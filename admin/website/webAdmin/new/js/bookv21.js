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
        var classTime = $(this).parents().eq(1).find('#class-time').text();
       //alert(classTime);
		var classDate = $('.datepicker').val();
        var className = $(this).parents().eq(1).find('#class-name').text();
        var testClas = $(this).attr('className');
        //alert(className);
        var instructor = $(this).parents().eq(1).find('#instructor').text();
        var schIDbunID = $(this).attr('id').split(' ');
		var scheduleID = schIDbunID[0];
		var bundleID = schIDbunID[1];
        var typeID = schIDbunID[2];
		var classText = className + ' at ' + classTime + ' on ' + classDate;
         //alert(bundleID);
		var classInfo = '<strong>' + className + '</strong><br>' + classDate + ' ' + classTime;
		$('#class-info').html(classInfo);
		$('#schedule_id').val(scheduleID);
        $('#bundle_id').val(bundleID);
        $('#class_text').val(classText);
        $('#time_slot').val(classTime);
        $('#class_name').val(className);
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
		var ajaxSwitch = 1;
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
					$("#class-list").html('Please select the number of classes then fill out the form on the right.<br>'+listings);
					$("#listings").tablesorter();
					$('#listings.tablesorter').tablesorter({
						scrollHeight: 385,
						widgets: ['scroller']
					});
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
		var memType = 'N';
		$('input:radio[name=active]').each(function() {
			if ($(this).val() == memType) {
				$(this).attr('checked', 'checked');
			}
		});
		//var test =('Scedule Type: '+scheduleType+'\n Club ID: '+clubId+'\n ClassName: '+className+'\n Barcode Type: '+barCodeType);
		//alert(test);
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
			// alert(data);
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
				    $('#msgBox2').html('Please notify the facility. ERROR: NOBUNDLE');
                        $("#msgBox2").css( { "color" : "red"} );
				} else {
					//alert(data);
                    $('#msgBox2').html(data);
                        $("#msgBox2").css( { "color" : "red"} );                    
				}
			} //end function success
		}); //end ajax 
	}
	//============================================================================================================================================
	$('#form1').submit(function() {
	  

		var memberId = $('#memberId').val();
		var scheduleId = $("#schedule_id").val();
		var bundleId = $("#bundle_id").val();
		var classDate = $(".datepicker").val();
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
			errors = errors + "Please fill out the Member ID Number field";
		}
		if (memberId == "0") {
			//alert('The Member ID  field cannot be set to zero');
		      errors = errors + "The Member ID  field cannot be set to zero";
		}
		if (isNaN(memberId)) {
			//alert('The Member ID Number field may only contain numbers');
		      errors = errors + "The Member ID Number field may only contain numbers";
		}
		if (memberId.length < 4) {
		//	alert('The Member ID Number number is too short');
		  errors = errors + "The Member ID Number number is too short";
		}
        if(errors !=""){
            $('#msgBox2').html('Please fix these errors then resubmit!  <br>'+errors+' ');
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
				$('#booking_count').val(bookingCount);
				if (successBit == 1) {
					//alert(classText + ' successfully booked');
                     $('#msgBox2').html(classText + ' successfully booked');
                     $("#msgBox2").css( { "color" : "green"} );

					$('#memberId').val("");
					$('#memberId').focus();
					loadClassList(typeId, classDate, locationId);
					if (bookingCount == 0) {
					    $('#msgBox2').html(classText + ' is fully booked for this date and time');
                        $("#msgBox2").css( { "color" : "green"} );
					}
				} else if (successBit == 2) {
					$('#memberId').val("");
					$("#memField").hide();
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
                        $('#msgBox2').html(classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
				    $('#msgBox2').html('There are no records associated with this member id');
                        $("#msgBox2").css( { "color" : "red"} );
                    
				} else if (successBit == 3) {
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (memberType == 'G') {
						memberType = 'N';
					}
					if (groupType == 'S' || groupType == 'F') {
						groupTypeTwo = 'S';
					}
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
					 $('#msgBox2').html(classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html(classText + ' have expired.  Use the form below to purchase more classes.');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 4) {
					loadClassList(typeId, classDate, locationId);
                    $('#msgBox2').html('This class has already been booked by this member');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 5) {
				
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (memberType == 'G') {
						memberType = 'N';
					}
					if (groupType == 'S' || groupType == 'F') {
						groupTypeTwo = 'S';
					}
					if (groupType == "") {
						groupTypeTwo = 'S';
					}
					if (bookingCount == 0) {
                        $('#msgBox2').html(classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html(classText + ' service does not exist for this member.  Use the form below to purchase classes.');
                        $("#msgBox2").css( { "color" : "red"} );                                        
				} else if (successBit == 6) {
				
					if (guestSalt == 'G') {
						$('#memberId').val("");
					}
					if (memberType == 'G') {
						memberType = 'N';
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
                        $('#msgBox2').html(classText + ' is fully booked for this date and time, however, classes maybe purchased for future sessions.');
                        $("#msgBox2").css( { "color" : "red"} );
					}
					loadClassList(typeId, classDate, locationId);
					loadClassOptionsTwo(scheduleId, locationId, className, memberType, groupTypeTwo, firstName, lastName, phone, email);
                    $('#msgBox2').html(classText + ' service has reached the quota for this ' + groupTypeText + '  Use the form below to purchase classes.');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 7) {
                    $('#msgBox2').html('There are no services associated with this member Id');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 8) {
                    $('#msgBox2').html(classText + ' has not been booked for this member Id');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 9) {
					loadClassList(typeId, classDate, locationId);
                    $('#msgBox2').html(classText + ' has been successfully canceled for this member Id');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 10) {
					
                    $('#msgBox2').html('This class date and time is greater than the end date for this guest pass');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 11) {
                    $('#msgBox2').html('This class cannot be canceled because it is less than 24 hrs until the class time');
                        $("#msgBox2").css( { "color" : "red"} );
				} else if (successBit == 12) {alert('This member has recieved the maximun number of Training Assesments!');
                    $('#msgBox2').html('This member has recieved the maximun number of Training Assesments!');
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