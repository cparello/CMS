function setTabs() {

var bg= '#282828';
//var bg = "url(./images/carbon_fibre.png)";

window.parent.document.getElementById('contentHeader').style.backgroundColor = bg;


window.parent.document.getElementById('contentHeader').innerHTML = '<div id="tabOne" class="headText headText2">Account Information</div><div id="tabTwo" class="headText">Payment History</div><div id="tabThree" class="headText">Member Information</div><div id="tabFour" class="headText">Notes</div><div id="tabFive" class="headText">Member History</div>';

window.parent.document.getElementById('contentFrame').style.top="38px";

}
//-------------------------------------------------------------------------------------------
function setContractRecord(contractKey) {
           

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
 

setTabs();
 
 
                            if(resultCount != 0)  {                                
                              window.location = "accountInformation.php";                                                                                                                                                                                      
                             }

                                        
//end of complete
} 

//end state change function
}


return false;    

}
