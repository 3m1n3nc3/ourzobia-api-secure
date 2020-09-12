/**
 * var src_url is the url to include all required resources 
 * from either public/resources or src directories
 */
var src_url;
 
if (typeof src_url === "undefined") {
	src_url = "https://cdn.jsdelivr.net/gh/3m1n3nc3/ourzobia-api@1.0.0/src/";
} 

// If jquery does not exist, load the latest version from CDN
if (typeof $ === 'undefined') {
	var script = document.createElement("script"); 
	script.src = "https://cdn.jsdelivr.net/npm/jquery@3/dist/jquery.min.js"; 
	document.getElementsByTagName("head")[0].appendChild(script);
} 

// load cookie.js
var script1 = document.createElement("script");
script1.async = true;
script1.src = src_url+"resources/js.cookie.js";
script1.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script1);

// Load alimontaziba.js
var script2 = document.createElement("script");
script2.async = true;
script2.src = src_url+"resources/alimontaziba.js";
script2.setAttribute('crossorigin','*');
document.getElementsByTagName("head")[0].appendChild(script2);

// Load alimon.css
var style = document.createElement("link");
style.rel = "stylesheet";
style.href = src_url+"resources/alimon.css"; 
document.getElementsByTagName("head")[0].appendChild(style);
