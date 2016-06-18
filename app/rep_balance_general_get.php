
<?php
include ("nexthor_app.php");
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
function fncCalcularVertical(&$arrayData){
	foreach ($arrayData['clase_cuenta'] as $key => $value) 
	{
		if($key < 4){
			foreach ($value['grupo_cuenta'] as $key2 => $value2) 
			{
				$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['vertical'] =  round(($value2['monto']/$value['monto'])*100,2);
				$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['vertical2'] =  round(($value2['monto2']/$value['monto2'])*100,2);
				
				foreach ($value2['subgrupo_cuenta'] as $key3 => $value3) 
				{
					$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['subgrupo_cuenta'][$key3]['vertical'] =  round(($value3['monto']/$value['monto'])*100,2);
					$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['subgrupo_cuenta'][$key3]['vertical2'] =  round(($value3['monto2']/$value['monto2'])*100,2);
				}
			}
				
		}
	}
}

function fncCompararTodo(&$arrayData){
	$arrayComparar = fncComparar($arrayData['capital_contable'],$arrayData['capital_contable2'],'Positiva');
	$arrayData['capital_contable_clase'] = $arrayComparar['clase'];
	$arrayData['capital_contable_varianza'] = $arrayComparar['varianza'];
	$arrayData['capital_contable_diferencia'] = $arrayComparar['diferencia'];
	foreach ($arrayData['clase_cuenta'] as $key => $value) 
	{
		$arrayComparar = fncComparar($arrayData['clase_cuenta'][$key]['monto'],$arrayData['clase_cuenta'][$key]['monto2'],$arrayData['clase_cuenta'][$key]['tendencia']);
		$arrayData['clase_cuenta'][$key]['clase'] = $arrayComparar['clase'];
		$arrayData['clase_cuenta'][$key]['varianza'] = $arrayComparar['varianza'];
		$arrayData['clase_cuenta'][$key]['diferencia'] = $arrayComparar['diferencia'];
		foreach ($value['grupo_cuenta'] as $key2 => $value2) 
		{
			$arrayComparar = fncComparar($value2['monto'],$value2['monto2'],$value2['tendencia']);
			$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['clase'] = $arrayComparar['clase'];
			$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['varianza'] = $arrayComparar['varianza'];
			$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['diferencia'] = $arrayComparar['diferencia'];
			foreach ($value2['subgrupo_cuenta'] as $key3 => $value3) 
			{
				$arrayComparar = fncComparar($value3['monto'],$value3['monto2'],$value3['tendencia']);
				$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['subgrupo_cuenta'][$key3]['clase'] = $arrayComparar['clase'];
				$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['subgrupo_cuenta'][$key3]['varianza'] = $arrayComparar['varianza'];
				$arrayData['clase_cuenta'][$key]['grupo_cuenta'][$key2]['subgrupo_cuenta'][$key3]['diferencia'] = $arrayComparar['diferencia'];
			}
		}
	}
}

