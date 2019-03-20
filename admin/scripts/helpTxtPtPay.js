function get_help_text(ht)   {

switch(ht)   {
case 1:
   helpText = "This field control whether trainers get paid a percentage of the per session sale price or a flat rate";                      
   return helpText;    
break;
case 2:
   helpText = "The percentage of the session cost a trainer will get paid. \"example 40 percent is .40\"";                      
   return helpText;    
break;
case 3:
   helpText = "The standard rate Trainers will get paid per hour.";                      
   return helpText;    
break;
case 4:
   helpText = "The standard rate Trainers will get paid per 1/2 hour."                      
   return helpText;    
break;
case 5:
   helpText = "This will activate the PT bonus structure. If a trainer hits a certain threshold they get a per hour bonus that you choose.  EXAMPLE if it is set at 30 and the bonus is at 1, 30 x 1 = $30 extra trainer gets paid. There are three separate teirs that can be setup.";                           
   return helpText;    
break;
case 6:
   helpText = "This will setup the first Tier in the PT bonus structure. If a trainer hits this many or more sessions during the pay period they get a per hour bonus that you setup.";                           
   return helpText;    
break;
case 7:
   helpText = "This will setup the first Tier bonus that the Trainer will get if they hit the first tier session Total.";                           
   return helpText;    
break;
case 8:
   helpText = "This will setup the second Tier in the PT bonus structure. If a trainer hits this many or more sessions during the pay period they get a per hour bonus that you setup.";                           
   return helpText;    
break;
case 9:
   helpText = "This will setup the second Tier bonus that the Trainer will get if they hit the second tier session Total.";                           
   return helpText;    
break;
case 10:
   helpText = "This will setup the third Tier in the PT bonus structure. If a trainer hits this many or more sessions during the pay period they get a per hour bonus that you setup.";                           
   return helpText;    
break;
case 11:
   helpText = "This will setup the third Tier bonus that the Trainer will get if they hit the third tier session Total.";                           
   return helpText;    
break;
case 12:
   helpText = "Set the number of Training Assesments a member is given.";                           
   return helpText;    
break;
case 13:
   helpText = "Set this to yes in order to pay trainers for assesments.";                           
   return helpText;    
break;
case 14:
   helpText = "This will setup the amount the trainers will be paid for an assesment.";                           
   return helpText;    
break;
case 15:
   helpText = "This will turn on reminders for PT sessions and Training Assesments.";                           
   return helpText;    
break;
case 16:
   helpText = "This will setup the time in hours before an Apointment that a trainer and client will recieve an alert about an upcoming session.";       
   return helpText;    
break;


}

}
