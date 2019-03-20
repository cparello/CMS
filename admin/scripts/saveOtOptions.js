$(document).ready(function() {
//--------------------------------------------------------------------
$("#set_overtime").click( function() {

var ruleOne = $("#rule_one").val();
var ruleTwo = $("#rule_two").val();
var ruleThree = $("#rule_three").val();
var state =  $("#state").val();
var ajaxSwitch = "1";

        $.ajax ({
                type: "POST",
                url: "overtimeOptions.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, rule_one: ruleOne, rule_two: ruleTwo, rule_three: ruleThree, state: state},               
                     success: function(data) { 
                         // alert(data);
                           if(data == "1") {
                           alert('Overtime Options successfully updated');
                            }else{
                            alert(data);
                            }
                                                 
                         }//end function success
                 }); //end ajax 

});
//------------------------------------------------------------------

 $("#state").change(function() {
                
                var ajaxSwitch = 2;
                
                var state = $("#state").val();
 
                //alert(state);
                $.ajax ({
                    type: "POST",
                    url: "overtimeOptions.php",
                    cache: false,
                    dataType: 'html', 
                    data: {ajax_switch: ajaxSwitch, state: state},               
                         success: function(data) { 
                        //   alert(data); 
                             var dataArray = data.split('|');                        
                             var successBit = dataArray[0]; 
                             var ruleOne = dataArray[1];
                             var ruleTwo = dataArray[2];
                             var ruleThree = dataArray[3];
                             
                            
                           if(successBit != "1") {
                                alert("Error");
                            }else{
                                 $("#rule_one").val(ruleOne);
                                 $("#rule_two").val(ruleTwo);
                                 $("#rule_three").val(ruleThree);
                            }
                                                 
                         }//end function success
                });
});
//===========================================
});