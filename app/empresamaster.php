<?php

// nombre
// ticker

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
<?php if ($empresa->ticker->Visible) { // ticker ?>
		<tr id="r_ticker">
			<td><?php echo $empresa->ticker->FldCaption() ?></td>
			<td<?php echo $empresa->ticker->CellAttributes() ?>>
<span id="el_empresa_ticker">
<span<?php echo $empresa->ticker->ViewAttributes() ?>>
<?php echo $empresa->ticker->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
