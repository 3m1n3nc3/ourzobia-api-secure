		<div class="row"> 
			<div class="col-md-12 table-responsive"> 
				<div class="my-2"> 
                    <button class="btn btn-primary upload-media" data-type="gallery" data-modal="#CustomModal">Upload Item</button> 
				</div>
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Gallery Items</h3>
					</div>
					<div class="card-body p-0">
						<table class="table table-striped">
							<thead>
								<tr>
									<th style="width: 10px">#</th>
									<th>Title</th>
									<th>Type</th>
									<th>Preview</th>  
									<th style="width: 200px">Actions</i></th>
								</tr>
							</thead>
							<tbody>
							<?php if ($galleries): 
								$i = 0?>
								<?php foreach ($galleries as $key => $gallery): 
									$i++;?>
								<tr class="uploaded_item">
									<td><?=$i?>.</td>
									<td><?=$gallery['title']?></td> 
									<td><?=strtoupper($gallery['type'])?></td> 
									<td>
										<div class="media" href="javascript:void(0)" onclick="modalImageViewer($(this))" data-src="<?=$creative->fetch_image($gallery['file'], my_config('default_banner'));?>"<?=(strtolower($gallery['type'])==='video') ? ' data-thumb="'.$gallery['thumbnail'].'"' : '' ?>>
				                            <?php if ($gallery['thumbnail']): ?> 
				                            <img src="<?=$creative->fetch_image($gallery['thumbnail'], my_config('default_banner')); ?>" style="max-height: 40px;" id="image_preview"> 
				                            <?php elseif (strtolower($gallery['type'])==='image'): ?>
											<img src="<?=$creative->fetch_image($gallery['file'], my_config('default_banner')); ?>" style="max-height: 40px;" id="image_preview"> 
				                            <?php endif ?>
				                        </div>
									</td> 
									<td>
										<a href="<?=site_url('admin/gallery/create/'.$gallery['id'])?>" class="btn btn-info">Edit</a>
	                                    <button 
	                                        class="btn btn-danger text-white m-1 deleter" 
	                                        onclick="confirmAction('<?=site_url('admin/gallery/delete/'.$gallery['id']);?>', true)">
	                                        <i class="fa fa-trash fa-fw"></i>
	                                    </button>  
									</td>
								</tr> 
								<?php endforeach ?>
							<?php else:?> 
								<tr><td colspan="5"><?php alert_notice("No media in gallery", 'info', true, 'FLAT') ?></td></tr> 
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> 
		</div>
