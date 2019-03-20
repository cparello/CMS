//changes the first image
function changeImage(fileName)  {

//here we update the banner object
setClassValues(fileName,1);

//this is the div to switch the banner image
var obj= document.getElementById('banSkin');
obj.style.backgroundImage =  'url("../pictures/banner/'+fileName+'")'; 

}
//--------------------------------------------------------------------------------------------------------------------------
function writeHeader(formHead, type)   {

if(type == 1) {
var head = document.getElementById('headerText');
setClassValues(formHead,2);
}else{
var head = document.getElementById('contentText');
setClassValues(formHead,3);
}

head.innerHTML =  formHead;

}
//------------------------------------------------------------------------------------------------------------------------

function posDiv(pos1, area)   {

var obj2a = document.getElementById('headerText').style;
var obj2b = document.getElementById('contentText').style;

switch (area) {
   case 1: 
   obj2a.marginTop =  pos1.toString() + "px";
   setClassValues(pos1,4);
   break;
   case 2: 
   obj2a.marginLeft =  pos1.toString() + "px";
   setClassValues(pos1,5);
   break;
   case 3: 
   obj2a.marginRight = pos1.toString() + "px";
   setClassValues(pos1,6);   
   break;
   case 4: 
   obj2b.marginTop = pos1.toString() + "px";
   setClassValues(pos1,7);    
   break;
   case 5: 
   obj2b.marginLeft =  pos1.toString() + "px";
   setClassValues(pos1,8);    
   break;
   case 6: 
   obj2b.marginRight = pos1.toString() + "px";
   setClassValues(pos1,9);    
   break;
  }
}

//---------------------------------------------------------------------------------------------------------------------------
function changefont(fonts, area) {

//alert(area);
//return false;

if(area > 6)  {

var obj3 = document.getElementById('contentText').style;
obj3.fontFamily = fonts;
setClassValues(fonts,10);
document.getElementById('text_font_temp').value = fonts;
}else{
var obj3 = document.getElementById('headerText').style;
obj3.fontFamily = fonts;
setClassValues(fonts,11);
document.getElementById('header_font_temp').value = fonts;
}

}

//------------------------------------------------------------------------------------------------------------------------------
function headAtts(atts, area, place)  {

if(place ==1) {
var obj4 = document.getElementById('headerText').style;
switch (area) {
   case 1: 
   obj4.letterSpacing =  atts.toString() + "px";
   setClassValues(atts,12);
   break;
   case 2: 
   obj4.fontSize =  atts.toString() + "pt";
   setClassValues(atts,13);   
   break;
   case 3: 
   obj4.fontWeight =  atts.toString();
   setClassValues(atts,14);   
   break;
  }
}else{
var obj4 = document.getElementById('contentText').style;
switch (area) {
   case 1: 
   obj4.letterSpacing =  atts.toString() + "px";
   setClassValues(atts,15);   
   break;
   case 2: 
   obj4.fontSize =  atts.toString() + "pt";
   setClassValues(atts,16);  
   break;
   case 3: 
   obj4.fontWeight =  atts.toString();
   setClassValues(atts,17); 
   break;
  }
}


}
//-------------------------------------------------------------------------------------------------------------------------------
function changeBack(color, place)  {

if(place == 1) {
var obj5 = document.getElementById('headerText').style;
setClassValues(color,18);
document.getElementById('header_color_temp').value = color;
}else{
var obj5 = document.getElementById('contentText').style;
setClassValues(color,19);
document.getElementById('text_color_temp').value = color;
}
obj5.color = color.toString();
//return false;

}
//------------------------------------------------------------------------------------------------------------------------------
function writeName(name)  {
setClassValues(name,20);
}
//-------------------------------------------------------------------------------------------------------------------------------
function writeLink(link)  {
setClassValues(link,21);
}
//-------------------------------------------------------------------------------------------------------------------------------



/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 */
function mycarousel_itemFirstInCallback(carousel, item, idx, state) {

//gets the file name and form name
//var fileName = $("#"+idx ).attr("name");
//var formName = $("form").attr("name");

};


/**
 * This is the callback function which receives notification
 * when an item becomes the first one in the visible range.
 * Triggered before animation.
 */
function mycarousel_itemVisibleInCallbackBeforeAnimation(carousel, item, idx, state) {
    // No animation on first load of the carousel
    if (state == 'init')
        return;

    jQuery('img', item).fadeIn('slow');
};



/**
 * This is the callback function which receives notification
 * when an item is no longer the first one in the visible range.
 * Triggered before animation.
 */
function mycarousel_itemVisibleOutCallbackBeforeAnimation(carousel, item, idx, state) {
    jQuery('img', item).fadeOut('slow');
};


jQuery(document).ready(function() {
    jQuery('.multi-carousel').jcarousel({
        scroll: 1,      
        itemFirstInCallback:  mycarousel_itemFirstInCallback
    });
});
