<?php
defined('ABSPATH') || exit;

/**
 * AJAX handlers for TOC management: save and fetch.
 * All server-side helpers for inserting and validating the nested tree.
 */

add_action( 'wp_ajax_tableOfContents_get_toc', 'tableOfContents_ajax_get_toc' );
add_action( 'wp_ajax_tableOfContents_save_toc', 'tableOfContents_ajax_save_toc' );

/**
 * Return nested tree as JSON (admin use).
 */
function tableOfContents_ajax_get_toc() {
    if ( ! current_user_can( apply_filters( 'tableOfContents_manage_cap', 'manage_options' ) ) ) {
        wp_send_json_error( array('message' => 'Insufficient permissions') );
    }

    // Ensure table exists
    if ( function_exists( 'tableOfContents_maybe_create_table' ) ) {
        tableOfContents_maybe_create_table();
    }

    $tree = tableOfContents_fetch_tree_from_db();

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

    $raw = wp_unslash( $_POST['tree'] );
    $data = json_decode( $raw, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        wp_send_json_error( array('message' => 'Invalid JSON payload') );
    }

    // Validate structure and page IDs
    $valid = tableOfContents_validate_tree( $data );
    if ( $valid !== true ) {
        wp_send_json_error( array('message' => 'Validation failed', 'errors' => $valid ) );
    }

    // Persist: we will TRUNCATE + insert DFS-style
    $res = tableOfContents_persist_tree( $data );

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

        if ( ! isset( $n['page_id'] ) || ! is_numeric( $n['page_id'] ) ) {
            $errors[] = "$curpath: missing or invalid page_id";
            continue;
        }

        $page_id = intval( $n['page_id'] );
        $post = get_post( $page_id );
        if ( ! $post || $post->post_type !== 'page' ) {
            $errors[] = "$curpath: page_id {$page_id} is not a valid page";
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
function tableOfContents_persist_tree( $nodes ) {
    global $wpdb;
    $table = tableOfContents_get_table_name();

    // Transaction-like behavior
    $wpdb->query( 'START TRANSACTION' );
    $ok = true;

    // Clear current table
    $wpdb->query( "TRUNCATE TABLE {$table}" );

    // Recursive inserter
    $insert_stack = array();
    $pos = 0;

    $insert_node = function( $nodes, $parent_id = null ) use ( &$wpdb, $table, &$insert_node, &$ok ) {
        $position = 0;
        foreach ( $nodes as $n ) {
            $page_id = intval( $n['page_id'] );
            // Use provided title or fallback to page title
            $title = isset( $n['title'] ) && $n['title'] !== '' ? sanitize_text_field( $n['title'] ) : get_the_title( $page_id );

            $result = $wpdb->insert(
                $table,
                array(
                    'parent_id'  => $parent_id,
                    'page_id'    => $page_id,
                    'title'      => $title,
                    'sort_order' => $position,
                    'created_at' => current_time( 'mysql' ),
                    'updated_at' => current_time( 'mysql' ),
                ),
                array( '%d', '%d', '%s', '%d', '%s', '%s' )
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

