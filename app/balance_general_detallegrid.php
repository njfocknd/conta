<?php

// Create page object
if (!isset($balance_general_detalle_grid)) $balance_general_detalle_grid = new cbalance_general_detalle_grid();

// Page init
$balance_general_detalle_grid->Page_Init();

// Page main
$balance_general_detalle_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_detalle_grid->Page_Render();
?>
<?php if ($balance_general_detalle->Export == "") { ?>
<script type="text/javascript">

// Form object
var fbalance_general_detallegrid = new ew_Form("fbalance_general_detallegrid", "grid");
fbalance_general_detallegrid.FormKeyCountName = '<?php echo $balance_general_detalle_grid->FormKeyCountName ?>';

// Validate form
fbalance_general_detallegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idclase_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idclase_cuenta->FldCaption(), $balance_general_detalle->idclase_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idgrupo_cuenta->FldCaption(), $balance_general_detalle->idgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsubgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idsubgrupo_cuenta->FldCaption(), $balance_general_detalle->idsubgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_principal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idcuenta_mayor_principal->FldCaption(), $balance_general_detalle->idcuenta_mayor_principal->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->monto->FldCaption(), $balance_general_detalle->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general_detalle->monto->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fbalance_general_detallegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idclase_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsubgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_principal", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fbalance_general_detallegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_general_detallegrid.ValidateRequired = true;
<?php } else { ?>
fbalance_general_detallegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_general_detallegrid.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_cuenta"],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detallegrid.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idclase_cuenta"],"ChildFields":["x_idsubgrupo_cuenta"],"FilterFields":["x_idclase_cuenta"],"Options":[],"Template":""};
fbalance_general_detallegrid.Lists["x_idsubgrupo_cuenta"] = {"LinkField":"x_idsubgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idgrupo_cuenta"],"ChildFields":["x_idcuenta_mayor_principal"],"FilterFields":["x_idgrupo_cuenta"],"Options":[],"Template":""};
fbalance_general_detallegrid.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idsubgrupo_cuenta"],"ChildFields":[],"FilterFields":["x_idsubgrupo_cuenta"],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($balance_general_detalle->CurrentAction == "gridadd") {
	if ($balance_general_detalle->CurrentMode == "copy") {
		$bSelectLimit = $balance_general_detalle_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$balance_general_detalle_grid->TotalRecs = $balance_general_detalle->SelectRecordCount();
			$balance_general_detalle_grid->Recordset = $balance_general_detalle_grid->LoadRecordset($balance_general_detalle_grid->StartRec-1, $balance_general_detalle_grid->DisplayRecs);
		} else {
			if ($balance_general_detalle_grid->Recordset = $balance_general_detalle_grid->LoadRecordset())
				$balance_general_detalle_grid->TotalRecs = $balance_general_detalle_grid->Recordset->RecordCount();
		}
		$balance_general_detalle_grid->StartRec = 1;
		$balance_general_detalle_grid->DisplayRecs = $balance_general_detalle_grid->TotalRecs;
	} else {
		$balance_general_detalle->CurrentFilter = "0=1";
		$balance_general_detalle_grid->StartRec = 1;
		$balance_general_detalle_grid->DisplayRecs = $balance_general_detalle->GridAddRowCount;
	}
	$balance_general_detalle_grid->TotalRecs = $balance_general_detalle_grid->DisplayRecs;
	$balance_general_detalle_grid->StopRec = $balance_general_detalle_grid->DisplayRecs;
} else {
	$bSelectLimit = $balance_general_detalle_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($balance_general_detalle_grid->TotalRecs <= 0)
			$balance_general_detalle_grid->TotalRecs = $balance_general_detalle->SelectRecordCount();
	} else {
		if (!$balance_general_detalle_grid->Recordset && ($balance_general_detalle_grid->Recordset = $balance_general_detalle_grid->LoadRecordset()))
			$balance_general_detalle_grid->TotalRecs = $balance_general_detalle_grid->Recordset->RecordCount();
	}
	$balance_general_detalle_grid->StartRec = 1;
	$balance_general_detalle_grid->DisplayRecs = $balance_general_detalle_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$balance_general_detalle_grid->Recordset = $balance_general_detalle_grid->LoadRecordset($balance_general_detalle_grid->StartRec-1, $balance_general_detalle_grid->DisplayRecs);

	// Set no record found message
	if ($balance_general_detalle->CurrentAction == "" && $balance_general_detalle_grid->TotalRecs == 0) {
		if ($balance_general_detalle_grid->SearchWhere == "0=101")
			$balance_general_detalle_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$balance_general_detalle_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$balance_general_detalle_grid->RenderOtherOptions();
?>
<?php $balance_general_detalle_grid->ShowPageHeader(); ?>
<?php
$balance_general_detalle_grid->ShowMessage();
?>
<?php if ($balance_general_detalle_grid->TotalRecs > 0 || $balance_general_detalle->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fbalance_general_detallegrid" class="ewForm form-inline">
<?php if ($balance_general_detalle_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($balance_general_detalle_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_balance_general_detalle" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_balance_general_detallegrid" class="table ewTable">
<?php echo $balance_general_detalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$balance_general_detalle_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$balance_general_detalle_grid->RenderListOptions();

// Render list options (header, left)
$balance_general_detalle_grid->ListOptions->Render("header", "left");
?>
<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idclase_cuenta) == "") { ?>
		<th data-name="idclase_cuenta"><div id="elh_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idclase_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_cuenta"><div><div id="elh_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idclase_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idclase_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idclase_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idgrupo_cuenta) == "") { ?>
		<th data-name="idgrupo_cuenta"><div id="elh_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idgrupo_cuenta"><div><div id="elh_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idsubgrupo_cuenta) == "") { ?>
		<th data-name="idsubgrupo_cuenta"><div id="elh_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idsubgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsubgrupo_cuenta"><div><div id="elh_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idsubgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idsubgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idsubgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idcuenta_mayor_principal) == "") { ?>
		<th data-name="idcuenta_mayor_principal"><div id="elh_balance_general_detalle_idcuenta_mayor_principal" class="balance_general_detalle_idcuenta_mayor_principal"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idcuenta_mayor_principal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_principal"><div><div id="elh_balance_general_detalle_idcuenta_mayor_principal" class="balance_general_detalle_idcuenta_mayor_principal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idcuenta_mayor_principal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idcuenta_mayor_principal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idcuenta_mayor_principal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->monto) == "") { ?>
		<th data-name="monto"><div id="elh_balance_general_detalle_monto" class="balance_general_detalle_monto"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_balance_general_detalle_monto" class="balance_general_detalle_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$balance_general_detalle_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$balance_general_detalle_grid->StartRec = 1;
$balance_general_detalle_grid->StopRec = $balance_general_detalle_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($balance_general_detalle_grid->FormKeyCountName) && ($balance_general_detalle->CurrentAction == "gridadd" || $balance_general_detalle->CurrentAction == "gridedit" || $balance_general_detalle->CurrentAction == "F")) {
		$balance_general_detalle_grid->KeyCount = $objForm->GetValue($balance_general_detalle_grid->FormKeyCountName);
		$balance_general_detalle_grid->StopRec = $balance_general_detalle_grid->StartRec + $balance_general_detalle_grid->KeyCount - 1;
	}
}
$balance_general_detalle_grid->RecCnt = $balance_general_detalle_grid->StartRec - 1;
if ($balance_general_detalle_grid->Recordset && !$balance_general_detalle_grid->Recordset->EOF) {
	$balance_general_detalle_grid->Recordset->MoveFirst();
	$bSelectLimit = $balance_general_detalle_grid->UseSelectLimit;
	if (!$bSelectLimit && $balance_general_detalle_grid->StartRec > 1)
		$balance_general_detalle_grid->Recordset->Move($balance_general_detalle_grid->StartRec - 1);
} elseif (!$balance_general_detalle->AllowAddDeleteRow && $balance_general_detalle_grid->StopRec == 0) {
	$balance_general_detalle_grid->StopRec = $balance_general_detalle->GridAddRowCount;
}

