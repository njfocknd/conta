<?php

// Create page object
if (!isset($proveedor_grid)) $proveedor_grid = new cproveedor_grid();

// Page init
$proveedor_grid->Page_Init();

// Page main
$proveedor_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$proveedor_grid->Page_Render();
?>
<?php if ($proveedor->Export == "") { ?>
<script type="text/javascript">

// Form object
var fproveedorgrid = new ew_Form("fproveedorgrid", "grid");
fproveedorgrid.FormKeyCountName = '<?php echo $proveedor_grid->FormKeyCountName ?>';

// Validate form
fproveedorgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idpersona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $proveedor->idpersona->FldCaption(), $proveedor->idpersona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $proveedor->estado->FldCaption(), $proveedor->estado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_insercion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($proveedor->fecha_insercion->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fproveedorgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "codigo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nit", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "direccion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpersona", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha_insercion", false)) return false;
	return true;
}

// Form_CustomValidate event
fproveedorgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fproveedorgrid.ValidateRequired = true;
<?php } else { ?>
fproveedorgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fproveedorgrid.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproveedorgrid.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fproveedorgrid.Lists["x_estado"].Options = <?php echo json_encode($proveedor->estado->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($proveedor->CurrentAction == "gridadd") {
	if ($proveedor->CurrentMode == "copy") {
		$bSelectLimit = $proveedor_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$proveedor_grid->TotalRecs = $proveedor->SelectRecordCount();
			$proveedor_grid->Recordset = $proveedor_grid->LoadRecordset($proveedor_grid->StartRec-1, $proveedor_grid->DisplayRecs);
		} else {
			if ($proveedor_grid->Recordset = $proveedor_grid->LoadRecordset())
				$proveedor_grid->TotalRecs = $proveedor_grid->Recordset->RecordCount();
		}
		$proveedor_grid->StartRec = 1;
		$proveedor_grid->DisplayRecs = $proveedor_grid->TotalRecs;
	} else {
		$proveedor->CurrentFilter = "0=1";
		$proveedor_grid->StartRec = 1;
		$proveedor_grid->DisplayRecs = $proveedor->GridAddRowCount;
	}
	$proveedor_grid->TotalRecs = $proveedor_grid->DisplayRecs;
	$proveedor_grid->StopRec = $proveedor_grid->DisplayRecs;
} else {
	$bSelectLimit = $proveedor_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($proveedor_grid->TotalRecs <= 0)
			$proveedor_grid->TotalRecs = $proveedor->SelectRecordCount();
	} else {
		if (!$proveedor_grid->Recordset && ($proveedor_grid->Recordset = $proveedor_grid->LoadRecordset()))
			$proveedor_grid->TotalRecs = $proveedor_grid->Recordset->RecordCount();
	}
	$proveedor_grid->StartRec = 1;
	$proveedor_grid->DisplayRecs = $proveedor_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$proveedor_grid->Recordset = $proveedor_grid->LoadRecordset($proveedor_grid->StartRec-1, $proveedor_grid->DisplayRecs);

	// Set no record found message
	if ($proveedor->CurrentAction == "" && $proveedor_grid->TotalRecs == 0) {
		if ($proveedor_grid->SearchWhere == "0=101")
			$proveedor_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$proveedor_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$proveedor_grid->RenderOtherOptions();
?>
<?php $proveedor_grid->ShowPageHeader(); ?>
<?php
$proveedor_grid->ShowMessage();
?>
<?php if ($proveedor_grid->TotalRecs > 0 || $proveedor->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fproveedorgrid" class="ewForm form-inline">
<div id="gmp_proveedor" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_proveedorgrid" class="table ewTable">
<?php echo $proveedor->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$proveedor_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$proveedor_grid->RenderListOptions();

// Render list options (header, left)
$proveedor_grid->ListOptions->Render("header", "left");
?>
<?php if ($proveedor->codigo->Visible) { // codigo ?>
	<?php if ($proveedor->SortUrl($proveedor->codigo) == "") { ?>
		<th data-name="codigo"><div id="elh_proveedor_codigo" class="proveedor_codigo"><div class="ewTableHeaderCaption"><?php echo $proveedor->codigo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="codigo"><div><div id="elh_proveedor_codigo" class="proveedor_codigo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->codigo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->codigo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->codigo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->nit->Visible) { // nit ?>
	<?php if ($proveedor->SortUrl($proveedor->nit) == "") { ?>
		<th data-name="nit"><div id="elh_proveedor_nit" class="proveedor_nit"><div class="ewTableHeaderCaption"><?php echo $proveedor->nit->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nit"><div><div id="elh_proveedor_nit" class="proveedor_nit">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->nit->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->nit->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->nit->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->nombre->Visible) { // nombre ?>
	<?php if ($proveedor->SortUrl($proveedor->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_proveedor_nombre" class="proveedor_nombre"><div class="ewTableHeaderCaption"><?php echo $proveedor->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_proveedor_nombre" class="proveedor_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->direccion->Visible) { // direccion ?>
	<?php if ($proveedor->SortUrl($proveedor->direccion) == "") { ?>
		<th data-name="direccion"><div id="elh_proveedor_direccion" class="proveedor_direccion"><div class="ewTableHeaderCaption"><?php echo $proveedor->direccion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="direccion"><div><div id="elh_proveedor_direccion" class="proveedor_direccion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->direccion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->direccion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->direccion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
	<?php if ($proveedor->SortUrl($proveedor->idpersona) == "") { ?>
		<th data-name="idpersona"><div id="elh_proveedor_idpersona" class="proveedor_idpersona"><div class="ewTableHeaderCaption"><?php echo $proveedor->idpersona->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpersona"><div><div id="elh_proveedor_idpersona" class="proveedor_idpersona">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->idpersona->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->idpersona->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->idpersona->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->estado->Visible) { // estado ?>
	<?php if ($proveedor->SortUrl($proveedor->estado) == "") { ?>
		<th data-name="estado"><div id="elh_proveedor_estado" class="proveedor_estado"><div class="ewTableHeaderCaption"><?php echo $proveedor->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_proveedor_estado" class="proveedor_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($proveedor->fecha_insercion->Visible) { // fecha_insercion ?>
	<?php if ($proveedor->SortUrl($proveedor->fecha_insercion) == "") { ?>
		<th data-name="fecha_insercion"><div id="elh_proveedor_fecha_insercion" class="proveedor_fecha_insercion"><div class="ewTableHeaderCaption"><?php echo $proveedor->fecha_insercion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha_insercion"><div><div id="elh_proveedor_fecha_insercion" class="proveedor_fecha_insercion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $proveedor->fecha_insercion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($proveedor->fecha_insercion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($proveedor->fecha_insercion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$proveedor_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$proveedor_grid->StartRec = 1;
$proveedor_grid->StopRec = $proveedor_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($proveedor_grid->FormKeyCountName) && ($proveedor->CurrentAction == "gridadd" || $proveedor->CurrentAction == "gridedit" || $proveedor->CurrentAction == "F")) {
		$proveedor_grid->KeyCount = $objForm->GetValue($proveedor_grid->FormKeyCountName);
		$proveedor_grid->StopRec = $proveedor_grid->StartRec + $proveedor_grid->KeyCount - 1;
	}
}
$proveedor_grid->RecCnt = $proveedor_grid->StartRec - 1;
if ($proveedor_grid->Recordset && !$proveedor_grid->Recordset->EOF) {
	$proveedor_grid->Recordset->MoveFirst();
	$bSelectLimit = $proveedor_grid->UseSelectLimit;
	if (!$bSelectLimit && $proveedor_grid->StartRec > 1)
		$proveedor_grid->Recordset->Move($proveedor_grid->StartRec - 1);
} elseif (!$proveedor->AllowAddDeleteRow && $proveedor_grid->StopRec == 0) {
	$proveedor_grid->StopRec = $proveedor->GridAddRowCount;
}

// Initialize aggregate
$proveedor->RowType = EW_ROWTYPE_AGGREGATEINIT;
$proveedor->ResetAttrs();
$proveedor_grid->RenderRow();
if ($proveedor->CurrentAction == "gridadd")
	$proveedor_grid->RowIndex = 0;
if ($proveedor->CurrentAction == "gridedit")
	$proveedor_grid->RowIndex = 0;
while ($proveedor_grid->RecCnt < $proveedor_grid->StopRec) {
	$proveedor_grid->RecCnt++;
	if (intval($proveedor_grid->RecCnt) >= intval($proveedor_grid->StartRec)) {
		$proveedor_grid->RowCnt++;
		if ($proveedor->CurrentAction == "gridadd" || $proveedor->CurrentAction == "gridedit" || $proveedor->CurrentAction == "F") {
			$proveedor_grid->RowIndex++;
			$objForm->Index = $proveedor_grid->RowIndex;
			if ($objForm->HasValue($proveedor_grid->FormActionName))
				$proveedor_grid->RowAction = strval($objForm->GetValue($proveedor_grid->FormActionName));
			elseif ($proveedor->CurrentAction == "gridadd")
				$proveedor_grid->RowAction = "insert";
			else
				$proveedor_grid->RowAction = "";
		}

		// Set up key count
		$proveedor_grid->KeyCount = $proveedor_grid->RowIndex;

		// Init row class and style
		$proveedor->ResetAttrs();
		$proveedor->CssClass = "";
		if ($proveedor->CurrentAction == "gridadd") {
			if ($proveedor->CurrentMode == "copy") {
				$proveedor_grid->LoadRowValues($proveedor_grid->Recordset); // Load row values
				$proveedor_grid->SetRecordKey($proveedor_grid->RowOldKey, $proveedor_grid->Recordset); // Set old record key
			} else {
				$proveedor_grid->LoadDefaultValues(); // Load default values
				$proveedor_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$proveedor_grid->LoadRowValues($proveedor_grid->Recordset); // Load row values
		}
		$proveedor->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($proveedor->CurrentAction == "gridadd") // Grid add
			$proveedor->RowType = EW_ROWTYPE_ADD; // Render add
		if ($proveedor->CurrentAction == "gridadd" && $proveedor->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
		if ($proveedor->CurrentAction == "gridedit") { // Grid edit
			if ($proveedor->EventCancelled) {
				$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
			}
			if ($proveedor_grid->RowAction == "insert")
				$proveedor->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$proveedor->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($proveedor->CurrentAction == "gridedit" && ($proveedor->RowType == EW_ROWTYPE_EDIT || $proveedor->RowType == EW_ROWTYPE_ADD) && $proveedor->EventCancelled) // Update failed
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values
		if ($proveedor->RowType == EW_ROWTYPE_EDIT) // Edit row
			$proveedor_grid->EditRowCnt++;
		if ($proveedor->CurrentAction == "F") // Confirm row
			$proveedor_grid->RestoreCurrentRowFormValues($proveedor_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$proveedor->RowAttrs = array_merge($proveedor->RowAttrs, array('data-rowindex'=>$proveedor_grid->RowCnt, 'id'=>'r' . $proveedor_grid->RowCnt . '_proveedor', 'data-rowtype'=>$proveedor->RowType));

		// Render row
		$proveedor_grid->RenderRow();

		// Render list options
		$proveedor_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($proveedor_grid->RowAction <> "delete" && $proveedor_grid->RowAction <> "insertdelete" && !($proveedor_grid->RowAction == "insert" && $proveedor->CurrentAction == "F" && $proveedor_grid->EmptyRow())) {
?>
	<tr<?php echo $proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$proveedor_grid->ListOptions->Render("body", "left", $proveedor_grid->RowCnt);
?>
	<?php if ($proveedor->codigo->Visible) { // codigo ?>
		<td data-name="codigo"<?php echo $proveedor->codigo->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_codigo" class="form-group proveedor_codigo">
<input type="text" data-table="proveedor" data-field="x_codigo" name="x<?php echo $proveedor_grid->RowIndex ?>_codigo" id="x<?php echo $proveedor_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->codigo->getPlaceHolder()) ?>" value="<?php echo $proveedor->codigo->EditValue ?>"<?php echo $proveedor->codigo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="proveedor" data-field="x_codigo" name="o<?php echo $proveedor_grid->RowIndex ?>_codigo" id="o<?php echo $proveedor_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($proveedor->codigo->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_codigo" class="form-group proveedor_codigo">
<input type="text" data-table="proveedor" data-field="x_codigo" name="x<?php echo $proveedor_grid->RowIndex ?>_codigo" id="x<?php echo $proveedor_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->codigo->getPlaceHolder()) ?>" value="<?php echo $proveedor->codigo->EditValue ?>"<?php echo $proveedor->codigo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_codigo" class="proveedor_codigo">
<span<?php echo $proveedor->codigo->ViewAttributes() ?>>
<?php echo $proveedor->codigo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_codigo" name="x<?php echo $proveedor_grid->RowIndex ?>_codigo" id="x<?php echo $proveedor_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($proveedor->codigo->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_codigo" name="o<?php echo $proveedor_grid->RowIndex ?>_codigo" id="o<?php echo $proveedor_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($proveedor->codigo->OldValue) ?>">
<?php } ?>
<a id="<?php echo $proveedor_grid->PageObjName . "_row_" . $proveedor_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="proveedor" data-field="x_idproveedor" name="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->CurrentValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_idproveedor" name="o<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="o<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT || $proveedor->CurrentMode == "edit") { ?>
<input type="hidden" data-table="proveedor" data-field="x_idproveedor" name="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" id="x<?php echo $proveedor_grid->RowIndex ?>_idproveedor" value="<?php echo ew_HtmlEncode($proveedor->idproveedor->CurrentValue) ?>">
<?php } ?>
	<?php if ($proveedor->nit->Visible) { // nit ?>
		<td data-name="nit"<?php echo $proveedor->nit->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-table="proveedor" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->getPlaceHolder()) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-table="proveedor" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->getPlaceHolder()) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nit" class="proveedor_nit">
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<?php echo $proveedor->nit->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $proveedor->nombre->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nombre" class="form-group proveedor_nombre">
<input type="text" data-table="proveedor" data-field="x_nombre" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre->getPlaceHolder()) ?>" value="<?php echo $proveedor->nombre->EditValue ?>"<?php echo $proveedor->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nombre" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($proveedor->nombre->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nombre" class="form-group proveedor_nombre">
<input type="text" data-table="proveedor" data-field="x_nombre" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre->getPlaceHolder()) ?>" value="<?php echo $proveedor->nombre->EditValue ?>"<?php echo $proveedor->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_nombre" class="proveedor_nombre">
<span<?php echo $proveedor->nombre->ViewAttributes() ?>>
<?php echo $proveedor->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nombre" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($proveedor->nombre->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_nombre" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($proveedor->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->direccion->Visible) { // direccion ?>
		<td data-name="direccion"<?php echo $proveedor->direccion->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_direccion" class="form-group proveedor_direccion">
<input type="text" data-table="proveedor" data-field="x_direccion" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion->getPlaceHolder()) ?>" value="<?php echo $proveedor->direccion->EditValue ?>"<?php echo $proveedor->direccion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="proveedor" data-field="x_direccion" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion" value="<?php echo ew_HtmlEncode($proveedor->direccion->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_direccion" class="form-group proveedor_direccion">
<input type="text" data-table="proveedor" data-field="x_direccion" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion->getPlaceHolder()) ?>" value="<?php echo $proveedor->direccion->EditValue ?>"<?php echo $proveedor->direccion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_direccion" class="proveedor_direccion">
<span<?php echo $proveedor->direccion->ViewAttributes() ?>>
<?php echo $proveedor->direccion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_direccion" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion" value="<?php echo ew_HtmlEncode($proveedor->direccion->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_direccion" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion" value="<?php echo ew_HtmlEncode($proveedor->direccion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
		<td data-name="idpersona"<?php echo $proveedor->idpersona->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($proveedor->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_idpersona" class="form-group proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_idpersona" class="form-group proveedor_idpersona">
<select data-table="proveedor" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->idpersona->DisplayValueSeparator) ? json_encode($proveedor->idpersona->DisplayValueSeparator) : $proveedor->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona"<?php echo $proveedor->idpersona->EditAttributes() ?>>
<?php
if (is_array($proveedor->idpersona->EditValue)) {
	$arwrk = $proveedor->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($proveedor->idpersona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $proveedor->idpersona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($proveedor->idpersona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>" selected><?php echo $proveedor->idpersona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $proveedor->idpersona->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$proveedor->idpersona->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$proveedor->idpersona->LookupFilters += array("f0" => "`idpersona` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$proveedor->Lookup_Selecting($proveedor->idpersona, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $proveedor->idpersona->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo $proveedor->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_idpersona" name="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($proveedor->idpersona->getSessionValue() <> "") { ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_idpersona" class="form-group proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_idpersona" class="form-group proveedor_idpersona">
<select data-table="proveedor" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->idpersona->DisplayValueSeparator) ? json_encode($proveedor->idpersona->DisplayValueSeparator) : $proveedor->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona"<?php echo $proveedor->idpersona->EditAttributes() ?>>
<?php
if (is_array($proveedor->idpersona->EditValue)) {
	$arwrk = $proveedor->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($proveedor->idpersona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $proveedor->idpersona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($proveedor->idpersona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>" selected><?php echo $proveedor->idpersona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $proveedor->idpersona->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$proveedor->idpersona->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$proveedor->idpersona->LookupFilters += array("f0" => "`idpersona` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$proveedor->Lookup_Selecting($proveedor->idpersona, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $proveedor->idpersona->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo $proveedor->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_idpersona" class="proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<?php echo $proveedor->idpersona->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_idpersona" name="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $proveedor->estado->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_estado" class="form-group proveedor_estado">
<div id="tp_x<?php echo $proveedor_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="proveedor" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->estado->DisplayValueSeparator) ? json_encode($proveedor->estado->DisplayValueSeparator) : $proveedor->estado->DisplayValueSeparator) ?>" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado" value="{value}"<?php echo $proveedor->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $proveedor_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $proveedor->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($proveedor->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($proveedor->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($proveedor->estado->CurrentValue) ?>" checked<?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $proveedor->estado->OldValue = "";
?>
</div></div>
</span>
<input type="hidden" data-table="proveedor" data-field="x_estado" name="o<?php echo $proveedor_grid->RowIndex ?>_estado" id="o<?php echo $proveedor_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($proveedor->estado->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_estado" class="form-group proveedor_estado">
<div id="tp_x<?php echo $proveedor_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="proveedor" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->estado->DisplayValueSeparator) ? json_encode($proveedor->estado->DisplayValueSeparator) : $proveedor->estado->DisplayValueSeparator) ?>" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado" value="{value}"<?php echo $proveedor->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $proveedor_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $proveedor->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($proveedor->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($proveedor->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($proveedor->estado->CurrentValue) ?>" checked<?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $proveedor->estado->OldValue = "";
?>
</div></div>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_estado" class="proveedor_estado">
<span<?php echo $proveedor->estado->ViewAttributes() ?>>
<?php echo $proveedor->estado->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($proveedor->estado->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_estado" name="o<?php echo $proveedor_grid->RowIndex ?>_estado" id="o<?php echo $proveedor_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($proveedor->estado->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($proveedor->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion"<?php echo $proveedor->fecha_insercion->CellAttributes() ?>>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_fecha_insercion" class="form-group proveedor_fecha_insercion">
<input type="text" data-table="proveedor" data-field="x_fecha_insercion" data-format="7" name="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $proveedor->fecha_insercion->EditValue ?>"<?php echo $proveedor->fecha_insercion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="proveedor" data-field="x_fecha_insercion" name="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->OldValue) ?>">
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_fecha_insercion" class="form-group proveedor_fecha_insercion">
<input type="text" data-table="proveedor" data-field="x_fecha_insercion" data-format="7" name="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $proveedor->fecha_insercion->EditValue ?>"<?php echo $proveedor->fecha_insercion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($proveedor->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $proveedor_grid->RowCnt ?>_proveedor_fecha_insercion" class="proveedor_fecha_insercion">
<span<?php echo $proveedor->fecha_insercion->ViewAttributes() ?>>
<?php echo $proveedor->fecha_insercion->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_fecha_insercion" name="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->FormValue) ?>">
<input type="hidden" data-table="proveedor" data-field="x_fecha_insercion" name="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$proveedor_grid->ListOptions->Render("body", "right", $proveedor_grid->RowCnt);
?>
	</tr>
<?php if ($proveedor->RowType == EW_ROWTYPE_ADD || $proveedor->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fproveedorgrid.UpdateOpts(<?php echo $proveedor_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($proveedor->CurrentAction <> "gridadd" || $proveedor->CurrentMode == "copy")
		if (!$proveedor_grid->Recordset->EOF) $proveedor_grid->Recordset->MoveNext();
}
?>
<?php
	if ($proveedor->CurrentMode == "add" || $proveedor->CurrentMode == "copy" || $proveedor->CurrentMode == "edit") {
		$proveedor_grid->RowIndex = '$rowindex$';
		$proveedor_grid->LoadDefaultValues();

		// Set row properties
		$proveedor->ResetAttrs();
		$proveedor->RowAttrs = array_merge($proveedor->RowAttrs, array('data-rowindex'=>$proveedor_grid->RowIndex, 'id'=>'r0_proveedor', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($proveedor->RowAttrs["class"], "ewTemplate");
		$proveedor->RowType = EW_ROWTYPE_ADD;

		// Render row
		$proveedor_grid->RenderRow();

		// Render list options
		$proveedor_grid->RenderListOptions();
		$proveedor_grid->StartRowCnt = 0;
?>
	<tr<?php echo $proveedor->RowAttributes() ?>>
<?php

// Render list options (body, left)
$proveedor_grid->ListOptions->Render("body", "left", $proveedor_grid->RowIndex);
?>
	<?php if ($proveedor->codigo->Visible) { // codigo ?>
		<td data-name="codigo">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_codigo" class="form-group proveedor_codigo">
<input type="text" data-table="proveedor" data-field="x_codigo" name="x<?php echo $proveedor_grid->RowIndex ?>_codigo" id="x<?php echo $proveedor_grid->RowIndex ?>_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->codigo->getPlaceHolder()) ?>" value="<?php echo $proveedor->codigo->EditValue ?>"<?php echo $proveedor->codigo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_codigo" class="form-group proveedor_codigo">
<span<?php echo $proveedor->codigo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->codigo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_codigo" name="x<?php echo $proveedor_grid->RowIndex ?>_codigo" id="x<?php echo $proveedor_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($proveedor->codigo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_codigo" name="o<?php echo $proveedor_grid->RowIndex ?>_codigo" id="o<?php echo $proveedor_grid->RowIndex ?>_codigo" value="<?php echo ew_HtmlEncode($proveedor->codigo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->nit->Visible) { // nit ?>
		<td data-name="nit">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_nit" class="form-group proveedor_nit">
<input type="text" data-table="proveedor" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nit->getPlaceHolder()) ?>" value="<?php echo $proveedor->nit->EditValue ?>"<?php echo $proveedor->nit->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_nit" class="form-group proveedor_nit">
<span<?php echo $proveedor->nit->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->nit->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nit" name="x<?php echo $proveedor_grid->RowIndex ?>_nit" id="x<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_nit" name="o<?php echo $proveedor_grid->RowIndex ?>_nit" id="o<?php echo $proveedor_grid->RowIndex ?>_nit" value="<?php echo ew_HtmlEncode($proveedor->nit->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_nombre" class="form-group proveedor_nombre">
<input type="text" data-table="proveedor" data-field="x_nombre" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->nombre->getPlaceHolder()) ?>" value="<?php echo $proveedor->nombre->EditValue ?>"<?php echo $proveedor->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_nombre" class="form-group proveedor_nombre">
<span<?php echo $proveedor->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_nombre" name="x<?php echo $proveedor_grid->RowIndex ?>_nombre" id="x<?php echo $proveedor_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($proveedor->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_nombre" name="o<?php echo $proveedor_grid->RowIndex ?>_nombre" id="o<?php echo $proveedor_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($proveedor->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->direccion->Visible) { // direccion ?>
		<td data-name="direccion">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_direccion" class="form-group proveedor_direccion">
<input type="text" data-table="proveedor" data-field="x_direccion" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($proveedor->direccion->getPlaceHolder()) ?>" value="<?php echo $proveedor->direccion->EditValue ?>"<?php echo $proveedor->direccion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_direccion" class="form-group proveedor_direccion">
<span<?php echo $proveedor->direccion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->direccion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_direccion" name="x<?php echo $proveedor_grid->RowIndex ?>_direccion" id="x<?php echo $proveedor_grid->RowIndex ?>_direccion" value="<?php echo ew_HtmlEncode($proveedor->direccion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_direccion" name="o<?php echo $proveedor_grid->RowIndex ?>_direccion" id="o<?php echo $proveedor_grid->RowIndex ?>_direccion" value="<?php echo ew_HtmlEncode($proveedor->direccion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->idpersona->Visible) { // idpersona ?>
		<td data-name="idpersona">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<?php if ($proveedor->idpersona->getSessionValue() <> "") { ?>
<span id="el$rowindex$_proveedor_idpersona" class="form-group proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_proveedor_idpersona" class="form-group proveedor_idpersona">
<select data-table="proveedor" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->idpersona->DisplayValueSeparator) ? json_encode($proveedor->idpersona->DisplayValueSeparator) : $proveedor->idpersona->DisplayValueSeparator) ?>" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona"<?php echo $proveedor->idpersona->EditAttributes() ?>>
<?php
if (is_array($proveedor->idpersona->EditValue)) {
	$arwrk = $proveedor->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($proveedor->idpersona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $proveedor->idpersona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($proveedor->idpersona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($proveedor->idpersona->CurrentValue) ?>" selected><?php echo $proveedor->idpersona->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $proveedor->idpersona->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$proveedor->idpersona->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$proveedor->idpersona->LookupFilters += array("f0" => "`idpersona` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$proveedor->Lookup_Selecting($proveedor->idpersona, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $proveedor->idpersona->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="s_x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo $proveedor->idpersona->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_proveedor_idpersona" class="form-group proveedor_idpersona">
<span<?php echo $proveedor->idpersona->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->idpersona->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_idpersona" name="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="x<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_idpersona" name="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" id="o<?php echo $proveedor_grid->RowIndex ?>_idpersona" value="<?php echo ew_HtmlEncode($proveedor->idpersona->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->estado->Visible) { // estado ?>
		<td data-name="estado">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_estado" class="form-group proveedor_estado">
<div id="tp_x<?php echo $proveedor_grid->RowIndex ?>_estado" class="ewTemplate"><input type="radio" data-table="proveedor" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($proveedor->estado->DisplayValueSeparator) ? json_encode($proveedor->estado->DisplayValueSeparator) : $proveedor->estado->DisplayValueSeparator) ?>" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado" value="{value}"<?php echo $proveedor->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $proveedor_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $proveedor->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($proveedor->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($proveedor->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($proveedor->estado->CurrentValue) ?>" checked<?php echo $proveedor->estado->EditAttributes() ?>><?php echo $proveedor->estado->CurrentValue ?></label>
<?php
    }
}
if (@$emptywrk) $proveedor->estado->OldValue = "";
?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_estado" class="form-group proveedor_estado">
<span<?php echo $proveedor->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_estado" name="x<?php echo $proveedor_grid->RowIndex ?>_estado" id="x<?php echo $proveedor_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($proveedor->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_estado" name="o<?php echo $proveedor_grid->RowIndex ?>_estado" id="o<?php echo $proveedor_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($proveedor->estado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($proveedor->fecha_insercion->Visible) { // fecha_insercion ?>
		<td data-name="fecha_insercion">
<?php if ($proveedor->CurrentAction <> "F") { ?>
<span id="el$rowindex$_proveedor_fecha_insercion" class="form-group proveedor_fecha_insercion">
<input type="text" data-table="proveedor" data-field="x_fecha_insercion" data-format="7" name="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" placeholder="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->getPlaceHolder()) ?>" value="<?php echo $proveedor->fecha_insercion->EditValue ?>"<?php echo $proveedor->fecha_insercion->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_proveedor_fecha_insercion" class="form-group proveedor_fecha_insercion">
<span<?php echo $proveedor->fecha_insercion->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $proveedor->fecha_insercion->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="proveedor" data-field="x_fecha_insercion" name="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="x<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="proveedor" data-field="x_fecha_insercion" name="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" id="o<?php echo $proveedor_grid->RowIndex ?>_fecha_insercion" value="<?php echo ew_HtmlEncode($proveedor->fecha_insercion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$proveedor_grid->ListOptions->Render("body", "right", $proveedor_grid->RowCnt);
?>
<script type="text/javascript">
fproveedorgrid.UpdateOpts(<?php echo $proveedor_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($proveedor->CurrentMode == "add" || $proveedor->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $proveedor_grid->FormKeyCountName ?>" id="<?php echo $proveedor_grid->FormKeyCountName ?>" value="<?php echo $proveedor_grid->KeyCount ?>">
<?php echo $proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($proveedor->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $proveedor_grid->FormKeyCountName ?>" id="<?php echo $proveedor_grid->FormKeyCountName ?>" value="<?php echo $proveedor_grid->KeyCount ?>">
<?php echo $proveedor_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($proveedor->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fproveedorgrid">
</div>
<?php

// Close recordset
if ($proveedor_grid->Recordset)
	$proveedor_grid->Recordset->Close();
?>
<?php if ($proveedor_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($proveedor_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($proveedor_grid->TotalRecs == 0 && $proveedor->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($proveedor_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($proveedor->Export == "") { ?>
<script type="text/javascript">
fproveedorgrid.Init();
</script>
<?php } ?>
<?php
$proveedor_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$proveedor_grid->Page_Terminate();
?>
