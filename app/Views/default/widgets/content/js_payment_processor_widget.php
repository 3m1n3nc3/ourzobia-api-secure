<?php $request = service("request"); ?>
<script id="payment-processor-widget">  

    <?php if (!$request->isAJAX()):?>
    window.onload = function() {
    <?php endif;?> 

        if (typeof verify_initiation !== "undefined") {
            $('body').off('click', '.process-payment .payment-method');
            $('body').off('change', '.payment-processor select[name=duration]');
        }

        var form   = $(".payment-processor");

        var duration = form.find("select[name=duration] option:selected").val();  
        var duration = duration ? duration : 1;  
        var name     = form.find("input[name=name]").val();  
        var checkin  = form.find("input[name=checkin_date]").val();  
        var amount   = (Number(form.find("input[name=amount]").val())*duration).toFixed(2);

        var wallet = $(".payment-processor").find("button[data-processor=wallet]").data("balance");
        var wallet = wallet ? wallet : 0.00;  

        if (amount>wallet) {
            $(".payment-processor").find("button[data-processor=wallet]").hide();
        }

        // Initiate booking
        $('body').on('change', '.payment-processor select[name=duration]', function(e) {
            let _amt = Number(form.find("input[name=amount]").val()*$(this).selected().val()).toFixed(2); 
            if (_amt>wallet) {
                $(".payment-processor").find("button[data-processor=wallet]").hide();
            } else {
                $(".payment-processor").find("button[data-processor=wallet]").show();
            }
            console.log(_amt,wallet)
        });

        $('body').on('click', '.process-payment .payment-method', function(e) { 
            var $this  = $(this);
            var processor = $this.data('processor'); 

            duration = form.find("select[name=duration] option:selected").val();  
            duration = duration ? duration : 1;  
            name     = form.find("input[name=name]").val();  
            checkin  = form.find("input[name=checkin_date]").val();  
            amount   = (Number(form.find("input[name=amount]").val())*duration).toFixed(2);

            var data     = {id: form.find("input[name=id]").val(), type: form.find("input[name=type]").val(), checkin: checkin, duration: duration, email: "<?=logged_user('email')?>"};

            $($this).buttonLoader('start'); 

            if (processor == 'paystack') {  
                $("head").jsCssLoader('https://js.paystack.co/v1/inline.js', 'js', function(e) {

                    /* Final price */ 
                    if ($.inArray("<?=my_config('site_currency')?>", [ "NGN", "GHS", "GHC" ] ) > -1) {
                        amount = amount*100;
                    }

                    var handler = PaystackPop.setup({
                        key: "<?=my_config('paystack_public')?>", // Replace with your public key
                        email: "<?=logged_user('email')?>",
                        currency: "<?=my_config('site_currency')?>",
                        amount: amount,
                        firstname: "<?=logged_user('fullname')?>",
                        lastname: "",
                        description: "Book " + name + " for " + duration + " days",
            //             // label: "Optional string that replaces customer email"
                        onClose: function() {
                            $($this).buttonLoader('stop');
                        },
                        callback: function(response) {
                            process_payment(processor + "/" + response.reference, data, $this); 
                        }
                    });
                      
                    handler.openIframe(); 
                    $(window).on('popstate', function() {
                        handler.close();
                    });
                },
                function(e) {return(typeof PaystackPop !== "undefined")});  
            }
            else if (processor == 'stripe') {   
                $("head").jsCssLoader(link('resources/plugins/stripe-elements/global.css'), 'css'); 
                $("head").jsCssLoader(
                    link('resources/plugins/stripe-elements/stripe.js'), 'js', function(e) {
                        processStripePayment(data, link('ajax/payments/stripe'), "<?=my_config('stripe_public')?>");
                        $(document).on("payment_loaded", function(e, result) { 
                            if (result.error) { 
                                $("#payment-form .payment-notification").alert_notice(result.error.message, "error", "auto");
                            } else {
                                data.data = result.paymentIntent; 
                                process_payment(processor + "/success", data);
                            }
                        });
                    },
                    function(e) {return(typeof processStripePayment !== "undefined")}
                );    
            }
            else {
                process_payment(processor, data, $this); 
            }
        }); 

    <?php if (!$request->isAJAX()):?>
    }   
    <?php endif;?>

    if (typeof verify_initiation === "undefined") {
        var process_payment = (processor, data, selector) => {  
            $.ajax({ 
                type: 'POST',
                url: link('ajax/payments/'+processor),
                data: data,  
                dataType: 'JSON',
                success: function(resps) { 
                    if (selector) {
                        $(selector).buttonLoader('stop');
                    }
                    if (resps.success) {
                        $(".modal").modal('hide');
                        show_toastr(resps.message, resps.status);
                        if (resps.redirect) {
                            setTimeout(
                                redirect(resps.redirect), 
                            1000); 
                        }
                    }
                    else
                    {
                        $(".payment-notification").alert_notice(resps.message, resps.status, false);
                    }
                },
                error: function(xhr, status, error) {
                    show_toastr(xhr.status, 'error');  
                    if (selector) {
                        $(selector).buttonLoader('stop');
                    }  
                }  
            });
        }
    
        var verify_initiation = () => {return true;}
    }
</script>