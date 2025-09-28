<?php


defined('ABSPATH') || exit;
require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";


function wbsLoadAppShowcase()
{
    require_once "template/AppShowcasePage.php";
}