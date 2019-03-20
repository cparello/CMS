function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This is the lattitude and longitude of the club location. Please search google for the coordinates of your gyms address and copy/past them here.";                      
   return helpText;    
break;
case 2:
   helpText = "This is text used to describe this location.";                      
   return helpText;    
break;
case 3:
   helpText = "This is a list of available ammenities at this location.";                      
   return helpText;    
break;
case 4:
   helpText = "This is the hours of this location. Ex- Monday-Friday 5AM-12PM"                      
   return helpText;    
break;
case 5:
   helpText = "This is the hours of this location. Ex-Sat-Sun 5AM-8PM";                  
   return helpText;    
break;
case 55:
   helpText = "This is the zipcode of your club.";                           
   return helpText;    
break;
case 99:
   helpText = "This is length of the guest pass listed on the website.";                           
   return helpText;    
break;



}

}
