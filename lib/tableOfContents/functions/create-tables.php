<?php
defined('ABSPATH') || exit;

/**
 * Create DB table for TOC manager
 * This file is theme/module-level: call site_toc_maybe_create_table() on init/load.
 */

global $cta_cto_table_loaded;
$cta_cto_table_loaded = true;

/**
 * Create or update the toc table using dbDelta.
 * Call this on admin_init or theme setup. Safe to rerun.
 */
function tableOfContents_maybe_create_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'tableOfContents';
    $charset_collate = $wpdb->get_charset_collate();

    // We will store a schema version to avoid unnecessary calls.
    $option_name = 'tableOfContents_db_version';
    $db_version = get_option( $option_name, '' );
    $current_version = '1.0';

    if ( $db_version === $current_version ) {
        return;
    }

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

    $sql = "CREATE TABLE {$table_name} (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        parent_id BIGINT UNSIGNED NULL,
        page_id BIGINT UNSIGNED NOT NULL,
        title VARCHAR(255) NOT NULL,
        sort_order INT NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id),
        KEY parent_id (parent_id),
        KEY page_id (page_id),
        KEY sort_order (sort_order)
    ) {$charset_collate};";

    dbDelta( $sql );

    update_option( $option_name, $current_version );
}

/**
 * Helper: get table name.
 */
function tableOfContents_get_table_name() {
    global $wpdb;
    return $wpdb->prefix . 'tableOfContents';
}

/**
 * Helper: fetch all rows and build nested tree (single query).
 * Returns array of nested nodes:
 * [
 *  ['id'=>row_id, 'page_id'=>..., 'title'=>..., 'children'=>[...]],
 *  ...
 * ]
 */
function tableOfContents_fetch_tree_from_db() {
    global $wpdb;
    $table = tableOfContents_get_table_name();

    $rows = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY parent_id ASC, sort_order ASC, id ASC", ARRAY_A );

    if ( empty($rows) ) return [];

    // Build map of id => node
    $map = [];
    foreach ( $rows as $r ) {
        $map[ $r['id'] ] = [
            'db_id'    => (int) $r['id'],
            'parent_id'=> $r['parent_id'] ? (int) $r['parent_id'] : null,
            'page_id'  => (int) $r['page_id'],
            'title'    => $r['title'],
            'children' => [],
        ];
    }

    // Build tree
    $tree = [];
    foreach ( $map as $id => &$node ) {
        if ( $node['parent_id'] && isset( $map[ $node['parent_id'] ] ) ) {
            $map[ $node['parent_id'] ]['children'][] = &$node;
        } else {
            $tree[] = &$node;
        }
    }
    unset($node);

    return $tree;
}

