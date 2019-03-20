<?php
$ptBool = $_REQUEST['ptBool'];
if($ptBool == '1'){
    include "trainingSalesSql.php";
    //echo"test";
}elseif($ptBool == '2'){
    include "renewalSalesSql.php";
}else{
   include "salesSql.php"; 
}
session_start();
$salesSql = $_SESSION['salesSql'];

//echo "$ptBool";
//exit;

$location_id = $salesSql-> getLocationId();
$club_location = $salesSql->getClubLocation();
$product_list = $salesSql-> getProductList();
$contractKey = $salesSql-> getContractKey();
$monthly_billing_type = $salesSql-> getMonthlyBillingType();
$group_type = $salesSql-> getGroupType();
$group_type_info = $salesSql-> getGroupTypeInfo();
$client_info = $salesSql-> getContractClientInfo();
$group_number = $salesSql-> getGroupNumber();
$term_type = $salesSql-> getTermType();
$transfer = $salesSql-> getTransfer();
$pro_rate_dues = $salesSql-> getProRateDues();
$process_fee_eft = $salesSql-> getProcessFeeMonth();
$down_payment = $salesSql-> getDownPayment();
$initiation_fee = $salesSql-> getInitiationFee();
$process_fee_pif = $salesSql-> getProcessFeePif();
$pre_paid_services = $salesSql-> getPifServicesTotal();
$pre_paid_services = sprintf("%.2f", $pre_paid_services);
$today_payment = $salesSql-> getTodaysPayment(); 
$balance_due = $salesSql-> getBalanceDue();
$balance_due_date = $salesSql->getDueDate();
$monthly_payment = $salesSql-> getMonthlyDues();
$date_picker = $salesSql-> getDatePicker();
$sig = $salesSql-> getSig();
$signUpDate = $salesSql-> getSignupDate();
$saleArray = $salesSql-> getSalesArray();
$pifQuantity = $salesSql-> getPifLength();
$eftQuantity = $salesSql-> getEftLength();
$servTermArray = $salesSql-> getServiceTermArray();
$conKeyArray = $salesSql-> getConKeyArray();
$totalServiceArray = $salesSql-> getTotalServiceArray();
$totalGearArray = $salesSql-> getTotalGearArray();
/*$memberInfoArray = $salesSql-> getNameAddArray();
$hostBillingInfo = $salesSql-> getHostBillingInfoArray();

$monthly_billing_type = $salesSql-> getMonthlyBilling();
$length = $salesSql-> getLength();
$hostBool = $salesSql-> getHostBool();*/
//echo "$contractKey a $saleArray b $product_list";


include "contractSql.php";
$contractSql = new contractSql();
$contractSql-> setPtBool($ptBool);
$contractSql-> loadContractDefaults();
$logo_image = $contractSql-> getLogoImage();
$contract_terms = $contractSql-> getContractTerms();
$contract_quit = $contractSql-> getContractQuit();

//$contractSql-> setSalesArray($saleArray);

$contract_type = 'S';
        //$contractSql-> setDatePicker($date_picker);
        /*$contractSql-> setMemberInfoArray($memberInfoArray);
        $contractSql-> setHostBillingInfoArray($hostBillingInfo);*/
        
        
        $contractSql-> setMonthlyBillingType($monthly_billing_type);
        $contractSql-> setServTermArray($servTermArray);
        $contractSql-> setPifQuantity($pifQuantity);
        $contractSql-> setEftQuantity($eftQuantity);
        $contractSql-> setSig($sig);
        $contractSql-> setTotalServiceArray($totalServiceArray);
        $contractSql-> setTotalGearArray($totalGearArray);
        $contractSql-> setGroupType($group_type);
        $contractSql-> setGroupTypeInfo($group_type_info);
        $contractSql-> parseGroupTypeInfo();
        $contractSql-> setContractType($contract_type);
        $contractSql-> loadContractType();
        $contract_type_header = $contractSql-> getContractTypeHeader();
        $contractSql-> parseContactInfo($client_info);
        $group_info = $contractSql-> getGroupTypeInfo();
        $first_name = $contractSql-> getFirstName();
        $middle_name = $contractSql-> getMiddleName();
        $last_name = $contractSql-> getLastName();
        $street_address = $contractSql-> getStreetAddress();
        $primary_phone = $contractSql-> getPrimaryPhone();
        $cell_phone = $contractSql-> getCellPhone();
        $email_address = $contractSql-> getEmailAddress();
    //    echo "test";
