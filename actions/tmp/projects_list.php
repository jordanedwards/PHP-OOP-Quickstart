<?php 
 include($_SERVER['DOCUMENT_ROOT'] . "/invoices/includes/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_projects.php");
 ?>
	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
	<base href="http://<?php  echo $_SERVER['HTTP_HOST']; ?>/invoices/"/>
	
    <title><?php  echo $appConfig["app_title"];  ?> | Projects List</title>

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

<?php  include("nav_bar.php") ?>

  <div class="container">
  
  <div class="row">
        <div class="col-md-12">
        <?php  include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php");  ?>
        <h1>Projects List</h1>
		</div>
	</div>
  
      <div class="row">
        <div class="col-md-12">
		 <p><span id="search_toggle" title="Search/Filter Results"><img src="images/icon_search.png" alt="search" /> Search/Filter</span> <img src="images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="images/add.png" alt="add" /> <a href="projects_edit.php?id=0">Add New Projects</a></p>
<?php 

$dm = new DataManager();

			$s_id = mysqli_real_escape_string($dm->connection, $_REQUEST["s_id"]);
			$s_title = mysqli_real_escape_string($dm->connection, $_REQUEST["s_title"]);
			$s_status = mysqli_real_escape_string($dm->connection, $_REQUEST["s_status"]);
			$s_customer = mysqli_real_escape_string($dm->connection, $_REQUEST["s_customer"]);
			$s_progress = mysqli_real_escape_string($dm->connection, $_REQUEST["s_progress"]);
			$s_sort = mysql_real_escape_string($_POST['sort']);
			$s_sort_dir = mysqli_real_escape_string($dm->connection, $_POST['sort_dir']);
 ?>
        <div id="search">
          <form action="<?php  echo $_SERVER["PHP_SELF"]  ?>?reload=true" method="post" name="frmFilter" id="frmFilter">
            <table class="admin_table" style="display:block">
              <tr>
			  <td>Projects Id</td><td>Projects Title</td><td>Projects Status</td><td>Projects Customer</td><td>Projects Progress</td>				<td><input type="button" class="clear" value="Clear" /></td>
              </tr>
			  
 				<tr>
			  <td><input type="text" name="s_id"  value="<?php  echo $_POST["s_id"]  ?>"/></td>
				<td><input type="text" name="s_title"  value="<?php  echo $_POST["s_title"]  ?>"/></td>
				<td><input type="text" name="s_status"  value="<?php  echo $_POST["s_status"]  ?>"/></td>
				<td><input type="text" name="s_customer"  value="<?php  echo $_POST["s_customer"]  ?>"/></td>
				<td><input type="text" name="s_progress"  value="<?php  echo $_POST["s_progress"]  ?>"/></td>
					  

				<input type="hidden" id="sort" name="sort" value="<?php echo $_POST['sort']?>" />
				<input type="hidden" id="sort_dir" name="sort_dir" value="<?php echo $_POST['sort_dir']?>" />
								
                <td valign="top"><input type="submit" class="submit" value="Search" /></td>
              </tr>
            </table>
          </form>
        </div>
			<br>	
<?php 
					
					$query = $session->getQuery($_SERVER["PHP_SELF"]);
					$reload = (isset($_GET['reload']) && $_GET['reload'] == "true" && isset($_GET['page']) == false ? $_GET['reload'] : "");
					
					if ($query == "" || $reload == "true") {
					// Page set to reload (new query)		
							 
						if($s_id != ""){
								$query_where .= ' AND projects_id = "'.$s_id.'"';
						} 
						if($s_title != ""){
								$query_where .= ' AND projects_title = "'.$s_title.'"';
						} 
						if($s_status != ""){
								$query_where .= ' AND projects_status = "'.$s_status.'"';
						} 
						if($s_customer != ""){
								$query_where .= ' AND projects_customer = "'.$s_customer.'"';
						} 
						if($s_progress != ""){
								$query_where .= ' AND projects_progress = "'.$s_progress.'"';
						}		

						$query = "SELECT * from projects WHERE 1=1" . $query_where;
							
							
						if ($s_sort != ""){
           					$order = " ORDER BY " . $s_sort . " " . $s_sort_dir;		
						} else {
							$order = " ORDER BY projects_id DESC";
						}
						$query .= $order;
						
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
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/projects_list_template.htm');
					echo $pager->displayRecords(mysqli_escape_string($dm->connection, $page));
					//echo $query;
			 ?>
        </div>

    </div> 
</div><!-- /container -->

	<footer>
      <div class="container">
        <?php  include("includes/footer.php");  ?>
      </div>
    </footer>
	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>')
    
<?php  if ($session->getSort($_SERVER["PHP_SELF"]) != ""){
  // If there is a sort saved in session, print a jquery function to add class to the selected column
   ?>
<script>

$(function() {
	  $('#<?php  echo $session->getSort($_SERVER["PHP_SELF"]);  ?>').addClass('sort_<?php  echo $session->getSortDir($_SERVER["PHP_SELF"])  ?>');
	  /* Set the input field for sort direction so that it can be toggled*/
	  $('#sort_dir').val("<?php  echo $session->getSortDir($_SERVER['PHP_SELF'])  ?>")
  }); 
</script>

<?php  }  ?>
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
	<?php  if ($query_where != ""){
	echo "$('#search').toggle();";
	} ?>
	
});

$(".clear").bind("click", function() {
  $("input[type=text], input[type=number], textarea, select").val("");
  $('#frmFilter').submit();  
});

  </script>
  </body>
</html>