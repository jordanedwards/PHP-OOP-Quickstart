<?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php"); ?>
<?php
	// verify that the admin user is logged in
	if($session->get_user_id() != "") {
		header("location:/dashboard.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $appConfig["app_title"]; ?></title>
	<link href="/css/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div id="page_wrapper">
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/admin_header.php"); ?>
    <div id="right_column">
    	<div id="content_wrapper">
        <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php"); ?>
        <p>Enter the email address associated with your account. If your email address is found in the system we will send an email to your account with intructions on how to reset your password.</p>
        <form id="form1" action="/actions/action_forgot_password_admin.php" method="post">
        	<table cellpadding="2px" cellspacing="0" border="0">
          <tr><td>Email:</td><td><input id="email" name="email" type="text" size="50" /></td></tr>
          <tr><td></td><td><input type="submit" value="Reset Password" /></td></tr>
          </table>
        </form>
				<a href="/">&laquo;Back</a>
      </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/left_admin_column.php"); ?>
  </div>
  <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/admin_footer.php"); ?>
</body>
</html>