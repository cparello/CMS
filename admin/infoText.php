<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  infoText{

private $textNum;

function setTextNum($textNum)  {
		$this->textNum = $textNum;
		}		  


function createTextInfo() {

switch ($this->textNum) {
    case 1:
        $textInfo = 'Use this form to add users to ClubManagerPro';
        break;
    case 2:
        $textInfo = 'Use this form to search users in ClubManagerPro';
        break;
     case 3:
        $textInfo = 'Edit or delete the following information. If you press delete you will be asked if you wish to delete this user';
        break;
     case 4:
        $textInfo = 'Use this form to add employees';
        break;
     case 5:
        $textInfo = 'Use this form to search existing employees';
        break;     
     case 6:
        $textInfo = 'Edit or delete the following information. If you press delete you will be asked if you wish to delete this employee';
        break;                
     case 7:
        $textInfo = 'Use this form to edit employees';
        break;       
     case 8:
        $textInfo = 'Use this form to edit employee commision structure';
        break;     
     case 9:
        $textInfo = 'Use this form to add an employee type. The employee description is optional';
        break; 
     case 10:
        $textInfo = 'Use this form to search  employee types.';
        break;   
     case 11:
        $textInfo = 'Use this to edit or delete employee types.';
        break;       
     case 12:
        $textInfo = 'Use this to edit this employee type.';
        break; 
     case 13:
        $textInfo = 'Use this to form to add services.';
        break; 
     case 14:
        $textInfo = 'Use this to form search existing services.';
        break;     
     case 15:
        $textInfo = 'Use this to edit or delete existing services.';
        break;   
     case 16:
        $textInfo = 'Use this form  to edit this service.';
        break;     
     case 17:
        $textInfo = 'Use this form  to add a service location.';
        break;   
     case 18:
        $textInfo = 'Use this form  to edit this service location.';
        break;      
     case 19:
        $textInfo = 'Choose a service location from the menu below.';
        break; 
     case 20:
        $textInfo = 'Use this form to set the default values for Club and Contract rates and fees.';
        break;   
      case 21:
        $textInfo = 'Use this form to upload and view a logo for use with your Sales Contracts.';
        break;  
      case 22:
        $textInfo = 'Use this to change and edit your sales forms';
        break;   
      case 23:
        $textInfo = 'Use this  to change and edit your  overide PIN number for your sales forms';
        break;  
      case 24:
        $textInfo = 'Use this to designate the payment options used in your contract forms';
        break; 
      case 25:
        $textInfo = 'Use this to update the liabitlity terms and conditions for your contract forms';
        break;
      case 26:
        $textInfo = 'Use this to set Fee and Billing Cycle Dates';
        break; 
      case 27:
        $textInfo = 'Use this to search Client Accounts';
        break;   
      case 28:
        $textInfo = 'Use this to set the expiration time for your notes and their assignment to user groups';
        break;   
      case 29:
        $textInfo = 'Use this to enter cash and check payments as well as NSF entries from your bank';
        break;    
      case 30:
        $textInfo = 'Use this to process pre payments for your monthly subscribers';
        break;  
      case 31:
        $textInfo = 'Use this to print out lists, email clients and print out invoices for your accounts collectible';
        break; 
      case 32:
        $textInfo = 'Use this to configure invoices for your accounts collectible';
        break;   
      case 33:
        $textInfo = 'Use this to search for employees in order to edit time clock entries';
        break; 
      case 34:
        $textInfo = 'Select the timeline from the drop down menu then press edit to view';
        break; 
      case 35:
        $textInfo = 'Enter or edit times and dates. Use the select box(s) to choose the records you wish to update';
        break;  
      case 36:
        $textInfo = 'Use this to search for employees in order to edit payroll for individual employees';
        break;
      case 37:
        $textInfo = 'Select the employee with the checkbox to the right of the record. Press "Edit Selected Records" to process';
        break; 
      case 38:
        $textInfo = 'Use this to process individual payroll, adjust payroll additions and deductions. Click on the bar(s) to view record(s)';
        break;    
      case 39:
        $textInfo = 'Use this to process your payroll. Select the club location and payroll cycle, press "View Club Payroll Results" for processing options';
        break; 
      case 40:
        $textInfo = 'Use this to set the user name and password for the "Member Interface" at each of your Club locations';
        break;    
      case 41:
        $textInfo = 'Use this to set the number of recently sold member listings for each of your Club locations';
        break;   
      case 42:
        $textInfo = 'Use this to set the number of members who have recently checked into each of your Club locations';
        break;   
      case 43:
        $textInfo = 'Use this to create guest passes for each of  your Club locations';
        break; 
      case 44:
        $textInfo = 'Use this to edit or delete your Guest Passes';
        break; 
      case 45:
        $textInfo = 'Use this to edit your Guest Passes';
        break;  
      case 46:
        $textInfo = 'Use this to edit the sender and reply to information when emailing Guest Passes';
        break;    
      case 47:
        $textInfo = 'Use this to create inventory in order to assign this inventory to your Club Location(s) Point of Sale interface';
        break;  
      case 48:
        $textInfo = 'Use this to search then edit your inventory created for your Club Location(s) Point of Sale interface';
        break;  
      case 49:
        $textInfo = 'Use this to search then edit and assign your inventory created for your Club Location(s) Point of Sale interface';
        break;
      case 50:
        $textInfo = 'Use this to  edit and assign your inventory created for your Club Location(s)';
        break;    
      case 51:
        $textInfo = 'Use this to  delete unused categories';
        break; 
      case 52:
        $textInfo = 'Use this to create a QuickBooks&#0174; connection file to access and process your payroll records from your desktop computer';
        break;  
      case 53:
        $textInfo = 'Use this to set the printer type for your POS receipts. You can choose between standard letter or standard thermal receipt format';
        break; 
      case 54:
        $textInfo = 'Use this to configure invoices for your renewable accounts';
        break; 
      case 55:
        $textInfo = 'Use this to print out lists, email clients and print out invoices for your renewable accounts';
        break; 
      case 56:
        $textInfo = 'Use this to provide content for  lists, email and printable letters for your members who have expired and you wish to reinstate';
        break; 
      case 57:
        $textInfo = 'Use this to print out lists, email clients and print out letters for members who have expired services';
        break;      
      case 58:
        $textInfo = 'Use this tool for in depth reports on your current and past sales';
        break;      
      case 59:
        $textInfo = 'Use this tool set up your state overtime parameters';
        break;  
      case 60:
        $textInfo = 'Use this tool to show real time cash flow reports for both your service and retail sales';
        break;   
      case 61:
        $textInfo = 'Use this tool to generate retail sales reports';
        break;   
      case 62:
        $textInfo = 'Use this tool to create reports for past due accounts, declined transactions an balances due';
        break;  
      case 63:
        $textInfo = 'Use this tool to create reports for renewable and expired accounts';
        break;  
      case 64:
        $textInfo = 'Use this tool to create reports of settled transactions for monthly memberships and services';
        break;      
      case 65:
        $textInfo = 'Use this tool to create reports of canceled accounts and memberships placed on hold';
        break;   
      case 66:
        $textInfo = 'Use this tool to create unique categories for services such as classes';
        break;  
      case 67:
        $textInfo = 'Use this tool to edit or delete schedule categories';
        break;   
      case 68:
        $textInfo = 'Use this tool to edit schedule categories';
        break;  
      case 69:
        $textInfo = 'Use this tool to create or add bundled services to your schedule categories';
        break;      
      case 70:
        $textInfo = 'Use this tool to edit or delete bundled services';
        break; 
      case 71:
        $textInfo = 'Use this tool to add Instructors and Class Rooms for your services';
        break; 
      case 72:
        $textInfo = 'Use this tool to add Instructors upload Photos and Descriptions';
        break; 
      case 73:
        $textInfo = 'Use this tool to add Class Rooms to your Schedule Categories';
        break;  
      case 74:
        $textInfo = 'Use this tool to edit Instructors and Class Rooms for your services';
        break; 
      case 75:
        $textInfo = 'Choose an Instructor from this list to edit or delete';
        break;    
      case 76:
        $textInfo = 'Choose a Class Room from this list to edit or delete';
        break;    
      case 77:
        $textInfo = 'Use these tools to create and edit class schedules';
        break;    
      case 78:
        $textInfo = 'Use these tools to create reports to show attrition comparisons, active an inactive accounts';
        break;  
      case 79:
        $textInfo = 'Use these tools to create reports to show attendance records for club access';
        break;     
      case 80:
        $textInfo = 'Use these tools to create reports to show attendance records for club classes and events';
        break;   
      case 81:
        $textInfo = 'Use these tools to create reports that generate payroll information from your clubs';
        break;  
      case 82:
        $textInfo = 'Use these tools to create reports that show the commissions and sales of your sales staff';
        break;  
      case 83:
        $textInfo = 'Use this to edit your CyberSource&#0174 Merchant Gateway options';
        break;                   
      case 84:
        $textInfo = 'Use this to search then edit orders created by web store visitors while purchasing';
        break;
      case 85:
        $textInfo = 'Use this to edit orders created by web store visitors while purchasing. Sort the columns by clicking the column header';
        break;
     }  
     
     
     
   
return "$textInfo";  
}










}

?>