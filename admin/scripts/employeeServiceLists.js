function checkValue(val) {
var a = val;
b = (a.replace(/^\W+/,'')).replace(/\W+$/,'');

if(isNaN(b)) {
alert('Value must be a Number');
return false
}
}
//=========================================================

function changeColor(obj, r1, r2, col, compType, comp, del) {

//----------------------------------------------------------------------------
//untoggle if delete is checked
var i = del;

if (typeof document.form1.elements['delete[]'].length != 'undefined') {
 
	      if(document.form1.elements['delete[]'][i].checked)   {
            document.form1.elements['delete[]'][i].checked = false;
            }	

}else{

document.form1.elements['delete[]'].checked = false;

}

//-----------------------------------------------------------------------------
//this checks to see if a pay type is selected
var dropDown = document.form1.elements[compType];

var a = dropDown[0].value;
var b = dropDown[1].value;
var c = dropDown[2].value;
var d = dropDown[3].value;


if(a == "" && b=="" && c=="" && d=="") {
obj.checked=false;
alert('Please select at least one Pay Type');

//this toggles the color of the row
var x=document.getElementById(r1);
var y=document.getElementById(r2);
x.style.backgroundColor = (obj.checked) ? "gold" : col;
y.style.backgroundColor = (obj.checked) ? "gold" : col;


return false;
}

//-----------------------------------------------------------------------------
//this checks to see if at least one payfield is selected
var payField = document.form1.elements[comp];
var e = payField[0].value;
var f = payField[1].value;
var g = payField[2].value;
var h = payField[3].value;

if(e == "" && f=="" && g=="" && h=="") {
obj.checked=false;
alert('Please enter at least one payment amount');
return false;
}

//--------------------------------------------------------------------------------------------------------------
//checks to see if the select drop cooresponds with the input field
if(a != "" &&  e =="") {
obj.checked=false;
alert('Please enter the payment amount next to the Pay Type you selected');
return false;
}

if(b != "" &&  f =="") {
obj.checked=false;
alert('Please enter the payment amount next to the Pay Type you selected');
return false;
}

if(c != "" &&  g =="") {
obj.checked=false;
alert('Please enter the payment amount next to the Pay Type you selected');
return false;
}

if(d != "" &&  h=="") {
obj.checked=false;
alert('Please enter the payment amount next to the Pay Type you selected');
return false;
}
//-------------------------------------------------------------------------------------------------------------
if(e != "" &&  a =="") {
obj.checked=false;
alert('Please select a Pay Type next to the payment amount you entered');
return false;
}

if(f != "" &&  b =="") {
obj.checked=false;
alert('Please select a Pay Type next to the payment amount you entered');
return false;
}

if(g != "" &&  c =="") {
obj.checked=false;
alert('Please select a Pay Type next to the payment amount you entered');
return false;
}

if(h != "" &&  d=="") {
obj.checked=false;
alert('Please select a Pay Type next to the payment amount you entered');
return false;
}
//-------------------------------------------------------------------------------------------------------------

//this toggles the color of the row
var x=document.getElementById(r1);
var y=document.getElementById(r2);
x.style.backgroundColor = (obj.checked) ? "gold" : col;
y.style.backgroundColor = (obj.checked) ? "gold" : col;

}

//==================================================================
//this changes color if delete is selected
function changeColor2(obj, r1, r2, col, serv) {

var i = serv;

if (typeof document.form1.elements['serve[]'].length != 'undefined') {


      if(document.form1.elements['serve[]'][i].checked)   {
        document.form1.elements['serve[]'][i].checked = false;
       }
       
}else{
      document.form1.elements['serve[]'].checked = false;

}

//this toggles the color of the row
var x=document.getElementById(r1);
var y=document.getElementById(r2);
x.style.backgroundColor = (obj.checked) ? "red" : col;
y.style.backgroundColor = (obj.checked) ? "red" : col;


}

//=====================================================================
function checkData()  {
//this checks to see if any of the check boxes have been checked before submitting
 sel = -1;
 sel2 = -1;

 if (typeof document.form1.elements['serve[]'].length != 'undefined') {

                        for (i=0; i< document.form1.elements['serve[]'].length; i++) {
                           if (document.form1.elements['serve[]'][i].checked) { 
                              sel = i;
                             }
                           }
}else{

                       if (document.form1.elements['serve[]'].checked) { 
                           sel = 1;
                          }
} 
 //============================================================
 if (typeof document.form1.elements['delete[]'].length != 'undefined') {
 
                       for (j=0; j< document.form1.elements['delete[]'].length; j++) {
                             if (document.form1.elements['delete[]'][j].checked) { 
                                  sel2 = j;
                               }
                            } 
}else{

                       if (document.form1.elements['delete[]'].checked) { 
                           sel2 = 1;
                          }
}
 
//============================================================== 
 
 
  if (sel == -1 && sel2 == -1)  {
      alert("Please select a service to Update or Delete");
      return false;
     }
    return true;


}










