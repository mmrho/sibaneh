<?php
function wbs_AppShowcase_enqueue_scripts() {
    
    if (is_single() || is_page_template('AppShowcase.php')) {
        wp_enqueue_style('AppShowcaseStyle', THEME_LIB . 'AppShowcase/assets/scss/style.css');
        wp_enqueue_script('AppShowcaseScript', THEME_LIB . 'AppShowcase/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_AppShowcase_enqueue_scripts');