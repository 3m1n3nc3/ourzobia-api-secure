<!DOCTYPE html>
<html>
    <?=view('default/header'); ?> 
    <body class="hold-transition lockscreen">
        <!-- Automatic element centering -->
        <div class="lockscreen-wrapper<?=($screen!=='login')?' mt-3':''?>">
            <div class="lockscreen-logo">
                <a href="<?=site_url()?>">
                    <img src="<?=$creative->fetch_image(my_config('site_logo'), 'logo')?>" height="50px" alt="<?=my_config('site_name')?> Logo">
                </a>
                <h5><?=my_config('site_name')?></h5>
            </div>
            <!-- User name -->
            <?=load_widget('content/basic_' . $screen)?> 

            <div class="lockscreen-footer text-center"> 
                <strong>Copyright &copy; 2019-<?=date('Y')?> <a href="<?=base_url()?>"><?=my_config('site_name')?></a></strong> <br>
                All rights reserved.
            </div>
        </div> 
        <?=view('default/dashboard_footer'); echo set_value('print')?>
        <?php if (set_value('print')): ?>
        <script type="text/javascript"> 
          window.addEventListener("load", window.print());
        </script>
        <?php endif ?>
    </body>
</html>