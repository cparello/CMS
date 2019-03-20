$(document).ready(function() {
//---------------------------------------------------------------
$("#savedDropSales").live("change", function(event) {

var savedReportId = $("option:selected", this).val();
var reportType = $("#report_type").val();
var ajaxSwitch = "1";

if(savedReportId != "") {


        $.ajax ({
                type: "POST",
                url: "selectReport.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, saved_report_id: savedReportId, report_type: reportType},               
                     success: function(data) { 

                      var dropArrayOne = data.split('@');
                      var repType = dropArrayOne[0];
                      var dropList = dropArrayOne[1];
                      var dropListArray = dropList.split('|');
                      
                      switch (repType) {
                            case "S":
                            var idDrops = dropListArray[0];
                            var groupTypeDrops = dropListArray[1];
                            var serviceTypeDrops = dropListArray[2];
                            var serviceTypeOptionsDrops = dropListArray[3];
                            var salesTypeDrops = dropListArray[4];
                            var salesNameDrops = dropListArray[5];
                            
                            $("#service_location").html(idDrops);
                            $("#group_type").html(groupTypeDrops);
                            $("#service_type").html(serviceTypeDrops);
                            $("#service_type_options").html(serviceTypeOptionsDrops);
                            $("#sales_type").html(salesTypeDrops);
                            $("#sales_name").html(salesNameDrops);
                            break;
                            
                            case "F":
                            var idDrops = dropListArray[0];
                            var flowTypeDrops = dropListArray[1];
                            var salesTypeDrops = dropListArray[2];
                            
                            $("#service_location").html(idDrops);
                            $("#flow_type").html(flowTypeDrops); 
                            $("#sales_type").html(salesTypeDrops);                             
                            break;
                            
                            case "R":
                            var idDrops = dropListArray[0];
                            var categoryTypeDrops = dropListArray[1];
                            var productNameDrops = dropListArray[2];
                            
                            $("#service_location").html(idDrops);
                            $("#retail_category").html(categoryTypeDrops); 
                            $("#product").html(productNameDrops);                             
                            break;                            
                            
                            case "C":
                            var collectionTypeDrops = dropListArray[0];
                            var collectionCategoryDrops = dropListArray[1];
                                                      
                            $("#colCat").show();
                            $("#collection_type").html(collectionTypeDrops);
                            
                            var collectionType = $("#collection_type").val();
                            //here we take care of the text labels
                            if(collectionType == 'P') {
                               var dropDownLable = ('<span class="black">2. Collection Attempts</span>&nbsp;');
                               var parHeader1 = 'Accounts Past Due';
                               var parHeader2 = 'Total Past Due';
                               var parHeader3 = 'Past Due Projected';                            
                              }
                            if(collectionType == 'D') {
                               var dropDownLable = ('<span class="black">2. Transaction Type</span>&nbsp;');
                               var parHeader1 = 'Declined Transactions';
                               var parHeader2 = 'Declined Total';
                               var parHeader3 = 'Declined Projected';                            
                              }                            
                            if(collectionType == 'I') {
                               var dropDownLable = ('<span class="black">2. Club Location</span>&nbsp;');
                               var parHeader1 = 'Balance Due';
                               var parHeader2 = 'Due Total';
                               var parHeader3 = 'Due Projected';                        
                              }                             
                            
                            $("#colLable").html(dropDownLable);
                            $("#pHeader1").text(parHeader1);
                            $("#pHeader2").text(parHeader2);
                            $("#pHeader3").text(parHeader3);
                            $("#colCat").html(collectionCategoryDrops); 
                            break;                 

                            case "E":
                            var renewTypeDrops = dropListArray[0];
                            var locationDrops = dropListArray[1];

                            $("#renew_type").html(renewTypeDrops);    
                            $("#service_location").html(locationDrops);
                            break;
                            
                            case "M":
                            var transactionTypeDrops = dropListArray[0];
                            $("#transaction_type").html(transactionTypeDrops);    
                            break;  
                            
                            case "H":
                            var hcTypeDrops = dropListArray[0];
                            $("#hc_type").html(hcTypeDrops);    
                            break;  
                            
                            case "A":
                            var categoryTypeDrops = dropListArray[0];
                            var locationDrops = dropListArray[1];
                            var dateRangeDrops = dropListArray[2];
                            $("#category_type").html(categoryTypeDrops);
                            $("#service_location").html(locationDrops);
                            $("#date_range").html(dateRangeDrops);
                            break;
                            
                            case "CA":
                            var locationDrops = dropListArray[0];
                            var attendanceTypeDrops = dropListArray[1];
                            $("#service_location").html(locationDrops);
                            $("#attendance_type").html(attendanceTypeDrops);
                            break;
                            
                            case "EA":
                            var locationDrops = dropListArray[0];
                            var scheduleTypeDrops = dropListArray[1];
                            var classNameDrops = dropListArray[2];
                            $("#service_location").html(locationDrops);
                            $("#schedule_type").html(scheduleTypeDrops);
                            $("#class_name").html(classNameDrops);
                            break;  
                            
                            case "P":
                            var locationDrops = dropListArray[0];
                            var paymentCycleDrops = dropListArray[1];
                            var compTypeDrops = dropListArray[2];
                            var empTypeDrops = dropListArray[3];
                            var otTypeDrops = dropListArray[4];
                            $("#service_location").html(locationDrops);
                            $("#payment_cycle").html(paymentCycleDrops);
                            $("#compensation_type").html(compTypeDrops);
                            $("#employee_type").html(empTypeDrops);
                            $("#ot_type").html(otTypeDrops);
                            break;                                  
                            
                            case "CO":
                            var locationDrops = dropListArray[0];
                            var empTypeDrops = dropListArray[1];
                            var empNameDrops = dropListArray[2];
                            var serviceTypeDrops = dropListArray[3];
                            $("#service_location").html(locationDrops);
                            $("#employee_type").html(empTypeDrops);
                            $("#employee_name").html(empNameDrops);
                            $("#service_type").html(serviceTypeDrops);
                            break;                                
                            
                            
                          }
                                 

                         }//end function success
                 }); //end ajax 


  }



});
//---------------------------------------------------------------
});