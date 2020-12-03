<?php
define('JODIT_DEBUG', false);
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Application.php';

$config = require(__DIR__ . "/default.config.php");

if (file_exists(__DIR__ . "/config.php")) {
	$config = array_merge($config, require(__DIR__ . "/config.php"));
}

define('JODIT_CONFIG', $config);
