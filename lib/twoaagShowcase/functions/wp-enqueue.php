<?php
function wbs_twoaagShowcase_enqueue_scripts() {
    
    if (is_page_template('twoaagShowcase.php')) {
        wp_enqueue_style('twoaagShowcaseStyle', THEME_LIB . 'twoaagShowcase/assets/scss/style.css');
        wp_enqueue_script('twoaagShowcaseScript', THEME_LIB . 'twoaagShowcase/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_twoaagShowcase_enqueue_scripts');
