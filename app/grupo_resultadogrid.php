<?php

// Create page object
if (!isset($grupo_resultado_grid)) $grupo_resultado_grid = new cgrupo_resultado_grid();

// Page init
$grupo_resultado_grid->Page_Init();

// Page main
$grupo_resultado_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$grupo_resultado_grid->Page_Render();
?>
<?php if ($grupo_resultado->Export == "") { ?>
<script type="text/javascript">

// Form object
var fgrupo_resultadogrid = new ew_Form("fgrupo_resultadogrid", "grid");
fgrupo_resultadogrid.FormKeyCountName = '<?php echo $grupo_resultado_grid->FormKeyCountName ?>';

// Validate form
fgrupo_resultadogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idclase_resultado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_resultado->idclase_resultado->FldCaption(), $grupo_resultado->idclase_resultado->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fgrupo_resultadogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idclase_resultado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	return true;
}

// Form_CustomValidate event
fgrupo_resultadogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fgrupo_resultadogrid.ValidateRequired = true;
<?php } else { ?>
fgrupo_resultadogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fgrupo_resultadogrid.Lists["x_idclase_resultado"] = {"LinkField":"x_idclase_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($grupo_resultado->CurrentAction == "gridadd") {
	if ($grupo_resultado->CurrentMode == "copy") {
		$bSelectLimit = $grupo_resultado_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$grupo_resultado_grid->TotalRecs = $grupo_resultado->SelectRecordCount();
			$grupo_resultado_grid->Recordset = $grupo_resultado_grid->LoadRecordset($grupo_resultado_grid->StartRec-1, $grupo_resultado_grid->DisplayRecs);
		} else {
			if ($grupo_resultado_grid->Recordset = $grupo_resultado_grid->LoadRecordset())
				$grupo_resultado_grid->TotalRecs = $grupo_resultado_grid->Recordset->RecordCount();
		}
		$grupo_resultado_grid->StartRec = 1;
		$grupo_resultado_grid->DisplayRecs = $grupo_resultado_grid->TotalRecs;
	} else {
		$grupo_resultado->CurrentFilter = "0=1";
		$grupo_resultado_grid->StartRec = 1;
		$grupo_resultado_grid->DisplayRecs = $grupo_resultado->GridAddRowCount;
	}
	$grupo_resultado_grid->TotalRecs = $grupo_resultado_grid->DisplayRecs;
	$grupo_resultado_grid->StopRec = $grupo_resultado_grid->DisplayRecs;
} else {
	$bSelectLimit = $grupo_resultado_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($grupo_resultado_grid->TotalRecs <= 0)
			$grupo_resultado_grid->TotalRecs = $grupo_resultado->SelectRecordCount();
	} else {
		if (!$grupo_resultado_grid->Recordset && ($grupo_resultado_grid->Recordset = $grupo_resultado_grid->LoadRecordset()))
			$grupo_resultado_grid->TotalRecs = $grupo_resultado_grid->Recordset->RecordCount();
	}
	$grupo_resultado_grid->StartRec = 1;
	$grupo_resultado_grid->DisplayRecs = $grupo_resultado_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$grupo_resultado_grid->Recordset = $grupo_resultado_grid->LoadRecordset($grupo_resultado_grid->StartRec-1, $grupo_resultado_grid->DisplayRecs);

	// Set no record found message
	if ($grupo_resultado->CurrentAction == "" && $grupo_resultado_grid->TotalRecs == 0) {
		if ($grupo_resultado_grid->SearchWhere == "0=101")
			$grupo_resultado_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$grupo_resultado_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$grupo_resultado_grid->RenderOtherOptions();
?>
<?php $grupo_resultado_grid->ShowPageHeader(); ?>
<?php
$grupo_resultado_grid->ShowMessage();
?>
<?php if ($grupo_resultado_grid->TotalRecs > 0 || $grupo_resultado->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fgrupo_resultadogrid" class="ewForm form-inline">
<?php if ($grupo_resultado_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($grupo_resultado_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_grupo_resultado" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_grupo_resultadogrid" class="table ewTable">
<?php echo $grupo_resultado->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$grupo_resultado_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$grupo_resultado_grid->RenderListOptions();

// Render list options (header, left)
$grupo_resultado_grid->ListOptions->Render("header", "left");
?>
<?php if ($grupo_resultado->idclase_resultado->Visible) { // idclase_resultado ?>
	<?php if ($grupo_resultado->SortUrl($grupo_resultado->idclase_resultado) == "") { ?>
		<th data-name="idclase_resultado"><div id="elh_grupo_resultado_idclase_resultado" class="grupo_resultado_idclase_resultado"><div class="ewTableHeaderCaption"><?php echo $grupo_resultado->idclase_resultado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_resultado"><div><div id="elh_grupo_resultado_idclase_resultado" class="grupo_resultado_idclase_resultado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_resultado->idclase_resultado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_resultado->idclase_resultado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_resultado->idclase_resultado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($grupo_resultado->nombre->Visible) { // nombre ?>
	<?php if ($grupo_resultado->SortUrl($grupo_resultado->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_grupo_resultado_nombre" class="grupo_resultado_nombre"><div class="ewTableHeaderCaption"><?php echo $grupo_resultado->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_grupo_resultado_nombre" class="grupo_resultado_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $grupo_resultado->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($grupo_resultado->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($grupo_resultado->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$grupo_resultado_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$grupo_resultado_grid->StartRec = 1;
$grupo_resultado_grid->StopRec = $grupo_resultado_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($grupo_resultado_grid->FormKeyCountName) && ($grupo_resultado->CurrentAction == "gridadd" || $grupo_resultado->CurrentAction == "gridedit" || $grupo_resultado->CurrentAction == "F")) {
		$grupo_resultado_grid->KeyCount = $objForm->GetValue($grupo_resultado_grid->FormKeyCountName);
		$grupo_resultado_grid->StopRec = $grupo_resultado_grid->StartRec + $grupo_resultado_grid->KeyCount - 1;
	}
}
$grupo_resultado_grid->RecCnt = $grupo_resultado_grid->StartRec - 1;
if ($grupo_resultado_grid->Recordset && !$grupo_resultado_grid->Recordset->EOF) {
	$grupo_resultado_grid->Recordset->MoveFirst();
	$bSelectLimit = $grupo_resultado_grid->UseSelectLimit;
	if (!$bSelectLimit && $grupo_resultado_grid->StartRec > 1)
		$grupo_resultado_grid->Recordset->Move($grupo_resultado_grid->StartRec - 1);
} elseif (!$grupo_resultado->AllowAddDeleteRow && $grupo_resultado_grid->StopRec == 0) {
	$grupo_resultado_grid->StopRec = $grupo_resultado->GridAddRowCount;
}

// Initialize aggregate
$grupo_resultado->RowType = EW_ROWTYPE_AGGREGATEINIT;
$grupo_resultado->ResetAttrs();
$grupo_resultado_grid->RenderRow();
if ($grupo_resultado->CurrentAction == "gridadd")
	$grupo_resultado_grid->RowIndex = 0;
if ($grupo_resultado->CurrentAction == "gridedit")
	$grupo_resultado_grid->RowIndex = 0;
while ($grupo_resultado_grid->RecCnt < $grupo_resultado_grid->StopRec) {
	$grupo_resultado_grid->RecCnt++;
	if (intval($grupo_resultado_grid->RecCnt) >= intval($grupo_resultado_grid->StartRec)) {
		$grupo_resultado_grid->RowCnt++;
		if ($grupo_resultado->CurrentAction == "gridadd" || $grupo_resultado->CurrentAction == "gridedit" || $grupo_resultado->CurrentAction == "F") {
			$grupo_resultado_grid->RowIndex++;
			$objForm->Index = $grupo_resultado_grid->RowIndex;
			if ($objForm->HasValue($grupo_resultado_grid->FormActionName))
				$grupo_resultado_grid->RowAction = strval($objForm->GetValue($grupo_resultado_grid->FormActionName));
			elseif ($grupo_resultado->CurrentAction == "gridadd")
				$grupo_resultado_grid->RowAction = "insert";
			else
				$grupo_resultado_grid->RowAction = "";
		}

		// Set up key count
		$grupo_resultado_grid->KeyCount = $grupo_resultado_grid->RowIndex;

		// Init row class and style
		$grupo_resultado->ResetAttrs();
		$grupo_resultado->CssClass = "";
		if ($grupo_resultado->CurrentAction == "gridadd") {
			if ($grupo_resultado->CurrentMode == "copy") {
				$grupo_resultado_grid->LoadRowValues($grupo_resultado_grid->Recordset); // Load row values
				$grupo_resultado_grid->SetRecordKey($grupo_resultado_grid->RowOldKey, $grupo_resultado_grid->Recordset); // Set old record key
			} else {
				$grupo_resultado_grid->LoadDefaultValues(); // Load default values
				$grupo_resultado_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$grupo_resultado_grid->LoadRowValues($grupo_resultado_grid->Recordset); // Load row values
		}
		$grupo_resultado->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($grupo_resultado->CurrentAction == "gridadd") // Grid add
			$grupo_resultado->RowType = EW_ROWTYPE_ADD; // Render add
		if ($grupo_resultado->CurrentAction == "gridadd" && $grupo_resultado->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$grupo_resultado_grid->RestoreCurrentRowFormValues($grupo_resultado_grid->RowIndex); // Restore form values
		if ($grupo_resultado->CurrentAction == "gridedit") { // Grid edit
			if ($grupo_resultado->EventCancelled) {
				$grupo_resultado_grid->RestoreCurrentRowFormValues($grupo_resultado_grid->RowIndex); // Restore form values
			}
			if ($grupo_resultado_grid->RowAction == "insert")
				$grupo_resultado->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$grupo_resultado->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($grupo_resultado->CurrentAction == "gridedit" && ($grupo_resultado->RowType == EW_ROWTYPE_EDIT || $grupo_resultado->RowType == EW_ROWTYPE_ADD) && $grupo_resultado->EventCancelled) // Update failed
			$grupo_resultado_grid->RestoreCurrentRowFormValues($grupo_resultado_grid->RowIndex); // Restore form values
		if ($grupo_resultado->RowType == EW_ROWTYPE_EDIT) // Edit row
			$grupo_resultado_grid->EditRowCnt++;
		if ($grupo_resultado->CurrentAction == "F") // Confirm row
			$grupo_resultado_grid->RestoreCurrentRowFormValues($grupo_resultado_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$grupo_resultado->RowAttrs = array_merge($grupo_resultado->RowAttrs, array('data-rowindex'=>$grupo_resultado_grid->RowCnt, 'id'=>'r' . $grupo_resultado_grid->RowCnt . '_grupo_resultado', 'data-rowtype'=>$grupo_resultado->RowType));

		// Render row
		$grupo_resultado_grid->RenderRow();

		// Render list options
		$grupo_resultado_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($grupo_resultado_grid->RowAction <> "delete" && $grupo_resultado_grid->RowAction <> "insertdelete" && !($grupo_resultado_grid->RowAction == "insert" && $grupo_resultado->CurrentAction == "F" && $grupo_resultado_grid->EmptyRow())) {
?>
	<tr<?php echo $grupo_resultado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$grupo_resultado_grid->ListOptions->Render("body", "left", $grupo_resultado_grid->RowCnt);
?>
	<?php if ($grupo_resultado->idclase_resultado->Visible) { // idclase_resultado ?>
		<td data-name="idclase_resultado"<?php echo $grupo_resultado->idclase_resultado->CellAttributes() ?>>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($grupo_resultado->idclase_resultado->getSessionValue() <> "") { ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<span<?php echo $grupo_resultado->idclase_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_resultado->idclase_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<select data-table="grupo_resultado" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_resultado->idclase_resultado->DisplayValueSeparator) ? json_encode($grupo_resultado->idclase_resultado->DisplayValueSeparator) : $grupo_resultado->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado"<?php echo $grupo_resultado->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($grupo_resultado->idclase_resultado->EditValue)) {
	$arwrk = $grupo_resultado->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_resultado->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_resultado->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_resultado->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>" selected><?php echo $grupo_resultado->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $grupo_resultado->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado`= 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_resultado->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_resultado->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_resultado->Lookup_Selecting($grupo_resultado->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_resultado->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo $grupo_resultado->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="grupo_resultado" data-field="x_idclase_resultado" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->OldValue) ?>">
<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($grupo_resultado->idclase_resultado->getSessionValue() <> "") { ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<span<?php echo $grupo_resultado->idclase_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_resultado->idclase_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<select data-table="grupo_resultado" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_resultado->idclase_resultado->DisplayValueSeparator) ? json_encode($grupo_resultado->idclase_resultado->DisplayValueSeparator) : $grupo_resultado->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado"<?php echo $grupo_resultado->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($grupo_resultado->idclase_resultado->EditValue)) {
	$arwrk = $grupo_resultado->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_resultado->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_resultado->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_resultado->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>" selected><?php echo $grupo_resultado->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $grupo_resultado->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado`= 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_resultado->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_resultado->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_resultado->Lookup_Selecting($grupo_resultado->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_resultado->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo $grupo_resultado->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_idclase_resultado" class="grupo_resultado_idclase_resultado">
<span<?php echo $grupo_resultado->idclase_resultado->ViewAttributes() ?>>
<?php echo $grupo_resultado->idclase_resultado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="grupo_resultado" data-field="x_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->FormValue) ?>">
<input type="hidden" data-table="grupo_resultado" data-field="x_idclase_resultado" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->OldValue) ?>">
<?php } ?>
<a id="<?php echo $grupo_resultado_grid->PageObjName . "_row_" . $grupo_resultado_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="grupo_resultado" data-field="x_idgrupo_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idgrupo_resultado->CurrentValue) ?>">
<input type="hidden" data-table="grupo_resultado" data-field="x_idgrupo_resultado" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idgrupo_resultado->OldValue) ?>">
<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_EDIT || $grupo_resultado->CurrentMode == "edit") { ?>
<input type="hidden" data-table="grupo_resultado" data-field="x_idgrupo_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idgrupo_resultado->CurrentValue) ?>">
<?php } ?>
	<?php if ($grupo_resultado->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $grupo_resultado->nombre->CellAttributes() ?>>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_nombre" class="form-group grupo_resultado_nombre">
<input type="text" data-table="grupo_resultado" data-field="x_nombre" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_resultado->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_resultado->nombre->EditValue ?>"<?php echo $grupo_resultado->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="grupo_resultado" data-field="x_nombre" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_resultado->nombre->OldValue) ?>">
<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_nombre" class="form-group grupo_resultado_nombre">
<input type="text" data-table="grupo_resultado" data-field="x_nombre" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_resultado->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_resultado->nombre->EditValue ?>"<?php echo $grupo_resultado->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $grupo_resultado_grid->RowCnt ?>_grupo_resultado_nombre" class="grupo_resultado_nombre">
<span<?php echo $grupo_resultado->nombre->ViewAttributes() ?>>
<?php echo $grupo_resultado->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="grupo_resultado" data-field="x_nombre" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_resultado->nombre->FormValue) ?>">
<input type="hidden" data-table="grupo_resultado" data-field="x_nombre" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_resultado->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$grupo_resultado_grid->ListOptions->Render("body", "right", $grupo_resultado_grid->RowCnt);
?>
	</tr>
<?php if ($grupo_resultado->RowType == EW_ROWTYPE_ADD || $grupo_resultado->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fgrupo_resultadogrid.UpdateOpts(<?php echo $grupo_resultado_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($grupo_resultado->CurrentAction <> "gridadd" || $grupo_resultado->CurrentMode == "copy")
		if (!$grupo_resultado_grid->Recordset->EOF) $grupo_resultado_grid->Recordset->MoveNext();
}
?>
<?php
	if ($grupo_resultado->CurrentMode == "add" || $grupo_resultado->CurrentMode == "copy" || $grupo_resultado->CurrentMode == "edit") {
		$grupo_resultado_grid->RowIndex = '$rowindex$';
		$grupo_resultado_grid->LoadDefaultValues();

		// Set row properties
		$grupo_resultado->ResetAttrs();
		$grupo_resultado->RowAttrs = array_merge($grupo_resultado->RowAttrs, array('data-rowindex'=>$grupo_resultado_grid->RowIndex, 'id'=>'r0_grupo_resultado', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($grupo_resultado->RowAttrs["class"], "ewTemplate");
		$grupo_resultado->RowType = EW_ROWTYPE_ADD;

		// Render row
		$grupo_resultado_grid->RenderRow();

		// Render list options
		$grupo_resultado_grid->RenderListOptions();
		$grupo_resultado_grid->StartRowCnt = 0;
?>
	<tr<?php echo $grupo_resultado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$grupo_resultado_grid->ListOptions->Render("body", "left", $grupo_resultado_grid->RowIndex);
?>
	<?php if ($grupo_resultado->idclase_resultado->Visible) { // idclase_resultado ?>
		<td data-name="idclase_resultado">
<?php if ($grupo_resultado->CurrentAction <> "F") { ?>
<?php if ($grupo_resultado->idclase_resultado->getSessionValue() <> "") { ?>
<span id="el$rowindex$_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<span<?php echo $grupo_resultado->idclase_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_resultado->idclase_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<select data-table="grupo_resultado" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($grupo_resultado->idclase_resultado->DisplayValueSeparator) ? json_encode($grupo_resultado->idclase_resultado->DisplayValueSeparator) : $grupo_resultado->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado"<?php echo $grupo_resultado->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($grupo_resultado->idclase_resultado->EditValue)) {
	$arwrk = $grupo_resultado->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($grupo_resultado->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $grupo_resultado->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($grupo_resultado->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->CurrentValue) ?>" selected><?php echo $grupo_resultado->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $grupo_resultado->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado`= 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$grupo_resultado->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$grupo_resultado->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$grupo_resultado->Lookup_Selecting($grupo_resultado->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $grupo_resultado->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo $grupo_resultado->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_grupo_resultado_idclase_resultado" class="form-group grupo_resultado_idclase_resultado">
<span<?php echo $grupo_resultado->idclase_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_resultado->idclase_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="grupo_resultado" data-field="x_idclase_resultado" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo_resultado" data-field="x_idclase_resultado" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($grupo_resultado->idclase_resultado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($grupo_resultado->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($grupo_resultado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_grupo_resultado_nombre" class="form-group grupo_resultado_nombre">
<input type="text" data-table="grupo_resultado" data-field="x_nombre" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_resultado->nombre->getPlaceHolder()) ?>" value="<?php echo $grupo_resultado->nombre->EditValue ?>"<?php echo $grupo_resultado->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_grupo_resultado_nombre" class="form-group grupo_resultado_nombre">
<span<?php echo $grupo_resultado->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_resultado->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="grupo_resultado" data-field="x_nombre" name="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="x<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_resultado->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="grupo_resultado" data-field="x_nombre" name="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" id="o<?php echo $grupo_resultado_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($grupo_resultado->nombre->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$grupo_resultado_grid->ListOptions->Render("body", "right", $grupo_resultado_grid->RowCnt);
?>
<script type="text/javascript">
fgrupo_resultadogrid.UpdateOpts(<?php echo $grupo_resultado_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($grupo_resultado->CurrentMode == "add" || $grupo_resultado->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $grupo_resultado_grid->FormKeyCountName ?>" id="<?php echo $grupo_resultado_grid->FormKeyCountName ?>" value="<?php echo $grupo_resultado_grid->KeyCount ?>">
<?php echo $grupo_resultado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($grupo_resultado->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $grupo_resultado_grid->FormKeyCountName ?>" id="<?php echo $grupo_resultado_grid->FormKeyCountName ?>" value="<?php echo $grupo_resultado_grid->KeyCount ?>">
<?php echo $grupo_resultado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($grupo_resultado->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fgrupo_resultadogrid">
</div>
<?php

// Close recordset
if ($grupo_resultado_grid->Recordset)
	$grupo_resultado_grid->Recordset->Close();
?>
<?php if ($grupo_resultado_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($grupo_resultado_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($grupo_resultado_grid->TotalRecs == 0 && $grupo_resultado->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($grupo_resultado_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($grupo_resultado->Export == "") { ?>
<script type="text/javascript">
fgrupo_resultadogrid.Init();
</script>
<?php } ?>
<?php
$grupo_resultado_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$grupo_resultado_grid->Page_Terminate();
?>
