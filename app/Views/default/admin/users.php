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
						<div class="icheck-primary">
							<input type="checkbox" id="checkall">
							<label for="checkall" id="clabel">
								Check All
							</label>
						</div> 
						<table class="table table-bordered table-hover display" id="datatables_table" style="width: 100%"> 
							<thead> 
								<tr> 
									<th> </th> 
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
						<div class="my-1">
							<button class="btn btn-warning shadow generate_email disabled" disabled data-action="generate">Generate Cpanel Webmail Accounts</button>
							<button class="btn btn-success shadow generate_email disabled" disabled data-action="alwm">Augment AL Webmail Accounts</button>
							<button class="btn btn-danger shadow generate_email disabled" disabled data-action="delete">Delete Cpanel Webmail Accounts</button>
						</div>
					</div> 
				</div> 
			</div> 
		</div>

		<script type="text/javascript"> 
			window.onload = function() { 
				const checkall = $('#checkall');
				checkall.on('change', function(e) {
					$('.checkboxes').each(function() {
						$(this).prop("checked", $(e.target).prop("checked"));
					});

					var text = "Check All";
					if ($(e.target).prop("checked")) {
						text = "Uncheck All";
					}

					if ($(".checkboxes:checkbox:checked").length>0) { 
						$(".generate_email").removeAttr('disabled').removeClass('disabled'); 
					} else {
						$(".generate_email").attr('disabled');
						$(".generate_email").addClass('disabled');
					}

					$("label#clabel").text(text);
				});

				$(".generate_email").click(function() {
					var ids = [];
					var $this = $(this);
					$(".checkboxes:checkbox:checked").each(function() {
						ids.push($(this).data('uid'))
					});
 
					if ($(".checkboxes:checkbox:checked").length>0) { 
						$.ajax({
							url: link("connect/generate_emails"),
							method: "post",
							dataType: "JSON",
							data: {uids:ids,action:$this.data('action')},
							beforeSend: function() { 
                				$this.buttonLoader('start');  
							}, 
							success: function(data) {
                				$this.buttonLoader('stop'); 
                				show_toastr(data.message, data.status);  
							}
						});
					}
				});
			}
		</script>