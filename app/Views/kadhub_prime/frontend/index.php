<!DOCTYPE html>
<html lang="en"> 

<?php
$infochildren = $contentModel->get_content(array('parent' => $content['safelink'])); 
$push_bg = ''; ; 
?>
<?=view('kadhub_prime/frontend/header'); ?>

<body class="<?=my_config('front_skin') ? "custom-theme" . my_config('des_accent_color_variant') : ""?>">

    <!-- Load Header -->
    <?=load_widget('frontend_header_widget', [], 'front')?>

    <?php $push_bg = my_config('first_home_section', null, 'white_section');
          if ($content['safelink'] === 'homepage' || (empty($infochildren) && !empty($content['content']))): 
          $push_bg = ($push_bg==='light_section') ? 'white_section' : 'light_section';?>
    <section id="team" class="section <?=$push_bg?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">
                    <!-- KAD<span>HUB</span> -->
                    <?=highlight_phrase($content['subtitle'], substr($content['subtitle'], round(strlen($content['subtitle'])/2), round(strlen($content['subtitle'])/2)), '<span>', '</span>');?>
                    <?=(!empty($user['uid']) && $user['admin'] >= 3) ? ' ' . anchor('admin/content/create/' . $content['id'], 'Edit', ['class'=>'btn btn-danger']) : ''?>
                </h2>
                <hr class="lines wow zoomIn" data-wow-delay="0.3s"> 
            </div>
            <p class="text-center wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.2s">
                <?=decode_html($content['content'])?>
            </p>
        </div>
    </section>
    <?php endif; ?>

    <?=load_widget('blog', [], 'front')?>

    <?php
        $i = 0;
    if (!empty($infochildren)): 
        foreach ($infochildren as $key => $info): 
            $i++;
            $push_bg = ($push_bg==='light_section') ? 'white_section' : 'light_section'; ?>  
    <section id="infochild<?=$i?>" class="section <?=$push_bg?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s"> 
                    <?=highlight_phrase($info['title'], substr($info['title'], round(strlen($info['title'])/2), round(strlen($info['title'])/2)), '<span>', '</span>');?>
                    <?=(!empty($user['uid']) && $user['admin'] >= 3) ? ' ' . anchor('admin/content/create/' . $info['id'], 'Edit', ['class'=>'btn btn-danger']) : ''?>
                </h2>
                <hr class="lines wow zoomIn" data-wow-delay="0.3s"> 
            </div>
            <?php if (!empty($info['banner'])): ?>
            <div class="row">
                <div class="col-md-4 container wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.1s">
                    <img class="w-100" src="<?=$creative->fetch_image($info['banner'], my_config('default_banner')); ?>" alt="">
                </div>
                <div class="col-md-8">
                    <p class="text-center wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.2s">
                        <?=decode_html($info['content'])?>
                    </p>
                </div>
            </div>
            <?php else: ?>
            <p class="text-center wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.2s">
                <?=decode_html($info['content'])?>
            </p>
            <?php endif; ?>
        </div>
    </section>
    <?php endforeach; 
    endif;
    $push_bg = ($push_bg==='light_section') ? 'white_section' : 'light_section'; ?>

    <?php if (!empty($content['services']) && !empty($services)): 
        $i = 0.0;
        ?> 
    <section id="services" class="section <?=$push_bg?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">
                    <?=_lang('our_services')?>
                </h2>
                <hr class="lines wow zoomIn" data-wow-delay="0.3s">
                <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">
                    <?=_lang('we_seek_to_provide_a_user_friendly_environment')?> 
                </p>
            </div>
            <div class="row align-items-center d-flex justify-content-center">
                <?php foreach ($services as $key => $feature): 
                    $i += 0.2;?> 
                <div class="col-md-4 col-sm-6">
                    <div class="item-boxes wow fadeInDown" data-wow-delay="<?=$i?>s">
                        <div class="icon">
                            <i class="<?=$feature['icon']?>"></i>
                        </div>
                        <h4><?=$feature['title']?></h4>
                        <p>
                            <?=$feature['details']?>
                        </p>
                        <p>&nbsp;</p>   
                    </div>
                </div>  
                <?php endforeach ?>  
            </div>
        </div>
    </section>
    <?php endif;
    $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; ?>

    <?php if (!empty($content['features']) && !empty($features)):  
        $limit  = ceil(count($features) / 2);
        $page1   = min(1, ceil( count($features)/ $limit )); 
        $offset1 = ($page1 - 1) * $limit;
        if( $offset1 < 0 ) $offset1 = 0;
        $page2   = min(2, ceil( count($features)/ $limit )); 
        $offset2 = ($page2 - 1) * $limit;
        if( $offset1 < 0 ) $offset2 = 0;?>
    <section id="features" class="section <?=$push_bg?>" data-stellar-background-ratio="0.2">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?=_lang('amazing_features')?>
                </h2>
                <hr class="lines">
                <p class="section-subtitle">
                    <?=_lang('focus_on_productivity')?>
                </p>
                <?=(!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/features/create', 'Create New', ['class'=>'btn btn-danger']) : ''?>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 col-sm-6">
                    <div class="content-left text-md-right">
                        <?php foreach (array_slice($features, $offset1, $limit) as $key => $feature): ?>
                        <div class="box-item left">
                            <span class="icon">
                            <i class="<?=$feature['icon']?>"></i>
                            </span>
                            <div class="text">
                                <h4>
                                    <?=$feature['title']?>     
                                </h4>
                                <p> 
                                    <?=nl2br($feature['details'])?> 
                                    <?=(!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/features/create/'.$feature['id'], 'Edit', ['class'=>'text-danger font-weight-bold']) : ''?>
                                </p>
                            </div>
                        </div> 
                        <?php endforeach ?>  
                    </div>
                </div>
                <div class="col-lg-4 d-none d-lg-flex">
                    <div class="show-box">
                        <img src="<?=$creative->fetch_image(my_config('feature_sprite'), my_config('default_banner')); ?>" alt="">
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="content-right text-left">
                        <?php foreach (array_slice($features, $offset2, $limit) as $key => $feature): ?>
                        <div class="box-item right">
                            <span class="icon">
                            <i class="<?=$feature['icon']?>"></i>
                            </span>
                            <div class="text">
                                <h4>
                                    <?=$feature['title']?>       
                                </h4>
                                <p> 
                                    <?=nl2br($feature['details'])?> 
                                    <?=(!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/features/create/'.$feature['id'], 'Edit', ['class'=>'text-danger font-weight-bold']) : ''?>
                                </p>
                            </div>
                        </div> 
                        <?php endforeach ?>  
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section';
         endif;?>

    <?php if (!empty($content['video'])): ?>
    <section class="video-promo section" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="video-promo-content text-center">
                        <h2 class="mt-4 wow zoomIn" data-wow-duration="1000ms" data-wow-delay="100ms">
                            <?=_lang('nothing_is_impossible')?>
                        </h2>
                        <p class="wow zoomIn" data-wow-duration="1000ms" data-wow-delay="100ms">
                            <?=_lang('learn_and_improve_your_skills')?>
                        </p>
                        <a href="<?=$content['video']?>" class="video-popup"><i class="lnr lnr-film-play"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
        $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section';
         endif;?>

    <?php if (!empty($content['gallery']) && !empty($galleries)):?>
    <section id="portfolios" class="section <?=$push_bg?>">

        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?=_lang('awesome_views')?></h2>
                <hr class="lines">
                <p class="section-subtitle">
                    <?=_lang('our_offices_are_well_suited')?>
                </p>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $gtags = $xt = [];
                    foreach ($galleries as $key => $gallery) {
                        $gtags[] = str_ireplace(' ', '', $gallery['category']);
                    }
                        
                    foreach (explode(',',implode(',', $gtags)) as $key => $vl) {
                        $xt[str_ireplace(' ', '_', $vl)] = ucwords(str_ireplace(['_','-'], ' ', $vl));
                    } ?>

                    <div class="controls text-center">
                        <a class="filter active btn btn-common" data-filter="all">
                            <?=_lang('all')?>
                        </a>
                        <?php foreach ($xt as $key => $gtags): ?>
                        <a class="filter btn btn-common" data-filter=".<?=$key?>">
                            <?=$gtags?>
                        </a>
                        <?php endforeach ?> 
                    </div>

                </div>

                <div id="portfolio" class="row">
                    <?php foreach ($galleries as $key => $gallery): ?>
                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix <?=str_ireplace(',', ' ', str_ireplace(' ', '', $gallery['category']))?>">
                        <div class="portfolio-item">
                            <div class="shot-item">
                                <?php if ($gallery['thumbnail']): ?> 
                                <a class="overlay" href="javascript:void(0)" onclick="modalImageViewer($(this))" data-src="<?=$creative->fetch_image($gallery['file'], my_config('default_banner'));?>"<?=(strtolower($gallery['type'])==='video') ? ' data-thumb="'.$gallery['thumbnail'].'"' : '' ?>>
                                    <img src="<?=$creative->fetch_image($gallery['thumbnail'], my_config('default_banner')); ?>" alt="" style="min-width: 550px; height: 265px" />
                                    <i class="lnr lnr-plus-circle item-icon"></i>
                                </a>
                                <?php elseif (strtolower($gallery['type'])==='image'): ?>
                                <a class="overlay lightbox" href="<?=$creative->fetch_image($gallery['file'], my_config('default_banner')); ?>">
                                    <img src="<?=$creative->fetch_image($gallery['file'], my_config('default_banner')); ?>" alt="" style="min-width: 550px; height: 265px" />
                                    <i class="lnr lnr-plus-circle item-icon"></i>
                                </a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>     
                </div>
            </div>
        </div> 
    </section>
    <?php
          $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; 
          endif;?>

    <?php if (!empty($content['pricing']) && !empty($hubs)):?>
    <section id="pricing" class="section pricing-section <?=$push_bg?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <?=_lang('our_office_space')?> 
                </h2>
                <hr class="lines">
                <p class="section-subtitle">
                    <?=_lang('our_office_spaces_are_purposefully_designed')?>
                </p>
            </div>
            <?=load_widget('pricing_tables', ['hubs' => $hubs])?> 
        </div>
    </section>    
    <?php
          $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; 
          endif;?>  


    <?php if (!empty($content['partners']) && !empty($partners)):?>
    <section id="clients" class="section <?=$push_bg?>">
        <div class="container"> 
            <div class="row" id="clients-scroller">
                <?php foreach ($partners as $key => $partner): ?> 
                <div class="client-item-wrapper">
                    <a href="<?=prep_url($partner['button'])?>" title="<?=$partner['details']?>" data-toggle="tooltip">
                        <img src="<?=$creative->fetch_image($partner['image'], my_config('default_banner')); ?>" alt="" style="max-width: 200px;">
                    </a>
                </div> 
                <?php endforeach ?>  
            </div>
        </div>
    </section>
    <?php
          $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; 
          endif;?>  

    <?php if (!empty($content['contact']) && (my_config('contact_address') || my_config('contact_email') || my_config('contact_phone'))): ?>
    <!--The contact sesction-->
    <section class="section <?=$push_bg?>" id="contact"> 
        <div class="contact-block">
            <div class="section-header"> 
                <h2 class="section-title">
                    <?=_lang('contact_us')?> 
                </h2>
                <hr class="lines">
            </div>
 
            <div class="contactSec">
                <div class="container">
                    <div class="contactinfo">
                        <div>
                            <h2> 
                                <?=_lang('contact_info')?> 
                            </h2>
                            <ul class="info">
                                <?php if (my_config('contact_address')): ?>
                                <li>
                                    <span><i class="fa fa-map fa-lg text-white"></i></span>
                                    <span>
                                        <?=my_config('contact_address')?>
                                    </span>
                                </li>
                                <?php endif ?>
                                <?php if (my_config('contact_email')): ?>
                                <li>
                                    <span><i class="fa fa-at fa-lg text-white"></i></span>
                                    <span>
                                        <?=my_config('contact_email')?>
                                    </span>
                                </li>
                                <?php endif ?>
                                <?php if (my_config('contact_phone')): ?>
                                <li>
                                    <span><i class="fa fa-phone fa-lg text-white"></i></span>
                                    <span>
                                        <?=my_config('contact_phone')?>
                                    </span>
                                </li>
                                <?php endif ?>
                            </ul>
                        </div>
                        <ul class="sci d-flex justify-content-center"> 
                            <?php if (my_config('contact_facebook')): ?>
                            <li>
                                <a href="<?=my_config('contact_facebook')?>">
                                    <span><i class="fab fa-facebook fa-lg text-white"></i></span>
                                </a>
                            </li>
                            <?php endif ?>
                            <?php if (my_config('contact_twitter')): ?>
                            <li>
                                <a href="<?=my_config('contact_twitter')?>">
                                    <span><i class="fab fa-twitter fa-lg text-white"></i></span>
                                </a>
                            </li>
                            <?php endif ?>
                            <?php if (my_config('contact_instagram')): ?>
                            <li>
                                <a href="<?=my_config('contact_instagram')?>">
                                    <span><i class="fab fa-instagram fa-lg text-white"></i></span>
                                </a>
                            </li>
                            <?php endif ?>
                            <?php if (my_config('contact_telegram')): ?>
                            <li>
                                <a href="<?=my_config('contact_telegram')?>">
                                    <span><i class="fab fa-telegram fa-lg text-white"></i></span>
                                </a>
                            </li>
                            <?php endif ?> 
                        </ul>
                    </div>
                    <div class="contactForm">
                        <h2>
                            <?=_lang('send_a_message')?>
                        </h2>
                        <?=form_open('#contact', ["class" => "formBox marketing-form row", "id" => "open_contact_form"])?> 
                            <input type="hidden" name="type" value="message">
                            <div class="inputBox w-md-50">
                                <input type="text" name="first_name" value="<?=set_value('first_name')?>" required>
                                <span><?=_lang('first_name')?></span>
                            </div>
                            <div class="inputBox w-md-50">
                                <input type="text" name="last_name" value="<?=set_value('last_name')?>" required>
                                <span><?=_lang('last_name')?></span>
                            </div>
                            <div class="inputBox w-md-50">
                                <input type="email" name="email" value="<?=set_value('email')?>" required>
                                <span><?=_lang('email_address')?></span>
                            </div>
                            <div class="inputBox w-md-50">
                                <input type="number" name="phone" value="<?=set_value('phone')?>" required>
                                <span><?=_lang('phone_number')?></span>
                            </div>
                            <div class="inputBox w100">
                                <textarea name="message" required><?=set_value('message')?></textarea>
                                <span><?=_lang('write_your_message_here')?></span>
                            </div> 
                            
                            <button type="submit" class="btn btn-block sub_btn btn-common"><?=_lang('send')?></button> 
                            <div class="col-12 message"></div>
                        <?=form_close()?> 
                    </div>
                </div>
            </div>
        </div>
        <div class="toggle-map">
            <a href="#" class="map-icon wow pulse" data-wow-iteration="infinite" data-wow-duration="500ms">
                <img src="<?=base_url('resources/theme/kadhub_prime/img/map-marker.png')?>" width="40px">
            </a>
        </div>
        <div id="google-map"> 
        <?php if (!my_config('google_api_key') && stripos(my_config('google_maps_latlang'),'http')!==false && stripos(my_config('google_maps_latlang'),'map')!==false): ?>
            <iframe src="<?=my_config('google_maps_latlang')?>" width="1300" height="450" frameborder="0" style="border:0;" allowfullscreen="true" aria-hidden="false" tabindex="0"></iframe>
        <?php elseif (!my_config('google_api_key') || count(explode(',', my_config('google_maps_latlang'))) !== 2): ?>
            <?=alert_notice("Invalid Map Settings", "error", false, false)?> 
        <?php endif; ?>
        </div>
    </section>
    <?php
          $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; 
          endif;?>  


    <?php if (!empty($content['subscription']) && my_config('mailjet_api_key') && my_config('mailjet_secret_key')): ?>
    <section id="subscribe" class="section <?=$push_bg?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title"><?=_lang('subscribe_newsletter')?></h2>
                <hr class="lines">
                <p class="section-subtitle"><?=_lang('subscribe_to_get_all_latest_news_from_us')?></p>
            </div>
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <?=form_open('#subscribe', ["class"=>"text-center form-inline position-relative marketing-form row", "id"=>"subscribe_form"])?>
                        <input type="hidden" name="type" value="subscribe">
                        <input type="text" class="mb-20 form-control" name="email" placeholder="<?=_lang('your_email')?>" value="<?=set_value('email')?>" required>
                        <button type="submit" class="sub_btn btn-common"><?=_lang('subscribe')?></button>
                        <div class="col-12 message"></div>
                    <?=form_close()?> 
                </div>
            </div>
        </div>
    </section>
    <?php endif;?>

    <?=view('kadhub_prime/frontend/footer'); ?>
    <?php //=load_widget('content/js_payment_processor_widget', ['load' => 1])?> 
</body> 

</html>