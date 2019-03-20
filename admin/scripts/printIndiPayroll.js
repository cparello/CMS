function openPrintIndiWindow() {

window.open('indiPrintForm.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');

}
//-----------------------------------------------------------------------------------------------
function printIndiPayroll() {

this.employeeName = document.getElementById('employee_name').value;
this.userId = document.getElementById('user_id').value;

var commissionArray = document.getElementById('commission_total_array').value;



var commissionTotalArray = commissionArray.split("|");

var salaryArray = document.getElementById('salary_wage_array').value;
var salaryTotalArray = salaryArray.split("|");

var hourlyArray = document.getElementById('hourly_wages_array').value;
var hourlyWagesArray = hourlyArray.split("|");

var projectedArray = document.getElementById('hours_projected_array').value;
var hoursProjectedArray = projectedArray.split("|");

var hoursArray = document.getElementById('total_hours_array').value;
var totalHoursArray = hoursArray.split("|");

var subArray = document.getElementById('sub_total_array').value;
var subTotalArray = subArray.split("|");

var idArray = document.getElementById('id_card_array').value;
var idCardArray = idArray.split("|");



var typeKeys = document.getElementById('type_key_array').value;
var typeKeyArray = typeKeys.split("|");
var typeKeyLength = typeKeyArray.length - 1;


var groupMarker = 1;
var typeKey = "";
var commission = "";
var salary = "";
var hourlyWages = "";
var hoursProjected = "";
var totalHours = null;
var subTotal = "";
var idCard = null;

var radioNameOne = 'da1';
var recursiveOne = 'rec1';
var amountOne = 'amount1';
var descriptionOne = 'desc1';
var groupOneArray = "";

var radioNameTwo = 'da2';
var recursiveTwo = 'rec2';
var amountTwo = 'amount2';
var descriptionTwo = 'desc2';

var radioNameThree = 'da3';
var recursiveThree = 'rec3';
var amountThree = 'amount3';
var descriptionThree = 'desc3';

var radioNameFour = 'da4';
var recursiveFour = 'rec4';
var amountFour = 'amount4';
var descriptionFour = 'desc4';

this.detailsArray = "";

checkRecursiveThree();

if(typeKeyLength >1) {
            
  for(var i = 0; i < typeKeyLength; i++) {
        
        typeKey = typeKeyArray[i];
        commission = commissionTotalArray[i];
        salary = salaryTotalArray[i];
        hourlyWages = hourlyWagesArray[i];
        hoursProjected = hoursProjectedArray[i];
        totalHours = totalHoursArray[i];
        subTotal = subTotalArray[i];
        idCard = idCardArray[i];
        
        var radioGroupOne = (radioNameOne+groupMarker);
        var radioCheckOne = checkSelection(radioGroupOne);     
        
        var recursiveCheckOne = (recursiveOne+groupMarker);      
        var recursiveResultOne = checkRecursive(recursiveCheckOne);
        
        var amountFieldOne = (amountOne+groupMarker);
        var amountValueOne = getAddSubAmount(amountFieldOne);
        
        var descriptionFieldOne = (descriptionOne+groupMarker);
        var descriptionValueOne = getAddSubDescription(descriptionFieldOne);
        
        var checkBoolOne = checkGroupFields(descriptionValueOne, amountValueOne, recursiveResultOne);
                                   if(checkBoolOne == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions One\"  as recursive');
                                              return false;
                                     }
    

        var radioGroupTwo = (radioNameTwo+groupMarker);
        var radioCheckTwo = checkSelection(radioGroupTwo);     
        
        var recursiveCheckTwo = (recursiveTwo+groupMarker);      
        var recursiveResultTwo = checkRecursive(recursiveCheckTwo);
        
        var amountFieldTwo = (amountTwo+groupMarker);
        var amountValueTwo = getAddSubAmount(amountFieldTwo);
        
        var descriptionFieldTwo = (descriptionTwo+groupMarker);
        var descriptionValueTwo = getAddSubDescription(descriptionFieldTwo);
        
        var checkBoolTwo = checkGroupFields(descriptionValueTwo, amountValueTwo, recursiveResultTwo);
                                   if(checkBoolTwo == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Two\"  as recursive');
                                              return false;
                                     }


        var radioGroupThree = (radioNameThree+groupMarker);
        var radioCheckThree = checkSelection(radioGroupThree);     
        
        var recursiveCheckThree = (recursiveThree+groupMarker);      
        var recursiveResultThree = checkRecursive(recursiveCheckThree);
        
        var amountFieldThree = (amountThree+groupMarker);
        var amountValueThree = getAddSubAmount(amountFieldThree);
        
        var descriptionFieldThree = (descriptionThree+groupMarker);
        var descriptionValueThree = getAddSubDescription(descriptionFieldThree);
        
        var checkBoolThree = checkGroupFields(descriptionValueThree, amountValueThree, recursiveResultThree);
                                   if(checkBoolThree == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Three\"  as recursive');
                                              return false;
                                     }


        var radioGroupFour = (radioNameFour+groupMarker);
        var radioCheckFour = checkSelection(radioGroupFour);     
        
        var recursiveCheckFour = (recursiveFour+groupMarker);      
        var recursiveResultFour = checkRecursive(recursiveCheckFour);
        
        var amountFieldFour = (amountFour+groupMarker);
        var amountValueFour = getAddSubAmount(amountFieldFour);
        
        var descriptionFieldFour = (descriptionFour+groupMarker);
        var descriptionValueFour = getAddSubDescription(descriptionFieldFour);
        
        var checkBoolFour = checkGroupFields(descriptionValueFour, amountValueFour, recursiveResultFour);
                                   if(checkBoolFour == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Four\"  as recursive');
                                              return false;
                                     }
  
           groupMarker++;
           
          detailsArray += (userId+ '|' +typeKey+ '|' +radioCheckOne+ '|' +amountValueOne+ '|' +descriptionValueOne+ '|' +recursiveResultOne+ '|' +radioCheckTwo+ '|' +amountValueTwo+ '|' +descriptionValueTwo+ '|' +recursiveResultTwo+ '|' +radioCheckThree+ '|' +amountValueThree+ '|' +descriptionValueThree+ '|' +recursiveResultThree+ '|' +radioCheckFour+ '|' +amountValueFour+ '|' +descriptionValueFour+ '|' +recursiveResultFour+ '|' +commission+ '|' +salary+ '|' +hourlyWages+ '|' +hoursProjected+ '|' +totalHours+ '|' +subTotal+ '|' +idCard+ '|' +employeeName+ '@');
           
       }  //end for loop 
      
     
      
    //below is for a single employee job type  
    //#################################################################################
       }else{
       
          typeKey = typeKeyArray[0];
          commission = commissionTotalArray[0];
          salary = salaryTotalArray[0];
          hourlyWages = hourlyWagesArray[0];
          hoursProjected = hoursProjectedArray[0];
          totalHours = totalHoursArray[0];
          subTotal = subTotalArray[0];
          idCard = idCardArray[0];
          
          groupMarker = 1;
 
        var radioGroupOne = (radioNameOne+groupMarker);
        var radioCheckOne = checkSelection(radioGroupOne);     
        
        var recursiveCheckOne = (recursiveOne+groupMarker);      
        var recursiveResultOne = checkRecursive(recursiveCheckOne);
        
        var amountFieldOne = (amountOne+groupMarker);
        var amountValueOne = getAddSubAmount(amountFieldOne);
        
        var descriptionFieldOne = (descriptionOne+groupMarker);
        var descriptionValueOne = getAddSubDescription(descriptionFieldOne);
        
        var checkBoolOne = checkGroupFields(descriptionValueOne, amountValueOne, recursiveResultOne);
                                   if(checkBoolOne == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions One\"  as recursive');
                                              return false;
                                     } 
 
 
        var radioGroupTwo = (radioNameTwo+groupMarker);
        var radioCheckTwo = checkSelection(radioGroupTwo);     
        
        var recursiveCheckTwo = (recursiveTwo+groupMarker);      
        var recursiveResultTwo = checkRecursive(recursiveCheckTwo);
        
        var amountFieldTwo = (amountTwo+groupMarker);
        var amountValueTwo = getAddSubAmount(amountFieldTwo);
        
        var descriptionFieldTwo = (descriptionTwo+groupMarker);
        var descriptionValueTwo = getAddSubDescription(descriptionFieldTwo);
        
        var checkBoolTwo = checkGroupFields(descriptionValueTwo, amountValueTwo, recursiveResultTwo);
                                   if(checkBoolTwo == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Two\"  as recursive');
                                              return false;
                                     } 
 
 
        var radioGroupThree = (radioNameThree+groupMarker);
        var radioCheckThree = checkSelection(radioGroupThree);     
        
        var recursiveCheckThree = (recursiveThree+groupMarker);      
        var recursiveResultThree = checkRecursive(recursiveCheckThree);
        
        var amountFieldThree = (amountThree+groupMarker);
        var amountValueThree = getAddSubAmount(amountFieldThree);
        
        var descriptionFieldThree = (descriptionThree+groupMarker);
        var descriptionValueThree = getAddSubDescription(descriptionFieldThree);
        
        var checkBoolThree = checkGroupFields(descriptionValueThree, amountValueThree, recursiveResultThree);
                                   if(checkBoolThree == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Three\"  as recursive');
                                              return false;
                                     }
                                     
                                     
        var radioGroupFour = (radioNameFour+groupMarker);
        var radioCheckFour = checkSelection(radioGroupFour);     
        
        var recursiveCheckFour = (recursiveFour+groupMarker);      
        var recursiveResultFour = checkRecursive(recursiveCheckFour);
        
        var amountFieldFour = (amountFour+groupMarker);
        var amountValueFour = getAddSubAmount(amountFieldFour);
        
        var descriptionFieldFour = (descriptionFour+groupMarker);
        var descriptionValueFour = getAddSubDescription(descriptionFieldFour);
        
        var checkBoolFour = checkGroupFields(descriptionValueFour, amountValueFour, recursiveResultFour);
                                   if(checkBoolFour == false) {
                                      alert('Please fill out both the description and amount fields if you wish to save \"Employee Deductions and Additions Four\"  as recursive');
                                              return false;
                                     }       
                                     
           detailsArray += (userId+ '|' +typeKey+ '|' +radioCheckOne+ '|' +amountValueOne+ '|' +descriptionValueOne+ '|' +recursiveResultOne+ '|' +radioCheckTwo+ '|' +amountValueTwo+ '|' +descriptionValueTwo+ '|' +recursiveResultTwo+ '|' +radioCheckThree+ '|' +amountValueThree+ '|' +descriptionValueThree+ '|' +recursiveResultThree+ '|' +radioCheckFour+ '|' +amountValueFour+ '|' +descriptionValueFour+ '|' +recursiveResultFour+ '|' +commission+ '|' +salary+ '|' +hourlyWages+ '|' +hoursProjected+ '|' +totalHours+ '|' +subTotal+ '|' +idCard+ '|' +employeeName+ '@'); 
           
       
       }//end else
       
       loadIndiDetails();
       
}       
//------------------------------------------------------------------------------------------
function loadIndiDetails() {
var hoursList = document.getElementById('hours_list').value;   
var ptHtml = document.getElementById('pt_html').value; 
var ptHtmlTA = document.getElementById('pt_html_ta').value;   
var ot1 = document.getElementById('ot_array').value;   
var ot2 = document.getElementById('ot_doubtime_array').value; 
var commissReturns = document.getElementById('commission_returns').value; 
var salesHtml = document.getElementById('sales_html').value; 
//alert(ptHtml);
var parameters = "";
parameters = parameters+'details_array='+detailsArray;
parameters = parameters+'&hours_list='+hoursList;
parameters = parameters+'&pt_html='+ptHtml;
parameters = parameters+'&pt_html_ta='+ptHtmlTA;
parameters = parameters+'&ot1='+ot1;
parameters = parameters+'&ot2='+ot2;
parameters = parameters+'&commissReturns='+commissReturns;
parameters = parameters+'&salesHtml='+salesHtml;
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "viewIndiDetails.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var details =  xmlHttp.responseText; 
                         if(details == 1) {
                            setTimeout('openPrintIndiWindow()', 500);
                            }else{
                            alert(details);
                            }
                       
             }
}
//========================================


}



