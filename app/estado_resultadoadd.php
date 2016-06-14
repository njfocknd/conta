<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "estado_resultadoinfo.php" ?>
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
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "estado_resultadolist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "estado_resultadoview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
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
		$this->venta_netas->CurrentValue = 0.00;
		$this->costo_ventas->CurrentValue = 0.00;
		$this->depreciacion->CurrentValue = 0.00;
		$this->interes_pagado->CurrentValue = 0.00;
		$this->utilidad_gravable->CurrentValue = 0.00;
		$this->impuestos->CurrentValue = 0.00;
		$this->utilidad_neta->CurrentValue = 0.00;
		$this->dividendos->CurrentValue = 0.00;
		$this->utilidades_retenidas->CurrentValue = 0.00;
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
		if (!$this->venta_netas->FldIsDetailKey) {
			$this->venta_netas->setFormValue($objForm->GetValue("x_venta_netas"));
		}
		if (!$this->costo_ventas->FldIsDetailKey) {
			$this->costo_ventas->setFormValue($objForm->GetValue("x_costo_ventas"));
		}
		if (!$this->depreciacion->FldIsDetailKey) {
			$this->depreciacion->setFormValue($objForm->GetValue("x_depreciacion"));
		}
		if (!$this->interes_pagado->FldIsDetailKey) {
			$this->interes_pagado->setFormValue($objForm->GetValue("x_interes_pagado"));
		}
		if (!$this->utilidad_gravable->FldIsDetailKey) {
			$this->utilidad_gravable->setFormValue($objForm->GetValue("x_utilidad_gravable"));
		}
		if (!$this->impuestos->FldIsDetailKey) {
			$this->impuestos->setFormValue($objForm->GetValue("x_impuestos"));
		}
		if (!$this->utilidad_neta->FldIsDetailKey) {
			$this->utilidad_neta->setFormValue($objForm->GetValue("x_utilidad_neta"));
		}
		if (!$this->dividendos->FldIsDetailKey) {
			$this->dividendos->setFormValue($objForm->GetValue("x_dividendos"));
		}
		if (!$this->utilidades_retenidas->FldIsDetailKey) {
			$this->utilidades_retenidas->setFormValue($objForm->GetValue("x_utilidades_retenidas"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
		$this->idperiodo_contable->CurrentValue = $this->idperiodo_contable->FormValue;
		$this->venta_netas->CurrentValue = $this->venta_netas->FormValue;
		$this->costo_ventas->CurrentValue = $this->costo_ventas->FormValue;
		$this->depreciacion->CurrentValue = $this->depreciacion->FormValue;
		$this->interes_pagado->CurrentValue = $this->interes_pagado->FormValue;
		$this->utilidad_gravable->CurrentValue = $this->utilidad_gravable->FormValue;
		$this->impuestos->CurrentValue = $this->impuestos->FormValue;
		$this->utilidad_neta->CurrentValue = $this->utilidad_neta->FormValue;
		$this->dividendos->CurrentValue = $this->dividendos->FormValue;
		$this->utilidades_retenidas->CurrentValue = $this->utilidades_retenidas->FormValue;
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
		$this->utilidad_gravable->setDbValue($rs->fields('utilidad_gravable'));
		$this->impuestos->setDbValue($rs->fields('impuestos'));
		$this->utilidad_neta->setDbValue($rs->fields('utilidad_neta'));
		$this->dividendos->setDbValue($rs->fields('dividendos'));
		$this->utilidades_retenidas->setDbValue($rs->fields('utilidades_retenidas'));
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
		$this->utilidad_gravable->DbValue = $row['utilidad_gravable'];
		$this->impuestos->DbValue = $row['impuestos'];
		$this->utilidad_neta->DbValue = $row['utilidad_neta'];
		$this->dividendos->DbValue = $row['dividendos'];
		$this->utilidades_retenidas->DbValue = $row['utilidades_retenidas'];
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
		// Convert decimal values if posted back

		if ($this->venta_netas->FormValue == $this->venta_netas->CurrentValue && is_numeric(ew_StrToFloat($this->venta_netas->CurrentValue)))
			$this->venta_netas->CurrentValue = ew_StrToFloat($this->venta_netas->CurrentValue);

		// Convert decimal values if posted back
		if ($this->costo_ventas->FormValue == $this->costo_ventas->CurrentValue && is_numeric(ew_StrToFloat($this->costo_ventas->CurrentValue)))
			$this->costo_ventas->CurrentValue = ew_StrToFloat($this->costo_ventas->CurrentValue);

		// Convert decimal values if posted back
		if ($this->depreciacion->FormValue == $this->depreciacion->CurrentValue && is_numeric(ew_StrToFloat($this->depreciacion->CurrentValue)))
			$this->depreciacion->CurrentValue = ew_StrToFloat($this->depreciacion->CurrentValue);

		// Convert decimal values if posted back
		if ($this->interes_pagado->FormValue == $this->interes_pagado->CurrentValue && is_numeric(ew_StrToFloat($this->interes_pagado->CurrentValue)))
			$this->interes_pagado->CurrentValue = ew_StrToFloat($this->interes_pagado->CurrentValue);

		// Convert decimal values if posted back
		if ($this->utilidad_gravable->FormValue == $this->utilidad_gravable->CurrentValue && is_numeric(ew_StrToFloat($this->utilidad_gravable->CurrentValue)))
			$this->utilidad_gravable->CurrentValue = ew_StrToFloat($this->utilidad_gravable->CurrentValue);

		// Convert decimal values if posted back
		if ($this->impuestos->FormValue == $this->impuestos->CurrentValue && is_numeric(ew_StrToFloat($this->impuestos->CurrentValue)))
			$this->impuestos->CurrentValue = ew_StrToFloat($this->impuestos->CurrentValue);

		// Convert decimal values if posted back
		if ($this->utilidad_neta->FormValue == $this->utilidad_neta->CurrentValue && is_numeric(ew_StrToFloat($this->utilidad_neta->CurrentValue)))
			$this->utilidad_neta->CurrentValue = ew_StrToFloat($this->utilidad_neta->CurrentValue);

		// Convert decimal values if posted back
		if ($this->dividendos->FormValue == $this->dividendos->CurrentValue && is_numeric(ew_StrToFloat($this->dividendos->CurrentValue)))
			$this->dividendos->CurrentValue = ew_StrToFloat($this->dividendos->CurrentValue);

		// Convert decimal values if posted back
		if ($this->utilidades_retenidas->FormValue == $this->utilidades_retenidas->CurrentValue && is_numeric(ew_StrToFloat($this->utilidades_retenidas->CurrentValue)))
			$this->utilidades_retenidas->CurrentValue = ew_StrToFloat($this->utilidades_retenidas->CurrentValue);

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
		// utilidad_gravable
		// impuestos
		// utilidad_neta
		// dividendos
		// utilidades_retenidas

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idestado_resultado
		$this->idestado_resultado->ViewValue = $this->idestado_resultado->CurrentValue;
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idempresa
		$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
		$this->idempresa->ViewCustomAttributes = "";

		// idperiodo_contable
		$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->CurrentValue;
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

		// utilidad_gravable
		$this->utilidad_gravable->ViewValue = $this->utilidad_gravable->CurrentValue;
		$this->utilidad_gravable->ViewCustomAttributes = "";

		// impuestos
		$this->impuestos->ViewValue = $this->impuestos->CurrentValue;
		$this->impuestos->ViewCustomAttributes = "";

		// utilidad_neta
		$this->utilidad_neta->ViewValue = $this->utilidad_neta->CurrentValue;
		$this->utilidad_neta->ViewCustomAttributes = "";

		// dividendos
		$this->dividendos->ViewValue = $this->dividendos->CurrentValue;
		$this->dividendos->ViewCustomAttributes = "";

		// utilidades_retenidas
		$this->utilidades_retenidas->ViewValue = $this->utilidades_retenidas->CurrentValue;
		$this->utilidades_retenidas->ViewCustomAttributes = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";
			$this->idperiodo_contable->TooltipValue = "";

			// venta_netas
			$this->venta_netas->LinkCustomAttributes = "";
			$this->venta_netas->HrefValue = "";
			$this->venta_netas->TooltipValue = "";

			// costo_ventas
			$this->costo_ventas->LinkCustomAttributes = "";
			$this->costo_ventas->HrefValue = "";
			$this->costo_ventas->TooltipValue = "";

			// depreciacion
			$this->depreciacion->LinkCustomAttributes = "";
			$this->depreciacion->HrefValue = "";
			$this->depreciacion->TooltipValue = "";

			// interes_pagado
			$this->interes_pagado->LinkCustomAttributes = "";
			$this->interes_pagado->HrefValue = "";
			$this->interes_pagado->TooltipValue = "";

			// utilidad_gravable
			$this->utilidad_gravable->LinkCustomAttributes = "";
			$this->utilidad_gravable->HrefValue = "";
			$this->utilidad_gravable->TooltipValue = "";

			// impuestos
			$this->impuestos->LinkCustomAttributes = "";
			$this->impuestos->HrefValue = "";
			$this->impuestos->TooltipValue = "";

			// utilidad_neta
			$this->utilidad_neta->LinkCustomAttributes = "";
			$this->utilidad_neta->HrefValue = "";
			$this->utilidad_neta->TooltipValue = "";

			// dividendos
			$this->dividendos->LinkCustomAttributes = "";
			$this->dividendos->HrefValue = "";
			$this->dividendos->TooltipValue = "";

			// utilidades_retenidas
			$this->utilidades_retenidas->LinkCustomAttributes = "";
			$this->utilidades_retenidas->HrefValue = "";
			$this->utilidades_retenidas->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			$this->idempresa->EditValue = ew_HtmlEncode($this->idempresa->CurrentValue);
			$this->idempresa->PlaceHolder = ew_RemoveHtml($this->idempresa->FldCaption());

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			$this->idperiodo_contable->EditValue = ew_HtmlEncode($this->idperiodo_contable->CurrentValue);
			$this->idperiodo_contable->PlaceHolder = ew_RemoveHtml($this->idperiodo_contable->FldCaption());

			// venta_netas
			$this->venta_netas->EditAttrs["class"] = "form-control";
			$this->venta_netas->EditCustomAttributes = "";
			$this->venta_netas->EditValue = ew_HtmlEncode($this->venta_netas->CurrentValue);
			$this->venta_netas->PlaceHolder = ew_RemoveHtml($this->venta_netas->FldCaption());
			if (strval($this->venta_netas->EditValue) <> "" && is_numeric($this->venta_netas->EditValue)) $this->venta_netas->EditValue = ew_FormatNumber($this->venta_netas->EditValue, -2, -1, -2, 0);

			// costo_ventas
			$this->costo_ventas->EditAttrs["class"] = "form-control";
			$this->costo_ventas->EditCustomAttributes = "";
			$this->costo_ventas->EditValue = ew_HtmlEncode($this->costo_ventas->CurrentValue);
			$this->costo_ventas->PlaceHolder = ew_RemoveHtml($this->costo_ventas->FldCaption());
			if (strval($this->costo_ventas->EditValue) <> "" && is_numeric($this->costo_ventas->EditValue)) $this->costo_ventas->EditValue = ew_FormatNumber($this->costo_ventas->EditValue, -2, -1, -2, 0);

			// depreciacion
			$this->depreciacion->EditAttrs["class"] = "form-control";
			$this->depreciacion->EditCustomAttributes = "";
			$this->depreciacion->EditValue = ew_HtmlEncode($this->depreciacion->CurrentValue);
			$this->depreciacion->PlaceHolder = ew_RemoveHtml($this->depreciacion->FldCaption());
			if (strval($this->depreciacion->EditValue) <> "" && is_numeric($this->depreciacion->EditValue)) $this->depreciacion->EditValue = ew_FormatNumber($this->depreciacion->EditValue, -2, -1, -2, 0);

			// interes_pagado
			$this->interes_pagado->EditAttrs["class"] = "form-control";
			$this->interes_pagado->EditCustomAttributes = "";
			$this->interes_pagado->EditValue = ew_HtmlEncode($this->interes_pagado->CurrentValue);
			$this->interes_pagado->PlaceHolder = ew_RemoveHtml($this->interes_pagado->FldCaption());
			if (strval($this->interes_pagado->EditValue) <> "" && is_numeric($this->interes_pagado->EditValue)) $this->interes_pagado->EditValue = ew_FormatNumber($this->interes_pagado->EditValue, -2, -1, -2, 0);

			// utilidad_gravable
			$this->utilidad_gravable->EditAttrs["class"] = "form-control";
			$this->utilidad_gravable->EditCustomAttributes = "";
			$this->utilidad_gravable->EditValue = ew_HtmlEncode($this->utilidad_gravable->CurrentValue);
			$this->utilidad_gravable->PlaceHolder = ew_RemoveHtml($this->utilidad_gravable->FldCaption());
			if (strval($this->utilidad_gravable->EditValue) <> "" && is_numeric($this->utilidad_gravable->EditValue)) $this->utilidad_gravable->EditValue = ew_FormatNumber($this->utilidad_gravable->EditValue, -2, -1, -2, 0);

			// impuestos
			$this->impuestos->EditAttrs["class"] = "form-control";
			$this->impuestos->EditCustomAttributes = "";
			$this->impuestos->EditValue = ew_HtmlEncode($this->impuestos->CurrentValue);
			$this->impuestos->PlaceHolder = ew_RemoveHtml($this->impuestos->FldCaption());
			if (strval($this->impuestos->EditValue) <> "" && is_numeric($this->impuestos->EditValue)) $this->impuestos->EditValue = ew_FormatNumber($this->impuestos->EditValue, -2, -1, -2, 0);

			// utilidad_neta
			$this->utilidad_neta->EditAttrs["class"] = "form-control";
			$this->utilidad_neta->EditCustomAttributes = "";
			$this->utilidad_neta->EditValue = ew_HtmlEncode($this->utilidad_neta->CurrentValue);
			$this->utilidad_neta->PlaceHolder = ew_RemoveHtml($this->utilidad_neta->FldCaption());
			if (strval($this->utilidad_neta->EditValue) <> "" && is_numeric($this->utilidad_neta->EditValue)) $this->utilidad_neta->EditValue = ew_FormatNumber($this->utilidad_neta->EditValue, -2, -1, -2, 0);

			// dividendos
			$this->dividendos->EditAttrs["class"] = "form-control";
			$this->dividendos->EditCustomAttributes = "";
			$this->dividendos->EditValue = ew_HtmlEncode($this->dividendos->CurrentValue);
			$this->dividendos->PlaceHolder = ew_RemoveHtml($this->dividendos->FldCaption());
			if (strval($this->dividendos->EditValue) <> "" && is_numeric($this->dividendos->EditValue)) $this->dividendos->EditValue = ew_FormatNumber($this->dividendos->EditValue, -2, -1, -2, 0);

			// utilidades_retenidas
			$this->utilidades_retenidas->EditAttrs["class"] = "form-control";
			$this->utilidades_retenidas->EditCustomAttributes = "";
			$this->utilidades_retenidas->EditValue = ew_HtmlEncode($this->utilidades_retenidas->CurrentValue);
			$this->utilidades_retenidas->PlaceHolder = ew_RemoveHtml($this->utilidades_retenidas->FldCaption());
			if (strval($this->utilidades_retenidas->EditValue) <> "" && is_numeric($this->utilidades_retenidas->EditValue)) $this->utilidades_retenidas->EditValue = ew_FormatNumber($this->utilidades_retenidas->EditValue, -2, -1, -2, 0);

			// Add refer script
			// idempresa

			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";

			// idperiodo_contable
			$this->idperiodo_contable->LinkCustomAttributes = "";
			$this->idperiodo_contable->HrefValue = "";

			// venta_netas
			$this->venta_netas->LinkCustomAttributes = "";
			$this->venta_netas->HrefValue = "";

			// costo_ventas
			$this->costo_ventas->LinkCustomAttributes = "";
			$this->costo_ventas->HrefValue = "";

			// depreciacion
			$this->depreciacion->LinkCustomAttributes = "";
			$this->depreciacion->HrefValue = "";

			// interes_pagado
			$this->interes_pagado->LinkCustomAttributes = "";
			$this->interes_pagado->HrefValue = "";

			// utilidad_gravable
			$this->utilidad_gravable->LinkCustomAttributes = "";
			$this->utilidad_gravable->HrefValue = "";

			// impuestos
			$this->impuestos->LinkCustomAttributes = "";
			$this->impuestos->HrefValue = "";

			// utilidad_neta
			$this->utilidad_neta->LinkCustomAttributes = "";
			$this->utilidad_neta->HrefValue = "";

			// dividendos
			$this->dividendos->LinkCustomAttributes = "";
			$this->dividendos->HrefValue = "";

			// utilidades_retenidas
			$this->utilidades_retenidas->LinkCustomAttributes = "";
			$this->utilidades_retenidas->HrefValue = "";
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
		if (!ew_CheckInteger($this->idempresa->FormValue)) {
			ew_AddMessage($gsFormError, $this->idempresa->FldErrMsg());
		}
		if (!$this->idperiodo_contable->FldIsDetailKey && !is_null($this->idperiodo_contable->FormValue) && $this->idperiodo_contable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idperiodo_contable->FldCaption(), $this->idperiodo_contable->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idperiodo_contable->FormValue)) {
			ew_AddMessage($gsFormError, $this->idperiodo_contable->FldErrMsg());
		}
		if (!$this->venta_netas->FldIsDetailKey && !is_null($this->venta_netas->FormValue) && $this->venta_netas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->venta_netas->FldCaption(), $this->venta_netas->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->venta_netas->FormValue)) {
			ew_AddMessage($gsFormError, $this->venta_netas->FldErrMsg());
		}
		if (!$this->costo_ventas->FldIsDetailKey && !is_null($this->costo_ventas->FormValue) && $this->costo_ventas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->costo_ventas->FldCaption(), $this->costo_ventas->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->costo_ventas->FormValue)) {
			ew_AddMessage($gsFormError, $this->costo_ventas->FldErrMsg());
		}
		if (!$this->depreciacion->FldIsDetailKey && !is_null($this->depreciacion->FormValue) && $this->depreciacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->depreciacion->FldCaption(), $this->depreciacion->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->depreciacion->FormValue)) {
			ew_AddMessage($gsFormError, $this->depreciacion->FldErrMsg());
		}
		if (!$this->interes_pagado->FldIsDetailKey && !is_null($this->interes_pagado->FormValue) && $this->interes_pagado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->interes_pagado->FldCaption(), $this->interes_pagado->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->interes_pagado->FormValue)) {
			ew_AddMessage($gsFormError, $this->interes_pagado->FldErrMsg());
		}
		if (!$this->utilidad_gravable->FldIsDetailKey && !is_null($this->utilidad_gravable->FormValue) && $this->utilidad_gravable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->utilidad_gravable->FldCaption(), $this->utilidad_gravable->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->utilidad_gravable->FormValue)) {
			ew_AddMessage($gsFormError, $this->utilidad_gravable->FldErrMsg());
		}
		if (!$this->impuestos->FldIsDetailKey && !is_null($this->impuestos->FormValue) && $this->impuestos->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->impuestos->FldCaption(), $this->impuestos->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->impuestos->FormValue)) {
			ew_AddMessage($gsFormError, $this->impuestos->FldErrMsg());
		}
		if (!$this->utilidad_neta->FldIsDetailKey && !is_null($this->utilidad_neta->FormValue) && $this->utilidad_neta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->utilidad_neta->FldCaption(), $this->utilidad_neta->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->utilidad_neta->FormValue)) {
			ew_AddMessage($gsFormError, $this->utilidad_neta->FldErrMsg());
		}
		if (!$this->dividendos->FldIsDetailKey && !is_null($this->dividendos->FormValue) && $this->dividendos->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->dividendos->FldCaption(), $this->dividendos->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->dividendos->FormValue)) {
			ew_AddMessage($gsFormError, $this->dividendos->FldErrMsg());
		}
		if (!$this->utilidades_retenidas->FldIsDetailKey && !is_null($this->utilidades_retenidas->FormValue) && $this->utilidades_retenidas->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->utilidades_retenidas->FldCaption(), $this->utilidades_retenidas->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->utilidades_retenidas->FormValue)) {
			ew_AddMessage($gsFormError, $this->utilidades_retenidas->FldErrMsg());
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

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idempresa
		$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, strval($this->idempresa->CurrentValue) == "");

		// idperiodo_contable
		$this->idperiodo_contable->SetDbValueDef($rsnew, $this->idperiodo_contable->CurrentValue, 0, strval($this->idperiodo_contable->CurrentValue) == "");

		// venta_netas
		$this->venta_netas->SetDbValueDef($rsnew, $this->venta_netas->CurrentValue, 0, strval($this->venta_netas->CurrentValue) == "");

		// costo_ventas
		$this->costo_ventas->SetDbValueDef($rsnew, $this->costo_ventas->CurrentValue, 0, strval($this->costo_ventas->CurrentValue) == "");

		// depreciacion
		$this->depreciacion->SetDbValueDef($rsnew, $this->depreciacion->CurrentValue, 0, strval($this->depreciacion->CurrentValue) == "");

		// interes_pagado
		$this->interes_pagado->SetDbValueDef($rsnew, $this->interes_pagado->CurrentValue, 0, strval($this->interes_pagado->CurrentValue) == "");

		// utilidad_gravable
		$this->utilidad_gravable->SetDbValueDef($rsnew, $this->utilidad_gravable->CurrentValue, 0, strval($this->utilidad_gravable->CurrentValue) == "");

		// impuestos
		$this->impuestos->SetDbValueDef($rsnew, $this->impuestos->CurrentValue, 0, strval($this->impuestos->CurrentValue) == "");

		// utilidad_neta
		$this->utilidad_neta->SetDbValueDef($rsnew, $this->utilidad_neta->CurrentValue, 0, strval($this->utilidad_neta->CurrentValue) == "");

		// dividendos
		$this->dividendos->SetDbValueDef($rsnew, $this->dividendos->CurrentValue, 0, strval($this->dividendos->CurrentValue) == "");

		// utilidades_retenidas
		$this->utilidades_retenidas->SetDbValueDef($rsnew, $this->utilidades_retenidas->CurrentValue, 0, strval($this->utilidades_retenidas->CurrentValue) == "");

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
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->idempresa->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->idperiodo_contable->FldCaption(), $estado_resultado->idperiodo_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idperiodo_contable");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->idperiodo_contable->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_venta_netas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->venta_netas->FldCaption(), $estado_resultado->venta_netas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_venta_netas");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->venta_netas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_costo_ventas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->costo_ventas->FldCaption(), $estado_resultado->costo_ventas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_costo_ventas");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->costo_ventas->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_depreciacion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->depreciacion->FldCaption(), $estado_resultado->depreciacion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_depreciacion");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->depreciacion->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_interes_pagado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->interes_pagado->FldCaption(), $estado_resultado->interes_pagado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_interes_pagado");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->interes_pagado->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_utilidad_gravable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->utilidad_gravable->FldCaption(), $estado_resultado->utilidad_gravable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_utilidad_gravable");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->utilidad_gravable->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_impuestos");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->impuestos->FldCaption(), $estado_resultado->impuestos->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_impuestos");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->impuestos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_utilidad_neta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->utilidad_neta->FldCaption(), $estado_resultado->utilidad_neta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_utilidad_neta");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->utilidad_neta->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_dividendos");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->dividendos->FldCaption(), $estado_resultado->dividendos->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_dividendos");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->dividendos->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_utilidades_retenidas");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado->utilidades_retenidas->FldCaption(), $estado_resultado->utilidades_retenidas->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_utilidades_retenidas");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado->utilidades_retenidas->FldErrMsg()) ?>");

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
<input type="text" data-table="estado_resultado" data-field="x_idempresa" name="x_idempresa" id="x_idempresa" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->idempresa->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->idempresa->EditValue ?>"<?php echo $estado_resultado->idempresa->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->idempresa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<div id="r_idperiodo_contable" class="form-group">
		<label id="elh_estado_resultado_idperiodo_contable" for="x_idperiodo_contable" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->idperiodo_contable->CellAttributes() ?>>
