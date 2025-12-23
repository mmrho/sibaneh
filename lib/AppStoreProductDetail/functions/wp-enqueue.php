<?php
function wbs_AppStoreProductDetail_enqueue_scripts() {
    
    if (is_single() || is_page_template('AppStoreProductDetail.php')) {
        wp_enqueue_style('AppStoreProductDetailStyle', THEME_LIB . 'AppStoreProductDetail/assets/scss/style.css');
        wp_enqueue_script('AppStoreProductDetailScript', THEME_LIB . 'AppStoreProductDetail/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_AppStoreProductDetail_enqueue_scripts');







// Enable Aparat embed support in WordPress
function aparat_oembed_support() {
    wp_oembed_add_provider(
        '#https?://(www\.)?aparat\.com/v/.*#i',
        'https://www.aparat.com/oembed',
        true
    );
}
add_action('init', 'aparat_oembed_support');
