<!DOCTYPE html> 
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
                    <?php if ($page_name == 'login'): ?>
                    <h3 class="login-box-msg">
                    	<?=_lang('account_login')?> 
                   </h3>
                    <?php else: ?>
                    <h3 class="login-box-msg">
                    	<?=_lang('create_new_account')?> 
                    </h3>
                    <?php endif ?> 

                    <?php if (!empty($referrer['uid']) && $_request->getGet('ref') && $referrer['uid'] != system_user_id(true)): ?>
                        <h6 class="badge badge-secondary text-center">
                            <?=_lang('referred_by',[$referrer['user_level'], $referrer['fullname']])?> 
                        </h6>
                    <?php endif ?>
						
                    <?php if ($page_name == 'login'): ?>

					<?=form_open('', array('method' => 'post', 'class' => 'login_form'))?> 
                        <?= csrf_field() ?>
						<?=$errors->showError('username', 'my_single_error');?>
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="username" placeholder="<?=_lang('username_email')?>" value="<?= set_value('username'); ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						
						<?=$errors->showError('password', 'my_single_error');?>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="password" placeholder="<?=_lang('password')?>" value="<?= set_value('password'); ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="icheck-primary">
									<input type="checkbox" id="remember" name="remember"<?= set_checkbox('remember', 'on'); ?>>
									<label for="remember">
										<?=_lang('remember_me')?>
									</label>
								</div>
							</div>
							<!-- /.col -->
                        <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?>
							<div class="col-4">
								<button type="submit" class="btn btn-primary btn-block">
									<?=_lang('login')?> 
								</button>
							</div>
							<!-- /.col -->
                        <?php endif ?>
						</div>
                        <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?>
                        <div class="text-center mt-3"> 
                            <p class="mb-2 text-muted">
                            	<?=_lang('forgot_password')?><a href="<?=site_url('user/m/recovery')?>">Reset</a>
                            </p>
                            <p class="mb-0 text-muted">
                            	<?=_lang('dont_have_an_account')?>
                            	<a href="<?=site_url('signup' . ($_request->getGet('redirect') ? '?redirect=' . urlencode($_request->getGet('redirect')) : ''))?>">
                            		<?=_lang('register')?> 	
                        		</a>
                        	</p> 
                        </div>
                        <?php endif ?>
					<?=form_close()?>
                    <?php else: ?>
                    <?=form_open('signup', 'class="form form-alt signup_form text-left" method="post"')?>
                        <?= csrf_field() ?>
                        
                        <?=$errors->showError('email', 'my_single_error');?>
                        <div class="form-group">
                        	<label for="email">
                        		<?=_lang('your_email')?>
                        	</label>
	                        <div class="input-group">
	                            <input type="text" class="form-control" id="email" name="email" aria-describedby="Your Email" placeholder="Your Email" value="<?= set_value('email'); ?>" required> 
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-envelope"></span>
									</div>
								</div>
	                        </div>
                        </div>
                        
                        <?=$errors->showError('phone_number', 'my_single_error');?>
                        <div class="form-group">
                            <label for="phone">
                            	<?=_lang('your_phone')?>
                            </label>
                            <div class="input-group mb-3">
                            <?php if (my_config('reg_mode') == 0): ?>
                                <div class="input-group-prepend">
                                    <select class="form-control" name="phone_code" required>
                                        <?=select_countries(set_value('phone_code'), 'phonecode')?> 
                                    </select> 
                                </div>
                            <?php endif ?>
                                <input type="text" class="form-control" aria-label="Phone" id="phone" name="phone_number" placeholder="Phone Number" value="<?= set_value('phone_number'); ?>" required>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-phone"></span>
									</div>
								</div>
                            </div>
                        </div>

                        <?=$errors->showError('password', 'my_single_error');?>
                        <div class="form-group">
                            <label for="password">
								<?=_lang('password')?>
                            </label>
                            <div class="input-group mb-3">
                            	<input type="password" class="form-control" id="password" name="password" aria-describedby="Password" placeholder="Password" value="<?= set_value('password'); ?>" required> 
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
                            </div>
                        </div> 

                        <?=$errors->showError('repassword', 'my_single_error');?>
                        <div class="form-group">
                            <label for="repassword">
                            	<?=_lang('repeat_password')?>
                            </label>
                            <div class="input-group mb-3">
                            	<input type="password" class="form-control" id="repassword" name="repassword" aria-describedby="Repeat Password" placeholder="Repeat Password" value="<?= set_value('repassword'); ?>" required> 
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
							</div>
                        </div> 
						<div class="row">
							<?=$errors->showError('terms', 'my_single_error');?>
							<div class="col-8">
								<div class="icheck-primary">
									<input type="checkbox" id="terms" name="terms"<?= set_checkbox('terms', 'on'); ?>>
									<label for="terms">
										<?=_lang('i_accept_terms_conditions', [site_url('page/terms-of-use')])?> 
									</label>
								</div> 
							</div>
                        <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?>
							<div class="col-4">
								<button type="submit" class="btn btn-primary btn-block">
									<?=_lang('register_now'); ?>
								</button>
							</div>
							<!-- /.col -->
                        <?php endif ?>
                        </div>
                        <?php if (my_config('site_mode') !== '1' || $session->has('incognito')): ?>
                        <div class="text-center mt-3"> 
                            <p class="mb-2 text-muted">
                            	<a href="<?=site_url('user/m/recovery')?>">
                            		<?=_lang('forgot_password')?>
                            	</a>
                            </p>
                            <p class="mb-0 text-muted">
                            	<?=_lang('already_have_an_account')?>
                            	<a href="<?=site_url('login')?>">
                            		<?=_lang('login')?> 	
                        		</a>
                        	</p>
                        </div>
                        <?php endif ?>
                    <?=form_close()?>
                    <?php endif ?> 
				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
		<!-- /.login-box -->
		<!-- Footer Content -->
		<?=view('default/dashboard_footer'); ?> 
	</body>
</html>
