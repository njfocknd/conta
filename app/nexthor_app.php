<?php
session_start(); 
ob_start(); 
date_default_timezone_set("America/Guatemala");
error_reporting(0);
include "ewcfg12.php";
include "phpfn12.php";
include "userfn12.php";
header("Cache-Control: private, no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
include "nexthor/php/app_db_config.php";
include('nexthor/php/function.php');
require_once('nexthor/php/dbops.php'); 

?>
