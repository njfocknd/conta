<?php

// nombre
// saldo
// idempresa
// idempleado
// idcuenta

?>
<?php if ($caja_chica->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $caja_chica->TableCaption() ?></h4> -->
<table id="tbl_caja_chicamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($caja_chica->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $caja_chica->nombre->FldCaption() ?></td>
			<td<?php echo $caja_chica->nombre->CellAttributes() ?>>
<span id="el_caja_chica_nombre" class="form-group">
<span<?php echo $caja_chica->nombre->ViewAttributes() ?>>
<?php echo $caja_chica->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica->saldo->Visible) { // saldo ?>
		<tr id="r_saldo">
			<td><?php echo $caja_chica->saldo->FldCaption() ?></td>
			<td<?php echo $caja_chica->saldo->CellAttributes() ?>>
<span id="el_caja_chica_saldo" class="form-group">
<span<?php echo $caja_chica->saldo->ViewAttributes() ?>>
<?php echo $caja_chica->saldo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $caja_chica->idempresa->FldCaption() ?></td>
			<td<?php echo $caja_chica->idempresa->CellAttributes() ?>>
<span id="el_caja_chica_idempresa" class="form-group">
<span<?php echo $caja_chica->idempresa->ViewAttributes() ?>>
<?php echo $caja_chica->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica->idempleado->Visible) { // idempleado ?>
		<tr id="r_idempleado">
			<td><?php echo $caja_chica->idempleado->FldCaption() ?></td>
			<td<?php echo $caja_chica->idempleado->CellAttributes() ?>>
<span id="el_caja_chica_idempleado" class="form-group">
<span<?php echo $caja_chica->idempleado->ViewAttributes() ?>>
<?php echo $caja_chica->idempleado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica->idcuenta->Visible) { // idcuenta ?>
		<tr id="r_idcuenta">
			<td><?php echo $caja_chica->idcuenta->FldCaption() ?></td>
			<td<?php echo $caja_chica->idcuenta->CellAttributes() ?>>
<span id="el_caja_chica_idcuenta" class="form-group">
<span<?php echo $caja_chica->idcuenta->ViewAttributes() ?>>
<?php echo $caja_chica->idcuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
