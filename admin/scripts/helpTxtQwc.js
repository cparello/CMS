function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Create a User Name using letters and/ or numbers between seven and ten charachters long. This User Name will be used to access your payroll data";                      
   return helpText;    
break;
case 2:
   helpText = "Once you have created your connection file, Use this to save this file on your computer. Use your QuickBooks&#0174; Web Connector program to access this file in order to retreive your payroll record(s)";                      
   return helpText;  
break;
case 3:
   helpText = "If you currently have \"Payroll Services\" set up in Quickbooks&#0174 housing existing employee data, select \"Yes\" from the drop down menu below. If you do not have Quickbooks&#0174 set up to accept employee data, select \"No\"";                      
   return helpText;  
break;
case 4:
   helpText = "Create a Password using letters and/ or numbers between seven and ten charachters long. This Password will be used to access your payroll data";                      
   return helpText;  
break;
}

}
