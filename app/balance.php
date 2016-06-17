<?php
session_start(); 
ob_start(); 
date_default_timezone_set("America/Guatemala");
error_reporting(0);
header("Cache-Control: private, no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
include "ewcfg12.php";
include "phpfn12.php";
include "userfn12.php";
include "header.php";
include ("nexthor/php/app_db_config.php");
require_once('nexthor/php/dbops.php');
require_once('nexthor/php/function.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$queryEmpresa="select idempresa id, ticker name from empresa where estado='Activo';";
$queryPeriodoContable="select idperiodo_contable id, nombre name from periodo_contable where estado='Activo';";

?>

<html lang="en-US">
	<head>
		<title>Balance General</title>
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html">
		<meta name="author" content="Romeo Muñoz">
		<link rel="shortcut icon" href="icon.ico">
		<link rel="icon" href="icon.ico">
		<script src="nexthor/my_js/balance.js" type="text/javascript"></script>
		<script src="nexthor/js/nexthor_js.js" type="text/javascript"></script>
	</head>

	<body>
		<div class="panel panel-info">
			<div class="panel-heading">
				<?php echo "Empresa ".fncDesignCombo($queryEmpresa,'idempresa','','','',0)." Periodo Contable ".fncDesignCombo($queryPeriodoContable,'idperiodo_contable','','','',0) ?>
				<button type="button" class="btn btn-info btn-sm" onclick="fncMostrarBalance();">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</div>
		 	<div class="panel-body">
				<div class="container-fluid" id="divBalance">
		  			
				</div>
		  	</div>
			<div class="panel-footer" id="divUpdate">Balance General</div>
		</div>
	</body>
</html>
<script>fncMostrarBalance();</script>