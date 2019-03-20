<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memberNotes {

private $contractKey = null;
private $contractHeader = null;
private $contractFooter = '</div>';
private $targetDrops = null;
private $noteForm = null;
private $noteKey = 1;
private $targetAppId = null;
private $userName = null;
private $userId = null;
private $noteList = null;
private $noteDate = null;
private $noteDateOrig = null;
private $noteTopic = null;
private $applicationGroup = null;
private $notePriority = null;
private $noteTable = null;
private $rowCount = null;
private $noteSecs = null;
private $prioritySecs = null;
private $expirationSecs = null;
private $columnSql = null;
private $noteNumber = null;
private $notepage = null;
private $divisor = "|";
private $xBox = null;
private $memSwitch = null; //this is set up so that if set it filters out member records


function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }
function setTargetDrops($targetDrops) {
                 $this->targetDrops = $targetDrops;
              }
function setNoteKey($noteKey) {
                 $this->noteKey = $noteKey;
              }
function setTargetAppId($targetAppId) {
                 $this->targetAppId = $targetAppId;
              }              
function setXbox($xBox) {
                 $this->xBox = $xBox;
              }
function setMemSwitch($memSwitch) {
                 $this->memSwitch = $memSwitch;
              }
function setNoteTopic($noteTopic) {
       $this->noteTopic = $noteTopic;
       }
function setNoteMessage($noteMessage) {
       $this->noteMessage = $noteMessage;
       }
function setNoteDate($date) {
       $this->noteDate = $date;
       }                 
              
//-------------------------------------             
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}
//---------------------------------------------------------------------------------------------------------
function parseNoteList() {

   switch($this->notePriority)  {
             case "L":
             $rowClass = 'yellowBack';
             break;
             case "M":
             $rowClass = 'orangeBack';
             break;
             case "H":
             $rowClass = 'redBack';
             break;
             }
$h =  date('h',strtotime($this->noteDateOrig)); 
$m =  date('i',strtotime($this->noteDateOrig)); 
$s =  date('s',strtotime($this->noteDateOrig));            
$month = date('m',strtotime($this->noteDateOrig));
$day = date('d',strtotime($this->noteDateOrig));
$year = date('Y',strtotime($this->noteDateOrig));

if ($this->ampm == 'PM'){
    $h = 00;
}else{
    $buff = 0;
}
$date = date('Y-m-d H:i:s',mktime($h,$m,$s,$month,$day,$year));

$this->noteList .= "
<tr class=\"$rowClass\">
<td class=\"black\">
$this->noteDate
</td>
<td class=\"black\">
$this->userName
</td>
<td class=\"black\">
$this->applicationGroup
</td>
<td class=\"black\">
$this->noteTopic
</td>
<td class=\"black\">
<div class=\"ShowHide\">View</div>
</td>
<td class=\"black\">
<ul>
<input type=\"button\" name=\"del_note\" id=\"del_note\" value=\"Delete\" class=\"button1 delNote\" topic2=\"$this->noteTopic\" message2=\"$this->noteMessage\" contract_key2=\"$this->contractKey\"\" onClick=\"return deleteNote('$date','$this->noteTopic','$this->noteMessage','$this->contractKey');\"/>
</ul>

</td>
</tr>

<tr class=\"hiddenTR\">
<td colspan=\"5\" class=\"black8\">
$this->noteMessage
</td>
<tr>
";

}
//---------------------------------------------------------------------------------------------------------
function loadUserName() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_name FROM admin_passwords WHERE user_id = '$this->userId'");
   $stmt->execute();      
   $stmt->store_result();  
   $rowCount = $stmt->num_rows;
   $stmt->bind_result($user_name);
   $stmt->fetch();

  if($rowCount !=0) {
     $this->userName = $user_name;
     }else{
     $this->userName = 'NA';
     }



