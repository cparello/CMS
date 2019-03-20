//---------------------------------------------------------------------------------------------------------------------------------------
function setLiabilityHost() {

var openCheck = document.form1.liability_host;
var groupType =  document.form1.group_type.value;

try{
var firstNameLib = newFirstName;
var middleNameLib = newMiddleName;
var lastNameLib = newLastName;
var streetAddressLib = newStreetAddress;
var cityLib = newCity;
var stateOptionLib = newStateOption;
var zipCodeLib = newZipCode;
var homePhoneLib = newHomePhone;
var cellPhoneLib = newCellPhone;
var emailLib = newEmail;
var dobLib = newDob;
var licNumLib = newLicNum;
}
catch (e){
var firstNameLib = "";
var middleNameLib = "";
var lastNameLib = "";
var streetAddressLib = "";
var cityLib = "";
var stateOptionLib = "";
var zipCodeLib = "";
var homePhoneLib = "";
var cellPhoneLib = "";
var emailLib = "";
var dobLib = "";
var licNumLib = "";
}
//alert(openCheck.checked);
//alert('fu');
if(openCheck.checked == true) {


var liabilityForm = '<table id="secTab" align="center" cellpadding="2" class="tabBoard1"><tr class="tabHead"><td colspan="2" class="oBtext">Liability Host Contact/Billing  Information</td><td align="right" class="checkText"></td></tr><tr><td class="black">First Name:</td><td class="black">Middle Name: <span class="dob">(Optional)</span></td><td class="black">Last Name:</td></tr><tr><td><input  name="first_name_lib" type="text" id="first_name_lib" value="'+firstNameLib+'" size="25" maxlength="60"  onFocus="return checkServices(this.name,this.id)"/></td><td><input name="middle_name_lib" type="text" id="middle_name_lib" value="'+middleNameLib+'" size="25" maxlength="100" /></td><td><input  name="last_name_lib" type="text" id="last_name_lib" value="'+lastNameLib+'" size="25" maxlength="30" onFocus="return checkServices(this.name,this.id)"/></td></tr><tr><td class="black">Street Address:</td><td class="black">City:</td><td class="black">State:</td></tr><tr><td><input name="street_address_lib" type="text" id="street_address_lib" value="'+streetAddressLib+'" size="25" maxlength="100"  onFocus="return checkServices(this.name,this.id)"/></td><td><input name="city_lib" type="text" id="city_lib" value="'+cityLib+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td><select  name="state_lib" id="state_lib"  onFocus="return checkServices(this.name,this.id)"/><option value="">Select State</option>'+stateOptionLib+'<option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">Wash. D.C.</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">So. Carolina</option><option value="SD">So. Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select></td></tr><tr><td class="black">Zipcode:</td><td class="black">Primary Phone:</td><td class="black">Cell Phone:</td></tr><tr><td><input name="zip_code_lib" type="text" id="zip_code_lib" value="'+zipCodeLib+'" size="25" maxlength="5"  onFocus="return checkServices(this.name,this.id)"/></td><td><input name="home_phone_lib" type="text" id="home_phone_lib" value="'+homePhoneLib+'" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/></td><td><input  name="cell_phone_lib" type="text" id="cell_phone_lib" value="'+cellPhoneLib+'" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/></td></tr><tr><td class="black">Email Address:</td><td class="black">Date of Birth: <span class="dob_lib">(mm/dd/yyyy)</span></td><td class="black"></td></tr><tr><td class="pad"><input  name="email_lib" type="text" id="email_lib" value="'+emailLib+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="dob_lib" type="text" id="dob_lib" value="'+dobLib+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"></td></tr></table>';

document.getElementById('libHost').innerHTML = liabilityForm;

//document.getElementById('typeHead1').innerHTML = "Member Information ";

}else{

this.newFirstName = document.getElementsByName('first_name_lib').item(0).value;
this.newMiddleName = document.getElementsByName('middle_name_lib').item(0).value;
this.newLastName = document.getElementsByName('last_name_lib').item(0).value;
this.newStreetAddress = document.getElementsByName('street_address_lib').item(0).value;
this.newCity = document.getElementsByName('city_lib').item(0).value;

   //this sets up the state selected and option value
   var stateNameObject = document.getElementsByName('state_lib').item(0);
   var optionIndex = stateNameObject.selectedIndex;  
   var stateName = stateNameObject.options[optionIndex].text;
   var stateValue = stateNameObject.value;   
   this.newStateOption = '<option selected value="'+ stateValue +'">' +stateName + '</option>';
   
this.newZipCode = document.getElementsByName('zip_code_lib').item(0).value;
this.newHomePhone = document.getElementsByName('home_phone_lib').item(0).value;
this.newCellPhone = document.getElementsByName('cell_phone_lib').item(0).value;
this.newEmail = document.getElementsByName('email_lib').item(0).value;
this.newDob = document.getElementsByName('dob_lib').item(0).value;
this.newLicNum = document.getElementsByName('lic_num_lib').item(0).value;

document.getElementById('libHost').innerHTML = "";

/*if(groupType == "S")  {
  var memText = "Member Information "
  }else{
  var memText = "Primary Member Information "
  }

document.getElementById('typeHead1').innerHTML = memText;*/
}

}
//-------------------------------------------------------------------------------------------------------------------------------------
function passEmgContact(memNum) {

if(document.getElementById('contSet').checked == true)  {

var bool = confirm('This will transfer all of the emergency contact information from the \"Emergency Contact Information 1\" section to the  \"Emergency Contact Information\" sections 2 through '+memNum+'.  This will overwrite any contact information currently in these sections. Do you wish to continue?');
	if (bool == 0){
		return false;
	}

var emgName;
var emgRelation;
var emgPhone;

var j = 0;
var i = 1;


        var emgNameArray = document.getElementsByName('econt_name[]');
        var emgRelationArray = document.getElementsByName('econt_relation[]');
        var emgPhoneArray = document.getElementsByName('econt_phone[]');

        emgName = emgNameArray[j].value;
        emgRelation = emgRelationArray[j].value;
        emgPhone = emgPhoneArray[j].value;
        
          //make sure all of the fields arefilled out before passing the address info
         if(emgName == "" ||  emgName =="" ||  emgPhone == "")  {
   
         alert('Please fill out all of the emergency contact fields in this section  before choosing this option');
                 return false;
             }
        

          for(i=1; i <= memNum; i++) {
          emgNameArray[i].value = emgName;
          emgRelationArray[i].value = emgRelation;
          emgPhoneArray[i].value = emgPhone;          
          }


}

}
//------------------------------------------------------------------------------------------------------------------------------------
function passAddress(memNum)  {

if(document.getElementById('addSet').checked == true)  {

var bool = confirm('This will transfer all of the address information from this section to the  \"Member Information\" sections 2 through '+memNum+'.  This will overwrite any address information currently in these sections. Do you wish to continue?');
	if (bool == 0){
		return false;
	}

var streetAddress;
var cityName;
var stateName;
var stateValue;
var optionIndex;
var stateOption;
var zipCode;
var j = 0;
var i = 1;

        var streetAddressArray = document.getElementsByName('street_address[]');
        var cityNameArray = document.getElementsByName('city[]');
        var stateNameArray = document.getElementsByName('state[]');
        var zipCodeArray = document.getElementsByName('zip_code[]');


   streetAddress = streetAddressArray[j].value;
   cityName = cityNameArray[j].value;
   
   //this sets up the state selected and option value
   optionIndex = stateNameArray[j].selectedIndex;
   stateName = stateNameArray[j].options[optionIndex].text;
   stateValue = stateNameArray[j].value;   
   stateOption = '<option selected value="'+ stateValue +'">' +stateName + '</option>';
   
   zipCode = zipCodeArray[j].value;
   
   
   //make sure all of the fields arefilled out before passing the address info
   if(streetAddress == "" ||  cityName =="" ||  stateValue == "" || zipCode == "")  {
   
         alert('Please fill out all of the address information fields in this section  before choosing this option');
              return false;
             }
   

                   for(i=1; i <= memNum; i++) {
                        streetAddressArray[i].value = streetAddress;
                        cityNameArray[i].value = cityName;
                        stateNameArray[i].value = stateValue;
                        zipCodeArray[i].value = zipCode;
                        }

}

}
//-------------------------------------------------------------------------------------------------------------------------------------
function getContactForms(memNum)    {

var contactForms = "";
var primary;
var numHead;

//set the variables for the form values
var firstName;
var middleName;
var lastName;
var streetAddress;
var cityName;
var stateName;
var stateValue;
var optionIndex;
var stateOption;
var zipCode;
var homePhone;
var cellPhone;
var emailAddress;
var birthDate;
var licenseNumber;
var emgName;
var emgRelation;
var emgPhone;

var arrayLength;


//sets up the transfer switch for address and Emerg contact ifo if multiple fields
if(memNum == 1) {
   var addressSet = "";
   var contactSet = "";
  }else{ 
  var addressSet = 'Set as Default Address:&nbsp;<input type="checkbox" id="addSet" name="address_field" value="on" onClick="return  passAddress('+memNum+')">';
  var contactSet = 'Set as Default Contact:&nbsp;<input type="checkbox" id="contSet"  name="contact_field" value="on" onClick="return passEmgContact('+memNum+')">';
 }



var j = 0;


        var firstNameArray = document.getElementsByName('first_name[]');
        var middleNameArray = document.getElementsByName('middle_name[]');
        var lastNameArray = document.getElementsByName('last_name[]');
        var streetAddressArray = document.getElementsByName('street_address[]');
        var cityNameArray = document.getElementsByName('city[]');
        var stateNameArray = document.getElementsByName('state[]');
        var zipCodeArray = document.getElementsByName('zip_code[]');
        var homePhoneArray = document.getElementsByName('home_phone[]');
        var cellPhoneArray = document.getElementsByName('cell_phone[]');
        var emailAddressArray = document.getElementsByName('email[]');
        var birthDateArray = document.getElementsByName('dob[]');
        var licenseNumberArray = document.getElementsByName('lic_num[]');
        var emgNameArray = document.getElementsByName('econt_name[]');
        var emgRelationArray = document.getElementsByName('econt_relation[]');
        var emgPhoneArray = document.getElementsByName('econt_phone[]');

       //sets up the index tabs
        var tabOne = 20;
        


        
              //this sets up the array length we will use first name since all of the lengths are the same
              arrayLength = firstNameArray.length;
          

for(i=1; i <= memNum; i++) {
//this sets up the number of the header on the form
numHead = i;

              if(i == 1) {
                primary = contactHeader;
                        if(primary == "Member Information")  {
                               numHead = "";
                          }
                          
                }else{
                primary = "Member Informaton";
                addressSet = "";
                contactSet = "";
                 
                }
                
                
                
                
        
//sets up the form fields
if(j < arrayLength)  {
  
   firstName = firstNameArray[j].value;
   middleName = middleNameArray[j].value;
   lastName = lastNameArray[j].value;
   streetAddress = streetAddressArray[j].value;
   cityName = cityNameArray[j].value;
   
   //this sets up the state selected and option value
   optionIndex = stateNameArray[j].selectedIndex;
   stateName = stateNameArray[j].options[optionIndex].text;
   stateValue = stateNameArray[j].value;   
   stateOption = '<option selected value="'+ stateValue +'">' +stateName + '</option>';
   
   zipCode = zipCodeArray[j].value;
   homePhone = homePhoneArray[j].value;
   cellPhone = cellPhoneArray[j].value;
   emailAddress = emailAddressArray[j].value;
   birthDate = birthDateArray[j].value;
   licenseNumber = licenseNumberArray[j].value;
   
   emgName = emgNameArray[j].value;
   emgRelation = emgRelationArray[j].value;
   emgPhone = emgPhoneArray[j].value;
   
}
                

contactForms += '<table id="firstTab' + i + '" align="center" cellpadding="2" class="tabBoard1"width="100%" border="0"><tr class="tabHead"><td colspan="2" class="oBtext"><span id="typeHead'+ i +'">'+ primary + ' </span>' + numHead + '</td><td align="right" class="checkText" colspan="2"><div id="addSet'+i+'">'+addressSet+'</div></td></tr><tr><td class="black">First Name:</td><td class="black">Middle Name: <span class="dob">(Optional)</span></td><td class="black" colspan="2">Last Name:</td></tr><tr><td><input  name="first_name[]" type="text" id="first_name'+ i +'" value="'+firstName+'" size="25" maxlength="60"  onFocus="return checkServices(this.name, this.id)"/></td><td><input name="middle_name[]" type="text" id="middle_name'+ i +'" value="'+middleName+'" size="25" maxlength="100" /></td><td><input  name="last_name[]" type="text" id="last_name'+ i +'" value="'+lastName+'" size="25" maxlength="30"   onFocus="return checkServices(this.name,this.id)"/></td><td rowspan="7" valign="top">&nbsp;</td></tr><tr><td class="black">Street Address:</td><td class="black">City:</td><td class="black">State:</td></tr><tr><td><input name="street_address[]" type="text" id="street_address' + i + '" value="'+streetAddress+'" size="25" maxlength="100"  onFocus="return checkServices(this.name,this.id)"/></td><td><input name="city[]" type="text" id="city'+ i +'" value="'+cityName+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td><select  name="state[]" id="state' + i +'"  onFocus="return checkServices(this.name,this.id)"/><option value="">Select State</option>'+stateOption+'<option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DE">Delaware</option><option value="DC">Wash. D.C.</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">So. Carolina</option><option value="SD">So. Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option></select></td></tr><tr><td class="black">Zipcode:</td><td class="black">Primary Phone:</td><td class="black">Cell Phone:</td></tr><tr><td><input name="zip_code[]" type="text" id="zip_code'+ i +'" value="'+zipCode+'" size="25" maxlength="5"  onFocus="return checkServices(this.name,this.id)"/></td><td><input name="home_phone[]" type="text" id="home_phone' + i +'" value="'+homePhone+'" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/></td><td><input  name="cell_phone[]" type="text" id="cell_phone' + i +'" value="'+cellPhone+'" size="25" maxlength="15"  onFocus="return checkServices(this.name,this.id)"/></td></tr><tr><td class="black">Email Address:</td><td class="black">Date of Birth: <span class="dob">(mm/dd/yyyy)</span></td><td class="black">Drivers License:</td></tr><tr><td class="pad"><input  name="email[]" type="text" id="email' + i + '" value="'+emailAddress+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="dob[]" type="text" id="dob'+ i +'" value="'+birthDate+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="lic_num[]" type="text" id="lic_num' + i + '" value="'+licenseNumber+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td></tr><tr class="tabHead"><td colspan="3" class="oBtext">Emergency Contact Information ' + numHead + '</td><td align="right" class="checkText"><div id="contactSet'+1+'">'+contactSet+'</div></td></tr><tr><td class="black">Contact Name:</td><td class="black">Relationship:</td><td colspan="2"class="black">Contact Phone:</td></tr><tr><td class="pad"><input  name="econt_name[]" type="text" id="econt_name'+ i +'" value="'+emgName+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="econt_relation[]" type="text" id="econt_relation'+ i +'" value="'+emgRelation+'" size="25" maxlength="30"   onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="econt_phone[]" type="text" id="econt_phone'+ i +'" value="'+emgPhone+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td><td valign="top"><input type="button" class="button1" name="liability_form" value="Print Waiver" onClick="printLiabilityForm('+j+');"/></td></tr></table>';




//reset the names so that they do not duplicate in fields
firstName = "";
middleName = "";
lastName = "";
streetAddress = "";
cityName = "";
stateOption = "";
zipCode = "";
homePhone = "";
cellPhone = "";
emailAddress = "";
birthDate = "";
licenseNumber = "";
emgName = "";
emgRelation = "";
emgPhone = "";

j++;


}

return contactForms;

}
//-------------------------------------------------------------------------------------------------------------------------------------
function getGroupTypeForm(groupName)  {

var typeName;
var typeAddress;
var typePhone;

try {
typeName = document.getElementsByName('type_name').item(0).value;
typeAddress = document.getElementsByName('type_address').item(0).value;
typePhone = document.getElementsByName('type_phone').item(0).value;
}
catch(e)
{
typeName = "";
typeAddress = "";
typePhone = "";
}

var groupForm = '<table></table><table id="secTab" align="center" cellpadding="2" class="tabBoard2"><tr class="tabHead"><td colspan="3" class="oBtext">'+ groupName + ' Information </td></tr><tr><td class="black">'+ groupName +' Name:</td><td class="black">'+ groupName + ' Address:</td><td class="black">' + groupName +' Phone:</td></tr><tr><td class="pad"><input  name="type_name" type="text" id="type_name" value="'+typeName+'" size="30" maxlength="30" onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="type_address" type="text" id="type_address" value="'+typeAddress+'" size="50" maxlength="50"  onFocus="return checkServices(this.name,this.id)"/></td><td class="pad"><input  name="type_phone" type="text" id="type_phone" value="'+typePhone+'" size="25" maxlength="30"  onFocus="return checkServices(this.name,this.id)"/></td></tr></table>';


return  groupForm;

}
//-------------------------------------------------------------------------------------------------------------------------------
function setContactDivs(memNum)  {

if(memNum == "") {
return "";
}

var openCheck = document.form1.liability_host;
var groupType =  document.form1.group_type.value;
var contactHeader;
var groupInfo;
var contactForms;
var allForms

switch(groupType)  {
case 'S':
    if(openCheck.checked == true) {
        this.contactHeader = "Member Information ";
        }else{
        this.contactHeader = 'Member Contact Information';
      }
 groupInfo = "<table></table>";
break;
case 'F':
    if(openCheck.checked == true) {
        this.contactHeader = "Member Information ";
        }else{
        this.contactHeader = 'Primary Member Contact Information';
      }
 groupInfo = "<table></table>";
break;
case 'B':
    if(openCheck.checked == true) {
        this.contactHeader = "Member Information ";
        }else{
        this.contactHeader = 'Primary Member Contact Information';
      }
 groupInfo = getGroupTypeForm('Business');
break;

case 'O':
    if(openCheck.checked == true) {
        this.contactHeader = "Member Information ";
        }else{
        this.contactHeader = 'Primary Member Contact Information';
      }
 groupInfo = getGroupTypeForm('Organization');
break;  
}


contactForms = getContactForms(memNum);

document.getElementById('groupInfo').innerHTML = groupInfo;
document.getElementById('userForm1').innerHTML = contactForms;


}

//------------------------------------------------------------------------------------------------------------------
function setNoteTopic(topicValue)  {
document.form1.note_topic.value = topicValue;
}

//------------------------------------------------------------------------------------------------------------------
function setNoteBody(noteValue) {
document.form1.note_body.value = noteValue;
}
//------------------------------------------------------------------------------------------------------------------