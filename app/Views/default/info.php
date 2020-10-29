<?php  
$theme = array(
	'name'        => 'Default',
	'version'     => '1.1.0',
	'author'      => 'Ourzobia',
	'status'      => 'Incomplete',
    'availability' => 'User, Admin and Frontend',
    'stable'      => ['user', 'admin','frontend'], //['admin', 'user','frontend']
    'modules'     => [
    	/*User Modules*/'error_page','dashboard','products','account','profile','m','hubs','hub_type', 'payments',
    	/*Admin Modules*/'_dashboard','_users','_products','_config','_features','_content','_gallery','_hubs','_hub_type', '_payments', '_analytics'], 
	'modes'		  => ['light']
);
