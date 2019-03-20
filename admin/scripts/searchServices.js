function send_id(fromWhere)  {

var txt=document.getElementById("idContent1");

var serviceType1a = document.form1.service_type.value;
var serviceType1b = document.form1.service_type;

var serviceLocation1a = document.form1.service_location.value;
var serviceLocation1b = document.form1.service_location;

var groupType1a = document.form1.group_type.value;
var groupType1b = document.form1.group_type;



var submitAll =  document.form1.all.value;


var searchStrng = "";

switch(fromWhere)   {
case 1:
    if(serviceType1a == "")  {
       txt.innerHTML= '<span class="errors">Please supply a Service name</span>';
       serviceType1b.focus();                          
       return false;
      }
      searchStrng = serviceType1a;
break;
case 2:
   if(serviceLocation1a == "")  {
      txt.innerHTML= '<span class="errors">Please select a Service Location</span>';
      serviceLocation1b.focus();                          
      return false;
    }
    searchStrng = serviceLocation1a;
break;
case 3:
   if(groupType1a == "")  {
      txt.innerHTML= '<span class="errors">Please select a Group Type</span>';
      groupType1b.focus();                          
      return false;
    }
    searchStrng = groupType1a;
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
var url="serviceCheck1.php";
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
 txt.innerHTML= '<span class="errors">Service Name does not exist</span>';
 serviceType1b.focus();                          
 return false;
}

if(passStatus == 2) {
 txt.innerHTML= '<span class="errors">Service Location does not exist</span>';
 serviceLocation1b.focus();                          
 return false;
}

if(passStatus == 3) {
 txt.innerHTML= '<span class="errors">No Group Types in this Category</span>';
groupType1b.focus();                          
 return false;
}


if(passStatus == 4) {
 txt.innerHTML= '<span class="errors">No Records Exist</span>';
 //businessName2.focus();                          
 return false;
}


if(passStatus == 5)  {
document.form1.submit();
}


//end of complete
} 

//end state change function
}

return false;     
     

}
