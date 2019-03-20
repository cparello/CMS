<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class overtimeOptions {

private $dailyRuleOne = null;
private $dailyRuleTwo = null;
private $weeklyRule = null;

function setState($state) {
          $this->state = $state;
          }

function setDailyRuleOne($dailyRuleOne) {
          $this->dailyRuleOne = $dailyRuleOne;
          }
          
function setDailyRuleTwo($dailyRuleTwo) {
          $this->dailyRuleTwo = $dailyRuleTwo;
          }

function setWeeklyRule($weeklyRule) {
          $this->weeklyRule = $weeklyRule;
          }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}
//==============================================================================================
function saveOtOptions() {
    
 $ot_id = 1;   
    
if($this->dailyRuleOne == "") {
  $this->dailyRuleOne = 0;
  }
if($this->dailyRuleTwo == "") {
  $this->dailyRuleTwo = 0;
  }    
if($this->weeklyRule == "") {
  $this->weeklyRule = 0;
  }

    
$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT ot_hourly_state_rule, ot_secondary_hourly_state_rule, ot_weekly_state_rule FROM payroll_ot_rules_hours WHERE state = '$this->state' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($ot_hourly_state_rule, $ot_secondary_hourly_state_rule, $ot_weekly_state_rule);
$stmt->fetch();
$rowCount = $stmt->num_rows;

if($rowCount != 0)  {
    $sql = "UPDATE payroll_ot_rules_hours  SET ot_hourly_state_rule = ?, ot_secondary_hourly_state_rule = ?, ot_weekly_state_rule = ?  WHERE state = '$this->state' ";
    $stmt = $dbMain->prepare($sql);
    $stmt->bind_param('iii', $this->dailyRuleOne, $this->dailyRuleTwo, $this->weeklyRule);
    $stmt->execute();        
    $stmt->close();
    }else{
        $sql = "INSERT INTO payroll_ot_rules_hours VALUES (?,?,?,?,?)";
        $stmt = $dbMain->prepare($sql);
        $stmt->bind_param('iiiis',$ot_id,$this->dailyRuleOne, $this->dailyRuleTwo, $this->weeklyRule, $this->state);
        $stmt->execute();        
        $stmt->close(); 
    }
}
//===============================================
function loadOtOptions() {

$dbMain = $this->dbconnect();
$stmt = $dbMain ->prepare("SELECT ot_hourly_state_rule, ot_secondary_hourly_state_rule, ot_weekly_state_rule FROM payroll_ot_rules_hours WHERE state = '$this->state' ");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result( $this->dailyRuleOne, $this->dailyRuleTwo, $this->weeklyRule);
$stmt->fetch();
$stmt->close();
}
//==============================================================================================
function getDailyRuleOne() {
          return($this->dailyRuleOne);
          }
function getDailyRuleTwo() {
          return($this->dailyRuleTwo);
          }
function getWeeklyRule() {
          return($this->weeklyRule);
          }

}
//========================================================================
//========================================================================
$ajax_switch = $_REQUEST['ajax_switch'];


if($ajax_switch == 1) {
    
    $rule_one = $_REQUEST['rule_one'];
    $rule_two = $_REQUEST['rule_two'];
    $rule_three = $_REQUEST['rule_three'];
    $state = $_REQUEST['state'];

  $overtime = new overtimeOptions();
  $overtime-> setDailyRuleOne($rule_one);
  $overtime-> setDailyRuleTwo($rule_two);
  $overtime-> setWeeklyRule($rule_three);
  $overtime-> setState($state);
  $overtime-> saveOtOptions();
  
   $success = "1";
   echo"$success";
   exit;
}

if($ajax_switch == 2) {
  
  $state = $_REQUEST['state'];

  $overtime = new overtimeOptions();
  $overtime-> setState($state);
  $overtime-> loadOtOptions();
  $rule_one = $overtime-> getDailyRuleOne($rule_one);
  $rule_two = $overtime-> getDailyRuleTwo($rule_two);
  $rule_three = $overtime-> getWeeklyRule($rule_three);
   $success = "1";
   echo"$success|$rule_one|$rule_two|$rule_three";
   exit;
}
?>