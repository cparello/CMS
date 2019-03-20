
//==================================================================================
function setCancelBit() {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var serviceCancelBox = 'cancel';
var serviceCancelField = 'cancel_cost';
var boxCancelId;
var fieldCancelId;
var cancelBool = "";

        for (var j = 2, row; row = serviceTable.rows[j]; j++) {
        
            boxCancelId = (serviceCancelBox + rowId);
            fieldCancelId = (serviceCancelField +rowId);
            
               if(document.getElementById(boxCancelId).checked == true) {
                  cancelBool = 1;
                 }
    
             rowId++;
           }
           
  if(cancelBool == 1) {
    document.getElementById("cancel_bit").value = 1;
    }else{
    document.getElementById("cancel_bit").value = "";
    }

}
//-------------------------------------------------------------------------------------
function disableRefundCheckBoxes(fieldBool) {

//disable the refund check boxes
try  
{   
var refundMethod = document.form1.elements["refund_check"];   
      for(var v=0; v < refundMethod.length;  v++)  { 
           refundMethod[v].disabled = fieldBool;
          }   
}
catch(err)
{ }//end catch error

}
//------------------------------------------------------------------------------------
function  disableTransferFields(fieldBool) {

var transferBit = document.form1.transfer_bit.value;
      

if(transferBit == "1") {

try  
{   
document.getElementById("type_name").readOnly = fieldBool;
}
catch(err)
{ }//end catch error

document.getElementById("first_name").readOnly = fieldBool;
document.getElementById("middle_name").readOnly = fieldBool;
document.getElementById("last_name").readOnly = fieldBool;


}
}
//---------------------------------------------------------------------------------------
function disableRejectedTransactions(fieldBool) {

try  
{   
    var rejectTable = document.getElementById("secTab8");
    var fields = rejectTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = fieldBool;         
              }
    // document.form1.refund_balance.disabled = fieldBool;
}
catch(err)
{ }//end catch error



}
//--------------------------------------------------------------------------------------
function findMemberHoldChecks() {

 var refundTable = document.getElementById("groupList");
    var fields = refundTable.getElementsByTagName("input");
    var input;
    var boolCheck = false;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];
               
               if(input.checked == true) {
                  boolCheck = true;
                  }
               
              }
return boolCheck;
}
//---------------------------------------------------------------------------------------------
function disableRefunds(fieldBool) {

  var refundTable = document.getElementById("secTab3");
    var fields = refundTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = fieldBool;         
              }

     var refundMethod = document.form1.elements["refund_check"]; 
     for(var v=0; v < refundMethod.length;  v++)  { 
         refundMethod[v].disabled = fieldBool;
         }


}
//---------------------------------------------------------------------------------------------
function disableServiceCredit(bool) {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var serviceNumberField = 'serv_num';
var serviceCreditDrop = 'serv_credit';
var serveNumId;
var servCreditId;

        for (var j = 2, row; row = serviceTable.rows[j]; j++) {
        
            serveNumId = (serviceNumberField + rowId);
            servCreditId = (serviceCreditDrop +rowId);
            
            document.getElementById(serveNumId).disabled = bool;
            document.getElementById(servCreditId).disabled = bool;

             rowId++;
           }

}
//---------------------------------------------------------------------------------------------
function disableServiceHold(bool) {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var serviceHoldBox = 'hold';

        for (var j = 2, row; row = serviceTable.rows[j]; j++) {
        
            serveHoldId = (serviceHoldBox + rowId);
            
            document.getElementById(serveHoldId).disabled = bool;
             rowId++;
           }

}
//---------------------------------------------------------------------------------------------
function parseDisableFields(fieldBool) {

//first we disable all of the refunds if available
try  
{   
    var refundTable = document.getElementById("secTab3");
    var fields = refundTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = fieldBool;         
              }
     document.form1.refund_balance.disabled = fieldBool;
}
catch(err)
{ }//end catch error


//now we disable the available holds cancelations and credit terms
    var refundTable = document.getElementById("secTab4");
    var fields = refundTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = fieldBool;         
              }


//disable members if they exist
try  
{   
    var refundTable = document.getElementById("groupList");
    var fields = refundTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = fieldBool;         
              }
    
}
catch(err)
{ }//end catch error


document.form1.past_due_balance.disabled = fieldBool;
document.form1.cancelation_balance.disabled = fieldBool;
document.form1.hold_balance.disabled = fieldBool;

if(fieldBool == true) {
   var transferFee = document.form1.transfer_fee.value;
   }else{
   var transferFee = '0.00';
   }
