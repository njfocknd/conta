<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg12.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql12.php") ?>
<?php include_once "phpfn12.php" ?>
<?php include_once "caja_chica_aplicacioninfo.php" ?>
<?php include_once "caja_chica_detalleinfo.php" ?>
<?php include_once "userfn12.php" ?>
<?php

//
// Page class
//

$caja_chica_aplicacion_delete = NULL; // Initialize page object first

class ccaja_chica_aplicacion_delete extends ccaja_chica_aplicacion {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{7A6CF8EC-FF5E-4A2F-90E6-C9E9870D7F9C}";

	// Table name
	var $TableName = 'caja_chica_aplicacion';

	// Page object name
	var $PageObjName = 'caja_chica_aplicacion_delete';

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

		// Table object (caja_chica_aplicacion)
		if (!isset($GLOBALS["caja_chica_aplicacion"]) || get_class($GLOBALS["caja_chica_aplicacion"]) == "ccaja_chica_aplicacion") {
			$GLOBALS["caja_chica_aplicacion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["caja_chica_aplicacion"];
		}

		// Table object (caja_chica_detalle)
		if (!isset($GLOBALS['caja_chica_detalle'])) $GLOBALS['caja_chica_detalle'] = new ccaja_chica_detalle();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'caja_chica_aplicacion', TRUE);

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
		global $EW_EXPORT, $caja_chica_aplicacion;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($caja_chica_aplicacion);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("caja_chica_aplicacionlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in caja_chica_aplicacion class, caja_chica_aplicacioninfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("caja_chica_aplicacionlist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->idcaja_chica_aplicacion->setDbValue($rs->fields('idcaja_chica_aplicacion'));
		$this->idcaja_chica_detalle->setDbValue($rs->fields('idcaja_chica_detalle'));
		$this->idreferencia->setDbValue($rs->fields('idreferencia'));
		$this->tabla_referencia->setDbValue($rs->fields('tabla_referencia'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->idcaja_chica_aplicacion->DbValue = $row['idcaja_chica_aplicacion'];
		$this->idcaja_chica_detalle->DbValue = $row['idcaja_chica_detalle'];
		$this->idreferencia->DbValue = $row['idreferencia'];
		$this->tabla_referencia->DbValue = $row['tabla_referencia'];
		$this->monto->DbValue = $row['monto'];
		$this->fecha->DbValue = $row['fecha'];
		$this->fecha_insercion->DbValue = $row['fecha_insercion'];
		$this->estado->DbValue = $row['estado'];
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
		// idcaja_chica_aplicacion
		// idcaja_chica_detalle
		// idreferencia
		// tabla_referencia
		// monto
		// fecha
		// fecha_insercion
		// estado

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// idcaja_chica_aplicacion
		$this->idcaja_chica_aplicacion->ViewValue = $this->idcaja_chica_aplicacion->CurrentValue;
		$this->idcaja_chica_aplicacion->ViewCustomAttributes = "";

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle->ViewValue = $this->idcaja_chica_detalle->CurrentValue;
		$this->idcaja_chica_detalle->ViewCustomAttributes = "";

		// idreferencia
		$this->idreferencia->ViewValue = $this->idreferencia->CurrentValue;
		$this->idreferencia->ViewCustomAttributes = "";

		// tabla_referencia
		$this->tabla_referencia->ViewValue = $this->tabla_referencia->CurrentValue;
		$this->tabla_referencia->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

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

			// idcaja_chica_detalle
			$this->idcaja_chica_detalle->LinkCustomAttributes = "";
			$this->idcaja_chica_detalle->HrefValue = "";
			$this->idcaja_chica_detalle->TooltipValue = "";

			// idreferencia
			$this->idreferencia->LinkCustomAttributes = "";
			$this->idreferencia->HrefValue = "";
			$this->idreferencia->TooltipValue = "";

			// tabla_referencia
			$this->tabla_referencia->LinkCustomAttributes = "";
			$this->tabla_referencia->HrefValue = "";
			$this->tabla_referencia->TooltipValue = "";

			// monto
			$this->monto->LinkCustomAttributes = "";
			$this->monto->HrefValue = "";
			$this->monto->TooltipValue = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['idcaja_chica_aplicacion'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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
			if ($sMasterTblVar == "caja_chica_detalle") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_idcaja_chica_detalle"] <> "") {
					$GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->setQueryStringValue($_GET["fk_idcaja_chica_detalle"]);
					$this->idcaja_chica_detalle->setQueryStringValue($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->QueryStringValue);
					$this->idcaja_chica_detalle->setSessionValue($this->idcaja_chica_detalle->QueryStringValue);
					if (!is_numeric($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "caja_chica_detalle") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_idcaja_chica_detalle"] <> "") {
					$GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->setFormValue($_POST["fk_idcaja_chica_detalle"]);
					$this->idcaja_chica_detalle->setFormValue($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->FormValue);
					$this->idcaja_chica_detalle->setSessionValue($this->idcaja_chica_detalle->FormValue);
					if (!is_numeric($GLOBALS["caja_chica_detalle"]->idcaja_chica_detalle->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "caja_chica_detalle") {
				if ($this->idcaja_chica_detalle->CurrentValue == "") $this->idcaja_chica_detalle->setSessionValue("");
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
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("caja_chica_aplicacionlist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($caja_chica_aplicacion_delete)) $caja_chica_aplicacion_delete = new ccaja_chica_aplicacion_delete();

// Page init
$caja_chica_aplicacion_delete->Page_Init();

// Page main
$caja_chica_aplicacion_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$caja_chica_aplicacion_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fcaja_chica_aplicaciondelete = new ew_Form("fcaja_chica_aplicaciondelete", "delete");

// Form_CustomValidate event
fcaja_chica_aplicaciondelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcaja_chica_aplicaciondelete.ValidateRequired = true;
<?php } else { ?>
fcaja_chica_aplicaciondelete.ValidateRequired = false; 
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
<?php $caja_chica_aplicacion_delete->ShowPageHeader(); ?>
<?php
$caja_chica_aplicacion_delete->ShowMessage();
?>
<form name="fcaja_chica_aplicaciondelete" id="fcaja_chica_aplicaciondelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($caja_chica_aplicacion_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $caja_chica_aplicacion_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="caja_chica_aplicacion">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($caja_chica_aplicacion_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="table ewTable">
<?php echo $caja_chica_aplicacion->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
		<th><span id="elh_caja_chica_aplicacion_idcaja_chica_detalle" class="caja_chica_aplicacion_idcaja_chica_detalle"><?php echo $caja_chica_aplicacion->idcaja_chica_detalle->FldCaption() ?></span></th>
<?php } ?>
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
		<th><span id="elh_caja_chica_aplicacion_idreferencia" class="caja_chica_aplicacion_idreferencia"><?php echo $caja_chica_aplicacion->idreferencia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
		<th><span id="elh_caja_chica_aplicacion_tabla_referencia" class="caja_chica_aplicacion_tabla_referencia"><?php echo $caja_chica_aplicacion->tabla_referencia->FldCaption() ?></span></th>
<?php } ?>
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
		<th><span id="elh_caja_chica_aplicacion_monto" class="caja_chica_aplicacion_monto"><?php echo $caja_chica_aplicacion->monto->FldCaption() ?></span></th>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
		<th><span id="elh_caja_chica_aplicacion_fecha" class="caja_chica_aplicacion_fecha"><?php echo $caja_chica_aplicacion->fecha->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$caja_chica_aplicacion_delete->RecCnt = 0;
$i = 0;
while (!$caja_chica_aplicacion_delete->Recordset->EOF) {
	$caja_chica_aplicacion_delete->RecCnt++;
	$caja_chica_aplicacion_delete->RowCnt++;

	// Set row properties
	$caja_chica_aplicacion->ResetAttrs();
	$caja_chica_aplicacion->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$caja_chica_aplicacion_delete->LoadRowValues($caja_chica_aplicacion_delete->Recordset);

	// Render row
	$caja_chica_aplicacion_delete->RenderRow();
?>
	<tr<?php echo $caja_chica_aplicacion->RowAttributes() ?>>
<?php if ($caja_chica_aplicacion->idcaja_chica_detalle->Visible) { // idcaja_chica_detalle ?>
		<td<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->CellAttributes() ?>>
<span id="el<?php echo $caja_chica_aplicacion_delete->RowCnt ?>_caja_chica_aplicacion_idcaja_chica_detalle" class="caja_chica_aplicacion_idcaja_chica_detalle">
<span<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idcaja_chica_detalle->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($caja_chica_aplicacion->idreferencia->Visible) { // idreferencia ?>
		<td<?php echo $caja_chica_aplicacion->idreferencia->CellAttributes() ?>>
<span id="el<?php echo $caja_chica_aplicacion_delete->RowCnt ?>_caja_chica_aplicacion_idreferencia" class="caja_chica_aplicacion_idreferencia">
<span<?php echo $caja_chica_aplicacion->idreferencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->idreferencia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($caja_chica_aplicacion->tabla_referencia->Visible) { // tabla_referencia ?>
		<td<?php echo $caja_chica_aplicacion->tabla_referencia->CellAttributes() ?>>
<span id="el<?php echo $caja_chica_aplicacion_delete->RowCnt ?>_caja_chica_aplicacion_tabla_referencia" class="caja_chica_aplicacion_tabla_referencia">
<span<?php echo $caja_chica_aplicacion->tabla_referencia->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->tabla_referencia->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($caja_chica_aplicacion->monto->Visible) { // monto ?>
		<td<?php echo $caja_chica_aplicacion->monto->CellAttributes() ?>>
<span id="el<?php echo $caja_chica_aplicacion_delete->RowCnt ?>_caja_chica_aplicacion_monto" class="caja_chica_aplicacion_monto">
<span<?php echo $caja_chica_aplicacion->monto->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->monto->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($caja_chica_aplicacion->fecha->Visible) { // fecha ?>
		<td<?php echo $caja_chica_aplicacion->fecha->CellAttributes() ?>>
<span id="el<?php echo $caja_chica_aplicacion_delete->RowCnt ?>_caja_chica_aplicacion_fecha" class="caja_chica_aplicacion_fecha">
<span<?php echo $caja_chica_aplicacion->fecha->ViewAttributes() ?>>
<?php echo $caja_chica_aplicacion->fecha->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$caja_chica_aplicacion_delete->Recordset->MoveNext();
}
$caja_chica_aplicacion_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $caja_chica_aplicacion_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fcaja_chica_aplicaciondelete.Init();
</script>
<?php
$caja_chica_aplicacion_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$caja_chica_aplicacion_delete->Page_Terminate();
?>
