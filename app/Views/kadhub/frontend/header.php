<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- favicon -->
    <link rel="icon" href="<?=$creative->fetch_image(my_config('favicon'), 'logo')?>"> 
    <?=!empty($metatags) ? $metatags . "\n" : ''?>
    <title><?=$page_title?> | <?=my_config('site_name')?></title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap" rel="stylesheet"> 
    <!-- Css Styles -->
    <link rel="stylesheet" href="<?=base_url('resources/theme/kadhub/styles/style.css')?>" type="text/css"> 
    <script>
        function link(path){
            var url = '<?=site_url()?>' + path;
            return url;
        }
        function base_link(path){
            var url = '<?=base_url()?>/' + path;
            return url;
        }

        CI_ENVIRONMENT  = '<?=env('CI_ENVIRONMENT', 'production')?>'; 
    </script>

    <?php if(my_config('google_analytics_key')): ?>
        <!-- Google Analytics -->
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', "<?=my_config('google_analytics_key')?>", 'auto');
            ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    <?php endif ?>
</head>
