                    <?php if (!empty($comment)):
                        $avatar = $fullname = "";
                        if (fetch_user('uid', $comment['uid'])) {
                            $fullname = fetch_user('fullname', $comment['uid']);
                            $avatar   = fetch_user('avatar_link', $comment['uid']);
                        } 
                        elseif (!empty($comment['meta'])) {
                            $meta     = toArray(json_decode($comment['meta']));
                            $fullname = $meta['fullname'] . " (Guest)";
                            $avatar   = $creative->fetch_image('avatar', 'boy');
                        }
                        $replies = $postsModel->get_comments($comment['id'], 'reply');
                        $true_guest = (($meta['uip']??null) === $_request->getIPAddress());?> 

                        <li class="comment post-comment" id="post-comment-<?=$comment['id']?>">
                            <div class="the-comment">
                                <div class="avatar">
                                    <img src="<?=$avatar?>" alt="" style="height: 50px">
                                </div>
                                <div class="comment-box">
                                    <div class="comment-author">
                                        <strong><?=$fullname?></strong>
                                        <span class="meta"> 
                                            <?=date('M j, Y', $comment['time'])?> at <?=date('h:i A', $comment['time'])?> 
                                        </span>
                                    <?php if (my_config('allow_comments', null, 1)): ?>
                                        <?php if (service('session')->has('guest_meta') || logged_in()): ?>
                                        <a class="comment-reply-link" href="javascript:void(0)" data-target="#reply-form-<?=$comment['id']?>"> - Reply</a>
                                        <?php endif ?>
                                    <?php endif ?>
                                        <?php if (logged_user('uid') === $comment['uid'] || $true_guest || logged_user('admin')): ?>
                                        <button class="btn px-0 deleter" 
                                            type="button" 
                                            title="Delete"
                                            data-toggle="tooltip"
                                            data-target="#post-comment-<?=$comment['id']?>"
                                            data-extra='{"type":"comment","modal":"#actionModal"}'
                                            data-label="Delete"
                                            data-class="btn btn-danger btn-spinner font-weight-bold py-0" 
                                            data-type="posts" 
                                            data-id="<?=$comment['id']?>"
                                            onclick="confirmAction('click', false, 'cancel', 'Are you sure you want to delete this comment?', this);">
                                            <i class="fa fa-trash fa-fw text-danger"></i>
                                        </button> 
                                        <?php endif ?>
                                    </div>
                                    <div class="comment-text">
                                        <p><?=$comment['comment']?></p>
                                    </div>
                                </div>
                            </div>
                            <ul class="children post-reply-list" id="replies_section_<?=$comment['id']?>">
                            <?php if ($replies): ?>
                                <?php foreach ($replies as $key => $reply) {
                                    echo load_widget('posts/reply', ['comment'=>$comment, 'reply' => $reply], 'front');
                                }?> 
                            <?php endif ?>
                            </ul>

                            <?php if (my_config('allow_comments', null, 1)): ?>
                                <?php if (service('session')->has('guest_meta') || logged_in()): ?>
                                <?=form_open('', ['id' => "reply-form-{$comment['id']}", 'class' => 'reply-form comment-form', 'style' => 'display:none;'])?>
                                <div class="message"></div>
                                <?=form_hidden('post_id', $post['post_id'])?>
                                <?=form_hidden('reply_id', $comment['id'])?>
                                <?=form_hidden('type', 'reply')?>
                                <div class="row"> 
                                    <div class="col-md-9">
                                        <div class="form-group"> 
                                            <input type="text" class="form-control" name="comment" id="reply<?=$comment['id']?>" placeholder="<?=_lang('write_a_reply')?>" required>  
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
                        </li> 
                    <?php endif ?> 