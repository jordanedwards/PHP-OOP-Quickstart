<?php
// Application Configuration File
// set application variables

$appConfig['app_title'] = "Youve been framed"; 

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',1);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','./error_log.txt');

// Discover which environment we are in:
	
if($_SERVER['HTTP_HOST'] == 'localhost'):
 	error_reporting(E_ALL);
	$appConfig["environment"] = "local_development";
else:
	$appConfig["environment"] = "production";
	ini_set('display_errors', 'off');
	error_reporting(E_ERROR | E_WARNING  | E_PARSE);
endif;