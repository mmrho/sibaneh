<?php
/* EducationHub */

defined('ABSPATH') || exit;


require_once "functions/wp-enqueue.php";
require_once "functions/ajax.php";


function wbsLoadEducationHub()
{
    require_once "template/EducationHub.php";
}