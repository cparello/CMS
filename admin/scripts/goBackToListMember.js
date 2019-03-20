$(document).ready(function() {


//----------------------------------------------------------------
$("#goBack").click( function() {


var whereBool = $('#whichBackBut').val(); 
//alert('fu '+whereBool);
if(whereBool == 1){
    window.location = "searchMembers.php?marker=1";
}else if(whereBool == 2){
    window.location = "viewCheckInHistory.php";
}else{
    alert("Error has occured! Button not Assigned.")
}
       
});


});











