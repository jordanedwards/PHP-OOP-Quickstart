<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',0);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','error_log.txt');
extract($_GET);

if (!isset($selected_table)){
echo "No table selected";
die();
}
$file = file_get_contents('../projects/'.$projectName, true);
$settings = json_decode($file, true);
$settingsText = var_export($settings, true);

require_once('../classes/class_data_manager.php');
$dm = new DataManager($db_host,$db_user,$db_pass,$db_name);

	$sql = "Show columns from " . $selected_table;
	$result = $dm->queryRecords($sql);
	
	$num_rows = mysql_num_rows($result);
	
	function trim_from_marker($str, $marker) {
		$marker_location = strpos($str,$marker,0);
		return substr($str,$marker_location+1, strlen($str));
	}

	while ($row = mysql_fetch_row($result)) {
		$field_names[$row[0]]= trim_from_marker($row[0],"_");
	}
	
  header('Content-disposition: attachment; filename='.$selected_table.'_list.php');
  header ("Content-Type:text/php");  
  print("<?php");
  
  if (isset($template)){
  	require("../templates/".$template."/list.php");
  } else {
  	require("../templates/Standard/list.php");  
  }
    ?>