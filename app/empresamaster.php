<?php

// nombre
// direccion
// nit

?>
<?php if ($empresa->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $empresa->TableCaption() ?></h4> -->
<table id="tbl_empresamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $empresa->TableCustomInnerHtml ?>
	<tbody>
<?php if ($empresa->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $empresa->nombre->FldCaption() ?></td>
			<td<?php echo $empresa->nombre->CellAttributes() ?>>
<span id="el_empresa_nombre">
<span<?php echo $empresa->nombre->ViewAttributes() ?>>
<?php echo $empresa->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($empresa->direccion->Visible) { // direccion ?>
		<tr id="r_direccion">
			<td><?php echo $empresa->direccion->FldCaption() ?></td>
			<td<?php echo $empresa->direccion->CellAttributes() ?>>
<span id="el_empresa_direccion">
<span<?php echo $empresa->direccion->ViewAttributes() ?>>
<?php echo $empresa->direccion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($empresa->nit->Visible) { // nit ?>
		<tr id="r_nit">
			<td><?php echo $empresa->nit->FldCaption() ?></td>
			<td<?php echo $empresa->nit->CellAttributes() ?>>
<span id="el_empresa_nit">
<span<?php echo $empresa->nit->ViewAttributes() ?>>
<?php echo $empresa->nit->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
