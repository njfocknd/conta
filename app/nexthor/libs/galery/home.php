<?php 
session_start(); 
ob_start(); 
date_default_timezone_set("America/Guatemala");

include "ewcfg12.php";
include "phpfn12.php";
include "userfn12.php";

header("Cache-Control: private, no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

include "header.php";
include ("nexthor/php/app_db_config.php");
require_once('nexthor/php/dbops.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);

if(isset($_GET['nota']))
{
	$queryNota="select a.id_article, a.titulo, a.subtitulo, texto_articulo,
				a.fecha, a.Hora, a.Usuario, concat(u.nombres, ' ', u.apellidos) corresponsal, a.Municipio, a.Depto
				from vw_articulos a 
				inner join vw_user u on (u.id_user = a.Usuario) where id_article = ".$_GET['nota'].";";
				
	$res = $MyOps->list_orders($queryNota);
	if($res)
	{
		while ($row = mysql_fetch_assoc($res)) 
		{
		$idArticulo= $row["id_article"];
		$titulo= $row["titulo"];
		$subtitulo= $row["subtitulo"];
		$fecha= $row["fecha"];
		$hora= $row["Hora"];
		$corresponsal= $row["corresponsal"];
		$municipio= $row["Municipio"];
		$departamento= $row["Depto"];
		$nota= $row["texto_articulo"];
		}
	}
	$imagenes=""; $thumbnails="";
	$queryImagenes="select file_name, autor, text_ from attachment where estado = 'Activo' and id_article = ".$idArticulo;
	$res2 = $MyOps->list_orders($queryImagenes);
	if($res2)
	{
		while ($row2 = mysql_fetch_assoc($res2)) 
		{
			//$imagenes.='<img src="https://s3.amazonaws.com/collaborators/preview/'.$row2["file_name"].'" class="img-rounded"/>';
			$thumbnails.='<li><a href="https://s3.amazonaws.com/collaborators/archivos_subidos/'.$row2["file_name"].'" title="Foto tomada por: '.$row2["autor"].'"><img src="https://s3.amazonaws.com/collaborators/preview/'.$row2["file_name"].'" alt="turntable"></a></li>';
		}
	}
}
?>

<!doctype html>
<html lang="en-US">
<head>
  <meta charset="utf-8">
  <meta http-equiv="Content-Type" content="text/html">
  <title>Blog-Style Lightbox Gallery - Design Shack Demo</title>
  <meta name="author" content="Jake Rocheleau">
  <link rel="shortcut icon" href="http://designshack.net/favicon.ico">
  <link rel="icon" href="http://designshack.net/favicon.ico">
  <link rel="stylesheet" type="text/css" media="all" href="css/styles.css">
  <link rel="stylesheet" type="text/css" media="all" href="css/jquery.lightbox-0.5.css">
  <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>
</head>

<body>
  <div id="topbar"><a href="http://designshack.net">Back to Design Shack</a></div>
  
  <div id="w">
    <div id="content">
      <h1>Images Lightbox Gallery</h1>
      <p>We are creating a thumbnail blog-style image gallery with the <a href="http://leandrovieira.com/projects/jquery/lightbox/">jQuery lightBox plugin</a> made by Leandro Vieira Pinho. Completely free and open source to use on any project!</p>
      
      <div id="thumbnails">
        <ul class="clearfix">
          <!-- source: http://dribbble.com/shots/1115721-Turntable -->
          <li><a href="images/photos/01-turntable-illustration-graphic.png" title="Turntable by Jens Kappelmann"><img src="images/photos/01-turntable-illustration-graphic-thumbnail.png" alt="turntable"></a></li>
          
          <!-- source: http://dribbble.com/shots/1115776-DIY-Robot-Kit -->
          <li><a href="images/photos/02-robot-diy-kit.png" title="DIY Robot by Jory Raphael"><img src="images/photos/02-robot-diy-kit-thumbnail.png" alt="DIY Robot Kit"></a></li>
          
          <!-- source: http://dribbble.com/shots/1115794-Todly -->
          <li><a href="images/photos/03-todly-green-monster.png" title="Todly by Scott Wetterschneider"><img src="images/photos/03-todly-green-monster-thumbnail.png" alt="Todly"></a></li>
          
          <!-- source: http://dribbble.com/shots/1115299-Legend-of-Zelda-Tea-Party -->
          <li><a href="images/photos/04-loz-tea-party.png" title="LoZ Tea Party by Joseph Le"><img src="images/photos/04-loz-tea-party-thumbnail.png" alt="legend of zelda tea party"></a></li>
          
          <!-- source: http://dribbble.com/shots/1116121-klaxon-Icon -->
          <li><a href="images/photos/05-klaxon-air-horn.png" title="Klaxon Icon by John Khester"><img src="images/photos/05-klaxon-air-horn-thumbnail.png" alt="airhorn icon"></a></li>
          
          <!-- source: http://dribbble.com/shots/1116241-Flat-Coffee -->
          <li><a href="images/photos/06-flat-coffee.png" title="Flat Coffee by Baglan Dosmagambetov"><img src="images/photos/06-flat-coffee-thumbnail.png" alt="flat coffee"></a></li>
          
          <!-- source: http://dribbble.com/shots/1116392-Creative-player-Retina -->
          <li><a href="images/photos/07-ipad-music-player.png" title="iPad Music Player by Angel Bartolli"><img src="images/photos/07-ipad-music-player-thumbnail.png" alt="player ui"></a></li>
          
          <!-- source: http://dribbble.com/shots/1115350-Extreme-Fish-Bowl -->
          <li><a href="images/photos/08-extreme-fish-bowl.png" title="Extreme Fish Bowl by Brian Franco"><img src="images/photos/08-extreme-fish-bowl-thumbnail.png" alt="extreme skateboarding fish bowl"></a></li>
          
          <!-- source: http://dribbble.com/shots/1116637-Typographic-Illustration-detail-1 -->
          <li><a href="images/photos/09-city-building-illustration.png" title="Illustration by Brandon Ancone"><img src="images/photos/09-city-building-illustration-thumbnail.png" alt="city illustration"></a></li>
          
          <!-- source: http://dribbble.com/shots/1116442-Restaurant-illustration -->
          <li><a href="images/photos/10-big-restaurant.png" title="Restaurant Illustration by Dury"><img src="images/photos/10-big-restaurant-thumbnail.png" alt="restaurant illustration"></a></li>
        </ul>
      </div>
    </div><!-- @end #content -->
  </div><!-- @end #w -->
<script type="text/javascript">
$(function() {
    $('#thumbnails a').lightBox();
});
</script>
</body>
</html>