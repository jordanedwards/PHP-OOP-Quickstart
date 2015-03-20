<?php
   			mysql_connect($_GET['db_host'], $_GET['db_user'], $_GET['db_pass'])
			   or die("Database credential failed: Host - " . $_GET['db_host'] . " User - " . $_GET['db_user'] . " Pass - " . $_GET['db_pass']);
		    mysql_select_db($_GET['db_name']) or die("Database name does not exist");
			?>
	<select name="selected_field" id="selected_field">
	<option value=""></option>
		<?php
			$sql = "Show fields from " . $_GET['table'];
			$result=mysql_query($sql);
			
			while ($row = mysql_fetch_row($result)) {
				 echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
			}
?>
    </select>