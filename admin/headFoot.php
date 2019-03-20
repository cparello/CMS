<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

class  headFoot {

//set the header date and business name
	private $footerDate;
	private $businessName;
    private $businessNickName;
//    private $copyWriteName = "Essential Management Systems Inc.";
    private $copyWriteName = "MantisTree";

function setFooterDate($footerDate)  {
		$this->footer_date = $footerDate;
		  }

function setBusinessName($businessName)  {
		 $this->business_name = $businessName;
		  }

function setBusinessNickName($businessNickName)  {
		 $this->business_nick_name = $businessNickName;
		  }


 

//Gets the footer Date
function getFooterDate()   {  
      $footerDate = date(Y);
      $this->footer_date = $footerDate;   
		return($this->footer_date);
    	}
    	   	
//load the Business names
function loadNames()   { 
global $dbMain;
 $result1 = $dbMain ->query("SELECT * FROM company_names WHERE business_name !='' "); 
           $row1 = $result1 ->fetch_array(MYSQLI_NUM);
           $businessName = $row1[0];
           $businessNickName = $row1[1];
           $this->business_nick_name = $businessNickName; 
           $this->business_name = $businessName;         
}



function getBusinessNickName()    {
      return($this->business_nick_name);
     }


function getBusinessName()    {
      return($this->business_name);
     }

function getCopyWriteName() {
       return($this->copyWriteName);
       }


}


?>