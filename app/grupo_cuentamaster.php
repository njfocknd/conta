<?php

// nomeclatura
// nombre
// idclase_cuenta

?>
<?php if ($grupo_cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $grupo_cuenta->TableCaption() ?></h4> -->
<table id="tbl_grupo_cuentamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($grupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<tr id="r_nomeclatura">
			<td><?php echo $grupo_cuenta->nomeclatura->FldCaption() ?></td>
			<td<?php echo $grupo_cuenta->nomeclatura->CellAttributes() ?>>
<span id="el_grupo_cuenta_nomeclatura" class="form-group">
<span<?php echo $grupo_cuenta->nomeclatura->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nomeclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $grupo_cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $grupo_cuenta->nombre->CellAttributes() ?>>
<span id="el_grupo_cuenta_nombre" class="form-group">
<span<?php echo $grupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<tr id="r_idclase_cuenta">
			<td><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?></td>
			<td<?php echo $grupo_cuenta->idclase_cuenta->CellAttributes() ?>>
<span id="el_grupo_cuenta_idclase_cuenta" class="form-group">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<?php echo $grupo_cuenta->idclase_cuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
