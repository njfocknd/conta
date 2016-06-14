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

$estado_resultado_list = NULL; // Initialize page object first

class cestado_resultado_list extends cestado_resultado {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'estado_resultado';

	// Page object name
	var $PageObjName = 'estado_resultado_list';

	// Grid form hidden field names
	var $FormName = 'festado_resultadolist';
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

		// Table object (estado_resultado)
		if (!isset($GLOBALS["estado_resultado"]) || get_class($GLOBALS["estado_resultado"]) == "cestado_resultado") {
			$GLOBALS["estado_resultado"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_resultado"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "estado_resultadoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "estado_resultadodelete.php";
		$this->MultiUpdateUrl = "estado_resultadoupdate.php";

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_resultado', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption festado_resultadolistsrch";

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

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Restore filter list
			$this->RestoreFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
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

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
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
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

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
			$this->idestado_resultado->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->idestado_resultado->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->idestado_resultado->AdvancedSearch->ToJSON(), ","); // Field idestado_resultado
		$sFilterList = ew_Concat($sFilterList, $this->idempresa->AdvancedSearch->ToJSON(), ","); // Field idempresa
		$sFilterList = ew_Concat($sFilterList, $this->idperiodo_contable->AdvancedSearch->ToJSON(), ","); // Field idperiodo_contable
		$sFilterList = ew_Concat($sFilterList, $this->venta_netas->AdvancedSearch->ToJSON(), ","); // Field venta_netas
		$sFilterList = ew_Concat($sFilterList, $this->costo_ventas->AdvancedSearch->ToJSON(), ","); // Field costo_ventas
		$sFilterList = ew_Concat($sFilterList, $this->depreciacion->AdvancedSearch->ToJSON(), ","); // Field depreciacion
		$sFilterList = ew_Concat($sFilterList, $this->interes_pagado->AdvancedSearch->ToJSON(), ","); // Field interes_pagado
		$sFilterList = ew_Concat($sFilterList, $this->utilidad_gravable->AdvancedSearch->ToJSON(), ","); // Field utilidad_gravable
		$sFilterList = ew_Concat($sFilterList, $this->impuestos->AdvancedSearch->ToJSON(), ","); // Field impuestos
		$sFilterList = ew_Concat($sFilterList, $this->utilidad_neta->AdvancedSearch->ToJSON(), ","); // Field utilidad_neta
		$sFilterList = ew_Concat($sFilterList, $this->dividendos->AdvancedSearch->ToJSON(), ","); // Field dividendos
		$sFilterList = ew_Concat($sFilterList, $this->utilidades_retenidas->AdvancedSearch->ToJSON(), ","); // Field utilidades_retenidas
		$sFilterList = ew_Concat($sFilterList, $this->estado->AdvancedSearch->ToJSON(), ","); // Field estado

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

		// Field idestado_resultado
		$this->idestado_resultado->AdvancedSearch->SearchValue = @$filter["x_idestado_resultado"];
		$this->idestado_resultado->AdvancedSearch->SearchOperator = @$filter["z_idestado_resultado"];
		$this->idestado_resultado->AdvancedSearch->SearchCondition = @$filter["v_idestado_resultado"];
		$this->idestado_resultado->AdvancedSearch->SearchValue2 = @$filter["y_idestado_resultado"];
		$this->idestado_resultado->AdvancedSearch->SearchOperator2 = @$filter["w_idestado_resultado"];
		$this->idestado_resultado->AdvancedSearch->Save();

		// Field idempresa
		$this->idempresa->AdvancedSearch->SearchValue = @$filter["x_idempresa"];
		$this->idempresa->AdvancedSearch->SearchOperator = @$filter["z_idempresa"];
		$this->idempresa->AdvancedSearch->SearchCondition = @$filter["v_idempresa"];
		$this->idempresa->AdvancedSearch->SearchValue2 = @$filter["y_idempresa"];
		$this->idempresa->AdvancedSearch->SearchOperator2 = @$filter["w_idempresa"];
		$this->idempresa->AdvancedSearch->Save();

		// Field idperiodo_contable
		$this->idperiodo_contable->AdvancedSearch->SearchValue = @$filter["x_idperiodo_contable"];
		$this->idperiodo_contable->AdvancedSearch->SearchOperator = @$filter["z_idperiodo_contable"];
		$this->idperiodo_contable->AdvancedSearch->SearchCondition = @$filter["v_idperiodo_contable"];
		$this->idperiodo_contable->AdvancedSearch->SearchValue2 = @$filter["y_idperiodo_contable"];
		$this->idperiodo_contable->AdvancedSearch->SearchOperator2 = @$filter["w_idperiodo_contable"];
		$this->idperiodo_contable->AdvancedSearch->Save();

		// Field venta_netas
		$this->venta_netas->AdvancedSearch->SearchValue = @$filter["x_venta_netas"];
		$this->venta_netas->AdvancedSearch->SearchOperator = @$filter["z_venta_netas"];
		$this->venta_netas->AdvancedSearch->SearchCondition = @$filter["v_venta_netas"];
		$this->venta_netas->AdvancedSearch->SearchValue2 = @$filter["y_venta_netas"];
		$this->venta_netas->AdvancedSearch->SearchOperator2 = @$filter["w_venta_netas"];
		$this->venta_netas->AdvancedSearch->Save();

		// Field costo_ventas
		$this->costo_ventas->AdvancedSearch->SearchValue = @$filter["x_costo_ventas"];
		$this->costo_ventas->AdvancedSearch->SearchOperator = @$filter["z_costo_ventas"];
		$this->costo_ventas->AdvancedSearch->SearchCondition = @$filter["v_costo_ventas"];
		$this->costo_ventas->AdvancedSearch->SearchValue2 = @$filter["y_costo_ventas"];
		$this->costo_ventas->AdvancedSearch->SearchOperator2 = @$filter["w_costo_ventas"];
		$this->costo_ventas->AdvancedSearch->Save();

		// Field depreciacion
		$this->depreciacion->AdvancedSearch->SearchValue = @$filter["x_depreciacion"];
		$this->depreciacion->AdvancedSearch->SearchOperator = @$filter["z_depreciacion"];
		$this->depreciacion->AdvancedSearch->SearchCondition = @$filter["v_depreciacion"];
		$this->depreciacion->AdvancedSearch->SearchValue2 = @$filter["y_depreciacion"];
		$this->depreciacion->AdvancedSearch->SearchOperator2 = @$filter["w_depreciacion"];
		$this->depreciacion->AdvancedSearch->Save();

		// Field interes_pagado
		$this->interes_pagado->AdvancedSearch->SearchValue = @$filter["x_interes_pagado"];
		$this->interes_pagado->AdvancedSearch->SearchOperator = @$filter["z_interes_pagado"];
		$this->interes_pagado->AdvancedSearch->SearchCondition = @$filter["v_interes_pagado"];
		$this->interes_pagado->AdvancedSearch->SearchValue2 = @$filter["y_interes_pagado"];
		$this->interes_pagado->AdvancedSearch->SearchOperator2 = @$filter["w_interes_pagado"];
		$this->interes_pagado->AdvancedSearch->Save();

		// Field utilidad_gravable
		$this->utilidad_gravable->AdvancedSearch->SearchValue = @$filter["x_utilidad_gravable"];
		$this->utilidad_gravable->AdvancedSearch->SearchOperator = @$filter["z_utilidad_gravable"];
		$this->utilidad_gravable->AdvancedSearch->SearchCondition = @$filter["v_utilidad_gravable"];
		$this->utilidad_gravable->AdvancedSearch->SearchValue2 = @$filter["y_utilidad_gravable"];
		$this->utilidad_gravable->AdvancedSearch->SearchOperator2 = @$filter["w_utilidad_gravable"];
		$this->utilidad_gravable->AdvancedSearch->Save();

		// Field impuestos
		$this->impuestos->AdvancedSearch->SearchValue = @$filter["x_impuestos"];
		$this->impuestos->AdvancedSearch->SearchOperator = @$filter["z_impuestos"];
		$this->impuestos->AdvancedSearch->SearchCondition = @$filter["v_impuestos"];
		$this->impuestos->AdvancedSearch->SearchValue2 = @$filter["y_impuestos"];
		$this->impuestos->AdvancedSearch->SearchOperator2 = @$filter["w_impuestos"];
		$this->impuestos->AdvancedSearch->Save();

		// Field utilidad_neta
		$this->utilidad_neta->AdvancedSearch->SearchValue = @$filter["x_utilidad_neta"];
		$this->utilidad_neta->AdvancedSearch->SearchOperator = @$filter["z_utilidad_neta"];
		$this->utilidad_neta->AdvancedSearch->SearchCondition = @$filter["v_utilidad_neta"];
		$this->utilidad_neta->AdvancedSearch->SearchValue2 = @$filter["y_utilidad_neta"];
		$this->utilidad_neta->AdvancedSearch->SearchOperator2 = @$filter["w_utilidad_neta"];
		$this->utilidad_neta->AdvancedSearch->Save();

		// Field dividendos
		$this->dividendos->AdvancedSearch->SearchValue = @$filter["x_dividendos"];
		$this->dividendos->AdvancedSearch->SearchOperator = @$filter["z_dividendos"];
		$this->dividendos->AdvancedSearch->SearchCondition = @$filter["v_dividendos"];
		$this->dividendos->AdvancedSearch->SearchValue2 = @$filter["y_dividendos"];
		$this->dividendos->AdvancedSearch->SearchOperator2 = @$filter["w_dividendos"];
		$this->dividendos->AdvancedSearch->Save();

		// Field utilidades_retenidas
		$this->utilidades_retenidas->AdvancedSearch->SearchValue = @$filter["x_utilidades_retenidas"];
		$this->utilidades_retenidas->AdvancedSearch->SearchOperator = @$filter["z_utilidades_retenidas"];
		$this->utilidades_retenidas->AdvancedSearch->SearchCondition = @$filter["v_utilidades_retenidas"];
		$this->utilidades_retenidas->AdvancedSearch->SearchValue2 = @$filter["y_utilidades_retenidas"];
		$this->utilidades_retenidas->AdvancedSearch->SearchOperator2 = @$filter["w_utilidades_retenidas"];
		$this->utilidades_retenidas->AdvancedSearch->Save();

		// Field estado
		$this->estado->AdvancedSearch->SearchValue = @$filter["x_estado"];
		$this->estado->AdvancedSearch->SearchOperator = @$filter["z_estado"];
		$this->estado->AdvancedSearch->SearchCondition = @$filter["v_estado"];
		$this->estado->AdvancedSearch->SearchValue2 = @$filter["y_estado"];
		$this->estado->AdvancedSearch->SearchOperator2 = @$filter["w_estado"];
		$this->estado->AdvancedSearch->Save();
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		$this->BuildSearchSql($sWhere, $this->idestado_resultado, $Default, FALSE); // idestado_resultado
		$this->BuildSearchSql($sWhere, $this->idempresa, $Default, FALSE); // idempresa
		$this->BuildSearchSql($sWhere, $this->idperiodo_contable, $Default, FALSE); // idperiodo_contable
		$this->BuildSearchSql($sWhere, $this->venta_netas, $Default, FALSE); // venta_netas
		$this->BuildSearchSql($sWhere, $this->costo_ventas, $Default, FALSE); // costo_ventas
		$this->BuildSearchSql($sWhere, $this->depreciacion, $Default, FALSE); // depreciacion
		$this->BuildSearchSql($sWhere, $this->interes_pagado, $Default, FALSE); // interes_pagado
		$this->BuildSearchSql($sWhere, $this->utilidad_gravable, $Default, FALSE); // utilidad_gravable
		$this->BuildSearchSql($sWhere, $this->impuestos, $Default, FALSE); // impuestos
		$this->BuildSearchSql($sWhere, $this->utilidad_neta, $Default, FALSE); // utilidad_neta
		$this->BuildSearchSql($sWhere, $this->dividendos, $Default, FALSE); // dividendos
		$this->BuildSearchSql($sWhere, $this->utilidades_retenidas, $Default, FALSE); // utilidades_retenidas
		$this->BuildSearchSql($sWhere, $this->estado, $Default, FALSE); // estado

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->idestado_resultado->AdvancedSearch->Save(); // idestado_resultado
			$this->idempresa->AdvancedSearch->Save(); // idempresa
			$this->idperiodo_contable->AdvancedSearch->Save(); // idperiodo_contable
			$this->venta_netas->AdvancedSearch->Save(); // venta_netas
			$this->costo_ventas->AdvancedSearch->Save(); // costo_ventas
			$this->depreciacion->AdvancedSearch->Save(); // depreciacion
			$this->interes_pagado->AdvancedSearch->Save(); // interes_pagado
			$this->utilidad_gravable->AdvancedSearch->Save(); // utilidad_gravable
			$this->impuestos->AdvancedSearch->Save(); // impuestos
			$this->utilidad_neta->AdvancedSearch->Save(); // utilidad_neta
			$this->dividendos->AdvancedSearch->Save(); // dividendos
			$this->utilidades_retenidas->AdvancedSearch->Save(); // utilidades_retenidas
			$this->estado->AdvancedSearch->Save(); // estado
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Check if search parm exists
	function CheckSearchParms() {
		if ($this->idestado_resultado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->idempresa->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->idperiodo_contable->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->venta_netas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->costo_ventas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->depreciacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->interes_pagado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->utilidad_gravable->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->impuestos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->utilidad_neta->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->dividendos->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->utilidades_retenidas->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->estado->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->idestado_resultado->AdvancedSearch->UnsetSession();
		$this->idempresa->AdvancedSearch->UnsetSession();
		$this->idperiodo_contable->AdvancedSearch->UnsetSession();
		$this->venta_netas->AdvancedSearch->UnsetSession();
		$this->costo_ventas->AdvancedSearch->UnsetSession();
		$this->depreciacion->AdvancedSearch->UnsetSession();
		$this->interes_pagado->AdvancedSearch->UnsetSession();
		$this->utilidad_gravable->AdvancedSearch->UnsetSession();
		$this->impuestos->AdvancedSearch->UnsetSession();
		$this->utilidad_neta->AdvancedSearch->UnsetSession();
		$this->dividendos->AdvancedSearch->UnsetSession();
		$this->utilidades_retenidas->AdvancedSearch->UnsetSession();
		$this->estado->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore advanced search values
		$this->idestado_resultado->AdvancedSearch->Load();
		$this->idempresa->AdvancedSearch->Load();
		$this->idperiodo_contable->AdvancedSearch->Load();
		$this->venta_netas->AdvancedSearch->Load();
		$this->costo_ventas->AdvancedSearch->Load();
		$this->depreciacion->AdvancedSearch->Load();
		$this->interes_pagado->AdvancedSearch->Load();
		$this->utilidad_gravable->AdvancedSearch->Load();
		$this->impuestos->AdvancedSearch->Load();
		$this->utilidad_neta->AdvancedSearch->Load();
		$this->dividendos->AdvancedSearch->Load();
		$this->utilidades_retenidas->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->idestado_resultado); // idestado_resultado
			$this->UpdateSort($this->idempresa); // idempresa
			$this->UpdateSort($this->idperiodo_contable); // idperiodo_contable
			$this->UpdateSort($this->venta_netas); // venta_netas
			$this->UpdateSort($this->costo_ventas); // costo_ventas
			$this->UpdateSort($this->depreciacion); // depreciacion
			$this->UpdateSort($this->interes_pagado); // interes_pagado
			$this->UpdateSort($this->utilidad_gravable); // utilidad_gravable
			$this->UpdateSort($this->impuestos); // impuestos
			$this->UpdateSort($this->utilidad_neta); // utilidad_neta
			$this->UpdateSort($this->dividendos); // dividendos
			$this->UpdateSort($this->utilidades_retenidas); // utilidades_retenidas
			$this->UpdateSort($this->estado); // estado
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

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->idestado_resultado->setSort("");
				$this->idempresa->setSort("");
				$this->idperiodo_contable->setSort("");
				$this->venta_netas->setSort("");
				$this->costo_ventas->setSort("");
				$this->depreciacion->setSort("");
				$this->interes_pagado->setSort("");
				$this->utilidad_gravable->setSort("");
				$this->impuestos->setSort("");
				$this->utilidad_neta->setSort("");
				$this->dividendos->setSort("");
				$this->utilidades_retenidas->setSort("");
				$this->estado->setSort("");
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

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = TRUE;
		$item->OnLeft = TRUE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
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

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if (TRUE)
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->idestado_resultado->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"festado_resultadolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"festado_resultadolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.festado_resultadolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"festado_resultadolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
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

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// idestado_resultado

		$this->idestado_resultado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idestado_resultado"]);
		if ($this->idestado_resultado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idestado_resultado->AdvancedSearch->SearchOperator = @$_GET["z_idestado_resultado"];

		// idempresa
		$this->idempresa->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idempresa"]);
		if ($this->idempresa->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idempresa->AdvancedSearch->SearchOperator = @$_GET["z_idempresa"];

		// idperiodo_contable
		$this->idperiodo_contable->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_idperiodo_contable"]);
		if ($this->idperiodo_contable->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->idperiodo_contable->AdvancedSearch->SearchOperator = @$_GET["z_idperiodo_contable"];

		// venta_netas
		$this->venta_netas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_venta_netas"]);
		if ($this->venta_netas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->venta_netas->AdvancedSearch->SearchOperator = @$_GET["z_venta_netas"];

		// costo_ventas
		$this->costo_ventas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_costo_ventas"]);
		if ($this->costo_ventas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->costo_ventas->AdvancedSearch->SearchOperator = @$_GET["z_costo_ventas"];

		// depreciacion
		$this->depreciacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_depreciacion"]);
		if ($this->depreciacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->depreciacion->AdvancedSearch->SearchOperator = @$_GET["z_depreciacion"];

		// interes_pagado
		$this->interes_pagado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_interes_pagado"]);
		if ($this->interes_pagado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->interes_pagado->AdvancedSearch->SearchOperator = @$_GET["z_interes_pagado"];

		// utilidad_gravable
		$this->utilidad_gravable->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_utilidad_gravable"]);
		if ($this->utilidad_gravable->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->utilidad_gravable->AdvancedSearch->SearchOperator = @$_GET["z_utilidad_gravable"];

		// impuestos
		$this->impuestos->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_impuestos"]);
		if ($this->impuestos->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->impuestos->AdvancedSearch->SearchOperator = @$_GET["z_impuestos"];

		// utilidad_neta
		$this->utilidad_neta->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_utilidad_neta"]);
		if ($this->utilidad_neta->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->utilidad_neta->AdvancedSearch->SearchOperator = @$_GET["z_utilidad_neta"];

		// dividendos
		$this->dividendos->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_dividendos"]);
		if ($this->dividendos->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->dividendos->AdvancedSearch->SearchOperator = @$_GET["z_dividendos"];

		// utilidades_retenidas
		$this->utilidades_retenidas->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_utilidades_retenidas"]);
		if ($this->utilidades_retenidas->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->utilidades_retenidas->AdvancedSearch->SearchOperator = @$_GET["z_utilidades_retenidas"];

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_estado"]);
		if ($this->estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->estado->AdvancedSearch->SearchOperator = @$_GET["z_estado"];
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idestado_resultado")) <> "")
			$this->idestado_resultado->CurrentValue = $this->getKey("idestado_resultado"); // idestado_resultado
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
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idestado_resultado
			$this->idestado_resultado->EditAttrs["class"] = "form-control";
			$this->idestado_resultado->EditCustomAttributes = "";
			$this->idestado_resultado->EditValue = ew_HtmlEncode($this->idestado_resultado->AdvancedSearch->SearchValue);
			$this->idestado_resultado->PlaceHolder = ew_RemoveHtml($this->idestado_resultado->FldCaption());

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			$this->idempresa->EditValue = ew_HtmlEncode($this->idempresa->AdvancedSearch->SearchValue);
			$this->idempresa->PlaceHolder = ew_RemoveHtml($this->idempresa->FldCaption());

			// idperiodo_contable
			$this->idperiodo_contable->EditAttrs["class"] = "form-control";
			$this->idperiodo_contable->EditCustomAttributes = "";
			$this->idperiodo_contable->EditValue = ew_HtmlEncode($this->idperiodo_contable->AdvancedSearch->SearchValue);
			$this->idperiodo_contable->PlaceHolder = ew_RemoveHtml($this->idperiodo_contable->FldCaption());

			// venta_netas
			$this->venta_netas->EditAttrs["class"] = "form-control";
			$this->venta_netas->EditCustomAttributes = "";
			$this->venta_netas->EditValue = ew_HtmlEncode($this->venta_netas->AdvancedSearch->SearchValue);
			$this->venta_netas->PlaceHolder = ew_RemoveHtml($this->venta_netas->FldCaption());

			// costo_ventas
			$this->costo_ventas->EditAttrs["class"] = "form-control";
			$this->costo_ventas->EditCustomAttributes = "";
			$this->costo_ventas->EditValue = ew_HtmlEncode($this->costo_ventas->AdvancedSearch->SearchValue);
			$this->costo_ventas->PlaceHolder = ew_RemoveHtml($this->costo_ventas->FldCaption());

			// depreciacion
			$this->depreciacion->EditAttrs["class"] = "form-control";
			$this->depreciacion->EditCustomAttributes = "";
			$this->depreciacion->EditValue = ew_HtmlEncode($this->depreciacion->AdvancedSearch->SearchValue);
			$this->depreciacion->PlaceHolder = ew_RemoveHtml($this->depreciacion->FldCaption());

			// interes_pagado
			$this->interes_pagado->EditAttrs["class"] = "form-control";
			$this->interes_pagado->EditCustomAttributes = "";
			$this->interes_pagado->EditValue = ew_HtmlEncode($this->interes_pagado->AdvancedSearch->SearchValue);
			$this->interes_pagado->PlaceHolder = ew_RemoveHtml($this->interes_pagado->FldCaption());

			// utilidad_gravable
			$this->utilidad_gravable->EditAttrs["class"] = "form-control";
			$this->utilidad_gravable->EditCustomAttributes = "";
			$this->utilidad_gravable->EditValue = ew_HtmlEncode($this->utilidad_gravable->AdvancedSearch->SearchValue);
			$this->utilidad_gravable->PlaceHolder = ew_RemoveHtml($this->utilidad_gravable->FldCaption());

			// impuestos
			$this->impuestos->EditAttrs["class"] = "form-control";
			$this->impuestos->EditCustomAttributes = "";
			$this->impuestos->EditValue = ew_HtmlEncode($this->impuestos->AdvancedSearch->SearchValue);
			$this->impuestos->PlaceHolder = ew_RemoveHtml($this->impuestos->FldCaption());

			// utilidad_neta
			$this->utilidad_neta->EditAttrs["class"] = "form-control";
			$this->utilidad_neta->EditCustomAttributes = "";
			$this->utilidad_neta->EditValue = ew_HtmlEncode($this->utilidad_neta->AdvancedSearch->SearchValue);
			$this->utilidad_neta->PlaceHolder = ew_RemoveHtml($this->utilidad_neta->FldCaption());

			// dividendos
			$this->dividendos->EditAttrs["class"] = "form-control";
			$this->dividendos->EditCustomAttributes = "";
			$this->dividendos->EditValue = ew_HtmlEncode($this->dividendos->AdvancedSearch->SearchValue);
			$this->dividendos->PlaceHolder = ew_RemoveHtml($this->dividendos->FldCaption());

			// utilidades_retenidas
			$this->utilidades_retenidas->EditAttrs["class"] = "form-control";
			$this->utilidades_retenidas->EditCustomAttributes = "";
			$this->utilidades_retenidas->EditValue = ew_HtmlEncode($this->utilidades_retenidas->AdvancedSearch->SearchValue);
			$this->utilidades_retenidas->PlaceHolder = ew_RemoveHtml($this->utilidades_retenidas->FldCaption());

			// estado
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(FALSE);
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->idestado_resultado->AdvancedSearch->Load();
		$this->idempresa->AdvancedSearch->Load();
		$this->idperiodo_contable->AdvancedSearch->Load();
		$this->venta_netas->AdvancedSearch->Load();
		$this->costo_ventas->AdvancedSearch->Load();
		$this->depreciacion->AdvancedSearch->Load();
		$this->interes_pagado->AdvancedSearch->Load();
		$this->utilidad_gravable->AdvancedSearch->Load();
		$this->impuestos->AdvancedSearch->Load();
		$this->utilidad_neta->AdvancedSearch->Load();
		$this->dividendos->AdvancedSearch->Load();
		$this->utilidades_retenidas->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
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
if (!isset($estado_resultado_list)) $estado_resultado_list = new cestado_resultado_list();

// Page init
$estado_resultado_list->Page_Init();

// Page main
$estado_resultado_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = festado_resultadolist = new ew_Form("festado_resultadolist", "list");
festado_resultadolist.FormKeyCountName = '<?php echo $estado_resultado_list->FormKeyCountName ?>';

// Form_CustomValidate event
festado_resultadolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultadolist.ValidateRequired = true;
<?php } else { ?>
festado_resultadolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultadolist.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultadolist.Lists["x_estado"].Options = <?php echo json_encode($estado_resultado->estado->Options()) ?>;

// Form object for search
var CurrentSearchForm = festado_resultadolistsrch = new ew_Form("festado_resultadolistsrch");

// Validate function for search
festado_resultadolistsrch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}

// Form_CustomValidate event
festado_resultadolistsrch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultadolistsrch.ValidateRequired = true; // Use JavaScript validation
<?php } else { ?>
festado_resultadolistsrch.ValidateRequired = false; // No JavaScript validation
<?php } ?>

// Dynamic selection lists
festado_resultadolistsrch.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultadolistsrch.Lists["x_estado"].Options = <?php echo json_encode($estado_resultado->estado->Options()) ?>;
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php if ($estado_resultado_list->TotalRecs > 0 && $estado_resultado_list->ExportOptions->Visible()) { ?>
<?php $estado_resultado_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($estado_resultado_list->SearchOptions->Visible()) { ?>
<?php $estado_resultado_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($estado_resultado_list->FilterOptions->Visible()) { ?>
<?php $estado_resultado_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php
	$bSelectLimit = $estado_resultado_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($estado_resultado_list->TotalRecs <= 0)
			$estado_resultado_list->TotalRecs = $estado_resultado->SelectRecordCount();
	} else {
		if (!$estado_resultado_list->Recordset && ($estado_resultado_list->Recordset = $estado_resultado_list->LoadRecordset()))
			$estado_resultado_list->TotalRecs = $estado_resultado_list->Recordset->RecordCount();
	}
	$estado_resultado_list->StartRec = 1;
	if ($estado_resultado_list->DisplayRecs <= 0 || ($estado_resultado->Export <> "" && $estado_resultado->ExportAll)) // Display all records
		$estado_resultado_list->DisplayRecs = $estado_resultado_list->TotalRecs;
	if (!($estado_resultado->Export <> "" && $estado_resultado->ExportAll))
		$estado_resultado_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$estado_resultado_list->Recordset = $estado_resultado_list->LoadRecordset($estado_resultado_list->StartRec-1, $estado_resultado_list->DisplayRecs);

	// Set no record found message
	if ($estado_resultado->CurrentAction == "" && $estado_resultado_list->TotalRecs == 0) {
		if ($estado_resultado_list->SearchWhere == "0=101")
			$estado_resultado_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$estado_resultado_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$estado_resultado_list->RenderOtherOptions();
?>
<?php if ($estado_resultado->Export == "" && $estado_resultado->CurrentAction == "") { ?>
<form name="festado_resultadolistsrch" id="festado_resultadolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($estado_resultado_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="festado_resultadolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="estado_resultado">
	<div class="ewBasicSearch">
<?php
if ($gsSearchError == "")
	$estado_resultado_list->LoadAdvancedSearch(); // Load advanced search

// Render for search
$estado_resultado->RowType = EW_ROWTYPE_SEARCH;

// Render row
$estado_resultado->ResetAttrs();
$estado_resultado_list->RenderRow();
?>
<div id="xsr_1" class="ewRow">
<?php if ($estado_resultado->estado->Visible) { // estado ?>
	<div id="xsc_estado" class="ewCell form-group">
		<label class="ewSearchCaption ewLabel"><?php echo $estado_resultado->estado->FldCaption() ?></label>
		<span class="ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></span>
		<span class="ewSearchField">
<div id="tp_x_estado" class="ewTemplate"><input type="radio" data-table="estado_resultado" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado->estado->DisplayValueSeparator) ? json_encode($estado_resultado->estado->DisplayValueSeparator) : $estado_resultado->estado->DisplayValueSeparator) ?>" name="x_estado" id="x_estado" value="{value}"<?php echo $estado_resultado->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $estado_resultado->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($estado_resultado->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="estado_resultado" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $estado_resultado->estado->EditAttributes() ?>><?php echo $estado_resultado->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($estado_resultado->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="estado_resultado" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($estado_resultado->estado->CurrentValue) ?>" checked<?php echo $estado_resultado->estado->EditAttributes() ?>><?php echo $estado_resultado->estado->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
	</div>
<?php } ?>
</div>
<div id="xsr_2" class="ewRow">
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php $estado_resultado_list->ShowPageHeader(); ?>
<?php
$estado_resultado_list->ShowMessage();
?>
<?php if ($estado_resultado_list->TotalRecs > 0 || $estado_resultado->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid">
<div class="panel-heading ewGridUpperPanel">
<?php if ($estado_resultado->CurrentAction <> "gridadd" && $estado_resultado->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($estado_resultado_list->Pager)) $estado_resultado_list->Pager = new cPrevNextPager($estado_resultado_list->StartRec, $estado_resultado_list->DisplayRecs, $estado_resultado_list->TotalRecs) ?>
<?php if ($estado_resultado_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($estado_resultado_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($estado_resultado_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $estado_resultado_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($estado_resultado_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($estado_resultado_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $estado_resultado_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $estado_resultado_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $estado_resultado_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $estado_resultado_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($estado_resultado_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="festado_resultadolist" id="festado_resultadolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_resultado_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_resultado_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_resultado">
<div id="gmp_estado_resultado" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($estado_resultado_list->TotalRecs > 0) { ?>
<table id="tbl_estado_resultadolist" class="table ewTable">
<?php echo $estado_resultado->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$estado_resultado_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$estado_resultado_list->RenderListOptions();

// Render list options (header, left)
$estado_resultado_list->ListOptions->Render("header", "left");
?>
<?php if ($estado_resultado->idestado_resultado->Visible) { // idestado_resultado ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->idestado_resultado) == "") { ?>
		<th data-name="idestado_resultado"><div id="elh_estado_resultado_idestado_resultado" class="estado_resultado_idestado_resultado"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->idestado_resultado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idestado_resultado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->idestado_resultado) ?>',1);"><div id="elh_estado_resultado_idestado_resultado" class="estado_resultado_idestado_resultado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->idestado_resultado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->idestado_resultado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->idestado_resultado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->idempresa->Visible) { // idempresa ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->idempresa) == "") { ?>
		<th data-name="idempresa"><div id="elh_estado_resultado_idempresa" class="estado_resultado_idempresa"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->idempresa->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idempresa"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->idempresa) ?>',1);"><div id="elh_estado_resultado_idempresa" class="estado_resultado_idempresa">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->idempresa->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->idempresa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->idempresa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->idperiodo_contable) == "") { ?>
		<th data-name="idperiodo_contable"><div id="elh_estado_resultado_idperiodo_contable" class="estado_resultado_idperiodo_contable"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="idperiodo_contable"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->idperiodo_contable) ?>',1);"><div id="elh_estado_resultado_idperiodo_contable" class="estado_resultado_idperiodo_contable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->idperiodo_contable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->idperiodo_contable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->idperiodo_contable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->venta_netas->Visible) { // venta_netas ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->venta_netas) == "") { ?>
		<th data-name="venta_netas"><div id="elh_estado_resultado_venta_netas" class="estado_resultado_venta_netas"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->venta_netas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="venta_netas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->venta_netas) ?>',1);"><div id="elh_estado_resultado_venta_netas" class="estado_resultado_venta_netas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->venta_netas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->venta_netas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->venta_netas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->costo_ventas->Visible) { // costo_ventas ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->costo_ventas) == "") { ?>
		<th data-name="costo_ventas"><div id="elh_estado_resultado_costo_ventas" class="estado_resultado_costo_ventas"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->costo_ventas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="costo_ventas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->costo_ventas) ?>',1);"><div id="elh_estado_resultado_costo_ventas" class="estado_resultado_costo_ventas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->costo_ventas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->costo_ventas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->costo_ventas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->depreciacion->Visible) { // depreciacion ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->depreciacion) == "") { ?>
		<th data-name="depreciacion"><div id="elh_estado_resultado_depreciacion" class="estado_resultado_depreciacion"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->depreciacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="depreciacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->depreciacion) ?>',1);"><div id="elh_estado_resultado_depreciacion" class="estado_resultado_depreciacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->depreciacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->depreciacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->depreciacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->interes_pagado->Visible) { // interes_pagado ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->interes_pagado) == "") { ?>
		<th data-name="interes_pagado"><div id="elh_estado_resultado_interes_pagado" class="estado_resultado_interes_pagado"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->interes_pagado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="interes_pagado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->interes_pagado) ?>',1);"><div id="elh_estado_resultado_interes_pagado" class="estado_resultado_interes_pagado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->interes_pagado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->interes_pagado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->interes_pagado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->utilidad_gravable->Visible) { // utilidad_gravable ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->utilidad_gravable) == "") { ?>
		<th data-name="utilidad_gravable"><div id="elh_estado_resultado_utilidad_gravable" class="estado_resultado_utilidad_gravable"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidad_gravable->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="utilidad_gravable"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->utilidad_gravable) ?>',1);"><div id="elh_estado_resultado_utilidad_gravable" class="estado_resultado_utilidad_gravable">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidad_gravable->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->utilidad_gravable->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->utilidad_gravable->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->impuestos->Visible) { // impuestos ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->impuestos) == "") { ?>
		<th data-name="impuestos"><div id="elh_estado_resultado_impuestos" class="estado_resultado_impuestos"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->impuestos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="impuestos"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->impuestos) ?>',1);"><div id="elh_estado_resultado_impuestos" class="estado_resultado_impuestos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->impuestos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->impuestos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->impuestos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->utilidad_neta->Visible) { // utilidad_neta ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->utilidad_neta) == "") { ?>
		<th data-name="utilidad_neta"><div id="elh_estado_resultado_utilidad_neta" class="estado_resultado_utilidad_neta"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidad_neta->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="utilidad_neta"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->utilidad_neta) ?>',1);"><div id="elh_estado_resultado_utilidad_neta" class="estado_resultado_utilidad_neta">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidad_neta->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->utilidad_neta->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->utilidad_neta->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->dividendos->Visible) { // dividendos ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->dividendos) == "") { ?>
		<th data-name="dividendos"><div id="elh_estado_resultado_dividendos" class="estado_resultado_dividendos"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->dividendos->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="dividendos"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->dividendos) ?>',1);"><div id="elh_estado_resultado_dividendos" class="estado_resultado_dividendos">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->dividendos->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->dividendos->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->dividendos->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->utilidades_retenidas->Visible) { // utilidades_retenidas ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->utilidades_retenidas) == "") { ?>
		<th data-name="utilidades_retenidas"><div id="elh_estado_resultado_utilidades_retenidas" class="estado_resultado_utilidades_retenidas"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidades_retenidas->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="utilidades_retenidas"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->utilidades_retenidas) ?>',1);"><div id="elh_estado_resultado_utilidades_retenidas" class="estado_resultado_utilidades_retenidas">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->utilidades_retenidas->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->utilidades_retenidas->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->utilidades_retenidas->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($estado_resultado->estado->Visible) { // estado ?>
	<?php if ($estado_resultado->SortUrl($estado_resultado->estado) == "") { ?>
		<th data-name="estado"><div id="elh_estado_resultado_estado" class="estado_resultado_estado"><div class="ewTableHeaderCaption"><?php echo $estado_resultado->estado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="estado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $estado_resultado->SortUrl($estado_resultado->estado) ?>',1);"><div id="elh_estado_resultado_estado" class="estado_resultado_estado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $estado_resultado->estado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($estado_resultado->estado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($estado_resultado->estado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$estado_resultado_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($estado_resultado->ExportAll && $estado_resultado->Export <> "") {
	$estado_resultado_list->StopRec = $estado_resultado_list->TotalRecs;
} else {

	// Set the last record to display
	if ($estado_resultado_list->TotalRecs > $estado_resultado_list->StartRec + $estado_resultado_list->DisplayRecs - 1)
		$estado_resultado_list->StopRec = $estado_resultado_list->StartRec + $estado_resultado_list->DisplayRecs - 1;
	else
		$estado_resultado_list->StopRec = $estado_resultado_list->TotalRecs;
}
$estado_resultado_list->RecCnt = $estado_resultado_list->StartRec - 1;
if ($estado_resultado_list->Recordset && !$estado_resultado_list->Recordset->EOF) {
	$estado_resultado_list->Recordset->MoveFirst();
	$bSelectLimit = $estado_resultado_list->UseSelectLimit;
	if (!$bSelectLimit && $estado_resultado_list->StartRec > 1)
		$estado_resultado_list->Recordset->Move($estado_resultado_list->StartRec - 1);
} elseif (!$estado_resultado->AllowAddDeleteRow && $estado_resultado_list->StopRec == 0) {
	$estado_resultado_list->StopRec = $estado_resultado->GridAddRowCount;
}

// Initialize aggregate
$estado_resultado->RowType = EW_ROWTYPE_AGGREGATEINIT;
$estado_resultado->ResetAttrs();
$estado_resultado_list->RenderRow();
while ($estado_resultado_list->RecCnt < $estado_resultado_list->StopRec) {
	$estado_resultado_list->RecCnt++;
	if (intval($estado_resultado_list->RecCnt) >= intval($estado_resultado_list->StartRec)) {
		$estado_resultado_list->RowCnt++;

		// Set up key count
		$estado_resultado_list->KeyCount = $estado_resultado_list->RowIndex;

		// Init row class and style
		$estado_resultado->ResetAttrs();
		$estado_resultado->CssClass = "";
		if ($estado_resultado->CurrentAction == "gridadd") {
		} else {
			$estado_resultado_list->LoadRowValues($estado_resultado_list->Recordset); // Load row values
		}
		$estado_resultado->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$estado_resultado->RowAttrs = array_merge($estado_resultado->RowAttrs, array('data-rowindex'=>$estado_resultado_list->RowCnt, 'id'=>'r' . $estado_resultado_list->RowCnt . '_estado_resultado', 'data-rowtype'=>$estado_resultado->RowType));

		// Render row
		$estado_resultado_list->RenderRow();

		// Render list options
		$estado_resultado_list->RenderListOptions();
?>
	<tr<?php echo $estado_resultado->RowAttributes() ?>>
<?php

// Render list options (body, left)
$estado_resultado_list->ListOptions->Render("body", "left", $estado_resultado_list->RowCnt);
?>
	<?php if ($estado_resultado->idestado_resultado->Visible) { // idestado_resultado ?>
		<td data-name="idestado_resultado"<?php echo $estado_resultado->idestado_resultado->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_idestado_resultado" class="estado_resultado_idestado_resultado">
<span<?php echo $estado_resultado->idestado_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado->idestado_resultado->ListViewValue() ?></span>
</span>
<a id="<?php echo $estado_resultado_list->PageObjName . "_row_" . $estado_resultado_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($estado_resultado->idempresa->Visible) { // idempresa ?>
		<td data-name="idempresa"<?php echo $estado_resultado->idempresa->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_idempresa" class="estado_resultado_idempresa">
<span<?php echo $estado_resultado->idempresa->ViewAttributes() ?>>
<?php echo $estado_resultado->idempresa->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->idperiodo_contable->Visible) { // idperiodo_contable ?>
		<td data-name="idperiodo_contable"<?php echo $estado_resultado->idperiodo_contable->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_idperiodo_contable" class="estado_resultado_idperiodo_contable">
<span<?php echo $estado_resultado->idperiodo_contable->ViewAttributes() ?>>
<?php echo $estado_resultado->idperiodo_contable->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->venta_netas->Visible) { // venta_netas ?>
		<td data-name="venta_netas"<?php echo $estado_resultado->venta_netas->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_venta_netas" class="estado_resultado_venta_netas">
<span<?php echo $estado_resultado->venta_netas->ViewAttributes() ?>>
<?php echo $estado_resultado->venta_netas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->costo_ventas->Visible) { // costo_ventas ?>
		<td data-name="costo_ventas"<?php echo $estado_resultado->costo_ventas->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_costo_ventas" class="estado_resultado_costo_ventas">
<span<?php echo $estado_resultado->costo_ventas->ViewAttributes() ?>>
<?php echo $estado_resultado->costo_ventas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->depreciacion->Visible) { // depreciacion ?>
		<td data-name="depreciacion"<?php echo $estado_resultado->depreciacion->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_depreciacion" class="estado_resultado_depreciacion">
<span<?php echo $estado_resultado->depreciacion->ViewAttributes() ?>>
<?php echo $estado_resultado->depreciacion->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->interes_pagado->Visible) { // interes_pagado ?>
		<td data-name="interes_pagado"<?php echo $estado_resultado->interes_pagado->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_interes_pagado" class="estado_resultado_interes_pagado">
<span<?php echo $estado_resultado->interes_pagado->ViewAttributes() ?>>
<?php echo $estado_resultado->interes_pagado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->utilidad_gravable->Visible) { // utilidad_gravable ?>
		<td data-name="utilidad_gravable"<?php echo $estado_resultado->utilidad_gravable->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_utilidad_gravable" class="estado_resultado_utilidad_gravable">
<span<?php echo $estado_resultado->utilidad_gravable->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidad_gravable->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->impuestos->Visible) { // impuestos ?>
		<td data-name="impuestos"<?php echo $estado_resultado->impuestos->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_impuestos" class="estado_resultado_impuestos">
<span<?php echo $estado_resultado->impuestos->ViewAttributes() ?>>
<?php echo $estado_resultado->impuestos->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->utilidad_neta->Visible) { // utilidad_neta ?>
		<td data-name="utilidad_neta"<?php echo $estado_resultado->utilidad_neta->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_utilidad_neta" class="estado_resultado_utilidad_neta">
<span<?php echo $estado_resultado->utilidad_neta->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidad_neta->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->dividendos->Visible) { // dividendos ?>
		<td data-name="dividendos"<?php echo $estado_resultado->dividendos->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_dividendos" class="estado_resultado_dividendos">
<span<?php echo $estado_resultado->dividendos->ViewAttributes() ?>>
<?php echo $estado_resultado->dividendos->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->utilidades_retenidas->Visible) { // utilidades_retenidas ?>
		<td data-name="utilidades_retenidas"<?php echo $estado_resultado->utilidades_retenidas->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_utilidades_retenidas" class="estado_resultado_utilidades_retenidas">
<span<?php echo $estado_resultado->utilidades_retenidas->ViewAttributes() ?>>
<?php echo $estado_resultado->utilidades_retenidas->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($estado_resultado->estado->Visible) { // estado ?>
		<td data-name="estado"<?php echo $estado_resultado->estado->CellAttributes() ?>>
<span id="el<?php echo $estado_resultado_list->RowCnt ?>_estado_resultado_estado" class="estado_resultado_estado">
<span<?php echo $estado_resultado->estado->ViewAttributes() ?>>
<?php echo $estado_resultado->estado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$estado_resultado_list->ListOptions->Render("body", "right", $estado_resultado_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($estado_resultado->CurrentAction <> "gridadd")
		$estado_resultado_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($estado_resultado->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($estado_resultado_list->Recordset)
	$estado_resultado_list->Recordset->Close();
?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($estado_resultado->CurrentAction <> "gridadd" && $estado_resultado->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($estado_resultado_list->Pager)) $estado_resultado_list->Pager = new cPrevNextPager($estado_resultado_list->StartRec, $estado_resultado_list->DisplayRecs, $estado_resultado_list->TotalRecs) ?>
<?php if ($estado_resultado_list->Pager->RecordCount > 0) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($estado_resultado_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($estado_resultado_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $estado_resultado_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($estado_resultado_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($estado_resultado_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $estado_resultado_list->PageUrl() ?>start=<?php echo $estado_resultado_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $estado_resultado_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $estado_resultado_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $estado_resultado_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $estado_resultado_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($estado_resultado_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($estado_resultado_list->TotalRecs == 0 && $estado_resultado->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($estado_resultado_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
festado_resultadolistsrch.Init();
festado_resultadolistsrch.FilterList = <?php echo $estado_resultado_list->GetFilterList() ?>;
festado_resultadolist.Init();
</script>
<?php
$estado_resultado_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_resultado_list->Page_Terminate();
?>
