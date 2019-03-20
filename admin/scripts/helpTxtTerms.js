function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Use this field to set the contract duration to pay or quit. Most states allow for between 3 to five days for any party who enters into a contract to be able to cancel that contract. Contact your local legal authorities for more information.";                      
   return helpText;    
break;
case 2:
   helpText = "Use this field to set the legal Terms and Conditions for your member contract forms. Cut and paste or type your text into this field.";                      
   return helpText;  
break;
case 3:
   helpText = "Use this field to set the Liability Terms and Conditions for your member contract forms. Cut and paste or type your text into this field.";                      
   return helpText;  
break;
case 4:
   helpText = "Use this field to set the grace period allowed for member renewals. For example if your grace period is thirty days, enter \"30\" into this field.";                      
   return helpText;  
break;
}

}
