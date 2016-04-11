<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "documento_caja_chicainfo.php" ?>
<?php include_once "caja_chicainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$documento_caja_chica_add = NULL; // Initialize page object first

class cdocumento_caja_chica_add extends cdocumento_caja_chica {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'documento_caja_chica';

	// Page object name
	var $PageObjName = 'documento_caja_chica_add';

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

		// Table object (documento_caja_chica)
		if (!isset($GLOBALS["documento_caja_chica"]) || get_class($GLOBALS["documento_caja_chica"]) == "cdocumento_caja_chica") {
			$GLOBALS["documento_caja_chica"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["documento_caja_chica"];
		}

		// Table object (caja_chica)
		if (!isset($GLOBALS['caja_chica'])) $GLOBALS['caja_chica'] = new ccaja_chica();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'documento_caja_chica', TRUE);

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
		global $EW_EXPORT, $documento_caja_chica;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($documento_caja_chica);
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
	var $FormClassName = "form-horizontal ewForm ewAddForm";
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["iddocumento_caja_chica"] != "") {
				$this->iddocumento_caja_chica->setQueryStringValue($_GET["iddocumento_caja_chica"]);
				$this->setKey("iddocumento_caja_chica", $this->iddocumento_caja_chica->CurrentValue); // Set up key
			} else {
				$this->setKey("iddocumento_caja_chica", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		} else {
			if ($this->CurrentAction == "I") // Load default values for blank record
				$this->LoadDefaultValues();
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("documento_caja_chicalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "documento_caja_chicalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "documento_caja_chicaview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD; // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load default values
	function LoadDefaultValues() {
		$this->idcaja_chica->CurrentValue = 1;
		$this->tipo->CurrentValue = "Abono";
		$this->idtipo_documento->CurrentValue = 1;
		$this->serie->CurrentValue = NULL;
		$this->serie->OldValue = $this->serie->CurrentValue;
		$this->numero->CurrentValue = NULL;
		$this->numero->OldValue = $this->numero->CurrentValue;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->monto->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idcaja_chica->FldIsDetailKey) {
			$this->idcaja_chica->setFormValue($objForm->GetValue("x_idcaja_chica"));
		}
		if (!$this->tipo->FldIsDetailKey) {
			$this->tipo->setFormValue($objForm->GetValue("x_tipo"));
		}
		if (!$this->idtipo_documento->FldIsDetailKey) {
			$this->idtipo_documento->setFormValue($objForm->GetValue("x_idtipo_documento"));
		}
		if (!$this->serie->FldIsDetailKey) {
			$this->serie->setFormValue($objForm->GetValue("x_serie"));
		}
		if (!$this->numero->FldIsDetailKey) {
			$this->numero->setFormValue($objForm->GetValue("x_numero"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idcaja_chica->CurrentValue = $this->idcaja_chica->FormValue;
		$this->tipo->CurrentValue = $this->tipo->FormValue;
		$this->idtipo_documento->CurrentValue = $this->idtipo_documento->FormValue;
		$this->serie->CurrentValue = $this->serie->FormValue;
		$this->numero->CurrentValue = $this->numero->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->monto->CurrentValue = $this->monto->FormValue;
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
		$this->iddocumento_caja_chica->setDbValue($rs->fields('iddocumento_caja_chica'));
		$this->idcaja_chica->setDbValue($rs->fields('idcaja_chica'));
		$this->tipo->setDbValue($rs->fields('tipo'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->serie->setDbValue($rs->fields('serie'));
		$this->numero->setDbValue($rs->fields('numero'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->iddocumento_caja_chica->DbValue = $row['iddocumento_caja_chica'];
		$this->idcaja_chica->DbValue = $row['idcaja_chica'];
		$this->tipo->DbValue = $row['tipo'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->serie->DbValue = $row['serie'];
		$this->numero->DbValue = $row['numero'];
		$this->fecha->DbValue = $row['fecha'];
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("iddocumento_caja_chica")) <> "")
			$this->iddocumento_caja_chica->CurrentValue = $this->getKey("iddocumento_caja_chica"); // iddocumento_caja_chica
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
		// Convert decimal values if posted back

		if ($this->monto->FormValue == $this->monto->CurrentValue && is_numeric(ew_StrToFloat($this->monto->CurrentValue)))
			$this->monto->CurrentValue = ew_StrToFloat($this->monto->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// iddocumento_caja_chica
		// idcaja_chica
		// tipo
		// idtipo_documento
		// serie
		// numero
		// fecha
		// monto
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// iddocumento_caja_chica
		$this->iddocumento_caja_chica->ViewValue = $this->iddocumento_caja_chica->CurrentValue;
		$this->iddocumento_caja_chica->ViewCustomAttributes = "";

		// idcaja_chica
		if (strval($this->idcaja_chica->CurrentValue) <> "") {
			$sFilterWrk = "`idcaja_chica`" . ew_SearchString("=", $this->idcaja_chica->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idcaja_chica, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idcaja_chica->ViewValue = $this->idcaja_chica->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
			}
		} else {
			$this->idcaja_chica->ViewValue = NULL;
		}
		$this->idcaja_chica->ViewCustomAttributes = "";

		// tipo
		if (strval($this->tipo->CurrentValue) <> "") {
			$this->tipo->ViewValue = $this->tipo->OptionCaption($this->tipo->CurrentValue);
		} else {
			$this->tipo->ViewValue = NULL;
		}
		$this->tipo->ViewCustomAttributes = "";

		// idtipo_documento
		if (strval($this->idtipo_documento->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
			}
		} else {
			$this->idtipo_documento->ViewValue = NULL;
		}
		$this->idtipo_documento->ViewCustomAttributes = "";

		// serie
		$this->serie->ViewValue = $this->serie->CurrentValue;
		$this->serie->ViewCustomAttributes = "";

		// numero
		$this->numero->ViewValue = $this->numero->CurrentValue;
		$this->numero->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

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

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

			// idcaja_chica
			$this->idcaja_chica->LinkCustomAttributes = "";
			$this->idcaja_chica->HrefValue = "";
			$this->idcaja_chica->TooltipValue = "";

			// tipo
			$this->tipo->LinkCustomAttributes = "";
			$this->tipo->HrefValue = "";
			$this->tipo->TooltipValue = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// serie
			$this->serie->LinkCustomAttributes = "";
			$this->serie->HrefValue = "";
			$this->serie->TooltipValue = "";

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";
			$this->numero->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idcaja_chica
			$this->idcaja_chica->EditAttrs["class"] = "form-control";
			$this->idcaja_chica->EditCustomAttributes = "";
			if ($this->idcaja_chica->getSessionValue() <> "") {
				$this->idcaja_chica->CurrentValue = $this->idcaja_chica->getSessionValue();
			if (strval($this->idcaja_chica->CurrentValue) <> "") {
				$sFilterWrk = "`idcaja_chica`" . ew_SearchString("=", $this->idcaja_chica->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idcaja_chica, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idcaja_chica->ViewValue = $this->idcaja_chica->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
				}
			} else {
				$this->idcaja_chica->ViewValue = NULL;
			}
			$this->idcaja_chica->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idcaja_chica->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcaja_chica`" . ew_SearchString("=", $this->idcaja_chica->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `caja_chica`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idcaja_chica, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcaja_chica->EditValue = $arwrk;
			}

			// tipo
			$this->tipo->EditAttrs["class"] = "form-control";
			$this->tipo->EditCustomAttributes = "";
			$this->tipo->EditValue = $this->tipo->Options(TRUE);

			// idtipo_documento
			$this->idtipo_documento->EditAttrs["class"] = "form-control";
			$this->idtipo_documento->EditCustomAttributes = "";
			if (trim(strval($this->idtipo_documento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idtipo_documento->EditValue = $arwrk;

			// serie
			$this->serie->EditAttrs["class"] = "form-control";
			$this->serie->EditCustomAttributes = "";
			$this->serie->EditValue = ew_HtmlEncode($this->serie->CurrentValue);
			$this->serie->PlaceHolder = ew_RemoveHtml($this->serie->FldCaption());

			// numero
			$this->numero->EditAttrs["class"] = "form-control";
			$this->numero->EditCustomAttributes = "";
			$this->numero->EditValue = ew_HtmlEncode($this->numero->CurrentValue);
			$this->numero->PlaceHolder = ew_RemoveHtml($this->numero->FldCaption());

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// Add refer script
			// idcaja_chica

			$this->idcaja_chica->LinkCustomAttributes = "";
			$this->idcaja_chica->HrefValue = "";

			// tipo
			$this->tipo->LinkCustomAttributes = "";
			$this->tipo->HrefValue = "";

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";

			// serie
			$this->serie->LinkCustomAttributes = "";
			$this->serie->HrefValue = "";

			// numero
			$this->numero->LinkCustomAttributes = "";
			$this->numero->HrefValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";

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
		if (!$this->idcaja_chica->FldIsDetailKey && !is_null($this->idcaja_chica->FormValue) && $this->idcaja_chica->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcaja_chica->FldCaption(), $this->idcaja_chica->ReqErrMsg));
		}
		if (!$this->tipo->FldIsDetailKey && !is_null($this->tipo->FormValue) && $this->tipo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tipo->FldCaption(), $this->tipo->ReqErrMsg));
		}
		if (!$this->idtipo_documento->FldIsDetailKey && !is_null($this->idtipo_documento->FormValue) && $this->idtipo_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idtipo_documento->FldCaption(), $this->idtipo_documento->ReqErrMsg));
		}
		if (!$this->serie->FldIsDetailKey && !is_null($this->serie->FormValue) && $this->serie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->serie->FldCaption(), $this->serie->ReqErrMsg));
		}
		if (!$this->numero->FldIsDetailKey && !is_null($this->numero->FormValue) && $this->numero->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->numero->FldCaption(), $this->numero->ReqErrMsg));
		}
		if (!$this->fecha->FldIsDetailKey && !is_null($this->fecha->FormValue) && $this->fecha->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->fecha->FldCaption(), $this->fecha->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idcaja_chica
		$this->idcaja_chica->SetDbValueDef($rsnew, $this->idcaja_chica->CurrentValue, 0, strval($this->idcaja_chica->CurrentValue) == "");

		// tipo
		$this->tipo->SetDbValueDef($rsnew, $this->tipo->CurrentValue, "", strval($this->tipo->CurrentValue) == "");

		// idtipo_documento
		$this->idtipo_documento->SetDbValueDef($rsnew, $this->idtipo_documento->CurrentValue, 0, strval($this->idtipo_documento->CurrentValue) == "");

		// serie
		$this->serie->SetDbValueDef($rsnew, $this->serie->CurrentValue, "", FALSE);

		// numero
		$this->numero->SetDbValueDef($rsnew, $this->numero->CurrentValue, "", FALSE);

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), ew_CurrentDate(), FALSE);

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->iddocumento_caja_chica->setDbValue($conn->Insert_ID());
				$rsnew['iddocumento_caja_chica'] = $this->iddocumento_caja_chica->DbValue;
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
			if ($sMasterTblVar == "caja_chica") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcaja_chica"] <> "") {
					$GLOBALS["caja_chica"]->idcaja_chica->setQueryStringValue($_GET["fk_idcaja_chica"]);
					$this->idcaja_chica->setQueryStringValue($GLOBALS["caja_chica"]->idcaja_chica->QueryStringValue);
					$this->idcaja_chica->setSessionValue($this->idcaja_chica->QueryStringValue);
					if (!is_numeric($GLOBALS["caja_chica"]->idcaja_chica->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "caja_chica") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idcaja_chica"] <> "") {
					$GLOBALS["caja_chica"]->idcaja_chica->setFormValue($_POST["fk_idcaja_chica"]);
					$this->idcaja_chica->setFormValue($GLOBALS["caja_chica"]->idcaja_chica->FormValue);
					$this->idcaja_chica->setSessionValue($this->idcaja_chica->FormValue);
					if (!is_numeric($GLOBALS["caja_chica"]->idcaja_chica->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "caja_chica") {
				if ($this->idcaja_chica->CurrentValue == "") $this->idcaja_chica->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("documento_caja_chicalist.php"), "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, $url);
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
if (!isset($documento_caja_chica_add)) $documento_caja_chica_add = new cdocumento_caja_chica_add();

// Page init
$documento_caja_chica_add->Page_Init();

// Page main
$documento_caja_chica_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$documento_caja_chica_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fdocumento_caja_chicaadd = new ew_Form("fdocumento_caja_chicaadd", "add");

// Validate form
fdocumento_caja_chicaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcaja_chica");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->idcaja_chica->FldCaption(), $documento_caja_chica->idcaja_chica->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_tipo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->tipo->FldCaption(), $documento_caja_chica->tipo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->idtipo_documento->FldCaption(), $documento_caja_chica->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_serie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->serie->FldCaption(), $documento_caja_chica->serie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_numero");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->numero->FldCaption(), $documento_caja_chica->numero->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->fecha->FldCaption(), $documento_caja_chica->fecha->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_caja_chica->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $documento_caja_chica->monto->FldCaption(), $documento_caja_chica->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($documento_caja_chica->monto->FldErrMsg()) ?>");

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
fdocumento_caja_chicaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fdocumento_caja_chicaadd.ValidateRequired = true;
<?php } else { ?>
fdocumento_caja_chicaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fdocumento_caja_chicaadd.Lists["x_idcaja_chica"] = {"LinkField":"x_idcaja_chica","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaadd.Lists["x_tipo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fdocumento_caja_chicaadd.Lists["x_tipo"].Options = <?php echo json_encode($documento_caja_chica->tipo->Options()) ?>;
fdocumento_caja_chicaadd.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $documento_caja_chica_add->ShowPageHeader(); ?>
<?php
$documento_caja_chica_add->ShowMessage();
?>
<form name="fdocumento_caja_chicaadd" id="fdocumento_caja_chicaadd" class="<?php echo $documento_caja_chica_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($documento_caja_chica_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $documento_caja_chica_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="documento_caja_chica">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($documento_caja_chica->getCurrentMasterTable() == "caja_chica") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="caja_chica">
<input type="hidden" name="fk_idcaja_chica" value="<?php echo $documento_caja_chica->idcaja_chica->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($documento_caja_chica->idcaja_chica->Visible) { // idcaja_chica ?>
	<div id="r_idcaja_chica" class="form-group">
		<label id="elh_documento_caja_chica_idcaja_chica" for="x_idcaja_chica" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->idcaja_chica->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->idcaja_chica->CellAttributes() ?>>
<?php if ($documento_caja_chica->idcaja_chica->getSessionValue() <> "") { ?>
<span id="el_documento_caja_chica_idcaja_chica">
<span<?php echo $documento_caja_chica->idcaja_chica->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $documento_caja_chica->idcaja_chica->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcaja_chica" name="x_idcaja_chica" value="<?php echo ew_HtmlEncode($documento_caja_chica->idcaja_chica->CurrentValue) ?>">
<?php } else { ?>
<span id="el_documento_caja_chica_idcaja_chica">
<select data-table="documento_caja_chica" data-field="x_idcaja_chica" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->idcaja_chica->DisplayValueSeparator) ? json_encode($documento_caja_chica->idcaja_chica->DisplayValueSeparator) : $documento_caja_chica->idcaja_chica->DisplayValueSeparator) ?>" id="x_idcaja_chica" name="x_idcaja_chica"<?php echo $documento_caja_chica->idcaja_chica->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->idcaja_chica->EditValue)) {
	$arwrk = $documento_caja_chica->idcaja_chica->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->idcaja_chica->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->idcaja_chica->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->idcaja_chica->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->idcaja_chica->CurrentValue) ?>" selected><?php echo $documento_caja_chica->idcaja_chica->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcaja_chica`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `caja_chica`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$documento_caja_chica->idcaja_chica->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$documento_caja_chica->idcaja_chica->LookupFilters += array("f0" => "`idcaja_chica` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$documento_caja_chica->Lookup_Selecting($documento_caja_chica->idcaja_chica, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $documento_caja_chica->idcaja_chica->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idcaja_chica" id="s_x_idcaja_chica" value="<?php echo $documento_caja_chica->idcaja_chica->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $documento_caja_chica->idcaja_chica->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->tipo->Visible) { // tipo ?>
	<div id="r_tipo" class="form-group">
		<label id="elh_documento_caja_chica_tipo" for="x_tipo" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->tipo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->tipo->CellAttributes() ?>>
<span id="el_documento_caja_chica_tipo">
<select data-table="documento_caja_chica" data-field="x_tipo" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->tipo->DisplayValueSeparator) ? json_encode($documento_caja_chica->tipo->DisplayValueSeparator) : $documento_caja_chica->tipo->DisplayValueSeparator) ?>" id="x_tipo" name="x_tipo"<?php echo $documento_caja_chica->tipo->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->tipo->EditValue)) {
	$arwrk = $documento_caja_chica->tipo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->tipo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->tipo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->tipo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->tipo->CurrentValue) ?>" selected><?php echo $documento_caja_chica->tipo->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $documento_caja_chica->tipo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->idtipo_documento->Visible) { // idtipo_documento ?>
	<div id="r_idtipo_documento" class="form-group">
		<label id="elh_documento_caja_chica_idtipo_documento" for="x_idtipo_documento" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->idtipo_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->idtipo_documento->CellAttributes() ?>>
<span id="el_documento_caja_chica_idtipo_documento">
<select data-table="documento_caja_chica" data-field="x_idtipo_documento" data-value-separator="<?php echo ew_HtmlEncode(is_array($documento_caja_chica->idtipo_documento->DisplayValueSeparator) ? json_encode($documento_caja_chica->idtipo_documento->DisplayValueSeparator) : $documento_caja_chica->idtipo_documento->DisplayValueSeparator) ?>" id="x_idtipo_documento" name="x_idtipo_documento"<?php echo $documento_caja_chica->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($documento_caja_chica->idtipo_documento->EditValue)) {
	$arwrk = $documento_caja_chica->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($documento_caja_chica->idtipo_documento->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $documento_caja_chica->idtipo_documento->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($documento_caja_chica->idtipo_documento->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($documento_caja_chica->idtipo_documento->CurrentValue) ?>" selected><?php echo $documento_caja_chica->idtipo_documento->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$documento_caja_chica->idtipo_documento->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$documento_caja_chica->idtipo_documento->LookupFilters += array("f0" => "`idtipo_documento` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$documento_caja_chica->Lookup_Selecting($documento_caja_chica->idtipo_documento, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $documento_caja_chica->idtipo_documento->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idtipo_documento" id="s_x_idtipo_documento" value="<?php echo $documento_caja_chica->idtipo_documento->LookupFilterQuery() ?>">
</span>
<?php echo $documento_caja_chica->idtipo_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->serie->Visible) { // serie ?>
	<div id="r_serie" class="form-group">
		<label id="elh_documento_caja_chica_serie" for="x_serie" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->serie->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->serie->CellAttributes() ?>>
<span id="el_documento_caja_chica_serie">
<input type="text" data-table="documento_caja_chica" data-field="x_serie" name="x_serie" id="x_serie" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->serie->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->serie->EditValue ?>"<?php echo $documento_caja_chica->serie->EditAttributes() ?>>
</span>
<?php echo $documento_caja_chica->serie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->numero->Visible) { // numero ?>
	<div id="r_numero" class="form-group">
		<label id="elh_documento_caja_chica_numero" for="x_numero" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->numero->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->numero->CellAttributes() ?>>
<span id="el_documento_caja_chica_numero">
<input type="text" data-table="documento_caja_chica" data-field="x_numero" name="x_numero" id="x_numero" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->numero->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->numero->EditValue ?>"<?php echo $documento_caja_chica->numero->EditAttributes() ?>>
</span>
<?php echo $documento_caja_chica->numero->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_documento_caja_chica_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->fecha->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->fecha->CellAttributes() ?>>
<span id="el_documento_caja_chica_fecha">
<input type="text" data-table="documento_caja_chica" data-field="x_fecha" data-format="7" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->fecha->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->fecha->EditValue ?>"<?php echo $documento_caja_chica->fecha->EditAttributes() ?>>
<?php if (!$documento_caja_chica->fecha->ReadOnly && !$documento_caja_chica->fecha->Disabled && !isset($documento_caja_chica->fecha->EditAttrs["readonly"]) && !isset($documento_caja_chica->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fdocumento_caja_chicaadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $documento_caja_chica->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($documento_caja_chica->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_documento_caja_chica_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $documento_caja_chica->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $documento_caja_chica->monto->CellAttributes() ?>>
<span id="el_documento_caja_chica_monto">
<input type="text" data-table="documento_caja_chica" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($documento_caja_chica->monto->getPlaceHolder()) ?>" value="<?php echo $documento_caja_chica->monto->EditValue ?>"<?php echo $documento_caja_chica->monto->EditAttributes() ?>>
</span>
<?php echo $documento_caja_chica->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $documento_caja_chica_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fdocumento_caja_chicaadd.Init();
</script>
<?php
$documento_caja_chica_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$documento_caja_chica_add->Page_Terminate();
?>
