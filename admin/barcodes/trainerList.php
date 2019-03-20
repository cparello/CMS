<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  timeClockLists {

     private  $searchString;
     private  $searchType;
     private  $typeKey;
     private  $dropList;
     private  $tableHeader;
     private  $headerName;
     private  $userName;
     private  $idCard;
     private  $userId;
     private  $recordList;
     private  $empFname;
     private  $empLname;
     private  $empMname;
     private  $empPhone1;
     private  $employeeType;
     private  $counter = 1;


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
//------------------------------------------------------------------------------------------------------------------------------
function loadClubName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id='$this->clubId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($club_name); 
             $stmt->fetch();

 $this->clubName = $club_name;
}
//------------------------------------------------------------------------------------------------------------------------------
function loadUserName() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT user_name FROM admin_passwords WHERE user_id='$this->userId'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($user_name); 
             $stmt->fetch();
              
 $this->userName = "<a href=\"mailto:$user_name\">$user_name</a>"; 

}
//------------------------------------------------------------------------------------------------------------------------------
function loadEmployeeTypeSingle() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$this->typeKey'");
             $stmt->execute();      
             $stmt->store_result();      
             $stmt->bind_result($employee_type, $club_id); 
             $stmt->fetch();

 $this->employeeType = $employee_type;
 $this->clubId = $club_id; 
 $this->loadClubName();
 $this->loadUserName();  
 
 $this->formatList();
}
//------------------------------------------------------------------------------------------------------------------------------
function loadEmployeeTypeMultiple()   {

$dbMain = $this->dbconnect();

         $result1 = $dbMain ->prepare("SELECT type_key, id_card  FROM basic_compensation WHERE user_id = '$this->userId'");
         $result1->execute();      
         $result1->store_result(); 
         $result1->bind_result($type_key, $id_card);      
                                  while ($result1->fetch()) {        
              
                                              if($type_key != null)  {                                                 
                                                          $result2 = $dbMain ->prepare("SELECT employee_type, club_id  FROM employee_type WHERE type_key = '$type_key'");
                                                          $result2->execute();      
                                                          $result2->store_result(); 
                                                          $result2->bind_result($employee_type, $club_id);    
                                                          $result2->fetch();
                                                          
                                                          $this->employeeType = $employee_type;
                                                          $this->idCard = $id_card;
                                                          $this->clubId = $club_id; 
                                                          $this->loadClubName();
                                                          $this->loadUserName();
                                                          $this->formatList();
                                                    
                                                   }//end if not null
              
                                             }//end while loop


}
//-----------------------------------------------------------------------------------------------------------------
function formatList()  {

 $employee_name ="$this->empFname $this->empMname $this->empLname";
              
                                   //create color rows
                                 static $cell_count = 1;
                                 if($cell_count == 2) {
                                           $color = "#D8D8D8";
                                           $cell_count = "";
                                   }else{
                                           $color = "#FFFFFF";
                                   }
                                           $cell_count = $cell_count + 1;
                                           
 
    
                   
                                           
                               
        
 $this->recordList .="<tr>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->counter</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$employee_name</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->empPhone1</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->userName</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->employeeType</b></font></td>
<td align=\"left\" valign =\"top\" bgcolor=\"$color\"><font face=\"Arial\" size=\"1\" color=\"black\"><b>$this->clubName</b></font></td>

<td align=\"left\"  valign =\"top\" bgcolor=\"$color\">
<form style=\"display:inline;\" method=\"post\" action=\"ptSalesAndStats.php\">
<input type=\"text\" id=\"datepicker1\" name=\"datepicker1\" size=\"10\" value=\"\" />
<input type=\"text\" id=\"datepicker2\" name=\"datepicker2\" size=\"10\" value=\"\" />
</td>

<td align=\"left\"  valign =\"top\" bgcolor=\"$color\"/>
<input type=\"hidden\" name=\"id_card\" value=\"$this->idCard\"/>
<input type=\"hidden\" name=\"user_id\" value=\"$this->userId\"/>
<input type=\"hidden\" name=\"employee_name\" value=\"$employee_name\"/>
<input type=\"submit\" name=\"edit\" value=\"Edit\">
</form>
</td>
</tr>\n";

$this->counter++;

}
//------------------------------------------------------------------------------------------------------------------
function loadUserId()  {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT user_id, type_key  FROM basic_compensation WHERE id_card = '$this->idCard' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($user_id, $type_key);
$stmt->fetch();  

$this->userId = $user_id;
$this->typeKey = $type_key;

if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
   
$stmt->close();              
}
//------------------------------------------------------------------------------------------------------------------
function getContactInfo()    {

$dbMain = $this->dbconnect();

$stmt = $dbMain ->prepare("SELECT emp_fname, emp_mname, emp_lname, emp_phone1 FROM employee_info WHERE user_id='$this->userId'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($emp_fname, $emp_mname, $emp_lname, $emp_phone1); 
$stmt->fetch();

$this->empFname = $emp_fname;
$this->empMname = $emp_mname;
$this->empLname = $emp_lname;
$this->empPhone1 = $emp_phone1;
              
}
//-------------------------------------------------------------------------------------------------------------------
function loadTableHeader()  {

$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">#</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Employee Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Phone</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">User Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Position</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Timeline Start/End</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Edit</font></th>
</tr>\n";    

$this->tableHeader = $table_header;

}
//-------------------------------------------------------------------------------------------------------------------
function loadRecords()   {

define("NAME", 1);
define("CARDNUM", 2);

$dbMain = $this->dbconnect();

$searchString = $this->searchString; 
$this->loadTableHeader();

//echo"dsdfsdv $this->searchType";
//exit;
switch ($this->searchType) {
    case NAME:
            $searchStringArray = preg_split('/\s+/', $searchString);
            $searchString1 = $searchStringArray[0];
            $searchString2 = $searchStringArray[1];    
            $stmt = $dbMain ->prepare("SELECT user_id, emp_fname, emp_mname, emp_lname, emp_phone1  FROM employee_info WHERE emp_fname LIKE '%$searchString1%'  AND emp_lname LIKE '%$searchString2%' ");      
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($user_id, $emp_fname, $emp_mname, $emp_lname, $emp_phone1);
          
            while ($stmt->fetch()) {
                     $this->userId = $user_id;
                     $this->empFname = $emp_fname;
                     $this->empMname = $emp_mname;
                     $this->empLname = $emp_lname;
                     $this->empPhone1 = $emp_phone1;
                     $this->loadEmployeeTypeMultiple();                                        
                     }
                    
            break;
    case CARDNUM:
             $this->idCard = $searchString;
             $this->loadUserId();     
             $this->getContactInfo(); 
             $this->loadEmployeeTypeSingle();           
            break;
      }
      
                            
 //hear is the object for multiple records
 $this->dropList = "$this->tableHeader  $this->recordList";
 
         
  }     
//======================================================================================

//these are the links for the table list that are more than one item
   function getDropList()   {
		return($this->dropList);
    	} 


}