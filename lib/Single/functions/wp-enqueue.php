<?php
function wbs_single_enqueue_scripts() {

    if (is_page_template('single.php')) {
        wp_enqueue_style('singleStyle', THEME_LIB . 'single/assets/scss/style.css');
        wp_enqueue_script('singleScript', THEME_LIB . 'single/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }



}
add_action( 'wp_enqueue_scripts', 'wbs_single_enqueue_scripts');