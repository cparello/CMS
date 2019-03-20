<?php
$serviceTemplate = <<<SERVICETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/services.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript1
$javaScript2
$javaScript3
$javaScript4
$javaScript5
$javaScript6

<title>$page_title</title>

</head>
<body>
$infoTemplate

<div id="userHeader">
$page_title
</div>

<div id="conf" class="conf">
 $confirmation&nbsp;
</div>


<div id="userForm">
<form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return send_id()">
<table border="0" align="center">
<tr>
<td class="black" colspan="5" >
<p>
Part One: Basic Service Information
</p>
</td>
</tr>


<tr>
<td class="grey" colspan="5">
<u>Service Information</u>
</td>
</tr>

<tr>
<td class="black" valign="middle">
Service Name:
</td>
<td valign="top">
<input tabindex= "1" name="service_type" type="text" id="service_type" value="$service_type" size="25" maxlength="45" onFocus="killHeader()"/><a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
<td>
&nbsp;
</td>

<td rowspan="2" class="black" valign="top">
Service Description:
</td>
<td rowspan="2" valign="top">
<textarea tabindex= "2" cols="21" rows="2" name="service_desc" id="service_desc" tabindex= "2">$service_desc</textarea><a href="javascript: void" id="pos3" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -55, 'pos3', 3 );" /><img src="../images/question-mark.png" class="alignTop"></a>
</td>
</tr>



<tr>
<td class="black">
Club Location:
</td>
<td>
<select tabindex= "3" name="service_location" id="service_location">
$drop_menu
</select>  <a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>
</td>
<td>
&nbsp;
</td>
</tr>

<tr>
<td class="black" valign="middle">
Group Type:
</td>
<td valign="bottom">
<select tabindex= "4" name="group_type" id="group_type">
$group_menu
</select>  <a href="javascript: void" id="pos10" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -10, 'pos10', 10 );" /><img src="../images/question-mark.png" class="alignTop"></a>
</td>
<td class="black">
&nbsp;
</td>
<td class="black adjustTop2">
Bundle Class:
</td>
<td class="black adjustTop">
No &nbsp;<input type="radio" name="bundle" value="N" id="bundle1" $check_default1 >
&nbsp;&nbsp;
Yes &nbsp;<input type="radio" name="bundle" value="Y" id="bundle2" $check_default2>  <a href="javascript: void" id="pos12" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -10, 'pos12', 12 );" /><img src="../images/question-mark.png" class="alignTop"></a>
</td>


</tr>




<tr>
<td>
</td>
<td id="error1" colspan="4">
&nbsp;
</td>
</tr>


<tr>
<td class="black" colspan="5" >
<p>
Part two:  Service Term{s} Information
</p>
</td>
</tr>




<tr>
<td colspan="2" class="grey">
<u>Service Terms One</u>
</td>
<td>
&nbsp;
</td>
<td colspan="2" class="grey">
<u>Service Terms Two</u>
</td>
</tr>

<tr>
<td class="black">
Service Quantity:
</td>
<td>
<input tabindex= "5" type="text" name="service_quantity1" id="service_quantity1" value="$service_quantity1" size="25" maxlength="2" value="$service_quantity1" tabindex= "3"><a href="javascript: void" id="pos4" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos4', 4);" /><img src="../images/question-mark.png" class="alignMiddle"></a>  
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Quantity:
</td>
<td>
<input tabindex= "10" type="text" name="service_quantity2"  id="service_quantity2" size="25" maxlength="2" value="$service_quantity2" tabindex= "3">    
</td>
</tr>


<tr>
<td class="black">
Service Duration:
</td>
<td>
<select tabindex= "6" name="duration1" id="duration1" onBlur="return checkServiceDuration(this.value, this.id);">
 $serviceMenu $serviceMenu1
</select><a href="javascript: void" id="pos5" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos5', 5);" /><img src="../images/question-mark.png" class="alignMiddle"></a>   
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Duration:
</td>
<td>
<select tabindex= "11" name="duration2" id="duration2" onBlur="return checkServiceDuration(this.value, this.id);">
$serviceMenu $serviceMenu2
</select>  
</td>
</tr>


