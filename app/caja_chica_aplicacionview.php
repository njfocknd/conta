<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "caja_chica_aplicacioninfo.php" ?>
<?php include_once "caja_chica_detalleinfo.php" ?>
<?php include_once "documento_caja_chicagridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$caja_chica_aplicacion_view = NULL; // Initialize page object first

class ccaja_chica_aplicacion_view extends ccaja_chica_aplicacion {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'caja_chica_aplicacion';

	// Page object name
	var $PageObjName = 'caja_chica_aplicacion_view';

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

		// Table object (caja_chica_aplicacion)
		if (!isset($GLOBALS["caja_chica_aplicacion"]) || get_class($GLOBALS["caja_chica_aplicacion"]) == "ccaja_chica_aplicacion") {
			$GLOBALS["caja_chica_aplicacion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["caja_chica_aplicacion"];
		}
		$KeyUrl = "";
		if (@$_GET["idcaja_chica_aplicacion"] <> "") {
			$this->RecKey["idcaja_chica_aplicacion"] = $_GET["idcaja_chica_aplicacion"];
			$KeyUrl .= "&amp;idcaja_chica_aplicacion=" . urlencode($this->RecKey["idcaja_chica_aplicacion"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (caja_chica_detalle)
		if (!isset($GLOBALS['caja_chica_detalle'])) $GLOBALS['caja_chica_detalle'] = new ccaja_chica_detalle();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caja_chica_aplicacion', TRUE);

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
		$this->idcaja_chica_aplicacion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $caja_chica_aplicacion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($caja_chica_aplicacion);
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
			if (@$_GET["idcaja_chica_aplicacion"] <> "") {
				$this->idcaja_chica_aplicacion->setQueryStringValue($_GET["idcaja_chica_aplicacion"]);
				$this->RecKey["idcaja_chica_aplicacion"] = $this->idcaja_chica_aplicacion->QueryStringValue;
			} elseif (@$_POST["idcaja_chica_aplicacion"] <> "") {
				$this->idcaja_chica_aplicacion->setFormValue($_POST["idcaja_chica_aplicacion"]);
				$this->RecKey["idcaja_chica_aplicacion"] = $this->idcaja_chica_aplicacion->FormValue;
			} else {
				$sReturnUrl = "caja_chica_aplicacionlist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "caja_chica_aplicacionlist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "caja_chica_aplicacionlist.php"; // Not page request, return to list
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

		// "detail_documento_caja_chica"
		$item = &$option->Add("detail_documento_caja_chica");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("documento_caja_chica", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("documento_caja_chicalist.php?" . EW_TABLE_SHOW_MASTER . "=caja_chica_aplicacion&fk_idreferencia=" . urlencode(strval($this->idreferencia->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["documento_caja_chica_grid"] && $GLOBALS["documento_caja_chica_grid"]->DetailView) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=documento_caja_chica")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "documento_caja_chica";
		}
		if ($GLOBALS["documento_caja_chica_grid"] && $GLOBALS["documento_caja_chica_grid"]->DetailEdit) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=documento_caja_chica")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "documento_caja_chica";
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
			$DetailTableLink .= "documento_caja_chica";
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
		$this->idcaja_chica_aplicacion->setDbValue($rs->fields('idcaja_chica_aplicacion'));
		$this->idcaja_chica_detalle->setDbValue($rs->fields('idcaja_chica_detalle'));
		$this->idreferencia->setDbValue($rs->fields('idreferencia'));
		$this->tabla_referencia->setDbValue($rs->fields('tabla_referencia'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcaja_chica_aplicacion->DbValue = $row['idcaja_chica_aplicacion'];
		$this->idcaja_chica_detalle->DbValue = $row['idcaja_chica_detalle'];
		$this->idreferencia->DbValue = $row['idreferencia'];
		$this->tabla_referencia->DbValue = $row['tabla_referencia'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha->DbValue = $row['fecha'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
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

		// Convert decimal values if posted back
		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcaja_chica_aplicacion
		// idcaja_chica_detalle
		// idreferencia
		// tabla_referencia
		// monto
		// fecha
		// fecha_insercion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idcaja_chica_aplicacion
		$this->idcaja_chica_aplicacion->ViewValue = $this->idcaja_chica_aplicacion->CurrentValue;
		$this->idcaja_chica_aplicacion->ViewCustomAttributes = "";

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle->ViewValue = $this->idcaja_chica_detalle->CurrentValue;
		$this->idcaja_chica_detalle->ViewCustomAttributes = "";

		// idreferencia
		$this->idreferencia->ViewValue = $this->idreferencia->CurrentValue;
		$this->idreferencia->ViewCustomAttributes = "";

		// tabla_referencia
		$this->tabla_referencia->ViewValue = $this->tabla_referencia->CurrentValue;
		$this->tabla_referencia->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idcaja_chica_aplicacion
			$this->idcaja_chica_aplicacion->LinkCustomAttributes = "";
			$this->idcaja_chica_aplicacion->HrefValue = "";
			$this->idcaja_chica_aplicacion->TooltipValue = "";

			// idcaja_chica_detalle
			$this->idcaja_chica_detalle->LinkCustomAttributes = "";
			$this->idcaja_chica_detalle->HrefValue = "";
			$this->idcaja_chica_detalle->TooltipValue = "";

			// idreferencia
			$this->idreferencia->LinkCustomAttributes = "";
			$this->idreferencia->HrefValue = "";
			$this->idreferencia->TooltipValue = "";

			// tabla_referencia
			$this->tabla_referencia->LinkCustomAttributes = "";
			$this->tabla_referencia->HrefValue = "";
			$this->tabla_referencia->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// fecha_insercion
			$this->fecha_insercion->LinkCustomAttributes = "";
			$this->fecha_insercion->HrefValue = "";
			$this->fecha_insercion->TooltipValue = "";

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
			if ($sMasterTblVar == "caja_chica_detalle") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcaja_chica_detalle"] <> "") {
					$GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->setQueryStringValue($_GET["fk_idcaja_chica_detalle"]);
					$this->idcaja_chica_detalle->setQueryStringValue($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->QueryStringValue);
					$this->idcaja_chica_detalle->setSessionValue($this->idcaja_chica_detalle->QueryStringValue);
					if (!is_numeric($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "caja_chica_detalle") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idcaja_chica_detalle"] <> "") {
					$GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->setFormValue($_POST["fk_idcaja_chica_detalle"]);
					$this->idcaja_chica_detalle->setFormValue($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->FormValue);
					$this->idcaja_chica_detalle->setSessionValue($this->idcaja_chica_detalle->FormValue);
					if (!is_numeric($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "caja_chica_detalle") {
				if ($this->idcaja_chica_detalle->CurrentValue == "") $this->idcaja_chica_detalle->setSessionValue("");
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
			if (in_array("documento_caja_chica", $DetailTblVar)) {
				if (!isset($GLOBALS["documento_caja_chica_grid"]))
					$GLOBALS["documento_caja_chica_grid"] = new cdocumento_caja_chica_grid;
				if ($GLOBALS["documento_caja_chica_grid"]->DetailView) {
					$GLOBALS["documento_caja_chica_grid"]->CurrentMode = "view";

					// Save current master table to detail table
					$GLOBALS["documento_caja_chica_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["documento_caja_chica_grid"]->setStartRecordNumber(1);
					$GLOBALS["documento_caja_chica_grid"]->iddocumento_caja_chica->FldIsDetailKey = TRUE;
					$GLOBALS["documento_caja_chica_grid"]->iddocumento_caja_chica->CurrentValue = $this->idreferencia->CurrentValue;
					$GLOBALS["documento_caja_chica_grid"]->iddocumento_caja_chica->setSessionValue($GLOBALS["documento_caja_chica_grid"]->iddocumento_caja_chica->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("caja_chica_aplicacionlist.php"), "", $this->TableVar, TRUE);
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
if (!isset($caja_chica_aplicacion_view)) $caja_chica_aplicacion_view = new ccaja_chica_aplicacion_view();

// Page init
$caja_chica_aplicacion_view->Page_Init();

// Page main
$caja_chica_aplicacion_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_aplicacion_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fcaja_chica_aplicacionview = new ew_Form("fcaja_chica_aplicacionview", "view");

// Form_CustomValidate event
fcaja_chica_aplicacionview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_aplicacionview.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_aplicacionview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcaja_chica_aplicacionview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcaja_chica_aplicacionview.Lists["x_estado"].Options = <?php echo json_encode($caja_chica_aplicacion->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $caja_chica_aplicacion_view->ExportOptions->Render("body") ?>
<?php
	foreach ($caja_chica_aplicacion_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $caja_chica_aplicacion_view->ShowPageHeader(); ?>
<?php
$caja_chica_aplicacion_view->ShowMessage();
?>
<form name="fcaja_chica_aplicacionview" id="fcaja_chica_aplicacionview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($caja_chica_aplicacion_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $caja_chica_aplicacion_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="caja_chica_aplicacion">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($caja_chica_aplicacion->idcaja_chica_aplicacion->Visible) { // idcaja_chica_aplicacion ?>
	<tr id="r_idcaja_chica_aplicacion">
		<td><span id="elh_caja_chica_aplicacion_idcaja_chica_aplicacion"><?php echo $caja_chica_aplicacion->idcaja_chica_aplicacion->FldCaption() ?></span></td>
		<td data-name="idcaja_chica_aplicacion"<?php echo $caja_chica_aplicacion->idcaja_chica_aplicacion->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idcaja_chica_aplicacion">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_aplicacion->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idcaja_chica_aplicacion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
	<tr id="r_idcaja_chica_detalle">
		<td><span id="elh_caja_chica_aplicacion_idcaja_chica_detalle"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?></span></td>
		<td data-name="idcaja_chica_detalle"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
	<tr id="r_idreferencia">
		<td><span id="elh_caja_chica_aplicacion_idreferencia"><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></span></td>
		<td data-name="idreferencia"<?php echo $caja_chica_aplicacion->idreferencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idreferencia">
<span<?php echo $caja_chica_aplicacion->idreferencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idreferencia->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
	<tr id="r_tabla_referencia">
		<td><span id="elh_caja_chica_aplicacion_tabla_referencia"><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></span></td>
		<td data-name="tabla_referencia"<?php echo $caja_chica_aplicacion->tabla_referencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_tabla_referencia">
<span<?php echo $caja_chica_aplicacion->tabla_referencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->tabla_referencia->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_caja_chica_aplicacion_monto"><?php echo $caja_chica_aplicacion->monto->FldCaption() ?></span></td>
		<td data-name="monto"<?php echo $caja_chica_aplicacion->monto->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_monto">
<span<?php echo $caja_chica_aplicacion->monto->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_caja_chica_aplicacion_fecha"><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></span></td>
		<td data-name="fecha"<?php echo $caja_chica_aplicacion->fecha->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_fecha">
<span<?php echo $caja_chica_aplicacion->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->fecha->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_caja_chica_aplicacion_fecha_insercion"><?php echo $caja_chica_aplicacion->fecha_insercion->FldCaption() ?></span></td>
		<td data-name="fecha_insercion"<?php echo $caja_chica_aplicacion->fecha_insercion->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_fecha_insercion">
<span<?php echo $caja_chica_aplicacion->fecha_insercion->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($caja_chica_aplicacion->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_caja_chica_aplicacion_estado"><?php echo $caja_chica_aplicacion->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $caja_chica_aplicacion->estado->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_estado">
<span<?php echo $caja_chica_aplicacion->estado->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("documento_caja_chica", explode(",", $caja_chica_aplicacion->getCurrentDetailTable())) && $documento_caja_chica->DetailView) {
?>
<?php if ($caja_chica_aplicacion->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("documento_caja_chica", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "documento_caja_chicagrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fcaja_chica_aplicacionview.Init();
</script>
<?php
$caja_chica_aplicacion_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$caja_chica_aplicacion_view->Page_Terminate();
?>
