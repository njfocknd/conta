<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "empleadoinfo.php" ?>
<?php include_once "personainfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$empleado_search = NULL; // Initialize page object first

class cempleado_search extends cempleado {

	// Page ID
	var $PageID = 'search';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'empleado';

	// Page object name
	var $PageObjName = 'empleado_search';

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

		// Table object (empleado)
		if (!isset($GLOBALS["empleado"]) || get_class($GLOBALS["empleado"]) == "cempleado") {
			$GLOBALS["empleado"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["empleado"];
		}

		// Table object (persona)
		if (!isset($GLOBALS['persona'])) $GLOBALS['persona'] = new cpersona();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'search', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'empleado', TRUE);

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
		$this->idempleado->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		global $EW_EXPORT, $empleado;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($empleado);
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
	var $FormClassName = "form-horizontal ewForm ewSearchForm";
	var $IsModal = FALSE;
	var $SearchLabelClass = "col-sm-3 control-label ewLabel";
	var $SearchRightColumnClass = "col-sm-9";

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsSearchError;
		global $gbSkipHeaderFooter;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		if ($this->IsPageRequest()) { // Validate request

			// Get action
			$this->CurrentAction = $objForm->GetValue("a_search");
			switch ($this->CurrentAction) {
				case "S": // Get search criteria

					// Build search string for advanced search, remove blank field
					$this->LoadSearchValues(); // Get search values
					if ($this->ValidateSearch()) {
						$sSrchStr = $this->BuildAdvancedSearch();
					} else {
						$sSrchStr = "";
						$this->setFailureMessage($gsSearchError);
					}
					if ($sSrchStr <> "") {
						$sSrchStr = $this->UrlParm($sSrchStr);
						$sSrchStr = "empleadolist.php" . "?" . $sSrchStr;
						if ($this->IsModal) {
							$row = array();
							$row["url"] = $sSrchStr;
							echo ew_ArrayToJson(array($row));
							$this->Page_Terminate();
							exit();
						} else {
							$this->Page_Terminate($sSrchStr); // Go to list page
						}
					}
			}
		}

		// Restore search settings from Session
		if ($gsSearchError == "")
			$this->LoadAdvancedSearch();

		// Render row for search
		$this->RowType = EW_ROWTYPE_SEARCH;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Build advanced search
	function BuildAdvancedSearch() {
		$sSrchUrl = "";
		$this->BuildSearchUrl($sSrchUrl, $this->idempleado); // idempleado
		$this->BuildSearchUrl($sSrchUrl, $this->nit); // nit
		$this->BuildSearchUrl($sSrchUrl, $this->codigo); // codigo
		$this->BuildSearchUrl($sSrchUrl, $this->nombre); // nombre
		$this->BuildSearchUrl($sSrchUrl, $this->direccion); // direccion
		$this->BuildSearchUrl($sSrchUrl, $this->idpersona); // idpersona
		$this->BuildSearchUrl($sSrchUrl, $this->estado); // estado
		$this->BuildSearchUrl($sSrchUrl, $this->idempresa); // idempresa
		if ($sSrchUrl <> "") $sSrchUrl .= "&";
		$sSrchUrl .= "cmd=search";
		return $sSrchUrl;
	}

