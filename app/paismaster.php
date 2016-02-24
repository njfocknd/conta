<?php

// nombre
?>
<?php if ($pais->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $pais->TableCaption() ?></h4> -->
<table id="tbl_paismaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($pais->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $pais->nombre->FldCaption() ?></td>
			<td<?php echo $pais->nombre->CellAttributes() ?>>
<span id="el_pais_nombre" class="form-group">
<span<?php echo $pais->nombre->ViewAttributes() ?>>
<?php echo $pais->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
