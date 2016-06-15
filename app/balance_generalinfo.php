<?php

// Global variable for table object
$balance_general = NULL;

//
// Table class for balance_general
//
class cbalance_general extends cTable {
	var $idbalance_general;
	var $idempresa;
	var $idperiodo_contable;
	var $activo_circulante;
	var $activo_fijo;
	var $pasivo_circulante;
	var $pasivo_fijo;
	var $capital_contable;
	var $estado;
	var $fecha_insercion;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'balance_general';
		$this->TableName = 'balance_general';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`balance_general`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// idbalance_general
		$this->idbalance_general = new cField('balance_general', 'balance_general', 'x_idbalance_general', 'idbalance_general', '`idbalance_general`', '`idbalance_general`', 3, -1, FALSE, '`idbalance_general`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idbalance_general->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idbalance_general'] = &$this->idbalance_general;

		// idempresa
		$this->idempresa = new cField('balance_general', 'balance_general', 'x_idempresa', 'idempresa', '`idempresa`', '`idempresa`', 3, -1, FALSE, '`idempresa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idempresa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idempresa'] = &$this->idempresa;

		// idperiodo_contable
		$this->idperiodo_contable = new cField('balance_general', 'balance_general', 'x_idperiodo_contable', 'idperiodo_contable', '`idperiodo_contable`', '`idperiodo_contable`', 3, -1, FALSE, '`idperiodo_contable`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idperiodo_contable->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idperiodo_contable'] = &$this->idperiodo_contable;

