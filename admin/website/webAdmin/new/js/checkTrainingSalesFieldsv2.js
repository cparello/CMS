
    
//======================================================================
function openLiabiltyWindow()  {

window.open('php/liabilityWindow.php','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
}
//---------------------------------------------------------------------
function openContractWindow()  {
//alert('Open Contract Window'); 
//window.open('php/contractWindow.php?ptBool=1','','scrollbars=yes,menubar=no,height=600,width=800,resizable=no,toolbar=no,location=no,status=no');
window.location = "php/contractWindow.php?ptBool=1";
}


//---------------------------------------------------------------------
//===================================
$(document).ready(function() {
    
   
    
    var checkBox = $('#liability_host');
    checkBox.on('change', function() {
         if(document.getElementById('liability_host').checked == false && document.getElementById('billing_info').checked == false){
            $('#hostInfo').html(null);
        }else{
        var libHost = "<strong>Liability Host Contact/Billing Information (ALL FIELDS REQUIRED)</strong><br><div class=\"small-12 large-4 columns\"><input  tabindex=\"110\" name=\"first_name[]\" type=\"text\" id=\"first_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"First Name(REQUIRED)\"><input  tabindex=\"113\" name=\"street_address[]\" type=\"text\" id=\"street_address_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Street Address(REQUIRED)\"><input tabindex=\"116\" name=\"zip_code[]\" type=\"text\" id=\"zip_code_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Zip Code(REQUIRED)\"><input tabindex=\"118\"  name=\"email[]\" type=\"text\" id=\"email_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Email(REQUIRED)\"></div><div class=\"small-12 large-4 columns\"><input tabindex=\"111\" name=\"middle_name[]\" type=\"text\" id=\"middle_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Middle Name\"><input tabindex=\"114\" name=\"city[]\" type=\"text\" id=\"city_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"City(REQUIRED)\"><input tabindex=\"117\" name=\"home_phone[]\" type=\"text\" id=\"home_phone_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Phone(REQUIRED)\"><input  tabindex=\"119\" name=\"dob[]\" type=\"text\" id=\"dob_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Date of Birth (MM/DD/YYYY)(REQUIRED)\"></div><div class=\"small-12 large-4 columns\"><input tabindex=\"112\" name=\"last_name[]\" type=\"text\" id=\"last_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Last Name(REQUIRED)\"><select  tabindex=\"115\" name=\"state[]\" id=\"state_li\"><option value=\"\">Select State(REQUIRED)</option><option value=\"AL\">Alabama</option><option value=\"AK\">Alaska</option><option value=\"AZ\">Arizona</option><option value=\"AR\">Arkansas</option><option value=\"CA\">California</option><option value=\"CO\">Colorado</option><option value=\"CT\">Connecticut</option><option value=\"DE\">Delaware</option><option value=\"DC\">Wash. D.C.</option><option value=\"FL\">Florida</option><option value=\"GA\">Georgia</option><option value=\"HI\">Hawaii</option><option value=\"ID\">Idaho</option><option value=\"IL\">Illinois</option><option value=\"IN\">Indiana</option><option value=\"IA\">Iowa</option><option value=\"KS\">Kansas</option><option value=\"KY\">Kentucky</option><option value=\"LA\">Louisiana</option><option value=\"ME\">Maine</option><option value=\"MD\">Maryland</option><option value=\"MA\">Massachusetts</option><option value=\"MI\">Michigan</option><option value=\"MN\">Minnesota</option><option value=\"MS\">Mississippi</option><option value=\"MO\">Missouri</option><option value=\"MT\">Montana</option><option value=\"NE\">Nebraska</option><option value=\"NV\">Nevada</option><option value=\"NH\">New Hampshire</option><option value=\"NJ\">New Jersey</option><option value=\"NM\">New Mexico</option><option value=\"NY\">New York</option><option value=\"NC\">North Carolina</option><option value=\"ND\">North Dakota</option><option value=\"OH\">Ohio</option><option value=\"OK\">Oklahoma</option><option value=\"OR\">Oregon</option><option value=\"PA\">Pennsylvania</option><option value=\"RI\">Rhode Island</option><option value=\"SC\">So. Carolina</option><option value=\"SD\">So. Dakota</option><option value=\"TN\">Tennessee</option><option value=\"TX\">Texas</option><option value=\"UT\">Utah</option><option value=\"VT\">Vermont</option><option value=\"VA\">Virginia</option><option value=\"WA\">Washington</option><option value=\"WV\">West Virginia</option><option value=\"WI\">Wisconsin</option><option value=\"WY\">Wyoming</option></select></div>";
        $('#hostInfo').html(libHost);
        }
    });
    
     var checkBox2 = $('#billing_info');
    checkBox2.on('change', function() {
         if(document.getElementById('billing_info').checked == false && document.getElementById('liability_host').checked == false){
            $('#hostInfo').html(null);
        }else{
        var libHost2 = "<strong>Liability Host Contact/Billing Information (ALL FIELDS REQUIRED)</strong><br><div class=\"small-12 large-4 columns\"><input  tabindex=\"110\" name=\"first_name[]\" type=\"text\" id=\"first_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"First Name(REQUIRED)\"><input  tabindex=\"113\" name=\"street_address[]\" type=\"text\" id=\"street_address_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Street Address(REQUIRED)\"><input tabindex=\"116\" name=\"zip_code[]\" type=\"text\" id=\"zip_code_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Zip Code(REQUIRED)\"><input tabindex=\"118\"  name=\"email[]\" type=\"text\" id=\"email_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Email(REQUIRED)\"></div><div class=\"small-12 large-4 columns\"><input tabindex=\"111\" name=\"middle_name[]\" type=\"text\" id=\"middle_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Middle Name\"><input tabindex=\"114\" name=\"city[]\" type=\"text\" id=\"city_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"City(REQUIRED)\"><input tabindex=\"117\" name=\"home_phone[]\" type=\"text\" id=\"home_phone_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Phone(REQUIRED)\"><input  tabindex=\"119\" name=\"dob[]\" type=\"text\" id=\"dob_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Date of Birth (MM/DD/YYYY)(REQUIRED)\"></div><div class=\"small-12 large-4 columns\"><input tabindex=\"112\" name=\"last_name[]\" type=\"text\" id=\"last_name_li\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Last Name(REQUIRED)\"><select  tabindex=\"115\" name=\"state[]\" id=\"state_li\"><option value=\"\">Select State(REQUIRED)</option><option value=\"AL\">Alabama</option><option value=\"AK\">Alaska</option><option value=\"AZ\">Arizona</option><option value=\"AR\">Arkansas</option><option value=\"CA\">California</option><option value=\"CO\">Colorado</option><option value=\"CT\">Connecticut</option><option value=\"DE\">Delaware</option><option value=\"DC\">Wash. D.C.</option><option value=\"FL\">Florida</option><option value=\"GA\">Georgia</option><option value=\"HI\">Hawaii</option><option value=\"ID\">Idaho</option><option value=\"IL\">Illinois</option><option value=\"IN\">Indiana</option><option value=\"IA\">Iowa</option><option value=\"KS\">Kansas</option><option value=\"KY\">Kentucky</option><option value=\"LA\">Louisiana</option><option value=\"ME\">Maine</option><option value=\"MD\">Maryland</option><option value=\"MA\">Massachusetts</option><option value=\"MI\">Michigan</option><option value=\"MN\">Minnesota</option><option value=\"MS\">Mississippi</option><option value=\"MO\">Missouri</option><option value=\"MT\">Montana</option><option value=\"NE\">Nebraska</option><option value=\"NV\">Nevada</option><option value=\"NH\">New Hampshire</option><option value=\"NJ\">New Jersey</option><option value=\"NM\">New Mexico</option><option value=\"NY\">New York</option><option value=\"NC\">North Carolina</option><option value=\"ND\">North Dakota</option><option value=\"OH\">Ohio</option><option value=\"OK\">Oklahoma</option><option value=\"OR\">Oregon</option><option value=\"PA\">Pennsylvania</option><option value=\"RI\">Rhode Island</option><option value=\"SC\">So. Carolina</option><option value=\"SD\">So. Dakota</option><option value=\"TN\">Tennessee</option><option value=\"TX\">Texas</option><option value=\"UT\">Utah</option><option value=\"VT\">Vermont</option><option value=\"VA\">Virginia</option><option value=\"WA\">Washington</option><option value=\"WV\">West Virginia</option><option value=\"WI\">Wisconsin</option><option value=\"WY\">Wyoming</option></select></div>";
        
        $('#hostInfo').html(libHost2);
        }
    });
    
    var checkBox = $('#billType');
    checkBox.on('change', function() {
        var billType = $('#billType').val();
        
       
        if (billType == "CR"){
            $('#bankPay').html(null);
            if(billType == "NO"){
                document.getElementById('verifyEft').innerHTML = null;
                document.getElementById('verifyRate').innerHTML = null;
                document.getElementById('verifyEnhance').innerHTML = null;
                document.getElementById('verifyMaint').innerHTML = null;
             }
              var total = $('#totalPrice').val();
            var cycleDay = document.getElementById('cycleDay').value;
            var pastDay = document.getElementById('pastDay').value;
            var enhanceFee = document.getElementById('enhanceFee').value;
            var rejectionFee = document.getElementById('rejectionFee').value;
            var lateFee = document.getElementById('lateFee').value;
            
            var monthlyDues = document.getElementById('monthDues').value;
            var monthlyBool = document.getElementById('monthly_bool').value;
            
            //alert(year);
            for (var i = 0; i < 10; i++) {
                var year = document.getElementById('yearDrop').value;
                //alert(i);
                year = parseFloat(year);
                i = parseFloat(i);
                year = year + i;
                var yearDrop = yearDrop + "<option value=\""+year+"\" >"+year+"</option>";
            }
            
           
            
            if(monthlyBool != "0")  {
                var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
            
           // document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
            document.getElementById('verifyEft').innerHTML = eftHtml;
             }
            var creditForm = "<p><strong>Credit Card Payment</strong></p><select  tabindex=\"161\"  name=\"card_type\" id=\"card_type\"><option value>Card Type</option><option value=\"Visa\" >Visa</option><option value=\"MC\" >MasterCard</option><option value=\"Amex\" >American Express</option><option value=\"Disc\" >Discover</option></select><input tabindex=\"162\" name=\"card_name\" type=\"text\" id=\"card_name\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Name on Card\"><input tabindex=\"163\" name=\"card_number\" type=\"text\" id=\"card_number\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Card Number\"><input tabindex=\"164\" name=\"card_cvv\" type=\"text\" id=\"card_cvv\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Security Code\"><div class=\"row\"><div class=\"small-6 large-6 columns\"><label>Exp. Month<select name=\"card_month\" id=\"card_month\"><option value=\"\">Month</option><option value=\"01\" >January</option><option value=\"02\" >February</option><option value=\"03\" >March</option><option value=\"04\" >April</option><option value=\"05\" >May</option><option value=\"06\" >June</option><option value=\"07\" >July</option><option value=\"08\" >August</option><option value=\"09\" >September</option><option value=\"10\" >October</option><option value=\"11\" >November</option><option value=\"12\" >December</option></select></label></div><div class=\"small-6 large-6 columns\"><label>Exp. Year<select name=\"card_year\" id=\"card_year\">"+yearDrop+"</select></label></label></div></div><input tabindex=\"165\"  name=\"credit_pay\" type=\"text\" id=\"credit_pay\" value=\""+total+"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Credit Payment\" disabled=\"disabled\">";
            $('#creditPay').html(creditForm);
            
            
            
        }else if(billType == "BA"){
            $('#creditPay').html(null);
            if(billType == "NO"){
                document.getElementById('verifyEft').innerHTML = null;
                document.getElementById('verifyRate').innerHTML = null;
                document.getElementById('verifyEnhance').innerHTML = null;
                document.getElementById('verifyMaint').innerHTML = null;
             }
           var total = $('#totalPrice').val();
                var bankForm = "<p><strong>Bank Payment</strong></p><input  tabindex=\"170\" name=\"bank_name\" type=\"text\" id=\"bank_name\"  value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Bank Name\"><select  tabindex=\"171\" name=\"account_type\" id=\"account_type\"><option value=\"\">Account Type</option><option value=\"C\" >Personal Checking</option><option value=\"B\" >Business Checking</option><option value=\"S\" >Savings</option></select><input tabindex=\"171\" name=\"account_name\" type=\"text\" id=\"account_name\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Account Name\"><input tabindex=\"172\" name=\"account_num\" type=\"text\" id=\"account_num\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Account Number\"><input tabindex=\"173\" name=\"aba_num\" type=\"text\" id=\"aba_num\" value=\"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"Routing Number\"><input  tabindex=\"174\" name=\"ach_pay\" type=\"text\" id=\"ach_pay\" value=\""+total+"\" onclick=\"return checkServices(this.name,this.id)\" placeholder=\"ACH Payment\" disabled=\"disabled\">";
                $('#bankPay').html(bankForm);
                var cycleDay = document.getElementById('cycleDay').value;
                var pastDay = document.getElementById('pastDay').value;
                var enhanceFee = document.getElementById('enhanceFee').value;
                var rejectionFee = document.getElementById('rejectionFee').value;
                var lateFee = document.getElementById('lateFee').value;
                
                var monthlyDues = document.getElementById('monthDues').value;
                var monthlyBool = document.getElementById('monthly_bool').value;
                
                if(monthlyBool != "0")  {
                    var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";
                
                //document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
                document.getElementById('verifyEft').innerHTML = eftHtml;
                }
        }
    });
    
    
//setPaymentRadioButtons();

  $("#submitPt").click(function() {
    
     var clubId = $('#clubId').val();
     var errors = "";
    var saleArray = $('#purchaseArray').val();
    var secondaryArray = $('#secondaryPurchase').val();
    var gearArray = $('#gearPurchase').val();
    var billType = $('#billType').val();
    var alreadyMember = $('#alreadyMember').val(); 
    
  /*  if(alreadyMember == 0)  {
                    var answer1 = confirm("You are not logged in! If you are already a member please click cancel and login to your account first. If you are not a member click ok to continue. Do you wish to continue?");
                               if (!answer1) {
                                      return false;
                                     }           
                      }*/

    
      //alert(clubId);
     
       
        
       // var test = document.getElementById('terms_conditions').checked;
       //alert(test);
        if(document.getElementById('terms_conditions').checked == false){
           //alert('You must read and agree to the Personal Training Waiver before proceding.');
           //return false;
           errors = errors + 'You must read and agree to the Personal Training Waiver before proceding.';
        }
            //var groupType = $("#group_type").val();

         //   switch(groupType)  {
          //  case 'S':
            var length = $('#numSales').val();
         //   break;
         //   }
            
            
    
        /*if(document.getElementById('liability_host').checked == true || document.getElementById('billing_info').checked == true){
           $('#hostInfo').html(libHost);
           }*/
            
      // if (alreadyMember == 0){
     //    if(document.getElementById('liability_host').checked == true || document.getElementById('billing_info').checked == true){
           //alert('You must fill out the liablilty host section and check the box due to the fact that you are signing up more than one person.');
           //return false;
     //      errors = errors + '<br>You must fill out the liablilty host section because the member signing up is a minor or the billing information is different than the membership information.';
    //    }
      
            var i;
            var memberInfoArray = "";
            var memberEmgContArray = "";
            length = parseInt(length);
            var nameAddArray = "";
            var emgContArray = "";
            
            for(i=1; i <= length; i++)  {
            
            var firstName = '#first_name'+i;
            var middleName = '#middle_name'+i;
            var lastName = '#last_name'+i;
            var streetAddress = '#street_address'+i;
            var cityName = '#city'+i;
            var stateName = '#state'+i;
            var zipCodeNumber = '#zip_code'+i;
            var homePhoneNumber = '#home_phone'+i;
            var cellPhoneNumber = '#home_phone'+i;
            var emailAddress = '#email'+i;
            var dobDate = '#dob'+i;
           // var licNumber = '#lic_num'+i;
            var emgName = '#econt_name'+i;
            var emgRelation = '#econt_relation'+i;
            var emgPhone = '#econt_phone'+i;
            
            //var index = 0;
            //var streetAddressArray = document.getElementsByName('street_address[]');
            //var streetAddress = streetAddressArray[index].value;
            //alert(streetAddress);
            //return false;
            
            var first = $(firstName).val();
            var middle = $(middleName).val();
            var last = $(lastName).val();
            var street = $(streetAddress).val();
            var city = $(cityName).val();
            var state = $(stateName).val();
            var zipCode = $(zipCodeNumber).val();
            var homePhone = $(homePhoneNumber).val();
            var cellPhone = $(cellPhoneNumber).val();
            var email = $(emailAddress).val();
            var dob = $(dobDate).val();
           // var license= $(licNumber).val();
            var eName = $(emgName).val();
            var eRelation = $(emgRelation).val();
            var ePhone = $(emgPhone).val();
            
               if(firstName == "") {
               //alert('Please fill out the '+firstName+ ' field');
               //document.getElementById(firstName).focus();
               //return false;
               errors = errors + 'Please fill out the First Name field.';
        
               }
              if(lastName == "") {
                 //alert('Please fill out the '+lastName+ ' field');
                 //document.getElementById(lastName).focus();
                 //return false;
                 errors = errors + '<br>Please fill out the Last Name field.';
        
                 }
              if(streetAddress == "") {
                //alert('Please fill out the '+streetAddress+ ' field');
                 //document.getElementById(streetAddress).focus();
                //return false;
                errors = errors + '<br>Please fill out the Address field.';
        
                }
              if(city == "") {
               //alert('Please fill out the '+cityName+ ' field');
               //document.getElementById(cityName).focus();
               //return false;
               errors = errors + '<br>Please fill out the City field.';
        
              }
              if(state == "") {
                //alert('Please select a '+stateName+ ' State');
               // document.getElementById(stateName).focus();
                //return false;
                errors = errors + '<br>Please select a State.';
        
               }
              if(zipCode == "") {
                 // alert('Please fill out the '+zipCodeNumber+ ' field');
                 // document.getElementById(zipCodeNumber).focus();
                 // return false;
                  errors = errors + '<br>Please fill out the Zipcode field.';
        
                 }
              if(homePhone == "") {
                 // alert('Please fill out the ' +homePhoneNumber+ ' Primary Phone field');
                  //document.getElementById(homePhoneNumber).focus();
                  //return false;
                  errors = errors + '<br>Please fill out the Phone field.';
        
                  }
              /*if(cellPhone == "") {
                 // alert('Please fill out the '+cellPhoneNumber+ ' field');
                  //document.getElementById(cellPhoneNumber).focus();
                  //return false;
                  errors = errors + '<br>Please fill out the Cell Phone field.';
        
                  }*/
              if(email == "") {
                      // alert('Please fill out the '+emailAddress+ ' field');
                     //  document.getElementById(emailAddress).focus();
                     //  return false;
                       errors = errors + '<br>Please fill out the Email field.';
        
                       }
              if(dob == "") {
                      //  alert('Please fill out the '+dobDate+ ' field');
                      //  document.getElementById(dobDate).focus();
                      //  return false;
                        errors = errors + '<br>Please fill out the Date of Birth field.';
        
                        }
              /*/* if(license == "") {
                          alert('Please fill out the '+licNumber+ ' field');
                          document.getElementById(licNumber).focus();
                          return false;
                          }
             if(eName == "")  {
                   alert('Please fill out all of the '+emgName+ ' field');
                   document.getElementById(emgName).focus();
                   return false;
                   }
              if(eRelation == "")  {
                  alert('Please fill out all of the '+eRelation+ ' field');
                  document.getElementById(eRelation).focus();
                  return false;
                  }
              if(ePhone == "")  {
                 alert('Please fill out all of the '+ePhone+ ' field');
                 document.getElementById(ePhone).focus();
                 return false;
                 }*/
            /*  if(firstName == "" &&  lastName == "" &&  streetAddress == "" && city == "" && state == "" &&  zipCode == "" && homePhone == "" && cellPhone == "" && email == "" && dob == "") {
                alert('Please fill out all of the Contact Information');
                document.getElementById('first_name1').focus();
                return false;
                }*/
            //nameAddArray = nameAddArray.replace(/#/g, "");
            street = street.replace(/#/g, "Num");            
            //alert(length);
            //alert(streetAddress);
            //alert(street);
            nameAddArray += (first+'|'+middle+'|'+last+'|'+street+'|'+city+'|'+state+'|'+zipCode+'|'+homePhone+'|'+cellPhone+'|'+email+'|'+dob+'#');
            emgContArray += (eName+'|'+eRelation+'|'+ePhone+'#');
            }
              // alert(nameAddArray);
            $("#member_info_array").val(nameAddArray);
            $("#emg_info_array").val(emgContArray);
            
            if(document.getElementById('liability_host').checked == true || document.getElementById('billing_info').checked == true){
               var firstNameHost = document.getElementById('first_name_li').value;
            var middleNameHost = document.getElementById('middle_name_li').value;
            var lastNameHost = document.getElementById('last_name_li').value;
            var streetAddressHost = document.getElementById('street_address_li').value;
            var cityHost = document.getElementById('city_li').value;
            var stateHost = document.getElementById('state_li').value;
            var zipCodeHost = document.getElementById('zip_code_li').value;
            var homePhoneHost = document.getElementById('home_phone_li').value;
            var cellPhoneHost = document.getElementById('home_phone_li').value;
            var emailHost = document.getElementById('email_li').value;
            var dobHost = document.getElementById('dob_li').value;
            //var licNumberHost = document.getElementById('lic_num_lib').value;




           if(lastNameHost == "") {
           //alert('Please fill out the Liability Host  Last Name field');
           //document.getElementById('last_name_li').focus();
           //return false;
           errors = errors + '<br>Please fill out the Liability Host  Last Name field.';
           }

          if(streetAddressHost == "") {
          // alert('Please fill out the Liability Host  Street Address field');
           //document.getElementById('street_address_li').focus();
           //return false;
           errors = errors + '<br>Please fill out the Liability Host  Street Address field.';
           }

          if(cityHost == "") {
           //alert('Please fill out the Liability Host  City field');
          // document.getElementById('city_lib').focus();
          // return false;
           errors = errors + '<br>Please fill out the Liability Host  City field.';
           }

          if(stateHost == "") {
           //alert('Please select a Liability Host State');
           //document.getElementById('state_li').focus();
           //return false;
           errors = errors + '<br>Please select a Liability Host State.';
           }

          if(zipCodeHost == "") {
           //alert('Please fill out the Liability Host  Zip Code field');
           //document.getElementById('zip_code_li').focus();
           //return false;
           errors = errors + '<br>Please fill out the Liability Host  Zip Code field.';
           }

         if(homePhoneHost == "") {
          //alert('Please fill out the Liability Host  Primary Phone field');
          //document.getElementById('home_phone_li').focus();
          //return false;
          errors = errors + '<br>Please fill out the Liability Host Phone field.';
          }

          /*if(cellPhoneHost == "") {
           //alert('Please fill out the Liability Host  Cell Phone field');
           //document.getElementById('cell_phone_li').focus();
           //return false;
           errors = errors + '<br>Please fill out the Liability Host  Cell Phone field.';
           }*/

          if(emailHost == "") {
           //alert('Please fill out the Liability Host  Email Address field');
           //document.getElementById('email_li').focus();
           //return false;
           errors = errors + '<br>Please fill out the Liability Host  Email Address field.';
           }

          if(dobHost == "") {
           //alert('Please fill out the Liability Host  Date of Birth field');
           //document.getElementById('dob_li').focus();
          // return false;
           errors = errors + '<br>Please fill out the Liability Host  Date of Birth field.';
           }

         /* if(licNumberHost == "") {
           alert('Please fill out the Liability Host  Drivers License field');
           document.getElementById('lic_num_lib').focus();
           return false;
           }*/


            /*if(firstNameHost == "" &&  lastNameHost == "" &&  streetAddressHost == "" && cityHost == "" && stateHost == "" &&  zipCodeHost == "" && homePhoneHost == "" && cellPhoneHost == "" && emailHost == "" && dobHost == "") {
            alert('Please fill out all of the Liability Host Information');
            document.getElementById('first_name_li').focus();
            return false;
            }*/

            var hostInfoArray = (firstNameHost+'|'+middleNameHost+'|'+lastNameHost+'|'+streetAddressHost+'|'+cityHost+'|'+stateHost+'|'+zipCodeHost+'|'+homePhoneHost+'|'+cellPhoneHost+'|'+emailHost+'|'+dobHost);
            
            $("#host_info_array").val(hostInfoArray); 
            }
            
      
      
      
      ////////////==================================================================
      //////////////============================================================BILLING INFO FOR CS
            var nameSalt;
            //now get the address and name info
              if(document.getElementById('liability_host').checked == true || document.getElementById('billing_info').checked == true)   {
                nameSalt = '_li';
                var hostBool = 1;
                }else{
                    nameSalt = 1;
                    var hostBool = 0;
                }
                //check if the liability host is checked

            var streetAddress = '#street_address'+nameSalt;
            var cityName = '#city'+nameSalt;
            var stateName = '#state'+nameSalt;
            var zipCodeNumber = '#zip_code'+nameSalt;
            var homePhoneNumber = '#home_phone'+nameSalt;
            var emailAddress = '#email'+nameSalt;
            //var licNumber = '#lic_num'+nameSalt;
                  
            var streetBill = $(streetAddress).val();
            var cityBill = $(cityName).val();
            var stateBill = $(stateName).val();
            var zipCodeBill = $(zipCodeNumber).val();
            var homePhoneBill = $(homePhoneNumber).val();
            var emailBill = $(emailAddress).val();
            //var licenseBill = $(licNumber).val();
                
       // }
            //do a check onthe credit csrd to auth netif present
            var cardType = $("#card_type").val();
            var cardName = $("#card_name").val();
            var cardNumber = $("#card_number").val();
            var cardCvv = $("#card_cvv").val();
            var cardMonth = $("#card_month").val();
            var cardYear = $("#card_year").val();
            var creditPayment = $("#credit_pay").val();       
            
            var bankName = $("#bank_name").val();
            var accountType = $("#account_type").val();
            var accountName = $("#account_name").val();
            var accountNumber = $("#account_num").val();
            var routingNumber = $("#aba_num").val();
            var achPayment = $("#ach_pay").val();
           // var creditPayment = $("#credit_pay").val();
            var cashPayment = $("#cash_pay").val();
            var checkPayment = $("#check_pay").val();
            var checkNumber = $("#check_number").val();
            var checkNumberField = $("#check_number").val();
            var checkNumberFieldName = 'check_number';
            
            //=======================================================================================
            //======================================================================================                        
                 if(billType == "NO"){
                    errors = errors + "You must select a billing option!";
                }
               
                //here we make sure that a monthly billing cycle is selected if it exists for the service
                var monthlyBillingSelected = "";

                if(billType == "CR") {
                  $("monthly_billing_selected").val('CR');
                  monthlyBillingSelected = 'CR';
                }
                if(billType == "BA") {
                  $("monthly_billing_selected").val('BA');
                  monthlyBillingSelected = 'BA';
                }
                
                if($('#verifyEft').html() != ""){
                    if($("monthDues").val() != 0.00 || $("monthDues").val() != ""){
                      if($('input:radio[name=eftVerify]:checked').val() == undefined || $('input:radio[name=eftVerify]:checked').val() == 'No'){
                            //alert('Please read the \"MONTHLY TRANSACTION REQUEST:\" and agree to the terms by selecting yes to continue.');
                            //return false;
                            errors = errors + '<br>Please read the \"MONTHLY TRANSACTION REQUEST:\" and agree to the terms by selecting yes to continue.';
                        }
                  }  
                }
                 
                 
                
               
                //achPayment.trim();
                if(achPayment == "" && creditPayment == "")  {
                    //alert('Please enter a payment amount into one or more of the following fields: \"Credit Payment\", \"ACH Payment\"');
                    //return false;
                    errors = errors + '<br>Please enter a payment amount into one or more of the following fields: \"Credit Payment\", \"ACH Payment\".';
                    }  
                                           
                    //make sure the payment amount is the same as todays payment also make sure cc or bank feilds are filled out
                    var todaysPayment = $("#today_payment").val();
                    todaysPayment = parseFloat(todaysPayment);
                    todaysPayment = todaysPayment.toFixed(2);
                    
                if(billType == "BA") {              
                    if(achPayment == "") {
                       achPayment = 0;  
                       }else{
                       var bankName = document.getElementById('bank_name').value;
                       var accountType = document.getElementById('account_type').value;
                       var accountName = document.getElementById('account_name').value;
                       var accountNumber = document.getElementById('account_num').value;
                       var routingNumber = document.getElementById('aba_num').value;
                       var routingValue = document.getElementById('aba_num').value;
                       var routingName = document.getElementById('aba_num');
                       var i;
                       var n;
                       var t;


           if(bankName == "")  {
            // alert('Please enter a Bank Name');
            // document.getElementById('bank_name').focus();
            // return false;    
             errors = errors + '<br>Please enter a Bank Name.';        
            }                

            if(accountType == "")  {
            // alert('Please select an Account Type');
            // document.getElementById('account_type').focus();
            // return false;     
             errors = errors + '<br>Please select an Account Type.';       
            }        

            if(accountName == "")  {
            // alert('Please enter the name on the account');
            // document.getElementById('account_name').focus();
            // return false;  
             errors = errors + '<br>Please enter the name on the account.';          
            }     

            if(accountNumber == "")  {
            // alert('Please enter the Account Number');
            // document.getElementById('account_num').focus();
             //return false;   
             errors = errors + '<br>Please enter the Account Number.';         
            }            

            if(routingNumber == "")  {
            // alert('Please enter the Routing Number');
            // document.getElementById('aba_num').focus();
             //return false; 
             errors = errors + '<br>Please enter the Routing Number.';           
            }  
            
            
                            
                             
                              if (isNaN(routingValue)) {
                              // alert('Routing Number may only contain numbers');
                               document.getElementById('aba_num').value = "";
                              // routingName.focus();   
                               //return false;
                               errors = errors + '<br>Routing Number may only contain numbers.';
                               }
                            
                              if (routingValue.length < 9) {
                                // alert('Routing Number is too short. Routing number must be 9 charachters in length.');
                                 document.getElementById('aba_num').value = "";
                                 //routingName.focus();   
                                 //return false;
                                 errors = errors + '<br>Routing Number is too short. Routing number must be 9 charachters in length.';
                                } 
                                
                               if (routingValue.length > 9) {
                                 //alert('Routing Number is too long. Routing number must be 9 charachters in length.');
                                 document.getElementById('aba_num').value = "";
                                // routingName.focus();   
                                // return false;
                                 errors = errors + '<br>Routing Number is too long. Routing number must be 9 charachters in length.';
                                } 
                             
                             
                               t = "";
                              for (i = 0; i < routingValue.length; i++) {
                                c = parseInt(routingValue.charAt(i), 10);
                                       if (c >= 0 && c <= 9) {
                                           t = t + c;
                                         }
                                  }
                             
                             
                              n = 0;
                              for (i = 0; i < t.length; i += 3) {
                                   n += parseInt(t.charAt(i),     10) * 3
                                   +  parseInt(t.charAt(i + 1), 10) * 7
                                   +  parseInt(t.charAt(i + 2), 10);
                                   }
                            
                              // If the resulting sum is an even multiple of ten (but not zero),
                              // the aba routing number is good.
                            
                                            if (n != 0 && n % 10 == 0)  {
                                               return true;
                                               }else{
                                                 //alert('Routing Number is not in the correct format');
                                                 document.getElementById('aba_num').value = "";
                                                 //routingName.focus();   
                                                 //return false;
                                                 errors = errors + '<br>Routing Number is not in the correct format.';
                                                }
  
                              }
                     }else{
                            achPayment = 0;
                         }          
                              
                     if(billType == "CR") {
                            if(creditPayment == "") {  
                              creditPayment = 0;
                              }else{
                                var cardType = document.getElementById('card_type').value;
                                var cardName = document.getElementById('card_name').value;
                                var cardNumber = document.getElementById('card_number').value;
                                var cardCvv = document.getElementById('card_cvv').value;
                                var cardMonth = document.getElementById('card_month').value;
                                var cardYear = document.getElementById('card_year').value;




            
            if(cardName == "")  {
            // alert('Please enter the \"Name on Card\"');
            // document.getElementById('card_name').focus();
            // return false;  
             errors = errors + '<br>Please enter the \"Name on Card\".';        
            }            

            if(cardNumber == "")  {
            // alert('Please enter the \"Card Number\"');
            // document.getElementById('card_number').focus();
           //  return false;   
             errors = errors + '<br>Please enter the \"Card Number\".';         
             }
             
              if(cardNumber != "")  {
                cardNumber = cardNumber.replace(/\s+/g, "");
                cardNumber = cardNumber.replace(/-/g, ""); 

                if(cardType == "") {
                    errors = errors + '<br>Please select a Card type';
                     //return errors;     
                            }else{
                                    if (cardType == "Visa") {
                                          // Visa: length 16, prefix 4, dashes optional.
                                          var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
                                          var cardText = 'Visa';
                                         }else if(cardType == "MC") {
                                          // Mastercard: length 16, prefix 51-55, dashes optional.
                                          var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
                                          var cardText = 'Master Card';
                                          }else if(cardType == "Disc") {
                                          // Discover: length 16, prefix 6011, dashes optional.
                                          var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
                                          var cardText = 'Discover';
                                          }else if(cardType == "Amex") {
                                          // American Express: length 15, prefix 34 or 37.
                                          var re = /^3[4,7]\d{13}$/;
                                          var cardText = 'American Express';
                                           }else if(cardType == "Diners") {
                                          // Diners: length 14, prefix 30, 36, or 38.
                                          var re = /^3[0,6,8]\d{12}$/;
                                          var cardText = 'Diners Club';
                                          }
                                       
                                      
                                             if(!re.test(cardNumber)) {  
                                                errors = errors + '<br>Invalid ' +cardText+ ' Credit Card Number';
                                                //alert('Invalid ' +cardText+ ' Credit Card Number');
                                               // document.getElementById('card_number').value ="";
                                              //  document.getElementById('card_number').focus();
                                              //  return false;
                                               }
                                    
                                           
                                              
                                       
                                       var checksum = 0;
                                       for (var i=(2-(cardNumber.length % 2)); i<= cardNumber.length; i+=2) {
                                          checksum += parseInt(cardNumber.charAt(i-1));
                                           }
                                       // Analyze odd digits in even length strings or even digits in odd length strings.
                                       for (var i=(cardNumber.length % 2) + 1; i<cardNumber.length; i+=2) {
                                          var digit = parseInt(cardNumber.charAt(i-1)) * 2;
                                          if (digit < 10) { 
                                          checksum += digit; 
                                          }else{ 
                                          checksum += (digit-9); 
                                          }
                                       }
                                       
                                       
                                       
                                       if ((checksum % 10) == 0) {
                                           //return true; 
                                           }else{
                                            errors = errors + '<br>Invalid Credit Card Number';
                                           //alert('Invalid Credit Card Number');
                                           //document.getElementById('card_number').value ="";
                                           
                                         //  document.getElementById('card_number').focus();
                                         //  return false;
                                          }  
                                        //  return errors; 
                                }           
              }
            

            if(cardCvv == "")  {
            // alert('Please enter the \"Security Code\"');
             //document.getElementById('card_cvv').focus();
            // return false;     
             errors = errors + '<br>Please enter the \"Security Code\".';       
            } 
            
            if(cardCvv != "")  {
            var cardType = document.getElementById('card_type').value;
                    var cvvValue = document.getElementById('card_cvv').value;
                    var cvvName = document.getElementById('card_cvv');
                    var cvvLength;
                    
                    cvvValue = cvvValue.replace(/\s+/g, "");
                    
                    switch(cardType)  {
                    case 'Visa':
                    cvvLength = 3; 
                    break;
                    case 'MC':
                    cvvLength = 3; 
                    break;
                    case 'Amex':
                    cvvLength = 4; 
                    break;
                    case 'Disc':
                    cvvLength = 3; 
                    break;  
                    }
                    
                    
                    if (isNaN(cvvValue)) {
                      // alert('Security Code may only contain Numbers');
                       document.getElementById(cvvField).value = "";
                      // cvvName.focus();   
                       //return false;
                       errors = errors + '<br>Security Code may only contain Numbers.';
                    }
                    
                    if(cvvValue.length < cvvLength)  {
                       //alert('Security Code is too short');
                       document.getElementById(cvvField).value = "";
                      // cvvName.focus();   
                      // return false;
                       errors = errors + '<br>Security Code is too short.';
                    }
                    
                    if(cvvValue.length > cvvLength)  {
                       //alert('Security Code is too long');
                       document.getElementById(cvvField).value = "";
                      // cvvName.focus();   
                      // return false;
                       errors = errors + '<br>Security Code is too long.';
                    }
        
             }
            
            
            

            if(cardMonth == "")  {
            // alert('Please select the \"Card Month\"');
             //document.getElementById('card_month').focus();
             //return false;         
             errors = errors + '<br>Please select the \"Card Month\".';   
            }            

            if(cardYear == "")  {
             //alert('Please select the \"Card Year\"');
             //document.getElementById('card_year').focus();
             //return false;   
             errors = errors + '<br>Please select the \"Card Year\".';         
            }          
                  } 
                  }else{
                            creditPayment = 0;
                         }          
                            achPayment = parseFloat(achPayment);
                            creditPayment = parseFloat(creditPayment);          
                            
                            
                            var paymentTotals = achPayment + creditPayment;
                            //check to see if amount is greater than todays payment
                                        if(paymentTotals > todaysPayment) {
                                             paymentTotals = paymentTotals.toFixed(2); 
                                             todaysPayment = todaysPayment.toFixed(2); 
                                           //alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is greater than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                                           // return false;
                                            errors = errors + '<br>The total amount entered into the payment field(s) "'+paymentTotals+'"  is greater than the value entered into the "Todays Payment" field "'+todaysPayment+'".';
                                          }
                            
                            //now check to see if it is less
                                        if(paymentTotals < todaysPayment) {
                                             paymentTotals = paymentTotals;//.toFixed(2); 
                                             todaysPayment = todaysPayment;//.toFixed(2); 
                                          // alert('The total amount entered into the payment field(s) "'+paymentTotals+'"  is less than the value entered into the "Todays Payment" field "'+todaysPayment+'".'); 
                                            //return false;
                                            errors = errors + '<br>The total amount entered into the payment field(s) "'+paymentTotals+'"  is less than the value entered into the "Todays Payment" field "'+todaysPayment+'".';
                                          }


var sig = document.getElementById('input_name').value;
//alert(sig);
 if(sig == '')  {
                   // var answer1 = confirm("You have not saved the signature. Do you wish to continue?");
                    //           if (!answer1) {
                                      //return false;
                                      
                      //               }  
                                     errors = errors + '<br>You have not saved the signature.';         
                      }


               
              

                //disable save button to prevent double charges
                $(".buttonSubmit").attr("disabled", "disabled");
                     //alert('fu');
                
                //encode card type
                cardType = encodeURIComponent(cardType);
                cardName = encodeURIComponent(cardName);
                cardNumber = encodeURIComponent(cardNumber);
                cardCvv = encodeURIComponent(cardCvv);
                cardMonth = encodeURIComponent(cardMonth);
                cardYear = encodeURIComponent(cardYear);
                creditPayment = encodeURIComponent(creditPayment);
                
                //encode banking info
                bankName = encodeURIComponent(bankName);
                accountType = encodeURIComponent(accountType);
                accountName = encodeURIComponent(accountName);
                accountNumber = encodeURIComponent(accountNumber);
                routingNumber = encodeURIComponent(routingNumber);
                street = encodeURIComponent(street);
                city = encodeURIComponent(city);
                state = encodeURIComponent(state);
                zipCode = encodeURIComponent(zipCode);
                homePhone = encodeURIComponent(homePhone);
                email = encodeURIComponent(email);
                achPayment = encodeURIComponent(achPayment);
                
                //additional sale arrays
              
                var dues = document.getElementById('monthDues').value;
                //alert(dues);
                errors = errors.trim();
                if(errors != ""){
                    $('#successBox').html('Please fix these errors then resubmit!  <br>'+errors+' ');
                    $("#successBox").css( { "color" : "red"} );
                    $('.buttonSubmit').prop('disabled', false);
                    return false;
                }
                
                 $.ajax ({
                 type: "POST",
                 url: "php/contractCardCheckTraining.php",
                 cache: false,
                 async: false,
                 dataType: 'html', 
                 data: {card_type: cardType, card_name: cardName, card_number: cardNumber, card_cvv: cardCvv, card_month: cardMonth, card_year: cardYear, credit_pay: creditPayment, bank_name: bankName, account_type: accountType, account_name: accountName, account_number: accountNumber, routing_number: routingNumber, account_street: streetBill, account_city: cityBill, account_state: stateBill, account_zip: zipCodeBill, account_phone: homePhoneBill, account_email: emailBill, ach_pay: achPayment, name_add_array: nameAddArray, emg_contact_array: emgContArray, host_billing_info_array: hostInfoArray, sale_array: saleArray, length: length, hostBool: hostBool, sig: sig, clubId: clubId, monthlyBillingSelected: monthlyBillingSelected, secondaryArray: secondaryArray, gearArray: gearArray},              
                 success: function(data) {    
                 //alert(data);
                         
                    if(data != 11) {
                        $('.buttonSubmit').prop('disabled', false);
                         $('#successBox').html('Transaction failed!  '+data+' ');
                        $("#successBox").css( { "color" : "red"} );
                        alert(data);
                        $( "#card_type" ).focus();
                       }else if(data == 11) {
                         $('#successBox').html('Your transaction was successful. A window will now open so you can print out your contract. Please make sure you have any popup blocker disabled.');
                        $("#successBox").css( { "color" : "green"} );
                        setTimeout('openContractWindow()', 1000);                  
                                             }
                                             
                     }//end function success
                    
              }); //end ajax              
         
        
    });
});
//------------------------------------------------------------------------------------------------------------------------------------------------
function setPaymentRadioButtons(monthTotal)   {
   
var cycleDay = document.getElementById('cycleDay').value;
var pastDay = document.getElementById('pastDay').value;
var enhanceFee = document.getElementById('enhanceFee').value;
var rejectionFee = document.getElementById('rejectionFee').value;
var lateFee = document.getElementById('lateFee').value;

var monthlyDues = document.getElementById('monthDues').value;
var monthlyBool = document.getElementById('monthly_bool').value;
//get the file permissions for the radios
var monthBit = document.getElementById('month_bit').value;
var monthBitArray = monthBit.split("");
var creditDisabled;
var bankDisabled;
//alert(monthlyBool);

if(monthBitArray[2] == 1) {
    bankDisabled = "";
    }else{
    bankDisabled ='disabled="disabled"';
    }    
    
if(monthBitArray[3] == 1) {
    creditDisabled = "";
    }else{
    creditDisabled ='disabled="disabled"';
    }    


var buttonTitle= 'Set Monthly Billing:';
var creditRadio = '<input type="radio" id="monthly_billing1" name="monthly_billing"  value="CR" onClick="return checkServices(this.name,this.id)"'+creditDisabled+'/>';
var bankRadio =  '<input type="radio"  id="monthly_billing2" name="monthly_billing"   value="BA" onClick="return checkServices(this.name,this.id)"'+bankDisabled+'/>';


if(monthlyBool == "0")  {
document.getElementById('setMonth1').innerHTML = "";
document.getElementById('setMonth2').innerHTML = "";
document.getElementById('setMonthCredit').innerHTML = "";
document.getElementById('setMonthBank').innerHTML = "";
}else{
    var eftHtml = "<b><input tabindex=\"140\" type=\"radio\" value=\"Yes\" name=\"eftVerify\">Yes&nbsp;&nbsp;</input><input type=\"radio\" value=\"No\" name=\"eftVerify\">No</input><span class=\"subHeader\">&nbsp;&nbsp;&nbsp;MONTHLY TRANSACTION REQUEST:</span><p>I authorize my credit card company and or bank to make a payment of <span class=\"boldLine\">$"+monthlyDues+"</span> and charge it to my account on or close to day <span class=\"boldLine\">"+cycleDay+"</span> of every month as indicated by the terms of this contract. I acknowledge that a service fee of <span class=\"boldLine\">\$"+rejectionFee+"</span> will be assessed and charged for any payment rejected for insufficient funds or any other reason. I acknowledge that a late fee of <span class=\"boldLine\">\$"+lateFee+"</span> will be assessed and charged should any monthly payment becomes <span class=\"boldLine\">"+pastDay+"</span> days past due.I acknowledge that monthly payments made on a regular basis can vary in amount based on terms, discounts, and or promotions, set forth and agreed upon by this contract.</p>  </b>";

document.getElementById('setMonth1').innerHTML = buttonTitle;
document.getElementById('setMonth2').innerHTML = buttonTitle;
document.getElementById('setMonthCredit').innerHTML = creditRadio;
document.getElementById('setMonthBank').innerHTML = bankRadio;
document.getElementById('monthlyText').innerHTML = "Please select a Monthly Billing option below by clicking the button next to \"Set Monthly Billing\"";
document.getElementById('verifyEft').innerHTML = eftHtml;


}
}
//-----------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------------------
function setTodaysPayment()  {
//alert(todaysPayment);
var totalDue;
var balanceDue;
var balanceDueForm;

setPaymentRadioButtons();



totalDue = document.getElementById('totalPrice').value;
totalDueBackup = document.getElementById('balance_due_backup').value;
todaysPayment = document.getElementById('today_payment').value;
if(todaysPayment == ""){
     todaysPayment = 0;
}
//alert('today pay '+totalDue);
//alert(monthlyPayment);
if(isNaN(todaysPayment)) {
  todaysPayment = 0;
  alert('The value you entered is not a number.');
      return false;
  }

totalDue = parseFloat(totalDue);

todaysPayment = parseFloat(todaysPayment);

  
balanceDue = totalDueBackup - todaysPayment;
balanceDueForm = balanceDue;
balanceDueForm = balanceDueForm.toFixed(2);

if(totalDue == 0) {
balanceDue = 0;
todaysPayment = 0;
balanceDueForm = "";

//set the balance due date
//setBalanceDueDate();

}

if(isNaN(balanceDue)) {
  balanceDue = parseFloat(totalDueBackup);
  }

balanceDue = balanceDue.toFixed(2); 
//
todaysPayment = todaysPayment.toFixed(2);
//if(isNaN(balanceDue)) {
//  balanceDue = totalDueBackup;
//  }
document.getElementById('balance_due').value = balanceDueForm;
//document.getElementById('balance_due').value = balanceDue;
//document.getElementById('today_payment').value = todaysPayment;
document.getElementById('todayPayTwoTotal').innerHTML = todaysPayment;


}
//================================================================
function validCreditCard() {

var cardType = document.getElementById('card_type').value;
var cardNumber = document.getElementById('card_number').value;
var errors = "";

//clear out any garbage charachters
cardNumber = cardNumber.replace(/\s+/g, "");
cardNumber = cardNumber.replace(/-/g, ""); 

if(cardType == "") {
    errors = errors + 'Please select a Card type';
     return errors;     
            }else{
                 if (cardType == "Visa") {
                      // Visa: length 16, prefix 4, dashes optional.
                      var re = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
                      var cardText = 'Visa';
                     }else if(cardType == "MC") {
                      // Mastercard: length 16, prefix 51-55, dashes optional.
                      var re = /^5[1-5]\d{2}-?\d{4}-?\d{4}-?\d{4}$/;
                      var cardText = 'Master Card';
                      }else if(cardType == "Disc") {
                      // Discover: length 16, prefix 6011, dashes optional.
                      var re = /^6011-?\d{4}-?\d{4}-?\d{4}$/;
                      var cardText = 'Discover';
                      }else if(cardType == "Amex") {
                      // American Express: length 15, prefix 34 or 37.
                      var re = /^3[4,7]\d{13}$/;
                      var cardText = 'American Express';
                       }else if(cardType == "Diners") {
                      // Diners: length 14, prefix 30, 36, or 38.
                      var re = /^3[0,6,8]\d{12}$/;
                      var cardText = 'Diners Club';
                      }
                   
                  
                         if(!re.test(cardNumber)) {  
                            errors = errors + 'Invalid ' +cardText+ ' Credit Card Number';
                            //alert('Invalid ' +cardText+ ' Credit Card Number');
                           // document.getElementById('card_number').value ="";
                          //  document.getElementById('card_number').focus();
                          //  return false;
                           }
                
                       
                          
                   
                   var checksum = 0;
                   for (var i=(2-(cardNumber.length % 2)); i<= cardNumber.length; i+=2) {
                      checksum += parseInt(cardNumber.charAt(i-1));
                       }
                   // Analyze odd digits in even length strings or even digits in odd length strings.
                   for (var i=(cardNumber.length % 2) + 1; i<cardNumber.length; i+=2) {
                      var digit = parseInt(cardNumber.charAt(i-1)) * 2;
                      if (digit < 10) { 
                      checksum += digit; 
                      }else{ 
                      checksum += (digit-9); 
                      }
                   }
                   
                   
                   
                   if ((checksum % 10) == 0) {
                       //return true; 
                       }else{
                        errors = errors + 'Invalid Credit Card Number';
                       //alert('Invalid Credit Card Number');
                       //document.getElementById('card_number').value ="";
                       
                     //  document.getElementById('card_number').focus();
                     //  return false;
                      }  
                      return errors; 
            }


      
      
}      

//---------------------------------------------------------------------------------------------------------------------------------------------
function getMemberNumber()   {

              var memberNumber = document.getElementById('mem_num').value;
                    if(memberNumber == "") {
                      memberNumber = 1;
                     }
              return memberNumber;
}
//---------------------------------------------------------------------------------------------------------------------------------------------


//---------------------------------------------------------------------------------------------------------------------------------------------
function browserKinks() {

// var versionSwitch = document.getElementById('parse_switch').value;

// if(versionSwitch != "3") {
     this.phoneField=null;
     this.routeField=null;
     this.dobField=null;
     this.cardField=null;
     this.cvvField=null;
     this.zipField=null;
     this.emailField=null;
 // }


}
//------------------------------------------------------------------------------------------------------------------------------------------------
function checkDayMonth(month, day) {

switch(month)  {
case '01':
 if(day > 31) {
 return false;
 }
break;
case '02':
if(day > 29) {
return false;
}
break;
case '03':
if(day > 31) {
return false;
}
break;
case '04':
if(day > 30) {
return false;
}
break;  
case '05':
if(day >31) {
return false;
}
break;  
case '06':
if(day > 30) {
return false;
}
break;  
case '07':
if(day > 31) {
return false;
}
break; 
case '08':
if(day > 31) {
return false;
}
break; 
case '09':
if(day > 30) {
return false;
}
break; 
case '10':
if(day > 31) {
return false;
}
break;  
case '11':
if(day >30) {
return false;
}
break;  
case '12':
if(day > 31) {
return false;
}
break;  
}


}
//--------------------------------------------------------------------------------------------------------------
function checkDob()  {

var dobValue = document.getElementById(dobField).value;
var dobName = document.getElementById(dobField);

var regexObj =/^(\d{2})\/(\d{2})\/(\d{4})$/;

if(!regexObj.test(dobValue)) {
   alert('You have entered an invalid Date of Birth format. Please use \"mm/dd/yyyy\" ');
   document.getElementById(dobField).value ="";
   dobName.focus();
   browserKinks();
   return false;
   }else{
     var dobArray = dobValue.split( '/' );
      if(dobArray[0] > 12) {
        alert('You have entered an invalid Date of Birth month');
        document.getElementById(dobField).value ="";
        dobName.focus();
        browserKinks();
        return false;
        }
        
      if(dobArray[1] > 31) {
         alert('You have entered an invalid Date for the day of birth');
         document.getElementById(dobField).value ="";
         dobName.focus();
         browserKinks();
         return false; 
        }else{
               var boon = checkDayMonth(dobArray[0], dobArray[1]);
                                 if(boon == false)  {
                                   alert('The day you entered exceeds the number of days in the month');
                                   document.getElementById(dobField).value ="";
                                   dobName.focus();
                                   browserKinks();                                   
                                   return false;                                                                   
                                  }       
        }
      
            
      
   }

}
//---------------------------------------------------------------------------------------------------------------
function checkPhoneNumber()  {

var phoneValue = document.getElementById(phoneField).value;
var phoneName = document.getElementById(phoneField);

phoneValue = phoneValue.replace(/\s+/g, " ");

var regexObj = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;

if (regexObj.test(phoneValue)) {
    var formattedPhoneNumber = phoneValue.replace(regexObj, "($1) $2-$3");
        document.getElementById(phoneField).value = formattedPhoneNumber;
     }else{
               alert('You have entered an invalid Phone Number or format.  The Phone Number must contain an area code followed by the number');
               document.getElementById(phoneField).value = "";
               phoneName.focus();
              browserKinks();
               return false;
    }

}
//----------------------------------------------------------------------------------------------------------------
function checkZipCode()  {

var zipValue = document.getElementById(zipField).value;
var zipNameField = document.getElementById(zipField);

//zipValue = parseInt(zipValue);
if (isNaN(zipValue)) {
   alert('Zip Code may only contain Numbers');   
 //  setTimeout ('document.getElementById(zipField).focus()',300);
 //  setTimeout ('alert(\'Zip Code may only contain Numbers\')', 300);    
   document.getElementById(zipField).value = "";
   document.getElementById(zipField).focus();
   browserKinks();
   return false;
}
if(zipValue.length < 5) {
  document.getElementById(zipField).focus();
  alert('The Zip Code you entered is too short');
  document.getElementById(zipField).value = "";
  browserKinks();
  return false;
} 



}
//-----------------------------------------------------------------------------------------------------------------
function checkEmail()  {

var emailValue = document.getElementById(emailField).value;
var fieldName = document.getElementById(emailField);

// this checks the validity of the user name to see if it is a valid email address
var at="@";
var dot=".";
var lat=emailValue.indexOf(at);
var lstr=emailValue.length;
var ldot=emailValue.indexOf(dot);

        if(emailValue == "")  {
          alert("You have entered an invalid email address");
          document.getElementById(emailField).value ="";
          fieldName.focus(); 
          browserKinks();
          return false;
        }
        
		if(emailValue.indexOf(at)==-1){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		   return false;
		}

		if(emailValue.indexOf(at)==-1 || emailValue.indexOf(at)==0 || emailValue.indexOf(at)==lstr){
		   alert("You have entered an invalid email address");
		   document.getElementById(emailField).value ="";
           fieldName.focus();
          browserKinks();
		   return false;
		}

		if(emailValue.indexOf(dot)==-1 || emailValue.indexOf(dot)==0 || emailValue.indexOf(dot)==lstr){
		  alert("You have entered an invalid email address");	
		  document.getElementById(emailField).value ="";
           fieldName.focus();
           browserKinks();
		    return false;
		}

		 if(emailValue.indexOf(at,(lat+1))!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.substring(lat-1,lat)==dot || emailValue.substring(lat+1,lat+2)==dot){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }

		 if(emailValue.indexOf(dot,(lat+2))==-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;
		 }
		
		 if(emailValue.indexOf(" ")!=-1){
		    alert("You have entered an invalid email address");
		    document.getElementById(emailField).value ="";
            fieldName.focus();
            browserKinks();
		    return false;		 
         }




}
//------------------------------------------------------------------------------------------------------------------
function setEmailListeners(fieldId) {

this.emailField = fieldId;
var fieldFocus = document.getElementById(emailField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkEmail()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkEmail()});                           
}          

}
//-------------------------------------------------------------------------------------------------------------------
function setZipListeners(fieldId) {

this.zipField = fieldId;
var fieldFocus = document.getElementById(zipField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkZipCode()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkZipCode()});                           
}          


}
//--------------------------------------------------------------------------------------------------------------------
function setPhoneListeners(fieldId) {

this.phoneField = fieldId;
var fieldFocus = document.getElementById(phoneField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkPhoneNumber()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkPhoneNumber()});                           
}          


}
//--------------------------------------------------------------------------------------------------------------------
function setDobListeners(fieldId) {

this.dobField = fieldId;
var fieldFocus = document.getElementById(dobField);

try 
{

 fieldFocus.addEventListener ('change', function () {checkDob()}, false);
}
catch(err)
{
    
fieldFocus.attachEvent("onchange",function () {checkDob()});                           
}          

}
//--------------------------------------------------------------------------------------------------------------------
function setPaymentListeners(fieldId) {

this.paymentField = fieldId;
var fieldFocus = document.getElementById(paymentField);

//try 
//{
//alert(paymentField);
 var fullFieldValue;
    
    fullFieldValue = $('#'+paymentField+'').val();//this.value;
    //alert(fullFieldValue);
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    
/*}
catch(err)
{
    
fieldFocus.attachEvent("onkeyup",function () {
    var fullFieldValue = this.value;
    var newFieldValue;
    if(isNaN(fullFieldValue)) {
    newFieldValue = fullFieldValue.slice(0,-1);
    document.getElementById(paymentField).value = newFieldValue;
      alert('The value you entered is not a number.');
      return false;
      }
    });                           
}    */


}