<span id="el_estado_resultado_idperiodo_contable">
<input type="text" data-table="estado_resultado" data-field="x_idperiodo_contable" name="x_idperiodo_contable" id="x_idperiodo_contable" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->idperiodo_contable->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->idperiodo_contable->EditValue ?>"<?php echo $estado_resultado->idperiodo_contable->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->idperiodo_contable->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->venta_netas->Visible) { // venta_netas ?>
	<div id="r_venta_netas" class="form-group">
		<label id="elh_estado_resultado_venta_netas" for="x_venta_netas" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->venta_netas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->venta_netas->CellAttributes() ?>>
<span id="el_estado_resultado_venta_netas">
<input type="text" data-table="estado_resultado" data-field="x_venta_netas" name="x_venta_netas" id="x_venta_netas" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->venta_netas->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->venta_netas->EditValue ?>"<?php echo $estado_resultado->venta_netas->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->venta_netas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->costo_ventas->Visible) { // costo_ventas ?>
	<div id="r_costo_ventas" class="form-group">
		<label id="elh_estado_resultado_costo_ventas" for="x_costo_ventas" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->costo_ventas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->costo_ventas->CellAttributes() ?>>
<span id="el_estado_resultado_costo_ventas">
<input type="text" data-table="estado_resultado" data-field="x_costo_ventas" name="x_costo_ventas" id="x_costo_ventas" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->costo_ventas->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->costo_ventas->EditValue ?>"<?php echo $estado_resultado->costo_ventas->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->costo_ventas->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->depreciacion->Visible) { // depreciacion ?>
	<div id="r_depreciacion" class="form-group">
		<label id="elh_estado_resultado_depreciacion" for="x_depreciacion" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->depreciacion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->depreciacion->CellAttributes() ?>>
