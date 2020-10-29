        <?=form_open_multipart('admin/features/', 'class="form center-block create-post-update" id="my-dropzone"')?>
            <?=csrf_field()?>
            <div class="modal-header" >
                Upload Media
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <div class="form-row"> 
                    <div class="col-md-6 form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?=set_value('title', $gallery['title']??'') ?>">
                    </div> 

                    <div class="col-md-6 form-group"> 
                        <label for="featured">Featured</label>
                        <select name="featured" class="form-control" required>
                            <option value="0"<?=set_select('featured', '0', ($gallery['featured']??'') == '0')?>>Not Featured</option>
                            <option value="1"<?=set_select('featured', '1', ($gallery['featured']??'') == '1')?>>Featured</option> 
                        </select> 
                    </div> 
                </div>

                <div class="form-group">
                    <label for="category">Tags</label>
                    <input type="text" class="form-control" name="category" id="category" placeholder="Enter Tags" value="<?=set_value('category', $gallery['category']??'') ?>">
                </div>

                <div class="form-group"> 
                    <label for="details">Description</label>
                    <textarea name="description" class="form-control"><?=set_value('details', $feature['details']??'') ?></textarea> 
                </div>  
                <div class="d-flex justify-content-center font-weight-bold h7">
                    <div class="dropzone" style="max-width: auto;"></div>
                    <div class="dropzone-previews"></div>
                </div>
            </div> 
            <div class="modal-footer">
                <button class="btn close text-sm small" data-dismiss="modal" aria-label="Close">Discard</button>
                <button type="submit" class="btn btn-primary submit_btn">Upload</button>
            </div>
        <?=form_close()?>