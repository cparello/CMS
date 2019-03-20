function searchMembers(buttonId) {

var invoice = document.getElementById('search_invoice').value;
var date = document.getElementById('datepicker1').value;
var barcode = document.getElementById('search_barcode').value;
var cat = document.getElementById('search_cat').value; 
var range1 = document.getElementById('datepicker2').value;
var range2 = document.getElementById('datepicker3').value;
//alert(invoice);
 //alert(range1);          
 // alert(range2); 
   //   alert(buttonId);   
//check wiich submit button is selected            
switch(buttonId)  {
case 'invoice':
         if(invoice == "" )  {
            alert('Please enter a value into the Invoice Field');
            document.getElementById('search_invoice').focus();
            return false;
          }else{
            date = "";
            barcode = ""; 
            cat = ""; 
            range2 == "";
            range1  == "";
          }          
break;

case 'date':
         if(date == "" )  {
            alert('Please enter a value into the Date Field');
            document.getElementById('search_date').focus();
            return false;
          }else{
            invoice = "";
            barcode = "";  
            cat = "";
            range2 == "";
            range1  == "";     
          }          
break;


case 'barcode':
         if(barcode == "" )  {
            alert('Please enter a value into the Barcode');
            document.getElementById('search_barcode').focus();
            return false;
          }else if(isNaN(barcode)) {
            alert('Barcode can only contain numbers');
            document.getElementById('search_barcode').focus();
            return false;
          }else{
            invoice = "";
            cat = ""; 
            date = "";
            range2 == "";
            range1  == "";        
          }          
break;

case 'cat':
         if(cat == "" )  {
            alert('Please enter a value into the Category');
            document.getElementById('search_cat').focus();
            return false;
          }else{
            invoice = "";
            date = "";  
            barcode = "";
            range2 == "";
            range1  == "";         
          }          
break;
case 'range':
         if(range2 == "" || range1 =="")  {
            alert('Please enter a value into both date boxes.');
            document.getElementById('search_range1').focus();
            return false;
          }else{
            invoice = "";
            date = "";  
            barcode = ""; 
            cat = "";        
          }          
break;
}
       
 //make sure a form fields are filled out
if(cat == "" && invoice == ""  &&  barcode == ""  && date == "" && range2 == "" && range1 == "")  {
  alert('Search fields cannot be blank. Please enter a value into at least one of these fields');
          document.getElementById(buttonId).focus();
          return false;
          }                       

//encode to send to server
cat = encodeURIComponent(cat);
invoice = encodeURIComponent(invoice); 
barcode = encodeURIComponent(barcode);
date = encodeURIComponent(date);
range2 = encodeURIComponent(range2);
range1 = encodeURIComponent(range1);
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
var url="../billing/searchVoidedPosTransactionsHistory.php";
url=url+"?date="+date;
url=url+"&barcode="+barcode;
url=url+"&cat="+cat;
url=url+"&invoice="+invoice;
url=url+"&range1="+range1;
url=url+"&range2="+range2;
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
                                         window.location = "searchVoidAccountsPOS.php?marker=1";           
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
