<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class  accountDropList {

private  $searchSql = null;
private  $groupSql = null;
private  $groupName = null;
private  $accountList = null;
private  $earlyRenewalGrace = null;
private  $earlyRenewalPercent = null;
private  $earlyAvailable = null;
private  $backGroundColor = null;
private  $elementDisabled = null;
private  $contractKey = null;
private  $firstName = null;
private  $middleName = null;
private  $lastName = null;
private  $streetAddress = null;
private  $city = null;
private  $state = null;
private  $zipCode = null;
private  $primaryPhone = null;
private  $emailAddress = null;
private  $renewButton = null;
private  $accountStatus = null;
private  $monthlyServices = null;
private  $pifServices = null;
private  $serviceTerm = null;
private  $cellCount = 1;
private  $tableTag = null;
private  $tableEndTag = null;
private  $fontClass = null;
private  $prePayButton = null;

function setSearchSql($searchSql) {
                 $this->searchSql = $searchSql;
              }

//connect to database
function dbconnect()   {
require"../dbConnect.php";
return $dbMain;
}

//========================================================================
function loadAccountList() {

$subHtml = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"
        \"http://www.w3.org/TR/html4/loose.dtd\">
<html>
<head>
<link rel=\"stylesheet\" href=\"../css/accountInfo.css\"/>
<link rel=\"stylesheet\" href=\"../css/printReport.css\">
<script type=\"text/javascript\" src=\"../scripts/printPage.js\"></script>

<title>Untitled</title>
</head>
<body>

";

/*<tr>
<td class=\"black\">
Line Number:
</td>
<td class=\"black\">
Invoice Number:
</td>
<td class=\"black\">
Purchase Date:
</td>
<td class=\"black\">
Retail Cost:
</td>
<td class=\"black\">
Barcode:
</td>
<td class=\"black\">
Club ID:
</td>
<td class=\"black\">
Category:
</td>
<td class=\"black\">
Number of Items:
</td>
<td class=\"black\">
Wholesale Cost:
</td>
</tr>";*/


           $subHtml .= "
<div id=\"userForm1\">
<table id=\"secTab\" align=\"center\" cellpadding=\"2\" border=\"0\" class=\"tabBoard1\">
<tr class=\"tabHead\">
<td>
<a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/contract_logo.png\"  /></a>
</td>
<td colspan=\"10\" class=\"oBtext\">
<h1><center>Note Search Results</center></h1>
</td>
</tr>

<tr style=\"background-color:  #FFF\">
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Line #:</th>
<th align=\"left\" bgcolor=\"#000000\" class=\"keyHeader\">Contract Key:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Note Topic:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Note Message:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Deletion Date:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\"></th>
</tr>";


$retailCostTot = 0;
$wholeCostTot = 0;
$profit = 0;

$this->cellCount = 1;
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM account_notes_deleted WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($contract_key, $note_topic, $note_msg, $deletion_date);
    while ($stmt->fetch()) {  
                $deletion_date = date('F j, Y',strtotime($deletion_date));
                
$subHtml .="<tr>

<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$contract_key</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$note_topic</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$note_msg</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$deletion_date </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\"><input  type=\"button\" class=\"button1\" id=\"view1\" name=\"view1\" value=\"View Note\" onClick=\"return setContractRecord('$contract_key','$note_topic','$note_msg','$deletion_date',this.id);\"/></td>
</tr>";


/*$subHtml .="<tr>
<td>
<input  name=\"counter\" type=\"text\" id=\"counter\" value=\"$this->cellCount\" size=\"5\" maxlength=\"20\"  disabled/>     
</td>
<td>
<input  name=\"invoice\" type=\"text\" id=\"invoice\" value=\"$item_marker\" size=\"7\" maxlength=\"20\"  disabled/>     
</td>
<td>
<input  name=\"date\" type=\"text\" id=\"date\" value=\"$purchase_date\" size=\"25\" maxlength=\"30\"  disabled />
</td>
<td>
<input name=\"retail\" type=\"text\" id=\"retail\" value=\"$retail_cost\" size=\"7\" maxlength=\"10\" disabled/>
</td>
<td>
<input name=\"barcode\" type=\"text\" id=\"barcode\" value=\"$bar_code\" size=\"10\" maxlength=\"15\" disabled/>
</td>
<td>
<input name=\"club\" type=\"text\" id=\"club\" value=\"$club_id\" size=\"15\" maxlength=\"25\" disabled/>
</td>
<td>
<input name=\"cat\" type=\"text\" id=\"cat\" value=\"$category_name\" size=\"25\" maxlength=\"5\"  disabled/>
</td>
<td class=\"pad\">
<input  name=\"number\" type=\"text\" id=\"number\" value=\"$number_items\" size=\"5\" maxlength=\"10\" disabled/>
</td>
<td class=\"pad\">
<input  name=\"whole\" type=\"text\" id=\"whole\" value=\"$whole_cost\" size=\"7\" maxlength=\"100\" disabled/>
</td>
<td rowspan=\"7\" valign=\"top\">
&nbsp;
</td>
<br>";*/
            
           
                                                                 
            $this->cellCount++;


            }
            
    if(!$stmt->execute())  {
	printf("Error: %s.\n", $stmt->error);
      }
   
$stmt->close(); 

$subHtml .= "
</table>
</div>
</body>
</html>";

$this->subHtml = $subHtml;
   return "$this->subHtml";

        
}
//======================================================================

function getAccountList() {
        return($this->subHtml);
       }
       
       
       
       
}
?>