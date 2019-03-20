<?php
include_once('php/connection.php');

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    .row {
        text-align: center;
    }
    .billInfo{
            position: relative;
            border: 5px solid #000;
            padding: 30px;
            margin: 30px;
            height: 400px;
            }
    .payInfo{
            position: relative;
            border: 5px solid #000;
            padding: 30px;
            margin: 30px;
            height: 500px;
            width: 400px;
            }
    .memInfo{
            position: relative;
            border: 5px solid #000;
            padding: 30px;
            margin: 30px;
            height: 700px;
            width: 700px;
            }
    .classInfo{
            position: relative;
            border: 5px solid #000;
            padding: 30px;
            margin: 30px;
            height: 700px;
            width: 400px;
    }
    
    </style>
    <script type="text/javascript" src="js/jqueryNew.js"></script>
    <script src="js/myAccountUpdate.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/updateContactPrefs.js"></script>
</head>
<body>
    <?php include_once('inc/header.php'); 
    
     $contractKey = $_SESSION['userContractKey'];
  
    $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone, email, dob, MAX(contract_date), club_id, host_type FROM contract_info WHERE contract_key = '$contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone, $email, $dob, $date, $club_id, $host_type);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT member_id FROM member_info WHERE contract_key = '$contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($member_id);
    $stmt->fetch();
    $stmt->close();
    
    $dob = date('m/d/Y',strtotime($dob));
    
    $stmt = $dbMain ->prepare("SELECT monthly_billing_type, billing_amount, cycle_date FROM monthly_payments WHERE contract_key = '$contractKey' LIMIT 1");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($monthly_billing_type, $billing_amount, $cycle_date);
    $stmt->fetch();
    $stmt->close();
    
    
    if($monthly_billing_type == "CR"){
        $ccBill = "selected";
        $achBill = "";
        $msg = "";
        
         $yearDrop = date("Y");
        for($i=0;$i<=10;$i++){
            $year = date("Y");
            $year = $year + $i;
            $yearDrop .= "<option value=\"$year\" >$year</option>";
        }
        
        $stmt = $dbMain ->prepare("SELECT card_number, card_exp_date, card_type FROM credit_info WHERE contract_key = '$contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($card_number, $card_exp_date, $card_type);
        $stmt->fetch();
        $stmt->close();
        
        $month = date('m',strtotime($card_exp_date));
        $monthTxt = date('F',strtotime($card_exp_date));
        $year = date('Y',strtotime($card_exp_date));
       // echo "test $monthly_billing_type $ccForm";
        //echo $ccForm;
        
       $ccForm = "
            <li class=\"title\">Credit Card Payment</li>
            <select  name=\"card_type\" id=\"card_type\">
                <option value=\"$card_type\"  selected>$card_type</option>
                <option value=\"Visa\" >Visa</option>
                <option value=\"MC\" >MasterCard</option>
                <option value=\"Amex\" >American Express</option>
                <option value=\"Disc\" >Discover</option>
            </select>
            <input name=\"card_number\" type=\"text\" id=\"card_number\" value=\"$card_number\" placeholder=\"Card Number\">
                    <label>Exp. Month
                    <select name=\"card_month\" id=\"card_month\">
                        <option value=\"$month\"  selected >$monthTxt</option>
                        <option value=\"01\" >January</option>
                        <option value=\"02\" >February</option>
                        <option value=\"03\" >March</option>
                        <option value=\"04\" >April</option>
                        <option value=\"05\" >May</option>
                        <option value=\"06\" >June</option>
                        <option value=\"07\" >July</option>
                        <option value=\"08\" >August</option>
                        <option value=\"09\" >September</option>
                        <option value=\"10\" >October</option>
                        <option value=\"11\" >November</option>
                        <option value=\"12\" >December</option>
                    </select>
                    </label>
                    <label>Exp. Year
                    <select name=\"card_year\" id=\"card_year\">
                         <option value=\"$year\" selected>$year</option>
                       $yearDrop
                    </select>
                    </label>
                </label>
                ";
                
                 $stmt = $dbMain ->prepare("SELECT account_type, account_number, routing_number, bank_name FROM banking_info WHERE contract_key = '$contractKey'");
                $stmt->execute();      
                $stmt->store_result();      
                $stmt->bind_result($account_type, $account_number, $routing_number, $bank_name);
                $stmt->fetch();
                $stmt->close();
            
    }elseif($monthly_billing_type == "BA"){
        $ccBill = "";
        $achBill = "selected";
        $msg = "";
        
        $stmt = $dbMain ->prepare("SELECT account_type, account_number, routing_number, bank_name FROM banking_info WHERE contract_key = '$contractKey'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($account_type, $account_number, $routing_number, $bank_name);
        $stmt->fetch();
        $stmt->close();
        
        $achForm = "
            <li class=\"title\">Bank Payment</li>
            <input  name=\"bank_name\" type=\"text\" id=\"bank_name\"  value=\"$bank_name\" placeholder=\"Bank Name\">
			<select name=\"account_type\" id=\"account_type\">
                <option value=\"$account_type\">$account_type</option>
                <option value=\"C\" >Personal Checking</option>
                <option value=\"B\" >Business Checking</option>
                <option value=\"S\" >Savings</option>
            </select>
			<input name=\"account_num\" type=\"text\" id=\"account_num\" value=\"$account_number\" placeholder=\"Account Number\">
			<input name=\"aba_num\" type=\"text\" id=\"aba_num\" value=\"$routing_number\" placeholder=\"Routing Number\">";
            
            $stmt = $dbMain ->prepare("SELECT card_number, card_exp_date, card_type FROM credit_info WHERE contract_key = '$contractKey'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($card_number, $card_exp_date, $card_type);
            $stmt->fetch();
            $stmt->close();
            
            $month = date('m',strtotime($card_exp_date));
            $monthTxt = date('F',strtotime($card_exp_date));
            $year = date('Y',strtotime($card_exp_date));
    }else{
        $msg = "You have no billing option setup";
    }
    
     $customerBillingDay = date('d',strtotime($cycle_date));
    
    $dobLi = date('m-d-Y',strtotime($dobLi));
    
    $membershipInfo = "
                        <li class=\"title\">Monthly Memberships</li>
                        <table align=\"right\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
                        <tbody>
                        <tr>
                            <td>
                            Service Name
                            </td>
                            <td>
                            Monthly Dues
                            </td>
                            <td>
                            End Date
                            </td>
                            </tr>";
    
    $stmt22 = $dbMain ->prepare("SELECT DISTINCT service_key, service_name, monthly_dues, end_date, service_id FROM monthly_services WHERE contract_key = '$contractKey'");
    $stmt22->execute();      
    $stmt22->store_result();      
    $stmt22->bind_result($service_key, $service_name, $monthly_dues, $end_date, $service_id);
    $rowCount1 = $stmt22->num_rows;
    while($stmt22->fetch()){
        $stmt = $dbMain ->prepare("SELECT account_status FROM account_status WHERE contract_key = '$contractKey' AND service_key = '$service_key' AND service_id = '$service_id'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($account_status);
            $stmt->fetch();
            $stmt->close();
       
        if($account_status == 'CU'){
            $endDate = date('m-d-y',strtotime($end_date));
            $membershipInfo .= "<tr>
                            <td>
                            $service_name
                            </td>
                            <td>
                            $monthly_dues
                            </td>
                            <td>
                            $endDate
                            </td>
                            </tr>";
        }
        
    }
    $membershipInfo .= "</tbody></table>Your monthly payment is $$billing_amount.";
    $stmt22->close();
    if($rowCount1 == 0){
        $membershipInfo .= "You have no Monthly Services.</tbody></table>";
    }
    
    $pifMembershipInfo = "<li class=\"title\">PIF Memberships</li>
                        <table align=\"right\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
                        <tbody>
                        <tr>
                            <td>
                            Service Name
                            </td>
                            <td>
                            End Date
                            </td>
                            </tr>";
    $stmt99 = $dbMain ->prepare("SELECT DISTINCT service_key FROM paid_full_services WHERE contract_key = '$contractKey'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($service_key);
    $rowCount2 = $stmt99->num_rows;
    while($stmt99->fetch()){
        $classCount = "0";
        $class_count = "0";
        $SMclass_count = "0";
        $SMclass_count2 = 0;
        $stmt = $dbMain ->prepare("SELECT service_name, MAX(end_date) FROM paid_full_services WHERE contract_key = '$contractKey' AND service_key = '$service_key'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_name, $end_date);
        $stmt->fetch();
        $stmt->close();
        $endBuff = $end_date;
        
        $endDate = date('m-d-y',strtotime($end_date));
        if($endDate == "12-31-69" OR $endBuff == '0000-00-00 00:00:00'){
            
            $stmt = $dbMain ->prepare("SELECT SUM(class_count) FROM member_class_count WHERE contract_key = '$contractKey' AND service_key = '$service_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($class_count);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT SUM(class_count) FROM schedular_member_class_count WHERE sm_contract_key = '$contractKey' AND service_key = '$service_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($SMclass_count);
            $stmt->fetch();
            $stmt->close();
            
            $stmt = $dbMain ->prepare("SELECT SUM(class_count) FROM schedular_member_class_count WHERE sm_member_id = '$member_id' AND service_key = '$service_key'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($SMclass_count2);
            $stmt->fetch();
            $stmt->close();
            
            $classCount = $SMclass_count + $class_count + $SMclass_count2;
            $endDate = "$classCount left";
        }
        $nowSecs = time();
        $expSecs = strtotime($end_date);
        
        if($nowSecs <= $expSecs OR $endBuff == '0000-00-00 00:00:00'){
            $pifMembershipInfo .= "<tr>
                            <td>
                            $service_name
                            </td>
                            <td>
                            $endDate
                            </td>
                            </tr>";
                            
        }
        
        $service_key = "";
        
    }
    $pifMembershipInfo .= "</tbody></table>";
    $stmt99->close();
     if($rowCount2 == 0){
        $pifMembershipInfo .= "You have no Paid In Full Services.</tbody></table>";
    }
    
    $stmt = $dbMain ->prepare("SELECT member_id FROM member_info WHERE contract_key = '$contractKey'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($barcode);
    $stmt->fetch();
    $stmt->close();
    
    
    $now = time();
    $nowDate = date('h:i:s m-d-Y',$now);
    $classInfo = "<li class=\"title\">Scheduled Classes</li>
                        <table align=\"right\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
                        <tbody>
                        <tr>
                            <td>
                            Class Name
                            </td>
                            <td>
                            Class Date
                            </td>
                            <td>
                            Club
                            </td>
                            </tr>";
    $stmt99 = $dbMain ->prepare("SELECT bundle_id, club_id, class_date_time FROM class_bookings WHERE member_id = '$barcode' AND class_date_time > '$nowDate'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($bundle_id, $club_id, $class_date_time);
    $rowCount3 = $stmt99->num_rows;
    while($stmt99->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT bundle_name FROM bundle_type WHERE bundle_id = '$bundle_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($bundle_name);
        $stmt->fetch();
        $stmt->close();
    
        $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($club_name);
        $stmt->fetch();
        $stmt->close();
        
        $class_date_time = date('h:i m-d-y',strtotime($class_date_time));
        $classInfo .= "<tr>
                            <td>
                            $bundle_name
                            </td>
                            <td>
                            $class_date_time
                            </td>
                            <td>
                            $club_name
                            </td>
                            </tr>";
        $bundle_id = "";
        $club_id = "";
        $class_date_time = "";
        
    }
    $classInfo .= "</tbody></table>";
    $stmt99->close();
    if($rowCount3 == 0){
        $classInfo .= "You have no Scheduled Classes.</tbody></table>";
    }
    $yearDrop = date('Y');
    
    
 $stmt = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($do_not_call_cell, $do_not_call_home, $do_not_email, $do_not_text, $do_not_mail, $prefered_contact_method);
 $stmt->fetch();
 $stmt->close();  
 
 if($do_not_call_cell == "Y"){
    $dncc = "checked";
 }
 if($do_not_call_home == "Y"){
    $dnch = "checked";
 }
 if($do_not_email == "Y"){
    $dne = "checked";
 }
 if($do_not_text == "Y"){
    $dnt = "checked";
 }
 if($do_not_mail == "Y"){
    $dnm = "checked";
 }

 switch ($prefered_contact_method){
    case 'home_phone':
        $selected = "<option selected value=\"home_phone\">Home Phone</option>";
    break;
    case 'cell_phone':
        $selected = "<option selected value=\"cell_phone\">Cell Phone</option>";
    break;
    case 'email':
        $selected = "<option selected value=\"email\">Email</option>";
    break;
    case 'text':
        $selected = "<option selected value=\"text\">Text</option>";
    break;
    case 'mail':
        $selected = "<option selected value=\"mail\">Mail</option>";
    break;
    default:
        $selected = "<option selected value=\"none\">None</option>";
    break;
 }
    ?>
    
    <div id="cover">
        <h1>My Account</h1>
    </div>
    
      <div class="row">
        <div class="small-12 large-12">
        <ul class="pricing-table">
        <li class="title">Member Billing Information</li>
        
        </div>
        <div class="small-12 large-4 columns">
        <input name="first_name[]" type="text" id="first_name" value="<?php  echo $first_name ?>"  placeholder="First Name (REQUIRED)"  required>
        <input name="street_address[]" type="text" id="street_address" value="<?php  echo $street ?>"  placeholder="Street Address(REQUIRED)"  required>
        <input name="zip_code[]" type="text" id="zip_code" value="<?php  echo $zip ?>" placeholder="Zip Code(REQUIRED)">
        <input  name="email[]" type="text" id="email" value="<?php  echo $email ?>"  placeholder="Email(REQUIRED)"  required>
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="middle_name[]" type="text" id="middle_name" value="<?php  echo $middle_name ?>"  placeholder="Middle Name (optional)">
        <input name="city[]" type="text" id="city" value="<?php  echo $city ?>"   placeholder="City(REQUIRED)" required>
        <input name="home_phone[]" type="text" id="home_phone" value="<?php  echo $primary_phone ?>"  placeholder="Phone(REQUIRED)" required>
        <input  name="dob[]" type="text" id="dob" value="<?php  echo $dob ?>"  placeholder="Date of Birth (MM/DD/YYYY)(REQUIRED)" required> 
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="last_name[]" type="text" id="last_name" value="<?php  echo $last_name ?>"  placeholder="Last Name(REQUIRED)" required>
        <select  name="state[]" id="state" required>
        <option value="<?php  echo $state  ?>" selected=""><?php  echo $state  ?></option>
                <option value="">Select State(REQUIRED)</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">Wash. D.C.</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">So. Carolina</option>
                <option value="SD">So. Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
            
             <span id="msgBox"></span>
             <button class="button" id="updateInfo" type="submit"><span>Update</span></button>
             <input type="hidden" id="contract_key" name="contract_key" value="<?php echo $contractKey ?>">
             <input type="hidden" id="yearDrop" name="yearDrop" value="<?php echo $yearDrop ?>">
             <input type="hidden" id="card_typePre" name="card_typePre" value="<?php echo $card_type ?>">
             <input type="hidden" id="card_numPre" name="card_numPre" value="<?php echo $card_number ?>">
             <input type="hidden" id="card_monthPre" name="card_monthPre" value="<?php echo $month ?>">
             <input type="hidden" id="card_yearPre" name="card_yearPre" value="<?php echo $year ?>">
             <input type="hidden" id="card_mtxtPre" name="card_mtxtPre" value="<?php echo $monthTxt ?>">
             <input type="hidden" id="bank_namePre" name="bank_namePre" value="<?php echo $bank_name ?>">
             <input type="hidden" id="bank_typePre" name="bank_typePre" value="<?php echo $account_type ?>">
             <input type="hidden" id="account_numberPre" name="account_numberPre" value="<?php echo $account_number ?>">
             <input type="hidden" id="routing_numberPre" name="routing_numberPre" value="<?php echo $routing_number ?>">
             <input type="hidden" id="month_bool" name="month_bool" value="<?php echo $rowCount1 ?>">
            </ul>
        </div>
      </div>  
       <div class="row">
      <table align="middle" border="0" cellpadding="0" cellspacing="4" width="100%">
<tbody>
  <tr>
    <h3><Center>Contact Preferences</Center></h3>
  </tr>
  <tr>
   <th>Do not call home</th>
   <th>Do not call cell</th>
   <th>Do not email</th>
   <th>Do not mail</th>
   <th>Do not text message</th>
   <th>Preferred Contact Method</th>
  </tr>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="no_call_home" id="no_call_home"  value="1" <?php  echo $dnch ?>></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="no_call_cell" id="no_call_cell"  <?php  echo $dncc  ?>value="2"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="no_email" id="no_email"  <?php  echo $dne  ?>value="3"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="no_mail" id="no_mail"  <?php  echo $dnm  ?>value="4"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type="checkbox" name="no_text" id="no_text"  <?php  echo $dnt  ?>value="4"/></td>
   <td>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <select name="pref_contact" id="pref_contact">
       <?php  echo $selected ?>
        <option value="home_phone">Home Phone</option>
        <option value="cell_phone">Cell Phone</option>
        <option value="email">Email</option>
        <option value="text">Text</option>
        <option value="email">Email</option>
        <option value="mail">Mail</option>
        <option value="none">None</option>
      </select> 
   </td>
  </tr>
  <tr>
  <td><span id="homeBox"></span></td>
  <td><span id="cellBox"></span></td>
  <td><span id="emailBox"></span></td>
  <td><span id="mailBox"></span></td>
  <td><span id="textBox"></span></td>
  <td><span id="prefBox"></span></td>
  </tr>
  </tbody>
</table>
      </div>    
      <div class="row">
         <div class="small-12 large-4 columns">
         <ul class="pricing-table">
         <li class="title">Payment Method</li>
         
         <select  name="billType" id="billType" required>
                <option value="NO">Select Billing Type(REQUIRED)</option>
                <option value="CR" <?php echo $ccBill ?>>Credit Card</option>
                <option value="BA" <?php echo $achBill ?>>Bank</option>
            </select>
            </ul>
         <ul class="pricing-table">
            <span id="payForms"><?php echo $ccForm ?>
            <?php echo $achForm ?>
            <?php echo $msg ?></span>
            <span id="msgBox2"></span>
            <button class="button" id="updatePay" type="submit"><span>Update</span></button>  
            </ul>
            </div>
                <div class="small-12 large-4 columns">
                    <ul class="pricing-table">
                    <?php echo $membershipInfo ?>
                    </ul>
                </div>
                    <div class="small-12 large-4 columns">
                    <ul class="pricing-table">
                    <?php echo $pifMembershipInfo ?>
                    </ul>
                    </div>
                <div class="small-12 large-4 columns">
                 <ul class="pricing-table">
                    <?php echo $classInfo ?>
                    </ul>
                </div>
      </div>        
     
    
    
    <?php include_once('inc/footer.php'); ?>
    
  
</body>
</html>
