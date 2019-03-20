<?php
function getStateOption($state)  {

//This carries the state when the script calls itself
  switch($state) {          
      case"AL":
      $state_name = "Alabama";
      break;
      case"AK":
      $state_name = "Alaska";
      break;
      case"AZ":
      $state_name = "Arizona";
      break;
      case"AR":
      $state_name = "Arkansas";
      break;
      case"CA":
      $state_name = "California";
      break;
      case"CO":
      $state_name = "Colorado";
      break;
      case"CT":
      $state_name = "Connecticut";
      break;
      case"DE":
      $state_name = "Delaware";
      break;
      case"DC":
      $state_name = "Wash. D.C.";
      break;
      case"FL":
      $state_name = "Florida";
      break;
      case"GA":
      $state_name = "Georgia";
      break;
      case"HI":
      $state_name = "Hawaii";
      break;
      case"ID":
      $state_name = "Idaho";
      break;
      case"IL":
      $state_name = "Illinois";
      break;
      case"IN":
      $state_name = "Indiana";
      break;
      case"IA":
      $state_name = "Iowa";
      break;
      case"KS":
      $state_name = "Kansas";
      break;
      case"KY":
      $state_name = "Kentucky";
      break;
      case"LA":
      $state_name = "Louisiana";
      break;
      case"ME":
      $state_name = "Maine";
      break;
      case"MD":
      $state_name = "Maryland";
      break;
      case"MA":
      $state_name = "Massachusetts";
      break;
      case"MI":
      $state_name = "Michigan";
      break;
      case"MN":
      $state_name = "Minnesota";
      break;
      case"MS":
      $state_name = "Mississippi";
      break;
      case"MO":
      $state_name = "Missouri";
      break;
      case"MT":
      $state_name = "Montana";
      break;
      case"NE":
      $state_name = "Nebraska";
      break;
      case"NV":
      $state_name = "Nevada";
      break;
      case"NH":
      $state_name = "New Hampshire";
      break;
      case"NJ":
      $state_name = "New Jersey";
      break;
      case"NM":
      $state_name = "New Mexico";
      break;
      case"NY":
      $state_name = "New York";
      break;
      case"NC":
      $state_name = "North Carolina";
      break;
      case"ND":
      $state_name = "North Dakota";
      break;
      case"OH":
      $state_name = "Ohio";
      break;
      case"OK":
      $state_name = "Oklahoma";
      break;
      case"OR":
      $state_name = "Oregon";
      break;
      case"PA":
      $state_name = "Pennsylvania";
      break;
      case"RI":
      $state_name = "Rhode Island";
      break;
      case"SC":
      $state_name = "So. Carolina";
      break;
      case"SD":
      $state_name = "So. Dakota";
      break;
      case"TN":
      $state_name = "Tennessee";
      break;
      case"TX":
      $state_name = "Texas";
      break;
      case"UT":
      $state_name = "Utah";
      break;
      case"VT":
      $state_name = "Vermont";
      break;
      case"VA":
      $state_name = "Virginia";
      break;
      case"WA":
      $state_name = "Washington";
      break;
      case"WV":
      $state_name = "West Virginia";
      break;
      case"WI":
      $state_name = "Wisconsin";
      break;
      case"WY":
      $state_name = "Wyoming";
      break;
     }

if($state == "") {
   $state_select = "<option value>Select State</option>";
   }else{
   $state_select = "<option value=\"$state\" selected >$state_name</option>\n<option value>Select State</option>";
   }

return $state_select;

}
//------------------------------------------------------------------------------------------------------------------
//this function handles the cc drop down
function getCreditCardOption($card_type)  {

//this carries the card type when reloaded
  switch($card_type) {          
      case"Visa":
      $type_name = "Visa";
      break;
      case"MC":
      $type_name = "MasterCard";
      break;
      case"Amex":
      $type_name = "American Express";
      break;
      case"Disc":
      $type_name = "Discover";
      break;
}

if($card_type == "") {
   $card_select = "<option value>Card Type</option>";
   }else{
   $card_select = "<option value=\"$card_type\" selected>$type_name</option>\n<option value>Card Type</option>";
   }

return $card_select;   

}
//-----------------------------------------------------------------------------------------------------------------------
//this handles the month and year for cards
function getCreditCardMonth($month)  {

//This carries the month over
  switch($month) {          
      case"01":
      $month_name = "January";
      break;
      case"02":
      $month_name = "February";
      break;
      case"03":
      $month_name = "March";
      break;
      case"04":
      $month_name = "April";
      break;
      case"05":
      $month_name = "May";
      break;
      case"06":
      $month_name = "June";
      break;
      case"07":
      $month_name = "July";
      break;
      case"08":
      $month_name = "August";
      break;
      case"09":
      $month_name = "September";
      break;
      case"10":
      $month_name = "October";
      break;
      case"11":
      $month_name = "November";
      break;
      case"12":
      $month_name = "December";
      break;
}

if($month == "") {
   $month_select = "<option value>Month</option>";
   }else{
   $month_select = "<option value=\"$month\" selected>$month_name</option>\n<option value>Month</option>";
   }

return $month_select;
}
//------------------------------------------------------------------------------------------------------------------------
function getCreditCardYear($year)  {

  switch($year) {          
      case"08":
      $year_name = "2008";
      break;
      case"09":
      $year_name = "2009";
      break;
      case"10":
      $year_name = "2010";
      break;
      case"11":
      $year_name = "2011";
      break;
      case"12":
      $year_name = "2012";
      break;
      case"13":
      $year_name = "2013";
      break;
      case"14":
      $year_name = "2014";
      break; 
      case"15":
      $year_name = "2015";
      break;    
      case"16":
      $year_name = "2016";
      break;           
}

if($year == "") {
   $year_select = "<option value>Year</option>";
   }else{
   $year_select = "<option value=\"$year\" selected>$year_name</option>\n<option value>Year</option>";
   }

return $year_select;

}
//-----------------------------------------------------------------------------------------------------------------------
function getBillingCycle($billing_cycle)  {

switch($billing_cycle) {          
      case"30":
      $cycle_name = "Thirty Days";
      break;
      case"60":
      $cycle_name = "Sixty Days";
      break;
      case"90":
      $cycle_name = "Ninety Days";
      break;
}

if($billing_cycle == "") {
   $cycle_select = "<option value>Billing Cycle</option>";
   }else{
   $cycle_select = "<option value=\"$billing_cycle\" selected>$cycle_name</option>\n<option value>Billing Cycle</option";
   }

return $cycle_select;

}
//-------------------------------------------------------------------------------------------------------------------------
//this formats the product type
function  getProductType($product_type)  {

switch($product_type) {          
      case"1":
      $product_name = "Club Manager Pro";
      break;
      case"2":
      $product_name = "Club Manager Elite";
      break;
    }

if($product_type == "") {
   $product_select = "<option value>Select Product</option>";
   }else{
   $product_select = "<option value=\"$product_type\" selected>$product_name</option>";
   }

return $product_select;

}
//------------------------------------------------------------------------------------------------------------------------
//this formats the payment cycle
function getPaymentCycle($payment_cycle)   {

switch($payment_cycle) {          
      case"D":
      $cycle_name = "Daily";
      break;
      case"W":
      $cycle_name = "Weekly";
      break;
      case"B":
      $cycle_name = "Bi-Monthly";
      break;
      case"M":
      $cycle_name = "Monthly";
      break;      
}

if($payment_cycle == "") {
   $cycle_select = "<option value>Payment Cycle</option>";
   }else{
   $cycle_select = "<option value=\"$payment_cycle\" selected>$cycle_name</option>\n<option value>Payment Cycle</option>";
   }

return $cycle_select;

}
//---------------------------------------------------------------------------------------------------------------------------
function getCompensationType($compOption)    {

switch($compOption) {          
      case"S":
      $comp_name = "Salary";
      break;
      case"H":
      $comp_name = "Hourly";
      break;
      case"C":
      $comp_name = "Commission";
      break; 
      case"SC":
      $comp_name = "Salary/Commission";
      break;  
      case"HC":
      $comp_name = "Hourly/Commission";
      break;         
}

if($compOption == "") {
   $cycle_select = "<option value>Compensation Type</option>";
   }else{
   $cycle_select = "<option value=\"$compOption\" selected>$comp_name</option>\n<option value>Compensation Type</option>";
   }

return $cycle_select;


}
//-----------------------------------------------------------------------------------------------------------------------------
?>