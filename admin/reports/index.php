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
                          <span id=\"tot6\"><u>Primary Phone</u><br></span>
                          <span id=\"tot7\"><u># Calls</u><br>  </span>
                          <span id=\"tot8\"><u>Email Address</u><br>  </span>
                          <span id=\"tot9\"><u>Code</u><br>  </span>
                          <span id=\"tot10\"><u>Response</u><br>  </span>
                          <span id=\"tot11\"><u>Amount</u><br>  </span>
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
        height: 65px;
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
    .button1 {
        margin-bottom: 0;
}
</style>
<link rel="stylesheet" href="../css/zebra.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="../scripts/modernizr.js"></script>
<script src="../scripts/foundation.min.js"></script>
<script src="../scripts/zebra_datepicker.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.js"></script>
<script type="text/javascript" src="../scripts/jquery.tablesorter.scroller.js"></script> 
<script type="text/javascript" src="../scripts/spamContactGuard5.js"></script>
<script type="text/javascript">
function doSomething(contractKey) {
    //console.log("test");
    //var contractKey = $(this).closest('tr').find('#contract_key').text();
    console.log(contractKey);
    window.location = "../billing/accountInformation.php?rp_ckey3="+contractKey;   
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
            $("#run1").click(function() { 
                var errors = "";
                
                var ajax_switch = 1;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                var date2 = $("#datepicker2").val();
                
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
                    url: "loadCollectionsData.php",
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
								scrollHeight: 370,
								widgets: ['scroller']
							});             
                        } else {
                             $('#dataArea').html(""); 
                            $('#msgBox').html('No collections data for these choices.');
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
            doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th style=\"width: 16px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">#</font></th><th style=\"width: 48px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Contract</font></th><th style=\"width: 123px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Name</font></th><th style=\"width: 45px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 26px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 88px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Primary Phone</font></th><th style=\"width: 28px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 189px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Email Address</font></th><th style=\"width: 38px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 32px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Due Date</font></th><th style=\"width: 43px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Billing Amount</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
            //$("#tableArea").css( { "hieght" : "100%"});
            doc.close();
        });
        
        
     $("#sms_all").click(function() { 
                var errors = "";
                
                var ajax_switch = 2;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                var date2 = $("#datepicker2").val();
                
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
                    url: "loadCollectionsData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2},            
                    success: function(data) {
                        //alert(data);
                        if(data == 1) {  
                            var panel = $('#run1');
                            eval(panel.trigger('click'));  
                        } else {
                            
                        }                     
                    }
                });
            });
	
           

            $("#email_all").click(function() { 
                var errors = "";
                
                var ajax_switch = 3;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                var date2 = $("#datepicker2").val();
                
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
                    url: "loadCollectionsData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, date2: date2},       
                    success: function(data) {
                        //alert(data);
                        if(data == 1) {  
                            var panel = $('#run1');
                            eval(panel.trigger('click'));  
                        } else {
                            
                        }                      
                    }
                });
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
</div>
<div class="leftM4B" id="leftM4B">
<input class="button1" id="run1" name="run1" value="Run Report" type="button"></input><input class="button1" id="print1" name="print1" value="Print Preview" type="button"></input><input class="button1" id="sms_all" name="sms_all" value="SMS All" type="button"></input><input class="button1" id="email_all" name="email_all" value="Email All" type="button"></input>
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




