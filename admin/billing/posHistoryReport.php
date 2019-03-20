<?php
session_start();



//===============================================================================

class posHistory {
    
private $counter = 0;
private $month = null;
private $barcode = null;


function setContractKey($contractKey){
    $this->contractKey = $contractKey;
}  
           
//connect to database
function dbConnect()   {
require"../dbConnect.php";
return $dbMain;
}


//------------------------------------------------------------------------------------------
function loadListings() {
    
    $dbMain = $this->dbconnect();
   
$counter = 1;
$reportHeader = <<<REPORTHEADER
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport_v2.css"> 
<script type="text/javascript" src="../scripts/printPage.js"></script>

<title>POS History</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6"><strong>POS History Report</strong></span>
</div>


<div id="listings">
<table align="left" border="0" cellspacing="0" cellpadding="4" width=100%>

<tr>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">#</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Quantity</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Barcode</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Product Description</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Cost</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Tax</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Date</font></th>
<th align="left"  bgcolor="#303030"><font face="Arial" size="1" color="#FFFFFF">Club</font></th>
</tr>

REPORTHEADER;

echo"$reportHeader";
//echo "key $this->contractKey";
$stmt3 = $dbMain->prepare("SELECT number_items, bar_code, product_desc, total_cost, sales_tax, purchase_date, club_id FROM merchant_sales WHERE contract_key = '$this->contractKey'");
$stmt3->execute();
$stmt3->store_result();
$stmt3->bind_result($number_items, $bar_code, $product_desc, $total_cost, $sales_tax, $purchase_date, $club_id);
while($stmt3->fetch()){
    
        $stmt = $dbMain->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($club_name);
        $stmt->fetch();
        $stmt->close();
        
        $date = date("F j Y", strtotime($purchase_date));
        
            echo"<tr>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$counter</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$number_items</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$bar_code</b></font>
        </td>  
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$product_desc</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$total_cost</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$$sales_tax</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$date</b></font>
        </td>
        <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
        <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
        </td>
        </tr>\n";
        
        $counter++;
        
        }


echo"</table>\n</div>";
//echo "test";
$stmt = $dbMain ->prepare("SELECT member_id FROM member_info WHERE contract_key = '$this->contractKey'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($barcode);
$stmt->fetch();
$stmt->close();

$now = time();
    $nowDate = date('h:i:s m-d-Y',$now);
    $classInfo = "<div id=\"reportName2\"> 
                    <span class=\"black5\">Name of Report:</span>
                    &nbsp;
                    <span class=\"black6\"><strong>Scheduled Classes</strong></span>
                    </div>
                    
                    <div id=\"listings2\">
                    <table align=\"right\" border=\"0\" cellpadding=\"4\" cellspacing=\"0\" width=\"100%\">
                        <tbody>
                        <tr>
                            <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Class Name</font></th>
                            <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Class Date</font></th>
                            <th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">Club</font></th>
                        </tr>";
                            
    $stmt99 = $dbMain ->prepare("SELECT bundle_id, club_id, class_date_time FROM class_bookings WHERE member_id = '$barcode' AND class_date_time > '$nowDate'");
    $stmt99->execute();      
    $stmt99->store_result();      
    $stmt99->bind_result($bundle_id, $club_id, $class_date_time);
    $rowCount3 = $stmt99->num_rows;
    while($stmt99->fetch()){
        
        $stmt = $dbMain ->prepare("SELECT bundle_name FROM bundle_type WHERE bundle_id = '$bundle_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($bundle_name);
        $stmt->fetch();
        $stmt->close();
    
        $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id = '$club_id'");
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($club_name);
        $stmt->fetch();
        $stmt->close();
        
        $class_date_time = date('h:i m-d-y',strtotime($class_date_time));
        $classInfo .= "<tr>
                            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$bundle_name</b></font>
                            </td>
                            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$class_date_time</b></font>
                            </td>
                            <td align=\"left\" valign =\"top\" bgcolor=\"$this->color\">
                            <font face=\"Arial\" size=\"1\" color=\"black\"><b>$club_name</b></font>
                            </td>
                            </tr>";
        $bundle_id = "";
        $club_id = "";
        $class_date_time = "";
        
    }
    $classInfo .= "</tbody></table>";
    $stmt99->close();
    if($rowCount3 == 0){
        $classInfo .= "You have no Scheduled Classes.</tbody></table>";
    }

echo "$classInfo";
}
//===============================================

}

$contract_key = $_SESSION['contract_key'];
$ajaxSwitch = $_REQUEST['ajax_switch'];
//unset($_SESSION['contract_key']);
//echo "key222 $contract_key";

//$month = 'January';
//$barcode = '127985';
if ($ajaxSwitch == 1){
    $posLookup = new posHistory();
    $posLookup-> setContractKey($contract_key);
    $posLookup->loadListings();
}





?>