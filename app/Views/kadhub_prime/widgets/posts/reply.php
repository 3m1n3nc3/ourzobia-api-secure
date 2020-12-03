                    <?php if (!empty($comment) && !empty($reply)):  
                        $avatar = $fullname = "";
                        if (fetch_user('uid', $reply['uid'])) {
                            $fullname = fetch_user('fullname', $reply['uid']);
                            $avatar   = fetch_user('avatar_link', $reply['uid']);
                        } 
                        elseif (!empty($reply['meta'])) {
                            $meta     = toArray(json_decode($reply['meta']));
                            $fullname = $meta['fullname'] . " (Guest)";
                            $avatar   = $creative->fetch_image('avatar', 'boy');
                        } 
                        $true_guest = (($meta['uip']??null) === $_request->getIPAddress());?> 
                        
                    <li class="comment post-reply" id="post-reply-<?=$reply['id']?>">
                        <div class="the-comment">
                            <div class="avatar">
                                <img src="<?=$avatar?>" alt="" style="height: 50px">
                            </div>
                            <div class="comment-box">
                                <div class="comment-author">
                                    <strong><?=$fullname?></strong> 
                                    
                                <?php if (my_config('allow_comments', null, 1)): ?>
                                    <?php if (service('session')->has('guest_meta') || logged_in()): ?>
                                    <span class="meta"> <?=date('M j, Y', $reply['time'])?> at <?=date('h:i A', $reply['time'])?></span>
                                    <a class="comment-reply-link" href="javascript:void(0)" data-target="#reply-form-<?=$reply['id']?>"> - Reply</a> 
                                    <?php endif ?>
                                <?php endif ?>

                                    <?php if (logged_user('uid') === $reply['uid'] || $true_guest ||  logged_user('admin')): ?>
                                    <button class="btn px-0 deleter" 
                                        type="button" 
                                        title="Delete"
                                        data-toggle="tooltip"
                                        data-target="#post-reply-<?=$reply['id']?>"
                                        data-extra='{"type":"reply","modal":"#actionModal"}'
                                        data-label="Delete"
                                        data-class="btn btn-danger btn-spinner font-weight-bold py-0" 
                                        data-type="posts" 
                                        data-id="<?=$reply['id']?>"
                                        onclick="confirmAction('click', false, 'cancel', 'Are you sure you want to delete this comment?', this);">
                                        <i class="fa fa-trash fa-fw text-danger"></i>
                                    </button> 
                                    <?php endif ?>
                                </div>
                                <div class="comment-text">
                                    <p><?=$reply['comment']?></p>
                                </div>

                            <?php if (my_config('allow_comments', null, 1)): ?>
                                <?php if (service('session')->has('guest_meta') || logged_in()): ?>
                                <?=form_open('', ['id' => "reply-form-{$reply['id']}", 'class' => 'reply-form comment-form', 'style' => 'display:none;'])?>
                                <div class="message"></div>
                                <?=form_hidden('post_id', $post['post_id'])?>
                                <?=form_hidden('reply_id', $comment['id'])?>
                                <?=form_hidden('type', 'reply')?>
                                <div class="row"> 
                                    <div class="col-md-9">
                                        <div class="form-group"> 
                                            <input type="text" class="form-control" name="comment" id="reply<?=$comment['id']?>" placeholder="<?=_lang('write_a_reply')?>">  
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="submit-button">
                                            <button class="btn btn-primary" type="submit"><?=_lang('reply')?></button>
                                        </div>
                                    </div>
                                </div>
                                <?=form_close()?> 
                                <?php endif ?>
                            <?php endif ?>
                            </div>
                        </div>
                    </li> 
                    <?php endif ?> 