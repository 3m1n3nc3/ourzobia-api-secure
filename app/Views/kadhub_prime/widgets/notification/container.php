                    <li>
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="javascript:" data-toggle="dropdown" id="get-notifications"><i class="icon feather icon-bell" id="notification_bell"></i></a>
                            <div class="dropdown-menu dropdown-menu-right slimScrollDiv notification">
                                <div class="noti-head">
                                    <h6 class="d-inline-block m-b-0">Notifications</h6>
                                    <div class="float-right"> 
								        <?php if(module_active('account')): ?>
                                        <a href="<?=site_url('user/account')?>" class="m-r-10">Settings</a>
                                        <?php endif ?>
                                        <a href="javascript:">clear all</a>
                                    </div>
                                </div>

								<!-- DROPDOWN BOX LIST -->
                                <ul class="noti-body scroll-notifications" id="notifications__list" style="overflow: auto; width: 100%; height: auto; max-height: calc(100vh - 300px);"></ul>

								<div class="text-center preloader d-none">
									<div class="spinner-light text-info spinner-grow" role="status">
										<span class="sr-only">Loading...</span>
									</div>
								</div>

								<?php if(module_active('account')): ?>
                                <div class="noti-footer">
                                    <a href="<?=site_url('user/account/notifications')?>">View all Notifications</a>
                                </div>
                                <?php endif ?>
                            </div>
                        </div>
                    </li> 