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

$caja_chica_aplicacion_add = NULL; // Initialize page object first

class ccaja_chica_aplicacion_add extends ccaja_chica_aplicacion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'caja_chica_aplicacion';

	// Page object name
	var $PageObjName = 'caja_chica_aplicacion_add';

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

		// Table object (caja_chica_aplicacion)
		if (!isset($GLOBALS["caja_chica_aplicacion"]) || get_class($GLOBALS["caja_chica_aplicacion"]) == "ccaja_chica_aplicacion") {
			$GLOBALS["caja_chica_aplicacion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["caja_chica_aplicacion"];
		}

		// Table object (caja_chica_detalle)
		if (!isset($GLOBALS['caja_chica_detalle'])) $GLOBALS['caja_chica_detalle'] = new ccaja_chica_detalle();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caja_chica_aplicacion', TRUE);

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

			// Process auto fill for detail table 'documento_caja_chica'
			if (@$_POST["grid"] == "fdocumento_caja_chicagrid") {
				if (!isset($GLOBALS["documento_caja_chica_grid"])) $GLOBALS["documento_caja_chica_grid"] = new cdocumento_caja_chica_grid;
				$GLOBALS["documento_caja_chica_grid"]->Page_Init();
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
			if (@$_GET["idcaja_chica_aplicacion"] != "") {
				$this->idcaja_chica_aplicacion->setQueryStringValue($_GET["idcaja_chica_aplicacion"]);
				$this->setKey("idcaja_chica_aplicacion", $this->idcaja_chica_aplicacion->CurrentValue); // Set up key
			} else {
				$this->setKey("idcaja_chica_aplicacion", ""); // Clear key
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

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("caja_chica_aplicacionlist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					if ($this->getCurrentDetailTable() <> "") // Master/detail add
						$sReturnUrl = $this->GetDetailUrl();
					else
						$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "caja_chica_aplicacionlist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "caja_chica_aplicacionview.php")
						$sReturnUrl = $this->GetViewUrl(); // View page, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		$this->idcaja_chica_detalle->CurrentValue = 1;
		$this->idreferencia->CurrentValue = NULL;
		$this->idreferencia->OldValue = $this->idreferencia->CurrentValue;
		$this->tabla_referencia->CurrentValue = NULL;
		$this->tabla_referencia->OldValue = $this->tabla_referencia->CurrentValue;
		$this->monto->CurrentValue = 0.00;
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idcaja_chica_detalle->FldIsDetailKey) {
			$this->idcaja_chica_detalle->setFormValue($objForm->GetValue("x_idcaja_chica_detalle"));
		}
		if (!$this->idreferencia->FldIsDetailKey) {
			$this->idreferencia->setFormValue($objForm->GetValue("x_idreferencia"));
		}
		if (!$this->tabla_referencia->FldIsDetailKey) {
			$this->tabla_referencia->setFormValue($objForm->GetValue("x_tabla_referencia"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idcaja_chica_detalle->CurrentValue = $this->idcaja_chica_detalle->FormValue;
		$this->idreferencia->CurrentValue = $this->idreferencia->FormValue;
		$this->tabla_referencia->CurrentValue = $this->tabla_referencia->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcaja_chica_aplicacion")) <> "")
			$this->idcaja_chica_aplicacion->CurrentValue = $this->getKey("idcaja_chica_aplicacion"); // idcaja_chica_aplicacion
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idcaja_chica_detalle
			$this->idcaja_chica_detalle->EditAttrs["class"] = "form-control";
			$this->idcaja_chica_detalle->EditCustomAttributes = "";
			if ($this->idcaja_chica_detalle->getSessionValue() <> "") {
				$this->idcaja_chica_detalle->CurrentValue = $this->idcaja_chica_detalle->getSessionValue();
			$this->idcaja_chica_detalle->ViewValue = $this->idcaja_chica_detalle->CurrentValue;
			$this->idcaja_chica_detalle->ViewCustomAttributes = "";
			} else {
			$this->idcaja_chica_detalle->EditValue = ew_HtmlEncode($this->idcaja_chica_detalle->CurrentValue);
			$this->idcaja_chica_detalle->PlaceHolder = ew_RemoveHtml($this->idcaja_chica_detalle->FldCaption());
			}

			// idreferencia
			$this->idreferencia->EditAttrs["class"] = "form-control";
			$this->idreferencia->EditCustomAttributes = "";
			$this->idreferencia->EditValue = ew_HtmlEncode($this->idreferencia->CurrentValue);
			$this->idreferencia->PlaceHolder = ew_RemoveHtml($this->idreferencia->FldCaption());

			// tabla_referencia
			$this->tabla_referencia->EditAttrs["class"] = "form-control";
			$this->tabla_referencia->EditCustomAttributes = "";
			$this->tabla_referencia->EditValue = ew_HtmlEncode($this->tabla_referencia->CurrentValue);
			$this->tabla_referencia->PlaceHolder = ew_RemoveHtml($this->tabla_referencia->FldCaption());

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// fecha
			$this->fecha->EditAttrs["class"] = "form-control";
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

			// Add refer script
			// idcaja_chica_detalle

			$this->idcaja_chica_detalle->LinkCustomAttributes = "";
			$this->idcaja_chica_detalle->HrefValue = "";

			// idreferencia
			$this->idreferencia->LinkCustomAttributes = "";
			$this->idreferencia->HrefValue = "";

			// tabla_referencia
			$this->tabla_referencia->LinkCustomAttributes = "";
			$this->tabla_referencia->HrefValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
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
		if (!$this->idcaja_chica_detalle->FldIsDetailKey && !is_null($this->idcaja_chica_detalle->FormValue) && $this->idcaja_chica_detalle->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcaja_chica_detalle->FldCaption(), $this->idcaja_chica_detalle->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcaja_chica_detalle->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcaja_chica_detalle->FldErrMsg());
		}
		if (!ew_CheckInteger($this->idreferencia->FormValue)) {
			ew_AddMessage($gsFormError, $this->idreferencia->FldErrMsg());
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("documento_caja_chica", $DetailTblVar) && $GLOBALS["documento_caja_chica"]->DetailAdd) {
			if (!isset($GLOBALS["documento_caja_chica_grid"])) $GLOBALS["documento_caja_chica_grid"] = new cdocumento_caja_chica_grid(); // get detail page object
			$GLOBALS["documento_caja_chica_grid"]->ValidateGridForm();
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

		// Check referential integrity for master table 'caja_chica_detalle'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_caja_chica_detalle();
		if (strval($this->idcaja_chica_detalle->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@idcaja_chica_detalle@", ew_AdjustSql($this->idcaja_chica_detalle->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			$rsmaster = $GLOBALS["caja_chica_detalle"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "caja_chica_detalle", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle->SetDbValueDef($rsnew, $this->idcaja_chica_detalle->CurrentValue, 0, strval($this->idcaja_chica_detalle->CurrentValue) == "");

		// idreferencia
		$this->idreferencia->SetDbValueDef($rsnew, $this->idreferencia->CurrentValue, NULL, FALSE);

		// tabla_referencia
		$this->tabla_referencia->SetDbValueDef($rsnew, $this->tabla_referencia->CurrentValue, NULL, FALSE);

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idcaja_chica_aplicacion->setDbValue($conn->Insert_ID());
				$rsnew['idcaja_chica_aplicacion'] = $this->idcaja_chica_aplicacion->DbValue;
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

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("documento_caja_chica", $DetailTblVar) && $GLOBALS["documento_caja_chica"]->DetailAdd) {
				$GLOBALS["documento_caja_chica"]->iddocumento_caja_chica->setSessionValue($this->idreferencia->CurrentValue); // Set master key
				if (!isset($GLOBALS["documento_caja_chica_grid"])) $GLOBALS["documento_caja_chica_grid"] = new cdocumento_caja_chica_grid(); // Get detail page object
				$AddRow = $GLOBALS["documento_caja_chica_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["documento_caja_chica"]->iddocumento_caja_chica->setSessionValue(""); // Clear master key if insert failed
			}
		}

		// Commit/Rollback transaction
		if ($this->getCurrentDetailTable() <> "") {
			if ($AddRow) {
				$conn->CommitTrans(); // Commit transaction
			} else {
				$conn->RollbackTrans(); // Rollback transaction
			}
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
				if ($GLOBALS["documento_caja_chica_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["documento_caja_chica_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["documento_caja_chica_grid"]->CurrentMode = "add";
					$GLOBALS["documento_caja_chica_grid"]->CurrentAction = "gridadd";

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
if (!isset($caja_chica_aplicacion_add)) $caja_chica_aplicacion_add = new ccaja_chica_aplicacion_add();

// Page init
$caja_chica_aplicacion_add->Page_Init();

// Page main
$caja_chica_aplicacion_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_aplicacion_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcaja_chica_aplicacionadd = new ew_Form("fcaja_chica_aplicacionadd", "add");

// Validate form
fcaja_chica_aplicacionadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idcaja_chica_detalle");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption(), $caja_chica_aplicacion->idcaja_chica_detalle->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcaja_chica_detalle");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->idcaja_chica_detalle->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_idreferencia");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->idreferencia->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica_aplicacion->monto->FldCaption(), $caja_chica_aplicacion->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->monto->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($caja_chica_aplicacion->fecha->FldErrMsg()) ?>");

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
fcaja_chica_aplicacionadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_aplicacionadd.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_aplicacionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
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
<?php $caja_chica_aplicacion_add->ShowPageHeader(); ?>
<?php
$caja_chica_aplicacion_add->ShowMessage();
?>
<form name="fcaja_chica_aplicacionadd" id="fcaja_chica_aplicacionadd" class="<?php echo $caja_chica_aplicacion_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($caja_chica_aplicacion_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $caja_chica_aplicacion_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="caja_chica_aplicacion">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($caja_chica_aplicacion->getCurrentMasterTable() == "caja_chica_detalle") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="caja_chica_detalle">
<input type="hidden" name="fk_idcaja_chica_detalle" value="<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
	<div id="r_idcaja_chica_detalle" class="form-group">
		<label id="elh_caja_chica_aplicacion_idcaja_chica_detalle" for="x_idcaja_chica_detalle" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CellAttributes() ?>>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->getSessionValue() <> "") { ?>
<span id="el_caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcaja_chica_detalle" name="x_idcaja_chica_detalle" value="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->CurrentValue) ?>">
<?php } else { ?>
<span id="el_caja_chica_aplicacion_idcaja_chica_detalle">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idcaja_chica_detalle" name="x_idcaja_chica_detalle" id="x_idcaja_chica_detalle" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idcaja_chica_detalle->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditValue ?>"<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
	<div id="r_idreferencia" class="form-group">
		<label id="elh_caja_chica_aplicacion_idreferencia" for="x_idreferencia" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica_aplicacion->idreferencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_idreferencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_idreferencia" name="x_idreferencia" id="x_idreferencia" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->idreferencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->idreferencia->EditValue ?>"<?php echo $caja_chica_aplicacion->idreferencia->EditAttributes() ?>>
</span>
<?php echo $caja_chica_aplicacion->idreferencia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
	<div id="r_tabla_referencia" class="form-group">
		<label id="elh_caja_chica_aplicacion_tabla_referencia" for="x_tabla_referencia" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica_aplicacion->tabla_referencia->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_tabla_referencia">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_tabla_referencia" name="x_tabla_referencia" id="x_tabla_referencia" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->tabla_referencia->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->tabla_referencia->EditValue ?>"<?php echo $caja_chica_aplicacion->tabla_referencia->EditAttributes() ?>>
</span>
<?php echo $caja_chica_aplicacion->tabla_referencia->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_caja_chica_aplicacion_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica_aplicacion->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica_aplicacion->monto->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_monto">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->monto->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->monto->EditValue ?>"<?php echo $caja_chica_aplicacion->monto->EditAttributes() ?>>
</span>
<?php echo $caja_chica_aplicacion->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
	<div id="r_fecha" class="form-group">
		<label id="elh_caja_chica_aplicacion_fecha" for="x_fecha" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica_aplicacion->fecha->CellAttributes() ?>>
<span id="el_caja_chica_aplicacion_fecha">
<input type="text" data-table="caja_chica_aplicacion" data-field="x_fecha" data-format="7" name="x_fecha" id="x_fecha" placeholder="<?php echo ew_HtmlEncode($caja_chica_aplicacion->fecha->getPlaceHolder()) ?>" value="<?php echo $caja_chica_aplicacion->fecha->EditValue ?>"<?php echo $caja_chica_aplicacion->fecha->EditAttributes() ?>>
<?php if (!$caja_chica_aplicacion->fecha->ReadOnly && !$caja_chica_aplicacion->fecha->Disabled && !isset($caja_chica_aplicacion->fecha->EditAttrs["readonly"]) && !isset($caja_chica_aplicacion->fecha->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fcaja_chica_aplicacionadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $caja_chica_aplicacion->fecha->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("documento_caja_chica", explode(",", $caja_chica_aplicacion->getCurrentDetailTable())) && $documento_caja_chica->DetailAdd) {
?>
<?php if ($caja_chica_aplicacion->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("documento_caja_chica", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "documento_caja_chicagrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $caja_chica_aplicacion_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcaja_chica_aplicacionadd.Init();
</script>
<?php
$caja_chica_aplicacion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$caja_chica_aplicacion_add->Page_Terminate();
?>
