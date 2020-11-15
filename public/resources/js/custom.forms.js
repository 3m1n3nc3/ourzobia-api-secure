jQuery(document).ready(function($) {    
    
    var bank_info_form = $('form.bank_info_form'); 
    bank_info_form.ajaxForm({
        url: link('ajax/main/save_bank_info'),
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
        url: link('ajax/main/save_account_info'),
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
        url: link('ajax/main/token_management'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) { 
            token_management.find('button[type=submit]').buttonLoader('start');
        },
        success: function(data, status, xhr, form) { 
            show_toastr(data.message, data.status);      
            token_management.find('button[type=submit]').buttonLoader('stop');
            var message = $("</div>").text(data.message);
            token_management.find('.form_message').alert_notice(data.message, data.status, true); 
            if (data.redirect) {
                redirect(data.redirect);
            }
        }, 
        error: handleError
    });

    var manage_user_form = $('form.manage_user_form'); 
    manage_user_form.ajaxForm({
        url: link('ajax/main/save_account_managed_changes'),
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
        url: link('ajax/main/change_password'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) {
            password_form.find('button[type=submit]').buttonLoader('start'); 
        },
        success: function(data, status, xhr, form) {  
            show_toastr(data.message, data.status); 
            password_form.find('button[type=submit]').buttonLoader('stop'); 
            if (data.redirect) {
                redirect(data.redirect);
            }
        }
    });

    $("form.marketing-form").each(function(e) {
        var marketing_form = $(this);
        marketing_form.ajaxForm({
            url: link('ajax/main/marketing_form'),
            type: 'POST',
            dataType: 'json',
            beforeSend: function(arr,form) {
                marketing_form.find('.sub_btn').buttonLoader('start');  
            },
            success: function(data, status, xhr, form) {
                marketing_form.find(".message").alert_notice(data.message, data.status, true); 
                marketing_form.find('.sub_btn').buttonLoader('stop');   
            }
        }); 
    });
});  
