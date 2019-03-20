<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
include"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT DISTINCT state FROM club_info");
$stmt->execute();      
$stmt->store_result(); 
$stmt-> bind_result($state);
while($stmt->fetch()){
    $state = trim($state);
    $stateDrop .="<option value=\"$state\">$state</option>";
     }
$stmt->close();



include "overtimeOptions.php";
$overtime = new overtimeOptions();
$overtime-> setState($state);   
$overtime-> loadOtOptions();
$rule_one = $overtime-> getDailyRuleOne();
$rule_two = $overtime-> getDailyRuleTwo();
$rule_three = $overtime-> getWeeklyRule();

 $html = "<tr>
<td class=\"grey\">
<u>Overtime State </u>
</td>
</tr>

<tr>
<td>
<select id=\"state\" name=\"state\">
$stateDrop
</select> 


</td>
</tr>

<tr>
<td class=\"grey\">
<u>Overtime Rule One (Daily)</u>
</td>
</tr>

<tr>
<td>
<input name=\"rule_one\" type=\"text\" id=\"rule_one\" size=\"15\" maxlength=\"2\" value=\"$rule_one\"/><a href=\"javascript: void\" id=\"pos1\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"></a>
</td>
</tr>

<tr>
<td class=\"grey spacePad\">
<u>Overtime Rule Two (Daily)</u>
</td>
</tr>

<tr>
<td>
<input name=\"rule_two\" type=\"text\" id=\"rule_two\" size=\"15\" maxlength=\"2\" value=\"$rule_two\"/><a href=\"javascript: void\" id=\"pos2\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"></a>
</td>
</tr>

<tr>
<td class=\"grey spacePad\">
<u>Overtime Rule Three (Weekly)</u>
</td>
</tr>

<tr>
<td>
<input name=\"rule_three\" type=\"text\" id=\"rule_three\" size=\"15\" maxlength=\"2\" value=\"$rule_three\"/><a href=\"javascript: void\" id=\"pos3\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);\" /><img src=\"../images/question-mark.png\" class=\"alignMiddle\"></a>
</td>
</tr>";    

//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(59);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";


$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtOtOptions.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/saveOtOptions.js\"></script>";

//print out the search form
include "../templates/otOptionsTemplate.php";

?>