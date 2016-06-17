<?php
include('nexthor_app.php');
include('header.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$now = date (Ymd);
$diaUno = date("01/m/Y", strtotime("$now +0 day"));
$diaDos = date("d/m/Y", strtotime("$now +0 day"));
?>
<script type='text/javascript'src="nexthor/js/nexthor_js.js" ></script>
<script>
function fncMostrar(){
	div=document.getElementById("div_resultado");
	$(div).html("<img src='nexthor/image/loading.gif' align='center'>");
	div2=document.getElementById("div_resultado2");
	//$(div2).html("<img src='nexthor/image/loading.gif' align='center'>");
	div3=document.getElementById("div_resultado3");
	$(div3).html("<img src='nexthor/image/loading.gif' align='center'>");
	capital=document.getElementById('capital').value;
	periodo=document.getElementById('periodo').value;
	tasa=document.getElementById('tasa').value;
	str_param="capital="+capital+"&periodo="+periodo+"&tasa="+tasa+"&interesCompuesto=1";
	ajax_dynamic_div("POST",'amortizacion_get.php',str_param,div);
	str_param2="capital="+capital+"&periodo="+periodo+"&tasa="+tasa+"&interesCompuesto=1";
	//ajax_dynamic_div("POST",'valor_presente_get.php',str_param2,div2);
	str_param3="capital="+capital+"&periodo="+periodo+"&tasa="+tasa+"&grafica=1";
	ajax_dynamic_div("POST",'amortizacion_get.php',str_param3,div3);
}
</script>
<body>
	<form name="nexthor" id="nexthor" >
		
		<div class="panel panel-primary">

			<div class="panel-body">
				<center>
				<div class="panel panel-info">
					<div class="panel-heading">
						Interés Simple
					</div>
					<div class="panel-body">
						<table style="width:100%;">
							<tr>
								<td>
									Inversión:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									Año 1:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									Año 2:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									Año 3:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									Año 4:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									Año 5:
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
								<td>
									<input type="text" name="capital" id="capital" value="5000" class="form-control" style = 'width:100px;text-align:right'>
								</td>
							</tr>
							<tr>
								<td>
									<button type="button" class="btn btn-success" onclick = "fncMostrar();">
										<span class="glyphicon glyphicon-search"></span> Calcular
									</button>
								</td>
							</tr>
						</table>
					</div>
				</center>
			
				<table style="width:100%;">
					<tr>
						<td width="20%">
							<div id='div_resultado' ></div>
						</td>
						<td width="2%">
							
						</td>
						<td width="55%" rowspan = 2>
							<div id='div_resultado3' ></div>
						</td>
					</tr>
					<tr>
						<td width="20%">
							<div id='div_resultado2' ></div>
						</td>
						<td width="2%">
							
						</td>
					</tr>
				</table>
			</div>
		</div>
	</form>
</body>
