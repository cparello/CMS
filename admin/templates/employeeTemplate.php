<?php
session_start();
$employee_template = <<<EMPLOYEETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/employee_form.css">
$javaScript
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body$onLoad>
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

<td colspan="2" class="grey"><u>Employee Contact Information</u>
</td>
<td>
&nbsp
</td>
<td colspan="2" class="grey">
<u>Employee Type Information </u>
</td>
</tr>


<tr>
<td class="black">
First Name:
</td>
<td>
<input  name="first_name" type="text" id="first_name" value="$first_name" size="25" maxlength="60"/>     
</td>
<td>
&nbsp;
</td>
<td class="black">
Primary Employee Type:
</td>
<td>
<select name="employee_type1" id="employee_type1" onChange="alterSubmit(1);"/>
$drop_menu_emp1
</select>
</td>
</tr>

<tr>
<td class="black">
Middle Name:
</td>
<td>
<input name="middle_name" type="text" id="middle_name" value="$middle_name" size="25" maxlength="100" /></td>
<td>
&nbsp;
</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle1" id="payment_cycle1" >
      $cycle_option1
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
</tr>

<tr>
<td class="black">
Last Name:
</td>
<td>
<input  name="last_name" type="text" id="last_name" value="$last_name" size="25" maxlength="30" />
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type1" id="compensation_type1" onChange="compChange(1)" />
      $compensation_option1
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
</select>      
</td>
</tr>

<tr>
<td class="black">
Street Address:
</td>
<td>
<input name="street_address" type="text" id="street_address" value="$street_address" size="25" maxlength="100" />
</td>

<td>&nbsp;
</td>
<td class="black" id="pay1a">
Payment Amount:
</td>
<td  id="pay1b">
<input  name="payment_amount1" type="text" id="payment_amount1" value="$payment_amount1" size="25" maxlength="100" />
</td>
</tr>

<tr>
<td class="black">
City:
</td>
<td>
<input name="city" type="text" id="city" value="$city" size="25" maxlength="30" />
</td>

<td>
&nbsp;
</td>
<td>
</td>
<td id="error4">
</td>
</tr>

<tr>
<td class="black">
State:
</td>
<td>
<select  name="state" id="state" >
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
Employee Type:
</td>
<td>
<select name="employee_type2" id="employee_type2" onChange="alterSubmit(2);"/>
$drop_menu_emp2
</select>
</td>
</tr>

<tr>
<td class="black">
Zipcode:
</td>
<td>
<input name="zip_code" type="text" id="zip_code" value="$zip_code" size="25" maxlength="10" />
</td>
<td>
&nbsp;

</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle2" id="payment_cycle2" >
      $cycle_option2
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
</tr>

<tr>
<td class="black">
Primary Phone:
</td>
<td>
<input name="home_phone" type="text" id="home_phone" value="$home_phone" size="25" maxlength="15" />
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type2" id="compensation_type2" onChange="compChange(2)" />
      $compensation_option2
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
</select>      
</td>
</tr>
    
<tr>
<td class="black">
Cell Phone:
</td>
<td>
<input  name="cell_phone" type="text" id="cell_phone" value="$cell_phone" size="25" maxlength="15" />
</td>
<td>&nbsp;</td>
<td class="black" id="pay2a">
Payment Amount:
</td>
<td  id="pay2b">
<input  name="payment_amount2" type="text" id="payment_amount2" value="$payment_amount2" size="25" maxlength="100" />
</td>
</tr>

<tr>
<td>
&nbsp;
</td>
<td id="error1" colspan="3">
</td>
<td id="error5">
</td>
</tr>


<tr>
<td colspan="2" class="grey">
<u>Emergency Contact Information </u>
</td>
<td>
&nbsp;
</td>
<td class="black">
Employee Type:
</td>
<td>
<select name="employee_type3" id="employee_type3" onChange="alterSubmit(3);"/>
$drop_menu_emp3
</select>
</td>
</tr>

<tr>
<td class="black">
Contact Name:
</td>
<td>
<input name="emergency_contact" type="text" id="emergency_contact" value="$emergency_contact"size="25" maxlength="60" />
</td>

<td>
&nbsp;
</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle3" id="payment_cycle3" >
      $cycle_option3
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>
</tr>

<tr>
<td class="black">
Contact Phone:
</td>
<td>
<input name="emergency_phone" type="text" id="emergency_phone" value="$emergency_phone" size="25" maxlength="15" />
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type3" id="compensation_type3" onChange="compChange(3)" />
      $compensation_option3
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
</select>      
</td>
</tr>

<tr>
<td>
</td>
<td colspan="2" id="error2">
&nbsp;
</td>
<td class="black" id="pay3a">
Payment Amount:
</td>
<td id="pay3b">
<input name="payment_amount3" type="text" id="payment_amount3" value="$payment_amount3" size="25" maxlength="10" />
</td>
</tr>

<tr>
<td class="grey" colspan="2">
<u>Username/Password Creation </u>
</td>
<td>
&nbsp;
</td>
<td>
</td>
<td id="error6">
</td>  
</tr>

<tr>
<td class="black">
Username:
</td>
<td>
<input  name="user_name1" type="text" id="user_name1" value="$user_name1" size="25" maxlength="50" onBlur="return checkUserName(this.value$userIdVar)"/>
</td>
<td>
&nbsp;
</td>
<td class="black">
Employee Type:
</td>
<td>
<select  name="employee_type4" id="employee_type4" onChange="alterSubmit(4);"/>
$drop_menu_emp4
</select>
</td>
</tr>


<tr>
<td class="black">
Password:
</td>
<td>
<input name="pass_word1" type="text" id="pass_word1" value="$pass_word1" size="25" maxlength="10" />
</td>
<td>
&nbsp;
</td>
<td class="black">
Payment Cycle:
</td>
<td>
<select name="payment_cycle4" id="payment_cycle4" >
      $cycle_option4
      <option value="D">Daily</option>
      <option value="W">Weekly</option>
      <option value="B">Bi-Monthly</option>
      <option value="M">Monthly</option>
</select>      
</td>

</tr>


<tr>
<td class="black">
Verify Password:
</td>
<td>
<input  name="pass_word2" type="text" id="pass_word2" value="$pass_word2" size="25" maxlength="10" />
</td>
<td>
&nbsp;
</td>
<td class="black">
Compensation Type:
</td>
<td>
<select name="compensation_type4" id="compensation_type4" onChange="compChange(4)" />
      $compensation_option4
      <option value="S">Salary</option>
      <option value="H">Hourly</option>
      <option value="C">Comission</option>
</select>      
</td>
</tr>


<tr>
<td>
</td>
<td colspan="2" id="error3">
</td>
<td class="black" id="pay4a">
Payment Amount:
</td>
<td id="pay4b">
<input  name="payment_amount4" type="text" id="payment_amount4" value="$payment_amount4" size="25" maxlength="10" />
</td>
</tr>


<tr>
<td colspan="7">
&nbsp;
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


<div class="continue" id="continue">
<span class="secondHeader">
$secondary_title
</span>
<p>
<input  type="submit" name="continue" value="Continue to Sales Services" />
<input name="marker" type="hidden" id="marker" value="1" />
</div>



</form>
</body>
</html>
EMPLOYEETEMPLATE;
echo"$employee_template";
?>