$(document).ready(function() {


//----------------------------------------------------------------
$("#goBack").click( function() {
//alert('fu');
var where_from = $("#where_from").val(); 
if(where_from == 1){
    window.location = "../reports/billingInfoReport.php";    
}else if(where_from == 3){
    window.location = "../reports/memberReports.php";    
}else if(where_from == 4){
    window.location = "../reports/collectionsReport.php";    
}else if(where_from == 5){
    window.location = "../reports/renewalReports.php";    
}else if(where_from == 6){
    window.location = "../reports/salesReport.php";    
}else if(where_from == 7){
    window.location = "../reports/initilBalanceReport.php";    
}else{
 window.location = "searchAccounts.php?marker=1";       
}
   
});


});











