<?php
class  bannerVars {


	//declare the banner vars
	private $banner_id = null;
	
	private $image_name = null;
	
	private $header_text = null ;
	private $header_top = null;
	private $header_left = null;
	private $header_right = null;
	private $header_font = null;	
	private $header_size = null;
	private $header_space = null;
	private $header_strength = null;	
	private $header_color = null;
	
	private $content_text = null;	
	private $content_top = null;
	private $content_left = null;
	private $content_right = null;
    private $content_font = null;
    private $content_size = null;
    private $content_space = null;
    private $content_strength = null;
    private $content_color = null;    
    
    public $banner_name = null;  
    private $banner_link = null;     

 	function setIBannerId($id = null)  {
		if(isset($id)) {
			$this->banner_id = $id;
			}
	}
 
 
 
 //set functions for private class members
 
	function setImageName($id = null)  {
		if(isset($id)) {
			$this->image_name = $id;
			}
	}

//sets the banner name and link
	function setBannerName($id = null)  {
		if(isset($id))  {
		 $this->banner_name = $id;
		  }
	}	
	function setBannerLink($id = null)  {
		if(isset($id))  {
		 $this->banner_link = $id;
		  }
	}		
//setters for header text	
	function setHeaderText($id = null)  {
		if(isset($id))  {
		 $this->header_text = $id;
		  }
	}
 
	function setHeaderTop($id = null)  {
		if(isset($id))  {
		 $this->header_top = $id;
		  }
	} 
    
	function setHeaderLeft($id = null)  {
		if(isset($id))  {
		 $this->header_left = $id;
		  }
	} 
	
	function setHeaderRight($id = null)  {
		if(isset($id))  {
		 $this->header_right = $id;
		  }
	} 	
	
	function setHeaderFont($id = null)  {
		if(isset($id))  {
		 $this->header_font = $id;
		  }
	} 	
	
	function setHeaderSize($id = null)  {
		if(isset($id))  {
		 $this->header_size = $id;
		  }
	} 	
	
	function setHeaderSpace($id = null)  {
		if(isset($id))  {
		 $this->header_space = $id;
		  }
	} 	
	
	function setHeaderStrength($id = null)  {
		if(isset($id))  {
		 $this->header_strength = $id;
		  }
	} 	
	
	function setHeaderColor($id = null)  {
		if(isset($id))  {
		 $this->header_color = $id;
		  }
	} 

//setters for the contentent

	function setContentText($id = null)  {
		if(isset($id))  {
		 $this->content_text = $id;
		  }
	}
 
	function setContentTop($id = null)  {
		if(isset($id))  {
		 $this->content_top = $id;
		  }
	} 
    
	function setContentLeft($id = null)  {
		if(isset($id))  {
		 $this->content_left = $id;
		  }
	} 
	
	function setContentRight($id = null)  {
		if(isset($id))  {
		 $this->content_right = $id;
		  }
	} 	
	
	function setContentFont($id = null)  {
		if(isset($id))  {
		 $this->content_font = $id;
		  }
	} 	
	
	function setContentSize($id = null)  {
		if(isset($id))  {
		 $this->content_size = $id;
		  }
	} 	
	
	function setContentSpace($id = null)  {
		if(isset($id))  {
		 $this->content_space = $id;
		  }
	} 	
	
	function setContentStrength($id = null)  {
		if(isset($id))  {
		 $this->content_strength = $id;
		  }
	} 	
	
	function setContentColor($id = null)  {
		if(isset($id))  {
		 $this->content_color = $id;
		  }
	} 

//------------------------------------------------------------------------------------------------------------------------------
//now set the getter functions
	function getBannerName() {
		return($this->banner_name);
	}
	
	function getBannerLink() {
		return($this->banner_link);
	}

	function getBannerId() {
		return($this->banner_id);
	}
	
	function getImageName() {
		return($this->image_name);
	}

	
//gets for the header text	
	
	function getHeaderText() {
		return($this->header_text);
	}

	function getHeaderTop() {
		return($this->header_top);
	}
	
	function getHeaderLeft() {
		return($this->header_left);
	}	
	
	function getHeaderRight() {
		return($this->header_right);
	}	
		
