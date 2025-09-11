<?php
defined('ABSPATH') || exit;

/**
 * Enqueue CSS and JS for tableOfContents
 * Assets will be loaded before any HTML output
 */
function wbs_tableOfContents_enqueue_assets() {
    static $registered = false; // Prevent multiple enqueue
    if ($registered) return;

    wp_enqueue_style(
        'tableOfContentsStyle',
        THEME_LIB . 'tableOfContents/assets/scss/style.css',
        array(),
        THEME_VERSION
    );

    wp_enqueue_script(
        'tableOfContentsScript',
        THEME_LIB . 'tableOfContents/assets/js/script.js',
        array('jquery'),
        THEME_VERSION,
        true
    );

    $registered = true;
}
add_action('wp_enqueue_scripts', 'wbs_tableOfContents_enqueue_assets');

/*
 * Enqueue scripts & styles for admin and frontend specific to tableOfContents module.
 */

// Admin assets for TOC manager
add_action( 'admin_enqueue_scripts', 'tableOfContents_admin_enqueue' );
function tableOfContents_admin_enqueue( $hook ) {
    // Only load on our TOC manager page slug
    $screen = get_current_screen();
    if ( ! $screen ) return;

    // The submenu slug we added is 'tableOfContents-manager'
    if ( strpos( $screen->id, 'hubOfTheWorldOfApplicationsAndGames' ) === false ) {
        return;
    }

    // jsTree (already present in module)
   
    wp_enqueue_script(
        'jstree',
        THEME_LIB . 'tableOfContents/assets/js/modules/jstree.min.js',
        array('jquery'),
        THEME_VERSION,
        true
    );
    // Admin module script

    wp_enqueue_script(
        'tableOfContents-script-admin',
        THEME_LIB . 'tableOfContents/assets/js/script-admin.js',
        array('jquery'),
        THEME_VERSION,
        true
    );
    // Admin style
   
    wp_enqueue_style(
        'tableOfContents-admin-style',
        THEME_LIB . 'tableOfContents/assets/scss/style-admin.css',
        array(),
        THEME_VERSION
    );
    // Localize: ajax URL, nonce (posts removed)
    wp_localize_script( 'tableOfContents-script-admin', 'toc_data', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'tableOfContents_nonce' ),
    ) );
}
