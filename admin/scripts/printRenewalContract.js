function openRenewalContractWindow()  {
//alert('Open Contract Window'); 
document.form1.contract_bit.value = 1;

window.open('renewalContractWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
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
//--------------------------------------------------------------------------------------------------------
function checkEarly()  {

var earlyRenew = 'early'+j;    
var earlyValue;
try
  {
  earlyValue = document.getElementById('early1[]').value;
  }
catch(e)
  {
  earlyValue = "NA";
  }
//alert(earlyValue);
return earlyValue;

}
//===========================================================
function printRenewContract(thisName, thisField)  {

//first check to make sure all of the perspective fields are filled out
var bool;
bool = checkServices(thisName,thisField);
if(bool == false)  {
  return false;
}

//-------------------------------------------------------------------------------------------------------
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

//---------------------------------------------------------------------------------------------------------------------------------------
//this checks to see if any of the check boxes have been checked before submitting and get the value
var i;
this.j =1;
var standardRenew;
var standardValue = 0;
var earlyValue;
var serviceKey;
var productListArray = "";
var commissionField;
var commissionCredit;


var diffServiceKey = document.form1.service_name_drop.value;
var earlyTest = document.form1.early_test.value;
//alert(earlyTest);
//alert(bool);
/* if (typeof document.form1.elements['renew[]'].length != 'undefined') {

                 for (i=0; i< document.form1.elements['renew[]'].length; i++) {
                           if (document.form1.elements['renew[]'][i].checked) {                           
                                serviceKey = document.form1.elements['renew[]'][i].value; 
                                commissionField = 'commission_credit'+j;
                                commissionCredit = document.getElementById(commissionField).value;
                                standardRenew = 'standard'+j;                               
                                standardValue = document.getElementById(standardRenew).value;                              
                                earlyValue = checkEarly();        
                                productListArray += (serviceKey+ '|' +standardValue+ '|' +earlyValue+ '|' +commissionCredit+ '#');                                                                 
                             }                             
                         j++;
                      }*/
      if (earlyTest == 1)  {                                    
                     if (document.getElementById('renew1').checked) {                            
                            serviceKey = document.getElementById('renew1').value; 
                            //alert('init early '+serviceKey);
                            if (serviceKey != diffServiceKey){
                                var oldKey = serviceKey;
                                var changedServiceBool = 1;
                                serviceKey = diffServiceKey;
                            }else{
                               var changedServiceBool = 0; 
                            }
                            //alert('after '+serviceKey); 
                            standardValue = document.getElementById('early1').value;
                            commissionCredit = document.getElementById('commission_credit1').value;
                            earlyValue = checkEarly();                           
                            productListArray = (serviceKey+ '|' +standardValue+ '|' +earlyValue+ '|' +commissionCredit+ '#');  
                          }      
      }else{

                       if (document.getElementById('renew1').checked) {                            
                            serviceKey = document.getElementById('renew1').value; 
                           // alert('init stan '+serviceKey);
                            if (serviceKey != diffServiceKey){
                                var oldKey = serviceKey;
                                var changedServiceBool = 1;
                                serviceKey = diffServiceKey;
                            }else{
                               var changedServiceBool = 0; 
                            }
                            //alert('after '+serviceKey);                            
                            standardValue = document.getElementById('standard1').value;
                            commissionCredit = document.getElementById('commission_credit1').value;
                            earlyValue = checkEarly();                           
                            productListArray = (serviceKey+ '|' +standardValue+ '|' +earlyValue+ '|' +commissionCredit+ '#');  
                          }
      }
     // alert(productListArray);
    //  alert('old '+oldKey);
     // alert('bool '+changedServiceBool)
       //alert('fu');
//-------------------------------------------------------------------------------------------------------------------------------------                 
//get the contract id total amount and renew fees
var contractKey = document.form1.renewal_contract_key.value;
var renewalFee = document.form1.renewal_fee.value;
var serviceTotal = document.form1.service_total.value;
var grandTotal = document.form1.grand_total.value;
var todaysPayment = document.form1.today_payment.value;
var balanceDue = document.form1.balance_due.value;
var balanceDueDate = document.form1.due_date.value;
var pifOutBool = document.form1.pif_out_bool.value;
var pifOutTime = document.form1.pif_out_time.value;
var pifOutMoneyOwed = document.form1.pif_out_money_owed.value;
var pastDueAmount = document.form1.past_due_amount.value;
var yearQuantity = document.form1.year_quantity.value;
var sig = document.form1.input_name.value;

 if(sig == '')  {
                    var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }
//alert(yearQuantity);
//-------------------------------------------------------------------------------------------------------------------------------------
var firstName = document.form1.first_name.value;
var middleName = document.form1.middle_name.value;
var lastName = document.form1.last_name.value;
//-------------------------------------------------------------------------------------------------------------------------------------
//for group types
var groupType = document.form1.group_type.value;
var groupName = document.form1.group_name.value;

//-------------------------------------------------------------------------------------------------------------------------------------
//fields for ajax
groupInfoArray = encodeURIComponent(groupInfoArray);
addressInfoArray = encodeURIComponent(addressInfoArray);  
productListArray = encodeURIComponent(productListArray);
contractKey = encodeURIComponent(contractKey);
renewalFee = encodeURIComponent(renewalFee);
serviceTotal = encodeURIComponent(serviceTotal);
grandTotal = encodeURIComponent(grandTotal);
todaysPayment = encodeURIComponent(todaysPayment); 
balanceDue = encodeURIComponent(balanceDue);
balanceDueDate = encodeURIComponent(balanceDueDate);
firstName = encodeURIComponent(firstName);
middleName = encodeURIComponent(middleName);
lastName = encodeURIComponent(lastName);
groupType = encodeURIComponent(groupType);
groupName = encodeURIComponent(groupName);
pifOutBool = encodeURIComponent(pifOutBool);
pifOutTime = encodeURIComponent(pifOutTime);
pifOutMoneyOwed = encodeURIComponent(pifOutMoneyOwed);
pastDueAmount = encodeURIComponent(pastDueAmount);
yearQuantity = encodeURIComponent(yearQuantity);
oldKey = encodeURIComponent(oldKey);
changedServiceBool = encodeURIComponent(changedServiceBool);


 
var parameters = "";
parameters = parameters+'group_info_array='+groupInfoArray;
parameters = parameters+'&address_info_array='+addressInfoArray;
parameters = parameters+'&product_list_array='+productListArray;
parameters = parameters+'&contract_key='+contractKey;
parameters = parameters+'&renewal_fee='+renewalFee;
parameters = parameters+'&service_total='+serviceTotal;
parameters = parameters+'&grand_total='+grandTotal;
parameters = parameters+'&todays_payment='+todaysPayment;
parameters = parameters+'&balance_due='+balanceDue;
parameters = parameters+'&balance_due_date='+balanceDueDate;
parameters = parameters+'&first_name='+firstName;
parameters = parameters+'&middle_name='+middleName;
parameters = parameters+'&last_name='+lastName;
parameters = parameters+'&group_type='+groupType;
parameters = parameters+'&group_name='+groupName;
parameters = parameters+'&pif_out_bool='+pifOutBool;
parameters = parameters+'&pif_out_time='+pifOutTime;
parameters = parameters+'&pif_out_money_owed='+pifOutMoneyOwed;
parameters = parameters+'&past_due_amount='+pastDueAmount;
parameters = parameters+'&year_quantity='+yearQuantity;

parameters = parameters+'&old_key='+oldKey;
parameters = parameters+'&changed_service_bool='+changedServiceBool;
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
xmlHttp.open("POST", "createRenewalObject.php", true);
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
                           setTimeout('openRenewalContractWindow()', 1000);
                           }else{
                           alert('There was an error printing this contract');
                           return false;                         
                           }                                                
             }
}
//========================================

}







