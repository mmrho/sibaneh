<?php
defined('ABSPATH') || exit;

/**
 * AJAX handlers for TOC management: save and fetch.
 * All server-side helpers for inserting and validating the nested tree.
 */

add_action( 'wp_ajax_tableOfContents_get_toc', 'tableOfContents_ajax_get_toc' );
add_action( 'wp_ajax_tableOfContents_save_toc', 'tableOfContents_ajax_save_toc' );
add_action( 'wp_ajax_tableOfContents_create_new_content', 'tableOfContents_ajax_create_new_content' ); // جدید

/**
 * Return nested tree as JSON (admin use).
 */
function tableOfContents_ajax_get_toc() {
    if ( ! current_user_can( apply_filters( 'tableOfContents_manage_cap', 'manage_options' ) ) ) {
        wp_send_json_error( array('message' => 'Insufficient permissions') );
    }

    // تغییر: category رو از POST بگیریم
    $category = isset($_POST['category']) ? sanitize_key($_POST['category']) : '';

    // تغییر جدید: اگر خالی بود، پیش‌فرض ست کن و لاگ کن (بدون ارور)
    if (empty($category)) {
        $category = 'default';
        error_log('Category was empty in get_toc AJAX - POST data: ' . print_r($_POST, true));
    }

    // Ensure table exists
    if ( function_exists( 'tableOfContents_maybe_create_table' ) ) {
        tableOfContents_maybe_create_table();
    }

    $tree = tableOfContents_fetch_tree_from_db($category); // تغییر: category پاس می‌دیم

    wp_send_json_success( array( 'tree' => $tree ) );
}

/**
 * Save nested tree from admin. Expect POST param 'tree' as JSON array.
 */
function tableOfContents_ajax_save_toc() {
    if ( ! current_user_can( apply_filters( 'tableOfContents_manage_cap', 'manage_options' ) ) ) {
        wp_send_json_error( array('message' => 'Insufficient permissions') );
    }

    check_ajax_referer( 'tableOfContents_nonce', 'nonce' );

    if ( empty( $_POST['tree'] ) ) {
        wp_send_json_error( array('message' => 'Missing tree data') );
    }

    // تغییر: category رو از POST بگیریم
    $category = isset($_POST['category']) ? sanitize_key($_POST['category']) : '';

    // تغییر جدید: اگر خالی بود، پیش‌فرض ست کن و لاگ کن (بدون ارور)
    if (empty($category)) {
        $category = 'default';
        error_log('Category was empty in save_toc AJAX - POST data: ' . print_r($_POST, true));
    }

    $raw = wp_unslash( $_POST['tree'] );
    $data = json_decode( $raw, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        wp_send_json_error( array('message' => 'Invalid JSON payload') );
    }

    // Validate structure and post IDs
    $valid = tableOfContents_validate_tree( $data );
    if ( $valid !== true ) {
        wp_send_json_error( array('message' => 'Validation failed', 'errors' => $valid ) );
    }

    // Persist: we will TRUNCATE + insert DFS-style
    $res = tableOfContents_persist_tree( $data, $category ); // تغییر: category پاس می‌دیم

    if ( $res === true ) {
        // Clear cache if implemented
        if ( function_exists( 'tableOfContents_invalidate_cache' ) ) {
            tableOfContents_invalidate_cache();
        }
        wp_send_json_success( array('message' => 'TOC saved') );
    } else {
        wp_send_json_error( array('message' => 'Failed to save TOC') );
    }
}

/**
 * New: Create a new CPT post via AJAX.
 */
function tableOfContents_ajax_create_new_content() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        wp_send_json_error( array('message' => 'Insufficient permissions') );
    }

    check_ajax_referer( 'tableOfContents_nonce', 'nonce' );

    $title = sanitize_text_field( $_POST['title'] );
    if ( empty( $title ) ) {
        wp_send_json_error( array('message' => 'Missing title') );
    }

    $post_id = wp_insert_post( array(
        'post_title'    => $title,
        'post_type'     => 'sibaneh_content',
        'post_status'   => 'draft', // یا publish اگر بخوای
        'post_author'   => get_current_user_id(),
    ) );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array('message' => 'Failed to create content') );
    }

    wp_send_json_success( array( 'post_id' => $post_id, 'title' => $title ) );
}

