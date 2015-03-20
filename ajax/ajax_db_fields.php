<p>
	<select id="class_name">
	<option value="">None</option>
		<?php
			require_once($_SERVER['DOCUMENT_ROOT']."/quickstart/classes/class_data_manager.php");
			$dm = new DataManager();

			$sql = "Show fields from " . $_GET['table'];
			$result = $dm->queryRecords($sql);
			while ($row = mysql_fetch_row($result)) {
				 echo '<option value="'. $row[0] . '">' . $row[0] . '</option>';
			}
?>
    </select>
</p>