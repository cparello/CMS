<?php
include_once('php/connection.php');
$stmt = $dbMain ->prepare("SELECT mailing_street, mailing_city, mailing_state, mailing_zip, business_phone, contact_email  FROM business_info WHERE bus_id = '1000'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($mailing_street, $mailing_city, $mailing_state, $mailing_zip, $business_phone, $contact_email);
$stmt->fetch();
$stmt->close();
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    #msgBox{
        text-align: center;
    }
    .spacerFoot{
        height: 620px;
        posistion:relative;
    }
    
    </style>

</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Contact Us</h1>
    </div>
    
    <div class="row">
   
    </div>
    
    <div class="row">
        <div class="small-12 large-12 columns" id="class-list">
                        <table align="center" border="0" cellpadding="4" cellspacing="0" width="60%">
                        <tbody>
                        <tr>
                            <td>
                            Corporate Email:
                            </td>
                            <td>
                            <?php echo $contact_email ?>
                            </td>
                            </tr>
                            <tr>
                            <td>
                            Corporate Phone:
                            </td>
                            <td>
                            <?php echo  $business_phone ?>
                            </td>
                            </tr>
                            <tr>
                            <td>
                            Corporate Mailing Address:
                            </td>
                            <td>
                            <?php echo $mailing_street?>
                            </td>
                            </tr>
                            <tr>
                            <td>
                            &nbsp;
                            </td>
                            <td>
                            <?php echo  $mailing_city ?>,&nbsp; <?php echo  $mailing_state ?> &nbsp;&nbsp;<?php echo  $mailing_zip ?>
                            </td>
                            </tr>
                            </tbody></table>
                            
                                                                                    
        </div>
        <div class="spacerFoot">
   
    </div>
    </div>
    
    
    <?php include_once('inc/footer.php'); ?>
    
</body>
</html>
