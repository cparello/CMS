<?php
session_start();
$employee_template = <<<EMPLOYEETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/info.css">
<link rel="stylesheet" href="../css/employee_form.css">
<link rel="stylesheet" href="../css/pop_hint.css">
$javaScript
$javaScript2
$javaScript3
$javaScript4
$javaScript5
$javaScript6
<title>$page_title</title>

</head>
<body$onLoad>

$infoTemplate

<div id="businessHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="employeeForm">
<form name="form1" id="form1"  method="post" action="$submit_link"  onSubmit="return checkData()" onReset="checkField();">
<table border="0" align="center">

<tr>
<td colspan="5" class="black">
<p>
Part One: Employee Information
</p>
</td>
</tr>

<tr>
<td colspan="2" class="grey"><u>Employee Contact Information</u>
</td>
<td>
&nbsp
</td>
<td colspan="2" class="grey">
<u>Emergency Contact Information</u>
</td>
</tr>


<tr>
<td class="black">
First Name:
</td>
<td>
<input  name="first_name" type="text" id="first_name" value="$first_name" size="25" maxlength="60" tabindex="1"/>     
</td>
<td>
&nbsp;
</td>
<td class="black">
Contact Name:
</td>
<td>
<input name="emergency_contact" type="text" id="emergency_contact" value="$emergency_contact"size="25" maxlength="60"  tabindex="10"/>
</td>
</tr>

<tr>
<td class="black">
Middle Name:
</td>
<td>
<input name="middle_name" type="text" id="middle_name" value="$middle_name" size="25" maxlength="100"  tabindex="2"/></td>
<td>
&nbsp;
</td>
<td class="black">
Contact Phone:
</td>
<td>
<input name="emergency_phone" type="text" id="emergency_phone" value="$emergency_phone" size="25" maxlength="15"  tabindex="11"/>
</td>
</tr>

<tr>
<td class="black">
Last Name:
</td>
<td>
<input  name="last_name" type="text" id="last_name" value="$last_name" size="25" maxlength="30"  tabindex="3"/>
</td>
<td>
&nbsp;
</td>
<td colspan="2" id="error2">
&nbsp;
</td>
</tr>

<tr>
<td class="black">
Street Address:
</td>
<td>
<input name="street_address" type="text" id="street_address" value="$street_address" size="25" maxlength="100"  tabindex="4"/>
</td>

<td>&nbsp;
</td>
<td class="grey" colspan="2">
<u>Username/Password Creation </u>
</td>
</tr>

<tr>
<td class="black">
City:
</td>
<td>
<input name="city" type="text" id="city" value="$city" size="25" maxlength="30"  tabindex="5"/>
</td>

<td>
&nbsp;
</td>
<td class="black">
Username:
</td>
<td>
<input  name="user_name1" type="text" id="user_name1" value="$user_name1" size="25" maxlength="50" onBlur="return checkUserName(this.value$userIdVar)"  tabindex="12"/>  <a href="javascript: void" id="pos1" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos1', 1 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>



</td>
</tr>

<tr>
<td class="black">
State:
</td>
<td>
<select  name="state" id="state"  tabindex="6">
      $state_option
      <option value="AL">Alabama</option>
      <option value="AK">Alaska</option>
      <option value="AZ">Arizona</option>
      <option value="AR">Arkansas</option>
      <option value="CA">California</option>
      <option value="CO">Colorado</option>
      <option value="CT">Connecticut</option>
      <option value="DE">Delaware</option>
      <option value="DC">Wash. D.C.</option>
      <option value="FL">Florida</option>
      <option value="GA">Georgia</option>
      <option value="HI">Hawaii</option>
      <option value="ID">Idaho</option>
      <option value="IL">Illinois</option>
      <option value="IN">Indiana</option>
      <option value="IA">Iowa</option>
      <option value="KS">Kansas</option>
      <option value="KY">Kentucky</option>
      <option value="LA">Louisiana</option>
      <option value="ME">Maine</option>
      <option value="MD">Maryland</option>
      <option value="MA">Massachusetts</option>
      <option value="MI">Michigan</option>
      <option value="MN">Minnesota</option>
      <option value="MS">Mississippi</option>
      <option value="MO">Missouri</option>
      <option value="MT">Montana</option>
      <option value="NE">Nebraska</option>
      <option value="NV">Nevada</option>
      <option value="NH">New Hampshire</option>
      <option value="NJ">New Jersey</option>
      <option value="NM">New Mexico</option>
      <option value="NY">New York</option>
      <option value="NC">North Carolina</option>
      <option value="ND">North Dakota</option>
      <option value="OH">Ohio</option>
      <option value="OK">Oklahoma</option>
      <option value="OR">Oregon</option>
      <option value="PA">Pennsylvania</option>
      <option value="RI">Rhode Island</option>
      <option value="SC">So. Carolina</option>
      <option value="SD">So. Dakota</option>
      <option value="TN">Tennessee</option>
      <option value="TX">Texas</option>
      <option value="UT">Utah</option>
      <option value="VT">Vermont</option>
      <option value="VA">Virginia</option>
      <option value="WA">Washington</option>
      <option value="WV">West Virginia</option>
      <option value="WI">Wisconsin</option>
      <option value="WY">Wyoming</option>
