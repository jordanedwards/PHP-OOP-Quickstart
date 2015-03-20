<?php

/* Populates files with project data, then creates a compressed zip file of the base classes, includes and file structure*/


function create_zip($files = array(),$destination = '',$overwrite = true) {
	//if the zip file already exists and overwrite is false, return false
	if(file_exists($destination) && !$overwrite) { return false; }
	//vars
	$valid_files = array();
	//if files were passed in...
	if(is_array($files)) {
		//cycle through each file
		foreach($files as $file) {
			//make sure the file exists
			if(file_exists($file)) {
				$valid_files[] = $file;
			}
		}
	}
	//if we have good files...
	if(count($valid_files)) {
		//create the archive
		$zip = new ZipArchive();
		if($zip->open($destination,$overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true) {
			return false;
		}
		//add the files
		foreach($valid_files as $file) {
			$zip->addFile($file,$file);
		}
		//debug
		//echo 'The zip archive contains ',$zip->numFiles,' files with a status of ',$zip->status;
		
		//close the zip -- done!
		$zip->close();
		
		//check to make sure the file exists
		return file_exists($destination);
	}
	else
	{
		return false;
	}
}


if (isset($_GET['project'])){
// Write to these files the project specific variables:
/* 
config_app.php
config_db.php
init.php
*/

//Pull JSON data from project file:
writeFiles($_GET['project']);
}

function writeFiles($project){
if (isset($project)){
//Pull JSON data from project file:

$project = 'projects/'.$project;
$project = file_get_contents($project);

$json_project_settings=json_decode($project,true);
echo $json_project_settings["settings_email"] . "<br>";
echo $json_project_settings["settings_timezone"] . "<br>";


//*********************************************************************************
// config_app.php:
//********************************************************************************
// 
$out=  <<<'EOD'
<?php
// Application Configuration File
// set application variables

$appConfig['app_title'] = 
EOD;
$out .= '"' . $json_project_settings['settings_application_name'] . '"';
$out .= <<<'EOD'

// Discover which environment we are in:
	
if($_SERVER['HTTP_HOST'] == 'localhost'):
	ini_set('display_errors',1); 
 	error_reporting(E_ALL);
	$appConfig["environment"] = "local_development";
EOD;
if ($json_project_settings['dev_use']==1){
$out .= <<<'EOD'


elseif ($_SERVER['HTTP_HOST'] == 
EOD;
$out .= '"' . $json_project_settings['dev_url'] . '"):
';
$out .= <<<'EOD'
	ini_set('display_errors',1); 
 	error_reporting(E_ALL);
	$appConfig["environment"] = "development";
	
EOD;
}
$out .= <<<'EOD'

else:
	$appConfig["environment"] = "production";	
endif;
EOD;

$file_name = "base/includes/config_app.php";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);


//*********************************************************************************
// config_db.php:
//********************************************************************************


$out=  <<<'EOD'
<?php
// Database Configuration File

	require($_SERVER['DOCUMENT_ROOT'] .'/includes/config_app.php');
	
	if ($appConfig["environment"] == 'development'){
		$dbConfig['dbhost'] = 
EOD;

$out .= '"' . $json_project_settings['dev_dbhost'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbuser'] = 
EOD;
$out .= '"' . $json_project_settings['dev_dbuser'] . '";';
$out .= <<<'EOD'

		$dbConfig['dbpass'] = 
EOD;

$out .= '"' . $json_project_settings['dev_dbpass'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbname'] = 
EOD;
$out .= '"' . $json_project_settings['dev_dbname'] . '";';

$out .= <<<'EOD'
		
	}elseif ($appConfig["environment"] == 'local_development'){
		$dbConfig['dbhost'] = 
EOD;

$out .= '"' . $json_project_settings['local_dbhost'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbuser'] = 
EOD;
$out .= '"' . $json_project_settings['local_dbuser'] . '";';
$out .= <<<'EOD'

		$dbConfig['dbpass'] = 
EOD;

$out .= '"' . $json_project_settings['local_dbpass'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbname'] = 
EOD;
$out .= '"' . $json_project_settings['local_dbname'] . '";';

$out .= <<<'EOD'

	}else{
		// Production		
		$dbConfig['dbhost'] = 
EOD;

$out .= '"' . $json_project_settings['pro_dbhost'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbuser'] = 
EOD;
$out .= '"' . $json_project_settings['pro_dbuser'] . '";';
$out .= <<<'EOD'

		$dbConfig['dbpass'] = 
EOD;

$out .= '"' . $json_project_settings['pro_dbpass'] . '";';

$out .= <<<'EOD'
		
		$dbConfig['dbname'] = 
EOD;
$out .= '"' . $json_project_settings['pro_dbname'] . '";';

$out .= <<<'EOD'

	}
EOD;
$file_name = "base/includes/config_db.php";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);



//*********************************************************************************
// init.php:
//********************************************************************************


$out=  <<<'EOD'
<?php
	ob_start();
	session_start();
	date_default_timezone_set(
EOD;

$out .= '"' . $json_project_settings['settings_timezone'] . '");';

$out .= <<<'EOD'

	include($_SERVER['DOCUMENT_ROOT'] . '/includes/config_app.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/classes/class_session_manager.php');
	include($_SERVER['DOCUMENT_ROOT'] . '/classes/class_functions.php');
	
	$session = new SessionManager();
		
	$alert_msg = $session->getAlertMessage();
	$alert_color = $session->getAlertColor();
	$admin_email = 
EOD;

$out .= '"' . $json_project_settings['settings_email'] . '";';

$file_name = "base/includes/init.php";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);	
	
// $_GET['project'] isset close bracket:
}
// End function:
}

// Make this dynamic at some point (pull everything in the "Base" folder):

$files_to_zip = array(
	'base/actions/index.html',
	'base/ajax/index.html',
	'base/classes/class_data_manager.php',
	'base/classes/class_error_handler.php',
	'base/classes/class_functions.php',
	'base/classes/class_phpmailer.php',
	'base/classes/class_record_pager.php',
	'base/classes/class_session_manager.php',					
	'base/includes/config_app.php',
	'base/includes/config_db.php',
	'base/includes/init.php',
	'base/includes/system_messaging.php',
	'base/page_templates/index.html'
);
//if true, good; if false, zip creation failed
$result = create_zip($files_to_zip,'quickstart_base.zip');

$file = 'quickstart_base.zip';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
?>