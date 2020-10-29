            <div class="p-3"></div> 

            <?php if (!empty($payment)): ?>
            <div class="lockscreen-name mt-3">
                <?=!empty($screen_name) ? $screen_name . (!empty($hub['hub_no']) ? "<span class=\"badge badge-warning\">".$hub['hub_no']."</span>" : "") : (!empty($user['fullname']) ? $user['fullname'] : 'Hi!')?> 
            </div> 
             
            <div class="lockscreen-item"> 
                <div class="lockscreen-image">
                    <i class="fa fa-check-circle fa-4x text-success"></i>
                </div>  
                <div class="lockscreen-credentials my-5">
                    <h5 class="d-flex flex-column justify-content-center">
                        <?=$message??'Payment Success!'?>
                    </h5>
                </div> 
            </div>  
            <div class="help-block text-center font-weight-bold">
                You can <a href="<?=$link??site_url("user/hubs/booked/{$payment['id']}")?>" class="text-success">View Item</a>
            </div>  
            <div class="text-center font-weight-bold">
                Or goto <a href="<?=site_url('user/payments')?>">Payments history</a>
            </div>  
            <?php else: ?>
            <div class="help-block text-center mx-1">
                <?php alert_notice('The requested resource was not found!', 'error', true, false, 'h2', null, 'h1')?>
            </div>
            <?php endif ?>

            <div class="m-3 p-3"></div>