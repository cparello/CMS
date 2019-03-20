function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Place your mouse cursor within the first \"Date Range\" field to display a calendar where you may pick a start date for your report. You may alternately type in a start date into this field using the \"mm/dd/yyyy\" format.  Use the second \"Date Range\" in the same manor to pick an end date for your report. You can use your cursor with the backspace button in either of these fields to edit your dates.  Click anywhere outside of the calendars and the \"Date Range\" fields to hide the calendars. If the \"Date Range\" fields are left blank then the report will generate all sales from the first of the year to the current date.";                      
   return helpText;    
break;
case 2:
   helpText = "Use these fields to select dates to create \"Expired Accounts\" reports. If these fields are left blank the default range will be from the first of the year to the current date.  Place your mouse cursor within the first \"Date Range\" field to display a calendar where you may pick a start date for your report. You may alternately type in a start date into this field using the \"mm/dd/yyyy\" format.  Use the second \"Date Range\" in the same manor to pick an end date for your report. You can use your cursor with the backspace button in either of these fields to edit your dates.  Click anywhere outside of the calendars and the \"Date Range\" fields to hide the calendars. If the \"Date Range\" fields are left blank then the report will generate all sales from the first of the year to the current date.";                      
   return helpText;    
break;
}

}
                     
   