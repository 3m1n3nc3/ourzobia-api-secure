
jQuery(document).ready(function($) {
    refreshDom();
    //setup ajax error handling
    if (CI_ENVIRONMENT !== 'production') {
        $.ajaxSetup({
            error: function (data, status, error) { 
                var msg    = (typeof data.responseJSON !== 'undefined' && data.responseJSON.message)?data.responseJSON.message:data.statusText?data.statusText:"An Error Occurred";
                var line   = (typeof data.responseJSON !== 'undefined' && data.responseJSON.line)?" line: " +data.responseJSON.line:"";
                var file   = (typeof data.responseJSON !== 'undefined' && data.responseJSON.file)?"<br/>file: " + data.responseJSON.file + line:"";
                if (typeof data.responseJSON === 'undefined') {
                    msg += '<div>'+data.responseText+'</div>';
                }
                var status = (typeof data.responseJSON !== 'undefined' && data.responseJSON.code) ? data.responseJSON.code : data.status; 
                if (status == 401) {
                    show_toastr(msg, 'error');  
                    setTimeout(function() {
                        window.location.href = link('login');
                    }, 400)  
                } else { 
                    var log = "Error Code: " + status + "<br>Error: " + msg + file; 
                    $(this).terminal(log); 
                    $('#console').show();
                }
            }
        });
    }

    const players = Plyr.setup('.js-player');

    var sel = $('select#bank_code').children("option:selected"); 
    $('#account_type').val(sel.data('type'));
    
    $('.timeago').each(function() {
        $(this).livestamp($(this).data('timeago'));
    });  

    $("input[data-bootstrap-switch]").each(function(){
        $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    // Show the create post modal and create a new post
    $('body').on('click','.upload-media', function(e) { 
        uploadMedia(this);
    });
 
    $('.allowCopy').click(function() 
    {
        var element = $($(this).data('content')); 
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(element.text()).select(); 
        if (document.execCommand('copy'))
        { 
            $temp.remove()
            show_toastr('Content has been copied to clipboard', 'success');   
        }
    }); 

    $('button[type="submit"]').click(function() {
        $(this).addClass('btn-spinner btn-spinner-example');
    });
 
    $('body').on('click','button.cancel, a.cancel, .delete.cancel', function(e) {
        var target = typeof $(this).data('target') !== 'undefined' ? $(this).data('target') : null;
        cancel_(this, target);
    });

    $('button.disabled').click(function(e) {
        e.preventDefault();
        var msg = $(this).data('msg');
        show_toastr(msg ? msg : null, 'error');
    });

    // jQuery UI sortable for the todo list 
    $('.todo-list').sortable({
        placeholder          : 'sort-highlight',
        handle               : '.handle',
        forcePlaceholderSize : true,
        zIndex               : 999999,
        update: function (event, ui) {
            var sort_order = $(this).sortable('serialize');
            $.ajax({
                async: true,
                type: 'POST',
                url: link('connect/sortable'),
                data: sort_order,  
                dataType: 'JSON',
                success: function(resps) { 
                    console.log(resps);
                },
                error: function(xhr, status, error) { 
                    error_message(xhr, status, error, '#sort_message');
                }  
            })
        }
    });

    /**
     * fetch the image upload modal content and attach to the modal body
     * @param  {String} ){                                 var m_id [id or class of a container to append content]
     * @param  {[type]} error: function(xhr, status, error) {
     *                             error_message(xhr, status, error, m_id);        
     * }      })} [if there is an error on the page run the error function]
     * @return {[type]}        [null]
     */
    $('.upload_resize_image').click(function() {

        var m_id        = '.modal-content';
        var modal       = $('.modal'+$(this).data('target'));
        var endpoint_id = $(this).data('endpoint_id');
        var endpoint    = $(this).data('endpoint');
        var type        = $(this).data('type'); 
        var set_elid    = $(this).prev('div').attr('id'); 
        var self        = $(this);

        modal.attr('style', 'z-index:999999;').modal('show');
        var spinner = modal.find('.loader').clone().show().attr('id', 'remove_loader');
        modal.find('.modal-content').append(spinner); 
        $('#remove_loader').remove(); 
     
        $.ajax({
            async: true,
            type: 'POST',
            url: link('ajax/main/upload_image'),
            data: {endpoint_id:endpoint_id, endpoint:endpoint, type:type},  
            dataType: 'JSON',
            success: function(resps) { 
                $.getScript(base_link("resources/plugins/image-uploader/upload-handler.js?time="+Math.floor(Math.random() * 10000) + 50000));
                modal.find('.modal-content').html(resps.content);
                $('#button_identifiers').val(set_elid); 
            },
            error: function(xhr, status, error) {
                error_message(xhr, status, error, m_id);
            }  
        });
    }); 

    // Load the payment modal
    $('body').on('click', '.booking-btn', function(e) { 
        if (!is_logged()) {
            redirect('login?redirect=user%2Fhubs%2Fdetail%2F' + $(this).data('id'));
            return false;
        }
        var modal_selector = (typeof $(this).data('modal') !== 'undefined') ? $(this).data('modal') : '.modal#uploadModal';
        var modal     = $(modal_selector);
        if (modal.hasClass('custom')) { 
            var content = modal.find('.modal-content').removeClass('stripe');
        } else {
            var content = modal.find('.modal-body').attr('style', 'padding:0rem;').removeClass('stripe');
        } 

        // ourModal('show'); 
        content.html(preloader); 

        modal.attr('style', 'z-index:9000;').modal('show');
        modal.find('.modal-dialog').addClass('modal-lg').removeClass('modal-md').removeClass('modal-dialog-scrollable'); 

        var data = {id: $(this).data('id'), type: $(this).data('type'), amount: $(this).data('price'), name: $(this).data('name')};

        $.get(link('ajax/main/just_load_modal/payment_processor'), data, function(data) {
            content.html(data.html);
            if (typeof data.body.html !== "undefined") {
                $("body " + data.body.id).remove();
                $("body").append(data.body.html);
            }
            $(".xdsoft_").remove();
            $('.datetimepick').datetimepicker({
                format:'Y-m-d H:i:s',
                mask:true
            });
        });
    });
}); 

function modalImageViewer(identifier) {  

    var varid = Math.floor(Math.random() * 5);

    if (typeof identifier == 'object') {
        var image_src = identifier.data('src');

        if (typeof identifier.data('thumb') !== 'undefined') {
            var video = '<video class="js-player" id="player-'+varid+'" playsinline controls data-poster="'+identifier.data('thumb')+'" style="max-height:70vh;">'+
                    '<source src="'+image_src+'" type="video/mp4" />'+
                    '<source src="'+image_src+'" type="video/webm" />'+
                '</video>';
        }
    } else {
        var image_src = $('img' + identifier).attr('src'); 
    }
    if (typeof identifier !== 'object' && typeof image_src == 'undefined') {
        var image_src = $(identifier).data('src'); 
    }
    var image = '<img class="img-fluid border-gray" src="'+image_src+'" style="max-height:70vh;" alt="View Image">';

    $('#actionModal').attr('style', 'z-index:999999;').modal('show').find('.modal-body').html($("<div>",{
        class:'border rounded text-center',
        html: video ? video : image
    }));

    $('#actionModal').find('.modal-dialog').removeClass('modal-sm').removeClass('modal-md'); 
    $('#actionModal').find('.modal-title').text('Image Viewer'); 
}

function cancel_(self, selector = '') {
    var id   = $(self).data('id');
    var uuid = $(self).data('uid') ? $(self).data('uid') : null; 
    var type = $(self).data('type');
    var extra = $(self).data('extra') ? $(self).data('extra') : null; 
    var data  = {id:id, uid:uuid, type:type, data:extra}; 
    $(self).buttonLoader('start'); 
    $.post(link('ajax/main/cancel'), data, function(data, textStatus, xhr) {
        show_toastr(data.message, data.status);    
        if (data.success == true) {  
            if (selector) {
                $(selector).slideUp(); 
            } else {
                $('#'+type+id).slideUp(); 
            }
        } 
        if (extra !== null && typeof extra.modal !== 'undefined') {
            $(extra.modal).modal('hide');
        }
        $(self).buttonLoader('stop'); 
    });
} 

function refreshDom() {   

    console.log('DOM Refreshed...');
}
 
function error_message(xhr, status, error, mid) {
    var errorMessage = 'An Error Occurred - ' + xhr.status + ': ' + xhr.statusText + '<br> ' + error;  
    show_toastr(errorMessage+'</br>'+xhr.responseText, 'error');   
    
    $(mid).after( 
        '<div class="card m-2 text-center">'+
            '<div class="card-header p-2">Server Response: </div>'+
            '<div class="card-body p-2 text-info">'+
                '<div class="card-text font-weight-bold text-danger">'+errorMessage+'</div>'
                +xhr.responseText+
            '</div>'+
        '</div>'
    );
}
 
function handleError(xhr, status, error, mid) { 
    show_toastr(xhr.responseJSON.message, xhr.responseJSON.status);
    $('body').find('button[type=submit]').buttonLoader('stop');
    if (mid) {
        $(mid).after();
    }
} 

function confirmAction(data, inline, action, message) { 
    action  = action ? action : 'delete';
    var btn = (action === 'delete' || action === 'cancel') ? 'danger' : 'success';
    var button_ajax   = '<a href="javascript:void(0)" class="p-0 mx-1 text-white btn btn-md btn-block btn-'+btn+'" data-'+action+'="true" onclick="'+data+'" id="'+action+'_confirm"> YES '+action.toUpperCase()+' </a>';
    var button_inline = '<a href="'+data+'" class="p-0 mx-1 text-white btn btn-md btn-block btn-'+btn+'" data-'+action+'="true" id="'+action+'_confirm"> YES '+action.toUpperCase()+' </a>';
    

    if (data === 'submit') {
        var button_list = 
        '<div class="font-weight-bold">'+
            '<button type="submit" class="confirm_submit p-0 mx-1 text-white btn btn-md btn-block btn-'+btn+'">'+action.toUpperCase()+'</button>'+
            '<button type="button" class="p-0 mx-1 text-white btn btn-md btn-block btn-info" data-dismiss="modal">No</button>'+
        '</div>';
    } else {
        var button_list = 
        '<div class="font-weight-bold">'+ (inline ? button_inline : button_ajax) +
            '<button type="button" class="p-0 mx-1 text-white btn btn-md btn-block btn-info" data-dismiss="modal">No</button>'+
        '</div>';
    } 

    $('#actionModal .modal-body').html('<p>'+(message ? message : 'Are you sure you want to '+action+' this item?')+'</p>');
    $('#actionModal .modal-body').append(button_list);
    $('#actionModal .modal-title').html('Confirmation');
    $("#actionModal").modal('show'); 

    $(".confirm_submit").click(function(e) {
        var form = $("form"+inline);
        if (typeof form !== 'undefined') {
            form.submit();
        }
    });
}

function safeLinker(e) { 
    var title = $.trim($(e).val()); 
    title = title.replace(/[^a-zA-Z0-9-]+/g, '-');

    var safelink = 'input[name="safelink"]';
    $(safelink).val(title.toLowerCase());
}

$('#actionModal').on('hide.bs.modal', function(e) { 
    $('#actionModal .modal-body, #actionModal .modal-title').html('');
    $('#actionModal .modal-body').html('<div class="loader"><div class="spinner-grow text-warning"></div></div>');
})

function site_settings(key, value, related) {
    return $.post(link('ajax/main/site_settings'), {setting_key:key, setting_value:value, related:1}, function (data) {
        show_toastr(data.message, data.status);
    });
}

function scrollToSel(target, offset) { 
    // Scroll
    $('html,body').animate({
        scrollTop: $(target).offset().top - (offset ? offset : 300)
    }, 'slow');
}

function show_toastr(message = 'A network error occurred!', type = 'warning') {
    var title = ucwords(type);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "600",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    if (type == 'success') {toastr.success(message, title)} 
    if (type == 'info') {toastr.info(message, title)} 
    if (type == 'error') {toastr.error(message, title)} 
    if (type == 'warning') {toastr.warning(message, title)} 
}
 
var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

function redirect(path) {
    if (typeof path !== "undefined") { 
        if (path.indexOf("http")>-1)
            window.location.href = path;
        else
            window.location.href = link(path);
    } else {
        path = (typeof path !== "undefined") ? path : '';
        window.location.href = link(path);
    }
}

function _toggleFullScreen(recover) {
    $(window).height();
    document.fullscreenElement||
    document.mozFullScreenElement||
    document.webkitFullscreenElement?
    document.cancelFullScreen?
    document.cancelFullScreen():
    document.mozCancelFullScreen?
    document.mozCancelFullScreen():
    document.webkitCancelFullScreen&&document.webkitCancelFullScreen():
    document.documentElement.requestFullscreen?
    document.documentElement.requestFullscreen():
    document.documentElement.mozRequestFullScreen?
    document.documentElement.mozRequestFullScreen():
    document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);

    var state = ' on';
    if (recover !== true && $(".full-screen").hasClass("on")) {
        var state = '';
    }
    // site_settings('des_fullscreen', state);

    $(".full-screen").toggleClass("on");
    $(".full-screen > i").toggleClass("icon-maximize on");
    $(".full-screen > i").toggleClass("icon-minimize");
}

function get_notifications(segment, theme, data_segment = ''){
    if (!is_logged()) {
        redirect('login');
        return false;
    }
    var notfi_set = $("div#notifications__list, ul#notifications__list");
    var newnotif  = $("#new__notif");
    $.ajax({
        url: link('connect/fetch_notifications'+(segment?'/'+segment:'')+(data_segment?'/'+data_segment:'')+(theme?'/'+theme:'')),
        type: 'GET',
        dataType: 'json'
    })
    .done(function(data) { 
        if (segment === 'user') {
            if (theme === 'vikinger') {
                $.getScript(base_link("resources/theme/vikinger/js/global/global.hexagons.js?time="+Math.floor(Math.random() * 10000) + 50000));
            }
            $.getScript(base_link("resources/js/wazo.progress.js?time="+Math.floor(Math.random() * 10000) + 50000));
        }
        if (data.success === true) {
            newnotif.text('');
            notfi_set.html(data.html);
            $("#notification_bell").removeClass('text-danger');
            $('.scroll-notifications').overlayScrollbars({ });
        }

        else if(data.success === false){
            var cont = $('<div>').append($('<span>',{
                text:data.message
            }));

            notfi_set.html($("<div>",{
                class:'no__notifications',
                html: cont.prepend('<svg xmlns="http://www.w3.org/2000/svg" class="confetti" viewBox="0 0 1081 601"><path class="st0" d="M711.8 91.5c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7C695.2 84 702.7 91.5 711.8 91.5zM711.8 64.1c5.9 0 10.7 4.8 10.7 10.7s-4.8 10.7-10.7 10.7 -10.7-4.8-10.7-10.7S705.9 64.1 711.8 64.1z"/><path class="st0" d="M74.5 108.3c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7C57.9 100.9 65.3 108.3 74.5 108.3zM74.5 81c5.9 0 10.7 4.8 10.7 10.7 0 5.9-4.8 10.7-10.7 10.7s-10.7-4.8-10.7-10.7S68.6 81 74.5 81z"/><path class="st1" d="M303 146.1c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7C286.4 138.6 293.8 146.1 303 146.1zM303 118.7c5.9 0 10.7 4.8 10.7 10.7 0 5.9-4.8 10.7-10.7 10.7s-10.7-4.8-10.7-10.7C292.3 123.5 297.1 118.7 303 118.7z"/><path class="st2" d="M243.4 347.4c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7S234.2 347.4 243.4 347.4zM243.4 320c5.9 0 10.7 4.8 10.7 10.7 0 5.9-4.8 10.7-10.7 10.7s-10.7-4.8-10.7-10.7S237.5 320 243.4 320z"/><path class="st1" d="M809.8 542.3c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7C793.2 534.8 800.7 542.3 809.8 542.3zM809.8 514.9c5.9 0 10.7 4.8 10.7 10.7s-4.8 10.7-10.7 10.7 -10.7-4.8-10.7-10.7S803.9 514.9 809.8 514.9z"/><path class="st3" d="M1060.5 548.3c9.2 0 16.7-7.5 16.7-16.7s-7.5-16.7-16.7-16.7 -16.7 7.5-16.7 16.7C1043.9 540.8 1051.4 548.3 1060.5 548.3zM1060.5 520.9c5.9 0 10.7 4.8 10.7 10.7s-4.8 10.7-10.7 10.7 -10.7-4.8-10.7-10.7S1054.6 520.9 1060.5 520.9z"/><path class="st3" d="M387.9 25.2l7.4-7.4c1.1-1.1 1.1-3 0-4.1s-3-1.1-4.1 0l-7.4 7.4 -7.4-7.4c-1.1-1.1-3-1.1-4.1 0s-1.1 3 0 4.1l7.4 7.4 -7.4 7.4c-1.1 1.1-1.1 3 0 4.1s3 1.1 4.1 0l7.4-7.4 7.4 7.4c1.1 1.1 3 1.1 4.1 0s1.1-3 0-4.1L387.9 25.2z"/><path class="st3" d="M368.3 498.6l7.4-7.4c1.1-1.1 1.1-3 0-4.1s-3-1.1-4.1 0l-7.4 7.4 -7.4-7.4c-1.1-1.1-3-1.1-4.1 0s-1.1 3 0 4.1l7.4 7.4 -7.4 7.4c-1.1 1.1-1.1 3 0 4.1s3 1.1 4.1 0l7.4-7.4 7.4 7.4c1.1 1.1 3 1.1 4.1 0s1.1-3 0-4.1L368.3 498.6z"/><path class="st3" d="M16.4 270.2l7.4-7.4c1.1-1.1 1.1-3 0-4.1s-3-1.1-4.1 0l-7.4 7.4 -7.4-7.4c-1.1-1.1-3-1.1-4.1 0s-1.1 3 0 4.1l7.4 7.4 -7.4 7.4c-1.1 1.1-1.1 3 0 4.1s3 1.1 4.1 0l7.4-7.4 7.4 7.4c1.1 1.1 3 1.1 4.1 0s1.1-3 0-4.1L16.4 270.2z"/><path class="st2" d="M824.7 351.1l7.4-7.4c1.1-1.1 1.1-3 0-4.1s-3-1.1-4.1 0l-7.4 7.4 -7.4-7.4c-1.1-1.1-3-1.1-4.1 0s-1.1 3 0 4.1l7.4 7.4 -7.4 7.4c-1.1 1.1-1.1 3 0 4.1s3 1.1 4.1 0l7.4-7.4 7.4 7.4c1.1 1.1 3 1.1 4.1 0s1.1-3 0-4.1L824.7 351.1z"/><path class="st1" d="M146.3 573.6H138v-8.3c0-1.3-1-2.3-2.3-2.3s-2.3 1-2.3 2.3v8.3h-8.3c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3h8.3v8.3c0 1.3 1 2.3 2.3 2.3s2.3-1 2.3-2.3v-8.3h8.3c1.3 0 2.3-1 2.3-2.3S147.6 573.6 146.3 573.6z"/><path class="st1" d="M1005.6 76.3h-8.3V68c0-1.3-1-2.3-2.3-2.3s-2.3 1-2.3 2.3v8.3h-8.3c-1.3 0-2.3 1-2.3 2.3s1 2.3 2.3 2.3h8.3v8.3c0 1.3 1 2.3 2.3 2.3s2.3-1 2.3-2.3v-8.3h8.3c1.3 0 2.3-1 2.3-2.3S1006.8 76.3 1005.6 76.3z"/><path class="st1" d="M95.5 251.6c-3.5 0-6.3 2.8-6.3 6.3 0 3.5 2.8 6.3 6.3 6.3s6.3-2.8 6.3-6.3S99 251.6 95.5 251.6z"/><path class="st0" d="M1032 281.8c-3.5 0-6.3 2.8-6.3 6.3s2.8 6.3 6.3 6.3 6.3-2.8 6.3-6.3S1035.5 281.8 1032 281.8z"/><path class="st2" d="M741.6 139.3c-3.5 0-6.3 2.8-6.3 6.3s2.8 6.3 6.3 6.3 6.3-2.8 6.3-6.3S745 139.3 741.6 139.3z"/><path class="st3" d="M890.7 43.5c3.3 0 6-2.7 6-6s-2.7-6-6-6 -6 2.7-6 6C884.8 40.8 887.4 43.5 890.7 43.5z"/><path class="st0" d="M164.3 537.6c3.3 0 6-2.7 6-6s-2.7-6-6-6 -6 2.7-6 6C158.4 535 161 537.6 164.3 537.6z"/></svg><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell-off"><path d="M8.56 2.9A7 7 0 0 1 19 9v4m-2 4H2a3 3 0 0 0 3-3V9a7 7 0 0 1 .78-3.22M13.73 21a2 2 0 0 1-3.46 0"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>')
            }));
        }
    });
}

function update_notices(segment){
    var app_page = $("body").data('page');
    var features = {
        'notifications':1,
        'new_messages':1, 
        'chats':0
    };

    if (app_page == 'messages') {
        features['chats'] = 1;
    }

    $.ajax({
        url: link('connect/update_notices'+(segment?'/'+segment:'')),
        type: 'GET',
        dataType: 'json',
        data: features,
    })
    .done(function(data) {
        if (data.notif && $.isNumeric(data.notif)) {
            var newnotif = $("#new__notif");
            newnotif.text(data.notif);
            $("#notification_bell").addClass('text-danger');
            $(".action-list-item#get-notifications").addClass('unread');
        } 

        if (data.new_messages && $.isNumeric(data.new_messages)) {
            var new_messages = $("#new__messages");
            var new_messages_sec = $("#new__messages_sec");
            new_messages.text(data.new_messages);
            new_messages_sec.text(data.new_messages);
        }
    });

    setTimeout(function(){
        update_notices(segment);
    },(1000 * 10))
}

function uploadMedia(target) { 

    var modal_selector = (typeof $(target).data('modal') !== 'undefined') ? $(target).data('modal') : '.modal#uploadModal';
    var modal     = $(modal_selector);
    if (modal.hasClass('custom')) { 
        var content = modal.find('.modal-content');
    } else {
        var content = modal.find('.modal-body').attr('style', 'padding:0rem;');
    }
    const creator = $(target); 
    var post_type = $(target).data('type'); 
    var edit_id   = $(target).data('id'); 
    var query     = ''; 

    // ourModal('show'); 
    content.html(preloader);
    creator.toggleClass('active');
    creator.siblings().removeClass('active');   

    modal.attr('style', 'z-index:999999;').modal('show'); 
    modal.find('.modal-dialog').addClass('modal-lg').removeClass('modal-md'); 
 
    $.ajax({
        url: link('ajax/main/upload_media_modal/'+segment),
        type: 'GET',
        dataType: 'json',
        type: 'POST',
        data : {type:post_type}
    })
    .done(function(data) {
        $('#preloader').remove(); 
        content.html(data.html);
        // scrollToSel('.popup-box-content');
        // $('#poster_title_id').html(creator.clone().removeAttr('.create-post'));
        if (typeof edit_id !== 'undefined') {
            $('#poster_title_id').html('<div class="option-item active create-post"><p class="option-item-title">Edit Post</p></div>');
            content.find('textarea[name=description]').val($('p#item-description-' + edit_id).text());
        } else {
            $('#poster_title_id').html(creator.clone().removeAttr('.create-post'));
        }

        content.find('textarea[name=description]').focus();  

        if (post_type == 'video' || post_type == 'image' || post_type == 'gallery') {
            Dropzone.autoDiscover = false;
            var myDropzone = new Dropzone("div.dropzone", {
                url: link('connect/upload_media'),
                autoProcessQueue: false,
                uploadMultiple: false,
                parallelUploads: 1,
                maxFiles: 1,
                maxFilesize: 35,
                acceptedFiles: "video/*,image/*",
                init: function() {
                    var myDropzone = this; 
                    document.querySelector("button.submit_btn").addEventListener("click", function(e) { 
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue(); 
                    });    
                    this.on("success", function(files, response) { 
                        content.find('button[type=submit]').buttonLoader('stop'); 
                        show_toastr(response.message, response.status);
                        modal.modal('hide'); 
                        $(".uploaded_item:last").after(response.html);  
                    });   
                    this.on("error", function(files, error) { 
                        show_toastr(error, 'error'); 
                    }); 

                    this.on("sending", function(data, xhr, form) {
                        content.find('button[type=submit]').buttonLoader('start'); 
                        var file_type = data.type;
                        if (post_type == 'video' || file_type.indexOf('video') !=-1) {
                            form.append('thumbnail', $(data.previewElement).find('div.dz-image img').attr('src'));
                        }  
                        if (typeof edit_id !== 'undefined') {
                            form.append('item_id', edit_id);
                        }
                        form.append('title', content.find('input[name=title]').val());
                        form.append('featured', content.find('select[name=featured]').val());
                        form.append('category', content.find('input[name=category]').val());
                        form.append('description', content.find('textarea[name=description]').val());
                        form.append('type', file_type); 
                    });    

                    this.on("addedfile", function(file) {
                        var removeButton = Dropzone.createElement("<button class=\"btn mt-1 btn-danger\">Remove file</button>");
                        var _this = this;
                        removeButton.addEventListener("click", function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            _this.removeFile(file);
                        });
                        file.previewElement.appendChild(removeButton);
                    });
                } 
            });

            myDropzone.on("addedfile", function(file) {
                loadMediaThumb(file);
            });
        } else {
            var post_update_form = $('.create-post-update');
            if (typeof edit_id !== 'undefined') {
                var query = {post_id:edit_id};
            }
            post_update_form.ajaxForm({
                url: link('connect/create_post'),
                type: 'POST',
                dataType: 'json',
                data: query,
                beforeSend: function(arr,form) {
                    post_update_form.find('button[type=submit]').buttonLoader('start'); 
                },
                success: function(data, status, xhr, form) { 
                    show_toastr(data.message, data.status);
                    post_update_form.find('button[type=submit]').buttonLoader('stop'); 
                    modal.modal('hide'); 
                    if (typeof edit_id !== 'undefined') {
                        $(".post-item-content#post-item-content-" + edit_id).before(data.html); 
                        $(".post-item-content#post-item-content-" + edit_id).last().remove(); 
                    } else {
                        $(".post-item-content:first").before(data.html); 
                    }
                    programaticAppLoader();
                }, 
                error: handleError
            });
        }
        refreshDom();
    });  
}

