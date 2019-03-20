function setPrePayRecord(contractKey) {

//write to the header the description of the pre payment
var prePayText = 'Process Prepaid Transactions';


//parent.document.contentHeader.innerHTML = prePayText;
window.parent.document.getElementById('contentHeader').innerHTML = prePayText;
           
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
 alert ("There was an error processing your request.")
 return false;
 }


//send off the request
var url="setContractKey.php";
url=url+"?contract_key="+contractKey;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    
                     var resultCount =  xmlHttp.responseText;
//alert(resultCount);
                            if(resultCount == 0)  {
                             alert('There was an error processing your request');                        
                             return false;                            
                            }
  
                            if(resultCount != 0)  {                                
                              window.location = "prePayments.php";                                                                                                                                                                                      
                             }
                                        
//end of complete
} 

//end state change function
}


return false;    

}
