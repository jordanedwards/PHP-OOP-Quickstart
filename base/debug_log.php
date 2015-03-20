<?php
require_once("includes/init.php"); 
//ini_set('display_errors', 0);
$dm = new DataManager();

if (isset($_GET['delete-entry'])):
	$strSQL = 'DELETE FROM log WHERE log_id =' . mysql_real_escape_string($_GET['delete-entry']);
	$result = $dm->queryRecords($strSQL);
endif;

if (isset($_GET['clear-all'])):
	if ($_GET['clear-all']):
		$strSQL = 'DELETE FROM log WHERE 1=1';
		$result = $dm->queryRecords($strSQL);
	endif;
endif;

	?>
<style>
.debugTable{
	padding:5px;
	border: 1px solid #000;
	border-collapse: collapse;
}
.debugTable th {
	background:#ccc;
	padding:5px;
	border: 1px solid #000;
}
.debugTable td {
	padding:5px;
	border: 1px solid #000;
}

</style>
<h1>Debug Log</h1>
<a href='debug_log.php?clear-all=true'>&raquo; Clear All</a>
<br /><br />
	<table class="debugTable">
	<thead>
	<tr>
		<th>Time</th><th>Content</th><th>User</th><th>Delete</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$strSQL = 'SELECT * FROM log ORDER BY log_time DESC';
	
	$result = $dm->queryRecords($strSQL);
	$num_rows = mysql_num_rows($result);
			
	if ($num_rows != 0):
	
		while ($line = mysqli_fetch_array($result)):
			echo "<tr><td>".$line['log_time'] . "</td><td>" . $line['log_val'] . "</td><td>" . $line['log_user'] . "</td><td align='center'><a href='debug_log.php?delete-entry=" . $line['log_id'] . "'>X</a></td></tr>";
		endwhile;
	else:
		echo "<tr><td colspan='4'>No records</td></tr>";
	endif;		
?>
	</tbody>
	</table>