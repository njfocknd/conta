<?php

// nombre
// fecha_inicio
// fecha_fin
// estatus

?>
<?php if ($periodo_contable->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $periodo_contable->TableCaption() ?></h4> -->
<table id="tbl_periodo_contablemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $periodo_contable->TableCustomInnerHtml ?>
	<tbody>
<?php if ($periodo_contable->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $periodo_contable->nombre->FldCaption() ?></td>
			<td<?php echo $periodo_contable->nombre->CellAttributes() ?>>
<span id="el_periodo_contable_nombre">
<span<?php echo $periodo_contable->nombre->ViewAttributes() ?>>
<?php echo $periodo_contable->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($periodo_contable->fecha_inicio->Visible) { // fecha_inicio ?>
		<tr id="r_fecha_inicio">
			<td><?php echo $periodo_contable->fecha_inicio->FldCaption() ?></td>
			<td<?php echo $periodo_contable->fecha_inicio->CellAttributes() ?>>
<span id="el_periodo_contable_fecha_inicio">
<span<?php echo $periodo_contable->fecha_inicio->ViewAttributes() ?>>
<?php echo $periodo_contable->fecha_inicio->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($periodo_contable->fecha_fin->Visible) { // fecha_fin ?>
		<tr id="r_fecha_fin">
			<td><?php echo $periodo_contable->fecha_fin->FldCaption() ?></td>
			<td<?php echo $periodo_contable->fecha_fin->CellAttributes() ?>>
<span id="el_periodo_contable_fecha_fin">
<span<?php echo $periodo_contable->fecha_fin->ViewAttributes() ?>>
<?php echo $periodo_contable->fecha_fin->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($periodo_contable->estatus->Visible) { // estatus ?>
		<tr id="r_estatus">
			<td><?php echo $periodo_contable->estatus->FldCaption() ?></td>
			<td<?php echo $periodo_contable->estatus->CellAttributes() ?>>
<span id="el_periodo_contable_estatus">
<span<?php echo $periodo_contable->estatus->ViewAttributes() ?>>
<?php echo $periodo_contable->estatus->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
