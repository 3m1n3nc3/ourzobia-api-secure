	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<title><?=$page_title?> | <?=my_config('site_name')?></title>
        <!-- favicon -->
        <link rel="icon" href="<?=$creative->fetch_image(my_config('favicon'), 'logo')?>"> 
        <!-- Meta Tags -->
        <?=!empty($metatags) ? $metatags . "\n" : ''?>
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
		<!-- Font Awesome Icons -->
		<link rel="stylesheet" href="<?=base_url('resources/plugins/fontawesome-free/css/all.min.css')?>">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?=base_url('resources/distr/css/adminlte.min.css')?>">
        <link rel="stylesheet" href="<?=base_url('resources/css/excerpts.css')?>">
        <link rel="stylesheet" href="<?=base_url('resources/plugins/daterangepicker/daterangepicker.css')?>">
		<!-- Icheck Bootstrap -->
		<link rel="stylesheet" href="<?=base_url('resources/plugins/icheck-bootstrap/icheck-bootstrap.css')?>">
		<!-- component-spinners -->
		<link rel="stylesheet" href="<?=base_url('resources/css/component-spinners.css')?>">
		<!-- Ourzobia -->
		<link rel="stylesheet" href="<?=base_url('resources/css/ourzobia.style.css')?>">
		<link rel="stylesheet" href="<?=base_url('resources/plugins/toastr/toastr.min.css')?>"> 
        <link rel="stylesheet" href="<?=base_url('resources/plugins/plyr/plyr.css')?>"> 
        <!-- feather icon-->
        <link rel="stylesheet" href="<?=base_url('resources/fonts/feather/css/feather.css')?>">
		<!-- Croppie -->
		<link rel="stylesheet" href="<?=base_url('resources/plugins/image-uploader/croppie.css')?>">
		<link rel="stylesheet" href="<?=base_url('resources/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?>">
        <!-- Jodit text editor -->
        <link rel="stylesheet" href="<?= base_url('resources/plugins/jodit/jodit.css'); ?>">
    <!-- Datatables -->
    <?php if (isset($has_table) && $has_table): ?>
        <link rel="stylesheet" href="<?php echo base_url('resources/plugins/datatables-bs4/css/dataTables.bootstrap4.css'); ?>">
    <?php endif ?>
		<script>
            function link(path){
                var url = '<?=site_url()?>' + path;
                return url;
            }
            function base_link(path){
                var url = '<?=base_url()?>/' + path;
                return url;
            }

            function is_logged() {
                return '<?=$account_data->logged_in()?>';
            }

            CI_ENVIRONMENT  = '<?=env('CI_ENVIRONMENT', 'production')?>'; 
            preloader = '<div class="d-flex justify-content-center" id="preloader"><div class="spinner-grow text-warning"></div></div>';
            segment   = 'user';
		</script>
        <?= $util->statsJsVars(true); ?>
	</head>
