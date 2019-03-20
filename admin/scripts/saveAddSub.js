function checkSelection(radioName) {

var addSubType;

if(document.form1.elements[radioName][0].checked == true) {
   addSubType = 'S'
  }else if(document.form1.elements[radioName][1].checked == true) {
   addSubType = 'A';
  }else{
   addSubType = 'E';
  }

return addSubType;

}
//-----------------------------------------------------------------------------------------------
function  checkRecursive(checkBox) {

var saveRec;

if(document.form1.elements[checkBox].checked == true) {
   saveRec = 'Y';
   }else{
   saveRec = 'N';
   }

return saveRec;

}
//-----------------------------------------------------------------------------------------------
function getAddSubAmount(fieldId) {

var addSubAmount = document.getElementById(fieldId).value;

       if(addSubAmount == "") {
          addSubAmount = "";
          }

return addSubAmount;
}
//-----------------------------------------------------------------------------------------------
function getAddSubDescription(fieldId) {

var addSubDescription = document.getElementById(fieldId).value;

      if(addSubDescription == "") {
         addSubDescription = "";
         }

return addSubDescription;
}
//-----------------------------------------------------------------------------------------------
function checkGroupFields(descriptionValue, amountValue, recursiveResult) {

      if(recursiveResult == 'Y') {
            
            if(descriptionValue == "") {
               return false;
               }
            if(amountValue == "") {
               return false;
               }
              
         }else{
           return true;
         }
             
}
//------------------------------------------------------------------------------------------------
function saveAddSub() {

this.employeeName = document.getElementById('employee_name').value;
this.userId = document.getElementById('user_id').value;
var typeKeys = document.getElementById('type_key_array').value;
      typeKeyArray = typeKeys.split("|");
var typeKeyLength = typeKeyArray.length - 1;


var groupMarker = 1;
var typeKey = "";

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

this.employeeAddSubArray = "";

//checks to see if there are recursions set
var recursiveBool = checkRecursiveTwo();
      if(recursiveBool == false) {
         return false;
         }


if(typeKeyLength >1) {
            
  for(var i = 0; i < typeKeyLength; i++) {
        
        typeKey = typeKeyArray[i];
        
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
           
          employeeAddSubArray += (userId+ '|' +typeKey+ '|' +radioCheckOne+ '|' +amountValueOne+ '|' +descriptionValueOne+ '|' +recursiveResultOne+ '|' +radioCheckTwo+ '|' +amountValueTwo+ '|' +descriptionValueTwo+ '|' +recursiveResultTwo+ '|' +radioCheckThree+ '|' +amountValueThree+ '|' +descriptionValueThree+ '|' +recursiveResultThree+ '|' +radioCheckFour+ '|' +amountValueFour+ '|' +descriptionValueFour+ '|' +recursiveResultFour+ '@');
           
       }  //end for loop 
      
     
      
    //below is for a single employee job type  
    //#################################################################################
       }else{
       
          typeKey = typeKeyArray[0];
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
                                     
           employeeAddSubArray += (userId+ '|' +typeKey+ '|' +radioCheckOne+ '|' +amountValueOne+ '|' +descriptionValueOne+ '|' +recursiveResultOne+ '|' +radioCheckTwo+ '|' +amountValueTwo+ '|' +descriptionValueTwo+ '|' +recursiveResultTwo+ '|' +radioCheckThree+ '|' +amountValueThree+ '|' +descriptionValueThree+ '|' +recursiveResultThree+ '|' +radioCheckFour+ '|' +amountValueFour+ '|' +descriptionValueFour+ '|' +recursiveResultFour+ '@'); 
           
       
       }//end else
       
 var r = confirm('This will save recursive deductions and additions for this employee. Do you wish to continue?');                                
         if(r == true) {
            saveToAjax();
           }else{
            return false;
           }             
       
        
}
//---------------------------------------------------------------------------------------------------------------------------
function checkRecursiveTwo() {

var recursiveCheck = document.getElementsByClassName('recur');
var compare = 0;

for(var i = 0; i < recursiveCheck.length; i++) {
      if(recursiveCheck[i].checked != true) {
         compare++;             
        }
     }
   
    if(compare == i) {
      alert('Please select an addition or deduction as recursive before submitting this form');
              return false;
      }else{
              return true;
      }

}
//----------------------------------------------------------------------------------------------------------------------------
function saveToAjax() {

userId = encodeURIComponent(userId);
employeeAddSubArray = encodeURIComponent(employeeAddSubArray);

var parameters = "";
parameters = parameters+'user_id='+userId;
parameters = parameters+'&employee_add_sub_array='+employeeAddSubArray;


//get ajax request object  and send the params to the form object
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
xmlHttp.open("POST", "saveAddSum.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var resp = xmlHttp.responseText;
                                       if(resp == 1) {
                                         alert('Additions and Deductions for \"' +employeeName+ '\" successfully saved');                                       
                                         }else{
                                         alert(resp);
                                         }
             }
} 


}









