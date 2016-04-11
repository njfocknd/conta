<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "documento_caja_chicainfo.php" ?>
<?php include_once "caja_chicainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$documento_caja_chica_view = NULL; // Initialize page object first

class cdocumento_caja_chica_view extends cdocumento_caja_chica {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'documento_caja_chica';

	// Page object name
	var $PageObjName = 'documento_caja_chica_view';

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

		// Table object (documento_caja_chica)
		if (!isset($GLOBALS["documento_caja_chica"]) || get_class($GLOBALS["documento_caja_chica"]) == "cdocumento_caja_chica") {
			$GLOBALS["documento_caja_chica"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_caja_chica"];
		}
		$KeyUrl = "";
		if (@$_GET["iddocumento_caja_chica"] <> "") {
			$this->RecKey["iddocumento_caja_chica"] = $_GET["iddocumento_caja_chica"];
			$KeyUrl .= "&amp;iddocumento_caja_chica=" . urlencode($this->RecKey["iddocumento_caja_chica"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (caja_chica)
		if (!isset($GLOBALS['caja_chica'])) $GLOBALS['caja_chica'] = new ccaja_chica();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_caja_chica', TRUE);

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
		$this->iddocumento_caja_chica->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $documento_caja_chica;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($documento_caja_chica);
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
			if (@$_GET["iddocumento_caja_chica"] <> "") {
				$this->iddocumento_caja_chica->setQueryStringValue($_GET["iddocumento_caja_chica"]);
				$this->RecKey["iddocumento_caja_chica"] = $this->iddocumento_caja_chica->QueryStringValue;
			} elseif (@$_POST["iddocumento_caja_chica"] <> "") {
				$this->iddocumento_caja_chica->setFormValue($_POST["iddocumento_caja_chica"]);
				$this->RecKey["iddocumento_caja_chica"] = $this->iddocumento_caja_chica->FormValue;
			} else {
				$sReturnUrl = "documento_caja_chicalist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "documento_caja_chicalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "documento_caja_chicalist.php"; // Not page request, return to list
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
		$this->iddocumento_caja_chica->setDbValue($rs->fields('iddocumento_caja_chica'));
		$this->idcaja_chica->setDbValue($rs->fields('idcaja_chica'));
		$this->tipo->setDbValue($rs->fields('tipo'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddocumento_caja_chica->DbValue = $row['iddocumento_caja_chica'];
		$this->idcaja_chica->DbValue = $row['idcaja_chica'];
		$this->tipo->DbValue = $row['tipo'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->serie->DbValue = $row['serie'];
		$this->numero->DbValue = $row['numero'];
		$this->fecha->DbValue = $row['fecha'];
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
		// iddocumento_caja_chica
		// idcaja_chica
		// tipo
		// idtipo_documento
		// serie
		// numero
		// fecha
		// monto
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// iddocumento_caja_chica
		$this->iddocumento_caja_chica->ViewValue = $this->iddocumento_caja_chica->CurrentValue;
		$this->iddocumento_caja_chica->ViewCustomAttributes = "";

		// idcaja_chica
		if (strval($this->idcaja_chica->CurrentValue) <> "") {
			$sFilterWrk = "`idcaja_chica`" . ew_SearchString("=", $this->idcaja_chica->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idcaja_chica, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idcaja_chica->ViewValue = $this->idcaja_chica->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
			}
		} else {
			$this->idcaja_chica->ViewValue = NULL;
		}
		$this->idcaja_chica->ViewCustomAttributes = "";

		// tipo
		if (strval($this->tipo->CurrentValue) <> "") {
			$this->tipo->ViewValue = $this->tipo->OptionCaption($this->tipo->CurrentValue);
		} else {
			$this->tipo->ViewValue = NULL;
		}
		$this->tipo->ViewCustomAttributes = "";

		// idtipo_documento
		if (strval($this->idtipo_documento->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
			}
		} else {
			$this->idtipo_documento->ViewValue = NULL;
		}
		$this->idtipo_documento->ViewCustomAttributes = "";

		// serie
		$this->serie->ViewValue = $this->serie->CurrentValue;
		$this->serie->ViewCustomAttributes = "";

		// numero
		$this->numero->ViewValue = $this->numero->CurrentValue;
		$this->numero->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
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

			// iddocumento_caja_chica
			$this->iddocumento_caja_chica->LinkCustomAttributes = "";
			$this->iddocumento_caja_chica->HrefValue = "";
			$this->iddocumento_caja_chica->TooltipValue = "";

			// idcaja_chica
			$this->idcaja_chica->LinkCustomAttributes = "";
			$this->idcaja_chica->HrefValue = "";
			$this->idcaja_chica->TooltipValue = "";

			// tipo
			$this->tipo->LinkCustomAttributes = "";
			$this->tipo->HrefValue = "";
			$this->tipo->TooltipValue = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// serie
			$this->serie->LinkCustomAttributes = "";
			$this->serie->HrefValue = "";
			$this->serie->TooltipValue = "";

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";
			$this->numero->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

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
			if ($sMasterTblVar == "caja_chica") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcaja_chica"] <> "") {
					$GLOBALS["caja_chica"]->idcaja_chica->setQueryStringValue($_GET["fk_idcaja_chica"]);
					$this->idcaja_chica->setQueryStringValue($GLOBALS["caja_chica"]->idcaja_chica->QueryStringValue);
					$this->idcaja_chica->setSessionValue($this->idcaja_chica->QueryStringValue);
					if (!is_numeric($GLOBALS["caja_chica"]->idcaja_chica->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "caja_chica") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idcaja_chica"] <> "") {
					$GLOBALS["caja_chica"]->idcaja_chica->setFormValue($_POST["fk_idcaja_chica"]);
					$this->idcaja_chica->setFormValue($GLOBALS["caja_chica"]->idcaja_chica->FormValue);
					$this->idcaja_chica->setSessionValue($this->idcaja_chica->FormValue);
					if (!is_numeric($GLOBALS["caja_chica"]->idcaja_chica->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "caja_chica") {
				if ($this->idcaja_chica->CurrentValue == "") $this->idcaja_chica->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("documento_caja_chicalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($documento_caja_chica_view)) $documento_caja_chica_view = new cdocumento_caja_chica_view();

// Page init
$documento_caja_chica_view->Page_Init();

// Page main
$documento_caja_chica_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_caja_chica_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fdocumento_caja_chicaview = new ew_Form("fdocumento_caja_chicaview", "view");

// Form_CustomValidate event
fdocumento_caja_chicaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_caja_chicaview.ValidateRequired = true;
<?php } else { ?>
fdocumento_caja_chicaview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_caja_chicaview.Lists["x_idcaja_chica"] = {"LinkField":"x_idcaja_chica","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaview.Lists["x_tipo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaview.Lists["x_tipo"].Options = <?php echo json_encode($documento_caja_chica->tipo->Options()) ?>;
fdocumento_caja_chicaview.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaview.Lists["x_estado"].Options = <?php echo json_encode($documento_caja_chica->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $documento_caja_chica_view->ExportOptions->Render("body") ?>
<?php
	foreach ($documento_caja_chica_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $documento_caja_chica_view->ShowPageHeader(); ?>
<?php
$documento_caja_chica_view->ShowMessage();
?>
<form name="fdocumento_caja_chicaview" id="fdocumento_caja_chicaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_caja_chica_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_caja_chica_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_caja_chica">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($documento_caja_chica->iddocumento_caja_chica->Visible) { // iddocumento_caja_chica ?>
	<tr id="r_iddocumento_caja_chica">
		<td><span id="elh_documento_caja_chica_iddocumento_caja_chica"><?php echo $documento_caja_chica->iddocumento_caja_chica->FldCaption() ?></span></td>
		<td data-name="iddocumento_caja_chica"<?php echo $documento_caja_chica->iddocumento_caja_chica->CellAttributes() ?>>
<span id="el_documento_caja_chica_iddocumento_caja_chica">
<span<?php echo $documento_caja_chica->iddocumento_caja_chica->ViewAttributes() ?>>
<?php echo $documento_caja_chica->iddocumento_caja_chica->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->idcaja_chica->Visible) { // idcaja_chica ?>
	<tr id="r_idcaja_chica">
		<td><span id="elh_documento_caja_chica_idcaja_chica"><?php echo $documento_caja_chica->idcaja_chica->FldCaption() ?></span></td>
		<td data-name="idcaja_chica"<?php echo $documento_caja_chica->idcaja_chica->CellAttributes() ?>>
<span id="el_documento_caja_chica_idcaja_chica">
<span<?php echo $documento_caja_chica->idcaja_chica->ViewAttributes() ?>>
<?php echo $documento_caja_chica->idcaja_chica->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->tipo->Visible) { // tipo ?>
	<tr id="r_tipo">
		<td><span id="elh_documento_caja_chica_tipo"><?php echo $documento_caja_chica->tipo->FldCaption() ?></span></td>
		<td data-name="tipo"<?php echo $documento_caja_chica->tipo->CellAttributes() ?>>
<span id="el_documento_caja_chica_tipo">
<span<?php echo $documento_caja_chica->tipo->ViewAttributes() ?>>
<?php echo $documento_caja_chica->tipo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->idtipo_documento->Visible) { // idtipo_documento ?>
	<tr id="r_idtipo_documento">
		<td><span id="elh_documento_caja_chica_idtipo_documento"><?php echo $documento_caja_chica->idtipo_documento->FldCaption() ?></span></td>
		<td data-name="idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_caja_chica_idtipo_documento">
<span<?php echo $documento_caja_chica->idtipo_documento->ViewAttributes() ?>>
<?php echo $documento_caja_chica->idtipo_documento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->serie->Visible) { // serie ?>
	<tr id="r_serie">
		<td><span id="elh_documento_caja_chica_serie"><?php echo $documento_caja_chica->serie->FldCaption() ?></span></td>
		<td data-name="serie"<?php echo $documento_caja_chica->serie->CellAttributes() ?>>
<span id="el_documento_caja_chica_serie">
<span<?php echo $documento_caja_chica->serie->ViewAttributes() ?>>
<?php echo $documento_caja_chica->serie->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->numero->Visible) { // numero ?>
	<tr id="r_numero">
		<td><span id="elh_documento_caja_chica_numero"><?php echo $documento_caja_chica->numero->FldCaption() ?></span></td>
		<td data-name="numero"<?php echo $documento_caja_chica->numero->CellAttributes() ?>>
<span id="el_documento_caja_chica_numero">
<span<?php echo $documento_caja_chica->numero->ViewAttributes() ?>>
<?php echo $documento_caja_chica->numero->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_documento_caja_chica_fecha"><?php echo $documento_caja_chica->fecha->FldCaption() ?></span></td>
		<td data-name="fecha"<?php echo $documento_caja_chica->fecha->CellAttributes() ?>>
<span id="el_documento_caja_chica_fecha">
<span<?php echo $documento_caja_chica->fecha->ViewAttributes() ?>>
<?php echo $documento_caja_chica->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_documento_caja_chica_monto"><?php echo $documento_caja_chica->monto->FldCaption() ?></span></td>
		<td data-name="monto"<?php echo $documento_caja_chica->monto->CellAttributes() ?>>
<span id="el_documento_caja_chica_monto">
<span<?php echo $documento_caja_chica->monto->ViewAttributes() ?>>
<?php echo $documento_caja_chica->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_documento_caja_chica_estado"><?php echo $documento_caja_chica->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $documento_caja_chica->estado->CellAttributes() ?>>
<span id="el_documento_caja_chica_estado">
<span<?php echo $documento_caja_chica->estado->ViewAttributes() ?>>
<?php echo $documento_caja_chica->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($documento_caja_chica->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_documento_caja_chica_fecha_insercion"><?php echo $documento_caja_chica->fecha_insercion->FldCaption() ?></span></td>
		<td data-name="fecha_insercion"<?php echo $documento_caja_chica->fecha_insercion->CellAttributes() ?>>
<span id="el_documento_caja_chica_fecha_insercion">
<span<?php echo $documento_caja_chica->fecha_insercion->ViewAttributes() ?>>
<?php echo $documento_caja_chica->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fdocumento_caja_chicaview.Init();
</script>
<?php
$documento_caja_chica_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$documento_caja_chica_view->Page_Terminate();
?>
