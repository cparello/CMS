function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Search by the employee first and last name.  You may also use partial names.  For example if you want to search for \"John Smith\" you can type in \"J Smit\" You can also search by the employee last name.";                      
   return helpText;    
break;
case 2:
   helpText = "Enter the employee ID number as it appears below the bar code on the employee ID Card";                      
   return helpText;  
break;
}

}
