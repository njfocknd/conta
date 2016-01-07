<?php

// Create page object
if (!isset($grupo_cuenta_grid)) $grupo_cuenta_grid = new cgrupo_cuenta_grid();

// Page init
$grupo_cuenta_grid->Page_Init();

// Page main
$grupo_cuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$grupo_cuenta_grid->Page_Render();
?>
<?php if ($grupo_cuenta->Export == "") { ?>
<script type="text/javascript">

// Page object
var grupo_cuenta_grid = new ew_Page("grupo_cuenta_grid");
grupo_cuenta_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = grupo_cuenta_grid.PageID; // For backward compatibility

// Form object
var fgrupo_cuentagrid = new ew_Form("fgrupo_cuentagrid");
fgrupo_cuentagrid.FormKeyCountName = '<?php echo $grupo_cuenta_grid->FormKeyCountName ?>';

// Validate form
fgrupo_cuentagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idclase_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->idclase_cuenta->FldCaption(), $grupo_cuenta->idclase_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nomeclatura->FldCaption(), $grupo_cuenta->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nombre->FldCaption(), $grupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->estado->FldCaption(), $grupo_cuenta->estado->ReqErrMsg)) ?>");

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
fgrupo_cuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idclase_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nomeclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fgrupo_cuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fgrupo_cuentagrid.ValidateRequired = true;
<?php } else { ?>
fgrupo_cuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fgrupo_cuentagrid.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($grupo_cuenta->CurrentAction == "gridadd") {
	if ($grupo_cuenta->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$grupo_cuenta_grid->TotalRecs = $grupo_cuenta->SelectRecordCount();
			$grupo_cuenta_grid->Recordset = $grupo_cuenta_grid->LoadRecordset($grupo_cuenta_grid->StartRec-1, $grupo_cuenta_grid->DisplayRecs);
		} else {
			if ($grupo_cuenta_grid->Recordset = $grupo_cuenta_grid->LoadRecordset())
				$grupo_cuenta_grid->TotalRecs = $grupo_cuenta_grid->Recordset->RecordCount();
		}
		$grupo_cuenta_grid->StartRec = 1;
		$grupo_cuenta_grid->DisplayRecs = $grupo_cuenta_grid->TotalRecs;
	} else {
		$grupo_cuenta->CurrentFilter = "0=1";
		$grupo_cuenta_grid->StartRec = 1;
		$grupo_cuenta_grid->DisplayRecs = $grupo_cuenta->GridAddRowCount;
	}
	$grupo_cuenta_grid->TotalRecs = $grupo_cuenta_grid->DisplayRecs;
	$grupo_cuenta_grid->StopRec = $grupo_cuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$grupo_cuenta_grid->TotalRecs = $grupo_cuenta->SelectRecordCount();
	} else {
		if ($grupo_cuenta_grid->Recordset = $grupo_cuenta_grid->LoadRecordset())
			$grupo_cuenta_grid->TotalRecs = $grupo_cuenta_grid->Recordset->RecordCount();
	}
	$grupo_cuenta_grid->StartRec = 1;
	$grupo_cuenta_grid->DisplayRecs = $grupo_cuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$grupo_cuenta_grid->Recordset = $grupo_cuenta_grid->LoadRecordset($grupo_cuenta_grid->StartRec-1, $grupo_cuenta_grid->DisplayRecs);

	// Set no record found message
	if ($grupo_cuenta->CurrentAction == "" && $grupo_cuenta_grid->TotalRecs == 0) {
		if ($grupo_cuenta_grid->SearchWhere == "0=101")
			$grupo_cuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$grupo_cuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$grupo_cuenta_grid->RenderOtherOptions();
?>
<?php $grupo_cuenta_grid->ShowPageHeader(); ?>
<?php
$grupo_cuenta_grid->ShowMessage();
?>
<?php if ($grupo_cuenta_grid->TotalRecs > 0 || $grupo_cuenta->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fgrupo_cuentagrid" class="ewForm form-inline">
<div id="gmp_grupo_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_grupo_cuentagrid" class="table ewTable">
<?php echo $grupo_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$grupo_cuenta_grid->RenderListOptions();

// Render list options (header, left)
$grupo_cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->idclase_cuenta) == "") { ?>
		<th data-name="idclase_cuenta"><div id="elh_grupo_cuenta_idclase_cuenta" class="grupo_cuenta_idclase_cuenta"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_cuenta"><div><div id="elh_grupo_cuenta_idclase_cuenta" class="grupo_cuenta_idclase_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->idclase_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->idclase_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($grupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->nomeclatura) == "") { ?>
		<th data-name="nomeclatura"><div id="elh_grupo_cuenta_nomeclatura" class="grupo_cuenta_nomeclatura"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nomeclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomeclatura"><div><div id="elh_grupo_cuenta_nomeclatura" class="grupo_cuenta_nomeclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nomeclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->nomeclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->nomeclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_grupo_cuenta_nombre" class="grupo_cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_grupo_cuenta_nombre" class="grupo_cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($grupo_cuenta->estado->Visible) { // estado ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->estado) == "") { ?>
		<th data-name="estado"><div id="elh_grupo_cuenta_estado" class="grupo_cuenta_estado"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_grupo_cuenta_estado" class="grupo_cuenta_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$grupo_cuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$grupo_cuenta_grid->StartRec = 1;
$grupo_cuenta_grid->StopRec = $grupo_cuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($grupo_cuenta_grid->FormKeyCountName) && ($grupo_cuenta->CurrentAction == "gridadd" || $grupo_cuenta->CurrentAction == "gridedit" || $grupo_cuenta->CurrentAction == "F")) {
		$grupo_cuenta_grid->KeyCount = $objForm->GetValue($grupo_cuenta_grid->FormKeyCountName);
		$grupo_cuenta_grid->StopRec = $grupo_cuenta_grid->StartRec + $grupo_cuenta_grid->KeyCount - 1;
	}
}
$grupo_cuenta_grid->RecCnt = $grupo_cuenta_grid->StartRec - 1;
if ($grupo_cuenta_grid->Recordset && !$grupo_cuenta_grid->Recordset->EOF) {
	$grupo_cuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $grupo_cuenta_grid->StartRec > 1)
		$grupo_cuenta_grid->Recordset->Move($grupo_cuenta_grid->StartRec - 1);
} elseif (!$grupo_cuenta->AllowAddDeleteRow && $grupo_cuenta_grid->StopRec == 0) {
	$grupo_cuenta_grid->StopRec = $grupo_cuenta->GridAddRowCount;
}

