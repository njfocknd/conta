<?php

// Global variable for table object
$estado_resultado = NULL;

//
// Table class for estado_resultado
//
class cestado_resultado extends cTable {
	var $idestado_resultado;
	var $idempresa;
	var $idperiodo_contable;
	var $venta_netas;
	var $costo_ventas;
	var $depreciacion;
	var $interes_pagado;
	var $impuestos;
	var $dividendos;
	var $utilidades_retenidas;
	var $utilidad_neta;
	var $estado;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'estado_resultado';
		$this->TableName = 'estado_resultado';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`estado_resultado`";
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

		// idestado_resultado
		$this->idestado_resultado = new cField('estado_resultado', 'estado_resultado', 'x_idestado_resultado', 'idestado_resultado', '`idestado_resultado`', '`idestado_resultado`', 3, -1, FALSE, '`idestado_resultado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idestado_resultado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idestado_resultado'] = &$this->idestado_resultado;

		// idempresa
		$this->idempresa = new cField('estado_resultado', 'estado_resultado', 'x_idempresa', 'idempresa', '`idempresa`', '`idempresa`', 3, -1, FALSE, '`idempresa`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idempresa->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idempresa'] = &$this->idempresa;

		// idperiodo_contable
		$this->idperiodo_contable = new cField('estado_resultado', 'estado_resultado', 'x_idperiodo_contable', 'idperiodo_contable', '`idperiodo_contable`', '`idperiodo_contable`', 3, -1, FALSE, '`idperiodo_contable`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->idperiodo_contable->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idperiodo_contable'] = &$this->idperiodo_contable;

