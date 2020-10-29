            <div class="lockscreen-name">
                <?=!empty($screen_name) ? $screen_name : (!empty($user['fullname']) ? $user['fullname'] : 'Hi!')?> 
            </div> 
             
            <div class="lockscreen-item"> 
                <div class="lockscreen-image">
                    <img src="<?=$creative->fetch_image(logged_user('avatar'), 'banner')?>" alt="">
                </div>  
            <?=form_open('login', array('method' => 'post', 'class' => 'lockscreen-credentials'))?>  
                <div class="input-group">
                    <input type="hidden" name="username" value="<?=set_value('username', $user['username']); ?>">
                    <input type="password" class="form-control" placeholder="<?=_lang('password')?>">
                    <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?> 
                        <div class="input-group-append"> 
                            <button type="submit" class="btn" title="<?=_lang('login')?>" data-toggle="tooltip">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
            <?=form_close()?>  
            </div>  
            <div class="help-block text-center">
                Enter your password to log back in
            </div>
            <div class="text-center">
                <a href="<?=site_url('logout/login')?>">Or log in as a different user</a>
            </div>  