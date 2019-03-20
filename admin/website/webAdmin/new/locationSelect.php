<?php
include_once('php/connection.php');
$clubDrop = "";

$stmt = $dbMain ->prepare("SELECT club_name, club_id, club_address FROM club_info WHERE club_id != ''");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($clubName, $club_id, $club_address); 
while($stmt->fetch()){
    $clubName = trim($clubName);
    $clubDrop .="<option value=\"$club_id\">$clubName - $club_address</option>";
     }



?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php');
    //<script src="js/checkAreaZip.js" type="text/javascript"></script> ?>
    <style>
    .spacerFoot{
        height: 250px;
        posistion:relative;
    }
    </style>
    
    
    <script src="js/checkClosestZipv1.js" type="text/javascript"></script>
    <script>

$(document).ready(function(){
    $('#submitLoc').click(function() {
        //alert();        
        var location = $('#location').val();
            window.location = "join.php?club_id="+location+"";
        });
   
});
</script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Location Select</h1></div>
    
    <div id="content" class="row">
        <div class="small-12 large-4 columns">
            <h2>Find The Closest Location</h2>
            
            <p><label for="zipcode1" class="label"><u>Zipcode</u></label>
<input id="zipcode1" value="" name="zipcode1" maxlength="320" type="text" tabindex="1" class="input" /></p>
 <br>
                <p><span><label for="miles" class="label"><u>Distance</u>&nbsp;&nbsp;(optional)</label>
                <select tabindex= "1" name="miles" id="miles">
                <option value="" selected>Please Select</option>  
                <option value="5">5 Miles</option>
                <option value="10">10 Miles</option>
                <option value="25">25 Miles</option>
                <option value="50">50 Miles</option>
                </select></p>
                <br>
<p>
<br>
<span id="msgBox"></span>
<button class="button" id="zipCloseSearch" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Search</span></span></button>
</p>
        </div>
        
        
         <div class="small-12 large-4 columns">
            <h2>Select a Location</h2>
            
            <p><td>
                    <select tabindex= "1" name="location" id="location">
                    <option value="" selected>Please Select</option>  
                    <?php echo $clubDrop ?>
                    </select>
                </td></p>
                <button class="button" id="submitLoc" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Go</span></span></button>
                       
        </div>
    </div>
     <div class="spacerFoot">
   
          </div>
        
    
    <?php /*<div class="small-12 large-4 columns">
            <h2>Find Locations Near Your Area</h2>
            
            <p><span><label for="zipcode2" class="label"><u>Zipcode</u></label>
                <input id="zipcode2" value="" name="zipcode2" maxlength="320" type="text" tabindex="1" class="input" /></p>
                <br>
                <p><span><label for="miles" class="label"><u>Distance</u></label>
                <select tabindex= "1" name="miles" id="miles">
                <option value="" selected>Please Select</option>  
                <option value="5">5 Miles</option>
                <option value="10">10 Miles</option>
                <option value="25">25 Miles</option>
                <option value="50">50 Miles</option>
                </select></p>
                <br>
                <button class="button" id="zipAreaSearch" type="submit" data-text="Processing…"><span class="button-left"><span class="button-right">Search</span></span></button>
        </div>*/ include_once('inc/footer.php'); ?>
</body>
</html>
