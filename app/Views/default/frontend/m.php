<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    
    <!-- Header -->
    <?=view('default/header'); ?> 

    <body class="hold-transition login-page">
        <div class="login-box"> 
            <div class="login-logo">
                <a href="<?=site_url()?>">
                    <img src="<?=$creative->fetch_image(my_config('site_logo'), 'logo')?>" height="50px" alt="<?=my_config('site_name')?> Logo">
                </a>
                <h5 class="pt-2"><?=my_config('site_name')?></h5>
            </div> 

            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <h3 class="login-box-msg"><?=$page_title?></h3>
                    
                    <?php if (empty($token_user)): ?>
                    <p class="mb-3 text-center">
                        We will send a link to your <a href="#"><u>registered email</u></a> to complete your request.
                    </p>
                    <?php endif ?>

                    <?php if (!empty($token_user)): ?>
                        <h5 class="text-success">Hello <span class="font-weight-bold"><?=$token_user['fullname']?></span></h5>
                        <?php if ($action == 'password' && !empty($token_user)): ?>
                        <h5 class="text-info"><?=_lang('m_change_your_password')?></h5>
                        <?php endif ?>
                    <?php endif ?>
                
                    <?=form_open('', 'class="form token_management text-left"');?> 
                        <?= csrf_field() ?>
                        <?=form_hidden('token', $_request->getGet('token')) ?>
                        <?php if ($action == 'recovery' || ($action == 'password' && empty($token_user))): ?>
                            <?=form_hidden('action', 'send_token') ?>
                            <?=form_hidden('type', 'recover_password') ?>
                        <?php elseif ($action == 'access' || $action == 'incognito'): ?>
                            <?=form_hidden('action', 'send_token') ?>
                            <?=form_hidden('type', $action . '_token') ?>
                        <?php elseif ($action == 'password' && !empty($token_user)): ?>
                            <?=form_hidden('action', 'change_password') ?>
                        <?php endif ?>

                        <div class="form_message" style="display: none;"></div>
                        <?=$session->getFlashdata('notice')?>

                        <?php if ($action == 'password' && !empty($token_user)): ?>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" class="form-control" id="password" name="password" aria-describedby="password" placeholder="New Password" value="<?= set_value('password'); ?>" required> 
                            <?=$errors->showError('password', 'my_single_error');?>
                        </div>

                        <div class="form-group">
                            <label for="repassword">Repeat Password</label>
                            <input type="password" class="form-control" id="repassword" name="repassword" aria-describedby="repassword" placeholder="Repeat Password" value="<?= set_value('repassword'); ?>" required> 
                            <?=$errors->showError('repassword', 'my_single_error');?>
                        </div>
                        <?php else: ?> 
                        <div class="form-group">
                            <label for="email">Your Email Address</label>
                            <input type="text" class="form-control" id="email" name="email" aria-describedby="email" placeholder="Your Email Address" value="<?= set_value('email'); ?>" required> 
                            <?=$errors->showError('email', 'my_single_error');?>
                        </div>
                        <?php endif ?>

                        <div class="text-center">
                            <?php if ($action == 'recovery' || $action == 'access' || $action == 'incognito'): ?>  
                            <button type="submit" class="btn btn-primary shadow-2 mb-4">Send Token</button> 
                            <?php elseif (!empty($token_user)): ?>
                            <button type="submit" class="btn btn-primary shadow-2 mb-4">Update</button> 
                            <?php else: ?>
                            <p class="mb-0 text-muted">
                                <a class="btn btn-primary shadow-2 mb-4" href="<?=site_url('user/m/recovery')?>" >Request New Token</a>
                            </p>
                            <?php endif ?>

                            <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?>
                            <p class="mb-0 text-muted">Already have an account? <a href="<?=site_url('home/login')?>" >Login</a></p>
                            <?php endif ?>
                        </div>
                    <?=form_close()?>   
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
        <!-- Footer Content -->
        <?=view('default/dashboard_footer'); ?> 
    </body>
</html>
