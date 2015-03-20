<?php 
	ini_set('display_errors','on');
//	require_once($_SERVER['DOCUMENT_ROOT'] . "/quickstart/includes/init.php");
/*
foreach ($_POST as $key => $val){
			echo $key . " - " . $val."<br>";
	}

exit();*/
$table_name = $_POST['table_name'];

// Directly update database:
if ($_GET['sqlInsert'] == "true"){

extract($_GET);
require_once('../classes/class_data_manager.php');
$dm = new DataManager($db_host,$db_user,$db_pass,$db_name);

$strSQL = "
CREATE TABLE IF NOT EXISTS `". $table_name. "` (
`" . $table_name . "_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
"; 

foreach($_POST as $key => $value) {
	if (substr($key,0,5) == "field"){
		$strSQL .= "`" . $table_name . "_" . $value . "` ";
	}
	if (substr($key,0,4) == "type"){
		$strSQL .= $value . " NOT NULL,
";
	}
}
$strSQL .="
`is_active` varchar(1) NOT NULL DEFAULT 'Y',
`". $table_name. "_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`". $table_name. "_last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`". $table_name. "_last_updated_user` varchar(200) NOT NULL DEFAULT '0',
  
PRIMARY KEY (`". $table_name. "_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;
";

//mail("jordan@orchardcity.ca","test",$strSQL);
//$result= $dm->queryRecords("Create table TESTtable");
$result = $dm->queryRecords($strSQL);
	
	if ($result){
		$msg="success";
	} else {
	$msg="failed" . "<br>
	" . $strSQL;
	echo $msg;
	exit();
	}

	header("Location: ../index.php?load_project=". $_GET['projectName'] . "&msg=".$msg);
}

// Spit out file instead:
  header('Content-disposition: attachment; filename='.$table_name.'.sql');
  header ("Content-Type:text/sql");  
	
?>

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `<?php echo $table_name ?>` (
`<?php echo $table_name ?>_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
<?php 
foreach($_POST as $key => $value) {
	if (substr($key,0,5) == "field"){
		echo "`" . $table_name . "_" . $value . "` ";
	}
	if (substr($key,0,4) == "type"){
		echo $value . " NOT NULL,
";
	}
}
?>
`is_active` varchar(1) NOT NULL DEFAULT 'Y'
`<?php echo $table_name ?>_date_created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`<?php echo $table_name ?>_last_updated` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
`<?php echo $table_name ?>_last_updated_user` varchar(200) NOT NULL DEFAULT '0',
  
PRIMARY KEY (`<?php echo $table_name ?>_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;


