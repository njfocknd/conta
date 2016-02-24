<?php

// nomeclatura
// nombre
// idgrupo_cuenta

?>
<?php if ($subgrupo_cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $subgrupo_cuenta->TableCaption() ?></h4> -->
<table id="tbl_subgrupo_cuentamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($subgrupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<tr id="r_nomeclatura">
			<td><?php echo $subgrupo_cuenta->nomeclatura->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->nomeclatura->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nomeclatura" class="form-group">
<span<?php echo $subgrupo_cuenta->nomeclatura->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nomeclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->nombre->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nombre" class="form-group">
<span<?php echo $subgrupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<tr id="r_idgrupo_cuenta">
			<td><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->idgrupo_cuenta->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_idgrupo_cuenta" class="form-group">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
