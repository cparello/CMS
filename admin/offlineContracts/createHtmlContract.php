<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class createContract {

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//==============================================================================================
function enhanceFeeText(){
    
    if ($this->enhanceFee != 0.00){
      $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT eft_cycle, pif_cycle_date, term_switch  FROM enhance_fee_cycles  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);
   $stmt->fetch();
   
   //break up the guarentee cycle date
$day = date("d", strtotime($annual_cycle_date));
$month = date("m", strtotime($annual_cycle_date));
$year = date("Y");

$enhanceCycleDateString = "$month/$day/$year";
$enhanceCycleDateSecs = strtotime($enhanceCycleDateString);

//fro semi annual dates
$enhanceCycleDateSecsAnnual = $enhanceCycleDateSecs + 15724800;
$semiAnnual2=  date("F jS", $enhanceCycleDateSecsAnnual+(86400*3)); 

//for quarterly dates
$enhanceCycleDateQuarter2 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year)); 
$enhanceCycleDateQuarter3 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateQuarter4 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));

//for monthly dates
$enhanceCycleDateMonths2 = date("F jS", mktime(0, 0, 0, $month + 1, $day, $year)); 
$enhanceCycleDateMonths3 = date("F jS", mktime(0, 0, 0, $month + 2, $day, $year));
$enhanceCycleDateMonths4 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year));
$enhanceCycleDateMonths5 = date("F jS", mktime(0, 0, 0, $month + 4, $day, $year));
$enhanceCycleDateMonths6 = date("F jS", mktime(0, 0, 0, $month + 5, $day, $year));
$enhanceCycleDateMonths7 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$enhanceCycleDateMonths8 = date("F jS", mktime(0, 0, 0, $month + 7, $day, $year));
$enhanceCycleDateMonths9 = date("F jS", mktime(0, 0, 0, $month + 8, $day, $year));
$enhanceCycleDateMonths10 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$enhanceCycleDateMonths11 = date("F jS", mktime(0, 0, 0, $month + 10, $day, $year));
$enhanceCycleDateMonths12 = date("F jS", mktime(0, 0, 0, $month + 11, $day, $year));

$todaysDateSecs = time();
   
   
   $this->enhanceAnnualCycleDate = date("F jS", strtotime($annual_cycle_date));
   
    switch($eft_cycle) {
        case "A":
        
        $this->enhanceFee = sprintf("%.2f", $this->enhanceFee / 1);
        $this->enhanceRequest = "<p>I acknowledge that an annual enhancement fee of <span class=\"boldLine\">\$$this->enhanceFee</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> this year and on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year.</p>";
        break;
        case "B":
        $this->enhanceFee = sprintf("%.2f", $this->enhanceFee / 2);
        $this->enhanceRequest = "<p>I acknowledge that a bi-annual enhancement fee of <span class=\"boldLine\">\$$this->enhanceFee</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> and <span class=\"boldLine\">$semiAnnual2</span> of this year and on <span class=\"boldLine\">$this->enhanceAnnualCycleDate</span> and <span class=\"boldLine\">$semiAnnual2</span> of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates.</p>";
        break;
        case "Q":
          $this->enhanceFee = sprintf("%.2f", $this->enhanceFee / 4);
        $this->enhanceRequest = "<p>I acknowledge that a quarterly enhancement fee of <span class=\"boldLine\">\$$this->enhanceFee</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$annual_cycle_date</span> $enhanceCycleDateQuarter2 $enhanceCycleDateQuarter3 $enhanceCycleDateQuarter4  this year and on day <span class=\"boldLine\">$annual_cycle_date</span> $enhanceCycleDateQuarter2 $enhanceCycleDateQuarter3 $enhanceCycleDateQuarter4   year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates of each quarter.</p>";
        break;
        case "M":
        $this->enhanceFee = sprintf("%.2f", $this->enhanceFee / 12);
        $this->enhanceRequest = "<p>I acknowledge that a monthly enhancement fee of <span class=\"boldLine\">\$$this->enhanceFee</span> will be charged to each member for the purpose of ongoing club maintenance and upgrades. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$annual_cycle_date</span> of every month of this year and on day <span class=\"boldLine\">$annual_cycle_date</span> of every month of each year thereafter. If there is no year provided the Club Enhancement Fee will be automatically drafted on the following year on the same dates of each month.</p>";
        break;        
        }  
    }else{
        $this->enhanceRequest = "<p></p>";
    }
     

}
//==============================================================================================
function rateFeeText(){
    
    if ($this->rateFee != 0.00){
     $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT eft_cycle, annual_cycle_date, term_switch  FROM guarantee_fee_cycles  WHERE cycle_num = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($eft_cycle, $annual_cycle_date, $term_switch);
   $stmt->fetch();
   
   $annualCycleDate = date("F jS", strtotime($annual_cycle_date));
   
   $day = date("d", strtotime($annual_cycle_date));
$month = date("m", strtotime($annual_cycle_date));
$year = date("Y");
$guaranteeCycleDateString = "$month/$day/$year";
$guaranteeCycleDateSecs = strtotime($guaranteeCycleDateString);

//fro semi annual dates
$guaranteeCycleDateSecsAnnual = date("F jS", $guaranteeCycleDateSecs + 15724800); 

//for quarterly dates
$guaranteeCycleDateQuarter2 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year)); 
$guaranteeCycleDateQuarter3 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateQuarter4 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));

