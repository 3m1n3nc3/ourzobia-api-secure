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
							<?php if (module_active('_dashboard')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/dashboard')?>" class="nav-link<?=active_page('dashboard', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-tachometer-alt"></i>
									<p>
										<?=_lang('admin_dashboard')?> 
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('_users')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/users')?>" class="nav-link<?=active_page('users', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-users"></i>
									<p>
										<?=_lang('users')?>  
									</p>
								</a>
							</li>
							<?php endif ?>  
							<?php if (module_active('_products')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/products')?>" class="nav-link<?=active_page('products', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-box"></i>
									<p>
										<?=_lang('products')?> 
									</p>
								</a>
							</li>
							<?php endif ?>   
							<?php if (module_active('_payments')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/payments')?>" class="nav-link<?=active_page('payments', $page_name)?>">
									<i class="nav-icon fas fa-credit-card"></i>
									<p>
                    					<?=_lang('payments')?> 
									</p>
								</a>
							</li>
							<?php endif ?>  
							<?php if (logged_user('admin')>=3 && (
								module_active('_hub_type') ||
								module_active('_hubs') 
							)):?>
							<li class="nav-item has-treeview<?=active_page(['hub_type','hub_create','hub_list', 'hub_booked'], $_page_name??$page_name, false, 'menu-open')?>">
								<a href="#" class="nav-link<?=active_page(['hub_type','hub_create','hub_list', 'hub_booked'], $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-building"></i>
									<p>
										<?=_lang('manage_hubs')?>
									</p>
								</a>
            					<ul class="nav nav-treeview"> 
									<?php if (module_active('_hub_type')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/hubs')?>" class="nav-link<?=active_page('hub_type', $page_name_??$_page_name??$page_name)?>">
											<i class="nav-icon fas fa-object-group"></i>
											<p>
												<?=_lang('hub_category')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
									<?php if (module_active('_hubs')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/hubs/hub_list')?>" class="nav-link<?=active_page(['hub_list','hub_create'], $page_name_??$_page_name??$page_name)?>">
											<i class="nav-icon fas fa-columns"></i>
											<p>
												<?=_lang('hub_list')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
									<?php if (module_active('_hubs')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/hubs/hub_booked')?>" class="nav-link<?=active_page('hub_booked', $page_name_??$_page_name??$page_name)?>">
											<i class="nav-icon fas fa-book-open"></i>
											<p>
												<?=_lang('booked_hubs')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
								</ul>
							</li>
							<?php endif?>
							<?php if (logged_user('admin')>=3 && (
								module_active('_config') ||
								module_active('_features') ||
								module_active('_content') ||
								module_active('_gallery')
							)):?>
							<li class="nav-item has-treeview<?=active_page(['configuration','features','content','gallery'], $_page_name??$page_name, false, 'menu-open')?>">
								<a href="#" class="nav-link<?=active_page(['configuration','features','content','gallery'], $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-cog"></i>
									<p>
										<?=_lang('config')?>
									</p>
								</a>
            					<ul class="nav nav-treeview"> 
									<?php if (module_active('_config')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/configuration')?>" class="nav-link<?=active_page('configuration', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-cog"></i>
											<p>
												<?=_lang('configuration')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
									<?php if (module_active('_features')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/features')?>" class="nav-link<?=active_page('features', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-image"></i>
											<p>
												<?=_lang('features')?>
											</p>
										</a>
									</li>
									<?php endif ?>
									<?php if (module_active('_content')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/content')?>" class="nav-link<?=active_page('content', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-file-alt"></i>
											<p>
												<?=_lang('content')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
									<?php if (module_active('_gallery')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/gallery')?>" class="nav-link<?=active_page('gallery', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-play-circle"></i>
											<p>
												<?=_lang('gallery')?>
											</p>
										</a>
									</li>
									<?php endif ?> 
								</ul>
							</li>
							<?php endif?>  
							<?php if (module_active('dashboard')):?> 
							<li class="nav-item">
								<a href="<?=site_url('user')?>" class="nav-link<?=active_page('admin', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-user"></i>
									<p>
										<?=_lang('dashboard')?>  
									</p>
								</a>
							</li> 
							<?php endif ?> 
							<?php if (module_active('_analytics')):?> 
							<li class="nav-item">
								<a href="<?=site_url('admin/analytics')?>" class="nav-link<?=active_page('analytics', $_page_name??$page_name)?>">
									<i class="nav-icon fa fa-chart-line"></i>
									<p>
										<?=_lang('analytics')?>  
									</p>
								</a>
							</li> 
							<?php endif ?>  
  
							<div class="mt-2 border-top d-flex justify-content-left"> 
								<div class="h7 mt-2">
									GET STARTED
								</div>
							</div>

							<?php if (module_active('_updates') && $user['admin']>=3):?> 
							<li class="nav-item">
								<a href="<?=site_url('admin/updates')?>" class="nav-link<?=active_page('updates', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-box-open"></i>
									<p>
										Updates 
									</p>
								</a>
							</li> 
							<?php endif ?> 
							<li class="nav-item">
								<a href="https://toneflixcode.cf/hubboxx" class="nav-link">
									<i class="nav-icon fas fa-book"></i>
									<p>
										Documentation 
									</p>
								</a>
							</li> 
							<li class="nav-item">
								<a href="https://toneflixcode.cf/hubboxx" class="nav-link">
									<span class="nav-link-text text-sm">System Version: v<?=env('installation.version')?></span>
								</a>
							</li> 
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>
