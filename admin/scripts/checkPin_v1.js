//-------------------------------------------------------------------------------------------------------------
function enableFields(fieldName, boon) {

//alert(fieldName);

var payField = document.form1.elements[fieldName];     //put this back into the function braket once I figur th other bullshit out
if (payField[0]) {
          for (var i=0; i< payField.length; i++) {
                payField[i].disabled =boon;  
                return boon;
              }
 }else{

    payField.disabled = boon;
    return boon;
}



}
//-----------------------------------------------------------------------------------------------------------
function sendFormFields(stringLength, fieldName, boon) {

//alert(stringLength);
var fieldNameTwo = "";

for (var i=1; i <= stringLength; i++) {
        fieldNameTwo = fieldName.replace(/[0-9]/g, i); 
        //alert(fieldNameTwo);
         
enableFields(fieldNameTwo, boon);
}

}
//-----------------------------------------------------------------------------------------------------------
function setFormFields(boon)   {

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;


var singleField = 'compS1[]';
var familyField = 'compF1[]';
var businessField = 'compB1[]';
var organizationField = 'compO1[]';


sendFormFields(singleLength, singleField, boon);
sendFormFields(familyLength, familyField, boon);
sendFormFields(businessLength, businessField, boon);
sendFormFields(organizationLength, organizationField, boon);

}
//----------------------------------------------------------------------------------------------

function validateOveridePin(pinNumber)  {

var test = pinNumber.length;


//get ajax request object
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
//-------------------------------------------------------
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="checkPin.php";
url=url+"?pin="+pinNumber;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;

if(pinNumber.length == 4) {

if(passStatus == 1) {
alert('You have entered an invalid PIN number');
document.getElementById("overide_pin").value = "";
document.getElementById("overide_pin").focus();                           
 return false;
 }else if(passStatus == 2) {
 document.form1.overide_pin.disabled = true;
 setFormFields(false);
 }
 }
 
 

//end of complete
} 

//end state change function
}

return false;  

}
//------------------------------------------------------------------------------------------------------------------------------------------
//this is used to check if sales person has permission to change content
function fieldChange()   {

var pinNumber = document.getElementById("overide_pin").value;

if(pinNumber == "") {
alert('You do not have permission to edit this price. To edit this price please enter your PIN number in the Price Change Overide field.');
document.getElementById("overide_pin").focus(); 
 return false;
}
//get ajax request object
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
//-------------------------------------------------------
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="checkPin2.php";
url=url+"?pin="+pinNumber;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
alert('You do not have permission to edit this price. To edit this price please enter your PIN number in the Price Change Overide field.');
document.getElementById("overide_pin").focus(); 
 return false;
}

//end of complete
} 

//end state change function
}


return false;    




}












