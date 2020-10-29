		<div class="row"> 
			<div class="col-md-12"> 
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Feature' : 'Create Feature';?></h3>
					</div>
					<?=form_open_multipart('admin/features/'.$action.($id?'/'.$id:''))?>
						<?=csrf_field()?>
						<div class="card-body">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="<?=set_value('title', $feature['title']??'') ?>">
							</div>

							<div class="form-row"> 
								<div class="col form-group"> 
									<label for="feature">Feature Type</label>
									<select name="type" class="form-control" required>
										<option value="feature"<?=set_select('type', 'feature', ($feature['type']??'') == 'feature')?>>Feature</option>
										<option value="service"<?=set_select('type', 'service', ($feature['type']??'') == 'service')?>>Service</option>
										<option value="slider"<?=set_select('type', 'slider', ($feature['type']??'') == 'slider')?>>Slider Item</option>
									</select> 
								</div>
								<div class="col form-group"> 
									<label for="feature">Icon</label>
									<select name="icon" class="form-control" required>
										<?=pass_icon(1, set_value('icon', ($feature['icon']??'')), TRUE)?>
									</select> 
								</div>
							</div>

							<div class="form-group"> 
								<label for="details">Description</label>
								<textarea name="details" class="form-control"><?=set_value('details', $feature['details']??'') ?></textarea> 
							</div> 

	                        <div class="form-group">
	                            <div class="form-group">
	                                <label for="button">Button Link</label>
	                                <input type="text" class="form-control" name="button" placeholder="Button Link" value="<?=set_value('button', $feature['button']??'');?>"> 
	                            </div> 

	                            <label>Button Link Example: </label> <br>
	                            <code>[link=https://example.com class=primary-btn howit-btn] Example[/link]</code>
	                            <hr class="border-danger">
	                        </div>

	                        <div class="form-row col-md-12">
	                            <div class="form-group <?=($feature['image']??'')?'col-md-7':'col-md-12'?>">
									<label for="image">Banner Image</label>
	                                <div class="input-group">
	                                    <div class="custom-file">
	                                        <input type="file" name="image" class="custom-file-input" id="image"> 
											<label class="custom-file-label" for="image">Choose file</label>
	                                    </div>
	                                </div>
	                                <small class="text-muted">Image file for this feature</small>
	                                <?=$creative->upload_errors('site_logo', '<span class="text-danger">', '</span>')?>
	                            </div>
	                            <?php if ($feature['image']??''): ?>
	                            <div class="form-group <?=($feature['image']??'')?'col-md-5':'col-md-12'?>">
	                                <label class="text-info text-sm" for="image_preview">Banner Preview</label><br> 
	                                <img src="<?= $creative->fetch_image($feature['image']??'', my_config('default_banner')); ?>" style="max-height: 50px;" id="image_preview">
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
