function sendEmployeeId(linkBit) {

var userName = prompt("Please enter  your \"Username\" in the field below.\nYour Employee ID will be emailed to you shortly.\n\n")


// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=userName.indexOf(at);
var lstr=userName.length;
var ldot=userName.indexOf(dot);

        if(userName == "")  {
          alert("Please supply your user name");                        
          return false;
        }
        
		if(userName.indexOf(at)==-1){
		   alert("You have entered an invalid username");
		   return false;
		}

		if(userName.indexOf(at)==-1 || userName.indexOf(at)==0 || userName.indexOf(at)==lstr){
		   alert("You have entered an invalid user name");
		   return false;
		}

		if(userName.indexOf(dot)==-1 || userName.indexOf(dot)==0 || userName.indexOf(dot)==lstr){
		   alert("You have entered an invalid user name");
		   return false;
		}

		 if(userName.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid user name");
		    return false;
		 }

		 if(userName.substring(lat-1,lat)==dot || userName.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid user name");
		    return false;
		 }

		 if(userName.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid user name");
		    return false;
		 }
		
		 if(userName.indexOf(" ")!=-1){
		    alert("You have entered an invalid user name");
		    return false;		 
         }


if(linkBit == 1) {
 var appLink = 'helper_apps/sendEmployeeId.php';
 }
if(linkBit == 2) {
 var appLink = '../helper_apps/sendEmployeeId.php';
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
var url=appLink;
url=url+"?user_name="+userName;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
 alert("The Username you submitted is invalid");                         
 return false;
}

if(passStatus == 2)  {
 alert('Your Employee ID has been successfully emailed to "' +userName+ '"');   
}


//end of complete
} 

//end state change function
}

return false;     







}