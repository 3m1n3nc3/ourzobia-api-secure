<?php if ($notifications): ?>
    <div style="max-height: 300px; overflow-y: scroll;">
    <?php foreach ($notifications as $notification):
        $subject  = str_ireplace(['user_', '_user2', 'user_', '_paired'], ['','','','paired'], $notification->type);
        $userdata = $acc_data->fetch($notification->notifier_id, 1);
        $notifier_name   = ($userdata) ? fetch_user('fullname', $notification->notifier_id) : _lang('guest');
        $notifier_avatar = ($userdata) ? fetch_user('avatar_link', $notification->notifier_id) : $creative->fetch_image('guest', 'boy');
        ?>

        <a href="<?=$notification->url?>" class="dropdown-item">
            <!-- Notification Start -->
            <div class="media">
                <img src="<?=$notifier_avatar; ?>" alt="<?=$notifier_name?>" class="img-size-50 mr-3 img-circle">
                <!-- <i class="fas fa-envelope fa-2x mr-2"></i> -->
                <div class="media-body">
                    <h3 class="dropdown-item-title text-danger">
                        <?=_lang(''.$subject)?>
                    </h3>
                    <p class="text-sm">
                        <?php if ($notification->text): ?>
                        <?=$notification->text?> 
                        <?php else: ?>
                        <?=_lang('_'.$notification->type, [ucwords($notifier_name)])?> 
                        <?php endif ?>
                    </p>
                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> <?=timeAgo($notification->time)?></p>
                </div>
            </div>
            <!-- Notification End -->
        </a>
        <div class="dropdown-divider"></div>
    <?php endforeach; ?>
    </div>
<?php endif ?> 

<?php if (!$notifications): ?>
    <div class="dropdown-item text-center text-info">
        <i class="fas fa-bell-slash fa-5x mr-2"></i>
        <h5 class="text-danger">No Notifications</h5>
    </div>
<?php endif ?>
             
<?php if(module_active('account')): ?>
    <div class="dropdown-divider"></div>  
    <a href="<?=site_url('user/account/notifications')?>" class="dropdown-item dropdown-footer">All Notifications</a>
<?php endif ?>
