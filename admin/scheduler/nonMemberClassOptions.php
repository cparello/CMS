<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class classOptions {

private $dailyRuleOne = null;
private $dailyRuleTwo = null;
private $weeklyRule = null;

function setQuan1($quan1) {
          $this->quan1 = $quan1;
          }
function setPrice1($price1) {
          $this->price1 = $price1;
          }

function setQuan2($quan2) {
          $this->quan2 = $quan2;
          }
function setPrice2($price2) {
          $this->price2 = $price2;
          }
          
function setQuan3($quan3) {
          $this->quan3 = $quan3;
          }
function setPrice3($price3) {
          $this->price3 = $price3;
          }
          
function setQuan4($quan4) {
          $this->quan4 = $quan4;
          }
function setPrice4($price4) {
          $this->price4 = $price4;
          }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function saveNMPOptions() {
    
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT class_key FROM non_member_class_prices WHERE class_key = '1'");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($class_key);
$stmt->fetch();
$stmt->close();


    
if($class_key == 1)  {
    
    $sql = "UPDATE non_member_class_prices  SET quan1 = ?, quan2 = ?, quan3 = ?, quan4 = ?, price1 = ?, price2 = ?, price3 = ?, price4 = ?  WHERE class_key = '1'";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iiiidddd', $this->quan1, $this->quan2, $this->quan3, $this->quan4, $this->price1, $this->price2,$this->price3,$this->price4);
    $stmt->execute();        
    $stmt->close();
    }else{
        $class_key = 1;
        $sql = "INSERT INTO non_member_class_prices VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiiiissss',$class_key, $this->quan1, $this->quan2, $this->quan3, $this->quan4, $this->price1, $this->price2,$this->price3,$this->price4);
        $stmt->execute();        
        $stmt->close(); 
    }
}
//===============================================
function loadNonMemOptions() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT quan1, quan2, quan3, quan4, price1, price2, price3, price4 FROM non_member_class_prices WHERE class_key = '1'");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result( $this->quan1, $this->quan2, $this->quan3, $this->quan4, $this->price1, $this->price2,$this->price3,$this->price4);
$stmt->fetch();
$stmt->close();
}
//==============================================================================================
function getQuan1() {
          return ($this->quan1);
          }
function getPrice1() {
          return ($this->price1);
          }

function getQuan2() {
          return ($this->quan2);
          }
function getPrice2() {
          return ($this->price2);
          }
          
function getQuan3() {
          return ($this->quan3);
          }
function getPrice3() {
          return ($this->price3);
          }
          
function getQuan4() {
          return ($this->quan4);
          }
function getPrice4() {
          return ($this->price4);
          }

}
//========================================================================
//========================================================================
$ajax_switch = $_REQUEST['ajax_switch'];


if($ajax_switch == 1) {
   
    $quan1 = $_REQUEST['quan1'];
    $price1 = $_REQUEST['price1'];
    $quan2 = $_REQUEST['quan2'];
    $price2 = $_REQUEST['price2'];
    $quan3 = $_REQUEST['quan3'];
    $price3 = $_REQUEST['price3'];
    $quan4 = $_REQUEST['quan4'];
    $price4 = $_REQUEST['price4'];
  $overtime = new classOptions();
  $overtime-> setQuan1($quan1);
  $overtime-> setPrice1($price1);
  $overtime-> setQuan2($quan2);
  $overtime-> setPrice2($price2);
  $overtime-> setQuan3($quan3);
  $overtime-> setPrice3($price3);
  $overtime-> setQuan4($quan4);
  $overtime-> setPrice4($price4);
  $overtime-> saveNMPOptions();
  
   $success = "1";
   echo"$success";
   exit;
}


?>