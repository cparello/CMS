<?php
include "../../../dbConnect.php";
include "bannerVars.php";

session_start();
$the_value = $_REQUEST['the_value'];
$ref_num = $_REQUEST['ref_num'];
$sid = $_REQUEST['sid'];



//echo "ref $ref_num value $the_value";
//exit;


 switch($ref_num) {
	         case "1":
             $_SESSION['banners']->setImageName($the_value);
	         break;
             case "2":
             $_SESSION['banners']->setHeaderText($the_value); 
             break;
             case "3":
             $_SESSION['banners']->setContentText($the_value); 
             break;             
             case "4":
             $_SESSION['banners']->setHeaderTop($the_value); 
             break;   
             case "5":
             $_SESSION['banners']->setHeaderLeft($the_value); 
             break;   
             case "6":
             $_SESSION['banners']->setHeaderRight($the_value); 
             break;   
             case "7":
             $_SESSION['banners']->setContentTop($the_value); 
             break;                
             case "8":
             $_SESSION['banners']->setContentLeft($the_value); 
             break;   
             case "9":
             $_SESSION['banners']->setContentRight($the_value); 
             break;   
             case "10":
             $_SESSION['banners']->setContentFont($the_value); 
             break; 
             case "11":
             $_SESSION['banners']->setHeaderFont($the_value); 
             break;
             case "12":
             $_SESSION['banners']->setHeaderSpace($the_value); 
             break;
             case "13":
             $_SESSION['banners']->setHeaderSize($the_value); 
             break;   
             case "14":
             $_SESSION['banners']->setHeaderStrength($the_value); 
             break;               
             case "15":
             $_SESSION['banners']->setContentSpace($the_value); 
             break;
             case "16":
             $_SESSION['banners']->setContentSize($the_value); 
             break;   
             case "17":
             $_SESSION['banners']->setContentStrength($the_value); 
             break;  
             case "18":
             $_SESSION['banners']->setHeaderColor($the_value); 
             break; 
             case "19":
             $_SESSION['banners']->setContentColor($the_value); 
             break;             
             case "20":
             $_SESSION['banners']->setBannerName($the_value); 
             break;             
             case "21":
             $_SESSION['banners']->setBannerLink($the_value); 
             break;             
             }


exit;



?>