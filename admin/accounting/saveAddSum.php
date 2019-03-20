<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class saveAddSub {

private $userId = null;
private $typeKey = null;
private $addSubOne = null;
private $addSubDescOne = null;
private $addSubAmountOne = null;
private $saveMarkerOne = null;
private $addSubTwo = null;
private $addSubDescTwo = null;
private $addSubAmountTwo = null;
private $saveMarkerTwo = null;
private $addSubThree = null;
private $addSubDescThree = null;
private $addSubAmountThree = null;
private $saveMarkerThree = null;
private $addSubFour = null;
private $addSubDescFour = null;
private $addSubAmountFour = null;
private $saveMarkerFour = null;

private $testShit =null;

function setUserId($userId) {
      $this->userId = $userId;
      }
function setTypeKey($typeKey) {
      $this->typeKey = $typeKey;
      }
function setAddSubOne($addSubOne) {
      $this->addSubOne = $addSubOne;
      }
function setAddSubDescOne($addSubDescOne) {
      $this->addSubDescOne = $addSubDescOne;
      }
function setAddSubAmountOne($addSubAmountOne) {
      $this->addSubAmountOne = $addSubAmountOne;
      }
function setSaveMarkerOne($saveMarkerOne) {
      $this->saveMarkerOne = $saveMarkerOne;
      }
function setAddSubTwo($addSubTwo) {
      $this->addSubTwo = $addSubTwo;
      }
function setAddSubDescTwo($addSubDescTwo) {
      $this->addSubDescTwo = $addSubDescTwo;
      }
function setAddSubAmountTwo($addSubAmountTwo) {
      $this->addSubAmountTwo = $addSubAmountTwo;
      }
function setSaveMarkerTwo($saveMarkerTwo) {
      $this->saveMarkerTwo = $saveMarkerTwo;
      }
function setAddSubThree($addSubThree) {
      $this->addSubThree = $addSubThree;
      }
function setAddSubDescThree($addSubDescThree) {
      $this->addSubDescThree = $addSubDescThree;
      }
function setAddSubAmountThree($addSubAmountThree) {
      $this->addSubAmountThree = $addSubAmountThree;
      }
function setSaveMarkerThree($saveMarkerThree) {
      $this->saveMarkerThree = $saveMarkerThree;
      }
function setAddSubFour($addSubFour) {
      $this->addSubFour = $addSubFour;
      }
function setAddSubDescFour($addSubDescFour) {
      $this->addSubDescFour = $addSubDescFour;
      }
function setAddSubAmountFour($addSubAmountFour) {
      $this->addSubAmountFour = $addSubAmountFour;
      }
function setSaveMarkerFour($saveMarkerFour) {
      $this->saveMarkerFour = $saveMarkerFour;
      }


//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//----------------------------------------------------------------------------------------------------
function updateAddSubRecursive() {

$dbMain = $this->dbconnect();
$sql = "UPDATE add_sub_recursive SET  add_sub_one= ?, add_sub_desc_one= ?, add_sub_amount_one= ?, add_sub_two= ?, add_sub_desc_two= ?, add_sub_amount_two= ?, add_sub_three= ?, add_sub_desc_three= ?, add_sub_amount_three= ?, add_sub_four= ?, add_sub_desc_four=?, add_sub_amount_four=? WHERE type_key = '$this->typeKey' AND user_id='$this->userId' ";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('ssdssdssdssd', $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour);		


$addSubOne = $this->addSubOne;
$addSubDescOne = $this->addSubDescOne; 
$addSubAmountOne = $this->addSubAmountOne;
$addSubTwo = $this->addSubTwo;
$addSubDescTwo = $this->addSubDescTwo;
$addSubAmountTwo = $this->addSubAmountTwo;
$addSubThree = $this->addSubThree; 
$addSubDescThree = $this->addSubDescThree;
$addSubAmountThree = $this->addSubAmountThree; 
$addSubFour = $this->addSubFour;
$addSubDescFour = $this->addSubDescFour;
$addSubAmountFour = $this->addSubAmountFour;


if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }
}
//-----------------------------------------------------------------------------------------------------
function saveAddSubRecursive() {

$dbMain = $this->dbconnect();
$sql = "INSERT INTO add_sub_recursive VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('iissdssdssdssd', $userId, $typeKey, $addSubOne, $addSubDescOne, $addSubAmountOne, $addSubTwo, $addSubDescTwo, $addSubAmountTwo, $addSubThree, $addSubDescThree, $addSubAmountThree, $addSubFour, $addSubDescFour, $addSubAmountFour);

$userId = $this->userId;
$typeKey = $this->typeKey;
$addSubOne = $this->addSubOne;
$addSubDescOne = $this->addSubDescOne; 
$addSubAmountOne = $this->addSubAmountOne;
$addSubTwo = $this->addSubTwo;
$addSubDescTwo = $this->addSubDescTwo;
$addSubAmountTwo = $this->addSubAmountTwo;
$addSubThree = $this->addSubThree; 
$addSubDescThree = $this->addSubDescThree;
$addSubAmountThree = $this->addSubAmountThree; 
$addSubFour = $this->addSubFour;
$addSubDescFour = $this->addSubDescFour;
$addSubAmountFour = $this->addSubAmountFour;


if(!$stmt->execute())  {
    return($this->errorMessage);
    printf("Error: %s.\n", $stmt->error);
	exit;
   }

}
//-----------------------------------------------------------------------------------------------------
function parseAddSub() {

//first we filter any fields that have amounts or descrips or ad sub details that are not set to save
if($this->saveMarkerOne == 'N') {
   $this->addSubOne = 'E';
   $this->addSubDescOne = "";
   $this->addSubAmountOne = "";
  }
if($this->saveMarkerTwo == 'N') {
   $this->addSubTwo = 'E';
   $this->addSubDescTwo = "";
   $this->addSubAmountTwo = "";
  }
if($this->saveMarkerThree == 'N') {
   $this->addSubThree = 'E';
   $this->addSubDescThree = "";
   $this->addSubAmountThree = "";
  }
if($this->saveMarkerFour == 'N') {
   $this->addSubFour = 'E';
   $this->addSubDescFour = "";
   $this->addSubAmountFour = "";
  }


$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT count(*) as count FROM add_sub_recursive WHERE type_key = '$this->typeKey' AND user_id='$this->userId' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($count);
$stmt->fetch();

       if($count == 0) {
          $this->saveAddSubRecursive();
         }else{
          $this->updateAddSubRecursive();  
         }

}
//----------------------------------------------------------------------------------------------------
function getTestShit() {
      return($this->testShit);
      }


}

