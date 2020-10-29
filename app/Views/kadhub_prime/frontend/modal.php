		<?php if (empty($popup_box)): ?> 
		    <!-- Load the <?=$modal_target ?? 'primary-modal'?> modal here -->
		    <div class="modal fade" id="<?=$modal_target ?? 'primary-modal'?>" style="z-index: 999999;"> 
				<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered <?=$modal_size ?? 'modal-xl'?>"> 
					<div class="modal-content"> 
						<?php if (!empty($modal_title)):?> 
						<div class="modal-header"> 
							<h4 class="modal-title">
								<?=$modal_title?>
							</h4> 
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
			<div class="popup-box mid popup-manage-container">
			    <a class="popup-close-button popup-manage-container-trigger" href="javascript:ourModal()">
			        <svg class="popup-close-button-icon icon-cross">
			            <use xlink:href="#svg-cross"></use>
			        </svg>
			    </a>
			    <div class="popup-box-body"> 
			      	<div class="popup-box-content" style="width: 100%;" data-simplebar>
			      		<?php if ($widget_box === true): ?>
			        	<div class="widget-box"> 
			          		<p class="widget-box-title"><?=$modal_title?></p> 
			          		<div class="widget-box-content"><?=$modal_content?></div>
			      		</div>
			      		<?php else: ?>
			      			<?=$modal_content?>
			      		<?php endif ?>
			      	</div>
			    </div>
			</div> 
		<?php endif ?>
 
