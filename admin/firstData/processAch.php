<?php
/**
* First Data Global Gateway e4℠
*
* Copyright (c) 2004.  All Rights Reserved.
*
* YOUR RIGHTS WITH RESPECT TO THIS SOFTWARE IS GOVERNED BY THE
* TERMS AND CONDITIONS SET FORTH IN THE CORRESPONDING EULA.
*
* Last Updated: May 8, 2006 ----------------- Modified October 5, 2012 by Aaron Sears
*
* A PHP server is required for this sample code and can be downloaded from http://www.php.net 
* PHP 5.1.2 was used for this code.
*
* PHP Extensions required:	
*		php_openssl.dll 		- allows the use of https connections
*								- required files:
*									libeay32.dll	- included in the PHP 5.1.2 package
*									ssleay32.dll	- inlcuded in the PHP 5.1.2 package
*		php_openssl.dll should be inside the 'ext' directory under the PHP installation directory and the required 
*		dependancies are in the root of the PHP installation directory.
* 		The dependencies should be placed in a directory which is part of the windows path or placed in the 'system32' of 
*		the Windows installation directory.
*		php_openssl.dll extension should be enabled in the PHP.ini file used to setup the PHP server.											
*
*		php_soap.dll			- allows the soap communication with the transaction server.
*
*		php_soap.dll should be inside the 'ext' directory under the PHP installation directory.
*		php_soap.dll extension should be enabled in the PHP.ini file used to setup the PHP server.															
*
* For setup of PHP server and activation of PHP extensions please refer to the installation manual included in the 
* PHP 5.1.2 package download.
**/
//$test = date('Y-m-d H:i:s');
//echo "date testenjsdhjkdjk  $test<br>";
class SoapClientHMAC extends SoapClient {
  public function __doRequest($request, $location, $action, $version, $one_way = NULL) {
	global $context;
	require"../dbConnect.php";

    $stmt = $dbMain ->prepare("SELECT hmac, key_id FROM billing_gateway_fields WHERE club_id= '3551'");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($hmackey, $keyid);
    $stmt->fetch();
    $stmt->close();
     // <-- Insert the Key ID here
	$hashtime = date("c");
	$hashstr = "POST\ntext/xml; charset=utf-8\n" . sha1($request) . "\n" . $hashtime . "\n" . parse_url($location,PHP_URL_PATH);
	$authstr = base64_encode(hash_hmac("sha1",$hashstr,$hmackey,TRUE));
	if (version_compare(PHP_VERSION, '5.3.11') == -1) {
		ini_set("user_agent", "PHP-SOAP/" . PHP_VERSION . "\r\nAuthorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request));
	} else {
		stream_context_set_option($context,array("http" => array("header" => "authorization: GGE4_API " . $keyid . ":" . $authstr . "\r\nx-gge4-date: " . $hashtime . "\r\nx-gge4-content-sha1: " . sha1($request))));
	}
    return parent::__doRequest($request, $location, $action, $version, $one_way);
  }
  
  public function SoapClientHMAC($wsdl, $options = NULL) {
	global $context;
	$context = stream_context_create();
	$options['stream_context'] = $context;
	return parent::SoapClient($wsdl, $options);
  }
}
//$gatewayID = "AF7527-01";
//$password = "g3opj80z";
$transactionType = "00";
$contractKey = "129374";
//$language = "en";
$checkNumber = "123";
$checkType = "P";//"P" (personal check), or "C" (corporate check).
$customerName = "Tania F Vasquez";
$amount = "10.00";
$bankAccountNumber = "3423234214";
$bankRoutingNumber =  "011487987";
$customerIdType = "0"; // 0 = dl,  1 = ssid  2 = taxid  4= military id
$customerId = "g23123";  // id value
$streetAddress = "123 fubar way";
$zip = "91501";
$city = "BURBANK";  //caps
$state = "CA";//caps
$country = "US";//caps
$address = "14029 FOOTHILL APT #6|91342|SYLMAR|CA|US";
$email = "none@email.com";

require"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT gateway_id, password, language, max_retries, link FROM billing_gateway_fields WHERE club_id= '3551'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($gatewayID, $password, $language, $maxRetries, $link);
$stmt->fetch();
$stmt->close();

$trxnProperties = array(
  "User_Name"=>"",
  "Secure_AuthResult"=>"",
  "Ecommerce_Flag"=>"8",  // 2 = recurring   R= retail
  "XID"=>"",
  "ExactID"=>"$gatewayID",				    //Payment Gateway
  "Password"=>"$password",					                //Gateway Password
  "Transaction_Type"=>$transactionType,//Transaction Code I.E. Purchase="00" Pre-Authorization="01" etc.
  "Reference_No"=>$contractKey,
  "Customer_Ref"=>$_POST["tbPOS_Customer_Ref"],
  "Reference_3"=>$_POST["tbPOS_Reference_3"],
  "Client_IP"=>"",					                    //This value is only used for fraud investigation.
  "Client_Email"=>$email,			//This value is only used for fraud investigation.
  "Language"=>$language,				//English="en" French="fr"
  "CheckNumber"=>$checkNumber,		    //For Testing, Use Test#s VISA="4111111111111111" MasterCard="5500000000000004" etc.
  "CheckType"=>$checkType,//"P" (personal check), or "C" (corporate check).
  "CustomerName"=>$customerName,
  "BankAccountNumber"=>$bankAccountNumber,
  "BankRoutingNumber"=>$bankRoutingNumber,
  "CustomerID"=>$customerId,
  "CustomerIDType"=>$customerIdType,
  "Address"=>$address,
  "Track1"=>"",
  "Track2"=>"",
  "Authorization_Num"=>$_POST["tbPOS_Authorization_Num"],
  "Transaction_Tag"=>$_POST["tbPOS_Transaction_Tag"],
  "DollarAmount"=>$amount,
  "VerificationStr1"=>$_POST["tbPOS_VerificationStr1"],
  "VerificationStr2"=>"",
  "CVD_Presence_Ind"=>"",
  "Secure_AuthRequired"=>"",
  "Currency"=>"USD",    //https://firstdata.zendesk.com/entries/450214-supported-currencies
  "PartialRedemption"=>"",
  
  // Level 2 fields 
  "ZipCode"=>$_POST["tbPOS_ZipCode"],
  "Tax1Amount"=>$_POST["tbPOS_Tax1Amount"],
  "Tax1Number"=>$_POST["tbPOS_Tax1Number"],
  "Tax2Amount"=>$_POST["tbPOS_Tax2Amount"],
  "Tax2Number"=>$_POST["tbPOS_Tax2Number"],
  
  "SurchargeAmount"=>$_POST["tbPOS_SurchargeAmount"],	//Used for debit transactions only
  "PAN"=>$_POST["tbPOS_PAN"]							//Used for debit transactions only
  );


$client = new SoapClientHMAC($link);
$trxnResult = $client->SendAndCommitCheck($trxnProperties);


if(@$client->fault){
    // there was a fault, inform
    print "<B>FAULT:  Code: {$client->faultcode} <BR />";
    print "String: {$client->faultstring} </B>";
    $trxnResult["CTR"] = "There was an error while processing. No TRANSACTION DATA IN CTR!";
}
//Uncomment the following commented code to display the full results.

echo "<H3><U>Transaction Properties BEFORE Processing</U></H3>";
echo "<TABLE border='0'>\n";
echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
foreach($trxnProperties as $key=>$value){
    echo " <TR><TD>$key</TD><TD>:$value</TD></TR>\n";
}
echo "</TABLE>\n";

echo "<H3><U>Transaction Properties AFTER Processing</U></H3>";
echo "<TABLE border='0'>\n";
echo " <TR><TD><B>Property</B></TD><TD><B>Value</B></TD></TR>\n";
foreach($trxnResult as $key=>$value){
    $value = nl2br($value);
    echo " <TR><TD valign='top'>$key</TD><TD>:$value</TD></TR>\n";
}
echo "</TABLE>\n";


// kill object
unset($client);
?>

<html>
<head>
<title>VPOS - Sample Code</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</head>

<body>
    <table>
	    <tr><td>
	    <table cellSpacing="0" cellPadding="0" width="660" align="left" border="0">
<tr>
	<td><font face="verdana,arial,helvetica" size="5"><b>First Data Global Gateway e4 POS</b></font></td>
</tr>
	        </table></td></tr>
	        <tr><td>
	        <table cellSpacing="6" cellPadding="0" width="660" align="left" border="2">
		        <tr>
			        <td align="left" valign="top">
						<?php 
							foreach($trxnResult as $key=>$value){
								if ($key == "CTR") {
								    $value = nl2br($value);
									print $value;
								}
							}
						?></td>
                    <!-- NOTE: chr(10) is the ASCII equivalent of the "Line Feed" character -->
		        </tr>
		        <tr>
			        <td align="center" valign="top"><a href="javascript:history.back();">Perform Another Transaction</a></td>
		        </tr>
	    </table></td></tr>
    </table>
</body>
</html>
