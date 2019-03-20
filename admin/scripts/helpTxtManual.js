function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Type in the account number of the contract holder.  The system will display in real time the contract holder's name and contact information.  Once the account has been verified use the \"View Account\"  check box to show the current payment information.";                      
   return helpText;    
break;
case 2:
   helpText = "Edit the payment amount if needed.  If you are proccessing a check transaction, enter the check number located in the top right corner of the check.  Select either the cash or check radio button. Use the Process Payment button to submit the transaction. ";                      
   return helpText;  
break;
case 3:
   helpText = "This allows you to process intitial payments on a contract where a balance is due and the remaining balance is either a cash or a check payment. If a late fee applies, this will be displayed and can be optionally waived by setting the Late Fee balance to zero.  If you are proccessing a check transaction, enter the check number located in the top right corner of the check.  Select either the cash or check radio button. Use the Process Payment button to submit the transaction.";                      
   return helpText;  
break;
case 4:
   helpText = "This allows you to enter checks that were rejected by your bank for \"Non Suficiant Funds\". Enter the the amount on the rejected check into the Check Amount field and the check number (located in the upper right hand corner of the check) into the Check Number field. If you wish to view the client account upon submitting this record, check the \"View Client Account\" option and you will be re-directed to the records associated with this account. ";                      
   return helpText;  
break;
}

}
