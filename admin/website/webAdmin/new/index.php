<?php 

include_once('php/connection.php'); 

include "../../../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT header_txt, header_txt2, header_txt3, header_txtSize, header_txt2Size, header_txt3Size, box_width, text_transform, header_color, back_color, promo_link, photo1, photo2, photo3, photo4, photo5, opacity  FROM website_promo WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($headerTxt, $headerTxt2, $headerTxt3, $headerTxtSize, $headerTxt2Size, $headerTxt3Size, $boxSize, $textTrans, $headerColor, $backColor, $promoLink, $photo1Ban, $photo2Ban, $photo3Ban, $photo4Ban, $photo5Ban, $opacity);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT business_name  FROM business_info WHERE bus_id = '1000'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($bus_name);
$stmt->fetch();
$stmt->close();

$stmt = $dbMain ->prepare("SELECT club_name, club_phone  FROM club_info WHERE club_id != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_name, $club_phone);
while($stmt->fetch()){
     $club_contacts .= ' ' . $club_name .'&nbsp;&nbsp;'. $club_phone . ' | ';
}
$stmt->close();

//echo "$headerTxt, $headerTxt2, $headerTxt3, $boxSize, $textTrans, $headerColor, $backColor, $promoLink, $photo1, $photo2, $photo3, $photo4, $photo5";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
   
    <style>
    #message-box, .bannCols {
        color: #<?php echo $headerColor ?>;
        background-color: <?php $backColor?>;
        text-transform: <?php echo $textTrans?>;
        width: <?php echo $boxSize ?>%;
        cursor: pointer;
        opacity: <?php echo $opacity ?>; 
}
#message-box .line-1 {
    font-size: <?php echo $headerTxtSize?>vw;
}
#message-box .line-2 {
    font-size: <?php echo $headerTxtSize?>vw;
}
#message-box .line-3 {
    font-size: <?php echo $headerTxtSize?>vw;
}
#manClinic{
    cursor: pointer;
    
}
    </style> 
<link rel="stylesheet" href="css/slippry.css" />
    	<script>
       /* $(document).ready(function() {
            
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
                           
        });*/
    </script>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <ul id="slippry-slider">
        <div id="message-box"><span class="line-1"><?php echo $headerTxt ?></span><br><span class="line-2"><?php echo $headerTxt2 ?></span><br><span class="line-3"><?php echo $headerTxt3 ?></span></div>
        <li><img src="img/<?php echo $photo1Ban ?>" alt="slide 1"></li>
        <li><img src="img/<?php echo $photo2Ban ?>" alt="slide 2"></li>
        <li><img src="img/<?php echo $photo3Ban ?>" alt="slide 3"></li>
        <li><img src="img/<?php echo $photo4Ban ?>" alt="slide 3"></li>
        <li><img src="img/<?php echo $photo5Ban ?>" alt="slide 3"></li>
    </ul>
    
    <div id="icons" class="row">
        <div class="small-12 medium-4 large-4 columns"><a class="txtColor" href="join.php"><i class="fa fa-check "></i><br>Join</a></div>
        <div class="small-12 medium-4 large-4 columns"><a class="txtColor" href="class-schedule.php"><i class="fa fa-calendar txtColor"></i><br>Schedule</a></div>
        <div class="small-12 medium-4 large-4 columns"><a class="txtColor" href="location.php?clubName=<?php echo $clubName ?>"><i class= "fa fa-location-arrow txtColor"></i><br>Locations</a></div>
    </div>
    
    <div id="hp-content">
        <div class="row">
            <div class="small-12 large-8 columns">
                <div id="hp-article" class="small-12 column">
                    <article>
                        <img src="img/<?php echo $photo1 ?>"  width="22%" height="22%"><h2><?php echo $clubInfoOneHead ?></h2>
                        <p><?php echo $clubInfoOneCopy ?></p>
                    </article>
                    
                    <article>
                        <img src="img/<?php echo $photo2 ?>"  width="22%" height="22%"><h2><?php echo $clubInfoTwoHead ?></h2>
                        <p><?php echo $clubInfoTwoCopy ?></p>
                    </article>
                </div>
                
                <div id="guest-pass" class="small-12 column">
                    <?php include_once('inc/get-pass.php'); ?>
                </div>
            </div>

            <div class="small-12 large-4 columns">
                <h2>What's New</h2>
                <article>
                    <strong><?php echo $announcmentOneHead ?></strong>
                    <p><?php echo $announcmentOneCopy ?></p>
                </article>
                
                <article>
                    <strong><?php echo $announcmentTwoHead ?></strong>
                    <p><?php echo $announcmentTwoCopy ?></p>
                </article>
                
                <article>
                    <strong><?php echo $announcmentThreeHead ?></strong>
                    <p><?php echo $announcmentThreeCopy ?></p>
                </article>
                
                <article>
                    <strong><?php echo $announcmentFourHead ?></strong>
                    <p><?php echo $announcmentFourCopy ?></p>
                </article>
            </div>
        </div>
        <input type="hidden" name="link_name" id="link_name" value="<?php echo $promoLink ?>"/>
    </div>
    <script type="text/javascript" src="js/slippry.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#slippry-slider').slippry({
				captions: false,
				pager: false
			});
		});
    </script>
    <?php 
/*include"../../../../dbConnect.php";


  $stmt = $dbMain ->prepare("SELECT facebook_business_page_name, twitter_handle, youtube_chanel_name, yelp_page, google_plus, instagram, linked_in, pinterest  FROM website_colors WHERE web_key = '1'");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($faceBookBusinessName, $twitterHandle, $youtubeChannel, $yelp_page, $google_plus, $instagram, $linked_in, $pinterest );
   $stmt->fetch();

if(!$stmt->execute())  {
	printf("Error: load web stuff%s.\n", $stmt->error);
   }
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
}*/

    include_once('inc/footer.php'); ?>
    <input type="hidden" name="fb" id="fb" value="<?php echo $faceBookBusinessName ?>"/>
    <input type="hidden" name="gp" id="gp" value="<?php echo $google_plus ?>"/>
    <input type="hidden" name="inst" id="inst" value="<?php echo $instagram ?>"/>
    <input type="hidden" name="li" id="li" value="<?php echo $linked_in ?>"/>
    <input type="hidden" name="pin" id="pin" value="<?php echo $pinterest ?>"/>
    <input type="hidden" name="twit" id="twit" value="<?php echo $twitterHandle ?>"/>
    <input type="hidden" name="yp" id="yp" value="<?php echo $yelp_page ?>"/>
    <input type="hidden" name="yt" id="yt" value="<?php echo $youtubeChannel ?>"/>
</body>
</html>