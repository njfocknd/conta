<?php

// Global variable for table object
$caja_chica_detalle = NULL;

//
// Table class for caja_chica_detalle
//
class ccaja_chica_detalle extends cTable {
	var $idcaja_chica_detalle;
	var $idcaja_chica;
	var $tipo;
	var $fecha;
	var $monto;
	var $monto_aplicado;
	var $fecha_insercion;
	var $estado;
	var $descripcion;
	var $idreferencia;
	var $tabla_referencia;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'caja_chica_detalle';
		$this->TableName = 'caja_chica_detalle';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`caja_chica_detalle`";
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

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_idcaja_chica_detalle', 'idcaja_chica_detalle', '`idcaja_chica_detalle`', '`idcaja_chica_detalle`', 3, -1, FALSE, '`idcaja_chica_detalle`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->idcaja_chica_detalle->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcaja_chica_detalle'] = &$this->idcaja_chica_detalle;

		// idcaja_chica
		$this->idcaja_chica = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_idcaja_chica', 'idcaja_chica', '`idcaja_chica`', '`idcaja_chica`', 3, -1, FALSE, '`idcaja_chica`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idcaja_chica->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idcaja_chica'] = &$this->idcaja_chica;

		// tipo
		$this->tipo = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_tipo', 'tipo', '`tipo`', '`tipo`', 202, -1, FALSE, '`tipo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->tipo->OptionCount = 2;
		$this->fields['tipo'] = &$this->tipo;

		// fecha
		$this->fecha = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_fecha', 'fecha', '`fecha`', 'DATE_FORMAT(`fecha`, \'%d/%m/%Y\')', 133, 7, FALSE, '`fecha`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha'] = &$this->fecha;

		// monto
		$this->monto = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_monto', 'monto', '`monto`', '`monto`', 131, -1, FALSE, '`monto`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->monto->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto'] = &$this->monto;

		// monto_aplicado
		$this->monto_aplicado = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_monto_aplicado', 'monto_aplicado', '`monto_aplicado`', '`monto_aplicado`', 131, -1, FALSE, '`monto_aplicado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->monto_aplicado->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['monto_aplicado'] = &$this->monto_aplicado;

