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
    $clubDrop .="<option value=\"$club_id\">$clubName</option>";
     }
$stmt->close();

$todaysDate = date('m-d-Y');



$table_header = "<table align=\"left\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\" width=100%>
<thead>
<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Counter</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Location</font></th>
<th align=\"left\" bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">First name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Last Name</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Date</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Scheduled Time-In</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Scheduled Time-Out</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock-In Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Clock-Out Time</font></th>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"white\">Variance</font></th>
</tr>
</thead>
<tbody>\n";    

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/attendenceVariances.css">
<link rel="stylesheet" href="../css/zebra.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="../scripts/modernizr.js"></script>
<script src="../scripts/foundation.min.js"></script>
<script src="../scripts/zebra_datepicker.js"></script>
<script>
   $(document).ready(function() {
             //DATEPICKER
            $('input.datepicker').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            //UPDATE CLASS TYPES WHEN CLUB IS SELECTED
            $(".topArea").change(function() {
                var errors = "";
                
                var ajax_switch = 1;
                var clubId = $("#location").val();
                var date = $(".datepicker").val();
                
                var bIn = $("#minsBeforeCin").val();
                var bOut = $("#minsBeforeCout").val();
                var aIn = $("#minsAfterCin").val();
                var aOut = $("#minsAfterCout").val();
               // alert(date);
                //alert(clubId);
                
                if(clubId == "") {
                    errors = errors + "Please select a location.<bt>";
                }
                if(date == "") {
                   errors = errors + "Please select a date.<bt>";
                }
                
                if(errors != "") {
                    $('#msgBox').html('Please fix these errors then continue. <br>'+errors);
                    $("#megBox").css( { "color" : "red"} );
                    return false;
                }
                //alert(clubId);
                $.ajax ({
                    type: "POST",
                    url: "attendenceData.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajax_switch, clubId: clubId, date: date, bIn: bIn, bOut: bOut, aIn: aIn, aOut: aOut},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('.tableArea').html("");   
                            $('.tableArea').html(data);        
                        } else {
                             $('#dataArea').html(""); 
                            $('#msgBox').html('No flags at this location on this date.');
                            $("#msgBox").css( { "color" : "red"} );
                            return false;
                        }                     
                    }
                });
            });
            
            
                               
        });
</script>
</head>
<body>
<div class="topArea">
<h2 class="title">Attendence Variances</h2>
<div class="left" id="left">
Club:  <br><select id="location" name="location">
<option value="0">Choose Option</option>
<option value="1">All Clubs</option>
<?php echo $clubDrop; ?>
</select> 
</div>
<div class="right" id="right">
Date: <span style="display: block; position: relative; float: none; top: auto; right: auto; bottom: auto; left: auto;" class="Zebra_DatePicker_Icon_Wrapper"><input style="position: relative; top: auto; right: auto; bottom: auto; left: auto;" readonly="readonly" class="datepicker" id="datepicker" value="" type="text"><button style="top: 10.5px; left: 201px;" type="button" class="Zebra_DatePicker_Icon Zebra_DatePicker_Icon_Inside">Pick a date</button></span>
</div>
<br>
<div class="leftM" id="leftM">
Minutes Before Check-In:  <br><select id="minsBeforeCin" name="minsBeforeCin">
<option value="0" selected>All Check-Ins</option>
<option value="5">5 Mins Before</option>
<option value="15">15 Mins Before</option>
<option value="30">30 Mins Before</option>
</select> 
</div>
<div class="rightM" id="rightM">
Minutes Before Check-Out:  <br><select id="minsBeforeCout" name="minsBeforeCout">
<option value="0" selected>All Check-Ins</option>
<option value="5">5 Mins Before</option>
<option value="15">15 Mins Before</option>
<option value="30">30 Mins Before</option>
</select> 
</div>
<div class="leftM2" id="leftM2">
Minutes After Check-In:  <br><select id="minsAfterCin" name="minsAfterCin">
<option value="0" selected>All Check-Ins</option>
<option value="5">5 Mins After</option>
<option value="15">15 Mins After</option>
<option value="30">30 Mins After</option>
</select> 
</div>
<div class="rightM2" id="rightM2">
Minutes After Check-Out:  <br><select id="minsAfterCout" name="minsAfterCCout">
<option value="0" selected>All Check-Ins</option>
<option value="5">5 Mins After</option>
<option value="15">15 Mins After</option>
<option value="30">30 Mins After</option>
</select> 
</div>




<span id="msgBox"></span>
</div>

<div class="tableArea">
<?php echo $table_header; ?>
</tbody>
</table>
</div>
</body>
</html>




