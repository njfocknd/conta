
<?php
include ("nexthor_app.php");
function fncSetDataToArray($row, &$arrayData, $option)
{
	switch($option)
	{
		case 0:
			$arrayData["idestado_resultado"]=$row["idestado_resultado"];
			$arrayData["cuenta"]=$row["cuenta"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["monto"]=0;
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["nombre"]=$row["clase_resultado"];
			break;
		case 1:
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["id"]=$row["idestado_resultado_detalle"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["monto"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["nombre"]=$row["grupo_resultado"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["monto"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["nombre"]=$row["clase_resultado"];
			break;
	}
}
?>
	<link rel="stylesheet" href="style.css" type="text/css">
    <script src="nexthor/libs/amcharts/amcharts.js" type="text/javascript"></script>
	<script src="nexthor/libs/amcharts/funnel.js" type="text/javascript"></script>
<?php
function fncGrafica(&$arrayData){
	$utilidad_antes = ($arrayData['clase_resultado'][1]['monto']-($arrayData['clase_resultado'][3]["monto"]+$arrayData['clase_resultado'][2]["monto"]));
	$utilidad_gravable=$utilidad_antes-$arrayData['clase_resultado'][4]["monto"];
	$utilidad_neta=$utilidad_gravable-$arrayData['clase_resultado'][5]["monto"];
	
	echo '<script>

            var chart;
            var data = [
                
                {
                    "title": "'.$arrayData['clase_resultado'][2]['nombre'].'",
                    "value": '.round((($arrayData['clase_resultado'][2]['monto']/$arrayData['clase_resultado'][1]['monto'])*100),2).'
                },
                {
                    "title": "'.$arrayData['clase_resultado'][3]['nombre'].'",
                    "value": '.round((($arrayData['clase_resultado'][3]['monto']/$arrayData['clase_resultado'][1]['monto'])*100),2).'
                },
				{
                    "title": "'.$arrayData['clase_resultado'][4]['nombre'].'",
                    "value": '.round((($arrayData['clase_resultado'][4]['monto']/$arrayData['clase_resultado'][1]['monto'])*100),2).'
                },
				{
                    "title": "'.$arrayData['clase_resultado'][5]['nombre'].'",
                    "value": '.round((($arrayData['clase_resultado'][5]['monto']/$arrayData['clase_resultado'][1]['monto'])*100),2).'
                },
				{
                    "title": "Utilidad neta",
                    "value": '.round((($utilidad_neta/$arrayData['clase_resultado'][1]['monto'])*100),2).'
                },
			];</script>';
?><script>
            AmCharts.ready(function () {

                chart = new AmCharts.AmFunnelChart();
                chart.rotate = false;
                chart.titleField = "title";
                chart.balloon.fixedPosition = true;
                chart.marginRight = 210;
                chart.marginLeft = 15;
                chart.labelPosition = "right";
                chart.funnelAlpha = 0.9;
                chart.valueField = "value";
                chart.startX = -500;
                chart.dataProvider = data;
                chart.startAlpha = 0;
                chart.depth3D = 100;
                chart.angle = 30;
                chart.outlineAlpha = 1;
                chart.outlineThickness = 2;
                chart.outlineColor = "#FFFFFF";
                chart.write("chartdiv");
            });
        </script>
<?php
	
}
function fncHTML($arrayData){
	$utilidad_antes = ($arrayData['clase_resultado'][1]['monto']-($arrayData['clase_resultado'][3]["monto"]+$arrayData['clase_resultado'][2]["monto"]));
	$utilidad_gravable=$utilidad_antes-$arrayData['clase_resultado'][4]["monto"];
	$utilidad_neta=$utilidad_gravable-$arrayData['clase_resultado'][5]["monto"];
	$query = "select gr.idgrupo_resultado id, concat(cr.nombre,' <- ',gr.nombre) name 
				from grupo_resultado gr
				inner join clase_resultado cr on cr.idclase_resultado = gr.idclase_resultado
				where  gr.estado =1 and gr.idgrupo_resultado not in(select idgrupo_resultado from estado_resultado_detalle where idestado_resultado = ".$arrayData["idestado_resultado"]." and estado = 1 )
				order by cr.idclase_resultado,gr.idgrupo_resultado;";
	echo "<center><table style='width:100%;'>
			<tr valign='top' align = 'center'>
				<td style='width:65%;'>
					<div class='panel panel-success'>
						<table class='table' >
							<tr class='success'>
								<td  colspan = 4><b>".$arrayData['clase_resultado'][1]['nombre']."</b></td>
							</tr>";
	foreach ($arrayData['clase_resultado'][1]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td></td>
								<td colspan = 2>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	echo "					<tr class='warning'>
								<td  colspan = 4><b>".$arrayData['clase_resultado'][2]['nombre']."</b></td>
							</tr>";
	foreach ($arrayData['clase_resultado'][2]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td></td>
								<td colspan = 2>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	echo "					<tr class='warning'>
								<td colspan = 4><b>".$arrayData['clase_resultado'][3]['nombre']."</b></td>
							</tr>";
	foreach ($arrayData['clase_resultado'][3]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td></td>
								<td colspan = 2>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	echo "					
							<tr class='danger'>
								<td colspan = 3><em><b>Utilidades antes de intereses e impuestos</td>
								<td><b><input type='text' value='".number_format($utilidad_antes,0)."' style='text-align: right' size='8'  class='form-control' readonly/></b></td>
							</tr>
							<tr class='warning'>
								<td colspan = 4><b>".$arrayData['clase_resultado'][4]['nombre']."</b></td>
							</tr>";
	foreach ($arrayData['clase_resultado'][4]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td></td>
								<td colspan = 2>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	echo "					
							<tr class='danger'>
								<td  colspan = 2><em><b>Utilidad gravable</td>
								<td></td>
								<td><b><input type='text' value='".number_format($utilidad_gravable,0)."' style='text-align: right' size='8'  class='form-control' readonly/></b></td>
							</tr>
							<tr class='warning'>
								<td  colspan = 4><b>".$arrayData['clase_resultado'][5]['nombre']."</b></td>
							</tr>";
	foreach ($arrayData['clase_resultado'][5]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td></td>
								<td colspan = 2>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	echo "					<tr class='success'>
								<td  colspan = 2><em><b>Utilidad neta</td>
								<td></td>
								<td><b><input type='text' value='".number_format($utilidad_neta,0)."' style='text-align: right' size='8'  class='form-control' readonly/></b></td>
							</tr>
							
						</table>
					</div>	
				</td>
				<td style='width:3%;'>
				</td>
				<td  style='width:32%;'>";
	if ($arrayData["cuenta"] >0){
		echo "		<div class='panel panel-success'>
						<div class='panel-heading'>Agregar detalle al Estado de Resultado</div>
						<table class='table' >
							<tr>
								<td>".fncDesignCombo($query,'cuenta','onchange="fncCambiarCuenta('.$arrayData['idestado_resultado'].',this.value)"','<option value = 0></option>','',0)."</td>
								<td><input type='text' id = 'monto' value='0' style='text-align: right' size='8'  class='form-control' onchange='fncAgregarCuenta(".$arrayData['idestado_resultado'].",this.value);' /></td>
							</tr>
						</table>
					</div>";
	}
					
	echo "			<div id='chartdiv' style='width: 700px; height: 500px;'></div>
				</td>
			</tr>
		  </table></center>";
}

if(true)
{
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	if (isset($_POST["empresa"])&&isset($_POST["periodoContable"])&&isset($_POST["mostrarResultado"]))
	{
		$query="select er.idestado_resultado,  cr.idclase_resultado, cr.nombre clase_resultado, 
					gr.idgrupo_resultado, gr.nombre grupo_resultado, (select count(*)
				from grupo_resultado gr2
				inner join clase_resultado cr2 on cr2.idclase_resultado = gr2.idclase_resultado
				where  gr2.estado =1 and gr2.idgrupo_resultado not in(select idgrupo_resultado from estado_resultado_detalle where idestado_resultado = er.idestado_resultado and estado = 1 )) cuenta
				from estado_resultado er, clase_resultado cr, grupo_resultado gr
				where er.idempresa = ".$_POST['empresa']." and er.idperiodo_contable = ".$_POST['periodoContable']."  and er.estado ='Activo' 
				and cr.idclase_resultado = gr.idclase_resultado and gr.estado ='Activo' and cr.estado ='Activo' 
				order by cr.idclase_resultado, gr.idgrupo_resultado ;";
		fncExecuteQuery($MyOps, $query, $arrayData, 0);
		if(!count($arrayData)>0){
			$query = " INSERT INTO estado_resultado (idempresa,idperiodo_contable) 
						VALUES (".$_POST["empresa"].",".$_POST["periodoContable"].");";
			$MyOps->insert_to_db($query);
			echo "<script>fncMostrar();</script>";
		}
		else{
			$query="select idestado_resultado_detalle, cr.idclase_resultado, cr.nombre clase_resultado, gr.idgrupo_resultado, gr.nombre grupo_resultado, monto
					from estado_resultado_detalle  erd
					inner join clase_resultado cr on cr.idclase_resultado = erd.idclase_resultado
					inner join grupo_resultado gr on gr.idgrupo_resultado = erd.idgrupo_resultado
					where erd.estado = 1 and erd.idestado_resultado = ".$arrayData['idestado_resultado']."
					order by cr.idclase_resultado, gr.idgrupo_resultado;";
			fncExecuteQuery($MyOps, $query, $arrayData, 1);
			fncHTML($arrayData);
			fncGrafica($arrayData);	
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

