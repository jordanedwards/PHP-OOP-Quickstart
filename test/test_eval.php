<?php
$appConfig["app_title"] = "TEST";
$output = file_get_contents('../templates/Bootstrap/test_list_2.php');
/*
// replace the dynamic php tags so they don't get evaluated (we'll put them back later)
$output = str_replace("<?php ","<dynamic ",$file);
$output = str_replace("?> ","dynamic> ",$output);

// Convert eval tags to php tags
$output = str_replace("<eval>","<?php echo",$output);
$output = str_replace("</eval>","?>",$output);
*/
$string = "beautiful";
$time = "winter";
$settings['base_url'] = "testsite";
$selected_table  = "test_table";

$str = 'This is a $string $time morning!';

eval("\$str = \"$str\";");
echo $str;
echo "<br>";

eval("\$output = \"$output\";");
echo $output;
?>