		// activo_circulante
		$this->activo_circulante = new cField('balance_general', 'balance_general', 'x_activo_circulante', 'activo_circulante', '`activo_circulante`', '`activo_circulante`', 131, -1, FALSE, '`activo_circulante`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_circulante->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['activo_circulante'] = &$this->activo_circulante;

		// activo_fijo
		$this->activo_fijo = new cField('balance_general', 'balance_general', 'x_activo_fijo', 'activo_fijo', '`activo_fijo`', '`activo_fijo`', 131, -1, FALSE, '`activo_fijo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->activo_fijo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['activo_fijo'] = &$this->activo_fijo;

		// pasivo_circulante
		$this->pasivo_circulante = new cField('balance_general', 'balance_general', 'x_pasivo_circulante', 'pasivo_circulante', '`pasivo_circulante`', '`pasivo_circulante`', 131, -1, FALSE, '`pasivo_circulante`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasivo_circulante->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pasivo_circulante'] = &$this->pasivo_circulante;

		// pasivo_fijo
		$this->pasivo_fijo = new cField('balance_general', 'balance_general', 'x_pasivo_fijo', 'pasivo_fijo', '`pasivo_fijo`', '`pasivo_fijo`', 131, -1, FALSE, '`pasivo_fijo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->pasivo_fijo->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['pasivo_fijo'] = &$this->pasivo_fijo;

		// capital_contable
		$this->capital_contable = new cField('balance_general', 'balance_general', 'x_capital_contable', 'capital_contable', '`capital_contable`', '`capital_contable`', 131, -1, FALSE, '`capital_contable`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->capital_contable->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['capital_contable'] = &$this->capital_contable;

		// estado
		$this->estado = new cField('balance_general', 'balance_general', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->estado->OptionCount = 2;
		$this->fields['estado'] = &$this->estado;

		// fecha_insercion
		$this->fecha_insercion = new cField('balance_general', 'balance_general', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "empresa") {
			if ($this->idempresa->getSessionValue() <> "")
				$sMasterFilter .= "`idempresa`=" . ew_QuotedValue($this->idempresa->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "empresa") {
			if ($this->idempresa->getSessionValue() <> "")
				$sDetailFilter .= "`idempresa`=" . ew_QuotedValue($this->idempresa->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_empresa() {
		return "`idempresa`=@idempresa@";
	}

	// Detail filter
	function SqlDetailFilter_empresa() {
		return "`idempresa`=@idempresa@";
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "balance_general_detalle") {
			$sDetailUrl = $GLOBALS["balance_general_detalle"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_idbalance_general=" . urlencode($this->idbalance_general->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "balance_generallist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`balance_general`";
	}

	function SqlFrom() { // For backward compatibility
    	return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
    	$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
    	return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
    	$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
    	return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
    	$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
    	return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
    	$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
    	return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
    	$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
    	return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
    	$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('idbalance_general', $rs))
				ew_AddFilter($where, ew_QuotedName('idbalance_general', $this->DBID) . '=' . ew_QuotedValue($rs['idbalance_general'], $this->idbalance_general->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`idbalance_general` = @idbalance_general@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idbalance_general->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idbalance_general@", ew_AdjustSql($this->idbalance_general->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "balance_generallist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "balance_generallist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("balance_generalview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("balance_generalview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "balance_generaladd.php?" . $this->UrlParm($parm);
		else
			$url = "balance_generaladd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("balance_generaledit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("balance_generaledit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("balance_generaladd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("balance_generaladd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("balance_generaldelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "empresa" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idempresa=" . urlencode($this->idempresa->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "idbalance_general:" . ew_VarToJson($this->idbalance_general->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idbalance_general->CurrentValue)) {
			$sUrl .= "idbalance_general=" . urlencode($this->idbalance_general->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["idbalance_general"]))
				$arKeys[] = ew_StripSlashes($_POST["idbalance_general"]);
			elseif (isset($_GET["idbalance_general"]))
				$arKeys[] = ew_StripSlashes($_GET["idbalance_general"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->idbalance_general->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->idbalance_general->setDbValue($rs->fields('idbalance_general'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->activo_circulante->setDbValue($rs->fields('activo_circulante'));
		$this->activo_fijo->setDbValue($rs->fields('activo_fijo'));
		$this->pasivo_circulante->setDbValue($rs->fields('pasivo_circulante'));
		$this->pasivo_fijo->setDbValue($rs->fields('pasivo_fijo'));
		$this->capital_contable->setDbValue($rs->fields('capital_contable'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idbalance_general
		// idempresa
		// idperiodo_contable
		// activo_circulante
		// activo_fijo
		// pasivo_circulante
		// pasivo_fijo
		// capital_contable
		// estado
		// fecha_insercion
		// idbalance_general

		$this->idbalance_general->ViewValue = $this->idbalance_general->CurrentValue;
		$this->idbalance_general->ViewCustomAttributes = "";

		// idempresa
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
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

		// idperiodo_contable
		if (strval($this->idperiodo_contable->CurrentValue) <> "") {
			$sFilterWrk = "`idperiodo_contable`" . ew_SearchString("=", $this->idperiodo_contable->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idperiodo_contable`, `nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `periodo_contable`";
		$sWhereWrk = "";
		$lookuptblfilter = "`estado` = 'Activo'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->idperiodo_contable, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->idperiodo_contable->ViewValue = $this->idperiodo_contable->CurrentValue;
			}
		} else {
			$this->idperiodo_contable->ViewValue = NULL;
		}
		$this->idperiodo_contable->ViewCustomAttributes = "";

		// activo_circulante
		$this->activo_circulante->ViewValue = $this->activo_circulante->CurrentValue;
		$this->activo_circulante->ViewCustomAttributes = "";

		// activo_fijo
		$this->activo_fijo->ViewValue = $this->activo_fijo->CurrentValue;
		$this->activo_fijo->ViewCustomAttributes = "";

		// pasivo_circulante
		$this->pasivo_circulante->ViewValue = $this->pasivo_circulante->CurrentValue;
		$this->pasivo_circulante->ViewCustomAttributes = "";

		// pasivo_fijo
		$this->pasivo_fijo->ViewValue = $this->pasivo_fijo->CurrentValue;
		$this->pasivo_fijo->ViewCustomAttributes = "";

		// capital_contable
		$this->capital_contable->ViewValue = $this->capital_contable->CurrentValue;
		$this->capital_contable->ViewCustomAttributes = "";

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

		// idbalance_general
		$this->idbalance_general->LinkCustomAttributes = "";
		$this->idbalance_general->HrefValue = "";
		$this->idbalance_general->TooltipValue = "";

		// idempresa
		$this->idempresa->LinkCustomAttributes = "";
		$this->idempresa->HrefValue = "";
		$this->idempresa->TooltipValue = "";

		// idperiodo_contable
		$this->idperiodo_contable->LinkCustomAttributes = "";
		$this->idperiodo_contable->HrefValue = "";
		$this->idperiodo_contable->TooltipValue = "";

		// activo_circulante
		$this->activo_circulante->LinkCustomAttributes = "";
		$this->activo_circulante->HrefValue = "";
		$this->activo_circulante->TooltipValue = "";

		// activo_fijo
		$this->activo_fijo->LinkCustomAttributes = "";
		$this->activo_fijo->HrefValue = "";
		$this->activo_fijo->TooltipValue = "";

		// pasivo_circulante
		$this->pasivo_circulante->LinkCustomAttributes = "";
		$this->pasivo_circulante->HrefValue = "";
		$this->pasivo_circulante->TooltipValue = "";

		// pasivo_fijo
		$this->pasivo_fijo->LinkCustomAttributes = "";
		$this->pasivo_fijo->HrefValue = "";
		$this->pasivo_fijo->TooltipValue = "";

		// capital_contable
		$this->capital_contable->LinkCustomAttributes = "";
		$this->capital_contable->HrefValue = "";
		$this->capital_contable->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idbalance_general
		$this->idbalance_general->EditAttrs["class"] = "form-control";
		$this->idbalance_general->EditCustomAttributes = "";
		$this->idbalance_general->EditValue = $this->idbalance_general->CurrentValue;
		$this->idbalance_general->ViewCustomAttributes = "";

		// idempresa
		$this->idempresa->EditAttrs["class"] = "form-control";
		$this->idempresa->EditCustomAttributes = "";
		if ($this->idempresa->getSessionValue() <> "") {
			$this->idempresa->CurrentValue = $this->idempresa->getSessionValue();
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
		$sWhereWrk = "";
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
		} else {
		}

		// idperiodo_contable
		$this->idperiodo_contable->EditAttrs["class"] = "form-control";
		$this->idperiodo_contable->EditCustomAttributes = "";

		// activo_circulante
		$this->activo_circulante->EditAttrs["class"] = "form-control";
		$this->activo_circulante->EditCustomAttributes = "";
		$this->activo_circulante->EditValue = $this->activo_circulante->CurrentValue;
		$this->activo_circulante->PlaceHolder = ew_RemoveHtml($this->activo_circulante->FldCaption());
		if (strval($this->activo_circulante->EditValue) <> "" && is_numeric($this->activo_circulante->EditValue)) $this->activo_circulante->EditValue = ew_FormatNumber($this->activo_circulante->EditValue, -2, -1, -2, 0);

		// activo_fijo
		$this->activo_fijo->EditAttrs["class"] = "form-control";
		$this->activo_fijo->EditCustomAttributes = "";
		$this->activo_fijo->EditValue = $this->activo_fijo->CurrentValue;
		$this->activo_fijo->PlaceHolder = ew_RemoveHtml($this->activo_fijo->FldCaption());
		if (strval($this->activo_fijo->EditValue) <> "" && is_numeric($this->activo_fijo->EditValue)) $this->activo_fijo->EditValue = ew_FormatNumber($this->activo_fijo->EditValue, -2, -1, -2, 0);

		// pasivo_circulante
		$this->pasivo_circulante->EditAttrs["class"] = "form-control";
		$this->pasivo_circulante->EditCustomAttributes = "";
		$this->pasivo_circulante->EditValue = $this->pasivo_circulante->CurrentValue;
		$this->pasivo_circulante->PlaceHolder = ew_RemoveHtml($this->pasivo_circulante->FldCaption());
		if (strval($this->pasivo_circulante->EditValue) <> "" && is_numeric($this->pasivo_circulante->EditValue)) $this->pasivo_circulante->EditValue = ew_FormatNumber($this->pasivo_circulante->EditValue, -2, -1, -2, 0);

		// pasivo_fijo
		$this->pasivo_fijo->EditAttrs["class"] = "form-control";
		$this->pasivo_fijo->EditCustomAttributes = "";
		$this->pasivo_fijo->EditValue = $this->pasivo_fijo->CurrentValue;
		$this->pasivo_fijo->PlaceHolder = ew_RemoveHtml($this->pasivo_fijo->FldCaption());
		if (strval($this->pasivo_fijo->EditValue) <> "" && is_numeric($this->pasivo_fijo->EditValue)) $this->pasivo_fijo->EditValue = ew_FormatNumber($this->pasivo_fijo->EditValue, -2, -1, -2, 0);

		// capital_contable
		$this->capital_contable->EditAttrs["class"] = "form-control";
		$this->capital_contable->EditCustomAttributes = "";
		$this->capital_contable->EditValue = $this->capital_contable->CurrentValue;
		$this->capital_contable->PlaceHolder = ew_RemoveHtml($this->capital_contable->FldCaption());
		if (strval($this->capital_contable->EditValue) <> "" && is_numeric($this->capital_contable->EditValue)) $this->capital_contable->EditValue = ew_FormatNumber($this->capital_contable->EditValue, -2, -1, -2, 0);

		// estado
		$this->estado->EditCustomAttributes = "";
		$this->estado->EditValue = $this->estado->Options(FALSE);

		// fecha_insercion
		$this->fecha_insercion->EditAttrs["class"] = "form-control";
		$this->fecha_insercion->EditCustomAttributes = "";
		$this->fecha_insercion->EditValue = ew_FormatDateTime($this->fecha_insercion->CurrentValue, 7);
		$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->idbalance_general->Exportable) $Doc->ExportCaption($this->idbalance_general);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->activo_circulante->Exportable) $Doc->ExportCaption($this->activo_circulante);
					if ($this->activo_fijo->Exportable) $Doc->ExportCaption($this->activo_fijo);
					if ($this->pasivo_circulante->Exportable) $Doc->ExportCaption($this->pasivo_circulante);
					if ($this->pasivo_fijo->Exportable) $Doc->ExportCaption($this->pasivo_fijo);
					if ($this->capital_contable->Exportable) $Doc->ExportCaption($this->capital_contable);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				} else {
					if ($this->idbalance_general->Exportable) $Doc->ExportCaption($this->idbalance_general);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->activo_circulante->Exportable) $Doc->ExportCaption($this->activo_circulante);
					if ($this->activo_fijo->Exportable) $Doc->ExportCaption($this->activo_fijo);
					if ($this->pasivo_circulante->Exportable) $Doc->ExportCaption($this->pasivo_circulante);
					if ($this->pasivo_fijo->Exportable) $Doc->ExportCaption($this->pasivo_fijo);
					if ($this->capital_contable->Exportable) $Doc->ExportCaption($this->capital_contable);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->idbalance_general->Exportable) $Doc->ExportField($this->idbalance_general);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->activo_circulante->Exportable) $Doc->ExportField($this->activo_circulante);
						if ($this->activo_fijo->Exportable) $Doc->ExportField($this->activo_fijo);
						if ($this->pasivo_circulante->Exportable) $Doc->ExportField($this->pasivo_circulante);
						if ($this->pasivo_fijo->Exportable) $Doc->ExportField($this->pasivo_fijo);
						if ($this->capital_contable->Exportable) $Doc->ExportField($this->capital_contable);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					} else {
						if ($this->idbalance_general->Exportable) $Doc->ExportField($this->idbalance_general);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->activo_circulante->Exportable) $Doc->ExportField($this->activo_circulante);
						if ($this->activo_fijo->Exportable) $Doc->ExportField($this->activo_fijo);
						if ($this->pasivo_circulante->Exportable) $Doc->ExportField($this->pasivo_circulante);
						if ($this->pasivo_fijo->Exportable) $Doc->ExportField($this->pasivo_fijo);
						if ($this->capital_contable->Exportable) $Doc->ExportField($this->capital_contable);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
