function searchMembers(buttonId) {

var memberName = document.getElementById('search_name').value;
var contractId = document.getElementById('search_id').value;



try
  {

if(document.form1.contract_bit.value != "") {
  alert('WARNING!  This Contract has not been submitted. To submit this Contract please use the "Step 2 Submit Order" button below.  If you wish to cancel this order,  please use the "Cancel Contract" button at the bottom of this page to start over.');
  document.form1.cancel_contract.focus();
  return false; 
  }

  }
catch(err)
  {

  //return true;

  }







//make sure a form fields are filled out
if(memberName == "" && contractId == "")  {
  alert('Search fields cannot be blank. Please enter a value into at least one of these fields');
          document.getElementById(buttonId).focus();
          return false;
          }
if (isNaN(contractId)) {
    alert('Contract Id can only contain numbers');
            document.getElementById('search_id').focus();
            return false;
            }

//encode to send to server
memberName = encodeURIComponent(memberName);
contractId = encodeURIComponent(contractId); 

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
var url="searchMemberAccounts.php";
url=url+"?member_name="+memberName;
url=url+"&contract_id="+contractId;
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
                                         window.location = "accountList.php";           
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
