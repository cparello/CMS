<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}

if(isset( $_POST['edit'])) {

     include "roomSql.php";
     $edit = new roomSql();
     $edit-> setRoomName($room_name);
     $edit-> setTypeId($type_id);
     $edit-> setRoomId($room_id);
     $edit-> updateRoom();

     $confirmation = "Class Room '$room_name' successfully updated to '$type_name'.";
         
}
//--------------------------------------------------------------------------------------------------------------------------------
if(isset( $_POST['delete'])) {

     include "roomSql.php";
     $delete = new roomSql();
     $delete-> setTypeId($type_id);
     $delete-> setRoomId($room_id);
     $delete-> deleteRoom();
     $delete_status = $delete-> getDeleteStatus();
     
      if($delete_status == 1) {
         $confirmation = "Class Room '$instructor_name' successfully deleted from '$type_name'.";
         }else{
         $confirmation = "There was an error deleting this class room";
         }

}

//--------------------------------------------------------------------------------------------------------------------------------

$javaScript1 ="<script type=\"text/javascript\" src=\"../scripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"../scripts/helpTxtCategory.js\"></script>";
$javaScript3 ="<script type=\"text/javascript\" src=\"../scripts/jqueryNew.js\"></script>";
$javaScript4 ="<script type=\"text/javascript\" src=\"../scripts/editRoomList.js\"></script>";
$javaScript5 ="<script type=\"text/javascript\" src=\"../scripts/roomConfirmation.js\"></script>";




 include "editRoomList.php";
 $list = new editRoomList();
 $list-> setTypeId($type_id);
 $list-> setTypeName($type_name);
 $list-> loadRecords();
 $drop_list = $list-> getDropList();
 $info_bit = 76;
 $page_title  = "Edit Class Rooms for $type_name";
 $page_template = "roomListTemplate.php";  

                         
//this is for the info bar
include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum($info_bit);
$info_text = $getText -> createTextInfo();
include "../templates/infoTemplate2.php";    

include "../templates/$page_template";
exit;






?>