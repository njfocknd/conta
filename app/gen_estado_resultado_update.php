<?php
include ("nexthor_app.php");
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
																
if (isset($_POST["id"])&&isset($_POST["monto"])&&isset($_POST["actualizarDetalle"]))
{
	$query = "UPDATE balance_general_detalle SET monto = '".$_POST["monto"]."' where idbalance_general_detalle = ".$_POST["id"].";";
	$MyOps->update_to_db($query);
}
elseif (isset($_POST["id"])&&isset($_POST["monto"])&&isset($_POST["agregarDetalle"]))
{
	$query = " INSERT INTO balance_general_detalle (idbalance_general,idclase_cuenta,idgrupo_cuenta,idsubgrupo_cuenta,monto) 
				VALUES (".$_POST["id"].",obtener_idclase_cuenta(".$_POST["cuenta"]."),obtener_idgrupo_cuenta(".$_POST["cuenta"]."),".$_POST["cuenta"].",".$_POST["monto"].");";
	$MyOps->insert_to_db($query);
}
?>