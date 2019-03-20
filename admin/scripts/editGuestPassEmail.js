$(document).ready(function(){
//--------------------------------------------------------------------------------------
function testEmailAddress(emailAddress) {

var at="@";
var dot=".";
var lat=emailAddress.indexOf(at);
var lstr=emailAddress.length;
var ldot=emailAddress.indexOf(dot);

		if(emailAddress.indexOf(at)==-1){
		   return false;
	      }

		if(emailAddress.indexOf(at)==-1 || emailAddress.indexOf(at)==0 || emailAddress.indexOf(at)==lstr) {
		   return false;
	      }

		if(emailAddress.indexOf(dot)==-1 || emailAddress.indexOf(dot)==0 || emailAddress.indexOf(dot)==lstr) {
		  return false;
		  }

		 if(emailAddress.indexOf(at,(lat+1))!=-1){
		    return false;
		  }

		 if(emailAddress.substring(lat-1,lat)==dot || emailAddress.substring(lat+1,lat+2)==dot) {
		    return false;
		  }

		 if(emailAddress.indexOf(dot,(lat+2))==-1) {
		    return false;
		  }
		
		 if(emailAddress.indexOf(" ")!=-1) {
		    return false;		 
          }

}
//--------------------------------------------------------------------------------------
   $('#form1').submit(function(event) {

      var fromAddress= $("#from_address").val();
      var replyAddress = $("#reply_address").val();
      var fromName = $("#from_name").val();
      var introMessage = $("#intro_message").val();
      var addressBool;
        
          if(fromAddress == "") {
            alert('Please enter a \"Sender Email\" address');
                   $("#from_address").focus();
                     return false;
             }else{
             addressBool = testEmailAddress(fromAddress);
                 if(addressBool == false) {
                   alert('You have entered an invalid \"Sender Email\" address')
                         $("#from_address").focus();
                           return false;
                   }
              }


          if(replyAddress == "") {
            alert('Please enter a \"Reply Email\" address');
                   $("#reply_address").focus();
                     return false;
             }else{
             addressBool = testEmailAddress(replyAddress);
                 if(addressBool == false) {
                   alert('You have entered an invalid \"Reply Email\" address')
                         $("#reply_address").focus();
                           return false;
                   }
              }

           
          if(fromName == "") {
            alert('Please enter a \"From Name\"');
                   $("#from_name").focus();
                     return false;
            }
            
             
          if(introMessage == "") {
            alert('Please enter an Intro Message');
                   $("#intro_message").focus();
                    return false;
            }
        
          if(introMessage.length > 150) {
            alert('Intro Message cannot exceed 150 charachters in length');
                  $("#intro_message").focus();
                   return false;
             }             
             
             
             
             
    });
//------------------------------------------------------------------------------------
$('.pullConf').focus(function(){
$('#conf').html("");
});
//------------------------------------------------------------------------------------
   });