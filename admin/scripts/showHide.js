$(document).ready(function(){

	$('.list_head').click(function() {
		$('.list_head').removeClass('on');
	 	$('.list_body').slideUp('normal');
   
		if($(this).next().is(':hidden') == true) {
			$(this).addClass('on');
			$(this).next().slideDown('normal');
		 } 	
	 });

$('.list_body').hide();
	
	$(".listLinks").click(function(){
	 var ts = $(this).text();
	$('#contentHeader').text(ts).css({'background-color' : '#8CC63F'});
	$('#contentHeader').css('text-align' , 'left');
	$('#contentHeader').css('padding-top' , '7px');	
	
     });
	
	
	
});