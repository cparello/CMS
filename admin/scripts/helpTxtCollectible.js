function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who are past due on their monthly payments.";                      
   return helpText;    
break;
case 2:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who's monthly payments have been rejected do to insuficiant funds and or declined credit card transactions.";                      
   return helpText;  
break;
case 3:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who subscribe to monthly services.";                      
   return helpText;  
break;
case 4:
   helpText = "This will reset the Invoice Attempt number back to the FIRST NOTICE for the mail function.";                      
   return helpText;  
break;
}

}