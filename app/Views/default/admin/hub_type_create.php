		<div class="row"> 
			<div class="col-md-12"> 
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Feature' : 'Create Hub Category';?></h3>
					</div>
					<?=form_open_multipart('admin/hubs/'.$action.($id?'/'.$id:''));?>
						<?=csrf_field()?>
						<div class="card-body">
							<div class="form-group">
								<label for="name">Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Hub Category name" value="<?=set_value('name', $hub['name']??'') ?>" required>
							</div>

							<div class="form-row"> 
								<div class="col-md-6 form-group">
									<label for="seats">Available Seats</label>
									<input type="number" class="form-control" name="seats" id="seats" placeholder="Enter Available Seats" value="<?=set_value('seats', $hub['seats']??'') ?>" required>
								</div>

								<div class="col-md-6"> 
									<label for="icon">Icon</label>
									<div class="form-group"> 
										<?=icon_selector(4, set_value('icon', ($hub['icon']??'')), "form-control", "regular")?>
									</div>
								</div>

								<div class="col-md-4 form-group">
									<label for="price">Price (Per Minimum Duration)</label>
									<input type="number" class="form-control" name="price" id="price" placeholder="Price (Per Minimum Stay Duration Circle)" value="<?=set_value('price', $hub['price']??'') ?>">
								</div>

								<div class="col-md-4 form-group">
									<label for="duration">Minimum Duration</label>
									<input type="number" class="form-control" name="duration" id="duration" placeholder="Minimum Stay Duration in hours" value="<?=set_value('duration', $hub['duration']??'') ?>">
								</div>

								<div class="col-md-4 form-group"> 
									<label for="status">Status</label>
									<select name="status" class="form-control">
										<option value="0" <?=set_select('status', '0', ($hub['status']??'0')==='0')?>>Inactive</option>
										<option value="1" <?=set_select('status', '1', ($hub['status']??'1')==='1')?>>Active</option>
									</select> 
								</div>
							</div>

							<div class="form-group">
								<label for="facilities">Facilities</label>
								<input type="text" class="form-control" name="facilities" id="facilities" placeholder="Enter Comma, Separated Facilities" value="<?=set_value('facilities', $hub['facilities']??'') ?>">
							</div> 

							<div class="form-group"> 
								<label for="description">Description</label>
								<textarea name="description" class="form-control"><?=set_value('description', $hub['description']??'') ?></textarea>
							</div>  

	                        <div class="form-row col-md-12">
	                            <div class="form-group <?=($hub['banner']??'')?'col-md-7':'col-md-12'?>">
									<label for="banner">Banner Image</label>
	                                <div class="input-group">
	                                    <div class="custom-file">
	                                        <input type="file" name="banner" class="custom-file-input" id="banner"> 
											<label class="custom-file-label" for="banner">Choose file</label>
	                                    </div>
	                                </div>
	                                <small class="text-muted">Image file for this feature</small>
	                                <?=$creative->upload_errors('site_logo', '<span class="text-danger">', '</span>')?>
	                            </div>
	                            <?php if ($hub['banner']??''): ?>
	                            <div class="form-group <?=($hub['banner']??'')?'col-md-5':'col-md-12'?>">
	                                <label class="text-info text-sm" for="image_preview">Banner Preview</label><br> 
	                                <img src="<?= $creative->fetch_image($hub['banner']??'', my_config('default_banner')); ?>" style="max-height: 50px;" id="image_preview">
	                            </div>
	                            <?php endif ?>
	                        </div>
						</div> 
						<div class="card-footer">
							<button type="submit" class="btn btn-primary"><?=$id ? 'Save' : 'Create Category';?></button>
						</div>
					<?=form_close()?>
				</div>
			</div> 
		</div>
 
		<script>
		    window.onload = function() {  
	            $('#facilities').selectize({
	                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
	                delimiter: ',',
	                persist: false,
	                hideSelected: true,
	                valueField: 'title',
	                searchField: 'title',
	                options: <?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(array_string_blast($hubs_m->get_hub([], 'hubs'), 'facilities')))."\"}]"?>,
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
  
				$('select[name=icon]').fontIconPicker({
					theme: 'fip-bootstrap',
            		iconsPerPage: 25
				});   
		    }
		</script> 