<?php
//this loops through the service type drops and adds services to the employees who are in sales

//check to see if this is not null and then parse
if(isset($_POST['service_types1'])) {
        //loop through the check boxes
         foreach($_POST['service_types1'] as $value1) {
               $valueArray = explode("|", $value1);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }

//check to see if this is not null and then parse
if(isset($_POST['service_types2'])) {
        //loop through the check boxes
         foreach($_POST['service_types2'] as $value2) {
               $valueArray = explode("|", $value2);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }


//check to see if this is not null and then parse
if(isset($_POST['service_types3'])) {
        //loop through the drop down lists
         foreach($_POST['service_types3'] as $value3) {
               $valueArray = explode("|", $value3);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }


//check to see if this is not null and then parse
if(isset($_POST['service_types4'])) {
        //loop through the check boxes
         foreach($_POST['service_types4'] as $value4) {
               $valueArray = explode("|", $value4);
               $club_id = $valueArray[0];
               $service_key = $valueArray[1];     
             
               $employee_info->setServiceKey($service_key);
               $employee_info->setClubId($club_id);
               $employee_info->commissionSave();               
              }              
  }
?>
