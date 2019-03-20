//global variables
var  servicePatternResult;
var  monthServiceFee;
var  pifServiceFee;
var  currentProcFee;
var  groupTypePayments;
var summaryRowId;
var monthlyTotal;
var subtractAmount;
var serviceCost;
//---------------------------------------------------------------------------------------------------------------------------------------------
function setGrandTotalMemberFee() {
var groupType = document.form1.group_type.value;
var newMembers = memSwitch;
var memberFeesArray;

switch(groupType)  {
case 'S':
memberFeesArray = document.form1.single_fees.value;
break;
case 'F':
memberFeesArray = document.form1.family_fees.value;
break;
case 'B':
memberFeesArray = document.form1.business_fees.value;
break;
case 'O':
memberFeesArray = document.form1.organization_fees.value;
break;  
}

memberFeesArray = memberFeesArray.split("|");
addMemberFee = memberFeesArray[2];

 if(isNaN(newMembers)) {
     newMembers = 0;
    }
    
  if(newMembers == 0) {  
      document.form1.member_fee_hidden.value = "";
      }else{
        addMemberFee =parseInt(addMemberFee);
        newMembers = parseInt(newMembers);
        addMemberFee = newMembers * addMemberFee;
        addMemberFee = addMemberFee.toFixed(2);
        document.form1.member_fee_hidden.value = addMemberFee;
      }

}
//-----------------------------------------------------------------------------------------------------------------------------------------------
function setAddMemberFee() {  

var groupType = document.form1.group_type.value;
var newMembers = memSwitch;
var memberFeesArray;
var addMemberFee;
var newMonthlyPayment = document.getElementById('current_month_payment').innerHTML;
var newMonthlyServicePayment = document.form1.monthly_payment.value;
var currentMonthProRate = document.getElementById('month_prorate_total').innerHTML;


switch(groupType)  {
case 'S':
memberFeesArray = document.form1.single_fees.value;
break;
case 'F':
memberFeesArray = document.form1.family_fees.value;
break;
case 'B':
memberFeesArray = document.form1.business_fees.value;
break;
case 'O':
memberFeesArray = document.form1.organization_fees.value;
break;  
}

memberFeesArray = memberFeesArray.split("|");
addMemberFee = memberFeesArray[2];

 if(isNaN(newMembers)) {
     newMembers = 0;
    }

if(newMembers == 0) {
       document.form1.member_fee.value = "";
       document.getElementById('new_member_fee').innerHTML = "0.00";       
             
                   if(newMonthlyServicePayment == "") {
                      document.form1.new_monthly_payment.value = "";
                      document.form1.total_fees_monthly.value = "";
                       }
         
  }else{
  
  addMemberFee =parseInt(addMemberFee);
  newMembers = parseInt(newMembers);
  addMemberFee = newMembers * addMemberFee;
  addMemberFee = addMemberFee.toFixed(2);
  
  document.form1.member_fee.value = addMemberFee;  
  document.getElementById('new_member_fee').innerHTML = addMemberFee;
  
                 if(newMonthlyPayment == "0.00") {
                    document.form1.new_monthly_payment.value = "";
                    }else{
                    document.form1.new_monthly_payment.value = newMonthlyPayment;
                    document.form1.total_fees_monthly.value = currentMonthProRate;
                    }
    
  
  }


}
//----------------------------------------------------------------------------------------------------------------------------------------------
function  setProrateTotals(memNum)  {

var dateNow = document.form1.todays_date.value;
      dateNow = parseInt(dateNow);
      dateNow = dateNow * 1000;

var dayRateArray = document.form1.daily_rate_array.value;
      dayRateArray = dayRateArray.split("|");
      
var remainMonthDays = document.form1.remain_month_days.value      
      remainMonthDays = parseInt(remainMonthDays);
         
var  milDays =  remainMonthDays * 86400000;
var  monthStartDate = milDays + (dateNow + 86400000);        
     

var length = document.form1.field_count.value;
      length = parseInt(length);
      
var serviceValueArray = "";  
var dailyRate = "";
var endDate = "";
var dateDifference = ""; 
var oneDay = 1000 * 60 * 60 * 24;
var numberOfDays = "";
var proRateCurrent = "";
var proRateSingleRate = "";
var adjustmentRate = "";
var adjustmentRate2 = "";
var proField = 'pro[]';
var serviceSalt = "";
var proRateTotal = 0;
var monthProRate = 0; 
var monthProRateTotal = 0; 
var renewRate;
var singleRenewRate;
var newMembersRenewRate;
var totalRenewRate = 0;
var dailyRateOrig = "";

if(length > 1) {  

                       for(i = 0; i < length; i++) {
                       
                             serviceValueArray = dayRateArray[i];
                             serviceValueArray = serviceValueArray.split(" ");
                             dailyRate = serviceValueArray[0];
                             
                             //set the original date so we can calc from today until the end of term for the service prorate field
                             dailyRateOrig = dailyRate;
                             dailyRateOrig = parseFloat(dailyRateOrig);
                             
                             //sets up the dail rate rate based on the group number
                             dailyRate = dailyRate / groupNumber;
                             
                             dailyRate = parseFloat(dailyRate);
                             endDate = serviceValueArray[1];
                             serviceSalt = serviceValueArray[2];
                             
                             renewRate = serviceValueArray[3];
                             renewRate = parseFloat(renewRate);
                             singleRenewRate = renewRate / groupNumber;
                             newMembersRenewRate = singleRenewRate * memNum;
                             totalRenewRate += (newMembersRenewRate + renewRate);

                             
                            if(serviceSalt == 0) {
                             dateDifference = endDate - dateNow;
                             numberOfDays = dateDifference / oneDay;
                              }
                              
                             if(serviceSalt == 1)  {
                             dateDifference = endDate - monthStartDate;
                             numberOfDays = dateDifference / oneDay;
                              }
                              
                             
                             
                             //sets up the service fields in the current services for pro rate
                             proRateCurrent = numberOfDays * dailyRateOrig;
                             proRateSingleRate = proRateCurrent / groupNumber;                       
                             adjustmentRate =parseFloat(adjustmentRate);
                             adjustmentRate = proRateSingleRate * memNum;
                             adjustmentRate2 = adjustmentRate;
                             adjustmentRate = adjustmentRate.toFixed(2);
                             
                             if(endDate == 'NA')  {
                               proRateSingleRate = dailyRateOrig / groupNumber;
                               adjustmentRate = proRateSingleRate * memNum; 
                               adjustmentRate2 = adjustmentRate;
                               adjustmentRate = adjustmentRate.toFixed(2);
                               }
                                     if (isNaN(adjustmentRate)) {
                                        adjustmentRate = "";
                                        }
                                                      
                           document.form1.elements[proField][i].value = adjustmentRate;
                         
                                               //this adds up the services based on members
                                               if(serviceSalt == 0) {                                                   
                                                   proRateTotal  += adjustmentRate2;                                                   
                                                  }
                                                  
                                              //this is to get the prorate for monthly added members that will be due now   
                                               if(serviceSalt == 1)  {   
                                                  monthProRate = dailyRate * remainMonthDays;
                                                  monthProRate = monthProRate * memNum;
                                                  monthProRateTotal += monthProRate;                                                  
                                                  }
                            
                            }
    
}else{

                             serviceValueArray = dayRateArray[0];
                             serviceValueArray = serviceValueArray.split(" ");
                             dailyRate = serviceValueArray[0];
                             
                             //set the original date so we can calc from today until the end of term for the service prorate field
                             dailyRateOrig = dailyRate;
                             dailyRateOrig = parseFloat(dailyRateOrig);
                             
                             //sets up the dail rate rate based on the group number
                             dailyRate = dailyRate / groupNumber;
                             
                             dailyRate = parseFloat(dailyRate);
                             endDate = serviceValueArray[1];
                             serviceSalt = serviceValueArray[2];
                             
                             renewRate = serviceValueArray[3];
                             renewRate = parseFloat(renewRate);
                             singleRenewRate = renewRate / groupNumber;
                             newMembersRenewRate = singleRenewRate * memNum;
                             totalRenewRate = (newMembersRenewRate + renewRate);
                             
                             if(serviceSalt == 0) {
                             dateDifference = endDate - dateNow;
                             numberOfDays = dateDifference / oneDay;
                              }                              
                             if(serviceSalt == 1)  {
                             dateDifference = endDate - monthStartDate;
                             numberOfDays = dateDifference / oneDay;                             
                              }
                          
                             //sets up the service fields in the current services for pro rate
                             proRateCurrent = numberOfDays * dailyRateOrig;                            
                             proRateSingleRate = proRateCurrent / groupNumber;                            
                             adjustmentRate = proRateSingleRate * memNum;
                             adjustmentRate =parseFloat(adjustmentRate);
                             adjustmentRate2 = adjustmentRate;
                             adjustmentRate = adjustmentRate.toFixed(2);
                             
                             if(endDate == 'NA')  {
                               proRateSingleRate = dailyRateOrig / groupNumber;
                               adjustmentRate = proRateSingleRate * memNum; 
                               adjustmentRate2 = adjustmentRate;
                               adjustmentRate = adjustmentRate.toFixed(2);
                               }
                                     if (isNaN(adjustmentRate)) {
                                        adjustmentRate = "";
                                        }
                             
                             
                            
                             document.form1.elements[proField].value = adjustmentRate;
                                               //this adds up the services based on members
                                               if(serviceSalt == 0) {
                                                   proRateTotal = adjustmentRate2;                                              
                                                  }
                                              //this is to get the prorate for monthly added members that will be due now   
                                               if(serviceSalt == 1)  {   
                                                  monthProRate = dailyRate * remainMonthDays;
                                                  monthProRate = monthProRate * memNum;
                                                  monthProRateTotal = monthProRate;                                                  
                                                  }   
  
}
alert(dailyRate);
if(serviceSalt == 0) {
   var monthAmount = 30 * dailyRate;                                            
                                                  }
                                              //this is to get the prorate for monthly added members that will be due now   
if(serviceSalt == 1)  {   
   var monthAmount = 30 * dailyRate;                                                  
}   

//add the prorate totals together
 if(isNaN(proRateTotal)) {
     proRateTotal = 0;
    }
 if(proRateTotal == "") {
     proRateTotal = 0;
     }
    
    //set the month prorate total in list
  if(isNaN(monthProRateTotal)) {
     monthProRateTotal = 0;
    }  
    
   //if there is a nul val we cant use tofixed since it takes a floating point number
  totalRenewRate = totalRenewRate.toFixed(2);
  if(isNaN(totalRenewRate)) {
     totalRenewRate = document.form1.total_renew_rate.value;
    }        
  if(totalRenewRate == "") {
     totalRenewRate = document.form1.total_renew_rate.value;
     }
    
  //alert(totalRenewRate);
    monthProRateTotal = monthProRateTotal.toFixed(2);
    
    document.getElementById('month_prorate_total').innerHTML = monthProRateTotal;
    if(monthProRateTotal  == 0)  {
       document.form1.month_prorate_total2.value = "";
       }else{
       document.form1.month_prorate_total2.value = monthProRateTotal;      
       }
       
       document.getElementById('current_renew_total').innerHTML = totalRenewRate;
    
    

             //now add the prorate total to the grand total in PIF 
                  var pifGrandTotal = 0;
                  var pifSubTotal = document.form1.grand_total_pif.value;
                     if(pifSubTotal == "") {
                        pifSubTotal = 0;
                        pifSubTotal = parseFloat(pifSubTotal);
                       }else{
                        pifSubTotal = parseFloat(pifSubTotal);
                       }
                        
                        // if(proRateTotal != 0) {
                           pifGrandTotal = proRateTotal + pifSubTotal;
                       //    }                        
                         if(pifGrandTotal == 0) {
                            pifGrandTotal = "";
                           }
                         if(isNaN(pifGrandTotal)) {
                            pifGrandTotal = "";
                            }  
                          
                       if(pifGrandTotal != "") {    
                          pifGrandTotal = pifGrandTotal.toFixed(2);
                          
                        }
                       proRateTotal = proRateTotal.toFixed(2);
                       document.form1.grand_total_pif2.value =  pifGrandTotal;  
                       document.getElementById('pro_total').innerHTML = proRateTotal;
                       
                       //clears the prorate field if zero
                       if(proRateTotal != 0) {
                         document.form1.prorate_pif_total.value = proRateTotal;
                         }else{
                         document.form1.prorate_pif_total.value = "";
                         }
     
    setGrandTotal(monthAmount); 
     
}
//-----------------------------------------------------------------------------------------------------------------------------------------------
function parseInitFee(initValue, fieldName) {

checkNan(initValue,fieldName);
monthlyTotal = document.form1.month_service.value;
initValue = parseFloat(initValue);
var initBase = initValue;

if (isNaN(initValue)) {
     initValue = '0.00';
   }

if(monthlyTotal != "0.00")  {
        if(groupTypePayments != "S")  {
           var  memberNumber = document.form1.mem_num.value;
                     //  alert(memberNumber);
                      if(memberNumber != "") {
                        memberNumber = parseInt(memberNumber);
                        initValue = initValue * memberNumber;      
                        }
           }
      
initValue = initValue.toFixed(2);

document.getElementById('serve_init').innerHTML = initValue;
document.form1.init_base.value = initBase;
//add to minimum total due
setGrandTotal();


}
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function setOpenEnd()  {
var i= "";
var openCheck = document.form1.open_end;

if(openCheck.checked == true) {

//check to see if there is a service selected if not return false
var monthTotal = document.getElementById('serve_month').innerHTML;
      monthTotal = parseFloat(monthTotal);
      
      if(monthTotal == "0.00") {
        openCheck.checked = false;
        alert('Please select a Monthly service');
        return false;
        }

//free up the initiation fee field
document.form1.init_fee.disabled = false;


//first disable the down payment field then check if there was a value and set it to none
//document.form1.down_pay.value = "";
//var downName = document.form1.down_pay.name;
// var downPayment = 0;
//parseDownPay(downPayment,downName);
//document.form1.down_pay.disabled = true;



}else{

//document.form1.down_pay.disabled = false;
document.form1.init_fee.value = "";
document.getElementById('serve_init').innerHTML = "0.00";
document.form1.init_fee.disabled = true;
setGrandTotal();
}


}
//------------------------------------------------------------------------------------------------------------------------------------------------
function setPaymentRadioButtons(monthTotal)   {

var creditSelected = "";
var bankSelected = "";
var checkSelected = "";
var cashSelected = "";

//get the saved monthly payment type
var monthlyBillingType = document.form1.month_billing_type.value;
switch(monthlyBillingType)  {
case 'CR':
creditSelected = 'checked="yes"';
break;
case 'BA':
bankSelected = 'checked="yes"';
break;
case 'CH':
checkSelected = 'checked="yes"';
break;
case 'CA':
cashSelected = 'checked="yes"';
break;  
}



//get the file permissions for the radios
var monthBit = document.form1.month_bit.value;
var monthBitArray = monthBit.split("");
var creditDisabled;
var bankDisabled;
var cashDisabled;
var checkDisabled;

if(monthBitArray[0] == 1) {
    cashDisabled = "";
    }else{
    cashDisabled ='disabled="disabled"';
    }
    
if(monthBitArray[1] == 1) {
    checkDisabled = "";
    }else{
    checkDisabled ='disabled="disabled"';
    }

if(monthBitArray[2] == 1) {
    bankDisabled = "";
    }else{
    bankDisabled ='disabled="disabled"';
    }    
    
if(monthBitArray[3] == 1) {
    creditDisabled = "";
    }else{
    creditDisabled ='disabled="disabled"';
    }    


var buttonTitle= 'Set Monthly Billing:';
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id)"' +creditSelected+'  '+creditDisabled+'/><input class="button1" value="Pre-Auth Card"  name="pre_auth" id="pre_auth" type="button">&nbsp;<input name="preAuthStatus" id="preAuthStatus" size="20" maxlength="20" value="unverified" type="text" disabled="disabled"><input type="hidden" name="preAuthBool"  id="preAuthBool" value="0"/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"' +bankSelected+'  '+bankDisabled+'/>';
var cashRadio =  '<input type="radio"  id="monthly_billing3" name="monthly_billing"   value="CA" onClick="return checkServices(this.name,this.id)"' +cashSelected+'  '+cashDisabled+'/>';
var checkRadio =  '<input type="radio" id="monthly_billing4"  name="monthly_billing"  value="CH" onClick="return checkServices(this.name,this.id)"'
+checkSelected+'  '+checkDisabled+'/>';

if(monthTotal == "0.00"  && monthlyBillingType == "")  {
document.getElementById('setMonth1').innerHTML = "";
document.getElementById('setMonth2').innerHTML = "";
document.getElementById('setMonth3').innerHTML = "";
document.getElementById('setMonth4').innerHTML = "";
document.getElementById('setMonthCredit').innerHTML = "";
document.getElementById('setMonthBank').innerHTML = "";
document.getElementById('setMonthCash').innerHTML = "";
document.getElementById('setMonthCheck').innerHTML = "";
}else{
document.getElementById('setMonth1').innerHTML = buttonTitle;
document.getElementById('setMonth2').innerHTML = buttonTitle;
document.getElementById('setMonth3').innerHTML = buttonTitle;
document.getElementById('setMonth4').innerHTML = buttonTitle;
document.getElementById('setMonthCredit').innerHTML = creditRadio;
document.getElementById('setMonthBank').innerHTML = bankRadio;
document.getElementById('setMonthCash').innerHTML = cashRadio;
document.getElementById('setMonthCheck').innerHTML = checkRadio;
}

}
//-------------------------------------------------------------------------------------------------------------------------------------------------
//sets the number in the field if a radio button is checked
function setField(fieldValue) {


var altField = renGroup.replace("_type", "");
//alert(altField);

var renRateField = document.getElementsByName(altField).item(1);

                          document.getElementsByName(altField).item(0).value = fieldValue;
          
          //this checks to make sure the field is not a class
          if(renRateField.value != 'NA') {          
                 renRateField.value = fieldValue;
             }   
        
}

