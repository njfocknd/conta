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

$balance_general_detalle_list = NULL; // Initialize page object first

class cbalance_general_detalle_list extends cbalance_general_detalle {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'balance_general_detalle';

	// Page object name
	var $PageObjName = 'balance_general_detalle_list';

	// Grid form hidden field names
	var $FormName = 'fbalance_general_detallelist';
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

		// Table object (balance_general_detalle)
		if (!isset($GLOBALS["balance_general_detalle"]) || get_class($GLOBALS["balance_general_detalle"]) == "cbalance_general_detalle") {
			$GLOBALS["balance_general_detalle"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["balance_general_detalle"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "balance_general_detalleadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "balance_general_detalledelete.php";
		$this->MultiUpdateUrl = "balance_general_detalleupdate.php";

		// Table object (balance_general)
		if (!isset($GLOBALS['balance_general'])) $GLOBALS['balance_general'] = new cbalance_general();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'balance_general_detalle', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fbalance_general_detallelistsrch";

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "balance_general") {
			global $balance_general;
			$rsmaster = $balance_general->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("balance_generallist.php"); // Return to master page
			} else {
				$balance_general->LoadListRowValues($rsmaster);
				$balance_general->RowType = EW_ROWTYPE_MASTER; // Master row
				$balance_general->RenderListRow();
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
		$this->monto->FormValue = ""; // Clear form value
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
			$this->idbalance_general_detalle->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idbalance_general_detalle->FormValue))
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
					$sKey .= $this->idbalance_general_detalle->CurrentValue;

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
		if ($objForm->HasValue("x_idclase_cuenta") && $objForm->HasValue("o_idclase_cuenta") && $this->idclase_cuenta->CurrentValue <> $this->idclase_cuenta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idgrupo_cuenta") && $objForm->HasValue("o_idgrupo_cuenta") && $this->idgrupo_cuenta->CurrentValue <> $this->idgrupo_cuenta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idsubgrupo_cuenta") && $objForm->HasValue("o_idsubgrupo_cuenta") && $this->idsubgrupo_cuenta->CurrentValue <> $this->idsubgrupo_cuenta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_monto") && $objForm->HasValue("o_monto") && $this->monto->CurrentValue <> $this->monto->OldValue)
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

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->idclase_cuenta); // idclase_cuenta
			$this->UpdateSort($this->idgrupo_cuenta); // idgrupo_cuenta
			$this->UpdateSort($this->idsubgrupo_cuenta); // idsubgrupo_cuenta
			$this->UpdateSort($this->monto); // monto
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
				$this->idbalance_general->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->idclase_cuenta->setSort("");
				$this->idgrupo_cuenta->setSort("");
				$this->idsubgrupo_cuenta->setSort("");
				$this->monto->setSort("");
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
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idbalance_general_detalle->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->idbalance_general_detalle->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fbalance_general_detallelistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fbalance_general_detallelistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fbalance_general_detallelist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->idclase_cuenta->CurrentValue = 1;
		$this->idclase_cuenta->OldValue = $this->idclase_cuenta->CurrentValue;
		$this->idgrupo_cuenta->CurrentValue = 1;
		$this->idgrupo_cuenta->OldValue = $this->idgrupo_cuenta->CurrentValue;
		$this->idsubgrupo_cuenta->CurrentValue = 6;
		$this->idsubgrupo_cuenta->OldValue = $this->idsubgrupo_cuenta->CurrentValue;
		$this->monto->CurrentValue = 0.00;
		$this->monto->OldValue = $this->monto->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idclase_cuenta->FldIsDetailKey) {
			$this->idclase_cuenta->setFormValue($objForm->GetValue("x_idclase_cuenta"));
		}
		$this->idclase_cuenta->setOldValue($objForm->GetValue("o_idclase_cuenta"));
		if (!$this->idgrupo_cuenta->FldIsDetailKey) {
			$this->idgrupo_cuenta->setFormValue($objForm->GetValue("x_idgrupo_cuenta"));
		}
		$this->idgrupo_cuenta->setOldValue($objForm->GetValue("o_idgrupo_cuenta"));
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey) {
			$this->idsubgrupo_cuenta->setFormValue($objForm->GetValue("x_idsubgrupo_cuenta"));
		}
		$this->idsubgrupo_cuenta->setOldValue($objForm->GetValue("o_idsubgrupo_cuenta"));
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		$this->monto->setOldValue($objForm->GetValue("o_monto"));
		if (!$this->idbalance_general_detalle->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idbalance_general_detalle->setFormValue($objForm->GetValue("x_idbalance_general_detalle"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idbalance_general_detalle->CurrentValue = $this->idbalance_general_detalle->FormValue;
		$this->idclase_cuenta->CurrentValue = $this->idclase_cuenta->FormValue;
		$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->FormValue;
		$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
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
		$this->idbalance_general_detalle->setDbValue($rs->fields('idbalance_general_detalle'));
		$this->idbalance_general->setDbValue($rs->fields('idbalance_general'));
		$this->idclase_cuenta->setDbValue($rs->fields('idclase_cuenta'));
		$this->idgrupo_cuenta->setDbValue($rs->fields('idgrupo_cuenta'));
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
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
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idbalance_general_detalle")) <> "")
			$this->idbalance_general_detalle->CurrentValue = $this->getKey("idbalance_general_detalle"); // idbalance_general_detalle
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

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idclase_cuenta
			$this->idclase_cuenta->EditAttrs["class"] = "form-control";
			$this->idclase_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idclase_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clase_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idclase_cuenta->EditValue = $arwrk;

			// idgrupo_cuenta
			$this->idgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idgrupo_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idclase_cuenta` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_cuenta->EditValue = $arwrk;

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idsubgrupo_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idsubgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idgrupo_cuenta` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsubgrupo_cuenta->EditValue = $arwrk;

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) {
			$this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -1, -1);
			$this->monto->OldValue = $this->monto->EditValue;
			}

			// Add refer script
			// idclase_cuenta

			$this->idclase_cuenta->LinkCustomAttributes = "";
			$this->idclase_cuenta->HrefValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idclase_cuenta
			$this->idclase_cuenta->EditAttrs["class"] = "form-control";
			$this->idclase_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idclase_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clase_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idclase_cuenta->EditValue = $arwrk;

			// idgrupo_cuenta
			$this->idgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idgrupo_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idclase_cuenta` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_cuenta->EditValue = $arwrk;

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idsubgrupo_cuenta->EditCustomAttributes = "";
			if (trim(strval($this->idsubgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idgrupo_cuenta` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nomenclatura`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsubgrupo_cuenta->EditValue = $arwrk;

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) {
			$this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -1, -1);
			$this->monto->OldValue = $this->monto->EditValue;
			}

			// Edit refer script
			// idclase_cuenta

			$this->idclase_cuenta->LinkCustomAttributes = "";
			$this->idclase_cuenta->HrefValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
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
		if (!$this->idclase_cuenta->FldIsDetailKey && !is_null($this->idclase_cuenta->FormValue) && $this->idclase_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idclase_cuenta->FldCaption(), $this->idclase_cuenta->ReqErrMsg));
		}
		if (!$this->idgrupo_cuenta->FldIsDetailKey && !is_null($this->idgrupo_cuenta->FormValue) && $this->idgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idgrupo_cuenta->FldCaption(), $this->idgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey && !is_null($this->idsubgrupo_cuenta->FormValue) && $this->idsubgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsubgrupo_cuenta->FldCaption(), $this->idsubgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
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
				$sThisKey .= $row['idbalance_general_detalle'];
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

			// idclase_cuenta
			$this->idclase_cuenta->SetDbValueDef($rsnew, $this->idclase_cuenta->CurrentValue, 0, $this->idclase_cuenta->ReadOnly);

			// idgrupo_cuenta
			$this->idgrupo_cuenta->SetDbValueDef($rsnew, $this->idgrupo_cuenta->CurrentValue, 0, $this->idgrupo_cuenta->ReadOnly);

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->SetDbValueDef($rsnew, $this->idsubgrupo_cuenta->CurrentValue, 0, $this->idsubgrupo_cuenta->ReadOnly);

			// monto
			$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, $this->monto->ReadOnly);

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

		// idclase_cuenta
		$this->idclase_cuenta->SetDbValueDef($rsnew, $this->idclase_cuenta->CurrentValue, 0, strval($this->idclase_cuenta->CurrentValue) == "");

		// idgrupo_cuenta
		$this->idgrupo_cuenta->SetDbValueDef($rsnew, $this->idgrupo_cuenta->CurrentValue, 0, strval($this->idgrupo_cuenta->CurrentValue) == "");

		// idsubgrupo_cuenta
		$this->idsubgrupo_cuenta->SetDbValueDef($rsnew, $this->idsubgrupo_cuenta->CurrentValue, 0, strval($this->idsubgrupo_cuenta->CurrentValue) == "");

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// idbalance_general
		if ($this->idbalance_general->getSessionValue() <> "") {
			$rsnew['idbalance_general'] = $this->idbalance_general->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idbalance_general_detalle->setDbValue($conn->Insert_ID());
				$rsnew['idbalance_general_detalle'] = $this->idbalance_general_detalle->DbValue;
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
if (!isset($balance_general_detalle_list)) $balance_general_detalle_list = new cbalance_general_detalle_list();

// Page init
$balance_general_detalle_list->Page_Init();

// Page main
$balance_general_detalle_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_detalle_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fbalance_general_detallelist = new ew_Form("fbalance_general_detallelist", "list");
fbalance_general_detallelist.FormKeyCountName = '<?php echo $balance_general_detalle_list->FormKeyCountName ?>';

// Validate form
fbalance_general_detallelist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idclase_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idclase_cuenta->FldCaption(), $balance_general_detalle->idclase_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idgrupo_cuenta->FldCaption(), $balance_general_detalle->idgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsubgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->idsubgrupo_cuenta->FldCaption(), $balance_general_detalle->idsubgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general_detalle->monto->FldCaption(), $balance_general_detalle->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general_detalle->monto->FldErrMsg()) ?>");

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
fbalance_general_detallelist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "idclase_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idsubgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "monto", false)) return false;
	return true;
}

// Form_CustomValidate event
fbalance_general_detallelist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_general_detallelist.ValidateRequired = true;
<?php } else { ?>
fbalance_general_detallelist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_general_detallelist.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_cuenta"],"FilterFields":[],"Options":[],"Template":""};
fbalance_general_detallelist.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idclase_cuenta"],"ChildFields":["x_idsubgrupo_cuenta"],"FilterFields":["x_idclase_cuenta"],"Options":[],"Template":""};
fbalance_general_detallelist.Lists["x_idsubgrupo_cuenta"] = {"LinkField":"x_idsubgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idgrupo_cuenta"],"ChildFields":[],"FilterFields":["x_idgrupo_cuenta"],"Options":[],"Template":""};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($balance_general_detalle_list->TotalRecs > 0 && $balance_general_detalle_list->ExportOptions->Visible()) { ?>
<?php $balance_general_detalle_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($balance_general_detalle->Export == "") || (EW_EXPORT_MASTER_RECORD && $balance_general_detalle->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "balance_generallist.php";
if ($balance_general_detalle_list->DbMasterFilter <> "" && $balance_general_detalle->getCurrentMasterTable() == "balance_general") {
	if ($balance_general_detalle_list->MasterRecordExists) {
		if ($balance_general_detalle->getCurrentMasterTable() == $balance_general_detalle->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "balance_generalmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($balance_general_detalle->CurrentAction == "gridadd") {
	$balance_general_detalle->CurrentFilter = "0=1";
	$balance_general_detalle_list->StartRec = 1;
	$balance_general_detalle_list->DisplayRecs = $balance_general_detalle->GridAddRowCount;
	$balance_general_detalle_list->TotalRecs = $balance_general_detalle_list->DisplayRecs;
	$balance_general_detalle_list->StopRec = $balance_general_detalle_list->DisplayRecs;
} else {
	$bSelectLimit = $balance_general_detalle_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($balance_general_detalle_list->TotalRecs <= 0)
			$balance_general_detalle_list->TotalRecs = $balance_general_detalle->SelectRecordCount();
	} else {
		if (!$balance_general_detalle_list->Recordset && ($balance_general_detalle_list->Recordset = $balance_general_detalle_list->LoadRecordset()))
			$balance_general_detalle_list->TotalRecs = $balance_general_detalle_list->Recordset->RecordCount();
	}
	$balance_general_detalle_list->StartRec = 1;
	if ($balance_general_detalle_list->DisplayRecs <= 0 || ($balance_general_detalle->Export <> "" && $balance_general_detalle->ExportAll)) // Display all records
		$balance_general_detalle_list->DisplayRecs = $balance_general_detalle_list->TotalRecs;
	if (!($balance_general_detalle->Export <> "" && $balance_general_detalle->ExportAll))
		$balance_general_detalle_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$balance_general_detalle_list->Recordset = $balance_general_detalle_list->LoadRecordset($balance_general_detalle_list->StartRec-1, $balance_general_detalle_list->DisplayRecs);

	// Set no record found message
	if ($balance_general_detalle->CurrentAction == "" && $balance_general_detalle_list->TotalRecs == 0) {
		if ($balance_general_detalle_list->SearchWhere == "0=101")
			$balance_general_detalle_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$balance_general_detalle_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$balance_general_detalle_list->RenderOtherOptions();
?>
<?php $balance_general_detalle_list->ShowPageHeader(); ?>
<?php
$balance_general_detalle_list->ShowMessage();
?>
<?php if ($balance_general_detalle_list->TotalRecs > 0 || $balance_general_detalle->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div class="panel-heading ewGridUpperPanel">
<?php if ($balance_general_detalle->CurrentAction <> "gridadd" && $balance_general_detalle->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($balance_general_detalle_list->Pager)) $balance_general_detalle_list->Pager = new cPrevNextPager($balance_general_detalle_list->StartRec, $balance_general_detalle_list->DisplayRecs, $balance_general_detalle_list->TotalRecs) ?>
<?php if ($balance_general_detalle_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($balance_general_detalle_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($balance_general_detalle_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $balance_general_detalle_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($balance_general_detalle_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($balance_general_detalle_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_detalle_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fbalance_general_detallelist" id="fbalance_general_detallelist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($balance_general_detalle_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $balance_general_detalle_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="balance_general_detalle">
<?php if ($balance_general_detalle->getCurrentMasterTable() == "balance_general" && $balance_general_detalle->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="balance_general">
<input type="hidden" name="fk_idbalance_general" value="<?php echo $balance_general_detalle->idbalance_general->getSessionValue() ?>">
<?php } ?>
<div id="gmp_balance_general_detalle" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($balance_general_detalle_list->TotalRecs > 0) { ?>
<table id="tbl_balance_general_detallelist" class="table ewTable">
<?php echo $balance_general_detalle->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$balance_general_detalle_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$balance_general_detalle_list->RenderListOptions();

// Render list options (header, left)
$balance_general_detalle_list->ListOptions->Render("header", "left");
?>
<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idclase_cuenta) == "") { ?>
		<th data-name="idclase_cuenta"><div id="elh_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idclase_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idclase_cuenta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general_detalle->SortUrl($balance_general_detalle->idclase_cuenta) ?>',1);"><div id="elh_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idclase_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idclase_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idclase_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idgrupo_cuenta) == "") { ?>
		<th data-name="idgrupo_cuenta"><div id="elh_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idgrupo_cuenta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general_detalle->SortUrl($balance_general_detalle->idgrupo_cuenta) ?>',1);"><div id="elh_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->idsubgrupo_cuenta) == "") { ?>
		<th data-name="idsubgrupo_cuenta"><div id="elh_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idsubgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idsubgrupo_cuenta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general_detalle->SortUrl($balance_general_detalle->idsubgrupo_cuenta) ?>',1);"><div id="elh_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->idsubgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->idsubgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->idsubgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
	<?php if ($balance_general_detalle->SortUrl($balance_general_detalle->monto) == "") { ?>
		<th data-name="monto"><div id="elh_balance_general_detalle_monto" class="balance_general_detalle_monto"><div class="ewTableHeaderCaption"><?php echo $balance_general_detalle->monto->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="monto"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $balance_general_detalle->SortUrl($balance_general_detalle->monto) ?>',1);"><div id="elh_balance_general_detalle_monto" class="balance_general_detalle_monto">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $balance_general_detalle->monto->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($balance_general_detalle->monto->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($balance_general_detalle->monto->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$balance_general_detalle_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($balance_general_detalle->ExportAll && $balance_general_detalle->Export <> "") {
	$balance_general_detalle_list->StopRec = $balance_general_detalle_list->TotalRecs;
} else {

	// Set the last record to display
	if ($balance_general_detalle_list->TotalRecs > $balance_general_detalle_list->StartRec + $balance_general_detalle_list->DisplayRecs - 1)
		$balance_general_detalle_list->StopRec = $balance_general_detalle_list->StartRec + $balance_general_detalle_list->DisplayRecs - 1;
	else
		$balance_general_detalle_list->StopRec = $balance_general_detalle_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($balance_general_detalle_list->FormKeyCountName) && ($balance_general_detalle->CurrentAction == "gridadd" || $balance_general_detalle->CurrentAction == "gridedit" || $balance_general_detalle->CurrentAction == "F")) {
		$balance_general_detalle_list->KeyCount = $objForm->GetValue($balance_general_detalle_list->FormKeyCountName);
		$balance_general_detalle_list->StopRec = $balance_general_detalle_list->StartRec + $balance_general_detalle_list->KeyCount - 1;
	}
}
$balance_general_detalle_list->RecCnt = $balance_general_detalle_list->StartRec - 1;
if ($balance_general_detalle_list->Recordset && !$balance_general_detalle_list->Recordset->EOF) {
	$balance_general_detalle_list->Recordset->MoveFirst();
	$bSelectLimit = $balance_general_detalle_list->UseSelectLimit;
	if (!$bSelectLimit && $balance_general_detalle_list->StartRec > 1)
		$balance_general_detalle_list->Recordset->Move($balance_general_detalle_list->StartRec - 1);
} elseif (!$balance_general_detalle->AllowAddDeleteRow && $balance_general_detalle_list->StopRec == 0) {
	$balance_general_detalle_list->StopRec = $balance_general_detalle->GridAddRowCount;
}

// Initialize aggregate
$balance_general_detalle->RowType = EW_ROWTYPE_AGGREGATEINIT;
$balance_general_detalle->ResetAttrs();
$balance_general_detalle_list->RenderRow();
if ($balance_general_detalle->CurrentAction == "gridadd")
	$balance_general_detalle_list->RowIndex = 0;
if ($balance_general_detalle->CurrentAction == "gridedit")
	$balance_general_detalle_list->RowIndex = 0;
while ($balance_general_detalle_list->RecCnt < $balance_general_detalle_list->StopRec) {
	$balance_general_detalle_list->RecCnt++;
	if (intval($balance_general_detalle_list->RecCnt) >= intval($balance_general_detalle_list->StartRec)) {
		$balance_general_detalle_list->RowCnt++;
		if ($balance_general_detalle->CurrentAction == "gridadd" || $balance_general_detalle->CurrentAction == "gridedit" || $balance_general_detalle->CurrentAction == "F") {
			$balance_general_detalle_list->RowIndex++;
			$objForm->Index = $balance_general_detalle_list->RowIndex;
			if ($objForm->HasValue($balance_general_detalle_list->FormActionName))
				$balance_general_detalle_list->RowAction = strval($objForm->GetValue($balance_general_detalle_list->FormActionName));
			elseif ($balance_general_detalle->CurrentAction == "gridadd")
				$balance_general_detalle_list->RowAction = "insert";
			else
				$balance_general_detalle_list->RowAction = "";
		}

		// Set up key count
		$balance_general_detalle_list->KeyCount = $balance_general_detalle_list->RowIndex;

		// Init row class and style
		$balance_general_detalle->ResetAttrs();
		$balance_general_detalle->CssClass = "";
		if ($balance_general_detalle->CurrentAction == "gridadd") {
			$balance_general_detalle_list->LoadDefaultValues(); // Load default values
		} else {
			$balance_general_detalle_list->LoadRowValues($balance_general_detalle_list->Recordset); // Load row values
		}
		$balance_general_detalle->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($balance_general_detalle->CurrentAction == "gridadd") // Grid add
			$balance_general_detalle->RowType = EW_ROWTYPE_ADD; // Render add
		if ($balance_general_detalle->CurrentAction == "gridadd" && $balance_general_detalle->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$balance_general_detalle_list->RestoreCurrentRowFormValues($balance_general_detalle_list->RowIndex); // Restore form values
		if ($balance_general_detalle->CurrentAction == "gridedit") { // Grid edit
			if ($balance_general_detalle->EventCancelled) {
				$balance_general_detalle_list->RestoreCurrentRowFormValues($balance_general_detalle_list->RowIndex); // Restore form values
			}
			if ($balance_general_detalle_list->RowAction == "insert")
				$balance_general_detalle->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$balance_general_detalle->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($balance_general_detalle->CurrentAction == "gridedit" && ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT || $balance_general_detalle->RowType == EW_ROWTYPE_ADD) && $balance_general_detalle->EventCancelled) // Update failed
			$balance_general_detalle_list->RestoreCurrentRowFormValues($balance_general_detalle_list->RowIndex); // Restore form values
		if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) // Edit row
			$balance_general_detalle_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$balance_general_detalle->RowAttrs = array_merge($balance_general_detalle->RowAttrs, array('data-rowindex'=>$balance_general_detalle_list->RowCnt, 'id'=>'r' . $balance_general_detalle_list->RowCnt . '_balance_general_detalle', 'data-rowtype'=>$balance_general_detalle->RowType));

		// Render row
		$balance_general_detalle_list->RenderRow();

		// Render list options
		$balance_general_detalle_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($balance_general_detalle_list->RowAction <> "delete" && $balance_general_detalle_list->RowAction <> "insertdelete" && !($balance_general_detalle_list->RowAction == "insert" && $balance_general_detalle->CurrentAction == "F" && $balance_general_detalle_list->EmptyRow())) {
?>
	<tr<?php echo $balance_general_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_detalle_list->ListOptions->Render("body", "left", $balance_general_detalle_list->RowCnt);
?>
	<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idclase_cuenta" class="balance_general_detalle_idclase_cuenta">
<span<?php echo $balance_general_detalle->idclase_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idclase_cuenta->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $balance_general_detalle_list->PageObjName . "_row_" . $balance_general_detalle_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->CurrentValue) ?>">
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT || $balance_general_detalle->CurrentMode == "edit") { ?>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idbalance_general_detalle" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idbalance_general_detalle" value="<?php echo ew_HtmlEncode($balance_general_detalle->idbalance_general_detalle->CurrentValue) ?>">
<?php } ?>
	<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idgrupo_cuenta" class="balance_general_detalle_idgrupo_cuenta">
<span<?php echo $balance_general_detalle->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
		<td data-name="idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_idsubgrupo_cuenta" class="balance_general_detalle_idsubgrupo_cuenta">
<span<?php echo $balance_general_detalle->idsubgrupo_cuenta->ViewAttributes() ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
		<td data-name="monto"<?php echo $balance_general_detalle->monto->CellAttributes() ?>>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_monto" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->OldValue) ?>">
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $balance_general_detalle_list->RowCnt ?>_balance_general_detalle_monto" class="balance_general_detalle_monto">
<span<?php echo $balance_general_detalle->monto->ViewAttributes() ?>>
<?php echo $balance_general_detalle->monto->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_detalle_list->ListOptions->Render("body", "right", $balance_general_detalle_list->RowCnt);
?>
	</tr>
<?php if ($balance_general_detalle->RowType == EW_ROWTYPE_ADD || $balance_general_detalle->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fbalance_general_detallelist.UpdateOpts(<?php echo $balance_general_detalle_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($balance_general_detalle->CurrentAction <> "gridadd")
		if (!$balance_general_detalle_list->Recordset->EOF) $balance_general_detalle_list->Recordset->MoveNext();
}
?>
<?php
	if ($balance_general_detalle->CurrentAction == "gridadd" || $balance_general_detalle->CurrentAction == "gridedit") {
		$balance_general_detalle_list->RowIndex = '$rowindex$';
		$balance_general_detalle_list->LoadDefaultValues();

		// Set row properties
		$balance_general_detalle->ResetAttrs();
		$balance_general_detalle->RowAttrs = array_merge($balance_general_detalle->RowAttrs, array('data-rowindex'=>$balance_general_detalle_list->RowIndex, 'id'=>'r0_balance_general_detalle', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($balance_general_detalle->RowAttrs["class"], "ewTemplate");
		$balance_general_detalle->RowType = EW_ROWTYPE_ADD;

		// Render row
		$balance_general_detalle_list->RenderRow();

		// Render list options
		$balance_general_detalle_list->RenderListOptions();
		$balance_general_detalle_list->StartRowCnt = 0;
?>
	<tr<?php echo $balance_general_detalle->RowAttributes() ?>>
<?php

// Render list options (body, left)
$balance_general_detalle_list->ListOptions->Render("body", "left", $balance_general_detalle_list->RowIndex);
?>
	<?php if ($balance_general_detalle->idclase_cuenta->Visible) { // idclase_cuenta ?>
		<td data-name="idclase_cuenta">
<span id="el$rowindex$_balance_general_detalle_idclase_cuenta" class="form-group balance_general_detalle_idclase_cuenta">
<?php $balance_general_detalle->idclase_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idclase_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idclase_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idclase_cuenta->DisplayValueSeparator) : $balance_general_detalle->idclase_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta"<?php echo $balance_general_detalle->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idclase_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idclase_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idclase_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idclase_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idclase_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idclase_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idclase_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idclase_cuenta->LookupFilters += array("f0" => "`idclase_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idclase_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idclase_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" value="<?php echo $balance_general_detalle->idclase_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idclase_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idclase_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idclase_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta">
<span id="el$rowindex$_balance_general_detalle_idgrupo_cuenta" class="form-group balance_general_detalle_idgrupo_cuenta">
<?php $balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$balance_general_detalle->idgrupo_cuenta->EditAttrs["onchange"]; ?>
<select data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta"<?php echo $balance_general_detalle->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idgrupo_cuenta->LookupFilters += array("f1" => "`idclase_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $balance_general_detalle->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idgrupo_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
		<td data-name="idsubgrupo_cuenta">
<span id="el$rowindex$_balance_general_detalle_idsubgrupo_cuenta" class="form-group balance_general_detalle_idsubgrupo_cuenta">
<select data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) : $balance_general_detalle->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta"<?php echo $balance_general_detalle->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($balance_general_detalle->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $balance_general_detalle->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($balance_general_detalle->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $balance_general_detalle->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $balance_general_detalle->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $balance_general_detalle->idsubgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$balance_general_detalle->idsubgrupo_cuenta->LookupFilters += array("f1" => "`idgrupo_cuenta` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$balance_general_detalle->Lookup_Selecting($balance_general_detalle->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nomenclatura`";
if ($sSqlWrk <> "") $balance_general_detalle->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" id="s_x<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo $balance_general_detalle->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_idsubgrupo_cuenta" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($balance_general_detalle->idsubgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($balance_general_detalle->monto->Visible) { // monto ?>
		<td data-name="monto">
<span id="el$rowindex$_balance_general_detalle_monto" class="form-group balance_general_detalle_monto">
<input type="text" data-table="balance_general_detalle" data-field="x_monto" name="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" id="x<?php echo $balance_general_detalle_list->RowIndex ?>_monto" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $balance_general_detalle->monto->EditValue ?>"<?php echo $balance_general_detalle->monto->EditAttributes() ?>>
</span>
<input type="hidden" data-table="balance_general_detalle" data-field="x_monto" name="o<?php echo $balance_general_detalle_list->RowIndex ?>_monto" id="o<?php echo $balance_general_detalle_list->RowIndex ?>_monto" value="<?php echo ew_HtmlEncode($balance_general_detalle->monto->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$balance_general_detalle_list->ListOptions->Render("body", "right", $balance_general_detalle_list->RowCnt);
?>
<script type="text/javascript">
fbalance_general_detallelist.UpdateOpts(<?php echo $balance_general_detalle_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($balance_general_detalle->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $balance_general_detalle_list->FormKeyCountName ?>" id="<?php echo $balance_general_detalle_list->FormKeyCountName ?>" value="<?php echo $balance_general_detalle_list->KeyCount ?>">
<?php echo $balance_general_detalle_list->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general_detalle->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $balance_general_detalle_list->FormKeyCountName ?>" id="<?php echo $balance_general_detalle_list->FormKeyCountName ?>" value="<?php echo $balance_general_detalle_list->KeyCount ?>">
<?php echo $balance_general_detalle_list->MultiSelectKey ?>
<?php } ?>
<?php if ($balance_general_detalle->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($balance_general_detalle_list->Recordset)
	$balance_general_detalle_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($balance_general_detalle->CurrentAction <> "gridadd" && $balance_general_detalle->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($balance_general_detalle_list->Pager)) $balance_general_detalle_list->Pager = new cPrevNextPager($balance_general_detalle_list->StartRec, $balance_general_detalle_list->DisplayRecs, $balance_general_detalle_list->TotalRecs) ?>
<?php if ($balance_general_detalle_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($balance_general_detalle_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($balance_general_detalle_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $balance_general_detalle_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($balance_general_detalle_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($balance_general_detalle_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $balance_general_detalle_list->PageUrl() ?>start=<?php echo $balance_general_detalle_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $balance_general_detalle_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_detalle_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($balance_general_detalle_list->TotalRecs == 0 && $balance_general_detalle->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($balance_general_detalle_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fbalance_general_detallelist.Init();
</script>
<?php
$balance_general_detalle_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$balance_general_detalle_list->Page_Terminate();
?>
