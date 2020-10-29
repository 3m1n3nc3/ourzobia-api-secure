<?php 
    $param      = ['recipient_id' => user_id(), 'type' => 'all', 'page' => NULL];
    $notif_list = $ntfn->getNotifications($param); 
?>  
            <?php if ($notif_list): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tbody>
                        <?php foreach ($notif_list as $key => $notification): 
                            $ntfn->setSeen($notification->type);
                            $subject  = str_ireplace(['user_', '_user2', 'user_', '_paired'], ['','','','paired'], $notification->type);
                            $userdata = $acc_data->fetch($notification->notifier_id, 1)?>
                            <tr class="unread">
                                <td>
                                    <?=load_widget('avatar',['profile'=>$userdata])?> 
                                </td>
                                <td>
                                    <a href="<?=$notification->url?>">
                                        <h6 class="mb-1"><?=_lang(''.$subject)?></h6>
                                        <p class="m-0 text-secondary">
                                            <?php if ($notification->text): ?>
                                            <?=nl2br(word_wrap($notification->text, 55));?> 
                                            <?php else: ?>
                                            <?=nl2br(word_wrap(_lang(''.$notification->type, [ucfirst($userdata['username'])]), 55));?> 
                                            <?php endif ?> 
                                        </p>
                                    </a>
                                </td>
                                <td>
                                    <h6 class="text-muted"><i class="fas fa-circle <?=$notification->seen?'text-c-red':'text-c-green'?> f-10 m-r-15"></i><?=ucwords(date('d M H:i',$notification->time))?></h6>
                                </td>
                                <td> 
                                    <a href="#!" class="label theme-bg text-white f-12">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach ?>  
                        </tbody>
                    </table>
                </div> 
            <?php else: ?>
                <div class="text-center text-info">
                    <i class="fas fa-bell-slash fa-5x mr-2"></i>
                    <h5 class="text-danger">No Notifications</h5>
                </div>
            <?php endif ?>