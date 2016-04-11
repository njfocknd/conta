<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "cuentainfo.php" ?>
<?php include_once "subcuentainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$cuenta_edit = NULL; // Initialize page object first

class ccuenta_edit extends ccuenta {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'cuenta';

	// Page object name
	var $PageObjName = 'cuenta_edit';

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

		// Table object (cuenta)
		if (!isset($GLOBALS["cuenta"]) || get_class($GLOBALS["cuenta"]) == "ccuenta") {
			$GLOBALS["cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["cuenta"];
		}

		// Table object (subcuenta)
		if (!isset($GLOBALS['subcuenta'])) $GLOBALS['subcuenta'] = new csubcuenta();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'cuenta', TRUE);

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
		global $EW_EXPORT, $cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($cuenta);
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
		if (@$_GET["idcuenta"] <> "") {
			$this->idcuenta->setQueryStringValue($_GET["idcuenta"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->idcuenta->CurrentValue == "")
			$this->Page_Terminate("cuentalist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("cuentalist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "cuentalist.php")
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
		if (!$this->nomenclatura->FldIsDetailKey) {
			$this->nomenclatura->setFormValue($objForm->GetValue("x_nomenclatura"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->debe->FldIsDetailKey) {
			$this->debe->setFormValue($objForm->GetValue("x_debe"));
		}
		if (!$this->haber->FldIsDetailKey) {
			$this->haber->setFormValue($objForm->GetValue("x_haber"));
		}
		if (!$this->saldo->FldIsDetailKey) {
			$this->saldo->setFormValue($objForm->GetValue("x_saldo"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idcuenta->FldIsDetailKey)
			$this->idcuenta->setFormValue($objForm->GetValue("x_idcuenta"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idcuenta->CurrentValue = $this->idcuenta->FormValue;
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->debe->CurrentValue = $this->debe->FormValue;
		$this->haber->CurrentValue = $this->haber->FormValue;
		$this->saldo->CurrentValue = $this->saldo->FormValue;
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
		$this->idcuenta->setDbValue($rs->fields('idcuenta'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->debe->setDbValue($rs->fields('debe'));
		$this->haber->setDbValue($rs->fields('haber'));
		$this->saldo->setDbValue($rs->fields('saldo'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->idsubcuenta->setDbValue($rs->fields('idsubcuenta'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcuenta->DbValue = $row['idcuenta'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->debe->DbValue = $row['debe'];
		$this->haber->DbValue = $row['haber'];
		$this->saldo->DbValue = $row['saldo'];
		$this->estado->DbValue = $row['estado'];
		$this->idsubcuenta->DbValue = $row['idsubcuenta'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Convert decimal values if posted back

		if ($this->debe->FormValue == $this->debe->CurrentValue && is_numeric(ew_StrToFloat($this->debe->CurrentValue)))
			$this->debe->CurrentValue = ew_StrToFloat($this->debe->CurrentValue);

		// Convert decimal values if posted back
		if ($this->haber->FormValue == $this->haber->CurrentValue && is_numeric(ew_StrToFloat($this->haber->CurrentValue)))
			$this->haber->CurrentValue = ew_StrToFloat($this->haber->CurrentValue);

		// Convert decimal values if posted back
		if ($this->saldo->FormValue == $this->saldo->CurrentValue && is_numeric(ew_StrToFloat($this->saldo->CurrentValue)))
			$this->saldo->CurrentValue = ew_StrToFloat($this->saldo->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// idcuenta
		// nomenclatura
		// nombre
		// debe
		// haber
		// saldo
		// estado
		// idsubcuenta

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idcuenta
		$this->idcuenta->ViewValue = $this->idcuenta->CurrentValue;
		$this->idcuenta->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// debe
		$this->debe->ViewValue = $this->debe->CurrentValue;
		$this->debe->ViewCustomAttributes = "";

		// haber
		$this->haber->ViewValue = $this->haber->CurrentValue;
		$this->haber->ViewCustomAttributes = "";

		// saldo
		$this->saldo->ViewValue = $this->saldo->CurrentValue;
		$this->saldo->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// idsubcuenta
		if (strval($this->idsubcuenta->CurrentValue) <> "") {
			$sFilterWrk = "`idsubcuenta`" . ew_SearchString("=", $this->idsubcuenta->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idsubcuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `subcuenta`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idsubcuenta, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idsubcuenta->ViewValue = $this->idsubcuenta->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idsubcuenta->ViewValue = $this->idsubcuenta->CurrentValue;
			}
		} else {
			$this->idsubcuenta->ViewValue = NULL;
		}
		$this->idsubcuenta->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// debe
			$this->debe->LinkCustomAttributes = "";
			$this->debe->HrefValue = "";
			$this->debe->TooltipValue = "";

			// haber
			$this->haber->LinkCustomAttributes = "";
			$this->haber->HrefValue = "";
			$this->haber->TooltipValue = "";

			// saldo
			$this->saldo->LinkCustomAttributes = "";
			$this->saldo->HrefValue = "";
			$this->saldo->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

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

			// debe
			$this->debe->EditAttrs["class"] = "form-control";
			$this->debe->EditCustomAttributes = "";
			$this->debe->EditValue = ew_HtmlEncode($this->debe->CurrentValue);
			$this->debe->PlaceHolder = ew_RemoveHtml($this->debe->FldCaption());
			if (strval($this->debe->EditValue) <> "" && is_numeric($this->debe->EditValue)) $this->debe->EditValue = ew_FormatNumber($this->debe->EditValue, -2, -1, -2, 0);

			// haber
			$this->haber->EditAttrs["class"] = "form-control";
			$this->haber->EditCustomAttributes = "";
			$this->haber->EditValue = ew_HtmlEncode($this->haber->CurrentValue);
			$this->haber->PlaceHolder = ew_RemoveHtml($this->haber->FldCaption());
			if (strval($this->haber->EditValue) <> "" && is_numeric($this->haber->EditValue)) $this->haber->EditValue = ew_FormatNumber($this->haber->EditValue, -2, -1, -2, 0);

			// saldo
			$this->saldo->EditAttrs["class"] = "form-control";
			$this->saldo->EditCustomAttributes = "";
			$this->saldo->EditValue = ew_HtmlEncode($this->saldo->CurrentValue);
			$this->saldo->PlaceHolder = ew_RemoveHtml($this->saldo->FldCaption());
			if (strval($this->saldo->EditValue) <> "" && is_numeric($this->saldo->EditValue)) $this->saldo->EditValue = ew_FormatNumber($this->saldo->EditValue, -2, -1, -2, 0);

			// estado
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(FALSE);

			// Edit refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// debe
			$this->debe->LinkCustomAttributes = "";
			$this->debe->HrefValue = "";

			// haber
			$this->haber->LinkCustomAttributes = "";
			$this->haber->HrefValue = "";

			// saldo
			$this->saldo->LinkCustomAttributes = "";
			$this->saldo->HrefValue = "";

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
		if (!$this->debe->FldIsDetailKey && !is_null($this->debe->FormValue) && $this->debe->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->debe->FldCaption(), $this->debe->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->debe->FormValue)) {
			ew_AddMessage($gsFormError, $this->debe->FldErrMsg());
		}
		if (!$this->haber->FldIsDetailKey && !is_null($this->haber->FormValue) && $this->haber->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->haber->FldCaption(), $this->haber->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->haber->FormValue)) {
			ew_AddMessage($gsFormError, $this->haber->FldErrMsg());
		}
		if (!$this->saldo->FldIsDetailKey && !is_null($this->saldo->FormValue) && $this->saldo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->saldo->FldCaption(), $this->saldo->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->saldo->FormValue)) {
			ew_AddMessage($gsFormError, $this->saldo->FldErrMsg());
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

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nomenclatura
			$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, NULL, $this->nomenclatura->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, $this->nombre->ReadOnly);

			// debe
			$this->debe->SetDbValueDef($rsnew, $this->debe->CurrentValue, 0, $this->debe->ReadOnly);

			// haber
			$this->haber->SetDbValueDef($rsnew, $this->haber->CurrentValue, 0, $this->haber->ReadOnly);

			// saldo
			$this->saldo->SetDbValueDef($rsnew, $this->saldo->CurrentValue, 0, $this->saldo->ReadOnly);

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
			if ($sMasterTblVar == "subcuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idsubcuenta"] <> "") {
					$GLOBALS["subcuenta"]->idsubcuenta->setQueryStringValue($_GET["fk_idsubcuenta"]);
					$this->idsubcuenta->setQueryStringValue($GLOBALS["subcuenta"]->idsubcuenta->QueryStringValue);
					$this->idsubcuenta->setSessionValue($this->idsubcuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["subcuenta"]->idsubcuenta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "subcuenta") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idsubcuenta"] <> "") {
					$GLOBALS["subcuenta"]->idsubcuenta->setFormValue($_POST["fk_idsubcuenta"]);
					$this->idsubcuenta->setFormValue($GLOBALS["subcuenta"]->idsubcuenta->FormValue);
					$this->idsubcuenta->setSessionValue($this->idsubcuenta->FormValue);
					if (!is_numeric($GLOBALS["subcuenta"]->idsubcuenta->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "subcuenta") {
				if ($this->idsubcuenta->CurrentValue == "") $this->idsubcuenta->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("cuentalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($cuenta_edit)) $cuenta_edit = new ccuenta_edit();

// Page init
$cuenta_edit->Page_Init();

// Page main
$cuenta_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$cuenta_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fcuentaedit = new ew_Form("fcuentaedit", "edit");

// Validate form
fcuentaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_debe");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->debe->FldCaption(), $cuenta->debe->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_debe");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->debe->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_haber");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->haber->FldCaption(), $cuenta->haber->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_haber");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->haber->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->saldo->FldCaption(), $cuenta->saldo->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_saldo");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($cuenta->saldo->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $cuenta->estado->FldCaption(), $cuenta->estado->ReqErrMsg)) ?>");

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
fcuentaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcuentaedit.ValidateRequired = true;
<?php } else { ?>
fcuentaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fcuentaedit.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fcuentaedit.Lists["x_estado"].Options = <?php echo json_encode($cuenta->estado->Options()) ?>;

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
<?php $cuenta_edit->ShowPageHeader(); ?>
<?php
$cuenta_edit->ShowMessage();
?>
<form name="fcuentaedit" id="fcuentaedit" class="<?php echo $cuenta_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($cuenta_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $cuenta_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="cuenta">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($cuenta->getCurrentMasterTable() == "subcuenta") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="subcuenta">
<input type="hidden" name="fk_idsubcuenta" value="<?php echo $cuenta->idsubcuenta->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_cuenta_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->nomenclatura->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->nomenclatura->CellAttributes() ?>>
<span id="el_cuenta_nomenclatura">
<input type="text" data-table="cuenta" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $cuenta->nomenclatura->EditValue ?>"<?php echo $cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $cuenta->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_cuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->nombre->CellAttributes() ?>>
<span id="el_cuenta_nombre">
<input type="text" data-table="cuenta" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $cuenta->nombre->EditValue ?>"<?php echo $cuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $cuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->debe->Visible) { // debe ?>
	<div id="r_debe" class="form-group">
		<label id="elh_cuenta_debe" for="x_debe" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->debe->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->debe->CellAttributes() ?>>
<span id="el_cuenta_debe">
<input type="text" data-table="cuenta" data-field="x_debe" name="x_debe" id="x_debe" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->debe->getPlaceHolder()) ?>" value="<?php echo $cuenta->debe->EditValue ?>"<?php echo $cuenta->debe->EditAttributes() ?>>
</span>
<?php echo $cuenta->debe->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->haber->Visible) { // haber ?>
	<div id="r_haber" class="form-group">
		<label id="elh_cuenta_haber" for="x_haber" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->haber->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->haber->CellAttributes() ?>>
<span id="el_cuenta_haber">
<input type="text" data-table="cuenta" data-field="x_haber" name="x_haber" id="x_haber" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->haber->getPlaceHolder()) ?>" value="<?php echo $cuenta->haber->EditValue ?>"<?php echo $cuenta->haber->EditAttributes() ?>>
</span>
<?php echo $cuenta->haber->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->saldo->Visible) { // saldo ?>
	<div id="r_saldo" class="form-group">
		<label id="elh_cuenta_saldo" for="x_saldo" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->saldo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->saldo->CellAttributes() ?>>
<span id="el_cuenta_saldo">
<input type="text" data-table="cuenta" data-field="x_saldo" name="x_saldo" id="x_saldo" size="30" placeholder="<?php echo ew_HtmlEncode($cuenta->saldo->getPlaceHolder()) ?>" value="<?php echo $cuenta->saldo->EditValue ?>"<?php echo $cuenta->saldo->EditAttributes() ?>>
</span>
<?php echo $cuenta->saldo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($cuenta->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_cuenta_estado" class="col-sm-2 control-label ewLabel"><?php echo $cuenta->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $cuenta->estado->CellAttributes() ?>>
<span id="el_cuenta_estado">
<div id="tp_x_estado" class="ewTemplate"><input type="radio" data-table="cuenta" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($cuenta->estado->DisplayValueSeparator) ? json_encode($cuenta->estado->DisplayValueSeparator) : $cuenta->estado->DisplayValueSeparator) ?>" name="x_estado" id="x_estado" value="{value}"<?php echo $cuenta->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $cuenta->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($cuenta->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="cuenta" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $cuenta->estado->EditAttributes() ?>><?php echo $cuenta->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($cuenta->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="cuenta" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($cuenta->estado->CurrentValue) ?>" checked<?php echo $cuenta->estado->EditAttributes() ?>><?php echo $cuenta->estado->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
<?php echo $cuenta->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="cuenta" data-field="x_idcuenta" name="x_idcuenta" id="x_idcuenta" value="<?php echo ew_HtmlEncode($cuenta->idcuenta->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $cuenta_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fcuentaedit.Init();
</script>
<?php
$cuenta_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$cuenta_edit->Page_Terminate();
?>
