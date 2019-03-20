<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class viewCheckInSql {

private $locationId = null;
private $contractKey = null;
private $attendanceDate = null;
private $memberId = null;
private $memberName = null;
private $memberAddress = null;
private $memberPhone = null;
private $groupType = null;
private $groupName = null;
private $groupNumber = null;
private $checkInList = null;
private $listingLimit = null;
private $tableHeader = null;
private $clientRows = null;
private $accessFlag = null;
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

//--------------------------------------------------------------------------
function loadTableHeader() {

$this->tableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr bgcolor=\"#303030\">
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Check In Date</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Photo</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Id</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Name</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Address</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">Member Phone</font></th>
<th align=\"left\"><font face=\"Arial\" size=\"1\" color=\"white\">View Account</font></th>
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
     
     if($this->accessFlag == 'Y') {
        $color = "#FF3300";
        }

   if($this->contractKey == "NA") {
      $viewAccount = "<font face=\"Arial\" size=\"1\" color=\"black\"><b>NA</b></font>";
      }else{
      $viewAccount ="
      <form style=\"display:inline;\" method=\"post\" action=\"viewAccountInfo.php\">
      <input type=\"hidden\" name=\"contract_key\" value=\"$this->contractKey\">
      <input type=\"hidden\" name=\"member_id\" value=\"$this->memberId\">
      <input type=\"submit\" name=\"edit\" value=\"View Account\">
      <input type=\"hidden\" id=\"whichBackBut\" name=\"whichBackBut\" value=\"2\"/></form>";
      }



 $this->clientRows .="<tr bgcolor=\"$color\">
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->attendanceDate</b></font></td>
<td align=\"left\" valign =\"top\"><img src=\"../memberphotos/$this->memberPhoto\" width=\"50\" height=\"70\"  onError=\"this.src = '../memberphotos/no_photo.jpg'\"></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberId</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberName</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberAddress</b></font></td>
<td align=\"left\" valign =\"top\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->memberPhone</b></font></td>
<td align=\"left\"  valign =\"top\">
$viewAccount
</td>
</tr>\n";

$this->counter++;


}
//--------------------------------------------------------------------------
function loadMemberListing()  {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT contract_key, first_name, middle_name, last_name, street, city, state, zip, primary_phone, member_photo FROM member_info WHERE  member_id ='$this->memberId' ");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($contract_key, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $member_photo);         
             $stmt->fetch();
             
             
             $this->contractKey = $contract_key;
             $this->memberName = "$first_name $middle_name $last_name";
             $this->memberAddress = "$street $city, $state $zip";
             $this->memberPhone = $primary_phone;
             $this->memberPhoto = $member_photo;           
             $this->parseMemberListings();

             $stmt->close();                                            
}
//--------------------------------------------------------------------------
function loadGuestPassListing() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT guest_name, guest_phone FROM guest_register WHERE  bar_code ='$this->memberId' ");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($guest_name, $guest_phone);         
             $stmt->fetch();

             $this->contractKey = 'NA';
             $this->memberName = $guest_name;
             $this->memberAddress = 'GUEST PASS ';
             $this->memberPhone = $guest_phone;
             $this->memberPhoto = "";           
             $this->parseMemberListings();

             $stmt->close(); 
}
//--------------------------------------------------------------------------
function loadAttendanceRecords() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT member_id, attendance_date, access_flag, attendance_type FROM attendance_records WHERE  location_id ='$this->locationId' ORDER BY attendance_date DESC LIMIT $this->listingLimit");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($member_id, $attendance_date, $access_flag, $attendance_type);         
$rowCount = $stmt->num_rows;

           if($rowCount != 0) {
            
               while ($stmt->fetch()) {  
                         $this->memberId = $member_id;
                         $this->attendanceDate = date('M j, Y H:i', strtotime($attendance_date)); 
                         $this->accessFlag = $access_flag;

                          if(($attendance_type == "MA") || ($attendance_type == "SA")) {
                             $this->loadMemberListing();
                             }else{
                             $this->loadGuestPassListing();
                             }
                                                   
                            
                         }

              }
              
$stmt->close(); 

}
//--------------------------------------------------------------------------
function loadListingLimit() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT listings_number FROM check_in_history WHERE  location_id ='$this->locationId'");
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
function loadHistoryList() {

$this->loadListingLimit();
$this->loadAttendanceRecords();
$this->loadTableHeader();

$this->checkInList = "$this->tableHeader $this->clientRows </table>";

}
//--------------------------------------------------------------------------
function getCheckInList() {
       return($this->checkInList);
       }




















}

?>