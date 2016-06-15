
<?php
include ("nexthor_app.php");
?> <!-- dataTables -->
    <script type="text/javascript" src="nexthor/libs/DataTables/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/media/js/dataTables.jqueryui.js"></script>
    <link rel="stylesheet" type="text/css" href="nexthor/libs/DataTables/media/css/jquery.dataTables.css">
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/dataTables.buttons.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/buttons.colVis.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/buttons.flash.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/jszip/jszip-2.5.min.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/buttons.html5.js"></script>
    <script type="text/javascript" src="nexthor/libs/DataTables/extensions/Buttons/js/buttons.print.js"></script>
    <link rel="stylesheet" type="text/css" href="nexthor/libs/DataTables/extensions/Buttons/css/buttons.dataTables.css">
<script type="text/javascript" language="javascript" class="init">
$(document).ready(function() {
    var lastIdx = null;
    var table = $('#myTable').DataTable( {
        dom: 'Bfrtip',
		responsive: true,
		bFilter: false,
		buttons: [
			{
                extend: 'excelFlash',
                text: 'Generar Excel',
                exportOptions: {
                    columns: ':visible'
                },
                title: 'Comparar Facturas'
            }
		],
		scrollY:        '50vh',
		scrollCollapse: true,
		paging:         false,
		"oLanguage": 
		{
			"sLengthMenu": "Ver _MENU_ registros por pagina",
			"sZeroRecords": "Lo sentimos, la informacion que busca no ha sido encontrada",
			"sInfo": "Mostrando del _START_ al _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 of 0 registros",
			"sInfoFiltered": "(Filtrando de _MAX_ total registros)",
			"sSearch": "Buscar:",
			"oPaginate": 
			{
				"sFirst": "Primero",
				"sLast": "Ultimo",
				"sNext": "Siguiente",
				"sPrevious": "Anterior"
			}
		},
    } );
 
    $('a.toggle-vis').on( 'click', function (e) {
        e.preventDefault();
 
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
 
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );
} );
	</script>
<?php
//funciones dedicadas php
function fncSetDataToArray($row, &$arrayData, $option)
	{
	switch($option)
		{
		case 0:
			$id=$row["id"];
			$arrayData['detalle'][$id]["corresponsal"]=$row["corresponsal"];
			$arrayData['detalle'][$id]["cantidad"]=$row["cantidad"];
			$arrayData['detalle'][$id]["region"]=$row["region"];
			$arrayData['detalle'][$id]["variable"]=$row["variable"];
			$arrayData['total']["cantidad"]+=$row["cantidad"];
			$arrayData['total']["variable"]+=$row["variable"];
			$arrayData['modo'] = 0;
			break;
		case 1:
			$id=$row["id"];
			$arrayData['detalle'][$id]["cantidad"]=$row["cantidad"];
			$arrayData['detalle'][$id]["pivote"]=$row["pivote"];
			$arrayData['detalle'][$id]["variable"]=$row["variable"];
			$arrayData['total']["cantidad"]+=$row["cantidad"];
			$arrayData['total']["variable"]+=$row["variable"];
			$arrayData['modo'] = 1;
			$arrayData['group_by'] = 'Región';
			break;
		case 2:
			$id=$row["id"];
			$arrayData['detalle'][$id]["cantidad"]=$row["cantidad"];
			$arrayData['detalle'][$id]["pivote"]=$row["pivote"];
			$arrayData['detalle'][$id]["variable"]=$row["variable"];
			$arrayData['total']["cantidad"]+=$row["cantidad"];
			$arrayData['total']["variable"]+=$row["variable"];
			$arrayData['modo'] = 1;
			$arrayData['group_by'] = 'Sección';
			break;
		case 3:
			$id=$row["id"];
			$arrayData['detalle'][$id]["cantidad"]=$row["cantidad"];
			$arrayData['detalle'][$id]["pivote"]=$row["pivote"];
			$arrayData['detalle'][$id]["variable"]=$row["variable"];
			$arrayData['total']["cantidad"]+=$row["cantidad"];
			$arrayData['total']["variable"]+=$row["variable"];
			$arrayData['modo'] = 1;
			$arrayData['group_by'] = 'Tipo de Notas';
			break;
		case 4:
			$id=$row["id"];
			$id2=$row["id_article"];
			$arrayData['detalle'][$id]['nota'][$id2]['FechaCalificacion']=$row["FechaCalificacion"];
			$arrayData['detalle'][$id]['nota'][$id2]["id_article"]=$row["id_article"];
			$arrayData['detalle'][$id]['nota'][$id2]["titulo"]=$row["titulo"];
			$arrayData['detalle'][$id]['nota'][$id2]["region"]=$row["region"];
			$arrayData['detalle'][$id]['nota'][$id2]["NombreMunicipio"]=$row["NombreMunicipio"];
			$arrayData['detalle'][$id]['nota'][$id2]["corresponsal"]=$row["corresponsal"];
			$arrayData['detalle'][$id]['nota'][$id2]["CalificadaPor"]=$row["CalificadaPor"];
			$arrayData['detalle'][$id]['nota'][$id2]["NombreDepartamento"]=$row["NombreDepartamento"];
			$arrayData['detalle'][$id]['nota'][$id2]["calificacion"]=$row["calificacion"];
			$arrayData['detalle'][$id]['nota'][$id2]["variable"]=$row["variable"];
			$arrayData['detalle'][$id]['variable']+=$row["variable"];
			$arrayData['variable']+=$row["variable"];
			$arrayData['detalle'][$id]['FechaCalificacion']=$row["FechaCalificacion"];
			$arrayData['modo'] = 2;
			break;
		}
	}

function fncHTML($arrayData){
	global $arrayMes;
	if($arrayData['modo'] == 0){
		echo "<table id='myTable' class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>Región</th>
						<th>Corresponsal</th>
						<th>Notas</th>
						<th>Variable</th>
					</tr>
				</thead>
				<tbody>";
		$x=0;$y=0;$css_td = " ";
		foreach ($arrayData['detalle'] as $key => $value) {
			echo "<tr align='right' >
					<td align='left'>".$value['region']."</td>
					<td align='left'>".$value['corresponsal']."</td>
					<td>".number_format($value['cantidad'],0)."</td>
					<td>".number_format($value['variable'],2)."</td>
				  </tr>";
		}
		echo "  </tbody>
				<tfoot>
					<tr>
						<td></td>
						<td>Totales</td>
						<td align='right' >".$arrayData['total']['cantidad']."</td>
						<td align='right' >".$arrayData['total']['variable']."</td>
					</tr>
				</tfoot>
			</table>";
	}
	elseif($arrayData['modo'] == 1){
		echo "<table id='myTable' class='table table-striped table-bordered'>
				<thead>
					<tr>
						<th>".$arrayData['group_by']."</th>
						<th>Notas</th>
						<th>Variable</th>
					</tr>
				</thead>
				<tbody>";
		$x=0;$y=0;$css_td = " ";
		foreach ($arrayData['detalle'] as $key => $value) {
			echo "<tr align='right' >
					<td align='left'>".$value['pivote']."</td>
					<td>".number_format($value['cantidad'],0)."</td>
					<td>".number_format($value['variable'],2)."</td>
				  </tr>";
		}
		echo "  </tbody>
				<tfoot>
					<tr>
						<td>Totales</td>
						<td align='right' >".$arrayData['total']['cantidad']."</td>
						<td align='right' >".$arrayData['total']['variable']."</td>
					</tr>
				</tfoot>
			  </table>";
	}
	elseif($arrayData['modo'] == 2){
		echo "<table id='myTable' class='table table-bordered'>
				<thead>
					<tr>
						<th>Fecha de Calificación</th>
						<th>No. Artículo</th>
						<th>Nota</th>
						<th>Corresponsal</th>
						<th>Región</th>
						<th>Departamento</th>
						<th>Municipio</th>
						<th>Cal.</th>
						<th>Valor</th>
						<th>Redactor</th>
					</tr>
				</thead>
				<tbody>";
		$x=0;$y=0;$css_td = " ";
		foreach ($arrayData['detalle'] as $key => $value) {
			foreach ($value['nota'] as $key2 => $value2) {
				echo "<tr align='right' >
					<td align='left'>".$value2['FechaCalificacion']."</td>
					<td align='left'>".$value2['id_article']."</td>
					<td align='left'>".$value2['titulo']."</td>
					<td align='left'>".$value2['corresponsal']."</td>
					<td align='left'>".$value2['region']."</td>
					<td align='left'>".$value2['NombreDepartamento']."</td>
					<td align='left'>".$value2['NombreMunicipio']."</td>
					<td align='left'>".$value2['calificacion']."</td>
					<td>".number_format($value2['variable'],2)."</td>
					<td align='left'>".$value2['CalificadaPor']."</td>
				  </tr>";
			}
			echo "<tr align='right' class='success'>
					<td align='left'>".$value['FechaCalificacion']."</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>Subtotal</td>
					<td>".number_format($value['variable'],2)."</td>
					<td></td>
				  </tr>";
		}
		echo "  </tbody>
				<tfoot>
					<tr align='right' >
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td>Total</td>
						<td>".number_format($arrayData['variable'],2)."</td>
						<td></td>
					</tr>
				</tfoot>
			  </table>";
	}
	
}

	
	 
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);

