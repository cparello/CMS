<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
class failDelUpSubscriptions {


function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

function setBool($bool){
    $this->bool = $bool;
}
//===============================================================================================
function failedUpdates(){
    
    $reportDate = date('F',strtotime($this->monthStart));
    
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>Attendence Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Failed Subscription Updates</strong></Center></H1></span>

<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
     <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Line Number</font></th>
      <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
    
  </tr>"; 
   
$dbMain = $this->dbconnect();

$cycDayCounter = 1;
$stmt1 = $dbMain->prepare("SELECT DISTINCT contract_key FROM failed_updates_subscriptions WHERE contract_key!=''");
$stmt1->execute();      
$stmt1->store_result();      
$stmt1->bind_result($contract_key); 
while($stmt1->fetch()){
        echo    "<tr>
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$cycDayCounter</b></font>
            </td>  
            <td align=\"left\" valign =\"top\">
            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
            </td>
            </tr>\n";
    $cycDayCounter++;
}
$stmt1->close(); 

//var_dump($dayArray);




echo  "</table>
</div>
</head>
</html>";
}
//==================================================================================================
function failedSetup(){
   
     $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Failed Subscription Setup</strong></Center></H1></span>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">line Number</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Subscription Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Billing Type</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Billing Amount</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Frequency</font></th>
     </tr>";


    
    $dbMain = $this->dbconnect();
    
 $counter = 1;
    //echo "$start $end $this->monthStart $this->monthEnd";
    
    $stmt999 = $dbMain->prepare("SELECT contract_key, subscription_type, billing_type, billing_amount, reason_code, fequency FROM failed_subscriptions  WHERE contract_key != ''");//>=
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($contract_key, $subscription_type, $billing_type, $billing_amount, $reason_code, $fequency); 
    while($stmt999->fetch()){
            
            
            echo  "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$subscription_type</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$billing_type</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$fequency</b></font>
</td>
</tr>";
$counter++;
}
           
echo  "</table>
</div>
</head>
</html>";             
    
    $stmt999->close();
    
    
}
//=====================================================================================
function failedCancellations(){
  
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Failed Subscription Cancellations</strong></Center></H1></span>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">line Number</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Subscription ID</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Reason Code</font></th>
     </tr>";


    
    $dbMain = $this->dbconnect();
    
 $counter = 1;
    //echo "$start $end $this->monthStart $this->monthEnd";
    
    $stmt999 = $dbMain->prepare("SELECT contract_key, subscription_id, reason_code FROM failed_deletions  WHERE contract_key != ''");//>=
    $stmt999->execute();      
    $stmt999->store_result();      
    $stmt999->bind_result($contractKey, $sub_id, $reason_code); 
    while($stmt999->fetch()){
            
            
            echo  "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contractKey</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$sub_id</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$reason_code</b></font>
</td>
</tr>";
$counter++;
}
           
echo  "</table>
</div>
</head>
</html>";             
    
    $stmt999->close();
    
    
    
}
//=====================================================================================
function neverSetup(){
  
    $reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>



<span class="black6"><Center><H1><strong>Club Manager Pro</strong></Center></H1></span>
<span class="black6"><Center><H1><strong>Subscriptions Never Setup</strong></Center></H1></span>



<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>


REPORTHEADER;

echo"$reportHeader";

echo" <tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">line Number</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">First Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Last Name</font></th>
     </tr>";
 
        
        

    
    $dbMain = $this->dbconnect();
    
    $counter = 1;
    $counter2 = 1;
    $stmt99 = $dbMain->prepare("SELECT DISTINCT contract_key FROM monthly_payments WHERE contract_key != ''");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($contract_key);   
    while($stmt99->fetch()){
        $CScontract_key = null;
        
         $stmt22 = $dbMain->prepare("SELECT service_key, MAX(end_date) FROM monthly_services WHERE contract_key = '$contract_key' AND service_name LIKE '%membership%'");
        $stmt22->execute();      
        $stmt22->store_result();      
        $stmt22->bind_result($service_key, $end_date);   
        $stmt22->fetch();
        $stmt22->close(); 
        
         $stmt22 = $dbMain->prepare("SELECT account_status FROM account_status WHERE contract_key = '$contract_key' AND service_key = '$service_key'");
        $stmt22->execute();      
        $stmt22->store_result();      
        $stmt22->bind_result($account_status);   
        $stmt22->fetch();
        $stmt22->close(); 
        
         $stmt22 = $dbMain->prepare("SELECT DISTINCT contract_key FROM cs_subscriptions WHERE contract_key = '$contract_key' AND subscription_type = 'MS'");
        $stmt22->execute();      
        $stmt22->store_result();      
        $stmt22->bind_result($CScontract_key);   
        $stmt22->fetch();
        $stmt22->close(); 
        
        $CScontract_key = trim($CScontract_key);

        if ($CScontract_key == '0' AND $account_status =='CU'){
            
            $stmt2 = $dbMain->prepare("SELECT DISTINCT first_name, last_name FROM contract_info WHERE contract_key = '$contract_key' AND first_name != ''");
            $stmt2->execute();      
            $stmt2->store_result();      
            $stmt2->bind_result($first_name, $last_name);   
            $stmt2->fetch();
            $stmt2->close(); 
            
            $first_name = trim($first_name);
        
            
            
            echo  "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter2</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
</td>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name</b></font>
</td>  
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$last_name</b></font>
</td>
</tr>";
       
                    $counter2++;
            $first_name = null;
            $last_name = null;
         
           
            }
            $counter++;
           
           
    
     
             
        
      
        
        
    }   
    $stmt99->close(); 
    echo  "</table>
</div>
</head>
</html>";  
    
    
}
//==============================================================================================
function fileMaker(){
    
    if ($this->bool == 'U'){
        $this->failedDeletions();
        }else if($this->bool == 'C'){
            $this->failedCancellations();
        }else if($this->bool == 'S'){
            $this->failedSetup();
        }else if($this->bool == 'N'){
            $this->neverSetup();
        }
}
//===============================================

}
//$upload = new failDelUpSubscriptions();
//$upload->fileMaker();


?>