function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "The \"Club Manager Pro\" point of sale system has five default product categories that you may choose from.  These are comprised of \"Clothing\",  \"Supplements\", \"Food & Beverage\", \"Accessories\" and \"Publications\".  You may also create your own category for a specific product. ";                      
   return helpText;    
break;
case 2:
   helpText = "Use this section to either use an existing \"Bar Code\" or create your own barcode number for a specific product you wish to sell.  Use  the \"Product Description\" field to input the name of your product";                      
   return helpText;  
break;
case 3:
   helpText = "Enter the 'Unit Cost' of your product in the \"Wholesale Cost\"  field and the 'Retail Unit Price' for that product in the \"Retail Cost\" field.  If applicable, set the sales tax percent in the \"Sales Tax\" field.  For example if the sales tax is eight and a half percent, set this value to  \"0.0825\".   Set the total number of items you are selling into the \"Inventory\" field.";                      
   return helpText;  
break;
case 4:
   helpText = "If your desktop computer is hooked up to a  network or local standard printer, choose 'Letter Format'.  If you have a thermal receipt printer choose 'Reciept Format'.";                      
   return helpText;  
break;
}

}
                     
   