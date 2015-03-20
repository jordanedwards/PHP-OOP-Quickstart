<style>
input {
width: 300px;
}
</style>
<div class="field">
<label class="main">Fields:</label>
<table id="field_list" style="float: right;">
<tbody id="field_list_group">
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors',1);
ini_set('log_errors',1);

require("../classes/class_project.php");
require("../classes/class_data_manager_extended.php");

if (isset($_GET['project'])){

$project = new DataManager();
$project->get_by_name($_GET['project']);
$project->set_selected_environment($_GET['environment']);
$project->setConnection();

	function checkSelected($val_type,$val) {
		if ($val_type == $val){
			return ' selected="selected" ';
		}
	}
	
	$sql = "Show fields from " . $_GET['table'];
	$sql = "SELECT * from " . $_GET['table'];
	
	$result=mysql_query($sql);
	
	$result = mysql_query($sql);
	$fields = mysql_num_fields($result);
	$rows   = mysql_num_rows($result);
	
	for ($i=0; $i < $fields; $i++) {
		$type  = mysql_field_type($result, $i);
		$name  = mysql_field_name($result, $i);
		$len   = mysql_field_len($result, $i);
		$flags = mysql_field_flags($result, $i);

		echo '<tr><td><span class="table_prefix"></span><input name="field_' . $i . '" value="' . $name .'" class="line_item"></td>
		<td><select class="column_type" name="type_' . $i . '" style="display:block; width:auto">
		<option value=""></option>
		<option value="int(5)" '; if($type=="int"){echo ' selected="selected" ';} echo '>INT</option>
		<option value="tinyint(2)" ' . checkSelected($type,"tinyint") . '>TINYINT</option>
		<option value="smallint(5)" ' . checkSelected($type,"smallint") . '>SMALLINT</option>
		<option value="mediumint(7)" ' . checkSelected($type,"mediumint") . '>MEDIUMINT</option>
		<option value="int(10)" ' . checkSelected($type,"int") . '>INT</option>
		<option value="bigint(20)" ' . checkSelected($type,"bigint") . '>BIGINT</option>
		<option value="decimal(5,2)" ' . checkSelected($type,"decimal") . '>DECIMAL</option>
		<option value="float(5,2)" ' . checkSelected($type,"float") . '>FLOAT</option>
		<option value="double(5,2)" ' . checkSelected($type,"double") . '>DOUBLE</option>
		<option value="real" ' . checkSelected($type,"real") . '>REAL</option>
		<option value="bit" ' . checkSelected($type,"bit") . '>BIT</option>
		<option value="boolean" ' . checkSelected($type,"boolean") . '>BOOLEAN</option>
		<option value="serial" ' . checkSelected($type,"serial") . '>SERIAL</option>
		</optgroup><optgroup label="DATE and TIME">
		<option value="date" ' . checkSelected($type,"date") . '>DATE</option>
		<option value="datetime" ' . checkSelected($type,"datetime") . '>DATETIME</option>
		<option value="timestamp" ' . checkSelected($type,"timestamp") . '>TIMESTAMP</option>
		<option value="time" ' . checkSelected($type,"time") . '>TIME</option>
		<option value="year(4)" ' . checkSelected($type,"year") . '>YEAR</option>
		</optgroup><optgroup label="STRING">
		<option value="char(4)" ' . checkSelected($type,"char") . '>CHAR</option>
		<option value="varchar(200)" '; if($type=="string"){echo ' selected="selected" ';} echo '>VARCHAR</option>
		<option value="tinytext" ' . checkSelected($type,"tinytext") . '>TINYTEXT</option>
		<option value="text" ' . checkSelected($type,"text") . '>TEXT</option>
		<option value="mediumtext" ' . checkSelected($type,"mediumtext") . '>MEDIUMTEXT</option>
		<option value="longtext" ' . checkSelected($type,"longtext") . '>LONGTEXT</option>
		<option value="tinyblob" ' . checkSelected($type,"tinyblob") . '>TINYBLOB</option>
		<option value="mediumblob" ' . checkSelected($type,"mediumblob") . '>MEDIUMBLOB</option>
		<option value="blob" ' . checkSelected($type,"blob") . '>BLOB</option>
		<option value="longblob" ' . checkSelected($type,"longblob") . '>LONGBLOB</option>
		<option value="enum" ' . checkSelected($type,"enum") . '>ENUM</option>
		<option value="set" ' . checkSelected($type,"set") . '>SET</option>
		</optgroup>
		</select></td>
		<td>
			<input name="len_' . $i . '" value="' . $len . '" style="width: 50px;">
		</td>
		</tr>
		
		';
	}
	?>  
			  	
<?php }?>
</tbody>
			  </table>
            <div class="field buttons">
              <label class="main">&nbsp;</label>
				<button type="button" onClick="add_another_input();">Add another field</button>
				<!--<button type="button" onClick="remove_input();">Remove last field</button>-->
				<button type="button" name="Reset_SQL" value="1" onClick="resetSql()">Reset Form</button>			
				<br>
            </div>
            <div class="field buttons">
              <label class="main">&nbsp;</label>
              	<button type="button" name="Update_SQL_To_DB" value="1" onClick="sqlUpdate()" style="background: rgb(194, 194, 221);">&raquo; Update Database Table</button>
              	<button type="button" name="Create_SQL" value="1" onClick="sqlCreate()" style="background: rgb(194, 194, 221);">&raquo; Create SQL </button>				
				<br>
            </div>
</div>