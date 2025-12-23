<?php


defined('ABSPATH') || exit;
require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";


function wbsLoadAppStoreProductDetail()
{
    require_once "template/AppStoreProductDetailPage.php";
}