        <?php if ($mails_ids) {
            $limit = my_config('perpage', null, 5);
            $page  = min($pagination, ceil( $count_mail/ $limit )); //get last page when $_GET['page'] > $totalPages
            $offset = ($page - 1) * $limit;
            if( $offset < 0 ) $offset = 0;
        }?>        
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><?=ucwords($curr_folder)?></h3>
                <div class="card-tools">
                    <?=form_open('', ['method' => 'GET'])?>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" name="q" placeholder="Search Mail" value="<?=$_request->getGet('q')?>">
                        <input type="hidden" name="ctk" value="<?=csrf_hash()?>">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <?=form_close()?>
                </div>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <?php if ($mails_ids):?>
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm action" data-action="delete" title="Delete" data-toggle="tooltip">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm send-reply" title="Reply" data-toggle="tooltip">
                            <i class="fas fa-reply"></i>
                        </button> 
                    </div> 
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm mail-loader" data-action="sync" data-referrer="<?=$referrer?>" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <div class="float-right pagination-data" data-action="sync" data-referrer="<?=$referrer?>" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>"> 
                        <?=(($pagination*$limit)-$limit)+1?>-<?=$count_mail >= $pagination*$limit ? $pagination*$limit : $count_mail?>/<?=$count_mail?>
                        <?=service('pager')->makeLinks($pagination, $limit, $count_mail, 'custom_mail');?> 
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                </div>
                <?php endif;?>

                <div class="table-responsive mailbox-messages">
                <?=load_widget("mail/mailbox_table", [
                    'mails_ids' => $mails_ids, 
                    'offset'    => $offset ?? 1,
                    'limit'     => $limit ?? 0
                ])?>
                </div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
                <?php if ($mails_ids):?>
                <div class="mailbox-controls">
                    <!-- Check all button -->
                    <button type="button" class="btn btn-default btn-sm checkbox-toggle">
                    <i class="far fa-square"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm action" data-action="delete" title="Delete" data-toggle="tooltip">
                            <i class="far fa-trash-alt"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm send-reply" title="Reply" data-toggle="tooltip">
                            <i class="fas fa-reply"></i>
                        </button> 
                    </div>

                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm mail-loader" data-action="sync" data-referrer="<?=$referrer?>" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                    <div class="float-right pagination-data" data-action="sync" data-referrer="<?=$referrer?>" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>"> 
                        <?=(($pagination*$limit)-$limit)+1?>-<?=$count_mail >= $pagination*$limit ? $pagination*$limit : $count_mail?>/<?=$count_mail?>
                        <?=service('pager')->makeLinks($pagination, $limit, $count_mail, 'custom_mail');?>
                        <!-- /.btn-group -->
                    </div>
                    <!-- /.float-right -->
                </div>
                <?php endif;?>
            </div>
        </div>
        <!-- /.card -->

        <?php if ($mails_ids):?>
        <script>
            window.onload = function() {
                //Enable check and uncheck all functionality
                $('.checkbox-toggle').click(function () {
                    var clicks = $(this).data('clicks')
                    if (clicks) {
                        //Uncheck all checkboxes
                        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                        $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                    } else {
                        //Check all checkboxes
                        $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                        $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                    }
                    $(this).data('clicks', !clicks)
                })

                //Handle starring for font awesome
                $('.mailbox-star').click(function (e) {
                    e.preventDefault()
                    //detect type
                    var $this = $(this).find('a > i')
                    var star  = $this.hasClass('star')

                    //Switch states
                    if (star) {
                        $this.toggleClass('text-warning flagged')
                        $this.toggleClass('text-muted')
                    }

                    mail_action(this);
                });

                $("body").on("click", ".mail-loader", function(e) {
                    e.preventDefault();
                    mail_loader(this);
                });

                $(".send-reply").click(function() {
                    var recipients = []; 
                    let $this      = $(this);
                    $('.mailbox-messages input[type=\'checkbox\']:checked').each(function() { 
                        recipients.push($( $(this).data('target') ).data('replyto')); 
                    });
                    let form = $("<form>", {"action" : link("mail/compose"), "method" : "POST", "style" : "display:none;"})
                    .append($("<input>", {"type" : "hidden", "name" : "recipients", "value" : recipients}));

                    form.appendTo("body").submit();
                });

                $(".action").click(function() { 
                    mail_action(this);
                });
  
                if (is_logged()) {
                    $('#webmail-login-btn').click(function() {
                        
                        var $this = $(this);
                        
                        $this.buttonLoader('start');
                        $("form#webmail-login").remove();

                        $.post(link('connect/access_webmail/'+<?=logged_user('uid')?>), function(data) {
                            
                            $this.buttonLoader('stop'); 
                            show_toastr(data.message, data.status);  
                            
                            if (data.success === true) {
                                $form = $("<form>", {action: data.host, target: '_blank', id: 'webmail-login', method: 'post'})
                                    .append('<input type="hidden" name="session" value="'+data.session+'">'); 
                                $form.appendTo('body').submit();
                            }
                        });
                    });
                } 
            }
        </script>
        <?php endif;?>