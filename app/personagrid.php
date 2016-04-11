<?php

// Create page object
if (!isset($persona_grid)) $persona_grid = new cpersona_grid();

// Page init
$persona_grid->Page_Init();

// Page main
$persona_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persona_grid->Page_Render();
?>
<?php if ($persona->Export == "") { ?>
<script type="text/javascript">

// Form object
var fpersonagrid = new ew_Form("fpersonagrid", "grid");
fpersonagrid.FormKeyCountName = '<?php echo $persona_grid->FormKeyCountName ?>';

// Validate form
fpersonagrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_tipo_persona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $persona->tipo_persona->FldCaption(), $persona->tipo_persona->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fpersonagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tipo_persona", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "apellido", false)) return false;
	return true;
}

// Form_CustomValidate event
fpersonagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonagrid.ValidateRequired = true;
<?php } else { ?>
fpersonagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonagrid.Lists["x_tipo_persona"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonagrid.Lists["x_tipo_persona"].Options = <?php echo json_encode($persona->tipo_persona->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($persona->CurrentAction == "gridadd") {
	if ($persona->CurrentMode == "copy") {
		$bSelectLimit = $persona_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$persona_grid->TotalRecs = $persona->SelectRecordCount();
			$persona_grid->Recordset = $persona_grid->LoadRecordset($persona_grid->StartRec-1, $persona_grid->DisplayRecs);
		} else {
			if ($persona_grid->Recordset = $persona_grid->LoadRecordset())
				$persona_grid->TotalRecs = $persona_grid->Recordset->RecordCount();
		}
		$persona_grid->StartRec = 1;
		$persona_grid->DisplayRecs = $persona_grid->TotalRecs;
	} else {
		$persona->CurrentFilter = "0=1";
		$persona_grid->StartRec = 1;
		$persona_grid->DisplayRecs = $persona->GridAddRowCount;
	}
	$persona_grid->TotalRecs = $persona_grid->DisplayRecs;
	$persona_grid->StopRec = $persona_grid->DisplayRecs;
} else {
	$bSelectLimit = $persona_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($persona_grid->TotalRecs <= 0)
			$persona_grid->TotalRecs = $persona->SelectRecordCount();
	} else {
		if (!$persona_grid->Recordset && ($persona_grid->Recordset = $persona_grid->LoadRecordset()))
			$persona_grid->TotalRecs = $persona_grid->Recordset->RecordCount();
	}
	$persona_grid->StartRec = 1;
	$persona_grid->DisplayRecs = $persona_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$persona_grid->Recordset = $persona_grid->LoadRecordset($persona_grid->StartRec-1, $persona_grid->DisplayRecs);

	// Set no record found message
	if ($persona->CurrentAction == "" && $persona_grid->TotalRecs == 0) {
		if ($persona_grid->SearchWhere == "0=101")
			$persona_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$persona_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$persona_grid->RenderOtherOptions();
?>
<?php $persona_grid->ShowPageHeader(); ?>
<?php
$persona_grid->ShowMessage();
?>
<?php if ($persona_grid->TotalRecs > 0 || $persona->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fpersonagrid" class="ewForm form-inline">
<div id="gmp_persona" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_personagrid" class="table ewTable">
<?php echo $persona->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$persona_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$persona_grid->RenderListOptions();

// Render list options (header, left)
$persona_grid->ListOptions->Render("header", "left");
?>
<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
	<?php if ($persona->SortUrl($persona->tipo_persona) == "") { ?>
		<th data-name="tipo_persona"><div id="elh_persona_tipo_persona" class="persona_tipo_persona"><div class="ewTableHeaderCaption"><?php echo $persona->tipo_persona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo_persona"><div><div id="elh_persona_tipo_persona" class="persona_tipo_persona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persona->tipo_persona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persona->tipo_persona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persona->tipo_persona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($persona->nombre->Visible) { // nombre ?>
	<?php if ($persona->SortUrl($persona->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_persona_nombre" class="persona_nombre"><div class="ewTableHeaderCaption"><?php echo $persona->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_persona_nombre" class="persona_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persona->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persona->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persona->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($persona->apellido->Visible) { // apellido ?>
	<?php if ($persona->SortUrl($persona->apellido) == "") { ?>
		<th data-name="apellido"><div id="elh_persona_apellido" class="persona_apellido"><div class="ewTableHeaderCaption"><?php echo $persona->apellido->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="apellido"><div><div id="elh_persona_apellido" class="persona_apellido">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $persona->apellido->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($persona->apellido->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($persona->apellido->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$persona_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$persona_grid->StartRec = 1;
$persona_grid->StopRec = $persona_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($persona_grid->FormKeyCountName) && ($persona->CurrentAction == "gridadd" || $persona->CurrentAction == "gridedit" || $persona->CurrentAction == "F")) {
		$persona_grid->KeyCount = $objForm->GetValue($persona_grid->FormKeyCountName);
		$persona_grid->StopRec = $persona_grid->StartRec + $persona_grid->KeyCount - 1;
	}
}
$persona_grid->RecCnt = $persona_grid->StartRec - 1;
if ($persona_grid->Recordset && !$persona_grid->Recordset->EOF) {
	$persona_grid->Recordset->MoveFirst();
	$bSelectLimit = $persona_grid->UseSelectLimit;
	if (!$bSelectLimit && $persona_grid->StartRec > 1)
		$persona_grid->Recordset->Move($persona_grid->StartRec - 1);
} elseif (!$persona->AllowAddDeleteRow && $persona_grid->StopRec == 0) {
	$persona_grid->StopRec = $persona->GridAddRowCount;
}

// Initialize aggregate
$persona->RowType = EW_ROWTYPE_AGGREGATEINIT;
$persona->ResetAttrs();
$persona_grid->RenderRow();
if ($persona->CurrentAction == "gridadd")
	$persona_grid->RowIndex = 0;
if ($persona->CurrentAction == "gridedit")
	$persona_grid->RowIndex = 0;
while ($persona_grid->RecCnt < $persona_grid->StopRec) {
	$persona_grid->RecCnt++;
	if (intval($persona_grid->RecCnt) >= intval($persona_grid->StartRec)) {
		$persona_grid->RowCnt++;
		if ($persona->CurrentAction == "gridadd" || $persona->CurrentAction == "gridedit" || $persona->CurrentAction == "F") {
			$persona_grid->RowIndex++;
			$objForm->Index = $persona_grid->RowIndex;
			if ($objForm->HasValue($persona_grid->FormActionName))
				$persona_grid->RowAction = strval($objForm->GetValue($persona_grid->FormActionName));
			elseif ($persona->CurrentAction == "gridadd")
				$persona_grid->RowAction = "insert";
			else
				$persona_grid->RowAction = "";
		}

		// Set up key count
		$persona_grid->KeyCount = $persona_grid->RowIndex;

		// Init row class and style
		$persona->ResetAttrs();
		$persona->CssClass = "";
		if ($persona->CurrentAction == "gridadd") {
			if ($persona->CurrentMode == "copy") {
				$persona_grid->LoadRowValues($persona_grid->Recordset); // Load row values
				$persona_grid->SetRecordKey($persona_grid->RowOldKey, $persona_grid->Recordset); // Set old record key
			} else {
				$persona_grid->LoadDefaultValues(); // Load default values
				$persona_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$persona_grid->LoadRowValues($persona_grid->Recordset); // Load row values
		}
		$persona->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($persona->CurrentAction == "gridadd") // Grid add
			$persona->RowType = EW_ROWTYPE_ADD; // Render add
		if ($persona->CurrentAction == "gridadd" && $persona->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$persona_grid->RestoreCurrentRowFormValues($persona_grid->RowIndex); // Restore form values
		if ($persona->CurrentAction == "gridedit") { // Grid edit
			if ($persona->EventCancelled) {
				$persona_grid->RestoreCurrentRowFormValues($persona_grid->RowIndex); // Restore form values
			}
			if ($persona_grid->RowAction == "insert")
				$persona->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$persona->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($persona->CurrentAction == "gridedit" && ($persona->RowType == EW_ROWTYPE_EDIT || $persona->RowType == EW_ROWTYPE_ADD) && $persona->EventCancelled) // Update failed
			$persona_grid->RestoreCurrentRowFormValues($persona_grid->RowIndex); // Restore form values
		if ($persona->RowType == EW_ROWTYPE_EDIT) // Edit row
			$persona_grid->EditRowCnt++;
		if ($persona->CurrentAction == "F") // Confirm row
			$persona_grid->RestoreCurrentRowFormValues($persona_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$persona->RowAttrs = array_merge($persona->RowAttrs, array('data-rowindex'=>$persona_grid->RowCnt, 'id'=>'r' . $persona_grid->RowCnt . '_persona', 'data-rowtype'=>$persona->RowType));

		// Render row
		$persona_grid->RenderRow();

		// Render list options
		$persona_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($persona_grid->RowAction <> "delete" && $persona_grid->RowAction <> "insertdelete" && !($persona_grid->RowAction == "insert" && $persona->CurrentAction == "F" && $persona_grid->EmptyRow())) {
?>
	<tr<?php echo $persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persona_grid->ListOptions->Render("body", "left", $persona_grid->RowCnt);
?>
	<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
		<td data-name="tipo_persona"<?php echo $persona->tipo_persona->CellAttributes() ?>>
<?php if ($persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_tipo_persona" class="form-group persona_tipo_persona">
<select data-table="persona" data-field="x_tipo_persona" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->tipo_persona->DisplayValueSeparator) ? json_encode($persona->tipo_persona->DisplayValueSeparator) : $persona->tipo_persona->DisplayValueSeparator) ?>" id="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" name="x<?php echo $persona_grid->RowIndex ?>_tipo_persona"<?php echo $persona->tipo_persona->EditAttributes() ?>>
<?php
if (is_array($persona->tipo_persona->EditValue)) {
	$arwrk = $persona->tipo_persona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->tipo_persona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->tipo_persona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->tipo_persona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->tipo_persona->CurrentValue) ?>" selected><?php echo $persona->tipo_persona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $persona->tipo_persona->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="persona" data-field="x_tipo_persona" name="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" id="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" value="<?php echo ew_HtmlEncode($persona->tipo_persona->OldValue) ?>">
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_tipo_persona" class="form-group persona_tipo_persona">
<select data-table="persona" data-field="x_tipo_persona" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->tipo_persona->DisplayValueSeparator) ? json_encode($persona->tipo_persona->DisplayValueSeparator) : $persona->tipo_persona->DisplayValueSeparator) ?>" id="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" name="x<?php echo $persona_grid->RowIndex ?>_tipo_persona"<?php echo $persona->tipo_persona->EditAttributes() ?>>
<?php
if (is_array($persona->tipo_persona->EditValue)) {
	$arwrk = $persona->tipo_persona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->tipo_persona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->tipo_persona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->tipo_persona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->tipo_persona->CurrentValue) ?>" selected><?php echo $persona->tipo_persona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $persona->tipo_persona->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_tipo_persona" class="persona_tipo_persona">
<span<?php echo $persona->tipo_persona->ViewAttributes() ?>>
<?php echo $persona->tipo_persona->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="persona" data-field="x_tipo_persona" name="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" id="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" value="<?php echo ew_HtmlEncode($persona->tipo_persona->FormValue) ?>">
<input type="hidden" data-table="persona" data-field="x_tipo_persona" name="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" id="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" value="<?php echo ew_HtmlEncode($persona->tipo_persona->OldValue) ?>">
<?php } ?>
<a id="<?php echo $persona_grid->PageObjName . "_row_" . $persona_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="persona" data-field="x_idpersona" name="x<?php echo $persona_grid->RowIndex ?>_idpersona" id="x<?php echo $persona_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($persona->idpersona->CurrentValue) ?>">
<input type="hidden" data-table="persona" data-field="x_idpersona" name="o<?php echo $persona_grid->RowIndex ?>_idpersona" id="o<?php echo $persona_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($persona->idpersona->OldValue) ?>">
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_EDIT || $persona->CurrentMode == "edit") { ?>
<input type="hidden" data-table="persona" data-field="x_idpersona" name="x<?php echo $persona_grid->RowIndex ?>_idpersona" id="x<?php echo $persona_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($persona->idpersona->CurrentValue) ?>">
<?php } ?>
	<?php if ($persona->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $persona->nombre->CellAttributes() ?>>
<?php if ($persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_nombre" class="form-group persona_nombre">
<input type="text" data-table="persona" data-field="x_nombre" name="x<?php echo $persona_grid->RowIndex ?>_nombre" id="x<?php echo $persona_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->nombre->getPlaceHolder()) ?>" value="<?php echo $persona->nombre->EditValue ?>"<?php echo $persona->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="persona" data-field="x_nombre" name="o<?php echo $persona_grid->RowIndex ?>_nombre" id="o<?php echo $persona_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($persona->nombre->OldValue) ?>">
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_nombre" class="form-group persona_nombre">
<input type="text" data-table="persona" data-field="x_nombre" name="x<?php echo $persona_grid->RowIndex ?>_nombre" id="x<?php echo $persona_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->nombre->getPlaceHolder()) ?>" value="<?php echo $persona->nombre->EditValue ?>"<?php echo $persona->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_nombre" class="persona_nombre">
<span<?php echo $persona->nombre->ViewAttributes() ?>>
<?php echo $persona->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="persona" data-field="x_nombre" name="x<?php echo $persona_grid->RowIndex ?>_nombre" id="x<?php echo $persona_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($persona->nombre->FormValue) ?>">
<input type="hidden" data-table="persona" data-field="x_nombre" name="o<?php echo $persona_grid->RowIndex ?>_nombre" id="o<?php echo $persona_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($persona->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($persona->apellido->Visible) { // apellido ?>
		<td data-name="apellido"<?php echo $persona->apellido->CellAttributes() ?>>
<?php if ($persona->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_apellido" class="form-group persona_apellido">
<input type="text" data-table="persona" data-field="x_apellido" name="x<?php echo $persona_grid->RowIndex ?>_apellido" id="x<?php echo $persona_grid->RowIndex ?>_apellido" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->apellido->getPlaceHolder()) ?>" value="<?php echo $persona->apellido->EditValue ?>"<?php echo $persona->apellido->EditAttributes() ?>>
</span>
<input type="hidden" data-table="persona" data-field="x_apellido" name="o<?php echo $persona_grid->RowIndex ?>_apellido" id="o<?php echo $persona_grid->RowIndex ?>_apellido" value="<?php echo ew_HtmlEncode($persona->apellido->OldValue) ?>">
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_apellido" class="form-group persona_apellido">
<input type="text" data-table="persona" data-field="x_apellido" name="x<?php echo $persona_grid->RowIndex ?>_apellido" id="x<?php echo $persona_grid->RowIndex ?>_apellido" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->apellido->getPlaceHolder()) ?>" value="<?php echo $persona->apellido->EditValue ?>"<?php echo $persona->apellido->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($persona->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $persona_grid->RowCnt ?>_persona_apellido" class="persona_apellido">
<span<?php echo $persona->apellido->ViewAttributes() ?>>
<?php echo $persona->apellido->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="persona" data-field="x_apellido" name="x<?php echo $persona_grid->RowIndex ?>_apellido" id="x<?php echo $persona_grid->RowIndex ?>_apellido" value="<?php echo ew_HtmlEncode($persona->apellido->FormValue) ?>">
<input type="hidden" data-table="persona" data-field="x_apellido" name="o<?php echo $persona_grid->RowIndex ?>_apellido" id="o<?php echo $persona_grid->RowIndex ?>_apellido" value="<?php echo ew_HtmlEncode($persona->apellido->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$persona_grid->ListOptions->Render("body", "right", $persona_grid->RowCnt);
?>
	</tr>
<?php if ($persona->RowType == EW_ROWTYPE_ADD || $persona->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpersonagrid.UpdateOpts(<?php echo $persona_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($persona->CurrentAction <> "gridadd" || $persona->CurrentMode == "copy")
		if (!$persona_grid->Recordset->EOF) $persona_grid->Recordset->MoveNext();
}
?>
<?php
	if ($persona->CurrentMode == "add" || $persona->CurrentMode == "copy" || $persona->CurrentMode == "edit") {
		$persona_grid->RowIndex = '$rowindex$';
		$persona_grid->LoadDefaultValues();

		// Set row properties
		$persona->ResetAttrs();
		$persona->RowAttrs = array_merge($persona->RowAttrs, array('data-rowindex'=>$persona_grid->RowIndex, 'id'=>'r0_persona', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($persona->RowAttrs["class"], "ewTemplate");
		$persona->RowType = EW_ROWTYPE_ADD;

		// Render row
		$persona_grid->RenderRow();

		// Render list options
		$persona_grid->RenderListOptions();
		$persona_grid->StartRowCnt = 0;
?>
	<tr<?php echo $persona->RowAttributes() ?>>
<?php

// Render list options (body, left)
$persona_grid->ListOptions->Render("body", "left", $persona_grid->RowIndex);
?>
	<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
		<td data-name="tipo_persona">
<?php if ($persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_persona_tipo_persona" class="form-group persona_tipo_persona">
<select data-table="persona" data-field="x_tipo_persona" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->tipo_persona->DisplayValueSeparator) ? json_encode($persona->tipo_persona->DisplayValueSeparator) : $persona->tipo_persona->DisplayValueSeparator) ?>" id="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" name="x<?php echo $persona_grid->RowIndex ?>_tipo_persona"<?php echo $persona->tipo_persona->EditAttributes() ?>>
<?php
if (is_array($persona->tipo_persona->EditValue)) {
	$arwrk = $persona->tipo_persona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->tipo_persona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->tipo_persona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->tipo_persona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->tipo_persona->CurrentValue) ?>" selected><?php echo $persona->tipo_persona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $persona->tipo_persona->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_persona_tipo_persona" class="form-group persona_tipo_persona">
<span<?php echo $persona->tipo_persona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $persona->tipo_persona->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="persona" data-field="x_tipo_persona" name="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" id="x<?php echo $persona_grid->RowIndex ?>_tipo_persona" value="<?php echo ew_HtmlEncode($persona->tipo_persona->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="persona" data-field="x_tipo_persona" name="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" id="o<?php echo $persona_grid->RowIndex ?>_tipo_persona" value="<?php echo ew_HtmlEncode($persona->tipo_persona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($persona->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_persona_nombre" class="form-group persona_nombre">
<input type="text" data-table="persona" data-field="x_nombre" name="x<?php echo $persona_grid->RowIndex ?>_nombre" id="x<?php echo $persona_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->nombre->getPlaceHolder()) ?>" value="<?php echo $persona->nombre->EditValue ?>"<?php echo $persona->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_persona_nombre" class="form-group persona_nombre">
<span<?php echo $persona->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $persona->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="persona" data-field="x_nombre" name="x<?php echo $persona_grid->RowIndex ?>_nombre" id="x<?php echo $persona_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($persona->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="persona" data-field="x_nombre" name="o<?php echo $persona_grid->RowIndex ?>_nombre" id="o<?php echo $persona_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($persona->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($persona->apellido->Visible) { // apellido ?>
		<td data-name="apellido">
<?php if ($persona->CurrentAction <> "F") { ?>
<span id="el$rowindex$_persona_apellido" class="form-group persona_apellido">
<input type="text" data-table="persona" data-field="x_apellido" name="x<?php echo $persona_grid->RowIndex ?>_apellido" id="x<?php echo $persona_grid->RowIndex ?>_apellido" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->apellido->getPlaceHolder()) ?>" value="<?php echo $persona->apellido->EditValue ?>"<?php echo $persona->apellido->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_persona_apellido" class="form-group persona_apellido">
<span<?php echo $persona->apellido->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $persona->apellido->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="persona" data-field="x_apellido" name="x<?php echo $persona_grid->RowIndex ?>_apellido" id="x<?php echo $persona_grid->RowIndex ?>_apellido" value="<?php echo ew_HtmlEncode($persona->apellido->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="persona" data-field="x_apellido" name="o<?php echo $persona_grid->RowIndex ?>_apellido" id="o<?php echo $persona_grid->RowIndex ?>_apellido" value="<?php echo ew_HtmlEncode($persona->apellido->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$persona_grid->ListOptions->Render("body", "right", $persona_grid->RowCnt);
?>
<script type="text/javascript">
fpersonagrid.UpdateOpts(<?php echo $persona_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($persona->CurrentMode == "add" || $persona->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $persona_grid->FormKeyCountName ?>" id="<?php echo $persona_grid->FormKeyCountName ?>" value="<?php echo $persona_grid->KeyCount ?>">
<?php echo $persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persona->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $persona_grid->FormKeyCountName ?>" id="<?php echo $persona_grid->FormKeyCountName ?>" value="<?php echo $persona_grid->KeyCount ?>">
<?php echo $persona_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($persona->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fpersonagrid">
</div>
<?php

// Close recordset
if ($persona_grid->Recordset)
	$persona_grid->Recordset->Close();
?>
<?php if ($persona_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($persona_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($persona_grid->TotalRecs == 0 && $persona->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($persona_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($persona->Export == "") { ?>
<script type="text/javascript">
fpersonagrid.Init();
</script>
<?php } ?>
<?php
$persona_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$persona_grid->Page_Terminate();
?>
