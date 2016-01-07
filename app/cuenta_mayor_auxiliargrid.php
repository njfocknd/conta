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

// Page object
var cuenta_mayor_auxiliar_grid = new ew_Page("cuenta_mayor_auxiliar_grid");
cuenta_mayor_auxiliar_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = cuenta_mayor_auxiliar_grid.PageID; // For backward compatibility

// Form object
var fcuenta_mayor_auxiliargrid = new ew_Form("fcuenta_mayor_auxiliargrid");
fcuenta_mayor_auxiliargrid.FormKeyCountName = '<?php echo $cuenta_mayor_auxiliar_grid->FormKeyCountName ?>';

// Validate form
fcuenta_mayor_auxiliargrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_principal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption(), $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nomeclatura->FldCaption(), $cuenta_mayor_auxiliar->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nombre->FldCaption(), $cuenta_mayor_auxiliar->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->estado->FldCaption(), $cuenta_mayor_auxiliar->estado->ReqErrMsg)) ?>");

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
fcuenta_mayor_auxiliargrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_principal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nomeclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "estado", false)) return false;
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
fcuenta_mayor_auxiliargrid.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") {
	if ($cuenta_mayor_auxiliar->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$cuenta_mayor_auxiliar_grid->TotalRecs = $cuenta_mayor_auxiliar->SelectRecordCount();
	} else {
		if ($cuenta_mayor_auxiliar_grid->Recordset = $cuenta_mayor_auxiliar_grid->LoadRecordset())
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
<div class="ewGrid">
<div id="fcuenta_mayor_auxiliargrid" class="ewForm form-inline">
<div id="gmp_cuenta_mayor_auxiliar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_cuenta_mayor_auxiliargrid" class="table ewTable">
<?php echo $cuenta_mayor_auxiliar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$cuenta_mayor_auxiliar_grid->RenderListOptions();

// Render list options (header, left)
$cuenta_mayor_auxiliar_grid->ListOptions->Render("header", "left");
?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->idcuenta_mayor_principal) == "") { ?>
		<th data-name="idcuenta_mayor_principal"><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_principal"><div><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_mayor_auxiliar->nomeclatura->Visible) { // nomeclatura ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nomeclatura) == "") { ?>
		<th data-name="nomeclatura"><div id="elh_cuenta_mayor_auxiliar_nomeclatura" class="cuenta_mayor_auxiliar_nomeclatura"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomeclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomeclatura"><div><div id="elh_cuenta_mayor_auxiliar_nomeclatura" class="cuenta_mayor_auxiliar_nomeclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomeclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->nomeclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->nomeclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
<?php if ($cuenta_mayor_auxiliar->estado->Visible) { // estado ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->estado) == "") { ?>
		<th data-name="estado"><div id="elh_cuenta_mayor_auxiliar_estado" class="cuenta_mayor_auxiliar_estado"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div><div id="elh_cuenta_mayor_auxiliar_estado" class="cuenta_mayor_auxiliar_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
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
	$bSelectLimit = EW_SELECT_LIMIT;
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
<select data-field="x_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta_mayor_principal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
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
<select data-field="x_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta_mayor_principal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ListViewValue() ?></span>
<input type="hidden" data-field="x_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->FormValue) ?>">
<input type="hidden" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
<a id="<?php echo $cuenta_mayor_auxiliar_grid->PageObjName . "_row_" . $cuenta_mayor_auxiliar_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<input type="hidden" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT || $cuenta_mayor_auxiliar->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nomeclatura->Visible) { // nomeclatura ?>
		<td data-name="nomeclatura"<?php echo $cuenta_mayor_auxiliar->nomeclatura->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nomeclatura" class="form-group cuenta_mayor_auxiliar_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nomeclatura" class="form-group cuenta_mayor_auxiliar_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_mayor_auxiliar->nomeclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nomeclatura->ListViewValue() ?></span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->FormValue) ?>">
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $cuenta_mayor_auxiliar->nombre->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nombre->ListViewValue() ?></span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->FormValue) ?>">
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $cuenta_mayor_auxiliar->estado->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_estado" class="form-group cuenta_mayor_auxiliar_estado">
<div id="tp_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="{value}"<?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cuenta_mayor_auxiliar->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-field="x_estado" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->estado->OldValue = "";
?>
</div>
</span>
<input type="hidden" data-field="x_estado" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->estado->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_grid->RowCnt ?>_cuenta_mayor_auxiliar_estado" class="form-group cuenta_mayor_auxiliar_estado">
<div id="tp_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="{value}"<?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cuenta_mayor_auxiliar->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-field="x_estado" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->estado->OldValue = "";
?>
</div>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $cuenta_mayor_auxiliar->estado->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->estado->ListViewValue() ?></span>
<input type="hidden" data-field="x_estado" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->estado->FormValue) ?>">
<input type="hidden" data-field="x_estado" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->estado->OldValue) ?>">
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
	<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td>
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-field="x_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
 $sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
 $sWhereWrk = "";

 // Call Lookup selecting
 $cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk);
 if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idcuenta_mayor_principal` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nomeclatura->Visible) { // nomeclatura ?>
		<td>
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nomeclatura" class="form-group cuenta_mayor_auxiliar_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomeclatura->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nomeclatura" class="form-group cuenta_mayor_auxiliar_nomeclatura">
<span<?php echo $cuenta_mayor_auxiliar->nomeclatura->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->nomeclatura->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nomeclatura" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomeclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td>
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->nombre->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->estado->Visible) { // estado ?>
		<td>
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "F") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_estado" class="form-group cuenta_mayor_auxiliar_estado">
<div id="tp_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="{value}"<?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $cuenta_mayor_auxiliar->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_auxiliar->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-field="x_estado" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cuenta_mayor_auxiliar->estado->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
if (@$emptywrk) $cuenta_mayor_auxiliar->estado->OldValue = "";
?>
</div>
</span>
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_estado" class="form-group cuenta_mayor_auxiliar_estado">
<span<?php echo $cuenta_mayor_auxiliar->estado->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->estado->ViewValue ?></p></span>
</span>
<input type="hidden" data-field="x_estado" name="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="x<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->estado->FormValue) ?>">
<?php } ?>
<input type="hidden" data-field="x_estado" name="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" id="o<?php echo $cuenta_mayor_auxiliar_grid->RowIndex ?>_estado" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->estado->OldValue) ?>">
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
<div class="ewGridLowerPanel">
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