$stmt->close(); 

}
//----------------------------------------------------------------------------------------------------------
function loadContractHeader() {

if($this->xBox == 1) {
   $closeOpen = "<span class=\"closeThree\">X</span>";
   }else{
   $closeOpen = "";
   }
  

$this->contractHeader ="
<div class=\"notesTable\" id=\"notesTable\">
<span class=\"contractNumberHeader\">Contract Number:&nbsp;&nbsp;</span>
<span class=\"contractNumber\">$this->contractKey</span>
$closeOpen 
<p>";

}
//============================================================
function  loadNoteForm()  {

if($this->xBox == 1) {
   $scriptEvent = "";
   $submitEvent = "";
   $saveClass = 'saveNote';
   }else{
   $scriptEvent = "onClick=\"toggleNoteDiv(this.id);\"";
   $submitEvent = "onClick=\"return sendNote('BL');\"";
   $saveClass = "";
   }

if($this->noteKey == 1) {


$this->noteForm = " 
<table id=\"noteTab2\" align=\"center\" cellpadding=\"3\" class=\"noteBoard2\">
<tr class=\"noteHead\">
<td colspan=\"2\" class=\"noteText\">Create / Send Note</td>
</tr>

<tr>
<td class=\"black noteTab\" valign=\"middle\">
Topic:
</td>
<td class=\"black noteTab\" valign=\"top\">
Note:
</td>
</tr>

<tr>
<td align=\"left\" class=\"noteTab\">
<input  name=\"topic\" type=\"text\" id=\"topic\" value=\"\" size=\"25\" maxlength=\"50\" />
</td>
<td align=\"left\" rowspan=\"5\" valign=\"top\"class=\"noteTab\">
<textarea cols=\"30\" rows=\"7\" name=\"message\" id=\"message\"></textarea>
</td>
</tr> 

<tr>
<td class=\"black noteTab\" valign=\"middle\">
Target:
</td>
</tr>

<tr>
<td align=\"left\" class=\"noteTab\">
<select name=\"target_app\" id=\"target_app\">
$this->targetDrops
</select>
</td>
</tr>

<tr>
<td class=\"black noteTab\" valign=\"bottom\">
Priority:
</td>
</tr>

<tr>
<td class=\"black noteTab\">

<table width=\"100%\" cellspacing=\"0\">
<tr>
<td wdth=\"30%\" align=\"left\">
Low<input name=\"priority\" id= \"low\" type=\"radio\" class=\"outCheck\" value=\"L\" $scriptEvent checked /> 
</td>
<td>
Medium<input name=\"priority\" id= \"medium\" type=\"radio\" class=\"outCheck\" value=\"M\" $scriptEvent/>
</td>
<td>
High<input name=\"priority\" id= \"high\" type=\"radio\" class=\"outCheck\" value=\"H\" $scriptEvent/>
</td>
</tr>
</table>

</td>
</tr>

<tr>
<td class=\"black noteTab\">

<table width=\"100%\" cellspacing=\"0\">
<tr>
<td width=\"30%\" align=\"left\">
<div id=\"yellow2\"></div> 
</td>
<td width=\"40%\" align=\"left\">
<div id=\"orange2\"></div>
</td>
<td>
<div id=\"red2\"></div>
</td>
</tr>
</table>

</td>
<td class=\"black noteTab\">
<input type=\"button\" name=\"end_note\" id=\"end_note\" value=\"Send Note\" class=\"button1 $saveClass\" $submitEvent/>
</td>
</tr>
</table>";


}else{







}

}
//============================================================
function loadNoteList()  {

if($this->memSwitch == null) {
   $memSql = "";
   }else{
   $memSql = "AND member_id= '0'";
   }

if($this->targetAppId = 'BL'){
    $wildCard = "target_app != ''";
}else{
    $wildCard = "target_app = '$this->targetAppId'";
}


   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_id, note_date, am_pm, note_topic , note_message, note_category, priority FROM account_notes WHERE contract_key = '$this->contractKey' AND $wildCard $memSql ORDER BY note_date DESC");
   $stmt->execute();      
   $stmt->store_result();  
   $rowCount = $stmt->num_rows;
   $stmt->bind_result($user_id, $note_date, $am_pm, $note_topic , $note_message, $note_category, $priority);
   
 $this->noteNumber = $rowCount;
   
if($rowCount != 0) {

        while ($stmt->fetch()) { 
             $this->noteDateRaw = $note_date;
                //first get the user name
                 $this->userId = $user_id;
                 $this->loadUserName();

               //format the date into english
                 $note_date = date('D F j, Y  g:i', strtotime($note_date));
                 $this->noteDate = "$note_date$am_pm";
                 $this->ampm = $am_pm;
                 
                 
                 $this->noteTopic = $note_topic;
                 $this->noteMessage = $note_message;
                 
                 switch($note_category)  {
                            case "NS":
                            $this->applicationGroup = 'New Sales';
                            break;
                            case "RS":
                            $this->applicationGroup = 'Renewal Sales';
                            break;
                            case "US":
                            $this->applicationGroup = 'Upgrade Sales';
                            break;
                            case "IS":
                            $this->applicationGroup = 'Internet Sales';
                            break;
                            case "BL":
                            $this->applicationGroup = 'Billing Services';
                            break;
                            case "MI":
                            $this->applicationGroup = 'Member Interface';
                            break;
                            case "EM":
                            $this->applicationGroup = 'Employee Services';
                            break;                            
                          }

                   $this->notePriority = $priority;

                    //create the listing
                    $this->parseNoteList();

               }
           
}else{

$this->noteList ="<tr><td colspan=\"5\" class=\"redText noteTile2\">No Notes Available</td></tr>";

}

$this->noteTable ="
<table id=\"reportNotes\" cellpadding=\"2\" class=\"noteBoard1\" align=\"center\"> 
<tr class=\"noteHead\">
<td colspan=\"7\" class=\"noteText\">
Current Notes on Account
</td>
</tr>
<tr class=\"noteHead\">
<td class=\"noteText3 noteTile6 noteTile3\">   
DateTime
</td>
<td class=\"noteText3 noteTile6\">
User Name
</td>
<td class=\"noteText3 noteTile6\">
Application Group
</td>
<td class=\"noteText3 noteTile6\">
Topic
</td> 
<td class=\"noteText3 noteTile6\">
Message
 </td>
<td class=\"noteText3 noteTile6 noteTile4\">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delete
 </td>                      
 </tr>
$this->noteList
</table>";

}
//============================================================
function deleteNote() {

$dbMain = $this->dbconnect();
$sql = "DELETE FROM account_notes WHERE contract_key = ?  AND  priority = ?  AND note_date = ?";
		
		if ($stmt = $dbMain->prepare($sql))   {
			$stmt->bind_param("iss", $contractKey, $priority, $noteDate);
			$contractKey = $this->contractKey; 
			$priority = $this->notePriority;
			$noteDate = $this->noteDateOrig;
			$stmt->execute();
			$stmt->close();
            }else{
			 printf("Errormessage: %s\n", $dbMain->error);
			 die("Could not prepare SQL statement: $sql");
		     }
         
}
//============================================================
function deleteNoteTwo() {
    
$this->noteMessage = trim($this->noteMessage);
$this->noteTopic = trim($this->noteTopic);    
//echo "$this->contractKey          $this->noteTopic                    $this->noteDate      ";
//exit;
$dbMain = $this->dbconnect();
$sql = "DELETE FROM account_notes WHERE contract_key = '$this->contractKey'  AND  note_message = '$this->noteMessage'   AND note_topic = '$this->noteTopic'";	
$stmt = $dbMain->prepare($sql);
if($stmt->execute()){
    $this->result = 1;
}else{
     $this->result = 0;
}
$stmt->close();

$noteDate = date("Y-m-d H:i:s");
$sql = "INSERT INTO account_notes_deleted VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $this->contractKey, $this->noteTopic, $this->noteMessage,$noteDate);
$stmt->execute();
$stmt->close(); 

         
}
//============================================================
function loadDurationSecs() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT $this->columnSql FROM manage_notes WHERE $this->columnSql !=''");
   $stmt->execute();      
   $stmt->store_result();  
   $rowCount = $stmt->num_rows;
   $stmt->bind_result($priority_days);
   $stmt->fetch(); 
   
   $daySecs = 86400;   
   $seconds = $daySecs * $priority_days;
   
    return $seconds;   

}
//============================================================
function parseNoteStatus() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT note_date,  priority FROM account_notes WHERE contract_key = '$this->contractKey' AND target_app = '$this->targetAppId' ORDER BY note_date DESC");
   $stmt->execute();      
   $stmt->store_result();  
   $rowCount = $stmt->num_rows;
   $stmt->bind_result($note_date, $priority);

         if($rowCount != 0) {

                 while ($stmt->fetch()) { 
        
                           $this->noteSecs = strtotime($note_date);
                           $this->noteDateOrig = $note_date;
                           $this->notePriority = $priority;
                           $this->todaySecs = time();
                           
                            switch($this->notePriority)  {
                            case "L":
                            $this->columnSql = 'low_days';
                            $this->prioritySecs = $this->loadDurationSecs();
                            break;
                            case "M":
                            $this->columnSql = 'medium_days';
                            $this->prioritySecs = $this->loadDurationSecs();
                            break;
                            case "H":
                            $this->columnSql = 'high_days';
                            $this->prioritySecs = $this->loadDurationSecs();
                            break;
                            }
                           
                           //add the duration of the note to the time stamp of the note check to make sure todays stamp is greater thatn ethe stamp
                           $this->expirationSecs = $this->prioritySecs + $this->noteSecs;
                             //if the priority secs is set o zero then we do not delete
                             if($this->prioritySecs != 0) {
                                 if($this->todaySecs > $this->expirationSecs) {                           
                                     $this->deleteNote();
                                    }   
                               }
                      }
        }

}
//============================================================

