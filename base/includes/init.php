<?php
	ob_start();
	session_start();
	date_default_timezone_set("America/Vancouver");
// Sets the paths for includes for these folders. To access the URL itself, use $json_project_settings array
	$base_folder =  $_SERVER['DOCUMENT_ROOT'] . "/admin";

	$includes_folder = $base_folder . "/includes";
	$class_folder = $base_folder . "/classes";
	$actions_folder = $base_folder . "/actions";
		
	$base_href = "/admin";
	$includes_href = $base_href . "/includes";
	$class_href = $base_href . "/classes";
	$actions_href = $base_href . "/actions";

	require_once($includes_folder . '/config_app.php');
	require_once($class_folder . '/class_session_manager.php');
	require_once($class_folder . '/class_functions.php');
	require_once($class_folder . '/class_data_manager.php');
		
	$session = new SessionManager();
		
	$alert_msg = $session->getAlertMessage();
	$alert_color = $session->getAlertColor();
	
	$admin_email = "jordan@orchardcity.ca";
// ****************************************** SET TO YOUR LOGIN & YOUR LOGIN ACTION PAGE **********************************			
	if ($_SERVER['PHP_SELF'] != "/admin/index.php" && $_SERVER['PHP_SELF'] != "/admin/actions/action_login_user.php"){
		if($session->get_user_id() == "") {
		$current_adr = str_replace("?","*",$_SERVER["REQUEST_URI"]);
		$current_adr = str_replace("&","~",$current_adr);
// ****************************************** SET TO YOUR LOGIN PAGE **********************************		
		header("location:/admin/index.php?redirect="		
.$current_adr );
		exit;
		}
	}