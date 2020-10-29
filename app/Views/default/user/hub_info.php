			<!-- Default box -->
			<div class="card card-solid extra">
				<div class="card-body">
					<div class="row">
						<div class="col-12 col-sm-5">
							<h3 class="d-inline-block d-sm-none"><?=$hub['name']?></h3>
							<div class="col-12">
								<img src="<?=$creative->fetch_image($hub['banner'], my_config('default_banner')); ?>" class="product-image" alt="Product Image">
							</div>
						</div>
						<div class="col-12 col-sm-7">
							<h3 class="my-3"><?=$hub['name']?></h3>
							<p><?=$hub['description']?></p>
							<hr>
							<h4>Features</h4>
                            <ul>
                                <?php foreach (explode(',', $hub['facilities']) as $key => $facility): ?>
                                <li><?=$facility?></li>
                                <?php endforeach?>
                            </ul>
							<div class="bg-success py-2 px-3 mt-4">
								<h2 class="mb-0"><?=money($hub['price'])?></h2>
							</div>
							<div class="mt-4">
		                        <div class="plan-button"> 
		                            <button class="btn btn-common booking-btn" data-type="hub" data-id="<?=$hub['id']?>">Book Now</button>
		                        </div> 
							</div>
						</div>
					</div>
				</div>
				<!-- /.card-body -->
			</div>
			<!-- /.card -->
 