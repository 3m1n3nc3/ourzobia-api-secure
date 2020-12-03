        <?=form_open_multipart('', 'class="form p-3 was-validated center-block create-post-update" id="my-dropzone"');?>
            <?=csrf_field()?>
            <?php if (!empty($item_id)): ?>
                <?=form_hidden('item_id', $item_id)?>
            <?php endif ?>
            <div class="form-row"> 
                <div class="col-md-6 form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?=set_value('title', $content['title']??'') ?>" required> 
                    <div class="invalid-feedback">Please enter a valid title.</div>
                </div> 

                <div class="col-md-6 form-group"> 
                    <label for="featured">Featured</label>
                    <select name="featured" class="form-control" id="featured" required>
                        <option value="0"<?=set_select('featured', '0', ($content['featured']??'') == '0')?>>Not Featured</option>
                        <option value="1"<?=set_select('featured', '1', ($content['featured']??'') == '1')?>>Featured</option> 
                    </select> 
                </div> 

                <div class="col-md-<?=($media_type??'') === 'event'?'6':'12' ?> form-group">
                    <label for="category">Tags</label>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter Tags" value="<?=set_value('category', $content['category']??'') ?>">
                </div>

                <?php if (($media_type??'') === 'event'): ?> 
                <div class="col-md-6 form-group">
                    <label for="event_time">Event Time</label>
                    <input type="text" class="form-control timepicker" name="event_time" id="event_time" placeholder="Event Time" value="<?=set_value('event_time', date('Y-m-d H:i:s', $content['event_time']??strtotime("NOW"))) ?>" autocomplete="off" required>
                    <div class="invalid-feedback">Please enter a valid event time.</div>
                </div>

                <div class="col-md-12 form-group">
                    <label for="event_venue">Event Venue</label>
                    <input type="text" class="form-control" name="event_venue" id="event_venue" placeholder="Event Venue" value="<?=set_value('event_venue', $content['event_venue']??'')?>" required>
                    <div class="invalid-feedback">Please enter a valid event venue.</div>
                </div>
                <?php endif ?>
            </div>

            <div class="form-group"> 
                <label for="details">Description</label>
                <textarea name="description" class="form-control textarea" id="details"<?=in_array(($media_type??''), ['event','blog','post'])?' required':'' ?>><?=set_value('description', decode_html($content['description']??'')) ?></textarea>
                <?php if (in_array(($media_type??''), ['event','blog','post'])): ?>
                <div class="invalid-feedback">Please enter a valid description.</div>
                <?php endif ?>
            </div>

            <?php if (!$item_id): ?>
            <div class="d-flex justify-content-center load-dropzone p-3">
                <button type="button" class="btn btn-warning load-dropzone"><i class="fa fa-plus"></i> Add Media Files</button>
            </div>
            <?php endif ?>

            <div class="dropzone-block" style="display: none;">
                <div class="d-flex justify-content-center font-weight-bold h7">
                    <div class="dropzone" style="max-width: auto;"></div>
                    <div class="dropzone-previews"></div>
                </div>
            </div>

            <input type="hidden" id="dz-checker" value="0">

            <button type="submit" class="d-none submit_btn" style="display: none">save</button>
        <?=form_close()?>

        <?php if (in_array(($media_type??''), ['event','blog','post'])) 
        {
            $tags = array_string_blast($postsModel->get_post(), 'tags');
        } 
        else
        {
            $tags = array_string_blast($contentModel->get_features([], 'gallery'), 'category');
        } ?> 
        
        <script> 
            $('#category').selectize({
                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
                delimiter: ',',
                persist: false,
                hideSelected: true,
                valueField: 'title',
                searchField: 'title',
                options: <?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values($tags))."\"}]"?>,
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

            $('.timepicker').datetimepicker({
                format:'Y-m-d H:i:s',
                mask:true
            });
            
            <?php if (in_array(($media_type??''), ['event','blog','post'])): ?>
            $('.textarea').each(function () { 
                var editor = new Jodit(this, {
                    uploader: {
                        url: link('ajax/jodit?action=fileUpload&privacy=user')
                    },
                    filebrowser: {
                        ajax: {
                            url: link('ajax/jodit?privacy=user')
                        }
                    }
                });
            });
            <?php endif ?>
        </script> 