/**
 * Validate incoming tree structure recursively.
 * Return true or array of error messages.
 */
function tableOfContents_validate_tree( $nodes, &$errors = array(), $path = '' ) {
    if ( ! is_array( $nodes ) ) {
        $errors[] = "$path : Node must be an array";
        return $errors;
    }

    foreach ( $nodes as $index => $n ) {
        $curpath = $path === '' ? (string)$index : $path . '.' . $index;

        if ( ! isset( $n['post_id'] ) || ! is_numeric( $n['post_id'] ) ) { // تغییر به post_id
            $errors[] = "$curpath: missing or invalid post_id";
            continue;
        }

        $post_id = intval( $n['post_id'] );
        $post = get_post( $post_id );
        if ( ! $post || $post->post_type !== 'sibaneh_content' ) { // تغییر به CPT
            $errors[] = "$curpath: post_id {$post_id} is not a valid sibaneh_content";
        }

        if ( isset( $n['children'] ) && ! is_array( $n['children'] ) ) {
            $errors[] = "$curpath: children must be array";
        } elseif ( isset( $n['children'] ) && is_array( $n['children'] ) ) {
            tableOfContents_validate_tree( $n['children'], $errors, $curpath );
        }
    }

    return empty( $errors ) ? true : $errors;
}

/**
 * Persist tree: TRUNCATE and insert DFS-style
 */
function tableOfContents_persist_tree( $nodes, $category = '' ) { // تغییر: پارامتر category اضافه شد
    global $wpdb;
    $table = tableOfContents_get_table_name();

    // Transaction-like behavior
    $wpdb->query( 'START TRANSACTION' );
    $ok = true;

    // Clear current table for this category
    $wpdb->delete( $table, array( 'category' => $category ) ); // تغییر: فقط ردیف‌های این category رو پاک می‌کنیم نه کل جدول

    // Recursive inserter
    $insert_stack = array();
    $pos = 0;

    $insert_node = function( $nodes, $parent_id = null ) use ( &$wpdb, $table, &$insert_node, &$ok, $category ) {
        $position = 0;
        foreach ( $nodes as $n ) {
            $post_id = intval( $n['post_id'] ); // تغییر به post_id
            // Use provided title or fallback to post title
            $title = isset( $n['title'] ) && $n['title'] !== '' ? sanitize_text_field( $n['title'] ) : get_the_title( $post_id );

            $result = $wpdb->insert(
                $table,
                array(
                    'parent_id'  => $parent_id,
                    'post_id'    => $post_id, // تغییر به post_id
                    'title'      => $title,
                    'category'   => $category, // تغییر: اضافه کردن category به هر ردیف
                    'sort_order' => $position,
                    'created_at' => current_time( 'mysql' ),
                    'updated_at' => current_time( 'mysql' ),
                ),
                array( '%d', '%d', '%s', '%s', '%d', '%s', '%s' ) // تغییر: فرمت برای category اضافه شد
            );

            if ( $result === false ) {
                $ok = false;
                return false;
            }

            $new_id = $wpdb->insert_id;

            if ( isset( $n['children'] ) && is_array( $n['children'] ) && ! empty( $n['children'] ) ) {
                $insert_node( $n['children'], $new_id );
                if ( ! $ok ) return false;
            }
            $position++;
        }
        return true;
    };

    $ok = $insert_node( $nodes, null );

    if ( $ok ) {
        $wpdb->query( 'COMMIT' );
        return true;
    } else {
        $wpdb->query( 'ROLLBACK' );
        return false;
    }
}

/**
 * Optional cache invalidation function
 */
function tableOfContents_invalidate_cache() {
    if ( wp_cache_get( 'tableOfContents_tree' ) ) {
        wp_cache_delete( 'tableOfContents_tree' );
    }
}

/**
 * Optional: get cached tree or fetch
 */
function tableOfContents_get_cached_tree() {
    $cached = wp_cache_get( 'tableOfContents_tree' );
    if ( $cached ) return $cached;

    $tree = tableOfContents_fetch_tree_from_db();
    wp_cache_set( 'tableOfContents_tree', $tree, '', DAY_IN_SECONDS );
    return $tree;
}