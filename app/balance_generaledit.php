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

$balance_general_edit = NULL; // Initialize page object first

class cbalance_general_edit extends cbalance_general {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'balance_general';

	// Page object name
	var $PageObjName = 'balance_general_edit';

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

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Table object (periodo_contable)
		if (!isset($GLOBALS['periodo_contable'])) $GLOBALS['periodo_contable'] = new cperiodo_contable();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'balance_general', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

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
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["idbalance_general"] <> "") {
			$this->idbalance_general->setQueryStringValue($_GET["idbalance_general"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->idbalance_general->CurrentValue == "")
			$this->Page_Terminate("balance_generallist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("balance_generallist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "balance_generallist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->activo_circulante->FldIsDetailKey) {
			$this->activo_circulante->setFormValue($objForm->GetValue("x_activo_circulante"));
		}
		if (!$this->activo_fijo->FldIsDetailKey) {
			$this->activo_fijo->setFormValue($objForm->GetValue("x_activo_fijo"));
		}
		if (!$this->pasivo_circulante->FldIsDetailKey) {
			$this->pasivo_circulante->setFormValue($objForm->GetValue("x_pasivo_circulante"));
		}
		if (!$this->pasivo_fijo->FldIsDetailKey) {
			$this->pasivo_fijo->setFormValue($objForm->GetValue("x_pasivo_fijo"));
		}
		if (!$this->capital_contable->FldIsDetailKey) {
			$this->capital_contable->setFormValue($objForm->GetValue("x_capital_contable"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idbalance_general->FldIsDetailKey)
			$this->idbalance_general->setFormValue($objForm->GetValue("x_idbalance_general"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idbalance_general->CurrentValue = $this->idbalance_general->FormValue;
		$this->activo_circulante->CurrentValue = $this->activo_circulante->FormValue;
		$this->activo_fijo->CurrentValue = $this->activo_fijo->FormValue;
		$this->pasivo_circulante->CurrentValue = $this->pasivo_circulante->FormValue;
		$this->pasivo_fijo->CurrentValue = $this->pasivo_fijo->FormValue;
		$this->capital_contable->CurrentValue = $this->capital_contable->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
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

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// activo_circulante
			$this->activo_circulante->EditAttrs["class"] = "form-control";
			$this->activo_circulante->EditCustomAttributes = "";
			$this->activo_circulante->EditValue = ew_HtmlEncode($this->activo_circulante->CurrentValue);
			$this->activo_circulante->PlaceHolder = ew_RemoveHtml($this->activo_circulante->FldCaption());
			if (strval($this->activo_circulante->EditValue) <> "" && is_numeric($this->activo_circulante->EditValue)) $this->activo_circulante->EditValue = ew_FormatNumber($this->activo_circulante->EditValue, -2, -1, -2, 0);

			// activo_fijo
			$this->activo_fijo->EditAttrs["class"] = "form-control";
			$this->activo_fijo->EditCustomAttributes = "";
			$this->activo_fijo->EditValue = ew_HtmlEncode($this->activo_fijo->CurrentValue);
			$this->activo_fijo->PlaceHolder = ew_RemoveHtml($this->activo_fijo->FldCaption());
			if (strval($this->activo_fijo->EditValue) <> "" && is_numeric($this->activo_fijo->EditValue)) $this->activo_fijo->EditValue = ew_FormatNumber($this->activo_fijo->EditValue, -2, -1, -2, 0);

			// pasivo_circulante
			$this->pasivo_circulante->EditAttrs["class"] = "form-control";
			$this->pasivo_circulante->EditCustomAttributes = "";
			$this->pasivo_circulante->EditValue = ew_HtmlEncode($this->pasivo_circulante->CurrentValue);
			$this->pasivo_circulante->PlaceHolder = ew_RemoveHtml($this->pasivo_circulante->FldCaption());
			if (strval($this->pasivo_circulante->EditValue) <> "" && is_numeric($this->pasivo_circulante->EditValue)) $this->pasivo_circulante->EditValue = ew_FormatNumber($this->pasivo_circulante->EditValue, -2, -1, -2, 0);

			// pasivo_fijo
			$this->pasivo_fijo->EditAttrs["class"] = "form-control";
			$this->pasivo_fijo->EditCustomAttributes = "";
			$this->pasivo_fijo->EditValue = ew_HtmlEncode($this->pasivo_fijo->CurrentValue);
			$this->pasivo_fijo->PlaceHolder = ew_RemoveHtml($this->pasivo_fijo->FldCaption());
			if (strval($this->pasivo_fijo->EditValue) <> "" && is_numeric($this->pasivo_fijo->EditValue)) $this->pasivo_fijo->EditValue = ew_FormatNumber($this->pasivo_fijo->EditValue, -2, -1, -2, 0);

			// capital_contable
			$this->capital_contable->EditAttrs["class"] = "form-control";
			$this->capital_contable->EditCustomAttributes = "";
			$this->capital_contable->EditValue = ew_HtmlEncode($this->capital_contable->CurrentValue);
			$this->capital_contable->PlaceHolder = ew_RemoveHtml($this->capital_contable->FldCaption());
			if (strval($this->capital_contable->EditValue) <> "" && is_numeric($this->capital_contable->EditValue)) $this->capital_contable->EditValue = ew_FormatNumber($this->capital_contable->EditValue, -2, -1, -2, 0);

			// estado
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(FALSE);

			// Edit refer script
			// activo_circulante

			$this->activo_circulante->LinkCustomAttributes = "";
			$this->activo_circulante->HrefValue = "";

			// activo_fijo
			$this->activo_fijo->LinkCustomAttributes = "";
			$this->activo_fijo->HrefValue = "";

			// pasivo_circulante
			$this->pasivo_circulante->LinkCustomAttributes = "";
			$this->pasivo_circulante->HrefValue = "";

			// pasivo_fijo
			$this->pasivo_fijo->LinkCustomAttributes = "";
			$this->pasivo_fijo->HrefValue = "";

			// capital_contable
			$this->capital_contable->LinkCustomAttributes = "";
			$this->capital_contable->HrefValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
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
		if (!$this->activo_circulante->FldIsDetailKey && !is_null($this->activo_circulante->FormValue) && $this->activo_circulante->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->activo_circulante->FldCaption(), $this->activo_circulante->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->activo_circulante->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo_circulante->FldErrMsg());
		}
		if (!$this->activo_fijo->FldIsDetailKey && !is_null($this->activo_fijo->FormValue) && $this->activo_fijo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->activo_fijo->FldCaption(), $this->activo_fijo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->activo_fijo->FormValue)) {
			ew_AddMessage($gsFormError, $this->activo_fijo->FldErrMsg());
		}
		if (!$this->pasivo_circulante->FldIsDetailKey && !is_null($this->pasivo_circulante->FormValue) && $this->pasivo_circulante->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pasivo_circulante->FldCaption(), $this->pasivo_circulante->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->pasivo_circulante->FormValue)) {
			ew_AddMessage($gsFormError, $this->pasivo_circulante->FldErrMsg());
		}
		if (!$this->pasivo_fijo->FldIsDetailKey && !is_null($this->pasivo_fijo->FormValue) && $this->pasivo_fijo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->pasivo_fijo->FldCaption(), $this->pasivo_fijo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->pasivo_fijo->FormValue)) {
			ew_AddMessage($gsFormError, $this->pasivo_fijo->FldErrMsg());
		}
		if (!$this->capital_contable->FldIsDetailKey && !is_null($this->capital_contable->FormValue) && $this->capital_contable->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->capital_contable->FldCaption(), $this->capital_contable->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->capital_contable->FormValue)) {
			ew_AddMessage($gsFormError, $this->capital_contable->FldErrMsg());
		}
		if ($this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("balance_general_detalle", $DetailTblVar) && $GLOBALS["balance_general_detalle"]->DetailEdit) {
			if (!isset($GLOBALS["balance_general_detalle_grid"])) $GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid(); // get detail page object
			$GLOBALS["balance_general_detalle_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// activo_circulante
			$this->activo_circulante->SetDbValueDef($rsnew, $this->activo_circulante->CurrentValue, 0, $this->activo_circulante->ReadOnly);

			// activo_fijo
			$this->activo_fijo->SetDbValueDef($rsnew, $this->activo_fijo->CurrentValue, 0, $this->activo_fijo->ReadOnly);

			// pasivo_circulante
			$this->pasivo_circulante->SetDbValueDef($rsnew, $this->pasivo_circulante->CurrentValue, 0, $this->pasivo_circulante->ReadOnly);

			// pasivo_fijo
			$this->pasivo_fijo->SetDbValueDef($rsnew, $this->pasivo_fijo->CurrentValue, 0, $this->pasivo_fijo->ReadOnly);

			// capital_contable
			$this->capital_contable->SetDbValueDef($rsnew, $this->capital_contable->CurrentValue, 0, $this->capital_contable->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("balance_general_detalle", $DetailTblVar) && $GLOBALS["balance_general_detalle"]->DetailEdit) {
						if (!isset($GLOBALS["balance_general_detalle_grid"])) $GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid(); // Get detail page object
						$EditRow = $GLOBALS["balance_general_detalle_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

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
			if (in_array("balance_general_detalle", $DetailTblVar)) {
				if (!isset($GLOBALS["balance_general_detalle_grid"]))
					$GLOBALS["balance_general_detalle_grid"] = new cbalance_general_detalle_grid;
				if ($GLOBALS["balance_general_detalle_grid"]->DetailEdit) {
					$GLOBALS["balance_general_detalle_grid"]->CurrentMode = "edit";
					$GLOBALS["balance_general_detalle_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["balance_general_detalle_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["balance_general_detalle_grid"]->setStartRecordNumber(1);
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->FldIsDetailKey = TRUE;
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->CurrentValue = $this->idbalance_general->CurrentValue;
					$GLOBALS["balance_general_detalle_grid"]->idbalance_general->setSessionValue($GLOBALS["balance_general_detalle_grid"]->idbalance_general->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("balance_generallist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($balance_general_edit)) $balance_general_edit = new cbalance_general_edit();

// Page init
$balance_general_edit->Page_Init();

// Page main
$balance_general_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$balance_general_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fbalance_generaledit = new ew_Form("fbalance_generaledit", "edit");

// Validate form
fbalance_generaledit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_activo_circulante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->activo_circulante->FldCaption(), $balance_general->activo_circulante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_activo_circulante");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->activo_circulante->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_activo_fijo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->activo_fijo->FldCaption(), $balance_general->activo_fijo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_activo_fijo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->activo_fijo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_circulante");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->pasivo_circulante->FldCaption(), $balance_general->pasivo_circulante->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_circulante");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->pasivo_circulante->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_fijo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->pasivo_fijo->FldCaption(), $balance_general->pasivo_fijo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_pasivo_fijo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->pasivo_fijo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_capital_contable");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->capital_contable->FldCaption(), $balance_general->capital_contable->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_capital_contable");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($balance_general->capital_contable->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $balance_general->estado->FldCaption(), $balance_general->estado->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fbalance_generaledit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fbalance_generaledit.ValidateRequired = true;
<?php } else { ?>
fbalance_generaledit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fbalance_generaledit.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fbalance_generaledit.Lists["x_estado"].Options = <?php echo json_encode($balance_general->estado->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php $balance_general_edit->ShowPageHeader(); ?>
<?php
$balance_general_edit->ShowMessage();
?>
<form name="fbalance_generaledit" id="fbalance_generaledit" class="<?php echo $balance_general_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($balance_general_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $balance_general_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="balance_general">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($balance_general->getCurrentMasterTable() == "empresa") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="empresa">
<input type="hidden" name="fk_idempresa" value="<?php echo $balance_general->idempresa->getSessionValue() ?>">
<?php } ?>
<?php if ($balance_general->getCurrentMasterTable() == "periodo_contable") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="periodo_contable">
<input type="hidden" name="fk_idperiodo_contable" value="<?php echo $balance_general->idperioso_contable->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($balance_general->activo_circulante->Visible) { // activo_circulante ?>
	<div id="r_activo_circulante" class="form-group">
		<label id="elh_balance_general_activo_circulante" for="x_activo_circulante" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->activo_circulante->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->activo_circulante->CellAttributes() ?>>
<span id="el_balance_general_activo_circulante">
<input type="text" data-table="balance_general" data-field="x_activo_circulante" name="x_activo_circulante" id="x_activo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_circulante->EditValue ?>"<?php echo $balance_general->activo_circulante->EditAttributes() ?>>
</span>
<?php echo $balance_general->activo_circulante->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($balance_general->activo_fijo->Visible) { // activo_fijo ?>
	<div id="r_activo_fijo" class="form-group">
		<label id="elh_balance_general_activo_fijo" for="x_activo_fijo" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->activo_fijo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->activo_fijo->CellAttributes() ?>>
<span id="el_balance_general_activo_fijo">
<input type="text" data-table="balance_general" data-field="x_activo_fijo" name="x_activo_fijo" id="x_activo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->activo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->activo_fijo->EditValue ?>"<?php echo $balance_general->activo_fijo->EditAttributes() ?>>
</span>
<?php echo $balance_general->activo_fijo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($balance_general->pasivo_circulante->Visible) { // pasivo_circulante ?>
	<div id="r_pasivo_circulante" class="form-group">
		<label id="elh_balance_general_pasivo_circulante" for="x_pasivo_circulante" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->pasivo_circulante->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->pasivo_circulante->CellAttributes() ?>>
<span id="el_balance_general_pasivo_circulante">
<input type="text" data-table="balance_general" data-field="x_pasivo_circulante" name="x_pasivo_circulante" id="x_pasivo_circulante" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_circulante->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_circulante->EditValue ?>"<?php echo $balance_general->pasivo_circulante->EditAttributes() ?>>
</span>
<?php echo $balance_general->pasivo_circulante->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($balance_general->pasivo_fijo->Visible) { // pasivo_fijo ?>
	<div id="r_pasivo_fijo" class="form-group">
		<label id="elh_balance_general_pasivo_fijo" for="x_pasivo_fijo" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->pasivo_fijo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->pasivo_fijo->CellAttributes() ?>>
<span id="el_balance_general_pasivo_fijo">
<input type="text" data-table="balance_general" data-field="x_pasivo_fijo" name="x_pasivo_fijo" id="x_pasivo_fijo" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->pasivo_fijo->getPlaceHolder()) ?>" value="<?php echo $balance_general->pasivo_fijo->EditValue ?>"<?php echo $balance_general->pasivo_fijo->EditAttributes() ?>>
</span>
<?php echo $balance_general->pasivo_fijo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($balance_general->capital_contable->Visible) { // capital_contable ?>
	<div id="r_capital_contable" class="form-group">
		<label id="elh_balance_general_capital_contable" for="x_capital_contable" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->capital_contable->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->capital_contable->CellAttributes() ?>>
<span id="el_balance_general_capital_contable">
<input type="text" data-table="balance_general" data-field="x_capital_contable" name="x_capital_contable" id="x_capital_contable" size="30" placeholder="<?php echo ew_HtmlEncode($balance_general->capital_contable->getPlaceHolder()) ?>" value="<?php echo $balance_general->capital_contable->EditValue ?>"<?php echo $balance_general->capital_contable->EditAttributes() ?>>
</span>
<?php echo $balance_general->capital_contable->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($balance_general->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_balance_general_estado" class="col-sm-2 control-label ewLabel"><?php echo $balance_general->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $balance_general->estado->CellAttributes() ?>>
<span id="el_balance_general_estado">
<div id="tp_x_estado" class="ewTemplate"><input type="radio" data-table="balance_general" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($balance_general->estado->DisplayValueSeparator) ? json_encode($balance_general->estado->DisplayValueSeparator) : $balance_general->estado->DisplayValueSeparator) ?>" name="x_estado" id="x_estado" value="{value}"<?php echo $balance_general->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $balance_general->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($balance_general->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="balance_general" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $balance_general->estado->EditAttributes() ?>><?php echo $balance_general->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($balance_general->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="balance_general" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($balance_general->estado->CurrentValue) ?>" checked<?php echo $balance_general->estado->EditAttributes() ?>><?php echo $balance_general->estado->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $balance_general->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="balance_general" data-field="x_idbalance_general" name="x_idbalance_general" id="x_idbalance_general" value="<?php echo ew_HtmlEncode($balance_general->idbalance_general->CurrentValue) ?>">
<?php
	if (in_array("balance_general_detalle", explode(",", $balance_general->getCurrentDetailTable())) && $balance_general_detalle->DetailEdit) {
?>
<?php if ($balance_general->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("balance_general_detalle", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "balance_general_detallegrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $balance_general_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fbalance_generaledit.Init();
</script>
<?php
$balance_general_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$balance_general_edit->Page_Terminate();
?>
