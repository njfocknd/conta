<?php

// idcaja_chica
// tipo
// fecha
// monto
// monto_aplicado
// descripcion

?>
<?php if ($caja_chica_detalle->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $caja_chica_detalle->TableCaption() ?></h4> -->
<table id="tbl_caja_chica_detallemaster" class="table table-bordered table-striped ewViewTable">
<?php echo $caja_chica_detalle->TableCustomInnerHtml ?>
	<tbody>
<?php if ($caja_chica_detalle->idcaja_chica->Visible) { // idcaja_chica ?>
		<tr id="r_idcaja_chica">
			<td><?php echo $caja_chica_detalle->idcaja_chica->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->idcaja_chica->CellAttributes() ?>>
<span id="el_caja_chica_detalle_idcaja_chica">
<span<?php echo $caja_chica_detalle->idcaja_chica->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->idcaja_chica->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_detalle->tipo->Visible) { // tipo ?>
		<tr id="r_tipo">
			<td><?php echo $caja_chica_detalle->tipo->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->tipo->CellAttributes() ?>>
<span id="el_caja_chica_detalle_tipo">
<span<?php echo $caja_chica_detalle->tipo->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->tipo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_detalle->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $caja_chica_detalle->fecha->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->fecha->CellAttributes() ?>>
<span id="el_caja_chica_detalle_fecha">
<span<?php echo $caja_chica_detalle->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_detalle->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $caja_chica_detalle->monto->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->monto->CellAttributes() ?>>
<span id="el_caja_chica_detalle_monto">
<span<?php echo $caja_chica_detalle->monto->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_detalle->monto_aplicado->Visible) { // monto_aplicado ?>
		<tr id="r_monto_aplicado">
			<td><?php echo $caja_chica_detalle->monto_aplicado->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->monto_aplicado->CellAttributes() ?>>
<span id="el_caja_chica_detalle_monto_aplicado">
<span<?php echo $caja_chica_detalle->monto_aplicado->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->monto_aplicado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_detalle->descripcion->Visible) { // descripcion ?>
		<tr id="r_descripcion">
			<td><?php echo $caja_chica_detalle->descripcion->FldCaption() ?></td>
			<td<?php echo $caja_chica_detalle->descripcion->CellAttributes() ?>>
<span id="el_caja_chica_detalle_descripcion">
<span<?php echo $caja_chica_detalle->descripcion->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->descripcion->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
