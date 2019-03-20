
	<script>
        $(document).ready(function() {
            
            //GET CLASSES ON SUBMIT==============================================================================================================
			$('#message-box').click(function() {
			 
		          var link_name = $("#link_name").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
            //======================================================================================================================================
          $('.fa-google-plus').click(function() {
			 
		          var link_name = $("#gp").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
            //================================================================
            $('.fa-instagram').click(function() {
			 
		          var link_name = $("#inst").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-linkedin').click(function() {
			 
		          var link_name = $("#li").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-pinterest-p').click(function() {
			 
		          var link_name = $("#pin").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-twitter').click(function() {
			 
		          var link_name = $("#twit").val();
                  
                  window.location = ''+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-yelp').click(function() {
			 
		          var link_name = $("#yp").val();
                  
                  window.location = 'http://www.yelp.com/biz/'+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-youtube-play').click(function() {
			 
		          var link_name = $("#yt").val();
                  
                  window.location = 'https://www.youtube.com/channel/'+link_name+'';
			}); //END GET CLASSES ON SUBMIT
             //================================================================
            $('.fa-facebook').click(function() {
			 
		          var link_name = $("#fb").val();
                  
                  window.location    = 'https://www.facebook.com/pages/'+link_name+'';
                  	}); 
                //===================
            $("#manClinic").click( function() {
                    //alert();
                    window.location = "manClinic.php";      
                    });                           
		
       //=================================================================== 
                           
        });
    </script>
<?php
include"../../../../dbConnect.php";


   $stmt = $dbMain ->prepare("SELECT facebook_business_page_name, twitter_handle, youtube_chanel_name, yelp_page, google_plus, instagram, linked_in, pinterest  FROM website_colors WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($faceBookBusinessName, $twitterHandle, $youtubeChannel, $yelp_page, $google_plus, $instagram, $linked_in, $pinterest );
   $stmt->fetch();
   $stmt->execute();
   $stmt->close();
   
   $stmt = $dbMain ->prepare("SELECT privacy, terms  FROM web_misc WHERE row_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($privacy, $terms);
   $stmt->fetch();
   $stmt->execute();
   $stmt->close();

if(trim($faceBookBusinessName) != ""){
    $fbHtml = "<i class=\"fa fa-facebook\"></i>";
}
if(trim($google_plus) != ""){
    $gPlusHtml = "<i class=\"fa fa-google-plus\"></i>";
}
if(trim($instagram) != ""){
    $instaHtml = "<i class=\"fa fa-instagram\"></i>";
}
if(trim($linked_in) != ""){
    $linkHtml = "<i class=\"fa fa-linkedin\" ></i>";
}
if(trim($pinterest) != ""){
    $pinHtml = "<i class=\"fa fa-pinterest-p\"></i>";
}
if(trim($twitterHandle) != ""){
    $twitHtml = "<i class=\"fa fa-twitter\"></i>";
}
if(trim($yelp_page) != ""){
    $yelpHtml = "<i class=\"fa fa-yelp\"></i>";
}
if(trim($youtubeChannel) != ""){
    $tubeHtml = "<i class=\"fa fa-youtube-play\"></i>";
}

?>


<footer>
    <div class="row">
        <div class="small-12 large-7 columns"><?php echo '&copy;' . date('Y') . ' ' . $business_name . ' | ' . $club_contacts . '' .  '<a  tabindex="-1" href="mailto:' . $email . '">' . $email . '</a>'. ' | '  ?><a  tabindex="-1" class="botLinks3" href="javascript:void(0);">PRIVACY POLICY</a> <span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=HMhTdG4LpgKmCFiXrmkdxZolqMhZjoAKMExZVVo0kJCGHYzZVPkcryx1k1ET"></script></span><span id="manClinic"><img src="img/manClinic.png" alt="Man Clinic" height="25" width="50"></span></div>
        <div  tabindex="-1" id="social" class="small-12 large-5 columns"><?php echo $fbHtml ?><?php echo $gPlusHtml ?><?php echo $instaHtml ?><?php echo $linkHtml ?><?php echo $pinHtml ?><?php echo $twitHtml ?><?php echo $yelpHtml ?><?php echo $tubeHtml ?></div>
    </div>
</footer>
<div id="privacy" class="privacy">
<div id="popx2" class="popx2">
<a href="javascript:void(0);" ><img src="img/popx.png" width="18" height="17" border="0"></a>
</div>
<div id="headerContact" class="headerContact">
<p><?php echo $privacy; ?></p>
</div>
</div>

<script src="js/foundation.min.js"></script>
<script>
$(document).foundation({
    orbit: {
        slide_number: false,
        bullets: false,
        timer_speed: 4000,
        resume_on_mouseout: true
    }
});
    
$(document).ready(function(){
    $('#submit-member-login').click(function() {
        var barcode = $('#login-barcode').val();
        var password = $('#login-password').val();

        //SUBMIT LOGIN INFORMATION
        $.ajax ({
            type: "POST",
            url: "php/member-login.php",
            cache: false,
            async: false,
            dataType: 'html', 
            data: {barcode: barcode, password: password},              
            success: function(data) { 
                //alert(data);
                var dataArray = data.split("|");
                var bit = dataArray[0];
                var contractKey = dataArray[1];
                var barcode = dataArray[2];
                var name = dataArray[3];

                if(bit == 1) {
                    $('#login-success').fadeIn();
                    $('#login-cart').load('index.php #login-cart');
                } else {  
                    $('#login-failure').toggle();
                    return false;                                              
                }
            }
        });
        return false;
        });
    //TOGGLE FAILURE LOGIN ALERT BOX
    $('#login-failure .close').click(function() {
        $(this).parents().eq(1).toggle();
    });
});
</script>

    <input type="hidden" name="fb" id="fb" value="<?php echo $faceBookBusinessName ?>"/>
    <input type="hidden" name="gp" id="gp" value="<?php echo $google_plus ?>"/>
    <input type="hidden" name="inst" id="inst" value="<?php echo $instagram ?>"/>
    <input type="hidden" name="li" id="li" value="<?php echo $linked_in ?>"/>
    <input type="hidden" name="pin" id="pin" value="<?php echo $pinterest ?>"/>
    <input type="hidden" name="twit" id="twit" value="<?php echo $twitterHandle ?>"/>
    <input type="hidden" name="yp" id="yp" value="<?php echo $yelp_page ?>"/>
    <input type="hidden" name="yt" id="yt" value="<?php echo $youtubeChannel ?>"/>