$user_id = $_REQUEST['user_id'];
$employee_add_sub_array = $_REQUEST['employee_add_sub_array'];

$employee_add_sub_array = urldecode($employee_add_sub_array);
$employee_add_sub_array = explode("@", $employee_add_sub_array);

foreach ($employee_add_sub_array as $add_sub) {

             if($add_sub != "") {
             
                         $group_rec = explode("|", $add_sub);
                         $user_id = $group_rec[0];
                         $type_key = $group_rec[1];
                         $add_sub_one = $group_rec[2];
                         $add_sub_amount_one = $group_rec[3];
                         $add_sub_desc_one = $group_rec[4];
                         $save_marker_one = $group_rec[5];
                         $add_sub_two = $group_rec[6];
                         $add_sub_amount_two = $group_rec[7];
                         $add_sub_desc_two = $group_rec[8];
                         $save_marker_two = $group_rec[9]; 
                         $add_sub_three = $group_rec[10];
                         $add_sub_amount_three = $group_rec[11];
                         $add_sub_desc_three = $group_rec[12];
                         $save_marker_three = $group_rec[13];  
                         $add_sub_four = $group_rec[14];
                         $add_sub_amount_four = $group_rec[15];
                         $add_sub_desc_four = $group_rec[16];
                         $save_marker_four = $group_rec[17];     
                         
                  $addSubRecord = new saveAddSub();
                  $addSubRecord-> setUserId($user_id); 
                  $addSubRecord-> setTypeKey($type_key); 
                  $addSubRecord-> setAddSubOne($add_sub_one);
                  $addSubRecord-> setAddSubAmountOne($add_sub_amount_one);
                  $addSubRecord-> setAddSubDescOne($add_sub_desc_one);
                  $addSubRecord-> setSaveMarkerOne($save_marker_one);
                  $addSubRecord-> setAddSubTwo($add_sub_two);
                  $addSubRecord-> setAddSubAmountTwo($add_sub_amount_two);
                  $addSubRecord-> setAddSubDescTwo($add_sub_desc_two);
                  $addSubRecord-> setSaveMarkerTwo($save_marker_two);
                  $addSubRecord-> setAddSubThree($add_sub_three);
                  $addSubRecord-> setAddSubAmountThree($add_sub_amount_three);
                  $addSubRecord-> setAddSubDescThree($add_sub_desc_three);
                  $addSubRecord-> setSaveMarkerThree($save_marker_three);
                  $addSubRecord-> setAddSubFour($add_sub_four);
                  $addSubRecord-> setAddSubAmountFour($add_sub_amount_four);
                  $addSubRecord-> setAddSubDescFour($add_sub_desc_four);
                  $addSubRecord-> setSaveMarkerFour($save_marker_four);
                  
                  $addSubRecord-> parseAddSub();
                                                                    
                }
           }


echo"1";

?>
