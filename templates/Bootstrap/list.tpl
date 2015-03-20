<dynamic>
 include($_SERVER['DOCUMENT_ROOT'] . "/<?php echo ($this->settings['base_url'] != '' ? $this->settings['base_url'] . "/" : "")?><?php echo $this->settings['includes_url']?>/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_<?php echo $this->selected_table ?>.php");
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
	<base href="http://<dynamic> echo $_SERVER['HTTP_HOST'];</dynamic>/<?php echo $this->settings['base_url'];?>/"/>
	
    <title><dynamic> echo $appConfig["app_title"]; </dynamic> | <?php echo ucfirst($this->selected_table) ?> List</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<dynamic> include("nav_bar.php")</dynamic>

  <div class="container">
  
  <div class="row">
        <div class="col-md-12">
        <dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php"); </dynamic>
        <h1><?php echo ucfirst($this->selected_table) ?> List</h1>
		</div>
	</div>
  
      <div class="row">
        <div class="col-md-12">
		 <p><span id="search_toggle" title="Search/Filter Results"><img src="images/icon_search.png" alt="search" /> Search/Filter</span> <img src="images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="images/add.png" alt="add" /> <a href="<?php echo $this->selected_table ?>_edit.php?id=0">Add New <?php echo ucfirst($this->selected_table) ?></a></p>
<dynamic>

$dm = new DataManager();

			<?php
foreach($this->field_names as $key => $val){
echo '$s_' . $val . ' = mysqli_real_escape_string($dm->connection, $_REQUEST["s_' . $val. '"]);
			';
}	

?>
$s_sort = mysqli_real_escape_string($dm->connection, $_POST['sort']);
			$s_sort_dir = mysqli_real_escape_string($dm->connection, $_POST['sort_dir']);
		
			if ($s_sort == ""){
				// if no sort is set, pick a default
				$s_sort = "<?php echo $this->index_name ?>";
				$s_sort_dir = "desc";	
			}

		$order = " ORDER BY " . $s_sort . " " . $s_sort_dir;		
					
</dynamic>
        <div id="search">
          <form action="<dynamic> echo $_SERVER["PHP_SELF"] </dynamic>?reload=true" method="post" name="frmFilter" id="frmFilter">
            <table class="admin_table" style="display:block">
              <tr>
			  <?php
foreach($this->field_names as $key => $val){
				echo "<td>" . ucfirst($this->selected_table) . " " . ucfirst($val) . "</td>";
}
?>
				<td><input type="button" class="clear" value="Clear" /></td>
              </tr>
			  
 				<tr>
			  <?php
foreach($this->field_names as $key => $val){
				echo '<td><input type="text" name="s_' . $val. '"  value="<dynamic> echo $_POST["s_' . $val. '"] </dynamic>"/></td>
				';
}
?>	  

				<input type="hidden" id="sort" name="sort" value="<?php print("<?php"); ?> echo $_POST['sort']?>" />
				<input type="hidden" id="sort_dir" name="sort_dir" value="<?php print("<?php"); ?> echo $_POST['sort_dir']?>" />
								
                <td valign="top"><input type="submit" class="submit" value="Search" /></td>
              </tr>
            </table>
          </form>
        </div>
			<br>	
<dynamic>
					
					$query = $session->getQuery($_SERVER["PHP_SELF"]);
					$reload = (isset($_GET['reload']) && $_GET['reload'] == "true" && isset($_GET['page']) == false ? $_GET['reload'] : "");
					
					if ($query == "" || $reload == "true") {
					// Page set to reload (new query)		
							<?php
foreach($this->field_names as $key => $val){
				echo ' 
						if($s_' . $val . ' != ""){
								$query_where .= \' AND ' . $this->selected_table . '_' . $val . ' = "\'.$s_' . $val . ".'\"';
						}";
}
?>		

						$query = "SELECT * from <?php echo $this->selected_table ?> WHERE 1=1" . $query_where .$order;
						
						//Handle the sorting of the records
						$session->setQuery($_SERVER["PHP_SELF"],$query);
						$session->setSort($_SERVER["PHP_SELF"],$s_sort);
						$session->setSortDir($_SERVER["PHP_SELF"],$s_sort_dir);
					}else{
						//The page is not reloaded so use the query from the session
						$query = $session->getQuery($_SERVER["PHP_SELF"]);
					}

					if(isset($_GET['page'])){$page = $_GET['page'];}else{$page = 1;}
					$session->setPage($page);
					
					require_once($class_folder ."/class_record_pager.php");
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/<?php echo $this->selected_table ?>_list_template.htm');
					echo $pager->displayRecords(mysqli_escape_string($dm->connection, $page));
					//echo $query;
			</dynamic>
        </div>

    </div> 
</div><!-- /container -->

	<footer>
      <div class="container">
        <dynamic> include("includes/footer.php"); </dynamic>
      </div>
    </footer>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>')
    
<dynamic> if ($session->getSort($_SERVER["PHP_SELF"]) != ""){
  // If there is a sort saved in session, print a jquery function to add class to the selected column
  </dynamic>
<script>

$(function() {
	  $('#<dynamic> echo $session->getSort($_SERVER["PHP_SELF"]); </dynamic>').addClass('sort_<dynamic> echo $session->getSortDir($_SERVER["PHP_SELF"]) </dynamic>');
	  /* Set the input field for sort direction so that it can be toggled*/
	  $('#sort_dir').val("<dynamic> echo $session->getSortDir($_SERVER['PHP_SELF']) </dynamic>")
  }); 
</script>

<dynamic> } </dynamic>
  <script> 
$('.sort_column').click(function(){
  // Field clicked; 
  // - Set sort & sort direction input values
  // - Submit form
  $('#sort').val($(this).attr('id'));
  
 if ($('#sort_dir').val() == "asc"){
 		$('#sort_dir').val("desc");
	} else {
		$('#sort_dir').val("asc");
	}
  $('#frmFilter').submit();
});
  
$(document).ready(function() { 
	$('#search_toggle').click(function() {
		$('#search').toggle();
	});
	<dynamic> if ($query_where != ""){
	echo "$('#search').toggle();";
	}</dynamic>
	
});

$(".clear").bind("click", function() {
  $("input[type=text], input[type=number], textarea, select").val("");
  $('#frmFilter').submit();  
});

  </script>
  </body>
</html>