<span id="el_estado_resultado_depreciacion">
<input type="text" data-table="estado_resultado" data-field="x_depreciacion" name="x_depreciacion" id="x_depreciacion" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->depreciacion->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->depreciacion->EditValue ?>"<?php echo $estado_resultado->depreciacion->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->depreciacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->interes_pagado->Visible) { // interes_pagado ?>
	<div id="r_interes_pagado" class="form-group">
		<label id="elh_estado_resultado_interes_pagado" for="x_interes_pagado" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->interes_pagado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->interes_pagado->CellAttributes() ?>>
<span id="el_estado_resultado_interes_pagado">
<input type="text" data-table="estado_resultado" data-field="x_interes_pagado" name="x_interes_pagado" id="x_interes_pagado" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->interes_pagado->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->interes_pagado->EditValue ?>"<?php echo $estado_resultado->interes_pagado->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->interes_pagado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->utilidad_gravable->Visible) { // utilidad_gravable ?>
	<div id="r_utilidad_gravable" class="form-group">
		<label id="elh_estado_resultado_utilidad_gravable" for="x_utilidad_gravable" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->utilidad_gravable->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->utilidad_gravable->CellAttributes() ?>>
<span id="el_estado_resultado_utilidad_gravable">
<input type="text" data-table="estado_resultado" data-field="x_utilidad_gravable" name="x_utilidad_gravable" id="x_utilidad_gravable" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->utilidad_gravable->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->utilidad_gravable->EditValue ?>"<?php echo $estado_resultado->utilidad_gravable->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->utilidad_gravable->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->impuestos->Visible) { // impuestos ?>
	<div id="r_impuestos" class="form-group">
		<label id="elh_estado_resultado_impuestos" for="x_impuestos" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->impuestos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->impuestos->CellAttributes() ?>>
