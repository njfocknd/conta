<?php

// Create page object
if (!isset($subcuenta_grid)) $subcuenta_grid = new csubcuenta_grid();

// Page init
$subcuenta_grid->Page_Init();

// Page main
$subcuenta_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subcuenta_grid->Page_Render();
?>
<?php if ($subcuenta->Export == "") { ?>
<script type="text/javascript">

// Form object
var fsubcuentagrid = new ew_Form("fsubcuentagrid", "grid");
fsubcuentagrid.FormKeyCountName = '<?php echo $subcuenta_grid->FormKeyCountName ?>';

// Validate form
fsubcuentagrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nomenclatura->FldCaption(), $subcuenta->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nombre->FldCaption(), $subcuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->idcuenta_mayor_auxiliar->FldCaption(), $subcuenta->idcuenta_mayor_auxiliar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($subcuenta->idcuenta_mayor_auxiliar->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fsubcuentagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_auxiliar", false)) return false;
	return true;
}

// Form_CustomValidate event
fsubcuentagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubcuentagrid.ValidateRequired = true;
<?php } else { ?>
fsubcuentagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($subcuenta->CurrentAction == "gridadd") {
	if ($subcuenta->CurrentMode == "copy") {
		$bSelectLimit = $subcuenta_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$subcuenta_grid->TotalRecs = $subcuenta->SelectRecordCount();
			$subcuenta_grid->Recordset = $subcuenta_grid->LoadRecordset($subcuenta_grid->StartRec-1, $subcuenta_grid->DisplayRecs);
		} else {
			if ($subcuenta_grid->Recordset = $subcuenta_grid->LoadRecordset())
				$subcuenta_grid->TotalRecs = $subcuenta_grid->Recordset->RecordCount();
		}
		$subcuenta_grid->StartRec = 1;
		$subcuenta_grid->DisplayRecs = $subcuenta_grid->TotalRecs;
	} else {
		$subcuenta->CurrentFilter = "0=1";
		$subcuenta_grid->StartRec = 1;
		$subcuenta_grid->DisplayRecs = $subcuenta->GridAddRowCount;
	}
	$subcuenta_grid->TotalRecs = $subcuenta_grid->DisplayRecs;
	$subcuenta_grid->StopRec = $subcuenta_grid->DisplayRecs;
} else {
	$bSelectLimit = $subcuenta_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($subcuenta_grid->TotalRecs <= 0)
			$subcuenta_grid->TotalRecs = $subcuenta->SelectRecordCount();
	} else {
		if (!$subcuenta_grid->Recordset && ($subcuenta_grid->Recordset = $subcuenta_grid->LoadRecordset()))
			$subcuenta_grid->TotalRecs = $subcuenta_grid->Recordset->RecordCount();
	}
	$subcuenta_grid->StartRec = 1;
	$subcuenta_grid->DisplayRecs = $subcuenta_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$subcuenta_grid->Recordset = $subcuenta_grid->LoadRecordset($subcuenta_grid->StartRec-1, $subcuenta_grid->DisplayRecs);

	// Set no record found message
	if ($subcuenta->CurrentAction == "" && $subcuenta_grid->TotalRecs == 0) {
		if ($subcuenta_grid->SearchWhere == "0=101")
			$subcuenta_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$subcuenta_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$subcuenta_grid->RenderOtherOptions();
?>
<?php $subcuenta_grid->ShowPageHeader(); ?>
<?php
$subcuenta_grid->ShowMessage();
?>
<?php if ($subcuenta_grid->TotalRecs > 0 || $subcuenta->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fsubcuentagrid" class="ewForm form-inline">
<?php if ($subcuenta_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($subcuenta_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_subcuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_subcuentagrid" class="table ewTable">
<?php echo $subcuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$subcuenta_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$subcuenta_grid->RenderListOptions();

// Render list options (header, left)
$subcuenta_grid->ListOptions->Render("header", "left");
?>
<?php if ($subcuenta->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($subcuenta->SortUrl($subcuenta->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_subcuenta_nomenclatura" class="subcuenta_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $subcuenta->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div><div id="elh_subcuenta_nomenclatura" class="subcuenta_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subcuenta->nombre->Visible) { // nombre ?>
	<?php if ($subcuenta->SortUrl($subcuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_subcuenta_nombre" class="subcuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $subcuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_subcuenta_nombre" class="subcuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
	<?php if ($subcuenta->SortUrl($subcuenta->idcuenta_mayor_auxiliar) == "") { ?>
		<th data-name="idcuenta_mayor_auxiliar"><div id="elh_subcuenta_idcuenta_mayor_auxiliar" class="subcuenta_idcuenta_mayor_auxiliar"><div class="ewTableHeaderCaption"><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_auxiliar"><div><div id="elh_subcuenta_idcuenta_mayor_auxiliar" class="subcuenta_idcuenta_mayor_auxiliar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->idcuenta_mayor_auxiliar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->idcuenta_mayor_auxiliar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$subcuenta_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$subcuenta_grid->StartRec = 1;
$subcuenta_grid->StopRec = $subcuenta_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($subcuenta_grid->FormKeyCountName) && ($subcuenta->CurrentAction == "gridadd" || $subcuenta->CurrentAction == "gridedit" || $subcuenta->CurrentAction == "F")) {
		$subcuenta_grid->KeyCount = $objForm->GetValue($subcuenta_grid->FormKeyCountName);
		$subcuenta_grid->StopRec = $subcuenta_grid->StartRec + $subcuenta_grid->KeyCount - 1;
	}
}
$subcuenta_grid->RecCnt = $subcuenta_grid->StartRec - 1;
if ($subcuenta_grid->Recordset && !$subcuenta_grid->Recordset->EOF) {
	$subcuenta_grid->Recordset->MoveFirst();
	$bSelectLimit = $subcuenta_grid->UseSelectLimit;
	if (!$bSelectLimit && $subcuenta_grid->StartRec > 1)
		$subcuenta_grid->Recordset->Move($subcuenta_grid->StartRec - 1);
} elseif (!$subcuenta->AllowAddDeleteRow && $subcuenta_grid->StopRec == 0) {
	$subcuenta_grid->StopRec = $subcuenta->GridAddRowCount;
}

// Initialize aggregate
$subcuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$subcuenta->ResetAttrs();
$subcuenta_grid->RenderRow();
if ($subcuenta->CurrentAction == "gridadd")
	$subcuenta_grid->RowIndex = 0;
if ($subcuenta->CurrentAction == "gridedit")
	$subcuenta_grid->RowIndex = 0;
while ($subcuenta_grid->RecCnt < $subcuenta_grid->StopRec) {
	$subcuenta_grid->RecCnt++;
	if (intval($subcuenta_grid->RecCnt) >= intval($subcuenta_grid->StartRec)) {
		$subcuenta_grid->RowCnt++;
		if ($subcuenta->CurrentAction == "gridadd" || $subcuenta->CurrentAction == "gridedit" || $subcuenta->CurrentAction == "F") {
			$subcuenta_grid->RowIndex++;
			$objForm->Index = $subcuenta_grid->RowIndex;
			if ($objForm->HasValue($subcuenta_grid->FormActionName))
				$subcuenta_grid->RowAction = strval($objForm->GetValue($subcuenta_grid->FormActionName));
			elseif ($subcuenta->CurrentAction == "gridadd")
				$subcuenta_grid->RowAction = "insert";
			else
				$subcuenta_grid->RowAction = "";
		}

		// Set up key count
		$subcuenta_grid->KeyCount = $subcuenta_grid->RowIndex;

		// Init row class and style
		$subcuenta->ResetAttrs();
		$subcuenta->CssClass = "";
		if ($subcuenta->CurrentAction == "gridadd") {
			if ($subcuenta->CurrentMode == "copy") {
				$subcuenta_grid->LoadRowValues($subcuenta_grid->Recordset); // Load row values
				$subcuenta_grid->SetRecordKey($subcuenta_grid->RowOldKey, $subcuenta_grid->Recordset); // Set old record key
			} else {
				$subcuenta_grid->LoadDefaultValues(); // Load default values
				$subcuenta_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$subcuenta_grid->LoadRowValues($subcuenta_grid->Recordset); // Load row values
		}
		$subcuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($subcuenta->CurrentAction == "gridadd") // Grid add
			$subcuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($subcuenta->CurrentAction == "gridadd" && $subcuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$subcuenta_grid->RestoreCurrentRowFormValues($subcuenta_grid->RowIndex); // Restore form values
		if ($subcuenta->CurrentAction == "gridedit") { // Grid edit
			if ($subcuenta->EventCancelled) {
				$subcuenta_grid->RestoreCurrentRowFormValues($subcuenta_grid->RowIndex); // Restore form values
			}
			if ($subcuenta_grid->RowAction == "insert")
				$subcuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$subcuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($subcuenta->CurrentAction == "gridedit" && ($subcuenta->RowType == EW_ROWTYPE_EDIT || $subcuenta->RowType == EW_ROWTYPE_ADD) && $subcuenta->EventCancelled) // Update failed
			$subcuenta_grid->RestoreCurrentRowFormValues($subcuenta_grid->RowIndex); // Restore form values
		if ($subcuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$subcuenta_grid->EditRowCnt++;
		if ($subcuenta->CurrentAction == "F") // Confirm row
			$subcuenta_grid->RestoreCurrentRowFormValues($subcuenta_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$subcuenta->RowAttrs = array_merge($subcuenta->RowAttrs, array('data-rowindex'=>$subcuenta_grid->RowCnt, 'id'=>'r' . $subcuenta_grid->RowCnt . '_subcuenta', 'data-rowtype'=>$subcuenta->RowType));

		// Render row
		$subcuenta_grid->RenderRow();

		// Render list options
		$subcuenta_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($subcuenta_grid->RowAction <> "delete" && $subcuenta_grid->RowAction <> "insertdelete" && !($subcuenta_grid->RowAction == "insert" && $subcuenta->CurrentAction == "F" && $subcuenta_grid->EmptyRow())) {
?>
	<tr<?php echo $subcuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subcuenta_grid->ListOptions->Render("body", "left", $subcuenta_grid->RowCnt);
?>
	<?php if ($subcuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $subcuenta->nomenclatura->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nomenclatura" class="form-group subcuenta_nomenclatura">
<input type="text" data-table="subcuenta" data-field="x_nomenclatura" name="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nomenclatura->EditValue ?>"<?php echo $subcuenta->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nomenclatura" name="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nomenclatura" class="form-group subcuenta_nomenclatura">
<input type="text" data-table="subcuenta" data-field="x_nomenclatura" name="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nomenclatura->EditValue ?>"<?php echo $subcuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nomenclatura" class="subcuenta_nomenclatura">
<span<?php echo $subcuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $subcuenta->nomenclatura->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nomenclatura" name="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->FormValue) ?>">
<input type="hidden" data-table="subcuenta" data-field="x_nomenclatura" name="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<a id="<?php echo $subcuenta_grid->PageObjName . "_row_" . $subcuenta_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="subcuenta" data-field="x_idsubcuenta" name="x<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" id="x<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->CurrentValue) ?>">
<input type="hidden" data-table="subcuenta" data-field="x_idsubcuenta" name="o<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" id="o<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT || $subcuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-table="subcuenta" data-field="x_idsubcuenta" name="x<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" id="x<?php echo $subcuenta_grid->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($subcuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $subcuenta->nombre->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-table="subcuenta" data-field="x_nombre" name="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nombre" name="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-table="subcuenta" data-field="x_nombre" name="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_nombre" class="subcuenta_nombre">
<span<?php echo $subcuenta->nombre->ViewAttributes() ?>>
<?php echo $subcuenta->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nombre" name="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->FormValue) ?>">
<input type="hidden" data-table="subcuenta" data-field="x_nombre" name="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
		<td data-name="idcuenta_mayor_auxiliar"<?php echo $subcuenta->idcuenta_mayor_auxiliar->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->getPlaceHolder()) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->getPlaceHolder()) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subcuenta_grid->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<?php echo $subcuenta->idcuenta_mayor_auxiliar->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->FormValue) ?>">
<input type="hidden" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subcuenta_grid->ListOptions->Render("body", "right", $subcuenta_grid->RowCnt);
?>
	</tr>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD || $subcuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsubcuentagrid.UpdateOpts(<?php echo $subcuenta_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($subcuenta->CurrentAction <> "gridadd" || $subcuenta->CurrentMode == "copy")
		if (!$subcuenta_grid->Recordset->EOF) $subcuenta_grid->Recordset->MoveNext();
}
?>
<?php
	if ($subcuenta->CurrentMode == "add" || $subcuenta->CurrentMode == "copy" || $subcuenta->CurrentMode == "edit") {
		$subcuenta_grid->RowIndex = '$rowindex$';
		$subcuenta_grid->LoadDefaultValues();

		// Set row properties
		$subcuenta->ResetAttrs();
		$subcuenta->RowAttrs = array_merge($subcuenta->RowAttrs, array('data-rowindex'=>$subcuenta_grid->RowIndex, 'id'=>'r0_subcuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($subcuenta->RowAttrs["class"], "ewTemplate");
		$subcuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$subcuenta_grid->RenderRow();

		// Render list options
		$subcuenta_grid->RenderListOptions();
		$subcuenta_grid->StartRowCnt = 0;
?>
	<tr<?php echo $subcuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subcuenta_grid->ListOptions->Render("body", "left", $subcuenta_grid->RowIndex);
?>
	<?php if ($subcuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<?php if ($subcuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_subcuenta_nomenclatura" class="form-group subcuenta_nomenclatura">
<input type="text" data-table="subcuenta" data-field="x_nomenclatura" name="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nomenclatura->EditValue ?>"<?php echo $subcuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_subcuenta_nomenclatura" class="form-group subcuenta_nomenclatura">
<span<?php echo $subcuenta->nomenclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->nomenclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nomenclatura" name="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="x<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcuenta" data-field="x_nomenclatura" name="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" id="o<?php echo $subcuenta_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subcuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($subcuenta->CurrentAction <> "F") { ?>
<span id="el$rowindex$_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-table="subcuenta" data-field="x_nombre" name="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_subcuenta_nombre" class="form-group subcuenta_nombre">
<span<?php echo $subcuenta->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_nombre" name="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="x<?php echo $subcuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcuenta" data-field="x_nombre" name="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" id="o<?php echo $subcuenta_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
		<td data-name="idcuenta_mayor_auxiliar">
<?php if ($subcuenta->CurrentAction <> "F") { ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el$rowindex$_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->getPlaceHolder()) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="subcuenta" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $subcuenta_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subcuenta_grid->ListOptions->Render("body", "right", $subcuenta_grid->RowCnt);
?>
<script type="text/javascript">
fsubcuentagrid.UpdateOpts(<?php echo $subcuenta_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($subcuenta->CurrentMode == "add" || $subcuenta->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $subcuenta_grid->FormKeyCountName ?>" id="<?php echo $subcuenta_grid->FormKeyCountName ?>" value="<?php echo $subcuenta_grid->KeyCount ?>">
<?php echo $subcuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($subcuenta->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $subcuenta_grid->FormKeyCountName ?>" id="<?php echo $subcuenta_grid->FormKeyCountName ?>" value="<?php echo $subcuenta_grid->KeyCount ?>">
<?php echo $subcuenta_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($subcuenta->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsubcuentagrid">
</div>
<?php

// Close recordset
if ($subcuenta_grid->Recordset)
	$subcuenta_grid->Recordset->Close();
?>
<?php if ($subcuenta_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($subcuenta_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($subcuenta_grid->TotalRecs == 0 && $subcuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subcuenta_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($subcuenta->Export == "") { ?>
<script type="text/javascript">
fsubcuentagrid.Init();
</script>
<?php } ?>
<?php
$subcuenta_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$subcuenta_grid->Page_Terminate();
?>