//--------------------------------------------------------------------------------------------------------------------------------
function checkGroupInfo(fieldId)  {


var tip = 1;
var  typeName = document.getElementById('type_name').value;
var  typeAddress = document.getElementById('type_address').value;
var  typePhone = document.getElementById('type_phone').value;

if(fieldId != 'type_name')  {
   if(typeName == "") {
      alert('Please enter the ' +smallHeader+ ' Name');
      document.getElementById('type_name').focus();
      return tip;
     }
}else{
return true;
}


if(fieldId != 'type_address')  {
   if(typeAddress == "") {
     alert('Please enter the ' +smallHeader+ ' Address');
     document.getElementById('type_address').focus();
     return tip;
     }
}else{
return true;
}

if(fieldId != 'type_phone')  {
   if(typePhone == "") {
     alert('Please enter the ' +smallHeader+ ' Phone Number');
     document.getElementById('type_phone').focus();
     return tip;
     }
}else{
return true;
}

if(typeName == "" && typeAddress == "" && typePhone == "") {
   alert('Please fill out all of the ' +typeHeader);
   document.getElementById('type_name').focus();
   return tip;
}

}

//-----------------------------------------------------------------------------------------------------------------------
function checkServices(fieldName, fieldId)  {

//set an event listener depending on if the fied is an email address zip code or phone number or date of birth
var emailPattern = /email/g;
var emailResult = emailPattern.test(fieldId);
if(emailResult == true) {
this.emailField = fieldId;
setEmailListeners(fieldId);
}
var zipPattern = /zip/g;
var zipResult = zipPattern.test(fieldId);
if(zipResult == true) {
this.zipField = fieldId;
setZipListeners(fieldId);
}
var phonePattern = /phone/g;
var phoneResult = phonePattern.test(fieldId);
if(phoneResult == true) {
this.phoneField = fieldId;
setPhoneListeners(fieldId);
}
var dobPattern = /dob/g;
var dobResult = dobPattern.test(fieldId);
if(dobResult == true) {
this.dobField = fieldId;
setDobListeners(fieldId);
}



var paymentPattern = /^[a-zA-Z]+_pay$/;
var paymentResult = paymentPattern.test(fieldId);
if(paymentResult == true) {
this.paymentField = fieldId;
setPaymentListeners(fieldId);
}



     
             


this.primaryContact = "Member";
//------------------------------------------------------------------------------------------------------------------------
function comfirmSale() {

var message = document.getElementById('confirmation_message').value; 

if(message != "") {
   alert(message);
  }
}

}




