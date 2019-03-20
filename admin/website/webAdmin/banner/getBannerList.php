<?php
class  getBannerList {

public $banner_name;

	function setBannerName($banner_name)  {
		 $this->banner_name = $banner_name;
		  }
		  
    function getBannerName()   {
		return($this->banner_name);
    	}
	
//---------------------------------------------------------------------------------------------------------------------------------------------------
function getBannerDrop()  {
include "../../../dbConnect.php";
//get drop down
$i =0;
$result1 = $dbMain ->query("SELECT banner_id, banner_name  FROM web_banner_ads  WHERE banner_id != '0' "); 
$num_results1 =  $result1 ->num_rows;
    
for($i=0; $i < $num_results1; $i++)  {
    $row1 = $result1 ->fetch_array(MYSQLI_NUM);
    $banner_id = $row1[0];
    $banner_name = $row1[1];
       
    $drop_down .="<option value=\"$banner_id\">$banner_name\n";    
  }     

$drop_list = "<select name = \"banner_id\" id=\"banner_id\">\n$drop_down</select>";

return  $drop_list;
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function setLive($banner_id)      {
include "../../../dbConnect.php";


$result1 = $dbMain ->query("SELECT  banner_name, banner_link, banner_image, banner_header, header_top, header_left, header_right, header_font, header_space, header_size, header_strength, header_color,  banner_content, content_top, content_left,  content_right, content_font, content_space, content_size, content_strength, content_color  FROM web_banner_ads  WHERE banner_id = '$banner_id' "); 
$num_results1 =  $result1 ->num_rows;
$row1 = $result1 ->fetch_array(MYSQLI_NUM);

$banner_name = $row1[0];
$banner_link  = $row1[1];
$banner_image = $row1[2];
$banner_header = $row1[3];
$header_top = $row1[4];
$header_left = $row1[5];
$header_right = $row1[6];
$header_font  = $row1[7]; 
$header_space = $row1[8]; 
$header_size = $row1[9];
$header_strength = $row1[10];
$header_color = $row1[11];
$banner_content = $row1[12];
$content_top = $row1[13];
$content_left = $row1[14];
$content_right = $row1[15]; 
$content_font = $row1[16];
$content_space  = $row1[17];
$content_size = $row1[18];
$content_strength = $row1[19];
$content_color = $row1[20];  

$set_live = 'y';

	$sql = "UPDATE web_current_ad SET 
	   banner_id =?,
       banner_name =?,
       banner_link =?, 
       banner_image =?,
       banner_header =?, 
       header_top =?,
       header_left =?,
       header_right =?,
       header_font =?,
       header_space =?,
       header_size =?,
       header_strength =?,
       header_color =?,
       banner_content =?,             
       content_top =?,
       content_left =?,
       content_right =?,
       content_font =?,
       content_space =?,
       content_size =?,
       content_strength =?,
       content_color =?,
       live = ?
	  WHERE live = ?";
		
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('issssiiisiiissiiisiiisss',  
$banner_id,		
$banner_name,
$banner_link,
$banner_image,
$banner_header,
$header_top,
$header_left,
$header_right,
$header_font,
$header_space,
$header_size,
$header_strength,
$header_color,
$banner_content,
$content_top,
$content_left,
$content_right,
$content_font,
$content_space,
$content_size,
$content_strength,
$content_color, 
$set_live,
$set_live
					);	
		
if(!$stmt->execute()) {
			printf("Error: %s.\n", $stmt->error);
		}
		
		// printf("rows inserted: %d\n", $stmt->affected_rows);
		
		/* close statement and connection */
		$stmt->close(); 

  $this-> banner_name = $banner_name;

}
//-----------------------------------------------------------------------------------------------------------------------------------------------



}
?>