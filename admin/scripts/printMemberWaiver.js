function openLiabiltyWindow()  {

window.open('liabilityWindowTwo.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//---------------------------------------------------------------------------------------------------------------
function printMemberWaiver(addSalt, contactId, fieldName, fieldId, contractKey)  {

//'1', '780', this.name, this.id, '1814'


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
var memberId = document.getElementById('member_id' +addSalt).value;     
               
     
firstName = firstName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
middleName = middleName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
lastName = lastName.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
streetAddress = streetAddress.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
cityVal = cityVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
emailVal = emailVal.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');
licNumber = licNumber.replace(/[^\.\? \! \$ \% \@ \, \" a-zA-Z 0-9]+/g,'');



//below we open and print out the form
 var libNameAddArray = (firstName+'|'+middleName+'|'+lastName+'|'+streetAddress+'|'+cityVal+'|'+stateVal+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+emailVal+'|'+dobVal+'|'+licNumber);

libNameAddArray = encodeURIComponent(libNameAddArray);


var libParameters = "";
libParameters = libParameters+'lib_address_array='+libNameAddArray;
libParameters = libParameters+'&contract_key='+contractKey;


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

 
xmlHttp.open("POST", "createLiabilityObjectTwo.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", libParameters.length);
xmlHttp.setRequestHeader("Connection", "close");

xmlHttp.onreadystatechange= function() { 

        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                          
                         if(successKey == 1) {                              
                          setTimeout('openLiabiltyWindow()', 500);
                           }else{   
                           alert(successKey);
                            alert('There was an error printing this form');
                           return false;                         
                           }                             
             }
}

xmlHttp.send(libParameters);
//===========================================   

       }

}