</select>
</td>
<td>
&nbsp;
</td>

<td class="black">
Password:
</td>
<td>
<input name="pass_word1" type="text" id="pass_word1" value="$pass_word1" size="25" maxlength="10"  tabindex="13"/>
<a href="javascript: void" id="pos2" onclick="popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, 0, 'pos2', 2 );" /><img src="../images/question-mark.png" class="alignMiddle"></a>

</td>
</tr>

<tr>
<td class="black">
Zipcode:
</td>
<td>
<input name="zip_code" type="text" id="zip_code" value="$zip_code" size="25" maxlength="10"  tabindex="7"/>
</td>
<td>
&nbsp;
</td>
<td class="black">
Verify Password:
</td>
<td>
<input  name="pass_word2" type="text" id="pass_word2" value="$pass_word2" size="25" maxlength="10"  tabindex="14"/>
</td>
<td>
</tr>

<tr>
<td class="black">
Primary Phone:
</td>
<td>
<input name="home_phone" type="text" id="home_phone" value="$home_phone" size="25" maxlength="15"  tabindex="8"/>
</td>
<td>
&nbsp;
</td>
<td colspan="2" id="error3">
</td>
</tr>
    
<tr>
<td class="black">
Cell Phone:
</td>
<td>
<input  name="cell_phone" type="text" id="cell_phone" value="$cell_phone" size="25" maxlength="15"  tabindex="9"/>
</td>
<td>
&nbsp;
</td>
<td class="black">
Social Security #:
</td>
<td>
<input name="ss_number" type="text" id="ss_number" value="$ss_number" size="25" maxlength="10" />
</td>
</tr>

<tr>
<td class="black">
Email Address:
</td>
<td>
<input  name="email" type="text" id="email" value="$email" size="25" maxlength="15"  tabindex="9"/>
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td id="error1" colspan="3">
</td>
<td>
</td>
</tr>

<tr>
<td class="black">
<p>
<b>Part Two: SalesPerson Shift Hours</b>
</p>
</td>
</tr>

<tr>
<td class="black">
Total Sales Hours</td>
<td class="black">
<b>$totHours</b>
</td>

</tr>

<tr>
<td class="black">
</td>
<td class="black">
<b>Start 1</b>
</td>
<td class="black">
<b>End 1</b>
</td>
<td class="black">
<b>Start 2</b>
</td>
<td class="black">
<b>End 2</b>
</td>
</tr>

<tr>
<td class="black">
<p>
<b>Monday:</b>
</p>
</td>
<td class="black">
<select name="monday_start_1" id="monday_start_1" />
      <option value="$monday_start_1" selected>$monday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="monday_end_1" id="monday_end_1" />
      <option value="$monday_end_1" selected>$monday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="monday_start_2" id="monday_start_2" />
      <option value="$monday_start_2" selected>$monday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="monday_end_2" id="monday_end_2"/>
      <option value="$monday_end_2" selected>$monday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Tuesday:</b>
</p>
</td>
<td class="black">
<select name="tuesday_start_1" id="tuesday_start_1" />
      <option value="$tuesday_start_1" selected>$tuesday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="tuesday_end_1" id="tuesday_end_1" />
      <option value="$tuesday_end_1" selected>$tuesday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="tuesday_start_2" id="tuesday_start_2" />
      <option value="$tuesday_start_2" selected>$tuesday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="tuesday_end_2" id="tuesday_end_2"/>
      <option value="$tuesday_end_2" selected>$tuesday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Wednesday:</b>
