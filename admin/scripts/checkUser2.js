function checkUser2(userName, fieldId, origUser) {


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
var url="checkUser.php";
url=url+"?user="+userName;
url=url+"&orig_user="+origUser;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    
                     var userNameArray =  xmlHttp.responseText;
                     var userNameArray = userNameArray.split("|");
                           
                           var bool = userNameArray[0];
                           var newUserName = userNameArray[1];
 //alert(bool);
                            if(bool == 1)  {
                             alert('The user you entered is invalid.');
                             document.getElementById(fieldId).value = newUserName;
                             document.getElementById(fieldId).focus();
                             return false;                            
                            }
                            
                            if(bool == 3)  {
                            alert('The user you entered is not a valid sales representative.');
                            document.getElementById(fieldId).value = newUserName;
                            document.getElementById(fieldId).focus();
                            return false;                                                     
                            }

                                        
//end of complete
} 

//end state change function
}


return false;    

}
