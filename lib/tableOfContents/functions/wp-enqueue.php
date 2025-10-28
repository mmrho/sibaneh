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

    // تغییر جدید: strtolower برای مطابقت بهتر
    $screen_id = strtolower($screen->id);

    // تغییر جدید: لاگ screen_id برای دیباگ (در error_log ببین)
    error_log('Screen ID in enqueue: ' . $screen_id);

    // The submenu slug we added is 'tableOfContents-manager'
    if (
        strpos($screen_id, 'huboftheworldofapplicationsandgames') === false && // تغییر جدید: فقط بخش slug lowercase
        strpos($screen_id, 'comprehensiveappletutorials') === false &&
        strpos($screen_id, 'newsandanalysis') === false
    ) {
        error_log('Screen ID not matched any slug!'); // تغییر جدید: لاگ اگر شرط true باشه
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
    $category = ''; // تغییر: category رو بر اساس screen ID localize کنیم
    if (strpos($screen_id, 'huboftheworldofapplicationsandgames') !== false) {
        $category = 'apps_games';
    } elseif (strpos($screen_id, 'comprehensiveappletutorials') !== false) {
        $category = 'apple_tutorials';
    } elseif (strpos($screen_id, 'newsandanalysis') !== false) {
        $category = 'news_analysis';
    }

    // تغییر جدید: اگر خالی بود، پیش‌فرض
    if (empty($category)) {
        $category = 'default';
        error_log('Category was empty in enqueue - screen ID: ' . $screen->id);
    }

    wp_localize_script( 'tableOfContents-script-admin', 'toc_data', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'tableOfContents_nonce' ),
        'category' => $category, // تغییر: اضافه کردن category به localize
    ) );
}