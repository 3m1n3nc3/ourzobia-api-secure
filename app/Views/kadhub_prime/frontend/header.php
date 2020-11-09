<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?=$page_title?> | <?=my_config('site_name')?></title>
    <!-- favicon -->
    <link rel="icon" href="<?=$creative->fetch_image(my_config('favicon'), 'logo')?>"> 
    <!-- Meta Tags -->
    <?=!empty($metatags) ? $metatags . "\n" : ''?>
 
    <link rel="stylesheet" href="<?=base_url('resources/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/plugins/fontawesome-free/css/all.min.css')?>"> 
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/menu_sideslide.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/line-icons.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/owl.carousel.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/owl.theme.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/nivo-lightbox.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/magnific-popup.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/animate.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/main.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/responsive.css')?>"> 
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/extra.css')?>">
    
    <link rel="stylesheet" href="<?=base_url('resources/plugins/plyr/plyr.css')?>"> 
  
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub_prime/css/colors/preset.css')?>">
    <link rel="stylesheet" href="<?=base_url('resources/distr/css/color-theme.css')?>">
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
        segment   = 'frontend';
    </script>
</head>