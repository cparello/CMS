function checkData()   {
var merch1a = document.form1.merchant_id.value;
var merch1b = document.form1.merchant_id;
var aMode1a = document.form1.account_mode.value;
var aMode1b = document.form1.account_mode;
var score ="_";
var err1 = document.getElementById("conf");

if(merch1a == "")  {
 err1.innerHTML= '<span class="errors">Merchant ID field cannot be blank</span>';
 merch1b.focus();                          
 return false;
 }
 if(merch1a.length < 3)  {
 err1.innerHTML= '<span class="errors">Merchant ID is too short</span>';
 merch1b.focus();                          
 return false;        
 }
if(merch1a.indexOf(score)==-1 || merch1a.indexOf(score)==0) {
 err1.innerHTML= '<span class="errors">Merchant ID must contain an underscore</span>';
 merch1b.focus();                          
 return false;     
}
if(aMode1a == "") {
 err1.innerHTML= '<span class="errors">Please select a Processor Mode</span>';
 aMode1b.focus();                          
 return false;      
}

var response =  confirm('WARNING! This will permently change your Transaction Processor options.  If you are unsure of these values do not make these  changes as it might effect the ability of this software to process transactions.  Do you wish to continue?');
           if(!response) {         
              return false;
             }     


}
//------------------------------------------------------------------------------------------------------------
function checkDataTwo()   {

var csUserNameVal = document.form2.cs_user_name.value;
var csUserNameField = document.form2.cs_user_name;
var csPasswordVal = document.form2.cs_password.value;
var csPasswordField = document.form2.cs_password;
var csSettleModeVal = document.form2.settle_mode.value;
var casSettleModeField = document.form2.settle_mode;
var err1 = document.getElementById("conf");

if(csUserNameVal == "")  {
 err1.innerHTML= '<span class="errors">User Name field cannot be blank</span>';
 csUserNameField.focus();                          
 return false;
 }

if(csPasswordVal == "")  {
 err1.innerHTML= '<span class="errors">Password field cannot be blank</span>';
 csPasswordField.focus();                          
 return false;
 }

if(csSettleModeVal == "") {
 err1.innerHTML= '<span class="errors">Please select a Settlement Mode</span>';
 casSettleModeField.focus();                          
 return false;      
}

var response =  confirm('WARNING! This will permently change your Transaction Settlement options.  If you are unsure of these values do not make these  changes as it might effect the ability of this software to process transactions.  Do you wish to continue?');
           if(!response) {         
              return false;
             }                             

}
//-------------------------------------------------------------------------------------------------------------
function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}