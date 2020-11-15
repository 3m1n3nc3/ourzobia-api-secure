<!DOCTYPE html>
<html lang="en"> 

<?php
$infochildren = $content_md->get_content(array('parent' => $content['safelink'])); 
$push_bg = ''; ; 
?>
<?=view('kadhub_prime/frontend/header'); ?>

<body class="<?=my_config('front_skin') ? "custom-theme" . my_config('des_accent_color_variant') : ""?>">

    <header id="slider-area">
        <div class="navbar-area w-100 bg-white fixed-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <nav class="navbar navbar-expand-lg mainmenu-area<?=my_config('des_nav_variant')?>">
                            <a class="navbar-brand" href="<?=site_url()?>"><img src="<?=$creative->fetch_image(my_config('site_logo'), 'logo')?>" alt="" style="max-height: 35px;"></a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                <?php if (my_config('scrollspy_nav')): ?>
                                    <li class="nav-item<?=active_page('homepage', $content['safelink'])?>">
                                        <a class="nav-link page-scroll" href="<?=site_url('#slider-area')?>"><?=_lang('home')?></a>
                                    </li> 
                                    <?php if ($content['safelink'] === 'homepage' && $content['content']):?>
                                    <li class="nav-item<?=active_page('about', $content['safelink'])?>">
                                        <a class="nav-link page-scroll" href="#team"><?=_lang('about_us')?></a>
                                    </li> 
                                    <?php else:?>
                                    <li class="nav-item<?=active_page('about', $content['safelink'])?>">
                                        <a class="nav-link page-scroll" href="<?=site_url('page/about')?>"><?=_lang('about_us')?></a>
                                    </li> 
                                    <?php endif;?>

                                    <?php if ($content['services']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#services"><?=_lang('services')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?php if ($content['features']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#features"><?=_lang('features')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?php if ($content['gallery']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#portfolios"><?=_lang('gallery')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?php if ($content['pricing']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#pricing"><?=_lang('pricing')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?php if ($content['contact']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#contact"><?=_lang('contact')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?php if ($content['subscription']):?>
                                    <li class="nav-item">
                                        <a class="nav-link page-scroll" href="#subscribe"><?=_lang('subscribe')?></a>
                                    </li> 
                                    <?php endif;?> 
                                <?php else:?>
                                    <?php foreach ($content_md->get_content(
                                        ['parent'=>'non','in'=>'header','order_field'=>['name'=>'safelink','id'=>'homepage']]) as $key => $nl): ?>
                                    <li class="nav-item<?=active_page($nl['safelink'], $_page_name??$page_name)?>">
                                        <a class="nav-link" href="<?=site_url('page/'.$nl['safelink'])?>"><?=($nl['safelink'] == 'homepage' ? 'Home' : $nl['title'])?></a>
                                    </li>
                                    <?php endforeach ?> 
                                <?php endif ?>
                                <?=(!empty($user['uid']) && $user['admin'] >= 3) ? '<li class="nav-item">'.anchor('admin/configuration', 'Configuration', ['class'=>'nav-link']).'</li>' : ''?> &nbsp;
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div> 

        <?php if ($content['slider'] && !empty($sliders)): 
            $i = 0?>
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php foreach ($sliders as $key => $slider): $i++?> 
                    <li data-target="#carousel-slider" data-slide-to="<?=$i-1?>"<?=active_page(1, $i, true)?>></li>
                    <?php endforeach ?>  
                </ol>
                <div class="carousel-inner" role="listbox">
                    <?php
                        $i = 0; foreach ($sliders as $key => $slider): $i++?>  
                    <div class="carousel-item<?=active_page(1, $i)?>">
                        <img src="<?=$creative->fetch_image($slider['image'], my_config('default_banner')); ?>" alt="">
                        <div class="carousel-caption">
                            <h1 class="text-center"><?=nl2br(word_wrap(strip_tags(decode_html($slider['title'])), 26));?></h1>
                            <p><?=$slider['details']?></p>
                            <?=$slider['button'] ? showBBcodes($slider['button'], 'btn btn-lg btn-border') : ''?>
                        </div>
                    </div>
                    <?php endforeach ?>   
                </div>
                <a class="carousel-control-prev" href="#carousel-slider" role="button" data-slide="prev">
                    <i class="lnr  lnr-arrow-left"></i>
                </a>
                <a class="carousel-control-next" href="#carousel-slider" role="button" data-slide="next">
                    <i class="lnr  lnr-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php elseif ($content['banner']): ?>
        <div id="carousel-area">
            <div id="carousel-slider" class="carousel slide" data-ride="carousel"> 
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="<?=$creative->fetch_image($content['banner'], my_config('default_banner')); ?>" alt="">
                        <div class="carousel-caption">
                            <h1><?=nl2br(word_wrap(strip_tags(decode_html($content['title'])), 26));?></h1> 
                            <p><?=$content['intro']?></p>
                            <?=$content['button'] ? showBBcodes($content['button'], 'btn btn-primary') : ''?>  
                            <?=(!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/content/create/'.$content['id'], 'Edit ' . $content['title'], ['class'=>'btn btn-danger']) : ''?>
                        </div>
                    </div>  
                </div> 
            </div>
        </div>
        <?php elseif ($content['breadcrumb']): ?> 
        <div class="mt-5 pt-xs-5 pt-lg-5 pb-4">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center"> 
                        <h2><?=$content['title']?></h2> 
                        <a href="<?=site_url()?>"><?=_lang('home')?></a>
                        <i class="fa fa-chevron-right"></i>
                        <span><?=$content['title']?></span> 
                    </div>
                </div>
            </div>
        </div> 
        <?php endif ?>
    </header>

    <?php if ($content['safelink'] === 'homepage' || (empty($infochildren) && !empty($content['content']))): ?>
    <section id="team" class="section">
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

    <?php
        $i = 0;
    if (!empty($infochildren)): 
        foreach ($infochildren as $key => $info): 
            $i++?>  
    <?php $push_bg = ($i % 2 === 0) ? 'light_section' : 'white_section';?>
    <section id="infochild<?=$i?>" class="section <?=($i % 2 !== 0)?'light_section':'white_section'?>">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">
                    <!-- KAD<span>HUB</span> -->
                    <?=highlight_phrase($info['title'], substr($info['title'], round(strlen($info['title'])/2), round(strlen($info['title'])/2)), '<span>', '</span>');?>
                    <?=(!empty($user['uid']) && $user['admin'] >= 3) ? ' ' . anchor('admin/content/create/' . $info['id'], 'Edit', ['class'=>'btn btn-danger']) : ''?>
                </h2>
                <hr class="lines wow zoomIn" data-wow-delay="0.3s"> 
            </div>
            <p class="text-center wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.2s">
                <?=decode_html($info['content'])?>
            </p>
        </div>
    </section>
    <?php endforeach; 
    endif;
    $push_bg = ($push_bg==='light_section') ? 'light_section' : 'white_section';?>

    <?php if ($content['services'] && !empty($services)): 
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

    <?php if ($content['features'] && !empty($features)):  
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
                                    <?=$feature['details']?> 
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
                                    <?=$feature['details']?> 
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

    <?php if ($content['video']): ?>
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

    <?php if ($content['gallery'] && !empty($galleries)):?>
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

    <?php if ($content['pricing'] && !empty($hubs)):?>
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


    <?php if ($content['contact'] && (my_config('contact_address') || my_config('contact_email') || my_config('contact_phone'))): ?>
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
        </div>
    </section>
    <?php
        $push_bg = ($push_bg==='white_section') ? 'light_section' : 'white_section'; 
          endif;?>  


    <?php if ($content['subscription'] && my_config('mailjet_api_key') && my_config('mailjet_secret_key')): ?>
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
                        <input type="text" class="mb-20 form-control" name="email" placeholder="Your Email Address" value="<?=set_value('email')?>" required>
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