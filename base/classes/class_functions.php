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
	require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
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
		echo mysqli_real_escape_string($dm->connection, $val);
	}
	$result = ob_get_contents();
	ob_end_clean();

	$strSQL = "INSERT INTO log (log_user, log_val) VALUES (" . $user_id . ", '" . $result . "')";				
	$result = $dm->updateRecords($strSQL);

}

function escaped_var_from_post($varname){
	$dm = new DataManager();
	if (isset($_REQUEST[$varname])){
		$$varname = mysqli_real_escape_string($dm->connection, $_REQUEST[$varname]);
	}else{
		$$varname = "";
	}
		return $$varname;
}


/* backup the db OR just a table */
function backup_tables($tables = '*')
{
	require_once('class_data_manager.php');
	$dm = new DataManager();
	
	//get all of the tables
	if($tables == '*')
	{
		$tables = array();
		$result = $dm->queryRecords('SHOW TABLES');
		while($row = mysqli_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}
	else
	{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}
	
	//cycle through
	foreach($tables as $table)
	{
		$result = $dm->queryRecords('SELECT * FROM '.$table);
		$num_fields = mysqli_num_fields($result);
		
		$return.= 'DROP TABLE '.$table.';';
		$row2 = mysqli_fetch_row($dm->queryRecords('SHOW CREATE TABLE '.$table));
		$return.= "\n\n".$row2[1].";\n\n";
		
		for ($i = 0; $i < $num_fields; $i++) 
		{
			while($row = mysqli_fetch_row($result))
			{
				$return.= 'INSERT INTO '.$table.' VALUES(';
				for($j=0; $j<$num_fields; $j++) 
				{
					$row[$j] = addslashes($row[$j]);
					//$row[$j] = ereg_replace("\n","\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}
	
	//save file
	$handle = fopen('db-backup-'.time().'-'.(md5(implode(',',$tables))).'.sql','w+');
	fwrite($handle,$return);
	fclose($handle);
}
?>

