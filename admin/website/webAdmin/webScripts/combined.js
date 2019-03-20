// Date last modified = 20110719 // Modified by = AC var lpMTagConfig = { 'lpServer ': 'sales.liveperson.net ', 'lpNumber ': '13297230 ', 'lpProtocol ':(document.location.toString().indexOf( 'https: ')==0) ? 'https ': 'http ', 'lpTagLoaded ':false, 'lpTagSrv ': 'sales.liveperson.net ', 'pageStartTime ':(new Date()).getTime() //pageStartTime is set with a timestamp as soon as the page starts loading
//};
lpMTagConfig.lpLoadScripts = function() {
lpAddMonitorTag();
}

function lpAddMonitorTag(src) {
if (!lpMTagConfig.lpTagLoaded) {
if (typeof(src) == 'undefined ' || typeof(src) == 'object ') {
if (lpMTagConfig.lpMTagSrc) {
src = lpMTagConfig.lpMTagSrc;
}

else {
if (lpMTagConfig.lpTagSrv) {
src = lpMTagConfig.lpProtocol + ':// '+lpMTagConfig.lpTagSrv + '/hcp/html/mTag.js ';
}

else {
src = '/hcp/html/mTag.js ';
};
};
};
if (src.indexOf( 'http ') != 0) {
src = lpMTagConfig.lpProtocol + ':// '+ lpMTagConfig.lpServer + src + ' ?site= '+ lpMTagConfig.lpNumber;
}

else {
if (src.indexOf( 'site= ') <0) {
if (src.indexOf( ' ? ') <0) {
src = src + ' ? ';
}

else {
src = src + '& ';
}

src = src + 'site= '+ lpMTagConfig.lpNumber;
};
};
var s = document.createElement( 'script ');
s.setAttribute( 'type ', 'text/javascript ');
s.setAttribute( 'charset ', 'iso-8859-1 ');
s.setAttribute( 'src ',src);
document.getElementsByTagName( 'head ').item(0).appendChild(s);
}
}

//The code below send a PAGEVAR to LP with the time [in seconds ]it took the page to load. Code is executed in the onload event lpMTagConfig.calculateSentPageTime = function () {
var t = (new Date()).getTime() - lpMTagConfig.pageStartTime;
lpAddVars( 'page ', 'pageLoadTime ',Math.round(t/1000)+ 'sec ');
};
//Variables Arrays - By Scope if (typeof(lpMTagConfig.pageVar)== 'undefined ') {
lpMTagConfig.pageVar = [ ];
}

if (typeof(lpMTagConfig.sessionVar)== 'undefined ') {
lpMTagConfig.sessionVar = [ ];
}

if (typeof(lpMTagConfig.visitorVar)== 'undefined ') {
lpMTagConfig.visitorVar = [ ];
}

//Extra actions to be taken once the code executes if (typeof(lpMTagConfig.onLoadCode)== 'undefined ') {
lpMTagConfig.onLoadCode = [ ];
}

//Dynamic Buttons Array if(typeof(lpMTagConfig.dynButton)== 'undefined ') {
lpMTagConfig.dynButton = [ ];
}

// This need to be add to afterStartPage will work if(typeof(lpMTagConfig.ifVisitorCode)== 'undefined ') {
lpMTagConfig.ifVisitorCode = [ ];
}

// Function that sends variables to LP - By Scope function lpAddVars(scope,name,value) {
if (name.indexOf( 'OrderTotal ')!=-1 | |name.indexOf( 'OrderNumber ')!=-1) {
if (value== ' ' | |value==0) return;
// pass 0 value to all but OrderTotal else lpMTagConfig.sendCookies = false
}

value=lpTrimSpaces(value.toString());
//Remove cut long variables names and values. Trims suffix of the variable name above the 25th character onwards if (name.length >50) {
name=name.substr(0,50);
}

if (value.length >50) {
// Trims suffix of the variable value above the 50th character onwards value=value.substr(0,50);
}

switch (scope) {
case 'page ':lpMTagConfig.pageVar [lpMTagConfig.pageVar.length ]= escape(name)+ '= '+escape(value);
break;
case 'session ':lpMTagConfig.sessionVar [lpMTagConfig.sessionVar.length ]= escape(name)+ '= '+escape(value);
break;
case 'visitor ':lpMTagConfig.visitorVar [lpMTagConfig.visitorVar.length ]= escape(name)+ '= '+escape(value);
break;
}
}

// Preventing long cookie transfer for IE based browsers. function onloadEMT() {
var LPcookieLengthTest=document.cookie;
if (lpMTag.lpBrowser == 'IE '&& LPcookieLengthTest.length >1000) {
lpMTagConfig.sendCookies=false;
}
}

//The Trim function returns a text value with the leading and trailing spaces removed function lpTrimSpaces(stringToTrim) {
return stringToTrim.replace(/^ \s+ | \s+$/g, ' ');
}

// Immediate Data submission function function lpSendData(varscope,varname,varvalue) {
if(typeof(lpMTag)!= 'undefined '&& typeof(lpMTag.lpSendData)!= 'undefined ') lpMTag.lpSendData(varscope.toUpperCase() + 'VAR! '+ varname + '= '+ varvalue,true);
}

// The unit variable purpose is to route the chat or call to the designated skill. <LOB >should be replaced with the skill name,i.e.:sales try {
if (typeof(lpUnit)== 'undefined ') {
var lpUnit= 'sales ';
}

if (typeof(lpLanguage)== 'undefined ') {
var lpLanguage= 'english ';
}

if(typeof(lpAddVars)!= 'undefined ') {
lpAddVars( 'page ', 'unit ',lpUnit);
lpAddVars( 'session ', 'language ',lpLanguage);
}

lpMTagConfig.defaultInvite = 'chat '+ '- '+ lpUnit+ '- '+lpLanguage;
}

catch(e) {
}

lpMTagConfig.onLoadCode [lpMTagConfig.onLoadCode.length ]= onloadEMT;
//Scan dynButton and removes buttons which doesnt have Div on the page lpMTagConfig.onLoadCode [lpMTagConfig.onLoadCode.length ]= function () {
if(typeof(lpMTagConfig.dynButton)!= 'undefined ') {
for (i=0;
i <lpMTagConfig.dynButton.length;
i++) {
if (typeof(lpMTagConfig.dynButton [i ].pid)!= 'undefined '&& document.getElementById(lpMTagConfig.dynButton [i ].pid) == null) {
lpMTagConfig.dynButton.splice(i,1);
i--;
}
}
}
};
//The folowing functions will be load after the page will finish loading lpMTagConfig.onLoadAll = function () {
lpMTagConfig.calculateSentPageTime();
lpMTagConfig.lpLoadScripts();
};
if (window.attachEvent) {
window.attachEvent( 'onload ',lpMTagConfig.onLoadAll);
}

else {
window.addEventListener( 'load ',lpMTagConfig.onLoadAll,false);
}

//Omniture Tracking //Invitation shown tracking function lpMTagConfig.inviteChatShown = function (objName) {
var inviteObj = eval(objName);
//try {
//Omniture tracking call - Invitation Displayed var s = s_gi(s_account);
s.linkTrackVars = 'events,eVar52 ';
s.linkTrackEvents = 'event43 ';
s.eVar52 = 'invite-shown ';
s.events = 'event43 ';
s.tl(inviteObj, 'o ', 'lp_invite_displayed ');
//
}

catch (e) {
}

