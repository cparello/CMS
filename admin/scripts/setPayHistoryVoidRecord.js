
//-------------------------------------------------------------------------------------------
function setContractRecord(cKey, requestId, billType, amount, date, descrip) {
           
//alert(amount);
//alert(invoice);
//alert(id);


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
var url="setVoidPayHistoryKey.php";
url=url+"?c_key="+cKey;
url=url+"&request_id="+requestId;
url=url+"&bill_type="+billType;
url=url+"&amount="+amount;
url=url+"&date="+date;
url=url+"&descrip="+descrip;
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
                                var answer1 = confirm("Your transaction was succesfully refunded would you like to print a reciept?");
                               if (!answer1) {
                                      return false;
                                     }else{
                                        window.location = "receiptWindowPayHistory.php";     
                                     }    
                                                                                                                                                                                                               
                             }

                                        
//end of complete
} 

//end state change function
}


return false;    

}