</p>
</td>
<td class="black">
<select name="wednesday_start_1" id="wednesday_start_1" />
      <option value="$wednesday_start_1" selected>$wednesday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="wednesday_end_1" id="wednesday_end_1" />
      <option value="$wednesday_end_1" selected>$wednesday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="wednesday_start_2" id="wednesday_start_2" />
      <option value="$wednesday_start_2" selected>$wednesday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="wednesday_end_2" id="wednesday_end_2"/>
      <option value="$wednesday_end_2" selected>$wednesday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Thursday:</b>
</p>
</td>
<td class="black">
<select name="thursday_start_1" id="thursday_start_1" />
      <option value="$thursday_start_1" selected>$thursday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="thursday_end_1" id="monthursday_end_1" />
      <option value="$thursday_end_1" selected>$thursday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="thursday_start_2" id="thursday_start_2" />
      <option value="$thursday_start_2" selected>$thursday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="thursday_end_2" id="thursday_end_2"/>
      <option value="$thursday_end_2" selected>$thursday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Friday:</b>
</p>
</td>
<td class="black">
<select name="friday_start_1" id="friday_start_1" />
      <option value="$friday_start_1" selected>$friday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="friday_end_1" id="friday_end_1" />
      <option value="$friday_end_1" selected>$friday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="friday_start_2" id="friday_start_2" />
      <option value="$friday_start_2" selected>$friday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="friday_end_2" id="friday_end_2"/>
      <option value="$friday_end_2" selected>$friday_end_2_txt</option>
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Saturday:</b>
</p>
</td>
<td class="black">
<select name="saturday_start_1" id="saturday_start_1" />
      <option value="$saturday_start_1" selected>$saturday_start_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="saturday_end_1" id="saturday_end_1" />
      <option value="$saturday_end_1" selected>$saturday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="saturday_start_2" id="saturday_start_2" />
      <option value="$saturday_start_2" selected>$saturday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="saturday_end_2" id="saturday_end_2"/>
      <option value="$saturday_end_2" selected>$saturday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>
<tr>
<td class="black">
<p>
<b>Sunday:</b>
</p>
</td>
<td class="black">
<select name="sunday_start_1" id="sunday_start_1" />
      <option value="$sunday_start_1" selected>$sunday_start_1_txt</option>
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="sunday_end_1" id="sunday_end_1" />
      <option value="$sunday_end_1" selected>$sunday_end_1_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="sunday_start_2" id="sunday_start_2" />
      <option value="$sunday_start_2" selected>$sunday_start_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
<td class="black">
<select name="sunday_end_2" id="sunday_end_2"/>
      <option value="$sunday_end_2" selected>$sunday_end_2_txt</option> 
      <option value="0">No Shift</option>
      <option value="1">1 AM</option>
      <option value="2">2 AM</option>
      <option value="3">3 AM</option>
      <option value="4">4 AM</option>
      <option value="5">5 AM</option>
      <option value="6">6 AM</option>
      <option value="7">7 AM</option>
      <option value="8">8 AM</option>
      <option value="9">9 AM</option>
      <option value="10">10 AM</option>
      <option value="11">11 AM</option>
      <option value="12">12 PM</option>
      <option value="13">1 PM</option>
      <option value="14">2 PM</option>
      <option value="15">3 PM</option>
      <option value="16">4 PM</option>
      <option value="17">5 PM</option>
      <option value="18">6 PM</option>
      <option value="19">7 PM</option>
      <option value="20">8 PM</option>
      <option value="21">9 PM</option>
      <option value="22">10 PM</option>
      <option value="23">11 PM</option>
      <option value="24">12 AM</option>
</select>      
</td>
</tr>


<tr class="bgTwo">
<td colspan="5" class="black">
<p>
Part Three: Job Description(s)
</p>
</td>
</tr>


<tr class="bgTwo">
<td colspan="2" class="grey">
<u>Employee Type Information One</u>
</td>
<td>
&nbsp;
</td>
<td colspan="2" class="grey">
<u>Employee Type Information Three</u>
</td>
</tr>

