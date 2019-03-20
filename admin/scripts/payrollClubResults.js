function printRecords() {

window.print();

}
//-----------------------------------------------------------------------------------------------------------------
function openPrintIndiWindow() {

window.open('indiPrintForm.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

}
//------------------------------------------------------------------------------------------------------------------
function checkSelection(obj, col, rowId) {

//this toggles the color of the row
var highlightColor = '#993300';
var x=document.getElementById(rowId);
x.style.backgroundColor = (obj.checked) ?  col : highlightColor;

}
//-------------------------------------------------------------------------------------------------------------------
function checkData()  {
//this checks to see if any of the check boxes have been checked before submitting
 sel = -1;

 if (typeof document.form1.elements['process[]'].length != 'undefined') {

       for (i=0; i< document.form1.elements['process[]'].length; i++) {
             if (document.form1.elements['process[]'][i].checked) { 
                 sel = i;
               }
            }
}else{

       if (document.form1.elements['process[]'].checked) { 
           sel = 1;
           }
} 
 //======================================
  
  if (sel == -1)  {
      alert("Please select employee(s) to process");
      return false;
     }
     
//=====================================

 var r = confirm('This will process the payroll for this pay period. Do you wish to continue?');                                
         if(r == true) {
            return true;
           }else{
            return false;
           }                
     
}
//------------------------------------------------------------------------------------------------------------------
function getDetails(insertArray) {

var dateStart = document.getElementById('date_start').value;
var dateEnd = document.getElementById('date_end').value;

var parameters = "";
parameters = parameters+'insert_array='+insertArray;
parameters = parameters+'&date_start='+dateStart;
parameters = parameters+'&date_end='+dateEnd;
//alert(dateStart+" "+dateEnd);
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
xmlHttp.open("POST", "viewDetails.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var details =  xmlHttp.responseText; 
                    //alert(details);
                         if(details == 1) {
                            setTimeout('openPrintIndiWindow()', 500);
                            //alert(details);
                            }
                       
             }
}
//========================================


}