<div class="row"> 
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?=fetch_user('avatar_link', $uid)?>" alt="<?=fetch_user('fullname', $uid)?> profile picture">
                </div>
                <h3 class="profile-username text-center"><?=fetch_user('fullname', $uid)?></h3>
                <?php if (fetch_user('cpanel', $uid)): ?>
                <h7 class="text-muted text-center"><?=fetch_user('username', $uid) . '@' . my_config('cpanel_domain')?></h7> 
                <?php endif?>
                <!-- <p class="text-muted text-center"></p> -->
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>All Products</b> <a class="float-right"><?=$statistics['all_products']??0?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Active Products</b> <a class="float-right"><?=$statistics['active_products']??0?></a>
                    </li> 
                </ul> 
                <?php if (user_id() === user_id($uid) && fetch_user('cpanel')): ?>
                <button class="btn btn-sm btn-success btn-block" id="webmail-login-btn">
                    <span class='fa-stack'>
                        <i class='fas fa-circle fa-stack-2x'></i>
                        <i class='fab fa-cpanel fa-stack-1x fa-inverse text-danger'></i>
                    </span>
                    Webmail Login
                </button> 
                    <?php if (my_config('afterlogic_domain')): ?>
                <button class="btn btn-info btn-block text-sm" id="al-login-btn" onclick="window.location.href = '<?=my_config('afterlogic_protocol') . '://' . my_config('afterlogic_domain')?>'"> 
                    AfterLogic Webmail
                </button> 
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card --> 
    </div>
    <!-- /.col -->

    <div class="col-md-9"> 
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills"> 
                    <li class="nav-item">
                        <a class="nav-link<?=active_page('settings', $_page_name??$page_name)?>" href="#settings" data-toggle="tab">Settings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?=active_page('profile', $_page_name??$page_name)?>" href="#profile" data-toggle="tab">Profile</a>
                    </li>
                    <?php if (user_id() === user_id($uid)): ?>
                    <li class="nav-item">
                        <a class="nav-link<?=active_page('notifications', $_page_name??$page_name)?>" href="#notifications" data-toggle="tab">Notification</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.card-header -->

            <div class="card-body"> 

                <div class="tab-content"> 
                    <!-- /.tab-pane -->
                    <div class="tab-pane<?=active_page('settings', $_page_name??$page_name)?>" id="settings">

                        <?=load_widget('avatar_upload', ['uid'=>$uid])?> 

                        <?=form_open('user/account/settings' . ($uid?'/'.$uid:''), 'class="form-horizontal"')?>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <label for="inputName" class="text-muted"><?=fetch_user('username', $uid)?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="<?=set_value('fullname', fetch_user('fullname', $uid)) ?>">
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?=set_value('email', fetch_user('email', $uid)) ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?=set_value('phone_number', fetch_user('phone_number', $uid)) ?>">
                                </div>
                            </div> 
                            <?php if (logged_user('admin')): ?>  
                            <div class="form-group row">
                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10"> 
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=set_value('password') ?>" onkeyup="this.type==='text'?this.type='password':''"> 
                                    <small class="text-muted">
                                        <div class="d-none get_random_password" style="display: none;"><?=$enc_lib->get_random_password(10,12,TRUE,TRUE,TRUE,TRUE)?></div>
                                        <span class="text-info">Default:</span> 
                                        <a href="javascript:void(0)" class="text-danger dps" onclick="const pp = document.getElementById('password'); pp.type='text'; pp.value=this.innerHTML">
                                            <?=my_config('default_password')?> 
                                        </a> 
                                        |-----|
                                        <span class="text-info">Random:</span> 
                                        <a href="javascript:void(0)" class="text-danger xps" onclick="const pp = document.getElementById('password'); pp.type='text'; pp.value=this.innerHTML"> 
                                        </a>
                                    </small>
                                </div>
                            </div>  
                            <?php endif ?>
                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <button type="submit" class="btn btn-danger">Save</button>
                                </div>
                            </div>
                        <?=form_close()?>
                    </div>
                    <!-- /.tab-pane -->

                    <div class="tab-pane<?=active_page('profile', $_page_name??$page_name)?>" id="profile"> 

                        <div class="form-horizontal">
                            <div class="form-group row">
                                <label for="usernameLabel" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <label id="usernameLabel" class="text-muted"><?=fetch_user('username', $uid)?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fullnameLabel" class="col-sm-2 col-form-label">Fullname</label>
                                <div class="col-sm-10">
                                    <label id="fullnameLabel" class="text-muted"><?=fetch_user('fullname', $uid)?></label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="emailLabel" class="col-sm-2 col-form-label">Email Address</label>
                                <div class="col-sm-10">
                                    <label id="emailLabel" class="text-muted"><?=fetch_user('email', $uid)?></label>
                                </div>
                            </div>  
                            <?php if (fetch_user('cpanel', $uid)): ?>
                            <div class="form-group row">
                                <label for="emailLabel" class="col-sm-2 col-form-label">Webmail Address</label>
                                <div class="col-sm-10">
                                    <label id="emailLabel" class="text-muted"><?=fetch_user('username', $uid) . '@' . my_config('cpanel_domain')?></label>
                                </div>
                            </div>  
                            <?php endif ?>
                            <div class="form-group row">
                                <label for="phoneLabel" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-sm-10">
                                    <label id="phoneLabel" class="text-muted"><?=fetch_user('phone_number', $uid)?></label>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <!-- /.tab-pane -->

                    <?php if (user_id() === user_id($uid)): ?>
                    <div class="tab-pane<?=active_page('notifications', $_page_name??$page_name)?>" id="notifications"> 
                        <?=load_widget('notification/box')?> 
                    </div>
                    <?php endif; ?>
                </div>
            <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<script type="text/javascript"> 
    window.onload = function() { 
        document.querySelector('.xps').innerHTML = document.querySelector('.get_random_password').innerHTML;
        
        <?php if (!fetch_user('password', $uid)): ?>
            document.getElementById('password').value = document.querySelector('.dps').innerHTML;
        <?php endif; ?>

        if (is_logged()) {
            $('#webmail-login-btn').click(function() {
                
                var $this = $(this);
                
                $this.buttonLoader('start');

                $.post(link('connect/access_webmail/'+<?=logged_user('uid')?>), function(data) {
                    
                    $this.buttonLoader('stop'); 
                    show_toastr(data.message, data.status);  
                    
                    if (data.success === true) {
                        $form = $("<form></form>");
                        $form.attr({action: data.host, target: '_blank', id: 'webmail-login', method: 'post'})
                            .append('<input type="hidden" name="session" value="'+data.session+'">');
                        $('body').append($form);
                        $('form#webmail-login').submit();
                    }
                });
            });
        }
    }
</script>