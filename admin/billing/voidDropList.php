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
<h1><center>POS Sales Information </center></h1>
</td>
</tr>

<tr style=\"background-color:  #FFF\">
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Line #:</th>
<th align=\"left\" bgcolor=\"#000000\" class=\"keyHeader\">Item Number:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Purchase Date:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Retail Cost:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Barcode:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Club:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Category:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Number of Items:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Wholesale Cost:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">Product Description:</th>
<th align=\"left\"  bgcolor=\"#000000\" class=\"keyHeader\">&nbsp;</th>
</tr>";


$retailCostTot = 0;
$wholeCostTot = 0;
$profit = 0;

$this->cellCount = 1;
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT * FROM merchant_sales WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($item_marker,$purchase_marker,$transaction_id,$number_items,$category_id,$category_name,$bar_code,$product_desc,$sales_tax,$whole_cost,$retail_cost,$total_cost,$purchase_date,$club_id,$club_inv_marker,$internet, $contract_key);
    while ($stmt->fetch()) {  
                $purchase_date = date('F j, Y',strtotime($purchase_date));
                $stmt99 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
               $stmt99->execute();      
               $stmt99->store_result();      
               $stmt99->bind_result($club);
               $stmt99->fetch();
               $stmt99->close();
                
                $retailCostTot += $retail_cost;
                $wholeCostTot += $whole_cost;
                
$subHtml .="<tr>

<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$item_marker</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$purchase_date</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$retail_cost</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$bar_code </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$club</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$category_name</b></td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$number_items</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$$whole_cost </td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$product_desc </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\"><input  type=\"button\" class=\"button1\" id=\"void1\" name=\"void1\" value=\"Void Transaction\" onClick=\"return setContractRecord('$item_marker','$purchase_marker',this.id);\"/></td>
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
$subHtml .="<tr>

<tr style=\"background-color:  #FFF\">
<td align=\"left\"  valign =\"middle\" class=\"keyText\"><input  type=\"button\" class=\"button1\" id=\"void2\" name=\"void2\" value=\"Void All Transaction\" onClick=\"return setContractRecord('$item_marker','$purchase_marker',this.id);\"/></td>
</tr>";

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