		// venta_netas
		$this->venta_netas = new cField('estado_resultado', 'estado_resultado', 'x_venta_netas', 'venta_netas', '`venta_netas`', '`venta_netas`', 131, -1, FALSE, '`venta_netas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->venta_netas->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['venta_netas'] = &$this->venta_netas;

		// costo_ventas
		$this->costo_ventas = new cField('estado_resultado', 'estado_resultado', 'x_costo_ventas', 'costo_ventas', '`costo_ventas`', '`costo_ventas`', 131, -1, FALSE, '`costo_ventas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->costo_ventas->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['costo_ventas'] = &$this->costo_ventas;

		// depreciacion
		$this->depreciacion = new cField('estado_resultado', 'estado_resultado', 'x_depreciacion', 'depreciacion', '`depreciacion`', '`depreciacion`', 131, -1, FALSE, '`depreciacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->depreciacion->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['depreciacion'] = &$this->depreciacion;

		// interes_pagado
		$this->interes_pagado = new cField('estado_resultado', 'estado_resultado', 'x_interes_pagado', 'interes_pagado', '`interes_pagado`', '`interes_pagado`', 131, -1, FALSE, '`interes_pagado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->interes_pagado->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['interes_pagado'] = &$this->interes_pagado;

		// impuestos
		$this->impuestos = new cField('estado_resultado', 'estado_resultado', 'x_impuestos', 'impuestos', '`impuestos`', '`impuestos`', 131, -1, FALSE, '`impuestos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->impuestos->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['impuestos'] = &$this->impuestos;

		// dividendos
		$this->dividendos = new cField('estado_resultado', 'estado_resultado', 'x_dividendos', 'dividendos', '`dividendos`', '`dividendos`', 131, -1, FALSE, '`dividendos`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dividendos->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['dividendos'] = &$this->dividendos;

		// utilidades_retenidas
		$this->utilidades_retenidas = new cField('estado_resultado', 'estado_resultado', 'x_utilidades_retenidas', 'utilidades_retenidas', '`utilidades_retenidas`', '`utilidades_retenidas`', 131, -1, FALSE, '`utilidades_retenidas`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->utilidades_retenidas->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['utilidades_retenidas'] = &$this->utilidades_retenidas;

		// utilidad_neta
		$this->utilidad_neta = new cField('estado_resultado', 'estado_resultado', 'x_utilidad_neta', 'utilidad_neta', '`utilidad_neta`', '`utilidad_neta`', 131, -1, FALSE, '`utilidad_neta`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->utilidad_neta->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['utilidad_neta'] = &$this->utilidad_neta;

		// estado
		$this->estado = new cField('estado_resultado', 'estado_resultado', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->estado->OptionCount = 2;
		$this->fields['estado'] = &$this->estado;
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
		if ($this->getCurrentDetailTable() == "estado_resultado_detalle") {
			$sDetailUrl = $GLOBALS["estado_resultado_detalle"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_idestado_resultado=" . urlencode($this->idestado_resultado->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "estado_resultadolist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`estado_resultado`";
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
		$this->TableFilter = "`estado`= 'Activo'";
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
			if (array_key_exists('idestado_resultado', $rs))
				ew_AddFilter($where, ew_QuotedName('idestado_resultado', $this->DBID) . '=' . ew_QuotedValue($rs['idestado_resultado'], $this->idestado_resultado->FldDataType, $this->DBID));
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
		return "`idestado_resultado` = @idestado_resultado@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idestado_resultado->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idestado_resultado@", ew_AdjustSql($this->idestado_resultado->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "estado_resultadolist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "estado_resultadolist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("estado_resultadoview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("estado_resultadoview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "estado_resultadoadd.php?" . $this->UrlParm($parm);
		else
			$url = "estado_resultadoadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("estado_resultadoedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("estado_resultadoedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("estado_resultadoadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("estado_resultadoadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("estado_resultadodelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "idestado_resultado:" . ew_VarToJson($this->idestado_resultado->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idestado_resultado->CurrentValue)) {
			$sUrl .= "idestado_resultado=" . urlencode($this->idestado_resultado->CurrentValue);
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
			if ($isPost && isset($_POST["idestado_resultado"]))
				$arKeys[] = ew_StripSlashes($_POST["idestado_resultado"]);
			elseif (isset($_GET["idestado_resultado"]))
				$arKeys[] = ew_StripSlashes($_GET["idestado_resultado"]);
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
			$this->idestado_resultado->CurrentValue = $key;
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
		$this->idestado_resultado->setDbValue($rs->fields('idestado_resultado'));
		$this->idempresa->setDbValue($rs->fields('idempresa'));
		$this->idperiodo_contable->setDbValue($rs->fields('idperiodo_contable'));
		$this->venta_netas->setDbValue($rs->fields('venta_netas'));
		$this->costo_ventas->setDbValue($rs->fields('costo_ventas'));
		$this->depreciacion->setDbValue($rs->fields('depreciacion'));
		$this->interes_pagado->setDbValue($rs->fields('interes_pagado'));
		$this->impuestos->setDbValue($rs->fields('impuestos'));
		$this->dividendos->setDbValue($rs->fields('dividendos'));
		$this->utilidades_retenidas->setDbValue($rs->fields('utilidades_retenidas'));
		$this->utilidad_neta->setDbValue($rs->fields('utilidad_neta'));
		$this->estado->setDbValue($rs->fields('estado'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idestado_resultado
		// idempresa
		// idperiodo_contable
		// venta_netas
		// costo_ventas
		// depreciacion
		// interes_pagado
		// impuestos
		// dividendos
		// utilidades_retenidas
		// utilidad_neta
		// estado
		// idestado_resultado

		$this->idestado_resultado->ViewValue = $this->idestado_resultado->CurrentValue;
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idempresa
		if (strval($this->idempresa->CurrentValue) <> "") {
			$sFilterWrk = "`idempresa`" . ew_SearchString("=", $this->idempresa->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `idempresa`, `ticker` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `empresa`";
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

		// venta_netas
		$this->venta_netas->ViewValue = $this->venta_netas->CurrentValue;
		$this->venta_netas->ViewCustomAttributes = "";

		// costo_ventas
		$this->costo_ventas->ViewValue = $this->costo_ventas->CurrentValue;
		$this->costo_ventas->ViewCustomAttributes = "";

		// depreciacion
		$this->depreciacion->ViewValue = $this->depreciacion->CurrentValue;
		$this->depreciacion->ViewCustomAttributes = "";

		// interes_pagado
		$this->interes_pagado->ViewValue = $this->interes_pagado->CurrentValue;
		$this->interes_pagado->ViewCustomAttributes = "";

		// impuestos
		$this->impuestos->ViewValue = $this->impuestos->CurrentValue;
		$this->impuestos->ViewCustomAttributes = "";

		// dividendos
		$this->dividendos->ViewValue = $this->dividendos->CurrentValue;
		$this->dividendos->ViewCustomAttributes = "";

		// utilidades_retenidas
		$this->utilidades_retenidas->ViewValue = $this->utilidades_retenidas->CurrentValue;
		$this->utilidades_retenidas->ViewCustomAttributes = "";

		// utilidad_neta
		$this->utilidad_neta->ViewValue = $this->utilidad_neta->CurrentValue;
		$this->utilidad_neta->ViewCustomAttributes = "";

		// estado
		if (strval($this->estado->CurrentValue) <> "") {
			$this->estado->ViewValue = $this->estado->OptionCaption($this->estado->CurrentValue);
		} else {
			$this->estado->ViewValue = NULL;
		}
		$this->estado->ViewCustomAttributes = "";

		// idestado_resultado
		$this->idestado_resultado->LinkCustomAttributes = "";
		$this->idestado_resultado->HrefValue = "";
		$this->idestado_resultado->TooltipValue = "";

		// idempresa
		$this->idempresa->LinkCustomAttributes = "";
		$this->idempresa->HrefValue = "";
		$this->idempresa->TooltipValue = "";

		// idperiodo_contable
		$this->idperiodo_contable->LinkCustomAttributes = "";
		$this->idperiodo_contable->HrefValue = "";
		$this->idperiodo_contable->TooltipValue = "";

		// venta_netas
		$this->venta_netas->LinkCustomAttributes = "";
		$this->venta_netas->HrefValue = "";
		$this->venta_netas->TooltipValue = "";

		// costo_ventas
		$this->costo_ventas->LinkCustomAttributes = "";
		$this->costo_ventas->HrefValue = "";
		$this->costo_ventas->TooltipValue = "";

		// depreciacion
		$this->depreciacion->LinkCustomAttributes = "";
		$this->depreciacion->HrefValue = "";
		$this->depreciacion->TooltipValue = "";

		// interes_pagado
		$this->interes_pagado->LinkCustomAttributes = "";
		$this->interes_pagado->HrefValue = "";
		$this->interes_pagado->TooltipValue = "";

		// impuestos
		$this->impuestos->LinkCustomAttributes = "";
		$this->impuestos->HrefValue = "";
		$this->impuestos->TooltipValue = "";

		// dividendos
		$this->dividendos->LinkCustomAttributes = "";
		$this->dividendos->HrefValue = "";
		$this->dividendos->TooltipValue = "";

		// utilidades_retenidas
		$this->utilidades_retenidas->LinkCustomAttributes = "";
		$this->utilidades_retenidas->HrefValue = "";
		$this->utilidades_retenidas->TooltipValue = "";

		// utilidad_neta
		$this->utilidad_neta->LinkCustomAttributes = "";
		$this->utilidad_neta->HrefValue = "";
		$this->utilidad_neta->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idestado_resultado
		$this->idestado_resultado->EditAttrs["class"] = "form-control";
		$this->idestado_resultado->EditCustomAttributes = "";
		$this->idestado_resultado->EditValue = $this->idestado_resultado->CurrentValue;
		$this->idestado_resultado->ViewCustomAttributes = "";

		// idempresa
		$this->idempresa->EditAttrs["class"] = "form-control";
		$this->idempresa->EditCustomAttributes = "";

		// idperiodo_contable
		$this->idperiodo_contable->EditAttrs["class"] = "form-control";
		$this->idperiodo_contable->EditCustomAttributes = "";

		// venta_netas
		$this->venta_netas->EditAttrs["class"] = "form-control";
		$this->venta_netas->EditCustomAttributes = "";
		$this->venta_netas->EditValue = $this->venta_netas->CurrentValue;
		$this->venta_netas->PlaceHolder = ew_RemoveHtml($this->venta_netas->FldCaption());
		if (strval($this->venta_netas->EditValue) <> "" && is_numeric($this->venta_netas->EditValue)) $this->venta_netas->EditValue = ew_FormatNumber($this->venta_netas->EditValue, -2, -1, -2, 0);

		// costo_ventas
		$this->costo_ventas->EditAttrs["class"] = "form-control";
		$this->costo_ventas->EditCustomAttributes = "";
		$this->costo_ventas->EditValue = $this->costo_ventas->CurrentValue;
		$this->costo_ventas->PlaceHolder = ew_RemoveHtml($this->costo_ventas->FldCaption());
		if (strval($this->costo_ventas->EditValue) <> "" && is_numeric($this->costo_ventas->EditValue)) $this->costo_ventas->EditValue = ew_FormatNumber($this->costo_ventas->EditValue, -2, -1, -2, 0);

		// depreciacion
		$this->depreciacion->EditAttrs["class"] = "form-control";
		$this->depreciacion->EditCustomAttributes = "";
		$this->depreciacion->EditValue = $this->depreciacion->CurrentValue;
		$this->depreciacion->PlaceHolder = ew_RemoveHtml($this->depreciacion->FldCaption());
		if (strval($this->depreciacion->EditValue) <> "" && is_numeric($this->depreciacion->EditValue)) $this->depreciacion->EditValue = ew_FormatNumber($this->depreciacion->EditValue, -2, -1, -2, 0);

		// interes_pagado
		$this->interes_pagado->EditAttrs["class"] = "form-control";
		$this->interes_pagado->EditCustomAttributes = "";
		$this->interes_pagado->EditValue = $this->interes_pagado->CurrentValue;
		$this->interes_pagado->PlaceHolder = ew_RemoveHtml($this->interes_pagado->FldCaption());
		if (strval($this->interes_pagado->EditValue) <> "" && is_numeric($this->interes_pagado->EditValue)) $this->interes_pagado->EditValue = ew_FormatNumber($this->interes_pagado->EditValue, -2, -1, -2, 0);

		// impuestos
		$this->impuestos->EditAttrs["class"] = "form-control";
		$this->impuestos->EditCustomAttributes = "";
		$this->impuestos->EditValue = $this->impuestos->CurrentValue;
		$this->impuestos->PlaceHolder = ew_RemoveHtml($this->impuestos->FldCaption());
		if (strval($this->impuestos->EditValue) <> "" && is_numeric($this->impuestos->EditValue)) $this->impuestos->EditValue = ew_FormatNumber($this->impuestos->EditValue, -2, -1, -2, 0);

		// dividendos
		$this->dividendos->EditAttrs["class"] = "form-control";
		$this->dividendos->EditCustomAttributes = "";
		$this->dividendos->EditValue = $this->dividendos->CurrentValue;
		$this->dividendos->PlaceHolder = ew_RemoveHtml($this->dividendos->FldCaption());
		if (strval($this->dividendos->EditValue) <> "" && is_numeric($this->dividendos->EditValue)) $this->dividendos->EditValue = ew_FormatNumber($this->dividendos->EditValue, -2, -1, -2, 0);

		// utilidades_retenidas
		$this->utilidades_retenidas->EditAttrs["class"] = "form-control";
		$this->utilidades_retenidas->EditCustomAttributes = "";
		$this->utilidades_retenidas->EditValue = $this->utilidades_retenidas->CurrentValue;
		$this->utilidades_retenidas->PlaceHolder = ew_RemoveHtml($this->utilidades_retenidas->FldCaption());
		if (strval($this->utilidades_retenidas->EditValue) <> "" && is_numeric($this->utilidades_retenidas->EditValue)) $this->utilidades_retenidas->EditValue = ew_FormatNumber($this->utilidades_retenidas->EditValue, -2, -1, -2, 0);

		// utilidad_neta
		$this->utilidad_neta->EditAttrs["class"] = "form-control";
		$this->utilidad_neta->EditCustomAttributes = "";
		$this->utilidad_neta->EditValue = $this->utilidad_neta->CurrentValue;
		$this->utilidad_neta->PlaceHolder = ew_RemoveHtml($this->utilidad_neta->FldCaption());
		if (strval($this->utilidad_neta->EditValue) <> "" && is_numeric($this->utilidad_neta->EditValue)) $this->utilidad_neta->EditValue = ew_FormatNumber($this->utilidad_neta->EditValue, -2, -1, -2, 0);

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$this->estado->EditValue = $this->estado->Options(TRUE);

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
					if ($this->idestado_resultado->Exportable) $Doc->ExportCaption($this->idestado_resultado);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->venta_netas->Exportable) $Doc->ExportCaption($this->venta_netas);
					if ($this->costo_ventas->Exportable) $Doc->ExportCaption($this->costo_ventas);
					if ($this->depreciacion->Exportable) $Doc->ExportCaption($this->depreciacion);
					if ($this->interes_pagado->Exportable) $Doc->ExportCaption($this->interes_pagado);
					if ($this->impuestos->Exportable) $Doc->ExportCaption($this->impuestos);
					if ($this->dividendos->Exportable) $Doc->ExportCaption($this->dividendos);
					if ($this->utilidades_retenidas->Exportable) $Doc->ExportCaption($this->utilidades_retenidas);
					if ($this->utilidad_neta->Exportable) $Doc->ExportCaption($this->utilidad_neta);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
				} else {
					if ($this->idestado_resultado->Exportable) $Doc->ExportCaption($this->idestado_resultado);
					if ($this->idempresa->Exportable) $Doc->ExportCaption($this->idempresa);
					if ($this->idperiodo_contable->Exportable) $Doc->ExportCaption($this->idperiodo_contable);
					if ($this->venta_netas->Exportable) $Doc->ExportCaption($this->venta_netas);
					if ($this->costo_ventas->Exportable) $Doc->ExportCaption($this->costo_ventas);
					if ($this->depreciacion->Exportable) $Doc->ExportCaption($this->depreciacion);
					if ($this->interes_pagado->Exportable) $Doc->ExportCaption($this->interes_pagado);
					if ($this->impuestos->Exportable) $Doc->ExportCaption($this->impuestos);
					if ($this->dividendos->Exportable) $Doc->ExportCaption($this->dividendos);
					if ($this->utilidades_retenidas->Exportable) $Doc->ExportCaption($this->utilidades_retenidas);
					if ($this->utilidad_neta->Exportable) $Doc->ExportCaption($this->utilidad_neta);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
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
						if ($this->idestado_resultado->Exportable) $Doc->ExportField($this->idestado_resultado);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->venta_netas->Exportable) $Doc->ExportField($this->venta_netas);
						if ($this->costo_ventas->Exportable) $Doc->ExportField($this->costo_ventas);
						if ($this->depreciacion->Exportable) $Doc->ExportField($this->depreciacion);
						if ($this->interes_pagado->Exportable) $Doc->ExportField($this->interes_pagado);
						if ($this->impuestos->Exportable) $Doc->ExportField($this->impuestos);
						if ($this->dividendos->Exportable) $Doc->ExportField($this->dividendos);
						if ($this->utilidades_retenidas->Exportable) $Doc->ExportField($this->utilidades_retenidas);
						if ($this->utilidad_neta->Exportable) $Doc->ExportField($this->utilidad_neta);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
					} else {
						if ($this->idestado_resultado->Exportable) $Doc->ExportField($this->idestado_resultado);
						if ($this->idempresa->Exportable) $Doc->ExportField($this->idempresa);
						if ($this->idperiodo_contable->Exportable) $Doc->ExportField($this->idperiodo_contable);
						if ($this->venta_netas->Exportable) $Doc->ExportField($this->venta_netas);
						if ($this->costo_ventas->Exportable) $Doc->ExportField($this->costo_ventas);
						if ($this->depreciacion->Exportable) $Doc->ExportField($this->depreciacion);
						if ($this->interes_pagado->Exportable) $Doc->ExportField($this->interes_pagado);
						if ($this->impuestos->Exportable) $Doc->ExportField($this->impuestos);
						if ($this->dividendos->Exportable) $Doc->ExportField($this->dividendos);
						if ($this->utilidades_retenidas->Exportable) $Doc->ExportField($this->utilidades_retenidas);
						if ($this->utilidad_neta->Exportable) $Doc->ExportField($this->utilidad_neta);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
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
