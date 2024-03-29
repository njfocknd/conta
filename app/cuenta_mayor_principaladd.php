<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "cuenta_mayor_principalinfo.php" ?>
<?php include_once "subgrupo_cuentainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$cuenta_mayor_principal_add = NULL; // Initialize page object first

class ccuenta_mayor_principal_add extends ccuenta_mayor_principal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'cuenta_mayor_principal';

	// Page object name
	var $PageObjName = 'cuenta_mayor_principal_add';

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

		// Table object (cuenta_mayor_principal)
		if (!isset($GLOBALS["cuenta_mayor_principal"]) || get_class($GLOBALS["cuenta_mayor_principal"]) == "ccuenta_mayor_principal") {
			$GLOBALS["cuenta_mayor_principal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta_mayor_principal"];
		}

		// Table object (subgrupo_cuenta)
		if (!isset($GLOBALS['subgrupo_cuenta'])) $GLOBALS['subgrupo_cuenta'] = new csubgrupo_cuenta();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta_mayor_principal', TRUE);

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
		global $EW_EXPORT, $cuenta_mayor_principal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta_mayor_principal);
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
			if (@$_GET["idcuenta_mayor_principal"] != "") {
				$this->idcuenta_mayor_principal->setQueryStringValue($_GET["idcuenta_mayor_principal"]);
				$this->setKey("idcuenta_mayor_principal", $this->idcuenta_mayor_principal->CurrentValue); // Set up key
			} else {
				$this->setKey("idcuenta_mayor_principal", ""); // Clear key
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
					$this->Page_Terminate("cuenta_mayor_principallist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "cuenta_mayor_principallist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "cuenta_mayor_principalview.php")
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
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idsubgrupo_cuenta->CurrentValue = NULL;
		$this->idsubgrupo_cuenta->OldValue = $this->idsubgrupo_cuenta->CurrentValue;
		$this->definicion->CurrentValue = NULL;
		$this->definicion->OldValue = $this->definicion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomenclatura->FldIsDetailKey) {
			$this->nomenclatura->setFormValue($objForm->GetValue("x_nomenclatura"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey) {
			$this->idsubgrupo_cuenta->setFormValue($objForm->GetValue("x_idsubgrupo_cuenta"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->FormValue;
		$this->definicion->CurrentValue = $this->definicion->FormValue;
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
		$this->idcuenta_mayor_principal->setDbValue($rs->fields('idcuenta_mayor_principal'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta_mayor_principal->DbValue = $row['idcuenta_mayor_principal'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idsubgrupo_cuenta->DbValue = $row['idsubgrupo_cuenta'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idcuenta_mayor_principal")) <> "")
			$this->idcuenta_mayor_principal->CurrentValue = $this->getKey("idcuenta_mayor_principal"); // idcuenta_mayor_principal
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
		// idcuenta_mayor_principal
		// nomenclatura
		// nombre
		// idsubgrupo_cuenta
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idcuenta_mayor_principal
		$this->idcuenta_mayor_principal->ViewValue = $this->idcuenta_mayor_principal->CurrentValue;
		$this->idcuenta_mayor_principal->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// idsubgrupo_cuenta
		if (strval($this->idsubgrupo_cuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
			}
		} else {
			$this->idsubgrupo_cuenta->ViewValue = NULL;
		}
		$this->idsubgrupo_cuenta->ViewCustomAttributes = "";

		// definicion
		$this->definicion->ViewValue = $this->definicion->CurrentValue;
		$this->definicion->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";
			$this->idsubgrupo_cuenta->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomenclatura
			$this->nomenclatura->EditAttrs["class"] = "form-control";
			$this->nomenclatura->EditCustomAttributes = "";
			$this->nomenclatura->EditValue = ew_HtmlEncode($this->nomenclatura->CurrentValue);
			$this->nomenclatura->PlaceHolder = ew_RemoveHtml($this->nomenclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idsubgrupo_cuenta->EditCustomAttributes = "";
			if ($this->idsubgrupo_cuenta->getSessionValue() <> "") {
				$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->getSessionValue();
			if (strval($this->idsubgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
				}
			} else {
				$this->idsubgrupo_cuenta->ViewValue = NULL;
			}
			$this->idsubgrupo_cuenta->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idsubgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsubgrupo_cuenta->EditValue = $arwrk;
			}

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// Add refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
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
		if (!$this->nomenclatura->FldIsDetailKey && !is_null($this->nomenclatura->FormValue) && $this->nomenclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomenclatura->FldCaption(), $this->nomenclatura->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey && !is_null($this->idsubgrupo_cuenta->FormValue) && $this->idsubgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsubgrupo_cuenta->FldCaption(), $this->idsubgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->definicion->FldIsDetailKey && !is_null($this->definicion->FormValue) && $this->definicion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->definicion->FldCaption(), $this->definicion->ReqErrMsg));
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

		// nomenclatura
		$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idsubgrupo_cuenta
		$this->idsubgrupo_cuenta->SetDbValueDef($rsnew, $this->idsubgrupo_cuenta->CurrentValue, 0, FALSE);

		// definicion
		$this->definicion->SetDbValueDef($rsnew, $this->definicion->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idcuenta_mayor_principal->setDbValue($conn->Insert_ID());
				$rsnew['idcuenta_mayor_principal'] = $this->idcuenta_mayor_principal->DbValue;
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
			if ($sMasterTblVar == "subgrupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idsubgrupo_cuenta"] <> "") {
					$GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->setQueryStringValue($_GET["fk_idsubgrupo_cuenta"]);
					$this->idsubgrupo_cuenta->setQueryStringValue($GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->QueryStringValue);
					$this->idsubgrupo_cuenta->setSessionValue($this->idsubgrupo_cuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "subgrupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idsubgrupo_cuenta"] <> "") {
					$GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->setFormValue($_POST["fk_idsubgrupo_cuenta"]);
					$this->idsubgrupo_cuenta->setFormValue($GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->FormValue);
					$this->idsubgrupo_cuenta->setSessionValue($this->idsubgrupo_cuenta->FormValue);
					if (!is_numeric($GLOBALS["subgrupo_cuenta"]->idsubgrupo_cuenta->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "subgrupo_cuenta") {
				if ($this->idsubgrupo_cuenta->CurrentValue == "") $this->idsubgrupo_cuenta->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cuenta_mayor_principallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cuenta_mayor_principal_add)) $cuenta_mayor_principal_add = new ccuenta_mayor_principal_add();

// Page init
$cuenta_mayor_principal_add->Page_Init();

// Page main
$cuenta_mayor_principal_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_mayor_principal_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fcuenta_mayor_principaladd = new ew_Form("fcuenta_mayor_principaladd", "add");

// Validate form
fcuenta_mayor_principaladd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomenclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->nomenclatura->FldCaption(), $cuenta_mayor_principal->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->nombre->FldCaption(), $cuenta_mayor_principal->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idsubgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->idsubgrupo_cuenta->FldCaption(), $cuenta_mayor_principal->idsubgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_definicion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->definicion->FldCaption(), $cuenta_mayor_principal->definicion->ReqErrMsg)) ?>");

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
fcuenta_mayor_principaladd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuenta_mayor_principaladd.ValidateRequired = true;
<?php } else { ?>
fcuenta_mayor_principaladd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuenta_mayor_principaladd.Lists["x_idsubgrupo_cuenta"] = {"LinkField":"x_idsubgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $cuenta_mayor_principal_add->ShowPageHeader(); ?>
<?php
$cuenta_mayor_principal_add->ShowMessage();
?>
<form name="fcuenta_mayor_principaladd" id="fcuenta_mayor_principaladd" class="<?php echo $cuenta_mayor_principal_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_mayor_principal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_mayor_principal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_mayor_principal">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($cuenta_mayor_principal->getCurrentMasterTable() == "subgrupo_cuenta") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="subgrupo_cuenta">
<input type="hidden" name="fk_idsubgrupo_cuenta" value="<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($cuenta_mayor_principal->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_cuenta_mayor_principal_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->nomenclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->nomenclatura->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nomenclatura">
<input type="text" data-table="cuenta_mayor_principal" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_principal->nomenclatura->EditValue ?>"<?php echo $cuenta_mayor_principal->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_cuenta_mayor_principal_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->nombre->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nombre">
<input type="text" data-table="cuenta_mayor_principal" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="64" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_principal->nombre->EditValue ?>"<?php echo $cuenta_mayor_principal->nombre->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->idsubgrupo_cuenta->Visible) { // idsubgrupo_cuenta ?>
	<div id="r_idsubgrupo_cuenta" class="form-group">
		<label id="elh_cuenta_mayor_principal_idsubgrupo_cuenta" for="x_idsubgrupo_cuenta" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->CellAttributes() ?>>
<?php if ($cuenta_mayor_principal->idsubgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el_cuenta_mayor_principal_idsubgrupo_cuenta">
<span<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idsubgrupo_cuenta" name="x_idsubgrupo_cuenta" value="<?php echo ew_HtmlEncode($cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el_cuenta_mayor_principal_idsubgrupo_cuenta">
<select data-table="cuenta_mayor_principal" data-field="x_idsubgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta_mayor_principal->idsubgrupo_cuenta->DisplayValueSeparator) ? json_encode($cuenta_mayor_principal->idsubgrupo_cuenta->DisplayValueSeparator) : $cuenta_mayor_principal->idsubgrupo_cuenta->DisplayValueSeparator) ?>" id="x_idsubgrupo_cuenta" name="x_idsubgrupo_cuenta"<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_principal->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $cuenta_mayor_principal->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue) ?>" selected><?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$cuenta_mayor_principal->idsubgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$cuenta_mayor_principal->idsubgrupo_cuenta->LookupFilters += array("f0" => "`idsubgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$cuenta_mayor_principal->Lookup_Selecting($cuenta_mayor_principal->idsubgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $cuenta_mayor_principal->idsubgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idsubgrupo_cuenta" id="s_x_idsubgrupo_cuenta" value="<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_cuenta_mayor_principal_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->definicion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->definicion->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_definicion">
<input type="text" data-table="cuenta_mayor_principal" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->definicion->getPlaceHolder()) ?>" value="<?php echo $cuenta_mayor_principal->definicion->EditValue ?>"<?php echo $cuenta_mayor_principal->definicion->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cuenta_mayor_principal_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcuenta_mayor_principaladd.Init();
</script>
<?php
$cuenta_mayor_principal_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cuenta_mayor_principal_add->Page_Terminate();
?>
