<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

//this class formats the dropdown menu for clubs and facilities
class  instructorSql {

private  $typeId = null;
private  $instructorName = null;
private  $instructorDescription = null;
private  $instructorId = null;
private  $imageBit = null;
private  $imageName = null;
private  $fileExtension = null;
private  $instructorPhoto = null;
private  $deleteStatus = null;


function setTypeId($typeId) {
        $this->typeId = $typeId;
        }
        
function setInstructorName($instructorName) {
        $this->instructorName = $instructorName;
        }

function setInstructorDescription($instructorDescription) {
        $this->instructorDescription = $instructorDescription;
        }

function setImageBit($imageBit) {
        $this->imageBit = $imageBit;
        }
        
function setFileExtension($fileExtension) {
        $this->fileExtension = $fileExtension;
        }
        
function setInstructorId($instructorId) {
        $this->instructorId = $instructorId;
        }
function setTypeName($type_name){
        $this->typeName = $type_name;
        }
 
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
} 
//------------------------------------------------------------------------------------------------------- 
function updateInstructorInfo() {

   $dbMain = $this->dbconnect();
   $sql = "UPDATE instructor_info SET instructor_photo= ? WHERE instructor_id= '$this->instructorId' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('s',  $instructorPhoto);
   
   $instructorPhoto = $this->instructorPhoto;
   
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }	
     
   $stmt->close(); 

}
//-------------------------------------------------------------------------------------------------------
 function addInstructor() {
     $dbMain = $this->dbconnect();
    if ($this->typeId == '' OR $this->typeId == 0){
        
       $nameArray =  explode(' ',$this->typeName);
       $searchString = $nameArray[0];
        
         $stmt = $dbMain ->prepare("SELECT type_id FROM schedule_type WHERE type_name LIKE '%$searchString%' ");
         $stmt->execute();      
         $stmt->store_result();      
         $stmt->bind_result($this->typeId);
         $stmt->fetch();
         $stmt->close();
    }
  
    //$dbMain = $this->dbconnect();
    $sql = "INSERT INTO instructor_info VALUES (?, ?, ?, ?, ?)";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iisss', $instructorId, $typeId, $instructorName, $instructorDescription, $photoName);

    $instructorId = null;    
    $typeId = $this->typeId;
    $instructorName = $this->instructorName;
    $instructorDescription = $this->instructorDescription;
    $photoName = null;

      if(!$stmt->execute())  {
          // aver strange error her where it spits out a false error that report name can't be null but the var is saved
          printf("Error: %s. save name\n", $stmt->error);
        }
        
   $this->instructorId = $stmt->insert_id; 
   
   $stmt->close();  
    
    if($this->imageBit == 1) {  
        $separator = '.';
        $this->imageName = "$this->instructorId$separator";
        $this->instructorPhoto = "$this->imageName$this->fileExtension";
        $this->updateInstructorInfo();       
      }
  
 }
//-------------------------------------------------------------------------------------------------------
function updateInstructor() {

   $dbMain = $this->dbconnect();
   $sql = "UPDATE instructor_info SET instructor_name= ?, instructor_description= ? WHERE instructor_id= '$this->instructorId' ";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('ss',  $instructorName, $instructorDescription);
   
   $instructorName = $this->instructorName;
   $instructorDescription = $this->instructorDescription;
   
   if(!$stmt->execute())  {
      printf("Error: %s.\n", $stmt->error);
     }	
     
   $stmt->close(); 


    if($this->imageBit == 1) {  
        $separator = '.';
        $this->imageName = "$this->instructorId$separator";
        $this->instructorPhoto = "$this->imageName$this->fileExtension";
        $this->updateInstructorInfo();       
      }

}
//-------------------------------------------------------------------------------------------------------
function deleteInstructor() {

 $dbMain = $this->dbconnect();
 $sql = "DELETE FROM instructor_info WHERE type_id = ? AND instructor_id = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("ii", $this->typeId, $this->instructorId);
			$stmt->execute();
			$stmt->close();
			$this->deleteStatus = 1;
           }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		   }


}
//-------------------------------------------------------------------------------------------------------
function getImageName() {
      return($this->imageName);
      }
 
function getDeleteStatus() {
      return($this->deleteStatus);
      }



 
}
//===============================================================







?>