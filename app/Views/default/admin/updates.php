<?php
    $curr_theme = theme_info(my_config('site_theme')); 
    $curr_adm_theme = theme_info(my_config('admin_theme'));?>

		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="card"> 
					<div class="card-header borde"> 
						<div class="d-flex justify-content-between"> 
							<h3 class="card-title">Manage Updates</h3> 
						</div> 
					</div> 
					<div class="card-body">  
                        <div class="progress m-t-30" style="height: 7px; display: none;">
                            <div class="progress-bar progress-c-theme" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div> 

	                    <?=form_open_multipart('admin/updates/upload', ['class'=>'upload_update_form', 'id'=>'upload_form'])?>
		                    <label for="upload" class="btn btn-success btn-lg rounded-0 btn-md text-white mt-3">
		                        <i class="fas fa-box-open"></i> Upload Update File
		                    </label>
		                    <input type="file" name="update_file" id="upload" class="d-none" accept=".zip" style="display: none;">
	                    <?=form_close()?>

	                    <div class="container p-3" style='font-family: Consolas,"courier new"; color: crimson; background-color: #f1f1f1; padding: 2px; font-size: 100%;'>
	                        <code>
	                            <div class="new_updates_notice"><?= $new_updates;?></div>
                            <?php 
                            	$i = 0;
                            	foreach ($available_updates as $key => $update_item): 
                            		$i++ ?>
                            	<div class="border p-3 my-3 install-container" id="install-container-<?=$i;?>">
	                            	<div><span class="text-info">Name:</span> <?=$update_item->name?></div>
	                            	<div><span class="text-info">Type:</span> <?=$update_item->type?></div>
	                            	<div><span class="text-info">Version:</span> <?=$update_item->version?></div>
	                            	<div><span class="text-info">Release Date:</span> <?=$update_item->release_date?></div>
	                            	<div><span class="text-info">Author:</span> <?=$update_item->author?></div>
	                            	<div><span class="text-info">Availability:</span> <?=$update_item->availability?></div>
	                            	<div><span class="text-info">Requirements:</span> <?=$update_item->requirements['info']?></div> 
			                    	<?php if (!$update_item->requirements['error']): ?>
				                    <?=form_open('admin/updates/install', ['class'=>'upload_update_form mt-0', 'id'=>'installer'.$i])?>
					                    <button type="submit" class="btn btn-success btn-sm rounded-lg btn-md text-white">
					                        <i class="fas fa-wrench"></i> Install
					                    </button>
					                    <input type="hidden" name="update_file" id="update_file<?=$i;?>" class="d-none" style="display: none;" value="<?=$update_item->file?>">
					                    <input type="hidden" name="update_filename" id="update_filename<?=$i;?>" class="d-none" style="display: none;" value="<?=$update_item->file_name?>">
					                    <input type="hidden" name="meta" id="meta<?=$i;?>" class="d-none" style="display: none;" value="<?=$update_item->name?> v<?=$update_item->version?>">
				                    <?=form_close()?>  
			                    	<?php endif ?>
				                    <?=form_open("admin/updates/delete/{$update_item->file_name}", ['class'=>'float-right upload_update_form mt-0', 'id'=>'deleter'.$i])?>
					                    <button type="submit" class="btn btn-danger btn-sm rounded-lg btn-md text-white">
					                        <i class="fas fa-trash"></i> Delete
					                    </button> 
				                    <?=form_close()?>  
                            	</div> 
                            <?php endforeach ?>
			                    <div class="mt-3 text-info font-weight-bold small"> 
			                        <div class="text-success">System Version</div> 
			                        <div>v<?=env('installation.version');?></div>  
			                    </div>
			                    <div class="mt-1 text-info font-weight-bold small"> 
			                        <div class="text-success">Active Themes</div> 
			                        <div><?=$curr_theme['name'];?> Version: <span class="text-muted">v<?=$curr_theme['version'];?></span></div> 
			                        <div><?=$curr_adm_theme['name'];?> Version: <span class="text-muted">v<?=$curr_adm_theme['version'];?></span></div> 
			                    </div>
	                        </code>
	                    </div>
					</div> 
				</div> 
			</div> 
		</div>

		<script type="text/javascript">
			addEventListener("load", function() {
			  	'use strict'

			  	var upload_update_form = $('.upload_update_form');
			  	var upload_update_action;
				var progress_bar = $('.progress-bar');

			  	$('#upload').change(function() {
			  		upload_update_action = $('#upload_form').attr('action');
			  		$('#upload_form').submit(); 
			  	});

			  	$('.upload_update_form').submit(function(e) {
			  		upload_update_form = $("#"+$(e.target).attr('id'));
			  		upload_update_action = upload_update_form.attr('action');
        			upload_update_form.find('button[type="submit"]').buttonLoader('start'); 
			  	});

			  	upload_update_form.ajaxForm({
		            url: upload_update_action,
		            type: 'POST',
		            dataType: 'json',
		            beforeSend: function(arr,form) {
 						progress_bar.attr({style:"width:0%", "aria-valuenow":"0"});
		            },
		            success: function(data, status, xhr, form) { 
		            	show_toastr(data.message, data.status);
		            	data.status = data.status == 'error' ? 'danger' : data.status;
		            	$(".general_notice").alert_notice(data.message, data.status);
        				upload_update_form.find('button[type="submit"]').buttonLoader('stop'); 
		            	upload_update_form.parent('.install-container').remove();
		            	upload_update_form.resetForm();
		            	if (data.notice) {
		            		$(".new_updates_notice").html(data.notice);
		            	}
 						setTimeout(function() {
 							progress_bar.parent('div').slideUp(); 
 						}, 3000);
		            },
		            uploadProgress: function(evt) {
					  	if (evt.lengthComputable) {
						    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
						    progress_bar.parent('div').slideDown();
						    progress_bar.attr({style:"width:"+percentComplete+"%", "aria-valuenow":percentComplete});
					  	}
		            }
			  	});
			});
		</script>