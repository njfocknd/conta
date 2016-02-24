<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "grupo_cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "clase_cuentainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "subgrupo_cuentagridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$grupo_cuenta_add = NULL; // Initialize page object first

class cgrupo_cuenta_add extends cgrupo_cuenta {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'grupo_cuenta';

	// Page object name
	var $PageObjName = 'grupo_cuenta_add';

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

		// Table object (grupo_cuenta)
		if (!isset($GLOBALS["grupo_cuenta"]) || get_class($GLOBALS["grupo_cuenta"]) == "cgrupo_cuenta") {
			$GLOBALS["grupo_cuenta"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["grupo_cuenta"];
		}

		// Table object (clase_cuenta)
		if (!isset($GLOBALS['clase_cuenta'])) $GLOBALS['clase_cuenta'] = new cclase_cuenta();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'grupo_cuenta', TRUE);

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

			// Process auto fill for detail table 'subgrupo_cuenta'
			if (@$_POST["grid"] == "fsubgrupo_cuentagrid") {
				if (!isset($GLOBALS["subgrupo_cuenta_grid"])) $GLOBALS["subgrupo_cuenta_grid"] = new csubgrupo_cuenta_grid;
				$GLOBALS["subgrupo_cuenta_grid"]->Page_Init();
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
		global $EW_EXPORT, $grupo_cuenta;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($grupo_cuenta);
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
			if (@$_GET["idgrupo_cuenta"] != "") {
				$this->idgrupo_cuenta->setQueryStringValue($_GET["idgrupo_cuenta"]);
				$this->setKey("idgrupo_cuenta", $this->idgrupo_cuenta->CurrentValue); // Set up key
			} else {
				$this->setKey("idgrupo_cuenta", ""); // Clear key
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
					$this->Page_Terminate("grupo_cuentalist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "grupo_cuentaview.php")
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
		$this->nomeclatura->CurrentValue = NULL;
		$this->nomeclatura->OldValue = $this->nomeclatura->CurrentValue;
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->idclase_cuenta->CurrentValue = NULL;
		$this->idclase_cuenta->OldValue = $this->idclase_cuenta->CurrentValue;
		$this->definicion->CurrentValue = NULL;
		$this->definicion->OldValue = $this->definicion->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->nomeclatura->FldIsDetailKey) {
			$this->nomeclatura->setFormValue($objForm->GetValue("x_nomeclatura"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->idclase_cuenta->FldIsDetailKey) {
			$this->idclase_cuenta->setFormValue($objForm->GetValue("x_idclase_cuenta"));
		}
		if (!$this->definicion->FldIsDetailKey) {
			$this->definicion->setFormValue($objForm->GetValue("x_definicion"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->nomeclatura->CurrentValue = $this->nomeclatura->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->idclase_cuenta->CurrentValue = $this->idclase_cuenta->FormValue;
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
		$this->idgrupo_cuenta->setDbValue($rs->fields('idgrupo_cuenta'));
		$this->nomeclatura->setDbValue($rs->fields('nomeclatura'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->idclase_cuenta->setDbValue($rs->fields('idclase_cuenta'));
		$this->definicion->setDbValue($rs->fields('definicion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idgrupo_cuenta->DbValue = $row['idgrupo_cuenta'];
		$this->nomeclatura->DbValue = $row['nomeclatura'];
		$this->nombre->DbValue = $row['nombre'];
		$this->idclase_cuenta->DbValue = $row['idclase_cuenta'];
		$this->definicion->DbValue = $row['definicion'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idgrupo_cuenta")) <> "")
			$this->idgrupo_cuenta->CurrentValue = $this->getKey("idgrupo_cuenta"); // idgrupo_cuenta
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
		// idgrupo_cuenta
		// nomeclatura
		// nombre
		// idclase_cuenta
		// definicion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// idgrupo_cuenta
			$this->idgrupo_cuenta->ViewValue = $this->idgrupo_cuenta->CurrentValue;
			$this->idgrupo_cuenta->ViewCustomAttributes = "";

			// nomeclatura
			$this->nomeclatura->ViewValue = $this->nomeclatura->CurrentValue;
			$this->nomeclatura->ViewCustomAttributes = "";

			// nombre
			$this->nombre->ViewValue = $this->nombre->CurrentValue;
			$this->nombre->ViewCustomAttributes = "";

			// idclase_cuenta
			if (strval($this->idclase_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idclase_cuenta->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idclase_cuenta->ViewValue = $this->idclase_cuenta->CurrentValue;
				}
			} else {
				$this->idclase_cuenta->ViewValue = NULL;
			}
			$this->idclase_cuenta->ViewCustomAttributes = "";

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

			// nomeclatura
			$this->nomeclatura->LinkCustomAttributes = "";
			$this->nomeclatura->HrefValue = "";
			$this->nomeclatura->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// idclase_cuenta
			$this->idclase_cuenta->LinkCustomAttributes = "";
			$this->idclase_cuenta->HrefValue = "";
			$this->idclase_cuenta->TooltipValue = "";

			// definicion
			$this->definicion->LinkCustomAttributes = "";
			$this->definicion->HrefValue = "";
			$this->definicion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// nomeclatura
			$this->nomeclatura->EditAttrs["class"] = "form-control";
			$this->nomeclatura->EditCustomAttributes = "";
			$this->nomeclatura->EditValue = ew_HtmlEncode($this->nomeclatura->CurrentValue);
			$this->nomeclatura->PlaceHolder = ew_RemoveHtml($this->nomeclatura->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// idclase_cuenta
			$this->idclase_cuenta->EditAttrs["class"] = "form-control";
			$this->idclase_cuenta->EditCustomAttributes = "";
			if ($this->idclase_cuenta->getSessionValue() <> "") {
				$this->idclase_cuenta->CurrentValue = $this->idclase_cuenta->getSessionValue();
			if (strval($this->idclase_cuenta->CurrentValue) <> "") {
				$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idclase_cuenta->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idclase_cuenta->ViewValue = $this->idclase_cuenta->CurrentValue;
				}
			} else {
				$this->idclase_cuenta->ViewValue = NULL;
			}
			$this->idclase_cuenta->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->idclase_cuenta->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idclase_cuenta`" . ew_SearchString("=", $this->idclase_cuenta->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `clase_cuenta`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idclase_cuenta, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idclase_cuenta->EditValue = $arwrk;
			}

			// definicion
			$this->definicion->EditAttrs["class"] = "form-control";
			$this->definicion->EditCustomAttributes = "";
			$this->definicion->EditValue = ew_HtmlEncode($this->definicion->CurrentValue);
			$this->definicion->PlaceHolder = ew_RemoveHtml($this->definicion->FldCaption());

			// Edit refer script
			// nomeclatura

			$this->nomeclatura->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// idclase_cuenta
			$this->idclase_cuenta->HrefValue = "";

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
		if (!$this->nomeclatura->FldIsDetailKey && !is_null($this->nomeclatura->FormValue) && $this->nomeclatura->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nomeclatura->FldCaption(), $this->nomeclatura->ReqErrMsg));
		}
		if (!$this->nombre->FldIsDetailKey && !is_null($this->nombre->FormValue) && $this->nombre->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->nombre->FldCaption(), $this->nombre->ReqErrMsg));
		}
		if (!$this->idclase_cuenta->FldIsDetailKey && !is_null($this->idclase_cuenta->FormValue) && $this->idclase_cuenta->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idclase_cuenta->FldCaption(), $this->idclase_cuenta->ReqErrMsg));
		}
		if (!$this->definicion->FldIsDetailKey && !is_null($this->definicion->FormValue) && $this->definicion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->definicion->FldCaption(), $this->definicion->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("subgrupo_cuenta", $DetailTblVar) && $GLOBALS["subgrupo_cuenta"]->DetailAdd) {
			if (!isset($GLOBALS["subgrupo_cuenta_grid"])) $GLOBALS["subgrupo_cuenta_grid"] = new csubgrupo_cuenta_grid(); // get detail page object
			$GLOBALS["subgrupo_cuenta_grid"]->ValidateGridForm();
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

		// nomeclatura
		$this->nomeclatura->SetDbValueDef($rsnew, $this->nomeclatura->CurrentValue, "", FALSE);

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, "", FALSE);

		// idclase_cuenta
		$this->idclase_cuenta->SetDbValueDef($rsnew, $this->idclase_cuenta->CurrentValue, 0, FALSE);

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
			$this->idgrupo_cuenta->setDbValue($conn->Insert_ID());
			$rsnew['idgrupo_cuenta'] = $this->idgrupo_cuenta->DbValue;
		}

		// Add detail records
		if ($AddRow) {
			$DetailTblVar = explode(",", $this->getCurrentDetailTable());
			if (in_array("subgrupo_cuenta", $DetailTblVar) && $GLOBALS["subgrupo_cuenta"]->DetailAdd) {
				$GLOBALS["subgrupo_cuenta"]->idgrupo_cuenta->setSessionValue($this->idgrupo_cuenta->CurrentValue); // Set master key
				if (!isset($GLOBALS["subgrupo_cuenta_grid"])) $GLOBALS["subgrupo_cuenta_grid"] = new csubgrupo_cuenta_grid(); // Get detail page object
				$AddRow = $GLOBALS["subgrupo_cuenta_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["subgrupo_cuenta"]->idgrupo_cuenta->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "clase_cuenta") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idclase_cuenta"] <> "") {
					$GLOBALS["clase_cuenta"]->idclase_cuenta->setQueryStringValue($_GET["fk_idclase_cuenta"]);
					$this->idclase_cuenta->setQueryStringValue($GLOBALS["clase_cuenta"]->idclase_cuenta->QueryStringValue);
					$this->idclase_cuenta->setSessionValue($this->idclase_cuenta->QueryStringValue);
					if (!is_numeric($GLOBALS["clase_cuenta"]->idclase_cuenta->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "clase_cuenta") {
				if ($this->idclase_cuenta->QueryStringValue == "") $this->idclase_cuenta->setSessionValue("");
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
			if (in_array("subgrupo_cuenta", $DetailTblVar)) {
				if (!isset($GLOBALS["subgrupo_cuenta_grid"]))
					$GLOBALS["subgrupo_cuenta_grid"] = new csubgrupo_cuenta_grid;
				if ($GLOBALS["subgrupo_cuenta_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["subgrupo_cuenta_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["subgrupo_cuenta_grid"]->CurrentMode = "add";
					$GLOBALS["subgrupo_cuenta_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["subgrupo_cuenta_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["subgrupo_cuenta_grid"]->setStartRecordNumber(1);
					$GLOBALS["subgrupo_cuenta_grid"]->idgrupo_cuenta->FldIsDetailKey = TRUE;
					$GLOBALS["subgrupo_cuenta_grid"]->idgrupo_cuenta->CurrentValue = $this->idgrupo_cuenta->CurrentValue;
					$GLOBALS["subgrupo_cuenta_grid"]->idgrupo_cuenta->setSessionValue($GLOBALS["subgrupo_cuenta_grid"]->idgrupo_cuenta->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$Breadcrumb->Add("list", $this->TableVar, "grupo_cuentalist.php", "", $this->TableVar, TRUE);
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
if (!isset($grupo_cuenta_add)) $grupo_cuenta_add = new cgrupo_cuenta_add();

// Page init
$grupo_cuenta_add->Page_Init();

// Page main
$grupo_cuenta_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$grupo_cuenta_add->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var grupo_cuenta_add = new ew_Page("grupo_cuenta_add");
grupo_cuenta_add.PageID = "add"; // Page ID
var EW_PAGE_ID = grupo_cuenta_add.PageID; // For backward compatibility

// Form object
var fgrupo_cuentaadd = new ew_Form("fgrupo_cuentaadd");

// Validate form
fgrupo_cuentaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_nomeclatura");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nomeclatura->FldCaption(), $grupo_cuenta->nomeclatura->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_nombre");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->nombre->FldCaption(), $grupo_cuenta->nombre->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idclase_cuenta");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->idclase_cuenta->FldCaption(), $grupo_cuenta->idclase_cuenta->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_definicion");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $grupo_cuenta->definicion->FldCaption(), $grupo_cuenta->definicion->ReqErrMsg)) ?>");

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
fgrupo_cuentaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fgrupo_cuentaadd.ValidateRequired = true;
<?php } else { ?>
fgrupo_cuentaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fgrupo_cuentaadd.Lists["x_idclase_cuenta"] = {"LinkField":"x_idclase_cuenta","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $grupo_cuenta_add->ShowPageHeader(); ?>
<?php
$grupo_cuenta_add->ShowMessage();
?>
<form name="fgrupo_cuentaadd" id="fgrupo_cuentaadd" class="form-horizontal ewForm ewAddForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($grupo_cuenta_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $grupo_cuenta_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="grupo_cuenta">
<input type="hidden" name="a_add" id="a_add" value="A">
<div>
<?php if ($grupo_cuenta->nomeclatura->Visible) { // nomeclatura ?>
	<div id="r_nomeclatura" class="form-group">
		<label id="elh_grupo_cuenta_nomeclatura" for="x_nomeclatura" class="col-sm-2 control-label ewLabel"><?php echo $grupo_cuenta->nomeclatura->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $grupo_cuenta->nomeclatura->CellAttributes() ?>>
<span id="el_grupo_cuenta_nomeclatura">
<input type="text" data-field="x_nomeclatura" name="x_nomeclatura" id="x_nomeclatura" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nomeclatura->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nomeclatura->EditValue ?>"<?php echo $grupo_cuenta->nomeclatura->EditAttributes() ?>>
</span>
<?php echo $grupo_cuenta->nomeclatura->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($grupo_cuenta->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_grupo_cuenta_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $grupo_cuenta->nombre->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $grupo_cuenta->nombre->CellAttributes() ?>>
<span id="el_grupo_cuenta_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->nombre->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->nombre->EditValue ?>"<?php echo $grupo_cuenta->nombre->EditAttributes() ?>>
</span>
<?php echo $grupo_cuenta->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($grupo_cuenta->idclase_cuenta->Visible) { // idclase_cuenta ?>
	<div id="r_idclase_cuenta" class="form-group">
		<label id="elh_grupo_cuenta_idclase_cuenta" for="x_idclase_cuenta" class="col-sm-2 control-label ewLabel"><?php echo $grupo_cuenta->idclase_cuenta->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $grupo_cuenta->idclase_cuenta->CellAttributes() ?>>
<?php if ($grupo_cuenta->idclase_cuenta->getSessionValue() <> "") { ?>
<span id="el_grupo_cuenta_idclase_cuenta">
<span<?php echo $grupo_cuenta->idclase_cuenta->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $grupo_cuenta->idclase_cuenta->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idclase_cuenta" name="x_idclase_cuenta" value="<?php echo ew_HtmlEncode($grupo_cuenta->idclase_cuenta->CurrentValue) ?>">
<?php } else { ?>
<span id="el_grupo_cuenta_idclase_cuenta">
<select data-field="x_idclase_cuenta" id="x_idclase_cuenta" name="x_idclase_cuenta"<?php echo $grupo_cuenta->idclase_cuenta->EditAttributes() ?>>
<?php
if (is_array($grupo_cuenta->idclase_cuenta->EditValue)) {
	$arwrk = $grupo_cuenta->idclase_cuenta->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($grupo_cuenta->idclase_cuenta->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idclase_cuenta`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `clase_cuenta`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$grupo_cuenta->Lookup_Selecting($grupo_cuenta->idclase_cuenta, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idclase_cuenta" id="s_x_idclase_cuenta" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idclase_cuenta` = {filter_value}"); ?>&amp;t0=3">
</span>
<?php } ?>
<?php echo $grupo_cuenta->idclase_cuenta->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($grupo_cuenta->definicion->Visible) { // definicion ?>
	<div id="r_definicion" class="form-group">
		<label id="elh_grupo_cuenta_definicion" for="x_definicion" class="col-sm-2 control-label ewLabel"><?php echo $grupo_cuenta->definicion->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $grupo_cuenta->definicion->CellAttributes() ?>>
<span id="el_grupo_cuenta_definicion">
<input type="text" data-field="x_definicion" name="x_definicion" id="x_definicion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($grupo_cuenta->definicion->PlaceHolder) ?>" value="<?php echo $grupo_cuenta->definicion->EditValue ?>"<?php echo $grupo_cuenta->definicion->EditAttributes() ?>>
</span>
<?php echo $grupo_cuenta->definicion->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("subgrupo_cuenta", explode(",", $grupo_cuenta->getCurrentDetailTable())) && $subgrupo_cuenta->DetailAdd) {
?>
<?php if ($grupo_cuenta->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("subgrupo_cuenta", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "subgrupo_cuentagrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fgrupo_cuentaadd.Init();
</script>
<?php
$grupo_cuenta_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$grupo_cuenta_add->Page_Terminate();
?>