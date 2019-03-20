<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memberNotesTwo {

private $contractKey = null;
private $memberId = null;
private $contractHeader = null;
private $targetDrops = null;
private $noteForm = null;
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
private $memberName = null;
private $noteButtonId = null;


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
function setMemberName($memberName) {
                 $this->memberName = $memberName;
              }
//this member id is actually the member key rather than the bar code id           
function setMemberId($memberId) {
                 $this->memberId = $memberId;
              }
function setNoteButtonId($noteButtonId) {
                 $this->noteButtonId = $noteButtonId;
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

$this->contractHeader ="
<span class=\"contractNumberHeader\">Member Name:&nbsp;&nbsp;</span>
<span class=\"contractNumber\">$this->memberName</span>
<span class=\"closeFive\">X</span>
<p>";

}
//============================================================
function  loadNoteForm()  {


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
<input  name=\"topic_two\" type=\"text\" id=\"topic_two\" value=\"\" size=\"25\" maxlength=\"50\" />
</td>
<td align=\"left\" rowspan=\"5\" valign=\"top\"class=\"noteTab\">
<textarea cols=\"30\" rows=\"7\" name=\"message_two\" id=\"message_two\"></textarea>
</td>
</tr> 

<tr>
<td class=\"black noteTab\" valign=\"middle\">
Target:
</td>
</tr>

<tr>
<td align=\"left\" class=\"noteTab\">
<select name=\"target_app_two\" id=\"target_app_two\">
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
Low<input name=\"priority_two\" id= \"low\" type=\"radio\" class=\"outCheck prioType\" value=\"L\" checked/> 
</td>
<td>
Medium<input name=\"priority_two\" id= \"medium\" type=\"radio\" class=\"outCheck prioType\" value=\"M\"/>
</td>
<td>
High<input name=\"priority_two\" id= \"high\" type=\"radio\" class=\"outCheck prioType\" value=\"H\" />
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
<div id=\"yellow3\"></div> 
</td>
<td width=\"40%\" align=\"left\">
<div id=\"orange3\"></div>
</td>
<td>
<div id=\"red3\"></div>
</td>
</tr>
</table>

</td>
<td class=\"black noteTab\">
<input type=\"button\" name=\"end_note_two\" id=\"end_note_two\" data-memberKey=\"$this->memberId\" data-memberName=\"$this->memberName\" data-contractKey=\"$this->contractKey\" data-noteButtonId=\"$this->noteButtonId\" value=\"Send Note\" class=\"button1 saveMemberNoteTwo\"/>
</td>
</tr>
</table>";


}
//============================================================
function loadNoteList()  {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT user_id, note_date, am_pm, note_topic , note_message, note_category, priority FROM account_notes WHERE contract_key = '$this->contractKey' AND target_app = '$this->targetAppId' AND member_id='$this->memberId' ORDER BY note_date DESC");
   $stmt->execute();      
   $stmt->store_result();  
   $rowCount = $stmt->num_rows;
   $stmt->bind_result($user_id, $note_date, $am_pm, $note_topic , $note_message, $note_category, $priority);
   
 $this->noteNumber = $rowCount;
   
if($rowCount != 0) {

        while ($stmt->fetch()) { 
             
                //first get the user name
                 $this->userId = $user_id;
                 $this->loadUserName();

               //format the date into english
                 $note_date = date('D F j, Y  g:i', strtotime($note_date));
                 $this->noteDate = "$note_date$am_pm";
                 
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
<td colspan=\"5\" class=\"noteText\">
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
<td class=\"noteText3 noteTile6 noteTile4\">
Message
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
         


}
//=============================================================
$ajax_switch = $_REQUEST['ajax_switch'];
$member_key = $_REQUEST['member_key'];
$contract_key = $_REQUEST['contract_key'];
$member_id = $_REQUEST['member_id'];
$member_name = $_REQUEST['member_name'];
$note_button_id  = $_REQUEST['note_button_id'];                           
$priority  = $_REQUEST['priority']; 
$target_app  = $_REQUEST['target_app']; 
$message  = $_REQUEST['message']; 
$topic  = $_REQUEST['topic']; 
$from_app  = $_REQUEST['from_app']; 

           
                 
if($ajax_switch == 1)  {

//getst the target dropdown for notes
$targetApp = 'assignment_member';
$target_app_id = 'MI';
include "noteSql.php";
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();


//gets the contract header and the note form
$memberNotes = new memberNotesTwo();
$memberNotes-> setContractKey($contract_key);
$memberNotes-> setMemberId($member_key);
$memberNotes-> setMemberName($member_name);
$memberNotes-> setNoteButtonId($note_button_id);
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
$saveNote-> setMemberId($member_key);
$saveNote-> setNotePriority($priority);
$saveNote-> setTargetAppId($target_app);
$saveNote-> setNoteCategory($from_app);    
$save_result = $saveNote-> saveNote();


if($save_result == 1) {

//getst the target dropdown for notes
$targetApp = 'assignment_member';
$target_app_id = 'MI';
$loadTargets = new noteSql();
$loadTargets-> setTargetApp($targetApp);
$target_drops = $loadTargets-> loadDropDowns();

//gets the contract header and the note form
$memberNotes = new memberNotesTwo();
$memberNotes-> setContractKey($contract_key);
$memberNotes-> setMemberId($member_key);
$memberNotes-> setMemberName($member_name);
$memberNotes-> setNoteButtonId($note_button_id);
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
$note_number = $memberNotes-> getNoteNumber();
$note_number = trim($note_number);

$notePage =  "$header $note_form  $note_table|$note_number";  
echo"$notePage";
exit;

}
}  //end ajax switch two
//-----------------------------------------------------------------------------------------------------




?>