<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$from_address = $_REQUEST['from_address'];
$reply_address = $_REQUEST['reply_address'];
$from_name = $_REQUEST['from_name'];
$intro_message = $_REQUEST['intro_message'];

include "saveGuestPassEmail.php";

if (isset($_POST['save']))       {

$marker_id = 1;

$savePass = new saveGuestPassEmail();
$savePass-> setMarkerId($marker_id);
$savePass-> setFromAddress($from_address);
$savePass-> setReplyAddress($reply_address);
$savePass-> setFromName($from_name);
$savePass-> setIntroMessage($intro_message);
$savePass-> parseGuestPassEmail();
        
$confirmation = "Guest Pass Email Successfully Saved";   
}

$loadPass = new saveGuestPassEmail();
$loadPass-> loadGuestPassEmail();
$from_address = $loadPass-> getFromAddress();
$reply_address = $loadPass-> getReplyAddress();
$from_name = $loadPass-> getFromName();
$intro_message = $loadPass-> getIntroMessage();

$page_title = 'Edit Guest Pass Email';
$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtGuestPass.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editGuestPassEmail.js\"></script>";

include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(46);
$info_text = $getText -> createTextInfo();


include "../templates/infoTemplate2.php";
include "../templates/guestPassEmailTemplate.php";


?>