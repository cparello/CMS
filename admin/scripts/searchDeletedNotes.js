function searchMembers(buttonId) {

var contractKey = document.getElementById('search_key').value;
//alert(contractKey);
//check wiich submit button is selected            
switch(buttonId)  {
case 'contract_key':
         if(contractKey == "" )  {
            alert('Please enter a value into the Contract Key Field');
            document.getElementById('search_key').focus();
            return false;
          }
break;


}
       
 //make sure a form fields are filled out
if(contractKey == "")  {
  alert('Search fields cannot be blank. Please enter a value into at least one of these fields');
          document.getElementById(buttonId).focus();
          return false;
          }                       

//encode to send to server
contractKey = encodeURIComponent(contractKey); 
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
var url="../utilities/searchDeletedNotesTwo.php";
url=url+"?contract_key="+contractKey;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("GET",url,true);
xmlHttp.send(null);


//this function checks the state and then parses the response
function stateChanged() { 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
                    
                     var resultCount =  xmlHttp.responseText;
//alert(resultCount);
                            if(resultCount == 0)  {
                             alert('There are no records that match your query ');                        
                             return false;                            
                            }
                            
                            if(resultCount != 0)  {
                            var answer = confirm('There are currently ' +resultCount+ ' record(s) that match your query.  Do you wish to view these records?');
                            
                                   if(answer)   {           
                                         window.location = "searchDeletedNotes.php?marker=1";           
                                       }else{             
                                                 return false;    
                                       }                                                                                                                                            
                            }

                                        
//end of complete
} 

//end state change function
}


return false;    

}
