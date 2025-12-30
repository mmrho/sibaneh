<?php
function wbs_academyShowcase_enqueue_scripts() {
    
    if (is_page_template('academyShowcase.php')) {
        wp_enqueue_style('academyShowcaseStyle', THEME_LIB . 'academyShowcase/assets/scss/style.css');
        wp_enqueue_script('academyShowcaseScript', THEME_LIB . 'academyShowcase/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_academyShowcase_enqueue_scripts');
