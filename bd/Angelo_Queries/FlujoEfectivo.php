<?php
	require_once('php/dbops.php');
	$cn = new DBOps('dbadmin','23Nexthor23','contable','nexthordb.cquvmppcukva.us-west-2.rds.amazonaws.com');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    	table tr td{
   			padding:0px;
		}
    </style>
</head>
<body>	
	<?php 	
		#$result= $cn->select_data('select * from view_estado_flujo_efectivo where idempresa =2 and anio=2015 order by idgrupo_flujo_efectivo,monto desc;');
		$result= $cn->list_orders('select * from view_estado_flujo_efectivo where idempresa =2 and anio=2015 order by idgrupo_flujo_efectivo,monto desc;');

		$numero = mysql_num_rows($result);
		
		echo "<div style='width:50%'>";
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
			printf("<td > %s</td><td class='text-right'>%s</td>",$fila['actividad'],$EfectivoInicio);			
			echo "</tr>";

			while ($fila = mysql_fetch_assoc($result)) {
				if($idgrupo != $fila['idgrupo_flujo_efectivo']){
					if ($TotalPorActividades != 0){
						echo "<tr>";
						printf("<td style='padding-left:5em'>Efectivo neto %s</td><td class='text-right'><b><u>%s</u></b></td>",$fila['actividad'],$TotalPorActividades);			
						echo "</tr>";	
						$TotalPorActividades=0;
					}
					echo "<tr class='alto'>";
					printf("<td colspan='2'><b>%s</b></td>",$fila['actividad']);			
					echo "</tr>";
					$idgrupo=$fila['idgrupo_flujo_efectivo'];
				}
				echo "<tr>";
				printf("<td style='padding-left:3em'> %s</td><td class='text-right'>%s</td>",$fila['subactividad'],$fila['monto']);			
				echo "</tr>";
				$TotalPorActividades+=$fila['monto'];				
				$EfectivoFinal += $fila['monto'];
			}
			if ($TotalPorActividades != 0){
				echo "<tr>";
				printf("<td style='padding-left:5em'>Efectivo neto %s</td><td class='text-right'><b><u>%s</u></b></td>",$fila['actividad'],$TotalPorActividades);			
				echo "</tr>";	
				$TotalPorActividades=0;
			}
			echo "<tr>";
			printf("<td >Incremento Neto Efectivo </td><td class='text-right'>%s</td>",$EfectivoFinal);			
			echo "</tr>";
			echo "<tr class='alto'>";
			printf("<td >Efectivo al final de periodo </td><td class='text-right'>%s</td>",$EfectivoFinal+$EfectivoInicio);			
			echo "</tr>";

			echo "<tbody>";
			echo "</table>";

		}
		echo "<div>";

		
	 ?>
</body>
</html>