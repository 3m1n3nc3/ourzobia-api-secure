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
										Dashboard 
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
										<?=ucwords($profile['firstname']) . '\'s'?> Account 
										<?php else: ?>  
										My Account 
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
										<?=ucwords($profile['firstname']) . '\'s'?> Products 
										<?php else: ?>  
										My Products 
										<?php endif ?>  
									</p>
								</a>
							</li>
							<?php endif ?>    
							<?php if (module_active('_dashboard')):?> 
							<li class="nav-item">
								<a href="<?=site_url('admin')?>" class="nav-link<?=active_page('admin', $_page_name??$page_name)?>">
									<i class="nav-icon fas fa-user-secret"></i>
									<p>
										Admin Dashboard 
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
