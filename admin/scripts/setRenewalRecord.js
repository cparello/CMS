function setRenewalRecord(contractKey, serviceKey, Type)   {


switch(Type)  {
case 'early_renewal':
var renewalType = 'E';
break;
case 'renewal':
var renewalType = 'S';
break;
case 'expired':
var renewalType = 'X';
break;
case 'pif':
var renewalType = 'P';
break;
}
//alert(renewalType);



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
var url="createRenewalListObject.php";
url=url+"?contract_key="+contractKey;
url=url+"&service_key="+serviceKey;
url=url+"&renewal_type="+renewalType;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    
                     var resultCount =  xmlHttp.responseText;
//alert(resultCount);
                            if(resultCount == 1)  {
                             window.location = "renewalForm.php";                                                                               
                              }else{
                              alert('There was an error processing your request');
                               return false;                              
                              }
                            
                                                                
//end of complete
} 

//end state change function
}


return false;    

//

}