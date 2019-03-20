<div data-alert class="alert-box" id="master-alert-box">
    <a href="shopping-cart.php"><span id="alert-message"></span></a>
    <a href="#" class="close">&times;</a>
</div>
<header>
<style>
#manClinic{
    cursor: pointer;
    
}
    </style>
    <!--div class="row">
        <div class="small-12 column margin-top-bottom text-center"><img src="img/ad.jpg"></div>
    </div-->
    
    <div id="logo" class="row">
        <div class="right" id="login-cart">
            <?php
            if (!isset($_SESSION['userFirstName'])) {
                echo '<span style="margin-right:10px;"><a href="#" data-reveal-id="myModal"><i class="fa fa-user"></i> Member Login</a></span>';
            } else {
                $name = $_SESSION['userFirstName'];
                echo '<span style="margin-right:10px;"><i class="fa fa-user"></i> ' . $name . '
                 (<a href="php/member-logout.php">Logout</a>)<br><a href="myAccount.php">My Account</a></span>';
            }
            ?>
            <a href="shopping-cart.php"><i class="fa fa-shopping-cart"></i> <span id="numberOfCartItems" class="label round" title="Number of products in the cart"><?php echo $numberOfCartItems ?></span></a>
        </div>
            
    	<a href="index.php"><img src="img/contract_logo.png" alt="$gym_name"></a>
        
    </div>

    <nav>
        <div class="top-bar row" data-topbar>
            <ul class="title-area">
                <li class="name"></li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <ul>
                    <?php
                    $stmt = $dbMain ->prepare("SELECT nav_text_color, about_us, going_green, visit, owner_info, our_mission, contact, photo, classes, schedule, class_descriptions, instructors, group_fitness, spin, yoga, boxing, zumba, pt, trainers, packages, small_group, train_info, news, sign_up, cancel, view, store, clearence, gear, catalog, supps FROM web_link_bar_options WHERE web_key = '1'");
                    echo($dbMain->error);
                    $stmt->execute();      
                    $stmt->store_result();      
                    $stmt->bind_result($navTextColor, $aboutUs, $goingGreen, $visit, $ownerInfo, $mission, $contactUs, $photo, $classes, $schedule, $class_descriptions, $instructors, $groupx ,$spinning , $yoga,$boxing ,$zumba ,$pt,  $trainer,    $package,$groupTrain,$trainInfo,$news,$newsSign, $newsCanc,  $viewNews, $store, $clearence , $gear, $catalog, $supp); 
                    $stmt->fetch();

                    //ABOUT US
                    if ($aboutUs == 'Yes') {
                        if ($goingGreen == 'Yes' || $ownerInfo == 'Yes' || $visit == 'Yes' || $mission == 'Yes') {
                            echo '<li class="has-dropdown"><a tabindex="-1" href="contactUs.php">Contact Us</a><ul class="dropdown">';
                            if ($ownerInfo == 'Yes'){ echo '<li><a tabindex="-1" href="owner-information.php">Owner Info</a></li>'; }
                            if ($goingGreen == 'Yes') { echo '<li><a tabindex="-1" href="paperless.php">We are Paperless!</a></li>'; }
                            if ($visit == 'Yes'){ echo '<li><a tabindex="-1" href="scheduleVisit.php">Schedule A Visit</a></li>'; }
                            if ($mission == 'Yes') { echo '<li><a tabindex="-1" href="our-mission.php">Our Mission</a></li>'; }
                            if ($contactUs == 'Yes') { echo '<li><a tabindex="-1" href="contactUs.php">Contact Us</a></li>'; }
                            if ($photo == 'Yes') { echo '<li><a tabindex="-1" href="photo-gallery.php">Photo Gallery</a></li>'; }
                            echo '</ul></li>';
                        } else {
                            echo '<li><a tabindex="-1" href="our-mission.php">About Us</a></li>';
                        }
                    }
                    
                    //LOCATIONS                    
                    //DATABASE CALL FOR LOCATIONS
                    $lct = $dbMain ->prepare("SELECT club_id, club_name FROM club_info WHERE club_id != ''");
                    echo($dbMain->error);
                    $lct->execute();      
                    $lct->store_result();      
                    $lct->bind_result($clubID, $clubName);
                    while($lct->fetch()){
                        $clubName2 = $clubName;
                        $clubName = urlencode($clubName);
                        $locationsHtml .= '<li><a tabindex="-1" href="location.php?clubName=' . $clubName . '">' . $clubName2 . '</a></li>';
                        //CREATE ARRAY OF CLUB NAMES FOR USE IN OTHER PARTS OF NAVIGATION
                        $clubs[id][] .= $clubID;
                        $clubs[name][] .= $clubName;
                        $clubs2[name][] .= $clubName2;
                    }

                    if ($locationsHtml) {
                        echo '<li class="has-dropdown"><a tabindex="-1" href="location.php?clubName=' . $clubName . '">Locations</a><ul class="dropdown">';
                        echo $locationsHtml;
                        echo '</li></ul>';
                    } else {
                        echo '<li><a tabindex="-1" href="location.php?clubName=' . $clubName . '">Location</a>';
                    }

                    //CLASSES
                    if ($classes == 'Yes') {
                        if ($schedule == 'Yes' || $class_descriptions == 'Yes' || $groupx == 'Yes' || $spinning == 'Yes' || $yoga == 'Yes' || $boxing == 'Yes' || $zumba == 'Yes') {
                            echo '<li class="has-dropdown"><a tabindex="-1" href="class-schedule.php">Class Schedules</a><ul class="dropdown">';
                            if ($schedule == 'Yes') { echo '<li><a tabindex="-1" href="class-schedule.php">Schedule</a></li>'; }
                            if ($class_descriptions == 'Yes') { echo '<li><a href="classDescSelectPage.php">Class Descriptions</a></li>'; }
                             if ($instructors == 'Yes') {
                                echo '<li class="has-dropdown">
                                <a tabindex="-1" href="#">Instructors</a>
                                <ul class="dropdown">';
                                for($i=0; $i < count($clubs); $i++) {
                                    echo '<li><a tabindex="-1" href="instructors.php?club=' . $clubs[id][$i] . '">' . $clubs2[name][$i] . '</a></li>';
                                }
                                echo '</ul></li>';
                            }
                            if ($boxing == 'Yes'){ echo '<li><a tabindex="-1" href="/boxing">Boxing</a></li>'; }
                            if ($groupx == 'Yes') { echo '<li><a tabindex="-1" href="/groupx">Group Fitness</a></li>'; }
                            if ($spinning == 'Yes') { echo '<li><a tabindex="-1" href="/spin">Spinning</a></li>'; }
                            if ($yoga == 'Yes') { echo '<li><a tabindex="-1" href="/yoga">Yoga</a></li>'; }
                            if ($zumba == 'Yes') { echo '<li><a tabindex="-1" href="/zumba">Zumba</a></li>'; }
                            echo '</ul></li>';
                        } else {
                            echo '<li><a tabindex="-1" href="class-schedule.php">Classes</a></li>';
                        }
                    }

                    //PERSONAL TRAINING
                    if ($pt == 'Yes') {
                        if ($trainer == 'Yes' || $package == 'Yes' || $groupTrain == 'Yes' || $trainInfo == 'Yes') {
                            echo '<li class="has-dropdown"><a tabindex="-1" href="training-packages.php">Personal Training</a><ul class="dropdown">';
                            if ($trainer == 'Yes') {
                                echo '<li class="has-dropdown">
                                <a tabindex="-1" href="#">Trainers</a>
                                <ul class="dropdown">';
                                for($i=0; $i < count($clubs); $i++) {
                                    echo '<li><a tabindex="-1" href="trainers.php?club=' . $clubs[id][$i] . '">' . $clubs2[name][$i] . '</a></li>';
                                }
                                echo '</ul></li>';
                            }
                            if ($package == 'Yes') { 
                                //echo '<li><a href="training-packages.php">Training Packages</a></li>';
                                 echo '<li class="has-dropdown">
                                    <a tabindex="-1" href="training-packages.php">Training Packages</a>
                                    <ul class="dropdown">';
                                        echo '<li><a tabindex="-1" href="https://squareup.com/market/hdfitness">' . $clubs2[name][0] . '</a></li>';
                                        echo '<li><a tabindex="-1" href="training-packages.php?club=' . $clubs[id][1] . '">' . $clubs2[name][1] . '</a></li>';
                                    echo '</ul></li>';
                                
                                 }
                            if ($groupTrain == 'Yes'){ echo '<li><a tabindex="-1" href="/grouptrain">Group Training</a></li>'; }
                            if ($trainInfo == 'Yes') { echo '<li><a tabindex="-1" href="/packages">Training Information</a></li>'; }
                            echo '</ul></li>';
                        } else {
                            echo '<li><a tabindex="-1" href="/life">Personal Training</a></li>';
                        }
                    }

                    //JOIN
                    echo '<li><a tabindex="-1" href="locationSelect.php">Join</a></li>';
                    
                    //Renew
                    echo '<li><a tabindex="-1" href="renew.php">Renew</a></li>';

                    //GUEST PASSES
                    echo '<li><a tabindex="-1" href="guest-passes.php">Guest Passes</a></li>';

                    //NEWSLETTER
                    if ($news == 'Yes') {
                        if ($newsSign == 'Yes' || $newsCanc == 'Yes' || $viewNews == 'Yes') {
                            echo '<li class="has-dropdown"><a tabindex="-1" href="newsletter.php">Newsletter</a><ul class="dropdown">';
                            if ($newsSign == 'Yes') { echo '<li><a tabindex="-1" href="newsletter.php">Sign Up</a></li>'; }
                            if ($newsCanc == 'Yes') { echo '<li><a tabindex="-1" href="cancelNewsletter.php">Cancel Newsletter</a></li>'; }
                            if ($viewNews == 'Yes'){ echo '<li><a tabindex="-1" href="viewNewsletter.php">View Newsletters</a></li>'; }
                            echo '</ul></li>';
                        } else {
                            echo '<li><a tabindex="-1" href="/myeq2">Newsletter</a></li>';
                        }
                    }

                    //STORE
                    if ($store == 'Yes') {
                        if ($clearence == 'Yes' || $gear == 'Yes' || $catalog == 'Yes' || $supp == 'Yes') {
                            echo '<li class="has-dropdown"><a tabindex="-1" href="store.php">Store</a><ul class="dropdown">';
                            if ($clearence == 'Yes') { echo '<li><a tabindex="-1" href="/clearance">Clearance</a></li>'; }
                            if ($gear == 'Yes') { echo '<li><a tabindex="-1" href="/clubgear">Club Gear</a></li>'; }
                            if ($catalog == 'Yes'){ echo '<li><a tabindex="-1" href="/catalog">Catalog</a></li>'; }
                            if ($supp == 'Yes'){ echo '<li><a tabindex="-1" href="/supplements">Supplements</a></li>'; }
                            echo '</ul></li>';
                        } else {
                            echo '<li><a tabindex="-1" href="store.php">Store</a></li>';
                        }
                    }
                    ?>
                </ul>
            </section>
        </div>
    </nav>
    
    <div id="myModal" class="reveal-modal" data-reveal>
        <div class="row">
            <form method="post" action="php/member-login.php" id="member-login" data-abide>
            <div class="small-12 large-6 columns">
                <h3>Membership Login</h3>
                <div class="row collapse postfix-radius">
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-barcode"></i></span>
                    </div>
                    <div class="small-11 columns">
                    <input type="text" name="barcode" placeholder="Email Address" id="login-barcode" required>
                    <small class="error">Please enter your email</small>
                    </div>
                    
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-lock"></i></span>
                    </div>
                    <div class="small-11 columns">
                        <input type="password" name="password" placeholder="Password" id="login-password" required>
                        <small class="error">Please enter your password</small>
                    </div>
                    
                    <div class="small-12 column hide" id="login-success">
                        <div data-alert class="alert-box success radius">
                            You are now logged in.
                            <a href="#" class="close">&times;</a>
                        </div>
                    </div>
                    
                    <div class="small-12 column hide" id="login-failure">
                        <div class="alert-box alert radius">
                            The barcode or password you entered is incorrect.
                            <a href="#" class="close">&times;</a>
                        </div>
                    </div>
                    
                    <div class="small-12 column">
                        <button class="btn" type="submit" value="Login" form="member-login" id="submit-member-login">Login <i class="fa fa-chevron-circle-right"></i></button><br>
                        <a href="#">Don't have your barcode?</a><br>
                        <a href="#">Forgot your password?</a>
                    </div>
                </div>
                </form>
            </div>
            
            <div class="small-12 large-6 columns">
                <ul class="pricing-table">
                  <li class="title"><strong>Register Today</strong></li>
                  <li class="bullet-item">Book classes, see your class history, schedule time with a personal trainer, update your account - it’s all here!</li>
                  <li class="cta-button"><a class="button" href="createAccount2.php">Join Today!</a></li>
                </ul>
            </div>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
</header>