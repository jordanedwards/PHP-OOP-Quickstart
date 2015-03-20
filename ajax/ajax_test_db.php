<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',0);
ini_set('log_errors',0);

require("../classes/class_project.php");
require("../classes/class_data_manager_extended.php");

extract($_GET);

$project = new DataManager();
$project->get_by_name($project_name);
$project->set_selected_environment($environment);

if ($project->setConnection()):
	echo $environment . " Database connected successfully";
else:
	$dbConnectDetails = "HOST: " . $project->get_dbhost() . "<br>USER: " . $project->get_dbuser() . "<br>PASS: " . $project->get_dbpass() . "<br> DATABASE:" .$project->get_dbname();
	echo $environment . " Database connection failed using: <br>" . $dbConnectDetails;
endif;
?>

