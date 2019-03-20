function send_id(fromWhere)  {

var txt=document.getElementById("idContent1");

var employeeName1a = document.form1.employee_name.value;
var employeeName1b = document.form1.employee_name;

var employeeIdCard1a = document.form1.id_card.value;
var employeeIdCard1b = document.form1.id_card;

//alert('fubar');
var searchStrng = "";

switch(fromWhere)   {
case 1:
    if(employeeName1a == "")  {
       txt.innerHTML= '<span class="errors">Please enter an Employee Name</span>';
       employeeName1b.focus();                          
       return false;
      }
      searchStrng = employeeName1a;
      document.getElementById('id_card').value ="";
break;
case 2:
   if(employeeIdCard1a == "")  {
      txt.innerHTML= '<span class="errors">Please enter an Employee ID number</span>';
      employeeIdCard1b.focus();                          
      return false;      
    }
    
  if(employeeIdCard1a != "")  {
    if(isNaN(employeeIdCard1a)) {
      txt.innerHTML= '<span class="errors">Employee ID number must only contain numbers</span>';
      employeeIdCard1b.focus();                          
      return false;      
    }  
   }    
    document.getElementById('employee_name').value ="";
    searchStrng = employeeIdCard1a;
break;
}

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
var url="employeeCheckSalesperson3.php";
url=url+"?type="+fromWhere;
url=url+"&search_string="+searchStrng;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;
//alert(passStatus);

if(passStatus == 1) {
 txt.innerHTML= '<span class="errors">Employee(s) do not exist</span>';
 employeeName1b.focus();                          
 return false;
}

if(passStatus == 2) {
 txt.innerHTML= '<span class="errors">Employee ID Number does not exist</span>';
 employeeIdCard1b.focus();                           
 return false;
}



if(passStatus == 4)  {
document.form1.submit();
}


//end of complete
} 

//end state change function
}

return false;     
     

}
