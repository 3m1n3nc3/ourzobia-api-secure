            <div class="lockscreen-name">
                <?=!empty($screen_name) ? $screen_name : (!empty($user['fullname']) ? $user['fullname'] : 'Hi!')?> 
            </div> 
             
            <div class="lockscreen-item"> 
                <div class="lockscreen-image">
                    <img src="<?=$creative->fetch_image(logged_user('avatar'), 'banner')?>" alt="">
                </div>  
            <?=form_open('relogin' . (!empty($redirect) ? '?redirect=' . $redirect : ''), [
                'method' => 'post', 
                'class' => 'lockscreen-credentials'
            ])?>  
                <?= csrf_field() ?> 
                <input type="hidden" name="help_action" value="<?=$help_action?>">
                <input type="hidden" name="set_token" value="<?=$set_token?>">
                <input type="hidden" name="username" value="<?=set_value('username', $user['username']); ?>">
                <div class="input-group">
                    <?php if (!empty($set_token)): ?>
                    <?php endif ?>
                    <input type="password" name="password" class="form-control" placeholder="<?=_lang('password')?>">
                    <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?> 
                        <div class="input-group-append"> 
                            <button type="submit" class="btn" title="<?=_lang('login')?>" data-toggle="tooltip">
                                <i class="fas fa-arrow-right text-muted"></i>
                            </button>
                        </div>
                    <?php endif ?>
                </div>
                <?php if (isset($errors)): ?>
                    <?= $errors->showError('password', 'my_single_error'); ?>
                    <?= $errors->showError('username', 'my_single_error'); ?>
                <?php endif ?>
            <?=form_close();?>  
            </div>  
            <div class="help-block text-center">
                Enter your password to <?=$help_action??'log back in!'?>
            </div>
            <div class="text-center">
                <a href="<?=site_url('logout/login')?>">Or log in as a different user</a>
            </div>  