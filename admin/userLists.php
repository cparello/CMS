<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  userLists {

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
require"dbConnect.php";
return $dbMain;
}




function loadRecords()   {

$dbMain = $this->dbconnect();

$searchType = $this->search_type; 
$searchString = $this->search_string; 

switch ($searchType) {
    case 1:
        $stmt = $dbMain ->prepare("SELECT user_id FROM access_level WHERE last_name LIKE '$searchString%'"); 
        break;
    case 2:
        $stmt = $dbMain ->prepare("SELECT user_id FROM admin_passwords WHERE user_name ='$searchString'");
        break;
    case 3:
        $stmt = $dbMain ->prepare("SELECT user_id FROM admin_passwords WHERE user_id != '0'  AND user_name != '' ");
        break;
      }

      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($user_id);   
      
$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">First Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Last Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">User Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Password</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Edit</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Delete</font></th>
</tr>\n";                   
                                    
  //    //if the number of rows are greater than one then we create a list
//      if($stmt ->num_rows >1) {
       $i = 1;
                      while ($stmt->fetch()) {                            
                                 $result  =  $dbMain -> query( "SELECT access_level.file_perm,  access_level.first_name,  access_level.last_name, admin_passwords.user_name, admin_passwords.pass_word FROM admin_passwords, access_level WHERE admin_passwords.user_id ='$user_id' AND admin_passwords.user_id = access_level.user_id"); 
                                 $row = mysqli_fetch_array($result, MYSQLI_NUM);
                                 $access_level = $row[0];
                                 $first_name = $row[1];
                                 $last_name = $row[2];
                                 $user_name = $row[3];
                                 $pass_word = $row[4];
                               
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
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$first_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$last_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$user_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$pass_word</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"editUser.php\">
<input type=\"hidden\" name=\"userId\" value=\"$user_id\">
<input type=\"hidden\" name=\"accesslevel\" value=\"$access_level\">
<input type=\"hidden\" name=\"first_name\" value=\"$first_name\">
<input type=\"hidden\" name=\"last_name\" value=\"$last_name\">
<input type=\"hidden\" name=\"username\" value=\"$user_name\">
<input type=\"hidden\" name=\"password\" value=\"$pass_word\">
<input type=\"submit\" name=\"edit\" value=\"Edit\"></form>
</td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" action=\"editUser.php\" method=\"post\">
<input type=\"hidden\" name=\"userId\" value=\"$user_id\">
<input type=\"hidden\" name=\"first_name\" value=\"$first_name\">
<input type=\"hidden\" name=\"last_name\" value=\"$last_name\">
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