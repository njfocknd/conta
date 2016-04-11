<?php

// idcaja_chica_detalle
// idreferencia
// tabla_referencia
// monto
// fecha

?>
<?php if ($caja_chica_aplicacion->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $caja_chica_aplicacion->TableCaption() ?></h4> -->
<table id="tbl_caja_chica_aplicacionmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $caja_chica_aplicacion->TableCustomInnerHtml ?>
	<tbody>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
		<tr id="r_idcaja_chica_detalle">
			<td><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?></td>
			<td<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
		<tr id="r_idreferencia">
			<td><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></td>
			<td<?php echo $caja_chica_aplicacion->idreferencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idreferencia">
<span<?php echo $caja_chica_aplicacion->idreferencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idreferencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
		<tr id="r_tabla_referencia">
			<td><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></td>
			<td<?php echo $caja_chica_aplicacion->tabla_referencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_tabla_referencia">
<span<?php echo $caja_chica_aplicacion->tabla_referencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->tabla_referencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
		<tr id="r_monto">
			<td><?php echo $caja_chica_aplicacion->monto->FldCaption() ?></td>
			<td<?php echo $caja_chica_aplicacion->monto->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_monto">
<span<?php echo $caja_chica_aplicacion->monto->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->monto->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
		<tr id="r_fecha">
			<td><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></td>
			<td<?php echo $caja_chica_aplicacion->fecha->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_fecha">
<span<?php echo $caja_chica_aplicacion->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->fecha->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