//exit;
        $contractSql-> loadBusinessInfo();
        $business_name = $contractSql-> getBusinessName();
        $business_dba = $contractSql-> getBusinessDba();
        
        $contractSql-> setDownPayment($down_payment);
        $contractSql-> setTermType($term_type);
        $contractSql-> setGroupNumber($group_number);
        $contractSql-> setProductListArray($saleArray);
        $contractSql-> setTransfer($transfer);
        $contractSql-> loadProductSummarys();
        
        $summary_rows = $contractSql-> getSummaryTableRows();
        $summary_rows_email = $contractSql-> getSummaryEmailRows();
        
        $contractSql-> setProRateDues($pro_rate_dues);
        $contractSql-> setProcessFeeMonthly($process_fee_eft);
        
        $contractSql-> setInitiationFee($initiation_fee);
        $contractSql-> setProcessFeePif($process_fee_pif);
        $contractSql-> setPifServicesTotal($pre_paid_services);
        $contractSql-> setTodaysPayment($today_payment);
        $contractSql-> setBalanceDue($balance_due);
        $contractSql-> setDueDate($balance_due_date);
        $contractSql-> loadInitialPayments();
        $initial_payments = $contractSql-> getInitialPayments();
        $initial_payments_email = $contractSql-> getInitialEmailRows();
        $contractSql-> loadContractTerms();
        $contract_terms = $contractSql-> getContractTerms();
        $emp_name = $contractSql-> getEmpName();
        $liabilityTerms = $contractSql->  getLiabilityTerms();
        $contractSql-> setMonthlyDues($monthly_payment);
        $contractSql-> setMonthlyBillingType($monthly_billing_type);
        
        
        $contractSql-> checkEnhanceFee();
        $contractSql-> loadMonthlyTransactionRequest();
        $transaction_request = $contractSql-> getTransactionRequest(); 
        
        $contractSql-> loadSignupSection(); 
        $signup_section = $contractSql-> getSignupSection();
        //echo "$signup_section";
        //exit;
        
        
        $javaScript1 ="<script type=\"text/javascript\" src=\"../../scripts/printPage.js\"></script>";
        
        //echo "test$contract_terms";
        //exit;
        //include "../webTemplates/contractTemplate.php";
        $sig = str_replace(' ','+',$sig);
        $contractTemplate = <<<CONTRACTTEMPLATE
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <link rel="stylesheet" href="../../css/contract.css"/>
        
        $javaScript1
        	<title>Untitled</title>
        </head>
        <body>
        <div id="pageWrap">
        <div id="contractHeaders">
        <div id="logoDiv">
        <a onclick="printPage()" href="javascript: void(0)">
            <img width="139" height="54" src="../../images/contract_logo.png"></img>
        </a>
        </div>
        <div id="contractType">
        <span class="typeName">$contract_type_header</span>
        <span class="pipe">|</span>
        <span class="contractNumber">Contract #$contractKey</span>
        </div>
        </div>
        
        <div id="hostHeader">
<span class="subHeader">LIABILITY HOST (Contract Holder)</span>
</div>
<div id="underline"></div>

<div id="memberInfo">
<table>
$group_info
<tr>
<td class="nameTitles">
Host Name:
</td>
<td class="nameSakes">
$first_name $middle_name $last_name
</td>
</tr>
<tr>
<td class="nameTitles">
Address:
</td>
<td class="nameSakes">
$street_address
</td>
</tr>
<tr>
<td class="nameTitles">
Primary Phone:
</td>
<td class="nameSakes">
$primary_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Cell Phone:
</td>
<td class="nameSakes">
$cell_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Email Address:
</td>
<td class="nameSakes">
$email_address
</td>
</tr>
</table>
</div>

<div id="agreeLine">
It is agreed by and between "$business_name" (d.b.a. "$business_dba"), hereinafter,
"$business_name", and Liability Host and/or the Contract Holder named above, as follows:
</div>

<div id="summaryHeader">
<span class="subHeader">SERVICE SUMMARY</span>
</div>
<div id="underline2"></div>

<div id="summaryInfo">
<table cellpadding="0" cellspacing="0">
$summary_rows
</table>
</div>


<div id="initialHeader">
<span class="subHeader">INITIAL PAYMENTS</span>
</div>
<div id="underline3"></div>

<div id="initialPayments">
<table cellpadding="0" cellspacing="0">
$initial_payments
</table>
</div>

