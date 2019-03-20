<?php
session_start();
//error_reporting(E_ALL);
class emailDSRReports {

private $contractKey = null;
private $barCode = null;
private $firstName = null;
private $midName = null;
private $lastName = null;
private $phone = null;
private $email = null;
private $street = null;
private $color = null;
   
          
          
//connect to database
function dbConnect()   {
require"/var/www/vhosts/ems/cmp.burbankathleticclub.com/admin/dbConnect.php";
return $dbMain;
}


//==============================================================================================
function moveData(){
  
$dbMain = $this->dbconnect();
  // echo "fubar";
$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close(); 
   
$idArray = explode('_',$database_name);
 
$stmt22 = $dbMain->prepare("SELECT contact_email FROM business_info WHERE bus_id = '$idArray[1]'");
$stmt22->execute();
$stmt22->store_result();
$stmt22->bind_result($contact_email);
$stmt22->fetch();
$stmt22->close();
    
  $message = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />";

/*

<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>" . strip_tags($_POST['req-name']) . "</td></tr>";
$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($_POST['req-email']) . "</td></tr>";
$message .= "<tr><td><strong>Type of Change:</strong> </td><td>" . strip_tags($_POST['typeOfChange']) . "</td></tr>";
$message .= "<tr><td><strong>Urgency:</strong> </td><td>" . strip_tags($_POST['urgency']) . "</td></tr>";
$message .= "<tr><td><strong>URL To Change (main):</strong> </td><td>" . $_POST['URL-main'] . "</td></tr>";
$addURLS = $_POST['addURLS'];
if (($addURLS) != '') {
    $message .= "<tr><td><strong>URL To Change (additional):</strong> </td><td>" . strip_tags($addURLS) . "</td></tr>";
}
$curText = htmlentities($_POST['curText']);           
if (($curText) != '') {
    $message .= "<tr><td><strong>CURRENT Content:</strong> </td><td>" . $curText . "</td></tr>";
}
$message .= "<tr><td><strong>NEW Content:</strong> </td><td>" . htmlentities($_POST['newText']) . "</td></tr>";
$message .= "</table>"

*/
$message = "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro  -  Daily Sales Report</strong></Center></H1></p><br>";

  
  $stmt99 = $dbMain->prepare("SELECT club_name, club_contact, club_id FROM club_info WHERE club_id != ''");
  $stmt99->execute();
  $stmt99->store_result();
  $stmt99->bind_result($club_name, $club_contact, $club_id);
  while($stmt99->fetch()){
    
      $total = 0;
      $cc = 0;
      $ca = 0;
      $ch = 0;
      $ach = 0;
      $count = 0;
      $newCount = 0;
      $renewCount = 0;
    $counter = 1;
    $eft = 0;
    //echo"$club_name";
    
  //$message = 
  $mStart = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
  $mEnd = date('Y-m-d H:i:s', mktime(23,59,59,date('m'),date('t'),date('Y')));
    $stmt = $dbMain->prepare("SELECT SUM(unit_price) FROM sales_info WHERE (sale_date_time BETWEEN '$mStart' AND '$mEnd') AND (contract_location LIKE '%$club_name%') AND location_id != '0'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($currentTot);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain->prepare("SELECT quota FROM sales_quotas WHERE club_id = '$club_id'");
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($quota);
    $stmt->fetch();
    $stmt->close();
    
    $salesLeft = sprintf("%01.2f", $quota - $currentTot);
    
    $now = time();
    $mEndSecs = strtotime($mEnd);
    $diff = $mEndSecs - $now;
    $daysLeft = round($diff/86400);
    $dailyGoal = sprintf("%01.2f", $salesLeft/$daysLeft);
    $dailyGoal = $dailyGoal;
  
  
  $dayStart = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-1,date('Y')));
  $dayEnd = date('Y-m-d H:i:s', mktime(23,59,59,date('m'),date('d')-1,date('Y')));
  
  $date = date('F d Y',strtotime($dayStart));
  
  $message .= "<p class=\"bbackheader\"><Center><H1><strong>Club:</strong> " . $club_name . "  </Center></H1></p>";
  
  $message .= "<tr><td><Center><strong>Date:</strong>    " . $date . " </Center></td></tr>";
  $message .= "<tr><td><Center><strong>Manager:</strong> " . $club_contact . " </Center></td></tr><br><br>";
  
  $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Quota: $quota</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Total: $currentTot</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sales Left: $salesLeft</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Daily Goal: $dailyGoal</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Days Left: $daysLeft</font></th>
  </tr>\n"; 
  
  
  $message .= "<p class=\"bbackheader\"><Center><H3><strong>Services Sold:</strong></Center></H3></p>";
  $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Employee Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  </tr>\n"; 
  
    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale FROM sales_info WHERE (sale_date_time BETWEEN '$dayStart' AND '$dayEnd') AND (contract_location LIKE '%$club_name%') AND location_id != '0'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale);
    while($stmt3->fetch()){
        $stmt = $dbMain->prepare("SELECT emp_fname, emp_lname FROM employee_info WHERE user_id = '$user_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($emp_fname, $emp_lname);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name, email FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname, $email);
        $stmt->fetch();
        $stmt->close();
        
         $msgText = "";
        if ($new_sale == 'Y'){
            $newCount++;
            $msgText = "becoming a member of";
        }else{
            $renewCount++;
            $msgText = "renewing your membership with";
        }
        
        if ($club_id == 3552){
            //echo "test $email $mem_fname $mem_lname";
           mail("$email", "Complimentary Personal Training",

                "Hello, $mem_fname $mem_lname 
                
                We are offering you a complimentary Personal Training session to say thank you for $msgText Burbank Athletic Club. Please call (818) 563-4203 to schedule an appointment or you can email info2@burbankathleticclub.com.
                
                
                Thank you,
                Burbank Athletic Club
                Personal Training Department
                
                (c)BAC.",
                "From: BAC PT Department<info2@burbankathleticclub.com>","-finfo2@burbankathleticclub.com");  
                
        }
        
        $stmt = $dbMain->prepare("SELECT credit_payment, cash_payment, ach_payment, check_payment  FROM payment_history WHERE contract_key = '$contract_key' AND (payment_date BETWEEN '$dayStart' AND '$dayEnd') AND (payment_description LIKE '%New Service%' OR payment_description LIKE '%Service Renewal%'  OR payment_description LIKE '%Service Upgrade%')");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($credit_payment, $cash_payment, $ach_payment, $check_payment);
        $stmt->fetch();
        $stmt->close();
        
        $transType = '';
        
        
        
        if ($credit_payment != '0.00'){
            $cc += $credit_payment;
            $transType = 'CC';
            $payment = $credit_payment;
        }elseif ($cash_payment != '0.00'){
            $ca += $cash_payment;
            $transType = 'CA';
            $payment = $cash_payment;
        }elseif ($ach_payment != '0.00'){
            $ach += $ach_payment;
            $transType = 'ACH';
            $payment = $ach_payment;
        }elseif ($check_payment != '0.00'){
            $ch += $check_payment;
            $transType = 'CH';
            $payment = $check_payment;
        }
        
        if (preg_match('/Monthly/i',$service_name)){
            $eft += $payment;
        }
        
        $total += $unit_price;
        //$message .= "<tr><td><Center> <strong>Type:</strong> " . $transType . " <strong> Service: </strong> " . $service_name . " <strong> Cost:  </strong> " . $unit_price . " <strong>  Salesperson: </strong> " . $emp_fname ." " . $emp_lname . "</Center></td></tr>";
        $message .=    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$transType</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$payment</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$emp_fname  $emp_lname</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$mem_fname $mem_lname</b></font>
                </td>
                </tr>\n";
                        
        $count++;
        $counter++;

       
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    $total2 = sprintf("%01.2f", $cc+$ca+$ach+$ch);
    $cc = sprintf("%01.2f", $cc);
    $ca = sprintf("%01.2f", $ca);
    $ach = sprintf("%01.2f", $ach);
    $ch = sprintf("%01.2f", $ch);
    
    $message .= "<br><p class=\"bbackheader\"><Center><H3><strong>Totals:</strong></Center></H3></p>";
    $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Credit Cards</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Checks</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New EFT</font></th>
  </tr>\n"; 
    
    $message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total2</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cc</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ca</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ach</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ch</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newCount</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewCount</b></font>
</td>
<td align=\"right\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$eft</b></font>
</td>
</tr>\n";
    
   /* $message .= "<tr><td> <Center><strong>Total Sales Before Price Overide:</strong> $" .  $total ."</Center></td></tr>";
    $message .= "<tr><td> <Center><strong> (Actual):</strong> $" .   ."</Center></td></tr>";
    $message .= "<tr><td><Center><strong></strong> $" .. "</Center></td></tr>";
    $message .= "<tr><td><Center><strong></strong> $" .  . "</Center></td></tr>";
    $message .= "<tr><td><Center><strong>ACH: $" .  . "</Center></td></tr>";
    $message .= "<tr><td><Center><strong>Checks:</strong> $" . . "</Center></td></tr>";
    $message .= "<tr><td><Center><strong>Number of Sales:</strong> " .  . "</Center></td></tr>";
    $message .= "<tr><td><Center><strong>New:</strong>  " .  . "</Center></td></tr>";
    $message .= "<tr><td><Center><strong>Renewals:</strong> " .  . "</Center></td></tr><br><br>";*/
    
    $message .= "<tr><td> <Center><strong><br><br><br><br><br><br><br><br><br><br><br><br></strong></Center></td></tr>";
    
        }
  $stmt99->close();
  

  
   $total = 0;
      $cc = 0;
      $ca = 0;
      $ch = 0;
      $ach = 0;
      $count = 0;
      $newCount = 0;
      $renewCount = 0;
      $eftWeb = 0;
  
  $message .= "<p class=\"bbackheader\"><Center><H1><strong>Website:</strong></Center></H1></p>";
  
  $message .= "<tr><td><Center><strong>Date:</strong>    " . $date . " </Center></td></tr>";

  $message .= "<p class=\"bbackheader\"><Center><H3><strong>Services Sold:</strong></Center></H3></p>";
  
  $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Transaction Type</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Contract Key</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  </tr>\n"; 
  
  $counter = 1;
    $stmt3 = $dbMain->prepare("SELECT contract_key, service_name, unit_price, user_id, new_sale FROM sales_info WHERE (sale_date_time BETWEEN '$dayStart' AND '$dayEnd') AND location_id = '0'");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($contract_key, $service_name, $unit_price, $user_id, $new_sale);
    while($stmt3->fetch()){
        
        $stmt = $dbMain->prepare("SELECT first_name, last_name FROM member_info WHERE contract_key = '$contract_key'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($mem_fname, $mem_lname);
        $stmt->fetch();
        $stmt->close();
        
        $stmt = $dbMain->prepare("SELECT check_payment, credit_payment FROM payment_history WHERE contract_key = '$contract_key' AND (payment_date BETWEEN '$dayStart' AND '$dayEnd')");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($check_payment, $credit_payment);
        $stmt->fetch();
        $stmt->close();
        
        if($credit_payment != 0){
            $transType = 'CC';
        }else{
            $transType = 'Bank';
        }
        
        
        if ($new_sale == 'Y'){
            $newCount++;
        }else{
            $renewCount++;
        }
        
        if (preg_match('/Monthly/i',$service_name)){
            $unit_price = round($unit_price/12,2);
            $eftWeb += $unit_price;
        }
        
        $total += $unit_price;
        //$message .= " <tr><td><Center> <strong>Type:</strong> " . $transType . " <strong> Service: </strong> " . $service_name . " <strong> Cost:  </strong> " . $unit_price . " <strong> </Center></td></tr>";
        $message .=    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$transType</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_name</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$unit_price</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$mem_fname $mem_lname</b></font>
                </td>
                </tr>\n";
        $count++;
        $counter++;
        $credit_payment = "";
        $mem_fname = "";
        $mem_lname = "";
        $contract_key = "";
        $service_name = "";
        $unit_price = "";
        $user_id = "";
        $new_sale = "";
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    
    $message .= "<br><p class=\"bbackheader\"><Center><H3><strong>Totals:</strong></Center></H3></p>";
    $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewal Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New EFT</font></th>
  </tr>\n"; 
    
    $message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$total</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$eftWeb</b></font>
</td>
</tr>\n";


$message .= "<tr><td> <Center><strong><br><br><br><br><br><br><br><br><br><br><br><br></strong></Center></td></tr>";

   $total = 0;
   $count = 0; 
  
  $message .= "<p class=\"bbackheader\"><Center><H1><strong>POS:</strong></Center></H1></p>";
  
  $message .= "<tr><td><Center><strong>Date:</strong>    " . $date . " </Center></td></tr>";

  $message .= "<p class=\"bbackheader\"><Center><H3><strong>Items Sold:</strong></Center></H3></p>";
  
  $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Product Description</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Sale Price</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Club Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Name</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Contract Key</font></th>
  </tr>\n"; 
  
  $counter = 1;
    $stmt3 = $dbMain->prepare("SELECT product_desc, total_cost, club_id, contract_key FROM merchant_sales WHERE (purchase_date BETWEEN '$dayStart' AND '$dayEnd')");
    $stmt3->execute();
    $stmt3->store_result();
    $stmt3->bind_result($product_desc, $total_cost, $club_id, $contract_key);
    while($stmt3->fetch()){
          $stmt99 = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
          $stmt99->execute();
          $stmt99->store_result();
          $stmt99->bind_result($club_name);
          $stmt99->fetch();
          $stmt99->fetch();
          
          $stmt99 = $dbMain->prepare("SELECT first_name, last_name  FROM member_info WHERE contract_key = '$contract_key'");
          $stmt99->execute();
          $stmt99->store_result();
          $stmt99->bind_result($first_name, $last_name);
          $stmt99->fetch();
          $stmt99->fetch();
          
        $total += $total_cost;
        //$message .= " <tr><td><Center> <strong>Type:</strong> " . $transType . " <strong> Service: </strong> " . $service_name . " <strong> Cost:  </strong> " . $unit_price . " <strong> </Center></td></tr>";
        $message .=    "<tr>
                <td align=\"left\" valign =\"top\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$product_desc</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$total_cost</b></font>
                </td>  
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name&nbsp;$last_name</b></font>
                </td>
                <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                <font face=\"Arial\" size=\"1\" color=\"black\"><b>$contract_key</b></font>
                </td>
                </tr>\n";
        $count++;
        $counter++;
        
        $product_desc = "";
        $total_cost = "";
        $club_id = "";
        $contract_key = "";
        $club_name = "";
        $first_name = "";
        $last_name = "";
    }
    $stmt3->close();
    
    $total = sprintf("%01.2f", $total);
    
    $message .= "<br><p class=\"bbackheader\"><Center><H3><strong>Totals:</strong></Center></H3></p>";
    $message .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Number of Sales</font></th>
  </tr>\n"; 
    
    $message .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$total</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$count</b></font>
</td>  
</tr>\n";  
    //$message .= "<br><p class=\"bbackheader\"><Center><H3><strong>Totals:</strong></Center></H3></p>";
    //$message .= "<tr><td> <Center><strong>Total Sales:</strong> $" .  $total ."</Center></td></tr>";
    //$message .= "<tr><td><Center><strong>Number of Sales:</strong>  " . $count . "</Center></td></tr>";
    //$message .= "<tr><td><Center><strong>New:</strong>  " . $newCount . "</Center></td></tr>";
    //$message .= "<tr><td><Center><strong>Renewals:</strong> " . $renewCount . "</Center></td></tr><br><br>";
    
    //$message .= "\r\n\r\nTotal Sales: $$total    \r\n\r\n   New: $newCount  Renewals: $renewCount\r\n\r\n\r\n\r\n";
  
  $message .=  "</table>
</head>
</html>";
  
    //$message = wordwrap($message, 70, "\r\n"); 
$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";  
$message = wordwrap($message, 70, "\r\n");
mail($contact_email, 'Daily Sales Report', $message, $headers);   
mail('greg@burbankathleticclub.com', 'Daily Sales Report', $message, $headers);
mail('christopherparello@gmail.com', 'Daily Sales Report', $message, $headers);
mail('sandi@burbankathleticclub.com', 'Daily Sales Report', $message, $headers);

$spinMonthlyCount = 0;
$yogaMonthlyCount = 0;
$spinClassCount = 0;
$yogaClassCount = 0;
$newServiceCount = 0;
$renewalServiceCount = 0;
$upgradeServiceCount = 0;
$pastDueCcCount = 0;
$pastDueAchCount = 0;
$pastDueCashCount = 0;
$pastDueCheckCount = 0;
$monthlyServicePrePayCount = 0;
$serviceCancelFeeCount = 0;
$guarenteeFeeCCCount = 0;
$guarenteeFeeACHCount = 0;
$guarenteeFeeCashCount = 0;
$guarenteeFeeCheckCount = 0;
$monthlyDuesCashCount = 0;
$monthlyDuesCcCount = 0;
$monthlyDuesCheckCount = 0;
$monthlyDuesAchCount = 0;
$declinedRejectionFeeCount = 0;
$giftCertCount = 0;
$declinedSettledCashCount = 0;
$declinedSettledCheckCount = 0;
$declinedSettledAchCount = 0;
$declinedSettledCcCount = 0;
$pastDueSettledCount = 0;
$memberHoldFeeCount = 0;
$achRejectionFeeCount = 0;
$ccRejectionFeeCount = 0;
$checkRejectionFeeCount = 0;
$cashRejectionFeeCount = 0;
$monthlyDuesCcSettledCount = 0;
$monthlyDuesCashSettledCount = 0;
$monthlyDuesCheckSettledCount = 0;
$monthlyDuesAchSettledCount = 0;
$monthlyPaymentCount = 0;


$spinMonthlyTot = 0;
$yogaMonthlyTot = 0;
$spinClassTot = 0;
$yogaClassTot = 0;
$newServiceTot = 0;
$renewalServiceTot = 0;
$upgradeServiceTot = 0;
$pastDueCcTot = 0;
$pastDueAchTot = 0;
$pastDueCashTot = 0;
$pastDueCheckTot = 0;
$monthlyServicePrePayTot = 0;
$serviceCancelFeeTot = 0;
$guarenteeFeeCCTot = 0;
$guarenteeFeeACHTot = 0;
$guarenteeFeeCashTot = 0;
$guarenteeFeeCheckTot = 0;
$monthlyDuesCashTot = 0;
$monthlyDuesCcTot = 0;
$monthlyDuesCheckTot = 0;
$monthlyDuesAchTot = 0;
$declinedRejectionFeeTot = 0;
$giftCertTot = 0;
$declinedSettledCashTot = 0;
$declinedSettledCheckTot = 0;
$declinedSettledAchTot = 0;
$declinedSettledCcTot = 0;
$pastDueSettledTot = 0;
$memberHoldFeeTot = 0;
$achRejectionFeeTot = 0;
$ccRejectionFeeTot = 0;
$checkRejectionFeeTot = 0;
$cashRejectionFeeTot = 0;
$monthlyDuesCcSettledTot = 0;
$monthlyDuesCashSettledTot = 0;
$monthlyDuesCheckSettledTot = 0;
$monthlyDuesAchSettledTot = 0;
$monthlyPaymentTot = 0;



$stmt = $dbMain->prepare("SELECT payment_amount, payment_description  FROM payment_history WHERE (payment_date BETWEEN '$dayStart' AND '$dayEnd') AND (payment_flag = 'PF' OR payment_flag = 'BD')");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($payment_amount, $payment_description);
while($stmt->fetch()){
    //echo"$payment_description $payment_amount<br>";
    switch($payment_description){
        case 'Spin Monthly Payment':
            $spinMonthlyCount++;
            $spinMonthlyTot += $payment_amount;
        break;
        case 'Yoga Monthly Payment':
            $yogaMonthlyCount++;
            $yogaMonthlyTot += $payment_amount;
        break;
        case 'Spin Class':
            $spinClassCount++;
            $spinClassTot += $payment_amount;
        break;
        case 'Yoga Class':
            $yogaClassCount++;
            $yogaClassTot += $payment_amount;
        break;
        case 'New Service':
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'PIF Membership'://
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'Service Renewal':
            $renewalServiceCount++;
            $renewalServiceTot += $payment_amount;
        break;
        case 'Service Upgrade':
            $upgradeServiceCount++;
            $upgradeServiceTot += $payment_amount;
                
        break;
        case 'Past Due CC':
            $pastDueCcCount++;
            $pastDueCcTot += $payment_amount;
        break;
        case 'Past Due Cash':
            
            $pastDueCashCount++;
            $pastDueCashTot += $payment_amount;
        break;
        case 'Past Due Check':
            $pastDueCheckCount++;
            $pastDueCheckTot += $payment_amount;
        break;
        case 'Past Due ACH':
            $pastDueAchCount++;
            $pastDueAchTot += $payment_amount;
        break;
        case 'Monthly Service Prepaid':
            $monthlyServicePrePayCount++;
            $monthlyServicePrePayTot += $payment_amount;
        break;
        case 'Service Cancel Fee':
            $serviceCancelFeeCount++;
            $serviceCancelFeeTot += $payment_amount;
        break;
        case 'Guarantee Fee CC':
            $guarenteeFeeCCCount++;
            $guarenteeFeeCCTot += $payment_amount;
        break;
        case 'Guarantee Fee ACH':
            $guarenteeFeeACHCount++;
            $guarenteeFeeACHTot += $payment_amount;
        break;
        case 'Guarantee Fee Cash':
            $guarenteeFeeCashCount++;
            $guarenteeFeeCashTot += $payment_amount;
        break;
        case 'Guarantee Fee Check':
            $guarenteeFeeCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues Cash':
            $monthlyDuesCashCount++;
            $monthlyDuesCashTot += $payment_amount;
        break;
        case 'Monthly Dues CC'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'EFT Credit'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'Monthly Dues Check':
            $monthlyDuesCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues ACH':
            $monthlyDuesAchCount++;
            $monthlyDuesAchTot += $payment_amount;
        break;
        case 'Monthly Payment':
            $monthlyPaymentCount++;
            $monthlyPaymentTot += $payment_amount;
        break;
        case 'Declined Rejection Fee':
            $declinedRejectionFeeCount++;
            $declinedRejectionFeeTot += $payment_amount;
        break;
        case 'Gift Certificate':
            $giftCertCount++;
            $giftCertTot += $payment_amount;
        break;
        case 'Declined Settled Cash':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
         case 'Declined Settled Check':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
         case 'Declined Settled CC':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
         case 'Declined Settled ACH':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Past Due Settled':
            $pastDueSettledCount++;
            $pastDueSettledTot += $payment_amount;
        break;
        case 'Member Hold Fee':
            $memberHoldFeeCount++;
            $memberHoldFeeTot += $payment_amount;
        break;
        case 'Monthly Dues CC Settled':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
        case 'Monthly Dues ACH Settled':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Monthly Dues Cash Settled':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
        case 'Monthly Dues Check Settled':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
        case 'CC Rejection Fee':
            $ccRejectionFeeCount++;
            $ccRejectionFeeTot += $payment_amount;
        break;
        case 'ACH Rejection Fee':
            $achRejectionFeeCount++;
            $achRejectionFeeTot += $payment_amount;
        break;
        case 'Check Rejection Fee':
            $checkRejectionFeeCount++;
            $checkRejectionFeeTot  += $payment_amount;
        break;
        case 'Cash Rejection Fee':
            $cashRejectionFeeCountt++;
            $cashRejectionFeeTot += $payment_amount;
        break;
    }
    
}
$stmt->close();

$todaysDate = date('m-d-Y',strtotime("yesterday"));
$totalSales = $newServiceTot + $renewalServiceTot + $upgradeServiceTot;
$totalCount = $newServiceCount + $renewalServiceCount + $upgradeServiceCount;

$message2 = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />
  
";

$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Daily Dashboard Report:</strong></Center></H1></p><br>";
$message2 .= "<tr><td> <Center><strong>Date:</strong> " .  $date ."</Center></td></tr><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Sales Numbers:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations</font></th>
  </tr>\n";
  
  
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$totalCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$totalSales</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$newServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewalServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$renewalServiceTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$upgradeServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$upgradeServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$serviceCancelFeeCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$serviceCancelFeeTot</b></font>
</td>
</tr>\n";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class</font></th>
  </tr>\n"; 

$message2 .=    "<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$giftCertCount</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$giftCertTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinClassTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaClassTot</b></font>
</td>
</tr>\n";


$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Fees Collected:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee</font></th>
  
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$memberHoldFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$memberHoldFeeTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$achRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$ccRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ccRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$checkRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$checkRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$cashRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cashRejectionFeeTot</b></font>
</td>  
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Recurring Billing:</strong></Center></H3></p><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Rate Fee:</strong></Center></H3></p><br>";

 $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeCCTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeACHCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeACHTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
</tr>\n";



$message2 .= "<p class=\"bbackheader\"><Center><H3><strong> Monthly Dues:    </strong></Center></H3></p><br>";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesAchCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyServicePrePayCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyServicePrePayTot</b></font>
</td>
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Collections:</strong></Center></H3></p><br>";


$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check</font></th>
  </tr>\n"; 
 
 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyPaymentCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyPaymentTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCheckTot</b></font>
</td>

</tr>\n";

$message2 .=" <tr> 
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled</font></th>
  </tr>\n"; 

 $message2 .=    "<tr>
 <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCashTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCheckTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCcTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueSettledCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueSettledTot</b></font>
</td>  
</tr>\n";


  $message2 .=  "</table>
</head>
</html>";
  
    //$message = wordwrap($message, 70, "\r\n"); 
$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   

mail('christopherparello@gmail.com', 'Daily Dashboard Report', $message2, $headers);
mail($contact_email, 'Daily Dashboard Report', $message2, $headers);
mail('sandi@burbankathleticclub.com', 'Daily Dashboard Report', $message2, $headers);

$sunday = date('w');//0 = sunday

if ($sunday == '0'){
    $spinMonthlyCount = 0;
$yogaMonthlyCount = 0;
$spinClassCount = 0;
$yogaClassCount = 0;
$newServiceCount = 0;
$renewalServiceCount = 0;
$upgradeServiceCount = 0;
$pastDueCcCount = 0;
$pastDueAchCount = 0;
$pastDueCashCount = 0;
$pastDueCheckCount = 0;
$monthlyServicePrePayCount = 0;
$serviceCancelFeeCount = 0;
$guarenteeFeeCCCount = 0;
$guarenteeFeeACHCount = 0;
$guarenteeFeeCashCount = 0;
$guarenteeFeeCheckCount = 0;
$monthlyDuesCashCount = 0;
$monthlyDuesCcCount = 0;
$monthlyDuesCheckCount = 0;
$monthlyDuesAchCount = 0;
$declinedRejectionFeeCount = 0;
$giftCertCount = 0;
$declinedSettledCashCount = 0;
$declinedSettledCheckCount = 0;
$declinedSettledAchCount = 0;
$declinedSettledCcCount = 0;
$pastDueSettledCount = 0;
$memberHoldFeeCount = 0;
$achRejectionFeeCount = 0;
$ccRejectionFeeCount = 0;
$checkRejectionFeeCount = 0;
$cashRejectionFeeCount = 0;
$monthlyDuesCcSettledCount = 0;
$monthlyDuesCashSettledCount = 0;
$monthlyDuesCheckSettledCount = 0;
$monthlyDuesAchSettledCount = 0;
$monthlyPaymentCount = 0;


$spinMonthlyTot = 0;
$yogaMonthlyTot = 0;
$spinClassTot = 0;
$yogaClassTot = 0;
$newServiceTot = 0;
$renewalServiceTot = 0;
$upgradeServiceTot = 0;
$pastDueCcTot = 0;
$pastDueAchTot = 0;
$pastDueCashTot = 0;
$pastDueCheckTot = 0;
$monthlyServicePrePayTot = 0;
$serviceCancelFeeTot = 0;
$guarenteeFeeCCTot = 0;
$guarenteeFeeACHTot = 0;
$guarenteeFeeCashTot = 0;
$guarenteeFeeCheckTot = 0;
$monthlyDuesCashTot = 0;
$monthlyDuesCcTot = 0;
$monthlyDuesCheckTot = 0;
$monthlyDuesAchTot = 0;
$declinedRejectionFeeTot = 0;
$giftCertTot = 0;
$declinedSettledCashTot = 0;
$declinedSettledCheckTot = 0;
$declinedSettledAchTot = 0;
$declinedSettledCcTot = 0;
$pastDueSettledTot = 0;
$memberHoldFeeTot = 0;
$achRejectionFeeTot = 0;
$ccRejectionFeeTot = 0;
$checkRejectionFeeTot = 0;
$cashRejectionFeeTot = 0;
$monthlyDuesCcSettledTot = 0;
$monthlyDuesCashSettledTot = 0;
$monthlyDuesCheckSettledTot = 0;
$monthlyDuesAchSettledTot = 0;
$monthlyPaymentTot = 0;

$weekStart = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),date('d')-8,date('Y')));
$weekEnd = date('Y-m-d H:i:s', mktime(23,59,59,date('m'),date('d')-1,date('Y')));

$stmt = $dbMain->prepare("SELECT payment_amount, payment_description  FROM payment_history WHERE (payment_date BETWEEN '$weekStart' AND '$weekEnd') AND (payment_flag = 'PF' OR payment_flag = 'BD')");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($payment_amount, $payment_description);
while($stmt->fetch()){
    //echo"$payment_description $payment_amount<br>";
    switch($payment_description){
        case 'Spin Monthly Payment':
            $spinMonthlyCount++;
            $spinMonthlyTot += $payment_amount;
        break;
        case 'Yoga Monthly Payment':
            $yogaMonthlyCount++;
            $yogaMonthlyTot += $payment_amount;
        break;
        case 'Spin Class':
            $spinClassCount++;
            $spinClassTot += $payment_amount;
        break;
        case 'Yoga Class':
            $yogaClassCount++;
            $yogaClassTot += $payment_amount;
        break;
        case 'New Service':
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'PIF Membership'://
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'Service Renewal':
            $renewalServiceCount++;
            $renewalServiceTot += $payment_amount;
        break;
        case 'Service Upgrade':
            $upgradeServiceCount++;
            $upgradeServiceTot += $payment_amount;
                
        break;
        case 'Past Due CC':
            $pastDueCcCount++;
            $pastDueCcTot += $payment_amount;
        break;
        case 'Past Due Cash':
            
            $pastDueCashCount++;
            $pastDueCashTot += $payment_amount;
        break;
        case 'Past Due Check':
            $pastDueCheckCount++;
            $pastDueCheckTot += $payment_amount;
        break;
        case 'Past Due ACH':
            $pastDueAchCount++;
            $pastDueAchTot += $payment_amount;
        break;
        case 'Monthly Service Prepaid':
            $monthlyServicePrePayCount++;
            $monthlyServicePrePayTot += $payment_amount;
        break;
        case 'Service Cancel Fee':
            $serviceCancelFeeCount++;
            $serviceCancelFeeTot += $payment_amount;
        break;
        case 'Guarantee Fee CC':
            $guarenteeFeeCCCount++;
            $guarenteeFeeCCTot += $payment_amount;
        break;
        case 'Guarantee Fee ACH':
            $guarenteeFeeACHCount++;
            $guarenteeFeeACHTot += $payment_amount;
        break;
        case 'Guarantee Fee Cash':
            $guarenteeFeeCashCount++;
            $guarenteeFeeCashTot += $payment_amount;
        break;
        case 'Guarantee Fee Check':
            $guarenteeFeeCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues Cash':
            $monthlyDuesCashCount++;
            $monthlyDuesCashTot += $payment_amount;
        break;
        case 'Monthly Dues CC'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'EFT Credit'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'Monthly Dues Check':
            $monthlyDuesCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues ACH':
            $monthlyDuesAchCount++;
            $monthlyDuesAchTot += $payment_amount;
        break;
        case 'Monthly Payment':
            $monthlyPaymentCount++;
            $monthlyPaymentTot += $payment_amount;
        break;
        case 'Declined Rejection Fee':
            $declinedRejectionFeeCount++;
            $declinedRejectionFeeTot += $payment_amount;
        break;
        case 'Gift Certificate':
            $giftCertCount++;
            $giftCertTot += $payment_amount;
        break;
        case 'Declined Settled Cash':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
         case 'Declined Settled Check':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
         case 'Declined Settled CC':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
         case 'Declined Settled ACH':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Past Due Settled':
            $pastDueSettledCount++;
            $pastDueSettledTot += $payment_amount;
        break;
        case 'Member Hold Fee':
            $memberHoldFeeCount++;
            $memberHoldFeeTot += $payment_amount;
        break;
        case 'Monthly Dues CC Settled':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
        case 'Monthly Dues ACH Settled':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Monthly Dues Cash Settled':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
        case 'Monthly Dues Check Settled':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
        case 'CC Rejection Fee':
            $ccRejectionFeeCount++;
            $ccRejectionFeeTot += $payment_amount;
        break;
        case 'ACH Rejection Fee':
            $achRejectionFeeCount++;
            $achRejectionFeeTot += $payment_amount;
        break;
        case 'Check Rejection Fee':
            $checkRejectionFeeCount++;
            $checkRejectionFeeTot  += $payment_amount;
        break;
        case 'Cash Rejection Fee':
            $cashRejectionFeeCountt++;
            $cashRejectionFeeTot += $payment_amount;
        break;
    }
    
}
$stmt->close();
//$weekStart = date('m-d-Y',strtotime("last saturday"));
//$todaysDate = date('m-d-Y',strtotime('yesterday'));


$wstart = explode(' ',$weekStart);
$wend = explode(' ',$weekEnd);

$totalSales = $newServiceTot + $renewalServiceTot + $upgradeServiceTot;
$totalCount = $newServiceCount + $renewalServiceCount + $upgradeServiceCount;

$message2 = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />
  
";

$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Weekly Dashboard Report:</strong></Center></H1></p><br>";
$message2 .= "<tr><td> <Center><strong>Date:</strong> " .  $wstart[0] ."<strong>   to   </strong> " .  $wend[0] ."</Center></td></tr><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Sales Numbers:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations</font></th>
  </tr>\n";
  
  
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$totalCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$totalSales</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$newServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewalServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$renewalServiceTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$upgradeServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$upgradeServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$serviceCancelFeeCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$serviceCancelFeeTot</b></font>
</td>
</tr>\n";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class</font></th>
  </tr>\n"; 

$message2 .=    "<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$giftCertCount</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$giftCertTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinClassTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaClassTot</b></font>
</td>
</tr>\n";


$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Fees Collected:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee</font></th>
  
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$memberHoldFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$memberHoldFeeTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$achRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$ccRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ccRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$checkRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$checkRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$cashRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cashRejectionFeeTot</b></font>
</td>  
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Recurring Billing:</strong></Center></H3></p><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Rate Fee:</strong></Center></H3></p><br>";

 $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeCCTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeACHCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeACHTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
</tr>\n";



$message2 .= "<p class=\"bbackheader\"><Center><H3><strong> Monthly Dues:    </strong></Center></H3></p><br>";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesAchCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyServicePrePayCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyServicePrePayTot</b></font>
</td>
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Collections:</strong></Center></H3></p><br>";


$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check</font></th>
  </tr>\n"; 
 
 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyPaymentCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyPaymentTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCheckTot</b></font>
</td>

</tr>\n";

$message2 .=" <tr> 
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled</font></th>
  </tr>\n"; 

 $message2 .=    "<tr>
 <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCashTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCheckTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCcTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueSettledCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueSettledTot</b></font>
</td>  
</tr>\n";


  $message2 .=  "</table>
</head>
</html>";
  
    //$message = wordwrap($message, 70, "\r\n"); 
$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   

mail('christopherparello@gmail.com', 'Weekly Dashboard Report', $message2, $headers);
mail($contact_email, 'Daily Dashboard Report', $message2, $headers);
mail('sandi@burbankathleticclub.com', 'Daily Dashboard Report', $message2, $headers);
}

$lastDay = date('t');//0 = sunday
$todayDay = date('d');

if ($todayDay == $lastDay){
    $spinMonthlyCount = 0;
$yogaMonthlyCount = 0;
$spinClassCount = 0;
$yogaClassCount = 0;
$newServiceCount = 0;
$renewalServiceCount = 0;
$upgradeServiceCount = 0;
$pastDueCcCount = 0;
$pastDueAchCount = 0;
$pastDueCashCount = 0;
$pastDueCheckCount = 0;
$monthlyServicePrePayCount = 0;
$serviceCancelFeeCount = 0;
$guarenteeFeeCCCount = 0;
$guarenteeFeeACHCount = 0;
$guarenteeFeeCashCount = 0;
$guarenteeFeeCheckCount = 0;
$monthlyDuesCashCount = 0;
$monthlyDuesCcCount = 0;
$monthlyDuesCheckCount = 0;
$monthlyDuesAchCount = 0;
$declinedRejectionFeeCount = 0;
$giftCertCount = 0;
$declinedSettledCashCount = 0;
$declinedSettledCheckCount = 0;
$declinedSettledAchCount = 0;
$declinedSettledCcCount = 0;
$pastDueSettledCount = 0;
$memberHoldFeeCount = 0;
$achRejectionFeeCount = 0;
$ccRejectionFeeCount = 0;
$checkRejectionFeeCount = 0;
$cashRejectionFeeCount = 0;
$monthlyDuesCcSettledCount = 0;
$monthlyDuesCashSettledCount = 0;
$monthlyDuesCheckSettledCount = 0;
$monthlyDuesAchSettledCount = 0;
$monthlyPaymentCount = 0;


$spinMonthlyTot = 0;
$yogaMonthlyTot = 0;
$spinClassTot = 0;
$yogaClassTot = 0;
$newServiceTot = 0;
$renewalServiceTot = 0;
$upgradeServiceTot = 0;
$pastDueCcTot = 0;
$pastDueAchTot = 0;
$pastDueCashTot = 0;
$pastDueCheckTot = 0;
$monthlyServicePrePayTot = 0;
$serviceCancelFeeTot = 0;
$guarenteeFeeCCTot = 0;
$guarenteeFeeACHTot = 0;
$guarenteeFeeCashTot = 0;
$guarenteeFeeCheckTot = 0;
$monthlyDuesCashTot = 0;
$monthlyDuesCcTot = 0;
$monthlyDuesCheckTot = 0;
$monthlyDuesAchTot = 0;
$declinedRejectionFeeTot = 0;
$giftCertTot = 0;
$declinedSettledCashTot = 0;
$declinedSettledCheckTot = 0;
$declinedSettledAchTot = 0;
$declinedSettledCcTot = 0;
$pastDueSettledTot = 0;
$memberHoldFeeTot = 0;
$achRejectionFeeTot = 0;
$ccRejectionFeeTot = 0;
$checkRejectionFeeTot = 0;
$cashRejectionFeeTot = 0;
$monthlyDuesCcSettledTot = 0;
$monthlyDuesCashSettledTot = 0;
$monthlyDuesCheckSettledTot = 0;
$monthlyDuesAchSettledTot = 0;
$monthlyPaymentTot = 0;

$monthStart = date('Y-m-d H:i:s', mktime(0,0,0,date('m'),1,date('Y')));
$monthEnd = date('Y-m-d H:i:s', mktime(23,59,59,date('m'),date('t'),date('Y')));
//echo "$monthStart $monthEnd";

$stmt = $dbMain->prepare("SELECT payment_amount, payment_description  FROM payment_history WHERE (payment_date BETWEEN '$monthStart' AND '$monthEnd') AND (payment_flag = 'PF' OR payment_flag = 'BD')");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($payment_amount, $payment_description);
while($stmt->fetch()){
    //echo"$payment_description $payment_amount<br>";
    switch($payment_description){
        case 'Spin Monthly Payment':
            $spinMonthlyCount++;
            $spinMonthlyTot += $payment_amount;
        break;
        case 'Yoga Monthly Payment':
            $yogaMonthlyCount++;
            $yogaMonthlyTot += $payment_amount;
        break;
        case 'Spin Class':
            $spinClassCount++;
            $spinClassTot += $payment_amount;
        break;
        case 'Yoga Class':
            $yogaClassCount++;
            $yogaClassTot += $payment_amount;
        break;
        case 'New Service':
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'PIF Membership'://
            $newServiceCount++;
            $newServiceTot += $payment_amount;
        break;
        case 'Service Renewal':
            $renewalServiceCount++;
            $renewalServiceTot += $payment_amount;
        break;
        case 'Service Upgrade':
            $upgradeServiceCount++;
            $upgradeServiceTot += $payment_amount;
                
        break;
        case 'Past Due CC':
            $pastDueCcCount++;
            $pastDueCcTot += $payment_amount;
        break;
        case 'Past Due Cash':
            
            $pastDueCashCount++;
            $pastDueCashTot += $payment_amount;
        break;
        case 'Past Due Check':
            $pastDueCheckCount++;
            $pastDueCheckTot += $payment_amount;
        break;
        case 'Past Due ACH':
            $pastDueAchCount++;
            $pastDueAchTot += $payment_amount;
        break;
        case 'Monthly Service Prepaid':
            $monthlyServicePrePayCount++;
            $monthlyServicePrePayTot += $payment_amount;
        break;
        case 'Service Cancel Fee':
            $serviceCancelFeeCount++;
            $serviceCancelFeeTot += $payment_amount;
        break;
        case 'Guarantee Fee CC':
            $guarenteeFeeCCCount++;
            $guarenteeFeeCCTot += $payment_amount;
        break;
        case 'Guarantee Fee ACH':
            $guarenteeFeeACHCount++;
            $guarenteeFeeACHTot += $payment_amount;
        break;
        case 'Guarantee Fee Cash':
            $guarenteeFeeCashCount++;
            $guarenteeFeeCashTot += $payment_amount;
        break;
        case 'Guarantee Fee Check':
            $guarenteeFeeCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues Cash':
            $monthlyDuesCashCount++;
            $monthlyDuesCashTot += $payment_amount;
        break;
        case 'Monthly Dues CC'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'EFT Credit'://
            $monthlyDuesCcCount++;
            $monthlyDuesCcTot += $payment_amount;
        break;
        case 'Monthly Dues Check':
            $monthlyDuesCheckCount++;
            $monthlyDuesCheckTot += $payment_amount;
        break;
        case 'Monthly Dues ACH':
            $monthlyDuesAchCount++;
            $monthlyDuesAchTot += $payment_amount;
        break;
        case 'Monthly Payment':
            $monthlyPaymentCount++;
            $monthlyPaymentTot += $payment_amount;
        break;
        case 'Declined Rejection Fee':
            $declinedRejectionFeeCount++;
            $declinedRejectionFeeTot += $payment_amount;
        break;
        case 'Gift Certificate':
            $giftCertCount++;
            $giftCertTot += $payment_amount;
        break;
        case 'Declined Settled Cash':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
         case 'Declined Settled Check':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
         case 'Declined Settled CC':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
         case 'Declined Settled ACH':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Past Due Settled':
            $pastDueSettledCount++;
            $pastDueSettledTot += $payment_amount;
        break;
        case 'Member Hold Fee':
            $memberHoldFeeCount++;
            $memberHoldFeeTot += $payment_amount;
        break;
        case 'Monthly Dues CC Settled':
            $declinedSettledCcCount++;
            $declinedSettledCcTot += $payment_amount;
        break;
        case 'Monthly Dues ACH Settled':
            $declinedSettledAchCount++;
            $declinedSettledAchTot += $payment_amount;
        break;
        case 'Monthly Dues Cash Settled':
            $declinedSettledCashCount++;
            $declinedSettledCashTot += $payment_amount;
        break;
        case 'Monthly Dues Check Settled':
            $declinedSettledCheckCount++;
            $declinedSettledCheckTot += $payment_amount;
        break;
        case 'CC Rejection Fee':
            $ccRejectionFeeCount++;
            $ccRejectionFeeTot += $payment_amount;
        break;
        case 'ACH Rejection Fee':
            $achRejectionFeeCount++;
            $achRejectionFeeTot += $payment_amount;
        break;
        case 'Check Rejection Fee':
            $checkRejectionFeeCount++;
            $checkRejectionFeeTot  += $payment_amount;
        break;
        case 'Cash Rejection Fee':
            $cashRejectionFeeCountt++;
            $cashRejectionFeeTot += $payment_amount;
        break;
    }
    
}
$stmt->close();
//$weekStart = date('m-d-Y',strtotime("last saturday"));
//$todaysDate = date('m-d-Y',strtotime('yesterday'));


$wstart = explode(' ',$monthStart);
$wend = explode(' ',$monthEnd);
$totalSales = $newServiceTot + $renewalServiceTot + $upgradeServiceTot;
$totalCount = $newServiceCount + $renewalServiceCount + $upgradeServiceCount;


$message2 = "<!DOCTYPE html PUBLIC \"\-//W3C//DTD XHTML 1.0 Transitional//EN\"\ \"\http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"\>
<html xmlns=\"\http://www.w3.org/1999/xhtml\"\>
 <head>
  <meta http-equiv=\"\\Content-Type\"\ content=\"\text/html; charset=UTF-8\"\ />
  
";

$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Club Manager Pro</strong></Center></H1></p>";
$message2 .= "<p class=\"bbackheader\"><Center><H1><strong>Monthly Dashboard Report:</strong></Center></H1></p><br>";
$message2 .= "<tr><td> <Center><strong>Date:</strong> " .  $wstart[0] ."<strong>   to   </strong> " .  $wend[0] ."</Center></td></tr><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Sales Numbers:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Total Sales</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">New Services</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Renewals</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Upgrades</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Service Cancellations</font></th>
  </tr>\n";
  
  
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$totalCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$totalSales</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$newServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$newServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$renewalServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$renewalServiceTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$upgradeServiceCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$upgradeServiceTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$serviceCancelFeeCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$serviceCancelFeeTot</b></font>
</td>
</tr>\n";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Gift Certificates</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Spinning</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Yoga</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Spin Class</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Yoga Class</font></th>
  </tr>\n"; 

$message2 .=    "<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$giftCertCount</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$giftCertTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaMonthlyCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaMonthlyTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$spinClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$spinClassTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$yogaClassCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$yogaClassTot</b></font>
</td>
</tr>\n";


$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Fees Collected:</strong></Center></H3></p><br>";
   
    $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Member Hold Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">ACH Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">CC Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Check Rejection Fee</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Cash Rejection Fee</font></th>
  
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$memberHoldFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$memberHoldFeeTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$achRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$achRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$ccRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$ccRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$checkRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$checkRejectionFeeTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$cashRejectionFeeCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$cashRejectionFeeTot</b></font>
</td>  
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Recurring Billing:</strong></Center></H3></p><br>";
$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Rate Fee:</strong></Center></H3></p><br>";

 $message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Guarentee Fee Cash</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeCCTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeACHCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$guarenteeFeeACHTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
</tr>\n";



$message2 .= "<p class=\"bbackheader\"><Center><H3><strong> Monthly Dues:    </strong></Center></H3></p><br>";

$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues ACH</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Dues Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Prepaid Dues</font></th>
  </tr>\n"; 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$guarenteeFeeCCCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesAchCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCheckCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCheckTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyDuesCashCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyDuesCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyServicePrePayCount</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyServicePrePayTot</b></font>
</td>
</tr>\n";

$message2 .= "<p class=\"bbackheader\"><Center><H3><strong>Collections:</strong></Center></H3></p><br>";


$message2 .=" <tr>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">#</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Monthly Payment</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach Count</font></th>
  <th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Ach</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Cash</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Check</font></th>
  </tr>\n"; 
 
 
    
    $message2 .=    "<tr>
<td align=\"left\" valign =\"top\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>1</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$monthlyPaymentCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$monthlyPaymentTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCcTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCashTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueCheckTot</b></font>
</td>

</tr>\n";

$message2 .=" <tr> 
   <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Cash</font></th> 
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled Check</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled ACH</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Declined Settled CC</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled Count</font></th>
  <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Past Due Settled</font></th>
  </tr>\n"; 

 $message2 .=    "<tr>
 <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCashCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCashTot</b></font>
</td>  
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCheckCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCheckTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledAchCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledAchTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$declinedSettledCcCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$declinedSettledCcTot</b></font>
</td>
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$pastDueSettledCount</b></font>
</td> 
<td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
<font face=\"Arial\" size=\"1\" color=\"black\"><b>$$pastDueSettledTot</b></font>
</td>  
</tr>\n";


  $message2 .=  "</table>
</head>
</html>";
  
    //$message = wordwrap($message, 70, "\r\n"); 
$headers  = "From: ClubManagerPro@bac.com\r\n";
$headers .= "Content-type: text/html\r\n";   

mail('christopherparello@gmail.com', 'Monthly Dashboard Report', $message2, $headers);
mail($contact_email, 'Daily Dashboard Report', $message2, $headers);
mail('sandi@burbankathleticclub.com', 'Daily Dashboard Report', $message2, $headers);

}
}
//===============================================

}
$report = new emailDSRReports();
$report->moveData();







?>