	function getHeaderFont() {
		return($this->header_font);
	}		
	
	function getHeaderSize() {
		return($this->header_size);
	}		
	
	function getHeaderSpace() {
		return($this->header_space);
	}		
	
	function getHeaderStrength() {
		return($this->header_strength);
	}		
	
	function getHeaderColor() {
		return($this->header_color);
	}		
	
	
//gets for the content text	
		function getContentText() {
		return($this->content_text);
	}

	function getContentTop() {
		return($this->content_top);
	}
	
	function getContentLeft() {
		return($this->content_left);
	}	
	
	function getContentRight() {
		return($this->content_right);
	}	
		
	function getContentFont() {
		return($this->content_font);
	}		
	
	function getContentSize() {
		return($this->content_size);
	}		
	
	function getContentSpace() {
		return($this->content_space);
	}		
	
	function getContentStrength() {
		return($this->content_strength);
	}		
	
	function getContentColor() {
		return($this->content_color);
	}		
//-------------------------------------------------------------------------------------------------------------------------------------	
function save( $newbannerVars = false ) {
    //echo "fubar11";
		/* Connect to a MySQL server */
		include "../../../dbConnect.php";
		//$mysqli = $this->dbconnect();
		
		//If the report should be saved as a new report than set the report_id to null
		if($newbannerVars == true ) {
			$this->banner_id = null;
		   }
			
		$sql = "INSERT INTO web_banner_ads VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,  ?, ?, ?, ?,  ?, ?)";
		$stmt = $dbMain ->prepare($sql);
		$stmt->bind_param('issssiiisiiissiiisiiis',  
						$banner_id,
						$banner_name, 
						$banner_link, 
						$image_name, 
						$header_text, 
						$header_top, 
						$header_left, 
						$header_right, 
						$header_font, 
						$header_space, 
						$header_size, 
						$header_strength, 
						$header_color, 
						$content_text, 
						$content_top, 
						$content_left, 
						$content_right, 
						$content_font, 
						$content_space, 
						$content_size, 
						$content_strength, 
						$content_color 
					); 
		
		//setting values from the global values
		$banner_name = $this->banner_name; 
		$banner_link = $this->banner_link; 
		$image_name = $this->image_name; 
		$header_text = $this->header_text; 
		$header_top = $this->header_top; 
		$header_left = $this->header_left; 
		$header_right = $this->header_right; 
		$header_font = $this->header_font; 
		$header_space = $this->header_space; 
		$header_size = $this->header_size; 
		$header_strength = $this->header_strength; 
		$header_color = $this->header_color; 
		$content_text = $this->content_text; 
		$content_top = $this->content_top; 
		$content_left = $this->content_left; 
		$content_right = $this->content_right; 
		$content_font = $this->content_font; 
		$content_space = $this->content_space; 
		$content_size = $this->content_size; 
		$content_strength = $this->content_strength; 
		$content_color = $this->content_color; 

		
		/* execute prepared statement */
		if(!$stmt->execute()) {
			printf("Error: %s.\n", $stmt->error);
	     	}
		
		//set the report id to the last ran query 
		$this->banner_id = $stmt->insert_id;
		

		/* close statement and connection */
		$stmt->close(); 
		
	}
		//=========================================================================	
	//Given a banner ID should Query the Report table and set all the local variables
	function load($banner_id)    {
		// Connect to a MySQL server */
		include "../../../dbConnect.php";
		
		// prepare statement
		$stmt = $dbMain->prepare( "SELECT * FROM web_banner_ads WHERE banner_id = ?" );
		$stmt->bind_param('i', $banner_id);
		
		// bind variables to prepared statement
		$stmt->bind_result( $banner_id,
						$banner_name, 
						$banner_link, 
						$image_name, 
						$header_text, 
						$header_top, 
						$header_left, 
						$header_right, 
						$header_font, 
						$header_space, 
						$header_size, 
						$header_strength, 
						$header_color, 
						$content_text, 
						$content_top, 
						$content_left, 
						$content_right, 
						$content_font, 
						$content_space, 
						$content_size, 
						$content_strength, 
						$content_color 
		);
		
		$stmt->execute() or die ("Could not execute statement");
		$stmt->store_result();
		
		//check the number of rows returned id not 1 the report D.N.E.
		if( $stmt->num_rows == 0) {
			printf("ERROR: Report does not Exisit \n");
		    }else{
		    
			$stmt->fetch();
		
		 $this->banner_id = $banner_id;
		 $this->banner_name = $banner_name; 
		 $this->banner_link = $banner_link; 
	     $this->image_name = $image_name; 
		 $this->header_text = $header_text; 
		 $this->header_top = $header_top; 
		 $this->header_left = $header_left; 
		 $this->header_right = $header_right; 
		 $this->header_font = $header_font; 
		 $this->header_space = $header_space; 
		 $this->header_size = $header_size; 
		 $this->header_strength = $header_strength; 
		 $this->header_color = $header_color; 
		 $this->content_text = $content_text; 
		 $this->content_top = $content_top; 
		 $this->content_left = $content_left; 
		 $this->content_right = $content_right; 
		 $this->content_font = $content_font; 
		 $this->content_space = $content_space; 
		 $this->content_size = $content_size; 
		 $this->content_strength = $content_strength; 
		 $this->content_color = $content_color; 
			
			
		}
		$stmt->close();
		/* close connection */
		//$dbMain->close(); 
	}
	
//=========================================================================
//This update the query
	function upDate()  {
	   //echo "fubar";	
		include "../../../dbConnect.php";
        
      	 $banner_name = $this-> banner_name; 
		 $banner_link = $this-> banner_link; 
	     $image_name = $this-> image_name; 
		 $header_text = $this-> header_text; 
		 $header_top = $this-> header_top; 
		 $header_left = $this-> header_left; 
		 $header_right = $this-> header_right; 
		 $header_font = $this-> header_font; 
		 $header_space = $this->header_space; 
		 $header_size = $this-> header_size; 
		 $header_strength = $this-> header_strength; 
		 $header_color = $this->header_color; 
		 $content_text = $this->content_text; 
		 $content_top = $this->content_top; 
		 $content_left = $this-> content_left; 
		 $content_right = $this-> content_right; 
		 $content_font = $this-> content_font; 
		 $content_space = $this-> content_space; 
		 $content_size = $this->content_size; 
		 $content_strength = $this-> content_strength; 
		 $content_color = $this->content_color; 
    	$banner_id = $this-> banner_id;
        
		$sql = "UPDATE web_banner_ads SET  banner_name =?, banner_link =?,   banner_image =?,banner_header =?, header_top =?,header_left =?, header_right =?, header_font =?, header_space =?, header_size =?,header_strength =?,header_color =?, banner_content =?, content_top =?, content_left =?,content_right =?, content_font =?, content_space =?, content_size =?,content_strength =?,content_color =? WHERE banner_id = ?";
		
		$stmt = $dbMain->prepare($sql);
		echo($dbMain->error);
		$stmt->bind_param('ssssiiisiiissiiisiiisi',  $banner_name, $banner_link, $image_name, $header_text, $header_top,$header_left, $header_right, $header_font, 	$header_space,	$header_size, $header_strength,$header_color,$content_text, $content_top, $content_left, $content_right, $content_font,$content_space, $content_size, $content_strength, $content_color, $banner_id);	
		if(!$stmt->execute()) {
			printf("Error: %s.\n", $stmt->error);
		}
		
	//	 printf("rows inserted: %d\n", $stmt->affected_rows);
		
		/* close statement and connection */
		$stmt->close(); 
		
	//	echo "$banner_name";
		
	}		

//=============================================================================		
	//This should delete the query
	function delete()   {	
		//deletes the report that is loaded
		include "../../../dbConnect.php";
		
		$sql = "DELETE FROM web_banner_ads WHERE banner_id = ? LIMIT 1";
		
		if ($stmt = $dbMain->prepare($sql))    {
			$stmt->bind_param("i", $this->banner_id);
			$stmt->execute();
			
			$stmt->close();
			
		}else{
			 printf("Errormessage: %s\n", $dbMain->error);
			die("Could not prepare SQL statement: $sql");
		}
		
	}
		
		
		
		
		
//=============================================================================	
}
?>