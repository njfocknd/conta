
<?php
include ("nexthor_app.php");
?> 
	<link rel="stylesheet" href="style.css" type="text/css">
    <script src="nexthor/libs/amcharts/amcharts.js" type="text/javascript"></script>
    <script src="nexthor/libs/amcharts/serial.js" type="text/javascript"></script>
<?php
	echo  '<script>var chart;var chartData = [';
	$amortizacion = floatval($_POST["capital"])/((1-(1/pow((1+(floatval($_POST["tasa"])/100)),floatval($_POST["periodo"]))))/(floatval($_POST["tasa"])/100));
	$deuda = $_POST["capital"];
	for ($x = 1; $x < floatval($_POST["periodo"]); $x++)
	{
		$interes = $deuda*(floatval($_POST["tasa"])/100);
		$capital = $amortizacion-$interes;
		$deuda = $deuda -$capital;
		echo '{
                    "year": '.$x.',
                    "primer_dato": '.round($interes,2).', 
					"segundo_dato": '.round($capital,2).',
                },';
	}
	$interes = $deuda*(floatval($_POST["tasa"])/100);
	$capital = $amortizacion-$interes;
	$deuda = $deuda -$amortizacion;
	echo '		{
                    "year": '.$x.',
                    "primer_dato": '.round(($interes),2).',
					"segundo_dato": '.round($capital,2).',
                }
            ];</script>';
?>
 <script>
            
                  AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();

                chart.dataProvider = chartData;
                chart.categoryField = "year";

                chart.addTitle("Años", 15);

                // AXES
                // Category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.gridAlpha = 0.07;
                categoryAxis.axisColor = "#DADADA";
                categoryAxis.startOnAxis = true;

                // Value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.title = "porcentaje"; // this line makes the chart "stacked"
                valueAxis.stackType = "100%";
                valueAxis.gridAlpha = 0.07;
                chart.addValueAxis(valueAxis);

                // GRAPHS
                // first graph
                var graph = new AmCharts.AmGraph();
                graph.type = "line"; // it's simple line graph
                graph.title = "Interés pagado";
                graph.valueField = "primer_dato";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.6; // setting fillAlphas to > 0 value makes it area graph
                graph.balloonText = "<img src='nexthor/image/money.png' style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px;'><span style='font-size:14px; color:#000000;'>Interés pagado <b>[[value]]</b></span>";
                chart.addGraph(graph);

                // second graph
                graph = new AmCharts.AmGraph();
                graph.type = "line";
                graph.title = "Capital pagado";
                graph.valueField = "segundo_dato";
                graph.lineAlpha = 0;
                graph.fillAlphas = 0.6;
                graph.balloonText = "<img src='nexthor/image/money.png' style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px;'><span style='font-size:14px; color:#000000;'>Capital pagado <b>[[value]]</b></span>";
                chart.addGraph(graph);


                // LEGEND
                var legend = new AmCharts.AmLegend();
                legend.align = "center";
                legend.valueText = "[[value]] ([[percents]]%)";
                legend.valueWidth = 100;
                legend.valueAlign = "left";
                legend.equalWidths = false;
                legend.periodValueText = "total: [[value.sum]]"; // this is displayed when mouse is not over the chart.
                chart.addLegend(legend);

                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.zoomable = false; // as the chart displayes not too many values, we disabled zooming
                chartCursor.cursorAlpha = 0;
                chartCursor.valueZoomable = true;
                chartCursor.pan = true;
                chart.addChartCursor(chartCursor);

                //  VALUE SCROLLBAR
                chart.valueScrollbar = new AmCharts.ChartScrollbar();

                // WRITE
                chart.write("chartdiv");
            });

        </script>
<?php

function fncGrafica(){
	echo ' <div id="chartdiv" style="width: 100%; height: 400px;"></div>';
}
function fncCalcularInteresSimple(){
	$interes_simple = (floatval($_POST["capital"])*floatval($_POST["tasa"]))/(1-(pow((1+floatval($_POST["tasa"])),(-1*floatval($_POST["periodo"])))));
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
	$interes_compuesto = floatval($_POST["capital"])/((1-(1/pow((1+(floatval($_POST["tasa"])/100)),floatval($_POST["periodo"]))))/(floatval($_POST["tasa"])/100));
	echo '<center><div class="panel panel-success">
			  <div class="panel-heading">
				Amortización fija
			  </div>
			  <div class="panel-body">
				'.number_format($interes_compuesto,2).'
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

