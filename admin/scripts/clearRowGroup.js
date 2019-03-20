function clearRowGroup(buttonGroup,servCost,sumNum) {


                   var j = 1;
                   var prevRenValue = document.form1.elements[servCost][j].value;               
                         prevRenValue = parseMemNumber(prevRenValue);
                         if(prevRenValue == "NA") {
                          prevRenValue = 0;
                         }else if (prevRenValue == "") {
                          prevRenValue = 0;
                          }
           
                   


var rad = document.form1.elements[buttonGroup];
// take out the radio buttons
 if (rad[0]) {
           for (var i=0; i< rad.length; i++) {
                if (rad[i].checked) {           
                    rad[i].checked = false;
                  }
               }
}else{
      if (rad.checked) { 
      rad.checked = false;
      } 
   }


 //erase the form feild 
var payField = document.form1.elements[servCost];     //put this back into the function braket once I figur th other bullshit out
if (payField[0]) {
          for (var i=0; i< payField.length; i++) {
                if (payField[i].value != "NA") {           
                   payField[i].value = "";
                   }
              }
 }else{
     if (payField.value) { 
        payField.value = "";
       } 
   }
   
               //clears out the summary fields
               if(sumNum != 0) {   
                             
                   //this patern the price number that we use to subtract from a previous service total
                    var pat = /\d+\.\d{2}/;
                   
                  //get existing elements. paturn is to determine if it is not a prepaid service
                   var searchString = document.getElementById(sumNum).innerHTML;
                   var servicePattern = /Month/g;
                   var currentTable= document.getElementById(sumNum);
                   var tagHousing = currentTable.getElementsByTagName('td');
                   var currentProductType = tagHousing[1].innerHTML;
                         servicePatternResult = servicePattern.test(currentProductType);
                         //this parses the group type for the monthly payment function
                           var groupPattern = /[A-Z]/;
                           this.groupTypePayments = groupPattern.exec(sumNum);
                   
                   var prevCost =pat.exec(searchString);
                   if(prevCost != null) { 
                      subtractServiceFees(prevCost);
                      subtractRenewalFees(prevRenValue);
                      }
                 document.getElementById(sumNum).innerHTML="";
                 //delete the monthly sum
                 monthyPayments();
                }
   
   
   
   
   
   
   
 } // Ends clear row group" function



//------------------------------------------------------------------------------------------------------------------------------------------------
function parseFields(stringLength, groupType)   {
 var stringNumber;
 var stringBracket;
 var sumNum = 0;
 var prevRenValue;
 var renField;
 var j = 1;
                   
for (var i=1; i <= stringLength; i++) {
        stringNumber = groupType.replace(/\d+/, i);
        stringBracket = groupType.replace("[]", "");
        stringBracket = stringBracket.replace("_type", "");
        stringBracket = stringBracket.replace(/\d+/, i); 
        
        renField = groupType.replace("_type", "");
        renField = renField.replace(/\d+/, i); 
        prevRenValue = document.form1.elements[renField][j].value;

                 if(prevRenValue != "") {        
                      if(prevRenValue != "NA") {   
                          prevRenValue = parseMemNumber(prevRenValue);
                          subtractRenewalFees(prevRenValue);  
                         }
                  }
                  
clearRowGroup(stringNumber,stringBracket,sumNum);
}

}
//----------------------------------------------------------------------------------------------------------------------------------------------
function deleteSummaryDivs(length, initial) {

for(i=1; i <= length; i++) {
                   var sumId = i + initial;
                    //this patern the price number that we use to subtract from a previous service total
                    var pat = /\d+\.\d{2}/;
                    //get existing elements
                    var searchString = document.getElementById(sumId).innerHTML;

            
                 if(searchString != "")  {
                 var servicePattern = /Month/g;
                 var currentTable= document.getElementById(sumId);
                 var tagHousing = currentTable.getElementsByTagName('td');
                 var currentProductType = tagHousing[1].innerHTML;
                 servicePatternResult = servicePattern.test(currentProductType);
                }   
                   

                   
                   var prevCost =pat.exec(searchString);
                   if(prevCost != null) {
                      subtractServiceFees(prevCost);                      
                      }                  
                   
                   
                   
                   document.getElementById(sumId).innerHTML="";
                   }

}
//-----------------------------------------------------------------------------------------------------------------------------------------------
function deleteOthers(field)  {

//get the row length of the lists to do the loops
var singleLength  = document.form1.single_rows.value;
var familyLength  = document.form1.family_rows.value;
var businessLength  = document.form1.business_rows.value;
var organizationLength  = document.form1.organization_rows.value;
var singleString;
var familyString;
var businessString;
var organizationString;
var singleInitial = 'S';
var familyInitial = 'F';
var businessInitial = 'B';
var organizationInitial = 'O';

var pat1=/S/g;
var resultSingle =pat1.test(field);

var pat2 =/F/g;
var resultFamily =pat2.test(field);

var pat3 =/B/g;
var resultBusiness =pat3.test(field);

var pat4 =/O/g;
var resultOrganization =pat4.test(field);

if(resultSingle == true) {
  familyString= field.replace("S", "F");
  businessString = field.replace("S", "B");
  organizationString = field.replace("S", "O");   
  parseFields(familyLength,familyString);     
  parseFields(businessLength,businessString);    
  parseFields(organizationLength,organizationString);    
  
  deleteSummaryDivs(familyLength,familyInitial);
  deleteSummaryDivs(businessLength,businessInitial);
  deleteSummaryDivs(organizationLength,organizationInitial);                 
                                    
}

if(resultFamily == true) {
 singleString = field.replace("F", "S");
 businessString = field.replace("F", "B");
 organizationString = field.replace("F", "O");
 parseFields(singleLength,singleString); 
 parseFields(businessLength,businessString);
 parseFields(organizationLength,organizationString); 
 
 deleteSummaryDivs(singleLength,singleInitial);
 deleteSummaryDivs(businessLength,businessInitial);
 deleteSummaryDivs(organizationLength,organizationInitial); 
}

if(resultBusiness == true) {
 singleString = field.replace("B", "S");
 familyString = field.replace("B", "F");
 organizationString = field.replace("B", "O");
 parseFields(singleLength,singleString); 
 parseFields(familyLength,familyString);
 parseFields(organizationLength,organizationString); 
 
 deleteSummaryDivs(singleLength,singleInitial);
 deleteSummaryDivs(familyLength,familyInitial);
 deleteSummaryDivs(organizationLength,organizationInitial);
}

if(resultOrganization == true) {
 singleString = field.replace("O", "S");
 familyString = field.replace("O", "F");
 businessString = field.replace("O", "B");
 parseFields(singleLength,singleString); 
 parseFields(familyLength,familyString);
 parseFields(businessLength,businessString);
 
 deleteSummaryDivs(singleLength,singleInitial);
 deleteSummaryDivs(businessLength,businessInitial);
 deleteSummaryDivs(familyLength,familyInitial);
}




monthyPayments();

}

//------------------------------------------------------------------------------------------------------------------------------------------

