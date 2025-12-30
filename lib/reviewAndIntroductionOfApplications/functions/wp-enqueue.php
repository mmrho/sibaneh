<?php
function wbs_reviewAndIntroductionOfApplications_enqueue_scripts() {
    
    if (is_page_template('reviewAndIntroductionOfApplications.php')) {
        wp_enqueue_style('reviewAndIntroductionOfApplicationsStyle', THEME_LIB . 'reviewAndIntroductionOfApplications/assets/scss/style.css');
        wp_enqueue_script('reviewAndIntroductionOfApplicationsScript', THEME_LIB . 'reviewAndIntroductionOfApplications/assets/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'wbs_reviewAndIntroductionOfApplications_enqueue_scripts');