	// Build search URL
	function BuildSearchUrl(&$Url, &$Fld, $OprOnly=FALSE) {
		global $objForm;
		$sWrk = "";
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = $objForm->GetValue("x_$FldParm");
		$FldOpr = $objForm->GetValue("z_$FldParm");
		$FldCond = $objForm->GetValue("v_$FldParm");
		$FldVal2 = $objForm->GetValue("y_$FldParm");
		$FldOpr2 = $objForm->GetValue("w_$FldParm");
		$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);
		$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		$lFldDataType = ($Fld->FldIsVirtual) ? EW_DATATYPE_STRING : $Fld->FldDataType;
		if ($FldOpr == "BETWEEN") {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal) && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal <> "" && $FldVal2 <> "" && $IsValidValue) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			}
		} else {
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal));
			if ($FldVal <> "" && $IsValidValue && ew_IsValidOpr($FldOpr, $lFldDataType)) {
				$sWrk = "x_" . $FldParm . "=" . urlencode($FldVal) .
					"&z_" . $FldParm . "=" . urlencode($FldOpr);
			} elseif ($FldOpr == "IS NULL" || $FldOpr == "IS NOT NULL" || ($FldOpr <> "" && $OprOnly && ew_IsValidOpr($FldOpr, $lFldDataType))) {
				$sWrk = "z_" . $FldParm . "=" . urlencode($FldOpr);
			}
			$IsValidValue = ($lFldDataType <> EW_DATATYPE_NUMBER) ||
				($lFldDataType == EW_DATATYPE_NUMBER && $this->SearchValueIsNumeric($Fld, $FldVal2));
			if ($FldVal2 <> "" && $IsValidValue && ew_IsValidOpr($FldOpr2, $lFldDataType)) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "y_" . $FldParm . "=" . urlencode($FldVal2) .
					"&w_" . $FldParm . "=" . urlencode($FldOpr2);
			} elseif ($FldOpr2 == "IS NULL" || $FldOpr2 == "IS NOT NULL" || ($FldOpr2 <> "" && $OprOnly && ew_IsValidOpr($FldOpr2, $lFldDataType))) {
				if ($sWrk <> "") $sWrk .= "&v_" . $FldParm . "=" . urlencode($FldCond) . "&";
				$sWrk .= "w_" . $FldParm . "=" . urlencode($FldOpr2);
			}
		}
		if ($sWrk <> "") {
			if ($Url <> "") $Url .= "&";
			$Url .= $sWrk;
		}
	}

	function SearchValueIsNumeric($Fld, $Value) {
		if (ew_IsFloatFormat($Fld->FldType)) $Value = ew_StrToFloat($Value);
		return is_numeric($Value);
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// idempleado

		$this->idempleado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idempleado"));
		$this->idempleado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idempleado");

		// nit
		$this->nit->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nit"));
		$this->nit->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nit");

		// codigo
		$this->codigo->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_codigo"));
		$this->codigo->AdvancedSearch->SearchOperator = $objForm->GetValue("z_codigo");

		// nombre
		$this->nombre->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_nombre"));
		$this->nombre->AdvancedSearch->SearchOperator = $objForm->GetValue("z_nombre");

		// direccion
		$this->direccion->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_direccion"));
		$this->direccion->AdvancedSearch->SearchOperator = $objForm->GetValue("z_direccion");

		// idpersona
		$this->idpersona->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idpersona"));
		$this->idpersona->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idpersona");

		// estado
		$this->estado->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_estado"));
		$this->estado->AdvancedSearch->SearchOperator = $objForm->GetValue("z_estado");

		// idempresa
		$this->idempresa->AdvancedSearch->SearchValue = ew_StripSlashes($objForm->GetValue("x_idempresa"));
		$this->idempresa->AdvancedSearch->SearchOperator = $objForm->GetValue("z_idempresa");
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// idempleado
		// nit
		// codigo
		// nombre
		// direccion
		// idpersona
		// estado
		// idempresa

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idempleado
		$this->idempleado->ViewValue = $this->idempleado->CurrentValue;
		$this->idempleado->ViewCustomAttributes = "";

		// nit
		$this->nit->ViewValue = $this->nit->CurrentValue;
		$this->nit->ViewCustomAttributes = "";

		// codigo
		$this->codigo->ViewValue = $this->codigo->CurrentValue;
		$this->codigo->ViewCustomAttributes = "";

		// nombre
		$this->nombre->ViewValue = $this->nombre->CurrentValue;
		$this->nombre->ViewCustomAttributes = "";

		// direccion
		$this->direccion->ViewValue = $this->direccion->CurrentValue;
		$this->direccion->ViewCustomAttributes = "";

		// idpersona
		if (strval($this->idpersona->CurrentValue) <> "") {
			$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idpersona, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$arwrk[2] = $rswrk->fields('Disp2Fld');
				$this->idpersona->ViewValue = $this->idpersona->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idpersona->ViewValue = $this->idpersona->CurrentValue;
			}
		} else {
			$this->idpersona->ViewValue = NULL;
		}
		$this->idpersona->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

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

			// idempleado
			$this->idempleado->LinkCustomAttributes = "";
			$this->idempleado->HrefValue = "";
			$this->idempleado->TooltipValue = "";

			// nit
			$this->nit->LinkCustomAttributes = "";
			$this->nit->HrefValue = "";
			$this->nit->TooltipValue = "";

			// codigo
			$this->codigo->LinkCustomAttributes = "";
			$this->codigo->HrefValue = "";
			$this->codigo->TooltipValue = "";

			// nombre
			$this->nombre->LinkCustomAttributes = "";
			$this->nombre->HrefValue = "";
			$this->nombre->TooltipValue = "";

			// direccion
			$this->direccion->LinkCustomAttributes = "";
			$this->direccion->HrefValue = "";
			$this->direccion->TooltipValue = "";

			// idpersona
			$this->idpersona->LinkCustomAttributes = "";
			$this->idpersona->HrefValue = "";
			$this->idpersona->TooltipValue = "";

			// estado
			$this->estado->LinkCustomAttributes = "";
			$this->estado->HrefValue = "";
			$this->estado->TooltipValue = "";

			// idempresa
			$this->idempresa->LinkCustomAttributes = "";
			$this->idempresa->HrefValue = "";
			$this->idempresa->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_SEARCH) { // Search row

			// idempleado
			$this->idempleado->EditAttrs["class"] = "form-control";
			$this->idempleado->EditCustomAttributes = "";
			$this->idempleado->EditValue = ew_HtmlEncode($this->idempleado->AdvancedSearch->SearchValue);
			$this->idempleado->PlaceHolder = ew_RemoveHtml($this->idempleado->FldCaption());

			// nit
			$this->nit->EditAttrs["class"] = "form-control";
			$this->nit->EditCustomAttributes = "";
			$this->nit->EditValue = ew_HtmlEncode($this->nit->AdvancedSearch->SearchValue);
			$this->nit->PlaceHolder = ew_RemoveHtml($this->nit->FldCaption());

			// codigo
			$this->codigo->EditAttrs["class"] = "form-control";
			$this->codigo->EditCustomAttributes = "";
			$this->codigo->EditValue = ew_HtmlEncode($this->codigo->AdvancedSearch->SearchValue);
			$this->codigo->PlaceHolder = ew_RemoveHtml($this->codigo->FldCaption());

			// nombre
			$this->nombre->EditAttrs["class"] = "form-control";
			$this->nombre->EditCustomAttributes = "";
			$this->nombre->EditValue = ew_HtmlEncode($this->nombre->AdvancedSearch->SearchValue);
			$this->nombre->PlaceHolder = ew_RemoveHtml($this->nombre->FldCaption());

			// direccion
			$this->direccion->EditAttrs["class"] = "form-control";
			$this->direccion->EditCustomAttributes = "";
			$this->direccion->EditValue = ew_HtmlEncode($this->direccion->AdvancedSearch->SearchValue);
			$this->direccion->PlaceHolder = ew_RemoveHtml($this->direccion->FldCaption());

			// idpersona
			$this->idpersona->EditAttrs["class"] = "form-control";
			$this->idpersona->EditCustomAttributes = "";
			if (trim(strval($this->idpersona->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idpersona`" . ew_SearchString("=", $this->idpersona->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `persona`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idpersona, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idpersona->EditValue = $arwrk;

			// estado
			$this->estado->EditCustomAttributes = "";
			$this->estado->EditValue = $this->estado->Options(FALSE);

			// idempresa
			$this->idempresa->EditAttrs["class"] = "form-control";
			$this->idempresa->EditCustomAttributes = "";
			if (trim(strval($this->idempresa->AdvancedSearch->SearchValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->AdvancedSearch->SearchValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `idempresa`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `empresa`";
			$sWhereWrk = "";
			$lookuptblfilter = "`estado` = 'Activo'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->idempresa, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idempresa->EditValue = $arwrk;
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

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;
		if (!ew_CheckInteger($this->idempleado->AdvancedSearch->SearchValue)) {
			ew_AddMessage($gsSearchError, $this->idempleado->FldErrMsg());
		}

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->idempleado->AdvancedSearch->Load();
		$this->nit->AdvancedSearch->Load();
		$this->codigo->AdvancedSearch->Load();
		$this->nombre->AdvancedSearch->Load();
		$this->direccion->AdvancedSearch->Load();
		$this->idpersona->AdvancedSearch->Load();
		$this->estado->AdvancedSearch->Load();
		$this->idempresa->AdvancedSearch->Load();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("empleadolist.php"), "", $this->TableVar, TRUE);
		$PageId = "search";
		$Breadcrumb->Add("search", $PageId, $url);
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
if (!isset($empleado_search)) $empleado_search = new cempleado_search();

// Page init
$empleado_search->Page_Init();

// Page main
$empleado_search->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$empleado_search->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "search";
<?php if ($empleado_search->IsModal) { ?>
var CurrentAdvancedSearchForm = fempleadosearch = new ew_Form("fempleadosearch", "search");
<?php } else { ?>
var CurrentForm = fempleadosearch = new ew_Form("fempleadosearch", "search");
<?php } ?>

// Form_CustomValidate event
fempleadosearch.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fempleadosearch.ValidateRequired = true;
<?php } else { ?>
fempleadosearch.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fempleadosearch.Lists["x_idpersona"] = {"LinkField":"x_idpersona","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","x_apellido","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fempleadosearch.Lists["x_estado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fempleadosearch.Lists["x_estado"].Options = <?php echo json_encode($empleado->estado->Options()) ?>;
fempleadosearch.Lists["x_idempresa"] = {"LinkField":"x_idempresa","Ajax":true,"AutoFill":false,"DisplayFields":["x_nombre","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};

// Form object for search
// Validate function for search

fempleadosearch.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	var infix = "";
	elm = this.GetElements("x" + infix + "_idempleado");
	if (elm && !ew_CheckInteger(elm.value))
		return this.OnError(elm, "<?php echo ew_JsEncode2($empleado->idempleado->FldErrMsg()) ?>");

	// Fire Form_CustomValidate event
	if (!this.Form_CustomValidate(fobj))
		return false;
	return true;
}
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$empleado_search->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $empleado_search->ShowPageHeader(); ?>
<?php
$empleado_search->ShowMessage();
?>
<form name="fempleadosearch" id="fempleadosearch" class="<?php echo $empleado_search->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($empleado_search->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $empleado_search->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="empleado">
<input type="hidden" name="a_search" id="a_search" value="S">
<?php if ($empleado_search->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($empleado->idempleado->Visible) { // idempleado ?>
	<div id="r_idempleado" class="form-group">
		<label for="x_idempleado" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_idempleado"><?php echo $empleado->idempleado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idempleado" id="z_idempleado" value="="></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->idempleado->CellAttributes() ?>>
			<span id="el_empleado_idempleado">
<input type="text" data-table="empleado" data-field="x_idempleado" name="x_idempleado" id="x_idempleado" placeholder="<?php echo ew_HtmlEncode($empleado->idempleado->getPlaceHolder()) ?>" value="<?php echo $empleado->idempleado->EditValue ?>"<?php echo $empleado->idempleado->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->nit->Visible) { // nit ?>
	<div id="r_nit" class="form-group">
		<label for="x_nit" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_nit"><?php echo $empleado->nit->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nit" id="z_nit" value="LIKE"></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->nit->CellAttributes() ?>>
			<span id="el_empleado_nit">
<input type="text" data-table="empleado" data-field="x_nit" name="x_nit" id="x_nit" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nit->getPlaceHolder()) ?>" value="<?php echo $empleado->nit->EditValue ?>"<?php echo $empleado->nit->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->codigo->Visible) { // codigo ?>
	<div id="r_codigo" class="form-group">
		<label for="x_codigo" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_codigo"><?php echo $empleado->codigo->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_codigo" id="z_codigo" value="LIKE"></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->codigo->CellAttributes() ?>>
			<span id="el_empleado_codigo">
<input type="text" data-table="empleado" data-field="x_codigo" name="x_codigo" id="x_codigo" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->codigo->getPlaceHolder()) ?>" value="<?php echo $empleado->codigo->EditValue ?>"<?php echo $empleado->codigo->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->nombre->Visible) { // nombre ?>
	<div id="r_nombre" class="form-group">
		<label for="x_nombre" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_nombre"><?php echo $empleado->nombre->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_nombre" id="z_nombre" value="LIKE"></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->nombre->CellAttributes() ?>>
			<span id="el_empleado_nombre">
<input type="text" data-table="empleado" data-field="x_nombre" name="x_nombre" id="x_nombre" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->nombre->getPlaceHolder()) ?>" value="<?php echo $empleado->nombre->EditValue ?>"<?php echo $empleado->nombre->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->direccion->Visible) { // direccion ?>
	<div id="r_direccion" class="form-group">
		<label for="x_direccion" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_direccion"><?php echo $empleado->direccion->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("LIKE") ?><input type="hidden" name="z_direccion" id="z_direccion" value="LIKE"></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->direccion->CellAttributes() ?>>
			<span id="el_empleado_direccion">
<input type="text" data-table="empleado" data-field="x_direccion" name="x_direccion" id="x_direccion" size="30" maxlength="45" placeholder="<?php echo ew_HtmlEncode($empleado->direccion->getPlaceHolder()) ?>" value="<?php echo $empleado->direccion->EditValue ?>"<?php echo $empleado->direccion->EditAttributes() ?>>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->idpersona->Visible) { // idpersona ?>
	<div id="r_idpersona" class="form-group">
		<label for="x_idpersona" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_idpersona"><?php echo $empleado->idpersona->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idpersona" id="z_idpersona" value="="></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->idpersona->CellAttributes() ?>>
			<span id="el_empleado_idpersona">
<select data-table="empleado" data-field="x_idpersona" data-value-separator="<?php echo ew_HtmlEncode(is_array($empleado->idpersona->DisplayValueSeparator) ? json_encode($empleado->idpersona->DisplayValueSeparator) : $empleado->idpersona->DisplayValueSeparator) ?>" id="x_idpersona" name="x_idpersona"<?php echo $empleado->idpersona->EditAttributes() ?>>
<?php
if (is_array($empleado->idpersona->EditValue)) {
	$arwrk = $empleado->idpersona->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($empleado->idpersona->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $empleado->idpersona->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($empleado->idpersona->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($empleado->idpersona->CurrentValue) ?>" selected><?php echo $empleado->idpersona->CurrentValue ?></option>
<?php
    }
}
?>
</select>
<?php
$sSqlWrk = "SELECT `idpersona`, `nombre` AS `DispFld`, `apellido` AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `persona`";
$sWhereWrk = "";
$lookuptblfilter = "`estado` = 'Activo'";
ew_AddFilter($sWhereWrk, $lookuptblfilter);
$empleado->idpersona->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$empleado->idpersona->LookupFilters += array("f0" => "`idpersona` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$empleado->Lookup_Selecting($empleado->idpersona, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $empleado->idpersona->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idpersona" id="s_x_idpersona" value="<?php echo $empleado->idpersona->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->estado->Visible) { // estado ?>
	<div id="r_estado" class="form-group">
		<label class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_estado"><?php echo $empleado->estado->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_estado" id="z_estado" value="="></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->estado->CellAttributes() ?>>
			<span id="el_empleado_estado">
<div id="tp_x_estado" class="ewTemplate"><input type="radio" data-table="empleado" data-field="x_estado" data-value-separator="<?php echo ew_HtmlEncode(is_array($empleado->estado->DisplayValueSeparator) ? json_encode($empleado->estado->DisplayValueSeparator) : $empleado->estado->DisplayValueSeparator) ?>" name="x_estado" id="x_estado" value="{value}"<?php echo $empleado->estado->EditAttributes() ?>></div>
<div id="dsl_x_estado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php
$arwrk = $empleado->estado->EditValue;
if (is_array($arwrk)) {
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($empleado->estado->AdvancedSearch->SearchValue) == strval($arwrk[$rowcntwrk][0])) ? " checked" : "";
		if ($selwrk <> "")
			$emptywrk = FALSE;
?>
<label class="radio-inline"><input type="radio" data-table="empleado" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowcntwrk ?>" value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?><?php echo $empleado->estado->EditAttributes() ?>><?php echo $empleado->estado->DisplayValue($arwrk[$rowcntwrk]) ?></label>
<?php
	}
	if ($emptywrk && strval($empleado->estado->CurrentValue) <> "") {
?>
<label class="radio-inline"><input type="radio" data-table="empleado" data-field="x_estado" name="x_estado" id="x_estado_<?php echo $rowswrk ?>" value="<?php echo ew_HtmlEncode($empleado->estado->CurrentValue) ?>" checked<?php echo $empleado->estado->EditAttributes() ?>><?php echo $empleado->estado->CurrentValue ?></label>
<?php
    }
}
?>
</div></div>
</span>
		</div></div>
	</div>
<?php } ?>
<?php if ($empleado->idempresa->Visible) { // idempresa ?>
	<div id="r_idempresa" class="form-group">
		<label for="x_idempresa" class="<?php echo $empleado_search->SearchLabelClass ?>"><span id="elh_empleado_idempresa"><?php echo $empleado->idempresa->FldCaption() ?></span>	
		<p class="form-control-static ewSearchOperator"><?php echo $Language->Phrase("=") ?><input type="hidden" name="z_idempresa" id="z_idempresa" value="="></p>
		</label>
		<div class="<?php echo $empleado_search->SearchRightColumnClass ?>"><div<?php echo $empleado->idempresa->CellAttributes() ?>>
			<span id="el_empleado_idempresa">
<select data-table="empleado" data-field="x_idempresa" data-value-separator="<?php echo ew_HtmlEncode(is_array($empleado->idempresa->DisplayValueSeparator) ? json_encode($empleado->idempresa->DisplayValueSeparator) : $empleado->idempresa->DisplayValueSeparator) ?>" id="x_idempresa" name="x_idempresa"<?php echo $empleado->idempresa->EditAttributes() ?>>
<?php
if (is_array($empleado->idempresa->EditValue)) {
	$arwrk = $empleado->idempresa->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = ew_SameStr($empleado->idempresa->AdvancedSearch->SearchValue, $arwrk[$rowcntwrk][0]) ? " selected" : "";
		if ($selwrk <> "") $emptywrk = FALSE;		
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $empleado->idempresa->DisplayValue($arwrk[$rowcntwrk]) ?>
</option>
<?php
	}
	if ($emptywrk && strval($empleado->idempresa->CurrentValue) <> "") {
?>
<option value="<?php echo ew_HtmlEncode($empleado->idempresa->CurrentValue) ?>" selected><?php echo $empleado->idempresa->CurrentValue ?></option>
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
$empleado->idempresa->LookupFilters = array("s" => $sSqlWrk, "d" => "");
$empleado->idempresa->LookupFilters += array("f0" => "`idempresa` = {filter_value}", "t0" => "3", "fn0" => "");
$sSqlWrk = "";
$empleado->Lookup_Selecting($empleado->idempresa, $sWhereWrk); // Call Lookup selecting
if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
if ($sSqlWrk <> "") $empleado->idempresa->LookupFilters["s"] .= $sSqlWrk;
?>
<input type="hidden" name="s_x_idempresa" id="s_x_idempresa" value="<?php echo $empleado->idempresa->LookupFilterQuery() ?>">
</span>
		</div></div>
	</div>
<?php } ?>
</div>
<?php if (!$empleado_search->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-3 col-sm-9">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("Search") ?></button>
<button class="btn btn-default ewButton" name="btnReset" id="btnReset" type="button" onclick="ew_ClearForm(this.form);"><?php echo $Language->Phrase("Reset") ?></button>
	</div>
</div>
<?php } ?>
</form>
<script type="text/javascript">
fempleadosearch.Init();
</script>
<?php
$empleado_search->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$empleado_search->Page_Terminate();
?>
