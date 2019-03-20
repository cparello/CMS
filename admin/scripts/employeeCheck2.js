function compChange(fromWhere) {

var txt1a=document.getElementById("pay1a");
var txt1b=document.getElementById("pay1b");
var txt2a=document.getElementById("pay2a");
var txt2b=document.getElementById("pay2b");
var txt3a=document.getElementById("pay3a");
var txt3b=document.getElementById("pay3b");
var txt4a=document.getElementById("pay4a");
var txt4b=document.getElementById("pay4b");
var err4=document.getElementById("error4");
var err5=document.getElementById("error5");
var err6=document.getElementById("error6");
var err7=document.getElementById("error7");

switch(fromWhere)   {
case 1:
var selIdx = document.form1.compensation_type1.selectedIndex;
var newSel = document.form1.compensation_type1[selIdx].value;
if(newSel == "C") {
   txt1a.innerHTML= "";
   txt1b.innerHTML= "";
   err4.innerHTML= "";
   }else{
   txt1a.innerHTML='Payment Amount:';
   txt1b.innerHTML='<input  name="payment_amount1" type="text" id="payment_amount" value="" size="25" maxlength="100" />';
  }
break;
case 2:
var selIdx = document.form1.compensation_type2.selectedIndex;
var newSel = document.form1.compensation_type2[selIdx].value;
if(newSel == "C") {
   txt2a.innerHTML= "";
   txt2b.innerHTML= ""; 
   err4.innerHTML= "";
   err5.innerHTML= "";   
   }else{
   txt2a.innerHTML='Payment Amount:';
   txt2b.innerHTML='<input  name="payment_amount2" type="text" id="payment_amount2" value="" size="25" maxlength="100" />';
  }
break;
case  3:
var selIdx = document.form1.compensation_type3.selectedIndex;
var newSel = document.form1.compensation_type3[selIdx].value;
if(newSel == "C") {
   txt3a.innerHTML= "";
   txt3b.innerHTML= "";  
   err4.innerHTML= "";
   err5.innerHTML= ""; 
   err6.innerHTML= ""; 
   }else{
   txt3a.innerHTML='Payment Amount:';
   txt3b.innerHTML='<input  name="payment_amount3" type="text" id="payment_amount3" value="" size="25" maxlength="100" />';
  }  
break;
case  4:
var selIdx = document.form1.compensation_type4.selectedIndex;
var newSel = document.form1.compensation_type4[selIdx].value;
if(newSel == "C") {
   txt4a.innerHTML= "";
   txt4b.innerHTML= ""; 
   err4.innerHTML= "";
   err5.innerHTML= ""; 
   err6.innerHTML= ""; 
   err7.innerHTML= "";    
   }else{
   txt4a.innerHTML='Payment Amount:';
   txt4b.innerHTML='<input  name="payment_amount4" type="text" id="payment_amount4" value="" size="25" maxlength="100" />';
  }  
break;
}

}

//this sets the type of submit button
//==========================================================================================

//====================================================================================
//this puts all of the fields back to normal if altered by onchage statements
function checkField()  {

var subBut1 =document.getElementById("sub1");
var  err1=document.getElementById("error1");
var  err2=document.getElementById("error2");
var  err3=document.getElementById("error3");
var  err4=document.getElementById("error4");
var  err5=document.getElementById("error5");
var err6=document.getElementById("error6");
var err7=document.getElementById("error7");

var txt1a=document.getElementById("pay1a");
var txt1b=document.getElementById("pay1b");
var txt2a=document.getElementById("pay2a");
var txt2b=document.getElementById("pay2b");
var txt3a=document.getElementById("pay3a");
var txt3b=document.getElementById("pay3b");
var txt4a=document.getElementById("pay4a");
var txt4b=document.getElementById("pay4b");

 txt1a.innerHTML='Payment Amount:';
 txt1b.innerHTML='<input  name="payment_amount1" type="text" id="payment_amount1" value="" size="25" maxlength="100" />';
 txt2a.innerHTML='Payment Amount:';
 txt2b.innerHTML='<input  name="payment_amount2" type="text" id="payment_amount2" value="" size="25" maxlength="100" />';
 txt3a.innerHTML='Payment Amount:';
 txt3b.innerHTML='<input  name="payment_amount3" type="text" id="payment_amount3" value="" size="25" maxlength="100" />';
 txt4a.innerHTML='Payment Amount:';
 txt4b.innerHTML='<input  name="payment_amount4" type="text" id="payment_amount4" value="" size="25" maxlength="100" />';
 
subBut1.innerHTML = '<input  type="submit" name="save" value="Add Employee" />&nbsp;&nbsp;<input type="reset" value="Reset"><input name="marker" type="hidden" id="marker" value="1" />';
       
err1.innerHTML ="";     
err2.innerHTML ="";     
err3.innerHTML =""; 
err4.innerHTML =""; 
err5.innerHTML =""; 
err6.innerHTML =""; 
err7.innerHTML =""; 
}

