<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "cuenta_mayor_auxiliarinfo.php" ?>
<?php include_once "cuenta_mayor_principalinfo.php" ?>
<?php include_once "subcuentagridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$cuenta_mayor_auxiliar_view = NULL; // Initialize page object first

class ccuenta_mayor_auxiliar_view extends ccuenta_mayor_auxiliar {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'cuenta_mayor_auxiliar';

	// Page object name
	var $PageObjName = 'cuenta_mayor_auxiliar_view';

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

		// Table object (cuenta_mayor_auxiliar)
		if (!isset($GLOBALS["cuenta_mayor_auxiliar"]) || get_class($GLOBALS["cuenta_mayor_auxiliar"]) == "ccuenta_mayor_auxiliar") {
			$GLOBALS["cuenta_mayor_auxiliar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta_mayor_auxiliar"];
		}
		$KeyUrl = "";
		if (@$_GET["idcuenta_mayor_auxiliar"] <> "") {
			$this->RecKey["idcuenta_mayor_auxiliar"] = $_GET["idcuenta_mayor_auxiliar"];
			$KeyUrl .= "&amp;idcuenta_mayor_auxiliar=" . urlencode($this->RecKey["idcuenta_mayor_auxiliar"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (cuenta_mayor_principal)
		if (!isset($GLOBALS['cuenta_mayor_principal'])) $GLOBALS['cuenta_mayor_principal'] = new ccuenta_mayor_principal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta_mayor_auxiliar', TRUE);

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
		$this->idcuenta_mayor_auxiliar->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $cuenta_mayor_auxiliar;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta_mayor_auxiliar);
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
			if (@$_GET["idcuenta_mayor_auxiliar"] <> "") {
				$this->idcuenta_mayor_auxiliar->setQueryStringValue($_GET["idcuenta_mayor_auxiliar"]);
				$this->RecKey["idcuenta_mayor_auxiliar"] = $this->idcuenta_mayor_auxiliar->QueryStringValue;
			} elseif (@$_POST["idcuenta_mayor_auxiliar"] <> "") {
				$this->idcuenta_mayor_auxiliar->setFormValue($_POST["idcuenta_mayor_auxiliar"]);
				$this->RecKey["idcuenta_mayor_auxiliar"] = $this->idcuenta_mayor_auxiliar->FormValue;
			} else {
				$sReturnUrl = "cuenta_mayor_auxiliarlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "cuenta_mayor_auxiliarlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "cuenta_mayor_auxiliarlist.php"; // Not page request, return to list
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

		// "detail_subcuenta"
		$item = &$option->Add("detail_subcuenta");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("subcuenta", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("subcuentalist.php?" . EW_TABLE_SHOW_MASTER . "=cuenta_mayor_auxiliar&fk_idcuenta_mayor_auxiliar=" . urlencode(strval($this->idcuenta_mayor_auxiliar->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["subcuenta_grid"] && $GLOBALS["subcuenta_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=subcuenta")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "subcuenta";
		}
		if ($GLOBALS["subcuenta_grid"] && $GLOBALS["subcuenta_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=subcuenta")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "subcuenta";
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
			$DetailTableLink .= "subcuenta";
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
		$this->idcuenta_mayor_auxiliar->setDbValue($rs->fields('idcuenta_mayor_auxiliar'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idcuenta_mayor_principal->setDbValue($rs->fields('idcuenta_mayor_principal'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta_mayor_auxiliar->DbValue = $row['idcuenta_mayor_auxiliar'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idcuenta_mayor_principal->DbValue = $row['idcuenta_mayor_principal'];
		$this->definicion->DbValue = $row['definicion'];
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta_mayor_auxiliar
		// nomenclatura
		// nombre
		// idcuenta_mayor_principal
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idcuenta_mayor_auxiliar
		$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
		$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

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

		// definicion
		$this->definicion->ViewValue = $this->definicion->CurrentValue;
		$this->definicion->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->LinkCustomAttributes = "";
			$this->idcuenta_mayor_auxiliar->HrefValue = "";
			$this->idcuenta_mayor_auxiliar->TooltipValue = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->LinkCustomAttributes = "";
			$this->idcuenta_mayor_principal->HrefValue = "";
			$this->idcuenta_mayor_principal->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
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
			if ($sMasterTblVar == "cuenta_mayor_principal") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcuenta_mayor_principal"] <> "") {
					$GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->setQueryStringValue($_GET["fk_idcuenta_mayor_principal"]);
					$this->idcuenta_mayor_principal->setQueryStringValue($GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->QueryStringValue);
					$this->idcuenta_mayor_principal->setSessionValue($this->idcuenta_mayor_principal->QueryStringValue);
					if (!is_numeric($GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "cuenta_mayor_principal") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idcuenta_mayor_principal"] <> "") {
					$GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->setFormValue($_POST["fk_idcuenta_mayor_principal"]);
					$this->idcuenta_mayor_principal->setFormValue($GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->FormValue);
					$this->idcuenta_mayor_principal->setSessionValue($this->idcuenta_mayor_principal->FormValue);
					if (!is_numeric($GLOBALS["cuenta_mayor_principal"]->idcuenta_mayor_principal->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cuenta_mayor_principal") {
				if ($this->idcuenta_mayor_principal->CurrentValue == "") $this->idcuenta_mayor_principal->setSessionValue("");
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
			if (in_array("subcuenta", $DetailTblVar)) {
				if (!isset($GLOBALS["subcuenta_grid"]))
					$GLOBALS["subcuenta_grid"] = new csubcuenta_grid;
				if ($GLOBALS["subcuenta_grid"]->DetailView) {
					$GLOBALS["subcuenta_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["subcuenta_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["subcuenta_grid"]->setStartRecordNumber(1);
					$GLOBALS["subcuenta_grid"]->idcuenta_mayor_auxiliar->FldIsDetailKey = TRUE;
					$GLOBALS["subcuenta_grid"]->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
					$GLOBALS["subcuenta_grid"]->idcuenta_mayor_auxiliar->setSessionValue($GLOBALS["subcuenta_grid"]->idcuenta_mayor_auxiliar->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cuenta_mayor_auxiliarlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cuenta_mayor_auxiliar_view)) $cuenta_mayor_auxiliar_view = new ccuenta_mayor_auxiliar_view();

// Page init
$cuenta_mayor_auxiliar_view->Page_Init();

// Page main
$cuenta_mayor_auxiliar_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_mayor_auxiliar_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fcuenta_mayor_auxiliarview = new ew_Form("fcuenta_mayor_auxiliarview", "view");

// Form_CustomValidate event
fcuenta_mayor_auxiliarview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_mayor_auxiliarview.ValidateRequired = true;
<?php } else { ?>
fcuenta_mayor_auxiliarview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_mayor_auxiliarview.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcuenta_mayor_auxiliarview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcuenta_mayor_auxiliarview.Lists["x_estado"].Options = <?php echo json_encode($cuenta_mayor_auxiliar->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $cuenta_mayor_auxiliar_view->ExportOptions->Render("body") ?>
<?php
	foreach ($cuenta_mayor_auxiliar_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $cuenta_mayor_auxiliar_view->ShowPageHeader(); ?>
<?php
$cuenta_mayor_auxiliar_view->ShowMessage();
?>
<form name="fcuenta_mayor_auxiliarview" id="fcuenta_mayor_auxiliarview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_mayor_auxiliar_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_mayor_auxiliar_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_mayor_auxiliar">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
	<tr id="r_idcuenta_mayor_auxiliar">
		<td><span id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_auxiliar"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->FldCaption() ?></span></td>
		<td data-name="idcuenta_mayor_auxiliar"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_idcuenta_mayor_auxiliar">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
	<tr id="r_nomenclatura">
		<td><span id="elh_cuenta_mayor_auxiliar_nomenclatura"><?php echo $cuenta_mayor_auxiliar->nomenclatura->FldCaption() ?></span></td>
		<td data-name="nomenclatura"<?php echo $cuenta_mayor_auxiliar->nomenclatura->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_nomenclatura">
<span<?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
	<tr id="r_nombre">
		<td><span id="elh_cuenta_mayor_auxiliar_nombre"><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?></span></td>
		<td data-name="nombre"<?php echo $cuenta_mayor_auxiliar->nombre->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_nombre">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nombre->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<tr id="r_idcuenta_mayor_principal">
		<td><span id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></span></td>
		<td data-name="idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->definicion->Visible) { // definicion ?>
	<tr id="r_definicion">
		<td><span id="elh_cuenta_mayor_auxiliar_definicion"><?php echo $cuenta_mayor_auxiliar->definicion->FldCaption() ?></span></td>
		<td data-name="definicion"<?php echo $cuenta_mayor_auxiliar->definicion->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_definicion">
<span<?php echo $cuenta_mayor_auxiliar->definicion->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->definicion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_cuenta_mayor_auxiliar_estado"><?php echo $cuenta_mayor_auxiliar->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $cuenta_mayor_auxiliar->estado->CellAttributes() ?>>
<span id="el_cuenta_mayor_auxiliar_estado">
<span<?php echo $cuenta_mayor_auxiliar->estado->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("subcuenta", explode(",", $cuenta_mayor_auxiliar->getCurrentDetailTable())) && $subcuenta->DetailView) {
?>
<?php if ($cuenta_mayor_auxiliar->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("subcuenta", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "subcuentagrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fcuenta_mayor_auxiliarview.Init();
</script>
<?php
$cuenta_mayor_auxiliar_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cuenta_mayor_auxiliar_view->Page_Terminate();
?>
