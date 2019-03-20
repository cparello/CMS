function send_id()  {

var txt=document.getElementById("idContent1");
var id1 = document.form1.id_card.value;
var id2 = document.form1.id_card;

var x = id1;
id1 = (x.replace(/^\W+/,'')).replace(/\W+$/,'');


        
        if(id1 == "")  {
          txt.innerHTML= '<p class="errors">Please supply your Employee ID Number</p>';
          id2.focus();                          
          return false;
        }
        
     

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
var url="logCheckSales2.php";
url=url+"?id_card="+id1;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;
//alert(passStatus);

if(passStatus == 1) {
 txt.innerHTML= '<p class="errors">Your Employee ID is invalid</p>';
 id2.focus();                          
 return false;
}

if(passStatus == 2)  {
document.form1.submit();
}


//end of complete
} 

//end state change function
}

return false;     
     
     
     
     
     
//-------------------------------------------------------


}