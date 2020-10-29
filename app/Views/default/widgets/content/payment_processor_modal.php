        <?=form_open_multipart('', 'class="form center-block payment-processor"')?>
            <?=csrf_field()?>
            <?=form_hidden($post_data)?>
            <div class="modal-header" >
                Checkout
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body bg-light px-2 py-0">
                <div class="payment-notification"></div>
                <div class="p-3 payment-methods row d-flex justify-content-center">
                    <div class="row my-3 col-lg-12">
                        <div class="form-group col-lg-6">
                            <label class="text-primary" for="checkin_date">Check In Date</label>
                            <input type="text" name="checkin_date" value="<?=set_value('checkin_date'), date("Y-m-d H:i:s", strtotime("NOW")) ?>" class="form-control datetimepick" placeholder="2020-10-20 21:39:00" autocomplete="none"> 
                        </div>

                        <div class="form-group col-lg-6">
                            <label class="text-primary" for="duration">Duration (Days)</label>
                            <select id="duration" name="duration" class="form-control">
                                <option value="">Duration of use (Days)</option> 
                                <?php for ($i = 1; $i<32; $i++):?>
                                <option value="<?=$i?>"<?=set_select('duration', $i)?>><?=$i?></option> 
                                <?php endfor?>
                            </select> 
                        </div>
                    </div>
                    <div class="d-flex justify-content-center col-12 process-payment">
                        <?php if (logged_user('wallet')>0): ?>
                        <button class="btn btn-outline-primary m-2 payment-method" data-processor="wallet" data-balance="<?=logged_user('wallet')?>">
                            <i class="fa fa-5x fa-fw fa-wallet"></i>
                            <div class="font-weight-bold"><?=money(logged_user('wallet'))?></div>
                        </button>
                        <?php endif ?>
                        <?php if (my_config('enable_paystack') && my_config('paystack_public') && my_config('paystack_secret')): ?>
                        <button class="btn btn-outline-primary m-2 payment-method" data-processor="paystack">
                            <i class="fab fa-5x fa-fw"><svg height="60" width="60" viewBox="0 0 68 68" fill="none" xmlns="http://www.w3.org/2000/svg" id="svg_resize"><g transform="scale(0.11)" clip-path="url(#clip0)" fill="currentColor"><path d="M548.416 0H31.792C14.306 0 0 14.333 0 31.852v57.333c0 17.519 14.306 31.852 31.792 31.852h515.034c17.486 0 31.792-14.333 31.792-31.852V31.852C580.208 14.333 565.901 0 548.416 0zM548.416 320.111H31.792C14.306 320.111 0 334.444 0 351.963v57.333c0 17.519 14.306 31.852 31.792 31.852h515.034c17.486 0 31.792-14.333 31.792-31.852v-57.333c1.59-17.519-12.717-31.852-30.202-31.852zM322.691 480.963H31.792C14.306 480.963 0 495.296 0 512.815v57.333C0 587.667 14.306 602 31.792 602h290.899c17.486 0 31.792-14.333 31.792-31.852v-57.333c0-17.519-14.306-31.852-31.792-31.852zM580.208 160.852H31.792C14.306 160.852 0 175.185 0 192.703v57.334c0 17.518 14.306 31.852 31.792 31.852h548.416c17.486 0 31.792-14.334 31.792-31.852v-57.334c0-17.518-14.306-31.851-31.792-31.851z"></path></g><defs><clipPath id="clip0"><path fill="#fff" d="M0 0h612v602H0z"></path></clipPath></defs></svg></i>
                            <div class="font-weight-bold">Paystack</div>
                        </button>
                        <?php endif ?>
                        <?php if (my_config('enable_stripe') || my_config('stripe_public') || my_config('stripe_secret')): ?>
                        <button class="btn btn-outline-primary m-2 payment-method" data-processor="stripe">
                            <i class="fab fa-5x fa-fw fa-stripe"></i>
                        </button>
                        <?php endif ?>
                    </div>
                </div>
            </div>  
        <?=form_close();?> 