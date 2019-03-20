<?php
session_start();
$cat_id_selected = "";
$cat_id_selected = $_REQUEST['cat_id'];

include"../../dbConnect.php";
include"loadWebsitePreferences.php";
include "loadStuff.php"; 
include "loadCart.php";

include "webLogCheck.php";
$logCheck = new loginCheck();
$logCheck-> setButtonColor($middleButtons);
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();

$buttonsHtmlMiddle = "";
$stmt = $dbMain ->prepare("SELECT cat_id, cat_name FROM website_store_categories WHERE show_on_web = 'Y'");
echo($dbMain->error);
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($cat_id, $cat_name); 
while($stmt->fetch()){    
    $buttonsHtmlMiddle .= "<button class=\"buttonLocation$middleButtons butColor buttonSize2\" name=\"$cat_id\" value=\"$cat_id\" type=\"buttonLocation$middleButtons\">$cat_name</button>";
   }

$stmt = $dbMain ->prepare("SELECT count(*) as count FROM pos_inventory WHERE category_id = '$cat_id_selected'");
$stmt->execute();      
$stmt->store_result();      
$stmt->bind_result($count); 
$stmt->fetch();
$stmt->close();

switch($count){
    case '1':
        $cssBox1 = "p1x1 {                             
            top: 59%;                         
            left: 45%;                      
            }   ";
        $cssArray = array('p1x1');
    break;
    case '2':
        $cssBox1 = "p1x1 {                             
        top: 59%;                         
        left: 30%;                      
        }   ";
       $cssBox2 = "p1x2 {                             
        top: 59%;                         
        left: 50%;                      
        }  ";
      
        
        $cssArray = array('p1x1','p1x2');
    break;
    case '3':
        $cssBox1 = "p1x1 {                             
        top: 59%;                         
        left: 25%;                      
        }   ";
       $cssBox2 = "p1x2 {                             
        top: 59%;                         
        left: 50%;                      
        }  ";
       $cssBox3 = "p1x3 {                             
        top: 59%;                         
        left: 75%;                      
        }      ";
       
        
        $cssArray = array('p1x1','p1x2','p1x3');
    break;
    default:
        $cssBox1 = "p1x1 {                             
        top: 59%;                         
        left: 10%;                      
        }   ";
       $cssBox2 = "p1x2 {                             
        top: 59%;                         
        left: 30%;                      
        }  ";
       $cssBox3 = "p1x3 {                             
        top: 59%;                         
        left: 50%;                      
        }      ";
       $cssBox4 = "p1x4 {                             
        top: 59%;                         
        left: 70%;                      
        }   ";
       $cssBox5 = "p2x1 {                             
        top: 140%;                         
        left: 10%;                      
        }  ";
       $cssBox6 = "p2x2 {                             
        top: 140%;                         
        left: 30%;                      
        }  ";
         $cssBox7 = "p2x3 {                             
        top: 140%;                         
        left: 50%;                      
        }  ";
         $cssBox8 = "p2x4 {                             
        top: 140%;                         
        left: 70%;                      
        }  ";
        $cssBox9 = "p3x1 {                             
        top: 200%;                         
        left: 10%;                      
        }  ";
       $cssBox10 = "p3x2 {                             
        top: 200%;                         
        left: 30%;                      
        }  ";
         $cssBox11 = "p3x3 {                             
        top: 200%;                         
        left: 50%;                      
        }  ";
         $cssBox12 = "p3x4 {                             
        top: 200%;                         
        left: 70%;                      
        }  ";
        
        $cssArray = array('p1x1','p1x2','p1x3','p1x4','p2x1','p2x2','p2x3','p2x4','p3x1','p3x2','p3x3','p3x4');
    break;
}
   
   
    
    //echo "$cat_id_selected";
    $counter = 0;
    if ($cat_id_selected != ""){
        $stmt = $dbMain ->prepare("SELECT product_desc, retail_cost, inventory_marker, sales_tax FROM pos_inventory WHERE category_id = '$cat_id_selected'");
        echo($dbMain->error);
        $stmt->execute();      
        $stmt->store_result();      
        $stmt->bind_result($product_desc, $retail_cost, $inventory_marker, $sales_tax); 
        while($stmt->fetch()){    
            $cssBuff = $cssArray[$counter];
            
            $stmt99 = $dbMain ->prepare("SELECT description, picture FROM website_product_info WHERE item_marker = '$inventory_marker'");
            echo($dbMain->error);
            $stmt99->execute();      
            $stmt99->store_result();      
            $stmt99->bind_result($description, $pictureMain); 
            $stmt99->fetch();   
            $stmt99->close(); 
               
                $divBoxes .= "<div class=\"block s1x1 $cssBuff\">
                <p class=\"caption-header txt-gray\"><span style=\"color: #000000; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $product_desc</span></b></p>
                <p class=\"caption-header txt-gray\"><span style=\"color: #000000; font-family: Times; font-size:20px;\"><b><span id=\"membership1\"> $$retail_cost</span></b></p>
                    <br>
                    <div class=\"empPhoto\">
                         <a href=\"itemDescriptionPage.php?itemId=$inventory_marker\"><img src=\"pictures/gear/$pictureMain\" alt=\"Smiley face\" height=\"200\" width=\"200\"></a>
                    </div>
                </div>";
            $counter++;
            }
            
           
    }
    
                
                
              
                 
               




include "webTemplates/storePageTemplate.php";

?>