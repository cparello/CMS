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
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id)"' +creditSelected+'  '+creditDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type1"  name="billing_type1"  value="CR" onClick="return updateMonthlyBilling(this)"/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"' +bankSelected+'  '+bankDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type2"  name="billing_type2"  value="BA" onClick="return updateMonthlyBilling(this)"/>';
var cashRadio =  '<input type="radio"  id="monthly_billing3" name="monthly_billing"   value="CA" onClick="return checkServices(this.name,this.id)"' +cashSelected+'  '+cashDisabled+'/>&nbsp;&nbsp;&nbsp; <span class="black">Update Monthly Billing</span> <input type="checkbox" id="billing_type3"  name="billing_type3"  value="CA" onClick="return updateMonthlyBilling(this)"/>';
var checkRadio =  '<input type="radio" id="monthly_billing4"  name="monthly_billing"  value="CH" onClick="return checkServices(this.name,this.id)"'
+checkSelected+'  '+checkDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type4"  name="billing_type4"  value="CH" onClick="return updateMonthlyBilling(this)"/>';

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

//------------------------------------------------------------------------------------------------------------------------------------------
function showMemNumber(groupType)  {

try
  {

if(groupType == "S")  {
document.getElementById('memNum').style.visibility = 'hidden';
document.getElementById('mem_num').value = "";
}else{
document.getElementById('memNum').style.visibility = 'visible';
}


  }
catch(err)
  {
  //Handle errors here
  }




//shows the monthly payment options if there is an existing monthly service
var monthlyBillingType = document.form1.month_billing_type.value;
      if(monthlyBillingType != "") {
         var monthTotal = 0.00;
         setPaymentRadioButtons(monthTotal);
        }

}
//--------------------------------------------------------------------------------------------------------------------