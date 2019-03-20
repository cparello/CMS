<?php
$feeTemplate = <<<FEETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/fees.css">
<link rel="stylesheet" href="../css/pop_hint.css">
<link rel="stylesheet" href="../css/info.css">
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
  <form id="form1" name="form1" method="post" action="$submit_link">

<table border="0" align="center" cellspacing="0" cellpadding="0">
<tr>
<td align="left" colspan="2" class="grey">
<u>Single Processing Fees</u><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="40">
</td>
<td align="left" colspan="2" class="grey">
<u>Family Processing Fees</u><a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "1" name="process_fee_single" type="text" id="process_fee_single" value= "$process_fee_single" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "2" name="process_fee_family" type="text" id="process_fee_family" value= "$process_fee_family" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>


<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "1" name="process_fee_single2" type="text" id="process_fee_single2" value= "$process_fee_single2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "2" name="process_fee_family2" type="text" id="process_fee_family2" value= "$process_fee_family2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>



<tr>
<td align="left" colspan="2" class="grey">
<u>Single Upgrade Fees</u><a href="javascript: void" id="pos9" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos9', 9);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="40">
</td>
<td align="left" colspan="2" class="grey">
<u>Family Upgrade Fees</u><a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos10', 10);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "1" name="upgrade_fee_single" type="text" id="upgrade_fee_single" value= "$upgrade_fee_single" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "2" name="upgrade_fee_family" type="text" id="upgrade_fee_family" value= "$upgrade_fee_family" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>

<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "1" name="upgrade_fee_single2" type="text" id="upgrade_fee_single2" value= "$upgrade_fee_single2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "2" name="upgrade_fee_family2" type="text" id="upgrade_fee_family2" value= "$upgrade_fee_family2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>

<tr>
<td class="black">
Add Member:
</td>
<td>
<input tabindex= "1" name="upgrade_fee_single3" type="text" id="upgrade_fee_single3" value= "NA" size="10" maxlength="8" disabled="disabled"/>
</td>
<td width="20">
</td>
<td class="black">
Add Member:
</td>
<td>
<input tabindex= "2" name="upgrade_fee_family3" type="text" id="upgrade_fee_family3" value= "$upgrade_fee_family3" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Single Renewal Fees</u><a href="javascript: void" id="pos15" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos15', 15);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="40">
</td>
<td align="left" colspan="2" class="grey">
<u>Family Renewal Fees</u><a href="javascript: void" id="pos16" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos16', 16);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "1" name="renewal_fee_single" type="text" id="renewal_fee_single" value= "$renewal_fee_single" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "2" name="renewal_fee_family" type="text" id="renewal_fee_family" value= "$renewal_fee_family" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>
<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "1" name="renewal_fee_single2" type="text" id="renewal_fee_single2" value= "$renewal_fee_single2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "2" name="renewal_fee_family2" type="text" id="renewal_fee_family2" value= "$renewal_fee_family2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>



<tr>
<td align="left" colspan="2" class="grey">
<u>Business Processing Fees</u><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos3', 3);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td align="left" colspan="2" class="grey">
<u>Organization Processing Fees</u><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "3" name="process_fee_business" type="text" id="process_fee_business" value= "$process_fee_business" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "4" name="process_fee_organization" type="text" id="process_fee_organization" value= "$process_fee_organization" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>


<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "3" name="process_fee_business2" type="text" id="process_fee_business2" value= "$process_fee_business2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "4" name="process_fee_organization2" type="text" id="process_fee_organization2" value= "$process_fee_organization2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Business Upgrade Fees</u><a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos11', 11);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td align="left" colspan="2" class="grey">
<u>Organization Upgrade Fees</u><a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos12', 12);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "3" name="upgrade_fee_business" type="text" id="upgrade_fee_business" value= "$upgrade_fee_business" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "4" name="upgrade_fee_organization" type="text" id="upgrade_fee_organization" value= "$upgrade_fee_organization" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>

<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "3" name="upgrade_fee_business2" type="text" id="upgrade_fee_business2" value= "$upgrade_fee_business2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "4" name="upgrade_fee_organization2" type="text" id="upgrade_fee_organization2" value= "$upgrade_fee_organization2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>

<tr>
<td class="black">
Add Member:
</td>
<td>
<input tabindex= "3" name="upgrade_fee_business3" type="text" id="upgrade_fee_business3" value= "$upgrade_fee_business3" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Add Member:
</td>
<td>
<input tabindex= "4" name="upgrade_fee_organization3" type="text" id="upgrade_fee_organization3" value= "$upgrade_fee_organization3" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Business Renewal Fees</u><a href="javascript: void" id="pos17" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos17', 17);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td align="left" colspan="2" class="grey">
<u>Organization Renewal Fees</u><a href="javascript: void" id="pos18" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos18', 18);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "3" name="renewal_fee_business" type="text" id="renewal_fee_business" value= "$renewal_fee_business" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Month to Month:
</td>
<td>
<input tabindex= "4" name="renewal_fee_organization" type="text" id="renewal_fee_organization" value= "$renewal_fee_organization" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>

