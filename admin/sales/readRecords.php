<?php

class readMembers{

private $contractKey = null;
private $deleteList = null;
private $fieldCount = 0;

function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}



//=================================================
function readRecords()   {

$dbMain = $this->dbconnect();

$recordHeader = "$this->fieldCount  CONTRACT KEY: $this->contractKey   TABLE ROWS READ<br>";
 
 
//--------------------------------------------------------------------------------------------------------------------------------------------------- 
$stmt = $dbMain ->prepare("SELECT * FROM sales_info WHERE contract_key = '$this->contractKey' ");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w, $x, $y);

 while ($stmt->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">sales_info</th></tr>
                    <tr><td>sales_key</td><td>$a</td></tr>
                    <tr><td>location_id</td><td>$b</td></tr>
                    <tr><td>contract_location</td><td>$c</td></tr>
                    <tr><td>user_id</td><td>$d</td></tr>
                    <tr><td>group_type </td><td>$e</td></tr> 
                    <tr><td>group_number</td><td>$f</td></tr>
                    <tr><td>club_id</td><td>$g</td></tr> 
                    <tr><td>service_key</td><td>$h</td></tr>
                    <tr><td>service_name</td><td>$i</td></tr>
                    <tr><td>service_quantity</td><td>$j</td></tr>
                    <tr><td>service_term</td><td>$k</td></tr>
                    <tr><td>service_type</td><td>$l</td></tr>
                    <tr><td>unit_price</td><td>$m</td></tr>
                    <tr><td>group_price</td><td>$n</td></tr>
                    <tr><td>overide_pin</td><td>$o</td></tr>
                    <tr><td>overide_unit_price</td><td>$p</td></tr>
                    <tr><td>overide_group_price</td><td>$q</td></tr>
                    <tr><td>contract_key</td><td>$r</td></tr>
                    <tr><td>term_type</td><td>$s</td></tr>
                    <tr><td>renewal</td><td>$t</td></tr>
                    <tr><td>upgrade</td><td>$u</td></tr>
                    <tr><td>internet</td><td>$v</td></tr>
                    <tr><td>sale_date_time</td><td>$w</td></tr>
                    <tr><td>am_pm</td><td>$x</td></tr>
                    <tr><td>early_renewal</td><td>$y</td></tr> 
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    ";                                                                       
                }  
                
if($stmt->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">sales_info</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

                    
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }		 
$stmt->close(); 

//---------------------------------------------------------------------------------------------------------------------------------------------------
$stmt2 = $dbMain ->prepare("SELECT * FROM account_notes WHERE contract_key = '$this->contractKey' ");
$stmt2->execute();      
$stmt2->store_result();   
$stmt2->bind_result($a, $b, $c, $d, $e, $f);

    while ($stmt2->fetch()) {
    
                     $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">account_notes</th></tr>
                    <tr><td>contract_key_key</td><td>$a</td></tr>
                    <tr><td>user_id</td><td>$b</td></tr>
                    <tr><td>note_date</td><td>$c</td></tr>
                    <tr><td>am_pm</td><td>$d</td></tr>
                    <tr><td>note_topic</td><td>$e</td></tr> 
                    <tr><td>note_message</td><td>$f</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    "; 
    }
    
if($stmt2->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">account_notes</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }
    

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt2->execute())  {
	printf("Error: %s.\n", $stmt2->error);
   }		 
$stmt2->close(); 

//---------------------------------------------------------------------------------------------------------------------------------------------------
$stmt3 = $dbMain ->prepare("SELECT * FROM account_status WHERE contract_key = '$this->contractKey' ");
$stmt3->execute();      
$stmt3->store_result();   
$stmt3->bind_result($a, $b, $c, $d);

    while ($stmt3->fetch()) {
    
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">account_status</th></tr>
                    <tr><td>contract_key_key</td><td>$a</td></tr>
                    <tr><td>service_key</td><td>$b</td></tr>
                    <tr><td>account_status</td><td>$c</td></tr>
                    <tr><td>status_date</td><td>$d</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    "; 
         }
         
if($stmt3->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">account_status</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                
         
$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt3->execute())  {
	printf("Error: %s.\n", $stmt3->error);
   }		 
