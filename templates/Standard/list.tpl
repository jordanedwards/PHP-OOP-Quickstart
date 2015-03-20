<dynamic> 
 include($_SERVER['DOCUMENT_ROOT'] . "/<?php  if($this->settings['base_url'] != '' ){ echo $this->settings['base_url'] . "/"; } else {}?><?php echo $this->settings['includes_url']?>/init.php"); 
 include($_SERVER['DOCUMENT_ROOT'] . "/classes/class_<?php echo $this->selected_table ?>.php"); </dynamic>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Manage <?php echo ucfirst($this->selected_table) ?> - <dynamic> echo $appConfig["app_title"]; </dynamic></title>
	<link href="/css/admin.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/js/jquery.js"></script>
  <script type="text/javascript" src="/js/jquery.metadata.js"></script>
	<script type="text/javascript" src="/js/jquery.validate.js"></script>
  <script type="text/javascript" src="/js/jquery-ui-custom.js"></script>
  <script type="text/javascript">  
 		$(document).ready(function() { 
			 $('#search_toggle').click(function() {
				$('#search').toggle('fast', function() {
				});
			});
		});
  </script>
</head>

<body>
  <div id="page_wrapper">
  	<dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/admin_header.php"); </dynamic>
    <div id="right_column">
    	<div id="content_wrapper">
      	<dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/system_messaging.php"); </dynamic>
        <h1><img src="/images/icon_maintenance.png" /> Manage <?php echo ucfirst($this->selected_table) ?></h1>
        <p><span id="search_toggle" title="Search/Filter Results"><img src="/images/icon_search.png" alt="search" /> Search/Filter</span> <img src="/images/arrow_down.png" alt="" align="bottom" /> | 
        <img src="/images/add.png" alt="add" /> <a href="/customer_edit.php?id=0">Add New Customer</a></p>

<dynamic>
		
$dm = new DataManager();

			<?php
foreach($this->field_names as $key => $val){
echo '$s_' . $val . ' = mysqli_real_escape_string($dm->connection, $_POST["s_' . $val. '"]);
			';
}	

?>
$s_sort = mysql_real_escape_string($_POST['sort']);
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

				<input type="hidden" id="sort" name="sort" value="<?php print("<?php"); ?> echo $_POST['sort']?>" />
				<input type="hidden" id="sort_dir" name="sort_dir" value="<?php print("<?php"); ?> echo $_POST['sort_dir']?>" />
								
                <td valign="top"><input type="submit" class="submit" value="Search" /></td>
              </tr>
            </table>
          </form>
        </div>
        
        <dynamic>
		
					$query = $session->getQuery($_SERVER["PHP_SELF"]);
					$reload = (isset($_GET['reload']) && $_GET['reload'] == "true" && isset($_GET['page']) == false ? $_GET['reload'] : "");
					
					if ($query == "" || $reload == "true") {
					// Page set to reload (new query)		
							<?php
foreach($this->field_names as $key => $val){
				echo ' 
						if($s_' . $val . ' != ""){
								$query_where .= \' AND ' . $this->selected_table . '_' . $val . ' = "\'.$s_' . $this->selected_table . "_" . $val . ".'\"';
						}";
}
?>		

						$query = "SELECT * from <?php echo $this->selected_table ?> WHERE 1=1" . $query_where .$order;
						
						//Handle the sorting of the records
						$session->setQuery($_SERVER["PHP_SELF"],$query);
					}else{
						//The page is not reloaded so use the query from the session
						$query = $session->getQuery($_SERVER["PHP_SELF"]);
						
		
						//See if we just need to resort that column
						
						$sort = " ORDER BY ".$sortvar." ".$sortdir;
		
						//Set the sort options in the session for the next page
						$session->setSort($_SERVER["PHP_SELF"], $sortvar);
						$session->setSortDir($_SERVER["PHP_SELF"], $sortdir);
					}

					if(isset($_GET['page'])){$page = $_GET['page'];}else{$page = 1;}
					$session->setPage($page);
					
					require_once($_SERVER['DOCUMENT_ROOT']."/classes/class_record_pager.php");
					// instantiate a new pager object
					$pager=new Pager($query,'paginglinks',20,0,1,'page_templates/<?php echo $this->selected_table ?>_list_template.htm');
					// display records and paging links
					echo $pager->displayRecords(mysqli_escape_string($dm->connection, $page));
					
				</dynamic>
        <br clear="all" />
      </div>
    </div>
    <dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/left_admin_column.php"); </dynamic>
	</div>
  <dynamic> include($_SERVER['DOCUMENT_ROOT'] . "/includes/admin_footer.php"); </dynamic>
</body>
</html>