<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  salesNameDrops {

private  $clubId = null;
private  $groupType = null;
private  $serviceType = null;
private  $serviceTypeOptions = null;
private  $salesType = null;

private  $serviceKey = null;
private  $serviceName = null;
private  $nameDrops = null;
private  $allSelect = null;


function setClubId($clubId) {
       $this->clubId = $clubId;
       }

function setGroupType($groupType) {
       $this->groupType = $groupType;
       }
       
function setServiceType($serviceType) {
       $this->serviceType = $serviceType;
       }       
       
function setServiceTypeOptions($serviceTypeOptions) {
       $this->serviceTypeOptions = $serviceTypeOptions;
       }       

function setSalesType($salesType) {
       $this->salesType = $salesType;
       }          
       
            
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//---------------------------------------------------------------------------------
function loadNameDrops() {

if(($this->clubId == '0') || ($this->clubId == 'I')) {
  $sqlClub = "club_id IS NOT NULL";
  }else{
  $sqlClub = "club_id = '$this->clubId'";
  }

if($this->groupType == '0') {
  $sqlGroup = "";
  }else{
  $sqlGroup = "AND group_type = '$this->groupType'";
  }

//takes care of service type sql
if($this->serviceType == '0') {
  $sqlServiceType = "";
  }else{
  $sqlServiceType = "AND service_type = '$this->serviceType'";
  }

    //takes care of service type options sql
    switch ($this->serviceTypeOptions) {
      case "AA":
      $sqlServiceOptions = "AND service_term != '0'";
      break;
      case "CL":
      $sqlServiceOptions = "AND service_term='C'";
      break; 
      case "SC":
      $sqlServiceOptions = "AND service_term='SC'";
      break;            
      case "FT":
      $sqlServiceOptions =  "AND service_term !='M' AND service_term !='PM' AND service_term != 'C' AND term_type='T'";
      break;   
      case "MT":
      $sqlServiceOptions = "AND service_term='M' AND term_type='T'";
      break;
      case "MO":
      $sqlServiceOptions = "AND service_term ='M' AND term_type='O'";
      break;
      case "AP":
      $sqlServiceOptions = "AND service_term != 'M' AND service_term !='PM'";
      break;      
      case "AM":
      $sqlServiceOptions = "AND service_term = 'M'";
      break;            
      }
        
      
    //takes care of sales type options sql
    switch ($this->salesType) {
      case "0":
      $sqlSalesType = "AND sales_key != '0'";
      break;
      case "APF":
      $sqlSalesType = "AND service_type = 'P'";
      break;
      case "APM":
      $sqlSalesType = "AND service_type = 'E'";
      break;      
      case "SN":
      $sqlSalesType = "AND new_sale = 'Y'";
      break;
      case "SNP":
      $sqlSalesType = "AND new_sale = 'Y' AND service_type = 'P'";
      break;
      case "SNM":
      $sqlSalesType = "AND new_sale = 'Y' AND service_type = 'E'";
      break;      
      case "SU":
      $sqlSalesType = "AND upgrade = 'Y'";
      
         if($this->serviceTypeOptions == 'MT') {
          $sqlServiceOptions = "AND service_term='PM' AND term_type='T'";
            }
         if($this->serviceTypeOptions == 'MO') {
          $sqlServiceOptions = "AND service_term='PM' AND term_type='O'";
            }            
                        
      break;       
      case "SUP":
      $sqlSalesType = "AND upgrade = 'Y' AND service_type = 'P'";
      break;       
      case "SUM":
      $sqlSalesType = "AND upgrade = 'Y' AND service_type = 'E'";
      
         if($this->serviceTypeOptions == 'MT') {
          $sqlServiceOptions = "AND service_term='PM' AND term_type='T'";
            }
         if($this->serviceTypeOptions == 'MO') {
          $sqlServiceOptions = "AND service_term='PM' AND term_type='O'";
            }           
      
      break;          
      case "SRP":
      $sqlSalesType = "AND renewal= 'Y' AND early_renewal = 'N'";
      break;           
      case "ERP":
      $sqlSalesType = "AND early_renewal = 'Y'";
      break;        
      case "ARP":
      $sqlSalesType = "AND renewal= 'Y'";
      break;           
    }
      
 //checks for internet sale     
   if($this->clubId == 'I') {
     $sqlOnline = "AND internet = 'Y'";
     }else{
     $sqlOnline = "";
     }
  
 $sqlWhere ="$sqlClub $sqlGroup $sqlServiceType $sqlServiceOptions $sqlSalesType $sqlOnline";
 
 //echo"$sqlWhere";
//  exit;
 
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT DISTINCT service_key, service_name  FROM sales_info WHERE $sqlWhere ");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($serviceKey, $serviceName);
   $rowCount = $stmt->num_rows;
  
if($rowCount != 0)  {  
  
   while ($stmt->fetch()) {
            $nameOptions .=  "<option value=\"$serviceKey\">$serviceName</option>\n";         
           }
 
              $dropHeader = "<option value>Select Sales Name</option>\n"; 
   
           if($rowCount >1) {
              $allSelect = "<option value=\"0\">All Sales Names</option>\n";
              }

   $this->nameDrops = "$dropHeader $allSelect $nameOptions";
 
 
   }else{
    $this->nameDrops = "0";   
   }
 
   if(!$stmt->execute())  {
	printf("Error: %s.\n  sales_info table distinct", $stmt->error);
      }
   
$stmt->close();    


}
//---------------------------------------------------------------------------------
function getNameDrops() {
           return($this->nameDrops);
           }




}
//---------------------------------------------------------------------------------
$ajax_switch = $_REQUEST['ajax_switch'];
$club_id = $_REQUEST['club_id'];
$group_type = $_REQUEST['group_type'];
$service_type = $_REQUEST['service_type'];
$service_type_options = $_REQUEST['service_type_options'];
$sales_type = $_REQUEST['sales_type'];
              
                  

if($ajax_switch == 1) {

$name = new salesNameDrops();
$name-> setClubId($club_id);
$name-> setGroupType($group_type);
$name-> setServiceType($service_type);
$name-> setServiceTypeOptions($service_type_options);
$name-> setSalesType($sales_type);
$name-> loadNameDrops();
$name_drops = $name-> getNameDrops();

echo"$name_drops";
exit;

 
}