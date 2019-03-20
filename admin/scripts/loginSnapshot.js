function send_id()  {

var txt=document.getElementById("idContent1");
var id1 = document.form1.username.value;
var id2 = document.form1.username;
var id3 = document.form1.password.value;
var id4 = document.form1.password;
var x = id1;
var y = id3;
id1 = (x.replace(/^\W+/,'')).replace(/\W+$/,'');
id3 = (y.replace(/^\W+/,'')).replace(/\W+$/,'');

        
// this checks the validity of the user name to see if it is a valid email address
        if(id1 == "")  {
          txt.innerHTML= '<p class="errors">Please supply your user name</p>';
          id2.focus();                          
          return false;
        }
        
	

//this checks the validity of the password.       
          if(id3 == "")  {
           txt.innerHTML= '<p class="errors">Please supply your password</p>';
           id4.focus();                          
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
var url="logCheckMemberInterface.php";
url=url+"?user="+id1;
url=url+"&pass="+id3;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
 txt.innerHTML= '<p class="errors">Your User Name or Password is invalid</p>';
 id2.focus();                          
 return false;
}

if(passStatus == 2)  {
document.form1.submit();
}


//end of complete
} 

//end state change function
}

return false;     
     
     
     
     
     
//-------------------------------------------------------


}