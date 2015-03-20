<?php
ini_set('display_errors',0);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','error_log.txt');

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


/* Populates files with project data, then creates a compressed zip file of the base classes, includes and file structure*/
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

// To do: Pull vendor specific files depending on the template type:
// $json_project_settings['output_type']


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
$out .= '"' . $json_project_settings['settings_application_name'] . '"; ';
$out .= <<<'EOD'


error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',1);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','./error_log.txt');

// Discover which environment we are in:
	
if($_SERVER['HTTP_HOST'] == 'localhost'):
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
 	error_reporting(E_ALL);
	$appConfig["environment"] = "development";
	
EOD;
}
$out .= <<<'EOD'

else:
	$appConfig["environment"] = "production";
	ini_set('display_errors', 'off');
	error_reporting(E_ERROR | E_WARNING  | E_PARSE);
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

// Sets the paths for includes for these folders. To access the URL itself, use $json_project_settings array
	$base_folder = 
EOD;

if (isset($json_project_settings['base_url'])){
	$out .= ' $_SERVER[\'DOCUMENT_ROOT\'] . "/' . $json_project_settings['base_url'] . '";';
} else {
	$out .= ' $_SERVER[\'DOCUMENT_ROOT\'];';
}

$out .= <<<'EOD'


	$includes_folder = 
EOD;

$out .= '$base_folder . "/' . $json_project_settings['includes_url'] . '";';

$out .= <<<'EOD'

	$class_folder = 
EOD;

$out .= '$base_folder . "/' . $json_project_settings['class_url'] . '";';

$out .= <<<'EOD'

	$actions_folder = 
EOD;

$out .= '$base_folder . "/' . $json_project_settings['actions_url'] . '";
';

if (isset($json_project_settings['base_url'])){
	$out .= '		
	$base_href = "/' . $json_project_settings['base_url'] . '";
	';
} else {
	$out .= '		
	$base_href ="";
	';
}

	$out .= '$includes_href = $base_href . "/' .$json_project_settings['includes_url'] .'";
';
	$out .= '	$class_href = $base_href . "/' .$json_project_settings['class_url'] .'";
';
	$out .= '	$actions_href = $base_href . "/' .$json_project_settings['actions_url'] .'";
';	
	
$out .= <<<'EOD'

	require_once($includes_folder . '/config_app.php');
	require_once($class_folder . '/class_session_manager.php');
	require_once($class_folder . '/class_functions.php');
	require_once($class_folder . '/class_data_manager.php');
	
	// Get settings:
	// Show if you have a settings table and want to write the settings as constants:
	/*$dm = new DataManager(); 
	$strSQL = "SELECT * FROM settings";						

	$result = $dm->queryRecords($strSQL);	
	while($row = mysqli_fetch_assoc($result)):
		$const_name = strtoupper(str_replace(" ","_",$row['settings_name']));
		define($const_name,$row['settings_value']);
	endwhile;*/
		
	$session = new SessionManager();
		
	$alert_msg = $session->getAlertMessage();
	$alert_color = $session->getAlertColor();
	
	$admin_email = 
EOD;

$out .= '"' . $json_project_settings['settings_email'] . '";';
$out .= '
// ****************************************** SET TO YOUR LOGIN & YOUR LOGIN ACTION PAGE **********************************			
	if ($_SERVER[\'PHP_SELF\'] != ';	


if (isset($json_project_settings['base_url'])){
	$out .=	'"/' . $json_project_settings['base_url'] . '/index.php" && $_SERVER[\'PHP_SELF\'] != "/' . $json_project_settings['base_url'] . "/" . $json_project_settings['actions_url'] . '/action_login_user.php"';
} else {
	$out .=	'/index.php" && $_SERVER[\'PHP_SELF\'] != "/' . $json_project_settings['actions_url']. '/action_login_user.php"';
}

$out .= <<<'EOD'
){
		if($session->get_user_id() == "") {
		$current_adr = str_replace("?","*",$_SERVER["REQUEST_URI"]);
		$current_adr = str_replace("&","~",$current_adr);
// ****************************************** SET TO YOUR LOGIN PAGE **********************************		
		header(
EOD;

if (isset($json_project_settings['base_url'])){
	$out .=	'"location:/' .$json_project_settings['base_url'] . '/index.php?redirect="';
} else {
	$out .=	'"location:/index.php?redirect="';
}
$out .= <<<'EOD'
		
.$current_adr );
		exit;
		}
	}
EOD;

$file_name = "base/includes/init.php";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);	

//*********************************************************************************// setup.sql://********************************************************************************
// Sets up users, log tables
$out=  <<<'EOD'

CREATE TABLE IF NOT EXISTS `user` (  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,  `user_first_name` varchar(50) NOT NULL DEFAULT '',  `user_last_name` varchar(50) NOT NULL DEFAULT '',  `user_email` varchar(100) NOT NULL DEFAULT '',  `user_tel` varchar(20) NOT NULL DEFAULT '0',  `user_carrier` varchar(20) NOT NULL DEFAULT '0',  `user_password` varchar(100) NOT NULL DEFAULT '',  `user_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_role` smallint(11) NOT NULL DEFAULT '0',  `user_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',  `user_last_updated_user` varchar(200) NOT NULL DEFAULT '0',  PRIMARY KEY (`user_id`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(8) NOT NULL AUTO_INCREMENT,
  `log_user` int(3) NOT NULL,
  `log_val` longtext NOT NULL,
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

EOD;

$file_name = "base/setup.sql";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);	
}
// End function:
}

// Make this dynamic at some point (pull everything in the "Base" folder):

$files_to_zip = array(
	'base/actions/action_forgot_password_admin.php',
	'base/actions/action_login_user.php',    	
	'base/actions/action_logout.php',	    	
	'base/ajax/index.html',
	'base/classes/class_data_manager.php',
	'base/classes/class_drop_downs.php',	
	'base/classes/class_error_handler.php',
	'base/classes/class_functions.php',
	'base/classes/class_phpmailer.php',
	'base/classes/class_record_pager.php',
	'base/classes/class_session_manager.php',
	'base/classes/class_user.php',
	'base/css/font-awesome.css',	
	'base/css/styles.css',
	'base/css/print.css',
	'base/fonts/FontAwesome.otf',
	'base/fonts/fontawesome-webfont.eot',
	'base/fonts/fontawesome-webfont.svg',
	'base/fonts/fontawesome-webfont.ttf',
	'base/fonts/fontawesome-webfont.woff',									
	'base/includes/config_app.php',
	'base/includes/config_db.php',
	'base/includes/config_mail.php',
	'base/includes/config_secure.php',	
	'base/includes/init.php',
	'base/includes/system_messaging.php',
	'base/images/add.png',
	'base/images/arrow_down.png',	
	'base/images/asc.gif',	
	'base/images/bg.gif',	
	'base/images/carets.gif',	
	'base/images/darken.gif',	
	'base/images/delete.gif',	
	'base/images/desc.gif',	
	'base/images/document.png',	
	'base/images/edit.png',
	'base/images/icon_search.png',	
	'base/images/lighten.png',	
	'base/images/view.png',	
	'base/page_templates/index.html',
	'base/setup.sql',	
	'base/index.php',	
	'base/forgot_password.php'	
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