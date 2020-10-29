		<div class="row"> 
			<div class="col-md-12"> 
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Item' : 'Add Item';?></h3>
					</div>
					<?=form_open_multipart('admin/gallery/'.$action.($id?'/'.$id:''))?>
						<?=csrf_field()?>
			            <div class="card-body">
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
			                    <textarea name="details" class="form-control"><?=set_value('details', $gallery['details']??'') ?></textarea> 
			                </div>   

			                <?php $image = $gallery['type']==='image'?$gallery['file']:$gallery['thumbnail']?>

	                        <div class="col-md-12 form-row">
	                            <div class="form-group <?=$image?'col-md-7':'col-md-12'?>">
									<label for="file">File</label>
	                                <div class="input-group">
	                                    <div class="custom-file">
	                                        <input type="file" name="file" class="custom-file-input" id="file"> 
											<label class="custom-file-label" for="file">Choose file</label>
	                                    </div>
	                                </div>
	                                <small class="text-muted">File for this gallery item</small>
	                                <?=$creative->upload_errors('site_logo', '<span class="text-danger">', '</span>')?>
	                            </div> 
	                            <?php if ($gallery['file']??''):?>
	                            <div class="form-group <?=$image?'col-md-5':'col-md-12'?>">
	                                <label class="text-info text-sm" for="image_preview">Preview</label><br> 
	                                <img src="<?=$creative->fetch_image($image, my_config('default_banner')); ?>" style="max-height: 50px;" id="image_preview">
	                            </div>
	                            <?php endif ?>
	                        </div>
						</div> 
						<div class="card-footer">
							<button type="submit" class="btn btn-primary"><?=$id ? 'Save' : 'Create Feature';?></button>
						</div>
					<?=form_close()?>
				</div>
			</div> 
		</div>
 

		<script>
		    window.onload = function() {  
	            $('#category').selectize({
	                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
	                delimiter: ',',
	                persist: false,
	                hideSelected: true,
	                valueField: 'title',
	                searchField: 'title',
	                options: <?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(array_string_blast($contentModel->get_features([], 'gallery'), 'category')))."\"}]"?>,
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
		    }
		</script> 
