function comFields() {

var txt1a=document.getElementById("pay1a");
var txt1b=document.getElementById("pay1b");
var txt2a=document.getElementById("pay2a");
var txt2b=document.getElementById("pay2b");
var txt3a=document.getElementById("pay3a");
var txt3b=document.getElementById("pay3b");
var txt4a=document.getElementById("pay4a");
var txt4b=document.getElementById("pay4b");
var err4=document.getElementById("error4");
var err5=document.getElementById("error5");
var err6=document.getElementById("error6");
var err7=document.getElementById("error7");

//this sets up the commission feilds for employee type 1
var selIdx = document.form1.compensation_type1.selectedIndex;
var newSel = document.form1.compensation_type1[selIdx].value;
if(newSel == "C") {
   txt1a.innerHTML= "";
   txt1b.innerHTML= "";
   err4.innerHTML= "";
  }



//this sets up the commission feilds for employee type 2
var selIdx = document.form1.compensation_type2.selectedIndex;
var newSel = document.form1.compensation_type2[selIdx].value;
if(newSel == "C") {
   txt2a.innerHTML= "";
   txt2b.innerHTML= ""; 
   err4.innerHTML= "";
   err5.innerHTML= "";   
  }


//this sets up the commission feilds for employee type 3
var selIdx = document.form1.compensation_type3.selectedIndex;
var newSel = document.form1.compensation_type3[selIdx].value;
if(newSel == "C") {
   txt3a.innerHTML= "";
   txt3b.innerHTML= "";  
   err4.innerHTML= "";
   err5.innerHTML= ""; 
   err6.innerHTML= ""; 
  }  


//this sets up the commission feilds for employee type 4
var selIdx = document.form1.compensation_type4.selectedIndex;
var newSel = document.form1.compensation_type4[selIdx].value;
if(newSel == "C") {
   txt4a.innerHTML= "";
   txt4b.innerHTML= ""; 
   err4.innerHTML= "";
   err5.innerHTML= ""; 
   err6.innerHTML= ""; 
   err7.innerHTML= "";    
  }  

//====================================================================================




}