function loadMediaThumb(file) {
    if (typeof file !== 'undefined') { 
        var fileReader = new FileReader();
        if (file.type.match('image')) {
            fileReader.onload = function() {
                var img = document.createElement('img');
                img.src = fileReader.result;
                document.getElementsByClassName('dz-image')[0].appendChild(img);
            };
            fileReader.readAsDataURL(file);
        } else {
            fileReader.onload = function() {
            var blob = new Blob([fileReader.result], {type: file.type});
            var url = URL.createObjectURL(blob);
            var video = document.createElement('video');
            var timeupdate = function() {
            if (snapImage()) {
                video.removeEventListener('timeupdate', timeupdate);
                video.pause();
            }
          };
          video.addEventListener('loadeddata', function() {
                if (snapImage()) {
                    video.removeEventListener('timeupdate', timeupdate);
                }
            });
            var snapImage = function() {
                var canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                var image = canvas.toDataURL();
                var success = image.length > 100000;
                if (success) {
                    var img = document.createElement('img');
                    img.src = image;
                    img.setAttribute('data-dz-thumbnail', '');
                    img.setAttribute('width', '120');
                    img.setAttribute('height', '120');
                    img.alt = file.name;
                    document.querySelector('.dz-image img').remove();
                    document.getElementsByClassName('dz-image')[0].appendChild(img);
                    URL.revokeObjectURL(url);
                }
                return success;
            };
            video.addEventListener('timeupdate', timeupdate);
            video.preload = 'metadata';
            video.src = url;
            // Load video in Safari / IE11
            video.muted = true;
            video.playsInline = true;
            video.play();
        };
        fileReader.readAsArrayBuffer(file);
      }
    }
}