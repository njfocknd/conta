<?php

// Create page object
if (!isset($balance_general_grid)) $balance_general_grid = new cbalance_general_grid();

// Page init
$balance_general_grid->Page_Init();

// Page main
$balance_general_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_grid->Page_Render();
?>
<?php if ($balance_general->Export == "") { ?>
<script type="text/javascript">

// Form object
var fbalance_generalgrid = new ew_Form("fbalance_generalgrid", "grid");
fbalance_generalgrid.FormKeyCountName = '<?php echo $balance_general_grid->FormKeyCountName ?>';

// Validate form
fbalance_generalgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->idempresa->FldCaption(), $balance_general->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->idperiodo_contable->FldCaption(), $balance_general->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_activo_circulante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->activo_circulante->FldCaption(), $balance_general->activo_circulante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_activo_circulante");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->activo_circulante->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo_fijo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->activo_fijo->FldCaption(), $balance_general->activo_fijo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_activo_fijo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->activo_fijo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_circulante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->pasivo_circulante->FldCaption(), $balance_general->pasivo_circulante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_circulante");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->pasivo_circulante->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_fijo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->pasivo_fijo->FldCaption(), $balance_general->pasivo_fijo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_fijo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->pasivo_fijo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_capital_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->capital_contable->FldCaption(), $balance_general->capital_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_capital_contable");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->capital_contable->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fbalance_generalgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idempresa", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idperiodo_contable", false)) return false;
	if (ew_ValueChanged(fobj, infix, "activo_circulante", false)) return false;
	if (ew_ValueChanged(fobj, infix, "activo_fijo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pasivo_circulante", false)) return false;
	if (ew_ValueChanged(fobj, infix, "pasivo_fijo", false)) return false;
	if (ew_ValueChanged(fobj, infix, "capital_contable", false)) return false;
	return true;
}

