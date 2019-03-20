<?php

/* JPEGCam Test Script */
/* Receives JPEG webcam submission and saves to local file. */
/* Make sure your directory has permission to write files as your web server user! */
//date('YmdHis')
$member_id = $_REQUEST['member_id'];
$filename = $member_id . '.jpg';
$complete_path = "../memberphotos/$filename";
$result = file_put_contents( $complete_path, file_get_contents('php://input') );
if (!$result) {
	print "ERROR: Failed to write data to $filename, check permissions\n";
	exit();
}


$url = "../memberphotos/$filename";


print "$url\n";

?>