document.form1.total_balance_due.value = transferFee;


}
//----------------------------------------------------------------------------------------------------------------
function disableFields(obj) {

//get current object values
var fieldName = obj.name;
var fieldValue = obj.value;
var disableBit;

//get the current fild values
var firstName = document.form1.first_name.value;
      firstName = firstName.replace(/^\s+|\s+$/g,"");
      firstName = firstName.replace(/\t/g, '');
var middleName = document.form1.middle_name.value;
      middleName = middleName.replace(/^\s+|\s+$/g,"");
      middleName = middleName.replace(/\t/g, '');
var lastName = document.form1.last_name.value;
      lastName = lastName.replace(/^\s+|\s+$/g,"");
      lastName = lastName.replace(/\t/g, '');

//get hidden field original values
var typeNameOrig = document.form1.type_name_orig.value;
var firstNameOrig = document.form1.first_name_orig.value
var middleNameOrig = document.form1.middle_name_orig.value;
var lastNameOrig = document.form1.last_name_orig.value;
var transferFee = document.form1.transfer_fee.value;

//see if there is a business or organization name
try
{
var typeName = document.form1.type_name.value;
      typeName = typeName.replace(/^\s+|\s+$/g,"");
      typeName = typeName.replace(/\t/g, '');
      
      
}catch(err)
{ }


//clean white space
fieldValue =  fieldValue.replace(/^\s+|\s+$/g,"");
fieldValue = fieldValue.replace(/\t/g, '');


switch(fieldName)  {
case "type_name":
  if(typeNameOrig != fieldValue) {      
      disableBit = 1;
     }
  break;
case "first_name":
  if(firstNameOrig != fieldValue) {      
      disableBit = 1;
     }
  break;
case "middle_name":
  if(middleNameOrig != fieldValue) {      
      disableBit = 1;
     }
  break;  
case "last_name":
  if(lastNameOrig != fieldValue) {      
      disableBit = 1;
     }
  break;  
}

//now we check all of the fields and adjust the disable bit to a 0 value and reset the fields
try
{

if(typeName == typeNameOrig && firstName == firstNameOrig && middleName == middleNameOrig &&  lastName == lastNameOrig) {
   disableBit = 0;
  }

}
catch(err)
{

if(firstName == firstNameOrig && middleName == middleNameOrig &&  lastName == lastNameOrig) {
   disableBit = 0;
  }

}//end catch error


// if the disable bit is set to one then we disable all fields
if(disableBit == 1) {
   var fieldBool = true;
        parseDisableFields(fieldBool); 
        disableRejectedTransactions(fieldBool);
}


if(disableBit == 0)  {
   var fieldBool = false;
         parseDisableFields(fieldBool); 
         disableRejectedTransactions(fieldBool);
         
   var accFlag = document.form1.acc_flag.value;      
         if(accFlag == 1)  {
           disableServiceCancel();         
           }
           
           try{
           disableGroupCancel(); 
           }
           catch(err)
          { }
         
 }


}
//-----------------------------------------------------------------------------------------------------------------------
function disableServiceCancel() {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var serviceCancelBox = 'cancel';
var serviceCancelField = 'cancel_cost';
var boxCancelId;
var fieldCancelId;

        for (var j = 2, row; row = serviceTable.rows[j]; j++) {
        
            boxCancelId = (serviceCancelBox + rowId);
            fieldCancelId = (serviceCancelField +rowId);
            
            document.getElementById(boxCancelId).disabled = true;
            document.getElementById(fieldCancelId).disabled = true;

             rowId++;
           }

}
//--------------------------------------------------------------------------------------------------------------------------
function disableServiceCancelTwo(bool) {

var serviceTable = document.getElementById("secTab4");
var tabRow = serviceTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var serviceCancelBox = 'cancel';
var serviceCancelField = 'cancel_cost';
var boxCancelId;
var fieldCancelId;

        for (var j = 2, row; row = serviceTable.rows[j]; j++) {
        
            boxCancelId = (serviceCancelBox + rowId);
            fieldCancelId = (serviceCancelField +rowId);
            
            document.getElementById(boxCancelId).disabled = bool;
            document.getElementById(fieldCancelId).disabled = bool;

             rowId++;
           }

}
//-----------------------------------------------------------------------------------------------------------------------------
function disableMemberCancel(cancelBool) {

try  
{   
var refundMembersTable = document.getElementById("groupList"); 
var refundTabRow = refundMembersTable.getElementsByTagName('tr');
 

var row2; 
var rowId2 = 1;
var cancelMemBox = 'cancel_mem';
var cancelMemId; 

           for (var k = 1, row2; row2 = refundMembersTable.rows[k]; k++) {                  
                  cancelMemId = (cancelMemBox + rowId2);
                  try{
                  document.getElementById(cancelMemId).disabled = cancelBool;
                  }catch(err){}
                   rowId2++;
                 }


}
catch(err)
{

}//end catch error



}
//-------------------------------------------------------------------------------------------------------------------------
function disableGroupCancel() {

try  
{   
var refundMembersTable = document.getElementById("groupList"); 
var refundTabRow = refundMembersTable.getElementsByTagName('tr');
 
var row;
var rowId = 1; 
var refundCancelBox = 'cancel_mem';
var refundCancelField = 'cancel_member';
var cancelBoxId;
var fieldCancelId;
 
           for (var j = 1, row; row = refundMembersTable.rows[j]; j++) {
                  
                  cancelBoxId = (refundCancelBox + rowId);
                  fieldCancelId = (refundCancelField + rowId);
                                    
                  document.getElementById(cancelBoxId).disabled = true;
                  document.getElementById(fieldCancelId).disabled = true;

                   rowId++;
                 }

}
catch(err)
{

}//end catch error


}
//--------------------------------------------------------------------------------------------------------------------------
function checkUncheckMemberHolds(holdBool)  {

try  
{   
var refundMembersTable = document.getElementById("groupList"); 
var refundTabRow = refundMembersTable.getElementsByTagName('tr');
 
var row;
var row2;
var rowId = 1; 
var rowId2 = 1;
var refundHoldBox = 'hold_mem';
var cancelMemBox = 'cancel_mem';
var memberHoldId; 
var cancelMemId; 

           for (var j = 1, row; row = refundMembersTable.rows[j]; j++) {                  
                  memberHoldId = (refundHoldBox + rowId);
                  document.getElementById(memberHoldId).disabled = holdBool;
                   rowId++;
                 }


           for (var k = 1, row2; row2 = refundMembersTable.rows[k]; k++) {                  
                  cancelMemId = (cancelMemBox + rowId2);
                  try{
                  document.getElementById(cancelMemId).disabled = holdBool;
                  }catch(err){}
                   rowId2++;
                 }


}
catch(err)
{

}//end catch error


}
//---------------------------------------------------------------------------------------------------------------------------
function disableMemberHolds(holdBool)  {

try  
{   
var refundMembersTable = document.getElementById("groupList"); 
var refundTabRow = refundMembersTable.getElementsByTagName('tr');
 
var row;
var rowId = 1; 
var refundHoldBox = 'hold_mem';
var memberHoldId; 


           for (var j = 1, row; row = refundMembersTable.rows[j]; j++) {                  
                  memberHoldId = (refundHoldBox + rowId);
                  try{
                   document.getElementById(memberHoldId).disabled = holdBool;
                   }catch(err){}
                   rowId++;
                 }


}
catch(err)
{

}//end catch error



}
//---------------------------------------------------------------------------------------------------------------------------
function checkAll(id, count) {

 var payDues = document.form1.elements["pay_dues[]"]; 
 var payName = 'pay_dues';
 var payId;
document.getElementById('un_select_all').checked = false;


var anyCheckedBool = 0;
if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         if (document.getElementById(payId).checked == true){
            anyCheckedBool = 1;
         } 
    }
}
if (anyCheckedBool == 1){
    alert('Some boxes are already checked. To use check all please unselect these boxes first.');
    return false;
}

 //takes care of multiple rejections so that other section check boxes will not uncheck
 if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         
           if(document.getElementById('select_all').checked == true) {
                document.getElementById(payId).checked = true; 
                var totalValue = document.form1.total_balance_due.value;
                var pastDue = document.form1.past_due_balance.value;
                     if(isNaN(totalValue)) {
                       totalValue = 0;
                       }
                     if(totalValue == "") {
                       totalValue = 0;
                       }
                       totalValue =  parseFloat(totalValue);
                      
                var paymentTotalName = 'rejection_total';
                var paymentTotalId;
                 paymentTotalId = (paymentTotalName +i);
                var rejectionTotal = document.getElementById(paymentTotalId).value;
                      rejectionTotal = parseFloat(rejectionTotal);

 
                   var fieldBool = true;
                   var totalBalanceDue = totalValue + rejectionTotal;
 
   
                
                 var fieldBit;
                if(fieldBit == 1) {
                  fieldBool = true;
                  }
                   
                // parseDisableFields(fieldBool);
                 disableRefundCheckBoxes(fieldBool)
                 disableTransferFields(fieldBool);
                 disableServiceCredit(fieldBool);
                 disableMemberCancel(fieldBool);
                 disableMemberHolds(fieldBool);
                 disableServiceCancelTwo(fieldBool);
                 disableServiceHold(fieldBool);

 
                  try{
                 document.getElementById('billing_type1').disabled = fieldBool;
                 document.getElementById('billing_type2').disabled = fieldBool;
                 document.getElementById('billing_type3').disabled = fieldBool; 
                 document.getElementById('billing_type4').disabled = fieldBool;
                 document.getElementById('update_billing_type').disabled = fieldBool;                      
                 }catch(err){}
            //alert('fu');
            totalBalanceDue22 = totalBalanceDue;
            totalBalanceDue = totalBalanceDue.toFixed(2);
            document.form1.total_balance_due.value = totalBalanceDue;
            pastDue = parseFloat(pastDue);
            var combined = totalBalanceDue22 + pastDue;
            combined = combined.toFixed(2);
            //alert(combined);
            document.form1.combined_total_balance_due.value = combined;         
                          } 
                                      
                    }
   }
  
      
}
//---------------------------------------------------------------------------------------------------------------------------
function unCheckAll(id, count) {

 var payDues = document.form1.elements["pay_dues[]"]; 
 var payName = 'pay_dues';
 var payId;
 if (document.getElementById('select_all').checked == false){
    alert('Check all boxes was not selected!');
    document.getElementById('un_select_all').checked = false;
    return false;
    }
 
var anyCheckedBool = 0;
if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         if (document.getElementById(payId).checked == false){
            anyCheckedBool = 1;
         } 
    }
}
if (anyCheckedBool == 1){
    alert('Not all of the boxes are checked. To use Uncheck all please select all the boxes first.');
    return false;
}


 //takes care of multiple rejections so that other section check boxes will not uncheck
 if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         
           if(document.getElementById('un_select_all').checked == true) {
                document.getElementById(payId).checked = false; 
                var totalValue = document.form1.total_balance_due.value;
                var pastDue = document.form1.past_due_balance.value;
                     if(isNaN(totalValue)) {
                       totalValue = 0;
                       }
                     if(totalValue == "") {
                       totalValue = 0;
                       }
                       totalValue =  parseFloat(totalValue);
                      
                var paymentTotalName = 'rejection_total';
                var paymentTotalId;
                 paymentTotalId = (paymentTotalName +i);
                var rejectionTotal = document.getElementById(paymentTotalId).value;
                      rejectionTotal = parseFloat(rejectionTotal);

 
                   var fieldBool = true;
                   var totalBalanceDue = totalValue - rejectionTotal;
 
   
                
                 var fieldBit;
                if(fieldBit == 1) {
                  fieldBool = true;
                  }
                   
                // parseDisableFields(fieldBool);
                 disableRefundCheckBoxes(fieldBool)
                 disableTransferFields(fieldBool);
                 disableServiceCredit(fieldBool);
                 disableMemberCancel(fieldBool);
                 disableMemberHolds(fieldBool);
                 disableServiceCancelTwo(fieldBool);
                 disableServiceHold(fieldBool);

 
                  try{
                 document.getElementById('billing_type1').disabled = fieldBool;
                 document.getElementById('billing_type2').disabled = fieldBool;
                 document.getElementById('billing_type3').disabled = fieldBool; 
                 document.getElementById('billing_type4').disabled = fieldBool;
                 document.getElementById('update_billing_type').disabled = fieldBool;                      
                 }catch(err){}
            //alert('fu');
            totalBalanceDue22 = totalBalanceDue;
            totalBalanceDue = totalBalanceDue.toFixed(2);
            document.form1.total_balance_due.value = totalBalanceDue;
            pastDue = parseFloat(pastDue);
            var combined = pastDue - totalBalanceDue22;
            combined = combined.toFixed(2);
            //alert(combined);
            document.form1.combined_total_balance_due.value = combined;         
                          } 
                                      
                    }
   }
  
      document.getElementById('select_all').checked = false;
}
//---------------------------------------------------------------------------------------------------------------------------
function loadFundsAvailable(holdCheckValue) {

var fundsAvailable = document.form1.funds_available.value;
var holdCheckArray = holdCheckValue.split("|");
var monthlyDues = holdCheckArray[4];
var fundsTotal;
 
      if(monthlyDues == "") {
         monthlyDues = 0;
         }
         
      monthlyDues = parseFloat(monthlyDues);
      fundsAvailable = parseFloat(fundsAvailable);
      fundsAvailable = (fundsAvailable +  monthlyDues);
      document.form1.funds_available.value = fundsAvailable;
      
}
//----------------------------------------------------------------------------------------------------------------------------
function checkUncheckCancel(checkBool)  {

var hccTable = document.getElementById("secTab4");
var tabRow = hccTable.getElementsByTagName('tr');

var row;
var rowId = 1;
var creditDropElement = "";
var creditNumElement = "";
var creditHideElement = "";
var holdBoxElement = "";
var cancelCheckElement = "";
var cancelFieldElement = "";
var creditDrop = 'serv_credit';
var creditNum = 'serv_num';
var creditHide = 'serv_keys';
var holdCheckId = 'hold';
var cancelCheckId = 'cancel';

var trueFalse = "";

if(checkBool == 1)  {
   trueFalse = true;
   }
if(checkBool == 0)  {
   trueFalse = false;
   }   
//alert(trueFalse);
for (var i = 2, row; row = hccTable.rows[i]; i++) {

       cancelCheckElement = (cancelCheckId + rowId);
      // cancelFieldElement = (cancelField + rowId);
       creditDropElement = (creditDrop + rowId);
       creditNumElement = (creditNum + rowId);
       creditHideElement = (creditHide +rowId);
       holdBoxElement = (holdCheckId +rowId); 


       
          if(document.getElementById(cancelCheckElement).disabled == true) {
                   document.getElementById(creditDropElement).disabled = true;
                   document.getElementById(creditNumElement).disabled = true;
                   document.getElementById(creditHideElement).disabled = true;
                   document.getElementById(holdBoxElement).disabled = true;                                      
                   }else{
                   document.getElementById(creditDropElement).disabled = trueFalse;
                   document.getElementById(creditNumElement).disabled = trueFalse;
                   document.getElementById(creditHideElement).disabled = trueFalse;
                   document.getElementById(holdBoxElement).disabled = trueFalse;
                   }
       
       
                                
       rowId++;

}

}
//----------------------------------------------------------------------------------------------------------------------------
function checkUncheckHolds(checkBool, holdFee, holdFlag) {

//here we look to see if there are refunds available so that if a hold is checked then released that the cancel fields stay disabled
var accFlag = document.form1.acc_flag.value;

var hccTable = document.getElementById("secTab4");
var tabRow = hccTable.getElementsByTagName('tr');
var accFlag = document.form1.acc_flag.value;


var row;
var rowId = 1;
var cancelCheckElement;
var cancelFieldElement;
var creditDropElement;
var creditNumElement;
var creditHideElement;
var holdBoxElement;
var col;
var trueFalse;
var holdCost = 0;

if(checkBool == 1)  {
   col = "#900"; 
   trueFalse = true;
   }
if(checkBool == 0)  {
   col = "#fff"; 
   trueFalse = false;
   }   

     try{
     document.getElementById('billing_type1').disabled = trueFalse;
     document.getElementById('billing_type2').disabled = trueFalse;
     document.getElementById('billing_type3').disabled = trueFalse; 
     document.getElementById('billing_type4').disabled = trueFalse;
     document.getElementById('update_billing_type').disabled = trueFalse;                      
     }catch(err){}
     
     try{
     var refundMethod = document.form1.elements["refund_check"]; 
     for(var v=0; v < refundMethod.length;  v++)  { 
         refundMethod[v].disabled = trueFalse;
         }
     }catch(err){}

        for (var i = 2, row; row = hccTable.rows[i]; i++) {
                     
               cancelCheckElement = (cancelCheckId + rowId);
               cancelFieldElement = (cancelField + rowId);
               creditDropElement = (creditDrop + rowId);
               creditNumElement = (creditNum + rowId);
               creditHideElement = (creditHide +rowId);
               holdBoxElement = (holdCheckId +rowId); 
               
               tabRow[i].style.backgroundColor = col;                                 
                   
                document.getElementById(cancelCheckElement).disabled = trueFalse;
                document.getElementById(cancelFieldElement).disabled = trueFalse;
                document.getElementById(creditDropElement).disabled = trueFalse;
                document.getElementById(creditNumElement).disabled = trueFalse;
                document.getElementById(creditHideElement).disabled = trueFalse;
                
               if(document.getElementById(holdBoxElement).disabled != true) {
                   document.getElementById(holdBoxElement).checked = trueFalse;
                   
                   }else{
                                      
                   document.getElementById(cancelCheckElement).disabled = true;
                   document.getElementById(cancelFieldElement).disabled = true;
                   document.getElementById(creditDropElement).disabled = true;
                   document.getElementById(creditNumElement).disabled = true;
                   document.getElementById(creditHideElement).disabled = true; 
                 //  tabRow[rowId].style.backgroundColor = "#fff";
                   }
              
                
                  if(accFlag == 1) {
                      document.getElementById(cancelCheckElement).disabled = true;
                      document.getElementById(cancelFieldElement).disabled = true;   
                     }
                               
                
                if(trueFalse == true && document.getElementById(holdBoxElement).disabled != true) {
                   holdCost = holdCost + holdFee;
                  }else if(trueFalse == false && document.getElementById(holdBoxElement).disabled != true) {
                   holdCost = holdCost + holdFee;
                  }
                
                   //this handles the cancel elements if it is set to disables on the backend
            //      if(checkBool == 0) {
             //         if(accFlag == "") {
                      //  document.getElementById(cancelCheckElement).disabled = false;
                      //  document.getElementById(cancelFieldElement).disabled = false;
             ///           }else{
                       // document.getElementById(cancelCheckElement).disabled = true;
                        //document.getElementById(cancelFieldElement).disabled = true;                                             
               //         }                  
               //     }                     
                
                
                                
           rowId++;
           }
return holdCost;           
}
//-----------------------------------------------------------------------------------------------------------------------------
function checkHoldBit(obj, holdBit) {

var serviceValArray = obj.value.split("|");
var serviceId = serviceValArray[5];
var holdBitVal = document.form1.hold_bit_array.value;
var holdBitArray = holdBitVal.split("|");
      
      for(var i=0; i < holdBitArray.length; i++) {
           if(holdBitArray[i] == serviceId) {
               var holdFlag = 1;
              }      
           }

if(holdFlag == 1) {
  holdBit = 0;
  }

return holdBit;    

}
//------------------------------------------------------------------------------------------------------------------------------
function checkMemberHoldBit(obj, holdBit) {

var memberValArray = obj.value.split("|");
var generalId = memberValArray[1];
var memberHoldBitVal = document.form1.member_hold_bit_array.value;
var memberHoldBitArray = memberHoldBitVal.split("|");
      
      for(var i=0; i < memberHoldBitArray.length; i++) {
           if(memberHoldBitArray[i] == generalId) {
               var holdFlag = 1;
              }      
           }

if(holdFlag == 1) {
  holdBit = 0;
  }

return holdBit;    

}