//for monthly dates
$guaranteeCycleDateMonths2 = date("F jS", mktime(0, 0, 0, $month + 1, $day, $year)); 
$guaranteeCycleDateMonths3 = date("F jS", mktime(0, 0, 0, $month + 2, $day, $year));
$guaranteeCycleDateMonths4 = date("F jS", mktime(0, 0, 0, $month + 3, $day, $year));
$guaranteeCycleDateMonths5 = date("F jS", mktime(0, 0, 0, $month + 4, $day, $year));
$guaranteeCycleDateMonths6 = date("F jS", mktime(0, 0, 0, $month + 5, $day, $year));
$guaranteeCycleDateMonths7 = date("F jS", mktime(0, 0, 0, $month + 6, $day, $year));
$guaranteeCycleDateMonths8 = date("F jS", mktime(0, 0, 0, $month + 7, $day, $year));
$guaranteeCycleDateMonths9 = date("F jS", mktime(0, 0, 0, $month + 8, $day, $year));
$guaranteeCycleDateMonths10 = date("F jS", mktime(0, 0, 0, $month + 9, $day, $year));
$guaranteeCycleDateMonths11 = date("F jS", mktime(0, 0, 0, $month + 10, $day, $year));
$guaranteeCycleDateMonths12 = date("F jS", mktime(0, 0, 0, $month + 11, $day, $year));
   
   switch($eft_cycle) {
    case "A":
        $this->rateFee = sprintf("%.2f", $this->rateFee / 1);
        $this->guaranteeRequest ="<p>I acknowledge that an annual rate guarantee fee of <span class=\"boldLine\">\$$this->rateFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$annualCycleDate</span> of this year and on <span class=\"boldLine\">$annualCycleDate</span> of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year.</p>"; 
        break;
    case "B":
        $this->rateFee = sprintf("%.2f", $this->rateFee / 2);
        $this->guaranteeRequest ="<p>I acknowledge that a bi-annual rate guarantee fee of <span class=\"boldLine\">\$$this->rateFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">$annualCycleDate</span> and <span class=\"boldLine\">$guaranteeCycleDateSecsAnnual</span> of this year and on <span class=\"boldLine\">January $annualCycleDate</span> and <span class=\"boldLine\">$guaranteeCycleDateSecsAnnual</span> of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates.</p>";
        break;
    case "Q":
        $this->rateFee = sprintf("%.2f", $this->rateFee / 4);
       $this->guaranteeRequest = "<p>I acknowledge that a quarterly rate guarantee fee of <span class=\"boldLine\">\$$this->rateFee</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$annualCycleDate</span> $guaranteeCycleDateQuarter2 $guaranteeCycleDateQuarter3 $guaranteeCycleDateQuarter4 of every quarter of this year and on day <span class=\"boldLine\">$this->billingDay</span> $annualCycleDate</span> $guaranteeCycleDateQuarter2 $guaranteeCycleDateQuarter3 $guaranteeCycleDateQuarter4of every quarter of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates of each quarter.</p>";
        break;
    case "M":
        $this->rateFee = sprintf("%.2f", $this->rateFee / 12);
        $this->guaranteeRequest ="<p>I acknowledge that a monthly rate guarantee fee of <span class=\"boldLine\">\$$this->rateFee</span>  will be charged to each contract for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on day <span class=\"boldLine\">$annualCycleDate</span> of every month of this year and on day <span class=\"boldLine\">$annualCycleDate</span> of every month of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates of each month.</p>";
        break;
    }
    }else{
        $this->guaranteeRequest ="<p></p>";
    }
    
   // echo $this->guaranteeRequest;
   // exit;
}

