function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Select a location where you wish your prospects to have access.  Create a title for your guest pass.  For example: \"All Access Pass\" or \"Five Free Yoga Classes\"";                      
   return helpText;    
break;
case 2:
   helpText = "Type in the number of \"days(1 to 31)\" that your guest pass will be valid. You may create up to four duration terms. Terms Two through Four are optional ";                      
   return helpText;  
break;
case 3:
   helpText = "Select the available service types for this guest pass below.  If you wish to select more than one service, hold down the control key on your keyboard and simultaniously select multiple selections from this menu with your mouse";                      
   return helpText;  
break;
case 4:
   helpText = "Create a marketing message that will appear on this guest pass. The Marketing Message cannot exceed 100 charachters in length";                      
   return helpText;  
break;
case 5:
   helpText = "Edit title of your guest pass.  For example: \"All Access Pass\" or \"Five Free Yoga Classes\"";                      
   return helpText;    
break;
case 6:
   helpText = "Select the available service types you wish to  this guest pass in the \"Available Services\" list below, press the \"Add Service\" button.  Select the services you wish to remove from the \"Current Services\" list then press the \"Remove Service\" button";                      
   return helpText;  
break;
case 7:
   helpText = "Type in the sender and reply to email addresses you wish to use when generating guest pass emails";                      
   return helpText;  
break;
case 8:
   helpText = "Set the name you wish to have the recipient view when they recieve their guest pass email.  Use the Intro Message field to set the introductory sentence that will appear in the body of the email.  The Intro Message cannot exceed 150 charachters in length";                      
   return helpText;  
break;
}

}
                     
   