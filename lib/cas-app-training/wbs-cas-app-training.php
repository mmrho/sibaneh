<?php


defined('ABSPATH') || exit;
require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";


function wbsLoadCasAppTraining()
{
    require_once "template/cas-app-training-page.php";
}