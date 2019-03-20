<?php
include_once('php/connection.php');
$_SESSION['admin_access'] = "yes";
$clubDrop = "";
$stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id); 
while ($stmt->fetch()) {
    $clubName = trim($clubName);
    $clubDrop .= '<option value="' . $club_id . '">' . $clubName . '</option>';
}

include "php/liabilitySql.php";
$liabilitySql = new liabilitySql();
$liabilitySql-> loadLiabilityDefaults();
$liability_terms = $liabilitySql-> getLiabilityTerms();


?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    #msgBox{
        text-align: center;
    }
    .scroller_tbl{
        height: 200px;
    }
    #class-time{
        text-decoration: underline;
        font: bold;
        font-weight: 800;
    }
    #class-name{
        text-decoration: underline;
        font: bold;
        font-weight: 800;
    }
    #instructor{
        font-size: 0.675rem;
    }
    .length{
        font-size: 0.675rem;
    }
    #booking_count{
        font-size: 0.675rem;
    }
    .roomName{
        font-size: 0.675rem;
    }
    .full{
       font-weight: 800;
    }
    .oBtext3{
        text-align: center;
    }
    .black2{
        text-align: center;
        font-weight: 800;
    }
    button, .button {
        margin: 20px 0px 1.25rem;
        padding: 10px 10px;
    }
    a {
        color: #000;
    }
    .cancColor{
        color: #00F;
    }
    .bookColor{
        color: #00F;
    }
    </style>
                <script>
