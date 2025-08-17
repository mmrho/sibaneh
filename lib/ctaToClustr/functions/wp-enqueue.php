<?php
defined('ABSPATH') || exit;

/**
 * Enqueue CSS and JS for CTA To Clustr
 * Assets will be loaded before any HTML output
 */
function wbs_ctaToClustr_enqueue_assets() {
    static $registered = false; // Prevent multiple enqueue
    if ($registered) return;

    wp_enqueue_style(
        'ctaToClustrStyle',
        THEME_LIB . 'ctaToClustr/assets/scss/style.css',
        array(),
        THEME_VERSION
    );

    wp_enqueue_script(
        'ctaToClustrScript',
        THEME_LIB . 'ctaToClustr/assets/js/script.js',
        array('jquery'),
        THEME_VERSION,
        true
    );

    $registered = true;
}
add_action('wp_enqueue_scripts', 'wbs_ctaToClustr_enqueue_assets');





add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'ctaToClustrStyle',
        THEME_LIB . 'ctaToClustr/assets/scss/style.css',
        array(),
        THEME_VERSION
    );

    wp_enqueue_script(
        'ctaToClustrScript',
        THEME_LIB . 'ctaToClustr/assets/js/script.js',
        array('jquery'),
        THEME_VERSION,
        true
    );
});
