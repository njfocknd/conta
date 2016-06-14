<?php

// idclase_resultado
// nombre

?>
<?php if ($clase_resultado->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $clase_resultado->TableCaption() ?></h4> -->
<table id="tbl_clase_resultadomaster" class="table table-bordered table-striped ewViewTable">
<?php echo $clase_resultado->TableCustomInnerHtml ?>
	<tbody>
<?php if ($clase_resultado->idclase_resultado->Visible) { // idclase_resultado ?>
		<tr id="r_idclase_resultado">
			<td><?php echo $clase_resultado->idclase_resultado->FldCaption() ?></td>
			<td<?php echo $clase_resultado->idclase_resultado->CellAttributes() ?>>
<span id="el_clase_resultado_idclase_resultado">
<span<?php echo $clase_resultado->idclase_resultado->ViewAttributes() ?>>
<?php echo $clase_resultado->idclase_resultado->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($clase_resultado->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $clase_resultado->nombre->FldCaption() ?></td>
			<td<?php echo $clase_resultado->nombre->CellAttributes() ?>>
<span id="el_clase_resultado_nombre">
<span<?php echo $clase_resultado->nombre->ViewAttributes() ?>>
<?php echo $clase_resultado->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
