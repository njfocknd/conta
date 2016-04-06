<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "subcuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuenta_mayor_auxiliarinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "cuentagridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$subcuenta_add = NULL; // Initialize page object first

class csubcuenta_add extends csubcuenta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'subcuenta';

	// Page object name
	var $PageObjName = 'subcuenta_add';

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

		// Table object (subcuenta)
		if (!isset($GLOBALS["subcuenta"]) || get_class($GLOBALS["subcuenta"]) == "csubcuenta") {
			$GLOBALS["subcuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["subcuenta"];
		}

		// Table object (cuenta_mayor_auxiliar)
		if (!isset($GLOBALS['cuenta_mayor_auxiliar'])) $GLOBALS['cuenta_mayor_auxiliar'] = new ccuenta_mayor_auxiliar();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'subcuenta', TRUE);

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

			// Process auto fill for detail table 'cuenta'
			if (@$_POST["grid"] == "fcuentagrid") {
				if (!isset($GLOBALS["cuenta_grid"])) $GLOBALS["cuenta_grid"] = new ccuenta_grid;
				$GLOBALS["cuenta_grid"]->Page_Init();
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
		global $EW_EXPORT, $subcuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($subcuenta);
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
			if (@$_GET["idsubcuenta"] != "") {
				$this->idsubcuenta->setQueryStringValue($_GET["idsubcuenta"]);
				$this->setKey("idsubcuenta", $this->idsubcuenta->CurrentValue); // Set up key
			} else {
				$this->setKey("idsubcuenta", ""); // Clear key
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
					$this->Page_Terminate("subcuentalist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "subcuentaview.php")
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
		$this->nomenclatura->CurrentValue = NULL;
		$this->nomenclatura->OldValue = $this->nomenclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idcuenta_mayor_auxiliar->CurrentValue = NULL;
		$this->idcuenta_mayor_auxiliar->OldValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
		$this->definicion->CurrentValue = NULL;
		$this->definicion->OldValue = $this->definicion->CurrentValue;
		$this->estado->CurrentValue = "Activo";
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
		if (!$this->idcuenta_mayor_auxiliar->FldIsDetailKey) {
			$this->idcuenta_mayor_auxiliar->setFormValue($objForm->GetValue("x_idcuenta_mayor_auxiliar"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->FormValue;
		$this->definicion->CurrentValue = $this->definicion->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
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
		$this->idsubcuenta->setDbValue($rs->fields('idsubcuenta'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idcuenta_mayor_auxiliar->setDbValue($rs->fields('idcuenta_mayor_auxiliar'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idsubcuenta->DbValue = $row['idsubcuenta'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idcuenta_mayor_auxiliar->DbValue = $row['idcuenta_mayor_auxiliar'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idsubcuenta")) <> "")
			$this->idsubcuenta->CurrentValue = $this->getKey("idsubcuenta"); // idsubcuenta
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
		// idsubcuenta
		// nomenclatura
		// nombre
		// idcuenta_mayor_auxiliar
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idsubcuenta
			$this->idsubcuenta->ViewValue = $this->idsubcuenta->CurrentValue;
			$this->idsubcuenta->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
			$this->nomenclatura->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";

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

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->LinkCustomAttributes = "";
			$this->idcuenta_mayor_auxiliar->HrefValue = "";
			$this->idcuenta_mayor_auxiliar->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
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

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->EditAttrs["class"] = "form-control";
			$this->idcuenta_mayor_auxiliar->EditCustomAttributes = "";
			if ($this->idcuenta_mayor_auxiliar->getSessionValue() <> "") {
				$this->idcuenta_mayor_auxiliar->CurrentValue = $this->idcuenta_mayor_auxiliar->getSessionValue();
			$this->idcuenta_mayor_auxiliar->ViewValue = $this->idcuenta_mayor_auxiliar->CurrentValue;
			$this->idcuenta_mayor_auxiliar->ViewCustomAttributes = "";
			} else {
			$this->idcuenta_mayor_auxiliar->EditValue = ew_HtmlEncode($this->idcuenta_mayor_auxiliar->CurrentValue);
			$this->idcuenta_mayor_auxiliar->PlaceHolder = ew_RemoveHtml($this->idcuenta_mayor_auxiliar->FldCaption());
			}

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// estado
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			$this->estado->EditValue = $arwrk;

			// Edit refer script
			// nomenclatura

			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// idcuenta_mayor_auxiliar
			$this->idcuenta_mayor_auxiliar->HrefValue = "";

			// definicion
			$this->definicion->HrefValue = "";

			// estado
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
		if (!$this->nomenclatura->FldIsDetailKey && !is_null($this->nomenclatura->FormValue) && $this->nomenclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomenclatura->FldCaption(), $this->nomenclatura->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idcuenta_mayor_auxiliar->FldIsDetailKey && !is_null($this->idcuenta_mayor_auxiliar->FormValue) && $this->idcuenta_mayor_auxiliar->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idcuenta_mayor_auxiliar->FldCaption(), $this->idcuenta_mayor_auxiliar->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->idcuenta_mayor_auxiliar->FormValue)) {
			ew_AddMessage($gsFormError, $this->idcuenta_mayor_auxiliar->FldErrMsg());
		}
		if (!$this->definicion->FldIsDetailKey && !is_null($this->definicion->FormValue) && $this->definicion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->definicion->FldCaption(), $this->definicion->ReqErrMsg));
		}
		if ($this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cuenta", $DetailTblVar) && $GLOBALS["cuenta"]->DetailAdd) {
			if (!isset($GLOBALS["cuenta_grid"])) $GLOBALS["cuenta_grid"] = new ccuenta_grid(); // get detail page object
			$GLOBALS["cuenta_grid"]->ValidateGridForm();
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

		// nomenclatura
		$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idcuenta_mayor_auxiliar
		$this->idcuenta_mayor_auxiliar->SetDbValueDef($rsnew, $this->idcuenta_mayor_auxiliar->CurrentValue, 0, FALSE);

		// definicion
		$this->definicion->SetDbValueDef($rsnew, $this->definicion->CurrentValue, "", FALSE);

		// estado
		$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", strval($this->estado->CurrentValue) == "");

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
			$this->idsubcuenta->setDbValue($conn->Insert_ID());
			$rsnew['idsubcuenta'] = $this->idsubcuenta->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("cuenta", $DetailTblVar) && $GLOBALS["cuenta"]->DetailAdd) {
				$GLOBALS["cuenta"]->idsubcuenta->setSessionValue($this->idsubcuenta->CurrentValue); // Set master key
				if (!isset($GLOBALS["cuenta_grid"])) $GLOBALS["cuenta_grid"] = new ccuenta_grid(); // Get detail page object
				$AddRow = $GLOBALS["cuenta_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cuenta"]->idsubcuenta->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "cuenta_mayor_auxiliar") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcuenta_mayor_auxiliar"] <> "") {
					$GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->setQueryStringValue($_GET["fk_idcuenta_mayor_auxiliar"]);
					$this->idcuenta_mayor_auxiliar->setQueryStringValue($GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->QueryStringValue);
					$this->idcuenta_mayor_auxiliar->setSessionValue($this->idcuenta_mayor_auxiliar->QueryStringValue);
					if (!is_numeric($GLOBALS["cuenta_mayor_auxiliar"]->idcuenta_mayor_auxiliar->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "cuenta_mayor_auxiliar") {
				if ($this->idcuenta_mayor_auxiliar->QueryStringValue == "") $this->idcuenta_mayor_auxiliar->setSessionValue("");
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
			if (in_array("cuenta", $DetailTblVar)) {
				if (!isset($GLOBALS["cuenta_grid"]))
					$GLOBALS["cuenta_grid"] = new ccuenta_grid;
				if ($GLOBALS["cuenta_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cuenta_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cuenta_grid"]->CurrentMode = "add";
					$GLOBALS["cuenta_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cuenta_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cuenta_grid"]->setStartRecordNumber(1);
					$GLOBALS["cuenta_grid"]->idsubcuenta->FldIsDetailKey = TRUE;
					$GLOBALS["cuenta_grid"]->idsubcuenta->CurrentValue = $this->idsubcuenta->CurrentValue;
					$GLOBALS["cuenta_grid"]->idsubcuenta->setSessionValue($GLOBALS["cuenta_grid"]->idsubcuenta->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "subcuentalist.php", "", $this->TableVar, TRUE);
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
if (!isset($subcuenta_add)) $subcuenta_add = new csubcuenta_add();

// Page init
$subcuenta_add->Page_Init();

// Page main
$subcuenta_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$subcuenta_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var subcuenta_add = new ew_Page("subcuenta_add");
subcuenta_add.PageID = "add"; // Page ID
var EW_PAGE_ID = subcuenta_add.PageID; // For backward compatibility

// Form object
var fsubcuentaadd = new ew_Form("fsubcuentaadd");

// Validate form
fsubcuentaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomenclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nomenclatura->FldCaption(), $subcuenta->nomenclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->nombre->FldCaption(), $subcuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->idcuenta_mayor_auxiliar->FldCaption(), $subcuenta->idcuenta_mayor_auxiliar->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idcuenta_mayor_auxiliar");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($subcuenta->idcuenta_mayor_auxiliar->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_definicion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->definicion->FldCaption(), $subcuenta->definicion->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $subcuenta->estado->FldCaption(), $subcuenta->estado->ReqErrMsg)) ?>");

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
fsubcuentaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsubcuentaadd.ValidateRequired = true;
<?php } else { ?>
fsubcuentaadd.ValidateRequired = false; 
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
<?php $subcuenta_add->ShowPageHeader(); ?>
<?php
$subcuenta_add->ShowMessage();
?>
<form name="fsubcuentaadd" id="fsubcuentaadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($subcuenta_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $subcuenta_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="subcuenta">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($subcuenta->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_subcuenta_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $subcuenta->nomenclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subcuenta->nomenclatura->CellAttributes() ?>>
<span id="el_subcuenta_nomenclatura">
<input type="text" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nomenclatura->PlaceHolder) ?>" value="<?php echo $subcuenta->nomenclatura->EditValue ?>"<?php echo $subcuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $subcuenta->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subcuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_subcuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $subcuenta->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subcuenta->nombre->CellAttributes() ?>>
<span id="el_subcuenta_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->nombre->PlaceHolder) ?>" value="<?php echo $subcuenta->nombre->EditValue ?>"<?php echo $subcuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $subcuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->Visible) { // idcuenta_mayor_auxiliar ?>
	<div id="r_idcuenta_mayor_auxiliar" class="form-group">
		<label id="elh_subcuenta_idcuenta_mayor_auxiliar" for="x_idcuenta_mayor_auxiliar" class="col-sm-2 control-label ewLabel"><?php echo $subcuenta->idcuenta_mayor_auxiliar->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subcuenta->idcuenta_mayor_auxiliar->CellAttributes() ?>>
<?php if ($subcuenta->idcuenta_mayor_auxiliar->getSessionValue() <> "") { ?>
<span id="el_subcuenta_idcuenta_mayor_auxiliar">
<span<?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $subcuenta->idcuenta_mayor_auxiliar->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idcuenta_mayor_auxiliar" name="x_idcuenta_mayor_auxiliar" value="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->CurrentValue) ?>">
<?php } else { ?>
<span id="el_subcuenta_idcuenta_mayor_auxiliar">
<input type="text" data-field="x_idcuenta_mayor_auxiliar" name="x_idcuenta_mayor_auxiliar" id="x_idcuenta_mayor_auxiliar" size="30" placeholder="<?php echo ew_HtmlEncode($subcuenta->idcuenta_mayor_auxiliar->PlaceHolder) ?>" value="<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditValue ?>"<?php echo $subcuenta->idcuenta_mayor_auxiliar->EditAttributes() ?>>
</span>
<?php } ?>
<?php echo $subcuenta->idcuenta_mayor_auxiliar->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subcuenta->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_subcuenta_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $subcuenta->definicion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subcuenta->definicion->CellAttributes() ?>>
<span id="el_subcuenta_definicion">
<input type="text" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($subcuenta->definicion->PlaceHolder) ?>" value="<?php echo $subcuenta->definicion->EditValue ?>"<?php echo $subcuenta->definicion->EditAttributes() ?>>
</span>
<?php echo $subcuenta->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($subcuenta->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_subcuenta_estado" class="col-sm-2 control-label ewLabel"><?php echo $subcuenta->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $subcuenta->estado->CellAttributes() ?>>
<span id="el_subcuenta_estado">
<div id="tp_x_estado" class="<?php echo EW_ITEM_TEMPLATE_CLASSNAME ?>"><input type="radio" name="x_estado" id="x_estado" value="{value}"<?php echo $subcuenta->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList">
<?php
$arwrk = $subcuenta->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($subcuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked=\"checked\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;

		// Note: No spacing within the LABEL tag
?>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 1) ?>
<label class="radio-inline"><input type="radio" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $subcuenta->estado->EditAttributes() ?>><?php echo $arwrk[$rowcntwrk][1] ?></label>
<?php echo ew_RepeatColumnTable($rowswrk, $rowcntwrk, 5, 2) ?>
<?php
	}
}
?>
</div>
</span>
<?php echo $subcuenta->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("cuenta", explode(",", $subcuenta->getCurrentDetailTable())) && $cuenta->DetailAdd) {
?>
<?php if ($subcuenta->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cuenta", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "cuentagrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fsubcuentaadd.Init();
</script>
<?php
$subcuenta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$subcuenta_add->Page_Terminate();
?>
