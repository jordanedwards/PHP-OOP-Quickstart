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


?>
<form action="actions/action_list_creator.php" id="fieldsForm" method="get">
<table class="table">
<input name="selected_table" value="<?php echo $_GET['table']; ?>" type="hidden">
<input name="environment" value="<?php echo $_GET['environment']; ?>"  type="hidden"/>
<input name="project_name" value="<?php echo $_GET['project']; ?>"  type="hidden"/>
<input name="template" value="<?php echo $_GET['template']; ?>"  type="hidden"/>

		<?php 
			$sql = "SELECT * from " . $_GET['table'];
		
			$result = mysql_query($sql);
			$fields = mysql_num_fields($result);
			
		for ($i=0; $i < $fields; $i++) {
			$type  = mysql_field_type($result, $i);
			$name  = mysql_field_name($result, $i);
			$flags = mysql_field_flags($result, $i);
			
			echo "<tr>";
			
			// Don't check the fields that are automatically set in the class. Probably no need to edit these:
			if (strpos($name,"date_created",0) || strpos($name,"last_updated")){
				$checked = "";			
			} else {
				$checked = " checked='checked' ";
			}
			
			$readonly = "";
			// Force the index to be selected, we need it on the page template
			if (strpos($flags," primary_key ",0) || strpos($flags," unique_key ")){
				echo "<td><input type='hidden' id='" . $name . "' value='" . $name . "' name='fields[" . $name . "]' readonly='true' /><p>$name (used as the edit column)</p></td>";
			} else {	
				echo "<td><input type='checkbox' id='" . $name . "' value='" . $name . "' name='fields[" . $name . "]' class='formCheckbox' " . $checked . "/>&nbsp; $name</td>";
			}
			?><td>
									
			</td>
			<?php
			echo "</tr>";
		}
		?>
		<tr><td>
			<a href="#" id="checkall">&raquo; Check all</a>
		</td></tr>
		</table>
					
	
<button type="submit" value="Submit">Submit</button>
</form>
	
<?php } ?>
<script>
$("#checkall").on("click", function (e) {
	e.preventDefault();
            $('.formCheckbox').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
});	
</script>