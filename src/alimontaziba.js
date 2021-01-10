/**
 * HubBoxx PHP Api Plugin v1.2.1
 * form loader and validator
 * var src is the url to pass all api request
 * url can be auto generated by passing data-api in the alimon.js loader script tag
 *
 * Copyright 2020, ToneFlix PHP
 * Released under the MIT license
 */

var loc = window.location.hostname;
var domain = encodeURIComponent(loc);
var url;

var _script  = document.querySelector('[data-current="true"]');
var _license = document.querySelector('meta[name="tc:license"]');
var _product = document.querySelector('meta[name="tc:product"]');

if (typeof _license !== "undefined" && _license !== null) {
	_license = _license.getAttribute('content');
} else {
	_license = "";
}

if (typeof _product !== "undefined" && _product !== null) {
	_product = _product.getAttribute('content');
} else {
	_product = "";
}

if (typeof _script !== "undefined") {
	var api_src = _script.getAttribute('data-api');

	if (typeof api_src !== "undefined") {
		var url = api_src.replace(/(\w+\b)(\.min.js\b\/|\.js\/|\.min.js\b|\.js\b)/gi, "");
	}
}
 
if (typeof url === "undefined") {
	var url = "http://api.ourzobiaphp.cf/";
}

$(function() {
	// Initialize the cookies without conflict
	if (typeof Cookies !== "undefined") {	
		
		// var VCookies = Cookies.noConflict(); 
		var verified = Cookies.get('verified'); 

		if (typeof verified !== "undefined") {
			verified = Boolean(verified);
		}
	 	// Cookies.remove('verified');
	 	// 
	 	// Generate and load the activation form
		if (verified !== true) {
			var form = $("<form />", {action: "requests/activate", method: "POST", id: "product_activation_form"}).append(
				$("<div />", {class: "form-group"}).append(
					$("<label />", {for: "activation_email", text: "Email Address"}),
					$("<input />", {type: "email", class: "form-control", name: "email", id: "activation_email", "aria-describedby": "emailHelp", placeholder: "Enter Email Address"}),
					$("<small />", {id: "emailHelp", class: "form-text text-muted", text: "This is the email address used during purchase."})
				),
				$("<div />", {class: "form-group"}).append(
					$("<label />", {for: "activation_code", text: "Purchase Code"}),
					$("<input />", {type: "text", class: "form-control", name: "code", id: "activation_code", "aria-describedby": "emailHelp", placeholder: "Purchase Code"}),
					$("<p />", {class: "my-1"}).append(
						$("<a />", {href: url + "login", target: "_blank", text: "Lost Purchase Code?"})
					)
				),
				$("<button />", {type: "submit", class: "btn btn-primary btn-block btn-lg", text: "Activate Product"})

			);

			// Append the activation form to a card
			var carder = $("<div />", {class: "card"}).append(
				$("<div />", {class: "card-body"}).append(
					$("<h1 />", {class: "text-danger", text: "Activate Your Product."}),
					$("<div />", {class: "notificationbox"}),
					$("<h5 />", {class: "text-info mb-5", text: "Please enter the details from your purchase point."}),
					form
				)
			);

			// Check if the installation has been activated
			if (verify() === true) {
				Cookies.set('verified', true, { expires: 45 });
				window.location.reload(true);
			} else {
				// If installation is not active load the activation form to the body
				var section = $("<section />", {class: "api"}).append(carder);
				$("body").html(section);

				check_update();

				// Process the activation
				var activation_form = $("#product_activation_form");
				activation_form.on("submit", function(e) {
					e.preventDefault();
					$("button[type=submit]").buttonSpinner("start");
					$(".notificationbox").alert_notice('Please Wait...', 'info');
					activate(e);
				});
			}
		} 

		/**
		 * Activate the installation
		 * @param  {object} 	$this 	the form initiating this method
		 * @return {null}     
		 */
		function activate($this) {  
			$.post(url+"requests/activate?origin=alimontaziba.js", {
				domain: domain,
				license: _license,
				product: _product,
				email: $("#activation_email").val(),
				code: $("#activation_code").val()
			}, function(data) {
				$("button[type=submit]").buttonSpinner("stop");
				if (data.message) {
					$(".notificationbox").alert_notice(data.message, data.status);
				}

				if (data.success === true) {
					Cookies.set('verified', true, { expires: 45 });
					$("button[type=submit]").remove();
					window.location.reload(true);
				}
			});
		}
	}
});

