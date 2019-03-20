<?php

include"../../dbConnect.php";


$stmt = $dbMain ->prepare("SELECT nav_text_color, about_us, going_green, visit, owner_info, our_mission, classes, schedule, class_descriptions, group_fitness, spin, yoga, boxing, zumba, pt, trainers, packages, small_group, train_info, news, sign_up, cancel, view, store, clearence, gear, catalog, supps FROM web_link_bar_options WHERE web_key = '1'");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($navTextColor, $aboutUs, $goingGreen, $visit, $ownerInfo, $mission, $classes, $schedule, $class_descriptions, $groupx ,$spinning , $yoga,$boxing ,$zumba ,$pt,  $trainer,    $package,$groupTrain,$trainInfo,$news,$newsSign, $newsCanc,  $viewNews, $store, $clearence , $gear, $catalog, $supp); 
   $stmt->fetch();

if ($goingGreen == 'Yes'){
    $greenHtml = "<li><a href=\"greenCompanyPage.php\" target=\"\" title=\"Going Green\">
                    We are Paperless!</a></li>";
}else{ 
    $greenHtml = "";
                    }
if ($ownerInfo == 'Yes'){
    $ownerInfoHtml = "<li><a href=\"ownerInfoPage.php\" target=\"\" title=\"Owner Info\">
                    Owner Info</a></li>";
}else{ 
    $ownerInfoHtml = "";
                    }
                    
if ($visit == 'Yes'){
    $visitHtml = "<li><a href=\"scheduleVisitPage.php\" target=\"\" title=\"Schedule A Visit\">
                    Schedule A Visit</a></li>";
}else{ 
    $visitHtml = "";
                    }
if ($mission == 'Yes'){
    $missionHtml = "<li><a href=\"companyMissionPage.php\" target=\"\" title=\"Our Mission\">
                    Our Mission</a></li>";
}else{ 
    $missionHtml = "";
                    }
                    
  if($aboutUs == 'Yes'){
    $aboutHtml = "<li class=\"nav-title\">
            <a href=\"companyMissionPage.php\" target=\"\" title=\"About\"
                id=\"nav-about\" class=\"hot-spot\">
                About Us
            </a>
            
            <ul class=\"sub-nav\">
            
                $ownerInfoHtml
                
                $greenHtml
                
                $visitHtml
                
                $missionHtml
                
                <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
            </ul>


        </li>";
  }else{
    $aboutHtml = "";
  }


if ($schedule == 'Yes'){
    $scheduleHtml =  "<li><a href=\"schedulePage.php\" target=\"\" title=\"Schedule\">
        Schedule</a></li>";
}else{
    $scheduleHtml = "";
}
if ($class_descriptions == 'Yes'){
    $classDescriptionsHtml =  "<li><a href=\"classDescriptionsSelectorPage.php\" target=\"\" title=\"Class Descriptions\">
        Class Descriptions</a></li>";
}else{
    $classDescriptionsHtml = "";
}


if ($groupx == 'Yes'){
    $groupHtml =  "<li><a href=\"/groupx\" target=\"\" title=\"Group Fitness\">
        Group Fitness</a></li>";
}else{
    $groupHtml = "";
}
if ($spinning == 'Yes'){
    $spinHtml =  "<li><a href=\"/spin\" target=\"\" title=\"Spinning\">
        Spinning</a></li>";
}else{
    $spinHtml = "";
}

if ($yoga == 'Yes'){
    $yogaHtml =  "<li><a href=\"/yoga\" target=\"\" title=\"Yoga\">
        Yoga</a></li>";
}else{
    $yogaHtml = "";
}

if ($boxing == 'Yes'){
    $boxingHtml =  "<li><a href=\"/boxing\" target=\"\" title=\"Boxing\">
        Boxing</a></li>";
}else{
    $boxingHtml = "";
}

if ($zumba == 'Yes'){
    $zumbaHtml =  "<li><a href=\"/zumba\" target=\"\" title=\"Zumba\">
        Zumba</a></li>";
}else{
    $zumbaHtml = "";
}

if ($classes == 'Yes'){
  $classesHtml =  "<li class=\"nav-title\"><a href=\"schedulePage.php\" target=\"\" title=\"Fitness\"
            id=\"nav-fitness\" class=\"hot-spot\">
            Classes
        </a>
            
<ul class=\"sub-nav\">
    
    $scheduleHtml
    
    $classDescriptionsHtml
    
    $groupHtml
    
    $zumbaHtml
    
    $spinHtml
    
    $boxingHtml
    
    $yogaHtml
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>


        </li>";
}else{
    $classesHtml = "";
}

