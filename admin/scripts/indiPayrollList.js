function checkSelection(obj, col, rowId) {

var selectValueArray = obj.value.split("|");
var selectValue = selectValueArray[0];


if(typeof document.form1.elements['view[]'].length != 'undefined') {

      for (i=0; i< document.form1.elements['view[]'].length; i++) {
             if(document.form1.elements['view[]'][i].checked) { 
                
                var loopValueArray = document.form1.elements['view[]'][i].value.split("|");
                var loopValue = loopValueArray[0];
                      if(selectValue != loopValue) {
                         alert('The employee you selected does not match your other selection(s)');
                                 return false;
                         }
                               
                }
           }
    }

//this toggles the color of the row
var highlightColor = '#99CC99';
var x=document.getElementById(rowId);
x.style.backgroundColor = (obj.checked) ? highlightColor : col;

}
//----------------------------------------------------------------------------------------------------
function checkData()  {
//this checks to see if any of the check boxes have been checked before submitting
 sel = -1;

 if (typeof document.form1.elements['view[]'].length != 'undefined') {

       for (i=0; i< document.form1.elements['view[]'].length; i++) {
             if (document.form1.elements['view[]'][i].checked) { 
                 sel = i;
               }
            }
}else{

       if (document.form1.elements['view[]'].checked) { 
           sel = 1;
           }
} 
 //============================================================
  
  if (sel == -1)  {
      alert("Please select an employee to process");
      return false;
     }
      return true;


}