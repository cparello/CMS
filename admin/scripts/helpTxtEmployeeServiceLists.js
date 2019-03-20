function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "Use the drop down menus to select a unique commission structure for this employee.  Select \"Percent\" if you wish to assign a percentage of the corresponding  \"Service Term\" or \"Flat Fee\" for a fixed dollar amount.<br>If you select \"Percent\", type in the numerical value in the form field next to the drop drop menu.  For instance type in the number \"6\" for six percent.<br>If you select \"Flat Fee\", type in the dollar amount.  For example: \"19.95\".";                      
   return helpText;    
break;
case 2:
   helpText = "Write a brief description of the Emlpoyee Type.";                      
   return helpText;  
break;
}

}