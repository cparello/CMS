
//-------------------------------------------------------------------------------------------
function setContractRecord(posKey, invoice, id) {
           

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

//alert(posKey);
//send off the request
var url="setPosKey.php";
url=url+"?pos_key="+posKey;
url=url+"&invoice="+invoice;
url=url+"&id="+id;
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
                              window.location = "receiptWindow.php";                                                                                                                                                                                      
                             }

                                        
//end of complete
} 

//end state change function
}


return false;    

}
