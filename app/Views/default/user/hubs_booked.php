		<div class="row"> 
			<div class="col-md-12 table-responsive">  
				<div class="my-2">
					<a href="<?=site_url('user/hubs')?>" class="btn btn-success">Book Hub</a>
				</div>
				<div class="card"> 
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>hub</th>
									<th>Paid</th> 
									<th>Checkin Date</th>  
									<th>Checkout Date</th>   
								</tr>
							</thead>
							<tbody>
							<?php if ($hubs): 
								$i = 0?>
								<?php foreach ($hubs as $key => $hub):  
									$i++;?>
								<tr class="uploaded_item">
									<td><?=$i?>.</td>
									<td>
										<a href="<?=site_url('user/hubs/booked/' . $hub['id'])?>"><?=$hub['name']?></a>
										<span class="badge badge-warning"><?=$hub['hub_no']?></span>
										<?=time_differentiator($hub['checkin_date'], $hub['checkout_date'], "div.Booked for ", "small text-success")?>
									</td>  
									<td><?=money($hub['amount'])?></td>   
									<td><?=nl2br(date("jS M Y \n h:i A", $hub['checkin_date']))?></td>  
									<td>
										<?=nl2br(date("jS M Y \n h:i A", $hub['checkout_date']))?>
									</td> 
								</tr> 
								<?php endforeach ?>
							<?php else:?> 
								<tr><td colspan="5"><?php alert_notice("You have not booked any hubs!", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<?=$booking_pg->simpleLinks('default', 'custom_full')?>
			</div> 
		</div>
