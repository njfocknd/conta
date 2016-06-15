
<?php
include ("nexthor_app.php");
?> 
	<link rel="stylesheet" href="style.css" type="text/css">
    <script src="nexthor/libs/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="nexthor/libs/amcharts/serial.js" type="text/javascript"></script>
<?php
	echo  '<script>var chart;var chartData = [';
	
	for ($x = 1; $x < floatval($_POST["periodo"]); $x++)
	{
		echo '{
                    "year": '.$x.',
                    "primer_dato": '.round((floatval($_POST["capital"])/(pow(1+((floatval($_POST["tasa"]))/100),floatval($x)))),2).',
                },';
	}
	echo '		{
                    "year": '.$x.',
                    "primer_dato": '.round((floatval($_POST["capital"])/(pow(1+((floatval($_POST["tasa"]))/100),floatval($_POST["periodo"])))),2).',
                }
            ];</script>';
?>
 <script>
            
      
           AmCharts.makeChart("chartdiv", {
               type: "serial",
               dataProvider: chartData,
               marginTop: 10,
               categoryField: "year",
               categoryAxis: {
                   gridAlpha: 0.07,
                   axisColor: "#DADADA",
                   startOnAxis: true,
                   guides: []
               },
               valueAxes: [{
                   stackType: "regular",
                   gridAlpha: 0.07,
                   title: "Valor Presente"
               }],

               graphs: [{
                   type: "line",
                   title: "Valor Presente",
                   valueField: "primer_dato",
                   lineAlpha: 0,
                   fillAlphas: 0.6,
                   balloonText: "<img src='nexthor/image/money.png' style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px;'><span style='font-size:14px; color:#000000;'><b>[[value]]</b></span>"
               }],
               legend: {
                   position: "bottom",
                   valueText: "[[value]]",
                   valueWidth: 1000,
                   valueAlign: "left",
                   equalWidths: false,
                   periodValueText: "total: [[value.sum]]"
               },
               chartCursor: {
                   cursorAlpha: 0
               },
               chartScrollbar: {
                   color: "FFFFFF"
               }

           });

        </script>
<?php

function fncGrafica(){
	echo ' <div id="chartdiv" style="width: 100%; height: 400px;"></div>';
}
function fncCalcularInteresSimple(){
	$interes_simple = (floatval($_POST["capital"])*floatval ($_POST["periodo"])*floatval($_POST["tasa"]))/100;
	echo '<center><div class="panel panel-info">
			  <div class="panel-heading">
				Interés Simple
			  </div>
			  <div class="panel-body">
				<table style="width:90%;">
					<tr>
						<td>Inversión</td>
						<td align="right">'.number_format($_POST["capital"],2).'</td>
					</tr>
					<tr>
						<td>Interés</td>
						<td align="right">'.number_format($interes_simple,2).'</td>
					</tr>
					<tr>
						<td>Valor Futuro</td>
						<td align="right">'.number_format(($_POST["capital"]+$interes_simple),2).'</td>
					</tr>
				</table>
			  </div>
			</div></center>';
	
}
function fncCalcularInteresCompuesto(){
	$interes_compuesto = ((floatval($_POST["capital"])/(pow(1+((floatval($_POST["tasa"]))/100),floatval($_POST["periodo"]))))-floatval($_POST["capital"]));
	echo '<center><div class="panel panel-success">
			  <div class="panel-heading">
				Valor Presente
			  </div>
			  <div class="panel-body">
				<table style="width:90%;">
					<tr>
						<td>Valor Futuro</td>
						<td align="right">'.number_format($_POST["capital"],2).'</td>
					</tr>
					<tr>
						<td>Descuento</td>
						<td align="right">'.number_format($interes_compuesto,2).'</td>
					</tr>
					<tr>
						<td>Valor Presente</td>
						<td align="right">'.number_format(($_POST["capital"]+$interes_compuesto),2).'</td>
					</tr>
				</table>
			  </div>
			</div></center>';
	
}


if(true)
{
	if (isset($_POST["capital"])&&isset($_POST["periodo"])&&isset($_POST["tasa"])&&isset($_POST["interesSimple"]))
	{
		fncCalcularInteresSimple();						
	}
	if (isset($_POST["capital"])&&isset($_POST["periodo"])&&isset($_POST["tasa"])&&isset($_POST["interesCompuesto"]))
	{
		fncCalcularInteresCompuesto();						
	}
	if (isset($_POST["capital"])&&isset($_POST["periodo"])&&isset($_POST["tasa"])&&isset($_POST["grafica"]))
	{
		fncGrafica();						
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

