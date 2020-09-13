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
				<a href="<?=site_url()?>"><b><?=my_config('site_name')?></a>
			</div>
			<!-- /.login-logo -->
			<div class="card">
				<div class="card-body login-card-body">
					<p class="login-box-msg">Sign to your dashboard</p>
					<?=form_open('', array('method' => 'post', 'class' => 'login_form'))?>
						
						<?=$errors->showError('username', 'my_single_error');?>
						<div class="input-group mb-3">
							<input type="text" class="form-control" name="username" placeholder="Username or Email" value="<?= set_value('username'); ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-user"></span>
								</div>
							</div>
						</div>
						
						<?=$errors->showError('password', 'my_single_error');?>
						<div class="input-group mb-3">
							<input type="password" class="form-control" name="password" placeholder="Password" value="<?= set_value('password'); ?>">
							<div class="input-group-append">
								<div class="input-group-text">
									<span class="fas fa-lock"></span>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-8">
								<div class="icheck-primary">
									<input type="checkbox" id="remember" name="remember" id="terms"<?= set_checkbox('remember', 'on'); ?>>
									<label for="remember">
										Remember Me
									</label>
								</div>
							</div>
							<!-- /.col -->
							<div class="col-4">
								<button type="submit" class="btn btn-primary btn-block">Sign In</button>
							</div>
							<!-- /.col -->
						</div>
					<?=form_close()?>
					<p class="mb-1">
						<a href="<?=site_url('recovery')?>">I forgot my password</a>
					</p> 
				</div>
				<!-- /.login-card-body -->
			</div>
		</div>
		<!-- /.login-box -->
		<!-- Footer Content -->
		<?=view('default/dashboard_footer'); ?> 
	</body>
</html>
