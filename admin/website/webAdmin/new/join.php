<?php
include_once('php/connection.php');
$club_id = $_REQUEST['club_id'];

$stmt = $dbMain ->prepare("SELECT number_memberships, membership1, membership2, membership3, membership4, membership5, membership6, mem1, mem2, mem3, mem4, mem5, mem6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color, box_color_promo, text_color_promo FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($numberMemberships, $membership1, $membership2, $membership3, $membership4, $membership5, $membership6, $mem1, $mem2, $mem3, $mem4, $mem5, $mem6, $descrip1, $descrip2, $descrip3, $descrip4, $descrip5, $descrip6, $boxColor, $textColor, $boxColorPromo, $textColorPromo);
$stmt->fetch();
$stmt->close();

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<style>
.specOff{
    text-align: center;
    font-size: 26px;
    margin-bottom: 30px;
}
.pricing-table .title1 {
    background-color: #<?php echo $boxColor; ?>;
    padding: 0.9375rem 1.25rem;
    text-align: center;
    color: #<?php echo $textColor; ?>;
    font-weight: normal;
    font-size: 1rem;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
}
.pricing-table .title2 {
    background-color: #<?php echo $boxColorPromo; ?>;
    padding: 0.9375rem 1.25rem;
    text-align: center;
    color: #<?php echo $textColorPromo; ?>;
    font-weight: normal;
    font-size: 1rem;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
}
.oBtext{
    background-color: #333;
    padding: 0.9375rem 1.25rem;
    text-align: center;
    color: #EEE;
}

#blanket {
   background-color:#111;
   opacity: 0.65;
   *background:none;
   position:absolute;
   z-index: 9001;
   top:0px;
   left:0px;
   width:100%;
}

#popUpDiv {
	position:absolute;
	background:#333;
	width:400px;
	height:775px;
	border:5px solid #000;
	z-index: 9002;
}

