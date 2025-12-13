<?php
/**
 * Disable WordPress Admin Bar and Restrict Admin Access for non-admin users
 */

// 1. Hide the black bar (Admin Bar) in the site's appearance
function wbs_disable_admin_bar_for_non_admins() {
   // If the user does not have administrative access (not an admin)
    if (!current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'wbs_disable_admin_bar_for_non_admins');

// 2. Prevent access to the WordPress dashboard (wp-admin)
function wbs_restrict_admin_access() {
    // If the request is related to the admin environment and is not Ajax and the user is not an admin
    if (is_admin() && !wp_doing_ajax() && !current_user_can('manage_options')) {
       // Redirect to the user's dedicated dashboard 
        $redirect = home_url('/userdashboard/');
        wp_redirect($redirect);
        exit;
    }
}

add_action('init', 'wbs_restrict_admin_access');