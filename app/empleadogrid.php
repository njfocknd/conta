<?php

// Create page object
if (!isset($empleado_grid)) $empleado_grid = new cempleado_grid();

// Page init
$empleado_grid->Page_Init();

// Page main
$empleado_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$empleado_grid->Page_Render();
?>
<?php if ($empleado->Export == "") { ?>
<script type="text/javascript">

// Page object
var empleado_grid = new ew_Page("empleado_grid");
empleado_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = empleado_grid.PageID; // For backward compatibility

// Form object
var fempleadogrid = new ew_Form("fempleadogrid");
fempleadogrid.FormKeyCountName = '<?php echo $empleado_grid->FormKeyCountName ?>';

// Validate form
fempleadogrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $empleado->idempresa->FldCaption(), $empleado->idempresa->ReqErrMsg)) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fempleadogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "codigo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	return true;
}

// Form_CustomValidate event
fempleadogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fempleadogrid.ValidateRequired = true;
<?php } else { ?>
fempleadogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fempleadogrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":null,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($empleado->CurrentAction == "gridadd") {
	if ($empleado->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$empleado_grid->TotalRecs = $empleado->SelectRecordCount();
			$empleado_grid->Recordset = $empleado_grid->LoadRecordset($empleado_grid->StartRec-1, $empleado_grid->DisplayRecs);
		} else {
			if ($empleado_grid->Recordset = $empleado_grid->LoadRecordset())
				$empleado_grid->TotalRecs = $empleado_grid->Recordset->RecordCount();
		}
		$empleado_grid->StartRec = 1;
		$empleado_grid->DisplayRecs = $empleado_grid->TotalRecs;
	} else {
		$empleado->CurrentFilter = "0=1";
		$empleado_grid->StartRec = 1;
		$empleado_grid->DisplayRecs = $empleado->GridAddRowCount;
	}
	$empleado_grid->TotalRecs = $empleado_grid->DisplayRecs;
	$empleado_grid->StopRec = $empleado_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$empleado_grid->TotalRecs = $empleado->SelectRecordCount();
	} else {
		if ($empleado_grid->Recordset = $empleado_grid->LoadRecordset())
			$empleado_grid->TotalRecs = $empleado_grid->Recordset->RecordCount();
	}
	$empleado_grid->StartRec = 1;
	$empleado_grid->DisplayRecs = $empleado_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$empleado_grid->Recordset = $empleado_grid->LoadRecordset($empleado_grid->StartRec-1, $empleado_grid->DisplayRecs);

	// Set no record found message
	if ($empleado->CurrentAction == "" && $empleado_grid->TotalRecs == 0) {
		if ($empleado_grid->SearchWhere == "0=101")
			$empleado_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$empleado_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$empleado_grid->RenderOtherOptions();
?>
<?php $empleado_grid->ShowPageHeader(); ?>
<?php
$empleado_grid->ShowMessage();
?>
<?php if ($empleado_grid->TotalRecs > 0 || $empleado->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fempleadogrid" class="ewForm form-inline">
<div id="gmp_empleado" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_empleadogrid" class="table ewTable">
<?php echo $empleado->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$empleado_grid->RenderListOptions();

// Render list options (header, left)
$empleado_grid->ListOptions->Render("header", "left");
?>
<?php if ($empleado->nit->Visible) { // nit ?>
	<?php if ($empleado->SortUrl($empleado->nit) == "") { ?>
		<th data-name="nit"><div id="elh_empleado_nit" class="empleado_nit"><div class="ewTableHeaderCaption"><?php echo $empleado->nit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nit"><div><div id="elh_empleado_nit" class="empleado_nit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $empleado->nit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($empleado->nit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($empleado->nit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($empleado->codigo->Visible) { // codigo ?>
	<?php if ($empleado->SortUrl($empleado->codigo) == "") { ?>
		<th data-name="codigo"><div id="elh_empleado_codigo" class="empleado_codigo"><div class="ewTableHeaderCaption"><?php echo $empleado->codigo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo"><div><div id="elh_empleado_codigo" class="empleado_codigo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $empleado->codigo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($empleado->codigo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($empleado->codigo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($empleado->nombre->Visible) { // nombre ?>
	<?php if ($empleado->SortUrl($empleado->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_empleado_nombre" class="empleado_nombre"><div class="ewTableHeaderCaption"><?php echo $empleado->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_empleado_nombre" class="empleado_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $empleado->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($empleado->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($empleado->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($empleado->idempresa->Visible) { // idempresa ?>
	<?php if ($empleado->SortUrl($empleado->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_empleado_idempresa" class="empleado_idempresa"><div class="ewTableHeaderCaption"><?php echo $empleado->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_empleado_idempresa" class="empleado_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $empleado->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($empleado->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($empleado->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$empleado_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$empleado_grid->StartRec = 1;
$empleado_grid->StopRec = $empleado_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($empleado_grid->FormKeyCountName) && ($empleado->CurrentAction == "gridadd" || $empleado->CurrentAction == "gridedit" || $empleado->CurrentAction == "F")) {
		$empleado_grid->KeyCount = $objForm->GetValue($empleado_grid->FormKeyCountName);
		$empleado_grid->StopRec = $empleado_grid->StartRec + $empleado_grid->KeyCount - 1;
	}
}
$empleado_grid->RecCnt = $empleado_grid->StartRec - 1;
if ($empleado_grid->Recordset && !$empleado_grid->Recordset->EOF) {
	$empleado_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $empleado_grid->StartRec > 1)
		$empleado_grid->Recordset->Move($empleado_grid->StartRec - 1);
} elseif (!$empleado->AllowAddDeleteRow && $empleado_grid->StopRec == 0) {
	$empleado_grid->StopRec = $empleado->GridAddRowCount;
}

// Initialize aggregate
$empleado->RowType = EW_ROWTYPE_AGGREGATEINIT;
$empleado->ResetAttrs();
$empleado_grid->RenderRow();
if ($empleado->CurrentAction == "gridadd")
	$empleado_grid->RowIndex = 0;
if ($empleado->CurrentAction == "gridedit")
	$empleado_grid->RowIndex = 0;
while ($empleado_grid->RecCnt < $empleado_grid->StopRec) {
	$empleado_grid->RecCnt++;
	if (intval($empleado_grid->RecCnt) >= intval($empleado_grid->StartRec)) {
		$empleado_grid->RowCnt++;
		if ($empleado->CurrentAction == "gridadd" || $empleado->CurrentAction == "gridedit" || $empleado->CurrentAction == "F") {
			$empleado_grid->RowIndex++;
			$objForm->Index = $empleado_grid->RowIndex;
			if ($objForm->HasValue($empleado_grid->FormActionName))
				$empleado_grid->RowAction = strval($objForm->GetValue($empleado_grid->FormActionName));
			elseif ($empleado->CurrentAction == "gridadd")
				$empleado_grid->RowAction = "insert";
			else
				$empleado_grid->RowAction = "";
		}

		// Set up key count
		$empleado_grid->KeyCount = $empleado_grid->RowIndex;

		// Init row class and style
		$empleado->ResetAttrs();
		$empleado->CssClass = "";
		if ($empleado->CurrentAction == "gridadd") {
			if ($empleado->CurrentMode == "copy") {
				$empleado_grid->LoadRowValues($empleado_grid->Recordset); // Load row values
				$empleado_grid->SetRecordKey($empleado_grid->RowOldKey, $empleado_grid->Recordset); // Set old record key
			} else {
				$empleado_grid->LoadDefaultValues(); // Load default values
				$empleado_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$empleado_grid->LoadRowValues($empleado_grid->Recordset); // Load row values
		}
		$empleado->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($empleado->CurrentAction == "gridadd") // Grid add
			$empleado->RowType = EW_ROWTYPE_ADD; // Render add
		if ($empleado->CurrentAction == "gridadd" && $empleado->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$empleado_grid->RestoreCurrentRowFormValues($empleado_grid->RowIndex); // Restore form values
		if ($empleado->CurrentAction == "gridedit") { // Grid edit
			if ($empleado->EventCancelled) {
				$empleado_grid->RestoreCurrentRowFormValues($empleado_grid->RowIndex); // Restore form values
			}
			if ($empleado_grid->RowAction == "insert")
				$empleado->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$empleado->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($empleado->CurrentAction == "gridedit" && ($empleado->RowType == EW_ROWTYPE_EDIT || $empleado->RowType == EW_ROWTYPE_ADD) && $empleado->EventCancelled) // Update failed
			$empleado_grid->RestoreCurrentRowFormValues($empleado_grid->RowIndex); // Restore form values
		if ($empleado->RowType == EW_ROWTYPE_EDIT) // Edit row
			$empleado_grid->EditRowCnt++;
		if ($empleado->CurrentAction == "F") // Confirm row
			$empleado_grid->RestoreCurrentRowFormValues($empleado_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$empleado->RowAttrs = array_merge($empleado->RowAttrs, array('data-rowindex'=>$empleado_grid->RowCnt, 'id'=>'r' . $empleado_grid->RowCnt . '_empleado', 'data-rowtype'=>$empleado->RowType));

		// Render row
		$empleado_grid->RenderRow();

		// Render list options
		$empleado_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($empleado_grid->RowAction <> "delete" && $empleado_grid->RowAction <> "insertdelete" && !($empleado_grid->RowAction == "insert" && $empleado->CurrentAction == "F" && $empleado_grid->EmptyRow())) {
?>
	<tr<?php echo $empleado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$empleado_grid->ListOptions->Render("body", "left", $empleado_grid->RowCnt);
?>
	<?php if ($empleado->nit->Visible) { // nit ?>
		<td data-name="nit"<?php echo $empleado->nit->CellAttributes() ?>>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_nit" class="form-group empleado_nit">
<input type="text" data-field="x_nit" name="x<?php echo $empleado_grid->RowIndex ?>_nit" id="x<?php echo $empleado_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nit->PlaceHolder) ?>" value="<?php echo $empleado->nit->EditValue ?>"<?php echo $empleado->nit->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nit" name="o<?php echo $empleado_grid->RowIndex ?>_nit" id="o<?php echo $empleado_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($empleado->nit->OldValue) ?>">
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_nit" class="form-group empleado_nit">
<input type="text" data-field="x_nit" name="x<?php echo $empleado_grid->RowIndex ?>_nit" id="x<?php echo $empleado_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nit->PlaceHolder) ?>" value="<?php echo $empleado->nit->EditValue ?>"<?php echo $empleado->nit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $empleado->nit->ViewAttributes() ?>>
<?php echo $empleado->nit->ListViewValue() ?></span>
<input type="hidden" data-field="x_nit" name="x<?php echo $empleado_grid->RowIndex ?>_nit" id="x<?php echo $empleado_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($empleado->nit->FormValue) ?>">
<input type="hidden" data-field="x_nit" name="o<?php echo $empleado_grid->RowIndex ?>_nit" id="o<?php echo $empleado_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($empleado->nit->OldValue) ?>">
<?php } ?>
<a id="<?php echo $empleado_grid->PageObjName . "_row_" . $empleado_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idempleado" name="x<?php echo $empleado_grid->RowIndex ?>_idempleado" id="x<?php echo $empleado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($empleado->idempleado->CurrentValue) ?>">
<input type="hidden" data-field="x_idempleado" name="o<?php echo $empleado_grid->RowIndex ?>_idempleado" id="o<?php echo $empleado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($empleado->idempleado->OldValue) ?>">
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_EDIT || $empleado->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idempleado" name="x<?php echo $empleado_grid->RowIndex ?>_idempleado" id="x<?php echo $empleado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($empleado->idempleado->CurrentValue) ?>">
<?php } ?>
	<?php if ($empleado->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $empleado->codigo->CellAttributes() ?>>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_codigo" class="form-group empleado_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $empleado_grid->RowIndex ?>_codigo" id="x<?php echo $empleado_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->codigo->PlaceHolder) ?>" value="<?php echo $empleado->codigo->EditValue ?>"<?php echo $empleado->codigo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_codigo" name="o<?php echo $empleado_grid->RowIndex ?>_codigo" id="o<?php echo $empleado_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($empleado->codigo->OldValue) ?>">
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_codigo" class="form-group empleado_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $empleado_grid->RowIndex ?>_codigo" id="x<?php echo $empleado_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->codigo->PlaceHolder) ?>" value="<?php echo $empleado->codigo->EditValue ?>"<?php echo $empleado->codigo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $empleado->codigo->ViewAttributes() ?>>
<?php echo $empleado->codigo->ListViewValue() ?></span>
<input type="hidden" data-field="x_codigo" name="x<?php echo $empleado_grid->RowIndex ?>_codigo" id="x<?php echo $empleado_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($empleado->codigo->FormValue) ?>">
<input type="hidden" data-field="x_codigo" name="o<?php echo $empleado_grid->RowIndex ?>_codigo" id="o<?php echo $empleado_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($empleado->codigo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($empleado->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $empleado->nombre->CellAttributes() ?>>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_nombre" class="form-group empleado_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $empleado_grid->RowIndex ?>_nombre" id="x<?php echo $empleado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nombre->PlaceHolder) ?>" value="<?php echo $empleado->nombre->EditValue ?>"<?php echo $empleado->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $empleado_grid->RowIndex ?>_nombre" id="o<?php echo $empleado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($empleado->nombre->OldValue) ?>">
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_nombre" class="form-group empleado_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $empleado_grid->RowIndex ?>_nombre" id="x<?php echo $empleado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nombre->PlaceHolder) ?>" value="<?php echo $empleado->nombre->EditValue ?>"<?php echo $empleado->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $empleado->nombre->ViewAttributes() ?>>
<?php echo $empleado->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $empleado_grid->RowIndex ?>_nombre" id="x<?php echo $empleado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($empleado->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $empleado_grid->RowIndex ?>_nombre" id="o<?php echo $empleado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($empleado->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($empleado->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $empleado->idempresa->CellAttributes() ?>>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_idempresa" class="form-group empleado_idempresa">
<select data-field="x_idempresa" id="x<?php echo $empleado_grid->RowIndex ?>_idempresa" name="x<?php echo $empleado_grid->RowIndex ?>_idempresa"<?php echo $empleado->idempresa->EditAttributes() ?>>
<?php
if (is_array($empleado->idempresa->EditValue)) {
	$arwrk = $empleado->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($empleado->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $empleado->idempresa->OldValue = "";
?>
</select>
<script type="text/javascript">
fempleadogrid.Lists["x_idempresa"].Options = <?php echo (is_array($empleado->idempresa->EditValue)) ? ew_ArrayToJson($empleado->idempresa->EditValue, 1) : "[]" ?>;
</script>
</span>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $empleado_grid->RowIndex ?>_idempresa" id="o<?php echo $empleado_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($empleado->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $empleado_grid->RowCnt ?>_empleado_idempresa" class="form-group empleado_idempresa">
<select data-field="x_idempresa" id="x<?php echo $empleado_grid->RowIndex ?>_idempresa" name="x<?php echo $empleado_grid->RowIndex ?>_idempresa"<?php echo $empleado->idempresa->EditAttributes() ?>>
<?php
if (is_array($empleado->idempresa->EditValue)) {
	$arwrk = $empleado->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($empleado->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $empleado->idempresa->OldValue = "";
?>
</select>
<script type="text/javascript">
fempleadogrid.Lists["x_idempresa"].Options = <?php echo (is_array($empleado->idempresa->EditValue)) ? ew_ArrayToJson($empleado->idempresa->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } ?>
<?php if ($empleado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $empleado->idempresa->ViewAttributes() ?>>
<?php echo $empleado->idempresa->ListViewValue() ?></span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $empleado_grid->RowIndex ?>_idempresa" id="x<?php echo $empleado_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($empleado->idempresa->FormValue) ?>">
<input type="hidden" data-field="x_idempresa" name="o<?php echo $empleado_grid->RowIndex ?>_idempresa" id="o<?php echo $empleado_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($empleado->idempresa->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$empleado_grid->ListOptions->Render("body", "right", $empleado_grid->RowCnt);
?>
	</tr>
<?php if ($empleado->RowType == EW_ROWTYPE_ADD || $empleado->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fempleadogrid.UpdateOpts(<?php echo $empleado_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($empleado->CurrentAction <> "gridadd" || $empleado->CurrentMode == "copy")
		if (!$empleado_grid->Recordset->EOF) $empleado_grid->Recordset->MoveNext();
}
?>
<?php
	if ($empleado->CurrentMode == "add" || $empleado->CurrentMode == "copy" || $empleado->CurrentMode == "edit") {
		$empleado_grid->RowIndex = '$rowindex$';
		$empleado_grid->LoadDefaultValues();

		// Set row properties
		$empleado->ResetAttrs();
		$empleado->RowAttrs = array_merge($empleado->RowAttrs, array('data-rowindex'=>$empleado_grid->RowIndex, 'id'=>'r0_empleado', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($empleado->RowAttrs["class"], "ewTemplate");
		$empleado->RowType = EW_ROWTYPE_ADD;

		// Render row
		$empleado_grid->RenderRow();

		// Render list options
		$empleado_grid->RenderListOptions();
		$empleado_grid->StartRowCnt = 0;
?>
	<tr<?php echo $empleado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$empleado_grid->ListOptions->Render("body", "left", $empleado_grid->RowIndex);
?>
	<?php if ($empleado->nit->Visible) { // nit ?>
		<td>
<?php if ($empleado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_empleado_nit" class="form-group empleado_nit">
<input type="text" data-field="x_nit" name="x<?php echo $empleado_grid->RowIndex ?>_nit" id="x<?php echo $empleado_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nit->PlaceHolder) ?>" value="<?php echo $empleado->nit->EditValue ?>"<?php echo $empleado->nit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_empleado_nit" class="form-group empleado_nit">
<span<?php echo $empleado->nit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $empleado->nit->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nit" name="x<?php echo $empleado_grid->RowIndex ?>_nit" id="x<?php echo $empleado_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($empleado->nit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nit" name="o<?php echo $empleado_grid->RowIndex ?>_nit" id="o<?php echo $empleado_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($empleado->nit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($empleado->codigo->Visible) { // codigo ?>
		<td>
<?php if ($empleado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_empleado_codigo" class="form-group empleado_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $empleado_grid->RowIndex ?>_codigo" id="x<?php echo $empleado_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->codigo->PlaceHolder) ?>" value="<?php echo $empleado->codigo->EditValue ?>"<?php echo $empleado->codigo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_empleado_codigo" class="form-group empleado_codigo">
<span<?php echo $empleado->codigo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $empleado->codigo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_codigo" name="x<?php echo $empleado_grid->RowIndex ?>_codigo" id="x<?php echo $empleado_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($empleado->codigo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_codigo" name="o<?php echo $empleado_grid->RowIndex ?>_codigo" id="o<?php echo $empleado_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($empleado->codigo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($empleado->nombre->Visible) { // nombre ?>
		<td>
<?php if ($empleado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_empleado_nombre" class="form-group empleado_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $empleado_grid->RowIndex ?>_nombre" id="x<?php echo $empleado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nombre->PlaceHolder) ?>" value="<?php echo $empleado->nombre->EditValue ?>"<?php echo $empleado->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_empleado_nombre" class="form-group empleado_nombre">
<span<?php echo $empleado->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $empleado->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $empleado_grid->RowIndex ?>_nombre" id="x<?php echo $empleado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($empleado->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $empleado_grid->RowIndex ?>_nombre" id="o<?php echo $empleado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($empleado->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($empleado->idempresa->Visible) { // idempresa ?>
		<td>
<?php if ($empleado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_empleado_idempresa" class="form-group empleado_idempresa">
<select data-field="x_idempresa" id="x<?php echo $empleado_grid->RowIndex ?>_idempresa" name="x<?php echo $empleado_grid->RowIndex ?>_idempresa"<?php echo $empleado->idempresa->EditAttributes() ?>>
<?php
if (is_array($empleado->idempresa->EditValue)) {
	$arwrk = $empleado->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($empleado->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $empleado->idempresa->OldValue = "";
?>
</select>
<script type="text/javascript">
fempleadogrid.Lists["x_idempresa"].Options = <?php echo (is_array($empleado->idempresa->EditValue)) ? ew_ArrayToJson($empleado->idempresa->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php } else { ?>
<span id="el$rowindex$_empleado_idempresa" class="form-group empleado_idempresa">
<span<?php echo $empleado->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $empleado->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $empleado_grid->RowIndex ?>_idempresa" id="x<?php echo $empleado_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($empleado->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $empleado_grid->RowIndex ?>_idempresa" id="o<?php echo $empleado_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($empleado->idempresa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$empleado_grid->ListOptions->Render("body", "right", $empleado_grid->RowCnt);
?>
<script type="text/javascript">
fempleadogrid.UpdateOpts(<?php echo $empleado_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($empleado->CurrentMode == "add" || $empleado->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $empleado_grid->FormKeyCountName ?>" id="<?php echo $empleado_grid->FormKeyCountName ?>" value="<?php echo $empleado_grid->KeyCount ?>">
<?php echo $empleado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($empleado->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $empleado_grid->FormKeyCountName ?>" id="<?php echo $empleado_grid->FormKeyCountName ?>" value="<?php echo $empleado_grid->KeyCount ?>">
<?php echo $empleado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($empleado->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fempleadogrid">
</div>
<?php

// Close recordset
if ($empleado_grid->Recordset)
	$empleado_grid->Recordset->Close();
?>
<?php if ($empleado_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($empleado_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($empleado_grid->TotalRecs == 0 && $empleado->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($empleado_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($empleado->Export == "") { ?>
<script type="text/javascript">
fempleadogrid.Init();
</script>
<?php } ?>
<?php
$empleado_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$empleado_grid->Page_Terminate();
?>
