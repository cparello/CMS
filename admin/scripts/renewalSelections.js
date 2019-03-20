function setBalanceDueDate(days) {

//get ajax request object
function GetXmlHttpObjectTwo() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//-------------------------------------------------------
xmlHttp=GetXmlHttpObjectTwo();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }


//send off the request
var url="dueDate.php";
url=url+"?term_days="+days;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChangedTwo; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChangedTwo() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                     
                     var dueDate =  xmlHttp.responseText;
                     var totalDue = document.form1.grand_total.value;
                               if(totalDue == "0.00")  {
                               dueDate = "";
                                }
                     
                              document.form1.due_date.value = dueDate;
                                        
//end of complete
} 

//end state change function
}


return false;    


}

//-----------------------------------------------------------------------------------------------------------------
function setTodaysPayment(todaysPayment)  {

var totalDue;
var balanceDue;
var balanceDueForm;

totalDue = document.form1.grand_total.value;
totalDue = parseFloat(totalDue);

todaysPayment = parseFloat(todaysPayment);


if(isNaN(todaysPayment)) {
  todaysPayment = 0;
  }
if(isNaN(totalDue)) {
  totalDue = 0;
  }
  
balanceDue = totalDue - todaysPayment;
balanceDueForm = balanceDue;
balanceDueForm = balanceDueForm.toFixed(2);

if(totalDue == 0) {
balanceDue = 0;
todaysPayment = 0;
balanceDueForm = "";

//set the balance due date
document.form1.due_date.value = "";
document.getElementById('rem_day').selectedIndex = 0;
document.form1.today_payment.value = "";
}


balanceDue = balanceDue.toFixed(2); 
//
todaysPayment = todaysPayment.toFixed(2);

document.form1.balance_due.value = balanceDueForm;



}

