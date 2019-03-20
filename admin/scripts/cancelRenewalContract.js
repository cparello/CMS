function cancelRenewalContract()  {
var printSwitch = document.form1.print_switch.value;

if(printSwitch != 1) {
   alert('Contract has not been created.');
        return false;
   }

//create a confirmation to ses  if they wish to cancel
//var contractKey  = document.form1.contract_key.value;
var deleteSwitch = 1;
var answer = confirm('This will cancel this renewal contract and redirect you to the \"New Member Application Interface\".  Do you wish to continue?');

  if(answer) {
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

//this function checks the state and then parses the response
function stateChanged() { 
   if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
       var confirmDelete = xmlHttp.responseText;
             if(confirmDelete == 1) {
                window.location = "salesForm.php";
             } 
      }
}

//send off the request
var url="createRenewalObject.php";
url=url+"?delete_switch="+deleteSwitch;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


  
                         }else{                         
                                  return false;
                         }

}