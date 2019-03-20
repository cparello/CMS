<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memberInfo {

private $contractKey = null;
private $stateId = 1;
private $state = null;
private $stateList = null;
private $cellCount = 0;
private $firstName = null;
private $middleName = null;
private $lastName = null;
private $streetAddress = null;
private $cityName = null;
private $zipCode = null;
private $cellPhone = null;
private $homePhone = null;
private $emailAddress = null;
private $birthDate = null;
private $licenseNumber = null;
private $emgName = null;
private $emgRelation = null;
private $emgPhone = null;
private $contactRows = null;
private $memberId = null;
private $generalId = null;
private $memberContent = null;
private $memberPhoto = null;



function setContractKey($contractKey) {
                 $this->contractKey = $contractKey;
              }


//-------------------------------------             
//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;              
}

//=================================================
function stateSelect() {


switch ($this->state)  {
case "AL":
$AL ="selected";
break;
case "AK":
$AK="selected";
break;
case "AZ":
$AZ="selected";
break;
case "AR":
$AR="selected";
break;
case "CA":
$CA="selected";
break;
case "CO":
$CO="selected";
break;
case "DE":
$DE="selected";
break;
case "DC":
$DC="selected";
break;
case "FL":
$FL="selected";
break;
case "GA":
$GA="selected";
break;
case "HI":
$HI="selected";
break;
case "ID":
$ID="selected";
break;
case "IL":
$IL="selected";
break;
case "IN":
$IN="selected";
break;
case "IA":
$IA="selected";
break;
case "KS":
$KS="selected";
break;
case "KY":
$KY="selected";
break;
case "LA":
$LA="selected";
break;
case "LA":
$ME="selected";
break;
case "MD":
$MD="selected";
break;
case "MA":
$MA="selected";
break;
case "MI":
$MI="selected";
break;
case "MN":
$MN="selected";
break;
case "MS":
$MS="selected";
break;
case "MO":
$MO="selected";
break;
case "MT":
$MT="selected";
break;
case "NE":
$NE="selected";
break;
case "NV":
$NV="selected";
break;
case "NH":
$NH="selected";
break;
case "NJ":
$NJ="selected";
break;
case "NM":
$NM="selected";
break;
case "NY":
$NY="selected";
break;
case "NC":
$NC="selected";
break;
case "ND":
$ND="selected";
break;
case "OH":
$OH="selected";
break;
case "OK":
$OK="selected";
break;
case "OR":
$OR="selected";
break;
case "PA":
$PA="selected";
break;
case "RI":
$RI="selected";
break;
case "SC":
$SC="selected";
break;
case "SD":
$SD="selected";
break;
case "TN":
$TN="selected";
break;
case "TX":
$TX="selected";
break;
case "UT":
$UT="selected";
break;
case "VT":
$VT="selected";
break;
case "VA":
$VA="selected";
break;
case "WA":
$WA="selected";
break;
case "WV":
$WV="selected";
break;
case "WI":
$WI="selected";
break;
case "WY":
$WY="selected";
break;
}





$this->stateList = "
<select name=\"state\" id=\"state$this->cellCount\" onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\">
<option value=\"\">Select State</option>
<option value=\"AL\" $AL>Alabama</option>
<option value=\"AK\" $AK>Alaska</option>
<option value=\"AZ\" $AZ>Arizona</option>
<option value=\"AR\" $AR>Arkansas</option>
<option value=\"CA\" $CA>California</option>
<option value=\"CO\" $CO>Colorado</option>
<option value=\"CT\" $CT>Connecticut</option>
<option value=\"DE\" $DE>Delaware</option>
<option value=\"DC\" $DC>Wash. D.C.</option>
<option value=\"FL\" $FL>Florida</option>
<option value=\"GA\" $GA>Georgia</option>
<option value=\"HI\" $HI>Hawaii</option>
<option value=\"ID\" $ID>Idaho</option>
<option value=\"IL\" $IL>Illinois</option>
<option value=\"IN\" $IN>Indiana</option>
<option value=\"IA\" $IA>Iowa</option>
<option value=\"KS\" $KS>Kansas</option>
<option value=\"KY\" $KY>Kentucky</option>
<option value=\"LA\" $LA>Louisiana</option>
<option value=\"ME\" $ME>Maine</option>
<option value=\"MD\" $MD>Maryland</option>
<option value=\"MA\" $MA>Massachusetts</option>
<option value=\"MI\" $MI>Michigan</option>
<option value=\"MN\" $MN>Minnesota</option>
<option value=\"MS\" $MS>Mississippi</option>
<option value=\"MO\" $MO>Missouri</option>
<option value=\"MT\" $MT>Montana</option>
<option value=\"NE\" $NE>Nebraska</option>
<option value=\"NV\" $NV>Nevada</option>
<option value=\"NH\" $NH>New Hampshire</option>
<option value=\"NJ\" $NJ>New Jersey</option>
<option value=\"NM\" $NM>New Mexico</option>
<option value=\"NY\" $NY>New York</option>
<option value=\"NC\" $NC>North Carolina</option>
<option value=\"ND\" $ND>North Dakota</option>
<option value=\"OH\" $OH>Ohio</option>
<option value=\"OK\" $OK>Oklahoma</option>
<option value=\"OR\" $OR>Oregon</option>
<option value=\"PA\" $PA>Pennsylvania</option>
<option value=\"RI\" $RI>Rhode Island</option>
<option value=\"SC\" $SC>So. Carolina</option>
<option value=\"SD\" $SD>So. Dakota</option>
<option value=\"TN\" $TN>Tennessee</option>
<option value=\"TX\" $TX>Texas</option>
<option value=\"UT\" $UT>Utah</option>
<option value=\"VT\" $VT>Vermont</option>
<option value=\"VA\" $VA>Virginia</option>
<option value=\"WA\" $WA>Washington</option>
<option value=\"WV\" $WV>West Virginia</option>
<option value=\"WI\" $WI>Wisconsin</option>
<option value=\"WY\" $WY>Wyoming</option>
</select>";
}

