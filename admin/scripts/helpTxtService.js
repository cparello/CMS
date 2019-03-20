function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Create a short name for your service. For example: \"General Gym Membership\"";                      
   return helpText;    
break;
case 2:
   helpText = "Choose the specific location you wish to assign this service. You can also assign this to \"All\" if you wish this to be a universal service if you have mor than one location";                      
   return helpText;  
break;
case 3:
   helpText = "Write a brief description of the service you have created. This is an optional field";                      
   return helpText;  
break;
case 4:
   helpText = "This ties in with the \"Service Duration\" drop down menu below. For instance if your service is a gym membership you may type in the number \"6\" then choose \"Months\" form the drop down menu.  If your service is a class such as \"Yoga\", you can also choose the \"Class(s)\" option.  This would translate to \"6 Classes\".";                      
   return helpText;  
break;
case 5:
   helpText = "Select the duration for the \"Service Quantity\" field above. This can be in the form of Class(s), Days, Weeks, Months or Years";                      
   return helpText;  
break;
case 6:
   helpText = "Assign a cost for this service. For example, if your service is a one week gym membership, you can type in a dollar amount such as \"19.95\".";                      
   return helpText;  
break;
case 7:
   helpText = "This is an optional field that can be edited at anytime. Use this to assign a \"Commission Type\" to your sales staff.  Choose \"Flat Rate\" for a specific dollar amount or \"Percent\" to reflect a percntage of the dollar amount you entered in the \"Service Cost\" field above";                      
   return helpText;  
break;
case 8:
   helpText = "This is an optional field that can be edited at anytime. This allows you to enter a commission amount assigned to your sales staff based on the \"Commission Type\" you selected above. For instance if you selected \"Flat Rate\", type in a dollar amount such as \"20.00\".  If you selected \"Percent\", Type in a number such as \"10\". This would reflect a commission of 10% based on the amount you created in the \"Service Cost\" field above. ";                      
   return helpText;  
break;
case 9:
   helpText = "Search by the name of the service. You can also use a partial name. For example if you are searching for \"General Membership\" you can type in \"Gen\". ";                      
   return helpText;  
break;
case 10:
   helpText = "Assign a \"Group Type\" fpr this service.  For example if \"Single\" is selected  the cost of this service is only for one individual. If Business, Family or Organization is selected this service will be assigned and associated with multiple individuals related to that Famiy, Business or Organization. ";                      
   return helpText;  
break;
case 11:
   helpText = "Use these check boxes to allocate  which day(s) of the week a service is available.  If this is applied to a \"Membership\",  this feature limits access to your club or facility as to the days specified.  If applied to a non-member subscribing to a service, this feature also limits access  to your club or facility based on the days this service is available.  If all check boxes are left unchecked, the \"Access Limit\" is set to unlimited access.";                      
   return helpText;  
break;
case 12:
   helpText = "This sets up a master class for bundle arrays used with your scheduler system. When this service name uses the name sake of a particular bundle array and the value is set to \"Yes\", this service will be used to sell additional classes ";                      
   return helpText;  
break;
}

}
