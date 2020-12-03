		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="my-2">
                    <button class="btn btn-primary upload-media" 
                    	data-type="gallery" 
                    	data-media="post" 
                    	data-modal-title="Create New Post" 
                    	data-modal="#actionModal">Create New Post
                    </button>  
                    <button class="btn btn-warning upload-media" 
                    	data-type="gallery" 
                    	data-media="event" 
                    	data-modal-title="Create New Event" 
                    	data-modal="#actionModal">Create New Event
                    </button>  
				</div>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"><?=empty($all_post) ? _lang('blog_and_events_posts_by_me') : _lang('blog_and_events_posts')?></h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Title</th> 
									<th>Type</th> 
									<th>Posted</th> 
									<th>Image</th> 
									<th style="width: 200px">Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php if ($posts): 
								$i = 0?>
								<?php foreach ($posts as $key => $post): 
									$i++;

									$meta = null;

						            if ($post['thumbnail']) {
						                $image = $creative->fetch_image($post['thumbnail'], 'banner');
						            } 
						            elseif ($post['type'] == 'image') {
						                $image = $creative->fetch_image($post['file'], 'banner');
						            } 
						            elseif (!empty($post['meta'])) {
						                $meta = toArray(json_decode($post['meta']));
						                $image = $creative->fetch_image($meta['file'], 'banner');
						            }
						            else { 
						                $image = $creative->fetch_image('default_banner', my_config('default_banner'));
						            }
						            $token = $post['token'] ?? $post['post_id'];
						        ?> 
								<tr id="posts<?=$post['post_id']?>">
									<td><?=$i?>.</td> 
									<td>
										<?=anchor("post/$token",$post['title'] ? $post['title'] : _lang('blog_post_by', [fetch_user('fullname', $post['uid'])]), ['target' => '_blank'])?>
									</td>
									<td><?=$post['event_time'] ? _lang('event') : ucwords($post['type'])?></td>
									<td><?=date('M, j Y h:i A', $post['time'])?></td>
									<td>
										<div class="media" href="javascript:void(0)" onclick="modalImageViewer($(this))" data-src="<?=$meta ? $image : $creative->fetch_image($post['file'], my_config('default_banner'));?>"<?=(strtolower($post['type'])==='video') ? ' data-thumb="'.$post['thumbnail'].'"' : '' ?>>
			                            	<img src="<?=$image; ?>" style="max-height: 40px;" id="image_preview">
			                            </div>
									</td>  
									<td>
										<button class="btn px-0 upload-media"
	                                    	title="Edit"
	                                    	data-toggle="tooltip"
					                    	data-type="gallery" 
					                    	data-id="<?=$post['post_id']?>" 
					                    	data-media="<?=$post['event_time'] ? "event" : $post['type']?>" 
					                    	data-modal-title="Edit <?=$post['event_time'] ? _lang('event') : ucwords($post['type'])?>" 
					                    	data-modal="#actionModal">
	                                        <i class="fa fa-edit fa-fw text-info"></i>
					                    </abutton> 
										<button class="btn px-0 deleter" 
											type="button" 
	                                    	title="Delete"
	                                    	data-toggle="tooltip"
		                    				data-extra='{"save":"true","modal":"#actionModal"}'
		                    				data-label="Delete"
											data-class="btn btn-danger btn-spinner font-weight-bold py-0" 
											data-type="posts" 
											data-id="<?=$post['post_id']?>"
											onclick="confirmAction('click', false, 'cancel', 'Are you sure you want to delete this <?=$post['event_time'] ? _lang('event') : ucwords($post['type'])?>?', this);">
	                                        <i class="fa fa-trash fa-fw text-danger"></i>
										</button> 
									</td>
								</tr> 
								<?php endforeach ?> 
							<?php else:?> 
								<tr><td colspan="4"><?php alert_notice("No Posts Available!", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table> 
					</div>
				</div>

				<?= $pager->simpleLinks('default', 'custom_full') ?>
			</div> 
		</div>
