<?php

// nomenclatura
// nombre
// idgrupo_cuenta
// tendencia

?>
<?php if ($subgrupo_cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $subgrupo_cuenta->TableCaption() ?></h4> -->
<table id="tbl_subgrupo_cuentamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $subgrupo_cuenta->TableCustomInnerHtml ?>
	<tbody>
<?php if ($subgrupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<tr id="r_nomenclatura">
			<td><?php echo $subgrupo_cuenta->nomenclatura->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->nomenclatura->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nomenclatura">
<span<?php echo $subgrupo_cuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nomenclatura->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->nombre->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nombre">
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
<span id="el_subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($subgrupo_cuenta->tendencia->Visible) { // tendencia ?>
		<tr id="r_tendencia">
			<td><?php echo $subgrupo_cuenta->tendencia->FldCaption() ?></td>
			<td<?php echo $subgrupo_cuenta->tendencia->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_tendencia">
<span<?php echo $subgrupo_cuenta->tendencia->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->tendencia->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