$stmt3->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt4 = $dbMain ->prepare("SELECT * FROM banking_info WHERE contract_key = '$this->contractKey' ");
$stmt4->execute();      
$stmt4->store_result();   
$stmt4->bind_result($a, $b, $c, $d, $e, $f, $g, $h);

 while ($stmt4->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">banking_info</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>bank_name</td><td>$b</td></tr>
                    <tr><td>account_type</td><td>$c</td></tr>
                    <tr><td>account_fname</td><td>$d</td></tr>
                    <tr><td>account_mname</td><td>$e</td></tr> 
                    <tr><td>account_lname</td><td>$f</td></tr>
                    <tr><td>account_number</td><td>$g</td></tr> 
                    <tr><td>routing_number</td><td>$h</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    ";
           }
           
if($stmt4->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">banking_info</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                     

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt4->execute())  {
	printf("Error: %s.\n", $stmt4->error);
   }		 
$stmt4->close(); 

//-----------------------------------------------------------------------------------------------------------------------------------------------
$stmt5 = $dbMain ->prepare("SELECT * FROM contract_info WHERE contract_key = '$this->contractKey' ");
$stmt5->execute();      
$stmt5->store_result();   
$stmt5->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v, $w, $x, $y);

 while ($stmt5->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">contract_info</th></tr>
                    <tr><td>user_id</td><td>$a</td></tr>
                    <tr><td>contract_key </td><td>$b</td></tr>
                    <tr><td>contract_type</td><td>$c</td></tr>
                    <tr><td>transfer</td><td>$d</td></tr>
                    <tr><td>signup_date</td><td>$e</td></tr> 
                    <tr><td>club_id</td><td>$f</td></tr>
                    <tr><td>contract_location</td><td>$g</td></tr> 
                    <tr><td>contract_date</td><td>$h</td></tr>
                    <tr><td>contract_terms</td><td>$i</td></tr>
                    <tr><td>pay_quit</td><td>$j</td></tr>
                    <tr><td>host_type</td><td>$k</td></tr>
                    <tr><td>first_name</td><td>$l</td></tr>
                    <tr><td>middle_name</td><td>$m</td></tr>
                    <tr><td>last_name</td><td>$n</td></tr>
                    <tr><td>street</td><td>$o</td></tr>
                    <tr><td>city</td><td>$p</td></tr>
                    <tr><td>state</td><td>$q</td></tr>
                    <tr><td>zip</td><td>$r</td></tr>
                    <tr><td>primary_phone</td><td>$s</td></tr>
                    <tr><td>cell_phone</td><td>$t</td></tr>
                    <tr><td>email</td><td>$u</td></tr>
                    <tr><td>dob</td><td>$v</td></tr>
                    <tr><td>license_number</td><td>$w</td></tr>
                    <tr><td>grace_period</td><td>$x</td></tr>
                    <tr><td>contract_html</td><td>$y</td></tr> 
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
                    ";                                                                       
                }  
                
if($stmt5->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">contract_info</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt5->execute())  {
	printf("Error: %s.\n", $stmt5->error);
   }		 
$stmt5->close(); 

//-------------------------------------------------------------------------------------------------------------------------------------------------
$stmt6 = $dbMain ->prepare("SELECT * FROM contract_keys WHERE contract_key = '$this->contractKey' ");
$stmt6->execute();      
$stmt6->store_result();   
$stmt6->bind_result($a);

 while ($stmt6->fetch()) {  
        
     $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">contract_key</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                   }
                   
if($stmt6->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">contract_key</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";


if(!$stmt6->execute())  {
	printf("Error: %s.\n", $stmt6->error);
   }		 
$stmt6->close(); 

//-------------------------------------------------------------------------------------------------------------------------------------------------
$stmt7 = $dbMain ->prepare("SELECT * FROM credit_info WHERE contract_key = '$this->contractKey' ");
$stmt7->execute();      
$stmt7->store_result();   
$stmt7->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l);

 while ($stmt7->fetch()) {  
 
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">credit_info</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>card_fname</td><td>$b</td></tr>
                    <tr><td>card_mname</td><td>$c</td></tr>
                    <tr><td>card_lname</td><td>$d</td></tr>
                    <tr><td>card_street</td><td>$e</td></tr> 
                    <tr><td>card_city</td><td>$f</td></tr>
                    <tr><td>card_state</td><td>$g</td></tr> 
                    <tr><td>card_zip</td><td>$h</td></tr>
                    <tr><td>card_type</td><td>$i</td></tr>
                    <tr><td>card_number</td><td>$j</td></tr>
                    <tr><td>card_cvv</td><td>$k</td></tr>
                    <tr><td>card_exp_date</td><td>$l</td></tr> 
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                   }
                   
if($stmt7->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">credit_info</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt7->execute())  {
	printf("Error: %s.\n", $stmt7->error);
   }		 
$stmt7->close(); 

//-------------------------------------------------------------------------------------------------------------------------------------------------
$stmt8 = $dbMain ->prepare("SELECT * FROM initial_payments WHERE contract_key = '$this->contractKey' ");
$stmt8->execute();      
$stmt8->store_result();   
$stmt8->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p);

 while ($stmt8->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">initial_payments</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>process_fee_monthly</td><td>$b</td></tr>
                    <tr><td>process_fee_full</td><td>$c</td></tr>
                    <tr><td>enhance_fee</td><td>$d</td></tr>
                    <tr><td>new_member_fee</td><td>$e</td></tr> 
                    <tr><td>todays_payment</td><td>$f</td></tr>
                    <tr><td>cash_payment</td><td>$g</td></tr> 
                    <tr><td>check_payment</td><td>$h</td></tr>
                    <tr><td>ach_payment</td><td>$i</td></tr>
                    <tr><td>credit_payment</td><td>$j</td></tr>
                    <tr><td>balance_due</td><td>$k</td></tr>
                    <tr><td>due_date</td><td>$l</td></tr>
                    <tr><td>process_date</td><td>$m</td></tr>
                    <tr><td>due_status</td><td>$n</td></tr>
                    <tr><td>min_total_due</td><td>$o</td></tr>
                    <tr><td>signup_date</td><td>$p</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                   }