<div id="terms">
<p>
$contract_terms

<h4>Liability Terms</h4>
$liabilityTerms
</p>
</div>
$transaction_request

<div id="signUp">
$signup_section
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="signature">
<img width="300" height="160" alt="sigImage" src="$sig" />
</div>

<div id="empsignature">
<span class="signatures">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$emp_name</b></span>
</div>


<div id="signLine1"><span class="signatures">CONTRACTOR HOLDER SIGNATURE</span></div>

<div id="signLine2"><span class="signatures">CLUB REPRESENTATIVE</span></div>
</div>

</div>
</body>
</html>
CONTRACTTEMPLATE;

$imArray = explode(',',$sig);
$data = base64_decode($imArray[1]);
//$im = imagecreatefromstring($data);

$ourFileName = "../../../sigs/$contractKey.png";
$ourFileHandle = fopen($ourFileName, 'c');
//perror($ourFileHandle);

fwrite($ourFileHandle, $data);                
fclose($ourFileHandle);
include '../../dbConnect.php';
include '../../dbConnectOne.php';
$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close();

$namearray = explode('_',$database_name);
$id = $namearray[1];

$stmt = $dbMainOne ->prepare("SELECT dns_name FROM dns_info WHERE bus_id = '$id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($dns_name);   
$stmt->fetch();   
$stmt->close();

$url = "cmp.$dns_name";

$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<link rel=\"stylesheet\" href=\"../../css/contract.css\"/>
$javaScript1
	<title>Untitled</title>
</head>
<body>

<img src=\"https://cmpdevsite.com/admin/images/contract_logo.png \" />

<tr>
<h3>$contract_type_header&nbsp;|&nbsp;Contract #$contractKey</h3>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">LIABILITY HOST (Contract Holder)</font></th>
</tr>

<table>
$group_info
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Host Name:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$first_name $middle_name $last_name</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Address:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$street_address</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Primary Phone:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$primary_phone</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Cell Phone:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$cell_phone</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Email Address:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$email_address</font></th>
</tr>
</table>
<br>
<br>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">It is agreed by and between \"$business_name\" (d.b.a. \"$business_dba\"), hereinafter,
\"$business_name\", and Liability Host and/or the Contract Holder named above, as follows:</font></th>
</tr>
<br>
<br>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">SERVICE SUMMARY</font></th>
</tr>

<table cellpadding=\"0\" cellspacing=\"0\">
$summary_rows_email
</table>


<br>
<br>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">INITIAL PAYMENTS</font></th>
</tr>
<tr>
$initial_payments_email
</tr>

<p>
<b>$contract_terms<br><br><h5>Liability Terms:<br><br>$liabilityTerms</b>
</p>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$transaction_request</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$signup_section</font></th>
</tr>
<br>
<br>
<br>
<br>
<br>
<br>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><img src=\"https://cmpdevsite.com/admin/sigs/$contractKey.png\" alt=\"sigImage\" /></th>
<tr>


<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">CONTRACT HOLDER SIGNATURE_________________________________</font><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLUB REPRESENTATIVE: &nbsp;&nbsp;&nbsp;$emp_name</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"></th>
</tr>

</body>
</html>";

$headers  = "From: $business_name@info.com\r\n";
$headers .= "Content-type: text/html\r\n";   

$signature = "";
$date = date("Y-m-d");
include '../../dbConnect.php';
//echo"$message";
//exit;
$cKeyInsertArray = explode('|',$conKeyArray);
foreach($cKeyInsertArray as $cKeyIns){
    $sql = "UPDATE contract_info SET contract_html= ? WHERE contract_key = '$cKeyIns' AND signup_date = '$signUpDate'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('s',  $contractTemplate);
    if(!$stmt->execute())  {
    	printf("Error: %s.\n function update HTML", $stmt->error);
       }		
    $stmt->close(); 
    
    $sql = "INSERT INTO contract_signatures VALUES (?,?,?,?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('isss', $cKeyIns, $signature,$message,$date);
    
    if(!$stmt->execute())  {
    	printf("Error: %s.signature\n", $stmt->error);
       }		
    $stmt->close();  
}



//set the vars for the contract header

$contractTemplate = trim($contractTemplate);
mail($email_address, "$business_name Contract", $message, $headers);

echo"$contractTemplate";


//$salesSql-> setContractHtml($contractTemplate);
//$_SESSION['salesSql'] = $salesSql;
?>