//------------------------------------------------------------------------------------------------------------------------------
function setMemberHold(obj) {

var memberValArray = obj.value.split("|");
var memberId = memberValArray[0];
var generalId = memberValArray[1];
var contractKey = memberValArray[2];
var successKey;

 if(!obj.checked) {
         var ajaxSwitch = 2;
               serviceStatus = 'CU';
               var response =  confirm('This will realese the hold on this member. Do you wish to continue?');
         }       

//if the response is false then we return false and reset the check box. if not we release the hold
if(!response) {         
return false;

}else{

  var parameters = "";
  parameters = parameters+'ajax_switch='+ajaxSwitch;
  parameters = parameters+'&contract_key3='+contractKey;
  parameters = parameters+'&member_id='+memberId;
  parameters = parameters+'&general_id='+generalId;


//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }
 
xmlHttp.open("POST", "updateAccountInfo.php", false);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(parameters);


              successKey =  xmlHttp.responseText; 
   
               if(successKey != 1) {
                 alert('There was an error processing the hold on this member: \n'  +successKey);  
                          return false;
                } 
   
               if(successKey == 1) {  
                  var holdBitArray = document.form1.member_hold_bit_array.value;
                        holdBitArray = (holdBitArray + generalId + '|');
                        document.form1.member_hold_bit_array.value = holdBitArray;  
                 }    

}


}
//-----------------------------------------------------------------------------------------------------------------------------
function setServiceHold(obj)  {

var serviceValArray = obj.value.split("|");
var contractKey = serviceValArray[1];
var serviceKey = serviceValArray[2];
var serviceStatus = serviceValArray[3];
var monthlyDues = serviceValArray[4];
var serviceId = serviceValArray[5];
var successKey;
var streetAddress = document.getElementById('street_address').value;
var city = document.getElementById('city').value;
var state = document.getElementById('state').value;
var zipCode = document.getElementById('zip_code').value;
var homePhone = document.getElementById('home_phone').value;
var email = document.getElementById('email').value;
var licNumber = document.getElementById('lic_num').value;

streetAddress = encodeURIComponent(streetAddress);
city = encodeURIComponent(city);
state = encodeURIComponent(state);
zipCode = encodeURIComponent(zipCode);
homePhone = encodeURIComponent(homePhone);
email = encodeURIComponent(email);
licNumber = encodeURIComponent(licNumber);




this.passStatus = false;


      if(!obj.checked) {
         var ajaxSwitch = 1;
               serviceStatus = 'CU';
               var response =  confirm('This will realese the hold on this service. Do you wish to continue?');
         }       


//if the response is false then we return false and reset the check box. if not we release the hold
if(!response) {         
return false;

}else{


var hccTable = document.getElementById("secTab4");
var tabRow = hccTable.getElementsByTagName('tr');
var row;
var rowId = 1;
var holdBoxElement;
var holdCheckValue;
var holdCheckArray = "";
var holdValueArray = "";
var holdFlag;

                for (var i = 2, row; row = hccTable.rows[i]; i++) {
                      holdBoxElement = (holdCheckId +rowId);
                      holdCheckValue = document.getElementById(holdBoxElement).value; 
                      
                      holdValueArray = holdCheckValue.split("|");
                      holdFlag = holdValueArray[6];                    
                     
                      if(holdFlag != 1) {
                         loadFundsAvailable(holdCheckValue);
                         holdCheckArray +=(holdCheckValue +'@');
                        }
                      rowId++;                          
                      }

  
  var parameters = "";
  parameters = parameters+'ajax_switch='+ajaxSwitch;
  parameters = parameters+'&hold_check_array='+holdCheckArray;
  parameters = parameters+'&account_street='+streetAddress;
  parameters = parameters+'&account_city='+city;
  parameters = parameters+'&account_state='+state;
  parameters = parameters+'&account_zip='+zipCode;
  parameters = parameters+'&account_phone='+homePhone;
  parameters = parameters+'&account_email='+email;
  parameters = parameters+'&lic_number='+licNumber;

//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }
 
xmlHttp.open("POST", "updateAccountInfo.php", false);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(parameters);


              successKey =  xmlHttp.responseText; 
           
              if(successKey == 2) {
                 alert('There was an error processing this financial transaction.');  
                          return false;
                }
   
               if(successKey != 1) {
                 alert('There was an error processing the hold on this service: \n'  +successKey);  
                          return false;
                } 
   
               if(successKey == 1) {  
                  var holdBitArray = document.form1.hold_bit_array.value;
                        holdBitArray = (holdBitArray + serviceId + '|');
                        document.form1.hold_bit_array.value = holdBitArray;  
                 }    

   }//end if response was true from the prompt alert
    
      
}
//------------------------------------------------------------------------------
function showHideRadioButtons(monthSwitch)   {

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
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id);"' +creditSelected+'  '+creditDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type1"  name="billing_type1"  value="CR" onClick="return updateMonthlyBilling(this)"/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"' +bankSelected+'  '+bankDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type2"  name="billing_type2"  value="BA" onClick="return updateMonthlyBilling(this)"/>';
var cashRadio =  '<input type="radio"  id="monthly_billing3" name="monthly_billing"   value="CA" onClick="return checkServices(this.name,this.id)"' +cashSelected+'  '+cashDisabled+'/>&nbsp;&nbsp;&nbsp; <span class="black">Update Monthly Billing</span> <input type="checkbox" id="billing_type3"  name="billing_type3"  value="CA" onClick="return updateMonthlyBilling(this)"/>';
var checkRadio =  '<input type="radio" id="monthly_billing4"  name="monthly_billing"  value="CH" onClick="return checkServices(this.name,this.id)"'
+checkSelected+'  '+checkDisabled+'/>&nbsp;&nbsp;&nbsp; Update Monthly Billing <input type="checkbox" id="billing_type4"  name="billing_type4"  value="CH" onClick="return updateMonthlyBilling(this)"/>';

