<?php
error_reporting(0);
ini_set('display_errors', '0');
extract($_GET);

require_once('../classes/class_data_manager.php');
$dm = new DataManager($db_host,$db_user,$db_pass,$db_name);

$selected_table = $_GET['selected_table'];

	$sql = "Show columns from " . $selected_table;
	$result = $dm->queryRecords($sql);
	
	$num_rows = mysql_num_rows($result);
	
	function trim_from_marker($str, $marker) {
		$marker_location = strpos($str,$marker,0);
		return substr($str,$marker_location+1, strlen($str));
	}

	while ($row = mysql_fetch_row($result)) {
		$field_names[$row[0]]= trim_from_marker($row[0],"_");
	}


  header('Content-disposition: attachment; filename='.$selected_table.'_edit.php');
  header ("Content-Type:text/php");  
  print("<?php");
?> // include necessary libraries
	include($_SERVER['DOCUMENT_ROOT'] . "/includes/init.php");
	//include($_SERVER['DOCUMENT_ROOT'] . "/includes/init_admins.php");	
	include($class_folder . "/class_<?php echo $selected_table ?>.php");
	
		// make sure we have a valid id, if not return them to the dashboard with an error message
	if(!isset($_GET["id"])) {
		$session->setAlertMessage("Could not edit the target <?php echo $selected_table ?> - invalid ID. Please try again.");
		$session->setAlertColor("yellow");
		header("location:/index.php");
		exit;
	}
		// load the <?php echo $selected_table ?>
		
		$<?php echo $selected_table ?>_id = $_GET["id"];
		$<?php echo $selected_table ?> = new <?php echo ucfirst($selected_table) ?>();
		$<?php echo $selected_table ?>->get_by_id($<?php echo $selected_table ?>_id);
		?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Add/Edit <?php echo ucfirst($selected_table) ?> - <?php print("<?php");?> echo $appConfig["app_title"]; ?></title>
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
    <?php print("<?php"); ?> include($includes_folder . "/admin_header.php"); ?>
    <div id="right_column">
    	<div id="content_wrapper">
        <?php print("<?php"); ?> include($includes_folder . "/system_messaging.php"); ?>

        <h1><img src="/images/icon_maintenance.png" /> Add/Edit <?php echo ucfirst($selected_table) ?></h1>
        <p><span class="red">*</span> The red asterisk indicates all mandatory fields.</p>
        <div class="errorContainer">
          <p><strong>There are errors in your form submission. Please read below for details.</strong></p>
          <ol>
		  <?php
foreach($field_names as $key => $val){
if ($val != "id" && $val != "date_created" && $val != "last_updated"  && $val != "last_updated_user"){
?>
            <li><label for="<?php echo $key?>" class="error">Please enter the <?php echo ucfirst($val)?></label></li>
<?php
}
}
?>
          </ol>
        </div>

	<form id="form_<?php echo $selected_table ?>" action="/actions/action_<?php echo $selected_table ?>_edit.php" method="post">
	<input type="hidden" name="<?php echo $selected_table ?>_id" value="<?php print("<?php"); ?> echo $<?php echo $selected_table ?>->get_id(); ?>" />

         <table class="editor">
		  <?php
foreach($field_names as $key => $val){
if ($val != "id" && $val != "date_created" && $val != "last_updated"  && $val != "last_updated_user"){
?>
				<tr>
           			<td class="label"><?php echo ucfirst(str_replace("_"," ",$val))?>: </td>
            		<td class="field"><input id="<?php echo $key?>" name="<?php echo $key?>" type="text" value="<?php print("<?php"); ?> echo $<?php echo $selected_table ?>->get_<?php echo $val?>(); ?>"  class="{validate:{required:true}}" size="50" maxlength="100" /> <span class="red">*</span></td>
         		</tr>
<?php
}
}
?>
  		</table>
          <br />
          <input type="submit" value="Add/Update <?php echo ucfirst($selected_table) ?>" />&nbsp;&nbsp;
          <input type="button" value="Cancel" onClick="window.location ='<?php print("<?php"); ?> echo $_SERVER["HTTP_REFERER"];?>'" />
        </form>
		
        <?php print("<?php"); ?> if($<?php echo $selected_table ?>->get_id() > 0){ ?>
          <p><em>Last updated: <?php print("<?php"); ?> $<?php echo $selected_table ?>->get_last_updated(); ?> By: <?php print("<?php"); ?> echo $<?php echo $selected_table ?>->get_last_updated_user(); ?></em></p>
        <?php print("<?php"); ?> } ?>		
		
      </div>
    </div>
    <?php print("<?php"); ?> include($includes_folder . "/left_admin_column.php"); ?>
  </div>
  <?php print("<?php"); ?> include($includes_folder . "/admin_footer.php"); ?>
</body>
</html>		