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
    @media only screen and (min-width: 64.063em){
    .large-4 {
        width: 25%;
    }
    .large-8 {
        width: 100%;
    }
    }
    .emptyMsg{
        font-size: 200%;
        font-weight: 800;
        text-align: center;
    }
</style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Instructors</h1></div>
    
    <div class="row">
        <div class="small-12 large-8 columns">
            <?php
            $directoryPath = $_SERVER['DOCUMENT_ROOT'];
            $directoryArray = explode("/",$directoryPath);
            $domainDir = $directoryArray[6];
            $testCount = 0;

            $stmt = $dbMain ->prepare("SELECT instructor_id, instructor_name, instructor_description, instructor_photo, type_id FROM instructor_info WHERE type_id != '' ORDER BY instructor_id ASC");
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($instructor_id, $instructor_name, $instructor_description, $instructor_photo, $type_id);
            while($stmt->fetch()){
                if($instructor_name != ""){
                    $count = 0;
                    $stmt9 = $dbMain ->prepare("SELECT count(*) as count FROM bundle_type WHERE location_id = '$get_club_id' AND bundle_name NOT LIKE '%Train%' AND type_id = '$type_id'");
                    $stmt9->execute();      
                    $stmt9->store_result();      
                    $stmt9->bind_result($count);
                    $stmt9->fetch();
                    $stmt9->close();
                    
                    if($count != 0){
                        $testCount++;
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
                $instructor_id = "";
                $instructor_name = "";
                $instructor_description = "";
                $instructor_photo = "";
                $type_id = "";
            }
            $stmt->close();
            if($testCount == 0){
                 echo "<div class=\"emptyMsg\">There are no instructors at this location.</div>
                        <style>
                        .spacerFoot{
                            height: 150px;
                            posistion:relative;
                        }
                        </style>";
            }
            echo "<div class=\"spacerFoot\">
   
          </div>";
            ?>
        </div>
       
    </div>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>
