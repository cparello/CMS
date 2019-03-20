<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class viewPaymentHistory {


private $contractKey = null;
private $paymentAmount = null;
private $balanceDue = null;
private $paymentDueDate = null;
private $paymentDate = null;
private $paymentDescription = null;
private $transKey = null;
private $rowCount = 0;
private $historyKey = null;
private $paymentFlag = null;
private $historyRows = null;
private $paymentContent = null;

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }


//-------------------------------------             
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//-------------------------------------



//==================================================================
function createHistoryContent() {

$paymentHouse ="
<div class=\"hisitoryTable\">
<span class=\"contractNumberHeader\">Contract Number:&nbsp;&nbsp;</span>
<span class=\"contractNumber\">$this->contractKey</span>

<p>
<span class=\"black\">Past Due = </span>&nbsp;<span class=\"payStatus\">&nbsp;&nbsp;&nbsp;</span>
&nbsp;&nbsp;&nbsp;&nbsp;
<span class=\"black\">Rejected = </span>&nbsp;<span class=\"payStatusTwo\">&nbsp;&nbsp;&nbsp;</span>
</p>

<p>
<table id=\"paymentList\" class=\"tablesorter\" align=\"left\" border=\"1\" rules=\"none\" frame=\"box\" cellspacing=\"0\" cellpadding=\"5\" width=\"100%\"> 
<thead>
<tr class=\"tabHead\">
<th class=\"oBtext3 tile3\">   
Billing Type&nbsp;
</th>
<th class=\"oBtext3\">
Billing Amount&nbsp;&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Balance Due&nbsp;&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Days Past Due&nbsp;&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Payment Date&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Date Due&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Trans Key&nbsp;&nbsp;&nbsp;
</th>
<th class=\"oBtext3\">
Refund&nbsp;
</th>
</tr>
</thead>
<tbody>
$this->historyRows
</tbody>
</table>
</p>
</div>";



$this->paymentContent = $paymentHouse;



}
//=================================================================
function parsePaymentRows() {

                    //create color rows
                     static $cell_count = 1;
                      if($cell_count == 2) {
                         $color = "#D8D8D8";
                         $color2 = "D8D8D8";
                         $cell_count = "";
                         }else{
                         $color = "#FFFFFF";
                         $color2 = "FFFFFF";
                         }
                         $cell_count = $cell_count + 1;


   $dueDateSecs =  strtotime($this->paymentDueDate);
   $payDateSecs =  strtotime($this->paymentDate);

//check for past due and get the number of days past due
if($this->paymentFlag == 'BD' || $this->paymentFlag == 'RE')  {
   $todayDateSecs = time();
   
   if($dueDateSecs < $todayDateSecs) {
      $dateDifSecs = abs($todayDateSecs - $dueDateSecs);
      $daysPastDue = floor($dateDifSecs / (60*60*24));
     }else{
      $daysPastDue = 0;
     }
   
   }else{
   $daysPastDue = 0;   
   }
   
//now we change the color css of the text depending on the status   
if($this->paymentFlag == 'PF')  {
   $textCss = 'black';
   }
if($this->paymentFlag == 'BD')  {
   $textCss = 'black';
   }   
if($this->paymentFlag == 'RE')  {
   $textCss = 'orange';
   }      
   
//if past due then we change the text color
if($this->paymentFlag != 'RE' &&  $this->paymentFlag != 'PF') {
     if($daysPastDue > 0) {
       $textCss = 'yellow';
       }
   }
   
   
   
   $paymentDate = date("F j, Y", $payDateSecs); 
   $paymentDueDate = date("F j, Y", $dueDateSecs);
      

$this->historyRows .= "<tr id=\"a$this->rowCount\" >
             <td class=\"$textCss\">
              $this->paymentDescription
             </td>
             <td class=\"$textCss\">
              $this->paymentAmount
             </td>
             <td class=\"$textCss\">
              $this->balanceDue
             </td>             
             <td class=\"$textCss\">
              $daysPastDue
             </td>
             <td class=\"$textCss\">
              $paymentDate
             </td>
             <td class=\"$textCss\">
             $paymentDueDate
             </td> 
             <td class=\"$textCss\">
             $this->transKey
             </td>
             <td class=\"$textCss\">
             $this->voidButton
             </td>
             </tr>";

}
//==================================================================
function loadPaymentHistory()  {

   $dbMain = $this->dbconnect();
   $stmt999 = $dbMain ->prepare("SELECT payment_amount, balance_due, payment_due_date, payment_date, payment_flag, payment_description, trans_key, cc_request_id, ach_request_id, credit_payment, ach_payment FROM payment_history WHERE contract_key = '$this->contractKey' ORDER BY payment_due_date DESC");
   $stmt999->execute();      
   $stmt999->store_result();      
   $stmt999->bind_result($payment_amount, $balance_due, $payment_due_date, $payment_date, $payment_flag, $payment_description, $trans_key, $cc_request_id, $ach_request_id,  $credit_payment, $ach_payment);
   
   
while($stmt999->fetch()) { 
            $stmt = $dbMain ->prepare("SELECT COUNT(*) AS count FROM refunded_pay_history WHERE contract_key = '$this->contractKey' AND (orig_request_id = '$cc_request_id' OR orig_request_id = '$ach_request_id')");
               $stmt->execute();      
               $stmt->store_result();      
               $stmt->bind_result($count);
               $stmt->fetch();
               $stmt->close();  
               
               if ($count == 0){
                    if ($payment_flag != 'RE'){
                        if ($credit_payment != 0.00 AND ($cc_request_id != 0 AND $cc_request_id != "")){
                            $this->voidButton = "<input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Refund\" onClick=\"return setContractRecord('$this->contractKey','$cc_request_id','CR','$payment_amount','$payment_date','$payment_description');\"/>";
                         }else if ($ach_payment != 0.00 AND ($ach_request_id != 0 AND $ach_request_id != "")){
                            $this->voidButton = "<input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Refund\" onClick=\"return setContractRecord('$this->contractKey','$ach_request_id','BA','$payment_amount','$payment_date','$payment_description');\"/>";
                         }else{
                            $this->voidButton = "<input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Not Available\" onClick=\"return setContractRecord('$this->contractKey','$ach_request_id','BA','$payment_amount','$payment_date','$payment_description');\"/ disabled>";
                            }
                    }else{
                         $this->voidButton = "<input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Not Available\" onClick=\"return setContractRecord('$this->contractKey','$ach_request_id','BA','$payment_amount','$payment_date','$payment_description');\"/ disabled>";
                    }
                        
               }else{
                $this->voidButton = "<input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Processed\" onClick=\"return setContractRecord('$this->contractKey','$ach_request_id','BA','$payment_amount','$payment_date','$payment_description');\"/ disabled>";
               }       
    
         
         $this->paymentAmount = $payment_amount;
         $this->balanceDue = $balance_due;
         $this->paymentDueDate = $payment_due_date;
         $this->paymentDate = $payment_date;
         $this->paymentFlag = $payment_flag;
         $this->paymentDescription = $payment_description;
         $this->transKey = $trans_key;
         $this->rowCount++;
         $this->parsePaymentRows();
        }

$stmt999->close();             

$this->createHistoryContent();
}

//==================================================================

function getPaymentContent() {
          return($this->paymentContent);
          }

}
//--------------------------------------------------------------------------------------------------------------------------
$contract_key = $_SESSION['contract_key'];

$load_history = new viewPaymentHistory();
$load_history-> setContractKey($contract_key);
$load_history-> loadPaymentHistory();
$payment_content = $load_history-> getPaymentContent();

/*
$accountInfoTemplate = <<<ACCOUNTINFOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/accountInfo.css"/>
<title>Untitled</title>
</head>
<body>


$payment_content

</body>
</html>
ACCOUNTINFOTEMPLATE;
*/

echo"$payment_content";


?>