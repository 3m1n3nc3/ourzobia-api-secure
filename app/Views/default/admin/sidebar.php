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
										Dashboard 
									</p>
								</a>
							</li>
							<?php endif ?> 
							<?php if (module_active('_users')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/users')?>" class="nav-link<?=active_page('users', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-users"></i>
									<p>
										Users 
									</p>
								</a>
							</li>
							<?php endif ?>  
							<?php if (module_active('_products')): ?>
							<li class="nav-item">
								<a href="<?=site_url('admin/products')?>" class="nav-link<?=active_page('products', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-box"></i>
									<p>
										Products 
									</p>
								</a>
							</li>
							<?php endif ?>   
							<?php if (logged_user('admin')>=3):?>
							<li class="nav-item has-treeview<?=active_page(['configuration','features','content', 'banks'], $_page_name??$page_name, false, 'menu-open')?>">
								<a href="#" class="nav-link<?=active_page(['configuration','features','content', 'banks'], $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-cog"></i>
									<p>
										Config
									</p>
								</a>
            					<ul class="nav nav-treeview"> 
									<?php if (module_active('_config')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/configuration')?>" class="nav-link<?=active_page('configuration', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-cog"></i>
											<p>
												Configuration
											</p>
										</a>
									</li>
									<?php endif ?> 
									<?php if (module_active('_features')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/features')?>" class="nav-link<?=active_page('features', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-image"></i>
											<p>
												Features
											</p>
										</a>
									</li>
									<?php endif ?>
									<?php if (module_active('_content')): ?>
									<li class="nav-item">
										<a href="<?=site_url('admin/content')?>" class="nav-link<?=active_page('content', $_page_name??$page_name)?>">
											<i class="nav-icon fas fa-file-alt"></i>
											<p>
												Content
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
										User Dashboard 
									</p>
								</a>
							</li> 
							<?php endif ?> 
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
						</ul>
					</nav>
					<!-- /.sidebar-menu -->
				</div>
				<!-- /.sidebar -->
			</aside>
