<?php
include('nexthor_app.php');
include('header.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$queryEmpresa="select idempresa id, ticker name from empresa where estado='Activo';";
$queryPeriodoContable="select idperiodo_contable id, concat(nombre,' (',estatus,')') name from periodo_contable where estado='Activo';";
?>
<script src="nexthor/my_js/gen_balance_general.js" type="text/javascript"></script>
<script src="nexthor/js/nexthor_js.js" type="text/javascript"></script>
<html lang="en-US">
<head>
	<title>Balance General</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html">
	<meta name="author" content="Romeo Muñoz">
	<link rel="shortcut icon" href="icon.ico">
	<link rel="icon" href="icon.ico">
</head>
<body>
	<div class="panel panel-info">
		<div class="panel-heading">
			<center>
				Balance General de
				<?php echo fncDesignCombo($queryEmpresa,'idempresa','','','',0);?>
				<?php echo " para el año ".fncDesignCombo($queryPeriodoContable,'idperiodo_contable','','','',0) ?>
				<button type="button" class="btn btn-info btn-sm" onclick="fncMostrar();">
					<span class="glyphicon glyphicon-search"> </span> Buscar
				</button>
			</center>
		</div>
		<div class="panel-body">
			<div class="container-fluid" id="divResultado"></div>
		</div>
	</div>
	<div class="container-fluid" id="divActualizar"></div>
</body>
</html>
<script>fncMostrar();</script>