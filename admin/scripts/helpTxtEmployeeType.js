function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Create a name for an Employee type. For example:  \"Front Desk\" or \"Maintanance\" <br>NOTE:<br>If you wish to create a Sales Associate, this can be achmplished by using the key word \"Sales\" in the title";                      
   return helpText;    
break;
case 2:
   helpText = "Write a brief description of the Emlpoyee Type.";                      
   return helpText;  
break;
case 3:
   helpText = "Select the Service Location you wish to assign this Employee Type.";                      
   return helpText;  
break;
}

}