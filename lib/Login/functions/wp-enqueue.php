<?php
function wbs_login_enqueue_scripts() {

    if (is_page_template('login.php')) {
        wp_enqueue_style('loginStyle', THEME_LIB . 'login/assets/scss/style.css');
        wp_enqueue_script('loginScript', THEME_LIB . 'login/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }



}
add_action( 'wp_enqueue_scripts', 'wbs_login_enqueue_scripts');