function checkData(theForm) {

var roomName = theForm.room_name.value;
var roomField = theForm.room_name;


if(roomName == "") {
  alert('Please enter the name of the room you wish to edit.');
             roomField.focus();
             return false;
 }
 

}
//-------------------------------------------------------------------------------------------
function confirmDelete(theForm)  {

    var roomName = theForm.room_name.value;
    var answer = confirm('Are you sure that you wish to delete the room '+roomName+ ' ?');
     if (!answer) {
       return false;
      }
}


