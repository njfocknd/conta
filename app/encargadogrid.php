<?php

// Create page object
if (!isset($encargado_grid)) $encargado_grid = new cencargado_grid();

// Page init
$encargado_grid->Page_Init();

// Page main
$encargado_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$encargado_grid->Page_Render();
?>
<?php if ($encargado->Export == "") { ?>
<script type="text/javascript">

// Form object
var fencargadogrid = new ew_Form("fencargadogrid", "grid");
fencargadogrid.FormKeyCountName = '<?php echo $encargado_grid->FormKeyCountName ?>';

// Validate form
fencargadogrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idempleado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $encargado->idempleado->FldCaption(), $encargado->idempleado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tabla");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $encargado->tabla->FldCaption(), $encargado->tabla->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idreferencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $encargado->idreferencia->FldCaption(), $encargado->idreferencia->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_inicio");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($encargado->fecha_inicio->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha_fin");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($encargado->fecha_fin->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $encargado->estado->FldCaption(), $encargado->estado->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fencargadogrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idempleado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tabla", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idreferencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_inicio", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_fin", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	return true;
}

// Form_CustomValidate event
fencargadogrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fencargadogrid.ValidateRequired = true;
<?php } else { ?>
fencargadogrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fencargadogrid.Lists["x_idempleado"] = {"LinkField":"x_idempleado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fencargadogrid.Lists["x_idreferencia"] = {"LinkField":"x_idcaja_chica","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fencargadogrid.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fencargadogrid.Lists["x_estado"].Options = <?php echo json_encode($encargado->estado->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($encargado->CurrentAction == "gridadd") {
	if ($encargado->CurrentMode == "copy") {
		$bSelectLimit = $encargado_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$encargado_grid->TotalRecs = $encargado->SelectRecordCount();
			$encargado_grid->Recordset = $encargado_grid->LoadRecordset($encargado_grid->StartRec-1, $encargado_grid->DisplayRecs);
		} else {
			if ($encargado_grid->Recordset = $encargado_grid->LoadRecordset())
				$encargado_grid->TotalRecs = $encargado_grid->Recordset->RecordCount();
		}
		$encargado_grid->StartRec = 1;
		$encargado_grid->DisplayRecs = $encargado_grid->TotalRecs;
	} else {
		$encargado->CurrentFilter = "0=1";
		$encargado_grid->StartRec = 1;
		$encargado_grid->DisplayRecs = $encargado->GridAddRowCount;
	}
	$encargado_grid->TotalRecs = $encargado_grid->DisplayRecs;
	$encargado_grid->StopRec = $encargado_grid->DisplayRecs;
} else {
	$bSelectLimit = $encargado_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($encargado_grid->TotalRecs <= 0)
			$encargado_grid->TotalRecs = $encargado->SelectRecordCount();
	} else {
		if (!$encargado_grid->Recordset && ($encargado_grid->Recordset = $encargado_grid->LoadRecordset()))
			$encargado_grid->TotalRecs = $encargado_grid->Recordset->RecordCount();
	}
	$encargado_grid->StartRec = 1;
	$encargado_grid->DisplayRecs = $encargado_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$encargado_grid->Recordset = $encargado_grid->LoadRecordset($encargado_grid->StartRec-1, $encargado_grid->DisplayRecs);

	// Set no record found message
	if ($encargado->CurrentAction == "" && $encargado_grid->TotalRecs == 0) {
		if ($encargado_grid->SearchWhere == "0=101")
			$encargado_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$encargado_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$encargado_grid->RenderOtherOptions();
?>
<?php $encargado_grid->ShowPageHeader(); ?>
<?php
$encargado_grid->ShowMessage();
?>
<?php if ($encargado_grid->TotalRecs > 0 || $encargado->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fencargadogrid" class="ewForm form-inline">
<div id="gmp_encargado" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_encargadogrid" class="table ewTable">
<?php echo $encargado->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$encargado_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$encargado_grid->RenderListOptions();

// Render list options (header, left)
$encargado_grid->ListOptions->Render("header", "left");
?>
<?php if ($encargado->idempleado->Visible) { // idempleado ?>
	<?php if ($encargado->SortUrl($encargado->idempleado) == "") { ?>
		<th data-name="idempleado"><div id="elh_encargado_idempleado" class="encargado_idempleado"><div class="ewTableHeaderCaption"><?php echo $encargado->idempleado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempleado"><div><div id="elh_encargado_idempleado" class="encargado_idempleado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->idempleado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->idempleado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->idempleado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($encargado->tabla->Visible) { // tabla ?>
	<?php if ($encargado->SortUrl($encargado->tabla) == "") { ?>
		<th data-name="tabla"><div id="elh_encargado_tabla" class="encargado_tabla"><div class="ewTableHeaderCaption"><?php echo $encargado->tabla->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tabla"><div><div id="elh_encargado_tabla" class="encargado_tabla">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->tabla->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->tabla->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->tabla->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($encargado->idreferencia->Visible) { // idreferencia ?>
	<?php if ($encargado->SortUrl($encargado->idreferencia) == "") { ?>
		<th data-name="idreferencia"><div id="elh_encargado_idreferencia" class="encargado_idreferencia"><div class="ewTableHeaderCaption"><?php echo $encargado->idreferencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idreferencia"><div><div id="elh_encargado_idreferencia" class="encargado_idreferencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->idreferencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->idreferencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->idreferencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($encargado->fecha_inicio->Visible) { // fecha_inicio ?>
	<?php if ($encargado->SortUrl($encargado->fecha_inicio) == "") { ?>
		<th data-name="fecha_inicio"><div id="elh_encargado_fecha_inicio" class="encargado_fecha_inicio"><div class="ewTableHeaderCaption"><?php echo $encargado->fecha_inicio->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_inicio"><div><div id="elh_encargado_fecha_inicio" class="encargado_fecha_inicio">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->fecha_inicio->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->fecha_inicio->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->fecha_inicio->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($encargado->fecha_fin->Visible) { // fecha_fin ?>
	<?php if ($encargado->SortUrl($encargado->fecha_fin) == "") { ?>
		<th data-name="fecha_fin"><div id="elh_encargado_fecha_fin" class="encargado_fecha_fin"><div class="ewTableHeaderCaption"><?php echo $encargado->fecha_fin->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_fin"><div><div id="elh_encargado_fecha_fin" class="encargado_fecha_fin">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->fecha_fin->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->fecha_fin->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->fecha_fin->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($encargado->estado->Visible) { // estado ?>
	<?php if ($encargado->SortUrl($encargado->estado) == "") { ?>
		<th data-name="estado"><div id="elh_encargado_estado" class="encargado_estado"><div class="ewTableHeaderCaption"><?php echo $encargado->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_encargado_estado" class="encargado_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $encargado->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($encargado->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($encargado->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$encargado_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$encargado_grid->StartRec = 1;
$encargado_grid->StopRec = $encargado_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($encargado_grid->FormKeyCountName) && ($encargado->CurrentAction == "gridadd" || $encargado->CurrentAction == "gridedit" || $encargado->CurrentAction == "F")) {
		$encargado_grid->KeyCount = $objForm->GetValue($encargado_grid->FormKeyCountName);
		$encargado_grid->StopRec = $encargado_grid->StartRec + $encargado_grid->KeyCount - 1;
	}
}
$encargado_grid->RecCnt = $encargado_grid->StartRec - 1;
if ($encargado_grid->Recordset && !$encargado_grid->Recordset->EOF) {
	$encargado_grid->Recordset->MoveFirst();
	$bSelectLimit = $encargado_grid->UseSelectLimit;
	if (!$bSelectLimit && $encargado_grid->StartRec > 1)
		$encargado_grid->Recordset->Move($encargado_grid->StartRec - 1);
} elseif (!$encargado->AllowAddDeleteRow && $encargado_grid->StopRec == 0) {
	$encargado_grid->StopRec = $encargado->GridAddRowCount;
}

// Initialize aggregate
$encargado->RowType = EW_ROWTYPE_AGGREGATEINIT;
$encargado->ResetAttrs();
$encargado_grid->RenderRow();
if ($encargado->CurrentAction == "gridadd")
	$encargado_grid->RowIndex = 0;
if ($encargado->CurrentAction == "gridedit")
	$encargado_grid->RowIndex = 0;
while ($encargado_grid->RecCnt < $encargado_grid->StopRec) {
	$encargado_grid->RecCnt++;
	if (intval($encargado_grid->RecCnt) >= intval($encargado_grid->StartRec)) {
		$encargado_grid->RowCnt++;
		if ($encargado->CurrentAction == "gridadd" || $encargado->CurrentAction == "gridedit" || $encargado->CurrentAction == "F") {
			$encargado_grid->RowIndex++;
			$objForm->Index = $encargado_grid->RowIndex;
			if ($objForm->HasValue($encargado_grid->FormActionName))
				$encargado_grid->RowAction = strval($objForm->GetValue($encargado_grid->FormActionName));
			elseif ($encargado->CurrentAction == "gridadd")
				$encargado_grid->RowAction = "insert";
			else
				$encargado_grid->RowAction = "";
		}

		// Set up key count
		$encargado_grid->KeyCount = $encargado_grid->RowIndex;

		// Init row class and style
		$encargado->ResetAttrs();
		$encargado->CssClass = "";
		if ($encargado->CurrentAction == "gridadd") {
			if ($encargado->CurrentMode == "copy") {
				$encargado_grid->LoadRowValues($encargado_grid->Recordset); // Load row values
				$encargado_grid->SetRecordKey($encargado_grid->RowOldKey, $encargado_grid->Recordset); // Set old record key
			} else {
				$encargado_grid->LoadDefaultValues(); // Load default values
				$encargado_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$encargado_grid->LoadRowValues($encargado_grid->Recordset); // Load row values
		}
		$encargado->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($encargado->CurrentAction == "gridadd") // Grid add
			$encargado->RowType = EW_ROWTYPE_ADD; // Render add
		if ($encargado->CurrentAction == "gridadd" && $encargado->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$encargado_grid->RestoreCurrentRowFormValues($encargado_grid->RowIndex); // Restore form values
		if ($encargado->CurrentAction == "gridedit") { // Grid edit
			if ($encargado->EventCancelled) {
				$encargado_grid->RestoreCurrentRowFormValues($encargado_grid->RowIndex); // Restore form values
			}
			if ($encargado_grid->RowAction == "insert")
				$encargado->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$encargado->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($encargado->CurrentAction == "gridedit" && ($encargado->RowType == EW_ROWTYPE_EDIT || $encargado->RowType == EW_ROWTYPE_ADD) && $encargado->EventCancelled) // Update failed
			$encargado_grid->RestoreCurrentRowFormValues($encargado_grid->RowIndex); // Restore form values
		if ($encargado->RowType == EW_ROWTYPE_EDIT) // Edit row
			$encargado_grid->EditRowCnt++;
		if ($encargado->CurrentAction == "F") // Confirm row
			$encargado_grid->RestoreCurrentRowFormValues($encargado_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$encargado->RowAttrs = array_merge($encargado->RowAttrs, array('data-rowindex'=>$encargado_grid->RowCnt, 'id'=>'r' . $encargado_grid->RowCnt . '_encargado', 'data-rowtype'=>$encargado->RowType));

		// Render row
		$encargado_grid->RenderRow();

		// Render list options
		$encargado_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($encargado_grid->RowAction <> "delete" && $encargado_grid->RowAction <> "insertdelete" && !($encargado_grid->RowAction == "insert" && $encargado->CurrentAction == "F" && $encargado_grid->EmptyRow())) {
?>
	<tr<?php echo $encargado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$encargado_grid->ListOptions->Render("body", "left", $encargado_grid->RowCnt);
?>
	<?php if ($encargado->idempleado->Visible) { // idempleado ?>
		<td data-name="idempleado"<?php echo $encargado->idempleado->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idempleado" class="form-group encargado_idempleado">
<select data-table="encargado" data-field="x_idempleado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idempleado->DisplayValueSeparator) ? json_encode($encargado->idempleado->DisplayValueSeparator) : $encargado->idempleado->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idempleado" name="x<?php echo $encargado_grid->RowIndex ?>_idempleado"<?php echo $encargado->idempleado->EditAttributes() ?>>
<?php
if (is_array($encargado->idempleado->EditValue)) {
	$arwrk = $encargado->idempleado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idempleado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idempleado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idempleado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idempleado->CurrentValue) ?>" selected><?php echo $encargado->idempleado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idempleado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
$sWhereWrk = "";
$encargado->idempleado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idempleado->LookupFilters += array("f0" => "`idempleado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idempleado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idempleado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" id="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo $encargado->idempleado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="encargado" data-field="x_idempleado" name="o<?php echo $encargado_grid->RowIndex ?>_idempleado" id="o<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($encargado->idempleado->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idempleado" class="form-group encargado_idempleado">
<select data-table="encargado" data-field="x_idempleado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idempleado->DisplayValueSeparator) ? json_encode($encargado->idempleado->DisplayValueSeparator) : $encargado->idempleado->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idempleado" name="x<?php echo $encargado_grid->RowIndex ?>_idempleado"<?php echo $encargado->idempleado->EditAttributes() ?>>
<?php
if (is_array($encargado->idempleado->EditValue)) {
	$arwrk = $encargado->idempleado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idempleado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idempleado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idempleado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idempleado->CurrentValue) ?>" selected><?php echo $encargado->idempleado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idempleado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
$sWhereWrk = "";
$encargado->idempleado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idempleado->LookupFilters += array("f0" => "`idempleado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idempleado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idempleado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" id="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo $encargado->idempleado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idempleado" class="encargado_idempleado">
<span<?php echo $encargado->idempleado->ViewAttributes() ?>>
<?php echo $encargado->idempleado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_idempleado" name="x<?php echo $encargado_grid->RowIndex ?>_idempleado" id="x<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($encargado->idempleado->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_idempleado" name="o<?php echo $encargado_grid->RowIndex ?>_idempleado" id="o<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($encargado->idempleado->OldValue) ?>">
<?php } ?>
<a id="<?php echo $encargado_grid->PageObjName . "_row_" . $encargado_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="encargado" data-field="x_idencargado" name="x<?php echo $encargado_grid->RowIndex ?>_idencargado" id="x<?php echo $encargado_grid->RowIndex ?>_idencargado" value="<?php echo ew_HtmlEncode($encargado->idencargado->CurrentValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_idencargado" name="o<?php echo $encargado_grid->RowIndex ?>_idencargado" id="o<?php echo $encargado_grid->RowIndex ?>_idencargado" value="<?php echo ew_HtmlEncode($encargado->idencargado->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT || $encargado->CurrentMode == "edit") { ?>
<input type="hidden" data-table="encargado" data-field="x_idencargado" name="x<?php echo $encargado_grid->RowIndex ?>_idencargado" id="x<?php echo $encargado_grid->RowIndex ?>_idencargado" value="<?php echo ew_HtmlEncode($encargado->idencargado->CurrentValue) ?>">
<?php } ?>
	<?php if ($encargado->tabla->Visible) { // tabla ?>
		<td data-name="tabla"<?php echo $encargado->tabla->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_tabla" class="form-group encargado_tabla">
<input type="text" data-table="encargado" data-field="x_tabla" name="x<?php echo $encargado_grid->RowIndex ?>_tabla" id="x<?php echo $encargado_grid->RowIndex ?>_tabla" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($encargado->tabla->getPlaceHolder()) ?>" value="<?php echo $encargado->tabla->EditValue ?>"<?php echo $encargado->tabla->EditAttributes() ?>>
</span>
<input type="hidden" data-table="encargado" data-field="x_tabla" name="o<?php echo $encargado_grid->RowIndex ?>_tabla" id="o<?php echo $encargado_grid->RowIndex ?>_tabla" value="<?php echo ew_HtmlEncode($encargado->tabla->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_tabla" class="form-group encargado_tabla">
<input type="text" data-table="encargado" data-field="x_tabla" name="x<?php echo $encargado_grid->RowIndex ?>_tabla" id="x<?php echo $encargado_grid->RowIndex ?>_tabla" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($encargado->tabla->getPlaceHolder()) ?>" value="<?php echo $encargado->tabla->EditValue ?>"<?php echo $encargado->tabla->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_tabla" class="encargado_tabla">
<span<?php echo $encargado->tabla->ViewAttributes() ?>>
<?php echo $encargado->tabla->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_tabla" name="x<?php echo $encargado_grid->RowIndex ?>_tabla" id="x<?php echo $encargado_grid->RowIndex ?>_tabla" value="<?php echo ew_HtmlEncode($encargado->tabla->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_tabla" name="o<?php echo $encargado_grid->RowIndex ?>_tabla" id="o<?php echo $encargado_grid->RowIndex ?>_tabla" value="<?php echo ew_HtmlEncode($encargado->tabla->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($encargado->idreferencia->Visible) { // idreferencia ?>
		<td data-name="idreferencia"<?php echo $encargado->idreferencia->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($encargado->idreferencia->getSessionValue() <> "") { ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idreferencia" class="form-group encargado_idreferencia">
<span<?php echo $encargado->idreferencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->idreferencia->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idreferencia" class="form-group encargado_idreferencia">
<select data-table="encargado" data-field="x_idreferencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idreferencia->DisplayValueSeparator) ? json_encode($encargado->idreferencia->DisplayValueSeparator) : $encargado->idreferencia->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia"<?php echo $encargado->idreferencia->EditAttributes() ?>>
<?php
if (is_array($encargado->idreferencia->EditValue)) {
	$arwrk = $encargado->idreferencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idreferencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idreferencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idreferencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>" selected><?php echo $encargado->idreferencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idreferencia->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$encargado->idreferencia->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idreferencia->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idreferencia, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idreferencia->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo $encargado->idreferencia->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_idreferencia" name="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($encargado->idreferencia->getSessionValue() <> "") { ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idreferencia" class="form-group encargado_idreferencia">
<span<?php echo $encargado->idreferencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->idreferencia->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idreferencia" class="form-group encargado_idreferencia">
<select data-table="encargado" data-field="x_idreferencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idreferencia->DisplayValueSeparator) ? json_encode($encargado->idreferencia->DisplayValueSeparator) : $encargado->idreferencia->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia"<?php echo $encargado->idreferencia->EditAttributes() ?>>
<?php
if (is_array($encargado->idreferencia->EditValue)) {
	$arwrk = $encargado->idreferencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idreferencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idreferencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idreferencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>" selected><?php echo $encargado->idreferencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idreferencia->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$encargado->idreferencia->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idreferencia->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idreferencia, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idreferencia->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo $encargado->idreferencia->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_idreferencia" class="encargado_idreferencia">
<span<?php echo $encargado->idreferencia->ViewAttributes() ?>>
<?php echo $encargado->idreferencia->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_idreferencia" name="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($encargado->fecha_inicio->Visible) { // fecha_inicio ?>
		<td data-name="fecha_inicio"<?php echo $encargado->fecha_inicio->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_inicio" class="form-group encargado_fecha_inicio">
<input type="text" data-table="encargado" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_inicio->EditValue ?>"<?php echo $encargado->fecha_inicio->EditAttributes() ?>>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_inicio" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($encargado->fecha_inicio->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_inicio" class="form-group encargado_fecha_inicio">
<input type="text" data-table="encargado" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_inicio->EditValue ?>"<?php echo $encargado->fecha_inicio->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_inicio" class="encargado_fecha_inicio">
<span<?php echo $encargado->fecha_inicio->ViewAttributes() ?>>
<?php echo $encargado->fecha_inicio->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_inicio" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($encargado->fecha_inicio->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_fecha_inicio" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($encargado->fecha_inicio->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($encargado->fecha_fin->Visible) { // fecha_fin ?>
		<td data-name="fecha_fin"<?php echo $encargado->fecha_fin->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_fin" class="form-group encargado_fecha_fin">
<input type="text" data-table="encargado" data-field="x_fecha_fin" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_fin->EditValue ?>"<?php echo $encargado->fecha_fin->EditAttributes() ?>>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_fin" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($encargado->fecha_fin->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_fin" class="form-group encargado_fecha_fin">
<input type="text" data-table="encargado" data-field="x_fecha_fin" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_fin->EditValue ?>"<?php echo $encargado->fecha_fin->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_fecha_fin" class="encargado_fecha_fin">
<span<?php echo $encargado->fecha_fin->ViewAttributes() ?>>
<?php echo $encargado->fecha_fin->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_fin" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($encargado->fecha_fin->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_fecha_fin" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($encargado->fecha_fin->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($encargado->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $encargado->estado->CellAttributes() ?>>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_estado" class="form-group encargado_estado">
<div id="tp_x<?php echo $encargado_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="encargado" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->estado->DisplayValueSeparator) ? json_encode($encargado->estado->DisplayValueSeparator) : $encargado->estado->DisplayValueSeparator) ?>" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado" value="{value}"<?php echo $encargado->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $encargado_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $encargado->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($encargado->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($encargado->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($encargado->estado->CurrentValue) ?>" checked<?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $encargado->estado->OldValue = "";
?>
</div></div>
</span>
<input type="hidden" data-table="encargado" data-field="x_estado" name="o<?php echo $encargado_grid->RowIndex ?>_estado" id="o<?php echo $encargado_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($encargado->estado->OldValue) ?>">
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_estado" class="form-group encargado_estado">
<div id="tp_x<?php echo $encargado_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="encargado" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->estado->DisplayValueSeparator) ? json_encode($encargado->estado->DisplayValueSeparator) : $encargado->estado->DisplayValueSeparator) ?>" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado" value="{value}"<?php echo $encargado->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $encargado_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $encargado->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($encargado->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($encargado->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($encargado->estado->CurrentValue) ?>" checked<?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $encargado->estado->OldValue = "";
?>
</div></div>
</span>
<?php } ?>
<?php if ($encargado->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $encargado_grid->RowCnt ?>_encargado_estado" class="encargado_estado">
<span<?php echo $encargado->estado->ViewAttributes() ?>>
<?php echo $encargado->estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($encargado->estado->FormValue) ?>">
<input type="hidden" data-table="encargado" data-field="x_estado" name="o<?php echo $encargado_grid->RowIndex ?>_estado" id="o<?php echo $encargado_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($encargado->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$encargado_grid->ListOptions->Render("body", "right", $encargado_grid->RowCnt);
?>
	</tr>
<?php if ($encargado->RowType == EW_ROWTYPE_ADD || $encargado->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fencargadogrid.UpdateOpts(<?php echo $encargado_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($encargado->CurrentAction <> "gridadd" || $encargado->CurrentMode == "copy")
		if (!$encargado_grid->Recordset->EOF) $encargado_grid->Recordset->MoveNext();
}
?>
<?php
	if ($encargado->CurrentMode == "add" || $encargado->CurrentMode == "copy" || $encargado->CurrentMode == "edit") {
		$encargado_grid->RowIndex = '$rowindex$';
		$encargado_grid->LoadDefaultValues();

		// Set row properties
		$encargado->ResetAttrs();
		$encargado->RowAttrs = array_merge($encargado->RowAttrs, array('data-rowindex'=>$encargado_grid->RowIndex, 'id'=>'r0_encargado', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($encargado->RowAttrs["class"], "ewTemplate");
		$encargado->RowType = EW_ROWTYPE_ADD;

		// Render row
		$encargado_grid->RenderRow();

		// Render list options
		$encargado_grid->RenderListOptions();
		$encargado_grid->StartRowCnt = 0;
?>
	<tr<?php echo $encargado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$encargado_grid->ListOptions->Render("body", "left", $encargado_grid->RowIndex);
?>
	<?php if ($encargado->idempleado->Visible) { // idempleado ?>
		<td data-name="idempleado">
<?php if ($encargado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_encargado_idempleado" class="form-group encargado_idempleado">
<select data-table="encargado" data-field="x_idempleado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idempleado->DisplayValueSeparator) ? json_encode($encargado->idempleado->DisplayValueSeparator) : $encargado->idempleado->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idempleado" name="x<?php echo $encargado_grid->RowIndex ?>_idempleado"<?php echo $encargado->idempleado->EditAttributes() ?>>
<?php
if (is_array($encargado->idempleado->EditValue)) {
	$arwrk = $encargado->idempleado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idempleado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idempleado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idempleado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idempleado->CurrentValue) ?>" selected><?php echo $encargado->idempleado->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idempleado->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
$sWhereWrk = "";
$encargado->idempleado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idempleado->LookupFilters += array("f0" => "`idempleado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idempleado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idempleado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" id="s_x<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo $encargado->idempleado->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_encargado_idempleado" class="form-group encargado_idempleado">
<span<?php echo $encargado->idempleado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->idempleado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_idempleado" name="x<?php echo $encargado_grid->RowIndex ?>_idempleado" id="x<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($encargado->idempleado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_idempleado" name="o<?php echo $encargado_grid->RowIndex ?>_idempleado" id="o<?php echo $encargado_grid->RowIndex ?>_idempleado" value="<?php echo ew_HtmlEncode($encargado->idempleado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($encargado->tabla->Visible) { // tabla ?>
		<td data-name="tabla">
<?php if ($encargado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_encargado_tabla" class="form-group encargado_tabla">
<input type="text" data-table="encargado" data-field="x_tabla" name="x<?php echo $encargado_grid->RowIndex ?>_tabla" id="x<?php echo $encargado_grid->RowIndex ?>_tabla" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($encargado->tabla->getPlaceHolder()) ?>" value="<?php echo $encargado->tabla->EditValue ?>"<?php echo $encargado->tabla->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_encargado_tabla" class="form-group encargado_tabla">
<span<?php echo $encargado->tabla->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->tabla->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_tabla" name="x<?php echo $encargado_grid->RowIndex ?>_tabla" id="x<?php echo $encargado_grid->RowIndex ?>_tabla" value="<?php echo ew_HtmlEncode($encargado->tabla->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_tabla" name="o<?php echo $encargado_grid->RowIndex ?>_tabla" id="o<?php echo $encargado_grid->RowIndex ?>_tabla" value="<?php echo ew_HtmlEncode($encargado->tabla->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($encargado->idreferencia->Visible) { // idreferencia ?>
		<td data-name="idreferencia">
<?php if ($encargado->CurrentAction <> "F") { ?>
<?php if ($encargado->idreferencia->getSessionValue() <> "") { ?>
<span id="el$rowindex$_encargado_idreferencia" class="form-group encargado_idreferencia">
<span<?php echo $encargado->idreferencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->idreferencia->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_encargado_idreferencia" class="form-group encargado_idreferencia">
<select data-table="encargado" data-field="x_idreferencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->idreferencia->DisplayValueSeparator) ? json_encode($encargado->idreferencia->DisplayValueSeparator) : $encargado->idreferencia->DisplayValueSeparator) ?>" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia"<?php echo $encargado->idreferencia->EditAttributes() ?>>
<?php
if (is_array($encargado->idreferencia->EditValue)) {
	$arwrk = $encargado->idreferencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($encargado->idreferencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $encargado->idreferencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($encargado->idreferencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($encargado->idreferencia->CurrentValue) ?>" selected><?php echo $encargado->idreferencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $encargado->idreferencia->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$encargado->idreferencia->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$encargado->idreferencia->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$encargado->Lookup_Selecting($encargado->idreferencia, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $encargado->idreferencia->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="s_x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo $encargado->idreferencia->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_encargado_idreferencia" class="form-group encargado_idreferencia">
<span<?php echo $encargado->idreferencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->idreferencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_idreferencia" name="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="x<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_idreferencia" name="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" id="o<?php echo $encargado_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($encargado->idreferencia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($encargado->fecha_inicio->Visible) { // fecha_inicio ?>
		<td data-name="fecha_inicio">
<?php if ($encargado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_encargado_fecha_inicio" class="form-group encargado_fecha_inicio">
<input type="text" data-table="encargado" data-field="x_fecha_inicio" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_inicio->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_inicio->EditValue ?>"<?php echo $encargado->fecha_inicio->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_encargado_fecha_inicio" class="form-group encargado_fecha_inicio">
<span<?php echo $encargado->fecha_inicio->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->fecha_inicio->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_inicio" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($encargado->fecha_inicio->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_fecha_inicio" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_inicio" value="<?php echo ew_HtmlEncode($encargado->fecha_inicio->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($encargado->fecha_fin->Visible) { // fecha_fin ?>
		<td data-name="fecha_fin">
<?php if ($encargado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_encargado_fecha_fin" class="form-group encargado_fecha_fin">
<input type="text" data-table="encargado" data-field="x_fecha_fin" data-format="7" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" placeholder="<?php echo ew_HtmlEncode($encargado->fecha_fin->getPlaceHolder()) ?>" value="<?php echo $encargado->fecha_fin->EditValue ?>"<?php echo $encargado->fecha_fin->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_encargado_fecha_fin" class="form-group encargado_fecha_fin">
<span<?php echo $encargado->fecha_fin->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->fecha_fin->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_fecha_fin" name="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="x<?php echo $encargado_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($encargado->fecha_fin->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_fecha_fin" name="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" id="o<?php echo $encargado_grid->RowIndex ?>_fecha_fin" value="<?php echo ew_HtmlEncode($encargado->fecha_fin->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($encargado->estado->Visible) { // estado ?>
		<td data-name="estado">
<?php if ($encargado->CurrentAction <> "F") { ?>
<span id="el$rowindex$_encargado_estado" class="form-group encargado_estado">
<div id="tp_x<?php echo $encargado_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="encargado" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($encargado->estado->DisplayValueSeparator) ? json_encode($encargado->estado->DisplayValueSeparator) : $encargado->estado->DisplayValueSeparator) ?>" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado" value="{value}"<?php echo $encargado->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $encargado_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $encargado->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($encargado->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($encargado->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($encargado->estado->CurrentValue) ?>" checked<?php echo $encargado->estado->EditAttributes() ?>><?php echo $encargado->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $encargado->estado->OldValue = "";
?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_encargado_estado" class="form-group encargado_estado">
<span<?php echo $encargado->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $encargado->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="encargado" data-field="x_estado" name="x<?php echo $encargado_grid->RowIndex ?>_estado" id="x<?php echo $encargado_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($encargado->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="encargado" data-field="x_estado" name="o<?php echo $encargado_grid->RowIndex ?>_estado" id="o<?php echo $encargado_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($encargado->estado->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$encargado_grid->ListOptions->Render("body", "right", $encargado_grid->RowCnt);
?>
<script type="text/javascript">
fencargadogrid.UpdateOpts(<?php echo $encargado_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($encargado->CurrentMode == "add" || $encargado->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $encargado_grid->FormKeyCountName ?>" id="<?php echo $encargado_grid->FormKeyCountName ?>" value="<?php echo $encargado_grid->KeyCount ?>">
<?php echo $encargado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($encargado->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $encargado_grid->FormKeyCountName ?>" id="<?php echo $encargado_grid->FormKeyCountName ?>" value="<?php echo $encargado_grid->KeyCount ?>">
<?php echo $encargado_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($encargado->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fencargadogrid">
</div>
<?php

// Close recordset
if ($encargado_grid->Recordset)
	$encargado_grid->Recordset->Close();
?>
<?php if ($encargado_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($encargado_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($encargado_grid->TotalRecs == 0 && $encargado->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($encargado_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($encargado->Export == "") { ?>
<script type="text/javascript">
fencargadogrid.Init();
</script>
<?php } ?>
<?php
$encargado_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$encargado_grid->Page_Terminate();
?>
