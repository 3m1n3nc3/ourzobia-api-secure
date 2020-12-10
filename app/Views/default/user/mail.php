<div class="row">
    <div class="col-md-3">
    <?=load_widget('mail/sidebar')?>
    </div>
 
    <div class="col-md-9">
    <?=load_widget("mail/$widget")?>
    </div> 
</div> 

<script> 
    function mail_loader(selector) {
        var $this   = $(selector);
        var $target = $(selector);
        var page    = '';
        if (typeof $this.data('page') !== 'undefined') {
            $this = $('.pagination-data');
            page  = $target.data('page');
        }
        let action = $this.data('action');
        let mailpath = $this.data('mailpath');
        let referrer = $this.data('referrer');
        $target.buttonLoader('start'); 

        $.post(link("ajax/imap/loader/" + referrer + "/" + mailpath + page), {action:action}, function(data) {
            $target.buttonLoader('stop');  
            if (data.success === true) { 
                $(".mailbox-messages").html(data.html);
                $(".pagination-data").html(data.pagination);
                updateChangeUrl(data.page_title, data.page_url);
            }  
        }) 
    }

    function mail_action(selector) {
        var ids    = []; 
        var paths  = []; 
        var targets = []; 
        let $this   = $(selector); //$(this)
        let action  = $this.data('action');
        $('.mailbox-messages input[type=\'checkbox\']:checked').each(function() {
            ids.push($(this).val())
            paths.push($(this).data('mailpath'))
            targets.push($(this).data('target'))
        });
        var mailpath = paths.length > 0 ? paths[0] : '';
        var clicks   = $('.checkbox-toggle').data('clicks')

        if ($('.mailbox-messages input[type=\'checkbox\']:checked').length>0 || $this.data('id')) {
            if ($this.data('id')) {
                ids = []; 
                ids.push($this.data('id'));
                mailpath = $this.data('mailpath');
            }
            $.ajax({
                url: link("ajax/imap/action/" + mailpath),
                method: "post",
                dataType: "JSON",
                data: {ids:ids,action:action,mailpath:mailpath},
                beforeSend: function() { 
                    $this.buttonLoader('start');  
                }, 
                success: function(data) {
                    $this.buttonLoader('stop'); 
                    if (data.message !== false) {
                        show_toastr(data.message, data.status);
                    }
                    if (data.success === true) {
                        if (action === 'delete') {
                            if ($this.data('redirect')) {
                                redirect($this.data('redirect'));
                            }
                            $.each(targets, function(index, item) {
                                $(item).fadeOut();
                            }); 
                            if ($('.messageTr').length<1 && urlParam('page') > 1) { 
                                mail_loader(".mail-loader");
                            } 
                        }
                    }             
                }
            });
        } 
    }
</script>