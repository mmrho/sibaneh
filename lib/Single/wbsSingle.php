<?php
defined('ABSPATH') || exit;
/*
 * Login And Register
 */

require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";


function wbsLoadSinglePage()
{
    require_once "template/singlePage.php";
}