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

$balance_general_list = NULL; // Initialize page object first

class cbalance_general_list extends cbalance_general {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'balance_general';

	// Page object name
	var $PageObjName = 'balance_general_list';

	// Grid form hidden field names
	var $FormName = 'fbalance_generallist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "balance_generaladd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "balance_generaldelete.php";
		$this->MultiUpdateUrl = "balance_generalupdate.php";

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'balance_general', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fbalance_generallistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

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

			// Process auto fill for detail table 'balance_general_detalle'
			if (@$_POST["grid"] == "fbalance_general_detallegrid") {
				if (!isset($GLOBALS["balance_general_detalle_grid"])) $GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid;
				$GLOBALS["balance_general_detalle_grid"]->Page_Init();
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

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "empresa") {
			global $empresa;
			$rsmaster = $empresa->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("empresalist.php"); // Return to master page
			} else {
				$empresa->LoadListRowValues($rsmaster);
				$empresa->RowType = EW_ROWTYPE_MASTER; // Master row
				$empresa->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "periodo_contable") {
			global $periodo_contable;
			$rsmaster = $periodo_contable->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("periodo_contablelist.php"); // Return to master page
			} else {
				$periodo_contable->LoadListRowValues($rsmaster);
				$periodo_contable->RowType = EW_ROWTYPE_MASTER; // Master row
				$periodo_contable->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->idbalance_general->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idbalance_general->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->idempresa); // idempresa
			$this->UpdateSort($this->idperioso_contable); // idperioso_contable
			$this->UpdateSort($this->activo_circulante); // activo_circulante
			$this->UpdateSort($this->activo_fijo); // activo_fijo
			$this->UpdateSort($this->pasivo_circulante); // pasivo_circulante
			$this->UpdateSort($this->pasivo_fijo); // pasivo_fijo
			$this->UpdateSort($this->capital_contable); // capital_contable
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idempresa->setSessionValue("");
				$this->idperioso_contable->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->idempresa->setSort("");
				$this->idperioso_contable->setSort("");
				$this->activo_circulante->setSort("");
				$this->activo_fijo->setSort("");
				$this->pasivo_circulante->setSort("");
				$this->pasivo_fijo->setSort("");
				$this->capital_contable->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "detail_balance_general_detalle"
		$item = &$this->ListOptions->Add("detail_balance_general_detalle");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["balance_general_detalle_grid"])) $GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = TRUE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("balance_general_detalle");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = TRUE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		if (TRUE)
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewLink")) . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		else
			$oListOpt->Body = "";

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_balance_general_detalle"
		$oListOpt = &$this->ListOptions->Items["detail_balance_general_detalle"];
		if (TRUE) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("balance_general_detalle", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("balance_general_detallelist.php?" . EW_TABLE_SHOW_MASTER . "=balance_general&fk_idbalance_general=" . urlencode(strval($this->idbalance_general->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["balance_general_detalle_grid"]->DetailView) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=balance_general_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "balance_general_detalle";
			}
			if ($GLOBALS["balance_general_detalle_grid"]->DetailEdit) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=balance_general_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "balance_general_detalle";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
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
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idbalance_general->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddLink")) . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "");
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_balance_general_detalle");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=balance_general_detalle");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["balance_general_detalle"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["balance_general_detalle"]->DetailAdd);
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "balance_general_detalle";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddMasterDetailLink")) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $Language->Phrase("AddMasterDetailLink") . "</a>";
			$item->Visible = ($DetailTableLink <> "");

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fbalance_generallistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fbalance_generallistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = FALSE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fbalance_generallist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idbalance_general")) <> "")
			$this->idbalance_general->CurrentValue = $this->getKey("idbalance_general"); // idbalance_general
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
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
if (!isset($balance_general_list)) $balance_general_list = new cbalance_general_list();

// Page init
$balance_general_list->Page_Init();

// Page main
$balance_general_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fbalance_generallist = new ew_Form("fbalance_generallist", "list");
fbalance_generallist.FormKeyCountName = '<?php echo $balance_general_list->FormKeyCountName ?>';

// Form_CustomValidate event
fbalance_generallist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_generallist.ValidateRequired = true;
<?php } else { ?>
fbalance_generallist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_generallist.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_ticker","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generallist.Lists["x_idperioso_contable"] = {"LinkField":"x_idperiodo_contable","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($balance_general_list->TotalRecs > 0 && $balance_general_list->ExportOptions->Visible()) { ?>
<?php $balance_general_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($balance_general->Export == "") || (EW_EXPORT_MASTER_RECORD && $balance_general->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "empresalist.php";
if ($balance_general_list->DbMasterFilter <> "" && $balance_general->getCurrentMasterTable() == "empresa") {
	if ($balance_general_list->MasterRecordExists) {
		if ($balance_general->getCurrentMasterTable() == $balance_general->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "empresamaster.php" ?>
<?php
	}
}
?>
<?php
$gsMasterReturnUrl = "periodo_contablelist.php";
if ($balance_general_list->DbMasterFilter <> "" && $balance_general->getCurrentMasterTable() == "periodo_contable") {
	if ($balance_general_list->MasterRecordExists) {
		if ($balance_general->getCurrentMasterTable() == $balance_general->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "periodo_contablemaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $balance_general_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($balance_general_list->TotalRecs <= 0)
			$balance_general_list->TotalRecs = $balance_general->SelectRecordCount();
	} else {
		if (!$balance_general_list->Recordset && ($balance_general_list->Recordset = $balance_general_list->LoadRecordset()))
			$balance_general_list->TotalRecs = $balance_general_list->Recordset->RecordCount();
	}
	$balance_general_list->StartRec = 1;
	if ($balance_general_list->DisplayRecs <= 0 || ($balance_general->Export <> "" && $balance_general->ExportAll)) // Display all records
		$balance_general_list->DisplayRecs = $balance_general_list->TotalRecs;
	if (!($balance_general->Export <> "" && $balance_general->ExportAll))
		$balance_general_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$balance_general_list->Recordset = $balance_general_list->LoadRecordset($balance_general_list->StartRec-1, $balance_general_list->DisplayRecs);

	// Set no record found message
	if ($balance_general->CurrentAction == "" && $balance_general_list->TotalRecs == 0) {
		if ($balance_general_list->SearchWhere == "0=101")
			$balance_general_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$balance_general_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$balance_general_list->RenderOtherOptions();
?>
<?php $balance_general_list->ShowPageHeader(); ?>
<?php
$balance_general_list->ShowMessage();
?>
<?php if ($balance_general_list->TotalRecs > 0 || $balance_general->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div class="panel-heading ewGridUpperPanel">
<?php if ($balance_general->CurrentAction <> "gridadd" && $balance_general->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($balance_general_list->Pager)) $balance_general_list->Pager = new cPrevNextPager($balance_general_list->StartRec, $balance_general_list->DisplayRecs, $balance_general_list->TotalRecs) ?>
<?php if ($balance_general_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($balance_general_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($balance_general_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $balance_general_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($balance_general_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($balance_general_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $balance_general_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $balance_general_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $balance_general_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $balance_general_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fbalance_generallist" id="fbalance_generallist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($balance_general_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $balance_general_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="balance_general">
<?php if ($balance_general->getCurrentMasterTable() == "empresa" && $balance_general->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="empresa">
<input type="hidden" name="fk_idempresa" value="<?php echo $balance_general->idempresa->getSessionValue() ?>">
<?php } ?>
<?php if ($balance_general->getCurrentMasterTable() == "periodo_contable" && $balance_general->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="periodo_contable">
<input type="hidden" name="fk_idperiodo_contable" value="<?php echo $balance_general->idperioso_contable->getSessionValue() ?>">
<?php } ?>
<div id="gmp_balance_general" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($balance_general_list->TotalRecs > 0) { ?>
<table id="tbl_balance_generallist" class="table ewTable">
<?php echo $balance_general->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$balance_general_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$balance_general_list->RenderListOptions();

// Render list options (header, left)
$balance_general_list->ListOptions->Render("header", "left");
?>
<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
	<?php if ($balance_general->SortUrl($balance_general->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_balance_general_idempresa" class="balance_general_idempresa"><div class="ewTableHeaderCaption"><?php echo $balance_general->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->idempresa) ?>',1);"><div id="elh_balance_general_idempresa" class="balance_general_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->idperioso_contable->Visible) { // idperioso_contable ?>
	<?php if ($balance_general->SortUrl($balance_general->idperioso_contable) == "") { ?>
		<th data-name="idperioso_contable"><div id="elh_balance_general_idperioso_contable" class="balance_general_idperioso_contable"><div class="ewTableHeaderCaption"><?php echo $balance_general->idperioso_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperioso_contable"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->idperioso_contable) ?>',1);"><div id="elh_balance_general_idperioso_contable" class="balance_general_idperioso_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->idperioso_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->idperioso_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->idperioso_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
	<?php if ($balance_general->SortUrl($balance_general->activo_circulante) == "") { ?>
		<th data-name="activo_circulante"><div id="elh_balance_general_activo_circulante" class="balance_general_activo_circulante"><div class="ewTableHeaderCaption"><?php echo $balance_general->activo_circulante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activo_circulante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->activo_circulante) ?>',1);"><div id="elh_balance_general_activo_circulante" class="balance_general_activo_circulante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->activo_circulante->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->activo_circulante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->activo_circulante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
	<?php if ($balance_general->SortUrl($balance_general->activo_fijo) == "") { ?>
		<th data-name="activo_fijo"><div id="elh_balance_general_activo_fijo" class="balance_general_activo_fijo"><div class="ewTableHeaderCaption"><?php echo $balance_general->activo_fijo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="activo_fijo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->activo_fijo) ?>',1);"><div id="elh_balance_general_activo_fijo" class="balance_general_activo_fijo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->activo_fijo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->activo_fijo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->activo_fijo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
	<?php if ($balance_general->SortUrl($balance_general->pasivo_circulante) == "") { ?>
		<th data-name="pasivo_circulante"><div id="elh_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante"><div class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_circulante->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasivo_circulante"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->pasivo_circulante) ?>',1);"><div id="elh_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_circulante->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->pasivo_circulante->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->pasivo_circulante->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
	<?php if ($balance_general->SortUrl($balance_general->pasivo_fijo) == "") { ?>
		<th data-name="pasivo_fijo"><div id="elh_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo"><div class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_fijo->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="pasivo_fijo"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->pasivo_fijo) ?>',1);"><div id="elh_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->pasivo_fijo->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->pasivo_fijo->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->pasivo_fijo->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
	<?php if ($balance_general->SortUrl($balance_general->capital_contable) == "") { ?>
		<th data-name="capital_contable"><div id="elh_balance_general_capital_contable" class="balance_general_capital_contable"><div class="ewTableHeaderCaption"><?php echo $balance_general->capital_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="capital_contable"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general->SortUrl($balance_general->capital_contable) ?>',1);"><div id="elh_balance_general_capital_contable" class="balance_general_capital_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general->capital_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general->capital_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general->capital_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$balance_general_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($balance_general->ExportAll && $balance_general->Export <> "") {
	$balance_general_list->StopRec = $balance_general_list->TotalRecs;
} else {

	// Set the last record to display
	if ($balance_general_list->TotalRecs > $balance_general_list->StartRec + $balance_general_list->DisplayRecs - 1)
		$balance_general_list->StopRec = $balance_general_list->StartRec + $balance_general_list->DisplayRecs - 1;
	else
		$balance_general_list->StopRec = $balance_general_list->TotalRecs;
}
$balance_general_list->RecCnt = $balance_general_list->StartRec - 1;
if ($balance_general_list->Recordset && !$balance_general_list->Recordset->EOF) {
	$balance_general_list->Recordset->MoveFirst();
	$bSelectLimit = $balance_general_list->UseSelectLimit;
	if (!$bSelectLimit && $balance_general_list->StartRec > 1)
		$balance_general_list->Recordset->Move($balance_general_list->StartRec - 1);
} elseif (!$balance_general->AllowAddDeleteRow && $balance_general_list->StopRec == 0) {
	$balance_general_list->StopRec = $balance_general->GridAddRowCount;
}

// Initialize aggregate
$balance_general->RowType = EW_ROWTYPE_AGGREGATEINIT;
$balance_general->ResetAttrs();
$balance_general_list->RenderRow();
while ($balance_general_list->RecCnt < $balance_general_list->StopRec) {
	$balance_general_list->RecCnt++;
	if (intval($balance_general_list->RecCnt) >= intval($balance_general_list->StartRec)) {
		$balance_general_list->RowCnt++;

		// Set up key count
		$balance_general_list->KeyCount = $balance_general_list->RowIndex;

		// Init row class and style
		$balance_general->ResetAttrs();
		$balance_general->CssClass = "";
		if ($balance_general->CurrentAction == "gridadd") {
		} else {
			$balance_general_list->LoadRowValues($balance_general_list->Recordset); // Load row values
		}
		$balance_general->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$balance_general->RowAttrs = array_merge($balance_general->RowAttrs, array('data-rowindex'=>$balance_general_list->RowCnt, 'id'=>'r' . $balance_general_list->RowCnt . '_balance_general', 'data-rowtype'=>$balance_general->RowType));

		// Render row
		$balance_general_list->RenderRow();

		// Render list options
		$balance_general_list->RenderListOptions();
?>
	<tr<?php echo $balance_general->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_list->ListOptions->Render("body", "left", $balance_general_list->RowCnt);
?>
	<?php if ($balance_general->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $balance_general->idempresa->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_idempresa" class="balance_general_idempresa">
<span<?php echo $balance_general->idempresa->ViewAttributes() ?>>
<?php echo $balance_general->idempresa->ListViewValue() ?></span>
</span>
<a id="<?php echo $balance_general_list->PageObjName . "_row_" . $balance_general_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($balance_general->idperioso_contable->Visible) { // idperioso_contable ?>
		<td data-name="idperioso_contable"<?php echo $balance_general->idperioso_contable->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_idperioso_contable" class="balance_general_idperioso_contable">
<span<?php echo $balance_general->idperioso_contable->ViewAttributes() ?>>
<?php echo $balance_general->idperioso_contable->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
		<td data-name="activo_circulante"<?php echo $balance_general->activo_circulante->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_activo_circulante" class="balance_general_activo_circulante">
<span<?php echo $balance_general->activo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->activo_circulante->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
		<td data-name="activo_fijo"<?php echo $balance_general->activo_fijo->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_activo_fijo" class="balance_general_activo_fijo">
<span<?php echo $balance_general->activo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->activo_fijo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
		<td data-name="pasivo_circulante"<?php echo $balance_general->pasivo_circulante->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_pasivo_circulante" class="balance_general_pasivo_circulante">
<span<?php echo $balance_general->pasivo_circulante->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_circulante->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
		<td data-name="pasivo_fijo"<?php echo $balance_general->pasivo_fijo->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_pasivo_fijo" class="balance_general_pasivo_fijo">
<span<?php echo $balance_general->pasivo_fijo->ViewAttributes() ?>>
<?php echo $balance_general->pasivo_fijo->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
		<td data-name="capital_contable"<?php echo $balance_general->capital_contable->CellAttributes() ?>>
<span id="el<?php echo $balance_general_list->RowCnt ?>_balance_general_capital_contable" class="balance_general_capital_contable">
<span<?php echo $balance_general->capital_contable->ViewAttributes() ?>>
<?php echo $balance_general->capital_contable->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_list->ListOptions->Render("body", "right", $balance_general_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($balance_general->CurrentAction <> "gridadd")
		$balance_general_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($balance_general->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($balance_general_list->Recordset)
	$balance_general_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($balance_general->CurrentAction <> "gridadd" && $balance_general->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($balance_general_list->Pager)) $balance_general_list->Pager = new cPrevNextPager($balance_general_list->StartRec, $balance_general_list->DisplayRecs, $balance_general_list->TotalRecs) ?>
<?php if ($balance_general_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($balance_general_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($balance_general_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $balance_general_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($balance_general_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($balance_general_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $balance_general_list->PageUrl() ?>start=<?php echo $balance_general_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $balance_general_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $balance_general_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $balance_general_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $balance_general_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($balance_general_list->TotalRecs == 0 && $balance_general->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fbalance_generallist.Init();
</script>
<?php
$balance_general_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$balance_general_list->Page_Terminate();
?>
