<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../dbConnect.php";

$clubDrop = "";
$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id); 
while($stmt->fetch()){
    $clubName = trim($clubName);
    $clubDrop .="<option value=\"$club_id|$clubName\">$clubName</option>";
     }
$stmt->close();

$todaysDate = date('m/d/Y');


$table_header = "<div id=\"totals\">
                          <span id=\"tot1\"><u>Record #</u><br></span>
                          <span id=\"tot2\"><u>Contract</u><br>  </span>
                          <span id=\"tot3\"><u>Name</u><br>  </span>
                          <span id=\"tot4\"><u>Total Cost</u><br>  </span>
                          <span id=\"tot5\"><u>Amount Paid</u><br>  </span>
                          <span id=\"tot1\"><u>Balance Due</u><br></span>
                          <span id=\"tot2\"><u>Due Date</u><br>  </span>
                          <span id=\"tot3\"><u>Days Pastdue</u><br>  </span>
                          <span id=\"tot4\"><u>Phone Number</u><br>  </span>
                          <span id=\"tot5\"><u>Email</u><br>  </span>
                          </div>";    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/reportTools.css">
<style>
.topArea {
    height: 90px;
}
#totals {
    height: 60px;
}
</style>
<link rel="stylesheet" href="../css/zebra.css" />
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
    window.location = "../billing/accountInformation.php?rp_ckey6="+contractKey;   
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
              
                
                
                //alert(clubId);
                $.ajax ({
                    type: "POST",
                    url: "loadBalanceData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('.tableArea').html("");   
                            $('.tableArea').html(data);  
                            
                            $("#listings").tablesorter();
							$('#listings.tablesorter').tablesorter({
								scrollHeight: 300,
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
                doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Record #</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Contract Key</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Member Name</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Total Cost</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Amount Paid</font></th><th align=\"center\" bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Balance Due</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Due Date</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Days Pastdue</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Phone Number</font></th><th align=\"center\"  bgcolor=\"#000000\"><font face=\"Arial\" size=\"2\" color=\"#FFFFFF\">Email</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
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
<?php echo $clubDrop; ?>
</select> 
</div>
<div class="leftM2B" id="leftM2B">
Date: <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker" value="<?php echo $todaysDate; ?>" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
</div>
<div class="leftM3B" id="leftM3B">
Range End(Optional): <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker2" value="" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
<input class="button1" id="button1" name="run" value="Run Report" type="button"></input><input class="button1" id="print1" name="print1" value="Print Preview" type="button"></input>
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




