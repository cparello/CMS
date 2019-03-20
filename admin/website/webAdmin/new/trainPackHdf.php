<?php
include_once('php/connection.php');
include "../../../dbConnect.php";
$get_club_id = $_GET['club'];
?>
<!doctype html>
<html class="no-js" lang="en">
<head>

    <?php include_once('inc/meta.php'); ?>
<style>
.row2 {
    width: 50%;
    margin: 0px auto;
    max-width: 62.5rem;
}
.contact{
    text-align: center;
}
</style>    
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover"><h1>Hi-Def Training Packages</h1></div>
    
    
    <?php
        echo '<div class="row"> <span id="error"></span></div>';
        
     ?>
     
     <?php
        echo '<div class="row2">';
        
     ?>
     <p class="contact"><a href="mailto:hdfitness@charter.net" target="_blank">hdfitness@charter.net</a><br>Phone: 818-599-9830</p>
     </span>
        <iframe src="http://docs.google.com/gview?url=http://www.burbankathleticclub.com/PT-PACKAGE.pdf&embedded=true" style="width:718px; height:700px;" frameborder="0"></iframe>
      
    <?php
        echo '</div>';
    ?>
    
    <?php include_once('inc/footer.php'); ?>
</body>
</html>