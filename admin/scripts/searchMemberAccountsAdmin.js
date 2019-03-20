function searchMembers(buttonId) {

var searchBy = document.getElementById('search_by').value;
var searchName = document.getElementById('search_name').value;

var memberName;
var contractId;
var groupName; 
var ccNum;
var bank;
var memberName2;  
//var groupName = document.getElementById('search_group').value;
//var ccNum = document.getElementById('search_cc').value; 

//var bank = document.getElementById('search_bank').value;
//var memberName2 = document.getElementById('search_member').value; 
 //alert(searchBy);
 //alert(searchName);           
 if(searchName == "" )  {
            alert('Please enter a value into the Box');
            document.getElementById('search_name').focus();
            return false;
          }           
//check wiich submit button is selected            
switch(searchBy)  {
case '1':
            memberName = searchName;
            contractId = "";
            groupName = ""; 
            ccNum = "";
            bank  = "";
            memberName2 = ""; 
            //alert(memberName);     
break;

case '2':
        contractId = searchName;
        if(isNaN(contractId)) {
            alert('Contract Id can only contain numbers');
            document.getElementById('search_name').focus();
            return false;
          }
            memberName = "";
            groupName = "";  
            ccNum = "";     
            bank  = "";
            memberName2 = "";
           // alert(contractId);
                  
break;


case '3':
            groupName =searchName;
            contractId = "";
            memberName = ""; 
            ccNum = ""; 
            bank  = "";
            memberName2 = "";             
break;

case '4':
            ccNum = searchName;
            contractId = "";
            memberName = "";  
            groupName = ""; 
            bank  = "";
            memberName2 = "";        
                  
break;

case '5':
            memberName2 = searchName;
            contractId = "";
            memberName = "";  
            groupName = "";   
            bank  = "";
            memberName = "";         
             //alert(memberName2);         
break;

case '6':
            bank = searchName;
            contractId = "";
            memberName = "";  
            groupName = ""; 
             
            memberName = "";   
            memberName2 = ""; 
                   
break;
}
       
 //make sure a form fields are filled out
if(memberName == "" && contractId == ""  &&  groupName == ""  && ccNum == ""  &&  memberName2 == ""  && bank == "")  {
  alert('Search field cannot be blank. Please enter a value into the field');
          document.getElementById('search_name').focus();
          return false;
          }                       

//encode to send to server
memberName = encodeURIComponent(memberName);
contractId = encodeURIComponent(contractId); 
groupName = encodeURIComponent(groupName);
ccNum = encodeURIComponent(ccNum);
memberName2 = encodeURIComponent(memberName2);
bank = encodeURIComponent(bank);
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
var url="../sales/searchMemberAccounts.php";
url=url+"?member_name="+memberName;
url=url+"&contract_id="+contractId;
url=url+"&group_name="+groupName;
url=url+"&cc_num="+ccNum;
url=url+"&member_name2="+memberName2;
url=url+"&bank="+bank;
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
                                         window.location = "searchAccounts.php?marker=1";           
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
