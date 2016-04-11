<?php

// Create page object
if (!isset($caja_chica_aplicacion_grid)) $caja_chica_aplicacion_grid = new ccaja_chica_aplicacion_grid();

// Page init
$caja_chica_aplicacion_grid->Page_Init();

// Page main
$caja_chica_aplicacion_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_aplicacion_grid->Page_Render();
?>
<?php if ($caja_chica_aplicacion->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcaja_chica_aplicaciongrid = new ew_Form("fcaja_chica_aplicaciongrid", "grid");
fcaja_chica_aplicaciongrid.FormKeyCountName = '<?php echo $caja_chica_aplicacion_grid->FormKeyCountName ?>';

// Validate form
fcaja_chica_aplicaciongrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcaja_chica_detalle");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption(), $caja_chica_aplicacion->idcaja_chica_detalle->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcaja_chica_detalle");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->idcaja_chica_detalle->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idreferencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->idreferencia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_aplicacion->monto->FldCaption(), $caja_chica_aplicacion->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->fecha->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcaja_chica_aplicaciongrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idcaja_chica_detalle", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idreferencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tabla_referencia", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	return true;
}

// Form_CustomValidate event
fcaja_chica_aplicaciongrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_aplicaciongrid.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_aplicaciongrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<?php } ?>
<?php
if ($caja_chica_aplicacion->CurrentAction == "gridadd") {
	if ($caja_chica_aplicacion->CurrentMode == "copy") {
		$bSelectLimit = $caja_chica_aplicacion_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$caja_chica_aplicacion_grid->TotalRecs = $caja_chica_aplicacion->SelectRecordCount();
			$caja_chica_aplicacion_grid->Recordset = $caja_chica_aplicacion_grid->LoadRecordset($caja_chica_aplicacion_grid->StartRec-1, $caja_chica_aplicacion_grid->DisplayRecs);
		} else {
			if ($caja_chica_aplicacion_grid->Recordset = $caja_chica_aplicacion_grid->LoadRecordset())
				$caja_chica_aplicacion_grid->TotalRecs = $caja_chica_aplicacion_grid->Recordset->RecordCount();
		}
		$caja_chica_aplicacion_grid->StartRec = 1;
		$caja_chica_aplicacion_grid->DisplayRecs = $caja_chica_aplicacion_grid->TotalRecs;
	} else {
		$caja_chica_aplicacion->CurrentFilter = "0=1";
		$caja_chica_aplicacion_grid->StartRec = 1;
		$caja_chica_aplicacion_grid->DisplayRecs = $caja_chica_aplicacion->GridAddRowCount;
	}
	$caja_chica_aplicacion_grid->TotalRecs = $caja_chica_aplicacion_grid->DisplayRecs;
	$caja_chica_aplicacion_grid->StopRec = $caja_chica_aplicacion_grid->DisplayRecs;
} else {
	$bSelectLimit = $caja_chica_aplicacion_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($caja_chica_aplicacion_grid->TotalRecs <= 0)
			$caja_chica_aplicacion_grid->TotalRecs = $caja_chica_aplicacion->SelectRecordCount();
	} else {
		if (!$caja_chica_aplicacion_grid->Recordset && ($caja_chica_aplicacion_grid->Recordset = $caja_chica_aplicacion_grid->LoadRecordset()))
			$caja_chica_aplicacion_grid->TotalRecs = $caja_chica_aplicacion_grid->Recordset->RecordCount();
	}
	$caja_chica_aplicacion_grid->StartRec = 1;
	$caja_chica_aplicacion_grid->DisplayRecs = $caja_chica_aplicacion_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$caja_chica_aplicacion_grid->Recordset = $caja_chica_aplicacion_grid->LoadRecordset($caja_chica_aplicacion_grid->StartRec-1, $caja_chica_aplicacion_grid->DisplayRecs);

	// Set no record found message
	if ($caja_chica_aplicacion->CurrentAction == "" && $caja_chica_aplicacion_grid->TotalRecs == 0) {
		if ($caja_chica_aplicacion_grid->SearchWhere == "0=101")
			$caja_chica_aplicacion_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$caja_chica_aplicacion_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$caja_chica_aplicacion_grid->RenderOtherOptions();
?>
<?php $caja_chica_aplicacion_grid->ShowPageHeader(); ?>
<?php
$caja_chica_aplicacion_grid->ShowMessage();
?>
<?php if ($caja_chica_aplicacion_grid->TotalRecs > 0 || $caja_chica_aplicacion->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fcaja_chica_aplicaciongrid" class="ewForm form-inline">
<div id="gmp_caja_chica_aplicacion" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_caja_chica_aplicaciongrid" class="table ewTable">
<?php echo $caja_chica_aplicacion->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$caja_chica_aplicacion_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$caja_chica_aplicacion_grid->RenderListOptions();

// Render list options (header, left)
$caja_chica_aplicacion_grid->ListOptions->Render("header", "left");
?>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
	<?php if ($caja_chica_aplicacion->SortUrl($caja_chica_aplicacion->idcaja_chica_detalle) == "") { ?>
		<th data-name="idcaja_chica_detalle"><div id="elh_caja_chica_aplicacion_idcaja_chica_detalle" class="caja_chica_aplicacion_idcaja_chica_detalle"><div class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcaja_chica_detalle"><div><div id="elh_caja_chica_aplicacion_idcaja_chica_detalle" class="caja_chica_aplicacion_idcaja_chica_detalle">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_aplicacion->idcaja_chica_detalle->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_aplicacion->idcaja_chica_detalle->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
	<?php if ($caja_chica_aplicacion->SortUrl($caja_chica_aplicacion->idreferencia) == "") { ?>
		<th data-name="idreferencia"><div id="elh_caja_chica_aplicacion_idreferencia" class="caja_chica_aplicacion_idreferencia"><div class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idreferencia"><div><div id="elh_caja_chica_aplicacion_idreferencia" class="caja_chica_aplicacion_idreferencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_aplicacion->idreferencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_aplicacion->idreferencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
	<?php if ($caja_chica_aplicacion->SortUrl($caja_chica_aplicacion->tabla_referencia) == "") { ?>
		<th data-name="tabla_referencia"><div id="elh_caja_chica_aplicacion_tabla_referencia" class="caja_chica_aplicacion_tabla_referencia"><div class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tabla_referencia"><div><div id="elh_caja_chica_aplicacion_tabla_referencia" class="caja_chica_aplicacion_tabla_referencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_aplicacion->tabla_referencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_aplicacion->tabla_referencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
	<?php if ($caja_chica_aplicacion->SortUrl($caja_chica_aplicacion->monto) == "") { ?>
		<th data-name="monto"><div id="elh_caja_chica_aplicacion_monto" class="caja_chica_aplicacion_monto"><div class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_caja_chica_aplicacion_monto" class="caja_chica_aplicacion_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_aplicacion->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_aplicacion->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
	<?php if ($caja_chica_aplicacion->SortUrl($caja_chica_aplicacion->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_caja_chica_aplicacion_fecha" class="caja_chica_aplicacion_fecha"><div class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_caja_chica_aplicacion_fecha" class="caja_chica_aplicacion_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_aplicacion->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_aplicacion->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$caja_chica_aplicacion_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$caja_chica_aplicacion_grid->StartRec = 1;
$caja_chica_aplicacion_grid->StopRec = $caja_chica_aplicacion_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($caja_chica_aplicacion_grid->FormKeyCountName) && ($caja_chica_aplicacion->CurrentAction == "gridadd" || $caja_chica_aplicacion->CurrentAction == "gridedit" || $caja_chica_aplicacion->CurrentAction == "F")) {
		$caja_chica_aplicacion_grid->KeyCount = $objForm->GetValue($caja_chica_aplicacion_grid->FormKeyCountName);
		$caja_chica_aplicacion_grid->StopRec = $caja_chica_aplicacion_grid->StartRec + $caja_chica_aplicacion_grid->KeyCount - 1;
	}
}
$caja_chica_aplicacion_grid->RecCnt = $caja_chica_aplicacion_grid->StartRec - 1;
if ($caja_chica_aplicacion_grid->Recordset && !$caja_chica_aplicacion_grid->Recordset->EOF) {
	$caja_chica_aplicacion_grid->Recordset->MoveFirst();
	$bSelectLimit = $caja_chica_aplicacion_grid->UseSelectLimit;
	if (!$bSelectLimit && $caja_chica_aplicacion_grid->StartRec > 1)
		$caja_chica_aplicacion_grid->Recordset->Move($caja_chica_aplicacion_grid->StartRec - 1);
} elseif (!$caja_chica_aplicacion->AllowAddDeleteRow && $caja_chica_aplicacion_grid->StopRec == 0) {
	$caja_chica_aplicacion_grid->StopRec = $caja_chica_aplicacion->GridAddRowCount;
}

// Initialize aggregate
$caja_chica_aplicacion->RowType = EW_ROWTYPE_AGGREGATEINIT;
$caja_chica_aplicacion->ResetAttrs();
$caja_chica_aplicacion_grid->RenderRow();
if ($caja_chica_aplicacion->CurrentAction == "gridadd")
	$caja_chica_aplicacion_grid->RowIndex = 0;
if ($caja_chica_aplicacion->CurrentAction == "gridedit")
	$caja_chica_aplicacion_grid->RowIndex = 0;
while ($caja_chica_aplicacion_grid->RecCnt < $caja_chica_aplicacion_grid->StopRec) {
	$caja_chica_aplicacion_grid->RecCnt++;
	if (intval($caja_chica_aplicacion_grid->RecCnt) >= intval($caja_chica_aplicacion_grid->StartRec)) {
		$caja_chica_aplicacion_grid->RowCnt++;
		if ($caja_chica_aplicacion->CurrentAction == "gridadd" || $caja_chica_aplicacion->CurrentAction == "gridedit" || $caja_chica_aplicacion->CurrentAction == "F") {
			$caja_chica_aplicacion_grid->RowIndex++;
			$objForm->Index = $caja_chica_aplicacion_grid->RowIndex;
			if ($objForm->HasValue($caja_chica_aplicacion_grid->FormActionName))
				$caja_chica_aplicacion_grid->RowAction = strval($objForm->GetValue($caja_chica_aplicacion_grid->FormActionName));
			elseif ($caja_chica_aplicacion->CurrentAction == "gridadd")
				$caja_chica_aplicacion_grid->RowAction = "insert";
			else
				$caja_chica_aplicacion_grid->RowAction = "";
		}

		// Set up key count
		$caja_chica_aplicacion_grid->KeyCount = $caja_chica_aplicacion_grid->RowIndex;

		// Init row class and style
		$caja_chica_aplicacion->ResetAttrs();
		$caja_chica_aplicacion->CssClass = "";
		if ($caja_chica_aplicacion->CurrentAction == "gridadd") {
			if ($caja_chica_aplicacion->CurrentMode == "copy") {
				$caja_chica_aplicacion_grid->LoadRowValues($caja_chica_aplicacion_grid->Recordset); // Load row values
				$caja_chica_aplicacion_grid->SetRecordKey($caja_chica_aplicacion_grid->RowOldKey, $caja_chica_aplicacion_grid->Recordset); // Set old record key
			} else {
				$caja_chica_aplicacion_grid->LoadDefaultValues(); // Load default values
				$caja_chica_aplicacion_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$caja_chica_aplicacion_grid->LoadRowValues($caja_chica_aplicacion_grid->Recordset); // Load row values
		}
		$caja_chica_aplicacion->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($caja_chica_aplicacion->CurrentAction == "gridadd") // Grid add
			$caja_chica_aplicacion->RowType = EW_ROWTYPE_ADD; // Render add
		if ($caja_chica_aplicacion->CurrentAction == "gridadd" && $caja_chica_aplicacion->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$caja_chica_aplicacion_grid->RestoreCurrentRowFormValues($caja_chica_aplicacion_grid->RowIndex); // Restore form values
		if ($caja_chica_aplicacion->CurrentAction == "gridedit") { // Grid edit
			if ($caja_chica_aplicacion->EventCancelled) {
				$caja_chica_aplicacion_grid->RestoreCurrentRowFormValues($caja_chica_aplicacion_grid->RowIndex); // Restore form values
			}
			if ($caja_chica_aplicacion_grid->RowAction == "insert")
				$caja_chica_aplicacion->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$caja_chica_aplicacion->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($caja_chica_aplicacion->CurrentAction == "gridedit" && ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT || $caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) && $caja_chica_aplicacion->EventCancelled) // Update failed
			$caja_chica_aplicacion_grid->RestoreCurrentRowFormValues($caja_chica_aplicacion_grid->RowIndex); // Restore form values
		if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) // Edit row
			$caja_chica_aplicacion_grid->EditRowCnt++;
		if ($caja_chica_aplicacion->CurrentAction == "F") // Confirm row
			$caja_chica_aplicacion_grid->RestoreCurrentRowFormValues($caja_chica_aplicacion_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$caja_chica_aplicacion->RowAttrs = array_merge($caja_chica_aplicacion->RowAttrs, array('data-rowindex'=>$caja_chica_aplicacion_grid->RowCnt, 'id'=>'r' . $caja_chica_aplicacion_grid->RowCnt . '_caja_chica_aplicacion', 'data-rowtype'=>$caja_chica_aplicacion->RowType));

		// Render row
		$caja_chica_aplicacion_grid->RenderRow();

		// Render list options
		$caja_chica_aplicacion_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($caja_chica_aplicacion_grid->RowAction <> "delete" && $caja_chica_aplicacion_grid->RowAction <> "insertdelete" && !($caja_chica_aplicacion_grid->RowAction == "insert" && $caja_chica_aplicacion->CurrentAction == "F" && $caja_chica_aplicacion_grid->EmptyRow())) {
?>
	<tr<?php echo $caja_chica_aplicacion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_aplicacion_grid->ListOptions->Render("body", "left", $caja_chica_aplicacion_grid->RowCnt);
?>
	<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
		<td data-name="idcaja_chica_detalle"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditValue ?>"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditValue ?>"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->FormValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->OldValue) ?>">
<?php } ?>
<a id="<?php echo $caja_chica_aplicacion_grid->PageObjName . "_row_" . $caja_chica_aplicacion_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_aplicacion" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_aplicacion->CurrentValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_aplicacion" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_aplicacion->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT || $caja_chica_aplicacion->CurrentMode == "edit") { ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_aplicacion" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_aplicacion" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_aplicacion->CurrentValue) ?>">
<?php } ?>
	<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
		<td data-name="idreferencia"<?php echo $caja_chica_aplicacion->idreferencia->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idreferencia" class="form-group caja_chica_aplicacion_idreferencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idreferencia->EditValue ?>"<?php echo $caja_chica_aplicacion->idreferencia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idreferencia" class="form-group caja_chica_aplicacion_idreferencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idreferencia->EditValue ?>"<?php echo $caja_chica_aplicacion->idreferencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_idreferencia" class="caja_chica_aplicacion_idreferencia">
<span<?php echo $caja_chica_aplicacion->idreferencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idreferencia->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->FormValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
		<td data-name="tabla_referencia"<?php echo $caja_chica_aplicacion->tabla_referencia->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_tabla_referencia" class="form-group caja_chica_aplicacion_tabla_referencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->tabla_referencia->EditValue ?>"<?php echo $caja_chica_aplicacion->tabla_referencia->EditAttributes() ?>>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_tabla_referencia" class="form-group caja_chica_aplicacion_tabla_referencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->tabla_referencia->EditValue ?>"<?php echo $caja_chica_aplicacion->tabla_referencia->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_tabla_referencia" class="caja_chica_aplicacion_tabla_referencia">
<span<?php echo $caja_chica_aplicacion->tabla_referencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->tabla_referencia->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->FormValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $caja_chica_aplicacion->monto->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_monto" class="form-group caja_chica_aplicacion_monto">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_monto" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->monto->EditValue ?>"<?php echo $caja_chica_aplicacion->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_monto" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_monto" class="form-group caja_chica_aplicacion_monto">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_monto" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->monto->EditValue ?>"<?php echo $caja_chica_aplicacion->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_monto" class="caja_chica_aplicacion_monto">
<span<?php echo $caja_chica_aplicacion->monto->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->monto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_monto" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->FormValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_monto" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $caja_chica_aplicacion->fecha->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_fecha" class="form-group caja_chica_aplicacion_fecha">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->fecha->EditValue ?>"<?php echo $caja_chica_aplicacion->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_aplicacion->fecha->ReadOnly && !$caja_chica_aplicacion->fecha->Disabled && !isset($caja_chica_aplicacion->fecha->EditAttrs["readonly"]) && !isset($caja_chica_aplicacion->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_aplicaciongrid", "x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_fecha" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_fecha" class="form-group caja_chica_aplicacion_fecha">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->fecha->EditValue ?>"<?php echo $caja_chica_aplicacion->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_aplicacion->fecha->ReadOnly && !$caja_chica_aplicacion->fecha->Disabled && !isset($caja_chica_aplicacion->fecha->EditAttrs["readonly"]) && !isset($caja_chica_aplicacion->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_aplicaciongrid", "x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_aplicacion_grid->RowCnt ?>_caja_chica_aplicacion_fecha" class="caja_chica_aplicacion_fecha">
<span<?php echo $caja_chica_aplicacion->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->fecha->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_fecha" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->FormValue) ?>">
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_fecha" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_aplicacion_grid->ListOptions->Render("body", "right", $caja_chica_aplicacion_grid->RowCnt);
?>
	</tr>
<?php if ($caja_chica_aplicacion->RowType == EW_ROWTYPE_ADD || $caja_chica_aplicacion->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcaja_chica_aplicaciongrid.UpdateOpts(<?php echo $caja_chica_aplicacion_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($caja_chica_aplicacion->CurrentAction <> "gridadd" || $caja_chica_aplicacion->CurrentMode == "copy")
		if (!$caja_chica_aplicacion_grid->Recordset->EOF) $caja_chica_aplicacion_grid->Recordset->MoveNext();
}
?>
<?php
	if ($caja_chica_aplicacion->CurrentMode == "add" || $caja_chica_aplicacion->CurrentMode == "copy" || $caja_chica_aplicacion->CurrentMode == "edit") {
		$caja_chica_aplicacion_grid->RowIndex = '$rowindex$';
		$caja_chica_aplicacion_grid->LoadDefaultValues();

		// Set row properties
		$caja_chica_aplicacion->ResetAttrs();
		$caja_chica_aplicacion->RowAttrs = array_merge($caja_chica_aplicacion->RowAttrs, array('data-rowindex'=>$caja_chica_aplicacion_grid->RowIndex, 'id'=>'r0_caja_chica_aplicacion', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($caja_chica_aplicacion->RowAttrs["class"], "ewTemplate");
		$caja_chica_aplicacion->RowType = EW_ROWTYPE_ADD;

		// Render row
		$caja_chica_aplicacion_grid->RenderRow();

		// Render list options
		$caja_chica_aplicacion_grid->RenderListOptions();
		$caja_chica_aplicacion_grid->StartRowCnt = 0;
?>
	<tr<?php echo $caja_chica_aplicacion->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_aplicacion_grid->ListOptions->Render("body", "left", $caja_chica_aplicacion_grid->RowIndex);
?>
	<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
		<td data-name="idcaja_chica_detalle">
<?php if ($caja_chica_aplicacion->CurrentAction <> "F") { ?>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->getSessionValue() <> "") { ?>
<span id="el$rowindex$_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditValue ?>"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_idcaja_chica_detalle" class="form-group caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
		<td data-name="idreferencia">
<?php if ($caja_chica_aplicacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_aplicacion_idreferencia" class="form-group caja_chica_aplicacion_idreferencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idreferencia->EditValue ?>"<?php echo $caja_chica_aplicacion->idreferencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_idreferencia" class="form-group caja_chica_aplicacion_idreferencia">
<span<?php echo $caja_chica_aplicacion->idreferencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idreferencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_idreferencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
		<td data-name="tabla_referencia">
<?php if ($caja_chica_aplicacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_aplicacion_tabla_referencia" class="form-group caja_chica_aplicacion_tabla_referencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->tabla_referencia->EditValue ?>"<?php echo $caja_chica_aplicacion->tabla_referencia->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_tabla_referencia" class="form-group caja_chica_aplicacion_tabla_referencia">
<span<?php echo $caja_chica_aplicacion->tabla_referencia->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->tabla_referencia->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_tabla_referencia" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
		<td data-name="monto">
<?php if ($caja_chica_aplicacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_aplicacion_monto" class="form-group caja_chica_aplicacion_monto">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_monto" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->monto->EditValue ?>"<?php echo $caja_chica_aplicacion->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_monto" class="form-group caja_chica_aplicacion_monto">
<span<?php echo $caja_chica_aplicacion->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_monto" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_monto" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
		<td data-name="fecha">
<?php if ($caja_chica_aplicacion->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_aplicacion_fecha" class="form-group caja_chica_aplicacion_fecha">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->fecha->EditValue ?>"<?php echo $caja_chica_aplicacion->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_aplicacion->fecha->ReadOnly && !$caja_chica_aplicacion->fecha->Disabled && !isset($caja_chica_aplicacion->fecha->EditAttrs["readonly"]) && !isset($caja_chica_aplicacion->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_aplicaciongrid", "x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_aplicacion_fecha" class="form-group caja_chica_aplicacion_fecha">
<span<?php echo $caja_chica_aplicacion->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_fecha" name="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_aplicacion" data-field="x_fecha" name="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_aplicacion_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_aplicacion_grid->ListOptions->Render("body", "right", $caja_chica_aplicacion_grid->RowCnt);
?>
<script type="text/javascript">
fcaja_chica_aplicaciongrid.UpdateOpts(<?php echo $caja_chica_aplicacion_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($caja_chica_aplicacion->CurrentMode == "add" || $caja_chica_aplicacion->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $caja_chica_aplicacion_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_aplicacion_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_aplicacion_grid->KeyCount ?>">
<?php echo $caja_chica_aplicacion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_aplicacion->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $caja_chica_aplicacion_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_aplicacion_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_aplicacion_grid->KeyCount ?>">
<?php echo $caja_chica_aplicacion_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_aplicacion->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcaja_chica_aplicaciongrid">
</div>
<?php

// Close recordset
if ($caja_chica_aplicacion_grid->Recordset)
	$caja_chica_aplicacion_grid->Recordset->Close();
?>
<?php if ($caja_chica_aplicacion_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($caja_chica_aplicacion_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($caja_chica_aplicacion_grid->TotalRecs == 0 && $caja_chica_aplicacion->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($caja_chica_aplicacion_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($caja_chica_aplicacion->Export == "") { ?>
<script type="text/javascript">
fcaja_chica_aplicaciongrid.Init();
</script>
<?php } ?>
<?php
$caja_chica_aplicacion_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$caja_chica_aplicacion_grid->Page_Terminate();
?>
