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

$estado_resultado_view = NULL; // Initialize page object first

class cestado_resultado_view extends cestado_resultado {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'estado_resultado';

	// Page object name
	var $PageObjName = 'estado_resultado_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["idestado_resultado"] <> "") {
			$this->RecKey["idestado_resultado"] = $_GET["idestado_resultado"];
			$KeyUrl .= "&amp;idestado_resultado=" . urlencode($this->RecKey["idestado_resultado"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_resultado', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->idestado_resultado->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idestado_resultado"] <> "") {
				$this->idestado_resultado->setQueryStringValue($_GET["idestado_resultado"]);
				$this->RecKey["idestado_resultado"] = $this->idestado_resultado->QueryStringValue;
			} elseif (@$_POST["idestado_resultado"] <> "") {
				$this->idestado_resultado->setFormValue($_POST["idestado_resultado"]);
				$this->RecKey["idestado_resultado"] = $this->idestado_resultado->FormValue;
			} else {
				$sReturnUrl = "estado_resultadolist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "estado_resultadolist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "estado_resultadolist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageAddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");

		// Edit
		$item = &$option->Add("edit");
		$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageEditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "");

		// Copy
		$item = &$option->Add("copy");
		$item->Body = "<a class=\"ewAction ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("ViewPageCopyLink") . "</a>";
		$item->Visible = ($this->CopyUrl <> "");

