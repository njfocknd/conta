<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "estado_resultado_detalleinfo.php" ?>
<?php include_once "estado_resultadoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$estado_resultado_detalle_view = NULL; // Initialize page object first

class cestado_resultado_detalle_view extends cestado_resultado_detalle {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'estado_resultado_detalle';

	// Page object name
	var $PageObjName = 'estado_resultado_detalle_view';

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

		// Table object (estado_resultado_detalle)
		if (!isset($GLOBALS["estado_resultado_detalle"]) || get_class($GLOBALS["estado_resultado_detalle"]) == "cestado_resultado_detalle") {
			$GLOBALS["estado_resultado_detalle"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_resultado_detalle"];
		}
		$KeyUrl = "";
		if (@$_GET["idestado_resultado_detalle"] <> "") {
			$this->RecKey["idestado_resultado_detalle"] = $_GET["idestado_resultado_detalle"];
			$KeyUrl .= "&amp;idestado_resultado_detalle=" . urlencode($this->RecKey["idestado_resultado_detalle"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (estado_resultado)
		if (!isset($GLOBALS['estado_resultado'])) $GLOBALS['estado_resultado'] = new cestado_resultado();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_resultado_detalle', TRUE);

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
		$this->idestado_resultado_detalle->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $estado_resultado_detalle;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_resultado_detalle);
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
			if (@$_GET["idestado_resultado_detalle"] <> "") {
				$this->idestado_resultado_detalle->setQueryStringValue($_GET["idestado_resultado_detalle"]);
				$this->RecKey["idestado_resultado_detalle"] = $this->idestado_resultado_detalle->QueryStringValue;
			} elseif (@$_POST["idestado_resultado_detalle"] <> "") {
				$this->idestado_resultado_detalle->setFormValue($_POST["idestado_resultado_detalle"]);
				$this->RecKey["idestado_resultado_detalle"] = $this->idestado_resultado_detalle->FormValue;
			} else {
				$sReturnUrl = "estado_resultado_detallelist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "estado_resultado_detallelist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "estado_resultado_detallelist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
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
		$this->idestado_resultado_detalle->setDbValue($rs->fields('idestado_resultado_detalle'));
		$this->idestado_resultado->setDbValue($rs->fields('idestado_resultado'));
		$this->idclase_resultado->setDbValue($rs->fields('idclase_resultado'));
		$this->idgrupo_resultado->setDbValue($rs->fields('idgrupo_resultado'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idestado_resultado_detalle->DbValue = $row['idestado_resultado_detalle'];
		$this->idestado_resultado->DbValue = $row['idestado_resultado'];
		$this->idclase_resultado->DbValue = $row['idclase_resultado'];
		$this->idgrupo_resultado->DbValue = $row['idgrupo_resultado'];
		$this->monto->DbValue = $row['monto'];
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
		// idestado_resultado_detalle
		// idestado_resultado
		// idclase_resultado
		// idgrupo_resultado
		// monto
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idestado_resultado_detalle
		$this->idestado_resultado_detalle->ViewValue = $this->idestado_resultado_detalle->CurrentValue;
		$this->idestado_resultado_detalle->ViewCustomAttributes = "";

		// idestado_resultado
		if (strval($this->idestado_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idestado_resultado`" . ew_SearchString("=", $this->idestado_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idestado_resultado`, `idempresa` AS `DispFld`, `idperiodo_contable` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_resultado`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idestado_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->idestado_resultado->ViewValue = $this->idestado_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idestado_resultado->ViewValue = $this->idestado_resultado->CurrentValue;
			}
		} else {
			$this->idestado_resultado->ViewValue = NULL;
		}
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idclase_resultado
		if (strval($this->idclase_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idclase_resultado`" . ew_SearchString("=", $this->idclase_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idclase_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idclase_resultado->ViewValue = $this->idclase_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idclase_resultado->ViewValue = $this->idclase_resultado->CurrentValue;
			}
		} else {
			$this->idclase_resultado->ViewValue = NULL;
		}
		$this->idclase_resultado->ViewCustomAttributes = "";

		// idgrupo_resultado
		if (strval($this->idgrupo_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idgrupo_resultado`" . ew_SearchString("=", $this->idgrupo_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idgrupo_resultado->ViewValue = $this->idgrupo_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idgrupo_resultado->ViewValue = $this->idgrupo_resultado->CurrentValue;
			}
		} else {
			$this->idgrupo_resultado->ViewValue = NULL;
		}
		$this->idgrupo_resultado->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idestado_resultado_detalle
			$this->idestado_resultado_detalle->LinkCustomAttributes = "";
			$this->idestado_resultado_detalle->HrefValue = "";
			$this->idestado_resultado_detalle->TooltipValue = "";

			// idestado_resultado
			$this->idestado_resultado->LinkCustomAttributes = "";
			$this->idestado_resultado->HrefValue = "";
			$this->idestado_resultado->TooltipValue = "";

			// idclase_resultado
			$this->idclase_resultado->LinkCustomAttributes = "";
			$this->idclase_resultado->HrefValue = "";
			$this->idclase_resultado->TooltipValue = "";

			// idgrupo_resultado
			$this->idgrupo_resultado->LinkCustomAttributes = "";
			$this->idgrupo_resultado->HrefValue = "";
			$this->idgrupo_resultado->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

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
			if ($sMasterTblVar == "estado_resultado") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idestado_resultado"] <> "") {
					$GLOBALS["estado_resultado"]->idestado_resultado->setQueryStringValue($_GET["fk_idestado_resultado"]);
					$this->idestado_resultado->setQueryStringValue($GLOBALS["estado_resultado"]->idestado_resultado->QueryStringValue);
					$this->idestado_resultado->setSessionValue($this->idestado_resultado->QueryStringValue);
					if (!is_numeric($GLOBALS["estado_resultado"]->idestado_resultado->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "estado_resultado") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idestado_resultado"] <> "") {
					$GLOBALS["estado_resultado"]->idestado_resultado->setFormValue($_POST["fk_idestado_resultado"]);
					$this->idestado_resultado->setFormValue($GLOBALS["estado_resultado"]->idestado_resultado->FormValue);
					$this->idestado_resultado->setSessionValue($this->idestado_resultado->FormValue);
					if (!is_numeric($GLOBALS["estado_resultado"]->idestado_resultado->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "estado_resultado") {
				if ($this->idestado_resultado->CurrentValue == "") $this->idestado_resultado->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_resultado_detallelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($estado_resultado_detalle_view)) $estado_resultado_detalle_view = new cestado_resultado_detalle_view();

// Page init
$estado_resultado_detalle_view->Page_Init();

// Page main
$estado_resultado_detalle_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_detalle_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = festado_resultado_detalleview = new ew_Form("festado_resultado_detalleview", "view");

// Form_CustomValidate event
festado_resultado_detalleview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultado_detalleview.ValidateRequired = true;
<?php } else { ?>
festado_resultado_detalleview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultado_detalleview.Lists["x_idestado_resultado"] = {"LinkField":"x_idestado_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_idempresa","x_idperiodo_contable","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detalleview.Lists["x_idclase_resultado"] = {"LinkField":"x_idclase_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_resultado"],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detalleview.Lists["x_idgrupo_resultado"] = {"LinkField":"x_idgrupo_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detalleview.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detalleview.Lists["x_estado"].Options = <?php echo json_encode($estado_resultado_detalle->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $estado_resultado_detalle_view->ExportOptions->Render("body") ?>
<?php
	foreach ($estado_resultado_detalle_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $estado_resultado_detalle_view->ShowPageHeader(); ?>
<?php
$estado_resultado_detalle_view->ShowMessage();
?>
<form name="festado_resultado_detalleview" id="festado_resultado_detalleview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_resultado_detalle_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_resultado_detalle_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_resultado_detalle">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($estado_resultado_detalle->idestado_resultado_detalle->Visible) { // idestado_resultado_detalle ?>
	<tr id="r_idestado_resultado_detalle">
		<td><span id="elh_estado_resultado_detalle_idestado_resultado_detalle"><?php echo $estado_resultado_detalle->idestado_resultado_detalle->FldCaption() ?></span></td>
		<td data-name="idestado_resultado_detalle"<?php echo $estado_resultado_detalle->idestado_resultado_detalle->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idestado_resultado_detalle">
<span<?php echo $estado_resultado_detalle->idestado_resultado_detalle->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idestado_resultado_detalle->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado_detalle->idestado_resultado->Visible) { // idestado_resultado ?>
	<tr id="r_idestado_resultado">
		<td><span id="elh_estado_resultado_detalle_idestado_resultado"><?php echo $estado_resultado_detalle->idestado_resultado->FldCaption() ?></span></td>
		<td data-name="idestado_resultado"<?php echo $estado_resultado_detalle->idestado_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idestado_resultado">
<span<?php echo $estado_resultado_detalle->idestado_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idestado_resultado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado_detalle->idclase_resultado->Visible) { // idclase_resultado ?>
	<tr id="r_idclase_resultado">
		<td><span id="elh_estado_resultado_detalle_idclase_resultado"><?php echo $estado_resultado_detalle->idclase_resultado->FldCaption() ?></span></td>
		<td data-name="idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idclase_resultado">
<span<?php echo $estado_resultado_detalle->idclase_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado_detalle->idgrupo_resultado->Visible) { // idgrupo_resultado ?>
	<tr id="r_idgrupo_resultado">
		<td><span id="elh_estado_resultado_detalle_idgrupo_resultado"><?php echo $estado_resultado_detalle->idgrupo_resultado->FldCaption() ?></span></td>
		<td data-name="idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idgrupo_resultado">
<span<?php echo $estado_resultado_detalle->idgrupo_resultado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado_detalle->monto->Visible) { // monto ?>
	<tr id="r_monto">
		<td><span id="elh_estado_resultado_detalle_monto"><?php echo $estado_resultado_detalle->monto->FldCaption() ?></span></td>
		<td data-name="monto"<?php echo $estado_resultado_detalle->monto->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_monto">
<span<?php echo $estado_resultado_detalle->monto->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->monto->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($estado_resultado_detalle->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_estado_resultado_detalle_estado"><?php echo $estado_resultado_detalle->estado->FldCaption() ?></span></td>
		<td data-name="estado"<?php echo $estado_resultado_detalle->estado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_estado">
<span<?php echo $estado_resultado_detalle->estado->ViewAttributes() ?>>
<?php echo $estado_resultado_detalle->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
festado_resultado_detalleview.Init();
</script>
<?php
$estado_resultado_detalle_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_resultado_detalle_view->Page_Terminate();
?>
