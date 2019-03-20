<?php
session_start();


class  launchSalesForm{

function setServiceName($serviceName) {
          $this->serviceNameArray = $serviceName;
          }
function setServiceQuantity($serviceQuantity) {
          $this->serviceQuantityArray = $serviceQuantity;
          }
function  setServiceNumberMemberships($number_memberships){
          $this->numberMembershipsArray = $number_memberships;
          }
function  setServiceCost($service_cost){
          $this->serviceCostArray = $service_cost;
          }
//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}
//=======================================================================================================
function loadTermsConditions()   {
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT contract_terms, liability_terms FROM contract_defaults WHERE contract_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($contract_term, $liability_terms);
$stmt->fetch();
$stmt->close();

$this->terms = "$contract_term<br><br><u>Liability Term:</u>$liability_terms";

}       
//----------------------------------------------------------------------------------------------------
function loadSalesForm() {
    $this->summaryHtml = "<tr class=\"tabHead\">
            <td colspan=\"3\" class=\"oBtext\">
            <b>Purchase Summary</b>
            </td>
            <td colspan=\"3\" class=\"oBtext\">
            Quantity
            </td>
            <td colspan=\"3\" class=\"oBtext\">
            Price
            </td>
            <td colspan=\"3\" class=\"oBtext\">
            Service Length
            </td>
            </tr>";
            
$dbMain = $this->dbconnect(); 


$this->loadTermsConditions();
include"loadWebsitePreferences.php";
include "loadStuff.php"; 

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$stmt = $dbMain ->prepare("SELECT cycle_day, past_day FROM billing_cycle WHERE cycle_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cycle_day, $past_day);   
$stmt->fetch();   
$stmt->close();

$stmt = $dbMain ->prepare("SELECT rejection_fee, late_fee  FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($rejection_fee, $late_fee);   
$stmt->fetch();   
$stmt->close();

$nameTempArr = explode('-',$this->serviceNameArray);
$name = $nameTempArr[0];

$stmt = $dbMain ->prepare("SELECT service_term FROM service_cost JOIN service_info ON service_cost.service_key = service_info.service_key WHERE service_type = '$name' AND service_quantity = '$this->serviceQuantityArray'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_term);   
$stmt->fetch();   
$stmt->close();

switch($service_term){
    case'W':
        if ($this->serviceQuantityArray == 1){
            $textTerm = "Week";
        }else{
            $textTerm = "Weeks";
        }
    break;
    case'D':
        if ($this->serviceQuantityArray == 1){
            $textTerm = "Day";
        }else{
            $textTerm = "Days";
        }
    break;
    case'Y':
        if ($this->serviceQuantityArray == 1){
            $textTerm = "Year";
        }else{
            $textTerm = "Years";
        }
    break;
    
}

$this->monthlyBillingBool = 0;
$this->monthlyDues = 0;
//echo "$this->serviceNameArray<br>$this->serviceQuantityArray<br>";

$arrayPointer = 1;
$counter = 0;

$this->summaryHtml .= "
            <tr>
            <td colspan=\"3\" class=\"sumtext\">
            <b>$this->serviceNameArray</b>
            </td>
            <td colspan=\"3\" class=\"sumtext\">
            <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1</b>
            </td>
            <td colspan=\"3\" class=\"sumtext\">
            <b>$$this->serviceCostArray</b>
            </td>
            <td colspan=\"3\" class=\"sumtext\">
            <bb style=\"padding-left: 10px;\"><b>$this->serviceQuantityArray $textTerm</b>
            </td>
            </tr>";
            
$this->saleArray = "$this->serviceNameArray,1,$this->serviceCostArray,$this->serviceQuantityArray";
 
//echo "vsdvsd $this->totalCost";
$this->totalCost = sprintf("%.2f", $this->serviceCostArray);

//$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT service1, service2, service3, service4, service5, servicePhoto1, servicePhoto2, servicePhoto3, servicePhoto4, servicePhoto5, gear1, gear2, gear3, gear4, gear5, gearPhoto1, gearPhoto2, gearPhoto3, gearPhoto4, gearPhoto5 FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($this->service1, $this->service2, $this->service3, $this->service4, $this->service5, $this->servicePhoto1, $this->servicePhoto2, $this->servicePhoto3, $this->servicePhoto4, $this->servicePhoto5, $this->gear1, $this->gear2, $this->gear3, $this->gear4, $this->gear5, $this->gearPhoto1, $this->gearPhoto2, $this->gearPhoto3, $this->gearPhoto4, $this->gearPhoto5);
$stmt->fetch();
$stmt->close();

$service1Buff = explode('-',$this->service1);
$this->service1 = trim($service1Buff[0]);

$service2Buff = explode('-',$this->service2);
$this->service2 = trim($service2Buff[0]);

$service3Buff = explode('-',$this->service3);
$this->service3 = trim($service3Buff[0]);

$service4Buff = explode('-',$this->service4);
$this->service4 = trim($service4Buff[0]);

$service5Buff = explode('-',$this->service5);
$this->service5 = trim($service5Buff[0]);

$stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$this->gear1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retailCost1, $clubInvMarker1);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$this->gear2'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retailCost2, $clubInvMarker2);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$this->gear3'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retailCost3, $clubInvMarker3);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$this->gear4'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retailCost4, $clubInvMarker4);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT retail_cost, club_inv_marker FROM club_inventory WHERE product_desc = '$this->gear5'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($retailCost5, $clubInvMarker5);
$stmt->fetch();
$stmt->close();

$gearItem1 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/gear/$this->gearPhoto1\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->gear1</u><br>$$retailCost1</b>
  </div>
  <div class=\"radButtons\">
  <div id=\"buttonArea6\">
      <center><input type='button' value='Add' id='add6'  class='add6 buttonPasses$middleButtons buttonSize'></center>
      </div>
      <input type=\"hidden\" name=\"gearAdd6\" id=\"gearAdd6\" value=\"$clubInvMarker1|$retailCost1|$this->gear1\"/>
  </div>"; 
  
  
  
//echo "test2";

$gearItem2 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/gear/$this->gearPhoto2\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->gear2</u><br>$$retailCost2</b>
  </div>
  <div class=\"radButtons\">
  <div id=\"buttonArea7\">
      <center><input type='button' value='Add' id='add7'  class='add7 buttonPasses$middleButtons buttonSize'></center>
      </div>
      <input type=\"hidden\" name=\"gearAdd7\" id=\"gearAdd7\" value=\"$clubInvMarker2|$retailCost2|$this->gear2\"/>
  </div>"; 
  
 $gearItem3 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/gear/$this->gearPhoto3\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->gear3</u><br>$$retailCost3</b>
  </div>
  <div class=\"radButtons\">
  <div id=\"buttonArea8\">
      <center><input type='button' value='Add' id='add8'  class='add8 buttonPasses$middleButtons buttonSize'></center>
      </div>
      <input type=\"hidden\" name=\"gearAdd8\" id=\"gearAdd8\" value=\"$clubInvMarker3|$retailCost3|$this->gear3\"/>
  </div>"; 
  
  $gearItem4 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/gear/$this->gearPhoto4\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->gear4</u><br>$$retailCost4</b>
  </div>
  <div class=\"radButtons\">
  <div id=\"buttonArea9\">
      <center><input type='button' value='Add' id='add9'  class='add9 buttonPasses$middleButtons buttonSize'></center>
      </div>
      <input type=\"hidden\" name=\"gearAdd9\" id=\"gearAdd9\" value=\"$clubInvMarker4|$retailCost4|$this->gear4\"/>
  </div>"; 
  
  $gearItem5 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/gear/$this->gearPhoto5\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->gear5</u><br>$$retailCost5</b>
  </div>
  <div class=\"radButtons\">
  <div id=\"buttonArea10\">
      <center><input type='button' value='Add' id='add10'  class='add10 buttonPasses$middleButtons buttonSize'></center>
      </div>
      <input type=\"hidden\" name=\"gearAdd10\" id=\"gearAdd10\" value=\"$clubInvMarker5|$retailCost5|$this->gear5\"/>
  </div>"; 


$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->service1' ORDER BY service_cost ASC
");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
    while($stmt->fetch()){
        $serviceKeyArray1[$counter] = $service_key;
        $serviceCostArray1[$counter] = $service_cost;
        $serviceQuantityArray1[$counter] = $service_quantity;
        if ($service_quantity > 1){
            $buff = "s";
        }else{
            $buff = "";
        }
        switch($service_term){
            case 'C':
            if ($buff == 's'){
                $buff = 'es';
            }
            $serviceTermArray1[$counter] = "Class$buff";
            break;
            case 'D':
            $serviceTermArray1[$counter] = "Day$buff";
            break;
            case 'W':
            $serviceTermArray1[$counter] = "Week$buff";
            break;
            case 'M':
            $serviceTermArray1[$counter] = "Month$buff";
            break;
            case 'Y':
            $serviceTermArray1[$counter] = "Year$buff";
            break;
        }
        $counter++;
    }
$stmt->close();
$servicePrice1a = $serviceCostArray1[0];
$servicePrice1b = $serviceCostArray1[1];
$servicePrice1c = $serviceCostArray1[2];
$servicePrice1d = $serviceCostArray1[3];
$serviceTerm1a = $serviceTermArray1[0];
$serviceTerm1b = $serviceTermArray1[1];
$serviceTerm1c = $serviceTermArray1[2];
$serviceTerm1d = $serviceTermArray1[3];
$serviceQuantity1a = $serviceQuantityArray1[0];
$serviceQuantity1b = $serviceQuantityArray1[1];
$serviceQuantity1c = $serviceQuantityArray1[2];
$serviceQuantity1d = $serviceQuantityArray1[3];
$serviceKey1 = $serviceKeyArray1[0];

$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->service2' ORDER BY service_cost ASC
");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
    while($stmt->fetch()){
        $serviceKeyArray2[$counter] = $service_key;
        $serviceCostArray2[$counter] = $service_cost;
        $serviceQuantityArray2[$counter] = $service_quantity;
        if ($service_quantity > 1){
            $buff = "s";
        }else{
            $buff = "";
        }
        switch($service_term){
            case 'C':
            if ($buff == 's'){
                $buff = 'es';
            }
            $serviceTermArray2[$counter] = "Class$buff";
            break;
            case 'D':
            $serviceTermArray2[$counter] = "Day$buff";
            break;
            case 'W':
            $serviceTermArray2[$counter] = "Week$buff";
            break;
            case 'M':
            $serviceTermArray2[$counter] = "Month$buff";
            break;
            case 'Y':
            $serviceTermArray2[$counter] = "Year$buff";
            break;
        }
        $counter++;
    }
$stmt->close();
$servicePrice2a = $serviceCostArray2[0];
$servicePrice2b = $serviceCostArray2[1];
$servicePrice2c = $serviceCostArray2[2];
$servicePrice2d = $serviceCostArray2[3];
$serviceTerm2a = $serviceTermArray2[0];
$serviceTerm2b = $serviceTermArray2[1];
$serviceTerm2c = $serviceTermArray2[2];
$serviceTerm2d = $serviceTermArray2[3];
$serviceQuantity2a = $serviceQuantityArray2[0];
$serviceQuantity2b = $serviceQuantityArray2[1];
$serviceQuantity2c = $serviceQuantityArray2[2];
$serviceQuantity2d = $serviceQuantityArray2[3];
$serviceKey2 = $serviceKeyArray2[0];

$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->service3' ORDER BY service_cost ASC
");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
    while($stmt->fetch()){
        $serviceKeyArray3[$counter] = $service_key;
        $serviceCostArray3[$counter] = $service_cost;
        $serviceQuantityArray3[$counter] = $service_quantity;
        if ($service_quantity > 1){
            $buff = "s";
        }else{
            $buff = "";
        }
        switch($service_term){
            case 'C':
            if ($buff == 's'){
                $buff = 'es';
            }
            $serviceTermArray3[$counter] = "Class$buff";
            break;
            case 'D':
            $serviceTermArray3[$counter] = "Day$buff";
            break;
            case 'W':
            $serviceTermArray3[$counter] = "Week$buff";
            break;
            case 'M':
            $serviceTermArray3[$counter] = "Month$buff";
            break;
            case 'Y':
            $serviceTermArray3[$counter] = "Year$buff";
            break;
        }
        $counter++;
    }
$stmt->close();
$servicePrice3a = $serviceCostArray3[0];
$servicePrice3b = $serviceCostArray3[1];
$servicePrice3c = $serviceCostArray3[2];
$servicePrice3d = $serviceCostArray3[3];
$serviceTerm3a = $serviceTermArray3[0];
$serviceTerm3b = $serviceTermArray3[1];
$serviceTerm3c = $serviceTermArray3[2];
$serviceTerm3d = $serviceTermArray3[3];
$serviceQuantity3a = $serviceQuantityArray3[0];
$serviceQuantity3b = $serviceQuantityArray3[1];
$serviceQuantity3c = $serviceQuantityArray3[2];
$serviceQuantity3d = $serviceQuantityArray3[3];
$serviceKey3 = $serviceKeyArray3[0];

$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->service4' ORDER BY service_cost ASC
");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
    while($stmt->fetch()){
        $serviceKeyArray4[$counter] = $service_key;
        $serviceCostArray4[$counter] = $service_cost;
        $serviceQuantityArray4[$counter] = $service_quantity;
        if ($service_quantity > 1){
            $buff = "s";
        }else{
            $buff = "";
        }
        switch($service_term){
            case 'C':
            if ($buff == 's'){
                $buff = 'es';
            }
            $serviceTermArray4[$counter] = "Class$buff";
            break;
            case 'D':
            $serviceTermArray4[$counter] = "Day$buff";
            break;
            case 'W':
            $serviceTermArray4[$counter] = "Week$buff";
            break;
            case 'M':
            $serviceTermArray4[$counter] = "Month$buff";
            break;
            case 'Y':
            $serviceTermArray4[$counter] = "Year$buff";
            break;
        }
        $counter++;
    }
$stmt->close();
$servicePrice4a = $serviceCostArray4[0];
$servicePrice4b = $serviceCostArray4[1];
$servicePrice4c = $serviceCostArray4[2];
$servicePrice4d = $serviceCostArray4[3];
$serviceTerm4a = $serviceTermArray4[0];
$serviceTerm4b = $serviceTermArray4[1];
$serviceTerm4c = $serviceTermArray4[2];
$serviceTerm4d = $serviceTermArray4[3];
$serviceQuantity4a = $serviceQuantityArray4[0];
$serviceQuantity4b = $serviceQuantityArray4[1];
$serviceQuantity4c = $serviceQuantityArray4[2];
$serviceQuantity4d = $serviceQuantityArray4[3];
$serviceKey4 = $serviceKeyArray4[0];

$counter = 0;
$stmt = $dbMain-> prepare("SELECT service_info.service_key, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->service5' ORDER BY service_cost ASC
");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_key, $service_cost, $service_term, $service_quantity);
    while($stmt->fetch()){
        $serviceKeyArray5[$counter] = $service_key;
        $serviceCostArray5[$counter] = $service_cost;
        $serviceQuantityArray5[$counter] = $service_quantity;
        if ($service_quantity > 1){
            $buff = "s";
        }else{
            $buff = "";
        }
        switch($service_term){
            case 'C':
            if ($buff == 's'){
                $buff = 'es';
            }
            $serviceTermArray5[$counter] = "Class$buff";
            break;
            case 'D':
            $serviceTermArray5[$counter] = "Day$buff";
            break;
            case 'W':
            $serviceTermArray5[$counter] = "Week$buff";
            break;
            case 'M':
            $serviceTermArray5[$counter] = "Month$buff";
            break;
            case 'Y':
            $serviceTermArray5[$counter] = "Year$buff";
            break;
        }
        $counter++;
    }
$stmt->close();
$servicePrice5a = $serviceCostArray5[0];
$servicePrice5b = $serviceCostArray5[1];
$servicePrice5c = $serviceCostArray5[2];
$servicePrice5d = $serviceCostArray5[3];
$serviceTerm5a = $serviceTermArray5[0];
$serviceTerm5b = $serviceTermArray5[1];
$serviceTerm5c = $serviceTermArray5[2];
$serviceTerm5d = $serviceTermArray5[3];
$serviceQuantity5a = $serviceQuantityArray5[0];
$serviceQuantity5b = $serviceQuantityArray5[1];
$serviceQuantity5c = $serviceQuantityArray5[2];
$serviceQuantity5d = $serviceQuantityArray5[3];
$serviceKey5 = $serviceKeyArray5[0];

$marketingItem1 = "<div class=\"new-faceout p13nimp\"  id=\"purchase_B0050SYYTK\" data-asin=\"B0050SYYTK\" data-ref=\"pd_sim_vg_1\">
    
 <div class=\"product-image\">
                       <img src=\"pictures/servicePhotos/$this->servicePhoto1\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->service1</u></b>
  </div>
  <div class=\"radButtons\">
  <br>
      <b><input type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1a|$serviceTerm1a|$servicePrice1a|$this->service1\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity1a $serviceTerm1a $$servicePrice1a</span></input><br>
      <input type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1b|$serviceTerm1b|$servicePrice1b|$this->service1\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity1b $serviceTerm1b $$servicePrice1b</span></input><br>
      <input type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1c|$serviceTerm1c|$servicePrice1c|$this->service1\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity1c $serviceTerm1c $$servicePrice1c</span></input><br>
      <input type=\"radio\" name=\"serviceOptions1\" value=\"$serviceKey1|$serviceQuantity1d|$serviceTerm1d|$servicePrice1d|$this->service1\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity1d $serviceTerm1d $$servicePrice1d</span></input></b><br><br>
      <div id=\"buttonArea1\">
      <center><input type='button' value='Add' id='add1' class='add1 buttonPasses$middleButtons buttonSize'></center>
      </div>
      </div>
  </div>"; 
  
  
  
//echo "test2";

$marketingItem2 =  "<div class=\"new-faceout p13nimp\"  id=\"purchase_B006ZPAYMI\" data-asin=\"B006ZPAYMI\" data-ref=\"pd_sim_vg_2\">
    <div class=\"product-image\">
                       <img src=\"pictures/servicePhotos/$this->servicePhoto2\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->service2</u></b>
  </div>
   <div class=\"radButtons\">
   <br>
      <b><input type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2a|$serviceTerm2a|$servicePrice2a|$this->service2\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity2a $serviceTerm2a $$servicePrice2a</span></input><br>
      <input type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2b|$serviceTerm2b|$servicePrice2b|$this->service2\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity2b $serviceTerm2b $$servicePrice2b</span></input><br>
      <input type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2c|$serviceTerm2c|$servicePrice2c|$this->service2\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity2c $serviceTerm2c $$servicePrice2c</span></input><br>
      <input type=\"radio\" name=\"serviceOptions2\" value=\"$serviceKey2|$serviceQuantity2d|$serviceTerm2d|$servicePrice2d|$this->service2\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity2d $serviceTerm2d $$servicePrice2d</span></input></b><br><br>
      <div id=\"buttonArea2\">
      <center><input type='button' value='Add' id='add2' class='add2 buttonPasses$middleButtons buttonSize'></center>
      </div>
  </div>";
  
  $marketingItem3 =  " <div class=\"new-faceout p13nimp\"  id=\"purchase_B004FEJ8ZA\" data-asin=\"B004FEJ8ZA\" data-ref=\"pd_sim_vg_3\">
    

<div class=\"product-image\">
                       <img src=\"pictures/servicePhotos/$this->servicePhoto3\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->service3</u></b>

  </div>
   <div class=\"radButtons\">
   <br>
      <b><input type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3a|$serviceTerm3a|$servicePrice3a|$this->service3\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity3a $serviceTerm3a $$servicePrice3a</span></input><br>
      <input type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3b|$serviceTerm3b|$servicePrice3b|$this->service3\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity3b $serviceTerm3b $$servicePrice3b</span></input><br>
      <input type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3c|$serviceTerm3c|$servicePrice3c|$this->service3\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity3c $serviceTerm3c $$servicePrice3c</span></input><br>
      <input type=\"radio\" name=\"serviceOptions3\" value=\"$serviceKey3|$serviceQuantity3d|$serviceTerm3d|$servicePrice3d|$this->service3\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity3d $serviceTerm3d $$servicePrice3d</span></input></b><br><br>
      <div id=\"buttonArea3\">
      <center><input type='button' value='Add' id='add3' class='add3 buttonPasses$middleButtons buttonSize'></center>
      </div>
  </div>";
  
  $marketingItem4 =  " <div class=\"new-faceout p13nimp\"  id=\"purchase_B005EYG6K0\" data-asin=\"B005EYG6K0\" data-ref=\"pd_sim_vg_4\">
                        <div class=\"product-image\">
                        <img src=\"pictures/servicePhotos/$this->servicePhoto4\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                        </div>
                    <b><u>$this->service4</u></b>

  </div>
   <div class=\"radButtons\">
   <br>
      <b><input type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4a|$serviceTerm4a|$servicePrice4a|$this->service4\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity4a $serviceTerm4a $$servicePrice4a</span></input><br>
      <input type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4b|$serviceTerm4b|$servicePrice4b|$this->service4\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity4b $serviceTerm4b $$servicePrice4b</span></input><br>
      <input type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4c|$serviceTerm4c|$servicePrice4c|$this->service4\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity4c $serviceTerm4c $$servicePrice4c</span></input><br>
      <input type=\"radio\" name=\"serviceOptions4\" value=\"$serviceKey4|$serviceQuantity4d|$serviceTerm4d|$servicePrice4d|$this->service4\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity4d $serviceTerm4d $$servicePrice4d</span></input></b><br><br>
      <div id=\"buttonArea4\">
      <center><input type='button' value='Add' id='add4' class='add4 buttonPasses$middleButtons buttonSize'></center>
      </div>
  </div>";
  
  $marketingItem5 =  " <div class=\"new-faceout p13nimp\"  id=\"purchase_B003UT9XJM\" data-asin=\"B003UT9XJM\" data-ref=\"pd_sim_vg_6\">
 <div class=\"product-image\">
                       <img src=\"pictures/servicePhotos/$this->servicePhoto5\" width=\"100\" alt=\"\" height=\"100\" border=\"0\" />
                    </div>
                    <b><u>$this->service5</u></b>
  </div>
   <div class=\"radButtons\">
   <br>
      <b><input type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5a|$serviceTerm5a|$servicePrice5a|$this->service5\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity5a $serviceTerm5a $$servicePrice5a</span></input><br>
      <input type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5b|$serviceTerm5b|$servicePrice5b|$this->service5\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity5b $serviceTerm5b $$servicePrice5b</span></input><br>
      <input type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5c|$serviceTerm5c|$servicePrice5c|$this->service5\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity5c $serviceTerm5c $$servicePrice5c</span></input><br>
      <input type=\"radio\" name=\"serviceOptions5\" value=\"$serviceKey5|$serviceQuantity5d|$serviceTerm5d|$servicePrice5d|$this->service5\"><span style=\"color: #$textColor;\">&nbsp;$serviceQuantity5d $serviceTerm5d $$servicePrice5d</span></input></b><br><br>
      <div id=\"buttonArea5\">
      <center><input type='button' value='Add' id='add5' class='add5 buttonPasses$middleButtons buttonSize'></center>
      </div>
  </div>";
  
//$this->createGroupInfoForm();
include"webTemplates/renewalFormTemplate.php";

/*$stmt = $dbMain ->prepare("SELECT process_fee_single_two FROM fees WHERE fee_num = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($pif_process_fee);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT service_cost FROM service_cost JOIN service_info ON service_info.service_key = service_cost.service_key WHERE service_type = '$this->serviceName' AND service_quantity = '$this->serviceQuantity'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($service_cost);
$stmt->fetch();
$stmt->close();

$totPrice = sprintf("%.2f", $service_cost+$pif_process_fee);

$bit = 1;
$passBack = "$bit|$service_cost|$totPrice";
return $passBack;*/

}
//======================================================================================


    
}
//--------------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$number_memberships = $_REQUEST['number_memberships'];
$service_name = $_REQUEST['service_name'];
$service_quantity = $_REQUEST['service_quantity'];
$service_cost = $_REQUEST['service_cost'];
//var_dump($number_memberships);
//var_dump($service_name);
//var_dump($service_quantity);
//var_dump($service_cost);
if($ajax_switch == 1) {

$loadPricing = new launchSalesForm();
$loadPricing-> setServiceName($service_name);
$loadPricing-> setServiceQuantity($service_quantity);
$loadPricing-> setServiceNumberMemberships($number_memberships);
$loadPricing-> setServiceCost($service_cost);
$loadPricing-> loadSalesForm();
}





?>