<?php

// nomeclatura
// nombre
// idcuenta_mayor_principal

?>
<?php if ($cuenta_mayor_auxiliar->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $cuenta_mayor_auxiliar->TableCaption() ?></h4> -->
<table id="tbl_cuenta_mayor_auxiliarmaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($cuenta_mayor_auxiliar->nomeclatura->Visible) { // nomeclatura ?>
		<tr id="r_nomeclatura">
			<td><?php echo $cuenta_mayor_auxiliar->nomeclatura->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_auxiliar->nomeclatura->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_nomeclatura" class="form-group">
<span<?php echo $cuenta_mayor_auxiliar->nomeclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nomeclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_auxiliar->nombre->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_nombre" class="form-group">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<tr id="r_idcuenta_mayor_principal">
			<td><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
