<?php

// idtipo_documento
// nombre
// estado
// fecha_insercion

?>
<?php if ($tipo_documento->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $tipo_documento->TableCaption() ?></h4> -->
<table id="tbl_tipo_documentomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $tipo_documento->TableCustomInnerHtml ?>
	<tbody>
<?php if ($tipo_documento->idtipo_documento->Visible) { // idtipo_documento ?>
		<tr id="r_idtipo_documento">
			<td><?php echo $tipo_documento->idtipo_documento->FldCaption() ?></td>
			<td<?php echo $tipo_documento->idtipo_documento->CellAttributes() ?>>
<span id="el_tipo_documento_idtipo_documento">
<span<?php echo $tipo_documento->idtipo_documento->ViewAttributes() ?>>
<?php echo $tipo_documento->idtipo_documento->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tipo_documento->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $tipo_documento->nombre->FldCaption() ?></td>
			<td<?php echo $tipo_documento->nombre->CellAttributes() ?>>
<span id="el_tipo_documento_nombre">
<span<?php echo $tipo_documento->nombre->ViewAttributes() ?>>
<?php echo $tipo_documento->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tipo_documento->estado->Visible) { // estado ?>
		<tr id="r_estado">
			<td><?php echo $tipo_documento->estado->FldCaption() ?></td>
			<td<?php echo $tipo_documento->estado->CellAttributes() ?>>
<span id="el_tipo_documento_estado">
<span<?php echo $tipo_documento->estado->ViewAttributes() ?>>
<?php echo $tipo_documento->estado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($tipo_documento->fecha_insercion->Visible) { // fecha_insercion ?>
		<tr id="r_fecha_insercion">
			<td><?php echo $tipo_documento->fecha_insercion->FldCaption() ?></td>
			<td<?php echo $tipo_documento->fecha_insercion->CellAttributes() ?>>
<span id="el_tipo_documento_fecha_insercion">
<span<?php echo $tipo_documento->fecha_insercion->ViewAttributes() ?>>
<?php echo $tipo_documento->fecha_insercion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
