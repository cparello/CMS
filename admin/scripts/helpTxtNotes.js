function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Use these fields to set the number of days a note  will be available for viewing before it is automatically deleted.  If a value is set to zero the note will remain available indefinately.";                      
   return helpText;    
break;
case 2:
   helpText = "Select the available an application type from the menu below that you wish to allow the associated application to send notes.  If you wish to select more than one application, hold down the control key on your keyboard and simultaniously select multiple selections from this menu with your mouse";                      
   return helpText;  
break;
}

}