<tr>
<td class="black">
Service Cost:
</td>
<td>
<input tabindex= "7" type="text" name="service_cost1" id="service_cost1" size="25" maxlength="7" value="$service_cost1" tabindex= "5"><a href="javascript: void" id="pos6" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos6', 6);" /><img src="../images/question-mark.png" class="alignMiddle"></a>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Cost:
</td>
<td>
<input tabindex= "12" type="text" name="service_cost2" id="service_cost2" size="25" maxlength="7" value="$service_cost2" tabindex= "5">    
</td>
</tr>


<tr>
<td class="black">
Commission Type:
</td>
<td>
<select tabindex= "8" name="commission_type1" id="commission_type1">
$commissionMenu $commissionMenu1
</select><a href="javascript: void" id="pos7" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos7', 7);" /><img src="../images/question-mark.png" class="alignMiddle"></a>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Commission Type:
</td>
<td>
<select tabindex= "13" name="commission_type2" id="commission_type2">
$commissionMenu $commissionMenu2
</select>
</td>
</tr>


<tr>
<td class="black">
Commission Amount:
</td>
<td>
<input tabindex= "9" type="text" name="commission_amount1" id="commission_amount1" size="25" maxlength="7" value="$commission_amount1" tabindex= "5"><a href="javascript: void" id="pos8" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos8', 8);" /><img src="../images/question-mark.png" class="alignMiddle"></a>          
</td>
<td>
&nbsp;
</td>
<td class="black">
Commission Amount:
</td>
<td>
<input tabindex= "14" type="text" name="commission_amount2" id="commission_amount2" size="25" maxlength="7" value="$commission_amount2" tabindex= "5">    
</td>
</tr>


<tr>
<td class="black">
Access Limit (Optional):
</td>
<td class="black">
S<input type="checkbox" name="access_day1" value="1" $checked_one_1 />M<input type="checkbox" name="access_day1" value="2" $checked_one_2 />T<input type="checkbox" name="access_day1" value="3" $checked_one_3 / >W<input type="checkbox" name="access_day1" value="4" $checked_one_4 />T<input type="checkbox" name="access_day1" value="5" $checked_one_5 />F<input type="checkbox" name="access_day1" value="6" $checked_one_6 />S<input type="checkbox" name="access_day1" value="7" $checked_one_7 /><a href="javascript: void" id="pos11" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  0, -120, 'pos11', 11);" /><img src="../images/question-mark.png" class="alignMiddle"></a>          
</td>
<td>
&nbsp;
</td>
<td class="black">
Access Limit (Optional):
</td>
<td class="black">
S<input type="checkbox" name="access_day2" value="1" $checked_two_1 />M<input type="checkbox" name="access_day2" value="2" $checked_two_2 />T<input type="checkbox" name="access_day2" value="3" $checked_two_3 />W<input type="checkbox" name="access_day2" value="4" $checked_two_4 />T<input type="checkbox" name="access_day2" value="5" $checked_two_5 />F<input type="checkbox" name="access_day2" value="6" $checked_two_6 />S<input type="checkbox" name="access_day2" value="7" $checked_two_7 />    
</td>
</tr>



<tr>
<td>
&nbsp;
</td>
<td id="error2">
</td>
<td>
&nbsp;
</td>
<td>
&nbsp;
</td>
<td id="error3">
</td>
</tr>


<tr>
<td colspan="2" class="grey termSpace">
<u>Service Terms Three</u>
</td>
<td>
&nbsp;
</td>
<td colspan="2" class="grey termSpace">
<u>Service Terms Four</u>
</td>
</tr>



<tr>
<td class="black">
Service Quantity:
</td>
<td>
<input tabindex= "15" type="text" name="service_quantity3"  id="service_quantity3" size="25" maxlength="2" value="$service_quantity3" tabindex= "3">    
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Quantity:
</td>
<td>
<input tabindex= "20" type="text" name="service_quantity4"  id="service_quantity4" size="25" maxlength="2" value="$service_quantity4" tabindex= "3">    
</td>
</tr>


