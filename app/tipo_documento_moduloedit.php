<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "tipo_documento_moduloinfo.php" ?>
<?php include_once "moduloinfo.php" ?>
<?php include_once "tipo_documentoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$tipo_documento_modulo_edit = NULL; // Initialize page object first

class ctipo_documento_modulo_edit extends ctipo_documento_modulo {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'tipo_documento_modulo';

	// Page object name
	var $PageObjName = 'tipo_documento_modulo_edit';

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

		// Table object (tipo_documento_modulo)
		if (!isset($GLOBALS["tipo_documento_modulo"]) || get_class($GLOBALS["tipo_documento_modulo"]) == "ctipo_documento_modulo") {
			$GLOBALS["tipo_documento_modulo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["tipo_documento_modulo"];
		}

		// Table object (modulo)
		if (!isset($GLOBALS['modulo'])) $GLOBALS['modulo'] = new cmodulo();

		// Table object (tipo_documento)
		if (!isset($GLOBALS['tipo_documento'])) $GLOBALS['tipo_documento'] = new ctipo_documento();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'tipo_documento_modulo', TRUE);

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
		global $EW_EXPORT, $tipo_documento_modulo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($tipo_documento_modulo);
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
		if (@$_GET["idtipo_documento_modulo"] <> "") {
			$this->idtipo_documento_modulo->setQueryStringValue($_GET["idtipo_documento_modulo"]);
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
		if ($this->idtipo_documento_modulo->CurrentValue == "")
			$this->Page_Terminate("tipo_documento_modulolist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("tipo_documento_modulolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "tipo_documento_modulolist.php")
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
		if (!$this->idtipo_documento->FldIsDetailKey) {
			$this->idtipo_documento->setFormValue($objForm->GetValue("x_idtipo_documento"));
		}
		if (!$this->idmodulo->FldIsDetailKey) {
			$this->idmodulo->setFormValue($objForm->GetValue("x_idmodulo"));
		}
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idtipo_documento_modulo->FldIsDetailKey)
			$this->idtipo_documento_modulo->setFormValue($objForm->GetValue("x_idtipo_documento_modulo"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idtipo_documento_modulo->CurrentValue = $this->idtipo_documento_modulo->FormValue;
		$this->idtipo_documento->CurrentValue = $this->idtipo_documento->FormValue;
		$this->idmodulo->CurrentValue = $this->idmodulo->FormValue;
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
		$this->idtipo_documento_modulo->setDbValue($rs->fields('idtipo_documento_modulo'));
		$this->idtipo_documento->setDbValue($rs->fields('idtipo_documento'));
		$this->idmodulo->setDbValue($rs->fields('idmodulo'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idtipo_documento_modulo->DbValue = $row['idtipo_documento_modulo'];
		$this->idtipo_documento->DbValue = $row['idtipo_documento'];
		$this->idmodulo->DbValue = $row['idmodulo'];
		$this->estado->DbValue = $row['estado'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idtipo_documento_modulo
		// idtipo_documento
		// idmodulo
		// estado
		// fecha_insercion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idtipo_documento_modulo
		$this->idtipo_documento_modulo->ViewValue = $this->idtipo_documento_modulo->CurrentValue;
		$this->idtipo_documento_modulo->ViewCustomAttributes = "";

		// idtipo_documento
		if (strval($this->idtipo_documento->CurrentValue) <> "") {
			$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
			}
		} else {
			$this->idtipo_documento->ViewValue = NULL;
		}
		$this->idtipo_documento->ViewCustomAttributes = "";

		// idmodulo
		if (strval($this->idmodulo->CurrentValue) <> "") {
			$sFilterWrk = "`idmodulo`" . ew_SearchString("=", $this->idmodulo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idmodulo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idmodulo->ViewValue = $this->idmodulo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idmodulo->ViewValue = $this->idmodulo->CurrentValue;
			}
		} else {
			$this->idmodulo->ViewValue = NULL;
		}
		$this->idmodulo->ViewCustomAttributes = "";

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

			// idtipo_documento
			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";
			$this->idtipo_documento->TooltipValue = "";

			// idmodulo
			$this->idmodulo->LinkCustomAttributes = "";
			$this->idmodulo->HrefValue = "";
			$this->idmodulo->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// idtipo_documento
			$this->idtipo_documento->EditAttrs["class"] = "form-control";
			$this->idtipo_documento->EditCustomAttributes = "";
			if ($this->idtipo_documento->getSessionValue() <> "") {
				$this->idtipo_documento->CurrentValue = $this->idtipo_documento->getSessionValue();
			if (strval($this->idtipo_documento->CurrentValue) <> "") {
				$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idtipo_documento->ViewValue = $this->idtipo_documento->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idtipo_documento->ViewValue = $this->idtipo_documento->CurrentValue;
				}
			} else {
				$this->idtipo_documento->ViewValue = NULL;
			}
			$this->idtipo_documento->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idtipo_documento->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idtipo_documento`" . ew_SearchString("=", $this->idtipo_documento->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_documento`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idtipo_documento, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idtipo_documento->EditValue = $arwrk;
			}

			// idmodulo
			$this->idmodulo->EditAttrs["class"] = "form-control";
			$this->idmodulo->EditCustomAttributes = "";
			if ($this->idmodulo->getSessionValue() <> "") {
				$this->idmodulo->CurrentValue = $this->idmodulo->getSessionValue();
			if (strval($this->idmodulo->CurrentValue) <> "") {
				$sFilterWrk = "`idmodulo`" . ew_SearchString("=", $this->idmodulo->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idmodulo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->idmodulo->ViewValue = $this->idmodulo->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->idmodulo->ViewValue = $this->idmodulo->CurrentValue;
				}
			} else {
				$this->idmodulo->ViewValue = NULL;
			}
			$this->idmodulo->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idmodulo->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idmodulo`" . ew_SearchString("=", $this->idmodulo->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `modulo`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idmodulo, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idmodulo->EditValue = $arwrk;
			}

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(TRUE);

			// Edit refer script
			// idtipo_documento

			$this->idtipo_documento->LinkCustomAttributes = "";
			$this->idtipo_documento->HrefValue = "";

			// idmodulo
			$this->idmodulo->LinkCustomAttributes = "";
			$this->idmodulo->HrefValue = "";

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
		if (!$this->idtipo_documento->FldIsDetailKey && !is_null($this->idtipo_documento->FormValue) && $this->idtipo_documento->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idtipo_documento->FldCaption(), $this->idtipo_documento->ReqErrMsg));
		}
		if (!$this->idmodulo->FldIsDetailKey && !is_null($this->idmodulo->FormValue) && $this->idmodulo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idmodulo->FldCaption(), $this->idmodulo->ReqErrMsg));
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

			// idtipo_documento
			$this->idtipo_documento->SetDbValueDef($rsnew, $this->idtipo_documento->CurrentValue, 0, $this->idtipo_documento->ReadOnly);

			// idmodulo
			$this->idmodulo->SetDbValueDef($rsnew, $this->idmodulo->CurrentValue, 0, $this->idmodulo->ReadOnly);

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
			if ($sMasterTblVar == "tipo_documento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idtipo_documento"] <> "") {
					$GLOBALS["tipo_documento"]->idtipo_documento->setQueryStringValue($_GET["fk_idtipo_documento"]);
					$this->idtipo_documento->setQueryStringValue($GLOBALS["tipo_documento"]->idtipo_documento->QueryStringValue);
					$this->idtipo_documento->setSessionValue($this->idtipo_documento->QueryStringValue);
					if (!is_numeric($GLOBALS["tipo_documento"]->idtipo_documento->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "modulo") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idmodulo"] <> "") {
					$GLOBALS["modulo"]->idmodulo->setQueryStringValue($_GET["fk_idmodulo"]);
					$this->idmodulo->setQueryStringValue($GLOBALS["modulo"]->idmodulo->QueryStringValue);
					$this->idmodulo->setSessionValue($this->idmodulo->QueryStringValue);
					if (!is_numeric($GLOBALS["modulo"]->idmodulo->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "tipo_documento") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idtipo_documento"] <> "") {
					$GLOBALS["tipo_documento"]->idtipo_documento->setFormValue($_POST["fk_idtipo_documento"]);
					$this->idtipo_documento->setFormValue($GLOBALS["tipo_documento"]->idtipo_documento->FormValue);
					$this->idtipo_documento->setSessionValue($this->idtipo_documento->FormValue);
					if (!is_numeric($GLOBALS["tipo_documento"]->idtipo_documento->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
			if ($sMasterTblVar == "modulo") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idmodulo"] <> "") {
					$GLOBALS["modulo"]->idmodulo->setFormValue($_POST["fk_idmodulo"]);
					$this->idmodulo->setFormValue($GLOBALS["modulo"]->idmodulo->FormValue);
					$this->idmodulo->setSessionValue($this->idmodulo->FormValue);
					if (!is_numeric($GLOBALS["modulo"]->idmodulo->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "tipo_documento") {
				if ($this->idtipo_documento->CurrentValue == "") $this->idtipo_documento->setSessionValue("");
			}
			if ($sMasterTblVar <> "modulo") {
				if ($this->idmodulo->CurrentValue == "") $this->idmodulo->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("tipo_documento_modulolist.php"), "", $this->TableVar, TRUE);
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
if (!isset($tipo_documento_modulo_edit)) $tipo_documento_modulo_edit = new ctipo_documento_modulo_edit();

// Page init
$tipo_documento_modulo_edit->Page_Init();

// Page main
$tipo_documento_modulo_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$tipo_documento_modulo_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ftipo_documento_moduloedit = new ew_Form("ftipo_documento_moduloedit", "edit");

// Validate form
ftipo_documento_moduloedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idtipo_documento");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tipo_documento_modulo->idtipo_documento->FldCaption(), $tipo_documento_modulo->idtipo_documento->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idmodulo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $tipo_documento_modulo->idmodulo->FldCaption(), $tipo_documento_modulo->idmodulo->ReqErrMsg)) ?>");

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
ftipo_documento_moduloedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftipo_documento_moduloedit.ValidateRequired = true;
<?php } else { ?>
ftipo_documento_moduloedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftipo_documento_moduloedit.Lists["x_idtipo_documento"] = {"LinkField":"x_idtipo_documento","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftipo_documento_moduloedit.Lists["x_idmodulo"] = {"LinkField":"x_idmodulo","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftipo_documento_moduloedit.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
ftipo_documento_moduloedit.Lists["x_estado"].Options = <?php echo json_encode($tipo_documento_modulo->estado->Options()) ?>;

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
<?php $tipo_documento_modulo_edit->ShowPageHeader(); ?>
<?php
$tipo_documento_modulo_edit->ShowMessage();
?>
<form name="ftipo_documento_moduloedit" id="ftipo_documento_moduloedit" class="<?php echo $tipo_documento_modulo_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($tipo_documento_modulo_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $tipo_documento_modulo_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="tipo_documento_modulo">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($tipo_documento_modulo->getCurrentMasterTable() == "tipo_documento") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="tipo_documento">
<input type="hidden" name="fk_idtipo_documento" value="<?php echo $tipo_documento_modulo->idtipo_documento->getSessionValue() ?>">
<?php } ?>
<?php if ($tipo_documento_modulo->getCurrentMasterTable() == "modulo") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="modulo">
<input type="hidden" name="fk_idmodulo" value="<?php echo $tipo_documento_modulo->idmodulo->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($tipo_documento_modulo->idtipo_documento->Visible) { // idtipo_documento ?>
	<div id="r_idtipo_documento" class="form-group">
		<label id="elh_tipo_documento_modulo_idtipo_documento" for="x_idtipo_documento" class="col-sm-2 control-label ewLabel"><?php echo $tipo_documento_modulo->idtipo_documento->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tipo_documento_modulo->idtipo_documento->CellAttributes() ?>>
<?php if ($tipo_documento_modulo->idtipo_documento->getSessionValue() <> "") { ?>
<span id="el_tipo_documento_modulo_idtipo_documento">
<span<?php echo $tipo_documento_modulo->idtipo_documento->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idtipo_documento->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idtipo_documento" name="x_idtipo_documento" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->CurrentValue) ?>">
<?php } else { ?>
<span id="el_tipo_documento_modulo_idtipo_documento">
<select data-table="tipo_documento_modulo" data-field="x_idtipo_documento" data-value-separator="<?php echo ew_HtmlEncode(is_array($tipo_documento_modulo->idtipo_documento->DisplayValueSeparator) ? json_encode($tipo_documento_modulo->idtipo_documento->DisplayValueSeparator) : $tipo_documento_modulo->idtipo_documento->DisplayValueSeparator) ?>" id="x_idtipo_documento" name="x_idtipo_documento"<?php echo $tipo_documento_modulo->idtipo_documento->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idtipo_documento->EditValue)) {
	$arwrk = $tipo_documento_modulo->idtipo_documento->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($tipo_documento_modulo->idtipo_documento->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $tipo_documento_modulo->idtipo_documento->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($tipo_documento_modulo->idtipo_documento->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento->CurrentValue) ?>" selected><?php echo $tipo_documento_modulo->idtipo_documento->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idtipo_documento`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_documento`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$tipo_documento_modulo->idtipo_documento->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$tipo_documento_modulo->idtipo_documento->LookupFilters += array("f0" => "`idtipo_documento` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idtipo_documento, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $tipo_documento_modulo->idtipo_documento->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idtipo_documento" id="s_x_idtipo_documento" value="<?php echo $tipo_documento_modulo->idtipo_documento->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $tipo_documento_modulo->idtipo_documento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tipo_documento_modulo->idmodulo->Visible) { // idmodulo ?>
	<div id="r_idmodulo" class="form-group">
		<label id="elh_tipo_documento_modulo_idmodulo" for="x_idmodulo" class="col-sm-2 control-label ewLabel"><?php echo $tipo_documento_modulo->idmodulo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $tipo_documento_modulo->idmodulo->CellAttributes() ?>>
<?php if ($tipo_documento_modulo->idmodulo->getSessionValue() <> "") { ?>
<span id="el_tipo_documento_modulo_idmodulo">
<span<?php echo $tipo_documento_modulo->idmodulo->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $tipo_documento_modulo->idmodulo->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idmodulo" name="x_idmodulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->CurrentValue) ?>">
<?php } else { ?>
<span id="el_tipo_documento_modulo_idmodulo">
<select data-table="tipo_documento_modulo" data-field="x_idmodulo" data-value-separator="<?php echo ew_HtmlEncode(is_array($tipo_documento_modulo->idmodulo->DisplayValueSeparator) ? json_encode($tipo_documento_modulo->idmodulo->DisplayValueSeparator) : $tipo_documento_modulo->idmodulo->DisplayValueSeparator) ?>" id="x_idmodulo" name="x_idmodulo"<?php echo $tipo_documento_modulo->idmodulo->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->idmodulo->EditValue)) {
	$arwrk = $tipo_documento_modulo->idmodulo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($tipo_documento_modulo->idmodulo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $tipo_documento_modulo->idmodulo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($tipo_documento_modulo->idmodulo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idmodulo->CurrentValue) ?>" selected><?php echo $tipo_documento_modulo->idmodulo->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idmodulo`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `modulo`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$tipo_documento_modulo->idmodulo->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$tipo_documento_modulo->idmodulo->LookupFilters += array("f0" => "`idmodulo` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$tipo_documento_modulo->Lookup_Selecting($tipo_documento_modulo->idmodulo, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $tipo_documento_modulo->idmodulo->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idmodulo" id="s_x_idmodulo" value="<?php echo $tipo_documento_modulo->idmodulo->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $tipo_documento_modulo->idmodulo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($tipo_documento_modulo->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_tipo_documento_modulo_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $tipo_documento_modulo->estado->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $tipo_documento_modulo->estado->CellAttributes() ?>>
<span id="el_tipo_documento_modulo_estado">
<select data-table="tipo_documento_modulo" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($tipo_documento_modulo->estado->DisplayValueSeparator) ? json_encode($tipo_documento_modulo->estado->DisplayValueSeparator) : $tipo_documento_modulo->estado->DisplayValueSeparator) ?>" id="x_estado" name="x_estado"<?php echo $tipo_documento_modulo->estado->EditAttributes() ?>>
<?php
if (is_array($tipo_documento_modulo->estado->EditValue)) {
	$arwrk = $tipo_documento_modulo->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($tipo_documento_modulo->estado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $tipo_documento_modulo->estado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($tipo_documento_modulo->estado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($tipo_documento_modulo->estado->CurrentValue) ?>" selected><?php echo $tipo_documento_modulo->estado->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $tipo_documento_modulo->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-table="tipo_documento_modulo" data-field="x_idtipo_documento_modulo" name="x_idtipo_documento_modulo" id="x_idtipo_documento_modulo" value="<?php echo ew_HtmlEncode($tipo_documento_modulo->idtipo_documento_modulo->CurrentValue) ?>">
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $tipo_documento_modulo_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
ftipo_documento_moduloedit.Init();
</script>
<?php
$tipo_documento_modulo_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$tipo_documento_modulo_edit->Page_Terminate();
?>
