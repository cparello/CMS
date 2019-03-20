<?php
include_once('php/connection.php');

$viewedClubName = $_GET['clubName'];
$viewedClubName = urldecode($viewedClubName);

$stmt = $dbMain ->prepare("SELECT club_zip, Lattitude, longitude, amenities1, amenities2, amenities3, amenities4, amenities5, amenities6, amenities7, amenities8, hoursText1, hoursText2, clubText, guestPassLength FROM website_locations_setup WHERE club_name LIKE '%$viewedClubName%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_zip, $Lattitude, $longitude, $amenities1, $amenities2, $amenities3, $amenities4, $amenities5, $amenities6, $amenities7, $amenities8, $hoursText1, $hoursText2, $clubText, $guestPassLength ); 
$stmt->fetch();

$amenities1 . ' - ' . $amenities2 . ' - ' . $amenities3 . ' - ' . $amenities4 . ' - ' . $amenities5 . ' - ' . $amenities6 . ' - ' . $amenities7 . ' - ' . $amenities8;

if(trim($amenities1 != "")){
    $amenitiesHtml .= "$amenities1";
}
if(trim($amenities2 != "")){
    $amenitiesHtml .= "- $amenities2";
}
if(trim($amenities3 != "")){
    $amenitiesHtml .= "- $amenities3";
}
if(trim($amenities4 != "")){
    $amenitiesHtml .= "- $amenities4";
}
if(trim($amenities5 != "")){
    $amenitiesHtml .= "- $amenities5";
}
if(trim($amenities6 != "")){
    $amenitiesHtml .= "- $amenities6";
}
if(trim($amenities7 != "")){
    $amenitiesHtml .= "- $amenities7";
}
if(trim($amenities8 != "")){
    $amenitiesHtml .= "- $amenities8";
}

$stmt = $dbMain ->prepare("SELECT club_address, club_phone, club_contact, club_id FROM club_info WHERE club_name LIKE '%$viewedClubName%'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($club_address, $club_phone, $club_contact, $minClubId); 
$stmt->fetch();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <style>
    .google-maps {
        position: relative;
        padding-bottom: 30%; // This is the aspect ratio
        height: 0;
        overflow: hidden;
    }
    .google-maps iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
</head>
<body>
    <?php include_once('inc/header.php'); 
    if($minClubId == "3551"){
        $comment = "!--";
        $commentClose = "--";
        $comment2 = "";
        $commentClose2 = "";
    }else{
        $comment = "";
        $commentClose = "";
        $comment2 = "!--";
        $commentClose2 = "--";
    }
    
    ?>
    
    <!--div id="map-canvas"></div-->
    <div class="google-maps">
    <<?php echo $comment2 ?>iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3300.585453273764!2d-118.31030800000002!3d34.182514999999995!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c29550702b4159%3A0x389177df74b9af93!2sBurbank+Athletic+Club!5e0!3m2!1sen!2sus!4v1423006266028" width="100%" height="450" frameborder="0" style="border:0" class="margin"></iframe<?php echo $commentClose2 ?>>
    
    <<?php echo $comment ?>iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3300.468274300679!2d-118.348612!3d34.185509999999994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c295a02c9cdd13%3A0xeccd3a536bded156!2sBurbank+Athletic+Club!5e0!3m2!1sen!2sus!4v1435104312267" width="100%" height="450" frameborder="0" style="border:0"></iframe<?php echo $commentClose ?>>
    </div>
    
    <div class="row">
        <div class="small-12 large-8 columns">
            <h1><?php echo $viewedClubName ?></h1>
            <p><?php echo $club_address ?></p>
            <p><?php echo $club_phone ?></p>
            <p><?php echo $clubText ?></p>
            
            <!--GUEST PASS-->
            <?php include_once('inc/get-pass.php'); ?>
            
        </div>
        <div class="small-12 large-4 columns">
            <a href="/join.php?club_id=<?php echo $minClubId ?>" class="button expand"><i class="fa fa-user"></i> Membership Information</a><br>
            <a href="class-schedule.php" class="button expand"><i class="fa fa-calendar"></i> Class Schedule</a>
            <h4>Hours</h4>
            <table>
                <tbody>
                    <tr>
                        <td><?php echo $hoursText1 ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $hoursText2 ?></td>
                    </tr>
                </tbody>
            </table>

            <h4>Manager</h4>
            <p><?php echo $club_contact ?></p> 

            <h4>Ammenities</h4>
            <p><?php echo $amenitiesHtml ?></p>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&sensor=false"></script>

<script type="text/javascript">
function initialize() {
    var mapOptions = {
    center: new google.maps.LatLng(<?php echo $longitude; ?>, <?php echo $Lattitude; ?>),
    zoom: 18
};

var map = new google.maps.Map(document.getElementById("map-canvas"),
mapOptions);
var marker = new google.maps.Marker({
    position: map.getCenter(),
    map: map,
    title: 'Click to zoom'
});

google.maps.event.addListener(map, 'center_changed', function() {
// 3 seconds after the center of the map has changed, pan back to the
// marker.
window.setTimeout(function() {
map.panTo(marker.getPosition());
}, 3000);
});

google.maps.event.addListener(marker, 'click', function() {
map.setZoom(16);
map.setCenter(marker.getPosition());
});

}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
</body>
</html>
