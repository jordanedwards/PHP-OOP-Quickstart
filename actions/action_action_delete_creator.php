<?php
error_reporting(0);
ini_set('display_errors', '0');
extract($_GET);

  header('Content-disposition: attachment; filename=action_'.$selected_table.'_delete.php');
  header ("Content-Type:text/php");  
  print("<?php");
?>

	// include necessary libraries
	include($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php");
	include($_SERVER['DOCUMENT_ROOT'] . "/includes/init_admins.php");
	
	// verify that we have a valid id
	if(!isset($_GET["id"])) {
		$session->setAlertMessage("Could not delete the target <?php echo $selected_table ?> - invalid ID. Please try again.");
		$session->setAlertColor("yellow");	
		header("location:/<?php echo $selected_table ?>_list.php");
		exit;
	}
	
	$id = $_GET["id"];
	
	// delete the record from the database
	include($_SERVER['DOCUMENT_ROOT'] . "/classes/class_<?php echo $selected_table ?>.php"); 
	$<?php echo $selected_table ?> = new <?php echo $selected_table ?>();
		
	if($<?php echo $selected_table ?>->delete_by_id($id) == true) {
		$session->setAlertMessage("The <?php echo ucfirst($selected_table) ?> has been removed successfully.");
		$session->setAlertColor("green");
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}
	else {
		$session->setAlertMessage("There was a problem removing the <?php echo ucfirst($selected_table) ?>. Please try again.");
		$session->setAlertColor("yellow");	
		header("location:".$_SERVER['HTTP_REFERER']);
		exit;
	}