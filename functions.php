<?php
global $wpdb;
define('WPDBPREFIX', $wpdb->prefix);
define('THEME_CLASS', get_template_directory() . '/class/');
define('THEME_LIB', get_template_directory_uri() . '/lib/');
define('THEME_MODULES', get_template_directory_uri() . '/modules/');
define('THEME_ASSETS', get_template_directory_uri() . '/assets/');
const THEME_VERSION = '2.3.8',
THEME_JS = THEME_ASSETS . 'js/',
THEME_CSS = THEME_ASSETS . 'css/';
define('THEME_IMG', get_template_directory_uri() . '/images/');
define('THEME_FUNCTIONS', get_template_directory() . '/inc/functions/');
define('THEME_TEMPLATE', get_template_directory() . '/inc/template/');
define('THEME_MODULES_DIR', get_template_directory() . '/modules/');
define('THEME_LIB_DIR', get_template_directory() . '/lib/');


add_theme_support('title-tag');

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
}
