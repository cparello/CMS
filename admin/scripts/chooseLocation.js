function chooseLocation()  {
var txt1=document.getElementById("error1");

var locationId1a = document.form1.service_location.value;
var locationId1b = document.form1.service_location;

 if(locationId1a == "")  {
      txt1.innerHTML= '<p class="errors">Please select a Location</p>';
      locationId1b.focus();                          
      return false;
    }
}




function confirmDelete()  {

var txt1=document.getElementById("error1");

var locationId1a = document.form1.service_location.value;
var locationId1b = document.form1.service_location;

 if(locationId1a == "")  {
      txt1.innerHTML= '<p class="errors">Please select a Location</p>';
      locationId1b.focus();                          
      return false;
    }else{
      txt1.innerHTML='';
      var answer = confirm("Are you sure that you want to delete this service location?");
       if (!answer) {
       return false;
       }
    }
}