<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  guestPassList{

private  $listFormat = null;
private  $clubType = null;
private  $passId =null;
private  $locationId = null;
private  $passTitle = null;
private  $termOne = null;
private  $termTwo = null;
private  $termThree = null;
private  $termFour = null;
private  $passMessage = null;
private  $passDate = null;
private  $serviceLocation = null;
private  $confirmationMessage = null;
private  $passTopic = null;
private  $serviceList = null;
private  $serviceKey = null;


function setListFormat($listFormat) {
          $this->listFormat = $listFormat;
          }
function setClubType($clubType) {
          $this->clubType = $clubType;
          }         
function setPassId($passId) {
          $this->passId = $passId;
          }
function setPassTitle($passTitle) {
          $this->passTitle = $passTitle;
          }
function setLocationId($locationId) {
          $this->locationId = $locationId;
          }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//================================================================
function loadServiceList() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_type FROM service_info WHERE service_key='$this->serviceKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceType);
$stmt->fetch();

$this->serviceList .= "$serviceType <br>";


}
//----------------------------------------------------------------------------------------------------------------
function loadServices() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT service_key FROM guest_pass_services WHERE pass_id='$this->passId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($serviceKey);

while ($stmt->fetch()) { 
        $this->serviceKey = $serviceKey;
        $this->loadServiceList();
        }


}
//-----------------------------------------------------------------------------------------------------------------
function parseMemIntList() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT pass_id, pass_title, term_one, term_two, term_three, term_four FROM guest_pass WHERE location_id ='$this->locationId' ORDER BY pass_date  ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passId, $passTitle,  $termOne,  $termTwo, $termThree, $termFour);
$rowCount = $stmt->num_rows;

