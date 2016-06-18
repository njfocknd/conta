
<?php
include ("nexthor_app.php");
function fncSetDataToArray($row, &$arrayData, $option)
{
	
	$i = count($arrayData[$row['agrupacion']]);
	$i += 1;
	
	$arrayData[$row['agrupacion']][$i]['nombre']= $row['nombre'];
	$arrayData[$row['agrupacion']][$i]['valor']= $row['valor'];
	$arrayData[$row['agrupacion']][$i]['interpretacion']= $row['interpretacion'];
}

function fncHTML($arrayData){

	$RazonesLiquidez = "";
	foreach ($arrayData['I'] as $key => $value) {
		$RazonesLiquidez .= sprintf("<tr>
										<td>%s</td>
										<td>%s %s</td>
									</tr>", $value['nombre'],$value['valor'],$value['interpretacion']);							
	}

	$RazonesApalancamiento="";
	foreach ($arrayData['II'] as $key => $value) {
		$RazonesApalancamiento .= sprintf("<tr>
												<td>%s</td>
												<td>%s %s</td>
											</tr>", $value['nombre'],$value['valor'],$value['interpretacion']);							
	}

	$RazonesRotacionActivos="";
	foreach ($arrayData['III'] as $key => $value) {
		$RazonesRotacionActivos .= sprintf("<tr>
												<td>%s</td>
												<td>%s %s</td>
											</tr>", $value['nombre'],$value['valor'],$value['interpretacion']);							
	}

	$RazonesRentabilidad="";
	foreach ($arrayData['IV'] as $key => $value) {
		$RazonesRentabilidad .= sprintf("<tr>
											<td>%s</td>
											<td>%s %s</td>
										</tr>", $value['nombre'],$value['valor'],$value['interpretacion']);							
	}

	echo "	<table style='width:100%;'>
				<tr valign='top' align='center'>
					<td style='width:49%;'>
						<div class='panel panel-success'>
							<div class='panel-heading'>Razones de liquidez o solvencia a corto plazo</div>
							<table class='table'>".$RazonesLiquidez."</table>
						</div>
					</td>
					<td style='width:2%;'></td>
					<td style='width:49%;'>
						<div class='panel panel-warning'>
							<div class='panel-heading'>Razones de apalancamiento financiera o solvencia a largo plazo</div>
							<table class='table'>".$RazonesApalancamiento."</table>
						</div>
					</td>
				</tr>
				<tr valign='top' align='center'>
					<td style='width:49%;'>
						<div class='panel panel-warning'>
							<div class='panel-heading'>Razones de actividad o rotacion de activos</div>
							<table class='table'>".$RazonesRotacionActivos."</table>
						</div>
					</td>
					<td style='width:2%;'></td>
					<td style='width:49%;'>
						<div class='panel panel-success'>
							<div class='panel-heading'>Razones de Rentabilidad</div>
							<table class='table'>".$RazonesRentabilidad."</table>
						</div>
					</td>
				</tr>
		 	</table>";	
}

if(true)
{
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	if (isset($_POST["empresa"])&&isset($_POST["periodoContable"]))
	{

		$MyOps->exec_proc("pr_razones_financieras", sprintf("%s,%s", $_POST['empresa'],$_POST['periodoContable']));

		$query=sprintf("select * from view_razones_financieras where idempresa=%s and idperiodo_contable=%s",$_POST['empresa'],$_POST['periodoContable']);

		fncExecuteQuery($MyOps, $query, $arrayData, 0);
		
		if (count($arrayData)>0){
			fncHTML($arrayData); 
		}else{
			echo "<script>alert('No existen datos para mostrar');</script>";
		}
	}
	else
	{
		include('nexthor/php/error.php'); 
	}
	unset($arrayData);
}
else
{
	include('nexthor/php/access_denied.php'); 
}
?>

