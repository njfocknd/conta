
<?php
$arrayMesCorto = array("01" => "ene", "02" => "feb", "03" => "mar", "04" => "abr", "05" => "may", "06" => "jun", "07" => "jul", "08" => "ago", "09" => "sep", "10" => "oct", "11" => "nov", "12" => "dic");
$arrayMes = array("01" => "Enero", "02" => "Febrero", "03" => "Marzo", "04" => "Abril", "05" => "Mayo", "06" => "Junio", "07" => "Julio", "08" => "Agosto", "09" => "Septiembre", "10" => "Octubre", "11" => "Noviembre", "12" => "Diciembre");
$arrayDia = array("0" => "domingo", "1" => "lunes", "2" => "martes", "3" => "miercoles", "4" => "jueves", "5" => "viernes", "6" => "sabado");

function fncOperarQuery($object, $query, &$arrayData, $option)
	{

	$res = $object->list_orders($query);
	if($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			fncSetDataToArray($row, $arrayData, $option);
			}
		}
	}
	

function fncExecuteQuery($object, $query, &$arrayData, $option)
	{

	$res = $object->list_orders($query);
	if($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			fncSetDataToArray($row, $arrayData, $option);
			}
		}
	}
	
function fncComboQuery($MyOps, $query,$name,$function,$prefix,$suffix,$selected,$error)
	{
	$count=0;
	$combo="<select id ='".$name."' name ='".$name."' ".$function." class='form-control' style = 'width:180px;'>";
	$combo.=$prefix;
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			if ($selected==$row['id'])
				$combo.="<option value='".$row['id']."' selected>".$row["name"]." *</option>";
			else
				$combo.="<option value='".$row['id']."'>".$row["name"]."</option>";
			}
		}
	$combo.=$suffix."</select>";
	if ($count==0)
		{
		$alert="<SCRIPT LANGUAGE=\"JavaScript\">Alertify.dialog.labels.ok ='Aceptar';Alertify.dialog.alert('<img src=\'general_repository/image/stop_48x48.png\'><b><big>Error en  ".$error."</big></b>');</SCRIPT>";
		$combo.=$alert." <img src='general_repository/image/stop_24x24.png'> <font color =red><b>Error en el Selector</b></font>";
		}
	return $combo;
	}
		function fncDesignCombo($query,$name,$function,$prefix,$suffix,$selected,$error)
	{
	include('app_db_config.php');
	//require_once('dbops.php');     
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	$count=0;
	$combo="<select id='".$name."' name ='".$name."' ".$function." class='form-control'>";
	$combo.=$prefix;
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			if ($selected==$row['id'])
				$combo.="<option value='".$row['id']."' selected> ".$row["name"]." *</option>";
			else
				$combo.="<option value='".$row['id']."'> ".$row["name"]."</option>";
			}
		}
	
	$combo.=$suffix."</select>";
	if ($count==0)
		{
		$alert="<SCRIPT LANGUAGE=\"JavaScript\">Alertify.log.error('<b><big>".$error."</big></b>');</SCRIPT>";
		$combo.=$alert." <img src='general_repository/image/stop_24x24.png'> <font color =red><b>No tiene Datos</b></font>";
		}
	return $combo;
	}?>