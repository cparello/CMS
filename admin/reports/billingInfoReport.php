<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
require"../dbConnect.php";

$batchDrop = "";
$stmt = $dbMain ->prepare("SELECT DISTINCT batch_id, cycle_start_month, cycle_start_day, cycle_start_year, payment_type, club_id FROM batch_recurring_records WHERE batch_id != '' ORDER BY cycle_start_month ASC, cycle_start_day ASC");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($batch_id, $cycle_start_month, $cycle_start_day, $cycle_start_year, $payment_type, $club_id); 
while($stmt->fetch()){
    $stmt55 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt55->execute();      
    $stmt55->store_result();      
    $stmt55->bind_result($club_name); 
    $stmt55->fetch();
    $stmt55->close();
    
    
    $batchDrop .="<option value=\"$batch_id|$payment_type\">$club_name ------ $payment_type ------ $cycle_start_month-$cycle_start_day-$cycle_start_year</option>";
     }
$stmt->close();

$feeDrop = "";
$stmt = $dbMain ->prepare("SELECT DISTINCT payment_type FROM batch_recurring_records WHERE batch_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($payment_type); 
while($stmt->fetch()){
    $feeDrop .="<option value=\"$payment_type\">$payment_type</option>";
     }
$stmt->close();

$todaysDate = date('m/d/Y');




$table_header = "<div id=\"totals\" class=\"totals11\">

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
    console.log("test");
    //var contractKey = $(this).closest('tr').find('#contract_key').text();
    console.log(contractKey);
    var bg= '#282828';
    //var bg = "url(./images/carbon_fibre.png)";
    
    window.parent.document.getElementById('contentHeader').style.backgroundColor = bg;
    
    
    window.parent.document.getElementById('contentHeader').innerHTML = '<div id="tabOne" class="headText headText2">Account Information</div><div id="tabTwo" class="headText">Payment History</div><div id="tabThree" class="headText">Member Information</div><div id="tabFour" class="headText">Notes</div><div id="tabFive" class="headText">Member History</div>';
    
    window.parent.document.getElementById('contentFrame').style.top="38px";
    window.location = "../billing/accountInformation.php?rp_ckey="+contractKey;   
    return false;
}
</script>

<script>
   $(document).ready(function() {
    
           /* $("#contract_key").click(function() { 
                console.log("test");
                var contractKey = $(this).closest('tr').find('#contract_key').text();
                window.location = "accountInformation.php?rp_ckey="+contractKey;   
             }); 
             
             $("#name_click").click(function() { 
                console.log("test");
                var contractKey = $(this).closest('tr').find('#contract_key').text();
                window.location = "accountInformation.php?rp_ckey="+contractKey;   
             }); */
    
             $(".topArea").change(function() {
                var bill_prob = $("#bill_prob").val(); 
                
                if(bill_prob == 'CHECK' || bill_prob == 'STATE'){
                    $('#meth').prop("disabled",true);
                    $('#batch').prop("disabled",true);
                }else{
                    $('#meth').prop("disabled",false);
                    $('#batch').prop("disabled",false);
                }
               }); 
            
            //UPDATE CLASS TYPES WHEN CLUB IS SELECTED
            $("#run1").click(function() { 
                var errors = "";
                
                var ajax_switch = 1;
                //var clubId = $("#location").val();
                var meth = $("#meth").val();
                var batch = $("#batch").val();
                var bill_prob = $("#bill_prob").val(); 
                
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
                    url: "loadBillingInfo.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, meth: meth, batch: batch, bill_prob: bill_prob},               
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
            doc.write("<!DOCTYPE HTML><html><head><title>Renewal Report</title><link rel=\"stylesheet\" type=\"text/css\" href=\"../css/reportTools.css\"></head><body><div class=\"tableArea expand-div\" id=\"tableArea\"><table id=\"listings\" align=\"center\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\" width=100%><thead><tr class=\" tableCenter\"><th style=\"width: 16px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">#</font></th><th style=\"width: 48px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Contract</font></th><th style=\"width: 123px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Name</font></th><th style=\"width: 45px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 26px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 88px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Primary Phone</font></th><th style=\"width: 28px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 189px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Email Address</font></th><th style=\"width: 38px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\"></font></th><th style=\"width: 32px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Reason Code</font></th><th style=\"width: 43px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Reason</font></th><th style=\"width: 43px;\" class=\"header\" align=\"center\" bgcolor=\"#000000\"><font color=\"#FFFFFF\" size=\"1\" face=\"Arial\">Billing Amount</font></th></tr></thead>"+$(printContents).html()+"</table></div></body></html><input type='button' id='btnPrint' class='button1' value='Print' style='float: right;' onclick='window.print();'/>");
            //$("#tableArea").css( { "hieght" : "100%"});
            doc.close();
        });
        
        
     $("#sms_all").click(function() { 
                var errors = "";
                
                var ajax_switch = 2;
              //  var clubId = $("#location").val();
                var meth = $("#meth").val();
                var batch = $("#batch").val();
                var bill_prob = $("#bill_prob").val(); 
                
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
                    url: "loadBillingInfo.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, meth: meth, batch: batch, bill_prob: bill_prob},               
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
              //  var clubId = $("#location").val();
                var meth = $("#meth").val();
                var batch = $("#batch").val();
                var bill_prob = $("#bill_prob").val(); 
                
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
                    url: "loadBillingInfo.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, meth: meth, batch: batch, bill_prob: bill_prob},               
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
Batch Date:<br><select id="batch" name="batch">
<?php echo $batchDrop; ?>
</select> 
</div>
<div class="leftM2B" id="leftM2B">

</div>
<div class="leftM3B" id="leftM3B">
Billing Report:<br> <select name="bill_prob" id="bill_prob">
<option value="0" selected="selected">All Billing Problems</option>
<option value="EXP">Expired Card</option>
<option value="MIS">Missing Info</option>
<option value="STOP">Stop Payment</option>
<option value="DUP">Duplicate Trans</option>
<option value="INV">Invalid Card</option>
<option value="ISS">Issuer Declined</option>
<option value="CHECK">Checks</option>
<option value="STATE">Statements - Cash</option>
<option value="DEC">All Declined</option>
<option value="NSF">All NSF</option>
<option value="NOT">Trans not Permitted</option>
<option value="PICK">Pick Up Card</option>
<option value="1">All active accounts</option>
</select>
</div>
<div class="leftM4B" id="leftM4B">
Payment Method:<br><select id="meth" name="meth">
<option value="0" selected="selected">All Methods</option>
<option value="CC">CC</option>
<option value="ACH">ACH</option>
</select> 
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




