$(document).ready(function() {
//-----------------------------------------------------------------
function resetDropDowns(fromWhere) {

var serviceTypeDrop = "<option value>Select Service Type</option>";
var serviceTypeOptionsDrop = "<option value>Select Service Options</option>";
var salesTypeDrop = "<option value>Select Sales Type</option>";
var salesNameDrop = "<option value>Select Sales Name</option>";

     switch(fromWhere) {
        case "SL":
        $("#service_type").html(serviceTypeDrop);
        $("#service_type_options").html(serviceTypeOptionsDrop);
        $("#sales_type").html(salesTypeDrop);
        $("#sales_name").html(salesNameDrop);
        break;
        case "GT":
        $("#service_type_options").html(serviceTypeOptionsDrop);
        $("#sales_type").html(salesTypeDrop);
        $("#sales_name").html(salesNameDrop);        
        break;     
        case "ST":
        $("#sales_type").html(salesTypeDrop);
        $("#sales_name").html(salesNameDrop); 
        break;
        case "SO":
        $("#sales_name").html(salesNameDrop); 
        break;        
        }

}
//----------------------------------------------------------------
$("#service_location").change( function() {

var clubId = $("option:selected", this).val();
var ajaxSwitch = 1;
var fromWhere = "SL";

  if(clubId != "") {

        $.ajax ({
                type: "POST",
                url: "groupDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId},               
                     success: function(data) { 
                         $("#group_type").html(data);   
                           resetDropDowns(fromWhere);                        
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#group_type").live("change", function(event) {

var groupType = $("option:selected", this).val();
var clubId = $("#service_location").val();
var ajaxSwitch = 1;
var fromWhere = "GT";

  if(groupType != "") {  

        $.ajax ({
                type: "POST",
                url: "typeDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, group_type: groupType},               
                     success: function(data) { 
                         $("#service_type").html(data); 
                         resetDropDowns(fromWhere);
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------
$("#service_type").live("change", function(event) {

var serviceType = $("option:selected", this).val();
var optionDrops = "";
var fromWhere = "ST";


  if(serviceType != "") {  
  
     switch(serviceType) {
        case "0":
        optionDrops = "<option value>Select Service Options</option>\n<option value='AA'>All Options</option>\n<option value='CL'>Paid Full Classes (Sales)</option>\n<option value='SC'>Paid Full Classes (Scheduler)</option>\n<option value='FT'>Paid Full Term Services</option>\n<option value='MT'>Monthly Term Services</option>\n<option value='MO'>Monthly Open Ended</option>";
        $("#service_type_options").html(optionDrops);
        break;
        case "P":
        optionDrops = "<option value>Select Service Options</option>\n<option value='AP'>All Options</option>\n<option value='CL'>Paid Full Classes (Sales)</option>\n<option value='SC'>Paid Full Classes (Scheduler)</option>\n<option value='FT'>Paid Full Term Services</option>";
        $("#service_type_options").html(optionDrops);
        break;        
        case "E":
        optionDrops = "<option value>Select Service Options</option>\n<option value='AM'>All Options</option>\n<option value='MT'>Monthly Term Services</option>\n<option value='MO'>Monthly Open Ended</option>";
        $("#service_type_options").html(optionDrops);
        break;        
        }
        
    resetDropDowns(fromWhere);
   }
     
});
//-----------------------------------------------------------------
$("#service_type_options").live("change", function(event) {

var serviceTypeOptions = $("option:selected", this).val();
var fromWhere = "SO";
var optionDrops2 = "";

    if(serviceTypeOptions != "") { 

      switch(serviceTypeOptions) {
        case "AA":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='0'>All Sales Types</option>\n<option value='SN'>Sales New</option>\n<option value='SU'>Sales Upgrade</option>\n<option value='SRP'>Standard Renewal</option>\n<option value='ERP'>Early Renewal</option><option value='ARP'>All Renewals</option>\n";
        $("#sales_type").html(optionDrops2);
        break;
        case "AP":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APF'>All Sales Types</option>\n<option value='SNP'>Sales New</option>\n<option value='SUP'>Sales Upgrade</option>\n<option value='SRP'>Standard Renewal</option>\n<option value='ERP'>Early Renewal</option><option value='ARP'>All Renewals</option>\n";
        $("#sales_type").html(optionDrops2);
        break;        
        case "AM":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APM'>All Sales Types</option>\n<option value='SNM'>Sales New</option>\n<option value='SUM'>Sales Upgrade</option>\n";
        $("#sales_type").html(optionDrops2);
        break;                
        case "CL":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APF'>All Sales Types</option>\n<option value='SNP'>Sales New</option>\n<option value='SUP'>Sales Upgrade</option>\n";
        $("#sales_type").html(optionDrops2);
        break;    
        case "SC":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='SNP'>Sales New</option>\n";
        $("#sales_type").html(optionDrops2);
        break;                   
        case "FT":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APF'>All Sales Types</option>\n<option value='SNP'>Sales New</option>\n<option value='SUP'>Sales Upgrade</option>\n<option value='SRP'>Standard Renewal</option>\n<option value='ERP'>Early Renewal</option><option value='ARP'>All Renewals</option>\n";
        $("#sales_type").html(optionDrops2);
        break;     
        case "MT":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APM'>All Sales Types</option>\n<option value='SNM'>Sales New</option>\n<option value='SUM'>Sales Upgrade</option>\n";
        $("#sales_type").html(optionDrops2);
        break; 
        case "MO":
        optionDrops2 = "<option value>Select Sales Type</option>\n<option value='APM'>All Sales Types</option>\n<option value='SNM'>Sales New</option>\n<option value='SUM'>Sales Upgrade</option>\n";
        $("#sales_type").html(optionDrops2);
        break;                         
        }
        
         resetDropDowns(fromWhere);
     }
       
         
});
//-----------------------------------------------------------------
$("#sales_type").live("change", function(event) {

var clubId = $("#service_location").val();
var groupType = $("#group_type").val();
var serviceType = $("#service_type").val();
var serviceTypeOptions = $("#service_type_options").val();
var salesType = $("option:selected", this).val();
var ajaxSwitch = 1;


  if(salesType != "") {  

        $.ajax ({
                type: "POST",
                url: "salesNameDrops.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId, group_type: groupType, service_type: serviceType, service_type_options: serviceTypeOptions, sales_type: salesType},               
                     success: function(data) { 
                 // alert(data);
                          if(data == "0") {
                            alert('There are currently no records that match your search criterior');
                                    return false;                          
                            }else{
                             $("#sales_name").html(data);
                            }
                                                                           
                         }//end function success
                 }); //end ajax 

       }
     
});
//-----------------------------------------------------------------

});


