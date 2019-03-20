function openContractWindow()  {
//alert('Open Contract Window'); 
window.open('listReport.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}

//-----------------------------------------------------------------------------------------------------------------
function openContract(id) {

//fields for ajax

switch(id)  {
case 'pop_window1':
            var year = document.getElementById("year").value;
            var month = document.getElementById("cexp_date1").value;
            var report = document.getElementById("report").value;
         if(report == "" || month == "" || year == ""  )  {
            alert('Please select all three fields to view a Report.');
            document.getElementById('report').focus();
            return false;
          }
break;
case 'pop_window2':
          var year = document.getElementById("year2").value;
            var month = document.getElementById("cexp_date2").value;
            var report = document.getElementById("report2").value;
         if(report == "" || month == "" || year == "")  {
            alert('Please select all three fields to view a Report.');
            document.getElementById('report2').focus();
            return false;
          }
break;
case 'pop_window3':
          var year = document.getElementById("year3").value;
            var month = document.getElementById("cexp_date3").value;
            var report = document.getElementById("report3").value;
         if(report == "" || month == "" || year == "")  {
            alert('Please select all three fields to view a Report.');
            document.getElementById('report3').focus();
            return false;
          }
break;
case 'pop_window4':
          var year = document.getElementById("collect_year").value;
          var month = document.getElementById("collect_month").value;
          var report = "collect";
         if(year == "")  {
            alert('Please select a year.');
            document.getElementById('collect_year').focus();
            return false;
          }
           if(month == "")  {
            alert('Please select a month.');
            document.getElementById('collect_month').focus();
            return false;
          }
break;

}

//alert(report+ '\n' +month+ '\n' + +year);
//return false;



year = encodeURIComponent(year);
month = encodeURIComponent(month); 
report = encodeURIComponent(report);

var parameters = "";
parameters = parameters+'year='+year;
parameters = parameters+'&month='+month;
parameters = parameters+'&report='+report;

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
//alert(xmlHttp); 
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "createReportObject.php", true);
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
                           alert('There was an error printing this report');
                           return false;                         
                           }                                                
             }
}
//========================================

}
