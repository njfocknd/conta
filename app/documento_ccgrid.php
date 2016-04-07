<?php

// Create page object
if (!isset($documento_cc_grid)) $documento_cc_grid = new cdocumento_cc_grid();

// Page init
$documento_cc_grid->Page_Init();

// Page main
$documento_cc_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_cc_grid->Page_Render();
?>
<?php if ($documento_cc->Export == "") { ?>
<script type="text/javascript">

// Page object
var documento_cc_grid = new ew_Page("documento_cc_grid");
documento_cc_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = documento_cc_grid.PageID; // For backward compatibility

// Form object
var fdocumento_ccgrid = new ew_Form("fdocumento_ccgrid");
fdocumento_ccgrid.FormKeyCountName = '<?php echo $documento_cc_grid->FormKeyCountName ?>';

// Validate form
fdocumento_ccgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->idtipo_documento->FldCaption(), $documento_cc->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->tipo->FldCaption(), $documento_cc->tipo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->fecha->FldCaption(), $documento_cc->fecha->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_cc->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_serie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->serie->FldCaption(), $documento_cc->serie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_numero");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->numero->FldCaption(), $documento_cc->numero->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->monto->FldCaption(), $documento_cc->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_cc->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcaja_chica");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_cc->idcaja_chica->FldCaption(), $documento_cc->idcaja_chica->ReqErrMsg)) ?>");

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
fdocumento_ccgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idtipo_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tipo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "serie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcaja_chica", false)) return false;
	return true;
}

