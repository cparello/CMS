<?php
require"../dbConnect.php";
//foreach($ckeyArr as $contractKey){
    $contractKey = 56995;
   // $dbMain = $this->dbconnect();
    $stmt = $dbMain ->prepare("SELECT first_name, middle_name, last_name, primary_phone, cell_phone, email, street, city, state, zip FROM contract_info WHERE contract_key = '$contractKey' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($first_name, $middle_name, $last_name, $primaryPhone, $cellPhone, $email, $street, $city, $state, $zip);
    $stmt->fetch();
    $stmt->close();
    
    $stmt = $dbMain ->prepare("SELECT start_date, end_date FROM paid_full_services WHERE contract_key = '$contractKey' ");
    $stmt->execute();      
    $stmt->store_result();      
    $stmt->bind_result($start_date, $end_date);
    $stmt->fetch();
    $stmt->close();
    
    $name = "$first_name $middle_name $last_name";
    
    $address = "$street $city, $state $zip";
    
    $contractHtml = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
                    <html xmlns=\"http://www.w3.org/1999/xhtml\">
                    <head>
                    <link rel=\"stylesheet\" href=\"../css/contractv2.css\"/>
                    	<title>Untitled</title>
                    </head>
                    <body>
                    <div id=\"pageWrap\">
                    <div id=\"contractHeaders\">
                    <div id=\"logoDiv\">
                    <a href=\"javascript: void(0)\" onClick=\"printPage()\"><img src=\"../images/contract_logo.png\" width=\"139\" height=\"54\" /></a>
                    </div>
                    <div id=\"contractType\">
                    <span class=\"typeName\">Single Service Agreement</span>
                    <span class=\"pipe\">|</span>
                    <span class=\"contractNumber\">Contract #$contractKey</span>
                    </div>
                    </div>
                    
                    <div id=\"hostHeader\">
                    <span class=\"subHeader\">LIABILITY HOST (Contract Holder)</span>
                    </div>
                    <div id=\"underline\"></div>
                    
                    <div id=\"memberInfo\">
                    <table>
                    
                    <tr>
                    <td class=\"nameTitles\">
                    Host Name:
                    </td>
                    <td class=\"nameSakes\">
                    $name
                    </td>
                    </tr>
                    <tr>
                    <td class=\"nameTitles\">
                    Address:
                    </td>
                    <td class=\"nameSakes\">
                    $address
                    </td>
                    </tr>
                    <tr>
                    <td class=\"nameTitles\">
                    Primary Phone:
                    </td>
                    <td class=\"nameSakes\">
                    $primaryPhone
                    </td>
                    </tr>
                    <tr>
                    <td class=\"nameTitles\">
                    Cell Phone:
                    </td>
                    <td class=\"nameSakes\">
                    $cellPhone
                    </td>
                    </tr>
                    <tr>
                    <td class=\"nameTitles\">
                    Email Address:
                    </td>
                    <td class=\"nameSakes\">
                    $email
                    </td>
                    </tr>
                    </table>
                    </div>
                    
                    <div id=\"agreeLine\">
                    It is agreed by and between \"BURBANK ATHLETIC CLUB\" (d.b.a. \"BURBANK ATHLETIC CLUB LLC\"), hereinafter,
                    \"BURBANK ATHLETIC CLUB\", and Liability Host and/or the Contract Holder named above, as follows:
                    </div>
                    
                    <div id=\"summaryHeader\">
                    <span class=\"subHeader\">SERVICE SUMMARY</span>
                    </div>
                    <div id=\"underline2\"></div>
                    
                    <div id=\"summaryInfo\">
                    <table cellpadding=\"0\" cellspacing=\"0\">
                    
                    <tr>
                    <td class=\"fieldHeaderTop\">
                    Quantity
                    </td>
                    <td class=\"fieldHeaderTop\">
                    Service Name
                    </td>
                    <td class=\"fieldHeaderTop\">
                    Service Location
                    </td>
                    <td class=\"fieldHeaderTop\">
                    Service Duration
                    </td>
                    </tr>
                    
                    <tr>
                    <td class=\"fieldValues\">
                    1
                    </td>
                    <td class=\"fieldValues\">
                    Monthly Membership
                    </td>
                    <td class=\"fieldValues\">
                     All Locations
                    </td>
                    <td class=\"fieldValues\" >
                    12 Month(s)
                    </td>
                    </tr>
                    
                    <tr>
                    <td class=\"fieldHeader\">
                    Unit Cost
                    </td>
                    <td class=\"fieldHeader\">
                    Unit Renew Rate
                    </td>
                    <td class=\"fieldHeader\">
                    Group Cost
                    </td>
                    <td class=\"fieldHeader\">
                    Group Renew Rate
                    </td>
                    </tr>
                    
                    <tr>
                    <td class=\"fieldValues\">
                    120.00
                    </td>
                    <td class=\"fieldValues\">
                    120.00
                    </td>
                    <td class=\"fieldValues\">
                    NA
                    </td>
                    <td class=\"fieldValues\">
                    NA
                    </td>
                    </tr>
                    
                    <tr>
                    <td class=\"fieldHeader pad\">
                    Monthly Dues
                    </td>
                    <td class=\"fieldHeader pad\">
                    Term Type
                    </td>
                    <td  class=\"fieldHeader pad\">
                    Start Date
                    </td>
                    <td class=\"fieldHeader pad\">
                    End Date
                    </td>
                    </tr>
                    
                    <tr>
                    <td class=\"fieldValues\">
                    10.00
                    </td>
                    <td class=\"fieldValues\">
                    Full Term
                    </td>
                    <td class=\"fieldValues\">
                    May 14, 2015
                    </td>
                    <td class=\"fieldValues\">
                    May 14, 2016
                    </td>
                    </tr>
                    
                    
                    </table>
                    </div>
                    
                    
                    <div id=\"initialHeader\">
                    <span class=\"subHeader\">INITIAL PAYMENTS</span>
                    </div>
                    <div id=\"underline3\"></div>
                    
                    <div id=\"initialPayments\">
                    <table cellpadding=\"0\" cellspacing=\"0\">
                      <tr><td class=\"nameTitles2\">Processing Fee (Monthly Services):</td><td class=\"nameSakes2\">0.00</td><td class=\"nameSakes3\"></td></tr> <tr><td class=\"nameTitles2\">Prorate Dues (Monthly Services):</td><td class=\"nameSakes2\">0</td><td class=\"nameSakes3\"></td></tr>   <tr><td class=\"nameTitles2 pad\">TOTAL DUE:</td><td class=\"nameSakes4 pad\">10.00</td><td class=\"nameSakes3\"></td></tr> <tr><td class=\"nameTitles2\">TODAYS PAYMENT:</td><td class=\"nameSakes2\">10.00</td><td class=\"nameSakes3\"></td></tr> <tr><td class=\"nameTitles2\">BALANCE DUE:</td><td class=\"nameSakes2\">0.00</td><td class=\"nameSakes3\">DUE DATE:<span class=\"dueDate\">  $start_date</span></td></tr>
                    </table>
                    </div>
                    
                    <div id=\"terms\">
                    <p>
                    (5)DAY CANCELLATION: YOU, THE BUYER, MAY CANCEL THIS AGREEMENT AT ANY TIME PRIOR TO MIDNIGHT OF THE FIFTH BUSINESS DAY AFTER THE DATE OF THIS AGREEMENT, EXCLUDING SUNDAYS AND HOLIDAYS. IF CREDIT IS DUE, A REFUND WILL BE ISSUED BETWEEN 60 AND 90 DAYS. 
                    BEYOND THE INITIAL 5DAY COOL OFF PERIOD AND TERM OF THE AGREEMENT, TO CANCEL THIS AGREEMENT ALL MONTHLY PAY PLAN MEMBERS MUST SEND IN A 30DAY NOTICE IN ORDER TO CANCEL THEIR MONTHLY BILLING MEMBERSHIP TO BURBANK ATHLETIC CLUB, P.O. BOX 10997, BURBANK, CALIFORNIA 91510-0506 OR EMAIL TO INFO@BURBANKATHLETICCLUB.COM.FOR ALL MONTHLY MEMBERSHIPS SOLD PRIOR TO 2012 A $35.00 CANCELLATION FEE IS REQUIRED TO CANCEL A MEMBERSHIP. FOR THE OPEN-ENDED $30.00 A MONTH MEMBERSHIP A 60 DAY ADVANCED WRITTEN CANCELLATION NOTICE IS REQUIRED. ALL PAID IN FULL SERVICE PURCHASES ARE FINAL.  UNLESS SPECIFIED AT TIME OF SALE THE MEMBERSHIP RENEWAL RATE IS SUBJECT TO CHANGE. GUARANTEED MEMBERSHIP RENEWAL RATES ARE VOID AFTER 30DAYS FROM EXPIRATION DATE OF AGREEMENT. 
                    ALL CLASS PURCHASES ARE FINAL. THERE ARE NO REFUNDS FOR MISSED CLASSES OR NO SHOWS. ONLY INDIVIDUAL PERSONAL TRAINING SESSIONS CAN BE RESCHEDULED WITH 24 HOUR ADVANCED NOTICE. FOR YOGA AND GROUP CYCLING PARTICIPANTS THE UNLIMITED MONTHLY OPTION ONLY ALLOWS FOR TWO CANCELLATIONS PER MONTH. THIS WILL ENSURE FAIR ACCESS TO ALL WILLING PARTICIPANTS. IF YOU EXCEED TWO CANCELLATIONS YOU WILL BE WARNED BY THE COORDINATOR OF THE DEPARTMENT AND THE BURBANK ATHLETIC CLUB RESERVES THE RIGHT TO REVOKE YOUR UNLIMITED ACCESS TO THE PROGRAM.
                    MONTHLY DUES: THE BILLING DATE FOR BURBANK ATHLETIC CLUB IS THE 25TH OF EVERY MONTH, OR THE NEXT BUSINESS DAY. MONTHLY DUES CHARGES WILL CONTINUE TO BE DUE EACH MONTH REGARDLESS OF YOUR USE OF THE CLUB UNTIL YOU NOTIFY US IN WRITING THAT YOU WISH TO CANCEL THIS CONTRACT.  REGARDLESS OF SUCH CANCELLATION, ANY OUTSTANDING BALANCE OF THE MEMBERSHIP FEE WILL REMAIN DUE AND PAYABLE IN ACCORDANCE WITH THIS CONTRACT. PROVIDED YOU ARE IN GOOD STANDING AND THE MEMBERSHIP FEE IS PAID IN FULL, YOU MAY WITHIN THIRTY (30) DAYS OF THE DATE OF THIS CONTRACT OR THE YEARLY ANNIVERSARY DATE OF THIS CONTRACT, PAY THE MONTHLY DUES IN ADVANCE FOR A FULL YEAR AS ANNUAL DUES. WE MAY APPLY DUES PAYMENTS TO PAY ANY OTHER SUMS WHICH ARE PAST DUE. IF YOU FAIL TO PAY ANY MONTHLY DUES PAYMENT WITHIN 30 DAYS AFTER THE DATE SUCH PAYMENT IS DUE, YOUR MEMBERSHIP PRIVILEGES MAY BE CANCELLED AND YOU MAY HAVE TO REAPPLY FOR MEMBERSHIP AT THE PRICES WE ARE THEN CHARGING NEW MEMBERS OR PAY A REINSTATEMENT FEE, IF AVAILABLE. MEMBER HEREBY GRANTS TO BURBANK ATHLETIC CLUB THE RIGHT TO CHARGE MEMBER'S BANK ACCOUNT AND/OR ANY CREDIT CARD INCLUDING, BUT WITHOUT LIMITATION, VISA, MASTERCARD, AMERICAN EXPRESS OR DISCOVER, FOR ALL SERVICE FEES AND/OR ANY BALANCE OWED OF MEMBERSHIP AGREEMENT, NON-SUFFICIENT FUND CHECKS AND/OR DIRECT CHARGE MEMO RETURNED UNPAID BY MEMBER'S BANK OR CREDIT CARD COMPANY. IN ADDITION TO THE OTHER DUES, FEES, AND CHARGES PROVIDED FOR IN THIS AGREEMENT, MEMBER AGREES TO PAY BURBANK ATHLETIC CLUB A SCHEDULED SERVICE FEE THEN IN EFFECT FOR ANY ITEM OR DIRECT CHARGE MEMO NOT PAID FOR BY MEMBER'S BANK OR CREDIT CARD COMPANY WHEN PRESENTED FOR PAYMENT BY BURBANK ATHLETIC CLUB. BURBANK ATHLETIC CLUB REPORTS PAYMENT HISTORY RECORDS TO SEVERAL NATIONAL CREDIT BUREAUS. 10. INCREASES: A. TERM AGREEMENTS: WITH THE EXCEPTION OF MEMBERSHIP CONTRACTS WITH RATE GUARANTEE FEES  MONTHLY DUES MAY BE INCREASED ON THE SECOND ANNIVERSARY DATE OF THIS CONTRACT AND EACH SUCCEEDING ANNIVERSARY DATE BY 15% OR THE INCREASE FROM YEAR TO YEAR IN THE CONSUMER PRICE INDEX IN EFFECT ON EACH ANNIVERSARY DATE, WHICHEVER IS GREATEST, PLUS ANY APPLICABLE TAXES. FOR PURPOSES OF CALCULATING MONTHLY DUES INCREASES, \"CONSUMER PRICE INDEX\" MEANS THE CONSUMER PRICE INDEX - ALL URBAN CONSUMERS ALL ITEMS, U.S. CITY AVERAGE (1982 - 84 - 100) PUBLISHED BY THE BUREAU OF LABOR STATISTICS OF THE U.S. DEPARTMENT OF LABOR OR, IF NOT PUBLISHED, A SUBSTITUTE INDEX SELECTED BY US AND PREPARED BY AN APPROPRIATE ENTITY. THE CPI LIMITATION TO THE INCREASE IN MONTHLY DUES APPLIES ONLY TO AGREEMENTS WITH A SPECIFIED \"TERM\". FOR PAID IN FULL MEMBERSHIPS: RENEWAL FEES ARE SUBJECT TO CHANGE IF NOT GUARANTEED BY PRESENT CONTRACT OR IF PRESENT MEMBERSHIP IS NOT RENEWED WITHIN 30 DAYS OF EXPIRATION DATE. B. OPEN-END AGREEMENTS: THIS SECTION APPLIES TO AGREEMENTS THAT DO NOT HAVE A SPECIFIED \"TERM\" OR ARE CONVERTED TO AN OPEN-END AGREEMENT UPON EXPIRATION OF THE TERM. TO COVER OUR INCREASING COSTS IN PROVIDING SERVICES, MONTHLY DUES MAY BE INCREASED ACCORDING TO OUR CURRENT PRICES. NOTICE OF SAID INCREASE SHALL BE POSTED ON THE PREMISES NO LESS THAN (30) THIRTY DAYS BEFORE DATE OF INCREASE. C. COUPON STATUS: A $10 MONTHLY SERVICE FEE WILL BE CHARGED ON ACCOUNTS CONVERTED TO COUPON STATUS.
                    BURBANK ATHLETIC CLUB RECOMMENDS THAT ALL MONTHLY MEMBERS ALLOW PAYMENTS TO GO THROUGH ELECTRONICALLY. BURBANK ATHLETIC CLUB DOES NOT RECOMMEND MEMBERS TO MAKE ANY PAYMENTS AT THE GYM. BURBANK ATHLETIC CLUB WILL NOT BE RESPONSIBLE FOR ERRORS MADE DUE TO PAYMENTS MADE IN HOUSE. IF PAYMENTS MUST BE MADE IN HOUSE, THEY MUST BE DONE BY THE 1ST OF THAT MONTH. BURBANK ATHLETIC CLUB WILL ACCESS A $35.00 FEE FOR ALL REJECTED CREDIT CARD AND/OR BANK ACCOUNT DEBITS. MEMBERSHIP MAY NOT BE PAID MORE THEN 30 DAYS IN ADVANCE. CREDIT CARD AND BANK ACCOUNT CHANGES ARE THE SOLE RESPONSIBILITY OF THE MEMBER TO UPDATE THEIR MEMBERSHIP BILLING INFORMATION SO THAT MONTHLY BILLS ARE NOT LATE. MEMBERSHIP FREEZE WILL BE BILLED AT $10.00 FEE PER MONTH.
                     PAID IN FULL MEMBERSHIPS ARE ELGIBLE FOR RENEWAL UNDER THE TERMS OF THIS CONTRACT WITHIN 30 DAYS UPON THE EXPIRATION OF TERMS OF SERVICE. I ACKNOWLEDGE THAT IN THE EVENT MY MEMBERSHIP CARD IS LOST, STOLEN, OR DESTROYED I AGREE TO PAY A MEMBERSHIP CARD REPLACEMENT FEE OF $10.00 IN ORDER TO BE ISSUED A REPLACEMENT CARD. YOU, THE BUYER, MAY CANCEL THIS AGREEMENT AT ANY TIME PRIOR TO MIDNIGHT OF THE 5  BUSINESS
                    DAY AFTER THE DATE OF THIS AGREEMENT, EXCLUDING SUNDAYS AND HOLIDAYS.
                    
                    <h4>Liability Terms</h4>
                    IN NO EVENT SHALL BURBANK ATHLETIC CLUB BE LIABLE FOR ANY SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES.In consideration of gaining membership and/or being allowed to participate in the activities and programs of Burbank Athletic Club and to use its facilities, machinery, in addition to the payment of any fee or charge, Member does hereby waive, release, and forever discharge Burbank Athletic Club and its officers, agents, employees, representatives, executors, and assigns, and all others from any and
                    all responsibilities and liability for injuries or damages resulting from Members participation in any activities or Members use of equipment or machinery in Burbank Athletic Club facilities or arisingout of Members participation in any activities at Burbank Athletic Club facilities. Member does also hereby release all of those mentioned and any others acting on their behalf or in any way arising out of or connected with Members participation in any activities of Burbank Athletic Club or the use of any equipment or machinery at Burbank Athletic Club. Member understands and is aware that strength,
                    flexibility, and aerobic exercise, including the use of equipment, is a potentially hazardous activity. Member also understands that fitness activities involve a risk of injury. Member does hereby further declare Member and Members family members, to be physically sound and suffering from no condition, impairment, disease, infirmity, or other illness that would prevent Members participation, or family members participation, in any of the activities and programs of Burbank Athletic Club or the use of equipment or machinery except as hereinafter stated. Member acknowledges that Member and Members family members have either had a physical examination and have been given Members and Members family members, physicians permission to participate, or that Member has decided to participate in activity and/or use of Burbank Athletic Club equipment and machinery without the approval of Members physician and does hereby assume all responsibility for Members and Members family members, participation and activities, and use of equipment and machinery in the Burbank Athletic Club.I acknowledge that I have carefully read this waiver and fully understand that it is a release of liability.  I am waiving any rights that I may have to bring any legal action to assert a claim and I further agree to assume all the risk of damage, loss or theft to or of any personal property. 
                    
                    
                    </p>
                    </div>
                    
                    <div id=\"monthlyHeader\">
                    <span class=\"subHeader\">MONTHLY TRANSACTION REQUEST:</span>
                    </div>
                    <div id=\"underline4\"></div>
                    <div id=\"billingRequest\"> <p>I authorize my credit card company to make a payment of <span class=\"boldLine\">$10.00</span> and charge it to my account on or close to day <span class=\"boldLine\">25</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">$3.00</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">$10.00</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">6</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p> <p>I acknowledge that a bi-annual rate guarantee fee of <span class=\"boldLine\">$19.00</span> will be charged to each member for the purpose of maintaining a discounted membership rate. I acknowledge that this fee will be collected on <span class=\"boldLine\">July 15th</span> and <span class=\"boldLine\">January 15th</span> of this year and on <span class=\"boldLine\">July 15th</span> and <span class=\"boldLine\">January 15th</span> of each year thereafter. If there is no year provided the rate guarantee fee will be automatically drafted on the following year on the same dates.</p>   <p class=\"collect\">The first payment of <span class=\"boldLine\">$10.00</span> shall be collected on <span class=\"boldLine\">May 25, 2015</span> for the month of <span class=\"boldLine\">June 2015</span>.</p> <p>Cancellation: I understand that I am in full control of my payment in accordance with this service agreement,and if at any time, after the 5 day cancellation procedure above, I decide to discontinue, I will simply notify BURBANK ATHLETIC CLUB , in writing by no later than 10th of the desired month of cancellation. (This provision does not apply to a Paid In Full Service Agreement or Open Ended Service Aggreement) Notification after the 10th of the desired month will require an additional1 month fees. Not applicable to any cancellation fees otherwise due. To cancel, I will include a legible copy of agreement or cancellation form, ORIGINAL MEMBERSHIP CARD and $0.00 cancellation fee. Such notice shall be sent to BURBANK ATHLETIC CLUB, P.O. Box 10997, Burbank, California 91510-0997. Any variations from the cancellation procedure may result in a delay in processing cancellation.</p> <p class=\"line\"></p> </div>
                    
                    <div id=\"signUp\">
                      <p>Executed at BURBANK ATHLETIC CLUB P.O. Box 10997, Burbank, California 91510-0997 on $start_date</p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <div id=\"signature\">
                    Website
                    </div>
                    
                    <div id=\"empsignature\">
                    <span class=\"signatures\"><b>Website</b></span>
                    </div>
                    
                    
                    <div id=\"signLine1\"><span class=\"signatures\">CONTRACTOR HOLDER SIGNATURE</span></div>
                    
                    <div id=\"signLine2\"><span class=\"signatures\">CLUB REPRESENTATIVE</span></div>
                    </div>
                    
                    </div>
                    </body>
                    </html>";
//}


echo $contractHtml;

//load the directory path since this is subject to change with each client
$directoryPath = $_SERVER['DOCUMENT_ROOT'];
$directoryArray = explode("/",$directoryPath);
$domainDir = $directoryArray[6];

array_map('unlink', glob("/var/www/vhosts/ems/$domainDir/admin/earlyrenewal/*.pdf"));

$fileName = "$contractKey.pdf";
$invoiceSalt = rand(1000, 9000);
$tempFile = "testFile$invoiceSalt.html";
$contentFile = "/var/www/vhosts/ems/$domainDir/admin/earlyrenewal/$tempFile";

file_put_contents($contentFile, $contractHtml);

exec("/usr/local/bin/wkhtmltopdf  -s Letter --outline -T 0 -B 0 -R 0 -L 0 $contentFile /var/www/vhosts/ems/$domainDir/admin/earlyrenewal/$fileName");

unlink("$contentFile");

//rename the file so it is more legible for download
$newFileName = "ck$contractKey.pdf";

rename("/var/www/vhosts/ems/$domainDir/admin/earlyrenewal/$fileName", "/var/www/vhosts/ems/$domainDir/admin/earlyrenewal/$newFileName");
?>