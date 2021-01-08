		<div class="row"> 
			<div class="col-md-12"> 
				<div class="mb-3">
					<?=anchor('admin/active_products/create', "Add Product", ['class'=>'btn btn-primary'])?>
				</div>
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Product' : 'Add Product';?></h3>
					</div> 
                	
					<?=form_open_multipart('admin/active_products/'.$action.($id?'/'.$id:''))?>
						<?=csrf_field()?>
						<div class="card-body">
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="name">Product Name</label>
									<select name="name" class="form-control" id="name" required>
										<?php if ($sel_products = $main_products_m->get_products()): ?>
											<?php foreach ($sel_products as $key => $sel_product):?>
											<option value="<?=$sel_product['title']?>"<?=set_select('title', ($sel_product['title']??''), ($sel_product['title']??'')==($product['name']??''))?>><?=$sel_product['name']?></option>
											<?php endforeach ?>  
										<?php endif ?>
									</select> 
								</div> 

								<div class="form-group col-md-6">
									<label for="name">Product License</label>
									<select name="license_type" class="form-control" id="license_type" required>
										<?php foreach (toArray(json_decode($main_products_m->get_products(['title' => $product['name']])['licenses']??'')??'') as $key => $licenses):?>
											<option value="<?=$licenses?>"<?=set_select('title', ($licenses??''), ($licenses??'')==($product['license_type']??''))?>><?=ucwords($licenses)?></option>
										<?php endforeach ?> 
									</select> 
								</div>  

								<div class="form-group col-md-6">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?=set_value('email', $product['email']??'') ?>">
								</div>  

								<div class="form-group col-md-6">
									<label for="domain">Domain</label>
									<input type="text" class="form-control" name="domain" id="domain" placeholder="Enter Domain" value="<?=set_value('domain', $product['domain']??'') ?>">
								</div>  

								<div class="form-group col-md-6">
									<label for="code">Product Code</label>
									<input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" value="<?=set_value('code', $product['code']??$enc_lib->get_random_password(10,10,TRUE,FALSE,TRUE)) ?>"<?=!$id?' readonly':''?>>
								</div>  

								<div class="form-group col-md-6">
									<label for="expiry">Expires in <?=($id ? "<span class=\"text-success\">" . date('M j Y,  h:i A', $product['expiry']) . "</span>" : '')?></label>
									<select name="expiry" class="form-control" id="expiry" required>
										<?php if ($id??null): ?>
										<option value="0">Unchanged</option>
										<?php endif ?>
										<option value="1 days"<?=set_select('expiry', '1 days')?>>1 Day</option>
										<option value="7 days"<?=set_select('expiry', '7 days')?>>7 Days</option>
										<option value="30 days"<?=set_select('expiry', '30 days')?>>30 Days</option>
										<option value="365 days"<?=set_select('expiry', '365 days')?>>365 Days</option>
										<option value="1"<?=set_select('expiry', '1', strtotime("+365 days") < ($product['expiry']??''))?>>Unlimited</option>
									</select> 
								</div>  
							</div>

							<div class="form-group"> 
								<label for="Status">Status</label>
								<select name="status" class="form-control" required>
									<option value="0"<?=set_select('status', ($product['status']??''), ($product['status']??'')==0)?>>Inactive</option>
									<option value="1"<?=set_select('status', ($product['status']??''), ($product['status']??'')==1)?>>Active</option>
								</select> 
							</div>
						</div> 
						<div class="card-footer">
							<button type="submit" class="btn btn-primary"><?=$id ? 'Save' : 'Add';?></button>
						</div>
					<?=form_close()?>
				</div>
			</div> 
		</div>
