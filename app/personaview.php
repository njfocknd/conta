<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "personainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "paisinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$persona_view = NULL; // Initialize page object first

class cpersona_view extends cpersona {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'persona';

	// Page object name
	var $PageObjName = 'persona_view';

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

		// Table object (persona)
		if (!isset($GLOBALS["persona"]) || get_class($GLOBALS["persona"]) == "cpersona") {
			$GLOBALS["persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persona"];
		}
		$KeyUrl = "";
		if (@$_GET["idpersona"] <> "") {
			$this->RecKey["idpersona"] = $_GET["idpersona"];
			$KeyUrl .= "&amp;idpersona=" . urlencode($this->RecKey["idpersona"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (pais)
		if (!isset($GLOBALS['pais'])) $GLOBALS['pais'] = new cpais();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persona', TRUE);

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
		$this->idpersona->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $persona;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($persona);
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

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["idpersona"] <> "") {
				$this->idpersona->setQueryStringValue($_GET["idpersona"]);
				$this->RecKey["idpersona"] = $this->idpersona->QueryStringValue;
			} else {
				$sReturnUrl = "personalist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "personalist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "personalist.php"; // Not page request, return to list
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
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->tipo_persona->setDbValue($rs->fields('tipo_persona'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->apellido->setDbValue($rs->fields('apellido'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->cui->setDbValue($rs->fields('cui'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->fecha_nacimiento->setDbValue($rs->fields('fecha_nacimiento'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->sexo->setDbValue($rs->fields('sexo'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpersona->DbValue = $row['idpersona'];
		$this->tipo_persona->DbValue = $row['tipo_persona'];
		$this->nombre->DbValue = $row['nombre'];
		$this->apellido->DbValue = $row['apellido'];
		$this->direccion->DbValue = $row['direccion'];
		$this->cui->DbValue = $row['cui'];
		$this->idpais->DbValue = $row['idpais'];
		$this->fecha_nacimiento->DbValue = $row['fecha_nacimiento'];
		$this->_email->DbValue = $row['email'];
		$this->sexo->DbValue = $row['sexo'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->estado->DbValue = $row['estado'];
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

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idpersona
		// tipo_persona
		// nombre
		// apellido
		// direccion
		// cui
		// idpais
		// fecha_nacimiento
		// email
		// sexo
		// fecha_insercion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idpersona
			$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			$this->idpersona->ViewCustomAttributes = "";

			// tipo_persona
			if (strval($this->tipo_persona->CurrentValue) <> "") {
				switch ($this->tipo_persona->CurrentValue) {
					case $this->tipo_persona->FldTagValue(1):
						$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(1) <> "" ? $this->tipo_persona->FldTagCaption(1) : $this->tipo_persona->CurrentValue;
						break;
					case $this->tipo_persona->FldTagValue(2):
						$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(2) <> "" ? $this->tipo_persona->FldTagCaption(2) : $this->tipo_persona->CurrentValue;
						break;
					default:
						$this->tipo_persona->ViewValue = $this->tipo_persona->CurrentValue;
				}
			} else {
				$this->tipo_persona->ViewValue = NULL;
			}
			$this->tipo_persona->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// apellido
			$this->apellido->ViewValue = $this->apellido->CurrentValue;
			$this->apellido->ViewCustomAttributes = "";

			// direccion
			$this->direccion->ViewValue = $this->direccion->CurrentValue;
			$this->direccion->ViewCustomAttributes = "";

			// cui
			$this->cui->ViewValue = $this->cui->CurrentValue;
			$this->cui->ViewCustomAttributes = "";

			// idpais
			if (strval($this->idpais->CurrentValue) <> "") {
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpais->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idpais->ViewValue = $this->idpais->CurrentValue;
				}
			} else {
				$this->idpais->ViewValue = NULL;
			}
			$this->idpais->ViewCustomAttributes = "";

			// fecha_nacimiento
			$this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
			$this->fecha_nacimiento->ViewValue = ew_FormatDateTime($this->fecha_nacimiento->ViewValue, 7);
			$this->fecha_nacimiento->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// sexo
			if (strval($this->sexo->CurrentValue) <> "") {
				switch ($this->sexo->CurrentValue) {
					case $this->sexo->FldTagValue(1):
						$this->sexo->ViewValue = $this->sexo->FldTagCaption(1) <> "" ? $this->sexo->FldTagCaption(1) : $this->sexo->CurrentValue;
						break;
					case $this->sexo->FldTagValue(2):
						$this->sexo->ViewValue = $this->sexo->FldTagCaption(2) <> "" ? $this->sexo->FldTagCaption(2) : $this->sexo->CurrentValue;
						break;
					default:
						$this->sexo->ViewValue = $this->sexo->CurrentValue;
				}
			} else {
				$this->sexo->ViewValue = NULL;
			}
			$this->sexo->ViewCustomAttributes = "";

			// fecha_insercion
			$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
			$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
			$this->fecha_insercion->ViewCustomAttributes = "";

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

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";
			$this->idpersona->TooltipValue = "";

			// tipo_persona
			$this->tipo_persona->LinkCustomAttributes = "";
			$this->tipo_persona->HrefValue = "";
			$this->tipo_persona->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";
			$this->apellido->TooltipValue = "";

			// cui
			$this->cui->LinkCustomAttributes = "";
			$this->cui->HrefValue = "";
			$this->cui->TooltipValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";
			$this->idpais->TooltipValue = "";

			// fecha_nacimiento
			$this->fecha_nacimiento->LinkCustomAttributes = "";
			$this->fecha_nacimiento->HrefValue = "";
			$this->fecha_nacimiento->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// sexo
			$this->sexo->LinkCustomAttributes = "";
			$this->sexo->HrefValue = "";
			$this->sexo->TooltipValue = "";

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
			if ($sMasterTblVar == "pais") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idpais"] <> "") {
					$GLOBALS["pais"]->idpais->setQueryStringValue($_GET["fk_idpais"]);
					$this->idpais->setQueryStringValue($GLOBALS["pais"]->idpais->QueryStringValue);
					$this->idpais->setSessionValue($this->idpais->QueryStringValue);
					if (!is_numeric($GLOBALS["pais"]->idpais->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "pais") {
				if ($this->idpais->QueryStringValue == "") $this->idpais->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "personalist.php", "", $this->TableVar, TRUE);
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
if (!isset($persona_view)) $persona_view = new cpersona_view();

// Page init
$persona_view->Page_Init();

// Page main
$persona_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persona_view->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var persona_view = new ew_Page("persona_view");
persona_view.PageID = "view"; // Page ID
var EW_PAGE_ID = persona_view.PageID; // For backward compatibility

// Form object
var fpersonaview = new ew_Form("fpersonaview");

// Form_CustomValidate event
fpersonaview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonaview.ValidateRequired = true;
<?php } else { ?>
fpersonaview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonaview.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php $persona_view->ExportOptions->Render("body") ?>
<?php
	foreach ($persona_view->OtherOptions as &$option)
		$option->Render("body");
?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $persona_view->ShowPageHeader(); ?>
<?php
$persona_view->ShowMessage();
?>
<form name="fpersonaview" id="fpersonaview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($persona_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $persona_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="persona">
<table class="table table-bordered table-striped ewViewTable">
<?php if ($persona->idpersona->Visible) { // idpersona ?>
	<tr id="r_idpersona">
		<td><span id="elh_persona_idpersona"><?php echo $persona->idpersona->FldCaption() ?></span></td>
		<td<?php echo $persona->idpersona->CellAttributes() ?>>
<span id="el_persona_idpersona" class="form-group">
<span<?php echo $persona->idpersona->ViewAttributes() ?>>
<?php echo $persona->idpersona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
	<tr id="r_tipo_persona">
		<td><span id="elh_persona_tipo_persona"><?php echo $persona->tipo_persona->FldCaption() ?></span></td>
		<td<?php echo $persona->tipo_persona->CellAttributes() ?>>
<span id="el_persona_tipo_persona" class="form-group">
<span<?php echo $persona->tipo_persona->ViewAttributes() ?>>
<?php echo $persona->tipo_persona->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->nombre->Visible) { // nombre ?>
	<tr id="r_nombre">
		<td><span id="elh_persona_nombre"><?php echo $persona->nombre->FldCaption() ?></span></td>
		<td<?php echo $persona->nombre->CellAttributes() ?>>
<span id="el_persona_nombre" class="form-group">
<span<?php echo $persona->nombre->ViewAttributes() ?>>
<?php echo $persona->nombre->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->apellido->Visible) { // apellido ?>
	<tr id="r_apellido">
		<td><span id="elh_persona_apellido"><?php echo $persona->apellido->FldCaption() ?></span></td>
		<td<?php echo $persona->apellido->CellAttributes() ?>>
<span id="el_persona_apellido" class="form-group">
<span<?php echo $persona->apellido->ViewAttributes() ?>>
<?php echo $persona->apellido->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->cui->Visible) { // cui ?>
	<tr id="r_cui">
		<td><span id="elh_persona_cui"><?php echo $persona->cui->FldCaption() ?></span></td>
		<td<?php echo $persona->cui->CellAttributes() ?>>
<span id="el_persona_cui" class="form-group">
<span<?php echo $persona->cui->ViewAttributes() ?>>
<?php echo $persona->cui->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->idpais->Visible) { // idpais ?>
	<tr id="r_idpais">
		<td><span id="elh_persona_idpais"><?php echo $persona->idpais->FldCaption() ?></span></td>
		<td<?php echo $persona->idpais->CellAttributes() ?>>
<span id="el_persona_idpais" class="form-group">
<span<?php echo $persona->idpais->ViewAttributes() ?>>
<?php echo $persona->idpais->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
	<tr id="r_fecha_nacimiento">
		<td><span id="elh_persona_fecha_nacimiento"><?php echo $persona->fecha_nacimiento->FldCaption() ?></span></td>
		<td<?php echo $persona->fecha_nacimiento->CellAttributes() ?>>
<span id="el_persona_fecha_nacimiento" class="form-group">
<span<?php echo $persona->fecha_nacimiento->ViewAttributes() ?>>
<?php echo $persona->fecha_nacimiento->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->_email->Visible) { // email ?>
	<tr id="r__email">
		<td><span id="elh_persona__email"><?php echo $persona->_email->FldCaption() ?></span></td>
		<td<?php echo $persona->_email->CellAttributes() ?>>
<span id="el_persona__email" class="form-group">
<span<?php echo $persona->_email->ViewAttributes() ?>>
<?php echo $persona->_email->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->sexo->Visible) { // sexo ?>
	<tr id="r_sexo">
		<td><span id="elh_persona_sexo"><?php echo $persona->sexo->FldCaption() ?></span></td>
		<td<?php echo $persona->sexo->CellAttributes() ?>>
<span id="el_persona_sexo" class="form-group">
<span<?php echo $persona->sexo->ViewAttributes() ?>>
<?php echo $persona->sexo->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->fecha_insercion->Visible) { // fecha_insercion ?>
	<tr id="r_fecha_insercion">
		<td><span id="elh_persona_fecha_insercion"><?php echo $persona->fecha_insercion->FldCaption() ?></span></td>
		<td<?php echo $persona->fecha_insercion->CellAttributes() ?>>
<span id="el_persona_fecha_insercion" class="form-group">
<span<?php echo $persona->fecha_insercion->ViewAttributes() ?>>
<?php echo $persona->fecha_insercion->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($persona->estado->Visible) { // estado ?>
	<tr id="r_estado">
		<td><span id="elh_persona_estado"><?php echo $persona->estado->FldCaption() ?></span></td>
		<td<?php echo $persona->estado->CellAttributes() ?>>
<span id="el_persona_estado" class="form-group">
<span<?php echo $persona->estado->ViewAttributes() ?>>
<?php echo $persona->estado->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
</form>
<script type="text/javascript">
fpersonaview.Init();
</script>
<?php
$persona_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$persona_view->Page_Terminate();
?>
