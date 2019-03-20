function openPayrollWindow()  {
//alert('Open Contract Window'); 
window.open('payrollSettledListReport.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//-----------------------------------------------------------------------------------------------------------------
function openPayroll() {

//fields for ajax

var start = document.getElementById("datepicker1").value;
var end = document.getElementById("datepicker2").value;

//alert(contractKey+ '\n' +month+ '\n' + +year);
//return false;
if(start == "") {
           alert('Please select a start range');
           $("#datepicker1").focus();
            return false;
            }
if(end == "") {
           alert('Please select a end range');
           $("#datepicker2").focus();
            return false;
            }
//alert(start);            
start = encodeURIComponent(start);
end = encodeURIComponent(end); 

var parameters = "";
parameters = parameters+'start='+start;
parameters = parameters+'&end='+end;
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
xmlHttp.open("POST", "createPayrollObject.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
                     //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1){   
                           setTimeout('openPayrollWindow()', 1000);
                           }else{
                           alert('There was an error printing this report');
                           return false;                         
                           }                                                
             }
}
//========================================

}
