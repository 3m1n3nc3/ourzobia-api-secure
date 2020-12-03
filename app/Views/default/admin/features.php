		<div class="row"> 
			<div class="col-md-12 my-3">  
				<a href="<?=site_url('admin/features/create')?>" class="btn btn-success">Add Feature</a> 
			</div>
			<div class="col-md-8 table-responsive"> 
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Features</h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Title</th>
									<th>Type</th>
									<th>Icon</th>  
									<th style="width: 200px">Actions</th>
								</tr>
							</thead>
							<tbody class="todo-list" data-widget="todo-list" data-data='{"table":"features"}'>
							<?php if ($features): 
								$i = 0?>
								<?php foreach ($features as $key => $feature): 
									$i++;?>
								<tr id="item-<?=$feature['id']?>">
									<td><?=$i?>.</td>
									<td data-toggle="tooltip" title="<?=$feature['details']?>"><?=$feature['title']?></td> 
									<td><?=strtoupper($feature['type'])?></td> 
									<td>
			                            <?php if ($feature['image']): ?> 
			                               <img src="<?= $creative->fetch_image($feature['image']??'', my_config('default_banner')); ?>" style="max-height: 40px;" id="image_preview"> 
			                            <?php else: ?>
										<span class="badge bg-success">
											<i class="<?=$feature['icon']?> fa-2x fa-fw"></i> 
										</span>
			                            <?php endif ?>
									</td> 
									<td>
										<a href="<?=site_url('admin/features/create/'.$feature['id'])?>" class="btn m-0 p-0">
	                                        <i class="fa fa-edit fa-fw text-info"></i>
	                                    </a>
	                                    <button 
	                                        class="btn text-white m-0 p-0 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/features/delete/'.$feature['id']);?>', true)">
	                                        <i class="fa fa-trash fa-fw text-danger"></i>
	                                    </button>  
			                            <span class="handle p-0 m-0">
			                                <i class="fas fa-ellipsis-v"></i>
			                                <i class="fas fa-ellipsis-v"></i>
			                            </span>
									</td>
								</tr> 
								<?php endforeach ?> 
							<?php else:?> 
								<tr><td colspan="5"><?php alert_notice("No features listed", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> 
			<div class="col-md-4"> 
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-info">Features Sprite</h3>
					</div>
					<div class="card-body p-0">
		            <?=form_open_multipart('admin/features/config', ['id' => 'paform', 'class' => 'needs-validation row container', 'novalidate' => null]); ?> 
	                    <div class="form-group col-md-12 m-2"> 
	                        <div class="input-group">
	                            <div class="custom-file">
	                                <input type="file" name="feature_sprite" class="custom-file-input" id="feature_sprite" accept="image/*">
	                                <label class="custom-file-label" for="feature_sprite">Choose file</label>
	                            </div>
	                        </div>
	                        <small class="text-muted">The sprite image in-between the feature list</small>
	                        <?=$creative->upload_errors('feature_sprite', '<span class="text-danger">', '</span>')?>
	                    </div>

	                    <div class="form-group col-md-7"> 
	                        <a href="<?=site_url('admin/features/config?remove=feature_sprite#paform')?>" class="float-left hover shadow m-2 px-2 rounded pt-1"><i class="fa fa-times fa-lg text-danger"></i></a>
	                        <img src="<?=$creative->fetch_image(my_config('feature_sprite'), my_config('default_banner')); ?>" style="max-height: 50px;" id="logo_preview">
	                    </div> 
	                    <div class="form-group col-md-5">
		                	<button type="submit" class="btn btn-block btn-info btn-round btn-md text-white mb-3">Upload</button> 
	                    </div> 
		            <?=form_close(); ?>
		        	</div>
		    	</div>
		    </div>
		</div>
