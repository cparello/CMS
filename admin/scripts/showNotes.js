$(document).ready(function() {

$('#reportNotes').live("click", function(event){
    
    // find where the click originated from
    var trigger = event.target;
    
    // if it has a class of "ShowHide"
    // THEN toggle the next row
    if(trigger.className == 'ShowHide')
    {
        // toggle away
        $(trigger).closest('tr').next('.hiddenTR').toggle();
    }
});


});