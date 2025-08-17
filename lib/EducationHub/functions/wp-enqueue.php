<?php
function wbs_educationHub_enqueue_scripts() {
    
    if (is_single() || is_page_template('EducationHub.php')) {
        wp_enqueue_style('educationHubStyle', THEME_LIB . 'EducationHub/assets/scss/style.css');
        wp_enqueue_script('educationHubScript', THEME_LIB . 'EducationHub/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_educationHub_enqueue_scripts');