    <div class="col-md-12"> 
        <div class="card"> 
            <div class="card-header"> 
                <h5 class="card-title"><i class="fa fa-file fa-fw text-gray"></i>Manage Content</h5>
                <div class="float-right">
                    <a href="<?= site_url('admin/content/create')?>" class="btn btn-success text-white mr-1">Create New Page</a>
                </div> 
            </div>
            <div class="card-body"> 
                <!-- <?= form_open(uri_string(), ['method' => 'get']);?> -->
  <!--               <label class="text-info" for="parent">Filter by Parent</label>
                <div class="form-row">
                    <div class="form-group col">
                        <select class="form-control" id="parent" name="parent">
                            <option value="non" <?= set_select('parent', 'non') ?>>No Parent</option>
                            <option value="" <?= set_select('parent', '') ?>>All</option>
                            <?php foreach($parents AS $parent): ?> 
                            <?php 
                                $pager = $content_md->get_content(['safelink' => $parent['parent']]);
                                if($parent['parent'] != ''): ?>
                                    <?='<option value="'.$parent['parent'].'"'.set_select('parent', $parent['parent']).'>'.ucwords($pager['title']).'</option>' ?>   
                                <?php endif; ?>
                            <?php endforeach; ?> 
                        </select>
                    </div>

                    <div class="form-group col">
                        <button class="btn btn-primary btn-md font-weight-bold pass"><i class="fa fa-spinner"></i> Filter</button>
                    </div>
                </div> -->
                <!-- <?= form_close(); ?> -->

                <!-- <hr class="bg-warning"> -->

                <div class="row container">
                    <?php if($contents): ?> 

                    <table class="table table-bordered text-sm">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th>
                                <th>Content</th>   
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
      
                        <tbody>
                        <?php $i = 0;
                          foreach($contents AS $content): 
                            $i++; ?>  
                            <tr id="table_row_<?= $content['id'] ?>">
                                <td class="text-center">
                                    <?=$i; ?> 
                                </td>
                                <?php if(!$content['parent']): ?> 
                                <td class="text-info font-weight-bold">
                                    <a href="<?= site_url('page/'.$content['safelink']) ?>"><?= $content['title'] ?></a>
                                </td>
                                <?php else: ?> 
                                <td>
                                    <?= $content['title'] ?> 
                                </td>
                                <?php endif; ?> 
                                <td>
                                    <?=nl2br(word_wrap(strip_tags(word_limiter(decode_html($content['content']), 30)), 55));?>  
                                </td>   
                                <td class="td-actions text-right" style="min-width: 120px;">
                                    <a href="<?= site_url('admin/content/create/'.$content['id']);?>" class="btn btn-info btn-sm text-white">
                                        <i class="fa fa-edit fa-fw"></i>
                                    </a> 
                                    <?php if(!in_array($content['safelink'], ['homepage', 'footer', 'welcome', 'about', 'contact'])): ?> 
                                    <button 
                                        class="btn btn-danger text-white btn-sm deleter" 
                                        onclick="confirmAction('<?=site_url('admin/content/delete/'.$content['id']);?>', true)">
                                        <i class="fa fa-trash fa-fw"></i>
                                    </button>
                                    <?php endif; ?> 
                                </td>
                            </tr>  
                        <?php endforeach; ?> 
                        </tbody>
                    </table>
     
                    <?php else: ?>
                         No Pages
                    <?php endif; ?> 
                </div>

            </div> 
        </div>
    </div>
