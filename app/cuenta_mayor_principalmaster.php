<?php

// nomenclatura
// nombre
// idsubgrupo_cuenta

?>
<?php if ($cuenta_mayor_principal->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $cuenta_mayor_principal->TableCaption() ?></h4> -->
<table id="tbl_cuenta_mayor_principalmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $cuenta_mayor_principal->TableCustomInnerHtml ?>
	<tbody>
<?php if ($cuenta_mayor_principal->nomenclatura->Visible) { // nomenclatura ?>
		<tr id="r_nomenclatura">
			<td><?php echo $cuenta_mayor_principal->nomenclatura->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_principal->nomenclatura->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nomenclatura">
<span<?php echo $cuenta_mayor_principal->nomenclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_principal->nomenclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta_mayor_principal->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $cuenta_mayor_principal->nombre->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_principal->nombre->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nombre">
<span<?php echo $cuenta_mayor_principal->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_principal->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($cuenta_mayor_principal->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
		<tr id="r_idsubgrupo_cuenta">
			<td><?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->FldCaption() ?></td>
			<td<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_idsubgrupo_cuenta">
<span<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->ViewAttributes() ?>>
<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
