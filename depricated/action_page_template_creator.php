<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',1);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','error_log.txt');
// Should get selected_table, database settings (change in the future to just pull from project json), project_name

require("../classes/class_project.php");
require("../classes/class_data_manager_extended.php");

extract($_GET);

if (!isset($selected_table) || !isset($environment) || !isset($project_name)){
echo "table, environment, or project not selected";
die();
}

function trim_from_marker($str, $marker) {
	$marker_location = strpos($str,$marker,0);
	return substr($str,$marker_location+1, strlen($str));
}
	
// Get project settings
$project = new DataManager();
$project->get_by_name($project_name);
$project->set_selected_environment("Production");
$project->setConnection();

	// Get Primary Index:
	// Move to class and create object (future)
	$sql = 'SHOW INDEXES FROM ' . $selected_table . ' WHERE Key_name = "PRIMARY" OR Key_name = "UNIQUE"';
	$indexResult = $project->queryRecords($sql);
	$num_rows_index = mysql_num_rows($indexResult);
	
	if ($num_rows_index > 0){
	while ($row = mysql_fetch_array($indexResult, MYSQL_ASSOC)) {
		$index_name = $row['Column_name'];
	
	}
	} else {
		$index_name	= $selected_table . "_id";
	}
	
	// Get field names:
foreach($_GET['fields'] as $key => $value)
{
	$field_names[$key]= trim_from_marker($key,"_");
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