<?php

// Global variable for table object
$membership = NULL;

//
// Table class for membership
//
class cmembership extends cTable {
	var $memberID;
	var $f_name;
	var $dob;
	var $address;
	var $nationality;
	var $mobile;
	var $_email;
	var $occupation;
	var $level_edu;
	var $mentor;
	var $interest;
	var $affiliation;
	var $church;
	var $role;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'membership';
		$this->TableName = 'membership';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`membership`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// memberID
		$this->memberID = new cField('membership', 'membership', 'x_memberID', 'memberID', '`memberID`', '`memberID`', 3, -1, FALSE, '`memberID`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->memberID->Sortable = TRUE; // Allow sort
		$this->memberID->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['memberID'] = &$this->memberID;

		// f_name
		$this->f_name = new cField('membership', 'membership', 'x_f_name', 'f_name', '`f_name`', '`f_name`', 200, -1, FALSE, '`f_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->f_name->Sortable = TRUE; // Allow sort
		$this->fields['f_name'] = &$this->f_name;

		// dob
		$this->dob = new cField('membership', 'membership', 'x_dob', 'dob', '`dob`', ew_CastDateFieldForLike('`dob`', 0, "DB"), 133, 0, FALSE, '`dob`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->dob->Sortable = TRUE; // Allow sort
		$this->dob->FldDefaultErrMsg = str_replace("%s", $GLOBALS["EW_DATE_FORMAT"], $Language->Phrase("IncorrectDate"));
		$this->fields['dob'] = &$this->dob;

		// address
		$this->address = new cField('membership', 'membership', 'x_address', 'address', '`address`', '`address`', 200, -1, FALSE, '`address`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->address->Sortable = TRUE; // Allow sort
		$this->fields['address'] = &$this->address;

		// nationality
		$this->nationality = new cField('membership', 'membership', 'x_nationality', 'nationality', '`nationality`', '`nationality`', 200, -1, FALSE, '`nationality`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->nationality->Sortable = TRUE; // Allow sort
		$this->fields['nationality'] = &$this->nationality;

		// mobile
		$this->mobile = new cField('membership', 'membership', 'x_mobile', 'mobile', '`mobile`', '`mobile`', 200, -1, FALSE, '`mobile`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mobile->Sortable = TRUE; // Allow sort
		$this->fields['mobile'] = &$this->mobile;

		// email
		$this->_email = new cField('membership', 'membership', 'x__email', 'email', '`email`', '`email`', 200, -1, FALSE, '`email`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->_email->Sortable = TRUE; // Allow sort
		$this->fields['email'] = &$this->_email;

		// occupation
		$this->occupation = new cField('membership', 'membership', 'x_occupation', 'occupation', '`occupation`', '`occupation`', 200, -1, FALSE, '`occupation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->occupation->Sortable = TRUE; // Allow sort
		$this->fields['occupation'] = &$this->occupation;

		// level_edu
		$this->level_edu = new cField('membership', 'membership', 'x_level_edu', 'level_edu', '`level_edu`', '`level_edu`', 200, -1, FALSE, '`level_edu`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->level_edu->Sortable = TRUE; // Allow sort
		$this->fields['level_edu'] = &$this->level_edu;

		// mentor
		$this->mentor = new cField('membership', 'membership', 'x_mentor', 'mentor', '`mentor`', '`mentor`', 200, -1, FALSE, '`mentor`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->mentor->Sortable = TRUE; // Allow sort
		$this->fields['mentor'] = &$this->mentor;

		// interest
		$this->interest = new cField('membership', 'membership', 'x_interest', 'interest', '`interest`', '`interest`', 200, -1, FALSE, '`interest`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->interest->Sortable = TRUE; // Allow sort
		$this->fields['interest'] = &$this->interest;

		// affiliation
		$this->affiliation = new cField('membership', 'membership', 'x_affiliation', 'affiliation', '`affiliation`', '`affiliation`', 200, -1, FALSE, '`affiliation`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->affiliation->Sortable = TRUE; // Allow sort
		$this->fields['affiliation'] = &$this->affiliation;

		// church
		$this->church = new cField('membership', 'membership', 'x_church', 'church', '`church`', '`church`', 200, -1, FALSE, '`church`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->church->Sortable = TRUE; // Allow sort
		$this->fields['church'] = &$this->church;

		// role
		$this->role = new cField('membership', 'membership', 'x_role', 'role', '`role`', '`role`', 200, -1, FALSE, '`role`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->role->Sortable = TRUE; // Allow sort
		$this->fields['role'] = &$this->role;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`membership`";
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
		$this->TableFilter = "";
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
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
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
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
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
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->memberID->setDbValue($conn->Insert_ID());
			$rs['memberID'] = $this->memberID->DbValue;
		}
		return $bInsert;
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
		$sql = preg_replace('/,+$/', "", $sql);
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
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('memberID', $rs))
				ew_AddFilter($where, ew_QuotedName('memberID', $this->DBID) . '=' . ew_QuotedValue($rs['memberID'], $this->memberID->FldDataType, $this->DBID));
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
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`memberID` = @memberID@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->memberID->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->memberID->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@memberID@", ew_AdjustSql($this->memberID->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "membershiplist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "membershipview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "membershipedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "membershipadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "membershiplist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("membershipview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("membershipview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "membershipadd.php?" . $this->UrlParm($parm);
		else
			$url = "membershipadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("membershipedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("membershipadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("membershipdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "memberID:" . ew_VarToJson($this->memberID->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->memberID->CurrentValue)) {
			$sUrl .= "memberID=" . urlencode($this->memberID->CurrentValue);
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
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
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
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["memberID"]))
				$arKeys[] = $_POST["memberID"];
			elseif (isset($_GET["memberID"]))
				$arKeys[] = $_GET["memberID"];
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
			$this->memberID->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->memberID->setDbValue($rs->fields('memberID'));
		$this->f_name->setDbValue($rs->fields('f_name'));
		$this->dob->setDbValue($rs->fields('dob'));
		$this->address->setDbValue($rs->fields('address'));
		$this->nationality->setDbValue($rs->fields('nationality'));
		$this->mobile->setDbValue($rs->fields('mobile'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->occupation->setDbValue($rs->fields('occupation'));
		$this->level_edu->setDbValue($rs->fields('level_edu'));
		$this->mentor->setDbValue($rs->fields('mentor'));
		$this->interest->setDbValue($rs->fields('interest'));
		$this->affiliation->setDbValue($rs->fields('affiliation'));
		$this->church->setDbValue($rs->fields('church'));
		$this->role->setDbValue($rs->fields('role'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
		// memberID
		// f_name
		// dob
		// address
		// nationality
		// mobile
		// email
		// occupation
		// level_edu
		// mentor
		// interest
		// affiliation
		// church
		// role
		// memberID

		$this->memberID->ViewValue = $this->memberID->CurrentValue;
		$this->memberID->ViewCustomAttributes = "";

		// f_name
		$this->f_name->ViewValue = $this->f_name->CurrentValue;
		$this->f_name->ViewCustomAttributes = "";

		// dob
		$this->dob->ViewValue = $this->dob->CurrentValue;
		$this->dob->ViewValue = ew_FormatDateTime($this->dob->ViewValue, 0);
		$this->dob->ViewCustomAttributes = "";

		// address
		$this->address->ViewValue = $this->address->CurrentValue;
		$this->address->ViewCustomAttributes = "";

		// nationality
		$this->nationality->ViewValue = $this->nationality->CurrentValue;
		$this->nationality->ViewCustomAttributes = "";

		// mobile
		$this->mobile->ViewValue = $this->mobile->CurrentValue;
		$this->mobile->ViewCustomAttributes = "";

		// email
		$this->_email->ViewValue = $this->_email->CurrentValue;
		$this->_email->ViewCustomAttributes = "";

		// occupation
		$this->occupation->ViewValue = $this->occupation->CurrentValue;
		$this->occupation->ViewCustomAttributes = "";

		// level_edu
		$this->level_edu->ViewValue = $this->level_edu->CurrentValue;
		$this->level_edu->ViewCustomAttributes = "";

		// mentor
		$this->mentor->ViewValue = $this->mentor->CurrentValue;
		$this->mentor->ViewCustomAttributes = "";

		// interest
		$this->interest->ViewValue = $this->interest->CurrentValue;
		$this->interest->ViewCustomAttributes = "";

		// affiliation
		$this->affiliation->ViewValue = $this->affiliation->CurrentValue;
		$this->affiliation->ViewCustomAttributes = "";

		// church
		$this->church->ViewValue = $this->church->CurrentValue;
		$this->church->ViewCustomAttributes = "";

		// role
		$this->role->ViewValue = $this->role->CurrentValue;
		$this->role->ViewCustomAttributes = "";

		// memberID
		$this->memberID->LinkCustomAttributes = "";
		$this->memberID->HrefValue = "";
		$this->memberID->TooltipValue = "";

		// f_name
		$this->f_name->LinkCustomAttributes = "";
		$this->f_name->HrefValue = "";
		$this->f_name->TooltipValue = "";

		// dob
		$this->dob->LinkCustomAttributes = "";
		$this->dob->HrefValue = "";
		$this->dob->TooltipValue = "";

		// address
		$this->address->LinkCustomAttributes = "";
		$this->address->HrefValue = "";
		$this->address->TooltipValue = "";

		// nationality
		$this->nationality->LinkCustomAttributes = "";
		$this->nationality->HrefValue = "";
		$this->nationality->TooltipValue = "";

		// mobile
		$this->mobile->LinkCustomAttributes = "";
		$this->mobile->HrefValue = "";
		$this->mobile->TooltipValue = "";

		// email
		$this->_email->LinkCustomAttributes = "";
		$this->_email->HrefValue = "";
		$this->_email->TooltipValue = "";

		// occupation
		$this->occupation->LinkCustomAttributes = "";
		$this->occupation->HrefValue = "";
		$this->occupation->TooltipValue = "";

		// level_edu
		$this->level_edu->LinkCustomAttributes = "";
		$this->level_edu->HrefValue = "";
		$this->level_edu->TooltipValue = "";

		// mentor
		$this->mentor->LinkCustomAttributes = "";
		$this->mentor->HrefValue = "";
		$this->mentor->TooltipValue = "";

		// interest
		$this->interest->LinkCustomAttributes = "";
		$this->interest->HrefValue = "";
		$this->interest->TooltipValue = "";

		// affiliation
		$this->affiliation->LinkCustomAttributes = "";
		$this->affiliation->HrefValue = "";
		$this->affiliation->TooltipValue = "";

		// church
		$this->church->LinkCustomAttributes = "";
		$this->church->HrefValue = "";
		$this->church->TooltipValue = "";

		// role
		$this->role->LinkCustomAttributes = "";
		$this->role->HrefValue = "";
		$this->role->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// memberID
		$this->memberID->EditAttrs["class"] = "form-control";
		$this->memberID->EditCustomAttributes = "";
		$this->memberID->EditValue = $this->memberID->CurrentValue;
		$this->memberID->ViewCustomAttributes = "";

		// f_name
		$this->f_name->EditAttrs["class"] = "form-control";
		$this->f_name->EditCustomAttributes = "";
		$this->f_name->EditValue = $this->f_name->CurrentValue;
		$this->f_name->PlaceHolder = ew_RemoveHtml($this->f_name->FldCaption());

		// dob
		$this->dob->EditAttrs["class"] = "form-control";
		$this->dob->EditCustomAttributes = "";
		$this->dob->EditValue = ew_FormatDateTime($this->dob->CurrentValue, 8);
		$this->dob->PlaceHolder = ew_RemoveHtml($this->dob->FldCaption());

		// address
		$this->address->EditAttrs["class"] = "form-control";
		$this->address->EditCustomAttributes = "";
		$this->address->EditValue = $this->address->CurrentValue;
		$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

		// nationality
		$this->nationality->EditAttrs["class"] = "form-control";
		$this->nationality->EditCustomAttributes = "";
		$this->nationality->EditValue = $this->nationality->CurrentValue;
		$this->nationality->PlaceHolder = ew_RemoveHtml($this->nationality->FldCaption());

		// mobile
		$this->mobile->EditAttrs["class"] = "form-control";
		$this->mobile->EditCustomAttributes = "";
		$this->mobile->EditValue = $this->mobile->CurrentValue;
		$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

		// email
		$this->_email->EditAttrs["class"] = "form-control";
		$this->_email->EditCustomAttributes = "";
		$this->_email->EditValue = $this->_email->CurrentValue;
		$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

		// occupation
		$this->occupation->EditAttrs["class"] = "form-control";
		$this->occupation->EditCustomAttributes = "";
		$this->occupation->EditValue = $this->occupation->CurrentValue;
		$this->occupation->PlaceHolder = ew_RemoveHtml($this->occupation->FldCaption());

		// level_edu
		$this->level_edu->EditAttrs["class"] = "form-control";
		$this->level_edu->EditCustomAttributes = "";
		$this->level_edu->EditValue = $this->level_edu->CurrentValue;
		$this->level_edu->PlaceHolder = ew_RemoveHtml($this->level_edu->FldCaption());

		// mentor
		$this->mentor->EditAttrs["class"] = "form-control";
		$this->mentor->EditCustomAttributes = "";
		$this->mentor->EditValue = $this->mentor->CurrentValue;
		$this->mentor->PlaceHolder = ew_RemoveHtml($this->mentor->FldCaption());

		// interest
		$this->interest->EditAttrs["class"] = "form-control";
		$this->interest->EditCustomAttributes = "";
		$this->interest->EditValue = $this->interest->CurrentValue;
		$this->interest->PlaceHolder = ew_RemoveHtml($this->interest->FldCaption());

		// affiliation
		$this->affiliation->EditAttrs["class"] = "form-control";
		$this->affiliation->EditCustomAttributes = "";
		$this->affiliation->EditValue = $this->affiliation->CurrentValue;
		$this->affiliation->PlaceHolder = ew_RemoveHtml($this->affiliation->FldCaption());

		// church
		$this->church->EditAttrs["class"] = "form-control";
		$this->church->EditCustomAttributes = "";
		$this->church->EditValue = $this->church->CurrentValue;
		$this->church->PlaceHolder = ew_RemoveHtml($this->church->FldCaption());

		// role
		$this->role->EditAttrs["class"] = "form-control";
		$this->role->EditCustomAttributes = "";
		$this->role->EditValue = $this->role->CurrentValue;
		$this->role->PlaceHolder = ew_RemoveHtml($this->role->FldCaption());

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
					if ($this->memberID->Exportable) $Doc->ExportCaption($this->memberID);
					if ($this->f_name->Exportable) $Doc->ExportCaption($this->f_name);
					if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
					if ($this->address->Exportable) $Doc->ExportCaption($this->address);
					if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->occupation->Exportable) $Doc->ExportCaption($this->occupation);
					if ($this->level_edu->Exportable) $Doc->ExportCaption($this->level_edu);
					if ($this->mentor->Exportable) $Doc->ExportCaption($this->mentor);
					if ($this->interest->Exportable) $Doc->ExportCaption($this->interest);
					if ($this->affiliation->Exportable) $Doc->ExportCaption($this->affiliation);
					if ($this->church->Exportable) $Doc->ExportCaption($this->church);
					if ($this->role->Exportable) $Doc->ExportCaption($this->role);
				} else {
					if ($this->memberID->Exportable) $Doc->ExportCaption($this->memberID);
					if ($this->f_name->Exportable) $Doc->ExportCaption($this->f_name);
					if ($this->dob->Exportable) $Doc->ExportCaption($this->dob);
					if ($this->address->Exportable) $Doc->ExportCaption($this->address);
					if ($this->nationality->Exportable) $Doc->ExportCaption($this->nationality);
					if ($this->mobile->Exportable) $Doc->ExportCaption($this->mobile);
					if ($this->_email->Exportable) $Doc->ExportCaption($this->_email);
					if ($this->occupation->Exportable) $Doc->ExportCaption($this->occupation);
					if ($this->level_edu->Exportable) $Doc->ExportCaption($this->level_edu);
					if ($this->mentor->Exportable) $Doc->ExportCaption($this->mentor);
					if ($this->interest->Exportable) $Doc->ExportCaption($this->interest);
					if ($this->affiliation->Exportable) $Doc->ExportCaption($this->affiliation);
					if ($this->church->Exportable) $Doc->ExportCaption($this->church);
					if ($this->role->Exportable) $Doc->ExportCaption($this->role);
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
						if ($this->memberID->Exportable) $Doc->ExportField($this->memberID);
						if ($this->f_name->Exportable) $Doc->ExportField($this->f_name);
						if ($this->dob->Exportable) $Doc->ExportField($this->dob);
						if ($this->address->Exportable) $Doc->ExportField($this->address);
						if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->occupation->Exportable) $Doc->ExportField($this->occupation);
						if ($this->level_edu->Exportable) $Doc->ExportField($this->level_edu);
						if ($this->mentor->Exportable) $Doc->ExportField($this->mentor);
						if ($this->interest->Exportable) $Doc->ExportField($this->interest);
						if ($this->affiliation->Exportable) $Doc->ExportField($this->affiliation);
						if ($this->church->Exportable) $Doc->ExportField($this->church);
						if ($this->role->Exportable) $Doc->ExportField($this->role);
					} else {
						if ($this->memberID->Exportable) $Doc->ExportField($this->memberID);
						if ($this->f_name->Exportable) $Doc->ExportField($this->f_name);
						if ($this->dob->Exportable) $Doc->ExportField($this->dob);
						if ($this->address->Exportable) $Doc->ExportField($this->address);
						if ($this->nationality->Exportable) $Doc->ExportField($this->nationality);
						if ($this->mobile->Exportable) $Doc->ExportField($this->mobile);
						if ($this->_email->Exportable) $Doc->ExportField($this->_email);
						if ($this->occupation->Exportable) $Doc->ExportField($this->occupation);
						if ($this->level_edu->Exportable) $Doc->ExportField($this->level_edu);
						if ($this->mentor->Exportable) $Doc->ExportField($this->mentor);
						if ($this->interest->Exportable) $Doc->ExportField($this->interest);
						if ($this->affiliation->Exportable) $Doc->ExportField($this->affiliation);
						if ($this->church->Exportable) $Doc->ExportField($this->church);
						if ($this->role->Exportable) $Doc->ExportField($this->role);
					}
					$Doc->EndExportRow($RowCnt);
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
