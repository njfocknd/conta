<?php
session_start(); 
ob_start(); 
date_default_timezone_set("America/Guatemala");
error_reporting(0);
header("Cache-Control: private, no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
include "ewcfg12.php";
include "phpfn12.php";
include "userfn12.php";
include ("nexthor/php/app_db_config.php");
require_once('nexthor/php/dbops.php');
require_once('nexthor/php/function.php');
$MyOps = new DBOps($usr_name,$usr_pwd,$target_db,$target_host);

if(isset($_POST['empresa'])&& isset($_POST['periodoContable'])&& isset($_POST['mostrarBalance']))
{
	$queryBalanceGeneral="select idbalance_general id from  balance_general where idempresa = ".$_POST['empresa']." and idperiodo_contable = ".$_POST['periodoContable']." and estado ='Activo' order by idbalance_general desc limit 1;";
	$resBG = $MyOps->list_orders($queryBalanceGeneral);
	$pBalanceGeneral=0;
	if($resBG)
	{
		$bandera = 0;
		while ($row = mysql_fetch_assoc($resBG)) 
		{
			$pBalanceGeneral=$row['id'];
			$queryAcirculante="select sc.idsubgrupo_cuenta id, sc.nombre, bgd.monto from balance_general_detalle bgd
								inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
								where bgd.idbalance_general = ".$row['id']." and bgd.idclase_cuenta = 1 and bgd.idgrupo_cuenta =1;";

			$queryAfijo="select sc.idsubgrupo_cuenta id, sc.nombre, bgd.monto from balance_general_detalle bgd
						inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
						where bgd.idbalance_general = ".$row['id']." and bgd.idclase_cuenta = 1 and bgd.idgrupo_cuenta =2;";

			$queryPcirculante="select sc.idsubgrupo_cuenta id, sc.nombre, bgd.monto from balance_general_detalle bgd
								inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
								where bgd.idbalance_general = ".$row['id']." and bgd.idclase_cuenta = 3 and bgd.idgrupo_cuenta =4;";

			$queryPfijo="select sc.idsubgrupo_cuenta id, sc.nombre, bgd.monto from balance_general_detalle bgd
								inner join subgrupo_cuenta sc on(sc.idsubgrupo_cuenta = bgd.idsubgrupo_cuenta)
								where bgd.idbalance_general = ".$row['id']." and bgd.idclase_cuenta = 3 and bgd.idgrupo_cuenta =5;";
		}
	}
	echo $pBalanceGeneral;
	if($pBalanceGeneral == 0){
		echo '<script>document.getElementById("botonAgregarPeriodo").className = "btn btn-success btn-sm";</script>';
		echo "no hay estado de resultado";
	}
	else{
		echo "<input type='hidden' value='".$pBalanceGeneral."' id='pBalanceGeneral'>";
		//Activo Circulante
		$activoCirculante=""; $notInAC="";
		$resAC = $MyOps->list_orders($queryAcirculante);
		if($resAC)
		{
			while ($rowAC = mysql_fetch_assoc($resAC)) 
			{
				$activoCirculante.="<tr><td>".$rowAC['nombre']."</td><td style='text-align:right;'>".$rowAC['monto']."</td></tr>";
				$notInAC.=$rowAC['id'].",";
			}
		}
		$notInAC=substr($notInAC,0,-1);

		//ActivoFijo
		$activoFijo=""; $notInAF="";
		$resAF = $MyOps->list_orders($queryAfijo);
		if($resAF)
		{
			while ($rowAF = mysql_fetch_assoc($resAF)) 
			{
				$activoFijo.="<tr><td>".$rowAF['nombre']."</td><td  style='text-align:right;'>".$rowAF['monto']."</td></tr>";
				$notInAF.=$rowAF['id'].",";
			}
		}
		$notInAF=substr($notInAF,0,-1);

		//Pasivo Circulante
		$pasivoCirculante=""; $notInPC="";
		$resPC = $MyOps->list_orders($queryPcirculante);
		if($resPC)
		{
			while ($rowPC = mysql_fetch_assoc($resPC)) 
			{
				$pasivoCirculante.="<tr><td>".$rowPC['nombre']."</td><td style='text-align:right;'>".$rowPC['monto']."</td></tr>";
				$notInPC.=$rowPC['id'].",";
			}
		}
		$notInPC=substr($notInPC,0,-1);

		//Pasivo Fijo
		$pasivoFijo=""; $notInPF="";
		$resPF = $MyOps->list_orders($queryPfijo);
		if($resPF)
		{
			while ($rowPF = mysql_fetch_assoc($resPF)) 
			{
				$pasivoFijo.="<tr><td>".$rowPF['nombre']."</td><td style='text-align:right;'>".$rowPF['monto']."</td></tr>";
				$notInPF.=$rowPF['id'].",";
			}
		}
		$notInPF=substr($notInPF,0,-1);
		$querySubGrupoAc="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 1 and estado =1 and idsubgrupo_cuenta not in(".$notInAC.");";
		$querySubGrupoAf="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 4 and estado =1 and idsubgrupo_cuenta not in(".$notInAF.");";
		$querySubGrupoPc="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 2 and estado =1 and idsubgrupo_cuenta not in(".$notInPC.");";
		$querySubGrupoPf="select idsubgrupo_cuenta id, nombre name from subgrupo_cuenta where idgrupo_cuenta = 5 and estado =1 and idsubgrupo_cuenta not in(".$notInPF.");";
	?>
	<div class="row" style="text-align:center;">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Activo Circulante<input type="hidden" value="1" id="inputClaseCuentaActivo" class="form-control"><input type="hidden" value="1" id="inputGrupoCuentaCirculanteA" class="form-control"></div>
				<div class="panel-body">
					<table class="table table-striped">
					<tbody>
						<?php
						 echo $activoCirculante;
						?>
					</tbody>
				</table>
				</div>

				<div class="panel-footer">
					<?php echo fncDesignCombo($querySubGrupoAc,'idsubgrupo_cuentaAc','','','',0) ?>
					<input type="text" value="0.00" id="montoAc" class="form-control">
					<button type="button" class="btn btn-default btn-sm" onclick="fncAgregar(1);">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">Pasivo Circulante<input type="hidden" value="3" id="inputClaseCuentaPasivo" class="form-control"><input type="hidden" value="4" id="inputGrupoCuentaCirculanteP" class="form-control"></div>
				<div class="panel-body">
					<table class="table table-striped">
						<tbody>
							<?php
							 echo $pasivoCirculante;
							?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<?php echo fncDesignCombo($querySubGrupoPc,'idsubgrupo_cuentaPc','','','',0) ?><input type="text" value="0.00" id="montoPc" class="form-control">								
					<button type="button" class="btn btn-default btn-sm" onclick="fncAgregar(2);">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
	<div class="row" style="text-align:center;">
		<div class="col-md-6">
			<div class="panel panel-primary">
				<div class="panel-heading">Activo Fijo<input type="hidden" value="2" id="inputGrupoCuentaFijoA" class="form-control"></div>
				<div class="panel-body">
					<table class="table table-striped">
						<tbody>
							<?php
							 echo $activoFijo;
							?>
						</tbody>
					</table>	
				</div>
				<div class="panel-footer">
					<?php echo fncDesignCombo($querySubGrupoAf,'idsubgrupo_cuentaAf','','','',0) ?><input type="text" value="0.00" id="montoAf" class="form-control">
					<button type="button" class="btn btn-default btn-sm" onclick="fncAgregar(3);">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-danger">
				<div class="panel-heading">Pasivo Fijo<input type="hidden" value="5" id="inputGrupoCuentaFijoP" class="form-control"></div>
				<div class="panel-body">
					<table class="table table-striped">
						<tbody>
							<?php
							 echo $pasivoFijo;
							?>
						</tbody>
					</table>
				</div>
				<div class="panel-footer">
					<?php echo fncDesignCombo($querySubGrupoPf,'idsubgrupo_cuentaPf','','','',0) ?><input type="text" value="0.00" id="montoPf" class="form-control">
					<button type="button" class="btn btn-default btn-sm" onclick="fncAgregar(4);">
						<span class="glyphicon glyphicon-plus"></span>
					</button>
				</div>
			</div>
		</div>
	</div>

<?php
	}										
}
//balance="+balance+"&grupoCuenta="+grupoCuenta+"&claseCuenta="+claseCuenta+"&subGrupoCuenta="+subGrupoCuenta+"&monto="+monto+"&agregar=1";
elseif(isset($_POST['balance'])&& isset($_POST['grupoCuenta'])&& isset($_POST['claseCuenta'])&& isset($_POST['subGrupoCuenta'])&& isset($_POST['monto'])&& isset($_POST['agregar']))
{
	$query = "INSERT INTO balance_general_detalle(idbalance_general, idclase_cuenta, idgrupo_cuenta, idsubgrupo_cuenta, monto) 
						VALUES ('".$_POST["balance"]."','".$_POST["claseCuenta"]."','".$_POST["grupoCuenta"]."','".$_POST["subGrupoCuenta"]."','".$_POST["monto"]."');";
		
			if ($MyOps->insert_to_db($query))
			{
				echo "<script>fncMostrarBalance();</script>";
			}
}
?>