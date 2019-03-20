function send_id()  {

var txt1=document.getElementById("error1");

var locationId1a = document.form1.location_id.value;
var locationId1b = document.form1.location_id;

var locationName1a = document.form1.location_name.value;
var locationName1b = document.form1.location_name;

var locationAddress1a = document.form1.location_address.value;
var locationAddress1b = document.form1.location_address;

var locationPhone1a = document.form1.location_phone.value;
var locationPhone1b = document.form1.location_phone;

var locationContact1a = document.form1.location_contact.value;
var locationContact1b = document.form1.location_contact;


//trim the white space from the input fields
var a = locationId1a;
var b = locationName1a;
var c = locationAddress1a;
var d = locationPhone1a;
var e = locationContact1a;

locationId1a = (a.replace(/^\W+/,'')).replace(/\W+$/,'');
locationName1a = (b.replace(/^\W+/,'')).replace(/\W+$/,'');
locationAddress1a = (c.replace(/^\W+/,'')).replace(/\W+$/,'');
locationPhone1a = (d.replace(/^\W+/,'')).replace(/\W+$/,'');
locationContact1a = (e.replace(/^\W+/,'')).replace(/\W+$/,'');


//check to see if fields are filled out is filled out
   if(locationId1a== "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location ID</span>';
          locationId1b.focus();                          
          return false;
         }      

  if(locationName1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Name</span>';
          locationName1b.focus();                          
          return false;
         }      

  if(locationAddress1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Address</span>';
          locationAddress1b.focus();                          
          return false;
         }      

  if(locationPhone1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Phone</span>';
          locationPhone1b.focus();                          
          return false;
         }      

  if(locationContact1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Contact</span>';
          locationContact1b.focus();                          
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
var url="locationCheck.php";
url=url+"?loc_id="+locationId1a;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;

if(passStatus == 1) {
 txt1.innerHTML= '<p class="errors">Location ID Already Taken</p>';
 locationId1b.focus();                           
 return false;
}

if(passStatus == 4)  {
document.form1.submit();
}



}
}

return false;

}

function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}