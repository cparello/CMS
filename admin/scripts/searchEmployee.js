function send_id(fromWhere)  {

var txt=document.getElementById("idContent1");

var employeeName1a = document.form1.employee_name.value;
var employeeName1b = document.form1.employee_name

var employeeType1a = document.form1.employee_type.value;
var employeeType1b = document.form1.employee_type;
var i = document.form1.employee_type.selectedIndex;
var empType = document.form1.employee_type.options[i].text;

var serviceLocation1a = document.form1.service_location.value;
var serviceLocation1b = document.form1.service_location;
var j = document.form1.service_location.selectedIndex;
var locOps = document.form1.service_location.options[j].text;

var submitAll =  document.form1.all.value;

var nameStrng = "";
var searchStrng = "";

switch(fromWhere)   {
case 1:
    if(employeeName1a == "")  {
       txt.innerHTML= '<span class="errors">Please enter an Employee Name</span>';
       employeeName1b.focus();                          
       return false;
      }
      searchStrng = employeeName1a;
break;
case 2:
   if(employeeType1a == "")  {
      txt.innerHTML= '<span class="errors">Please select an Employee Type</span>';
      employeeType1b.focus();                          
      return false;      
    }
    searchStrng = employeeType1a;
    nameStrng = empType;
break;
case 3:
   if(serviceLocation1a == "")  {
      txt.innerHTML= '<span class="errors">Please select a Service Location</span>';
      serviceLocation1b.focus();                          
      return false;
    }
    searchStrng = serviceLocation1a;
    nameStrng = locOps;
break;
case  4:
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
var url="employeeCheck1.php";
url=url+"?type="+fromWhere;
url=url+"&criterior="+searchStrng;
url=url+"&drops="+nameStrng;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;

//alert(passStatus);

if(passStatus == 1) {
 txt.innerHTML= '<span class="errors">Employee(s) do not exist</span>';
 employeeName1b.focus();                          
 return false;
}

if(passStatus == 2) {
 txt.innerHTML= '<span class="errors">Employee(s) do not exist</span>';
 employeeName1b.focus();                           
 return false;
}


if(passStatus == 3) {
 txt.innerHTML= '<span class="errors">Employee(s) do not Exist</span>';
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
