<?php
include_once('php/connection.php');
include "../../../dbConnect.php";
$get_club_id = $_GET['club'];
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<style>
#error{
    text-align: center;
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
                 url: "php/guest2.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {name: guestName, email: emailA, phone: phoneNumber, location:location, marker: marker},              
                 success: function(data) {    
                // alert(data);
                         
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
                var cost = $(this).parents().eq(2).find('input[type=radio]:checked').attr('rel');
                $(this).parents().eq(2).find('.total').html('$'+qty*cost);
                $('.buy').prop('disabled', false);
            });
  
            //UPDATE TOTAL WHEN QTY IS CHANGED
            $('.qty').change(function() {
                var qty = $(this).val();
                var cost = $(this).parents().eq(2).find('input[type=radio]:checked').attr('rel');
                $(this).parents().eq(2).find('.total').html('$'+qty*cost);
                $('.buy').prop('disabled', false);
            });
            
            //UPDATE TOTAL WHEN OPTION IS CHANGED
            $('.option').click(function() {
                var cost = $(this).attr('rel');
                var qty = $(this).parents().eq(2).find('.qty').val();
                $(this).parents().eq(2).find('.total').html('$'+qty*cost);
            });
            
            //submit
             $('.buy').click(function() {
                $("#leaveBool").val(1);
                var isMember = $("#alreadyMember").val();
                var total = $(this).parents().eq(2).find('.total').html();
                var serviceName = $(this).parents().eq(2).find('.title').html();
                var numberClasses = $(this).parents().eq(2).find('input[type=radio]:checked').attr('value');
                var qty = $(this).parents().eq(2).find('.qty').val();
                var serviceKey = $(this).parents().eq(2).find('#serviceKey').val();
                  
                total = total.replace("$", "");
                
                //alert(serviceKey);
                //alert(serviceName);
                //alert(numberClasses);
               /* if(isMember == 0)  {
                    var answer1 = confirm("You are not logged in! If you are already a member please click cancel and login to your account first. If you are not a member click ok to continue. Do you wish to continue?");
                    if (!answer1) {
                        return false;
                    }           
                }*/
                  //  alert(total) ;
                 if(total == 0 || total == 'TOTAL'){
                    //alert('Please select a package and enter the quantity first, then click BUY NOW again.');
                     $('#error').html('Please select a package and enter the quantity first, then click BUY NOW again.');
                    $("#error").css( { "color" : "red"} );
                    $('buy').prop('disabled', true);
                    return false;
                 }
                 
                 location.href = 'trainingSalesForm.php?service_name='+serviceName+'&num_classes='+numberClasses+'&total='+total+'&qty='+qty+'&serviceKey='+serviceKey; 
            });
            
            
            
            
        });
    </script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Training Packages</h1></div>
    
    <div class="row">
     <div id="blanket" style="display:none;"></div>
	<div id="popUpDiv" style="display:none;">
    
    	<a href="#" id="closeLink" >X Close Special Offer</a>
        <h4 class="oBtext">Get Free Assesment</h4><div id="oBox" class="oBox"><div id="oBtext" class="oBtext"><center>SPECIAL OFFER!</center><br>Congratulations! You have been selected to receive<br>a FREE personal training assesment.<br>Please enter the following information below <br>to receive your special offer.</div></div><div id="oBox2" class="oBox2"><p class="oBtext">Name<br><input name="name" type="text" id="name" value="" size="30" maxlength="50"></p><p class="oBtext">Email Address<br><input name="email" type="text" id="email" value="" size="30" maxlength="50"><p class="oBtext">Phone Number<br><input name="phone" type="text" id="phone" value="" size="15" maxlength="15"><p class="oBtext">North Location&nbsp;<input type="radio" name="location" value="north">&nbsp;&nbsp;Media Center &nbsp;<input type="radio" name="location" value="media"><p class="oBtext"><span id="msgBox"></span><input type="submit" name="Get Discount Rate" value="Get Discount Rate" class="button pass"></p></div>
    </div>	
   <a id="link">SPECIAL OFFER!</a>
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

    $stmt = $dbMain ->prepare("SELECT number_packages, package1, package2, package3, package4, package5, package6, descrip1, descrip2, descrip3, descrip4, descrip5, descrip6, box_color, text_color FROM website_training_options WHERE web_key = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($numberMemberships, $package1, $package2, $package3, $package4, $package5, $package6, $descrip1, $descrip2, $descrip3, $descrip4, $descrip5, $descrip6, $boxColor, $textColor);
    $stmt->fetch();
    $stmt->close();

    $stmt = $dbMain ->prepare("SELECT upgrade_fee_single FROM fees WHERE fee_num = '1'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($upgrade_fee_single);
    $stmt->fetch();
    $stmt->close();

    $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($homeClubName);
    $stmt->fetch();
    $stmt->close();

    if($upgrade_fee_single != '0.00') {
        $upgradeFeeHtml1 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process1\">$$upgrade_fee_single</span></b></p>";
        $upgradeFeeHtml2 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process2\">$$upgrade_fee_single</span></b></p>";
        $upgradeFeeHtml3 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process3\">$$upgrade_fee_single</span></b></p>";
        $upgradeFeeHtml4 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process4\">$$upgrade_fee_single</span></b></p>";
        $upgradeFeeHtml5 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process5\">$$upgrade_fee_single</span></b></p>";
        $upgradeFeeHtml6 = "<p class=\"caption-header txt-gray\"><span style=\"color: #$textColor; font-family: Times; font-size:16px;\"><b>Processing Fee:&nbsp; <span id=\"process6\">$$upgrade_fee_single</span></b></p>";
    } else {
        $upgradeFeeHtml1 = "";
        $upgradeFeeHtml2 = "";
        $upgradeFeeHtml3 = "";
        $upgradeFeeHtml4 = "";
        $upgradeFeeHtml5 = "";
        $upgradeFeeHtml6 = "";
    }

    //GET PACKAGE COUNT FOR COLUMN LAYOUT
    if($package1) $package_count = 1;
    if($package2) $package_count = 2;
    if($package3) $package_count = 3;
    if($package4) $package_count = 4;
    if($package5) $package_count = 5;
    if($package6) $package_count = 6;

    for ($i=1; $i<$numberMemberships+1; $i++) {
        $buttons = ''; //RESET BUTTONS FOR EACH LOOP ELSE IT WILL SPIT OUT THE PREVIOUS BUTTONS
        if($i==1 OR $i==4) {
            echo '<div class="row"> <span id="error"></span>';
        }

        ${"memArray" . $i} = explode('-',${"package" . $i});
        ${"memArray" . $i}[0] = trim(${"memArray" . $i}[0]);
        ${"mem" . $i} = ${"memArray" . $i}[0];
        ${"loc" . $i} = ${"memArray" . $i}[1];
        if (preg_match('/All/i',${"memArray" . $i}[1])) {
            $clubIdLocal = "0";
            ${"club_name" . $i} = "All Locations";
        } else {
            $clubIdLocal = $club_id;
            ${"club_name" . $i} = $homeClubName;
        }

        $stmt = $dbMain-> prepare("SELECT service_info.service_key, service_type, club_id, service_cost, service_term, service_quantity FROM service_info JOIN service_cost ON service_info.service_key = service_cost.service_key WHERE service_info.service_type = '${"mem" . $i}' AND club_id = '$clubIdLocal' ORDER BY service_cost ASC");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result(${"service_key" . $i}, ${"service_type" . $i}, ${"club_id" . $i}, ${"service_cost" . $i}, ${"service_term" . $i}, ${"service_quantity" . $i});
        $while_counter = 1;
        while ($stmt->fetch()) {
            if ($service_term1 == "C") {
                $termText = "Classes";
            }
            if ($service_quantity1 == 1) {
                $termText = "Class";
            }
            $buttons .= '<input type="radio" name="yearOptions' . $i . '" value="' . ${"service_quantity" . $i} . '"';
            if ($while_counter==1) {$buttons .= ' checked ';}
            $buttons .= 'rel="' . ${"service_cost" . $i} . '" class="option"> ' . ${"service_quantity" . $i} . ' ' . $termText . ' - <strong>' . ${"service_cost" . $i} . '</strong></input><br>';
            $while_counter++;
        }
        $stmt->close();
        $cost1 = $service_cost1;
        $priceText1 = "for <span id=\"pifYears1\">$service_quantity1 $termText</span> ";

        echo '<div class="small-12 large-4 columns">
            <ul class="pricing-table">
                <li class="title">' . ${"service_type" . $i} . ' - ' . ${"club_name" . $i} . '</li>
                <li class="description">' . ${"descrip" . $i} . '</li>
                <li class="bullet-item options">' . $buttons . '</li>
                <li class="bullet-item text-center">QTY<br><input type="text" value="0" class="qty text-center"></li>
                <li class="price total">TOTAL</li>
                <li class="cta-button"><a class="button buy" href="#">Buy Now</a></li>
                <input name="serviceKey" id="serviceKey" value="'.${"service_key" . $i}.'" type="hidden">
            </ul>
        </div>';

        if($i==3 OR $i==$package_count) {
            echo '</div>';
        }
        echo '<input name="alreadyMember" id="alreadyMember" value="'.$alreadyMember.'" type="hidden">';
    }
    ?>
    
    <?php include_once('inc/footer.php'); ?>
    <input name="leaveBool" id="leaveBool" value="0" type="hidden">
</body>
</html>