<?php
wp_enqueue_style('bootstrap', THEME_CSS . 'bootstrap.rtl.min.css');
//wp_enqueue_style('swiper', THEME_CSS . 'swiper-bundle.min.css');
wp_enqueue_style('sweetalert2', THEME_ASSETS . 'plugins/sweetalert2/dist/sweetalert2.min.css');
wp_enqueue_style('icons', THEME_ASSETS . 'fonts/icons/style.css');
wp_enqueue_style('style', get_stylesheet_uri(), [], THEME_VERSION);

wp_deregister_script('jquery');
wp_register_script('jquery', THEME_JS . 'jquery-3.6.0.min.js', false, NULL, true);
wp_enqueue_script('jquery');


wp_enqueue_script('swiper', THEME_JS . 'swiper-bundle.min.js', array('jquery'), THEME_VERSION, true);
wp_enqueue_script('sweetalert', THEME_ASSETS . 'plugins/sweetalert2/dist/sweetalert2.all.min.js', array('jquery'), THEME_VERSION, true);
wp_enqueue_script('script', THEME_JS . 'script.js', array('jquery'), THEME_VERSION, true);
wp_enqueue_script('loading', THEME_ASSETS . 'js/Modules/loading.js', array('script'), THEME_VERSION, true);
wp_enqueue_script('wbsChangeUrl', THEME_ASSETS . 'js/Modules/wbsChangeUrl.js', array('script'), THEME_VERSION, true);
wp_enqueue_script('wbsAjax', THEME_ASSETS . 'js/Modules/wbsAjax.js', array('script'), THEME_VERSION, true);
wp_enqueue_script('header', THEME_ASSETS . 'js/header.js', array('script'), THEME_VERSION, true);
/*
    wp_enqueue_script('popup', THEME_ASSETS . 'js/modules/popup.js', array('script'), THEME_VERSION, true);
    wp_enqueue_script('alert', THEME_ASSETS . 'js/modules/alert.js', array('script'), THEME_VERSION, true);*/