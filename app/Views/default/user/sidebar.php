			<!-- Main Sidebar Container -->
			<aside class="main-sidebar elevation-4<?=my_config('des_disable_sidebar_expand').my_config('des_sidebar_variants')?>">
				<!-- Brand Logo -->
				<a href="<?=site_url()?>" class="brand-link<?=my_config('des_small_brand').my_config('des_logo_skin')?>">
					<img src="<?=$creative->fetch_image(my_config('site_logo'), 'logo')?>" alt="<?=my_config('site_name')?> Logo" class="brand-image img-circle elevation-3"
					style="opacity: .8">
					<span class="brand-text font-weight-light"><?=my_config('site_name')?></span>
				</a>

				<!-- Sidebar -->
				<div class="sidebar">
					<!-- Sidebar user panel (optional) -->
					<div class="user-panel mt-3 pb-3 mb-3 d-flex">
						<div class="image">
							<img src="<?=$user['avatar_link']?>" class="img-circle elevation-2" alt="User Image">
						</div>
						<div class="info">
							<a href="#" class="d-block"><?=ucwords($user['fullname'])?></a>
						</div>
					</div>

					<!-- Sidebar Menu -->
					<nav class="mt-2">
						<ul class="nav nav-pills nav-sidebar flex-column<?=my_config('des_sidenav_small_text').my_config('des_flat_nav').my_config('des_legacy_nav').my_config('des_compact_nav').my_config('des_indent_nav')?>" data-widget="treeview" role="menu" data-accordion="false"> 
							<?php if (module_active('dashboard')): ?>
							<li class="nav-item">
								<a href="<?=site_url('user/dashboard')?>" class="nav-link<?=active_page('dashboard', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>
										<?=_lang('dashboard')?> 
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('account')): ?>
							<li class="nav-item">
								<a href="<?=site_url('user/account')?>" class="nav-link<?=active_page('account', $page_name)?>">
									<i class="nav-icon fas fa-user"></i>
									<p>
                    					<?php if (!empty($profile['uid']) && user_id() !== user_id($profile['uid'])): ?>
										<?=_lang('named_users_acount', [ucwords($profile['firstname'])])?> 
										<?php else: ?>  
										<?=_lang('my_account')?> 
										<?php endif ?>  
									</p>
								</a>
							</li>
							<?php endif ?>  
							<?php if (module_active('products')): ?>
							<li class="nav-item">
								<a href="<?=site_url('user/products')?>" class="nav-link<?=active_page('products', $page_name)?>">
									<i class="nav-icon fas fa-box-open"></i>
									<p>
                    					<?php if (!empty($profile['uid']) && user_id() !== user_id($profile['uid'])): ?>
										<?=_lang('named_users_products', [ucwords($profile['firstname'])])?> 
										<?php else: ?>  
										<?=_lang('my_products')?> 
										<?php endif ?>  
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('posts', my_config('frontend_theme', null, 'default')) && logged_user('admin')): ?>
							<li class="nav-item">
								<a href="<?=site_url('user/posts')?>" class="nav-link<?=active_page('posts', $page_name)?>">
									<i class="nav-icon fas fa-podcast	"></i>
									<p>
                    					<?=_lang('blog_and_events')?> 
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('mail') && 
								logged_user('cpanel') && 
								my_config('cpanel_url') && 
								my_config('cpanel_username') && 
								my_config('cpanel_password')): ?>
							<li class="nav-item">
								<a href="<?=site_url('mail')?>" class="nav-link<?=active_page('mail', $page_name)?>">
									<i class="nav-icon fas fa-envelope"></i>
									<p>
                    					<?=_lang('mailbox')?> 
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('hub_type') || module_active('hubs')):?>
							<li class="nav-item has-treeview<?=active_page(['hubs','hub_info','hubs_booked'], $_page_name??$page_name, false, 'menu-open')?>">
								<a href="#" class="nav-link<?=active_page(['hubs','hub_info','hubs_booked'], $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-building"></i>
									<p>
										<?=_lang('hubs')?>
									</p>
								</a>
            					<ul class="nav nav-treeview"> 
									<?php if (module_active('hub_type')): ?>
									<li class="nav-item">
										<a href="<?=site_url('user/hubs')?>" class="nav-link<?=active_page('hubs', $page_name_??$_page_name??$page_name)?>">
											<i class="nav-icon fas fa-columns"></i>
											<p>
												<?=_lang('book_hub')?>
											</p>
										</a>
									</li>
									<?php endif ?>  
								</ul>
            					<ul class="nav nav-treeview"> 
									<?php if (module_active('hubs')): ?>
									<li class="nav-item">
										<a href="<?=site_url('user/hubs/my_hubs')?>" class="nav-link<?=active_page('hubs_booked', $page_name_??$_page_name??$page_name)?>">
											<i class="nav-icon fas fa-columns"></i>
											<p>
												<?=_lang('my_hubs')?>
											</p>
										</a>
									</li>
									<?php endif ?>  
								</ul>
							</li>
							<?php endif ?>   
							<?php if (module_active('payments')): ?>
							<li class="nav-item">
								<a href="<?=site_url('user/payments')?>" class="nav-link<?=active_page('payments', $page_name)?>">
									<i class="nav-icon fas fa-credit-card"></i>
									<p>
                    					<?php if (!empty($profile['uid']) && user_id() !== user_id($profile['uid'])): ?>
										<?=_lang('named_users_payments', [ucwords($profile['firstname'])])?> 
										<?php else: ?>  
										<?=_lang('my_payments')?> 
										<?php endif ?>  
									</p>
								</a>
							</li>
							<?php endif ?>  
							<?php if (module_active('_dashboard') && logged_user('admin')):?> 
							<li class="nav-item">
								<a href="<?=site_url('admin')?>" class="nav-link<?=active_page('admin', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-user-secret"></i>
									<p>
										<?=_lang('admin_dashboard')?>
									</p>
								</a>
							</li> 
							<?php endif ?>   
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>