function someFunc() {
    if (1==2) {
        return true;
    } else {
        return false;
    }
}
</script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Class Schedule</h1>
    </div>
    
    <div class="row">
        <form>
            <div class="small-12 large-3 columns">
                <label>Club
                    <select id="location" name="location">
                        <option value="">Select a Club</option>
                        <?php echo $clubDrop ?>
                    </select>
                </label>
            </div>
            
            <div class="small-12 large-3 columns">
                <label>Date
                    <input type="text" class="datepicker" value="<?php echo date('m/d/Y'); ?>">
                   
                </label>
            </div>
            
            <div class="small-12 large-3 columns">
                <label>Classes
                    <select id="schedule_type" class="schedule_type">
                        <option value="">Select a Category First</option>
                    </select>
                </label>
            </div>
            
            <div class="small-12 large-3 columns">
                <button type="submit" class="button expand" id="get-classes"><i class="fa fa-search"></i> Search</button>
            </div>
            <span id="msgBox"></span>
            <input type="hidden" name="schedule_id" id="schedule_id" value="">
            <input type="hidden" name="bundle_id" id="bundle_id" value="">
            <input type="hidden" name="class_text" id="class_text" value="">
            <input type="hidden" name="type_id" id="type_id" value="1">
            <input type="hidden" name="location_id" id="location_id" value="">
            <input type="hidden" name="time_slot" id="time_slot" value="">
            <input type="hidden" name="booking_count" id="booking_count" value="">
            <input type="hidden" id="purchase_marker" name="purchase_marker" value="">
            <input type="hidden" id="dataBool" name="dataBool" value="">
            <input type="hidden" id="class_date" name="class_date" value="">
            
        </form>
    </div>
    
    <div class="row">
        <div class="small-12 large-12 columns" id="class-list">
        <table id="listings" class="tablesorter" align="left" border="0" rules="none"  cellspacing="0" cellpadding="3" width="100%"> 
        <thead>
        <tr class="tabHead">
        <th class="oBtext3">   
        Monday
        </th>
        <th class="oBtext3">
        Tuesday
        </th>
        <th class="oBtext3">
        Wednesday
        </th>
        <th class="oBtext3">
        Thursday
        </th>
        <th class="oBtext3">
        Friday
        </th>
        <th class="oBtext3">
        Saturday
        </th>
        <th class="oBtext3">
        Sunday
        </th>
        </tr>
        </thead>
        <tbody>
            <p><strong>Please select a club, date and class above to view the class schedule.</strong></p>
            </tbody>
        </table>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 columns spacerChange" style="height:400px;"></div>
    </div>
    <?php include_once('inc/footer.php'); ?>
    
    <!--BOOK CLASS MODAL-->
    <div id="book-class" class="reveal-modal" data-reveal>
        <div class="row">
            <div class="small-12 large-6 columns">
            	<form id="form1" onsubmit="return someFunc()">
                <div class="panel">
                    <h3>Book Class</h3>
                    <p id="class-info"><strong>Vinyassa Flow</strong><br>
                    04/16/2015 12:00 PM</p>
                </div>
                
                <h4>Member/Non-Member ID</h4>
                <div class="row collapse postfix-radius">
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-barcode"></i></span>
                    </div>
                    <div class="small-11 columns">
                    <input type="text" name="memberId" placeholder="Enter your Barcode here" id="memberId">
                    <input name="non_member" id="non_member" value="" type="checkbox"></input>&nbsp;&nbsp;I am not a Member and I do not have a barcode yet.
                    <span id="msgBox2"></span>
                    <span id="radioBox"></span>
                    </div>
                    <div class="small-12 column">
                        <input type="hidden" name="schedule_id" id="schedule_id" value="">
                        <input type="hidden" name="bundle_id" id="bundle_id" value="">
                        <input type="hidden" name="class_text" id="class_text" value="">
                        <input type="hidden" name="class_name" id="class_name" value="">
                        <input type="hidden" name="type_id" id="type_id" value="">
                        <input type="hidden" name="location_id" id="location_id" value="">
                        <input type="hidden" name="time_slot" id="time_slot" value="">
                        <input type="hidden" name="booking_count" id="booking_count" value="">
                        <input type="hidden" id="purchase_marker" name="purchase_marker" value="">
                        <input type="hidden" id="action" name="action" value="">
                        <input type="hidden" id="contract_key" name="contract_key" value="">
                        <input type="hidden" id="transaction_key" name="transaction_key" value="">
                        <input type="submit" name="bookClass" id="bookClass" value="Book Class" class="button">
                    </div>
                </div>
                </form>
            </div>
            
            <div class="small-12 large-6 columns">
                <h3><span id="nonMemMem">Member</span> Information</h3>
                
                <strong>Contact Info</strong>
                <div class="row">
                    <div class="small-6 large-6 columns">
                    <input type="text" id="sm_fname" value="" placeholder="First Name">
                    <input type="text" id="sm_email" value="" placeholder="Email">
                    </div>

                    <div class="small-6 large-6 columns">
                    <input type="text" id="sm_lname" value="" placeholder="Last Name">
                    <input type="text" id="sm_phone" value="" placeholder="Phone Number">
                    </div>
                </div>

                <strong>Credit Card Payment</strong>
                <select  name="card_type" id="card_type">
                    <option value>Card Type</option>
                    <option value="Visa" >Visa</option>
                    <option value="MC" >MasterCard</option>
                    <option value="Amex" >American Express</option>
                    <option value="Disc" >Discover</option>
                </select>
                <input name="card_name" type="text" id="card_name" value="" placeholder="Name on Card">
                <input name="card_number" type="text" id="card_number" value="" placeholder="Card Number">
                <input name="card_cvv" type="text" id="card_cvv" value="" placeholder="Security Code">
                
                <div class="row">
                    <div class="small-6 large-6 columns">
                        <label>Exp. Month
                        <select name="card_month" id="card_month">
                            <option value="">Month</option>
                            <option value="01" >January</option>
                            <option value="02" >February</option>
                            <option value="03" >March</option>
                            <option value="04" >April</option>
                            <option value="05" >May</option>
                            <option value="06" >June</option>
                            <option value="07" >July</option>
                            <option value="08" >August</option>
                            <option value="09" >September</option>
                            <option value="10" >October</option>
                            <option value="11" >November</option>
                            <option value="12" >December</option>
                        </select>
                        </label>
                    </div>
                    
                    <div class="small-6 large-6 columns">
                        <label>Exp. Year
                        <select name="card_year" id="card_year">
                            <option value="">Year</option>
                            <option value="15" >2015</option>
                            <option value="16" >2016</option>
                            <option value="17" >2017</option>
                            <option value="18" >2018</option>
                            <option value="19" >2019</option>
                            <option value="20" >2020</option>
                            <option value="21" >2021</option>
                            <option value="22" >2022</option>
                            <option value="23" >2023</option>
                            <option value="24" >2024</option>
                            <option value="25" >2025</option>
                            <option value="26" >2026</option>
                            <option value="27" >2027</option>
                            <option value="28" >2028</option>
                        </select>
                        </label>
                    </label>
                    </div>
                </div>
                <input type="hidden" name="credit_pay" id="credit_pay" value="">
                
                <div class="row margin">
    	<h3>Class Waiver</h3>
        <div style="border:1px solid #c9c9c9; overflow:scroll; height:125px; width:100%"><p><?php echo $liability_terms;?></p>
        </div>
        <input  tabindex="90" type="checkbox" name="terms_conditions" id="terms_conditions"  value=""/> I've read & agreed to Burbank Athletic Club's Class Waiver.
    </div>
                
                <span id="msgBox5"></span>
                <input type="button" name="purchase_class" id="purchase_class" value="Process Payment" class="button small">
                <input type="button" name="print_receipt" id="print_receipt" value="Print Receipt" class="button small">
                <input type="button" name="waiver" id="waiver" value="Print Waiver" class="button small">
                <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=HMhTdG4LpgKmCFiXrmkdxZolqMhZjoAKMExZVVo0kJCGHYzZVPkcryx1k1ET"></script></span>
        
              
            </div>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    
    <!--CANCEL CLASS MODAL-->
    <div id="cancel-class" class="reveal-modal small" data-reveal>
        <div class="row">
            <form  onsubmit="return someFunc()" id="form2" >
            <div class="small-12 large-12 columns">
                <div class="panel">
                    <h3>Cancel Class</h3>
                    <p><strong>Vinyassa Flow</strong><br>
                    04/16/2015 12:00 PM</p>
                </div>
                
                <h4>Member ID</h4>
                <div class="row collapse postfix-radius">
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-barcode"></i></span>
                    </div>
                    <div class="small-11 columns">
                    <input type="text" name="memberIdCanc" placeholder="Barcode" id="memberIdCanc" required>
                    <span id="msgBox3"></span>
                    </div>
                    
                    <div class="small-12 column">
                        <input type="submit" name="cancelClass" id="cancelClass" value="Cancel Class" class="button">
                    </div>
                </div>
            </div>
            </form>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
    
    <script src="js/zebra_datepicker.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
    <script type="text/javascript" src="js/jquery.tablesorter.scroller2.js"></script> 
   
	<script>
        $(document).ready(function() {
            
              
           /* var radBox = $('input:radio[name=sessions]:checked');
              radBox.on('change', function(){
                alert();
                        var servBuff = $('input:radio[name=sessions]:checked').val(); 
                        var serviceArray = servBuff.split(",");
                        serviceCost = serviceArray[0];
                        serviceKey = serviceArray[1];               
                        $('#credit_pay').val(serviceCost);                        
                
            });*/
            
            //DATEPICKER
            $('input.datepicker').Zebra_DatePicker({
				format: 'm/d/Y'
			});
            
            //UPDATE CLASS TYPES WHEN CLUB IS SELECTED
            $("#location").change(function() {
                
                var ajaxSwitch = 1;
                var clubId = $("#location").val();
                
                if(clubId == "") {
                    $('#msgBox').html('Please select a club.');
                    $("#megBox").css( { "color" : "red"} );
                    return false;
                }
                //alert(clubId);
                $.ajax ({
                    type: "POST",
                    url: "php/getClasses.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajaxSwitch, clubId: clubId},               
                    success: function(data) {
                        //alert(data);
                        if(data != "") {  
                            //alert('fu1');
                            $('#schedule_type').html(data);        
                        } else {
                            $('#msgBox').html('No classes at this location.');
                            $("#msgBox").css( { "color" : "red"} );
                            return false;
                        }                     
                    }
                });
            });
            
            //GET CLASSES ON SUBMIT==============================================================================================================
			$('#get-classes').click(function() {
				var clubId = $("#location").val();
                var errors = "";
				   
				if (clubId == "") {
					//alert('Please select a club first.');
					//return false;
                    errors = errors + "Please select a club first.<br>";
				}
				
				var ajaxSwitch =1;
				var eventDate = $(".datepicker").val();
				var scheduleType = $("#schedule_type").val();
				//scheduleTypeArray = scheduleTypeArray.split(",");
				//var scheduleType = scheduleTypeArray[0];
				//var locationId =  scheduleTypeArray[1];
				
				//alert(eventDate);
				if (eventDate == "") {
					//alert('Please provide a date for this session');
					//return false;
                    errors = errors + "Please provide a date for this session.<br>";
				} else {
					var date_regex = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(19|20)\d{2}$/;
					if(!(date_regex.test(eventDate))) {
						//alert('The date you entered is not in the correct format.  Please use \"mm/dd/yyyy\" ');
						//return false;
                        errors = errors + "The date you entered is not in the correct format.  Please use \"mm/dd/yyyy\" <br>";
					}                    
				}
				
				if (scheduleType == "") {
					//alert('Please select a \"Schedule Category\"');
					//return false;
                    errors = errors + "Please select a \"Schedule Category\".<br>";
				}
                
                //if(document.getElementById('week_grid').checked == true){
                    var ajaxSwitch =2;
               // }
                
                if(errors !=""){
                     $('#msgBox').html('Please fix these errors first.<br> ' +errors);
                     $("#msgBox").css( { "color" : "red"} );
                     $("#msgBox").css( { "text-align": "center"} );
                     return false;
                }
				
				//$("#type_id").val(scheduleType);
				//$("#location_id").val(locationId);
				
				//alert('fu');
				$.ajax ({
					type: "POST",
					url: "php/loadClassList.php",
					cache: false,
					dataType: 'html', 
					data: {ajax_switch: ajaxSwitch, schedule_type: scheduleType, event_date: eventDate, clubId: clubId},
					success: function(data) {  
					//	alert(data);
						var dataArray = data.split('|');                        
						var successBit = dataArray[0]; 
						var listings = dataArray[1];
						
						if (successBit == 1) {    
						  $('#msgBox').html("");
							$("#class-list").html(listings);
                             $(".spacerChange").css( { "height" : "0px"} );
                            
						//	$("#listings").tablesorter();
						//	$('#listings.tablesorter').tablesorter({
						//		scrollHeight: 600,
						//		widgets: ['scroller']
						//	});                 
						} else {
							//alert(data);
                            $('#msgBox').html('Failed ' +data);
                             $("#msgBox").css( { "color" : "red"} );
                             return false;
						}                     
					},
					error: function() {$('#msgBox').html('There was an error.');
                                         $("#megBox").css( { "color" : "red"} );
                                         return false;}
				});
				return false;
			}); //END GET CLASSES ON SUBMIT
            //======================================================================================================================================
          
                               
        });
    </script>
   <script src="js/printClassReciept21.js"></script>
   <script src="js/bookv35.js"></script> 
   <script src="js/cancelClassv32.js"></script>   
   <script src="js/processClassPurchase32.js"></script> 
</body>
</html>
