<?php
defined('ABSPATH') || exit;
/*
 * Login And Register
 */

require_once "functions/wp-enqueue.php";
require_once "functions/create-tables.php";
require_once "functions/ajax.php";


function wbsLoadLoginForm()
{
    require_once "template/loginForm.php";
}