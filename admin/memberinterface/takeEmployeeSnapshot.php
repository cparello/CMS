<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$user_id = $_REQUEST['user_id'];
$employee_name = $_REQUEST['employee_name'];

$user_id = urldecode($user_id);
$employee_name = urldecode($employee_name);


$agent = $_SERVER['HTTP_USER_AGENT'];

//Operation System
if(preg_match('/Linux/',$agent)) {
   $os = 'Linux';
   $sound_bite = 'true';
  }
  
  if(preg_match('/Win/',$agent)) {
   $os = 'Windows';
   $sound_bite = 'true';
  }
  
  if(preg_match('/Mac/',$agent)) {
   $os = 'Mac';
   $sound_bite = 'true';   
   }
   
   
$takeSnapShotTemplate = <<<TAKECAMERA

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>JPEGCam Test Page</title>
	<meta name="generator" content="TextMate http://macromates.com/">
	<meta name="author" content="Joseph Huckaby">
	<!-- Date: 2008-03-15 -->
	
<style>	
#wsfCam {	
height: 320px;
width: 240px;
outline: 1px solid #000000;
background-color: #CCCCCC;		
}	

#upload_results {	
height: 320px;
width: 240px;
outline: 1px solid #000000;
background-color: #CCCCCC;	
text-align: center;
font-size: 12pt;
font-weight: 500;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #000;
}	

.padTop {
padding-top: 15px;
}
	
.button {
border: 0px;
-moz-border-radius: 5px 5px 5px 5px;
border-radius: 5px 5px 5px 5px;
padding-top: 6px;
padding-bottom:  6px;
padding-right:  10px;
padding-left:  10px;
background: #6AC04E;
font-size: 10pt;
font-weight: 300;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #FFF
}	
	
.memberNumberHeader {
font-size: 11pt;
font-weight: 700;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #000000;
}

.memberNumber {
font-size: 11pt;
font-weight: 700;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #C33;
}	
</style>	


</head>
<body>
	<table>
    <tr>
	<td colspan="3">
	 <span class="memberNumberHeader">Employee Name:&nbsp;&nbsp;</span>
     <span class="memberNumber">$employee_name</span>
	</td>
	</tr>
	
	<tr>
	<td valign="top">
     <div id="wsfCam">
	
	<!-- First, include the JPEGCam JavaScript Library -->
	<script type="text/javascript" src="../scripts/webcam.js"></script>
	
	<!-- Configure a few settings -->
	<script language="JavaScript">
		webcam.set_api_url( 'testTwo.php?user_id=$user_id' );
		webcam.set_quality( 90 ); // JPEG quality (1 - 100)
		webcam.set_shutter_sound($sound_bite); // play shutter click sound
	</script>
	
	<!-- Next, write the movie to the page at 320x240 -->
	<script language="JavaScript">
		document.write( webcam.get_html(240, 320) );
	</script>
	
	
	<!-- Code to handle the server response (see test.php) -->
	<script language="JavaScript">
		webcam.set_hook( 'onComplete', 'my_completion_handler' );		
		function take_snapshot() {
			// take snapshot and upload to server
			document.getElementById('upload_results').innerHTML = '<br><br>Uploading Image<br><br>Please Wait...';
			webcam.snap();
		}
		
		function my_completion_handler(msg) {
			// extract URL out of PHP output
			    var unix = Math.round(+new Date()/1000);
				var image_url = (msg+ '?' +unix);
				// show JPEG image in page
				document.getElementById('upload_results').innerHTML =  '<img src="' + image_url + '">';
				
				webcam.reset();
		
		}
	</script>
	
	</div>
	</td>
	<td>
	&nbsp;&nbsp;
	</td>
	<td valign="top">
	<div id="upload_results"></div>
	</td>
	</tr>
	
	<tr>
	<td align="center" class="padTop">
	<form>
	<input type=button class="button" value="Configure Camera" onClick="webcam.configure()">
	</td>
	<td>
	&nbsp;&nbsp;
	</td>
	<td align="center" class="padTop">
    <input type=button class="button" value="Take Snapshot" onClick="take_snapshot()">
	</form>	
	</td>
	</tr>	
	</table>
	

</body>
</html>
TAKECAMERA;
echo"$takeSnapShotTemplate";
?>