<?php
include_once('php/connection.php');

 $stmt = $dbMain ->prepare("SELECT type_id, type_name, location_id FROM schedule_type WHERE type_id != '' ");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($type_id, $type_name, $location_id); 
 $rowCount = $stmt->num_rows;

    while ($stmt->fetch()) { 
    
               if($location_id == "0") {
                  $serviceLocation = 'All Locations';
                  }else{
                     $stmt9 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$location_id'");
                     $stmt9->execute();      
                     $stmt9->store_result();      
                     $stmt9->bind_result($club_name); 
                     $stmt9->fetch();
                  }
                              
               $type_select .= "<option value=\"$type_id\">$type_name $serviceLocation</option>\n";         
            }
    
   
   $choose_type = "<option value>Choose Schedule Category</option>\n";
             
$schedule_type_drops = "$choose_type$type_select";            
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    .row {
        text-align: center;
    }
    .spacerFoot{
        height: 260px;
        posistion:relative;
    }
    </style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Class Descriptions</h1>
    </div>
    
    <div class="row">
       <tr>
        <td>
        <center><h3>View Class Descriptions</h3></center>
        </td>
        </tr>
        <br>
                       <form>
        <table border="0" align="center" cellspacing="0" cellpadding="0">
        
        <div class="box">
        <tr>
        <td class="black">
        1.  Select Schedule Category:&nbsp;&nbsp;
        </td>
        <td>
        <select name="schedule_type"  id="schedule_type" class="black3"/>
        <?php echo $schedule_type_drops ?>
        </select>
        </td>
        </tr>
        
        <tr>
        <td class="black">
        2.  Select Class Name:&nbsp;&nbsp;
        </td>
        <td>
        <select name="bundle_type"  id="bundle_type" class="black3"/>
        <?php echo $bundle_type_drops ?>
        </select>
        </td>
        <td>
        (OPTIONAL)
        </td>
        </tr>
        
        <br>
        
        <tr>
        <td>
        </td>
        <td class="black">
        <br>
        <input type="button" id="classDescrips" class="button" name="classDescrips" value="Load Class Descriptions" />
        <td>
        </tr>
        </div>
        </table>
        </div>
        
        
         <div class="spacerFoot">
   
          </div>
        
        
        
        
        
    </div>
    
    <?php include_once('inc/footer.php'); ?>
    
    <script type="text/javascript" src="js/loadBundleDrops.js"></script>
    <script type="text/javascript" src="js/viewDescrips.js"></script>
  
</body>
</html>
