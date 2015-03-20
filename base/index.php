<?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php"); ?>
<?php
	// verify that the admin user is logged in
	if($session->get_user_id() != "") {
	// ****************************************** SET TO YOUR HOME PAGE **********************************
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
        <form id="form1" action="/actions/action_login_user.php" method="post">
        	<table cellpadding="2px" cellspacing="0" border="0">
          <tr><td>Email:</td><td><input id="email" name="email" type="text" size="50" /></td></tr>
          <tr><td>Password:</td><td><input id="password" name="password" type="password" /></td></tr>
          <tr><td></td><td><input type="submit" value="Login" /></td></tr>
          </table>
        </form>
        <br />
      	<a href="/forgot_password.php">Reset Your Password</a>
      </div>
    </div>
    <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/left_admin_column.php"); ?>
  </div>
  <?php include($_SERVER['DOCUMENT_ROOT'] . "/includes/admin_footer.php"); ?>
</body>
</html>