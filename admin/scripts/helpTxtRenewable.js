function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who are eligible for Early Renewal rates as set up in the 'Contract Tools' section.";                      
   return helpText;    
break;
case 2:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who's memberships have expired but are still eleigible to rejoin at thier original price point. This Grace Period can be setup in the 'Contract Tools' section";                      
   return helpText;  
break;
case 3:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who are up for renewal from today's date to thirty days prior to the expiration date on their contract";                      
   return helpText;  
break;
case 4:
   helpText = "This will set the date on the invoices that the invoices will be good until.";                      
   return helpText;  
break;
}

}