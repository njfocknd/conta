<?php
include('nexthor_app.php');
include('header.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$queryEmpresa="select idempresa id, ticker name from empresa where estado='Activo';";
$queryPeriodoContable="select idperiodo_contable id, nombre name from periodo_contable where estado='Activo';";
?>
<script src="nexthor/js/nexthor_js.js" type="text/javascript"></script>
<script>
function fncMostrar()
{
	div=document.getElementById("divResultado");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	empresa=document.getElementById('idempresa').value;
	periodoContable=document.getElementById('idperiodo_contable').value;
	empresa2=document.getElementById('idempresa2').value;
	varianza=document.getElementById('varianza').value;
	periodoContable2=document.getElementById('idperiodo_contable2').value;
	strParam="varianza="+varianza+"&empresa="+empresa+"&periodoContable="+periodoContable+"&empresa2="+empresa2+"&periodoContable2="+periodoContable2+"&mostrarResultado=1";
	ajax_dynamic_div("POST",'rep_estado_resultado_get.php',strParam,div,'false');
}
</script>
<html lang="en-US">
<head>
	<title>Comparativo de Balance General</title>
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
				Análisis Horizontal del Estado de Resultado de
				<?php echo fncDesignCombo($queryEmpresa,'idempresa','','','',0);?>
				<?php echo " para el año ".fncDesignCombo($queryPeriodoContable,'idperiodo_contable','','','',1) ?>
				en comparación con 
				<?php echo fncDesignCombo($queryEmpresa,'idempresa2','','','',0);?>
				<?php echo " para el año ".fncDesignCombo($queryPeriodoContable,'idperiodo_contable2','','','',2) ?>
				al 
				<SELECT id="varianza" class='form-control' style = 'width:90px;'>
					<option value='1' > 1%</option>
					<option value='5' >5%</option>
					<option value='10' selected >10%</option>
					<option value='25' >25%</option>
					<option value='50' >50%</option>
					<option value='75' >75%</option>
					<option value='75' >100%</option>
				</SELECT>
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