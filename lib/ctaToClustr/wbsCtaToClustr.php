<?php
defined('ABSPATH') || exit;

require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";

// Counter to ensure unique instances
if (!isset($GLOBALS['cta_instance_counter'])) {
    $GLOBALS['cta_instance_counter'] = 0;
}

/**
 * Load the CTA To Clustr template
 * @param string $target CSS selector of the element that local-nav should align under
 */
function wbsLoadCtaToClustr($target = '#site-header') {
    // Increment counter for unique instances
    $GLOBALS['cta_instance_counter']++;
    
    // Pass target and instance info to template
    $GLOBALS['cta_target'] = $target;
    $GLOBALS['cta_instance'] = $GLOBALS['cta_instance_counter'];
    
    require "template/ctaToClustr.php";
}
