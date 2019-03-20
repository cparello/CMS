<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  employeeLists {

     private  $searchString;
     private  $searchType;
     private  $typeKey;
     private  $userArray;
     private  $userIdNumbers;
     private  $dropDescription;
     private  $headerName;
     private  $userName;

function setSearchString($searchString) {
                 $this->searchString = $searchString;
              }

function setSearchType($searchType) {
                 $this->searchType = $searchType;
              }

function setTypeKey($typeKey) {
                 $this->typeKey = $typeKey;
              }

function setUserArray($userArray) {
                 $this->userArray = $userArray;
              }
              
function setUserIdNumbers($userIdNumbers) {
                 $this->userIdNumbers = $userIdNumbers;
              }        

function setDropDescription($dropDescription) {
                 $this->dropDescription = $dropDescription;
              }

function setHeaderName($headerName) {
                $this->headerName = $headerName;
              }

function setUserName($userName) {
                $this->userName = $userName;
              }



//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//-----------------------------------------------------------------------------------------------------------------------------






//------------------------------------------------------------------------------------------------------------------------------
function getServiceButton()   {

$dbMain = $this->dbconnect();
$user_id = $this->userId;
$emp_fname = $this->empFname;
$emp_mname = $this->empMname;
$emp_lname = $this->empLname;

         $result1 = $dbMain ->prepare("SELECT type_key  FROM basic_compensation WHERE user_id = '$user_id'");
         $result1->execute();      
         $result1->store_result(); 
         $result1->bind_result($type_key);      
                                  while ($result1 ->fetch()) {        
              
                                              if($type_key != null)  {                                                 
                                                          $result2 = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$type_key'");
                                                          $result2->execute();      
                                                          $result2->store_result(); 
                                                          $result2->bind_result($employee_type, $club_id);    
                                                          $result2 ->fetch();
                                                           //echo"$employee_type $type_key";
                                                                   if (preg_match("/sales/i", $employee_type)) {
                                                                   $formOne = 1;
                                                                   }
                                                                  
                                                                   
              
                                                 }//end if not null
              
                                             }//end while loop



            if($formOne == null) {
                   $button = "<font face=\"Arial\" size=\"1\" color=\"black\"><b>N/A</b></font>";
               }else{
                   $button = "<form style=\"display:inline;\" method=\"post\" action=\"parseEmployeeServiceLists.php\"><input type=\"hidden\" name=\"emp_user_id\" value=\"$user_id\"><input type=\"hidden\" name=\"emp_name\" value=\"$emp_fname $emp_mname $emp_lname\"><input type=\"submit\" name=\"continue\" value=\"Edit\"></form>";                                      
               }

return "$button";

}
//----------------------------------------------------------------------------------------------------------------
function getUserName() {

$user_id = $this->userId;
$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT user_name FROM admin_passwords WHERE user_id='$user_id'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($user_name); 
             $stmt->fetch();
              
 $this->userName = "<a href=\"mailto:$user_name\">$user_name</a>"; 

}
//-----------------------------------------------------------------------------------------------------------------
function formatList()  {

 $dropDescription = $this->dropDescription;

 $user_id = $this->userId;
 $emp_fname = $this->empFname;
 $emp_mname = $this->empMname;
 $emp_lname = $this->empLname;
 $emp_phone1 = $this->empPhone1;
 $j = $this->j;

$serviceButton = $this->getServiceButton();


$this->getUserName();
 
 $employee_name ="$emp_fname $emp_mname $emp_lname";
              
                                   //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                           $cell_count = $cell_count + 1;
                               
                                           $counter = $j++;

        
 $records ="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$employee_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$dropDescription</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->userName</b></font></td>
<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"editEmployee.php\">
<input type=\"hidden\" name=\"emp_user_id\" value=\"$user_id\">
<input type=\"submit\" name=\"edit\" value=\"Edit\"></form>
</td>

<td align=\"left\" valign =\"top\" bgcolor=\"$color\">
$serviceButton
</td>


<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" action=\"editEmployee.php\" method=\"post\">
<input type=\"hidden\" name=\"emp_user_id\" value=\"$user_id\">
<input type=\"hidden\" name=\"emp_full_name\" value=\"$employee_name\">
<input type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"return confirmDelete();\"></form>
</td>
</tr>\n";


return "$records";


}
//------------------------------------------------------------------------------------------------------------------
function getUserIds()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT user_id  FROM basic_compensation WHERE type_key = '$this->typeKey' AND user_id !='0'");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($user_id);

while ($stmt ->fetch()) {   
          $userArray .= "$user_id|";
          }
          

return "$userArray";
}

