$(document).ready(function() {
//================================================================
$(".pic1").click( function() {

var app = $("#check_in").val();
var clubId = $("#locationSnap").val();

if(clubId == ""){
    alert('Please select a club.');
    return false;
}

if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
    window.location = "../admin/memberinterface/indexSnapshot.php?clubId="+clubId;      
}


        

});
//----------------------------------------------------------------
$(".pic2").click( function() {
//alert('fu');
var app = $("#mem_int").val();

var clubId = $("#locationMem").val();

if(clubId == ""){
    alert('Please select a club.');
    return false;
}

if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
    window.location = "../admin/memberinterface/indexMemInt.php?clubId="+clubId;      
}

});
//----------------------------------------------------------------
$(".sales").click( function() {
//alert('fu');
var app = $("#sales").val();

if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
    window.location = "/admin/sales/indexSales.php";      
}

});
//----------------------------------------------------------------
$(".admin").click( function() {
//alert('fu');
var app = $("#admin").val();

if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
    window.location = "/admin/index.php";      
}

});
//----------------------------------------------------------------
$(".pic5").click( function() {
//alert('fu');
var app = $("#sales_sched").val();
var clubId = $("#locationSched").val();

if(clubId == ""){
    alert('Please select a club.');
    return false;
}

if(app == 'N'){
    alert('You do not have access to this application.');
    return false;
}else{
    window.location = "../admin/sales/masterScheduleUpdate.php?clubId="+clubId;      
}

});
//----------------------------------------------------------------
});