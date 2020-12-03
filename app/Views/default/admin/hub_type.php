		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="my-2">
					<a href="<?=site_url('admin/hubs/create')?>" class="btn btn-success">Add Hub Category</a>
				</div>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Hub Category</h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Name</th>
									<th>Amount</th>
									<th>Seats</th>
									<th>Icon</th>  
									<th>Duration</th>  
									<th>Status</th>  
									<th style="width: 200px">Actions</i></th>
								</tr>
							</thead>
							<tbody class="todo-list" data-widget="todo-list" data-data='{"table":"hub_types"}'>
							<?php if ($hubs): 
								$i = 0?>
								<?php foreach ($hubs as $key => $hub): 
									$i++;?>
								<tr id="item-<?=$hub['id']?>">
									<td><?=$i?>.</td>
									<td><?=$hub['name']?></td> 
									<td><?=strtoupper($hub['price'])?></td> 
									<td><?=strtoupper($hub['seats'])?></td> 
									<td>
			                            <?php if ($hub['banner']): ?> 
			                               <img src="<?= $creative->fetch_image($hub['banner']??'', my_config('default_banner')); ?>" style="max-height: 40px;" id="image_preview"> 
			                            <?php else: ?>
										<span class="badge bg-success">
											<i class="<?=$hub['icon']?> fa-2x fa-fw"></i> 
										</span>
			                            <?php endif?>
									</td> 
									<td><?=$hub['duration']?></td>  
									<td><?=($hub['status'])?'Active':'Inactive'?></td>  
									<td>
										<a href="<?=site_url('admin/hubs/create/'.$hub['id'])?>" class="btn btn-info">Edit</a>
	                                    <button 
	                                        class="btn btn-danger text-white m-1 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/hubs/delete/'.$hub['id'].'/hub_types');?>', true)">
	                                        <i class="fa fa-trash fa-fw"></i>
	                                    </button>  
			                            <span class="handle p-0 m-0">
			                                <i class="fas fa-ellipsis-v"></i>
			                                <i class="fas fa-ellipsis-v"></i>
			                            </span>
									</td>
								</tr> 
								<?php endforeach ?> 
							<?php else:?> 
								<tr><td colspan="8"><?php alert_notice("No hub type listed!", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> 
		</div>