		// fecha_insercion
		$this->fecha_insercion = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_fecha_insercion', 'fecha_insercion', '`fecha_insercion`', 'DATE_FORMAT(`fecha_insercion`, \'%d/%m/%Y\')', 135, 7, FALSE, '`fecha_insercion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fecha_insercion->FldDefaultErrMsg = str_replace("%s", "/", $Language->Phrase("IncorrectDateDMY"));
		$this->fields['fecha_insercion'] = &$this->fecha_insercion;

		// estado
		$this->estado = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_estado', 'estado', '`estado`', '`estado`', 202, -1, FALSE, '`estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->estado->OptionCount = 2;
		$this->fields['estado'] = &$this->estado;

		// descripcion
		$this->descripcion = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_descripcion', 'descripcion', '`descripcion`', '`descripcion`', 200, -1, FALSE, '`descripcion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['descripcion'] = &$this->descripcion;

		// idreferencia
		$this->idreferencia = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_idreferencia', 'idreferencia', '`idreferencia`', '`idreferencia`', 3, -1, FALSE, '`idreferencia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->idreferencia->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['idreferencia'] = &$this->idreferencia;

		// tabla_referencia
		$this->tabla_referencia = new cField('caja_chica_detalle', 'caja_chica_detalle', 'x_tabla_referencia', 'tabla_referencia', '`tabla_referencia`', '`tabla_referencia`', 200, -1, FALSE, '`tabla_referencia`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->fields['tabla_referencia'] = &$this->tabla_referencia;
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
		if ($this->getCurrentMasterTable() == "caja_chica") {
			if ($this->idcaja_chica->getSessionValue() <> "")
				$sMasterFilter .= "`idcaja_chica`=" . ew_QuotedValue($this->idcaja_chica->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "caja_chica") {
			if ($this->idcaja_chica->getSessionValue() <> "")
				$sDetailFilter .= "`idcaja_chica`=" . ew_QuotedValue($this->idcaja_chica->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_caja_chica() {
		return "`idcaja_chica`=@idcaja_chica@";
	}

	// Detail filter
	function SqlDetailFilter_caja_chica() {
		return "`idcaja_chica`=@idcaja_chica@";
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
		if ($this->getCurrentDetailTable() == "caja_chica_aplicacion") {
			$sDetailUrl = $GLOBALS["caja_chica_aplicacion"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_idcaja_chica_detalle=" . urlencode($this->idcaja_chica_detalle->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "caja_chica_detallelist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`caja_chica_detalle`";
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

		// Cascade Update detail table 'caja_chica_aplicacion'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['idcaja_chica_detalle']) && $rsold['idcaja_chica_detalle'] <> $rs['idcaja_chica_detalle'])) { // Update detail field 'idcaja_chica_detalle'
			$bCascadeUpdate = TRUE;
			$rscascade['idcaja_chica_detalle'] = $rs['idcaja_chica_detalle']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["caja_chica_aplicacion"])) $GLOBALS["caja_chica_aplicacion"] = new ccaja_chica_aplicacion();
			$rswrk = $GLOBALS["caja_chica_aplicacion"]->LoadRs("`idcaja_chica_detalle` = " . ew_QuotedValue($rsold['idcaja_chica_detalle'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$GLOBALS["caja_chica_aplicacion"]->Update($rscascade, "`idcaja_chica_detalle` = " . ew_QuotedValue($rsold['idcaja_chica_detalle'], EW_DATATYPE_NUMBER, 'DB'), $rswrk->fields);
				$rswrk->MoveNext();
			}
		}
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('idcaja_chica_detalle', $rs))
				ew_AddFilter($where, ew_QuotedName('idcaja_chica_detalle', $this->DBID) . '=' . ew_QuotedValue($rs['idcaja_chica_detalle'], $this->idcaja_chica_detalle->FldDataType, $this->DBID));
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

		// Cascade delete detail table 'caja_chica_aplicacion'
		if (!isset($GLOBALS["caja_chica_aplicacion"])) $GLOBALS["caja_chica_aplicacion"] = new ccaja_chica_aplicacion();
		$rscascade = $GLOBALS["caja_chica_aplicacion"]->LoadRs("`idcaja_chica_detalle` = " . ew_QuotedValue($rs['idcaja_chica_detalle'], EW_DATATYPE_NUMBER, "DB")); 
		while ($rscascade && !$rscascade->EOF) {
			$GLOBALS["caja_chica_aplicacion"]->Delete($rscascade->fields);
			$rscascade->MoveNext();
		}
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`idcaja_chica_detalle` = @idcaja_chica_detalle@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->idcaja_chica_detalle->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@idcaja_chica_detalle@", ew_AdjustSql($this->idcaja_chica_detalle->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "caja_chica_detallelist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "caja_chica_detallelist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("caja_chica_detalleview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("caja_chica_detalleview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "caja_chica_detalleadd.php?" . $this->UrlParm($parm);
		else
			$url = "caja_chica_detalleadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("caja_chica_detalleedit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("caja_chica_detalleedit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
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
			$url = $this->KeyUrl("caja_chica_detalleadd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("caja_chica_detalleadd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("caja_chica_detalledelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "caja_chica" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_idcaja_chica=" . urlencode($this->idcaja_chica->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "idcaja_chica_detalle:" . ew_VarToJson($this->idcaja_chica_detalle->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->idcaja_chica_detalle->CurrentValue)) {
			$sUrl .= "idcaja_chica_detalle=" . urlencode($this->idcaja_chica_detalle->CurrentValue);
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
			if ($isPost && isset($_POST["idcaja_chica_detalle"]))
				$arKeys[] = ew_StripSlashes($_POST["idcaja_chica_detalle"]);
			elseif (isset($_GET["idcaja_chica_detalle"]))
				$arKeys[] = ew_StripSlashes($_GET["idcaja_chica_detalle"]);
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
			$this->idcaja_chica_detalle->CurrentValue = $key;
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
		$this->idcaja_chica_detalle->setDbValue($rs->fields('idcaja_chica_detalle'));
		$this->idcaja_chica->setDbValue($rs->fields('idcaja_chica'));
		$this->tipo->setDbValue($rs->fields('tipo'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->monto->setDbValue($rs->fields('monto'));
		$this->monto_aplicado->setDbValue($rs->fields('monto_aplicado'));
		$this->fecha_insercion->setDbValue($rs->fields('fecha_insercion'));
		$this->estado->setDbValue($rs->fields('estado'));
		$this->descripcion->setDbValue($rs->fields('descripcion'));
		$this->idreferencia->setDbValue($rs->fields('idreferencia'));
		$this->tabla_referencia->setDbValue($rs->fields('tabla_referencia'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// idcaja_chica_detalle
		// idcaja_chica
		// tipo
		// fecha
		// monto
		// monto_aplicado
		// fecha_insercion
		// estado
		// descripcion
		// idreferencia
		// tabla_referencia
		// idcaja_chica_detalle

		$this->idcaja_chica_detalle->ViewValue = $this->idcaja_chica_detalle->CurrentValue;
		$this->idcaja_chica_detalle->ViewCustomAttributes = "";

		// idcaja_chica
		$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
		$this->idcaja_chica->ViewCustomAttributes = "";

		// tipo
		if (strval($this->tipo->CurrentValue) <> "") {
			$this->tipo->ViewValue = $this->tipo->OptionCaption($this->tipo->CurrentValue);
		} else {
			$this->tipo->ViewValue = NULL;
		}
		$this->tipo->ViewCustomAttributes = "";

		// fecha
		$this->fecha->ViewValue = $this->fecha->CurrentValue;
		$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
		$this->fecha->ViewCustomAttributes = "";

		// monto
		$this->monto->ViewValue = $this->monto->CurrentValue;
		$this->monto->ViewCustomAttributes = "";

		// monto_aplicado
		$this->monto_aplicado->ViewValue = $this->monto_aplicado->CurrentValue;
		$this->monto_aplicado->ViewCustomAttributes = "";

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

		// descripcion
		$this->descripcion->ViewValue = $this->descripcion->CurrentValue;
		$this->descripcion->ViewCustomAttributes = "";

		// idreferencia
		$this->idreferencia->ViewValue = $this->idreferencia->CurrentValue;
		$this->idreferencia->ViewCustomAttributes = "";

		// tabla_referencia
		$this->tabla_referencia->ViewValue = $this->tabla_referencia->CurrentValue;
		$this->tabla_referencia->ViewCustomAttributes = "";

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle->LinkCustomAttributes = "";
		$this->idcaja_chica_detalle->HrefValue = "";
		$this->idcaja_chica_detalle->TooltipValue = "";

		// idcaja_chica
		$this->idcaja_chica->LinkCustomAttributes = "";
		$this->idcaja_chica->HrefValue = "";
		$this->idcaja_chica->TooltipValue = "";

		// tipo
		$this->tipo->LinkCustomAttributes = "";
		$this->tipo->HrefValue = "";
		$this->tipo->TooltipValue = "";

		// fecha
		$this->fecha->LinkCustomAttributes = "";
		$this->fecha->HrefValue = "";
		$this->fecha->TooltipValue = "";

		// monto
		$this->monto->LinkCustomAttributes = "";
		$this->monto->HrefValue = "";
		$this->monto->TooltipValue = "";

		// monto_aplicado
		$this->monto_aplicado->LinkCustomAttributes = "";
		$this->monto_aplicado->HrefValue = "";
		$this->monto_aplicado->TooltipValue = "";

		// fecha_insercion
		$this->fecha_insercion->LinkCustomAttributes = "";
		$this->fecha_insercion->HrefValue = "";
		$this->fecha_insercion->TooltipValue = "";

		// estado
		$this->estado->LinkCustomAttributes = "";
		$this->estado->HrefValue = "";
		$this->estado->TooltipValue = "";

		// descripcion
		$this->descripcion->LinkCustomAttributes = "";
		$this->descripcion->HrefValue = "";
		$this->descripcion->TooltipValue = "";

		// idreferencia
		$this->idreferencia->LinkCustomAttributes = "";
		$this->idreferencia->HrefValue = "";
		$this->idreferencia->TooltipValue = "";

		// tabla_referencia
		$this->tabla_referencia->LinkCustomAttributes = "";
		$this->tabla_referencia->HrefValue = "";
		$this->tabla_referencia->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// idcaja_chica_detalle
		$this->idcaja_chica_detalle->EditAttrs["class"] = "form-control";
		$this->idcaja_chica_detalle->EditCustomAttributes = "";
		$this->idcaja_chica_detalle->EditValue = $this->idcaja_chica_detalle->CurrentValue;
		$this->idcaja_chica_detalle->ViewCustomAttributes = "";

		// idcaja_chica
		$this->idcaja_chica->EditAttrs["class"] = "form-control";
		$this->idcaja_chica->EditCustomAttributes = "";
		if ($this->idcaja_chica->getSessionValue() <> "") {
			$this->idcaja_chica->CurrentValue = $this->idcaja_chica->getSessionValue();
		$this->idcaja_chica->ViewValue = $this->idcaja_chica->CurrentValue;
		$this->idcaja_chica->ViewCustomAttributes = "";
		} else {
		$this->idcaja_chica->EditValue = $this->idcaja_chica->CurrentValue;
		$this->idcaja_chica->PlaceHolder = ew_RemoveHtml($this->idcaja_chica->FldCaption());
		}

		// tipo
		$this->tipo->EditAttrs["class"] = "form-control";
		$this->tipo->EditCustomAttributes = "";
		$this->tipo->EditValue = $this->tipo->Options(TRUE);

		// fecha
		$this->fecha->EditAttrs["class"] = "form-control";
		$this->fecha->EditCustomAttributes = "";
		$this->fecha->EditValue = ew_FormatDateTime($this->fecha->CurrentValue, 7);
		$this->fecha->PlaceHolder = ew_RemoveHtml($this->fecha->FldCaption());

		// monto
		$this->monto->EditAttrs["class"] = "form-control";
		$this->monto->EditCustomAttributes = "";
		$this->monto->EditValue = $this->monto->CurrentValue;
		$this->monto->PlaceHolder = ew_RemoveHtml($this->monto->FldCaption());
		if (strval($this->monto->EditValue) <> "" && is_numeric($this->monto->EditValue)) $this->monto->EditValue = ew_FormatNumber($this->monto->EditValue, -2, -1, -2, 0);

		// monto_aplicado
		$this->monto_aplicado->EditAttrs["class"] = "form-control";
		$this->monto_aplicado->EditCustomAttributes = "";
		$this->monto_aplicado->EditValue = $this->monto_aplicado->CurrentValue;
		$this->monto_aplicado->PlaceHolder = ew_RemoveHtml($this->monto_aplicado->FldCaption());
		if (strval($this->monto_aplicado->EditValue) <> "" && is_numeric($this->monto_aplicado->EditValue)) $this->monto_aplicado->EditValue = ew_FormatNumber($this->monto_aplicado->EditValue, -2, -1, -2, 0);

		// fecha_insercion
		$this->fecha_insercion->EditAttrs["class"] = "form-control";
		$this->fecha_insercion->EditCustomAttributes = "";
		$this->fecha_insercion->EditValue = ew_FormatDateTime($this->fecha_insercion->CurrentValue, 7);
		$this->fecha_insercion->PlaceHolder = ew_RemoveHtml($this->fecha_insercion->FldCaption());

		// estado
		$this->estado->EditAttrs["class"] = "form-control";
		$this->estado->EditCustomAttributes = "";
		$this->estado->EditValue = $this->estado->Options(TRUE);

		// descripcion
		$this->descripcion->EditAttrs["class"] = "form-control";
		$this->descripcion->EditCustomAttributes = "";
		$this->descripcion->EditValue = $this->descripcion->CurrentValue;
		$this->descripcion->PlaceHolder = ew_RemoveHtml($this->descripcion->FldCaption());

		// idreferencia
		$this->idreferencia->EditAttrs["class"] = "form-control";
		$this->idreferencia->EditCustomAttributes = "";
		$this->idreferencia->EditValue = $this->idreferencia->CurrentValue;
		$this->idreferencia->PlaceHolder = ew_RemoveHtml($this->idreferencia->FldCaption());

		// tabla_referencia
		$this->tabla_referencia->EditAttrs["class"] = "form-control";
		$this->tabla_referencia->EditCustomAttributes = "";
		$this->tabla_referencia->EditValue = $this->tabla_referencia->CurrentValue;
		$this->tabla_referencia->PlaceHolder = ew_RemoveHtml($this->tabla_referencia->FldCaption());

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
					if ($this->idcaja_chica_detalle->Exportable) $Doc->ExportCaption($this->idcaja_chica_detalle);
					if ($this->idcaja_chica->Exportable) $Doc->ExportCaption($this->idcaja_chica);
					if ($this->tipo->Exportable) $Doc->ExportCaption($this->tipo);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->monto_aplicado->Exportable) $Doc->ExportCaption($this->monto_aplicado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
					if ($this->idreferencia->Exportable) $Doc->ExportCaption($this->idreferencia);
					if ($this->tabla_referencia->Exportable) $Doc->ExportCaption($this->tabla_referencia);
				} else {
					if ($this->idcaja_chica_detalle->Exportable) $Doc->ExportCaption($this->idcaja_chica_detalle);
					if ($this->idcaja_chica->Exportable) $Doc->ExportCaption($this->idcaja_chica);
					if ($this->tipo->Exportable) $Doc->ExportCaption($this->tipo);
					if ($this->fecha->Exportable) $Doc->ExportCaption($this->fecha);
					if ($this->monto->Exportable) $Doc->ExportCaption($this->monto);
					if ($this->monto_aplicado->Exportable) $Doc->ExportCaption($this->monto_aplicado);
					if ($this->fecha_insercion->Exportable) $Doc->ExportCaption($this->fecha_insercion);
					if ($this->estado->Exportable) $Doc->ExportCaption($this->estado);
					if ($this->descripcion->Exportable) $Doc->ExportCaption($this->descripcion);
					if ($this->idreferencia->Exportable) $Doc->ExportCaption($this->idreferencia);
					if ($this->tabla_referencia->Exportable) $Doc->ExportCaption($this->tabla_referencia);
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
						if ($this->idcaja_chica_detalle->Exportable) $Doc->ExportField($this->idcaja_chica_detalle);
						if ($this->idcaja_chica->Exportable) $Doc->ExportField($this->idcaja_chica);
						if ($this->tipo->Exportable) $Doc->ExportField($this->tipo);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->monto_aplicado->Exportable) $Doc->ExportField($this->monto_aplicado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
						if ($this->idreferencia->Exportable) $Doc->ExportField($this->idreferencia);
						if ($this->tabla_referencia->Exportable) $Doc->ExportField($this->tabla_referencia);
					} else {
						if ($this->idcaja_chica_detalle->Exportable) $Doc->ExportField($this->idcaja_chica_detalle);
						if ($this->idcaja_chica->Exportable) $Doc->ExportField($this->idcaja_chica);
						if ($this->tipo->Exportable) $Doc->ExportField($this->tipo);
						if ($this->fecha->Exportable) $Doc->ExportField($this->fecha);
						if ($this->monto->Exportable) $Doc->ExportField($this->monto);
						if ($this->monto_aplicado->Exportable) $Doc->ExportField($this->monto_aplicado);
						if ($this->fecha_insercion->Exportable) $Doc->ExportField($this->fecha_insercion);
						if ($this->estado->Exportable) $Doc->ExportField($this->estado);
						if ($this->descripcion->Exportable) $Doc->ExportField($this->descripcion);
						if ($this->idreferencia->Exportable) $Doc->ExportField($this->idreferencia);
						if ($this->tabla_referencia->Exportable) $Doc->ExportField($this->tabla_referencia);
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
