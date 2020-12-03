    <?php if ((empty($content['slider']) || empty($sliders)) && !empty($content['banner'])): ?>
    <header id="hero-area" data-stellar-background-ratio="0.5" style="background-image: url('<?=$creative->fetch_image($content['banner'], my_config('default_banner')); ?>'); background-blend-mode: multiply; background-color: rgb(0 92 131 / 68%);">
    <?php else:?>
    <header id="slider-area">
    <?php endif;?>
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
                                    <?php foreach ($contentModel->get_content(
                                        ['parent'=>'non','in'=>'header','order_field'=>['name'=>'safelink','id'=>'homepage']]) as $key => $nl): ?>
                                    <li class="nav-item<?=active_page($nl['safelink'], $_page_name??$page_name)?>">
                                        <a class="nav-link" href="<?=site_url('page/'.$nl['safelink'])?>"><?=($nl['safelink'] == 'homepage' ? 'Home' : $nl['title'])?></a>
                                    </li>
                                    <?php endforeach ?> 
                                <?php endif ?> 
                                    <?php if (module_active('posts', my_config('frontend_theme', null, 'default'))):?>
                                    <li class="nav-item<?=active_page(['blog', 'posts'], $content['safelink'])?>">
                                        <a class="nav-link" href="<?=site_url('posts')?>"><?=_lang('blog')?></a>
                                    </li>
                                    <?php endif;?>
                                    <?php if (module_active('events', my_config('frontend_theme', null, 'default'))):?>
                                    <li class="nav-item<?=active_page('events', $content['safelink'])?>">
                                        <a class="nav-link" href="<?=site_url('events')?>"><?=_lang('events')?></a>
                                    </li>
                                    <?php endif;?>

                                    <?=(logged_user('admin') >= 3) ? '<li class="nav-item">'.anchor('admin/configuration', 'Configuration', ['class'=>'nav-link']).'</li>' : ''?>

                                    <li class="nav-item">
                                    <?=anchor(user_id() ? 'user/account' : 'login', user_id() ? logged_user('username') : 'Login', ['class'=>'nav-link'])?>
                                    </li> 
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div> 

        <?php if (!empty($content['slider']) && !empty($sliders)): 
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
                        <img src="<?=$creative->fetch_image($slider['image'], my_config('default_banner')); ?>" alt="" style="min-width: 100%;">
                        <div class="carousel-caption">
                            <h1 class="text-center"><?=nl2br(word_wrap(strip_tags(decode_html($slider['title'])), 26));?></h1>
                            <p><?=$slider['details']?></p>
                            <?=!empty($slider['button']) ? showBBcodes($slider['button'], 'btn btn-lg btn-border') : ''?>
                            <?=!empty($content['id']) && (!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/content/create/'.$content['id'], 'Edit ' . $content['title'], ['class'=>'btn btn-danger']) : ''?>
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
        <?php elseif (!empty($content['banner'])): ?> 
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-10">
                    <div class="contents text-center">
                        <h1 class="wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">
                            <?=nl2br(word_wrap(strip_tags(decode_html($content['title'])), 26));?>
                        </h1>
                        <div class="post-meta">
                        <?php if (!empty($post)): ?>
                            <?php if ($post['event_time']): ?>
                            <div class="date border-bottom mb-1">
                                <div class="font-weight-bold">
                                    <i class="lnr lnr-calendar-full"></i>
                                    <?=_lang('event_date', [date('M d, Y', $post['event_time'])])?>
                                </div>
                                <div class="font-weight-bold">
                                    <i class="lnr lnr-clock"></i>
                                    <?=_lang('event_time', [date('h:i A', $post['event_time'])])?>
                                </div>
                                <div class="font-weight-bold">
                                    <i class="lnr lnr-map-marker"></i>
                                    <?=_lang('event_venue', [$post['event_venue']])?>
                                </div>
                            </div>
                            <?php endif ?>
                            <ul>
                                <li><i class="lnr lnr-calendar-full"></i> <a href="#"><?=date('M d, Y', $post['time'])?></a></li>
                                <li><i class="lnr lnr-user"></i> <a href="#"><?=fetch_user('fullname', $post['uid'])?></a></li>
                                <?php 
                                      $count_comments = $postsModel->count_comments($post['post_id']);
                                      $count_comments += $postsModel->count_comments($post['post_id'], 'reply');
                                      if ($count_comments): ?>
                                <li>
                                    <i class="lnr lnr-bubble"></i> 
                                    <a href="#comments_section_<?=$post['post_id']?>"><?=$count_comments?> Comments</a>
                                </li> 
                                <?php endif ?>
                            </ul>
                        <?php else: ?>
                            <p><?=$content['intro']?></p>
                            <?=!empty($content['button']) ? showBBcodes($content['button'], 'btn btn-primary') : ''?>  
                            <?=!empty($content['id']) && (!empty($user['uid']) && $user['admin'] >= 3) ? anchor('admin/content/create/'.$content['id'], 'Edit ' . $content['title'], ['class'=>'btn btn-danger']) : ''?>
                        <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php elseif (!empty($content['breadcrumb'])): ?> 
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