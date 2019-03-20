function openAttendanceWindow()  {
//alert('Open Contract Window'); 
window.open('attendenceListReport2.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//-----------------------------------------------------------------------------------------------------------------
function openAttendance() {

//fields for ajax

var year = document.getElementById("year").value;
var month = document.getElementById("cexp_date1").value;
var contractKey = $("#contract_key_pre").val();
//alert(contractKey+ '\n' +month+ '\n' + +year);
//return false;
if(year == "") {
           alert('Please select a year');
           $("#year").focus();
            return false;
            }
if(month == "") {
           alert('Please select a month');
           $("#cexp_date1").focus();
            return false;
            }
            
var response =  confirm('Click YES to send an email of this report to the email address listed above in the member info. Click CANCEL to view the report now.');
                
if(!response) {         
  var emailBool = 0;

}else{
     var emailBool = 1;
}
year = encodeURIComponent(year);
month = encodeURIComponent(month); 
contractKey = encodeURIComponent(contractKey);

var parameters = "";
parameters = parameters+'year='+year;
parameters = parameters+'&month='+month;
parameters = parameters+'&contractKey='+contractKey;
parameters = parameters+'&emailBool='+emailBool;
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
xmlHttp.open("POST", "createAttendanceObject2.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {   
                           
                           setTimeout('openAttendanceWindow()', 1000);
                           }else{
                           alert('There was an error printing this report');
                           return false;                         
                           }                                                
             }
}
//========================================

}