function getContractHeader() {
          return($this->contractHeader);
          }
                   
function getContractFooter() {
          return($this->contractFooter);
          }

function getNoteForm() {
          return($this->noteForm);
          }

function getNoteTable() {
          return($this->noteTable);
          }

function getNoteNumber() {
          return($this->noteNumber);
          }

function  getNotePage() {
          return("$this->contractHeader $this->noteForm $this->noteTable $this->contractFooter $this->divisor $this->noteNumber");
          }
function getDeleteResult() {
          return($this->result);
          }         


}
//=============================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$priority = $_REQUEST['priority'];
$target_app = $_REQUEST['target_app'];
$message = $_REQUEST['message'];
$topic = $_REQUEST['topic'];
$from_app = $_REQUEST['from_app'];
$contract_key = $_REQUEST['contract_key'];
$date = $_REQUEST['date'];
//
$tempKey = $_SESSION['contract_key'];
if ($tempKey != ''){
    $contract_key = $_SESSION['contract_key'];
}
                 
if($ajax_switch == 1)  {

//getst the target dropdown for notes
$targetApp = 'assignment_billing';
$target_app_id = 'BL';
include "noteSql.php";
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();



//$user_id = $_SESSION['user_id'];
//$contract_key = '1651';


//gets the contract header and the note form
$memberNotes = new memberNotes();
$memberNotes-> setContractKey($contract_key);
$memberNotes-> loadContractHeader();
$memberNotes-> setTargetDrops($target_drops);
$memberNotes-> loadNoteForm(); 
$note_form = $memberNotes-> getNoteForm();

//get the note list
$memberNotes-> setTargetAppId($target_app_id);
$memberNotes-> parseNoteStatus();
$memberNotes-> loadNoteList();
$note_table = $memberNotes-> getNoteTable();

$header = $memberNotes-> getContractHeader();
$footer = $memberNotes-> getContractFooter();


$notePage =  "$header  $note_form  $note_table $footer";  
echo"$notePage";
exit;
}

