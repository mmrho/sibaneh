<?php
function wbs_comprehensiveAppleTutorials_enqueue_scripts() {
    
    if (is_single() || is_page_template('comprehensiveAppleTutorials.php')) {
        wp_enqueue_style('comprehensiveAppleTutorialsStyle', THEME_LIB . 'comprehensiveAppleTutorials/assets/scss/style.css');
        wp_enqueue_script('comprehensiveAppleTutorialsScript', THEME_LIB . 'comprehensiveAppleTutorials/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_comprehensiveAppleTutorials_enqueue_scripts');
