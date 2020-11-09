<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Ourzobia PHP Installer</title>
        <link rel="icon" href="<?=$creative->fetch_image('logo', 'logo')?>"> 
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?=create_url('resources/plugins/fontawesome-free/css/all.min.css')?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?=create_url('resources/distr/css/adminlte.min.css')?>">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    </head>
    <body class="sidebar-mini layout-fixed">
        <div class="wrapper">  
            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-light-success elevation-4">
                <!-- Brand Logo -->
                <a href="<?=create_url()?>" class="brand-link text-sm">
                    <img src="<?=$creative->fetch_image('logo', 'logo')?>" alt="Ourzobia Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                    <span class="brand-text font-weight-light">Installer</span>
                </a>
                <!-- Sidebar -->
                <div class="sidebar"> 
                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false"> 
                            <li class="nav-item">
                                <a href="#" class="nav-link disabled<?=active_page(true, ($progressing[1] == true || $progress == 1))?>">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Requirements
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mt-1">
                                <a href="#" class="nav-link disabled<?=active_page(true, ($progressing[2] || $progress == 2))?>">
                                    <i class="nav-icon fas fa-database"></i>
                                    <p>
                                        Database
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mt-1">
                                <a href="#" class="nav-link disabled<?=active_page(true, ($progressing[3] || $progress == 3))?>">
                                    <i class="nav-icon fas fa-download"></i>
                                    <p>
                                        Install
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item mt-1">
                                <a href="#" class="nav-link disabled<?=active_page(true, ($progress == 4))?>">
                                    <i class="nav-icon fas fa-thumbs-up"></i>
                                    <p>
                                        Finalize
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper text-sm">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark">Ourzobia PHP Installer</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="<?=create_url('install/start')?>">Installer</a></li>
                                    <?php if ($progress == 1): ?>
                                        <li class="breadcrumb-item active">Requirements</li>
                                    <?php elseif ($progress == 2): ?>
                                        <li class="breadcrumb-item active">Database</li> 
                                    <?php elseif ($progress == 3): ?>
                                        <li class="breadcrumb-item active">Install</li>
                                    <?php elseif ($progress == 4): ?>
                                        <li class="breadcrumb-item active">Finalize</li>
                                    <?php endif ?>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        
                        <?php if (isset($debug) && $debug != ''): ?>
                            <div class="alert alert-info"><?=$debug; ?></div>
                        <?php endif ?>

                        <?php if (isset($error) && $error != ''):?>
                            <div class="alert alert-danger text-left">
                                <?php echo $error; ?>
                            </div>
                        <?php endif ?>

                        <div class="row"> 
                            <!-- /.col-md-6 -->
                            <div class="col-lg-12">
                                <div class="card"> 
                                    <div class="card-body"> 
                                        <?php if ($progress == 1) include_once('requirements.php'); ?>

                                        <?php if ($progress == 2):?>
                                            <?=form_open(create_url(uri_string()));?>
                                            <?php echo form_hidden('step', $progress); ?>
                                            <div class="form-group">
                                                <label for="hostname" class="control-label">MySQL Hostname</label>
                                                <input type="text" class="form-control" name="hostname" value="<?=set_value('hostname')?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="database" class="control-label">Database Name</label>
                                                <input type="text" class="form-control" name="database" value="<?=set_value('database')?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="username" class="control-label">Database Username</label>
                                                <input type="text" class="form-control" name="username" value="<?=set_value('username')?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="control-label">Database Password</label>
                                                <input type="password" class="form-control" name="password" value="<?=set_value('password')?>">
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Check Database</button>
                                            </div>
                                            <?=form_close();?>
                                        <?php elseif ($progress == 3):?>
                                            <?=form_open(create_url(uri_string())); ?>
                                            <?=form_hidden('step', $progress); ?>
                                            <h3>Super Admin User Details</h3>
                                            <div class="form-group">
                                                <label for="admin_email" class="control-label">Email (Login Username)</label>
                                                <input type="email" class="form-control" name="admin_email" id="admin_email">
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_password" class="control-label">Password</label> 
                                                <input type="password" class="form-control" name="admin_password" id="admin_password">
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_passwordr" class="control-label">Confirm Password</label>
                                                <input type="password" class="form-control" name="admin_passwordr" id="admin_passwordr">
                                            </div>
                                            <div class="text-right">
                                                <button type="submit" class="btn btn-primary">Begin Installation</button>
                                            </div>
                                            <?=form_close(); ?>
                                        <?php elseif ($progress == 4):?>
                                            <h4 class="bold">Installation Complete!</h4>
                                            <p>
                                                Due to security reasons you must delete the installation directory.
                                            </p>
                                            <div class="mb-5">
                                                <?=anchor(create_url('install/start/delete_install_dir'), 'Delete Installation Directory', ['class'=>'btn btn-danger']); ?> 
                                                <?=anchor(create_url('admin/dashboard'), 'Goto Admin Dashboard', ['class'=>'btn btn-success']); ?> 
                                                <?=anchor(create_url('user/dashboard'), 'Goto User Dashboard', ['class'=>'btn btn-success']); ?> 
                                            </div> 
                                            <p>
                                                <b>Please note that Ourzobia PHP has two dashboards - </b>
                                            </p>
                                            <ul style="list-style: disc; margin-left: 15px;">
                                                <li>
                                                    <span style="color: #0084B4; padding-right: 5px;">
                                                        <?php echo create_url('admin/dashboard'); ?></span> Admin Dashboard : this dashboard is used to manage all aspects of your site.
                                                </li>
                                                <li>
                                                    <span style="color: #0084B4; padding-right: 5px;">
                                                        <?php echo create_url('user/dashboard'); ?></span> User Dashboard : this dashboard is where a user can manage their account and transactions.
                                                </li>
                                            </ul>
                                        <?php endif;?>
                                    </div>
                                </div> 
                            </div>
                            <!-- /.col-md-6 -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper --> 
            <!-- Main Footer -->
            <footer class="main-footer text-sm">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    v<?=env('installation.version')?>
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2020 <a href="http://ourzobiaphp.cf">Ourzobia PHP</a>.</strong> All rights reserved.
            </footer>
        </div>
        <!-- ./wrapper -->
        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?=create_url('resources/plugins/jquery/jquery.min.js')?>"></script>
        <!-- Bootstrap 4 -->
        <script src="<?=create_url('resources/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
        <!-- AdminLTE App -->
        <script src="<?=create_url('resources/distr/js/adminlte.min.js')?>"></script>
    </body>
</html>