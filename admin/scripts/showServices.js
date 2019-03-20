
function getServiceDrop(fromWhere, serveLoc)   {

//get ajax request object
function GetXmlHttpObject() {
var xmlHttp=null;

try{
// Firefox, Opera 8.0+, Safari
xmlHttp=new XMLHttpRequest();
}
catch (e){
  // Internet Explorer
  try{
      xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e){
      xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
}
return xmlHttp;
}
//-------------------------------------------------------
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null) {
 alert ("There was an error processing your request")
 return false;
 }

//send off the request
var url="getServiceDrops.php";
url=url+"?emp_type="+fromWhere;
url=url+"&serve_loc="+serveLoc;
url=url+"&service_switch="+serviceSwitch;
url=url+"&sid="+Math.random();
xmlHttp.onreadystatechange=function(){stateChanged(fromWhere)}; 
//xmlHttp.onreadystatechange=function(){return stateChanged()}

xmlHttp.open("GET",url,true);
xmlHttp.send(null);




//this function checks the state and then parses the response
function stateChanged(loc) { 

      if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete") { 
          var  passStatus =  xmlHttp.responseText;
              //   alert(passStatus);
                 
          if(serviceSwitch == 1)  {
               var passStatusArray = passStatus.split(':');
               var serviceList = passStatusArray[0];
               var categoryList = passStatusArray[1];
                    
                 if(loc == 1)  {            
                    var  empServe1b=document.getElementById("serve1b");
                    var  empCat1b=document.getElementById("cat1b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos3\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos3', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe1b.innerHTML =  serviceList + hintLink;
                    empCat1b.innerHTML = categoryList;
                    }      
                    
                 if(loc == 3)  {            
                    var  empServe3b=document.getElementById("serve3b");
                    var  empCat3b=document.getElementById("cat3b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos4\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos4', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe3b.innerHTML = serviceList + hintLink;
                    empCat3b.innerHTML = categoryList;
                    }                          
                    
                  if(loc == 2)  {            
                    var  empServe2b=document.getElementById("serve2b");
                    var  empCat2b=document.getElementById("cat2b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos5\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos5', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe2b.innerHTML = serviceList + hintLink;
                    empCat2b.innerHTML = categoryList;
                    }        
                    
                   if(loc == 4)  {            
                    var  empServe4b=document.getElementById("serve4b");
                    var  empCat4b=document.getElementById("cat4b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos6\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos6', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe4b.innerHTML = serviceList + hintLink;
                    empCat4b.innerHTML = categoryList;
                    }                           
             } //end if 1   
                
             if(serviceSwitch == 2 || serviceSwitch == 3)  { 
                var serviceList = passStatus;
                
                 if(loc == 1)  { 
                    var  empServe1b=document.getElementById("serve1b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos3\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos3', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe1b.innerHTML =  serviceList + hintLink;                   
                  }
                  
                 if(loc == 3) {
                   var  empServe3b=document.getElementById("serve3b");
                   var hintLink = "<a href=\"javascript: void\" id=\"pos4\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos4', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe3b.innerHTML = serviceList + hintLink;
                   }
                 
                 if(loc == 2) { 
                    var  empServe2b=document.getElementById("serve2b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos5\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos5', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe2b.innerHTML = serviceList + hintLink;
                  }
                  
                 if(loc == 4) {
                    var  empServe4b=document.getElementById("serve4b");
                    var hintLink = "<a href=\"javascript: void\" id=\"pos6\" onclick=\"popup_show('popup', 'popup_drag', 'popup_exit', 'element-right', -100, -70, 'pos6', 3 )\;\" /><img src=\"../images/question-mark.png\" class=\"alignTop\"/></a>";
                    empServe4b.innerHTML = serviceList + hintLink;
                   }
                                  
              } //end if 2   
 
 
 
 
 
                 
                 
     } //end complete
                 
}





}
//======================================================================
var valueAry=new Array();
function showServices(fromWhere, serveLoc, selObj,  objType)  {

this.serviceSwitch = 1;

 if(selObj.selectedIndex<1)  { 
  return; 
    }  
  if(!selObj.set) {  
     selObj.set=true;
     valueAry[valueAry.length]=selObj;         
    }
  
  for (i=0; i < valueAry.length; i++) {
    for (j = i+1; j< valueAry.length; j++) {                             
       if(valueAry[i].options[valueAry[i].selectedIndex].value == valueAry[j].options[valueAry[j].selectedIndex].value && objType.toLowerCase() == 'value') {        
        alert('This Employee Type Has Already Been Selected');
        valueAry[j].selectedIndex=0;
        return false;
      }
    }
  }




var selIdx1 = document.form1.employee_type1.selectedIndex;
var newSel1 = document.form1.employee_type1[selIdx1].text;
var selIdx2 = document.form1.employee_type2.selectedIndex;
var newSel2 = document.form1.employee_type2[selIdx2].text;
var selIdx3 = document.form1.employee_type3.selectedIndex;
var newSel3 = document.form1.employee_type3[selIdx3].text;
var selIdx4 = document.form1.employee_type4.selectedIndex;
var newSel4 = document.form1.employee_type4[selIdx4].text;

var  empServe1a=document.getElementById("serve1a");
var  empServe1b=document.getElementById("serve1b");
var  empServe3a=document.getElementById("serve3a");
var  empServe3b=document.getElementById("serve3b");
var  empServe2a=document.getElementById("serve2a");
var  empServe2b=document.getElementById("serve2b");
var  empServe4a=document.getElementById("serve4a");
var  empServe4b=document.getElementById("serve4b");

var  empCat1a=document.getElementById("cat1a");
var  empCat1b=document.getElementById("cat1b");
var  empCat3a=document.getElementById("cat3a");
var  empCat3b=document.getElementById("cat3b");
var  empCat2a=document.getElementById("cat2a");
var  empCat2b=document.getElementById("cat2b");
var  empCat4a=document.getElementById("cat4a");
var  empCat4b=document.getElementById("cat4b");


var categoryHeader = 'Available Categories:';
var serviceHeader = 'Available Service Types:';


var salesPat = /sales/i;
var result1 =salesPat.test(newSel1);
var result2 =salesPat.test(newSel2);
var result3 =salesPat.test(newSel3);
var result4 =salesPat.test(newSel4);


if(fromWhere == 1)   {
     if(result1 == true) {      
         getServiceDrop(fromWhere, serveLoc);     
         empServe1a.innerHTML= serviceHeader;
         empCat1a.innerHTML = categoryHeader;
         
       }else{       
        empServe1a.innerHTML= ""; 
        empServe1b.innerHTML= "";
        empCat1a.innerHTML="";
       }
   }
       
       
if(fromWhere == 3)   {       
       if(result3 == true) {      
         getServiceDrop(fromWhere, serveLoc);     
         empServe3a.innerHTML= serviceHeader;  
         empCat3a.innerHTML = categoryHeader;
       }else{       
        empServe3a.innerHTML= ""; 
        empServe3b.innerHTML= ""; 
        empCat3a.innerHTML = "";
       }
}


if(fromWhere == 2)   {
     if(result2 == true) {      
         getServiceDrop(fromWhere, serveLoc);     
         empServe2a.innerHTML= serviceHeader;
         empCat2a.innerHTML = categoryHeader;
       }else{       
        empServe2a.innerHTML= ""; 
        empServe2b.innerHTML= ""; 
        empCat2a.innerHTML = "";
       }
   }
       
       
if(fromWhere == 4)   {       
       if(result4 == true) {      
         getServiceDrop(fromWhere, serveLoc);     
         empServe4a.innerHTML= serviceHeader;
         empCat4a.innerHTML = categoryHeader;
       }else{       
        empServe4a.innerHTML= ""; 
        empServe4b.innerHTML= ""; 
        empCat4a.innerHTML = "";
       }
  }
}

//------------------------------------------------------------------------------------------------------------------------------------
function showSelect1(fromWhere, serveLoc)  {
//alert(serveLoc);
this.serviceSwitch = 2;
getServiceDrop(fromWhere, serveLoc); 
}

//--------------------------------------------------------------------------------------------------------------------------------------
function showSelect2(fromWhere, serveLoc)  {

this.serviceSwitch = 3;
var empId = document.form1.emp_user_id.value;

if(serveLoc != "") {
serveLoc = serveLoc+'|'+empId;
}

getServiceDrop(fromWhere, serveLoc); 
}









//------------------------------------------------------------------------------------------------------------------------------------