//------------------------------------------------------------------------------------------------------------------
function getUserArray()   {

      $userArray = $this->userArray;
      $userArray = trim($userArray);
      $userArray= substr_replace($userArray,"",-1);
      $userArray = explode("|", $userArray);  
      $userIdNumbers = array_unique($userArray);
      $userIdNumbers= array_filter($userIdNumbers);
      
return $userIdNumbers;      

}
//-------------------------------------------------------------------------------------------------------------------
function getListings()    {

$dbMain = $this->dbconnect();

$userIdNumbers = $this->userIdNumbers;

$j = 1;
        for ($i = 0; $i < count($userIdNumbers); $i++)  {
              $user_id_num = $userIdNumbers[$i];     
              $stmt = $dbMain ->prepare("SELECT user_id, emp_fname, emp_mname, emp_lname, emp_phone1 FROM employee_info WHERE user_id='$user_id_num'");
              $stmt->execute();      
              $stmt->store_result();      
              $stmt->bind_result($user_id, $emp_fname, $emp_mname, $emp_lname, $emp_phone1); 
              $stmt->fetch();

              $this->userId = $user_id;
              $this->empFname = $emp_fname;
              $this->empMname = $emp_mname;
              $this->empLname = $emp_lname;
              $this->empPhone1 = $emp_phone1;
              $this->j = $j++;
              
              $records .= $this->formatList();
              
             }

return "$records";

}
//-------------------------------------------------------------------------------------------------------------------
function getTableHeader()  {

$headerName = $this->headerName;

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">$headerName</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">User Email</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee Info</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Service Types</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Delete</font></th>
</tr>\n";    

return "$table_header";

}
//-------------------------------------------------------------------------------------------------------------------
function loadRecords()   {

define("NAME", 1);
define("TYPE", 2);
define("LOC", 3);
define("ALL", 4);




$dbMain = $this->dbconnect();

$searchType = $this->searchType; 
$searchString = $this->searchString; 

//echo"$searchType";
//exit;
switch ($searchType) {
    case NAME:
          $searchStringArray = preg_split('/\s+/', $searchString);
          $searchString1 = $searchStringArray[0];
          $searchString2 = $searchStringArray[1];    
          $stmt = $dbMain ->prepare("SELECT user_id, emp_fname, emp_mname, emp_lname, emp_phone1  FROM employee_info WHERE emp_fname LIKE '%$searchString1%'  AND emp_lname LIKE '%$searchString2%' "); 
         $this->headerName = 'Contact Information'; 
         $table_header = $this->getTableHeader();        
        
        break;
    case TYPE:
           $this->typeKey = $searchString;
           $userArray .= $this->getUserIds();     
           $this->userArray = $userArray;
           $userIdNumbers = $this->getUserArray();
           $this->userIdNumbers = $userIdNumbers;
           $this->headerName = 'Employee Type'; 
           $table_header = $this->getTableHeader(); 
           $records =  $this->getListings();        
        
         //here is the object for multiple records
           $drop_table = "$table_header  $records";
           $this->drop_list = $drop_table;
                  
      break;
    case LOC:
         $result1 = $dbMain ->prepare("SELECT type_key  FROM employee_type WHERE club_id = '$searchString'");
         $result1->execute();      
         $result1->store_result(); 
         $result1->bind_result($type_key);      
                                  while ($result1 ->fetch()) {        
                                             $this->typeKey = $type_key;                                
                                              $userArray .= $this->getUserIds();                                           
                                             }
                                            
                                              $this->userArray = $userArray;
                                              $userIdNumbers = $this->getUserArray();
                                              $userIdNumbers= array_values($userIdNumbers);
                                              $this->userIdNumbers = $userIdNumbers;
                                                                             
            $this->headerName = 'Service Location'; 
            $table_header = $this->getTableHeader();                                 
            $records =  $this->getListings();                                  
             
            //this sets the header and the records
             $drop_table = "$table_header  $records";
             $this->drop_list = $drop_table;
             
       break;
       case ALL:
       $stmt = $dbMain ->prepare("SELECT user_id, emp_fname, emp_mname, emp_lname, emp_phone1 FROM employee_info WHERE user_id !='0'");
       $this->headerName = 'Contact Information'; 
       $table_header = $this->getTableHeader(); 
       break;   
      }
      
          
if(($searchType == 4) || ($searchType == 1)) {
      $stmt->execute();      
      $stmt->store_result();      
      $stmt->bind_result($user_id, $emp_fname, $emp_mname, $emp_lname, $emp_phone1);                
 $j = 1;                              
 while ($stmt->fetch()) {                            

              $this->userId = $user_id;
              $this->empFname = $emp_fname;
              $this->empMname = $emp_mname;
              $this->empLname = $emp_lname;
              $this->empPhone1 = $emp_phone1;
              $this->j = $j++;
              $this->dropDescription = $emp_phone1;
              
              
              
              $records .= $this->formatList();     
           }   
                            
 //hear is the object for multiple records
 $drop_table = "$table_header  $records";
 $this->drop_list = $drop_table;
 
         }
  }     
//======================================================================================

//these are the links for the table list that are more than one item
   function getDropList()   {
		return($this->drop_list);
    	} 


}