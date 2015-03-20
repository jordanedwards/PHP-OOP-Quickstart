<?php
// Database Configuration File

	require($_SERVER['DOCUMENT_ROOT'] .'/includes/config_app.php');
	
	if ($appConfig["environment"] == 'development'){
		$dbConfig['dbhost'] = "";		
		$dbConfig['dbuser'] = "";
		$dbConfig['dbpass'] = "";		
		$dbConfig['dbname'] = "";		
	}elseif ($appConfig["environment"] == 'local_development'){
		$dbConfig['dbhost'] = "localhost";		
		$dbConfig['dbuser'] = "root";
		$dbConfig['dbpass'] = "";		
		$dbConfig['dbname'] = "youvebeenframed";
	}else{
		// Production		
		$dbConfig['dbhost'] = "localhost";		
		$dbConfig['dbuser'] = "orchardc_ybf";
		$dbConfig['dbpass'] = "BuRSyeuOaQ4*";		
		$dbConfig['dbname'] = "orchardc_youvebeenframed";
	}