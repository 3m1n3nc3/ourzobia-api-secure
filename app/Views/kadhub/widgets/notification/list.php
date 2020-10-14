                                <?php if ($notifications): ?> 
                                    <?php foreach ($notifications as $notif):
                                        $subject  = str_ireplace(['user_', '_user2', 'user_', '_paired'], ['','','','paired'], $notif->type);
                                        $userdata = $acc_data->fetch($notif->notifier_id, 1)?>
                                        <li class="notification">
                                            <div class="media">
                                                <a class="user-status-avatar" href="<?=$userdata['profile_link'];?>"> 
                                                    <img class="img-radius" src="<?=$userdata['avatar_link'];?>" alt="<?=$userdata['fullname'];?> Image">
                                                </a>
                                                <div class="media-body">
                                                    <p>
                                                        <strong><a href="<?=$notif->url?>"><?=_lang(''.$subject)?></a></strong>
                                                        <span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>
                                                            <span class="user-status-timestamp" data-livestamp="<?=date(DATE_ATOM, $notif->time)?>">
                                                                <?=date(DATE_ATOM, $notif->time)?> 
                                                            </span>
                                                        </span>
                                                    </p>
                                                    <p>
                                                        <?php if ($notif->text): ?>
                                                        <?=$notif->text?> 
                                                        <?php else: ?>
                                                        <?=_lang(''.$notif->type, [ucfirst($userdata['username'])])?> 
                                                        <?php endif ?> 
                                                    </p>
                                                </div>
                                            </div>
                                        </li>  
                                    <?php endforeach; ?>
                                <?php endif ?> 

                                <?php if (!$notifications): ?>
                                    <div class="dropdown-item text-center text-info">
                                        <i class="fas fa-bell-slash fa-5x mr-2"></i>
                                        <h5 class="text-danger">No Notifications</h5>
                                    </div>
                                <?php endif ?> 