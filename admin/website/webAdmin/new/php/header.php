<header>
    <div id="logo" class="row">
    <img src="img/logo_gym.png" alt="$gym_name">
    </div>

    <nav>
        <div class="top-bar row" data-topbar>
            <ul class="title-area">
                <li class="name"></li>
                <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <ul>
                    <li class="has-dropdown">
                    <a href="#">About Us</a>
                        <ul class="dropdown">
                        <li>
                        <a href="#" class="">Has Dropdown, Level 1</a>
                        </li>
                        <li><a href="#">Dropdown Option</a></li>
                        <li><a href="#">Dropdown Option</a></li>
                        <li><a href="#">Dropdown Option</a></li>
                        <li><a href="#">Dropdown Option</a></li>
                        <li><a href="#">Dropdown Option</a></li>
                        </ul>
                    </li>
                    <li><a href="location.php">Locations</a></li>
                    <li><a href="#">Classes</a></li>
                    <li><a href="#">Personal Training</a></li>
                    <li><a href="#">Join</a></li>
                    <li><a href="#">Guest Passes</a></li>
                    <li><a href="#">Newsletter</a></li>
                </ul>

                <ul class="right">
                    <li><a href="#" data-reveal-id="myModal"><i class="fa fa-user"></i> Member Login</a></li>
                </ul>
            </section>
        </div>
    </nav>
    
    <div id="myModal" class="reveal-modal" data-reveal>
        <div class="row">
            <form method="post" action="">
            <div class="small-12 large-6 columns">
                <h3>Membership Login</h3>
                <div class="row collapse postfix-radius">
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-barcode"></i></span>
                    </div>
                    <div class="small-11 columns">
                    <input type="text" name="barcode" placeholder="Barcode">
                    </div>
                    
                    <div class="small-1 columns">
                    <span class="prefix"><i class="fa fa-lock"></i></span>
                    </div>
                    <div class="small-11 columns">
                    <input type="password" name="password" placeholder="Password">
                    </div>
                    
                    <div class="small-12 column">
                        <button class="btn" type="submit" form="login" value="Login">Login <i class="fa fa-chevron-circle-right"></i></button><br>
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
                  <li class="cta-button"><a class="button" href="#">Join Today!</a></li>
                </ul>
            </div>
        </div>
        <a class="close-reveal-modal">&#215;</a>
    </div>
</header>