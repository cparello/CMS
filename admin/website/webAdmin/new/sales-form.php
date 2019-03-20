<?php
include_once('php/connection.php');
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/signature_pad.css">
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div class="row margin-top-bottom">
    	<h1>Purchase Summary</h1>
        <table width="100%">
            <thead>
                <tr>
                    <th width="50%">Item</th>
                    <th width="10%">QTY</th>
                    <th width="15%">Price</th>
                    <th width="15%">Service Length</th>
                </tr>
            </thead>
            
            <tbody>
                <tr>
                    <td>Personal Training Hours-All Locations</td>
                    <td>1</td>
                    <td>$1620.00</td>
                    <td>36 Classes</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="row text-center">
    	<h3>Customers Who Bought This Item Also Bought</h3>
        <ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-5">
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Monthly Towel Service</strong><br>
            	<input type="radio" name="serviceOptions1" value="260|1|Month|10.00|Monthly Towel Service"><span style="color: #;">&nbsp;1 Month $10.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|3|Months|25.00|Monthly Towel Service"><span style="color: #;">&nbsp;3 Months $25.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|6|Months|45.00|Monthly Towel Service"><span style="color: #;">&nbsp;6 Months $45.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|12|Months|85.00|Monthly Towel Service"><span style="color: #;">&nbsp;12 Months $85.00</span></input><br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Monthly Towel Service</strong><br>
            	<input type="radio" name="serviceOptions1" value="260|1|Month|10.00|Monthly Towel Service"><span style="color: #;">&nbsp;1 Month $10.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|3|Months|25.00|Monthly Towel Service"><span style="color: #;">&nbsp;3 Months $25.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|6|Months|45.00|Monthly Towel Service"><span style="color: #;">&nbsp;6 Months $45.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|12|Months|85.00|Monthly Towel Service"><span style="color: #;">&nbsp;12 Months $85.00</span></input><br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Monthly Towel Service</strong><br>
            	<input type="radio" name="serviceOptions1" value="260|1|Month|10.00|Monthly Towel Service"><span style="color: #;">&nbsp;1 Month $10.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|3|Months|25.00|Monthly Towel Service"><span style="color: #;">&nbsp;3 Months $25.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|6|Months|45.00|Monthly Towel Service"><span style="color: #;">&nbsp;6 Months $45.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|12|Months|85.00|Monthly Towel Service"><span style="color: #;">&nbsp;12 Months $85.00</span></input><br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Monthly Towel Service</strong><br>
            	<input type="radio" name="serviceOptions1" value="260|1|Month|10.00|Monthly Towel Service"><span style="color: #;">&nbsp;1 Month $10.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|3|Months|25.00|Monthly Towel Service"><span style="color: #;">&nbsp;3 Months $25.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|6|Months|45.00|Monthly Towel Service"><span style="color: #;">&nbsp;6 Months $45.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|12|Months|85.00|Monthly Towel Service"><span style="color: #;">&nbsp;12 Months $85.00</span></input><br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Monthly Towel Service</strong><br>
            	<input type="radio" name="serviceOptions1" value="260|1|Month|10.00|Monthly Towel Service"><span style="color: #;">&nbsp;1 Month $10.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|3|Months|25.00|Monthly Towel Service"><span style="color: #;">&nbsp;3 Months $25.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|6|Months|45.00|Monthly Towel Service"><span style="color: #;">&nbsp;6 Months $45.00</span></input><br>
                <input type="radio" name="serviceOptions1" value="260|12|Months|85.00|Monthly Towel Service"><span style="color: #;">&nbsp;12 Months $85.00</span></input><br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Hat</strong><br>
            	$14.00<br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Hat</strong><br>
            	$14.00<br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Hat</strong><br>
            	$14.00<br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Hat</strong><br>
            	$14.00<br>
                <input type="button" class="button" value="Add">
            </li>
            
            <li>
            	<img src="img/kettlebell.jpg" alt=""><br>
                <strong>Hat</strong><br>
            	$14.00<br>
                <input type="button" class="button" value="Add">
            </li>
        </ul>
    </div>
    
    <div class="row margin">
    	<h3>Personal Training Waiver</h3>
        <div style="border:1px solid #c9c9c9; overflow:scroll; height:250px; width:100%"><p>ASSUMPTION OF RISK, WAIVER AND RELEASE OF LIABILITY, AND INDEMNI TY AGREEMENT DECLARATIONS: This Agreement is entered into between personal trainer ________________ ("Trainer") and the undersigned ("Client"). The provision of personal training services by Trainer to Client, and Client‘s use of any premises, facilities o r equipment are contingent upon this Agreement.</p> 

        <p>ASSUMPTION OF RISK: You agree that if you engage in any physical exercise or activity, including personal training, or enter our premises or use any facility or equipment on our premises for any purpose, you do so at your own risk and assume the risk of any and all injury and/or damage you may suffer, whether while engaging in physical exercise or not. This includes injury or damage sustained while and/or resulting from using any premises or facility, or using any equipment, whether provided to you by Trainer or otherwise, including injuries or damages arising out of the negligence of Trainer, whether active or passive, or any of Trainer‘s affiliates, employees, agents, representatives, successors, and assigns. Your assumption of risk includes, but is not limited to, your use of any exercise equipment (mechanical or otherwise), sports fields, courts, or other areas, locker rooms, sidewalks, parking lots, stairs, pools, whirlpools, saunas, steam rooms, lobby or o ther general areas of any facilities, or any equipment. You assume the risk of your participation in any activity, class, program, instruction, or event, incl uding but not limited to weight lifting, walking, jogging, running, aerobic activities, aquatic ac tivities, tennis, basketball, volleyball, racquetball, or any other sporting or recreational endeavor. You agree that you are voluntarily participating in the aforementioned activities and assume all risk of injury, illness, damage, or loss to you or your property that might result, including, without limitation, any loss or theft of any personal property, whether arising out of the negligence of Trainer or otherwise. </p>
        
        <p>RELEASE: You agree on behalf of yourself (and all your personal representatives, heirs, ex ecutors, administrators, agents, and assigns) to release and discharge Trainer (and Trainer‘s affiliates, related entities, employees, agents, representatives, successors, and assigns) from any and all claims or causes of action (known or unknown) arising out of the negligence of Trainer, whether active or passive, or any of Trainer‘s affiliates, employees, agents, representatives, successors, and assigns. This waiver and release of liability includes, without limitation, injuries which may occur as a resul t of (a) your use of any exercise equipment or facilities which may malfunction or break, (b) improper maintenance of any exercise equipment, premises or facilities, (c) negligent instruction or supervision, including personal training, (d) negligent hirin g or retention of employees, and/or (e) slipping or tripping and falling while on any portion of a premises or while traveling to or from personal training, including injuries resulting from Trainer‘s or anyone else‘s negligent inspection or maintenance of the facility or premises.</p> 
        
        <p>INDEMNIFICATION: By execution of this agreement, you hereby agree to indemnify and hold harmless Trainer from any loss, liability, damage, or cost Trainer may incur due to the provision of personal training by Trainer to you.</p> 
        
        <p>ACKNOWLEDGMENTS: You expressly agree that the foregoing release, waiver, assumption of risk and indemnity agreement is intended to be as broad and inclusive as permitted by the law in the State of California and that if any portion thereof is held invalid, it is agreed that the balance shall, notwithstanding, continue in full legal force and effect. You acknowledge that Trainer offers a service to his/her clients encompassing the entire recreational and/or fitness spectrum. Trainer is not in the business of sellin g weight lifting equipment, exercise equipment, or other such products to the public, and the use of such items is incidental to the service provided by Trainer. You acknowledge and agree that Trainer does not place such items into the stream of commerce. This release is not intended as an attempted release of claims of gross negligence or intentional acts. You acknowledge that you have carefully read this waiver and release and fully understand that it is a release of liability, express assu mption of risk and indemnity agreement. You are aware and agree that by executing this waiver and release, you are giving up your right to bring a legal action or assert a claim against trainer for trainer‘s negligence, or for any defective product used wh ile receiving personal training from trainer. You have read and voluntarily signed the waiver and release and further a gree that no oral representations, statements, or inducement apart from the foregoing written agreement have been made. Date: ___________ Print Name: ________________ Sign Name: __________________</p>
        </div>
        <input type="checkbox" name="terms_conditions" id="terms_conditions"  value=""/> I have read Personal Training ASSUMPTION OF RISK, WAIVER AND RELEASE OF LIABILITY, AND INDEMNITY AGREEMENT DECLARATIONS.
    </div>
    
    <div class="row">
        <div class="small-12 large-12">
        <h3>1. Membership Information</h3>
        <strong>Liability Host Contact/Billing Information</strong><br>
        <p>Only fill-out this section if you are a parent signing-up a minor OR if your billing information is different than your membership information.</p>
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="first_name[]" type="text" id="first_name1" value="" placeholder="First Name">
        <input name="street_address[]" type="text" id="street_address1" value="" placeholder="Street Address">
        <input name="zip_code[]" type="text" id="zip_code1" value="" placeholder="Zip Code">
        <input  name="email[]" type="text" id="email1" value="" placeholder="Email">
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="middle_name[]" type="text" id="middle_name1" value="" placeholder="Middle Name">
        <input name="city[]" type="text" id="city1" value="" placeholder="City">
        <input name="home_phone[]" type="text" id="home_phone1" value="" placeholder="Home Phone">
        <input  name="dob[]" type="text" id="dob1" value="" placeholder="Date of Birth (MM/DD/YYYY)">
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="last_name[]" type="text" id="last_name1" value="" placeholder="Last Name">
        <select  name="state[]" id="state1">
                <option value="">Select State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">Wash. D.C.</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">So. Carolina</option>
                <option value="SD">So. Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
            <input  name="cell_phone[]" type="text" id="cell_phone1" value="" placeholder="Cell Phone">
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 large-12">
        <p><strong>Member Information</strong></p>
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="first_name[]" type="text" id="first_name1" value="" placeholder="First Name" required>
        <input name="street_address[]" type="text" id="street_address1" value="" placeholder="Street Address" required>
        <input name="zip_code[]" type="text" id="zip_code1" value="" placeholder="Zip Code" required>
        <input  name="email[]" type="text" id="email1" value="" placeholder="Email" required>
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="middle_name[]" type="text" id="middle_name1" value="" placeholder="Middle Name (optional)">
        <input name="city[]" type="text" id="city1" value="" placeholder="City" required>
        <input name="home_phone[]" type="text" id="home_phone1" value="" placeholder="Home Phone" required>
        <input  name="dob[]" type="text" id="dob1" value="" placeholder="Date of Birth (MM/DD/YYYY)" required>
        </div>
        
        <div class="small-12 large-4 columns">
        <input name="last_name[]" type="text" id="last_name1" value="" placeholder="Last Name" required>
        <select  name="state[]" id="state1" required>
                <option value="">Select State</option>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">Wash. D.C.</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">So. Carolina</option>
                <option value="SD">So. Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
            </select>
            <input  name="cell_phone[]" type="text" id="cell_phone1" value="" placeholder="Cell Phone"  required>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 large-12">
            <h3>2. Payment Information</h3>
            <p>Today's Payment: $0.00</p>
        </div>
    </div>
    
    <div class="row">
        <div class="small-12 large-6 columns">
            <p><strong>Credit Card Payment</strong></p>
            <select  name="card_type" id="card_type">
                <option value>Card Type</option>
                <option value="Visa" >Visa</option>
                <option value="MC" >MasterCard</option>
                <option value="Amex" >American Express</option>
                <option value="Disc" >Discover</option>
            </select>
            <input name="card_name" type="text" id="card_name" value="" placeholder="Name on Card">
            <input name="card_number" type="text" id="card_number" value="" placeholder="Card Number">
            <input name="card_cvv" type="text" id="card_cvv" value="" placeholder="Security Code">
            
            <div class="row">
                <div class="small-6 large-6 columns">
                    <label>Exp. Month
                    <select name="card_month" id="card_month">
                        <option value="">Month</option>
                        <option value="01" >January</option>
                        <option value="02" >February</option>
                        <option value="03" >March</option>
                        <option value="04" >April</option>
                        <option value="05" >May</option>
                        <option value="06" >June</option>
                        <option value="07" >July</option>
                        <option value="08" >August</option>
                        <option value="09" >September</option>
                        <option value="10" >October</option>
                        <option value="11" >November</option>
                        <option value="12" >December</option>
                    </select>
                    </label>
                </div>
                
                <div class="small-6 large-6 columns">
                    <label>Exp. Year
                    <select name="card_year" id="card_year">
                        <option value="">Year</option>
                        <option value="15" >2015</option>
                        <option value="16" >2016</option>
                        <option value="17" >2017</option>
                        <option value="18" >2018</option>
                        <option value="19" >2019</option>
                        <option value="20" >2020</option>
                        <option value="21" >2021</option>
                        <option value="22" >2022</option>
                        <option value="23" >2023</option>
                        <option value="24" >2024</option>
                        <option value="25" >2025</option>
                        <option value="26" >2026</option>
                        <option value="27" >2027</option>
                        <option value="28" >2028</option>
                    </select>
                    </label>
                </label>
                </div>
            </div>
            
          	<input  name="credit_pay" type="text" id="credit_pay" value="" placeholder="Credit Payment">
        </div>
        
        <div class="small-12 large-6 columns">
            <p><strong>Bank Payment</strong></p>
            <input  name="bank_name" type="text" id="bank_name"  value="" placeholder="Bank Name">
			<select name="account_type" id="account_type">
                <option value="">Account Type</option>
                <option value="C" >Personal Checking</option>
                <option value="B" >Business Checking</option>
                <option value="S" >Savings</option>
            </select>
			<input name="account_name" type="text" id="account_name" value="" placeholder="Account Name">
			<input name="account_num" type="text" id="account_num" value="" placeholder="Account Number">
			<input name="aba_num" type="text" id="aba_num" value="" placeholder="Routing Number">
			<input name="ach_pay" type="text" id="ach_pay" value="" placeholder="ACH Payment">
        </div>
    </div>
    
    <div class="row">
    	<div class="small-12 large-12 columns">
            <div id="signature-pad" class="m-signature-pad">
                <div class="m-signature-pad--body">
                  <canvas></canvas>
                </div>
            
                <div class="m-signature-pad--footer">
                    <strong>Sign above</strong><br>
                    <a data-action="clear" href="#">Clear</a> &mdash; <a data-action="save" href="#">Save</a>
                    <input type="hidden" id="input_name" name="input_name" value="">
                </div>
			</div>
        </div>
        <center><input type="button" value="Submit Information" id="qty" class="button buttonSubmit buttonPassesGreen buttonSize" field="number_memberships"></center>
     </div>
    
    <script type="text/javascript" src="js/signature_pad.js"></script>
	<script type="text/javascript" src="js/signaturePad.js"></script>
    <?php include_once('inc/footer.php'); ?>
</body>
</html>