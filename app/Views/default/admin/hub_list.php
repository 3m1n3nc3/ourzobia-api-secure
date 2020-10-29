		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="my-2">
					<a href="<?=site_url('admin/hubs/hub_create')?>" class="btn btn-success">Create Hub</a>
				</div>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">List Hubs</h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Number</th>
									<th>Category</th> 
									<th>Status</th>  
									<th style="width: 200px">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php if ($hubs): 
								$i = 0?>
								<?php foreach ($hubs as $key => $hub): 
									$i++;
									$category = $hubs_m->get_hub(['id' => $hub['hub_type']])?>
								<tr>
									<td><?=$i?>.</td>
									<td><?=$hub['hub_no']?></td> 
									<td>
										<a href="<?=site_url('admin/hubs/create/'.$hub['hub_no'])?>" class=""><?=$hub['name']?></a>
									</td>  
									<td><?=($hub['status'])?'Active':'Inactive'?></td>  
									<td>
										<a href="<?=site_url('admin/hubs/hub_create/'.$hub['id'].'/hubs')?>" class="btn btn-info">Edit</a>
	                                    <button 
	                                        class="btn btn-danger text-white m-1 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/hubs/delete/'.$hub['id'].'/hubs');?>', true)">
	                                        <i class="fa fa-trash fa-fw"></i>
	                                    </button>  
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
