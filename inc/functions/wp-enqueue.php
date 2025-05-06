<?php
defined('ABSPATH') || exit;
add_action('wp_enqueue_scripts', 'wbs_enqueue_scripts');
function wbs_enqueue_scripts()
{
    require_once "globalEnqueue.php";

   if (is_page_template('login.php')) {
        require_once get_template_directory() . "/lib/Login/functions/wp-enqueue.php";
    }
    if (is_front_page() || is_home()) {
        wp_enqueue_script('slider', THEME_ASSETS . 'js/Modules/slider.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('carousel', THEME_ASSETS . 'js/Modules/carousel.js', array('jquery'), THEME_VERSION, true);
    }


    $items = [
        'AjaxUrl' => admin_url('admin-ajax.php'),
        'SecurityNonce' => wp_create_nonce("wbs_check_nonce"),
        'themeUrl' => get_template_directory_uri()
    ];

    wp_localize_script('script', 'wbs_script', $items); 
}
/*
add_action('admin_enqueue_scripts', 'wbs_admin_enqueue_scripts', 2000);
function wbs_admin_enqueue_scripts($hook)
{
    if (str_contains($hook, 'sanjeshgaran')) {
        wp_enqueue_style('bootstrap', THEME_CSS . 'bootstrap.rtl.min.css');
        wp_enqueue_style('icons', THEME_ASSETS . 'fonts/icons/style.css');
        wp_enqueue_style('icons', THEME_ASSETS . 'admin/scss/style.css');
        wp_enqueue_style('sweetalert2', THEME_ASSETS . 'plugins/sweetalert2/dist/sweetalert2.min.css');
        wp_enqueue_style('select2', THEME_ASSETS . 'plugins/select2/css/select2.min.css');

        wp_enqueue_script('sweetalert', THEME_ASSETS . 'plugins/sweetalert2/dist/sweetalert2.all.min.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('select2', THEME_ASSETS . 'plugins/select2/js/select2.full.min.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('select2fa', THEME_ASSETS . 'plugins/select2/js/i18n/fa.js', array('jquery', 'select2'), THEME_VERSION, true);

        require_once get_template_directory() . "/lib/EducationalGrade/functions/wp-enqueue.php";

        wp_enqueue_script('wbsAjax', THEME_ASSETS . 'js/Modules/wbsAjax.js', array('wbsEducationalGradeScript'), THEME_VERSION, true);
        wp_enqueue_script('wbsSelect2Ajax', THEME_ASSETS . 'js/Modules/wbsSelect2Ajax.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('loading', THEME_ASSETS . '/js/Modules/loading.js', array('wbsEducationalGradeScript'), THEME_VERSION, true);
        $items = [
            'AjaxUrl' => admin_url('admin-ajax.php'),
            'SecurityNonce' => wp_create_nonce("wbs_check_nonce"),
            'adminUrl' => get_admin_url()
        ];
        wp_localize_script('wbsEducationalGradeScript', 'wbs_script', $items);
    }

    if ($hook === 'user-new.php' || $hook === 'user-edit.php' || $hook === 'post-new.php' || $hook === 'post.php') {
        wp_enqueue_style('sweetalert2', THEME_ASSETS . 'plugins/sweetalert2/dist/sweetalert2.min.css');
        wp_enqueue_style('select2', THEME_ASSETS . 'plugins/select2/css/select2.min.css');
        wp_enqueue_script('select2', THEME_ASSETS . 'plugins/select2/js/select2.full.min.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('select2fa', THEME_ASSETS . 'plugins/select2/js/i18n/fa.js', array('jquery', 'select2'), THEME_VERSION, true);
        require_once get_template_directory() . "/lib/EducationalGrade/functions/wp-enqueue.php";
        wp_enqueue_script('wbsAjax', THEME_ASSETS . 'js/Modules/wbsAjax.js', array('jquery'), THEME_VERSION, true);
        wp_enqueue_script('wbsSelect2Ajax', THEME_ASSETS . 'js/Modules/wbsSelect2Ajax.js', array('jquery'), THEME_VERSION, true);
        $items = [
            'AjaxUrl' => admin_url('admin-ajax.php'),
            'SecurityNonce' => wp_create_nonce("wbs_check_nonce"),
            'adminUrl' => get_admin_url()
        ];
        wp_localize_script('wbsEducationalGradeScript', 'wbs_script', $items);
    }

    if ($hook === 'user-edit.php') {
        wp_enqueue_style('AdminStyle', THEME_ASSETS . 'admin/scss/style.css');
        wp_enqueue_script('script', THEME_ASSETS . 'admin/js/script.js', array('jquery'), THEME_VERSION, true);
    }
}
*/