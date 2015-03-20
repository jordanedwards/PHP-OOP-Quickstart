<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',0);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
ini_set('error_log','error_log.txt');

require("../classes/class_project.php");
require("../classes/class_data_manager_extended.php");

extract($_GET);

/*
foreach ($_GET as $key => $value){
	echo "<li>$key: $value</li>";
}
*/

if (!isset($selected_table) || !isset($environment) || !isset($project_name)){
echo "table, environment, or project not selected";
die();
}

// Get project settings
$project = new DataManager();
$project->get_by_name($project_name);
$project->set_selected_environment($environment);
$project->setConnection();

//echo $project;

	function trim_from_marker($str, $marker) {
		$marker_location = strpos($str,$marker,0);
		return substr($str,$marker_location+1, strlen($str));
	}
	
/*
	$sql = "Show columns from " . $selected_table;
	$result = $project->queryRecords($sql);
	
	$num_rows = mysql_num_rows($result);

	while ($row = mysql_fetch_row($result)) {
		$field_names[$row[0]]= trim_from_marker($row[0],"_");
	}
	*/	

foreach($_GET['fields'] as $key => $value){

$field_names[$key]= trim_from_marker($key,"_");
$field_types[$key] = $value;
}

foreach($_GET['required'] as $key => $value){
	$required_field_names[$key]= $value;
	switch ($field_types[$key]):
		case "text":
			$required_field_validate[$key] = "minlength: 2, required: true";
		break;
		case "textarea":
			$required_field_validate[$key]  = "minlength: 2, required: true";
		break;		
		case "email":
			$required_field_validate[$key]  = "email: true, required: true";
		break;
		default:
			$required_field_validate[$key]  = "required: true";
		break;
	endswitch;
}
/*
echo "<pre>";
var_dump($required_field_validate);
echo "</pre>";

foreach($field_names as $key => $val):
echo $key . " : " . $required_field_names[$key] . " / " . $required_field_names[$key]["validate_vars"]. "<br>";

endforeach;

exit();
*/
	// Get Primary Index:
	// Move to class and create object (future)
	$sql = 'SHOW INDEXES FROM ' . $selected_table . ' WHERE Key_name = "PRIMARY" AND  Key_name = "UNIQUE"';
	$indexResult = $project->queryRecords($sql);
	$num_rows_index = mysql_num_rows($indexResult);
	
	if ($num_rows_index > 0){
	while ($row = mysql_fetch_array($indexResult, MYSQL_ASSOC)) {
		$index_name = $row['Column_name'];
	
	}
	} else {
		$index_name	= $selected_table . "_id";
	}
	

// Instantiate Templating engine, populate and print to file

// Create filter to change <dynamic> tags to <?php tags in the output
require '../Savant3/Savant3/Filter.php';
class swapTags extends Savant3_Filter {
  public static function filter($buffer) {
    $search = array("<dynamic>","</dynamic>");
    $replace = array('<?php ',' ?>');
    $buffer = str_replace($search, $replace, $buffer);
    return $buffer;
  }
}

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
$savant->settings = $project->get_attributes();
$savant->field_names = $field_names;
$savant->field_types = $field_types;
$savant->required_field_names = $required_field_names;
$savant->required_field_validate = $required_field_validate;
$savant->selected_table = $selected_table;
$savant->index_name = $index_name;

$savant->addFilters(array('swapTags', 'filter'));

  header('Content-disposition: attachment; filename='.$selected_table.'_edit.php');
  header ("Content-Type:text/php");  

	$savant->display("edit.tpl");

// NEXT STEPS:
// - write $savant->display to list.php in tmp directory
// - write page_template file to tmp directory
// Zip them both and output to browser as zip file

    ?>