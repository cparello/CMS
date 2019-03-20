<?php
function loadServiceAdjustment() {

//first we make sure that this is a monthly service, then we charge the client accordingly for the current monthly service if applicable
if($this->monthlyDues != 0) {

   $this->loadMonthlyPayment();
   $this->loadStartDate();
   $this->loadHoldDate();
   $this->loadBillingDay();
   
   //here we get the dates, convert to secs then 
   $service_start_date = strtotime($this->startDate);
   $service_hold_date = strtotime($this->holdDate);
   $service_end_date = strtotime($this->endDate);
   $signup_date = strtotime($this->signupDate);
   $hold_date = strtotime($this->holdDate);
   $todays_date = time();
   
   //subtract to get the time difference of the amount of seconds used from the start of the contract until the hold was implemented
   $service_term_to_hold_date = $service_hold_date - $service_start_date;

   //now we get the number of seconds until the end of the contract
   $hold_date_to_end_date = $service_end_date - $service_hold_date;
   
   //now check to see if the hold date is within the same month as the release date and if a payment has been received.  First we check to see if the hold is within the prorate month at the begining of the signup before the first service month of the contract startts
   $signup_month_year = date("Y.m", $signup_date);
   $today_month_year = date("Y.m", $todays_date);
   $start_month_year = date("Y.m", $service_start_date);
   
   if($signup_month_year == $today_month_year) {
     $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
     $this->updateMonthlyPayments();   
     }
   
   //here we check to see if this is the first month of service based on the service start date and todays date.  Then we check the hold day to see if it is greater or less than the billing day. If it is greater than the billing day we do not charge the account since they have already paid for it.  If it is before the billing day then we charge the account based on the number of days until the end of the month
   $hold_day = date("j", $hold_date);
   
    if($start_month_year == $today_month_year) {
    
           if($hold_day < $this->monthlyBillingDay) {
              $this->loadMonthProRate();              
              }   
        $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
        $this->updateMonthlyPayments();     
        }
        
   //this checks to see if this is a month to month service "one month".  If it is, it prorates or does not prorate based on the hold release day.  This also filters out the possibility of a double charge if it is beyond the first month of the service as stated above
    if($this->numberMonths == 1) {
       if($start_month_year != $today_month_year) {
       
            if($hold_day < $this->monthlyBillingDay) {
                $this->loadMonthProRate();              
               }   
           $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
           $this->updateMonthlyPayments();
         }    
      }
                       
   //finally we look for term monthly memberships that are more than one month in duration.  We use  the  number of seconds from the start date to the hold date and the number of seconds from the hold date to the end date of the service to create new start and end dates.
   if($this->numberMonths > 1)  {
       if(($start_month_year != $today_month_year)  &&  ($signup_month_year != $today_month_year)) {
       
          $new_start_date = $todays_date - $service_term_to_hold_date;
          $new_end_date =  $todays_date + $hold_date_to_end_date;
          $new_start_date_day = date("j", $new_start_date);
          
          //here we need to determine if the start date day is closer to the begining of the month or the end. If it is in the middle we move up to the next month value and create the new start and end dates  
          //fif the new start day is les than fifteen we push back the new start 'day back to the first day of that month
          if($new_start_date_day < 15) {
             $year_month = date("Y-m", $new_start_date);
             $this->newStartDate = "$year_month-01";
             $newEndDateSecs =  strtotime(date("Y-m-d", strtotime($this->newStartDate)) . "+$this->numberMonths month"); 
             $this->newEndDate = date("Y-m-d", $newEndDateSecs);
             
           //if the new start day is greater than fifteen we push the start date up to the new start date to the first of the next month
             }else{
             $year_month = date("Y-m", $new_start_date);
             $this->newStartDate = "$year_month-01";
             $newStartDateSecs = strtotime(date("Y-m-d", strtotime($this->newStartDate)) . "+1 month");
             $this->newStartDate = date("Y-m-d", $newStartDateSecs);
             $newEndDateSecs =  strtotime(date("Y-m-d", strtotime($this->newStartDate)) . "+$this->numberMonths month"); 
             $this->newEndDate = date("Y-m-d", $newEndDateSecs);             
             }
          
          
          
            if($hold_day < $this->monthlyBillingDay) {
                $this->loadMonthProRate();              
               }         
               
           $this->monthlyDues = $this->monthlyPayment + $this->monthlyDues;
           $this->updateMonthlyPayments();       
          }   
     }
                     
   
   

}



}

?>