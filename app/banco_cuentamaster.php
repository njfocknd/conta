<?php

// idempresa
// idbanco
// nombre
// numero

?>
<?php if ($banco_cuenta->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $banco_cuenta->TableCaption() ?></h4> -->
<table id="tbl_banco_cuentamaster" class="table table-bordered table-striped ewViewTable">
<?php echo $banco_cuenta->TableCustomInnerHtml ?>
	<tbody>
<?php if ($banco_cuenta->idempresa->Visible) { // idempresa ?>
		<tr id="r_idempresa">
			<td><?php echo $banco_cuenta->idempresa->FldCaption() ?></td>
			<td<?php echo $banco_cuenta->idempresa->CellAttributes() ?>>
<span id="el_banco_cuenta_idempresa">
<span<?php echo $banco_cuenta->idempresa->ViewAttributes() ?>>
<?php echo $banco_cuenta->idempresa->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco_cuenta->idbanco->Visible) { // idbanco ?>
		<tr id="r_idbanco">
			<td><?php echo $banco_cuenta->idbanco->FldCaption() ?></td>
			<td<?php echo $banco_cuenta->idbanco->CellAttributes() ?>>
<span id="el_banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<?php echo $banco_cuenta->idbanco->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco_cuenta->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $banco_cuenta->nombre->FldCaption() ?></td>
			<td<?php echo $banco_cuenta->nombre->CellAttributes() ?>>
<span id="el_banco_cuenta_nombre">
<span<?php echo $banco_cuenta->nombre->ViewAttributes() ?>>
<?php echo $banco_cuenta->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($banco_cuenta->numero->Visible) { // numero ?>
		<tr id="r_numero">
			<td><?php echo $banco_cuenta->numero->FldCaption() ?></td>
			<td<?php echo $banco_cuenta->numero->CellAttributes() ?>>
<span id="el_banco_cuenta_numero">
<span<?php echo $banco_cuenta->numero->ViewAttributes() ?>>
<?php echo $banco_cuenta->numero->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
