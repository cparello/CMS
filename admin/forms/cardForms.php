<?php
//this class is designed to dynamically generate forms for credit cards


class cardForms {

private $monthDrop;
private $monthDropScript;
private $monthDropTab;
private $monthDropDisable;
private $dropMonthHeader = 'Month';

private $yearDrop;
private $yearDropScript;
private $yearDropTab;
private $yearDropDisable;
private $dropYearHeader = 'Year';

private $typeDrop;
private $typeDropScript;
private $typeDropTab;
private $typeDropDisable;

private $cardTypeSelected = null;
private $yearSelected = null;
private $monthSelected = null;
private $expirationDate = null;


function setTypeDrop($typeDrop) {
             $this->typeDrop = $typeDrop;
             }
function setTypeDropScript($typeDropScript) {
             $this->typeDropScript =$typeDropScript;
             }
function setTypeDropDisable($typeDropDisable) {
             $this->typeDropDisable= $typeDropDisable;
             }            
function setTypeDropTab($typeDropTab) {
             $this->typeDropTab ="tabindex=\"$typeDropTab\"";
             }             
function setCardTypeSelected($cardTypeSelected) {
             $this->cardTypeSelected = $cardTypeSelected;
             }
     
     
function setExpirationDate($expirationDate) {
             $this->expirationDate =$expirationDate;
             }      


function setMonthDrop($monthDrop) {
             $this->monthDrop =$monthDrop;
             }
function setMonthDropScript($monthDropScript) {
             $this->monthDropScript =$monthDropScript;
             }
function setMonthDropDisable($monthDropDisable) {
             $this->monthDropDisable= $monthDropDisable;
             }            
function setMonthDropTab($monthDropTab) {
             $this->monthDropTab ="tabindex=\"$monthDropTab\"";
             }
function setMonthSelected($monthSelected) {
             $this->monthSelected =$monthSelected;
             }     
   

function setYearDrop($yearDrop) {
             $this->yearDrop =$yearDrop;
             }
function setYearDropScript($yearDropScript) {
             $this->yearDropScript =$yearDropScript;
             } 
function setYearDropDisable($yearDropDisable) {
             $this->yearDropDisable= $yearDropDisable;
             }                        
function setYearDropTab($yearDropTab) {
             $this->yearDropTab ="tabindex=\"$yearDropTab\"";
             }             
function setYearSelected($yearSelected) {
             $this->yearSelected =$yearSelected;
             }

             
//--------------------------------------------------------------------------------------------------------------------------------------
function parseDateSelected()  {

   $todays_date = date("Y-m-d");
   $expiration_date  = strtotime($this->expirationDate);
   $todays_date  = strtotime($todays_date);

             if($this->expirationDate != '0000-00-00') {
             
                   if($expiration_date <= $todays_date)  {                     
                      $this->dropMonthHeader = 'Expired Month';
                      $this->dropYearHeader = 'Expired Year';   
                      }else{
                          $expiration_date_array = explode('-', $this->expirationDate);
                          $this->yearSelected = $expiration_date_array[0];
                          $this->monthSelected = $expiration_date_array[1];                  
                     }
                     
                }
               
}
//-------------------------------------------------------------------------------------------------------------------------------------
function createTypeDrop()   {

switch ($this->cardTypeSelected)  {
case "Visa":
$visaSelected ="selected";
break;
case "MC":
$mcSelected="selected";
break;
case "Amex":
$amxSelected="selected";
break;
case "Disc":
$discSelected="selected";
break;
}

$this->typeDrop = <<<TYPEDROP
<select $this->typeDropTab name="card_type" id="card_type" $this->typeDropScript $this->typeDropDisable/>
  <option value>Card Type</option>
  <option value="Visa" $visaSelected>Visa</option>
  <option value="MC" $mcSelected>MasterCard</option>
  <option value="Amex" $amxSelected>American Express</option>
  <option value="Disc" $discSelected>Discover</option>
</select>
TYPEDROP;

}
//--------------------------------------------------------------------------------------------------------------------------------------
function createMonthDrop()   {

switch ($this->monthSelected)  {
case "01":
$firstMonthSelected ="selected";
break;
case "02":
$secondMonthSelected="selected";
break;
case "03":
$thirdMonthSelected="selected";
break;
case "04":
$fourthMonthSelected="selected";
break;
case "05":
$fifthMonthSelected="selected";
break;
case "06":
$sixthMonthSelected="selected";
break;
case "07":
$seventhMonthSelected="selected";
break;
case "08":
$eighthMonthSelected="selected";
break;
case "09":
$ninthMonthSelected="selected";
break;
case "10":
$tenthMonthSelected="selected";
break;
case "11":
$eleventhMonthSelected="selected";
break;
case "12":
$twelfthMonthSelected="selected";
break;
}





$this->monthDrop = <<<MONTHDROP
<select $this->monthDropTab name="card_month" id="card_month" $this->monthDropScript $this->monthDropDisable/>
<option value="">$this->dropMonthHeader</option>
<option value="01" $firstMonthSelected>January</option>
<option value="02" $secondMonthSelected>February</option>
<option value="03" $thirdMonthSelected>March</option>
<option value="04" $fourthMonthSelected>April</option>
<option value="05" $fifthMonthSelected>May</option>
<option value="06" $sixthMonthSelected>June</option>
<option value="07" $seventhMonthSelected>July</option>
<option value="08" $eighthMonthSelected>August</option>
<option value="09" $ninthMonthSelected>September</option>
<option value="10" $tenthMonthSelected>October</option>
<option value="11" $eleventhMonthSelected>November</option>
<option value="12" $twelfthMonthSelected>December</option>
</select> 
MONTHDROP;

}


//----------------------------------------------------------------------------------------------------------------------------------
function createYearDrop() {

$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")+1;
$secondYearValue = date("y")+1;
$thirdYearName = date("Y")+2;
$thirdYearValue = date("y")+2;
$fourthYearName = date("Y")+3;
$fourthYearValue = date("y")+3;
$fifthYearName = date("Y")+4;
$fifthYearValue = date("y")+4;
$sixthYearName = date("Y")+5;
$sixthYearValue = date("y")+5;
$seventhYearName = date("Y")+6;
$seventhYearValue = date("y")+6;
$eightYearName = date("Y")+7;
$eightYearValue = date("y")+7;
$nineYearName = date("Y")+8;
$nineYearValue = date("y")+8;
$tenYearName = date("Y")+9;
$tenYearValue = date("y")+9;
$elevenYearName = date("Y")+10;
$elevenYearValue = date("y")+10;
$twelveYearName = date("Y")+11;
$twelveYearValue = date("y")+11;
$thirteenYearName = date("Y")+12;
$thirteenYearValue = date("y")+12;
$fourteenYearName = date("Y")+13;
$fourteenYearValue = date("y")+13;


switch ($this->yearSelected)  {
case "$firstYearName":
$firstYearSelected ="selected";
break;
case "$secondYearName":
$secondYearSelected="selected";
break;
case "$thirdYearName":
$thirdYearSelected="selected";
break;
case "$fourthYearName":
$fourthYearSelected="selected";
break;
case "$fifthYearName":
$fifthYearSelected="selected";
break;
case "$sixthYearName":
$sixthYearSelected="selected";
break;
case "$seventhYearName":
$seventhYearSelected="selected";
break;
case "$eightYearName":
$eightYearSelected ="selected";
break;
case "$nineYearName":
$nineYearSelected="selected";
break;
case "$tenYearName":
$tenYearSelected="selected";
break;
case "$elevenYearName":
$elevenYearSelected="selected";
break;
case "$twelveYearName":
$twelveYearSelected="selected";
break;
case "$thirteenYearName":
$thirteenYearSelected="selected";
break;
case "$fourteenYearName":
$fourteenYearSelected="selected";
break;
}

            

$this->yearDrop = <<<YEARDROP
<select $this->yearDropTab name="card_year" id="card_year" $this->yearDropScript $this->yearDropDisable/>
<option value="">$this->dropYearHeader</option>
<option value="$firstYearValue" $firstYearSelected>$firstYearName</option>
<option value="$secondYearValue" $secondYearSelected>$secondYearName</option>
<option value="$thirdYearValue" $thirdYearSelected>$thirdYearName</option>
<option value="$fourthYearValue" $fourthYearSelected>$fourthYearName</option>
<option value="$fifthYearValue" $fifthYearSelected>$fifthYearName</option>
<option value="$sixthYearValue" $sixthYearSelected>$sixthYearName</option>
<option value="$seventhYearValue" $seventhYearSelected>$seventhYearName</option>
<option value="$eightYearValue" $eightYearSelected>$eightYearName</option>
<option value="$nineYearValue" $nineYearSelected>$nineYearName</option>
<option value="$tenYearValue" $tenYearSelected>$tenYearName</option>
<option value="$elevenYearValue" $elevenYearSelected>$elevenYearName</option>
<option value="$twelveYearValue" $twelveYearSelected>$twelveYearName</option>
<option value="$thirteenYearValue" $thirteenYearSelected>$thirteenYearName</option>
<option value="$fourteenYearValue" $fourteenYearSelected>$fourteenYearName</option>
</select>
YEARDROP;


}
//----------------------------------------------------------------------------------------------------------------------------------

function getMonthDrop() {
         return($this->monthDrop);
         }

function getYearDrop() {
         return($this->yearDrop);
         }
         
function getTypeDrop() {
        return($this->typeDrop);
        }       
         


}
?>