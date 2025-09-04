<?php
defined('ABSPATH') || exit;

require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";
require_once "functions/create-tables.php";

// Counter to ensure unique instances
if (!isset($GLOBALS['toc_instance_counter'])) {
    $GLOBALS['toc_instance_counter'] = 0;
}

/**
 * Load the toc template
 * @param string $target CSS selector of the element that local-nav should align under
 */
function wbsLoadTableOfContents($target = '#site-header') {
    // Increment counter for unique instances
    $GLOBALS['toc_instance_counter']++;
    
    // Pass target and instance info to template
    $GLOBALS['toc_target'] = $target;
    $GLOBALS['toc_instance'] = $GLOBALS['toc_instance_counter'];
    
    require "template/tableOfContents-public.php";
}
