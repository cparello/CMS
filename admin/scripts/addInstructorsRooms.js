$(document).ready(function() {
//----------------------------------------------------------------
$("#button1").click( function() {

var scheduleType = $("#schedule_type").val();
var instructorRoom = $("#instructor_room").val();
var typeName = "";


if(scheduleType == "") {
  alert('Please select a \"Schedule Category\"');
          $("#schedule_type").focus();
             return false;
 }

if(instructorRoom == "") {
  alert('Please select \"Instructor\" or \"Class Room\"');
          $("#instructor_room").focus();
             return false;
 }


$("#schedule_type > option").each(function() {
     if(this.selected == true) {
        typeName = this.text;   
        $("#type_name").val(typeName);
        }     
  });




});
//---------------------------------------------------------------
$("#instructor_room").change( function() {

var instructorRoom = $("#instructor_room").val();

switch(instructorRoom) {
case "I":
  $("#button1").val('Add Instructor');
  break;
case "R":
  $("#button1").val('Add Class Room');
  break;
default:
  $("#button1").val('Add');
}



});
//---------------------------------------------------------------
});