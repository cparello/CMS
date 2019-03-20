function checkData()   {
var pin1a = document.form1.overide_pin_one.value;
var pin1b = document.form1.overide_pin_one;
var  err1=document.getElementById("conf");

if(pin1a == "")  {
 err1.innerHTML= '<span class="errors">PIN field cannot be blank</span>';
 pin1b.focus();                          
 return false;
 }
if(isNaN(pin1a)) {
err1.innerHTML= '<span class="errors">PIN must be a Number</span>';
pin1b.focus();                          
return false;
 }
 if(pin1a.length < 4)  {
 err1.innerHTML= '<span class="errors">PIN is too short</span>';
 pin1b.focus();                          
 return false;        
 }


}

function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}