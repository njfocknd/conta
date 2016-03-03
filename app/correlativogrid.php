<?php

// Create page object
if (!isset($correlativo_grid)) $correlativo_grid = new ccorrelativo_grid();

// Page init
$correlativo_grid->Page_Init();

// Page main
$correlativo_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$correlativo_grid->Page_Render();
?>
<?php if ($correlativo->Export == "") { ?>
<script type="text/javascript">

// Page object
var correlativo_grid = new ew_Page("correlativo_grid");
correlativo_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = correlativo_grid.PageID; // For backward compatibility

// Form object
var fcorrelativogrid = new ew_Form("fcorrelativogrid");
fcorrelativogrid.FormKeyCountName = '<?php echo $correlativo_grid->FormKeyCountName ?>';

// Validate form
fcorrelativogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_codigo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $correlativo->codigo->FldCaption(), $correlativo->codigo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_valor");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $correlativo->valor->FldCaption(), $correlativo->valor->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_valor");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($correlativo->valor->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $correlativo->idempresa->FldCaption(), $correlativo->idempresa->ReqErrMsg)) ?>");

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
fcorrelativogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "codigo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "valor", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	return true;
}

// Form_CustomValidate event
fcorrelativogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcorrelativogrid.ValidateRequired = true;
<?php } else { ?>
fcorrelativogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcorrelativogrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($correlativo->CurrentAction == "gridadd") {
	if ($correlativo->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$correlativo_grid->TotalRecs = $correlativo->SelectRecordCount();
			$correlativo_grid->Recordset = $correlativo_grid->LoadRecordset($correlativo_grid->StartRec-1, $correlativo_grid->DisplayRecs);
		} else {
			if ($correlativo_grid->Recordset = $correlativo_grid->LoadRecordset())
				$correlativo_grid->TotalRecs = $correlativo_grid->Recordset->RecordCount();
		}
		$correlativo_grid->StartRec = 1;
		$correlativo_grid->DisplayRecs = $correlativo_grid->TotalRecs;
	} else {
		$correlativo->CurrentFilter = "0=1";
		$correlativo_grid->StartRec = 1;
		$correlativo_grid->DisplayRecs = $correlativo->GridAddRowCount;
	}
	$correlativo_grid->TotalRecs = $correlativo_grid->DisplayRecs;
	$correlativo_grid->StopRec = $correlativo_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$correlativo_grid->TotalRecs = $correlativo->SelectRecordCount();
	} else {
		if ($correlativo_grid->Recordset = $correlativo_grid->LoadRecordset())
			$correlativo_grid->TotalRecs = $correlativo_grid->Recordset->RecordCount();
	}
	$correlativo_grid->StartRec = 1;
	$correlativo_grid->DisplayRecs = $correlativo_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$correlativo_grid->Recordset = $correlativo_grid->LoadRecordset($correlativo_grid->StartRec-1, $correlativo_grid->DisplayRecs);

	// Set no record found message
	if ($correlativo->CurrentAction == "" && $correlativo_grid->TotalRecs == 0) {
		if ($correlativo_grid->SearchWhere == "0=101")
			$correlativo_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$correlativo_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$correlativo_grid->RenderOtherOptions();
?>
<?php $correlativo_grid->ShowPageHeader(); ?>
<?php
$correlativo_grid->ShowMessage();
?>
<?php if ($correlativo_grid->TotalRecs > 0 || $correlativo->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fcorrelativogrid" class="ewForm form-inline">
<div id="gmp_correlativo" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_correlativogrid" class="table ewTable">
<?php echo $correlativo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$correlativo_grid->RenderListOptions();

// Render list options (header, left)
$correlativo_grid->ListOptions->Render("header", "left");
?>
<?php if ($correlativo->codigo->Visible) { // codigo ?>
	<?php if ($correlativo->SortUrl($correlativo->codigo) == "") { ?>
		<th data-name="codigo"><div id="elh_correlativo_codigo" class="correlativo_codigo"><div class="ewTableHeaderCaption"><?php echo $correlativo->codigo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo"><div><div id="elh_correlativo_codigo" class="correlativo_codigo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $correlativo->codigo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($correlativo->codigo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($correlativo->codigo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($correlativo->valor->Visible) { // valor ?>
	<?php if ($correlativo->SortUrl($correlativo->valor) == "") { ?>
		<th data-name="valor"><div id="elh_correlativo_valor" class="correlativo_valor"><div class="ewTableHeaderCaption"><?php echo $correlativo->valor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="valor"><div><div id="elh_correlativo_valor" class="correlativo_valor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $correlativo->valor->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($correlativo->valor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($correlativo->valor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($correlativo->idempresa->Visible) { // idempresa ?>
	<?php if ($correlativo->SortUrl($correlativo->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_correlativo_idempresa" class="correlativo_idempresa"><div class="ewTableHeaderCaption"><?php echo $correlativo->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_correlativo_idempresa" class="correlativo_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $correlativo->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($correlativo->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($correlativo->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$correlativo_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$correlativo_grid->StartRec = 1;
$correlativo_grid->StopRec = $correlativo_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($correlativo_grid->FormKeyCountName) && ($correlativo->CurrentAction == "gridadd" || $correlativo->CurrentAction == "gridedit" || $correlativo->CurrentAction == "F")) {
		$correlativo_grid->KeyCount = $objForm->GetValue($correlativo_grid->FormKeyCountName);
		$correlativo_grid->StopRec = $correlativo_grid->StartRec + $correlativo_grid->KeyCount - 1;
	}
}
$correlativo_grid->RecCnt = $correlativo_grid->StartRec - 1;
if ($correlativo_grid->Recordset && !$correlativo_grid->Recordset->EOF) {
	$correlativo_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $correlativo_grid->StartRec > 1)
		$correlativo_grid->Recordset->Move($correlativo_grid->StartRec - 1);
} elseif (!$correlativo->AllowAddDeleteRow && $correlativo_grid->StopRec == 0) {
	$correlativo_grid->StopRec = $correlativo->GridAddRowCount;
}

// Initialize aggregate
$correlativo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$correlativo->ResetAttrs();
$correlativo_grid->RenderRow();
if ($correlativo->CurrentAction == "gridadd")
	$correlativo_grid->RowIndex = 0;
if ($correlativo->CurrentAction == "gridedit")
	$correlativo_grid->RowIndex = 0;
while ($correlativo_grid->RecCnt < $correlativo_grid->StopRec) {
	$correlativo_grid->RecCnt++;
	if (intval($correlativo_grid->RecCnt) >= intval($correlativo_grid->StartRec)) {
		$correlativo_grid->RowCnt++;
		if ($correlativo->CurrentAction == "gridadd" || $correlativo->CurrentAction == "gridedit" || $correlativo->CurrentAction == "F") {
			$correlativo_grid->RowIndex++;
			$objForm->Index = $correlativo_grid->RowIndex;
			if ($objForm->HasValue($correlativo_grid->FormActionName))
				$correlativo_grid->RowAction = strval($objForm->GetValue($correlativo_grid->FormActionName));
			elseif ($correlativo->CurrentAction == "gridadd")
				$correlativo_grid->RowAction = "insert";
			else
				$correlativo_grid->RowAction = "";
		}

		// Set up key count
		$correlativo_grid->KeyCount = $correlativo_grid->RowIndex;

		// Init row class and style
		$correlativo->ResetAttrs();
		$correlativo->CssClass = "";
		if ($correlativo->CurrentAction == "gridadd") {
			if ($correlativo->CurrentMode == "copy") {
				$correlativo_grid->LoadRowValues($correlativo_grid->Recordset); // Load row values
				$correlativo_grid->SetRecordKey($correlativo_grid->RowOldKey, $correlativo_grid->Recordset); // Set old record key
			} else {
				$correlativo_grid->LoadDefaultValues(); // Load default values
				$correlativo_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$correlativo_grid->LoadRowValues($correlativo_grid->Recordset); // Load row values
		}
		$correlativo->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($correlativo->CurrentAction == "gridadd") // Grid add
			$correlativo->RowType = EW_ROWTYPE_ADD; // Render add
		if ($correlativo->CurrentAction == "gridadd" && $correlativo->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$correlativo_grid->RestoreCurrentRowFormValues($correlativo_grid->RowIndex); // Restore form values
		if ($correlativo->CurrentAction == "gridedit") { // Grid edit
			if ($correlativo->EventCancelled) {
				$correlativo_grid->RestoreCurrentRowFormValues($correlativo_grid->RowIndex); // Restore form values
			}
			if ($correlativo_grid->RowAction == "insert")
				$correlativo->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$correlativo->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($correlativo->CurrentAction == "gridedit" && ($correlativo->RowType == EW_ROWTYPE_EDIT || $correlativo->RowType == EW_ROWTYPE_ADD) && $correlativo->EventCancelled) // Update failed
			$correlativo_grid->RestoreCurrentRowFormValues($correlativo_grid->RowIndex); // Restore form values
		if ($correlativo->RowType == EW_ROWTYPE_EDIT) // Edit row
			$correlativo_grid->EditRowCnt++;
		if ($correlativo->CurrentAction == "F") // Confirm row
			$correlativo_grid->RestoreCurrentRowFormValues($correlativo_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$correlativo->RowAttrs = array_merge($correlativo->RowAttrs, array('data-rowindex'=>$correlativo_grid->RowCnt, 'id'=>'r' . $correlativo_grid->RowCnt . '_correlativo', 'data-rowtype'=>$correlativo->RowType));

		// Render row
		$correlativo_grid->RenderRow();

		// Render list options
		$correlativo_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($correlativo_grid->RowAction <> "delete" && $correlativo_grid->RowAction <> "insertdelete" && !($correlativo_grid->RowAction == "insert" && $correlativo->CurrentAction == "F" && $correlativo_grid->EmptyRow())) {
?>
	<tr<?php echo $correlativo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$correlativo_grid->ListOptions->Render("body", "left", $correlativo_grid->RowCnt);
?>
	<?php if ($correlativo->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $correlativo->codigo->CellAttributes() ?>>
<?php if ($correlativo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_codigo" class="form-group correlativo_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $correlativo_grid->RowIndex ?>_codigo" id="x<?php echo $correlativo_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($correlativo->codigo->PlaceHolder) ?>" value="<?php echo $correlativo->codigo->EditValue ?>"<?php echo $correlativo->codigo->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_codigo" name="o<?php echo $correlativo_grid->RowIndex ?>_codigo" id="o<?php echo $correlativo_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($correlativo->codigo->OldValue) ?>">
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_codigo" class="form-group correlativo_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $correlativo_grid->RowIndex ?>_codigo" id="x<?php echo $correlativo_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($correlativo->codigo->PlaceHolder) ?>" value="<?php echo $correlativo->codigo->EditValue ?>"<?php echo $correlativo->codigo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $correlativo->codigo->ViewAttributes() ?>>
<?php echo $correlativo->codigo->ListViewValue() ?></span>
<input type="hidden" data-field="x_codigo" name="x<?php echo $correlativo_grid->RowIndex ?>_codigo" id="x<?php echo $correlativo_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($correlativo->codigo->FormValue) ?>">
<input type="hidden" data-field="x_codigo" name="o<?php echo $correlativo_grid->RowIndex ?>_codigo" id="o<?php echo $correlativo_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($correlativo->codigo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $correlativo_grid->PageObjName . "_row_" . $correlativo_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcorrelativo" name="x<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" id="x<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" value="<?php echo ew_HtmlEncode($correlativo->idcorrelativo->CurrentValue) ?>">
<input type="hidden" data-field="x_idcorrelativo" name="o<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" id="o<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" value="<?php echo ew_HtmlEncode($correlativo->idcorrelativo->OldValue) ?>">
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_EDIT || $correlativo->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcorrelativo" name="x<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" id="x<?php echo $correlativo_grid->RowIndex ?>_idcorrelativo" value="<?php echo ew_HtmlEncode($correlativo->idcorrelativo->CurrentValue) ?>">
<?php } ?>
	<?php if ($correlativo->valor->Visible) { // valor ?>
		<td data-name="valor"<?php echo $correlativo->valor->CellAttributes() ?>>
<?php if ($correlativo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_valor" class="form-group correlativo_valor">
<input type="text" data-field="x_valor" name="x<?php echo $correlativo_grid->RowIndex ?>_valor" id="x<?php echo $correlativo_grid->RowIndex ?>_valor" size="30" placeholder="<?php echo ew_HtmlEncode($correlativo->valor->PlaceHolder) ?>" value="<?php echo $correlativo->valor->EditValue ?>"<?php echo $correlativo->valor->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_valor" name="o<?php echo $correlativo_grid->RowIndex ?>_valor" id="o<?php echo $correlativo_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($correlativo->valor->OldValue) ?>">
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_valor" class="form-group correlativo_valor">
<input type="text" data-field="x_valor" name="x<?php echo $correlativo_grid->RowIndex ?>_valor" id="x<?php echo $correlativo_grid->RowIndex ?>_valor" size="30" placeholder="<?php echo ew_HtmlEncode($correlativo->valor->PlaceHolder) ?>" value="<?php echo $correlativo->valor->EditValue ?>"<?php echo $correlativo->valor->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $correlativo->valor->ViewAttributes() ?>>
<?php echo $correlativo->valor->ListViewValue() ?></span>
<input type="hidden" data-field="x_valor" name="x<?php echo $correlativo_grid->RowIndex ?>_valor" id="x<?php echo $correlativo_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($correlativo->valor->FormValue) ?>">
<input type="hidden" data-field="x_valor" name="o<?php echo $correlativo_grid->RowIndex ?>_valor" id="o<?php echo $correlativo_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($correlativo->valor->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($correlativo->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $correlativo->idempresa->CellAttributes() ?>>
<?php if ($correlativo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($correlativo->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_idempresa" class="form-group correlativo_idempresa">
<span<?php echo $correlativo->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_idempresa" class="form-group correlativo_idempresa">
<select data-field="x_idempresa" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa"<?php echo $correlativo->idempresa->EditAttributes() ?>>
<?php
if (is_array($correlativo->idempresa->EditValue)) {
	$arwrk = $correlativo->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($correlativo->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $correlativo->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $correlativo->Lookup_Selecting($correlativo->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($correlativo->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_idempresa" class="form-group correlativo_idempresa">
<span<?php echo $correlativo->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $correlativo_grid->RowCnt ?>_correlativo_idempresa" class="form-group correlativo_idempresa">
<select data-field="x_idempresa" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa"<?php echo $correlativo->idempresa->EditAttributes() ?>>
<?php
if (is_array($correlativo->idempresa->EditValue)) {
	$arwrk = $correlativo->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($correlativo->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $correlativo->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $correlativo->Lookup_Selecting($correlativo->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($correlativo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $correlativo->idempresa->ViewAttributes() ?>>
<?php echo $correlativo->idempresa->ListViewValue() ?></span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->FormValue) ?>">
<input type="hidden" data-field="x_idempresa" name="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$correlativo_grid->ListOptions->Render("body", "right", $correlativo_grid->RowCnt);
?>
	</tr>
<?php if ($correlativo->RowType == EW_ROWTYPE_ADD || $correlativo->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcorrelativogrid.UpdateOpts(<?php echo $correlativo_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($correlativo->CurrentAction <> "gridadd" || $correlativo->CurrentMode == "copy")
		if (!$correlativo_grid->Recordset->EOF) $correlativo_grid->Recordset->MoveNext();
}
?>
<?php
	if ($correlativo->CurrentMode == "add" || $correlativo->CurrentMode == "copy" || $correlativo->CurrentMode == "edit") {
		$correlativo_grid->RowIndex = '$rowindex$';
		$correlativo_grid->LoadDefaultValues();

		// Set row properties
		$correlativo->ResetAttrs();
		$correlativo->RowAttrs = array_merge($correlativo->RowAttrs, array('data-rowindex'=>$correlativo_grid->RowIndex, 'id'=>'r0_correlativo', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($correlativo->RowAttrs["class"], "ewTemplate");
		$correlativo->RowType = EW_ROWTYPE_ADD;

		// Render row
		$correlativo_grid->RenderRow();

		// Render list options
		$correlativo_grid->RenderListOptions();
		$correlativo_grid->StartRowCnt = 0;
?>
	<tr<?php echo $correlativo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$correlativo_grid->ListOptions->Render("body", "left", $correlativo_grid->RowIndex);
?>
	<?php if ($correlativo->codigo->Visible) { // codigo ?>
		<td>
<?php if ($correlativo->CurrentAction <> "F") { ?>
<span id="el$rowindex$_correlativo_codigo" class="form-group correlativo_codigo">
<input type="text" data-field="x_codigo" name="x<?php echo $correlativo_grid->RowIndex ?>_codigo" id="x<?php echo $correlativo_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($correlativo->codigo->PlaceHolder) ?>" value="<?php echo $correlativo->codigo->EditValue ?>"<?php echo $correlativo->codigo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_correlativo_codigo" class="form-group correlativo_codigo">
<span<?php echo $correlativo->codigo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->codigo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_codigo" name="x<?php echo $correlativo_grid->RowIndex ?>_codigo" id="x<?php echo $correlativo_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($correlativo->codigo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_codigo" name="o<?php echo $correlativo_grid->RowIndex ?>_codigo" id="o<?php echo $correlativo_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($correlativo->codigo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($correlativo->valor->Visible) { // valor ?>
		<td>
<?php if ($correlativo->CurrentAction <> "F") { ?>
<span id="el$rowindex$_correlativo_valor" class="form-group correlativo_valor">
<input type="text" data-field="x_valor" name="x<?php echo $correlativo_grid->RowIndex ?>_valor" id="x<?php echo $correlativo_grid->RowIndex ?>_valor" size="30" placeholder="<?php echo ew_HtmlEncode($correlativo->valor->PlaceHolder) ?>" value="<?php echo $correlativo->valor->EditValue ?>"<?php echo $correlativo->valor->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_correlativo_valor" class="form-group correlativo_valor">
<span<?php echo $correlativo->valor->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->valor->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_valor" name="x<?php echo $correlativo_grid->RowIndex ?>_valor" id="x<?php echo $correlativo_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($correlativo->valor->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_valor" name="o<?php echo $correlativo_grid->RowIndex ?>_valor" id="o<?php echo $correlativo_grid->RowIndex ?>_valor" value="<?php echo ew_HtmlEncode($correlativo->valor->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($correlativo->idempresa->Visible) { // idempresa ?>
		<td>
<?php if ($correlativo->CurrentAction <> "F") { ?>
<?php if ($correlativo->idempresa->getSessionValue() <> "") { ?>
<span id="el$rowindex$_correlativo_idempresa" class="form-group correlativo_idempresa">
<span<?php echo $correlativo->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_correlativo_idempresa" class="form-group correlativo_idempresa">
<select data-field="x_idempresa" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa"<?php echo $correlativo->idempresa->EditAttributes() ?>>
<?php
if (is_array($correlativo->idempresa->EditValue)) {
	$arwrk = $correlativo->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($correlativo->idempresa->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $correlativo->idempresa->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $correlativo->Lookup_Selecting($correlativo->idempresa, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="s_x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idempresa` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_correlativo_idempresa" class="form-group correlativo_idempresa">
<span<?php echo $correlativo->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $correlativo->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idempresa" name="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="x<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idempresa" name="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" id="o<?php echo $correlativo_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($correlativo->idempresa->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$correlativo_grid->ListOptions->Render("body", "right", $correlativo_grid->RowCnt);
?>
<script type="text/javascript">
fcorrelativogrid.UpdateOpts(<?php echo $correlativo_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($correlativo->CurrentMode == "add" || $correlativo->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $correlativo_grid->FormKeyCountName ?>" id="<?php echo $correlativo_grid->FormKeyCountName ?>" value="<?php echo $correlativo_grid->KeyCount ?>">
<?php echo $correlativo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($correlativo->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $correlativo_grid->FormKeyCountName ?>" id="<?php echo $correlativo_grid->FormKeyCountName ?>" value="<?php echo $correlativo_grid->KeyCount ?>">
<?php echo $correlativo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($correlativo->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcorrelativogrid">
</div>
<?php

// Close recordset
if ($correlativo_grid->Recordset)
	$correlativo_grid->Recordset->Close();
?>
<?php if ($correlativo_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($correlativo_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($correlativo_grid->TotalRecs == 0 && $correlativo->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($correlativo_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($correlativo->Export == "") { ?>
<script type="text/javascript">
fcorrelativogrid.Init();
</script>
<?php } ?>
<?php
$correlativo_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$correlativo_grid->Page_Terminate();
?>
