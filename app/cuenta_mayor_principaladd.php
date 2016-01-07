<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_mayor_principalinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "subgrupo_cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_mayor_auxiliargridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$cuenta_mayor_principal_add = NULL; // Initialize page object first

class ccuenta_mayor_principal_add extends ccuenta_mayor_principal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5B8C292A-87A7-44A6-9434-2D0CECD099FC}";

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
		if (!isset($conn)) $conn = ew_Connect();
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

			// Process auto fill for detail table 'cuenta_mayor_auxiliar'
			if (@$_POST["grid"] == "fcuenta_mayor_auxiliargrid") {
				if (!isset($GLOBALS["cuenta_mayor_auxiliar_grid"])) $GLOBALS["cuenta_mayor_auxiliar_grid"] = new ccuenta_mayor_auxiliar_grid;
				$GLOBALS["cuenta_mayor_auxiliar_grid"]->Page_Init();
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
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
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
				$this->LoadDefaultValues(); // Load default values
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
					if (ew_GetPageName($sReturnUrl) == "cuenta_mayor_principalview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values

					// Set up detail parameters
					$this->SetUpDetailParms();
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

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
		$this->idsubgrupo_cuenta->CurrentValue = NULL;
		$this->idsubgrupo_cuenta->OldValue = $this->idsubgrupo_cuenta->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->nomeclatura->CurrentValue = NULL;
		$this->nomeclatura->OldValue = $this->nomeclatura->CurrentValue;
		$this->definicion->CurrentValue = NULL;
		$this->definicion->OldValue = $this->definicion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey) {
			$this->idsubgrupo_cuenta->setFormValue($objForm->GetValue("x_idsubgrupo_cuenta"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->nomeclatura->FldIsDetailKey) {
			$this->nomeclatura->setFormValue($objForm->GetValue("x_nomeclatura"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->nomeclatura->CurrentValue = $this->nomeclatura->FormValue;
		$this->definicion->CurrentValue = $this->definicion->FormValue;
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
		$this->idcuenta_mayor_principal->setDbValue($rs->fields('idcuenta_mayor_principal'));
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->nomeclatura->setDbValue($rs->fields('nomeclatura'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta_mayor_principal->DbValue = $row['idcuenta_mayor_principal'];
		$this->idsubgrupo_cuenta->DbValue = $row['idsubgrupo_cuenta'];
		$this->nombre->DbValue = $row['nombre'];
		$this->nomeclatura->DbValue = $row['nomeclatura'];
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
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta_mayor_principal
		// idsubgrupo_cuenta
		// nombre
		// nomeclatura
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idcuenta_mayor_principal
			$this->idcuenta_mayor_principal->ViewValue = $this->idcuenta_mayor_principal->CurrentValue;
			$this->idcuenta_mayor_principal->ViewCustomAttributes = "";

			// idsubgrupo_cuenta
			if (strval($this->idsubgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idsubgrupo_cuenta->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
				}
			} else {
				$this->idsubgrupo_cuenta->ViewValue = NULL;
			}
			$this->idsubgrupo_cuenta->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// nomeclatura
			$this->nomeclatura->ViewValue = $this->nomeclatura->CurrentValue;
			$this->nomeclatura->ViewCustomAttributes = "";

			// definicion
			$this->definicion->ViewValue = $this->definicion->CurrentValue;
			$this->definicion->ViewCustomAttributes = "";

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

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->LinkCustomAttributes = "";
			$this->idsubgrupo_cuenta->HrefValue = "";
			$this->idsubgrupo_cuenta->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// nomeclatura
			$this->nomeclatura->LinkCustomAttributes = "";
			$this->nomeclatura->HrefValue = "";
			$this->nomeclatura->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idsubgrupo_cuenta
			$this->idsubgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idsubgrupo_cuenta->EditCustomAttributes = "";
			if ($this->idsubgrupo_cuenta->getSessionValue() <> "") {
				$this->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->getSessionValue();
			if (strval($this->idsubgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idsubgrupo_cuenta->ViewValue = $rswrk->fields('DispFld');
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
				$sFilterWrk = "`idsubgrupo_cuenta`" . ew_SearchString("=", $this->idsubgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `subgrupo_cuenta`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idsubgrupo_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idsubgrupo_cuenta->EditValue = $arwrk;
			}

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// nomeclatura
			$this->nomeclatura->EditAttrs["class"] = "form-control";
			$this->nomeclatura->EditCustomAttributes = "";
			$this->nomeclatura->EditValue = ew_HtmlEncode($this->nomeclatura->CurrentValue);
			$this->nomeclatura->PlaceHolder = ew_RemoveHtml($this->nomeclatura->FldCaption());

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// Edit refer script
			// idsubgrupo_cuenta

			$this->idsubgrupo_cuenta->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// nomeclatura
			$this->nomeclatura->HrefValue = "";

			// definicion
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
		if (!$this->idsubgrupo_cuenta->FldIsDetailKey && !is_null($this->idsubgrupo_cuenta->FormValue) && $this->idsubgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idsubgrupo_cuenta->FldCaption(), $this->idsubgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->nomeclatura->FldIsDetailKey && !is_null($this->nomeclatura->FormValue) && $this->nomeclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomeclatura->FldCaption(), $this->nomeclatura->ReqErrMsg));
		}
		if (!$this->definicion->FldIsDetailKey && !is_null($this->definicion->FormValue) && $this->definicion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->definicion->FldCaption(), $this->definicion->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cuenta_mayor_auxiliar", $DetailTblVar) && $GLOBALS["cuenta_mayor_auxiliar"]->DetailAdd) {
			if (!isset($GLOBALS["cuenta_mayor_auxiliar_grid"])) $GLOBALS["cuenta_mayor_auxiliar_grid"] = new ccuenta_mayor_auxiliar_grid(); // get detail page object
			$GLOBALS["cuenta_mayor_auxiliar_grid"]->ValidateGridForm();
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
		global $conn, $Language, $Security;

		// Begin transaction
		if ($this->getCurrentDetailTable() <> "")
			$conn->BeginTrans();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// idsubgrupo_cuenta
		$this->idsubgrupo_cuenta->SetDbValueDef($rsnew, $this->idsubgrupo_cuenta->CurrentValue, 0, FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// nomeclatura
		$this->nomeclatura->SetDbValueDef($rsnew, $this->nomeclatura->CurrentValue, "", FALSE);

		// definicion
		$this->definicion->SetDbValueDef($rsnew, $this->definicion->CurrentValue, "", FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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

		// Get insert id if necessary
		if ($AddRow) {
			$this->idcuenta_mayor_principal->setDbValue($conn->Insert_ID());
			$rsnew['idcuenta_mayor_principal'] = $this->idcuenta_mayor_principal->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("cuenta_mayor_auxiliar", $DetailTblVar) && $GLOBALS["cuenta_mayor_auxiliar"]->DetailAdd) {
				$GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_principal->setSessionValue($this->idcuenta_mayor_principal->CurrentValue); // Set master key
				if (!isset($GLOBALS["cuenta_mayor_auxiliar_grid"])) $GLOBALS["cuenta_mayor_auxiliar_grid"] = new ccuenta_mayor_auxiliar_grid(); // Get detail page object
				$AddRow = $GLOBALS["cuenta_mayor_auxiliar_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_principal->setSessionValue(""); // Clear master key if insert failed
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
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "subgrupo_cuenta") {
				if ($this->idsubgrupo_cuenta->QueryStringValue == "") $this->idsubgrupo_cuenta->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
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
			if (in_array("cuenta_mayor_auxiliar", $DetailTblVar)) {
				if (!isset($GLOBALS["cuenta_mayor_auxiliar_grid"]))
					$GLOBALS["cuenta_mayor_auxiliar_grid"] = new ccuenta_mayor_auxiliar_grid;
				if ($GLOBALS["cuenta_mayor_auxiliar_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cuenta_mayor_auxiliar_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cuenta_mayor_auxiliar_grid"]->CurrentMode = "add";
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->setStartRecordNumber(1);
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->idcuenta_mayor_principal->FldIsDetailKey = TRUE;
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->idcuenta_mayor_principal->CurrentValue = $this->idcuenta_mayor_principal->CurrentValue;
					$GLOBALS["cuenta_mayor_auxiliar_grid"]->idcuenta_mayor_principal->setSessionValue($GLOBALS["cuenta_mayor_auxiliar_grid"]->idcuenta_mayor_principal->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "cuenta_mayor_principallist.php", "", $this->TableVar, TRUE);
		$PageId = ($this->CurrentAction == "C") ? "Copy" : "Add";
		$Breadcrumb->Add("add", $PageId, ew_CurrentUrl());
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
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var cuenta_mayor_principal_add = new ew_Page("cuenta_mayor_principal_add");
cuenta_mayor_principal_add.PageID = "add"; // Page ID
var EW_PAGE_ID = cuenta_mayor_principal_add.PageID; // For backward compatibility

// Form object
var fcuenta_mayor_principaladd = new ew_Form("fcuenta_mayor_principaladd");

// Validate form
fcuenta_mayor_principaladd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
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
			elm = this.GetElements("x" + infix + "_idsubgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->idsubgrupo_cuenta->FldCaption(), $cuenta_mayor_principal->idsubgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->nombre->FldCaption(), $cuenta_mayor_principal->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->nomeclatura->FldCaption(), $cuenta_mayor_principal->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_definicion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta_mayor_principal->definicion->FldCaption(), $cuenta_mayor_principal->definicion->ReqErrMsg)) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

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
fcuenta_mayor_principaladd.Lists["x_idsubgrupo_cuenta"] = {"LinkField":"x_idsubgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<form name="fcuenta_mayor_principaladd" id="fcuenta_mayor_principaladd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_mayor_principal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_mayor_principal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta_mayor_principal">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
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
<select data-field="x_idsubgrupo_cuenta" id="x_idsubgrupo_cuenta" name="x_idsubgrupo_cuenta"<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($cuenta_mayor_principal->idsubgrupo_cuenta->EditValue)) {
	$arwrk = $cuenta_mayor_principal->idsubgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta_mayor_principal->idsubgrupo_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idsubgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subgrupo_cuenta`";
$sWhereWrk = "";

// Call Lookup selecting
$cuenta_mayor_principal->Lookup_Selecting($cuenta_mayor_principal->idsubgrupo_cuenta, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idsubgrupo_cuenta" id="s_x_idsubgrupo_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idsubgrupo_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $cuenta_mayor_principal->idsubgrupo_cuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_cuenta_mayor_principal_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->nombre->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->nombre->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_principal->nombre->EditValue ?>"<?php echo $cuenta_mayor_principal->nombre->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->nomeclatura->Visible) { // nomeclatura ?>
	<div id="r_nomeclatura" class="form-group">
		<label id="elh_cuenta_mayor_principal_nomeclatura" for="x_nomeclatura" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->nomeclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->nomeclatura->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x_nomeclatura" id="x_nomeclatura" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->nomeclatura->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_principal->nomeclatura->EditValue ?>"<?php echo $cuenta_mayor_principal->nomeclatura->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->nomeclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta_mayor_principal->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_cuenta_mayor_principal_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $cuenta_mayor_principal->definicion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta_mayor_principal->definicion->CellAttributes() ?>>
<span id="el_cuenta_mayor_principal_definicion">
<input type="text" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta_mayor_principal->definicion->PlaceHolder) ?>" value="<?php echo $cuenta_mayor_principal->definicion->EditValue ?>"<?php echo $cuenta_mayor_principal->definicion->EditAttributes() ?>>
</span>
<?php echo $cuenta_mayor_principal->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("cuenta_mayor_auxiliar", explode(",", $cuenta_mayor_principal->getCurrentDetailTable())) && $cuenta_mayor_auxiliar->DetailAdd) {
?>
<?php if ($cuenta_mayor_principal->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cuenta_mayor_auxiliar", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cuenta_mayor_auxiliargrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
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
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$cuenta_mayor_principal_add->Page_Terminate();
?>
