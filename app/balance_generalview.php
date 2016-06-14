<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "balance_generalinfo.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "periodo_contableinfo.php" ?>
<?php include_once "balance_general_detallegridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$balance_general_view = NULL; // Initialize page object first

class cbalance_general_view extends cbalance_general {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'balance_general';

	// Page object name
	var $PageObjName = 'balance_general_view';

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

		// Table object (balance_general)
		if (!isset($GLOBALS["balance_general"]) || get_class($GLOBALS["balance_general"]) == "cbalance_general") {
			$GLOBALS["balance_general"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["balance_general"];
		}
		$KeyUrl = "";
		if (@$_GET["idbalance_general"] <> "") {
			$this->RecKey["idbalance_general"] = $_GET["idbalance_general"];
			$KeyUrl .= "&amp;idbalance_general=" . urlencode($this->RecKey["idbalance_general"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'balance_general', TRUE);

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
		$this->idbalance_general->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $balance_general;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($balance_general);
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
			if (@$_GET["idbalance_general"] <> "") {
				$this->idbalance_general->setQueryStringValue($_GET["idbalance_general"]);
				$this->RecKey["idbalance_general"] = $this->idbalance_general->QueryStringValue;
			} elseif (@$_POST["idbalance_general"] <> "") {
				$this->idbalance_general->setFormValue($_POST["idbalance_general"]);
				$this->RecKey["idbalance_general"] = $this->idbalance_general->FormValue;
			} else {
				$sReturnUrl = "balance_generallist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "balance_generallist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "balance_generallist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetUpDetailParms();
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
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_balance_general_detalle"
		$item = &$option->Add("detail_balance_general_detalle");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("balance_general_detalle", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("balance_general_detallelist.php?" . EW_TABLE_SHOW_MASTER . "=balance_general&fk_idbalance_general=" . urlencode(strval($this->idbalance_general->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["balance_general_detalle_grid"] && $GLOBALS["balance_general_detalle_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=balance_general_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "balance_general_detalle";
		}
		if ($GLOBALS["balance_general_detalle_grid"] && $GLOBALS["balance_general_detalle_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=balance_general_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "balance_general_detalle";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = TRUE;
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "balance_general_detalle";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

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
		$this->idbalance_general->setDbValue($rs->fields('idbalance_general'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idperioso_contable->setDbValue($rs->fields('idperioso_contable'));
		$this->activo_circulante->setDbValue($rs->fields('activo_circulante'));
		$this->activo_fijo->setDbValue($rs->fields('activo_fijo'));
		$this->pasivo_circulante->setDbValue($rs->fields('pasivo_circulante'));
		$this->pasivo_fijo->setDbValue($rs->fields('pasivo_fijo'));
		$this->capital_contable->setDbValue($rs->fields('capital_contable'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idbalance_general->DbValue = $row['idbalance_general'];
		$this->idempresa->DbValue = $row['idempresa'];
		$this->idperioso_contable->DbValue = $row['idperioso_contable'];
		$this->activo_circulante->DbValue = $row['activo_circulante'];
		$this->activo_fijo->DbValue = $row['activo_fijo'];
		$this->pasivo_circulante->DbValue = $row['pasivo_circulante'];
		$this->pasivo_fijo->DbValue = $row['pasivo_fijo'];
		$this->capital_contable->DbValue = $row['capital_contable'];
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
		if ($this->activo_circulante->FormValue == $this->activo_circulante->CurrentValue && is_numeric(ew_StrToFloat($this->activo_circulante->CurrentValue)))
			$this->activo_circulante->CurrentValue = ew_StrToFloat($this->activo_circulante->CurrentValue);

		// Convert decimal values if posted back
		if ($this->activo_fijo->FormValue == $this->activo_fijo->CurrentValue && is_numeric(ew_StrToFloat($this->activo_fijo->CurrentValue)))
			$this->activo_fijo->CurrentValue = ew_StrToFloat($this->activo_fijo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pasivo_circulante->FormValue == $this->pasivo_circulante->CurrentValue && is_numeric(ew_StrToFloat($this->pasivo_circulante->CurrentValue)))
			$this->pasivo_circulante->CurrentValue = ew_StrToFloat($this->pasivo_circulante->CurrentValue);

		// Convert decimal values if posted back
		if ($this->pasivo_fijo->FormValue == $this->pasivo_fijo->CurrentValue && is_numeric(ew_StrToFloat($this->pasivo_fijo->CurrentValue)))
			$this->pasivo_fijo->CurrentValue = ew_StrToFloat($this->pasivo_fijo->CurrentValue);

		// Convert decimal values if posted back
		if ($this->capital_contable->FormValue == $this->capital_contable->CurrentValue && is_numeric(ew_StrToFloat($this->capital_contable->CurrentValue)))
			$this->capital_contable->CurrentValue = ew_StrToFloat($this->capital_contable->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idbalance_general
		// idempresa
		// idperioso_contable
		// activo_circulante
		// activo_fijo
		// pasivo_circulante
		// pasivo_fijo
		// capital_contable
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idbalance_general
		$this->idbalance_general->ViewValue = $this->idbalance_general->CurrentValue;
		$this->idbalance_general->ViewCustomAttributes = "";

		// idempresa
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
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

		// idperioso_contable
		if (strval($this->idperioso_contable->CurrentValue) <> "") {
			$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperioso_contable->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idperioso_contable, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idperioso_contable->ViewValue = $this->idperioso_contable->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idperioso_contable->ViewValue = $this->idperioso_contable->CurrentValue;
			}
		} else {
			$this->idperioso_contable->ViewValue = NULL;
		}
		$this->idperioso_contable->ViewCustomAttributes = "";

		// activo_circulante
		$this->activo_circulante->ViewValue = $this->activo_circulante->CurrentValue;
		$this->activo_circulante->ViewCustomAttributes = "";

		// activo_fijo
		$this->activo_fijo->ViewValue = $this->activo_fijo->CurrentValue;
		$this->activo_fijo->ViewCustomAttributes = "";

		// pasivo_circulante
		$this->pasivo_circulante->ViewValue = $this->pasivo_circulante->CurrentValue;
		$this->pasivo_circulante->ViewCustomAttributes = "";

		// pasivo_fijo
		$this->pasivo_fijo->ViewValue = $this->pasivo_fijo->CurrentValue;
		$this->pasivo_fijo->ViewCustomAttributes = "";

		// capital_contable
		$this->capital_contable->ViewValue = $this->capital_contable->CurrentValue;
		$this->capital_contable->ViewCustomAttributes = "";

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

			// idbalance_general
			$this->idbalance_general->LinkCustomAttributes = "";
			$this->idbalance_general->HrefValue = "";
			$this->idbalance_general->TooltipValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";

			// idperioso_contable
			$this->idperioso_contable->LinkCustomAttributes = "";
			$this->idperioso_contable->HrefValue = "";
			$this->idperioso_contable->TooltipValue = "";

			// activo_circulante
			$this->activo_circulante->LinkCustomAttributes = "";
			$this->activo_circulante->HrefValue = "";
			$this->activo_circulante->TooltipValue = "";

			// activo_fijo
			$this->activo_fijo->LinkCustomAttributes = "";
			$this->activo_fijo->HrefValue = "";
			$this->activo_fijo->TooltipValue = "";

			// pasivo_circulante
			$this->pasivo_circulante->LinkCustomAttributes = "";
			$this->pasivo_circulante->HrefValue = "";
			$this->pasivo_circulante->TooltipValue = "";

			// pasivo_fijo
			$this->pasivo_fijo->LinkCustomAttributes = "";
			$this->pasivo_fijo->HrefValue = "";
			$this->pasivo_fijo->TooltipValue = "";

			// capital_contable
			$this->capital_contable->LinkCustomAttributes = "";
			$this->capital_contable->HrefValue = "";
			$this->capital_contable->TooltipValue = "";

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
			if ($sMasterTblVar == "empresa") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idempresa"] <> "") {
					$GLOBALS["empresa"]->idempresa->setQueryStringValue($_GET["fk_idempresa"]);
					$this->idempresa->setQueryStringValue($GLOBALS["empresa"]->idempresa->QueryStringValue);
					$this->idempresa->setSessionValue($this->idempresa->QueryStringValue);
					if (!is_numeric($GLOBALS["empresa"]->idempresa->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "periodo_contable") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idperiodo_contable"] <> "") {
					$GLOBALS["periodo_contable"]->idperiodo_contable->setQueryStringValue($_GET["fk_idperiodo_contable"]);
					$this->idperioso_contable->setQueryStringValue($GLOBALS["periodo_contable"]->idperiodo_contable->QueryStringValue);
					$this->idperioso_contable->setSessionValue($this->idperioso_contable->QueryStringValue);
					if (!is_numeric($GLOBALS["periodo_contable"]->idperiodo_contable->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "empresa") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idempresa"] <> "") {
					$GLOBALS["empresa"]->idempresa->setFormValue($_POST["fk_idempresa"]);
					$this->idempresa->setFormValue($GLOBALS["empresa"]->idempresa->FormValue);
					$this->idempresa->setSessionValue($this->idempresa->FormValue);
					if (!is_numeric($GLOBALS["empresa"]->idempresa->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "periodo_contable") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idperiodo_contable"] <> "") {
					$GLOBALS["periodo_contable"]->idperiodo_contable->setFormValue($_POST["fk_idperiodo_contable"]);
					$this->idperioso_contable->setFormValue($GLOBALS["periodo_contable"]->idperiodo_contable->FormValue);
					$this->idperioso_contable->setSessionValue($this->idperioso_contable->FormValue);
					if (!is_numeric($GLOBALS["periodo_contable"]->idperiodo_contable->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "empresa") {
				if ($this->idempresa->CurrentValue == "") $this->idempresa->setSessionValue("");
			}
			if ($sMasterTblVar <> "periodo_contable") {
				if ($this->idperioso_contable->CurrentValue == "") $this->idperioso_contable->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
			if (in_array("balance_general_detalle", $DetailTblVar)) {
				if (!isset($GLOBALS["balance_general_detalle_grid"]))
					$GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid;
				if ($GLOBALS["balance_general_detalle_grid"]->DetailView) {
					$GLOBALS["balance_general_detalle_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["balance_general_detalle_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["balance_general_detalle_grid"]->setStartRecordNumber(1);
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->FldIsDetailKey = TRUE;
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->CurrentValue = $this->idbalance_general->CurrentValue;
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->setSessionValue($GLOBALS["balance_general_detalle_grid"]->idbalance_general->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("balance_generallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($balance_general_view)) $balance_general_view = new cbalance_general_view();

// Page init
$balance_general_view->Page_Init();

// Page main
$balance_general_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fbalance_generalview = new ew_Form("fbalance_generalview", "view");

// Form_CustomValidate event
fbalance_generalview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_generalview.ValidateRequired = true;
<?php } else { ?>
fbalance_generalview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_generalview.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_ticker","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generalview.Lists["x_idperioso_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generalview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generalview.Lists["x_estado"].Options = <?php echo json_encode($balance_general->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $balance_general_view->ExportOptions->Render("body") ?>
<?php
	foreach ($balance_general_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $balance_general_view->ShowPageHeader(); ?>
<?php
$balance_general_view->ShowMessage();
?>
<form name="fbalance_generalview" id="fbalance_generalview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($balance_general_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $balance_general_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="balance_general">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($balance_general->idbalance_general->Visible) { // idbalance_general ?>
	<tr id="r_idbalance_general">
		<td><span id="elh_balance_general_idbalance_general"><?php echo $balance_general->idbalance_general->FldCaption() ?></span></td>
		<td data-name="idbalance_general"<?php echo $balance_general->idbalance_general->CellAttributes() ?>>
<span id="el_balance_general_idbalance_general">
<span<?php echo $balance_general->idbalance_general->ViewAttributes() ?>>
<?php echo $balance_general->idbalance_general->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
	<tr id="r_idempresa">
		<td><span id="elh_balance_general_idempresa"><?php echo $balance_general->idempresa->FldCaption() ?></span></td>
		<td data-name="idempresa"<?php echo $balance_general->idempresa->CellAttributes() ?>>
<span id="el_balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<?php echo $balance_general->idempresa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->idperioso_contable->Visible) { // idperioso_contable ?>
	<tr id="r_idperioso_contable">
		<td><span id="elh_balance_general_idperioso_contable"><?php echo $balance_general->idperioso_contable->FldCaption() ?></span></td>
		<td data-name="idperioso_contable"<?php echo $balance_general->idperioso_contable->CellAttributes() ?>>
<span id="el_balance_general_idperioso_contable">
<span<?php echo $balance_general->idperioso_contable->ViewAttributes() ?>>
<?php echo $balance_general->idperioso_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
	<tr id="r_activo_circulante">
		<td><span id="elh_balance_general_activo_circulante"><?php echo $balance_general->activo_circulante->FldCaption() ?></span></td>
		<td data-name="activo_circulante"<?php echo $balance_general->activo_circulante->CellAttributes() ?>>
<span id="el_balance_general_activo_circulante">
<span<?php echo $balance_general->activo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->activo_circulante->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
	<tr id="r_activo_fijo">
		<td><span id="elh_balance_general_activo_fijo"><?php echo $balance_general->activo_fijo->FldCaption() ?></span></td>
		<td data-name="activo_fijo"<?php echo $balance_general->activo_fijo->CellAttributes() ?>>
<span id="el_balance_general_activo_fijo">
<span<?php echo $balance_general->activo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->activo_fijo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
	<tr id="r_pasivo_circulante">
		<td><span id="elh_balance_general_pasivo_circulante"><?php echo $balance_general->pasivo_circulante->FldCaption() ?></span></td>
		<td data-name="pasivo_circulante"<?php echo $balance_general->pasivo_circulante->CellAttributes() ?>>
<span id="el_balance_general_pasivo_circulante">
<span<?php echo $balance_general->pasivo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_circulante->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
	<tr id="r_pasivo_fijo">
		<td><span id="elh_balance_general_pasivo_fijo"><?php echo $balance_general->pasivo_fijo->FldCaption() ?></span></td>
		<td data-name="pasivo_fijo"<?php echo $balance_general->pasivo_fijo->CellAttributes() ?>>
<span id="el_balance_general_pasivo_fijo">
<span<?php echo $balance_general->pasivo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_fijo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
	<tr id="r_capital_contable">
		<td><span id="elh_balance_general_capital_contable"><?php echo $balance_general->capital_contable->FldCaption() ?></span></td>
		<td data-name="capital_contable"<?php echo $balance_general->capital_contable->CellAttributes() ?>>
<span id="el_balance_general_capital_contable">
<span<?php echo $balance_general->capital_contable->ViewAttributes() ?>>
<?php echo $balance_general->capital_contable->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_balance_general_estado"><?php echo $balance_general->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $balance_general->estado->CellAttributes() ?>>
<span id="el_balance_general_estado">
<span<?php echo $balance_general->estado->ViewAttributes() ?>>
<?php echo $balance_general->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($balance_general->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_balance_general_fecha_insercion"><?php echo $balance_general->fecha_insercion->FldCaption() ?></span></td>
		<td data-name="fecha_insercion"<?php echo $balance_general->fecha_insercion->CellAttributes() ?>>
<span id="el_balance_general_fecha_insercion">
<span<?php echo $balance_general->fecha_insercion->ViewAttributes() ?>>
<?php echo $balance_general->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("balance_general_detalle", explode(",", $balance_general->getCurrentDetailTable())) && $balance_general_detalle->DetailView) {
?>
<?php if ($balance_general->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("balance_general_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "balance_general_detallegrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fbalance_generalview.Init();
</script>
<?php
$balance_general_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$balance_general_view->Page_Terminate();
?>