/**
 * Checks if the installation has been activated 
 * @return {null}     
 */
function verify() { 
	var resp = false;  
	var data = {domain: domain, license: _license, product: _product};  
	$.ajax({
		async: false,
		url: url+"requests/verify?origin=alimontaziba.js", 
		method: "POST",
		dataType: "JSON",
		data: data,   
		success: function(data) { 
			if (data.success === true) {  
				resp = true;
			} else { 
				resp = false;
			}
		} 
	});
 
	return resp;
} 

/**
 * Checks if there is an update required for validation
 * @return {null}     
 */
function check_update() { 
	var resp = false;  
	var data = {domain: domain, product: _product, type: 'validation'};  
	$("#update_box").remove();
	$.ajax({
		async: false,
		url: url+"requests/check_updates?origin=alimontaziba.js", 
		method: "POST",
		dataType: "JSON",
		data: data,   
		success: function(data) { 
			if (data.success === true) {
				$("#product_activation_form").prepend(
					$("<div />", {id: "update_box", class: "mb-5"})
				);
				var update = $("<div />", {class: "container"});
				$("<h5 />", {class: "text-success", html: "New Updates Available!"}).appendTo(update);
				$("#update_box").alert_notice(update, data.status);
 
				if (data.updates) {
					for (i = 0; i < data.updates.length; i++) {
						var update_item = data.updates[length];
						$("<div />", {class: "border-top my-1"}).append(
							$("<a />", {id: "load_update", href: update_item.link, html: update_item.filename}),
							$("<div />", {class: "small", html: "File Size: " + update_item.filesize}),
							$("<div />", {class: "small text-info", html: update_item.message})
						).appendTo(update);
					} 
				}
			}
		} 
	});
 
	return resp;
} 

// Generate an alert
jQuery.fn.alert_notice = function (message = 'A network error occurred!', type = 'warning', dismiss = true) { 
    if (type === 'error') {
        type = 'danger';
    } else if (type === 'notice') {
        type = 'info';
    } 

    let general_notice = $("<div />", {class: "my-1 alert alert-dismissible alert-"+type, id: "create-alert-notice"})
        .append(
            dismiss === true ? 
            $("<button />", {class: "close", type: "button", "data-dismiss": "alert", "aria-hidden": "true", html: "&times;"}) : ""
        )
        .append(message);
  
    $this = $( this ).show().removeClass("d-none").removeClass("hidden").html(general_notice);

    if (dismiss === "auto") {
        setTimeout(function() {
            $this.children("#create-alert-notice").fadeOut("slow");
        }, 4000);
    }
}

jQuery.fn.buttonSpinner = function (action) {
    var self = $(this);
    var size_spinner = '';
    if (action == 'start') {
      	if ($(self).attr('disabled') == 'disabled') {
        	return false;
      	}
      	$(self).attr('data-btn-text', $(self).text());
      	if($(self).attr('data-spinner-type')) {
        	var type_spinner = $(self).attr('data-spinner-type');
      	} else {
        	var type_spinner = 'border';
      	};
      	if($(self).hasClass('btn-lg')) {
        	var size_spinner = 'spinner-' + type_spinner + '-lg';
      	};
      	if($(self).hasClass('btn-sm')) {
        	var size_spinner = 'spinner-' + type_spinner + '-sm';
      	};
      	if($(self).hasClass('btn-xs')) {
        	var size_spinner = 'spinner-' + type_spinner + '-xs';
      	};
      	if($(self).attr('data-spinner-text')) {
        	var text_spinner = '<span class="ml-2">' + $(self).attr('data-spinner-text') + '</span>';
      	} else {
        	var text_spinner = '<span class="sr-only d-block position-relative w-auto invisible" style="height:0;">' + $(self).attr('data-btn-text') + '</span>';
      	};
      	if($(self).hasClass('btn-spinner') != null) {
        	$(self).html('<span class="spinner-' + type_spinner + ' ' + size_spinner + '" role="status" aria-hidden="true"></span>' + text_spinner );
      	} else {
        	$(self).html(text_spinner);
      	};
      	$(self).addClass('disabled');
      	$(self).attr('disabled', true);
    }
    if (action == 'stop') {
      	$(self).html($(self).attr('data-btn-text'));
      	$(self).attr('disabled', false).removeClass('disabled');
    }
}
