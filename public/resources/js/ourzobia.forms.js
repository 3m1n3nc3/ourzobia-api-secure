jQuery(document).ready(function($) {
    $('#invest_btn').click(function() {
        $('#invest_form').slideToggle();
    });  

    $('#amount').keyup(function() {
        var profit = (($('#amount').val() - ( ($('#amount').val() * 50 / 100 )).toFixed(2)));
        $('#profit_display').html(number_format(Number(profit)));
        $('#receive_display').html(number_format(Number($('#amount').val())+profit));
    }); 

    var investment_form = $('form.investment_form');
    investment_form.each(function() { 
        var btn = $(this).data('investment-form'); 
        $(this).ajaxForm({
            url: link('ajax/invest'),
            type: 'POST',
            dataType: 'json',
            beforeSend: function(arr,form) {
                $('button#inv_'+btn).buttonLoader('start'); 
                $('button').not('#inv_'+btn).attr('disabled', true); 
            },
            success: function(data, status, xhr, form) {
                show_toastr(data.message, data.status); 
                if (data.rm_btns == 'all') {
                    investment_form.find('button[type="submit"]').remove();
                    investment_form.find('.form-input').remove();
                }
                $('button#inv_'+btn).buttonLoader('stop');  
                $('button').not('#inv_'+btn).removeAttr('disabled'); 
                if (data.redirect) {
                    redirect(data.redirect);
                }
            }
        });
    }); 

    var cashout_form = $('form.cashout_form'); 
    cashout_form.each(function() {
        var form_id = $(this).data('cashout-form'); 
        $(this).ajaxForm({
            url: link('ajax/cashout'),
            type: 'POST',
            dataType: 'json',
            beforeSend: function(arr,form) {  
                $('button#co_'+form_id).buttonLoader('start'); 
                $('button').not('#co_'+form_id).attr('disabled', true);  
            },
            success: function(data, status, xhr, form) {  
                show_toastr(data.message, data.status);   
                $('button#co_'+form_id).buttonLoader('stop');
                $('button').not('#co_'+form_id).removeAttr('disabled'); 
                if (data.success == true) {
                    $('#cashout_form'+$(form).data('cashout-form')).slideUp();
                    if (data.redirect) {
                        redirect(data.redirect);
                    }
                }
            }
        });
    });

    var confirm_form = $('form.confirm_form'); 
    confirm_form.each(function() {
        var form_id = $(this).data('confirm-form'); console.log(('#confirm_form'+form_id), confirm_form, form_id)
        $(this).ajaxForm({
            url: link('ajax/confirm'),
            type: 'POST',
            dataType: 'json',
            beforeSend: function(arr,form) {  
                $('button#cf_'+form_id).buttonLoader('start'); 
                $('button').not('#cf_'+form_id).attr('disabled', true);  
            },
            success: function(data, status, xhr, form) {   
                show_toastr(data.message, data.status);    
                $('button#cf_'+form_id).buttonLoader('stop');
                $('button').not('#cf_'+form_id).removeAttr('disabled'); 
                if (data.success == true) {
                    $('#confirm_form'+form_id).slideUp();
                    if (data.redirect) {
                        redirect(data.redirect);
                    }
                }
            }
        });
    });

    var report_form = $('form.report_form'); 
    report_form.each(function() {
        var form_id = $(this).data('report-form'); 
        $(this).ajaxForm({
            url: link('ajax/report'),
            type: 'POST',
            dataType: 'json',
            beforeSend: function(arr,form) {  
                $('button#rf_'+form_id).buttonLoader('start'); 
                $('button').not('#rf_'+form_id).attr('disabled', true);  
            },
            success: function(data, status, xhr, form) {   
                show_toastr(data.message, data.status);    
                if (data.success == true) { 
                    $('button').not('#rf_'+form_id).removeAttr('disabled');  
                    $('button#rf_'+form_id).buttonLoader('stop'); 
                    $('button#rf_'+form_id).text('Reported...').attr('disabled', true); 
                    if (data.redirect) {
                        redirect(data.redirect);
                    }
                }
            }
        });
    });
    
    var bank_info_form = $('form.bank_info_form'); 
    bank_info_form.ajaxForm({
        url: link('ajax/save_bank_info'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) {
            bank_info_form.find('button[type=submit]').buttonLoader('start'); 
        },
        success: function(data, status, xhr, form) { 
            show_toastr(data.message, data.status);
            bank_info_form.find('button[type=submit]').buttonLoader('stop');
            
            if (data.success) {
                if (data.html) {
                    $('#account-grid').before(data.html);
                    scrollToSel('#after-bank-message', 200);
                }
                bank_info_form.find('button[type=submit]').hide();
                bank_info_form.find('#account_number, select#bank_code').attr('readonly', true);
                if (data.redirect) {
                    redirect(data.redirect);
                }
            }
        }
    });

    var account_info_form = $('form.account_info_form'); 
    account_info_form.ajaxForm({
        url: link('ajax/save_account_info'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) { 
            account_info_form.find('button[type=submit]').buttonLoader('start');
        },
        success: function(data, status, xhr, form) { 
            show_toastr(data.message, data.status);      
            account_info_form.find('button[type=submit]').buttonLoader('stop');
            if (data.redirect) {
                redirect(data.redirect);
            }
        }
    });

    var token_management = $('form.token_management'); 
    token_management.ajaxForm({
        url: link('ajax/token_management'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) { 
            token_management.find('button[type=submit]').buttonLoader('start');
        },
        success: function(data, status, xhr, form) { 
            show_toastr(data.message, data.status);      
            token_management.find('button[type=submit]').buttonLoader('stop');
            var message = $("</div>").text(data.message);
            token_management.find('.form_message').html(data.message).addClass('alert mb-3 alert-' + (data.status == 'error' ? 'danger' : data.status)).fadeIn();
            if (data.redirect) {
                redirect(data.redirect);
            }
        }, 
        error: handleError
    });

    var manage_user_form = $('form.manage_user_form'); 
    manage_user_form.ajaxForm({
        url: link('ajax/save_account_managed_changes'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) { 
            manage_user_form.find('button[type=submit]').buttonLoader('start');
        },
        success: function(data, status, xhr, form) { 
            show_toastr(data.message, data.status);      
            manage_user_form.find('button[type=submit]').buttonLoader('stop');
            if (data.redirect) {
                redirect(data.redirect);
            }
        }
    });

    var password_form = $('form.password_form'); 
    password_form.ajaxForm({
        url: link('ajax/change_password'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) {
            password_form.find('button[type=submit]').buttonLoader('start'); 
        },
        success: function(data, status, xhr, form) {  
            show_toastr(data.message, data.status);
            // password_form.find('div.form_message').html($("<div>",{
            //     class:'alert alert-'+(data.success == true ? 'success' : 'danger')+' alert-dismissible',
            //     html: "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><i class='fa fa-check'></i> "+data.message+""
            // }));    

            password_form.find('button[type=submit]').buttonLoader('stop'); 
            if (data.redirect) {
                redirect(data.redirect);
            }
        }
    });
});  
