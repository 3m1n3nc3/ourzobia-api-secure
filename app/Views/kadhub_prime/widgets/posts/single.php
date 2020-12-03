        <?php 
            if ($post['type'] == 'image') {
                $image = $creative->fetch_image($post['file'], my_config('default_banner'));
            } 
            elseif (!empty($post['meta'])) {
                $meta  = toArray(json_decode($post['meta']));
                $image = $creative->fetch_image($meta['file'], my_config('default_banner'));
            }
            $current_page   = $_request->getGet('page')??1;
            $comments       = $postsModel->get_comments($post['post_id'], 'comment', $current_page);
            $count_comments = $cnt_cmnts =$postsModel->count_comments($post['post_id']);
            $count_comments += $postsModel->count_comments($post['post_id'], 'reply');
        ?> 
    <div id="blog-single">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-9">
                    <div class="blog-post">
                        <?php if (!empty($post['youtube'])): ?> 
                        <div class="post-thumb">
                            <div class="plyr__video-embeds iframe-wrap js-player" id="player-<?=$post['post_id']?>">
                                <iframe
                                src="<?=$post['youtube']?>?origin=https://plyr.io&amp;iv_load_policy=3&amp;modestbranding=1&amp;playsinline=1&amp;showinfo=0&amp;rel=0&amp;enablejsapi=1"
                                allowfullscreen
                                allowtransparency
                                allow="autoplay"
                                ></iframe>
                            </div>
                        </div>
                        <?php elseif ($post['type'] == 'video'): ?>
                        <div class="post-thumb">
                            <video class="js-player" id="player-<?=$post['post_id']?>" playsinline controls data-poster="<?=$creative->fetch_image($post['thumbnail'], 'banner')?>">
                                <source src="<?=base_url($post['file'])?>" type="video/mp4" />
                                <source src="<?=base_url($post['file'])?>" type="video/webm" /> 
                            </video>
                        </div>
                        <?php else: ?>
                            <?php if (!empty($image)): ?>
                        <div class="post-thumb">
                            <img src="<?=$image;?>" alt="">
                        </div>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if (!empty($post['description'])): ?>
                        <div class="post-content">
                            <p id="post-description-<?=$post['post_id']?>"><?=decode_html($post['description'])?></p>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center" id="comments_section">
            <div class="col-md-10">
                <div class="blog-comment">
                    <h4>
                        <?=_lang('count_comments', [$count_comments ? $count_comments : 'No'])?> 
                    </h4>
                    <ul class="comment-list post-comment-list" id="comments_section_<?=$post['post_id']?>">
                    <?php if ($comments):?>
                        <?php foreach ($comments as $key => $comment) {
                            echo load_widget('posts/comment', ['comment'=>$comment], 'front');
                        }?>
                    <?php endif ?>
                    </ul>

                    <div class="m-3">
                    <?=$pager->makeLinks($current_page, my_config('perpost', null, 10), $cnt_cmnts, 'custom_full')?>
                    </div>

                    <?php if (my_config('allow_comments', null, 1)):?>
                        <?php if (my_config('guest_comments', null, 1) || logged_in()): ?> 
                        <?=form_open('', ['id' => 'comment-form', 'class' => 'comment-form'])?>
                        <div class="message"></div>
                        <?=form_hidden('post_id', $post['post_id'])?>
                        <?=form_hidden('type', 'comment')?>
                        <div class="row">
                            <?php if (logged_in(false)): ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="<?=_lang('full_name')?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?=_lang('email_address')?>" required>
                                </div>
                            </div>
                            <?php endif ?>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="comment" id="comment" placeholder="<?=_lang('write_a_comment')?>" rows="4" required></textarea>
                                </div>
                                <div class="submit-button text-center">
                                    <button class="btn btn-common" type="submit"><?=_lang('post_comment')?></button>
                                </div>
                            </div>
                        </div>
                        <?=form_close()?>
                        <?php else: ?>
                            <?=alert_notice(_lang('login_to_comment'), 'info', false, false)?>
                        <?php endif ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>