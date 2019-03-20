function confirmUpdate() {
alert('Invoice Options Successfully Updated');
}
//-----------------------------------------------------------------------------------------
function checkData() {

var earlyHeader = document.form1.early_header.value;
var earlyHeaderField = document.form1.early_header;
var earlyTxt = document.form1.early_txt.value;
var earlyTxtField = document.form1.early_txt;

var graceHeader = document.form1.grace_header.value;
var graceHeaderField = document.form1.grace_header;
var graceTxt = document.form1.grace_txt.value;
var graceTxtField = document.form1.grace_txt;

var generalHeader = document.form1.general_header.value;
var generalHeaderField = document.form1.general_header;
var generalTxt = document.form1.general_txt.value;
var generalTxtField = document.form1.general_txt;


earlyHeader = earlyHeader.trim();
graceHeader = graceHeader.trim();
generalHeader = generalHeader.trim();

if(earlyHeader == "")  {
  alert('Early Renewal Invoice Header must contain a value');
        earlyHeaderField.focus();
        return false;
  }

if(graceHeader == "")  {
  alert('Grace Period Invoice Header must contain a value');
        graceHeaderField.focus();
        return false;
  }

if(generalHeader == "")  {
  alert('General Invoice Header must contain a value');
        generalHeaderField.focus();
        return false;
  }




}