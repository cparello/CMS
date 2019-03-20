<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//$mon6 = "john smith";
//$mon6phone = '(818)-000-0000';
//$user_id = 96;

/**/


$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<style type=\"text/css\">
  
  /* Main Containers */

  body {
  	margin: 0;
  	}
                                      
  #wrapper {                          
    width: 960px;                     
    }                                 
                                      
  #grid {                             
  	float: left;                      
  	width: 960px;                     
  	margin: 0;                        
  	padding: 0;                       
  	background: white;                
  	}                                 
                                      
  .block {                            
    position: absolute;               
    border: 1px solid black;          

    border: none;
    border-left: 1px solid #979ba1;          
    border-right: 1px solid #979ba1;          
    }                                 
                                      
  .inner {                            
    height: 100%;                     
    width: 100%;                      
    }                                 
                                      
  .s1x1 {                             
    height: 50px;                    
    width: 200px; 
    text-align:center;
    font:20px arial,sans-serif;
    background-color:#000; 
    color: #F0FFFF;
    text-decoration-color: #F0FFFF;
    -moz-text-decoration-color:  #F0FFFF;               

    color: #003d5c;
    background-color: #c9cfd6;
    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    font-size: 11pt;
    padding-top: 4px;
    }                                 
                                      
  .s2x1 {                             
    height: 75px;                    
    width: 50px; 
    background-color:#000;                     

    color: #003d5c;
    background-color: #c9cfd6;
    text-align: center;
    }                                 
                                      
  .s3x1 {                             
    height: 200px;                    
    width: 50px;
    vertical-align:middle;
    font:25px arial,sans-serif;
    background-color:#000;
    color: #F0FFFF;  
    text-decoration-color:  #F0FFFF;
    -moz-text-decoration-color:  #F0FFFF;                        

    color: #003d5c;
    background-color: #ffffff;
    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    font-size: 11pt;
    padding-top: 4px;
    text-align: center;
    }                                 
                                      
  .s3x1.odd {
    background-color: #e4e6e9;
  }

  .s4x1 {                             
    height: 50;                    
    width: 770px;                     
    }
    .s5x1 {                             
    height: 50;                    
    width: 1110px;                     
    }   
    .s6x1 {                             
    height: 50px;                    
    width: 1350px;                     
    }   
    .s7x1 {                             
    height: 50px;                    
    width: 1590px;                     
    }
    .s8x1 {                             
    height: 50px;                    
    width: 1830px;                     
    }                                         
                                      
  .s1x2 {                             
    height: 250px;                    
    width: 200px;                     
    }                                 
                                      
  .s2x2 {                             
    height: 200px;                    
    width: 200px;    
    background-color: #C0C0C0;                  

    color: #000000;
    background-color: #ffffff;                  
    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    font-size: 9pt;
    font-weight: 600;
    color: #000000;
    }                                 
                                      
  .s2x2.odd {
    /*color: #003d5c;*/
    background-color: #e4e6e9;
    }

  .s2x2 p {
    margin: 5px 0 5px 50px;
    }

  .s2x2 input[type=\"text\"],
  .s2x2 textarea {                            
    width: 100px;
    height: 18px;
    padding: 0;
    margin-top: 5px;
    border: 1px solid #000000;
  }
  
  .s3x2 {                             
    height: 200px;                    
    width: 200px;  
    background-color: #FFFF00;                     
    }                                 
                                      
  .s4x2 {                             
    height: 290px;                    
    width: 960px;                     
    }  
    .s5x2 {                             
    height: 290px;                    
    width: 1200px;                     
    }   
    .s6x2 {                             
    height: 290px;                    
    width: 1440px;                     
    }   
    .s7x2 {                             
    height: 290px;                    
    width: 1680px;                     
    }
     .s8x2 {                             
    height: 290px;                    
    width: 1920px;                     
    }                                      
                                      
  .s1x3 {                             
    height: 530px;                    
    width: 240px;                     
    }                                 
                                      
  .s2x3 {                             
    height: 530px;                    
    width: 480px;                     
    }                                 
                                      
  .s3x3 {                             
    height: 530px;                    
    width: 720px;                     
    }                                 
                                      
  .s4x3 {                             
    height: 530px;                    
    width: 960px;                     
    }                                 
   .s5x3 {                             
    height: 530px;                    
    width: 1200px;                     
    }     
    .s6x3 {                             
    height: 530px;                    
    width: 1440px;                     
    }     
    .s7x3 {                             
    height: 530px;                    
    width: 1680px;                     
    }                                       
     .s8x3 {                             
    height: 530px;                    
    width: 1920px;                     
    }                                    
  
  /* Blocks Position */               
                                      
  .p0x0 {                             
    top: 0px;                         
    left: 0px;                        
    }                                 
                                      
  .p1x1 {                             
    top: 50px;                         
    left: 50px;                      
    }                                 
                                      
  .p2x0 {                             
    top: 0px;                         
    left: 250px;                      
    }                                 
                                      
  .p3x0 {                             
    top: 0px;                         
    left: 450px;                      
    }   
    .p4x0 {                             
    top: 0px;                         
    left: 650px;                      
    }     
    .p5x0 {                             
    top: 0px;                         
    left: 850px;                      
    }     
    .p6x0 {                             
    top: 0px;                         
    left: 1050px;                      
    }  
   .p7x0 {                             
    top: 0px;                         
    left: 1250px;                      
    }                                          
                                      
  .p0x1 {                             
    top: 75px;                       
    left: 0px;                        

    top: 50px;                       
    }                                 
                                      
  .p1x0 {                             
    top: 0;                           
    left: 50px;                      
    }                                 
                                      
  .p1x1 {                             
    top: 50px;                       
    left: 50px;                      
    }                                 
                                      
  .p2x1 {                             
    top: 50px;                       
    left: 250px;                      
    }                                 
                                      
  .p3x1 {                             
    top: 50px;                       
    left: 450px;                      
    }    
   .p4x1 {                             
    top: 50px;                       
    left: 650px;                      
    }     
    .p5x1 {                             
    top: 50px;                       
    left: 850px;                      
    }     
    .p6x1 {                             
    top: 50px;                       
    left: 1050px;                      
    } 
    .p7x1 {                             
    top: 50px;                       
    left: 1250px;                      
    }                                       
                                      
                                      
  .p0x2 {                             
    top: 250px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x2 {                             
    top: 250px;                       
    left: 50px;                      
     }                                
                                      
  .p2x2 {                             
    top: 250px;                       
    left: 250px;                      
     }                                
                                      
  .p3x2 {                             
    top: 250px;                       
    left: 450px;                      
    }                                 
   .p4x2 {                             
    top: 250px;                       
    left: 650px;                      
    }     
    .p5x2 {                             
    top: 250px;                       
    left: 850px;                      
    }     
    .p6x2 {                             
    top: 250px;                       
    left: 1050px;                      
    } 
    .p7x2 {                             
    top: 250px;                       
    left: 1250px;                      
    }     
    .p0x3 {                             
    top: 450px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x3 {                             
    top: 450px;                       
    left: 50px;                      
     }                                
                                      
  .p2x3 {                             
    top: 450px;                       
    left: 250px;                      
     }                                
                                      
  .p3x3 {                             
    top: 450px;                       
    left: 450px;                      
    }                                 
   .p4x3 {                             
    top: 450px;                       
    left: 650px;                      
    }     
    .p5x3 {                             
    top: 450px;                       
    left: 850px;                      
    }     
    .p6x3 {                             
    top: 450px;                       
    left: 1050px;                      
    } 
    .p7x3 {                             
    top: 450px;                       
    left: 1250px;                      
    } 
    .p0x4 {                             
    top: 650px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x4 {                             
    top: 650px;                       
    left: 50px;                      
     }                                
                                      
  .p2x4 {                             
    top: 650px;                       
    left: 250px;                      
     }                                
                                      
  .p3x4 {                             
    top: 650px;                       
    left: 450px;                      
    }                                 
   .p4x4 {                             
    top: 650px;                       
    left: 650px;                      
    }     
    .p5x4 {                             
    top: 650px;                       
    left: 850px;                      
    }     
    .p6x4 {                             
    top: 650px;                       
    left: 1050px;                      
    } 
    .p7x4 {                             
    top: 650px;                       
    left: 1250px;                      
    }     
    
    .p0x5 {                             
    top: 850px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x5 {                             
    top: 850px;                       
    left: 50px;                      
     }                                
                                      
  .p2x5 {                             
    top: 850px;                       
    left: 250px;                      
     }                                
                                      
  .p3x5 {                             
    top: 850px;                       
    left: 450px;                      
    }                                 
   .p4x5 {                             
    top: 850px;                       
    left: 650px;                      
    }     
    .p5x5 {                             
    top: 850px;                       
    left: 850px;                      
    }     
    .p6x5 {                             
    top: 850px;                       
    left: 1050px;                      
    } 
    .p7x5 {                             
    top: 850px;                       
    left: 1250px;                      
    }  
    
    .p0x6 {                             
    top: 1050px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x6 {                             
    top: 1050px;                       
    left: 50px;                      
     }                                
                                      
  .p2x6 {                             
    top: 1050px;                       
    left: 250px;                      
     }                                
                                      
  .p3x6 {                             
    top: 1050px;                       
    left: 450px;                      
    }                                 
   .p4x6 {                             
    top: 1050px;                       
    left: 650px;                      
    }     
    .p5x6 {                             
    top: 1050px;                       
    left: 850px;                      
    }     
    .p6x6 {                             
    top: 1050px;                       
    left: 1050px;                      
    } 
    .p7x6 {                             
    top: 1050px;                       
    left: 1250px;                      
    } 
    
    .p0x7 {                             
    top: 1250px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x7 {                             
    top: 1250px;                       
    left: 50px;                      
     }                                
                                      
  .p2x7 {                             
    top: 1250px;                       
    left: 250px;                      
     }                                
                                      
  .p3x7 {                             
    top: 1250px;                       
    left: 450px;                      
    }                                 
   .p4x7 {                             
    top: 1250px;                       
    left: 650px;                      
    }     
    .p5x7 {                             
    top: 1250px;                       
    left: 850px;                      
    }     
    .p6x7 {                             
    top: 1250px;                       
    left: 1050px;                      
    } 
    .p7x7 {                             
    top: 1250px;                       
    left: 1250px;                      
    }           
    .p0x8 {                             
    top: 1450px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x8 {                             
    top: 1450px;                       
    left: 50px;                      
     }                                
                                      
  .p2x8 {                             
    top: 1450px;                       
    left: 250px;                      
     }                                
                                      
  .p3x8 {                             
    top: 1450px;                       
    left: 450px;                      
    }                                 
   .p4x8 {                             
    top: 1450px;                       
    left: 650px;                      
    }     
    .p5x8 {                             
    top: 1450px;                       
    left: 850px;                      
    }     
    .p6x8 {                             
    top: 1450px;                       
    left: 1050px;                      
    } 
    .p7x8 {                             
    top: 1450px;                       
    left: 1250px;                      
    }   
        .p0x9 {                             
    top: 1650px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x9 {                             
    top: 1650px;                       
    left: 50px;                      
     }                                
                                      
  .p2x9 {                             
    top: 1650px;                       
    left: 250px;                      
     }                                
                                      
  .p3x9 {                             
    top: 1650px;                       
    left: 450px;                      
    }                                 
   .p4x9 {                             
    top: 1650px;                       
    left: 650px;                      
    }     
    .p5x9 {                             
    top: 1650px;                       
    left: 850px;                      
    }     
    .p6x9 {                             
    top: 1650px;                       
    left: 1050px;                      
    } 
    .p7x9 {                             
    top: 1650px;                       
    left: 1250px;                      
    }  
    .p0x10 {                             
    top: 1850px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x10 {                             
    top: 1850px;                       
    left: 50px;                      
     }                                
                                      
  .p2x10 {                             
    top: 1850px;                       
    left: 250px;                      
     }                                
                                      
  .p3x10 {                             
    top: 1850px;                       
    left: 450px;                      
    }                                 
   .p4x10 {                             
    top: 1850px;                       
    left: 650px;                      
    }     
    .p5x10 {                             
    top: 1850px;                       
    left: 850px;                      
    }     
    .p6x10 {                             
    top: 1850px;                       
    left: 1050px;                      
    } 
    .p7x10 {                             
    top: 1850px;                       
    left: 1250px;                      
    }  
    .p0x11 {                             
    top: 2050px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x11 {                             
    top: 2050px;                       
    left: 50px;                      
     }                                
                                      
  .p2x11 {                             
    top: 2050px;                       
    left: 250px;                      
     }                                
                                      
  .p3x11 {                             
    top: 2050px;                       
    left: 450px;                      
    }                                 
   .p4x11 {                             
    top: 2050px;                       
    left: 650px;                      
    }     
    .p5x11 {                             
    top: 2050px;                       
    left: 850px;                      
    }     
    .p6x11 {                             
    top: 2050px;                       
    left: 1050px;                      
    } 
    .p7x11 {                             
    top: 2050px;                       
    left: 1250px;                      
    }                                                                                                                                                             
    .p0x12 {                             
    top: 2250px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x12 {                             
    top: 2250px;                       
    left: 50px;                      
     }                                
                                      
  .p2x12 {                             
    top: 2250px;                       
    left: 250px;                      
     }                                
                                      
  .p3x12 {                             
    top: 2250px;                       
    left: 450px;                      
    }                                 
   .p4x12 {                             
    top: 2250px;                       
    left: 650px;                      
    }     
    .p5x12 {                             
    top: 2250px;                       
    left: 850px;                      
    }     
    .p6x12 {                             
    top: 2250px;                       
    left: 1050px;                      
    } 
    .p7x12 {                             
    top: 2250px;                       
    left: 1250px;                      
    } 
    .p0x13 {                             
    top: 2450px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x13 {                             
    top: 2450px;                       
    left: 50px;                      
     }                                
                                      
  .p2x13 {                             
    top: 2450px;                       
    left: 250px;                      
     }                                
                                      
  .p3x13 {                             
    top: 2450px;                       
    left: 450px;                      
    }                                 
   .p4x13 {                             
    top: 2450px;                       
    left: 650px;                      
    }     
    .p5x13 {                             
    top: 2450px;                       
    left: 850px;                      
    }     
    .p6x13 {                             
    top: 2450px;                       
    left: 1050px;                      
    } 
    .p7x13 {                             
    top: 2450px;                       
    left: 1250px;                      
    } 
        .p0x14 {                             
    top: 2650px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x14 {                             
    top: 2650px;                       
    left: 50px;                      
     }                                
                                      
  .p2x14 {                             
    top: 2650px;                       
    left: 250px;                      
     }                                
                                      
  .p3x14 {                             
    top: 2650px;                       
    left: 450px;                      
    }                                 
   .p4x14 {                             
    top: 2650px;                       
    left: 650px;                      
    }     
    .p5x14 {                             
    top: 2650px;                       
    left: 850px;                      
    }     
    .p6x14 {                             
    top: 2650px;                       
    left: 1050px;                      
    } 
    .p7x14 {                             
    top: 2650px;                       
    left: 1250px;                      
    }                        
        .p0x15 {                             
    top: 2850px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x15 {                             
    top: 2850px;                       
    left: 50px;                      
     }                                
                                      
  .p2x15 {                             
    top: 2850px;                       
    left: 250px;                      
     }                                
                                      
  .p3x15 {                             
    top: 2850px;                       
    left: 450px;                      
    }                                 
   .p4x15 {                             
    top: 2850px;                       
    left: 650px;                      
    }     
    .p5x15 {                             
    top: 2850px;                       
    left: 850px;                      
    }     
    .p6x15 {                             
    top: 2850px;                       
    left: 1050px;                      
    } 
    .p7x15 {                             
    top: 2850px;                       
    left: 1250px;                      
    }     
        .p0x16 {                             
    top: 3050px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x16 {                             
    top: 3050px;                       
    left: 50px;                      
     }                                
                                      
  .p2x16 {                             
    top: 3050px;                       
    left: 250px;                      
     }                                
                                      
  .p3x16 {                             
    top: 3050px;                       
    left: 450px;                      
    }                                 
   .p4x16 {                             
    top: 3050px;                       
    left: 650px;                      
    }     
    .p5x16 {                             
    top: 3050px;                       
    left: 850px;                      
    }     
    .p6x16 {                             
    top: 3050px;                       
    left: 1050px;                      
    } 
    .p7x16 {                             
    top: 3050px;                       
    left: 1250px;                      
    }
        .p0x17 {                             
    top: 3250px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x17 {                             
    top: 3250px;                       
    left: 50px;                      
     }                                
                                      
  .p2x17 {                             
    top: 3250px;                       
    left: 250px;                      
     }                                
                                      
  .p3x17 {                             
    top: 3250px;                       
    left: 450px;                      
    }                                 
   .p4x17 {                             
    top: 3250px;                       
    left: 650px;                      
    }     
    .p5x17 {                             
    top: 3250px;                       
    left: 850px;                      
    }     
    .p6x17 {                             
    top: 3250px;                       
    left: 1050px;                      
    } 
    .p7x17 {                             
    top: 3250px;                       
    left: 1250px;                      
    }   
        .p0x18 {                             
    top: 3450px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x18 {                             
    top: 3450px;                       
    left: 50px;                      
     }                                
                                      
  .p2x18 {                             
    top: 3450px;                       
    left: 250px;                      
     }                                
                                      
  .p3x18 {                             
    top: 3450px;                       
    left: 450px;                      
    }                                 
   .p4x18 {                             
    top: 3450px;                       
    left: 650px;                      
    }     
    .p5x18 {                             
    top: 3450px;                       
    left: 850px;                      
    }     
    .p6x18 {                             
    top: 3450px;                       
    left: 1050px;                      
    } 
    .p7x18 {                             
    top: 3450px;                       
    left: 1250px;                      
    }   
        .p0x19 {                             
    top: 3650px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x19 {                             
    top: 3650px;                       
    left: 50px;                      
     }                                
                                      
  .p2x19 {                             
    top: 3650px;                       
    left: 250px;                      
     }                                
                                      
  .p3x19 {                             
    top: 3650px;                       
    left: 450px;                      
    }                                 
   .p4x19 {                             
    top: 3650px;                       
    left: 650px;                      
    }     
    .p5x19 {                             
    top: 3650px;                       
    left: 850px;                      
    }     
    .p6x19 {                             
    top: 3650px;                       
    left: 1050px;                      
    } 
    .p7x19 {                             
    top: 3650px;                       
    left: 1250px;                      
    }       
        .p0x20 {                             
    top: 3850px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x20 {                             
    top: 3850px;                       
    left: 50px;                      
     }                                
                                      
  .p2x20 {                             
    top: 3850px;                       
    left: 250px;                      
     }                                
                                      
  .p3x20 {                             
    top: 3850px;                       
    left: 450px;                      
    }                                 
   .p4x20 {                             
    top: 3850px;                       
    left: 650px;                      
    }     
    .p5x20 {                             
    top: 3850px;                       
    left: 850px;                      
    }     
    .p6x20 {                             
    top: 3850px;                       
    left: 1050px;                      
    } 
    .p7x20 {                             
    top: 3850px;                       
    left: 1250px;                      
    }    
        .p0x21 {                             
    top: 4050px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x21 {                             
    top: 4050px;                       
    left: 50px;                      
     }                                
                                      
  .p2x21 {                             
    top: 4050px;                       
    left: 250px;                      
     }                                
                                      
  .p3x21 {                             
    top: 4050px;                       
    left: 450px;                      
    }                                 
   .p4x21 {                             
    top: 4050px;                       
    left: 650px;                      
    }     
    .p5x21 {                             
    top: 4050px;                       
    left: 850px;                      
    }     
    .p6x21 {                             
    top: 4050px;                       
    left: 1050px;                      
    } 
    .p7x21 {                             
    top: 4050px;                       
    left: 1250px;                      
    }     
        .p0x22 {                             
    top: 4250px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x22 {                             
    top: 4250px;                       
    left: 50px;                      
     }                                
                                      
  .p2x22 {                             
    top: 4250px;                       
    left: 250px;                      
     }                                
                                      
  .p3x22 {                             
    top: 4250px;                       
    left: 450px;                      
    }                                 
   .p4x22 {                             
    top: 4250px;                       
    left: 650px;                      
    }     
    .p5x22 {                             
    top: 4250px;                       
    left: 850px;                      
    }     
    .p6x22 {                             
    top: 4250px;                       
    left: 1050px;                      
    } 
    .p7x22 {                             
    top: 4250px;                       
    left: 1250px;                      
    }    
        .p0x23 {                             
    top: 4450px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x23 {                             
    top: 4450px;                       
    left: 50px;                      
     }                                
                                      
  .p2x23 {                             
    top: 4450px;                       
    left: 250px;                      
     }                                
                                      
  .p3x23 {                             
    top: 4450px;                       
    left: 450px;                      
    }                                 
   .p4x23 {                             
    top: 4450px;                       
    left: 650px;                      
    }     
    .p5x23 {                             
    top: 4450px;                       
    left: 850px;                      
    }     
    .p6x23 {                             
    top: 4450px;                       
    left: 1050px;                      
    } 
    .p7x23 {                             
    top: 4450px;                       
    left: 1250px;                      
    }                              
.button {
   border-top: 1px solid #79f009;
   background: #b8f084;
   background: -webkit-gradient(linear, left top, left bottom, from(#00e86c), to(#b8f084));
   background: -webkit-linear-gradient(top, #00e86c, #b8f084);
   background: -moz-linear-gradient(top, #00e86c, #b8f084);
   background: -ms-linear-gradient(top, #00e86c, #b8f084);
   background: -o-linear-gradient(top, #00e86c, #b8f084);
   padding: 2px 4px;
   -webkit-border-radius: 40px;
   -moz-border-radius: 40px;
   border-radius: 40px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 17px;
   font-family: Helvetica, Arial, Sans-Serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 100px;
    height: 20px;
   }
.button:hover {
   border-top-color: #ffffff;
   background: #ffffff;
   color: #000000;

    background: #b0d191;
   }
.button:active {
   border-top-color: #000000;
   background: #000000;
   }
   
.button2 {
   border-top: 1px solid #ff0000;
   background: #000000;
   background: -webkit-gradient(linear, left top, left bottom, from(#fa0808), to(#000000));
   background: -webkit-linear-gradient(top, #fa0808, #000000);
   background: -moz-linear-gradient(top, #fa0808, #000000);
   background: -ms-linear-gradient(top, #fa0808, #000000);
   background: -o-linear-gradient(top, #fa0808, #000000);
   padding: 2px 4px;
   -webkit-border-radius: 40px;
   -moz-border-radius: 40px;
   border-radius: 40px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #fcfcfc;
   font-size: 17px;
   font-family: 'Lucida Grande', Helvetica, Arial, Sans-Serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #a5228e;
    border-radius: 0px;
    width: 86px;
    height: 20px;
    font-size: 9pt;
    width: 100px;
    height: 20px;
   }
.button2:hover {
   border-top-color: #ffffff;
   background: #ffffff;
   color: #000000;

    background: #b0d191;
   }
.button2:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }           
   
.buttonBack {
   border-top: 1px solid #0dfc00;
   background: #00ff09;
   background: -webkit-gradient(linear, left top, left bottom, from(#42a650), to(#00ff09));
   background: -webkit-linear-gradient(top, #42a650, #00ff09);
   background: -moz-linear-gradient(top, #42a650, #00ff09);
   background: -ms-linear-gradient(top, #42a650, #00ff09);
   background: -o-linear-gradient(top, #42a650, #00ff09);
   padding: 2px 4px;
   -webkit-border-radius: 39px;
   -moz-border-radius: 39px;
   border-radius: 39px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 15px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 40px;
    height: 20px;
    display: none;
   }
.buttonBack:hover {
   border-top-color: #ff0303;
   background: #ff0303;
   color: #000000;

    color: #ffffff;
    background: #a5228e;
   }
.buttonBack:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }

.buttonJump {
   border-top: 1px solid #0dfc00;
   background: #00ff09;
   background: -webkit-gradient(linear, left top, left bottom, from(#42a650), to(#00ff09));
   background: -webkit-linear-gradient(top, #42a650, #00ff09);
   background: -moz-linear-gradient(top, #42a650, #00ff09);
   background: -ms-linear-gradient(top, #42a650, #00ff09);
   background: -o-linear-gradient(top, #42a650, #00ff09);
   padding: 1px 1px;
   -webkit-border-radius: 39px;
   -moz-border-radius: 39px;
   border-radius: 39px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 12px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 40px;
    height: 20px;
   }
.buttonJump:hover {
   border-top-color: #ff0303;
   background: #ff0303;
   color: #000000;

    color: #ffffff;
    background: #a5228e;
   }
.buttonJump:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }
    
.buttonLast {
   border-top: 1px solid #0dfc00;
   background: #00ff09;
   background: -webkit-gradient(linear, left top, left bottom, from(#42a650), to(#00ff09));
   background: -webkit-linear-gradient(top, #42a650, #00ff09);
   background: -moz-linear-gradient(top, #42a650, #00ff09);
   background: -ms-linear-gradient(top, #42a650, #00ff09);
   background: -o-linear-gradient(top, #42a650, #00ff09);
   padding: 2px 4px;
   -webkit-border-radius: 39px;
   -moz-border-radius: 39px;
   border-radius: 39px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 15px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 40px;
    height: 20px;
   }
.buttonLast:hover {
   border-top-color: #ff0303;
   background: #ff0303;
   color: #000000;

    color: #ffffff;
    background: #a5228e;
   }
.buttonLast:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }
   
.buttonNext {
   border-top: 1px solid #0dfc00;
   background: #00ff09;
   background: -webkit-gradient(linear, left top, left bottom, from(#42a650), to(#00ff09));
   background: -webkit-linear-gradient(top, #42a650, #00ff09);
   background: -moz-linear-gradient(top, #42a650, #00ff09);
   background: -ms-linear-gradient(top, #42a650, #00ff09);
   background: -o-linear-gradient(top, #42a650, #00ff09);
   padding: 2px 4px;
   -webkit-border-radius: 39px;
   -moz-border-radius: 39px;
   border-radius: 39px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 15px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 40px;
    height: 20px;
   }
.buttonNext:hover {
   border-top-color: #ff0303;
   background: #ff0303;
   color: #000000;

    color: #ffffff;
    background: #a5228e;
   }
.buttonNext:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }

.buttonToday {
   border-top: 1px solid #0dfc00;
   background: #00ff09;
   background: -webkit-gradient(linear, left top, left bottom, from(#42a650), to(#00ff09));
   background: -webkit-linear-gradient(top, #42a650, #00ff09);
   background: -moz-linear-gradient(top, #42a650, #00ff09);
   background: -ms-linear-gradient(top, #42a650, #00ff09);
   background: -o-linear-gradient(top, #42a650, #00ff09);
   padding: 2px 4px;
   -webkit-border-radius: 39px;
   -moz-border-radius: 39px;
   border-radius: 39px;
   -webkit-box-shadow: rgba(0,0,0,1) 0 1px 0;
   -moz-box-shadow: rgba(0,0,0,1) 0 1px 0;
   box-shadow: rgba(0,0,0,1) 0 1px 0;
   text-shadow: rgba(0,0,0,.4) 0 1px 0;
   color: #000000;
   font-size: 12px;
   font-family: Georgia, serif;
   text-decoration: none;
   vertical-align: middle;

    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    background: #6aa342;
    color: #ffffff;
    border-radius: 0px;
    font-size: 9pt;
    width: 40px;
    height: 20px;
    padding-left: 0;
    padding-right: 0;
   }
.buttonToday:hover {
   border-top-color: #ff0303;
   background: #ff0303;
   color: #000000;

    color: #ffffff;
    background: #a5228e;
   }
.buttonToday:active {
   border-top-color: #1b435e;
   background: #1b435e;
   }                                  

button,
input[type=\"submit\"] {
    border: none;
    box-shadow: none;
    margin-top: 5px;
}

   
textarea {
   resize: none;
}  
</style>                              

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<title>CMP Sales Scheduler</title>
<link href=\"grids.css\" rel=\"stylesheet\" type=\"text/css\" />
<style type=\"text/css\">
</style>
<link rel=\"stylesheet\" href=\"../css/base/jquery.ui.all.css\">
<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/checkScheduleData.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/jquery.ui.core.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/jquery.ui.widget.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/jquery.ui.datepicker.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/jquery.tablesorter.scroller.js\"></script>
<script type=\"text/javascript\" src=\"../scripts/textSalesReminder.js\"></script>
<script>
$(function() {
$( \"#datepicker\" ).datepicker();
});
</script>
</head>

<body>

<div id=\"wrapper\">
  <div id=\"grid\">
       <div class=\"block s2x1 p0x0\">
       <form id=\"form10\" name=\"form10\" method=\"post\" action=\"salesForm.php\" onSubmit=\"return checkData()\">
          <button class=\"buttonBack\" name=\"back\" value=\"Back\" type=\"buttonBack\">Back</button>
        </form>
        <form id=\"form10\" name=\"form10\" method=\"post\" action=\"scheduleUpdate.php\" onSubmit=\"return checkData()\">
          <input type=\"text\" id=\"datepicker\" name=\"datepicker\" size=\"10\" value=\"$datePickDate\" />
          <button class=\"buttonJump\" name=\"jump\" value=\"Jump\" type=\"buttonJump\">Jump</button>
          <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"6\" />
          <input type=\"hidden\" id=\"user_id\" name=\"user_id\" value=\"$user_id\" />
        </form>
        </div>
       <div class=\"block s1x1 p1x0\">Monday<br>$monDate</div>
       <div class=\"block s1x1 p2x0\">Tuesday<br>$tueDate</div>
       <div class=\"block s1x1 p3x0\">Wednesday<br>$wedDate</div>
       <div class=\"block s1x1 p4x0\">Thurdsay<br>$thuDate</div>
       <div class=\"block s1x1 p5x0\">Friday<br>$friDate</div>
       <div class=\"block s1x1 p6x0\">Saturday<br>$satDate</div>
       <div class=\"block s1x1 p7x0\">Sunday<br>$sunDate</div>
      $gridHtml
       </div>
  </div>
</div>



</body>
</html>";

echo "$html";
exit;
?>