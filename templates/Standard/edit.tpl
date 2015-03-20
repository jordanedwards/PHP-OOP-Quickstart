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
	$<?php echo $this->selected_table ?>->get_by_id($<?php echo $this->selected_table ?>_id);
			
</dynamic>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><dynamic>  echo $appConfig["app_title"]; </dynamic> | <?php echo ucfirst($selected_table) ?> Edit</title>
	<link rel="stylesheet" type="text/css" href="/css/admin.css" />
	<link rel="stylesheet" type="text/css" href="/css/redmond/jquery-ui-1.8.9.custom.css" />
	<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />  
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-custom.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var container = $("div.errorContainer");
			// validate the form when it is submitted
			var validator = $("#form_<?php echo $selected_table ?>").validate({
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
</head>
<body>
	<div id="page_wrapper">
    <dynamic> include($includes_folder . "/admin_header.php"); </dynamic>
    <div id="right_column">
    	<div id="content_wrapper">
        <dynamic> include($includes_folder . "/system_messaging.php"); </dynamic>

        <h1><img src="/images/icon_maintenance.png" /> Add/Edit <?php echo ucfirst($selected_table) ?></h1>
        <p><span class="red">*</span> The red asterisk indicates all mandatory fields.</p>
        <div class="errorContainer">
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
        </div>

	<form id="form_<?php echo $this->selected_table ?>" action="<dynamic> echo $actions_href . "/action_";</dynamic><?php echo $this->selected_table ?>_edit.php" method="post">
	<input type="hidden" name="<?php echo $this->selected_table ?>_id" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_id(); </dynamic>" />

         <table class="admin_table">
<?php
foreach($this->field_names as $key => $val):
$required_text = "";
$required = false;

if ($this->required_field_names[$key] == 1){
	$required_text = ' class="{validate:{required:true}}" ';
	$required = true;
}

?>
				<tr>
           			<td class="label"><?php echo ucfirst(str_replace("_"," ",$val))?>: </td>
<?php
if ($this->field_types[$key] == "dropdown_dynamic" ):
// populate dropdowns
?>				
					<td class="field"><select id="<?php echo $key?>" name="<?php echo $key?>" <?php echo $required_text ?>>
							<option value="">None</option>
							<dynamic> $query="SELECT * FROM xxxxxx ORDER BY `xxxxxx_id`";
								$dm = new DataManager();
								$result = $dm->queryRecords($query);
								while ($row = mysqli_fetch_array($result))
								{
									if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == $row['xxxxxx_id']){
										echo "<option value='" . $row['xxxxxxx_id'] . "' selected>" . $row['xxxxxx_name'];
									} else {
										echo "<option value='" . $row['xxxxxxx_id'] . "'>" . $row['xxxxxxx_name'];
									}
								}
								</dynamic>
						</select>
					<?php if($required){ echo "<span class='red'> *</span> ";}?></td>
<?php
elseif ($this->field_types[$key] == "dropdown_static"):
?>

					<td class="field"><select id="<?php echo $key?>" name="<?php echo $key?>" <?php echo $required_text ?>>
							<option value=""></option>
							<option value="Y" <dynamic> if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == "Y"){ echo " selected='selected' ";} </dynamic>>Y</option>
							<option value="N" <dynamic> if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == "N"){ echo " selected='selected' ";} </dynamic>>N</option>						
						</select>
					<?php if($required){ echo "<span class='red'> *</span> ";}?></td>
<?php
elseif ($this->field_types[$key] == "tel"):
?>
					<td class="field"><input id="<?php echo $key?>" name="<?php echo $key?>" type="tel" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>"  style="width:90%" <?php echo $required_text ?>/><?php if($required){ echo "<span class='red'> *</span> ";}?></td>
<script type="text/javascript">
$(document).ready(function() {
	$("#<?php echo $key?>").mask("(999) 999-9999"); 
});	
</script>	
<?php
else:
?>
            		<td class="field"><input id="<?php echo $key?>" name="<?php echo $key?>" type="<?php echo $this->field_types[$key] ?>" <?php if ($this->field_types[$key] == "number"){echo 'step="any"';} ?> value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>" style="width:90%" <?php echo $required_text ?>/> <?php if($required){ echo "<span class='red'>*</span> ";}?></td>
<?php
endif;
?>				</tr>
<?php
endforeach;
?>
  		
		</table>
          <br />
          <input type="submit" value="Add/Update <?php echo ucfirst($this->selected_table) ?>" />&nbsp;&nbsp;
          <input type="button" value="Cancel" onClick="window.location ='<dynamic> echo $_SERVER["HTTP_REFERER"];</dynamic>'" />
        </form>
		
        <dynamic> if($<?php echo $selected_table ?>->get_id() > 0){ </dynamic>
          <p><em>Last updated: <dynamic> echo $<?php echo $this->selected_table ?>->get_last_updated(); </dynamic> by <dynamic> echo $<?php echo $this->selected_table ?>->get_last_updated_user(); </dynamic></em></p>
        <dynamic> } </dynamic>		
		
      </div>
    </div>
    <dynamic> include($includes_folder . "/left_admin_column.php"); ?>
  </div>
  <dynamic> include($includes_folder . "/admin_footer.php"); ?>
</body>
</html>