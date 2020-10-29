            <?php if (!empty($hubs)): ?>
             <div class="row pricing-tables extra">
                <?php foreach ($hubs as $key => $hub): ?>
                <div class="col-lg-4 col-sm-6">
                    <div class="pricing-table table-left mb-4">
                        <div class="icon">
                            <i class="<?=$hub['icon']?>"></i>
                        </div>
                        <div class="pricing-details">
                            <h2><a href="<?=site_url('user/hubs/detail/' . $hub['id'])?>"><?=$hub['name']?></a></h2>
                            <span>
                                <?=money($hub['price'])?>
                                <?php if (my_config('site_currency', NULL, "USD") !== my_config('stripe_currency', NULL, "USD")): ?>
                                <div class="small text-success border-top">
                                    <?=money($hub['price']/my_config('stripe_currency_rate', NULL, "5.00"),null,my_config('stripe_currency', NULL, "USD"))?>
                                </div>
                                <?php endif ?> 
                            </span>
                            <ul class="px-0">
                                <?php foreach (explode(',', $hub['facilities']) as $key => $facility): ?>
                                <li><?=$facility?></li>
                                <?php endforeach ?> 
                            </ul>
                        </div>
                        <div class="plan-button">
                            <button 
                                class="btn btn-common booking-btn" data-type="hub" data-id="<?=$hub['id']?>" data-price="<?=$hub['price']?>" data-name="<?=$hub['name']?>">
                                Book Now
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>    
            </div>
            <?php endif ?>