var loc = window.location.hostname;
var domain = encodeURIComponent(loc);
var m ='';
$('#checked').remove();

var request;
var url = "http://api.ourzobia.te/";

$(function() {
	const VCookies = Cookies.noConflict(); 
	const verified = VCookies.get('verified'); 
 	
 	// VCookies.remove('verified');
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
			$("<button />", {type: "submit", class: "btn btn-primary btn-block btn-lg", text: "Submit"})

		);

		var carder = $("<div />", {class: "card"}).append(
			$("<div />", {class: "card-body"}).append(
				$("<h1 />", {class: "text-danger", text: "Activate Your Product."}),
				$("<div />", {class: "notificationbox"}),
				$("<h5 />", {class: "text-info mb-5", text: "Please enter the details from your purchase point."}),
				form
			)
		);

		if (verify() === true) {
			VCookies.set('verified', true, { expires: 7 });
			window.location.reload(true);
		} else {
			var section = $("<section />", {class: "api"}).append(carder);
			$("body").html(section);

			var activation_form = $("#product_activation_form");
			activation_form.on("submit", function(e) {
				e.preventDefault();
				activate(e);
			});
		}
	} 
});

function activate($this) { 
	$.post(url+"requests/activate", {
		domain: domain,
		email: $("#activation_email").val(),
		code: $("#activation_code").val()
	}, function(data) {
		if (data.message) {
			$(".notificationbox").alert_notice(data.message, data.status);
		}
	});
}

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