$ulevel=CurrentUserLevel();
if($ulevel == -1)
	{
	if (isset($_POST["repCalificacion"])&&isset($_POST["grupo"]))
		{
		$filter=" ";
		if ($_POST["grupo"]==0){
			$query="select count(*) cantidad,u.region,concat(u.nombres,' ',u.apellidos) corresponsal,sum(valor) variable, u.id_user id
					from sumario_colaboradores sc, user u 
					where u.id_user = sc.id_user and sc.publicado = 1 and u.activo=1 
						and sc.fecha_calificacion between ".$_POST['date1']." and ".$_POST['date2']."
					group by concat(u.nombres,' ',u.apellidos),u.region 
					order by u.region,concat(u.nombres,' ',u.apellidos);";
		}
		elseif($_POST["grupo"]==1){
			$query="select count(*) cantidad,u.region pivote, sum(valor) variable, u.region id
					from sumario_colaboradores sc, user u 
					where u.id_user = sc.id_user and sc.publicado = 1 and u.activo=1 
						and sc.fecha_calificacion between ".$_POST['date1']." and ".$_POST['date2']."
					group by u.region 
					order by u.region;";
		}
		elseif($_POST["grupo"]==2){
			$query="select count(*) cantidad, sc.seccion pivote, sum(valor) variable, sc.seccion id
					from sumario_colaboradores sc, user u 
					where u.id_user = sc.id_user and sc.publicado = 1 and u.activo=1 
						and sc.fecha_calificacion between ".$_POST['date1']." and ".$_POST['date2']."
					group by sc.seccion
					order by sc.seccion;";
		}
		elseif($_POST["grupo"]==3){
			$query="select count(*) cantidad, sc.calificacion pivote, sum(valor) variable, sc.calificacion id
					from sumario_colaboradores sc, user u
					where u.id_user = sc.id_user and sc.publicado = 1 and u.activo=1 
						and sc.fecha_calificacion between ".$_POST['date1']." and ".$_POST['date2']."
					group by sc.calificacion
					order by sc.calificacion;";
		}
		elseif($_POST["grupo"]==4){
			$query="select DATE_FORMAT(sc.fecha_calificacion, '%Y%m%d') id, DATE_FORMAT(sc.fecha_calificacion, '%d/%m/%Y') AS FechaCalificacion, a.id_article, a.titulo, u.region,concat(u.nombres,' ',u.apellidos) AS corresponsal,
				sc.user_id_verificado_redactor, sc.user_id_verificado_jefe, m.nombre AS NombreMunicipio, d.nombre AS NombreDepartamento, sc.calificacion, concat(u2.nombres,' ',u2.apellidos) AS CalificadaPor,
				sc.valor variable
			from user u
				join sumario_colaboradores sc on u.id_user = sc.id_user 
				join article a on sc.id_article = a.id_article 
				join municipio m on a.idmunicipio = m.idmunicipio 
				join departamento d on m.iddepartamento = d.iddepartamento 
				left join user u2 on u2.id_user = sc.user_id_verificado_redactor
			where sc.publicado = 1 and u.activo=1 and sc.fecha_calificacion between ".$_POST['date1']." and ".$_POST['date2']." 
			order by FechaCalificacion;";
		}
		fncExecuteQuery($MyOps, $query, $arrayData, $_POST["grupo"]);
		if(count($arrayData)>0)
			{
			fncHTML($arrayData);						
			}
		else 
			{
			include('nexthor/php/no_data.php');
			}
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

