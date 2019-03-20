<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  serviceLists {

     private  $searchString;
     private  $searchType;

function setSearchString($searchString) {
                 $this->search_string = $searchString;
              }

function setSearchType($searchType) {
                 $this->search_type = $searchType;
              }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}




function loadRecords()   {

$dbMain = $this->dbconnect();

$searchType = $this->search_type; 
$searchString = $this->search_string; 

switch ($searchType) {
    case 1:
        $stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE service_type LIKE '%$searchString%' ORDER BY club_id, service_type  ASC"); 
        break;
    case 2:
         if($searchString != 0) {
              $stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE club_id ='$searchString' ORDER BY club_id, service_type  ASC");
             }else{
              $stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE club_id !='' ORDER BY club_id, service_type  ASC");
             }
      break;
     case 3:      
              $stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE group_type='$searchString' ORDER BY club_id, service_type  ASC");
      break;       
    case 4:
        $stmt = $dbMain ->prepare("SELECT * FROM service_info WHERE service_key != '0' ORDER BY club_id, service_type  ASC");
        break;
            }

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($service_key,$service_type,$service_desc,$club_id,$group_type,$bundle_class);   
      
     
      
      
$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Service Name</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Group Type</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Service Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Edit</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Delete</font></th>
</tr>\n";                   
                                    
  //    //if the number of rows are greater than one then we create a list
//      if($stmt ->num_rows >1) {
             $i = 1;
                      while ($stmt->fetch()) {                            
                                 $result  =  $dbMain -> query("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $service_location = $row[0];
                                  
                                  if($club_id == "0")  {
                                     $service_location = 'All Locations';
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
   
   switch($group_type) {          
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
   
   
   
      
 $records .="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_type</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$group_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_location</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"editService.php\">
<input type=\"hidden\" name=\"service_key\" value=\"$service_key\">
<input type=\"hidden\" name=\"service_type\" value=\"$service_type\">
<input type=\"hidden\" name=\"bundle\" value=\"$bundle_class\">
<input type=\"hidden\" name=\"service_location\" value=\"$service_location\">
<input type=\"hidden\" name=\"club_id\" value=\"$club_id\">
<input type=\"hidden\" name=\"service_desc\" value=\"$service_desc\">
<input type=\"hidden\" name=\"group_type\" value=\"$group_type\">
<input type=\"submit\" name=\"edit\" value=\"Edit\"></form>
</td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" action=\"editService.php\" method=\"post\">
<input type=\"hidden\" name=\"service_key\" value=\"$service_key\">
<input type=\"hidden\" name=\"service_type\" value=\"$service_type\">
<input type=\"hidden\" name=\"service_location\" value=\"$service_location\">
<input type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"return confirmDelete();\"></form>
</td>
</tr>\n";
                                                          
                          }
                               //hear is the object for multiple records
                                $drop_table = "$table_header  $records";
                                $this->drop_list = $drop_table;
   
        }     


//these are the links for the table list that are more than one item
   function getDropList()   {
		return($this->drop_list);
    	} 


}