    <div class="col-md-12"> 
        <div class="card"> 
            <div class="card-header"> 
                <h5 class="card-title"><i class="fa fa-file fa-fw text-gray"></i>Manage Content</h5>
                <div class="float-right">
                    <a href="<?= site_url('admin/content/create')?>" class="btn btn-success text-white mr-1">Create New Page</a>
                </div> 
            </div>
            <div class="card-body">  

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
