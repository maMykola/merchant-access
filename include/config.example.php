<?php
$db_config = [
	'dbName'=>'merchant_access',
	'dbLogin'=>'LOGIN',
	'dbPassword'=>'PASSWORD',
	'host'=>'localhost',
	];



defined("DB_CONFIG_NAME") || define("DB_CONFIG_NAME", 'merchant_access');
defined("DB_CONFIG_LOGIN") || define("DB_CONFIG_LOGIN", 'LOGIN');
defined("DB_CONFIG_PASSWORD") || define("DB_CONFIG_PASSWORD", 'PASSWORD');
defined("DB_CONFIG_HOST") || define("DB_CONFIG_HOST", 'localhost');

defined("GOOGLE_CAPTCHA_SITEKEY") || define("GOOGLE_CAPTCHA_SITEKEY", 'SITEKEY');
defined("GOOGLE_CAPTCHA_SECRETKEY") || define("GOOGLE_CAPTCHA_SECRETKEY", 'SECRETKEY');