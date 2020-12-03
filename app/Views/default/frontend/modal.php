		    <?php if (empty($custom)): ?> 
		    <!-- Load the <?=$modal_target ?? 'primary-modal'?> modal here -->
		    <div class="modal fade" id="<?=$modal_target ?? 'primary-modal'?>" style="z-index: 999999;"> 
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered <?=$modal_size ?? 'modal-xl'?>"> 
					<div class="modal-content"> 
						<?php if (!empty($modal_title)):?> 
						<div class="modal-header"> 
							<h5 class="modal-title">
								<?=$modal_title?>
							</h5> 
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
								<span aria-hidden="true">&times;</span> 
							</button> 
						</div> 
						<?php endif;?>  
						<div class="modal-body"> 
							<?=$modal_content ?? ''?> 
						</div> 
						<?php if (isset($modal_btn) && !isset($hide_footer)):?> 
						<div class="modal-footer justify-content-between"> 
							<?php if ($modal_btn !== TRUE):?> 
								<?=$modal_btn?>
							<?php else:?> 
								<span id="modal_btn_block"> 
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
								</span> 
							<?php endif;?> 
							<div id="appendiv"></div> 
						</div> 
						<?php endif;?> 
					</div> 
					<!-- /.modal-content --> 
				</div> 
				<!-- /.modal-dialog --> 
			</div> 
		<?php else: ?>
		    <div class="modal fade custom" id="<?=$modal_target ?? 'primary-modal'?>" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">  
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered <?=$modal_size ?? 'modal-xl'?>">
					<div class="modal-content">
 						<?=$modal_content ?? ''?> 
					</div>
				</div>
			</div>
		<?php endif ?>