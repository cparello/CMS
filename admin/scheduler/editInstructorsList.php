<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  editInstructorsList {

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
<th align=\"left\" class=\"listHeader\">Photo</th>
<th align=\"left\" class=\"listHeader\">Upload Photo</th>
<th align=\"left\" class=\"listHeader\">Instructor Name</th>
<th align=\"left\" class=\"listHeader\">Instructor Description</th>
<th align=\"left\" class=\"listHeader\">Edit Profile</th>
<th align=\"left\" class=\"listHeader\">Delete Profile</th>
</tr>\n"; 
$tableFooter = "</table>";

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT instructor_id, instructor_name, instructor_photo, instructor_description FROM instructor_info WHERE type_id= '$this->typeId' ORDER BY instructor_name  ASC");         
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($instructorId, $instructorName, $instructorPhoto, $instructorDescription);   
                                                       
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
                                            
                                            
  $image = "<img src=\"../instructorphotos/$instructorPhoto\" border=\"0\"\ width=\"50\" height=\"70\">";                                          
      
 $records .="<tr class=\"$color\">
<td align=\"left\" valign =\"top\" class=\"black\">$counter</td>
<td align=\"left\" valign =\"top\" class=\"black\">$image</td>
<td align=\"left\" valign =\"top\" class=\"black\">
<form style=\"display:inline;\" method=\"post\" action=\"editInstructorsList2.php\" enctype=\"multipart/form-data\" onSubmit=\"return checkData(this);\">
<input name=\"imagefile\" type=\"file\" id=\"imagefile\" value= \"\"/></td>
<td align=\"left\" valign =\"top\" class=\"black\"><input name=\"instructor_name\" type=\"text\" id=\"instructor_name\" value=\"$instructorName\" size=\"20\" maxlength=\"30\"/></td>
<td align=\"left\" valign =\"top\" class=\"black\">
<textarea cols=\"26\" rows=\"4\" name=\"instructor_description\" id=\"instructor_description\">$instructorDescription</textarea>
</td>
<td align=\"left\"  valign =\"top\" class=\"black\">
<input type=\"hidden\" name=\"instructor_id\" value=\"$instructorId\">
<input type=\"hidden\" name=\"type_id\" value=\"$this->typeId\">
<input type=\"hidden\" name=\"type_name\" value=\"$this->typeName\">
<input type=\"submit\" name=\"edit\" class=\"edit\" value=\"Edit\">
</form>
</td>
<td align=\"left\"  valign =\"top\" class=\"black\">
<form style=\"display:inline;\" action=\"editInstructorsList2.php\" method=\"post\" onSubmit=\"return confirmDelete(this);\">
<input type=\"hidden\" name=\"instructor_id\" value=\"$instructorId\">
<input type=\"hidden\" name=\"instructor_name\" value=\"$instructorName\">
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