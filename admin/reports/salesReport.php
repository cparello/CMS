<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../dbConnect.php";

$clubDrop = "";
$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id); 
while($stmt->fetch()){
    $clubName = trim($clubName);
    $clubDrop .="<option value=\"$club_id|$clubName\">$clubName</option>";
     }
$stmt->close();

$serviceDrop = "";
$stmt = $dbMain ->prepare("SELECT DISTINCT service_type, service_key FROM service_info WHERE service_key != '' ORDER BY service_type ASC");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($servName, $serviceKey); 
while($stmt->fetch()){
    $servName = trim($servName);
    $serviceDrop .="<option value=\"$serviceKey|$servName\">$servName</option>";
     }
$stmt->close();

$todaysDate = date('m/d/Y');

$stmt = $dbMain->prepare("SELECT emp_fname, emp_lname, user_id FROM employee_info WHERE user_id != ''");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($emp_fname, $emp_lname, $user_id);
while($stmt->fetch()){
    $empDrop .="<option value=\"$user_id\">$emp_fname $emp_lname</option>";
}
$stmt->close();


$table_header = "<div id=\"totals\">
                          <span id=\"tot1B\"><u>Month</u><br>  ".date('F')."</span>
                          <span id=\"tot2B\"><u>Quota</u><br> </span>
                          <span id=\"tot3B\"><u>Monthly Total</u><br> </span>
                          <span id=\"tot4B\"><u>Sales Left</u><br> </span>
                          <span id=\"tot5B\"><u>Daily Goal</u><br> </span>
                          </div>";    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/reportTools.css">
<link rel="stylesheet" href="../css/zebra.css" />
<style>
.topArea {
    height: 120px;
}
#totals {
    height: 60px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="../scripts/modernizr.js"></script>
<script src="../scripts/foundation.min.js"></script>
<script src="../scripts/zebra_datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script> 
<script type="text/javascript">
function doSomething(contractKey) {
    //console.log("test");
    //var contractKey = $(this).closest('tr').find('#contract_key').text();
    console.log(contractKey);
    var bg= '#282828';
    //var bg = "url(./images/carbon_fibre.png)";
    
    window.parent.document.getElementById('contentHeader').style.backgroundColor = bg;
    
    
    window.parent.document.getElementById('contentHeader').innerHTML = '<div id="tabOne" class="headText headText2">Account Information</div><div id="tabTwo" class="headText">Payment History</div><div id="tabThree" class="headText">Member Information</div><div id="tabFour" class="headText">Notes</div><div id="tabFive" class="headText">Member History</div>';
    
    window.parent.document.getElementById('contentFrame').style.top="38px";
    window.location = "../billing/accountInformation.php?rp_ckey5="+contractKey;   
    return false;
}
</script>
<script>
   $(document).ready(function() {
             //DATEPICKER
            $('input.datepicker').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            $('input.datepicker2').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            //UPDATE CLASS TYPES WHEN CLUB IS SELECTED
            $("#button1").click(function() { 
                var errors = "";
                
                var ajax_switch = 1;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                var date2 = $("#datepicker2").val();
                //alert(date2);
                
                var pifBool = $("#service_type").val();
                var salesBool = $("#sales_type").val();
                var groupBool = $("#group_type").val();
                var employee = $("#employee").val();
                
                
                //alert(clubId);
                $.ajax ({
                    type: "POST",
                    url: "loadSalesData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2, pifBool: pifBool, salesBool: salesBool, groupBool: groupBool, employee: employee},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('.tableArea').html("");   
                            $('.tableArea').html(data);  
                            
                            $("#listings").tablesorter();
							$('#listings.tablesorter').tablesorter({
								scrollHeight: 210,
								widgets: ['scroller']
							});             
                        } else {
                             $('#dataArea').html(""); 
                            $('#msgBox').html('No sales data for these choices.');
                            $("#msgBox").css( { "color" : "red"} );
                            return false;
                        }                     
                    }
                });
            });
            
            
            $("#print1").click (function () {
                    var printContents = $("#listings").clone();
                   // alert(printContents);
                    //return false;
                    var myWindow = window.open("", "popup","width=1000,height=600,scrollbars=yes,resizable=yes," +  
                        "toolbar=no,directories=no,location=no,menubar=no,status=no,left=0,top=0");
                    var doc = myWindow.document;
                    doc.open();
                    $(printContents).find('thead').remove();
                    $(printContents).find(".p_sms").remove();
                    $(printContents).find("#email_attempts").remove();
                    $(printContents).find("#p_sms_attempts").remove();
                    $(printContents).find("#p_call_attempts").remove();
                   // var button = "</table></div></body></html><input type='button' id='btnPrint' value='Print' style='float: right;' onclick='window.print();'/>";
                   // var tableHead = "<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%>";
                   
                   // $(printContents).prepend($(tableHead));
                    //$(printContents).after(tableClose);
                    //$(printContents).append($(button));
                    doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">#</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Contract Key</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Member Name</font></th><th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Transaction Type</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Service Name</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Price</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"3\" color=\"#FFFFFF\">Employee Name</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
                    //$("#tableArea").css( { "hieght" : "100%"});
                    doc.close();
        });
            
            
                               
        });
</script>
</head>
<body>
<div class="topArea">
<div class="leftM" id="leftM">
Club: <br><select id="location" name="location">
<option value="1" selected="selected">All Clubs</option>
<option value="0|Website">Website</option>
<?php echo $clubDrop; ?>
</select> 
</div>
<div class="right" id="right">
Date: <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker" value="<?php echo $todaysDate; ?>" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>

Range End(Optional): <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker2" value="" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
<input class="button1" id="button1" name="run" value="Run Report" type="button"></input><input class="button1" id="print1" name="print1" value="Print Preview" type="button"></input>
</div>
<br>
<div class="leftM2" id="leftM2">
Service Type:<br>  <select name="service_type" id="service_type">
<option value="0" selected="selected">All Service Types</option>
<option value="E">All Monthly Accounts</option>
<option value="P">All Paid In Full Accounts</option>
<?php echo $serviceDrop; ?>
</select>
</div>
<div class="leftM3" id="leftM3">
Employee:<br>  <select name="employee" id="employee">
<option value="0" selected="selected">All Employees</option>
<?php echo $empDrop ?>
</select>
</div>
<div class="rightM" id="rightM">
Sale Type:<br> <select name="sales_type" id="sales_type">
<option value="0" selected="selected">All Sales Types</option>
<option value="SN">Sales New</option>
<option value="SU">Sales Upgrade</option>
<option value="SRP">Standard Renewal</option>
<option value="ERP">Early Renewal</option>
<option value="ARP">All Renewals</option>
</select>
</div>
<div class="rightM2" id="rightM2">
Group Type:<br>  <select name="group_type" id="group_type">
<option value="0" selected="selected">All Groups</option>
<option value="S">Single</option>
<option value="O">Organization</option>
<option value="B">Business</option>
<option value="F">Family</option>
</select>
</div>




<span id="msgBox"></span>
</div>

<div class="tableArea expand-div" id="tableArea">
<?php echo $table_header; ?>
</tbody>
</table>
</div>
</body>
</html>