<tr>
<td class="black">
Service Duration:
</td>
<td>
<select tabindex= "16" name="duration3" id="duration3" onBlur="return checkServiceDuration(this.value, this.id);">
$serviceMenu $serviceMenu3
</select>  
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Duration:
</td>
<td>
<select tabindex= "21" name="duration4" id="duration4" onBlur="return checkServiceDuration(this.value, this.id);">
$serviceMenu $serviceMenu4
</select>  
</td>
</tr>


<tr>
<td class="black">
Service Cost:
</td>
<td>
<input tabindex= "17" type="text" name="service_cost3" id="service_cost3" size="25" maxlength="7" value="$service_cost3" tabindex= "5">    
</td>
<td>
&nbsp;
</td>
<td class="black">
Service Cost:
</td>
<td>
<input tabindex= "22" type="text" name="service_cost4" id="service_cost4" size="25" maxlength="7" value="$service_cost4" tabindex= "5">    
</td>
</tr>


<tr>
<td class="black">
Commission Type:
</td>
<td>
<select tabindex= "18" name="commission_type3" id="commission_type3">
$commissionMenu $commissionMenu3
</select>
</td>
<td>
&nbsp;
</td>
<td class="black">
Commission Type:
</td>
<td>
<select tabindex= "23" name="commission_type4" id="commission_type4">
$commissionMenu $commissionMenu4
</select>
</td>
</tr>


<tr>
<td class="black">
Commission Amount:
</td>
<td>
<input tabindex= "19" type="text" name="commission_amount3" id="commission_amount3" size="25" maxlength="7" value="$commission_amount3" tabindex= "5">    
</td>
<td>
&nbsp;
</td>
<td class="black">
Commission Amount:
</td>
<td>
<input tabindex= "24" type="text" name="commission_amount4" id="commission_amount4" size="25" maxlength="7" value="$commission_amount4" tabindex= "5">    
</td>
</tr>

<tr>
<td class="black">
Access Limit (Optional):
</td>
<td class="black">
S<input type="checkbox" name="access_day3" value="1" $checked_three_1 />M<input type="checkbox" name="access_day3" value="2" $checked_three_2 />T<input type="checkbox" name="access_day3" value="3" $checked_three_3 />W<input type="checkbox" name="access_day3" value="4" $checked_three_4 />T<input type="checkbox" name="access_day3" value="5" $checked_three_5 />F<input type="checkbox" name="access_day3" value="6" $checked_three_6 />S<input type="checkbox" name="access_day3" value="7" $checked_three_7 />
</td>
<td>
&nbsp;
</td>
<td class="black">
Access Limit (Optional):
</td>
<td class="black">
S<input type="checkbox" name="access_day4" value="1" $checked_four_1 />M<input type="checkbox" name="access_day4" value="2" $checked_four_2 />T<input type="checkbox" name="access_day4" value="3" $checked_four_3 />W<input type="checkbox" name="access_day4" value="4" $checked_four_4 />T<input type="checkbox" name="access_day4" value="5" $checked_four_5 />F<input type="checkbox" name="access_day4" value="6" $checked_four_6 />S<input type="checkbox" name="access_day4" value="7" $checked_four_7 />    
</td>
</tr>


<tr>
<td>
&nbsp;
</td>
<td id="error4">
</td>
<td>
&nbsp;
</td>
<td>
&nbsp;
</td>
<td id="error5">
</td>
</tr>


<tr>
<td class="black termSpace" colspan="5" >
<input type="submit" name="$submit_name" value="$page_title" />
&nbsp;&nbsp;<input type="reset" value="Reset">
<input name="marker" type="hidden" id="marker" value="1" /> 
$cost_key_hidden
$service_key_hidden

<input name="access1" type="hidden" id="access1" value="$access1" />
<input name="access2" type="hidden" id="access2" value="$access2" />
<input name="access3" type="hidden" id="access3" value="$access3" />
<input name="access4" type="hidden" id="access4" value="$access4" />

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

SERVICETEMPLATE;


echo"$serviceTemplate";
?>