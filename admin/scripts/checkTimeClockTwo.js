function checkData()  {
//this checks to see if any of the check boxes have been checked before submitting
 sel = -1;

 if (typeof document.form2.elements['update[]'].length != 'undefined') {

       for (i=0; i< document.form2.elements['update[]'].length; i++) {
             if (document.form2.elements['update[]'][i].checked) { 
                 sel = i;
               }
            }
}else{

       if (document.form2.elements['update[]'].checked) { 
           sel = 1;
           }
} 
 //============================================================
  
  if (sel == -1)  {
      alert("Please select a Timeclock to Update");
      return false;
     }
      return true;


}
//-----------------------------------------------------------------------------------------------------
function clockDateCompare(clockInDate, clockOutDate) {

var dateArrayIn = clockInDate.split( '/' );
var dateArrayOut = clockOutDate.split( '/' );

var clockDateInMonth = dateArrayIn[0];
var clockDateInDay = dateArrayIn[1];
var clockDateInYear = dateArrayIn[2];
var clockDateOutMonth = dateArrayOut[0];
var clockDateOutDay = dateArrayOut[1];
var clockDateOutYear = dateArrayOut[2];

clockInDate = (clockDateInYear+ '/' +clockDateInMonth+ '/' +clockDateInDay);
clockOutDate = (clockDateOutYear+ '/' +clockDateOutMonth+ '/' +clockDateOutDay);

var inDateCompare = new Date(clockInDate);
var outDateCompare = new Date(clockOutDate);

//if the date is less than the in date then we return fase
if(outDateCompare < inDateCompare) {
  alert('The Clock Out date that you entered is less than the Clock In date');
  return false;
   }


}
//----------------------------------------------------------------------------------------------------------
function checkDayMonth(month, day) {

switch(month)  {
case '01':
 if(day > 31) {
 return false;
 }
break;
case '02':
if(day > 29) {
return false;
}
break;
case '03':
if(day > 31) {
return false;
}
break;
case '04':
if(day > 30) {
return false;
}
break;  
case '05':
if(day >31) {
return false;
}
break;  
case '06':
if(day > 30) {
return false;
}
break;  
case '07':
if(day > 31) {
return false;
}
break; 
case '08':
if(day > 31) {
return false;
}
break; 
case '09':
if(day > 30) {
return false;
}
break; 
case '10':
if(day > 31) {
return false;
}
break;  
case '11':
if(day >30) {
return false;
}
break;  
case '12':
if(day > 31) {
return false;
}
break;  
}


}
//--------------------------------------------------------------------------------------------------------------
function checkDateFormat(dateValue)  {


var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dateValue)) {
   alert('You have entered an invalid Date format. Please use \"mm/dd/yyyy\" ');
   return false;
   }else{
     var dateArray = dateValue.split( '/' );
      if(dateArray[0] > 12) {
        alert('You have entered an invalid month');
        return false;
        }
        
      if(dateArray[1] > 31) {
         alert('The day of the month you entered exceeds the number of days in the month');
         return false; 
        }else{
               var boon = checkDayMonth(dateArray[0], dateArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');                                 
                                   return false;                                                                   
                                  }       
        }
      
              
   }

}
//---------------------------------------------------------------------------------------------------------------
function checkTimeFormat(clockTime) {

var regexObj =/^(\d{2}):(\d{2})$/; 

    if(!regexObj.test(clockTime)) {
        alert('You have entered an invalid time format.');
         return false;
       }else{
       
       var timeArray = clockTime.split( ':' );
       var timeHour = timeArray[0];
       var timeMinutes = timeArray[1];
             timeHour = parseInt(timeHour);
             timeMinutes = parseInt(timeMinutes);
             
             if(timeHour > 24) {
               alert('You have entered an invalid Hour.');
               return false;
               }
               
             if(timeMinutes > 59) {
               alert('You have entered an invalid number of minutes.');
               return false;
               }  
       
       }



}
//---------------------------------------------------------------------------------------------------------------
function changeColor(obj, r1, col, salt, clockDate) {

var clockInDateId = ('clock_in_date' +salt);
var clockInTimeId = ('clock_in_time' +salt);
var clockOutDateId = ('clock_out_date' +salt);
var clockOutTimeId = ('clock_out_time' +salt);

var clockInDate = document.getElementById(clockInDateId).value;
var clockInTime = document.getElementById(clockInTimeId).value;
var clockOutDate = document.getElementById(clockOutDateId).value;
var clockOutTime = document.getElementById(clockOutTimeId).value;

//make sure all of the fileds are filled out
if(clockInDate == "") {
   alert('Please enter a Clock In Date');
         document.getElementById(clockInDateId).focus();           
         return false;
         }
if(clockInTime == "") {
   alert('Please enter a Clock In Time');
         document.getElementById(clockInTimeId).focus();           
         return false;
         }
if(clockOutDate == "") {
   alert('Please enter a Clock Out Date');
         document.getElementById(clockOutDateId).focus();           
         return false;
         }
if(clockOutTime == "") {
   alert('Please enter a Clock Out Time');
         document.getElementById(clockOutTimeId).focus();           
         return false;
         }

//make sure the date format is correct
var inDateBool = checkDateFormat(clockInDate);
      if(inDateBool == false) {
         document.getElementById(clockInDateId).focus();
         return false;
         }
var outDateBool = checkDateFormat(clockOutDate);
      if(outDateBool == false) {
         document.getElementById(clockOutDateId).focus();
         return false;
         }
         
//This checks to make sure the Timeclock date is the same as the clock in date       
if(clockInDate != clockDate) {
  alert('Incorrect Clock In Date. Clock In date must be equal to the Timeclock Date.');
         document.getElementById(clockInDateId).focus();           
         return false;
          }
//this is to comapare the out date so that it is not less than the clock in date          
var outBoolCompare = clockDateCompare(clockInDate, clockOutDate);
      if(outBoolCompare == false) {
         document.getElementById(clockOutDateId).focus();
         return false;
         }

//now we check the format of the time entries
var outTimeBool = checkTimeFormat(clockOutTime);
      if(outTimeBool == false) {
         document.getElementById(clockOutTimeId).focus();
         return false;
         }
var inTimeBool = checkTimeFormat(clockInTime);
      if(inTimeBool == false) {
         document.getElementById(clockInTimeId).focus();
         return false;
         }

//once the formats are verified then we set the fields to read only         
if(obj.checked == true) {
  document.getElementById(clockInDateId).readOnly = true;
  document.getElementById(clockInTimeId).readOnly = true;
  document.getElementById(clockOutDateId).readOnly = true;
  document.getElementById(clockOutTimeId).readOnly = true;
  }else{
  document.getElementById(clockInDateId).readOnly = false;
  document.getElementById(clockInTimeId).readOnly = false;
  document.getElementById(clockOutDateId).readOnly = false;
  document.getElementById(clockOutTimeId).readOnly = false;  
  }
         
//this toggles the color of the row
var highlightColor = '#99CCFF';
var x=document.getElementById(r1);
x.style.backgroundColor = (obj.checked) ? highlightColor : col;


}
