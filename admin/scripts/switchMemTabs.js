$(document).ready(function(){

$('.buttonText').live('click', function()  {
       
    $('.buttonText').prev().css({backgroundColor: '#3E39D3'});
    $('.buttonText').prev().css({color: '#FFF'});
  
    $(this).css({backgroundColor: '#BDBEC0'});
    $(this).css({color: '#000'});


    var tabId = this.id;
    
   if(tabId != "clockIn")  {
      $('#clockIn').css({backgroundColor: '#3E39D3'});
      $('#clockIn').css({color: '#FFF'});   
      }
    
    
//---------------------------------------------------------------------------------
    switch(tabId)  {
            case 'newMem':
                    $("#content").attr("src", "viewNewMembers.php");
            break; 
            case 'searchMem':
                    $("#content").attr("src", "searchMembers.php");
            break;     
            case 'reCard':
                    $("#content").attr("src", "reassignMemberCard.php");
            break;        
            case 'checkIn':
                    $("#content").attr("src", "viewCheckInHistory.php");
            break;        
            case 'guestReg':
                    $("#content").attr("src", "guestRegistration.php");
            break;          
            case 'pointSale':
                    $("#content").attr("src", "pointOfSale.php");
            break;      
            case 'scheduler':
                    $("#content").attr("src", "viewScheduler.php");
            break;          
            case 'clockIn':
                    $("#content").attr("src", "employeeClockIn.php");
            break; 
          }
    
     }); 
});    