<?php $error = false; ?> 

<?php if (phpversion() < "7.2" || 
    !extension_loaded('mysqli') || 
    !extension_loaded('gd') || 
    !extension_loaded('curl') || 
    !extension_loaded('json') || 
    !extension_loaded('intl') || 
    !extension_loaded('mbstring') || 
    !extension_loaded('zip') || 
    ini_get('allow_url_fopen') != "1" || 
    !is_really_writable($this->dot_env_path) || 
    !is_really_writable(ROOTPATH . 'writable/session') ||  
    !is_really_writable(ROOTPATH . 'public/sitemap') || 
    !is_really_writable(ROOTPATH . 'public/uploads')): 
    $error = true; 
?>
    <div class="text-center alert alert-danger">Please fix the requirements to begin Ourzobia PHP Installation</div>
<?php endif;?>

<h3>Server Requirements</h3>
<table class="table table-hover">
    <thead>
        <tr>
            <th><b>Requirements</b></th>
            <th><b>Result</b></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>PHP 7.2+ </td>
            <td>
                <?php if (phpversion() < "7.2"):?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-warning">Your PHP version is <?=phpversion()?></span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>v.<?=phpversion()?></span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>MySQLi PHP Extension</td>
            <td>
                <?php if (!extension_loaded('mysqli')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>GD PHP Extension</td>
            <td>
                <?php if (!extension_loaded('gd')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>CURL PHP Extension</td>
            <td>
                <?php if (!extension_loaded('curl')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>MBString PHP Extension</td>
            <td>
                <?php if (!extension_loaded('mbstring')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>JSON PHP Extension</td>
            <td>
                <?php if (!extension_loaded('json')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>INTL PHP Extension</td>
            <td>
                <?php if (!extension_loaded('intl')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Not enabled</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>Zip Extension</td>
            <td>
                <?php if (!extension_loaded('zip')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Zip Extension is not enabled!</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>Allow allow_url_fopen</td>
            <td>
                <?php if (ini_get('allow_url_fopen') != "1"): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">Allow_url_fopen is not enabled!</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>enabled</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>.env Writable</td>
            <td>
                <?php if (!is_really_writable($this->dot_env_path)): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">No (Make .env writable) - Permissions 755</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>OK</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>writable/session Writable</td>
            <td>
                <?php if (!is_really_writable(ROOTPATH . 'writable/session')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">No (Make writable/session writable) - Permissions - 755</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>OK</span>
                <?php endif;?>
            </td>
        </tr> 
        <tr>
            <td>public/sitemap Writable</td>
            <td>
                <?php if (!is_really_writable(ROOTPATH . 'public/sitemap')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">No (Make public/sitemap writable) - Permissions - 755</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>OK</span>
                <?php endif;?>
            </td>
        </tr>
        <tr>
            <td>public/uploads Writable</td>
            <td>
                <?php if (!is_really_writable(ROOTPATH . 'public/uploads')): ?>
                    <i class="fa fa-times-circle fa-sm text-danger"></i>
                    <span class="badge badge-danger">No (Make public/uploads writable) - Permissions - 755</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>OK</span>
                <?php endif;?>
            </td>
        </tr> 
        <tr>
            <td>app/Controllers/Install Writable</td>
            <td>
                <?php if (!is_really_writable(APPPATH . 'Controllers/Install')): ?>
                    <i class="fa fa-times-circle fa-sm text-warning"></i>
                    <span class="badge badge-warning text-left">No (optional, Make app/Controllers/Install including it's sub folders and files writable <br> else you would have to manually delete it after installation) - Permissions - 755</span>
                <?php else: ?>
                    <i class="fa fa-check-circle fa-sm text-success"></i>
                    <span class='badge badge-success'>OK</span>
                <?php endif;?>
            </td>
        </tr> 
    </tbody>
</table>
<hr />

<?php if ($error == false):?>
    <div class="text-right">
    <?=form_open(create_url(uri_string()))?>
    <?=form_hidden('requirements_success', 'true')?>
    <button type="submit" class="btn btn-primary">Database Setup</button>
    <?=form_close()?>
    </div>
<?php endif;?>
