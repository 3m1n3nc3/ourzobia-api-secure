<!DOCTYPE html> 
<html lang="en"> 
 	<!-- Header -->
	<?=view('default/header'); ?>

	<body class="hold-transition sidebar-mini<?=my_config('des_fixed_layout').my_config('des_body_small_text').my_config('des_accent_color_variant')?>">
		<div class="wrapper">

			<!-- Navbar -->
			<?=view('default/navbar'); ?>

			<!-- Main Sidebar Container -->
			<?=view('default/' . (!empty($set_folder) ? $set_folder : '') . 'sidebar'); ?>

			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<div class="content-header">
					<div class="container-fluid">
						<div class="row mb-2">
							<div class="col-sm-6">
								<h1 class="m-0 text-dark"><?=$page_title?></h1>
								</div><!-- /.col -->
								<div class="col-sm-6">
									<ol class="breadcrumb float-sm-right">
										<li class="breadcrumb-item"><a href="#">Home</a></li>
										<li class="breadcrumb-item active"><?=$page_title?></li>
									</ol>
								</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.container-fluid -->
				</div>
				<!-- /.content-header -->

				<!-- Main content -->
				<div class="content">
					<div class="container-fluid pb-5"> 
						<div class="general_notice">
						<?=$session->getTempdata('notice');?>
						<?=$session->getFlashdata('notice');?>
						</div>
						<?=view('default/' . (!empty($set_folder) ? $set_folder : '') . $page_name); ?>
					</div><!-- /.container-fluid -->
				</div> 
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
	</body>
</html>
