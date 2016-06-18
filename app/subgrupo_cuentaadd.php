<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "subgrupo_cuentainfo.php" ?>
<?php include_once "grupo_cuentainfo.php" ?>
<?php include_once "cuenta_mayor_principalgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$subgrupo_cuenta_add = NULL; // Initialize page object first

class csubgrupo_cuenta_add extends csubgrupo_cuenta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'subgrupo_cuenta';

	// Page object name
	var $PageObjName = 'subgrupo_cuenta_add';

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

		// Table object (subgrupo_cuenta)
		if (!isset($GLOBALS["subgrupo_cuenta"]) || get_class($GLOBALS["subgrupo_cuenta"]) == "csubgrupo_cuenta") {
			$GLOBALS["subgrupo_cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["subgrupo_cuenta"];
		}

		// Table object (grupo_cuenta)
		if (!isset($GLOBALS['grupo_cuenta'])) $GLOBALS['grupo_cuenta'] = new cgrupo_cuenta();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subgrupo_cuenta', TRUE);

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

			// Process auto fill for detail table 'cuenta_mayor_principal'
			if (@$_POST["grid"] == "fcuenta_mayor_principalgrid") {
				if (!isset($GLOBALS["cuenta_mayor_principal_grid"])) $GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid;
				$GLOBALS["cuenta_mayor_principal_grid"]->Page_Init();
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
		global $EW_EXPORT, $subgrupo_cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($subgrupo_cuenta);
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
			if (@$_GET["idsubgrupo_cuenta"] != "") {
				$this->idsubgrupo_cuenta->setQueryStringValue($_GET["idsubgrupo_cuenta"]);
				$this->setKey("idsubgrupo_cuenta", $this->idsubgrupo_cuenta->CurrentValue); // Set up key
			} else {
				$this->setKey("idsubgrupo_cuenta", ""); // Clear key
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
					$this->Page_Terminate("subgrupo_cuentalist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "subgrupo_cuentalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "subgrupo_cuentaview.php")
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
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idgrupo_cuenta->CurrentValue = NULL;
		$this->idgrupo_cuenta->OldValue = $this->idgrupo_cuenta->CurrentValue;
		$this->definicion->CurrentValue = NULL;
		$this->definicion->OldValue = $this->definicion->CurrentValue;
		$this->idgrupo_flujo_efectivo->CurrentValue = NULL;
		$this->idgrupo_flujo_efectivo->OldValue = $this->idgrupo_flujo_efectivo->CurrentValue;
		$this->tendencia->CurrentValue = "Positiva";
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
		if (!$this->idgrupo_cuenta->FldIsDetailKey) {
			$this->idgrupo_cuenta->setFormValue($objForm->GetValue("x_idgrupo_cuenta"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
		if (!$this->idgrupo_flujo_efectivo->FldIsDetailKey) {
			$this->idgrupo_flujo_efectivo->setFormValue($objForm->GetValue("x_idgrupo_flujo_efectivo"));
		}
		if (!$this->tendencia->FldIsDetailKey) {
			$this->tendencia->setFormValue($objForm->GetValue("x_tendencia"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->FormValue;
		$this->definicion->CurrentValue = $this->definicion->FormValue;
		$this->idgrupo_flujo_efectivo->CurrentValue = $this->idgrupo_flujo_efectivo->FormValue;
		$this->tendencia->CurrentValue = $this->tendencia->FormValue;
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
		$this->idsubgrupo_cuenta->setDbValue($rs->fields('idsubgrupo_cuenta'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idgrupo_cuenta->setDbValue($rs->fields('idgrupo_cuenta'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->idgrupo_flujo_efectivo->setDbValue($rs->fields('idgrupo_flujo_efectivo'));
		$this->tendencia->setDbValue($rs->fields('tendencia'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idsubgrupo_cuenta->DbValue = $row['idsubgrupo_cuenta'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idgrupo_cuenta->DbValue = $row['idgrupo_cuenta'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
		$this->idgrupo_flujo_efectivo->DbValue = $row['idgrupo_flujo_efectivo'];
		$this->tendencia->DbValue = $row['tendencia'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idsubgrupo_cuenta")) <> "")
			$this->idsubgrupo_cuenta->CurrentValue = $this->getKey("idsubgrupo_cuenta"); // idsubgrupo_cuenta
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
		// idsubgrupo_cuenta
		// nomenclatura
		// nombre
		// idgrupo_cuenta
		// definicion
		// estado
		// idgrupo_flujo_efectivo
		// tendencia

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idsubgrupo_cuenta
		$this->idsubgrupo_cuenta->ViewValue = $this->idsubgrupo_cuenta->CurrentValue;
		$this->idsubgrupo_cuenta->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// idgrupo_cuenta
		if (strval($this->idgrupo_cuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->CurrentValue;
			}
		} else {
			$this->idgrupo_cuenta->ViewValue = NULL;
		}
		$this->idgrupo_cuenta->ViewCustomAttributes = "";

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

		// idgrupo_flujo_efectivo
		$this->idgrupo_flujo_efectivo->ViewValue = $this->idgrupo_flujo_efectivo->CurrentValue;
		$this->idgrupo_flujo_efectivo->ViewCustomAttributes = "";

		// tendencia
		if (strval($this->tendencia->CurrentValue) <> "") {
			$this->tendencia->ViewValue = $this->tendencia->OptionCaption($this->tendencia->CurrentValue);
		} else {
			$this->tendencia->ViewValue = NULL;
		}
		$this->tendencia->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";
			$this->idgrupo_cuenta->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";

			// idgrupo_flujo_efectivo
			$this->idgrupo_flujo_efectivo->LinkCustomAttributes = "";
			$this->idgrupo_flujo_efectivo->HrefValue = "";
			$this->idgrupo_flujo_efectivo->TooltipValue = "";

			// tendencia
			$this->tendencia->LinkCustomAttributes = "";
			$this->tendencia->HrefValue = "";
			$this->tendencia->TooltipValue = "";
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

			// idgrupo_cuenta
			$this->idgrupo_cuenta->EditAttrs["class"] = "form-control";
			$this->idgrupo_cuenta->EditCustomAttributes = "";
			if ($this->idgrupo_cuenta->getSessionValue() <> "") {
				$this->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->getSessionValue();
			if (strval($this->idgrupo_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->CurrentValue;
				}
			} else {
				$this->idgrupo_cuenta->ViewValue = NULL;
			}
			$this->idgrupo_cuenta->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idgrupo_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_cuenta`" . ew_SearchString("=", $this->idgrupo_cuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_cuenta->EditValue = $arwrk;
			}

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// idgrupo_flujo_efectivo
			$this->idgrupo_flujo_efectivo->EditAttrs["class"] = "form-control";
			$this->idgrupo_flujo_efectivo->EditCustomAttributes = "";
			$this->idgrupo_flujo_efectivo->EditValue = ew_HtmlEncode($this->idgrupo_flujo_efectivo->CurrentValue);
			$this->idgrupo_flujo_efectivo->PlaceHolder = ew_RemoveHtml($this->idgrupo_flujo_efectivo->FldCaption());

			// tendencia
			$this->tendencia->EditAttrs["class"] = "form-control";
			$this->tendencia->EditCustomAttributes = "";
			$this->tendencia->EditValue = $this->tendencia->Options(TRUE);

			// Add refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// idgrupo_cuenta
			$this->idgrupo_cuenta->LinkCustomAttributes = "";
			$this->idgrupo_cuenta->HrefValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";

			// idgrupo_flujo_efectivo
			$this->idgrupo_flujo_efectivo->LinkCustomAttributes = "";
			$this->idgrupo_flujo_efectivo->HrefValue = "";

			// tendencia
			$this->tendencia->LinkCustomAttributes = "";
			$this->tendencia->HrefValue = "";
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
		if (!$this->idgrupo_cuenta->FldIsDetailKey && !is_null($this->idgrupo_cuenta->FormValue) && $this->idgrupo_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idgrupo_cuenta->FldCaption(), $this->idgrupo_cuenta->ReqErrMsg));
		}
		if (!$this->definicion->FldIsDetailKey && !is_null($this->definicion->FormValue) && $this->definicion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->definicion->FldCaption(), $this->definicion->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idgrupo_flujo_efectivo->FormValue)) {
			ew_AddMessage($gsFormError, $this->idgrupo_flujo_efectivo->FldErrMsg());
		}
		if (!$this->tendencia->FldIsDetailKey && !is_null($this->tendencia->FormValue) && $this->tendencia->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tendencia->FldCaption(), $this->tendencia->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cuenta_mayor_principal", $DetailTblVar) && $GLOBALS["cuenta_mayor_principal"]->DetailAdd) {
			if (!isset($GLOBALS["cuenta_mayor_principal_grid"])) $GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid(); // get detail page object
			$GLOBALS["cuenta_mayor_principal_grid"]->ValidateGridForm();
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

		// nomenclatura
		$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idgrupo_cuenta
		$this->idgrupo_cuenta->SetDbValueDef($rsnew, $this->idgrupo_cuenta->CurrentValue, 0, FALSE);

		// definicion
		$this->definicion->SetDbValueDef($rsnew, $this->definicion->CurrentValue, "", FALSE);

		// idgrupo_flujo_efectivo
		$this->idgrupo_flujo_efectivo->SetDbValueDef($rsnew, $this->idgrupo_flujo_efectivo->CurrentValue, NULL, FALSE);

		// tendencia
		$this->tendencia->SetDbValueDef($rsnew, $this->tendencia->CurrentValue, "", strval($this->tendencia->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idsubgrupo_cuenta->setDbValue($conn->Insert_ID());
				$rsnew['idsubgrupo_cuenta'] = $this->idsubgrupo_cuenta->DbValue;
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
			if (in_array("cuenta_mayor_principal", $DetailTblVar) && $GLOBALS["cuenta_mayor_principal"]->DetailAdd) {
				$GLOBALS["cuenta_mayor_principal"]->idsubgrupo_cuenta->setSessionValue($this->idsubgrupo_cuenta->CurrentValue); // Set master key
				if (!isset($GLOBALS["cuenta_mayor_principal_grid"])) $GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid(); // Get detail page object
				$AddRow = $GLOBALS["cuenta_mayor_principal_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cuenta_mayor_principal"]->idsubgrupo_cuenta->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "grupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idgrupo_cuenta"] <> "") {
					$GLOBALS["grupo_cuenta"]->idgrupo_cuenta->setQueryStringValue($_GET["fk_idgrupo_cuenta"]);
					$this->idgrupo_cuenta->setQueryStringValue($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->QueryStringValue);
					$this->idgrupo_cuenta->setSessionValue($this->idgrupo_cuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "grupo_cuenta") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idgrupo_cuenta"] <> "") {
					$GLOBALS["grupo_cuenta"]->idgrupo_cuenta->setFormValue($_POST["fk_idgrupo_cuenta"]);
					$this->idgrupo_cuenta->setFormValue($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->FormValue);
					$this->idgrupo_cuenta->setSessionValue($this->idgrupo_cuenta->FormValue);
					if (!is_numeric($GLOBALS["grupo_cuenta"]->idgrupo_cuenta->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "grupo_cuenta") {
				if ($this->idgrupo_cuenta->CurrentValue == "") $this->idgrupo_cuenta->setSessionValue("");
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
			if (in_array("cuenta_mayor_principal", $DetailTblVar)) {
				if (!isset($GLOBALS["cuenta_mayor_principal_grid"]))
					$GLOBALS["cuenta_mayor_principal_grid"] = new ccuenta_mayor_principal_grid;
				if ($GLOBALS["cuenta_mayor_principal_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cuenta_mayor_principal_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cuenta_mayor_principal_grid"]->CurrentMode = "add";
					$GLOBALS["cuenta_mayor_principal_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cuenta_mayor_principal_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cuenta_mayor_principal_grid"]->setStartRecordNumber(1);
					$GLOBALS["cuenta_mayor_principal_grid"]->idsubgrupo_cuenta->FldIsDetailKey = TRUE;
					$GLOBALS["cuenta_mayor_principal_grid"]->idsubgrupo_cuenta->CurrentValue = $this->idsubgrupo_cuenta->CurrentValue;
					$GLOBALS["cuenta_mayor_principal_grid"]->idsubgrupo_cuenta->setSessionValue($GLOBALS["cuenta_mayor_principal_grid"]->idsubgrupo_cuenta->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("subgrupo_cuentalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($subgrupo_cuenta_add)) $subgrupo_cuenta_add = new csubgrupo_cuenta_add();

// Page init
$subgrupo_cuenta_add->Page_Init();

// Page main
$subgrupo_cuenta_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subgrupo_cuenta_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsubgrupo_cuentaadd = new ew_Form("fsubgrupo_cuentaadd", "add");

// Validate form
fsubgrupo_cuentaadd.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nomenclatura->FldCaption(), $subgrupo_cuenta->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->nombre->FldCaption(), $subgrupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->idgrupo_cuenta->FldCaption(), $subgrupo_cuenta->idgrupo_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_definicion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->definicion->FldCaption(), $subgrupo_cuenta->definicion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_flujo_efectivo");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($subgrupo_cuenta->idgrupo_flujo_efectivo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_tendencia");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subgrupo_cuenta->tendencia->FldCaption(), $subgrupo_cuenta->tendencia->ReqErrMsg)) ?>");

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
fsubgrupo_cuentaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubgrupo_cuentaadd.ValidateRequired = true;
<?php } else { ?>
fsubgrupo_cuentaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsubgrupo_cuentaadd.Lists["x_idgrupo_cuenta"] = {"LinkField":"x_idgrupo_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsubgrupo_cuentaadd.Lists["x_tendencia"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsubgrupo_cuentaadd.Lists["x_tendencia"].Options = <?php echo json_encode($subgrupo_cuenta->tendencia->Options()) ?>;

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
<?php $subgrupo_cuenta_add->ShowPageHeader(); ?>
<?php
$subgrupo_cuenta_add->ShowMessage();
?>
<form name="fsubgrupo_cuentaadd" id="fsubgrupo_cuentaadd" class="<?php echo $subgrupo_cuenta_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($subgrupo_cuenta_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $subgrupo_cuenta_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="subgrupo_cuenta">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($subgrupo_cuenta->getCurrentMasterTable() == "grupo_cuenta") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="grupo_cuenta">
<input type="hidden" name="fk_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($subgrupo_cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_subgrupo_cuenta_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->nomenclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->nomenclatura->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nomenclatura">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nomenclatura->EditValue ?>"<?php echo $subgrupo_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $subgrupo_cuenta->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subgrupo_cuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_subgrupo_cuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->nombre->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_nombre">
<input type="text" data-table="subgrupo_cuenta" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->nombre->EditValue ?>"<?php echo $subgrupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $subgrupo_cuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->Visible) { // idgrupo_cuenta ?>
	<div id="r_idgrupo_cuenta" class="form-group">
		<label id="elh_subgrupo_cuenta_idgrupo_cuenta" for="x_idgrupo_cuenta" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->idgrupo_cuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->idgrupo_cuenta->CellAttributes() ?>>
<?php if ($subgrupo_cuenta->idgrupo_cuenta->getSessionValue() <> "") { ?>
<span id="el_subgrupo_cuenta_idgrupo_cuenta">
<span<?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subgrupo_cuenta->idgrupo_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idgrupo_cuenta" name="x_idgrupo_cuenta" value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el_subgrupo_cuenta_idgrupo_cuenta">
<select data-table="subgrupo_cuenta" data-field="x_idgrupo_cuenta" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) : $subgrupo_cuenta->idgrupo_cuenta->DisplayValueSeparator) ?>" id="x_idgrupo_cuenta" name="x_idgrupo_cuenta"<?php echo $subgrupo_cuenta->idgrupo_cuenta->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->idgrupo_cuenta->EditValue)) {
	$arwrk = $subgrupo_cuenta->idgrupo_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->idgrupo_cuenta->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_cuenta->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->idgrupo_cuenta->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$subgrupo_cuenta->idgrupo_cuenta->LookupFilters += array("f0" => "`idgrupo_cuenta` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$subgrupo_cuenta->Lookup_Selecting($subgrupo_cuenta->idgrupo_cuenta, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $subgrupo_cuenta->idgrupo_cuenta->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idgrupo_cuenta" id="s_x_idgrupo_cuenta" value="<?php echo $subgrupo_cuenta->idgrupo_cuenta->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $subgrupo_cuenta->idgrupo_cuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subgrupo_cuenta->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_subgrupo_cuenta_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->definicion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->definicion->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_definicion">
<input type="text" data-table="subgrupo_cuenta" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->definicion->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->definicion->EditValue ?>"<?php echo $subgrupo_cuenta->definicion->EditAttributes() ?>>
</span>
<?php echo $subgrupo_cuenta->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subgrupo_cuenta->idgrupo_flujo_efectivo->Visible) { // idgrupo_flujo_efectivo ?>
	<div id="r_idgrupo_flujo_efectivo" class="form-group">
		<label id="elh_subgrupo_cuenta_idgrupo_flujo_efectivo" for="x_idgrupo_flujo_efectivo" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->idgrupo_flujo_efectivo->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->idgrupo_flujo_efectivo->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_idgrupo_flujo_efectivo">
<input type="text" data-table="subgrupo_cuenta" data-field="x_idgrupo_flujo_efectivo" name="x_idgrupo_flujo_efectivo" id="x_idgrupo_flujo_efectivo" size="30" placeholder="<?php echo ew_HtmlEncode($subgrupo_cuenta->idgrupo_flujo_efectivo->getPlaceHolder()) ?>" value="<?php echo $subgrupo_cuenta->idgrupo_flujo_efectivo->EditValue ?>"<?php echo $subgrupo_cuenta->idgrupo_flujo_efectivo->EditAttributes() ?>>
</span>
<?php echo $subgrupo_cuenta->idgrupo_flujo_efectivo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subgrupo_cuenta->tendencia->Visible) { // tendencia ?>
	<div id="r_tendencia" class="form-group">
		<label id="elh_subgrupo_cuenta_tendencia" for="x_tendencia" class="col-sm-2 control-label ewLabel"><?php echo $subgrupo_cuenta->tendencia->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subgrupo_cuenta->tendencia->CellAttributes() ?>>
<span id="el_subgrupo_cuenta_tendencia">
<select data-table="subgrupo_cuenta" data-field="x_tendencia" data-value-separator="<?php echo ew_HtmlEncode(is_array($subgrupo_cuenta->tendencia->DisplayValueSeparator) ? json_encode($subgrupo_cuenta->tendencia->DisplayValueSeparator) : $subgrupo_cuenta->tendencia->DisplayValueSeparator) ?>" id="x_tendencia" name="x_tendencia"<?php echo $subgrupo_cuenta->tendencia->EditAttributes() ?>>
<?php
if (is_array($subgrupo_cuenta->tendencia->EditValue)) {
	$arwrk = $subgrupo_cuenta->tendencia->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($subgrupo_cuenta->tendencia->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $subgrupo_cuenta->tendencia->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($subgrupo_cuenta->tendencia->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($subgrupo_cuenta->tendencia->CurrentValue) ?>" selected><?php echo $subgrupo_cuenta->tendencia->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $subgrupo_cuenta->tendencia->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("cuenta_mayor_principal", explode(",", $subgrupo_cuenta->getCurrentDetailTable())) && $cuenta_mayor_principal->DetailAdd) {
?>
<?php if ($subgrupo_cuenta->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cuenta_mayor_principal", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cuenta_mayor_principalgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $subgrupo_cuenta_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fsubgrupo_cuentaadd.Init();
</script>
<?php
$subgrupo_cuenta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$subgrupo_cuenta_add->Page_Terminate();
?>
