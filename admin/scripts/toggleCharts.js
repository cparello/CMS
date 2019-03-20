function openFlashChart2() {

swfobject.embedSWF(
  "open-flash-chart.swf", idVar,chartWidth,chartHeight, "9.0.0", "expressInstall.swf",{"get-data":"get_data_2"} );
}


function get_data_2()  {
return JSON.stringify(data1);
}


$(document).ready(function() {

this.idVar = "";
this.data1 = "";
this.dataOne= "";
this.dataTwo= "";
this.dataThree = "";
this.dataFour = "";
this.chartWidth = "";
this.chartHeight = "";
this.chartCount = "";
//this.barArray = "";
//this.lineArray = "";
//-----------------------------------------------------------------
$("#barBut").click( function() {

$(this).attr('src','../images/bar-on.png');
$("#lineBut").attr('src','../images/line-off.png');
var switchBit = "1";
$("#switch_bit").val(switchBit);

var barArray = $("#bar_charts").val();

       var dataArray = barArray.split('|');
             chartCount = dataArray[0];
                                  
             switch(chartCount) {
                   case "1":
                   dataOne = dataArray[1];
                   dataOne = $.parseJSON(dataOne);                   
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "800";
                   chartHeight = "175";
                   openFlashChart2();                                                                                        
                   break;      
                   
                   case "2":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break; 
                   
                   case "3":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break;                        
                    
                    case "4":
                    dataOne = dataArray[1];
                    dataTwo = dataArray[2];
                    dataThree = dataArray[3];
                    dataFour = dataArray[4]; 
                    
                    dataOne = $.parseJSON(dataOne);
                    data1 = dataOne;                                
                    idVar = "chart_one";
                    chartWidth = "200";
                    chartHeight = "175";
                    openFlashChart2();                                              
       
                    setTimeout(function() { loadSecond2(); }, 500);
                                               
                    function loadSecond2() { 
                            dataTwo = $.parseJSON(dataTwo);
                            data1 = dataTwo;
                            idVar = "chart_two";
                            chartWidth = "150";
                            chartHeight = "175";
                            openFlashChart2();
                           }        
             
                    setTimeout(function() { loadThird2(); }, 1100);        
             
                     function loadThird2() {           
                             dataThree = $.parseJSON(dataThree);
                             data1 = dataThree;
                             idVar = "chart_three";
                             chartWidth = "140";
                             chartHeight = "175";
                             openFlashChart2();                                
                            }                               

                     setTimeout(function() { loadFourth2(); }, 1700);        
             
                       function loadFourth2() {           
                               dataFour = $.parseJSON(dataFour);
                               data1 = dataFour;
                               idVar = "chart_four";
                               chartWidth = "300";
                               chartHeight = "175";
                               openFlashChart2();                                
                              }                                                                                               
                      break;    
                     }


});
//-----------------------------------------------------------------
$("#lineBut").click( function() {

$(this).attr('src','../images/line-on.png');
$("#barBut").attr('src','../images/bar-off.png');
var switchBit = "2";
$("#switch_bit").val(switchBit);

var barArray = $("#line_charts").val();

//alert(barArray);

       var dataArray = barArray.split('|');
             chartCount = dataArray[0];
                                  
             switch(chartCount) {
                   case "1":
                   dataOne = dataArray[1];
                   dataOne = $.parseJSON(dataOne);                   
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "800";
                   chartHeight = "175";
                   openFlashChart2();                                                                                        
                   break;   
                   
                   case "2":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break;  

                   case "3":
                   dataOne = dataArray[1];                   
                   dataOne = $.parseJSON(dataOne);
                   data1 = dataOne;                                
                   idVar = "chart_one";
                   chartWidth = "600";
                   chartHeight = "175";
                   openFlashChart2();                                              
                   break;
                    
                    case "4":
                    dataOne = dataArray[1];
                    dataTwo = dataArray[2];
                    dataThree = dataArray[3];
                    dataFour = dataArray[4]; 
                    
                    dataOne = $.parseJSON(dataOne);
                    data1 = dataOne;                                
                    idVar = "chart_one";
                    chartWidth = "200";
                    chartHeight = "175";
                    openFlashChart2();                                              
       
                    setTimeout(function() { loadSecond2(); }, 500);
                                               
                    function loadSecond2() { 
                            dataTwo = $.parseJSON(dataTwo);
                            data1 = dataTwo;
                            idVar = "chart_two";
                            chartWidth = "150";
                            chartHeight = "175";
                            openFlashChart2();
                           }        
             
                    setTimeout(function() { loadThird2(); }, 1100);        
             
                     function loadThird2() {           
                             dataThree = $.parseJSON(dataThree);
                             data1 = dataThree;
                             idVar = "chart_three";
                             chartWidth = "140";
                             chartHeight = "175";
                             openFlashChart2();                                
                            }                               

                     setTimeout(function() { loadFourth2(); }, 1700);        
             
                       function loadFourth2() {           
                               dataFour = $.parseJSON(dataFour);
                               data1 = dataFour;
                               idVar = "chart_four";
                               chartWidth = "300";
                               chartHeight = "175";
                               openFlashChart2();                                
                              }                                                                                               
                      break;    
                     }


});
//------------------------------------------------------------------------
$("#saveBut").on({
    'mouseover' : function() {
      $(this).attr('src','../images/save-on.png');
    },
    mouseout : function() {
  $(this).attr('src','../images/save-off.png');
    }
  });
//------------------------------------------------------------------------
$("#printBut").on({
    'mouseover' : function() {
      $(this).attr('src','../images/print-on.png');
    },
    mouseout : function() {
  $(this).attr('src','../images/print-off.png');
    }
  });
//---------------------------------------------------------------------


});