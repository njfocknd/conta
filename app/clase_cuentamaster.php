<?php

// nombre
// nomenclatura
// estado

?>
<?php if ($clase_cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $clase_cuenta->TableCaption() ?></h4> -->
<table id="tbl_clase_cuentamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($clase_cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $clase_cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $clase_cuenta->nombre->CellAttributes() ?>>
<span id="el_clase_cuenta_nombre" class="form-group">
<span<?php echo $clase_cuenta->nombre->ViewAttributes() ?>>
<?php echo $clase_cuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($clase_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<tr id="r_nomenclatura">
			<td><?php echo $clase_cuenta->nomenclatura->FldCaption() ?></td>
			<td<?php echo $clase_cuenta->nomenclatura->CellAttributes() ?>>
<span id="el_clase_cuenta_nomenclatura" class="form-group">
<span<?php echo $clase_cuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $clase_cuenta->nomenclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($clase_cuenta->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $clase_cuenta->estado->FldCaption() ?></td>
			<td<?php echo $clase_cuenta->estado->CellAttributes() ?>>
<span id="el_clase_cuenta_estado" class="form-group">
<span<?php echo $clase_cuenta->estado->ViewAttributes() ?>>
<?php echo $clase_cuenta->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
