<?php
include_once('php/connection.php');

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

for($i=1;$i<=30;$i++){
    $todayDay = date('d');
    $displayDate = date('F j Y',mktime(0,0,0,date('m'),$todayDay+$i,date('Y')));
    $date = date('Y-m-d',mktime(0,0,0,date('m'),$todayDay+$i,date('Y')));
    $day_select .= "<option value=\"$date\">$displayDate</option>\n"; 
    }

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
          //----------------------------------------------------------------
                $("#day").change( function() {
                
                var ajaxSwitch = 1;
                var clubId = $("#location").val();
                var day = $("#day").val();
                var dayText = $("#day:selected").text();
                //alert(clubId);
                $.ajax ({
                                type: "POST",
                                url: "php/loadHoursDrops.php",
                                cache: false,
                                dataType: 'html', 
                                data: {ajax_switch: ajaxSwitch, day: day, clubId: clubId},               
                                     success: function(data) {  
                //alert(data);
                                     var dataArray = data.split('|');
                                     var successBit = dataArray[0];
                                     var hourDrop = dataArray[1];
                                     var userId = dataArray[2];
                                     var name = dataArray[3];
                                     var clubName = dataArray[4];
                                                          
                                       if(successBit == 1) {
                                                                                             
                                                       $("#time").html(hourDrop);
                                                       $("#user_id").val(userId);
                                                       $("#emp_name").val(name);
                                                        $("#club_name").val(clubName);
                                         }
                                         
                                         
                
                                         }//end function success
                                 }); //end ajax 
                
                
                
                });
                //---------------------------------------------------------------
                $("#bookVisit").click(function() { 
                //alert('fu');
                //check to see if the form fields are filled out
                var name = $("#name").val();
                var dataArray2 = name.split(' ');
                var firstName = dataArray2[0];
                var lastName = dataArray2[1];
                
                var phone= $("#phone").val(); 
                var location = $("#location").val();
                
                var time = $("#time").val();
                var dataArray = time.split('@');
                var time = dataArray[0];
                var timeFormatted = dataArray[1];
                
                var day = $("#day").val();
                var userId = $("#user_id").val();
                var clubName =  $("#club_name").val();
                
                var errors = "";
                
                
                if(firstName == "") {
                   //alert('Please supply a \"Name\"');
                   //        return false;
                   errors = errors + 'Please supply a \"First Name\"<br>';
                   }
                if(lastName == "") {
                   //alert('Please supply a \"Name\"');
                   //        return false;
                   errors = errors + 'Please supply a \"Last Name\"<br>';
                   }
                   
                if(location == "") {
                  // alert('Please supply a \"Location\"');
                   //        return false;
                            errors = errors + 'Please supply a \"Location\"<br>';
                   }
                
                if(time == "") {
                  // alert('Please supply a \"Time\"');
                        //   return false;
                            errors = errors + 'Please supply a \"Time\"<br>';
                   }   
                  // alert(time);
                   
                //take care of phone and reformat if needed
                if(phone == "") {
                  // alert('Please supply a \"Phone\" number');
                          // return false;
                            errors = errors + 'Please supply a \"Phone\" number<br>';
                   }
                phone = phone.replace(/\s+/g, " ");
                var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
                
                if (regexObj.test(phone)) {
                    var formattedPhoneNumber = phone.replace(regexObj, "($1) $2-$3");
                        $("#phone").val(formattedPhoneNumber);       
                     }else{
                             //  alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
                             //  $("#phone").focus();
                              // return false;       
                                errors = errors + 'You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number';        
                    }
                       
                if (errors != ""){
                    $('#msgBox2').html(errors);
                    $("#msgBox2").css( { "color" : "red"} );
                    return false;
                }
                //alert(location);         
                         
                //alert(confirmEmail);
                //now we send this off to save
                var ajaxSwitch = 1;
                
                $.ajax ({
                                 type: "POST",
                                 url: "php/scheduleApointment.php",
                                 cache: false,
                                 async:false,
                                 dataType: 'html', 
                                 data: {ajax_switch: ajaxSwitch, userId: userId, time: time, name: name, phone: phone},               
                                 success: function(data) {    
                  // alert(data);                  
                                 
                                        if(data == 1) {
                                            var name = $("#emp_name").val();
                                            alert('Appointment Scheduled with '+name+' on '+timeFormatted+' at '+clubName+'');                
                                          }
                                                                                           
                                     }//end function success
                              }); //end ajax 
                
                
                 });
 //=====================================================  
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
    
    <div id="cover"><h1>Schedule a Visit</h1></div>
    
    <div class="row">
        <div class="small-12 large-8 columns">
          <form>
                <table border="0" align="center" cellspacing="0" cellpadding="0">
                
                <div class="box">
                                
                <tr>
                <td class="black">
                1.  Select Location:&nbsp;&nbsp;
                </td>
                <td>
                <select tabindex= "1" name="location" id="location">
                <option value="" selected>Please Select</option>  
                <?php echo $clubDrop ?>
                </select>
                </td>
                </tr>
                
                <tr>
                <td class="black">
                2.  Select Day:&nbsp;&nbsp;
                </td>
                <td>
                <select name="day"  id="day" class="black3"/>
                <?php echo $day_select ?>
                </select>
                </td>
                </tr>
                
                <tr>
                <td class="black">
                3.  Select Time:&nbsp;&nbsp;
                </td>
                <td>
                <select name="time"  id="time" class="black3"/>
                <?php echo $bundle_type_drops ?>
                </select>
                </td>
                </tr>
                
                <tr>
                <td class="black">
                4.  Name:&nbsp;&nbsp;
                </td>
                <td>
                <input name="name" id="name" value="" size="20" maxlength="40" tabindex="4"  type="text">
                </td>
                </tr>
                
                <tr>
                <td class="black">
                5.  Phone Number:&nbsp;&nbsp;
                </td>
                <td>
                <input name="phone" id="phone" value="" size="20" maxlength="10" tabindex="4" type="text">
                </td>
                </tr>
                
                <br>
                
                <tr>
                <td>
                </td>
                <td class="black">
                <br>
                <input type="button" id="bookVisit" class="button" name="bookVisit" value="Schedule Visit" />
                <span id="msgBox2"></span>
                <td>
                <input type="hidden" name="user_id" id="user_id" value=""/>
                <input type="hidden" name="emp_name" id="emp_name" value=""/>
                <input type="hidden" name="club_name" id="club_name" value=""/>
                </tr>
                </div>
                </table>
            </form>
        </div>
        <div class="small-12 large-4 columns passSpace">
            <h4 class="oBtext">Get Discount Rate</h4><div id="oBox" class="oBox"><div id="oBtext" class="oBtext"><center>SPECIAL OFFER!</center>Please enter the following information <br>and I'll have one of my staff<br>reach out and give you a special deal.</div></div><div id="oBox2" class="oBox2"><p class="oBtext">Name<br><input name="name" type="text" id="name" value="" size="30" maxlength="50"></p><p class="oBtext">Email Address<br><input name="email" type="text" id="email" value="" size="30" maxlength="50"><p class="oBtext">Phone Number<br><input name="phone" type="text" id="phone" value="" size="15" maxlength="15"><p class="oBtext">North Location&nbsp;<input type="radio" name="location" value="north">&nbsp;&nbsp;Media Center &nbsp;<input type="radio" name="location" value="media"><p class="oBtext"><span id="msgBox"></span><input type="submit" name="Get Discount Rate" value="Get Discount Rate" class="button pass"></p></div>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
