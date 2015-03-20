<?php
	// include necessary libraries
	include($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php");
    include($_SERVER['DOCUMENT_ROOT'] . "/classes/class_user.php");
	$user = new User();

  //Initiate the emailer
	include($_SERVER['DOCUMENT_ROOT'] . '/includes/config_mail.php');
	require_once($_SERVER['DOCUMENT_ROOT']."/classes/class_phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->Host = $mailConfig["mail_server"];
	$mail->Port = $mailConfig["mail_port"];
	$mail->Mailer = $mailConfig["mail_mailer"];
	$mail->SMTPAuth = $mailConfig["mail_smtpauth"];
	$mail->Username = $mailConfig["mail_username"];
	$mail->Password = $mailConfig["mail_password"];

  if(isset($_POST['email'])) {
		
  	if($user->get_by_email($_POST['email'])){
			
    	// code
      $code = $user->get_id() . '&c=' . $user->get_password();
			
	echo('<html><body>TEST2</body></html>');
			// set up mail account info
			$mail->IsHTML(true);
			$mail->From = $mailConfig["mail_from"];
			$mail->FromName = $mailConfig["mail_fromname"];
			$mail->Sender = $mailConfig["mail_sender"];
			$mail->AddAddress($_POST['email'], "");

			$mail->WordWrap = 50; // set word wrap to 50 characters
			$mail->Subject = "Reset Your Password";
			$body = "
A password reset request has been initiated for your account. If you would like to reset your password click the link below.

<a href='http://".$_SERVER['HTTP_HOST']."/actions/action_forgot_password_admin.php?id=".$code."'>http://".$_SERVER['HTTP_HOST']."/actions/action_forgot_password_admin.php?id=".$code."</a><br />
<br />
Please do not reply to this email.<br />
".$appConfig["app_title"]." Team<br />";
			$mail->Body = $body;
			
			if(!$mail->Send()){
				die("Message could not be sent. <p>Mailer Error: " . $mail->ErrorInfo);
			}
			$mail = NULL;

			$session->setAlertMessage("An email was sent to your account with password reset instructions.");
			$session->setAlertColor("green");
			header("location:/");
			exit;

		} else{
			$session->setAlertMessage("Could not find the associated email address.");
			$session->setAlertColor("red");
			header("location:/forgot_password.php");
			exit;
		}
  } elseif(isset($_GET['id'])) {
  	
		if($user->get_by_id(intval($_GET['id'])) && $_GET['c'] == $user->get_password()) {
			$password = $user->get_random_password(10);
			$user->set_password($password);
			$user->save();
		
			// set up mail account info
			$mail->IsHTML(true);
			$mail->From = $mailConfig["mail_from"];
			$mail->FromName = $mailConfig["mail_fromname"];
			$mail->Sender = $mailConfig["mail_sender"];
			$mail->AddAddress($user->get_email(), "");

			$mail->WordWrap = 80; // set word wrap to 50 characters
			$mail->Subject = "Your New Password";
			$body = "
A new password has been generated for your account. We recommend you change this password immediately upon logging in.	<br />
<br />
Password: ".$password."
<br />
Please do not reply to this email.<br />
".$appConfig["app_title"]." Team<br />";
			$mail->Body = $body;
			if(!$mail->Send()){
				die("Message could not be sent. <p>Mailer Error: " . $mail->ErrorInfo);
			}
			$mail = NULL;

			$session->setAlertMessage("Your password has been reset successfully. Please check your email for your new login credentials.");
			$session->setAlertColor("green");
			header("location:/");
			exit;

		}else{
			$session->setAlertMessage("Could not find the associated email address.");
			$session->setAlertColor("red");
			header("location:/forgot_password.php");
			exit;
		}
    }

?>
