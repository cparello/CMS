<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(8);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";

$emp_user_id = $_REQUEST['emp_user_id'];
$emp_name = $_REQUEST['emp_name'];
$comp_type1 = $_REQUEST['comp_type1'];
//this function saves all of the info if the employee is a sales person
if(isset($_POST['save1']))  {

include "employeeSql.php";


//set the new sql object to add the comission for the employee
$commission = new employeeSql;
$commission -> setUserId($emp_user_id);
$commission ->setEmpFullName($emp_name);

//this deletes  choices
if(isset($_POST['delete']))  {

//loop through the check boxes
        foreach ($_POST['delete'] as $val) {
                     $commission -> deleteEmployeeCommissions($val);
                      }  
}



//--------------------------------------------------------------------------------------------
//takes care of updating feilds
if(isset($_POST['serve'])) {

//loop through the check boxes
foreach ($_POST['serve'] as $value) {

               $valueArray = explode("|", $value);
               $salt = $valueArray[0];
               $club_id = $valueArray[1];
               $service_key = $valueArray[2];
               
               //set the club id and the service key
               $commission ->setClubId($club_id);
               $commission ->setServiceKey($service_key);
               $com_key = $commission ->getComKey();


     for ($i = 0, $t = count($comp_type1); $i < $t; $i++) {      
           $select = $_POST["comp_type$salt"][$i];
           $fee = $_POST["comp$salt"][$i];
           
           //filter out non numeric charachters
           $fee = trim($fee);
           $fee = preg_replace("/[^0-9 .]+/", "" ,$fee); 
                     
           
       //echo"$com_key<br>";
          switch($select) {          
                       case"F":
                       $commission ->setFlatRate($select);
                       $commission ->setFlatRateAmount($fee);
                       $commission ->setPercent(null);
                       $commission ->setPercentAmount(0);                       
                       break;
                       case"P":
                       $commission ->setPercent($select);
                       $commission ->setPercentAmount($fee);
                       $commission ->setFlatRate(null);
                       $commission ->setFlatRateAmount(0.00);                       
                       break;
                       case"":
                       $commission ->setPercent(null);
                       $commission ->setPercentAmount(0);
                       $commission ->setFlatRate(null);
                       $commission ->setFlatRateAmount(0.00); 
                       break;
                       }                     
                        $commission ->updateEmployeeCommissions($com_key); 
                         
                $com_key++;         
                         
           }
 
     }

}//end serve
  
$confirmation = $commission->getConfirmation();

}


//=================================================================
//if set to continue spit out the service types

$save_button ="
<tr>
<td colspan=\"7\">
&nbsp;
</td>
</tr>
<tr>
<td align=\"left\" id=\"sub1\" colspan=\"7\">
<input  type=\"submit\" name=\"save1\" value=\"Update Services For $emp_name\" />
&nbsp;&nbsp;<input type=\"reset\" value=\"Reset\"/>
<input name=\"emp_user_id\" type=\"hidden\" id=\"marker\" value=\"$emp_user_id\" />
<input name=\"emp_name\" type=\"hidden\" id=\"empn\" value=\"$emp_name\" />
</td>
</tr>
</form>";

//now we filter through the sales types to get the listings
include "employeeServiceLists2.php";

$emp_service_lists = new employeeServiceLists();
$emp_service_lists ->setUserId($emp_user_id);
$string_list = $emp_service_lists ->loadServiceLists();

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtEmployeeServiceLists.js\"></script>";

include "../templates/employeeServiceListsTemplate.php";
exit;
?>