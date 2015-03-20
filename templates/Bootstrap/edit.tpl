<dynamic>
 include("<?php echo $this->settings['includes_url']?>/init.php"); 
 include(CLASS_FOLDER . "/class_<?php echo $this->selected_table ?>.php");
 
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title><dynamic>  echo $appConfig["app_title"]; </dynamic> | <?php echo ucfirst($this->selected_table) ?> Edit</title>

    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="./css/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <link href="./css/font-awesome.css" rel="stylesheet" type="text/css">        
    <link href="./css/styles.css" rel="stylesheet">

  </head>

  <body>

<dynamic> include(INCLUDES_FOLDER ."nav_bar.php")</dynamic>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <dynamic> include(INCLUDES_FOLDER . "system_messaging.php"); </dynamic>

        <h1>Add/Edit <?php echo ucfirst($this->selected_table) ?></h1>
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
		  <br>
        </div>

	<form id="form_<?php echo $this->selected_table ?>" action="<dynamic> echo ACTIONS_URL;</dynamic>action_<?php echo $this->selected_table ?>_edit.php" method="post">
	<input type="hidden" name="<?php echo $this->selected_table ?>_id" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_id(); </dynamic>" />

         <table class="admin_table">
<?php
foreach($this->field_names as $key => $val):
$required_text = "";
$required = false;


if ($this->required_field_names[$key] == 1){
	$required_text = ' class="required" ';
	$required = true;
}

?>
				<tr>
           			<td style="width:1px; white-space:nowrap;"><?php echo ucfirst(str_replace("_"," ",$val))?>: </td>
<?php
if ($this->field_types[$key] == "dropdown_dynamic" ):
// populate dropdowns
?>				
					<td><select id="<?php echo $key?>" name="<?php echo $key?>" <?php echo $required_text ?>>
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

					<td><select id="<?php echo $key?>" name="<?php echo $key?>" <?php echo $required_text ?>>
							<option value=""></option>
							<option value="Y" <dynamic> if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == "Y"){ echo " selected='selected' ";} </dynamic>>Y</option>
							<option value="N" <dynamic> if ($<?php echo $this->selected_table; ?>->get_<?php echo $val; ?>() == "N"){ echo " selected='selected' ";} </dynamic>>N</option>						
						</select>
					<?php if($required){ echo "<span class='red'> *</span> ";}?></td>
<?php
elseif ($this->field_types[$key] == "tel"):
?>
					<td><input id="<?php echo $key?>" name="<?php echo $key?>" type="tel" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>"  style="width:90%" <?php echo $required_text ?>/><?php if($required){ echo "<span class='red'> *</span> ";}?></td>
<script type="text/javascript">
$(document).ready(function() {
	$("#<?php echo $key?>").mask("(999) 999-9999"); 
});	
</script>	
<?php
else:
?>
            		<td><input id="<?php echo $key?>" name="<?php echo $key?>" type="<?php echo $this->field_types[$key] ?>" <?php if ($this->field_types[$key] == "number"){echo 'step="any"';} ?> value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>" style="width:90%" <?php echo $required_text ?>/> <?php if($required){ echo "<span class='red'>*</span> ";}?></td>
<?php
endif;
?>				</tr>
<?php
endforeach;
?>
  		
		</table>
          <br />
          <input type="submit" value="Add/Update <?php echo ucfirst($this->selected_table) ?>" />&nbsp;&nbsp;
          <input type="button" value="Cancel" onClick="window.location ='<?php print("<?php"); ?> echo $_SERVER["HTTP_REFERER"];?>'" />
        </form>
		<br>
		
        <dynamic> if($<?php echo $this->selected_table ?>->get_id() > 0){ </dynamic>
          <p><em>Last updated: <dynamic> echo $<?php echo $this->selected_table ?>->get_last_updated(); </dynamic> by <dynamic> echo $<?php echo $this->selected_table ?>->get_last_updated_user(); </dynamic></em></p>
        <dynamic> } </dynamic>			
	
      </div>
    </div> 

</div><!-- /container -->

	<footer>
      <div class="container">
        <dynamic> include(INCLUDES_FOLDER . "footer.php"); </dynamic>
      </div>
    </footer>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/js/jquery.js"></script>
	<script type="text/javascript" src="/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script>
	<script type="text/javascript" src="/js/jquery-ui-custom.js"></script>
	<script type="text/javascript" src="/js/jquery.mask.js"></script>
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">

// Validation:
$(document).ready(function() {
	var rules = {
		    	rules: {
					<?php
					foreach($this->required_field_validate as $key => $val){
						echo $key . ": {
						" . $val . "
					},";
					}
					?>
				
				}
		    };
		
	    var validationObj = $.extend (rules, Application.validationRules);
		$('#form_<?php echo $this->selected_table ?>').validate(validationObj);
});		
// Include any masks here:
		 //   $("#student_tel").mask("(999) 999-9999");		
  </script>		
  </body>
</html>