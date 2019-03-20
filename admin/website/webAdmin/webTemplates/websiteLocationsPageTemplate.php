<?php
include"../../dbConnect.php";


$counter = 1;
$stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id != '' ORDER BY club_name ASC");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($clubName); 
   while($stmt->fetch()){
                $stmt999 = $dbMain ->prepare("SELECT Lattitude, longitude, club_zip, amenities1, amenities2, amenities3, amenities4, amenities5, amenities6, amenities7, amenities8, hoursText1, hoursText2, clubText, guestPassLength FROM website_locations_setup WHERE club_name = '$clubName'");
               $stmt999->execute();      
               $stmt999->store_result();      
               $stmt999->bind_result($longitude, $lattitude, $zip, $ammenities1, $ammenities2, $ammenities3, $ammenities4, $ammenities5, $ammenities6, $ammenities7, $ammenities8, $hourTxt1, $hourTxt2, $clubText, $guestPassLength);
               $stmt999->fetch();
                $stmt999->close();
    
    $locationsHtml .= "
    <tr>
    <td>
    <center><h4>$clubName</h4></center>
    </td>
    </tr>
    
    <tr>
                            <td>
                            <center>Website Guest Pass Length:<input id=\"guestPassLength$counter\" type=\"text\" maxlength=\"100\" size=\"10\" value=\"$guestPassLength\" name=\"guestPassLength$counter\" tabindex=\"5\"></input><a href=\"javascript: void\" id=\"pos99\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos99', 99 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a></center> 
                            </td>
                            </tr>
    
                    <tr>
                            <td class=\"black\" width=\"225\">
                            <center><b>Club Longitude and Lattitude:</b></center>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <center>LAT:&nbsp;<input id=\"long$counter\" type=\"text\" maxlength=\"100\" size=\"15\" value=\"$longitude\" name=\"long$counter\" tabindex=\"5\"></input>&nbsp;Long:&nbsp;<input id=\"lat$counter\" type=\"text\" maxlength=\"100\" size=\"15\" value=\"$lattitude\" name=\"lat$counter\" tabindex=\"5\"></input><a href=\"javascript: void\" id=\"pos1\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos1', 1 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a> </center>
                            <input type=\"hidden\" name=\"clubName$counter\" value=\"$clubName\" />
                            </td>
                            </tr>
                            
                             <tr>
                            <td class=\"black\" width=\"225\">
                            <center><b>Club Zipcode:</b></center>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <center><input id=\"zip$counter\" type=\"text\" maxlength=\"100\" size=\"15\" value=\"$zip\" name=\"zip$counter\" tabindex=\"5\"></input><a href=\"javascript: void\" id=\"pos55\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos55', 55 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a> </center>
                            </td>
                            </tr>
                            
                            <td class=\"black\" width=\"225\">
                            <center><b>Club Text:</b></center>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <center><textarea class=\"notes\" name=\"clubText$counter\" rows=\"4\" cols=\"48\">$clubText</textarea><a href=\"javascript: void\" id=\"pos2\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos2', 2 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a> </center>
                            </td>
                            </tr>
                            
                            <tr>
                            <td class=\"black\" width=\"225\">
                            <center>Ammennities:<a href=\"javascript: void\" id=\"pos3\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos3', 3 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a></center> 
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <input id=\"ammensOne$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities1\" name=\"ammensOne$counter\" tabindex=\"5\"></input><input id=\"ammensTwo$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities2\" name=\"ammensTwo$counter\" tabindex=\"5\"></input><input id=\"ammensThree$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities3\" name=\"ammensThree$counter\" tabindex=\"5\"></input><input id=\"ammensFour$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities4\" name=\"ammensFour$counter\" tabindex=\"5\"></input>
                            </td>
                            </tr>
                            <tr>
                            <td>
                            <input id=\"ammensFive$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities5\" name=\"ammensFive$counter\" tabindex=\"5\"></input><input id=\"ammensSix$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities6\" name=\"ammensSix$counter\" tabindex=\"5\"></input><input id=\"ammensSeven$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities7\" name=\"ammensSeven$counter\" tabindex=\"5\"></input><input id=\"ammensEight$counter\" type=\"text\" maxlength=\"100\" size=\"45\" value=\"$ammenities8\" name=\"ammensEight$counter\" tabindex=\"5\"></input>
                            </td>
                            </tr>
                            
                            

                            
                            <tr>
                            <td class=\"black\" width=\"225\">
                            <center>Club Hours:</center>
                            </td>
                            </tr>
                            
                            <tr>
                            <td>
                            <center>Hours Text One:<input id=\"hourTxtOne$counter\" type=\"text\" maxlength=\"100\" size=\"40\" value=\"$hourTxt1\" name=\"hourTxtOne$counter\" tabindex=\"5\"></input><a href=\"javascript: void\" id=\"pos4\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos4', 4 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a></center> 
                            </td>
                            </tr>
                            <tr>
                            <td>
                            <center>Hours Text Two:<input id=\"hourTxtTwo$counter\" type=\"text\" maxlength=\"100\" size=\"40\" value=\"$hourTxt2\" name=\"hourTxtTwo$counter\" tabindex=\"5\"></input><a href=\"javascript: void\" id=\"pos5\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right',  -100, -50, 'pos5', 5 );\" /><img src=\"../../images/question-mark.png\" class=\"alignMiddle\"></a><center> 
                            </td>
                            </tr>";
                            $counter++;
                               }





