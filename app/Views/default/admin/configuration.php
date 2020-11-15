<?php 
    $switch = ($request->getPost() ? 1 : null);
    $attribution = theme_info(my_config('frontend_theme'),'attribution'); ?>

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

                        <?php if ($step !== 'translations'): ?>
                        <a href="<?= site_url('admin/configuration/translations')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white<?=active_page('translations', $step)?>">
                            <i class="fas fa-language"></i> Translations
                        </a>
                        <?php endif; ?>

                        <?php if ($step !== 'email'): ?>
                        <a href="<?= site_url('admin/configuration/email')?>" class="btn btn-danger btn-round btn-md rounded-0 text-white">
                            <i class="fas fa-envelope"></i> Email
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
                        <div class="form-group col-md-<?=$attribution?'6':'12'?>">
                            <label class="text-info" for="site_name">Site Name</label>
                            <input type="text" name="value[site_name]" value="<?= set_value('value[site_name]', my_config('site_name')) ?>" class="form-control" >
                            <small class="text-muted">The name of this website</small>
                            <?= $errors->showError('value.site_name', 'my_single_error'); ?>
                        </div>

                        <?php if ($attribution): ?>
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="show_link_back">Show Attribution</label>
                                <select id="show_link_back" name="value[show_link_back]" class="form-control" required>
                                    <option value="0" <?= set_select('value[show_link_back]', '0', int_bool(my_config('show_link_back') == 0))?>>Hide
                                    </option>
                                    <option value="1" <?= set_select('value[show_link_back]', '1', int_bool(my_config('show_link_back') == 1))?>>Show
                                    </option>
                                </select>
                                <small class="text-muted">
                                Part of this software has been <?=$attribution?>. You can choose to show or hide the credits.
                                </small>
                                <?= $errors->showError('value.show_link_back', 'my_single_error'); ?>
                            </div>
                        </div>
                        <?php endif ?>
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

                        <div class="row col-md-6">
                            <div class="form-group col-md-8">
                                <label class="text-info" for="ipapi_key">IApi API Access Key</label>
                                <input type="text" name="value[ipapi_key]" value="<?= set_value('value[ipapi_key]', my_config('ipapi_key')) ?>" class="form-control" >
                                <small class="text-muted">Get your Keys from <a href="https://ipapi.com">https://ipapi.com</a></small>
                                <?= $errors->showError('value.ipapi_key', 'my_single_error'); ?>
                            </div>

                            <div class="form-group col-md-4">
                                <div class="form-group">
                                    <label class="text-info" for="ipapi_protocol">IpApi Protocol</label>
                                    <select id="ipapi_protocol" name="value[ipapi_protocol]" class="form-control" required>
                                        <option value="http" <?= set_select('value[ipapi_protocol]', 'http', my_config('ipapi_protocol', null, 'http') == 'http')?>>Insecure (HTTP)
                                        </option>
                                        <option value="https" <?= set_select('value[ipapi_protocol]', 'https', my_config('ipapi_protocol', null, 'http') == 'https')?>>Secure (HTTPS)
                                        </option>
                                    </select> 
                                    <?= $errors->showError('value.ipapi_protocol', 'my_single_error'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="fb_app_id">Facebook App ID</label>
                            <input type="text" name="value[fb_app_id]" value="<?= set_value('value[fb_app_id]', my_config('fb_app_id')) ?>" class="form-control" >
                            <small class="text-muted">Facebook App ID, get your IDs from <a href="https://developers.facebook.com">https://developers.facebook.com</a></small>
                            <?= $errors->showError('value.fb_app_id', 'my_single_error'); ?>
                        </div>

                        <div class="mb-3 pb-0 border-info border-bottom container-fluid">
                            <label class="font-weight-bold pb-0 mb-0" for="basic_block">Mailjet Configuration</label>
                            <div class="text-muted small">Mailjet is an easy-to-use all-in-one e-mail and SMS platform. get your keys from <a href="https://app.mailjet.com/account/api_keys">https://app.mailjet.com/account/api_keys</a></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="mailjet_api_key">Mailjet Api Key</label>
                            <input type="text" name="value[mailjet_api_key]" value="<?= set_value('value[mailjet_api_key]', my_config('mailjet_api_key')) ?>" class="form-control" >
                            <small class="text-muted">Public Mailjet API key. get your keys from <a href="https://app.mailjet.com/account/api_keys">https://app.mailjet.com/account/api_keys</a></small>
                            <?= $errors->showError('value.mailjet_api_key', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="mailjet_secret_key">Mailjet Secret Key</label>
                            <input type="text" name="value[mailjet_secret_key]" value="<?= set_value('value[mailjet_secret_key]', my_config('mailjet_secret_key')) ?>" class="form-control" >
                            <small class="text-muted">Private Mailjet API key. get your keys from <a href="https://app.mailjet.com/account/api_keys">https://app.mailjet.com/account/api_keys</a></small>
                            <?= $errors->showError('value.mailjet_secret_key', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="text-info" for="mailjet_bearer_token">Mailjet Bearer Token</label>
                            <input type="text" name="value[mailjet_bearer_token]" value="<?= set_value('value[mailjet_bearer_token]', my_config('mailjet_bearer_token')) ?>" class="form-control" >
                            <small class="text-muted">Authentication for the SMS API endpoints is done using a bearer token. Generate bearer token <a href="https://app.mailjet.com/sms">Here</a>. </small>
                            <?= $errors->showError('value.mailjet_bearer_token', 'my_single_error'); ?>
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
                            <div class="text-muted small">Use, if you have installed AfterLogic Webmail on your server. <a href="https://afterlogic.org/webmail-lite" class="text-info">Install AfterLogic Webmail Lite</a></div>
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
                                        <option value="http" <?= set_select('value[afterlogic_protocol]', 'http', my_config('afterlogic_protocol', null, 'http') == 'http')?>>Insecure (HTTP)
                                        </option>
                                        <option value="https" <?= set_select('value[afterlogic_protocol]', 'https', my_config('afterlogic_protocol', null, 'http') == 'https')?>>Secure (HTTPS)
                                        </option>
                                    </select> 
                                    <?= $errors->showError('value.afterlogic_protocol', 'my_single_error'); ?>
                                </div>
                            </div>
                        </div> 

                        <div class="form-group col-md-6">
                            <label class="text-info" for="afterlogic_username">Admin Username</label>
                            <input type="text" name="value[afterlogic_username]" value="<?= set_value('value[afterlogic_username]', my_config('afterlogic_username')) ?>" class="form-control" >
                            <small class="text-muted">Username for all AfterLogic Api requests</small>
                            <?= $errors->showError('value.afterlogic_username', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="afterlogic_password">Admin Password</label>
                            <input type="password" name="value[afterlogic_password]" value="<?= set_value('value[afterlogic_password]') ?>" class="form-control" >
                            <small class="text-muted">Password for all AfterLogic Api requests</small>
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
                            <input type="text" name="value[site_currency]" value="<?= set_value('value[site_currency]', my_config('site_currency', NULL, "USD")) ?>" class="form-control" >
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
                            <label class="text-info" for="paystack_public">Paystack Public Key</label>
                            <input type="text" name="value[paystack_public]" value="<?= set_value('value[paystack_public]', my_config('paystack_public')) ?>" class="form-control" >
                            <?= $errors->showError('value.paystack_public', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="paystack_secret">Paystack Secret Key</label>
                            <input type="text" name="value[paystack_secret]" value="<?= set_value('value[paystack_secret]', my_config('paystack_secret')) ?>" class="form-control" >
                            <?= $errors->showError('value.paystack_secret', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="stripe_public">Stripe Public Key</label>
                            <input type="text" name="value[stripe_public]" value="<?= set_value('value[stripe_public]', my_config('stripe_public')) ?>" class="form-control" >
                            <?= $errors->showError('value.stripe_public', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="stripe_secret">Stripe Secret Key</label>
                            <input type="text" name="value[stripe_secret]" value="<?= set_value('value[stripe_secret]', my_config('stripe_secret')) ?>" class="form-control" >
                            <?= $errors->showError('value.stripe_secret', 'my_single_error'); ?>
                        </div> 

                        <div class="form-group col-md-6">
                            <label class="text-info" for="password">Stripe Currency</label>
                            <input type="text" name="value[stripe_currency]" value="<?= set_value('value[stripe_currency]', my_config('stripe_currency', NULL, "USD")) ?>" class="form-control" >
                            <small class="text-muted">
                            The currency for all Stripe Transaction (E.g USD)
                            </small>
                            <?= $errors->showError('value.stripe_currency', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="password">Stripe Currency Conversion Rate</label>
                            <input type="text" name="value[stripe_currency_rate]" value="<?= set_value('value[stripe_currency_rate]', my_config('stripe_currency_rate', NULL, "5.00")) ?>" class="form-control" >
                            <small class="text-muted">
                            If the Base currency is different from the stripe currency please enter the conversion rate.  
                            <?php if (my_config('site_currency', NULL, "USD") !== my_config('stripe_currency', NULL, "USD")): ?>
                                <i>1 <?=my_config('stripe_currency', NULL, "USD")?> = <?=1*my_config('stripe_currency_rate', NULL, "5.00")?> <?=my_config('site_currency', NULL, "USD")?></i>
                            <?php endif ?>
                            </small>
                            <?= $errors->showError('value.stripe_currency_rate', 'my_single_error'); ?>
                        </div>

                        <div class="col-12 text-sm">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Payment Methods</h3>
                                </div>
                                <div class="form-row card-body">  
                                    <div class="form-group col-sm-4">
                                        <label class="text-info" for="enable_paystack">Paystack</label><br/>
                                        <input type="hidden" name="value[enable_paystack]" value="0">
                                        <input type="checkbox" name="value[enable_paystack]" value="1" id="enable_paystack" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('value[enable_paystack]', '1',(my_config('enable_paystack') == '1'))?>>
                                    </div> 
                                    <div class="form-group col-sm-4">
                                        <label class="text-info" for="enable_stripe">Stripe</label><br/>
                                        <input type="hidden" name="value[enable_stripe]" value="0">
                                        <input type="checkbox" name="value[enable_stripe]" value="1" id="enable_stripe" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('value[enable_stripe]', '1',(my_config('enable_stripe') == '1'))?>>
                                    </div> 
                                </div>
                            </div>
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

                        <div class="form-group col-md-4">
                            <label class="text-info" for="contact_phone">Contact Phone </label>
                            <input type="text" name="value[contact_phone]" value="<?= set_value('value[contact_phone]', my_config('contact_phone')) ?>" class="form-control" >
                            <small class="text-muted">Phone number for the site</small>
                            <?= $errors->showError('value.contact_phone', 'my_single_error'); ?>
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
                    $curr_theme = theme_info(my_config('site_theme', NULL, my_config('site_theme')));
                    $frontend_theme = theme_info(my_config('frontend_theme', NULL, my_config('frontend_theme')))?>
                    <input type="hidden" name="step" value="design">
                    <label class="font-weight-bold" for="design_block">Design Settings</label>
 
                    <div class="row border p-1 rounded text-info font-weight-bold small">
                        <div class="col-md-6">
                            <div class="text-success">Current Theme</div>
                            <div class="text-muted"><?=$curr_theme['name'];?></div>
                            <div>Author: <span class="text-muted"><?=$curr_theme['author'];?></span></div>
                            <div>Version: <span class="text-muted">v<?=$curr_theme['version'];?></span></div>
                            <div>Available For: <span class="text-muted"><?=$curr_theme['availability'];?></span></div>
                            <div>Stable Modules: <span class="text-muted"><?=implode(', ', $curr_theme['stable']);?></span></div>
                        </div> 
                        <div class="col-md-6">
                            <div class="text-success">Front Theme</div>
                            <div class="text-muted"><?=$frontend_theme['name'];?></div>
                            <div>Author: <span class="text-muted"><?=$frontend_theme['author'];?></span></div>
                            <div>Version: <span class="text-muted">v<?=$frontend_theme['version'];?></span></div>
                            <div>Available For: <span class="text-muted"><?=$frontend_theme['availability'];?></span></div>
                            <div>Stable Modules: <span class="text-muted"><?=implode(', ', $frontend_theme['stable']);?></span></div>
                        </div> 
                    </div>

                    <div class="row p-3 mb-3" id="design_block">
                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label class="text-info" for="site_theme">Site Theme</label>
                                <?=select_theme(
                                fetch_themes('user'),
                                'class="form-control" name="value[site_theme]"',
                                set_value('value[site_theme]', my_config('site_theme')));
                                ?>
                                <small class="text-muted">
                                Sets the user theme for the site.
                                </small>
                                <?= $errors->showError('value.site_theme', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label class="text-info" for="frontend_theme">Front Theme</label>
                                <?=select_theme(
                                fetch_themes('frontend'),
                                'class="form-control" name="value[frontend_theme]"',
                                set_value('value[frontend_theme]', my_config('frontend_theme', NULL, my_config('theme'))));
                                ?>
                                <small class="text-muted">
                                Sets the front theme for the site.
                                </small>
                                <?= $errors->showError('value.frontend_theme', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label class="text-info" for="admin_theme">Admin Theme</label>
                                <?=select_theme(
                                fetch_themes('admin'),
                                'class="form-control" name="value[admin_theme]"',
                                set_value('value[admin_theme]', my_config('admin_theme', NULL, my_config('theme'))));
                                ?>
                                <small class="text-muted">
                                Sets the admin theme for the site.
                                </small>
                                <?= $errors->showError('value.admin_theme', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-3">
                            <div class="form-group">
                                <label class="text-info" for="theme_mode">Theme Mode</label>
                                <?=select_theme_modes(my_config('site_theme'), 'class="form-control" name="value[theme_mode]"', my_config('theme_mode'))?>
                                <small class="text-muted">
                                    Set the mode for this theme, availability is subject to theme.
                                </small>
                            </div>
                        </div>   

                        <div class="form-group col-md-6">
                            <label class="text-info" for="admin_active_modules">Admin Theme Active Modules</label> 
                            <input 
                                type="text" id="admin_active_modules" name="value[admin_active_modules]" 
                                value="<?= set_value('value[admin_active_modules]', my_config('admin_active_modules', NULL, implode(",",array_values(theme_info(my_config('admin_theme'), 'modules'))))) ?>" 
                                class="form-control selectize" placeholder="Admin Theme Active Modules"
                                data-options='<?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(theme_info(my_config('admin_theme'), 'modules')))."\"}]"?>'
                            > 
                            <small class="text-muted">Set Modules that will be active for admin section (Admin modules begin with an _underscore)</small>
                            <?= $errors->showError('value.admin_active_modules', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="text-info" for="site_active_modules">Site Theme Active Modules</label>
                            <input 
                                type="text" id="site_active_modules" name="value[site_active_modules]" 
                                value="<?= set_value('value[site_active_modules]', my_config('site_active_modules', NULL, implode(",",array_values(theme_info(my_config('site_theme'), 'modules'))))) ?>" 
                                class="form-control selectize" placeholder="Site Theme Active Modules"
                                data-options='<?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(theme_info(my_config('site_theme'), 'modules')))."\"}]"?>'
                            >  
                            <small class="text-muted">Set Modules that will be active for user section (Admin modules begin with an _underscore)</small>
                            <?= $errors->showError('value.site_active_modules', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="front_skin">Front Page Skin</label>
                                <select id="front_skin" name="value[front_skin]" class="form-control">
                                    <option value="0"<?=set_select('value[front_skin]', '0',( my_config('front_skin') == '0'))?>>Unset
                                    </option>
                                    <option value="1"<?=set_select('value[front_skin]', '1', (my_config('front_skin') == '1'))?>>Default Theme Skin
                                    </option>  
                                </select>
                                <small class="text-muted">
                                Use the default theme skin on front page when available.
                                </small>
                                <?= $errors->showError('value.front_skin', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="scrollspy_nav">Front Page Navigation</label>
                                <select id="scrollspy_nav" name="value[scrollspy_nav]" class="form-control">
                                    <option value="1"<?=set_select('value[scrollspy_nav]', '1', (my_config('scrollspy_nav') == '1'))?>>Scrollspy
                                    </option> 
                                    <option value="0"<?=set_select('value[scrollspy_nav]', '0',(my_config('scrollspy_nav') == '0'))?>>Site Pages
                                    </option> 
                                </select>
                                <small class="text-muted">
                                Choose to use a scrollspy navigation bar or show site pages on navigation when available.
                                </small>
                                <?= $errors->showError('value.scrollspy_nav', 'my_single_error'); ?>
                            </div>
                        </div> 

                        <div class="form-group col-md-12">
                            <label class="text-info" for="site_slogan">Slogan</label>
                            <input type="text" name="value[site_slogan]" value="<?= set_value('value[site_slogan]', my_config('site_slogan')) ?>" class="form-control">
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
                                    <?php if (my_config('mailjet_api_key') && my_config('mailjet_secret_key')): ?>
                                    <option value="mailjet"<?=set_select('value[email_protocol]', 'mail',( my_config('email_protocol') == 'mailjet'))?>>Mailjet
                                    </option>
                                    <?php endif ?>
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

                    <label class="font-weight-bold" for="system_block">System</label>
                    <hr class="my-0"> 
                             
                    <div class="row p-3 mb-3"> 
                        <div class="form-group col-md-4">
                            <label class="text-info" for="timmezone">System Timezone</label>
                            <?=timezone_select('form-control custom-select', config('App')->appTimezone); ?>
                            <small class="text-muted">System Timezone for your location</small>
                            <?= $errors->showError('timezone', 'my_single_error'); ?>
                        </div>
                        <div class="col-md-8 row d-flex">
                            <div class="form-group col">
                                <label class="text-info" for="env[CI_ENVIRONMENT]">Developer Mode</label>
                                <div class="form-group">
                                    <input type="hidden" name="env[CI_ENVIRONMENT]" value="production">
                                    <input type="checkbox" name="env[CI_ENVIRONMENT]" value="development" id="env[CI_ENVIRONMENT]" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('env[CI_ENVIRONMENT]', '1',(env('CI_ENVIRONMENT') == 'development'))?>>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label class="text-info" for="mail_debug">Mail Debug</label>
                                <div class="form-group">
                                    <input type="hidden" name="value[mail_debug]" value="0">
                                    <input type="checkbox" name="value[mail_debug]" value="1" id="mail_debug" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('value[mail_debug]', '1',(my_config('mail_debug') == '1'))?>>
                                </div>
                            </div> 
                            <div class="form-group col">
                                <label class="text-info" for="cron_jobs">Crone Jobs</label>
                                <div class="form-group">
                                    <input type="hidden" name="value[cron_jobs]" value="0">
                                    <input type="checkbox" name="value[cron_jobs]" value="1" id="cron_jobs" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('value[cron_jobs]', '1',(my_config('cron_jobs') == '1'))?>>
                                </div>
                            </div>
                            <div class="form-group col">
                                <label class="text-info" for="sms_notify">SMS Notify</label>
                                <div class="form-group">
                                    <input type="hidden" name="value[sms_notify]" value="0">
                                    <input type="checkbox" name="value[sms_notify]" value="1" id="sms_notify" data-bootstrap-switch data-off-color="danger" data-on-color="success"<?=set_checkbox('value[sms_notify]', '1',(my_config('sms_notify') == '1'))?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($enable_steps &&  $step === 'email'): ?>
                    <input type="hidden" name="step" value="email">
                    <label class="font-weight-bold" for="email_block">Email Settings</label> 

                    <div class="row p-3 mb-3" id="email_block">    
 
                        <div class="col-md-12">
                            <label class="font-weight-bold" for="design_block">Messages to send</label>
                            <hr class="my-0"> 

                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="text-info" for="send_welcome">Welcome</label>
                                    <select id="send_welcome" name="value[send_welcome]" class="form-control">
                                        <option value="0"<?=set_select('value[send_welcome]', '0',(my_config('send_welcome') == '0'))?>>Dont Send
                                        </option>
                                        <option value="1"<?=set_select('value[send_welcome]', '1', (my_config('send_welcome') == '1'))?>>Send
                                        </option>    
                                    </select> 
                                    <?= $errors->showError('value.send_welcome', 'my_single_error'); ?> 
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="text-info" for="send_activation">Activation</label>
                                    <select id="send_activation" name="value[send_activation]" class="form-control">
                                        <option value="0"<?=set_select('value[send_activation]', '0',(my_config('send_activation') == '0'))?>>Dont Send
                                        </option>
                                        <option value="1"<?=set_select('value[send_activation]', '1', (my_config('send_activation') == '1'))?>>Send
                                        </option>    
                                    </select> 
                                    <?= $errors->showError('value.send_activation', 'my_single_error'); ?> 
                                </div>

                                <div class="form-group col-md-4">
                                    <label class="text-info" for="token_lifespan">Token Lifespan (Mins.)</label>
                                    <input type="number" name="value[token_lifespan]" value="<?= set_value('value[token_lifespan]', my_config('token_lifespan', null, 5)) ?>" class="form-control" min="1">
                                    <?=$errors->showError('value.token_lifespan', 'my_single_error'); ?>
                                    <small class="text-muted">
                                        How long a token will live before it expires. (Default is 5)
                                    </small>
                                </div>
                            </div> 
                        </div>

                        <div class="col-md-12">
                            <label class="font-weight-bold" for="design_block">Messages Templates</label>
                            <hr class="my-0"> 
                            <div class="text-danger">
                                Available Variables: {$conf=site_name}, {$user}, {$title}, {$anchor_link}, {$link}, {$link_title}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_welcome">Welcome Email</label>
                            <textarea name="value[email_welcome]" class="form-control" ><?= set_value('value[email_welcome]', my_config('email_welcome')) ?></textarea>
                            <small class="text-muted">
                                Welcome email to send every user after registration 
                            </small>
                            <?= $errors->showError('value.email_welcome', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_activation">Account Activation Email</label>
                            <textarea name="value[email_activation]" class="form-control" ><?= set_value('value[email_activation]', my_config('email_activation')) ?></textarea>
                            <small class="text-muted">
                                Email to send for account activation 
                            </small>
                            <?= $errors->showError('value.email_activation', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_token">Token Access Email</label>
                            <textarea name="value[email_token]" class="form-control" ><?= set_value('value[email_token]', my_config('email_token')) ?></textarea>
                            <small class="text-muted">
                                Email to send for token request 
                            </small>
                            <?= $errors->showError('value.email_token', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_incognito">Incognito Access Email</label>
                            <textarea name="value[email_incognito]" class="form-control" ><?= set_value('value[email_incognito]', my_config('email_incognito')) ?></textarea>
                            <small class="text-muted">
                                Email to send for incognito access request
                            </small>
                            <?= $errors->showError('value.email_incognito', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_recovery">Password Recovery Email</label>
                            <textarea name="value[email_recovery]" class="form-control" ><?= set_value('value[email_recovery]', my_config('email_recovery')) ?></textarea>
                            <small class="text-muted">
                                Email to send for password recovery requests 
                            </small>
                            <?= $errors->showError('value.email_recovery', 'my_single_error'); ?>
                        </div>
 
                        <div class="form-group col-md-12">
                            <label class="text-info" for="email_template">Email Template</label>
                            <textarea name="value[email_template]" class="form-control textarea" ><?= set_value('value[email_template]', my_config('email_template')) ?></textarea>
                            <small class="text-muted">
                                Design the view sent with email messages, the {$message} variable is compulsory.
                                <div class="text-info">Variables: {$conf=site_name}, {$user}, {$title}, {$message}, {$link}, {$link_title}</div>
                            </small>
                            <?= $errors->showError('value.email_template', 'my_single_error'); ?>
                        </div>

                        <div class="form-group col-sm-4 d-flex flex-row mx-auto">
                            <a href="<?= site_url('admin/configuration/email/testmail')?>" class="btn btn-warning btn-md mx-1">
                                <i class="fa fa-paper-plane"></i> Test Mail
                            </a>
                            <?php if (my_config('contact_phone')): ?>
                            <a href="<?= site_url('admin/configuration/email/testsms')?>" class="btn btn-warning btn-md mx-1">
                                <i class="fa fa-sms"></i> Test SMS
                            </a>
                            <?php endif ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if ($enable_steps &&  $step === 'translations'): 
                        $translations = read_lang(my_config('lang_pack', null, 'Default_'));
                        $limit  = 16;
                        $page   = min($pagination, ceil( count($translations)/ $limit )); //get last page when $_GET['page'] > $totalPages
                        $offset = ($page - 1) * $limit;
                        if( $offset < 0 ) $offset = 0;
                        if (my_config('lang_pack', null, 'Default_') === 'Default_') 
                            $prevent_update = 'You cant update the default Pack';
                        if (!empty($translations)) 
                            $show_save_update = true;
                        ?>

                    <input type="hidden" name="step" value="translations">
                    <input type="hidden" name="pagination" value="<?=$pagination?>">
                    <input type="hidden" name="lang_pack" value="<?=my_config('lang_pack', null, 'Default_')?>">
                    <label class="font-weight-bold" for="translations_block">Language and Translations</label>
                    <hr class="my-0">
                    <div class="row p-3 mb-3" id="translations_block">

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="locale">Locale</label>
                                <?=select_lang('class="form-control" name="env[app.defaultLocale]"', set_value("env[app.defaultLocale]", env('app.defaultLocale', 'en')), true)?>
                                <small class="text-muted">
                                    Set the preferred locale for this system.
                                </small>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label class="text-info" for="lang_pack">Translations Pack</label>
                                <?=select_lang('class="form-control" name="value[lang_pack]"', my_config('lang_pack', null, 'Default_'));?>
                                <small class="text-muted">
                                    Set the preferred translations pack for this system.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-12 row border-bottom mb-5">
                            <div class="form-group col-8">
                                <label class="text-info" for="find_string">Find Translation String</label>
                                <input type="text" name="find_string" value="<?=set_value('find_string') ?>" class="form-control" > 
                            </div>
                            <div class="form-group col-4"><br/>
                                <input name="find_lang_string" type="submit" value="Search" class="btn btn-info btn-round btn-md text-white mt-2">
                                <?php if ($request->getPost("find_lang_string")): ?>
                                <input name="clear_all" type="submit" value="Clear" class="btn btn-danger btn-md text-white mt-2">
                                <?php endif ?>
                            </div> 
                        </div>

                        <?php 
                                if ($request->getPost("find_lang_string") && $request->getPost("find_string")) {
                                    $list_translations = array_find($request->getPost("find_string"), $translations);
                                }
                                elseif ($translations) 
                                {
                                    $list_translations = array_slice($translations, $offset, $limit);
                                }

                               if ($translations && $list_translations): ?>
                            <?php foreach ($list_translations as $lang_key => $lang_lines): ?>
                            <div class="form-group col-md-6">
                                <label class="text-info" for="lkey"><?=$lang_key?></label>
                                <textarea name="lang[<?=$lang_key?>]" class="form-control" rows="1"><?= set_value("lang[$lang_key]", $lang_lines) ?></textarea> 
                                <?= $errors->showError("lang.$lang_key", 'my_single_error'); ?>
                            </div>
                            <?php endforeach ?>  
                        <?php else: ?>
                        <div class="col-md-12">
                            <?=alert_notice("No Translations Found!", "warning", false, false, NULL, "Notice!")?>
                        </div>
                        <?php endif ?>
                        <div class="col-md-12">
                            <input name="gen_trans" type="submit" value="Clone Default" class="btn btn-secondary btn-round btn-md text-white mb-3"> 
                        </div>
                    </div>
                    <?php if (!$request->getPost("find_lang_string")): ?>
                        <?=service('pager')->makeLinks($pagination, $limit, count($translations), 'custom_full');?>
                    <?php endif;
                     endif; ?>


                    <div class="send-button mb-3">
                    <?php if (empty($hide_update_btn)): ?>
                        <button type="submit" class="btn btn-info btn-round btn-md text-white mb-3">Update Configuration</button> 
                    <?php endif; ?>

                    <?php if (!empty($show_save_update) && empty($prevent_update)):
                        if (env('installation.demo', false) === false || logged_user('admin')>=3): ?> 
                        <input name="save_update" type="submit" value="Save Changes" class="btn btn-success btn-round btn-md text-white mb-3">

                        <?php if (!empty($translations)): ?>
                        <input name="delete_lang" type="submit" value="Delete Trans. Pack" class="btn btn-danger btn-round btn-md text-white mb-3">
                        <?php endif;
                        endif ?>
                    <?php else: !empty($show_save_update) ? alert_notice($prevent_update, 'error', true, 'FLAT') : ''; endif; ?>
                    </div> 

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

<script>
    window.onload = function() { 
        $(".selectize").each(function(e) { 
            $(this).selectize({
                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
                delimiter: ',',
                persist: false,
                hideSelected: true,
                valueField: 'title',
                searchField: 'title',
                options: $(this).data("options"),
                render: {
                    option: function(data, escape) {
                        return '<div class="title pl-1">' + escape(data.title) + '</div>';
                    },
                    item: function(data, escape) {
                        return '<div class="item">' + escape(data.title) + '</div>';
                    }
                },
                create: function(input) { 
                    return { 
                        title: input 
                    }
                }
            }); 
        }); 
    }
</script> 