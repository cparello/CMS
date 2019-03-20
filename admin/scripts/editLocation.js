function send_id()  {

var txt1=document.getElementById("error1");

var locationName1a = document.form1.location_name.value;
var locationName1b = document.form1.location_name;

var locationAddress1a = document.form1.location_address.value;
var locationAddress1b = document.form1.location_address;

var locationPhone1a = document.form1.location_phone.value;
var locationPhone1b = document.form1.location_phone;

var locationContact1a = document.form1.location_contact.value;
var locationContact1b = document.form1.location_contact;


//trim the white space from the input fields
var b = locationName1a;
var c = locationAddress1a;
var d = locationPhone1a;
var e = locationContact1a;

locationName1a = (b.replace(/^\W+/,'')).replace(/\W+$/,'');
locationAddress1a = (c.replace(/^\W+/,'')).replace(/\W+$/,'');
locationPhone1a = (d.replace(/^\W+/,'')).replace(/\W+$/,'');
locationContact1a = (e.replace(/^\W+/,'')).replace(/\W+$/,'');


//check to see if fields are filled out is filled out

  if(locationName1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Name</span>';
          locationName1b.focus();                          
          return false;
         }      

  if(locationAddress1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Address</span>';
          locationAddress1b.focus();                          
          return false;
         }      

  if(locationPhone1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Phone</span>';
          locationPhone1b.focus();                          
          return false;
         }      

  if(locationContact1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Location Contact</span>';
          locationContact1b.focus();                          
          return false;
         }      

}


function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}