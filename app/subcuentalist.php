<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "subcuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_mayor_auxiliarinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$subcuenta_list = NULL; // Initialize page object first

class csubcuenta_list extends csubcuenta {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'subcuenta';

	// Page object name
	var $PageObjName = 'subcuenta_list';

	// Grid form hidden field names
	var $FormName = 'fsubcuentalist';
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
			return $fn($_POST[EW_TOKEN_NAME]);
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

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (subcuenta)
		if (!isset($GLOBALS["subcuenta"]) || get_class($GLOBALS["subcuenta"]) == "csubcuenta") {
			$GLOBALS["subcuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["subcuenta"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "subcuentaadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "subcuentadelete.php";
		$this->MultiUpdateUrl = "subcuentaupdate.php";

		// Table object (cuenta_mayor_auxiliar)
		if (!isset($GLOBALS['cuenta_mayor_auxiliar'])) $GLOBALS['cuenta_mayor_auxiliar'] = new ccuenta_mayor_auxiliar();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subcuenta', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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

		// Setup other options
		$this->SetupOtherOptions();

		// Set "checkbox" visible
		if (count($this->CustomActions) > 0)
			$this->ListOptions->Items["checkbox"]->Visible = TRUE;
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn, $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $subcuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($subcuenta);
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
		$conn->Close();

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

			// Process custom action first
			$this->ProcessCustomAction();

			// Handle reset command
			$this->ResetCmd();

			// Set up master detail parameters
			$this->SetUpMasterParms();

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

			// Hide export options
			if ($this->Export <> "" || $this->CurrentAction <> "")
				$this->ExportOptions->HideAllOptions();

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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "cuenta_mayor_auxiliar") {
			global $cuenta_mayor_auxiliar;
			$rsmaster = $cuenta_mayor_auxiliar->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("cuenta_mayor_auxiliarlist.php"); // Return to master page
			} else {
				$cuenta_mayor_auxiliar->LoadListRowValues($rsmaster);
				$cuenta_mayor_auxiliar->RowType = EW_ROWTYPE_MASTER; // Master row
				$cuenta_mayor_auxiliar->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Load record count first
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount();
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
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
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
			$this->idsubcuenta->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idsubcuenta->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

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
					$sKey .= $this->idsubcuenta->CurrentValue;

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
		if ($objForm->HasValue("x_nomeclatura") && $objForm->HasValue("o_nomeclatura") && $this->nomeclatura->CurrentValue <> $this->nomeclatura->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_nombre") && $objForm->HasValue("o_nombre") && $this->nombre->CurrentValue <> $this->nombre->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_idcuenta_mayor_auxiliar") && $objForm->HasValue("o_idcuenta_mayor_auxiliar") && $this->idcuenta_mayor_auxiliar->CurrentValue <> $this->idcuenta_mayor_auxiliar->OldValue)
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

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->nomeclatura, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->nombre, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->definicion, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$sCond = $sDefCond;
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
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
						$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
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
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
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
			$this->UpdateSort($this->nomeclatura); // nomeclatura
			$this->UpdateSort($this->nombre); // nombre
			$this->UpdateSort($this->idcuenta_mayor_auxiliar); // idcuenta_mayor_auxiliar
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
				$this->idcuenta_mayor_auxiliar->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->nomeclatura->setSort("");
				$this->nombre->setSort("");
				$this->idcuenta_mayor_auxiliar->setSort("");
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
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
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

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idsubcuenta->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event, this);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->idsubcuenta->CurrentValue . "\">";
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
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];
			foreach ($this->CustomActions as $action => $name) {

				// Add custom action
				$item = &$option->Add("custom_" . $action);
				$item->Body = "<a class=\"ewAction ewCustomAction\" href=\"\" onclick=\"ew_SubmitSelected(document.fsubcuentalist, '" . ew_CurrentUrl() . "', null, '" . $action . "');return false;\">" . $name . "</a>";
			}

			// Hide grid edit, multi-delete and multi-update
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$item = &$option->GetItem("multidelete");
				if ($item) $item->Visible = FALSE;
				$item = &$option->GetItem("multiupdate");
				if ($item) $item->Visible = FALSE;
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
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit();\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $this->PageUrl() . "a=cancel\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
		}
	}

	// Process custom action
	function ProcessCustomAction() {
		global $conn, $Language, $Security;
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$rsuser = ($rs) ? $rs->GetRows() : array();
			if ($rs)
				$rs->Close();

			// Call row custom action event
			if (count($rsuser) > 0) {
				$conn->BeginTrans();
				foreach ($rsuser as $row) {
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $UserAction, $Language->Phrase("CustomActionCancelled")));
					}
				}
			}
		}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fsubcuentalistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere);

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
		$this->nomeclatura->CurrentValue = NULL;
		$this->nomeclatura->OldValue = $this->nomeclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idcuenta_mayor_auxiliar->CurrentValue = NULL;
		$this->idcuenta_mayor_auxiliar->OldValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
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
		if (!$this->nomeclatura->FldIsDetailKey) {
			$this->nomeclatura->setFormValue($objForm->GetValue("x_nomeclatura"));
		}
		$this->nomeclatura->setOldValue($objForm->GetValue("o_nomeclatura"));
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		$this->nombre->setOldValue($objForm->GetValue("o_nombre"));
		if (!$this->idcuenta_mayor_auxiliar->FldIsDetailKey) {
			$this->idcuenta_mayor_auxiliar->setFormValue($objForm->GetValue("x_idcuenta_mayor_auxiliar"));
		}
		$this->idcuenta_mayor_auxiliar->setOldValue($objForm->GetValue("o_idcuenta_mayor_auxiliar"));
		if (!$this->idsubcuenta->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idsubcuenta->setFormValue($objForm->GetValue("x_idsubcuenta"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->idsubcuenta->CurrentValue = $this->idsubcuenta->FormValue;
		$this->nomeclatura->CurrentValue = $this->nomeclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->FormValue;
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Load List page SQL
		$sSql = $this->SelectSQL();

		// Load recordset
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
		$conn->raiseErrorFn = '';

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->idsubcuenta->setDbValue($rs->fields('idsubcuenta'));
		$this->nomeclatura->setDbValue($rs->fields('nomeclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idcuenta_mayor_auxiliar->setDbValue($rs->fields('idcuenta_mayor_auxiliar'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idsubcuenta->DbValue = $row['idsubcuenta'];
		$this->nomeclatura->DbValue = $row['nomeclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idcuenta_mayor_auxiliar->DbValue = $row['idcuenta_mayor_auxiliar'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idsubcuenta")) <> "")
			$this->idsubcuenta->CurrentValue = $this->getKey("idsubcuenta"); // idsubcuenta
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

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
		// idsubcuenta
		// nomeclatura
		// nombre
		// idcuenta_mayor_auxiliar
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idsubcuenta
			$this->idsubcuenta->ViewValue = $this->idsubcuenta->CurrentValue;
			$this->idsubcuenta->ViewCustomAttributes = "";

			// nomeclatura
			$this->nomeclatura->ViewValue = $this->nomeclatura->CurrentValue;
			$this->nomeclatura->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";

			// definicion
			$this->definicion->ViewValue = $this->definicion->CurrentValue;
			$this->definicion->ViewCustomAttributes = "";

			// estado
			if (strval($this->estado->CurrentValue) <> "") {
				switch ($this->estado->CurrentValue) {
					case $this->estado->FldTagValue(1):
						$this->estado->ViewValue = $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->CurrentValue;
						break;
					case $this->estado->FldTagValue(2):
						$this->estado->ViewValue = $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->CurrentValue;
						break;
					default:
						$this->estado->ViewValue = $this->estado->CurrentValue;
				}
			} else {
				$this->estado->ViewValue = NULL;
			}
			$this->estado->ViewCustomAttributes = "";

			// nomeclatura
			$this->nomeclatura->LinkCustomAttributes = "";
			$this->nomeclatura->HrefValue = "";
			$this->nomeclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->LinkCustomAttributes = "";
			$this->idcuenta_mayor_auxiliar->HrefValue = "";
			$this->idcuenta_mayor_auxiliar->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomeclatura
			$this->nomeclatura->EditAttrs["class"] = "form-control";
			$this->nomeclatura->EditCustomAttributes = "";
			$this->nomeclatura->EditValue = ew_HtmlEncode($this->nomeclatura->CurrentValue);
			$this->nomeclatura->PlaceHolder = ew_RemoveHtml($this->nomeclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->EditAttrs["class"] = "form-control";
			$this->idcuenta_mayor_auxiliar->EditCustomAttributes = "";
			if ($this->idcuenta_mayor_auxiliar->getSessionValue() <> "") {
				$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->getSessionValue();
				$this->idcuenta_mayor_auxiliar->OldValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";
			} else {
			$this->idcuenta_mayor_auxiliar->EditValue = ew_HtmlEncode($this->idcuenta_mayor_auxiliar->CurrentValue);
			$this->idcuenta_mayor_auxiliar->PlaceHolder = ew_RemoveHtml($this->idcuenta_mayor_auxiliar->FldCaption());
			}

			// Edit refer script
			// nomeclatura

			$this->nomeclatura->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// nomeclatura
			$this->nomeclatura->EditAttrs["class"] = "form-control";
			$this->nomeclatura->EditCustomAttributes = "";
			$this->nomeclatura->EditValue = ew_HtmlEncode($this->nomeclatura->CurrentValue);
			$this->nomeclatura->PlaceHolder = ew_RemoveHtml($this->nomeclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->EditAttrs["class"] = "form-control";
			$this->idcuenta_mayor_auxiliar->EditCustomAttributes = "";
			if ($this->idcuenta_mayor_auxiliar->getSessionValue() <> "") {
				$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->getSessionValue();
				$this->idcuenta_mayor_auxiliar->OldValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";
			} else {
			$this->idcuenta_mayor_auxiliar->EditValue = ew_HtmlEncode($this->idcuenta_mayor_auxiliar->CurrentValue);
			$this->idcuenta_mayor_auxiliar->PlaceHolder = ew_RemoveHtml($this->idcuenta_mayor_auxiliar->FldCaption());
			}

			// Edit refer script
			// nomeclatura

			$this->nomeclatura->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->HrefValue = "";
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
		if (!$this->nomeclatura->FldIsDetailKey && !is_null($this->nomeclatura->FormValue) && $this->nomeclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomeclatura->FldCaption(), $this->nomeclatura->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idcuenta_mayor_auxiliar->FldIsDetailKey && !is_null($this->idcuenta_mayor_auxiliar->FormValue) && $this->idcuenta_mayor_auxiliar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta_mayor_auxiliar->FldCaption(), $this->idcuenta_mayor_auxiliar->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcuenta_mayor_auxiliar->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcuenta_mayor_auxiliar->FldErrMsg());
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
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
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
				$sThisKey .= $row['idsubcuenta'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
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
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nomeclatura
			$this->nomeclatura->SetDbValueDef($rsnew, $this->nomeclatura->CurrentValue, "", $this->nomeclatura->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", $this->nombre->ReadOnly);

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->SetDbValueDef($rsnew, $this->idcuenta_mayor_auxiliar->CurrentValue, 0, $this->idcuenta_mayor_auxiliar->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
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
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// nomeclatura
		$this->nomeclatura->SetDbValueDef($rsnew, $this->nomeclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idcuenta_mayor_auxiliar
		$this->idcuenta_mayor_auxiliar->SetDbValueDef($rsnew, $this->idcuenta_mayor_auxiliar->CurrentValue, 0, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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

		// Get insert id if necessary
		if ($AddRow) {
			$this->idsubcuenta->setDbValue($conn->Insert_ID());
			$rsnew['idsubcuenta'] = $this->idsubcuenta->DbValue;
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
			if ($sMasterTblVar == "cuenta_mayor_auxiliar") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcuenta_mayor_auxiliar"] <> "") {
					$GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->setQueryStringValue($_GET["fk_idcuenta_mayor_auxiliar"]);
					$this->idcuenta_mayor_auxiliar->setQueryStringValue($GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->QueryStringValue);
					$this->idcuenta_mayor_auxiliar->setSessionValue($this->idcuenta_mayor_auxiliar->QueryStringValue);
					if (!is_numeric($GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "cuenta_mayor_auxiliar") {
				if ($this->idcuenta_mayor_auxiliar->QueryStringValue == "") $this->idcuenta_mayor_auxiliar->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = ew_CurrentUrl();
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
if (!isset($subcuenta_list)) $subcuenta_list = new csubcuenta_list();

// Page init
$subcuenta_list->Page_Init();

// Page main
$subcuenta_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subcuenta_list->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var subcuenta_list = new ew_Page("subcuenta_list");
subcuenta_list.PageID = "list"; // Page ID
var EW_PAGE_ID = subcuenta_list.PageID; // For backward compatibility

// Form object
var fsubcuentalist = new ew_Form("fsubcuentalist");
fsubcuentalist.FormKeyCountName = '<?php echo $subcuenta_list->FormKeyCountName ?>';

// Validate form
fsubcuentalist.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
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
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nomeclatura->FldCaption(), $subcuenta->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nombre->FldCaption(), $subcuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->idcuenta_mayor_auxiliar->FldCaption(), $subcuenta->idcuenta_mayor_auxiliar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($subcuenta->idcuenta_mayor_auxiliar->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fsubcuentalist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "nomeclatura", false)) return false;
	if (ew_ValueChanged(fobj, infix, "nombre", false)) return false;
	if (ew_ValueChanged(fobj, infix, "idcuenta_mayor_auxiliar", false)) return false;
	return true;
}

// Form_CustomValidate event
fsubcuentalist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubcuentalist.ValidateRequired = true;
<?php } else { ?>
fsubcuentalist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

var fsubcuentalistsrch = new ew_Form("fsubcuentalistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($subcuenta_list->TotalRecs > 0 && $subcuenta->getCurrentMasterTable() == "" && $subcuenta_list->ExportOptions->Visible()) { ?>
<?php $subcuenta_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($subcuenta_list->SearchOptions->Visible()) { ?>
<?php $subcuenta_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php if (($subcuenta->Export == "") || (EW_EXPORT_MASTER_RECORD && $subcuenta->Export == "print")) { ?>
<?php
$gsMasterReturnUrl = "cuenta_mayor_auxiliarlist.php";
if ($subcuenta_list->DbMasterFilter <> "" && $subcuenta->getCurrentMasterTable() == "cuenta_mayor_auxiliar") {
	if ($subcuenta_list->MasterRecordExists) {
		if ($subcuenta->getCurrentMasterTable() == $subcuenta->TableVar) $gsMasterReturnUrl .= "?" . EW_TABLE_SHOW_MASTER . "=";
?>
<?php if ($subcuenta_list->ExportOptions->Visible()) { ?>
<div class="ewListExportOptions"><?php $subcuenta_list->ExportOptions->Render("body") ?></div>
<?php } ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_mayor_auxiliarmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($subcuenta->CurrentAction == "gridadd") {
	$subcuenta->CurrentFilter = "0=1";
	$subcuenta_list->StartRec = 1;
	$subcuenta_list->DisplayRecs = $subcuenta->GridAddRowCount;
	$subcuenta_list->TotalRecs = $subcuenta_list->DisplayRecs;
	$subcuenta_list->StopRec = $subcuenta_list->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$subcuenta_list->TotalRecs = $subcuenta->SelectRecordCount();
	} else {
		if ($subcuenta_list->Recordset = $subcuenta_list->LoadRecordset())
			$subcuenta_list->TotalRecs = $subcuenta_list->Recordset->RecordCount();
	}
	$subcuenta_list->StartRec = 1;
	if ($subcuenta_list->DisplayRecs <= 0 || ($subcuenta->Export <> "" && $subcuenta->ExportAll)) // Display all records
		$subcuenta_list->DisplayRecs = $subcuenta_list->TotalRecs;
	if (!($subcuenta->Export <> "" && $subcuenta->ExportAll))
		$subcuenta_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$subcuenta_list->Recordset = $subcuenta_list->LoadRecordset($subcuenta_list->StartRec-1, $subcuenta_list->DisplayRecs);

	// Set no record found message
	if ($subcuenta->CurrentAction == "" && $subcuenta_list->TotalRecs == 0) {
		if ($subcuenta_list->SearchWhere == "0=101")
			$subcuenta_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$subcuenta_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$subcuenta_list->RenderOtherOptions();
?>
<?php if ($subcuenta->Export == "" && $subcuenta->CurrentAction == "") { ?>
<form name="fsubcuentalistsrch" id="fsubcuentalistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($subcuenta_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fsubcuentalistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="subcuenta">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($subcuenta_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($subcuenta_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $subcuenta_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($subcuenta_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($subcuenta_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($subcuenta_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($subcuenta_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $subcuenta_list->ShowPageHeader(); ?>
<?php
$subcuenta_list->ShowMessage();
?>
<?php if ($subcuenta_list->TotalRecs > 0 || $subcuenta->CurrentAction <> "") { ?>
<div class="ewGrid">
<form name="fsubcuentalist" id="fsubcuentalist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($subcuenta_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $subcuenta_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="subcuenta">
<div id="gmp_subcuenta" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($subcuenta_list->TotalRecs > 0) { ?>
<table id="tbl_subcuentalist" class="table ewTable">
<?php echo $subcuenta->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$subcuenta_list->RenderListOptions();

// Render list options (header, left)
$subcuenta_list->ListOptions->Render("header", "left");
?>
<?php if ($subcuenta->nomeclatura->Visible) { // nomeclatura ?>
	<?php if ($subcuenta->SortUrl($subcuenta->nomeclatura) == "") { ?>
		<th data-name="nomeclatura"><div id="elh_subcuenta_nomeclatura" class="subcuenta_nomeclatura"><div class="ewTableHeaderCaption"><?php echo $subcuenta->nomeclatura->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nomeclatura"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subcuenta->SortUrl($subcuenta->nomeclatura) ?>',1);"><div id="elh_subcuenta_nomeclatura" class="subcuenta_nomeclatura">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->nomeclatura->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->nomeclatura->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->nomeclatura->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subcuenta->nombre->Visible) { // nombre ?>
	<?php if ($subcuenta->SortUrl($subcuenta->nombre) == "") { ?>
		<th data-name="nombre"><div id="elh_subcuenta_nombre" class="subcuenta_nombre"><div class="ewTableHeaderCaption"><?php echo $subcuenta->nombre->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="nombre"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subcuenta->SortUrl($subcuenta->nombre) ?>',1);"><div id="elh_subcuenta_nombre" class="subcuenta_nombre">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->nombre->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->nombre->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->nombre->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
	<?php if ($subcuenta->SortUrl($subcuenta->idcuenta_mayor_auxiliar) == "") { ?>
		<th data-name="idcuenta_mayor_auxiliar"><div id="elh_subcuenta_idcuenta_mayor_auxiliar" class="subcuenta_idcuenta_mayor_auxiliar"><div class="ewTableHeaderCaption"><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idcuenta_mayor_auxiliar"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $subcuenta->SortUrl($subcuenta->idcuenta_mayor_auxiliar) ?>',1);"><div id="elh_subcuenta_idcuenta_mayor_auxiliar" class="subcuenta_idcuenta_mayor_auxiliar">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($subcuenta->idcuenta_mayor_auxiliar->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($subcuenta->idcuenta_mayor_auxiliar->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$subcuenta_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($subcuenta->ExportAll && $subcuenta->Export <> "") {
	$subcuenta_list->StopRec = $subcuenta_list->TotalRecs;
} else {

	// Set the last record to display
	if ($subcuenta_list->TotalRecs > $subcuenta_list->StartRec + $subcuenta_list->DisplayRecs - 1)
		$subcuenta_list->StopRec = $subcuenta_list->StartRec + $subcuenta_list->DisplayRecs - 1;
	else
		$subcuenta_list->StopRec = $subcuenta_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($subcuenta_list->FormKeyCountName) && ($subcuenta->CurrentAction == "gridadd" || $subcuenta->CurrentAction == "gridedit" || $subcuenta->CurrentAction == "F")) {
		$subcuenta_list->KeyCount = $objForm->GetValue($subcuenta_list->FormKeyCountName);
		$subcuenta_list->StopRec = $subcuenta_list->StartRec + $subcuenta_list->KeyCount - 1;
	}
}
$subcuenta_list->RecCnt = $subcuenta_list->StartRec - 1;
if ($subcuenta_list->Recordset && !$subcuenta_list->Recordset->EOF) {
	$subcuenta_list->Recordset->MoveFirst();
	$bSelectLimit = EW_SELECT_LIMIT;
	if (!$bSelectLimit && $subcuenta_list->StartRec > 1)
		$subcuenta_list->Recordset->Move($subcuenta_list->StartRec - 1);
} elseif (!$subcuenta->AllowAddDeleteRow && $subcuenta_list->StopRec == 0) {
	$subcuenta_list->StopRec = $subcuenta->GridAddRowCount;
}

// Initialize aggregate
$subcuenta->RowType = EW_ROWTYPE_AGGREGATEINIT;
$subcuenta->ResetAttrs();
$subcuenta_list->RenderRow();
if ($subcuenta->CurrentAction == "gridadd")
	$subcuenta_list->RowIndex = 0;
if ($subcuenta->CurrentAction == "gridedit")
	$subcuenta_list->RowIndex = 0;
while ($subcuenta_list->RecCnt < $subcuenta_list->StopRec) {
	$subcuenta_list->RecCnt++;
	if (intval($subcuenta_list->RecCnt) >= intval($subcuenta_list->StartRec)) {
		$subcuenta_list->RowCnt++;
		if ($subcuenta->CurrentAction == "gridadd" || $subcuenta->CurrentAction == "gridedit" || $subcuenta->CurrentAction == "F") {
			$subcuenta_list->RowIndex++;
			$objForm->Index = $subcuenta_list->RowIndex;
			if ($objForm->HasValue($subcuenta_list->FormActionName))
				$subcuenta_list->RowAction = strval($objForm->GetValue($subcuenta_list->FormActionName));
			elseif ($subcuenta->CurrentAction == "gridadd")
				$subcuenta_list->RowAction = "insert";
			else
				$subcuenta_list->RowAction = "";
		}

		// Set up key count
		$subcuenta_list->KeyCount = $subcuenta_list->RowIndex;

		// Init row class and style
		$subcuenta->ResetAttrs();
		$subcuenta->CssClass = "";
		if ($subcuenta->CurrentAction == "gridadd") {
			$subcuenta_list->LoadDefaultValues(); // Load default values
		} else {
			$subcuenta_list->LoadRowValues($subcuenta_list->Recordset); // Load row values
		}
		$subcuenta->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($subcuenta->CurrentAction == "gridadd") // Grid add
			$subcuenta->RowType = EW_ROWTYPE_ADD; // Render add
		if ($subcuenta->CurrentAction == "gridadd" && $subcuenta->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$subcuenta_list->RestoreCurrentRowFormValues($subcuenta_list->RowIndex); // Restore form values
		if ($subcuenta->CurrentAction == "gridedit") { // Grid edit
			if ($subcuenta->EventCancelled) {
				$subcuenta_list->RestoreCurrentRowFormValues($subcuenta_list->RowIndex); // Restore form values
			}
			if ($subcuenta_list->RowAction == "insert")
				$subcuenta->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$subcuenta->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($subcuenta->CurrentAction == "gridedit" && ($subcuenta->RowType == EW_ROWTYPE_EDIT || $subcuenta->RowType == EW_ROWTYPE_ADD) && $subcuenta->EventCancelled) // Update failed
			$subcuenta_list->RestoreCurrentRowFormValues($subcuenta_list->RowIndex); // Restore form values
		if ($subcuenta->RowType == EW_ROWTYPE_EDIT) // Edit row
			$subcuenta_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$subcuenta->RowAttrs = array_merge($subcuenta->RowAttrs, array('data-rowindex'=>$subcuenta_list->RowCnt, 'id'=>'r' . $subcuenta_list->RowCnt . '_subcuenta', 'data-rowtype'=>$subcuenta->RowType));

		// Render row
		$subcuenta_list->RenderRow();

		// Render list options
		$subcuenta_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($subcuenta_list->RowAction <> "delete" && $subcuenta_list->RowAction <> "insertdelete" && !($subcuenta_list->RowAction == "insert" && $subcuenta->CurrentAction == "F" && $subcuenta_list->EmptyRow())) {
?>
	<tr<?php echo $subcuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subcuenta_list->ListOptions->Render("body", "left", $subcuenta_list->RowCnt);
?>
	<?php if ($subcuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td data-name="nomeclatura"<?php echo $subcuenta->nomeclatura->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_nomeclatura" class="form-group subcuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" id="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subcuenta->nomeclatura->EditValue ?>"<?php echo $subcuenta->nomeclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" id="o<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomeclatura->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_nomeclatura" class="form-group subcuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" id="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subcuenta->nomeclatura->EditValue ?>"<?php echo $subcuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subcuenta->nomeclatura->ViewAttributes() ?>>
<?php echo $subcuenta->nomeclatura->ListViewValue() ?></span>
<?php } ?>
<a id="<?php echo $subcuenta_list->PageObjName . "_row_" . $subcuenta_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-field="x_idsubcuenta" name="x<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" id="x<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->CurrentValue) ?>">
<input type="hidden" data-field="x_idsubcuenta" name="o<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" id="o<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT || $subcuenta->CurrentMode == "edit") { ?>
<input type="hidden" data-field="x_idsubcuenta" name="x<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" id="x<?php echo $subcuenta_list->RowIndex ?>_idsubcuenta" value="<?php echo ew_HtmlEncode($subcuenta->idsubcuenta->CurrentValue) ?>">
<?php } ?>
	<?php if ($subcuenta->nombre->Visible) { // nombre ?>
		<td data-name="nombre"<?php echo $subcuenta->nombre->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subcuenta_list->RowIndex ?>_nombre" id="x<?php echo $subcuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->PlaceHolder) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $subcuenta_list->RowIndex ?>_nombre" id="o<?php echo $subcuenta_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subcuenta_list->RowIndex ?>_nombre" id="x<?php echo $subcuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->PlaceHolder) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subcuenta->nombre->ViewAttributes() ?>>
<?php echo $subcuenta->nombre->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
		<td data-name="idcuenta_mayor_auxiliar"<?php echo $subcuenta->idcuenta_mayor_auxiliar->CellAttributes() ?>>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->PlaceHolder) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->OldValue) ?>">
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $subcuenta_list->RowCnt ?>_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->PlaceHolder) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<?php } ?>
<?php if ($subcuenta->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<?php echo $subcuenta->idcuenta_mayor_auxiliar->ListViewValue() ?></span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subcuenta_list->ListOptions->Render("body", "right", $subcuenta_list->RowCnt);
?>
	</tr>
<?php if ($subcuenta->RowType == EW_ROWTYPE_ADD || $subcuenta->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fsubcuentalist.UpdateOpts(<?php echo $subcuenta_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($subcuenta->CurrentAction <> "gridadd")
		if (!$subcuenta_list->Recordset->EOF) $subcuenta_list->Recordset->MoveNext();
}
?>
<?php
	if ($subcuenta->CurrentAction == "gridadd" || $subcuenta->CurrentAction == "gridedit") {
		$subcuenta_list->RowIndex = '$rowindex$';
		$subcuenta_list->LoadDefaultValues();

		// Set row properties
		$subcuenta->ResetAttrs();
		$subcuenta->RowAttrs = array_merge($subcuenta->RowAttrs, array('data-rowindex'=>$subcuenta_list->RowIndex, 'id'=>'r0_subcuenta', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($subcuenta->RowAttrs["class"], "ewTemplate");
		$subcuenta->RowType = EW_ROWTYPE_ADD;

		// Render row
		$subcuenta_list->RenderRow();

		// Render list options
		$subcuenta_list->RenderListOptions();
		$subcuenta_list->StartRowCnt = 0;
?>
	<tr<?php echo $subcuenta->RowAttributes() ?>>
<?php

// Render list options (body, left)
$subcuenta_list->ListOptions->Render("body", "left", $subcuenta_list->RowIndex);
?>
	<?php if ($subcuenta->nomeclatura->Visible) { // nomeclatura ?>
		<td>
<span id="el$rowindex$_subcuenta_nomeclatura" class="form-group subcuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" id="x<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $subcuenta->nomeclatura->EditValue ?>"<?php echo $subcuenta->nomeclatura->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nomeclatura" name="o<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" id="o<?php echo $subcuenta_list->RowIndex ?>_nomeclatura" value="<?php echo ew_HtmlEncode($subcuenta->nomeclatura->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subcuenta->nombre->Visible) { // nombre ?>
		<td>
<span id="el$rowindex$_subcuenta_nombre" class="form-group subcuenta_nombre">
<input type="text" data-field="x_nombre" name="x<?php echo $subcuenta_list->RowIndex ?>_nombre" id="x<?php echo $subcuenta_list->RowIndex ?>_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->PlaceHolder) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<input type="hidden" data-field="x_nombre" name="o<?php echo $subcuenta_list->RowIndex ?>_nombre" id="o<?php echo $subcuenta_list->RowIndex ?>_nombre" value="<?php echo ew_HtmlEncode($subcuenta->nombre->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
		<td>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el$rowindex$_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_subcuenta_idcuenta_mayor_auxiliar" class="form-group subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-field="x_idcuenta_mayor_auxiliar" name="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="x<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->PlaceHolder) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-field="x_idcuenta_mayor_auxiliar" name="o<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" id="o<?php echo $subcuenta_list->RowIndex ?>_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$subcuenta_list->ListOptions->Render("body", "right", $subcuenta_list->RowCnt);
?>
<script type="text/javascript">
fsubcuentalist.UpdateOpts(<?php echo $subcuenta_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($subcuenta->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $subcuenta_list->FormKeyCountName ?>" id="<?php echo $subcuenta_list->FormKeyCountName ?>" value="<?php echo $subcuenta_list->KeyCount ?>">
<?php echo $subcuenta_list->MultiSelectKey ?>
<?php } ?>
<?php if ($subcuenta->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $subcuenta_list->FormKeyCountName ?>" id="<?php echo $subcuenta_list->FormKeyCountName ?>" value="<?php echo $subcuenta_list->KeyCount ?>">
<?php echo $subcuenta_list->MultiSelectKey ?>
<?php } ?>
<?php if ($subcuenta->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($subcuenta_list->Recordset)
	$subcuenta_list->Recordset->Close();
?>
<div class="ewGridLowerPanel">
<?php if ($subcuenta->CurrentAction <> "gridadd" && $subcuenta->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($subcuenta_list->Pager)) $subcuenta_list->Pager = new cPrevNextPager($subcuenta_list->StartRec, $subcuenta_list->DisplayRecs, $subcuenta_list->TotalRecs) ?>
<?php if ($subcuenta_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($subcuenta_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $subcuenta_list->PageUrl() ?>start=<?php echo $subcuenta_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($subcuenta_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $subcuenta_list->PageUrl() ?>start=<?php echo $subcuenta_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $subcuenta_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($subcuenta_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $subcuenta_list->PageUrl() ?>start=<?php echo $subcuenta_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($subcuenta_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $subcuenta_list->PageUrl() ?>start=<?php echo $subcuenta_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $subcuenta_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $subcuenta_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $subcuenta_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $subcuenta_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subcuenta_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($subcuenta_list->TotalRecs == 0 && $subcuenta->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($subcuenta_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fsubcuentalistsrch.Init();
fsubcuentalist.Init();
</script>
<?php
$subcuenta_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$subcuenta_list->Page_Terminate();
?>
