<?php

// Create page object
if (!isset($caja_chica_detalle_grid)) $caja_chica_detalle_grid = new ccaja_chica_detalle_grid();

// Page init
$caja_chica_detalle_grid->Page_Init();

// Page main
$caja_chica_detalle_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_detalle_grid->Page_Render();
?>
<?php if ($caja_chica_detalle->Export == "") { ?>
<script type="text/javascript">

// Page object
var caja_chica_detalle_grid = new ew_Page("caja_chica_detalle_grid");
caja_chica_detalle_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = caja_chica_detalle_grid.PageID; // For backward compatibility

// Form object
var fcaja_chica_detallegrid = new ew_Form("fcaja_chica_detallegrid");
fcaja_chica_detallegrid.FormKeyCountName = '<?php echo $caja_chica_detalle_grid->FormKeyCountName ?>';

// Validate form
fcaja_chica_detallegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_detalle->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_detalle->monto->FldCaption(), $caja_chica_detalle->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_detalle->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_detalle->tipo->FldCaption(), $caja_chica_detalle->tipo->ReqErrMsg)) ?>");

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
fcaja_chica_detallegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tipo", false)) return false;
	return true;
}

// Form_CustomValidate event
fcaja_chica_detallegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_detallegrid.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_detallegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($caja_chica_detalle->CurrentAction == "gridadd") {
	if ($caja_chica_detalle->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$caja_chica_detalle_grid->TotalRecs = $caja_chica_detalle->SelectRecordCount();
			$caja_chica_detalle_grid->Recordset = $caja_chica_detalle_grid->LoadRecordset($caja_chica_detalle_grid->StartRec-1, $caja_chica_detalle_grid->DisplayRecs);
		} else {
			if ($caja_chica_detalle_grid->Recordset = $caja_chica_detalle_grid->LoadRecordset())
				$caja_chica_detalle_grid->TotalRecs = $caja_chica_detalle_grid->Recordset->RecordCount();
		}
		$caja_chica_detalle_grid->StartRec = 1;
		$caja_chica_detalle_grid->DisplayRecs = $caja_chica_detalle_grid->TotalRecs;
	} else {
		$caja_chica_detalle->CurrentFilter = "0=1";
		$caja_chica_detalle_grid->StartRec = 1;
		$caja_chica_detalle_grid->DisplayRecs = $caja_chica_detalle->GridAddRowCount;
	}
	$caja_chica_detalle_grid->TotalRecs = $caja_chica_detalle_grid->DisplayRecs;
	$caja_chica_detalle_grid->StopRec = $caja_chica_detalle_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$caja_chica_detalle_grid->TotalRecs = $caja_chica_detalle->SelectRecordCount();
	} else {
		if ($caja_chica_detalle_grid->Recordset = $caja_chica_detalle_grid->LoadRecordset())
			$caja_chica_detalle_grid->TotalRecs = $caja_chica_detalle_grid->Recordset->RecordCount();
	}
	$caja_chica_detalle_grid->StartRec = 1;
	$caja_chica_detalle_grid->DisplayRecs = $caja_chica_detalle_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$caja_chica_detalle_grid->Recordset = $caja_chica_detalle_grid->LoadRecordset($caja_chica_detalle_grid->StartRec-1, $caja_chica_detalle_grid->DisplayRecs);

	// Set no record found message
	if ($caja_chica_detalle->CurrentAction == "" && $caja_chica_detalle_grid->TotalRecs == 0) {
		if ($caja_chica_detalle_grid->SearchWhere == "0=101")
			$caja_chica_detalle_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$caja_chica_detalle_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$caja_chica_detalle_grid->RenderOtherOptions();
?>
<?php $caja_chica_detalle_grid->ShowPageHeader(); ?>
<?php
$caja_chica_detalle_grid->ShowMessage();
?>
<?php if ($caja_chica_detalle_grid->TotalRecs > 0 || $caja_chica_detalle->CurrentAction <> "") { ?>
<div class="ewGrid">
<div id="fcaja_chica_detallegrid" class="ewForm form-inline">
<div id="gmp_caja_chica_detalle" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_caja_chica_detallegrid" class="table ewTable">
<?php echo $caja_chica_detalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$caja_chica_detalle_grid->RenderListOptions();

// Render list options (header, left)
$caja_chica_detalle_grid->ListOptions->Render("header", "left");
?>
<?php if ($caja_chica_detalle->fecha->Visible) { // fecha ?>
	<?php if ($caja_chica_detalle->SortUrl($caja_chica_detalle->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_caja_chica_detalle_fecha" class="caja_chica_detalle_fecha"><div class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_caja_chica_detalle_fecha" class="caja_chica_detalle_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_detalle->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_detalle->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_detalle->monto->Visible) { // monto ?>
	<?php if ($caja_chica_detalle->SortUrl($caja_chica_detalle->monto) == "") { ?>
		<th data-name="monto"><div id="elh_caja_chica_detalle_monto" class="caja_chica_detalle_monto"><div class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_caja_chica_detalle_monto" class="caja_chica_detalle_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_detalle->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_detalle->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_detalle->tipo->Visible) { // tipo ?>
	<?php if ($caja_chica_detalle->SortUrl($caja_chica_detalle->tipo) == "") { ?>
		<th data-name="tipo"><div id="elh_caja_chica_detalle_tipo" class="caja_chica_detalle_tipo"><div class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->tipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo"><div><div id="elh_caja_chica_detalle_tipo" class="caja_chica_detalle_tipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_detalle->tipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_detalle->tipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_detalle->tipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$caja_chica_detalle_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$caja_chica_detalle_grid->StartRec = 1;
$caja_chica_detalle_grid->StopRec = $caja_chica_detalle_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($caja_chica_detalle_grid->FormKeyCountName) && ($caja_chica_detalle->CurrentAction == "gridadd" || $caja_chica_detalle->CurrentAction == "gridedit" || $caja_chica_detalle->CurrentAction == "F")) {
		$caja_chica_detalle_grid->KeyCount = $objForm->GetValue($caja_chica_detalle_grid->FormKeyCountName);
		$caja_chica_detalle_grid->StopRec = $caja_chica_detalle_grid->StartRec + $caja_chica_detalle_grid->KeyCount - 1;
	}
}
$caja_chica_detalle_grid->RecCnt = $caja_chica_detalle_grid->StartRec - 1;
if ($caja_chica_detalle_grid->Recordset && !$caja_chica_detalle_grid->Recordset->EOF) {
	$caja_chica_detalle_grid->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $caja_chica_detalle_grid->StartRec > 1)
		$caja_chica_detalle_grid->Recordset->Move($caja_chica_detalle_grid->StartRec - 1);
} elseif (!$caja_chica_detalle->AllowAddDeleteRow && $caja_chica_detalle_grid->StopRec == 0) {
	$caja_chica_detalle_grid->StopRec = $caja_chica_detalle->GridAddRowCount;
}

// Initialize aggregate
$caja_chica_detalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$caja_chica_detalle->ResetAttrs();
$caja_chica_detalle_grid->RenderRow();
if ($caja_chica_detalle->CurrentAction == "gridadd")
	$caja_chica_detalle_grid->RowIndex = 0;
if ($caja_chica_detalle->CurrentAction == "gridedit")
	$caja_chica_detalle_grid->RowIndex = 0;
while ($caja_chica_detalle_grid->RecCnt < $caja_chica_detalle_grid->StopRec) {
	$caja_chica_detalle_grid->RecCnt++;
	if (intval($caja_chica_detalle_grid->RecCnt) >= intval($caja_chica_detalle_grid->StartRec)) {
		$caja_chica_detalle_grid->RowCnt++;
		if ($caja_chica_detalle->CurrentAction == "gridadd" || $caja_chica_detalle->CurrentAction == "gridedit" || $caja_chica_detalle->CurrentAction == "F") {
			$caja_chica_detalle_grid->RowIndex++;
			$objForm->Index = $caja_chica_detalle_grid->RowIndex;
			if ($objForm->HasValue($caja_chica_detalle_grid->FormActionName))
				$caja_chica_detalle_grid->RowAction = strval($objForm->GetValue($caja_chica_detalle_grid->FormActionName));
			elseif ($caja_chica_detalle->CurrentAction == "gridadd")
				$caja_chica_detalle_grid->RowAction = "insert";
			else
				$caja_chica_detalle_grid->RowAction = "";
		}

		// Set up key count
		$caja_chica_detalle_grid->KeyCount = $caja_chica_detalle_grid->RowIndex;

		// Init row class and style
		$caja_chica_detalle->ResetAttrs();
		$caja_chica_detalle->CssClass = "";
		if ($caja_chica_detalle->CurrentAction == "gridadd") {
			if ($caja_chica_detalle->CurrentMode == "copy") {
				$caja_chica_detalle_grid->LoadRowValues($caja_chica_detalle_grid->Recordset); // Load row values
				$caja_chica_detalle_grid->SetRecordKey($caja_chica_detalle_grid->RowOldKey, $caja_chica_detalle_grid->Recordset); // Set old record key
			} else {
				$caja_chica_detalle_grid->LoadDefaultValues(); // Load default values
				$caja_chica_detalle_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$caja_chica_detalle_grid->LoadRowValues($caja_chica_detalle_grid->Recordset); // Load row values
		}
		$caja_chica_detalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($caja_chica_detalle->CurrentAction == "gridadd") // Grid add
			$caja_chica_detalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($caja_chica_detalle->CurrentAction == "gridadd" && $caja_chica_detalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$caja_chica_detalle_grid->RestoreCurrentRowFormValues($caja_chica_detalle_grid->RowIndex); // Restore form values
		if ($caja_chica_detalle->CurrentAction == "gridedit") { // Grid edit
			if ($caja_chica_detalle->EventCancelled) {
				$caja_chica_detalle_grid->RestoreCurrentRowFormValues($caja_chica_detalle_grid->RowIndex); // Restore form values
			}
			if ($caja_chica_detalle_grid->RowAction == "insert")
				$caja_chica_detalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$caja_chica_detalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($caja_chica_detalle->CurrentAction == "gridedit" && ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT || $caja_chica_detalle->RowType == EW_ROWTYPE_ADD) && $caja_chica_detalle->EventCancelled) // Update failed
			$caja_chica_detalle_grid->RestoreCurrentRowFormValues($caja_chica_detalle_grid->RowIndex); // Restore form values
		if ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$caja_chica_detalle_grid->EditRowCnt++;
		if ($caja_chica_detalle->CurrentAction == "F") // Confirm row
			$caja_chica_detalle_grid->RestoreCurrentRowFormValues($caja_chica_detalle_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$caja_chica_detalle->RowAttrs = array_merge($caja_chica_detalle->RowAttrs, array('data-rowindex'=>$caja_chica_detalle_grid->RowCnt, 'id'=>'r' . $caja_chica_detalle_grid->RowCnt . '_caja_chica_detalle', 'data-rowtype'=>$caja_chica_detalle->RowType));

		// Render row
		$caja_chica_detalle_grid->RenderRow();

		// Render list options
		$caja_chica_detalle_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($caja_chica_detalle_grid->RowAction <> "delete" && $caja_chica_detalle_grid->RowAction <> "insertdelete" && !($caja_chica_detalle_grid->RowAction == "insert" && $caja_chica_detalle->CurrentAction == "F" && $caja_chica_detalle_grid->EmptyRow())) {
?>
	<tr<?php echo $caja_chica_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_detalle_grid->ListOptions->Render("body", "left", $caja_chica_detalle_grid->RowCnt);
?>
	<?php if ($caja_chica_detalle->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $caja_chica_detalle->fecha->CellAttributes() ?>>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_fecha" class="form-group caja_chica_detalle_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->fecha->EditValue ?>"<?php echo $caja_chica_detalle->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_detalle->fecha->ReadOnly && !$caja_chica_detalle->fecha->Disabled && @$caja_chica_detalle->fecha->EditAttrs["readonly"] == "" && @$caja_chica_detalle->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_detallegrid", "x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-field="x_fecha" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_fecha" class="form-group caja_chica_detalle_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->fecha->EditValue ?>"<?php echo $caja_chica_detalle->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_detalle->fecha->ReadOnly && !$caja_chica_detalle->fecha->Disabled && @$caja_chica_detalle->fecha->EditAttrs["readonly"] == "" && @$caja_chica_detalle->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_detallegrid", "x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $caja_chica_detalle->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->fecha->ListViewValue() ?></span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->FormValue) ?>">
<input type="hidden" data-field="x_fecha" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->OldValue) ?>">
<?php } ?>
<a id="<?php echo $caja_chica_detalle_grid->PageObjName . "_row_" . $caja_chica_detalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_detalle->idcaja_chica_detalle->CurrentValue) ?>">
<input type="hidden" data-field="x_idcaja_chica_detalle" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_detalle->idcaja_chica_detalle->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT || $caja_chica_detalle->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_detalle->idcaja_chica_detalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($caja_chica_detalle->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $caja_chica_detalle->monto->CellAttributes() ?>>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_monto" class="form-group caja_chica_detalle_monto">
<input type="text" data-field="x_monto" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->monto->EditValue ?>"<?php echo $caja_chica_detalle->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_monto" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_monto" class="form-group caja_chica_detalle_monto">
<input type="text" data-field="x_monto" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->monto->EditValue ?>"<?php echo $caja_chica_detalle->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $caja_chica_detalle->monto->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->monto->ListViewValue() ?></span>
<input type="hidden" data-field="x_monto" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->FormValue) ?>">
<input type="hidden" data-field="x_monto" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_detalle->tipo->Visible) { // tipo ?>
		<td data-name="tipo"<?php echo $caja_chica_detalle->tipo->CellAttributes() ?>>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_tipo" class="form-group caja_chica_detalle_tipo">
<select data-field="x_tipo" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo"<?php echo $caja_chica_detalle->tipo->EditAttributes() ?>>
<?php
if (is_array($caja_chica_detalle->tipo->EditValue)) {
	$arwrk = $caja_chica_detalle->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_detalle->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $caja_chica_detalle->tipo->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-field="x_tipo" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($caja_chica_detalle->tipo->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_detalle_grid->RowCnt ?>_caja_chica_detalle_tipo" class="form-group caja_chica_detalle_tipo">
<select data-field="x_tipo" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo"<?php echo $caja_chica_detalle->tipo->EditAttributes() ?>>
<?php
if (is_array($caja_chica_detalle->tipo->EditValue)) {
	$arwrk = $caja_chica_detalle->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_detalle->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $caja_chica_detalle->tipo->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $caja_chica_detalle->tipo->ViewAttributes() ?>>
<?php echo $caja_chica_detalle->tipo->ListViewValue() ?></span>
<input type="hidden" data-field="x_tipo" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($caja_chica_detalle->tipo->FormValue) ?>">
<input type="hidden" data-field="x_tipo" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($caja_chica_detalle->tipo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_detalle_grid->ListOptions->Render("body", "right", $caja_chica_detalle_grid->RowCnt);
?>
	</tr>
<?php if ($caja_chica_detalle->RowType == EW_ROWTYPE_ADD || $caja_chica_detalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcaja_chica_detallegrid.UpdateOpts(<?php echo $caja_chica_detalle_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($caja_chica_detalle->CurrentAction <> "gridadd" || $caja_chica_detalle->CurrentMode == "copy")
		if (!$caja_chica_detalle_grid->Recordset->EOF) $caja_chica_detalle_grid->Recordset->MoveNext();
}
?>
<?php
	if ($caja_chica_detalle->CurrentMode == "add" || $caja_chica_detalle->CurrentMode == "copy" || $caja_chica_detalle->CurrentMode == "edit") {
		$caja_chica_detalle_grid->RowIndex = '$rowindex$';
		$caja_chica_detalle_grid->LoadDefaultValues();

		// Set row properties
		$caja_chica_detalle->ResetAttrs();
		$caja_chica_detalle->RowAttrs = array_merge($caja_chica_detalle->RowAttrs, array('data-rowindex'=>$caja_chica_detalle_grid->RowIndex, 'id'=>'r0_caja_chica_detalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($caja_chica_detalle->RowAttrs["class"], "ewTemplate");
		$caja_chica_detalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$caja_chica_detalle_grid->RenderRow();

		// Render list options
		$caja_chica_detalle_grid->RenderListOptions();
		$caja_chica_detalle_grid->StartRowCnt = 0;
?>
	<tr<?php echo $caja_chica_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_detalle_grid->ListOptions->Render("body", "left", $caja_chica_detalle_grid->RowIndex);
?>
	<?php if ($caja_chica_detalle->fecha->Visible) { // fecha ?>
		<td>
<?php if ($caja_chica_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_detalle_fecha" class="form-group caja_chica_detalle_fecha">
<input type="text" data-field="x_fecha" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->fecha->EditValue ?>"<?php echo $caja_chica_detalle->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_detalle->fecha->ReadOnly && !$caja_chica_detalle->fecha->Disabled && @$caja_chica_detalle->fecha->EditAttrs["readonly"] == "" && @$caja_chica_detalle->fecha->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_detallegrid", "x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_detalle_fecha" class="form-group caja_chica_detalle_fecha">
<span<?php echo $caja_chica_detalle->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_detalle->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_fecha" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_fecha" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_detalle->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_detalle->monto->Visible) { // monto ?>
		<td>
<?php if ($caja_chica_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_detalle_monto" class="form-group caja_chica_detalle_monto">
<input type="text" data-field="x_monto" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->PlaceHolder) ?>" value="<?php echo $caja_chica_detalle->monto->EditValue ?>"<?php echo $caja_chica_detalle->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_detalle_monto" class="form-group caja_chica_detalle_monto">
<span<?php echo $caja_chica_detalle->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_detalle->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_monto" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_monto" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_detalle->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_detalle->tipo->Visible) { // tipo ?>
		<td>
<?php if ($caja_chica_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_detalle_tipo" class="form-group caja_chica_detalle_tipo">
<select data-field="x_tipo" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo"<?php echo $caja_chica_detalle->tipo->EditAttributes() ?>>
<?php
if (is_array($caja_chica_detalle->tipo->EditValue)) {
	$arwrk = $caja_chica_detalle->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_detalle->tipo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $caja_chica_detalle->tipo->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_detalle_tipo" class="form-group caja_chica_detalle_tipo">
<span<?php echo $caja_chica_detalle->tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_detalle->tipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_tipo" name="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" id="x<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($caja_chica_detalle->tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_tipo" name="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" id="o<?php echo $caja_chica_detalle_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($caja_chica_detalle->tipo->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_detalle_grid->ListOptions->Render("body", "right", $caja_chica_detalle_grid->RowCnt);
?>
<script type="text/javascript">
fcaja_chica_detallegrid.UpdateOpts(<?php echo $caja_chica_detalle_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($caja_chica_detalle->CurrentMode == "add" || $caja_chica_detalle->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $caja_chica_detalle_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_detalle_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_detalle_grid->KeyCount ?>">
<?php echo $caja_chica_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_detalle->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $caja_chica_detalle_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_detalle_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_detalle_grid->KeyCount ?>">
<?php echo $caja_chica_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_detalle->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcaja_chica_detallegrid">
</div>
<?php

// Close recordset
if ($caja_chica_detalle_grid->Recordset)
	$caja_chica_detalle_grid->Recordset->Close();
?>
<?php if ($caja_chica_detalle_grid->ShowOtherOptions) { ?>
<div class="ewGridLowerPanel">
<?php
	foreach ($caja_chica_detalle_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($caja_chica_detalle_grid->TotalRecs == 0 && $caja_chica_detalle->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($caja_chica_detalle_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($caja_chica_detalle->Export == "") { ?>
<script type="text/javascript">
fcaja_chica_detallegrid.Init();
</script>
<?php } ?>
<?php
$caja_chica_detalle_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$caja_chica_detalle_grid->Page_Terminate();
?>