<tr class="bgTwo">
<td class="black">
ID Card Number:
</td>
<td>
<input  name="id_card1" type="text" id="id_card1" value="$id_card1" size="25" maxlength="25" $idCardCall />
</td>
<td>
&nbsp;
</td>
<td class="black">
ID Card Number:
</td>
<td>
<input name="id_card3" type="text" id="id_card3" value="$id_card3" size="25" maxlength="25" $idCardCall />
</td>
</tr>



<tr class="bgTwo">
<td class="black">
Job Description:
</td>
<td colspan="2">
<select name="employee_type1" id="employee_type1" onChange="showServices(1, this.value, this, 'value');" tabindex="15"/>
$drop_menu_emp1
</select>
</td>


<td class="black">
Job Description:
</td>
<td>
<select name="employee_type3" id="employee_type3" onChange="showServices(3, this.value, this, 'value');"tabindex="23"/>
$drop_menu_emp3
</select>
</td>
</tr>

<tr class="bgTwo">
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle1" id="payment_cycle1"  tabindex="16">
      $cycle_option1
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle3" id="payment_cycle3" tabindex="24"/>
      $cycle_option3
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
</tr>

<tr class="bgTwo">
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type1" id="compensation_type1" onChange="compChange(1)"  tabindex="17"/>
      $compensation_option1
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Commission</option>
      <option value="SC">Salary/Commission</option>
      <option value="HC">Hourly/Commission</option>
</select>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type3" id="compensation_type3" onChange="compChange(3)" tabindex="25"/>
      $compensation_option3
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
      <option value="SC">Salary/Commission</option>
      <option value="HC">Hourly/Commission</option>
</select>      
</td>
</tr>

<tr class="bgTwo">
<td class="black" id="pay1a">
Payment Amount:
</td>
<td  id="pay1b">
<input  name="payment_amount1" type="text" id="payment_amount1" value="$payment_amount1" size="25" maxlength="100"  tabindex="18"/>
</td>
<td>
&nbsp;
</td>
<td class="black" id="pay3a">
Payment Amount:
</td>
<td id="pay3b">
<input name="payment_amount3" type="text" id="payment_amount3" value="$payment_amount3" size="25" maxlength="10" tabindex="26"/>
</td>
</tr>

<tr class="bgTwo">
<td class="black" id="pay1d">
Hours Projected:
</td>
<td  id="pay1e">
<input  name="hours_projected1" type="text" id="hours_projected1" value="$hours_projected1" size="25" maxlength="3" />
</td>
<td>
&nbsp;
</td>
<td class="black" id="pay3d">
Hours Projected:
</td>
<td id="pay3e">
<input name="hours_projected3" type="text" id="hours_projected3" value="$hours_projected3" size="25" maxlength="3" />
</td>
</tr>

<tr class="bgTwo">
<td id="cat1a" class="black" valign="top">
$category_header1
</td>
<td id="cat1b" valign="top">
$category_list1
</td>
<td>
&nbsp;
</td>
<td id="cat3a" class="black" valign="top">
$category_header3
</td>
<td id="cat3b">
$category_list3
</td>  
</tr>


<tr class="bgTwo">
<td id="serve1a" class="black" valign="top">
$service_header1
</td>
<td id="serve1b" valign="top">
$service_list1
</td>
<td>
&nbsp;
</td>
<td id="serve3a" class="black" valign="top">
$service_header3
</td>
<td id="serve3b">
$service_list3
</td>  
</tr>


<tr class="bgTwo">
<td class="black">
$emp_delete_desc1
</td>
<td id="check1">
$emp_delete_check1
</td>
<td>
&nbsp;
</td>
<td class="black">
$emp_delete_desc3
</td>
<td id="check3">
$emp_delete_check3
</td>  
</tr>


<tr class="bgTwo">
<td>
</td>
<td id="error4">
</td>
<td>
&nbsp;
</td>
<td>
</td>
<td id="error6">
</td>  
</tr>


<tr class="bgTwo">
<td colspan="2" class="grey">
<u>Employee Type Information Two</u>
</td>
<td>
&nbsp;
</td>
<td colspan="2" class="grey">
<u>Employee Type Information Four</u>
</td>
</tr>