function fncSetDataToArray($row, &$arrayData, $option)
{
	switch($option)
	{
		case 0:
			$arrayData["idbalance_general"]=$row["idbalance_general"];
			$arrayData["capital_contable"]=$row["capital_contable"];
			$arrayData["periodo_contable"]=$row["periodo_contable"];
			$arrayData["empresa"]=$row["empresa"];
			break;
		case 1:
			$arrayData["idbalance_general2"]=$row["idbalance_general"];
			$arrayData["capital_contable2"]=$row["capital_contable"];
			$arrayData["periodo_contable2"]=$row["periodo_contable"];
			$arrayData["empresa2"]=$row["empresa"];
			break;
		case 2:
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["nombre"]=$row["subgrupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["tendencia"]=$row["tendencia"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["nombre"]=$row["grupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["tendencia"]=$row["tendencia"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["nombre"]=$row["clase_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["tendencia"]=$row["tendencia"];
			
			break;
		case 3:
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["nombre"]=$row["subgrupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["tendencia"]=$row["tendencia"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["nombre"]=$row["grupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["tendencia"]=$row["tendencia"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["nombre"]=$row["clase_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["tendencia"]=$row["tendencia"];
			break;
	}
}

function fncHTML($arrayData){
	echo "<table style='width:100%;'>
			<tr valign='top' align = 'center'>
				<td style='width:49%;'>
					<div class='panel panel-success'>
						<table class='table  table-bordered' >
						<tr class='active'>
							<th>Grupo</th>
							<th>Cuenta</th>
							<th>".$arrayData["empresa"]." ".$arrayData["periodo_contable"]."</th>
							<th>Varianción Vertical</th>
							<th>".$arrayData["empresa2"]." ".$arrayData["periodo_contable2"]."</th>
							<th>Varianción Vertical</th>
							<th>Diferencia</th>
							<th>Varianción Horizontal</th>
						</tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][1]["nombre"]." ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["vertical"],2)." %</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right'>".number_format($value["vertical2"],2)." %</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr>
								<td class='warning'></td>
								<td class='warning'><em><b>Total ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"]."</b></em></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["monto"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["vertical"],2)." %</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["monto2"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["vertical2"],2)." %</b></td>
								<td ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["diferencia"],0)."</b></td>
								<td ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["varianza"],2)." %</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][1]["nombre"]." ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["vertical"],2)." %</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right'>".number_format($value["vertical2"],2)." %</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr>
								<td class='warning'></td>
								<td class='warning'><em><b>Total ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"]."</b></em></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["monto"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["vertical"],2)." %</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["monto2"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["vertical2"],2)." %</b></td>
								<td ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["diferencia"],0)."</b></td>
								<td ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["varianza"],2)." %</b></td>
							</tr>
							<tr>
								<td class='success'><em><b>Total de ".$arrayData['clase_cuenta'][1]["nombre"]."</b></em></td>
								<td class='success'></td>
								<td class='success' align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["monto"],0)."</em></td></td>
								<td class='success'></td>
								<td class='success' align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["monto2"],0)."</em></td></td>
								<td class='success'></td>
								<td ".$arrayData['clase_cuenta'][1]["clase"]." align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["diferencia"],0)."</em></b></td>
								<td ".$arrayData['clase_cuenta'][1]["clase"]." align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["varianza"],2)." %</em></b></td>
							<tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][3]["nombre"]." ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["vertical"],2)." %</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right'>".number_format($value["vertical2"],2)." %</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr>
								<td  class='warning'></td>
								<td  class='warning'><em><b>Total ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"]."</b></em></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["monto"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["vertical"],2)." %</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["monto2"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["vertical2"],2)." %</b></td>
								<td ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["diferencia"],0)."</b></td>
								<td ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["varianza"],2)." %</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][3]["nombre"]." ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr>
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["vertical"],2)." %</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
								<td align = 'right'>".number_format($value["vertical2"],2)." %</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["diferencia"],0)."</td>
								<td align = 'right' ".$value["clase"].">".number_format($value["varianza"],2)." %</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr>
								<td class='warning' ></td>
								<td class='warning' ><em><b>Total ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"]."</b></em></td>
								<td class='warning'  align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["monto"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["vertical"],2)." %</b></td>
								<td class='warning'  align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["monto2"],0)."</b></td>
								<td class='warning' align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["vertical2"],2)." %</b></td>
								<td ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["diferencia"],0)."</b></td>
								<td ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["clase"]." align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["varianza"],2)." %</b></td>
							</tr>
							<tr >
								<td class='success'><em><b>Total de ".$arrayData['clase_cuenta'][3]["nombre"]."</b></em></td>
								<td class='success'></td>
								<td class='success' align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["monto"],0)."</em></b></td>
								<td class='success'></td>
								<td class='success' align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["monto2"],0)."</em></b></td>
								<td class='success'></td>
								<td ".$arrayData['clase_cuenta'][3]["clase"]." align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["diferencia"],0)."</em></b></td>
								<td ".$arrayData['clase_cuenta'][3]["clase"]." align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["varianza"],2)." %</em></b></td>
							<tr>		
							<tr class='active'>
								<td><em><b>Capital, Reservas y Resultados</b></em></td><td></td>
								<td align = 'right'><em><b>".number_format($arrayData['capital_contable'],0)."</b></em></td>
								<td></td>
								<td align = 'right'><em><b>".number_format($arrayData['capital_contable2'],0)."</b></em></td>
								<td></td>
								<td ".$arrayData['capital_contable_clase']."align = 'right'><em><b>".number_format($arrayData['capital_contable_diferencia'],0)."</b></em></td>
								<td ".$arrayData['capital_contable_clase']."align = 'right'><em><b>".number_format($arrayData['capital_contable_varianza'],0)." %</b></em></td>
							<tr>
							
				</td>
			</tr>
		</table>";
}
if(true)
{
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	if (isset($_POST["empresa"])&&isset($_POST["periodoContable"])&&isset($_POST["mostrarActivoCorriente"]))
	{
		$arrayData["idbalance_general"] = '0';
		$query="select b.idbalance_general, b.capital_contable, p.nombre periodo_contable, e.ticker empresa
			from  balance_general b
				inner join empresa e on e.idempresa = b.idempresa
				inner join periodo_contable p on p.idperiodo_contable = b.idperiodo_contable
			where b.idempresa = ".$_POST['empresa']." and b.idperiodo_contable = ".$_POST['periodoContable']." 
				and b.estado ='Activo'
			order by b.idbalance_general desc limit 1";
		fncExecuteQuery($MyOps, $query, $arrayData, 0);
		$query="select b.idbalance_general, b.capital_contable, p.nombre periodo_contable, e.ticker empresa 
			from  balance_general b 
				inner join empresa e on e.idempresa = b.idempresa
				inner join periodo_contable p on p.idperiodo_contable = b.idperiodo_contable
			where b.idempresa = ".$_POST['empresa2']." and b.idperiodo_contable = ".$_POST['periodoContable2']." 
				and b.estado ='Activo' 
			order by idbalance_general desc limit 1;";
		fncExecuteQuery($MyOps, $query, $arrayData, 1);
		if(count($arrayData)>0){
			$query="select bgd.idbalance_general_detalle, cc.idclase_cuenta, cc.nombre clase_cuenta, gc.idgrupo_cuenta, gc.nombre grupo_cuenta,
						sc.idsubgrupo_cuenta, sc.nombre subgrupo_cuenta, bgd.monto, tendencia
					from balance_general_detalle bgd
						inner join clase_cuenta cc on cc.idclase_cuenta = bgd.idclase_cuenta
						inner join grupo_cuenta gc on gc.idgrupo_cuenta = bgd.idgrupo_cuenta
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
					where bgd.idbalance_general = ".$arrayData['idbalance_general']." and bgd.estado = 1
					order by cc.idclase_cuenta, gc.idgrupo_cuenta, sc.idsubgrupo_cuenta;";
			fncExecuteQuery($MyOps, $query, $arrayData, 2);
			$query="select bgd.idbalance_general_detalle, cc.idclase_cuenta, cc.nombre clase_cuenta, gc.idgrupo_cuenta, gc.nombre grupo_cuenta,
						sc.idsubgrupo_cuenta, sc.nombre subgrupo_cuenta, bgd.monto, tendencia
					from balance_general_detalle bgd
						inner join clase_cuenta cc on cc.idclase_cuenta = bgd.idclase_cuenta
						inner join grupo_cuenta gc on gc.idgrupo_cuenta = bgd.idgrupo_cuenta
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
					where bgd.idbalance_general = ".$arrayData['idbalance_general2']." and bgd.estado = 1
					order by cc.idclase_cuenta, gc.idgrupo_cuenta, sc.idsubgrupo_cuenta;";
			fncExecuteQuery($MyOps, $query, $arrayData, 3);
			fncCompararTodo($arrayData);
			fncCalcularVertical($arrayData);
			fncHTML($arrayData); 
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

