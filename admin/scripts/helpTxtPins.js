function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This allows you to set a PIN number to over ride the default contract fees and service prices within your contract forms. The PIN must be four charachters in length and can only contain numbers";                      
   return helpText;  
break;
case 2:
   helpText = "This allows you to set your Merchant ID for your CyberSource payment gateway account.  If you are unsure of your Merchant ID please contact CyberSource in order to setup or obtain your ID.  The merchant ID is effectively the name of your account, and it should be a memorable string of letters, numbers, or underscores (_) that will represent your company.   Try not to use a merchant ID that is longer than 20 characters.";                      
   return helpText;  
break;
case 3:
   helpText = "This option allows you to switch from test mode to live mode when processing financial transactions. When set to \"Test Mode\", all transactions will be sent to the payment gateway but they will not be processed.";                      
   return helpText;  
break;
case 4:
   helpText = "Use this to set your User Name when accessing your settlement transactions. If you do not know your User Name, please refer to your Cybersource account in order to retrieve your User Name";                      
   return helpText;  
break;
case 5:
   helpText = "Use this to set your Password when accessing your settlement transactions. If you do not know your Password, please refer to your Cybersource account in order to retrieve your Password";                      
   return helpText;  
break;
case 6:
   helpText = "This option allows you to switch from test mode to live mode when accessing your settled transactions. When set to \"Test Mode\", all transactions will not be official.";                      
   return helpText;  
break;
}

}