#popUpDiv { a position:relative; top:20px; left:20px}
</style>
    <?php include_once('inc/meta.php'); ?>
     <style>
    p {
    margin-bottom: 0;
    
}
    h1, h2, h3, h4, h5, h6 {
    margin-bottom: 0rem;
}
</style>
    <script>
          $(window).on('beforeunload', function() {
        
  /* $('#error').html('<h4>Get Free Assesment</h4><div class="small-12 large-4 columns"><ul class="pricing-table"><div id="oBox" class="oBox"><div id="oBtext" class="oBtext"><center>SPECIAL OFFER!</center><br>Congratulations! You have been selected to receive<br>a FREE personal training assesment.<br>Please enter the following information below <br>to receive your special offer.</div></div><div id="oBox2" class="oBox2"><p class="formtxt1">Name<br><input name="name" type="text" id="name" value="" size="30" maxlength="50"></p><p class="formtxt2">Email Address<br><input name="email" type="text" id="email" value="" size="30" maxlength="50"><p class="formtxt2">Phone Number<br><input name="phone" type="text" id="phone" value="" size="15" maxlength="15"><p class="formtxt2">North Location&nbsp;<input type="radio" name="location" value="north">&nbsp;&nbsp;Media Center &nbsp;<input type="radio" name="location" value="media"><p class="formtxt3"><input type="submit" name="Get Discount Rate" value="Get Discount Rate" class="button pass"></p></div></ul></div>');*/
   if($("#leaveBool").val() == 0){
        var panel = $('#link');
             eval(panel.trigger('click'));  
            $("#popUpDiv").fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
            return false;
   }else{
     return undefined;
   }
        
        
    });
    
    function toggle(div_id) {
	var el = document.getElementById(div_id);
	if ( el.style.display == 'none' ) {	el.style.display = 'block';}
	else {el.style.display = 'none';}
        }
        function blanket_size(popUpDivVar) {
        	if (typeof window.innerWidth != 'undefined') {
        		viewportheight = window.innerHeight;
        	} else {
        		viewportheight = document.documentElement.clientHeight;
        	}
        	if ((viewportheight > document.body.parentNode.scrollHeight) && (viewportheight > document.body.parentNode.clientHeight)) {
        		blanket_height = viewportheight;
        	} else {
        		if (document.body.parentNode.clientHeight > document.body.parentNode.scrollHeight) {
        			blanket_height = document.body.parentNode.clientHeight;
        		} else {
        			blanket_height = document.body.parentNode.scrollHeight;
        		}
        	}
        	var blanket = document.getElementById('blanket');
        	blanket.style.height = blanket_height + 'px';
        	var popUpDiv = document.getElementById(popUpDivVar);
        	popUpDiv_height=blanket_height/2-200;//200 is half popup's height
        	popUpDiv.style.top = popUpDiv_height + 'px';
        }
        function window_pos(popUpDivVar) {
        	if (typeof window.innerWidth != 'undefined') {
        		viewportwidth = window.innerHeight;
        	} else {
        		viewportwidth = document.documentElement.clientHeight;
        	}
        	if ((viewportwidth > document.body.parentNode.scrollWidth) && (viewportwidth > document.body.parentNode.clientWidth)) {
        		window_width = viewportwidth;
        	} else {
        		if (document.body.parentNode.clientWidth > document.body.parentNode.scrollWidth) {
        			window_width = document.body.parentNode.clientWidth;
        		} else {
        			window_width = document.body.parentNode.scrollWidth;
        		}
        	}
        	var popUpDiv = document.getElementById(popUpDivVar);
        	window_width=window_width/2-200;//200 is half popup's width
        	popUpDiv.style.left = window_width + 'px';
        }
        function popup(windowname) {
        	blanket_size(windowname);
        	window_pos(windowname);
        	toggle('blanket');
        	toggle(windowname);		
        }
        $(document).ready(function() {
             $("#link,#closeLink").click( function () { popup('popUpDiv')});
            
            $('.pass').click(function() { 
               
     
        var guestName = $("#name").val();//document.form1.name.value;
        var emailA = $("#email").val();//document.form1.email.value;
        var phoneNumber = $("#phone").val();//document.form1.phone.value;
        var location = $('input:radio[name=location]:checked').val();
        
        var guestName2 = $("#name").val();//document.form1.name;
        var emailA2 = $("#email").val();//document.form1.email;
        var phoneNumber2 = $("#phone").val();//document.form1.phone;
          // alert();
         var marker = 1;
         var errors = '';
        
        
        if(guestName == "") {
        //alert("Please supply your name");
        errors = errors + 'Please supply your name<br>';
       // guestName2.focus();                          
        //return false;
        }
        
        
        //This validates the email addresses
        var x = emailA;
        emailA = (x.replace(/^\W+/,'')).replace(/\W+$/,'');
        
        
        var at="@";
        var dot=".";
        var lat=emailA.indexOf(at);
        var lstr=emailA.length;
        var ldot=emailA.indexOf(dot);
        if(emailA == "")  {
          //alert("Please supply a email address");
          errors = errors + 'Please supply your email address<br>';
          //txt.innerHTML= '<p class="valid">Please supply your email address</p>';
         // emailA2.focus();                          
        //  return false;
         }
		if(emailA.indexOf(at)==-1){
		   //alert("You have entered an invalid email address");
           errors = errors + 'You have entered an invalid email address<br>';
		   // txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
          // emailA2.focus();
		  // return false;
		}
		if(emailA.indexOf(at)==-1 || emailA.indexOf(at)==0 || emailA.indexOf(at)==lstr){
		   //alert("You have entered an invalid email address");
           errors = errors + 'You have entered an invalid email address<br>';
		 //  txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
        //   emailA2.focus();
		 //  return false;
		}
		if(emailA.indexOf(dot)==-1 || emailA.indexOf(dot)==0 || emailA.indexOf(dot)==lstr){
		 //  txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
           errors = errors + 'You have entered an invalid email address<br>';
           //emailA2.focus();
		//    return false;
		}
		 if(emailA.indexOf(at,(lat+1))!=-1){
		    //txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
            errors = errors + 'You have entered an invalid email address<br>';
         //   emailA2.focus();
		   // return false;
		 } 
      
		 if(emailA.substring(lat-1,lat)==dot || emailA.substring(lat+1,lat+2)==dot){
		   // txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
            errors = errors + 'You have entered an invalid email address<br>';
          ////  emailA2.focus();
		   // return false;
		 }
		 if(emailA.indexOf(dot,(lat+2))==-1){
		  //  txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
            errors = errors + 'You have entered an invalid email address<br>';
           // emailA2.focus();
		  //  return false;
		 }
		 if(emailA.indexOf(" ")!=-1){
		  //  txt.innerHTML= '<p class="valid">You have entered an invalid email address</p>';
            errors = errors + 'You have entered an invalid email address<br>';
           // emailA2.focus();
		   // return false;		 
         }
        if(phoneNumber == "") {
        //txt.innerHTML= '<p class="valid">Please enter your phone number</p>';
        errors = errors + 'Please enter your phone number<br>';
       // phoneNumber2.focus();                          
       // return false;
        }
         if (($('input:radio[name=location]:checked').val() != 'media' ) && ( $('input:radio[name=location]:checked').val() != 'north' )) {
                //txt.innerHTML= '<p class="valid">Please select a BAC location</p>';
                errors = errors + 'Please select a BAC location<br>';
                //return false;
                }
                
                if(errors != ''){
                    $("#msgBox").html(errors);
                    $("#msgBox").css( { "color" : "red"} );
                    return false;
                }
        
     $.ajax ({
                 type: "POST",
                 url: "php/guest3.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {name: guestName, email: emailA, phone: phoneNumber, location:location, marker: marker},              
                 success: function(data) {    
                 //alert(data);
                         
                    if(data != 1) {
                       $('#popUpDiv').html(data)
                       }else{
                        $("#msgBox").html('ERROR: ');
                        $("#msgBox").css( { "color" : "red"} );
                       }
                     }//end function success
              }); //end ajax  
  });
  
            $('.qty').click(function() {
                $(this).parents().eq(2).find('.qty').val(1);
                 var qty = 1;
                var cost = $(this).parents().eq(2).find('.cost').attr('rel');
                var proc = $(this).parents().eq(2).find('#procFee').html();
                var proRate = $(this).parents().eq(2).find('#prorate').html();
                var first = $(this).parents().eq(2).find('#firstMonth').html();
                var last = $(this).parents().eq(2).find('#lastMonth').html();
                var monthFee = $(this).parents().eq(2).find('#monthFee').val();
                
                
                var term_cost = $(this).parents().eq(2).find('input[type=radio]:checked').attr('rel');
                if(isNaN(proc)){
                    proc = 0;
                }
                monthFee = parseFloat(monthFee);
                proc = parseFloat(proc);
                cost = parseFloat(cost);
                term_cost = parseFloat(term_cost);
                qty = parseFloat(qty);
                if(isNaN(proRate)){
                    proRate = 0;
                }
                proRate = parseFloat(proRate);
                if(isNaN(first)){
                    first = 0;
                }
                first = parseFloat(first);
                if(isNaN(last)){
                    last = 0;
                }
                last = parseFloat(last);
                //alert(proc);
                //alert(cost);
                //alert(term_cost);
               // alert(qty);
                //alert(proRate);
                //alert(first);
                //alert(last);
                if (term_cost) {
                    var amount = qty*(term_cost+proc+proRate+first);
                    amount = amount.toFixed(2);
                    $(this).parents().eq(2).find('.total').html('$'+amount);
                } else {
                    var amount = qty*(monthFee+proc+proRate+first);
                    amount = amount.toFixed(2);
                    $(this).parents().eq(2).find('.total').html('$'+amount);
                }
 
            });
  
  
            //UPDATE TOTAL WHEN QTY IS CHANGED
            $('.qty').change(function() {
                var qty = $(this).val();
                var cost = $(this).parents().eq(2).find('.cost').attr('rel');
                var proc = $(this).parents().eq(2).find('#procFee').html();
                var proRate = $(this).parents().eq(2).find('#prorate').html();
                var first = $(this).parents().eq(2).find('#firstMonth').html();
                var last = $(this).parents().eq(2).find('#lastMonth').html();
                var monthFee = $(this).parents().eq(2).find('#monthFee').val();
                
                
                var term_cost = $(this).parents().eq(2).find('input[type=radio]:checked').attr('rel');
                if(isNaN(proc)){
                    proc = 0;
                }
                monthFee = parseFloat(monthFee);
                proc = parseFloat(proc);
                cost = parseFloat(cost);
                term_cost = parseFloat(term_cost);
                qty = parseFloat(qty);
                if(isNaN(proRate)){
                    proRate = 0;
                }
                proRate = parseFloat(proRate);
                if(isNaN(first)){
                    first = 0;
                }
                first = parseFloat(first);
                if(isNaN(last)){
                    last = 0;
                }
                last = parseFloat(last);
                //alert(proc);
                //alert(cost);
                //alert(term_cost);
               // alert(qty);
                //alert(proRate);
                //alert(first);
                //alert(last);
                if (term_cost) {
                    var amount = qty*(term_cost+proc+proRate+first);
                    amount = amount.toFixed(2);
                    $(this).parents().eq(2).find('.total').html('$'+amount);
                } else {
                    var amount = qty*(monthFee+proc+proRate+first);
                    amount = amount.toFixed(2);
                    $(this).parents().eq(2).find('.total').html('$'+amount);
                }
            });
            
            //UPDATE TOTAL WHEN OPTION IS CHANGED
            $('.option').click(function() {
                var qty = $(this).parents().eq(2).find('.qty').val();
                var cost = $(this).attr('rel');
                var term_length = $(this).val();
                $(this).parents().eq(2).find('.total').html('$'+qty*cost);
                $(this).parents().eq(2).find('.term_cost').html(cost);
                if(term_length == 26){
                    $(this).parents().eq(2).find('.term_text').html('for '+term_length+' Weeks');
                }else{
                    $(this).parents().eq(2).find('.term_text').html('for '+term_length+' Year');
                }
                
            });
            
            //submit
             $('.buy').click(function() {
                $("#leaveBool").val(1);
                var isMember = $("#alreadyMember").val();
                var total = $(this).parents().eq(2).find('.total').html();
                var serviceName = $(this).parents().eq(2).find('.name').html();
                 var termBool = $(this).parents().eq(2).find('#termBool').val();
                if (termBool == 'Y'){
                    var numberYears = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                }
                var proc = $(this).parents().eq(2).find('#procFee').html();
                var proRate = $(this).parents().eq(2).find('#prorate').html();
                var first = $(this).parents().eq(2).find('#firstMonth').html();
                var last = $(this).parents().eq(2).find('#lastMonth').html();
                var qty = $(this).parents().eq(2).find('.qty').val();
                var serviceKey = $(this).parents().eq(2).find('#serviceKey').val();
                var monthPassThru = $(this).parents().eq(2).find('#monthPassThru').val();
                  //alert(monthPassThru);
                total = total.replace("$", "");
                /*alert(total);
                alert(termBool);
                alert(qty);
                alert(serviceKey);
                alert(serviceName);
                alert(numberYears);*/
               /* if(isMember == 0)  {
                    var answer1 = confirm("You are not logged in! If you are already a member please click cancel and login to your account first. If you are not a member click ok to continue. Do you wish to continue?");
                    if (!answer1) {
                        return false;
                    }           
                }*/
                  //alert(total);    
                 if(total == 'TOTAL'){
                    //alert('Please select a package and enter the quantity first, then click BUY NOW again.');
                    $(this).parents().eq(2).find('#error').html('Please fill in the "QTY" for this service before you click "BUY"');
                    $(this).parents().eq(2).find('#error').css( { "color" : "red"} );
                     //$("#error").html('You must select the quantity of this service before you click "BUY"');
                    return false;
                 }
                 
                 location.href = 'membershipSalesForm.php?service_name='+serviceName+'&num_years='+numberYears+'&total='+total+'&qty='+qty+'&serviceKey='+serviceKey+'&proc='+proc+'&proRate='+proRate+'&first='+first+'&last='+last+'&monthPassThru='+monthPassThru; 
            });
        });
    </script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Join</h1></div>
    <div class="row">
     <div id="blanket" style="display:none;"></div>
	<div id="popUpDiv" style="display:none;">
    
    	<a href="#" id="closeLink" >X Close Special Offer</a>
        <h4 class="oBtext">Get Discount Rate</h4><div id="oBox" class="oBox"><div id="oBtext" class="oBtext"><center>SPECIAL OFFER!</center><br>Congratulations! You have been selected to receive<br>a special discounted rate.<br>Please enter the following information below <br>to receive your special offer.</div></div><div id="oBox2" class="oBox2"><p class="oBtext">Name<br><input name="name" type="text" id="name" value="" size="30" maxlength="50"></p><p class="oBtext">Email Address<br><input name="email" type="text" id="email" value="" size="30" maxlength="50"><p class="oBtext">Phone Number<br><input name="phone" type="text" id="phone" value="" size="15" maxlength="15"><p class="oBtext">North Location&nbsp;<input type="radio" name="location" value="north">&nbsp;&nbsp;Media Center &nbsp;<input type="radio" name="location" value="media"><p class="oBtext"><span id="msgBox"></span><input type="submit" name="Get Discount Rate" value="Get Discount Rate" class="button pass"></p></div>
    </div>
    <div class="specOff">
     <a id="link"><b><b>SPECIAL OFFER!</b></b></a>
    </div>	
  
    </div>
    <div class="row2">
    <span id="specialOffer"></span>
    </div>
    <?php
    if (!isset($_SESSION['userContractKey'])) {
        $alreadyMember = 0;
    } else {
        $alreadyMember = 1;
    }
    
    $stmt = $dbMain ->prepare("SELECT number_memberships, membership1, membership2, membership3, membership4, membership5, membership6, mem1, mem2, mem3, mem4, mem5, mem6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color FROM website_membership_options WHERE web_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($numberMemberships, $membership1, $membership2, $membership3, $membership4, $membership5, $membership6, $mem1, $mem2, $mem3, $mem4, $mem5, $mem6, $descrip1, $descrip2, $descrip3, $descrip4, $descrip5, $descrip6, $boxColor, $textColor);
    $stmt->fetch();
    $stmt->close();
    
    
    $memPromoArr = array($mem1, $mem2, $mem3, $mem4, $mem5, $mem6);
    //echo "test";
    $stmt = $dbMain ->prepare("SELECT process_fee_single, process_fee_single_two FROM fees WHERE fee_num = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($monthly_process_fee, $pif_process_fee);
    $stmt->fetch();
    $stmt->close();

    $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($homeClubName);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT billing_setup FROM billing_setup WHERE setup_id = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($billing_setup);
    $stmt->fetch();
    $stmt->close();

    if ($monthly_process_fee != '0.00') {
        $monthlyProcessFeeHtml1 = "Processing Fee:  $<span id=\"procFee\">$monthly_process_fee</span>";
        } else {
        $monthlyProcessFeeHtml1 = "";
    }

    if ($pif_process_fee != '0.00') {
        $pifProcessFeeHtml1 = "Processing Fee:  $<span id=\"procFee\">$pif_process_fee</span>";
        } else {
        $pifProcessFeeHtml1 = "";
    }

    //GET MEMBERSHIP COUNT FOR COLUMN LAYOUT
    if($membership1) $membership_count = 1;
    if($membership2) $membership_count = 2;
    if($membership3) $membership_count = 3;
    if($membership4) $membership_count = 4;
    if($membership5) $membership_count = 5;
    if($membership6) $membership_count = 6;
	
	for ($i=1; $i<$numberMemberships+1; $i++) {
	   $x = $i-1;
	    if($memPromoArr[$x] == 1){
	       $promoHiglight = "title2";
           $promoText = "<h4><b><b><center>Promo Price</center></b></b></h4>";
	    }else{
	       $promoHiglight = "title1";
           $promoText = "";
	            }
        $yearRadioButtons1 = ''; //RESET AS TO NOT REPEAT FROM PREVIOUS LOOP
        $buttons = ''; //RESET AS TO NOT REPEAT FROM PREVIOUS LOOP
        $memArray1 = explode('-',${"membership" . $i});
        $memArray1[0] = trim($memArray1[0]);
        $mem1 = $memArray1[0];
        $loc1 = $memArray1[1];
        if (preg_match('/All/i',$memArray1[1])) {
            $clubIdLocal = "0";
            $club_name1 = "All Locations";
        } else {
            $clubIdLocal = "$club_id";
            $club_name1 = $homeClubName;
        }

        if (preg_match('/monthly/i',$mem1)) {
            $sql1 = "AND service_quantity = '12'";
        } else {
            $sql1 = "AND service_quantity = '1'";
        }

        $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem1' $sql1 AND club_id = '$clubIdLocal'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($service_key1, $service_type1, $club_id1, $service_cost1, $service_term1, $service_quantity1);
        $stmt->fetch();
        $rowCount1 = $stmt->num_rows;
        $stmt->close();

        if ($rowCount1 == 0) {
            $loc1 = trim($loc1);
            $stmt = $dbMain-> prepare("SELECT club_id FROM club_info WHERE club_name = '$homeClubName'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($club_id_servicefix);
            $stmt->fetch();
            $stmt->close();

            $club_name1 = $loc1;
            $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '$mem1' $sql1 AND club_id = '$club_id_servicefix'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($service_key1, $service_type1, $club_id1, $service_cost1, $service_term1, $service_quantity1);
            $stmt->fetch();
            $stmt->close();
        }

        if ($service_term1 == "M") {
            
            $cost1 = sprintf("%.2f", $service_cost1/$service_quantity1);
            $priceText1 = "a month for<span id=\"pifYears1\"> 12 Months</span>";
            $monthly_amount = trim($cost1);
            $current_day_number = date(d);
            $month_days_number = date(t);
            $daily_amount = $monthly_amount / $month_days_number;
            $date_difference = $month_days_number - $current_day_number;
            $pro_rate_amount = $date_difference * $daily_amount;
            $pro_rate_amount1 = sprintf("%.2f", $pro_rate_amount);

            if ($pro_rate_amount == "" || $pro_rate_amount == 0) {
                $pro_rate_amount = '0.00';
            }
           
            switch($billing_setup){
                case '1':
                 $proc1 = $monthlyProcessFeeHtml1;
                 $proRateHtml1 =  "<br><small><span class=\"prorate\">Prorate Fee: $<span id=\"prorate\">$pro_rate_amount1</span></span></small>";
                 $monthlyPaymentHtml1 =  "";
                 $monthlyPaymentHtml2 =  "";
                 $monthFee = 0;
                break;
                case '2':
                 $proc1 = $monthlyProcessFeeHtml1;
                 $proRateHtml1 =  "<br><small><span class=\"prorate\">Prorate Fee: $<span id=\"prorate\">$pro_rate_amount1</span></span></small>";
                 $monthlyPaymentHtml1 =  "<br><small><span class=\"firstMonth\">First Month: $<span id=\"firstMonth\">$monthly_amount</span></span></small>";
                 $monthlyPaymentHtml2 =  "";
                 $monthFee = 0;
                break;
                case '3':
                 $proc1 = $monthlyProcessFeeHtml1;
                 $proRateHtml1 =  "";
                 $monthlyPaymentHtml1 =  "<br><small><span class=\"firstMonth\">First Month: $<span id=\"firstMonth\">$monthly_amount</span></span></small>";
                 $monthlyPaymentHtml2 =  "";
                 $monthFee = 0;
                break;
                case '4':
                 $proc1 = "";
                 $proRateHtml1 =  "";
                 $monthlyPaymentHtml1 =  "<br><small><span class=\"firstMonth\">First Month: $<span id=\"firstMonth\">$monthly_amount</span></span></small>";
                 $monthlyPaymentHtml2 =  "<br><small><span class=\"lastMonth\">Last Month: $<span id=\"lastMonth\">$monthly_amount</span></span></small>";
                 $monthFee = $monthly_amount;
                break;
                case '5':
                 $proc1 = "";
                 $proRateHtml1 =  "<br><small><span class=\"prorate\">Prorate Fee: $<span id=\"prorate\">$pro_rate_amount1</span></span></small>";
                 $monthlyPaymentHtml1 =  "";
                 $monthlyPaymentHtml2 =  "";
                 $monthFee = 0;
                break;
            }
        } else {
            $proc1 = $pifProcessFeeHtml1;
            $cost1 = $service_cost1;
            $priceText1 = "for <span id=\"pifYears1\">1 Year</span> ";
            $proRateHtml1 = "";
            $pro_rate_amount1 = "";
            $monthlyPaymentHtml1 =  "";
            $monthlyPaymentHtml2 =  "";
            
            $stmt = $dbMain-> prepare("SELECT service_cost, service_quantity, service_term FROM service_cost WHERE service_key = '$service_key1'  ORDER BY service_cost DESC");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($service_cost, $service_quantity, $service_term);
            
            $while_counter = 1;
            while ($stmt->fetch()) {
                if($while_counter == 1){
                    $checked = "checked=\"checked\"";
                }else{
                    $checked = "";
                }
                
                if($service_term == 'Y' AND $service_quantity <= '1'){
                    $buttons .= '<input type="radio" name="yearOptions' . $i . '" value="' . $service_quantity . '" class="option" rel="' . $service_cost . '" style="margin-left:5px;" ' . $checked .'> ' . $service_quantity . ' Year</input>';
                    $while_counter++;
                    }elseif($service_term == 'M' AND $service_quantity <= '12'){
                        $buttons .= '<input type="radio" name="yearOptions' . $i . '" value="' . $service_quantity . '" class="option" rel="' . $service_cost . '" style="margin-left:5px;" ' . $checked .'> ' . $service_quantity . ' Months</input>';
                        $while_counter++;
                        }elseif($service_term == 'W' AND $service_quantity <= '52'){
                        $buttons .= '<input type="radio" name="yearOptions' . $i . '" value="' . $service_quantity . '" class="option" rel="' . $service_cost . '" style="margin-left:5px;" ' . $checked .'> ' . $service_quantity . ' Weeks</input>';
                        $while_counter++;
                        }elseif($service_term == 'D' AND $service_quantity <= '365'){
                        $buttons .= '<input type="radio" name="yearOptions' . $i . '" value="' . $service_quantity . '" class="option" rel="' . $service_cost . '" style="margin-left:5px;" ' . $checked .'> ' . $service_quantity . ' Days</input>';
                        $while_counter++;
                        }
                        $service_cost = "";
                        $service_quantity = "";
                        $service_term = "";
                        }
            $stmt->close();
        };
        
        if($i==1 OR $i==4) {
            echo '<div class="row">';
        }
        
        echo '<div class="small-12 large-4 columns">
                ' . $promoText . '
            <ul class="pricing-table">
                <li class="name ' . $promoHiglight . '">' . $service_type1 . ' - ' . $club_name1 . '</li>
                <li class="description">' . ${"descrip" . $i} . '</li>
                <li class="price cost" rel="' . $cost1 . '">$<span class="term_cost">' . $cost1 . '</span><br><small><span class="term_text">' . $priceText1 . '</span></small><br><small><span class="proc_text">' . $proc1 . '</span></small>' . $proRateHtml1 . '' . $monthlyPaymentHtml1 . '' . $monthlyPaymentHtml2 . '<input name="monthFee" id="monthFee" value="'.$monthFee.'" type="hidden"><input name="monthPassThru" id="monthPassThru" value="'.$monthly_amount.'" type="hidden"></li>';
            if ($service_term1 == 'Y') echo '<li class="bullet-item options">' . $buttons . '</li>';
                echo '<li class="bullet-item text-center">QTY<br><input type="text" value="0" class="qty text-center"></li>
                <li class="price total">TOTAL</li>
                <span id="error"></span>
                <li class="cta-button"><a class="button buy" href="#">Buy Now</a></li>
                <input name="serviceKey" id="serviceKey" value="'.$service_key1.'" type="hidden">
                <input name="termBool" id="termBool" value="'.$service_term1.'" type="hidden">
            </ul>
        </div>';

        if($i==3 OR $i==$membership_count) {
            echo '</div>';
        }
        echo '<input name="alreadyMember" id="alreadyMember" value="'.$alreadyMember.'" type="hidden">';
    };
    ?>
    
    <?php include_once('inc/footer.php'); ?>
    <input name="leaveBool" id="leaveBool" value="0" type="hidden">
</body>
</html>