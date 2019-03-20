<?php
include_once('php/connection.php');
$get_club_id = $_GET['club'];
$get_club_id = urldecode($get_club_id);
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <style>
    .pricing-table .description {
    background-color: #FFF;
    padding: 0.9375rem;
    text-align: center;
    color: #000;
    font-size: 0.75rem;
    font-weight: bold;
    line-height: 1.4;
    border-bottom: 1px dotted #DDD;
}
</style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Trainers</h1></div>
    
    <div class="row">
        <div class="small-12 large-8 columns">
            <?php
            $stmt = $dbMain ->prepare("SELECT bundle_id, type_id FROM bundle_type WHERE location_id = '$get_club_id' AND bundle_name LIKE '%Train%'");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($bundle_id, $type_id);
            $stmt->fetch();
            $stmt->close();
            
            $directoryPath = $_SERVER['DOCUMENT_ROOT'];
            $directoryArray = explode("/",$directoryPath);
            $domainDir = $directoryArray[6];

            $stmt = $dbMain ->prepare("SELECT instructor_id, instructor_name, instructor_description, instructor_photo FROM instructor_info WHERE type_id = '$type_id' ORDER BY instructor_id ASC");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($instructor_id, $instructor_name, $instructor_description, $instructor_photo);
            while($stmt->fetch()){
                if($instructor_name != ""){
                    
                    echo "<div class=\"small-12 large-4 columns\">
                            <ul class=\"pricing-table\">
                                <li class=\"title\">$instructor_name</li><br>
                                <div class=\"empPhoto float-r\">
                                     <img src=\"https://$domainDir/admin/instructorphotos/$instructor_photo\" alt=\"emp-photo\" height=\"125\" width=\"125\"> 
                                </div>
                                <li class=\"description\">$instructor_description</li>
                                </ul>
                                </div>";
                }
            }
            $stmt->close();
            ?>
        </div>
        <div class="small-12 large-4 columns">
            <h2><u>FREE ASSESSMENT</u></h2>
            <p>Please contact one of our Trainers to recieve a complimentary fitness assessment. Assessments can consist of a workout, nutritional coaching, movement assessments, bodyfat analysis, form coaching and more. Each trainer customizes assessments to meet individual needs.</p>
            <p>Trainers make you reach your goals 30% faster!</p>
            <p>Maximize your workout in a minimal amount of time!</p>
            <p>Reduced chance of injury!</p>
            <h3>Get Motivated!<br> Get Results!</h3>
        </div>
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
