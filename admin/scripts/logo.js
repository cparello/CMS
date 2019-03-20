function killHeader()  {
var del =document.getElementById("conf");
del.innerHTML= "&nbsp";
}


function checkData()   {

var txt=document.getElementById("idContent1");
var log1 = document.form1.imagefile.value;
var log2 = document.form1.imagefile;

if(log1 == "")  {
          txt.innerHTML= '<span class="errors">Please select an image to upload</span>';
          log2.focus();                          
          return false;
         }      

}