//----------------------------------------------------------------------------------------------------------------------------------------------------
function checkRenRate()  {


//switch out the string to get the standard field id
var standardId = renGroup.replace("early", "standard");
var standardValue = document.getElementById(standardId).value;
var earlyValue = document.getElementById(renGroup).value;
var renPercent = document.form1.early_percent.value;
var priceFieldPercentValue;
var minimumRenRate;

//used for the pop up
var alertPercent = renPercent.replace("\.", "");
var alertPercent = alertPercent.replace(/^[0]/,"");

standardValue = parseFloat(standardValue);
earlyValue = parseFloat(earlyValue);
renPercent = parseFloat(renPercent);


//calculate what  ever the percent value is for the price
priceFieldPercentValue = renPercent * standardValue;

//subtract the percent value above from the price field value
minimumRenRate = standardValue - priceFieldPercentValue;

if(isNaN(earlyValue)) {
     earlyValue = 0;
   }
         
           if(earlyValue < minimumRenRate) {
                      
             alert('Resetting Early Renewal field.  The early renewal rate you entered is below the minimum renewal rate allowed for this service. The current early renewal rate is ' +alertPercent+'% below the current renewal rate.');
                     
                     subtractRenewalFees(earlyValue);
                     addRenewalFees(standardValue);
                     
                     standardValue = standardValue.toFixed(2);
                     document.getElementById(renGroup).value = standardValue;
                     return false;
     
           }
 
//alert(standardValue+'  '+earlyValue+'  '+renPercent);

}
//-----------------------------------------------------------------------------------------------
function addRenewalFees(renValue)  {

if(document.getElementById(checkBox).checked == true)  {

var renewalFee = document.form1.renewal_fee.value;
var grandTotal = document.form1.grand_total.value;
var serviceTotal = document.form1.service_total.value;
      serviceTotal = parseFloat(serviceTotal);
      grandTotal = parseFloat(grandTotal);
      renewalFee = parseFloat(renewalFee);

       //make the early renewal the same as standard if over ride
       if(earlyVal != "NA")  {             
             document.getElementById(earlyVal).value = renValue;       
            }
             
       
            if(renewalFee == "0.00")  {
               var renewalFeeOrig = document.form1.ren_fee_hidden.value;
                    renewalFeeOrig = parseFloat(renewalFeeOrig);
               var renewalFeeOrig2 = renewalFeeOrig.toFixed(2);
                   document.form1.renewal_fee.value = renewalFeeOrig2;
                   grandTotal = renewalFeeOrig;
                 }  

           var newServiceTotal = serviceTotal + renValue;
           var newGrandTotal = grandTotal + renValue;


              newGrandTotal = newGrandTotal.toFixed(2);
              newServiceTotal = newServiceTotal.toFixed(2); 
              document.form1.service_total.value = newServiceTotal;
              document.form1.grand_total.value = newGrandTotal;
                     //this access the balance due and todays payment
                      var todaysPayment = document.form1.today_payment.value;                   
                            setTodaysPayment(todaysPayment);
              
              if(renValue == 0) {
                document.getElementById(renGroup).value = "";
                      if(earlyVal != "NA")  { 
                      document.getElementById(earlyVal).value = "";
                      }
                }
              
              
}


}
//--------------------------------------------------------------------------
function subtractRenewalFees(currentValue) {

if(document.getElementById(checkBox).checked == true)  {

var renewalFee = document.form1.renewal_fee.value;
var grandTotal = document.form1.grand_total.value;
var serviceTotal = document.form1.service_total.value;
      serviceTotal = parseFloat(serviceTotal);
      grandTotal = parseFloat(grandTotal);
      renewalFee = parseFloat(renewalFee);
    
           var newServiceTotal = serviceTotal - currentValue;
           var newGrandTotal = grandTotal - currentValue;
                   
           
            //check to see if everything is reset to 0  if no services are selected      
             if(newServiceTotal == "0.00")  {
               newGrandTotal = 0;
               document.form1.renewal_fee.value = "0.00";
              }
              
              newGrandTotal = newGrandTotal.toFixed(2);
              newServiceTotal = newServiceTotal.toFixed(2); 
              document.form1.service_total.value = newServiceTotal;
              document.form1.grand_total.value = newGrandTotal;
                                                                            
                      //this access the balance due and todays payment
                      var todaysPayment = document.form1.today_payment.value;                   
                      setTodaysPayment(todaysPayment);
              
  
   }else{
   alert('Please use the check box on the right to select this service before modifing this renewal rate');
    currentValue = currentValue.toFixed(2); 
    document.getElementById(renGroup).value = currentValue;
    return false;
   }

}
//------------------------------------------------------------------------------------------
function subtractServiceTotals() {

var renewalFee = document.form1.renewal_fee.value;
var grandTotal = document.form1.grand_total.value;
var serviceTotal = document.form1.service_total.value;
      serviceTotal = parseFloat(serviceTotal);
      standVal = parseFloat(standVal);
      grandTotal = parseFloat(grandTotal);
      renewalFee = parseFloat(renewalFee);

        if(earlyVal == 'NA') {
           var newServiceTotal = serviceTotal - standVal;
           var newGrandTotal = grandTotal - standVal;
          }else{
           var earlyFieldVal = document.getElementById(earlyVal).value;
                 earlyFieldVal = parseFloat(earlyFieldVal);
           var newServiceTotal = serviceTotal - earlyFieldVal;
           var newGrandTotal = grandTotal - earlyFieldVal;
         }


//check to see if everything is reset to 0  if no services are selected      
if(newServiceTotal == "0.00")  {
 newGrandTotal = 0;
 document.form1.renewal_fee.value = "0.00";
}


newGrandTotal = newGrandTotal.toFixed(2);
newServiceTotal = newServiceTotal.toFixed(2); 
document.form1.service_total.value = newServiceTotal;
document.form1.grand_total.value = newGrandTotal;

                        //this access the balance due and todays payment
                      var todaysPayment = document.form1.today_payment.value;                   
                      setTodaysPayment(todaysPayment);


}
//-----------------------------------------------------------------------------------------------
function addServiceTotals()  {

var renewalFee = document.form1.renewal_fee.value;
var grandTotal = document.form1.grand_total.value;
var serviceTotal = document.form1.service_total.value;
      renewalFee = parseFloat(renewalFee);
      serviceTotal = parseFloat(serviceTotal);
      standVal = parseFloat(standVal);
      grandTotal = parseFloat(grandTotal);
      
    //if the fields are reset to zero set up the renew fee for one time use
     if(renewalFee == "0.00")  {
        var renewalFeeOrig = document.form1.ren_fee_hidden.value;
              renewalFeeOrig = parseFloat(renewalFeeOrig);
        var renewalFeeOrig2 = renewalFeeOrig.toFixed(2);
              document.form1.renewal_fee.value = renewalFeeOrig2;
              grandTotal = renewalFeeOrig;
         }  

         if(earlyVal == 'NA') {
            var newServiceTotal = serviceTotal + standVal;
            var newGrandTotal = grandTotal + standVal;
           }else{
            var earlyFieldVal = document.getElementById(earlyVal).value;
                  earlyFieldVal = parseFloat(earlyFieldVal);
            var newServiceTotal = serviceTotal + earlyFieldVal;
            var newGrandTotal = grandTotal + earlyFieldVal;
          }
          

          
newGrandTotal = newGrandTotal.toFixed(2);
newServiceTotal = newServiceTotal.toFixed(2); 
document.form1.service_total.value = newServiceTotal;
document.form1.grand_total.value = newGrandTotal;

                        //this access the balance due and todays payment
                      var todaysPayment = document.form1.today_payment.value;                   
                      setTodaysPayment(todaysPayment);
}
//---------------------------------------------------------------------------------------------
function primarySelectColor(early)   {
this.earlyVal = early;

var x=document.getElementById('a1');
x.style.backgroundColor = "gold";

}
//-----------------------------------------------------------------------------------------
function selectService(obj, r1, col, standard, early, renewRate) {

//this toggles the color of the row
var x=document.getElementById(r1);
x.style.backgroundColor = (obj.checked) ? "gold" : col;

this.earlyVal = early;
this.standVal = document.getElementById(standard).value;
this.renewalFee = document.form1.ren_fee_hidden.value;

//this is for setting the vars back to their orig if null
var resetSwitch = 0;

if(obj.checked == true)  {   
   addServiceTotals();
   
  }else{
  
  //sets the variables to 0 so if there is no value it will not come up as NAN in the total fields
   if(standVal == "") {
   document.getElementById(standard).value = 0;
   standVal = 0;
   resetSwitch = 1;
   
             if(earlyVal != "NA") {  
                document.getElementById(earlyVal).value = 0;
                resetSwitch = 2;
               }               
    }
 
 subtractServiceTotals();
 
//check the reset switch to return to original vals 
switch(resetSwitch)  {
case 1:
document.getElementById(standard).value = renewRate;
 alert('Renewal Rate cannot be blank.  Resetting to original value');
break;
case 2:
document.getElementById(earlyVal).value = renewRate;
document.getElementById(standard).value = renewRate;
alert('Values cannot be blank.  Resetting to original values');
break;
} 


  }//end else

}

