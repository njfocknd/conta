<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "caja_chicainfo.php" ?>
<?php include_once "encargadogridcls.php" ?>
<?php include_once "documento_caja_chicagridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$caja_chica_add = NULL; // Initialize page object first

class ccaja_chica_add extends ccaja_chica {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'caja_chica';

	// Page object name
	var $PageObjName = 'caja_chica_add';

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

		// Table object (caja_chica)
		if (!isset($GLOBALS["caja_chica"]) || get_class($GLOBALS["caja_chica"]) == "ccaja_chica") {
			$GLOBALS["caja_chica"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["caja_chica"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caja_chica', TRUE);

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

			// Process auto fill for detail table 'encargado'
			if (@$_POST["grid"] == "fencargadogrid") {
				if (!isset($GLOBALS["encargado_grid"])) $GLOBALS["encargado_grid"] = new cencargado_grid;
				$GLOBALS["encargado_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

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
			if (@$_GET["idcaja_chica"] != "") {
				$this->idcaja_chica->setQueryStringValue($_GET["idcaja_chica"]);
				$this->setKey("idcaja_chica", $this->idcaja_chica->CurrentValue); // Set up key
			} else {
				$this->setKey("idcaja_chica", ""); // Clear key
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
					$this->Page_Terminate("caja_chicalist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "caja_chicalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "caja_chicaview.php")
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
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idempresa->CurrentValue = 1;
		$this->idempleado->CurrentValue = 1;
		$this->idcuenta->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->idempresa->FldIsDetailKey) {
			$this->idempresa->setFormValue($objForm->GetValue("x_idempresa"));
		}
		if (!$this->idempleado->FldIsDetailKey) {
			$this->idempleado->setFormValue($objForm->GetValue("x_idempleado"));
		}
		if (!$this->idcuenta->FldIsDetailKey) {
			$this->idcuenta->setFormValue($objForm->GetValue("x_idcuenta"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
		$this->idempleado->CurrentValue = $this->idempleado->FormValue;
		$this->idcuenta->CurrentValue = $this->idcuenta->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcaja_chica")) <> "")
			$this->idcaja_chica->CurrentValue = $this->getKey("idcaja_chica"); // idcaja_chica
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
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
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

		// idempleado
		if (strval($this->idempleado->CurrentValue) <> "") {
			$sFilterWrk = "`idempleado`" . ew_SearchString("=", $this->idempleado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idempleado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idempleado->ViewValue = $this->idempleado->DisplayValue($arwrk);
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
			$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo' ";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idcuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idcuenta->ViewValue = $this->idcuenta->DisplayValue($arwrk);
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
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;

			// idempleado
			$this->idempleado->EditAttrs["class"] = "form-control";
			$this->idempleado->EditCustomAttributes = "";
			if (trim(strval($this->idempleado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempleado`" . ew_SearchString("=", $this->idempleado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idempresa` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empleado`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idempleado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempleado->EditValue = $arwrk;

			// idcuenta
			$this->idcuenta->EditAttrs["class"] = "form-control";
			$this->idcuenta->EditCustomAttributes = "";
			if (trim(strval($this->idcuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idcuenta`" . ew_SearchString("=", $this->idcuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo' ";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idcuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idcuenta->EditValue = $arwrk;

			// Add refer script
			// nombre

			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";

			// idempleado
			$this->idempleado->LinkCustomAttributes = "";
			$this->idempleado->HrefValue = "";

			// idcuenta
			$this->idcuenta->LinkCustomAttributes = "";
			$this->idcuenta->HrefValue = "";
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
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idempresa->FldIsDetailKey && !is_null($this->idempresa->FormValue) && $this->idempresa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempresa->FldCaption(), $this->idempresa->ReqErrMsg));
		}
		if (!$this->idempleado->FldIsDetailKey && !is_null($this->idempleado->FormValue) && $this->idempleado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempleado->FldCaption(), $this->idempleado->ReqErrMsg));
		}
		if (!$this->idcuenta->FldIsDetailKey && !is_null($this->idcuenta->FormValue) && $this->idcuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta->FldCaption(), $this->idcuenta->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("encargado", $DetailTblVar) && $GLOBALS["encargado"]->DetailAdd) {
			if (!isset($GLOBALS["encargado_grid"])) $GLOBALS["encargado_grid"] = new cencargado_grid(); // get detail page object
			$GLOBALS["encargado_grid"]->ValidateGridForm();
		}
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
		$conn = &$this->Connection();

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idempresa
		$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, strval($this->idempresa->CurrentValue) == "");

		// idempleado
		$this->idempleado->SetDbValueDef($rsnew, $this->idempleado->CurrentValue, 0, strval($this->idempleado->CurrentValue) == "");

		// idcuenta
		$this->idcuenta->SetDbValueDef($rsnew, $this->idcuenta->CurrentValue, 0, strval($this->idcuenta->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idcaja_chica->setDbValue($conn->Insert_ID());
				$rsnew['idcaja_chica'] = $this->idcaja_chica->DbValue;
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
			if (in_array("encargado", $DetailTblVar) && $GLOBALS["encargado"]->DetailAdd) {
				$GLOBALS["encargado"]->idreferencia->setSessionValue($this->idcaja_chica->CurrentValue); // Set master key
				if (!isset($GLOBALS["encargado_grid"])) $GLOBALS["encargado_grid"] = new cencargado_grid(); // Get detail page object
				$AddRow = $GLOBALS["encargado_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["encargado"]->idreferencia->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("documento_caja_chica", $DetailTblVar) && $GLOBALS["documento_caja_chica"]->DetailAdd) {
				$GLOBALS["documento_caja_chica"]->idcaja_chica->setSessionValue($this->idcaja_chica->CurrentValue); // Set master key
				if (!isset($GLOBALS["documento_caja_chica_grid"])) $GLOBALS["documento_caja_chica_grid"] = new cdocumento_caja_chica_grid(); // Get detail page object
				$AddRow = $GLOBALS["documento_caja_chica_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["documento_caja_chica"]->idcaja_chica->setSessionValue(""); // Clear master key if insert failed
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
				if ($GLOBALS["encargado_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["encargado_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["encargado_grid"]->CurrentMode = "add";
					$GLOBALS["encargado_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["encargado_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["encargado_grid"]->setStartRecordNumber(1);
					$GLOBALS["encargado_grid"]->idreferencia->FldIsDetailKey = TRUE;
					$GLOBALS["encargado_grid"]->idreferencia->CurrentValue = $this->idcaja_chica->CurrentValue;
					$GLOBALS["encargado_grid"]->idreferencia->setSessionValue($GLOBALS["encargado_grid"]->idreferencia->CurrentValue);
				}
			}
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
					$GLOBALS["documento_caja_chica_grid"]->idcaja_chica->FldIsDetailKey = TRUE;
					$GLOBALS["documento_caja_chica_grid"]->idcaja_chica->CurrentValue = $this->idcaja_chica->CurrentValue;
					$GLOBALS["documento_caja_chica_grid"]->idcaja_chica->setSessionValue($GLOBALS["documento_caja_chica_grid"]->idcaja_chica->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("caja_chicalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($caja_chica_add)) $caja_chica_add = new ccaja_chica_add();

// Page init
$caja_chica_add->Page_Init();

// Page main
$caja_chica_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcaja_chicaadd = new ew_Form("fcaja_chicaadd", "add");

// Validate form
fcaja_chicaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica->nombre->FldCaption(), $caja_chica->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica->idempresa->FldCaption(), $caja_chica->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempleado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica->idempleado->FldCaption(), $caja_chica->idempleado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $caja_chica->idcuenta->FldCaption(), $caja_chica->idcuenta->ReqErrMsg)) ?>");

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
fcaja_chicaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chicaadd.ValidateRequired = true;
<?php } else { ?>
fcaja_chicaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcaja_chicaadd.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idempleado"],"FilterFields":[],"Options":[],"Template":""};
fcaja_chicaadd.Lists["x_idempleado"] = {"LinkField":"x_idempleado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idempresa"],"ChildFields":[],"FilterFields":["x_idempresa"],"Options":[],"Template":""};
fcaja_chicaadd.Lists["x_idcuenta"] = {"LinkField":"x_idcuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $caja_chica_add->ShowPageHeader(); ?>
<?php
$caja_chica_add->ShowMessage();
?>
<form name="fcaja_chicaadd" id="fcaja_chicaadd" class="<?php echo $caja_chica_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($caja_chica_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $caja_chica_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="caja_chica">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($caja_chica->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_caja_chica_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica->nombre->CellAttributes() ?>>
<span id="el_caja_chica_nombre">
<input type="text" data-table="caja_chica" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($caja_chica->nombre->getPlaceHolder()) ?>" value="<?php echo $caja_chica->nombre->EditValue ?>"<?php echo $caja_chica->nombre->EditAttributes() ?>>
</span>
<?php echo $caja_chica->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label id="elh_caja_chica_idempresa" for="x_idempresa" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica->idempresa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica->idempresa->CellAttributes() ?>>
<span id="el_caja_chica_idempresa">
<?php $caja_chica->idempresa->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$caja_chica->idempresa->EditAttrs["onchange"]; ?>
<select data-table="caja_chica" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica->idempresa->DisplayValueSeparator) ? json_encode($caja_chica->idempresa->DisplayValueSeparator) : $caja_chica->idempresa->DisplayValueSeparator) ?>" id="x_idempresa" name="x_idempresa"<?php echo $caja_chica->idempresa->EditAttributes() ?>>
<?php
if (is_array($caja_chica->idempresa->EditValue)) {
	$arwrk = $caja_chica->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica->idempresa->CurrentValue) ?>" selected><?php echo $caja_chica->idempresa->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica->Lookup_Selecting($caja_chica->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="<?php echo $caja_chica->idempresa->LookupFilterQuery() ?>">
</span>
<?php echo $caja_chica->idempresa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica->idempleado->Visible) { // idempleado ?>
	<div id="r_idempleado" class="form-group">
		<label id="elh_caja_chica_idempleado" for="x_idempleado" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica->idempleado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica->idempleado->CellAttributes() ?>>
<span id="el_caja_chica_idempleado">
<select data-table="caja_chica" data-field="x_idempleado" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica->idempleado->DisplayValueSeparator) ? json_encode($caja_chica->idempleado->DisplayValueSeparator) : $caja_chica->idempleado->DisplayValueSeparator) ?>" id="x_idempleado" name="x_idempleado"<?php echo $caja_chica->idempleado->EditAttributes() ?>>
<?php
if (is_array($caja_chica->idempleado->EditValue)) {
	$arwrk = $caja_chica->idempleado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica->idempleado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica->idempleado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica->idempleado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica->idempleado->CurrentValue) ?>" selected><?php echo $caja_chica->idempleado->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idempleado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empleado`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica->idempleado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica->idempleado->LookupFilters += array("f0" => "`idempleado` = {filter_value}", "t0" => "3", "fn0" => "");
$caja_chica->idempleado->LookupFilters += array("f1" => "`idempresa` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$caja_chica->Lookup_Selecting($caja_chica->idempleado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica->idempleado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idempleado" id="s_x_idempleado" value="<?php echo $caja_chica->idempleado->LookupFilterQuery() ?>">
</span>
<?php echo $caja_chica->idempleado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($caja_chica->idcuenta->Visible) { // idcuenta ?>
	<div id="r_idcuenta" class="form-group">
		<label id="elh_caja_chica_idcuenta" for="x_idcuenta" class="col-sm-2 control-label ewLabel"><?php echo $caja_chica->idcuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $caja_chica->idcuenta->CellAttributes() ?>>
<span id="el_caja_chica_idcuenta">
<select data-table="caja_chica" data-field="x_idcuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($caja_chica->idcuenta->DisplayValueSeparator) ? json_encode($caja_chica->idcuenta->DisplayValueSeparator) : $caja_chica->idcuenta->DisplayValueSeparator) ?>" id="x_idcuenta" name="x_idcuenta"<?php echo $caja_chica->idcuenta->EditAttributes() ?>>
<?php
if (is_array($caja_chica->idcuenta->EditValue)) {
	$arwrk = $caja_chica->idcuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($caja_chica->idcuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $caja_chica->idcuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($caja_chica->idcuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($caja_chica->idcuenta->CurrentValue) ?>" selected><?php echo $caja_chica->idcuenta->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo' ";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$caja_chica->idcuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$caja_chica->idcuenta->LookupFilters += array("f0" => "`idcuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$caja_chica->Lookup_Selecting($caja_chica->idcuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $caja_chica->idcuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idcuenta" id="s_x_idcuenta" value="<?php echo $caja_chica->idcuenta->LookupFilterQuery() ?>">
</span>
<?php echo $caja_chica->idcuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("encargado", explode(",", $caja_chica->getCurrentDetailTable())) && $encargado->DetailAdd) {
?>
<?php if ($caja_chica->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("encargado", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "encargadogrid.php" ?>
<?php } ?>
<?php
	if (in_array("documento_caja_chica", explode(",", $caja_chica->getCurrentDetailTable())) && $documento_caja_chica->DetailAdd) {
?>
<?php if ($caja_chica->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("documento_caja_chica", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "documento_caja_chicagrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $caja_chica_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcaja_chicaadd.Init();
</script>
<?php
$caja_chica_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$caja_chica_add->Page_Terminate();
?>
