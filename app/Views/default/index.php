<!DOCTYPE html> 
<html lang="en">
 	<!-- Header -->
	<?=view('default/header', ['show_stats' => $show_stats??false]); ?>

	<body class="hold-transition sidebar-mini<?=(!empty($custom_skin) ? " custom-theme" : "") . my_config('des_fixed_layout').my_config('des_body_small_text').my_config('des_accent_color_variant').my_config('des_dark_mode')?>" data-payment_host="<?=site_url('ajax/payments')?>">
		<div class="wrapper"> 
			<!-- Navbar -->
			<?=view('default/navbar'); ?>

			<!-- Main Sidebar Container -->
			<?=view('default/' . (!empty($set_folder) ? $set_folder : '') . 'sidebar'); ?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0"><?=$page_title;?></h1>
								</div><!-- /.col -->
								<div class="col-sm-6">
									<ol class="breadcrumb float-sm-right">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item active"><?=$page_title?></li>
									</ol>
								</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</section>
				<!-- /.content-header -->

				<!-- Main content -->
				<section class="content">
					<div class="container-fluid pb-5"> 
						<div class="general_notice">
						<?=$session->getTempdata('notice');?>
						<?=$session->getFlashdata('notice');?>
						</div>
						<?=view('default/' . (!empty($set_folder) ? $set_folder : '') . $page_name); ?>
					</div><!-- /.container-fluid -->
				</section> 
				<!-- /.content -->
			</div>
			<!-- /.content-wrapper -->

			<!-- Control Sidebar -->
			<?=view('default/admin/control_sidebar'); ?>

			<!-- Main Footer -->
			<?=view('default/main_footer'); ?>

		</div>
		<!-- ./wrapper -->

		<!-- Footer Content -->
		<?=view('default/dashboard_footer'); ?>
		<?php //=load_widget('content/js_payment_processor_widget', ['load' => 1])?> 
	</body>
</html>
