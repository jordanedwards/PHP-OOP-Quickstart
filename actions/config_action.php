<?php
extract($_POST);


if ($Generate == 1){
// Generate Project was clicked:
$project_name = str_replace(" ","_", $settings_application_name);

$out = "{";
foreach ($_POST as $key => $val){
	$out .= '"' . $key . '":"' . $val . '",';
	}
$out = rtrim($out, ",");
$out .= "}";

$file_name = "../projects/" . $project_name . ".ini";
$fp = fopen($file_name,'w+'); 
fwrite($fp, $out); 
fclose($fp);

$header = 'Location: ../index.php?load_project=' . $project_name . ".ini";
header($header); 
}


if ($Create_SQL == 1){
//echo $out

foreach ($_POST as $key => $val){
			echo $key . " - " . $val."<br>";
	}
}
?>