
<?php
include('php/app_db_config.php');
require_once('php/dbops.php');     
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);

function fncDesignCombo($query,$name,$function,$prefix,$suffix,$selected,$error)
	{
	include('php/app_db_config.php');
	require_once('php/dbops.php');       
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	$count=0;
	$combo="<select id ='".$name."' name ='".$name."' ".$function.">";
	$combo.=$prefix;
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			if ($selected==$row['id'])
				$combo.="<option value='".$row['id']."' selected>".utf8_encode($row["name"])." *</option>";
			else
				$combo.="<option value='".$row['id']."'>".utf8_encode($row["name"])."</option>";
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


function fncReturnId($object, $query)
	{
	$res = $object->list_orders($query);
	if($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			return $row["id"];
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
function fncCreateArray($query)
	{
	include('php/app_db_config.php');
	require_once('php/dbops.php');       
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	$count=0;
	$array="";
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			$array[$row['id']]=$row['name'];
			}
		}
	return $array;
	}	

function fncGetMonth()
	{
	return array('01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril','05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto', '09'=>'Septiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');
	}

function fncGetDay()
	{
	return array('1'=>'Lunes','2'=>'Martes','3'=>'Mi&eacute;rcoles','4'=>'Jueves','5'=>'Viernes','6'=>'S&aacute;bado','0'=>'Domingo');
	}

function fncGetMonthShortcut()
	{
	return array('01'=>'Ene','02'=>'Feb','03'=>'Mar','04'=>'Abr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Ago', '09'=>'Sep', '10'=>'Oct', '11'=>'Nov', '12'=>'Dic');
	}

function fncGetDayShortcut()
	{
	return array('1'=>'Lu','2'=>'Ma','3'=>'Mi','4'=>'Ju','5'=>'Vi','6'=>'S&aacute;','0'=>'Do');
	}	
	
function fncDesignComboArray($res,$name,$function,$prefix,$suffix,$selected,$error)
	{
	$count=0;
	$combo="<select id ='".$name."' name ='".$name."' ".$function." style='width:150px'>";
	$combo.=$prefix;
	foreach ($res as $key => $row) 
		{
		$count++;
		if ($selected==$key)
			$combo.="<option value='".$key."' selected>".$res[$key]." *</option>";
		else
			$combo.="<option value='".$key."'>".$res[$key]."</option>";
		}
		
	
	$combo.=$suffix."</select>";
	if ($count==0)
		{
		$alert="<SCRIPT LANGUAGE=\"JavaScript\">Alertify.dialog.labels.ok ='Aceptar';Alertify.dialog.alert('<img src=\'general_repository/image/stop_48x48.png\'><b><big>Error en  ".$error."</big></b>');</SCRIPT>";
		$combo.=$alert." <img src='general_repository/image/stop_24x24.png'> <font color =red><b>Error en el Selector</b></font>";
		}
	return $combo;
	}
	

function fncDesignComboMultiple($query,$name,$function,$prefix,$suffix,$selected,$error)
	{
	include('php/app_db_config.php');
	require_once('php/dbops.php');       
	$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	$count=0;
	$combo="<select multiple id ='".$name."' name ='".$name."' ".$function."  class='select2 form-control' style='width:265px;'>";
	$combo.=$prefix;
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			if ($selected==$row['id'])
				$combo.="<option value='".$row['id']."' selected>".utf8_encode($row["name"])." *</option>";
			else
				$combo.="<option value='".$row['id']."'>".utf8_encode($row["name"])."</option>";
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

	
// Funciones Nuevas

function fncGetMinusculas($string)
{
	$minusculas = strtolower($string);
	return $minusculas;
}
function fncGetMayusculas($string)
{
	$mayusculas = strtoupper($string);
	return $mayusculas;
}
function fncGetCapital($string)
{
	$capital = ucwords(strtolower($string));
	return $capital;
}

function fncGetTable($MyOps,$query,$name,$id,$class,$classPanel,$tituloPanel)	
{
$encabezado='';
$cuerpo='';

	$resultado = $MyOps->list_orders($query);
	$campos ="<tr>";
	if($resultado)
	{
		while ($valor = mysql_fetch_assoc($resultado)) 
		{
			foreach ($valor as $llave2 => $valor2) {
				$array_encabezado[$llave2] = $llave2;
				$campos .= '<td>'.fncGetCapital($valor[$llave2]).'</td>';
			}
			$campos .="</tr><tr>";
		}
	}
	$campos .="</tr>";
	
	foreach ($array_encabezado as $llave => $valor) {
		$encabezado .= '<th>'.$array_encabezado[$llave].'</th>';
	}
echo '	<div class="panel '.$classPanel.'">
			<div class="panel-heading">
				'.$tituloPanel.'
			</div>
			
			<table class="table '.$class.'" id="'.$id.'" name="'.$name.'">
			<tr align="center">
				'.$encabezado.'
			</tr>
				'.$campos.'
			</table>
		</div>';
}

function fncCreaMatriz($MyOps, $query)
	{
	$count=0;
	$array="";
	$res = $MyOps->list_orders($query);
	if ($res)
		{
		while ($row = mysql_fetch_assoc($res)) 
			{
			$count++;
			$array[$row['id']]=$row['name'];
			}
		}
	return $array;
	}

function fncGetInput($name, $id, $tipo, $onclick, $onchange, $titulo, $texto)
{
	echo  '<input type="'.$tipo.'" class="form-control" id="'.$id.'" name="'.$name.'" onchange="'.$onchange.'" onclick="'.$onclick.'" title="'.$titulo.'" placeholder="'.$texto.'">';
}

function fncGetLabel($tipoLabel, $textoLabel)
{
	echo '<label for="'.$tipoLabel.'">'.$textoLabel.'</label>';
}

function fncGetInputLabel($tipoLabel, $textoLabel, $name, $id, $tipo, $onclick, $onchange, $titulo, $texto)
{
	echo  '<label for="'.$tipoLabel.'">'.$textoLabel.'</label><input type="'.$tipo.'" class="form-control" id="'.$id.'" name="'.$name.'" onchange="'.$onchange.'" onclick="'.$onclick.'" title="'.$titulo.'" placeholder="'.$texto.'">';

}

function fncGetCheck($type, $texto)
{
	echo'<input type="'.$type.'"> '.$texto.'';
}

function fncGetButton($type, $texto, $class, $title)
{
	echo '<button type="'.$type.'" class="'.$class.'" title="'.$title.'">'.$texto.'</button>';
}

function fncGetButtonImage($type, $texto, $class, $image, $title)
{
	echo'<button type="'.$type.'" class="'.$class.'" title="'.$title.'"><span class="'.$image.'" aria-hidden="true"></span> '.$texto.'</button>';
}

function fncGetTextArea($row, $texto, $title)
{
	echo '<textarea class="form-control" rows="'.$row.'" title="'.$title.'">'.$texto.'</textarea>';
}


?>