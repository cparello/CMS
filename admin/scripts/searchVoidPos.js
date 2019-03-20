function searchMembers(buttonId) {

var invoice = document.getElementById('search_invoice').value;
//alert(invoice);
//check wiich submit button is selected            
switch(buttonId)  {
case 'invoice':
         if(invoice == "" )  {
            alert('Please enter a value into the Invoice Field');
            document.getElementById('search_invoice').focus();
            return false;
          }
break;


}
       
 //make sure a form fields are filled out
if(invoice == "")  {
  alert('Search fields cannot be blank. Please enter a value into at least one of these fields');
          document.getElementById(buttonId).focus();
          return false;
          }                       

//encode to send to server
invoice = encodeURIComponent(invoice); 
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
var url="../billing/searchVoidPosTransactions.php";
url=url+"?invoice="+invoice;
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
                                         window.location = "searchVoidPos.php?marker=1";           
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
