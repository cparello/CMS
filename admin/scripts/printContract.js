function openLiabiltyWindow()  {

window.open('liabilityWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//---------------------------------------------------------------------
function openContractWindow()  {
//alert('Open Contract Window'); 
window.open('contractWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//---------------------------------------------------------------------
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

//---------------------------------------------------------------------
function checkDobs(dobValue, dobIndex)  {

var dobName = document.getElementById(dobIndex);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   document.getElementById(dobIndex).value ="";
   dobName.focus();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        document.getElementById(dobIndex).value ="";
        dobName.focus();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         document.getElementById(dobIndex).value ="";
         dobName.focus();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   document.getElementById(dobIndex).value ="";
                                   dobName.focus();                                  
                                   return false;                                                                   
                                  }       
        }
      
            
      
   }

}
//-------------------------------------------------------------------------------------------------------------------------
function checkEmails(emailValue, emailIndex)  {

var fieldName = document.getElementById(emailIndex);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          document.getElementById(emailIndex).value ="";
          fieldName.focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailIndex).value ="";
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailIndex).value ="";
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(emailIndex).value ="";
          fieldName.focus();
		   return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailIndex).value ="";
            fieldName.focus();
		    return false;		 
         }

}
//---------------------------------------------------------------------------------------------------------
function checkZipCodes(zipValue, zipIndex)  {

var zipName = document.getElementById(zipIndex);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');
   document.getElementById(zipIndex).value = "";
   zipName.focus();
   return false;
}
if(zipValue.length < 5) {
  alert('The Zip Code you entered is too short');
  document.getElementById(zipIndex).value = "";
  zipName.focus();
  return false;
}

}

//--------------------------------------------------------------------------------------------------------
function checkPhoneNumbers(phoneValue, phoneIndex)  {

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneIndex).value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneIndex).value = "";
               document.getElementById(phoneIndex).focus();
               return false;
    }
    
    
}

