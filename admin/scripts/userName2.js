function checkUserName(uName, userId) {


var  err3=document.getElementById("error3");
var id2 = document.form1.user_name1;

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
var url="userName2.php";
url=url+"?user="+uName;
url=url+"&id="+userId;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
err3.innerHTML= '<span class="errors">User Name is already taken</span>';
 id2.focus();                          
 return false;
}

if(passStatus == 2) {
err3.innerHTML= '';                        
return true;
}


//end of complete
} 

//end state change function
}
}
