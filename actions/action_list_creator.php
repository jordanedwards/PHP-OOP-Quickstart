<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',0);
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
$project->set_selected_environment($environment);
$project->setConnection();

/*
//If you need to debug and see what is in this object, show this:
echo $project;
exit();
*/
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
$savant->selected_table = $selected_table;
$savant->index_name = $index_name;
$savant->addFilters(array('swapTags', 'filter'));

// Write the output to the list file, using the template
ob_start();

	$savant->display("list.tpl");
	$getContent = ob_get_contents();

ob_end_clean();

$file_name = 'tmp/'.$selected_table.'_list.php';
$fp = fopen($file_name,'w+'); 
fwrite($fp, $getContent); 
fclose($fp);


// Write the output to the page template file, using the template
ob_start();

	$savant->display("list_template.tpl");
	$getContent = ob_get_contents();

ob_end_clean();

$file_name = 'tmp/'.$selected_table.'_list_template.htm';
$fp = fopen($file_name,'w+'); 
fwrite($fp, $getContent); 
fclose($fp);

// Zip them up:

require("../classes/class_zip.php");
	
$files_to_zip = array(
	'tmp/'.$selected_table.'_list.php',
	'tmp/'.$selected_table.'_list_template.htm'
);

$result = create_zip($files_to_zip,'tmp/list-and-page-template.zip');

$file = 'tmp/list-and-page-template.zip';

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