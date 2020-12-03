            <?php if (!empty($hub)): ?>
            <div class="lockscreen-name">
                <?=!empty($screen_name) ? $screen_name . (!empty($hub['hub_no']) ? "<span class=\"badge badge-warning\">".$hub['hub_no']."</span>" : "") : (!empty($user['fullname']) ? $user['fullname'] : 'Hi!')?> 
            </div> 
             
            <div class="lockscreen-item"> 
                <div class="lockscreen-image">
                    <img src="<?=$creative->fetch_image(logged_user('avatar'), 'banner')?>" alt="">
                </div>  
                <div class="lockscreen-credentials my-5">
                    <div class="d-flex flex-column justify-content-center">
                        <?=show_countdown($hub['checkin_date'], 'WAIT', round(diff2hours($hub['checkout_date'], $hub['checkin_date'])), "Hours", "h2 text-success font-weight-bold") ?>
                        <img src="<?=qr_generator(site_url('user/hubs/booked/'.$hub['id']), 'Verified');?>" width="150px"/>
                    </div>
                </div> 
            </div>  
            <div class="help-block text-center">
                Booked by <?=fetch_user('fullname', $hub['uid'])?> for
                <div class="d-flex justify-content-center">
                    <strong>
                        <?=date("j M, Y \n h:i A", $hub['checkin_date'])?>
                    </strong>
                    &nbsp;to&nbsp;
                    <strong>
                        <?=date("j M, Y \n h:i A", $hub['checkout_date'])?>
                    </strong>
                    <?=form_open('', 'class="mx-0 px-0 no-print" method="post"')?>
                        <?=form_hidden('print', 1)?> 
                        <button class="mx-0 px-1 btn" title="Print This Page" data-toggle="tooltip"><i class="fa fa-print"></i></button>
                    <?=form_close()?>
                </div>
            </div>  
            <?php else: ?>
            <div class="help-block text-center mx-1">
                <?php alert_notice('The requested resource was not found!', 'error', true, false, 'h2', null, 'h1')?>
            </div>
            <?php endif ?>