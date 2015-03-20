<?php 
 include($_SERVER['DOCUMENT_ROOT'] . "/site/includes/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_orders.php");
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
	<base href="http://<?php  echo $_SERVER['HTTP_HOST']; ?>/site/"/>
	
    <title><?php  echo $appConfig["app_title"];  ?> | Orders List</title>

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
        <h1>Orders List</h1>
		</div>
	</div>
  
      <div class="row">
        <div class="col-md-12">
		 <p><span id="search_toggle" title="Search/Filter Results"><img src="images/icon_search.png" alt="search" /> Search/Filter</span> <img src="images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="images/add.png" alt="add" /> <a href="orders_edit.php?id=0">Add New Orders</a></p>
<?php 

$dm = new DataManager();

			$s_id = mysqli_real_escape_string($dm->connection, $_REQUEST["s_id"]);
			$s_customer_id = mysqli_real_escape_string($dm->connection, $_REQUEST["s_customer_id"]);
			$s_production_status = mysqli_real_escape_string($dm->connection, $_REQUEST["s_production_status"]);
			$s_promised_date = mysqli_real_escape_string($dm->connection, $_REQUEST["s_promised_date"]);
			$s_last_updated_user = mysqli_real_escape_string($dm->connection, $_REQUEST["s_last_updated_user"]);
			$s_sort = mysqli_real_escape_string($dm->connection, $_POST['sort']);
			$s_sort_dir = mysqli_real_escape_string($dm->connection, $_POST['sort_dir']);
		
			if ($s_sort == ""){
				// if no sort is set, pick a default
				$s_sort = "orders_id";
				$s_sort_dir = "desc";	
			}

		$order = " ORDER BY " . $s_sort . " " . $s_sort_dir;		
					
 ?>
        <div id="search">
          <form action="<?php  echo $_SERVER["PHP_SELF"]  ?>?reload=true" method="post" name="frmFilter" id="frmFilter">
            <table class="admin_table" style="display:block">
              <tr>
			  <td>Orders Id</td><td>Orders Customer_id</td><td>Orders Production_status</td><td>Orders Promised_date</td><td>Orders Last_updated_user</td>				<td><input type="button" class="clear" value="Clear" /></td>
              </tr>
			  
 				<tr>
			  <td><input type="text" name="s_id"  value="<?php  echo $_POST["s_id"]  ?>"/></td>
				<td><input type="text" name="s_customer_id"  value="<?php  echo $_POST["s_customer_id"]  ?>"/></td>
				<td><input type="text" name="s_production_status"  value="<?php  echo $_POST["s_production_status"]  ?>"/></td>
				<td><input type="text" name="s_promised_date"  value="<?php  echo $_POST["s_promised_date"]  ?>"/></td>
				<td><input type="text" name="s_last_updated_user"  value="<?php  echo $_POST["s_last_updated_user"]  ?>"/></td>
					  

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
								$query_where .= ' AND orders_id = "'.$s_id.'"';
						} 
						if($s_customer_id != ""){
								$query_where .= ' AND orders_customer_id = "'.$s_customer_id.'"';
						} 
						if($s_production_status != ""){
								$query_where .= ' AND orders_production_status = "'.$s_production_status.'"';
						} 
						if($s_promised_date != ""){
								$query_where .= ' AND orders_promised_date = "'.$s_promised_date.'"';
						} 
						if($s_last_updated_user != ""){
								$query_where .= ' AND orders_last_updated_user = "'.$s_last_updated_user.'"';
						}		

						$query = "SELECT * from orders WHERE 1=1" . $query_where .$order;
						
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
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/orders_list_template.htm');
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