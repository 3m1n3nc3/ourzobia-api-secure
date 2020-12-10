                <?php if ($mails_ids): 
                    rsort($mails_ids);?>
                    <table class="table table-hover table-striped">
                        <tbody>
                        <?php foreach (array_slice($mails_ids, $offset, $limit) as $key => $mail_id):
                            $email = $mailbox->getMail($mail_id, false);
                            $head  = $mailbox->getMailHeader($mail_id);
                            $mail_info  = $mailbox->getMailsInfo([$mail_id])[0] ?? null;
                            $content    = $email->textPlain ? $email->textPlain : $email->textHtml;
                            $email_text = $content ? word_wrap(word_limiter(super_strip_tags($content), 10), 55) : $content;
                            if(!empty($email->autoSubmitted) || !empty($email->precedence)) { 
                                $mailbox->markMailAsRead($mail_id);
                            }
                            foreach ($head->replyTo as $replyTo => $rt) {}
                            ?>
                            <tr class="messageTr" id="messageId<?=$mail_id?>" data-replyto="<?=$replyTo?>">
                                <td>
                                    <div class="icheck-primary">
                                        <input type="checkbox" value="<?=$mail_id?>" data-mailpath="<?=base64_url($head->imapPath) . "?csrf=" . csrf_hash()?>" id="check<?=$mail_id?>" data-target="#messageId<?=$mail_id?>">
                                        <label for="check<?=$mail_id?>"></label>
                                    </div>
                                </td>
                                <td class="mailbox-star" data-id="<?=$mail_id?>" data-action="<?=($mail_info->flagged) ? 'unflag' : 'flag' ?>" data-mailpath="<?=base64_url($head->imapPath) . "?csrf=" . csrf_hash()?>" id="check<?=$mail_id?>">
                                    <a href="#" class="action">
                                        <?php if ($mail_info->flagged): ?>
                                        <i class="fas fa-star text-warning star" data-action="flag"></i>
                                        <?php else: ?>
                                        <i class="fas fa-star text-muted star" data-action="unflag"></i>
                                        <?php endif ?>
                                    </a>
                                </td> 
                                <td class="mailbox-name">
                                    <a href="<?=site_url('mail/hub/read/' .base64_url($head->imapPath) . "/$mail_id/?hash=" . csrf_hash())?>" class="<?=!$mail_info->seen ? 'font-weight-bold' : ''?>">
                                        <?=(isset($email->fromName)) ? $email->fromName : $email->fromAddress?> 
                                    </a>
                                </td>
                                <td class="mailbox-subject"> 
                                    <span class="<?=!$mail_info->seen ? 'font-weight-bold' : ''?>"><?=$head->subject?></span>  
                                    <span class="text-muted"><?=$email_text ? '- ' . $email_text : $email_text;?></span>
                                </td>
                                <td class="mailbox-attachment">
                                <?php if ($email->hasAttachments()): ?>
                                    <i class="fas fa-paperclip"></i>
                                <?php endif ?>
                                </td>
                                <td class="mailbox-date">
                                    <?=nl2br(date("j M, Y \n h:i A", strtotime($head->date)))?>
                                    <!-- <span class="user-status-timestamp" data-livestamp="<?=$head->date?>"> -->
                                        <!-- <?=$head->date?>  -->
                                    <!-- </span> -->
                                </td>
                            </tr> 
                        <?php endforeach;
                            $mailbox->disconnect(); ?>
                        </tbody>
                    </table>
                    <!-- /.table --> 
                    <?php else: ?>
                        <div class="text-center">
                        <?=alert_notice(ucwords($_request->getGet('q') ? 'No Results found for "'.$_request->getGet('q').'"' : $curr_folder . " Is Empty!"), "info", false, false, 'h3')?>
                        </div>
                    <?php endif ?>