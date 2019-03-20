function comfirmSale() {
var message = document.form1.confirmation_message.value; 

if(message != "") {
   alert(message);
  }

}
//----------------------------------------------------------------------------------------------------------------
function checkSelections() {

var clubLocation = document.getElementById('club_location').value;
var payrollCycle = document.getElementById('payroll_cycle').value;
var txt=document.getElementById("idContent1");
var dateStart = document.getElementById('datepicker1').value;
var dateEnd = document.getElementById('datepicker2').value;
//alert(dateStart+'  '+dateEnd);

if(clubLocation == "") {
 txt.innerHTML= '<span class="errors">Please select a Club Location</span>';
          document.getElementById('club_location').focus();
          return false;
          }

if(payrollCycle == "") {
   txt.innerHTML= '<span class="errors">Please select a Payroll Cycle</span>';
          document.getElementById('payroll_cycle').focus();
          return false;
          }

//-----------------------------------------------------------------------------------------
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
var url="payrollCheck.php";
url=url+"?club_location="+clubLocation;
url=url+"&payroll_cycle="+payrollCycle;
url=url+"&date_start="+dateStart;
url=url+"&date_end="+dateEnd;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;
//alert(passStatus);

if(passStatus == 4)  {
document.form1.submit();
return true;
}

if(passStatus == 1) {
 txt.innerHTML= '<span class="errors">Payroll for this combination does not exist</span>';                        
 return false;
}else{
alert(passStatus);
return false;
}


//end of complete
} 

//end state change function
}

return false;     

}
     