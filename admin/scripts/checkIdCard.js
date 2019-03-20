function checkIdCard(idCard, fieldId) {

idCard = idCard.replace(/ /g, '');

if(idCard == "") {
  return true;
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
var url="checkIdCard.php";
url=url+"?id_card="+idCard;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    
                     var passStatus =  xmlHttp.responseText;
                           
switch(fieldId) {
case 'id_card1':
  var descTxt = '\"Employee Type Information One\"';
  break;
case 'id_card2':
  var descTxt = '\"Employee Type Information Two\"';
  break;
case 'id_card3':
  var descTxt = '\"Employee Type Information Three\"';
  break;  
case 'id_card4':
  var descTxt = '\"Employee Type Information Four\"';
  break;  
}
//alert(passStatus);
                            if(passStatus == 1)  {
                             alert('The ID Number you entered \"' +idCard+ '\" for ' +descTxt+ ' is already in use');
                             document.getElementById(fieldId).value = "";
                             document.getElementById(fieldId).focus();
                             return false;
                            }
                            
                            if(passStatus == 2)  {
                              return true;
                              }
                                        
//end of complete
} 

//end state change function
}

}