if($stmt8->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">initial_payments</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt8->execute())  {
	printf("Error: %s.\n", $stmt8->error);
   }		 
$stmt8->close(); 

//---------------------------------------------------------------------------------------------------------------------------------------------------
$stmt9 = $dbMain ->prepare("SELECT * FROM member_groups WHERE contract_key = '$this->contractKey' ");
$stmt9->execute();      
$stmt9->store_result();   
$stmt9->bind_result($a, $b, $c, $d, $e, $f);

 while ($stmt9->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">member_groups</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>group_type</td><td>$b</td></tr>
                    <tr><td>group_number</td><td>$c</td></tr>
                    <tr><td>group_name</td><td>$d</td></tr>
                    <tr><td>group_address</td><td>$e</td></tr> 
                    <tr><td>group_phone</td><td>$f</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt9->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">member_groups</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt9->execute())  {
	printf("Error: %s.\n", $stmt9->error);
   }		 
$stmt9->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt10 = $dbMain ->prepare("SELECT * FROM member_info WHERE contract_key = '$this->contractKey' ");
$stmt10->execute();      
$stmt10->store_result();   
$stmt10->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s);

 while ($stmt10->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">member_info</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>member_id</td><td>$b</td></tr>
                    <tr><td>first_name</td><td>$c</td></tr>
                    <tr><td>middle_name</td><td>$d</td></tr>
                    <tr><td>last_name</td><td>$e</td></tr> 
                    <tr><td>street</td><td>$f</td></tr>
                    <tr><td>city</td><td>$g</td></tr> 
                    <tr><td>state</td><td>$h</td></tr>
                    <tr><td>zip</td><td>$i</td></tr>
                    <tr><td>primary_phone</td><td>$j</td></tr>
                    <tr><td>cell_phone</td><td>$k</td></tr>
                    <tr><td>email</td><td>$l</td></tr>
                    <tr><td>dob</td><td>$m</td></tr>
                    <tr><td>license_number</td><td>$n</td></tr>
                    <tr><td>emg_contact</td><td>$o</td></tr>
                    <tr><td>emg_relationship</td><td>$p</td></tr>
                    <tr><td>emg_phone_phone</td><td>$q</td></tr>
                    <tr><td>liability_terms</td><td>$r</td></tr>
                    <tr><td>member_photo</td><td>$s</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                   }

if($stmt10->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">member_info</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt10->execute())  {
	printf("Error: %s.\n", $stmt10->error);
   }		 
$stmt10->close();
 
//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt11 = $dbMain ->prepare("SELECT * FROM monthly_payments WHERE contract_key = '$this->contractKey' ");
$stmt11->execute();      
$stmt11->store_result();   
$stmt11->bind_result($a, $b, $c, $d, $e);

 while ($stmt11->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">monthly_payments</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>monthly_billing_type</td><td>$b</td></tr>
                    <tr><td>cycle_date</td><td>$c</td></tr>
                    <tr><td>billing_amount</td><td>$d</td></tr>
                    <tr><td>billing_status</td><td>$e</td></tr> 
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt11->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">monthly_payments</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt11->execute())  {
	printf("Error: %s.\n", $stmt11->error);
   }		 
