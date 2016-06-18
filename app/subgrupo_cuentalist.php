<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "subgrupo_cuentainfo.php" ?>
<?php include_once "grupo_cuentainfo.php" ?>
<?php include_once "cuenta_mayor_principalgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$subgrupo_cuenta_list = NULL; // Initialize page object first

class csubgrupo_cuenta_list extends csubgrupo_cuenta {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'subgrupo_cuenta';

	// Page object name
	var $PageObjName = 'subgrupo_cuenta_list';

	// Grid form hidden field names
	var $FormName = 'fsubgrupo_cuentalist';
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

		// Table object (subgrupo_cuenta)
		if (!isset($GLOBALS["subgrupo_cuenta"]) || get_class($GLOBALS["subgrupo_cuenta"]) == "csubgrupo_cuenta") {
			$GLOBALS["subgrupo_cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["subgrupo_cuenta"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "subgrupo_cuentaadd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "subgrupo_cuentadelete.php";
		$this->MultiUpdateUrl = "subgrupo_cuentaupdate.php";

		// Table object (grupo_cuenta)
		if (!isset($GLOBALS['grupo_cuenta'])) $GLOBALS['grupo_cuenta'] = new cgrupo_cuenta();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subgrupo_cuenta', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fsubgrupo_cuentalistsrch";

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

			// Process auto fill for detail table 'cuenta_mayor_principal'
			if (@$_POST["grid"] == "fcuenta_mayor_principalgrid") {
				if (!isset($GLOBALS["cuenta_mayor_principal_grid"])) $GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid;
				$GLOBALS["cuenta_mayor_principal_grid"]->Page_Init();
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
		global $EW_EXPORT, $subgrupo_cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($subgrupo_cuenta);
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "grupo_cuenta") {
			global $grupo_cuenta;
			$rsmaster = $grupo_cuenta->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("grupo_cuentalist.php"); // Return to master page
			} else {
				$grupo_cuenta->LoadListRowValues($rsmaster);
				$grupo_cuenta->RowType = EW_ROWTYPE_MASTER; // Master row
				$grupo_cuenta->RenderListRow();
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
			$this->idsubgrupo_cuenta->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idsubgrupo_cuenta->FormValue))
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
					$sKey .= $this->idsubgrupo_cuenta->CurrentValue;

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
		if ($objForm->HasValue("x_idgrupo_cuenta") && $objForm->HasValue("o_idgrupo_cuenta") && $this->idgrupo_cuenta->CurrentValue <> $this->idgrupo_cuenta->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_tendencia") && $objForm->HasValue("o_tendencia") && $this->tendencia->CurrentValue <> $this->tendencia->OldValue)
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
			$this->UpdateSort($this->nomenclatura); // nomenclatura
			$this->UpdateSort($this->nombre); // nombre
			$this->UpdateSort($this->idgrupo_cuenta); // idgrupo_cuenta
			$this->UpdateSort($this->tendencia); // tendencia
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
				$this->idgrupo_cuenta->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->nomenclatura->setSort("");
				$this->nombre->setSort("");
				$this->idgrupo_cuenta->setSort("");
				$this->tendencia->setSort("");
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

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "detail_cuenta_mayor_principal"
		$item = &$this->ListOptions->Add("detail_cuenta_mayor_principal");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE && !$this->ShowMultipleDetails;
		$item->OnLeft = TRUE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["cuenta_mayor_principal_grid"])) $GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid;

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
		$pages->Add("cuenta_mayor_principal");
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

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (TRUE) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CopyLink")) . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
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

