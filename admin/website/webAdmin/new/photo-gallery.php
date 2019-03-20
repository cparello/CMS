<?php
include_once('php/connection.php');

$stmt = $dbMain ->prepare("SELECT mission_statement, motto FROM website_company_mission WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($mission_statement, $motto);
$stmt->fetch();
$stmt->close();

$dir = "img/gallery/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $dropOptions2 .= "<li><a href=\"img/gallery/$value\"><img src=\"img/gallery/$value\"></a></li>";
                           }
                 }
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Photo Gallery</h1></div>
    
    <div class="row">
        <div class="small-12 large-12 columns">
            <p>Click an image to see a larger view</p>
            
            <ul class="gallery" data-clearing>
                <?php echo $dropOptions2 ?>
            </ul>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>