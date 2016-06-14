<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "partidainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$partida_add = NULL; // Initialize page object first

class cpartida_add extends cpartida {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'partida';

	// Page object name
	var $PageObjName = 'partida_add';

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

		// Table object (partida)
		if (!isset($GLOBALS["partida"]) || get_class($GLOBALS["partida"]) == "cpartida") {
			$GLOBALS["partida"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["partida"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'partida', TRUE);

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
		global $EW_EXPORT, $partida;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($partida);
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

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["idpartida"] != "") {
				$this->idpartida->setQueryStringValue($_GET["idpartida"]);
				$this->setKey("idpartida", $this->idpartida->CurrentValue); // Set up key
			} else {
				$this->setKey("idpartida", ""); // Clear key
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
					$this->Page_Terminate("partidalist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "partidalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "partidaview.php")
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
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->idcuenta_cargo->CurrentValue = NULL;
		$this->idcuenta_cargo->OldValue = $this->idcuenta_cargo->CurrentValue;
		$this->idcuenta_abono->CurrentValue = NULL;
		$this->idcuenta_abono->OldValue = $this->idcuenta_abono->CurrentValue;
		$this->monto->CurrentValue = 0;
		$this->estado->CurrentValue = "Activo";
		$this->descripcion->CurrentValue = NULL;
		$this->descripcion->OldValue = $this->descripcion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->idcuenta_cargo->FldIsDetailKey) {
			$this->idcuenta_cargo->setFormValue($objForm->GetValue("x_idcuenta_cargo"));
		}
		if (!$this->idcuenta_abono->FldIsDetailKey) {
			$this->idcuenta_abono->setFormValue($objForm->GetValue("x_idcuenta_abono"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->descripcion->FldIsDetailKey) {
			$this->descripcion->setFormValue($objForm->GetValue("x_descripcion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->idcuenta_cargo->CurrentValue = $this->idcuenta_cargo->FormValue;
		$this->idcuenta_abono->CurrentValue = $this->idcuenta_abono->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
		$this->descripcion->CurrentValue = $this->descripcion->FormValue;
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
		$this->idpartida->setDbValue($rs->fields('idpartida'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->idcuenta_cargo->setDbValue($rs->fields('idcuenta_cargo'));
		$this->idcuenta_abono->setDbValue($rs->fields('idcuenta_abono'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpartida->DbValue = $row['idpartida'];
		$this->fecha->DbValue = $row['fecha'];
		$this->idcuenta_cargo->DbValue = $row['idcuenta_cargo'];
		$this->idcuenta_abono->DbValue = $row['idcuenta_abono'];
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
		$this->descripcion->DbValue = $row['descripcion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idpartida")) <> "")
			$this->idpartida->CurrentValue = $this->getKey("idpartida"); // idpartida
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
		// idpartida
		// fecha
		// idcuenta_cargo
		// idcuenta_abono
		// monto
		// estado
		// descripcion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idpartida
		$this->idpartida->ViewValue = $this->idpartida->CurrentValue;
		$this->idpartida->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// idcuenta_cargo
		$this->idcuenta_cargo->ViewValue = $this->idcuenta_cargo->CurrentValue;
		$this->idcuenta_cargo->ViewCustomAttributes = "";

		// idcuenta_abono
		$this->idcuenta_abono->ViewValue = $this->idcuenta_abono->CurrentValue;
		$this->idcuenta_abono->ViewCustomAttributes = "";

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

		// descripcion
		$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
		$this->descripcion->ViewCustomAttributes = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// idcuenta_cargo
			$this->idcuenta_cargo->LinkCustomAttributes = "";
			$this->idcuenta_cargo->HrefValue = "";
			$this->idcuenta_cargo->TooltipValue = "";

			// idcuenta_abono
			$this->idcuenta_abono->LinkCustomAttributes = "";
			$this->idcuenta_abono->HrefValue = "";
			$this->idcuenta_abono->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
			$this->descripcion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// idcuenta_cargo
			$this->idcuenta_cargo->EditAttrs["class"] = "form-control";
			$this->idcuenta_cargo->EditCustomAttributes = "";
			$this->idcuenta_cargo->EditValue = ew_HtmlEncode($this->idcuenta_cargo->CurrentValue);
			$this->idcuenta_cargo->PlaceHolder = ew_RemoveHtml($this->idcuenta_cargo->FldCaption());

			// idcuenta_abono
			$this->idcuenta_abono->EditAttrs["class"] = "form-control";
			$this->idcuenta_abono->EditCustomAttributes = "";
			$this->idcuenta_abono->EditValue = ew_HtmlEncode($this->idcuenta_abono->CurrentValue);
			$this->idcuenta_abono->PlaceHolder = ew_RemoveHtml($this->idcuenta_abono->FldCaption());

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// estado
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(FALSE);

			// descripcion
			$this->descripcion->EditAttrs["class"] = "form-control";
			$this->descripcion->EditCustomAttributes = "";
			$this->descripcion->EditValue = ew_HtmlEncode($this->descripcion->CurrentValue);
			$this->descripcion->PlaceHolder = ew_RemoveHtml($this->descripcion->FldCaption());

			// Add refer script
			// fecha

			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";

			// idcuenta_cargo
			$this->idcuenta_cargo->LinkCustomAttributes = "";
			$this->idcuenta_cargo->HrefValue = "";

			// idcuenta_abono
			$this->idcuenta_abono->LinkCustomAttributes = "";
			$this->idcuenta_abono->HrefValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";

			// descripcion
			$this->descripcion->LinkCustomAttributes = "";
			$this->descripcion->HrefValue = "";
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
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}
		if (!$this->idcuenta_cargo->FldIsDetailKey && !is_null($this->idcuenta_cargo->FormValue) && $this->idcuenta_cargo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta_cargo->FldCaption(), $this->idcuenta_cargo->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcuenta_cargo->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcuenta_cargo->FldErrMsg());
		}
		if (!$this->idcuenta_abono->FldIsDetailKey && !is_null($this->idcuenta_abono->FormValue) && $this->idcuenta_abono->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta_abono->FldCaption(), $this->idcuenta_abono->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcuenta_abono->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcuenta_abono->FldErrMsg());
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if ($this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
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

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// idcuenta_cargo
		$this->idcuenta_cargo->SetDbValueDef($rsnew, $this->idcuenta_cargo->CurrentValue, 0, FALSE);

		// idcuenta_abono
		$this->idcuenta_abono->SetDbValueDef($rsnew, $this->idcuenta_abono->CurrentValue, 0, FALSE);

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// estado
		$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", strval($this->estado->CurrentValue) == "");

		// descripcion
		$this->descripcion->SetDbValueDef($rsnew, $this->descripcion->CurrentValue, NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idpartida->setDbValue($conn->Insert_ID());
				$rsnew['idpartida'] = $this->idpartida->DbValue;
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("partidalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($partida_add)) $partida_add = new cpartida_add();

// Page init
$partida_add->Page_Init();

// Page main
$partida_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$partida_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpartidaadd = new ew_Form("fpartidaadd", "add");

// Validate form
fpartidaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($partida->fecha->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_cargo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $partida->idcuenta_cargo->FldCaption(), $partida->idcuenta_cargo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_cargo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($partida->idcuenta_cargo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_abono");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $partida->idcuenta_abono->FldCaption(), $partida->idcuenta_abono->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_abono");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($partida->idcuenta_abono->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $partida->monto->FldCaption(), $partida->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($partida->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $partida->estado->FldCaption(), $partida->estado->ReqErrMsg)) ?>");

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
fpartidaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpartidaadd.ValidateRequired = true;
<?php } else { ?>
fpartidaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpartidaadd.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpartidaadd.Lists["x_estado"].Options = <?php echo json_encode($partida->estado->Options()) ?>;

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
<?php $partida_add->ShowPageHeader(); ?>
<?php
$partida_add->ShowMessage();
?>
<form name="fpartidaadd" id="fpartidaadd" class="<?php echo $partida_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($partida_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $partida_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="partida">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($partida->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_partida_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $partida->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $partida->fecha->CellAttributes() ?>>
<span id="el_partida_fecha">
<input type="text" data-table="partida" data-field="x_fecha" data-format="7" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($partida->fecha->getPlaceHolder()) ?>" value="<?php echo $partida->fecha->EditValue ?>"<?php echo $partida->fecha->EditAttributes() ?>>
</span>
<?php echo $partida->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($partida->idcuenta_cargo->Visible) { // idcuenta_cargo ?>
	<div id="r_idcuenta_cargo" class="form-group">
		<label id="elh_partida_idcuenta_cargo" for="x_idcuenta_cargo" class="col-sm-2 control-label ewLabel"><?php echo $partida->idcuenta_cargo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $partida->idcuenta_cargo->CellAttributes() ?>>
<span id="el_partida_idcuenta_cargo">
<input type="text" data-table="partida" data-field="x_idcuenta_cargo" name="x_idcuenta_cargo" id="x_idcuenta_cargo" size="30" placeholder="<?php echo ew_HtmlEncode($partida->idcuenta_cargo->getPlaceHolder()) ?>" value="<?php echo $partida->idcuenta_cargo->EditValue ?>"<?php echo $partida->idcuenta_cargo->EditAttributes() ?>>
</span>
<?php echo $partida->idcuenta_cargo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($partida->idcuenta_abono->Visible) { // idcuenta_abono ?>
	<div id="r_idcuenta_abono" class="form-group">
		<label id="elh_partida_idcuenta_abono" for="x_idcuenta_abono" class="col-sm-2 control-label ewLabel"><?php echo $partida->idcuenta_abono->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $partida->idcuenta_abono->CellAttributes() ?>>
<span id="el_partida_idcuenta_abono">
<input type="text" data-table="partida" data-field="x_idcuenta_abono" name="x_idcuenta_abono" id="x_idcuenta_abono" size="30" placeholder="<?php echo ew_HtmlEncode($partida->idcuenta_abono->getPlaceHolder()) ?>" value="<?php echo $partida->idcuenta_abono->EditValue ?>"<?php echo $partida->idcuenta_abono->EditAttributes() ?>>
</span>
<?php echo $partida->idcuenta_abono->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($partida->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_partida_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $partida->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $partida->monto->CellAttributes() ?>>
<span id="el_partida_monto">
<input type="text" data-table="partida" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($partida->monto->getPlaceHolder()) ?>" value="<?php echo $partida->monto->EditValue ?>"<?php echo $partida->monto->EditAttributes() ?>>
</span>
<?php echo $partida->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($partida->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_partida_estado" class="col-sm-2 control-label ewLabel"><?php echo $partida->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $partida->estado->CellAttributes() ?>>
<span id="el_partida_estado">
<div id="tp_x_estado" class="ewTemplate"><input type="radio" data-table="partida" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($partida->estado->DisplayValueSeparator) ? json_encode($partida->estado->DisplayValueSeparator) : $partida->estado->DisplayValueSeparator) ?>" name="x_estado" id="x_estado" value="{value}"<?php echo $partida->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $partida->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($partida->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="partida" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $partida->estado->EditAttributes() ?>><?php echo $partida->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($partida->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="partida" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($partida->estado->CurrentValue) ?>" checked<?php echo $partida->estado->EditAttributes() ?>><?php echo $partida->estado->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $partida->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($partida->descripcion->Visible) { // descripcion ?>
	<div id="r_descripcion" class="form-group">
		<label id="elh_partida_descripcion" for="x_descripcion" class="col-sm-2 control-label ewLabel"><?php echo $partida->descripcion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $partida->descripcion->CellAttributes() ?>>
<span id="el_partida_descripcion">
<input type="text" data-table="partida" data-field="x_descripcion" name="x_descripcion" id="x_descripcion" size="30" maxlength="128" placeholder="<?php echo ew_HtmlEncode($partida->descripcion->getPlaceHolder()) ?>" value="<?php echo $partida->descripcion->EditValue ?>"<?php echo $partida->descripcion->EditAttributes() ?>>
</span>
<?php echo $partida->descripcion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $partida_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpartidaadd.Init();
</script>
<?php
$partida_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$partida_add->Page_Terminate();
?>