		// "detail_cuenta_mayor_principal"
		$oListOpt = &$this->ListOptions->Items["detail_cuenta_mayor_principal"];
		if (TRUE) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("cuenta_mayor_principal", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("cuenta_mayor_principallist.php?" . EW_TABLE_SHOW_MASTER . "=subgrupo_cuenta&fk_idsubgrupo_cuenta=" . urlencode(strval($this->idsubgrupo_cuenta->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["cuenta_mayor_principal_grid"]->DetailView) {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=cuenta_mayor_principal")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "cuenta_mayor_principal";
			}
			if ($GLOBALS["cuenta_mayor_principal_grid"]->DetailEdit) {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=cuenta_mayor_principal")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "cuenta_mayor_principal";
			}
			if ($GLOBALS["cuenta_mayor_principal_grid"]->DetailAdd) {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=cuenta_mayor_principal")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
				if ($DetailCopyTblVar <> "") $DetailCopyTblVar .= ",";
				$DetailCopyTblVar .= "cuenta_mayor_principal";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idsubgrupo_cuenta->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->idsubgrupo_cuenta->CurrentValue . "\">";
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
		$item = &$option->Add("detailadd_cuenta_mayor_principal");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=cuenta_mayor_principal");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["cuenta_mayor_principal"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["cuenta_mayor_principal"]->DetailAdd);
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "cuenta_mayor_principal";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fsubgrupo_cuentalistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = FALSE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fsubgrupo_cuentalistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fsubgrupo_cuentalist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idgrupo_cuenta->CurrentValue = NULL;
		$this->idgrupo_cuenta->OldValue = $this->idgrupo_cuenta->CurrentValue;
		$this->tendencia->CurrentValue = "Positiva";
		$this->tendencia->OldValue = $this->tendencia->CurrentValue;
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
		if (!$this->idgrupo_cuenta->FldIsDetailKey) {
			$this->idgrupo_cuenta->setFormValue($objForm->GetValue("x_idgrupo_cuenta"));
		}
		$this->idgrupo_cuenta->setOldValue($objForm->GetValue("o_idgrupo_cuenta"));
		if (!$this->tendencia->FldIsDetailKey) {
			$this->tendencia->setFormValue($objForm->GetValue("x_tendencia"));
		}
		$this->tendencia->setOldValue($objForm->GetValue("o_tendencia"));
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idsubgrupo_cuenta->setFormValue($objForm->GetValue("x_idsubgrupo_cuenta"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->FormValue;
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->FormValue;
		$this->tendencia->CurrentValue = $this->tendencia->FormValue;
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
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idgrupo_cuenta->setDbValue($rs->fields('idgrupo_cuenta'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->idgrupo_flujo_efectivo->setDbValue($rs->fields('idgrupo_flujo_efectivo'));
		$this->tendencia->setDbValue($rs->fields('tendencia'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idsubgrupo_cuenta->DbValue = $row['idsubgrupo_cuenta'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idgrupo_cuenta->DbValue = $row['idgrupo_cuenta'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
		$this->idgrupo_flujo_efectivo->DbValue = $row['idgrupo_flujo_efectivo'];
		$this->tendencia->DbValue = $row['tendencia'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idsubgrupo_cuenta")) <> "")
			$this->idsubgrupo_cuenta->CurrentValue = $this->getKey("idsubgrupo_cuenta"); // idsubgrupo_cuenta
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
		// idsubgrupo_cuenta
		// nomenclatura
		// nombre
		// idgrupo_cuenta
		// definicion
		// estado
		// idgrupo_flujo_efectivo
		// tendencia

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idsubgrupo_cuenta
		$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
		$this->idsubgrupo_cuenta->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

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

		// idgrupo_flujo_efectivo
		$this->idgrupo_flujo_efectivo->ViewValue = $this->idgrupo_flujo_efectivo->CurrentValue;
		$this->idgrupo_flujo_efectivo->ViewCustomAttributes = "";

		// tendencia
		if (strval($this->tendencia->CurrentValue) <> "") {
			$this->tendencia->ViewValue = $this->tendencia->OptionCaption($this->tendencia->CurrentValue);
		} else {
			$this->tendencia->ViewValue = NULL;
		}
		$this->tendencia->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";
			$this->idgrupo_cuenta->TooltipValue = "";

			// tendencia
			$this->tendencia->LinkCustomAttributes = "";
			$this->tendencia->HrefValue = "";
			$this->tendencia->TooltipValue = "";
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

			// idgrupo_cuenta
			$this->idgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idgrupo_cuenta->EditCustomAttributes = "";
			if ($this->idgrupo_cuenta->getSessionValue() <> "") {
				$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->getSessionValue();
				$this->idgrupo_cuenta->OldValue = $this->idgrupo_cuenta->CurrentValue;
			if (strval($this->idgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
			} else {
			if (trim(strval($this->idgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_cuenta->EditValue = $arwrk;
			}

			// tendencia
			$this->tendencia->EditAttrs["class"] = "form-control";
			$this->tendencia->EditCustomAttributes = "";
			$this->tendencia->EditValue = $this->tendencia->Options(TRUE);

			// Add refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";

			// tendencia
			$this->tendencia->LinkCustomAttributes = "";
			$this->tendencia->HrefValue = "";
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

			// idgrupo_cuenta
			$this->idgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idgrupo_cuenta->EditCustomAttributes = "";
			if ($this->idgrupo_cuenta->getSessionValue() <> "") {
				$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->getSessionValue();
				$this->idgrupo_cuenta->OldValue = $this->idgrupo_cuenta->CurrentValue;
			if (strval($this->idgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
			} else {
			if (trim(strval($this->idgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_cuenta->EditValue = $arwrk;
			}

			// tendencia
			$this->tendencia->EditAttrs["class"] = "form-control";
			$this->tendencia->EditCustomAttributes = "";
			$this->tendencia->EditValue = $this->tendencia->Options(TRUE);

			// Edit refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";

			// tendencia
			$this->tendencia->LinkCustomAttributes = "";
			$this->tendencia->HrefValue = "";
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
		if (!$this->idgrupo_cuenta->FldIsDetailKey && !is_null($this->idgrupo_cuenta->FormValue) && $this->idgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idgrupo_cuenta->FldCaption(), $this->idgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->tendencia->FldIsDetailKey && !is_null($this->tendencia->FormValue) && $this->tendencia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tendencia->FldCaption(), $this->tendencia->ReqErrMsg));
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
				$sThisKey .= $row['idsubgrupo_cuenta'];
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

			// idgrupo_cuenta
			$this->idgrupo_cuenta->SetDbValueDef($rsnew, $this->idgrupo_cuenta->CurrentValue, 0, $this->idgrupo_cuenta->ReadOnly);

			// tendencia
			$this->tendencia->SetDbValueDef($rsnew, $this->tendencia->CurrentValue, "", $this->tendencia->ReadOnly);

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

		// idgrupo_cuenta
		$this->idgrupo_cuenta->SetDbValueDef($rsnew, $this->idgrupo_cuenta->CurrentValue, 0, FALSE);

		// tendencia
		$this->tendencia->SetDbValueDef($rsnew, $this->tendencia->CurrentValue, "", strval($this->tendencia->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idsubgrupo_cuenta->setDbValue($conn->Insert_ID());
				$rsnew['idsubgrupo_cuenta'] = $this->idsubgrupo_cuenta->DbValue;
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
			if ($sMasterTblVar == "grupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idgrupo_cuenta"] <> "") {
					$GLOBALS["grupo_cuenta"]->idgrupo_cuenta->setQueryStringValue($_GET["fk_idgrupo_cuenta"]);
					$this->idgrupo_cuenta->setQueryStringValue($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->QueryStringValue);
					$this->idgrupo_cuenta->setSessionValue($this->idgrupo_cuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "grupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idgrupo_cuenta"] <> "") {
					$GLOBALS["grupo_cuenta"]->idgrupo_cuenta->setFormValue($_POST["fk_idgrupo_cuenta"]);
					$this->idgrupo_cuenta->setFormValue($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->FormValue);
					$this->idgrupo_cuenta->setSessionValue($this->idgrupo_cuenta->FormValue);
					if (!is_numeric($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "grupo_cuenta") {
				if ($this->idgrupo_cuenta->CurrentValue == "") $this->idgrupo_cuenta->setSessionValue("");
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
if (!isset($subgrupo_cuenta_list)) $subgrupo_cuenta_list = new csubgrupo_cuenta_list();

// Page init
$subgrupo_cuenta_list->Page_Init();

// Page main
$subgrupo_cuenta_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subgrupo_cuenta_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fsubgrupo_cuentalist = new ew_Form("fsubgrupo_cuentalist", "list");
fsubgrupo_cuentalist.FormKeyCountName = '<?php echo $subgrupo_cuenta_list->FormKeyCountName ?>';

// Validate form
fsubgrupo_cuentalist.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nomenclatura->FldCaption(), $subgrupo_cuenta->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nombre->FldCaption(), $subgrupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->idgrupo_cuenta->FldCaption(), $subgrupo_cuenta->idgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tendencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->tendencia->FldCaption(), $subgrupo_cuenta->tendencia->ReqErrMsg)) ?>");

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
fsubgrupo_cuentalist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomenclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idgrupo_cuenta", false)) return false;
	if (ew_ValueChanged(fobj, infix, "tendencia", false)) return false;
	return true;
}

// Form_CustomValidate event
fsubgrupo_cuentalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubgrupo_cuentalist.ValidateRequired = true;
<?php } else { ?>
fsubgrupo_cuentalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsubgrupo_cuentalist.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsubgrupo_cuentalist.Lists["x_tendencia"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsubgrupo_cuentalist.Lists["x_tendencia"].Options = <?php echo json_encode($subgrupo_cuenta->tendencia->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($subgrupo_cuenta_list->TotalRecs > 0 && $subgrupo_cuenta_list->ExportOptions->Visible()) { ?>
<?php $subgrupo_cuenta_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($subgrupo_cuenta->Export == "") || (EW_EXPORT_MASTER_RECORD && $subgrupo_cuenta->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "grupo_cuentalist.php";
if ($subgrupo_cuenta_list->DbMasterFilter <> "" && $subgrupo_cuenta->getCurrentMasterTable() == "grupo_cuenta") {
	if ($subgrupo_cuenta_list->MasterRecordExists) {
		if ($subgrupo_cuenta->getCurrentMasterTable() == $subgrupo_cuenta->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php include_once "grupo_cuentamaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($subgrupo_cuenta->CurrentAction == "gridadd") {
	$subgrupo_cuenta->CurrentFilter = "0=1";
	$subgrupo_cuenta_list->StartRec = 1;
	$subgrupo_cuenta_list->DisplayRecs = $subgrupo_cuenta->GridAddRowCount;
	$subgrupo_cuenta_list->TotalRecs = $subgrupo_cuenta_list->DisplayRecs;
	$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta_list->DisplayRecs;
} else {
	$bSelectLimit = $subgrupo_cuenta_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($subgrupo_cuenta_list->TotalRecs <= 0)
			$subgrupo_cuenta_list->TotalRecs = $subgrupo_cuenta->SelectRecordCount();
	} else {
		if (!$subgrupo_cuenta_list->Recordset && ($subgrupo_cuenta_list->Recordset = $subgrupo_cuenta_list->LoadRecordset()))
			$subgrupo_cuenta_list->TotalRecs = $subgrupo_cuenta_list->Recordset->RecordCount();
	}
	$subgrupo_cuenta_list->StartRec = 1;
	if ($subgrupo_cuenta_list->DisplayRecs <= 0 || ($subgrupo_cuenta->Export <> "" && $subgrupo_cuenta->ExportAll)) // Display all records
		$subgrupo_cuenta_list->DisplayRecs = $subgrupo_cuenta_list->TotalRecs;
	if (!($subgrupo_cuenta->Export <> "" && $subgrupo_cuenta->ExportAll))
		$subgrupo_cuenta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$subgrupo_cuenta_list->Recordset = $subgrupo_cuenta_list->LoadRecordset($subgrupo_cuenta_list->StartRec-1, $subgrupo_cuenta_list->DisplayRecs);

	// Set no record found message
	if ($subgrupo_cuenta->CurrentAction == "" && $subgrupo_cuenta_list->TotalRecs == 0) {
		if ($subgrupo_cuenta_list->SearchWhere == "0=101")
			$subgrupo_cuenta_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$subgrupo_cuenta_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$subgrupo_cuenta_list->RenderOtherOptions();
?>
<?php $subgrupo_cuenta_list->ShowPageHeader(); ?>
<?php
$subgrupo_cuenta_list->ShowMessage();
?>
<?php if ($subgrupo_cuenta_list->TotalRecs > 0 || $subgrupo_cuenta->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div class="panel-heading ewGridUpperPanel">
<?php if ($subgrupo_cuenta->CurrentAction <> "gridadd" && $subgrupo_cuenta->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($subgrupo_cuenta_list->Pager)) $subgrupo_cuenta_list->Pager = new cPrevNextPager($subgrupo_cuenta_list->StartRec, $subgrupo_cuenta_list->DisplayRecs, $subgrupo_cuenta_list->TotalRecs) ?>
<?php if ($subgrupo_cuenta_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($subgrupo_cuenta_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($subgrupo_cuenta_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $subgrupo_cuenta_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($subgrupo_cuenta_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($subgrupo_cuenta_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subgrupo_cuenta_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fsubgrupo_cuentalist" id="fsubgrupo_cuentalist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($subgrupo_cuenta_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $subgrupo_cuenta_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="subgrupo_cuenta">
<?php if ($subgrupo_cuenta->getCurrentMasterTable() == "grupo_cuenta" && $subgrupo_cuenta->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="grupo_cuenta">
<input type="hidden" name="fk_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->getSessionValue() ?>">
<?php } ?>
<div id="gmp_subgrupo_cuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($subgrupo_cuenta_list->TotalRecs > 0) { ?>
<table id="tbl_subgrupo_cuentalist" class="table ewTable">
<?php echo $subgrupo_cuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$subgrupo_cuenta_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$subgrupo_cuenta_list->RenderListOptions();

// Render list options (header, left)
$subgrupo_cuenta_list->ListOptions->Render("header", "left");
?>
<?php if ($subgrupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->nomenclatura) == "") { ?>
		<th data-name="nomenclatura"><div id="elh_subgrupo_cuenta_nomenclatura" class="subgrupo_cuenta_nomenclatura"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nomenclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomenclatura"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subgrupo_cuenta->SortUrl($subgrupo_cuenta->nomenclatura) ?>',1);"><div id="elh_subgrupo_cuenta_nomenclatura" class="subgrupo_cuenta_nomenclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nomenclatura->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->nomenclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->nomenclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_subgrupo_cuenta_nombre" class="subgrupo_cuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subgrupo_cuenta->SortUrl($subgrupo_cuenta->nombre) ?>',1);"><div id="elh_subgrupo_cuenta_nombre" class="subgrupo_cuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->nombre->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->idgrupo_cuenta) == "") { ?>
		<th data-name="idgrupo_cuenta"><div id="elh_subgrupo_cuenta_idgrupo_cuenta" class="subgrupo_cuenta_idgrupo_cuenta"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idgrupo_cuenta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subgrupo_cuenta->SortUrl($subgrupo_cuenta->idgrupo_cuenta) ?>',1);"><div id="elh_subgrupo_cuenta_idgrupo_cuenta" class="subgrupo_cuenta_idgrupo_cuenta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->idgrupo_cuenta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->idgrupo_cuenta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subgrupo_cuenta->tendencia->Visible) { // tendencia ?>
	<?php if ($subgrupo_cuenta->SortUrl($subgrupo_cuenta->tendencia) == "") { ?>
		<th data-name="tendencia"><div id="elh_subgrupo_cuenta_tendencia" class="subgrupo_cuenta_tendencia"><div class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->tendencia->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="tendencia"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subgrupo_cuenta->SortUrl($subgrupo_cuenta->tendencia) ?>',1);"><div id="elh_subgrupo_cuenta_tendencia" class="subgrupo_cuenta_tendencia">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subgrupo_cuenta->tendencia->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subgrupo_cuenta->tendencia->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subgrupo_cuenta->tendencia->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$subgrupo_cuenta_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($subgrupo_cuenta->ExportAll && $subgrupo_cuenta->Export <> "") {
	$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta_list->TotalRecs;
} else {

	// Set the last record to display
	if ($subgrupo_cuenta_list->TotalRecs > $subgrupo_cuenta_list->StartRec + $subgrupo_cuenta_list->DisplayRecs - 1)
		$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta_list->StartRec + $subgrupo_cuenta_list->DisplayRecs - 1;
	else
		$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($subgrupo_cuenta_list->FormKeyCountName) && ($subgrupo_cuenta->CurrentAction == "gridadd" || $subgrupo_cuenta->CurrentAction == "gridedit" || $subgrupo_cuenta->CurrentAction == "F")) {
		$subgrupo_cuenta_list->KeyCount = $objForm->GetValue($subgrupo_cuenta_list->FormKeyCountName);
		$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta_list->StartRec + $subgrupo_cuenta_list->KeyCount - 1;
	}
}
$subgrupo_cuenta_list->RecCnt = $subgrupo_cuenta_list->StartRec - 1;
if ($subgrupo_cuenta_list->Recordset && !$subgrupo_cuenta_list->Recordset->EOF) {
	$subgrupo_cuenta_list->Recordset->MoveFirst();
	$bSelectLimit = $subgrupo_cuenta_list->UseSelectLimit;
	if (!$bSelectLimit && $subgrupo_cuenta_list->StartRec > 1)
		$subgrupo_cuenta_list->Recordset->Move($subgrupo_cuenta_list->StartRec - 1);
} elseif (!$subgrupo_cuenta->AllowAddDeleteRow && $subgrupo_cuenta_list->StopRec == 0) {
	$subgrupo_cuenta_list->StopRec = $subgrupo_cuenta->GridAddRowCount;
}

// Initialize aggregate
$subgrupo_cuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$subgrupo_cuenta->ResetAttrs();
$subgrupo_cuenta_list->RenderRow();
if ($subgrupo_cuenta->CurrentAction == "gridadd")
	$subgrupo_cuenta_list->RowIndex = 0;
if ($subgrupo_cuenta->CurrentAction == "gridedit")
	$subgrupo_cuenta_list->RowIndex = 0;
while ($subgrupo_cuenta_list->RecCnt < $subgrupo_cuenta_list->StopRec) {
	$subgrupo_cuenta_list->RecCnt++;
	if (intval($subgrupo_cuenta_list->RecCnt) >= intval($subgrupo_cuenta_list->StartRec)) {
		$subgrupo_cuenta_list->RowCnt++;
		if ($subgrupo_cuenta->CurrentAction == "gridadd" || $subgrupo_cuenta->CurrentAction == "gridedit" || $subgrupo_cuenta->CurrentAction == "F") {
			$subgrupo_cuenta_list->RowIndex++;
			$objForm->Index = $subgrupo_cuenta_list->RowIndex;
			if ($objForm->HasValue($subgrupo_cuenta_list->FormActionName))
				$subgrupo_cuenta_list->RowAction = strval($objForm->GetValue($subgrupo_cuenta_list->FormActionName));
			elseif ($subgrupo_cuenta->CurrentAction == "gridadd")
				$subgrupo_cuenta_list->RowAction = "insert";
			else
				$subgrupo_cuenta_list->RowAction = "";
		}

		// Set up key count
		$subgrupo_cuenta_list->KeyCount = $subgrupo_cuenta_list->RowIndex;

		// Init row class and style
		$subgrupo_cuenta->ResetAttrs();
		$subgrupo_cuenta->CssClass = "";
		if ($subgrupo_cuenta->CurrentAction == "gridadd") {
			$subgrupo_cuenta_list->LoadDefaultValues(); // Load default values
		} else {
			$subgrupo_cuenta_list->LoadRowValues($subgrupo_cuenta_list->Recordset); // Load row values
		}
		$subgrupo_cuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($subgrupo_cuenta->CurrentAction == "gridadd") // Grid add
			$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($subgrupo_cuenta->CurrentAction == "gridadd" && $subgrupo_cuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$subgrupo_cuenta_list->RestoreCurrentRowFormValues($subgrupo_cuenta_list->RowIndex); // Restore form values
		if ($subgrupo_cuenta->CurrentAction == "gridedit") { // Grid edit
			if ($subgrupo_cuenta->EventCancelled) {
				$subgrupo_cuenta_list->RestoreCurrentRowFormValues($subgrupo_cuenta_list->RowIndex); // Restore form values
			}
			if ($subgrupo_cuenta_list->RowAction == "insert")
				$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$subgrupo_cuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($subgrupo_cuenta->CurrentAction == "gridedit" && ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT || $subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) && $subgrupo_cuenta->EventCancelled) // Update failed
			$subgrupo_cuenta_list->RestoreCurrentRowFormValues($subgrupo_cuenta_list->RowIndex); // Restore form values
		if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$subgrupo_cuenta_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$subgrupo_cuenta->RowAttrs = array_merge($subgrupo_cuenta->RowAttrs, array('data-rowindex'=>$subgrupo_cuenta_list->RowCnt, 'id'=>'r' . $subgrupo_cuenta_list->RowCnt . '_subgrupo_cuenta', 'data-rowtype'=>$subgrupo_cuenta->RowType));

		// Render row
		$subgrupo_cuenta_list->RenderRow();

		// Render list options
		$subgrupo_cuenta_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($subgrupo_cuenta_list->RowAction <> "delete" && $subgrupo_cuenta_list->RowAction <> "insertdelete" && !($subgrupo_cuenta_list->RowAction == "insert" && $subgrupo_cuenta->CurrentAction == "F" && $subgrupo_cuenta_list->EmptyRow())) {
?>
	<tr<?php echo $subgrupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subgrupo_cuenta_list->ListOptions->Render("body", "left", $subgrupo_cuenta_list->RowCnt);
?>
	<?php if ($subgrupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura"<?php echo $subgrupo_cuenta->nomenclatura->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nomenclatura" class="form-group subgrupo_cuenta_nomenclatura">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nomenclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nomenclatura" class="form-group subgrupo_cuenta_nomenclatura">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nomenclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nomenclatura" class="subgrupo_cuenta_nomenclatura">
<span<?php echo $subgrupo_cuenta->nomenclatura->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nomenclatura->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $subgrupo_cuenta_list->PageObjName . "_row_" . $subgrupo_cuenta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_idsubgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->CurrentValue) ?>">
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_idsubgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT || $subgrupo_cuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_idsubgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idsubgrupo_cuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $subgrupo_cuenta->nombre->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_nombre" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_nombre" class="subgrupo_cuenta_nombre">
<span<?php echo $subgrupo_cuenta->nombre->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->nombre->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) : $subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $subgrupo_cuenta->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) : $subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $subgrupo_cuenta->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_idgrupo_cuenta" class="subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->tendencia->Visible) { // tendencia ?>
		<td data-name="tendencia"<?php echo $subgrupo_cuenta->tendencia->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_tendencia" class="form-group subgrupo_cuenta_tendencia">
<select data-table="subgrupo_cuenta" data-field="x_tendencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->tendencia->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->tendencia->DisplayValueSeparator) : $subgrupo_cuenta->tendencia->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia"<?php echo $subgrupo_cuenta->tendencia->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->tendencia->EditValue)) {
	$arwrk = $subgrupo_cuenta->tendencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->tendencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->tendencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->tendencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->tendencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->tendencia->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_tendencia" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->OldValue) ?>">
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_tendencia" class="form-group subgrupo_cuenta_tendencia">
<select data-table="subgrupo_cuenta" data-field="x_tendencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->tendencia->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->tendencia->DisplayValueSeparator) : $subgrupo_cuenta->tendencia->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia"<?php echo $subgrupo_cuenta->tendencia->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->tendencia->EditValue)) {
	$arwrk = $subgrupo_cuenta->tendencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->tendencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->tendencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->tendencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->tendencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->tendencia->OldValue = "";
?>
</select>
</span>
<?php } ?>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $subgrupo_cuenta_list->RowCnt ?>_subgrupo_cuenta_tendencia" class="subgrupo_cuenta_tendencia">
<span<?php echo $subgrupo_cuenta->tendencia->ViewAttributes() ?>>
<?php echo $subgrupo_cuenta->tendencia->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subgrupo_cuenta_list->ListOptions->Render("body", "right", $subgrupo_cuenta_list->RowCnt);
?>
	</tr>
<?php if ($subgrupo_cuenta->RowType == EW_ROWTYPE_ADD || $subgrupo_cuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsubgrupo_cuentalist.UpdateOpts(<?php echo $subgrupo_cuenta_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($subgrupo_cuenta->CurrentAction <> "gridadd")
		if (!$subgrupo_cuenta_list->Recordset->EOF) $subgrupo_cuenta_list->Recordset->MoveNext();
}
?>
<?php
	if ($subgrupo_cuenta->CurrentAction == "gridadd" || $subgrupo_cuenta->CurrentAction == "gridedit") {
		$subgrupo_cuenta_list->RowIndex = '$rowindex$';
		$subgrupo_cuenta_list->LoadDefaultValues();

		// Set row properties
		$subgrupo_cuenta->ResetAttrs();
		$subgrupo_cuenta->RowAttrs = array_merge($subgrupo_cuenta->RowAttrs, array('data-rowindex'=>$subgrupo_cuenta_list->RowIndex, 'id'=>'r0_subgrupo_cuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($subgrupo_cuenta->RowAttrs["class"], "ewTemplate");
		$subgrupo_cuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$subgrupo_cuenta_list->RenderRow();

		// Render list options
		$subgrupo_cuenta_list->RenderListOptions();
		$subgrupo_cuenta_list->StartRowCnt = 0;
?>
	<tr<?php echo $subgrupo_cuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subgrupo_cuenta_list->ListOptions->Render("body", "left", $subgrupo_cuenta_list->RowIndex);
?>
	<?php if ($subgrupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
		<td data-name="nomenclatura">
<span id="el$rowindex$_subgrupo_cuenta_nomenclatura" class="form-group subgrupo_cuenta_nomenclatura">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nomenclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nomenclatura" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre">
<span id="el$rowindex$_subgrupo_cuenta_nombre" class="form-group subgrupo_cuenta_nombre">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nombre" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_nombre" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
		<td data-name="idgrupo_cuenta">
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el$rowindex$_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_subgrupo_cuenta_idgrupo_cuenta" class="form-group subgrupo_cuenta_idgrupo_cuenta">
<select data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) : $subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->idgrupo_cuenta->OldValue = "";
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $subgrupo_cuenta->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" id="s_x<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subgrupo_cuenta->tendencia->Visible) { // tendencia ?>
		<td data-name="tendencia">
<span id="el$rowindex$_subgrupo_cuenta_tendencia" class="form-group subgrupo_cuenta_tendencia">
<select data-table="subgrupo_cuenta" data-field="x_tendencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->tendencia->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->tendencia->DisplayValueSeparator) : $subgrupo_cuenta->tendencia->DisplayValueSeparator) ?>" id="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" name="x<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia"<?php echo $subgrupo_cuenta->tendencia->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->tendencia->EditValue)) {
	$arwrk = $subgrupo_cuenta->tendencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->tendencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->tendencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->tendencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->tendencia->CurrentValue ?></option>
<?php
    }
}
if (@$emptywrk) $subgrupo_cuenta->tendencia->OldValue = "";
?>
</select>
</span>
<input type="hidden" data-table="subgrupo_cuenta" data-field="x_tendencia" name="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" id="o<?php echo $subgrupo_cuenta_list->RowIndex ?>_tendencia" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subgrupo_cuenta_list->ListOptions->Render("body", "right", $subgrupo_cuenta_list->RowCnt);
?>
<script type="text/javascript">
fsubgrupo_cuentalist.UpdateOpts(<?php echo $subgrupo_cuenta_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($subgrupo_cuenta->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $subgrupo_cuenta_list->FormKeyCountName ?>" id="<?php echo $subgrupo_cuenta_list->FormKeyCountName ?>" value="<?php echo $subgrupo_cuenta_list->KeyCount ?>">
<?php echo $subgrupo_cuenta_list->MultiSelectKey ?>
<?php } ?>
<?php if ($subgrupo_cuenta->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $subgrupo_cuenta_list->FormKeyCountName ?>" id="<?php echo $subgrupo_cuenta_list->FormKeyCountName ?>" value="<?php echo $subgrupo_cuenta_list->KeyCount ?>">
<?php echo $subgrupo_cuenta_list->MultiSelectKey ?>
<?php } ?>
<?php if ($subgrupo_cuenta->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($subgrupo_cuenta_list->Recordset)
	$subgrupo_cuenta_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($subgrupo_cuenta->CurrentAction <> "gridadd" && $subgrupo_cuenta->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($subgrupo_cuenta_list->Pager)) $subgrupo_cuenta_list->Pager = new cPrevNextPager($subgrupo_cuenta_list->StartRec, $subgrupo_cuenta_list->DisplayRecs, $subgrupo_cuenta_list->TotalRecs) ?>
<?php if ($subgrupo_cuenta_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($subgrupo_cuenta_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($subgrupo_cuenta_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $subgrupo_cuenta_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($subgrupo_cuenta_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($subgrupo_cuenta_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $subgrupo_cuenta_list->PageUrl() ?>start=<?php echo $subgrupo_cuenta_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $subgrupo_cuenta_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subgrupo_cuenta_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($subgrupo_cuenta_list->TotalRecs == 0 && $subgrupo_cuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subgrupo_cuenta_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fsubgrupo_cuentalist.Init();
</script>
<?php
$subgrupo_cuenta_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$subgrupo_cuenta_list->Page_Terminate();
?>
