		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="mb-3">
					<?=anchor('admin/users/create', "Create New User", ['class'=>'btn btn-primary'])?>
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
						<div class="my-1 row">
						<?php if (!my_config('cpanel_url') && my_config('cpanel_username') && my_config('cpanel_password')): ?>
							<button class="btn btn-warning shadow generate_email disabled" disabled data-action="generate">
								Generate Cpanel Webmail Accounts
							</button>
							<button class="btn btn-danger shadow generate_email disabled" disabled data-action="delete">
								Delete Cpanel Webmail Accounts
							</button>
						<?php else: ?>
							<div class="col-md-6">
								<?=alert_notice("Invalid Cpanel Config, Can't generate Webmail Accounts!", "error", false, "FLAT")?>
							</div>
						<?php endif ?>
						<?php if (!my_config('afterlogic_domain') && my_config('afterlogic_username') && my_config('afterlogic_password')): ?>
							<button class="btn btn-success shadow generate_email disabled" disabled data-action="alwm">
								Augment AfterLogic Accounts
							</button>
						<?php else: ?>
							<div class="col-md-6">
								<?=alert_notice("Invalid AfterLogic Config, Can't Augment AfterLogic Accounts!", "error", false, "FLAT")?>
							</div>
						<?php endif ?>
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

					check_the_boxes($(e.target).prop("checked"));

					$("label#clabel").text(text);
				});

				$("body").on("change", ".checkboxes", function(e) 
				{
					check_the_boxes($(e.target).prop("checked"));
				});

				$(".generate_email").click(function() {
					var ids = [];
					var $this = $(this);
					$(".checkboxes:checkbox:checked").each(function() {
						ids.push($(this).data('uid'))
					});
 					
 					if (!$this.prop("disabled")) 
 					{ 
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
					}
				});
			}

			function check_the_boxes(chcked) {

				if ($(".checkboxes:checkbox:checked").length>0) { 
					$(".generate_email").removeAttr('disabled').removeClass('disabled'); 
				} else {
					$(".generate_email").attr('disabled');
					$(".generate_email").addClass('disabled');
				}
			}
		</script>