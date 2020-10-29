		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="my-2">
					<a href="<?=site_url('admin/features/create')?>" class="btn btn-success">Add Feature</a>
				</div>
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
									<th style="width: 200px">Actions</i></th>
								</tr>
							</thead>
							<tbody>
							<?php if ($features): 
								$i = 0?>
								<?php foreach ($features as $key => $feature): 
									$i++;?>
								<tr>
									<td><?=$i?>.</td>
									<td><?=$feature['title']?></td> 
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
										<a href="<?=site_url('admin/features/create/'.$feature['id'])?>" class="btn btn-info">Edit</a>
	                                    <button 
	                                        class="btn btn-danger text-white m-1 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/features/delete/'.$feature['id']);?>', true)">
	                                        <i class="fa fa-trash fa-fw"></i>
	                                    </button>  
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
		</div>
