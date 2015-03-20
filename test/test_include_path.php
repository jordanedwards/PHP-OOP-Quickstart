<?php
ini_set('display_errors',1);
ini_set('log_errors',1);
ini_set('log_errors_max_len',0);
//ini_set('error_log','error_log.txt');

echo get_include_path();
echo realpath(dirname(__FILE__));
//set_include_path('/home/ftpuser/public_html/includes/');
//include(BASE_DIR . '/untitled.php');

?>