//====================================================================================
function checkData() {

var  err1=document.getElementById("error1");
var  err2=document.getElementById("error2");
var  err3=document.getElementById("error3");
var  err4=document.getElementById("error4");
var  err5=document.getElementById("error5");
var  err6=document.getElementById("error6");
var  err7=document.getElementById("error7");

var firstName1a = document.form1.first_name.value;
var firstName1b = document.form1.first_name;
var lastName1a = document.form1.last_name.value;
var lastName1b = document.form1.last_name;
var streetAddress1a = document.form1.street_address.value;
var streetAddress1b = document.form1.street_address;
var city1a = document.form1.city.value;
var city1b = document.form1.city;
var state1a = document.form1.state.value;
var state1b = document.form1.state;
var zipCode1a = document.form1.zip_code.value;
var zipCode1b = document.form1.zip_code;
var homePhone1a = document.form1.home_phone.value;
var homePhone1b = document.form1.home_phone;
var socialNumber1a = document.form1.ss_number.value;
var socialNumber1b = document.form1.ss_number;

var emergencyContact1a = document.form1.emergency_contact.value;
var emergencyContact1b = document.form1.emergency_contact;
var emergencyPhone1a = document.form1.emergency_phone.value;
var emergencyPhone1b = document.form1.emergency_phone;

var employeeType1a = document.form1.employee_type1.value;
var employeeType1b = document.form1.employee_type1;
var compensationType1a = document.form1.compensation_type1.value;
var compensationType1b = document.form1.compensation_type1;
var paymentCycle1a = document.form1.payment_cycle1.value;
var paymentCycle1b = document.form1.payment_cycle1;

var employeeType2a = document.form1.employee_type2.value;
var employeeType2b = document.form1.employee_type2;
var paymentCycle2a = document.form1.payment_cycle2.value;
var paymentCycle2b = document.form1.payment_cycle2;
var compensationType2a = document.form1.compensation_type2.value;
var compensationType2b = document.form1.compensation_type2;

var employeeType3a = document.form1.employee_type3.value;
var employeeType3b = document.form1.employee_type3;
var paymentCycle3a = document.form1.payment_cycle3.value;
var paymentCycle3b = document.form1.payment_cycle3;
var compensationType3a = document.form1.compensation_type3.value;
var compensationType3b = document.form1.compensation_type3;

var employeeType4a = document.form1.employee_type4.value;
var employeeType4b = document.form1.employee_type4;
var paymentCycle4a = document.form1.payment_cycle4.value;
var paymentCycle4b = document.form1.payment_cycle4;
var compensationType4a = document.form1.compensation_type4.value;
var compensationType4b = document.form1.compensation_type4;

if(firstName1a == "")  {
   err1.innerHTML= '<span class="errors">Please Enter a First Name</span>';
   firstName1b.focus();                          
   return false;
  }
if(lastName1a == "")  {
   err1.innerHTML= '<span class="errors">Please Enter a Last Name</span>';
   lastName1b.focus();                          
   return false;
  }
if(streetAddress1a == "")  {
   err1.innerHTML= '<span class="errors">Please Enter a Street Address</span>';
   streetAddress1b.focus();                          
   return false;
  }
if(city1a == "")  {
   err1.innerHTML= '<span class="errors">Please Enter a City</span>';
   city1b.focus();                          
   return false;
  }
if(state1a == "")  {
   err1.innerHTML= '<span class="errors">Please Select a State</span>';
   state1b.focus();                          
   return false;
  }
if(zipCode1a == "")  {
 err1.innerHTML= '<span class="errors">Please Enter a Zip Code</span>';
 zipCode1b.focus();                          
 return false;
 }
if(isNaN(zipCode1a)) {
err1.innerHTML= '<span class="errors">Zip Code must be a Number</span>';
zipCode1b.focus();                          
return false;
 }
if(homePhone1a == "")  {
err1.innerHTML= '<span class="errors">Please Enter a Primary Phone Number</span>';
homePhone1b.focus();                          
return false;
 }


if(emergencyContact1a == "")  {
err2.innerHTML= '<span class="errors">Please Enter a Contact Name</span>';
emergencyContact1b.focus();  
err1.innerHTML="";
return false;
 }
if(emergencyPhone1a == "")  {
err2.innerHTML= '<span class="errors">Please Enter a Contact Phone</span>';
emergencyPhone1b.focus();  
err1.innerHTML="";
return false;
 }


//this sets the validity of the user name which must be an email address
// this checks the validity of the user name to see if it is a valid email address
var id1 = document.form1.user_name1.value;
var id2 = document.form1.user_name1;
var id3 = document.form1.pass_word1.value;
var id4 = document.form1.pass_word1;
var id5 = document.form1.pass_word2.value;
var id6 = document.form1.pass_word2;

var x = id1;
var y = id3;
var z = id5;
id1 = (x.replace(/^\W+/,'')).replace(/\W+$/,'');
id3 = (y.replace(/^\W+/,'')).replace(/\W+$/,'');
id5 = (z.replace(/^\W+/,'')).replace(/\W+$/,'');


var at="@";
var dot=".";
var lat=id1.indexOf(at);
var lstr=id1.length;
var ldot=id1.indexOf(dot);

        if(id1 == "")  {
          err3.innerHTML= '<span class="errors">Please supply a user name</span>';
          id2.focus();  
          err1.innerHTML="";
          err2.innerHTML="";
          return false;
        }
        
		if(id1.indexOf(at)==-1){
		   err3.innerHTML= '<span class="errors">Invalid user name</span>';
           id2.focus();
		   return false;
		}

		if(id1.indexOf(at)==-1 || id1.indexOf(at)==0 || id1.indexOf(at)==lstr){
		   err3.innerHTML= '<span class="errors">Invalid user name</span>';
           id2.focus();
		   return false;
		}

		if(id1.indexOf(dot)==-1 || id1.indexOf(dot)==0 || id1.indexOf(dot)==lstr){
		   err3.innerHTML= '<span class="errors">Invalid user name</span>';
           id2.focus();
		    return false;
		}

		 if(id1.indexOf(at,(lat+1))!=-1){
		    err3.innerHTML= '<span class="errors">Invalid user name</span>';
            id2.focus();
		    return false;
		 }

		 if(id1.substring(lat-1,lat)==dot || id1.substring(lat+1,lat+2)==dot){
		    err3.innerHTML= '<span class="errors">Invalid user name</span>';
            id2.focus();
		    return false;
		 }

		 if(id1.indexOf(dot,(lat+2))==-1){
		    err3.innerHTML= '<span class="errors">Invalid user name</span>';
            id2.focus();
		    return false;
		 }
		
		 if(id1.indexOf(" ")!=-1){
		    err3.innerHTML= '<span class="errors">Invalid user name</span>';
            id2.focus();
		    return false;		 
         }
        

//This contains A to Z , 0 to 9 and A to B checks to see if there are letters and numbers
if(id3 == "") {
err3.innerHTML= '<span class="errors">Please Supply a Password</span>';
id4.focus();
err1.innerHTML="";
err2.innerHTML="";
return false;
}

   if(id3.length < 6)  {
           err3.innerHTML= '<span class="errors">Password is too short</span>';
           id4.focus();                          
           return false;        
        }
             
         if(id3.length > 10)  {
           err3.innerHTML= '<span class="errors">Password is too long</span>';
           id4.focus();                          
           return false;        
        }

//this checks the validity of the password
var regexNum = /\d/;
var regexLetter = /[a-zA-z]/;
if(!regexNum.test(id3) || !regexLetter.test(id3)){
err3.innerHTML= '<span class="errors">Invalid Password</span>';
id4.focus();
return false;
}     

if(id5 == "") {
err3.innerHTML= '<span class="errors">Please Verify Password</span>';
id6.focus();
return false;
}     

if(id5 != id3) {
err3.innerHTML= '<span class="errors">Passwords do not Match</span>';
id6.focus();
return false;
}     



//make sure a ss number is present
if(socialNumber1a == "")  {
err3.innerHTML= '<span class="errors">Please Enter a Social Security Number</span>';
socialNumber1b.focus();                          
return false;
 }
if(isNaN(socialNumber1a)) {
err3.innerHTML= '<span class="errors">Social Security Number must be a Number</span>';
socialNumber1b.focus();                          
return false;
 }
if(socialNumber1a.length < 9)  {
err3.innerHTML= '<span class="errors">Social Security Number is too short</span>';
socialNumber1b.focus();                          
return false;        
 }




//process if emp type is selected
if(employeeType1a != "") {
err1.innerHTML="";
err2.innerHTML="";
err3.innerHTML="";


if(paymentCycle1a == "") {
err4.innerHTML= '<span class="errors">Please Select a Payment Cycle</span>';
paymentCycle1b.focus();
return false;
}     

if(compensationType1a == "") {
err4.innerHTML= '<span class="errors">Please Select a Compensation Type</span>';
compensationType1b.focus();
return false;
}     



//check to see iff commission is selected then test
if(compensationType1a != "C")  {
    var paymentAmount1a = document.form1.payment_amount1.value;
    var paymentAmount1b = document.form1.payment_amount1;

     if(paymentAmount1a == "") {
      err4.innerHTML= '<span class="errors">Please Enter a Payment Amount</span>';
      paymentAmount1b.focus();
      return false;    
      }
   }
}

//check to see if other emp types are filled out
if(employeeType2a != "") {
   err1.innerHTML="";
   err2.innerHTML="";
   err3.innerHTML="";
   err4.innerHTML="";

        if(paymentCycle2a == "") {
            err5.innerHTML= '<span class="errors">Please Select a Payment Cycle</span>';
            paymentCycle2b.focus();
            return false;
           }     

        if(compensationType2a == "") {
            err5.innerHTML= '<span class="errors">Please Select a Compensation Type</span>';
            compensationType2b.focus();
            return false;
           }     

//check to see iff commission is selected then test
if(compensationType2a != "C")  {
    var paymentAmount2a = document.form1.payment_amount2.value;
    var paymentAmount2b = document.form1.payment_amount2;

     if(paymentAmount2a == "") {
      err5.innerHTML= '<span class="errors">Please Enter a Payment Amount</span>';
      paymentAmount2b.focus();
      return false;    
      }
   }
}   
//--------------------------------------------------------------------------------------------------------------------
if(employeeType3a != "") {
   err1.innerHTML="";
   err2.innerHTML="";
   err3.innerHTML="";
   err4.innerHTML="";
   err5.innerHTML="";
   
        if(paymentCycle3a == "") {
            err6.innerHTML= '<span class="errors">Please Select a Payment Cycle</span>';
            paymentCycle3b.focus();
            return false;
           }     

        if(compensationType3a == "") {
            err6.innerHTML= '<span class="errors">Please Select a Compensation Type</span>';
            compensationType3b.focus();
            return false;
           }     

//check to see iff commission is selected then test
if(compensationType3a != "C")  {
    var paymentAmount3a = document.form1.payment_amount3.value;
    var paymentAmount3b = document.form1.payment_amount3;

     if(paymentAmount3a == "") {
      err6.innerHTML= '<span class="errors">Please Enter a Payment Amount</span>';
      paymentAmount3b.focus();
      return false;    
      }
   }
}    
//-----------------------------------------------------------------------------------------------------------------------
if(employeeType4a != "") {
   err1.innerHTML="";
   err2.innerHTML="";
   err3.innerHTML="";
   err4.innerHTML="";
   err5.innerHTML="";
   err6.innerHTML="";
   
        if(paymentCycle4a == "") {
            err7.innerHTML= '<span class="errors">Please Select a Payment Cycle</span>';
            paymentCycle4b.focus();
            return false;
           }     

        if(compensationType4a == "") {
            err7.innerHTML= '<span class="errors">Please Select a Compensation Type</span>';
            compensationType4b.focus();
            return false;
           }     

//check to see iff commission is selected then test
if(compensationType4a != "C")  {
    var paymentAmount4a = document.form1.payment_amount4.value;
    var paymentAmount4b = document.form1.payment_amount4;

     if(paymentAmount4a == "") {
      err7.innerHTML= '<span class="errors">Please Enter a Payment Amount</span>';
      paymentAmount4b.focus();
      return false;    
      }
   }
}    

}

//======================================================================


