//----------------------------------------------------------------------------------------------------------------------------------------
function checkRenRate() {

var i = 0;
var j = 1;

var renewalField = document.form1.elements[renGroup][j];
var serviceValue = document.form1.elements[renGroup][i].value;
var renewalValue = document.form1.elements[renGroup][j].value;
var renPercent = document.form1.ren_percent.value;
var priceFieldPercentValue;
var minimumRenRate;
var serviceValue2;

//used for the pop up
var alertPercent = renPercent.replace("\.", "");
alertPercent = alertPercent.replace(/^[0]/,"");

//change these to parse float values
serviceValue = parseFloat(serviceValue);
renewalValue = parseFloat(renewalValue);
renPercent = parseFloat(renPercent);

//multiply by the number of members
//renewalValue = parseMemNumber(renewalValue);
//serviceValue = parseMemNumber(serviceValue);

//calculate what  ever the percent value is for the price
priceFieldPercentValue = renPercent * serviceValue;

//subtract the percent value above from the price field value
minimumRenRate = serviceValue - priceFieldPercentValue;

//alert(renewalValue+ '  '+minimumRenRate);
    //now we compare the new renwal rate with the minimum rate
    if(renewalValue != 0) {
        
               if(renewalValue < minimumRenRate) {
                
                       renewalValue = parseMemNumber(renewalValue);
                       subtractRenewalFees(renewalValue);
                       
                       serviceValue2 = parseMemNumber(serviceValue);
                       addRenewalFees(serviceValue2);
                      
                       serviceValue = serviceValue.toFixed(2);
                       document.form1.elements[renGroup][j].value = serviceValue;
                       
                     //reset the renewal rate
                      alert('The renewal rate is below the minimum renewal rate allowed for this service. The current minimum renewal rate is ' +alertPercent+'% below the current service price.');
                      renewalField.focus();
                     return false;
               }
      }
}
//-----------------------------------------------------------------------------------------------------------------------------------------
function multiplyAllFields(memValue)   {
// multiplies all of the fields based on number of members selected


this.groupNumber = document.form1.group_number.value;      
var groupType =  document.form1.group_type.value;
this.groupTypePayments = groupType;

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;

memValue = parseInt(memValue);


this.memSwitch = memValue;
//sets up the member fees for the grand total used in later functions
setGrandTotalMemberFee();

//sets the pro rate amont
setProrateTotals(memValue);


var length;

switch(groupType)  {
case 'S':
 length = singleLength;
break;
case 'F':
 length = familyLength;
break;
case 'B':
 length = businessLength;
break;
case 'O':
 length = organizationLength;
break;  
}

var valueFieldGroup = 'comp' + groupType;
var valueFieldId;
var valueFieldArray;
var serviceFieldValue;
var renewalFieldValue;
var adjustFieldValue;
var summaryId;

var i;
var j = 0;
var k =1;
var l = 2;

var renValue;
var renTotal = 0;
      renTotal = parseFloat(renTotal);
      length = parseInt(length);

                                for(i=1; i <= length; i++)  {
                                     valueFieldId = valueFieldGroup +i;                                     
                                     valueFieldArray = valueFieldId +'[]';                                   
                                     summaryId = i + groupType;
                                     serviceFieldValue = document.form1.elements[valueFieldArray][j].value;                                     
                                     renewalFieldValue = document.form1.elements[valueFieldArray][k].value;  
                                     adjustFieldValue = document.form1.elements[valueFieldArray][l].value;
                                              
                                            
                                              
                                         if(adjustFieldValue > 0 && adjustFieldValue != 'NA' && adjustFieldValue != "") {
                                            serviceFieldValue = adjustFieldValue;                                         
                                             }
                                              
                                                if(serviceFieldValue != "") {                                                
                                                     multiplySummaryFields(serviceFieldValue, summaryId, memValue, renewalFieldValue);                                                  
                                                  }    
                                                                                                                                       
                                             
                                                if(renewalFieldValue != "") {
                                                                                                
                                                              if(renewalFieldValue != "NA")  {
                                                                 renewalFieldValue = parseFloat(renewalFieldValue);
                                                                 renewalFieldValue = parseMemNumber(renewalFieldValue);                                                                   
                                                                 renTotal += renewalFieldValue;                                                               
                                                               //  document.getElementById('ren_total').innerHTML = renTotal;
                                                               }
                                                  }
                                     }
                                    
//alert(renTotal);
renTotal = renTotal.toFixed(2);
document.getElementById('ren_total').innerHTML = renTotal;



var initValue = document.form1.init_base.value;
        if(initValue == "") {
          initValue = 0;
        }
        if(isNaN(initValue)) {
         initValue = 0;
        }
        if(isNaN(memValue)) {
         memValue = 0;
        }



      initValue = parseFloat(initValue);      
     
var initTotal = initValue * memValue;
var initTotal2 = initTotal.toFixed(2);  
//alert(memValue);
      document.getElementById('serve_init').innerHTML = initTotal2;
      
     var thisServeTotal  = document.getElementById('serve_total_due').innerHTML;
           thisServeTotal = parseFloat(thisServeTotal);
           thisServeTotal = thisServeTotal + initTotal;
           thisServeTotal = thisServeTotal.toFixed(2);
           document.getElementById('serve_total_due').innerHTML = thisServeTotal;
  
//adjust the monthly payment if ther is a prorate  
 var divMonthlyPayment = document.getElementById('current_month_payment').innerHTML;
       divMonthlyPayment = parseFloat(divMonthlyPayment);
 var currentMonthlyPayment = document.form1.current_monthly_payments.value;
       currentMonthlyPayment = parseFloat(currentMonthlyPayment);
 var originalGroupNumber = document.form1.group_number.value;
       originalGroupNumber = parseInt(originalGroupNumber);
 var unitMonthlyPayment = currentMonthlyPayment / originalGroupNumber;
 var addedMonthlyPayment = unitMonthlyPayment * memValue;  
 var newMonthlyPayment = addedMonthlyPayment + currentMonthlyPayment;
       newMonthlyPayment = newMonthlyPayment.toFixed(2);
      document.getElementById('current_month_payment').innerHTML = newMonthlyPayment;
 
// alert(unitMonthlyPayment);
      
// var newMembers = memValue * unitMonthlyPayment;
//      setProRate(newMembers);     
      
//here we set the add member fee if a member is added      
setAddMemberFee();  


}
//-------------------------------------------------------------------------------------------------------------------------------------------
function   multiplySummaryFields(serviceFieldValue, summaryId, memValue, renewalFieldValue) {
//alert(serviceFieldValue);
var currentTable;
var tagHousing;
var currentProductType;
var currentServiceTerm;
var currentServiceCost
var groupPattern; 
var servicePattern;
//var serviceFieldValue;


 currentTable= document.getElementById(summaryId);
 tagHousing = currentTable.getElementsByTagName('td');
 currentProductType = tagHousing[0].innerHTML;
 currentServiceTerm = tagHousing[1].innerHTML;
 currentServiceCost = tagHousing[2].innerHTML;
                                                                                                                                                
 //this parses the group type for the monthly payment function
 groupPattern = /[A-Z]/;
 this.groupTypePayments = groupPattern.exec(summaryId);
 servicePattern = /Month/g;
 this.servicePatternResult = servicePattern.test(currentServiceTerm);

 currentServiceCost = parseFloat(currentServiceCost);
 serviceFieldValue = parseFloat(serviceFieldValue);

   if (isNaN(currentServiceCost)) {
       currentServiceCost = 0.00;
      }

   if (isNaN(serviceFieldValue)) {
       serviceFieldValue = 0.00;
      }
                                                   
                                                                                                 
   subtractServiceFees(currentServiceCost);

  serviceFieldValue = parseMemNumber(serviceFieldValue);
                                               
 if(memValue == "") {
   memValue = 1;
  }  
                                                
// serviceFieldValue = serviceFieldValue * memValue;                                                
 serviceFieldValue = serviceFieldValue.toFixed(2);
                                                
   currentTable.innerHTML =  ('<table width="100%" cellpadding="1" cellspacing="0" align="left"><tr><td class="green" width="50%">' + currentProductType +  '</td><td class="green"align="left">' + currentServiceTerm + '</td><td class="green" align="right">' + serviceFieldValue + '</td><tr></table>');
   

  addServiceFees(serviceFieldValue);
                                                

}
//------------------------------------------------------------------------------------------------------------------------------------------
function parseMemNumber(fieldValue)   {

//this calculates the price based on the number of members
var memNum = document.getElementById('mem_num').value;
      memNum = parseInt(memNum);
      
//if it is oly one member then we return the value as is
if(groupT == "S") {
   return fieldValue;   
  }  
//=========================================
//if it is not then we calculate the new value
if(groupT != "S")  {  

   var finalServiceCost; 
   
      if(memNum > 0)  {
               groupNumber = parseInt(groupNumber);                  
         var unitServiceCost = fieldValue / groupNumber;
         var newServiceCost = unitServiceCost * memNum;
         var finalServiceCost = fieldValue + newServiceCost;                                       
               setProrateTotals(memNum);
               
       }else{
         finalServiceCost = fieldValue;         
       }
//alert(finalServiceCost);
return finalServiceCost;
}

}
//------------------------------------------------------------------------------------------------------------------------------------------
function showMemNumber(groupType)  {

if(groupType == "S")  {
document.getElementById('memNum').style.visibility = 'hidden';
document.getElementById('mem_num').value = "";
}else{
document.getElementById('memNum').style.visibility = 'visible';
}

//shows the monthly payment options if there is an existing monthly service
var monthlyBillingType = document.form1.month_billing_type.value;
      if(monthlyBillingType != "") {
         var monthTotal = 0.00;
         setPaymentRadioButtons(monthTotal)
        }

}
//------------------------------------------------------------------------------------------------------------------------------------------
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
                     var totalDue = document.getElementById('serve_total_due').innerHTML;
                               if(totalDue == 0.00)  {
                               dueDate = "";
                                }
                     
                              document.form1.due_date.value = dueDate;
                                        
