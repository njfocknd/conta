<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "sucursalinfo.php" ?>
<?php include_once "empresainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$sucursal_add = NULL; // Initialize page object first

class csucursal_add extends csucursal {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'sucursal';

	// Page object name
	var $PageObjName = 'sucursal_add';

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

		// Table object (sucursal)
		if (!isset($GLOBALS["sucursal"]) || get_class($GLOBALS["sucursal"]) == "csucursal") {
			$GLOBALS["sucursal"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["sucursal"];
		}

		// Table object (empresa)
		if (!isset($GLOBALS['empresa'])) $GLOBALS['empresa'] = new cempresa();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'sucursal', TRUE);

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
		global $EW_EXPORT, $sucursal;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($sucursal);
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
			if (@$_GET["idsucursal"] != "") {
				$this->idsucursal->setQueryStringValue($_GET["idsucursal"]);
				$this->setKey("idsucursal", $this->idsucursal->CurrentValue); // Set up key
			} else {
				$this->setKey("idsucursal", ""); // Clear key
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
					$this->Page_Terminate("sucursallist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "sucursallist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "sucursalview.php")
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
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->casa_matriz->CurrentValue = "No";
		$this->direccion->CurrentValue = NULL;
		$this->direccion->OldValue = $this->direccion->CurrentValue;
		$this->idempresa->CurrentValue = 1;
		$this->idpais->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->casa_matriz->FldIsDetailKey) {
			$this->casa_matriz->setFormValue($objForm->GetValue("x_casa_matriz"));
		}
		if (!$this->direccion->FldIsDetailKey) {
			$this->direccion->setFormValue($objForm->GetValue("x_direccion"));
		}
		if (!$this->idempresa->FldIsDetailKey) {
			$this->idempresa->setFormValue($objForm->GetValue("x_idempresa"));
		}
		if (!$this->idpais->FldIsDetailKey) {
			$this->idpais->setFormValue($objForm->GetValue("x_idpais"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->casa_matriz->CurrentValue = $this->casa_matriz->FormValue;
		$this->direccion->CurrentValue = $this->direccion->FormValue;
		$this->idempresa->CurrentValue = $this->idempresa->FormValue;
		$this->idpais->CurrentValue = $this->idpais->FormValue;
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
		$this->idsucursal->setDbValue($rs->fields('idsucursal'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->casa_matriz->setDbValue($rs->fields('casa_matriz'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idsucursal->DbValue = $row['idsucursal'];
		$this->nombre->DbValue = $row['nombre'];
		$this->casa_matriz->DbValue = $row['casa_matriz'];
		$this->direccion->DbValue = $row['direccion'];
		$this->idempresa->DbValue = $row['idempresa'];
		$this->idpais->DbValue = $row['idpais'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idsucursal")) <> "")
			$this->idsucursal->CurrentValue = $this->getKey("idsucursal"); // idsucursal
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
		// idsucursal
		// nombre
		// casa_matriz
		// direccion
		// idempresa
		// idpais
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idsucursal
		$this->idsucursal->ViewValue = $this->idsucursal->CurrentValue;
		$this->idsucursal->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// casa_matriz
		if (strval($this->casa_matriz->CurrentValue) <> "") {
			$this->casa_matriz->ViewValue = $this->casa_matriz->OptionCaption($this->casa_matriz->CurrentValue);
		} else {
			$this->casa_matriz->ViewValue = NULL;
		}
		$this->casa_matriz->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

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
		$sSqlWrk .= " ORDER BY `nombre`";
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

		// idpais
		if (strval($this->idpais->CurrentValue) <> "") {
			$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idpais, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idpais->ViewValue = $this->idpais->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idpais->ViewValue = $this->idpais->CurrentValue;
			}
		} else {
			$this->idpais->ViewValue = NULL;
		}
		$this->idpais->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// casa_matriz
			$this->casa_matriz->LinkCustomAttributes = "";
			$this->casa_matriz->HrefValue = "";
			$this->casa_matriz->TooltipValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";
			$this->direccion->TooltipValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";
			$this->idpais->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// casa_matriz
			$this->casa_matriz->EditAttrs["class"] = "form-control";
			$this->casa_matriz->EditCustomAttributes = "";
			$this->casa_matriz->EditValue = $this->casa_matriz->Options(TRUE);

			// direccion
			$this->direccion->EditAttrs["class"] = "form-control";
			$this->direccion->EditCustomAttributes = "";
			$this->direccion->EditValue = ew_HtmlEncode($this->direccion->CurrentValue);
			$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if ($this->idempresa->getSessionValue() <> "") {
				$this->idempresa->CurrentValue = $this->idempresa->getSessionValue();
			if (strval($this->idempresa->CurrentValue) <> "") {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
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
			} else {
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
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;
			}

			// idpais
			$this->idpais->EditAttrs["class"] = "form-control";
			$this->idpais->EditCustomAttributes = "";
			if (trim(strval($this->idpais->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpais, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `nombre`";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpais->EditValue = $arwrk;

			// Add refer script
			// nombre

			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// casa_matriz
			$this->casa_matriz->LinkCustomAttributes = "";
			$this->casa_matriz->HrefValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";
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
		if (!$this->casa_matriz->FldIsDetailKey && !is_null($this->casa_matriz->FormValue) && $this->casa_matriz->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->casa_matriz->FldCaption(), $this->casa_matriz->ReqErrMsg));
		}
		if (!$this->idempresa->FldIsDetailKey && !is_null($this->idempresa->FormValue) && $this->idempresa->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idempresa->FldCaption(), $this->idempresa->ReqErrMsg));
		}
		if (!$this->idpais->FldIsDetailKey && !is_null($this->idpais->FormValue) && $this->idpais->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpais->FldCaption(), $this->idpais->ReqErrMsg));
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

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, FALSE);

		// casa_matriz
		$this->casa_matriz->SetDbValueDef($rsnew, $this->casa_matriz->CurrentValue, "", strval($this->casa_matriz->CurrentValue) == "");

		// direccion
		$this->direccion->SetDbValueDef($rsnew, $this->direccion->CurrentValue, NULL, FALSE);

		// idempresa
		$this->idempresa->SetDbValueDef($rsnew, $this->idempresa->CurrentValue, 0, strval($this->idempresa->CurrentValue) == "");

		// idpais
		$this->idpais->SetDbValueDef($rsnew, $this->idpais->CurrentValue, 0, strval($this->idpais->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idsucursal->setDbValue($conn->Insert_ID());
				$rsnew['idsucursal'] = $this->idsucursal->DbValue;
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
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "empresa") {
				if ($this->idempresa->CurrentValue == "") $this->idempresa->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("sucursallist.php"), "", $this->TableVar, TRUE);
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
if (!isset($sucursal_add)) $sucursal_add = new csucursal_add();

// Page init
$sucursal_add->Page_Init();

// Page main
$sucursal_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$sucursal_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fsucursaladd = new ew_Form("fsucursaladd", "add");

// Validate form
fsucursaladd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_casa_matriz");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->casa_matriz->FldCaption(), $sucursal->casa_matriz->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idempresa");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idempresa->FldCaption(), $sucursal->idempresa->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $sucursal->idpais->FldCaption(), $sucursal->idpais->ReqErrMsg)) ?>");

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
fsucursaladd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fsucursaladd.ValidateRequired = true;
<?php } else { ?>
fsucursaladd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fsucursaladd.Lists["x_casa_matriz"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsucursaladd.Lists["x_casa_matriz"].Options = <?php echo json_encode($sucursal->casa_matriz->Options()) ?>;
fsucursaladd.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fsucursaladd.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

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
<?php $sucursal_add->ShowPageHeader(); ?>
<?php
$sucursal_add->ShowMessage();
?>
<form name="fsucursaladd" id="fsucursaladd" class="<?php echo $sucursal_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($sucursal_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $sucursal_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="sucursal">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($sucursal->getCurrentMasterTable() == "empresa") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="empresa">
<input type="hidden" name="fk_idempresa" value="<?php echo $sucursal->idempresa->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($sucursal->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_sucursal_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $sucursal->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $sucursal->nombre->CellAttributes() ?>>
<span id="el_sucursal_nombre">
<input type="text" data-table="sucursal" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->nombre->getPlaceHolder()) ?>" value="<?php echo $sucursal->nombre->EditValue ?>"<?php echo $sucursal->nombre->EditAttributes() ?>>
</span>
<?php echo $sucursal->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sucursal->casa_matriz->Visible) { // casa_matriz ?>
	<div id="r_casa_matriz" class="form-group">
		<label id="elh_sucursal_casa_matriz" for="x_casa_matriz" class="col-sm-2 control-label ewLabel"><?php echo $sucursal->casa_matriz->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $sucursal->casa_matriz->CellAttributes() ?>>
<span id="el_sucursal_casa_matriz">
<select data-table="sucursal" data-field="x_casa_matriz" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->casa_matriz->DisplayValueSeparator) ? json_encode($sucursal->casa_matriz->DisplayValueSeparator) : $sucursal->casa_matriz->DisplayValueSeparator) ?>" id="x_casa_matriz" name="x_casa_matriz"<?php echo $sucursal->casa_matriz->EditAttributes() ?>>
<?php
if (is_array($sucursal->casa_matriz->EditValue)) {
	$arwrk = $sucursal->casa_matriz->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->casa_matriz->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->casa_matriz->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->casa_matriz->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->casa_matriz->CurrentValue) ?>" selected><?php echo $sucursal->casa_matriz->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $sucursal->casa_matriz->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sucursal->direccion->Visible) { // direccion ?>
	<div id="r_direccion" class="form-group">
		<label id="elh_sucursal_direccion" for="x_direccion" class="col-sm-2 control-label ewLabel"><?php echo $sucursal->direccion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $sucursal->direccion->CellAttributes() ?>>
<span id="el_sucursal_direccion">
<input type="text" data-table="sucursal" data-field="x_direccion" name="x_direccion" id="x_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($sucursal->direccion->getPlaceHolder()) ?>" value="<?php echo $sucursal->direccion->EditValue ?>"<?php echo $sucursal->direccion->EditAttributes() ?>>
</span>
<?php echo $sucursal->direccion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sucursal->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label id="elh_sucursal_idempresa" for="x_idempresa" class="col-sm-2 control-label ewLabel"><?php echo $sucursal->idempresa->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $sucursal->idempresa->CellAttributes() ?>>
<?php if ($sucursal->idempresa->getSessionValue() <> "") { ?>
<span id="el_sucursal_idempresa">
<span<?php echo $sucursal->idempresa->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $sucursal->idempresa->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idempresa" name="x_idempresa" value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>">
<?php } else { ?>
<span id="el_sucursal_idempresa">
<select data-table="sucursal" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idempresa->DisplayValueSeparator) ? json_encode($sucursal->idempresa->DisplayValueSeparator) : $sucursal->idempresa->DisplayValueSeparator) ?>" id="x_idempresa" name="x_idempresa"<?php echo $sucursal->idempresa->EditAttributes() ?>>
<?php
if (is_array($sucursal->idempresa->EditValue)) {
	$arwrk = $sucursal->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idempresa->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idempresa->CurrentValue) ?>" selected><?php echo $sucursal->idempresa->CurrentValue ?></option>
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
$sucursal->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="<?php echo $sucursal->idempresa->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $sucursal->idempresa->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($sucursal->idpais->Visible) { // idpais ?>
	<div id="r_idpais" class="form-group">
		<label id="elh_sucursal_idpais" for="x_idpais" class="col-sm-2 control-label ewLabel"><?php echo $sucursal->idpais->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $sucursal->idpais->CellAttributes() ?>>
<span id="el_sucursal_idpais">
<select data-table="sucursal" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($sucursal->idpais->DisplayValueSeparator) ? json_encode($sucursal->idpais->DisplayValueSeparator) : $sucursal->idpais->DisplayValueSeparator) ?>" id="x_idpais" name="x_idpais"<?php echo $sucursal->idpais->EditAttributes() ?>>
<?php
if (is_array($sucursal->idpais->EditValue)) {
	$arwrk = $sucursal->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($sucursal->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $sucursal->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($sucursal->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($sucursal->idpais->CurrentValue) ?>" selected><?php echo $sucursal->idpais->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$sucursal->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$sucursal->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$sucursal->Lookup_Selecting($sucursal->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
$sSqlWrk .= " ORDER BY `nombre`";
if ($sSqlWrk <> "") $sucursal->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idpais" id="s_x_idpais" value="<?php echo $sucursal->idpais->LookupFilterQuery() ?>">
</span>
<?php echo $sucursal->idpais->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $sucursal_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fsucursaladd.Init();
</script>
<?php
$sucursal_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$sucursal_add->Page_Terminate();
?>
