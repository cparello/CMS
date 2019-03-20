$(document).ready(function(){

//===================================================
$('#search').click(function() {
 // alert();
var barcode = $('#barcode').val();
var zipcode = $('#zipcode').val();
var email = $('#email').val();
      if(barcode == "") {
          alert('Please enter a value into the barcode field');
                  return false;                 
          }
      if(zipcode == "") {
          alert('Please enter a value into the zipcode field');
                  return false;                 
          }
      
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      barcode = barcode.replace(/\s+/g, "");
      zipcode = zipcode.replace(/\s+/g, "");
            
 var at="@";
var dot=".";
var lat=email.indexOf(at);
var lstr=email.length;
var ldot=email.indexOf(dot);

        if(email == "")  {
          alert("You have entered an invalid email address");
          document.getElementById(email).value ="";
          return false;
        }
        
		if(email.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(email).value ="";
		   return false;
		}

		if(email.indexOf(at)==-1 || email.indexOf(at)==0 || email.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(email).value ="";
		   return false;
		}

		if(email.indexOf(dot)==-1 || email.indexOf(dot)==0 || email.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(email).value ="";
		    return false;
		}

		 if(email.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(email).value ="";
		    return false;
		 }

		 if(email.substring(lat-1,lat)==dot || email.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(email).value ="";
		    return false;
		 }

		 if(email.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(email).value ="";
		    return false;
		 }
		
		 if(email.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(email).value ="";
		    return false;		 
         }
            
            
            
if(barcode != "")  {
      if(isNaN(barcode)) {
         alert('Barcode can only contain numbers');
         $("#barcode").focus();
         return false;         
         }
   }
if(zipcode != "")  {
      if(isNaN(zipcode)) {
         alert('Barcode can only contain numbers');
         $("#zipcode").focus();
         return false;         
         }
   }

 if(zipcode.length < 5) {
          alert('Your zipcode must be 5 digits');
                  return false;                 
          }
                       
  //alert(barcode);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "checkMemberBarcode.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, zipcode: zipcode, email: email},              
                 success: function(data) {    
                //alert(data)
                
                    var dataArray = data.split("|");
                    var dataBit = dataArray[0];
                    var name = dataArray[1];
                    var erCode = dataArray[2];
                         
                    if(dataBit == 1) {
                             $('#name').val(name);
                             //$('#checkTest').val(dataBit);
                              alert(name+' You have been found in our database an email has been sent to your email address on file. Please type the code into the box below.');
                                     
                       }else{  
                       alert('Your '+erCode+' information could not be verified in our database.')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });