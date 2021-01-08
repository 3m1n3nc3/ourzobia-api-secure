		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="mb-3">
					<?=anchor('admin/active_products/create', "Add Product", ['class'=>'btn btn-primary'])?>
				</div>
				<div class="card"> 
					<div class="card-header border-0"> 
						<div class="d-flex justify-content-between"> 
							<h3 class="card-title">Manage Products</h3> 
						</div> 
					</div> 
					<div class="card-body"> 
						<table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%"> 
							<thead> 
								<tr> 
									<th> PID </th> 
									<th> Name </th>  
									<th style="min-width: 100px;"> P.Code </th> 
									<th> Owner </th>  
									<th> Domain </th>  
									<th> Email </th> 
									<th> Date </th> 
									<th style="min-width: 65px;"> Actions </th> 
								</tr> 
							</thead> 
							<tbody> 
							</tbody> 
						</table> 
					</div> 
				</div> 
			</div> 
		</div>
