<dynamic>
 include($_SERVER['DOCUMENT_ROOT'] . "/<?php echo ($this->settings['base_url'] != '' ? $this->settings['base_url'] . "/" : "")?><?php echo $this->settings['includes_url']?>/init.php"); 
 include($class_folder . "/class_<?php echo $this->selected_table ?>.php");
 
	if(!isset($_GET["id"])) {
		$session->setAlertMessage("Can not edit - the ID is invalid. Please try again.");
		$session->setAlertColor("yellow");
		header("location:" . $base_href . "/index.php");
		exit;
	}

	// load the <?php echo $this->selected_table ?>		
	$<?php echo $this->selected_table ?>_id = $_GET["id"];
	$<?php echo $this->selected_table ?> = new <?php echo ucfirst($this->selected_table) ?>();
		
	if ($_GET["id"] ==0){
		// Change this to pass a parent value if creating a new record:
		//	$<?php echo $this->selected_table ?>->set_customer_id($_GET['customer_id']);
	} else {
		$<?php echo $this->selected_table ?>->get_by_id($<?php echo $this->selected_table ?>_id);
	}
			
</dynamic>
        <dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php"); </dynamic>

        <h1>Add/Edit <?php echo ucfirst($this->selected_table) ?></h1>
        <p><span class="red">*</span> The red asterisk indicates all mandatory fields.</p>
        <div class="errorContainer" style="display:none;">
          <p><strong>There are errors in your form submission. Please read below for details.</strong></p>
          <ol>
		  <?php
foreach($field_names as $key => $val){
?>
            <li><label for="<?php echo $key?>" class="error">Please enter the <?php echo ucfirst($val)?></label></li>
<?php
}
?>
          </ol>
		  <br>
        </div>

	<form id="form_<?php echo $this->selected_table ?>" action="<dynamic> echo $actions_href . "/action_";</dynamic><?php echo $this->selected_table ?>_edit.php" method="post">
	<input type="hidden" name="<?php echo $this->selected_table ?>_id" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_id(); </dynamic>" />

         <table>
<?php
foreach($this->field_names as $key => $val):
?>
				<tr>
           			<td style="width:1px; white-space:nowrap;"><?php echo ucfirst(str_replace("_"," ",$val))?>: </td>
<?php
if ($this->field_types[$key] == "dropdown_dynamic" ):
// populate dropdowns
?>

					
					<td><select id="<?php echo $key?>" name="<?php echo $key?>">
							<option value="">None</option>
							<dynamic> $query="SELECT * FROM xxxxxx ORDER BY `xxxxxx_id`";
								$dm = new DataManager();
								$result = $dm->queryRecords($query);
								while ($row = mysql_fetch_array($result))
								{
									if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == $row['xxxxxx_id']){
										echo "<option value='" . $row['xxxxxxx_id'] . "' selected>" . $row['xxxxxx_name'];
									} else {
										echo "<option value='" . $row['xxxxxxx_id'] . "'>" . $row['xxxxxxx_name'];
									}
								}
								</dynamic>
						</select>
					</td>				


<?php
else:
?>
            		<td><input id="<?php echo $key?>" name="<?php echo $key?>" type="<?php echo $this->field_types[$key] ?>" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>"  class="{validate:{required:true}}" style="width:90%"/> <span class="red">*</span></td>
<?php
endif;
echo "</td>";
endforeach;
?>
  		
		</table>
          <br />
          <input type="submit" value="Add/Update <?php echo ucfirst($this->selected_table) ?>" />&nbsp;&nbsp;
          <input type="button" value="Cancel" onClick="window.location ='<?php print("<?php"); ?> echo $_SERVER["HTTP_REFERER"];?>'" />
        </form>
		<br>
		
        <dynamic> if($<?php echo $this->selected_table ?>->get_id() > 0){ </dynamic>
          <p><em>Last updated: <dynamic> $<?php echo $this->selected_table ?>->get_last_updated(); </dynamic> By: <dynamic> echo $<?php echo $this->selected_table ?>->get_last_updated_user(); </dynamic></em></p>
        <dynamic> } </dynamic>		


	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-custom.js"></script>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
		$(document).ready(function() {
			var container = $("div.errorContainer");
			// validate the form when it is submitted
			var validator = $("#form_customers").validate({
				errorContainer: container,
				errorLabelContainer: $("ol", container),
				wrapper: "li",
				meta: "validate"
			});
	 	});

		$.validator.setDefaults({
			submitHandler: function() { form.submit();  }
		});
  </script>	