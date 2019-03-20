$(document).ready(function(){

//===================================================
$('#search').click(function() {
  //alert();
var barcode = $('#barcode').val();
var name = $('#name').val();
var emailAddress = $('#email').val();
var errors = "";
barcode = barcode.trim();
name = name.trim();

      if(barcode == "") {
          //alert('Please enter a value into the barcode field');
                  //return false;     
                  errors = errors + "Please enter a value into the barcode field.<br>";
                  $("#msgBox").html(errors);            
          }
      if(name == "") {
          //alert('Please enter a value into the name field');
             //     return false;  
                  errors = errors + "Please enter a value into the name field.<br>";
                   $("#msgBox").html(errors);                 
          }
      
      
//check to see if fields only contain numbers and make sure payment fields are filled out     
      barcode = barcode.replace(/\s+/g, "");
            
 var at="@";
var dot=".";
var lat=emailAddress.indexOf(at);
var lstr=emailAddress.length;
var ldot=emailAddress.indexOf(dot);

        if(emailAddress == "")  {
         // alert("You have entered an invalid email address");
          //document.getElementById('#email').value ="";
         // return false;
          errors = errors +  "You have entered an invalid email address.<br>";
           $("#msgBox").html(errors);  
        }
        
		if(emailAddress.indexOf(at)==-1){
		  // alert("You have entered an invalid email address");
		  // document.getElementById('#email').value ="";
		   //return false;
           errors = errors +  "You have entered an invalid email address.<br>";
            $("#msgBox").html(errors);  
		}

		if(emailAddress.indexOf(at)==-1 || emailAddress.indexOf(at)==0 || emailAddress.indexOf(at)==lstr){
		  // alert("You have entered an invalid email address");
		//   document.getElementById(email).value ="";
		 //  return false;
           errors = errors +  "You have entered an invalid email address.<br>";
            $("#msgBox").html(errors);  
		}

		if(emailAddress.indexOf(dot)==-1 || emailAddress.indexOf(dot)==0 || emailAddress.indexOf(dot)==lstr){
		 // alert("You have entered an invalid email address");	
		//  document.getElementById(email).value ="";
		  //  return false;
            errors = errors +  "You have entered an invalid email address.<br>";
             $("#msgBox").html(errors);  
		}

		 if(emailAddress.indexOf(at,(lat+1))!=-1){
		   // alert("You have entered an invalid email address");
		 //   document.getElementById(email).value ="";
		  //  return false;
            errors = errors +  "You have entered an invalid email address.<br>";
             $("#msgBox").html(errors);  
		 }

		 if(emailAddress.substring(lat-1,lat)==dot || emailAddress.substring(lat+1,lat+2)==dot){
		  //  alert("You have entered an invalid email address");
		   // document.getElementById(email).value ="";
		   // return false;
            errors = errors +  "You have entered an invalid email address.<br>";
             $("#msgBox").html(errors);  
		 }

		 if(emailAddress.indexOf(dot,(lat+2))==-1){
		   // alert("You have entered an invalid email address");
		   // document.getElementById(email).value ="";
		  //  return false;
            errors = errors +  "You have entered an invalid email address.<br>";
             $("#msgBox").html(errors);  
		 }
		
		 if(emailAddress.indexOf(" ")!=-1){
		   // alert("You have entered an invalid email address");
		   // document.getElementById(email).value ="";
		   // return false;	
            errors = errors +  "You have entered an invalid email address.<br>";	
             $("#msgBox").html(errors);   
         }
            
            
            
if(barcode != "")  {
      if(isNaN(barcode)) {
        // alert('Barcode can only contain numbers');
         $("#barcode").focus();
        // return false; 
         errors = errors +  "Barcode can only contain numbers.<br>";
          $("#msgBox").html(errors);          
         }
   }
 if (errors != ""){
    $("#msgBox").css( { "color" : "red"} );
    return false;
 }
  //alert(barcode);
  //send off to payment processor
    $.ajax ({
                 type: "POST",
                 url: "php/checkMemberBarcode.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {barcode: barcode, name: name, email: emailAddress},              
                 success: function(data) {    
                //alert(data)
                
                    var dataArray = data.split("|");
                    var dataBit = dataArray[0];
                    var name = dataArray[1];
                    var erCode = dataArray[2];
                         
                    if(dataBit == 1) {
                             $('#name').val(name);
                             //$('#checkTest').val(dataBit);
                             $("#msgBox").html(name+' a verification email has been sent to your email address. Please type the code into the box below..<br>');
                               $("#msgBox").css( { "color" : "green"} );
                                $('#barcode').prop('disabled', true);
                                $('#name').prop('disabled', true);
                                $('#email').prop('disabled', true);
                                     
                       }else{ 
                        $("#msgBox").html('Your '+erCode+' information could not be verified in our database. Please try again..<br>');
                        $("#msgBox").css( { "color" : "red"} );
                       //alert('Your '+erCode+' information could not be verified in our database.')
                        return false;                                              
                       }
                                             
                     }//end function success
              }); //end ajax              
     
    
      
 return false;      

          

});
//--------------------------------------------------------------------------------------



 });