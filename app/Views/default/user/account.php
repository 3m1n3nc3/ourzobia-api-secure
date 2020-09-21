<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="<?=fetch_user('avatar_link', $uid)?>" alt="<?=fetch_user('fullname', $uid)?> profile picture">
                </div>
                <h3 class="profile-username text-center"><?=fetch_user('fullname', $uid)?></h3>
                <!-- <p class="text-muted text-center"></p> -->
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>All Products</b> <a class="float-right"><?=$statistics['all_products']??0?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Active Products</b> <a class="float-right"><?=$statistics['active_products']??0?></a>
                    </li> 
                </ul> 
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

                        <?=form_open('user/account/settings', 'class="form-horizontal"')?>
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
                                    <?php $password = $enc_lib->get_random_password(8,8,TRUE,TRUE,TRUE,TRUE)?>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=set_value('password') ?>" onkeyup="this.type==='text'?this.type='password':''"> 
                                    <small class="text-muted"><span class="text-info">Default:</span> <a href="javascript:void(0)" onclick="const pp = document.getElementById('password'); pp.type='text'; pp.value=this.innerHTML"><?=$password?></a></small>
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