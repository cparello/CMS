function confirmUpdate() {
alert('Invoice Options Successfully Updated');
}
//-----------------------------------------------------------------------------------------
function checkData() {

var monthlyHeader = document.form1.monthly_header.value;
var monthlyHeaderField = document.form1.monthly_header;

var pastDueHeader = document.form1.past_due_header.value;
var pastDueHeaderField = document.form1.past_due_header;

var rejectedDeclinedHeader = document.form1.rejected_declined_header.value;
var rejectedDeclinedHeaderField = document.form1.rejected_declined_header;

var finalHeader = document.form1.final_header.value;
var finalHeaderField = document.form1.final_header;

var finalTxt = document.form1.final_txt.value;
var finalTxtField = document.form1.final_txt;

finalTxt = finalTxt.replace(/^\s+|\s+$/g,"");


if(monthlyHeader == "")  {
  alert('Monthly Invoice Header must contain a value');
        monthlyHeaderField.focus();
        return false;
  }

if(pastDueHeader == "")  {
  alert('Past Due Invoice Header must contain a value');
        pastDueHeaderField.focus();
        return false;
  }

if(rejectedDeclinedHeader == "")  {
  alert('Rejected Declined Invoice Header must contain a value');
        rejectedDeclinedHeaderField.focus();
        return false;
  }

if(finalHeader == "")  {
  alert('Final Notice Invoice Header must contain a value');
        finalHeaderField.focus();
        return false;
  }

if(finalTxt == "")  {
  alert('Final Notice Body Text must contain a value');
        finalTxtField.focus();
        return false;
  }



}