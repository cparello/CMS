<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$location_id = $_SESSION['location_id'];
include "viewNewMembersSql.php";

$viewNew = new viewNewMembersSql();
$viewNew-> setLocationId($location_id);
$viewNew-> loadNewMembersList();
$new_members_list = $viewNew-> getNewMembersList();


$javaScript1 = "<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";

include  "../templates/viewNewMembersTemplate.php";


?>