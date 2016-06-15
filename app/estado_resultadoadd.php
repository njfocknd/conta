<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "estado_resultadoinfo.php" ?>
<?php include_once "estado_resultado_detallegridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$estado_resultado_add = NULL; // Initialize page object first

class cestado_resultado_add extends cestado_resultado {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'estado_resultado';

	// Page object name
	var $PageObjName = 'estado_resultado_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (estado_resultado)
		if (!isset($GLOBALS["estado_resultado"]) || get_class($GLOBALS["estado_resultado"]) == "cestado_resultado") {
			$GLOBALS["estado_resultado"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_resultado"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_resultado', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {

			// Process auto fill for detail table 'estado_resultado_detalle'
			if (@$_POST["grid"] == "festado_resultado_detallegrid") {
				if (!isset($GLOBALS["estado_resultado_detalle_grid"])) $GLOBALS["estado_resultado_detalle_grid"] = new cestado_resultado_detalle_grid;
				$GLOBALS["estado_resultado_detalle_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $estado_resultado;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_resultado);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idestado_resultado"] != "") {
				$this->idestado_resultado->setQueryStringValue($_GET["idestado_resultado"]);
				$this->setKey("idestado_resultado", $this->idestado_resultado->CurrentValue); // Set up key
			} else {
				$this->setKey("idestado_resultado", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Set up detail parameters
		$this->SetUpDetailParms();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("estado_resultadolist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "estado_resultadolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "estado_resultadoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->idempresa->CurrentValue = 1;
		$this->idperiodo_contable->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idempresa->FldIsDetailKey) {
			$this->idempresa->setFormValue($objForm->GetValue("x_idempresa"));
		}
		if (!$this->idperiodo_contable->FldIsDetailKey) {
			$this->idperiodo_contable->setFormValue($objForm->GetValue("x_idperiodo_contable"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
		$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->idestado_resultado->setDbValue($rs->fields('idestado_resultado'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->venta_netas->setDbValue($rs->fields('venta_netas'));
		$this->costo_ventas->setDbValue($rs->fields('costo_ventas'));
		$this->depreciacion->setDbValue($rs->fields('depreciacion'));
		$this->interes_pagado->setDbValue($rs->fields('interes_pagado'));
		$this->impuestos->setDbValue($rs->fields('impuestos'));
		$this->dividendos->setDbValue($rs->fields('dividendos'));
		$this->utilidades_retenidas->setDbValue($rs->fields('utilidades_retenidas'));
		$this->utilidad_neta->setDbValue($rs->fields('utilidad_neta'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idestado_resultado->DbValue = $row['idestado_resultado'];
		$this->idempresa->DbValue = $row['idempresa'];
		$this->idperiodo_contable->DbValue = $row['idperiodo_contable'];
		$this->venta_netas->DbValue = $row['venta_netas'];
		$this->costo_ventas->DbValue = $row['costo_ventas'];
		$this->depreciacion->DbValue = $row['depreciacion'];
		$this->interes_pagado->DbValue = $row['interes_pagado'];
		$this->impuestos->DbValue = $row['impuestos'];
		$this->dividendos->DbValue = $row['dividendos'];
		$this->utilidades_retenidas->DbValue = $row['utilidades_retenidas'];
		$this->utilidad_neta->DbValue = $row['utilidad_neta'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idestado_resultado")) <> "")
			$this->idestado_resultado->CurrentValue = $this->getKey("idestado_resultado"); // idestado_resultado
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idestado_resultado
		// idempresa
		// idperiodo_contable
		// venta_netas
		// costo_ventas
		// depreciacion
		// interes_pagado
		// impuestos
		// dividendos
		// utilidades_retenidas
		// utilidad_neta
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idestado_resultado
		$this->idestado_resultado->ViewValue = $this->idestado_resultado->CurrentValue;
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idempresa
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idempresa, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idempresa->ViewValue = $this->idempresa->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
			}
		} else {
			$this->idempresa->ViewValue = NULL;
		}
		$this->idempresa->ViewCustomAttributes = "";

		// idperiodo_contable
		if (strval($this->idperiodo_contable->CurrentValue) <> "") {
			$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->CurrentValue;
			}
		} else {
			$this->idperiodo_contable->ViewValue = NULL;
		}
		$this->idperiodo_contable->ViewCustomAttributes = "";

		// venta_netas
		$this->venta_netas->ViewValue = $this->venta_netas->CurrentValue;
		$this->venta_netas->ViewCustomAttributes = "";

		// costo_ventas
		$this->costo_ventas->ViewValue = $this->costo_ventas->CurrentValue;
		$this->costo_ventas->ViewCustomAttributes = "";

		// depreciacion
		$this->depreciacion->ViewValue = $this->depreciacion->CurrentValue;
		$this->depreciacion->ViewCustomAttributes = "";

		// interes_pagado
		$this->interes_pagado->ViewValue = $this->interes_pagado->CurrentValue;
		$this->interes_pagado->ViewCustomAttributes = "";

		// impuestos
		$this->impuestos->ViewValue = $this->impuestos->CurrentValue;
		$this->impuestos->ViewCustomAttributes = "";

		// dividendos
		$this->dividendos->ViewValue = $this->dividendos->CurrentValue;
		$this->dividendos->ViewCustomAttributes = "";

		// utilidades_retenidas
		$this->utilidades_retenidas->ViewValue = $this->utilidades_retenidas->CurrentValue;
		$this->utilidades_retenidas->ViewCustomAttributes = "";

		// utilidad_neta
		$this->utilidad_neta->ViewValue = $this->utilidad_neta->CurrentValue;
		$this->utilidad_neta->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";
			$this->idperiodo_contable->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			if (trim(strval($this->idperiodo_contable->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `periodo_contable`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idperiodo_contable->EditValue = $arwrk;

			// Add refer script
			// idempresa

			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->idempresa->FldIsDetailKey && !is_null($this->idempresa->FormValue) && $this->idempresa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempresa->FldCaption(), $this->idempresa->ReqErrMsg));
		}
		if (!$this->idperiodo_contable->FldIsDetailKey && !is_null($this->idperiodo_contable->FormValue) && $this->idperiodo_contable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idperiodo_contable->FldCaption(), $this->idperiodo_contable->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("estado_resultado_detalle", $DetailTblVar) && $GLOBALS["estado_resultado_detalle"]->DetailAdd) {
			if (!isset($GLOBALS["estado_resultado_detalle_grid"])) $GLOBALS["estado_resultado_detalle_grid"] = new cestado_resultado_detalle_grid(); // get detail page object
			$GLOBALS["estado_resultado_detalle_grid"]->ValidateGridForm();
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idempresa
		$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, strval($this->idempresa->CurrentValue) == "");

		// idperiodo_contable
		$this->idperiodo_contable->SetDbValueDef($rsnew, $this->idperiodo_contable->CurrentValue, 0, strval($this->idperiodo_contable->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idestado_resultado->setDbValue($conn->Insert_ID());
				$rsnew['idestado_resultado'] = $this->idestado_resultado->DbValue;
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("estado_resultado_detalle", $DetailTblVar) && $GLOBALS["estado_resultado_detalle"]->DetailAdd) {
				$GLOBALS["estado_resultado_detalle"]->idestado_resultado->setSessionValue($this->idestado_resultado->CurrentValue); // Set master key
				if (!isset($GLOBALS["estado_resultado_detalle_grid"])) $GLOBALS["estado_resultado_detalle_grid"] = new cestado_resultado_detalle_grid(); // Get detail page object
				$AddRow = $GLOBALS["estado_resultado_detalle_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["estado_resultado_detalle"]->idestado_resultado->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
	}

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("estado_resultado_detalle", $DetailTblVar)) {
				if (!isset($GLOBALS["estado_resultado_detalle_grid"]))
					$GLOBALS["estado_resultado_detalle_grid"] = new cestado_resultado_detalle_grid;
				if ($GLOBALS["estado_resultado_detalle_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["estado_resultado_detalle_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["estado_resultado_detalle_grid"]->CurrentMode = "add";
					$GLOBALS["estado_resultado_detalle_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["estado_resultado_detalle_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["estado_resultado_detalle_grid"]->setStartRecordNumber(1);
					$GLOBALS["estado_resultado_detalle_grid"]->idestado_resultado->FldIsDetailKey = TRUE;
					$GLOBALS["estado_resultado_detalle_grid"]->idestado_resultado->CurrentValue = $this->idestado_resultado->CurrentValue;
					$GLOBALS["estado_resultado_detalle_grid"]->idestado_resultado->setSessionValue($GLOBALS["estado_resultado_detalle_grid"]->idestado_resultado->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_resultadolist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($estado_resultado_add)) $estado_resultado_add = new cestado_resultado_add();

// Page init
$estado_resultado_add->Page_Init();

// Page main
$estado_resultado_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = festado_resultadoadd = new ew_Form("festado_resultadoadd", "add");

// Validate form
festado_resultadoadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->idempresa->FldCaption(), $estado_resultado->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->idperiodo_contable->FldCaption(), $estado_resultado->idperiodo_contable->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
festado_resultadoadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultadoadd.ValidateRequired = true;
<?php } else { ?>
festado_resultadoadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultadoadd.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_ticker","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultadoadd.Lists["x_idperiodo_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $estado_resultado_add->ShowPageHeader(); ?>
<?php
$estado_resultado_add->ShowMessage();
?>
<form name="festado_resultadoadd" id="festado_resultadoadd" class="<?php echo $estado_resultado_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_resultado_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_resultado_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_resultado">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($estado_resultado->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label id="elh_estado_resultado_idempresa" for="x_idempresa" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->idempresa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->idempresa->CellAttributes() ?>>
<span id="el_estado_resultado_idempresa">
<select data-table="estado_resultado" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado->idempresa->DisplayValueSeparator) ? json_encode($estado_resultado->idempresa->DisplayValueSeparator) : $estado_resultado->idempresa->DisplayValueSeparator) ?>" id="x_idempresa" name="x_idempresa"<?php echo $estado_resultado->idempresa->EditAttributes() ?>>
<?php
if (is_array($estado_resultado->idempresa->EditValue)) {
	$arwrk = $estado_resultado->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado->idempresa->CurrentValue) ?>" selected><?php echo $estado_resultado->idempresa->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado->Lookup_Selecting($estado_resultado->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="<?php echo $estado_resultado->idempresa->LookupFilterQuery() ?>">
</span>
<?php echo $estado_resultado->idempresa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<div id="r_idperiodo_contable" class="form-group">
		<label id="elh_estado_resultado_idperiodo_contable" for="x_idperiodo_contable" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->idperiodo_contable->CellAttributes() ?>>
<span id="el_estado_resultado_idperiodo_contable">
<select data-table="estado_resultado" data-field="x_idperiodo_contable" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado->idperiodo_contable->DisplayValueSeparator) ? json_encode($estado_resultado->idperiodo_contable->DisplayValueSeparator) : $estado_resultado->idperiodo_contable->DisplayValueSeparator) ?>" id="x_idperiodo_contable" name="x_idperiodo_contable"<?php echo $estado_resultado->idperiodo_contable->EditAttributes() ?>>
<?php
if (is_array($estado_resultado->idperiodo_contable->EditValue)) {
	$arwrk = $estado_resultado->idperiodo_contable->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado->idperiodo_contable->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado->idperiodo_contable->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado->idperiodo_contable->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado->idperiodo_contable->CurrentValue) ?>" selected><?php echo $estado_resultado->idperiodo_contable->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado->idperiodo_contable->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado->idperiodo_contable->LookupFilters += array("f0" => "`idperiodo_contable` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado->Lookup_Selecting($estado_resultado->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado->idperiodo_contable->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idperiodo_contable" id="s_x_idperiodo_contable" value="<?php echo $estado_resultado->idperiodo_contable->LookupFilterQuery() ?>">
</span>
<?php echo $estado_resultado->idperiodo_contable->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("estado_resultado_detalle", explode(",", $estado_resultado->getCurrentDetailTable())) && $estado_resultado_detalle->DetailAdd) {
?>
<?php if ($estado_resultado->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("estado_resultado_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "estado_resultado_detallegrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $estado_resultado_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
festado_resultadoadd.Init();
</script>
<?php
$estado_resultado_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_resultado_add->Page_Terminate();
?>
