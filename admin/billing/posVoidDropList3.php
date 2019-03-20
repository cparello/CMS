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
<td colspan=\"17\" class=\"oBtext\">
<h1><center>POS Return Information </center></h1>
</td>
<br>
<br>
<td align=\"right\" class=\"checkText\">
<div id=\"addSet1\"></div>
</td>
</tr>

<tr style=\"background-color:  #FFF\">
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Line #:</th>
<th align=\"left\" bgcolor=\"#FFFFFF\" class=\"keyHeader\">Return Marker:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Return Type:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Return Reason:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Item Marker:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Invoice Number:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Number of Items:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Category:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Category Name:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Barcode:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Product Description:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Sales Tax:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Wholesale Cost:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Retail Cost:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Total Cost:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Return Date:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Club:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Club Inventory Marker:</th>
</tr>";


$retailCostTot = 0;
$wholeCostTot = 0;
$profit = 0;

$this->cellCount = 1;
$dbMain = $this->dbconnect();
   $stmt = $dbMain ->prepare("SELECT *  FROM refund_exchange WHERE $this->searchSql");
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($re_marker, $re_type, $return_reason, $item_marker, $purchase_marker, $number_items, $category_id, $category_name, $bar_code, $product_desc, $sales_tax, $whole_cost, $retail_cost, $total_cost, $re_date, $club_id, $club_inv_marker);
    while ($stmt->fetch()) {  
                $re_date = date('F j, Y',strtotime($re_date));
                $stmt99 = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
               $stmt99->execute();      
               $stmt99->store_result();      
               $stmt99->bind_result($club);
               $stmt99->fetch();
               $stmt99->close();
               //echo "marker $this->searchSql";
               //exit;
                
                
$subHtml .="<tr>

<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$re_marker</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$re_type</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$return_reason</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$item_marker</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$purchase_marker </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$number_items</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$category_name</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$category_id</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$bar_code </td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$product_desc </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$sales_tax</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$$whole_cost </td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$retail_cost</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$total_cost</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$re_date</td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$club </td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$club_inv_marker </td>
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
            
$stmt->close(); 

//$profit = $retailCostTot - $wholeCostTot;
//$this->cellCount--;
/*$subHtml .= "
<br>
<br>
<br>
<br>
<tr style=\"background-color:  #FFF\">
<td class=\"oBtext\">
<h3>POS Total Sales</h3>
</td>
</tr>
<tr style=\"background-color:  #FFF\">
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Total Sales</th>
<th align=\"left\" bgcolor=\"#FFFFFF\" class=\"keyHeader\">Gross Sales:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Wholesale Cost:</th>
<th align=\"left\"  bgcolor=\"#FFFFFF\" class=\"keyHeader\">Profit:</th>
</tr>
<tr>
<tr style=\"background-color:  #FFF\">
<td align=\"left\" valign =\"middle\" class=\"keyText\">$this->cellCount.</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$retailCostTot</td>
<td align=\"left\"  valign =\"middle\" class=\"keyText\">$$wholeCostTot</b></td>
<td align=\"left\" valign =\"middle\" class=\"keyText\">$$profit </td>
</tr>
";*/

$subHtml .= "
</tr>

</table>
</div>
</form>
</div>
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