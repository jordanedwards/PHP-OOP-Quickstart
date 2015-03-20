<?php 
 include($_SERVER['DOCUMENT_ROOT'] . "/weteachsports.ca/includes/init.php"); 
 include($class_folder . "/class_user.php"); 
 include($class_folder . "/class_sessions.php");
 ?>
	
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Orchard City Web Development">
    <link rel="icon" href="favicon.ico">
	<base href="http://<?php  echo $_SERVER['HTTP_HOST']; ?>/weteachsports.ca/"/>
	
    <title><?php  echo $appConfig["app_title"];  ?> | Sessions List</title>

    <!-- Bootstrap core CSS -->   
	
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
	
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

<?php  require("includes/navbar.php");  ?>

<div class="main">
  <div class="container">
  
    <div class="row">
        <div class="col-md-12">
        <?php  include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php");  ?>
        <h1>Sessions List</h1>
		</div>
	</div>
	
	<br>	
      <div class="row">
        <div class="col-md-12">
		 <p><span id="search_toggle" title="Search/Filter Results"><img src="images/icon_search.png" alt="search" /> Search/Filter</span> <img src="images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="images/add.png" alt="add" /> <a href="sessions_edit.php?id=0">Add New Sessions</a></p>
<?php 

$dm = new DataManager();

			$s_id = mysql_real_escape_string($_REQUEST["s_id"]);
			$s_title = mysql_real_escape_string($_REQUEST["s_title"]);
			$s_start_date = mysql_real_escape_string($_REQUEST["s_start_date"]);
			$s_end_date = mysql_real_escape_string($_REQUEST["s_end_date"]);
			$s_location = mysql_real_escape_string($_REQUEST["s_location"]);
			$s_active = mysql_real_escape_string($_REQUEST["s_active"]);
			$s_sort = mysql_real_escape_string($_POST['sort']);
			$s_sort_dir = mysql_real_escape_string($_POST['sort_dir']);
 ?>
        <div id="search">
          <form action="<?php  echo $_SERVER["PHP_SELF"]  ?>?reload=true" method="post" name="frmFilter" id="frmFilter">
            <table class="admin_table" style="display:block">
              <tr>
			  <td>Sessions Id</td><td>Sessions Title</td><td>Sessions Start_date</td><td>Sessions End_date</td><td>Sessions Location</td><td>Sessions Active</td>				<td><input type="button" class="clear" value="Clear" /></td>
              </tr>
			  
              <tr>
			  <td><input type="text" name="s_id"  value="<?php  echo $_POST["s_id"]  ?>"/></td>
				<td><input type="text" name="s_title"  value="<?php  echo $_POST["s_title"]  ?>"/></td>
				<td><input type="text" name="s_start_date"  value="<?php  echo $_POST["s_start_date"]  ?>"/></td>
				<td><input type="text" name="s_end_date"  value="<?php  echo $_POST["s_end_date"]  ?>"/></td>
				<td><input type="text" name="s_location"  value="<?php  echo $_POST["s_location"]  ?>"/></td>
				<td><input type="text" name="s_active"  value="<?php  echo $_POST["s_active"]  ?>"/></td>
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
								$query_where = ' AND sessions_id = "'.$s_id.'"';
						} 
						if($s_title != ""){
								$query_where = ' AND sessions_title = "'.$s_title.'"';
						} 
						if($s_start_date != ""){
								$query_where = ' AND sessions_start_date = "'.$s_start_date.'"';
						} 
						if($s_end_date != ""){
								$query_where = ' AND sessions_end_date = "'.$s_end_date.'"';
						} 
						if($s_location != ""){
								$query_where = ' AND sessions_location = "'.$s_location.'"';
						} 
						if($s_active != ""){
								$query_where = ' AND sessions_active = "'.$s_active.'"';
						}		

						$query = "SELECT * from sessions WHERE 1=1" . $query_where;
							
							
						if ($s_sort != ""){
           					$order = " ORDER BY " . $s_sort . " " . $s_sort_dir;		
						} else {
							$order = " ORDER BY sessions_id DESC";
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
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/sessions_list_template.htm');
					echo $pager->displayRecords(mysql_escape_string($page));
					//echo $query;
			 ?>
        </div>

    </div> 
  </div><!-- /container -->
</div>


<?php  include("includes/footer.php");  ?>

	
<script src="./js/libs/jquery-1.9.1.min.js"></script>
<script src="./js/libs/jquery-ui-1.10.0.custom.min.js"></script>
<script src="./js/libs/bootstrap.min.js"></script>

<script src="./js/Application.js"></script>

<script type="text/javascript" src="/js/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery-ui-custom.js"></script>
    
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