//end of complete
} 

//end state change function
}


return false;    


}

//------------------------------------------------------------------------------------------------------------------------------------------
function setTodaysPayment(todaysPayment)  {

//alert('fu'+todaysPayment);
var totalDue;
var balanceDue;
var balanceDueForm;

totalDue = document.getElementById('serve_total_due').innerHTML;
totalDue = parseFloat(totalDue);

todaysPayment = parseFloat(todaysPayment);
//document.getElementById('serve_total_due').innerHTML;

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
//setBalanceDueDate();

}


balanceDue = balanceDue.toFixed(2); 

todaysPayment = todaysPayment.toFixed(2);

document.form1.balance_due.value = balanceDueForm;
document.getElementById('serve_ballance_due').innerHTML = balanceDue;
document.getElementById('serve_today_payment').innerHTML = todaysPayment;


}
//--------------------------------------------------------------------------------------------------------------------------------------------
function setGrandTotal(monthAmount)   {

var prepaidServices;
var monthlyServices;
var processFees;
var proRateFee;
var initiationFee;
var totalDue;
var currentMonthlyProRateFee;
var currentPifProRateFee;
var addMemberFees;

//get the paid in full total 
prepaidServices = document.getElementById('serve_pif').innerHTML;
monthlyServices = document.getElementById('serve_month').innerHTML;
processFees = document.getElementById('process_fees').innerHTML;
//the prorate fee for monthly services
proRateFee = document.form1.pro_rate_fee.value;
//prorate for existing monthly services 
currentMonthlyProRateFee = document.form1.month_prorate_total2.value;
//prorate for existing PIF services
currentPifProRateFee = document.form1.prorate_pif_total.value;
//get the add member fee
addMemberFees = document.form1.member_fee_hidden.value;

initiationFee = document.getElementById('serve_init').innerHTML;

var fullFee = document.form1.full_fee.value;

//alert(prepaidServices);
if(prepaidServices == 0.00) {
  document.form1.process_fee_pif.value = "";
  }else{
  document.form1.process_fee_pif.value = fullFee;  
  }
                     


if(prepaidServices == "") {
   prepaidServices = 0;
   }
if(monthlyServices == "") {
   monthlyServices = 0;
   }
if(processFees == "") {
   processFees = 0;
   }
if(proRateFee == "") {
   proRateFee =0;
   }
if(initiationFee == "") {
   initiationFee =0;
   } 
if(currentMonthlyProRateFee == "") {
   currentMonthlyProRateFee =0;
   }
if(currentPifProRateFee == "") {
   currentPifProRateFee =0;
   }
if(addMemberFees =="") {
   addMemberFees =0;
   }

var billing_switch = document.form1.billing_switch.value;

prepaidServices = parseFloat(prepaidServices);
monthlyServices = parseFloat(monthlyServices);
processFees = parseFloat(processFees);
proRateFee = parseFloat(proRateFee);
initiationFee = parseFloat(initiationFee);
currentMonthlyProRateFee = parseFloat(currentMonthlyProRateFee);
currentPifProRateFee =parseFloat(currentPifProRateFee);
addMemberFees =parseFloat(addMemberFees);

//alert(prepaidServices);
//alert(monthlyServices);
//alert(monthAmount);
switch(billing_switch)  {
case '1':
 totalDue = prepaidServices + processFees + proRateFee + initiationFee + currentPifProRateFee + addMemberFees + currentMonthlyProRateFee ;
break;
case '2':
 totalDue = prepaidServices + processFees + proRateFee + initiationFee + currentPifProRateFee + addMemberFees + currentMonthlyProRateFee ;//month pay
break;
case '3':
 totalDue = prepaidServices + processFees + initiationFee + currentPifProRateFee + addMemberFees + monthAmount;//month pay
break;  
case '4':
 totalDue = prepaidServices + processFees + initiationFee + currentPifProRateFee + addMemberFees + monthAmount + monthAmount;//month pay*2
break; 
case '5':
 totalDue = prepaidServices + processFees + initiationFee + currentPifProRateFee + addMemberFees + currentMonthlyProRateFee ;
break; 
}   

//totalDue = prepaidServices + processFees + proRateFee + initiationFee + currentPifProRateFee + addMemberFees + currentMonthlyProRateFee ;
totalDue = totalDue.toFixed(2);



document.getElementById('serve_total_due').innerHTML = totalDue;

                        //this access the balance due and todays payment
                      var todaysPayment = document.form1.today_payment.value;                   
                      setTodaysPayment(todaysPayment, totalDue);



}
//------------------------------------------------------------------------------------------------------------------------------------------
function setTotalFeesMonthly(totalProrate)  {

var proRateFee;
var processFee;
var currentMonthProRate;
var totalFees;
var currentMonthlyPayment;

//get the prorate fee
proRateFee = document.form1.pro_rate_fee.value;
//get the processing fee
processFee = document.form1.process_fee_eft.value;
//get the current monthly prorate
currentMonthProRate = document.getElementById('month_prorate_total').innerHTML;
//get the current monthly fees if they exist
currentMonthlyPayment = document.getElementById('current_month_payment').innerHTML;
if(currentMonthlyPayment == '0.00') {
   currentMonthlyPayment = "";
  }


if(proRateFee == "") {
   proRateFee = 0;
   }

//create floating point numbers
proRateFee = parseFloat(proRateFee);
processFee = parseFloat(processFee);
currentMonthProRate = parseFloat(currentMonthProRate);
//alert(currentMonthProRate);

totalFees = proRateFee + processFee + currentMonthProRate;
totalFees = totalFees.toFixed(2);


//set up to delete the process fee if others are blank


if(document.form1.monthly_payment.value == "") {
   totalFees = "";
   document.getElementById('serve_init').innerHTML = "0.00";
   document.form1.init_fee.value = "";
   document.form1.pro_rate_fee.value="";
   document.form1.process_fee_eft.value="";
   
   if(document.form1.member_fee.value == "") {
       document.form1.new_monthly_payment.value="";
      // document.form1.month_prorate_total2 ="";      
      }else{
      document.form1.new_monthly_payment.value= currentMonthlyPayment;
   //   document.form1.total_fees_monthly = currentMonthProRate;
      }
   
   
   document.form1.open_end.checked = false;
   
   //set the transfer to uncheckable if a zero value
 //  document.form1.trans[0].checked = false;
//   document.form1.trans[1].checked = false;
//   document.form1.trans[0].disabled = true;
 //  document.form1.trans[1].disabled = true;
}else{
 //  document.form1.trans[0].disabled = false;
 //  document.form1.trans[1].disabled = false;
   
}

if(currentMonthProRate != 0  && document.form1.monthly_payment.value == "")  {
  document.form1.total_fees_monthly.value = currentMonthProRate;
  }else{
   document.form1.total_fees_monthly.value = totalFees;
   }



}
//------------------------------------------------------------------------------------------------------------------------------------------
function setProRate(monthlyPayment) {

//alert(monthlyPayment);

//get ajax request object
function GetXmlHttpObject() {
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
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="proRate.php";
url=url+"?monthly_amount="+monthlyPayment;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);

var billing_switch = document.form1.billing_switch.value;

//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                     
                     var proRatePayment =  xmlHttp.responseText;
                     var fieldAmount = proRatePayment;     //this sets up a separate format for the field variable
                           if(fieldAmount  == "0.00") {
                              fieldAmount = "0.00";
                            }
                            
                            if (billing_switch == 3 || billing_switch == 4){
                                //alert();
                                 //set the field amount
                               document.form1.pro_rate_fee.value = 0;
                               //set the summary amount
                               document.getElementById('serve_pro_rate').innerHTML = 0;
                            }else{
                                document.form1.pro_rate_fee.value = fieldAmount;
                               //set the summary amount
                               document.getElementById('serve_pro_rate').innerHTML = proRatePayment;
                            }
                           
                        if(monthPatternResult == true) {   
                           //set the new total monthly payment with existing services
                               var currentMonthlyPayment = document.getElementById('current_month_payment').innerHTML;
                                     currentMonthlyPayment = parseFloat(currentMonthlyPayment);
                               var selectedMonthlyPayment = document.form1.monthly_payment.value;
                                     selectedMonthlyPayment =  parseFloat(selectedMonthlyPayment);                                          
                               var newMonthlyPayment = currentMonthlyPayment + selectedMonthlyPayment;                              
                                     newMonthlyPayment = newMonthlyPayment.toFixed(2);
                                     
                                     if (isNaN(newMonthlyPayment)) {
                                         newMonthlyPayment ="";
                                         }
                              
                                      
                                     document.form1.new_monthly_payment.value = newMonthlyPayment;
                           }
                           
                                                 
                           //update the total fees in both sumarry and month to month 
                           setTotalFeesMonthly(newMonthlyPayment);
                                              
                           setGrandTotal(selectedMonthlyPayment);
//end of complete
} 

