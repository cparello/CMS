$(document).ready(function() {
    //---------------------------------------------------------------------------------------
    function loadClassBlurb(className, classDate, timeSlot) {
    
    className = className.trim();
    timeSlot = timeSlot.trim();
    
    var classBlurb = (className+ ' at ' +timeSlot+ ' on ' +classDate);
    
    $("#class_text").val(classBlurb);
    
    }
    //=================================================================
	$('body').on('click', '.book', function () {
	   
       $('#msgBox2').html("");
        $('#msgBox3').html("");
         $('#msgBox5').html("");
          $('#radioBox').html("");
          var classTime = $(this).closest('tr').find('#class-time').text();//$('#class-time').text();
       // var classTime = $(this).parents().eq(1).find('#class-time').text();
      // alert(classTime);
       //if(document.getElementById('week_grid').checked != true){
      //      var classDate = $('.datepicker').val();
     //  }else{
            var classDate = $(this).closest('td').find('#class-date').val();//$('#class-date').val();
            //alert(classDate);
     //  }
		$("#bookClass").attr('value', 'Book Class');
        var className = $(this).closest('td').find('#class-name').text();//$(this).parents().eq(1).find('#class-name').text();
        var testClas = $(this).attr('className');
        //alert(className);
        var instructor = $(this).closest('td').find('#class-name').text();//$(this).parents().eq(1).find('#instructor').text();
        var schIDbunID = $(this).attr('id').split(' ');
		var scheduleID = schIDbunID[0];
		var bundleID = schIDbunID[1];
        var typeID = schIDbunID[2];
		var classText = className + ' at ' + classTime + ' on ' + classDate;
         //alert(bundleID);
		var classInfo = '<strong>' + className + '</strong><br>' + classDate + '  at  ' + classTime;
		$('#class-info').html(classInfo);
		$('#schedule_id').val(scheduleID);
        $('#bundle_id').val(bundleID);
        $('#class_text').val(classText);
        $('#time_slot').val(classTime);
        $('#class_name').val(className);
        $('#class_date').val(classDate);
        $('#type_id').val(typeID);
       /*var test  = $(this).attr("class");
       alert(test);
		var idArray = $(this).val();
		var timeSlot = $(this).closest('tr').find('td:eq(0)').text();
		timeSlot = timeSlot.trim();
		var className = $(this).closest('tr').find('td:eq(1)').text();
		var classDate = $("#datepicker").val();
		var classText = (className + '&nbsp;&nbsp;&nbsp;&nbsp;' + classDate + '&nbsp;&nbsp;' + timeSlot);
		var typeText = 'Book Class:';
		//split the id array to get the schedule id and the bundle id
		idArray = idArray.split(" ");
		var scheduleId = idArray[0];
		var bundleId = idArray[1];
		$("#schedule_id").val(scheduleId);
		$("#bundle_id").val(bundleId);
		$("#time_slot").val(timeSlot);
		loadClassBlurb(className, classDate, timeSlot);
		$("#bookClass").attr('value', 'Book Class');
		//$("#radioMN").hide();
		$("#bookCancel").html(typeText);
		$("#classType").html(classText);
		$('#class_name').val(className);
        $('#book-class').foundation('reveal', 'open');
		$("#memberId").focus();*/
	});
	//--------------------------------------------------------------------------------------

	function loadClassList(scheduleType, eventDate, locationId) {
		var ajaxSwitch = 2;
		$.ajax({
			type: "POST",
			url: "php/loadClassList.php",
			cache: false,
			dataType: 'html',
			data: {
				ajax_switch: ajaxSwitch,
				schedule_type: scheduleType,
				event_date: eventDate,
                clubId: locationId 
			},
			success: function(data) {
				var dataArray = data.split('|');
				var successBit = dataArray[0];
				var listings = dataArray[1];
				if (successBit == 1) {
					$("#class-list").html(listings);
                     $(".spacerChange").css( { "height" : "0px"} );
				//	$("#listings").tablesorter();
				//	$('#listings.tablesorter').tablesorter({
				//		scrollHeight: 385,
				//		widgets: ['scroller']
			//		});
				} else {
				    $('#msgBox2').html(data);
                        $("#msgBox2").css( { "color" : "red"} );
					//alert(data);
				}
			} //end function success
		}); //end ajax 
	}
	//--------------------------------------------------------------

	function loadClassOptionsTwo(scheduleType, clubId, className, barCodeType, groupType, firstName, lastName, phone, email) {
		var ajaxSwitch = 1;
		className = className.trim();
		//takes non member member radios
		
		//var test =('Scedule Type: '+scheduleType+'\n Club ID: '+clubId+'\n ClassName: '+className+'\n Barcode Type: '+barCodeType);
		//alert(barCodeType);
		//return false;
		$.ajax({
			type: "POST",
			url: "php/loadClassOptions.php",
			cache: false,
			dataType: 'html',
			data: {
				ajax_switch: ajaxSwitch,
				schedule_type: scheduleType,
				club_id: clubId,
				search_string: className,
				bar_code_type: barCodeType,
				group_type: groupType
			},
			success: function(data) {
			 //alert(data);
				var dataArray = data.split('|');
				var successBit = dataArray[0];
				var listings = dataArray[1];
				if (successBit == 1) {
					$('#radioBox').html(listings);
					$("#sm_fname").val(firstName);
					$("#sm_lname").val(lastName);
					$("#sm_email").val(email);
					$("#sm_phone").val(phone);
				} else if (successBit == 2) {
				    $('#msgBox2').html('<br>Please notify the facility. ERROR: NOBUNDLE<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else {
					//alert(data);
                    $('#msgBox2').html(data);
                        $("#msgBox2").css( { "color" : "red"} );                    
				}
			} //end function success
		}); //end ajax 
	}
    //==========================================================================================================================================
     var checkBox = $('#non_member');
    checkBox.on('change', function() {
        //alert()
         if(document.getElementById('non_member').checked == false){
            $('#nonMemMem').html("Member");
            $('#bookClass').prop("disabled",false);
            $('#radioBox').html("");
            $('#msgBox2').html("");
            $("#msgBox2").css( { "color" : "black"} );            
            var scheduleId = $("#schedule_id").val();
    		var bundleId = $("#bundle_id").val();
    		//var classDate = $(".datepicker").val();
            var classDate = $('#class_date').val();
    		var classText = $("#class_text").val();
    		var typeId = $('#type_id').val();
    		var locationId = $("#location").val();
    		var className = $("#class_name").val();
            //alert(className);
    		var timeSlot = $("#time_slot").val();
            var groupType = "";
    		var groupTypeTwo = "";
    		var groupTypeText = "";
            var firstName = "";
            var lastName = "";
            var phone = "";
            var email = "";
            var memberType = 'M';
            var groupTypeTwo = 'S';
            loadClassList(typeId, classDate, locationId);
	       // loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
        }else if(document.getElementById('non_member').checked == true){
            $('#bookClass').prop("disabled",true);
            $('#nonMemMem').html("Non-Member");
            $('#radioBox').html("");
            $('#msgBox2').html("<br>1. Select the number of classes below. <br>2. Enter your info on the right. <br>3. Agree to the class waiver.<br>4. Press Process Payment button.<br>5. Class will automatically be booked.<br>6. Use the barcode in the Member ID box for buying or booking future classes.<br>");
             $("#msgBox2").css( { "color" : "black"} );  
            var scheduleId = $("#schedule_id").val();
    		var bundleId = $("#bundle_id").val();
    		//var classDate = $(".datepicker").val();
            var classDate = $('#class_date').val();
    		var classText = $("#class_text").val();
    		var typeId = $('#type_id').val();
    		var locationId = $("#location").val();
    		var className = $("#class_name").val();
            //alert(className);
    		var timeSlot = $("#time_slot").val();
            var groupType = "";
    		var groupTypeTwo = "";
    		var groupTypeText = "";
            var firstName = "";
            var lastName = "";
            var phone = "";
            var email = "";
            var memberType = 'N';
            var groupTypeTwo = 'S';
            loadClassList(typeId, classDate, locationId);
	        loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
        }
        
    });
	//============================================================================================================================================
          $('.close-reveal-modal').click(function() {
            document.getElementById('non_member').checked = false;
              });
            
    //===================================================
	$('#form1').submit(function() {
	  

		var memberId = $('#memberId').val();
		var scheduleId = $("#schedule_id").val();
		var bundleId = $("#bundle_id").val();
		//var classDate = $(".datepicker").val();
        var classDate = $('#class_date').val();
		var classText = $("#class_text").val();
		var typeId = $('#type_id').val();
		var locationId = $("#location").val();
		var className = $("#class_name").val();
        //alert(className);
		var timeSlot = $("#time_slot").val();
		var groupType = "";
		var groupTypeTwo = "";
		var ajaxSwitch = 1;
		var groupTypeText = "";
        var errors = "";
		//check for guest pass
		var guestSalt = memberId.charAt(0);
		if (guestSalt == 'G') {
			memberId = memberId.substr(1);
		}
		var taSalt = memberId.charAt(0);
		if (taSalt == 'T') {
			memberId = memberId.substr(1);
		}
		if (memberId == "") {
			//alert('Please fill out the Member ID Number field');
			errors = errors + "<br>Please fill out the Member ID Number field<br>";
		}
		if (memberId == "0") {
			//alert('The Member ID  field cannot be set to zero');
		      errors = errors + "<br>The Member ID  field cannot be set to zero<br>";
		}
		if (isNaN(memberId)) {
			//alert('The Member ID Number field may only contain numbers');
		      errors = errors + "<br>The Member ID Number field may only contain numbers<br>";
		}
		if (memberId.length < 4) {
		//	alert('The Member ID Number number is too short');
		  errors = errors + "<br>The Member ID Number number is too short<br>";
		}
        if(errors !=""){
            $('#msgBox2').html('<br>Please fix these errors then resubmit!  <br>'+errors+' ');
            $("#msgBox2").css( { "color" : "red"} );
            return false;
        }
         //alert("test");        
		//checks to see if this is a cancel then chanes the ajax switch
		//alert(taSalt+' sfd '+memberId);
		$.ajax({
			type: "POST",
			url: "php/bookClass.php",
			cache: false,
			dataType: 'html',
			data: {
				ajax_switch: ajaxSwitch,
				member_id: memberId,
				schedule_id: scheduleId,
				bundle_id: bundleId,
				class_date: classDate,
				type_id: typeId,
				location: locationId,
				time_slot: timeSlot,
				ta_salt: taSalt
			},
			success: function(data) {
		 		//alert(data);
				var dataArray = data.split('|');
				var successBit = dataArray[0];
				var bookingCount = dataArray[1];
				var memberType = dataArray[2];
				var bookingStatus = dataArray[3];
				groupType = dataArray[4];
				var firstName = dataArray[5];
				var lastName = dataArray[6];
				var phone = dataArray[7];
				var email = dataArray[8];
				//set booking count
				//$('#booking_count').val(bookingCount);
                //alert(bookingCount);
                $(this).closest('td').find('#booking_count').text(bookingCount);
				if (successBit == 1) {
					//alert(classText + ' successfully booked');
                     $('#msgBox2').html('<br>'+classText + ' successfully booked');
                     $("#msgBox2").css( { "color" : "green"} );

					$('#memberId').val("");
					$('#memberId').focus();
					loadClassList(typeId, classDate, locationId);
					if (bookingCount == 0) {
					    $('#msgBox2').html('<br>'+classText + ' is fully booked for this date and time');
                        $("#msgBox2").css( { "color" : "green"} );
					}
				} else if (successBit == 2) {
					$('#memberId').val("");
					$("#memField").hide();
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
                        $('#msgBox2').html('<br>'+classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
					}
                    if (document.getElementById('non_member').checked == true) {
						memberType = 'N';
					}else{
					   memberType = 'M';
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
				    $('#msgBox2').html('<br>There are no records associated with this member id');
                        $("#msgBox2").css( { "color" : "red"} );
                    
				} else if (successBit == 3) {
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (document.getElementById('non_member').checked == true) {
						memberType = 'N';
					}else{
					   memberType = 'M';
					}
					if (groupType == 'S' || groupType == 'F') {
						groupTypeTwo = 'S';
					}
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
					 $('#msgBox2').html('<br>'+classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html('<br>'+classText + ' have expired. <br>1. Select the number of classes below. <br>2. Enter your info on the right. <br>3. Agree to the class waiver. <br>4. Press Process Payment button.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 4) {
					loadClassList(typeId, classDate, locationId);
                    $('#msgBox2').html('<br>This class has already been booked by this member.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 5) {
				
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (document.getElementById('non_member').checked == true) {
						memberType = 'N';
					}else{
					   memberType = 'M';
					}
					if (groupType == 'S' || groupType == 'F') {
						groupTypeTwo = 'S';
					}
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
                        $('#msgBox2').html('<br>'+classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html('<br>You do not have '+classText + ' included in your membership.<br>1. Select the number of classes below. <br>2. Enter your info on the right. <br>3. Agree to the class waiver. <br>4. Press Process Payment button.<br>');
                        $("#msgBox2").css( { "color" : "red"} );                                        
				} else if (successBit == 6) {
				
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (document.getElementById('non_member').checked == true) {
						memberType = 'N';
					}else{
					   memberType = 'M';
					}
					if (groupType == 'S' || groupType == 'F' || groupType == 'B' || groupType == 'O') {
						groupTypeTwo = 'S';
					}
					if (groupType == 'B') {
						groupTypeText = 'Business Member.';
					}
					if (groupType == 'O') {
						groupTypeText = 'Organization Member.';
					}
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
                        $('#msgBox2').html('<br>'+classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html('<br>'+classText + ' classes have run out for ' + groupTypeText + ' <br>1. Select the number of classes below. <br>2. Enter your info on the right. <br>3. Agree to the class waiver. <br>4. Press Process Payment button.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 7) {
                    $('#msgBox2').html('<br>There are no services associated with this member Id.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 8) {
                    $('#msgBox2').html('<br>'+classText + ' has not been booked for this member Id.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 9) {
					loadClassList(typeId, classDate, locationId);
                    $('#msgBox2').html('<br>'+classText + ' has been successfully canceled for this member Id.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 10) {
					
                    $('#msgBox2').html('<br>This class date and time is greater than the end date for this guest pass.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 11) {
                    $('#msgBox2').html('<br>This class cannot be canceled because it is less than 24 hrs until the class time.<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 12) {alert('<br>This member has recieved the maximun number of Training Assesments!<br>');
                    $('#msgBox2').html('<br>This member has recieved the maximun number of Training Assesments!<br>');
                        $("#msgBox2").css( { "color" : "red"} );
				} else {
					alert(data);
				}
			} //end function success
		}); //end ajax 
		return false;
	});
	//-------------------------------------------------------         
});