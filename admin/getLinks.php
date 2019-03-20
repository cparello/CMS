<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  getLinks {

	public $filePerms;
	public $fileLinks;
	public $checkBox;

function setFilePerms($filePerms)  {
         if($filePerms == "") {
         $filePerms = '000000000000000';
         }
		$this->file_perms = $filePerms;
		  }

function setFileLinks($fileLinks)  {
		$this->file_links = $fileLinks;
		  }

function setCheckBox($checkBox)  {
		$this->check_box = $checkBox;
		  }

//----------------------------------------------------------------------------------------------------------------------
function loadMenus()  {

//Create definitions 

$num_results = strlen($this->file_perms);
$bit_array = str_split($this->file_perms);

for($i=0; $i <= $num_results; $i++)  {

switch ($i) {
    case 0:
       if ($bit_array[$i] == 1) {
         $this->file_links .= "<p class=\"list_head\">Add/Edit Users</p>
		<div class=\"list_body\">
        <a class=\"listLinks\" href = \"addUsers.php\" target=\"content\">Add New User</a><br>
        <a class=\"listLinks\" href = \"searchUsers.php\" target=\"content\">Search/Edit  Users</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
      $this->check_box .= "<tr>
       <td class=\"black\">
        Add/Edit Users:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"1\" $checked>    
       <td>
       </tr> ";       
        break;
   case 1:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Add/Edit Services</p>
		<div class=\"list_body\">
        <a class=\"listLinks\" href = \"services/addService.php\" target=\"content\">Add Services</a><br>
        <a class=\"listLinks\" href = \"services/searchServices.php\" target=\"content\">Search/Edit Services</a><br>
        <a class=\"listLinks\" href = \"clubs/addLocation.php\" target=\"content\">Add Service Location</a><br>
        <a class=\"listLinks\" href = \"clubs/editLocation.php\" target=\"content\">Edit Service Location</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Add/Edit Services:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"3\" $checked>    
       <td>
       </tr> ";       
        break;           
    case 2:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Add/Edit Employees</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"employees/addEmployee.php\" target=\"content\">Add Employee</a><br>
        <a class=\"listLinks\" href = \"employees/searchEmployee.php\" target=\"content\">Search/Edit Employee</a><br>
        <a class=\"listLinks\" href = \"employees/addEmployeeType.php\"  target=\"content\">Add Employee Type</a><br>
        <a class=\"listLinks\" href = \"employees/searchEmployeeType.php\"  target=\"content\">Search/Edit Employee Type</a>
		</div>\n";
	    $checked = 'checked';
        }else{
        $checked ="";
        }      
       $this->check_box .= "<tr>
       <td class=\"black\">
        Add/Edit Employees:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"2\" $checked>    
       <td>
       </tr> ";       	
        break;  
    case 3:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Contract Tools</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"contracts/editFees.php\" target=\"content\">Edit Grace Periods/Fees/Rates</a><br>		
        <a class=\"listLinks\" href = \"contracts/setLogo.php\" target=\"content\">Set Company Logo</a><br>
        <a class=\"listLinks\" href = \"contracts/editTerms.php\" target=\"content\">Edit Contract Terms</a><br>
        <a class=\"listLinks\" href = \"contracts/editLibTerms.php\" target=\"content\">Edit Liability Terms</a><br>
         <a class=\"listLinks\" href = \"contracts/editPaymentOptions.php\" target=\"content\">Edit Payment Options</a><br>
        <a class=\"listLinks\" href = \"contracts/editPins.php\" target=\"content\">Edit Overide PIN</a><br>
        <a class=\"listLinks\" href = \"billing/editInvoices.php\" target=\"content\">Edit Billing Invoice Options</a><br>
        <a class=\"listLinks\" href = \"billing/editRenewalInvoices.php\" target=\"content\">Edit Renewal Invoice Options</a><br>
        <a class=\"listLinks\" href = \"offlineContracts/loadHtmlContract.php\" target=\"content\">Create Offline Contracts</a><br>
        <a class=\"listLinks\" href = \"contracts/editMonthlyBillingSetup.php\" target=\"content\">Edit Initial Monthly Payment Setup</a><br>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Contract Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"4\" $checked>    
       <td>
       </tr> ";       
        break;     
    case 4:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Billing Tools</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"billing/searchAccounts.php\" target=\"content\">Search Client Accounts</a><br>
		<a class=\"listLinks\" href = \"billing/manualTransactions.php\" target=\"content\">Enter Manual Transactions</a><br>
		<a class=\"listLinks\" href = \"billing/accountsCollectible.php\" target=\"content\">Accounts Collectible</a><br>
		<a class=\"listLinks\" href = \"billing/accountsRenewable.php\" target=\"content\">Accounts Renewable</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Billing Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"5\" $checked>    
       <td>
       </tr> ";       
        break;     
        
    case 5:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Recursive Billing</p>
		<div class=\"list_body\">
        <a class=\"listLinks\" href = \"contracts/editCycleDates.php\" target=\"content\">Edit Payment Cycle Dates</a><br>
        <a class=\"listLinks\" href = \"contracts/viewReportsBilling.php\" target=\"content\">View Credit Card Reports</a><br>
        <a class=\"listLinks\" href = \"contracts/runManualBilling.php\" target=\"content\">Run Manual Billing</a><br>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Recursive Billing:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"6\" $checked>    
       <td>
       </tr> ";       
        break;             
        
       case 6:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Utilities</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"utilities/manageNotes.php\" target=\"content\">Edit Note Assignment / Duration</a><br>
        <a class=\"listLinks\" href = \"utilities/searchDeletedNotes.php\" target=\"content\">Search Deleted Notes</a><br>
        <a class=\"listLinks\" href = \"accounting/trainerSearch.php\" target=\"content\">Search Trainer Stats</a><br>
        <a class=\"listLinks\" href = \"accounting/salespersonSearch.php\" target=\"content\">Search Salesperson Stats</a><br>
        <a class=\"listLinks\" href = \"accounting/salespersonSearch2.php\" target=\"content\">Search Sales Appointment Stats</a><br>
        <a class=\"listLinks\" href = \"utilities/editSalesScheduleHours.php\" target=\"content\">Edit Sales Schedule Hours Setup</a><br>
		<a class=\"listLinks\" href = \"utilities/editMerchantId.php\" target=\"content\">Edit CyberSource&#0174; Options</a><br>
        <a class=\"listLinks\" href = \"utilities/editFdMerchantId.php\" target=\"content\">Edit NMI&#0174; Options</a><br>
        <a class=\"listLinks\" href = \"utilities/editFdCauOptions.php\" target=\"content\">Edit FirstData&#0174; Account Updater Options</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Utilities:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"7\" $checked>    
       <td>
       </tr> ";       
        break;                     
       case 7:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Payroll Tools</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"accounting/timeClockSearch.php\" target=\"content\">Edit Employee Time Clock</a><br>
        <a class=\"listLinks\" href = \"accounting/attendenceVariances.php\" target=\"content\">View Attendence Variances</a><br>
        <a class=\"listLinks\" href = \"accounting/payrollSearch.php\" target=\"content\">Calculate Individual Payroll</a><br>
		<a class=\"listLinks\" href = \"accounting/searchPayrollSettled.php\" target=\"content\">View Settled Payroll</a><br>
		<a class=\"listLinks\" href = \"accounting/payrollClubSearch.php\" target=\"content\">Calculate Club Payroll</a><br>
		<a class=\"listLinks\" href = \"accounting/loadQwc.php\" target=\"content\">QuickBooks&#0174; Web Connector</a><br>
        <a class=\"listLinks\" href = \"accounting/editSalesPayrollSetup.php\" target=\"content\">Sales Pay Setup</a><br>
        <a class=\"listLinks\" href = \"accounting/editPtPayrollSetup.php\" target=\"content\">Personal Training Pay Setup</a><br>
		<a class=\"listLinks\" href = \"accounting/otOptions.php\" target=\"content\">Set Overtime Options</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Payroll Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"8\" $checked>    
       <td>
       </tr> ";       
        break; 
       case 8:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Member Interface</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"memberinterface/memIntPasswords.php\" target=\"content\">Set Member Interface Passwords</a><br>
		<a class=\"listLinks\" href = \"memberinterface/newMemberListings.php\" target=\"content\">Set New Member Listings</a><br>
		<a class=\"listLinks\" href = \"memberinterface/checkInListings.php\" target=\"content\">Set Check In History</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Member Interface:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"9\" $checked>    
       <td>
       </tr> ";       
        break; 
       case 9:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Marketing Tools</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"marketingtools/createGuestPass.php\" target=\"content\">Create Guest Pass</a><br>
		<a class=\"listLinks\" href = \"marketingtools/viewGuestPasses.php\" target=\"content\">Edit Delete Guest Pass</a><br>
		<a class=\"listLinks\" href = \"marketingtools/editGuestPassEmail.php\" target=\"content\">Edit Guest Pass Email</a><br>
		<a class=\"listLinks\" href = \"marketingtools/editExpiredEnroll.php\" target=\"content\">Edit Expired/ Re-enrollment</a><br>
		<a class=\"listLinks\" href = \"marketingtools/processExpiredEnroll.php\" target=\"content\">Process Expired/ Re-enrollment</a><br>
        <a class=\"listLinks\" href = \"marketingtools/editPromo.php\" target=\"content\">Edit Promotion</a><br>
		<a class=\"listLinks\" href = \"marketingtools/processPromo.php\" target=\"content\">Process Promo</a><br>
        <a class=\"listLinks\" href = \"marketingtools/salespersonSearch3.php\" target=\"content\">Generate Schedule Leads</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Marketing Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"10\" $checked>    
       <td>
       </tr> ";       
        break;
       case 10:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Point of Sale</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"pos/createInventory.php\" target=\"content\">Create Inventory</a><br>
		<a class=\"listLinks\" href = \"pos/searchInventory.php\" target=\"content\">Search Edit Inventory</a><br>
		<a class=\"listLinks\" href = \"pos/searchClubInventory.php\" target=\"content\">Search Assign Inventory</a><br>
		<a class=\"listLinks\" href = \"pos/deleteCategories.php\" target=\"content\">Delete Categories</a><br>
		<a class=\"listLinks\" href = \"pos/printerOptions.php\" target=\"content\">Printer Options</a><br>
        <a class=\"listLinks\" href = \"billing/searchAccountsPOS.php\" target=\"content\">POS History</a><br>
        <a class=\"listLinks\" href = \"billing/searchVoidPos.php\" target=\"content\">Void POS Sale</a><br>
        <a class=\"listLinks\" href = \"billing/searchVoidAccountsPOS.php\" target=\"content\">Search Returned POS History</a><br>
        <a class=\"listLinks\" href = \"pos/editPosPage.php\" target=\"content\">Edit POS page</a><br>
		<a class=\"listLinks\" href = \"pos/searchOrders.php\" target=\"content\">Search Process Orders <small>(old style)</small></a><br>
		<a class=\"listLinks\" href = \"pos/searchOrders.php?marker=1\" target=\"content\">Search Process Orders</a><br>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Point of Sale:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"11\" $checked>    
       <td>
       </tr> ";       
        break;
       case 11:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Reporting Tools</p>
		<div class=\"list_body\">
        <a class=\"listLinks\" href = \"reports/collectionsReport.php\" target=\"content\">Collections Report</a><br>
        <a class=\"listLinks\" href = \"reports/memberReports.php\" target=\"content\">Member Reports</a><br>
        <a class=\"listLinks\" href = \"reports/billingInfoReport.php\" target=\"content\">Billing Reports</a><br>
        <a class=\"listLinks\" href = \"reports/salesReport.php\" target=\"content\">Sales Reports</a><br>
        <a class=\"listLinks\" href = \"reports/initilBalanceDue.php\" target=\"content\">Initial Balance Report</a><br>
        <a class=\"listLinks\" href = \"reports/renewalReports.php\" target=\"content\">Renewal Reports</a><br>
        <a class=\"listLinks\" href = \"reports/trainerSearch.php\" target=\"content\">Trainer Stats</a><br>
        <a class=\"listLinks\" href = \"reports/salespersonSearch.php\" target=\"content\">Salesperson Stats</a><br>
        <a class=\"listLinks\" href = \"reports/salespersonSearch2.php\" target=\"content\">Sales Appointment Stats</a><br>
        <a class=\"listLinks\" href = \"reports/salesReport.php\" target=\"content\">Sales Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createSalesReports.php\" target=\"content\">Gross Sales Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createRevenueReports.php\" target=\"content\">Cash Flow Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createRetailReports.php\" target=\"content\">Retail Sales Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createCollectibleReports.php\" target=\"content\">Accounts Collectible Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createRenewableReports.php\" target=\"content\">Accounts Renewable Reports</a><br>
		<a class=\"listLinks\" href = \"reports/createMonthlySettledReports.php\" target=\"content\">Monthly Settled Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createHoldCancelReports.php\" target=\"content\">Hold Cancel Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createActiveInactiveReports.php\" target=\"content\">Active & Inactive Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createClubAttendanceReports.php\" target=\"content\">Club Attendance Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createClassAttendanceReports.php\" target=\"content\">Class Attendance Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createPayrollReports.php\" target=\"content\">Payroll Reports</a><br>
	    <a class=\"listLinks\" href = \"reports/createCommissionReports.php\" target=\"content\">Commission Reports</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Reporting Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"12\" $checked>    
       <td>
       </tr> ";       
        break;  
       case 12:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Scheduling Tools</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"scheduler/addScheduleType.php\" target=\"content\">Add Schedule Category</a><br>
		<a class=\"listLinks\" href = \"scheduler/editScheduleType.php\" target=\"content\">Edit Schedule Category</a><br>
		<a class=\"listLinks\" href = \"scheduler/addScheduleBundle.php\" target=\"content\">Add Schedule Bundle</a><br>
 	    <a class=\"listLinks\" href = \"scheduler/addBundleDescription.php\" target=\"content\">Add Bundle Description</a><br>
		<a class=\"listLinks\" href = \"scheduler/editScheduleBundle.php\" target=\"content\">Edit Schedule Bundle</a><br>
        <a class=\"listLinks\" href = \"scheduler/editBundleDescription.php\" target=\"content\">Edit Bundle Description</a><br>
		<a class=\"listLinks\" href = \"scheduler/addInstructorsRooms.php\" target=\"content\">Add Instructors / Class Rooms</a><br>
		<a class=\"listLinks\" href = \"scheduler/editInstructorsRooms.php\" target=\"content\">Edit Instructors / Class Rooms</a><br>
        <a class=\"listLinks\" href = \"scheduler/nonMemberClassPrice.php\" target=\"content\">Edit Non-Member Class Options</a><br>
		<a class=\"listLinks\" href = \"scheduler/createClassSchedules.php\" target=\"content\">Create Class Schedules</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Scheduling Tools:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"13\" $checked>    
       <td>
       </tr> ";       
        break;                                     
       case 13:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Tutorials</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href = \"\" target=\"content\">Add/Edit Users Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Add/Edit Services Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Add/Edit Employees Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Contract Tools Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Billing Tools Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Utilities Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Payroll Tools Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Member Interface Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Marketing Tools Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Point of Sale Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Reporting Tools Tutorial</a><br>
		<a class=\"listLinks\" href = \"\" target=\"content\">Scheduling Tools Tutorial</a>		
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Tutorials:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"14\" $checked>    
       <td>
       </tr> ";       
        break;  
        case 14:
       if ($bit_array[$i] == 1) {
        $this->file_links .= "<p class=\"list_head\">Website</p>
		<div class=\"list_body\">
		<a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteColors.php\" target=\"content\">Homepage Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editLinkBarOptions.php\" target=\"content\">Link Bar Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteLocationsPage.php\" target=\"content\">Locations Page Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editJoinPage.php\" target=\"content\">Join Page Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editTrainerBuyPage.php\" target=\"content\">Trainer Buy Page Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editOwnerInfoPage.php\" target=\"content\">Owner Info Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteGreenCompany.php\" target=\"content\">Green Company Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteCompanyMission.php\" target=\"content\">Company Mission Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteStoreOptions.php\" target=\"content\">Store Options Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editStoreProductsInfoPage.php\" target=\"content\">Store Products Options Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsiteNews.php\" target=\"content\">Website Newsletter Setup</a><br>
        <a class=\"listLinks\" href =  \"website/webAdmin/editWebsitePromo.php\" target=\"content\">Promo Setup</a>
		</div>\n";
		$checked = 'checked';
        }else{
        $checked ="";
        }      
        $this->check_box .= "<tr>
       <td class=\"black\">
        Website:
       </td>
       <td>
       <input type=\"checkbox\" name=\"access\" value=\"15\" $checked>    
       <td>
       </tr> ";       
        break;                                                   
     }

}

//setthe file links 
//$this->file_links = $handle;


}
//-------------------------------------------------------------------------------------------------------------
//get the drop down menus
   function getFileLinks()   {
		return($this->file_links);
    	}

//get check boxes
  function getCheckBox()  {
		return($this->check_box);
		  }

}



?>