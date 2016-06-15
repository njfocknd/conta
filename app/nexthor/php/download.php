<?php
include ("app_db_config.php");
require_once('dbops.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
	if (!isset($_GET['id']) || empty($_GET['id'])) 
	{
	   exit();
	}
	else
	{
		#querys de ejecución
		$query="update attachment set cuenta_descargas = cuenta_descargas + 1 where id_attachment = '".$_GET["id_attachment"]."';";
		$queryInsert="INSERT INTO attachment_download (idattachment,iduser,iduserlevel) VALUES ('".$_GET["id_attachment"]."','".$_GET["user"]."','".$_GET["ulevel"]."');";
		#Actualiza el contador de descarga
		$MyOps->update_to_db($query);
		#Inserta el usuario que lo descarga
		$MyOps->insert_to_db($queryInsert);
		
		#Descarga de archivo
		$name=$_GET["id"];
		$filename =$urlImage.$_GET["id"];
		if($_GET["id_article"] < 267303)
			$filename =$urlZip.$_GET["id"];
		$buffer = file_get_contents($filename);
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/octet-stream");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . strlen($buffer));
		header("Content-Disposition: attachment; filename=$name");
		echo $buffer;
	}
?>
<script type="text/javascript">
			$(function() {
				alert(1);
			});
			</script>