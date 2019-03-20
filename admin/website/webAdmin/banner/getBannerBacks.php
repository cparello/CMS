<?php
// get the class photos
class getBannerBacks   {

public $class_type;
public $form_name;
public $banner_image;

function setClassType($type) {
$this->class_type = $type;
}
function setFormName($form) {
$this->form_name = $form;
}
function setBannerImage($banner_image) {
$this->banner_image = $banner_image;
}



function getBannerImages()  {
include "../../../dbConnect.php";




if($this->banner_image == "")  {
   $this->banner_image = 0;
   $selected_image ="";
   }else{    
  /* $result1 = $dbMain ->query("SELECT thumb_image, main_image, file_number, title  FROM class_photos WHERE  class_type='$this->class_type' AND thumb_image = '$this->banner_image'");
   $row1 = $result1 ->fetch_array(MYSQLI_NUM);
   $thumb_image1 = $row1[0];
   $main_image1 = $row1[1];
   $file_number1 = $row1[2];
   $title1 = $row1[3];*/  
   $count = 100;  
   $selected_image = "<li><a href=\"JavaScript://\" onClick=\"changeImage('$this->banner_image')\"><img id=\"$count\" src=\"../pictures/banner/$this->banner_image\" width=\"468\" height=\"60\"  /></a></li>\n";  
   }


/*
$counter1 = 2;
$i = 0;      
$result2 = $dbMain ->query("SELECT thumb_image, main_image, file_number, title  FROM class_photos WHERE  class_type='$this->class_type' AND thumb_image != '$this->banner_image'");
 $num_results2 =  $result2 ->num_rows;
    
for($i=0; $i < $num_results2; $i++)  {
    $row2 = $result2 ->fetch_array(MYSQLI_NUM);
    $thumb_image2 = $row2[0];
    $main_image2 = $row2[1];
    $file_number2 = $row2[2];
    $title2 = $row2[3];

  $count = $counter1++;  
   
$photo_recs .= "<li><a href=\"JavaScript://\" onClick=\"changeImage('$thumb_image2', '$this->form_name', '$main_image2', '$file_number2', '$title2')\"><img id=\"$count\"src=\"../classimages/cthumb/$thumb_image2\" width=\"468\" height=\"60\"  /></a></li>\n";
    
}*/
$count = 2;
$dir = "../pictures/banner/";

$root = scandir($dir, 1);
    foreach($root as $value) {           
        if($value != "") {
            $photo_recs .= "<li><a href=\"JavaScript://\" onClick=\"changeImage('$value')\"><img id=\"$count\" src=\"../pictures/banner/$value\" width=\"468\" height=\"60\"  /></a></li>\n";
                           }
                           $count++;
                 }


$listings ="
<form name=\"$this->form_name\" style=\"display:inline;\" >
<ul id=\"mycarousel\" class=\"multi-carousel jcarousel-skin-tango\">
$selected_image$photo_recs
</ul>
";


return $listings;

}


}
?>