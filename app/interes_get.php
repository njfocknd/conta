
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
                    "primer_dato": '.round((((floatval($_POST["capital"])*floatval ($x)*floatval($_POST["tasa"]))/100)+floatval($_POST["capital"])),2).',
                    "segundo_dato": '.round((floatval($_POST["capital"])*(pow(1+((floatval($_POST["tasa"]))/100),floatval($x)))),2).',
                },';
	}
	echo '		{
                    "year": '.$x.',
                    "primer_dato": '.round((((floatval($_POST["capital"])*floatval ($x)*floatval($_POST["tasa"]))/100)+floatval($_POST["capital"])),2).',
                    "segundo_dato": '.round((floatval($_POST["capital"])*(pow(1+((floatval($_POST["tasa"]))/100),floatval($_POST["periodo"])))),2).',
                }
            ];
	maximo = '.((floatval($_POST["capital"])*(pow(1+((floatval($_POST["tasa"]))/100),floatval($_POST["periodo"]))))).';
	minimo = '.(floatval($_POST["capital"])).';</script>';
?>
 <script>
            
			
            

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "year";
                chart.startDuration = 0.5;
                chart.balloon.color = "#000000";

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.fillAlpha = 1;
                categoryAxis.fillColor = "#FAFAFA";
                categoryAxis.gridAlpha = 0;
                categoryAxis.axisAlpha = 0;
                categoryAxis.gridPosition = "start";
                categoryAxis.position = "top";

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "";
                valueAxis.dashLength = 5;
                valueAxis.axisAlpha = 0;
                valueAxis.minimum = minimo;
                valueAxis.maximum = maximo;
                valueAxis.integersOnly = true;
                valueAxis.gridCount = 10;
                valueAxis.reversed = false; // this line makes the value axis reversed
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // primer_dato graph
                var graph = new AmCharts.AmGraph();
                graph.title = "Interés Simple";
                graph.valueField = "primer_dato";
                graph.balloonText = "Interés Simple a [[category]] años: [[value]]";
                graph.lineAlpha = 1;
                graph.bullet = "round";
                chart.addGraph(graph);

                // segundo_dato graph
                var graph = new AmCharts.AmGraph();
                graph.title = "Interés Compuesto";
                graph.valueField = "segundo_dato";
                graph.balloonText = "Interés Compuesto [[category]] años: [[value]]";
                graph.bullet = "round";
                chart.addGraph(graph);

           

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorPosition = "mouse";
                chartCursor.zoomable = false;
                chartCursor.cursorAlpha = 0;
                chart.addChartCursor(chartCursor);

                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.useGraphSettings = true;
                chart.addLegend(legend);

                // WRITE
                chart.write("chartdiv");
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
						<td>Valor Presente</td>
						<td align="right">'.number_format($_POST["capital"],2).'</td>
					</tr>
					<tr>
						<td>Rendimiento</td>
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
	$interes_compuesto = ((floatval($_POST["capital"])*(pow(1+((floatval($_POST["tasa"]))/100),floatval($_POST["periodo"]))))-floatval($_POST["capital"]));
	echo '<center><div class="panel panel-success">
			  <div class="panel-heading">
				Interés Compuesto
			  </div>
			  <div class="panel-body">
				<table style="width:90%;">
					<tr>
						<td>Valor Presente</td>
						<td align="right">'.number_format($_POST["capital"],2).'</td>
					</tr>
					<tr>
						<td>Rendimiento</td>
						<td align="right">'.number_format($interes_compuesto,2).'</td>
					</tr>
					<tr>
						<td>Valor Futuro</td>
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

