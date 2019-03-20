<?php
$sig = str_replace(' ','+',$sig);
$renewalTemplate = <<<RENEWALTEMPLATE
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="../css/contract.css"/>
$javaScript1
	<title>Untitled</title>
</head>
<body>
<div id="pageWrap">
<div id="contractHeaders">
<div id="logoDiv">
$logo_image
</div>
<div id="contractType">
<span class="typeName">$renewal_header</span>
<span class="pipe">|</span>
<span class="contractNumber">Contract #$contract_key</span>
</div>
</div>

<div id="hostHeader">
<span class="subHeader">LIABILITY HOST (Contract Holder)</span>
</div>
<div id="underline"></div>

<div id="memberInfo">
<table>
$group_info
<tr>
<td class="nameTitles">
Member Name:
</td>
<td class="nameSakes">
$first_name $middle_name $last_name
</td>
</tr>
<tr>
<td class="nameTitles">
Address:
</td>
<td class="nameSakes">
$street_address
</td>
</tr>
<tr>
<td class="nameTitles">
Primary Phone:
</td>
<td class="nameSakes">
$primary_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Cell Phone:
</td>
<td class="nameSakes">
$cell_phone
</td>
</tr>
<tr>
<td class="nameTitles">
Email Address:
</td>
<td class="nameSakes">
$email_address
</td>
</tr>
</table>
</div>

<div id="agreeLine">
It is agreed by and between "$business_name" (d.b.a. "$business_dba"), hereinafter,
"$business_name", and Liability Host and/or the Contract Holder named above, as follows:
</div>

<div id="summaryHeader">
<span class="subHeader">RENEWAL SUMMARY</span>
</div>
<div id="underline2"></div>

<div id="summaryInfo">
<table cellpadding="0" cellspacing="0">
$summary_rows
</table>
</div>

<div id="initialHeader">
<span class="subHeader">RENEWAL PAYMENTS</span>
</div>
<div id="underline3"></div>

<div id="initialPayments">
<table cellpadding="0" cellspacing="0">
$initial_payments
</table>
</div>

<div id="terms">
<p>
$contract_terms
</p>
</div>

<div id="signUp">
$contract_location
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<div id="signature">
<img width="300" height="160" alt="sigImage" src="$sig" />
</div>

<div id="empsignature">
<span class="signatures">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>$emp_name</b></span>
</div>

<div id="signHouse">
<div id="signLine1"><span class="signatures">CONTRACTOR HOLDER SIGNATURE</span></div>
<div id="signLine2"><span class="signatures">SIGNATURE OF CLUB REPRESENTATIVE</span></div>
</div>

</div>
</body>
</html>
RENEWALTEMPLATE;

$imArray = explode(',',$sig);
$data = base64_decode($imArray[1]);
//$im = imagecreatefromstring($data);

$ourFileName = "../sigs/$contract_key.png";
$ourFileHandle = fopen($ourFileName, 'c');
//perror($ourFileHandle);

fwrite($ourFileHandle, $data);                
fclose($ourFileHandle);
include '../dbConnect.php';
include '../dbConnectOne.php';
$stmt = $dbMain->prepare("SELECT DATABASE() AS database_name");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($database_name); 
$stmt->fetch();
$stmt->close();

$namearray = explode('_',$database_name);
$id = $namearray[1];

$stmt = $dbMainOne ->prepare("SELECT dns_name FROM dns_info WHERE bus_id = '$id'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($dns_name);   
$stmt->fetch();   
$stmt->close();

$url = "cmp.$dns_name";

$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\"
        \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head> 
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
<link rel=\"stylesheet\" href=\"../css/contract.css\"/>
$javaScript1
	<title>Untitled</title>
</head>
<body>

<img src=\"$url/admin/images/contract_logo.png \" />

<tr>
<h3>$renewal_header&nbsp;|&nbsp;Contract #$contract_key</h3>
</tr>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">LIABILITY HOST (Contract Holder)</font></th>
</tr>


<table>
$group_info
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Host Name:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$first_name $middle_name $last_name</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Address:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$street_address</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Primary Phone:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$primary_phone</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Cell Phone:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$cell_phone</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">Email Address:</font></th>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">$email_address</font></th>
</tr>
</table>
<br>
<br>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">It is agreed by and between \"$business_name\" (d.b.a. \"$business_dba\"), hereinafter,
\"$business_name\", and Liability Host and/or the Contract Holder named above, as follows:</font></th>
</tr>
<br>
<br>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">RENEWAL SUMMARY</font></th>
</tr>

<table cellpadding=\"0\" cellspacing=\"0\">
$summary_rows_email
</table>

<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">RENEWAL PAYMENTS</font></th>
</tr>


<table cellpadding=\"0\" cellspacing=\"0\">
$initial_payments_email
</table>


<p>
<b>$contract_terms</b>
</p>


<tr>
<th align=\"left\"  bgcolor=\"#303030\"><font face=\"Arial\" size=\"1\" color=\"#FFFFFF\">$contract_location</font></th>
</tr>


<br>
<br>
<br>
<br>
<br>
<br>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><img src=\"$url/admin/sigs/$contract_key.png\" alt=\"sigImage\" /></th>
<tr>


<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"><font face=\"Arial\" size=\"1\" color=\"#000000\">CONTRACT HOLDER SIGNATURE_________________________________</font><font face=\"Arial\" size=\"1\" color=\"#000000\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CLUB REPRESENTATIVE: &nbsp;&nbsp;&nbsp;$emp_name</font></th>
</tr>
<tr>
<th align=\"left\"  bgcolor=\"#FFFFFF\"></th>
</tr>
</body>
</html>";


$headers  = "From: $business_name@info.com\r\n";
$headers .= "Content-type: text/html\r\n";   

$signature = "";
$date = date("Y-m-d");
include '../dbConnect.php';
$sql = "INSERT INTO contract_signatures VALUES (?,?,?,?)";
$stmt = $dbMain->prepare($sql);
$stmt->bind_param('isss', $contract_key, $signature,$message,$date);

if(!$stmt->execute())  {
	printf("Error: %s.signature\n", $stmt->error);
   }		
$stmt->close();  

$contractTemplate = trim($contractTemplate);
mail($email_address, "$business_name Contract", $message, $headers);

$renewalTemplate = trim($renewalTemplate);
echo"$renewalTemplate";
?>
