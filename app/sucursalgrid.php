<?php

// Create page object
if (!isset($sucursal_grid)) $sucursal_grid = new csucursal_grid();

// Page init
$sucursal_grid->Page_Init();

// Page main
$sucursal_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sucursal_grid->Page_Render();
?>
<?php if ($sucursal->Export == "") { ?>
<script type="text/javascript">

// Form object
var fsucursalgrid = new ew_Form("fsucursalgrid", "grid");
fsucursalgrid.FormKeyCountName = '<?php echo $sucursal_grid->FormKeyCountName ?>';

// Validate form
fsucursalgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_casa_matriz");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->casa_matriz->FldCaption(), $sucursal->casa_matriz->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idempresa->FldCaption(), $sucursal->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idpais->FldCaption(), $sucursal->idpais->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fsucursalgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "casa_matriz", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idpais", false)) return false;
	return true;
}

// Form_CustomValidate event
fsucursalgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsucursalgrid.ValidateRequired = true;
<?php } else { ?>
fsucursalgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsucursalgrid.Lists["x_casa_matriz"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsucursalgrid.Lists["x_casa_matriz"].Options = <?php echo json_encode($sucursal->casa_matriz->Options()) ?>;
fsucursalgrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsucursalgrid.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($sucursal->CurrentAction == "gridadd") {
	if ($sucursal->CurrentMode == "copy") {
		$bSelectLimit = $sucursal_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$sucursal_grid->TotalRecs = $sucursal->SelectRecordCount();
			$sucursal_grid->Recordset = $sucursal_grid->LoadRecordset($sucursal_grid->StartRec-1, $sucursal_grid->DisplayRecs);
		} else {
			if ($sucursal_grid->Recordset = $sucursal_grid->LoadRecordset())
				$sucursal_grid->TotalRecs = $sucursal_grid->Recordset->RecordCount();
		}
		$sucursal_grid->StartRec = 1;
		$sucursal_grid->DisplayRecs = $sucursal_grid->TotalRecs;
	} else {
		$sucursal->CurrentFilter = "0=1";
		$sucursal_grid->StartRec = 1;
		$sucursal_grid->DisplayRecs = $sucursal->GridAddRowCount;
	}
	$sucursal_grid->TotalRecs = $sucursal_grid->DisplayRecs;
	$sucursal_grid->StopRec = $sucursal_grid->DisplayRecs;
} else {
	$bSelectLimit = $sucursal_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($sucursal_grid->TotalRecs <= 0)
			$sucursal_grid->TotalRecs = $sucursal->SelectRecordCount();
	} else {
		if (!$sucursal_grid->Recordset && ($sucursal_grid->Recordset = $sucursal_grid->LoadRecordset()))
			$sucursal_grid->TotalRecs = $sucursal_grid->Recordset->RecordCount();
	}
	$sucursal_grid->StartRec = 1;
	$sucursal_grid->DisplayRecs = $sucursal_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$sucursal_grid->Recordset = $sucursal_grid->LoadRecordset($sucursal_grid->StartRec-1, $sucursal_grid->DisplayRecs);

	// Set no record found message
	if ($sucursal->CurrentAction == "" && $sucursal_grid->TotalRecs == 0) {
		if ($sucursal_grid->SearchWhere == "0=101")
			$sucursal_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$sucursal_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$sucursal_grid->RenderOtherOptions();
?>
<?php $sucursal_grid->ShowPageHeader(); ?>
<?php
$sucursal_grid->ShowMessage();
?>
<?php if ($sucursal_grid->TotalRecs > 0 || $sucursal->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fsucursalgrid" class="ewForm form-inline">
<div id="gmp_sucursal" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_sucursalgrid" class="table ewTable">
<?php echo $sucursal->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$sucursal_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$sucursal_grid->RenderListOptions();

// Render list options (header, left)
$sucursal_grid->ListOptions->Render("header", "left");
?>
<?php if ($sucursal->nombre->Visible) { // nombre ?>
	<?php if ($sucursal->SortUrl($sucursal->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_sucursal_nombre" class="sucursal_nombre"><div class="ewTableHeaderCaption"><?php echo $sucursal->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div><div id="elh_sucursal_nombre" class="sucursal_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($sucursal->casa_matriz->Visible) { // casa_matriz ?>
	<?php if ($sucursal->SortUrl($sucursal->casa_matriz) == "") { ?>
		<th data-name="casa_matriz"><div id="elh_sucursal_casa_matriz" class="sucursal_casa_matriz"><div class="ewTableHeaderCaption"><?php echo $sucursal->casa_matriz->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="casa_matriz"><div><div id="elh_sucursal_casa_matriz" class="sucursal_casa_matriz">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->casa_matriz->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->casa_matriz->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->casa_matriz->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
	<?php if ($sucursal->SortUrl($sucursal->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_sucursal_idempresa" class="sucursal_idempresa"><div class="ewTableHeaderCaption"><?php echo $sucursal->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_sucursal_idempresa" class="sucursal_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($sucursal->idpais->Visible) { // idpais ?>
	<?php if ($sucursal->SortUrl($sucursal->idpais) == "") { ?>
		<th data-name="idpais"><div id="elh_sucursal_idpais" class="sucursal_idpais"><div class="ewTableHeaderCaption"><?php echo $sucursal->idpais->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idpais"><div><div id="elh_sucursal_idpais" class="sucursal_idpais">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $sucursal->idpais->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($sucursal->idpais->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($sucursal->idpais->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$sucursal_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$sucursal_grid->StartRec = 1;
$sucursal_grid->StopRec = $sucursal_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($sucursal_grid->FormKeyCountName) && ($sucursal->CurrentAction == "gridadd" || $sucursal->CurrentAction == "gridedit" || $sucursal->CurrentAction == "F")) {
		$sucursal_grid->KeyCount = $objForm->GetValue($sucursal_grid->FormKeyCountName);
		$sucursal_grid->StopRec = $sucursal_grid->StartRec + $sucursal_grid->KeyCount - 1;
	}
}
$sucursal_grid->RecCnt = $sucursal_grid->StartRec - 1;
if ($sucursal_grid->Recordset && !$sucursal_grid->Recordset->EOF) {
	$sucursal_grid->Recordset->MoveFirst();
	$bSelectLimit = $sucursal_grid->UseSelectLimit;
	if (!$bSelectLimit && $sucursal_grid->StartRec > 1)
		$sucursal_grid->Recordset->Move($sucursal_grid->StartRec - 1);
} elseif (!$sucursal->AllowAddDeleteRow && $sucursal_grid->StopRec == 0) {
	$sucursal_grid->StopRec = $sucursal->GridAddRowCount;
}

// Initialize aggregate
$sucursal->RowType = EW_ROWTYPE_AGGREGATEINIT;
$sucursal->ResetAttrs();
$sucursal_grid->RenderRow();
if ($sucursal->CurrentAction == "gridadd")
	$sucursal_grid->RowIndex = 0;
if ($sucursal->CurrentAction == "gridedit")
	$sucursal_grid->RowIndex = 0;
while ($sucursal_grid->RecCnt < $sucursal_grid->StopRec) {
	$sucursal_grid->RecCnt++;
	if (intval($sucursal_grid->RecCnt) >= intval($sucursal_grid->StartRec)) {
		$sucursal_grid->RowCnt++;
		if ($sucursal->CurrentAction == "gridadd" || $sucursal->CurrentAction == "gridedit" || $sucursal->CurrentAction == "F") {
			$sucursal_grid->RowIndex++;
			$objForm->Index = $sucursal_grid->RowIndex;
			if ($objForm->HasValue($sucursal_grid->FormActionName))
				$sucursal_grid->RowAction = strval($objForm->GetValue($sucursal_grid->FormActionName));
			elseif ($sucursal->CurrentAction == "gridadd")
				$sucursal_grid->RowAction = "insert";
			else
				$sucursal_grid->RowAction = "";
		}

		// Set up key count
		$sucursal_grid->KeyCount = $sucursal_grid->RowIndex;

		// Init row class and style
		$sucursal->ResetAttrs();
		$sucursal->CssClass = "";
		if ($sucursal->CurrentAction == "gridadd") {
			if ($sucursal->CurrentMode == "copy") {
				$sucursal_grid->LoadRowValues($sucursal_grid->Recordset); // Load row values
				$sucursal_grid->SetRecordKey($sucursal_grid->RowOldKey, $sucursal_grid->Recordset); // Set old record key
			} else {
				$sucursal_grid->LoadDefaultValues(); // Load default values
				$sucursal_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$sucursal_grid->LoadRowValues($sucursal_grid->Recordset); // Load row values
		}
		$sucursal->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($sucursal->CurrentAction == "gridadd") // Grid add
			$sucursal->RowType = EW_ROWTYPE_ADD; // Render add
		if ($sucursal->CurrentAction == "gridadd" && $sucursal->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
		if ($sucursal->CurrentAction == "gridedit") { // Grid edit
			if ($sucursal->EventCancelled) {
				$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
			}
			if ($sucursal_grid->RowAction == "insert")
				$sucursal->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$sucursal->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($sucursal->CurrentAction == "gridedit" && ($sucursal->RowType == EW_ROWTYPE_EDIT || $sucursal->RowType == EW_ROWTYPE_ADD) && $sucursal->EventCancelled) // Update failed
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values
		if ($sucursal->RowType == EW_ROWTYPE_EDIT) // Edit row
			$sucursal_grid->EditRowCnt++;
		if ($sucursal->CurrentAction == "F") // Confirm row
			$sucursal_grid->RestoreCurrentRowFormValues($sucursal_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$sucursal->RowAttrs = array_merge($sucursal->RowAttrs, array('data-rowindex'=>$sucursal_grid->RowCnt, 'id'=>'r' . $sucursal_grid->RowCnt . '_sucursal', 'data-rowtype'=>$sucursal->RowType));

		// Render row
		$sucursal_grid->RenderRow();

		// Render list options
		$sucursal_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($sucursal_grid->RowAction <> "delete" && $sucursal_grid->RowAction <> "insertdelete" && !($sucursal_grid->RowAction == "insert" && $sucursal->CurrentAction == "F" && $sucursal_grid->EmptyRow())) {
?>
	<tr<?php echo $sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sucursal_grid->ListOptions->Render("body", "left", $sucursal_grid->RowCnt);
?>
	<?php if ($sucursal->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $sucursal->nombre->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-table="sucursal" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->getPlaceHolder()) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="sucursal" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-table="sucursal" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->getPlaceHolder()) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_nombre" class="sucursal_nombre">
<span<?php echo $sucursal->nombre->ViewAttributes() ?>>
<?php echo $sucursal->nombre->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->FormValue) ?>">
<input type="hidden" data-table="sucursal" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
<?php } ?>
<a id="<?php echo $sucursal_grid->PageObjName . "_row_" . $sucursal_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="sucursal" data-field="x_idsucursal" name="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->CurrentValue) ?>">
<input type="hidden" data-table="sucursal" data-field="x_idsucursal" name="o<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="o<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT || $sucursal->CurrentMode == "edit") { ?>
<input type="hidden" data-table="sucursal" data-field="x_idsucursal" name="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" id="x<?php echo $sucursal_grid->RowIndex ?>_idsucursal" value="<?php echo ew_HtmlEncode($sucursal->idsucursal->CurrentValue) ?>">
<?php } ?>
	<?php if ($sucursal->casa_matriz->Visible) { // casa_matriz ?>
		<td data-name="casa_matriz"<?php echo $sucursal->casa_matriz->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_casa_matriz" class="form-group sucursal_casa_matriz">
<select data-table="sucursal" data-field="x_casa_matriz" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->casa_matriz->DisplayValueSeparator) ? json_encode($sucursal->casa_matriz->DisplayValueSeparator) : $sucursal->casa_matriz->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" name="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz"<?php echo $sucursal->casa_matriz->EditAttributes() ?>>
<?php
if (is_array($sucursal->casa_matriz->EditValue)) {
	$arwrk = $sucursal->casa_matriz->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->casa_matriz->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->casa_matriz->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->casa_matriz->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->CurrentValue) ?>" selected><?php echo $sucursal->casa_matriz->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->casa_matriz->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="sucursal" data-field="x_casa_matriz" name="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" id="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_casa_matriz" class="form-group sucursal_casa_matriz">
<select data-table="sucursal" data-field="x_casa_matriz" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->casa_matriz->DisplayValueSeparator) ? json_encode($sucursal->casa_matriz->DisplayValueSeparator) : $sucursal->casa_matriz->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" name="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz"<?php echo $sucursal->casa_matriz->EditAttributes() ?>>
<?php
if (is_array($sucursal->casa_matriz->EditValue)) {
	$arwrk = $sucursal->casa_matriz->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->casa_matriz->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->casa_matriz->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->casa_matriz->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->CurrentValue) ?>" selected><?php echo $sucursal->casa_matriz->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->casa_matriz->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_casa_matriz" class="sucursal_casa_matriz">
<span<?php echo $sucursal->casa_matriz->ViewAttributes() ?>>
<?php echo $sucursal->casa_matriz->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_casa_matriz" name="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" id="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->FormValue) ?>">
<input type="hidden" data-table="sucursal" data-field="x_casa_matriz" name="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" id="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $sucursal->idempresa->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-table="sucursal" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idempresa->DisplayValueSeparator) ? json_encode($sucursal->idempresa->DisplayValueSeparator) : $sucursal->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>" selected><?php echo $sucursal->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo $sucursal->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="sucursal" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-table="sucursal" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idempresa->DisplayValueSeparator) ? json_encode($sucursal->idempresa->DisplayValueSeparator) : $sucursal->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>" selected><?php echo $sucursal->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo $sucursal->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idempresa" class="sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<?php echo $sucursal->idempresa->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->FormValue) ?>">
<input type="hidden" data-table="sucursal" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($sucursal->idpais->Visible) { // idpais ?>
		<td data-name="idpais"<?php echo $sucursal->idpais->CellAttributes() ?>>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idpais" class="form-group sucursal_idpais">
<select data-table="sucursal" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idpais->DisplayValueSeparator) ? json_encode($sucursal->idpais->DisplayValueSeparator) : $sucursal->idpais->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idpais" name="x<?php echo $sucursal_grid->RowIndex ?>_idpais"<?php echo $sucursal->idpais->EditAttributes() ?>>
<?php
if (is_array($sucursal->idpais->EditValue)) {
	$arwrk = $sucursal->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idpais->CurrentValue) ?>" selected><?php echo $sucursal->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo $sucursal->idpais->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="sucursal" data-field="x_idpais" name="o<?php echo $sucursal_grid->RowIndex ?>_idpais" id="o<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($sucursal->idpais->OldValue) ?>">
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idpais" class="form-group sucursal_idpais">
<select data-table="sucursal" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idpais->DisplayValueSeparator) ? json_encode($sucursal->idpais->DisplayValueSeparator) : $sucursal->idpais->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idpais" name="x<?php echo $sucursal_grid->RowIndex ?>_idpais"<?php echo $sucursal->idpais->EditAttributes() ?>>
<?php
if (is_array($sucursal->idpais->EditValue)) {
	$arwrk = $sucursal->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idpais->CurrentValue) ?>" selected><?php echo $sucursal->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo $sucursal->idpais->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($sucursal->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $sucursal_grid->RowCnt ?>_sucursal_idpais" class="sucursal_idpais">
<span<?php echo $sucursal->idpais->ViewAttributes() ?>>
<?php echo $sucursal->idpais->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_idpais" name="x<?php echo $sucursal_grid->RowIndex ?>_idpais" id="x<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($sucursal->idpais->FormValue) ?>">
<input type="hidden" data-table="sucursal" data-field="x_idpais" name="o<?php echo $sucursal_grid->RowIndex ?>_idpais" id="o<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($sucursal->idpais->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sucursal_grid->ListOptions->Render("body", "right", $sucursal_grid->RowCnt);
?>
	</tr>
<?php if ($sucursal->RowType == EW_ROWTYPE_ADD || $sucursal->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsucursalgrid.UpdateOpts(<?php echo $sucursal_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($sucursal->CurrentAction <> "gridadd" || $sucursal->CurrentMode == "copy")
		if (!$sucursal_grid->Recordset->EOF) $sucursal_grid->Recordset->MoveNext();
}
?>
<?php
	if ($sucursal->CurrentMode == "add" || $sucursal->CurrentMode == "copy" || $sucursal->CurrentMode == "edit") {
		$sucursal_grid->RowIndex = '$rowindex$';
		$sucursal_grid->LoadDefaultValues();

		// Set row properties
		$sucursal->ResetAttrs();
		$sucursal->RowAttrs = array_merge($sucursal->RowAttrs, array('data-rowindex'=>$sucursal_grid->RowIndex, 'id'=>'r0_sucursal', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($sucursal->RowAttrs["class"], "ewTemplate");
		$sucursal->RowType = EW_ROWTYPE_ADD;

		// Render row
		$sucursal_grid->RenderRow();

		// Render list options
		$sucursal_grid->RenderListOptions();
		$sucursal_grid->StartRowCnt = 0;
?>
	<tr<?php echo $sucursal->RowAttributes() ?>>
<?php

// Render list options (body, left)
$sucursal_grid->ListOptions->Render("body", "left", $sucursal_grid->RowIndex);
?>
	<?php if ($sucursal->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<?php if ($sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sucursal_nombre" class="form-group sucursal_nombre">
<input type="text" data-table="sucursal" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->getPlaceHolder()) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_sucursal_nombre" class="form-group sucursal_nombre">
<span<?php echo $sucursal->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_nombre" name="x<?php echo $sucursal_grid->RowIndex ?>_nombre" id="x<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sucursal" data-field="x_nombre" name="o<?php echo $sucursal_grid->RowIndex ?>_nombre" id="o<?php echo $sucursal_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($sucursal->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sucursal->casa_matriz->Visible) { // casa_matriz ?>
		<td data-name="casa_matriz">
<?php if ($sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sucursal_casa_matriz" class="form-group sucursal_casa_matriz">
<select data-table="sucursal" data-field="x_casa_matriz" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->casa_matriz->DisplayValueSeparator) ? json_encode($sucursal->casa_matriz->DisplayValueSeparator) : $sucursal->casa_matriz->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" name="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz"<?php echo $sucursal->casa_matriz->EditAttributes() ?>>
<?php
if (is_array($sucursal->casa_matriz->EditValue)) {
	$arwrk = $sucursal->casa_matriz->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->casa_matriz->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->casa_matriz->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->casa_matriz->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->CurrentValue) ?>" selected><?php echo $sucursal->casa_matriz->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->casa_matriz->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_sucursal_casa_matriz" class="form-group sucursal_casa_matriz">
<span<?php echo $sucursal->casa_matriz->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->casa_matriz->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_casa_matriz" name="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" id="x<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sucursal" data-field="x_casa_matriz" name="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" id="o<?php echo $sucursal_grid->RowIndex ?>_casa_matriz" value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa">
<?php if ($sucursal->CurrentAction <> "F") { ?>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<select data-table="sucursal" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idempresa->DisplayValueSeparator) ? json_encode($sucursal->idempresa->DisplayValueSeparator) : $sucursal->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>" selected><?php echo $sucursal->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo $sucursal->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_sucursal_idempresa" class="form-group sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_idempresa" name="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="x<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sucursal" data-field="x_idempresa" name="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" id="o<?php echo $sucursal_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($sucursal->idpais->Visible) { // idpais ?>
		<td data-name="idpais">
<?php if ($sucursal->CurrentAction <> "F") { ?>
<span id="el$rowindex$_sucursal_idpais" class="form-group sucursal_idpais">
<select data-table="sucursal" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idpais->DisplayValueSeparator) ? json_encode($sucursal->idpais->DisplayValueSeparator) : $sucursal->idpais->DisplayValueSeparator) ?>" id="x<?php echo $sucursal_grid->RowIndex ?>_idpais" name="x<?php echo $sucursal_grid->RowIndex ?>_idpais"<?php echo $sucursal->idpais->EditAttributes() ?>>
<?php
if (is_array($sucursal->idpais->EditValue)) {
	$arwrk = $sucursal->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idpais->CurrentValue) ?>" selected><?php echo $sucursal->idpais->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $sucursal->idpais->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" id="s_x<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo $sucursal->idpais->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_sucursal_idpais" class="form-group sucursal_idpais">
<span<?php echo $sucursal->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="sucursal" data-field="x_idpais" name="x<?php echo $sucursal_grid->RowIndex ?>_idpais" id="x<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($sucursal->idpais->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="sucursal" data-field="x_idpais" name="o<?php echo $sucursal_grid->RowIndex ?>_idpais" id="o<?php echo $sucursal_grid->RowIndex ?>_idpais" value="<?php echo ew_HtmlEncode($sucursal->idpais->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$sucursal_grid->ListOptions->Render("body", "right", $sucursal_grid->RowCnt);
?>
<script type="text/javascript">
fsucursalgrid.UpdateOpts(<?php echo $sucursal_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($sucursal->CurrentMode == "add" || $sucursal->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $sucursal_grid->FormKeyCountName ?>" id="<?php echo $sucursal_grid->FormKeyCountName ?>" value="<?php echo $sucursal_grid->KeyCount ?>">
<?php echo $sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sucursal->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $sucursal_grid->FormKeyCountName ?>" id="<?php echo $sucursal_grid->FormKeyCountName ?>" value="<?php echo $sucursal_grid->KeyCount ?>">
<?php echo $sucursal_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($sucursal->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fsucursalgrid">
</div>
<?php

// Close recordset
if ($sucursal_grid->Recordset)
	$sucursal_grid->Recordset->Close();
?>
<?php if ($sucursal_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($sucursal_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($sucursal_grid->TotalRecs == 0 && $sucursal->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($sucursal_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($sucursal->Export == "") { ?>
<script type="text/javascript">
fsucursalgrid.Init();
</script>
<?php } ?>
<?php
$sucursal_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$sucursal_grid->Page_Terminate();
?>
