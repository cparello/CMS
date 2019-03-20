function checkData(num)   {
//alert();

var name = null;
var phone = null;
var notes = null;
var name = document.getElementsByClassName('name')[num].value;
//alert(name); ////document.form19.name.value; this.id('name');
var phone = document.getElementsByClassName('phone')[num].value;
//alert(phone);
var notes = document.getElementsByClassName('notes')[num].value;


//alert(notes);
//check to see if this is the submit button that has been checked
//alert(name);

if(name == "") {
           alert('Please fill out the Name field');
           document.getElementsByClassName('name')[num].focus();
           return false;
}

if(phone == "") {
             alert('Please fill out the Phone Number field');
             document.getElementsByClassName('phone')[num].focus();
             return false;
}
             
phone = phone.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phone)) {
    var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
        document.getElementsByClassName('phone')[num].value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementsByClassName('phone')[num].value = "";
               phone.focus();
               return false;
    }



          if(notes == "") {
             alert('Please fill out the notes field');
             document.getElementsByClassName('notes')[num].focus();
             return false;
             }







}