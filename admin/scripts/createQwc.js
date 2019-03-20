$(document).ready(function() {
//-----------------------------------------------------------------------
$('#create').click(function() {

var  qbStatus = $('#qb_status').val();
var  qbUserName = $('#qb_user_name').val();
var  qbUserNameLength = qbUserName.length;
var  qbPassword = $('#qb_password').val();
var  qbPasswordLength = qbPassword.length;

var  ajaxSwitch = 1;


if(qbStatus == "") {
     alert('Please select an \"Employee Status\"');
            $('#qb_status').focus();
             return false;
  }


if (!$('#qb_user_name').val().match("^[a-z0-9'.\s]{1,50}$")) {
     alert('You have entered a charachter in the \"Create User Name\" field that is not a number or a letter');
            $('#qb_user_name').focus();
             return false;
    }
    
if (qbUserNameLength < 7) {
     alert('Your user name is too short');
            $('#qb_user_name').focus();
             return false;
   }
   
   
if (!$('#qb_password').val().match("^[a-z0-9'.\s]{1,50}$")) {
     alert('You have entered a charachter in the \"Create Password\" field that is not a number or a letter');
            $('#qb_password').focus();
             return false;
    }
    
if (qbPasswordLength < 7) {
     alert('Your Password is too short');
            $('#qb_password').focus();
             return false;
   }   
   
   

$.ajax ({
                 type: "POST",
                 url: "createQWC.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch, qb_user_name: qbUserName, qb_status: qbStatus, qb_password: qbPassword},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       alert('Conection File successfully created');
                       }else{                         
                       alert('There was an error creating this file' +data);
                       }
                                             
                     }//end function success
              }); //end ajax 




return false;

}); 
//-----------------------------------------------------------------------
$('#download').click(function() {

var ajaxSwitch = 1;

$.ajax ({
                 type: "POST",
                 url: "fileExist.php",
                 cache: false,
                 dataType: 'html', 
                 data: {ajax_switch: ajaxSwitch},               
                 success: function(data) {    
                  //alert(data);
                    if(data == 1) {
                       location.href = "../qwc/downloadQwc.php";
                       }else{                         
                        alert('This connection file does not currently exist.');
                       }
                                             
                     }//end function success
              }); //end ajax 



return false;

}); 
//-----------------------------------------------------------------------
});

