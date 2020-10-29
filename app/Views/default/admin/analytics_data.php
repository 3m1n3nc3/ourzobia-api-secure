<?php 
$location = '';
if (!empty($analytics['referrer'])) 
{
    $referrer = parse_url($analytics['referrer'], PHP_URL_HOST);
    $analytics['referrer'] = $analytics['referrer'] ? anchor(prep_url($analytics['referrer']), prep_url($referrer) . "...", ['data-toggle'=>'tooltip', 'title'=>prep_url($analytics['referrer'])]) : null;
    $a_user = $account_data->fetch($analytics['uid']);

    if (in_array($analytics['metric'], ['activations', 'validations']) && $analytics['item_id']) 
    {
        $item = $products_m->getWhere(['id' => $analytics['item_id']], 1)->getRowArray();
        $analytics['item_id'] = anchor("admin/products/create/{$item['id']}", nl2br("{$item['name']} \n {$item['domain']}"));
    }

    if ($analytics['ip_info']) 
    { 
        $location = "\n" . img($analytics['ip_info']["location"]["country_flag"]??"", false, ['alt'=>($analytics['ip_info']["country_name"]??''), 'class'=>'mr-2', 'height'=>'17px']) . ($analytics['ip_info']["country_name"]??''); 
    } 
} ?>
		<div class="row"> 
			<div class="col-md-6">  
				<div class="card"> 
					<div class="card-body">
						<div class="bg-light border-dark p-3"> 
							<div class="form-horizontal">
								<div class="form-group row text-center h4 border-bottom pb-2">
									<div class="col-sm-12 font-weight-bold">IP Location</div>
								<?php if ($analytics['ip_info']): ?>
									<div class="col-sm-12">
										<?=$location?> (<?=$analytics['ip_info']["country_code"]??'Unknown'?>)
									</div>
								<?php endif ?>
								</div>
							<?php if ($analytics['ip_info']): ?>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">IP Address</div>
									<div class="col-sm-9">
										<?=$analytics['uip']??''?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">City, State</div>
									<div class="col-sm-9">
										<?=$analytics['ip_info']["city"]??''?> (<?=$analytics['ip_info']["region_name"]??'Unknown'?>)
									</div>
								</div>  
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Language</div>
									<div class="col-sm-9">
										<?php foreach ($analytics['ip_info']["location"]["languages"]??[]  as $key => $language): ?>
											<div><?=$language["name"]??''?> (<?=ucwords($language["code"]??'')?>)</div>
										<?php endforeach ?>
									</div>
								</div>  
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Zip</div>
									<div class="col-sm-9">
										<?=$analytics['ip_info']["zip"]??''?> 
									</div>
								</div>  
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Dialing Code</div>
									<div class="col-sm-9">
										+<?=$analytics['ip_info']["location"]["calling_code"]??''?> 
									</div>
								</div>  
							<?php endif ?>
							</div>
						</div>
					</div>
				</div>
			</div> 

			<div class="col-md-6">  
				<div class="card"> 
					<div class="card-body">
						<div class="bg-light border-dark p-3"> 
							<div class="form-horizontal">
								<div class="form-group row text-center h4 border-bottom pb-2">
									<div class="col-sm-12 font-weight-bold">Analysis</div> 
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Type</div>
									<div class="col-sm-9">
										<?=ucwords($analytics['type']??"N/A")?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Metric</div>
									<div class="col-sm-9">
										<?=ucwords($analytics['metric']??"N/A")?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Referrer</div>
									<div class="col-sm-9">
										<?=$analytics['referrer']??"N/A"?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">User</div>
									<div class="col-sm-9">
										<?=!empty($a_user) ? anchor($a_user['profile_link'], $a_user['fullname'],
							                    ['id' => 'name'.$a_user['uid'], 'data-img' => $a_user['avatar_link'], 'data-uid' => $a_user['uid']]) : "N/A"; ?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Item</div>
									<div class="col-sm-9">
										<?=(!is_numeric($analytics['item_id'])) ? $analytics['item_id'] : "N/A"?>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-3 font-weight-bold">Date</div>
									<div class="col-sm-9">
										<?=date('d M Y - h:i A', $analytics['date'])?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
