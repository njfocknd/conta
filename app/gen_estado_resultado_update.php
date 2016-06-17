<?php
include ("nexthor_app.php");
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
																
if (isset($_POST["id"])&&isset($_POST["monto"])&&isset($_POST["actualizarDetalle"]))
{
	$query = "UPDATE estado_resultado_detalle SET monto = '".$_POST["monto"]."' where idestado_resultado_detalle = ".$_POST["id"].";";
	$MyOps->update_to_db($query);
}
elseif (isset($_POST["id"])&&isset($_POST["monto"])&&isset($_POST["agregarDetalle"]))
{
	$query = " INSERT INTO estado_resultado_detalle (idestado_resultado,idclase_resultado,idgrupo_resultado,monto) 
				VALUES (".$_POST["id"].",obtener_idclase_resultado(".$_POST["cuenta"]."),".$_POST["cuenta"].",".$_POST["monto"].");";
	$MyOps->insert_to_db($query);
}
?>