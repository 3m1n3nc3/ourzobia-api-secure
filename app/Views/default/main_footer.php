		    <?php
		        $param1 = array(
		          	'modal_target' 	=> 'uploadModal', 
		          	'modal_size' 	=> 'modal-md',
		          	'modal_content' => 
		          	'<div class="m-0 p-0 text-center" id="upload_loader">
		                		<div class="loader">
		                			<div class="spinner-grow text-warning"></div>
		                		</div> 
		            		</div>'
		        );    
		        echo view('default/frontend/modal', $param1);
		    ?> 

		    <?php
		        $param = array(
		          	'modal_target' 	=> 'actionModal',
		          	'modal_title' 	=> 'Action Modal',
		          	'modal_size' 	=> 'modal-sm',
		          	'modal_content' => 
		          	'<div class="m-0 p-0 text-center" id="upload_loader1">
		                		<div class="loader">
		                			<div class="spinner-grow text-warning"></div>
		                		</div> 
		            		</div>'
		        );
		        echo view('default/frontend/modal', $param);
		    ?> 

            <?php
                $param2 = array(
                    'custom'        => true,
                    'modal_target'  => 'CustomModal', 
                    'modal_size'    => 'modal-md',
                    'modal_content' => '
                        <div class="m-0 p-0 text-center" id="upload_loader2">
                            <div class="loader">
                                <div class="spinner-grow text-warning"></div>
                            </div> 
                        </div>'
                );
                echo view('default/frontend/modal', $param2);
            ?> 

			<div class="m-2 card card-info shadow text-sm floating-card-box dragmove" style="position:fixed; top: 30px; right:0px; z-index: 5000; max-width:350px; display: none;">
				<div class="card-header dragmove-header">
					<h3 class="card-title">Box</h3>
					<div class="card-tools">
						<button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
						</button>
						<button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
				<div class="card-body p-0">
					<input type="hidden" name="state" value="default">
					<input type="hidden" name="type" value="">
					<ul class="products-list product-list-in-card pl-2 pr-2">
						<li class="item">
							<div class="product-img">
								<img src="" alt="Image" class="img-size-50">
							</div>
							<div class="product-info">
								<a href="javascript:void(0)" class="product-title"> 
									<span class="text"></span>
									<span class="badge float-right"> </span><!-- badge-success -->
								</a>
								<span class="product-description"></span>
							</div>
						</li> 
					</ul>
				</div>
				<div class="card-footer text-center">
					<form class="card_box-form">
						<button type="button" class="btn btn-danger btn-block font-weight-bold clear_pairing">Clear</button>
					</form>
				</div>
			</div>

			<!-- Main Footer -->
			<footer class="main-footer <?=my_config('des_footer_small_text')?>">
				<!-- To the right -->
				<div class="float-right d-none d-sm-inline">
					Developed by <?=my_config('site_name')?>
				</div>
				<!-- Default to the left -->
				<strong>Copyright &copy; 2019-<?=date('Y')?> <a href="<?=base_url()?>"><?=my_config('site_name')?></a>.</strong> All rights reserved.
			</footer>
