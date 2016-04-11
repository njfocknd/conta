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

// Form object
var fgrupo_cuentagrid = new ew_Form("fgrupo_cuentagrid", "grid");
fgrupo_cuentagrid.FormKeyCountName = '<?php echo $grupo_cuenta_grid->FormKeyCountName ?>';

// Validate form
fgrupo_cuentagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomenclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nomenclatura->FldCaption(), $grupo_cuenta->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nombre->FldCaption(), $grupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idclase_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->idclase_cuenta->FldCaption(), $grupo_cuenta->idclase_cuenta->ReqErrMsg)) ?>");

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
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idclase_cuenta", false)) return false;
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
fgrupo_cuentagrid.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($grupo_cuenta->CurrentAction == "gridadd") {
	if ($grupo_cuenta->CurrentMode == "copy") {
		$bSelectLimit = $grupo_cuenta_grid->UseSelectLimit;
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
	$bSelectLimit = $grupo_cuenta_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($grupo_cuenta_grid->TotalRecs <= 0)
			$grupo_cuenta_grid->TotalRecs = $grupo_cuenta->SelectRecordCount();
	} else {
		if (!$grupo_cuenta_grid->Recordset && ($grupo_cuenta_grid->Recordset = $grupo_cuenta_grid->LoadRecordset()))
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
<div class="panel panel-default ewGrid">
<div id="fgrupo_cuentagrid" class="ewForm form-inline">
<div id="gmp_grupo_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_grupo_cuentagrid" class="table ewTable">
<?php echo $grupo_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$grupo_cuenta_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$grupo_cuenta_grid->RenderListOptions();

// Render list options (header, left)
$grupo_cuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($grupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_grupo_cuenta_nomenclatura" class="grupo_cuenta_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div><div id="elh_grupo_cuenta_nomenclatura" class="grupo_cuenta_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<?php if ($grupo_cuenta->SortUrl($grupo_cuenta->idclase_cuenta) == "") { ?>
		<th data-name="idclase_cuenta"><div id="elh_grupo_cuenta_idclase_cuenta" class="grupo_cuenta_idclase_cuenta"><div class="ewTableHeaderCaption"><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_cuenta"><div><div id="elh_grupo_cuenta_idclase_cuenta" class="grupo_cuenta_idclase_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_cuenta->idclase_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_cuenta->idclase_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	$bSelectLimit = $grupo_cuenta_grid->UseSelectLimit;
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
	<?php if ($grupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $grupo_cuenta->nomenclatura->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nomenclatura" class="form-group grupo_cuenta_nomenclatura">
<input type="text" data-table="grupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nomenclatura->EditValue ?>"<?php echo $grupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nomenclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nomenclatura" class="form-group grupo_cuenta_nomenclatura">
<input type="text" data-table="grupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nomenclatura->EditValue ?>"<?php echo $grupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nomenclatura" class="grupo_cuenta_nomenclatura">
<span<?php echo $grupo_cuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nomenclatura->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->FormValue) ?>">
<input type="hidden" data-table="grupo_cuenta" data-field="x_nomenclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<a id="<?php echo $grupo_cuenta_grid->PageObjName . "_row_" . $grupo_cuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idgrupo_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<input type="hidden" data-table="grupo_cuenta" data-field="x_idgrupo_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT || $grupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idgrupo_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $grupo_cuenta->nombre->CellAttributes() ?>>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-table="grupo_cuenta" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-table="grupo_cuenta" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_nombre" class="grupo_cuenta_nombre">
<span<?php echo $grupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $grupo_cuenta->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->FormValue) ?>">
<input type="hidden" data-table="grupo_cuenta" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
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
<select data-table="grupo_cuenta" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ? json_encode($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) : $grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_cuenta->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_cuenta->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_cuenta->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>" selected><?php echo $grupo_cuenta->idclase_cuenta->CurrentValue ?></option>
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
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_cuenta->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_cuenta->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_cuenta->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $grupo_cuenta->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
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
<select data-table="grupo_cuenta" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ? json_encode($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) : $grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_cuenta->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_cuenta->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_cuenta->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>" selected><?php echo $grupo_cuenta->idclase_cuenta->CurrentValue ?></option>
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
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_cuenta->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_cuenta->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_cuenta->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $grupo_cuenta->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($grupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $grupo_cuenta_grid->RowCnt ?>_grupo_cuenta_idclase_cuenta" class="grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<?php echo $grupo_cuenta->idclase_cuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->FormValue) ?>">
<input type="hidden" data-table="grupo_cuenta" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
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
	<?php if ($grupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_cuenta_nomenclatura" class="form-group grupo_cuenta_nomenclatura">
<input type="text" data-table="grupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nomenclatura->EditValue ?>"<?php echo $grupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_nomenclatura" class="form-group grupo_cuenta_nomenclatura">
<span<?php echo $grupo_cuenta->nomenclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->nomenclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nomenclatura" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($grupo_cuenta->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<input type="text" data-table="grupo_cuenta" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_nombre" class="form-group grupo_cuenta_nombre">
<span<?php echo $grupo_cuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nombre" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_nombre" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta">
<?php if ($grupo_cuenta->CurrentAction <> "F") { ?>
<?php if ($grupo_cuenta->idclase_cuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<select data-table="grupo_cuenta" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ? json_encode($grupo_cuenta->idclase_cuenta->DisplayValueSeparator) : $grupo_cuenta->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_cuenta->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_cuenta->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_cuenta->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>" selected><?php echo $grupo_cuenta->idclase_cuenta->CurrentValue ?></option>
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
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_cuenta->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_cuenta->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_cuenta->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $grupo_cuenta->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_grupo_cuenta_idclase_cuenta" class="form-group grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idclase_cuenta" name="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo_cuenta" data-field="x_idclase_cuenta" name="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $grupo_cuenta_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->OldValue) ?>">
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
<div class="panel-footer ewGridLowerPanel">
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
