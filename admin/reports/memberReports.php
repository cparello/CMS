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




$table_header = "<div id=\"totals\">

                          <h1>Member Reports</h1>
                          </div>";    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Renewal Report</title>
<meta name="description" content="jQuery Print Area">
<meta name="keywords" content="jQuery Print Area">
<link rel="stylesheet" media="screen" type="text/css" href="../css/reportTools.css">
<link rel="stylesheet" media="print" type="text/css" href="../css/reportTools.css">
<meta http-equiv="imagetoolbar" content="no" />
<style>
    .topArea {
        height: 110px;
    }
    #totals {
        height: 50px;
    }

  a:hover{
    cursor: pointer;
    cursor: hand;
    }
  .p_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .c_sms{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_sms_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #p_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #c_call_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    #email_attempts{
        color: black;
        font-weight: 900;
        font-size: 16px;
    }
    .colorChange{
        color: red;
        
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
    console.log("test");
    //var contractKey = $(this).closest('tr').find('#contract_key').text();
    console.log(contractKey);
    var bg= '#282828';
    //var bg = "url(./images/carbon_fibre.png)";
    
    window.parent.document.getElementById('contentHeader').style.backgroundColor = bg;
    
    
    window.parent.document.getElementById('contentHeader').innerHTML = '<div id="tabOne" class="headText headText2">Account Information</div><div id="tabTwo" class="headText">Payment History</div><div id="tabThree" class="headText">Member Information</div><div id="tabFour" class="headText">Notes</div><div id="tabFive" class="headText">Member History</div>';
    
    window.parent.document.getElementById('contentFrame').style.top="38px";
    window.location = "../billing/accountInformation.php?rp_ckey2="+contractKey;   
    return false;
}
</script>


<script>
   $(document).ready(function() {
    
            $(".leftM2B").change(function() {
                var category_type = $("#category_type").val(); 
                
                if(category_type == 'GEN' || category_type == 'AA' || category_type == 'IA' || category_type == 'AGE' || category_type == 'HOL' || category_type == 'PRE' || category_type == 'CRE'){
                    $('#datepicker').prop("disabled",true);
                    $('#datepicker2').prop("disabled",true);
                    $('#location').prop("disabled",true);
                }else{
                    $('#datepicker').prop("disabled",false);
                    $('#datepicker2').prop("disabled",false);
                    $('#location').prop("disabled",false);
                }
               }); 
               
             //DATEPICKER
            $('input.datepicker').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            $('input.datepicker2').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            //UPDATE CLASS TYPES WHEN CLUB IS SELECTED
            $("#run1").click(function() { 
                var errors = "";
                
                var ajax_switch = 1;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                var date2 = $("#datepicker2").val();
                var catType = $("#category_type").val(); 
                var servType = $("#service_type").val();
                
               
                
                if(errors != ""){
                    $('#msgBox').html(errors);
                    $("#msgBox").css( { "color" : "red"} );
                    $(".topArea").css( { "height" : "100px"} );
                    return false;
                }else{
                    $('#msgBox').html("");
                    $(".topArea").css( { "height" : "70px"} );
                }
              
                
                
                //alert(clubId);
                $.ajax ({
                    type: "POST",
                    url: "loadMemberData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2, catType: catType, servType: servType},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('.tableArea').html("");   
                            $('.tableArea').html(data);  
                            
                            $("#listings").tablesorter();
							$('#listings.tablesorter').tablesorter({
								scrollHeight: 350,
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
            doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th style=\"width: 16px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">#</font></th><th style=\"width: 48px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Contract</font></th><th style=\"width: 123px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Name</font></th><th style=\"width: 88px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Primary Phone</font></th><th style=\"width: 189px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Email Address</font></th><th style=\"width: 38px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 75px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Service</font></th><th style=\"width: 32px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Exp Date</font></th><th style=\"width: 43px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Price</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
            //$("#tableArea").css( { "hieght" : "100%"});
            doc.close();
        });
        
        
     /*  	$('.print').click(function() {
              //  var table = $('#tableArea').html();
                //table = encodeURIComponent(table);
                //alert(table);
                
              
        	 window.open('printWindow.php','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
              var clone = $('.tableArea', window.parent.document).clone(true);
              alert(clone);
                 var theOuterHtml = clone.wrap('<div></div>').parent().html();
                 $('#tableArea2').append(theOuterHtml);
             //newWindow.document.write(table);
        	//	var container = $(this).attr('rel');
               // $('.scroller_tbl').css( { "height" : "200%"} );
        	//	$('#' + container).printArea();
        	//	return false;
        	});*/
	
           

           
                               
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
Category:<br> <select name="category_type" id="category_type" class="black3">
<option value="">Select Category</option>
<option value="AA">Active Accounts</option>
<option value="IA">Inactive Accounts</option>
<option value="AGE">Age Comparison</option>
<option value="NEW">New Members</option>
<option value="HOL">Freeze/Hold Report</option>
<option value="PRE">Prepayment Report</option>
<option value="CRE">Service Credit Report</option>
<option value="EMAIL">Email Report</option>
<option value="CELL">Cell Phone Report</option>
</select>
</div>
<div class="leftM3B" id="leftM3B">
Service Type:<br>  <select name="service_type" id="service_type">
<option value="0" selected="selected">All Service Types</option>
<?php echo $serviceDrop; ?>
</select>
</div>
<div class="leftM4B" id="leftM4B">
Date: <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker" value="<?php echo $todaysDate; ?>" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
Range End(Optional): <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker2" value="" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
<input class="button1" id="run1" name="run1" value="Run Report" type="button"></input><input class="button1" id="print1" name="print1" value="Print Preview" type="button"></input>
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




