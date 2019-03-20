<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  guestSearch{



function setSearchType($searchType) {
          $this->searchType = $searchType;
          }
function setSearchString($searchString) {
          $this->searchString = $searchString;
          }     


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------------------
function loadRecords()   {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">End Date</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Barcode</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Guest Pass Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Phone</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Email</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Price Quote</font></th>
</tr>\n";    

switch ($this->searchType) {
    case 'N':
        $searchString = "guest_name LIKE '%$this->searchString%'";
    break;
    case 'P':
        $searchString = "guest_phone LIKE '%$this->searchString%'";
    break;
    case 'E':
        $searchString = "guest_email LIKE '%$this->searchString%'";
    break;
}  
         
$i = 1;
$counter = 1;
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT * FROM guest_register WHERE $searchString ORDER BY end_date DESC LIMIT 5");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($barcode, $passId, $duration, $startDate, $endDate, $name, $phone, $email, $int1, $int2, $locationId, $quotedPrice);
while ($stmt->fetch()) { 
                      
                           
                                $passDate = date("F j, Y", strtotime($endDate));
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$locationId'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $serviceLocation = $row[0];
                                  
                                  if($serviceLocation == "")  {
                                     $serviceLocation = 'All Locations';
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
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$passDate</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$barcode</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$serviceLocation</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$phone</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$email</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$quotedPrice</b></font></td>
</tr>\n";
                                                          
                          }
                               //hear is the object for multiple records
                                $drop_table = "$table_header  $records</table>";
                                $this->drop_list = $drop_table;
   
        }     
//======================================================================================

//these are the links for the table list that are more than one item
function getDropList()   {
	return($this->drop_list);
    } 

    


}
//--------------------------------------------------------------------------------------
$searchType = $_REQUEST['searchType'];
$searchString = $_REQUEST['searchString'];
$ajax_switch = $_REQUEST['ajaxSwitch'];

if($ajax_switch == 1) {

$getLists = new guestSearch();
$getLists -> setSearchType($searchType);
$getLists -> setSearchString($searchString);
$getLists -> loadRecords(); 
$resultList = $getLists -> getDropList();

echo"1|$resultList";
exit;

}

?>









