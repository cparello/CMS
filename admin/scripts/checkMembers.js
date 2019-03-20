function checkMembers(fieldName, fieldId, addSalt)   {


var firstName = document.getElementById('first_name' +addSalt).value;
var middleName = document.getElementById('middle_name' +addSalt).value;
var lastName = document.getElementById('last_name' +addSalt).value;
var streetAddress = document.getElementById('street_address' +addSalt).value;
var cityVal = document.getElementById('city' +addSalt).value;
var stateVal = document.getElementById('state' +addSalt).value;
var zipCode = document.getElementById('zip_code' +addSalt).value;
var homePhone = document.getElementById('home_phone' +addSalt).value;
var cellPhone = document.getElementById('cell_phone' +addSalt).value;
var emailVal = document.getElementById('email' +addSalt).value;
var dobVal = document.getElementById('dob' +addSalt).value;
var licNumber = document.getElementById('lic_num' +addSalt).value;
var eContName = document.getElementById('econt_name' +addSalt).value;
var eContRelation = document.getElementById('econt_relation' +addSalt).value;
var eContPhone = document.getElementById('econt_phone' +addSalt).value;
var memberId = document.getElementById('member_id' +addSalt).value;

var primaryContact = ('Member Information ' +addSalt);

//check to see if this is the submit button that has been checked
if(fieldName == 'update')  {
    if(firstName == "" && lastName == "" && streetAddress == "" && cityVal == "" && stateVal == "" && zipCode == "" && homePhone == "" && cellPhone == "" && emailVal == "" && dobVal == "" && licNumber == "" && eContName == "" && eContRelation == "" && eContPhone == "" && memberId == "") {
       alert('Please fill out all of the ' +primaryContact+ '  information fields');
       return false;
       }
  }


if(fieldName != 'first_name') {
         if(firstName == "") {
           alert('Please fill out the ' +primaryContact+ ' First Name field');
           document.getElementById('first_name' +addSalt).focus();
           return false;
           }
  }else{
  return true;
  }


if(fieldName != 'last_name') {
          if(lastName == "") {
             alert('Please fill out the ' +primaryContact+ ' Last Name field');
             document.getElementById('last_name' +addSalt).focus();
             return false;
             }
}else{
  return true;
}


if(fieldName != 'member_id') {
          if(memberId == "") {
             alert('Please fill out the ' +primaryContact+ ' Member ID field');
             document.getElementById('member_id' +addSalt).focus();
             return false;
             }
}else{
  return true;
}


if(fieldName != 'street_address') {
          if(streetAddress == "") {
            alert('Please fill out the ' +primaryContact+ ' Street Address field');
            document.getElementById('street_address' +addSalt).focus();
            return false;
            }
}else{
  return true;
}


if(fieldName != 'city') {            
          if(cityVal == "") {
           alert('Please fill out the ' +primaryContact+ ' City field');
           document.getElementById('city' +addSalt).focus();
           return false;
           }
}else{
  return true;
}
     
      
if(fieldName != 'state') {      
          if(stateVal == "") {
           alert('Please select a ' +primaryContact+ ' State');
           document.getElementById('state' +addSalt).focus();
           return false;
           } 
}else{
  return true;
}


if(fieldName != 'zip_code') {
          if(zipCode == "") {
           alert('Please fill out the ' +primaryContact+ ' Zip Code field');
           document.getElementById('zip_code' +addSalt).focus();
           return false;
           }else{
           var boolZip = checkZipCode('zip_code' +addSalt);
              if(boolZip == false) {
                return false;
                }
           } 
}else{
  return true;
}


if(fieldName != 'home_phone') {               
         if(homePhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Primary Phone field');
          document.getElementById('home_phone' +addSalt).focus();
          return false;
          }else{
          var boolHphone = checkPhoneNumber('home_phone' +addSalt);
              if(boolHphone == false) {
                return false;
                }                 
          }
}else{
  return true;
}


if(fieldName != 'cell_phone') {     
         if(cellPhone == "") {
          alert('Please fill out the ' +primaryContact+ ' Cell Phone field');
          document.getElementById('cell_phone' +addSalt).focus();
          return false;
          }else{
          var boolCphone = checkPhoneNumber('cell_phone' +addSalt);
              if(boolCphone == false) {
                return false;
                }             
          }  
}else{
  return true;
}


if(fieldName != 'email') {
         if(emailVal == "") {
          alert('Please fill out the ' +primaryContact+ ' Email Address field');
          document.getElementById('email' +addSalt).focus();
          return false;
          }else{
          var boolEmail = checkEmail('email' +addSalt);
              if(boolEmail == false) {
                return false;
                }  
          }
}else{
  return true;
}          


if(fieldName != 'dob') {        
          if(dobVal == "") {
           alert('Please fill out the ' +primaryContact+ ' Date of Birth field');
           document.getElementById('dob' +addSalt).focus();
           return false;
           }else{           
           var boolDob = checkDob('dob' +addSalt);
              if(boolDob == false) {
                return false;
                }  
           }                        
}else{
  return true;
}


if(fieldName != 'lic_num') {
          if(licNumber == "") {
           alert('Please fill out the ' +primaryContact+ ' Drivers License field');
           document.getElementById('lic_num' +addSalt).focus();
           return false;
           }
}else{
  return true;
}


if(fieldName != 'econt_name') {
     if(eContName == "") {
           alert('Please fill out the ' +primaryContact+ ' Emergency Contact Name field');
           document.getElementById('econt_name' +addSalt).focus();
           return false;
           }
  }else{
  return true;
}


if(fieldName != 'econt_relation') {
     if(eContRelation == "") {
           alert('Please fill out the ' +primaryContact+ ' Emergency Contact Relationship field');
           document.getElementById('econt_relation' +addSalt).focus();
           return false;
           }
  }else{
  return true;
}


if(fieldName != 'econt_phone') {
     if(eContPhone == "") {
           alert('Please fill out the ' +primaryContact+ ' Emergency Contact Phone field');
           document.getElementById('econt_phone' +addSalt).focus();
           return false;
           }else{
          var booleCphone = checkPhoneNumber('econt_phone' +addSalt);
              if(booleCphone == false) {
                return false;
                }             
          }  
}else{
  return true;
}



}
//---------------------------------------------------------------------------------------------------------
function checkDob(dobField)  {

var dobValue = document.getElementById(dobField).value;
var dobName = document.getElementById(dobField);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   dobName.focus();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        dobName.focus();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         dobName.focus();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   dobName.focus();                                  
                                   return false;                                                                   
                                  }       
        }
            
   }
   

}
//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber(phoneFieldId)  {