if(monthSwitch == 0)  {
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

//------------------------------------------------------------------------------------------------------
function checkMonthBit(monthBit, addSub)  {
    
  monthBit = parseInt(monthBit);  
    
    //first check if there is a partial payment involved
    if(monthBit == 2) {    
       switch(addSub)  {
       case 'plus':
       showHideRadioButtons(0);
       break;
       case 'minus':
       showHideRadioButtons(1);
       break; 
       }    
     }

   //now see if it is service month
   if(monthBit == 1) {   
      var monthlyServiceCount = document.form1.monthly_service_count.value;
            monthlyServiceCount = parseInt(monthlyServiceCount);
   
         switch(addSub)  {
         case 'plus':
         monthlyServiceCount = monthlyServiceCount - monthBit;
         document.form1.monthly_service_count.value = monthlyServiceCount;
         break;
         case 'minus':
         monthlyServiceCount = monthlyServiceCount + monthBit;
         document.form1.monthly_service_count.value = monthlyServiceCount;
         break; 
         }     
         
               if(monthlyServiceCount == 0) {
                 showHideRadioButtons(0);
                }else{
                showHideRadioButtons(1);
                }   
     }



}
//----------------------------------------------------------------------------------------------------
function checkAvailable(val, fieldId) {

    if(val == 'NA') {
       document.getElementById(fieldId).disabled = true;  
      }
      
}

//----------------------------------------------------------------------------------------------------
function addSubtractTotalFees(subBal, sumBit)  { 

var totalBalanceDue = document.form1.total_balance_due.value;
       
       if(totalBalanceDue == "") {
         totalBalanceDue = 0;
         }
      
      totalBalanceDue = parseFloat(totalBalanceDue);

       if(sumBit == 0) {
         totalBalanceDue = totalBalanceDue + subBal;
         }else if(sumBit == 1) {
         totalBalanceDue = totalBalanceDue - subBal;
         }
         
          totalBalanceDue = totalBalanceDue.toFixed(2);
          document.form1.total_balance_due.value = totalBalanceDue;

}

//----------------------------------------------------------------------------------------------------
function checkRefund(obj, serviceId) {

var refundTable = document.getElementById("secTab3");
var checkBox = refundTable.getElementsByTagName("input");
var input;
var valArray;
var servId;
var refundCount = 0;

         for(var i=0; i < checkBox.length; i++) {
              input = checkBox[i];
              valArray = input.value.split("|");
              servId = valArray[5];
              
              if(input.checked == true) {
                 if(servId == serviceId) {
                    refundCount++;
                   }
                 }

             }

return refundCount;

}
//----------------------------------------------------------------------------------------------------
//takes care of refunds
function changeColor1(obj, r1, refundAmount, monthBit) {

//this toggles the color of the row
var col='#fff';
var x=document.getElementById(r1);
x.style.backgroundColor = (obj.checked) ? "#06C" : col;
var lastDayBit = document.getElementById('last_day').value;

//this breaks down the values of the checked box
var valueArray = obj.value.split("|");
var refundType= valueArray[3];
var serviceId = valueArray[5];


refundAmount = parseFloat(refundAmount);
var refundBalance = document.form1.refund_balance.value;
      refundBalance = parseFloat(refundBalance);

       if(obj.checked) {
         checkMonthBit(monthBit,'plus');
         var t = true;
         }else{
         checkMonthBit(monthBit,'minus');
         var t = false;
        }
                    

  //enable and or disable payment check boxes
if(refundBalance == 0) {
    var u = false;
    var z = true;   
   }else{
    var u = true;  
    var z = false;
   }
   var refundMethod = document.form1.elements["refund_check"];   
        for(var v=0; v < refundMethod.length;  v++)  { 
            refundMethod[v].disabled = false;
            }


             
//her we get the number of checkboxes in the parent table to compare 
var refundTable = document.getElementById("secTab3");
var checkBox = refundTable.getElementsByTagName("input");
var listLength = checkBox.length;
var parentTabRow = refundTable.getElementsByTagName('tr');
var cbNum = 0;
var servIdArray = "";
var delimiter = '|';
var input = "";
var valArray;
var servId;
var servCost;
var refType;
var rowNum = 1;
var startNum = "";



if(refundType != 'BNN' && refundType != 'BNR'  && refundType != 'BNU' && refundType != 'NCF' && refundType != 'RNF' && refundType != 'UPF' && refundType != 'NMF')  {   



//checks to see if there is on var in array, if this is the case then do no do a loop
if(listLength == 1) {

      input = checkBox[0];
      valArray = input.value.split("|");
      servId = valArray[5];
      refType = valArray[3];
      servCost = valArray[0];
      servCost = parseFloat(servCost);
      
       if(obj.checked) {
          refundBalance = refundBalance + servCost;                           
         }else{
          refundBalance = 0;
         }
      
/*
BNN = Bundled New Fee                                  
BNR = Bundled Renewal Fee
BNU = Bundled Upgrade Fees
NCF = New Contract Fee
RNF = Renewal Fee
UPF = Upgrade Fee
NMF = New Member Fee
INF = Initiation Fee
DNP = Down Payment
SMP = Service Monthly Prorate
SPF = Service Paid in Full
SPP = Service Paid Prorate
*/      
      
 }else{
refundBalance = 0;
//here we check all of the viable boxes above the currrent service id
for(var i= 0; i < checkBox.length; i++) {
      input = checkBox[i];
      valArray = input.value.split("|");
      servId = valArray[5];
      refType = valArray[3];
      servCost = valArray[0];
      servCost = parseFloat(servCost);
          
         
       if(obj.checked) {

            if(obj.checked == input.checked) {
               startNum = i;
               }else{
               startNum = "";
               }
       //   alert(startNum);
          
          if(startNum != "") {
                 if(i >= startNum) {          
                         if(refType != 'BNN' && refType != 'BNR'  && refType != 'NCF' && refType != 'RNF'  && refType != 'NMF')  {          
                             //input.checked = true;   
                           //  input.disabled = true;
                             parentTabRow[rowNum].style.backgroundColor = "#06C";  
                             refundBalance += servCost;                
                            }                      
                      }
               }

          
         }else{

                input.checked = false;   
                input.disabled = false;  
                parentTabRow[rowNum].style.backgroundColor = "#FFF"; 
                refundBalance = 0;
                                
         }  //end if obj checked
         
                  
            //this checks to see if there are non fee checked boxes and creates a count and an array list
            if(input.type == "checkbox" && input.checked==true) {          
               cbNum++;
               servIdArray += (servId + delimiter);
               }       
               
        rowNum++;   
        obj.disabled= false; 
           
    }//end for loop
}//end else if only one var

    
rowNum = 2;    


//end if not refund type
 }else{
 
 if(obj.checked) {
            
        var refundCount = checkRefund(obj, serviceId);
              if(refundCount == 1) {
                 
                    alert('Please select the corresponding service to refund before selecting a \"Fee\" to refund.');
                            x.style.backgroundColor = "#FFF";
                            obj.checked = false;
                            return false;              
                           }
                 
                                  
         refundBalance = refundBalance + refundAmount;         
         }else{
         refundBalance = refundBalance - refundAmount; 
        }
         
 }


         // set the refund balance for the field
           refundBalance = refundBalance.toFixed(2);                      
           document.form1.refund_balance.value = refundBalance;
     
    
//here we disable the holds and the credit fields if a refund is checked    for (var j = 1, row; row = hccTable.rows[j]; j++) { 
var hccTable = document.getElementById("secTab4");
var tabRow = hccTable.getElementsByTagName('tr');

var row;
var rowId = 1;
var serviceCancelBox = 'cancel';
var serviceHoldBox = 'hold';
var serviceKeys = 'serv_keys';
var serviceNum = 'serv_num';
var serviceCredit = 'serv_credit';
var serviceHoldId;
var serviceCancelId;
var serviceKeysId;
var serviceNumId;
var serviceCreditId;
var col;

        for (var j = 2, row; row = hccTable.rows[j]; j++) {
        
            serviceCancelId = (serviceCancelBox + rowId);
            serviceHoldId = (serviceHoldBox + rowId);
            serviceKeysId = (serviceKeys + rowId);
            serviceNumId = (serviceNum + rowId);
            serviceCreditId = (serviceCredit +rowId);
           
             
             if(input.checked == true)  {  
             
                document.getElementById(serviceHoldId).disabled = true;
                document.getElementById(serviceKeysId).disabled = true;
                document.getElementById(serviceNumId).disabled = true;
                document.getElementById(serviceCreditId).disabled = true;  
                
                try{
                document.getElementById('billing_type1').disabled = true;
                document.getElementById('billing_type2').disabled = true;
                document.getElementById('billing_type3').disabled = true; 
                document.getElementById('billing_type4').disabled = true;
                document.getElementById('update_billing_type').disabled = true;
                }catch(err){}
                
                }else{
                document.getElementById(serviceHoldId).disabled = z;
                document.getElementById(serviceKeysId).disabled = z;
                document.getElementById(serviceNumId).disabled = z;
                document.getElementById(serviceCreditId).disabled = z;
                
                try{
                document.getElementById('billing_type1').disabled = z;
                document.getElementById('billing_type2').disabled = z;
                document.getElementById('billing_type3').disabled = z; 
                document.getElementById('billing_type4').disabled = z;
                document.getElementById('update_billing_type').disabled = z;                
                }catch(err){}
                
                }
                                
           rowId++;
           }
 

   //do a try catch in case ther are no member rcords. This unchecks the member hold fields
   checkUncheckMemberHolds(z);
   disableRejectedTransactions(z);
   disableTransferFields(z);

}

//----------------------------------------------------------------------------------------------------
//this takes care of holds
function changeColor3(obj, r1, holdBit, cancelField, cancelCheckId, creditDrop, creditNum, creditHide, holdFlag) {

this.cancelCheckId = cancelCheckId;
this.cancelField = cancelField;
this.creditDrop = creditDrop;
this.creditNum = creditNum;
this.creditHide = creditHide;
this.holdCheckId = 'hold';



holdBit = parseInt(holdBit);
var holdBalance = document.form1.hold_balance.value;
      holdBalance = parseFloat(holdBalance);
var holdFee;
var groupBool;
var col='#fff';
var x;

//here we check to make sure the service has already been canceled if it has been then we set the hold bit to zero
holdBit = checkHoldBit(obj, holdBit);

     //find out if this is an existing hold if it is do not charge a hold fee and release hold through ajax call
      if(holdBit != 1) {
          holdFee = document.form1.hold_fee.value;   
          holdFee = parseFloat(holdFee);
         }else if(holdBit == 1) {
          holdFee = 0;
          holdFee = parseFloat(holdFee);
          var releaseBool = setServiceHold(obj);
                if(releaseBool == false) {
                   return false;
                  }                     
         }


      x=document.getElementById(r1);                                        
      x.style.backgroundColor = (obj.checked) ? "#900" : col;

  

         //if checked then add to the hold balance field
        if(obj.checked) {
           holdFee = checkUncheckHolds(1,holdFee, holdFlag);
           holdBalance = holdBalance + holdFee; 
           addSubtractTotalFees(holdFee, 0);
           groupBool = true;
                      
           }else{    
           holdFee = checkUncheckHolds(0,holdFee, holdFlag); 
           holdBalance = holdBalance - holdFee;   
           addSubtractTotalFees(holdFee, 1);
           groupBool = false;
                     
           }
// alert(holdFee);        
           holdBalance = holdBalance.toFixed(2);
           document.form1.hold_balance.value = holdBalance;
           
disableRejectedTransactions(groupBool);
disableTransferFields(groupBool);
           
   //do a try catch in case ther are no member rcords
try  
{   
 //here we disable the group check boxes if they exist  
var accFlag = document.form1.acc_flag.value;
var refundMembersTable = document.getElementById("groupList");
var fields = refundMembersTable.getElementsByTagName("input");
var input;



for(var i=0; i < fields.length; i++) {   
        input = fields[i];              
        input.disabled = groupBool;         
    }

if(accFlag != "")  {
   disableGroupCancel();
     if(obj.checked) {
        var fieldBool = true;
              disableRefunds(fieldBool);
        }else{
        var fieldBool = false;
              disableRefunds(fieldBool);        
         }   
   }



}
catch(err)
{
if(accFlag != "")  {
 if(obj.checked) {
        var fieldBool = true;
              disableRefunds(fieldBool);
        }else{
        var fieldBool = false;
              disableRefunds(fieldBool);        
         } 
 }        
}//end catch error           
           


}

//----------------------------------------------------------------------------------------------------------------------
//takes care of cancelations
function changeColor2(obj, r1, holdCheckId, cancelField, creditDrop, creditNum, creditHide, monthBit) {

var cancelationBalance = document.form1.cancelation_balance.value;
      cancelationBalance = parseFloat(cancelationBalance);
var cancelationFee;
var col='#fff';
var x;
var groupBool;

      x=document.getElementById(r1);                                        
      x.style.backgroundColor = (obj.checked) ? "#06C" : col;
      
      //get fee check to see if this cancel fee is not a number
      cancelationFee = document.form1.elements[cancelField].value;
      //if the cancelation fee is NA then disable the field
      if(cancelationFee == 'NA')  {
         document.form1.elements[cancelField].disabled = true;      
         }
      
      if (isNaN(cancelationFee)) {
          cancelationFee = 0;
         }
         
        cancelationFee = parseFloat(cancelationFee);

        if(obj.checked) {
           cancelationBalance = cancelationBalance + cancelationFee;
           addSubtractTotalFees(cancelationFee, 0);
           document.form1.elements[creditDrop].disabled = true;
           document.form1.elements[creditNum].disabled = true;
           document.form1.elements[creditHide].disabled = true;           
           document.getElementById(holdCheckId).disabled = true;   
           groupBool = true;
           checkMonthBit(monthBit,'plus');           
           
           try{  
           //disables enables billing type
           document.getElementById('billing_type1').disabled = true;
           document.getElementById('billing_type2').disabled = true;
           document.getElementById('billing_type3').disabled = true; 
           document.getElementById('billing_type4').disabled = true;
           document.getElementById('update_billing_type').disabled = true;
           }catch(err){}           
                      
           }else{
           cancelationBalance = cancelationBalance - cancelationFee;
           addSubtractTotalFees(cancelationFee, 1);
           document.form1.elements[creditDrop].disabled = false;
           document.form1.elements[creditNum].disabled = false;
           document.form1.elements[creditHide].disabled = false;           
           document.getElementById(holdCheckId).disabled = false; 
           groupBool = false;
           checkMonthBit(monthBit,'minus');
           
           try{  
           //disables enables billing type
           document.getElementById('billing_type1').disabled = false;
           document.getElementById('billing_type2').disabled = false;
           document.getElementById('billing_type3').disabled = false; 
           document.getElementById('billing_type4').disabled = false;
           document.getElementById('update_billing_type').disabled = false;
           }catch(err){}  
           
           }

//disrables rejections
disableRejectedTransactions(groupBool);
disableTransferFields(groupBool);

  //disable hold and service credit fields 
        if(obj.checked) {
           checkUncheckCancel(1);           
           }else{           
           checkUncheckCancel(0);           
           }

           cancelationBalance = cancelationBalance.toFixed(2);
           document.form1.cancelation_balance.value = cancelationBalance;  
   
   //do a try catch in case ther are no member rcords
try  
{   
 //here we disable the group check boxes if they exist  
var refundMembersTable = document.getElementById("groupList");
var fields = refundMembersTable.getElementsByTagName("input");
var input;

for(var i=0; i < fields.length; i++) {   
        input = fields[i];              
        input.disabled = groupBool;         
    }
           
}
catch(err){}//end catch error
   //in the case that there is not a fee attached to the cancel      
   setCancelBit();
}
//--------------------------------------------------------------------------------------------------------------------------
function disableHoldCancel(bool)  {

var accFlag = document.form1.acc_flag.value; 

//here we disable the holds and the credit fields if a refund is checked    for (var j = 1, row; row = hccTable.rows[j]; j++) { 
var hccTable = document.getElementById("secTab4");
var tabRow = hccTable.getElementsByTagName('tr');

var row;
var rowId = 1;
var serviceCancelBox = 'cancel';
var serviceCancelCost = 'cancel_cost';
var serviceHoldBox = 'hold';
var serviceNum = 'serv_num';
var serviceCredit = 'serv_credit';
var serviceHoldId;
var serviceCancelId;
var serviceCancelCostId;
var serviceKeysId;
var serviceNumId;
var serviceCreditId;
var col;

     try{  
     //disables enables billing type
     document.getElementById('billing_type1').disabled = bool;
     document.getElementById('billing_type2').disabled = bool;
     document.getElementById('billing_type3').disabled = bool; 
     document.getElementById('billing_type4').disabled = bool;
     document.getElementById('update_billing_type').disabled = bool;     
     }catch(err){}

     try{
     var refundMethod = document.form1.elements["refund_check"]; 
     for(var v=0; v < refundMethod.length;  v++)  { 
         refundMethod[v].disabled = bool;
         }
    }catch(err){}
    
    try{
    var refund = document.form1.elements["refund[]"];
     for(var v=0; v < refund.length;  v++)  { 
         refund[v].disabled = bool;
         }    
    }catch(err){}

        for (var j = 2, row; row = hccTable.rows[j]; j++) {
        
            serviceCancelId = (serviceCancelBox + rowId);
            serviceCancelCostId = (serviceCancelCost + rowId);
            serviceHoldId = (serviceHoldBox + rowId);
            serviceNumId = (serviceNum + rowId);
            serviceCreditId = (serviceCredit +rowId);
                                              
              //  document.getElementById(serviceHoldId).disabled = bool;
                
          //      if(accFlag == 1) {
          //        document.getElementById(serviceCancelId).disabled = true;
          //        document.getElementById(serviceCancelCostId).disabled = true;   
          //        }else{
          //        document.getElementById(serviceCancelId).disabled = bool;
          //        document.getElementById(serviceCancelCostId).disabled = bool;                   
          //        }
         
         if(document.getElementById(serviceNumId).disabled == true) {
                   document.getElementById(serviceCancelId).disabled = true;
                   document.getElementById(serviceCancelCostId).disabled = true;
                   document.getElementById(serviceCreditId).disabled = true;    
                   document.getElementById(serviceHoldId).disabled = true;                   
                   }else{
                   document.getElementById(serviceCancelId).disabled = bool;
                   document.getElementById(serviceCancelCostId).disabled = bool;
                   document.getElementById(serviceHoldId).disabled = bool;
                   
                   if(accFlag == 1) {
                      document.getElementById(serviceCancelId).disabled = true;
                      document.getElementById(serviceCancelCostId).disabled = true;   
                     }
                   
                   
                   }
              
        
         
         
         
                                
           rowId++;
           }

}
//--------------------------------------------------------------------------------------------------------------------------
function creditServiceTerm(fieldValue, fieldId, cancelCheck, cancelCost, holdCheck) {

var boolTwo;
var upgradeServiceBit;

//check to see if the char that is typed is a number. if not return false
var bool = checkNan(fieldValue,fieldId);
     if(bool == false) {
        return false;     
       }

//here we disable all of the fields fields except this input field and the adjacent drop down list
var creditFieldValue = document.getElementById(fieldId).value;

      if(creditFieldValue != "") {            
           boolTwo = true;
           disableHoldCancel(boolTwo);
           checkUncheckMemberHolds(boolTwo);
         }else{         
           boolTwo = false;
           disableHoldCancel(boolTwo);
           checkUncheckMemberHolds(boolTwo);
         }
         
}
//--------------------------------------------------------------------------------------------------------------------------
function checkNan(numberValue,fieldName)  {

var fullFieldValue = document.getElementById(fieldName).value;
var newFieldValue;


if(isNaN(fullFieldValue)) {

newFieldValue = fullFieldValue.slice(0,-1);
document.getElementById(fieldName).value = newFieldValue;

  alert('The value you entered is not a number.');
  return false;
  }

}
//--------------------------------------------------------------------------------------
function setCancelFee(todaysPayment, cancelCheckId)  {

if(document.getElementById(cancelCheckId).checked == true) {

var cancelationBalance;
var totalBalanceDue;
var cancelationDif;
var totalBalanceDif;

cancelationBalance = document.form1.cancelation_balance.value;
cancelationBalance = parseFloat(cancelationBalance);
totalBalanceDue = document.form1.total_balance_due.value;
totalBalanceDue = parseFloat(totalBalanceDue);
todaysPayment = parseFloat(todaysPayment);

if(isNaN(todaysPayment)) {
  todaysPayment = 0;
  }
if(isNaN(totalBalanceDue)) {
  totalBalanceDue = 0;
  }
if(isNaN(cancelationBalance)) {
  cancelationBalance = 0;
  }  
  
 
cancelationDif = cancelationBalance - todaysPayment;
totalBalanceDue = totalBalanceDue - cancelationDif;
cancelationBalance = cancelationBalance - cancelationDif;


totalBalanceDue = totalBalanceDue.toFixed(2);
cancelationBalance = cancelationBalance.toFixed(2);

document.form1.cancelation_balance.value = cancelationBalance;
document.form1.total_balance_due.value = totalBalanceDue;

}
}

//-----------------------------------------------------------------------------------------------
//takes care of member cancel
function prorateMembers(obj, r1, refundUnit, col, cancelField, holdCheck) {

//alert(holdCheck);

//this toggles the color of the row
var x=document.getElementById(r1);
x.style.backgroundColor = (obj.checked) ? "#06C" : col;

//get the group list length
var groupTable = document.getElementById("groupList");
var groupLength = groupTable.rows.length;
      groupLength = groupLength - 1;

//get the individual rate array
var indiRateArray = document.form1.group_price_array.value;
      indiRateArray = indiRateArray.split("|");
      
//get the past balance due
var pastDueBalance = document.form1.past_due_balance.value;

//check the refund disabled keys
var refundTest = document.form1.test.value;

      
//get the info form the account list table and change the html deduction
var serviceTable = document.getElementById("secTab4");
var row;
var quantity;
var currentRate;
var indiRate;
var q = 3;
var p = 4;   
var r = 0;
var sumBit;

//this var is for disableing the available refunds if exists
var bool;

if(obj.checked) {
  bool = true;
  disableMemberHolds(bool);  
  disableServiceCredit(bool);
  disableHoldCancel(bool);  
}else{
  bool = false;
  disableMemberHolds(bool);  
  disableServiceCredit(bool);
  disableHoldCancel(bool);  
}

//this setsup the adjustment to the new quantity and cost
for (var i = 2, row; row = serviceTable.rows[i]; i++) {

         quantity = row.cells[q].innerHTML;
         quantity = parseInt(quantity);
         currentRate = row.cells[p].innerHTML;
         currentRate = parseFloat(currentRate);
         
         //get the individual rate
          r = i - 2;
          indiRate = indiRateArray[r];
          indiRate = parseFloat(indiRate);
          
          
          if(obj.checked) {
            quantity = quantity - 1;
            row.cells[q].innerHTML = quantity;                    
            currentRate = currentRate - indiRate;
            currentRate = currentRate.toFixed(2);
            row.cells[p].innerHTML = currentRate; 
            t = true;
            }else{
            quantity = quantity + 1;
            row.cells[q].innerHTML = quantity;            
            currentRate = currentRate + indiRate;
            currentRate = currentRate.toFixed(2);
            row.cells[p].innerHTML = currentRate;
            t = false;
            }
        
}


          //here we check to see if there is a balance due that can be credited
          if(pastDueBalance != "0.00"  && refundTest != "")  {

             pastDueBalance = parseFloat(pastDueBalance);
             refundUnit = parseFloat(refundUnit);
   
                    if(obj.checked) {
                      pastDueBalance = pastDueBalance - refundUnit;
                      document.form1.elements[holdCheck].disabled = true;
                      pastDueBalance = pastDueBalance.toFixed(2);
                      document.form1.past_due_balance.value = pastDueBalance;
                      sumBit = 1;
                      addSubtractTotalFees(refundUnit, sumBit);                
                     }else{
                      pastDueBalance = pastDueBalance + refundUnit;
                      document.form1.elements[holdCheck].disabled = false;
                      pastDueBalance = pastDueBalance.toFixed(2);
                      document.form1.past_due_balance.value = pastDueBalance;
                      sumBit = 0;
                      addSubtractTotalFees(refundUnit, sumBit);
                     }
          
             }

   
   
            //if no past due balance tan due this
            if(pastDueBalance == "0.00"  && refundTest != "")  {

                   refundUnit = parseFloat(refundUnit);
             var refundBalance = document.form1.refund_balance.value;
                   refundBalance = parseFloat(refundBalance);
                   
                   if(obj.checked) {
                     refundBalance = refundBalance + refundUnit;
                    document.form1.elements[holdCheck].disabled = true;
                    }else{
                    refundBalance = refundBalance - refundUnit;
                    document.form1.elements[holdCheck].disabled = false;                    
                    }
                   
                   refundBalance = refundBalance.toFixed(2);
                   document.form1.refund_balance.value = refundBalance;  
                                      
              }
                          

//in case there is a refund enable or disable the checkboxes in the payment fields
try  
{

 if(pastDueBalance < 0 || document.form1.refund_balance.value > 0) {
   var u = false;   
   }else{
   var u = true; 
   }
   var refundMethod = document.form1.elements["refund_check"];   
        for(var v=0; v < refundMethod.length;  v++)  { 
            refundMethod[v].disabled = u;
            }    
}
catch(err)
{

}//end catch error


             //here we create the cancelation balance
             if(refundTest == "")  {
             
             var cancelationBalance = document.form1.cancelation_balance.value;
                   cancelationBalance = parseFloat(cancelationBalance);
             var cancelationFee;
                   //get fee check to see if this cancel fee is not a number
                  cancelationFee = document.form1.elements[cancelField].value;
                        //if the cancelation fee is NA then disable the field
                        if(cancelationFee == 'NA')  {
                          document.form1.elements[cancelField].disabled = true;      
                           }
      
                        if(isNaN(cancelationFee)) {
                         cancelationFee = 0;
                           }
         
                    cancelationFee = parseFloat(cancelationFee);
                    
                    if(obj.checked) {
                      cancelationBalance = cancelationBalance + cancelationFee;
                      document.form1.elements[holdCheck].disabled = true;
                      addSubtractTotalFees(cancelationFee, 0);
                      }else{
                      cancelationBalance = cancelationBalance - cancelationFee;
                      document.form1.elements[holdCheck].disabled = false;
                      addSubtractTotalFees(cancelationFee, 1);
                      }
                        cancelationBalance = cancelationBalance.toFixed(2);
                        document.form1.cancelation_balance.value = cancelationBalance;
             
             }


//here we disable the main available refunds if they exist
//her we get the number of checkboxes in the member table to compare 
var refundMembersTable = document.getElementById("groupList");
var checkBox = refundMembersTable.getElementsByTagName("input");
var cbNum = 0;
var input;

for(var i=0; i < checkBox.length; i++) {
    input = checkBox[i];
        if (input.type == "checkbox" && input.checked==true) {
            cbNum++;
           }              
    }

if(cbNum != 0)  {
  var t = true;
 }

//get the info form the account list table and change the html deduction
var refundRows = document.getElementById('secTab3').getElementsByTagName('tr');
var refundRowCount = refundRows.length;
//alert(refundRowCount);
var noRefundRow = 2;
var testRefundRows = document.getElementById('secTab3').rows[1].cells[0].innerHTML;

 if(testRefundRows != 'No Refunds Available') { 
      //this setsup disableing available service refunds if a member is selected
       for (var b = 0; b <= refundRowCount; b++) {   
             try{
             document.form1.elements['refund[]'] [b].disabled = t;
             }catch(err){}
             
             }  
              
    }else{
    
    var refundMembersTable = document.getElementById("secTab4");
    var fields = refundMembersTable.getElementsByTagName("input");
    var input;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i];              
               input.disabled = t;         
              }
    
    }

}

