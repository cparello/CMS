function openContractWindow()  {
//alert('Open Contract Window'); 
window.open('contractWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//-----------------------------------------------------------------------------------------------------------------
function openContract(contractDate, contractKey) {

var answer1 = confirm("Would you like to email a copy of this contract to the member?");
                               if (!answer1) {
                                      var bool = 0;
                                     }else{
                                        var bool = 1;
                                     }

//fields for ajax
contractDate = encodeURIComponent(contractDate);
contractKey = encodeURIComponent(contractKey); 
bool = encodeURIComponent(bool);
var parameters = "";
parameters = parameters+'contract_date='+contractDate;
parameters = parameters+'&contract_key='+contractKey;
parameters = parameters+'&bool='+bool;
//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "createContractObject.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {   
                           
                           setTimeout('openContractWindow()', 1000);
                           }else{
                           alert('There was an error printing this contract');
                           return false;                         
                           }                                                
             }
}
//========================================

}
