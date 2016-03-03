<?php

// tipo_persona
// nombre
// apellido

?>
<?php if ($persona->Visible) { ?>
<!-- <h4 class="ewMasterCaption"><?php echo $persona->TableCaption() ?></h4> -->
<table id="tbl_personamaster" class="table table-bordered table-striped ewViewTable">
	<tbody>
<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
		<tr id="r_tipo_persona">
			<td><?php echo $persona->tipo_persona->FldCaption() ?></td>
			<td<?php echo $persona->tipo_persona->CellAttributes() ?>>
<span id="el_persona_tipo_persona" class="form-group">
<span<?php echo $persona->tipo_persona->ViewAttributes() ?>>
<?php echo $persona->tipo_persona->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->nombre->Visible) { // nombre ?>
		<tr id="r_nombre">
			<td><?php echo $persona->nombre->FldCaption() ?></td>
			<td<?php echo $persona->nombre->CellAttributes() ?>>
<span id="el_persona_nombre" class="form-group">
<span<?php echo $persona->nombre->ViewAttributes() ?>>
<?php echo $persona->nombre->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($persona->apellido->Visible) { // apellido ?>
		<tr id="r_apellido">
			<td><?php echo $persona->apellido->FldCaption() ?></td>
			<td<?php echo $persona->apellido->CellAttributes() ?>>
<span id="el_persona_apellido" class="form-group">
<span<?php echo $persona->apellido->ViewAttributes() ?>>
<?php echo $persona->apellido->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
<?php } ?>
