			<!-- Navbar -->
			<nav class="main-header navbar navbar-expand navbar-light<?=my_config('des_nav_border').my_config('des_nav_small_text').my_config('des_nav_variant')?>">
				<!-- Left navbar links -->
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
					</li>
					<li class="nav-item d-none d-sm-inline-block">
						<a href="<?=site_url()?>" class="nav-link">Home</a>
					</li>
					<li class="nav-item d-none d-sm-inline-block">
						<a href="<?=site_url('page/contact')?>" class="nav-link">Contact</a>
					</li>
				</ul> 

				<!-- Right navbar links -->
				<ul class="navbar-nav ml-auto">      
          			<!-- Add Messages Dropdown Menu Here -->       
					<li class="nav-item dropdown">
						<a href="#" class="nav-link" data-toggle="dropdown" id="get-notifications">
							<i class="far fa-bell" id="notification_bell"></i>
							<span class="badge badge-danger navbar-badge" id="new__notif"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right scroll-notifications" id="notifications__list">
						</div>
						<div class="text-center preloader d-none">
							<div class="spinner-light text-info spinner-grow" role="status">
								<span class="sr-only">Loading...</span>
							</div>
						</div>
					</li>

					<li class="nav-item dropdown user-menu">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
							<img src="<?=$user['avatar_link']?>" class="user-image img-circle elevation-2" alt="Employee Image">
							<span class="d-none d-md-inline"><?=ucfirst($user['username'])?></span>
						</a>
						<ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
							<!-- User image -->
							<li class="user-header bg-light">
								<img src="<?=$user['avatar_link']?>" class="img-circle elevation-2" alt="User Image">
								<p>
									<?=ucwords($user['fullname'])?>
				                	<?php if (fetch_user('cpanel')): ?>
									<small><?=fetch_user('username') . '@' . my_config('cpanel_domain')?></small>
									<?php endif;?>
									<div class="card line-height-15 my-0 p-1"> 
					                    <div class="line-height-15 my-0 py-0">
					                    	<span class="text-info small ml-2">
					                    		<?=_lang('wallet')?>: <span class="text-danger"><?=money($user['wallet'])?></span>
					                    	</span>
					                    </div>
									</div>
								</p>
							</li>
							<!-- Menu Footer-->
							<li class="user-footer bg-warning">
								<?php if (module_active('account')): ?>
								<a href="<?=site_url('user/account')?>" class="btn btn-default btn-flat">Settings</a> 
								<?php endif;?>
								<a href="<?=site_url('logout')?>" class="btn btn-default btn-flat float-right">Sign out</a>
							</li>
						</ul>
					</li>
					<?php if ($user['admin']>1):?>
					<li class="nav-item">
						<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
						class="fas fa-th-large"></i></a>
					</li>
					<?php endif;?>
				</ul>
			</nav>
			<!-- /.navbar -->