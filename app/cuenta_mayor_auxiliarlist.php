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

$cuenta_mayor_auxiliar_list = NULL; // Initialize page object first

class ccuenta_mayor_auxiliar_list extends ccuenta_mayor_auxiliar {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'cuenta_mayor_auxiliar';

	// Page object name
	var $PageObjName = 'cuenta_mayor_auxiliar_list';

	// Grid form hidden field names
	var $FormName = 'fcuenta_mayor_auxiliarlist';
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

		// Table object (cuenta_mayor_auxiliar)
		if (!isset($GLOBALS["cuenta_mayor_auxiliar"]) || get_class($GLOBALS["cuenta_mayor_auxiliar"]) == "ccuenta_mayor_auxiliar") {
			$GLOBALS["cuenta_mayor_auxiliar"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta_mayor_auxiliar"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "cuenta_mayor_auxiliaradd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "cuenta_mayor_auxiliardelete.php";
		$this->MultiUpdateUrl = "cuenta_mayor_auxiliarupdate.php";

		// Table object (cuenta_mayor_principal)
		if (!isset($GLOBALS['cuenta_mayor_principal'])) $GLOBALS['cuenta_mayor_principal'] = new ccuenta_mayor_principal();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta_mayor_auxiliar', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fcuenta_mayor_auxiliarlistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
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

			// Process auto fill for detail table 'subcuenta'
			if (@$_POST["grid"] == "fsubcuentagrid") {
				if (!isset($GLOBALS["subcuenta_grid"])) $GLOBALS["subcuenta_grid"] = new csubcuenta_grid;
				$GLOBALS["subcuenta_grid"]->Page_Init();
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore filter list
			$this->RestoreFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cuenta_mayor_principal") {
			global $cuenta_mayor_principal;
			$rsmaster = $cuenta_mayor_principal->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cuenta_mayor_principallist.php"); // Return to master page
			} else {
				$cuenta_mayor_principal->LoadListRowValues($rsmaster);
				$cuenta_mayor_principal->RowType = EW_ROWTYPE_MASTER; // Master row
				$cuenta_mayor_principal->RenderListRow();
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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
			$this->idcuenta_mayor_auxiliar->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idcuenta_mayor_auxiliar->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->idcuenta_mayor_auxiliar->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_nomenclatura") && $objForm->HasValue("o_nomenclatura") && $this->nomenclatura->CurrentValue <> $this->nomenclatura->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nombre") && $objForm->HasValue("o_nombre") && $this->nombre->CurrentValue <> $this->nombre->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idcuenta_mayor_principal") && $objForm->HasValue("o_idcuenta_mayor_principal") && $this->idcuenta_mayor_principal->CurrentValue <> $this->idcuenta_mayor_principal->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->idcuenta_mayor_auxiliar->AdvancedSearch->ToJSON(), ","); // Field idcuenta_mayor_auxiliar
		$sFilterList = ew_Concat($sFilterList, $this->nomenclatura->AdvancedSearch->ToJSON(), ","); // Field nomenclatura
		$sFilterList = ew_Concat($sFilterList, $this->nombre->AdvancedSearch->ToJSON(), ","); // Field nombre
		$sFilterList = ew_Concat($sFilterList, $this->idcuenta_mayor_principal->AdvancedSearch->ToJSON(), ","); // Field idcuenta_mayor_principal
		$sFilterList = ew_Concat($sFilterList, $this->definicion->AdvancedSearch->ToJSON(), ","); // Field definicion
		$sFilterList = ew_Concat($sFilterList, $this->estado->AdvancedSearch->ToJSON(), ","); // Field estado
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}

		// Return filter list in json
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field idcuenta_mayor_auxiliar
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->SearchValue = @$filter["x_idcuenta_mayor_auxiliar"];
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->SearchOperator = @$filter["z_idcuenta_mayor_auxiliar"];
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->SearchCondition = @$filter["v_idcuenta_mayor_auxiliar"];
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->SearchValue2 = @$filter["y_idcuenta_mayor_auxiliar"];
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->SearchOperator2 = @$filter["w_idcuenta_mayor_auxiliar"];
		$this->idcuenta_mayor_auxiliar->AdvancedSearch->Save();

		// Field nomenclatura
		$this->nomenclatura->AdvancedSearch->SearchValue = @$filter["x_nomenclatura"];
		$this->nomenclatura->AdvancedSearch->SearchOperator = @$filter["z_nomenclatura"];
		$this->nomenclatura->AdvancedSearch->SearchCondition = @$filter["v_nomenclatura"];
		$this->nomenclatura->AdvancedSearch->SearchValue2 = @$filter["y_nomenclatura"];
		$this->nomenclatura->AdvancedSearch->SearchOperator2 = @$filter["w_nomenclatura"];
		$this->nomenclatura->AdvancedSearch->Save();

		// Field nombre
		$this->nombre->AdvancedSearch->SearchValue = @$filter["x_nombre"];
		$this->nombre->AdvancedSearch->SearchOperator = @$filter["z_nombre"];
		$this->nombre->AdvancedSearch->SearchCondition = @$filter["v_nombre"];
		$this->nombre->AdvancedSearch->SearchValue2 = @$filter["y_nombre"];
		$this->nombre->AdvancedSearch->SearchOperator2 = @$filter["w_nombre"];
		$this->nombre->AdvancedSearch->Save();

		// Field idcuenta_mayor_principal
		$this->idcuenta_mayor_principal->AdvancedSearch->SearchValue = @$filter["x_idcuenta_mayor_principal"];
		$this->idcuenta_mayor_principal->AdvancedSearch->SearchOperator = @$filter["z_idcuenta_mayor_principal"];
		$this->idcuenta_mayor_principal->AdvancedSearch->SearchCondition = @$filter["v_idcuenta_mayor_principal"];
		$this->idcuenta_mayor_principal->AdvancedSearch->SearchValue2 = @$filter["y_idcuenta_mayor_principal"];
		$this->idcuenta_mayor_principal->AdvancedSearch->SearchOperator2 = @$filter["w_idcuenta_mayor_principal"];
		$this->idcuenta_mayor_principal->AdvancedSearch->Save();

		// Field definicion
		$this->definicion->AdvancedSearch->SearchValue = @$filter["x_definicion"];
		$this->definicion->AdvancedSearch->SearchOperator = @$filter["z_definicion"];
		$this->definicion->AdvancedSearch->SearchCondition = @$filter["v_definicion"];
		$this->definicion->AdvancedSearch->SearchValue2 = @$filter["y_definicion"];
		$this->definicion->AdvancedSearch->SearchOperator2 = @$filter["w_definicion"];
		$this->definicion->AdvancedSearch->Save();

		// Field estado
		$this->estado->AdvancedSearch->SearchValue = @$filter["x_estado"];
		$this->estado->AdvancedSearch->SearchOperator = @$filter["z_estado"];
		$this->estado->AdvancedSearch->SearchCondition = @$filter["v_estado"];
		$this->estado->AdvancedSearch->SearchValue2 = @$filter["y_estado"];
		$this->estado->AdvancedSearch->SearchOperator2 = @$filter["w_estado"];
		$this->estado->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nomenclatura, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nombre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->definicion, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->nomenclatura); // nomenclatura
			$this->UpdateSort($this->nombre); // nombre
			$this->UpdateSort($this->idcuenta_mayor_principal); // idcuenta_mayor_principal
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

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->idcuenta_mayor_principal->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->nomenclatura->setSort("");
				$this->nombre->setSort("");
				$this->idcuenta_mayor_principal->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = FALSE;

