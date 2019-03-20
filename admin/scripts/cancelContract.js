//---------------------------------------------------------------------------------
function cancelContract()  {
var printSwitch = document.form1.print_switch.value;

if(printSwitch != 1) {
   alert('Contract has not been created.');
        return false;
   }

//create a confirmation to ses  if they wish to cancel
var contractKey  = document.form1.contract_key.value;
var deleteSwitch = 1;
var answer = confirm('WARNING!  This Contract has not been submitted.  To submit this Contract please use the "Step 2 Submit Order" button. If you wish to delete all information associated with this contract and reset all existing form fields click OK.');

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
var url="createSalesObject.php";
url=url+"?delete_switch="+deleteSwitch;
url=url+"&contract_key="+contractKey;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


  
                         }else{                         
                                  return false;
                         }

}