// Initialize aggregate
$grupo_cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$grupo_cuenta->ResetAttrs();
$grupo_cuenta_grid->RenderRow();
if ($grupo_cuenta->CurrentAction == "gridadd")
	$grupo_cuenta_grid->RowIndex = 0;
if ($grupo_cuenta->CurrentAction == "gridedit")
	$grupo_cuenta_grid->RowIndex = 0;
while ($grupo_cuenta_grid->RecCnt < $grupo_cuenta_grid->StopRec) {
	$grupo_cuenta_grid->RecCnt++;
	if (intval($grupo_cuenta_grid->RecCnt) >= intval($grupo_cuenta_grid->StartRec)) {
		$grupo_cuenta_grid->RowCnt++;
		if ($grupo_cuenta->CurrentAction == "gridadd" || $grupo_cuenta->CurrentAction == "gridedit" || $grupo_cuenta->CurrentAction == "F") {
			$grupo_cuenta_grid->RowIndex++;
			$objForm->Index = $grupo_cuenta_grid->RowIndex;
			if ($objForm->HasValue($grupo_cuenta_grid->FormActionName))
				$grupo_cuenta_grid->RowAction = strval($objForm->GetValue($grupo_cuenta_grid->FormActionName));
			elseif ($grupo_cuenta->CurrentAction == "gridadd")
				$grupo_cuenta_grid->RowAction = "insert";
			else
				$grupo_cuenta_grid->RowAction = "";
		}

		// Set up key count
		$grupo_cuenta_grid->KeyCount = $grupo_cuenta_grid->RowIndex;

		// Init row class and style
		$grupo_cuenta->ResetAttrs();
		$grupo_cuenta->CssClass = "";
		if ($grupo_cuenta->CurrentAction == "gridadd") {
			if ($grupo_cuenta->CurrentMode == "copy") {
				$grupo_cuenta_grid->LoadRowValues($grupo_cuenta_grid->Recordset); // Load row values
				$grupo_cuenta_grid->SetRecordKey($grupo_cuenta_grid->RowOldKey, $grupo_cuenta_grid->Recordset); // Set old record key
			} else {
				$grupo_cuenta_grid->LoadDefaultValues(); // Load default values
				$grupo_cuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$grupo_cuenta_grid->LoadRowValues($grupo_cuenta_grid->Recordset); // Load row values
		}
		$grupo_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($grupo_cuenta->CurrentAction == "gridadd") // Grid add
			$grupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($grupo_cuenta->CurrentAction == "gridadd" && $grupo_cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$grupo_cuenta_grid->RestoreCurrentRowFormValues($grupo_cuenta_grid->RowIndex); // Restore form values
		if ($grupo_cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($grupo_cuenta->EventCancelled) {
				$grupo_cuenta_grid->RestoreCurrentRowFormValues($grupo_cuenta_grid->RowIndex); // Restore form values
			}
			if ($grupo_cuenta_grid->RowAction == "insert")
				$grupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$grupo_cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($grupo_cuenta->CurrentAction == "gridedit" && ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT || $grupo_cuenta->RowType == EW_ROWTYPE_ADD) && $grupo_cuenta->EventCancelled) // Update failed
			$grupo_cuenta_grid->RestoreCurrentRowFormValues($grupo_cuenta_grid->RowIndex); // Restore form values
		if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$grupo_cuenta_grid->EditRowCnt++;
		if ($grupo_cuenta->CurrentAction == "F") // Confirm row
			$grupo_cuenta_grid->RestoreCurrentRowFormValues($grupo_cuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$grupo_cuenta->RowAttrs = array_merge($grupo_cuenta->RowAttrs, array('data-rowindex'=>$grupo_cuenta_grid->RowCnt, 'id'=>'r' . $grupo_cuenta_grid->RowCnt . '_grupo_cuenta', 'data-rowtype'=>$grupo_cuenta->RowType));

		// Render row
		$grupo_cuenta_grid->RenderRow();

		// Render list options
		$grupo_cuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($grupo_cuenta_grid->RowAction <> "delete" && $grupo_cuenta_grid->RowAction <> "insertdelete" && !($grupo_cuenta_grid->RowAction == "insert" && $grupo_cuenta->CurrentAction == "F" && $grupo_cuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $grupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$grupo_cuenta_grid->ListOptions->Render("body", "left", $grupo_cuenta_grid->RowCnt);
?>
	<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($grupo_cuenta->idclase_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<select data-field="x_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->idclase_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->idclase_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idclase_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($grupo_cuenta->idclase_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<select data-field="x_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->idclase_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->idclase_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idclase_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<?php echo $grupo_cuenta->idclase_cuenta->ListViewValue() ?></span>
<input type="hidden" data-field="x_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->FormValue) ?>">
<input type="hidden" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
<?php } ?>
<a id="<?php echo $grupo_cuenta_grid->PageObjName . "_row_" . $grupo_cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idgrupo_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<input type="hidden" data-field="x_idgrupo_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT || $grupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idgrupo_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($grupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td data-name="nomeclatura"<?php echo $grupo_cuenta->nomeclatura->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nomeclatura" class="form-group grupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nomeclatura->EditValue ?>"<?php echo $grupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nomeclatura" class="form-group grupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nomeclatura->EditValue ?>"<?php echo $grupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $grupo_cuenta->nomeclatura->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nomeclatura->ListViewValue() ?></span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->FormValue) ?>">
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $grupo_cuenta->nombre->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $grupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $grupo_cuenta->estado->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_estado" class="form-group grupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado"<?php echo $grupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->estado->EditValue)) {
	$arwrk = $grupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($grupo_cuenta->estado->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_estado" class="form-group grupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado"<?php echo $grupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->estado->EditValue)) {
	$arwrk = $grupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $grupo_cuenta->estado->ViewAttributes() ?>>
<?php echo $grupo_cuenta->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($grupo_cuenta->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($grupo_cuenta->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$grupo_cuenta_grid->ListOptions->Render("body", "right", $grupo_cuenta_grid->RowCnt);
?>
	</tr>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD || $grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fgrupo_cuentagrid.UpdateOpts(<?php echo $grupo_cuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($grupo_cuenta->CurrentAction <> "gridadd" || $grupo_cuenta->CurrentMode == "copy")
		if (!$grupo_cuenta_grid->Recordset->EOF) $grupo_cuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($grupo_cuenta->CurrentMode == "add" || $grupo_cuenta->CurrentMode == "copy" || $grupo_cuenta->CurrentMode == "edit") {
		$grupo_cuenta_grid->RowIndex = '$rowindex$';
		$grupo_cuenta_grid->LoadDefaultValues();

		// Set row properties
		$grupo_cuenta->ResetAttrs();
		$grupo_cuenta->RowAttrs = array_merge($grupo_cuenta->RowAttrs, array('data-rowindex'=>$grupo_cuenta_grid->RowIndex, 'id'=>'r0_grupo_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($grupo_cuenta->RowAttrs["class"], "ewTemplate");
		$grupo_cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$grupo_cuenta_grid->RenderRow();

		// Render list options
		$grupo_cuenta_grid->RenderListOptions();
		$grupo_cuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $grupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$grupo_cuenta_grid->ListOptions->Render("body", "left", $grupo_cuenta_grid->RowIndex);
?>
	<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td>
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<?php if ($grupo_cuenta->idclase_cuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<select data-field="x_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->idclase_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->idclase_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
 $sWhereWrk = "";
 $lookuptblfilter = "`estado` = 'Activo'";
 if (strval($lookuptblfilter) <> "") {
 	ew_AddFilter($sWhereWrk, $lookuptblfilter);
 }

 // Call Lookup selecting
 $grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idclase_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td>
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_cuenta_nomeclatura" class="form-group grupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nomeclatura->EditValue ?>"<?php echo $grupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_nomeclatura" class="form-group grupo_cuenta_nomeclatura">
<span<?php echo $grupo_cuenta->nomeclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->nomeclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
		<td>
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<span<?php echo $grupo_cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->estado->Visible) { // estado ?>
		<td>
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_cuenta_estado" class="form-group grupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado"<?php echo $grupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->estado->EditValue)) {
	$arwrk = $grupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $grupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_estado" class="form-group grupo_cuenta_estado">
<span<?php echo $grupo_cuenta->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($grupo_cuenta->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($grupo_cuenta->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$grupo_cuenta_grid->ListOptions->Render("body", "right", $grupo_cuenta_grid->RowCnt);
?>
<script type="text/javascript">
fgrupo_cuentagrid.UpdateOpts(<?php echo $grupo_cuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($grupo_cuenta->CurrentMode == "add" || $grupo_cuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $grupo_cuenta_grid->FormKeyCountName ?>" id="<?php echo $grupo_cuenta_grid->FormKeyCountName ?>" value="<?php echo $grupo_cuenta_grid->KeyCount ?>">
<?php echo $grupo_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($grupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $grupo_cuenta_grid->FormKeyCountName ?>" id="<?php echo $grupo_cuenta_grid->FormKeyCountName ?>" value="<?php echo $grupo_cuenta_grid->KeyCount ?>">
<?php echo $grupo_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($grupo_cuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fgrupo_cuentagrid">
</div>
<?php

// Close recordset
if ($grupo_cuenta_grid->Recordset)
	$grupo_cuenta_grid->Recordset->Close();
?>
<?php if ($grupo_cuenta_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($grupo_cuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($grupo_cuenta_grid->TotalRecs == 0 && $grupo_cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($grupo_cuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($grupo_cuenta->Export == "") { ?>
<script type="text/javascript">
fgrupo_cuentagrid.Init();
</script>
<?php } ?>
<?php
$grupo_cuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$grupo_cuenta_grid->Page_Terminate();
?>
