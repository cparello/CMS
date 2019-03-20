<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}


class linkBarOptionsSql {
    
function setNavTextColor($navTextColor){
        $this->navTextColor = $navTextColor;
}
function setAboutUs($aboutUs){
        $this->aboutUs = $aboutUs;
}
function setGoingGreen($goingGreen){
        $this->goingGreen = $goingGreen;
}
function setScheduleVisit($visit){
        $this->visit = $visit;
}
function setOwnerInfo($ownerInfo){
        $this->ownerInfo = $ownerInfo;
}
function setMission($mission){
        $this->mission = $mission;
}
function setContact($contact){
        $this->contact = $contact;
}
function setPhoto($photo){
        $this->photo = $photo;
}
function setClasses($classes){
        $this->classes = $classes;
}
function setSchedule($schedule){
        $this->schedule = $schedule;
}
function setClassDescriptions($classDescriptions){
        $this->classDescriptions = $classDescriptions;
}
function setInstructors($instructors){
        $this->instructors = $instructors;
}
function setGroupX($groupx){
        $this->groupx = $groupx;
}
function setSpinning($spinning){
        $this->spinning = $spinning;
}
function setYoga($yoga){
        $this->yoga = $yoga;
}
function setBoxing($boxing){
        $this->boxing = $boxing;
}
function setZumba($zumba){
        $this->zumba = $zumba;
}
function setPT($pt){
        $this->pt = $pt;
}
function setTrainer($trainer){
        $this->trainer = $trainer;
}
function setPackage($package){
        $this->package = $package;
}
function setGroupTrain($groupTrain){
        $this->groupTrain = $groupTrain;
}
function setTrainInfo($trainInfo){
        $this->trainInfo = $trainInfo;
}
function setNews($news){
        $this->news = $news;
}
function setNewsSign($newsSign){
        $this->newsSign = $newsSign;
}
function setNewsCanc($newsCanc){
        $this->newsCanc = $newsCanc;
}
function setViewNews($viewNews){
        $this->viewNews = $viewNews;
}
function setStore($store){
        $this->store = $store;
}
function setClearence($clearence){
        $this->clearence = $clearence;
}
function setGear($gear){
        $this->gear = $gear;
}
function setCatalog($catalog){
        $this->catalog = $catalog;
}
function setSupp($supp){
        $this->supp = $supp;
}

//connect to database
function dbconnect()   {
require"../../dbConnect.php";
return $dbMain;
}


//------------------------------------------------------------------------------------------------------------------
function loadOptionLinkBar()   {

//create a confirmation message for errors
$this->confirmation_message = "There was an error selecting these payment options";

$dbMain = $this->dbconnect();

 $stmt = $dbMain ->prepare("SELECT nav_text_color, about_us, going_green, visit, owner_info, our_mission, contact, photo, classes, schedule, class_descriptions, instructors, group_fitness, spin, yoga, boxing, zumba, pt, trainers, packages, small_group, train_info, news, sign_up, cancel, view, store, clearence, gear, catalog, supps FROM web_link_bar_options WHERE web_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($this->navTextColor, $this->aboutUs, $this->goingGreen, $this->visit, $this->ownerInfo, $this->mission, $this->contact, $this->photo, $this->classes, $this->schedule, $this->classDescriptions, $this->instructors, $this->groupx ,$this->spinning , $this->yoga,$this->boxing ,$this->zumba ,$this->pt,  $this->trainer,    $this->package,$this->groupTrain,$this->trainInfo,$this->news,$this->newsSign, $this->newsCanc,  $this->viewNews, $this->store, $this->clearence , $this->gear, $this->catalog, $this->supp ); 
   $stmt->fetch();
}
//----------------------------------------------------------------------------------------------------------------
function updateOptionLinkBar()   {

$dbMain = $this->dbconnect();
$sql = "UPDATE web_link_bar_options SET nav_text_color=?, about_us=?, going_green=?, visit=?, owner_info=?, our_mission=?, contact=?, photo=?, classes=?,  schedule=?, class_descriptions=?, instructors=?, group_fitness=?, spin=?, yoga=?, boxing=?, zumba=?, pt=?, trainers=?, packages=?, small_group=?, train_info=?, news=?, sign_up=?, cancel=?, view=?, store=?, clearence=?, gear=?, catalog=?, supps=? WHERE web_key ='1'";
   $stmt = $dbMain->prepare($sql);
   $stmt->bind_param('sssssssssssssssssssssssssssssss' , $this->navTextColor, $this->aboutUs, $this->goingGreen, $this->visit, $this->ownerInfo, $this->mission, $this->contact, $this->photo, $this->classes,  $this->schedule, $this->classDescriptions, $this->instructors, $this->groupx ,$this->spinning , $this->yoga,$this->boxing ,$this->zumba ,$this->pt,  $this->trainer,    $this->package,$this->groupTrain,$this->trainInfo,$this->news,$this->newsSign, $this->newsCanc,  $this->viewNews, $this->store, $this->clearence , $this->gear, $this->catalog, $this->supp);
   
  if(!$stmt->execute())  {
    $this->confirmationMessage = 'There was an Error updating these Payment Options';
	printf("Error: %s.\n", $stmt->error);
   }else{
   $this->confirmationMessage = 'Payment Options Successfully Updated';
   }

}
//----------------------------------------------------------------------------------------------------------------

function getNavTextColor(){
        return($this->navTextColor);
}
function getAboutUs(){
        return($this->aboutUs);
}
function getGoingGreen(){
        return($this->goingGreen);
}
function getScheduleVisit(){
        return($this->visit);
}
function getOwnerInfo(){
        return($this->ownerInfo);
}
function getMission(){
        return($this->mission);
}
function getContact(){
        return($this->contact);
}
function getPhoto(){
        return($this->photo);
}
function getClasses(){
        return($this->classes);
}
function getSchedule(){
        return($this->schedule);
}
function getClassDescriptions(){
        return($this->classDescriptions);
}
function getInstructors(){
        return($this->instructors);
}
function getGroupX(){
        return($this->groupx);
}
function getSpinning(){
        return($this->spinning);
}
function getYoga(){
        return($this->yoga);
}
function getBoxing(){
        return($this->boxing);
}
function getZumba(){
        return($this->zumba);
}
function getPT(){
        return($this->pt);
}
function getTrainer(){
        return($this->trainer);
}
function getPackage(){
        return($this->package);
}
function getGroupTrain(){
        return($this->groupTrain);
}
function getTrainInfo(){
        return($this->trainInfo);
}
function getNews(){
        return($this->news);
}
function getNewsSign(){
        return($this->newsSign);
}
function getNewsCanc(){
        return($this->newsCanc);
}
function getViewNews(){
        return($this->viewNews);
}
function getStore(){
        return($this->store);
}
function getClearence(){
        return($this->clearence);
}
function getGear(){
        return($this->gear);
}
function getCatalog(){
        return($this->catalog);
}
function getSupp(){
        return($this->supp);
}


}
?>