<tr>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "3" name="renewal_fee_business2" type="text" id="renewal_fee_business2" value= "$renewal_fee_business2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
<td width="20">
</td>
<td class="black">
Paid in Full:
</td>
<td>
<input tabindex= "4" name="renewal_fee_organization2" type="text" id="renewal_fee_organization2" value= "$renewal_fee_organization2" size="10" maxlength="8" onFocus="killHeader()"/>
</td>
</tr>










<tr>
<td align="left" colspan="2" class="grey">
<u>Grace Periods / Percentage Rates</u>
</td>
<td width="20">
</td>
<td align="left" colspan="2" class="grey">
&nbsp;
</td>
</tr>

<tr>
<td class="black">
Renewal Percent Rate:
</td>
<td>
<input tabindex= "5" name="renewal_percent" type="text" id="renewal_percent" value="$renewal_percent" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos8', 8 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Early Renewal Percent Rate:
</td>
<td>
<input tabindex= "6" name="early_renewal_percent" type="text" id="early_renewal_percent" value="$early_renewal_percent" size="10" maxlength="3" onFocus="killHeader()"/><a href="javascript: void" id="pos13" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos13', 13 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>



<tr>
<td class="black">
Early Renewal Grace Period:
</td>
<td>
<input tabindex= "7" name="early_renewal_grace" type="text" id="early_renewal_grace" value="$eary_renewal_grace" size="10" maxlength="3" onFocus="killHeader()"/><a href="javascript: void" id="pos14" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -70, 'pos14', 14 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Standard Renewal Grace Period:
</td>
<td>
<input tabindex= "1" name="standard_renewal_grace" type="text" id="standard_renewal_grace" value= "$standard_renewal_grace" size="10" maxlength="3" onFocus="killHeader()"/><a href="javascript: void" id="pos19" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos19', 19);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black">
Past Due Grace Period:
</td>
<td>
<input tabindex= "1" name="past_due_grace" type="text" id="past_due_grace" value= "$past_due_grace" size="10" maxlength="2" onFocus="killHeader()"/><a href="javascript: void" id="pos21" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos21', 21);" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Account Hold Grace Period:
</td>
<td>
<input tabindex= "10" name="hold_grace" type="text" id="hold_grace" value="$hold_grace" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos24" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos24', 24 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Class Percent Rate:
</td>
<td>
<input tabindex= "10" name="class_percent" type="text" id="class_percent" value="$class_percent" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos29" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos29', 29 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
&nbsp;
</td>
<td>
&nbsp;   
</td>
</tr>


<tr>
<td align="left" colspan="2" class="grey">
<u>Miscellaneous Fees</u>
</td>
<td width="20">
</td>
<td align="left" colspan="2" class="grey">
&nbsp;
</td>
</tr>

<tr>
<td class="black">
Enhancement Fee:
</td>
<td>
<input tabindex= "8" name="enhance_fee" type="text" id="enhance_fee" value="$enhance_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Cancelation Fee:
</td>
<td>
<input tabindex= "9" name="cancel_fee" type="text" id="cancel_fee" value="$cancel_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>        
</td>
</tr>

<tr>
<td class="black">
CC Rejection Fee:
</td>
<td>
<input tabindex= "10" name="rejection_fee" type="text" id="rejection_fee" value="$rejection_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</td>
<td width="20">
</td>
<td class="black">
Late Fee:
</td>
<td>
<input tabindex= "10" name="late_fee" type="text" id="late_fee" value="$late_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos20" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos20', 20 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>


<tr>
<td class="black">
Lost Card Fee:
</td>
<td>
<input tabindex= "10" name="card_fee" type="text" id="card_fee" value="$card_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos22" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos22', 22 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Rate Guarantee Fee:
</td>
<td>
<input tabindex= "10" name="rate_fee" type="text" id="rate_fee" value="$rate_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos23" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos23', 23 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Account Hold Fee:
</td>
<td>
<input tabindex= "10" name="hold_fee" type="text" id="hold_fee" value="$hold_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos25" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos25', 25 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
Member Hold Fee:
</td>
<td>
<input tabindex= "10" name="member_hold_fee" type="text" id="member_hold_fee" value="$member_hold_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos26" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos26', 26 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Transfer Fee:
</td>
<td>
<input tabindex= "10" name="transfer_fee" type="text" id="transfer_fee" value="$transfer_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos27" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos27', 27 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>
<td class="black">
NSF Fee:
</td>
<td>
<input tabindex= "10" name="nsf_fee" type="text" id="nsf_fee" value="$nsf_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos28" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos28', 28 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
</tr>

<tr>
<td class="black">
Maintnence Fee:
</td>
<td>
<input tabindex= "10" name="maintnence_fee" type="text" id="maintnence_fee" value="$maintnence_fee" size="10" maxlength="8" onFocus="killHeader()"/><a href="javascript: void" id="pos30" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos30', 30 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>    
</td>
<td width="20">
</td>

</tr>






<tr>
<td  colspan="5" align="left">
<br>
<input type="submit" name="$submit_name" value="$submit_title" />
<input type="hidden" name="marker" value="1" />
$hidden
</form>
</td>
</tr>

<tr>
<td id="idContent1" colspan="5">   
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
FEETEMPLATE;


echo"$feeTemplate";

?>


