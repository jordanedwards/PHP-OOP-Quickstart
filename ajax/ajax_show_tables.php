<?php
   			mysql_connect($_GET['db_host'], $_GET['db_user'], $_GET['db_pass'])
			   or die("Database connection error");
		    mysql_select_db($_GET['db_name']) or die("Database connection error");
			?>
	<select name="selected_table" id="selected_table" onChange="updateSelected(this.value)">
	<option value=""></option>
		<?php
			$sql = "Show tables from " . $_GET['db_name'];
			$result=mysql_query($sql);
			
			while ($row = mysql_fetch_row($result)) {
				 echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
			}
?>
    </select>