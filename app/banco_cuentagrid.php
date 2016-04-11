<?php

// Create page object
if (!isset($banco_cuenta_grid)) $banco_cuenta_grid = new cbanco_cuenta_grid();

// Page init
$banco_cuenta_grid->Page_Init();

// Page main
$banco_cuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$banco_cuenta_grid->Page_Render();
?>
<?php if ($banco_cuenta->Export == "") { ?>
<script type="text/javascript">

// Form object
var fbanco_cuentagrid = new ew_Form("fbanco_cuentagrid", "grid");
fbanco_cuentagrid.FormKeyCountName = '<?php echo $banco_cuenta_grid->FormKeyCountName ?>';

// Validate form
fbanco_cuentagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $banco_cuenta->idempresa->FldCaption(), $banco_cuenta->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $banco_cuenta->idbanco->FldCaption(), $banco_cuenta->idbanco->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fbanco_cuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbanco", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	return true;
}

// Form_CustomValidate event
fbanco_cuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbanco_cuentagrid.ValidateRequired = true;
<?php } else { ?>
fbanco_cuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbanco_cuentagrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbanco_cuentagrid.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($banco_cuenta->CurrentAction == "gridadd") {
	if ($banco_cuenta->CurrentMode == "copy") {
		$bSelectLimit = $banco_cuenta_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$banco_cuenta_grid->TotalRecs = $banco_cuenta->SelectRecordCount();
			$banco_cuenta_grid->Recordset = $banco_cuenta_grid->LoadRecordset($banco_cuenta_grid->StartRec-1, $banco_cuenta_grid->DisplayRecs);
		} else {
			if ($banco_cuenta_grid->Recordset = $banco_cuenta_grid->LoadRecordset())
				$banco_cuenta_grid->TotalRecs = $banco_cuenta_grid->Recordset->RecordCount();
		}
		$banco_cuenta_grid->StartRec = 1;
		$banco_cuenta_grid->DisplayRecs = $banco_cuenta_grid->TotalRecs;
	} else {
		$banco_cuenta->CurrentFilter = "0=1";
		$banco_cuenta_grid->StartRec = 1;
		$banco_cuenta_grid->DisplayRecs = $banco_cuenta->GridAddRowCount;
	}
	$banco_cuenta_grid->TotalRecs = $banco_cuenta_grid->DisplayRecs;
	$banco_cuenta_grid->StopRec = $banco_cuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = $banco_cuenta_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($banco_cuenta_grid->TotalRecs <= 0)
			$banco_cuenta_grid->TotalRecs = $banco_cuenta->SelectRecordCount();
	} else {
		if (!$banco_cuenta_grid->Recordset && ($banco_cuenta_grid->Recordset = $banco_cuenta_grid->LoadRecordset()))
			$banco_cuenta_grid->TotalRecs = $banco_cuenta_grid->Recordset->RecordCount();
	}
	$banco_cuenta_grid->StartRec = 1;
	$banco_cuenta_grid->DisplayRecs = $banco_cuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$banco_cuenta_grid->Recordset = $banco_cuenta_grid->LoadRecordset($banco_cuenta_grid->StartRec-1, $banco_cuenta_grid->DisplayRecs);

	// Set no record found message
	if ($banco_cuenta->CurrentAction == "" && $banco_cuenta_grid->TotalRecs == 0) {
		if ($banco_cuenta_grid->SearchWhere == "0=101")
			$banco_cuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$banco_cuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$banco_cuenta_grid->RenderOtherOptions();
?>
<?php $banco_cuenta_grid->ShowPageHeader(); ?>
<?php
$banco_cuenta_grid->ShowMessage();
?>
<?php if ($banco_cuenta_grid->TotalRecs > 0 || $banco_cuenta->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fbanco_cuentagrid" class="ewForm form-inline">
<div id="gmp_banco_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_banco_cuentagrid" class="table ewTable">
<?php echo $banco_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$banco_cuenta_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$banco_cuenta_grid->RenderListOptions();

// Render list options (header, left)
$banco_cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($banco_cuenta->idempresa->Visible) { // idempresa ?>
	<?php if ($banco_cuenta->SortUrl($banco_cuenta->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_banco_cuenta_idempresa" class="banco_cuenta_idempresa"><div class="ewTableHeaderCaption"><?php echo $banco_cuenta->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_banco_cuenta_idempresa" class="banco_cuenta_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $banco_cuenta->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($banco_cuenta->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($banco_cuenta->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($banco_cuenta->idbanco->Visible) { // idbanco ?>
	<?php if ($banco_cuenta->SortUrl($banco_cuenta->idbanco) == "") { ?>
		<th data-name="idbanco"><div id="elh_banco_cuenta_idbanco" class="banco_cuenta_idbanco"><div class="ewTableHeaderCaption"><?php echo $banco_cuenta->idbanco->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco"><div><div id="elh_banco_cuenta_idbanco" class="banco_cuenta_idbanco">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $banco_cuenta->idbanco->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($banco_cuenta->idbanco->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($banco_cuenta->idbanco->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($banco_cuenta->nombre->Visible) { // nombre ?>
	<?php if ($banco_cuenta->SortUrl($banco_cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_banco_cuenta_nombre" class="banco_cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $banco_cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_banco_cuenta_nombre" class="banco_cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $banco_cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($banco_cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($banco_cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($banco_cuenta->numero->Visible) { // numero ?>
	<?php if ($banco_cuenta->SortUrl($banco_cuenta->numero) == "") { ?>
		<th data-name="numero"><div id="elh_banco_cuenta_numero" class="banco_cuenta_numero"><div class="ewTableHeaderCaption"><?php echo $banco_cuenta->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_banco_cuenta_numero" class="banco_cuenta_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $banco_cuenta->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($banco_cuenta->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($banco_cuenta->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$banco_cuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$banco_cuenta_grid->StartRec = 1;
$banco_cuenta_grid->StopRec = $banco_cuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($banco_cuenta_grid->FormKeyCountName) && ($banco_cuenta->CurrentAction == "gridadd" || $banco_cuenta->CurrentAction == "gridedit" || $banco_cuenta->CurrentAction == "F")) {
		$banco_cuenta_grid->KeyCount = $objForm->GetValue($banco_cuenta_grid->FormKeyCountName);
		$banco_cuenta_grid->StopRec = $banco_cuenta_grid->StartRec + $banco_cuenta_grid->KeyCount - 1;
	}
}
$banco_cuenta_grid->RecCnt = $banco_cuenta_grid->StartRec - 1;
if ($banco_cuenta_grid->Recordset && !$banco_cuenta_grid->Recordset->EOF) {
	$banco_cuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = $banco_cuenta_grid->UseSelectLimit;
	if (!$bSelectLimit && $banco_cuenta_grid->StartRec > 1)
		$banco_cuenta_grid->Recordset->Move($banco_cuenta_grid->StartRec - 1);
} elseif (!$banco_cuenta->AllowAddDeleteRow && $banco_cuenta_grid->StopRec == 0) {
	$banco_cuenta_grid->StopRec = $banco_cuenta->GridAddRowCount;
}

// Initialize aggregate
$banco_cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$banco_cuenta->ResetAttrs();
$banco_cuenta_grid->RenderRow();
if ($banco_cuenta->CurrentAction == "gridadd")
	$banco_cuenta_grid->RowIndex = 0;
if ($banco_cuenta->CurrentAction == "gridedit")
	$banco_cuenta_grid->RowIndex = 0;
while ($banco_cuenta_grid->RecCnt < $banco_cuenta_grid->StopRec) {
	$banco_cuenta_grid->RecCnt++;
	if (intval($banco_cuenta_grid->RecCnt) >= intval($banco_cuenta_grid->StartRec)) {
		$banco_cuenta_grid->RowCnt++;
		if ($banco_cuenta->CurrentAction == "gridadd" || $banco_cuenta->CurrentAction == "gridedit" || $banco_cuenta->CurrentAction == "F") {
			$banco_cuenta_grid->RowIndex++;
			$objForm->Index = $banco_cuenta_grid->RowIndex;
			if ($objForm->HasValue($banco_cuenta_grid->FormActionName))
				$banco_cuenta_grid->RowAction = strval($objForm->GetValue($banco_cuenta_grid->FormActionName));
			elseif ($banco_cuenta->CurrentAction == "gridadd")
				$banco_cuenta_grid->RowAction = "insert";
			else
				$banco_cuenta_grid->RowAction = "";
		}

		// Set up key count
		$banco_cuenta_grid->KeyCount = $banco_cuenta_grid->RowIndex;

		// Init row class and style
		$banco_cuenta->ResetAttrs();
		$banco_cuenta->CssClass = "";
		if ($banco_cuenta->CurrentAction == "gridadd") {
			if ($banco_cuenta->CurrentMode == "copy") {
				$banco_cuenta_grid->LoadRowValues($banco_cuenta_grid->Recordset); // Load row values
				$banco_cuenta_grid->SetRecordKey($banco_cuenta_grid->RowOldKey, $banco_cuenta_grid->Recordset); // Set old record key
			} else {
				$banco_cuenta_grid->LoadDefaultValues(); // Load default values
				$banco_cuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$banco_cuenta_grid->LoadRowValues($banco_cuenta_grid->Recordset); // Load row values
		}
		$banco_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($banco_cuenta->CurrentAction == "gridadd") // Grid add
			$banco_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($banco_cuenta->CurrentAction == "gridadd" && $banco_cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$banco_cuenta_grid->RestoreCurrentRowFormValues($banco_cuenta_grid->RowIndex); // Restore form values
		if ($banco_cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($banco_cuenta->EventCancelled) {
				$banco_cuenta_grid->RestoreCurrentRowFormValues($banco_cuenta_grid->RowIndex); // Restore form values
			}
			if ($banco_cuenta_grid->RowAction == "insert")
				$banco_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$banco_cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($banco_cuenta->CurrentAction == "gridedit" && ($banco_cuenta->RowType == EW_ROWTYPE_EDIT || $banco_cuenta->RowType == EW_ROWTYPE_ADD) && $banco_cuenta->EventCancelled) // Update failed
			$banco_cuenta_grid->RestoreCurrentRowFormValues($banco_cuenta_grid->RowIndex); // Restore form values
		if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$banco_cuenta_grid->EditRowCnt++;
		if ($banco_cuenta->CurrentAction == "F") // Confirm row
			$banco_cuenta_grid->RestoreCurrentRowFormValues($banco_cuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$banco_cuenta->RowAttrs = array_merge($banco_cuenta->RowAttrs, array('data-rowindex'=>$banco_cuenta_grid->RowCnt, 'id'=>'r' . $banco_cuenta_grid->RowCnt . '_banco_cuenta', 'data-rowtype'=>$banco_cuenta->RowType));

		// Render row
		$banco_cuenta_grid->RenderRow();

		// Render list options
		$banco_cuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($banco_cuenta_grid->RowAction <> "delete" && $banco_cuenta_grid->RowAction <> "insertdelete" && !($banco_cuenta_grid->RowAction == "insert" && $banco_cuenta->CurrentAction == "F" && $banco_cuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $banco_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$banco_cuenta_grid->ListOptions->Render("body", "left", $banco_cuenta_grid->RowCnt);
?>
	<?php if ($banco_cuenta->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $banco_cuenta->idempresa->CellAttributes() ?>>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idempresa" class="form-group banco_cuenta_idempresa">
<select data-table="banco_cuenta" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idempresa->DisplayValueSeparator) ? json_encode($banco_cuenta->idempresa->DisplayValueSeparator) : $banco_cuenta->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa"<?php echo $banco_cuenta->idempresa->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idempresa->EditValue)) {
	$arwrk = $banco_cuenta->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->CurrentValue) ?>" selected><?php echo $banco_cuenta->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo $banco_cuenta->idempresa->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_idempresa" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idempresa" class="form-group banco_cuenta_idempresa">
<select data-table="banco_cuenta" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idempresa->DisplayValueSeparator) ? json_encode($banco_cuenta->idempresa->DisplayValueSeparator) : $banco_cuenta->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa"<?php echo $banco_cuenta->idempresa->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idempresa->EditValue)) {
	$arwrk = $banco_cuenta->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->CurrentValue) ?>" selected><?php echo $banco_cuenta->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo $banco_cuenta->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idempresa" class="banco_cuenta_idempresa">
<span<?php echo $banco_cuenta->idempresa->ViewAttributes() ?>>
<?php echo $banco_cuenta->idempresa->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_idempresa" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->FormValue) ?>">
<input type="hidden" data-table="banco_cuenta" data-field="x_idempresa" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->OldValue) ?>">
<?php } ?>
<a id="<?php echo $banco_cuenta_grid->PageObjName . "_row_" . $banco_cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco_cuenta" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco_cuenta->CurrentValue) ?>">
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco_cuenta" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT || $banco_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco_cuenta" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco_cuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($banco_cuenta->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco"<?php echo $banco_cuenta->idbanco->CellAttributes() ?>>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($banco_cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<select data-table="banco_cuenta" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idbanco->DisplayValueSeparator) ? json_encode($banco_cuenta->idbanco->DisplayValueSeparator) : $banco_cuenta->idbanco->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco"<?php echo $banco_cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idbanco->EditValue)) {
	$arwrk = $banco_cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idbanco->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idbanco->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>" selected><?php echo $banco_cuenta->idbanco->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idbanco->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo $banco_cuenta->idbanco->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->OldValue) ?>">
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($banco_cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<select data-table="banco_cuenta" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idbanco->DisplayValueSeparator) ? json_encode($banco_cuenta->idbanco->DisplayValueSeparator) : $banco_cuenta->idbanco->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco"<?php echo $banco_cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idbanco->EditValue)) {
	$arwrk = $banco_cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idbanco->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idbanco->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>" selected><?php echo $banco_cuenta->idbanco->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idbanco->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo $banco_cuenta->idbanco->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_idbanco" class="banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<?php echo $banco_cuenta->idbanco->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->FormValue) ?>">
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($banco_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $banco_cuenta->nombre->CellAttributes() ?>>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_nombre" class="form-group banco_cuenta_nombre">
<input type="text" data-table="banco_cuenta" data-field="x_nombre" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->nombre->EditValue ?>"<?php echo $banco_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_nombre" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($banco_cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_nombre" class="form-group banco_cuenta_nombre">
<input type="text" data-table="banco_cuenta" data-field="x_nombre" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->nombre->EditValue ?>"<?php echo $banco_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_nombre" class="banco_cuenta_nombre">
<span<?php echo $banco_cuenta->nombre->ViewAttributes() ?>>
<?php echo $banco_cuenta->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_nombre" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($banco_cuenta->nombre->FormValue) ?>">
<input type="hidden" data-table="banco_cuenta" data-field="x_nombre" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($banco_cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($banco_cuenta->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $banco_cuenta->numero->CellAttributes() ?>>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_numero" class="form-group banco_cuenta_numero">
<input type="text" data-table="banco_cuenta" data-field="x_numero" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->numero->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->numero->EditValue ?>"<?php echo $banco_cuenta->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_numero" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($banco_cuenta->numero->OldValue) ?>">
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_numero" class="form-group banco_cuenta_numero">
<input type="text" data-table="banco_cuenta" data-field="x_numero" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->numero->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->numero->EditValue ?>"<?php echo $banco_cuenta->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $banco_cuenta_grid->RowCnt ?>_banco_cuenta_numero" class="banco_cuenta_numero">
<span<?php echo $banco_cuenta->numero->ViewAttributes() ?>>
<?php echo $banco_cuenta->numero->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_numero" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($banco_cuenta->numero->FormValue) ?>">
<input type="hidden" data-table="banco_cuenta" data-field="x_numero" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($banco_cuenta->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$banco_cuenta_grid->ListOptions->Render("body", "right", $banco_cuenta_grid->RowCnt);
?>
	</tr>
<?php if ($banco_cuenta->RowType == EW_ROWTYPE_ADD || $banco_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbanco_cuentagrid.UpdateOpts(<?php echo $banco_cuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($banco_cuenta->CurrentAction <> "gridadd" || $banco_cuenta->CurrentMode == "copy")
		if (!$banco_cuenta_grid->Recordset->EOF) $banco_cuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($banco_cuenta->CurrentMode == "add" || $banco_cuenta->CurrentMode == "copy" || $banco_cuenta->CurrentMode == "edit") {
		$banco_cuenta_grid->RowIndex = '$rowindex$';
		$banco_cuenta_grid->LoadDefaultValues();

		// Set row properties
		$banco_cuenta->ResetAttrs();
		$banco_cuenta->RowAttrs = array_merge($banco_cuenta->RowAttrs, array('data-rowindex'=>$banco_cuenta_grid->RowIndex, 'id'=>'r0_banco_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($banco_cuenta->RowAttrs["class"], "ewTemplate");
		$banco_cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$banco_cuenta_grid->RenderRow();

		// Render list options
		$banco_cuenta_grid->RenderListOptions();
		$banco_cuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $banco_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$banco_cuenta_grid->ListOptions->Render("body", "left", $banco_cuenta_grid->RowIndex);
?>
	<?php if ($banco_cuenta->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa">
<?php if ($banco_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_banco_cuenta_idempresa" class="form-group banco_cuenta_idempresa">
<select data-table="banco_cuenta" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idempresa->DisplayValueSeparator) ? json_encode($banco_cuenta->idempresa->DisplayValueSeparator) : $banco_cuenta->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa"<?php echo $banco_cuenta->idempresa->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idempresa->EditValue)) {
	$arwrk = $banco_cuenta->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->CurrentValue) ?>" selected><?php echo $banco_cuenta->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo $banco_cuenta->idempresa->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_banco_cuenta_idempresa" class="form-group banco_cuenta_idempresa">
<span<?php echo $banco_cuenta->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_idempresa" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_idempresa" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($banco_cuenta->idempresa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($banco_cuenta->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco">
<?php if ($banco_cuenta->CurrentAction <> "F") { ?>
<?php if ($banco_cuenta->idbanco->getSessionValue() <> "") { ?>
<span id="el$rowindex$_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<select data-table="banco_cuenta" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($banco_cuenta->idbanco->DisplayValueSeparator) ? json_encode($banco_cuenta->idbanco->DisplayValueSeparator) : $banco_cuenta->idbanco->DisplayValueSeparator) ?>" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco"<?php echo $banco_cuenta->idbanco->EditAttributes() ?>>
<?php
if (is_array($banco_cuenta->idbanco->EditValue)) {
	$arwrk = $banco_cuenta->idbanco->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($banco_cuenta->idbanco->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $banco_cuenta->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($banco_cuenta->idbanco->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->CurrentValue) ?>" selected><?php echo $banco_cuenta->idbanco->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $banco_cuenta->idbanco->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$banco_cuenta->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$banco_cuenta->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$banco_cuenta->Lookup_Selecting($banco_cuenta->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $banco_cuenta->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="s_x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo $banco_cuenta->idbanco->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_banco_cuenta_idbanco" class="form-group banco_cuenta_idbanco">
<span<?php echo $banco_cuenta->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_idbanco" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($banco_cuenta->idbanco->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($banco_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($banco_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_banco_cuenta_nombre" class="form-group banco_cuenta_nombre">
<input type="text" data-table="banco_cuenta" data-field="x_nombre" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->nombre->EditValue ?>"<?php echo $banco_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_banco_cuenta_nombre" class="form-group banco_cuenta_nombre">
<span<?php echo $banco_cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_nombre" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($banco_cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_nombre" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($banco_cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($banco_cuenta->numero->Visible) { // numero ?>
		<td data-name="numero">
<?php if ($banco_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_banco_cuenta_numero" class="form-group banco_cuenta_numero">
<input type="text" data-table="banco_cuenta" data-field="x_numero" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($banco_cuenta->numero->getPlaceHolder()) ?>" value="<?php echo $banco_cuenta->numero->EditValue ?>"<?php echo $banco_cuenta->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_banco_cuenta_numero" class="form-group banco_cuenta_numero">
<span<?php echo $banco_cuenta->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $banco_cuenta->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="banco_cuenta" data-field="x_numero" name="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="x<?php echo $banco_cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($banco_cuenta->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="banco_cuenta" data-field="x_numero" name="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" id="o<?php echo $banco_cuenta_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($banco_cuenta->numero->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$banco_cuenta_grid->ListOptions->Render("body", "right", $banco_cuenta_grid->RowCnt);
?>
<script type="text/javascript">
fbanco_cuentagrid.UpdateOpts(<?php echo $banco_cuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($banco_cuenta->CurrentMode == "add" || $banco_cuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $banco_cuenta_grid->FormKeyCountName ?>" id="<?php echo $banco_cuenta_grid->FormKeyCountName ?>" value="<?php echo $banco_cuenta_grid->KeyCount ?>">
<?php echo $banco_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($banco_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $banco_cuenta_grid->FormKeyCountName ?>" id="<?php echo $banco_cuenta_grid->FormKeyCountName ?>" value="<?php echo $banco_cuenta_grid->KeyCount ?>">
<?php echo $banco_cuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($banco_cuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbanco_cuentagrid">
</div>
<?php

// Close recordset
if ($banco_cuenta_grid->Recordset)
	$banco_cuenta_grid->Recordset->Close();
?>
<?php if ($banco_cuenta_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($banco_cuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($banco_cuenta_grid->TotalRecs == 0 && $banco_cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($banco_cuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($banco_cuenta->Export == "") { ?>
<script type="text/javascript">
fbanco_cuentagrid.Init();
</script>
<?php } ?>
<?php
$banco_cuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$banco_cuenta_grid->Page_Terminate();
?>
