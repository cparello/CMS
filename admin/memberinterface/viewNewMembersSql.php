<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class viewNewMembersSql {

private $locationId = null;
private $contractKey = null;
private $contractDate = null;
private $clientName = null;
private $clientAddress = null;
private $groupType = null;
private $groupName = null;
private $groupNumber = null;
private $newMembersList = null;
private $listingLimit = null;
private $tableHeader = null;
private $clientRows = null;
private $counter = 1;

function setLocationId($locationId) {
      $this->locationId = $locationId;
      }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//--------------------------------------------------------------------------
function loadGroupInfo() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT group_type, group_number, group_name FROM member_groups WHERE  contract_key ='$this->contractKey' ");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($group_type, $group_number, $group_name);   
             $stmt->fetch(); 

   switch($group_type) {          
             case"S":
             $this->groupType = "Single";
             $this->groupName = 'NA';
             break;
             case"F":
             $this->groupType = "Family";
             $this->groupName = 'NA';
             break;
             case"B":
             $this->groupType = "Business";
             $this->groupName = $group_name;
             break;
             case"O":
             $this->groupType = "Organization";
             $this->groupName = $group_name;
             break;
            }              

            
            $this->groupNumber = $group_number;

$stmt->close();

}
//--------------------------------------------------------------------------
function loadTableHeader() {

$this->tableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Contract Id</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Contract Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Client Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Client Address</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Group Type</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Group Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Members</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Edit Member(s)</font></th>
</tr>\n";                   

}
//--------------------------------------------------------------------------
function parseMemberListings() {


  //create color rows
    static $cell_count = 1;
    if($cell_count == 2) {
      $color = "#D8D8D8";
      $cell_count = "";
      }else{
      $color = "#FFFFFF";
      }
     $cell_count = $cell_count + 1;


 $this->clientRows .="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractKey</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->contractDate</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clientName</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clientAddress</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupType</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupName</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->groupNumber</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"memberInfoTwo.php\">
<input type=\"hidden\" name=\"contract_key\" value=\"$this->contractKey\">
<input type=\"submit\" name=\"edit\" value=\"Edit Member(s)\"></form>
</td>
</tr>\n";

$this->counter++;


}
//--------------------------------------------------------------------------
function loadMemberListings()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_key, contract_date, first_name, middle_name, last_name, street, city, state, zip FROM contract_info WHERE  club_id ='$this->locationId' ORDER BY contract_date DESC LIMIT $this->listingLimit");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($contract_key, $contract_date, $first_name, $middle_name, $last_name, $street, $city, $state, $zip);         
             $rowCount = $stmt->num_rows;
             
            if($rowCount != 0) {
            
               while ($stmt->fetch()) {  
                         $this->contractKey = $contract_key;
                         $this->contractDate = date('M j, Y', strtotime($contract_date)); 
                         $this->clientName = "$first_name $middle_name $last_name";
                         $this->clientAddress = "$street $city, $state $zip";
                         $this->clientPhone = $primary_phone;
                         $this->clientEmail = $email;
                         $this->loadGroupInfo();
                         $this->parseMemberListings();
                        }
              }
                        
     $stmt->close();                    
                        
}
//--------------------------------------------------------------------------
function loadListingLimit() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT listings_number FROM new_member_listings WHERE  location_id ='$this->locationId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($listingsNumber);         
             $stmt->fetch(); 
             $rowCount = $stmt->num_rows;
            
             if($rowCount == 0)  {
                $this->listingLimit = '0';             
                }else{
                $this->listingLimit = $listingsNumber;
                }
                            
             $stmt->close(); 

}
//--------------------------------------------------------------------------
function loadNewMembersList() {

$this->loadListingLimit();
$this->loadMemberListings();
$this->loadTableHeader();

$this->newMembersList = "$this->tableHeader $this->clientRows </table>";

}
//--------------------------------------------------------------------------
function getNewMembersList() {
       return($this->newMembersList);
       }




















}

?>