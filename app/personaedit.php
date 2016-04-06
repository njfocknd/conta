<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
$EW_RELATIVE_PATH = "";
?>
<?php include_once $EW_RELATIVE_PATH . "ewcfg11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "ewmysql11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "phpfn11.php" ?>
<?php include_once $EW_RELATIVE_PATH . "personainfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "paisinfo.php" ?>
<?php include_once $EW_RELATIVE_PATH . "clientegridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "empleadogridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "proveedorgridcls.php" ?>
<?php include_once $EW_RELATIVE_PATH . "userfn11.php" ?>
<?php

//
// Page class
//

$persona_edit = NULL; // Initialize page object first

class cpersona_edit extends cpersona {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'persona';

	// Page object name
	var $PageObjName = 'persona_edit';

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

		// Table object (persona)
		if (!isset($GLOBALS["persona"]) || get_class($GLOBALS["persona"]) == "cpersona") {
			$GLOBALS["persona"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["persona"];
		}

		// Table object (pais)
		if (!isset($GLOBALS['pais'])) $GLOBALS['pais'] = new cpais();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'persona', TRUE);

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
		global $conn, $gsExportFile, $gTmpImages;

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
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["idpersona"] <> "") {
			$this->idpersona->setQueryStringValue($_GET["idpersona"]);
		}

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		if ($this->idpersona->CurrentValue == "")
			$this->Page_Terminate("personalist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("personalist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetUpDetailParms();
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
					else
						$sReturnUrl = $this->getReturnUrl();
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
		if (!$this->estado->FldIsDetailKey) {
			$this->estado->setFormValue($objForm->GetValue("x_estado"));
		}
		if (!$this->idpersona->FldIsDetailKey)
			$this->idpersona->setFormValue($objForm->GetValue("x_idpersona"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->idpersona->CurrentValue = $this->idpersona->FormValue;
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

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
				switch ($this->tipo_persona->CurrentValue) {
					case $this->tipo_persona->FldTagValue(1):
						$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(1) <> "" ? $this->tipo_persona->FldTagCaption(1) : $this->tipo_persona->CurrentValue;
						break;
					case $this->tipo_persona->FldTagValue(2):
						$this->tipo_persona->ViewValue = $this->tipo_persona->FldTagCaption(2) <> "" ? $this->tipo_persona->FldTagCaption(2) : $this->tipo_persona->CurrentValue;
						break;
					default:
						$this->tipo_persona->ViewValue = $this->tipo_persona->CurrentValue;
				}
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
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpais->ViewValue = $rswrk->fields('DispFld');
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
				switch ($this->sexo->CurrentValue) {
					case $this->sexo->FldTagValue(1):
						$this->sexo->ViewValue = $this->sexo->FldTagCaption(1) <> "" ? $this->sexo->FldTagCaption(1) : $this->sexo->CurrentValue;
						break;
					case $this->sexo->FldTagValue(2):
						$this->sexo->ViewValue = $this->sexo->FldTagCaption(2) <> "" ? $this->sexo->FldTagCaption(2) : $this->sexo->CurrentValue;
						break;
					default:
						$this->sexo->ViewValue = $this->sexo->CurrentValue;
				}
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

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// tipo_persona
			$this->tipo_persona->EditAttrs["class"] = "form-control";
			$this->tipo_persona->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->tipo_persona->FldTagValue(1), $this->tipo_persona->FldTagCaption(1) <> "" ? $this->tipo_persona->FldTagCaption(1) : $this->tipo_persona->FldTagValue(1));
			$arwrk[] = array($this->tipo_persona->FldTagValue(2), $this->tipo_persona->FldTagCaption(2) <> "" ? $this->tipo_persona->FldTagCaption(2) : $this->tipo_persona->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->tipo_persona->EditValue = $arwrk;

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
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idpais->ViewValue = $rswrk->fields('DispFld');
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
				$sFilterWrk = "`idpais`" . ew_SearchString("=", $this->idpais->CurrentValue, EW_DATATYPE_NUMBER);
			}
			$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `pais`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			if (strval($lookuptblfilter) <> "") {
				ew_AddFilter($sWhereWrk, $lookuptblfilter);
			}
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idpais, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
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
			$arwrk = array();
			$arwrk[] = array($this->sexo->FldTagValue(1), $this->sexo->FldTagCaption(1) <> "" ? $this->sexo->FldTagCaption(1) : $this->sexo->FldTagValue(1));
			$arwrk[] = array($this->sexo->FldTagValue(2), $this->sexo->FldTagCaption(2) <> "" ? $this->sexo->FldTagCaption(2) : $this->sexo->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->sexo->EditValue = $arwrk;

			// estado
			$this->estado->EditAttrs["class"] = "form-control";
			$this->estado->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->estado->FldTagValue(1), $this->estado->FldTagCaption(1) <> "" ? $this->estado->FldTagCaption(1) : $this->estado->FldTagValue(1));
			$arwrk[] = array($this->estado->FldTagValue(2), $this->estado->FldTagCaption(2) <> "" ? $this->estado->FldTagCaption(2) : $this->estado->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->estado->EditValue = $arwrk;

			// Edit refer script
			// tipo_persona

			$this->tipo_persona->HrefValue = "";

			// nombre
			$this->nombre->HrefValue = "";

			// apellido
			$this->apellido->HrefValue = "";

			// direccion
			$this->direccion->HrefValue = "";

			// cui
			$this->cui->HrefValue = "";

			// idpais
			$this->idpais->HrefValue = "";

			// fecha_nacimiento
			$this->fecha_nacimiento->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// sexo
			$this->sexo->HrefValue = "";

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
		if (!$this->estado->FldIsDetailKey && !is_null($this->estado->FormValue) && $this->estado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->estado->FldCaption(), $this->estado->ReqErrMsg));
		}

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("cliente", $DetailTblVar) && $GLOBALS["cliente"]->DetailEdit) {
			if (!isset($GLOBALS["cliente_grid"])) $GLOBALS["cliente_grid"] = new ccliente_grid(); // get detail page object
			$GLOBALS["cliente_grid"]->ValidateGridForm();
		}
		if (in_array("empleado", $DetailTblVar) && $GLOBALS["empleado"]->DetailEdit) {
			if (!isset($GLOBALS["empleado_grid"])) $GLOBALS["empleado_grid"] = new cempleado_grid(); // get detail page object
			$GLOBALS["empleado_grid"]->ValidateGridForm();
		}
		if (in_array("proveedor", $DetailTblVar) && $GLOBALS["proveedor"]->DetailEdit) {
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

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// tipo_persona
			$this->tipo_persona->SetDbValueDef($rsnew, $this->tipo_persona->CurrentValue, "", $this->tipo_persona->ReadOnly);

			// nombre
			$this->nombre->SetDbValueDef($rsnew, $this->nombre->CurrentValue, NULL, $this->nombre->ReadOnly);

			// apellido
			$this->apellido->SetDbValueDef($rsnew, $this->apellido->CurrentValue, NULL, $this->apellido->ReadOnly);

			// direccion
			$this->direccion->SetDbValueDef($rsnew, $this->direccion->CurrentValue, NULL, $this->direccion->ReadOnly);

			// cui
			$this->cui->SetDbValueDef($rsnew, $this->cui->CurrentValue, NULL, $this->cui->ReadOnly);

			// idpais
			$this->idpais->SetDbValueDef($rsnew, $this->idpais->CurrentValue, 0, $this->idpais->ReadOnly);

			// fecha_nacimiento
			$this->fecha_nacimiento->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha_nacimiento->CurrentValue, 7), NULL, $this->fecha_nacimiento->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// sexo
			$this->sexo->SetDbValueDef($rsnew, $this->sexo->CurrentValue, "", $this->sexo->ReadOnly);

			// estado
			$this->estado->SetDbValueDef($rsnew, $this->estado->CurrentValue, "", $this->estado->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}

				// Update detail records
				if ($EditRow) {
					$DetailTblVar = explode(",", $this->getCurrentDetailTable());
					if (in_array("cliente", $DetailTblVar) && $GLOBALS["cliente"]->DetailEdit) {
						if (!isset($GLOBALS["cliente_grid"])) $GLOBALS["cliente_grid"] = new ccliente_grid(); // Get detail page object
						$EditRow = $GLOBALS["cliente_grid"]->GridUpdate();
					}
					if (in_array("empleado", $DetailTblVar) && $GLOBALS["empleado"]->DetailEdit) {
						if (!isset($GLOBALS["empleado_grid"])) $GLOBALS["empleado_grid"] = new cempleado_grid(); // Get detail page object
						$EditRow = $GLOBALS["empleado_grid"]->GridUpdate();
					}
					if (in_array("proveedor", $DetailTblVar) && $GLOBALS["proveedor"]->DetailEdit) {
						if (!isset($GLOBALS["proveedor_grid"])) $GLOBALS["proveedor_grid"] = new cproveedor_grid(); // Get detail page object
						$EditRow = $GLOBALS["proveedor_grid"]->GridUpdate();
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
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "pais") {
				if ($this->idpais->QueryStringValue == "") $this->idpais->setSessionValue("");
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
			if (in_array("cliente", $DetailTblVar)) {
				if (!isset($GLOBALS["cliente_grid"]))
					$GLOBALS["cliente_grid"] = new ccliente_grid;
				if ($GLOBALS["cliente_grid"]->DetailEdit) {
					$GLOBALS["cliente_grid"]->CurrentMode = "edit";
					$GLOBALS["cliente_grid"]->CurrentAction = "gridedit";

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
				if ($GLOBALS["empleado_grid"]->DetailEdit) {
					$GLOBALS["empleado_grid"]->CurrentMode = "edit";
					$GLOBALS["empleado_grid"]->CurrentAction = "gridedit";

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
				if ($GLOBALS["proveedor_grid"]->DetailEdit) {
					$GLOBALS["proveedor_grid"]->CurrentMode = "edit";
					$GLOBALS["proveedor_grid"]->CurrentAction = "gridedit";

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
		$Breadcrumb->Add("list", $this->TableVar, "personalist.php", "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, ew_CurrentUrl());
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
if (!isset($persona_edit)) $persona_edit = new cpersona_edit();

// Page init
$persona_edit->Page_Init();

// Page main
$persona_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$persona_edit->Page_Render();
?>
<?php include_once $EW_RELATIVE_PATH . "header.php" ?>
<script type="text/javascript">

// Page object
var persona_edit = new ew_Page("persona_edit");
persona_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = persona_edit.PageID; // For backward compatibility

// Form object
var fpersonaedit = new ew_Form("fpersonaedit");

// Validate form
fpersonaedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_estado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $persona->estado->FldCaption(), $persona->estado->ReqErrMsg)) ?>");

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
fpersonaedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpersonaedit.ValidateRequired = true;
<?php } else { ?>
fpersonaedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpersonaedit.Lists["x_idpais"] = {"LinkField":"x_idpais","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

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
<?php $persona_edit->ShowPageHeader(); ?>
<?php
$persona_edit->ShowMessage();
?>
<form name="fpersonaedit" id="fpersonaedit" class="form-horizontal ewForm ewEditForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($persona_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $persona_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="persona">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<div>
<?php if ($persona->tipo_persona->Visible) { // tipo_persona ?>
	<div id="r_tipo_persona" class="form-group">
		<label id="elh_persona_tipo_persona" for="x_tipo_persona" class="col-sm-2 control-label ewLabel"><?php echo $persona->tipo_persona->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->tipo_persona->CellAttributes() ?>>
<span id="el_persona_tipo_persona">
<select data-field="x_tipo_persona" id="x_tipo_persona" name="x_tipo_persona"<?php echo $persona->tipo_persona->EditAttributes() ?>>
<?php
if (is_array($persona->tipo_persona->EditValue)) {
	$arwrk = $persona->tipo_persona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persona->tipo_persona->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
<?php echo $persona->tipo_persona->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label id="elh_persona_nombre" for="x_nombre" class="col-sm-2 control-label ewLabel"><?php echo $persona->nombre->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->nombre->CellAttributes() ?>>
<span id="el_persona_nombre">
<input type="text" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->nombre->PlaceHolder) ?>" value="<?php echo $persona->nombre->EditValue ?>"<?php echo $persona->nombre->EditAttributes() ?>>
</span>
<?php echo $persona->nombre->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->apellido->Visible) { // apellido ?>
	<div id="r_apellido" class="form-group">
		<label id="elh_persona_apellido" for="x_apellido" class="col-sm-2 control-label ewLabel"><?php echo $persona->apellido->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->apellido->CellAttributes() ?>>
<span id="el_persona_apellido">
<input type="text" data-field="x_apellido" name="x_apellido" id="x_apellido" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->apellido->PlaceHolder) ?>" value="<?php echo $persona->apellido->EditValue ?>"<?php echo $persona->apellido->EditAttributes() ?>>
</span>
<?php echo $persona->apellido->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->direccion->Visible) { // direccion ?>
	<div id="r_direccion" class="form-group">
		<label id="elh_persona_direccion" for="x_direccion" class="col-sm-2 control-label ewLabel"><?php echo $persona->direccion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->direccion->CellAttributes() ?>>
<span id="el_persona_direccion">
<input type="text" data-field="x_direccion" name="x_direccion" id="x_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->direccion->PlaceHolder) ?>" value="<?php echo $persona->direccion->EditValue ?>"<?php echo $persona->direccion->EditAttributes() ?>>
</span>
<?php echo $persona->direccion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->cui->Visible) { // cui ?>
	<div id="r_cui" class="form-group">
		<label id="elh_persona_cui" for="x_cui" class="col-sm-2 control-label ewLabel"><?php echo $persona->cui->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $persona->cui->CellAttributes() ?>>
<span id="el_persona_cui">
<input type="text" data-field="x_cui" name="x_cui" id="x_cui" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->cui->PlaceHolder) ?>" value="<?php echo $persona->cui->EditValue ?>"<?php echo $persona->cui->EditAttributes() ?>>
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
<select data-field="x_idpais" id="x_idpais" name="x_idpais"<?php echo $persona->idpais->EditAttributes() ?>>
<?php
if (is_array($persona->idpais->EditValue)) {
	$arwrk = $persona->idpais->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persona->idpais->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
$sSqlWrk = "SELECT `idpais`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `pais`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
if (strval($lookuptblfilter) <> "") {
	ew_AddFilter($sWhereWrk, $lookuptblfilter);
}

// Call Lookup selecting
$persona->Lookup_Selecting($persona->idpais, $sWhereWrk);
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
?>
<input type="hidden" name="s_x_idpais" id="s_x_idpais" value="s=<?php echo ew_Encrypt($sSqlWrk) ?>&amp;f0=<?php echo ew_Encrypt("`idpais` = {filter_value}"); ?>&amp;t0=3">
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
<input type="text" data-field="x_fecha_nacimiento" name="x_fecha_nacimiento" id="x_fecha_nacimiento" placeholder="<?php echo ew_HtmlEncode($persona->fecha_nacimiento->PlaceHolder) ?>" value="<?php echo $persona->fecha_nacimiento->EditValue ?>"<?php echo $persona->fecha_nacimiento->EditAttributes() ?>>
<?php if (!$persona->fecha_nacimiento->ReadOnly && !$persona->fecha_nacimiento->Disabled && @$persona->fecha_nacimiento->EditAttrs["readonly"] == "" && @$persona->fecha_nacimiento->EditAttrs["disabled"] == "") { ?>
<script type="text/javascript">
ew_CreateCalendar("fpersonaedit", "x_fecha_nacimiento", "%d/%m/%Y");
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
<input type="text" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($persona->_email->PlaceHolder) ?>" value="<?php echo $persona->_email->EditValue ?>"<?php echo $persona->_email->EditAttributes() ?>>
</span>
<?php echo $persona->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->sexo->Visible) { // sexo ?>
	<div id="r_sexo" class="form-group">
		<label id="elh_persona_sexo" for="x_sexo" class="col-sm-2 control-label ewLabel"><?php echo $persona->sexo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->sexo->CellAttributes() ?>>
<span id="el_persona_sexo">
<select data-field="x_sexo" id="x_sexo" name="x_sexo"<?php echo $persona->sexo->EditAttributes() ?>>
<?php
if (is_array($persona->sexo->EditValue)) {
	$arwrk = $persona->sexo->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persona->sexo->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
<?php echo $persona->sexo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($persona->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label id="elh_persona_estado" for="x_estado" class="col-sm-2 control-label ewLabel"><?php echo $persona->estado->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $persona->estado->CellAttributes() ?>>
<span id="el_persona_estado">
<select data-field="x_estado" id="x_estado" name="x_estado"<?php echo $persona->estado->EditAttributes() ?>>
<?php
if (is_array($persona->estado->EditValue)) {
	$arwrk = $persona->estado->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($persona->estado->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span>
<?php echo $persona->estado->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<input type="hidden" data-field="x_idpersona" name="x_idpersona" id="x_idpersona" value="<?php echo ew_HtmlEncode($persona->idpersona->CurrentValue) ?>">
<?php
	if (in_array("cliente", explode(",", $persona->getCurrentDetailTable())) && $cliente->DetailEdit) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("cliente", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "clientegrid.php" ?>
<?php } ?>
<?php
	if (in_array("empleado", explode(",", $persona->getCurrentDetailTable())) && $empleado->DetailEdit) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("empleado", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "empleadogrid.php" ?>
<?php } ?>
<?php
	if (in_array("proveedor", explode(",", $persona->getCurrentDetailTable())) && $proveedor->DetailEdit) {
?>
<?php if ($persona->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("proveedor", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "proveedorgrid.php" ?>
<?php } ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
	</div>
</div>
</form>
<script type="text/javascript">
fpersonaedit.Init();
</script>
<?php
$persona_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once $EW_RELATIVE_PATH . "footer.php" ?>
<?php
$persona_edit->Page_Terminate();
?>