		// "detail_subcuenta"
		$item = &$this->ListOptions->Add("detail_subcuenta");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["subcuenta_grid"])) $GLOBALS["subcuenta_grid"] = new csubcuenta_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssStyle = "white-space: nowrap;";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("subcuenta");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

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

		// "detail_subcuenta"
		$oListOpt = &$this->ListOptions->Items["detail_subcuenta"];
		if (TRUE) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("subcuenta", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("subcuentalist.php?" . EW_TABLE_SHOW_MASTER . "=cuenta_mayor_auxiliar&fk_idcuenta_mayor_auxiliar=" . urlencode(strval($this->idcuenta_mayor_auxiliar->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["subcuenta_grid"]->DetailView) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=subcuenta")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "subcuenta";
			}
			if ($GLOBALS["subcuenta_grid"]->DetailEdit) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=subcuenta")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "subcuenta";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idcuenta_mayor_auxiliar->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->idcuenta_mayor_auxiliar->CurrentValue . "\">";
		}
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
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "");
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_subcuenta");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=subcuenta");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["subcuenta"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["subcuenta"]->DetailAdd);
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "subcuenta";
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

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "");
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fcuenta_mayor_auxiliarlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fcuenta_mayor_auxiliarlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fcuenta_mayor_auxiliarlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = TRUE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = TRUE;
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fcuenta_mayor_auxiliarlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

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

	// Load default values
	function LoadDefaultValues() {
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idcuenta_mayor_principal->CurrentValue = NULL;
		$this->idcuenta_mayor_principal->OldValue = $this->idcuenta_mayor_principal->CurrentValue;
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomenclatura->FldIsDetailKey) {
			$this->nomenclatura->setFormValue($objForm->GetValue("x_nomenclatura"));
		}
		$this->nomenclatura->setOldValue($objForm->GetValue("o_nomenclatura"));
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		$this->nombre->setOldValue($objForm->GetValue("o_nombre"));
		if (!$this->idcuenta_mayor_principal->FldIsDetailKey) {
			$this->idcuenta_mayor_principal->setFormValue($objForm->GetValue("x_idcuenta_mayor_principal"));
		}
		$this->idcuenta_mayor_principal->setOldValue($objForm->GetValue("o_idcuenta_mayor_principal"));
		if (!$this->idcuenta_mayor_auxiliar->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idcuenta_mayor_auxiliar->setFormValue($objForm->GetValue("x_idcuenta_mayor_auxiliar"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->FormValue;
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idcuenta_mayor_principal->CurrentValue = $this->idcuenta_mayor_principal->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcuenta_mayor_auxiliar")) <> "")
			$this->idcuenta_mayor_auxiliar->CurrentValue = $this->getKey("idcuenta_mayor_auxiliar"); // idcuenta_mayor_auxiliar
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomenclatura
			$this->nomenclatura->EditAttrs["class"] = "form-control";
			$this->nomenclatura->EditCustomAttributes = "";
			$this->nomenclatura->EditValue = ew_HtmlEncode($this->nomenclatura->CurrentValue);
			$this->nomenclatura->PlaceHolder = ew_RemoveHtml($this->nomenclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->EditAttrs["class"] = "form-control";
			$this->idcuenta_mayor_principal->EditCustomAttributes = "";
			if ($this->idcuenta_mayor_principal->getSessionValue() <> "") {
				$this->idcuenta_mayor_principal->CurrentValue = $this->idcuenta_mayor_principal->getSessionValue();
				$this->idcuenta_mayor_principal->OldValue = $this->idcuenta_mayor_principal->CurrentValue;
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
			} else {
			if (trim(strval($this->idcuenta_mayor_principal->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcuenta_mayor_principal`" . ew_SearchString("=", $this->idcuenta_mayor_principal->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cuenta_mayor_principal`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcuenta_mayor_principal->EditValue = $arwrk;
			}

			// Add refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->LinkCustomAttributes = "";
			$this->idcuenta_mayor_principal->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomenclatura
			$this->nomenclatura->EditAttrs["class"] = "form-control";
			$this->nomenclatura->EditCustomAttributes = "";
			$this->nomenclatura->EditValue = ew_HtmlEncode($this->nomenclatura->CurrentValue);
			$this->nomenclatura->PlaceHolder = ew_RemoveHtml($this->nomenclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->EditAttrs["class"] = "form-control";
			$this->idcuenta_mayor_principal->EditCustomAttributes = "";
			if ($this->idcuenta_mayor_principal->getSessionValue() <> "") {
				$this->idcuenta_mayor_principal->CurrentValue = $this->idcuenta_mayor_principal->getSessionValue();
				$this->idcuenta_mayor_principal->OldValue = $this->idcuenta_mayor_principal->CurrentValue;
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
			} else {
			if (trim(strval($this->idcuenta_mayor_principal->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcuenta_mayor_principal`" . ew_SearchString("=", $this->idcuenta_mayor_principal->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cuenta_mayor_principal`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcuenta_mayor_principal->EditValue = $arwrk;
			}

			// Edit refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->LinkCustomAttributes = "";
			$this->idcuenta_mayor_principal->HrefValue = "";
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
		if (!$this->nomenclatura->FldIsDetailKey && !is_null($this->nomenclatura->FormValue) && $this->nomenclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomenclatura->FldCaption(), $this->nomenclatura->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idcuenta_mayor_principal->FldIsDetailKey && !is_null($this->idcuenta_mayor_principal->FormValue) && $this->idcuenta_mayor_principal->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta_mayor_principal->FldCaption(), $this->idcuenta_mayor_principal->ReqErrMsg));
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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['idcuenta_mayor_auxiliar'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nomenclatura
			$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", $this->nomenclatura->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", $this->nombre->ReadOnly);

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->SetDbValueDef($rsnew, $this->idcuenta_mayor_principal->CurrentValue, 0, $this->idcuenta_mayor_principal->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();
		return $EditRow;
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

		// nomenclatura
		$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idcuenta_mayor_principal
		$this->idcuenta_mayor_principal->SetDbValueDef($rsnew, $this->idcuenta_mayor_principal->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idcuenta_mayor_auxiliar->setDbValue($conn->Insert_ID());
				$rsnew['idcuenta_mayor_auxiliar'] = $this->idcuenta_mayor_auxiliar->DbValue;
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
			if ($sMasterTblVar <> "cuenta_mayor_principal") {
				if ($this->idcuenta_mayor_principal->CurrentValue == "") $this->idcuenta_mayor_principal->setSessionValue("");
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
if (!isset($cuenta_mayor_auxiliar_list)) $cuenta_mayor_auxiliar_list = new ccuenta_mayor_auxiliar_list();

// Page init
$cuenta_mayor_auxiliar_list->Page_Init();

// Page main
$cuenta_mayor_auxiliar_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_mayor_auxiliar_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fcuenta_mayor_auxiliarlist = new ew_Form("fcuenta_mayor_auxiliarlist", "list");
fcuenta_mayor_auxiliarlist.FormKeyCountName = '<?php echo $cuenta_mayor_auxiliar_list->FormKeyCountName ?>';

// Validate form
fcuenta_mayor_auxiliarlist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomenclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nomenclatura->FldCaption(), $cuenta_mayor_auxiliar->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->nombre->FldCaption(), $cuenta_mayor_auxiliar->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_principal");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption(), $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fcuenta_mayor_auxiliarlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_principal", false)) return false;
	return true;
}

// Form_CustomValidate event
fcuenta_mayor_auxiliarlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_mayor_auxiliarlist.ValidateRequired = true;
<?php } else { ?>
fcuenta_mayor_auxiliarlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_mayor_auxiliarlist.Lists["x_idcuenta_mayor_principal"] = {"LinkField":"x_idcuenta_mayor_principal","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
var CurrentSearchForm = fcuenta_mayor_auxiliarlistsrch = new ew_Form("fcuenta_mayor_auxiliarlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($cuenta_mayor_auxiliar_list->TotalRecs > 0 && $cuenta_mayor_auxiliar_list->ExportOptions->Visible()) { ?>
<?php $cuenta_mayor_auxiliar_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar_list->SearchOptions->Visible()) { ?>
<?php $cuenta_mayor_auxiliar_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar_list->FilterOptions->Visible()) { ?>
<?php $cuenta_mayor_auxiliar_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($cuenta_mayor_auxiliar->Export == "") || (EW_EXPORT_MASTER_RECORD && $cuenta_mayor_auxiliar->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cuenta_mayor_principallist.php";
if ($cuenta_mayor_auxiliar_list->DbMasterFilter <> "" && $cuenta_mayor_auxiliar->getCurrentMasterTable() == "cuenta_mayor_principal") {
	if ($cuenta_mayor_auxiliar_list->MasterRecordExists) {
		if ($cuenta_mayor_auxiliar->getCurrentMasterTable() == $cuenta_mayor_auxiliar->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "cuenta_mayor_principalmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") {
	$cuenta_mayor_auxiliar->CurrentFilter = "0=1";
	$cuenta_mayor_auxiliar_list->StartRec = 1;
	$cuenta_mayor_auxiliar_list->DisplayRecs = $cuenta_mayor_auxiliar->GridAddRowCount;
	$cuenta_mayor_auxiliar_list->TotalRecs = $cuenta_mayor_auxiliar_list->DisplayRecs;
	$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar_list->DisplayRecs;
} else {
	$bSelectLimit = $cuenta_mayor_auxiliar_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($cuenta_mayor_auxiliar_list->TotalRecs <= 0)
			$cuenta_mayor_auxiliar_list->TotalRecs = $cuenta_mayor_auxiliar->SelectRecordCount();
	} else {
		if (!$cuenta_mayor_auxiliar_list->Recordset && ($cuenta_mayor_auxiliar_list->Recordset = $cuenta_mayor_auxiliar_list->LoadRecordset()))
			$cuenta_mayor_auxiliar_list->TotalRecs = $cuenta_mayor_auxiliar_list->Recordset->RecordCount();
	}
	$cuenta_mayor_auxiliar_list->StartRec = 1;
	if ($cuenta_mayor_auxiliar_list->DisplayRecs <= 0 || ($cuenta_mayor_auxiliar->Export <> "" && $cuenta_mayor_auxiliar->ExportAll)) // Display all records
		$cuenta_mayor_auxiliar_list->DisplayRecs = $cuenta_mayor_auxiliar_list->TotalRecs;
	if (!($cuenta_mayor_auxiliar->Export <> "" && $cuenta_mayor_auxiliar->ExportAll))
		$cuenta_mayor_auxiliar_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$cuenta_mayor_auxiliar_list->Recordset = $cuenta_mayor_auxiliar_list->LoadRecordset($cuenta_mayor_auxiliar_list->StartRec-1, $cuenta_mayor_auxiliar_list->DisplayRecs);

	// Set no record found message
	if ($cuenta_mayor_auxiliar->CurrentAction == "" && $cuenta_mayor_auxiliar_list->TotalRecs == 0) {
		if ($cuenta_mayor_auxiliar_list->SearchWhere == "0=101")
			$cuenta_mayor_auxiliar_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$cuenta_mayor_auxiliar_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$cuenta_mayor_auxiliar_list->RenderOtherOptions();
?>
<?php if ($cuenta_mayor_auxiliar->Export == "" && $cuenta_mayor_auxiliar->CurrentAction == "") { ?>
<form name="fcuenta_mayor_auxiliarlistsrch" id="fcuenta_mayor_auxiliarlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($cuenta_mayor_auxiliar_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fcuenta_mayor_auxiliarlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="cuenta_mayor_auxiliar">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $cuenta_mayor_auxiliar_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($cuenta_mayor_auxiliar_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($cuenta_mayor_auxiliar_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($cuenta_mayor_auxiliar_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($cuenta_mayor_auxiliar_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $cuenta_mayor_auxiliar_list->ShowPageHeader(); ?>
<?php
$cuenta_mayor_auxiliar_list->ShowMessage();
?>
<?php if ($cuenta_mayor_auxiliar_list->TotalRecs > 0 || $cuenta_mayor_auxiliar->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<form name="fcuenta_mayor_auxiliarlist" id="fcuenta_mayor_auxiliarlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_mayor_auxiliar_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_mayor_auxiliar_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_mayor_auxiliar">
<?php if ($cuenta_mayor_auxiliar->getCurrentMasterTable() == "cuenta_mayor_principal" && $cuenta_mayor_auxiliar->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="cuenta_mayor_principal">
<input type="hidden" name="fk_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() ?>">
<?php } ?>
<div id="gmp_cuenta_mayor_auxiliar" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($cuenta_mayor_auxiliar_list->TotalRecs > 0) { ?>
<table id="tbl_cuenta_mayor_auxiliarlist" class="table ewTable">
<?php echo $cuenta_mayor_auxiliar->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$cuenta_mayor_auxiliar_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$cuenta_mayor_auxiliar_list->RenderListOptions();

// Render list options (header, left)
$cuenta_mayor_auxiliar_list->ListOptions->Render("header", "left");
?>
<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nomenclatura) ?>',1);"><div id="elh_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nomenclatura->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->nombre) ?>',1);"><div id="elh_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
	<?php if ($cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->idcuenta_mayor_principal) == "") { ?>
		<th data-name="idcuenta_mayor_principal"><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal"><div class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_principal"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $cuenta_mayor_auxiliar->SortUrl($cuenta_mayor_auxiliar->idcuenta_mayor_principal) ?>',1);"><div id="elh_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$cuenta_mayor_auxiliar_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($cuenta_mayor_auxiliar->ExportAll && $cuenta_mayor_auxiliar->Export <> "") {
	$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar_list->TotalRecs;
} else {

	// Set the last record to display
	if ($cuenta_mayor_auxiliar_list->TotalRecs > $cuenta_mayor_auxiliar_list->StartRec + $cuenta_mayor_auxiliar_list->DisplayRecs - 1)
		$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar_list->StartRec + $cuenta_mayor_auxiliar_list->DisplayRecs - 1;
	else
		$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($cuenta_mayor_auxiliar_list->FormKeyCountName) && ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" || $cuenta_mayor_auxiliar->CurrentAction == "gridedit" || $cuenta_mayor_auxiliar->CurrentAction == "F")) {
		$cuenta_mayor_auxiliar_list->KeyCount = $objForm->GetValue($cuenta_mayor_auxiliar_list->FormKeyCountName);
		$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar_list->StartRec + $cuenta_mayor_auxiliar_list->KeyCount - 1;
	}
}
$cuenta_mayor_auxiliar_list->RecCnt = $cuenta_mayor_auxiliar_list->StartRec - 1;
if ($cuenta_mayor_auxiliar_list->Recordset && !$cuenta_mayor_auxiliar_list->Recordset->EOF) {
	$cuenta_mayor_auxiliar_list->Recordset->MoveFirst();
	$bSelectLimit = $cuenta_mayor_auxiliar_list->UseSelectLimit;
	if (!$bSelectLimit && $cuenta_mayor_auxiliar_list->StartRec > 1)
		$cuenta_mayor_auxiliar_list->Recordset->Move($cuenta_mayor_auxiliar_list->StartRec - 1);
} elseif (!$cuenta_mayor_auxiliar->AllowAddDeleteRow && $cuenta_mayor_auxiliar_list->StopRec == 0) {
	$cuenta_mayor_auxiliar_list->StopRec = $cuenta_mayor_auxiliar->GridAddRowCount;
}

// Initialize aggregate
$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_AGGREGATEINIT;
$cuenta_mayor_auxiliar->ResetAttrs();
$cuenta_mayor_auxiliar_list->RenderRow();
if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd")
	$cuenta_mayor_auxiliar_list->RowIndex = 0;
if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit")
	$cuenta_mayor_auxiliar_list->RowIndex = 0;
while ($cuenta_mayor_auxiliar_list->RecCnt < $cuenta_mayor_auxiliar_list->StopRec) {
	$cuenta_mayor_auxiliar_list->RecCnt++;
	if (intval($cuenta_mayor_auxiliar_list->RecCnt) >= intval($cuenta_mayor_auxiliar_list->StartRec)) {
		$cuenta_mayor_auxiliar_list->RowCnt++;
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" || $cuenta_mayor_auxiliar->CurrentAction == "gridedit" || $cuenta_mayor_auxiliar->CurrentAction == "F") {
			$cuenta_mayor_auxiliar_list->RowIndex++;
			$objForm->Index = $cuenta_mayor_auxiliar_list->RowIndex;
			if ($objForm->HasValue($cuenta_mayor_auxiliar_list->FormActionName))
				$cuenta_mayor_auxiliar_list->RowAction = strval($objForm->GetValue($cuenta_mayor_auxiliar_list->FormActionName));
			elseif ($cuenta_mayor_auxiliar->CurrentAction == "gridadd")
				$cuenta_mayor_auxiliar_list->RowAction = "insert";
			else
				$cuenta_mayor_auxiliar_list->RowAction = "";
		}

		// Set up key count
		$cuenta_mayor_auxiliar_list->KeyCount = $cuenta_mayor_auxiliar_list->RowIndex;

		// Init row class and style
		$cuenta_mayor_auxiliar->ResetAttrs();
		$cuenta_mayor_auxiliar->CssClass = "";
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") {
			$cuenta_mayor_auxiliar_list->LoadDefaultValues(); // Load default values
		} else {
			$cuenta_mayor_auxiliar_list->LoadRowValues($cuenta_mayor_auxiliar_list->Recordset); // Load row values
		}
		$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") // Grid add
			$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD; // Render add
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" && $cuenta_mayor_auxiliar->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$cuenta_mayor_auxiliar_list->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_list->RowIndex); // Restore form values
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit") { // Grid edit
			if ($cuenta_mayor_auxiliar->EventCancelled) {
				$cuenta_mayor_auxiliar_list->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_list->RowIndex); // Restore form values
			}
			if ($cuenta_mayor_auxiliar_list->RowAction == "insert")
				$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit" && ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT || $cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) && $cuenta_mayor_auxiliar->EventCancelled) // Update failed
			$cuenta_mayor_auxiliar_list->RestoreCurrentRowFormValues($cuenta_mayor_auxiliar_list->RowIndex); // Restore form values
		if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) // Edit row
			$cuenta_mayor_auxiliar_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$cuenta_mayor_auxiliar->RowAttrs = array_merge($cuenta_mayor_auxiliar->RowAttrs, array('data-rowindex'=>$cuenta_mayor_auxiliar_list->RowCnt, 'id'=>'r' . $cuenta_mayor_auxiliar_list->RowCnt . '_cuenta_mayor_auxiliar', 'data-rowtype'=>$cuenta_mayor_auxiliar->RowType));

		// Render row
		$cuenta_mayor_auxiliar_list->RenderRow();

		// Render list options
		$cuenta_mayor_auxiliar_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($cuenta_mayor_auxiliar_list->RowAction <> "delete" && $cuenta_mayor_auxiliar_list->RowAction <> "insertdelete" && !($cuenta_mayor_auxiliar_list->RowAction == "insert" && $cuenta_mayor_auxiliar->CurrentAction == "F" && $cuenta_mayor_auxiliar_list->EmptyRow())) {
?>
	<tr<?php echo $cuenta_mayor_auxiliar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_mayor_auxiliar_list->ListOptions->Render("body", "left", $cuenta_mayor_auxiliar_list->RowCnt);
?>
	<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $cuenta_mayor_auxiliar->nomenclatura->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nomenclatura" class="cuenta_mayor_auxiliar_nomenclatura">
<span<?php echo $cuenta_mayor_auxiliar->nomenclatura->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nomenclatura->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $cuenta_mayor_auxiliar_list->PageObjName . "_row_" . $cuenta_mayor_auxiliar_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT || $cuenta_mayor_auxiliar->CurrentMode == "edit") { ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $cuenta_mayor_auxiliar->nombre->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_nombre" class="cuenta_mayor_auxiliar_nombre">
<span<?php echo $cuenta_mayor_auxiliar->nombre->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->nombre->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CellAttributes() ?>>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $cuenta_mayor_auxiliar_list->RowCnt ?>_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_mayor_auxiliar_list->ListOptions->Render("body", "right", $cuenta_mayor_auxiliar_list->RowCnt);
?>
	</tr>
<?php if ($cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_ADD || $cuenta_mayor_auxiliar->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fcuenta_mayor_auxiliarlist.UpdateOpts(<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($cuenta_mayor_auxiliar->CurrentAction <> "gridadd")
		if (!$cuenta_mayor_auxiliar_list->Recordset->EOF) $cuenta_mayor_auxiliar_list->Recordset->MoveNext();
}
?>
<?php
	if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd" || $cuenta_mayor_auxiliar->CurrentAction == "gridedit") {
		$cuenta_mayor_auxiliar_list->RowIndex = '$rowindex$';
		$cuenta_mayor_auxiliar_list->LoadDefaultValues();

		// Set row properties
		$cuenta_mayor_auxiliar->ResetAttrs();
		$cuenta_mayor_auxiliar->RowAttrs = array_merge($cuenta_mayor_auxiliar->RowAttrs, array('data-rowindex'=>$cuenta_mayor_auxiliar_list->RowIndex, 'id'=>'r0_cuenta_mayor_auxiliar', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($cuenta_mayor_auxiliar->RowAttrs["class"], "ewTemplate");
		$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_ADD;

		// Render row
		$cuenta_mayor_auxiliar_list->RenderRow();

		// Render list options
		$cuenta_mayor_auxiliar_list->RenderListOptions();
		$cuenta_mayor_auxiliar_list->StartRowCnt = 0;
?>
	<tr<?php echo $cuenta_mayor_auxiliar->RowAttributes() ?>>
<?php

// Render list options (body, left)
$cuenta_mayor_auxiliar_list->ListOptions->Render("body", "left", $cuenta_mayor_auxiliar_list->RowIndex);
?>
	<?php if ($cuenta_mayor_auxiliar->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<span id="el$rowindex$_cuenta_mayor_auxiliar_nomenclatura" class="form-group cuenta_mayor_auxiliar_nomenclatura">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nomenclatura" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<span id="el$rowindex$_cuenta_mayor_auxiliar_nombre" class="form-group cuenta_mayor_auxiliar_nombre">
<input type="text" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_auxiliar->nombre->EditValue ?>"<?php echo $cuenta_mayor_auxiliar->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_nombre" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->Visible) { // idcuenta_mayor_principal ?>
		<td data-name="idcuenta_mayor_principal">
<?php if ($cuenta_mayor_auxiliar->idcuenta_mayor_principal->getSessionValue() <> "") { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<span<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_cuenta_mayor_auxiliar_idcuenta_mayor_principal" class="form-group cuenta_mayor_auxiliar_idcuenta_mayor_principal">
<select data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ? json_encode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) : $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValueSeparator) ?>" id="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" name="x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal"<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue)) {
	$arwrk = $cuenta_mayor_auxiliar->idcuenta_mayor_principal->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue) ?>" selected><?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta_mayor_principal`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta_mayor_principal`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters += array("f0" => "`idcuenta_mayor_principal` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_auxiliar->Lookup_Selecting($cuenta_mayor_auxiliar->idcuenta_mayor_principal, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" id="s_x<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo $cuenta_mayor_auxiliar->idcuenta_mayor_principal->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="cuenta_mayor_auxiliar" data-field="x_idcuenta_mayor_principal" name="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" id="o<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>_idcuenta_mayor_principal" value="<?php echo ew_HtmlEncode($cuenta_mayor_auxiliar->idcuenta_mayor_principal->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$cuenta_mayor_auxiliar_list->ListOptions->Render("body", "right", $cuenta_mayor_auxiliar_list->RowCnt);
?>
<script type="text/javascript">
fcuenta_mayor_auxiliarlist.UpdateOpts(<?php echo $cuenta_mayor_auxiliar_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $cuenta_mayor_auxiliar_list->FormKeyCountName ?>" id="<?php echo $cuenta_mayor_auxiliar_list->FormKeyCountName ?>" value="<?php echo $cuenta_mayor_auxiliar_list->KeyCount ?>">
<?php echo $cuenta_mayor_auxiliar_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $cuenta_mayor_auxiliar_list->FormKeyCountName ?>" id="<?php echo $cuenta_mayor_auxiliar_list->FormKeyCountName ?>" value="<?php echo $cuenta_mayor_auxiliar_list->KeyCount ?>">
<?php echo $cuenta_mayor_auxiliar_list->MultiSelectKey ?>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($cuenta_mayor_auxiliar_list->Recordset)
	$cuenta_mayor_auxiliar_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($cuenta_mayor_auxiliar->CurrentAction <> "gridadd" && $cuenta_mayor_auxiliar->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($cuenta_mayor_auxiliar_list->Pager)) $cuenta_mayor_auxiliar_list->Pager = new cPrevNextPager($cuenta_mayor_auxiliar_list->StartRec, $cuenta_mayor_auxiliar_list->DisplayRecs, $cuenta_mayor_auxiliar_list->TotalRecs) ?>
<?php if ($cuenta_mayor_auxiliar_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($cuenta_mayor_auxiliar_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $cuenta_mayor_auxiliar_list->PageUrl() ?>start=<?php echo $cuenta_mayor_auxiliar_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($cuenta_mayor_auxiliar_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $cuenta_mayor_auxiliar_list->PageUrl() ?>start=<?php echo $cuenta_mayor_auxiliar_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $cuenta_mayor_auxiliar_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($cuenta_mayor_auxiliar_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $cuenta_mayor_auxiliar_list->PageUrl() ?>start=<?php echo $cuenta_mayor_auxiliar_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($cuenta_mayor_auxiliar_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $cuenta_mayor_auxiliar_list->PageUrl() ?>start=<?php echo $cuenta_mayor_auxiliar_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $cuenta_mayor_auxiliar_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $cuenta_mayor_auxiliar_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $cuenta_mayor_auxiliar_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $cuenta_mayor_auxiliar_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_mayor_auxiliar_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($cuenta_mayor_auxiliar_list->TotalRecs == 0 && $cuenta_mayor_auxiliar->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($cuenta_mayor_auxiliar_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fcuenta_mayor_auxiliarlistsrch.Init();
fcuenta_mayor_auxiliarlistsrch.FilterList = <?php echo $cuenta_mayor_auxiliar_list->GetFilterList() ?>;
fcuenta_mayor_auxiliarlist.Init();
</script>
<?php
$cuenta_mayor_auxiliar_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cuenta_mayor_auxiliar_list->Page_Terminate();
?>
