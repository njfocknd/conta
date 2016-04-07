<?php

// Create page object
if (!isset($tipo_documento_modulo_grid)) $tipo_documento_modulo_grid = new ctipo_documento_modulo_grid();

// Page init
$tipo_documento_modulo_grid->Page_Init();

// Page main
$tipo_documento_modulo_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipo_documento_modulo_grid->Page_Render();
?>
<?php if ($tipo_documento_modulo->Export == "") { ?>
<script type="text/javascript">

// Page object
var tipo_documento_modulo_grid = new ew_Page("tipo_documento_modulo_grid");
tipo_documento_modulo_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = tipo_documento_modulo_grid.PageID; // For backward compatibility

// Form object
var ftipo_documento_modulogrid = new ew_Form("ftipo_documento_modulogrid");
ftipo_documento_modulogrid.FormKeyCountName = '<?php echo $tipo_documento_modulo_grid->FormKeyCountName ?>';

// Validate form
ftipo_documento_modulogrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tipo_documento_modulo->idtipo_documento->FldCaption(), $tipo_documento_modulo->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmodulo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tipo_documento_modulo->idmodulo->FldCaption(), $tipo_documento_modulo->idmodulo->ReqErrMsg)) ?>");

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
ftipo_documento_modulogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idtipo_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idmodulo", false)) return false;
	return true;
}