//=================================================
function createMemberContent() {

$firstYearName = date("Y");
$firstYearValue = date("y");
$secondYearName = date("Y")-1;
$secondYearValue = date("y")-1;
$thirdYearName = date("Y")-2;
$thirdYearValue = date("y")-2;
$fourthYearName = date("Y")-3;
$fourthYearValue = date("y")-3;
$fifthYearName = date("Y")-4;
$fifthYearValue = date("y")-4;
$sixthYearName = date("Y")-5;
$sixthYearValue = date("y")-5;
$seventhYearName = date("Y")-6;
$seventhYearValue = date("y")-6;


 $dbMain = $this->dbconnect();
 $stmt = $dbMain ->prepare("SELECT do_not_call_cell, do_not_call_home, do_not_email, do_not_text, do_not_mail, prefered_contact_method FROM contact_preferences WHERE contract_key = '$this->contractKey'");
 $stmt->execute();      
 $stmt->store_result();      
 $stmt->bind_result($do_not_call_cell, $do_not_call_home, $do_not_email, $do_not_text, $do_not_mail, $prefered_contact_method);
 $stmt->fetch();
 $stmt->close();  
 
 if($do_not_call_cell == "Y"){
    $dncc = "checked";
 }
 if($do_not_call_home == "Y"){
    $dnch = "checked";
 }
 if($do_not_email == "Y"){
    $dne = "checked";
 }
 if($do_not_text == "Y"){
    $dnt = "checked";
 }
 if($do_not_mail == "Y"){
    $dnm = "checked";
 }

 switch ($prefered_contact_method){
    case 'home_phone':
        $selected = "<option selected value=\"home_phone\">Home Phone</option>";
    break;
    case 'cell_phone':
        $selected = "<option selected value=\"cell_phone\">Cell Phone</option>";
    break;
    case 'email':
        $selected = "<option selected value=\"email\">Email</option>";
    break;
    case 'text':
        $selected = "<option selected value=\"text\">Text</option>";
    break;
    case 'mail':
        $selected = "<option selected value=\"mail\">Mail</option>";
    break;
    default:
        $selected = "<option selected value=\"none\">None</option>";
    break;
 }
$this->memberContent = "
<div class=\"hisitoryTable\">
<span class=\"contractNumberHeader\">Contract Number:&nbsp;&nbsp;</span>
<span class=\"contractNumber\">$this->contractKey</span>
<p>
<form>
<table id=\"secTab4\" align=\"left\" cellpadding=\"2\" class=\"tabBoard4\">
$this->contactRows
</table>
</form>
</p>
<table align=\"middle\" border=\"0\" cellpadding=\"0\" cellspacing=\"4\" width=\"100%\">
<tbody>
  <tr>
    <h3><Center>Contact Preferences</Center></h3>
  </tr>
  <tr>
   <th>Do not call home</th>
   <th>Do not call cell</th>
   <th>Do not email</th>
   <th>Do not mail</th>
   <th>Do not text message</th>
   <th>Preferred Contact Method</th>
  </tr>
  <tr>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"no_call_home\" id=\"no_call_home\"  value=\"1\" $dnch></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"no_call_cell\" id=\"no_call_cell\"  $dncc value=\"2\"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"no_email\" id=\"no_email\"  $dne value=\"3\"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"no_mail\" id=\"no_mail\"  $dnm value=\"4\"/></td>
   <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <input type=\"checkbox\" name=\"no_text\" id=\"no_text\"  $dnt value=\"4\"/></td>
   <td>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  <select name=\"pref_contact\" id=\"pref_contact\">
      $selected
        <option value=\"home_phone\">Home Phone</option>
        <option value=\"cell_phone\">Cell Phone</option>
        <option value=\"email\">Email</option>
        <option value=\"text\">Text</option>
        <option value=\"email\">Email</option>
        <option value=\"mail\">Mail</option>
        <option value=\"none\">None</option>
      </select> 
   </td>
  </tr>
  <tr>
  <td><span id=\"homeBox\"></span></td>
  <td><span id=\"cellBox\"></span></td>
  <td><span id=\"emailBox\"></span></td>
  <td><span id=\"mailBox\"></span></td>
  <td><span id=\"textBox\"></span></td>
  <td><span id=\"prefBox\"></span></td>
  </tr>
  </tbody>
</table>
<p class=\"bbackheader\"><Center><H3><strong>Attendance</strong></Center></H3></p>
<tr>
<td align=\"bottom\" width=\"100\">
&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<strong>Select Date:</strong> 
</td>
<td>
<select name=\"cexp_date1\" id=\"cexp_date1\">
<option value=\"01\">January</option>
<option value=\"02\">February</option>
<option value=\"03\">March</option>
<option value=\"04\">April</option>
<option value=\"05\">May</option>
<option value=\"06\">June</option>
<option value=\"07\">July</option>
<option value=\"08\">August</option>
<option value=\"09\">September</option>
<option value=\"10\">October</option>
<option value=\"11\">November</option>
<option value=\"12\">December</option>
</select> 
</td>
<td>
<select name=\"year\" id=\"year\">
<option value=\"$firstYearValue\">$firstYearName</option>
<option value=\"$secondYearValue\">$secondYearName</option>
<option value=\"$thirdYearValue\">$thirdYearName</option>
<option value=\"$fourthYearValue\">$fourthYearName</option>
<option value=\"$fifthYearValue\">$fifthYearName</option>
<option value=\"$sixthYearValue\">$sixthYearName</option>
<option value=\"$seventhYearValue\">$seventhYearName</option>
</select> 
</td>
<td align=\"left\">
<input type=\"button\" id=\"pop_window\" name=\"pop_window\" value=\"Load Attendance\" class=\"button1\" onClick=\"openAttendance();\"/>
</td>
</tr>
</div>";

}
//=================================================
function parseContactRows() {

$this->stateSelect();

$this->contactRows .= "
<tr class=\"tabHead\">
<td colspan=\"2\" class=\"oBtext tile3\">
<span id=\"typeHead$this->cellCount\">Member Information </span>  $this->cellCount
</td>
<td align=\"right\" class=\"checkText tile4\" colspan=\"2\">
<div id=\"addSet$this->cellCount\"></div>
</td>
</tr>

<tr>
<td class=\"black tile3\">First Name:
</td>
<td class=\"black\">
Middle Name: <span class=\"dob\">(Optional)</span>
</td>
<td class=\"black\" >
Last Name:
</td>
<td class=\"black tile4\" colspan=\"2\">
Member ID:
</td>
</tr>

<tr>
<td class=\"black tile3\">
<input  name=\"first_name\" type=\"text\" id=\"first_name$this->cellCount\" value=\"$this->firstName\" size=\"25\" maxlength=\"60\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input name=\"middle_name\" type=\"text\" id=\"middle_name$this->cellCount\" value=\"$this->middleName\" size=\"25\" maxlength=\"100\" />
</td>
<td class=\"black\">
<input  name=\"last_name\" type=\"text\" id=\"last_name$this->cellCount\" value=\"$this->lastName\" size=\"25\" maxlength=\"30\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black tile4\">
<input  name=\"member_id\" type=\"text\" id=\"member_id$this->cellCount\" value=\"$this->memberId\" size=\"20\" maxlength=\"20\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
</tr>

<tr>
<td class=\"black tile3\">
Street Address:
</td>
<td class=\"black\">
City:
</td>
<td class=\"black\">
State:
</td>
<td class=\"black tile4\" rowspan=\"6\">
<img src=\"../memberphotos/$this->memberPhoto\" width=\"100\" height=\"125\" onError=\"this.src = '../memberphotos/no_photo.jpg'\">
</td>

</tr>

<tr>
<td class=\"black tile3\">
<input name=\"street_address\" type=\"text\" id=\"street_address$this->cellCount\" value=\"$this->streetAddress\" size=\"25\" maxlength=\"100\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input name=\"city\" type=\"text\" id=\"city$this->cellCount\" value=\"$this->cityName\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
$this->stateList
</td>
</tr>

<tr>
<td class=\"black tile3\">
Zipcode:
</td>
<td class=\"black\">
Primary Phone:
</td>
<td class=\"black\">
Cell Phone:
</td>
</tr>

<tr>
<td class=\"black tile3\">
<input name=\"zip_code\" type=\"text\" id=\"zip_code$this->cellCount\" value=\"$this->zipCode\" size=\"25\" maxlength=\"5\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input name=\"home_phone\" type=\"text\" id=\"home_phone$this->cellCount\" value=\"$this->homePhone\" size=\"25\" maxlength=\"15\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"cell_phone\" type=\"text\" id=\"cell_phone$this->cellCount\" value=\"$this->cellPhone\" size=\"25\" maxlength=\"15\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
</tr>

<tr>
<td class=\"black tile3\">
Email Address:
</td>
<td class=\"black\">
Date of Birth: <span class=\"dob\">(mm/dd/yyyy)</span>
</td>
<td class=\"black\">
Drivers License:
</td>
</tr>

<tr>
<td class=\"black tile3\">
<input  name=\"email\" type=\"text\" id=\"email$this->cellCount\" value=\"$this->emailAddress\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"dob\" type=\"text\" id=\"dob$this->cellCount\" value=\"$this->birthDate\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"lic_num\" type=\"text\" id=\"lic_num$this->cellCount\" value=\"$this->licenseNumber\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
</tr>

<tr class=\"tabHead\">
<td colspan=\"4\" class=\"oBtext tile3 tile4\">Emergency Contact Information $this->cellCount
</td>
</tr>

<tr>
<td class=\"black tile3\">
Contact Name:
</td>
<td class=\"black\">Relationship:
</td>
<td colspan=\"2\" class=\"black tile4\" colspan=\"2\">
Contact Phone:
</td>
</tr>

<tr>
<td class=\"black tile3 tile5\">
<input  name=\"econt_name\" type=\"text\" id=\"econt_name$this->cellCount\" value=\"$this->emgName\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"tile5\">
<input  name=\"econt_relation\" type=\"text\" id=\"econt_relation$this->cellCount\" value=\"$this->emgRelation\" size=\"25\" maxlength=\"30\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"tile5\">
<input  name=\"econt_phone\" type=\"text\" id=\"econt_phone$this->cellCount\" value=\"$this->emgPhone\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"tile4 tile5\">
<input type=\"button\" name=\"update\" id=\"update$this->cellCount\" value=\"Update Member\" class=\"button1\" onClick=\"return saveContactRecord('$this->cellCount', '$this->generalId', this.name, this.id);\"/>
</td>
</tr> 

<tr>
<td class=\"endFoot\" colspan=\"4\">
&nbsp;
</td>
</tr>";

}

