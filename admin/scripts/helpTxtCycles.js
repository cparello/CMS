function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Use this field to set the day of the month that that your monthly clients will be billed. HINT: Use only days that are common to each month. Numbers 1 through 28 are permissible";                      
   return helpText;    
break;
case 2:
   helpText = "Use this field to set the annual start date where your Monthly members will be billed an Enhancement Fee. Use the followng date format:  \"mm/dd/yyyy\" ";                      
   return helpText;    
break;
case 3:
   helpText = "Use this menu to select the cycle frequency you wish to bill  monthly members an Enhancement Fee.  If  \"Annual\" is selected the billing date will be the same as the date entered in the Cycle Date field. For all other selections, the billing date will correspond to the interval month and day. For example if \"Monthly\" is selected the next billing date will occur on the same day of the following month";                      
   return helpText;    
break;
case 4:
   helpText = "Use this field to set the annual start date where your Monthly members will be billed a Member Guarantee Fee. Use the followng date format:  \"mm/dd/yyyy\"";                       
   return helpText;    
break;
case 5:
   helpText = "Use this menu to select the cycle frequency you wish to bill  monthly members an Member Guarantee Fee.  If  \"Annual\" is selected the billing date will be the same as the date entered in the Cycle Date field. For all other selections, the billing date will correspond to the interval month and day. For example if \"Monthly\" is selected the next billing date will occur on the same day of the following month";                                 
   return helpText;    
break;
case 6:
   helpText = "Use this menu to select the monthly membership term type you wish to apply a Member Guarantee Fee.";                                 
   return helpText;    
break;
case 7:
   helpText = "Use this menu to select the monthly membership term type you wish to apply an Enhancement Fee.";                                 
   return helpText;    
break;
case 8:
   helpText = "Use this menu to select the number of attempts you wish to assign to your recursive monthly billing cycle.";                                 
   return helpText;    
break;
case 9:
   helpText = "Use this menu to select the interval (days) between attempts for your recursive monthly billing cycle.";                                 
   return helpText;    
break;
case 10:
   helpText = "Use this menu to select the number of attempts you wish to assign to your recursive Enhancement Fee billing cycle.";                                 
   return helpText;    
break;
case 11:
   helpText = "Use this menu to select the interval (days) between attempts for your recursive Enhancement Fee billing cycle.";                                 
   return helpText;    
break;
case 12:
   helpText = "Use this menu to select the number of attempts you wish to assign to your recursive Guarantee Fee billing cycle.";                                 
   return helpText;    
break;
case 13:
   helpText = "Use this menu to select the interval (days) between attempts for your recursive Guarantee Fee billing cycle.";                                 
   return helpText;    
break;
case 15:
   helpText = "Use this menu to select which types of memberships you wish to assign a Maintnence Fee to.";                                 
   return helpText;    
break;
case 16:
   helpText = "Use this menu to select when the member will be billed the Maintnence Fee. The fee will be added to their first cycle and then 6 months after their signup date if you Select Bi-Annual.";                                 
   return helpText;    
break;
}

}
