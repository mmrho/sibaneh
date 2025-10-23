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


if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}







// Enable categories and tags for pages
function wbs_enable_taxonomies_for_pages()
{
    register_taxonomy_for_object_type('category', 'page');
    register_taxonomy_for_object_type('post_tag', 'page');
}
add_action('init', 'wbs_enable_taxonomies_for_pages');

// Show category metabox in page editor
function wbs_add_category_metabox_to_pages()
{
    add_meta_box('categorydiv', __('Categories'), 'post_categories_meta_box', 'page', 'side', 'core');
}
add_action('admin_menu', 'wbs_add_category_metabox_to_pages');

// Show tag metabox in page editor
function wbs_add_tag_metabox_to_pages()
{
    add_meta_box('tagsdiv-post_tag', __('Tags'), 'post_tags_meta_box', 'page', 'side', 'core');
}
add_action('admin_menu', 'wbs_add_tag_metabox_to_pages');

// Modify category and tag archive queries to include pages
function wbs_include_pages_in_archives($query)
{
    if (!is_admin() && $query->is_main_query() && ($query->is_category() || $query->is_tag())) {
        $query->set('post_type', array('post', 'page'));
    }
}
add_action('pre_get_posts', 'wbs_include_pages_in_archives');





function replace_home_with_logo_in_breadcrumb($links)
{
    if (!empty($links) && isset($links[0])) {

        $logo_url = get_template_directory_uri() . '/images/temp/sibaneh-logo.png';
        $links[0]['text'] = '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . '" class="breadcrumb-logo">';
    }
    return $links;
}
add_filter('wpseo_breadcrumb_links', 'replace_home_with_logo_in_breadcrumb');
