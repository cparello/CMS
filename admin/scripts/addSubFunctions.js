function setTextColor(obj, salt, amountField)  {

    if(obj.checked == true) {
     
        var addSubSwitch = obj.value;
        var amountFieldId = (amountField+salt);
        
              if(addSubSwitch == 'd') {
                 document.getElementById(amountFieldId).style.color = "#FF9933";
                 }
              if(addSubSwitch == 'a') {
                 document.getElementById(amountFieldId).style.color = "#339900";
                 }
        }

}
//-------------------------------------------------------------------------------------------------------------------
function setPreAddSubs() {

var total = document.getElementById('totalMarker').value;
      total = parseFloat(total);
var elements = document.getElementsByClassName('val');
var radioSub = document.getElementsByClassName('sub');
var radioAdd = document.getElementsByClassName('add');

for(var i = 0; i < elements.length; ++i){

      if(elements[i].value != "") {
           if(radioSub[i].checked == true) {
              elements[i].style.color = "#FF9933";
              total -= parseFloat(elements[i].value);
              }
           if(radioAdd[i].checked == true) {
             elements[i].style.color = "#339900";
              total += parseFloat(elements[i].value);
             }
         }

     }
  total = total.toFixed(2);
  document.form1.total.value = total;

}
//-------------------------------------------------------------------------------------------------------------------
function switchAddSum(radioName, className, fieldID)  {

var total = document.getElementById('totalMarker').value;
      total = parseFloat(total);
var elements = document.getElementsByClassName(className);
var radioSub = document.getElementsByClassName('sub');
var radioAdd = document.getElementsByClassName('add');

if(document.getElementById(fieldID).value != "") {

     for(var i = 0; i < elements.length; ++i){
              
        if(elements[i].value != "") {
           if(radioSub[i].checked == true) {
              total -= parseFloat(elements[i].value);
              }
           if(radioAdd[i].checked == true) {
              total += parseFloat(elements[i].value);
             }
         }
                          
     }    
                             
   total = total.toFixed(2);             
   document.form1.total.value = total;
 }
}
//--------------------------------------------------------------------------------------------------------------------
function adjustTotal(obj, radioName, className)  {

var total = document.getElementById('totalMarker').value;
      total = parseFloat(total);
var elements = document.getElementsByClassName(className);
var radioSub = document.getElementsByClassName('sub');
var radioAdd = document.getElementsByClassName('add');

//first make sure that a radio is selected
if(document.form1.elements[radioName][0].checked != true && document.form1.elements[radioName][1].checked != true) {
   alert('Please select a \"Deduction\" or an \"Addition\" before filling out this amount.');
           obj.value = "";
           return false;
  }

for(var i = 0; i < elements.length; ++i){

      if(elements[i].value != "") {
           if(radioSub[i].checked == true) {
              total -= parseFloat(elements[i].value);
              }
           if(radioAdd[i].checked == true) {
              total += parseFloat(elements[i].value);
             }
         }

     }


  total = total.toFixed(2);
  document.form1.total.value = total;
  
}
//--------------------------------------------------------------------------------------------------------------------
function checkFields() {

var elements = document.getElementsByClassName('val');
var radioSub = document.getElementsByClassName('sub');
var radioAdd = document.getElementsByClassName('add');
var descField = document.getElementsByClassName('desc');

for(var i = 0; i < elements.length; ++i) {

      if(elements[i].value != "") {
           if(radioSub[i].checked == true || radioAdd[i].checked == true) {
                 if(descField[i].value == "") {
                    alert('Please fill out the \"Description Field\"');
                            descField[i].focus();
                            return false;
                    }                 
              }         
         }

     }
     
     
     //call the ad sub parse     
    $addSubBool = parseAddSub();
    if($addSubBool == false) {
       return false;
       }
    
        
}
//--------------------------------------------------------------------------------------------------------------------
function checkHours() {

var hours = document.getElementById('total_hours_array').value;
var hoursArray = hours.split("|");
var hoursLength = hoursArray.length - 1;
var numHours;
var totalHours = 0;

if(hoursLength > 1) {
    for(var i = 0; i < hoursLength; i++) {
                    
            numHours = hoursArray[i];
         if(isNaN(numHours)) {
             numHours = 0;
            }    
            totalHours += numHours;                        
       }
       
   }else{
     totalHours = hoursArray[0];
       if(totalHours == "") {
          totalHours = 0;
         }
    }

      if(totalHours == 0) {
          alert('There are no time clock records hours for this employee. The payroll for this employee cannot be processed.');
          return false;
        }       
                                  
                 
  }
  //----------------------------------------------------------------------------------------------------------------------
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
function parseAddSub() {

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

checkRecursiveThree();

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
       

    document.getElementById('add_deduct_array').value =  employeeAddSubArray; 
    
     var r = confirm('This will process the payroll for this employee. Do you wish to continue?');                                
         if(r == true) {
            document.form1.submit();
           }else{
            return false;
           }      
        
}
//---------------------------------------------------------------------------------------------------------------------------
function checkRecursiveThree() {

var recursiveCheck = document.getElementsByClassName('recur');
var compare = 0;

for(var i = 0; i < recursiveCheck.length; i++) {
      if(recursiveCheck[i].checked != true) {
         compare++;             
        }
     }
   
    if(compare == i) {
       document.getElementById('save_add_sub').value = 'N';
      }else{
       document.getElementById('save_add_sub').value = 'Y';
      }

}
//----------------------------------------------------------------------------------------------------------------------------










