<?php

include('nexthor_app.php');
include('header.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);
$queryEmpresa="select idempresa id, ticker name from empresa where estado='Activo';";
$queryPeriodoContable="select nombre id, nombre name from periodo_contable where estado='Activo';";
?>

<body>	

	<form id='formulario' method="post"  action="FlujoEfectivo.php">

		<div class="panel panel-info">
			<div class="panel-heading">
				<center>
					Flujo de efectivo de 
					<?php echo fncDesignCombo($queryEmpresa,'idempresa','','','',0);?>
					<?php echo " para el año ".fncDesignCombo($queryPeriodoContable,'anio','','','',0) ?>
					<button name="GenerarReporte" id="GenerarReporte"  type="submit" class="btn btn-info btn-sm">
						<span class="glyphicon glyphicon-search"> </span> Buscar
					</button>
				</center>
			</div>
			<div class="panel-body">
				<div class="container-fluid" id="divFlujoEfectivo">
				<center>
					<?php 
						if (isset($_POST['GenerarReporte'])) {
							$cn = new DBOps('dbadmin','23Nexthor23','contable','nexthordb.cquvmppcukva.us-west-2.rds.amazonaws.com');
							GenerarDatosParaReporte($cn);
							GenerarReporte($cn);
						}
				 
						function GenerarDatosParaReporte($cn){
							$idempresa=$_POST['idempresa'];
							$anio2=$_POST['anio'];
							$anio1=$anio2-1;

							$result= $cn->exec_proc('pr_generar_flujo_efectivo', sprintf('%s,%s,%s', $anio1, $anio2, $idempresa) );
						}

						function GenerarReporte($cn)
						{
							$idempresa=$_POST['idempresa'];
							$anio=$_POST['anio'];
							$query= sprintf('select * from view_estado_flujo_efectivo where idempresa=%s and anio=%s  order by idgrupo_flujo_efectivo,monto desc;',$idempresa,$anio);
							$result= $cn->list_orders($query);

							$numero = mysql_num_rows($result);
							
							echo "<div style='width:500px'>";
							if ($numero> 0){
								$fila = mysql_fetch_assoc($result);			
								echo "<table class='table table-hover'>";
								echo "<thead>";
								echo "<tr class='info'>";
								printf("<td colspan='2'>ESTADO DE FLUJO DE EFECTIVO <br> <b>%s<b></td>", $fila['nombre_empresa']);			
								echo "</tr>";
								echo "</thead>";
								echo "<tbody>";
								$idgrupo = 0;
								$EfectivoFinal = 0;
								$EfectivoInicio = $fila['monto'];
								$TotalPorActividades = 0;
								echo "<tr>";
								printf("<td > %s</td><td class='text-right'>%s</td>",$fila['actividad'],number_format($EfectivoInicio,0) );			
								echo "</tr>";

								while ($fila = mysql_fetch_assoc($result)) {
									if($idgrupo != $fila['idgrupo_flujo_efectivo']){
										if ($TotalPorActividades != 0){
											echo "<tr>";
											printf("<td style='padding-left:5em'>Efectivo neto %s</td><td class='text-right'><b><u>%s</u></b></td>",$fila['actividad'],number_format($TotalPorActividades,0) );			
											echo "</tr>";	
											$TotalPorActividades=0;
										}
										echo "<tr class='alto'>";
										printf("<td colspan='2'><b>%s</b></td>",$fila['actividad']);			
										echo "</tr>";
										$idgrupo=$fila['idgrupo_flujo_efectivo'];
									}
									echo "<tr>";
									printf("<td style='padding-left:3em'> %s</td><td class='text-right'>%s</td>",$fila['subactividad'],number_format($fila['monto'],0) );			
									echo "</tr>";
									$TotalPorActividades+=$fila['monto'];				
									$EfectivoFinal += $fila['monto'];
								}
								if ($TotalPorActividades != 0){
									echo "<tr>";
									printf("<td style='padding-left:5em'>Efectivo neto %s</td><td class='text-right'><b><u>%s</u></b></td>",$fila['actividad'],number_format($TotalPorActividades,0) );			
									echo "</tr>";	
									$TotalPorActividades=0;
								}
								echo "<tr>";
								printf("<td >Incremento Neto Efectivo </td><td class='text-right'>%s</td>",number_format($EfectivoFinal,0) );			
								echo "</tr>";
								echo "<tr class='alto'>";
								printf("<td >Efectivo al final de periodo </td><td class='text-right'>%s</td>",number_format($EfectivoFinal+$EfectivoInicio,0) );			
								echo "</tr>";

								echo "<tbody>";
								echo "</table>";
							}
							echo "<div>";
						}		
					 ?>
				</center>	
					 <script type="text/javascript">
					 	$(document).ready(function(){

					 		$('#formulario').submit(function(event){
					 				var anio = $('#anio').val();
					 				if(anio!='')
							        {
							            return true;
							        }
							        else
							        {
							        	alert('Debe ingresar un año para el flujo de efectivo');
							            return false;
							        }	 		
					 		});

					 	});
					 </script>
				</div>
			</div>
		</div>


  		
	</form>
	
</body>
</html>