$stmt11->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt12 = $dbMain ->prepare("SELECT * FROM monthly_services WHERE contract_key = '$this->contractKey' ");
$stmt12->execute();      
$stmt12->store_result();   
$stmt12->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p, $q, $r, $s, $t, $u, $v);

 while ($stmt12->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">monthly_services</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>group_type</td><td>$b</td></tr>
                    <tr><td>group_number</td><td>$c</td></tr>
                    <tr><td>service_key</td><td>$d</td></tr>
                    <tr><td>club_id</td><td>$e</td></tr> 
                    <tr><td>service_name</td><td>$f</td></tr>
                    <tr><td>number_months</td><td>$g</td></tr> 
                    <tr><td>unit_price</td><td>$h</td></tr>
                    <tr><td>unit_renew_rate</td><td>$i</td></tr>
                    <tr><td>group_price</td><td>$j</td></tr>
                    <tr><td>group_renew_rate</td><td>$k</td></tr>
                    <tr><td>term_type</td><td>$l</td></tr>
                    <tr><td>initiation_fee</td><td>$m</td></tr>
                    <tr><td>down_payment</td><td>$n</td></tr>
                    <tr><td>monthly_dues</td><td>$o</td></tr>
                    <tr><td>pro_rate_dues</td><td>$p</td></tr>
                    <tr><td>pro_date_start</td><td>$q</td></tr>
                    <tr><td>pro_date_end</td><td>$r</td></tr>
                    <tr><td>start_date</td><td>$s</td></tr>
                    <tr><td>end_date</td><td>$t</td></tr>
                    <tr><td>user_id</td><td>$u</td></tr>
                    <tr><td>signup_date</td><td>$v</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt12->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">monthly_services</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";
 
if(!$stmt12->execute())  {
	printf("Error: %s.\n", $stmt12->error);
   }		 
$stmt12->close(); 


//---------------------------------------------------------------------------------------------------------------------------------------------------
$stmt13 = $dbMain ->prepare("SELECT * FROM paid_full_services WHERE contract_key = '$this->contractKey' ");
$stmt13->execute();      
$stmt13->store_result();   
$stmt13->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k, $l, $m, $n, $o, $p);

 while ($stmt13->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">paid_full_services</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>group_type</td><td>$b</td></tr>
                    <tr><td>group_number</td><td>$c</td></tr>
                    <tr><td>service_key</td><td>$d</td></tr>
                    <tr><td>club_id</td><td>$e</td></tr> 
                    <tr><td>service_name</td><td>$f</td></tr>
                    <tr><td>service_quantity</td><td>$g</td></tr> 
                    <tr><td>service_term</td><td>$h</td></tr>
                    <tr><td>unit_price</td><td>$i</td></tr>
                    <tr><td>unit_renew_rate</td><td>$j</td></tr>
                    <tr><td>group_price</td><td>$k</td></tr>
                    <tr><td>group_renew_rate</td><td>$l</td></tr>
                    <tr><td>start_date</td><td>$m</td></tr>
                    <tr><td>end_date</td><td>$n</td></tr>
                    <tr><td>user_id</td><td>$o</td></tr>
                    <tr><td>signup_date</td><td>$p</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                   }

if($stmt13->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">paid_full_services</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt13->execute())  {
	printf("Error: %s.\n", $stmt13->error);
   }		 
