<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$priority = $_REQUEST['priority'];
$target_app = $_REQUEST['target_app'];
$message = $_REQUEST['message'];
$topic = $_REQUEST['topic'];
$from_app = $_REQUEST['from_app'];

//decode the info from the ajax post
$message = urldecode($message);
$topic = urldecode($topic);
$topic = trim($topic);
$message = trim($message);


$contract_key = $_SESSION['contract_key'];
$user_id  = $_SESSION['user_id'];

//$contract_key = "1651";
//$userId = '74';

include "../utilities/noteSql.php";
$saveNote = new noteSql();
$saveNote-> setNoteTopic($topic);
$saveNote-> setContractKey($contract_key);
$saveNote-> setNoteMessage($message);
$saveNote-> setNoteUser($user_id);
$saveNote-> setNotePriority($priority);
$saveNote-> setTargetAppId($target_app);
$saveNote-> setNoteCategory($from_app);
    
$save_result = $saveNote-> saveNote();

echo"$save_result";


?>