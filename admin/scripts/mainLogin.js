function send_id()  {

var txt=document.getElementById("idContent1");
var id1 = document.form1.username.value;
var id2 = document.form1.username;
var id3 = document.form1.password.value;
var id4 = document.form1.password;
var x = id1;
var y = id3;
id1 = (x.replace(/^\W+/,'')).replace(/\W+$/,'');
id3 = (y.replace(/^\W+/,'')).replace(/\W+$/,'');

        
// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=id1.indexOf(at);
var lstr=id1.length;
var ldot=id1.indexOf(dot);

        if(id1 == "")  {
          txt.innerHTML= '<p class="errors">Please supply your user name</p>';
          id2.focus();                          
          return false;
        }
        
		if(id1.indexOf(at)==-1){
		   //alert("You have entered an invalid email address");
		    txt.innerHTML= '<p class="errors">You have entered an invalid username</p>';
           id2.focus();
		   return false;
		}

		if(id1.indexOf(at)==-1 || id1.indexOf(at)==0 || id1.indexOf(at)==lstr){
		   //alert("You have entered an invalid email address");
		   txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
           id2.focus();
		   return false;
		}

		if(id1.indexOf(dot)==-1 || id1.indexOf(dot)==0 || id1.indexOf(dot)==lstr){
		   txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
           id2.focus();
		    return false;
		}

		 if(id1.indexOf(at,(lat+1))!=-1){
		    txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
            id2.focus();
		    return false;
		 }

		 if(id1.substring(lat-1,lat)==dot || id1.substring(lat+1,lat+2)==dot){
		    txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
            id2.focus();
		    return false;
		 }

		 if(id1.indexOf(dot,(lat+2))==-1){
		    txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
            id2.focus();
		    return false;
		 }
		
		 if(id1.indexOf(" ")!=-1){
		    txt.innerHTML= '<p class="errors">You have entered an invalid user name</p>';
            id2.focus();
		    return false;		 
         }
        

//this checks the validity of the password.       
          if(id3 == "")  {
           txt.innerHTML= '<p class="errors">Please supply your password</p>';
           id4.focus();                          
           return false;
         }  
        
        if(id3.length < 6)  {
           txt.innerHTML= '<p class="errors">Your Password is too short</p>';
           id4.focus();                          
           return false;        
        }
             
         if(id3.length > 10)  {
           txt.innerHTML= '<p class="errors">Your Password is too long</p>';
           id4.focus();                          
           return false;        
        }
        
     
//This contains A to Z , 0 to 9 and A to B
var regexNum = /\d/;
var regexLetter = /[a-zA-z]/;
if(!regexNum.test(id3) || !regexLetter.test(id3)){
txt.innerHTML= '<p class="errors">You have entered an Invalid Password</p>';
id4.focus();
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
var url="logCheck.php";
url=url+"?user="+id1;
url=url+"&pass="+id3;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);



//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
var passStatus =  xmlHttp.responseText;


if(passStatus == 1) {
 txt.innerHTML= '<p class="errors">Your User Name or Password is invalid</p>';
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