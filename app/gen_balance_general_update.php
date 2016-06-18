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

elseif (isset($_POST["id"])&&isset($_POST["idempresa_proyectar"])&&isset($_POST["proyectar"]))
{
	$query = "UPDATE balance_general_detalle SET estado = 2 where idbalance_general = ".$_POST["id"].";";
	$MyOps->update_to_db($query);
	$query="select idclase_cuenta, idgrupo_cuenta, idsubgrupo_cuenta, monto from balance_general bg
			inner join balance_general_detalle bgd on bgd.idbalance_general = bg.idbalance_general
			where idempresa = ".$_POST['idempresa_proyectar']." and idperiodo_contable = ".$_POST['idperiodo_contable_proyectar']." and bgd.estado ='Activo'
			and bg.estado ='Activo';";
	$res = $MyOps->list_orders($query);
	$pBalanceGeneral=0;
	if($res)
	{
		while ($row = mysql_fetch_assoc($res)) 
		{
				$query = " INSERT INTO balance_general_detalle (idbalance_general,idclase_cuenta,idgrupo_cuenta,idsubgrupo_cuenta,monto) 
				VALUES (".$_POST["id"].",".$row["idclase_cuenta"].",".$row["idgrupo_cuenta"].",".$row["idsubgrupo_cuenta"].",".($row["monto"]*(($_POST["aumento"]/100)+1)).");";
				$MyOps->insert_to_db($query);
		}
	}
}
?>