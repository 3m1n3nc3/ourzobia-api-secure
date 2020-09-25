<?php $switch = ($request->getPost() ? 1 : null) ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="float-right card-title text-gray">
                <?= ucwords($step ? $step . ' ' . 'Configuration' : ''); ?>
                </h5>
                <h5 class="card-title">
                <i class="text-gray fa fa-cogs"></i> Site Configuration
                </h5>
                <!-- <h7 class="title text-info"></h7> -->
            </div>
            <div class="card-body">
                <div class="collections container">
                    <?php $switch = ($request->getPost() ? 1 : null) ?>
                    <?= form_open_multipart(uri_string(), ['id' => 'paform', 'class' => 'needs-validation', 'novalidate' => null]); ?>
                    <div class="send-button border-bottom border-danger my-2">
                        <?php if ($step !== 'main'): ?>
                        <a href="<?= site_url('admin/configuration/main')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-home"></i> Main Configuration
                        </a>
                        <?php endif; ?>

                        <?php if ($step !== 'payment'): ?>
                        <a href="<?= site_url('admin/configuration/payment')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-credit-card"></i> Payment Settings
                        </a> 
                        <?php endif; ?> 

                        <?php if ($step !== 'contact'): ?>
                        <a href="<?= site_url('admin/configuration/contact')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-map"></i> Contact Settings
                        </a>
                        <?php endif; ?>

                        <?php if ($step !== 'design'): ?>
                        <a href="<?= site_url('admin/configuration/design')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-palette"></i> Design
                        </a>
                        <?php endif; ?>

                        <?php if ($step !== 'system'): ?>
                        <a href="<?= site_url('admin/configuration/system')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-desktop"></i> System
                        </a>
                        <?php endif; ?>  
                    </div>

                    <?php if ($enable_steps && $step === 'main'): ?>
                    <input type="hidden" name="step" value="main">
                    <label class="font-weight-bold" for="basic_block">Main Configuration</label>
                    <hr class="my-0">
                    <div class="form-row p-3 mb-3" id="basic_block">
                        <div class="form-group col-md-6">
                            <label class="text-info" for="site_name">Site Name</label>
                            <input type="text" name="value[site_name]" value="<?= set_value('value[site_name]', my_config('site_name')) ?>" class="form-control" >
                            <small class="text-muted">The name of this website</small>
                            <?= $errors->showError('value.site_name', 'my_single_error'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="show_link_back">Show Link Back</label>
                                <select id="show_link_back" name="value[show_link_back]" class="form-control" required>
                                    <option value="0" <?= set_select('value[show_link_back]', '0', int_bool(my_config('show_link_back') == 0))?>>Hide
                                    </option>
                                    <option value="1" <?= set_select('value[show_link_back]', '1', int_bool(my_config('show_link_back') == 1))?>>Show
                                    </option>
                                </select>
                                <small class="text-muted">
                                The public facing section of this software has been designed by Colorlib and licensed under CC BY 3.0, You can choose to show or hide the credits.
                                </small>
                                <?= $errors->showError('value.show_link_back', 'my_single_error'); ?>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="form-row p-3 mb-3" id="graphics_block">

                        <div class="row col-md-6">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="site_logo">Site Logo</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="site_logo" class="custom-file-input" id="site_logo">
                                        <label class="custom-file-label" for="site_logo">Choose file</label>
                                    </div>
                                </div>
                                <small class="text-muted">The logo of this website</small>
                                <?=$creative->upload_errors('site_logo', '<span class="text-danger">', '</span>')?>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-info text-sm" for="logo_preview">Logo Preview</label><br>
                                <a href="<?=site_url('admin/configuration/main/remove?q=logo_preview#graphics_block')?>" class="float-left hover shadow m-2 px-2 rounded pt-1"><i class="fa fa-times fa-lg text-danger"></i></a>
                                <img src="<?= $creative->fetch_image(my_config('site_logo'), 'logo'); ?>" style="max-height: 50px;" id="logo_preview">
                            </div>
                        </div>

                        <div class="row col-md-6">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="favicon">Site Favicon</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="favicon" class="custom-file-input" id="favicon">
                                        <label class="custom-file-label" for="favicon">Choose file</label>
                                    </div>
                                </div>
                                <small class="text-muted">The favicon of this website</small>
                                <?=$creative->upload_errors('favicon', '<span class="text-danger">', '</span>')?>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-info text-sm" for="logo_preview">Favicon Preview</label><br>
                                <a href="<?=site_url('admin/configuration/main/remove?q=favicon#graphics_block')?>" class="float-left hover shadow m-2 px-2 rounded pt-1"><i class="fa fa-times fa-lg text-danger"></i></a>
                                <img src="<?= $creative->fetch_image(my_config('favicon'), 'logo'); ?>" style="max-height: 50px;" id="logo_preview">
                            </div>
                        </div>

                        <div class="row col-md-6">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="main_banner">Main Banner</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="main_banner" class="custom-file-input" id="main_banner">
                                        <label class="custom-file-label" for="main_banner">Choose file</label>
                                    </div>
                                </div>
                                <small class="text-muted">The main banner on the front page</small>
                                <?=$creative->upload_errors('main_banner', '<span class="text-danger">', '</span>')?>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-info text-sm" for="main_banner">Main Banner Preview</label><br>
                                <a href="<?=site_url('admin/configuration/main/remove?q=main_banner#graphics_block')?>" class="float-left hover shadow m-2 px-2 rounded pt-1"><i class="fa fa-times fa-lg text-danger"></i></a>
                                <img src="<?=$creative->fetch_image(my_config('main_banner'), 'banner');?>" style="max-height: 50px;" id="main_banner">
                            </div>
                        </div> 

                        <div class="row col-md-6">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="default_banner">Default Banner</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="default_banner" class="custom-file-input" id="default_banner">
                                        <label class="custom-file-label" for="default_banner">Choose file</label>
                                    </div>
                                </div>
                                <small class="text-muted">Banner shown when a missing banner is requested</small>
                                <?=$creative->upload_errors('default_banner', '<span class="text-danger">', '</span>')?>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="text-info text-sm" for="default_banner">Default Banner Preview</label><br>
                                <a href="<?=site_url('admin/configuration/main/remove?q=default_banner#graphics_block')?>" class="float-left hover shadow m-2 px-2 rounded pt-1"><i class="fa fa-times fa-lg text-danger"></i></a>
                                <img src="<?=$creative->fetch_image(my_config('default_banner'), 'banner');?>" style="max-height: 50px;" id="default_banner">
                            </div>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="form-row p-3 mb-3" id="api_block"> 
                        <div class="form-group col-md-6">
                            <label class="text-info" for="google_analytics_key">Google Analytics Key</label>
                            <input type="text" name="value[google_analytics_key]" value="<?= set_value('value[google_analytics_key]', my_config('google_analytics_key')) ?>" class="form-control" >
                            <small class="text-muted">Setting this value automatically enables google analytics, get your keys from <a href="https://analytics.google.com">https://analytics.google.com</a></small>
                            <?= $errors->showError('value.google_analytics_key', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="tawk_id">Tawk.to Property ID</label>
                            <input type="text" name="value[tawk_id]" value="<?= set_value('value[tawk_id]', my_config('tawk_id')) ?>" class="form-control" >
                            <small class="text-muted">Setting this value automatically enables tawk.to on the site, get your IDs from <a href="https://tawk.to">https://tawk.to</a></small>
                            <?= $errors->showError('value.tawk_id', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="fb_app_id">Facebook App ID</label>
                            <input type="text" name="value[fb_app_id]" value="<?= set_value('value[fb_app_id]', my_config('fb_app_id')) ?>" class="form-control" >
                            <small class="text-muted">Facebook App ID, get your IDs from <a href="https://developers.facebook.com">https://developers.facebook.com</a></small>
                            <?= $errors->showError('value.fb_app_id', 'my_single_error'); ?>
                        </div>

                        <div class="mb-3 pb-0 border-info border-bottom container-fluid">
                            <label class="font-weight-bold pb-0 mb-0" for="basic_block">Cpanel Configuration</label>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="cpanel_url">Cpanel URL or IP</label>
                            <input type="text" name="value[cpanel_url]" value="<?= set_value('value[cpanel_url]', my_config('cpanel_url')) ?>" class="form-control" >
                            <small class="text-muted">URL endpoint for all Cpanel requests (Without the schema://)</small>
                            <?= $errors->showError('value.cpanel_url', 'my_single_error'); ?>
                        </div>

                        <div class="form-group form-row col-md-4">
                            <div class="form-group col-sm-8">
                                <label class="text-info" for="cpanel_port">Cpanel Port</label>
                                <input type="text" name="value[cpanel_port]" value="<?= set_value('value[cpanel_port]', my_config('cpanel_port')) ?>" class="form-control" >
                                <small class="text-muted">Port for all Cpanel requests</small>
                                <?= $errors->showError('value.cpanel_port', 'my_single_error'); ?>
                            </div>

                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label class="text-info" for="cpanel_protocol">Protocol</label>
                                    <select id="cpanel_protocol" name="value[cpanel_protocol]" class="form-control" required>
                                        <option value="http" <?= set_select('value[cpanel_protocol]', 'http', my_config('cpanel_protocol') == 'http')?>>Insecure (HTTP)
                                        </option>
                                        <option value="https" <?= set_select('value[cpanel_protocol]', 'https', my_config('cpanel_protocol') == 'https')?>>Secure (HTTPS)
                                        </option>
                                    </select> 
                                    <?= $errors->showError('value.cpanel_protocol', 'my_single_error'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="cpanel_domain">Cpanel Domain</label>
                            <input type="text" name="value[cpanel_domain]" value="<?= set_value('value[cpanel_domain]', my_config('cpanel_domain')) ?>" class="form-control" >
                            <small class="text-muted">Domain name to use when generating Webmail Email Address (Must be active in the auth account)</small>
                            <?= $errors->showError('value.cpanel_domain', 'my_single_error'); ?>
                        </div> 

                        <div class="form-group col-md-4">
                            <label class="text-info" for="cpanel_username">Cpanel Username</label>
                            <input type="text" name="value[cpanel_username]" value="<?= set_value('value[cpanel_username]', my_config('cpanel_username')) ?>" class="form-control" >
                            <small class="text-muted">Username for all Cpanel requests</small>
                            <?= $errors->showError('value.cpanel_username', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="cpanel_password">Cpanel Password</label>
                            <input type="password" name="value[cpanel_password]" value="<?= set_value('value[cpanel_password]') ?>" class="form-control" >
                            <small class="text-muted">Password for all Cpanel requests</small>
                            <?= $errors->showError('value.cpanel_password', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="default_password">Default Email Password</label>
                            <input type="text" name="value[default_password]" value="<?= set_value('value[default_password]', my_config('default_password')) ?>" class="form-control" >
                            <small class="text-muted">Password used when generating Webmail Accounts</small>
                            <?= $errors->showError('value.default_password', 'my_single_error'); ?>
                        </div>

                        <div class="mb-3 pb-0 border-info border-bottom container-fluid">
                            <label class="font-weight-bold pb-0 mb-0" for="basic_block">AfterLogic Webmail Configuration</label>
                            <small class="text-muted">Use, if you have installed AfterLogic Webmail on your server. <a href="https://afterlogic.org/webmail-lite" class="text-info">Install AfterLogic Webmail Lite</a></small>
                        </div>

                        <div class="form-group form-row col-md-12">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="afterlogic_domain">AfterLogic WebMail Domain</label>
                                <input type="text" name="value[afterlogic_domain]" value="<?= set_value('value[afterlogic_domain]', my_config('afterlogic_domain')) ?>" class="form-control" >
                                <small class="text-muted">If you have installed AfterLogic Webmail on your server, enter the domain here.</small>
                                <?= $errors->showError('value.afterlogic_domain', 'my_single_error'); ?>
                            </div> 

                            <div class="form-group col-sm-4">
                                <div class="form-group">
                                    <label class="text-info" for="afterlogic_protocol">Protocol</label>
                                    <select id="afterlogic_protocol" name="value[afterlogic_protocol]" class="form-control" required>
                                        <option value="http" <?= set_select('value[afterlogic_protocol]', 'http', my_config('afterlogic_protocol') == 'http')?>>Insecure (HTTP)
                                        </option>
                                        <option value="https" <?= set_select('value[afterlogic_protocol]', 'https', my_config('afterlogic_protocol') == 'https')?>>Secure (HTTPS)
                                        </option>
                                    </select> 
                                    <?= $errors->showError('value.afterlogic_protocol', 'my_single_error'); ?>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group col-md-6">
                            <label class="text-info" for="afterlogic_username">Admin Username</label>
                            <input type="text" name="value[afterlogic_username]" value="<?= set_value('value[afterlogic_username]', my_config('afterlogic_username')) ?>" class="form-control" >
                            <small class="text-muted">Username for all Cpanel requests</small>
                            <?= $errors->showError('value.afterlogic_username', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="afterlogic_password">Admin Password</label>
                            <input type="password" name="value[afterlogic_password]" value="<?= set_value('value[afterlogic_password]') ?>" class="form-control" >
                            <small class="text-muted">Password for all Cpanel requests</small>
                            <?= $errors->showError('value.afterlogic_password', 'my_single_error'); ?>
                        </div> 
                    </div>
                    <?php endif; ?>

                    <?php if ($enable_steps &&  $step === 'payment'): ?>
                    <input type="hidden" name="step" value="payment">
                    <label class="font-weight-bold" for="payment_block">Payment Settings</label>
                    <hr class="my-0">
                    <div class="row p-3 mb-3" id="payment_block">
                        <div class="form-group col-md-4">
                            <label class="text-info" for="password">Site Currency</label>
                            <input type="text" name="value[site_currency]" value="<?= set_value('value[site_currency]', my_config('site_currency')) ?>" class="form-control" >
                            <small class="text-muted">
                            The base currency for all purchases originating from this site (E.g USD)
                            </small>
                            <?= $errors->showError('value.site_currency', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="currency_symbol">Currency Symbol</label>
                            <input type="text" name="value[currency_symbol]" value="<?= set_value('value[currency_symbol]', my_config('currency_symbol')) ?>" class="form-control" >
                            <small class="text-muted">The symbol for the base currency</small>
                            <?= $errors->showError('value.currency_symbol', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="payment_ref_pref">Reference Prefix</label>
                            <input type="text" name="value[payment_ref_pref]" value="<?= set_value('value[payment_ref_pref]', my_config('payment_ref_pref')) ?>" class="form-control" >
                            <small class="text-muted">The prefix for generated payment reference</small>
                            <?= $errors->showError('value.payment_ref_pref', 'my_single_error'); ?>
                        </div>
                    </div> 
                    
                    <div class="row p-3 mb-3">
                        <div class="form-group col-md-6">
                            <label class="text-info" for="pref_fetch_bank_mode">Preferred Method to Fetch Banks </label>
                                <select id="pref_fetch_bank_mode" name="value[pref_fetch_bank_mode]" class="form-control">
                                    <option value="api" <?= set_select('value[pref_fetch_bank_mode]', 'api', (my_config('pref_fetch_bank_mode')=='api'))?>>API
                                    </option>
                                    <option value="db" <?= set_select('value[pref_fetch_bank_mode]', 'db', (my_config('pref_fetch_bank_mode')=='db'))?>>DB
                                    </option>
                                </select>
                            <small class="text-muted">Choose whether to use the API or use database when fetching banks.</small>
                            <?= $errors->showError('value.pref_fetch_bank_mode', 'my_single_error');?>
                        </div> 

                        <div class="form-group col-md-6">
                            <label class="text-info" for="allowed_wallets">Allowed Crypto Wallets</label>
                            <input type="text" name="value[allowed_wallets]" value="<?= set_value('value[allowed_wallets]', my_config('allowed_wallets')) ?>" class="form-control" >
                            <small class="text-muted">Comma separated list of Crypto wallets that users can add (E.g. Bitcoin,Litecoin,Etherium).</small>
                            <?= $errors->showError('value.allowed_wallets', 'my_single_error'); ?>
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label class="text-info" for="paystack_public">Paystack Public Key</label>
                            <input type="text" name="value[paystack_public]" value="<?= set_value('value[paystack_public]', my_config('paystack_public')) ?>" class="form-control" >
                            <?= $errors->showError('value.paystack_public', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="paystack_secret">Paystack Secret Key</label>
                            <input type="text" name="value[paystack_secret]" value="<?= set_value('value[paystack_secret]', my_config('paystack_secret')) ?>" class="form-control" >
                            <?= $errors->showError('value.paystack_secret', 'my_single_error'); ?>
                        </div>
                    </div>
                    <?php endif?> 

                    <?php if ($enable_steps &&  $step === 'contact'): ?>
                    <input type="hidden" name="step" value="contact">
                    <label class="font-weight-bold" for="contact_block">Contact Settings</label>
                    <hr class="my-0">
                    <div class="row p-3 mb-3" id="contact_block">
                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_email">Contact Email Address</label>
                            <input type="text" name="value[contact_email]" value="<?= set_value('value[contact_email]', my_config('contact_email')) ?>" class="form-control" >
                            <small class="text-muted">Contact email address for the site</small>
                            <?= $errors->showError('value.contact_email', 'my_single_error'); ?>
                        </div>  

                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_facebook">Contact Facebook</label>
                            <input type="text" name="value[contact_facebook]" value="<?= set_value('value[contact_facebook]', my_config('contact_facebook')) ?>" class="form-control" >
                            <small class="text-muted">Facebook account for the site</small>
                            <?= $errors->showError('value.contact_facebook', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_twitter">Contact Twitter</label>
                            <input type="text" name="value[contact_twitter]" value="<?= set_value('value[contact_twitter]', my_config('contact_twitter')) ?>" class="form-control" >
                            <small class="text-muted">Twitter account for the site</small>
                            <?= $errors->showError('value.contact_twitter', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_instagram">Contact Instagram </label>
                            <input type="text" name="value[contact_instagram]" value="<?= set_value('value[contact_instagram]', my_config('contact_instagram')) ?>" class="form-control" >
                            <small class="text-muted">Instagram account for the site</small>
                            <?= $errors->showError('value.contact_instagram', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_telegram">Contact Telegram </label>
                            <input type="text" name="value[contact_telegram]" value="<?= set_value('value[contact_telegram]', my_config('contact_telegram')) ?>" class="form-control" >
                            <small class="text-muted">Telegram account for the site</small>
                            <?= $errors->showError('value.contact_telegram', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="contact_address">Contact Address</label>
                            <textarea name="value[contact_address]" class="form-control textarea" ><?= set_value('value[contact_address]', my_config('contact_address')) ?></textarea>
                            <small class="text-muted">The site's contact or office address</small>
                            <?= $errors->showError('value.contact_address', 'my_single_error'); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($enable_steps &&  $step === 'design'):
                    $curr_theme = theme_info(my_config('theme'));
                    $curr_adm_theme = theme_info(my_config('theme'))?>
                    <input type="hidden" name="step" value="design">
                    <label class="font-weight-bold" for="design_block">Design Settings</label>
 
                    <div class="row border p-1 rounded text-info font-weight-bold small">
                        <div class="col-md-12">
                            <div class="text-success">Current Theme</div>
                            <div class="text-muted"><?=$curr_theme['name'];?></div>
                            <div>Author: <span class="text-muted"><?=$curr_theme['author'];?></span></div>
                            <div>Version: <span class="text-muted">v<?=$curr_theme['version'];?></span></div>
                            <div>Available For: <span class="text-muted"><?=$curr_theme['availability'];?></span></div>
                            <div>Stable Modules: <span class="text-muted"><?=implode(', ', $curr_theme['stable']);?></span></div>
                        </div> 
                    </div>

                    <div class="row p-3 mb-3" id="design_block">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="theme">Site Theme</label>
                                <?=select_theme(
                                fetch_themes('admin'),
                                'class="form-control" name="value[theme]"',
                                set_value('value[theme]', my_config('theme')));
                                ?>
                                <small class="text-muted">
                                Sets the admin theme for the site.
                                </small>
                                <?= $errors->showError('value.theme', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="theme_mode">Theme Mode</label>
                                <?=select_theme_modes(my_config('theme'), 'class="form-control" name="value[theme_mode]"', my_config('theme_mode'))?>
                                <small class="text-muted">
                                    Set the mode for this theme, availabilty is subject to theme.
                                </small>
                            </div>
                        </div>   

                        <div class="form-group col-md-12">
                            <label class="text-info" for="site_slogan">Slogan</label>
                            <input type="text" name="value[site_slogan]" value="<?= set_value('value[site_slogan]', my_config('site_slogan')) ?>" class="form-control" >
                            <small class="text-muted">Set a slogan for this site</small>
                            <?= $errors->showError('value.site_slogan', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="site_keywords">Site Keywords</label>
                            <input type="text" name="value[site_keywords]" value="<?= set_value('value[site_keywords]', my_config('site_keywords')) ?>" class="form-control" >
                            <small class="text-muted">Set a slogan for this site</small>
                            <?= $errors->showError('value.site_keywords', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="site_description">Description</label>
                            <textarea name="value[site_description]" class="form-control" ><?= set_value('value[site_description]', character_limiter(my_config('site_description'), 200,'')) ?></textarea><small class="text-muted">The site description might be used for SEO and other sections (Less than 200 characters)</small>
                            <?= $errors->showError('value.site_description', 'my_single_error'); ?>
                        </div>  

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_template">Email Template</label>
                            <textarea name="value[email_template]" class="form-control textarea" ><?= set_value('value[email_template]', my_config('email_template')) ?></textarea>
                            <small class="text-muted">
                                Design the view sent with email messages 
                                <div class="text-info">Variables: {$conf=site_name}, {$user}, {$title}, {$message}, {$link}, {$link_title}</div>
                            </small>
                            <?= $errors->showError('value.email_template', 'my_single_error'); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($enable_steps &&  $step === 'system'): ?>
                    <input type="hidden" name="step" value="system">
                    <label class="font-weight-bold" for="system_block">Email Settings</label>
                    <hr class="my-0"> 
                            
                    <?php $smtp_c = localhosted() ? 'smtp' : 'SMTP';?>
                    <div class="row p-3 mb-3" id="system_block">
                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label class="text-info" for="email_protocol">Email Protocol</label>
                                <select id="email_protocol" name="value[email_protocol]" class="form-control">
                                    <option value="mail"<?=set_select('value[email_protocol]', 'mail',( my_config('email_protocol') == 'mail'))?>>Mail
                                    </option>
                                    <option value="sendmail"<?=set_select('value[email_protocol]', 'sendmail', (my_config('email_protocol') == 'sendmail'))?>>Sendmail
                                    </option> 
                                    <option value="<?=$smtp_c?>"<?=set_select('value[email_protocol]', $smtp_c, (my_config('email_protocol') == $smtp_c))?>>SMTP
                                    </option> 
                                </select>
                                <small class="text-muted">
                                Sets protocol for sending email.
                                </small>
                                <?= $errors->showError('value.email_protocol', 'my_single_error'); ?>
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <div class="form-group">
                                <label class="text-info" for="smtp_crypto">SMTP Encryption</label>
                                <select id="smtp_crypto" name="value[smtp_crypto]" class="form-control">
                                    <option value="tls"<?=set_select('value[smtp_crypto]', 'tls',( my_config('smtp_crypto') == 'tls'))?>>TLS
                                    </option>
                                    <option value="ssl"<?=set_select('value[smtp_crypto]', 'ssl', (my_config('smtp_crypto') == 'ssl'))?>>SSL
                                    </option>  
                                </select>
                                <small class="text-muted">
                                Sets the SMTP Encryption for sending emails.
                                </small>
                                <?= $errors->showError('value.smtp_crypto', 'my_single_error'); ?>
                            </div>
                        </div> 
                        <div class="form-group col-md-4">
                            <label class="text-info" for="mailpath">Mail Path</label>
                            <input type="text" name="value[mailpath]" value="<?= set_value('value[mailpath]', my_config('mailpath')) ?>" class="form-control" placeholder="/usr/sbin/sendmail" >
                            <small class="text-muted">The server path to Sendmail</small>
                            <?= $errors->showError('value.mailpath', 'my_single_error'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-info" for="smtp_host">SMTP Host</label>
                            <input type="text" name="value[smtp_host]" value="<?= set_value('value[smtp_host]', my_config('smtp_host')) ?>" class="form-control" placeholder="example.com" >
                            <small class="text-muted">The SMTP Host for sending emails</small>
                            <?= $errors->showError('value.smtp_host', 'my_single_error'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-info" for="smtp_port">SMTP Port</label>
                            <input type="text" name="value[smtp_port]" value="<?= set_value('value[smtp_port]', my_config('smtp_port')) ?>" class="form-control" placeholder="25" >
                            <small class="text-muted">The SMTP Port for sending emails</small>
                            <?= $errors->showError('value.smtp_port', 'my_single_error'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-info" for="smtp_user">SMTP Username</label>
                            <input type="text" name="value[smtp_user]" value="<?= set_value('value[smtp_user]', my_config('smtp_user')) ?>" class="form-control" >
                            <small class="text-muted">The SMTP Username for sending emails</small>
                            <?= $errors->showError('value.smtp_user', 'my_single_error'); ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="text-info" for="smtp_pass">SMTP Password</label>
                            <input type="text" name="value[smtp_pass]" value="<?= set_value('value[smtp_pass]', my_config('smtp_pass')) ?>" class="form-control" >
                            <small class="text-muted">The SMTP Password for sending emails</small>
                            <?= $errors->showError('value.smtp_pass', 'my_single_error'); ?>
                        </div>
                    </div>     
                    <?php endif; ?>

                    <?php if (empty($hide_update_btn)): ?>
                    <div class="send-button">
                        <button type="submit" class="btn btn-info btn-round btn-sm text-white">Update Configuration</button>
                    </div>
                    <?php endif; ?>

                    <?= form_close(); ?>

                    <?php if ($enable_steps &&  $step === 'sitemap'): ?>
                    <input type="hidden" name="step" value="sitemap"> 
                    <hr class="my-0"> 

                    <a href="<?= site_url('admin/configuration/sitemap/generate')?>" class="btn btn-success btn-round btn-md rounded-0 text-white mt-3">
                        <i class="fas fa-code"></i> <?=$sitemap_btn?>
                    </a>
                    <div class="container p-3" style='font-family: Consolas,"courier new"; color: crimson; background-color: #f1f1f1; padding: 2px; font-size: 70%;'>
                        <code>
                            <?= $sitemap; ?>
                        </code>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Right profile sidebar -->
    <!-- <?php //$this->load->view('layout/_right_profile_sidebar') ?> -->
</div> 
