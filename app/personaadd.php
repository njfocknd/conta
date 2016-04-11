<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "personainfo.php" ?>
<?php include_once "paisinfo.php" ?>
<?php include_once "clientegridcls.php" ?>
<?php include_once "empleadogridcls.php" ?>
<?php include_once "proveedorgridcls.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$persona_add = NULL; // Initialize page object first

class cpersona_add extends cpersona {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'persona';

	// Page object name
	var $PageObjName = 'persona_add';

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

		// Table object (persona)
		if (!isset($GLOBALS["persona"]) || get_class($GLOBALS["persona"]) == "cpersona") {
			$GLOBALS["persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persona"];
		}

		// Table object (pais)
		if (!isset($GLOBALS['pais'])) $GLOBALS['pais'] = new cpais();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persona', TRUE);

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

			// Process auto fill for detail table 'cliente'
			if (@$_POST["grid"] == "fclientegrid") {
				if (!isset($GLOBALS["cliente_grid"])) $GLOBALS["cliente_grid"] = new ccliente_grid;
				$GLOBALS["cliente_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'empleado'
			if (@$_POST["grid"] == "fempleadogrid") {
				if (!isset($GLOBALS["empleado_grid"])) $GLOBALS["empleado_grid"] = new cempleado_grid;
				$GLOBALS["empleado_grid"]->Page_Init();
				$this->Page_Terminate();
				exit();
			}

			// Process auto fill for detail table 'proveedor'
			if (@$_POST["grid"] == "fproveedorgrid") {
				if (!isset($GLOBALS["proveedor_grid"])) $GLOBALS["proveedor_grid"] = new cproveedor_grid;
				$GLOBALS["proveedor_grid"]->Page_Init();
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
		global $EW_EXPORT, $persona;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($persona);
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
			if (@$_GET["idpersona"] != "") {
				$this->idpersona->setQueryStringValue($_GET["idpersona"]);
				$this->setKey("idpersona", $this->idpersona->CurrentValue); // Set up key
			} else {
				$this->setKey("idpersona", ""); // Clear key
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
					$this->Page_Terminate("personalist.php"); // No matching record, return to list
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
					if (ew_GetPageName($sReturnUrl) == "personalist.php")
						$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
					elseif (ew_GetPageName($sReturnUrl) == "personaview.php")
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
		$this->tipo_persona->CurrentValue = "Individual";
		$this->nombre->CurrentValue = NULL;
		$this->nombre->OldValue = $this->nombre->CurrentValue;
		$this->apellido->CurrentValue = NULL;
		$this->apellido->OldValue = $this->apellido->CurrentValue;
		$this->direccion->CurrentValue = NULL;
		$this->direccion->OldValue = $this->direccion->CurrentValue;
		$this->cui->CurrentValue = NULL;
		$this->cui->OldValue = $this->cui->CurrentValue;
		$this->idpais->CurrentValue = 1;
		$this->fecha_nacimiento->CurrentValue = NULL;
		$this->fecha_nacimiento->OldValue = $this->fecha_nacimiento->CurrentValue;
		$this->_email->CurrentValue = NULL;
		$this->_email->OldValue = $this->_email->CurrentValue;
		$this->sexo->CurrentValue = "Masculino";
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->tipo_persona->FldIsDetailKey) {
			$this->tipo_persona->setFormValue($objForm->GetValue("x_tipo_persona"));
		}
		if (!$this->nombre->FldIsDetailKey) {
			$this->nombre->setFormValue($objForm->GetValue("x_nombre"));
		}
		if (!$this->apellido->FldIsDetailKey) {
			$this->apellido->setFormValue($objForm->GetValue("x_apellido"));
		}
		if (!$this->direccion->FldIsDetailKey) {
			$this->direccion->setFormValue($objForm->GetValue("x_direccion"));
		}
		if (!$this->cui->FldIsDetailKey) {
			$this->cui->setFormValue($objForm->GetValue("x_cui"));
		}
		if (!$this->idpais->FldIsDetailKey) {
			$this->idpais->setFormValue($objForm->GetValue("x_idpais"));
		}
		if (!$this->fecha_nacimiento->FldIsDetailKey) {
			$this->fecha_nacimiento->setFormValue($objForm->GetValue("x_fecha_nacimiento"));
			$this->fecha_nacimiento->CurrentValue = ew_UnFormatDateTime($this->fecha_nacimiento->CurrentValue, 7);
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->sexo->FldIsDetailKey) {
			$this->sexo->setFormValue($objForm->GetValue("x_sexo"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->tipo_persona->CurrentValue = $this->tipo_persona->FormValue;
		$this->nombre->CurrentValue = $this->nombre->FormValue;
		$this->apellido->CurrentValue = $this->apellido->FormValue;
		$this->direccion->CurrentValue = $this->direccion->FormValue;
		$this->cui->CurrentValue = $this->cui->FormValue;
		$this->idpais->CurrentValue = $this->idpais->FormValue;
		$this->fecha_nacimiento->CurrentValue = $this->fecha_nacimiento->FormValue;
		$this->fecha_nacimiento->CurrentValue = ew_UnFormatDateTime($this->fecha_nacimiento->CurrentValue, 7);
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->sexo->CurrentValue = $this->sexo->FormValue;
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
		$this->idpersona->setDbValue($rs->fields('idpersona'));
		$this->tipo_persona->setDbValue($rs->fields('tipo_persona'));
		$this->nombre->setDbValue($rs->fields('nombre'));
		$this->apellido->setDbValue($rs->fields('apellido'));
		$this->direccion->setDbValue($rs->fields('direccion'));
		$this->cui->setDbValue($rs->fields('cui'));
		$this->idpais->setDbValue($rs->fields('idpais'));
		$this->fecha_nacimiento->setDbValue($rs->fields('fecha_nacimiento'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->sexo->setDbValue($rs->fields('sexo'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idpersona->DbValue = $row['idpersona'];
		$this->tipo_persona->DbValue = $row['tipo_persona'];
		$this->nombre->DbValue = $row['nombre'];
		$this->apellido->DbValue = $row['apellido'];
		$this->direccion->DbValue = $row['direccion'];
		$this->cui->DbValue = $row['cui'];
		$this->idpais->DbValue = $row['idpais'];
		$this->fecha_nacimiento->DbValue = $row['fecha_nacimiento'];
		$this->_email->DbValue = $row['email'];
		$this->sexo->DbValue = $row['sexo'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->estado->DbValue = $row['estado'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("idpersona")) <> "")
			$this->idpersona->CurrentValue = $this->getKey("idpersona"); // idpersona
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
		// idpersona
		// tipo_persona
		// nombre
		// apellido
		// direccion
		// cui
		// idpais
		// fecha_nacimiento
		// email
		// sexo
		// fecha_insercion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idpersona
		$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
		$this->idpersona->ViewCustomAttributes = "";

		// tipo_persona
		if (strval($this->tipo_persona->CurrentValue) <> "") {
			$this->tipo_persona->ViewValue = $this->tipo_persona->OptionCaption($this->tipo_persona->CurrentValue);
		} else {
			$this->tipo_persona->ViewValue = NULL;
		}
		$this->tipo_persona->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// apellido
		$this->apellido->ViewValue = $this->apellido->CurrentValue;
		$this->apellido->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

		// cui
		$this->cui->ViewValue = $this->cui->CurrentValue;
		$this->cui->ViewCustomAttributes = "";

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

		// fecha_nacimiento
		$this->fecha_nacimiento->ViewValue = $this->fecha_nacimiento->CurrentValue;
		$this->fecha_nacimiento->ViewValue = ew_FormatDateTime($this->fecha_nacimiento->ViewValue, 7);
		$this->fecha_nacimiento->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// sexo
		if (strval($this->sexo->CurrentValue) <> "") {
			$this->sexo->ViewValue = $this->sexo->OptionCaption($this->sexo->CurrentValue);
		} else {
			$this->sexo->ViewValue = NULL;
		}
		$this->sexo->ViewCustomAttributes = "";

		// fecha_insercion
		$this->fecha_insercion->ViewValue = $this->fecha_insercion->CurrentValue;
		$this->fecha_insercion->ViewValue = ew_FormatDateTime($this->fecha_insercion->ViewValue, 7);
		$this->fecha_insercion->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

			// tipo_persona
			$this->tipo_persona->LinkCustomAttributes = "";
			$this->tipo_persona->HrefValue = "";
			$this->tipo_persona->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";
			$this->apellido->TooltipValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";
			$this->direccion->TooltipValue = "";

			// cui
			$this->cui->LinkCustomAttributes = "";
			$this->cui->HrefValue = "";
			$this->cui->TooltipValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";
			$this->idpais->TooltipValue = "";

			// fecha_nacimiento
			$this->fecha_nacimiento->LinkCustomAttributes = "";
			$this->fecha_nacimiento->HrefValue = "";
			$this->fecha_nacimiento->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// sexo
			$this->sexo->LinkCustomAttributes = "";
			$this->sexo->HrefValue = "";
			$this->sexo->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// tipo_persona
			$this->tipo_persona->EditAttrs["class"] = "form-control";
			$this->tipo_persona->EditCustomAttributes = "";
			$this->tipo_persona->EditValue = $this->tipo_persona->Options(TRUE);

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->CurrentValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// apellido
			$this->apellido->EditAttrs["class"] = "form-control";
			$this->apellido->EditCustomAttributes = "";
			$this->apellido->EditValue = ew_HtmlEncode($this->apellido->CurrentValue);
			$this->apellido->PlaceHolder = ew_RemoveHtml($this->apellido->FldCaption());

			// direccion
			$this->direccion->EditAttrs["class"] = "form-control";
			$this->direccion->EditCustomAttributes = "";
			$this->direccion->EditValue = ew_HtmlEncode($this->direccion->CurrentValue);
			$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

			// cui
			$this->cui->EditAttrs["class"] = "form-control";
			$this->cui->EditCustomAttributes = "";
			$this->cui->EditValue = ew_HtmlEncode($this->cui->CurrentValue);
			$this->cui->PlaceHolder = ew_RemoveHtml($this->cui->FldCaption());

			// idpais
			$this->idpais->EditAttrs["class"] = "form-control";
			$this->idpais->EditCustomAttributes = "";
			if ($this->idpais->getSessionValue() <> "") {
				$this->idpais->CurrentValue = $this->idpais->getSessionValue();
			if (strval($this->idpais->CurrentValue) <> "") {
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpais, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
			} else {
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
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpais->EditValue = $arwrk;
			}

			// fecha_nacimiento
			$this->fecha_nacimiento->EditAttrs["class"] = "form-control";
			$this->fecha_nacimiento->EditCustomAttributes = "";
			$this->fecha_nacimiento->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha_nacimiento->CurrentValue, 7));
			$this->fecha_nacimiento->PlaceHolder = ew_RemoveHtml($this->fecha_nacimiento->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// sexo
			$this->sexo->EditAttrs["class"] = "form-control";
			$this->sexo->EditCustomAttributes = "";
			$this->sexo->EditValue = $this->sexo->Options(TRUE);

			// Add refer script
			// tipo_persona

			$this->tipo_persona->LinkCustomAttributes = "";
			$this->tipo_persona->HrefValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";

			// apellido
			$this->apellido->LinkCustomAttributes = "";
			$this->apellido->HrefValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";

			// cui
			$this->cui->LinkCustomAttributes = "";
			$this->cui->HrefValue = "";

			// idpais
			$this->idpais->LinkCustomAttributes = "";
			$this->idpais->HrefValue = "";

			// fecha_nacimiento
			$this->fecha_nacimiento->LinkCustomAttributes = "";
			$this->fecha_nacimiento->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// sexo
			$this->sexo->LinkCustomAttributes = "";
			$this->sexo->HrefValue = "";
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
		if (!$this->tipo_persona->FldIsDetailKey && !is_null($this->tipo_persona->FormValue) && $this->tipo_persona->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->tipo_persona->FldCaption(), $this->tipo_persona->ReqErrMsg));
		}
		if (!$this->idpais->FldIsDetailKey && !is_null($this->idpais->FormValue) && $this->idpais->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->idpais->FldCaption(), $this->idpais->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->fecha_nacimiento->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha_nacimiento->FldErrMsg());
		}
		if (!$this->sexo->FldIsDetailKey && !is_null($this->sexo->FormValue) && $this->sexo->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->sexo->FldCaption(), $this->sexo->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cliente", $DetailTblVar) && $GLOBALS["cliente"]->DetailAdd) {
			if (!isset($GLOBALS["cliente_grid"])) $GLOBALS["cliente_grid"] = new ccliente_grid(); // get detail page object
			$GLOBALS["cliente_grid"]->ValidateGridForm();
		}
		if (in_array("empleado", $DetailTblVar) && $GLOBALS["empleado"]->DetailAdd) {
			if (!isset($GLOBALS["empleado_grid"])) $GLOBALS["empleado_grid"] = new cempleado_grid(); // get detail page object
			$GLOBALS["empleado_grid"]->ValidateGridForm();
		}
		if (in_array("proveedor", $DetailTblVar) && $GLOBALS["proveedor"]->DetailAdd) {
			if (!isset($GLOBALS["proveedor_grid"])) $GLOBALS["proveedor_grid"] = new cproveedor_grid(); // get detail page object
			$GLOBALS["proveedor_grid"]->ValidateGridForm();
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

		// tipo_persona
		$this->tipo_persona->SetDbValueDef($rsnew, $this->tipo_persona->CurrentValue, "", strval($this->tipo_persona->CurrentValue) == "");

		// nombre
		$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, FALSE);

		// apellido
		$this->apellido->SetDbValueDef($rsnew, $this->apellido->CurrentValue, NULL, FALSE);

		// direccion
		$this->direccion->SetDbValueDef($rsnew, $this->direccion->CurrentValue, NULL, FALSE);

		// cui
		$this->cui->SetDbValueDef($rsnew, $this->cui->CurrentValue, NULL, FALSE);

		// idpais
		$this->idpais->SetDbValueDef($rsnew, $this->idpais->CurrentValue, 0, strval($this->idpais->CurrentValue) == "");

		// fecha_nacimiento
		$this->fecha_nacimiento->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_nacimiento->CurrentValue, 7), NULL, FALSE);

		// email
		$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, FALSE);

		// sexo
		$this->sexo->SetDbValueDef($rsnew, $this->sexo->CurrentValue, "", strval($this->sexo->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {

				// Get insert id if necessary
				$this->idpersona->setDbValue($conn->Insert_ID());
				$rsnew['idpersona'] = $this->idpersona->DbValue;
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
			if (in_array("cliente", $DetailTblVar) && $GLOBALS["cliente"]->DetailAdd) {
				$GLOBALS["cliente"]->idpersona->setSessionValue($this->idpersona->CurrentValue); // Set master key
				if (!isset($GLOBALS["cliente_grid"])) $GLOBALS["cliente_grid"] = new ccliente_grid(); // Get detail page object
				$AddRow = $GLOBALS["cliente_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["cliente"]->idpersona->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("empleado", $DetailTblVar) && $GLOBALS["empleado"]->DetailAdd) {
				$GLOBALS["empleado"]->idpersona->setSessionValue($this->idpersona->CurrentValue); // Set master key
				if (!isset($GLOBALS["empleado_grid"])) $GLOBALS["empleado_grid"] = new cempleado_grid(); // Get detail page object
				$AddRow = $GLOBALS["empleado_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["empleado"]->idpersona->setSessionValue(""); // Clear master key if insert failed
			}
			if (in_array("proveedor", $DetailTblVar) && $GLOBALS["proveedor"]->DetailAdd) {
				$GLOBALS["proveedor"]->idpersona->setSessionValue($this->idpersona->CurrentValue); // Set master key
				if (!isset($GLOBALS["proveedor_grid"])) $GLOBALS["proveedor_grid"] = new cproveedor_grid(); // Get detail page object
				$AddRow = $GLOBALS["proveedor_grid"]->GridInsert();
				if (!$AddRow)
					$GLOBALS["proveedor"]->idpersona->setSessionValue(""); // Clear master key if insert failed
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
			if ($sMasterTblVar == "pais") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idpais"] <> "") {
					$GLOBALS["pais"]->idpais->setQueryStringValue($_GET["fk_idpais"]);
					$this->idpais->setQueryStringValue($GLOBALS["pais"]->idpais->QueryStringValue);
					$this->idpais->setSessionValue($this->idpais->QueryStringValue);
					if (!is_numeric($GLOBALS["pais"]->idpais->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "pais") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idpais"] <> "") {
					$GLOBALS["pais"]->idpais->setFormValue($_POST["fk_idpais"]);
					$this->idpais->setFormValue($GLOBALS["pais"]->idpais->FormValue);
					$this->idpais->setSessionValue($this->idpais->FormValue);
					if (!is_numeric($GLOBALS["pais"]->idpais->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "pais") {
				if ($this->idpais->CurrentValue == "") $this->idpais->setSessionValue("");
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
			if (in_array("cliente", $DetailTblVar)) {
				if (!isset($GLOBALS["cliente_grid"]))
					$GLOBALS["cliente_grid"] = new ccliente_grid;
				if ($GLOBALS["cliente_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["cliente_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["cliente_grid"]->CurrentMode = "add";
					$GLOBALS["cliente_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["cliente_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["cliente_grid"]->setStartRecordNumber(1);
					$GLOBALS["cliente_grid"]->idpersona->FldIsDetailKey = TRUE;
					$GLOBALS["cliente_grid"]->idpersona->CurrentValue = $this->idpersona->CurrentValue;
					$GLOBALS["cliente_grid"]->idpersona->setSessionValue($GLOBALS["cliente_grid"]->idpersona->CurrentValue);
				}
			}
			if (in_array("empleado", $DetailTblVar)) {
				if (!isset($GLOBALS["empleado_grid"]))
					$GLOBALS["empleado_grid"] = new cempleado_grid;
				if ($GLOBALS["empleado_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["empleado_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["empleado_grid"]->CurrentMode = "add";
					$GLOBALS["empleado_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["empleado_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["empleado_grid"]->setStartRecordNumber(1);
					$GLOBALS["empleado_grid"]->idpersona->FldIsDetailKey = TRUE;
					$GLOBALS["empleado_grid"]->idpersona->CurrentValue = $this->idpersona->CurrentValue;
					$GLOBALS["empleado_grid"]->idpersona->setSessionValue($GLOBALS["empleado_grid"]->idpersona->CurrentValue);
				}
			}
			if (in_array("proveedor", $DetailTblVar)) {
				if (!isset($GLOBALS["proveedor_grid"]))
					$GLOBALS["proveedor_grid"] = new cproveedor_grid;
				if ($GLOBALS["proveedor_grid"]->DetailAdd) {
					if ($this->CopyRecord)
						$GLOBALS["proveedor_grid"]->CurrentMode = "copy";
					else
						$GLOBALS["proveedor_grid"]->CurrentMode = "add";
					$GLOBALS["proveedor_grid"]->CurrentAction = "gridadd";

					// Save current master table to detail table
					$GLOBALS["proveedor_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["proveedor_grid"]->setStartRecordNumber(1);
					$GLOBALS["proveedor_grid"]->idpersona->FldIsDetailKey = TRUE;
					$GLOBALS["proveedor_grid"]->idpersona->CurrentValue = $this->idpersona->CurrentValue;
					$GLOBALS["proveedor_grid"]->idpersona->setSessionValue($GLOBALS["proveedor_grid"]->idpersona->CurrentValue);
				}
			}
		}
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("personalist.php"), "", $this->TableVar, TRUE);
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
if (!isset($persona_add)) $persona_add = new cpersona_add();

// Page init
$persona_add->Page_Init();

// Page main
$persona_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persona_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "add";
var CurrentForm = fpersonaadd = new ew_Form("fpersonaadd", "add");

// Validate form
fpersonaadd.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_tipo_persona");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $persona->tipo_persona->FldCaption(), $persona->tipo_persona->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_idpais");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $persona->idpais->FldCaption(), $persona->idpais->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_fecha_nacimiento");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($persona->fecha_nacimiento->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_sexo");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $persona->sexo->FldCaption(), $persona->sexo->ReqErrMsg)) ?>");

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
fpersonaadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonaadd.ValidateRequired = true;
<?php } else { ?>
fpersonaadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonaadd.Lists["x_tipo_persona"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonaadd.Lists["x_tipo_persona"].Options = <?php echo json_encode($persona->tipo_persona->Options()) ?>;
fpersonaadd.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonaadd.Lists["x_sexo"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpersonaadd.Lists["x_sexo"].Options = <?php echo json_encode($persona->sexo->Options()) ?>;

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
<?php $persona_add->ShowPageHeader(); ?>
<?php
$persona_add->ShowMessage();
?>
<form name="fpersonaadd" id="fpersonaadd" class="<?php echo $persona_add->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($persona_add->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $persona_add->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="persona">
<input type="hidden" name="a_add" id="a_add" value="A">
<?php if ($persona->getCurrentMasterTable() == "pais") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="pais">
<input type="hidden" name="fk_idpais" value="<?php echo $persona->idpais->getSessionValue() ?>">
<?php } ?>
<div>
<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
	<div id="r_tipo_persona" class="form-group">
		<label id="elh_persona_tipo_persona" for="x_tipo_persona" class="col-sm-2 control-label ewLabel"><?php echo $persona->tipo_persona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->tipo_persona->CellAttributes() ?>>
<span id="el_persona_tipo_persona">
<select data-table="persona" data-field="x_tipo_persona" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->tipo_persona->DisplayValueSeparator) ? json_encode($persona->tipo_persona->DisplayValueSeparator) : $persona->tipo_persona->DisplayValueSeparator) ?>" id="x_tipo_persona" name="x_tipo_persona"<?php echo $persona->tipo_persona->EditAttributes() ?>>
<?php
if (is_array($persona->tipo_persona->EditValue)) {
	$arwrk = $persona->tipo_persona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->tipo_persona->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->tipo_persona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->tipo_persona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->tipo_persona->CurrentValue) ?>" selected><?php echo $persona->tipo_persona->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $persona->tipo_persona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_persona_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $persona->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->nombre->CellAttributes() ?>>
<span id="el_persona_nombre">
<input type="text" data-table="persona" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->nombre->getPlaceHolder()) ?>" value="<?php echo $persona->nombre->EditValue ?>"<?php echo $persona->nombre->EditAttributes() ?>>
</span>
<?php echo $persona->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->apellido->Visible) { // apellido ?>
	<div id="r_apellido" class="form-group">
		<label id="elh_persona_apellido" for="x_apellido" class="col-sm-2 control-label ewLabel"><?php echo $persona->apellido->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->apellido->CellAttributes() ?>>
<span id="el_persona_apellido">
<input type="text" data-table="persona" data-field="x_apellido" name="x_apellido" id="x_apellido" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->apellido->getPlaceHolder()) ?>" value="<?php echo $persona->apellido->EditValue ?>"<?php echo $persona->apellido->EditAttributes() ?>>
</span>
<?php echo $persona->apellido->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->direccion->Visible) { // direccion ?>
	<div id="r_direccion" class="form-group">
		<label id="elh_persona_direccion" for="x_direccion" class="col-sm-2 control-label ewLabel"><?php echo $persona->direccion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->direccion->CellAttributes() ?>>
<span id="el_persona_direccion">
<input type="text" data-table="persona" data-field="x_direccion" name="x_direccion" id="x_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->direccion->getPlaceHolder()) ?>" value="<?php echo $persona->direccion->EditValue ?>"<?php echo $persona->direccion->EditAttributes() ?>>
</span>
<?php echo $persona->direccion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->cui->Visible) { // cui ?>
	<div id="r_cui" class="form-group">
		<label id="elh_persona_cui" for="x_cui" class="col-sm-2 control-label ewLabel"><?php echo $persona->cui->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->cui->CellAttributes() ?>>
<span id="el_persona_cui">
<input type="text" data-table="persona" data-field="x_cui" name="x_cui" id="x_cui" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->cui->getPlaceHolder()) ?>" value="<?php echo $persona->cui->EditValue ?>"<?php echo $persona->cui->EditAttributes() ?>>
</span>
<?php echo $persona->cui->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->idpais->Visible) { // idpais ?>
	<div id="r_idpais" class="form-group">
		<label id="elh_persona_idpais" for="x_idpais" class="col-sm-2 control-label ewLabel"><?php echo $persona->idpais->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->idpais->CellAttributes() ?>>
<?php if ($persona->idpais->getSessionValue() <> "") { ?>
<span id="el_persona_idpais">
<span<?php echo $persona->idpais->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $persona->idpais->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_idpais" name="x_idpais" value="<?php echo ew_HtmlEncode($persona->idpais->CurrentValue) ?>">
<?php } else { ?>
<span id="el_persona_idpais">
<select data-table="persona" data-field="x_idpais" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->idpais->DisplayValueSeparator) ? json_encode($persona->idpais->DisplayValueSeparator) : $persona->idpais->DisplayValueSeparator) ?>" id="x_idpais" name="x_idpais"<?php echo $persona->idpais->EditAttributes() ?>>
<?php
if (is_array($persona->idpais->EditValue)) {
	$arwrk = $persona->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->idpais->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->idpais->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->idpais->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->idpais->CurrentValue) ?>" selected><?php echo $persona->idpais->CurrentValue ?></option>
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
$persona->idpais->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$persona->idpais->LookupFilters += array("f0" => "`idpais` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$persona->Lookup_Selecting($persona->idpais, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $persona->idpais->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idpais" id="s_x_idpais" value="<?php echo $persona->idpais->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php echo $persona->idpais->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->fecha_nacimiento->Visible) { // fecha_nacimiento ?>
	<div id="r_fecha_nacimiento" class="form-group">
		<label id="elh_persona_fecha_nacimiento" for="x_fecha_nacimiento" class="col-sm-2 control-label ewLabel"><?php echo $persona->fecha_nacimiento->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->fecha_nacimiento->CellAttributes() ?>>
<span id="el_persona_fecha_nacimiento">
<input type="text" data-table="persona" data-field="x_fecha_nacimiento" data-format="7" name="x_fecha_nacimiento" id="x_fecha_nacimiento" placeholder="<?php echo ew_HtmlEncode($persona->fecha_nacimiento->getPlaceHolder()) ?>" value="<?php echo $persona->fecha_nacimiento->EditValue ?>"<?php echo $persona->fecha_nacimiento->EditAttributes() ?>>
<?php if (!$persona->fecha_nacimiento->ReadOnly && !$persona->fecha_nacimiento->Disabled && !isset($persona->fecha_nacimiento->EditAttrs["readonly"]) && !isset($persona->fecha_nacimiento->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fpersonaadd", "x_fecha_nacimiento", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $persona->fecha_nacimiento->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_persona__email" for="x__email" class="col-sm-2 control-label ewLabel"><?php echo $persona->_email->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->_email->CellAttributes() ?>>
<span id="el_persona__email">
<input type="text" data-table="persona" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->_email->getPlaceHolder()) ?>" value="<?php echo $persona->_email->EditValue ?>"<?php echo $persona->_email->EditAttributes() ?>>
</span>
<?php echo $persona->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->sexo->Visible) { // sexo ?>
	<div id="r_sexo" class="form-group">
		<label id="elh_persona_sexo" for="x_sexo" class="col-sm-2 control-label ewLabel"><?php echo $persona->sexo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->sexo->CellAttributes() ?>>
<span id="el_persona_sexo">
<select data-table="persona" data-field="x_sexo" data-value-separator="<?php echo ew_HtmlEncode(is_array($persona->sexo->DisplayValueSeparator) ? json_encode($persona->sexo->DisplayValueSeparator) : $persona->sexo->DisplayValueSeparator) ?>" id="x_sexo" name="x_sexo"<?php echo $persona->sexo->EditAttributes() ?>>
<?php
if (is_array($persona->sexo->EditValue)) {
	$arwrk = $persona->sexo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($persona->sexo->CurrentValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $persona->sexo->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($persona->sexo->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($persona->sexo->CurrentValue) ?>" selected><?php echo $persona->sexo->CurrentValue ?></option>
<?php
    }
}
?>
</select>
</span>
<?php echo $persona->sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php
	if (in_array("cliente", explode(",", $persona->getCurrentDetailTable())) && $cliente->DetailAdd) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "clientegrid.php" ?>
<?php } ?>
<?php
	if (in_array("empleado", explode(",", $persona->getCurrentDetailTable())) && $empleado->DetailAdd) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("empleado", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "empleadogrid.php" ?>
<?php } ?>
<?php
	if (in_array("proveedor", explode(",", $persona->getCurrentDetailTable())) && $proveedor->DetailAdd) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("proveedor", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "proveedorgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $persona_add->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpersonaadd.Init();
</script>
<?php
$persona_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$persona_add->Page_Terminate();
?>