//end state change function
}


return false;    



}
//----------------------------------------------------------------------------------------------------------------------------------------
function resetButtonGroup(buttonGroup)  {


//alert(buttonGroup);
//get the summarry service cost     summaryRowId
var currentTable= document.getElementById(summaryRowId);

//get the current value for the price field
var priceFieldId; 
var priceField;
var serviceFieldId;

        priceFieldId = buttonGroup.replace("_type", "");
        serviceFieldId = buttonGroup.replace("_type", "");
        priceFieldId = priceFieldId.replace("[]", "");
        
if(currentTable.innerHTML != "")  {
tagHousing = currentTable.getElementsByTagName('td');
serviceCost = tagHousing[2].innerHTML;
}else{
serviceCost = 0;
}
                               
var rad
var val;
var j = 1;
var currentRenewalFee = document.form1.elements[serviceFieldId][j].value

rad = document.form1.elements[buttonGroup];
// take out the radio buttons
 if (rad[0]) {
           for (var i=0; i< rad.length; i++) {
                         
                    val = rad[i].value;
                    if(val == serviceCost)  {
                      rad[i].checked = true;   
                      document.getElementById(priceFieldId).value = serviceCost;
                      document.form1.elements[serviceFieldId][j].value  = currentRenewalFee;
                     }else if(serviceCost == 0) {
                     rad[i].checked = false;
                     document.getElementById(priceFieldId).value = "";
                     document.form1.elements[serviceFieldId][j].value = ""
                     }                                 
               }
      }

}
//------------------------------------------------------------------------------------------------------------------------------------------
/*function parseDownPay(feeAmount, fieldName)   {

var nanCheck = checkNan(feeAmount, fieldName);


//get the group type in order to send to the monthly payment function
this.groupTypePayments = document.form1.group_type.value;

monthlyTotal = document.form1.month_service.value;
feeAmount = parseFloat(feeAmount);
feeAmount = feeAmount.toFixed(2);

if (isNaN(feeAmount)) {
     feeAmount = '0.00';
   }

if(monthlyTotal != "0.00")  {
document.getElementById('serve_down').innerHTML = feeAmount;
}

monthyPayments();
}*/
//------------------------------------------------------------------------------------------------------------------------------------------
function monthyPayments()  {

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;

var length;

if(groupTypePayments == "B") {
length = businessLength;
}
if(groupTypePayments == "S") {
length = singleLength;
}
if(groupTypePayments == "F") {
length = familyLength;
}
if(groupTypePayments == "O") {
length = organizationLength;
}


var servicePattern = /Month/g;
var durationPattern = /\d+/;
var searchString;
var sumId;
var currentTable;
var tagHousing;
var monthlyProductType;
var monthlyTermResult;
var numberOfMonths; 
var durationTotal;
var monthlyPayment;
var i;


                for(i=1; i <= length; i++) {
                       sumId = i + groupTypePayments;
                       searchString = document.getElementById(sumId).innerHTML;
                       
                                 if(searchString != "")  {
                                        currentTable= document.getElementById(sumId);
                                        tagHousing = currentTable.getElementsByTagName('td');
                                        monthlyProductType = tagHousing[1].innerHTML;
                                        monthlyTermResult = servicePattern.test(monthlyProductType);
                                        
                                                     if(monthlyTermResult == true)  {
                                                          numberOfMonths = durationPattern.exec(monthlyProductType);
                                                          numberOfMonths = parseInt(numberOfMonths);                                                           
                                                       }                                   
                                      }
                      }//end for loop

//get the total monthly due
//document.getElementsByName(proMonthField).item(2).value = totalProrate; 


durationTotal = document.form1.month_service.value;
durationTotal = parseFloat(durationTotal);


//alert(durationTotal);

//set up for the prorate fee
var proFeeTotal = durationTotal;


//for down payment deduction we get the value to subtract
//subtractAmount = document.form1.down_pay.value;
//if(subtractAmount == "") {
//subtractAmount = "0.00";
//}
//subtractAmount = parseFloat(subtractAmount);
//durationTotal = durationTotal - subtractAmount;

//divide by the number of months and save to the monthly paymet field
monthlyPayment = durationTotal / numberOfMonths;
monthlyPayment = monthlyPayment.toFixed(2);

if (isNaN(monthlyPayment)) {
     monthlyPayment = "";
}

proFeeTotal = proFeeTotal / numberOfMonths;

document.form1.monthly_payment.value = monthlyPayment;

//sets the prorate amount for the rest of the days left in the current month
setProRate(proFeeTotal);

}
//-------------------------------------------------------------------------------------------------------------------------------------------
function checkEquals(serviceDuration, groupType, buttonGroup)   {


//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;

var length;

switch(groupType)  {
case 'S':
 length = singleLength;
break;
case 'F':
 length = familyLength;
break;
case 'B':
 length = businessLength
break;
case 'O':
 length = organizationLength;
break;  
}

 var j= 0;
 var servicePattern = /Month/g;
 var monthlyProductType;
 var currentTable;
 var tagHousing;
 var monthlyTermResult;
 var searchString;
 var sumId;
 var durationMonthsExisting;
 var durationPattern = /\d+/;
       serviceDuration = durationPattern.exec(serviceDuration);

                for(i=1; i <= length; i++) {
                       sumId = i + groupType;
                       searchString = document.getElementById(sumId).innerHTML;

                              if(searchString != "")  {
                                 currentTable= document.getElementById(sumId);
                                 tagHousing = currentTable.getElementsByTagName('td');
                                 monthlyProductType = tagHousing[1].innerHTML;
                                // serviceCost = tagHousing[2].innerHTML;
                                 monthlyTermResult = servicePattern.test(monthlyProductType);
                                 
                                 
                                                       if(monthlyTermResult == true)  {
                                                          durationMonthsExisting = durationPattern.exec(monthlyProductType);
                                                          durationMonthsExisting = parseInt(durationMonthsExisting);
                                                          serviceDuration = parseInt(serviceDuration);
                                                          
                                                                if(durationMonthsExisting != serviceDuration) {   
                                                                alert('Service terms for monthly services must have the same duration. You have already set a primary service term for this service. Use the \"Clear\" buttons in order to reset your service terms to make another selection');
                                                                
                                                                resetButtonGroup(buttonGroup);
                                                                
                                                                return false;                                                                
                                                                }else{
                                                                return true;
                                                                }
                                                    
                                                          }   //end second if
                                                                                                                 
                               }   //end first if
                               
                               
                     }//end for loop

}
//-------------------------------------------------------------------------------------------------------------------------------------------
function setPifGrandTotal()   {
                    
                         var pifFee  =  document.form1.full_fee.value;
                         var currentValue = document.form1.pre_paid_service.value;
                                                        
                         pifFee = parseFloat(pifFee);
                         currentValue = parseFloat(currentValue);
                         
                         var thisTotal = currentValue + pifFee;
                             
                                                  
                         if(currentValue == 0.00) {
                           thisTotal = 0;
                           }  
                     
                                                      
                         if(isNaN(thisTotal)) {
                           thisTotal = 0;
                         }
                          
                          //var thisTotal2 = thisTotal
                         // thisTotal = thisTotal.toFixed(2);                                                 
                        
                      //set up the combined total if available
                        var proRateTotal = document.getElementById('pro_total').innerHTML;
                        var grandTotal;
                                  proRateTotal = parseFloat(proRateTotal);
                                  grandTotal = proRateTotal + thisTotal;
                                
                                if(grandTotal != 0) {
                                  grandTotal = grandTotal.toFixed(2);
                                  }else{
                                  grandTotal = "";
                                  }
                                  
                                if(thisTotal != 0) {
                                   thisTotal = thisTotal.toFixed(2);
                                   }else{
                                   thisTotal = "";                                   
                                   }
                                
                                  document.form1.grand_total_pif2.value = grandTotal;                                   
                                  document.form1.grand_total_pif.value = thisTotal;
                       
}
//-------------------------------------------------------------------------------------------------------------------------------------------
function subtractMonthToMonth(serviceCost) {

var currentValue = document.form1.month_service.value;
currentValue = parseFloat(currentValue);
serviceCost = parseFloat(serviceCost);

if (isNaN(currentValue)) {
     currentValue = 0.00;
}
if (isNaN(serviceCost)) {
     serviceCost = 0.00;
}

currentValue = currentValue - serviceCost;
currentValue  = currentValue.toFixed(2);

//set the radio buttons in the payment form if the service total is 0.00
setPaymentRadioButtons(currentValue);

document.form1.month_service.value = currentValue;

//clear out the init fee field


                    if(currentValue == 0.00)  {
                        //clear out the init fee field
                        //document.getElementById('serve_down').innerHTML = currentValue;
                        //document.form1.down_pay.value = ""; 
               
try{

      if(memSwitch == "") {
        document.getElementById('serve_init').innerHTML = currentValue;
        document.form1.init_fee.value = "";
        document.form1.init_base.value = "";
        document.form1.open_end.checked = false;
        document.form1.init_fee.disabled = true;
        memSwitch = ""; 
        }

}
catch (e){

      if(typeof memSwitch === "undefined") {
        document.getElementById('serve_init').innerHTML = currentValue;
        document.form1.init_fee.value = "";
        document.form1.init_base.value = "";
        document.form1.open_end.checked = false;
        document.form1.init_fee.disabled = true;
       // memSwitch = ""; 
        }
  
}  
                                                  
                          
                        var pifFee  =  document.form1.full_fee.value;
                        var eftFee  =  document.form1.month_fee.value;
                        eftFee = parseFloat(eftFee);
                        pifFee = parseFloat(pifFee);
                        var combinedFee = eftFee + pifFee;
                        var subtractFee = combinedFee - eftFee;                        
                        eftFee = eftFee.toFixed(2);
                        pifFee = pifFee.toFixed(2);       
                        combinedFee = combinedFee.toFixed(2);
                        subtractFee = subtractFee.toFixed(2);
                                               
          //alert(combinedFee);        
                   
                        var processFees = document.getElementById('process_fees').innerHTML;
                        processFees = parseFloat(processFees);
                        processFees = processFees.toFixed(2);
                                               
                                        if(processFees == eftFee)  {
                                          currentProcFee = currentValue;
                                         }else if(processFees == pifFee) {
                                          currentProcFee = pifFee;
                                         }else if(processFees == combinedFee) {
                                          currentProcFee = subtractFee;
                                         }else{
                                         currentProcFee = currentValue;
                                         }
                              
                      // currentProcFee = currentProcFee.toFixed(2);
                       document.getElementById('process_fees').innerHTML = currentProcFee;
                     }


document.getElementById('serve_month').innerHTML = currentValue;

           // setGrandTotal();

}
//-------------------------------------------------------------------------------------------------------------------------------------------
function addMonthToMonth(serviceCost) {

var currentValue = document.form1.month_service.value;


currentValue = parseFloat(currentValue);
serviceCost = parseFloat(serviceCost);

if (isNaN(currentValue)) {
     currentValue = 0.00;
}
if (isNaN(serviceCost)) {
     serviceCost = 0.00;
}

currentValue = currentValue + serviceCost;
currentValue  = currentValue.toFixed(2);

//set the radio buttons in the payment form if the service total is 0.00
setPaymentRadioButtons(currentValue);

document.form1.month_service.value = currentValue;
document.getElementById('serve_month').innerHTML = currentValue;


var pifFee  =  document.form1.full_fee.value;
var eftFee  =  document.form1.month_fee.value;
eftFee = parseFloat(eftFee);
pifFee = parseFloat(pifFee);
var thisFee = eftFee + pifFee;

var processFees = document.getElementById('process_fees').innerHTML;
           if(processFees == eftFee)  {
                      currentProcFee = eftFee;
             }else if(processFees == pifFee)  {                  
                      currentProcFee = thisFee;
             }else if(processFees == thisFee) {
                      currentProcFee = thisFee;             
             }else{
                      currentProcFee = eftFee;                          
             }
            currentProcFee = currentProcFee.toFixed(2);
             document.getElementById('process_fees').innerHTML = currentProcFee;
          
             //this function divides the fees into monthly payments
             monthyPayments();
             //set the grand total
            // setGrandTotal();
            
}
//-----------------------------------------------------------------------------------------------------------------------------------------
function subtractPrepaid(serviceCost) {

var currentValue = document.form1.pre_paid_service.value;


currentValue = parseFloat(currentValue);
serviceCost = parseFloat(serviceCost);


if (isNaN(currentValue)) {
     currentValue = 0.00;
}
if (isNaN(serviceCost)) {
     serviceCost = 0.00;
}

currentValue = currentValue - serviceCost;
currentValue  = currentValue.toFixed(2);

var currentValueField = currentValue;

if(currentValue == 0.00)  {
currentValueField = "";
}

document.form1.pre_paid_service.value = currentValueField;


                    //deletes the current process fee summary
                     if(currentValue == 0.00)  {
                        var pifFee  =  document.form1.full_fee.value;
                        var eftFee  =  document.form1.month_fee.value;
                        eftFee = parseFloat(eftFee);                        
                        pifFee = parseFloat(pifFee);                        
                        var combinedFee = eftFee + pifFee;
                        var subtractFee = combinedFee - pifFee;
                        eftFee = eftFee.toFixed(2);
                        pifFee = pifFee.toFixed(2);
                        combinedFee = combinedFee.toFixed(2);
                        subtractFee = subtractFee.toFixed(2);
                        
                        var processFees = document.getElementById('process_fees').innerHTML;
                        processFees = parseFloat(processFees);
                        processFees = processFees.toFixed(2);
                                        if(processFees == pifFee)  {
                                          currentProcFee = currentValue;
                                         }else if(processFees == eftFee) {
                                          currentProcFee = eftFee;
                                         }else if(processFees == combinedFee) {
                                          currentProcFee = subtractFee;
                                         }else{
                                         currentProcFee = currentValue;
                                         }
                              
                      //currentProcFee = currentProcFee.toFixed(2);
                       document.getElementById('process_fees').innerHTML = currentProcFee;

                     }

                     document.getElementById('serve_pif').innerHTML = currentValue;

            setPifGrandTotal();
            //sets the total amount due in the summary
            setGrandTotal();
}
//---------------------------------------------------------------------------------------------------------------------------------------------
function addPrepaid(serviceCost) {

var currentValue;
var currentValueField;


currentValue = document.form1.pre_paid_service.value;

currentValue = parseFloat(currentValue);
serviceCost = parseFloat(serviceCost);

//for use with the grand total field
var totalCurrentValue = currentValue;

if (isNaN(currentValue)) {
     currentValue = 0;
}
if (isNaN(serviceCost)) {
     serviceCost = 0;
}

currentValue = currentValue + serviceCost;
currentValue  = currentValue.toFixed(2);


document.form1.pre_paid_service.value = currentValue;
document.getElementById('serve_pif').innerHTML = currentValue;


var pifFee  =  document.form1.full_fee.value;
var eftFee  =  document.form1.month_fee.value;
eftFee = parseFloat(eftFee);
pifFee = parseFloat(pifFee);
var thisFee = eftFee + pifFee;

var processFees = document.getElementById('process_fees').innerHTML;
           if(processFees == pifFee)  {
                      currentProcFee = pifFee;
             }else if(processFees == eftFee)  {                  
                      currentProcFee = thisFee;
             }else if(processFees == thisFee) {
                      currentProcFee = thisFee;             
             }else{
                      currentProcFee = pifFee;                          
             }
            currentProcFee = currentProcFee.toFixed(2);
            document.getElementById('process_fees').innerHTML = currentProcFee;
            //sets the grand total for paid in full services
            setPifGrandTotal();
            
            //sets the total amount due in the summary
            setGrandTotal();
            
            
            
}
//----------------------------------------------------------------------------------------------------------------------------------------------
function addRenewalFees(renCost) {
//alert(renCost);
        var j = 1;
        var renField = renGroup.replace("_type", "");   
        var renValue = document.form1.elements[renField][j].value;

     if(renValue != "NA")  {

       var renTotal = document.getElementById('ren_total').innerHTML;
            renTotal = parseFloat(renTotal);
            renCost = parseFloat(renCost);
            renTotal = renTotal + renCost;
            if (isNaN(renTotal )) {
                renTotal  = 0.00;
               }
            
            //add leading zeros
            renTotal = renTotal.toFixed(2);
            document.getElementById('ren_total').innerHTML = renTotal;
           
       }
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function subtractRenewalFees(renCost) {

//var j = 1;
//var renField = renGroup.replace("_type", "");   
//var renValue = document.form1.elements[renField][j].value;
//alert(renValue);

if (isNaN(renCost)) {
renCost = 0;
}

////if(renValue != "")  {
var renTotal = document.getElementById('ren_total').innerHTML;
renTotal = parseFloat(renTotal);
renCost = parseFloat(renCost);
renTotal = renTotal - renCost;
if (isNaN(renTotal )) {
     renTotal  = 0.00;
}

//add leading zeros
renTotal = renTotal.toFixed(2);
document.getElementById('ren_total').innerHTML = renTotal;
//}

}

//------------------------------------------------------------------------------------------------------------------------------------------------
function addServiceFees(serviceCost)   {

var serviceTotal = document.getElementById('serve_total').innerHTML;
serviceTotal = parseFloat(serviceTotal);
serviceCost = parseFloat(serviceCost);

serviceTotal = serviceTotal + serviceCost;

if(servicePatternResult != true) {
addPrepaid(serviceCost);
}else{
addMonthToMonth(serviceCost);
}


//add leading zeros
serviceTotal = serviceTotal.toFixed(2);
document.getElementById('serve_total').innerHTML = serviceTotal;

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function subtractServiceFees(prevCost) {

var serviceTotal = document.getElementById('serve_total').innerHTML;
serviceTotal = parseFloat(serviceTotal);
prevCost = parseFloat(prevCost);

serviceTotal = serviceTotal - prevCost;

if(servicePatternResult != true) {
subtractPrepaid(prevCost);
}else{
subtractMonthToMonth(prevCost);
}

//add leading zeros
serviceTotal = serviceTotal.toFixed(2);
document.getElementById('serve_total').innerHTML = serviceTotal;

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function setProcessingFees(groupArray)  {

groupArray =  groupArray.split("|");

var monthFee = groupArray[0];
monthFee = parseFloat(monthFee);
monthFee = monthFee.toFixed(2);

var fullFee = groupArray[1];
fullFee = parseFloat(fullFee);
fullFee = fullFee.toFixed(2);

document.form1.month_fee.value = monthFee;
document.form1.full_fee.value = fullFee;

if(servicePatternResult == true) {
    document.form1.process_fee_eft.value = monthFee;
   }else{
    document.form1.process_fee_pif.value = fullFee;
    }

}

//----------------------------------------------------------------------------------------------------------------------------------------------
function passServiceCosts(serviceKey, serviceDuration, serviceType, serviceCost, buttonGroup, idNum)     {
/*
1 second =1000milliseconds. sp divide milliseconds by 1000 to obtain seconds.
var d = Date.parse("September 16, 2013");
d=d / 1000;
document.write(d);
*/


//this is the number of members exiting for the account
this.groupNumber = parseInt(document.form1.group_number.value);
//sets up for renewal fees in later methods
this.renGroup = buttonGroup;
//this sets up the write to the processing fees
//var groupType = idNum.substr(1);

var idNumLength = idNum.length;

if(idNumLength == 2) {
   var groupType = idNum.substr(1);
  }
if(idNumLength == 3) {
   var groupType = idNum.substr(2);
  }
if(idNumLength == 4) {
   var groupType = idNum.substr(3);
  }


//some of these are set for use in other methods to reset the summarry divs
this.serviceD = serviceDuration;
this.summaryRowId = idNum;
this.serviceT = serviceType;
this.serviceK = serviceKey;
this.serviceC = serviceCost;
       serviceC= parseFloat(serviceC);
this.groupT = groupType;

var singleFees  = document.form1.single_fees.value;
var familyFees  = document.form1.family_fees.value;
var businessFees  = document.form1.business_fees.value;
var organizationFees  = document.form1.organization_fees.value;
//set up the group type for use with initiation fees etc
document.form1.group_type.value = groupType;


//this defines a variable for group types when creating monthly payments
 this.groupTypePayments = groupType;

//this creates the service type pattern
var servicePattern = /Month/g;
this.servicePatternResult = servicePattern.test(serviceDuration);
this.monthPatternResult = servicePatternResult;

if(servicePatternResult == true) {
var returnObject = checkEquals(serviceDuration, groupType, buttonGroup);
}


switch(groupType)  {
case 'S':
 setProcessingFees(singleFees);
 showMemNumber(groupType);
break;
case 'F':
setProcessingFees(familyFees);
showMemNumber(groupType);
break;
case 'B':
 setProcessingFees(businessFees);
 showMemNumber(groupType);
break;
case 'O':
 setProcessingFees(organizationFees);
 showMemNumber(groupType);
break;  
}




if(returnObject != false)  {
setField(serviceCost);
//this patern the price number that we use to subtract from a previous service total
var pat = /\d+\.\d{2}/;
//get existing elements
var searchString = document.getElementById(idNum).innerHTML;
var prevCost =pat.exec(searchString);
if(prevCost != null) {
subtractServiceFees(prevCost);
subtractRenewalFees(prevCost);
}

this.serviceAdjustOriginal = serviceC;

//calculates the number of members and adjust the price
serviceCost = parseMemNumber(serviceC);
serviceCost = serviceCost.toFixed(2);
serviceC = serviceCost;



if(monthPatternResult == true) {
setMonthlySummaryDivs();
}else{
//this writes to the sumarry fields when radio button is clicked
document.getElementById(idNum).innerHTML =  ('<table width="100%" cellpadding="1" cellspacing="0" align="left"><tr><td class="green" width="50%">' + serviceType +  '<span class="white"> '+ serviceKey +'</span></td><td class="green"align="left">' + serviceDuration + '</td><td class="green" align="right">' + serviceCost + ' </td><tr></table>');
}


var delay = function() { addServiceFees(serviceC); };
setTimeout(delay,500);



//addServiceFees(serviceCost);

addRenewalFees(serviceC);

//set the balance due date
//


}else{
return false;
}


}

//------------------------------------------------------------------------------------------------------------------------------------
function fieldChange(fieldValue, idNum, fieldName) {


var overCheck = document.form1.overide_pin.value;
var adjustVal = document.form1.elements[fieldName][2].value;

//disables upgrade m to m fields that are pro rated
  if(adjustVal != 0 && adjustVal != "NA" && adjustVal != "") {
     document.form1.elements[fieldName][0].disabled = true;
     document.form1.elements[fieldName][1].disabled = true;
     document.form1.elements[fieldName][2].disabled = true;
     }



this.renGroup = fieldName;
this.idNum = idNum;

var j = 1;
var i =0;
var fieldFocus;



//change the renewal value to match the new price
                 if(fieldName !="") {
                   var renValue = document.form1.elements[renGroup][j].value;
                        if(renValue != "NA") {
                           renValue = parseMemNumber(renValue);
                           subtractRenewalFees(renValue);
                           document.form1.elements[renGroup][j].value = fieldValue;
                           fieldValue = parseMemNumber(fieldValue);
                           addRenewalFees(fieldValue);
                          }
                  }
var fieldFocus = document.form1.elements[renGroup][i];
                  
try 
{

 fieldFocus.addEventListener ('keyup', function () {modifyServiceRenewals()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {modifyServiceRenewals()});                           
}          
                  
                  
                  
}
//-----------------------------------------------------------------------------------------------------------------------
function modifyServiceRenewals() {

//get the field value of the service price being typed
var i =0;
var j =1;
var serviceFieldValue = document.form1.elements[renGroup][i].value;

if (isNaN(serviceFieldValue)) {
     alert('Input Value must be a Number');
     return false;
   }

//alert(renGroup);

//change the renewal field value to match the service field value
document.form1.elements[renGroup][j].value = serviceFieldValue;

var currentTable= document.getElementById(idNum);
var tagHousing = currentTable.getElementsByTagName('td');
var currentProductType = tagHousing[0].innerHTML;
var currentServiceTerm = tagHousing[1].innerHTML;
var currentServiceCost = tagHousing[2].innerHTML;


//this parses the group type for the monthly payment function
 var groupPattern = /[A-Z]/;
 this.groupTypePayments = groupPattern.exec(idNum);
//alert(this.groupTypePayments);

var servicePattern = /Month/g;
this.servicePatternResult = servicePattern.test(currentServiceTerm);


currentServiceCost = parseFloat(currentServiceCost);
serviceFieldValue = parseFloat(serviceFieldValue);

if (isNaN(currentServiceCost)) {
     currentServiceCost = 0.00;
}

if (isNaN(serviceFieldValue)) {
     serviceFieldValue = 0.00;
}

subtractRenewalFees(currentServiceCost);
subtractServiceFees(currentServiceCost);
serviceFieldValue = parseMemNumber(serviceFieldValue);


serviceFieldValue = serviceFieldValue.toFixed(2);

currentTable.innerHTML =  ('<table width="100%" cellpadding="1" cellspacing="0" align="left"><tr><td class="green" width="50%">' + currentProductType +  '</td><td class="green"align="left">' + currentServiceTerm + '</td><td class="green" align="right">' + serviceFieldValue + '</td><tr></table>');

addServiceFees(serviceFieldValue);
addRenewalFees(serviceFieldValue);

}
//------------------------------------------------------------------------------------------------------------------------------------
function fieldChange2(renValue, fieldNameArray)   {


var fieldFocus;
renValue = parseFloat(renValue);
this.renGroup = fieldNameArray;

renValue = parseMemNumber(renValue);

document.form1.current_ren_rate.value = renValue;

if (isNaN(renValue)) {
     renValue = 0.00;
}

var j =1;
fieldFocus = document.form1.elements[fieldNameArray][j];

try 
{

 fieldFocus.addEventListener ('keyup', function () {modifyRen(this.value, this.name)}, false);
 fieldFocus.addEventListener ('change', function () {checkRenRate()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {modifyRen(this.value, this.name)});
fieldFocus.attachEvent("onchange",function () {checkRenRate()});                           
}
            

}
//-----------------------------------------------------------------------------------------------------------------------------------------
function modifyRen(fieldValue, fieldName)  {

//alert(renGroup);
var j =1;
fieldValue = document.form1.elements[renGroup][j].value;


if(fieldValue == "") {
  fieldValue = 0;
}

if(fieldValue == "N" || fieldValue == "A" || fieldValue == "NA")  {
  fieldValue = 0;
}else{
if (isNaN(fieldValue)) {
     alert('Input Value must be a Number');
     return false;
   }
}



fieldValue = parseFloat(fieldValue);
var currentValue = document.form1.current_ren_rate.value;
currentValue = parseFloat(currentValue);

if(currentValue == "N" || currentValue == "A" || currentValue == "NA")  {
  currentValue = 0;
}

//fieldValue = parseMemNumber(fieldValue);
//currentValue = parseMemNumber(currentValue);

subtractRenewalFees(currentValue);

fieldValue = parseMemNumber(fieldValue);

addRenewalFees(fieldValue);
              
document.form1.current_ren_rate.value = fieldValue;
}





