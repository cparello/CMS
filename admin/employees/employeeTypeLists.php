<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  employeeTypeLists {

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
        $stmt = $dbMain ->prepare("SELECT * FROM employee_type WHERE employee_type LIKE '%$searchString%'"); 
        break;
    case 2:
         if($searchString != 0) {
              $stmt = $dbMain ->prepare("SELECT * FROM employee_type WHERE club_id ='$searchString'");
             }else{
              $stmt = $dbMain ->prepare("SELECT * FROM employee_type WHERE club_id !=''");
             }
      break;
    case 3:
        $stmt = $dbMain ->prepare("SELECT * FROM employee_type WHERE type_key != '0' ORDER BY club_id ASC ");
        break;
      }

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($type_key, $employee_type, $employee_description,  $club_id);   
      
$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee Type</font></th>
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
                                
      
 $records .="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$employee_type</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$service_location</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"editEmployeeType.php\">
<input type=\"hidden\" name=\"type_key\" value=\"$type_key\">
<input type=\"hidden\" name=\"employee_type\" value=\"$employee_type\">
<input type=\"hidden\" name=\"service_location\" value=\"$service_location\">
<input type=\"hidden\" name=\"club_id\" value=\"$club_id\">
<input type=\"hidden\" name=\"employee_description\" value=\"$employee_description\">
<input type=\"submit\" name=\"edit\" value=\"Edit\"></form>
</td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" action=\"editEmployeeType.php\" method=\"post\">
<input type=\"hidden\" name=\"type_key\" value=\"$type_key\">
<input type=\"hidden\" name=\"employee_type\" value=\"$employee_type\">
<input type=\"hidden\" name=\"club_id\" value=\"$club_id\">
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