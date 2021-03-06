		<div class="row"> 
			<div class="col-md-8"> 
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
								<div class="col-lg-8 form-group"> 
									<label for="feature">Feature Type</label>
									<select name="type" class="form-control" required>
										<option value="feature"<?=set_select('type', 'feature', ($feature['type']??'') == 'feature')?>>Feature</option>
										<option value="service"<?=set_select('type', 'service', ($feature['type']??'') == 'service')?>>Service</option>
										<option value="slider"<?=set_select('type', 'slider', ($feature['type']??'') == 'slider')?>>Slider Item</option>
										<option value="partner"<?=set_select('type', 'partner', ($feature['type']??'') == 'partner')?>>Partner</option>
									</select> 
								</div>
								<div class="col-lg-4"> 
									<label for="feature">Icon</label>
									<div class="form-group"> 
										<?=icon_selector(4, set_value('icon', ($hub['icon']??'')), "form-control", "regular")?>
									</div>
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
	                            <code>[link=https://example.com class=btn btn-primary]Example Button[/link]</code>
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

			<div class="col-md-4"> 
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title">Features</h3>
						<a href="<?=site_url('admin/features/create')?>" class="btn btn-sm btn-success ml-2">Add New</a> 
					</div>
					<div class="card-body px-0">
						<table class="table table-hover">
							<thead>
								<tr> 
									<th>Title</th>
									<th>Icon</th>  
									<th><i class="fa fa-wrench fa-fw"></i></th>
								</tr>
							</thead>
							<tbody class="todo-list" data-widget="todo-list" data-data='{"table":"features"}'>
							<?php if ($features): 
								$i = 0?>
								<?php foreach ($features as $key => $featureX): 
									$i++;?>
								<tr id="item-<?=$featureX['id']?>"<?=$id===$featureX['id'] ? ' class="shadow border border-info"' : '';?>> 
									<td>
			                            <span class="handle p-0 m-0">
			                                <i class="fas fa-ellipsis-v"></i>
			                                <i class="fas fa-ellipsis-v"></i>
			                            </span>
			                            <?=$featureX['title']?>
			                        </td> 
									<td>
			                            <?php if ($featureX['image']): ?> 
			                               <img src="<?= $creative->fetch_image($featureX['image']??'', my_config('default_banner')); ?>" style="max-height: 15px;" id="image_preview"> 
			                            <?php else: ?>
										<span class="badge bg-success">
											<i class="<?=$featureX['icon']?> fa-fw"></i> 
										</span>
			                            <?php endif ?>
									</td> 
									<td>
										<a href="<?=site_url('admin/features/create/'.$featureX['id'])?>"><i class="fa fa-edit text-info fa-fw"></i></a>
	                                    <a href="javascript:void(0)"
	                                        class="deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/features/delete/'.$featureX['id']);?>', true)">
	                                        <i class="text-danger fa fa-trash fa-fw"></i>
	                                    </a>  
									</td>
								</tr> 
								<?php endforeach ?>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">
			// Make sure to fire only when the DOM is ready
			window.onload = function() {  
				let fi_cons = $('select[name=icon]').fontIconPicker({
					theme: 'fip-bootstrap',
            		iconsPerPage: 25
				});  
        		fi_cons.setIcon( '<?=set_value('icon', ($feature['icon']??''))?>' );
        		
	            $(document).on("shown", function(e) {
	                $(".selector-popup-wrap.icons-selector").attr("style", "left: -100px; top: 76px;"); 
	            });
			}
		</script>