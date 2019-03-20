<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  editRoomList {

     private  $typeId = null;
     private  $dropList = null;
     private  $typeName = null;

function setTypeId($typeId) {
           $this->typeId = $typeId;
          }

function setTypeName($typeName) {
           $this->typeName = $typeName;
          }
          
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//------------------------------------------------------------------------------------------------
function loadRecords()   {

$tableHeader = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\" class=\"listHeader\">#</th>
<th align=\"left\" class=\"listHeader\">Room Name</th>
<th align=\"left\" class=\"listHeader\">Edit Name</th>
<th align=\"left\" class=\"listHeader\">Delete Name</th>
</tr>\n"; 
$tableFooter = "</table>";

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT room_id, room_name FROM room_names WHERE type_id= '$this->typeId' ORDER BY room_name  ASC");         
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($roomId, $roomName);   
                                                       
             $i = 1;
                      while ($stmt->fetch()) {                            
                               
                                 //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "even";
                                           $cell_count = "";
                                   }else{
                                           $color = "odd";
                                   }
                                            $cell_count = $cell_count + 1;
                               
                                            $counter = $i++;
                                           
                                                                                 
      
 $records .="<tr class=\"$color\">
<td align=\"left\" valign =\"top\" class=\"black\">$counter</td>
<td align=\"left\" valign =\"top\" class=\"black\">
<form style=\"display:inline;\" method=\"post\" action=\"editRoomList2.php\"  onSubmit=\"return checkData(this);\">
<input name=\"room_name\" type=\"text\" id=\"room_name\" value=\"$roomName\" size=\"30\" maxlength=\"40\"/></td>
</td>
<td align=\"left\"  valign =\"top\" class=\"black\">
<input type=\"hidden\" name=\"room_id\" value=\"$roomId\">
<input type=\"hidden\" name=\"type_id\" value=\"$this->typeId\">
<input type=\"hidden\" name=\"type_name\" value=\"$this->typeName\">
<input type=\"submit\" name=\"edit\" class=\"edit\" value=\"Edit\">
</form>
</td>
<td align=\"left\"  valign =\"top\" class=\"black\">
<form style=\"display:inline;\" action=\"editRoomList2.php\" method=\"post\" onSubmit=\"return confirmDelete(this);\">
<input type=\"hidden\" name=\"room_id\" value=\"$roomId\">
<input type=\"hidden\" name=\"room_name\" value=\"$roomName\">
<input type=\"hidden\" name=\"type_id\" value=\"$this->typeId\">
<input type=\"hidden\" name=\"type_name\" value=\"$this->typeName\">
<input type=\"submit\" name=\"delete\" value=\"Delete\"></form>
</td>
</tr>\n";
                                                          
                          }
                               //hear is the object for multiple records
                               
                                $this->dropList = "$tableHeader  $records $tableFooter";
                                
   
        }     
//-------------------------------------------------------------------------------------------------------------------------

//these are the links for the table list that are more than one item
   function getDropList()   {
		return($this->dropList);
    	} 


}
?>