//----------------------------------------------------------------------------------------------------------
function getNumberOfMembers()   {

              var memberNumber = document.form1.mem_num.value;
                    if(memberNumber == "") {
                      memberNumber = 1;
                     }
              return memberNumber;
}
//---------------------------------------------------------------------------------------------------------
function getGroupInformation()  {

var typeName;
var typeAddress;
var typePhone;
var typeArray;
      typeName = document.getElementById('type_name').value;
      typeAddress = document.getElementById('type_address').value;
      typePhone = document.getElementById('type_phone').value;
      
      //if a pound sign is used for an apt etc, replace with num
      typeAddress = typeAddress.replace(/#/g, "Num");
      
      typeArray = (typeName+ '|' +typeAddress+ '|' +typePhone);
      
      typeArray = typeArray.replace(/#/g, "");
      
      return typeArray;

}
//--------------------------------------------------------------------------------------------------------
function getNameAdress(nameSalt) {

var firstName = 'first_name'+nameSalt;
var middleName = 'middle_name'+nameSalt;
var lastName = 'last_name'+nameSalt;
var streetAddress = 'street_address'+nameSalt;
var cityName = 'city'+nameSalt;
var stateName = 'state'+nameSalt;
var zipCodeNumber = 'zip_code'+nameSalt;
var homePhoneNumber = 'home_phone'+nameSalt;
var cellPhoneNumber = 'cell_phone'+nameSalt;
var emailAddress = 'email'+nameSalt;
var dobDate = 'dob'+nameSalt;
var licNumber = 'lic_num'+nameSalt;

var first = document.getElementById(firstName).value;
var middle = document.getElementById(middleName).value;
var last = document.getElementById(lastName).value;
var street = document.getElementById(streetAddress).value;
var city = document.getElementById(cityName).value;
var state = document.getElementById(stateName).value;
var zipCode = document.getElementById(zipCodeNumber).value;
var homePhone = document.getElementById(homePhoneNumber).value;
var cellPhone = document.getElementById(cellPhoneNumber).value;
var email = document.getElementById(emailAddress).value;
var dob = document.getElementById(dobDate).value;
var license= document.getElementById(licNumber).value;

//if a pound sign is used for an apt etc, replace with num
street = street.replace(/#/g, "Num");

var nameAddArray = (first+'|'+middle+'|'+last+'|'+street+'|'+city+'|'+state+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+email+'|'+dob+'|'+license);

//for all others replace pound with null
nameAddArray = nameAddArray.replace(/#/g, "");



return nameAddArray;

}
//--------------------------------------------------------------------------------------------------------
function printContract(thisName, thisField)  {

this.monthlyBillingType = "";

//first check to make sure all of the perspective fields are filled out
var bool;
bool = checkServices(thisName,thisField);
if(bool == false)  {
  return false;
}



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


var keySwitch;
var contractKey = document.form1.contract_key.value;
//check to see if a contract key has been generated then create a switch if a new key is needed
//alert(contractKey);
if(contractKey  == "") {
   keySwitch = 0;
   }else{
   keySwitch = 1;
   }

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;

var length;
var compPattern = 'comp';
var priceField;
var productListArray = "";
var monthPattern;
var renewalValue;
var serviceCost;
var j = 1;
var k = 0;
var memberNumbers;
var transfer;
var proRateDues;
var procFeeEft;
var downPayment;
var downPaymentMonthly
var initialFeesEft;
var monthlyPayment;
var openEnded;
var initiationFee;
var totalMonthlyServices;
var totalPifServices;
var procFeePif;
var pifGrandTotal;
var servicesTotal;
var renewalRateTotal;
var minimumTotalDue;
var todaysPayment;
var balanceDue;
var balanceDueDate;
var groupTypeInfoArray;
var nameAddressArray;
var libHost;
var contractType;

//get the contract type
contractType = document.form1.service_status.value;

//get the group type
var groupType = document.form1.group_type.value;


switch(groupType)  {
case 'S':
 length = singleLength;
 priceField = compPattern + groupType +j;
 memberNumbers = 1;
 groupTypeInfoArray = 'NA|NA|NA';
break;
case 'F':
 length = familyLength;
 priceField = compPattern + groupType +j;
 memberNumbers = getNumberOfMembers();
 groupTypeInfoArray = 'NA|NA|NA';
break;
case 'B':
 length = businessLength;
 priceField = compPattern + groupType +j;
 memberNumbers = getNumberOfMembers();
 groupTypeInfoArray = getGroupInformation();
break;
case 'O':
 length = organizationLength;
 priceField = compPattern + groupType +j;
 memberNumbers = getNumberOfMembers();
 groupTypeInfoArray = getGroupInformation();
break;  
}

//alert(priceField);\d

for (var i=1; i <= length; i++) {

                    var sumId = i + groupType;
                    //get existing elements
                    var searchString = document.getElementById(sumId).innerHTML;
         
          if(searchString != "")  {
                      
                   priceField = priceField.replace(/\d+/, i);                
                   serviceCost = document.form1.elements[priceField][k].value;                  
                   renewalValue = document.form1.elements[priceField][j].value;
                   
                 var servicePattern = /Month/g;
                 var currentTable= document.getElementById(sumId);
                 var tagHousing = currentTable.getElementsByTagName('td');
                 var currentProductTypeHouse = tagHousing[0].innerHTML;
                 var currentProductDuration = tagHousing[1].innerHTML;
                 var currentProductCost = tagHousing[2].innerHTML;
                                                                                   
                         
                    var rx = new RegExp("</span>","i");
                    var rx2 = new RegExp("<span .*?>","i");
                          currentProductTypeHouse = currentProductTypeHouse.replace(rx, "");
                          currentProductTypeHouse = currentProductTypeHouse.replace(rx2, "|");
                    var currentProductTypeArray = currentProductTypeHouse.split('|');
                    var currentProductType = currentProductTypeArray[0];
                    var productId = currentProductTypeArray[1];
                     
                     
                var serviceMonthResult = servicePattern.test(currentProductDuration);
                      if(serviceMonthResult  == true)   {
                         monthPattern = true;
                        }
                
                productListArray += (currentProductType+ '|' +renewalValue+ '|' +serviceCost+ '|' +currentProductDuration+ '|' +currentProductCost+ '|' +productId+ '@');
                
                }   
                 
 }


//get the transferable values
   if(document.form1.trans[0].checked == true) {
    transfer = "N";
   }
   if(document.form1.trans[1].checked == true) {
    transfer = "Y";
   }
   if(document.form1.trans[1].checked == false && document.form1.trans[0].checked == false) {
    transfer = "N";
   }

//get the month to month service fees if they exist
if(document.form1.total_fees_monthly.value != "") {

    proRateDues = document.form1.pro_rate_fee.value;
    procFeeEft = document.form1.process_fee_eft.value;
    downPaymentMonthly = document.form1.down_pay.value;
    //this shows what is due immediately, includes process fee and the pro rate amount 
    initialFeesEft = document.form1.total_fees_monthly.value;       
    monthlyPayment = document.form1.monthly_payment.value;
    
   //total for monthly services
   totalMonthlyServices =  document.getElementById('serve_month').innerHTML;

    //check to see if open ended is checked since it deletes a down payment
     if(document.form1.open_end.checked == true)   {
       openEnded = "O";
       initiationFee = document.form1.init_fee.value;
       downPaymentMonthly = "0";
      }else{
       openEnded = "T";
       initiationFee = "0";
      }
  
}

//now get paid in full if exists
if(document.form1.grand_total_pif.value != "")    {
   totalPifServices = document.form1.pre_paid_service.value;
   procFeePif = document.form1.process_fee_pif.value;
   //this shows the total in services and the processing fee
   pifGrandTotal = document.form1.grand_total_pif.value;
}

//now we look to get the services and renewal total etc
servicesTotal = document.getElementById('serve_total').innerHTML;
renewalRateTotal = document.getElementById('ren_total').innerHTML;
minimumTotalDue = document.getElementById('serve_total_due').innerHTML;
todaysPayment = document.form1.today_payment.value;
balanceDue = document.form1.balance_due.value;
balanceDueDate = document.form1.due_date.value;
var datePicker =  document.form1.datepicker.value;
var sig = document.form1.input_name.value;

 if(sig == '')  {
                    var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }
//alert(sig);
var nameSalt;
//now get the address and name info
  if(document.form1.liability_host.checked == true)   {
    libHost = 'L';
    nameSalt = '_lib';
    nameAddressArray = getNameAdress(nameSalt);
    }else{
    nameSalt = 1;
    nameAddressArray = getNameAdress(nameSalt);
    libHost = 'M';
    }


//fields for ajax

groupType = encodeURIComponent(groupType);
productListArray = encodeURIComponent(productListArray);  //list of products selectd
memberNumbers = encodeURIComponent(memberNumbers);
transfer = encodeURIComponent(transfer); //a bool value yes or no. must change to "Y" and "N" for db insert
proRateDues = encodeURIComponent(proRateDues);
procFeeEft = encodeURIComponent(procFeeEft);
downPaymentMonthly = encodeURIComponent(downPaymentMonthly);
initialFeesEft = encodeURIComponent(initialFeesEft);  //these are the one time fees that are charged for month to month service
monthlyPayment = encodeURIComponent(monthlyPayment);
totalMonthlyServices = encodeURIComponent(totalMonthlyServices);
openEnded = encodeURIComponent(openEnded);  
initiationFee = encodeURIComponent(initiationFee);
totalPifServices = encodeURIComponent(totalPifServices);
procFeePif = encodeURIComponent(procFeePif);
pifGrandTotal = encodeURIComponent(pifGrandTotal);
servicesTotal = encodeURIComponent(servicesTotal);
renewalRateTotal = encodeURIComponent(renewalRateTotal);
minimumTotalDue = encodeURIComponent(minimumTotalDue);
todaysPayment = encodeURIComponent(todaysPayment);
balanceDue = encodeURIComponent(balanceDue);
balanceDueDate = encodeURIComponent(balanceDueDate);
groupTypeInfoArray = encodeURIComponent(groupTypeInfoArray);
nameAddressArray = encodeURIComponent(nameAddressArray);
libHost = encodeURIComponent(libHost);
monthlyBillingType = encodeURIComponent(monthlyBillingType);
datePicker = encodeURIComponent(datePicker);
//sig = encodeURIComponent(sig);
//alert(sig);

var parameters = "";
parameters = parameters+'group_type='+groupType;
parameters = parameters+'&product_list_array='+productListArray;
parameters = parameters+'&mem_num='+memberNumbers;
parameters = parameters+'&trans='+transfer;
parameters = parameters+'&pro_rate_fee='+proRateDues;
parameters = parameters+'&process_fee_eft='+procFeeEft;
parameters = parameters+'&down_pay='+downPaymentMonthly;
parameters = parameters+'&total_fees_monthly='+initialFeesEft;
parameters = parameters+'&monthly_payment='+monthlyPayment;
parameters = parameters+'&serve_month='+totalMonthlyServices;
parameters = parameters+'&open_end='+openEnded;     //this will set in the form as a value of "1" if checked . converted to yes or no in the JS script
parameters = parameters+'&init_fee='+initiationFee;
parameters = parameters+'&pre_paid_service='+totalPifServices;
parameters = parameters+'&process_fee_pif='+procFeePif;
parameters = parameters+'&grand_total_pif='+pifGrandTotal;
parameters = parameters+'&serve_total='+servicesTotal;
parameters = parameters+'&ren_total='+renewalRateTotal;
parameters = parameters+'&serve_total_due='+minimumTotalDue;
parameters = parameters+'&today_payment='+todaysPayment;
parameters = parameters+'&balance_due='+balanceDue;
parameters = parameters+'&due_date='+balanceDueDate;
parameters = parameters+'&group_type_info_array='+groupTypeInfoArray;
parameters = parameters+'&name_address_array='+nameAddressArray;
parameters = parameters+'&liability_host='+libHost;  //value is 1 if checked saved as yes if chck no if not
parameters = parameters+'&service_status='+contractType; 
parameters = parameters+'&key_switch='+keySwitch;    //used to get a contract id nuber if needed
parameters = parameters+'&contract_key='+contractKey; 
parameters = parameters+'&monthly_billing_type='+monthlyBillingType; 
parameters = parameters+'&datepicker='+datePicker; 
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
xmlHttp.open("POST", "createSalesObject.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var contractKey =  xmlHttp.responseText;
                                        
                           //set the contract key in the hidden variable and the print switch
                           document.form1.contract_key.value = contractKey;
                           document.form1.print_switch.value = 1;
                           
                     setTimeout('openContractWindow()', 1000);                     
             }
}
//========================================

}

//------------------------------------------------------------------------------------------------------------------------------
function printLiabilityForm(index)  {

index = parseInt(index);
var fieldFocus = index + 1;

var firstName;
var lastName;
var streetAddress;
var cityName;

var stateName;
var stateValue;
var optionIndex;
var stateOption;

var zipCode;
var primaryPhone;
var cellPhone;
var emailAddress;
var birthDate;
var licenseNumber;

var emgName;
var emgRelation;
var emgPhone;

var zipIndex;
var phoneIndex;
var emailIndex;
var dobIndex;
var bool;



        var firstNameArray = document.getElementsByName('first_name[]');
        var middleNameArray = document.getElementsByName('middle_name[]');
        var lastNameArray = document.getElementsByName('last_name[]');
        var streetAddressArray = document.getElementsByName('street_address[]');
        var cityNameArray = document.getElementsByName('city[]');
        var stateNameArray = document.getElementsByName('state[]');
        var zipCodeArray = document.getElementsByName('zip_code[]');
        var homePhoneArray = document.getElementsByName('home_phone[]');
        var cellPhoneArray = document.getElementsByName('cell_phone[]');
        var emailAddressArray = document.getElementsByName('email[]');
        var birthDateArray = document.getElementsByName('dob[]');
        var licenseNumberArray = document.getElementsByName('lic_num[]');
        var emgNameArray = document.getElementsByName('econt_name[]');
        var emgRelationArray = document.getElementsByName('econt_relation[]');
        var emgPhoneArray = document.getElementsByName('econt_phone[]');

   firstName = firstNameArray[index].value;
   middleName = middleNameArray[index].value;
   lastName = lastNameArray[index].value;
   streetAddress = streetAddressArray[index].value;
   cityName = cityNameArray[index].value;
   
   optionIndex = stateNameArray[index].selectedIndex;
   stateName = stateNameArray[index].options[optionIndex].text;
   stateValue = stateNameArray[index].value; 
   
   zipCode = zipCodeArray[index].value;
   primaryPhone = homePhoneArray[index].value;
   cellPhone = cellPhoneArray[index].value;
   emailAddress = emailAddressArray[index].value;
   birthDate = birthDateArray[index].value;
   licenseNumber = licenseNumberArray[index].value;
   
   emgName = emgNameArray[index].value;
   emgRelation = emgRelationArray[index].value;
   emgPhone = emgPhoneArray[index].value;
   
//Make sure the contract form has been printed
var printSwitch = document.form1.print_switch.value;
 if(printSwitch == "")  {
                 alert('Please print out the Sales Contract before submitting this form');
                        document.form1.print_contract.focus();
                         return false;                           
                        }
   

//first check to see if the proper fields have been filled out
if(firstName == "" &&  lastName == "" &&  streetAddress == "" && cityName == "" && stateValue == "" &&  zipCode == "" && primaryPhone == "" && cellPhone == "" && emailAddress == "" && birthDate == "" && licenseNumber == "" ) {
alert('Please fill out all of the Contact Information associated with this member before printing this Waiver.');
document.getElementById('first_name'+fieldFocus+'').focus();
return false;
}


if(firstName == "") {
alert('Please fill out the  First Name field');
document.getElementById('first_name'+fieldFocus+'').focus();
return false;
}

if(lastName == "") {
alert('Please fill out the Last Name field');
document.getElementById('last_name'+fieldFocus+'').focus();
return false;
}

if(streetAddress == "") {
alert('Please fill out the Street Address field');
document.getElementById('street_address'+fieldFocus+'').focus();
return false;
}

if(cityName == "") {
alert('Please fill out the City field');
document.getElementById('city'+fieldFocus+'').focus();
return false;
}

if(stateValue == "") {
alert('Please select a State');
document.getElementById('state'+fieldFocus+'').focus();
return false;
}

if(zipCode == "") {
alert('Please fill out the Zip Code field');
document.getElementById('zip_code'+fieldFocus+'').focus();
return false;
}else{
zipIndex = ('zip_code'+fieldFocus);
bool = checkZipCodes(zipCode, zipIndex);
      if(bool == false) {
        return false;
        }
}

if(primaryPhone == "") {
alert('Please fill out the Primary Phone field');
document.getElementById('home_phone'+fieldFocus+'').focus();
return false;
}else{
phoneIndex = ('home_phone'+fieldFocus);
bool = checkPhoneNumbers(primaryPhone, phoneIndex);
     if(bool == false) {
        return false;
       }
}

if(cellPhone == "") {
alert('Please fill out the Cell Phone field');
document.getElementById('cell_phone'+fieldFocus+'').focus();
return false;
}else{
phoneIndex = ('cell_phone'+fieldFocus);
bool = checkPhoneNumbers(cellPhone, phoneIndex);
     if(bool == false) {
        return false;
       }
}


if(emailAddress == "") {
alert('Please fill out the Email Address field');
document.getElementById('email'+fieldFocus+'').focus();
return false;
}else{
emailIndex =  ('email'+fieldFocus);
bool = checkEmails(emailAddress, emailIndex);
     if(bool == false) {
        return false;
       }
}

if(birthDate == "") {
alert('Please fill out the  Date of Birth field');
document.getElementById('dob'+fieldFocus+'').focus();
return false;
}else{
dobIndex =  ('dob'+fieldFocus);
bool = checkDobs(birthDate, dobIndex);
     if(bool == false) {
        return false;
       }
}


if(licenseNumber == "") {
alert('Please fill out the Drivers License field');
document.getElementById('lic_num'+fieldFocus+'').focus();
return false;
}


//emg contact info
if(emgName == "" &&  emgRelation == "" &&  emgPhone == "")  {
alert('Please fill out all of the Emergency Contact Information associated with this member before printing this Waiver.');
document.getElementById('econt_name'+fieldFocus+'').focus();
return false;
}

if(emgName == "")  {
alert('Please fill out all of the Emergency Contact Name field');
document.getElementById('econt_name'+fieldFocus+'').focus();
return false;
}

if(emgRelation == "")  {
alert('Please fill out all of the Emergency Contact Relation field');
document.getElementById('econt_relation'+fieldFocus+'').focus();
return false;
}

if(emgPhone == "")  {
alert('Please fill out all of the Emergency Contact Phone field');
document.getElementById('econt_phone'+fieldFocus+'').focus();
return false;
}else{
phoneIndex = ('econt_phone'+fieldFocus);
bool = checkPhoneNumbers(emgPhone, phoneIndex);
     if(bool == false) {
        return false;
       }
}

//below we open and print out the form
 var libNameAddArray = (firstName+'|'+middleName+'|'+lastName+'|'+streetAddress+'|'+cityName+'|'+stateValue+'|'+zipCode+'|'+primaryPhone+'|'+cellPhone+'|'+emailAddress+'|'+birthDate+'|'+licenseNumber);

var libEmgContactArray = (emgName+'|'+emgRelation+'|'+emgPhone);
var contractKey = document.form1.contract_key.value;

libNameAddArray = encodeURIComponent(libNameAddArray);
libEmgContactArray = encodeURIComponent(libEmgContactArray);

var libParameters = "";
libParameters = libParameters+'lib_address_array='+libNameAddArray;
libParameters = libParameters+'&lib_emg_contact_array='+libEmgContactArray;
libParameters = libParameters+'&contract_key='+contractKey;


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
xmlHttp.open("POST", "createLiabilityObject.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(libParameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var liabilityKey =  xmlHttp.responseText; 
                     if(liabilityKey == 1) {
                        setTimeout('openLiabiltyWindow()', 500);
                       }
             }
}
//========================================








}







