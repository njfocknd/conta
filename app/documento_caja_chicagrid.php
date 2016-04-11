<?php

// Create page object
if (!isset($documento_caja_chica_grid)) $documento_caja_chica_grid = new cdocumento_caja_chica_grid();

// Page init
$documento_caja_chica_grid->Page_Init();

// Page main
$documento_caja_chica_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_caja_chica_grid->Page_Render();
?>
<?php if ($documento_caja_chica->Export == "") { ?>
<script type="text/javascript">

// Form object
var fdocumento_caja_chicagrid = new ew_Form("fdocumento_caja_chicagrid", "grid");
fdocumento_caja_chicagrid.FormKeyCountName = '<?php echo $documento_caja_chica_grid->FormKeyCountName ?>';

// Validate form
fdocumento_caja_chicagrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->tipo->FldCaption(), $documento_caja_chica->tipo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->idtipo_documento->FldCaption(), $documento_caja_chica->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_serie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->serie->FldCaption(), $documento_caja_chica->serie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_numero");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->numero->FldCaption(), $documento_caja_chica->numero->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->fecha->FldCaption(), $documento_caja_chica->fecha->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_caja_chica->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->monto->FldCaption(), $documento_caja_chica->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_caja_chica->monto->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fdocumento_caja_chicagrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "tipo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idtipo_documento", false)) return false;
	if (ew_ValueChanged(fobj, infix, "serie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fdocumento_caja_chicagrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_caja_chicagrid.ValidateRequired = true;
<?php } else { ?>
fdocumento_caja_chicagrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_caja_chicagrid.Lists["x_tipo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicagrid.Lists["x_tipo"].Options = <?php echo json_encode($documento_caja_chica->tipo->Options()) ?>;
fdocumento_caja_chicagrid.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($documento_caja_chica->CurrentAction == "gridadd") {
	if ($documento_caja_chica->CurrentMode == "copy") {
		$bSelectLimit = $documento_caja_chica_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$documento_caja_chica_grid->TotalRecs = $documento_caja_chica->SelectRecordCount();
			$documento_caja_chica_grid->Recordset = $documento_caja_chica_grid->LoadRecordset($documento_caja_chica_grid->StartRec-1, $documento_caja_chica_grid->DisplayRecs);
		} else {
			if ($documento_caja_chica_grid->Recordset = $documento_caja_chica_grid->LoadRecordset())
				$documento_caja_chica_grid->TotalRecs = $documento_caja_chica_grid->Recordset->RecordCount();
		}
		$documento_caja_chica_grid->StartRec = 1;
		$documento_caja_chica_grid->DisplayRecs = $documento_caja_chica_grid->TotalRecs;
	} else {
		$documento_caja_chica->CurrentFilter = "0=1";
		$documento_caja_chica_grid->StartRec = 1;
		$documento_caja_chica_grid->DisplayRecs = $documento_caja_chica->GridAddRowCount;
	}
	$documento_caja_chica_grid->TotalRecs = $documento_caja_chica_grid->DisplayRecs;
	$documento_caja_chica_grid->StopRec = $documento_caja_chica_grid->DisplayRecs;
} else {
	$bSelectLimit = $documento_caja_chica_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($documento_caja_chica_grid->TotalRecs <= 0)
			$documento_caja_chica_grid->TotalRecs = $documento_caja_chica->SelectRecordCount();
	} else {
		if (!$documento_caja_chica_grid->Recordset && ($documento_caja_chica_grid->Recordset = $documento_caja_chica_grid->LoadRecordset()))
			$documento_caja_chica_grid->TotalRecs = $documento_caja_chica_grid->Recordset->RecordCount();
	}
	$documento_caja_chica_grid->StartRec = 1;
	$documento_caja_chica_grid->DisplayRecs = $documento_caja_chica_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$documento_caja_chica_grid->Recordset = $documento_caja_chica_grid->LoadRecordset($documento_caja_chica_grid->StartRec-1, $documento_caja_chica_grid->DisplayRecs);

	// Set no record found message
	if ($documento_caja_chica->CurrentAction == "" && $documento_caja_chica_grid->TotalRecs == 0) {
		if ($documento_caja_chica_grid->SearchWhere == "0=101")
			$documento_caja_chica_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$documento_caja_chica_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$documento_caja_chica_grid->RenderOtherOptions();
?>
<?php $documento_caja_chica_grid->ShowPageHeader(); ?>
<?php
$documento_caja_chica_grid->ShowMessage();
?>
<?php if ($documento_caja_chica_grid->TotalRecs > 0 || $documento_caja_chica->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fdocumento_caja_chicagrid" class="ewForm form-inline">
<div id="gmp_documento_caja_chica" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_documento_caja_chicagrid" class="table ewTable">
<?php echo $documento_caja_chica->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$documento_caja_chica_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$documento_caja_chica_grid->RenderListOptions();

// Render list options (header, left)
$documento_caja_chica_grid->ListOptions->Render("header", "left");
?>
<?php if ($documento_caja_chica->tipo->Visible) { // tipo ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->tipo) == "") { ?>
		<th data-name="tipo"><div id="elh_documento_caja_chica_tipo" class="documento_caja_chica_tipo"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->tipo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tipo"><div><div id="elh_documento_caja_chica_tipo" class="documento_caja_chica_tipo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->tipo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->tipo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->tipo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_caja_chica->idtipo_documento->Visible) { // idtipo_documento ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->idtipo_documento) == "") { ?>
		<th data-name="idtipo_documento"><div id="elh_documento_caja_chica_idtipo_documento" class="documento_caja_chica_idtipo_documento"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->idtipo_documento->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idtipo_documento"><div><div id="elh_documento_caja_chica_idtipo_documento" class="documento_caja_chica_idtipo_documento">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->idtipo_documento->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->idtipo_documento->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->idtipo_documento->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_caja_chica->serie->Visible) { // serie ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->serie) == "") { ?>
		<th data-name="serie"><div id="elh_documento_caja_chica_serie" class="documento_caja_chica_serie"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->serie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="serie"><div><div id="elh_documento_caja_chica_serie" class="documento_caja_chica_serie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->serie->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->serie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->serie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_caja_chica->numero->Visible) { // numero ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->numero) == "") { ?>
		<th data-name="numero"><div id="elh_documento_caja_chica_numero" class="documento_caja_chica_numero"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_documento_caja_chica_numero" class="documento_caja_chica_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_caja_chica->fecha->Visible) { // fecha ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_documento_caja_chica_fecha" class="documento_caja_chica_fecha"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_documento_caja_chica_fecha" class="documento_caja_chica_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($documento_caja_chica->monto->Visible) { // monto ?>
	<?php if ($documento_caja_chica->SortUrl($documento_caja_chica->monto) == "") { ?>
		<th data-name="monto"><div id="elh_documento_caja_chica_monto" class="documento_caja_chica_monto"><div class="ewTableHeaderCaption"><?php echo $documento_caja_chica->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_documento_caja_chica_monto" class="documento_caja_chica_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $documento_caja_chica->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($documento_caja_chica->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($documento_caja_chica->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$documento_caja_chica_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$documento_caja_chica_grid->StartRec = 1;
$documento_caja_chica_grid->StopRec = $documento_caja_chica_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($documento_caja_chica_grid->FormKeyCountName) && ($documento_caja_chica->CurrentAction == "gridadd" || $documento_caja_chica->CurrentAction == "gridedit" || $documento_caja_chica->CurrentAction == "F")) {
		$documento_caja_chica_grid->KeyCount = $objForm->GetValue($documento_caja_chica_grid->FormKeyCountName);
		$documento_caja_chica_grid->StopRec = $documento_caja_chica_grid->StartRec + $documento_caja_chica_grid->KeyCount - 1;
	}
}
$documento_caja_chica_grid->RecCnt = $documento_caja_chica_grid->StartRec - 1;
if ($documento_caja_chica_grid->Recordset && !$documento_caja_chica_grid->Recordset->EOF) {
	$documento_caja_chica_grid->Recordset->MoveFirst();
	$bSelectLimit = $documento_caja_chica_grid->UseSelectLimit;
	if (!$bSelectLimit && $documento_caja_chica_grid->StartRec > 1)
		$documento_caja_chica_grid->Recordset->Move($documento_caja_chica_grid->StartRec - 1);
} elseif (!$documento_caja_chica->AllowAddDeleteRow && $documento_caja_chica_grid->StopRec == 0) {
	$documento_caja_chica_grid->StopRec = $documento_caja_chica->GridAddRowCount;
}

// Initialize aggregate
$documento_caja_chica->RowType = EW_ROWTYPE_AGGREGATEINIT;
$documento_caja_chica->ResetAttrs();
$documento_caja_chica_grid->RenderRow();
if ($documento_caja_chica->CurrentAction == "gridadd")
	$documento_caja_chica_grid->RowIndex = 0;
if ($documento_caja_chica->CurrentAction == "gridedit")
	$documento_caja_chica_grid->RowIndex = 0;
while ($documento_caja_chica_grid->RecCnt < $documento_caja_chica_grid->StopRec) {
	$documento_caja_chica_grid->RecCnt++;
	if (intval($documento_caja_chica_grid->RecCnt) >= intval($documento_caja_chica_grid->StartRec)) {
		$documento_caja_chica_grid->RowCnt++;
		if ($documento_caja_chica->CurrentAction == "gridadd" || $documento_caja_chica->CurrentAction == "gridedit" || $documento_caja_chica->CurrentAction == "F") {
			$documento_caja_chica_grid->RowIndex++;
			$objForm->Index = $documento_caja_chica_grid->RowIndex;
			if ($objForm->HasValue($documento_caja_chica_grid->FormActionName))
				$documento_caja_chica_grid->RowAction = strval($objForm->GetValue($documento_caja_chica_grid->FormActionName));
			elseif ($documento_caja_chica->CurrentAction == "gridadd")
				$documento_caja_chica_grid->RowAction = "insert";
			else
				$documento_caja_chica_grid->RowAction = "";
		}

		// Set up key count
		$documento_caja_chica_grid->KeyCount = $documento_caja_chica_grid->RowIndex;

		// Init row class and style
		$documento_caja_chica->ResetAttrs();
		$documento_caja_chica->CssClass = "";
		if ($documento_caja_chica->CurrentAction == "gridadd") {
			if ($documento_caja_chica->CurrentMode == "copy") {
				$documento_caja_chica_grid->LoadRowValues($documento_caja_chica_grid->Recordset); // Load row values
				$documento_caja_chica_grid->SetRecordKey($documento_caja_chica_grid->RowOldKey, $documento_caja_chica_grid->Recordset); // Set old record key
			} else {
				$documento_caja_chica_grid->LoadDefaultValues(); // Load default values
				$documento_caja_chica_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$documento_caja_chica_grid->LoadRowValues($documento_caja_chica_grid->Recordset); // Load row values
		}
		$documento_caja_chica->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($documento_caja_chica->CurrentAction == "gridadd") // Grid add
			$documento_caja_chica->RowType = EW_ROWTYPE_ADD; // Render add
		if ($documento_caja_chica->CurrentAction == "gridadd" && $documento_caja_chica->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$documento_caja_chica_grid->RestoreCurrentRowFormValues($documento_caja_chica_grid->RowIndex); // Restore form values
		if ($documento_caja_chica->CurrentAction == "gridedit") { // Grid edit
			if ($documento_caja_chica->EventCancelled) {
				$documento_caja_chica_grid->RestoreCurrentRowFormValues($documento_caja_chica_grid->RowIndex); // Restore form values
			}
			if ($documento_caja_chica_grid->RowAction == "insert")
				$documento_caja_chica->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$documento_caja_chica->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($documento_caja_chica->CurrentAction == "gridedit" && ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT || $documento_caja_chica->RowType == EW_ROWTYPE_ADD) && $documento_caja_chica->EventCancelled) // Update failed
			$documento_caja_chica_grid->RestoreCurrentRowFormValues($documento_caja_chica_grid->RowIndex); // Restore form values
		if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) // Edit row
			$documento_caja_chica_grid->EditRowCnt++;
		if ($documento_caja_chica->CurrentAction == "F") // Confirm row
			$documento_caja_chica_grid->RestoreCurrentRowFormValues($documento_caja_chica_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$documento_caja_chica->RowAttrs = array_merge($documento_caja_chica->RowAttrs, array('data-rowindex'=>$documento_caja_chica_grid->RowCnt, 'id'=>'r' . $documento_caja_chica_grid->RowCnt . '_documento_caja_chica', 'data-rowtype'=>$documento_caja_chica->RowType));

		// Render row
		$documento_caja_chica_grid->RenderRow();

		// Render list options
		$documento_caja_chica_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($documento_caja_chica_grid->RowAction <> "delete" && $documento_caja_chica_grid->RowAction <> "insertdelete" && !($documento_caja_chica_grid->RowAction == "insert" && $documento_caja_chica->CurrentAction == "F" && $documento_caja_chica_grid->EmptyRow())) {
?>
	<tr<?php echo $documento_caja_chica->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_caja_chica_grid->ListOptions->Render("body", "left", $documento_caja_chica_grid->RowCnt);
?>
	<?php if ($documento_caja_chica->tipo->Visible) { // tipo ?>
		<td data-name="tipo"<?php echo $documento_caja_chica->tipo->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_tipo" class="form-group documento_caja_chica_tipo">
<select data-table="documento_caja_chica" data-field="x_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->tipo->DisplayValueSeparator) ? json_encode($documento_caja_chica->tipo->DisplayValueSeparator) : $documento_caja_chica->tipo->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo"<?php echo $documento_caja_chica->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->tipo->EditValue)) {
	$arwrk = $documento_caja_chica->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->CurrentValue) ?>" selected><?php echo $documento_caja_chica->tipo->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->tipo->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_tipo" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_tipo" class="form-group documento_caja_chica_tipo">
<select data-table="documento_caja_chica" data-field="x_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->tipo->DisplayValueSeparator) ? json_encode($documento_caja_chica->tipo->DisplayValueSeparator) : $documento_caja_chica->tipo->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo"<?php echo $documento_caja_chica->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->tipo->EditValue)) {
	$arwrk = $documento_caja_chica->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->CurrentValue) ?>" selected><?php echo $documento_caja_chica->tipo->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->tipo->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_tipo" class="documento_caja_chica_tipo">
<span<?php echo $documento_caja_chica->tipo->ViewAttributes() ?>>
<?php echo $documento_caja_chica->tipo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_tipo" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_tipo" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $documento_caja_chica_grid->PageObjName . "_row_" . $documento_caja_chica_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_iddocumento_caja_chica" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" value="<?php echo ew_HtmlEncode($documento_caja_chica->iddocumento_caja_chica->CurrentValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_iddocumento_caja_chica" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" value="<?php echo ew_HtmlEncode($documento_caja_chica->iddocumento_caja_chica->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT || $documento_caja_chica->CurrentMode == "edit") { ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_iddocumento_caja_chica" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_iddocumento_caja_chica" value="<?php echo ew_HtmlEncode($documento_caja_chica->iddocumento_caja_chica->CurrentValue) ?>">
<?php } ?>
	<?php if ($documento_caja_chica->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_idtipo_documento" class="form-group documento_caja_chica_idtipo_documento">
<select data-table="documento_caja_chica" data-field="x_idtipo_documento" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->idtipo_documento->DisplayValueSeparator) ? json_encode($documento_caja_chica->idtipo_documento->DisplayValueSeparator) : $documento_caja_chica->idtipo_documento->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->idtipo_documento->EditValue)) {
	$arwrk = $documento_caja_chica->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->idtipo_documento->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->idtipo_documento->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->idtipo_documento->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->CurrentValue) ?>" selected><?php echo $documento_caja_chica->idtipo_documento->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->idtipo_documento->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$documento_caja_chica->idtipo_documento->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$documento_caja_chica->idtipo_documento->LookupFilters += array("f0" => "`idtipo_documento` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$documento_caja_chica->Lookup_Selecting($documento_caja_chica->idtipo_documento, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $documento_caja_chica->idtipo_documento->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo $documento_caja_chica->idtipo_documento->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_idtipo_documento" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_idtipo_documento" class="form-group documento_caja_chica_idtipo_documento">
<select data-table="documento_caja_chica" data-field="x_idtipo_documento" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->idtipo_documento->DisplayValueSeparator) ? json_encode($documento_caja_chica->idtipo_documento->DisplayValueSeparator) : $documento_caja_chica->idtipo_documento->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->idtipo_documento->EditValue)) {
	$arwrk = $documento_caja_chica->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->idtipo_documento->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->idtipo_documento->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->idtipo_documento->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->CurrentValue) ?>" selected><?php echo $documento_caja_chica->idtipo_documento->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->idtipo_documento->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$documento_caja_chica->idtipo_documento->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$documento_caja_chica->idtipo_documento->LookupFilters += array("f0" => "`idtipo_documento` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$documento_caja_chica->Lookup_Selecting($documento_caja_chica->idtipo_documento, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $documento_caja_chica->idtipo_documento->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo $documento_caja_chica->idtipo_documento->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_idtipo_documento" class="documento_caja_chica_idtipo_documento">
<span<?php echo $documento_caja_chica->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_caja_chica->idtipo_documento->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_idtipo_documento" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_idtipo_documento" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->serie->Visible) { // serie ?>
		<td data-name="serie"<?php echo $documento_caja_chica->serie->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_serie" class="form-group documento_caja_chica_serie">
<input type="text" data-table="documento_caja_chica" data-field="x_serie" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->serie->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->serie->EditValue ?>"<?php echo $documento_caja_chica->serie->EditAttributes() ?>>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_serie" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_caja_chica->serie->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_serie" class="form-group documento_caja_chica_serie">
<input type="text" data-table="documento_caja_chica" data-field="x_serie" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->serie->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->serie->EditValue ?>"<?php echo $documento_caja_chica->serie->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_serie" class="documento_caja_chica_serie">
<span<?php echo $documento_caja_chica->serie->ViewAttributes() ?>>
<?php echo $documento_caja_chica->serie->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_serie" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_caja_chica->serie->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_serie" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_caja_chica->serie->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $documento_caja_chica->numero->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_numero" class="form-group documento_caja_chica_numero">
<input type="text" data-table="documento_caja_chica" data-field="x_numero" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->numero->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->numero->EditValue ?>"<?php echo $documento_caja_chica->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_numero" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_caja_chica->numero->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_numero" class="form-group documento_caja_chica_numero">
<input type="text" data-table="documento_caja_chica" data-field="x_numero" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->numero->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->numero->EditValue ?>"<?php echo $documento_caja_chica->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_numero" class="documento_caja_chica_numero">
<span<?php echo $documento_caja_chica->numero->ViewAttributes() ?>>
<?php echo $documento_caja_chica->numero->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_numero" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_caja_chica->numero->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_numero" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_caja_chica->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $documento_caja_chica->fecha->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_fecha" class="form-group documento_caja_chica_fecha">
<input type="text" data-table="documento_caja_chica" data-field="x_fecha" data-format="7" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->fecha->EditValue ?>"<?php echo $documento_caja_chica->fecha->EditAttributes() ?>>
<?php if (!$documento_caja_chica->fecha->ReadOnly && !$documento_caja_chica->fecha->Disabled && !isset($documento_caja_chica->fecha->EditAttrs["readonly"]) && !isset($documento_caja_chica->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_caja_chicagrid", "x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_fecha" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_fecha" class="form-group documento_caja_chica_fecha">
<input type="text" data-table="documento_caja_chica" data-field="x_fecha" data-format="7" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->fecha->EditValue ?>"<?php echo $documento_caja_chica->fecha->EditAttributes() ?>>
<?php if (!$documento_caja_chica->fecha->ReadOnly && !$documento_caja_chica->fecha->Disabled && !isset($documento_caja_chica->fecha->EditAttrs["readonly"]) && !isset($documento_caja_chica->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_caja_chicagrid", "x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_fecha" class="documento_caja_chica_fecha">
<span<?php echo $documento_caja_chica->fecha->ViewAttributes() ?>>
<?php echo $documento_caja_chica->fecha->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_fecha" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_fecha" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $documento_caja_chica->monto->CellAttributes() ?>>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_monto" class="form-group documento_caja_chica_monto">
<input type="text" data-table="documento_caja_chica" data-field="x_monto" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->monto->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->monto->EditValue ?>"<?php echo $documento_caja_chica->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_monto" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_caja_chica->monto->OldValue) ?>">
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_monto" class="form-group documento_caja_chica_monto">
<input type="text" data-table="documento_caja_chica" data-field="x_monto" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->monto->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->monto->EditValue ?>"<?php echo $documento_caja_chica->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $documento_caja_chica_grid->RowCnt ?>_documento_caja_chica_monto" class="documento_caja_chica_monto">
<span<?php echo $documento_caja_chica->monto->ViewAttributes() ?>>
<?php echo $documento_caja_chica->monto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_monto" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_caja_chica->monto->FormValue) ?>">
<input type="hidden" data-table="documento_caja_chica" data-field="x_monto" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_caja_chica->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_caja_chica_grid->ListOptions->Render("body", "right", $documento_caja_chica_grid->RowCnt);
?>
	</tr>
<?php if ($documento_caja_chica->RowType == EW_ROWTYPE_ADD || $documento_caja_chica->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fdocumento_caja_chicagrid.UpdateOpts(<?php echo $documento_caja_chica_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($documento_caja_chica->CurrentAction <> "gridadd" || $documento_caja_chica->CurrentMode == "copy")
		if (!$documento_caja_chica_grid->Recordset->EOF) $documento_caja_chica_grid->Recordset->MoveNext();
}
?>
<?php
	if ($documento_caja_chica->CurrentMode == "add" || $documento_caja_chica->CurrentMode == "copy" || $documento_caja_chica->CurrentMode == "edit") {
		$documento_caja_chica_grid->RowIndex = '$rowindex$';
		$documento_caja_chica_grid->LoadDefaultValues();

		// Set row properties
		$documento_caja_chica->ResetAttrs();
		$documento_caja_chica->RowAttrs = array_merge($documento_caja_chica->RowAttrs, array('data-rowindex'=>$documento_caja_chica_grid->RowIndex, 'id'=>'r0_documento_caja_chica', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($documento_caja_chica->RowAttrs["class"], "ewTemplate");
		$documento_caja_chica->RowType = EW_ROWTYPE_ADD;

		// Render row
		$documento_caja_chica_grid->RenderRow();

		// Render list options
		$documento_caja_chica_grid->RenderListOptions();
		$documento_caja_chica_grid->StartRowCnt = 0;
?>
	<tr<?php echo $documento_caja_chica->RowAttributes() ?>>
<?php

// Render list options (body, left)
$documento_caja_chica_grid->ListOptions->Render("body", "left", $documento_caja_chica_grid->RowIndex);
?>
	<?php if ($documento_caja_chica->tipo->Visible) { // tipo ?>
		<td data-name="tipo">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_tipo" class="form-group documento_caja_chica_tipo">
<select data-table="documento_caja_chica" data-field="x_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->tipo->DisplayValueSeparator) ? json_encode($documento_caja_chica->tipo->DisplayValueSeparator) : $documento_caja_chica->tipo->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo"<?php echo $documento_caja_chica->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->tipo->EditValue)) {
	$arwrk = $documento_caja_chica->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->CurrentValue) ?>" selected><?php echo $documento_caja_chica->tipo->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->tipo->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_tipo" class="form-group documento_caja_chica_tipo">
<span<?php echo $documento_caja_chica->tipo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->tipo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_tipo" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_tipo" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_tipo" value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->idtipo_documento->Visible) { // idtipo_documento ?>
		<td data-name="idtipo_documento">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_idtipo_documento" class="form-group documento_caja_chica_idtipo_documento">
<select data-table="documento_caja_chica" data-field="x_idtipo_documento" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->idtipo_documento->DisplayValueSeparator) ? json_encode($documento_caja_chica->idtipo_documento->DisplayValueSeparator) : $documento_caja_chica->idtipo_documento->DisplayValueSeparator) ?>" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->idtipo_documento->EditValue)) {
	$arwrk = $documento_caja_chica->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->idtipo_documento->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->idtipo_documento->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->idtipo_documento->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->CurrentValue) ?>" selected><?php echo $documento_caja_chica->idtipo_documento->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $documento_caja_chica->idtipo_documento->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$documento_caja_chica->idtipo_documento->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$documento_caja_chica->idtipo_documento->LookupFilters += array("f0" => "`idtipo_documento` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$documento_caja_chica->Lookup_Selecting($documento_caja_chica->idtipo_documento, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $documento_caja_chica->idtipo_documento->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="s_x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo $documento_caja_chica->idtipo_documento->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_idtipo_documento" class="form-group documento_caja_chica_idtipo_documento">
<span<?php echo $documento_caja_chica->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_idtipo_documento" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_idtipo_documento" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_idtipo_documento" value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->serie->Visible) { // serie ?>
		<td data-name="serie">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_serie" class="form-group documento_caja_chica_serie">
<input type="text" data-table="documento_caja_chica" data-field="x_serie" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->serie->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->serie->EditValue ?>"<?php echo $documento_caja_chica->serie->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_serie" class="form-group documento_caja_chica_serie">
<span<?php echo $documento_caja_chica->serie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->serie->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_serie" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_caja_chica->serie->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_serie" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_serie" value="<?php echo ew_HtmlEncode($documento_caja_chica->serie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->numero->Visible) { // numero ?>
		<td data-name="numero">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_numero" class="form-group documento_caja_chica_numero">
<input type="text" data-table="documento_caja_chica" data-field="x_numero" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->numero->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->numero->EditValue ?>"<?php echo $documento_caja_chica->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_numero" class="form-group documento_caja_chica_numero">
<span<?php echo $documento_caja_chica->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_numero" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_caja_chica->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_numero" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($documento_caja_chica->numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->fecha->Visible) { // fecha ?>
		<td data-name="fecha">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_fecha" class="form-group documento_caja_chica_fecha">
<input type="text" data-table="documento_caja_chica" data-field="x_fecha" data-format="7" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->fecha->EditValue ?>"<?php echo $documento_caja_chica->fecha->EditAttributes() ?>>
<?php if (!$documento_caja_chica->fecha->ReadOnly && !$documento_caja_chica->fecha->Disabled && !isset($documento_caja_chica->fecha->EditAttrs["readonly"]) && !isset($documento_caja_chica->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_caja_chicagrid", "x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_fecha" class="form-group documento_caja_chica_fecha">
<span<?php echo $documento_caja_chica->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_fecha" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_fecha" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($documento_caja_chica->monto->Visible) { // monto ?>
		<td data-name="monto">
<?php if ($documento_caja_chica->CurrentAction <> "F") { ?>
<span id="el$rowindex$_documento_caja_chica_monto" class="form-group documento_caja_chica_monto">
<input type="text" data-table="documento_caja_chica" data-field="x_monto" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->monto->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->monto->EditValue ?>"<?php echo $documento_caja_chica->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_documento_caja_chica_monto" class="form-group documento_caja_chica_monto">
<span<?php echo $documento_caja_chica->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="documento_caja_chica" data-field="x_monto" name="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="x<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_caja_chica->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="documento_caja_chica" data-field="x_monto" name="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" id="o<?php echo $documento_caja_chica_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($documento_caja_chica->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$documento_caja_chica_grid->ListOptions->Render("body", "right", $documento_caja_chica_grid->RowCnt);
?>
<script type="text/javascript">
fdocumento_caja_chicagrid.UpdateOpts(<?php echo $documento_caja_chica_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($documento_caja_chica->CurrentMode == "add" || $documento_caja_chica->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $documento_caja_chica_grid->FormKeyCountName ?>" id="<?php echo $documento_caja_chica_grid->FormKeyCountName ?>" value="<?php echo $documento_caja_chica_grid->KeyCount ?>">
<?php echo $documento_caja_chica_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_caja_chica->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $documento_caja_chica_grid->FormKeyCountName ?>" id="<?php echo $documento_caja_chica_grid->FormKeyCountName ?>" value="<?php echo $documento_caja_chica_grid->KeyCount ?>">
<?php echo $documento_caja_chica_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($documento_caja_chica->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fdocumento_caja_chicagrid">
</div>
<?php

// Close recordset
if ($documento_caja_chica_grid->Recordset)
	$documento_caja_chica_grid->Recordset->Close();
?>
<?php if ($documento_caja_chica_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($documento_caja_chica_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($documento_caja_chica_grid->TotalRecs == 0 && $documento_caja_chica->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($documento_caja_chica_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($documento_caja_chica->Export == "") { ?>
<script type="text/javascript">
fdocumento_caja_chicagrid.Init();
</script>
<?php } ?>
<?php
$documento_caja_chica_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$documento_caja_chica_grid->Page_Terminate();
?>
