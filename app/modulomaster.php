<?php

// nombre
?>
<?php if ($modulo->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $modulo->TableCaption() ?></h4> -->
<table id="tbl_modulomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $modulo->TableCustomInnerHtml ?>
	<tbody>
<?php if ($modulo->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $modulo->nombre->FldCaption() ?></td>
			<td<?php echo $modulo->nombre->CellAttributes() ?>>
<span id="el_modulo_nombre">
<span<?php echo $modulo->nombre->ViewAttributes() ?>>
<?php echo $modulo->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
