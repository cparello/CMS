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
case 3:
   helpText = "Search by the user last name. You can also search by a partial last name. For example if you wish to search the last name \"Smith\" you can type \"Smit\"";                      
   return helpText;  
break;
}

}
