<?php

// Create page object
if (!isset($subgrupo_cuenta_grid)) $subgrupo_cuenta_grid = new csubgrupo_cuenta_grid();

// Page init
$subgrupo_cuenta_grid->Page_Init();

// Page main
$subgrupo_cuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subgrupo_cuenta_grid->Page_Render();
?>
<?php if ($subgrupo_cuenta->Export == "") { ?>
<script type="text/javascript">

// Page object
var subgrupo_cuenta_grid = new ew_Page("subgrupo_cuenta_grid");
subgrupo_cuenta_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = subgrupo_cuenta_grid.PageID; // For backward compatibility

// Form object
var fsubgrupo_cuentagrid = new ew_Form("fsubgrupo_cuentagrid");
fsubgrupo_cuentagrid.FormKeyCountName = '<?php echo $subgrupo_cuenta_grid->FormKeyCountName ?>';

// Validate form
fsubgrupo_cuentagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->idgrupo_cuenta->FldCaption(), $subgrupo_cuenta->idgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nombre->FldCaption(), $subgrupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nomeclatura->FldCaption(), $subgrupo_cuenta->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->estado->FldCaption(), $subgrupo_cuenta->estado->ReqErrMsg)) ?>");

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
fsubgrupo_cuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nomeclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fsubgrupo_cuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubgrupo_cuentagrid.ValidateRequired = true;
<?php } else { ?>
fsubgrupo_cuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsubgrupo_cuentagrid.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($subgrupo_cuenta->CurrentAction == "gridadd") {
	if ($subgrupo_cuenta->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$subgrupo_cuenta_grid->TotalRecs = $subgrupo_cuenta->SelectRecordCount();
			$subgrupo_cuenta_grid->Recordset = $subgrupo_cuenta_grid->LoadRecordset($subgrupo_cuenta_grid->StartRec-1, $subgrupo_cuenta_grid->DisplayRecs);
		} else {
			if ($subgrupo_cuenta_grid->Recordset = $subgrupo_cuenta_grid->LoadRecordset())
				$subgrupo_cuenta_grid->TotalRecs = $subgrupo_cuenta_grid->Recordset->RecordCount();
		}
		$subgrupo_cuenta_grid->StartRec = 1;
		$subgrupo_cuenta_grid->DisplayRecs = $subgrupo_cuenta_grid->TotalRecs;
	} else {
		$subgrupo_cuenta->CurrentFilter = "0=1";
		$subgrupo_cuenta_grid->StartRec = 1;
		$subgrupo_cuenta_grid->DisplayRecs = $subgrupo_cuenta->GridAddRowCount;
	}
	$subgrupo_cuenta_grid->TotalRecs = $subgrupo_cuenta_grid->DisplayRecs;
	$subgrupo_cuenta_grid->StopRec = $subgrupo_cuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$subgrupo_cuenta_grid->TotalRecs = $subgrupo_cuenta->SelectRecordCount();
	} else {
		if ($subgrupo_cuenta_grid->Recordset = $subgrupo_cuenta_grid->LoadRecordset())
			$subgrupo_cuenta_grid->TotalRecs = $subgrupo_cuenta_grid->Recordset->RecordCount();
	}
	$subgrupo_cuenta_grid->StartRec = 1;
	$subgrupo_cuenta_grid->DisplayRecs = $subgrupo_cuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$subgrupo_cuenta_grid->Recordset = $subgrupo_cuenta_grid->LoadRecordset($subgrupo_cuenta_grid->StartRec-1, $subgrupo_cuenta_grid->DisplayRecs);

	// Set no record found message
	if ($subgrupo_cuenta->CurrentAction == "" && $subgrupo_cuenta_grid->TotalRecs == 0) {
		if ($subgrupo_cuenta_grid->SearchWhere == "0=101")
			$subgrupo_cuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$subgrupo_cuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$subgrupo_cuenta_grid->RenderOtherOptions();
?>
<?php $subgrupo_cuenta_grid->ShowPageHeader(); ?>
<?php
$subgrupo_cuenta_grid->ShowMessage();
?>
<?php if ($subgrupo_cuenta_grid->TotalRecs > 0 || $subgrupo_cuenta->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fsubgrupo_cuentagrid" class="ewForm form-inline">
<div id="gmp_subgrupo_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_subgrupo_cuentagrid" class="table ewTable">
<?php echo $subgrupo_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$subgrupo_cuenta_grid->RenderListOptions();

// Render list options (header, left)
$subgrupo_cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->idgrupo_cuenta) == "") { ?>
		<th data-name="idgrupo_cuenta"><div id="elh_subgrupo_cuenta_idgrupo_cuenta" class="subgrupo_cuenta_idgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idgrupo_cuenta"><div><div id="elh_subgrupo_cuenta_idgrupo_cuenta" class="subgrupo_cuenta_idgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->idgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->idgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_subgrupo_cuenta_nombre" class="subgrupo_cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_subgrupo_cuenta_nombre" class="subgrupo_cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->nomeclatura) == "") { ?>
		<th data-name="nomeclatura"><div id="elh_subgrupo_cuenta_nomeclatura" class="subgrupo_cuenta_nomeclatura"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nomeclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomeclatura"><div><div id="elh_subgrupo_cuenta_nomeclatura" class="subgrupo_cuenta_nomeclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nomeclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->nomeclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->nomeclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->estado->Visible) { // estado ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->estado) == "") { ?>
		<th data-name="estado"><div id="elh_subgrupo_cuenta_estado" class="subgrupo_cuenta_estado"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_subgrupo_cuenta_estado" class="subgrupo_cuenta_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$subgrupo_cuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$subgrupo_cuenta_grid->StartRec = 1;
$subgrupo_cuenta_grid->StopRec = $subgrupo_cuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($subgrupo_cuenta_grid->FormKeyCountName) && ($subgrupo_cuenta->CurrentAction == "gridadd" || $subgrupo_cuenta->CurrentAction == "gridedit" || $subgrupo_cuenta->CurrentAction == "F")) {
		$subgrupo_cuenta_grid->KeyCount = $objForm->GetValue($subgrupo_cuenta_grid->FormKeyCountName);
		$subgrupo_cuenta_grid->StopRec = $subgrupo_cuenta_grid->StartRec + $subgrupo_cuenta_grid->KeyCount - 1;
	}
}
$subgrupo_cuenta_grid->RecCnt = $subgrupo_cuenta_grid->StartRec - 1;
if ($subgrupo_cuenta_grid->Recordset && !$subgrupo_cuenta_grid->Recordset->EOF) {
	$subgrupo_cuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $subgrupo_cuenta_grid->StartRec > 1)
		$subgrupo_cuenta_grid->Recordset->Move($subgrupo_cuenta_grid->StartRec - 1);
} elseif (!$subgrupo_cuenta->AllowAddDeleteRow && $subgrupo_cuenta_grid->StopRec == 0) {
	$subgrupo_cuenta_grid->StopRec = $subgrupo_cuenta->GridAddRowCount;
}

