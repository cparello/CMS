<?php

$name = $_REQUEST['name'];
$description = $_REQUEST['description'];
$descriptionList = $_REQUEST['descriptionList'];
$catName = $_REQUEST['catName'];

include_once('php/connection.php');


$stmt = $dbMain ->prepare("SELECT box_color, text_color FROM website_membership_options WHERE web_key = '1'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($boxColor, $textColor);
$stmt->fetch();
$stmt->close();

if(!isset($descriptionList)){
    $width = "50%";
    $class = "row2";
    $description = trim($description);
    if($description == ""){
        $height = "220px";
    }
    $html = " 
              <div class=\"small-12 large-4 columns\">
              <center><h2>$catName</h2></center>
                        <ul class=\"pricing-table\">
                            <li class=\"title\">$name</li>
                            <li class=\"description\">$description</li>
                        </ul>
                    </div>";
}else{
    $width = "100%";
    $class = "row";
    $descripArray = explode('@',$descriptionList);
    //var_dump($descripArray);
    $html .= "<center><h2>$catName</h2></center>";
    foreach($descripArray as $descripList){
        $detailsArray = explode('~',$descripList);
        $name = $detailsArray[0];
        $descrip = $detailsArray[1];
        $bunId = $detailsArray[2];
        
        if($descrip == ""){
            $descrip = "Not Available at this time.";
        }
        
        if($name != ""){
            $html .= "<div class=\"small-12 large-4 columns\">
                        <ul class=\"pricing-table\">
                            <li class=\"title\">$name</li>
                            <li class=\"description\">$descrip</li>
                        </ul>
                    </div>";
                
                /*<div id=\"classDescription\" class=\"classDescription gymBox\">
                <p class=\"className\">$name</p>
                <p class=\"classText\">$descrip</p>
                </div><br>*/
        
        }
        
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
.pricing-table .title {
    background-color: #000;
    padding: 0.9375rem 1.25rem;
    text-align: center;
    color: #FFF;
    font-weight: 900;
    font-size: 1.2rem;
    font-family: "Helvetica Neue",Helvetica,Roboto,Arial,sans-serif;
}
.pricing-table .description {
    background-color: #FFF;
    padding: 0.9375rem;
    text-align: center;
    color: #777;
    font-size: 1.2rem;
    font-weight: 900;
    line-height: 1.4;
    border-bottom: 1px dotted #DDD;
}
.row2 {
    width: <?php echo $width; ?>;
    margin-right: 200px;
    margin: 0px 40% auto;
    max-width: 62.5rem;
    height: <?php echo $height; ?>;
}
</style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Class Descriptions</h1>
    </div>
    <div class="<?php echo $class; ?>">
       
                <?php echo $html ?>
                
         
    </div>
    <div class="row">
       
           &nbsp;     
                
         
    </div>
    
    
    
    <?php include_once('inc/footer.php'); ?>
    
  
</body>
</html>
