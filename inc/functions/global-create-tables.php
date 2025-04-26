<?php
defined('ABSPATH') || exit;
/* ============================ Create Required Tables & Fields ============================ */
function wbs_sanjeshgaran_global_tables()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();

    $table_name = WPDBPREFIX . "wbs_files";
    $wbs_files = "CREATE TABLE $table_name (
        id BIGINT NOT NULL AUTO_INCREMENT,
        object varchar(20) NOT NULL,
        object_id BIGINT NOT NULL,
		name varchar(70) NOT NULL,
		dir varchar(255) NOT NULL,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME NULL,
		PRIMARY KEY (id)
	) $charset_collate";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($wbs_files);
}

add_action("after_switch_theme", "wbs_sanjeshgaran_global_tables");
