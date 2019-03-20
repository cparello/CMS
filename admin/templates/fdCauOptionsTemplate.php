<?php
$idTemplate = <<<IDTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/pins.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
<style>
.grey{
    font-size: 15pt;
    font-weight: 600;
    font-style: bold;
}
</style>
$javaScript1
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="userForm">
<form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">
<table border="0" align="center">
<tr>
<td colspan="2" class="grey">
<u><center>Account Updater</center></u>
</td>
</tr>

<tr>
<td class="black">
Set what to Update:
</td>
<td>
<select  name="select_bool" id="select_bool"/>
$selectBoolSelectList
</select>
<a href="javascript: void" id="pos199" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos199', 199);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Test Mode:
</td>
<td>
<select  name="testMode" id="testMode"/>
$testSelectList
</select>
<a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set DNS Name:
</td>
<td>
<input tabindex= "1" name="dnsName" type="text" id="dnsName" value= "$dnsName" size="25" maxlength="50" onBlur="killHeader()"/><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Port:
</td>
<td>
<input tabindex= "1" name="port" type="text" id="port" value= "$port" size="25" maxlength="20" onBlur="killHeader()"/>
<a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Updater Merchant Name:
</td>
<td>
<input tabindex= "1" name="merchantName" type="text" id="merchantName" value= "$merchantName" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Updater Merchant Number:
</td>
<td>
<input tabindex= "1" name="merchantNumber" type="text" id="merchantNumber" value= "$merchantNumber" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos12', 12);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Updater Job Name:
</td>
<td>
<input tabindex= "1" name="jobName" type="text" id="jobName" value= "$jobName" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set North/South Platform:
</td>
<td>
<select  name="northSouth" id="northSouth"/>
$northSouthSelectList
</select>
<a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Card Processor Name Info:
</td>
<td>
<input tabindex= "1" name="card_processor_name_info" type="text" id="card_processor_name_info" value= "$card_processor_name_info" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos14" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos14', 14);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set File Type:
</td>
<td>
<input tabindex= "1" name="fileType" type="text" id="fileType" value= "$fileType" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos13" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos13', 13);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>


<tr>
<td colspan="2" class="grey">
<u><center>Visa</center></u>
</td>
</tr>


<tr>
<td class="black">
Do You Use VISA:
</td>
<td>
<select  name="visaBool" id="visaBool"/>
$visaSelectList
</select>
<a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos15', 15);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Visa BIN:
</td>
<td>
<input tabindex= "1" name="visaBin" type="text" id="visaBin" value= "$visaBin" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td colspan="2" class="grey">
<u><center>MasterCard</center></u>
</td>
</tr>

<tr>
<td class="black">
Do You Use MASTERCARD:
</td>
<td>
<select  name="mcBool" id="mcBool"/>
$mcSelectList
</select>
<a href="javascript: void" id="pos16" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos16', 16);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set MasterCard ICA:
</td>
<td>
<input tabindex= "1" name="mcIca" type="text" id="mcIca" value= "$mcIca" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos8', 8);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td colspan="2" class="grey">
<u><center>Discover</center></u>
</td>
</tr>

<tr>
<td class="black">
Do You Use DISCOVER:
</td>
<td>
<select  name="discBool" id="discBool"/>
$discSelectList
</select>
<a href="javascript: void" id="pos17" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos17', 17);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>


<tr>
<td class="black">
Set Discover PID:
</td>
<td>
<input tabindex= "1" name="discoverPid" type="text" id="discoverPid" value= "$discoverPid" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos9', 9);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Discover Mailbox ID:
</td>
<td>
<select  name="discoverMailboxId" id="discoverMailboxId"/>
$mailboxSelectList
</select>
<a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos10', 10);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>

<tr>
<td class="black">
Set Discover SE Number:
</td>
<td>
<input tabindex= "1" name="discoverSeNumber" type="text" id="discoverSeNumber" value= "$discoverSeNumber" size="25" maxlength="20" onBlur="killHeader()"/><a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos11', 11);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
<td>
</tr>



<tr>
<td colspan="2">
&nbsp;
</td>
</tr>



<tr>
<td colspan="2" class="grey">
<u></u>
</td>
</tr>



<tr>
<td>
&nbsp;
</td>
<td>
<input type="submit" name="edit_id" value="Update Options" />
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>



</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
IDTEMPLATE;


echo"$idTemplate";

?>


