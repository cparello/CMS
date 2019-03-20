<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

include "userSql.php";
require"dbConnect.php";
//shows the copyright at bottom of page
$footer_admin = $_SESSION['footer_admin'];
$first_name = $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$accesslevel = $_REQUEST['accesslevel'];
$userId = $_REQUEST['userId'];
$marker = $_REQUEST['marker'];




   

    
    





if($marker == 1)  {

$checkIn = $_REQUEST['checkinHID'];
    $memInt = $_REQUEST['memintHID'];
    $sales = $_REQUEST['salesHID'];
    $admin = $_REQUEST['adminHID'];
    $schedule = $_REQUEST['scheduleHID'];
    $billing = $_REQUEST['billingHID'];


echo "$schedule";


$accesslevel = $_SESSION['access_level'];

$updateUser = new userSql();
$updateUser -> setFirstName($first_name);
$updateUser -> setLastName($last_name);
$updateUser -> setUserName($username);
$updateUser -> setPassWord($password);
$updateUser -> setAccessLevel($accesslevel);
$updateUser -> setUserId($userId);
$updateUser -> setCheck($checkIn);
$updateUser -> setMember($memInt);
$updateUser -> setSales($sales);
$updateUser -> setAdmin($admin);
$updateUser -> setSchedule($schedule);
$updateUser -> setBilling($billing);
$confirmation = $updateUser ->updateUser();


//sets up the varibles for the form template
$submit_link = 'editUser.php';
$submit_name = 'update';
$page_title  = "Edit User $first_name $last_name";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"scripts/login3.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"scripts/helpTxtUsers.js\"></script>";
$hidden = "<input type=\"hidden\" name=\"userId\" value=\"$userId\" />";

include "getLinks.php";
//get checkboxes
$getMenu = new getLinks();
$getMenu -> setFilePerms($accesslevel);
$getMenu -> loadMenus();
$handle =  $getMenu -> getCheckBox();


 $result1 = $dbMain ->prepare("SELECT check_in, mem_int, admin, sales, sales_schedule, billing FROM access_app WHERE user_id ='$userId'");
    $result1-> execute();      
    $result1-> store_result(); 
    $result1-> bind_result($checkIn , $memInt, $admin, $sales, $schedule, $billing);
    $result1-> fetch();
    $result1-> close();
    
    if($checkIn == "Y"){
        $checkedCheckin = "checked";
    }else{
         $checkedCheckin = "";
    }
    if($memInt == "Y"){
        $checkedMemint = "checked";
    } else{
         $checkedMemint = "";
    }
    if($sales == "Y"){
        $checkedSales = "checked";
    } else{
         $checkedSales = "";
    }
    if($admin == "Y"){
        $checkedAdmin = "checked";
    } else{
         $checkedAdmin = "";
    }
    if($schedule == "Y"){
        $checkedSched = "checked";
    } else{
         $checkedSched = "";
    }
    if($billing == "Y"){
        $checkedBill = "checked";
    } else{
         $checkedBill = "";
    }
include "templates/userTemplate.php";

}

//===============================================================

//check to see if this is an edit or a delete
if (isset($_POST['edit']))       {

//sets up the varibles for the form template
$submit_link = 'editUser.php';
$submit_name = 'update';
$page_title  = "Edit User $first_name $last_name";
$file_permissions = "";
$javaScript1 = "<script type=\"text/javascript\" src=\"scripts/login3.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"scripts/helpPops.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"scripts/helpTxtUsers.js\"></script>";
$hidden = "<input type=\"hidden\" name=\"userId\" value=\"$userId\" />";


include "getLinks.php";

//echo"$access_level";
//exit;

//get checkboxes
$getMenu = new getLinks();
$getMenu -> setFilePerms($accesslevel);
$getMenu -> loadMenus();
$handle =  $getMenu -> getCheckBox();


 $result1 = $dbMain ->prepare("SELECT check_in, mem_int, admin, sales, sales_schedule, billing FROM access_app WHERE user_id ='$userId'");
    $result1-> execute();      
    $result1-> store_result(); 
    $result1-> bind_result($checkIn , $memInt, $admin, $sales, $schedule, $billing);
    $result1-> fetch();
    $result1-> close();
    
    if($checkIn == "Y"){
        $checkedCheckin = "checked";
    }else{
         $checkedCheckin = "";
    }
    if($memInt == "Y"){
        $checkedMemint = "checked";
    } else{
         $checkedMemint = "";
    }
    if($sales == "Y"){
        $checkedSales = "checked";
    } else{
         $checkedSales = "";
    }
    if($admin == "Y"){
        $checkedAdmin = "checked";
    } else{
         $checkedAdmin = "";
    }
    if($schedule == "Y"){
        $checkedSched = "checked";
    } else{
         $checkedSched = "";
    }
    if($billing == "Y"){
        $checkedBill = "checked";
    } else{
         $checkedBill = "";
    }
include "templates/userTemplate.php";



}

//===================================================================================
if (isset($_POST['delete']))       {

$deleteUser = new userSql();
$deleteUser -> setFirstName($first_name);
$deleteUser -> setLastName($last_name);
$deleteUser -> setUserId($userId);

$confirmation = $deleteUser -> deleteUser();



//set the search type to three which is all
$search_type = "3";

include "userLists.php";
$getLists = new userLists();
$getLists -> setSearchType($search_type);
$getLists -> loadRecords(); 
$result1 = $getLists -> getDropList();

//check tp see if there are multi results or not
if($result1 != "") {
include "templates/userListsTemplate.php";
exit;
}


}




?>