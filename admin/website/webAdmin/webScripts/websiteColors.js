function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}
//================================================
function checkNan(numberValue, fieldFocus, fieldTitle)  {

if(isNaN(numberValue)) {
  alert('The  \"' +fieldTitle+ '\" value you entered is not a number.');
  fieldFocus.focus();
  return false;
  }

}
//================================================
function checkDayMonth(month, day) {

switch(month)  {
case '01':
 if(day > 31) {
 return false;
 }
break;
case '02':
if(day > 29) {
return false;
}
break;
case '03':
if(day > 31) {
return false;
}
break;
case '04':
if(day > 30) {
return false;
}
break;  
case '05':
if(day >31) {
return false;
}
break;  
case '06':
if(day > 30) {
return false;
}
break;  
case '07':
if(day > 31) {
return false;
}
break; 
case '08':
if(day > 31) {
return false;
}
break; 
case '09':
if(day > 30) {
return false;
}
break; 
case '10':
if(day > 31) {
return false;
}
break;  
case '11':
if(day >30) {
return false;
}
break;  
case '12':
if(day > 31) {
return false;
}
break;  
}


}

//================================================
function checkDateFormat(dateValue, dateField, fieldTitle)  {

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dateValue)) {
   alert('You have entered an invalid Date format in the \"' +fieldTitle+ '\"  field. Please use \"mm/dd/yyyy\" ');
   dateField.focus();
   return false;
   }else{
     var dateArray = dateValue.split( '/' );
      if(dateArray[0] > 12) {
        alert('You have entered an invalid month in the \"' +fieldTitle+ '\"  field.');      
        dateField.focus();
        return false;
        }
        
      if(dateArray[1] > 31) {
         alert('You have entered an invalid day in the \"' +fieldTitle+ '\"  field.');    
         dateField.focus();
         return false; 
        }else{
               var boon = checkDayMonth(dateArray[0], dateArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered  in the \"' +fieldTitle+ '\"  field exceeds the number of days in the month');
                                   dateField.focus();                                  
                                   return false;                                                                   
                                  }       
        }
      
                 
   }

}


//=========================================================
function parsePaymentValues(fieldValue, fieldName)   {

if(fieldValue != "")  {

var cycleDivisor = 0;
var summarySentence;
var feePayment = 0;

if(fieldName == "eft_enhancement_cycle") {   
      var feeTotal = document.form1.enhance_fee_total.value;
             feeTotal = parseFloat(feeTotal);
      var summaryText =   'Enhancement';  
      var paymentField = document.form1.enhance_fee_payment;
      var descriptText = document.getElementById("enhance_text");
    }
if(fieldName == "eft_guarantee_cycle") {   
      var feeTotal = document.form1.guarantee_fee_total.value;
            feeTotal = parseFloat(feeTotal);
      var summaryText =   'Guarantee';  
      var paymentField = document.form1.guarantee_fee_payment;
      var descriptText = document.getElementById("guarantee_text");
    }


 switch(fieldValue)  {
            case 'A':
            cycleDivisor = 1; 
            summarySentence = 'Annual '+summaryText+' Fee';            
            break;
            case 'B':
            cycleDivisor = 2;  
            summarySentence = 'Bi-Annual '+summaryText+' Fee';
            break;
            case 'Q':
            cycleDivisor = 4; 
            summarySentence = 'Quarterly '+summaryText+' Fee';
            break;
            case 'M':
            cycleDivisor = 12; 
            summarySentence = 'Monthly '+summaryText+' Fee';
            break;  
         }

//calc the payment fee         
feePayment = feeTotal / cycleDivisor;
feePayment = feePayment.toFixed(2);

paymentField.value = feePayment;
descriptText.innerHTML = summarySentence;


}

}
//=================================================================
function checkData()  {

var billingDay = document.form1.billing_day.value;
var billingDayField = document.form1.billing_day;
var billingDayName = 'Billing Day';

var pifEnhanceDate = document.form1.pif_enhance_date.value;
var pifEnhanceDateField = document.form1.pif_enhance_date;
var pifEnhanceDateName = 'Paid In Full Members';

var eftEnhanceCycle = document.form1.eft_enhancement_cycle.value;
var eftEnhanceCycleField = document.form1.eft_enhancement_cycle;
var eftEnhanceCycleName = 'Monthy Members Enhancement Menu';

var guaranteeAnnualDate = document.form1.guarantee_annual_date.value;
var guaranteeAnnualDateField = document.form1.guarantee_annual_date;
var guaranteeAnnualDateName = 'Annual Fee Date';

var eftGuaranteeCycle = document.form1.eft_guarantee_cycle.value;
var eftGuaranteeCycleField = document.form1.eft_guarantee_cycle;
var eftGuaranteeCycleName = 'Monthy Members Guarantee Menu';

var boon;



//--------------------------------------------------------------------------------------
//first check the billing day
if(billingDay == "") {
   alert('Please enter a value into the \"Billing Day\" field');
   billingDayField.focus();
   return false;   
  }
  

if(billingDay != "") {
   boon = checkNan(billingDay, billingDayField, billingDayName); 
     if(boon == false) {
        return false;
        }   
 }
if(billingDay > 28 ||  billingDay == 0) {
 alert('The \"Billing Day\" you entered is not valid.  Please enter a number between 1 and 28');
 billingDayField.focus();
 return false;   
}


//---------------------------------------------------------------------------------------
//now we check the pif enhance date
if(pifEnhanceDate == "") {
   alert('Please enter a date into the \"' +pifEnhanceDateName+ '\" field');
   pifEnhanceDateField.focus();
   return false;   
  }
if(pifEnhanceDate != "") {
  boon = checkDateFormat(pifEnhanceDate, pifEnhanceDateField, pifEnhanceDateName);
     if(boon == false) {
        return false;
       }
  }
//-------------------------------------------------------------------------------------
//check the guarantee date
if(eftGuaranteeCycle == "A") {

    if(guaranteeAnnualDate == "") {
       alert('Please enter a date into the \"' +guaranteeAnnualDateName+ '\" field');
       guaranteeAnnualDateField.focus();
       return false;   
       }
    if(guaranteeAnnualDate != "") {
       boon = checkDateFormat(guaranteeAnnualDate, guaranteeAnnualDateField, guaranteeAnnualDateName);
          if(boon == false) {
             return false;
            }              
      }
  }
//-------------------------------------------------------------------------------------
//check the guarantee drop menu
if(eftGuaranteeCycle == "") {
  alert('Please select a value from the \"' +eftGuaranteeCycleName+ '\"');
     eftGuaranteeCycleField.focus();
     return false;
  }
//-------------------------------------------------------------------------------------
//check the enhance drop menu
if(eftEnhanceCycle == "") {
  alert('Please select a value from the \"' +eftEnhanceCycleName+ '\"');
     eftEnhanceCycleField.focus();
     return false;
  }
//------------------------------------------------------------------------------------

}