//==============================================================================================
function loadStuff(){
    $dbMain = $this->dbconnect();
    
    $stmt = $dbMain ->prepare("SELECT business_name, business_dba, business_address FROM company_names WHERE  business_name !=''");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->businessName, $this->businessDba, $this->businessAddress);  
    $stmt->fetch(); 
    $stmt->close();   

    
    $stmt = $dbMain ->prepare("SELECT contract_terms, liability_terms, contract_quit FROM contract_defaults WHERE  contract_key ='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->contractTerms, $this->liabilityTerms, $this->contractQuit); 
    $stmt->fetch();  
    $stmt->close();  
    
    $stmt = $dbMain ->prepare("SELECT cycle_day, past_day FROM billing_cycle WHERE  cycle_key ='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->billingDay, $this->pastdays);   
    $stmt->fetch();
    $stmt->close();  
    
    $stmt = $dbMain ->prepare("SELECT rate_fee, late_fee, cancel_fee, rejection_fee, nsf_fee, enhance_fee FROM fees WHERE fee_num ='1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($this->rateFee, $this->lateFee, $this->cancelationFee, $this->rejectionFee, $this->nsfFee, $this->enhanceFee); 
    $stmt->fetch();  
    $stmt->close(); 
}          
//------------------------------------------------------------------------------------------    
function createEftFile(){
 $this->loadStuff();
 $this->rateFeeText();
 $this->enhanceFeeText();   
    
    $ourFileName = "../offlineContracts/eft_contract.htm";
    $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

$this->file ="<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>

<script>
function printPage(){
window.print();
}
</script>
	<title>Untitled</title>
</head>
<body>
<div id=\"pageWrap\">
<div id=\"contractHeaders\">
<div id=\"contractType\">
<h1><center>$this->businessName</center></h1>
<span class=\"typeName\"><b>Single Service Agreement</b></span>
<span class=\"pipe\">|</span>
<span class=\"contractNumber\"><b>Contract #_______</b></span>
</div>
</div>
<br />
<br />
<div id=\"hostHeader\">
<span class=\"subHeader\"><b>LIABILITY HOST (Contract Holder)</b></span>
</div>
<div id=\"underline\"></div>

<div id=\"memberInfo\">
<table>

<tr>
<td class=\"nameTitles\">
<b>First Name:</b>
</td>
<td class=\"nameTitles\">
<b>Last Name:</b>
</td>
<td class=\"nameTitles\">
<b>Address:</b>
</td>
<td class=\"nameTitles\">
<b>APT #:</b>
</td>
<td class=\"nameTitles\">
<b>City:</b>
</td>
</tr>

<tr>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>


<tr>

<td class=\"nameTitles\">
<b>State:</b>
</td>
<td class=\"nameTitles\">
<b>Zipcode:</b>
</td>
<td class=\"nameTitles\">
<b>Primary Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Cell Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Email Address:</b>
</td>
</tr>

<tr>

<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>

<br/><br/>
<div id=\"hostHeader\">
<span class=\"subHeader\">Member Information</span>
</div>
<div id=\"underline\"></div>

<div id=\"memberInfo\">
<table>

<tr>
<td class=\"nameTitles\">
<b>First Name:</b>
</td>
<td class=\"nameTitles\">
<b>Last Name:</b>
</td>
<td class=\"nameTitles\">
<b>Address:</b>
</td>
<td class=\"nameTitles\">
<b>APT #:</b>
</td>
<td class=\"nameTitles\">
<b>City:</b>
</td>
</tr>

<tr>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>


<tr>

<td class=\"nameTitles\">
<b>State:</b>
</td>
<td class=\"nameTitles\">
<b>Zipcode:</b>
</td>
<td class=\"nameTitles\">
<b>Primary Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Cell Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Email Address:</b>
</td>
</tr>

<tr>

<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>
<br />
<br />
<div id=\"agreeLine\">
<b>It is agreed by and between \"$this->businessName\" (d.b.a. \"$this->businessDba\"), hereinafter,
\"$this->businessName\", and Liability Host and/or the Contract Holder named above, as follows:</b>
</div>

<br />
<br />

<div id=\"summaryHeader\">
<span class=\"subHeader\"><b><Center><h5>SERVICE SUMMARY</h5></Center></b></span>
</div>
<div id=\"summaryInfo\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"nameTitles\">
<b>Quantity</b>
</td>
<td class=\"nameTitles\">
<b>&nbsp;&nbsp;Service Name</b>
</td>
<td class=\"nameTitles\">
<b>&nbsp;&nbsp;Service Location</b>
</td>
<td class=\"nameTitles\">
<b>&nbsp;&nbsp;Service Duration</b>
</td>
<td class=\"nameTitles\">
<b>&nbsp;&nbsp;Unit Cost</b>
</td>

</tr>
<tr>
<td class=\"fieldValues\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"1\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"All Locations\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\" >
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>

</tr>

<tr>
<td class=\"fieldHeader\">
<b>Unit Renew Rate</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Group Cost</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Group Renew Rate</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Start Date</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;End Date</b>
</td>
</tr>
<tr>
<td class=\"fieldValues\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"NA\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"NA\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<br />
<br />

<tr>
<td class=\"fieldHeader pad\">
<b>Transferable</b>
</td>
<td  class=\"fieldValues\">
(Yes/No)
</td>
</tr>
<br />
</table>
</div>

<br />
<div id=\"initialHeader\">
<span class=\"subHeader\"><b><center><h5>Payment Information</h5></center></b></span>
</div>
<div id=\"underline3\"></div>

<div id=\"initialPayments\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"nameTitles2\"><b>Credit Card Name:</b>
</td>
<td class=\"nameTitles2\"><b>&nbsp;&nbsp;Credit Card Number:</b>
</td>
<td class=\"nameTitles2\">
&nbsp;&nbsp;<b>Expiration Date</b>:
</td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>CVV:</b></td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>Card Type:</b></td>
</tr>
<tr>
<td class=\"nameSakes2\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<tr>
<td class=\"nameTitles2\"><b>Bank Name:</b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>Bank Account Number:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>Routing Number:</b><span class=\"dueDate\">
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<tr>
<td class=\"nameTitles2\"><b>Check Name:</b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>Check Number:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>Bank Name:</b><span class=\"dueDate\">
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>

<div id=\"initialHeader\">
<span class=\"subHeader\"><b><center><h5>INITIAL PAYMENTS</h5></center></b></span>
</div>
<div id=\"underline3\"></div>

<div id=\"initialPayments\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"nameTitles2\"><b>Processing Fee (Monthly Services):</b>
</td>
<td class=\"nameTitles2\">
&nbsp;&nbsp;<b>Prorate Dues (Monthly Services):</b>
</td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>TOTAL DUE:</b></td>
<td class=\"fieldHeader pad\">
<b>&nbsp;&nbsp;Monthly Dues</b>
</td>
</tr>
<tr>
<td class=\"nameSakes2\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>

</tr>
<tr>
<td class=\"nameTitles2\"><b>TODAYS PAYMENT:<b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>BALANCE DUE:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>DUE DATE:</b><span class=\"dueDate\">
<td class=\"fieldHeader pad\">
<b>&nbsp;&nbsp;Term Type</b>
</td>
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"TERM\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>


</table>
</div>


<div id=\"terms\">
<p>
$this->contractTerms<br>$this->liabilityTerms
</p>
</div>

<div id=\"monthlyHeader\">
<span class=\"subHeader\">MONTHLY TRANSACTION REQUEST:</span>
</div>
<div id=\"underline4\"></div>
<div id=\"billingRequest\"> <p>I authorize my credit card or ACH company to make a payment of <span class=\"boldLine\">$<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"3\" maxlength=\"3\"/>.<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"2\" maxlength=\"2\"/></span> and charge it to my account on or close to day <span class=\"boldLine\">$this->billingDay</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">$this->rejectionFee</span> for Credit cards and <span class=\"boldLine\">$this->nsfFee</span> for ACH will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">$this->lateFee</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">$this->pastdays</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>$this->guaranteeRequest<br>$this->enhanceRequest <p class=\"collect\">The first payment of <span class=\"boldLine\">$<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"3\" maxlength=\"3\"/>.<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"3\" maxlength=\"2\"/></span> shall be collected on <span class=\"boldLine\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"8\" maxlength=\"8\"/>$this->billingDay, 20<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"2\" maxlength=\"2\"/></span> for the month of <span class=\"boldLine\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"10\" maxlength=\"10\"/> 20__</span>.</p> <p>Cancellation: I understand that I am in full control of my payment in accordance with this service agreement,
and if at any time, after the $this->contractQuit day cancellation procedure above, I decide to discontinue, I will simply notify $this->businessName , in writing by no later than 10th of the desired month of cancellation. (This provision does not apply to a Paid In Full Service Agreement or Open Ended Service Aggreement) Notification after the 10th of the desired month will require an additional 1 month of fees. Not applicable to any cancellation fees otherwise due. To cancel, I will include a legible copy of agreement or cancellation form, ORIGINAL MEMBERSHIP CARD and \$$this->cancelationFee cancellation fee. Such notice shall be sent to $this->businessName, $this->businessAddress. Any variations from the cancellation procedure may result in a delay in processing cancellation.</p> </div>

<div id=\"signUp\">
  <p><b>Executed at $this->businessName $this->businessAddress on DATE: <input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></b></p>
</div>

<div id=\"signHouse\">
<div id=\"signLine1\"><span class=\"signatures\">CONTRACTOR HOLDER SIGNATURE_______________________________________</span></div>
<div id=\"signLine2\"><span class=\"signatures\">SIGNATURE OF CLUB REPRESENTATIVE__________________________________</span></div>
</div>

</div>
</body> 
</html>";
                            
   fwrite($ourFileHandle, $this->file);                
        
   fclose($ourFileHandle);
        
 $this->successBit = 1;
 
}
//------------------------------------------------------------------------------------------    
function createPifFile(){
    
$this->loadStuff();

    $ourFileName = "../offlineContracts/pif_contract.htm";
    $ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");

$this->file ="
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>

<script>
function printPage(){
window.print();
}
</script>
	<title>Untitled</title>
</head>
<body>
<div id=\"pageWrap\">
<div id=\"contractHeaders\">
<div id=\"contractType\">
<h1><center>$this->businessName</center></h1>
<span class=\"typeName\"><b>Single Service Agreement</b></span>
<span class=\"pipe\">|</span>
<span class=\"contractNumber\"><b>Contract #_______</b></span>
</div>
</div>
<br />
<br />
<div id=\"hostHeader\">
<span class=\"subHeader\"><b>LIABILITY HOST (Contract Holder)</b></span>
</div>
<div id=\"underline\"></div>

<div id=\"memberInfo\">
<table>

<tr>
<td class=\"nameTitles\">
<b>First Name:</b>
</td>
<td class=\"nameTitles\">
<b>Last Name:</b>
</td>
<td class=\"nameTitles\">
<b>Address:</b>
</td>
<td class=\"nameTitles\">
<b>APT #:</b>
</td>
<td class=\"nameTitles\">
<b>City:</b>
</td>
</tr>

<tr>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>


<tr>

<td class=\"nameTitles\">
<b>State:</b>
</td>
<td class=\"nameTitles\">
<b>Zipcode:</b>
</td>
<td class=\"nameTitles\">
<b>Primary Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Cell Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Email Address:</b>
</td>
</tr>

<tr>

<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>

<br/><br/>
<div id=\"hostHeader\">
<span class=\"subHeader\">Member Information</span>
</div>
<div id=\"underline\"></div>

<div id=\"memberInfo\">
<table>

<tr>
<td class=\"nameTitles\">
<b>First Name:</b>
</td>
<td class=\"nameTitles\">
<b>Last Name:</b>
</td>
<td class=\"nameTitles\">
<b>Address:</b>
</td>
<td class=\"nameTitles\">
<b>APT #:</b>
</td>
<td class=\"nameTitles\">
<b>City:</b>
</td>
</tr>

<tr>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>


<tr>

<td class=\"nameTitles\">
<b>State:</b>
</td>
<td class=\"nameTitles\">
<b>Zipcode:</b>
</td>
<td class=\"nameTitles\">
<b>Primary Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Cell Phone:</b>
</td>
<td class=\"nameTitles\">
<b>Email Address:</b>
</td>
</tr>

<tr>

<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"(   )-   -   \" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>
<br />
<br />
<div id=\"agreeLine\">
<b>It is agreed by and between \"$this->businessName\" (d.b.a. \"$this->businessDba\"), hereinafter,
\"$this->businessName\", and Liability Host and/or the Contract Holder named above, as follows:</b>
</div>

<br />
<br />

<div id=\"summaryHeader\">
<span class=\"subHeader\"><b><Center><h5>SERVICE SUMMARY</h5></Center></b></span>
</div>
<div id=\"summaryInfo\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"fieldHeaderTop\">
<b>Quantity</b>
</td>
<td class=\"fieldHeaderTop\">
<b>&nbsp;&nbsp;Service Name</b>
</td>
<td class=\"fieldHeaderTop\">
<b>&nbsp;&nbsp;Service Location</b>
</td>
<td class=\"fieldHeaderTop\">
<b>&nbsp;&nbsp;Service Duration</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Unit Cost</b>
</td>

</tr>
<tr>
<td class=\"fieldValues\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"1\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"All Locations\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\" >
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>

</tr>

<tr>
<td class=\"fieldHeader\">
<b>Unit Renew Rate</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Group Cost</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Group Renew Rate</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;Start Date</b>
</td>
<td class=\"fieldHeader\">
<b>&nbsp;&nbsp;End Date</b>
</td>
</tr>
<tr>
<td class=\"fieldValues\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"NA\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"NA\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"fieldValues\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<br />
<br />

<tr>
<td class=\"fieldHeader pad\">
<b>Transferable</b>
</td>
<td  class=\"fieldValues\">
(Yes/No)
</td>
</tr>
<br />
</table>
</div>

<br />
<div id=\"initialHeader\">
<span class=\"subHeader\"><b><center><h5>Payment Information</h5></center></b></span>
</div>
<div id=\"underline3\"></div>

<div id=\"initialPayments\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"nameTitles2\"><b>Credit Card Name:</b>
</td>
<td class=\"nameTitles2\"><b>&nbsp;&nbsp;Credit Card Number:</b>
</td>
<td class=\"nameTitles2\">
&nbsp;&nbsp;<b>Expiration Date</b>:
</td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>CVV:</b></td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>Card Type:</b></td>
</tr>
<tr>
<td class=\"nameSakes2\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<tr>
<td class=\"nameTitles2\"><b>Bank Name:</b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>Bank Account Number:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>Routing Number:</b><span class=\"dueDate\">
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
<tr>
<td class=\"nameTitles2\"><b>Check Name:</b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>Check Number:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>Bank Name:</b><span class=\"dueDate\">
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>

<div id=\"initialHeader\">
<span class=\"subHeader\"><b><center><h5>INITIAL PAYMENTS</h5></center></b></span>
</div>
<div id=\"underline3\"></div>

<div id=\"initialPayments\">
<table cellpadding=\"0\" cellspacing=\"0\">
<tr>
<td class=\"nameTitles2\"><b>Processing Fee (PIF Services):</b>
</td>
<td class=\"nameTitles2\">
&nbsp;&nbsp;<b>Paid In Full Service Cost(s):</b>
</td>
<td class=\"nameTitles2 pad\">&nbsp;&nbsp;<b>TOTAL DUE:</b></td>

</tr>
<tr>
<td class=\"nameSakes2\">
<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes4 pad\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>

</tr>
<tr>
<td class=\"nameTitles2\"><b>TODAYS PAYMENT:/<b></td>
<td class=\"nameTitles2\">&nbsp;&nbsp;<b>BALANCE DUE:</b></td>
<td class=\"nameSakes3\">&nbsp;&nbsp;<b>DUE DATE:</b><span class=\"dueDate\">
</tr>
<tr>
<td class=\"nameSakes2\"><input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></td>
<td class=\"nameSakes2\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
<td class=\"nameSakes3\">
&nbsp;&nbsp;<input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/>
</td>
</tr>
</table>
</div>

<div id=\"terms\">
<p>
$this->contractTerms<br>$this->liabilityTerms
</p>
</div>


<div id=\"signUp\">
  <p><b>Executed at  $this->businessName $this->businessAddress  on DATE: <input name=\"city\" type=\"text\" id=\"city\" value=\"\" size=\"25\" maxlength=\"30\"/></b></p>
</div>

<div id=\"signHouse\">
<div id=\"signLine1\"><span class=\"signatures\"><b>CONTRACTOR HOLDER SIGNATURE_______________________________________________</b></span></div>
<br />
<div id=\"signLine2\"><span class=\"signatures\"><b>SIGNATURE OF CLUB REPRESENTATIVE___________________________________________</b></span></div>
</div>

</div>
</body>
</html>";
                            
   fwrite($ourFileHandle, $this->file);                
        
   fclose($ourFileHandle);
        
 $this->successBit = 1;
 
}
//--------------------------------------------------------------------------------------------
function getSuccessBit() {
      return($this->successBit);
      }
//--------------------------------------------------------------------------------------------

}
//==============================================================================================
$ajax_switch = $_REQUEST['ajax_switch'];


if($ajax_switch == 2) {
  $loadData = new createContract();
  $loadData-> createEftFile();
  $successBit = $loadData-> getSuccessBit();
  echo"$successBit";
  exit;
  }
  
if($ajax_switch == 1) {
  $loadData = new createContract();
  $loadData-> createPifFile();
  $successBit = $loadData-> getSuccessBit();
  echo"$successBit";
  exit;
  }

?>