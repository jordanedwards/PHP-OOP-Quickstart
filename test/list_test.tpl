 <dynamic>
 include($_SERVER['DOCUMENT_ROOT'] . "/<?php echo $this->settings['includes_url']; ?>/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_<?php echo $this->selected_table; ?>.php");
 </dynamic>