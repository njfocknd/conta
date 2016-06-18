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
elseif (isset($_POST["id"])&&isset($_POST["idempresa_proyectar"])&&isset($_POST["proyectar"]))
{
	$query = "UPDATE estado_resultado_detalle SET estado = 2 where idestado_resultado = ".$_POST["id"].";";
	$MyOps->update_to_db($query);
	$query="select idclase_resultado , idgrupo_resultado , monto from estado_resultado bg
			inner join estado_resultado_detalle bgd on bgd.idestado_resultado = bg.idestado_resultado
			where idempresa = ".$_POST['idempresa_proyectar']." and idperiodo_contable = ".$_POST['idperiodo_contable_proyectar']." and bgd.estado ='Activo' and bg.estado ='Activo';";
	$res = $MyOps->list_orders($query);
	$pBalanceGeneral=0;
	if($res)
	{
		while ($row = mysql_fetch_assoc($res)) 
		{
				$query = " INSERT INTO estado_resultado_detalle (idestado_resultado,idclase_resultado,idgrupo_resultado,monto) 
				VALUES (".$_POST["id"].",".$row["idclase_resultado"].",".$row["idgrupo_resultado"].",".($row["monto"]*(($_POST["aumento"]/100)+1)).");";
				$MyOps->insert_to_db($query);
		}
	}
}
?>