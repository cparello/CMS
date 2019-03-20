
//-----------------------------------------------------------------------------------------------------------------
function openContract(id) {

//fields for ajax

switch(id)  {
case 'monthly_billing':
            var bool = 'B';
            
          var response =  confirm('This will Process monthly billing. Do you wish to continue?');
             if(!response) {         
                return false;  
                    }

//if the response is false then we return false and reset the check box. if not we release the hold

break;
case 'past_billing':
          var bool = 'P';
          
         var response =  confirm('This will Process PAST DUE monthly billing. Do you wish to continue?');
             if(!response) {         
                return false;  
                    }
break;
}

//alert(report+ '\n' +month+ '\n' + +year);
//return false;

var parameters = "";
parameters = parameters+'bool='+bool;

//get ajax request object  and send the params to the form object
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
//==========================================
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }
//alert(xmlHttp); 
xmlHttp.onreadystatechange=stateChanged; 
xmlHttp.open("POST", "runBilling.php", true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.send(parameters);

//==========================================
function stateChanged() { 
        if(xmlHttp.readyState==4 || xmlHttp.readyState=="complete") {      
                
                     var successKey =  xmlHttp.responseText;
               //alert(successKey);                         
                           //set the print switch so that if the submit button is suppressed then it will tel if the contract has been printed
                         if(successKey == 1) {   
                           
                           alert('Billing Success!')
                           }else{
                           alert('There was an error running this billing');
                           return false;                         
                           }                                                
             }
}
//========================================

}
