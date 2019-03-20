<?php

class billingList{
    
function setMonth($month){
    $this->month = $month;
}
function setDay($day){
    $this->day = $day;
}
function setYear($year){
    $this->year = $year;
}
function setFeeType($feeType){
    $this->feeType = $feeType;
}
function  setPassFail($passFail){
    $this->passFail = $passFail;
}

//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}

//------------------------------------------------------------------------------------------
function loadBillingList() {
    
    
    
switch($this->feeType){
    case 'EF':
        $feeName = "Enhance Fee";
    break;
    case 'MS':
        $feeName = "Monthly Service Fee";
    break;
    case 'RF':
        $feeName = "Rate Guarentee Fee";
    break;
    case 'MF':
        $feeName = "Maintenance Fee";
    break;
}
    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<style>
	#bg { position: fixed; top: 0; left: 0; }
		.bgwidth { width: 100%; }
		.bgheight { height: 100%; }

		#page-wrap { 
		  position: relative;
          width: 80%;
          margin: 50px auto;
          padding: 60px;
          background: white;
          }
</style>
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script>
		$(function() {

			var theWindow        = $(window),
			    bg              = $(\"#bg\"),
			    aspectRatio      = bg.width() / bg.height();

			function resizeBg() {

				if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
				    bg
				    	.removeClass()
				    	.addClass('bgheight');
				} else {
				    bg
				    	.removeClass()
				    	.addClass('bgwidth');
				}

			}

			theWindow.resize(function() {
				resizeBg();
			}).trigger(\"resize\");

		});
</script>
<title>Billing Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>$feeName Billing List preview</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>


<div id="page-wrap">
<table align="center" border="0" cellspacing="5" cellpadding="0" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
  <td>#</td>
  <td>Contract Key</td>
  <td>Member Name</td>
  <td>Phone</td>
  <td>Cell Phone</td>
  <td>Email</td>
  <td>Amount</td>
  <td>Trans Type</td>
  </tr>\n"; 

//echo "$this->feeType $this->month $this->year $this->day";
$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, billing_amount, transaction_type FROM billing_scheduled_preview WHERE payment_type = '$this->feeType' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND cycle_start_day = '$this->day'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $billing_amount, $transaction_type);   
while($stmt->fetch()){
    
      
    $stmt99 = $dbMain->prepare("SELECT primary_phone, cell_phone, email, first_name, last_name FROM contract_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($primary_phone, $cell_phone, $email, $first_name, $last_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    $first_name = trim($first_name);
    
    if ($first_name != ""){ 
        
        $total += $billing_amount;
        //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
        //$last4 = substr($credit_card_num,12,4);  
        //$credit_card_num = "****-****-****-$last4";
        
        echo    "<tr>
            <td class=\"item counter\">
            $counter
            </td>
            <td class=\"item\">
            $contract_key
            </td>
            <td class=\"item\">
            $first_name&nbsp; $last_name
            </td> 
            <td class=\"item\">
            $primary_phone
            </td>
            <td class=\"item\">
            $cell_phone
            </td>
            <td class=\"item\">
            $email
            </td>
            <td class=\"item\">
            $$billing_amount
            </td>  
            <td class=\"item\">
            $transaction_type
            </td>
            </tr>\n";
    }

    
 
$counter++;
$primary_phone = "";
$cell_phone = "";
$email = "";
$contract_key = "";
$reason_code = "";
$reason_descrip = "";
$exact_response = "";
$exact_code = "";
$amount_owed = "";
$payment_type = "";
$card_fname = "";
$card_lname = "";
$credit_card_num = "";
$card_exp = "";
$first_name = ""; 
$last_name = "";
}
$total = sprintf("%01.2f", $total);

echo "<tr>
  <td>Total: $$total</td>
  </tr>
  <tr>
  <td>Number: $counter</td>
  </tr>";


echo  "</table>

</div>
</head>
</html>";

}
//====================================================================
//------------------------------------------------------------------------------------------
function loadBillingListLive() {
    
    
    
switch($this->feeType){
    case 'EF':
        $feeName = "Enhance Fee";
    break;
    case 'MS':
        $feeName = "Monthly Service Fee";
    break;
    case 'RF':
        $feeName = "Rate Guarentee Fee";
    break;
    case 'MF':
        $feeName = "Maintenance Fee";
    break;
}

switch($this->passFail){
    case '1':
        $pass = " AND response = '100'";
    break;
    case '0':
        $pass = " AND response != '100'";
    break;
    
}

    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<style>
	#bg { position: fixed; top: 0; left: 0; }
		.bgwidth { width: 100%; }
		.bgheight { height: 100%; }

		#page-wrap { 
		  position: relative;
          width: 80%;
          margin: 50px auto;
          padding: 60px;
          background: white;
          }
</style>
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script>
		$(function() {

			var theWindow        = $(window),
			    bg              = $(\"#bg\"),
			    aspectRatio      = bg.width() / bg.height();

			function resizeBg() {

				if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
				    bg
				    	.removeClass()
				    	.addClass('bgheight');
				} else {
				    bg
				    	.removeClass()
				    	.addClass('bgwidth');
				}

			}

			theWindow.resize(function() {
				resizeBg();
			}).trigger(\"resize\");

		});
</script>
<title>Billing Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>$feeName Billing List preview</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>


<div id="page-wrap">
<table align="center" border="0" cellspacing="5" cellpadding="0" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo "<tr>
      <td class=\"listItem\">#</td>
      <td class=\"listItem\">Contract Key</td>
      <td class=\"listItem\">Member Name</td>
      <td class=\"listItem\">Phone</td>
      <td class=\"listItem\">Cell Phone</td>
      <td class=\"listItem\">Email</td>
      <td class=\"listItem\">Amount</td>
      <td class=\"listItem\">Trans Type</td>
      <td class=\"listItem\">Reason</td>
      </tr>\n"; 

echo "$this->feeType' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND cycle_start_day = '$this->day' $pass";
$counter = 1;
$total = 0;
$stmt = $dbMain->prepare("SELECT contract_key, billing_amount, transaction_type, response_message FROM billing_scheduled_recuring_payments WHERE payment_type = '$this->feeType' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND cycle_start_day = '$this->day' $pass");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_key, $billing_amount, $transaction_type, $response_message);   
while($stmt->fetch()){
    
      
    $stmt99 = $dbMain->prepare("SELECT primary_phone, cell_phone, email, first_name, last_name FROM contract_info WHERE contract_key = '$contract_key'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($primary_phone, $cell_phone, $email, $first_name, $last_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    $first_name = trim($first_name);
    
    if ($first_name != ""){ 
        
        $total += $billing_amount;
        //echo "$contract_key  <>   $credit_card_num   <>     $card_exp   <>    $card_name   <>   $amount_owed    <>    $card_type   <>   $reason_code   <>     $reason_descrip  <>   $fail_date   <>   $trans_title <> $phone<br><br>";
        //$last4 = substr($credit_card_num,12,4);  
        //$credit_card_num = "****-****-****-$last4";
        
        echo    "<tr>
            <td class=\"item counter\">
            $counter
            </td>
            <td class=\"item\">
            $contract_key
            </td>
            <td class=\"item\">
            $first_name&nbsp; $last_name
            </td> 
            <td class=\"item\">
            $primary_phone
            </td>
            <td class=\"item\">
            $cell_phone
            </td>
            <td class=\"item\">
            $email
            </td>
            <td class=\"item\">
            $$billing_amount
            </td>  
            <td class=\"item\">
            $transaction_type
            </td>
            <td class=\"item\">
            $response_message
            </td>
            </tr>\n";
    }

    
 
$counter++;
$primary_phone = "";
$cell_phone = "";
$email = "";
$contract_key = "";
$reason_code = "";
$reason_descrip = "";
$exact_response = "";
$exact_code = "";
$amount_owed = "";
$payment_type = "";
$card_fname = "";
$card_lname = "";
$credit_card_num = "";
$card_exp = "";
$first_name = ""; 
$last_name = "";
}
$total = sprintf("%01.2f", $total);

echo "<tr>
  <td>Total: $$total</td>
  </tr>
  <tr>
  <td>Number: $counter</td>
  </tr>";


echo  "</table>

</div>
</head>
</html>";

}
//====================================================================
//------------------------------------------------------------------------------------------
function loadBillingPreSumm() {
    
    
    
switch($this->feeType){
    case 'EF':
        $feeName = "Enhance Fee";
    break;
    case 'MS':
        $feeName = "Monthly Service Fee";
    break;
    case 'RF':
        $feeName = "Rate Guarantee Fee";
    break;
    case 'MF':
        $feeName = "Maintenance Fee";
    break;
}



    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<style>
	#bg { position: fixed; top: 0; left: 0; }
		.bgwidth { width: 100%; }
		.bgheight { height: 100%; }

		#page-wrap { 
		  position: relative;
          width: 80%;
          margin: 50px auto;
          padding: 60px;
          background: white;
          }
   
</style>
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script>
		$(function() {

			var theWindow        = $(window),
			    bg              = $(\"#bg\"),
			    aspectRatio      = bg.width() / bg.height();

			function resizeBg() {

				if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
				    bg
				    	.removeClass()
				    	.addClass('bgheight');
				} else {
				    bg
				    	.removeClass()
				    	.addClass('bgwidth');
				}

			}

			theWindow.resize(function() {
				resizeBg();
			}).trigger(\"resize\");

		});
</script>
<title>Billing Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>$feeName <br> Billing Summary Preview</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>


<div id="page-wrap">
<table align="center" border="0" cellspacing="5" cellpadding="0" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
    <td class=\"listItem\">
  #
  </td>
  <td class=\"listItem\">
  Fee Type
  </td>
  <td class=\"listItem\">
  Club Name
  </td>
  <td class=\"listItem\">
  Date
  </td>
  <td class=\"listItem\">
  Number of Records
  </td>
  <td class=\"listItem\">
  Projected $
  </td>
  <td class=\"listItem\">
  Projected CC $
  </td>
  <td class=\"listItem\">
  Projected ACH $
  </td>
  </tr>\n"; 

//echo "'$this->feeType' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND cycle_start_day = '$this->day'";
$counter = 1;
$total = 0;
$recTot = 0;
$stmt = $dbMain->prepare("SELECT projected, credit_total_projected, ach_total_projected, number_records, club_id FROM billing_monthly_batch_previews WHERE batch_type = '$this->feeType' AND month = '$this->month' AND year = '$this->year' AND day = '$this->day'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($projected, $credit_total_projected, $ach_total_projected, $number_records, $club_id);   
while($stmt->fetch()){
    
    $stmt99 = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($club_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    $total += $projected;
    $recTot += $number_records;
        
        echo    "<tr>
        <td class=\"item counter\">
            $counter
            </td>
            <td class=\"item\">
            $feeName
            </td>
            <td class=\"item\">
            $club_name
            </td>
            <td class=\"item\">
            $this->month-$this->day-$this->year
            </td> 
            <td class=\"item\">
            $number_records
            </td>
            <td class=\"item\">
            $$projected
            </td>
            <td class=\"item\">
            $$credit_total_projected
            </td>
            <td class=\"item\">
            $$ach_total_projected
            </td>  
            </tr>\n";
    

    
 
$counter++;

}
echo "<tr>
  <td>Total: $$total</td>
  </tr>
  <tr>
   <td>Number: $recTot</td>
  </tr>";


echo  "</table>

</div>
</head>
</html>";

}
//====================================================================
//------------------------------------------------------------------------------------------
function loadBillingLiveSum() {
    
    
    
switch($this->feeType){
    case 'EF':
        $feeName = "Enhance Fee";
    break;
    case 'MS':
        $feeName = "Monthly Service Fee";
    break;
    case 'RF':
        $feeName = "Rate Guarantee Fee";
    break;
    case 'MF':
        $feeName = "Maintenance Fee";
    break;
}



    
$reportDate = date('F',strtotime("$this->month/1/2014"));

$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<style>
	#bg { position: fixed; top: 0; left: 0; }
		.bgwidth { width: 100%; }
		.bgheight { height: 100%; }

		#page-wrap { 
		  position: relative;
          width: 80%;
          margin: 50px auto;
          padding: 60px;
          background: white;
          }
   
</style>
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script>
		$(function() {

			var theWindow        = $(window),
			    bg              = $(\"#bg\"),
			    aspectRatio      = bg.width() / bg.height();

			function resizeBg() {

				if ( (theWindow.width() / theWindow.height()) < aspectRatio ) {
				    bg
				    	.removeClass()
				    	.addClass('bgheight');
				} else {
				    bg
				    	.removeClass()
				    	.addClass('bgwidth');
				}

			}

			theWindow.resize(function() {
				resizeBg();
			}).trigger(\"resize\");

		});
</script>
<title>Billing Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<Center><H1><strong>Club Manager Pro</strong></Center></H1></Center>
<Center><H1><strong>$feeName <br> Billing Summary</strong></H1></Center>
<Center><H1><strong>Month: $reportDate</strong></H1></Center>


<div id="page-wrap">
<table align="center" border="0" cellspacing="5" cellpadding="0" width=100%>


REPORTHEADER;

echo"$reportHeader";

 $dbMain = $this->dbconnect();
    
 

echo" <tr>
    <td class=\"listItem\">
  #
  </td>
  <td class=\"listItem\">
  Fee Type
  </td>
  <td class=\"listItem\">
  Club Name
  </td>
  <td class=\"listItem\">
  Date
  </td>
  <td class=\"listItem\">
  Number of Records
  </td>
  <td class=\"listItem\">
  Number Successful
  </td>
  <td class=\"listItem\">
  Number Failed
  </td>
  <td class=\"listItem\">
  Percentage
  </td>
   <td class=\"listItem\">
  Amount Collected
  </td>
  <td class=\"listItem\">
  Amount Collected CC
  </td>
  <td class=\"listItem\">
  Amount Collected ACH
  </td>
  <td class=\"listItem\">
  Failed Amount
  </td>
   <td class=\"listItem\">
  Failed Amount CC
  </td>
  <td class=\"listItem\">
  Failed Amount ACH
  </td>
  </tr>\n"; 

//echo "'$this->feeType' AND cycle_start_month = '$this->month' AND cycle_start_year = '$this->year' AND cycle_start_day = '$this->day'";

$counter = 1;
$total = 0;
$recTot = 0;
$stmt = $dbMain->prepare("SELECT collected, collected_cc, collected_ach, failed_amount,failed_amount_cc, failed_amount_ach, percentage_collected, number_attempted, number_success, number_failed, club_id FROM billing_monthly_batch_totals WHERE batch_type = '$this->feeType' AND month = '$this->month' AND year = '$this->year' AND day = '$this->day'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($collected, $collected_cc, $collected_ach, $failed_amount, $failed_amount_cc, $failed_amount_ach, $percentage_collected, $number_attempted, $number_success, $number_failed, $club_id);   
while($stmt->fetch()){
    $total += $collected;
    $recTot += $number_success;
    
    $stmt99 = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($club_name);   
    $stmt99->fetch();
    $stmt99->close();
    
    
        
        echo    "<tr>
        <td class=\"item counter\">
            $counter
            </td>
            <td class=\"item\">
            $feeName
            </td>
            <td class=\"item\">
            $club_name
            </td>
            <td class=\"item\">
            $this->month-$this->day-$this->year
            </td> 
            <td class=\"item\">
            $number_attempted
            </td>
            <td class=\"item\">
            $number_success
            </td>
            <td class=\"item\">
            $number_failed
            </td>
            <td class=\"item\">
            $percentage_collected
            </td>  
            <td class=\"item\">
            $collected
            </td>
            <td class=\"item\">
            $collected_cc
            </td>
            <td class=\"item\">
            $collected_ach
            </td>  
            <td class=\"item\">
            $failed_amount
            </td>
            <td class=\"item\">
            $failed_amount_cc
            </td>
            <td class=\"item\">
            $failed_amount_ach
            </td>  
            </tr>\n";
    

    
 
$counter++;

}
echo "<tr>
  <td>Total: $$total</td>
  </tr>
  <tr>
  <td>Number: $recTot</td>
  </tr>";


echo  "</table>

</div>
</head>
</html>";

}
//==========================================================
}
$year = $_REQUEST['year'];
$month = $_REQUEST['month'];
$day = $_REQUEST['day'];
$feeType = $_REQUEST['fee'];
$ajax = $_REQUEST['ajaxSwitch'];
$passFail = $_REQUEST['passFail'];

if($ajax == 1){
    $report = new billingList();
    $report->setYear($year);
    $report->setMonth($month);
    $report->setDay($day);
    $report->setFeeType($feeType);
    $report->loadBillingList();
}
if($ajax == 2){
    $report = new billingList();
    $report->setYear($year);
    $report->setMonth($month);
    $report->setDay($day);
    $report->setFeeType($feeType);
    $report->setPassFail($passFail);
    $report->loadBillingListLive();
}
if($ajax == 3){
    $report = new billingList();
    $report->setYear($year);
    $report->setMonth($month);
    $report->setDay($day);
    $report->setFeeType($feeType);
    $report->loadBillingPreSumm();
}
if($ajax == 4){
    $report = new billingList();
    $report->setYear($year);
    $report->setMonth($month);
    $report->setDay($day);
    $report->setFeeType($feeType);
    $report->loadBillingLiveSum();
}
?>