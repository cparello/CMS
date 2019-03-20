<h2>Get Your Guest Pass Today</h2>
<p>Try <?php echo $business_name ?> out for free today!</p>

<div class="row">
    
    <div class="small-12 large-6 columns">
        <input type="text" name="first_name" id="first_name" tabindex="1" placeholder="First Name" />
        <input type="email" name="email" id="email" tabindex="3" placeholder="Email" />
        <input type="tel" name="phone" id="phone" tabindex="5" placeholder="Mobile Number" />
    </div>
    <div class="small-12 large-6 columns">
        <input type="text" name="last_name" id="last_name" tabindex="2" placeholder="Last Name" />
        <input type="email" name="confirm_email" id="confirm_email"  tabindex="4" placeholder="Confirm Email" />
        <select id="location">
            <option value="" tabindex="6">Select a Location</option>
            <?php
            $stmt = $dbMain ->prepare("SELECT club_name, club_id FROM club_info WHERE club_id != ''");
            echo($dbMain->error);
            $stmt->execute();      
            $stmt->store_result();      
            $stmt->bind_result($clubName, $club_id); 
            while($stmt->fetch()) {
                $clubName = trim($clubName);
                echo '<option value="' . $club_id . '">' . $clubName . '</option>';
            }
            ?>
        </select>
        <span id="msgBox"></span>
        <p><button class="btn right" name="createPass" id="createPass">Submit</button></p>
    </div>
    
    <script src="js/guestPassMain1.js"></script>   
</div>