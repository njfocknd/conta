<?php

// Create page object
if (!isset($cuenta_grid)) $cuenta_grid = new ccuenta_grid();

// Page init
$cuenta_grid->Page_Init();

// Page main
$cuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_grid->Page_Render();
?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcuentagrid = new ew_Form("fcuentagrid", "grid");
fcuentagrid.FormKeyCountName = '<?php echo $cuenta_grid->FormKeyCountName ?>';

// Validate form
fcuentagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idsubcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->idsubcuenta->FldCaption(), $cuenta->idsubcuenta->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsubcuenta", false)) return false;
	return true;
}

// Form_CustomValidate event
fcuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuentagrid.ValidateRequired = true;
<?php } else { ?>
fcuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuentagrid.Lists["x_idsubcuenta"] = {"LinkField":"x_idsubcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($cuenta->CurrentAction == "gridadd") {
	if ($cuenta->CurrentMode == "copy") {
		$bSelectLimit = $cuenta_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cuenta_grid->TotalRecs = $cuenta->SelectRecordCount();
			$cuenta_grid->Recordset = $cuenta_grid->LoadRecordset($cuenta_grid->StartRec-1, $cuenta_grid->DisplayRecs);
		} else {
			if ($cuenta_grid->Recordset = $cuenta_grid->LoadRecordset())
				$cuenta_grid->TotalRecs = $cuenta_grid->Recordset->RecordCount();
		}
		$cuenta_grid->StartRec = 1;
		$cuenta_grid->DisplayRecs = $cuenta_grid->TotalRecs;
	} else {
		$cuenta->CurrentFilter = "0=1";
		$cuenta_grid->StartRec = 1;
		$cuenta_grid->DisplayRecs = $cuenta->GridAddRowCount;
	}
	$cuenta_grid->TotalRecs = $cuenta_grid->DisplayRecs;
	$cuenta_grid->StopRec = $cuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = $cuenta_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cuenta_grid->TotalRecs <= 0)
			$cuenta_grid->TotalRecs = $cuenta->SelectRecordCount();
	} else {
		if (!$cuenta_grid->Recordset && ($cuenta_grid->Recordset = $cuenta_grid->LoadRecordset()))
			$cuenta_grid->TotalRecs = $cuenta_grid->Recordset->RecordCount();
	}
	$cuenta_grid->StartRec = 1;
	$cuenta_grid->DisplayRecs = $cuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cuenta_grid->Recordset = $cuenta_grid->LoadRecordset($cuenta_grid->StartRec-1, $cuenta_grid->DisplayRecs);

	// Set no record found message
	if ($cuenta->CurrentAction == "" && $cuenta_grid->TotalRecs == 0) {
		if ($cuenta_grid->SearchWhere == "0=101")
			$cuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cuenta_grid->RenderOtherOptions();
?>
<?php $cuenta_grid->ShowPageHeader(); ?>
<?php
$cuenta_grid->ShowMessage();
?>
<?php if ($cuenta_grid->TotalRecs > 0 || $cuenta->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fcuentagrid" class="ewForm form-inline">
<div id="gmp_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_cuentagrid" class="table ewTable">
<?php echo $cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$cuenta_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cuenta_grid->RenderListOptions();

// Render list options (header, left)
$cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($cuenta->SortUrl($cuenta->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_cuenta_nomenclatura" class="cuenta_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $cuenta->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div><div id="elh_cuenta_nomenclatura" class="cuenta_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->nombre->Visible) { // nombre ?>
	<?php if ($cuenta->SortUrl($cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_cuenta_nombre" class="cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_cuenta_nombre" class="cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta->idsubcuenta->Visible) { // idsubcuenta ?>
	<?php if ($cuenta->SortUrl($cuenta->idsubcuenta) == "") { ?>
		<th data-name="idsubcuenta"><div id="elh_cuenta_idsubcuenta" class="cuenta_idsubcuenta"><div class="ewTableHeaderCaption"><?php echo $cuenta->idsubcuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsubcuenta"><div><div id="elh_cuenta_idsubcuenta" class="cuenta_idsubcuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta->idsubcuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta->idsubcuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta->idsubcuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cuenta_grid->StartRec = 1;
$cuenta_grid->StopRec = $cuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cuenta_grid->FormKeyCountName) && ($cuenta->CurrentAction == "gridadd" || $cuenta->CurrentAction == "gridedit" || $cuenta->CurrentAction == "F")) {
		$cuenta_grid->KeyCount = $objForm->GetValue($cuenta_grid->FormKeyCountName);
		$cuenta_grid->StopRec = $cuenta_grid->StartRec + $cuenta_grid->KeyCount - 1;
	}
}
$cuenta_grid->RecCnt = $cuenta_grid->StartRec - 1;
if ($cuenta_grid->Recordset && !$cuenta_grid->Recordset->EOF) {
	$cuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = $cuenta_grid->UseSelectLimit;
	if (!$bSelectLimit && $cuenta_grid->StartRec > 1)
		$cuenta_grid->Recordset->Move($cuenta_grid->StartRec - 1);
} elseif (!$cuenta->AllowAddDeleteRow && $cuenta_grid->StopRec == 0) {
	$cuenta_grid->StopRec = $cuenta->GridAddRowCount;
}

// Initialize aggregate
$cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cuenta->ResetAttrs();
$cuenta_grid->RenderRow();
if ($cuenta->CurrentAction == "gridadd")
	$cuenta_grid->RowIndex = 0;
if ($cuenta->CurrentAction == "gridedit")
	$cuenta_grid->RowIndex = 0;
while ($cuenta_grid->RecCnt < $cuenta_grid->StopRec) {
	$cuenta_grid->RecCnt++;
	if (intval($cuenta_grid->RecCnt) >= intval($cuenta_grid->StartRec)) {
		$cuenta_grid->RowCnt++;
		if ($cuenta->CurrentAction == "gridadd" || $cuenta->CurrentAction == "gridedit" || $cuenta->CurrentAction == "F") {
			$cuenta_grid->RowIndex++;
			$objForm->Index = $cuenta_grid->RowIndex;
			if ($objForm->HasValue($cuenta_grid->FormActionName))
				$cuenta_grid->RowAction = strval($objForm->GetValue($cuenta_grid->FormActionName));
			elseif ($cuenta->CurrentAction == "gridadd")
				$cuenta_grid->RowAction = "insert";
			else
				$cuenta_grid->RowAction = "";
		}

		// Set up key count
		$cuenta_grid->KeyCount = $cuenta_grid->RowIndex;

		// Init row class and style
		$cuenta->ResetAttrs();
		$cuenta->CssClass = "";
		if ($cuenta->CurrentAction == "gridadd") {
			if ($cuenta->CurrentMode == "copy") {
				$cuenta_grid->LoadRowValues($cuenta_grid->Recordset); // Load row values
				$cuenta_grid->SetRecordKey($cuenta_grid->RowOldKey, $cuenta_grid->Recordset); // Set old record key
			} else {
				$cuenta_grid->LoadDefaultValues(); // Load default values
				$cuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cuenta_grid->LoadRowValues($cuenta_grid->Recordset); // Load row values
		}
		$cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cuenta->CurrentAction == "gridadd") // Grid add
			$cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cuenta->CurrentAction == "gridadd" && $cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
		if ($cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($cuenta->EventCancelled) {
				$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
			}
			if ($cuenta_grid->RowAction == "insert")
				$cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cuenta->CurrentAction == "gridedit" && ($cuenta->RowType == EW_ROWTYPE_EDIT || $cuenta->RowType == EW_ROWTYPE_ADD) && $cuenta->EventCancelled) // Update failed
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values
		if ($cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cuenta_grid->EditRowCnt++;
		if ($cuenta->CurrentAction == "F") // Confirm row
			$cuenta_grid->RestoreCurrentRowFormValues($cuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cuenta->RowAttrs = array_merge($cuenta->RowAttrs, array('data-rowindex'=>$cuenta_grid->RowCnt, 'id'=>'r' . $cuenta_grid->RowCnt . '_cuenta', 'data-rowtype'=>$cuenta->RowType));

		// Render row
		$cuenta_grid->RenderRow();

		// Render list options
		$cuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cuenta_grid->RowAction <> "delete" && $cuenta_grid->RowAction <> "insertdelete" && !($cuenta_grid->RowAction == "insert" && $cuenta->CurrentAction == "F" && $cuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_grid->ListOptions->Render("body", "left", $cuenta_grid->RowCnt);
?>
	<?php if ($cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $cuenta->nomenclatura->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nomenclatura" class="form-group cuenta_nomenclatura">
<input type="text" data-table="cuenta" data-field="x_nomenclatura" name="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta->nomenclatura->EditValue ?>"<?php echo $cuenta->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nomenclatura" name="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nomenclatura" class="form-group cuenta_nomenclatura">
<input type="text" data-table="cuenta" data-field="x_nomenclatura" name="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta->nomenclatura->EditValue ?>"<?php echo $cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nomenclatura" class="cuenta_nomenclatura">
<span<?php echo $cuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $cuenta->nomenclatura->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nomenclatura" name="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta->nomenclatura->FormValue) ?>">
<input type="hidden" data-table="cuenta" data-field="x_nomenclatura" name="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cuenta_grid->PageObjName . "_row_" . $cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cuenta" data-field="x_idcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->CurrentValue) ?>">
<input type="hidden" data-table="cuenta" data-field="x_idcuenta" name="o<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="o<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT || $cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cuenta" data-field="x_idcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $cuenta->nombre->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-table="cuenta" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-table="cuenta" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_nombre" class="cuenta_nombre">
<span<?php echo $cuenta->nombre->ViewAttributes() ?>>
<?php echo $cuenta->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->FormValue) ?>">
<input type="hidden" data-table="cuenta" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta->idsubcuenta->Visible) { // idsubcuenta ?>
		<td data-name="idsubcuenta"<?php echo $cuenta->idsubcuenta->CellAttributes() ?>>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cuenta->idsubcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<span<?php echo $cuenta->idsubcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idsubcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<select data-table="cuenta" data-field="x_idsubcuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta->idsubcuenta->DisplayValueSeparator) ? json_encode($cuenta->idsubcuenta->DisplayValueSeparator) : $cuenta->idsubcuenta->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta"<?php echo $cuenta->idsubcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsubcuenta->EditValue)) {
	$arwrk = $cuenta->idsubcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta->idsubcuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta->idsubcuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta->idsubcuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>" selected><?php echo $cuenta->idsubcuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta->idsubcuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subcuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta->idsubcuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta->idsubcuenta->LookupFilters += array("f0" => "`idsubcuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta->Lookup_Selecting($cuenta->idsubcuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta->idsubcuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo $cuenta->idsubcuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="cuenta" data-field="x_idsubcuenta" name="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->OldValue) ?>">
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cuenta->idsubcuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<span<?php echo $cuenta->idsubcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idsubcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<select data-table="cuenta" data-field="x_idsubcuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta->idsubcuenta->DisplayValueSeparator) ? json_encode($cuenta->idsubcuenta->DisplayValueSeparator) : $cuenta->idsubcuenta->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta"<?php echo $cuenta->idsubcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsubcuenta->EditValue)) {
	$arwrk = $cuenta->idsubcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta->idsubcuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta->idsubcuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta->idsubcuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>" selected><?php echo $cuenta->idsubcuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta->idsubcuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subcuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta->idsubcuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta->idsubcuenta->LookupFilters += array("f0" => "`idsubcuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta->Lookup_Selecting($cuenta->idsubcuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta->idsubcuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo $cuenta->idsubcuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_grid->RowCnt ?>_cuenta_idsubcuenta" class="cuenta_idsubcuenta">
<span<?php echo $cuenta->idsubcuenta->ViewAttributes() ?>>
<?php echo $cuenta->idsubcuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->FormValue) ?>">
<input type="hidden" data-table="cuenta" data-field="x_idsubcuenta" name="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_grid->ListOptions->Render("body", "right", $cuenta_grid->RowCnt);
?>
	</tr>
<?php if ($cuenta->RowType == EW_ROWTYPE_ADD || $cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcuentagrid.UpdateOpts(<?php echo $cuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cuenta->CurrentAction <> "gridadd" || $cuenta->CurrentMode == "copy")
		if (!$cuenta_grid->Recordset->EOF) $cuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cuenta->CurrentMode == "add" || $cuenta->CurrentMode == "copy" || $cuenta->CurrentMode == "edit") {
		$cuenta_grid->RowIndex = '$rowindex$';
		$cuenta_grid->LoadDefaultValues();

		// Set row properties
		$cuenta->ResetAttrs();
		$cuenta->RowAttrs = array_merge($cuenta->RowAttrs, array('data-rowindex'=>$cuenta_grid->RowIndex, 'id'=>'r0_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cuenta->RowAttrs["class"], "ewTemplate");
		$cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cuenta_grid->RenderRow();

		// Render list options
		$cuenta_grid->RenderListOptions();
		$cuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_grid->ListOptions->Render("body", "left", $cuenta_grid->RowIndex);
?>
	<?php if ($cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_nomenclatura" class="form-group cuenta_nomenclatura">
<input type="text" data-table="cuenta" data-field="x_nomenclatura" name="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta->nomenclatura->EditValue ?>"<?php echo $cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_nomenclatura" class="form-group cuenta_nomenclatura">
<span<?php echo $cuenta->nomenclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->nomenclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nomenclatura" name="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta->nomenclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta" data-field="x_nomenclatura" name="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_nombre" class="form-group cuenta_nombre">
<input type="text" data-table="cuenta" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_nombre" class="form-group cuenta_nombre">
<span<?php echo $cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_nombre" name="x<?php echo $cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta" data-field="x_nombre" name="o<?php echo $cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta->idsubcuenta->Visible) { // idsubcuenta ?>
		<td data-name="idsubcuenta">
<?php if ($cuenta->CurrentAction <> "F") { ?>
<?php if ($cuenta->idsubcuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<span<?php echo $cuenta->idsubcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idsubcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<select data-table="cuenta" data-field="x_idsubcuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta->idsubcuenta->DisplayValueSeparator) ? json_encode($cuenta->idsubcuenta->DisplayValueSeparator) : $cuenta->idsubcuenta->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta"<?php echo $cuenta->idsubcuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta->idsubcuenta->EditValue)) {
	$arwrk = $cuenta->idsubcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta->idsubcuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta->idsubcuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta->idsubcuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->CurrentValue) ?>" selected><?php echo $cuenta->idsubcuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta->idsubcuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subcuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta->idsubcuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta->idsubcuenta->LookupFilters += array("f0" => "`idsubcuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta->Lookup_Selecting($cuenta->idsubcuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta->idsubcuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="s_x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo $cuenta->idsubcuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cuenta_idsubcuenta" class="form-group cuenta_idsubcuenta">
<span<?php echo $cuenta->idsubcuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta->idsubcuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta" data-field="x_idsubcuenta" name="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="x<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta" data-field="x_idsubcuenta" name="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" id="o<?php echo $cuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($cuenta->idsubcuenta->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_grid->ListOptions->Render("body", "right", $cuenta_grid->RowCnt);
?>
<script type="text/javascript">
fcuentagrid.UpdateOpts(<?php echo $cuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cuenta->CurrentMode == "add" || $cuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cuenta_grid->FormKeyCountName ?>" id="<?php echo $cuenta_grid->FormKeyCountName ?>" value="<?php echo $cuenta_grid->KeyCount ?>">
<?php echo $cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cuenta_grid->FormKeyCountName ?>" id="<?php echo $cuenta_grid->FormKeyCountName ?>" value="<?php echo $cuenta_grid->KeyCount ?>">
<?php echo $cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcuentagrid">
</div>
<?php

// Close recordset
if ($cuenta_grid->Recordset)
	$cuenta_grid->Recordset->Close();
?>
<?php if ($cuenta_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($cuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cuenta_grid->TotalRecs == 0 && $cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cuenta->Export == "") { ?>
<script type="text/javascript">
fcuentagrid.Init();
</script>
<?php } ?>
<?php
$cuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cuenta_grid->Page_Terminate();
?>
