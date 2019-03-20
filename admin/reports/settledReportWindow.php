<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}



$report_name = $_SESSION['report_name'];
$from_date = $_SESSION['from_date'];
$to_date = $_SESSION['to_date'];
$transaction_name = $_SESSION['transaction_type'];
$summary_rows = $_SESSION['summary_rows'];
$print_chart = $_SESSION['print_chart'];


unset($_SESSION['report_name']);
unset($_SESSION['from_date']);
unset($_SESSION['to_date']);
unset($_SESSION['transaction_type']);
unset($_SESSION['summary_rows']);
unset($_SESSION['print_chart']);



if($from_date == "first") {
   $from_date = date("m/d/Y", mktime(0,0,0,1,1,date('Y')));
  }
  
if($to_date == "today") {
   $to_date = date("m/d/Y");
  }

//--------------------------------------------------------------------------------
//connect to database

require"../dbConnect.php";
$stmt = $dbMain ->prepare("SELECT business_nick,  business_street, business_city, business_state, business_zip, business_phone FROM  business_info WHERE bus_id = '1' ");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($business_nick,  $business_street, $business_city, $business_state, $business_zip, $business_phone);
$stmt->fetch();


$printReportTemplate = <<<PRINTREPORTTEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<link rel="stylesheet" href="../css/printReport.css">
<script type="text/javascript" src="../scripts/printPage.js"></script>
<script type="text/javascript" src="../scripts/jqueryNew.js"></script>
<script type="text/javascript" src="../scripts/showRenewRange.js"></script>
<script type="text/javascript" src="../scripts/json2.js"></script>
<script type="text/javascript" src="../scripts/swfobject.js"></script>


<script>
function openFlashChart2() {

swfobject.embedSWF("open-flash-chart.swf", idVar,chartWidth,chartHeight, "9.0.0", "expressInstall.swf",{"get-data":"get_data_2"},{"wmode":"transparent"});
}


function get_data_2()  {
return JSON.stringify(data1);
}


$(document).ready(function() {

this.idVar = "";
this.data1 = "";
this.dataOne= "";
this.dataTwo= "";
this.dataThree = "";
this.dataFour = "";
this.chartWidth = "";
this.chartHeight = "";
this.chartCount = "";
//this.barArray = "";
//this.lineArray = "";
//-----------------------------------------------------------------


//var barArray = $("#bar_charts").val();
var barArray = '$print_chart';

//alert(barArray);

       var dataArray = barArray.split('|');
             chartCount = dataArray[0];
             
                                  
             switch(chartCount) {
                   case "1":
                   dataOne = dataArray[1];
                   dataOne = $.parseJSON(dataOne);                   
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "800";
                   chartHeight = "175";
                   openFlashChart2();                                                                                        
                   break;      
                   
                   case "2":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break; 
                   
                   case "3":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break;                        
                    
                    case "4":
                    dataOne = dataArray[1];
                    dataTwo = dataArray[2];
                    dataThree = dataArray[3];
                    dataFour = dataArray[4]; 
                    
                    dataOne = $.parseJSON(dataOne);
                    data1 = dataOne;                                
                    idVar = "chart_one";
                    chartWidth = "200";
                    chartHeight = "178";
                    openFlashChart2();                                              
       
                    setTimeout(function() { loadSecond2(); }, 500);
                                               
                    function loadSecond2() { 
                            dataTwo = $.parseJSON(dataTwo);
                            data1 = dataTwo;
                            idVar = "chart_two";
                            chartWidth = "150";
                            chartHeight = "175";
                            openFlashChart2();
                           }        
             
                    setTimeout(function() { loadThird2(); }, 1100);        
             
                     function loadThird2() {           
                             dataThree = $.parseJSON(dataThree);
                             data1 = dataThree;
                             idVar = "chart_three";
                             chartWidth = "140";
                             chartHeight = "175";
                             openFlashChart2();                                
                            }                               

                     setTimeout(function() { loadFourth2(); }, 1700);        
             
                       function loadFourth2() {           
                               dataFour = $.parseJSON(dataFour);
                               data1 = dataFour;
                               idVar = "chart_four";
                               chartWidth = "300";
                               chartHeight = "175";
                               openFlashChart2();                                
                              }                                                                                               
                      break;    
                     }



//-------------------------------------------------------------------------------------------
});
</script>


<title>Sales Report</title>

</head>
<body>

<div id="logoDiv">
<a href="javascript: void(0)" onClick="printPage()"><img src="../images/contract_logo.png"  /></a>
</div>


<div id="addressDiv" class="black4">
$business_nick
<br>
$business_street
<br>
$business_city, $business_state $business_zip
<br>
$business_phone  
</div>

<div id="reportName"> 
<span class="black5">Name of Report:</span>
&nbsp;
<span class="black6">$report_name</span>
</div>


<div id="searchParams">
<span class="black5 padSix">Search Parameters</span>
</div>


<div id="paramList"> 
<table cellpadding="2">
<tr>
<td class="black7">
1.
</td>
<td class="black7">
Transaction Type
</td>
<td class="black6 padSeven">
$transaction_name
</td>
</tr>


<tr>
<td class="black7">
3.
</td>
<td class="black7">
Date Range
</td>
<td class="black6 padSeven" id="rangeCount">
$from_date  &nbsp; TO &nbsp; $to_date 
</td>
</tr>
</table>
</div>

<div id="graphs">
<span class="black5 padSix">Graphs</span>
</div>


<div id="graphHouse">
<div id="chart_one"></div>
<div id="chart_two"></div>
<div id="chart_three"></div>
<div id="chart_four"></div>
</div>


<div id="summary">
<span class="black5 padSix">Summary</span>
<table id="projTable" align="left" cellpadding="2" cellspacing="0" border="0" width="100%"> 
<tr>
<td class="projHeader pSpace1">
Period
</td>
<td class="projHeader pSpace2">
Total Transactions
</td>
<td class="projHeader pSpace4">
Total Amount
</td>
<td class="projHeader">
Projected Amount
</td>
</tr>
$summary_rows
</table>



</div>







</body>
</html>
PRINTREPORTTEMPLATE;


echo"$printReportTemplate";

?>