return true;
};
lpMTagConfig.inviteChatAccept = function (objName) {
var inviteObj = eval(objName);
//try {
//Omniture tracking call - Invitation Accepted var s = s_gi(s_account);
s.linkTrackVars = 'events ';
s.linkTrackEvents = 'event44 ';
s.events = 'event44 ';
s.tl(inviteObj, 'o ', 'lp_invite_accepted ');
//
}

catch (e) {
}

return true;
};
lpMTagConfig.inviteChatDeclined = function (objName) {
var inviteObj = eval(objName);
//try {
//Omniture tracking call - Invitation Declined var s = s_gi(s_account);
s.linkTrackVars = 'events ';
s.linkTrackEvents = 'event45 ';
s.events = 'event45 ';
s.tl(inviteObj, 'o ', 'lp_invite_declined ');
//
}

catch (e) {
}

return true;
};
lpMTagConfig.inviteChatTimeout = function (objName) {
var inviteObj = eval(objName);
//try {
//Omniture tracking call - Invitation TimedOut var s = s_gi(s_account);
s.linkTrackVars = 'events ';
s.linkTrackEvents = 'event46 ';
s.events = 'event46 ';
s.tl(inviteObj, 'o ', 'lp_invite_timeout ');
//
}

catch (e) {
}

return true;
};
lpMTagConfig.db1 = new Object();
lpMTagConfig.db1.dbClicked = function (objName,status) {
objRef = eval(objName);
if (status == 'online ') {
//try {
//Omniture tracking call - Button Clicked var s = s_gi(s_account);
s.linkTrackVars = 'events ';
s.linkTrackEvents = 'event42 ';
s.events = 'event42 ';
s.tl(objRef, 'o ', 'lp_button_click ');
//
}

catch (e) {
}
}

return true;
};
// LP Button Code lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'header-chat- '+ lpUnit + '- '+ lpLanguage + '-9 ', 'pid ': 'lpchatbutton9 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'chat- '+lpUnit+ '- '+lpLanguage, 'pid ': 'lpchatbutton1 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'chat- '+lpUnit+ '- '+lpLanguage+ '-2 ', 'pid ': 'lpchatbutton2 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'chat- '+lpUnit+ '- '+lpLanguage+ '-3 ', 'pid ': 'lpchatbutton3 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'chat- '+lpUnit+ '- '+lpLanguage+ '-4 ', 'pid ': 'lpchatbutton4 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'chat- '+lpUnit+ '- '+lpLanguage+ '-5 ', 'pid ': 'lpchatbutton5 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'clubPage-chat- '+lpUnit+ '- '+lpLanguage+ '-6 ', 'pid ': 'clubPagechatbutton6 ', 'ovr ': 'lpMTagConfig.db1 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'UBSPages-chat-sales-english-7 ', 'pid ': 'UBSPages-chat-sales-english-7 ', 'afterStartPage ':true
};
lpMTagConfig.dynButton [lpMTagConfig.dynButton.length ]= { 'name ': 'UpgradePage-chat-sales-english-8 ', 'pid ': 'UpgradePage-chat-sales-english-8 ', 'afterStartPage ':true
};
/*
 * Modernizr v1.6
 * http://www.modernizr.com
 *
 * Developed by: 
 * - Faruk Ates  http://farukat.es/
 * - Paul Irish  http://paulirish.com/
 *
 * Copyright (c) 2009-2010
 * Dual-licensed under the BSD or MIT licenses.
 * http://www.modernizr.com/license/
 */
window.Modernizr=function(i,e,u) {
function s(a,b) {
return( " "+a).indexOf(b)!==-1
}

function D(a,b) {
for(var c in a)if(j [a [c ] ]!==u&&(!b | |b(a [c ],E)))return true
}

function n(a,b) {
var c=a.charAt(0).toUpperCase()+a.substr(1);
c=(a+ " "+F.join(c+ " ")+c).split( " ");
return!!D(c,b)
}

function S() {
f.input=function(a) {
for(var b=0,c=a.length;
b <c;
b++)L [a [b ] ]=!!(a [b ]in h);
return L
}

( "autocomplete autofocus list placeholder max min multiple pattern required step ".split( " "));
f.inputtypes=function(a) {
for(var b=0,c,k=a.length;
b <k;
b++) {
h.setAttribute( "type ",a [b ]);
if(c=h.type!== "text ") {
h.value=M;
if(/^range$/.test(h.type)&&h.style.WebkitAppearance!==u) {
l.appendChild(h);
c=e.defaultView;
c=c.getComputedStyle&&c.getComputedStyle(h,null).WebkitAppearance!== "textfield "&&h.offsetHeight!==0;
l.removeChild(h)
}

else/^(search |tel)$/.test(h.type) | |(c=/^(url |email)$/.test(h.type) ?h.checkValidity&&h.checkValidity()===false:h.value!=M)
}

N [a [b ] ]=!!c
}

return N
}

( "search tel url email datetime date month week time datetime-local number range color ".split( " "))
}

var f= {
},l=e.documentElement,E=e.createElement( "modernizr "),j=E.style,h=e.createElement( "input "),M= ":) ",O=Object.prototype.toString,q= "-webkit- -moz- -o- -ms- -khtml- ".split( " "),F= "Webkit Moz O ms Khtml ".split( " "),v= {
svg: "http://www.w3.org/2000/svg "
},d= {
},N= {
},L= {
},P= [ ],w,Q=function(a) {
var b=document.createElement( "style "),c=e.createElement( "div ");
b.textContent=a+ " {
#modernizr {
height:3px
}
} ";
(e.head | |e.getElementsByTagName( "head ") [0 ]).appendChild(b);
c.id= "modernizr ";
l.appendChild(c);
a=c.offsetHeight=== 3;
b.parentNode.removeChild(b);
c.parentNode.removeChild(c);
return!!a
},o=function() {
var a= {
select: "input ",change: "input ",submit: "form ",reset: "form ",error: "img ",load: "img ",abort: "img "
};
return function(b,c) {
c=c | |document.createElement(a [b ] | | "div ");
b= "on "+b;
var k=b in c;
if(!k) {
c.setAttribute | |(c=document.createElement( "div "));
if(c.setAttribute&&c.removeAttribute) {
c.setAttribute(b, " ");
k=typeof c [b ]== "function ";
if(typeof c [b ]!= "undefined ")c [b ]=u;
c.removeAttribute(b)
}
}

return k
}
}

(),G= {
}

