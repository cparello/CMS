<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$monthly_header = $_REQUEST['monthly_header'];
$monthly_txt = $_REQUEST['monthly_txt'];
$past_due_header = $_REQUEST['past_due_header'];
$past_due_txt = $_REQUEST['past_due_txt'];
$pd = $_REQUEST['pd'];
$pd_frequency = $_REQUEST['pd_frequency'];
$rejected_declined_header = $_REQUEST['rejected_declined_header'];
$rejected_declined_txt = $_REQUEST['rejected_declined_txt'];
$rj = $_REQUEST['rj'];
$rj_frequency = $_REQUEST['rj_frequency'];
$final_header = $_REQUEST['final_header'];
$final_txt = $_REQUEST['final_txt'];


include "invoiceSql.php";

if($marker == 1) {

$updateInvoice = new invoiceSql();
$updateInvoice-> setMonthlyHeader($monthly_header);
$updateInvoice-> setMonthlyTxt($monthly_txt);
$updateInvoice-> setPastDueHeader($past_due_header);
$updateInvoice-> setPastDueTxt($past_due_txt);
$updateInvoice-> setPastDueAttempts($pd);
$updateInvoice-> setPastDueFrequency($pd_frequency);
$updateInvoice-> setRejectedDelinedHeader($rejected_declined_header);
$updateInvoice-> setRejectedDeclinedTxt($rejected_declined_txt);
$updateInvoice-> setRejectedDeclinedAttempts($rj);
$updateInvoice-> setRejectedDeclinedFrequency($rj_frequency);
$updateInvoice-> setFinalHeader($final_header);
$updateInvoice-> setFinalTxt($final_txt);
$updateInvoice-> upadateInvoiceOptions();

$confirmation = 'onLoad="confirmUpdate();"';

}


$loadInvoice = new invoiceSql();
$loadInvoice-> loadInvoiceOptions();
$monthly_header = $loadInvoice-> getMonthlyHeader();
$monthly_txt = $loadInvoice-> getMonthlyTxt();
$past_due_header = $loadInvoice-> getPastDueHeader();
$past_due_txt = $loadInvoice-> getPastDueTxt();
$past_due_attempts = $loadInvoice-> getPastDueAttempts();
$past_due_radio_name = 'pd';
$past_due_frequency = $loadInvoice->getPastDueFrequency();
$rejected_declined_header = $loadInvoice-> getRejectedDeclinedHeader();
$rejected_declined_txt = $loadInvoice-> getRejectedDeclinedTxt();
$rejected_declined_attempts = $loadInvoice-> getRejectedDeclinedAttempts();
$rejected_declined_name = 'rj';
$rejected_declined_frequency = $loadInvoice-> getRejectedDeclinedFrequency();
$final_header = $loadInvoice-> getFinalHeader();
$final_txt = $loadInvoice-> getFinalTxt();

$final_txt = trim($final_txt);
$monthly_txt = trim($monthly_txt);
$past_due_txt = trim($past_due_txt);
$rejected_declined_txt = trim($rejected_declined_txt);

//here we set up the frequency drop downs
include "frequencyDrops.php";
include "attemptRadios.php";

//sets up the radio buttons
$pastAttempts = new attemptRadios();
$pastAttempts-> setAttempts($past_due_attempts);
$pastAttempts-> setRadioName($past_due_radio_name);
$past_due_radios = $pastAttempts-> loadAttemptRadios();

$rejectedAttempts = new attemptRadios();
$rejectedAttempts-> setAttempts($rejected_declined_attempts);
$rejectedAttempts-> setRadioName($rejected_declined_name);
$rejected_declined_radios = $rejectedAttempts-> loadAttemptRadios();


//sets up the drop downs
$pastDrops = new frequencyDrops();
$pastDrops -> setFrequency($past_due_frequency);
$past_drop_menu = $pastDrops -> loadFrequencyMenu();

$rejectDeclinedDrops = new frequencyDrops();
$rejectDeclinedDrops-> setFrequency($rejected_declined_frequency);
$reject_declined_drop_menu = $rejectDeclinedDrops-> loadFrequencyMenu();


//print out the search form
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(32);
$info_text = $getText -> createTextInfo();
$javaScript1="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtInvoices.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editInvoices.js\"></script>";


include "../templates/infoTemplate2.php";
include "../templates/editInvoicesTemplate.php";



?>