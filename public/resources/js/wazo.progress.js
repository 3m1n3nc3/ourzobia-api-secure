jQuery(document).ready(function($) { 
    programaticAppLoader();
});

function programaticAppLoader() {
    const players = Plyr.setup('.js-player');

    $('.post-option-comment').on('click', function(e) {
        var target = $($(this).data('target'));
        target.find('input[name="comment"]').focus(); 
        scrollToSel($(this).data('target'))
    });

    var write_post_comment_form = $("form.write-post-comment");
    write_post_comment_form.ajaxForm({
        url: link('connect/write_comment'),
        type: 'POST',
        dataType: 'json',
        beforeSend: function(arr,form) { 
            // form.find('input[name="comment"]').after(preloader);
        },
        success: function(data, status, xhr, form) { 
            var post_id = form.find('input[name="post_id"]').val();
            show_toastr(data.message, data.status);    
            if (data.success == true) { 
                $('#post-item-content-'+post_id).find('.post-comment:first').before(data.html); 
                form.find('input[name="comment"]').val('');
            }
        }
    });   

    if (typeof app !== 'undefined') {
        // Investment maturity progress bar
        $('.progress-wazo-bar').each(function() { 
            var quid     = $(this).attr('id');
            var progress = $(this).data('progress');
            if (progress) {
                app.plugins.createProgressBar({
                    container: '#' + quid,
                    height: 4,
                    gradient: {
                        colors: ['#615dfa', '#41efff']
                    },
                    scale: {
                        start: 0,
                        end: 100,
                        stop: progress
                    },
                    linkText: true,
                    linkUnits: '%'
                });
            } else {
                $(this).parent().remove()
            }
        });

        // User level progress bar
        app.plugins.createProgressBar({
            container: '#logged-wazo-user-level',
            height: 4,
            lineColor: '#4a46c8'
        });

        var logged_wazo_user_level = $('#logged-wazo-user-level');
        app.plugins.createProgressBar({
            container: '#logged-wazo-user-level',
            height: 4,
            lineColor: '#41efff',
            scale: {
                start: 0,
                end: 100,
                stop: logged_wazo_user_level.data('level')
            },
            linkText: true,
            linkUnits: logged_wazo_user_level.data('next'),
            invertedProgress: false
        });

        var hexagon_wazo_progress = $('.hexagon-wazo-progress-40-44');
        hexagon_wazo_progress.each(function() {
            var self     = $(this);   
            var progress = self.data('progress');  
            var identifier = '.hex_'+self.data('id');  
     
            app.plugins.createHexagon({
                container: identifier,
                width: 40,
                height: 44,
                lineWidth: 3,
                roundedCorners: true,
                roundedCornerRadius: 1,
                gradient: {
                    colors: ['#41efff', '#615dfa']
                },
                scale: {
                    start: 0,
                    end: 1,
                    stop: progress
                }
            });
        });

        app.plugins.createHexagon({
            container: '.hexagon-wazo-border-40-44',
            width: 40,
            height: 44,
            lineWidth: 3,
            roundedCorners: true,
            roundedCornerRadius: 1,
            lineColor: '#e7e8ee'
        });

        var hexagon_wazo_progress = $('.hexagon-wazo-progress-124-136');
        hexagon_wazo_progress.each(function() {
            var self     = $(this);   
            var progress = self.data('progress');  
            var identifier = '.hexa_'+self.data('id');  
      
            app.plugins.createHexagon({
                container: identifier,
                width: 124,
                height: 136,
                lineWidth: 8,
                roundedCorners: true,
                gradient: {
                    colors: ['#41efff', '#615dfa']
                },
                scale: {
                    start: 0,
                    end: 1,
                    stop: progress
                }
            });
        });

        app.plugins.createHexagon({
            container: '.hexagon-wazo-border-124-136',
            width: 124,
            height: 136,
            lineWidth: 8,
            roundedCorners: true,
            lineColor: '#e7e8ee'
        });

        var hexagon_wazo_progress_b = $('.hexagon-wazo-progress-100-110');
        hexagon_wazo_progress_b.each(function() {
            var self     = $(this);   
            var progress = self.data('progress');  
            var identifier = '.bhex_'+self.data('id'); 
            
            app.plugins.createHexagon({
                container: identifier,
                width: 100,
                height: 110,
                lineWidth: 6,
                roundedCorners: true,
                gradient: {
                    colors: ['#41efff', '#615dfa']
                },
                scale: {
                    start: 0,
                    end: 1,
                    stop: progress
                }
            });
        });

        app.plugins.createHexagon({
          container: '.hexagon-wazo-border-100-110',
          width: 100,
          height: 110,
          lineWidth: 6,
          roundedCorners: true,
          lineColor: '#e7e8ee'
        });

        var hexagon_wazo_progress_8492 = $('.hexagon-wazo-progress-84-92'); 
        hexagon_wazo_progress_8492.each(function() {
            var self     = $(this);   
            var progress = self.data('progress'); 
            var identifier = '.progress_8492_'+self.data('id');  
            
            app.plugins.createHexagon({
                container: identifier,
                width: 84,
                height: 92,
                lineWidth: 5,
                roundedCorners: true,
                roundedCornerRadius: 3,
                gradient: {
                    colors: ['#41efff', '#615dfa']
                },
                scale: {
                    start: 0,
                    end: 1,
                    stop: .8
                }
            }); 
        });

        app.plugins.createPopup({
            container: '.popup-manage-container',
            trigger: '.popup-manage-container-trigger',
            overlay: {
                color: '21, 21, 31',
                opacity: .96
            },
            animation: {
                type: 'translate-in-fade',
                speed: .3,
                translateOffset: 40
            }
        });

        app.plugins.createDropdown({
            trigger: '.widget-box-post-settings-dropdown-trigger',
            container: '.widget-box-post-settings-dropdown',
            offset: {
                top: 30,
                right: 9
            },
            animation: {
                type: 'translate-top',
                speed: .3,
                translateOffset: {
                    vertical: 20
                }
            }
        });

        app.plugins.createDropdown({
            trigger: '.reaction-item-dropdown-trigger',
            container: '.reaction-item-dropdown',
            triggerEvent: 'hover',
            offset: {
                bottom: 38,
                left: -16
            },
            animation: {
                type: 'translate-bottom',
                speed: .3,
                translateOffset: {
                    vertical: 20
                }
            }
        });

        app.plugins.createHexagon({
            container: '.hexagon-image-30-32',
            width: 30,
            height: 32,
            roundedCorners: true,
            roundedCornerRadius: 1,
            clip: true
        });
    }
}

