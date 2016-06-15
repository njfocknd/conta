<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "estado_resultado_detalleinfo.php" ?>
<?php include_once "estado_resultadoinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$estado_resultado_detalle_add = NULL; // Initialize page object first

class cestado_resultado_detalle_add extends cestado_resultado_detalle {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'estado_resultado_detalle';

	// Page object name
	var $PageObjName = 'estado_resultado_detalle_add';

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

		// Table object (estado_resultado_detalle)
		if (!isset($GLOBALS["estado_resultado_detalle"]) || get_class($GLOBALS["estado_resultado_detalle"]) == "cestado_resultado_detalle") {
			$GLOBALS["estado_resultado_detalle"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["estado_resultado_detalle"];
		}

		// Table object (estado_resultado)
		if (!isset($GLOBALS['estado_resultado'])) $GLOBALS['estado_resultado'] = new cestado_resultado();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'estado_resultado_detalle', TRUE);

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
		global $EW_EXPORT, $estado_resultado_detalle;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($estado_resultado_detalle);
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
			if (@$_GET["idestado_resultado_detalle"] != "") {
				$this->idestado_resultado_detalle->setQueryStringValue($_GET["idestado_resultado_detalle"]);
				$this->setKey("idestado_resultado_detalle", $this->idestado_resultado_detalle->CurrentValue); // Set up key
			} else {
				$this->setKey("idestado_resultado_detalle", ""); // Clear key
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
					$this->Page_Terminate("estado_resultado_detallelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "estado_resultado_detallelist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "estado_resultado_detalleview.php")
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
		$this->idclase_resultado->CurrentValue = 1;
		$this->idgrupo_resultado->CurrentValue = 1;
		$this->monto->CurrentValue = 0.00;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->idclase_resultado->FldIsDetailKey) {
			$this->idclase_resultado->setFormValue($objForm->GetValue("x_idclase_resultado"));
		}
		if (!$this->idgrupo_resultado->FldIsDetailKey) {
			$this->idgrupo_resultado->setFormValue($objForm->GetValue("x_idgrupo_resultado"));
		}
		if (!$this->monto->FldIsDetailKey) {
			$this->monto->setFormValue($objForm->GetValue("x_monto"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->idclase_resultado->CurrentValue = $this->idclase_resultado->FormValue;
		$this->idgrupo_resultado->CurrentValue = $this->idgrupo_resultado->FormValue;
		$this->monto->CurrentValue = $this->monto->FormValue;
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
		$this->idestado_resultado_detalle->setDbValue($rs->fields('idestado_resultado_detalle'));
		$this->idestado_resultado->setDbValue($rs->fields('idestado_resultado'));
		$this->idclase_resultado->setDbValue($rs->fields('idclase_resultado'));
		$this->idgrupo_resultado->setDbValue($rs->fields('idgrupo_resultado'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idestado_resultado_detalle->DbValue = $row['idestado_resultado_detalle'];
		$this->idestado_resultado->DbValue = $row['idestado_resultado'];
		$this->idclase_resultado->DbValue = $row['idclase_resultado'];
		$this->idgrupo_resultado->DbValue = $row['idgrupo_resultado'];
		$this->monto->DbValue = $row['monto'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idestado_resultado_detalle")) <> "")
			$this->idestado_resultado_detalle->CurrentValue = $this->getKey("idestado_resultado_detalle"); // idestado_resultado_detalle
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
		// idestado_resultado_detalle
		// idestado_resultado
		// idclase_resultado
		// idgrupo_resultado
		// monto
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idestado_resultado_detalle
		$this->idestado_resultado_detalle->ViewValue = $this->idestado_resultado_detalle->CurrentValue;
		$this->idestado_resultado_detalle->ViewCustomAttributes = "";

		// idestado_resultado
		if (strval($this->idestado_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idestado_resultado`" . ew_SearchString("=", $this->idestado_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idestado_resultado`, `idempresa` AS `DispFld`, `idperiodo_contable` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_resultado`";
		$sWhereWrk = "";
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idestado_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->idestado_resultado->ViewValue = $this->idestado_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idestado_resultado->ViewValue = $this->idestado_resultado->CurrentValue;
			}
		} else {
			$this->idestado_resultado->ViewValue = NULL;
		}
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idclase_resultado
		if (strval($this->idclase_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idclase_resultado`" . ew_SearchString("=", $this->idclase_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idclase_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idclase_resultado->ViewValue = $this->idclase_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idclase_resultado->ViewValue = $this->idclase_resultado->CurrentValue;
			}
		} else {
			$this->idclase_resultado->ViewValue = NULL;
		}
		$this->idclase_resultado->ViewCustomAttributes = "";

		// idgrupo_resultado
		if (strval($this->idgrupo_resultado->CurrentValue) <> "") {
			$sFilterWrk = "`idgrupo_resultado`" . ew_SearchString("=", $this->idgrupo_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idgrupo_resultado->ViewValue = $this->idgrupo_resultado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idgrupo_resultado->ViewValue = $this->idgrupo_resultado->CurrentValue;
			}
		} else {
			$this->idgrupo_resultado->ViewValue = NULL;
		}
		$this->idgrupo_resultado->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// idclase_resultado
			$this->idclase_resultado->LinkCustomAttributes = "";
			$this->idclase_resultado->HrefValue = "";
			$this->idclase_resultado->TooltipValue = "";

			// idgrupo_resultado
			$this->idgrupo_resultado->LinkCustomAttributes = "";
			$this->idgrupo_resultado->HrefValue = "";
			$this->idgrupo_resultado->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// idclase_resultado
			$this->idclase_resultado->EditAttrs["class"] = "form-control";
			$this->idclase_resultado->EditCustomAttributes = "";
			if (trim(strval($this->idclase_resultado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idclase_resultado`" . ew_SearchString("=", $this->idclase_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clase_resultado`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idclase_resultado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idclase_resultado->EditValue = $arwrk;

			// idgrupo_resultado
			$this->idgrupo_resultado->EditAttrs["class"] = "form-control";
			$this->idgrupo_resultado->EditCustomAttributes = "";
			if (trim(strval($this->idgrupo_resultado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idgrupo_resultado`" . ew_SearchString("=", $this->idgrupo_resultado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, `idclase_resultado` AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `grupo_resultado`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idgrupo_resultado->EditValue = $arwrk;

			// monto
			$this->monto->EditAttrs["class"] = "form-control";
			$this->monto->EditCustomAttributes = "";
			$this->monto->EditValue = ew_HtmlEncode($this->monto->CurrentValue);
			$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
			if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

			// Add refer script
			// idclase_resultado

			$this->idclase_resultado->LinkCustomAttributes = "";
			$this->idclase_resultado->HrefValue = "";

			// idgrupo_resultado
			$this->idgrupo_resultado->LinkCustomAttributes = "";
			$this->idgrupo_resultado->HrefValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
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
		if (!$this->idclase_resultado->FldIsDetailKey && !is_null($this->idclase_resultado->FormValue) && $this->idclase_resultado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idclase_resultado->FldCaption(), $this->idclase_resultado->ReqErrMsg));
		}
		if (!$this->idgrupo_resultado->FldIsDetailKey && !is_null($this->idgrupo_resultado->FormValue) && $this->idgrupo_resultado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idgrupo_resultado->FldCaption(), $this->idgrupo_resultado->ReqErrMsg));
		}
		if (!$this->monto->FldIsDetailKey && !is_null($this->monto->FormValue) && $this->monto->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->monto->FldCaption(), $this->monto->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->monto->FormValue)) {
			ew_AddMessage($gsFormError, $this->monto->FldErrMsg());
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

		// idclase_resultado
		$this->idclase_resultado->SetDbValueDef($rsnew, $this->idclase_resultado->CurrentValue, 0, strval($this->idclase_resultado->CurrentValue) == "");

		// idgrupo_resultado
		$this->idgrupo_resultado->SetDbValueDef($rsnew, $this->idgrupo_resultado->CurrentValue, 0, strval($this->idgrupo_resultado->CurrentValue) == "");

		// monto
		$this->monto->SetDbValueDef($rsnew, $this->monto->CurrentValue, 0, strval($this->monto->CurrentValue) == "");

		// idestado_resultado
		if ($this->idestado_resultado->getSessionValue() <> "") {
			$rsnew['idestado_resultado'] = $this->idestado_resultado->getSessionValue();
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idestado_resultado_detalle->setDbValue($conn->Insert_ID());
				$rsnew['idestado_resultado_detalle'] = $this->idestado_resultado_detalle->DbValue;
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
			if ($sMasterTblVar == "estado_resultado") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idestado_resultado"] <> "") {
					$GLOBALS["estado_resultado"]->idestado_resultado->setQueryStringValue($_GET["fk_idestado_resultado"]);
					$this->idestado_resultado->setQueryStringValue($GLOBALS["estado_resultado"]->idestado_resultado->QueryStringValue);
					$this->idestado_resultado->setSessionValue($this->idestado_resultado->QueryStringValue);
					if (!is_numeric($GLOBALS["estado_resultado"]->idestado_resultado->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "estado_resultado") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idestado_resultado"] <> "") {
					$GLOBALS["estado_resultado"]->idestado_resultado->setFormValue($_POST["fk_idestado_resultado"]);
					$this->idestado_resultado->setFormValue($GLOBALS["estado_resultado"]->idestado_resultado->FormValue);
					$this->idestado_resultado->setSessionValue($this->idestado_resultado->FormValue);
					if (!is_numeric($GLOBALS["estado_resultado"]->idestado_resultado->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "estado_resultado") {
				if ($this->idestado_resultado->CurrentValue == "") $this->idestado_resultado->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("estado_resultado_detallelist.php"), "", $this->TableVar, TRUE);
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
if (!isset($estado_resultado_detalle_add)) $estado_resultado_detalle_add = new cestado_resultado_detalle_add();

// Page init
$estado_resultado_detalle_add->Page_Init();

// Page main
$estado_resultado_detalle_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$estado_resultado_detalle_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = festado_resultado_detalleadd = new ew_Form("festado_resultado_detalleadd", "add");

// Validate form
festado_resultado_detalleadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_idclase_resultado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->idclase_resultado->FldCaption(), $estado_resultado_detalle->idclase_resultado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idgrupo_resultado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->idgrupo_resultado->FldCaption(), $estado_resultado_detalle->idgrupo_resultado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $estado_resultado_detalle->monto->FldCaption(), $estado_resultado_detalle->monto->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_monto");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($estado_resultado_detalle->monto->FldErrMsg()) ?>");

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
festado_resultado_detalleadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
festado_resultado_detalleadd.ValidateRequired = true;
<?php } else { ?>
festado_resultado_detalleadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
festado_resultado_detalleadd.Lists["x_idclase_resultado"] = {"LinkField":"x_idclase_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":["x_idgrupo_resultado"],"FilterFields":[],"Options":[],"Template":""};
festado_resultado_detalleadd.Lists["x_idgrupo_resultado"] = {"LinkField":"x_idgrupo_resultado","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":["x_idclase_resultado"],"ChildFields":[],"FilterFields":["x_idclase_resultado"],"Options":[],"Template":""};

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
<?php $estado_resultado_detalle_add->ShowPageHeader(); ?>
<?php
$estado_resultado_detalle_add->ShowMessage();
?>
<form name="festado_resultado_detalleadd" id="festado_resultado_detalleadd" class="<?php echo $estado_resultado_detalle_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($estado_resultado_detalle_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $estado_resultado_detalle_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="estado_resultado_detalle">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($estado_resultado_detalle->getCurrentMasterTable() == "estado_resultado") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="estado_resultado">
<input type="hidden" name="fk_idestado_resultado" value="<?php echo $estado_resultado_detalle->idestado_resultado->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($estado_resultado_detalle->idclase_resultado->Visible) { // idclase_resultado ?>
	<div id="r_idclase_resultado" class="form-group">
		<label id="elh_estado_resultado_detalle_idclase_resultado" for="x_idclase_resultado" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado_detalle->idclase_resultado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado_detalle->idclase_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idclase_resultado">
<?php $estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"] = "ew_UpdateOpt.call(this); " . @$estado_resultado_detalle->idclase_resultado->EditAttrs["onchange"]; ?>
<select data-table="estado_resultado_detalle" data-field="x_idclase_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idclase_resultado->DisplayValueSeparator) ?>" id="x_idclase_resultado" name="x_idclase_resultado"<?php echo $estado_resultado_detalle->idclase_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idclase_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idclase_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idclase_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idclase_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idclase_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idclase_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idclase_resultado->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idclase_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_resultado`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idclase_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idclase_resultado->LookupFilters += array("f0" => "`idclase_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idclase_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idclase_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idclase_resultado" id="s_x_idclase_resultado" value="<?php echo $estado_resultado_detalle->idclase_resultado->LookupFilterQuery() ?>">
</span>
<?php echo $estado_resultado_detalle->idclase_resultado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado_detalle->idgrupo_resultado->Visible) { // idgrupo_resultado ?>
	<div id="r_idgrupo_resultado" class="form-group">
		<label id="elh_estado_resultado_detalle_idgrupo_resultado" for="x_idgrupo_resultado" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado_detalle->idgrupo_resultado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado_detalle->idgrupo_resultado->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_idgrupo_resultado">
<select data-table="estado_resultado_detalle" data-field="x_idgrupo_resultado" data-value-separator="<?php echo ew_HtmlEncode(is_array($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ? json_encode($estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) : $estado_resultado_detalle->idgrupo_resultado->DisplayValueSeparator) ?>" id="x_idgrupo_resultado" name="x_idgrupo_resultado"<?php echo $estado_resultado_detalle->idgrupo_resultado->EditAttributes() ?>>
<?php
if (is_array($estado_resultado_detalle->idgrupo_resultado->EditValue)) {
	$arwrk = $estado_resultado_detalle->idgrupo_resultado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($estado_resultado_detalle->idgrupo_resultado->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $estado_resultado_detalle->idgrupo_resultado->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($estado_resultado_detalle->idgrupo_resultado->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($estado_resultado_detalle->idgrupo_resultado->CurrentValue) ?>" selected><?php echo $estado_resultado_detalle->idgrupo_resultado->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idgrupo_resultado`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `grupo_resultado`";
$sWhereWrk = "{filter}";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$estado_resultado_detalle->idgrupo_resultado->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f0" => "`idgrupo_resultado` = {filter_value}", "t0" => "3", "fn0" => "");
$estado_resultado_detalle->idgrupo_resultado->LookupFilters += array("f1" => "`idclase_resultado` IN ({filter_value})", "t1" => "3", "fn1" => "");
$sSqlWrk = "";
$estado_resultado_detalle->Lookup_Selecting($estado_resultado_detalle->idgrupo_resultado, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $estado_resultado_detalle->idgrupo_resultado->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idgrupo_resultado" id="s_x_idgrupo_resultado" value="<?php echo $estado_resultado_detalle->idgrupo_resultado->LookupFilterQuery() ?>">
</span>
<?php echo $estado_resultado_detalle->idgrupo_resultado->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($estado_resultado_detalle->monto->Visible) { // monto ?>
	<div id="r_monto" class="form-group">
		<label id="elh_estado_resultado_detalle_monto" for="x_monto" class="col-sm-2 control-label ewLabel"><?php echo $estado_resultado_detalle->monto->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $estado_resultado_detalle->monto->CellAttributes() ?>>
<span id="el_estado_resultado_detalle_monto">
<input type="text" data-table="estado_resultado_detalle" data-field="x_monto" name="x_monto" id="x_monto" size="30" placeholder="<?php echo ew_HtmlEncode($estado_resultado_detalle->monto->getPlaceHolder()) ?>" value="<?php echo $estado_resultado_detalle->monto->EditValue ?>"<?php echo $estado_resultado_detalle->monto->EditAttributes() ?>>
</span>
<?php echo $estado_resultado_detalle->monto->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (strval($estado_resultado_detalle->idestado_resultado->getSessionValue()) <> "") { ?>
<input type="hidden" name="x_idestado_resultado" id="x_idestado_resultado" value="<?php echo ew_HtmlEncode(strval($estado_resultado_detalle->idestado_resultado->getSessionValue())) ?>">
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $estado_resultado_detalle_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
festado_resultado_detalleadd.Init();
</script>
<?php
$estado_resultado_detalle_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$estado_resultado_detalle_add->Page_Terminate();
?>
