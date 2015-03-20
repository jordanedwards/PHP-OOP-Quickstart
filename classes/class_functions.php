<?php

//Functions

function consoleLog($val){
	// Don't show anything if IE - Stupid IE breaks
	if (strpos($_SERVER['HTTP_USER_AGENT'],"MSIE",0) == 0){
    $numargs = func_num_args();
    
	if ($numargs >= 2) {
		$val = "";
	    $arg_list = func_get_args();
    	for ($i = 0; $i < $numargs; $i++) {
        	$val .= $arg_list[$i] . " / ";
    	}
	}
		print "<script>console.log('" . mysql_real_escape_string($val) . "')</script>";
	}
}

function addToLog($val){
			require_once($_SERVER['DOCUMENT_ROOT'] . '/quickstart/classes/class_data_manager.php');
			$dm = new DataManager();
			global $session;
			$user_id = $session->get_user_id();
			
			// What kind of $val is this? string, array, or object:
			ob_start();
			if (is_object($val)){
				$val = var_dump($val);
			} elseif(is_array($val)){
				$val = var_dump($val);			
			} else {
				// Just a string
				echo mysql_real_escape_string($val);
			}
			$result = ob_get_contents();
        	ob_end_clean();
		
			$strSQL = "INSERT INTO log (log_user, log_val) VALUES (" . $user_id . ", '" . $result . "')";				
			$result = $dm->updateRecords($strSQL);

}
?><script>
function write_sess_var(type,val){
		$.ajax({
			url:"ajax/ajax_sess_var.php?var="+type+"&val="+val,
				success: function(result){
			}
		});
	}
</script>