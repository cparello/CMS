<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
//$mon6 = "john smith";
//$mon6phone = '(818)-000-0000';
//$user_id = 96;

/**/

$admin_header = $_SESSION['header_admin'];
$user  =  $_SESSION['user_name'];
$userId  = $_SESSION['user_id'];
$footer_admin = $_SESSION['footer_admin'];
$userFirstName = $_SESSION['user_fname'];

$html = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>

<link rel=\"stylesheet\" href=\"../css/indexSales.css\">
<style type=\"text/css\">
  .contentFrame {
    position: static;
  }
  .footer {
    margin: 35px 0 0 0;  
  }
  p {
    font-weight: inherit;
    font-size: inherit;
    text-align: left;
  }
</style>                              

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
    padding-top: 15px;
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
    padding-top: 0;
    }                                 
                                      
  .s3x1 {                             
    height: 225px;                    
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
    /*padding-top: 4px;*/
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
    height: 225px;                    
    width: 200px;                     
    }                                 
                                      
  .s2x2 {                             
    height: 225px;                    
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
    height: 225px;                    
    width: 200px;   
    background-color: #FFFF00;                     

    color: #000000;
    font-family: \"Open Sans\", \"Arial\", \"Helvetica\", sans-serif;
    font-size: 9pt;
    font-weight: 600;
    }                                 
                                      
  .s3x2.odd {
    /*color: #003d5c;*/
    background-color: #eeee00;
    }

  .s3x2 p {
    margin: 5px 0 5px 50px;
    }

  .s3x2 input[type=\"text\"],
  .s3x2 textarea {                            
    width: 100px;
    height: 18px;
    padding: 0;
    margin-top: 5px;
    border: 1px solid #000000;
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
    .p8x0 {                             
    top: 0px;                         
    left: 1450px;                      
    } 
    .p9x0 {                             
    top: 0px;                         
    left: 1650px;                      
    }  
    .p10x0 {                             
    top: 0px;                         
    left: 1850px;                      
    }  
    .p11x0 {                             
    top: 0px;                         
    left: 2050px;                      
    }  
    .p12x0 {                             
    top: 0px;                         
    left: 2250px;                      
    }  
    .p13x0 {                             
    top: 0px;                         
    left: 2450px;                      
    }  
    .p14x0 {                             
    top: 0px;                         
    left: 2650px;                      
    }  
    .p15x0 {                             
    top: 0px;                         
    left: 2850px;                      
    }  
    .p16x0 {                             
    top: 0px;                         
    left: 3050px;                      
    }  
    .p17x0 {                             
    top: 0px;                         
    left: 3250px;                      
    }  
    .p18x0 {                             
    top: 0px;                         
    left: 3450px;                      
    }  
    .p19x0 {                             
    top: 0px;                         
    left: 3650px;                      
    }  
    .p20x0 {                             
    top: 0px;                         
    left: 3850px;                      
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
    .p8x1 {                             
    top: 50px;                      
    left: 1450px;                      
    }   
    .p9x1 {                             
    top: 50px;                       
    left: 1650px;                      
    }   
    .p10x1 {                             
    top: 50px;                     
    left: 1850px;                      
    }   
    .p11x1 {                             
    top: 50px;                       
    left: 2050px;                      
    }   
    .p12x1 {                             
    top: 50px;                     
    left: 2250px;                      
    }   
    .p13x1 {                             
    top: 50px;                       
    left: 2450px;                      
    }   
    .p14x1 {                            
    top: 50px;                       
    left: 2650px;                      
    }   
    .p15x1 {                             
    top: 50px;                   
    left: 2850px;                      
    }   
    .p16x1 {                             
    top: 50px;                      
    left: 3050px;                      
    }   
    .p17x1 {                             
    top: 50px;                       
    left: 3250px;                      
    }   
    .p18x1 {                             
    top: 50px;                       
    left: 3450px;                      
    }   
    .p19x1 {                             
    top: 50px;                      
    left: 3650px;                      
    }   
    .p20x1 {                             
    top: 50px;                      
    left: 3850px;                      
    }   
                                          
                                      
                                      
  .p0x2 {                             
    top: 275px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x2 {                             
    top: 275px;                       
    left: 50px;                      
     }                                
                                      
  .p2x2 {                             
    top: 275px;                       
    left: 250px;                      
     }                                
                                      
  .p3x2 {                             
    top: 275px;                       
    left: 450px;                      
    }                                 
   .p4x2 {                             
    top: 275px;                       
    left: 650px;                      
    }     
    .p5x2 {                             
    top: 275px;                       
    left: 850px;                      
    }     
    .p6x2 {                             
    top: 275px;                       
    left: 1050px;                      
    } 
    .p7x2 {                             
    top: 275px;                       
    left: 1250px;                      
    } 
    .p8x2 {                             
    top: 275px;                       
    left: 1450px;                      
    }  
    .p9x2 {                             
    top: 275px;                       
    left: 1650px;                      
    }  
    .p10x2 {                             
    top: 275px;                       
    left: 1850px;                      
    }  
    .p11x2 {                             
    top: 275px;                       
    left: 2050px;                      
    }  
    .p12x2 {                             
    top: 275px;                       
    left: 2250px;                      
    }  
    .p13x2 {                             
    top: 275px;                       
    left: 2450px;                      
    }  
    .p14x2 {                             
    top: 275px;                       
    left: 2650px;                      
    }  
    .p15x2 {                             
    top: 275px;                       
    left: 2850px;                      
    }  
    .p16x2 {                             
    top: 275px;                       
    left: 3050px;                      
    }  
    .p17x2 {                             
    top: 275px;                       
    left: 3250px;                      
    }  
    .p18x2 {                             
    top: 275px;                       
    left: 3450px;                      
    }  
    .p19x2 {                             
    top: 275px;                       
    left: 3650px;                      
    }  
    .p20x2 {                             
    top: 275px;                       
    left: 3850px;                      
    }      
    .p0x3 {                             
    top: 500px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x3 {                             
    top: 500px;                       
    left: 50px;                      
     }                                
                                      
  .p2x3 {                             
    top: 500px;                       
    left: 250px;                      
     }                                
                                      
  .p3x3 {                             
    top: 500px;                       
    left: 450px;                      
    }                                 
   .p4x3 {                             
    top: 500px;                       
    left: 650px;                      
    }     
    .p5x3 {                             
    top: 500px;                       
    left: 850px;                      
    }     
    .p6x3 {                             
    top: 500px;                       
    left: 1050px;                      
    } 
    .p7x3 {                             
    top: 500px;                       
    left: 1250px;                      
    } 
    .p8x3 {                             
    top: 500px;                       
    left: 1450px;                      
    } 
    .p9x3 {                             
    top: 500px;                       
    left: 1650px;                      
    } 
    .p10x3 {                             
    top: 500px;                       
    left: 1850px;                      
    } 
    .p11x3 {                             
    top: 500px;                       
    left: 2050px;                      
    } 
    .p12x3 {                             
    top: 500px;                       
    left: 2250px;                      
    } 
    .p13x3 {                             
    top: 500px;                       
    left: 2450px;                      
    } 
    .p14x3 {                             
    top: 500px;                       
    left: 2650px;                      
    } 
    .p15x3 {                             
    top: 500px;                       
    left: 2850px;                      
    } 
    .p16x3 {                             
    top: 500px;                       
    left: 3050px;                      
    } 
    .p17x3 {                             
    top: 500px;                       
    left: 3250px;                      
    } 
    .p18x3 {                             
    top: 500px;                       
    left: 3450px;                      
    } 
    .p19x3 {                             
    top: 500px;                       
    left: 3650px;                      
    } 
    .p20x3 {                             
    top: 500px;                       
    left: 3850px;                      
    } 
    .p0x4 {                             
    top: 725px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x4 {                             
    top: 725px;                       
    left: 50px;                      
     }                                
                                      
  .p2x4 {                             
    top: 725px;                       
    left: 250px;                      
     }                                
                                      
  .p3x4 {                             
    top: 725px;                       
    left: 450px;                      
    }                                 
   .p4x4 {                             
    top: 725px;                       
    left: 650px;                      
    }     
    .p5x4 {                             
    top: 725px;                       
    left: 850px;                      
    }     
    .p6x4 {                             
    top: 725px;                       
    left: 1050px;                      
    } 
    .p7x4 {                             
    top: 725px;                       
    left: 1250px;                      
    }   
       .p8x4 {                             
    top: 725px;                       
    left: 1450px;                      
    } 
    .p9x4 {                             
    top: 725px;                       
    left: 1650px;                      
    } 
    .p10x4 {                             
    top: 725px;                       
    left: 1850px;                      
    } 
    .p11x4 {                             
    top: 725px;                       
    left: 2050px;                      
    } 
    .p12x4 {                             
    top: 725px;                       
    left: 2250px;                      
    } 
    .p13x4 {                             
    top: 725px;                       
    left: 2450px;                      
    } 
    .p14x4 {                             
    top: 725px;                       
    left: 2650px;                      
    } 
    .p15x4 {                             
    top: 725px;                       
    left: 2850px;                      
    } 
    .p16x4 {                             
    top: 725px;                       
    left: 3050px;                      
    } 
    .p17x4 {                             
    top: 725px;                       
    left: 3250px;                      
    } 
    .p18x4 {                             
    top: 725px;                       
    left: 3450px;                      
    } 
    .p19x4 {                             
    top: 725px;                       
    left: 3650px;                      
    } 
    .p20x4 {                             
    top: 725px;                       
    left: 3850px;                      
    }   
    
    .p0x5 {                             
    top: 950px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x5 {                             
    top: 950px;                       
    left: 50px;                      
     }                                
                                      
  .p2x5 {                             
    top: 950px;                       
    left: 250px;                      
     }                                
                                      
  .p3x5 {                             
    top: 950px;                       
    left: 450px;                      
    }                                 
   .p4x5 {                             
    top: 950px;                       
    left: 650px;                      
    }     
    .p5x5 {                             
    top: 950px;                       
    left: 850px;                      
    }     
    .p6x5 {                             
    top: 950px;                       
    left: 1050px;                      
    } 
    .p7x5 {                             
    top: 950px;                       
    left: 1250px;                      
    }  
       .p8x5 {                             
    top: 950px;                       
    left: 1450px;                      
    } 
    .p9x5 {                             
    top: 950px;                       
    left: 1650px;                      
    } 
    .p10x5 {                             
    top: 950px;                       
    left: 1850px;                      
    } 
    .p11x5 {                             
    top: 950px;                       
    left: 2050px;                      
    } 
    .p12x5 {                             
    top: 950px;                       
    left: 2250px;                      
    } 
    .p13x5 {                             
    top: 950px;                       
    left: 2450px;                      
    } 
    .p14x5 {                             
    top: 950px;                       
    left: 2650px;                      
    } 
    .p15x5 {                             
    top: 950px;                       
    left: 2850px;                      
    } 
    .p16x5 {                             
    top: 950px;                       
    left: 3050px;                      
    } 
    .p17x5 {                             
    top: 950px;                       
    left: 3250px;                      
    } 
    .p18x5 {                             
    top: 950px;                       
    left: 3450px;                      
    } 
    .p19x5 {                             
    top: 950px;                       
    left: 3650px;                      
    } 
    .p20x5 {                             
    top: 950px;                       
    left: 3850px;                      
    } 
    .p0x6 {                             
    top: 1175px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x6 {                             
    top: 1175px;                       
    left: 50px;                      
     }                                
                                      
  .p2x6 {                             
    top: 1175px;                       
    left: 250px;                      
     }                                
                                      
  .p3x6 {                             
    top: 1175px;                       
    left: 450px;                      
    }                                 
   .p4x6 {                             
    top: 1175px;                       
    left: 650px;                      
    }     
    .p5x6 {                             
    top: 1175px;                       
    left: 850px;                      
    }     
    .p6x6 {                             
    top: 1175px;                       
    left: 1050px;                      
    } 
    .p7x6 {                             
    top: 1175px;                       
    left: 1250px;                      
    } 
    .p8x6 {                             
    top: 1175px;                       
    left: 1450px;                      
    } 
    .p9x6 {                             
    top: 1175px;                       
    left: 1650px;                      
    } 
    .p10x6 {                             
    top: 1175px;                       
    left: 1850px;                      
    } 
    .p11x6 {                             
    top: 1175px;                       
    left: 2050px;                      
    } 
    .p12x6 {                             
    top: 1175px;                       
    left: 2250px;                      
    } 
    .p13x6 {                             
    top: 1175px;                       
    left: 2450px;                      
    } 
    .p14x6 {                             
    top: 1175px;                       
    left: 2650px;                      
    } 
    .p15x6 {                             
    top: 1175px;                       
    left: 2850px;                      
    } 
    .p16x6 {                             
    top: 1175px;                       
    left: 3050px;                      
    } 
    .p17x6 {                             
    top: 1175px;                       
    left: 3250px;                      
    } 
    .p18x6 {                             
    top: 1175px;                       
    left: 3450px;                      
    } 
    .p19x6 {                             
    top: 1175px;                       
    left: 3650px;                      
    } 
    .p20x6 {                             
    top: 1175px;                       
    left: 3850px;                      
    } 
    
    .p0x7 {                             
    top: 1400px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x7 {                             
    top: 1400px;                       
    left: 50px;                      
     }                                
                                      
  .p2x7 {                             
    top: 1400px;                       
    left: 250px;                      
     }                                
                                      
  .p3x7 {                             
    top: 1400px;                       
    left: 450px;                      
    }                                 
   .p4x7 {                             
    top: 1400px;                       
    left: 650px;                      
    }     
    .p5x7 {                             
    top: 1400px;                       
    left: 850px;                      
    }     
    .p6x7 {                             
    top: 1400px;                       
    left: 1050px;                      
    } 
    .p7x7 {                             
    top: 1400px;                       
    left: 1250px;                      
    }   
       .p8x7 {                             
    top: 1400px;                       
    left: 1450px;                      
    } 
    .p9x7 {                             
    top: 1400px;                       
    left: 1650px;                      
    } 
    .p10x7 {                             
    top: 1400px;                       
    left: 1850px;                      
    } 
    .p11x7 {                             
    top: 1400px;                       
    left: 2050px;                      
    } 
    .p12x7 {                             
    top: 1400px;                       
    left: 2250px;                      
    } 
    .p13x7 {                             
    top: 1400px;                       
    left: 2450px;                      
    } 
    .p14x7 {                             
    top: 1400px;                       
    left: 2650px;                      
    } 
    .p15x7 {                             
    top: 1250px;                       
    left: 2850px;                      
    } 
    .p16x7 {                             
    top: 1400px;                       
    left: 3050px;                      
    } 
    .p17x7 {                             
    top: 1400px;                       
    left: 3250px;                      
    } 
    .p18x7 {                             
    top: 1400px;                       
    left: 3450px;                      
    } 
    .p19x7 {                             
    top: 1400px;                       
    left: 3650px;                      
    } 
    .p20x7 {                             
    top: 1400px;                       
    left: 3850px;                      
    }         
    .p0x8 {                             
    top: 1625px;                       
    left: -1px;                        
    }                                 
                                      
  .p1x8 {                             
    top: 1625px;                       
    left: 50px;                      
     }                                
                                      
  .p2x8 {                             
    top: 1625px;                       
    left: 250px;                      
     }                                
                                      
  .p3x8 {                             
    top: 1625px;                       
    left: 450px;                      
    }                                 
   .p4x8 {                             
    top: 1625px;                       
    left: 650px;                      
    }     
    .p5x8 {                             
    top: 1625px;                       
    left: 850px;                      
    }     
    .p6x8 {                             
    top: 1625px;                       
    left: 1050px;                      
    } 
    .p7x8 {                             
    top: 1625px;                       
    left: 1250px;                      
    }   
     .p8x8 {                             
    top: 1625px;                       
    left: 1450px;                      
    }   
     .p9x8 {                             
    top: 1625px;                       
    left: 1650px;                      
    }   
     .p10x8 {                             
    top: 1625px;                       
    left: 1850px;                      
    }   
     .p11x8 {                             
    top: 1625px;                       
    left: 2050px;                      
    }   
     .p12x8 {                             
    top: 1625px;                       
    left: 2250px;                      
    }   
     .p13x8 {                             
    top: 1625px;                       
    left: 2450px;                      
    }   
     .p14x8 {                             
    top: 1625px;                       
    left: 2650px;                      
    }   
     .p15x8 {                             
    top: 1625px;                       
    left: 2850px;                      
    }   
     .p16x8 {                             
    top: 1625px;                       
    left: 3050px;                      
    }   
     .p17x8 {                             
    top: 1625px;                       
    left: 3250px;                      
    }   
     .p18x8 {                             
    top: 1625px;                       
    left: 3450px;                      
    }   
     .p19x8 {                             
    top: 1625px;                       
    left: 3650px;                      
    }   
     .p20x8 {                             
    top: 1625px;                       
    left: 3850px;                      
    }   
    
    
    
        .p0x9 {                             
    top: 1850px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x9 {                             
    top: 1850px;                       
    left: 50px;                      
     }                                
                                      
  .p2x9 {                             
    top: 1850px;                       
    left: 250px;                      
     }                                
                                      
  .p3x9 {                             
    top: 1850px;                       
    left: 450px;                      
    }                                 
   .p4x9 {                             
    top: 1850px;                       
    left: 650px;                      
    }     
    .p5x9 {                             
    top: 1850px;                       
    left: 850px;                      
    }     
    .p6x9 {                             
    top: 1850px;                       
    left: 1050px;                      
    } 
    .p7x9 {                             
    top: 1850px;                       
    left: 1250px;                      
    }  
      .p8x9 {                             
    top: 1850px;                       
    left: 1450px;                      
    }   
     .p9x9 {                             
    top: 1850px;                       
    left: 1650px;                      
    }   
     .p10x9 {                             
    top: 1850px;                       
    left: 1850px;                      
    }   
     .p11x9 {                             
    top: 1850px;                       
    left: 2050px;                      
    }   
     .p12x9 {                             
    top: 1850px;                       
    left: 2250px;                      
    }   
     .p13x9 {                             
    top: 1850px;                       
    left: 2450px;                      
    }   
     .p14x9 {                             
    top: 1850px;                       
    left: 2650px;                      
    }   
     .p15x9 {                             
    top: 1850px;                       
    left: 2850px;                      
    }   
     .p16x9 {                             
    top: 1850px;                       
    left: 3050px;                      
    }   
     .p17x9 {                             
    top: 1850px;                       
    left: 3250px;                      
    }   
     .p18x9 {                             
    top: 1850px;                       
    left: 3450px;                      
    }   
     .p19x9 {                             
    top: 1850px;                       
    left: 3650px;                      
    }   
     .p20x9 {                             
    top: 1850px;                       
    left: 3850px;                      
    }   
    .p0x10 {                             
    top: 2075px;                       
    left: -2px;                        
    }                                 
                                      
  .p1x10 {                             
    top: 2075px;                       
    left: 50px;                      
     }                                
                                      
  .p2x10 {                             
    top: 2075px;                       
    left: 250px;                      
     }                                
                                      
  .p3x10 {                             
    top: 2075px;                       
    left: 450px;                      
    }                                 
   .p4x10 {                             
    top: 2075px;                       
    left: 650px;                      
    }     
    .p5x10 {                             
    top: 2075px;                       
    left: 850px;                      
    }     
    .p6x10 {                             
    top: 2075px;                       
    left: 1050px;                      
    } 
    .p7x10 {                             
    top: 2075px;                       
    left: 1250px;                      
    }  
      .p8x10 {                             
    top: 2075px;                       
    left: 1450px;                      
    }   
     .p9x10 {                             
    top: 2075px;                       
    left: 1650px;                      
    }   
     .p10x10 {                             
    top: 2075px;                       
    left: 1850px;                      
    }   
     .p11x10 {                             
    top: 2075px;                       
    left: 2050px;                      
    }   
     .p12x10 {                             
    top: 2075px;                       
    left: 2250px;                      
    }   
     .p13x10 {                             
    top: 2075px;                       
    left: 2450px;                      
    }   
     .p14x10 {                             
    top: 2075px;                       
    left: 2650px;                      
    }   
     .p15x10 {                             
    top: 2075px;                       
    left: 2850px;                      
    }   
     .p16x10 {                             
    top: 2075px;                       
    left: 3050px;                      
    }   
     .p17x10 {                             
    top: 2075px;                       
    left: 3250px;                      
    }   
     .p18x10 {                             
    top: 2075px;                       
    left: 3450px;                      
    }   
     .p19x10 {                             
    top: 2075px;                       
    left: 3650px;                      
    }   
     .p20x10 {                             
    top: 2075px;                       
    left: 3850px;                      
    }   
    .p0x11 {                             
    top: 2300px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x11 {                             
    top: 2300px;                       
    left: 50px;                      
     }                                
                                      
  .p2x11 {                             
    top: 2300px;                       
    left: 250px;                      
     }                                
                                      
  .p3x11 {                             
    top: 2300px;                       
    left: 450px;                      
    }                                 
   .p4x11 {                             
    top: 2300px;                       
    left: 650px;                      
    }     
    .p5x11 {                             
    top: 2300px;                       
    left: 850px;                      
    }     
    .p6x11 {                             
    top: 2300px;                       
    left: 1050px;                      
    } 
    .p7x11 {                             
    top: 2300px;                       
    left: 1250px;                      
    }  
    .p8x11 {                             
    top: 2300px;                       
    left: 1450px;                      
    }   
     .p9x11 {                             
    top: 2300px;                       
    left: 1650px;                      
    }   
     .p10x11 {                             
    top: 2300px;                       
    left: 1850px;                      
    }   
     .p11x11 {                             
    top: 2300px;                       
    left: 2050px;                      
    }   
     .p12x11 {                             
    top: 2300px;                       
    left: 2250px;                      
    }   
     .p13x11 {                             
    top: 2300px;                       
    left: 2450px;                      
    }   
     .p14x11 {                             
    top: 2300px;                       
    left: 2650px;                      
    }   
     .p15x11 {                             
    top: 2300px;                       
    left: 2850px;                      
    }   
     .p16x11 {                             
    top: 2300px;                       
    left: 3050px;                      
    }   
     .p17x11 {                             
    top: 2300px;                       
    left: 3250px;                      
    }   
     .p18x11 {                             
    top: 2300px;                       
    left: 3450px;                      
    }   
     .p19x11 {                             
    top: 2300px;                       
    left: 3650px;                      
    }   
     .p20x11 {                             
    top: 2300px;                       
    left: 3850px;                      
    }   
    
    .p0x12 {                             
    top: 2525px;                       
    left: 0px;                      
     }     
               
  .p1x12 {                             
    top: 2525px;                       
    left: 50px;                      
     }                                
                                      
  .p2x12 {                             
    top: 2525px;                       
    left: 250px;                      
     }                                
                                      
  .p3x12 {                             
    top: 2525px;                       
    left: 450px;                      
    }                                 
   .p4x12 {                             
    top: 2525px;                       
    left: 650px;                      
    }     
    .p5x12 {                             
    top: 2525px;                       
    left: 850px;                      
    }     
    .p6x12 {                             
    top: 2525px;                       
    left: 1050px;                      
    } 
    .p7x12 {                             
    top: 2525px;                       
    left: 1250px;                      
    } 
      .p8x12 {                             
    top: 2525px;                       
    left: 1450px;                      
    }   
     .p9x12 {                             
    top: 2525px;                       
    left: 1650px;                      
    }   
     .p10x12 {                             
    top: 2525px;                       
    left: 1850px;                      
    }   
     .p11x12 {                             
    top: 2525px;                       
    left: 2050px;                      
    }   
     .p12x12 {                             
    top: 2525px;                       
    left: 2250px;                      
    }   
     .p13x12 {                             
    top: 2525px;                       
    left: 2450px;                      
    }   
     .p14x12 {                             
    top: 2525px;                       
    left: 2650px;                      
    }   
     .p15x12 {                             
    top: 2525px;                       
    left: 2850px;                      
    }   
     .p16x12 {                             
    top: 2525px;                       
    left: 3050px;                      
    }   
     .p17x12 {                             
    top: 2525px;                       
    left: 3250px;                      
    }   
     .p18x12 {                             
    top: 2525px;                       
    left: 3450px;                      
    }   
     .p19x12 {                             
    top: 2525px;                       
    left: 3650px;                      
    }   
     .p20x12 {                             
    top: 2525px;                       
    left: 3850px;                      
    }   
    .p0x13 {                             
    top: 2750px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x13 {                             
    top: 2750px;                       
    left: 50px;                      
     }                                
                                      
  .p2x13 {                             
    top: 2750px;                       
    left: 250px;                      
     }                                
                                      
  .p3x13 {                             
    top: 2750px;                       
    left: 450px;                      
    }                                 
   .p4x13 {                             
    top: 2750px;                       
    left: 650px;                      
    }     
    .p5x13 {                             
    top: 2750px;                       
    left: 850px;                      
    }     
    .p6x13 {                             
    top: 2750px;                       
    left: 1050px;                      
    } 
    .p7x13 {                             
    top: 2750px;                       
    left: 1250px;                      
    } 
      .p8x13 {                             
    top: 2750px;                       
    left: 1450px;                      
    }   
     .p9x13 {                             
    top: 2750px;                       
    left: 1650px;                      
    }   
     .p10x13 {                             
    top: 2750px;                       
    left: 1850px;                      
    }   
     .p11x13 {                             
    top: 2750px;                       
    left: 2050px;                      
    }   
     .p12x13 {                             
    top: 2750px;                       
    left: 2250px;                      
    }   
     .p13x13 {                             
    top: 2750px;                       
    left: 2450px;                      
    }   
     .p14x13 {                             
    top: 2750px;                       
    left: 2650px;                      
    }   
     .p15x13 {                             
    top: 2750px;                       
    left: 2850px;                      
    }   
     .p16x13 {                             
    top: 2750px;                       
    left: 3050px;                      
    }   
     .p17x13 {                             
    top: 2750px;                       
    left: 3250px;                      
    }   
     .p18x13 {                             
    top: 2750px;                       
    left: 3450px;                      
    }   
     .p19x13 {                             
    top: 2750px;                       
    left: 3650px;                      
    }   
     .p20x13 {                             
    top: 2750px;                       
    left: 3850px;                      
    }   
        .p0x14 {                             
    top: 2975px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x14 {                             
    top: 2975px;                       
    left: 50px;                      
     }                                
                                      
  .p2x14 {                             
    top: 2975px;                       
    left: 250px;                      
     }                                
                                      
  .p3x14 {                             
    top: 2975px;                       
    left: 450px;                      
    }                                 
   .p4x14 {                             
    top: 2975px;                       
    left: 650px;                      
    }     
    .p5x14 {                             
    top: 2975px;                       
    left: 850px;                      
    }     
    .p6x14 {                             
    top: 2975px;                       
    left: 1050px;                      
    } 
    .p7x14 {                             
    top: 2975px;                       
    left: 1250px;                      
    }   
      .p8x14 {                             
    top: 2975px;                       
    left: 1450px;                      
    }   
     .p9x14 {                             
    top: 2975px;                       
    left: 1650px;                      
    }   
     .p10x14 {                             
    top: 2975px;                       
    left: 1850px;                      
    }   
     .p11x14 {                             
    top: 2975px;                       
    left: 2050px;                      
    }   
     .p12x14 {                             
    top: 2975px;                       
    left: 2250px;                      
    }   
     .p13x14 {                             
    top: 2975px;                       
    left: 2450px;                      
    }   
     .p14x14 {                             
    top: 2975px;                       
    left: 2650px;                      
    }   
     .p15x14 {                             
    top: 2975px;                       
    left: 2850px;                      
    }   
     .p16x14 {                             
    top: 2975px;                       
    left: 3050px;                      
    }   
     .p17x14 {                             
    top: 2975px;                       
    left: 3250px;                      
    }   
     .p18x14 {                             
    top: 2975px;                       
    left: 3450px;                      
    }   
     .p19x14 {                             
    top: 2975px;                       
    left: 3650px;                      
    }   
     .p20x14 {                             
    top: 2975px;                       
    left: 3850px;                      
    }                       
        .p0x15 {                             
    top: 3200px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x15 {                             
    top: 3200px;                       
    left: 50px;                      
     }                                
                                      
  .p2x15 {                             
    top: 3200px;                       
    left: 250px;                      
     }                                
                                      
  .p3x15 {                             
    top: 3200px;                       
    left: 450px;                      
    }                                 
   .p4x15 {                             
    top: 3200px;                       
    left: 650px;                      
    }     
    .p5x15 {                             
    top: 3200px;                       
    left: 850px;                      
    }     
    .p6x15 {                             
    top: 3200px;                       
    left: 1050px;                      
    } 
    .p7x15 {                             
    top: 3200px;                       
    left: 1250px;                      
    }    
      .p8x15 {                             
    top: 3200px;                       
    left: 1450px;                      
    }   
     .p9x15 {                             
    top: 3200px;                       
    left: 1650px;                      
    }   
     .p10x15 {                             
    top: 3200px;                       
    left: 1850px;                      
    }   
     .p11x15 {                             
    top: 3200px;                       
    left: 2050px;                      
    }   
     .p12x15 {                             
    top: 3200px;                       
    left: 2250px;                      
    }   
     .p13x15 {                             
    top: 3200px;                       
    left: 2450px;                      
    }   
     .p14x15 {                             
    top: 3200px;                       
    left: 2650px;                      
    }   
     .p15x15 {                             
    top: 3200px;                       
    left: 2850px;                      
    }   
     .p16x15 {                             
    top: 3200px;                       
    left: 3050px;                      
    }   
     .p17x15 {                             
    top: 3200px;                       
    left: 3250px;                      
    }   
     .p18x15 {                             
    top: 3200px;                       
    left: 3450px;                      
    }   
     .p19x15 {                             
    top: 3200px;                       
    left: 3650px;                      
    }   
     .p20x15 {                             
    top: 3200px;                       
    left: 3850px;                      
    }    
        .p0x16 {                             
    top: 3425px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x16 {                             
    top: 3425px;                       
    left: 50px;                      
     }                                
                                      
  .p2x16 {                             
    top: 3425px;                       
    left: 250px;                      
     }                                
                                      
  .p3x16 {                             
    top: 3425px;                       
    left: 450px;                      
    }                                 
   .p4x16 {                             
    top: 3425px;                       
    left: 650px;                      
    }     
    .p5x16 {                             
    top: 3425px;                       
    left: 850px;                      
    }     
    .p6x16 {                             
    top: 3425px;                       
    left: 1050px;                      
    } 
    .p7x16 {                             
    top: 3425px;                       
    left: 1250px;                      
    }
      .p8x16 {                             
    top: 3425px;                       
    left: 1450px;                      
    }   
     .p9x16 {                             
    top: 3425px;                       
    left: 1650px;                      
    }   
     .p10x16 {                             
    top: 3425px;                       
    left: 1850px;                      
    }   
     .p11x16 {                             
    top: 3425px;                       
    left: 2050px;                      
    }   
     .p12x16 {                             
    top: 3425px;                       
    left: 2250px;                      
    }   
     .p13x16 {                             
    top: 3425px;                       
    left: 2450px;                      
    }   
     .p14x16 {                             
    top: 3425px;                       
    left: 2650px;                      
    }   
     .p15x16 {                             
    top: 3425px;                       
    left: 2850px;                      
    }   
     .p16x16 {                             
    top: 3425px;                       
    left: 3050px;                      
    }   
     .p17x16 {                             
    top: 3425px;                       
    left: 3250px;                      
    }   
     .p18x16 {                             
    top: 3425px;                       
    left: 3450px;                      
    }   
     .p19x16 {                             
    top: 3425px;                       
    left: 3650px;                      
    }   
     .p20x16 {                             
    top: 3425px;                       
    left: 3850px;                      
    }   
        .p0x17 {                             
    top: 3650px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x17 {                             
    top: 3650px;                       
    left: 50px;                      
     }                                
                                      
  .p2x17 {                             
    top: 3650px;                       
    left: 250px;                      
     }                                
                                      
  .p3x17 {                             
    top: 3650px;                       
    left: 450px;                      
    }                                 
   .p4x17 {                             
    top: 3650px;                       
    left: 650px;                      
    }     
    .p5x17 {                             
    top: 3650px;                       
    left: 850px;                      
    }     
    .p6x17 {                             
    top: 3650px;                       
    left: 1050px;                      
    } 
    .p7x17 {                             
    top: 3650px;                       
    left: 1250px;                      
    }   
      .p8x17 {                             
    top: 3650px;                       
    left: 1450px;                      
    }   
     .p9x17 {                             
    top: 3650px;                       
    left: 1650px;                      
    }   
     .p10x17 {                             
    top: 3650px;                       
    left: 1850px;                      
    }   
     .p11x17 {                             
    top: 3650px;                       
    left: 2050px;                      
    }   
     .p12x17 {                             
    top: 3650px;                       
    left: 2250px;                      
    }   
     .p13x17 {                             
    top: 3650px;                       
    left: 2450px;                      
    }   
     .p14x17 {                             
    top: 3650px;                       
    left: 2650px;                      
    }   
     .p15x17 {                             
    top: 3650px;                       
    left: 2850px;                      
    }   
     .p16x17 {                             
    top: 3650px;                       
    left: 3050px;                      
    }   
     .p17x17 {                             
    top: 3650px;                       
    left: 3250px;                      
    }   
     .p18x17 {                             
    top: 3650px;                       
    left: 3450px;                      
    }   
     .p19x17 {                             
    top: 3650px;                       
    left: 3650px;                      
    }   
     .p20x17 {                             
    top: 3650px;                       
    left: 3850px;                      
    }   
        .p0x18 {                             
    top: 3875px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x18 {                             
    top: 3875px;                       
    left: 50px;                      
     }                                
                                      
  .p2x18 {                             
    top: 3875px;                       
    left: 250px;                      
     }                                
                                      
  .p3x18 {                             
    top: 3875px;                       
    left: 450px;                      
    }                                 
   .p4x18 {                             
    top: 3875px;                       
    left: 650px;                      
    }     
    .p5x18 {                             
    top: 3875px;                       
    left: 850px;                      
    }     
    .p6x18 {                             
    top: 3875px;                       
    left: 1050px;                      
    } 
    .p7x18 {                             
    top: 3875px;                       
    left: 1250px;                      
    }   
    .p8x18 {                             
    top: 3875px;                       
    left: 1450px;                      
    }   
     .p9x18 {                             
    top: 3875px;                       
    left: 1650px;                      
    }   
     .p10x18 {                             
    top: 3875px;                       
    left: 1850px;                      
    }   
     .p11x18 {                             
    top: 3875px;                       
    left: 2050px;                      
    }   
     .p12x18 {                             
    top: 3875px;                       
    left: 2250px;                      
    }   
     .p13x18 {                             
    top: 3875px;                       
    left: 2450px;                      
    }   
     .p14x18 {                             
    top: 3875px;                       
    left: 2650px;                      
    }   
     .p15x18 {                             
    top: 3875px;                       
    left: 2850px;                      
    }   
     .p16x18 {                             
    top: 3875px;                       
    left: 3050px;                      
    }   
     .p17x18 {                             
    top: 3875px;                       
    left: 3250px;                      
    }   
     .p18x18 {                             
    top: 3875px;                       
    left: 3450px;                      
    }   
     .p19x18 {                             
    top: 3875px;                       
    left: 3650px;                      
    }   
     .p20x18 {                             
    top: 3875px;                       
    left: 3850px;                      
    }   
    
        .p0x19 {                             
    top: 4100px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x19 {                             
    top: 4100px;                       
    left: 50px;                      
     }                                
                                      
  .p2x19 {                             
    top: 4100px;                       
    left: 250px;                      
     }                                
                                      
  .p3x19 {                             
    top: 4100px;                       
    left: 450px;                      
    }                                 
   .p4x19 {                             
    top: 4100px;                       
    left: 650px;                      
    }     
    .p5x19 {                             
    top: 4100px;                       
    left: 850px;                      
    }     
    .p6x19 {                             
    top: 4100px;                       
    left: 1050px;                      
    } 
    .p7x19 {                             
    top: 4100px;                       
    left: 1250px;                      
    }       
      .p8x19 {                             
    top: 4100px;                       
    left: 1450px;                      
    }   
     .p9x19 {                             
    top: 4100px;                       
    left: 1650px;                      
    }   
     .p10x19 {                             
    top: 4100px;                       
    left: 1850px;                      
    }   
     .p11x19 {                             
    top: 4100px;                       
    left: 2050px;                      
    }   
     .p12x19 {                             
    top: 4100px;                       
    left: 2250px;                      
    }   
     .p13x19 {                             
    top: 4100px;                       
    left: 2450px;                      
    }   
     .p14x19 {                             
    top: 4100px;                       
    left: 2650px;                      
    }   
     .p15x19 {                             
    top: 4100px;                       
    left: 2850px;                      
    }   
     .p16x19 {                             
    top: 4100px;                       
    left: 3050px;                      
    }   
     .p17x19 {                             
    top: 4100px;                       
    left: 3250px;                      
    }   
     .p18x19 {                             
    top: 4100px;                       
    left: 3450px;                      
    }   
     .p19x19 {                             
    top: 4100px;                       
    left: 3650px;                      
    }   
     .p20x19 {                             
    top: 4100px;                       
    left: 3850px;                      
    }   
        .p0x20 {                             
    top: 4325px;                       
    left: 0px;                        
    }                                 
                                      
  .p1x20 {                             
    top: 4325px;                       
    left: 50px;                      
     }                                
                                      
  .p2x20 {                             
    top: 4325px;                       
    left: 250px;                      
     }                                
                                      
  .p3x20 {                             
    top: 4325px;                       
    left: 450px;                      
    }                                 
   .p4x20 {                             
    top: 4325px;                       
    left: 650px;                      
    }     
    .p5x20 {                             
    top: 4325px;                       
    left: 850px;                      
    }     
    .p6x20 {                             
    top: 4325px;                       
    left: 1050px;                      
    } 
    .p7x20 {                             
    top: 4325px;                       
    left: 1250px;                      
    }    
      .p8x20 {                             
    top: 4325px;                       
    left: 1450px;                      
    }   
     .p9x20 {                             
    top: 4325px;                       
    left: 1650px;                      
    }   
     .p10x20 {                             
    top: 4325px;                       
    left: 1850px;                      
    }   
     .p11x20 {                             
    top: 4325px;                       
    left: 2050px;                      
    }   
     .p12x20 {                             
    top: 4325px;                       
    left: 2250px;                      
    }   
     .p13x20 {                             
    top: 4325px;                       
    left: 2450px;                      
    }   
     .p14x20 {                             
    top: 4325px;                       
    left: 2650px;                      
    }   
     .p15x20 {                             
    top: 4325px;                       
    left: 2850px;                      
    }   
     .p16x20 {                             
    top: 4325px;                       
    left: 3050px;                      
    }   
     .p17x20 {                             
    top: 4325px;                       
    left: 3250px;                      
    }   
     .p18x20 {                             
    top: 4325px;                       
    left: 3450px;                      
    }   
     .p19x20 {                             
    top: 4325px;                       
    left: 3650px;                      
    }   
     .p20x20 {                             
    top: 4325px;                       
    left: 3850px;                      
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

.block button,
.block input[type=\"submit\"] {
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
<input id=\"goBackAccess\" name=\"goBackAccess\" value=\"Go Back\" class=\"button1\" type=\"submit\">
<div id=\"headerHouse\" class=\"headerHouse\">
<div id=\"headerImg\" class=\"headerImg\">
<div class=\"imgPos\">
<img src=\"../images/logo2.gif\" border=\"0\" />
</div>
</div>
</div>

<div id= \"divStripe1\" class=\"divStripe1\">
</div>

<div id= \"divStripe2\" class=\"divStripe2\">
<div class=\"topMenu\">
  <!--<a href=\"salesForm.php#new_member\">New Member Application</a>-->
  <a href=\"scheduleUpdate.php\">Masters Sales Shedule</a>
  <!--<a href=\"salesForm.php#searchIt\">Search Member</a>-->
</div>
<div id=\"logTxt\" class=\"logTxt\">
<div class=\"txtForm\">
<span class=\"hello\">Hello $userFirstName</span>
| <span class=\"log\"><a class=\"logOut\" href = \"../mainLogin.php\">Log out</a></span>
<br>
Logged In:  $user
</div>
</div>
</div>


<div id=\"container\" class=\"container\">

<div id=\"contentHeader\" class=\"contentHeader\">
$admin_header  
</div>

<div id=\"contentFrame\" class=\"contentFrame\">

<div id=\"wrapper\">
  <div id=\"grid\">
       <div class=\"block s2x1 p0x0\">
       <form id=\"form10\" name=\"form10\" method=\"post\" action=\"../accessPoint.php\" onSubmit=\"return checkData()\">
          <button class=\"buttonBack\" name=\"back\" value=\"Back\" type=\"buttonBack\">Back</button>
        </form>
        <form id=\"form10\" name=\"form10\" method=\"post\" action=\"masterScheduleUpdate.php\" onSubmit=\"return checkData()\">
          <input type=\"text\" id=\"datepicker\" name=\"datepicker\" size=\"10\" value=\"$datePickDate\" />
          <button class=\"buttonJump\" name=\"jump\" value=\"Jump\" type=\"buttonJump\">Jump</button>
          <input type=\"hidden\" id=\"marker\" name=\"marker\" value=\"6\" />
        </form>
        </div>
      $divHtml
      $gridHtml 
  </div>
</div>

</div>

<div class=\"footer\">
$footer_admin
<img src=\"../images/logo_mantistree.png\" class=\"logo_mantistree\" />
</div>  


<script>
  $(document).ready(function(){
    $(\"#container\").height($(document).height() - $(\"#headerHouse\").height() - $(\"#divStripe1\").height() - $(\"#divStripe2\").height() - $(\".footer\").height());
    $(\"#contentFrame\").height($(\"#container\").height());
    $(\"#content\").height($(\"#container\").height());
    /**/
    $(\"#container\").width($(document).width());
    $(\"#contentHeader\").width($(window).width() - parseInt($(\"#contentHeader\").css(\"padding-left\").replace(\"px\", \"\")));
    $(\"#contentFrame\").width($(\"#container\").width());
    $(\"#content\").width($(\"#container\").width());
    //$(\".footer\").width($(\"#divStripe2\").width());
    $(\".footer\").width($(window).width() - parseInt($(\".footer\").css(\"padding-left\").replace(\"px\", \"\")));
    /**/
  });
</script>

</body>
</html>";

echo "$html";
exit;
?>