// Form_CustomValidate event
fdocumento_ccgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_ccgrid.ValidateRequired = true;
<?php } else { ?>
fdocumento_ccgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_ccgrid.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fdocumento_ccgrid.Lists["x_idcaja_chica"] = {"LinkField":"x_idcaja_chica","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($documento_cc->CurrentAction == "gridadd") {
	if ($documento_cc->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$documento_cc_grid->TotalRecs = $documento_cc->SelectRecordCount();
			$documento_cc_grid->Recordset = $documento_cc_grid->LoadRecordset($documento_cc_grid->StartRec-1, $documento_cc_grid->DisplayRecs);
		} else {
			if ($documento_cc_grid->Recordset = $documento_cc_grid->LoadRecordset())
				$documento_cc_grid->TotalRecs = $documento_cc_grid->Recordset->RecordCount();
		}
		$documento_cc_grid->StartRec = 1;
		$documento_cc_grid->DisplayRecs = $documento_cc_grid->TotalRecs;
	} else {
		$documento_cc->CurrentFilter = "0=1";
		$documento_cc_grid->StartRec = 1;
		$documento_cc_grid->DisplayRecs = $documento_cc->GridAddRowCount;
	}
	$documento_cc_grid->TotalRecs = $documento_cc_grid->DisplayRecs;
	$documento_cc_grid->StopRec = $documento_cc_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$documento_cc_grid->TotalRecs = $documento_cc->SelectRecordCount();
	} else {
		if ($documento_cc_grid->Recordset = $documento_cc_grid->LoadRecordset())
			$documento_cc_grid->TotalRecs = $documento_cc_grid->Recordset->RecordCount();
	}
	$documento_cc_grid->StartRec = 1;
	$documento_cc_grid->DisplayRecs = $documento_cc_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$documento_cc_grid->Recordset = $documento_cc_grid->LoadRecordset($documento_cc_grid->StartRec-1, $documento_cc_grid->DisplayRecs);

	// Set no record found message
	if ($documento_cc->CurrentAction == "" && $documento_cc_grid->TotalRecs == 0) {
		if ($documento_cc_grid->SearchWhere == "0=101")
			$documento_cc_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$documento_cc_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$documento_cc_grid->RenderOtherOptions();
?>
<?php $documento_cc_grid->ShowPageHeader(); ?>
<?php
$documento_cc_grid->ShowMessage();
?>
<?php if ($documento_cc_grid->TotalRecs > 0 || $documento_cc->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fdocumento_ccgrid" class="ewForm form-inline">
<div id="gmp_documento_cc" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_documento_ccgrid" class="table ewTable">
<?php echo $documento_cc->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$documento_cc_grid->RenderListOptions();

// Render list options (header, left)
$documento_cc_grid->ListOptions->Render("header", "left");
?>
<?php if ($documento_cc->idtipo_documento->Visible) { // idtipo_documento ?>
	<?php if ($documento_cc->SortUrl($documento_cc->idtipo_documento) == "") { ?>
		<th data-name="idtipo_documento"><div id="elh_documento_cc_idtipo_documento" class="documento_cc_idtipo_documento"><div class="ewTableHeaderCaption"><?php echo $documento_cc->idtipo_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_documento"><div><div id="elh_documento_cc_idtipo_documento" class="documento_cc_idtipo_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->idtipo_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->idtipo_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->idtipo_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->tipo->Visible) { // tipo ?>
	<?php if ($documento_cc->SortUrl($documento_cc->tipo) == "") { ?>
		<th data-name="tipo"><div id="elh_documento_cc_tipo" class="documento_cc_tipo"><div class="ewTableHeaderCaption"><?php echo $documento_cc->tipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo"><div><div id="elh_documento_cc_tipo" class="documento_cc_tipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->tipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->tipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->tipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->fecha->Visible) { // fecha ?>
	<?php if ($documento_cc->SortUrl($documento_cc->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_documento_cc_fecha" class="documento_cc_fecha"><div class="ewTableHeaderCaption"><?php echo $documento_cc->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_documento_cc_fecha" class="documento_cc_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->serie->Visible) { // serie ?>
	<?php if ($documento_cc->SortUrl($documento_cc->serie) == "") { ?>
		<th data-name="serie"><div id="elh_documento_cc_serie" class="documento_cc_serie"><div class="ewTableHeaderCaption"><?php echo $documento_cc->serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="serie"><div><div id="elh_documento_cc_serie" class="documento_cc_serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->serie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->numero->Visible) { // numero ?>
	<?php if ($documento_cc->SortUrl($documento_cc->numero) == "") { ?>
		<th data-name="numero"><div id="elh_documento_cc_numero" class="documento_cc_numero"><div class="ewTableHeaderCaption"><?php echo $documento_cc->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_documento_cc_numero" class="documento_cc_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->monto->Visible) { // monto ?>
	<?php if ($documento_cc->SortUrl($documento_cc->monto) == "") { ?>
		<th data-name="monto"><div id="elh_documento_cc_monto" class="documento_cc_monto"><div class="ewTableHeaderCaption"><?php echo $documento_cc->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_documento_cc_monto" class="documento_cc_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_cc->idcaja_chica->Visible) { // idcaja_chica ?>
	<?php if ($documento_cc->SortUrl($documento_cc->idcaja_chica) == "") { ?>
		<th data-name="idcaja_chica"><div id="elh_documento_cc_idcaja_chica" class="documento_cc_idcaja_chica"><div class="ewTableHeaderCaption"><?php echo $documento_cc->idcaja_chica->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcaja_chica"><div><div id="elh_documento_cc_idcaja_chica" class="documento_cc_idcaja_chica">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_cc->idcaja_chica->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_cc->idcaja_chica->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_cc->idcaja_chica->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$documento_cc_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$documento_cc_grid->StartRec = 1;
$documento_cc_grid->StopRec = $documento_cc_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($documento_cc_grid->FormKeyCountName) && ($documento_cc->CurrentAction == "gridadd" || $documento_cc->CurrentAction == "gridedit" || $documento_cc->CurrentAction == "F")) {
		$documento_cc_grid->KeyCount = $objForm->GetValue($documento_cc_grid->FormKeyCountName);
		$documento_cc_grid->StopRec = $documento_cc_grid->StartRec + $documento_cc_grid->KeyCount - 1;
	}
}
$documento_cc_grid->RecCnt = $documento_cc_grid->StartRec - 1;
if ($documento_cc_grid->Recordset && !$documento_cc_grid->Recordset->EOF) {
	$documento_cc_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $documento_cc_grid->StartRec > 1)
		$documento_cc_grid->Recordset->Move($documento_cc_grid->StartRec - 1);
} elseif (!$documento_cc->AllowAddDeleteRow && $documento_cc_grid->StopRec == 0) {
	$documento_cc_grid->StopRec = $documento_cc->GridAddRowCount;
}

// Initialize aggregate
$documento_cc->RowType = EW_ROWTYPE_AGGREGATEINIT;
$documento_cc->ResetAttrs();
$documento_cc_grid->RenderRow();
if ($documento_cc->CurrentAction == "gridadd")
	$documento_cc_grid->RowIndex = 0;
if ($documento_cc->CurrentAction == "gridedit")
	$documento_cc_grid->RowIndex = 0;
while ($documento_cc_grid->RecCnt < $documento_cc_grid->StopRec) {
	$documento_cc_grid->RecCnt++;
	if (intval($documento_cc_grid->RecCnt) >= intval($documento_cc_grid->StartRec)) {
		$documento_cc_grid->RowCnt++;
		if ($documento_cc->CurrentAction == "gridadd" || $documento_cc->CurrentAction == "gridedit" || $documento_cc->CurrentAction == "F") {
			$documento_cc_grid->RowIndex++;
			$objForm->Index = $documento_cc_grid->RowIndex;
			if ($objForm->HasValue($documento_cc_grid->FormActionName))
				$documento_cc_grid->RowAction = strval($objForm->GetValue($documento_cc_grid->FormActionName));
			elseif ($documento_cc->CurrentAction == "gridadd")
				$documento_cc_grid->RowAction = "insert";
			else
				$documento_cc_grid->RowAction = "";
		}

		// Set up key count
		$documento_cc_grid->KeyCount = $documento_cc_grid->RowIndex;

		// Init row class and style
		$documento_cc->ResetAttrs();
		$documento_cc->CssClass = "";
		if ($documento_cc->CurrentAction == "gridadd") {
			if ($documento_cc->CurrentMode == "copy") {
				$documento_cc_grid->LoadRowValues($documento_cc_grid->Recordset); // Load row values
				$documento_cc_grid->SetRecordKey($documento_cc_grid->RowOldKey, $documento_cc_grid->Recordset); // Set old record key
			} else {
				$documento_cc_grid->LoadDefaultValues(); // Load default values
				$documento_cc_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$documento_cc_grid->LoadRowValues($documento_cc_grid->Recordset); // Load row values
		}
		$documento_cc->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($documento_cc->CurrentAction == "gridadd") // Grid add
			$documento_cc->RowType = EW_ROWTYPE_ADD; // Render add
		if ($documento_cc->CurrentAction == "gridadd" && $documento_cc->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$documento_cc_grid->RestoreCurrentRowFormValues($documento_cc_grid->RowIndex); // Restore form values
		if ($documento_cc->CurrentAction == "gridedit") { // Grid edit
			if ($documento_cc->EventCancelled) {
				$documento_cc_grid->RestoreCurrentRowFormValues($documento_cc_grid->RowIndex); // Restore form values
			}
			if ($documento_cc_grid->RowAction == "insert")
				$documento_cc->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$documento_cc->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($documento_cc->CurrentAction == "gridedit" && ($documento_cc->RowType == EW_ROWTYPE_EDIT || $documento_cc->RowType == EW_ROWTYPE_ADD) && $documento_cc->EventCancelled) // Update failed
			$documento_cc_grid->RestoreCurrentRowFormValues($documento_cc_grid->RowIndex); // Restore form values
		if ($documento_cc->RowType == EW_ROWTYPE_EDIT) // Edit row
			$documento_cc_grid->EditRowCnt++;
		if ($documento_cc->CurrentAction == "F") // Confirm row
			$documento_cc_grid->RestoreCurrentRowFormValues($documento_cc_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$documento_cc->RowAttrs = array_merge($documento_cc->RowAttrs, array('data-rowindex'=>$documento_cc_grid->RowCnt, 'id'=>'r' . $documento_cc_grid->RowCnt . '_documento_cc', 'data-rowtype'=>$documento_cc->RowType));

		// Render row
		$documento_cc_grid->RenderRow();

		// Render list options
		$documento_cc_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($documento_cc_grid->RowAction <> "delete" && $documento_cc_grid->RowAction <> "insertdelete" && !($documento_cc_grid->RowAction == "insert" && $documento_cc->CurrentAction == "F" && $documento_cc_grid->EmptyRow())) {
?>
	<tr<?php echo $documento_cc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_cc_grid->ListOptions->Render("body", "left", $documento_cc_grid->RowCnt);
?>
	<?php if ($documento_cc->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento"<?php echo $documento_cc->idtipo_documento->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idtipo_documento" class="form-group documento_cc_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_cc->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idtipo_documento->EditValue)) {
	$arwrk = $documento_cc->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_cc->idtipo_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idtipo_documento" class="form-group documento_cc_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_cc->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idtipo_documento->EditValue)) {
	$arwrk = $documento_cc->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_cc->idtipo_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_cc->idtipo_documento->FormValue) ?>">
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_cc->idtipo_documento->OldValue) ?>">
<?php } ?>
<a id="<?php echo $documento_cc_grid->PageObjName . "_row_" . $documento_cc_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_iddocumento_cc" name="x<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" id="x<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" value="<?php echo ew_HtmlEncode($documento_cc->iddocumento_cc->CurrentValue) ?>">
<input type="hidden" data-field="x_iddocumento_cc" name="o<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" id="o<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" value="<?php echo ew_HtmlEncode($documento_cc->iddocumento_cc->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT || $documento_cc->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_iddocumento_cc" name="x<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" id="x<?php echo $documento_cc_grid->RowIndex ?>_iddocumento_cc" value="<?php echo ew_HtmlEncode($documento_cc->iddocumento_cc->CurrentValue) ?>">
<?php } ?>
	<?php if ($documento_cc->tipo->Visible) { // tipo ?>
		<td data-name="tipo"<?php echo $documento_cc->tipo->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_tipo" class="form-group documento_cc_tipo">
<select data-field="x_tipo" id="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" name="x<?php echo $documento_cc_grid->RowIndex ?>_tipo"<?php echo $documento_cc->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_cc->tipo->EditValue)) {
	$arwrk = $documento_cc->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->tipo->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_tipo" name="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" id="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_cc->tipo->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_tipo" class="form-group documento_cc_tipo">
<select data-field="x_tipo" id="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" name="x<?php echo $documento_cc_grid->RowIndex ?>_tipo"<?php echo $documento_cc->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_cc->tipo->EditValue)) {
	$arwrk = $documento_cc->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->tipo->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->tipo->ViewAttributes() ?>>
<?php echo $documento_cc->tipo->ListViewValue() ?></span>
<input type="hidden" data-field="x_tipo" name="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" id="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_cc->tipo->FormValue) ?>">
<input type="hidden" data-field="x_tipo" name="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" id="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_cc->tipo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_cc->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $documento_cc->fecha->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_fecha" class="form-group documento_cc_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_cc->fecha->PlaceHolder) ?>" value="<?php echo $documento_cc->fecha->EditValue ?>"<?php echo $documento_cc->fecha->EditAttributes() ?>>
<?php if (!$documento_cc->fecha->ReadOnly && !$documento_cc->fecha->Disabled && @$documento_cc->fecha->EditAttrs["readonly"] == "" && @$documento_cc->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_ccgrid", "x<?php echo $documento_cc_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_cc->fecha->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_fecha" class="form-group documento_cc_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_cc->fecha->PlaceHolder) ?>" value="<?php echo $documento_cc->fecha->EditValue ?>"<?php echo $documento_cc->fecha->EditAttributes() ?>>
<?php if (!$documento_cc->fecha->ReadOnly && !$documento_cc->fecha->Disabled && @$documento_cc->fecha->EditAttrs["readonly"] == "" && @$documento_cc->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_ccgrid", "x<?php echo $documento_cc_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->fecha->ViewAttributes() ?>>
<?php echo $documento_cc->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_cc->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_cc->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_cc->serie->Visible) { // serie ?>
		<td data-name="serie"<?php echo $documento_cc->serie->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_serie" class="form-group documento_cc_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_cc_grid->RowIndex ?>_serie" id="x<?php echo $documento_cc_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->serie->PlaceHolder) ?>" value="<?php echo $documento_cc->serie->EditValue ?>"<?php echo $documento_cc->serie->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_cc_grid->RowIndex ?>_serie" id="o<?php echo $documento_cc_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_cc->serie->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_serie" class="form-group documento_cc_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_cc_grid->RowIndex ?>_serie" id="x<?php echo $documento_cc_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->serie->PlaceHolder) ?>" value="<?php echo $documento_cc->serie->EditValue ?>"<?php echo $documento_cc->serie->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->serie->ViewAttributes() ?>>
<?php echo $documento_cc->serie->ListViewValue() ?></span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_cc_grid->RowIndex ?>_serie" id="x<?php echo $documento_cc_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_cc->serie->FormValue) ?>">
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_cc_grid->RowIndex ?>_serie" id="o<?php echo $documento_cc_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_cc->serie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_cc->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $documento_cc->numero->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_numero" class="form-group documento_cc_numero">
<input type="text" data-field="x_numero" name="x<?php echo $documento_cc_grid->RowIndex ?>_numero" id="x<?php echo $documento_cc_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->numero->PlaceHolder) ?>" value="<?php echo $documento_cc->numero->EditValue ?>"<?php echo $documento_cc->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_numero" name="o<?php echo $documento_cc_grid->RowIndex ?>_numero" id="o<?php echo $documento_cc_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_cc->numero->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_numero" class="form-group documento_cc_numero">
<input type="text" data-field="x_numero" name="x<?php echo $documento_cc_grid->RowIndex ?>_numero" id="x<?php echo $documento_cc_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->numero->PlaceHolder) ?>" value="<?php echo $documento_cc->numero->EditValue ?>"<?php echo $documento_cc->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->numero->ViewAttributes() ?>>
<?php echo $documento_cc->numero->ListViewValue() ?></span>
<input type="hidden" data-field="x_numero" name="x<?php echo $documento_cc_grid->RowIndex ?>_numero" id="x<?php echo $documento_cc_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_cc->numero->FormValue) ?>">
<input type="hidden" data-field="x_numero" name="o<?php echo $documento_cc_grid->RowIndex ?>_numero" id="o<?php echo $documento_cc_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_cc->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_cc->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $documento_cc->monto->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_monto" class="form-group documento_cc_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_cc_grid->RowIndex ?>_monto" id="x<?php echo $documento_cc_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_cc->monto->PlaceHolder) ?>" value="<?php echo $documento_cc->monto->EditValue ?>"<?php echo $documento_cc->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_cc_grid->RowIndex ?>_monto" id="o<?php echo $documento_cc_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_cc->monto->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_monto" class="form-group documento_cc_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_cc_grid->RowIndex ?>_monto" id="x<?php echo $documento_cc_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_cc->monto->PlaceHolder) ?>" value="<?php echo $documento_cc->monto->EditValue ?>"<?php echo $documento_cc->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->monto->ViewAttributes() ?>>
<?php echo $documento_cc->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_cc_grid->RowIndex ?>_monto" id="x<?php echo $documento_cc_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_cc->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_cc_grid->RowIndex ?>_monto" id="o<?php echo $documento_cc_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_cc->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_cc->idcaja_chica->Visible) { // idcaja_chica ?>
		<td data-name="idcaja_chica"<?php echo $documento_cc->idcaja_chica->CellAttributes() ?>>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($documento_cc->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<span<?php echo $documento_cc->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<select data-field="x_idcaja_chica" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica"<?php echo $documento_cc->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idcaja_chica->EditValue)) {
	$arwrk = $documento_cc->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idcaja_chica->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idcaja_chica->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idcaja_chica, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcaja_chica` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcaja_chica" name="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->OldValue) ?>">
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($documento_cc->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<span<?php echo $documento_cc->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $documento_cc_grid->RowCnt ?>_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<select data-field="x_idcaja_chica" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica"<?php echo $documento_cc->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idcaja_chica->EditValue)) {
	$arwrk = $documento_cc->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idcaja_chica->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idcaja_chica->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idcaja_chica, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcaja_chica` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($documento_cc->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $documento_cc->idcaja_chica->ViewAttributes() ?>>
<?php echo $documento_cc->idcaja_chica->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->FormValue) ?>">
<input type="hidden" data-field="x_idcaja_chica" name="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_cc_grid->ListOptions->Render("body", "right", $documento_cc_grid->RowCnt);
?>
	</tr>
<?php if ($documento_cc->RowType == EW_ROWTYPE_ADD || $documento_cc->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdocumento_ccgrid.UpdateOpts(<?php echo $documento_cc_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($documento_cc->CurrentAction <> "gridadd" || $documento_cc->CurrentMode == "copy")
		if (!$documento_cc_grid->Recordset->EOF) $documento_cc_grid->Recordset->MoveNext();
}
?>
<?php
	if ($documento_cc->CurrentMode == "add" || $documento_cc->CurrentMode == "copy" || $documento_cc->CurrentMode == "edit") {
		$documento_cc_grid->RowIndex = '$rowindex$';
		$documento_cc_grid->LoadDefaultValues();

		// Set row properties
		$documento_cc->ResetAttrs();
		$documento_cc->RowAttrs = array_merge($documento_cc->RowAttrs, array('data-rowindex'=>$documento_cc_grid->RowIndex, 'id'=>'r0_documento_cc', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($documento_cc->RowAttrs["class"], "ewTemplate");
		$documento_cc->RowType = EW_ROWTYPE_ADD;

		// Render row
		$documento_cc_grid->RenderRow();

		// Render list options
		$documento_cc_grid->RenderListOptions();
		$documento_cc_grid->StartRowCnt = 0;
?>
	<tr<?php echo $documento_cc->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_cc_grid->ListOptions->Render("body", "left", $documento_cc_grid->RowIndex);
?>
	<?php if ($documento_cc->idtipo_documento->Visible) { // idtipo_documento ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_idtipo_documento" class="form-group documento_cc_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_cc->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idtipo_documento->EditValue)) {
	$arwrk = $documento_cc->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idtipo_documento->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_idtipo_documento" class="form-group documento_cc_idtipo_documento">
<span<?php echo $documento_cc->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_cc->idtipo_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_cc_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_cc->idtipo_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->tipo->Visible) { // tipo ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_tipo" class="form-group documento_cc_tipo">
<select data-field="x_tipo" id="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" name="x<?php echo $documento_cc_grid->RowIndex ?>_tipo"<?php echo $documento_cc->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_cc->tipo->EditValue)) {
	$arwrk = $documento_cc->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->tipo->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_tipo" class="form-group documento_cc_tipo">
<span<?php echo $documento_cc->tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->tipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_tipo" name="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" id="x<?php echo $documento_cc_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_cc->tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_tipo" name="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" id="o<?php echo $documento_cc_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_cc->tipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->fecha->Visible) { // fecha ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_fecha" class="form-group documento_cc_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_cc->fecha->PlaceHolder) ?>" value="<?php echo $documento_cc->fecha->EditValue ?>"<?php echo $documento_cc->fecha->EditAttributes() ?>>
<?php if (!$documento_cc->fecha->ReadOnly && !$documento_cc->fecha->Disabled && @$documento_cc->fecha->EditAttrs["readonly"] == "" && @$documento_cc->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_ccgrid", "x<?php echo $documento_cc_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_fecha" class="form-group documento_cc_fecha">
<span<?php echo $documento_cc->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="x<?php echo $documento_cc_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_cc->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" id="o<?php echo $documento_cc_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_cc->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->serie->Visible) { // serie ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_serie" class="form-group documento_cc_serie">
<input type="text" data-field="x_serie" name="x<?php echo $documento_cc_grid->RowIndex ?>_serie" id="x<?php echo $documento_cc_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->serie->PlaceHolder) ?>" value="<?php echo $documento_cc->serie->EditValue ?>"<?php echo $documento_cc->serie->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_serie" class="form-group documento_cc_serie">
<span<?php echo $documento_cc->serie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->serie->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_serie" name="x<?php echo $documento_cc_grid->RowIndex ?>_serie" id="x<?php echo $documento_cc_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_cc->serie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_serie" name="o<?php echo $documento_cc_grid->RowIndex ?>_serie" id="o<?php echo $documento_cc_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_cc->serie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->numero->Visible) { // numero ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_numero" class="form-group documento_cc_numero">
<input type="text" data-field="x_numero" name="x<?php echo $documento_cc_grid->RowIndex ?>_numero" id="x<?php echo $documento_cc_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_cc->numero->PlaceHolder) ?>" value="<?php echo $documento_cc->numero->EditValue ?>"<?php echo $documento_cc->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_numero" class="form-group documento_cc_numero">
<span<?php echo $documento_cc->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_numero" name="x<?php echo $documento_cc_grid->RowIndex ?>_numero" id="x<?php echo $documento_cc_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_cc->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_numero" name="o<?php echo $documento_cc_grid->RowIndex ?>_numero" id="o<?php echo $documento_cc_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_cc->numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->monto->Visible) { // monto ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_cc_monto" class="form-group documento_cc_monto">
<input type="text" data-field="x_monto" name="x<?php echo $documento_cc_grid->RowIndex ?>_monto" id="x<?php echo $documento_cc_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_cc->monto->PlaceHolder) ?>" value="<?php echo $documento_cc->monto->EditValue ?>"<?php echo $documento_cc->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_monto" class="form-group documento_cc_monto">
<span<?php echo $documento_cc->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $documento_cc_grid->RowIndex ?>_monto" id="x<?php echo $documento_cc_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_cc->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $documento_cc_grid->RowIndex ?>_monto" id="o<?php echo $documento_cc_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_cc->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_cc->idcaja_chica->Visible) { // idcaja_chica ?>
		<td>
<?php if ($documento_cc->CurrentAction <> "F") { ?>
<?php if ($documento_cc->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el$rowindex$_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<span<?php echo $documento_cc->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<select data-field="x_idcaja_chica" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica"<?php echo $documento_cc->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($documento_cc->idcaja_chica->EditValue)) {
	$arwrk = $documento_cc->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($documento_cc->idcaja_chica->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $documento_cc->idcaja_chica->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $documento_cc->Lookup_Selecting($documento_cc->idcaja_chica, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcaja_chica` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_documento_cc_idcaja_chica" class="form-group documento_cc_idcaja_chica">
<span<?php echo $documento_cc->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_cc->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcaja_chica" name="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="x<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcaja_chica" name="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $documento_cc_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_cc->idcaja_chica->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_cc_grid->ListOptions->Render("body", "right", $documento_cc_grid->RowCnt);
?>
<script type="text/javascript">
fdocumento_ccgrid.UpdateOpts(<?php echo $documento_cc_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($documento_cc->CurrentMode == "add" || $documento_cc->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $documento_cc_grid->FormKeyCountName ?>" id="<?php echo $documento_cc_grid->FormKeyCountName ?>" value="<?php echo $documento_cc_grid->KeyCount ?>">
<?php echo $documento_cc_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_cc->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $documento_cc_grid->FormKeyCountName ?>" id="<?php echo $documento_cc_grid->FormKeyCountName ?>" value="<?php echo $documento_cc_grid->KeyCount ?>">
<?php echo $documento_cc_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_cc->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdocumento_ccgrid">
</div>
<?php

// Close recordset
if ($documento_cc_grid->Recordset)
	$documento_cc_grid->Recordset->Close();
?>
<?php if ($documento_cc_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($documento_cc_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($documento_cc_grid->TotalRecs == 0 && $documento_cc->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($documento_cc_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($documento_cc->Export == "") { ?>
<script type="text/javascript">
fdocumento_ccgrid.Init();
</script>
<?php } ?>
<?php
$documento_cc_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$documento_cc_grid->Page_Terminate();
?>