<span id="el_estado_resultado_impuestos">
<input type="text" data-table="estado_resultado" data-field="x_impuestos" name="x_impuestos" id="x_impuestos" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->impuestos->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->impuestos->EditValue ?>"<?php echo $estado_resultado->impuestos->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->impuestos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->utilidad_neta->Visible) { // utilidad_neta ?>
	<div id="r_utilidad_neta" class="form-group">
		<label id="elh_estado_resultado_utilidad_neta" for="x_utilidad_neta" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->utilidad_neta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->utilidad_neta->CellAttributes() ?>>
<span id="el_estado_resultado_utilidad_neta">
<input type="text" data-table="estado_resultado" data-field="x_utilidad_neta" name="x_utilidad_neta" id="x_utilidad_neta" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->utilidad_neta->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->utilidad_neta->EditValue ?>"<?php echo $estado_resultado->utilidad_neta->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->utilidad_neta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->dividendos->Visible) { // dividendos ?>
	<div id="r_dividendos" class="form-group">
		<label id="elh_estado_resultado_dividendos" for="x_dividendos" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->dividendos->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->dividendos->CellAttributes() ?>>
<span id="el_estado_resultado_dividendos">
<input type="text" data-table="estado_resultado" data-field="x_dividendos" name="x_dividendos" id="x_dividendos" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->dividendos->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->dividendos->EditValue ?>"<?php echo $estado_resultado->dividendos->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->dividendos->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado->utilidades_retenidas->Visible) { // utilidades_retenidas ?>
	<div id="r_utilidades_retenidas" class="form-group">
		<label id="elh_estado_resultado_utilidades_retenidas" for="x_utilidades_retenidas" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado->utilidades_retenidas->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado->utilidades_retenidas->CellAttributes() ?>>
<span id="el_estado_resultado_utilidades_retenidas">
<input type="text" data-table="estado_resultado" data-field="x_utilidades_retenidas" name="x_utilidades_retenidas" id="x_utilidades_retenidas" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado->utilidades_retenidas->getPlaceHolder()) ?>" value="<?php echo $estado_resultado->utilidades_retenidas->EditValue ?>"<?php echo $estado_resultado->utilidades_retenidas->EditAttributes() ?>>
</span>
<?php echo $estado_resultado->utilidades_retenidas->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
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
