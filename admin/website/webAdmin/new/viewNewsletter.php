<?php
include_once('php/connection.php');




$stmt = $dbMain ->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gymName); 
$stmt->fetch(); 

$stmt = $dbMain ->prepare("SELECT owners_letter, club_news, special_offer, qna, testimonials, upcoming_events, partner, misc1T, misc1C, misc2T, misc2C  FROM website_newsletter WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($ownersLetter, $clubNews, $specialOffer, $qna, $testimonials, $upcomingEvents,  $partner,  $misc1T,  $misc1C,  $misc2T,  $misc2C);
$stmt->fetch();
if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
   }
$stmt->close();

   
$tempGName = explode(' ',$gymName);
   
   
   $g1 = strtolower($tempGName[0]);
   $g1 = ucfirst($g1);
   $g2 = strtolower($tempGName[1]);
   $g2 = ucfirst($g2);
   $g3 = strtolower($tempGName[2]);
   $g3 = ucfirst($g3);
   $g4 = strtolower($tempGName[3]);
   $g4 = ucfirst($g4);
   
   $gymName = "$g1 $g2 $g3 $g4";

$_SESSION['admin_access'] = "yes";
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    .pricing-table {
            border-style: ridge;
            border-width: 5px;
    }
    .pricing-table .title {
        font-weight: 800;
    }
    .spacerFoot{
        height: 220px;
        position:relative;
        
    }

.grad {
  background: -webkit-linear-gradient(white, grey); /* For Safari 5.1 to 6.0 */
  background: -o-linear-gradient(white, grey); /* For Opera 11.1 to 12.0 */
  background: -moz-linear-gradient(white, grey); /* For Firefox 3.6 to 15 */
  background: linear-gradient(white, grey); /* Standard syntax */
} 

.pricing-table .description {
    color: #000;
}
h3{
    font-weight: 800;
    text-decoration: underline;
}
.spacer{
        height: 50px;
        width: 20%;
        
    }
    .photoBox{
        width: 15%;
        height: 150px;
        background:black;
        position: relative;
    }
    .photoBox2{
        top: 30%;
        width: 20%;
        height: 150px;
        background:black;
        position: relative;
    }


    </style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1><?php echo  $gymName  ?> Newsletter</h1>
    </div>
    
    
    <div class="row">
     <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Letter from the Owner</li>
            <li class="description grad"><?php echo $ownersLetter ?></li>
        </ul>
    </div>
     <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Club News</li>
            <li class="description grad"><?php echo $clubNews ?></li>
        </ul>
    </div>
   <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Special Offers</li>
            <li class="description grad"><?php echo $specialOffer ?></li>
        </ul>
    </div>
    <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Q&A</li>
            <li class="description grad"><?php echo $qna ?></li>
        </ul>
    </div><div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Testimonials</li>
            <li class="description grad"><?php echo $testimonials ?></li>
        </ul>
    </div>
    <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">Upcoming Events</li>
            <li class="description grad"><?php echo $upcomingEvents ?></li>
        </ul>
    </div>
    
    
     <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title">New Partnership</li>
            <li class="description grad"><?php echo $partner ?></li>
        </ul>
    </div><div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title"><?php echo $misc1T ?></li>
            <li class="description grad"><?php echo $misc1C ?></li>
        </ul>
    </div>
    <div class="small-12 large-4 columns">
        <ul class="pricing-table">
            <li class="title"><?php echo $misc2T ?></li>
            <li class="description grad"><?php echo $misc2C ?></li>
        </ul>
    </div>
    </div>
    
        
    <?php include_once('inc/footer.php'); ?>
    
   <script src="js/newsletter.js"></script>   
  
</body>
</html>
