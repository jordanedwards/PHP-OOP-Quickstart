<?php 
 include($_SERVER['DOCUMENT_ROOT'] . "/invoices/includes/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_documents.php");
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
	
    <title><?php  echo $appConfig["app_title"];  ?> | Documents List</title>

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
	<br>	
      <div class="row">
        <div class="col-md-12">
		 <p><span id="search_toggle" title="Search/Filter Results"><img src="images/icon_search.png" alt="search" /> Search/Filter</span> <img src="images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="images/add.png" alt="add" /> <a href="documents_edit.php?id=0">Add New Documents</a></p>
<?php 

$dm = new DataManager();

			$s_id = mysql_real_escape_string($_REQUEST["s_id"]);
			$s_customer_id = mysql_real_escape_string($_REQUEST["s_customer_id"]);
			$s_name = mysql_real_escape_string($_REQUEST["s_name"]);
			$s_date_created = mysql_real_escape_string($_REQUEST["s_date_created"]);
			$s_last_updated = mysql_real_escape_string($_REQUEST["s_last_updated"]);
			$s_last_updated_user = mysql_real_escape_string($_REQUEST["s_last_updated_user"]);
			$s_sort = mysql_real_escape_string($_POST['sort']);
			$s_sort_dir = mysql_real_escape_string($_POST['sort_dir']);
 ?>
        <div id="search">
          <form action="<?php  echo $_SERVER["PHP_SELF"]  ?>?reload=true" method="post" name="frmFilter" id="frmFilter">
            <table class="admin_table" style="display:block">
              <tr>
			  <td>Documents Id</td><td>Documents Customer_id</td><td>Documents Name</td><td>Documents Date_created</td><td>Documents Last_updated</td><td>Documents Last_updated_user</td>				<td><input type="button" class="clear" value="Clear" /></td>
              </tr>
              <tr>
                <td valign="top">
                	<select name="s_products_id">
                  	<option value=""></option>
                  </select>
                </td>
                <td valign="top"><input type="text" name="s_price"  value="<?php echo $_POST['s_price']?>"/></td>			  

				<input type="hidden" id="sort" name="sort" value="<?php echo $_POST['sort']?>" />
				<input type="hidden" id="sort_dir" name="sort_dir" value="<?php echo $_POST['sort_dir']?>" />
								
                <td valign="top"><input type="submit" class="submit" value="Search" /></td>
              </tr>
            </table>
          </form>
        </div>
<?php 
					
					$query = $session->getQuery($_SERVER["PHP_SELF"]);
					$reload = (isset($_GET['reload']) && $_GET['reload'] == "true" && isset($_GET['page']) == false ? $_GET['reload'] : "");
					
					if ($query == "" || $reload == "true") {
					// Page set to reload (new query)		
							 
						if($s_id != ""){
								$query_where = ' AND documents_id = "'.$s_id.'"';
						} 
						if($s_customer_id != ""){
								$query_where = ' AND documents_customer_id = "'.$s_customer_id.'"';
						} 
						if($s_name != ""){
								$query_where = ' AND documents_name = "'.$s_name.'"';
						} 
						if($s_date_created != ""){
								$query_where = ' AND documents_date_created = "'.$s_date_created.'"';
						} 
						if($s_last_updated != ""){
								$query_where = ' AND documents_last_updated = "'.$s_last_updated.'"';
						} 
						if($s_last_updated_user != ""){
								$query_where = ' AND documents_last_updated_user = "'.$s_last_updated_user.'"';
						}		

						$query = "SELECT * from documents WHERE 1=1" . $query_where;
							
							
						if ($s_sort != ""){
           					$order = " ORDER BY " . $s_sort . " " . $s_sort_dir;		
						} else {
							$order = " ORDER BY documents_id DESC";
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
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/documents_list_template.htm');
					echo $pager->displayRecords(mysql_escape_string($page));
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
});

$(".clear").bind("click", function() {
  $("input[type=text], input[type=number], textarea, select").val("");
  $('#frmFilter').submit();  
});

  </script>
  </body>
</html>