// Initialize aggregate
$subgrupo_cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$subgrupo_cuenta->ResetAttrs();
$subgrupo_cuenta_grid->RenderRow();
if ($subgrupo_cuenta->CurrentAction == "gridadd")
	$subgrupo_cuenta_grid->RowIndex = 0;
if ($subgrupo_cuenta->CurrentAction == "gridedit")
	$subgrupo_cuenta_grid->RowIndex = 0;
while ($subgrupo_cuenta_grid->RecCnt < $subgrupo_cuenta_grid->StopRec) {
	$subgrupo_cuenta_grid->RecCnt++;
	if (intval($subgrupo_cuenta_grid->RecCnt) >= intval($subgrupo_cuenta_grid->StartRec)) {
		$subgrupo_cuenta_grid->RowCnt++;
		if ($subgrupo_cuenta->CurrentAction == "gridadd" || $subgrupo_cuenta->CurrentAction == "gridedit" || $subgrupo_cuenta->CurrentAction == "F") {
			$subgrupo_cuenta_grid->RowIndex++;
			$objForm->Index = $subgrupo_cuenta_grid->RowIndex;
			if ($objForm->HasValue($subgrupo_cuenta_grid->FormActionName))
				$subgrupo_cuenta_grid->RowAction = strval($objForm->GetValue($subgrupo_cuenta_grid->FormActionName));
			elseif ($subgrupo_cuenta->CurrentAction == "gridadd")
				$subgrupo_cuenta_grid->RowAction = "insert";
			else
				$subgrupo_cuenta_grid->RowAction = "";
		}

		// Set up key count
		$subgrupo_cuenta_grid->KeyCount = $subgrupo_cuenta_grid->RowIndex;

		// Init row class and style
		$subgrupo_cuenta->ResetAttrs();
		$subgrupo_cuenta->CssClass = "";
		if ($subgrupo_cuenta->CurrentAction == "gridadd") {
			if ($subgrupo_cuenta->CurrentMode == "copy") {
				$subgrupo_cuenta_grid->LoadRowValues($subgrupo_cuenta_grid->Recordset); // Load row values
				$subgrupo_cuenta_grid->SetRecordKey($subgrupo_cuenta_grid->RowOldKey, $subgrupo_cuenta_grid->Recordset); // Set old record key
			} else {
				$subgrupo_cuenta_grid->LoadDefaultValues(); // Load default values
				$subgrupo_cuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$subgrupo_cuenta_grid->LoadRowValues($subgrupo_cuenta_grid->Recordset); // Load row values
		}
		$subgrupo_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($subgrupo_cuenta->CurrentAction == "gridadd") // Grid add
			$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($subgrupo_cuenta->CurrentAction == "gridadd" && $subgrupo_cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$subgrupo_cuenta_grid->RestoreCurrentRowFormValues($subgrupo_cuenta_grid->RowIndex); // Restore form values
		if ($subgrupo_cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($subgrupo_cuenta->EventCancelled) {
				$subgrupo_cuenta_grid->RestoreCurrentRowFormValues($subgrupo_cuenta_grid->RowIndex); // Restore form values
			}
			if ($subgrupo_cuenta_grid->RowAction == "insert")
				$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$subgrupo_cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($subgrupo_cuenta->CurrentAction == "gridedit" && ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT || $subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) && $subgrupo_cuenta->EventCancelled) // Update failed
			$subgrupo_cuenta_grid->RestoreCurrentRowFormValues($subgrupo_cuenta_grid->RowIndex); // Restore form values
		if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$subgrupo_cuenta_grid->EditRowCnt++;
		if ($subgrupo_cuenta->CurrentAction == "F") // Confirm row
			$subgrupo_cuenta_grid->RestoreCurrentRowFormValues($subgrupo_cuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$subgrupo_cuenta->RowAttrs = array_merge($subgrupo_cuenta->RowAttrs, array('data-rowindex'=>$subgrupo_cuenta_grid->RowCnt, 'id'=>'r' . $subgrupo_cuenta_grid->RowCnt . '_subgrupo_cuenta', 'data-rowtype'=>$subgrupo_cuenta->RowType));

		// Render row
		$subgrupo_cuenta_grid->RenderRow();

		// Render list options
		$subgrupo_cuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($subgrupo_cuenta_grid->RowAction <> "delete" && $subgrupo_cuenta_grid->RowAction <> "insertdelete" && !($subgrupo_cuenta_grid->RowAction == "insert" && $subgrupo_cuenta->CurrentAction == "F" && $subgrupo_cuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $subgrupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subgrupo_cuenta_grid->ListOptions->Render("body", "left", $subgrupo_cuenta_grid->RowCnt);
?>
	<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-field="x_idgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idgrupo_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-field="x_idgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idgrupo_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->ListViewValue() ?></span>
<input type="hidden" data-field="x_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->FormValue) ?>">
<input type="hidden" data-field="x_idgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<a id="<?php echo $subgrupo_cuenta_grid->PageObjName . "_row_" . $subgrupo_cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idsubgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->CurrentValue) ?>">
<input type="hidden" data-field="x_idsubgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT || $subgrupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idsubgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $subgrupo_cuenta->nombre->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subgrupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td data-name="nomeclatura"<?php echo $subgrupo_cuenta->nomeclatura->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_nomeclatura" class="form-group subgrupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nomeclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_nomeclatura" class="form-group subgrupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nomeclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subgrupo_cuenta->nomeclatura->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nomeclatura->ListViewValue() ?></span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->FormValue) ?>">
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $subgrupo_cuenta->estado->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_estado" class="form-group subgrupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado"<?php echo $subgrupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->estado->EditValue)) {
	$arwrk = $subgrupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->estado->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_grid->RowCnt ?>_subgrupo_cuenta_estado" class="form-group subgrupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado"<?php echo $subgrupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->estado->EditValue)) {
	$arwrk = $subgrupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subgrupo_cuenta->estado->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subgrupo_cuenta_grid->ListOptions->Render("body", "right", $subgrupo_cuenta_grid->RowCnt);
?>
	</tr>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD || $subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsubgrupo_cuentagrid.UpdateOpts(<?php echo $subgrupo_cuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($subgrupo_cuenta->CurrentAction <> "gridadd" || $subgrupo_cuenta->CurrentMode == "copy")
		if (!$subgrupo_cuenta_grid->Recordset->EOF) $subgrupo_cuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($subgrupo_cuenta->CurrentMode == "add" || $subgrupo_cuenta->CurrentMode == "copy" || $subgrupo_cuenta->CurrentMode == "edit") {
		$subgrupo_cuenta_grid->RowIndex = '$rowindex$';
		$subgrupo_cuenta_grid->LoadDefaultValues();

		// Set row properties
		$subgrupo_cuenta->ResetAttrs();
		$subgrupo_cuenta->RowAttrs = array_merge($subgrupo_cuenta->RowAttrs, array('data-rowindex'=>$subgrupo_cuenta_grid->RowIndex, 'id'=>'r0_subgrupo_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($subgrupo_cuenta->RowAttrs["class"], "ewTemplate");
		$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$subgrupo_cuenta_grid->RenderRow();

		// Render list options
		$subgrupo_cuenta_grid->RenderListOptions();
		$subgrupo_cuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $subgrupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subgrupo_cuenta_grid->ListOptions->Render("body", "left", $subgrupo_cuenta_grid->RowIndex);
?>
	<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td>
<?php if ($subgrupo_cuenta->CurrentAction <> "F") { ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-field="x_idgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idgrupo_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<td>
<?php if ($subgrupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<span<?php echo $subgrupo_cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td>
<?php if ($subgrupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_subgrupo_cuenta_nomeclatura" class="form-group subgrupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subgrupo_cuenta->nomeclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_nomeclatura" class="form-group subgrupo_cuenta_nomeclatura">
<span<?php echo $subgrupo_cuenta->nomeclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->nomeclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomeclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->estado->Visible) { // estado ?>
		<td>
<?php if ($subgrupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_subgrupo_cuenta_estado" class="form-group subgrupo_cuenta_estado">
<select data-field="x_estado" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado"<?php echo $subgrupo_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->estado->EditValue)) {
	$arwrk = $subgrupo_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subgrupo_cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $subgrupo_cuenta->estado->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_estado" class="form-group subgrupo_cuenta_estado">
<span<?php echo $subgrupo_cuenta->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" id="x<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" id="o<?php echo $subgrupo_cuenta_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subgrupo_cuenta_grid->ListOptions->Render("body", "right", $subgrupo_cuenta_grid->RowCnt);
?>
<script type="text/javascript">
fsubgrupo_cuentagrid.UpdateOpts(<?php echo $subgrupo_cuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($subgrupo_cuenta->CurrentMode == "add" || $subgrupo_cuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $subgrupo_cuenta_grid->FormKeyCountName ?>" id="<?php echo $subgrupo_cuenta_grid->FormKeyCountName ?>" value="<?php echo $subgrupo_cuenta_grid->KeyCount ?>">
<?php echo $subgrupo_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($subgrupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $subgrupo_cuenta_grid->FormKeyCountName ?>" id="<?php echo $subgrupo_cuenta_grid->FormKeyCountName ?>" value="<?php echo $subgrupo_cuenta_grid->KeyCount ?>">
<?php echo $subgrupo_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($subgrupo_cuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsubgrupo_cuentagrid">
</div>
<?php

// Close recordset
if ($subgrupo_cuenta_grid->Recordset)
	$subgrupo_cuenta_grid->Recordset->Close();
?>
<?php if ($subgrupo_cuenta_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($subgrupo_cuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($subgrupo_cuenta_grid->TotalRecs == 0 && $subgrupo_cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subgrupo_cuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($subgrupo_cuenta->Export == "") { ?>
<script type="text/javascript">
fsubgrupo_cuentagrid.Init();
</script>
<?php } ?>
<?php
$subgrupo_cuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$subgrupo_cuenta_grid->Page_Terminate();
?>
