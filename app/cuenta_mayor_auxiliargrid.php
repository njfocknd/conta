<?php

// Create page object
if (!isset($cuenta_mayor_auxiliar_grid)) $cuenta_mayor_auxiliar_grid = new ccuenta_mayor_auxiliar_grid();

// Page init
$cuenta_mayor_auxiliar_grid->Page_Init();

// Page main
$cuenta_mayor_auxiliar_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_mayor_auxiliar_grid->Page_Render();
?>
<?php if ($cuenta_mayor_auxiliar->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcuenta_mayor_auxiliargrid = new ew_Form("fcuenta_mayor_auxiliargrid", "grid");
fcuenta_mayor_auxiliargrid.FormKeyCountName = '<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>';

// Validate form
fcuenta_mayor_auxiliargrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nomenclatura->FldCaption(), $cuenta_mayor_auxiliar->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nombre->FldCaption(), $cuenta_mayor_auxiliar->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_principal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption(), $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcuenta_mayor_auxiliargrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_principal", false)) return false;
	return true;
}

// Form_CustomValidate event
fcuenta_mayor_auxiliargrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_mayor_auxiliargrid.ValidateRequired = true;
<?php } else { ?>
fcuenta_mayor_auxiliargrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_mayor_auxiliargrid.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") {
	if ($cuenta_mayor_auxiliar->CurrentMode == "copy") {
		$bSelectLimit = $cuenta_mayor_auxiliar_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar->SelectRecordCount();
			$cuenta_mayor_auxiliar_grid->Recordset = $cuenta_mayor_auxiliar_grid->LoadRecordset($cuenta_mayor_auxiliar_grid->StartRec-1, $cuenta_mayor_auxiliar_grid->DisplayRecs);
		} else {
			if ($cuenta_mayor_auxiliar_grid->Recordset = $cuenta_mayor_auxiliar_grid->LoadRecordset())
				$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar_grid->Recordset->RecordCount();
		}
		$cuenta_mayor_auxiliar_grid->StartRec = 1;
		$cuenta_mayor_auxiliar_grid->DisplayRecs = $cuenta_mayor_auxiliar_grid->TotalRecs;
	} else {
		$cuenta_mayor_auxiliar->CurrentFilter = "0=1";
		$cuenta_mayor_auxiliar_grid->StartRec = 1;
		$cuenta_mayor_auxiliar_grid->DisplayRecs = $cuenta_mayor_auxiliar->GridAddRowCount;
	}
	$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar_grid->DisplayRecs;
	$cuenta_mayor_auxiliar_grid->StopRec = $cuenta_mayor_auxiliar_grid->DisplayRecs;
} else {
	$bSelectLimit = $cuenta_mayor_auxiliar_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cuenta_mayor_auxiliar_grid->TotalRecs <= 0)
			$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar->SelectRecordCount();
	} else {
		if (!$cuenta_mayor_auxiliar_grid->Recordset && ($cuenta_mayor_auxiliar_grid->Recordset = $cuenta_mayor_auxiliar_grid->LoadRecordset()))
			$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar_grid->Recordset->RecordCount();
	}
	$cuenta_mayor_auxiliar_grid->StartRec = 1;
	$cuenta_mayor_auxiliar_grid->DisplayRecs = $cuenta_mayor_auxiliar_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$cuenta_mayor_auxiliar_grid->Recordset = $cuenta_mayor_auxiliar_grid->LoadRecordset($cuenta_mayor_auxiliar_grid->StartRec-1, $cuenta_mayor_auxiliar_grid->DisplayRecs);

	// Set no record found message
	if ($cuenta_mayor_auxiliar->CurrentAction == "" && $cuenta_mayor_auxiliar_grid->TotalRecs == 0) {
		if ($cuenta_mayor_auxiliar_grid->SearchWhere == "0=101")
			$cuenta_mayor_auxiliar_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cuenta_mayor_auxiliar_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cuenta_mayor_auxiliar_grid->RenderOtherOptions();
?>
<?php $cuenta_mayor_auxiliar_grid->ShowPageHeader(); ?>
<?php
$cuenta_mayor_auxiliar_grid->ShowMessage();
?>
<?php if ($cuenta_mayor_auxiliar_grid->TotalRecs > 0 || $cuenta_mayor_auxiliar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fcuenta_mayor_auxiliargrid" class="ewForm form-inline">
<?php if ($cuenta_mayor_auxiliar_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($cuenta_mayor_auxiliar_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_cuenta_mayor_auxiliar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_cuenta_mayor_auxiliargrid" class="table ewTable">
<?php echo $cuenta_mayor_auxiliar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$cuenta_mayor_auxiliar_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cuenta_mayor_auxiliar_grid->RenderListOptions();

// Render list options (header, left)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("header", "left");
?>
<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div><div id="elh_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->idcuenta_mayor_principal) == "") { ?>
		<th data-name="idcuenta_mayor_principal"><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_principal"><div><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$cuenta_mayor_auxiliar_grid->StartRec = 1;
$cuenta_mayor_auxiliar_grid->StopRec = $cuenta_mayor_auxiliar_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cuenta_mayor_auxiliar_grid->FormKeyCountName) && ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" || $cuenta_mayor_auxiliar->CurrentAction == "gridedit" || $cuenta_mayor_auxiliar->CurrentAction == "F")) {
		$cuenta_mayor_auxiliar_grid->KeyCount = $objForm->GetValue($cuenta_mayor_auxiliar_grid->FormKeyCountName);
		$cuenta_mayor_auxiliar_grid->StopRec = $cuenta_mayor_auxiliar_grid->StartRec + $cuenta_mayor_auxiliar_grid->KeyCount - 1;
	}
}
$cuenta_mayor_auxiliar_grid->RecCnt = $cuenta_mayor_auxiliar_grid->StartRec - 1;
if ($cuenta_mayor_auxiliar_grid->Recordset && !$cuenta_mayor_auxiliar_grid->Recordset->EOF) {
	$cuenta_mayor_auxiliar_grid->Recordset->MoveFirst();
	$bSelectLimit = $cuenta_mayor_auxiliar_grid->UseSelectLimit;
	if (!$bSelectLimit && $cuenta_mayor_auxiliar_grid->StartRec > 1)
		$cuenta_mayor_auxiliar_grid->Recordset->Move($cuenta_mayor_auxiliar_grid->StartRec - 1);
} elseif (!$cuenta_mayor_auxiliar->AllowAddDeleteRow && $cuenta_mayor_auxiliar_grid->StopRec == 0) {
	$cuenta_mayor_auxiliar_grid->StopRec = $cuenta_mayor_auxiliar->GridAddRowCount;
}

// Initialize aggregate
$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cuenta_mayor_auxiliar->ResetAttrs();
$cuenta_mayor_auxiliar_grid->RenderRow();
if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd")
	$cuenta_mayor_auxiliar_grid->RowIndex = 0;
if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit")
	$cuenta_mayor_auxiliar_grid->RowIndex = 0;
while ($cuenta_mayor_auxiliar_grid->RecCnt < $cuenta_mayor_auxiliar_grid->StopRec) {
	$cuenta_mayor_auxiliar_grid->RecCnt++;
	if (intval($cuenta_mayor_auxiliar_grid->RecCnt) >= intval($cuenta_mayor_auxiliar_grid->StartRec)) {
		$cuenta_mayor_auxiliar_grid->RowCnt++;
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" || $cuenta_mayor_auxiliar->CurrentAction == "gridedit" || $cuenta_mayor_auxiliar->CurrentAction == "F") {
			$cuenta_mayor_auxiliar_grid->RowIndex++;
			$objForm->Index = $cuenta_mayor_auxiliar_grid->RowIndex;
			if ($objForm->HasValue($cuenta_mayor_auxiliar_grid->FormActionName))
				$cuenta_mayor_auxiliar_grid->RowAction = strval($objForm->GetValue($cuenta_mayor_auxiliar_grid->FormActionName));
			elseif ($cuenta_mayor_auxiliar->CurrentAction == "gridadd")
				$cuenta_mayor_auxiliar_grid->RowAction = "insert";
			else
				$cuenta_mayor_auxiliar_grid->RowAction = "";
		}

		// Set up key count
		$cuenta_mayor_auxiliar_grid->KeyCount = $cuenta_mayor_auxiliar_grid->RowIndex;

		// Init row class and style
		$cuenta_mayor_auxiliar->ResetAttrs();
		$cuenta_mayor_auxiliar->CssClass = "";
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") {
			if ($cuenta_mayor_auxiliar->CurrentMode == "copy") {
				$cuenta_mayor_auxiliar_grid->LoadRowValues($cuenta_mayor_auxiliar_grid->Recordset); // Load row values
				$cuenta_mayor_auxiliar_grid->SetRecordKey($cuenta_mayor_auxiliar_grid->RowOldKey, $cuenta_mayor_auxiliar_grid->Recordset); // Set old record key
			} else {
				$cuenta_mayor_auxiliar_grid->LoadDefaultValues(); // Load default values
				$cuenta_mayor_auxiliar_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$cuenta_mayor_auxiliar_grid->LoadRowValues($cuenta_mayor_auxiliar_grid->Recordset); // Load row values
		}
		$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") // Grid add
			$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" && $cuenta_mayor_auxiliar->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cuenta_mayor_auxiliar_grid->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_grid->RowIndex); // Restore form values
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit") { // Grid edit
			if ($cuenta_mayor_auxiliar->EventCancelled) {
				$cuenta_mayor_auxiliar_grid->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_grid->RowIndex); // Restore form values
			}
			if ($cuenta_mayor_auxiliar_grid->RowAction == "insert")
				$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit" && ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT || $cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) && $cuenta_mayor_auxiliar->EventCancelled) // Update failed
			$cuenta_mayor_auxiliar_grid->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_grid->RowIndex); // Restore form values
		if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cuenta_mayor_auxiliar_grid->EditRowCnt++;
		if ($cuenta_mayor_auxiliar->CurrentAction == "F") // Confirm row
			$cuenta_mayor_auxiliar_grid->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$cuenta_mayor_auxiliar->RowAttrs = array_merge($cuenta_mayor_auxiliar->RowAttrs, array('data-rowindex'=>$cuenta_mayor_auxiliar_grid->RowCnt, 'id'=>'r' . $cuenta_mayor_auxiliar_grid->RowCnt . '_cuenta_mayor_auxiliar', 'data-rowtype'=>$cuenta_mayor_auxiliar->RowType));

		// Render row
		$cuenta_mayor_auxiliar_grid->RenderRow();

		// Render list options
		$cuenta_mayor_auxiliar_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cuenta_mayor_auxiliar_grid->RowAction <> "delete" && $cuenta_mayor_auxiliar_grid->RowAction <> "insertdelete" && !($cuenta_mayor_auxiliar_grid->RowAction == "insert" && $cuenta_mayor_auxiliar->CurrentAction == "F" && $cuenta_mayor_auxiliar_grid->EmptyRow())) {
?>
	<tr<?php echo $cuenta_mayor_auxiliar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("body", "left", $cuenta_mayor_auxiliar_grid->RowCnt);
?>
	<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $cuenta_mayor_auxiliar->nomenclatura->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura">
<span<?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nomenclatura->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->FormValue) ?>">
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cuenta_mayor_auxiliar_grid->PageObjName . "_row_" . $cuenta_mayor_auxiliar_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT || $cuenta_mayor_auxiliar->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $cuenta_mayor_auxiliar->nombre->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->FormValue) ?>">
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->FormValue) ?>">
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("body", "right", $cuenta_mayor_auxiliar_grid->RowCnt);
?>
	</tr>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD || $cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcuenta_mayor_auxiliargrid.UpdateOpts(<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cuenta_mayor_auxiliar->CurrentAction <> "gridadd" || $cuenta_mayor_auxiliar->CurrentMode == "copy")
		if (!$cuenta_mayor_auxiliar_grid->Recordset->EOF) $cuenta_mayor_auxiliar_grid->Recordset->MoveNext();
}
?>
<?php
	if ($cuenta_mayor_auxiliar->CurrentMode == "add" || $cuenta_mayor_auxiliar->CurrentMode == "copy" || $cuenta_mayor_auxiliar->CurrentMode == "edit") {
		$cuenta_mayor_auxiliar_grid->RowIndex = '$rowindex$';
		$cuenta_mayor_auxiliar_grid->LoadDefaultValues();

		// Set row properties
		$cuenta_mayor_auxiliar->ResetAttrs();
		$cuenta_mayor_auxiliar->RowAttrs = array_merge($cuenta_mayor_auxiliar->RowAttrs, array('data-rowindex'=>$cuenta_mayor_auxiliar_grid->RowIndex, 'id'=>'r0_cuenta_mayor_auxiliar', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cuenta_mayor_auxiliar->RowAttrs["class"], "ewTemplate");
		$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cuenta_mayor_auxiliar_grid->RenderRow();

		// Render list options
		$cuenta_mayor_auxiliar_grid->RenderListOptions();
		$cuenta_mayor_auxiliar_grid->StartRowCnt = 0;
?>
	<tr<?php echo $cuenta_mayor_auxiliar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("body", "left", $cuenta_mayor_auxiliar_grid->RowIndex);
?>
	<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<span<?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal">
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("body", "right", $cuenta_mayor_auxiliar_grid->RowCnt);
?>
<script type="text/javascript">
fcuenta_mayor_auxiliargrid.UpdateOpts(<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($cuenta_mayor_auxiliar->CurrentMode == "add" || $cuenta_mayor_auxiliar->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>" id="<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>" value="<?php echo $cuenta_mayor_auxiliar_grid->KeyCount ?>">
<?php echo $cuenta_mayor_auxiliar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>" id="<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>" value="<?php echo $cuenta_mayor_auxiliar_grid->KeyCount ?>">
<?php echo $cuenta_mayor_auxiliar_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcuenta_mayor_auxiliargrid">
</div>
<?php

// Close recordset
if ($cuenta_mayor_auxiliar_grid->Recordset)
	$cuenta_mayor_auxiliar_grid->Recordset->Close();
?>
<?php if ($cuenta_mayor_auxiliar_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($cuenta_mayor_auxiliar_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar_grid->TotalRecs == 0 && $cuenta_mayor_auxiliar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_mayor_auxiliar_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->Export == "") { ?>
<script type="text/javascript">
fcuenta_mayor_auxiliargrid.Init();
</script>
<?php } ?>
<?php
$cuenta_mayor_auxiliar_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$cuenta_mayor_auxiliar_grid->Page_Terminate();
?>
