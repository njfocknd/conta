<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "clase_cuentainfo.php" ?>
<?php include_once "grupo_cuentagridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$clase_cuenta_edit = NULL; // Initialize page object first

class cclase_cuenta_edit extends cclase_cuenta {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'clase_cuenta';

	// Page object name
	var $PageObjName = 'clase_cuenta_edit';

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

		// Table object (clase_cuenta)
		if (!isset($GLOBALS["clase_cuenta"]) || get_class($GLOBALS["clase_cuenta"]) == "cclase_cuenta") {
			$GLOBALS["clase_cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["clase_cuenta"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'clase_cuenta', TRUE);

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

			// Process auto fill for detail table 'grupo_cuenta'
			if (@$_POST["grid"] == "fgrupo_cuentagrid") {
				if (!isset($GLOBALS["grupo_cuenta_grid"])) $GLOBALS["grupo_cuenta_grid"] = new cgrupo_cuenta_grid;
				$GLOBALS["grupo_cuenta_grid"]->Page_Init();
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
		global $EW_EXPORT, $clase_cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($clase_cuenta);
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
		if (@$_GET["idclase_cuenta"] <> "") {
			$this->idclase_cuenta->setQueryStringValue($_GET["idclase_cuenta"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetUpDetailParms();
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->idclase_cuenta->CurrentValue == "")
			$this->Page_Terminate("clase_cuentalist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("clase_cuentalist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "clase_cuentalist.php")
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

					// Set up detail parameters
					$this->SetUpDetailParms();
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
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
		if (!$this->idclase_cuenta->FldIsDetailKey)
			$this->idclase_cuenta->setFormValue($objForm->GetValue("x_idclase_cuenta"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idclase_cuenta->CurrentValue = $this->idclase_cuenta->FormValue;
		$this->nomenclatura->CurrentValue = $this->nomenclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->estado->CurrentValue = $this->estado->FormValue;
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
		$this->idclase_cuenta->setDbValue($rs->fields('idclase_cuenta'));
		$this->nomenclatura->setDbValue($rs->fields('nomenclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->definicion->setDbValue($rs->fields('definicion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idclase_cuenta->DbValue = $row['idclase_cuenta'];
		$this->nomenclatura->DbValue = $row['nomenclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->estado->DbValue = $row['estado'];
		$this->definicion->DbValue = $row['definicion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idclase_cuenta
		// nomenclatura
		// nombre
		// estado
		// definicion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idclase_cuenta
		$this->idclase_cuenta->ViewValue = $this->idclase_cuenta->CurrentValue;
		$this->idclase_cuenta->ViewCustomAttributes = "";

		// nomenclatura
		$this->nomenclatura->ViewValue = $this->nomenclatura->CurrentValue;
		$this->nomenclatura->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// definicion
		$this->definicion->ViewValue = $this->definicion->CurrentValue;
		$this->definicion->ViewCustomAttributes = "";

			// nomenclatura
			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";
			$this->nomenclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";
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

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(TRUE);

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// Edit refer script
			// nomenclatura

			$this->nomenclatura->LinkCustomAttributes = "";
			$this->nomenclatura->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";

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
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("grupo_cuenta", $DetailTblVar) && $GLOBALS["grupo_cuenta"]->DetailEdit) {
			if (!isset($GLOBALS["grupo_cuenta_grid"])) $GLOBALS["grupo_cuenta_grid"] = new cgrupo_cuenta_grid(); // get detail page object
			$GLOBALS["grupo_cuenta_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// nomenclatura
			$this->nomenclatura->SetDbValueDef($rsnew, $this->nomenclatura->CurrentValue, NULL, $this->nomenclatura->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, $this->nombre->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

			// definicion
			$this->definicion->SetDbValueDef($rsnew, $this->definicion->CurrentValue, NULL, $this->definicion->ReadOnly);

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

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("grupo_cuenta", $DetailTblVar) && $GLOBALS["grupo_cuenta"]->DetailEdit) {
						if (!isset($GLOBALS["grupo_cuenta_grid"])) $GLOBALS["grupo_cuenta_grid"] = new cgrupo_cuenta_grid(); // Get detail page object
						$EditRow = $GLOBALS["grupo_cuenta_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
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
			if (in_array("grupo_cuenta", $DetailTblVar)) {
				if (!isset($GLOBALS["grupo_cuenta_grid"]))
					$GLOBALS["grupo_cuenta_grid"] = new cgrupo_cuenta_grid;
				if ($GLOBALS["grupo_cuenta_grid"]->DetailEdit) {
					$GLOBALS["grupo_cuenta_grid"]->CurrentMode = "edit";
					$GLOBALS["grupo_cuenta_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["grupo_cuenta_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["grupo_cuenta_grid"]->setStartRecordNumber(1);
					$GLOBALS["grupo_cuenta_grid"]->idclase_cuenta->FldIsDetailKey = TRUE;
					$GLOBALS["grupo_cuenta_grid"]->idclase_cuenta->CurrentValue = $this->idclase_cuenta->CurrentValue;
					$GLOBALS["grupo_cuenta_grid"]->idclase_cuenta->setSessionValue($GLOBALS["grupo_cuenta_grid"]->idclase_cuenta->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("clase_cuentalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($clase_cuenta_edit)) $clase_cuenta_edit = new cclase_cuenta_edit();

// Page init
$clase_cuenta_edit->Page_Init();

// Page main
$clase_cuenta_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$clase_cuenta_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fclase_cuentaedit = new ew_Form("fclase_cuentaedit", "edit");

// Validate form
fclase_cuentaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $clase_cuenta->estado->FldCaption(), $clase_cuenta->estado->ReqErrMsg)) ?>");

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
fclase_cuentaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fclase_cuentaedit.ValidateRequired = true;
<?php } else { ?>
fclase_cuentaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fclase_cuentaedit.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fclase_cuentaedit.Lists["x_estado"].Options = <?php echo json_encode($clase_cuenta->estado->Options()) ?>;

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
<?php $clase_cuenta_edit->ShowPageHeader(); ?>
<?php
$clase_cuenta_edit->ShowMessage();
?>
<form name="fclase_cuentaedit" id="fclase_cuentaedit" class="<?php echo $clase_cuenta_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($clase_cuenta_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $clase_cuenta_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="clase_cuenta">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($clase_cuenta->nomenclatura->Visible) { // nomenclatura ?>
	<div id="r_nomenclatura" class="form-group">
		<label id="elh_clase_cuenta_nomenclatura" for="x_nomenclatura" class="col-sm-2 control-label ewLabel"><?php echo $clase_cuenta->nomenclatura->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $clase_cuenta->nomenclatura->CellAttributes() ?>>
<span id="el_clase_cuenta_nomenclatura">
<input type="text" data-table="clase_cuenta" data-field="x_nomenclatura" name="x_nomenclatura" id="x_nomenclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($clase_cuenta->nomenclatura->getPlaceHolder()) ?>" value="<?php echo $clase_cuenta->nomenclatura->EditValue ?>"<?php echo $clase_cuenta->nomenclatura->EditAttributes() ?>>
</span>
<?php echo $clase_cuenta->nomenclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clase_cuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_clase_cuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $clase_cuenta->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $clase_cuenta->nombre->CellAttributes() ?>>
<span id="el_clase_cuenta_nombre">
<input type="text" data-table="clase_cuenta" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($clase_cuenta->nombre->getPlaceHolder()) ?>" value="<?php echo $clase_cuenta->nombre->EditValue ?>"<?php echo $clase_cuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $clase_cuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clase_cuenta->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_clase_cuenta_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $clase_cuenta->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $clase_cuenta->estado->CellAttributes() ?>>
<span id="el_clase_cuenta_estado">
<select data-table="clase_cuenta" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($clase_cuenta->estado->DisplayValueSeparator) ? json_encode($clase_cuenta->estado->DisplayValueSeparator) : $clase_cuenta->estado->DisplayValueSeparator) ?>" id="x_estado" name="x_estado"<?php echo $clase_cuenta->estado->EditAttributes() ?>>
<?php
if (is_array($clase_cuenta->estado->EditValue)) {
	$arwrk = $clase_cuenta->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($clase_cuenta->estado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $clase_cuenta->estado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($clase_cuenta->estado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($clase_cuenta->estado->CurrentValue) ?>" selected><?php echo $clase_cuenta->estado->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $clase_cuenta->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($clase_cuenta->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_clase_cuenta_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $clase_cuenta->definicion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $clase_cuenta->definicion->CellAttributes() ?>>
<span id="el_clase_cuenta_definicion">
<input type="text" data-table="clase_cuenta" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($clase_cuenta->definicion->getPlaceHolder()) ?>" value="<?php echo $clase_cuenta->definicion->EditValue ?>"<?php echo $clase_cuenta->definicion->EditAttributes() ?>>
</span>
<?php echo $clase_cuenta->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="clase_cuenta" data-field="x_idclase_cuenta" name="x_idclase_cuenta" id="x_idclase_cuenta" value="<?php echo ew_HtmlEncode($clase_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php
	if (in_array("grupo_cuenta", explode(",", $clase_cuenta->getCurrentDetailTable())) && $grupo_cuenta->DetailEdit) {
?>
<?php if ($clase_cuenta->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("grupo_cuenta", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "grupo_cuentagrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $clase_cuenta_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fclase_cuentaedit.Init();
</script>
<?php
$clase_cuenta_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$clase_cuenta_edit->Page_Terminate();
?>
