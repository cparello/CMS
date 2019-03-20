function checkData(theForm) {

var instructorName = theForm.instructor_name.value;
var instructorField = theForm.instructor_name;
var instructorDescription = theForm.instructor_description.value;


if(instructorName == "") {
  alert('Please enter the name of the instructor you wish to edit. \"Instructor Description\" and \"Upload Photo\" fields are optional');
             instructorField.focus();
             return false;
 }
 
if(instructorDescription != "") {
   var govenor = 1000;
   var descLength =  instructorDescription.length;
   
         if(descLength > govenor) {
            alert('The number of characters you have entered for the \"Instructor Description\" is '+descLength+'. This exceeds the maximum number of characters for this description which is '+govenor);
            return false;
           }
           
  }


}
//-------------------------------------------------------------------------------------------
function confirmDelete(theForm)  {

    var instructorName = theForm.instructor_name.value;
    var answer = confirm('Are you sure that you wish to delete the Instructor '+instructorName+ ' ?');
     if (!answer) {
       return false;
      }
}


