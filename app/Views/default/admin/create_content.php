f<div class="content">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="float-right">
                    <?php if (empty($content['parent']) && isset($content['safelink'])): ?>
                        <?=form_open('admin/content/create');?>
                        <input type="hidden" name="parent" value="<?=$content['safelink'];?>">
                        <input type="hidden" name="link_parent" value="true">
                        <button type="submit" class="btn btn-primary text-white mr-1">Link with New Content</button>
                        <?=form_close() ?>
                    <?php endif ?>
                    </div>
                    <h5 class="card-title">
                        <i class="fa fa-file fa-fw text-gray"></i>
                        <?php
                            $parent = $parent ?? set_value('parent');
                            $pager  = $content_md->get_content(['safelink' => $parent]);?>
                        <?=$parent ? 'Create Content for '.$pager['title'] : 'Create Page';?>
                    </h5>
                </div>
                <?=form_open(uri_string(), ['id' => 'sett_form', 'class' => 'needs-validation', 'novalidate' => null]);?>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-6 pr-1">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" onkeyup="safeLinker(this)" class="form-control" name="title" placeholder="Title" value="<?=set_value('title', $content['title']??'');?>">
                                <?=$errors->showError('title', 'my_single_error');?>
                            </div>
                        </div>
                        <div class="col-md-6 pl-1">
                            <div class="form-group">
                                <label for="safelink">Safelink</label>
                                <input type="text" class="form-control" name="safelink" placeholder="Safelink" value="<?=set_value('safelink', $content['safelink']??'');?>">
                                <?=$errors->showError('safelink', 'my_single_error');?>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-4 pr-1">
                            <div class="form-group">
                                <label for="icon">Icon</label>
                                <select class="form-control" id="icon" name="icon">
                                    <?=pass_icon(1, set_value('icon', $content['icon']??''), TRUE);?>
                                </select>
                                <?=$errors->showError('icon', 'my_single_error');?>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="align">Align Items</label>
                                <select class="form-control" id="align" name="align">
                                    <option value="left" <?=set_select('align', 'left', ($content['align']??null) == 'left' ? 1 : 0) ?>>Left</option>
                                    <option value="right" <?=set_select('align', 'right', ($content['align']??null) == 'right' ? 1 : 0) ?>>Right</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 pl-1">
                            <div class="form-group">
                                <label for="priority">Priority</label>
                                <select class="form-control" id="priority" name="priority">
                                    <option value="1" <?=set_select('priority', '1', (($content['priority']??'') == '1' ? 1 : 0)) ?>>1</option>
                                    <option value="2" <?=set_select('priority', '2', (($content['priority']??'') == '2' ? 1 : 0)) ?>>2</option>
                                    <option value="3" <?=set_select('priority', '3', (($content['priority']??'') == '3' ? 1 : 0)) ?>>3</option>
                                    <option value="4" <?=set_select('priority', '4', (($content['priority']??'') == '4' ? 1 : 0)) ?>>4</option>
                                    <option value="5" <?=set_select('priority', '5', (($content['priority']??'') == '5' ? 1 : 0)) ?>>5</option>
                                </select>
                                <?=$errors->showError('priority', 'my_single_error');?>
                            </div>
                        </div>
                        <div class="col-md-6 px-1">
                            <div class="form-group">
                                <label for="color">Color</label>
                                <input type="text" class="form-control" name="color" placeholder="Color" value="<?=set_value('color', $content['color']??'');?>">
                                <small class="text-primary">Use bootstrap Colors</small>
                                <?=$errors->showError('color', 'my_single_error');?>
                            </div>
                        </div>
                        <div class="col-md-6 px-1">
                            <div class="form-group">
                                <label for="col">Colum</label>
                                <select class="form-control" id="col" name="col">
                                    <option value="" <?=set_select('col', '', (($content['col']??'') == '')) ?>>None</option> 
                                    <option value="col-lg-6 col-md-6" <?=set_select('col', 'col-lg-6 col-md-6', (($content['col']??'') == 'col-lg-6 col-md-6')) ?>>col-lg-6 col-md-6</option> 
                                    <option value="col-md-6" <?=set_select('col', 'col-md-6', (($content['col']??'') == 'col-md-6')) ?>>col-md-6</option> 
                                    <option value="col-lg-6" <?=set_select('col', 'col-lg-6', (($content['col']??'') == 'col-lg-6')) ?>>col-lg-6</option> 
                                    <option value="col-sm-6" <?=set_select('col', 'col-sm-6', (($content['col']??'') == 'col-sm-6')) ?>>col-sm-6</option> 
                                </select>
                                <small class="text-primary">Use bootstrap Colums</small>
                                <?=$errors->showError('color', 'my_single_error');?>
                            </div>
                        </div>
                        <?php if (set_value('parent') OR $parent):?>
                        <input type="hidden" name="parent" id="parent" value="<?=$parent?>">
                        <?php else: ?>
                        <input type="hidden" name="parent" id="parent" value="">
                        <?php endif ?>
                        <div class="form-group col-md-12<?php //echo set_value('parent') ? '12' : '6' ?>">
                            <div class="form-group">
                                <label for="button">Button Link</label>
                                <input type="text" class="form-control" name="button" placeholder="Button Link" value="<?=set_value('button', $content['button']??'');?>">
                                <?=$errors->showError('button', 'my_single_error');?>
                            </div> 

                            <label>Button Link Example: </label> <br>
                            <code>[link=https://example.com class=primary-btn howit-btn] Example[/link]</code>
                            <hr class="border-danger">
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="video">Video Link</label>
                                <input type="text" class="form-control" name="video" placeholder="https://www.youtube.com/watch?v=RpvAmG1NNN0" value="<?=set_value('video', $content['video']??'');?>">
                                <small class="text-primary">
                                    Use youtube video links (Does not apply to whole site)<br>
                                    https://www.youtube.com/watch?v=RpvAmG1NNN0, https://www.youtube.com/embed/tgbNymZ7vqY
                                </small>
                                <?=$errors->showError('video', 'my_single_error');?>
                            </div>
                        </div>

                        <div class="form-group col-12 m-0 p-0 <?=($content['parent']??'') || set_value('parent') ? 'd-none' : '';?>"> 
                            <div class="form-check">
                                <label class="form-check-label mr-5" for="in_footer">
                                    <input name="in_footer" class="form-check-input text-primary" type="checkbox" value="1" <?=set_checkbox('in_footer', '1', int_bool((int)($content['in_footer']??''))) ?> id="in_footer">
                                    Show in Footer
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>  
                                <label class="form-check-label mr-5" for="in_header">
                                    <input name="in_header" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('in_header', '1', int_bool((int)($content['in_header']??''))) ?> id="in_header">
                                    Show in Header
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label> 
                                <label class="form-check-label mr-5" for="services">
                                    <input name="services" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('services', '1', int_bool((int)($content['services']??''))) ?> id="services">
                                    Show Services
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="features">
                                    <input name="features" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('features', '1', int_bool((int)($content['features']??''))) ?> id="features">
                                    Show Features
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="contact">
                                    <input name="contact" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('contact', '1', int_bool((int)($content['contact']??''))) ?> id="contact">
                                    Show Contact
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="subscription">
                                    <input name="subscription" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('subscription', '1', int_bool((int)($content['subscription']??''))) ?> id="subscription">
                                    Show Subscription
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="slider">
                                    <input name="slider" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('slider', '1', int_bool((int)($content['slider']??''))) ?> id="slider">
                                    Show Slider
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="gallery">
                                    <input name="gallery" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('gallery', '1', int_bool((int)($content['gallery']??''))) ?> id="gallery">
                                    Show Gallery
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="pricing">
                                    <input name="pricing" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('pricing', '1', int_bool((int)($content['pricing']??''))) ?> id="pricing">
                                    Show Pricing
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                                <label class="form-check-label mr-5" for="breadcrumb">
                                    <input name="breadcrumb" class="form-check-input text-primary" type="checkbox" value="1"<?=set_checkbox('breadcrumb', '1', int_bool((int)($content['breadcrumb']??''))) ?> id="breadcrumb">
                                    Breadcrumb Section
                                    <span class="form-check-sign">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <hr class="border-danger">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="intro">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" placeholder="Subtitle" value="<?=set_value('subtitle', $content['subtitle']??'');?>">
                                <?=$errors->showError('subtitle', 'my_single_error');?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="intro">Introductory Text</label>
                                <input type="text" class="form-control" name="intro" placeholder="Introductory Text" value="<?=set_value('intro', $content['intro']??'');?>">
                                <?=$errors->showError('intro', 'my_single_error');?>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="content">Content</label>
                            <textarea class="form-control textarea" id="content" name="content"><?=decode_html(($content['content']??''));?></textarea>
                            <?=$errors->showError('content', 'my_single_error');?>
                        </div>
                        
                        <div class="col-md-12">
                            <div>
                                <?php if ($content): ?>
                                <button type="submit" class="btn btn-success">Update Content</button>
                                <?php else: ?>
                                <button type="submit" class="btn btn-success">Create Content</button>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?=form_close() ?>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h5 class="card-title"><?=lang('content_image') ?></h5>
                </div>
                <div class="card-body box-profile">
                    <div class="text-center mb-3">
                        <a href="javascript:void(0)" onclick="modalImageViewer('.profile-user-img')">
                            <img class="profile-user-img img-fluid border-gray page" src="<?=$creative->fetch_image(($content['banner']??''), 'banner');?>" alt="...">
                        </a>
                    </div>
                    
                    <?php if ($content): ?>
                    <div id="upload_resize_image"
                        data-vwwidth="425"
                        data-vwheight="290"
                        data-bwwidth="430"
                        data-bwheight="295"
                        data-endpoint="content" 
                        data-endpoint_id="<?= $content['id']; ?>" 
                        class="d-none" 
                        style="display:none;">
                    </div>
                    <button class="btn btn-success btn-block text-white upload_resize_image"
                        type="button" 
                        id="resize_image_button"  
                        data-modal-title = "Upload Banner" 
                        data-type="wide" 
                        data-endpoint="content" 
                        data-endpoint_id="<?=$content['id']?>" 
                        data-toggle="modal" 
                        data-target="#uploadModal">
                        <b>Change Image</b>
                    </button>
                    <?php else: ?>
                    <?php alert_notice('Save to Upload Banner', 'info', TRUE, 'FLAT') ?>
                    <?php endif;?>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?=$children_title ?></h5>
                </div>
                <div class="card-body px-0">
                    <ul class="todo-list" data-widget="todo-list">
                        <?php if ($children): ?>
                        <?php $i = 0 ?>
                        <?php foreach ($children AS $child): ?>
                        <?php $i++ ?>
                        <li id="item-<?=$child['id']?>">
                            <!-- drag handle -->
                            <span class="handle">
                                <i class="fas fa-ellipsis-v"></i>
                                <i class="fas fa-ellipsis-v"></i>
                            </span>
                            <!-- checkbox -->
                            <div  class="icheck-primary d-inline ml-2">
                                <input type="checkbox" value="" name="todo<?=$child['id']?>" id="SortItem-<?=$child['id']?>" disabled <?=($content['id']??'') === $child['id'] ? ' checked' : ''?>>
                                <label for="todoCheck1"></label>
                            </div>
                            <!-- todo text -->
                            <span class="text">
                                <a href="<?=site_url('admin/content/create/'.$child['id'])?>"><?=$child['title'] ?></a>
                            </span>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <a href="<?=site_url('admin/content/create/'.$child['id'])?>"><i class="far fa-edit"></i></a>
                                <?php if(!in_array($child['safelink'], ['homepage', 'footer', 'welcome', 'about', 'contact'])): ?> 
                                <button class="btn btn-danger text-white m-1 deleter btn-sm"
                                onclick="confirmAction('<?=site_url('admin/content/delete/'.$child['id']);?>', true)">
                                <i class="fa fa-trash fa-fw"></i>
                                </button>
                                <?php endif;?>
                            </div>
                        </li>
                        <?php endforeach;?>
                        <?php else: ?>
                        <?=alert_notice('This page has no content', 'info', false, 'FLAT')?>
                        <?php endif;?>
                    </ul>
                    <span id="sort_message"></span>
                </div>
            </div>
        </div>
        
    </div>
</div>
