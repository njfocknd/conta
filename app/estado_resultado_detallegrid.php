<?php

// Create page object
if (!isset($estado_resultado_detalle_grid)) $estado_resultado_detalle_grid = new cestado_resultado_detalle_grid();

// Page init
$estado_resultado_detalle_grid->Page_Init();

// Page main
$estado_resultado_detalle_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_detalle_grid->Page_Render();
?>
<?php if ($estado_resultado_detalle->Export == "") { ?>
<script type="text/javascript">

// Form object
var festado_resultado_detallegrid = new ew_Form("festado_resultado_detallegrid", "grid");
festado_resultado_detallegrid.FormKeyCountName = '<?php echo $estado_resultado_detalle_grid->FormKeyCountName ?>';

// Validate form
festado_resultado_detallegrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->idclase_resultado->FldCaption(), $estado_resultado_detalle->idclase_resultado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_resultado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->idgrupo_resultado->FldCaption(), $estado_resultado_detalle->idgrupo_resultado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->monto->FldCaption(), $estado_resultado_detalle->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado_detalle->monto->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
festado_resultado_detallegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idclase_resultado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idgrupo_resultado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
festado_resultado_detallegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultado_detallegrid.ValidateRequired = true;
<?php } else { ?>
festado_resultado_detallegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultado_detallegrid.Lists["x_idclase_resultado"] = {"LinkField":"x_idclase_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_resultado"],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detallegrid.Lists["x_idgrupo_resultado"] = {"LinkField":"x_idgrupo_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idclase_resultado"],"ChildFields":[],"FilterFields":["x_idclase_resultado"],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($estado_resultado_detalle->CurrentAction == "gridadd") {
	if ($estado_resultado_detalle->CurrentMode == "copy") {
		$bSelectLimit = $estado_resultado_detalle_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$estado_resultado_detalle_grid->TotalRecs = $estado_resultado_detalle->SelectRecordCount();
			$estado_resultado_detalle_grid->Recordset = $estado_resultado_detalle_grid->LoadRecordset($estado_resultado_detalle_grid->StartRec-1, $estado_resultado_detalle_grid->DisplayRecs);
		} else {
			if ($estado_resultado_detalle_grid->Recordset = $estado_resultado_detalle_grid->LoadRecordset())
				$estado_resultado_detalle_grid->TotalRecs = $estado_resultado_detalle_grid->Recordset->RecordCount();
		}
		$estado_resultado_detalle_grid->StartRec = 1;
		$estado_resultado_detalle_grid->DisplayRecs = $estado_resultado_detalle_grid->TotalRecs;
	} else {
		$estado_resultado_detalle->CurrentFilter = "0=1";
		$estado_resultado_detalle_grid->StartRec = 1;
		$estado_resultado_detalle_grid->DisplayRecs = $estado_resultado_detalle->GridAddRowCount;
	}
	$estado_resultado_detalle_grid->TotalRecs = $estado_resultado_detalle_grid->DisplayRecs;
	$estado_resultado_detalle_grid->StopRec = $estado_resultado_detalle_grid->DisplayRecs;
} else {
	$bSelectLimit = $estado_resultado_detalle_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($estado_resultado_detalle_grid->TotalRecs <= 0)
			$estado_resultado_detalle_grid->TotalRecs = $estado_resultado_detalle->SelectRecordCount();
	} else {
		if (!$estado_resultado_detalle_grid->Recordset && ($estado_resultado_detalle_grid->Recordset = $estado_resultado_detalle_grid->LoadRecordset()))
			$estado_resultado_detalle_grid->TotalRecs = $estado_resultado_detalle_grid->Recordset->RecordCount();
	}
	$estado_resultado_detalle_grid->StartRec = 1;
	$estado_resultado_detalle_grid->DisplayRecs = $estado_resultado_detalle_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$estado_resultado_detalle_grid->Recordset = $estado_resultado_detalle_grid->LoadRecordset($estado_resultado_detalle_grid->StartRec-1, $estado_resultado_detalle_grid->DisplayRecs);

	// Set no record found message
	if ($estado_resultado_detalle->CurrentAction == "" && $estado_resultado_detalle_grid->TotalRecs == 0) {
		if ($estado_resultado_detalle_grid->SearchWhere == "0=101")
			$estado_resultado_detalle_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$estado_resultado_detalle_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$estado_resultado_detalle_grid->RenderOtherOptions();
?>
<?php $estado_resultado_detalle_grid->ShowPageHeader(); ?>
<?php
$estado_resultado_detalle_grid->ShowMessage();
?>
<?php if ($estado_resultado_detalle_grid->TotalRecs > 0 || $estado_resultado_detalle->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="festado_resultado_detallegrid" class="ewForm form-inline">
<?php if ($estado_resultado_detalle_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($estado_resultado_detalle_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_estado_resultado_detalle" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_estado_resultado_detallegrid" class="table ewTable">
<?php echo $estado_resultado_detalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$estado_resultado_detalle_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$estado_resultado_detalle_grid->RenderListOptions();

// Render list options (header, left)
$estado_resultado_detalle_grid->ListOptions->Render("header", "left");
?>
<?php if ($estado_resultado_detalle->idclase_resultado->Visible) { // idclase_resultado ?>
	<?php if ($estado_resultado_detalle->SortUrl($estado_resultado_detalle->idclase_resultado) == "") { ?>
		<th data-name="idclase_resultado"><div id="elh_estado_resultado_detalle_idclase_resultado" class="estado_resultado_detalle_idclase_resultado"><div class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->idclase_resultado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_resultado"><div><div id="elh_estado_resultado_detalle_idclase_resultado" class="estado_resultado_detalle_idclase_resultado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->idclase_resultado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado_detalle->idclase_resultado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado_detalle->idclase_resultado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado_detalle->idgrupo_resultado->Visible) { // idgrupo_resultado ?>
	<?php if ($estado_resultado_detalle->SortUrl($estado_resultado_detalle->idgrupo_resultado) == "") { ?>
		<th data-name="idgrupo_resultado"><div id="elh_estado_resultado_detalle_idgrupo_resultado" class="estado_resultado_detalle_idgrupo_resultado"><div class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->idgrupo_resultado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idgrupo_resultado"><div><div id="elh_estado_resultado_detalle_idgrupo_resultado" class="estado_resultado_detalle_idgrupo_resultado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->idgrupo_resultado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado_detalle->idgrupo_resultado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado_detalle->idgrupo_resultado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado_detalle->monto->Visible) { // monto ?>
	<?php if ($estado_resultado_detalle->SortUrl($estado_resultado_detalle->monto) == "") { ?>
		<th data-name="monto"><div id="elh_estado_resultado_detalle_monto" class="estado_resultado_detalle_monto"><div class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_estado_resultado_detalle_monto" class="estado_resultado_detalle_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado_detalle->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado_detalle->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado_detalle->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$estado_resultado_detalle_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$estado_resultado_detalle_grid->StartRec = 1;
$estado_resultado_detalle_grid->StopRec = $estado_resultado_detalle_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($estado_resultado_detalle_grid->FormKeyCountName) && ($estado_resultado_detalle->CurrentAction == "gridadd" || $estado_resultado_detalle->CurrentAction == "gridedit" || $estado_resultado_detalle->CurrentAction == "F")) {
		$estado_resultado_detalle_grid->KeyCount = $objForm->GetValue($estado_resultado_detalle_grid->FormKeyCountName);
		$estado_resultado_detalle_grid->StopRec = $estado_resultado_detalle_grid->StartRec + $estado_resultado_detalle_grid->KeyCount - 1;
	}
}
$estado_resultado_detalle_grid->RecCnt = $estado_resultado_detalle_grid->StartRec - 1;
if ($estado_resultado_detalle_grid->Recordset && !$estado_resultado_detalle_grid->Recordset->EOF) {
	$estado_resultado_detalle_grid->Recordset->MoveFirst();
	$bSelectLimit = $estado_resultado_detalle_grid->UseSelectLimit;
	if (!$bSelectLimit && $estado_resultado_detalle_grid->StartRec > 1)
		$estado_resultado_detalle_grid->Recordset->Move($estado_resultado_detalle_grid->StartRec - 1);
} elseif (!$estado_resultado_detalle->AllowAddDeleteRow && $estado_resultado_detalle_grid->StopRec == 0) {
	$estado_resultado_detalle_grid->StopRec = $estado_resultado_detalle->GridAddRowCount;
}

// Initialize aggregate
$estado_resultado_detalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$estado_resultado_detalle->ResetAttrs();
$estado_resultado_detalle_grid->RenderRow();
if ($estado_resultado_detalle->CurrentAction == "gridadd")
	$estado_resultado_detalle_grid->RowIndex = 0;
if ($estado_resultado_detalle->CurrentAction == "gridedit")
	$estado_resultado_detalle_grid->RowIndex = 0;
while ($estado_resultado_detalle_grid->RecCnt < $estado_resultado_detalle_grid->StopRec) {
	$estado_resultado_detalle_grid->RecCnt++;
	if (intval($estado_resultado_detalle_grid->RecCnt) >= intval($estado_resultado_detalle_grid->StartRec)) {
		$estado_resultado_detalle_grid->RowCnt++;
		if ($estado_resultado_detalle->CurrentAction == "gridadd" || $estado_resultado_detalle->CurrentAction == "gridedit" || $estado_resultado_detalle->CurrentAction == "F") {
			$estado_resultado_detalle_grid->RowIndex++;
			$objForm->Index = $estado_resultado_detalle_grid->RowIndex;
			if ($objForm->HasValue($estado_resultado_detalle_grid->FormActionName))
				$estado_resultado_detalle_grid->RowAction = strval($objForm->GetValue($estado_resultado_detalle_grid->FormActionName));
			elseif ($estado_resultado_detalle->CurrentAction == "gridadd")
				$estado_resultado_detalle_grid->RowAction = "insert";
			else
				$estado_resultado_detalle_grid->RowAction = "";
		}

		// Set up key count
		$estado_resultado_detalle_grid->KeyCount = $estado_resultado_detalle_grid->RowIndex;

		// Init row class and style
		$estado_resultado_detalle->ResetAttrs();
		$estado_resultado_detalle->CssClass = "";
		if ($estado_resultado_detalle->CurrentAction == "gridadd") {
			if ($estado_resultado_detalle->CurrentMode == "copy") {
				$estado_resultado_detalle_grid->LoadRowValues($estado_resultado_detalle_grid->Recordset); // Load row values
				$estado_resultado_detalle_grid->SetRecordKey($estado_resultado_detalle_grid->RowOldKey, $estado_resultado_detalle_grid->Recordset); // Set old record key
			} else {
				$estado_resultado_detalle_grid->LoadDefaultValues(); // Load default values
				$estado_resultado_detalle_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$estado_resultado_detalle_grid->LoadRowValues($estado_resultado_detalle_grid->Recordset); // Load row values
		}
		$estado_resultado_detalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($estado_resultado_detalle->CurrentAction == "gridadd") // Grid add
			$estado_resultado_detalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($estado_resultado_detalle->CurrentAction == "gridadd" && $estado_resultado_detalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$estado_resultado_detalle_grid->RestoreCurrentRowFormValues($estado_resultado_detalle_grid->RowIndex); // Restore form values
		if ($estado_resultado_detalle->CurrentAction == "gridedit") { // Grid edit
			if ($estado_resultado_detalle->EventCancelled) {
				$estado_resultado_detalle_grid->RestoreCurrentRowFormValues($estado_resultado_detalle_grid->RowIndex); // Restore form values
			}
			if ($estado_resultado_detalle_grid->RowAction == "insert")
				$estado_resultado_detalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$estado_resultado_detalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($estado_resultado_detalle->CurrentAction == "gridedit" && ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT || $estado_resultado_detalle->RowType == EW_ROWTYPE_ADD) && $estado_resultado_detalle->EventCancelled) // Update failed
			$estado_resultado_detalle_grid->RestoreCurrentRowFormValues($estado_resultado_detalle_grid->RowIndex); // Restore form values
		if ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$estado_resultado_detalle_grid->EditRowCnt++;
		if ($estado_resultado_detalle->CurrentAction == "F") // Confirm row
			$estado_resultado_detalle_grid->RestoreCurrentRowFormValues($estado_resultado_detalle_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$estado_resultado_detalle->RowAttrs = array_merge($estado_resultado_detalle->RowAttrs, array('data-rowindex'=>$estado_resultado_detalle_grid->RowCnt, 'id'=>'r' . $estado_resultado_detalle_grid->RowCnt . '_estado_resultado_detalle', 'data-rowtype'=>$estado_resultado_detalle->RowType));

		// Render row
		$estado_resultado_detalle_grid->RenderRow();

		// Render list options
		$estado_resultado_detalle_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($estado_resultado_detalle_grid->RowAction <> "delete" && $estado_resultado_detalle_grid->RowAction <> "insertdelete" && !($estado_resultado_detalle_grid->RowAction == "insert" && $estado_resultado_detalle->CurrentAction == "F" && $estado_resultado_detalle_grid->EmptyRow())) {
?>
	<tr<?php echo $estado_resultado_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$estado_resultado_detalle_grid->ListOptions->Render("body", "left", $estado_resultado_detalle_grid->RowCnt);
?>
	<?php if ($estado_resultado_detalle->idclase_resultado->Visible) { // idclase_resultado ?>
		<td data-name="idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->CellAttributes() ?>>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idclase_resultado" class="form-group estado_resultado_detalle_idclase_resultado">
<?php $estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"]; ?>
<select data-table="estado_resultado_detalle" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idclase_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo $estado_resultado_detalle->idclase_resultado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idclase_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->OldValue) ?>">
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idclase_resultado" class="form-group estado_resultado_detalle_idclase_resultado">
<?php $estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"]; ?>
<select data-table="estado_resultado_detalle" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idclase_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo $estado_resultado_detalle->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idclase_resultado" class="estado_resultado_detalle_idclase_resultado">
<span<?php echo $estado_resultado_detalle->idclase_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idclase_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->FormValue) ?>">
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idclase_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->OldValue) ?>">
<?php } ?>
<a id="<?php echo $estado_resultado_detalle_grid->PageObjName . "_row_" . $estado_resultado_detalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idestado_resultado_detalle" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idestado_resultado_detalle->CurrentValue) ?>">
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idestado_resultado_detalle" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idestado_resultado_detalle->OldValue) ?>">
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT || $estado_resultado_detalle->CurrentMode == "edit") { ?>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idestado_resultado_detalle" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idestado_resultado_detalle" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idestado_resultado_detalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($estado_resultado_detalle->idgrupo_resultado->Visible) { // idgrupo_resultado ?>
		<td data-name="idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->CellAttributes() ?>>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idgrupo_resultado" class="form-group estado_resultado_detalle_idgrupo_resultado">
<select data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idgrupo_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idgrupo_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idgrupo_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idgrupo_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idgrupo_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idgrupo_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idgrupo_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f0" => "`idgrupo_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f1" => "`idclase_resultado` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idgrupo_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo $estado_resultado_detalle->idgrupo_resultado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->OldValue) ?>">
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idgrupo_resultado" class="form-group estado_resultado_detalle_idgrupo_resultado">
<select data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idgrupo_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idgrupo_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idgrupo_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idgrupo_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idgrupo_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idgrupo_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idgrupo_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f0" => "`idgrupo_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f1" => "`idclase_resultado` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idgrupo_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo $estado_resultado_detalle->idgrupo_resultado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_idgrupo_resultado" class="estado_resultado_detalle_idgrupo_resultado">
<span<?php echo $estado_resultado_detalle->idgrupo_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->FormValue) ?>">
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($estado_resultado_detalle->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $estado_resultado_detalle->monto->CellAttributes() ?>>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_monto" class="form-group estado_resultado_detalle_monto">
<input type="text" data-table="estado_resultado_detalle" data-field="x_monto" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $estado_resultado_detalle->monto->EditValue ?>"<?php echo $estado_resultado_detalle->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_monto" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->OldValue) ?>">
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_monto" class="form-group estado_resultado_detalle_monto">
<input type="text" data-table="estado_resultado_detalle" data-field="x_monto" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $estado_resultado_detalle->monto->EditValue ?>"<?php echo $estado_resultado_detalle->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $estado_resultado_detalle_grid->RowCnt ?>_estado_resultado_detalle_monto" class="estado_resultado_detalle_monto">
<span<?php echo $estado_resultado_detalle->monto->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->monto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_monto" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->FormValue) ?>">
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_monto" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estado_resultado_detalle_grid->ListOptions->Render("body", "right", $estado_resultado_detalle_grid->RowCnt);
?>
	</tr>
<?php if ($estado_resultado_detalle->RowType == EW_ROWTYPE_ADD || $estado_resultado_detalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
festado_resultado_detallegrid.UpdateOpts(<?php echo $estado_resultado_detalle_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($estado_resultado_detalle->CurrentAction <> "gridadd" || $estado_resultado_detalle->CurrentMode == "copy")
		if (!$estado_resultado_detalle_grid->Recordset->EOF) $estado_resultado_detalle_grid->Recordset->MoveNext();
}
?>
<?php
	if ($estado_resultado_detalle->CurrentMode == "add" || $estado_resultado_detalle->CurrentMode == "copy" || $estado_resultado_detalle->CurrentMode == "edit") {
		$estado_resultado_detalle_grid->RowIndex = '$rowindex$';
		$estado_resultado_detalle_grid->LoadDefaultValues();

		// Set row properties
		$estado_resultado_detalle->ResetAttrs();
		$estado_resultado_detalle->RowAttrs = array_merge($estado_resultado_detalle->RowAttrs, array('data-rowindex'=>$estado_resultado_detalle_grid->RowIndex, 'id'=>'r0_estado_resultado_detalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($estado_resultado_detalle->RowAttrs["class"], "ewTemplate");
		$estado_resultado_detalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$estado_resultado_detalle_grid->RenderRow();

		// Render list options
		$estado_resultado_detalle_grid->RenderListOptions();
		$estado_resultado_detalle_grid->StartRowCnt = 0;
?>
	<tr<?php echo $estado_resultado_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$estado_resultado_detalle_grid->ListOptions->Render("body", "left", $estado_resultado_detalle_grid->RowIndex);
?>
	<?php if ($estado_resultado_detalle->idclase_resultado->Visible) { // idclase_resultado ?>
		<td data-name="idclase_resultado">
<?php if ($estado_resultado_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_resultado_detalle_idclase_resultado" class="form-group estado_resultado_detalle_idclase_resultado">
<?php $estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"]; ?>
<select data-table="estado_resultado_detalle" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idclase_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idclase_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo $estado_resultado_detalle->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_resultado_detalle_idclase_resultado" class="form-group estado_resultado_detalle_idclase_resultado">
<span<?php echo $estado_resultado_detalle->idclase_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_resultado_detalle->idclase_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idclase_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idclase_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idclase_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_resultado_detalle->idgrupo_resultado->Visible) { // idgrupo_resultado ?>
		<td data-name="idgrupo_resultado">
<?php if ($estado_resultado_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_resultado_detalle_idgrupo_resultado" class="form-group estado_resultado_detalle_idgrupo_resultado">
<select data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ?>" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idgrupo_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idgrupo_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idgrupo_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idgrupo_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idgrupo_resultado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $estado_resultado_detalle->idgrupo_resultado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idgrupo_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f0" => "`idgrupo_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f1" => "`idclase_resultado` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idgrupo_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="s_x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo $estado_resultado_detalle->idgrupo_resultado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_resultado_detalle_idgrupo_resultado" class="form-group estado_resultado_detalle_idgrupo_resultado">
<span<?php echo $estado_resultado_detalle->idgrupo_resultado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_resultado_detalle->idgrupo_resultado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_idgrupo_resultado" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($estado_resultado_detalle->monto->Visible) { // monto ?>
		<td data-name="monto">
<?php if ($estado_resultado_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_estado_resultado_detalle_monto" class="form-group estado_resultado_detalle_monto">
<input type="text" data-table="estado_resultado_detalle" data-field="x_monto" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $estado_resultado_detalle->monto->EditValue ?>"<?php echo $estado_resultado_detalle->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_estado_resultado_detalle_monto" class="form-group estado_resultado_detalle_monto">
<span<?php echo $estado_resultado_detalle->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $estado_resultado_detalle->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_monto" name="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="x<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="estado_resultado_detalle" data-field="x_monto" name="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" id="o<?php echo $estado_resultado_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estado_resultado_detalle_grid->ListOptions->Render("body", "right", $estado_resultado_detalle_grid->RowCnt);
?>
<script type="text/javascript">
festado_resultado_detallegrid.UpdateOpts(<?php echo $estado_resultado_detalle_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($estado_resultado_detalle->CurrentMode == "add" || $estado_resultado_detalle->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $estado_resultado_detalle_grid->FormKeyCountName ?>" id="<?php echo $estado_resultado_detalle_grid->FormKeyCountName ?>" value="<?php echo $estado_resultado_detalle_grid->KeyCount ?>">
<?php echo $estado_resultado_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($estado_resultado_detalle->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $estado_resultado_detalle_grid->FormKeyCountName ?>" id="<?php echo $estado_resultado_detalle_grid->FormKeyCountName ?>" value="<?php echo $estado_resultado_detalle_grid->KeyCount ?>">
<?php echo $estado_resultado_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($estado_resultado_detalle->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="festado_resultado_detallegrid">
</div>
<?php

// Close recordset
if ($estado_resultado_detalle_grid->Recordset)
	$estado_resultado_detalle_grid->Recordset->Close();
?>
<?php if ($estado_resultado_detalle_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($estado_resultado_detalle_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($estado_resultado_detalle_grid->TotalRecs == 0 && $estado_resultado_detalle->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($estado_resultado_detalle_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($estado_resultado_detalle->Export == "") { ?>
<script type="text/javascript">
festado_resultado_detallegrid.Init();
</script>
<?php } ?>
<?php
$estado_resultado_detalle_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$estado_resultado_detalle_grid->Page_Terminate();
?>