//-------------------------------------------------------------------------------------------------------
function rateChange(renValue, fieldId, checkBoxId, early)   {

var fieldFocus;
this.renGroup = fieldId;
this.checkBox = checkBoxId;

//find out if it is an early renewal from the field id
 var earlyPattern = /early/g;
 this.earlyPatternResult = earlyPattern.test(renGroup);


//change to a number value
renValue = parseFloat(renValue);
document.form1.current_ren_rate.value = renValue;

if(isNaN(renValue)) {
     renValue = 0.00;
}

fieldFocus = document.getElementById(fieldId);

//check to see if this is comming form a standard renewal override then reset the ealy field
 var standardPattern = /standard/g;
 this.standardPatternResult = standardPattern.test(renGroup);
 if(standardPatternResult == true) { 
      if(early != "NA") {      
       var currentEarlyValue = document.getElementById(early).value;
               if(currentEarlyValue != renValue) {
                  document.getElementById(early).value = renValue;
                   subtractRenewalFees(currentEarlyValue);
                   addRenewalFees(renValue);
                  }
       }  
 }
 
 
 
 

try 
{

 fieldFocus.addEventListener ('keyup', function () {modifyRen(this.value, this.name)}, false);
 
     if(earlyPatternResult == true) {
        fieldFocus.addEventListener ('change', function () {checkRenRate()}, false);
       }
 
}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function() {modifyRen(this.value, this.name)});

     if(earlyPatternResult == true) {

       fieldFocus.attachEvent("onblur",function() {checkRenRate()});
     
       }
}
           

}

//---------------------------------------------------------------------------------------------------------------------------
function modifyRen(fieldValue, fieldName)  {

fieldValue = document.getElementById(renGroup).value;

if(fieldValue == "") {
  fieldValue = 0;
  }

//fieldValue = parseFloat(fieldValue);

if (isNaN(fieldValue)) {
     alert('Input Value must be a Number');
     return false;
   }




fieldValue = parseFloat(fieldValue);
//alert(fieldValue);
var currentValue = document.form1.current_ren_rate.value;
currentValue = parseFloat(currentValue);



subtractRenewalFees(currentValue);

addRenewalFees(fieldValue);
              
document.form1.current_ren_rate.value = fieldValue;
}






























