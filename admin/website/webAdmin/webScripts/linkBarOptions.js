function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= '&nbsp;';
}


//---------------------------------------------------------------------------------------------------------------
function setBitMaps()  {

var genPat =""; 
var monthPat = "";
var total = "" ; 
var count = 0;

//first get the gen Bit
for (var i = 0 ; i < document.form1.gen_pay.length ; i++) {
    if (document.form1.gen_pay[i].checked == true) {
       total = "1";
       }else{
       total = "0";       
       }
       
 genPat += total;   
}

//now the monthly bit
total = "";


for (var j = 0 ; j < document.form1.month_pay.length ; j++) {
    if (document.form1.month_pay[j].checked == true) {
       total = "1";
       }else{
       total = "0";       
       }
       
 monthPat += total;   
}

//now set the hidden fields to send to the server
document.form1.gen_bit.value = genPat;
document.form1.month_bit.value = monthPat;


}