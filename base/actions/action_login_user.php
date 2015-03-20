<?php 
	require($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php"); 
	
	// make sure we have valid login information
	if(!isset($_REQUEST["email"]) || !isset($_REQUEST["password"])) {
		$session->setAlertMessage("Invalid login. Please make sure all fields have been entered correctly and try again.");
		$session->setAlertColor("yellow");	
		header("location:/index.php");
		exit;
	}
		
	$email = $_REQUEST["email"];
	$password = $_REQUEST["password"];
	
	// If the user arrived at a login-only page, redirect them to this page after login.
	$redirect = $_POST["redirect"];
	$redirect = str_replace("*","?",$_POST["redirect"]);
	$redirect = str_replace("~","&",$redirect);
	
	if ($redirect == ""){
		$redirect = "/dashboard.php";
	}	
	
	// if the user exists forward them to the dashboard, otherwise keep them at the login page with the appropriate login message
	require($_SERVER['DOCUMENT_ROOT'] . "/classes/class_user.php"); 
	$user = new User();
	$user->set_password($password);
	$user->set_email($email);
	$user_id = $user->login();
		
	if($user_id != "") {
		$user->update_last_login($user_id);
		$session->set_user_id($user_id);
		$session->set_user_role($user->get_role());
		$session->setAlertMessage("Login successful");
			header("location:" . $redirect);
		exit;
	}
	else {
		//The login failed so return the user to the login page with some error vars
		$session->setAlertMessage("Incorrect email/password combination. Please check your CAPS lock key and try again.");
		$session->setAlertColor("yellow");	
		header("location:/index.php");
		exit;
	}		
?>