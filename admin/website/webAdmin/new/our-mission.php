<?php
include_once('php/connection.php');

$stmt = $dbMain ->prepare("SELECT mission_statement, motto FROM website_company_mission WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($mission_statement, $motto);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
     <style>
    .oBtext{
    background-color: #333;
    padding: 0.9375rem 1.25rem;
    text-align: center;
    color: #EEE;
    }
     
    p {
    margin-bottom: 0;
    
}
    h1, h2, h3, h4, h5, h6 {
    margin-bottom: 0rem;
}

    </style>
     <script>
     $(document).ready(function() {
            
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
        //alert(guestName+' '+ emailA+' '+phoneNumber+' '+location+' '+marker);
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
                       $('.passSpace').html(data)
                       }else{
                        $("#msgBox").html('ERROR: ');
                        $("#msgBox").css( { "color" : "red"} );
                       }
                     }//end function success
              }); //end ajax  
    
  });
          
        });
        </script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Our Mission</h1></div>
    
    <div class="row">
        <div class="small-12 large-8 columns">
            <h2><?php echo $motto ?></h2>
            
            <p><?php echo $mission_statement ?></p>
        </div>
        <div class="small-12 large-4 columns passSpace">
            <h4 class="oBtext">Get Discount Rate</h4><div id="oBox" class="oBox"><div id="oBtext" class="oBtext"><center>SPECIAL OFFER!</center>Please enter the following information <br>and I'll have one of my staff<br>reach out and give you a special deal.</div></div><div id="oBox2" class="oBox2"><p class="oBtext">Name<br><input name="name" type="text" id="name" value="" size="30" maxlength="50"></p><p class="oBtext">Email Address<br><input name="email" type="text" id="email" value="" size="30" maxlength="50"><p class="oBtext">Phone Number<br><input name="phone" type="text" id="phone" value="" size="15" maxlength="15"><p class="oBtext">North Location&nbsp;<input type="radio" name="location" value="north">&nbsp;&nbsp;Media Center &nbsp;<input type="radio" name="location" value="media"><p class="oBtext"><span id="msgBox"></span><input type="submit" name="Get Discount Rate" value="Get Discount Rate" class="button pass"></p></div>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
