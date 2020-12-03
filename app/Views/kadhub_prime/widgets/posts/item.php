        <?php 
            if ($post['type'] == 'image') {
                $image = $creative->fetch_image($post['file'], 'banner');
            } 
            elseif (!empty($post['meta'])) {
                $meta = toArray(json_decode($post['meta']));
                $image = $creative->fetch_image($meta['file'], 'banner');
            }  
            $count_comments = $postsModel->count_comments($post['post_id']);
            $count_comments += $postsModel->count_comments($post['post_id'], 'reply');
        ?> 
                <div class="col-lg-4 col-md-6 blog-item">  
                    <div class="blog-item-wrapper mb-5">
                        <?php if (!empty($image)): ?>
                        <div class="blog-item-img" style="min-height: 200px; background-image: url('<?=$image;?>'); background-size: cover;">
                            <a href="<?=site_url("post/{$post['token']}")?>">
                                
                            </a>
                        </div>
                        <?php endif ?>
                        <div class="blog-item-text">
                            <h3>
                                <a href="<?=site_url("post/{$post['token']}")?>"><?=$post['title'] ? $post['title'] : _lang('blog_post_by', [fetch_user('fullname', $post['uid'])])?></a>
                            </h3>
                            <div class="meta-tags">
                                <?php if ($post['event_time']): ?>
                                <div class="date border-bottom mb-1">
                                    <div class="text-dark">
                                        <i class="lnr lnr-calendar-full"></i>
                                        <?=_lang('event_date', [date('M d, Y', $post['event_time'])])?>
                                    </div>
                                    <div class="text-dark">
                                        <i class="lnr lnr-clock"></i>
                                        <?=_lang('event_time', [date('h:i A', $post['event_time'])])?>
                                    </div>
                                    <div class="text-dark">
                                        <i class="lnr lnr-map-marker"></i>
                                        <?=_lang('event_venue', [$post['event_venue']])?>
                                    </div>
                                </div>
                                <?php endif ?>
                                <span class="date">
                                    <i class="lnr lnr-calendar-full"></i>
                                    <?=_lang('posted')?> <?=date('M d, Y', $post['time'])?>
                                </span>
                                <?php if ($count_comments): ?>
                                <span class="comments">
                                    <a href="<?=site_url("post/{$post['token']}#comments_section_{$post['post_id']}")?>">
                                        <i class="lnr lnr-bubble"></i> <?=$count_comments?> Comments
                                    </a>
                                </span>
                                <?php endif ?>
                            </div>
                            <?php if (!empty($post['description'])): ?>
                                <p id="post-description-<?=$post['post_id']?>">
                                    <?=nl2br(word_wrap(strip_tags(word_limiter(decode_html($post['description']), 30)), 55));?>   
                                </p>
                            <?php endif ?>
                            <a href="<?=site_url("post/{$post['token']}")?>" class="btn btn-common btn-rm">Read More</a>
                        </div>
                    </div> 
                </div>