if($rowCount > 0) {

         $i = 1;
             while ($stmt->fetch()) { 
                      
                       $this->passId = $passId;
                       $this->passTitle = $passTitle;
                       $this->termOne = $termOne;
                       $this->termTwo = $termTwo;
                       $this->termThree = $termThree;
                       $this->termFour = $termFour;
                       
                       if($this->termOne == 0) {
                         $termOneDesc = 'NA';
                         }else{
                         $termOneDesc = "$this->termOne Days  <input type=\"radio\" name=\"duration$i\" value=\"$this->termOne\"/>";
                         }                       
                       if($this->termTwo == 0) {
                         $termTwoDesc = 'NA';
                         }else{
                         $termTwoDesc = "$this->termTwo Days  <input type=\"radio\" name=\"duration$i\" value=\"$this->termTwo\" />";
                         }
                       if($this->termThree == 0) {
                         $termThreeDesc = 'NA';
                         }else{
                         $termThreeDesc = "$this->termThree Days  <input type=\"radio\" name=\"duration$i\" value=\"$this->termThree\" />";
                         }                       
                       if($this->termFour == 0) {
                         $termFourDesc = 'NA';
                         }else{
                         $termFourDesc = "$this->termFour Days  <input type=\"radio\" name=\"duration$i\" value=\"$this->termFour\" />";
                         }                       
                       
                       
                       

                       $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$this->locationId'");
                       $row = mysqli_fetch_array($result, MYSQLI_NUM);
                       $this->serviceLocation = $row[0];
                                  
                                  if($this->serviceLocation == "")  {
                                     $this->serviceLocation = 'All Locations';
                                     }
                                                                          
                                     
                       $this->loadServices();              
                               
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            $counter = $i++;


 $records .="<tr>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$counter</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$this->passTitle</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">
<ul id=\"original$counter\">
			<li>
				<span class=\"head\">View Services</span>
				<div class=\"content\">
                 $this->serviceList
				</div>
			</li>
			</ul>
			</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$termOneDesc</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$termTwoDesc</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$termThreeDesc</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$termFourDesc</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\" class=\"blackTwo\">$this->serviceLocation</td>
<td align=\"left\" valign =\"bottom\" bgcolor=\"$color\"><input type=\"radio\" name=\"pass_type\" class=\"passType\"  data-durationGroup=\"$counter\"  value=\"$this->passId|$counter\"/></td>
</tr>";



                     }

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\" class=\"white\">#</th>
<th align=\"left\" class=\"white\">Guest Pass Title</th>
<th align=\"left\" class=\"white\">Services</th>
<th align=\"left\" class=\"white\">Term One</th>
<th align=\"left\" class=\"white\">Term Two</th>
<th align=\"left\" class=\"white\">Term Three</th>
<th align=\"left\" class=\"white\">Term Four</th>
<th align=\"left\" class=\"white\">Service Location</th>
<th align=\"left\" class=\"white\">Select Pass</th>
</tr>\n";      


 $footer = "
 <tr>
 <td align=\"left\" colspan=\"2\" class=\"buttonPad\">
 <input type=\"button\" name=\"register\" id=\"register\" value=\"Save Registration\" class=\"button99\"/>
 </td>
 <td align=\"left\" colspan=\"2\" class=\"buttonPad\">
  <input type=\"button\" name=\"preview_print\" id=\"preview_print\" value=\"Preview And Print\" class=\"button99\"/>
  <input type=\"hidden\" id=\"term_duration\" name=\"term_duration\" value=\"\">
  <input type=\"hidden\" id=\"save_bit\" name=\"save_bit\" value=\"\">
  <input type=\"hidden\" id=\"bar_code_int\" name=\"bar_code_int\" value=\"\">
 </td>
  <td align=\"left\" colspan=\"3\" class=\"buttonPad\">
 <input type=\"button\" name=\"email_pass\" id=\"email_pass\" value=\"Email Guest Pass\" class=\"button99\"/>
 &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
  <input type=\"button\" name=\"waiver\" id=\"waiver\" value=\"Print Waiver\" class=\"button99\"/>
 </td>
 </tr>
 </table>";                     
 $this->drop_list = "$table_header $records $footer";


   }else{
   $resultList = '0';
   echo"$resultList";
   exit;
   }
   
   
}
//----------------------------------------------------------------------------------------------------------------
function loadRecords() {

  switch($this->listFormat) {          
             case"1":
             $this->parseAdminList();
             break;
             case"2":
             $this->parseMemIntList();
             break;            
            } 

}
//----------------------------------------------------------------------------------------------------------------
function parseAdminList()   {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM guest_pass WHERE pass_id !='0' ORDER BY pass_date  ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($passId, $locationId, $passTitle,  $termOne,  $termTwo, $termThree, $termFour, $passMessage, $passDate, $passTopic);
      
$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Creation Date</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Guest Pass Title</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Guest Pass Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Edit</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Delete</font></th>
</tr>\n";                   
                                    
  //    //if the number of rows are greater than one then we create a list

             $i = 1;
                      while ($stmt->fetch()) { 
                      
                                $this->passId = $passId;
                                $this->locationId = $locationId;
                                $this->passTitle = $passTitle;
                                $this->termOne = $termOne;
                                $this->termTwo = $termTwo;
                                $this->termThree = $termThree;
                                $this->termFour = $termFour;
                                $this->passMessage = $passMessage;
                                $this->passDate = date("F j, Y", strtotime($passDate));
                                $this->passTopic = $passTopic;
                                
                                if($this->termTwo == 0) {
                                   $this->termTwo = "";
                                   }
                                if($this->termThree == 0) {
                                   $this->termThree = "";
                                   }                      
                                if($this->termFour == 0) {
                                   $this->termFour = "";
                                   }
                      
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$this->locationId'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $this->serviceLocation = $row[0];
                                  
                                  if($this->serviceLocation == "")  {
                                     $this->serviceLocation = 'All Locations';
                                     }
                               
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            $counter = $i++;
   
   
   
      
 $records .="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->passDate</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->passTitle</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->serviceLocation</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"viewGuestPasses.php\">
<input type=\"hidden\" name=\"pass_id\" value=\"$this->passId\">
<input type=\"hidden\" name=\"location_id\" value=\"$this->locationId\">
<input type=\"hidden\" name=\"title\" value=\"$this->passTitle\">
<input type=\"hidden\" name=\"term_one\" value=\"$this->termOne\">
<input type=\"hidden\" name=\"term_two\" value=\"$this->termTwo\">
<input type=\"hidden\" name=\"term_three\" value=\"$this->termThree\">
<input type=\"hidden\" name=\"term_four\" value=\"$this->termFour\">
<input type=\"hidden\" name=\"pass_desc\" value=\"$this->passMessage\">
<input type=\"hidden\" name=\"pass_topic\" value=\"$this->passTopic\">
<input type=\"submit\" name=\"edit\" value=\"Edit\"></form>
</td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" action=\"viewGuestPasses.php\" method=\"post\">
<input type=\"hidden\" name=\"pass_id\" value=\"$this->passId\">
<input type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"return confirmDelete();\"></form>
</td>
</tr>\n";
                                                          
                          }
                               //hear is the object for multiple records
                                $drop_table = "$table_header  $records";
                                $this->drop_list = $drop_table;
   
        }     
//======================================================================================

//these are the links for the table list that are more than one item
function getDropList()   {
	return($this->drop_list);
    } 
function getConfirmationMessage()  {
    return($this->confirmationMessage);
    }
    


}
//--------------------------------------------------------------------------------------
$service_location = $_REQUEST['service_location'];
$ajax_switch = $_REQUEST['ajax_switch'];

if($ajax_switch == 1) {

$list_format = 2;
$getLists = new guestPassList();
$getLists -> setListFormat($list_format);
$getLists -> setLocationId($service_location);
$getLists -> loadRecords(); 
$resultList = $getLists -> getDropList();

echo"$resultList";
exit;

}

?>









