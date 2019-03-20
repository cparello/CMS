<?php
//this class is designed to dynamically generate forms for ach 

class bankForms {

private $accountDrop;
private $accountDropScript;
private $accountDropTab;
private $accountDropDisable;

private $accountTypeSelected = null;


function setAccountDrop($accountDrop) {
             $this->typeDrop = $accountDrop;
             }
function setAccountDropScript($accountDropScript) {
             $this->accountDropScript =$accountDropScript;
             }
function setAccountDropDisable($accountDropDisable) {
             $this->accountDropDisable= $accountDropDisable;
             }            
function setAccountDropTab($accountDropTab) {
             $this->accountDropTab ="tabindex=\"$accountDropTab\"";
             }             
function setAccountTypeSelected($accountTypeSelected) {
             $this->accountTypeSelected = $accountTypeSelected;
             }

//-------------------------------------------------------------------------------------------------------------------------------------
function createAccountDrop()   {

switch ($this->accountTypeSelected)  {
case "C":
$personalSelected ="selected";
break;
case "B":
$businessSelected="selected";
break;
case "S":
$savingsSelected="selected";
break;
}

$this->accountDrop = <<<ACCOUNTDROP
<select $this->accountDropTab  name="account_type" id="account_type" $this->accountDropScript $this->accountDropDisable/>
  <option value="">Account Type</option>
  <option value="C" $personalSelected>Personal Checking</option>
  <option value="B" $businessSelected>Business Checking</option>
  <option value="S" $savingsSelected>Savings</option>
</select>
ACCOUNTDROP;

}
//--------------------------------------------------------------------------------------------------------------------------------------

function getAccountDrop() {
        return($this->accountDrop);
        }       


}