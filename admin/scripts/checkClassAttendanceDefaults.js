function openFlashChart() {

swfobject.embedSWF(
  "open-flash-chart.swf", idVar,chartWidth,chartHeight, "9.0.0", "expressInstall.swf",{"get-data":"get_data_1"} );
}


function get_data_1()  {
return JSON.stringify(data1);
}


$(document).ready(function() {

this.idVar = "";
this.data1 = "";
this.dataOne= "";
this.dataTwo= "";
this.dataThree = "";
this.dataFour = "";
this.dataFive = "";
this.dataSix = "";
this.dataSeven = "";
this.dataEight = "";

//for print function
this.dataTen = "";
this.dataEleven = "";
this.dataTwelve = "";
this.dataThirteen = "";
this.dataFouteen = "";
this.dataFifteen = "";
this.dataSixteen = "";
this.dataSeventeen = "";

this.chartWidth = "";
this.chartHeight = "";
this.chartCount = "";
this.barArray = "";
this.barPrintArray = "";
this.lineArray = "";
this.linePrintArray = "";
this.projectionRow = null;
this.deleteIt = "";
//-----------------------------------------------------------------
$("#button1").click( function() {

var clubId = $("#service_location").val();
var scheduleType = $("#schedule_type").val();
var className = $("#class_name").val();
var fromDate = $("#from").val();
var toDate = $("#to").val();
var ajaxSwitch = 1;


if(clubId == "") {
  alert('Please select a \"Club Location\"');
  $("#service_location").focus();
  return false;
  }

if(scheduleType == "") {
  alert('Please select a \"Schedule Type\"');
  $("#schedule_type").focus();
  return false;
  }

if(className == "") {
  alert('Please select a \"Class Name\"');
  $("#class_name").focus();
  return false;
  }
  
//alert(clubId+ '\n' +scheduleType+ '\n' +className);
//return false;



        $.ajax ({
                type: "POST",
                url: "runClassAttendanceReports.php",
                cache: false,
                dataType: 'text', 
                data: {ajax_switch: ajaxSwitch, club_id: clubId,  schedule_type: scheduleType, class_name: className, from_date: fromDate, to_date: toDate},               
                     success: function(data) { 
                  //   alert(data);
                  //     return false;

                      var testVisible = $("#twoContent").is(":visible"); 
                     
                          if(testVisible == false) {
                              $("#sectionTwo").css("height", "Auto");
                             }else{
                             $("#sectionTwo").css("height", "350");
                             $("#barBut").attr('src','../images/bar-on.png');
                             $("#lineBut").attr('src','../images/line-off.png');
                            }
                          
                            $("#projTable").find("tr:gt(0)").remove();
                            
                            var dataArray = data.split('|');
                                  chartCount = dataArray[0];
                                  
                                       switch(chartCount) {
                                         case "1":
                                         var deleteIt = "";
                                         dataOne = dataArray[1];
                                         dataTwo = dataArray[2];
                                         projectionRow = dataArray[3];
                                         dataFour = dataArray[4];
                                         dataFive = dataArray[5];
                                         
                                         projectionRow = projectionRow.replace(/\\/g,'');
                                         $('#projTable tr:last').after(projectionRow);
                                         barArray = (chartCount+'|'+dataOne);
                                         lineArray = (chartCount+'|'+dataTwo);
                                         barPrintArray = (chartCount+'|'+dataFour);
                                         linePrintArray = (chartCount+'|'+dataFive);
                                         
                                               $("#bar_charts").val(barArray);
                                               $("#line_charts").val(lineArray);
                                               $("#bar_print").val(barPrintArray);
                                               $("#line_print").val(linePrintArray);
                                               $("#summary_rows").val(projectionRow);
                                                                                              
                                               $("#chart_two").attr('height', '0');
                                               $("#chart_three").attr('height', '0');
                                               $("#chart_four").attr('height', '0');
                                               $("#chart_two").attr('width', '0');
                                               $("#chart_three").attr('width', '0');
                                               $("#chart_four").attr('width', '0');                                               
                                               
                                               dataOne = $.parseJSON(dataOne);
                                               data1 = dataOne;                                
                                               idVar = "chart_one";
                                               chartWidth = "800";
                                               chartHeight = "175";
                                               openFlashChart();                                                                                        
                                         break;
                                         case "2":
                                         dataOne = dataArray[1];
                                         dataTwo = dataArray[2];  
                                         projectionRow = dataArray[3];
                                         dataFour = dataArray[4];
                                         dataFive = dataArray[5];
                                         
                                         projectionRow = projectionRow.replace(/\\/g,'');                                         
                                         $('#projTable tr:last').after(projectionRow);
                                         barArray = (chartCount+'|'+dataOne);
                                         lineArray = (chartCount+'|'+dataTwo);
                                         barPrintArray = (chartCount+'|'+dataFour);
                                         linePrintArray = (chartCount+'|'+dataFive);
                                         
                                               $("#bar_charts").val(barArray);
                                               $("#line_charts").val(lineArray);  
                                               $("#bar_print").val(barPrintArray);
                                               $("#line_print").val(linePrintArray);
                                               $("#summary_rows").val(projectionRow);
                                               
                                               $("#chart_two").attr('height', '0');
                                               $("#chart_three").attr('height', '0');
                                               $("#chart_four").attr('height', '0');
                                               $("#chart_two").attr('width', '0');
                                               $("#chart_three").attr('width', '0');
                                               $("#chart_four").attr('width', '0');      
          
                                               dataOne = $.parseJSON(dataOne);
                                               data1 = dataOne;                                
                                               idVar = "chart_one";
                                               chartWidth = "600";
                                               chartHeight = "175";
                                               openFlashChart();                                              
                                         break;     
                                         case "3":
                                         dataOne = dataArray[1];
                                         dataTwo = dataArray[2];  
                                         projectionRow = dataArray[3];
                                         dataFour = dataArray[4];
                                         dataFive = dataArray[5];
                                         
                                         projectionRow = projectionRow.replace(/\\/g,'');                                         
                                         $('#projTable tr:last').after(projectionRow);
                                         barArray = (chartCount+'|'+dataOne);
                                         lineArray = (chartCount+'|'+dataTwo);
                                         barPrintArray = (chartCount+'|'+dataFour);
                                         linePrintArray = (chartCount+'|'+dataFive);
                                         
                                               $("#bar_charts").val(barArray);
                                               $("#line_charts").val(lineArray);  
                                               $("#bar_print").val(barPrintArray);
                                               $("#line_print").val(linePrintArray);
                                               $("#summary_rows").val(projectionRow);
                                               
                                               $("#chart_two").attr('height', '0');
                                               $("#chart_three").attr('height', '0');
                                               $("#chart_four").attr('height', '0');
                                               $("#chart_two").attr('width', '0');
                                               $("#chart_three").attr('width', '0');
                                               $("#chart_four").attr('width', '0');      
          
                                               dataOne = $.parseJSON(dataOne);
                                               data1 = dataOne;                                
                                               idVar = "chart_one";
                                               chartWidth = "600";
                                               chartHeight = "175";
                                               openFlashChart();                                                       
                                         break;                                         
                                         case "4":
                                         dataOne = dataArray[1];
                                         dataTwo = dataArray[2];
                                         dataThree = dataArray[3];
                                         dataFour = dataArray[4]; 
                                         dataFive = dataArray[5];
                                         dataSix = dataArray[6];
                                         dataSeven = dataArray[7];
                                         dataEight = dataArray[8];
                                         projectionRow = dataArray[9];
                                         dataTen = dataArray[10];
                                         dataEleven = dataArray[11];
                                         dataTwelve = dataArray[12];
                                         dataThirteen = dataArray[13];
                                         dataFourteen = dataArray[14];
                                         dataFifteen = dataArray[15];
                                         dataSixteen = dataArray[16];
                                         dataSeventeen = dataArray[17];
                                         
                                         projectionRow = projectionRow.replace(/\\/g,'');                                         
                                         $('#projTable tr:last').after(projectionRow);
                                         barArray = (chartCount+'|'+dataOne+'|'+dataThree+'|'+dataFive+'|'+dataSeven);
                                         lineArray = (chartCount+'|'+dataTwo+'|'+dataFour+'|'+dataSix+'|'+dataEight);
                                         barPrintArray = (chartCount+'|'+dataTen+'|'+dataTwelve+'|'+dataFourteen+'|'+dataSixteen);
                                         linePrintArray = (chartCount+'|'+dataEleven+'|'+dataThirteen+'|'+dataFifteen+'|'+dataSeventeen);
                                                                                  
                                               $("#bar_charts").val(barArray);
                                               $("#line_charts").val(lineArray);       
                                               $("#bar_print").val(barPrintArray);
                                               $("#line_print").val(linePrintArray);
                                               $("#summary_rows").val(projectionRow);
                                               
                                               dataOne = $.parseJSON(dataOne);
                                               data1 = dataOne;                                
                                               idVar = "chart_one";
                                               chartWidth = "200";
                                               chartHeight = "175";
                                               openFlashChart();                                              
       
                                               setTimeout(function() { loadSecond(); }, 1400);
                                               
                                               function loadSecond() { 
                                                         dataThree = $.parseJSON(dataThree);
                                                         data1 = dataThree;
                                                         idVar = "chart_two";
                                                         chartWidth = "150";
                                                         chartHeight = "175";
                                                         openFlashChart();
                                                         }        
             
                                                setTimeout(function() { loadThird(); }, 2100);        
             
                                               function loadThird() {           
                                                         dataFive = $.parseJSON(dataFive);
                                                         data1 = dataFive;
                                                         idVar = "chart_three";
                                                         chartWidth = "140";
                                                         chartHeight = "175";
                                                         openFlashChart();                                
                                                        }                               

                                                setTimeout(function() { loadFourth(); }, 2800);        
             
                                               function loadFourth() {           
                                                         dataSeven = $.parseJSON(dataSeven);
                                                         data1 = dataSeven;
                                                         idVar = "chart_four";
                                                         chartWidth = "300";
                                                         chartHeight = "175";
                                                         openFlashChart();                                
                                                        }                                                                                               
                                         break;    
                                        }
                                  
                                                    
                         }//end function success
                 }); //end ajax 


});
//-----------------------------------------------------------------
});