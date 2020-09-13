		<div class="row"> 
			<div class="col-md-12"> 
				<div class="mb-3">
					<?=anchor('admin/products/create', "Add Product", ['class'=>'btn btn-primary'])?>
				</div>
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title"><?=$id ? 'Edit Product' : 'Add Product';?></h3>
					</div>
					<?=form_open_multipart('admin/products/'.$action.($id?'/'.$id:''))?>
						<?=csrf_field()?>
						<div class="card-body">
							<div class="form-group">
								<label for="name">Product Name</label>
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Product Name" value="<?=set_value('name', $product['name']??'') ?>">
							</div>  

							<div class="form-group">
								<label for="email">Email</label>
								<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?=set_value('email', $product['email']??'') ?>">
							</div>  

							<div class="form-group">
								<label for="domain">Domain</label>
								<input type="text" class="form-control" name="domain" id="domain" placeholder="Enter Domain" value="<?=set_value('domain', $product['domain']??'') ?>">
							</div>  

							<div class="form-group">
								<label for="code">Product Code</label>
								<input type="text" class="form-control" name="code" id="code" placeholder="Enter Code" value="<?=set_value('code', $product['code']??$enc_lib->get_random_password(10,10,TRUE,FALSE,TRUE)) ?>"<?=!$id?' readonly':''?>>
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
