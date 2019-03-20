function setMonthlySummaryDivs() {

var monthlyPayment;
var originalMonthlyAmount;
var endDate = document.form1.month_exp_date.value;


var durationPattern = /\d+/;
var numberOfMonths;
      numberOfMonths = durationPattern.exec(serviceD);
      numberOfMonths = parseInt(numberOfMonths);     

//divide by the number of months and save to the monthly paymet field
monthlyPayment = serviceC / numberOfMonths;
monthlyPayment = monthlyPayment.toFixed(2);

//this sets the original amount for multiplying members
originalMonthlyAmount = serviceAdjustOriginal / numberOfMonths;
originalMonthlyAmount = originalMonthlyAmount.toFixed(2);

/*
this.serviceD = serviceDuration;
this.summaryRowId = idNum;
this.serviceT = serviceType;
this.serviceK = serviceKey;
this.serviceC = serviceCost;
*/

//get ajax request object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//-------------------------------------------------------
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="proRate2.php";
url=url+"?end_date="+endDate;
url=url+"&monthly_amount="+monthlyPayment;
url=url+"&current_number_months="+numberOfMonths;
url=url+"&original_monthly_amount="+originalMonthlyAmount;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                     
                     var proRatePayment = xmlHttp.responseText;                    
                     var fieldAmountArray = proRatePayment.split("|");     //this sets up a separate format for the field variable                 
                     var fieldAmount = fieldAmountArray[0];    
                     var totalProrate = fieldAmountArray[1];
                     var prorateMonths = fieldAmountArray[2];
                     var staticTotalProRate = fieldAmountArray[3];
                //  alert(totalProrate);
                     var monthPattern = /Month/g;
                     var monthPatternResult = monthPattern.test(serviceD);

                    if(monthPatternResult == true) {
                       var proMonthField = renGroup.replace("_type", "");
                       
                        // alert(staticTotalProRate);
                       
                       
                         document.getElementsByName(proMonthField).item(2).value = staticTotalProRate;  
                                            
                             
                                 //set the summary div if prorate is more than zero    
                                if(totalProrate != '0.00')  {
                          
                                   document.getElementById(summaryRowId).innerHTML =  ('<table width="100%" cellpadding="1" cellspacing="0" align="left"><tr><td class="green" width="50%">' + serviceT +  '<span class="white"> '+ serviceK +'</span></td><td class="green"align="left">' +prorateMonths+ '  Month(s)</td><td class="green" align="right">' + totalProrate + ' </td><tr></table>');
                                   
                                  serviceC = totalProrate;
                                  
                                                    
                                  }else{
                                   document.getElementById(summaryRowId).innerHTML =  ('<table width="100%" cellpadding="1" cellspacing="0" align="left"><tr><td class="green" width="50%">' + serviceT +  '<span class="white"> '+ serviceK +'</span></td><td class="green"align="left">' +numberOfMonths+ '  Month(s)</td><td class="green" align="right">' + serviceC + ' </td><tr></table>');
                                  
                                   
                                  
                                  }
                                                                
                                                         
                          }
                               

                               
                     //      if(fieldAmount  == "0.00") {
                     //         fieldAmount = "0.00";                                                          
                     //        }
                             
                            //set the field amount
                        //   document.form1.pro_rate_fee.value = fieldAmount;
                           //set the summary amount
                        //   document.getElementById('serve_pro_rate').innerHTML = fieldAmount;
                           
                           //update the total fees in both sumarry and month to month 
                        //   setTotalFeesMonthly();
                                              
                           //setGrandTotal();
//end of complete
} 

//end state change function
}


return false;    



}



