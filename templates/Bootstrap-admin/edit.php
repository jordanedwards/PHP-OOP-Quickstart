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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Orchard City Web Development">
    <link rel="icon" href="favicon.ico">
    <title><dynamic>  echo $appConfig["app_title"]; </dynamic> | <?php echo ucfirst($this->selected_table) ?> Edit</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">    
    
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/bootstrap-responsive.min.css" rel="stylesheet">
    
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="./css/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">        
    
    <link href="./css/ui-lightness/jquery-ui-1.10.0.custom.min.css" rel="stylesheet">
    
    <link href="./css/base-admin-3.css" rel="stylesheet">
    <link href="./css/base-admin-3-responsive.css" rel="stylesheet">
    
    <link href="./css/pages/dashboard.css" rel="stylesheet">   
    <link href="./css/custom.css" rel="stylesheet">
    <link href="./css/styles.css" rel="stylesheet">

  </head>

  <body>

<dynamic> require("includes/navbar.php"); </dynamic>
<div class="main">

    <div class="container">
      <div class="row">
        <div class="col-md-12">
        <dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php"); </dynamic>

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
		</div>
	</div>
	
	<div class="row">
	<div class="col-md-8">
	<form id="form_<?php echo $this->selected_table ?>" action="<dynamic> echo $actions_href . "/action_";</dynamic><?php echo $this->selected_table ?>_edit.php" method="post">
	<input type="hidden" name="<?php echo $this->selected_table ?>_id" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_id(); </dynamic>" />

         <table class="admin_table">
		  <?php
foreach($this->field_names as $key => $val){
?>
				<tr>
           			<td style="width:1px; white-space:nowrap;"><?php echo ucfirst(str_replace("_"," ",$val))?>: </td>
<?php
if ($this->field_types[$key] == "dropdown_dynamic" ){
// populate dropdowns
?>

					
					<td><select id="<?php echo $key?>" name="<?php echo $key?>">
							<option value="">None</option>
							<dynamic> $query="SELECT * FROM xxxxxx ORDER BY `xxxxxx_id`";
								$dm = new DataManager();
								$result = $dm->queryRecords($query);
								while ($row = mysql_fetch_array($result))
								{
									if ($<?php echo $this->selected_table ?>->get_<?php echo $val?>() == $row['xxxxxx_id']){
										echo "<option value='" . $row['xxxxxxx_id'] . "' selected>" . $row['xxxxxx_name'];
									} else {
										echo "<option value='" . $row['xxxxxxx_id'] . "'>" . $row['xxxxxxx_name'];
									}
								}
								?>
						</select>
					</td>				


<?php
} else {
?>
            		<td><input id="<?php echo $key?>" name="<?php echo $key?>" type="<?php echo $this->field_types[$key] ?>" value="<dynamic> echo $<?php echo $this->selected_table ?>->get_<?php echo $val?>(); </dynamic>"  class="{validate:{required:true}}" style="width:90%"/> <span class="red">*</span></td>
<?php
}
echo "</td>";
}
}
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
	
      </div>
    </div> 

</div><!-- /container -->
</div>

<dynamic> include("includes/footer.php"); </dynamic>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="./js/libs/jquery-1.9.1.min.js"></script>
<script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
<script src="./js/libs/bootstrap.min.js"></script>

<script src="./js/Application.js"></script>

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
  </body>
</html>