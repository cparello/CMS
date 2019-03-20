$(document).ready(function() {

//----------------------------------------------------------------
$("#saveBut").click( function() {

   $("#chartSave").show("slow");

});
//---------------------------------------------------------------
$("#menu_exit").click( function() {

   $("#chartSave").hide("slow");

});
//---------------------------------------------------------------
$("#button2").click( function() {

var select = "";
var optionDropsArray = "";
var reportType = $("#report_type").val();
var reportName = $("#report_name").val();

if(reportType == 'S') {

var ajaxSwitch = 1;
var clubId = $("#service_location").val();
var groupType = $("#group_type").val();
var serviceType = $("#service_type").val();
var serviceTypeOptions = $("#service_type_options").val();
var salesType = $("#sales_type").val();
var salesName = $("#sales_name").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var clubIdDrops = "";
var groupTypeDrops = "";
var serviceTypeDrops = "";
var serviceTypeOptionsDrops = "";
var salesTypeDrops = "";
var salesNameDrops = "";



if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(groupType == "") {
  alert('Please select a \"Group Type\"');
  $("#group_type").focus();
  return false;
  }

if(serviceType == "") {
  alert('Please select a \"Service Type\"');
  $("#service_type").focus();
  return false;
  }

if(serviceTypeOptions == "") {
  alert('Please select one of the \"Service Options\"');
  $("#service_type_options").focus();
  return false;
  }

if(salesType == "") {
  alert('Please select a \"Sales Type\"');
  $("#sales_type").focus();
  return false;
  }

if(salesName == "") {
  alert('Please select a \"Sales Name\"');
  $("#sales_name").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }


//sets up saved html for drop down drill downs when a saved report is loaded
$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       clubIdDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#group_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       groupTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#service_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#service_type_options > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceTypeOptionsDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#sales_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       salesTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });
  
$("#sales_name > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       salesNameDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  


optionDropsArray = (clubIdDrops+ '|' +groupTypeDrops+ '|' +serviceTypeDrops+ '|' +serviceTypeOptionsDrops+ '|' +salesTypeDrops+ '|' +salesNameDrops);

}//end if sales report
//============================================
//this is for cash flow report
if(reportType == 'F') {

var ajaxSwitch = 2;
var clubId = $("#service_location").val();
var flowType = $("#flow_type").val();
var salesType = $("#sales_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var clubIdDrops = "";
var flowTypeDrops = "";
var salesTypeDrops = "";

if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(flowType == "") {
  alert('Please select a \"Cash Flow Type\"');
  $("#flow_type").focus();
  return false;
  }
  
if(salesType == "") {
  alert('Please select a \"Sales Type\"');
  $("#sales_type").focus();
  return false;
  }  

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }
  
  
//sets up saved html for drop down drill downs when a saved report is loaded
$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       clubIdDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#flow_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       flowTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });
  
$("#sales_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       salesTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  


optionDropsArray = (clubIdDrops+ '|' +flowTypeDrops+ '|' +salesTypeDrops);

}//end if cash flow report
//===============================================
//this is for retail reports
if(reportType == 'R') {

var ajaxSwitch = 3;
var clubId = $("#service_location").val();
var retailCategory = $("#retail_category").val();
var productName = $("#product").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var clubIdDrops = "";
var categoryTypeDrops = "";
var productNameDrops = "";

if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(retailCategory == "") {
  alert('Please select a \"Retail Category\"');
  $("#retail_category").focus();
  return false;
  }
  
if(productName == "") {
  alert('Please select a \"Product Name\"');
  $("#product").focus();
  return false;
  }  

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

//sets up saved html for drop down drill downs when a saved report is loaded
$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       clubIdDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#retail_category > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       categoryTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#product > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       productNameDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

optionDropsArray = (clubIdDrops+ '|' +categoryTypeDrops+ '|' +productNameDrops);


}//end retail report

//==========================================
//for accounts collectible
if(reportType == 'C') {

var ajaxSwitch = 4;
var reportName = $("#report_name").val();
var collectionType = $("#collection_type").val();
var collectionCategory = $("#colCat").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var collectionTypeDrops = "";
var collectionCategoryDrops = "";


if(collectionType == "") {
  alert('Please select a \"Collection Category\"');
  $("#collection_type").focus();
  return false;
  
  }else{
          
        if(collectionCategory == "") {
        
                switch (collectionType) {
                  case "P":
                  alert('Please select a \"Collection Attempt\"');         
                  break;
                  case "D":
                  alert('Please select a \"Transaction Type\"');                        
                  break;
                  case "I":
                  alert('Please select a \"Club Location\"');          
                  break;   
                 }
      
              $("#colCat").focus();
                return false;
         }
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }
  

//sets up saved html for drop down drill downs when a saved report is loaded
$("#collection_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       collectionTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#colCat > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       collectionCategoryDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });


optionDropsArray = (collectionTypeDrops+ '|' +collectionCategoryDrops);

}//end collection report
//======================================================
//for accounts renewable and expired
if(reportType == 'E') {

var ajaxSwitch = 5;
var renewType = $("#renew_type").val();
var serviceLocation = $("#service_location").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var renewTypeDrops = "";
var serviceLocationDrops = "";


if(renewType == "") {
  alert('Please select a \"Renewable Category\"');
  $("#renew_type").focus();
  return false;
 }

if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
 }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }
  

//sets up saved html for drop down drill downs when a saved report is loaded
$("#renew_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       renewTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });


$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

optionDropsArray = (renewTypeDrops+ '|' +serviceLocationDrops);

}//end renewable expired
//=====================================================
//for monthly settled
if(reportType == 'M') {

var ajaxSwitch = 6;
var transactionType = $("#transaction_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var transactionTypeDrops = "";


if(transactionType == "") {
  alert('Please select a \"Transaction Type\"');
  $("#transaction_type").focus();
  return false;
 }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }


//sets up saved html for drop down drill downs when a saved report is loaded
$("#transaction_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       transactionTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

optionDropsArray = (transactionTypeDrops+ '|');

}//end monthly settled
//------------------------------------------------------------------------------
//for cancel holds
if(reportType == 'H') {

var ajaxSwitch = 7;
var holdCancelType = $("#hc_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var holdCancelTypeDrops = "";


if(holdCancelType == "") {
  alert('Please select a \"Hold Cancel Type\"');
  $("#hc_type").focus();
  return false;
 }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }


//sets up saved html for drop down drill downs when a saved report is loaded
$("#hc_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       holdCancelTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

optionDropsArray = (holdCancelTypeDrops+ '|');

}//end hold cancel
//------------------------------------------------------------------------------
if(reportType == 'A') {

var ajaxSwitch = 8;
var categoryType = $("#category_type").val();
var serviceLocation = $("#service_location").val();
var dateRange = $("#date_range").val();
var serviceLocationDrops = "";
var categoryTypeDrops = "";
var dateRangeDrops = "";


if(categoryType == "") {
  alert('Please select a \"Category Type\"');
  $("#category_type").focus();
    return false;
  }
  
if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
    return false;
  }  
  
if(dateRange == "") {
  alert('Please select a \"Date Range\"');
  $("#date_range").focus();
    return false;
  }    

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }
  
  
//sets up saved html for drop down drill downs when a saved report is loaded  
$("#category_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       categoryTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  

$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });

$("#date_range > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       dateRangeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });
  
  
optionDropsArray = (categoryTypeDrops+ '|' +serviceLocationDrops+ '|' +dateRangeDrops);  

}
//------------------------------------------------------------------------------
if(reportType == 'CA') {

var ajaxSwitch = 9;
var attendanceType = $("#attendance_type").val();
var serviceLocation = $("#service_location").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var serviceLocationDrops = "";
var attendanceTypeDrops = "";

if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
    return false;
  }  

if(attendanceType == "") {
  alert('Please select an \"Attendance Category\"');
  $("#attendance_type").focus();
    return false;
  }  

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }
  
  
$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  
  
$("#attendance_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       attendanceTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });    
  
  optionDropsArray = (serviceLocationDrops+ '|' +attendanceTypeDrops);

}//end club attendance report
//------------------------------------------------------------------------------
if(reportType == 'EA') {

var ajaxSwitch = 10;
var scheduleType = $("#schedule_type").val();
var serviceLocation = $("#service_location").val();
var className = $("#class_name").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var serviceLocationDrops = "";
var scheduleTypeDrops = "";
var classNameDrops = "";


if(serviceLocation == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
    return false;
  }  

if(scheduleType == "") {
  alert('Please select a \"Schedule Type\"');
  $("#schedule_type").focus();
    return false;
  }  
  
if(className == "") {
  alert('Please select a \"Class Name\"');
  $("#class_name").focus();
    return false;
  }    
  

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }


$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  
  
$("#schedule_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       scheduleTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });  
  
$("#class_name > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       classNameDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      
  
  
optionDropsArray = (serviceLocationDrops+ '|' +scheduleTypeDrops+ '|' +classNameDrops);

}
//-----------------------------------------------------------------------------
if(reportType == 'P') {

var ajaxSwitch = 11;
var clubId = $("#service_location").val();
var paymentCycle = $("#payment_cycle").val();
var compType = $("#compensation_type").val();
var empType = $("#employee_type").val();
var otType = $("#ot_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var serviceLocationDrops = "";
var paymentCycleDrops = "";
var compTypeDrops = "";
var empTypeDrops = "";
var otTypeDrops = "";


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(paymentCycle == "") {
  alert('Please select a \"Payment Cycle\"');
  $("#payment_cycle").focus();
  return false;
  }

if(compType == "") {
  alert('Please select a \"Compensation Type\"');
  $("#compensation_type").focus();
  return false;
  }
  
if(empType == "") {
  alert('Please select an \"Employee Type\"');
  $("#employee_type").focus();
  return false;
  }  
  
if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }

  
$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });    
  
$("#payment_cycle > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       paymentCycleDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      
  
$("#compensation_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       compTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      

$("#employee_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       empTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      

$("#ot_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       otTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      
  
  
optionDropsArray = (serviceLocationDrops+ '|' +paymentCycleDrops+ '|' +compTypeDrops+ '|' +empTypeDrops+ '|' +otTypeDrops);  
  

}
//-----------------------------------------------------------------------------
if(reportType == 'CO') {

var ajaxSwitch = 12;
var clubId = $("#service_location").val();
var employeeType = $("#employee_type").val();
var employeeName = $("#employee_name").val();
var serviceType = $("#service_type").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var serviceLocationDrops = "";
var empTypeDrops = "";
var empNameDrops = "";
var serviceTypeDrops = "";


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(employeeType == "") {
  alert('Please select an \"Employee Type\"');
  $("#employee_type").focus();
  return false;
  }  

if(employeeName == "") {
  alert('Please select an \"Employee Name\"');
  $("#employee_name").focus();
  return false;
  }

if(serviceType == "") {
  alert('Please select a \"Service Type\"');
  $("#service_type").focus();
  return false;
  }

if(fromDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(toDate != "")  {
  alert('Reports with a \"Date Range\" cannot be saved');
  return false;
  }

if(reportName == "") {
  alert('Please enter a \"Report Name\"');
  $("#report_name").focus();
  return false;
  }


$("#service_location > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceLocationDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });    

$("#employee_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       empTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      

$("#employee_name > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       empNameDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      

$("#service_type > option").each(function() {
     if(this.selected == false) {
        select = "";
        }else{
        select = 'selected';
        }        
       serviceTypeDrops += ('<option value="' +this.value+ '"' +select+ '>' +this.text+ '</option>');
  });      



optionDropsArray = (serviceLocationDrops+ '|' +empTypeDrops+ '|' +empNameDrops+ '|' +serviceTypeDrops);  

}
//-----------------------------------------------------------------------------

        $.ajax ({
                type: "POST",
                url: "saveReport.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, report_name: reportName, options_array: optionDropsArray, report_type: reportType},               
                     success: function(data) { 
                     
                        var dataArray = data.split('|');
                        var successBit = dataArray[0]; 
                        var savedReports = dataArray[1];
                        
                        if(successBit == "1") {
                           
                           $("#savedDropSales").html(savedReports);
                        
                           alert('Your Report, "'+reportName+ '" has been successfully saved');
                           }else{
                           alert('There was an error processing your request.');
                           }
                       
                         }//end function success
                 }); //end ajax 

});
//----------------------------------------------------------------
});