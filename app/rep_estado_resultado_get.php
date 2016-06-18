
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
			$arrayData["idestado_resultado2"]=$row["idestado_resultado"];
			break;
		case 2:
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["id"]=$row["idestado_resultado_detalle"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["monto"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["nombre"]=$row["grupo_resultado"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["monto"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["nombre"]=$row["clase_resultado"];
			break;
		case 3:
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["id"]=$row["idestado_resultado_detalle"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["monto2"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["grupo_resultado"][$row["idgrupo_resultado"]]["nombre"]=$row["grupo_resultado"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["monto2"]+=$row["monto"];
			$arrayData['clase_resultado'][$row["idclase_resultado"]]["nombre"]=$row["clase_resultado"];
			break;
	}
}
function fncComparar($monto,$monto2,$tendencia){
	$respuesta['diferencia'] = $monto - $monto2;
	$respuesta['varianza'] = round(($respuesta['diferencia']/$monto)*100,2);
	$respuesta['clase'] = "";
	if($respuesta['varianza']>0){
		if ($respuesta['varianza']>$_POST['varianza']){
			if ($tendencia =='Positiva'){
				$respuesta['clase'] = " class='success' ";
			}
			else{
				$respuesta['clase'] = " class='danger' ";
			}
		}
	}
	else if($respuesta['varianza']<0){
		if ($respuesta['varianza']<($_POST['varianza']*-1)){
			if ($tendencia =='Positiva'){
				$respuesta['clase'] = " class='danger' ";
			}
			else{
				$respuesta['clase'] = " class='success' ";
			}
		}
	}
	return $respuesta;
}

function fncCompararTodo(&$arrayData){
	foreach ($arrayData['clase_resultado'] as $key => $value) 
	{
		$arrayComparar = fncComparar($value['monto'],$value['monto2'],'Positiva');
			
		$arrayData['clase_resultado'][$key]['clase'] = $arrayComparar['clase'];
		$arrayData['clase_resultado'][$key]['varianza'] = $arrayComparar['varianza'];
		$arrayData['clase_resultado'][$key]['diferencia'] = $arrayComparar['diferencia'];
		foreach ($value['grupo_resultado'] as $key2 => $value2) 
		{
			$arrayComparar = fncComparar($value2['monto'],$value2['monto2'],'Positiva');
			$arrayData['clase_resultado'][$key]['grupo_resultado'][$key2]['clase'] = $arrayComparar['clase'];
			$arrayData['clase_resultado'][$key]['grupo_resultado'][$key2]['varianza'] = $arrayComparar['varianza'];
			$arrayData['clase_resultado'][$key]['grupo_resultado'][$key2]['diferencia'] = $arrayComparar['diferencia'];
		}
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
	$utilidad_antes2 = ($arrayData['clase_resultado'][1]['monto2']-($arrayData['clase_resultado'][3]["monto2"]+$arrayData['clase_resultado'][2]["monto2"]));
	$utilidad_gravable2=$utilidad_antes2-$arrayData['clase_resultado'][4]["monto2"];
	$utilidad_neta2=$utilidad_gravable2-$arrayData['clase_resultado'][5]["monto2"];
	echo "<center><table style='width:100%;'>
			<tr valign='top' align = 'center'>
				<td style='width:75%;'>
					<div class='panel panel-success'>
						<table class='table  table-bordered' >
							<tr class='active'>
								<th>Grupo</th>
								<th>Cuenta</th>
								<th>Estado de Resultado Principal</th>
								<th>Estado de Resultado Referencia</th>
								<th>Diferencia</th>
								<th>Varianción</th>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_resultado'][1]['nombre']."</b></em>";
	foreach ($arrayData['clase_resultado'][1]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	$encabezado = "<em><b>".$arrayData['clase_resultado'][2]['nombre']."</b></em>";
	foreach ($arrayData['clase_resultado'][2]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	$encabezado = "<em><b>".$arrayData['clase_resultado'][3]['nombre']."</b></em>";
	foreach ($arrayData['clase_resultado'][3]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	
	$arrayComparar = fncComparar($utilidad_antes,$utilidad_antes2,'Positiva');
	echo "					
							<tr >
								<td colspan = 2 class='warning'><em><b>Utilidades antes de intereses e impuestos</td>
								<td align = 'right' class='warning'><b>".number_format($utilidad_antes,0)."</b></td>
								<td align = 'right' class='warning'><b>".number_format($utilidad_antes2,0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["diferencia"],0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["varianza"],0)." %</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_resultado'][4]['nombre']."</b></em>";
	foreach ($arrayData['clase_resultado'][4]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	$arrayComparar = fncComparar($utilidad_gravable,$utilidad_gravable2,'Positiva');
	echo "					
							<tr>
								<td  colspan = 2  class='danger'><em><b>Utilidad gravable</td>
								<td align = 'right' class='danger'><b>".number_format($utilidad_gravable,0)."</b></td>
								<td align = 'right' class='danger'><b>".number_format($utilidad_gravable2,0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["diferencia"],0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["varianza"],0)." %</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_resultado'][5]['nombre']."</b></em>";
	foreach ($arrayData['clase_resultado'][5]["grupo_resultado"]as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	$arrayComparar = fncComparar($utilidad_gravable,$utilidad_gravable2,'Positiva');
	
	echo "					<tr>
								<td  colspan = 2 class='success'><em><b>Utilidad neta</td>
								<td align = 'right' class='success'><b>".number_format($utilidad_neta,0)."</b></td>
								<td align = 'right' class='success'><b>".number_format($utilidad_neta2,0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["diferencia"],0)."</b></td>
								<td align = 'right' ".$arrayComparar["clase"]."><b>".number_format($arrayComparar["varianza"],0)." %</b></td>
							</tr>
							
						</table>
					</div>	
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
		$query="select er.idestado_resultado
				from estado_resultado er, clase_resultado cr, grupo_resultado gr
				where er.idempresa = ".$_POST['empresa2']." and er.idperiodo_contable = ".$_POST['periodoContable2']."  and er.estado ='Activo' 
				and cr.idclase_resultado = gr.idclase_resultado and gr.estado ='Activo' and cr.estado ='Activo' 
				order by cr.idclase_resultado, gr.idgrupo_resultado limit 1;";
		fncExecuteQuery($MyOps, $query, $arrayData, 1);
		if(count($arrayData)>0){
			$query="select idestado_resultado_detalle, cr.idclase_resultado, cr.nombre clase_resultado, gr.idgrupo_resultado, gr.nombre grupo_resultado, monto
					from estado_resultado_detalle  erd
					inner join clase_resultado cr on cr.idclase_resultado = erd.idclase_resultado
					inner join grupo_resultado gr on gr.idgrupo_resultado = erd.idgrupo_resultado
					where erd.estado = 1 and erd.idestado_resultado = ".$arrayData['idestado_resultado']."
					order by cr.idclase_resultado, gr.idgrupo_resultado;";
			fncExecuteQuery($MyOps, $query, $arrayData, 2);
			$query="select idestado_resultado_detalle, cr.idclase_resultado, cr.nombre clase_resultado, gr.idgrupo_resultado, gr.nombre grupo_resultado, monto
					from estado_resultado_detalle  erd
					inner join clase_resultado cr on cr.idclase_resultado = erd.idclase_resultado
					inner join grupo_resultado gr on gr.idgrupo_resultado = erd.idgrupo_resultado
					where erd.estado = 1 and erd.idestado_resultado = ".$arrayData['idestado_resultado2']."
					order by cr.idclase_resultado, gr.idgrupo_resultado;";
			fncExecuteQuery($MyOps, $query, $arrayData, 3);
			fncCompararTodo($arrayData);
			fncHTML($arrayData);
			#fncGrafica($arrayData);	
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

