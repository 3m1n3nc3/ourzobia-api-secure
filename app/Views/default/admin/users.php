		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="mb-3">
					<?=anchor('admin/users/create', "Create User", ['class'=>'btn btn-primary'])?>
				</div>
				<div class="card"> 
					<div class="card-header border-0"> 
						<div class="d-flex justify-content-between"> 
							<h3 class="card-title">Manage Users</h3> 
						</div> 
					</div> 
					<div class="card-body"> 
						<table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%"> 
							<thead> 
								<tr> 
									<th> <input type="checkbox" id="checkall"></th> 
									<th> UID</th> 
									<th> Name </th>  
									<th> Username </th>  
									<th> Email </th>  
									<th> Status </th> 
									<th> Registered </th> 
									<th style="min-width: 90px;"> Actions </th> 
								</tr> 
							</thead> 
							<tbody> 
							</tbody> 
						</table> 
					</div> 
				</div> 
			</div> 
		</div>

		<script type="text/javascript"> 
			window.onload = function() { 
				const checkall = $('#checkall');
				checkall.on('change', function(e) {
					console.log($('datatables_table').rows())
					console.log($(e.target).prop('checked'));
				});
			}
		</script>