if ($trainer == 'Yes'){
    $trainerHtml =  "<li><a href=\"trainerLocationSelectorPage.php\" target=\"\" title=\"Trainers\">
        Trainers</a></li>";
}else{
    $trainerHtml = "";
}
if ($package == 'Yes'){
    $packagesHtml =  "<li><a href=\"trainerPackageBuyPage.php\" target=\"\" title=\"Training Packages\">
        Training Packages</a></li>";
}else{
    $packagesHtml = "";
}
if ($groupTrain == 'Yes'){
    $groupTrainHtml =  "<li><a href=\"/groupTrain\" target=\"\" title=\"Group Training\">
        Group Training</a></li>";
}else{
    $groupTrainHtml = "";
}
if ($trainInfo == 'Yes'){
    $trainInfoHtml =  "<li><a href=\"/packages\" target=\"\" title=\"Training Information\">
        Training Information</a></li>";
}else{
    $trainInfoHtml = "";
}
if($pt == 'Yes'){
    $ptHtml = "<li class=\"nav-title\"><a href=\"/life\" target=\"\" title=\"Life\"
            id=\"nav-life\" class=\"hot-spot\">
            Personal Training
        </a>
            
<ul class=\"sub-nav\">


    $trainerHtml
    $packagesHtml
    $groupTrainHtml
    $trainInfoHtml
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>


        </li>";
}else{
    $ptHtml = "";
}

 
if ($newsSign == 'Yes'){
    $newsSignHtml =  "  <li><a href=\"/newsSignup\" target=\"\" title=\"Signup for The Newsletter\">
        Signup for The Newsletter</a></li>";
}else{
    $newsSignHtml = "";
}
if ($newsCanc == 'Yes'){
    $newsCancHtml =  "  <li><a href=\"/newsCancel\" target=\"\" title=\"Cancel The Newsletter\">
        Cancel The Newsletter</a></li>";
}else{
    $newsCancHtml = "";
}
if ($viewNews == 'Yes'){
    $viewNewsHtml =  "  <li><a href=\"/newsCancel\" target=\"\" title=\"View The Newsletter\">
        View The Newsletter</a></li>";
}else{
    $viewNewsHtml = "";
}
if($news == 'Yes'){
    $newsHtml = "<li class=\"nav-title\"><a href=\"/myeq2\" target=\"\" title=\"Members\"
            id=\"nav-members\" class=\"hot-spot\">
            News Letter
        </a>
            
<ul class=\"sub-nav\">
    
  $newsSignHtml
  
  $newsCancHtml
  
  $viewNewsHtml
    
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>
        </li>";
}else{
    $newsHtml = "";
}

if ($clearence == 'Yes'){
    $clearenceHtml =  "<li><a href=\"/clearance\" target=\"\" title=\"Clearance\">
        Clearance</a></li>";
}else{
    $clearenceHtml = "";
}
if ($gear == 'Yes'){
    $gearHtml =  "  <li><a href=\"/gear\" target=\"\" title=\"Club Gear\">
        Club Gear</a></li>";
}else{
    $gearHtml = "";
}
if ($catalog == 'Yes'){
    $catalogHtml =  "  <li><a href=\"/catalog\" target=\"\" title=\"Catalog\">
        Catalog</a></li>";
}else{
    $catalogHtml = "";
}
if ($supp == 'Yes'){
    $suppHtml =  "  <li><a href=\"/supplements\" target=\"\" title=\"Supplements\">
        Supplements</a></li>";
}else{
    $suppHtml = "";
}
if ($store == 'Yes'){
    $storeHtml = "<li class=\"nav-title\"><a href=\"storePage.php\" target=\"\" title=\"Members\"
            id=\"nav-members\" class=\"hot-spot\">
            Store
        </a>
            
<ul class=\"sub-nav\">
    
     $clearenceHtml
        
        $gearHtml
        
        $catalogHtml
        
        $suppHtml
    
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>
       
        </li>";
}else{
    $storeHtml = "";
}

   $stmt = $dbMain ->prepare("SELECT club_name FROM club_info WHERE club_id != ''");
   echo($dbMain->error);
   $stmt->execute();      
   $stmt->store_result();      
   $stmt->bind_result($clubName); 
   while($stmt->fetch()){
    
    $locationsHtml .= "<li><a href=\"locationPage.php?clubName=$clubName\" target=\"\" title=\"$clubName\">
        $clubName</a></li>";
   }
     
   
$navBarUls = " <ul class=\"nav\">
        
        $aboutHtml
        
        <li class=\"nav-title\"><a href=\"locationPage.php?clubName=$clubName\" target=\"\" title=\"Clubs\"
            id=\"nav-clubs\" class=\"hot-spot\">
            Locations
        </a>
            
<ul class=\"sub-nav\">
    
  $locationsHtml
    
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>


        </li>
        
        $classesHtml
        
        $ptHtml
        
        <li class=\"nav-title\"><a href=\"locationSelectorPage.php\" target=\"\" title=\"Join\"
            id=\"\" class=\"hot-spot\">
            Join
        </a>
            
<ul class=\"sub-nav\">
    
    <li><a href=\"locationSelectorPage.php\" target=\"\" title=\"Join\">
        Join</a></li>
    
    <li><a href=\"http://membership\" target=\"_blank\" title=\"Membership Information\">
        Membership Information</a></li>
    
    <li><a href=\"renewPage.php\" target=\"\" title=\"Renew Membership\">
        Renew</a></li>
    
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>


        </li>
        
        <li class=\"nav-title\"><a href=\"guestPassPage.php\" target=\"\" title=\"Members\"
            id=\"nav-members\" class=\"hot-spot\">
            Guest Passes
        </a>
            
<ul class=\"sub-nav\">
    
    <li><a href=\"guestPassPage.php\" target=\"\" title=\"Get a Pass\">
        Get a Pass!</a></li>
    
    <li class=\"round-bottom\"><span class=\"round-bottom-inner\"></span></li>
</ul>


        </li>
        
        $newsHtml
        
        $storeHtml
        
    </ul>";
    
  
?>