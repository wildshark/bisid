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

$membership_edit = NULL; // Initialize page object first

class cmembership_edit extends cmembership {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{C94A36D7-4F8C-407F-9ED7-192C6149F989}';

	// Table name
	var $TableName = 'membership';

	// Page object name
	var $PageObjName = 'membership_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if (!$Security->CanEdit()) {
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
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->memberID->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->memberID->Visible = FALSE;
		$this->f_name->SetVisibility();
		$this->dob->SetVisibility();
		$this->address->SetVisibility();
		$this->nationality->SetVisibility();
		$this->mobile->SetVisibility();
		$this->_email->SetVisibility();
		$this->occupation->SetVisibility();
		$this->level_edu->SetVisibility();
		$this->mentor->SetVisibility();
		$this->interest->SetVisibility();
		$this->affiliation->SetVisibility();
		$this->church->SetVisibility();
		$this->role->SetVisibility();

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

			// Handle modal response
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "membershipview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_memberID")) {
				$this->memberID->setFormValue($objForm->GetValue("x_memberID"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["memberID"])) {
				$this->memberID->setQueryStringValue($_GET["memberID"]);
				$loadByQuery = TRUE;
			} else {
				$this->memberID->CurrentValue = NULL;
			}
		}

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("membershiplist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "membershiplist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
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
		if (!$this->memberID->FldIsDetailKey)
			$this->memberID->setFormValue($objForm->GetValue("x_memberID"));
		if (!$this->f_name->FldIsDetailKey) {
			$this->f_name->setFormValue($objForm->GetValue("x_f_name"));
		}
		if (!$this->dob->FldIsDetailKey) {
			$this->dob->setFormValue($objForm->GetValue("x_dob"));
			$this->dob->CurrentValue = ew_UnFormatDateTime($this->dob->CurrentValue, 0);
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->nationality->FldIsDetailKey) {
			$this->nationality->setFormValue($objForm->GetValue("x_nationality"));
		}
		if (!$this->mobile->FldIsDetailKey) {
			$this->mobile->setFormValue($objForm->GetValue("x_mobile"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->occupation->FldIsDetailKey) {
			$this->occupation->setFormValue($objForm->GetValue("x_occupation"));
		}
		if (!$this->level_edu->FldIsDetailKey) {
			$this->level_edu->setFormValue($objForm->GetValue("x_level_edu"));
		}
		if (!$this->mentor->FldIsDetailKey) {
			$this->mentor->setFormValue($objForm->GetValue("x_mentor"));
		}
		if (!$this->interest->FldIsDetailKey) {
			$this->interest->setFormValue($objForm->GetValue("x_interest"));
		}
		if (!$this->affiliation->FldIsDetailKey) {
			$this->affiliation->setFormValue($objForm->GetValue("x_affiliation"));
		}
		if (!$this->church->FldIsDetailKey) {
			$this->church->setFormValue($objForm->GetValue("x_church"));
		}
		if (!$this->role->FldIsDetailKey) {
			$this->role->setFormValue($objForm->GetValue("x_role"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->memberID->CurrentValue = $this->memberID->FormValue;
		$this->f_name->CurrentValue = $this->f_name->FormValue;
		$this->dob->CurrentValue = $this->dob->FormValue;
		$this->dob->CurrentValue = ew_UnFormatDateTime($this->dob->CurrentValue, 0);
		$this->address->CurrentValue = $this->address->FormValue;
		$this->nationality->CurrentValue = $this->nationality->FormValue;
		$this->mobile->CurrentValue = $this->mobile->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->occupation->CurrentValue = $this->occupation->FormValue;
		$this->level_edu->CurrentValue = $this->level_edu->FormValue;
		$this->mentor->CurrentValue = $this->mentor->FormValue;
		$this->interest->CurrentValue = $this->interest->FormValue;
		$this->affiliation->CurrentValue = $this->affiliation->FormValue;
		$this->church->CurrentValue = $this->church->FormValue;
		$this->role->CurrentValue = $this->role->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("memberID")) <> "")
			$this->memberID->CurrentValue = $this->getKey("memberID"); // memberID
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// memberID
			$this->memberID->EditAttrs["class"] = "form-control";
			$this->memberID->EditCustomAttributes = "";
			$this->memberID->EditValue = $this->memberID->CurrentValue;
			$this->memberID->ViewCustomAttributes = "";

			// f_name
			$this->f_name->EditAttrs["class"] = "form-control";
			$this->f_name->EditCustomAttributes = "";
			$this->f_name->EditValue = ew_HtmlEncode($this->f_name->CurrentValue);
			$this->f_name->PlaceHolder = ew_RemoveHtml($this->f_name->FldCaption());

			// dob
			$this->dob->EditAttrs["class"] = "form-control";
			$this->dob->EditCustomAttributes = "";
			$this->dob->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->dob->CurrentValue, 8));
			$this->dob->PlaceHolder = ew_RemoveHtml($this->dob->FldCaption());

			// address
			$this->address->EditAttrs["class"] = "form-control";
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = ew_HtmlEncode($this->address->CurrentValue);
			$this->address->PlaceHolder = ew_RemoveHtml($this->address->FldCaption());

			// nationality
			$this->nationality->EditAttrs["class"] = "form-control";
			$this->nationality->EditCustomAttributes = "";
			$this->nationality->EditValue = ew_HtmlEncode($this->nationality->CurrentValue);
			$this->nationality->PlaceHolder = ew_RemoveHtml($this->nationality->FldCaption());

			// mobile
			$this->mobile->EditAttrs["class"] = "form-control";
			$this->mobile->EditCustomAttributes = "";
			$this->mobile->EditValue = ew_HtmlEncode($this->mobile->CurrentValue);
			$this->mobile->PlaceHolder = ew_RemoveHtml($this->mobile->FldCaption());

			// email
			$this->_email->EditAttrs["class"] = "form-control";
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);
			$this->_email->PlaceHolder = ew_RemoveHtml($this->_email->FldCaption());

			// occupation
			$this->occupation->EditAttrs["class"] = "form-control";
			$this->occupation->EditCustomAttributes = "";
			$this->occupation->EditValue = ew_HtmlEncode($this->occupation->CurrentValue);
			$this->occupation->PlaceHolder = ew_RemoveHtml($this->occupation->FldCaption());

			// level_edu
			$this->level_edu->EditAttrs["class"] = "form-control";
			$this->level_edu->EditCustomAttributes = "";
			$this->level_edu->EditValue = ew_HtmlEncode($this->level_edu->CurrentValue);
			$this->level_edu->PlaceHolder = ew_RemoveHtml($this->level_edu->FldCaption());

			// mentor
			$this->mentor->EditAttrs["class"] = "form-control";
			$this->mentor->EditCustomAttributes = "";
			$this->mentor->EditValue = ew_HtmlEncode($this->mentor->CurrentValue);
			$this->mentor->PlaceHolder = ew_RemoveHtml($this->mentor->FldCaption());

			// interest
			$this->interest->EditAttrs["class"] = "form-control";
			$this->interest->EditCustomAttributes = "";
			$this->interest->EditValue = ew_HtmlEncode($this->interest->CurrentValue);
			$this->interest->PlaceHolder = ew_RemoveHtml($this->interest->FldCaption());

			// affiliation
			$this->affiliation->EditAttrs["class"] = "form-control";
			$this->affiliation->EditCustomAttributes = "";
			$this->affiliation->EditValue = ew_HtmlEncode($this->affiliation->CurrentValue);
			$this->affiliation->PlaceHolder = ew_RemoveHtml($this->affiliation->FldCaption());

			// church
			$this->church->EditAttrs["class"] = "form-control";
			$this->church->EditCustomAttributes = "";
			$this->church->EditValue = ew_HtmlEncode($this->church->CurrentValue);
			$this->church->PlaceHolder = ew_RemoveHtml($this->church->FldCaption());

			// role
			$this->role->EditAttrs["class"] = "form-control";
			$this->role->EditCustomAttributes = "";
			$this->role->EditValue = ew_HtmlEncode($this->role->CurrentValue);
			$this->role->PlaceHolder = ew_RemoveHtml($this->role->FldCaption());

			// Edit refer script
			// memberID

			$this->memberID->LinkCustomAttributes = "";
			$this->memberID->HrefValue = "";

			// f_name
			$this->f_name->LinkCustomAttributes = "";
			$this->f_name->HrefValue = "";

			// dob
			$this->dob->LinkCustomAttributes = "";
			$this->dob->HrefValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";

			// nationality
			$this->nationality->LinkCustomAttributes = "";
			$this->nationality->HrefValue = "";

			// mobile
			$this->mobile->LinkCustomAttributes = "";
			$this->mobile->HrefValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";

			// occupation
			$this->occupation->LinkCustomAttributes = "";
			$this->occupation->HrefValue = "";

			// level_edu
			$this->level_edu->LinkCustomAttributes = "";
			$this->level_edu->HrefValue = "";

			// mentor
			$this->mentor->LinkCustomAttributes = "";
			$this->mentor->HrefValue = "";

			// interest
			$this->interest->LinkCustomAttributes = "";
			$this->interest->HrefValue = "";

			// affiliation
			$this->affiliation->LinkCustomAttributes = "";
			$this->affiliation->HrefValue = "";

			// church
			$this->church->LinkCustomAttributes = "";
			$this->church->HrefValue = "";

			// role
			$this->role->LinkCustomAttributes = "";
			$this->role->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

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
		if (!ew_CheckDateDef($this->dob->FormValue)) {
			ew_AddMessage($gsFormError, $this->dob->FldErrMsg());
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
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// f_name
			$this->f_name->SetDbValueDef($rsnew, $this->f_name->CurrentValue, NULL, $this->f_name->ReadOnly);

			// dob
			$this->dob->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->dob->CurrentValue, 0), NULL, $this->dob->ReadOnly);

			// address
			$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, $this->address->ReadOnly);

			// nationality
			$this->nationality->SetDbValueDef($rsnew, $this->nationality->CurrentValue, NULL, $this->nationality->ReadOnly);

			// mobile
			$this->mobile->SetDbValueDef($rsnew, $this->mobile->CurrentValue, NULL, $this->mobile->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// occupation
			$this->occupation->SetDbValueDef($rsnew, $this->occupation->CurrentValue, NULL, $this->occupation->ReadOnly);

			// level_edu
			$this->level_edu->SetDbValueDef($rsnew, $this->level_edu->CurrentValue, NULL, $this->level_edu->ReadOnly);

			// mentor
			$this->mentor->SetDbValueDef($rsnew, $this->mentor->CurrentValue, NULL, $this->mentor->ReadOnly);

			// interest
			$this->interest->SetDbValueDef($rsnew, $this->interest->CurrentValue, NULL, $this->interest->ReadOnly);

			// affiliation
			$this->affiliation->SetDbValueDef($rsnew, $this->affiliation->CurrentValue, NULL, $this->affiliation->ReadOnly);

			// church
			$this->church->SetDbValueDef($rsnew, $this->church->CurrentValue, NULL, $this->church->ReadOnly);

			// role
			$this->role->SetDbValueDef($rsnew, $this->role->CurrentValue, NULL, $this->role->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("membershiplist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
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
if (!isset($membership_edit)) $membership_edit = new cmembership_edit();

// Page init
$membership_edit->Page_Init();

// Page main
$membership_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$membership_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmembershipedit = new ew_Form("fmembershipedit", "edit");

// Validate form
fmembershipedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_dob");
			if (elm && !ew_CheckDateDef(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($membership->dob->FldErrMsg()) ?>");

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
fmembershipedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmembershipedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $membership_edit->ShowPageHeader(); ?>
<?php
$membership_edit->ShowMessage();
?>
<form name="fmembershipedit" id="fmembershipedit" class="<?php echo $membership_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($membership_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $membership_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="membership">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($membership_edit->IsModal) ?>">
<div class="ewEditDiv"><!-- page* -->
<?php if ($membership->memberID->Visible) { // memberID ?>
	<div id="r_memberID" class="form-group">
		<label id="elh_membership_memberID" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->memberID->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->memberID->CellAttributes() ?>>
<span id="el_membership_memberID">
<span<?php echo $membership->memberID->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $membership->memberID->EditValue ?></p></span>
</span>
<input type="hidden" data-table="membership" data-field="x_memberID" name="x_memberID" id="x_memberID" value="<?php echo ew_HtmlEncode($membership->memberID->CurrentValue) ?>">
<?php echo $membership->memberID->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->f_name->Visible) { // f_name ?>
	<div id="r_f_name" class="form-group">
		<label id="elh_membership_f_name" for="x_f_name" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->f_name->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->f_name->CellAttributes() ?>>
<span id="el_membership_f_name">
<input type="text" data-table="membership" data-field="x_f_name" name="x_f_name" id="x_f_name" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->f_name->getPlaceHolder()) ?>" value="<?php echo $membership->f_name->EditValue ?>"<?php echo $membership->f_name->EditAttributes() ?>>
</span>
<?php echo $membership->f_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->dob->Visible) { // dob ?>
	<div id="r_dob" class="form-group">
		<label id="elh_membership_dob" for="x_dob" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->dob->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->dob->CellAttributes() ?>>
<span id="el_membership_dob">
<input type="text" data-table="membership" data-field="x_dob" name="x_dob" id="x_dob" placeholder="<?php echo ew_HtmlEncode($membership->dob->getPlaceHolder()) ?>" value="<?php echo $membership->dob->EditValue ?>"<?php echo $membership->dob->EditAttributes() ?>>
</span>
<?php echo $membership->dob->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->address->Visible) { // address ?>
	<div id="r_address" class="form-group">
		<label id="elh_membership_address" for="x_address" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->address->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->address->CellAttributes() ?>>
<span id="el_membership_address">
<input type="text" data-table="membership" data-field="x_address" name="x_address" id="x_address" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->address->getPlaceHolder()) ?>" value="<?php echo $membership->address->EditValue ?>"<?php echo $membership->address->EditAttributes() ?>>
</span>
<?php echo $membership->address->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->nationality->Visible) { // nationality ?>
	<div id="r_nationality" class="form-group">
		<label id="elh_membership_nationality" for="x_nationality" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->nationality->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->nationality->CellAttributes() ?>>
<span id="el_membership_nationality">
<input type="text" data-table="membership" data-field="x_nationality" name="x_nationality" id="x_nationality" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->nationality->getPlaceHolder()) ?>" value="<?php echo $membership->nationality->EditValue ?>"<?php echo $membership->nationality->EditAttributes() ?>>
</span>
<?php echo $membership->nationality->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->mobile->Visible) { // mobile ?>
	<div id="r_mobile" class="form-group">
		<label id="elh_membership_mobile" for="x_mobile" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->mobile->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->mobile->CellAttributes() ?>>
<span id="el_membership_mobile">
<input type="text" data-table="membership" data-field="x_mobile" name="x_mobile" id="x_mobile" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->mobile->getPlaceHolder()) ?>" value="<?php echo $membership->mobile->EditValue ?>"<?php echo $membership->mobile->EditAttributes() ?>>
</span>
<?php echo $membership->mobile->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->_email->Visible) { // email ?>
	<div id="r__email" class="form-group">
		<label id="elh_membership__email" for="x__email" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->_email->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->_email->CellAttributes() ?>>
<span id="el_membership__email">
<input type="text" data-table="membership" data-field="x__email" name="x__email" id="x__email" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->_email->getPlaceHolder()) ?>" value="<?php echo $membership->_email->EditValue ?>"<?php echo $membership->_email->EditAttributes() ?>>
</span>
<?php echo $membership->_email->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->occupation->Visible) { // occupation ?>
	<div id="r_occupation" class="form-group">
		<label id="elh_membership_occupation" for="x_occupation" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->occupation->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->occupation->CellAttributes() ?>>
<span id="el_membership_occupation">
<input type="text" data-table="membership" data-field="x_occupation" name="x_occupation" id="x_occupation" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->occupation->getPlaceHolder()) ?>" value="<?php echo $membership->occupation->EditValue ?>"<?php echo $membership->occupation->EditAttributes() ?>>
</span>
<?php echo $membership->occupation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->level_edu->Visible) { // level_edu ?>
	<div id="r_level_edu" class="form-group">
		<label id="elh_membership_level_edu" for="x_level_edu" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->level_edu->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->level_edu->CellAttributes() ?>>
<span id="el_membership_level_edu">
<input type="text" data-table="membership" data-field="x_level_edu" name="x_level_edu" id="x_level_edu" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->level_edu->getPlaceHolder()) ?>" value="<?php echo $membership->level_edu->EditValue ?>"<?php echo $membership->level_edu->EditAttributes() ?>>
</span>
<?php echo $membership->level_edu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->mentor->Visible) { // mentor ?>
	<div id="r_mentor" class="form-group">
		<label id="elh_membership_mentor" for="x_mentor" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->mentor->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->mentor->CellAttributes() ?>>
<span id="el_membership_mentor">
<input type="text" data-table="membership" data-field="x_mentor" name="x_mentor" id="x_mentor" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->mentor->getPlaceHolder()) ?>" value="<?php echo $membership->mentor->EditValue ?>"<?php echo $membership->mentor->EditAttributes() ?>>
</span>
<?php echo $membership->mentor->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->interest->Visible) { // interest ?>
	<div id="r_interest" class="form-group">
		<label id="elh_membership_interest" for="x_interest" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->interest->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->interest->CellAttributes() ?>>
<span id="el_membership_interest">
<input type="text" data-table="membership" data-field="x_interest" name="x_interest" id="x_interest" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->interest->getPlaceHolder()) ?>" value="<?php echo $membership->interest->EditValue ?>"<?php echo $membership->interest->EditAttributes() ?>>
</span>
<?php echo $membership->interest->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->affiliation->Visible) { // affiliation ?>
	<div id="r_affiliation" class="form-group">
		<label id="elh_membership_affiliation" for="x_affiliation" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->affiliation->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->affiliation->CellAttributes() ?>>
<span id="el_membership_affiliation">
<input type="text" data-table="membership" data-field="x_affiliation" name="x_affiliation" id="x_affiliation" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->affiliation->getPlaceHolder()) ?>" value="<?php echo $membership->affiliation->EditValue ?>"<?php echo $membership->affiliation->EditAttributes() ?>>
</span>
<?php echo $membership->affiliation->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->church->Visible) { // church ?>
	<div id="r_church" class="form-group">
		<label id="elh_membership_church" for="x_church" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->church->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->church->CellAttributes() ?>>
<span id="el_membership_church">
<input type="text" data-table="membership" data-field="x_church" name="x_church" id="x_church" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->church->getPlaceHolder()) ?>" value="<?php echo $membership->church->EditValue ?>"<?php echo $membership->church->EditAttributes() ?>>
</span>
<?php echo $membership->church->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($membership->role->Visible) { // role ?>
	<div id="r_role" class="form-group">
		<label id="elh_membership_role" for="x_role" class="<?php echo $membership_edit->LeftColumnClass ?>"><?php echo $membership->role->FldCaption() ?></label>
		<div class="<?php echo $membership_edit->RightColumnClass ?>"><div<?php echo $membership->role->CellAttributes() ?>>
<span id="el_membership_role">
<input type="text" data-table="membership" data-field="x_role" name="x_role" id="x_role" size="30" maxlength="255" placeholder="<?php echo ew_HtmlEncode($membership->role->getPlaceHolder()) ?>" value="<?php echo $membership->role->EditValue ?>"<?php echo $membership->role->EditAttributes() ?>>
</span>
<?php echo $membership->role->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$membership_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $membership_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $membership_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
fmembershipedit.Init();
</script>
<?php
$membership_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$membership_edit->Page_Terminate();
?>
