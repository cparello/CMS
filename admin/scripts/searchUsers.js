function send_id(fromWhere)  {

var txt=document.getElementById("idContent1");

var lastName1 = document.form1.last_name.value;
var lastName2 = document.form1.last_name;

var userName1 = document.form1.username.value;
var userName2 = document.form1.username;

var submitAll =  document.form1.all.value;
var submitName =  document.form1.last.value;
var submitUser =  document.form1.user.value;

var searchStrng = "";

switch(fromWhere)   {
case 1:
    if(lastName1 == "")  {
       txt.innerHTML= '<span class="errors">Please supply a Last Name</span>';
       lastName2.focus();                          
       return false;
      }
      searchStrng = lastName1;
break;
case 2:
   if(userName1 == "")  {
      txt.innerHTML= '<span class="errors">Please supply a User Name</span>';
      userName2.focus();                          
      return false;
    }
    searchStrng = userName1;
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
var url="logCheck3.php";
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
 txt.innerHTML= '<span class="errors">Last Name does not exist</span>';
 lastName2.focus();                          
 return false;
}

if(passStatus == 2) {
 txt.innerHTML= '<span class="errors">User Name does not exist</span>';
 userName2.focus();                          
 return false;
}

if(passStatus == 3) {
 txt.innerHTML= '<span class="errors">No Records Exist</span>';
 userName2.focus();                          
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
