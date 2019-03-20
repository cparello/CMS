<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class contactForms {

private $groupType;
private $groupForm;
private $contactHeader;
private $groupInfoForm;
private $groupInfoHeader;

function setGroupType($groupType) {
       $this->groupType = $groupType;
       }

//---------------------------------------------------------------------------------------------------------------------------------------
function createGroupInfoForm()  {

$info_form = <<<INFOFORM
<table></table>
<table id="secTab" align="center" cellpadding="2" class="tabBoard2">
<tr class="tabHead">
<td colspan="3" class="oBtext">
$this->groupInfoHeader Information 
</td>
</tr>
<tr>
<td class="black">
$this->groupInfoHeader Name:
</td>
<td class="black">
$this->groupInfoHeader Address:
</td>
<td class="black">
$this->groupInfoHeader Phone:
</td>
</tr>
<tr>
<td class="pad">
<input  name="type_name" type="text" id="type_name" value="" size="30" maxlength="30"  tabindex="13" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="type_address" type="text" id="type_address" value="" size="50" maxlength="50"  tabindex="14" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="type_phone" type="text" id="type_phone" value="" size="25" maxlength="30"  tabindex="15" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
</table>
INFOFORM;

return $info_form;

}       
//----------------------------------------------------------------------------------------------------------------------------------------
function createContactForm()   {


$contact_form = <<<CONTACTFORM
<table id="secTab" align="center" cellpadding="2" border="0" class="tabBoard1">
<tr class="tabHead">
<td colspan="3" class="oBtext">
$this->contactHeader
</td>
<td align="right" class="checkText">
<div id="addSet1"></div>
</td>
</tr>
<tr>
<td class="black">
First Name:
</td>
<td class="black">
Middle Name: <span class="dob">(Optional)</span>
</td>
<td class="black" colspan="2">
Last Name:
</td>
</tr>
<tr>
<td>
<input  name="first_name[]" type="text" id="first_name1" value="" size="25" maxlength="60" tabindex="8" onClick="return checkServices(this.name,this.id)"/>     
</td>
<td>
<input name="middle_name[]" type="text" id="middle_name1" value="" size="25" maxlength="100"  tabindex="9" onClick="return checkServices(this.name,this.id)"/>
</td>
<td>
<input  name="last_name[]" type="text" id="last_name1" value="" size="25" maxlength="30"  tabindex="10"onClick="return checkServices(this.name,this.id)"/>
</td>
<td rowspan="7" valign="top">
&nbsp;
</td>



</tr>
<tr>
<td class="black">
Street Address:
</td>
<td class="black">
City:
</td>
<td class="black">
State:
</td>
</tr>
<tr>
<td>
<input name="street_address[]" type="text" id="street_address1" value="" size="25" maxlength="100"  tabindex="11" onClick="return checkServices(this.name,this.id)"/>
</td>
<td>
<input name="city[]" type="text" id="city1" value="" size="25" maxlength="30"  tabindex="12" onClick="return checkServices(this.name,this.id)"/>
</td>
<td>
<select  name="state[]" id="state1"   onClick="return checkServices(this.name,this.id)"/>
      <option value="">Select State</option>
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
</tr>
<tr>
<td class="black">
Zipcode:
</td>
<td class="black">
Primary Phone:
</td>
<td class="black">
Cell Phone:
</td>
</tr>
<tr>
<td>
<input name="zip_code[]" type="text" id="zip_code1" value="" size="25" maxlength="5"  tabindex="13" onClick="return checkServices(this.name,this.id)"/>
</td>
<td>
<input name="home_phone[]" type="text" id="home_phone1" value="" size="25" maxlength="15"  tabindex="14" onClick="return checkServices(this.name,this.id)"/>
</td>
<td>
<input  name="cell_phone[]" type="text" id="cell_phone1" value="" size="25" maxlength="15"  tabindex="15" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>
<tr>
<td class="black">
Email Address:
</td>
<td class="black">
Date of Birth: <span class="dob">(mm/dd/yyyy)</span>
</td>
<td class="black">
Drivers License:
</td>
</tr>
<tr>
<td class="pad">
<input  name="email[]" type="text" id="email1" value="" size="25" maxlength="30"  tabindex="16" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="dob[]" type="text" id="dob1" value="" size="25" maxlength="30"  tabindex="17" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="lic_num[]" type="text" id="lic_num1" value="" size="25" maxlength="30"  tabindex="18" onClick="return checkServices(this.name,this.id)"/>
</td>
</tr>

<tr class="tabHead">
<td colspan="3" class="oBtext">
Emergency Contact Information
</td>
<td align="right" class="checkText">
<div id="contactSet1"></div>
</td>
</tr>
<tr>
<td class="black">
Contact Name:
</td>
<td class="black">
Relationship:
</td>
<td class="black">
Contact Phone:
</td>
<td class="black">
&nbsp;
</td>
</tr>
<tr>
<td class="pad">
<input  name="econt_name[]" type="text" id="econt_name1" value="" size="25" maxlength="30"  tabindex="19" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="econt_relation[]" type="text" id="econt_relation1" value="" size="25" maxlength="30"  tabindex="20" onClick="return checkServices(this.name,this.id)"/>
</td>
<td class="pad">
<input  name="econt_phone[]" type="text" id="econt_phone1" value="" size="25" maxlength="30"  tabindex="21" onClick="return checkServices(this.name,this.id)"/>
</td>
<td valign="top">
<input  type="button" class="button1" name="liability_form" value="Print Waiver">
</td>
</tr>
</table>
CONTACTFORM;

return  $contact_form;

}       
//----------------------------------------------------------------------------------------------------------------------------------------       
function loadGroupForms()  {       
       
        switch($this->groupType) {          
                       case"S":
                       $this->contactHeader = 'Contact Information';
                       $this->groupForm = $this->createContactForm();
                       $this->groupInfoForm = "<table></table>";
                       break;
                       case"F":
                       $this->contactHeader = 'Primary Contact Information 1';
                       $this->groupForm = $this->createContactForm();
                       $this->groupInfoForm = "<table></table>";
                       break;
                       case"B":
                       $this->contactHeader = 'Primary Contact Information 1';
                       $this->groupInfoHeader = "Business";
                       $this->groupForm = $this->createContactForm();
                       $this->groupInfoForm = $this->createGroupInfoForm();
                       break;
                       case"O":
                       $this->contactHeader = 'Primary Contact Information 1';
                       $this->groupInfoHeader = "Organization";
                       $this->groupForm = $this->createContactForm();
                       $this->groupInfoForm = $this->createGroupInfoForm();
                       break;
                       }
       
 
 }      
//---------------------------------------------------------------------------------------------------------------------------------------

function getGroupForm()   {
         return($this->groupForm);
             }

function getGroupInfoForm() {
         return($this->groupInfoForm);
         }




}
?>