//----------------------------------------------------------------------------------------
if($ajax_switch == 2) {

$user_id = 0;
//decode the info from the ajax post
$message = urldecode($message);
$topic = urldecode($topic);
$topic = trim($topic);
$message = trim($message);

include "noteSql.php";
$saveNote = new noteSql();
$saveNote-> setNoteTopic($topic);
$saveNote-> setContractKey($contract_key);
$saveNote-> setNoteMessage($message);
$saveNote-> setNoteUser($user_id);
$saveNote-> setNotePriority($priority);
$saveNote-> setTargetAppId($target_app);
$saveNote-> setNoteCategory($from_app);    
$save_result = $saveNote-> saveNote();

if($save_result == 1) {

//getst the target dropdown for notes
$targetApp = 'assignment_member';
$target_app_id = 'MI';
$x_box = 1;
$mem_switch = 1;
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();

//gets the contract header and the note form
$memberNotes = new memberNotes();
$memberNotes-> setXbox($x_box);
$memberNotes-> setMemSwitch($mem_switch);
$memberNotes-> setContractKey($contract_key);
$memberNotes-> loadContractHeader();
$memberNotes-> setTargetDrops($target_drops);
$memberNotes-> loadNoteForm(); 
$note_form = $memberNotes-> getNoteForm();

//get the note list
$memberNotes-> setTargetAppId($target_app_id);
$memberNotes-> parseNoteStatus();
$memberNotes-> loadNoteList();
$note_table = $memberNotes-> getNoteTable();

$header = $memberNotes-> getContractHeader();
$footer = $memberNotes-> getContractFooter();
$note_number = $memberNotes-> getNoteNumber();
$note_number = trim($note_number);

$notePage =  "$header  $note_form  $note_table|$note_number";  
echo"$notePage";
exit;

}
}
//echo"xxsdfsdf $ajax_switch";
//exit;
if($ajax_switch == 3) {
$memberNotes = new memberNotes();
$user_id = 0;
//decode the info from the ajax post
$message = urldecode($message);
$topic = urldecode($topic);
$date = urldecode($date);
$contract_key = urldecode($contract_key);
$target_app = urldecode($target_app);
//echo "fubar";
//exit;
$topic = trim($topic);
$message = trim($message);

$memberNotes-> setNoteTopic($topic);
//echo "$topic  $contract_key  $message  $date";
//exit;
$memberNotes-> setContractKey($contract_key);
$memberNotes-> setNoteMessage($message);
$memberNotes-> setNoteDate($date);

$memberNotes-> deleteNoteTwo();
$result = $memberNotes-> getDeleteResult();
   
echo "$result";
exit;
}




/*
$accountInfoTemplate = <<<ACCOUNTINFOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/accountInfo.css"/>
<link rel="stylesheet" href="../css/notesTwo.css"/>
<script type="text/javascript" src="../scripts/memberNotes.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/showNotes.js"></script>

<title>Untitled</title>
</head>
<body>
<div id="payCont" style="position: absolute; top: 0px; width: 830px">

$header   
$note_form  
$note_table
$footer

</div>
</body>
</html>
ACCOUNTINFOTEMPLATE;
echo"$accountInfoTemplate";
*/


?>