// Form_CustomValidate event
ftipo_documento_modulogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftipo_documento_modulogrid.ValidateRequired = true;
<?php } else { ?>
ftipo_documento_modulogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftipo_documento_modulogrid.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
ftipo_documento_modulogrid.Lists["x_idmodulo"] = {"LinkField":"x_idmodulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($tipo_documento_modulo->CurrentAction == "gridadd") {
	if ($tipo_documento_modulo->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$tipo_documento_modulo_grid->TotalRecs = $tipo_documento_modulo->SelectRecordCount();
			$tipo_documento_modulo_grid->Recordset = $tipo_documento_modulo_grid->LoadRecordset($tipo_documento_modulo_grid->StartRec-1, $tipo_documento_modulo_grid->DisplayRecs);
		} else {
			if ($tipo_documento_modulo_grid->Recordset = $tipo_documento_modulo_grid->LoadRecordset())
				$tipo_documento_modulo_grid->TotalRecs = $tipo_documento_modulo_grid->Recordset->RecordCount();
		}
		$tipo_documento_modulo_grid->StartRec = 1;
		$tipo_documento_modulo_grid->DisplayRecs = $tipo_documento_modulo_grid->TotalRecs;
	} else {
		$tipo_documento_modulo->CurrentFilter = "0=1";
		$tipo_documento_modulo_grid->StartRec = 1;
		$tipo_documento_modulo_grid->DisplayRecs = $tipo_documento_modulo->GridAddRowCount;
	}
	$tipo_documento_modulo_grid->TotalRecs = $tipo_documento_modulo_grid->DisplayRecs;
	$tipo_documento_modulo_grid->StopRec = $tipo_documento_modulo_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$tipo_documento_modulo_grid->TotalRecs = $tipo_documento_modulo->SelectRecordCount();
	} else {
		if ($tipo_documento_modulo_grid->Recordset = $tipo_documento_modulo_grid->LoadRecordset())
			$tipo_documento_modulo_grid->TotalRecs = $tipo_documento_modulo_grid->Recordset->RecordCount();
	}
	$tipo_documento_modulo_grid->StartRec = 1;
	$tipo_documento_modulo_grid->DisplayRecs = $tipo_documento_modulo_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$tipo_documento_modulo_grid->Recordset = $tipo_documento_modulo_grid->LoadRecordset($tipo_documento_modulo_grid->StartRec-1, $tipo_documento_modulo_grid->DisplayRecs);

	// Set no record found message
	if ($tipo_documento_modulo->CurrentAction == "" && $tipo_documento_modulo_grid->TotalRecs == 0) {
		if ($tipo_documento_modulo_grid->SearchWhere == "0=101")
			$tipo_documento_modulo_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$tipo_documento_modulo_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$tipo_documento_modulo_grid->RenderOtherOptions();
?>
<?php $tipo_documento_modulo_grid->ShowPageHeader(); ?>
<?php
$tipo_documento_modulo_grid->ShowMessage();
?>
<?php if ($tipo_documento_modulo_grid->TotalRecs > 0 || $tipo_documento_modulo->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="ftipo_documento_modulogrid" class="ewForm form-inline">
<div id="gmp_tipo_documento_modulo" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_tipo_documento_modulogrid" class="table ewTable">
<?php echo $tipo_documento_modulo->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$tipo_documento_modulo_grid->RenderListOptions();

// Render list options (header, left)
$tipo_documento_modulo_grid->ListOptions->Render("header", "left");
?>
<?php if ($tipo_documento_modulo->idtipo_documento->Visible) { // idtipo_documento ?>
	<?php if ($tipo_documento_modulo->SortUrl($tipo_documento_modulo->idtipo_documento) == "") { ?>
		<th data-name="idtipo_documento"><div id="elh_tipo_documento_modulo_idtipo_documento" class="tipo_documento_modulo_idtipo_documento"><div class="ewTableHeaderCaption"><?php echo $tipo_documento_modulo->idtipo_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_documento"><div><div id="elh_tipo_documento_modulo_idtipo_documento" class="tipo_documento_modulo_idtipo_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tipo_documento_modulo->idtipo_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tipo_documento_modulo->idtipo_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tipo_documento_modulo->idtipo_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($tipo_documento_modulo->idmodulo->Visible) { // idmodulo ?>
	<?php if ($tipo_documento_modulo->SortUrl($tipo_documento_modulo->idmodulo) == "") { ?>
		<th data-name="idmodulo"><div id="elh_tipo_documento_modulo_idmodulo" class="tipo_documento_modulo_idmodulo"><div class="ewTableHeaderCaption"><?php echo $tipo_documento_modulo->idmodulo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idmodulo"><div><div id="elh_tipo_documento_modulo_idmodulo" class="tipo_documento_modulo_idmodulo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $tipo_documento_modulo->idmodulo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($tipo_documento_modulo->idmodulo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($tipo_documento_modulo->idmodulo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$tipo_documento_modulo_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$tipo_documento_modulo_grid->StartRec = 1;
$tipo_documento_modulo_grid->StopRec = $tipo_documento_modulo_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($tipo_documento_modulo_grid->FormKeyCountName) && ($tipo_documento_modulo->CurrentAction == "gridadd" || $tipo_documento_modulo->CurrentAction == "gridedit" || $tipo_documento_modulo->CurrentAction == "F")) {
		$tipo_documento_modulo_grid->KeyCount = $objForm->GetValue($tipo_documento_modulo_grid->FormKeyCountName);
		$tipo_documento_modulo_grid->StopRec = $tipo_documento_modulo_grid->StartRec + $tipo_documento_modulo_grid->KeyCount - 1;
	}
}
$tipo_documento_modulo_grid->RecCnt = $tipo_documento_modulo_grid->StartRec - 1;
if ($tipo_documento_modulo_grid->Recordset && !$tipo_documento_modulo_grid->Recordset->EOF) {
	$tipo_documento_modulo_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $tipo_documento_modulo_grid->StartRec > 1)
		$tipo_documento_modulo_grid->Recordset->Move($tipo_documento_modulo_grid->StartRec - 1);
} elseif (!$tipo_documento_modulo->AllowAddDeleteRow && $tipo_documento_modulo_grid->StopRec == 0) {
	$tipo_documento_modulo_grid->StopRec = $tipo_documento_modulo->GridAddRowCount;
}

// Initialize aggregate
$tipo_documento_modulo->RowType = EW_ROWTYPE_AGGREGATEINIT;
$tipo_documento_modulo->ResetAttrs();
$tipo_documento_modulo_grid->RenderRow();
if ($tipo_documento_modulo->CurrentAction == "gridadd")
	$tipo_documento_modulo_grid->RowIndex = 0;
if ($tipo_documento_modulo->CurrentAction == "gridedit")
	$tipo_documento_modulo_grid->RowIndex = 0;
while ($tipo_documento_modulo_grid->RecCnt < $tipo_documento_modulo_grid->StopRec) {
	$tipo_documento_modulo_grid->RecCnt++;
	if (intval($tipo_documento_modulo_grid->RecCnt) >= intval($tipo_documento_modulo_grid->StartRec)) {
		$tipo_documento_modulo_grid->RowCnt++;
		if ($tipo_documento_modulo->CurrentAction == "gridadd" || $tipo_documento_modulo->CurrentAction == "gridedit" || $tipo_documento_modulo->CurrentAction == "F") {
			$tipo_documento_modulo_grid->RowIndex++;
			$objForm->Index = $tipo_documento_modulo_grid->RowIndex;
			if ($objForm->HasValue($tipo_documento_modulo_grid->FormActionName))
				$tipo_documento_modulo_grid->RowAction = strval($objForm->GetValue($tipo_documento_modulo_grid->FormActionName));
			elseif ($tipo_documento_modulo->CurrentAction == "gridadd")
				$tipo_documento_modulo_grid->RowAction = "insert";
			else
				$tipo_documento_modulo_grid->RowAction = "";
		}

		// Set up key count
		$tipo_documento_modulo_grid->KeyCount = $tipo_documento_modulo_grid->RowIndex;

		// Init row class and style
		$tipo_documento_modulo->ResetAttrs();
		$tipo_documento_modulo->CssClass = "";
		if ($tipo_documento_modulo->CurrentAction == "gridadd") {
			if ($tipo_documento_modulo->CurrentMode == "copy") {
				$tipo_documento_modulo_grid->LoadRowValues($tipo_documento_modulo_grid->Recordset); // Load row values
				$tipo_documento_modulo_grid->SetRecordKey($tipo_documento_modulo_grid->RowOldKey, $tipo_documento_modulo_grid->Recordset); // Set old record key
			} else {
				$tipo_documento_modulo_grid->LoadDefaultValues(); // Load default values
				$tipo_documento_modulo_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$tipo_documento_modulo_grid->LoadRowValues($tipo_documento_modulo_grid->Recordset); // Load row values
		}
		$tipo_documento_modulo->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($tipo_documento_modulo->CurrentAction == "gridadd") // Grid add
			$tipo_documento_modulo->RowType = EW_ROWTYPE_ADD; // Render add
		if ($tipo_documento_modulo->CurrentAction == "gridadd" && $tipo_documento_modulo->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$tipo_documento_modulo_grid->RestoreCurrentRowFormValues($tipo_documento_modulo_grid->RowIndex); // Restore form values
		if ($tipo_documento_modulo->CurrentAction == "gridedit") { // Grid edit
			if ($tipo_documento_modulo->EventCancelled) {
				$tipo_documento_modulo_grid->RestoreCurrentRowFormValues($tipo_documento_modulo_grid->RowIndex); // Restore form values
			}
			if ($tipo_documento_modulo_grid->RowAction == "insert")
				$tipo_documento_modulo->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$tipo_documento_modulo->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($tipo_documento_modulo->CurrentAction == "gridedit" && ($tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT || $tipo_documento_modulo->RowType == EW_ROWTYPE_ADD) && $tipo_documento_modulo->EventCancelled) // Update failed
			$tipo_documento_modulo_grid->RestoreCurrentRowFormValues($tipo_documento_modulo_grid->RowIndex); // Restore form values
		if ($tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT) // Edit row
			$tipo_documento_modulo_grid->EditRowCnt++;
		if ($tipo_documento_modulo->CurrentAction == "F") // Confirm row
			$tipo_documento_modulo_grid->RestoreCurrentRowFormValues($tipo_documento_modulo_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$tipo_documento_modulo->RowAttrs = array_merge($tipo_documento_modulo->RowAttrs, array('data-rowindex'=>$tipo_documento_modulo_grid->RowCnt, 'id'=>'r' . $tipo_documento_modulo_grid->RowCnt . '_tipo_documento_modulo', 'data-rowtype'=>$tipo_documento_modulo->RowType));

		// Render row
		$tipo_documento_modulo_grid->RenderRow();

		// Render list options
		$tipo_documento_modulo_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($tipo_documento_modulo_grid->RowAction <> "delete" && $tipo_documento_modulo_grid->RowAction <> "insertdelete" && !($tipo_documento_modulo_grid->RowAction == "insert" && $tipo_documento_modulo->CurrentAction == "F" && $tipo_documento_modulo_grid->EmptyRow())) {
?>
	<tr<?php echo $tipo_documento_modulo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tipo_documento_modulo_grid->ListOptions->Render("body", "left", $tipo_documento_modulo_grid->RowCnt);
?>
	<?php if ($tipo_documento_modulo->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento"<?php echo $tipo_documento_modulo->idtipo_documento->CellAttributes() ?>>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tipo_documento_modulo->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento"<?php echo $tipo_documento_modulo->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idtipo_documento->EditValue)) {
	$arwrk = $tipo_documento_modulo->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idtipo_documento->OldValue = "";
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
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->OldValue) ?>">
<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tipo_documento_modulo->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento"<?php echo $tipo_documento_modulo->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idtipo_documento->EditValue)) {
	$arwrk = $tipo_documento_modulo->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idtipo_documento->OldValue = "";
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
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<?php echo $tipo_documento_modulo->idtipo_documento->ListViewValue() ?></span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->FormValue) ?>">
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->OldValue) ?>">
<?php } ?>
<a id="<?php echo $tipo_documento_modulo_grid->PageObjName . "_row_" . $tipo_documento_modulo_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idtipo_documento_modulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento_modulo->CurrentValue) ?>">
<input type="hidden" data-field="x_idtipo_documento_modulo" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento_modulo->OldValue) ?>">
<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT || $tipo_documento_modulo->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idtipo_documento_modulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento_modulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento_modulo->CurrentValue) ?>">
<?php } ?>
	<?php if ($tipo_documento_modulo->idmodulo->Visible) { // idmodulo ?>
		<td data-name="idmodulo"<?php echo $tipo_documento_modulo->idmodulo->CellAttributes() ?>>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($tipo_documento_modulo->idmodulo->getSessionValue() <> "") { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idmodulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<select data-field="x_idmodulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo"<?php echo $tipo_documento_modulo->idmodulo->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idmodulo->EditValue)) {
	$arwrk = $tipo_documento_modulo->idmodulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idmodulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idmodulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idmodulo, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmodulo` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idmodulo" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->OldValue) ?>">
<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($tipo_documento_modulo->idmodulo->getSessionValue() <> "") { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idmodulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $tipo_documento_modulo_grid->RowCnt ?>_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<select data-field="x_idmodulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo"<?php echo $tipo_documento_modulo->idmodulo->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idmodulo->EditValue)) {
	$arwrk = $tipo_documento_modulo->idmodulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idmodulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idmodulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idmodulo, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmodulo` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<?php echo $tipo_documento_modulo->idmodulo->ListViewValue() ?></span>
<input type="hidden" data-field="x_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->FormValue) ?>">
<input type="hidden" data-field="x_idmodulo" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tipo_documento_modulo_grid->ListOptions->Render("body", "right", $tipo_documento_modulo_grid->RowCnt);
?>
	</tr>
<?php if ($tipo_documento_modulo->RowType == EW_ROWTYPE_ADD || $tipo_documento_modulo->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ftipo_documento_modulogrid.UpdateOpts(<?php echo $tipo_documento_modulo_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($tipo_documento_modulo->CurrentAction <> "gridadd" || $tipo_documento_modulo->CurrentMode == "copy")
		if (!$tipo_documento_modulo_grid->Recordset->EOF) $tipo_documento_modulo_grid->Recordset->MoveNext();
}
?>
<?php
	if ($tipo_documento_modulo->CurrentMode == "add" || $tipo_documento_modulo->CurrentMode == "copy" || $tipo_documento_modulo->CurrentMode == "edit") {
		$tipo_documento_modulo_grid->RowIndex = '$rowindex$';
		$tipo_documento_modulo_grid->LoadDefaultValues();

		// Set row properties
		$tipo_documento_modulo->ResetAttrs();
		$tipo_documento_modulo->RowAttrs = array_merge($tipo_documento_modulo->RowAttrs, array('data-rowindex'=>$tipo_documento_modulo_grid->RowIndex, 'id'=>'r0_tipo_documento_modulo', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($tipo_documento_modulo->RowAttrs["class"], "ewTemplate");
		$tipo_documento_modulo->RowType = EW_ROWTYPE_ADD;

		// Render row
		$tipo_documento_modulo_grid->RenderRow();

		// Render list options
		$tipo_documento_modulo_grid->RenderListOptions();
		$tipo_documento_modulo_grid->StartRowCnt = 0;
?>
	<tr<?php echo $tipo_documento_modulo->RowAttributes() ?>>
<?php

// Render list options (body, left)
$tipo_documento_modulo_grid->ListOptions->Render("body", "left", $tipo_documento_modulo_grid->RowIndex);
?>
	<?php if ($tipo_documento_modulo->idtipo_documento->Visible) { // idtipo_documento ?>
		<td>
<?php if ($tipo_documento_modulo->CurrentAction <> "F") { ?>
<?php if ($tipo_documento_modulo->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<select data-field="x_idtipo_documento" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento"<?php echo $tipo_documento_modulo->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idtipo_documento->EditValue)) {
	$arwrk = $tipo_documento_modulo->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idtipo_documento->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idtipo_documento->OldValue = "";
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
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idtipo_documento, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idtipo_documento` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tipo_documento_modulo_idtipo_documento" class="form-group tipo_documento_modulo_idtipo_documento">
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idtipo_documento" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idtipo_documento" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($tipo_documento_modulo->idmodulo->Visible) { // idmodulo ?>
		<td>
<?php if ($tipo_documento_modulo->CurrentAction <> "F") { ?>
<?php if ($tipo_documento_modulo->idmodulo->getSessionValue() <> "") { ?>
<span id="el$rowindex$_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idmodulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<select data-field="x_idmodulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo"<?php echo $tipo_documento_modulo->idmodulo->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idmodulo->EditValue)) {
	$arwrk = $tipo_documento_modulo->idmodulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($tipo_documento_modulo->idmodulo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $tipo_documento_modulo->idmodulo->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idmodulo, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="s_x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idmodulo` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_tipo_documento_modulo_idmodulo" class="form-group tipo_documento_modulo_idmodulo">
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idmodulo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idmodulo" name="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="x<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idmodulo" name="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" id="o<?php echo $tipo_documento_modulo_grid->RowIndex ?>_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$tipo_documento_modulo_grid->ListOptions->Render("body", "right", $tipo_documento_modulo_grid->RowCnt);
?>
<script type="text/javascript">
ftipo_documento_modulogrid.UpdateOpts(<?php echo $tipo_documento_modulo_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($tipo_documento_modulo->CurrentMode == "add" || $tipo_documento_modulo->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $tipo_documento_modulo_grid->FormKeyCountName ?>" id="<?php echo $tipo_documento_modulo_grid->FormKeyCountName ?>" value="<?php echo $tipo_documento_modulo_grid->KeyCount ?>">
<?php echo $tipo_documento_modulo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tipo_documento_modulo->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $tipo_documento_modulo_grid->FormKeyCountName ?>" id="<?php echo $tipo_documento_modulo_grid->FormKeyCountName ?>" value="<?php echo $tipo_documento_modulo_grid->KeyCount ?>">
<?php echo $tipo_documento_modulo_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($tipo_documento_modulo->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ftipo_documento_modulogrid">
</div>
<?php

// Close recordset
if ($tipo_documento_modulo_grid->Recordset)
	$tipo_documento_modulo_grid->Recordset->Close();
?>
<?php if ($tipo_documento_modulo_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($tipo_documento_modulo_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($tipo_documento_modulo_grid->TotalRecs == 0 && $tipo_documento_modulo->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($tipo_documento_modulo_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($tipo_documento_modulo->Export == "") { ?>
<script type="text/javascript">
ftipo_documento_modulogrid.Init();
</script>
<?php } ?>
<?php
$tipo_documento_modulo_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$tipo_documento_modulo_grid->Page_Terminate();
?>
