<?php
session_start();
if (!isset($_SESSION['admin_access']))  {
exit;
}
$marker = $_REQUEST['marker'];
$aboutUs = $_REQUEST['aboutUs'];
$goingGreen = $_REQUEST['goingGreen'];
$visit = $_REQUEST['visit'];
$ownerInfo = $_REQUEST['ownerInfo'];
$mission = $_REQUEST['mission'];
$contact = $_REQUEST['contact'];
$photo = $_REQUEST['photo'];
$classes = $_REQUEST['classes'];
$schedule = $_REQUEST['schedule'];
$classDescriptions = $_REQUEST['classDescriptions'];
$instructors = $_REQUEST['instructors'];
$groupx = $_REQUEST['groupx'];
$spinning = $_REQUEST['spinning'];
$yoga = $_REQUEST['yoga'];
$boxing = $_REQUEST['boxing'];
$zumba = $_REQUEST['zumba'];
$pt = $_REQUEST['pt'];
$trainer = $_REQUEST['trainer'];
$package = $_REQUEST['package'];
$groupTrain = $_REQUEST['groupTrain'];
$trainInfo = $_REQUEST['trainInfo'];
$news = $_REQUEST['news'];
$newsSign = $_REQUEST['newsSign'];
$newsCanc = $_REQUEST['newsCanc'];
$viewNews = $_REQUEST['viewNews'];
$store = $_REQUEST['store'];
$clearence = $_REQUEST['clearence'];
$gear = $_REQUEST['gear'];
$catalog = $_REQUEST['catalog'];
$supp = $_REQUEST['supp'];
$navTextColor = $_REQUEST['navTextColor'];

include "linkBarOptionsSql.php";

//echo"a $aboutUs b $goingGreen c $ownerInfo d $mission e $visit";

if($marker == 1)  {
//set the general options
$set_links = new linkBarOptionsSql();
$set_links->setNavTextColor($navTextColor);
$set_links->setAboutUs($aboutUs);
$set_links->setGoingGreen($goingGreen);
$set_links->setScheduleVisit($visit);
$set_links->setOwnerInfo($ownerInfo);
$set_links->setMission($mission);
$set_links->setContact($contact);
$set_links->setPhoto($photo);
$set_links->setClasses($classes);
$set_links->setSchedule($schedule);
$set_links->setClassDescriptions($classDescriptions);
$set_links->setInstructors($instructors);
$set_links->setGroupX($groupx);
$set_links->setSpinning($spinning);
$set_links->setYoga($yoga);
$set_links->setBoxing($boxing);
$set_links->setZumba($zumba);
$set_links->setPT($pt);
$set_links->setTrainer($trainer);
$set_links->setPackage($package);
$set_links->setGroupTrain($groupTrain);
$set_links->setTrainInfo($trainInfo);
$set_links->setNews($news);
$set_links->setNewsSign($newsSign);
$set_links->setNewsCanc($newsCanc);
$set_links->setViewNews($viewNews);
$set_links->setStore($store);
$set_links->setClearence($clearence);
$set_links->setGear($gear);
$set_links->setCatalog($catalog);
$set_links->setSupp($supp);

$set_links->updateOptionLinkBar();
}

//echo "test uuu";
$set_links = new linkBarOptionsSql();
//first set the pay type first get the general perms
$set_links->loadOptionLinkBar();

$navTextColor = $set_links->getNavTextColor();
$aboutUs = $set_links->getAboutUs();
$goingGreen = $set_links->getGoingGreen();
$visit = $set_links->getScheduleVisit();
$ownerInfo = $set_links->getOwnerInfo();
$mission = $set_links->getMission();
$contact = $set_links->getContact();
$photo = $set_links->getPhoto();
$classes = $set_links->getClasses();
$schedule = $set_links->getSchedule();
$classDescriptions = $set_links->getClassDescriptions();
$instructors = $set_links->getInstructors();
$groupx = $set_links->getGroupX();
$spinning = $set_links->getSpinning();
$yoga = $set_links->getYoga();
$boxing = $set_links->getBoxing();
$zumba = $set_links->getZumba();
$pt = $set_links->getPT();
$trainer = $set_links->getTrainer();
$package = $set_links->getPackage();
$groupTrain = $set_links->getGroupTrain();
$trainInfo = $set_links->getTrainInfo();
$news = $set_links->getNews();
$newsSign = $set_links->getNewsSign();
$newsCanc = $set_links->getNewsCanc();
$viewNews = $set_links->getViewNews();
$store = $set_links->getStore();
$clearence = $set_links->getClearence();
$gear = $set_links->getGear();
$catalog = $set_links->getCatalog();
$supp = $set_links->getSupp();

//sets up the varibles for the form template
$submit_link = 'editLinkBarOptions.php';
$submit_name = 'save';
$page_title  = 'Update Link Bar Options';
$file_permissions = "";
$javaScript1 ="<script type=\"text/javascript\" src=\"webScripts/helpPops.js\"></script>";
$javaScript2 ="<script type=\"text/javascript\" src=\"webScripts/helpTxtLinkBarOptions.js\"></script>";
$javaScript3 = "<script type=\"text/javascript\" src=\"webScripts/linkBarOptions.js\"></script>";
//echo "test";

/*include "../infoText.php";
$getText = new infoText();
$getText -> setTextNum(24);
$info_text = $getText -> createTextInfo();*/

//include "../templates/infoTemplate2.php";
include "webTemplates/linkBarOptionsTemplate.php";
?>