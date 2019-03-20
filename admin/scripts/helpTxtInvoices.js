function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Use this to set the parameters for your monthly invoices. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Current Monthly Statement\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice";                      
   return helpText;    
break;
case 2:
   helpText = "Use this to set the parameters for your past due invoices. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Payment Past Due\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice. The \"Invoice Attempts\" radio buttons allow you to set how many notices you wish to send your clients before sending a final notice.  Use the \"Invoice Frequency\" drop down menu to select the duration between your invoices that you send to your clients. ";                      
   return helpText;  
break;
case 3:
   helpText = "Use this to set the parameters for clients who have submitted checks or eft transactions resulting in insuficiant funds as well as credit card transactions that have been declined. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Your payment was rejected\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice. The \"Invoice Attempts\" radio buttons allow you to set how many notices you wish to send your clients before sending a final notice.  Use the \"Invoice Frequency\" drop down menu to select the duration between your invoices that you send to your clients.";                      
   return helpText;  
break;
case 4:
   helpText = "Use this to set the parameters for your final notice to clients if when all attempts to email or mail them have beeen exhausted. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Final Notice\".  Use the \"Body Text\" field to add additional text or a description to the body of your invoice"; 
   return helpText;
break;
case 5:
   helpText = "Use this to set the parameters for your Early Renewal Invoices. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Early Renewal Offer\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice"; 
   return helpText;
break;
case 6:
   helpText = "Use this to set the parameters for your Grace Period Invoices. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"You still Have Time to Renew\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice"; 
   return helpText;
case 7:
   helpText = "Use this to set the parameters for your General Invoices. Use the \"Invoice Header\" field to set the title of your invoice. For example: \"Time to Renew your Membership\".  Use the optional \"Body Text\" field to add additional text or a description to the body of your invoice"; 
   return helpText;   
break;
case 8:
   helpText = "Use this to set the parameters for your expired accounts that you wish to re-enroll and promote your current services. Use the \"Invoice Header\" field to set the title of your message.  For example: \"We Want You Back\".   Use the \"Body Text 1\" field to add a paragraph to add descriptive message. Use the optional \"Body Text 2\"  field to add additional information. Use the radio buttons to target clients who have either expired paid in full term services, classes or both"; 
   return helpText;   
break;
case 9:
   helpText = "This allows you to view a phone list, email account holders or print out invoices that you can mail to your account holders who have services that have expired. Use the \"Date Range\" drop down menu to select the timeline you wish to process"; 
   return helpText;   
break;
}

}