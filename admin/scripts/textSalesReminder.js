$(document).ready(function(){

 $('.remind').live("click", function() { 


    
var ajaxSwitch = 1;

var phone = $(this).attr('phone');
var name = $(this).attr('name');
var classdate = $(this).attr('classdate');
var phone2 = phone;
var name2 = name;
//alert(' phone '+phone+' name '+name+' date '+classdate);


 var answer1 = confirm("Are you sure you want to send this appointment a text reminder to their cell?");
                               if (!answer1) {
                                      return false;
                                     }         
  phone = encodeURIComponent(phone);
  name = encodeURIComponent(name);
  ajaxSwitch = encodeURIComponent(ajaxSwitch);
  classdate = encodeURIComponent(classdate);
  
  
//alert('kjkjsdfjsdfkj');
 $.ajax ({
                 type: "POST",
                 url: "../sales/emailToSms.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {ajaxSwitch: ajaxSwitch, phone: phone, name: name, classdate: classdate},              
                 success: function(data) {    
               //alert(data);
                  
                  
                if(data = 1) { 
                    alert('A message has been sent to "' +phone2+ '" for "' +name2+ '" to remind them about their appointment!');
                     
                    }else{
                     alert(data);
                     return false;
                    }
                    
                                                              
                     }//end function success
              }); //end ajax  
              //alert('fjhsdhjjds');            

 });
 //====================================================
 
 });