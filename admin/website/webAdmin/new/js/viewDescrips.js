$(document).ready(function(){
//----------------------------------------------------------

//----------------------------------------------------------
$('#classDescrips').click( function() {

var ajaxSwitch = 1;
var bundleInfo = $("#bundle_type").val();
var typeId = $("#schedule_type").val();
var dataArray = bundleInfo.split(','); 
var bunId =  dataArray[0];

if (bundleInfo == ""){
    ajaxSwitch = 2;
   // var answer1 = confirm("If you do not choose a bundle you will see a list of all similiar classes. Do you wish to continue?");
   //                     if (!answer1) {
   //                       return false;
   //                      }       
}

//alert();
//alert(taSalt+' sfd '+memberId);
$.ajax ({
                type: "POST",
                url: "php/loadClassDescription.php",
                cache: false,
                dataType: 'html', 
                data: {ajax_switch: ajaxSwitch, bunId: bunId, typeId: typeId},               
                     success: function(data) {  
             // alert(data);
                              var dataArray = data.split('|');                        
                              var successBit = dataArray[0]; 
                              var description = dataArray[1];
                              var name = dataArray[2];
                              var catName = dataArray[3];
                                                                 
                          if(successBit == 1) {   
                            window.location = "classDescPage.php?name="+name+"&description="+description+"&catName="+catName+"";
                                     //$('#classDescription').val("<h2>"+name+"<br><br><h5>"+description+"");
                             }else if(successBit == 2){
                                window.location = "classDescPage.php?descriptionList="+description+"&catName="+name+"";
                             }
                                          
                     }//end function success
                 }); //end ajax 

return false;

 });
 //-------------------------------------------------------
});