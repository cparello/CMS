<?php


$marker = $_REQUEST['marker'];
$location = $_REQUEST['location'];
$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];
$email = $_REQUEST['email'];

if($marker == 1)  {

$location = trim($location);
//echo $location;
//exit;
 switch($location) {          
      case"media":
      $location_name = "Media Center";
      $email_to = 'info@burbankathleticclub.com';
      break;
      case"north":
      $location_name = "North Location";
      $email_to = 'info2@burbankathleticclub.com';
      break;
      default:
      $location_name = "North Location";
      $email_to = 'info2@burbankathleticclub.com';
      break;
      
      }




 mail("$email_to", "Sales Lead $location",
"Name:       $name
            
Phone:      $phone

Email:      $email

Location:   $location_name
              
Email:        $email_to", "FROM:  sales@burbankathleticclub.com");
                
$name =   strtoupper($name);
$name = trim($name);

$print_pass_two = <<<PRINTPASS
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
        "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css" media="all">

body {
background-image: url('images/back_grad1.jpg');
background-repeat: repeat y;
text-align: center;
}


.coupon {
position: relative; 
width: 300px;
height:300px;
border-style:solid;
border-width:2px;
margin-top:0px; 
margin-left: auto; 
margin-right: auto;
top:  43px;
}

.oBox {
position: absolute;
top: 0px;
left: 0px;
width: 300px;
height: 30px;
background-color: #42371B;
}

.oBox2 {
position: relative;
top: 60px;
left: 0px;
width: 250px;
height: 275px;
margin-top:0px; 
margin-left: auto; 
margin-right: auto;
}

.oBtext  {
position: relative;
top: 8px;
text-align: left;
padding-left: 10px;
font-size: 9pt;
font-weight: 300;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #FFFFFF;
}

.posit {
top: 30px;
text-align: center;
padding-left: 20px;
padding-right: 20px;
line-height:150%;
font-size: 11pt;
font-weight: 300;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #FFFFFF;
}

input{
background: #FFFFFF;
border: 1px solid #616163;
}


.formtxt1 {
padding-top: 40px;
text-align: left;
padding-left: 10px;
font-size: 8pt;
font-weight: 200;
font-style: normal;
letter-spacing: 1px;
font-family: "Arial","Helvetica","Times",serif;
color: #000000;
}

.formtxt2 {
padding-top: 1px;
text-align: left;
padding-left: 10px;
font-size: 8pt;
font-weight: 200;
font-style: normal;
letter-spacing: 1px;
font-family: "Arial","Helvetica","Times",serif;
color: #000000;
}

.formtxt3 {
padding-top: 10px;
text-align: left;
padding-left: 10px;
font-size: 8pt;
font-weight: 200;
font-style: normal;
letter-spacing: 1px;
font-family: "Arial","Helvetica","Times",serif;
color: #000000;
}

.valid {
text-align: left;
font-size: 10pt;
font-weight: 300;
font-style: normal;
font-family: "Arial","Helvetica","Times",serif;
color: #ffffff;
}

</style>
<!--[if lt IE 7]>
<script language="JavaScript">
function correctPNG() // correctly handle PNG transparency in Win IE 5.5 & 6.
{
   var arVersion = navigator.appVersion.split("MSIE")
   var version = parseFloat(arVersion[1])
   if ((version >= 5.5) && (document.body.filters)) 
   {
      for(var i=0; i<document.images.length; i++)
      {
         var img = document.images[i]
         var imgName = img.src.toUpperCase()
         if (imgName.substring(imgName.length-3, imgName.length) == "PNG")
         {
            var imgID = (img.id) ? "id='" + img.id + "' " : ""
            var imgClass = (img.className) ? "class='" + img.className + "' " : ""
            var imgTitle = (img.title) ? "title='" + img.title + "' " : "title='" + img.alt + "' "
            var imgStyle = "display:inline-block;" + img.style.cssText 
            if (img.align == "left") imgStyle = "float:left;" + imgStyle
            if (img.align == "right") imgStyle = "float:right;" + imgStyle
            if (img.parentElement.href) imgStyle = "cursor:hand;" + imgStyle
            var strNewHTML = "<span " + imgID + imgClass + imgTitle
            + " style=\"" + "width:" + img.width + "px; height:" + img.height + "px;" + imgStyle + ";"
            + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"
            + "(src=\'" + img.src + "\', sizingMethod='scale');\"></span>" 
            img.outerHTML = strNewHTML
            i = i-1
         }
      }
   }    
}
window.attachEvent("onload", correctPNG);
</script>
<![endif]-->



<head>
	<title>Get Discount Rate</title>
</head>
<body>

<div id="coupon" class="coupon">
<div id="oBox" class="oBox">
<div id="oBtext" class="oBtext">
<center>THANK YOU $name</center>
<p class="posit">
<br>
Your information has been received.
 A staff member will contact you within 24 hours.
 </p>
 <p class="posit">
 <br>
 <center>
 <form>
</form> 
 </center>
 
</div>
</div>
</div>
</body>
</html>
PRINTPASS;

echo"$print_pass_two";
exit;

}

?>