<?php
include_once('php/connection.php');

$stmt = $dbMain ->prepare("SELECT business_name FROM company_names WHERE business_name != ''");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gymName); 
$stmt->fetch(); 

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
    .row {
        text-align: center;
    }
    .row2 {
        width: 50%;
    }
    .spacerFoot{
        height: 220px;
        posistion:relative;
    }
    </style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Newsletter</h1>
    </div>
    <div class="row">
                <table align="middle" border="0" cellspacing="0" cellpadding="4" width=100%>
                 <tr >
                <th>Unsubscribe from our newsletter!</th>
                </tr>
                <tr>
                <th><b>Email</b></th>
                <th><b>Confirm Email</b></th>
                </tr>
                <tr>
                <td>
                <input  name="email" type="text" id="email" value="" size="20" maxlength="60"/>
                </td>
                <td>
                <input  name="confirm_email" type="text" id="confirm_email" value="" size="20" maxlength="30" />
                </td>
                </tr>
               <tr>
               <span id="msgBox"></span>
                <th><input type="submit"  class="button" name="cancelNews" id="cancelNews" value="Unsubscribe" /></th>
                <th><input type="hidden" name="marker" value="2" /></th>
                </tr>
                </table>     
    </div>
     <div class="spacerFoot">
   
          </div>
        
    <?php include_once('inc/footer.php'); ?>
    
   <script src="js/cancNews.js"></script>   
  
</body>
</html>
