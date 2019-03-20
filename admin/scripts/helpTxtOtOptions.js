function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "If your State has a daily overtime rule your employees will get \"time and a half\" for any hours over this value";                      
   return helpText;    
break;
case 2:
   helpText = "If your State has a daily overtime rule your employees will get \"double time\" for any hours over this value";                      
   return helpText;  
break;
case 3:
   helpText = "If your State has a weekly overtime rule your employees will get \"time and a half\" for any hours over this value";                      
   return helpText;  
break;
}

}
