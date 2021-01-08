		<div class="row">  
			<div class="col-md-8 table-responsive"> 
				<?php if (!empty($updates) && $action !== 'create_update'): ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?="Update Files for {$product['name']}"?> </h3>
						<a href="<?=site_url("admin/products/create_update/{$product['id']}")?>" class="btn btn-info btn-sm float-right">Create New</a>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Title</th>
									<th>Type</th>
									<th>Status</th>  
									<th style="width: 200px">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php if (!empty($updates)): 
								$i = 0?>
								<?php foreach ($updates as $key => $update): 
									$i++;?>
								<tr id="item-<?=$update['id']?>" <?=($id??null)===$update['id']?' class="bg-warning"':''?>>
									<td><?=$i?>.</td>
									<td data-toggle="tooltip" title="<?=$update['title']?>"><?=$update['title']?></td> 
									<td><?=ucwords($update['type'])?></td> 
									<td>
			                            <?php if ($update['status']): ?> 
										<span class="badge bg-success">
											Active
										</span>
			                            <?php else: ?>
										<span class="badge bg-danger">
											Inactive
										</span>
			                            <?php endif ?>
									</td> 
									<td>
										<a href="<?=site_url("download/" . base64_url($update['file']))?>" class="btn m-0 p-0">
	                                        <i class="fa fa-download fa-fw text-info"></i>
	                                    </a>
										<a href="<?=site_url("admin/products/create_update/{$product['id']}/{$update['id']}")?>" class="btn m-0 p-0">
	                                        <i class="fa fa-edit fa-fw text-info"></i>
	                                    </a>
	                                    <button 
	                                        class="btn text-white m-0 p-0 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/products/delete_update/'.$update['id']);?>', true)">
	                                        <i class="fa fa-trash fa-fw text-danger"></i>
	                                    </button>   
									</td>
								</tr> 
								<?php endforeach ?> 
							<?php else:?> 
								<tr><td colspan="5"><?php alert_notice("No products Updates listed", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php elseif (!empty($product) || !empty($update)): ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?="Create Update for {$product['name']}"?></h3>
						<a href="<?=site_url("admin/products/create_update/{$product['id']}")?>" class="btn btn-info btn-sm float-right">Create New</a>
					</div>
					<div class="card-body p-0">
				    <?=form_open_multipart('admin/products/create_update' . ($id??null ? '/' . $id : '') . ($update['id']??'' ? '/' . $update['id']??'' : ''), ['id' => 'paform2', 'class' => 'needs-validation container', 'novalidate' => null]); ?>  
						<div class="form-row">
							<div class="form-group col-md-12 mt-1">
								<label for="title">Update Title</label>
								<input type="text" class="form-control" name="title" id="title" placeholder="Enter Update Title" value="<?=set_value('title', $update['title']??'') ?>">
		                        <small class="text-muted">The title for the product update</small> 
							</div> 

							<div class="form-group col-md-6"> 
								<label for="type">Type</label>
								<select name="type" class="form-control" required>
									<option value="security"<?=set_select('type', ($update['type']??''), ($update['type']??'')=='security')?>>Security</option>
									<option value="update"<?=set_select('type', ($update['type']??''), ($update['type']??'')=='update')?>>Update</option>
									<option value="upgrade"<?=set_select('type', ($update['type']??''), ($update['type']??'')=='upgrade')?>>Upgrade</option>
									<option value="validation"<?=set_select('type', ($update['type']??''), ($update['type']??'')=='validation')?>>Validation</option>
								</select> 
							</div>

							<div class="form-group col-md-6"> 
								<label for="status">Status</label>
								<select name="status" class="form-control" id="status" required>
									<option value="0"<?=set_select('status', ($update['status']??''), ($update['status']??'')==0)?>>Inactive</option>
									<option value="1"<?=set_select('status', ($update['status']??''), ($update['status']??'')==1)?>>Active</option>
								</select> 
							</div>

							<div class="form-group col-md-12 mt-1">
								<label for="message">Update Message</label>
								<input type="text" class="form-control" name="message" id="message" placeholder="Enter Update Message" value="<?=set_value('message', $update['message']??'') ?>">
		                        <small class="text-muted">The Message to show to client</small> 
							</div> 

                            <div class="form-group col-md-12">
								<label for="package">Update Package</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="package" class="custom-file-input" id="package" accept=".zip"> 
										<label class="custom-file-label" for="package">Choose file</label>
                                    </div>
                                </div>
                                <small class="text-muted">File associated with this update</small>
                                <?=$creative->upload_errors('file', '<span class="text-danger">', '</span>')?>
                            </div>

							<div class="form-group col-md-12"> 
								<button type="submit" class="btn btn-primary"><?=($update['id']??null) ? 'Save Product Update' : 'Create Product Update';?></button> 
								<a href="<?=site_url("admin/products/create/{$product['id']}")?>" class="btn btn-info">Return to list</a>
							</div>
			        	</div>
				    <?=form_close(); ?>
					</div>
				</div>
				<?php endif ?>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Products</h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Name</th>
									<th>Identified As</th>
									<th>Status</th>  
									<th style="width: 200px">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php if ($products): 
								$i = 0?>
								<?php foreach ($products as $key => $listed_product): 
									$i++;?>
								<tr id="item-<?=$listed_product['id']?>" <?=($id??null)===$listed_product['id']?' class="bg-warning"':''?>>
									<td><?=$i?>.</td>
									<td data-toggle="tooltip" title="<?=$listed_product['name']?>"><?=$listed_product['name']?></td> 
									<td><?=$listed_product['title']?></td> 
									<td>
			                            <?php if ($listed_product['status']): ?> 
										<span class="badge bg-success">
											Active
										</span>
			                            <?php else: ?>
										<span class="badge bg-danger">
											Inactive
										</span>
			                            <?php endif ?>
									</td> 
									<td>
										<a href="<?=site_url('admin/products/create/'.$listed_product['id'])?>" class="btn m-0 p-0">
	                                        <i class="fa fa-edit fa-fw text-info"></i>
	                                    </a>
	                                    <button 
	                                        class="btn text-white m-0 p-0 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/products/delete/'.$listed_product['id']);?>', true)">
	                                        <i class="fa fa-trash fa-fw text-danger"></i>
	                                    </button>   
									</td>
								</tr> 
								<?php endforeach ?> 
							<?php else:?> 
								<tr><td colspan="5"><?php alert_notice("No products listed", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> 
			<div class="col-md-4" id="creative"> 
		    <?=form_open_multipart('admin/products/create' . ($id??null ? '/' . $id : ''), ['id' => 'paform', 'class' => 'needs-validation row container', 'novalidate' => null]); ?> 
				<div class="card">
					<div class="card-header">
						<h3 class="card-title text-info">Create Product</h3>
					</div>
					<div class="card-body form-row">
						<div class="form-group col-md-12">
							<label for="name">Product Name</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name" value="<?=set_value('name', $product['name']??'') ?>">
	                        <small class="text-muted">The name for the product</small>
	                        <?=$creative->upload_errors('feature_sprite', '<span class="text-danger">', '</span>')?>
						</div>
 
						<div class="form-group col-md-12">
							<label for="licenses">Available Licenses</label>
							<input type="text" class="form-control selectize" name="licenses" id="licenses" placeholder="Enter Product Name" value="<?=set_value('licenses', implode(',', toArray(json_decode($product['licenses']??''))??[])) ?>" data-options='<?="[{\"title\": \"".implode("\"},\n{\"title\": \"",array_values(array_string_blast($main_products_m->get_products(), 'licenses')))."\"}]"?>'>
	                        <small class="text-muted">For checking if user has correct license</small>
	                        <?=$creative->upload_errors('feature_sprite', '<span class="text-danger">', '</span>')?>
						</div>

						<div class="form-group col-md-12"> 
							<label for="Status">Status</label>
							<select name="status" class="form-control" required>
								<option value="0"<?=set_select('status', ($product['status']??''), ($product['status']??'')==0)?>>Inactive</option>
								<option value="1"<?=set_select('status', ($product['status']??''), ($product['status']??'')==1)?>>Active</option>
							</select> 
						</div>
		        	</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-primary"><?=($id??null) ? 'Save Product' : 'Create Product';?></button>
					</div>
		    	</div>
		    <?=form_close(); ?>
		    </div>
		</div>

		<script>
		    window.onload = function() { 
		        $(".selectize").each(function(e) { 
		            $(this).selectize({
		                plugins: ['drag_drop', 'remove_button', 'restore_on_backspace'], 
		                delimiter: ',',
		                persist: false,
		                hideSelected: true,
		                valueField: 'title',
		                searchField: 'title',
		                options: $(this).data("options"),
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
		        }); 
		    }
		</script> 
