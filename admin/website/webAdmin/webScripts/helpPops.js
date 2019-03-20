// Copyright (C) 2005-2008 Ilya S. Lyubinskiy. All rights reserved.



var popup_dragging = false;
var popup_target;
var popup_mouseX;
var popup_mouseY;
var popup_mouseposX;
var popup_mouseposY;
var popup_oldfunction;
var helpText;




//------------------------------------------------------------------------------------------------------------

function popup_mousedown(e)    {
  var ie = navigator.appName == "Microsoft Internet Explorer";
  popup_mouseposX = ie ? window.event.clientX : e.clientX;
  popup_mouseposY = ie ? window.event.clientY : e.clientY;
}

//---------------------------------------------------------------------------------------------------------

function popup_mousedown_window(e)   {
  var ie = navigator.appName == "Microsoft Internet Explorer";

  if ( ie && window.event.button != 1) return;
  if (!ie && e.button  != 0) return;


  popup_target   = this['target'];
  popup_mouseX   = ie ? window.event.clientX : e.clientX;
  popup_mouseY   = ie ? window.event.clientY : e.clientY;

  if(ie) {
       popup_oldfunction = document.onselectstart;
  }else{
       popup_oldfunction = document.onmousedown;
   }

  if(ie) {
       document.onselectstart = new Function("return false;");
  }else{
       document.onmousedown   = new Function("return false;");
  }
  
}

//----------------------------------------------------------------------------------------------

function popup_mouseup(e)   {
  var ie = navigator.appName == "Microsoft Internet Explorer";
  var element = document.getElementById(popup_target);

  if(ie) {
       document.onselectstart = popup_oldfunction;
  }else{
       document.onmousedown   = popup_oldfunction;
  }
  
}

//-------------------------------------------------------------------------------------------------

function popup_exit(e)   {
  var ie      = navigator.appName == "Microsoft Internet Explorer";
  var element = document.getElementById(popup_target);

  popup_mouseup(e);
  element.style.display = 'none';
}


//-------------------------------------------------------------------------------------------------

function popup_show(id, drag_id, exit_id, position, x, y, position_id, txt_id)   {

  var txt=document.getElementById("contHint");

  var element = document.getElementById(id);
  var drag_element = document.getElementById(drag_id);
  var exit_element = document.getElementById(exit_id);

  var width = window.innerWidth  ? window.innerWidth  : document.documentElement.clientWidth;
  var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight;

  element.style.position = "absolute";
  element.style.display  = "block";


    var position_element = document.getElementById(position_id);

    for (var p = position_element; p; p = p.offsetParent)
      if (p.style.position != 'absolute')   {
        x += p.offsetLeft;
        y += p.offsetTop;
      }

    if (position == "element-right" ) x += position_element.clientWidth;
    if (position == "element-bottom") y += position_element.clientHeight;

    element.style.left = x+'px';
    element.style.top  = y+'px';
 

 drag_element['target'] = id;
 drag_element.onmousedown = popup_mousedown_window;
 
 //get the text for the popup
  txt.innerHTML= get_help_text(txt_id);
 

 exit_element.onclick  = popup_exit;
  
   
}


//--------------------------------------------------------------------------------------------------

if (navigator.appName == "Microsoft Internet Explorer") {
     document.attachEvent   ('onmousedown', popup_mousedown);
   }else{
     document.addEventListener('mousedown', popup_mousedown, false);
   }


if (navigator.appName == "Microsoft Internet Explorer")  {
     document.attachEvent   ('onmouseup', popup_mouseup);
   }else{ 
     document.addEventListener('mouseup', popup_mouseup, false);
  } 
     
     
     