//==============================================================
function loadContactInfo() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT general_id, member_id, first_name, middle_name, last_name, street, city, state, zip, primary_phone, cell_phone,  email, dob, license_number, emg_contact, emg_relationship,  emg_phone_phone, member_photo FROM member_info WHERE contract_key = '$this->contractKey' ORDER BY last_name DESC");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($general_id, $member_id, $first_name, $middle_name, $last_name, $street, $city, $state, $zip, $primary_phone, $cell_phone,  $email, $dob, $license_number, $emg_contact, $emg_relationship,  $emg_phone_phone, $member_photo);
   
   
while($stmt->fetch()) {       
         $this->generalId = $general_id;           
         $this->memberId = $member_id;
         $this->firstName = $first_name;
         $this->middleName = $middle_name;
         $this->lastName = $last_name;         
         $this->streetAddress = $street;
         $this->cityName = $city;
         $this->state = $state;
         $this->zipCode = $zip;
         $this->cellPhone = $cell_phone;
         $this->homePhone = $primary_phone;
         $this->emailAddress = $email;
         $this->birthDate = date('m/d/Y', strtotime($dob));
         
         if($first_name == "" && $last_name == "") {
            $this->birthDate = null;
            $this->zipCode = null;
           }
         
         $this->licenseNumber = $license_number;
         $this->emgName = $emg_contact;
         $this->emgRelation = $emg_relationship;
         $this->emgPhone = $emg_phone_phone;
         
         if($member_photo == "")  {
            $this->memberPhoto = 'no_photo.jpg';
            }else{
            $this->memberPhoto = $member_photo;
            }
         
         $this->cellCount++;
         $this->parseContactRows();
        }

$stmt->close();             

$this->createMemberContent();

}
//==============================================================
function getMemberContent() {
          return($this->memberContent);
          }

}

//----------------------------------------------------------------

$contract_key = $_SESSION['contract_key'];

$loadMembers = new memberInfo();
$loadMembers-> setContractKey($contract_key);
$loadMembers-> loadContactInfo();
$member_content = $loadMembers-> getMemberContent();

/*
$accountInfoTemplate = <<<ACCOUNTINFOTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link rel="stylesheet" href="../css/accountInfo.css"/>
<title>Untitled</title>
</head>
<body>


$member_content

</body>
</html>
ACCOUNTINFOTEMPLATE;
*/

echo"$member_content";




?>
