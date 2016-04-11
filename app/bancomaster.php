<?php

// nombre
// alias

?>
<?php if ($banco->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $banco->TableCaption() ?></h4> -->
<table id="tbl_bancomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $banco->TableCustomInnerHtml ?>
	<tbody>
<?php if ($banco->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $banco->nombre->FldCaption() ?></td>
			<td<?php echo $banco->nombre->CellAttributes() ?>>
<span id="el_banco_nombre">
<span<?php echo $banco->nombre->ViewAttributes() ?>>
<?php echo $banco->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco->alias->Visible) { // alias ?>
		<tr id="r_alias">
			<td><?php echo $banco->alias->FldCaption() ?></td>
			<td<?php echo $banco->alias->CellAttributes() ?>>
<span id="el_banco_alias">
<span<?php echo $banco->alias->ViewAttributes() ?>>
<?php echo $banco->alias->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
