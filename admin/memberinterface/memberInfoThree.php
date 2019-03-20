<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class memberInfoThree {

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
private $bgClass = null;
private $headerMemberName = null;
private $noteCount = null;
private $holdCount = null;



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
function loadNoteCount() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM account_notes WHERE contract_key = '$this->contractKey' AND member_id='$this->generalId' ");
   $stmt->execute();      
   $stmt->store_result();  
   $stmt->bind_result($count);
   $stmt->fetch();
   
   $this->noteCount = $count;

}
//---------------------------------------------------------------------------------------
function checkMemberStatus() {

   $dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT count(*) AS count FROM member_hold WHERE contract_key = '$this->contractKey' AND general_id='$this->generalId' ");
   $stmt->execute();      
   $stmt->store_result();  
   $stmt->bind_result($count);
   $stmt->fetch();
   
   $this->holdCount = $count;


}
//---------------------------------------------------------------------------------------
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

$this->memberContent = "
<form>
<table id=\"secTab4Mem\" align=\"left\" cellpadding=\"3\" border=\"0\" class=\"tabBoard4Mem\">
<tr class=\"tabHeadMem\">
<td colspan=\"4\" class=\"oBtextMem tile3Mem\">
Member Information
</td>
</tr>
$this->contactRows
</table>
</form>";

}
//=================================================
function parseContactRows() {

$this->stateSelect();

$this->checkMemberStatus();

if($this->holdCount == 0) {
  $headerStyle = 'oBtextMemRecOne';
  $memStatus = 'Current';
  $holdDisabled = "";
  }else{
  $headerStyle = 'oBtextMemRecTwo';
  $memStatus = 'Hold';
  $holdDisabled = 'disabled=disabled';
  }

$this->contactRows .= "
<tr class=\"$this->bgClass showHideTwo\">
<td colspan=\"2\" class=\"$headerStyle tile3Mem\">
<span id=\"typeHead$this->cellCount\">Member Information </span>  $this->cellCount
</td>
<td colspan=\"2\" class=\"$headerStyle tile4Mem\">
<span class=\"headerMemName\">$this->memberHeaderName</span>
</td>
</tr>

<tr class=\"hiddenTR\">
<td colspan=\"4\" class=\"tile1Mem\">

<table class=\"memTab\">
<tr>
<td class=\"black\">First Name:
</td>
<td class=\"black\">
Middle Name: <span class=\"dob\">(Optional)</span>
</td>
<td class=\"black\" >
Last Name:
</td>
<td class=\"black\" colspan=\"2\">
Member ID:
</td>
</tr>

<tr>
<td class=\"black\">
<input  name=\"first_name\" type=\"text\" id=\"first_name$this->cellCount\" value=\"$this->firstName\" size=\"25\" maxlength=\"60\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input name=\"middle_name\" type=\"text\" id=\"middle_name$this->cellCount\" value=\"$this->middleName\" size=\"25\" maxlength=\"100\" />
</td>
<td class=\"black\">
<input  name=\"last_name\" type=\"text\" id=\"last_name$this->cellCount\" value=\"$this->lastName\" size=\"25\" maxlength=\"30\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"member_id\" type=\"text\" id=\"member_id$this->cellCount\" value=\"$this->memberId\" size=\"20\" maxlength=\"20\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
</tr>

<tr>
<td class=\"black\">
Street Address:
</td>
<td class=\"black\">
City:
</td>
<td class=\"black\">
State:
</td>
<td class=\"black\" rowspan=\"7\">
<img src=\"../memberphotos/$this->memberPhoto\" width=\125\" height=\"150\" onClick=\"return loadCamera('$this->cellCount');\" onError=\"this.src = '../memberphotos/no_photo.jpg'\"> 
</td>
</tr>

<tr>
<td class=\"black\">
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
<td class=\"black\">
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
<td class=\"black\">
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
<td class=\"black\">
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
<td class=\"black\">
<input  name=\"email\" type=\"text\" id=\"email$this->cellCount\" value=\"$this->emailAddress\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"dob\" type=\"text\" id=\"dob$this->cellCount\" value=\"$this->birthDate\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td class=\"black\">
<input  name=\"lic_num\" type=\"text\" id=\"lic_num$this->cellCount\" value=\"$this->licenseNumber\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
</tr>

<tr>
<td colspan=\"4\" class=\"padMem1\">Emergency Contact Information $this->cellCount
</td>
</tr>

<tr>
<td class=\"black\">
Contact Name:
</td>
<td class=\"black\">Relationship:
</td>
<td class=\"black\">
Contact Phone:
</td>
<td class=\"black\">
Member Status:
</td>
</tr>

<tr>
<td class=\"black\">
<input  name=\"econt_name\" type=\"text\" id=\"econt_name$this->cellCount\" value=\"$this->emgName\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input  name=\"econt_relation\" type=\"text\" id=\"econt_relation$this->cellCount\" value=\"$this->emgRelation\" size=\"25\" maxlength=\"30\"   onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input  name=\"econt_phone\" type=\"text\" id=\"econt_phone$this->cellCount\" value=\"$this->emgPhone\" size=\"25\" maxlength=\"30\"  onFocus=\"return checkMembers(this.name, this.id, $this->cellCount)\"/>
</td>
<td>
<input  name=\"member_status\" type=\"text\" id=\"member_status$this->cellCount\" value=\"$memStatus\" size=\"20\" readonly=readonly/>
</td>
</tr>

<tr>
<td class=\"black padTopMem\" colspan=\"4\">
<input type=\"button\" name=\"hold\" id=\"hold$this->cellCount\" value=\"Hold Member\" class=\"button1 holdMem\" data-memberKey=\"$this->generalId\" data-memberName=\"$this->memberHeaderName\" data-contractKey=\"$this->contractKey\" data-memberElementId=\"member_id$this->cellCount\" $holdDisabled/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"button\" name=\"notes\" id=\"notes$this->cellCount\" data-memberKey=\"$this->generalId\" data-memberName=\"$this->memberHeaderName\" data-contractKey=\"$this->contractKey\" data-memberElementId=\"member_id$this->cellCount\" value=\"Member Notes ($this->noteCount)\" class=\"button1 memNotes\"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"button\" name=\"update\" id=\"update$this->cellCount\" value=\"Update Member\" class=\"button1\" onClick=\"return saveContactRecord('$this->cellCount', '$this->generalId', this.name, this.id, '$this->contractKey');\"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type=\"button\" name=\"waiver\" id=\"waiver$this->cellCount\" value=\"Print Waiver\" class=\"button1\" onClick=\"return printMemberWaiver('$this->cellCount', '$this->generalId', this.name, this.id, '$this->contractKey');\"/>
</td>
</tr>

</table>




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

  //create color rows
    static $cell_count = 1;
    if($cell_count == 2) {
      $this->bgClass = "tabHeadMemTwo";
      $cell_count = "";
      }else{
      $this->bgClass = "tabHeadMemOne";
      }
      $cell_count = $cell_count + 1;
      
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
                  
         if($first_name == "" && $last_name == "") {
           $this->memberHeaderName = 'NA';
           }else{         
           $this->memberHeaderName = "$first_name $middle_name $last_name";
           }
         
         $this->loadNoteCount();
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





?>