var phoneValue = document.getElementById(phoneFieldId).value;
var phoneName = document.getElementById(phoneFieldId);

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneFieldId).value = formattedPhoneNumber;
        return true;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               phoneName.focus();
               return false;               
    }
    
  

}

//---------------------------------------------------------------------------------------------------------------
function checkZipCode(zipField)  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');       
   document.getElementById(zipField).focus();
   return false;
}

if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('The Zip Code you entered is too short');
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail(emailField)  {

var emailValue = document.getElementById(emailField).value;
var fieldName = document.getElementById(emailField);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          fieldName.focus(); 
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
           fieldName.focus();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
          fieldName.focus();
		  return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
            fieldName.focus();
		    return false;		 
         }



}


//----------------------------------------------------------------------------------------------------
function saveContactRecord(addSalt, contactId, fieldName, fieldId)  {

//first make sure the feilds are filled out
var bool1 = checkMembers(fieldName, fieldId, addSalt);
      if(bool1 == false) {
        return false;
       }else{
       
     
var firstName = document.getElementById('first_name' +addSalt).value;
var middleName = document.getElementById('middle_name' +addSalt).value;
var lastName = document.getElementById('last_name' +addSalt).value;
var streetAddress = document.getElementById('street_address' +addSalt).value;
var cityVal = document.getElementById('city' +addSalt).value;
var stateVal = document.getElementById('state' +addSalt).value;
var zipCode = document.getElementById('zip_code' +addSalt).value;
var homePhone = document.getElementById('home_phone' +addSalt).value;
var cellPhone = document.getElementById('cell_phone' +addSalt).value;
var emailVal = document.getElementById('email' +addSalt).value;
var dobVal = document.getElementById('dob' +addSalt).value;
var licNumber = document.getElementById('lic_num' +addSalt).value;
var eContName = document.getElementById('econt_name' +addSalt).value;
var eContRelation = document.getElementById('econt_relation' +addSalt).value;
var eContPhone = document.getElementById('econt_phone' +addSalt).value;
var memberId = document.getElementById('member_id' +addSalt).value;     
               
     
firstName = firstName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
middleName = middleName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
lastName = lastName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
streetAddress = streetAddress.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
cityVal = cityVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
emailVal = emailVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
licNumber = licNumber.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
eContName = eContName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
eContRelation = eContRelation.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');

var confirmationTopic = "";
      confirmationTopic = confirmationTopic+firstName;
      confirmationTopic = confirmationTopic+' '+middleName;
      confirmationTopic = confirmationTopic+' '+lastName;


  firstName = encodeURIComponent(firstName);
  middleName = encodeURIComponent(middleName);
  lastName = encodeURIComponent(lastName);
  streetAddress = encodeURIComponent(streetAddress);
  cityVal = encodeURIComponent(cityVal);
  stateVal = encodeURIComponent(stateVal);
  zipCode = encodeURIComponent(zipCode);
  homePhone = encodeURIComponent(homePhone);
  cellPhone = encodeURIComponent(cellPhone);
  emailVal = encodeURIComponent(emailVal);
  dobVal = encodeURIComponent(dobVal);
  licNumber = encodeURIComponent(licNumber);
  eContName = encodeURIComponent(eContName);
  eContRelation = encodeURIComponent(eContRelation);
  eContPhone = encodeURIComponent(eContPhone);
  memberId = encodeURIComponent(memberId);

  var parameters = "";
  parameters = parameters+'general_id='+contactId;
  parameters = parameters+'&member_id='+memberId;
  parameters = parameters+'&first_name='+firstName;
  parameters = parameters+'&middle_name='+middleName;
  parameters = parameters+'&last_name='+lastName;
  parameters = parameters+'&street='+streetAddress;
  parameters = parameters+'&city='+cityVal;
  parameters = parameters+'&state='+stateVal;
  parameters = parameters+'&zip='+zipCode;
  parameters = parameters+'&primary_phone='+homePhone;
  parameters = parameters+'&cell_phone='+cellPhone;
  parameters = parameters+'&email='+emailVal;
  parameters = parameters+'&dob='+dobVal;
  parameters = parameters+'&license_number='+licNumber;
  parameters = parameters+'&emg_contact='+eContName;
  parameters = parameters+'&emg_relationship='+eContRelation;
  parameters = parameters+'&emg_phone='+eContPhone;
  
    
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

 
xmlHttp.open("POST", "../utilities/updateMemberInfo.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");

xmlHttp.onreadystatechange= function() { 

        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                          
                         if(successKey == 1) {                              
                           alert('Member "' +confirmationTopic+ '" successfully updated');
                           }else{   
                           alert(successKey);
                            alert('There was an error updating this member');
                           return false;                         
                           }                             
             }
}

xmlHttp.send(parameters);
    
       
 
       }

}

