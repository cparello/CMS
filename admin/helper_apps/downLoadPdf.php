<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

$file_name = $_GET['file_name'];
$file_dir = $_GET['file_dir'];


$file_path = "../$file_dir/$file_name";


// We'll be outputting a PDF
header("Content-type: application/pdf");

// It will be called downloaded.pdf
header("Content-Disposition: attachment; filename=\"$file_name\"");

// The PDF source is in original.pdf
readfile($file_path);


?>