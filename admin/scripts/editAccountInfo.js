function editAccountInfo(fieldName, fieldId) {


//check the group marker to make sure it is set 
var enableFields = document.form1.group_marker.value;
var enableSwitch = document.form1.change_info;

//make sure they have made a selection and the payment stuff before editing the account info
var boon = editPaymentSummary();
      if(boon == false)  {
         enableSwitch.checked = false;
         return false;
     }



//universal account variables
var streetAddress = document.form1.street_address;
var cityName = document.form1.city;
var stateName = document.form1.state;
var zipCode = document.form1.zip;
var primaryPhone = document.form1.primary_phone;
var cellPhone = document.form1.cell_phone;
var emailAddress = document.form1.email;

if(enableFields == 1) {
      if(enableSwitch.checked == true) {
          document.form1.group_address.disabled = false;
          document.form1.group_phone.disabled = false;
        }else{
          document.form1.group_address.disabled = true;
          document.form1.group_phone.disabled = true;
        }
  }


if(enableSwitch.checked == true) {
streetAddress.disabled = false;
cityName.disabled = false;
stateName.disabled = false;
zipCode.disabled = false;
primaryPhone.disabled = false;
cellPhone.disabled = false;
emailAddress.disabled = false;

}else{
streetAddress.disabled = true;
cityName.disabled = true;
stateName.disabled = true;
zipCode.disabled = true;
primaryPhone.disabled = true;
cellPhone.disabled = true;
emailAddress.disabled = true;
}


}