function ourModal(state = 'hide') {
    var hidden_overlay    = "position: absolute; left: 50%; z-index: 100001; opacity: 0; visibility: hidden; transform: translate(0px, -40px); transition: transform 0.3s ease-in-out 0s, opacity 0.3s ease-in-out 0s, visibility 0.3s ease-in-out 0s; top: 0px; margin-left: -391.5px;";
    var shown_overlay     = "position: absolute; left: 50%; z-index: 100001; opacity: 1; visibility: visible; transform: translate(0px, 0px); transition: transform 0.3s ease-in-out 0s, opacity 0.3s ease-in-out 0s, visibility 0.3s ease-in-out 0s; top: 100px; margin-left: -391.5px;";
    var hidden_overlay_bg = "width: 100%; height: 100%; background-color: rgba(21, 21, 31, 0.96); position: fixed; top: 0px; left: 0px; z-index: 100000; opacity: 0; visibility: hidden; transition: opacity 0.3s ease-in-out 0s, visibility 0.3s ease-in-out 0s;";
    var shown_overlay_bg  = "width: 100%; height: 100%; background-color: rgba(21, 21, 31, 0.96); position: fixed; top: 0px; left: 0px; z-index: 100000; opacity: 1; visibility: visible; transition: opacity 0.3s ease-in-out 0s, visibility 0.3s ease-in-out 0s;";

    if (state === 'show') {
        document.getElementsByClassName("popup-manage-container")[0].setAttribute("style", shown_overlay);
        document.getElementById("xm-overlay-bg").setAttribute("style", shown_overlay_bg);
    } else {
        document.getElementsByClassName("popup-manage-container")[0].setAttribute("style", hidden_overlay);
        document.getElementById("xm-overlay-bg").setAttribute("style", hidden_overlay_bg);
    } 
}

function scrollToSel(target, offset) { 
    // Scroll
    $('html,body').animate({
        scrollTop: $(target).offset().top - (offset ? offset : 300)
    }, 'slow');
}