$(document).ready(function() {
//----------------------------------------------------------------
$("#button1").click( function() {

var scheduleType = $("#schedule_type").val();
var bundleType = $("#bundle_type").val();


if(scheduleType == "") {
  alert('Please select a \"Schedule Category\"');
          $("#schedule_type").focus();
             return false;
 }

if(bundleType == "") {
  alert('Please select a Schedule Name');
          $("#bundleType").focus();
             return false;
 }


var bundleName = $("#bundle_type option:selected").text();
var bundleTypeArray = bundleType.split(',');
var bundleId = bundleTypeArray[0];
var locationId = bundleTypeArray[1];

$("#bundle_name").val(bundleName);
$("#bundle_id").val(bundleId);
$("#location_id").val(locationId);

});
//---------------------------------------------------------------
});