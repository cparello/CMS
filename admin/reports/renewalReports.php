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
                          <span id=\"tot4\"><u>Send SMS</u><br>  </span>
                          <span id=\"tot5\"><u># SMS</u><br>  </span>
                          <span id=\"tot1\"><u>Primary Phone</u><br></span>
                          <span id=\"tot2\"><u># Calls</u><br>  </span>
                          <span id=\"tot3\"><u>Email Address</u><br>  </span>
                          <span id=\"tot4\"><u>Service</u><br>  </span>
                          <span id=\"tot5\"><u>Exp Date</u><br>  </span>
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
        height: 80px;
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
<script type="text/javascript" src="../scripts/spamContactGuard.js"></script>
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
    window.location = "../billing/accountInformation.php?rp_ckey4="+contractKey;   
    return false;
}
</script>

<script>
   $(document).ready(function() {
             $(".leftM2B").change(function() {
                var report = $("#renew_type").val(); 
                
                if(report == '23'){
                    $('#location').prop("disabled",true);
                    $('#leftM3B').html("Month: <select name=\"month\" id=\"month\"><option value=\"01\">January</option><option value=\"02\">February</option><option value=\"03\">March</option><option value=\"04\">April</option><option value=\"05\">May</option><option value=\"06\">June</option><option value=\"07\">July</option><option value=\"08\">August</option><option value=\"09\">September</option><option value=\"10\">October</option><option value=\"11\">November</option><option value=\"12\">December</option></select><br><br>Year:<select name=\"year\" id=\"year\"><option value=\"2015\">2015</option><option value=\"2014\">2014</option><option value=\"2013\">2013</option><option value=\"2012\">2012</option><option value=\"2011\">2011</option><option value=\"2010\">2010</option><option value=\"2009\">2009</option></select>");
                }else{
                    $('#location').prop("disabled",false);
                    $('#batch').html("Date: <span style=\"display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;\" class=\"Zebra_DatePicker_Icon_Wrapper\"><span style=\"display: inline-block; position: relative; float: none; top: 0px; right: 0px; bottom: 0px; left: 0px;\" class=\"Zebra_DatePicker_Icon_Wrapper\"><input style=\"position: relative; top: auto; right: auto; bottom: auto; left: auto; display: inline-block;\" readonly=\"readonly\" class=\"datepicker\" id=\"datepicker\" value=\"11/28/2015\" type=\"text\"><button style=\"top: 3.5px; left: 154px;\" type=\"button\" class=\"Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside\">Pick a date</button></span><button style=\"top: 10.5px; left: 201px;\" type=\"button\" class=\"Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside\">Pick a date</button></span>");
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
                var renewType = $("#renew_type").val(); 
                
                if(renewType != 23){
                    var date = $(".datepicker").val();
                    var date2 = $("#datepicker2").val();
                    
                    if(renewType == 0){
                        if(date2 == ""){
                            errors = "For this option there must be an end range.";
                        }
                    }else if (renewType == 1){
                        if(date2 != ""){
                            errors = "For this option there must NOT be an end range.";
                        }
                        }
                }else{
                    var month = $("#month").val();
                    var year = $("#year").val();
                    console.log(month);
                }
                
                
                
                
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
                    url: "loadRenewalData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2, renewType: renewType, month: month, year: year},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('.tableArea').html("");   
                            $('.tableArea').html(data);  
                            
                            $("#listings").tablesorter();
							$('#listings.tablesorter').tablesorter({
								scrollHeight: 400,
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
            doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th style=\"width: 16px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">#</font></th><th style=\"width: 48px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Contract</font></th><th style=\"width: 123px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Name</font></th><th style=\"width: 45px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 26px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 88px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Primary Phone</font></th><th style=\"width: 28px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 189px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Email Address</font></th><th style=\"width: 38px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 75px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Service</font></th><th style=\"width: 32px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Exp Date</font></th><th style=\"width: 43px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Price</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
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
Report Type:<br> <select name="renew_type" id="renew_type">
<option value="0" selected="selected">All Renew Types</option>
<option value="EXP">Expired Re-enroll</option>
<option value="SRP">Standard Renewal</option>
<option value="ERP">Early Renewal</option>
<option value="1">All active accounts</option>
<option value="23">Renewal Retention</option>
</select>
</div>
<div class="leftM3B" id="leftM3B">
Date: <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker" value="<?php echo $todaysDate; ?>" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
</div>
<div class="leftM4B" id="leftM4B">
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




