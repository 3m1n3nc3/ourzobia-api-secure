       <?php   
            foreach ($email->replyTo as $replyTo => $rt) {}?>

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Read Mail</h3>
                <div class="card-tools">
                    <a href="#" class="btn btn-tool" title="Previous"><i class="fas fa-chevron-left"></i></a>
                    <a href="#" class="btn btn-tool" title="Next"><i class="fas fa-chevron-right"></i></a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body bg-transparent p-0">
                <div class="mailbox-read-info">
                    <h5><?=$head->subject;?></h5>
                    <h6>
                        <div class="d-flex"> 
                            <code class="m-0">
                                <?php if ($head->headers->fromaddress): ?>
                                    <?=str_ireplace(['<','>'], ["&lt;","&gt;"], $head->headers->fromaddress);?>
                                <?php else: ?>
                                    <?=$email->fromName ? $email->fromName . " &lt;" : ''?><?=rtrim($head->fromAddress) . ($email->fromName ? "&gt;" : '');?>
                                <?php endif ?>
                            </code> 
                            <span class="dropdown m-0">
                                <a class="m-0 p-0 dropdown-toggle" data-toggle="dropdown" href="#">
                                    <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" style="min-width: 300px">
                                    <small class="dropdown-item" tabindex="-1">
                                        <div class="form-group row">
                                            <span class="col-sm-3">from:</span>
                                            <span class="col-sm-7"><?=$head->fromAddress;?></span>
                                        </div>  
                                        <div class="form-group row">
                                            <span class="col-sm-3">reply-to:</span>
                                            <span class="col-sm-7">
                                            <?php foreach ($head->replyTo as $replyTo => $rt):?> 
                                                <div><?=$replyTo?></div>
                                            <?php endforeach ?>
                                            </span>
                                        </div>  
                                        <div class="form-group row">
                                            <span class="col-sm-3">to:</span>
                                            <span class="col-sm-7">
                                            <?php foreach ($head->to as $tok => $to):?> 
                                                <div><?=$tok?></div>
                                            <?php endforeach ?>
                                            </span>
                                        </div>  
                                        <div class="form-group row">
                                            <span class="col-sm-3">date:</span>
                                            <span class="col-sm-7"><?=date('j M, Y h:i A', strtotime($head->date))?></span>
                                        </div>   
                                        <div class="form-group row">
                                            <span class="col-sm-3">subject:</span>
                                            <span class="col-sm-7"><?=nl2br(word_wrap($head->subject??'', 30));?></span>
                                        </div>   
                                        <div class="form-group row">
                                            <span class="col-sm-3">mailed-by:</span>
                                            <span class="col-sm-7"><?=$head->senderAddress;?></span>
                                        </div>   
                                    </small>
                                </div>
                            </span>
                        </div> 
                        <span class="mailbox-read-time float-right"><?=date('j M, Y h:i A', strtotime($head->date))?></span>
                    </h6>
                </div>
                <!-- /.mailbox-read-info -->
                <div class="mailbox-controls with-border text-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm action" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>" data-id="<?=$mail_id?>" data-action="delete" data-redirect="<?=site_url('mail/hub/folder/' . base64_url($mailbox->getImapPath()) . "/?csrf=" . csrf_hash())?>" data-container="body" title="Delete" data-toggle="tooltip">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    <?php if (!in_array($curr_folder, ['trash', 'drafts', 'sent'])): ?>
                        <button type="button" class="btn btn-default btn-sm send-reply" data-replyto="<?=$replyTo?>" data-container="body" title="Reply" data-toggle="tooltip">
                            <i class="fas fa-reply"></i>
                        </button>
                    <?php endif ?>
                        <a href="<?=site_url('mail/compose/' . base64_url($mailbox->getImapPath()) . "/$mail_id?csrf=" . csrf_hash())?>" class="btn btn-default btn-sm" data-container="body" title="Forward" data-toggle="tooltip">
                            <i class="fas fa-share"></i>
                        </a>
                    </div>
                    <!-- /.btn-group -->
                    <button type="button" class="btn btn-default btn-sm" title="Print">
                    <i class="fas fa-print"></i>
                    </button>
                </div>
                <!-- /.mailbox-controls -->
                <div class="mailbox-read-message">
                    <?=$email->textHtml ? $email->textHtml : formatLinkFromText($email->textPlain);?>
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-body -->

            <?php if ($email->hasAttachments()): ?>
            <div class="card-footer bg-white">
                <?=form_open()?>
                <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                    <?php foreach ($email->getAttachments() as $key => $attachment):
                        $attachment_filename = $upload_path . (url_title($curr_folder . $mail_id) . $attachment->name);
                        $attachment_link     = base_url($uploads_url . (url_title($curr_folder . $mail_id) . $attachment->name));
                        $attachment->setFilePath($attachment_filename);
                        // print_r($attachment_filenamet);
                        if (!file_exists($attachment_filename)) 
                        {
                            $attachment->saveToDisk();
                        }?>
                    <li style="min-width: 150px;">
                        <?php if (stripos($attachment->mime, 'image') !== false): ?>
                        <span class="mailbox-attachment-icon has-img" style="min-height: 105px;"><img src="<?=$attachment_link?>" alt="Attachment"></span>
                        <?php else: ?>
                        <span class="mailbox-attachment-icon"><i class="far fa-file fa-fw"></i></span>
                        <?php endif ?>
                        <div class="mailbox-attachment-info">
                            <a href="#" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> <?=$attachment->name?></a>
                            <span class="mailbox-attachment-size clearfix mt-1">
                                <span><?=number_to_size($attachment->sizeInBytes);?></span>
                                <button type="submit" class="btn btn-default btn-sm float-right" name="download" value="<?=$uploads_url . (url_title($curr_folder . $mail_id) . $attachment->name)?>">
                                    <i class="fas fa-cloud-download-alt"></i>
                                </button>
                            </span>
                        </div>
                    </li>
                    <?php endforeach ?>  
                </ul>
                <?=form_close()?>
            </div>
            <?php endif ?>

            <!-- /.card-footer -->
            <div class="card-footer">
                <div class="float-right"> 
                <?php if (!in_array($curr_folder, ['trash', 'drafts', 'sent'])): ?>
                    <button type="button" class="btn btn-default send-reply" data-replyto="<?=$replyTo?>"><i class="fas fa-reply"></i> Reply</button>
                <?php endif ?>
                    <a href="<?=site_url('mail/compose/' . base64_url($mailbox->getImapPath()) . "/$mail_id?csrf=" . csrf_hash())?>" class="btn btn-default forward"><i class="fas fa-share"></i> Forward</a>
                </div>
                <button type="button" class="btn btn-default action" data-mailpath="<?=base64_url($mailbox->getImapPath()) . "?csrf=" . csrf_hash()?>" data-id="<?=$mail_id?>" data-action="delete" data-redirect="<?=site_url('mail/hub/folder/' . base64_url($mailbox->getImapPath()) . "/?csrf=" . csrf_hash())?>"> 
                    <i class="far fa-trash-alt"></i> Delete
                </button>
                <button type="button" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card --> 

        <script>
            window.onload = function() {  
                $(".send-reply").click(function() {
                    var recipients = $(this).data('replyto');  
                    let form = $("<form>", {"action" : link("mail/compose"), "method" : "POST", "style" : "display:none;"})
                    .append($("<input>", {"type" : "hidden", "name" : "recipients", "value" : recipients}));

                    form.appendTo("body").submit();
                }); 

                $(".action").click(function() { 
                    mail_action(this);
                });
            }
        </script>