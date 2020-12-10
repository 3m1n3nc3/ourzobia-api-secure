        <div class="card p-1">  
            <span class="text-info text-center small">
                <?=fetch_user('enterprise_mail', user_id())?></span>
            </span> 
        </div>

        <a href="<?=site_url('mail/compose')?>" class="btn btn-primary btn-block mb-3">Compose</a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Folders</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <?php if ($folders): ?>
                        <?php foreach ($folders as $key => $folder): 
                            $folder_name = explode('.', $folder['shortpath'])[1]??explode('.', $folder['shortpath'])[0];?>
                        <!-- <li class="nav-item active"> -->
                        <li class="nav-item">
                            <a href="<?=site_url('mail/hub/folder/' .base64_url($folder['fullpath']) . '/?hash=' . csrf_hash())?>" class="nav-link<?=active_page(strtolower($folder_name), $curr_folder??'')?>">
                                <i class="<?=folder_icon($folder_name)?>"></i> <?=$folder_name?>
                                <!-- <span class="badge bg-primary float-right">12</span> -->
                            </a>
                        </li>
                        <?php endforeach ?>
                    <?php endif ?> 
                </ul>
            </div>
            <!-- /.card-body -->
        </div>

        <!-- /.Labels -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Labels</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-danger"></i>
                            Important
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-warning"></i> Promotions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="far fa-circle text-primary"></i>
                            Social
                        </a>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->
        </div> 
        <?php if (logged_user('cpanel')): ?>
        <button class="btn btn-sm font-weight-bold btn-success btn-block" id="webmail-login-btn">
            <span class='fa-stack'>
                <i class='fas fa-circle fa-stack-2x'></i>
                <i class='fab fa-cpanel fa-stack-1x fa-inverse text-danger'></i>
            </span>
            Webmail Login
        </button> 
            <?php if (my_config('afterlogic_domain')): ?>
        <button class="btn btn-info btn-block text-sm font-weight-bold" id="al-login-btn" onclick="window.location.href = '<?=my_config('afterlogic_protocol') . '://' . my_config('afterlogic_domain')?>'">
            <span class='fa-stack'>
                <i class='fas fa-circle fa-stack-2x'></i> 
                <img class='fa-stack-1x fa-inverse text-danger' src="<?=base_url('resources/img/alogic.svg')?>" style="height: 20px;">
            </span>
            AfterLogic Webmail
        </button> 
            <?php endif; ?>
        <?php endif; ?>