<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "caja_chicainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "encargadogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "caja_chica_detallegridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$caja_chica_view = NULL; // Initialize page object first

class ccaja_chica_view extends ccaja_chica {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'caja_chica';

	// Page object name
	var $PageObjName = 'caja_chica_view';

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

		// Table object (caja_chica)
		if (!isset($GLOBALS["caja_chica"]) || get_class($GLOBALS["caja_chica"]) == "ccaja_chica") {
			$GLOBALS["caja_chica"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["caja_chica"];
		}
		$KeyUrl = "";
		if (@$_GET["idcaja_chica"] <> "") {
			$this->RecKey["idcaja_chica"] = $_GET["idcaja_chica"];
			$KeyUrl .= "&amp;idcaja_chica=" . urlencode($this->RecKey["idcaja_chica"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caja_chica', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

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
		$this->idcaja_chica->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

			// Process auto fill for detail table 'encargado'
			if (@$_POST["grid"] == "fencargadogrid") {
				if (!isset($GLOBALS["encargado_grid"])) $GLOBALS["encargado_grid"] = new cencargado_grid;
				$GLOBALS["encargado_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'caja_chica_detalle'
			if (@$_POST["grid"] == "fcaja_chica_detallegrid") {
				if (!isset($GLOBALS["caja_chica_detalle_grid"])) $GLOBALS["caja_chica_detalle_grid"] = new ccaja_chica_detalle_grid;
				$GLOBALS["caja_chica_detalle_grid"]->Page_Init();
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
		global $EW_EXPORT, $caja_chica;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($caja_chica);
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

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idcaja_chica"] <> "") {
				$this->idcaja_chica->setQueryStringValue($_GET["idcaja_chica"]);
				$this->RecKey["idcaja_chica"] = $this->idcaja_chica->QueryStringValue;
			} else {
				$sReturnUrl = "caja_chicalist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "caja_chicalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "caja_chicalist.php"; // Not page request, return to list
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

		// Show detail edit/copy
		if ($this->getCurrentDetailTable() <> "") {

			// Detail Edit
			$item = &$option->Add("detailedit");
			$item->Body = "<a class=\"ewAction ewDetailEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable())) . "\">" . $Language->Phrase("MasterDetailEditLink") . "</a>";
			$item->Visible = (TRUE);
		}
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_encargado"
		$item = &$option->Add("detail_encargado");
		$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("encargado", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("encargadolist.php?" . EW_TABLE_SHOW_MASTER . "=caja_chica&fk_idcaja_chica=" . strval($this->idcaja_chica->CurrentValue) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["encargado_grid"] && $GLOBALS["encargado_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=encargado")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "encargado";
		}
		if ($GLOBALS["encargado_grid"] && $GLOBALS["encargado_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=encargado")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "encargado";
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
			$DetailTableLink .= "encargado";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_caja_chica_detalle"
		$item = &$option->Add("detail_caja_chica_detalle");
		$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("caja_chica_detalle", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("caja_chica_detallelist.php?" . EW_TABLE_SHOW_MASTER . "=caja_chica&fk_idcaja_chica=" . strval($this->idcaja_chica->CurrentValue) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["caja_chica_detalle_grid"] && $GLOBALS["caja_chica_detalle_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=caja_chica_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "caja_chica_detalle";
		}
		if ($GLOBALS["caja_chica_detalle_grid"] && $GLOBALS["caja_chica_detalle_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=caja_chica_detalle")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "caja_chica_detalle";
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
			$DetailTableLink .= "caja_chica_detalle";
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
		$this->idcaja_chica->setDbValue($rs->fields('idcaja_chica'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idempleado->setDbValue($rs->fields('idempleado'));
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcaja_chica->DbValue = $row['idcaja_chica'];
		$this->nombre->DbValue = $row['nombre'];
		$this->saldo->DbValue = $row['saldo'];
		$this->idempresa->DbValue = $row['idempresa'];
		$this->idempleado->DbValue = $row['idempleado'];
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

		// Convert decimal values if posted back
		if ($this->saldo->FormValue == $this->saldo->CurrentValue && is_numeric(ew_StrToFloat($this->saldo->CurrentValue)))
			$this->saldo->CurrentValue = ew_StrToFloat($this->saldo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcaja_chica
		// nombre
		// saldo
		// idempresa
		// idempleado
		// idcuenta
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcaja_chica
			$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
			$this->idcaja_chica->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// saldo
			$this->saldo->ViewValue = $this->saldo->CurrentValue;
			$this->saldo->ViewCustomAttributes = "";

			// idempresa
			if (strval($this->idempresa->CurrentValue) <> "") {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idempresa->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idempresa->ViewValue = $this->idempresa->CurrentValue;
				}
			} else {
				$this->idempresa->ViewValue = NULL;
			}
			$this->idempresa->ViewCustomAttributes = "";

			// idempleado
			if (strval($this->idempleado->CurrentValue) <> "") {
				$sFilterWrk = "`idempleado`" . ew_SearchString("=", $this->idempleado->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idempleado, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idempleado->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idempleado->ViewValue = $this->idempleado->CurrentValue;
				}
			} else {
				$this->idempleado->ViewValue = NULL;
			}
			$this->idempleado->ViewCustomAttributes = "";

			// idcuenta
			if (strval($this->idcuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo' ";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idcuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idcuenta->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
				}
			} else {
				$this->idcuenta->ViewValue = NULL;
			}
			$this->idcuenta->ViewCustomAttributes = "";

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

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

			// idcaja_chica
			$this->idcaja_chica->LinkCustomAttributes = "";
			$this->idcaja_chica->HrefValue = "";
			$this->idcaja_chica->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// saldo
			$this->saldo->LinkCustomAttributes = "";
			$this->saldo->HrefValue = "";
			$this->saldo->TooltipValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";

			// idempleado
			$this->idempleado->LinkCustomAttributes = "";
			$this->idempleado->HrefValue = "";
			$this->idempleado->TooltipValue = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
			$this->idcuenta->TooltipValue = "";

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
			if (in_array("encargado", $DetailTblVar)) {
				if (!isset($GLOBALS["encargado_grid"]))
					$GLOBALS["encargado_grid"] = new cencargado_grid;
				if ($GLOBALS["encargado_grid"]->DetailView) {
					$GLOBALS["encargado_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["encargado_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["encargado_grid"]->setStartRecordNumber(1);
					$GLOBALS["encargado_grid"]->idreferencia->FldIsDetailKey = TRUE;
					$GLOBALS["encargado_grid"]->idreferencia->CurrentValue = $this->idcaja_chica->CurrentValue;
					$GLOBALS["encargado_grid"]->idreferencia->setSessionValue($GLOBALS["encargado_grid"]->idreferencia->CurrentValue);
				}
			}
			if (in_array("caja_chica_detalle", $DetailTblVar)) {
				if (!isset($GLOBALS["caja_chica_detalle_grid"]))
					$GLOBALS["caja_chica_detalle_grid"] = new ccaja_chica_detalle_grid;
				if ($GLOBALS["caja_chica_detalle_grid"]->DetailView) {
					$GLOBALS["caja_chica_detalle_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["caja_chica_detalle_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["caja_chica_detalle_grid"]->setStartRecordNumber(1);
					$GLOBALS["caja_chica_detalle_grid"]->idcaja_chica->FldIsDetailKey = TRUE;
					$GLOBALS["caja_chica_detalle_grid"]->idcaja_chica->CurrentValue = $this->idcaja_chica->CurrentValue;
					$GLOBALS["caja_chica_detalle_grid"]->idcaja_chica->setSessionValue($GLOBALS["caja_chica_detalle_grid"]->idcaja_chica->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "caja_chicalist.php", "", $this->TableVar, TRUE);
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, ew_CurrentUrl());
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
if (!isset($caja_chica_view)) $caja_chica_view = new ccaja_chica_view();

// Page init
$caja_chica_view->Page_Init();

// Page main
$caja_chica_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var caja_chica_view = new ew_Page("caja_chica_view");
caja_chica_view.PageID = "view"; // Page ID
var EW_PAGE_ID = caja_chica_view.PageID; // For backward compatibility

// Form object
var fcaja_chicaview = new ew_Form("fcaja_chicaview");

// Form_CustomValidate event
fcaja_chicaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chicaview.ValidateRequired = true;
<?php } else { ?>
fcaja_chicaview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcaja_chicaview.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcaja_chicaview.Lists["x_idempleado"] = {"LinkField":"x_idempleado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};
fcaja_chicaview.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $caja_chica_view->ExportOptions->Render("body") ?>
<?php
	foreach ($caja_chica_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $caja_chica_view->ShowPageHeader(); ?>
<?php
$caja_chica_view->ShowMessage();
?>
<form name="fcaja_chicaview" id="fcaja_chicaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($caja_chica_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $caja_chica_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="caja_chica">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($caja_chica->idcaja_chica->Visible) { // idcaja_chica ?>
	<tr id="r_idcaja_chica">
		<td><span id="elh_caja_chica_idcaja_chica"><?php echo $caja_chica->idcaja_chica->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->idcaja_chica->CellAttributes() ?>>
<span id="el_caja_chica_idcaja_chica" class="form-group">
<span<?php echo $caja_chica->idcaja_chica->ViewAttributes() ?>>
<?php echo $caja_chica->idcaja_chica->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->nombre->Visible) { // nombre ?>
	<tr id="r_nombre">
		<td><span id="elh_caja_chica_nombre"><?php echo $caja_chica->nombre->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->nombre->CellAttributes() ?>>
<span id="el_caja_chica_nombre" class="form-group">
<span<?php echo $caja_chica->nombre->ViewAttributes() ?>>
<?php echo $caja_chica->nombre->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->saldo->Visible) { // saldo ?>
	<tr id="r_saldo">
		<td><span id="elh_caja_chica_saldo"><?php echo $caja_chica->saldo->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->saldo->CellAttributes() ?>>
<span id="el_caja_chica_saldo" class="form-group">
<span<?php echo $caja_chica->saldo->ViewAttributes() ?>>
<?php echo $caja_chica->saldo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->idempresa->Visible) { // idempresa ?>
	<tr id="r_idempresa">
		<td><span id="elh_caja_chica_idempresa"><?php echo $caja_chica->idempresa->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->idempresa->CellAttributes() ?>>
<span id="el_caja_chica_idempresa" class="form-group">
<span<?php echo $caja_chica->idempresa->ViewAttributes() ?>>
<?php echo $caja_chica->idempresa->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->idempleado->Visible) { // idempleado ?>
	<tr id="r_idempleado">
		<td><span id="elh_caja_chica_idempleado"><?php echo $caja_chica->idempleado->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->idempleado->CellAttributes() ?>>
<span id="el_caja_chica_idempleado" class="form-group">
<span<?php echo $caja_chica->idempleado->ViewAttributes() ?>>
<?php echo $caja_chica->idempleado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->idcuenta->Visible) { // idcuenta ?>
	<tr id="r_idcuenta">
		<td><span id="elh_caja_chica_idcuenta"><?php echo $caja_chica->idcuenta->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->idcuenta->CellAttributes() ?>>
<span id="el_caja_chica_idcuenta" class="form-group">
<span<?php echo $caja_chica->idcuenta->ViewAttributes() ?>>
<?php echo $caja_chica->idcuenta->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_caja_chica_estado"><?php echo $caja_chica->estado->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->estado->CellAttributes() ?>>
<span id="el_caja_chica_estado" class="form-group">
<span<?php echo $caja_chica->estado->ViewAttributes() ?>>
<?php echo $caja_chica->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_caja_chica_fecha_insercion"><?php echo $caja_chica->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $caja_chica->fecha_insercion->CellAttributes() ?>>
<span id="el_caja_chica_fecha_insercion" class="form-group">
<span<?php echo $caja_chica->fecha_insercion->ViewAttributes() ?>>
<?php echo $caja_chica->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("encargado", explode(",", $caja_chica->getCurrentDetailTable())) && $encargado->DetailView) {
?>
<?php if ($caja_chica->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("encargado", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "encargadogrid.php" ?>
<?php } ?>
<?php
	if (in_array("caja_chica_detalle", explode(",", $caja_chica->getCurrentDetailTable())) && $caja_chica_detalle->DetailView) {
?>
<?php if ($caja_chica->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("caja_chica_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "caja_chica_detallegrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fcaja_chicaview.Init();
</script>
<?php
$caja_chica_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$caja_chica_view->Page_Terminate();
?>
