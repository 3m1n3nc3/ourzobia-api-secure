<div class="row"> 
    <div class="col-md-12">
        <div class="mb-3">
            <?=anchor('admin/users/create', "Create New User", ['class'=>'btn btn-primary'])?>
        </div>
        <div class="card"> 
            <div class="card-header"> 
                <div class="d-flex justify-content-between"> 
                    <h3 class="card-title"><?=$uid ? "Update User: " . fetch_user('username', $uid) : "Create Users"?></h3> 
                </div> 
            </div> 
            <div class="card-body">  

                <!-- /.tab-pane --> 
                <?=form_open('admin/users/create' . ($uid?'/'.$uid:''), 'class="form-horizontal"')?> 
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?=set_value('username', fetch_user('username', $uid)) ?>">
                            <?= $errors->showError('value.username', 'my_single_error'); ?> 
                            <small class="text-info">Username will form part of Cpanel Webmail email address.</small>
                        </div>
                    </div>   
                    <div class="form-group row">
                        <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="<?=set_value('fullname', fetch_user('fullname', $uid)) ?>">
                            <?= $errors->showError('value.fullname', 'my_single_error'); ?> 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?=set_value('email', fetch_user('email', $uid)) ?>">
                            <?= $errors->showError('value.email', 'my_single_error'); ?> 
                            <small class="text-info">Skip if you intend to generate Cpanel Webmail email address.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?=set_value('phone_number', fetch_user('phone_number', $uid)) ?>">
                            <?= $errors->showError('value.phone_number', 'my_single_error'); ?> 
                        </div>
                    </div>  

                    <?php if (fetch_user('uid', $uid)): ?>
                    <div class="form-group row"> 
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="status" id="status">
                            <?php for ($i=0; $i < 3; $i++): ?> 
                                <option value="<?=$i?>"<?=set_select('status', $i, ($i == fetch_user('status', $uid)))?>><?=$i?></option>  
                            <?php endfor; ?>
                            </select> 
                            <?= $errors->showError('value.status', 'my_single_error'); ?> 
                            <small class="text-muted"> Some levels are only available here for experimentation. </small>
                        </div>
                    </div> 
                    <?php endif ?>

                    <div class="form-group row"> 
                        <label for="admin" class="col-sm-2 col-form-label">Admin Level</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="admin" id="admin">
                            <?php for ($i=0; $i < 5; $i++):
                                    if (fetch_user('uid', $uid) == logged_user('uid') && fetch_user('admin', $uid) > $i) continue; 
                                    if ($i > logged_user('admin')) continue; ?> 
                                <option value="<?=$i?>"<?=set_select('admin', $i, ($i == fetch_user('admin', $uid)))?>><?=$i?></option>  
                            <?php endfor; ?>
                            </select> 
                            <?= $errors->showError('value.admin', 'my_single_error'); ?> 
                            <small class="text-muted"> Some levels are only available here for experimentation. </small>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <?php $password = $enc_lib->get_random_password(8,8,TRUE,TRUE,TRUE,TRUE)?>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=set_value('password') ?>" onkeyup="this.type==='text'?this.type='password':''"> 
                            <?= $errors->showError('value.password', 'my_single_error'); ?> 
                            <small class="text-muted">
                                <div class="d-none get_random_password" style="display: none;"><?=(!$uid) ? $password : ''?></div>
                                <span class="text-info">Default:</span> <a href="javascript:void(0)" class="text-danger dps" onclick="const pp = document.getElementById('password'); pp.type='text'; pp.value=this.innerHTML"><?=my_config('default_password')?></a> |-----|
                                <span class="text-info">Random:</span> <a href="javascript:void(0)" class="text-danger xps" onclick="const pp = document.getElementById('password'); pp.type='text'; pp.value=this.innerHTML"></a>
                            </small>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <button type="submit" class="btn btn-danger">Save</button>
                        </div>
                    </div>
                <?=form_close()?>  
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
        document.getElementById('password').value = document.querySelector('.dps').innerHTML;
    }
</script>