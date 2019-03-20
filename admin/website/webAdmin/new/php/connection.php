<?php
session_start();

//DATABASE CONNECTION
//$dbMain = new mysqli('localhost','emsdata','6ym5yst3ms!','bac_admin'); 	
//if ($dbMain->connect_error) {
 //   die('Connect Error: ' . $dbMain->connect_error);
//}
include "../../../dbConnect.php";
//GET SHOPPING CART ITEM COUNT
$cart = $_SESSION['cart'];
$cartArray = explode('|',$cart);
$numberOfCartItems = count($cartArray);
$numberOfCartItems--;

//LOGIN STATUS CHECK
class loginCheck{
    function checkLogin() {
        if(!isset($_SESSION['userFirstName'])){
            $this->loginHtml = "<a href=\"memberLoginPage.php?member=1\" title=\"Member Sign-In\" target=\"\" class=\"more up bold\"><button class=\"buttonJoin$this->color buttonSize butColor\" name=\"login\" value=\"login\" type=\"buttonJoin$this->color\">Member Sign-In</button></a>";
        } else {
            $name = $_SESSION['userFirstName'];
            $this->loginHtml = "Welcome $name! <br> <a href=\"memberLogout.php\" title=\"Member Logout\" target=\"\" class=\"more up bold\"><button class=\"buttonJoin$this->color buttonSize butColor\" name=\"logout\" value=\"logout\" type=\"buttonJoin$this->color\">Member Logout</button></a> <br>  <a href=\"myAccount.php\" title=\"My Account\" target=\"\" class=\"more up bold\"><button class=\"buttonJoin$this->color buttonSize butColor\" name=\"myAccount\" value=\"My Account\" type=\"buttonJoin$this->color\">My Account</button></a>";
        }

    }
    function getLogHtml() {
        return($this->loginHtml);
    }
}

//LOAD WEBSITE PREFERENCES AND CLASSES
include 'preferences.php';

//LOGIN STATUS
$logCheck = new loginCheck();
$logCheck-> checkLogin();
$logHtml = $logCheck-> getLogHtml();
?>