$stmt13->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt14 = $dbMain ->prepare("SELECT * FROM new_monthly_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt14->execute();      
$stmt14->store_result();   
$stmt14->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k);

 while ($stmt14->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">new_monthly_upgrades</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>service_key</td><td>$b</td></tr>
                    <tr><td>group_number</td><td>$c</td></tr>
                    <tr><td>pro_rate_quantity</td><td>$d</td></tr>
                    <tr><td>pro_rate_term</td><td>$e</td></tr> 
                    <tr><td>pro_rate_price</td><td>$f</td></tr>
                    <tr><td>pro_rate_dues</td><td>$g</td></tr> 
                    <tr><td>start_date</td><td>$h</td></tr>
                    <tr><td>end_date</td><td>$i</td></tr>
                    <tr><td>user_id</td><td>$j</td></tr>
                    <tr><td>signup_date</td><td>$k</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt14->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">new_monthly_upgrades</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";


if(!$stmt14->execute())  {
	printf("Error: %s.\n", $stmt14->error);
   }		 
$stmt14->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt15 = $dbMain ->prepare("SELECT * FROM current_monthly_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt15->execute();      
$stmt15->store_result();   
$stmt15->bind_result($a, $b, $c, $d, $e, $f, $g, $h, $i, $j, $k);

 while ($stmt15->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">current_monthly_upgrades</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>service_key</td><td>$b</td></tr>
                    <tr><td>new_members</td><td>$c</td></tr>
                    <tr><td>pro_rate_quantity</td><td>$d</td></tr>
                    <tr><td>pro_rate_term</td><td>$e</td></tr> 
                    <tr><td>pro_rate_price</td><td>$f</td></tr>
                    <tr><td>pro_rate_dues</td><td>$g</td></tr> 
                    <tr><td>start_date</td><td>$h</td></tr>
                    <tr><td>end_date</td><td>$i</td></tr>
                    <tr><td>user_id</td><td>$j</td></tr>
                    <tr><td>signup_date</td><td>$k</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt15->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">current_monthly_upgrades</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt15->execute())  {
	printf("Error: %s.\n", $stmt15->error);
   }		 
$stmt15->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt16 = $dbMain ->prepare("SELECT * FROM current_pif_upgrades WHERE contract_key = '$this->contractKey' ");
$stmt16->execute();      
$stmt16->store_result();   
$stmt16->bind_result($a, $b, $c, $d, $e, $f, $g, $h);

 while ($stmt16->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">current_pif_upgrades</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>service_key</td><td>$b</td></tr>
                    <tr><td>new_members</td><td>$c</td></tr>
                    <tr><td>pro_rate_price</td><td>$d</td></tr>
                    <tr><td>start_date</td><td>$e</td></tr> 
                    <tr><td>end_date</td><td>$f</td></tr>
                    <tr><td>pro_rate_dues</td><td>$g</td></tr> 
                    <tr><td>signup_date</td><td>$h</td></tr>
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt16->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">current_pif_upgrades</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";

if(!$stmt16->execute())  {
	printf("Error: %s.\n", $stmt16->error);
   }		 
$stmt16->close(); 

//----------------------------------------------------------------------------------------------------------------------------------------------------
$stmt17 = $dbMain ->prepare("SELECT * FROM early_renewal_rates WHERE contract_key = '$this->contractKey' ");
$stmt17->execute();      
$stmt17->store_result();   
$stmt17->bind_result($a, $b, $c, $d, $e, $f, $g);

 while ($stmt17->fetch()) {  
        
      $nameVals .= "
                    <tr><th align=\"left\">Table Name:</th><th align=\"left\">early_renewal_rates</th></tr>
                    <tr><td>contract_key</td><td>$a</td></tr>
                    <tr><td>service_key</td><td>$b</td></tr>
                    <tr><td>service_name</td><td>$c</td></tr>
                    <tr><td>unit_renew_rate</td><td>$d</td></tr>
                    <tr><td>group_renew_rate</td><td>$e</td></tr> 
                    <tr><td>start_date</td><td>$f</td></tr>
                    <tr><td>end_date</td><td>$g</td></tr> 
                    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
                    }

if($stmt17->num_rows == 0) {
    $nameVals .= "<tr><th align=\"left\">Table Name:</th><th align=\"left\">early_renewal_rates</th></tr>
                             <tr><td colspan=\"2\">No Records For Contract Id:  $this->contractKey</td></tr>
                             <tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
  }                

$nameVals .= " <tr><td colspan=\"2\" style=\"border-top: 1px; border-bottom: 0px; border-left: 0px; border-right: 0px;
border-style:solid;\">&nbsp;</td></tr>";


if(!$stmt17->execute())  {
	printf("Error: %s.\n", $stmt17->error);
   }		 
$stmt17->close(); 


echo"    
<table>
$nameVals    
</table>";
}

//================================================
function loadReadRecords()  {

$dbMain = $this->dbconnect();

//first we start with pif services
$stmt = $dbMain ->prepare("SELECT contract_key FROM contract_keys WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();   
$stmt->bind_result($contract_key);
$rowCount = $stmt->num_rows;
           
                    while ($stmt->fetch()) {  
                             $this->contractKey = $contract_key; 
                             $this->fieldCount++;
                             $this->readRecords();                           
                             }                                

echo"<br><br>RECORDS READ:  $rowCount";




}
//=================================================


}
//-----------------------------------------------------------------------------------------------------------------

$contractKey = "1538";

$readMems = new readMembers();
$readMems->setContractKey($contractKey);
$readMems->readRecords();








?>