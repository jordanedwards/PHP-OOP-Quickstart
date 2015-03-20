<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',0);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','error_log.txt');
// Should get selected_table, database settings (change in the future to just pull from project json), project_name
extract($_GET);

if (!isset($selected_table)){
echo "No table selected";
die();
}
// Get project settings
$file = file_get_contents('../projects/'.$projectName, true);
$settings = json_decode($file, true);
//$settingsText = var_export($settings, true);

// Get field names from selected table
// Move to class and create object (future)
require_once('../classes/class_data_manager.php');
$dm = new DataManager($db_host,$db_user,$db_pass,$db_name);

		// Get Primary Index:
	// Move to class and create object (future)
	$sql = 'SHOW INDEXES FROM ' . $selected_table . ' WHERE Key_name = "PRIMARY" OR Key_name = "UNIQUE"';
	$indexResult = $dm->queryRecords($sql);
	$num_rows_index = mysql_num_rows($indexResult);
	
	if ($num_rows_index > 0){
	while ($row = mysql_fetch_array($indexResult, MYSQL_ASSOC)) {
		$index_name = $row['Column_name'];
	
	}
	} else {
		$index_name	= $selected_table . "_id";
	}
	
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
	

	

// Instantiate Templating engine, populate and print to file

// include Savant class file
require_once '../Savant3/Savant3.php';

// initialize template engine
  if (isset($template)){
  	$config = array(
    'template_path' => array("../templates/".$template."")
	); 
  } else {
  	$config = array(
    'template_path' => array("../templates/Standard")
	); 
  }
   
$savant = new Savant3($config);

// assign template variables
$savant->settings = $settings;
$savant->field_names = $field_names;
$savant->selected_table = $selected_table;
$savant->index_name = $index_name;

  header('Content-disposition: attachment; filename='.$selected_table.'_list_template.htm');
  header ("Content-Type:text/html");  

	$savant->display("list_template.tpl");

// NEXT STEPS:
// - write $savant->display to list.php in tmp directory
// - write page_template file to tmp directory
// Zip them both and output to browser as zip file

    ?>