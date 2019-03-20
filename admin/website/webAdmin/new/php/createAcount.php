<?php
include_once('php/connection.php');

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <?php include_once('inc/meta.php'); ?>
    <link rel="stylesheet" href="css/zebra.css" />
    <style>
    .row {
        text-align: center;
    }
    </style>
</head>
<body>
    <?php include_once('inc/header.php'); ?>
    
    <div id="cover">
        <h1>Create Account</h1>
    </div>
    
    <div class="row">
      <div class="small-12 large-4 columns">
            <h2>Verify Information</h2>
            <label for="name" class="label">Name</label>
            <input id="name" value="" name="name" maxlength="320" type="text" tabindex="1" class="input" disabled/>
            <label for="barcode" class="label">Barcode Number</label>
            <input id="barcode" value="" name="barcode" maxlength="320" type="text" tabindex="1" class="input" />
            <label for="zipcode" class="label">Zipcode</label>
            <input id="zipcode" value="" name="zipcode" maxlength="320" type="text" tabindex="1" class="input" />
            <label for="email" class="label">Email Address</label>
            <input id="email" value="" name="email" maxlength="320" type="text" tabindex="1" class="input" />
            <button class="button" id="search" type="submit">Check Information</button>
        </div>  
        <div id="authBox" class="small-12 large-4 columns">
            <h2>Authorization Code</h2>
            <input id="code" value="" name="code" maxlength="320" type="text" tabindex="5" class="input" />
            <button class="button" id="check" type="submit">Check Code</button>
        </div>       
        <div class="small-12 large-4 columns">
        <h2>Verify Information</h2>
            <h2>Create a Password</h2>
            <label for="password1" class="label">Password</label>
            <input id="password1" name="password1" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/>
            <label for="password2" class="label">Confirm Password</label>
            <input id="password2" name="password2" maxlength="16" type="password" tabindex="2" autocomplete="off" class="input"/>
            <button class="button" id="create" type="submit">Create Account</button>
            <input type="hidden" id="checkTest" name="checkTest" value="" />
        </div>         
    </div>
    
    <?php include_once('inc/footer.php'); ?>
    
    <script src="js/checkAccount.js" type="text/javascript"></script>
    <script src="js/createAccount.js" type="text/javascript"></script>
    <script src="ja/checkCode.js" type="text/javascript"></script>  
  
</body>
</html>
