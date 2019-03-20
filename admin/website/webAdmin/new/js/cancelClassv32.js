$(document).ready(function() {
    //---------------------------------------------------------------------------------------
    function loadClassBlurb(className, classDate, timeSlot) {
    
    className = className.trim();
    timeSlot = timeSlot.trim();
    
    var classBlurb = (className+ ' at ' +timeSlot+ ' on ' +classDate);
    
    $("#class_text").val(classBlurb);
    
    }
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
				//	});
				} else {
				    $('#msgBox2').html(data);
                        $("#msgBox2").css( { "color" : "red"} );
					//alert(data);
				}
			} //end function success
		}); //end ajax 
	}
	//---------------------------------------------------------------------------------------
	$('body').on('click', '.cancel', function () {
		 $('#msgBox2').html("");
        $('#msgBox3').html("");
         $('#msgBox5').html("");
          $('#radioBox').html("");
		var timeSlot = $(this).closest('tr').find('#class-time').text();//$('#class-time').text();//$(this).closest('tr').find('td:eq(0)').text();
		timeSlot = timeSlot.trim();
		var className = $(this).closest('td').find('#class-name').text();//$(this).parents().eq(1).find('#class-name').text();
		var classDate = $(this).closest('td').find('#class-date').val();
		var classText = (className + '&nbsp;&nbsp;&nbsp;&nbsp;' + classDate + '&nbsp;at&nbsp;' + timeSlot);
		var typeText = 'Cancel Class:';
		//split the id array to get the schedule id and the bundle id
		 var schIDbunID = $(this).attr('id').split(' ');
		var scheduleID = schIDbunID[1];
		var bundleID = schIDbunID[2];
        var typeID = schIDbunID[3];
		$("#schedule_id").val(scheduleID);
		$("#bundle_id").val(bundleID);
         $('#type_id').val(typeID);
		$("#time_slot").val(timeSlot);
		loadClassBlurb(className, classDate, timeSlot);
		$("#bookClass").attr('value', 'Cancel Class');
		//$("#radioMN").hide();
        $('#class_date').val(classDate);
		$("#bookCancel").html(typeText);
		$("#classType").html(classText);
		$('#class_name').val(className);
		$("#memberId").focus();
	});
	//============================================================================================================================================
	$('#form2').submit(function() {
	 // alert('test');
		var memberId = $('#memberIdCanc').val();
		var scheduleId = $("#schedule_id").val();
		var bundleId = $("#bundle_id").val();
		var classDate = $("#class_date").val();
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
            $('#msgBox3').html('Please fix these errors then resubmit!  <br>'+errors+' ');
            $("#msgBox3").css( { "color" : "red"} );
            return false;
        }
         //alert(scheduleId);        
		//checks to see if this is a cancel then chanes the ajax switch
			ajaxSwitch = 2;
		//alert(taSalt+' sfd '+memberId);
        //alert(ajaxSwitch+"   "+ memberId+"   "+  scheduleId+"   "+  bundleId+"   "+  classDate+"   "+ typeId+"   "+ locationId+"   "+ timeSlot+"   "+  taSalt);
        //return false;
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
			     if (successBit == 9) {
					loadClassList(typeId, classDate, locationId);
                    $('#msgBox3').html(classText + ' has been successfully canceled for this member Id');
                        $("#msgBox3").css( { "color" : "green"} );
				} else if (successBit == 11) {
                    $('#msgBox3').html('This class cannot be canceled because it is less than 24 hrs until the class time');
                        $("#msgBox3").css( { "color" : "red"} );
				}else if (successBit == 8) {
                    $('#msgBox3').html(classText + ' has not been booked for this member Id');
                        $("#msgBox3").css( { "color" : "red"} );
				}  else {
				    $('#msgBox3').html(data);
                        $("#msgBox3").css( { "color" : "red"} );
				}
			} //end function success
		}); //end ajax 
		return false;
	});
	//-------------------------------------------------------         
});