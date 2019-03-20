function newMemberForm() {

//check to see if a contract id has been generated
if(document.form1.contract_bit.value != "") {
  alert('WARNING!  This Contract has not been submitted. To submit this Contract please use the "Step 2 Submit Order" button below.  If you wish to cancel this order,  please use the "Cancel Contract" button at the bottom of this page to start over.');
  document.form1.cancel_contract.focus();
  return false; 
  }else{
  window.location = "salesForm.php";
  }

}