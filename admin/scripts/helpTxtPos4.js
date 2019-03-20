function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This allows you to search for a POS history of returned items based on the reciept invoice number";                      
   return helpText;    
break;
case 2:
   helpText = "Use this field to search by the returned items transaction date. Type in m/d/y";                      
   return helpText;  
break;
case 3:
   helpText = "Use this field to search by the barcode of the returned product.";                      
   return helpText;  
break;
case 4:
   helpText = "Use this field to search by the returned category of the POS.";
   return helpText; 
break;
case 5:
   helpText = "Use this field to search by a Date Range ex 1.  m/d/yyyy  2.  m/d/yyyy of when the transaction was returned.";
   return helpText; 
break;
}

}
