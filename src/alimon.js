var loc = window.location.hostname;
var domain = encodeURIComponent(loc);
var m ='';
$('#checked').remove();

var request;
var src_url;
 
if (typeof src_url === "undefined") {
	src_url = "https://cdn.jsdelivr.net/gh/3m1n3nc3/ourzobia-api@1.0.0/src/";
} 

if (typeof $ === 'undefined') {
	var script = document.createElement("script"); 
	script.src = "include.jquery.js"; 
	document.getElementsByTagName("head")[0].appendChild(script);
} 

var script1 = document.createElement("script");
script1.async = true;
script1.src = src_url+"js.cookie.js";
script1.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script");
script2.async = true;
script2.src = src_url+"alimontaziba.js";
script2.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script2);

var style = document.createElement("link");
style.rel = "stylesheet";
style.href = src_url+"alimon.css"; 
document.getElementsByTagName("head")[0].appendChild(style);
