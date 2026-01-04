<?php
function wbs_cas_app_training_enqueue_scripts() {
    
    if (is_page_template('cas-app-training.php')) {
        wp_enqueue_style('cas-app-training-style', THEME_LIB . 'cas-app-training/assets/scss/style.css');
        wp_enqueue_script('cas-app-training-script', THEME_LIB . 'cas-app-training/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_cas_app_training_enqueue_scripts');