		// Delete
		$item = &$option->Add("delete");
		$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "");

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		$this->utilidad_gravable->DbValue = $row['utilidad_gravable'];
		$this->impuestos->DbValue = $row['impuestos'];
		$this->utilidad_neta->DbValue = $row['utilidad_neta'];
		$this->dividendos->DbValue = $row['dividendos'];
		$this->utilidades_retenidas->DbValue = $row['utilidades_retenidas'];
		$this->estado->DbValue = $row['estado'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
		// estado

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

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idestado_resultado
			$this->idestado_resultado->LinkCustomAttributes = "";
			$this->idestado_resultado->HrefValue = "";
			$this->idestado_resultado->TooltipValue = "";

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

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_resultadolist.php"), "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

	    //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($estado_resultado_view)) $estado_resultado_view = new cestado_resultado_view();

// Page init
$estado_resultado_view->Page_Init();

// Page main
$estado_resultado_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = festado_resultadoview = new ew_Form("festado_resultadoview", "view");

// Form_CustomValidate event
festado_resultadoview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultadoview.ValidateRequired = true;
<?php } else { ?>
festado_resultadoview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultadoview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultadoview.Lists["x_estado"].Options = <?php echo json_encode($estado_resultado->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $estado_resultado_view->ExportOptions->Render("body") ?>
<?php
	foreach ($estado_resultado_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $estado_resultado_view->ShowPageHeader(); ?>
<?php
$estado_resultado_view->ShowMessage();
?>
<form name="festado_resultadoview" id="festado_resultadoview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_resultado_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_resultado_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_resultado">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($estado_resultado->idestado_resultado->Visible) { // idestado_resultado ?>
	<tr id="r_idestado_resultado">
		<td><span id="elh_estado_resultado_idestado_resultado"><?php echo $estado_resultado->idestado_resultado->FldCaption() ?></span></td>
		<td data-name="idestado_resultado"<?php echo $estado_resultado->idestado_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_idestado_resultado">
<span<?php echo $estado_resultado->idestado_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado->idestado_resultado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->idempresa->Visible) { // idempresa ?>
	<tr id="r_idempresa">
		<td><span id="elh_estado_resultado_idempresa"><?php echo $estado_resultado->idempresa->FldCaption() ?></span></td>
		<td data-name="idempresa"<?php echo $estado_resultado->idempresa->CellAttributes() ?>>
<span id="el_estado_resultado_idempresa">
<span<?php echo $estado_resultado->idempresa->ViewAttributes() ?>>
<?php echo $estado_resultado->idempresa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<tr id="r_idperiodo_contable">
		<td><span id="elh_estado_resultado_idperiodo_contable"><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?></span></td>
		<td data-name="idperiodo_contable"<?php echo $estado_resultado->idperiodo_contable->CellAttributes() ?>>
<span id="el_estado_resultado_idperiodo_contable">
<span<?php echo $estado_resultado->idperiodo_contable->ViewAttributes() ?>>
<?php echo $estado_resultado->idperiodo_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->venta_netas->Visible) { // venta_netas ?>
	<tr id="r_venta_netas">
		<td><span id="elh_estado_resultado_venta_netas"><?php echo $estado_resultado->venta_netas->FldCaption() ?></span></td>
		<td data-name="venta_netas"<?php echo $estado_resultado->venta_netas->CellAttributes() ?>>
<span id="el_estado_resultado_venta_netas">
<span<?php echo $estado_resultado->venta_netas->ViewAttributes() ?>>
<?php echo $estado_resultado->venta_netas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->costo_ventas->Visible) { // costo_ventas ?>
	<tr id="r_costo_ventas">
		<td><span id="elh_estado_resultado_costo_ventas"><?php echo $estado_resultado->costo_ventas->FldCaption() ?></span></td>
		<td data-name="costo_ventas"<?php echo $estado_resultado->costo_ventas->CellAttributes() ?>>
<span id="el_estado_resultado_costo_ventas">
<span<?php echo $estado_resultado->costo_ventas->ViewAttributes() ?>>
<?php echo $estado_resultado->costo_ventas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->depreciacion->Visible) { // depreciacion ?>
	<tr id="r_depreciacion">
		<td><span id="elh_estado_resultado_depreciacion"><?php echo $estado_resultado->depreciacion->FldCaption() ?></span></td>
		<td data-name="depreciacion"<?php echo $estado_resultado->depreciacion->CellAttributes() ?>>
<span id="el_estado_resultado_depreciacion">
<span<?php echo $estado_resultado->depreciacion->ViewAttributes() ?>>
<?php echo $estado_resultado->depreciacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->interes_pagado->Visible) { // interes_pagado ?>
	<tr id="r_interes_pagado">
		<td><span id="elh_estado_resultado_interes_pagado"><?php echo $estado_resultado->interes_pagado->FldCaption() ?></span></td>
		<td data-name="interes_pagado"<?php echo $estado_resultado->interes_pagado->CellAttributes() ?>>
<span id="el_estado_resultado_interes_pagado">
<span<?php echo $estado_resultado->interes_pagado->ViewAttributes() ?>>
<?php echo $estado_resultado->interes_pagado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->utilidad_gravable->Visible) { // utilidad_gravable ?>
	<tr id="r_utilidad_gravable">
		<td><span id="elh_estado_resultado_utilidad_gravable"><?php echo $estado_resultado->utilidad_gravable->FldCaption() ?></span></td>
		<td data-name="utilidad_gravable"<?php echo $estado_resultado->utilidad_gravable->CellAttributes() ?>>
<span id="el_estado_resultado_utilidad_gravable">
<span<?php echo $estado_resultado->utilidad_gravable->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidad_gravable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->impuestos->Visible) { // impuestos ?>
	<tr id="r_impuestos">
		<td><span id="elh_estado_resultado_impuestos"><?php echo $estado_resultado->impuestos->FldCaption() ?></span></td>
		<td data-name="impuestos"<?php echo $estado_resultado->impuestos->CellAttributes() ?>>
<span id="el_estado_resultado_impuestos">
<span<?php echo $estado_resultado->impuestos->ViewAttributes() ?>>
<?php echo $estado_resultado->impuestos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->utilidad_neta->Visible) { // utilidad_neta ?>
	<tr id="r_utilidad_neta">
		<td><span id="elh_estado_resultado_utilidad_neta"><?php echo $estado_resultado->utilidad_neta->FldCaption() ?></span></td>
		<td data-name="utilidad_neta"<?php echo $estado_resultado->utilidad_neta->CellAttributes() ?>>
<span id="el_estado_resultado_utilidad_neta">
<span<?php echo $estado_resultado->utilidad_neta->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidad_neta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->dividendos->Visible) { // dividendos ?>
	<tr id="r_dividendos">
		<td><span id="elh_estado_resultado_dividendos"><?php echo $estado_resultado->dividendos->FldCaption() ?></span></td>
		<td data-name="dividendos"<?php echo $estado_resultado->dividendos->CellAttributes() ?>>
<span id="el_estado_resultado_dividendos">
<span<?php echo $estado_resultado->dividendos->ViewAttributes() ?>>
<?php echo $estado_resultado->dividendos->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->utilidades_retenidas->Visible) { // utilidades_retenidas ?>
	<tr id="r_utilidades_retenidas">
		<td><span id="elh_estado_resultado_utilidades_retenidas"><?php echo $estado_resultado->utilidades_retenidas->FldCaption() ?></span></td>
		<td data-name="utilidades_retenidas"<?php echo $estado_resultado->utilidades_retenidas->CellAttributes() ?>>
<span id="el_estado_resultado_utilidades_retenidas">
<span<?php echo $estado_resultado->utilidades_retenidas->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidades_retenidas->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_estado_resultado_estado"><?php echo $estado_resultado->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $estado_resultado->estado->CellAttributes() ?>>
<span id="el_estado_resultado_estado">
<span<?php echo $estado_resultado->estado->ViewAttributes() ?>>
<?php echo $estado_resultado->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
festado_resultadoview.Init();
</script>
<?php
$estado_resultado_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_resultado_view->Page_Terminate();
?>
