<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "membershipinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$membership_delete = NULL; // Initialize page object first

class cmembership_delete extends cmembership {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{C94A36D7-4F8C-407F-9ED7-192C6149F989}';

	// Table name
	var $TableName = 'membership';

	// Page object name
	var $PageObjName = 'membership_delete';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

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
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
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
		if (!$this->CheckToken || !ew_IsPost())
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

		// Table object (membership)
		if (!isset($GLOBALS["membership"]) || get_class($GLOBALS["membership"]) == "cmembership") {
			$GLOBALS["membership"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["membership"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'membership', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("membershiplist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->memberID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->memberID->Visible = FALSE;
		$this->f_name->SetVisibility();
		$this->dob->SetVisibility();
		$this->nationality->SetVisibility();
		$this->mobile->SetVisibility();
		$this->occupation->SetVisibility();
		$this->mentor->SetVisibility();
		$this->interest->SetVisibility();

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
		global $EW_EXPORT, $membership;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($membership);
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
			ew_SaveDebugMsg();
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("membershiplist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in membership class, membershipinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
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
				$this->Page_Terminate("membershiplist.php"); // Return to list
			}
		}
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
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
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->memberID->setDbValue($row['memberID']);
		$this->f_name->setDbValue($row['f_name']);
		$this->dob->setDbValue($row['dob']);
		$this->address->setDbValue($row['address']);
		$this->nationality->setDbValue($row['nationality']);
		$this->mobile->setDbValue($row['mobile']);
		$this->_email->setDbValue($row['email']);
		$this->occupation->setDbValue($row['occupation']);
		$this->level_edu->setDbValue($row['level_edu']);
		$this->mentor->setDbValue($row['mentor']);
		$this->interest->setDbValue($row['interest']);
		$this->affiliation->setDbValue($row['affiliation']);
		$this->church->setDbValue($row['church']);
		$this->role->setDbValue($row['role']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['memberID'] = NULL;
		$row['f_name'] = NULL;
		$row['dob'] = NULL;
		$row['address'] = NULL;
		$row['nationality'] = NULL;
		$row['mobile'] = NULL;
		$row['email'] = NULL;
		$row['occupation'] = NULL;
		$row['level_edu'] = NULL;
		$row['mentor'] = NULL;
		$row['interest'] = NULL;
		$row['affiliation'] = NULL;
		$row['church'] = NULL;
		$row['role'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->memberID->DbValue = $row['memberID'];
		$this->f_name->DbValue = $row['f_name'];
		$this->dob->DbValue = $row['dob'];
		$this->address->DbValue = $row['address'];
		$this->nationality->DbValue = $row['nationality'];
		$this->mobile->DbValue = $row['mobile'];
		$this->_email->DbValue = $row['email'];
		$this->occupation->DbValue = $row['occupation'];
		$this->level_edu->DbValue = $row['level_edu'];
		$this->mentor->DbValue = $row['mentor'];
		$this->interest->DbValue = $row['interest'];
		$this->affiliation->DbValue = $row['affiliation'];
		$this->church->DbValue = $row['church'];
		$this->role->DbValue = $row['role'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
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

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

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

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";
			$this->nationality->TooltipValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";
			$this->mobile->TooltipValue = "";

			// occupation
			$this->occupation->LinkCustomAttributes = "";
			$this->occupation->HrefValue = "";
			$this->occupation->TooltipValue = "";

			// mentor
			$this->mentor->LinkCustomAttributes = "";
			$this->mentor->HrefValue = "";
			$this->mentor->TooltipValue = "";

			// interest
			$this->interest->LinkCustomAttributes = "";
			$this->interest->HrefValue = "";
			$this->interest->TooltipValue = "";
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
				$sThisKey .= $row['memberID'];
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("membershiplist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
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
if (!isset($membership_delete)) $membership_delete = new cmembership_delete();

// Page init
$membership_delete->Page_Init();

// Page main
$membership_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$membership_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = fmembershipdelete = new ew_Form("fmembershipdelete", "delete");

// Form_CustomValidate event
fmembershipdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmembershipdelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $membership_delete->ShowPageHeader(); ?>
<?php
$membership_delete->ShowMessage();
?>
<form name="fmembershipdelete" id="fmembershipdelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($membership_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $membership_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="membership">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($membership_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($membership->memberID->Visible) { // memberID ?>
		<th class="<?php echo $membership->memberID->HeaderCellClass() ?>"><span id="elh_membership_memberID" class="membership_memberID"><?php echo $membership->memberID->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->f_name->Visible) { // f_name ?>
		<th class="<?php echo $membership->f_name->HeaderCellClass() ?>"><span id="elh_membership_f_name" class="membership_f_name"><?php echo $membership->f_name->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->dob->Visible) { // dob ?>
		<th class="<?php echo $membership->dob->HeaderCellClass() ?>"><span id="elh_membership_dob" class="membership_dob"><?php echo $membership->dob->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->nationality->Visible) { // nationality ?>
		<th class="<?php echo $membership->nationality->HeaderCellClass() ?>"><span id="elh_membership_nationality" class="membership_nationality"><?php echo $membership->nationality->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->mobile->Visible) { // mobile ?>
		<th class="<?php echo $membership->mobile->HeaderCellClass() ?>"><span id="elh_membership_mobile" class="membership_mobile"><?php echo $membership->mobile->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->occupation->Visible) { // occupation ?>
		<th class="<?php echo $membership->occupation->HeaderCellClass() ?>"><span id="elh_membership_occupation" class="membership_occupation"><?php echo $membership->occupation->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->mentor->Visible) { // mentor ?>
		<th class="<?php echo $membership->mentor->HeaderCellClass() ?>"><span id="elh_membership_mentor" class="membership_mentor"><?php echo $membership->mentor->FldCaption() ?></span></th>
<?php } ?>
<?php if ($membership->interest->Visible) { // interest ?>
		<th class="<?php echo $membership->interest->HeaderCellClass() ?>"><span id="elh_membership_interest" class="membership_interest"><?php echo $membership->interest->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$membership_delete->RecCnt = 0;
$i = 0;
while (!$membership_delete->Recordset->EOF) {
	$membership_delete->RecCnt++;
	$membership_delete->RowCnt++;

	// Set row properties
	$membership->ResetAttrs();
	$membership->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$membership_delete->LoadRowValues($membership_delete->Recordset);

	// Render row
	$membership_delete->RenderRow();
?>
	<tr<?php echo $membership->RowAttributes() ?>>
<?php if ($membership->memberID->Visible) { // memberID ?>
		<td<?php echo $membership->memberID->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_memberID" class="membership_memberID">
<span<?php echo $membership->memberID->ViewAttributes() ?>>
<?php echo $membership->memberID->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->f_name->Visible) { // f_name ?>
		<td<?php echo $membership->f_name->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_f_name" class="membership_f_name">
<span<?php echo $membership->f_name->ViewAttributes() ?>>
<?php echo $membership->f_name->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->dob->Visible) { // dob ?>
		<td<?php echo $membership->dob->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_dob" class="membership_dob">
<span<?php echo $membership->dob->ViewAttributes() ?>>
<?php echo $membership->dob->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->nationality->Visible) { // nationality ?>
		<td<?php echo $membership->nationality->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_nationality" class="membership_nationality">
<span<?php echo $membership->nationality->ViewAttributes() ?>>
<?php echo $membership->nationality->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->mobile->Visible) { // mobile ?>
		<td<?php echo $membership->mobile->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_mobile" class="membership_mobile">
<span<?php echo $membership->mobile->ViewAttributes() ?>>
<?php echo $membership->mobile->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->occupation->Visible) { // occupation ?>
		<td<?php echo $membership->occupation->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_occupation" class="membership_occupation">
<span<?php echo $membership->occupation->ViewAttributes() ?>>
<?php echo $membership->occupation->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->mentor->Visible) { // mentor ?>
		<td<?php echo $membership->mentor->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_mentor" class="membership_mentor">
<span<?php echo $membership->mentor->ViewAttributes() ?>>
<?php echo $membership->mentor->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($membership->interest->Visible) { // interest ?>
		<td<?php echo $membership->interest->CellAttributes() ?>>
<span id="el<?php echo $membership_delete->RowCnt ?>_membership_interest" class="membership_interest">
<span<?php echo $membership->interest->ViewAttributes() ?>>
<?php echo $membership->interest->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$membership_delete->Recordset->MoveNext();
}
$membership_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $membership_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fmembershipdelete.Init();
</script>
<?php
$membership_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$membership_delete->Page_Terminate();
?>
