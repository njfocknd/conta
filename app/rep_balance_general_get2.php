
<?php
include ("nexthor_app.php");
function fncSetDataToArray($row, &$arrayData, $option)
{
	switch($option)
	{
		case 0:
			$arrayData["idbalance_general"]=$row["idbalance_general"];
			$arrayData["capital_contable"]=$row["capital_contable"];
			$arrayData["capital_contable_clase"]=" class='success' ";
			break;
		case 1:
			$arrayData["idbalance_general2"]=$row["idbalance_general"];
			$arrayData["capital_contable2"]=$row["capital_contable"];
			if ($arrayData["capital_contable2"]>$arrayData["capital_contable"])
				$arrayData["capital_contable_clase"]=" class='danger' ";
			break;
		case 2:
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["nombre"]=$row["subgrupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["clase"]=" class='success' ";
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["nombre"]=$row["grupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["clase"]=" class='success' ";
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["nombre"]=$row["clase_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["clase"]=" class='success' ";
			
			break;
		case 3:
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["nombre"]=$row["subgrupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["nombre"]=$row["grupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto2"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["nombre"]=$row["clase_cuenta"];
			if($arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto2"]>$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto"])
				$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["clase"]=" class='danger' ";
			if($arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto2"]>$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto"])
				$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["clase"]=" class='danger' ";
			if($arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto2"]>$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto"])
				$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["clase"]=" class='danger' ";
			break;
	}
}

function fncHTML($arrayData){
	echo "<table style='width:100%;'>
			<tr valign='top' align = 'center'>
				<td style='width:49%;'>
					<div class='panel panel-success'>
						<table class='table' >";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][1]["nombre"]." ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr ".$value["clase"].">
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["clase"].">
								<td></td>
								<td><em><b>Total ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"]."</b></em></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["monto"],0)."</b></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["monto2"],0)."</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][1]["nombre"]." ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr ".$value["clase"].">
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["clase"].">
								<td></td>
								<td><em><b>Total ".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"]."</b></em></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["monto"],0)."</b></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["monto2"],0)."</b></td>
							</tr>
							<tr ".$arrayData['clase_cuenta'][1]["clase"].">
								<td><em><b>Total de ".$arrayData['clase_cuenta'][1]["nombre"]."</b></em></td><td></td>
								<td align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["monto"],0)."</em></td></td>
								<td align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][1]["monto2"],0)."</em></td></td>
							<tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][3]["nombre"]." ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr ".$value["clase"].">
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["clase"].">
								<td></td>
								<td><em><b>Total ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"]."</b></em></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["monto"],0)."</b></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["monto2"],0)."</b></td>
							</tr>";
	$encabezado = "<em><b>".$arrayData['clase_cuenta'][3]["nombre"]." ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"]."</b></em>";
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["subgrupo_cuenta"] as $key => $value) 
	{
		echo "				<tr ".$value["clase"].">
								<td>".$encabezado."</td>
								<td>".$value["nombre"]."</td>
								<td align = 'right'>".number_format($value["monto"],0)."</td>
								<td align = 'right'>".number_format($value["monto2"],0)."</td>
							</tr>";
		$encabezado = "";
	}
	echo "					<tr ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["clase"].">
								<td></td>
								<td><em><b>Total ".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"]."</b></em></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["monto"],0)."</b></td>
								<td align = 'right'><b>".number_format($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["monto2"],0)."</b></td>
							</tr>
							<tr ".$arrayData['clase_cuenta'][3]["clase"].">
								<td><em><b>Total de ".$arrayData['clase_cuenta'][3]["nombre"]."</b></em></td>
								<td></td>
								<td align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["monto"],0)."</em></b></td>
								<td align = 'right'><em><b>".number_format($arrayData['clase_cuenta'][3]["monto2"],0)."</em></b></td>
							<tr>		
							<tr ".$arrayData['capital_contable_clase'].">
								<td><em><b>Capital, Reservas y Resultados</b></em></td><td></td>
								<td align = 'right'><em><b>".number_format($arrayData['capital_contable'],0)."</b></em></td>
								<td align = 'right'><em><b>".number_format($arrayData['capital_contable2'],0)."</b></em></td>
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
		$query="select idbalance_general, capital_contable
			from  balance_general 
			where idempresa = ".$_POST['empresa']." and idperiodo_contable = ".$_POST['periodoContable']." 
				and estado ='Activo'
			order by idbalance_general desc limit 1";
		fncExecuteQuery($MyOps, $query, $arrayData, 0);
		$query="select idbalance_general, capital_contable
			from  balance_general 
			where idempresa = ".$_POST['empresa2']." and idperiodo_contable = ".$_POST['periodoContable2']." 
				and estado ='Activo' 
			order by idbalance_general desc limit 1;";
		fncExecuteQuery($MyOps, $query, $arrayData, 1);
		if(count($arrayData)>0){
			$query="select bgd.idbalance_general_detalle, cc.idclase_cuenta, cc.nombre clase_cuenta, gc.idgrupo_cuenta, gc.nombre grupo_cuenta,
						sc.idsubgrupo_cuenta, sc.nombre subgrupo_cuenta, bgd.monto 
					from balance_general_detalle bgd
						inner join clase_cuenta cc on cc.idclase_cuenta = bgd.idclase_cuenta
						inner join grupo_cuenta gc on gc.idgrupo_cuenta = bgd.idgrupo_cuenta
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
					where bgd.idbalance_general = ".$arrayData['idbalance_general']." and bgd.estado = 1
					order by cc.idclase_cuenta, gc.idgrupo_cuenta, sc.idsubgrupo_cuenta;";
			fncExecuteQuery($MyOps, $query, $arrayData, 2);
			$query="select bgd.idbalance_general_detalle, cc.idclase_cuenta, cc.nombre clase_cuenta, gc.idgrupo_cuenta, gc.nombre grupo_cuenta,
						sc.idsubgrupo_cuenta, sc.nombre subgrupo_cuenta, bgd.monto 
					from balance_general_detalle bgd
						inner join clase_cuenta cc on cc.idclase_cuenta = bgd.idclase_cuenta
						inner join grupo_cuenta gc on gc.idgrupo_cuenta = bgd.idgrupo_cuenta
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
					where bgd.idbalance_general = ".$arrayData['idbalance_general2']." and bgd.estado = 1
					order by cc.idclase_cuenta, gc.idgrupo_cuenta, sc.idsubgrupo_cuenta;";
			fncExecuteQuery($MyOps, $query, $arrayData, 3);
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

