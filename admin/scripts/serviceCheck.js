function send_id()  {

var txt1=document.getElementById("error1");
var txt2=document.getElementById("error2");
var txt3=document.getElementById("error3");
var txt4=document.getElementById("error4");
var txt5=document.getElementById("error5");

var serviceName1a = document.form1.service_type.value;
var serviceName1b = document.form1.service_type;

var groupType1a = document.form1.group_type.value;
var groupType1b = document.form1.group_type;

var serviceLocation1a = document.form1.service_location.value;
var serviceLocation1b = document.form1.service_location;

var serviceQuantity1a = document.form1.service_quantity1.value;
var serviceQuantity1b = document.form1.service_quantity1;

var duration1a = document.form1.duration1.value;
var duration1b = document.form1.duration1;

var serviceCost1a = document.form1.service_cost1.value;
var serviceCost1b = document.form1.service_cost1;

var commissionType1a = document.form1.commission_type1.value;
var commissionType1b = document.form1.commission_type1;

var  commissionAmount1a = document.form1.commission_amount1.value;
var  commissionAmount1b = document.form1.commission_amount1;

//here are for the other qauntitties
var serviceQuantity2a = document.form1.service_quantity2.value;
var serviceQuantity2b = document.form1.service_quantity2;

var duration2a = document.form1.duration2.value;
var duration2b = document.form1.duration2;

var serviceCost2a = document.form1.service_cost2.value;
var serviceCost2b = document.form1.service_cost2;

var commissionType2a = document.form1.commission_type2.value;
var commissionType2b = document.form1.commission_type2;

var  commissionAmount2a = document.form1.commission_amount2.value;
var  commissionAmount2b = document.form1.commission_amount2;


var serviceQuantity3a = document.form1.service_quantity3.value;
var serviceQuantity3b = document.form1.service_quantity3;

var duration3a = document.form1.duration3.value;
var duration3b = document.form1.duration3;

var serviceCost3a = document.form1.service_cost3.value;
var serviceCost3b = document.form1.service_cost3;

var commissionType3a = document.form1.commission_type3.value;
var commissionType3b = document.form1.commission_type3;

var  commissionAmount3a = document.form1.commission_amount3.value;
var  commissionAmount3b = document.form1.commission_amount3;


var serviceQuantity4a = document.form1.service_quantity4.value;
var serviceQuantity4b = document.form1.service_quantity4;

var duration4a = document.form1.duration4.value;
var duration4b = document.form1.duration4;

var serviceCost4a = document.form1.service_cost4.value;
var serviceCost4b = document.form1.service_cost4;

var commissionType4a = document.form1.commission_type4.value;
var commissionType4b = document.form1.commission_type4;

var  commissionAmount4a = document.form1.commission_amount4.value;
var  commissionAmount4b = document.form1.commission_amount4;

//get rid of white space
var x = commissionAmount1a;
commissionAmount1a = (x.replace(/^\W+/,'')).replace(/\W+$/,'');

//check to see if service name is filled out
   if(serviceName1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Supply a Service Name</span>';
          serviceName1b.focus();                          
          return false;
         }      

  if(serviceLocation1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Select a Service Location</span>';
          serviceLocation1b.focus();                          
          return false;
         }      


//make sure a service group is selected
  if(groupType1a == "")  {
          txt1.innerHTML= '<span class="errors">Please Select a Group Type</span>';
          groupType1b.focus();                          
          return false;
         }      

//check to see that at least one service quantity is filled out
if(serviceQuantity1a == "") {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Please Input a Service Quantity</span>';
          serviceQuantity1b.focus();                          
          return false;
         }

//make sure it is a number
if(isNaN(serviceQuantity1a)) {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Service Qauntity must be a Number</span>';
          serviceQuantity1b.focus();                         
          return false;
}

      
if(duration1a == "") {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Please Select a Service Duration</span>';
          duration1b.focus();                          
          return false;
         }

if(serviceCost1a == "") {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Please Input a Service Cost</span>';
          serviceCost1b.focus();                          
          return false;
         }

if(isNaN(serviceCost1a)) {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Service Cost must be a Number</span>';
          serviceCost1b.focus();                         
          return false;
}

if(commissionType1a != "" &&  commissionAmount1a == "") {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Please enter a Commission Amount</span>';
          commissionAmount1b.focus();                         
          return false;
}else if(commissionType1a == "" &&  commissionAmount1a != "") {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Please select a Commission Type</span>';
          commissionType1b.focus();                         
          return false;
}

//check to see if it is s anumber
if(commissionAmount1a != "") {
     if(isNaN(commissionAmount1a)) {
          txt1.innerHTML="";
          txt2.innerHTML= '<span class="errors">Commission Amount must be a Number</span>';
          commissionAmount1b.focus();                         
          return false;
       }
  }
//-------------------------------------------------------------------------------------------------------------------------------
//if the the form is filled out with at least one service them check if anything else is filled
if(serviceQuantity1a != "" &&  duration1a != "" &&  serviceCost1a !="")  {


//trim the white space from the input fields
var a = serviceQuantity2a;
var b = serviceQuantity3a;
var c = serviceQuantity4a;

var d = commissionAmount2a;
var e = commissionAmount3a;
var  f = commissionAmount2a;

commissionAmount2a = (d.replace(/^\W+/,'')).replace(/\W+$/,'');
commissionAmount3a = (e.replace(/^\W+/,'')).replace(/\W+$/,'');
commissionAmount3a = (f.replace(/^\W+/,'')).replace(/\W+$/,'');

serviceQuantity2a = (a.replace(/^\W+/,'')).replace(/\W+$/,'');
serviceQuantity3a = (b.replace(/^\W+/,'')).replace(/\W+$/,'');
serviceQuantity4a = (c.replace(/^\W+/,'')).replace(/\W+$/,'');


//sub check for seconadary services for service terms 2
if(serviceQuantity2a != "") {

      //make sure it is a number
       if(isNaN(serviceQuantity2a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";          
          txt3.innerHTML= '<span class="errors">Service Qauntity must be a Number</span>';
          serviceQuantity2b.focus();                         
          return false;
        }
        
   if(duration2a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Please Select a Service Duration</span>';
          duration2b.focus();                          
          return false;
         }

if(serviceCost2a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Please Input a Service Cost</span>';
          serviceCost2b.focus();                          
          return false;
         }

if(isNaN(serviceCost2a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Service Cost must be a Number</span>';
          serviceCost2b.focus();                         
          return false;
       }
     
  if(commissionType2a != "" &&  commissionAmount2a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Please enter a Commission Amount</span>';
          commissionAmount2b.focus();                         
          return false;
     }else if(commissionType2a == "" &&  commissionAmount2a != "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Please select a Commission Type</span>';
          commissionType2b.focus();                         
          return false;
     }   
     
//check to see if it is s anumber
if(commissionAmount2a != "") {
     if(isNaN(commissionAmount2a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML= '<span class="errors">Commission Amount must be a Number</span>';
          commissionAmount2b.focus();                         
          return false;
       }
  }     
     
     
     
    }//end quantity2
    
    
    
//-----------------------------------------------------------------------------------------------------------------------------------    
    
//sub check for seconadary services for service terms 3
if(serviceQuantity3a != "") {

      //make sure it is a number
       if(isNaN(serviceQuantity3a)) {
          txt1.innerHTML="";
          txt2.innerHTML=""; 
          txt3.innerHTML="";           
          txt4.innerHTML= '<span class="errors">Service Qauntity must be a Number</span>';
          serviceQuantity3b.focus();                         
          return false;
        }
        
   if(duration3a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";           
          txt4.innerHTML= '<span class="errors">Please Select a Service Duration</span>';
          duration3b.focus();                          
          return false;
         }

if(serviceCost3a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";           
          txt4.innerHTML= '<span class="errors">Please Input a Service Cost</span>';
          serviceCost3b.focus();                          
          return false;
         }

if(isNaN(serviceCost3a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";           
          txt4.innerHTML= '<span class="errors">Service Cost must be a Number</span>';
          serviceCost3b.focus();                         
          return false;
       }
       
   if(commissionType3a != "" &&  commissionAmount3a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML= '<span class="errors">Please enter a Commission Amount</span>';
          commissionAmount3b.focus();                         
          return false;
     }else if(commissionType3a == "" &&  commissionAmount3a != "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML= '<span class="errors">Please select a Commission Type</span>';
          commissionType3b.focus();                         
          return false;
     }         
//check to see if it is s anumber
if(commissionAmount3a != "") {
     if(isNaN(commissionAmount3a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";          
          txt4.innerHTML= '<span class="errors">Commission Amount must be a Number</span>';
          commissionAmount3b.focus();                         
          return false;
       }
  }         
       
     
    }//end quantity3
    
//--------------------------------------------------------------------------------------------------------------------------
//sub check for seconadary services for service terms 4
if(serviceQuantity4a != "") {

      //make sure it is a number
       if(isNaN(serviceQuantity4a)) {
          txt1.innerHTML="";
          txt2.innerHTML=""; 
          txt3.innerHTML="";  
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Service Qauntity must be a Number</span>';
          serviceQuantity4b.focus();                         
          return false;
        }
        
   if(duration4a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Please Select a Service Duration</span>';
          duration4b.focus();                          
          return false;
         }

if(serviceCost4a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Please Input a Service Cost</span>';
          serviceCost4b.focus();                          
          return false;
         }

if(isNaN(serviceCost4a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML=""; 
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Service Cost must be a Number</span>';
          serviceCost4b.focus();                         
          return false;
       }
       
      if(commissionType4a != "" &&  commissionAmount4a == "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Please enter a Commission Amount</span>';
          commissionAmount4b.focus();                         
          return false;
     }else if(commissionType4a == "" &&  commissionAmount4a != "") {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";
          txt4.innerHTML="";  
          txt5.innerHTML= '<span class="errors">Please select a Commission Type</span>';
          commissionType4b.focus();                         
          return false;
     }             
//check to see if it is s anumber
if(commissionAmount4a != "") {
     if(isNaN(commissionAmount4a)) {
          txt1.innerHTML="";
          txt2.innerHTML="";
          txt3.innerHTML="";  
          txt4.innerHTML="";           
          txt5.innerHTML= '<span class="errors">Commission Amount must be a Number</span>';
          commissionAmount4b.focus();                         
          return false;
       }
  }                
      
     
    }//end quantity4
    
    
}//end if intiial service is filled out


//set up the acess limit 
//------------------------------------------------------------------------------------------------
function setAccessLimits(access)  {

var pat ="";    
var total = "" ; 
var count = 0;

for (var i = 0 ; i < document.form1[access].length ; i++) {
    if (document.form1[access][i].checked == true) {
       total = "1";
       count++;
       }else{
       total = "0";       
       }
       
 pat += total;   
}

return pat;

}
//----------------------------------------------------------------------------------------------
var accessOne = setAccessLimits('access_day1');
var accessTwo = setAccessLimits('access_day2');
var accessThree = setAccessLimits('access_day3');
var accessFour = setAccessLimits('access_day4');

document.form1.access1.value = accessOne;
document.form1.access2.value = accessTwo;
document.form1.access3.value = accessThree;
document.form1.access4.value = accessFour;

}
//----------------------------------------------------------------------------------------------------

function checkServiceDuration(durationValue, durationId)  {

var duration1a = document.form1.duration1.value;
var duration2a = document.form1.duration2.value;
var duration3a = document.form1.duration2.value;
var duration4a = document.form1.duration2.value;

                                                                                                                                                                                      

switch(durationId) {
case "duration1":
var serviceDuration = new Array(duration2a, duration3a, duration4a);
  break;
case "duration2":
var serviceDuration = new Array(duration1a, duration3a, duration4a);
  break;
case "duration3":
var serviceDuration = new Array(duration1a, duration2a, duration4a);
  break;
case "duration4":
var serviceDuration = new Array(duration1a, duration2a, duration3a);
  break;
}


for(var i=0; i < serviceDuration.length;  i++)  {

    if(durationValue == 'M')  {
    
     if(serviceDuration[i] != 'M' && serviceDuration[i] != "") {
             
                     alert('Monthly Duration can only be combined with other monthly durations');
                     document.getElementById(durationId).options[0].selected = true;
                     return false; 
                      
          }
    }
   
   
   
     if(durationValue != 'M') {
        
       if(serviceDuration[i] == 'M' && serviceDuration[i] != "")  {
     
                  alert('Monthly Duration can only be combined with other monthly durations');
                  document.getElementById(durationId).options[0].selected = true;
                  return false;     
         }    
    }



}

}
//----------------------------------------------------------------------------------------------------

function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}