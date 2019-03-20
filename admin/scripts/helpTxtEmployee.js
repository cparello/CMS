function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "The Username must be in the form of an email address. For example: John@anysite.com";                      
   return helpText;    
break;
case 2:
   helpText = "The password must be a minimum of six charachters in length and no longer than nine charachters. It must also contain at least one digit. For example:  johnp4";                      
   return helpText;  
break;
case  3:
   helpText = "Select the available service types for this employee from the menu on the left.  If you wish to select more than one service, hold down the control key on your keyboard and simultaniously select multiple selections from this menu with your mouse";                      
   return helpText;  
break;
case  4:
   helpText = "Check this box if you wish to delete this Employee Type from this Employee's profile. This will reset the form fields to their original values and allow you to enter  a new employee description. This does not effect employee information or other Job Descriptions for this employee";                      
   return helpText;  
break;
case  5:
   helpText = "Search by the employee first and last name.  You may also use partial names.  For example if you want to search for \"John Smith\" you can type in \"J Smit\" ";                      
   return helpText;  
break;
}

}
