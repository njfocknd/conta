<?php

// nomenclatura
// nombre
// idcuenta_mayor_auxiliar

?>
<?php if ($subcuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $subcuenta->TableCaption() ?></h4> -->
<table id="tbl_subcuentamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $subcuenta->TableCustomInnerHtml ?>
	<tbody>
<?php if ($subcuenta->nomenclatura->Visible) { // nomenclatura ?>
		<tr id="r_nomenclatura">
			<td><?php echo $subcuenta->nomenclatura->FldCaption() ?></td>
			<td<?php echo $subcuenta->nomenclatura->CellAttributes() ?>>
<span id="el_subcuenta_nomenclatura">
<span<?php echo $subcuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $subcuenta->nomenclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subcuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $subcuenta->nombre->FldCaption() ?></td>
			<td<?php echo $subcuenta->nombre->CellAttributes() ?>>
<span id="el_subcuenta_nombre">
<span<?php echo $subcuenta->nombre->ViewAttributes() ?>>
<?php echo $subcuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
		<tr id="r_idcuenta_mayor_auxiliar">
			<td><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?></td>
			<td<?php echo $subcuenta->idcuenta_mayor_auxiliar->CellAttributes() ?>>
<span id="el_subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<?php echo $subcuenta->idcuenta_mayor_auxiliar->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
