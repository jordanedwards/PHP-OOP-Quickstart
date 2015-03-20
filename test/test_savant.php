<?php
// include Savant class file
require_once '../Savant3/Savant3.php';

	
// initialize template engine
$savant = new Savant3();

// assign template variables
$savant->answer = 'Goat';
$savant->punchline = 'Goat to the door and find out.';

// interpolate variables and display template
$savant->display('knock.tpl');
?>