$salesPayrollTemplate = <<<CYCLETEMPLATE
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html> 

<head>
<link rel="stylesheet" href="../../css/fees.css">
<link rel="stylesheet" href="../../css/pop_hint.css">
<link rel="stylesheet" href="../../css/info.css">
<style>
.button {
   border-top: 1px solid #bdbec0;
   background: #bdbec0;
   background: -webkit-gradient(linear, left top, left bottom, from(#bdbec0), to(#bdbec0));
   background: -webkit-linear-gradient(top, #bdbec0, #bdbec0);
   background: -moz-linear-gradient(top, #bdbec0, #bdbec0);
   background: -ms-linear-gradient(top, #bdbec0, #bdbec0);
   background: -o-linear-gradient(top, #bdbec0, #bdbec0);
   padding: 20px 40px;
   -webkit-border-radius: 0px;
   -moz-border-radius: 0px;
   border-radius: 0px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 24px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;
   }
.button:hover {
   border-top-color: #030303;
   background: #030303;
   color: #ffffff;
   }
.button:active {
   border-top-color: #8bc63f;
   background: #8bc63f;
   }
</style>
$javaScript1
$javaScript2
$javaScript3
<title>$page_title</title>

</head>
<body>

$infoTemplate

<div id="userHeader">
$page_title  
</div>

<div id="conf" class="conf">
$confirmation &nbsp;
</div>


<div id="userForm">
  <form id="form1" name="form1" method="post" action="$submit_link" onSubmit="return checkData()">

<table border="0" align="center" cellspacing="0" cellpadding="0">
<tr>
<td align="left" colspan="2" class="grey">
<center><u>Website Locations Page Setup</u>   </center> 
</td>
</tr>


                            

$locationsHtml


<tr>
<td  colspan="2" align="left">
<br>
<a class="more up bold" target="" title="$submit_title">
<center><button class="button" type="submit" value="login" name="Update">$submit_title</button></center>
</a>
<input type="hidden" name="marker" value="1" />
</form>
</td>
</tr>




<tr>
<td id="idContent1" colspan="2">   
</td>              
</tr>
</table>
</div>

<div class="popHint"   id="popup" style="display: none;">
<div class="menu_form_header" id="popup_drag">
<img class="menu_form_exit"   id="popup_exit" src="../../images/popx.png" alt="" />
<span id= "contHint">
</span>
</div>
</div>

  
</body>
</html>
CYCLETEMPLATE;


echo"$salesPayrollTemplate";

?>


