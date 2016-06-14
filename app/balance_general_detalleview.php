<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "balance_general_detalleinfo.php" ?>
<?php include_once "balance_generalinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$balance_general_detalle_view = NULL; // Initialize page object first

class cbalance_general_detalle_view extends cbalance_general_detalle {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'balance_general_detalle';

	// Page object name
	var $PageObjName = 'balance_general_detalle_view';

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

		// Table object (balance_general_detalle)
		if (!isset($GLOBALS["balance_general_detalle"]) || get_class($GLOBALS["balance_general_detalle"]) == "cbalance_general_detalle") {
			$GLOBALS["balance_general_detalle"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["balance_general_detalle"];
		}
		$KeyUrl = "";
		if (@$_GET["idbalance_general_detalle"] <> "") {
			$this->RecKey["idbalance_general_detalle"] = $_GET["idbalance_general_detalle"];
			$KeyUrl .= "&amp;idbalance_general_detalle=" . urlencode($this->RecKey["idbalance_general_detalle"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (balance_general)
		if (!isset($GLOBALS['balance_general'])) $GLOBALS['balance_general'] = new cbalance_general();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'balance_general_detalle', TRUE);

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
		$this->idbalance_general_detalle->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $balance_general_detalle;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($balance_general_detalle);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idbalance_general_detalle"] <> "") {
				$this->idbalance_general_detalle->setQueryStringValue($_GET["idbalance_general_detalle"]);
				$this->RecKey["idbalance_general_detalle"] = $this->idbalance_general_detalle->QueryStringValue;
			} elseif (@$_POST["idbalance_general_detalle"] <> "") {
				$this->idbalance_general_detalle->setFormValue($_POST["idbalance_general_detalle"]);
				$this->RecKey["idbalance_general_detalle"] = $this->idbalance_general_detalle->FormValue;
			} else {
				$sReturnUrl = "balance_general_detallelist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "balance_general_detallelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "balance_general_detallelist.php"; // Not page request, return to list
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
		$this->idbalance_general_detalle->setDbValue($rs->fields('idbalance_general_detalle'));
		$this->idbalance_general->setDbValue($rs->fields('idbalance_general'));
		$this->idclase_cuenta->setDbValue($rs->fields('idclase_cuenta'));
		$this->idgrupo_cuenta->setDbValue($rs->fields('idgrupo_cuenta'));
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
		$this->idcuenta_mayor_principal->setDbValue($rs->fields('idcuenta_mayor_principal'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idbalance_general_detalle->DbValue = $row['idbalance_general_detalle'];
		$this->idbalance_general->DbValue = $row['idbalance_general'];
		$this->idclase_cuenta->DbValue = $row['idclase_cuenta'];
		$this->idgrupo_cuenta->DbValue = $row['idgrupo_cuenta'];
		$this->idsubgrupo_cuenta->DbValue = $row['idsubgrupo_cuenta'];
		$this->idcuenta_mayor_principal->DbValue = $row['idcuenta_mayor_principal'];
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
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
		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idbalance_general_detalle
		// idbalance_general
		// idclase_cuenta
		// idgrupo_cuenta
		// idsubgrupo_cuenta
		// idcuenta_mayor_principal
		// monto
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idbalance_general_detalle
		$this->idbalance_general_detalle->ViewValue = $this->idbalance_general_detalle->CurrentValue;
		$this->idbalance_general_detalle->ViewCustomAttributes = "";

		// idbalance_general
		if (strval($this->idbalance_general->CurrentValue) <> "") {
			$sFilterWrk = "`idbalance_general`" . ew_SearchString("=", $this->idbalance_general->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idbalance_general`, `idempresa` AS `DispFld`, `idperioso_contable` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `balance_general`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idbalance_general, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->idbalance_general->ViewValue = $this->idbalance_general->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idbalance_general->ViewValue = $this->idbalance_general->CurrentValue;
			}
		} else {
			$this->idbalance_general->ViewValue = NULL;
		}
		$this->idbalance_general->ViewCustomAttributes = "";

		// idclase_cuenta
		if (strval($this->idclase_cuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idclase_cuenta->ViewValue = $this->idclase_cuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idclase_cuenta->ViewValue = $this->idclase_cuenta->CurrentValue;
			}
		} else {
			$this->idclase_cuenta->ViewValue = NULL;
		}
		$this->idclase_cuenta->ViewCustomAttributes = "";

		// idgrupo_cuenta
		if (strval($this->idgrupo_cuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->CurrentValue;
			}
		} else {
			$this->idgrupo_cuenta->ViewValue = NULL;
		}
		$this->idgrupo_cuenta->ViewCustomAttributes = "";

		// idsubgrupo_cuenta
		if (strval($this->idsubgrupo_cuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
			}
		} else {
			$this->idsubgrupo_cuenta->ViewValue = NULL;
		}
		$this->idsubgrupo_cuenta->ViewCustomAttributes = "";

		// idcuenta_mayor_principal
		if (strval($this->idcuenta_mayor_principal->CurrentValue) <> "") {
			$sFilterWrk = "`idcuenta_mayor_principal`" . ew_SearchString("=", $this->idcuenta_mayor_principal->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idcuenta_mayor_principal->ViewValue = $this->idcuenta_mayor_principal->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idcuenta_mayor_principal->ViewValue = $this->idcuenta_mayor_principal->CurrentValue;
			}
		} else {
			$this->idcuenta_mayor_principal->ViewValue = NULL;
		}
		$this->idcuenta_mayor_principal->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewValue = ew_FormatNumber($this->monto->ViewValue, 2, -1, -1, -1);
		$this->monto->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

			// idbalance_general_detalle
			$this->idbalance_general_detalle->LinkCustomAttributes = "";
			$this->idbalance_general_detalle->HrefValue = "";
			$this->idbalance_general_detalle->TooltipValue = "";

			// idbalance_general
			$this->idbalance_general->LinkCustomAttributes = "";
			$this->idbalance_general->HrefValue = "";
			$this->idbalance_general->TooltipValue = "";

			// idclase_cuenta
			$this->idclase_cuenta->LinkCustomAttributes = "";
			$this->idclase_cuenta->HrefValue = "";
			$this->idclase_cuenta->TooltipValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";
			$this->idgrupo_cuenta->TooltipValue = "";

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";
			$this->idsubgrupo_cuenta->TooltipValue = "";

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->LinkCustomAttributes = "";
			$this->idcuenta_mayor_principal->HrefValue = "";
			$this->idcuenta_mayor_principal->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "balance_general") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idbalance_general"] <> "") {
					$GLOBALS["balance_general"]->idbalance_general->setQueryStringValue($_GET["fk_idbalance_general"]);
					$this->idbalance_general->setQueryStringValue($GLOBALS["balance_general"]->idbalance_general->QueryStringValue);
					$this->idbalance_general->setSessionValue($this->idbalance_general->QueryStringValue);
					if (!is_numeric($GLOBALS["balance_general"]->idbalance_general->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "balance_general") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idbalance_general"] <> "") {
					$GLOBALS["balance_general"]->idbalance_general->setFormValue($_POST["fk_idbalance_general"]);
					$this->idbalance_general->setFormValue($GLOBALS["balance_general"]->idbalance_general->FormValue);
					$this->idbalance_general->setSessionValue($this->idbalance_general->FormValue);
					if (!is_numeric($GLOBALS["balance_general"]->idbalance_general->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "balance_general") {
				if ($this->idbalance_general->CurrentValue == "") $this->idbalance_general->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("balance_general_detallelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($balance_general_detalle_view)) $balance_general_detalle_view = new cbalance_general_detalle_view();

// Page init
$balance_general_detalle_view->Page_Init();

// Page main
$balance_general_detalle_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_detalle_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fbalance_general_detalleview = new ew_Form("fbalance_general_detalleview", "view");

// Form_CustomValidate event
fbalance_general_detalleview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_general_detalleview.ValidateRequired = true;
<?php } else { ?>
fbalance_general_detalleview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_general_detalleview.Lists["x_idbalance_general"] = {"LinkField":"x_idbalance_general","Ajax":true,"AutoFill":false,"DisplayFields":["x_idempresa","x_idperioso_contable","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_cuenta"],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idsubgrupo_cuenta"],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_idsubgrupo_cuenta"] = {"LinkField":"x_idsubgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idcuenta_mayor_principal"],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detalleview.Lists["x_estado"].Options = <?php echo json_encode($balance_general_detalle->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $balance_general_detalle_view->ExportOptions->Render("body") ?>
<?php
	foreach ($balance_general_detalle_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $balance_general_detalle_view->ShowPageHeader(); ?>
<?php
$balance_general_detalle_view->ShowMessage();
?>
<form name="fbalance_general_detalleview" id="fbalance_general_detalleview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($balance_general_detalle_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $balance_general_detalle_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="balance_general_detalle">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($balance_general_detalle->idbalance_general_detalle->Visible) { // idbalance_general_detalle ?>
	<tr id="r_idbalance_general_detalle">
		<td><span id="elh_balance_general_detalle_idbalance_general_detalle"><?php echo $balance_general_detalle->idbalance_general_detalle->FldCaption() ?></span></td>
		<td data-name="idbalance_general_detalle"<?php echo $balance_general_detalle->idbalance_general_detalle->CellAttributes() ?>>
<span id="el_balance_general_detalle_idbalance_general_detalle">
<span<?php echo $balance_general_detalle->idbalance_general_detalle->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idbalance_general_detalle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->idbalance_general->Visible) { // idbalance_general ?>
	<tr id="r_idbalance_general">
		<td><span id="elh_balance_general_detalle_idbalance_general"><?php echo $balance_general_detalle->idbalance_general->FldCaption() ?></span></td>
		<td data-name="idbalance_general"<?php echo $balance_general_detalle->idbalance_general->CellAttributes() ?>>
<span id="el_balance_general_detalle_idbalance_general">
<span<?php echo $balance_general_detalle->idbalance_general->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idbalance_general->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<tr id="r_idclase_cuenta">
		<td><span id="elh_balance_general_detalle_idclase_cuenta"><?php echo $balance_general_detalle->idclase_cuenta->FldCaption() ?></span></td>
		<td data-name="idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->CellAttributes() ?>>
<span id="el_balance_general_detalle_idclase_cuenta">
<span<?php echo $balance_general_detalle->idclase_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idclase_cuenta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<tr id="r_idgrupo_cuenta">
		<td><span id="elh_balance_general_detalle_idgrupo_cuenta"><?php echo $balance_general_detalle->idgrupo_cuenta->FldCaption() ?></span></td>
		<td data-name="idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->CellAttributes() ?>>
<span id="el_balance_general_detalle_idgrupo_cuenta">
<span<?php echo $balance_general_detalle->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
	<tr id="r_idsubgrupo_cuenta">
		<td><span id="elh_balance_general_detalle_idsubgrupo_cuenta"><?php echo $balance_general_detalle->idsubgrupo_cuenta->FldCaption() ?></span></td>
		<td data-name="idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->CellAttributes() ?>>
<span id="el_balance_general_detalle_idsubgrupo_cuenta">
<span<?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<tr id="r_idcuenta_mayor_principal">
		<td><span id="elh_balance_general_detalle_idcuenta_mayor_principal"><?php echo $balance_general_detalle->idcuenta_mayor_principal->FldCaption() ?></span></td>
		<td data-name="idcuenta_mayor_principal"<?php echo $balance_general_detalle->idcuenta_mayor_principal->CellAttributes() ?>>
<span id="el_balance_general_detalle_idcuenta_mayor_principal">
<span<?php echo $balance_general_detalle->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idcuenta_mayor_principal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_balance_general_detalle_monto"><?php echo $balance_general_detalle->monto->FldCaption() ?></span></td>
		<td data-name="monto"<?php echo $balance_general_detalle->monto->CellAttributes() ?>>
<span id="el_balance_general_detalle_monto">
<span<?php echo $balance_general_detalle->monto->ViewAttributes() ?>>
<?php echo $balance_general_detalle->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_balance_general_detalle_estado"><?php echo $balance_general_detalle->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $balance_general_detalle->estado->CellAttributes() ?>>
<span id="el_balance_general_detalle_estado">
<span<?php echo $balance_general_detalle->estado->ViewAttributes() ?>>
<?php echo $balance_general_detalle->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general_detalle->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_balance_general_detalle_fecha_insercion"><?php echo $balance_general_detalle->fecha_insercion->FldCaption() ?></span></td>
		<td data-name="fecha_insercion"<?php echo $balance_general_detalle->fecha_insercion->CellAttributes() ?>>
<span id="el_balance_general_detalle_fecha_insercion">
<span<?php echo $balance_general_detalle->fecha_insercion->ViewAttributes() ?>>
<?php echo $balance_general_detalle->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fbalance_general_detalleview.Init();
</script>
<?php
$balance_general_detalle_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$balance_general_detalle_view->Page_Terminate();
?>
