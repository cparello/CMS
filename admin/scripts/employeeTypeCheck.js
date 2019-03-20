function send_id()  {

var txt1=document.getElementById("error1");


var employeeType1a = document.form1.employee_type.value;
var employeeType1b = document.form1.employee_type;

var employeeDescription1a = document.form1.employee_description.value;
var employeeDescription1b = document.form1.employee_description;

var serviceLocation1a = document.form1.service_location.value;
var serviceLocation1b = document.form1.service_location;


//check to see if service name is filled out
   if(employeeType1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Enter an Employee Type</span>';
          employeeType1b.focus();                          
          return false;
         }      

  if(employeeDescription1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Enter a Employee Description</span>';
          employeeDescription1b.focus();                          
          return false;
         }      


//check to see that at least one service quantity is filled out
if(serviceLocation1a == "") {
          txt1.innerHTML= '<span class="errors">Please Select a Service Location</span>';
          serviceLocation1b.focus();                          
          return false;
         }
}


function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}