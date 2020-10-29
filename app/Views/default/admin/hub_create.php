		<div class="row"> 
			<div class="col-md-12"> 
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Feature' : 'Create Hub';?></h3>
					</div>
					<?=form_open_multipart('admin/hubs/'  .$action . ($id?'/'.$id:'') . ($extra?'/'.$extra:''), 'id=hub_create')?>
						<?=csrf_field()?>
						<div class="card-body">
							<div class="form-group"> 
								<label for="hub_type">Category</label>
								<select name="hub_type" class="form-control">
									<?php if ($categories = $hubs_m->get_hub()): ?>
										<option value="">Select Category</option>
										<?php foreach ($categories as $key => $category): ?>
										<option value="<?=$category['id']?>"<?=set_select('hub_type', $category['id'], ($hub['hub_type']??'')===$category['id'])?>>
											<?=$category['name']?> 
										</option>	
										<?php endforeach ?>
									<?php endif?>
								</select> 
							</div>
 
							<div class="form-row"> 
 								<?php if (!$id): ?>
								<div class="col-md-6 form-group">
									<label for="range_from">Range From</label>
									<input type="number" class="form-control" name="range_from" id="range_from" placeholder="Range From" value="<?=set_value('range_from', $hub['range_from']??'') ?>" required>
								</div> 

								<div class="col-md-6 form-group">
									<label for="range_to">Range To</label>
									<input type="number" class="form-control" name="range_to" id="range_to" placeholder="Range To" value="<?=set_value('range_to', $hub['range_to']??'') ?>" required>
								</div> 
 								<?php endif ?>

								<div class="col-md-12 form-group"> 
									<label for="status">Status</label>
									<select name="status" class="form-control">
										<option value="0" <?=set_select('status', '0', ($hub['status']??'0')==='0')?>>Inactive</option>
										<option value="1" <?=set_select('status', '1', ($hub['status']??'1')==='1')?>>Active</option>
									</select> 
								</div>
							</div>  
						</div> 
						<div class="card-footer">
							<button type="submit" class="btn btn-primary"><?=$id ? 'Save' : 'Create Hub';?></button>
						</div>
					<?=form_close()?>
				</div>
			</div> 
		</div>
																		
		<script>
			window.onload = function() {
				var from = document.querySelector("input[name=range_from]");
				var to   = document.querySelector("input[name=range_to]");

				$("button[type=submit]").on('click', function(e) { 
					if (from !== null && to !== null) {
					    e.preventDefault();
						var count = (to.value-from.value)+1;
						var rooms_word = count>1 ? ' rooms' : ' room';

						confirmAction('submit', '#hub_create', 'submit', 'Are you sure you want to create '+count+rooms_word+'?');
					} 
				})
			}
		</script>