// Form_CustomValidate event
fbalance_generalgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_generalgrid.ValidateRequired = true;
<?php } else { ?>
fbalance_generalgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_generalgrid.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_ticker","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generalgrid.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<?php } ?>
<?php
if ($balance_general->CurrentAction == "gridadd") {
	if ($balance_general->CurrentMode == "copy") {
		$bSelectLimit = $balance_general_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$balance_general_grid->TotalRecs = $balance_general->SelectRecordCount();
			$balance_general_grid->Recordset = $balance_general_grid->LoadRecordset($balance_general_grid->StartRec-1, $balance_general_grid->DisplayRecs);
		} else {
			if ($balance_general_grid->Recordset = $balance_general_grid->LoadRecordset())
				$balance_general_grid->TotalRecs = $balance_general_grid->Recordset->RecordCount();
		}
		$balance_general_grid->StartRec = 1;
		$balance_general_grid->DisplayRecs = $balance_general_grid->TotalRecs;
	} else {
		$balance_general->CurrentFilter = "0=1";
		$balance_general_grid->StartRec = 1;
		$balance_general_grid->DisplayRecs = $balance_general->GridAddRowCount;
	}
	$balance_general_grid->TotalRecs = $balance_general_grid->DisplayRecs;
	$balance_general_grid->StopRec = $balance_general_grid->DisplayRecs;
} else {
	$bSelectLimit = $balance_general_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($balance_general_grid->TotalRecs <= 0)
			$balance_general_grid->TotalRecs = $balance_general->SelectRecordCount();
	} else {
		if (!$balance_general_grid->Recordset && ($balance_general_grid->Recordset = $balance_general_grid->LoadRecordset()))
			$balance_general_grid->TotalRecs = $balance_general_grid->Recordset->RecordCount();
	}
	$balance_general_grid->StartRec = 1;
	$balance_general_grid->DisplayRecs = $balance_general_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$balance_general_grid->Recordset = $balance_general_grid->LoadRecordset($balance_general_grid->StartRec-1, $balance_general_grid->DisplayRecs);

	// Set no record found message
	if ($balance_general->CurrentAction == "" && $balance_general_grid->TotalRecs == 0) {
		if ($balance_general_grid->SearchWhere == "0=101")
			$balance_general_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$balance_general_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$balance_general_grid->RenderOtherOptions();
?>
<?php $balance_general_grid->ShowPageHeader(); ?>
<?php
$balance_general_grid->ShowMessage();
?>
<?php if ($balance_general_grid->TotalRecs > 0 || $balance_general->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fbalance_generalgrid" class="ewForm form-inline">
<?php if ($balance_general_grid->ShowOtherOptions) { ?>
<div class="panel-heading ewGridUpperPanel">
<?php
	foreach ($balance_general_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_balance_general" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_balance_generalgrid" class="table ewTable">
<?php echo $balance_general->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$balance_general_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$balance_general_grid->RenderListOptions();

// Render list options (header, left)
$balance_general_grid->ListOptions->Render("header", "left");
?>
<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
	<?php if ($balance_general->SortUrl($balance_general->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_balance_general_idempresa" class="balance_general_idempresa"><div class="ewTableHeaderCaption"><?php echo $balance_general->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div><div id="elh_balance_general_idempresa" class="balance_general_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<?php if ($balance_general->SortUrl($balance_general->idperiodo_contable) == "") { ?>
		<th data-name="idperiodo_contable"><div id="elh_balance_general_idperiodo_contable" class="balance_general_idperiodo_contable"><div class="ewTableHeaderCaption"><?php echo $balance_general->idperiodo_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperiodo_contable"><div><div id="elh_balance_general_idperiodo_contable" class="balance_general_idperiodo_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->idperiodo_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->idperiodo_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->idperiodo_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
	<?php if ($balance_general->SortUrl($balance_general->activo_circulante) == "") { ?>
		<th data-name="activo_circulante"><div id="elh_balance_general_activo_circulante" class="balance_general_activo_circulante"><div class="ewTableHeaderCaption"><?php echo $balance_general->activo_circulante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activo_circulante"><div><div id="elh_balance_general_activo_circulante" class="balance_general_activo_circulante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->activo_circulante->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->activo_circulante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->activo_circulante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
	<?php if ($balance_general->SortUrl($balance_general->activo_fijo) == "") { ?>
		<th data-name="activo_fijo"><div id="elh_balance_general_activo_fijo" class="balance_general_activo_fijo"><div class="ewTableHeaderCaption"><?php echo $balance_general->activo_fijo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activo_fijo"><div><div id="elh_balance_general_activo_fijo" class="balance_general_activo_fijo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->activo_fijo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->activo_fijo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->activo_fijo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
	<?php if ($balance_general->SortUrl($balance_general->pasivo_circulante) == "") { ?>
		<th data-name="pasivo_circulante"><div id="elh_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante"><div class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_circulante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasivo_circulante"><div><div id="elh_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_circulante->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->pasivo_circulante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->pasivo_circulante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
	<?php if ($balance_general->SortUrl($balance_general->pasivo_fijo) == "") { ?>
		<th data-name="pasivo_fijo"><div id="elh_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo"><div class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_fijo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasivo_fijo"><div><div id="elh_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_fijo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->pasivo_fijo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->pasivo_fijo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
	<?php if ($balance_general->SortUrl($balance_general->capital_contable) == "") { ?>
		<th data-name="capital_contable"><div id="elh_balance_general_capital_contable" class="balance_general_capital_contable"><div class="ewTableHeaderCaption"><?php echo $balance_general->capital_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="capital_contable"><div><div id="elh_balance_general_capital_contable" class="balance_general_capital_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->capital_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->capital_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->capital_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$balance_general_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$balance_general_grid->StartRec = 1;
$balance_general_grid->StopRec = $balance_general_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($balance_general_grid->FormKeyCountName) && ($balance_general->CurrentAction == "gridadd" || $balance_general->CurrentAction == "gridedit" || $balance_general->CurrentAction == "F")) {
		$balance_general_grid->KeyCount = $objForm->GetValue($balance_general_grid->FormKeyCountName);
		$balance_general_grid->StopRec = $balance_general_grid->StartRec + $balance_general_grid->KeyCount - 1;
	}
}
$balance_general_grid->RecCnt = $balance_general_grid->StartRec - 1;
if ($balance_general_grid->Recordset && !$balance_general_grid->Recordset->EOF) {
	$balance_general_grid->Recordset->MoveFirst();
	$bSelectLimit = $balance_general_grid->UseSelectLimit;
	if (!$bSelectLimit && $balance_general_grid->StartRec > 1)
		$balance_general_grid->Recordset->Move($balance_general_grid->StartRec - 1);
} elseif (!$balance_general->AllowAddDeleteRow && $balance_general_grid->StopRec == 0) {
	$balance_general_grid->StopRec = $balance_general->GridAddRowCount;
}

// Initialize aggregate
$balance_general->RowType = EW_ROWTYPE_AGGREGATEINIT;
$balance_general->ResetAttrs();
$balance_general_grid->RenderRow();
if ($balance_general->CurrentAction == "gridadd")
	$balance_general_grid->RowIndex = 0;
if ($balance_general->CurrentAction == "gridedit")
	$balance_general_grid->RowIndex = 0;
while ($balance_general_grid->RecCnt < $balance_general_grid->StopRec) {
	$balance_general_grid->RecCnt++;
	if (intval($balance_general_grid->RecCnt) >= intval($balance_general_grid->StartRec)) {
		$balance_general_grid->RowCnt++;
		if ($balance_general->CurrentAction == "gridadd" || $balance_general->CurrentAction == "gridedit" || $balance_general->CurrentAction == "F") {
			$balance_general_grid->RowIndex++;
			$objForm->Index = $balance_general_grid->RowIndex;
			if ($objForm->HasValue($balance_general_grid->FormActionName))
				$balance_general_grid->RowAction = strval($objForm->GetValue($balance_general_grid->FormActionName));
			elseif ($balance_general->CurrentAction == "gridadd")
				$balance_general_grid->RowAction = "insert";
			else
				$balance_general_grid->RowAction = "";
		}

		// Set up key count
		$balance_general_grid->KeyCount = $balance_general_grid->RowIndex;

		// Init row class and style
		$balance_general->ResetAttrs();
		$balance_general->CssClass = "";
		if ($balance_general->CurrentAction == "gridadd") {
			if ($balance_general->CurrentMode == "copy") {
				$balance_general_grid->LoadRowValues($balance_general_grid->Recordset); // Load row values
				$balance_general_grid->SetRecordKey($balance_general_grid->RowOldKey, $balance_general_grid->Recordset); // Set old record key
			} else {
				$balance_general_grid->LoadDefaultValues(); // Load default values
				$balance_general_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$balance_general_grid->LoadRowValues($balance_general_grid->Recordset); // Load row values
		}
		$balance_general->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($balance_general->CurrentAction == "gridadd") // Grid add
			$balance_general->RowType = EW_ROWTYPE_ADD; // Render add
		if ($balance_general->CurrentAction == "gridadd" && $balance_general->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$balance_general_grid->RestoreCurrentRowFormValues($balance_general_grid->RowIndex); // Restore form values
		if ($balance_general->CurrentAction == "gridedit") { // Grid edit
			if ($balance_general->EventCancelled) {
				$balance_general_grid->RestoreCurrentRowFormValues($balance_general_grid->RowIndex); // Restore form values
			}
			if ($balance_general_grid->RowAction == "insert")
				$balance_general->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$balance_general->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($balance_general->CurrentAction == "gridedit" && ($balance_general->RowType == EW_ROWTYPE_EDIT || $balance_general->RowType == EW_ROWTYPE_ADD) && $balance_general->EventCancelled) // Update failed
			$balance_general_grid->RestoreCurrentRowFormValues($balance_general_grid->RowIndex); // Restore form values
		if ($balance_general->RowType == EW_ROWTYPE_EDIT) // Edit row
			$balance_general_grid->EditRowCnt++;
		if ($balance_general->CurrentAction == "F") // Confirm row
			$balance_general_grid->RestoreCurrentRowFormValues($balance_general_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$balance_general->RowAttrs = array_merge($balance_general->RowAttrs, array('data-rowindex'=>$balance_general_grid->RowCnt, 'id'=>'r' . $balance_general_grid->RowCnt . '_balance_general', 'data-rowtype'=>$balance_general->RowType));

		// Render row
		$balance_general_grid->RenderRow();

		// Render list options
		$balance_general_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($balance_general_grid->RowAction <> "delete" && $balance_general_grid->RowAction <> "insertdelete" && !($balance_general_grid->RowAction == "insert" && $balance_general->CurrentAction == "F" && $balance_general_grid->EmptyRow())) {
?>
	<tr<?php echo $balance_general->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_grid->ListOptions->Render("body", "left", $balance_general_grid->RowCnt);
?>
	<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $balance_general->idempresa->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($balance_general->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idempresa" class="form-group balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idempresa" class="form-group balance_general_idempresa">
<select data-table="balance_general" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idempresa->DisplayValueSeparator) ? json_encode($balance_general->idempresa->DisplayValueSeparator) : $balance_general->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa"<?php echo $balance_general->idempresa->EditAttributes() ?>>
<?php
if (is_array($balance_general->idempresa->EditValue)) {
	$arwrk = $balance_general->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>" selected><?php echo $balance_general->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$balance_general->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo $balance_general->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_idempresa" name="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($balance_general->idempresa->getSessionValue() <> "") { ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idempresa" class="form-group balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idempresa" class="form-group balance_general_idempresa">
<select data-table="balance_general" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idempresa->DisplayValueSeparator) ? json_encode($balance_general->idempresa->DisplayValueSeparator) : $balance_general->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa"<?php echo $balance_general->idempresa->EditAttributes() ?>>
<?php
if (is_array($balance_general->idempresa->EditValue)) {
	$arwrk = $balance_general->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>" selected><?php echo $balance_general->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$balance_general->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo $balance_general->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idempresa" class="balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<?php echo $balance_general->idempresa->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_idempresa" name="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->OldValue) ?>">
<?php } ?>
<a id="<?php echo $balance_general_grid->PageObjName . "_row_" . $balance_general_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="balance_general" data-field="x_idbalance_general" name="x<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" id="x<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" value="<?php echo ew_HtmlEncode($balance_general->idbalance_general->CurrentValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_idbalance_general" name="o<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" id="o<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" value="<?php echo ew_HtmlEncode($balance_general->idbalance_general->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT || $balance_general->CurrentMode == "edit") { ?>
<input type="hidden" data-table="balance_general" data-field="x_idbalance_general" name="x<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" id="x<?php echo $balance_general_grid->RowIndex ?>_idbalance_general" value="<?php echo ew_HtmlEncode($balance_general->idbalance_general->CurrentValue) ?>">
<?php } ?>
	<?php if ($balance_general->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable"<?php echo $balance_general->idperiodo_contable->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idperiodo_contable" class="form-group balance_general_idperiodo_contable">
<select data-table="balance_general" data-field="x_idperiodo_contable" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idperiodo_contable->DisplayValueSeparator) ? json_encode($balance_general->idperiodo_contable->DisplayValueSeparator) : $balance_general->idperiodo_contable->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable"<?php echo $balance_general->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($balance_general->idperiodo_contable->EditValue)) {
	$arwrk = $balance_general->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idperiodo_contable->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idperiodo_contable->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idperiodo_contable->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->CurrentValue) ?>" selected><?php echo $balance_general->idperiodo_contable->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general->idperiodo_contable->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idperiodo_contable->LookupFilters += array("f0" => "`idperiodo_contable` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idperiodo_contable->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo $balance_general->idperiodo_contable->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general" data-field="x_idperiodo_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idperiodo_contable" class="form-group balance_general_idperiodo_contable">
<select data-table="balance_general" data-field="x_idperiodo_contable" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idperiodo_contable->DisplayValueSeparator) ? json_encode($balance_general->idperiodo_contable->DisplayValueSeparator) : $balance_general->idperiodo_contable->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable"<?php echo $balance_general->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($balance_general->idperiodo_contable->EditValue)) {
	$arwrk = $balance_general->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idperiodo_contable->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idperiodo_contable->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idperiodo_contable->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->CurrentValue) ?>" selected><?php echo $balance_general->idperiodo_contable->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general->idperiodo_contable->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idperiodo_contable->LookupFilters += array("f0" => "`idperiodo_contable` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idperiodo_contable->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo $balance_general->idperiodo_contable->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_idperiodo_contable" class="balance_general_idperiodo_contable">
<span<?php echo $balance_general->idperiodo_contable->ViewAttributes() ?>>
<?php echo $balance_general->idperiodo_contable->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_idperiodo_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_idperiodo_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
		<td data-name="activo_circulante"<?php echo $balance_general->activo_circulante->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_circulante" class="form-group balance_general_activo_circulante">
<input type="text" data-table="balance_general" data-field="x_activo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_circulante->EditValue ?>"<?php echo $balance_general->activo_circulante->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" value="<?php echo ew_HtmlEncode($balance_general->activo_circulante->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_circulante" class="form-group balance_general_activo_circulante">
<input type="text" data-table="balance_general" data-field="x_activo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_circulante->EditValue ?>"<?php echo $balance_general->activo_circulante->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_circulante" class="balance_general_activo_circulante">
<span<?php echo $balance_general->activo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->activo_circulante->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" value="<?php echo ew_HtmlEncode($balance_general->activo_circulante->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_activo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" value="<?php echo ew_HtmlEncode($balance_general->activo_circulante->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
		<td data-name="activo_fijo"<?php echo $balance_general->activo_fijo->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_fijo" class="form-group balance_general_activo_fijo">
<input type="text" data-table="balance_general" data-field="x_activo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_fijo->EditValue ?>"<?php echo $balance_general->activo_fijo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" value="<?php echo ew_HtmlEncode($balance_general->activo_fijo->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_fijo" class="form-group balance_general_activo_fijo">
<input type="text" data-table="balance_general" data-field="x_activo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_fijo->EditValue ?>"<?php echo $balance_general->activo_fijo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_activo_fijo" class="balance_general_activo_fijo">
<span<?php echo $balance_general->activo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->activo_fijo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" value="<?php echo ew_HtmlEncode($balance_general->activo_fijo->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_activo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" value="<?php echo ew_HtmlEncode($balance_general->activo_fijo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
		<td data-name="pasivo_circulante"<?php echo $balance_general->pasivo_circulante->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_circulante" class="form-group balance_general_pasivo_circulante">
<input type="text" data-table="balance_general" data-field="x_pasivo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_circulante->EditValue ?>"<?php echo $balance_general->pasivo_circulante->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" value="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_circulante" class="form-group balance_general_pasivo_circulante">
<input type="text" data-table="balance_general" data-field="x_pasivo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_circulante->EditValue ?>"<?php echo $balance_general->pasivo_circulante->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante">
<span<?php echo $balance_general->pasivo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_circulante->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" value="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_pasivo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" value="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
		<td data-name="pasivo_fijo"<?php echo $balance_general->pasivo_fijo->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_fijo" class="form-group balance_general_pasivo_fijo">
<input type="text" data-table="balance_general" data-field="x_pasivo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_fijo->EditValue ?>"<?php echo $balance_general->pasivo_fijo->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" value="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_fijo" class="form-group balance_general_pasivo_fijo">
<input type="text" data-table="balance_general" data-field="x_pasivo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_fijo->EditValue ?>"<?php echo $balance_general->pasivo_fijo->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo">
<span<?php echo $balance_general->pasivo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_fijo->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" value="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_pasivo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" value="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
		<td data-name="capital_contable"<?php echo $balance_general->capital_contable->CellAttributes() ?>>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_capital_contable" class="form-group balance_general_capital_contable">
<input type="text" data-table="balance_general" data-field="x_capital_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->capital_contable->getPlaceHolder()) ?>" value="<?php echo $balance_general->capital_contable->EditValue ?>"<?php echo $balance_general->capital_contable->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general" data-field="x_capital_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" value="<?php echo ew_HtmlEncode($balance_general->capital_contable->OldValue) ?>">
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_capital_contable" class="form-group balance_general_capital_contable">
<input type="text" data-table="balance_general" data-field="x_capital_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->capital_contable->getPlaceHolder()) ?>" value="<?php echo $balance_general->capital_contable->EditValue ?>"<?php echo $balance_general->capital_contable->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_grid->RowCnt ?>_balance_general_capital_contable" class="balance_general_capital_contable">
<span<?php echo $balance_general->capital_contable->ViewAttributes() ?>>
<?php echo $balance_general->capital_contable->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_capital_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" value="<?php echo ew_HtmlEncode($balance_general->capital_contable->FormValue) ?>">
<input type="hidden" data-table="balance_general" data-field="x_capital_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" value="<?php echo ew_HtmlEncode($balance_general->capital_contable->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_grid->ListOptions->Render("body", "right", $balance_general_grid->RowCnt);
?>
	</tr>
<?php if ($balance_general->RowType == EW_ROWTYPE_ADD || $balance_general->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbalance_generalgrid.UpdateOpts(<?php echo $balance_general_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($balance_general->CurrentAction <> "gridadd" || $balance_general->CurrentMode == "copy")
		if (!$balance_general_grid->Recordset->EOF) $balance_general_grid->Recordset->MoveNext();
}
?>
<?php
	if ($balance_general->CurrentMode == "add" || $balance_general->CurrentMode == "copy" || $balance_general->CurrentMode == "edit") {
		$balance_general_grid->RowIndex = '$rowindex$';
		$balance_general_grid->LoadDefaultValues();

		// Set row properties
		$balance_general->ResetAttrs();
		$balance_general->RowAttrs = array_merge($balance_general->RowAttrs, array('data-rowindex'=>$balance_general_grid->RowIndex, 'id'=>'r0_balance_general', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($balance_general->RowAttrs["class"], "ewTemplate");
		$balance_general->RowType = EW_ROWTYPE_ADD;

		// Render row
		$balance_general_grid->RenderRow();

		// Render list options
		$balance_general_grid->RenderListOptions();
		$balance_general_grid->StartRowCnt = 0;
?>
	<tr<?php echo $balance_general->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_grid->ListOptions->Render("body", "left", $balance_general_grid->RowIndex);
?>
	<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<?php if ($balance_general->idempresa->getSessionValue() <> "") { ?>
<span id="el$rowindex$_balance_general_idempresa" class="form-group balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_balance_general_idempresa" class="form-group balance_general_idempresa">
<select data-table="balance_general" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idempresa->DisplayValueSeparator) ? json_encode($balance_general->idempresa->DisplayValueSeparator) : $balance_general->idempresa->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa"<?php echo $balance_general->idempresa->EditAttributes() ?>>
<?php
if (is_array($balance_general->idempresa->EditValue)) {
	$arwrk = $balance_general->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idempresa->CurrentValue) ?>" selected><?php echo $balance_general->idempresa->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idempresa->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$balance_general->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo $balance_general->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_balance_general_idempresa" class="form-group balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_idempresa" name="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="x<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_idempresa" name="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" id="o<?php echo $balance_general_grid->RowIndex ?>_idempresa" value="<?php echo ew_HtmlEncode($balance_general->idempresa->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_idperiodo_contable" class="form-group balance_general_idperiodo_contable">
<select data-table="balance_general" data-field="x_idperiodo_contable" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->idperiodo_contable->DisplayValueSeparator) ? json_encode($balance_general->idperiodo_contable->DisplayValueSeparator) : $balance_general->idperiodo_contable->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable"<?php echo $balance_general->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($balance_general->idperiodo_contable->EditValue)) {
	$arwrk = $balance_general->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general->idperiodo_contable->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general->idperiodo_contable->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general->idperiodo_contable->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->CurrentValue) ?>" selected><?php echo $balance_general->idperiodo_contable->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general->idperiodo_contable->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general->idperiodo_contable->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general->idperiodo_contable->LookupFilters += array("f0" => "`idperiodo_contable` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general->Lookup_Selecting($balance_general->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $balance_general->idperiodo_contable->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="s_x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo $balance_general->idperiodo_contable->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_idperiodo_contable" class="form-group balance_general_idperiodo_contable">
<span<?php echo $balance_general->idperiodo_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->idperiodo_contable->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_idperiodo_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_idperiodo_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_idperiodo_contable" value="<?php echo ew_HtmlEncode($balance_general->idperiodo_contable->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
		<td data-name="activo_circulante">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_activo_circulante" class="form-group balance_general_activo_circulante">
<input type="text" data-table="balance_general" data-field="x_activo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_circulante->EditValue ?>"<?php echo $balance_general->activo_circulante->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_activo_circulante" class="form-group balance_general_activo_circulante">
<span<?php echo $balance_general->activo_circulante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->activo_circulante->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" value="<?php echo ew_HtmlEncode($balance_general->activo_circulante->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_activo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_circulante" value="<?php echo ew_HtmlEncode($balance_general->activo_circulante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
		<td data-name="activo_fijo">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_activo_fijo" class="form-group balance_general_activo_fijo">
<input type="text" data-table="balance_general" data-field="x_activo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_fijo->EditValue ?>"<?php echo $balance_general->activo_fijo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_activo_fijo" class="form-group balance_general_activo_fijo">
<span<?php echo $balance_general->activo_fijo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->activo_fijo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_activo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" value="<?php echo ew_HtmlEncode($balance_general->activo_fijo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_activo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_activo_fijo" value="<?php echo ew_HtmlEncode($balance_general->activo_fijo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
		<td data-name="pasivo_circulante">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_pasivo_circulante" class="form-group balance_general_pasivo_circulante">
<input type="text" data-table="balance_general" data-field="x_pasivo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_circulante->EditValue ?>"<?php echo $balance_general->pasivo_circulante->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_pasivo_circulante" class="form-group balance_general_pasivo_circulante">
<span<?php echo $balance_general->pasivo_circulante->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->pasivo_circulante->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_circulante" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" value="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_circulante" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_circulante" value="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
		<td data-name="pasivo_fijo">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_pasivo_fijo" class="form-group balance_general_pasivo_fijo">
<input type="text" data-table="balance_general" data-field="x_pasivo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_fijo->EditValue ?>"<?php echo $balance_general->pasivo_fijo->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_pasivo_fijo" class="form-group balance_general_pasivo_fijo">
<span<?php echo $balance_general->pasivo_fijo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->pasivo_fijo->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_fijo" name="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="x<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" value="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_pasivo_fijo" name="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" id="o<?php echo $balance_general_grid->RowIndex ?>_pasivo_fijo" value="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
		<td data-name="capital_contable">
<?php if ($balance_general->CurrentAction <> "F") { ?>
<span id="el$rowindex$_balance_general_capital_contable" class="form-group balance_general_capital_contable">
<input type="text" data-table="balance_general" data-field="x_capital_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->capital_contable->getPlaceHolder()) ?>" value="<?php echo $balance_general->capital_contable->EditValue ?>"<?php echo $balance_general->capital_contable->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_balance_general_capital_contable" class="form-group balance_general_capital_contable">
<span<?php echo $balance_general->capital_contable->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $balance_general->capital_contable->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="balance_general" data-field="x_capital_contable" name="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="x<?php echo $balance_general_grid->RowIndex ?>_capital_contable" value="<?php echo ew_HtmlEncode($balance_general->capital_contable->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="balance_general" data-field="x_capital_contable" name="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" id="o<?php echo $balance_general_grid->RowIndex ?>_capital_contable" value="<?php echo ew_HtmlEncode($balance_general->capital_contable->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_grid->ListOptions->Render("body", "right", $balance_general_grid->RowCnt);
?>
<script type="text/javascript">
fbalance_generalgrid.UpdateOpts(<?php echo $balance_general_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($balance_general->CurrentMode == "add" || $balance_general->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $balance_general_grid->FormKeyCountName ?>" id="<?php echo $balance_general_grid->FormKeyCountName ?>" value="<?php echo $balance_general_grid->KeyCount ?>">
<?php echo $balance_general_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $balance_general_grid->FormKeyCountName ?>" id="<?php echo $balance_general_grid->FormKeyCountName ?>" value="<?php echo $balance_general_grid->KeyCount ?>">
<?php echo $balance_general_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fbalance_generalgrid">
</div>
<?php

// Close recordset
if ($balance_general_grid->Recordset)
	$balance_general_grid->Recordset->Close();
?>
<?php if ($balance_general_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($balance_general_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($balance_general_grid->TotalRecs == 0 && $balance_general->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($balance_general->Export == "") { ?>
<script type="text/javascript">
fbalance_generalgrid.Init();
</script>
<?php } ?>
<?php
$balance_general_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$balance_general_grid->Page_Terminate();
?>
