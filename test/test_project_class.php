<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',1);
ini_set('log_errors',1);

require("../classes/class_project.php");
require("../classes/class_data_manager_extended.php");

$project = new DataManager();
$project->get_by_name("Orchardcity.ini");
$project->set_selected_environment("Production");
$project->setConnection();

echo "<h3>Actual results from a query:</h3><ul>";
$query="SELECT * FROM customers";
$result = $project->queryRecords($query);

while ($row = mysql_fetch_array($result))
{
	 echo "<li>" . $row['customer_name'] . "</li>";
}
echo "</ul>";

echo $project;
?>
<br />
Here