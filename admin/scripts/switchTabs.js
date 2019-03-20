$(document).ready(function(){

$('.headText').live('click', function()  {
       
    $('.headText').prev().css({'background-image' : 'url(images/tab_grey.png)' });
    $('.headText').prev().css('color','black');
  
    $(this).css({'background-image' : 'url(images/tab_royal.png)' });
    $(this).css('color','white');


    var tabId = this.id;
    
    if(tabId != "tabFive")  {
      $('#tabFive').css({'background-image' : 'url(images/tab_grey.png)' });
      $('#tabFive').css('color','black');    
      }
  
   if(tabId == "tabOne")  {
      $('#tabOne').css({'background-image' : 'url(images/tab_royal.png)' });
      $('#tabOne').css('color','white');    
      }
  
      
   switch(tabId)  {
            case 'tabOne':
            $("iframe#content").contents().find("#infoHouse").show();
            $("iframe#content").contents().find("#payCont").hide();
            break;
           
            case 'tabTwo':
            $("iframe#content").contents().find("#infoHouse").hide();
            $("iframe#content").contents().find("#payCont").show();            
            $.ajaxSetup ({cache: false});  
            $("iframe#content").contents().find("#payCont").load("billing/viewPaymentHistory.php", 
            function (response) {
            $("iframe#content").contents().find("#paymentList").tablesorter({widgets: ["zebra"]});            
            $("iframe#content").contents().find("#paymentList tr").mouseover(function() {$(this).addClass("over");});                  
            $("iframe#content").contents().find("#paymentList tr").mouseout(function(){ $(this).removeClass("over");});   
            
        //    $("iframe#content").contents().find("#paymentList tr").click(function() { 
       //     $(this).toggleClass('highlight');
            
        //    }); 
            
            
            
            
            
            
            });                 
            break;
           
            case 'tabThree':
            $("iframe#content").contents().find("#infoHouse").hide();
            $("iframe#content").contents().find("#payCont").show();            
            $.ajax
            ({
            type: "POST",
            url: "billing/memberInfo.php",
            cache: false,
            dataType: 'html', 
            success: function(data)          
            {
            $("iframe#content").contents().find("#payCont").html(data);
            }
            });            
            break;
           
            case 'tabFour':
            $("iframe#content").contents().find("#infoHouse").hide();
            $("iframe#content").contents().find("#payCont").show();            
            $.ajax
            ({
            type: "POST",
            url: "utilities/memberNotes.php?ajax_switch=1",
            cache: false,
            dataType: 'html', 
            success: function(data)          
            {
            $("iframe#content").contents().find("#payCont").html(data);
            }
            });            
            break;    
            
            case 'tabFive':
            $("iframe#content").contents().find("#infoHouse").hide();
            $("iframe#content").contents().find("#payCont").show();            
            $.ajax
            ({
            type: "POST",
            url: "billing/posHistoryReport.php?ajax_switch=1",
            cache: false,
            dataType: 'html', 
            success: function(data)          
            {
            $("iframe#content").contents().find("#payCont").html(data);
            }
            });            
            break;      
         }
      
//alert(tabId);
  
});
	

	
});