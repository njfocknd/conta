
<?php
include ("nexthor_app.php");
function fncSetDataToArray($row, &$arrayData, $option)
{
	switch($option)
	{
		case 0:
			$arrayData["idbalance_general"]=$row["idbalance_general"];
			$arrayData["activo_corriente"]=$row["activo_corriente"];
			$arrayData["activo_fijo"]=$row["activo_fijo"];
			$arrayData["pasivo_corriente"]=$row["pasivo_corriente"];
			$arrayData["pasivo_fijo"]=$row["pasivo_fijo"];
			$arrayData["capital_contable"]=$row["capital_contable"];
			$arrayData['clase_cuenta'][1]["nombre"]='Activo';
			$arrayData['clase_cuenta'][3]["nombre"]='Pasivo';
			$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"] = 'Corriente';
			$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"] = 'Fijo';
			$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"] = 'Corriente';
			$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"] = 'Fijo';
			break;
		case 1:
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["nombre"]=$row["subgrupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["subgrupo_cuenta"][$row["idsubgrupo_cuenta"]]["id"]=$row["idbalance_general_detalle"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["grupo_cuenta"][$row["idgrupo_cuenta"]]["nombre"]=$row["grupo_cuenta"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["monto"]+=$row["monto"];
			$arrayData['clase_cuenta'][$row["idclase_cuenta"]]["nombre"]=$row["clase_cuenta"];
			break;
	}
}

function fncHTML($arrayData){
	echo "<table style='width:100%;'>
			<tr valign='top' align = 'center'>
				<td style='width:49%;'>
					<div class='panel panel-success'>
						<div class='panel-heading'>".$arrayData['clase_cuenta'][1]["nombre"]."</div>
						  <table class='table' >
							<tr>
								<td><em><b>".$arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["nombre"]."</b></em></td><td colspan = 2></td>
							<tr>";
	$ids= '0';$x=0;
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][1]["subgrupo_cuenta"] as $key => $value) 
	{
		$x++;
		$ids.=",".$key;
		echo "				<tr>
								<td></td>
								<td>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	if ($arrayData['activo_corriente']>$x){
		$query="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 1 and estado =1 and idsubgrupo_cuenta not in(".$ids.");";
		echo "				<tr>
								<td></td>
								<td>".fncDesignCombo($query,'cuenta_1','onchange="fncCambiarCuenta(1,'.$arrayData['idbalance_general'].',this.value)"','<option value = 0></option>','',0)."</td>
								<td><input type='text' id = 'monto_1' value='0' style='text-align: right' size='8'  class='form-control' onchange='fncAgregarCuenta(1,".$arrayData['idbalance_general'].",this.value);' /></td>
							</tr>";	
	}

	echo "					<tr>
								<td><em><b>".$arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["nombre"]."</b></em></td><td colspan = 2></td>
							<tr>";
	$ids= '0';$x=0;
	foreach ($arrayData['clase_cuenta'][1]["grupo_cuenta"][2]["subgrupo_cuenta"] as $key => $value) 
	{
		$x++;
		$ids.=",".$key;
		echo "				<tr>
								<td></td>
								<td>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	if ($arrayData['activo_fijo']>$x){
		$query="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 2 and estado =1 and idsubgrupo_cuenta not in(".$ids.");";
		echo "				<tr>
								<td></td>
								<td>".fncDesignCombo($query,'cuenta_2','onchange="fncCambiarCuenta(2,'.$arrayData['idbalance_general'].',this.value)"','<option value = 0></option>','',0)."</td>
								<td><input type='text' id = 'monto_2' value='0' style='text-align: right' size='8'  class='form-control' onchange='fncAgregarCuenta(2,".$arrayData['idbalance_general'].",this.value);' /></td>
							</tr>";	
	}
	echo "					<tr>
								<td></td>
								<td></td>
								<td><input type='text' value='".$arrayData['clase_cuenta'][1]["monto"]."' style='text-align: right;' size='8'  class='form-control' readonly/></td>
							<tr>
						</table>
					</div>
				</td>
				<td style='width:2%;'>
				</td>
				<td style='width:49%;'>
					<div class='panel panel-warning'>
						<div class='panel-heading'>".$arrayData['clase_cuenta'][3]["nombre"]."</div>
						  <table class='table'>
							<tr>
								<td><em><b>".$arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["nombre"]."</b></em></td><td colspan = 2></td>
							<tr>";
	$ids= '0';$x=0;
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][4]["subgrupo_cuenta"] as $key => $value) 
	{
		$x++;
		$ids.=",".$key;
		echo "				<tr>
								<td></td>
								<td>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	if ($arrayData['pasivo_corriente']>$x){
		$query="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 4 and estado =1 and idsubgrupo_cuenta not in(".$ids.");";
		echo "				<tr>
								<td></td>
								<td>".fncDesignCombo($query,'cuenta_3','onchange="fncCambiarCuenta(3,'.$arrayData['idbalance_general'].',this.value)"','<option value = 0></option>','',0)."</td>
								<td><input type='text' id = 'monto_3' value='0' style='text-align: right' size='8'  class='form-control' onchange='fncAgregarCuenta(3,".$arrayData['idbalance_general'].",this.value);' /></td>
							</tr>";	
	}
	echo "					<tr>
								<td><em><b>".$arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["nombre"]."</b></em></td><td colspan = 2></td>
							<tr>";
	$ids= '0';$x=0;
	foreach ($arrayData['clase_cuenta'][3]["grupo_cuenta"][5]["subgrupo_cuenta"] as $key => $value) 
	{
		$x++;
		$ids.=",".$key;
		echo "				<tr>
								<td></td>
								<td>".$value["nombre"]."</td>
								<td><input type='text' value='".$value["monto"]."' style='text-align: right' size='8'  class='form-control' onchange='fncCambiarMonto(".$value["id"].",this.value);' /></td>
							</tr>";
	}
	if ($arrayData['pasivo_fijo']>$x){
		$query="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 5 and estado =1 and idsubgrupo_cuenta not in(".$ids.");";
		echo "				<tr>
								<td></td>
								<td>".fncDesignCombo($query,'cuenta_4','onchange="fncCambiarCuenta(4,'.$arrayData['idbalance_general'].',this.value)"','<option value = 0></option>','',0)."</td>
								<td><input type='text' id = 'monto_4' value='0' style='text-align: right' size='8'  class='form-control' onchange='fncAgregarCuenta(4,".$arrayData['idbalance_general'].",this.value);' /></td>
							</tr>";	
	}
	echo "					<tr>
								<td></td>
								<td></td>
								<td><input type='text' value='".$arrayData['clase_cuenta'][3]["monto"]."' style='text-align: right;' size='8'  class='form-control' readonly/></td>
							<tr>		
						</table>
					</div>
					<div class='panel panel-info'>
						<div class='panel-heading'>Capital Contable</div>
						  <table class='table'>
							<tr>
								<td><em><b>Capital, Reservas y Resultados</b></em></td><td></td><td>".$arrayData['capital_contable']."</td>
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
		$query="select idbalance_general, (select count(*) from subgrupo_cuenta where idgrupo_cuenta = 1 and estado = 1) activo_corriente,
				(select count(*) from subgrupo_cuenta where idgrupo_cuenta = 2 and estado = 1) activo_fijo,
				(select count(*) from subgrupo_cuenta where idgrupo_cuenta = 4 and estado = 1) pasivo_corriente,
				(select count(*) from subgrupo_cuenta where idgrupo_cuenta = 5 and estado = 1) pasivo_fijo,
				capital_contable
			from  balance_general 
			where idempresa = ".$_POST['empresa']." and idperiodo_contable = ".$_POST['periodoContable']." 
				and estado ='Activo' 
			order by idbalance_general desc limit 1;";
		fncExecuteQuery($MyOps, $query, $arrayData, 0);
		if(!count($arrayData)>0){
			$query = " INSERT INTO balance_general (idempresa,idperiodo_contable) 
						VALUES (".$_POST["empresa"].",".$_POST["periodoContable"].");";
			$MyOps->insert_to_db($query);
			echo "<script>fncMostrar();</script>";
		}
		else{
			$query="select bgd.idbalance_general_detalle, cc.idclase_cuenta, cc.nombre clase_cuenta, gc.idgrupo_cuenta, gc.nombre grupo_cuenta,
						sc.idsubgrupo_cuenta, sc.nombre subgrupo_cuenta, bgd.monto 
					from balance_general_detalle bgd
						inner join clase_cuenta cc on cc.idclase_cuenta = bgd.idclase_cuenta
						inner join grupo_cuenta gc on gc.idgrupo_cuenta = bgd.idgrupo_cuenta
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
					where bgd.idbalance_general = ".$arrayData['idbalance_general']." and bgd.estado = 1
					order by cc.idclase_cuenta, gc.idgrupo_cuenta, sc.idsubgrupo_cuenta;";
			fncExecuteQuery($MyOps, $query, $arrayData, 1);
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