// Initialize aggregate
$balance_general_detalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$balance_general_detalle->ResetAttrs();
$balance_general_detalle_grid->RenderRow();
if ($balance_general_detalle->CurrentAction == "gridadd")
	$balance_general_detalle_grid->RowIndex = 0;
if ($balance_general_detalle->CurrentAction == "gridedit")
	$balance_general_detalle_grid->RowIndex = 0;
while ($balance_general_detalle_grid->RecCnt < $balance_general_detalle_grid->StopRec) {
	$balance_general_detalle_grid->RecCnt++;
	if (intval($balance_general_detalle_grid->RecCnt) >= intval($balance_general_detalle_grid->StartRec)) {
		$balance_general_detalle_grid->RowCnt++;
		if ($balance_general_detalle->CurrentAction == "gridadd" || $balance_general_detalle->CurrentAction == "gridedit" || $balance_general_detalle->CurrentAction == "F") {
			$balance_general_detalle_grid->RowIndex++;
			$objForm->Index = $balance_general_detalle_grid->RowIndex;
			if ($objForm->HasValue($balance_general_detalle_grid->FormActionName))
				$balance_general_detalle_grid->RowAction = strval($objForm->GetValue($balance_general_detalle_grid->FormActionName));
			elseif ($balance_general_detalle->CurrentAction == "gridadd")
				$balance_general_detalle_grid->RowAction = "insert";
			else
				$balance_general_detalle_grid->RowAction = "";
		}

		// Set up key count
		$balance_general_detalle_grid->KeyCount = $balance_general_detalle_grid->RowIndex;

		// Init row class and style
		$balance_general_detalle->ResetAttrs();
		$balance_general_detalle->CssClass = "";
		if ($balance_general_detalle->CurrentAction == "gridadd") {
			if ($balance_general_detalle->CurrentMode == "copy") {
				$balance_general_detalle_grid->LoadRowValues($balance_general_detalle_grid->Recordset); // Load row values
				$balance_general_detalle_grid->SetRecordKey($balance_general_detalle_grid->RowOldKey, $balance_general_detalle_grid->Recordset); // Set old record key
			} else {
				$balance_general_detalle_grid->LoadDefaultValues(); // Load default values
				$balance_general_detalle_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$balance_general_detalle_grid->LoadRowValues($balance_general_detalle_grid->Recordset); // Load row values
		}
		$balance_general_detalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($balance_general_detalle->CurrentAction == "gridadd") // Grid add
			$balance_general_detalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($balance_general_detalle->CurrentAction == "gridadd" && $balance_general_detalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$balance_general_detalle_grid->RestoreCurrentRowFormValues($balance_general_detalle_grid->RowIndex); // Restore form values
		if ($balance_general_detalle->CurrentAction == "gridedit") { // Grid edit
			if ($balance_general_detalle->EventCancelled) {
				$balance_general_detalle_grid->RestoreCurrentRowFormValues($balance_general_detalle_grid->RowIndex); // Restore form values
			}
			if ($balance_general_detalle_grid->RowAction == "insert")
				$balance_general_detalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$balance_general_detalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($balance_general_detalle->CurrentAction == "gridedit" && ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT || $balance_general_detalle->RowType == EW_ROWTYPE_ADD) && $balance_general_detalle->EventCancelled) // Update failed
			$balance_general_detalle_grid->RestoreCurrentRowFormValues($balance_general_detalle_grid->RowIndex); // Restore form values
		if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$balance_general_detalle_grid->EditRowCnt++;
		if ($balance_general_detalle->CurrentAction == "F") // Confirm row
			$balance_general_detalle_grid->RestoreCurrentRowFormValues($balance_general_detalle_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$balance_general_detalle->RowAttrs = array_merge($balance_general_detalle->RowAttrs, array('data-rowindex'=>$balance_general_detalle_grid->RowCnt, 'id'=>'r' . $balance_general_detalle_grid->RowCnt . '_balance_general_detalle', 'data-rowtype'=>$balance_general_detalle->RowType));

		// Render row
		$balance_general_detalle_grid->RenderRow();

		// Render list options
		$balance_general_detalle_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($balance_general_detalle_grid->RowAction <> "delete" && $balance_general_detalle_grid->RowAction <> "insertdelete" && !($balance_general_detalle_grid->RowAction == "insert" && $balance_general_detalle->CurrentAction == "F" && $balance_general_detalle_grid->EmptyRow())) {
?>
	<tr<?php echo $balance_general_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_detalle_grid->ListOptions->Render("body", "left", $balance_general_detalle_grid->RowCnt);
?>
	<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta">
<span<?php echo $balance_general_detalle->idclase_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idclase_cuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->FormValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->OldValue) ?>">
<?php } ?>
<a id="<?php echo $balance_general_detalle_grid->PageObjName . "_row_" . $balance_general_detalle_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->CurrentValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT || $balance_general_detalle->CurrentMode == "edit") { ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta">
<span<?php echo $balance_general_detalle->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->FormValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
		<td data-name="idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<?php $balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<?php $balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta">
<span<?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->FormValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal"<?php echo $balance_general_detalle->idcuenta_mayor_principal->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idcuenta_mayor_principal" class="form-group balance_general_detalle_idcuenta_mayor_principal">
<select data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) : $balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $balance_general_detalle->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $balance_general_detalle->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f1" => "`idsubgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $balance_general_detalle->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idcuenta_mayor_principal" class="form-group balance_general_detalle_idcuenta_mayor_principal">
<select data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) : $balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $balance_general_detalle->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $balance_general_detalle->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f1" => "`idsubgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $balance_general_detalle->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_idcuenta_mayor_principal" class="balance_general_detalle_idcuenta_mayor_principal">
<span<?php echo $balance_general_detalle->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idcuenta_mayor_principal->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->FormValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $balance_general_detalle->monto->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_grid->RowCnt ?>_balance_general_detalle_monto" class="balance_general_detalle_monto">
<span<?php echo $balance_general_detalle->monto->ViewAttributes() ?>>
<?php echo $balance_general_detalle->monto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->FormValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_detalle_grid->ListOptions->Render("body", "right", $balance_general_detalle_grid->RowCnt);
?>
	</tr>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD || $balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbalance_general_detallegrid.UpdateOpts(<?php echo $balance_general_detalle_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($balance_general_detalle->CurrentAction <> "gridadd" || $balance_general_detalle->CurrentMode == "copy")
		if (!$balance_general_detalle_grid->Recordset->EOF) $balance_general_detalle_grid->Recordset->MoveNext();
}
?>
<?php
	if ($balance_general_detalle->CurrentMode == "add" || $balance_general_detalle->CurrentMode == "copy" || $balance_general_detalle->CurrentMode == "edit") {
		$balance_general_detalle_grid->RowIndex = '$rowindex$';
		$balance_general_detalle_grid->LoadDefaultValues();

		// Set row properties
		$balance_general_detalle->ResetAttrs();
		$balance_general_detalle->RowAttrs = array_merge($balance_general_detalle->RowAttrs, array('data-rowindex'=>$balance_general_detalle_grid->RowIndex, 'id'=>'r0_balance_general_detalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($balance_general_detalle->RowAttrs["class"], "ewTemplate");
		$balance_general_detalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$balance_general_detalle_grid->RenderRow();

		// Render list options
		$balance_general_detalle_grid->RenderListOptions();
		$balance_general_detalle_grid->StartRowCnt = 0;
?>
	<tr<?php echo $balance_general_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_detalle_grid->ListOptions->Render("body", "left", $balance_general_detalle_grid->RowIndex);
?>
	<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta">
<?php if ($balance_general_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<span<?php echo $balance_general_detalle->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general_detalle->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta">
<?php if ($balance_general_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<span<?php echo $balance_general_detalle->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general_detalle->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
		<td data-name="idsubgrupo_cuenta">
<?php if ($balance_general_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<?php $balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idsubgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<span<?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal">
<?php if ($balance_general_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_detalle_idcuenta_mayor_principal" class="form-group balance_general_detalle_idcuenta_mayor_principal">
<select data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) : $balance_general_detalle->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal"<?php echo $balance_general_detalle->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $balance_general_detalle->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idcuenta_mayor_principal->LookupFilters += array("f1" => "`idsubgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $balance_general_detalle->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_detalle_idcuenta_mayor_principal" class="form-group balance_general_detalle_idcuenta_mayor_principal">
<span<?php echo $balance_general_detalle->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general_detalle->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idcuenta_mayor_principal" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($balance_general_detalle->idcuenta_mayor_principal->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
		<td data-name="monto">
<?php if ($balance_general_detalle->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<span<?php echo $balance_general_detalle->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general_detalle->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" id="o<?php echo $balance_general_detalle_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_detalle_grid->ListOptions->Render("body", "right", $balance_general_detalle_grid->RowCnt);
?>
<script type="text/javascript">
fbalance_general_detallegrid.UpdateOpts(<?php echo $balance_general_detalle_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($balance_general_detalle->CurrentMode == "add" || $balance_general_detalle->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $balance_general_detalle_grid->FormKeyCountName ?>" id="<?php echo $balance_general_detalle_grid->FormKeyCountName ?>" value="<?php echo $balance_general_detalle_grid->KeyCount ?>">
<?php echo $balance_general_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general_detalle->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $balance_general_detalle_grid->FormKeyCountName ?>" id="<?php echo $balance_general_detalle_grid->FormKeyCountName ?>" value="<?php echo $balance_general_detalle_grid->KeyCount ?>">
<?php echo $balance_general_detalle_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general_detalle->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbalance_general_detallegrid">
</div>
<?php

// Close recordset
if ($balance_general_detalle_grid->Recordset)
	$balance_general_detalle_grid->Recordset->Close();
?>
<?php if ($balance_general_detalle_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($balance_general_detalle_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($balance_general_detalle_grid->TotalRecs == 0 && $balance_general_detalle->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_detalle_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($balance_general_detalle->Export == "") { ?>
<script type="text/javascript">
fbalance_general_detallegrid.Init();
</script>
<?php } ?>
<?php
$balance_general_detalle_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$balance_general_detalle_grid->Page_Terminate();
?>
