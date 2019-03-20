function confirmUpdate() {
alert('Expired Re-enrollment Options Successfully Updated');
}
//-----------------------------------------------------------------------------------------
function checkData() {

var erHeader = document.form1.er_header.value;
var erHeaderField = document.form1.er_header;
var erTxt = document.form1.er_txt_one.value;
var erTxtField = document.form1.er_txt_one;

erHeader = erHeader.trim();
erTxt = erTxt.trim();


if(erHeader == "")  {
  alert('Invoice Header must contain a value');
        erHeaderField.focus();
        return false;
  }

if(erTxt == "")  {
  alert('Body Text 1 must contain a value');
        erTxtField.focus();
        return false;
  }






}