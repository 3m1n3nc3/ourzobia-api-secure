<div class="row"> 
    <div class="col-md-12">
        <div class="card"> 
            <div class="card-header border-0"> 
                <div class="d-flex justify-content-between"> 
                    <h3 class="card-title">Create Users</h3> 
                </div> 
            </div> 
            <div class="card-body">  

                <!-- /.tab-pane --> 
                <?=form_open('admin/users/create', 'class="form-horizontal"')?> 
                    <div class="form-group row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?=set_value('username') ?>">
                            <small class="text-info">Username will form part of Cpanel Webmail email address.</small>
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="fullname" class="col-sm-2 col-form-label">Fullname</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="<?=set_value('fullname') ?>">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?=set_value('email') ?>">
                            <small class="text-info">Skip if you intend to generate Cpanel Webmail email address.</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="phone_number" class="col-sm-2 col-form-label">Phone Number</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number" value="<?=set_value('phone_number') ?>">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <?php $password = $enc_lib->get_random_password(8,8,TRUE,TRUE,TRUE,TRUE)?>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=set_value('password') ?>" onkeyup="this.type==='text'?this.type='password':''"> 
                            <small class="text-muted">
                                <div class="d-none get_random_password" style="display: none;"><?=$password?></div>
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