<tr class="bgTwo">
<td class="black">
ID Card Number:
</td>
<td>
<input  name="id_card2" type="text" id="id_card2" value="$id_card2" size="25" maxlength="25" $idCardCall />
</td>
<td>
&nbsp;
</td>
<td class="black">
ID Card Number:
</td>
<td>
<input name="id_card4" type="text" id="id_card4" value="$id_card4" size="25" maxlength="25" $idCardCall />
</td>
</tr>

<tr class="bgTwo">
<td class="black">
Job Description:
</td>
<td colspan="2">
<select name="employee_type2" id="employee_type2" onChange="showServices(2, this.value, this, 'value');" tabindex="19"/>
$drop_menu_emp2
</select>
</td>
<td class="black">
Job Description:
</td>
<td>
<select  name="employee_type4" id="employee_type4" onChange="showServices(4, this.value, this, 'value');" tabindex="27"/>
$drop_menu_emp4
</select>
</td>
</tr>


<tr class="bgTwo">
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle2" id="payment_cycle2"  tabindex="20"/>
      $cycle_option2
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle4" id="payment_cycle4" tabindex="28"/>
      $cycle_option4
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
</tr>


<tr class="bgTwo">
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type2" id="compensation_type2" onChange="compChange(2)" tabindex="21"/>
      $compensation_option2
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
      <option value="SC">Salary/Commission</option>
      <option value="HC">Hourly/Commission</option>
</select>      
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type4" id="compensation_type4" onChange="compChange(4)" tabindex="29"/>
      $compensation_option4
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
      <option value="SC">Salary/Commission</option>
      <option value="HC">Hourly/Commission</option>
</select>      
</td>
</tr>

<tr class="bgTwo">
<td class="black" id="pay2a">
Payment Amount:
</td>
<td  id="pay2b">
<input  name="payment_amount2" type="text" id="payment_amount2" value="$payment_amount2" size="25" maxlength="100" tabindex="22"/>
</td>
<td>
&nbsp;
</td>
<td class="black" id="pay4a">
Payment Amount:
</td>
<td id="pay4b">
<input  name="payment_amount4" type="text" id="payment_amount4" value="$payment_amount4" size="25" maxlength="10" tabindex="30"/>
</td>
</tr>


<tr class="bgTwo">
<td class="black" id="pay2d">
Hours Projected:
</td>
<td  id="pay2e">
<input  name="hours_projected2" type="text" id="hours_projected2" value="$hours_projected2" size="25" maxlength="3" />
</td>
<td>
&nbsp;
</td>
<td class="black" id="pay4d">
Hours Projected:
</td>
<td id="pay4e">
<input name="hours_projected4" type="text" id="hours_projected4" value="$hours_projected4" size="25" maxlength="3" />
</td>
</tr>


<tr class="bgTwo">
<td id="cat2a" class="black" valign="top">
$category_header2
</td>
<td id="cat2b" valign="top">
$category_list2
</td>
<td>
&nbsp;
</td>
<td id="cat4a" class="black" valign="top">
$category_header4
</td>
<td id="cat4b">
$category_list4
</td>  
</tr>


<tr class="bgTwo">
<td id="serve2a" class="black" valign="top">
$service_header2
</td>
<td id="serve2b">
$service_list2
</td>
<td>
&nbsp;
</td>
<td id="serve4a" class="black" valign="top">
$service_header4
</td>
<td id="serve4b">
$service_list4
</td>  
</tr>


<tr class="bgTwo">
<td class="black">
$emp_delete_desc2
</td>
<td id="check2">
$emp_delete_check2
</td>
<td>
&nbsp;
</td>
<td class="black">
$emp_delete_desc4
</td>
<td id="check4">
$emp_delete_check4
</td>  
</tr>


<tr class="bgTwo">
<td>
</td>
<td id="error5">
</td>
<td>
&nbsp;
</td>
<td>
</td>
<td id="error7">
</td>  
</tr>




<tr>
<td align="center" valign="top" id="sub1" colspan="7">
<input  type="submit" name="$submit_name" value="$button_title" />
&nbsp;&nbsp;<input type="reset" value="Reset"/>
<input name="marker" type="hidden" id="marker" value="1" />
$hidden
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



</form>
</body>
</html>
EMPLOYEETEMPLATE;
echo"$employee_template";
?>