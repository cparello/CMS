<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  groupDrops{

private  $groupType = null;


function setGroupType($groupType) {
        $this->groupType = $groupType;
         }
 

function loadGroupMenu() {

if($this->groupType == null) {
          $choose_group = "
          <option value>Select Group Type</option>\n
          <option value=\"S\">Single</option>\n
          <option value=\"F\">Family</option>\n
          <option value=\"B\">Business</option>\n
          <option value=\"O\">Organization</option>\n";   
           }else{           
           switch($this->groupType) {          
             case"S":
             $group_name = "Single";
             break;
             case"F":
             $group_name = "Family";
             break;
             case"B":
             $group_name = "Business";
             break;
             case"O":
             $group_name = "Organization";
             break;
            }
          $choose_group = "
          <option value=\"$this->groupType\" selected>$group_name</option>\n
          <option value=\"S\">Single</option>\n
          <option value=\"F\">Family</option>\n
          <option value=\"B\">Business</option>\n
          <option value=\"O\">Organization</option>\n";                  
           }
          
return "$choose_group";            

}





}

?>