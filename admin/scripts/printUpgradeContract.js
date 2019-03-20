function openUpgradeContractWindow()  {
//alert('Open Contract Window'); 
document.form1.contract_bit.value = 1;
window.open('upgradeContractWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//-------------------------------------------------------------------------------------------------------------------------
function getGroupInfo()  {

var groupAddress =  document.form1.group_address.value;
var groupPhone =   document.form1.group_phone.value;

  //if a pound sign is used for an apt etc, replace with num
      groupAddress = groupAddress.replace(/#/g, "Num");

 var groupArray = (groupAddress+ '|' +groupPhone);
      
 return groupArray;

}
//--------------------------------------------------------------------------------------------------------
function setMonthlyBilling()  {
if(document.getElementById('monthly_billing1').checked == true) {
  document.form1.monthly_billing_selected.value = 'CR';
  monthlyBillingType =  'CR';
}
if(document.getElementById('monthly_billing2').checked == true) {
  document.form1.monthly_billing_selected.value = 'BA';
  monthlyBillingType =  'BA';
}

if(document.getElementById('monthly_billing3').checked == true) {
  document.form1.monthly_billing_selected.value = 'CA';
  monthlyBillingType =  'CA';
}

if(document.getElementById('monthly_billing4').checked == true) {
  document.form1.monthly_billing_selected.value = 'CH';
  monthlyBillingType =  'CH';
}

}
//--------------------------------------------------------------------------------------------------------
function getAddressInfo() {

var streetAddress = document.form1.street_address.value;
var cityName = document.form1.city.value;
var stateName = document.form1.state.value;
var zipCode = document.form1.zip.value;
var primaryPhone = document.form1.primary_phone.value;
var cellPhone = document.form1.cell_phone.value;
var emailAddress = document.form1.email.value;

  //if a pound sign is used for an apt etc, replace with num
      streetAddress = streetAddress.replace(/#/g, "Num");

var  addressInfoArray = (streetAddress+'|'+cityName+'|'+stateName+'|'+zipCode+'|'+primaryPhone+'|'+cellPhone+'|'+emailAddress);

       addressInfoArray = addressInfoArray.replace(/#/g, "");


return addressInfoArray;

}

//===========================================================
function printRenewContract(thisName, thisField)  {

this.monthlyBillingType = "";


//first check to make sure all of the perspective fields are filled out
var bool;
bool = checkServices(thisName,thisField);
if(bool == false)  {
  return false;
}
//----------------------------------------------------------------------------
//here we make sure that a monthly billing cycle is selected if it exists for the service
var radioSwitch = document.getElementById('setMonth1').innerHTML;
 if(radioSwitch != "") {

 if(document.getElementById('monthly_billing1').checked == false  && document.getElementById('monthly_billing2').checked == false && document.getElementById('monthly_billing3').checked == false && document.getElementById('monthly_billing4').checked == false) {
 alert('Please select a Monthly Billing option for this contract');
 return false;                         
  }else{
  setMonthlyBilling();
  }
    
  }else if(radioSwitch == "")  {
  document.form1.monthly_billing_selected.value = "";
  monthlyBillingType = "";
  }
//----------------------------------------------------------------------------
var keySwitch;
var contractKey = document.form1.contract_key.value;
//check to see if a contract key has been generated then create a switch if a new key is needed
//alert(contractKey);
if(contractKey  == "") {
   keySwitch = 0;
   }else{
   keySwitch = 1;
   }
//------------------------------------------------------------------------------
//set up if contact info has been changed
var groupInfoArray = "NA";
var addressInfoArray = "NA";
var enableFields = document.form1.group_marker.value;
//first we see if the basic account info is checked. if not we do not send to form object
var enableSwitch = document.form1.change_info;
if(enableSwitch.checked == true) {
     addressInfoArray = getAddressInfo();     
          if(enableFields == 1) {
             groupInfoArray = getGroupInfo()
             }    
   }
//-------------------------------------------------------------------------------------
var compPattern = 'comp';
var priceField;
var productListArray = "";
var monthPattern;
var renewalValue;
var unitRenewalValue;
var newRenewalValue;
var serviceCost;
var adjustedRate;
var unitServiceValue;
var newServiceValue;
var originalServiceValue;
var monthGovernor;
var dailyRate;

var transfer;
var proRateDues;
var currentMonthlyProrate;
var procFeeEft;
var newMonthlyPayment;   
var initialFeesEft;
var monthlyPayment;
var openEnded;
var initiationFee;
var totalMonthlyServices;

var newTotalPifServices;
var procFeePif;
var newPifGrandTotal;
var currentPifProrateTotal;
var newCurrentPifGrandTotal;
var currentMonthlyProrateTotal;
var currentMonthlyPayment;
var newServicesTotal;
var newRenewalRateTotal;
var newMemberFee;
var currentRenewTotal;
var minimumTotalDue;
var todaysPayment;
var balanceDue;
var balanceDueDate;
var groupTypeInfoArray;
var nameAddressArray;
var contractKey;
var groupType;
var serviceTerm;

//get the contract type
var contractType = document.form1.service_status.value;

//get the group type
var groupType = document.form1.group_type.value;

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;
var groupNumber =  document.form1.group_number.value;       //this is the original number of members
      groupNumber = parseInt(groupNumber);
var newMembers = document.form1.mem_num.value;
      if(newMembers == "") {
         newMembers = 0;
        }
      newMembers = parseInt(newMembers);

//vars for for loops
var length;
var j = 0;
var k = 1;
var l = 2;

switch(groupType)  {
case 'S':
 length = singleLength;
 priceField = compPattern + groupType +k;
break;
case 'F':
 length = familyLength;
 priceField = compPattern + groupType +k;
break;
case 'B':
 length = businessLength;
 priceField = compPattern + groupType +k;
break;
case 'O':
 length = organizationLength;
 priceField = compPattern + groupType +k;
break;  
}

//-----------------------------------------------------------------------------------------------------------------------------------
//loop through the summary divs

for (var i=1; i <= length; i++) {

                    var sumId = i + groupType;
                    //get existing elements
                    var searchString = document.getElementById(sumId).innerHTML;
         
          if(searchString != "")  {
          //alert(priceField+' j '+j+' sum '+sumId+' i '+i);     
                   priceField = priceField.replace(/\d+/, '');
                  // priceField = priceField.replace(/0/, '');
                   //myString = searchString.replace(/\D/g,'');
                //   alert(priceField+' '+i);   
                   var priceField = priceField +  i;
                   priceField = priceField.trim();    
                        //       alert(priceField+' '+i);   
                   serviceCost = document.form1.elements[priceField][j].value;
                   serviceCost = parseFloat(serviceCost);
                   renewalValue = document.form1.elements[priceField][k].value;
                   renewalValue = parseFloat(renewalValue);
                   adjustedRate = document.form1.elements[priceField][l].value;
                   
                   //create the original service cost val based on the number of members
                   unitServiceValue = serviceCost / groupNumber;
                   newServiceValue = unitServiceValue * newMembers;
                   originalServiceValue = newServiceValue + serviceCost;
                   originalServiceValue = originalServiceValue.toFixed(2);
                   
                   //create the renewal val based on the number of members
                   unitRenewalValue = renewalValue / groupNumber;
                   newRenewalValue = unitRenewalValue * newMembers;
                   renewalValue = newRenewalValue + renewalValue;
                   renewalValue = renewalValue.toFixed(2);
                  
                  //sets up for classes
                   if(isNaN(renewalValue)) {
                      renewalValue = 'NA';
                     }
                   
                   
                 var servicePattern = /Month/g;
                 var currentTable= document.getElementById(sumId);
                 var tagHousing = currentTable.getElementsByTagName('td');
                 var currentProductType = tagHousing[0].innerHTML;
                 var currentProductDuration = tagHousing[1].innerHTML;
                 var currentProductCost = tagHousing[2].innerHTML;
                                          
               //       currentProductType = currentProductType.replace("</span>", ""); 
              //        currentProductTypeArray = currentProductType.split('<span class="white">');               
             //         currentProductType = currentProductTypeArray[0];               
            //    var productId = currentProductTypeArray[1];
                
                
                    var rx = new RegExp("</span>","i");
                    var rx2 = new RegExp("<span .*?>","i");
                          currentProductType = currentProductType.replace(rx, "");
                          currentProductType = currentProductType.replace(rx2, "|");
                    var currentProductTypeArray = currentProductType.split('|');
                    var currentProductType = currentProductTypeArray[0];
                    var productId = currentProductTypeArray[1];
                    
                    
                
                var serviceMonthResult = servicePattern.test(currentProductDuration);
                      if(serviceMonthResult  == true)   {
                         monthPattern = true;
                         serviceCost = adjustedRate;                         
                        }
                
                monthGovernor = document.form1.month_governor.value;
                
                
                productListArray += (currentProductType+ '|'+monthGovernor+'|'+originalServiceValue+ '|' +renewalValue+ '|' +serviceCost+ '|' +currentProductDuration+ '|' +currentProductCost+ '|' +productId+ '@');
                
                }   
                 
 }
 
//-----------------------------------------------------------------------------------------------------------------------------------
//if ther are additional members we process here

var currentProRateArray ="";


if(newMembers > 0) {

var serviceValueArray;
var serviceKey;
var currentProRate;

var fieldLength = document.form1.field_count.value;
      fieldLength = parseInt(fieldLength);
var dayRateArray = document.form1.daily_rate_array.value;
      dayRateArray = dayRateArray.split("|");

                  if(fieldLength > 1) {

                       for (var i=0; i < fieldLength; i++) {
                               currentProRate =  document.form1.elements['pro[]'][i].value;
                               serviceValueArray = dayRateArray[i];
                               serviceValueArray = serviceValueArray.split(" ");
                               dailyRate = serviceValueArray[0];
                               serviceKey = serviceValueArray[4];
                               serviceTerm = serviceValueArray[5];
                               currentProRateArray += (currentProRate+ '|' +serviceKey+ '|' +serviceTerm+ '|' +dailyRate+ '@');                                  
                             }

                       }else{
                           currentProRate =  document.form1.elements['pro[]'].value; 
                           serviceValueArray = dayRateArray[0];
                           serviceValueArray = serviceValueArray.split(" ");
                           dailyRate = serviceValueArray[0];
                           serviceKey = serviceValueArray[4];
                           serviceTerm = serviceValueArray[5];
                           currentProRateArray = (currentProRate+ '|' +serviceKey+ '|' +serviceTerm+ '|' +dailyRate+ '@');
                       }
                       
                     //  alert(serviceValueArray);

}
//---------------------------------------------------------------------------------------------------------------------------------
//get the transferable values
var transfer = document.form1.trans.value;

   
//---------------------------------------------------------------------------------------------------------------------------------
//get the month to month service fees if they exist
if(document.form1.total_fees_monthly.value != "") {

    proRateDues = document.form1.pro_rate_fee.value;
    procFeeEft = document.form1.process_fee_eft.value;
    //this shows what is due immediately, includes process fee and the pro rate amount 
    initialFeesEft = document.form1.total_fees_monthly.value;   //tese are the combined fees and prorates for both current and new monthly services    
    monthlyPayment = document.form1.monthly_payment.value;
    newMonthlyPayment = document.form1.new_monthly_payment.value;
    currentMonthlyProrate = document.form1.month_prorate_total2.value;
    
   //total for monthly services
   totalMonthlyServices =  document.getElementById('serve_month').innerHTML;

    //check to see if open ended is checked since it deletes a down payment
     if(document.form1.open_end.checked == true)   {
       openEnded = "O";
       initiationFee = document.form1.init_fee.value;
      }else{
       openEnded = "T";
       initiationFee = "0";
      }
  
}

//----------------------------------------------------------------------------------------------------------------------------------
//now get paid in full if exists
if(document.form1.grand_total_pif2.value != "")    {

   newTotalPifServices = document.form1.pre_paid_service.value;
   procFeePif = document.form1.process_fee_pif.value;
   
   //this shows the total in services and the processing fee;
   newPifGrandTotal = document.form1.grand_total_pif.value;
   
   //existing services prorate
   currentPifProrateTotal = document.form1.prorate_pif_total.value;
   
   newCurrentPifGrandTotal  = document.form1.grand_total_pif2.value;
   
}
//-----------------------------------------------------------------------------------------------------------------------------------
//now we look to get the services and renewal total etc
currentRenewTotal = document.getElementById('current_renew_total').innerHTML;
currentMonthlyPayment = document.getElementById('current_month_payment').innerHTML;
newMemberFee = document.form1.member_fee.value;
newServicesTotal = document.getElementById('serve_total').innerHTML;
newRenewalRateTotal = document.getElementById('ren_total').innerHTML;
minimumTotalDue = document.getElementById('serve_total_due').innerHTML;
todaysPayment = document.form1.today_payment.value;
balanceDue = document.form1.balance_due.value;
balanceDueDate = document.form1.due_date.value;
contractKey = document.form1.upgrade_contract_key.value;
groupType = document.form1.group_type.value;
newUpgradeServiceKey = document.form1.new_upgrade_service_key.value;
var sig = document.form1.input_name.value;

 if(sig == '')  {
                    var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }
//-------------------------------------------------------------------------------------------------------------------------------------
var firstName = document.form1.first_name.value;
var middleName = document.form1.middle_name.value;
var lastName = document.form1.last_name.value;
var groupName = document.form1.group_name.value;
//-------------------------------------------------------------------------------------------------------------------------------------
//alert(newMembers);

//fields for ajax
groupInfoArray = encodeURIComponent(groupInfoArray);
addressInfoArray = encodeURIComponent(addressInfoArray);  
productListArray = encodeURIComponent(productListArray);
newMembers = encodeURIComponent(newMembers);
currentProRateArray = encodeURIComponent(currentProRateArray);
transfer = encodeURIComponent(transfer);
proRateDues = encodeURIComponent(proRateDues);
procFeeEft = encodeURIComponent(procFeeEft);
initialFeesEft = encodeURIComponent(initialFeesEft);
monthlyPayment = encodeURIComponent(monthlyPayment);
newMonthlyPayment = encodeURIComponent(newMonthlyPayment);
currentMonthlyProrate = encodeURIComponent(currentMonthlyProrate);
totalMonthlyServices = encodeURIComponent(totalMonthlyServices);
openEnded = encodeURIComponent(openEnded);
initiationFee = encodeURIComponent(initiationFee);
newTotalPifServices = encodeURIComponent(newTotalPifServices);
procFeePif = encodeURIComponent(procFeePif);
newPifGrandTotal = encodeURIComponent(newPifGrandTotal);
currentPifProrateTotal = encodeURIComponent(currentPifProrateTotal);
newCurrentPifGrandTotal = encodeURIComponent(newCurrentPifGrandTotal);
currentRenewTotal = encodeURIComponent(currentRenewTotal);
currentMonthlyPayment = encodeURIComponent(currentMonthlyPayment);
newMemberFee = encodeURIComponent(newMemberFee);
newServicesTotal = encodeURIComponent(newServicesTotal);
newRenewalRateTotal = encodeURIComponent(newRenewalRateTotal);
minimumTotalDue = encodeURIComponent(minimumTotalDue);
todaysPayment = encodeURIComponent(todaysPayment);
balanceDue = encodeURIComponent(balanceDue);
balanceDueDate = encodeURIComponent(balanceDueDate);
contractKey = encodeURIComponent(contractKey);
groupType = encodeURIComponent(groupType);
groupNumber = encodeURIComponent(groupNumber);
firstName = encodeURIComponent(firstName);
middleName = encodeURIComponent(middleName);
lastName = encodeURIComponent(lastName);
groupName = encodeURIComponent(groupName);
monthlyBillingType = encodeURIComponent(monthlyBillingType);
newUpgradeServiceKey = encodeURIComponent(newUpgradeServiceKey);

 
var parameters = "";
parameters = parameters+'group_info_array='+groupInfoArray;
parameters = parameters+'&address_info_array='+addressInfoArray;
parameters = parameters+'&product_list_array='+productListArray;
parameters = parameters+'&new_members='+newMembers;
parameters = parameters+'&current_prorate_array='+currentProRateArray;
parameters = parameters+'&transfer='+transfer;
parameters = parameters+'&pro_rate_dues='+proRateDues;
parameters = parameters+'&proc_fee_eft='+procFeeEft;
parameters = parameters+'&initial_fees_eft='+initialFeesEft;
parameters = parameters+'&monthly_payment='+monthlyPayment;
parameters = parameters+'&new_monthly_payment='+newMonthlyPayment;
parameters = parameters+'&current_monthly_prorate='+currentMonthlyProrate;
parameters = parameters+'&total_monthly_services='+totalMonthlyServices;
parameters = parameters+'&open_ended='+openEnded;
parameters = parameters+'&initiation_fee='+initiationFee;
parameters = parameters+'&new_total_pif_services='+newTotalPifServices;
parameters = parameters+'&proc_fee_pif='+procFeePif;
parameters = parameters+'&new_pif_grand_total='+newPifGrandTotal;
parameters = parameters+'&current_pif_prorate_total='+currentPifProrateTotal;
parameters = parameters+'&new_current_pif_grand_total='+newCurrentPifGrandTotal;
parameters = parameters+'&current_renew_total='+currentRenewTotal;
parameters = parameters+'&current_monthly_payment='+currentMonthlyPayment;
parameters = parameters+'&new_member_fee='+newMemberFee;
parameters = parameters+'&new_services_total='+newServicesTotal;
parameters = parameters+'&new_renewal_rate_total='+newRenewalRateTotal;
parameters = parameters+'&minimum_total_due='+minimumTotalDue;
parameters = parameters+'&todays_payment='+todaysPayment;
parameters = parameters+'&balance_due='+balanceDue;
parameters = parameters+'&balance_due_date='+balanceDueDate;
parameters = parameters+'&contract_key='+contractKey;
parameters = parameters+'&group_type='+groupType;
parameters = parameters+'&group_number='+groupNumber;
parameters = parameters+'&first_name='+firstName;
parameters = parameters+'&middle_name='+middleName;
parameters = parameters+'&last_name='+lastName;
parameters = parameters+'&group_name='+groupName;
parameters = parameters+'&monthly_billing_type='+monthlyBillingType;
parameters = parameters+'&new_upgrade_service_key='+newUpgradeServiceKey;
parameters = parameters+'&sig='+sig;
//get ajax request object  and send the params to the form object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "createUpgradeObject.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
             //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {   
                           document.form1.print_switch.value = 1;
                           setTimeout('openUpgradeContractWindow()', 1000);
                           }else{
                           alert('There was an error printing this contract: '+successKey);
                           return false;                         
                           }                                                
             }
}
//========================================


}