//------------------------------------------------------------------------------------------------------------------------------------------
//this is for member holds
function changeColor4(obj, r1, col, cancelCheck, cancelField, holdBit, typeBit) {
/*
var holdValue = obj.value;
var holdValueArray =  holdValue.split("|");
var memberNumber = holdValueArray[0];
      if(memberNumber == 'Unassigned') {
         alert('This member has not been assigned an ID Number. An ID Number must be assigned to this member before a hold can be placed');
                 return false;
         }
*/         

      holdBit = parseInt(holdBit);
var memberHoldFee;
var serviceBool;
var holdBalance = document.form1.hold_balance.value;
      holdBalance = parseFloat(holdBalance);
var x;   

      
//here we check to make sure the service has already been canceled if it has been then we set the hold bit to zero
holdBit = checkMemberHoldBit(obj, holdBit);      
      

       //find out if this is an existing hold if it is do not charge a hold fee
      if(holdBit != 1) {
          memberHoldFee = document.form1.member_hold_fee.value;   
          memberHoldFee = parseFloat(memberHoldFee);
         }else if(holdBit == 1) {
          memberHoldFee = 0;
          memberHoldFee = parseFloat(memberHoldFee);
          
          //send to function to release the hold
          var releaseBool = setMemberHold(obj);
                if(releaseBool == false) {
                   return false;
                  }                   
         }
         

      x=document.getElementById(r1);                                        
      x.style.backgroundColor = (obj.checked) ? "#900" : col; 
 
 
         //if checked then add to the hold ballance field
        if(obj.checked) {
           holdBalance = holdBalance + memberHoldFee; 
           addSubtractTotalFees(memberHoldFee, 0);
           
           try{
           document.form1.elements[cancelCheck].disabled = true;
           document.form1.elements[cancelField].disabled = true;
           }catch(err){}
           
           serviceBool = true;
           }else{
           holdBalance = holdBalance - memberHoldFee;    
           addSubtractTotalFees(memberHoldFee, 1);
           serviceBool = false;
           
           if(typeBit == 0) {
           
              try{
              document.form1.elements[cancelCheck].disabled = false;
              document.form1.elements[cancelField].disabled = false; 
              }catch(err){}
              
              }else{
              
              try{
              document.form1.elements[cancelCheck].disabled = true;
              document.form1.elements[cancelField].disabled = true;  
              }catch(err){}
              
              }
                    
           }


        

           holdBalance = holdBalance.toFixed(2);
           document.form1.hold_balance.value = holdBalance;

    //this disables the service table elements when checked
    var accFlag = document.form1.acc_flag.value;
    var serviceTable = document.getElementById("secTab4");
    var fields = serviceTable.getElementsByTagName("input");
    var drops = serviceTable.getElementsByTagName("select");
    var input;
    var sel;
    
          for(var i=0; i < fields.length; i++) {   
               input = fields[i]; 
               input.disabled = serviceBool;  
              }
              
          for(var i=0; i < drops.length; i++) {   
               sel = drops[i];
               sel.disabled = serviceBool;
              }       
              
        try{        
        document.getElementById("billing_type1").disabled = serviceBool;
        document.getElementById("billing_type2").disabled = serviceBool;
        document.getElementById("billing_type3").disabled = serviceBool;
        document.getElementById("billing_type4").disabled = serviceBool;
        }catch(err){}
              

if(accFlag != "")  {
   disableServiceCancel();
     if(obj.checked) {
        var fieldBool = true;
              disableRefunds(fieldBool);
        }else{
        var fieldBool = findMemberHoldChecks();
              disableRefunds(fieldBool);        
         }         
   }

disableRejectedTransactions(serviceBool);
disableTransferFields(serviceBool);
disableMemberCancel(serviceBool);
}
//------------------------------------------------------------------------------------------------------------
function changeRejectFee(obj, salt) {

var rejectFieldName = 'rejection_fee';
var rejectFieldId = (rejectFieldName +salt);

var paymentTotalName = 'rejection_total';
var paymentTotalId = (paymentTotalName +salt);
var rejectFee = obj.value;
      rejectFee =  parseFloat(rejectFee);        
var paymentTotal = document.getElementById(paymentTotalId).value;
var combinedTotal = document.getElementById('combined_total_balance_due').value;
      paymentTotal = parseFloat(paymentTotal);
      combinedTotal = parseFloat(combinedTotal);
    
 if(obj.checked) { 
   paymentTotal = paymentTotal + rejectFee;
   paymentTotal = paymentTotal.toFixed(2);  
   combinedTotal = combinedTotal + rejectFee;
   combinedTotal = combinedTotal.toFixed(2);   
                            document.getElementById(paymentTotalId).value = paymentTotal;
                            document.getElementById('combined_total_balance_due').value = combinedTotal;
                            document.getElementById(rejectFieldId).disabled = false;
   }else{   
   paymentTotal = paymentTotal - rejectFee;
   paymentTotal = paymentTotal.toFixed(2);   
   combinedTotal = combinedTotal - rejectFee;
   combinedTotal = combinedTotal.toFixed(2);   
                            document.getElementById(paymentTotalId).value = paymentTotal;  
                            document.getElementById('combined_total_balance_due').value = combinedTotal;
                            document.getElementById(rejectFieldId).disabled = true; 
   }
   
 var payName = 'pay_dues';
 var payId;   
       payId = (payName +salt);
       
       if(document.getElementById(payId).checked == true) {
          var totalValue = document.form1.total_balance_due.value;
                totalValue = parseFloat(totalValue);
                
                if(obj.checked) { 
                   totalValue = totalValue + rejectFee;
                   totalValue = totalValue.toFixed(2);
                   document.form1.total_balance_due.value = totalValue;
                   }else{
                   totalValue = totalValue - rejectFee;
                   totalValue = totalValue.toFixed(2);
                   document.form1.total_balance_due.value = totalValue;                                      
                   }
             
          }
   
   
}
//------------------------------------------------------------------------------------------------------------
function changeLateFee(obj, salt) {

var lateFieldName = 'late_fee';
var lateFieldId = (lateFieldName +salt);

var paymentTotalName = 'rejection_total';
var paymentTotalId = (paymentTotalName +salt);
var lateFee = obj.value;
      lateFee =  parseFloat(lateFee);        
var paymentTotal = document.getElementById(paymentTotalId).value;
var combinedTotal = document.getElementById('combined_total_balance_due').value;
      paymentTotal = parseFloat(paymentTotal);
      combinedTotal = parseFloat(combinedTotal);

 if(obj.checked) { 
   paymentTotal = paymentTotal + lateFee;
   combinedTotal = combinedTotal  + lateFee;
   paymentTotal = paymentTotal.toFixed(2);
   combinedTotal = combinedTotal.toFixed(2);
                            document.getElementById(paymentTotalId).value = paymentTotal;
                            document.getElementById('combined_total_balance_due').value = combinedTotal;
                            document.getElementById(lateFieldId).disabled = false;
   }else{   
   paymentTotal = paymentTotal - lateFee;
   paymentTotal = paymentTotal.toFixed(2);   
   combinedTotal = combinedTotal - lateFee;
   combinedTotal = combinedTotal.toFixed(2);   
                            document.getElementById(paymentTotalId).value = paymentTotal;
                            document.getElementById('combined_total_balance_due').value = combinedTotal;
                            document.getElementById(lateFieldId).disabled = true;
   }
   
 var payName = 'pay_dues';
 var payId;   
       payId = (payName +salt);
       
       if(document.getElementById(payId).checked == true) {
          var totalValue = document.form1.total_balance_due.value;
          var combinedTotal = document.form1.combined_total_balance_due.value;
                totalValue = parseFloat(totalValue);
                combinedTotal = parseFloat(combinedTotal);
                
                if(obj.checked) { 
                   totalValue = totalValue + lateFee;
                   totalValue = totalValue.toFixed(2);
                   document.form1.total_balance_due.value = totalValue;
                   //combinedTotal = combinedTotal + lateFee;
                   //combinedTotal = combinedTotal.toFixed(2);
                   //document.form1.combined_total_balance_due = combinedTotal;
                   }else{
                   totalValue = totalValue - lateFee;
                   totalValue = totalValue.toFixed(2);
                   document.form1.total_balance_due.value = totalValue;  
                   //combinedTotal = combinedTotal - lateFee;
                  // combinedTotal = combinedTotal.toFixed(2);
                   //document.form1.combined_total_balance_due = combinedTotal;                                      
                   }
             
          }   
   
   
}
//-------------------------------------------------------------------------------------------------------------
function setRejectionDues(obj, salt) {

var objId = obj.id;
var fieldBit =0;
var totalValue = document.form1.total_balance_due.value;
var pastDue = document.form1.past_due_balance.value;
     if(isNaN(totalValue)) {
       totalValue = 0;
       }
     if(totalValue == "") {
       totalValue = 0;
       }
       totalValue =  parseFloat(totalValue);
      
var paymentTotalName = 'rejection_total';
var paymentTotalId = (paymentTotalName +salt);
var rejectionTotal = document.getElementById(paymentTotalId).value;
      rejectionTotal = parseFloat(rejectionTotal);

 if(obj.checked) {
   var fieldBool = true;
   var totalBalanceDue = totalValue + rejectionTotal;
   }else{
   var fieldBool = false; 
   var totalBalanceDue = totalValue - rejectionTotal;
   }
   

 var payDues = document.form1.elements["pay_dues[]"]; 
 var payName = 'pay_dues';
 var payId;
 
 //takes care of multiple rejections so that other section check boxes will not uncheck
 if(payDues.length >1) { 
   for(i=1; i <= payDues.length; i++)  {   
         payId = (payName +i);
         
           if(document.getElementById(payId).checked == true) {
              fieldBit =1;             
              } 
                           if(obj.checked) {
                               if(payId != objId) {
                                  document.getElementById(payId).disabled = false;                   
                                  }    
                               }else{
                                  document.getElementById(payId).disabled = false; 
                               }
        }
   }
  
if(fieldBit == 1) {
  fieldBool = true;
  }
   
// parseDisableFields(fieldBool);
 disableRefundCheckBoxes(fieldBool)
 disableTransferFields(fieldBool);
 disableServiceCredit(fieldBool);
 disableMemberCancel(fieldBool);
 disableMemberHolds(fieldBool);
 disableServiceCancelTwo(fieldBool);
 disableServiceHold(fieldBool);

 
      try{
     document.getElementById('billing_type1').disabled = fieldBool;
     document.getElementById('billing_type2').disabled = fieldBool;
     document.getElementById('billing_type3').disabled = fieldBool; 
     document.getElementById('billing_type4').disabled = fieldBool;
     document.getElementById('update_billing_type').disabled = fieldBool;                      
     }catch(err){}
//alert('fu');
totalBalanceDue22 = totalBalanceDue;
totalBalanceDue = totalBalanceDue.toFixed(2);
document.form1.total_balance_due.value = totalBalanceDue;
pastDue = parseFloat(pastDue);
var combined = totalBalanceDue22 + pastDue;
combined = combined.toFixed(2);
//alert(combined);
document.form1.combined_total_balance_due.value = combined;

}
//-------------------------------------------------------------------------------------------
function updateMonthlyBilling(updateFlag) {

var updateType = updateFlag.value;
var currentBillingType = document.form1.month_billing_type.value;
var disable;

if(updateFlag.checked == true) {
   if(updateType != currentBillingType) {
     alert('Please set the Monthly Billing Type that corresponds with this check box');     
     return false;
     }else{
     document.form1.update_monthly.value = updateType;
     document.form1.ach_pay.value = "";
     document.form1.credit_pay.value = "";
     document.form1.check_pay.value = "";
     document.form1.cash_pay.value = "";
     document.form1.ach_pay.disabled = true;
     document.form1.credit_pay.disabled = true;
     document.form1.check_pay.disabled = true;
     document.form1.cash_pay.disabled = true;   
     document.getElementById('update_billing_type').value = updateType;
     disable = true;     
     parseDisableFields(disable);  
     disableRefundCheckBoxes(disable);     
     }

  }else{
     document.form1.update_monthly.value = "";
     document.getElementById('billing_type1').checked = false;
     document.getElementById('billing_type2').checked = false;   
     document.getElementById('billing_type3').checked = false;   
     document.getElementById('billing_type4').checked = false;    
     document.form1.ach_pay.value = "";
     document.form1.credit_pay.value = "";
     document.form1.check_pay.value = "";
     document.form1.cash_pay.value = "";
     document.form1.ach_pay.disabled = false;
     document.form1.credit_pay.disabled = false;
     document.form1.check_pay.disabled = false;
     document.form1.cash_pay.disabled = false;    
     document.getElementById('update_billing_type').value = "";
     disable = false;     
     parseDisableFields(disable); 
     disableRefundCheckBoxes(disable);
  }

}
//-----------------------------------------------------------------------------------------------------------
//disables options if a service has been placed on hold
function checkServiceHold() {

    var elem = document.getElementById('hold1').checked;
    
if (typeof elem !== 'undefined' && elem !== null){
    if(document.getElementById('hold1').checked == true) {
        
        var t = true

            try{        
            document.getElementById("billing_type1").disabled = true;
            document.getElementById("billing_type2").disabled = true;
            document.getElementById("billing_type3").disabled = true;
            document.getElementById("billing_type4").disabled = true;
            }catch(err){}

            try{   
            disableRefunds(t);
            }catch(err){}
 
            disableMemberHolds(t);  
            disableServiceCredit(t);
            disableMemberCancel(t);

      }
}
     

}
//------------------------------------------------------------------------------------------------------------
function checkRefunds(obj) {

if(document.getElementById('refund_balance').value == '0.00') {
  alert('Please select a service or member to refund');
          return false;
  }
  
}
//------------------------------------------------------------------------------------------------------------
function deleteRejectionDues(obj, count, contractKey, historyKey, userId) {

var ajaxSwitch = 3;
 
 var response =  confirm('This will delete this fee from this account. Do you wish to continue?');
                            if(!response) {         
                               return false;
                              }     

  var parameters = "";
  parameters = parameters+'ajax_switch='+ajaxSwitch;
  parameters = parameters+'&contract_key3='+contractKey;
  parameters = parameters+'&history_key='+historyKey;



//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }
 
xmlHttp.open("POST", "updateAccountInfo.php", false);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(parameters);


              successKey =  xmlHttp.responseText; 
   
               if(successKey != 1) {
                 alert('There was an error deleting this Fee: \n'  +successKey);  
                          return false;
                } 
   
               if(successKey == 1) {  
                  alert('This Fee was successfully deleted! The page will be reloaded.');  
                  window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";       
                 }  
  
}
//------------------------------------------------------------------------------------------------------------


//------------------------------------------------------------------------------------------------------------
function changeMonthlyPayment(contractKey, userId) {

var ajaxSwitch = 4;
   
var newValue = document.form1.month.value;
   
 var response =  confirm('This will change the monthly payment for this account to '+newValue+'. Do you wish to continue?');
                            if(!response) { 
                                window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";      
                               return false;
                              }     

  var parameters = "";
  parameters = parameters+'ajax_switch='+ajaxSwitch;
  parameters = parameters+'&contract_key3='+contractKey;
  parameters = parameters+'&newValue='+newValue;



//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }
 
xmlHttp.open("POST", "updateAccountInfo.php", false);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", parameters.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(parameters);


              successKey =  xmlHttp.responseText; 
   
               if(successKey != 1) {
                 alert('There was an error saving the new payment value: \n'  +successKey);  
                          return false;
                } 
   
               if(successKey == 1) {  
                  alert('This new payment value was saved successfully! The page will be reloaded.');  
                  window.location = "accountInformation.php?contract_key=" + contractKey + "&user_id=" + userId + "";       
                 }  
  
}
//------------------------------------------------------------------------------------------------------------