.hasOwnProperty,R;
R= typeof G!== "undefined "&&typeof G.call!== "undefined " ?function(a,b) {
return G.call(a,b)
}:function(a,b) {
return b in a&&typeof a.constructor.prototype [b ]=== "undefined "
};
d.flexbox=function() {
var a=e.createElement( "div "),b=e.createElement( "div ");
(function(k,g,r,x) {
g+= ": ";
k.style.cssText=(g+q.join(r+ "; "+g)).slice(0,-g.length)+(x | | " ")
}

)(a, "display ", "box ", "width:42px;
padding:0; ");
b.style.cssText=q.join( "box-flex:1; ")+ "width:10px; ";
a.appendChild(b);
l.appendChild(a);
var c=b.offsetWidth===42;
a.removeChild(b);
l.removeChild(a);
return c
};
d.canvas=function() {
var a=e.createElement( "canvas ");
return!!(a.getContext&&a.getContext( "2d "))
};
d.canvastext=function() {
return!!(f.canvas&&typeof e.createElement( "canvas ").getContext( "2d ").fillText== "function ")
};
d.webgl=function() {
var a=e.createElement( "canvas ");
try {
if(a.getContext( "webgl "))return true
}

catch(b) {
}

try {
if(a.getContext( "experimental-webgl "))return true
}

catch(c) {
}

return false
};
d.touch=function() {
return "ontouchstart "in i | |Q( "@media ( "+q.join( "touch-enabled),( ")+ "modernizr) ")
};
d.geolocation=function() {
return!!navigator.geolocation
};
d.postmessage=function() {
return!!i.postMessage
};
d.websqldatabase=function() {
return!!i.openDatabase
};
d.indexedDB=function() {
for(var a=-1,b=F.length;
++a <b;
) {
var c=F [a ].toLowerCase();
if(i [c+ "_indexedDB " ] | |i [c+ "IndexedDB " ])return true
}

return false
};
d.hashchange=function() {
return o( "hashchange ",i)&&(document.documentMode===u | |document.documentMode >7)
};
d.history=function() {
return!!(i.history&&history.pushState)
};
d.draganddrop=function() {
return o( "drag ")&& o( "dragstart ")&&o( "dragenter ")&&o( "dragover ")&&o( "dragleave ")&&o( "dragend ")&&o( "drop ")
};
d.websockets=function() {
return "WebSocket "in i
};
d.rgba=function() {
j.cssText= "background-color:rgba(150,255,150,.5) ";
return s(j.backgroundColor, "rgba ")
};
d.hsla=function() {
j.cssText= "background-color:hsla(120,40%,100%,.5) ";
return s(j.backgroundColor, "rgba ") | |s(j.backgroundColor, "hsla ")
};
d.multiplebgs=function() {
j.cssText= "background:url(//:),url(//:),red url(//:) ";
return/(url \s* \(.* ?) {
3
}

/.test(j.background)
};
d.backgroundsize= function() {
return n( "backgroundSize ")
};
d.borderimage=function() {
return n( "borderImage ")
};
d.borderradius=function() {
return n( "borderRadius ", " ",function(a) {
return s(a, "orderRadius ")
}

)
};
d.boxshadow=function() {
return n( "boxShadow ")
};
d.textshadow=function() {
return e.createElement( "div ").style.textShadow=== " "
};
d.opacity=function() {
var a=q.join( "opacity:.5; ")+ " ";
j.cssText=a;
return s(j.opacity, "0.5 ")
};
d.cssanimations=function() {
return n( "animationName ")
};
d.csscolumns=function() {
return n( "columnCount ")
};
d.cssgradients= function() {
var a=( "background-image: "+q.join( "gradient(linear,left top,right bottom,from(#9f9),to(white));
background-image: ")+q.join( "linear-gradient(left top,#9f9,white);
background-image: ")).slice(0,-17);
j.cssText=a;
return s(j.backgroundImage, "gradient ")
};
d.cssreflections=function() {
return n( "boxReflect ")
};
d.csstransforms=function() {
return!!D( [ "transformProperty ", "WebkitTransform ", "MozTransform ", "OTransform ", "msTransform " ])
};
d.csstransforms3d=function() {
var a=!!D( [ "perspectiveProperty ", "WebkitPerspective ", "MozPerspective ", "OPerspective ", "msPerspective " ]);
if(a)a=Q( "@media ( "+q.join( "transform-3d),( ")+ "modernizr) ");
return a
};
d.csstransitions=function() {
return n( "transitionProperty ")
};
d.fontface=function() {
var a,b=e.head | |e.getElementsByTagName( "head ") [0 ] | |l,c=e.createElement( "style "),k=e.implementation | | {
hasFeature:function() {
return false
}
};
c.type= "text/css ";
b.insertBefore(c,b.firstChild);
a=c.sheet | |c.styleSheet;
b=k.hasFeature( "CSS2 ", " ") ?function(g) {
if(!(a&&g))return false;
var r=false;
try {
a.insertRule(g,0);
r=!/unknown/i.test(a.cssRules [0 ].cssText);
a.deleteRule(a.cssRules.length-1)
}

catch(x) {
}

return r
}:function(g) {
if(!(a&&g))return false;
a.cssText=g;
return a.cssText.length!==0&&!/unknown/i.test(a.cssText)&&a.cssText.replace(/ \r+ | \n+/g, " ").indexOf(g.split( " ") [0 ])===0
};
f._fontfaceready=function(g) {
g(f.fontface)
};
return b( '@font-face {
font-family: "font ";
src: "font.ttf ";
} ')
};
d.video=function() {
var a=e.createElement( "video "),b=!!a.canPlayType;
if(b) {
b=new Boolean(b);
b.ogg=a.canPlayType( 'video/ogg;
codecs= "theora " ');
b.h264=a.canPlayType( 'video/mp4;
codecs= "avc1.42E01E " ') | |a.canPlayType( 'video/mp4;
codecs= "avc1.42E01E,mp4a.40.2 " ');
b.webm=a.canPlayType( 'video/webm;
codecs= "vp8,vorbis " ')
}

return b
};
d.audio=function() {
var a=e.createElement( "audio "),b=!!a.canPlayType;
if(b) {
b=new Boolean(b);
b.ogg=a.canPlayType( 'audio/ogg;
codecs= "vorbis " ');
b.mp3=a.canPlayType( "audio/mpeg; ");
b.wav=a.canPlayType( 'audio/wav;
codecs= "1 " ');
b.m4a=a.canPlayType( "audio/x-m4a; ") | |a.canPlayType( "audio/aac; ")
}

return b
};
d.localstorage=function() {
try {
return "localStorage "in i&&i.localStorage!==null
}

catch(a) {
return false
}
};
d.sessionstorage=function() {
try {
return "sessionStorage "in i&&i.sessionStorage!==null
}

catch(a) {
return false
}
};
d.webWorkers=function() {
return!!i.Worker
};
d.applicationcache=function() {
return!!i.applicationCache
};
d.svg=function() {
return!!e.createElementNS&&!!e.createElementNS(v.svg, "svg ").createSVGRect
};
d.inlinesvg=function() {
var a=document.createElement( "div ");
a.innerHTML= " <svg/ > ";
return(a.firstChild&&a.firstChild.namespaceURI)==v.svg
};
d.smil=function() {
return!!e.createElementNS&& /SVG/.test(O.call(e.createElementNS(v.svg, "animate ")))
};
d.svgclippaths=function() {
return!!e.createElementNS&&/SVG/.test(O.call(e.createElementNS(v.svg, "clipPath ")))
};
for(var H in d)if(R(d,H)) {
w=H.toLowerCase();
f [w ]=d [H ]();
P.push((f [w ] ? " ": "no- ")+w)
}

f.input | |S();
f.crosswindowmessaging=f.postmessage;
f.historymanagement=f.history;
f.addTest=function(a,b) {
a=a.toLowerCase();
if(!f [a ]) {
b=!!b();
l.className+= " "+(b ? " ": "no- ")+a;
f [a ]=b;
return f
}
};
j.cssText= " ";
E=h=null;
i.attachEvent&&function() {
var a=e.createElement( "div ");
a.innerHTML= " <elem > </elem > ";
return a.childNodes.length!==1
}

()&&function(a,b) {
function c(p) {
for(var m=-1;
++m <r;
)p.createElement(g [m ])
}

function k(p,m) {
for(var I=p.length,t=-1,y,J= [ ];
++t <I;
) {
y=p [t ];
m=y.media | |m;
J.push(k(y.imports,m));
J.push(y.cssText)
}

return J.join( " ")
}

var g= "abbr |article |aside |audio |canvas |details |figcaption |figure |footer |header |hgroup |mark |meter |nav |output |progress |section |summary |time |video ".split( " | "),r=g.length,x=RegExp( " <(/*)(abbr |article |aside |audio |canvas |details |figcaption |figure |footer |header |hgroup |mark |meter |nav |output |progress |section |summary |time |video) ", "gi "),T=RegExp( " \ \b(abbr |article |aside |audio |canvas |details |figcaption |figure |footer |header |hgroup |mark |meter |nav |output |progress |section |summary |time |video) \ \b( ?!.* [;
} ]) ", "gi "),z=b.createDocumentFragment(),A=b.documentElement,K=A.firstChild,B=b.createElement( "style "),C=b.createElement( "body ");
B.media= "all ";
c(b);
c(z);
a.attachEvent( "onbeforeprint ",function() {
for(var p=-1;
++p <r;
)for(var m=b.getElementsByTagName(g [p ]),I=m.length,t=-1;
++t <I;
)if(m [t ].className.indexOf( "iepp_ ") <0)m [t ].className+= "iepp_ "+ g [p ];
K.insertBefore(B,K.firstChild);
B.styleSheet.cssText=k(b.styleSheets, "all ").replace(T, ".iepp_$1 ");
z.appendChild(b.body);
A.appendChild(C);
C.innerHTML=z.firstChild.innerHTML.replace(x, " <$1bdo ")
}

);
a.attachEvent( "onafterprint ",function() {
C.innerHTML= " ";
A.removeChild(C);
K.removeChild(B);
A.appendChild(z.firstChild)
}

)
}

(this,document);
f._enableHTML5=true;
f._version= "1.6 ";
l.className=l.className.replace(/ \bno-js \b/, " ")+ "js ";
l.className+= " "+P.join( " ");
return f
}

(this,this.document);
var mboxCopyright = "Copyright 1996-2012. Adobe Systems Incorporated. All rights reserved. ";
mboxUrlBuilder = function(a,b) {
this.a = a;
this.b = b;
this.c = new Array();
this.d = function(e) {
return e;
};
this.f = null;
};
mboxUrlBuilder.prototype.addParameter = function(g,h) {
var i = new RegExp( '( \ ' | ") ');
if (i.exec(g)) {
throw "Parameter ' "+ g + " 'contains invalid characters ";
}

for (var j = 0;
j <this.c.length;
j++) {
var k = this.c [j ];
if (k.name == g) {
k.value = h;
return this;
}
}

var l = new Object();
l.name = g;
l.value = h;
this.c [this.c.length ]= l;
return this;
};
mboxUrlBuilder.prototype.addParameters = function(c) {
if (!c) {
return this;
}

for (var j = 0;
j <c.length;
j++) {
var m = c [j ].indexOf( '= ');
if (m == -1 | |m == 0) {
continue;
}

this.addParameter(c [j ].substring(0,m),c [j ].substring(m + 1,c [j ].length));
}

return this;
};
mboxUrlBuilder.prototype.setServerType = function(n) {
this.o = n;
};
mboxUrlBuilder.prototype.setBasePath = function(f) {
this.f = f;
};
mboxUrlBuilder.prototype.setUrlProcessAction = function(p) {
this.d = p;
};
mboxUrlBuilder.prototype.buildUrl = function() {
var q = this.f ?this.f: '/m2/ '+ this.b + '/mbox/ '+ this.o;
var r = document.location.protocol == 'file: ' ? 'http: ':document.location.protocol;
var e = r + "// "+ this.a + q;
var s = e.indexOf( ' ? ') != -1 ? '& ': ' ? ';
for (var j = 0;
j <this.c.length;
j++) {
var k = this.c [j ];
e += s + encodeURIComponent(k.name) + '= '+ encodeURIComponent(k.value);
s = '& ';
}

return this.t(this.d(e));
};
mboxUrlBuilder.prototype.getParameters = function() {
return this.c;
};
mboxUrlBuilder.prototype.setParameters = function(c) {
this.c = c;
};
mboxUrlBuilder.prototype.clone = function() {
var u = new mboxUrlBuilder(this.a,this.b);
u.setServerType(this.o);
u.setBasePath(this.f);
u.setUrlProcessAction(this.d);
for (var j = 0;
j <this.c.length;
j++) {
u.addParameter(this.c [j ].name,this.c [j ].value);
}

return u;
};
mboxUrlBuilder.prototype.t = function(v) {
return v.replace(/ \ "/g, '&quot; ').replace(/ >/g, '&gt; ');
};
mboxStandardFetcher = function() {
};
mboxStandardFetcher.prototype.getType = function() {
return 'standard ';
};
mboxStandardFetcher.prototype.fetch = function(w) {
w.setServerType(this.getType());
document.write( ' < '+ 'scr '+ 'ipt src= " '+ w.buildUrl() + ' "language= "JavaScript " > < '+ ' \/scr '+ 'ipt > ');
};
mboxStandardFetcher.prototype.cancel = function() {
};
mboxAjaxFetcher = function() {
};
mboxAjaxFetcher.prototype.getType = function() {
return 'ajax ';
};
mboxAjaxFetcher.prototype.fetch = function(w) {
w.setServerType(this.getType());
var e = w.buildUrl();
this.x = document.createElement( 'script ');
this.x.src = e;
document.body.appendChild(this.x);
};
mboxAjaxFetcher.prototype.cancel = function() {
};
mboxMap = function() {
this.y = new Object();
this.z = new Array();
};
mboxMap.prototype.put = function(A,h) {
if (!this.y [A ]) {
this.z [this.z.length ]= A;
}

this.y [A ]= h;
};
mboxMap.prototype.get = function(A) {
return this.y [A ];
};
mboxMap.prototype.remove = function(A) {
this.y [A ]= undefined;
};
mboxMap.prototype.each = function(p) {
for (var j = 0;
j <this.z.length;
j++ ) {
var A = this.z [j ];
var h = this.y [A ];
if (h) {
var B = p(A,h);
if (B === false) {
break;
}
}
}
};
mboxFactory = function(C,b,D) {
this.E = false;
this.C = C;
this.D = D;
this.F = new mboxList();
mboxFactories.put(D,this);
this.G = typeof document.createElement( 'div ').replaceChild != 'undefined '&& (function() {
return true;
}

)() && typeof document.getElementById != 'undefined '&& typeof (window.attachEvent | |document.addEventListener | |window.addEventListener) != 'undefined '&& typeof encodeURIComponent != 'undefined ';
this.H = this.G && mboxGetPageParameter( 'mboxDisable ') == null;
var I = D == 'default ';
this.J = new mboxCookieManager( 'mbox '+ (I ? ' ':( '- '+ D)),(function() {
return mboxCookiePageDomain();
}

)());
this.H = this.H && this.J.isEnabled() && (this.J.getCookie( 'disable ') == null);
if (this.isAdmin()) {
this.enable();
}

this.K();
this.L = mboxGenerateId();
this.M = mboxScreenHeight();
this.N = mboxScreenWidth();
this.O = mboxBrowserWidth();
this.P = mboxBrowserHeight();
this.Q = mboxScreenColorDepth();
this.R = mboxBrowserTimeOffset();
this.S = new mboxSession(this.L, 'mboxSession ', 'session ',31 * 60,this.J);
this.T = new mboxPC( 'PC ',1209600,this.J);
this.w = new mboxUrlBuilder(C,b);
this.U(this.w,I);
this.V = new Date().getTime();
this.W = this.V;
var X = this;
this.addOnLoad(function() {
X.W = new Date().getTime();
}

);
if (this.G) {
this.addOnLoad(function() {
X.E = true;
X.getMboxes().each(function(Y) {
Y.setFetcher(new mboxAjaxFetcher());
Y.finalize();
}

);
}

);
if (this.H) {
this.limitTraffic(100,10368000);
this.Z();
this._ = new mboxSignaler(function(ab,c) {
return X.create(ab,c);
},this.J);
}
}
};
mboxFactory.prototype.isEnabled = function() {
return this.H;
};
mboxFactory.prototype.getDisableReason = function() {
return this.J.getCookie( 'disable ');
};
mboxFactory.prototype.isSupported = function() {
return this.G;
};
mboxFactory.prototype.disable = function(bb,cb) {
if (typeof bb == 'undefined ') {
bb = 60 * 60;
}

if (typeof cb == 'undefined ') {
cb = 'unspecified ';
}

if (!this.isAdmin()) {
this.H = false;
this.J.setCookie( 'disable ',cb,bb);
}
};
mboxFactory.prototype.enable = function() {
this.H = true;
this.J.deleteCookie( 'disable ');
};
mboxFactory.prototype.isAdmin = function() {
return document.location.href.indexOf( 'mboxEnv ') != -1;
};
mboxFactory.prototype.limitTraffic = function(db,bb) {
};
mboxFactory.prototype.addOnLoad = function(eb) {
if (this.isDomLoaded()) {
eb();
}

else {
var fb = false;
var gb = function() {
if (fb) {
return;
}

fb = true;
eb();
};
this.hb.push(gb);
if (this.isDomLoaded() && !fb) {
gb();
}
}
};
mboxFactory.prototype.getEllapsedTime = function() {
return this.W - this.V;
};
mboxFactory.prototype.getEllapsedTimeUntil = function(ib) {
return ib - this.V;
};
mboxFactory.prototype.getMboxes = function() {
return this.F;
};
mboxFactory.prototype.get = function(ab,jb) {
return this.F.get(ab).getById(jb | |0);
};
mboxFactory.prototype.update = function(ab,c) {
if (!this.isEnabled()) {
return;
}

if (!this.isDomLoaded()) {
var X = this;
this.addOnLoad(function() {
X.update(ab,c);
}

);
return;
}

if (this.F.get(ab).length() == 0) {
throw "Mbox "+ ab + "is not defined ";
}

this.F.get(ab).each(function(Y) {
Y.getUrlBuilder() .addParameter( 'mboxPage ',mboxGenerateId());
Y.load(c);
}

);
};
mboxFactory.prototype.create = function( ab,c,kb) {
if (!this.isSupported()) {
return null;
}

var e = this.w.clone();
e.addParameter( 'mboxCount ',this.F.length() + 1);
e.addParameters(c);
var jb = this.F.get(ab).length();
var lb = this.D + '- '+ ab + '- '+ jb;
var mb;
if (kb) {
mb = new mboxLocatorNode(kb);
}

else {
if (this.E) {
throw 'The page has already been loaded,can \ 't write marker ';
}

mb = new mboxLocatorDefault(lb);
}

try {
var X = this;
var nb = 'mboxImported- '+ lb;
var Y = new mbox(ab,jb,e,mb,nb);
if (this.H) {
Y.setFetcher( this.E ?new mboxAjaxFetcher():new mboxStandardFetcher());
}

Y.setOnError(function(ob,n) {
Y.setMessage(ob);
Y.activate();
if (!Y.isActivated()) {
X.disable(60 * 60,ob);
window.location.reload(false);
}
}

);
this.F.add(Y);
}

catch (pb) {
this.disable();
throw 'Failed creating mbox " '+ ab + ' ",the error was: '+ pb;
}

var qb = new Date();
e.addParameter( 'mboxTime ',qb.getTime() - (qb.getTimezoneOffset() * 60000));
return Y;
};
mboxFactory.prototype.getCookieManager = function() {
return this.J;
};
mboxFactory.prototype.getPageId = function() {
return this.L;
};
mboxFactory.prototype.getPCId = function() {
return this.T;
};
mboxFactory.prototype.getSessionId = function() {
return this.S;
};
mboxFactory.prototype.getSignaler = function() {
return this._;
};
mboxFactory.prototype.getUrlBuilder = function() {
return this.w;
};
mboxFactory.prototype.U = function(e,I) {
e.addParameter( 'mboxHost ',document.location.hostname) .addParameter( 'mboxSession ',this.S.getId());
if (!I) {
e.addParameter( 'mboxFactoryId ',this.D);
}

if (this.T.getId() != null) {
e.addParameter( 'mboxPC ',this.T.getId());
}

e.addParameter( 'mboxPage ',this.L);
e.addParameter( 'screenHeight ',this.M);
e.addParameter( 'screenWidth ',this.N);
e.addParameter( 'browserWidth ',this.O);
e.addParameter( 'browserHeight ',this.P);
e.addParameter( 'browserTimeOffset ',this.R);
e.addParameter( 'colorDepth ',this.Q);
e.setUrlProcessAction(function(e) {
e += '&mboxURL= '+ encodeURIComponent(document.location);
var rb = encodeURIComponent(document.referrer);
if (e.length + rb.length <2000) {
e += '&mboxReferrer= '+ rb;
}

e += '&mboxVersion= '+ mboxVersion;
return e;
}

);
};
mboxFactory.prototype.sb = function() {
return " ";
};
mboxFactory.prototype.Z = function() {
document.write( ' <style >. '+ 'mboxDefault '+ ' {
visibility:hidden;
} </style > ');
};
mboxFactory.prototype.isDomLoaded = function() {
return this.E;
};
mboxFactory.prototype.K = function() {
if (this.hb != null) {
return;
}

this.hb = new Array();
var X = this;
(function() {
var tb = document.addEventListener ? "DOMContentLoaded ": "onreadystatechange ";
var ub = false;
var vb = function() {
if (ub) {
return;
}

ub = true;
for (var i = 0;
i <X.hb.length;
++i) {
X.hb [i ]();
}
};
if (document.addEventListener) {
document.addEventListener(tb,function() {
document.removeEventListener(tb,arguments.callee,false);
vb();
},false);
window.addEventListener( "load ",function() {
document.removeEventListener( "load ",arguments.callee,false);
vb();
},false);
}

else if (document.attachEvent) {
if (self !== self.top) {
document.attachEvent(tb,function() {
if (document.readyState === 'complete ') {
document.detachEvent(tb,arguments.callee);
vb();
}
}

);
}

else {
var wb = function() {
try {
document.documentElement.doScroll( 'left ');
vb();
}

catch (xb) {
setTimeout(wb,13);
}
};
wb();
}
}

if (document.readyState === "complete ") {
vb();
}
}

)();
};
mboxSignaler = function(yb,J) {
this.J = J;
var zb = J.getCookieNames( 'signal- ');
for (var j = 0;
j <zb.length;
j++) {
var Ab = zb [j ];
var Bb = J.getCookie(Ab).split( '& ');
var Y = yb(Bb [0 ],Bb);
Y.load();
J.deleteCookie(Ab);
}
};
mboxSignaler.prototype.signal = function(Cb,ab ) {
this.J.setCookie( 'signal- '+ Cb,mboxShiftArray(arguments).join( '& '),45 * 60);
};
mboxList = function() {
this.F = new Array();
};
mboxList.prototype.add = function(Y) {
if (Y != null) {
this.F [this.F.length ]= Y;
}
};
mboxList.prototype.get = function(ab) {
var B = new mboxList();
for (var j = 0;
j <this.F.length;
j++) {
var Y = this.F [j ];
if (Y.getName() == ab) {
B.add(Y);
}
}

return B;
};
mboxList.prototype.getById = function(Db) {
return this.F [Db ];
};
mboxList.prototype.length = function() {
return this.F.length;
};
mboxList.prototype.each = function(p) {
if (typeof p != 'function ') {
throw 'Action must be a function,was: '+ typeof(p);
}

for (var j = 0;
j <this.F.length;
j++) {
p(this.F [j ]);
}
};
mboxLocatorDefault = function(g) {
this.g = 'mboxMarker- '+ g;
document.write( ' <div id= " '+ this.g + ' "style= "visibility:hidden;
display:none " >&nbsp; </div > ');
};
mboxLocatorDefault.prototype.locate = function() {
var Eb = document.getElementById(this.g);
while (Eb != null) {
if (Eb.nodeType == 1) {
if (Eb.className == 'mboxDefault ') {
return Eb;
}
}

Eb = Eb.previousSibling;
}

return null;
};
mboxLocatorDefault.prototype.force = function() {
var Fb = document.createElement( 'div ');
Fb.className = 'mboxDefault ';
var Gb = document.getElementById(this.g);
Gb.parentNode.insertBefore(Fb,Gb);
return Fb;
};
mboxLocatorNode = function(Hb) {
this.Eb = Hb;
};
mboxLocatorNode.prototype.locate = function() {
return typeof this.Eb == 'string ' ?document.getElementById(this.Eb):this.Eb;
};
mboxLocatorNode.prototype.force = function() {
return null;
};
mboxCreate = function(ab ) {
var Y = mboxFactoryDefault.create( ab,mboxShiftArray(arguments));
if (Y) {
Y.load();
}

return Y;
};
mboxDefine = function(kb,ab ) {
var Y = mboxFactoryDefault.create(ab,mboxShiftArray(mboxShiftArray(arguments)),kb);
return Y;
};
mboxUpdate = function(ab ) {
mboxFactoryDefault.update(ab,mboxShiftArray(arguments));
};
mbox = function(g,Ib,w,Jb,nb) {
this.Kb = null;
this.Lb = 0;
this.mb = Jb;
this.nb = nb;
this.Mb = null;
this.Nb = new mboxOfferContent();
this.Fb = null;
this.w = w;
this.message = ' ';
this.Ob = new Object();
this.Pb = 0;
this.Ib = Ib;
this.g = g;
this.Qb();
w.addParameter( 'mbox ',g) .addParameter( 'mboxId ',Ib);
this.Rb = function() {
};
this.Sb = function() {
};
this.Tb = null;
};
mbox.prototype.getId = function() {
return this.Ib;
};
mbox.prototype.Qb = function() {
if (this.g.length >250) {
throw "Mbox Name "+ this.g + "exceeds max length of "+ "250 characters. ";
}

else if (this.g.match(/^ \s+ | \s+$/g)) {
throw "Mbox Name "+ this.g + "has leading/trailing whitespace(s). ";
}
};
mbox.prototype.getName = function() {
return this.g;
};
mbox.prototype.getParameters = function() {
var c = this.w.getParameters();
var B = new Array();
for (var j = 0;
j <c.length;
j++) {
if (c [j ].name.indexOf( 'mbox ') != 0) {
B [B.length ]= c [j ].name + '= '+ c [j ].value;
}
}

return B;
};
mbox.prototype.setOnLoad = function(p) {
this.Sb = p;
return this;
};
mbox.prototype.setMessage = function(ob) {
this.message = ob;
return this;
};
mbox.prototype.setOnError = function(Rb) {
this.Rb = Rb;
return this;
};
mbox.prototype.setFetcher = function(Ub) {
if (this.Mb) {
this.Mb.cancel();
}

this.Mb = Ub;
return this;
};
mbox.prototype.getFetcher = function() {
return this.Mb;
};
mbox.prototype.load = function(c) {
if (this.Mb == null) {
return this;
}

this.setEventTime( "load.start ");
this.cancelTimeout();
this.Lb = 0;
var w = (c && c.length >0) ?this.w.clone().addParameters(c):this.w;
this.Mb.fetch(w);
var X = this;
this.Vb = setTimeout(function() {
X.Rb( 'browser timeout ',X.Mb.getType());
},15000);
this.setEventTime( "load.end ");
return this;
};
mbox.prototype.loaded = function() {
this.cancelTimeout();
if (!this.activate()) {
var X = this;
setTimeout(function() {
X.loaded();
},100);
}
};
mbox.prototype.activate = function() {
if (this.Lb) {
return this.Lb;
}

this.setEventTime( 'activate '+ ++this.Pb + '.start ');
if (this.show()) {
this.cancelTimeout();
this.Lb = 1;
}

this.setEventTime( 'activate '+ this.Pb + '.end ');
return this.Lb;
};
mbox.prototype.isActivated = function() {
return this.Lb;
};
mbox.prototype.setOffer = function(Nb) {
if (Nb && Nb.show && Nb.setOnLoad) {
this.Nb = Nb;
}

else {
throw 'Invalid offer ';
}

return this;
};
mbox.prototype.getOffer = function() {
return this.Nb;
};
mbox.prototype.show = function() {
this.setEventTime( 'show.start ');
var B = this.Nb.show(this);
this.setEventTime(B == 1 ? "show.end.ok ": "show.end ");
return B;
};
mbox.prototype.showContent = function(Wb) {
if (Wb == null) {
return 0;
}

if (this.Fb == null | |!this.Fb.parentNode) {
this.Fb = this.getDefaultDiv();
if (this.Fb == null) {
return 0;
}
}

if (this.Fb != Wb) {
this.Xb(this.Fb);
this.Fb.parentNode.replaceChild(Wb,this.Fb);
this.Fb = Wb;
}

this.Yb(Wb);
this.Sb();
return 1;
};
mbox.prototype.hide = function() {
this.setEventTime( 'hide.start ');
var B = this.showContent(this.getDefaultDiv());
this.setEventTime(B == 1 ? 'hide.end.ok ': 'hide.end.fail ');
return B;
};
mbox.prototype.finalize = function() {
this.setEventTime( 'finalize.start ');
this.cancelTimeout();
if (this.getDefaultDiv() == null) {
if (this.mb.force() != null) {
this.setMessage( 'No default content,an empty one has been added ');
}

else {
this.setMessage( 'Unable to locate mbox ');
}
}

if (!this.activate()) {
this.hide();
this.setEventTime( 'finalize.end.hide ');
}

this.setEventTime( 'finalize.end.ok ');
};
mbox.prototype.cancelTimeout = function() {
if (this.Vb) {
clearTimeout(this.Vb);
}

if (this.Mb != null) {
this.Mb.cancel();
}
};
mbox.prototype.getDiv = function() {
return this.Fb;
};
mbox.prototype.getDefaultDiv = function() {
if (this.Tb == null) {
this.Tb = this.mb.locate();
}

return this.Tb;
};
mbox.prototype.setEventTime = function(Zb) {
this.Ob [Zb ]= (new Date()).getTime();
};
mbox.prototype.getEventTimes = function() {
return this.Ob;
};
mbox.prototype.getImportName = function() {
return this.nb;
};
mbox.prototype.getURL = function() {
return this.w.buildUrl();
};
mbox.prototype.getUrlBuilder = function() {
return this.w;
};
mbox.prototype._b = function(Fb) {
return Fb.style.display != 'none ';
};
mbox.prototype.Yb = function(Fb) {
this.ac(Fb,true);
};
mbox.prototype.Xb = function(Fb) {
this.ac(Fb,false);
};
mbox.prototype.ac = function(Fb,bc) {
Fb.style.visibility = bc ? "visible ": "hidden ";
Fb.style.display = bc ? "block ": "none ";
};
mboxOfferContent = function() {
this.Sb = function() {
};
};
mboxOfferContent.prototype.show = function(Y) {
var B = Y.showContent(document.getElementById(Y.getImportName()));
if (B == 1) {
this.Sb();
}

return B;
};
mboxOfferContent.prototype.setOnLoad = function(Sb) {
this.Sb = Sb;
};
mboxOfferAjax = function(Wb) {
this.Wb = Wb;
this.Sb = function() {
};
};
mboxOfferAjax.prototype.setOnLoad = function(Sb) {
this.Sb = Sb;
};
mboxOfferAjax.prototype.show = function(Y) {
var cc = document.createElement( 'div ');
cc.id = Y.getImportName();
cc.innerHTML = this.Wb;
var B = Y.showContent(cc);
if (B == 1) {
this.Sb();
}

return B;
};
mboxOfferDefault = function() {
this.Sb = function() {
};
};
mboxOfferDefault.prototype.setOnLoad = function(Sb) {
this.Sb = Sb;
};
mboxOfferDefault.prototype.show = function(Y) {
var B = Y.hide();
if (B == 1) {
this.Sb();
}

return B;
};
mboxCookieManager = function mboxCookieManager(g,dc) {
this.g = g;
this.dc = dc == ' ' | |dc.indexOf( '. ') == -1 ? ' ': ';
domain= '+ dc;
this.ec = new mboxMap();
this.loadCookies();
};
mboxCookieManager.prototype.isEnabled = function() {
this.setCookie( 'check ', 'true ',60);
this.loadCookies();
return this.getCookie( 'check ') == 'true ';
};
mboxCookieManager.prototype.setCookie = function(g,h,bb) {
if (typeof g != 'undefined '&& typeof h != 'undefined '&& typeof bb != 'undefined ') {
var fc = new Object();
fc.name = g;
fc.value = escape(h);
fc.expireOn = Math.ceil(bb + new Date().getTime() / 1000);
this.ec.put(g,fc);
this.saveCookies();
}
};
mboxCookieManager.prototype.getCookie = function(g) {
var fc = this.ec.get(g);
return fc ?unescape(fc.value):null;
};
mboxCookieManager.prototype.deleteCookie = function(g) {
this.ec.remove(g);
this.saveCookies();
};
mboxCookieManager.prototype.getCookieNames = function(gc) {
var hc = new Array();
this.ec.each(function(g,fc) {
if (g.indexOf(gc) == 0) {
hc [hc.length ]= g;
}
}

);
return hc;
};
mboxCookieManager.prototype.saveCookies = function() {
var ic = false;
var jc = 'disable ';
var kc = new Array();
var lc = 0;
this.ec.each(function(g,fc) {
if(!ic | |g === jc) {
kc [kc.length ]= g + '# '+ fc.value + '# '+ fc.expireOn;
if (lc <fc.expireOn) {
lc = fc.expireOn;
}
}
}

);
var mc = new Date(lc * 1000);
document.cookie = this.g + '= '+ kc.join( ' | ') + ';
expires= '+ mc.toGMTString() + ';
path=/ '+ this.dc;
};
mboxCookieManager.prototype.loadCookies = function() {
this.ec = new mboxMap();
var nc = document.cookie.indexOf(this.g + '= ');
if (nc != -1) {
var oc = document.cookie.indexOf( '; ',nc);
if (oc == -1) {
oc = document.cookie.indexOf( ', ',nc);
if (oc == -1) {
oc = document.cookie.length;
}
}

var pc = document.cookie.substring( nc + this.g.length + 1,oc).split( ' | ');
var qc = Math.ceil(new Date().getTime() / 1000);
for (var j = 0;
j <pc.length;
j++) {
var fc = pc [j ].split( '# ');
if (qc <= fc [2 ]) {
var rc = new Object();
rc.name = fc [0 ];
rc.value = fc [1 ];
rc.expireOn = fc [2 ];
this.ec.put(rc.name,rc);
}
}
}
};
mboxSession = function(sc,tc,Ab,uc,J) {
this.tc = tc;
this.Ab = Ab;
this.uc = uc;
this.J = J;
this.vc = false;
this.Ib = typeof mboxForceSessionId != 'undefined ' ?mboxForceSessionId:mboxGetPageParameter(this.tc);
if (this.Ib == null | |this.Ib.length == 0) {
this.Ib = J.getCookie(Ab);
if (this.Ib == null | |this.Ib.length == 0) {
this.Ib = sc;
this.vc = true;
}
}

J.setCookie(Ab,this.Ib,uc);
};
mboxSession.prototype.getId = function() {
return this.Ib;
};
mboxSession.prototype.forceId = function(wc) {
this.Ib = wc;
this.J.setCookie(this.Ab,this.Ib,this.uc);
};
mboxPC = function(Ab,uc,J) {
this.Ab = Ab;
this.uc = uc;
this.J = J;
this.Ib = typeof mboxForcePCId != 'undefined ' ?mboxForcePCId:J.getCookie(Ab);
if (this.Ib != null) {
J.setCookie(Ab,this.Ib,uc);
}
};
mboxPC.prototype.getId = function() {
return this.Ib;
};
mboxPC.prototype.forceId = function(wc) {
if (this.Ib != wc) {
this.Ib = wc;
this.J.setCookie(this.Ab,this.Ib,this.uc);
return true;
}

return false;
};
mboxGetPageParameter = function(g) {
var B = null;
var xc = new RegExp(g + "=( [^ \& ]*) ");
var yc = xc.exec(document.location);
if (yc != null && yc.length >= 2) {
B = yc [1 ];
}

return B;
};
mboxSetCookie = function(g,h,bb) {
return mboxFactoryDefault.getCookieManager().setCookie(g,h,bb);
};
mboxGetCookie = function(g) {
return mboxFactoryDefault.getCookieManager().getCookie(g);
};
mboxCookiePageDomain = function() {
var dc = (/( [^: ]*)(: [0-9 ] {
0,5
}

) ?/).exec(document.location.host) [1 ];
var zc = / [0-9 ] {
1,3
} \. [0-9 ] {
1,3
} \. [0-9 ] {
1,3
} \. [0-9 ] {
1,3
}

/;
if (!zc.exec(dc)) {
var Ac = (/( [^ \. ]+ \. [^ \. ] {
3
} | [^ \. ]+ \. [^ \. ]+ \. [^ \. ] {
2
}

)$/).exec(dc);
if (Ac) {
dc = Ac [0 ];
}
}

return dc ?dc: " ";
};
mboxShiftArray = function(Bc) {
var B = new Array();
for (var j = 1;
j <Bc.length;
j++) {
B [B.length ]= Bc [j ];
}

return B;
};
mboxGenerateId = function() {
return (new Date()).getTime() + "- "+ Math.floor(Math.random() * 999999);
};
mboxScreenHeight = function() {
return screen.height;
};
mboxScreenWidth = function() {
return screen.width;
};
mboxBrowserWidth = function() {
return (window.innerWidth) ?window.innerWidth:document.documentElement ?document.documentElement.clientWidth:document.body.clientWidth;
};
mboxBrowserHeight = function() {
return (window.innerHeight) ?window.innerHeight:document.documentElement ?document.documentElement.clientHeight:document.body.clientHeight;
};
mboxBrowserTimeOffset = function() {
return -new Date().getTimezoneOffset();
};
mboxScreenColorDepth = function() {
return screen.pixelDepth;
};
if (typeof mboxVersion == 'undefined ') {
var mboxVersion = 41;
var mboxFactories = new mboxMap();
var mboxFactoryDefault = new mboxFactory( 'equinoxfitnessclubs.tt.omtrdc.net ', 'equinoxfitnessclubs ', 'default ');
};
if (mboxGetPageParameter( "mboxDebug ") != null | |mboxFactoryDefault.getCookieManager() .getCookie( "debug ") != null) {
setTimeout(function() {
if (typeof mboxDebugLoaded == 'undefined ') {
alert( 'Could not load the remote debug. \nPlease check your connection '+ 'to Test&amp;
Target servers ');
}
},60*60);
document.write( ' < '+ 'scr '+ 'ipt language= "Javascript1.2 "src= '+ ' "http://admin6.testandtarget.omniture.com/admin/mbox/mbox_debug.jsp ?mboxServerHost=equinoxfitnessclubs.tt.omtrdc.net '+ '&clientCode=equinoxfitnessclubs " > < '+ ' \/scr '+ 'ipt > ');
};
mboxScPluginFetcher = function(b,Cc) {
this.b = b;
this.Cc = Cc;
};
mboxScPluginFetcher.prototype.Dc = function(w) {
w.setBasePath( '/m2/ '+ this.b + '/sc/standard ');
this.Ec(w);
var e = w.buildUrl();
e += '&scPluginVersion=1 ';
return e;
};
mboxScPluginFetcher.prototype.Ec = function(w) {
var Fc = [ "dynamicVariablePrefix ", "visitorID ", "vmk ", "ppu ", "charSet ", "visitorNamespace ", "cookieDomainPeriods ", "cookieLifetime ", "pageName ", "currencyCode ", "variableProvider ", "channel ", "server ", "pageType ", "transactionID ", "purchaseID ", "campaign ", "state ", "zip ", "events ", "products ", "linkName ", "linkType ", "resolution ", "colorDepth ", "javascriptVersion ", "javaEnabled ", "cookiesEnabled ", "browserWidth ", "browserHeight ", "connectionType ", "homepage ", "pe ", "pev1 ", "pev2 ", "pev3 ", "visitorSampling ", "visitorSamplingGroup ", "dynamicAccountSelection ", "dynamicAccountList ", "dynamicAccountMatch ", "trackDownloadLinks ", "trackExternalLinks ", "trackInlineStats ", "linkLeaveQueryString ", "linkDownloadFileTypes ", "linkExternalFilters ", "linkInternalFilters ", "linkTrackVars ", "linkTrackEvents ", "linkNames ", "lnk ", "eo " ];
for (var j = 0;
j <Fc.length;
j++) {
this.Gc(Fc [j ],w);
}

for (var j = 1;
j <= 75;
j++) {
this.Gc( 'prop '+ j,w);
this.Gc( 'eVar '+ j,w);
this.Gc( 'hier '+ j,w);
}
};
mboxScPluginFetcher.prototype.Gc = function(g,w) {
var h = this.Cc [g ];
if (typeof(h) === 'undefined ' | |h === null | |h === ' ') {
return;
}

w.addParameter(g,h);
};
mboxScPluginFetcher.prototype.cancel = function() {
};
mboxScPluginFetcher.prototype.fetch = function(w) {
w.setServerType(this.getType());
var e = this.Dc(w);
this.x = document.createElement( 'script ');
this.x.src = e;
document.body.appendChild(this.x);
};
mboxScPluginFetcher.prototype.getType = function() {
return 'ajax ';
};
function mboxLoadSCPlugin(Cc) {
if (!Cc) {
return null;
}

Cc.m_tt = function(Cc) {
var Hc = Cc.m_i( 'tt ');
Hc.H = true;
Hc.b = 'equinoxfitnessclubs ';
Hc [ '_t ' ]= function() {
if (!this.isEnabled()) {
return;
}

var Y = this.Jc();
if (Y) {
var Ub = new mboxScPluginFetcher(this.b,this.s);
Y.setFetcher(Ub);
Y.load();
}
};
Hc.isEnabled = function() {
return this.H && mboxFactoryDefault.isEnabled();
};
Hc.Jc = function() {
var ab = this.Kc();
var Fb = document.createElement( 'DIV ');
return mboxFactoryDefault.create(ab,new Array(),Fb);
};
Hc.Kc = function() {
var Lc = this.s.events && this.s.events.indexOf( 'purchase ') != -1;
return 'SiteCatalyst: '+ (Lc ? 'purchase ': 'event ');
};
};
return Cc.loadModule( 'tt ');
};
var mboxTrack=function(mbox,params) {
var m,u,i,f=mboxFactoryDefault;
if(f.isEnabled()) {
if(f.getMboxes().length() >0) {
m=f.getMboxes().getById(0);
u=m.getURL().replace( "mbox= "+escape(m.getName()), "mbox= "+mbox).replace( "/undefined ", "/ajax ").replace( "mboxPage= "+f.getPageId(), "mboxPage= "+mboxGenerateId())+ '& '+params,i=new Image();
i.style.display= 'none ';
i.src=u;
document.body.appendChild(i)
}

else {
mboxTrackDefer(mbox,params)
}
}
},mboxTrackDefer=function(mbox,params) {
var f=mboxFactoryDefault;
if(f.isEnabled()) {
mboxFactoryDefault.getSignaler().signal(mbox,mbox+ '& '+params)
}
},mboxTrackLink=function(mbox,params,url) {
mboxTrack(mbox,params);
setTimeout( "location= ' "+url+ " ' ",500)
};
mboxScPluginFetcher.prototype.Gc = function(g,w) {
var h = this.Cc [g ];
if (typeof(h) === 'undefined ' | |h === null | |h === ' ') {
return;
}

if (!g.match( "^(linkInternalFilters |linkTrackVars |linkTrackEvents |linkDownloadFileTypes |prop1 |prop2 |eVar3 |prop6 |prop7 |prop8 |prop9 |prop11 |prop14 |eVar14 |prop15 |eVar15 |prop17 |prop21 |prop23 |prop24 |eVar24 |eVar33 |prop35 |prop36 |eVar49)$ ")) w.addParameter(g,h);
};
var mboxTrack=function(mbox,params) {
var m,u,i,f=mboxFactoryDefault;
if(f.isEnabled()) {
if(f.getMboxes().length() >0) {
m=f.getMboxes().getById(0);
u=m.getURL().replace( "mbox= "+escape(m.getName()), "mbox= "+mbox).replace( "/undefined ", "/ajax ").replace( "mboxPage= "+f.getPageId(), "mboxPage= "+mboxGenerateId())+ '& '+params,i=new Image();
i.style.display= 'none ';
i.src=u;
document.body.appendChild(i)
}

else {
mboxTrackDefer(mbox,params)
}
}
},mboxTrackDefer=function(mbox,params) {
var f=mboxFactoryDefault;
if(f.isEnabled()) {
mboxFactoryDefault.getSignaler().signal(mbox,mbox+ '& '+params)
}
},mboxTrackLink=function(mbox,params,url) {
mboxTrack(mbox,params);
setTimeout( "location= ' "+url+ " ' ",500)
};