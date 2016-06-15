<?php

// idempresa
// idperiodo_contable
// activo_circulante
// activo_fijo
// pasivo_circulante
// pasivo_fijo
// capital_contable

?>
<?php if ($balance_general->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $balance_general->TableCaption() ?></h4> -->
<table id="tbl_balance_generalmaster" class="table table-bordered table-striped ewViewTable">
<?php echo $balance_general->TableCustomInnerHtml ?>
	<tbody>
<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $balance_general->idempresa->FldCaption() ?></td>
			<td<?php echo $balance_general->idempresa->CellAttributes() ?>>
<span id="el_balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<?php echo $balance_general->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<tr id="r_idperiodo_contable">
			<td><?php echo $balance_general->idperiodo_contable->FldCaption() ?></td>
			<td<?php echo $balance_general->idperiodo_contable->CellAttributes() ?>>
<span id="el_balance_general_idperiodo_contable">
<span<?php echo $balance_general->idperiodo_contable->ViewAttributes() ?>>
<?php echo $balance_general->idperiodo_contable->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
		<tr id="r_activo_circulante">
			<td><?php echo $balance_general->activo_circulante->FldCaption() ?></td>
			<td<?php echo $balance_general->activo_circulante->CellAttributes() ?>>
<span id="el_balance_general_activo_circulante">
<span<?php echo $balance_general->activo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->activo_circulante->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
		<tr id="r_activo_fijo">
			<td><?php echo $balance_general->activo_fijo->FldCaption() ?></td>
			<td<?php echo $balance_general->activo_fijo->CellAttributes() ?>>
<span id="el_balance_general_activo_fijo">
<span<?php echo $balance_general->activo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->activo_fijo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
		<tr id="r_pasivo_circulante">
			<td><?php echo $balance_general->pasivo_circulante->FldCaption() ?></td>
			<td<?php echo $balance_general->pasivo_circulante->CellAttributes() ?>>
<span id="el_balance_general_pasivo_circulante">
<span<?php echo $balance_general->pasivo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_circulante->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
		<tr id="r_pasivo_fijo">
			<td><?php echo $balance_general->pasivo_fijo->FldCaption() ?></td>
			<td<?php echo $balance_general->pasivo_fijo->CellAttributes() ?>>
<span id="el_balance_general_pasivo_fijo">
<span<?php echo $balance_general->pasivo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_fijo->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
		<tr id="r_capital_contable">
			<td><?php echo $balance_general->capital_contable->FldCaption() ?></td>
			<td<?php echo $balance_general->capital_contable->CellAttributes() ?>>
<span id="el_balance_general_capital_contable">
<span<?php echo $balance_general->capital_contable->ViewAttributes() ?>>
<?php echo $balance_general->capital_contable->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
