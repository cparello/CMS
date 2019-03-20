<?php
session_start();


class  loginCheck{


//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}

function setButtonColor($color){
    $this->color = $color;
}

//-------------------------------------------------------------------------------------------------------------------
function checkLogin() {

if(!isset($_SESSION['userFirstName'])){
    $this->loginHtml = "<a href=\"memberLoginPage.php?member=1\" title=\"Member Sign-In\" target=\"\" class=\"more up bold\"><button class=\"buttonJoin$this->color buttonSize butColor\" name=\"login\" value=\"login\" type=\"buttonJoin$this->color\">Member Sign-In</button></a>";
}else{
    $name = $_SESSION['userFirstName'];
    $this->loginHtml = "Welcome $name! <br> <a href=\"memberLogout.php\" title=\"Member Logout\" target=\"\" class=\"more up bold\"><button class=\"buttonJoin$this->color buttonSize butColor\" name=\"logout\" value=\"logout\" type=\"buttonJoin$this->color\">Member Logout</button></a>";
}

}
//======================================================================================
function getLogHtml(){
    return($this->loginHtml);
}

    
}
//--------------------------------------------------------------------------------------

?>