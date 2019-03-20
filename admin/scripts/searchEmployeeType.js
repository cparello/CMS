function send_id(fromWhere)  {

var txt=document.getElementById("idContent1");

var employeeType1a = document.form1.employee_type.value;
var employeeType1b = document.form1.employee_type;

var serviceLocation1a = document.form1.service_location.value;
var serviceLocation1b = document.form1.service_location;


var submitAll =  document.form1.all.value;


var searchStrng = "";

switch(fromWhere)   {
case 1:
    if(employeeType1a == "")  {
       txt.innerHTML= '<p class="errors">Please enter an Employee Type</p>';
       employeeType1b.focus();                          
       return false;
      }
      searchStrng = employeeType1a;
break;
case 2:
   if(serviceLocation1a == "")  {
      txt.innerHTML= '<p class="errors">Please select a Service Location</p>';
      serviceLocation1b.focus();                          
      return false;
    }
    searchStrng = serviceLocation1a;
break;
case  3:
    searchStrng = 'all';
break;
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
var url="employeeTypeCheck1.php";
url=url+"?type="+fromWhere;
url=url+"&criterior="+searchStrng;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
 txt.innerHTML= '<p class="errors">Employee Type does not exist</p>';
 employeeType1b.focus();                          
 return false;
}

if(passStatus == 2) {
 txt.innerHTML= '<p class="errors">Service Location does not exist</p>';
 serviceLocation1b.focus();                          
 return false;
}


if(passStatus == 3) {
 txt.innerHTML= '<p class="errors">No Records Exist</p>';
 //businessName2.focus();                          
 return false;
}


if(passStatus == 4)  {
document.form1.submit();
}


//end of complete
} 

//end state change function
}

return false;     
     

}
