function setClassValues(theValue, ref)  {

if(ref == 18 || ref == 19)  {
theValue = theValue.substr(1); 
//alert(theValue);
}

//alert(ref+' fu '+theValue);

//-------------------------------------------------------------
//set up ajax call to parse the values	 
//get ajax request object
function GetXmlHttpObject() {
var xmlHttp=null;
try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//-------------------------------------------------------
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="setBannerValues.php";
url=url+"?the_value="+theValue;
url=url+"&ref_num="+ref;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var content2 = xmlHttp.responseText;
}

}

}//end function



// submit the form
function submitForm(buttonVal) {
    
var headerTop = document.getElementById('headerTop1').value;
var headerLeft = document.getElementById('headerTop2').value;
var headerRight = document.getElementById('headerTop3').value;
var headerFont = document.getElementById('header_font_temp').value;
var headerSpace = document.getElementById('headerSpace').value;
var headerSize = document.getElementById('headerSize').value;
var headerStrength = document.getElementById('headerStrength').value;
var headerColor = document.getElementById('header_color_temp').value;
var banner =  document.getElementById('banSkin');

var header = document.getElementById('header').value;
var content = document.getElementById('content').value;
var name = document.getElementById('name').value;
var link = document.getElementById('link').value;
var textTop = document.getElementById('textTop1').value;
var textLeft = document.getElementById('textTop2').value;
var textRight = document.getElementById('textTop3').value;
var textFont = document.getElementById('text_font_temp').value;

var textSpace = document.getElementById('textSpace').value;
var textSize = document.getElementById('textSize').value;
var textStrength = document.getElementById('textStrength').value;
var textColor = document.getElementById('text_color_temp').value;

var header = document.getElementById('header').value;
var content = document.getElementById('content').value;
var name = document.getElementById('name').value;
var link = document.getElementById('link').value;

//alert(headerTop+'dfdf');
if(header == "") {  
            alert('Please enter a value into the header box.');
            document.getElementById('header').value ="";
            document.form1.header.focus();
            return false;
           }
if(content == "") {  
            alert('Please enter a value into the name box');
            //document.getElementsByName('One').value ="";
            //document.form1.headerTop1.focus();
            return false;
           }
if(name == "") {  
            alert('Please enter a value into the name box');
            document.getElementById('name').value ="";
            document.form1.name.focus();
            return false;
           }
if(link == "") {  
            alert('Please enter a value into the link box');
            document.getElementById('link').value ="";
            document.form1.link.focus();
            return false;
           }
           
           
if(banner == "") {  
            alert('Please click the banner image on the top to select a background image.');
            document.getElementById('banSkin').value ="";
            document.form1.banSkin.focus();
            return false;
           }
if(textColor == "") {  
            alert('Please select a color for the context text on the right');
            //document.getElementsByName('One').value ="";
            //document.form1.headerTop1.focus();
            return false;
           }
if(textSpace == "") {  
            alert('Please enter a value into the text Space box');
            document.getElementById('textSpace').value ="";
            document.form1.textSpace.focus();
            return false;
           }
if(textSize == "") {  
            alert('Please enter a value into the text Size box');
            document.getElementById('textSize').value ="";
            document.form1.textSize.focus();
            return false;
           }
if(textStrength == "") {  
            alert('Please enter a value into the text Strength box');
            document.getElementById('textStrength').value ="";
            document.form1.textStrength.focus();
            return false;
           }
if(textFont == "") {  
            alert('Please choose a font on the right for the context.');
            //document.getElementById('banSkin').value ="";
            //document.form1.banSkin.focus();
            return false;
           }
if(textTop == "") {  
            alert('Please enter a value into the text Top box');
            document.getElementById('textTop1').value ="";
            document.form1.textTop1.focus();
            return false;
           }

if(textLeft == "") {  
            alert('Please enter a value into the text Left box');
            document.getElementById('textTop2').value ="";
            document.form1.textTop2.focus();
            return false;
           }
if(textRight == "") {  
            alert('Please enter a value into the text Right box');
            document.getElementById('textTop3').value ="";
            document.form1.textTop3.focus();
            return false;
           }
if(headerTop == "") {  
            alert('Please enter a value into the Header Top box');
            document.getElementById('headerTop1').value ="";
            document.form1.headerTop1.focus();
            return false;
           }

if(headerLeft == "") {  
            alert('Please enter a value into the Header Left box');
            document.getElementById('headerTop2').value ="";
            document.form1.headerTop2.focus();
            return false;
           }
if(headerRight == "") {  
            alert('Please enter a value into the Header Right box');
            document.getElementById('headerTop3').value ="";
            document.form1.headerTop3.focus();
            return false;
           }
if(headerFont == "") {  
            alert('Please enter a value into the Header Font box');
            document.getElementById('radio').value ="";
            document.form1.radio.focus();
            return false;
           }
if(headerSpace == "") {  
            alert('Please enter a value into the Header Space box');
            document.getElementById('headerSpace').value ="";
            document.form1.headerSpace.focus();
            return false;
           }
if(headerSize == "") {  
            alert('Please enter a value into the Header Size box');
            document.getElementById('headerSize').value ="";
            document.form1.headerSize.focus();
            return false;
           }
if(headerStrength == "") {  
            alert('Please enter a value into the Header Strength box');
            document.getElementById('headerStrength').value ="";
            document.form1.headerStrength.focus();
            return false;
           }
if(headerColor == "") {  
            alert('Please select a color for the header text');
            //document.getElementsByName('One').value ="";
            //document.form1.headerTop1.focus();
            return false;
           }
           
document.getElementById('buthold').value = buttonVal;
//alert(buttonVal);
document.form1.submit();
}


