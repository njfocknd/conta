<?php

// Create page object
if (!isset($caja_chica_cheque_grid)) $caja_chica_cheque_grid = new ccaja_chica_cheque_grid();

// Page init
$caja_chica_cheque_grid->Page_Init();

// Page main
$caja_chica_cheque_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_cheque_grid->Page_Render();
?>
<?php if ($caja_chica_cheque->Export == "") { ?>
<script type="text/javascript">

// Form object
var fcaja_chica_chequegrid = new ew_Form("fcaja_chica_chequegrid", "grid");
fcaja_chica_chequegrid.FormKeyCountName = '<?php echo $caja_chica_cheque_grid->FormKeyCountName ?>';

// Validate form
fcaja_chica_chequegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcaja_chica");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_cheque->idcaja_chica->FldCaption(), $caja_chica_cheque->idcaja_chica->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbanco");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_cheque->idbanco->FldCaption(), $caja_chica_cheque->idbanco->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idbanco_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_cheque->idbanco_cuenta->FldCaption(), $caja_chica_cheque->idbanco_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_cheque->fecha->FldCaption(), $caja_chica_cheque->fecha->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_cheque->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_cheque->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_cheque->status->FldCaption(), $caja_chica_cheque->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fcaja_chica_chequegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idcaja_chica", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbanco", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idbanco_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "fecha", false)) return false;
	if (ew_ValueChanged(fobj, infix, "numero", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	return true;
}

// Form_CustomValidate event
fcaja_chica_chequegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_chequegrid.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_chequegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcaja_chica_chequegrid.Lists["x_idcaja_chica"] = {"LinkField":"x_idcaja_chica","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcaja_chica_chequegrid.Lists["x_idbanco"] = {"LinkField":"x_idbanco","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idbanco_cuenta"],"FilterFields":[],"Options":[],"Template":""};
fcaja_chica_chequegrid.Lists["x_idbanco_cuenta"] = {"LinkField":"x_idbanco_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","x_numero","",""],"ParentFields":["x_idbanco"],"ChildFields":[],"FilterFields":["x_idbanco"],"Options":[],"Template":""};
fcaja_chica_chequegrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcaja_chica_chequegrid.Lists["x_status"].Options = <?php echo json_encode($caja_chica_cheque->status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($caja_chica_cheque->CurrentAction == "gridadd") {
	if ($caja_chica_cheque->CurrentMode == "copy") {
		$bSelectLimit = $caja_chica_cheque_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$caja_chica_cheque_grid->TotalRecs = $caja_chica_cheque->SelectRecordCount();
			$caja_chica_cheque_grid->Recordset = $caja_chica_cheque_grid->LoadRecordset($caja_chica_cheque_grid->StartRec-1, $caja_chica_cheque_grid->DisplayRecs);
		} else {
			if ($caja_chica_cheque_grid->Recordset = $caja_chica_cheque_grid->LoadRecordset())
				$caja_chica_cheque_grid->TotalRecs = $caja_chica_cheque_grid->Recordset->RecordCount();
		}
		$caja_chica_cheque_grid->StartRec = 1;
		$caja_chica_cheque_grid->DisplayRecs = $caja_chica_cheque_grid->TotalRecs;
	} else {
		$caja_chica_cheque->CurrentFilter = "0=1";
		$caja_chica_cheque_grid->StartRec = 1;
		$caja_chica_cheque_grid->DisplayRecs = $caja_chica_cheque->GridAddRowCount;
	}
	$caja_chica_cheque_grid->TotalRecs = $caja_chica_cheque_grid->DisplayRecs;
	$caja_chica_cheque_grid->StopRec = $caja_chica_cheque_grid->DisplayRecs;
} else {
	$bSelectLimit = $caja_chica_cheque_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($caja_chica_cheque_grid->TotalRecs <= 0)
			$caja_chica_cheque_grid->TotalRecs = $caja_chica_cheque->SelectRecordCount();
	} else {
		if (!$caja_chica_cheque_grid->Recordset && ($caja_chica_cheque_grid->Recordset = $caja_chica_cheque_grid->LoadRecordset()))
			$caja_chica_cheque_grid->TotalRecs = $caja_chica_cheque_grid->Recordset->RecordCount();
	}
	$caja_chica_cheque_grid->StartRec = 1;
	$caja_chica_cheque_grid->DisplayRecs = $caja_chica_cheque_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$caja_chica_cheque_grid->Recordset = $caja_chica_cheque_grid->LoadRecordset($caja_chica_cheque_grid->StartRec-1, $caja_chica_cheque_grid->DisplayRecs);

	// Set no record found message
	if ($caja_chica_cheque->CurrentAction == "" && $caja_chica_cheque_grid->TotalRecs == 0) {
		if ($caja_chica_cheque_grid->SearchWhere == "0=101")
			$caja_chica_cheque_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$caja_chica_cheque_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$caja_chica_cheque_grid->RenderOtherOptions();
?>
<?php $caja_chica_cheque_grid->ShowPageHeader(); ?>
<?php
$caja_chica_cheque_grid->ShowMessage();
?>
<?php if ($caja_chica_cheque_grid->TotalRecs > 0 || $caja_chica_cheque->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div id="fcaja_chica_chequegrid" class="ewForm form-inline">
<div id="gmp_caja_chica_cheque" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table id="tbl_caja_chica_chequegrid" class="table ewTable">
<?php echo $caja_chica_cheque->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$caja_chica_cheque_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$caja_chica_cheque_grid->RenderListOptions();

// Render list options (header, left)
$caja_chica_cheque_grid->ListOptions->Render("header", "left");
?>
<?php if ($caja_chica_cheque->idcaja_chica->Visible) { // idcaja_chica ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->idcaja_chica) == "") { ?>
		<th data-name="idcaja_chica"><div id="elh_caja_chica_cheque_idcaja_chica" class="caja_chica_cheque_idcaja_chica"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idcaja_chica->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcaja_chica"><div><div id="elh_caja_chica_cheque_idcaja_chica" class="caja_chica_cheque_idcaja_chica">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idcaja_chica->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->idcaja_chica->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->idcaja_chica->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->idbanco->Visible) { // idbanco ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->idbanco) == "") { ?>
		<th data-name="idbanco"><div id="elh_caja_chica_cheque_idbanco" class="caja_chica_cheque_idbanco"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idbanco->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco"><div><div id="elh_caja_chica_cheque_idbanco" class="caja_chica_cheque_idbanco">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idbanco->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->idbanco->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->idbanco->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->idbanco_cuenta->Visible) { // idbanco_cuenta ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->idbanco_cuenta) == "") { ?>
		<th data-name="idbanco_cuenta"><div id="elh_caja_chica_cheque_idbanco_cuenta" class="caja_chica_cheque_idbanco_cuenta"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idbanco_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idbanco_cuenta"><div><div id="elh_caja_chica_cheque_idbanco_cuenta" class="caja_chica_cheque_idbanco_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->idbanco_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->idbanco_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->idbanco_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->fecha->Visible) { // fecha ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->fecha) == "") { ?>
		<th data-name="fecha"><div id="elh_caja_chica_cheque_fecha" class="caja_chica_cheque_fecha"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->fecha->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="fecha"><div><div id="elh_caja_chica_cheque_fecha" class="caja_chica_cheque_fecha">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->fecha->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->fecha->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->fecha->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->numero->Visible) { // numero ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->numero) == "") { ?>
		<th data-name="numero"><div id="elh_caja_chica_cheque_numero" class="caja_chica_cheque_numero"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->numero->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="numero"><div><div id="elh_caja_chica_cheque_numero" class="caja_chica_cheque_numero">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->numero->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->numero->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->numero->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->monto->Visible) { // monto ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->monto) == "") { ?>
		<th data-name="monto"><div id="elh_caja_chica_cheque_monto" class="caja_chica_cheque_monto"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div><div id="elh_caja_chica_cheque_monto" class="caja_chica_cheque_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($caja_chica_cheque->status->Visible) { // status ?>
	<?php if ($caja_chica_cheque->SortUrl($caja_chica_cheque->status) == "") { ?>
		<th data-name="status"><div id="elh_caja_chica_cheque_status" class="caja_chica_cheque_status"><div class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status"><div><div id="elh_caja_chica_cheque_status" class="caja_chica_cheque_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $caja_chica_cheque->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($caja_chica_cheque->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($caja_chica_cheque->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$caja_chica_cheque_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$caja_chica_cheque_grid->StartRec = 1;
$caja_chica_cheque_grid->StopRec = $caja_chica_cheque_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($caja_chica_cheque_grid->FormKeyCountName) && ($caja_chica_cheque->CurrentAction == "gridadd" || $caja_chica_cheque->CurrentAction == "gridedit" || $caja_chica_cheque->CurrentAction == "F")) {
		$caja_chica_cheque_grid->KeyCount = $objForm->GetValue($caja_chica_cheque_grid->FormKeyCountName);
		$caja_chica_cheque_grid->StopRec = $caja_chica_cheque_grid->StartRec + $caja_chica_cheque_grid->KeyCount - 1;
	}
}
$caja_chica_cheque_grid->RecCnt = $caja_chica_cheque_grid->StartRec - 1;
if ($caja_chica_cheque_grid->Recordset && !$caja_chica_cheque_grid->Recordset->EOF) {
	$caja_chica_cheque_grid->Recordset->MoveFirst();
	$bSelectLimit = $caja_chica_cheque_grid->UseSelectLimit;
	if (!$bSelectLimit && $caja_chica_cheque_grid->StartRec > 1)
		$caja_chica_cheque_grid->Recordset->Move($caja_chica_cheque_grid->StartRec - 1);
} elseif (!$caja_chica_cheque->AllowAddDeleteRow && $caja_chica_cheque_grid->StopRec == 0) {
	$caja_chica_cheque_grid->StopRec = $caja_chica_cheque->GridAddRowCount;
}

// Initialize aggregate
$caja_chica_cheque->RowType = EW_ROWTYPE_AGGREGATEINIT;
$caja_chica_cheque->ResetAttrs();
$caja_chica_cheque_grid->RenderRow();
if ($caja_chica_cheque->CurrentAction == "gridadd")
	$caja_chica_cheque_grid->RowIndex = 0;
if ($caja_chica_cheque->CurrentAction == "gridedit")
	$caja_chica_cheque_grid->RowIndex = 0;
while ($caja_chica_cheque_grid->RecCnt < $caja_chica_cheque_grid->StopRec) {
	$caja_chica_cheque_grid->RecCnt++;
	if (intval($caja_chica_cheque_grid->RecCnt) >= intval($caja_chica_cheque_grid->StartRec)) {
		$caja_chica_cheque_grid->RowCnt++;
		if ($caja_chica_cheque->CurrentAction == "gridadd" || $caja_chica_cheque->CurrentAction == "gridedit" || $caja_chica_cheque->CurrentAction == "F") {
			$caja_chica_cheque_grid->RowIndex++;
			$objForm->Index = $caja_chica_cheque_grid->RowIndex;
			if ($objForm->HasValue($caja_chica_cheque_grid->FormActionName))
				$caja_chica_cheque_grid->RowAction = strval($objForm->GetValue($caja_chica_cheque_grid->FormActionName));
			elseif ($caja_chica_cheque->CurrentAction == "gridadd")
				$caja_chica_cheque_grid->RowAction = "insert";
			else
				$caja_chica_cheque_grid->RowAction = "";
		}

		// Set up key count
		$caja_chica_cheque_grid->KeyCount = $caja_chica_cheque_grid->RowIndex;

		// Init row class and style
		$caja_chica_cheque->ResetAttrs();
		$caja_chica_cheque->CssClass = "";
		if ($caja_chica_cheque->CurrentAction == "gridadd") {
			if ($caja_chica_cheque->CurrentMode == "copy") {
				$caja_chica_cheque_grid->LoadRowValues($caja_chica_cheque_grid->Recordset); // Load row values
				$caja_chica_cheque_grid->SetRecordKey($caja_chica_cheque_grid->RowOldKey, $caja_chica_cheque_grid->Recordset); // Set old record key
			} else {
				$caja_chica_cheque_grid->LoadDefaultValues(); // Load default values
				$caja_chica_cheque_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$caja_chica_cheque_grid->LoadRowValues($caja_chica_cheque_grid->Recordset); // Load row values
		}
		$caja_chica_cheque->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($caja_chica_cheque->CurrentAction == "gridadd") // Grid add
			$caja_chica_cheque->RowType = EW_ROWTYPE_ADD; // Render add
		if ($caja_chica_cheque->CurrentAction == "gridadd" && $caja_chica_cheque->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$caja_chica_cheque_grid->RestoreCurrentRowFormValues($caja_chica_cheque_grid->RowIndex); // Restore form values
		if ($caja_chica_cheque->CurrentAction == "gridedit") { // Grid edit
			if ($caja_chica_cheque->EventCancelled) {
				$caja_chica_cheque_grid->RestoreCurrentRowFormValues($caja_chica_cheque_grid->RowIndex); // Restore form values
			}
			if ($caja_chica_cheque_grid->RowAction == "insert")
				$caja_chica_cheque->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$caja_chica_cheque->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($caja_chica_cheque->CurrentAction == "gridedit" && ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT || $caja_chica_cheque->RowType == EW_ROWTYPE_ADD) && $caja_chica_cheque->EventCancelled) // Update failed
			$caja_chica_cheque_grid->RestoreCurrentRowFormValues($caja_chica_cheque_grid->RowIndex); // Restore form values
		if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) // Edit row
			$caja_chica_cheque_grid->EditRowCnt++;
		if ($caja_chica_cheque->CurrentAction == "F") // Confirm row
			$caja_chica_cheque_grid->RestoreCurrentRowFormValues($caja_chica_cheque_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$caja_chica_cheque->RowAttrs = array_merge($caja_chica_cheque->RowAttrs, array('data-rowindex'=>$caja_chica_cheque_grid->RowCnt, 'id'=>'r' . $caja_chica_cheque_grid->RowCnt . '_caja_chica_cheque', 'data-rowtype'=>$caja_chica_cheque->RowType));

		// Render row
		$caja_chica_cheque_grid->RenderRow();

		// Render list options
		$caja_chica_cheque_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($caja_chica_cheque_grid->RowAction <> "delete" && $caja_chica_cheque_grid->RowAction <> "insertdelete" && !($caja_chica_cheque_grid->RowAction == "insert" && $caja_chica_cheque->CurrentAction == "F" && $caja_chica_cheque_grid->EmptyRow())) {
?>
	<tr<?php echo $caja_chica_cheque->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_cheque_grid->ListOptions->Render("body", "left", $caja_chica_cheque_grid->RowCnt);
?>
	<?php if ($caja_chica_cheque->idcaja_chica->Visible) { // idcaja_chica ?>
		<td data-name="idcaja_chica"<?php echo $caja_chica_cheque->idcaja_chica->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($caja_chica_cheque->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<span<?php echo $caja_chica_cheque->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<select data-table="caja_chica_cheque" data-field="x_idcaja_chica" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) : $caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica"<?php echo $caja_chica_cheque->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->idcaja_chica->EditValue)) {
	$arwrk = $caja_chica_cheque->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->idcaja_chica->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->idcaja_chica->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->idcaja_chica->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->idcaja_chica->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idcaja_chica->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idcaja_chica->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idcaja_chica->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idcaja_chica, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica_cheque->idcaja_chica->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo $caja_chica_cheque->idcaja_chica->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($caja_chica_cheque->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<span<?php echo $caja_chica_cheque->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<select data-table="caja_chica_cheque" data-field="x_idcaja_chica" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) : $caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica"<?php echo $caja_chica_cheque->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->idcaja_chica->EditValue)) {
	$arwrk = $caja_chica_cheque->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->idcaja_chica->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->idcaja_chica->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->idcaja_chica->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->idcaja_chica->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idcaja_chica->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idcaja_chica->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idcaja_chica->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idcaja_chica, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica_cheque->idcaja_chica->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo $caja_chica_cheque->idcaja_chica->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idcaja_chica" class="caja_chica_cheque_idcaja_chica">
<span<?php echo $caja_chica_cheque->idcaja_chica->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->idcaja_chica->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->OldValue) ?>">
<?php } ?>
<a id="<?php echo $caja_chica_cheque_grid->PageObjName . "_row_" . $caja_chica_cheque_grid->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica_cheque" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica_cheque->CurrentValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica_cheque" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica_cheque->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT || $caja_chica_cheque->CurrentMode == "edit") { ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica_cheque" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica_cheque" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica_cheque->CurrentValue) ?>">
<?php } ?>
	<?php if ($caja_chica_cheque->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco"<?php echo $caja_chica_cheque->idbanco->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco" class="form-group caja_chica_cheque_idbanco">
<?php $caja_chica_cheque->idbanco->EditAttrs["onclick"] = "ew_UpdateOpt.call(this); " . @$caja_chica_cheque->idbanco->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco->DisplayValueSeparator) : $caja_chica_cheque->idbanco->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="{value}"<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo $caja_chica_cheque->idbanco->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco" class="form-group caja_chica_cheque_idbanco">
<?php $caja_chica_cheque->idbanco->EditAttrs["onclick"] = "ew_UpdateOpt.call(this); " . @$caja_chica_cheque->idbanco->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco->DisplayValueSeparator) : $caja_chica_cheque->idbanco->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="{value}"<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo $caja_chica_cheque->idbanco->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco" class="caja_chica_cheque_idbanco">
<span<?php echo $caja_chica_cheque->idbanco->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->idbanco->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->idbanco_cuenta->Visible) { // idbanco_cuenta ?>
		<td data-name="idbanco_cuenta"<?php echo $caja_chica_cheque->idbanco_cuenta->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($caja_chica_cheque->idbanco_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<span<?php echo $caja_chica_cheque->idbanco_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco_cuenta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco_cuenta->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) : $caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="{value}"<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco_cuenta`, `nombre` AS `DispFld`, `numero` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f0" => "`idbanco_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f1" => "`idbanco` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo $caja_chica_cheque->idbanco_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($caja_chica_cheque->idbanco_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<span<?php echo $caja_chica_cheque->idbanco_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco_cuenta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco_cuenta->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) : $caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="{value}"<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco_cuenta`, `nombre` AS `DispFld`, `numero` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f0" => "`idbanco_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f1" => "`idbanco` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo $caja_chica_cheque->idbanco_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_idbanco_cuenta" class="caja_chica_cheque_idbanco_cuenta">
<span<?php echo $caja_chica_cheque->idbanco_cuenta->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->idbanco_cuenta->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->fecha->Visible) { // fecha ?>
		<td data-name="fecha"<?php echo $caja_chica_cheque->fecha->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_fecha" class="form-group caja_chica_cheque_fecha">
<input type="text" data-table="caja_chica_cheque" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->fecha->EditValue ?>"<?php echo $caja_chica_cheque->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_cheque->fecha->ReadOnly && !$caja_chica_cheque->fecha->Disabled && !isset($caja_chica_cheque->fecha->EditAttrs["readonly"]) && !isset($caja_chica_cheque->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_chequegrid", "x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_fecha" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_fecha" class="form-group caja_chica_cheque_fecha">
<input type="text" data-table="caja_chica_cheque" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->fecha->EditValue ?>"<?php echo $caja_chica_cheque->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_cheque->fecha->ReadOnly && !$caja_chica_cheque->fecha->Disabled && !isset($caja_chica_cheque->fecha->EditAttrs["readonly"]) && !isset($caja_chica_cheque->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_chequegrid", "x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_fecha" class="caja_chica_cheque_fecha">
<span<?php echo $caja_chica_cheque->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->fecha->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_fecha" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_fecha" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->numero->Visible) { // numero ?>
		<td data-name="numero"<?php echo $caja_chica_cheque->numero->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_numero" class="form-group caja_chica_cheque_numero">
<input type="text" data-table="caja_chica_cheque" data-field="x_numero" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->numero->EditValue ?>"<?php echo $caja_chica_cheque->numero->EditAttributes() ?>>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_numero" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_numero" class="form-group caja_chica_cheque_numero">
<input type="text" data-table="caja_chica_cheque" data-field="x_numero" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->numero->EditValue ?>"<?php echo $caja_chica_cheque->numero->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_numero" class="caja_chica_cheque_numero">
<span<?php echo $caja_chica_cheque->numero->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->numero->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_numero" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_numero" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $caja_chica_cheque->monto->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_monto" class="form-group caja_chica_cheque_monto">
<input type="text" data-table="caja_chica_cheque" data-field="x_monto" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->monto->EditValue ?>"<?php echo $caja_chica_cheque->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_monto" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_monto" class="form-group caja_chica_cheque_monto">
<input type="text" data-table="caja_chica_cheque" data-field="x_monto" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->monto->EditValue ?>"<?php echo $caja_chica_cheque->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_monto" class="caja_chica_cheque_monto">
<span<?php echo $caja_chica_cheque->monto->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->monto->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_monto" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_monto" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->status->Visible) { // status ?>
		<td data-name="status"<?php echo $caja_chica_cheque->status->CellAttributes() ?>>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_status" class="form-group caja_chica_cheque_status">
<select data-table="caja_chica_cheque" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->status->DisplayValueSeparator) ? json_encode($caja_chica_cheque->status->DisplayValueSeparator) : $caja_chica_cheque->status->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status"<?php echo $caja_chica_cheque->status->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->status->EditValue)) {
	$arwrk = $caja_chica_cheque->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->status->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->status->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_status" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->OldValue) ?>">
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_status" class="form-group caja_chica_cheque_status">
<select data-table="caja_chica_cheque" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->status->DisplayValueSeparator) ? json_encode($caja_chica_cheque->status->DisplayValueSeparator) : $caja_chica_cheque->status->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status"<?php echo $caja_chica_cheque->status->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->status->EditValue)) {
	$arwrk = $caja_chica_cheque->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->status->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->status->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $caja_chica_cheque_grid->RowCnt ?>_caja_chica_cheque_status" class="caja_chica_cheque_status">
<span<?php echo $caja_chica_cheque->status->ViewAttributes() ?>>
<?php echo $caja_chica_cheque->status->ListViewValue() ?></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_status" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->FormValue) ?>">
<input type="hidden" data-table="caja_chica_cheque" data-field="x_status" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->OldValue) ?>">
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_cheque_grid->ListOptions->Render("body", "right", $caja_chica_cheque_grid->RowCnt);
?>
	</tr>
<?php if ($caja_chica_cheque->RowType == EW_ROWTYPE_ADD || $caja_chica_cheque->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcaja_chica_chequegrid.UpdateOpts(<?php echo $caja_chica_cheque_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($caja_chica_cheque->CurrentAction <> "gridadd" || $caja_chica_cheque->CurrentMode == "copy")
		if (!$caja_chica_cheque_grid->Recordset->EOF) $caja_chica_cheque_grid->Recordset->MoveNext();
}
?>
<?php
	if ($caja_chica_cheque->CurrentMode == "add" || $caja_chica_cheque->CurrentMode == "copy" || $caja_chica_cheque->CurrentMode == "edit") {
		$caja_chica_cheque_grid->RowIndex = '$rowindex$';
		$caja_chica_cheque_grid->LoadDefaultValues();

		// Set row properties
		$caja_chica_cheque->ResetAttrs();
		$caja_chica_cheque->RowAttrs = array_merge($caja_chica_cheque->RowAttrs, array('data-rowindex'=>$caja_chica_cheque_grid->RowIndex, 'id'=>'r0_caja_chica_cheque', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($caja_chica_cheque->RowAttrs["class"], "ewTemplate");
		$caja_chica_cheque->RowType = EW_ROWTYPE_ADD;

		// Render row
		$caja_chica_cheque_grid->RenderRow();

		// Render list options
		$caja_chica_cheque_grid->RenderListOptions();
		$caja_chica_cheque_grid->StartRowCnt = 0;
?>
	<tr<?php echo $caja_chica_cheque->RowAttributes() ?>>
<?php

// Render list options (body, left)
$caja_chica_cheque_grid->ListOptions->Render("body", "left", $caja_chica_cheque_grid->RowIndex);
?>
	<?php if ($caja_chica_cheque->idcaja_chica->Visible) { // idcaja_chica ?>
		<td data-name="idcaja_chica">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<?php if ($caja_chica_cheque->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el$rowindex$_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<span<?php echo $caja_chica_cheque->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<select data-table="caja_chica_cheque" data-field="x_idcaja_chica" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idcaja_chica->DisplayValueSeparator) : $caja_chica_cheque->idcaja_chica->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica"<?php echo $caja_chica_cheque->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->idcaja_chica->EditValue)) {
	$arwrk = $caja_chica_cheque->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->idcaja_chica->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->idcaja_chica->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->idcaja_chica->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->idcaja_chica->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idcaja_chica->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idcaja_chica->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idcaja_chica->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idcaja_chica, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica_cheque->idcaja_chica->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo $caja_chica_cheque->idcaja_chica->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_idcaja_chica" class="form-group caja_chica_cheque_idcaja_chica">
<span<?php echo $caja_chica_cheque->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idcaja_chica" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idcaja_chica" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idcaja_chica->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->idbanco->Visible) { // idbanco ?>
		<td data-name="idbanco">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_cheque_idbanco" class="form-group caja_chica_cheque_idbanco">
<?php $caja_chica_cheque->idbanco->EditAttrs["onclick"] = "ew_UpdateOpt.call(this); " . @$caja_chica_cheque->idbanco->EditAttrs["onclick"]; ?>
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco->DisplayValueSeparator) : $caja_chica_cheque->idbanco->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="{value}"<?php echo $caja_chica_cheque->idbanco->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco->LookupFilters += array("f0" => "`idbanco` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo $caja_chica_cheque->idbanco->LookupFilterQuery() ?>">
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_idbanco" class="form-group caja_chica_cheque_idbanco">
<span<?php echo $caja_chica_cheque->idbanco->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idbanco->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->idbanco_cuenta->Visible) { // idbanco_cuenta ?>
		<td data-name="idbanco_cuenta">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<?php if ($caja_chica_cheque->idbanco_cuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<span<?php echo $caja_chica_cheque->idbanco_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<div class="ewDropdownList has-feedback">
	<span onclick="" class="form-control dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?>
	</span>
	<span class="glyphicon glyphicon-remove form-control-feedback ewDropdownListClear"></span>
	<span class="form-control-feedback"><span class="caret"></span></span>
	<div id="dsl_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" data-repeatcolumn="1" class="dropdown-menu">
		<div class="ewItems" style="position: relative; overflow-x: hidden;">
<?php
$arwrk = $caja_chica_cheque->idbanco_cuenta->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "") {
			$emptywrk = FALSE;
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
<?php
		}
	}
	if ($emptywrk && strval($caja_chica_cheque->idbanco_cuenta->CurrentValue) <> "") {
?>
<input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->CurrentValue) ?>" checked<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>><?php echo $caja_chica_cheque->idbanco_cuenta->CurrentValue ?>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->idbanco_cuenta->OldValue = "";
?>
		</div>
	</div>
	<div id="tp_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" class="ewTemplate"><input type="radio" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ? json_encode($caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) : $caja_chica_cheque->idbanco_cuenta->DisplayValueSeparator) ?>" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="{value}"<?php echo $caja_chica_cheque->idbanco_cuenta->EditAttributes() ?>></div>
</div>
<?php
$sSqlWrk = "SELECT `idbanco_cuenta`, `nombre` AS `DispFld`, `numero` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `banco_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica_cheque->idbanco_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f0" => "`idbanco_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$caja_chica_cheque->idbanco_cuenta->LookupFilters += array("f1" => "`idbanco` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$caja_chica_cheque->Lookup_Selecting($caja_chica_cheque->idbanco_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $caja_chica_cheque->idbanco_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="s_x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo $caja_chica_cheque->idbanco_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_idbanco_cuenta" class="form-group caja_chica_cheque_idbanco_cuenta">
<span<?php echo $caja_chica_cheque->idbanco_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->idbanco_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_idbanco_cuenta" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_idbanco_cuenta" value="<?php echo ew_HtmlEncode($caja_chica_cheque->idbanco_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->fecha->Visible) { // fecha ?>
		<td data-name="fecha">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_cheque_fecha" class="form-group caja_chica_cheque_fecha">
<input type="text" data-table="caja_chica_cheque" data-field="x_fecha" data-format="7" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->fecha->EditValue ?>"<?php echo $caja_chica_cheque->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_cheque->fecha->ReadOnly && !$caja_chica_cheque->fecha->Disabled && !isset($caja_chica_cheque->fecha->EditAttrs["readonly"]) && !isset($caja_chica_cheque->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_chequegrid", "x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_fecha" class="form-group caja_chica_cheque_fecha">
<span<?php echo $caja_chica_cheque->fecha->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->fecha->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_fecha" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_fecha" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_fecha" value="<?php echo ew_HtmlEncode($caja_chica_cheque->fecha->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->numero->Visible) { // numero ?>
		<td data-name="numero">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_cheque_numero" class="form-group caja_chica_cheque_numero">
<input type="text" data-table="caja_chica_cheque" data-field="x_numero" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->numero->EditValue ?>"<?php echo $caja_chica_cheque->numero->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_numero" class="form-group caja_chica_cheque_numero">
<span<?php echo $caja_chica_cheque->numero->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->numero->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_numero" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_numero" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_numero" value="<?php echo ew_HtmlEncode($caja_chica_cheque->numero->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->monto->Visible) { // monto ?>
		<td data-name="monto">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_cheque_monto" class="form-group caja_chica_cheque_monto">
<input type="text" data-table="caja_chica_cheque" data-field="x_monto" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_cheque->monto->EditValue ?>"<?php echo $caja_chica_cheque->monto->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_monto" class="form-group caja_chica_cheque_monto">
<span<?php echo $caja_chica_cheque->monto->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->monto->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_monto" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_monto" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($caja_chica_cheque->monto->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($caja_chica_cheque->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($caja_chica_cheque->CurrentAction <> "F") { ?>
<span id="el$rowindex$_caja_chica_cheque_status" class="form-group caja_chica_cheque_status">
<select data-table="caja_chica_cheque" data-field="x_status" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica_cheque->status->DisplayValueSeparator) ? json_encode($caja_chica_cheque->status->DisplayValueSeparator) : $caja_chica_cheque->status->DisplayValueSeparator) ?>" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status"<?php echo $caja_chica_cheque->status->EditAttributes() ?>>
<?php
if (is_array($caja_chica_cheque->status->EditValue)) {
	$arwrk = $caja_chica_cheque->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica_cheque->status->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica_cheque->status->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica_cheque->status->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->CurrentValue) ?>" selected><?php echo $caja_chica_cheque->status->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $caja_chica_cheque->status->OldValue = "";
?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_caja_chica_cheque_status" class="form-group caja_chica_cheque_status">
<span<?php echo $caja_chica_cheque->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_cheque->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_status" name="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" id="x<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="caja_chica_cheque" data-field="x_status" name="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" id="o<?php echo $caja_chica_cheque_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($caja_chica_cheque->status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$caja_chica_cheque_grid->ListOptions->Render("body", "right", $caja_chica_cheque_grid->RowCnt);
?>
<script type="text/javascript">
fcaja_chica_chequegrid.UpdateOpts(<?php echo $caja_chica_cheque_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($caja_chica_cheque->CurrentMode == "add" || $caja_chica_cheque->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $caja_chica_cheque_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_cheque_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_cheque_grid->KeyCount ?>">
<?php echo $caja_chica_cheque_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_cheque->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $caja_chica_cheque_grid->FormKeyCountName ?>" id="<?php echo $caja_chica_cheque_grid->FormKeyCountName ?>" value="<?php echo $caja_chica_cheque_grid->KeyCount ?>">
<?php echo $caja_chica_cheque_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($caja_chica_cheque->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fcaja_chica_chequegrid">
</div>
<?php

// Close recordset
if ($caja_chica_cheque_grid->Recordset)
	$caja_chica_cheque_grid->Recordset->Close();
?>
<?php if ($caja_chica_cheque_grid->ShowOtherOptions) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php
	foreach ($caja_chica_cheque_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($caja_chica_cheque_grid->TotalRecs == 0 && $caja_chica_cheque->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($caja_chica_cheque_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($caja_chica_cheque->Export == "") { ?>
<script type="text/javascript">
fcaja_chica_chequegrid.Init();
</script>
<?php } ?>
<?php
$caja_chica_cheque_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$caja_chica_cheque_grid->Page_Terminate();
?>
