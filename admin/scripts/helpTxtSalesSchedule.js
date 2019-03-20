function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This allows you to set the start time for your daily sales schedule.";                      
   return helpText;  
break;
case 2:
   helpText = "This allows you to set the end time for your daily sales schedule. If your facility is operating on split shifts this will designate the end of the first shift.";                      
   return helpText;  
break;
case 3:
   helpText = "This allows you to set the start time for your second shift on your daily sales schedule. If facility is operating on split shifts this will designate the start of the second shift.";                      
   return helpText;  
break;
case 4:
   helpText = "This allows you to set the end time for your second shift on your daily sales schedule. If facility is operating on split shifts this will designate the end of the second shift.";                      
   return helpText;  
break;
}

}
