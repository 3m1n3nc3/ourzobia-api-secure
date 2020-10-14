/**
 * Ourzobia PHP Api
 * v1.1.1
 * alimontaziba.js
 * form loader and validator
 * var src is the url to pass all api request
 * url can be auto generated by passing data-api in the alimon.js loader script tag
 */

var loc = window.location.hostname;
var domain = encodeURIComponent(loc); 
var url;

var _script = document.querySelector('[data-current="true"]');

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
		
		var VCookies = Cookies.noConflict(); 
		var verified = VCookies.get('verified'); 
 	
	 	// VCookies.remove('verified');
	 	// 
	 	// Generate and load the activation form
		if (typeof verified === "undefined" || verified === false) {
			var form = $("<form />", {action: "requests/activate", method: "POST", id: "product_activation_form"}).append(
				$("<div />", {class: "form-group"}).append(
					$("<label />", {for: "activation_email", text: "Email Address"}),
					$("<input />", {type: "email", class: "form-control", name: "email", id: "activation_email", "aria-describedby": "emailHelp", placeholder: "Enter Email Address"}),
					$("<small />", {id: "emailHelp", class: "form-text text-muted", text: "This is the email address used during purchase."})
				),
				$("<div />", {class: "form-group"}).append(
					$("<label />", {for: "activation_code", text: "Purchase Code"}),
					$("<input />", {type: "text", class: "form-control", name: "code", id: "activation_code", "aria-describedby": "emailHelp", placeholder: "Purchase Code"})
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
				VCookies.set('verified', true, { expires: 45 });
				window.location.reload(true);
			} else {
				// If installation is not active load the activation form to the body
				var section = $("<section />", {class: "api"}).append(carder);
				$("body").html(section);

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
	}

	/**
	 * Activate the installation
	 * @param  {object} 	$this 	the form initiating this method
	 * @return {null}     
	 */
	function activate($this) {  
		$.post(url+"requests/activate", {
			domain: domain,
			email: $("#activation_email").val(),
			code: $("#activation_code").val()
		}, function(data) {
			if (data.message) {
				$(".notificationbox").alert_notice(data.message, data.status);
			}

			if (data.success === true) {
				VCookies.set('verified', true, { expires: 45 });
				$("button[type=submit]").buttonSpinner("stop");
				$("button[type=submit]").remove();
				window.location.reload(true);
			}
		});
	}
});

/**
 * Checks if the installation has been activated 
 * @return {null}     
 */
function verify() { 
	var resp = false;  
	$.ajax({
		async: false,
		url: url+"requests/verify", 
		method: "POST",
		dataType: "JSON",
		data: {domain: domain},   
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

// Generate an alert
jQuery.fn.alert_notice = function (message = 'A network error occurred!', type = 'warning') { 
    if (type === 'error') {
        type = 'danger';
    }

    var general_notice = $("<div></div>")
        .html('<button type="button" class="close float-right" data-dismiss="alert" aria-hidden="true">&times;</button>' + message)
        .addClass("alert alert-dismissible alert-"+type)
        .attr("id", "install-alert");

    $(this).find("#install-alert").remove();
    $( this ).append(general_notice);
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