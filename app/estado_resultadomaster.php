<?php

// idempresa
// idperiodo_contable
// venta_netas
// utilidad_neta

?>
<?php if ($estado_resultado->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $estado_resultado->TableCaption() ?></h4> -->
<table id="tbl_estado_resultadomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $estado_resultado->TableCustomInnerHtml ?>
	<tbody>
<?php if ($estado_resultado->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $estado_resultado->idempresa->FldCaption() ?></td>
			<td<?php echo $estado_resultado->idempresa->CellAttributes() ?>>
<span id="el_estado_resultado_idempresa">
<span<?php echo $estado_resultado->idempresa->ViewAttributes() ?>>
<?php echo $estado_resultado->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<tr id="r_idperiodo_contable">
			<td><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?></td>
			<td<?php echo $estado_resultado->idperiodo_contable->CellAttributes() ?>>
<span id="el_estado_resultado_idperiodo_contable">
<span<?php echo $estado_resultado->idperiodo_contable->ViewAttributes() ?>>
<?php echo $estado_resultado->idperiodo_contable->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($estado_resultado->venta_netas->Visible) { // venta_netas ?>
		<tr id="r_venta_netas">
			<td><?php echo $estado_resultado->venta_netas->FldCaption() ?></td>
			<td<?php echo $estado_resultado->venta_netas->CellAttributes() ?>>
<span id="el_estado_resultado_venta_netas">
<span<?php echo $estado_resultado->venta_netas->ViewAttributes() ?>>
<?php echo $estado_resultado->venta_netas->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($estado_resultado->utilidad_neta->Visible) { // utilidad_neta ?>
		<tr id="r_utilidad_neta">
			<td><?php echo $estado_resultado->utilidad_neta->FldCaption() ?></td>
			<td<?php echo $estado_resultado->utilidad_neta->CellAttributes() ?>>
<span id="el_estado_resultado_utilidad_neta">
<span<?php echo $estado_resultado->utilidad_neta->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidad_neta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
