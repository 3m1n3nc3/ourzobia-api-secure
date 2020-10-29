
    var processStripePayment = (data, base_url, public_key) => {
        $("head").jsCssLoader(
            'https://js.stripe.com/v3/', 'js', function(e) {
                let form = $("<form />", {class: "modal-body stripe payment-processor bg-light", id: "payment-form"})
                .append($("<div />", {id: "card-element"}))
                .append(
                    $("<button />", {id: "submit"})
                        .append($("<div />", {class: "spinner hidden", id: "spinner"}))
                        .append($("<div />", {id: "button-text", text: "Pay Now"}))
                ) 
                .append($("<p />", {class: "payment-notification hidden", role: "alert"}));

                $(".payment-processor").remove();
                $(".modal.fade.show .modal-dialog").removeClass("modal-lg").removeClass("modal-sm").removeClass("modal-md");
                $(".modal.fade.show .modal-dialog .modal-content").html(form);

                var stripe = Stripe(public_key);
                var purchase = {
                    items: data
                };
                $("#card-element button").attr("disabled", true);
                $.post(link('ajax/payments/stripe/payment_intents'), purchase, function(resp) {
                    var elements = stripe.elements();
                    var style = {
                        base: {
                            color: "#32325d",
                            fontFamily: 'Arial, sans-serif',
                            fontSmoothing: "antialiased",
                            fontSize: "16px",
                            "::placeholder": {
                                color: "#32325d"
                            }
                        },
                        invalid: {
                            fontFamily: 'Arial, sans-serif',
                            color: "#fa755a",
                            iconColor: "#fa755a"
                        }
                    };
                    var card = elements.create("card", { style: style });
                    // Stripe injects an iframe into the DOM
                    card.mount("#card-element");
                    card.on("load", function (event) {console.log("onreadystatechange")});
                    card.on("change", function (event) {
                        // Disable the Pay button if there are no card details in the Element
                        $("#payment-form button").attr("disabled", event.empty);
                        if (event.error) {
                            $("#payment-form .payment-notification").alert_notice(event.error.message, "error", "auto");
                        } 
                    });

                    $("#payment-form").on("submit", function(event) {
                        event.preventDefault();
                        // Complete payment when the submit button is clicked
                        payWithCard(stripe, card, resp.client_secret);
                    });

                    // Calls stripe.confirmCardPayment
                    // If the card requires authentication Stripe shows a pop-up modal to
                    // prompt the user to enter authentication details without leaving your page.
                    var payWithCard = function(stripe, card, clientSecret) {
                        loading(true);
                        stripe.confirmCardPayment(clientSecret, {
                            receipt_email: data.email,
                            payment_method: {
                                card: card
                            }
                        })
                        .then(function(result) {
                            $( document ).trigger("payment_loaded", result);
                            if (result.error) {
                                // Show error to your customer 
                                loading(false);
                                $( document ).trigger("payment_fail", result);
                                // $("#payment-form .payment-notification").alert_notice(result.error.message, "error", "auto");
                            } else {
                                // The payment succeeded!
                                loading(false); 
                                $( document ).trigger("payment_success", result);
                                // $("#payment-form .payment-notification").alert_notice("Payment was successful!", "success", false); 
                                $("#payment-form button").attr("disabled", true);
                            }
                        });
                    };  

                    // Show a spinner on payment submission
                    var loading = function(isLoading) {
                        if (isLoading) {
                            // Disable the button and show a spinner
                            $("#payment-form button").attr("disabled", true);
                            $("#payment-form #spinner").removeClass("hidden");
                            $("#payment-form #button-text").addClass("hidden");
                        } else {
                            $("#payment-form button").attr("disabled", false);
                            $("#payment-form #spinner").addClass("hidden");
                            $("#payment-form #button-text").removeClass("hidden");
                        }
                    };
                })
            }, 
            function(script) {return(typeof Stripe !== "undefined")}
        );
    } 