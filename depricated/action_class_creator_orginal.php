<?php
/* $_SERVER['DOCUMENT_ROOT'] */
$selected_table = $_GET['selected_table'];

include("../includes/init.php");
require_once('../classes/class_data_manager.php');

function right($str, $length) {
     return substr($str, -$length);
}
function trim_from_marker($str, $marker) {
	$marker_location = strpos($str,$marker,0);
	return substr($str,$marker_location+1, strlen($str));
}

$dm = new DataManager();

	$sql = "Show columns from " . $selected_table;
	$result = $dm->queryRecords($sql);
	
	$num_rows = mysql_num_rows($result);

	while ($row = mysql_fetch_row($result)) {
		$field_names[]= trim_from_marker($row[0],"_");
	}
	
//foreach($field_names as $key => $val){
//echo $key . " => " . trim_from_marker($val,"_") . "<br>";
//}

  header('Content-disposition: attachment; filename=class_'.$selected_table.'.php');
  header ("Content-Type:text/php");  
  print("<?php");
 ?>
 
 class <?php echo  
 
 ucfirst($selected_table) ?> {
 
 <?php	
foreach($field_names as $key => $val){

 echo 'private $'. $val . ';
 ';
 }
?>

	function __construct() {
	
	}
<?php 
foreach($field_names as $key => $val){

 echo '		public function get_'. $val . '() { return $this->' . $val .';}
 ';
 echo '		public function set_'. $val . '($value) {$this->' . $val .'=$value;}
 '; 
 echo '
 ';
}
?>

public function save() {

		try{
			require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();

			// if record does not already exist, create a new one
			if($this->get_id() == 0) {
			
				$strSQL = "INSERT INTO <?php echo $selected_table ?> (<?php 
				mysql_data_seek($result, 0);
				while ($row = mysql_fetch_row($result)) {
					++$row_num;
					if ($row_num < $num_rows){
						 echo $row[0] .', ' ;
					} else {
						 echo $row[0];
					}
					
				} 
				$row_num = 0;
				?>) 
        VALUES (
							<?php 
				foreach($field_names as $key => $val){
					++$row_num;
					if ($row_num < $num_rows){
						$field_suffix = right($val,12);
						if ($field_suffix == "date_created" || $field_suffix == "last_updated"){
							echo "NOW(),
							";
						} else {
						echo '\'".mysql_real_escape_string($this->get_' . $val .'())."\',
							';
						 }
					 } else {
						if ($field_suffix == "date_created" || $field_suffix == "last_updated"){
						?>'".mysql_real_escape_string($this->get_last_updated_user())."')";	
						<?php
						} else {						 
						 echo '\'".mysql_real_escape_string($this->get_' . $val .'())."\')";
						 ';	
						 }				 
					}
				} 
				 $row_num = 0;

				?>}
			else {
				$strSQL = "UPDATE <?php echo $selected_table ?> SET 
							<?php 
				foreach($field_names as $key => $val){

					++$row_num;
					$field_suffix = right($val,12);					
					if ($row_num < $num_rows){
						if ($field_suffix == "date_created" || $field_suffix == "id"){} 
						elseif ($field_suffix == "last_updated"){
							echo $selected_table . "_" . $val .'=NOW(),
						 	';
						}else {
						 	echo $selected_table . "_" . $val .'=\'".mysql_real_escape_string($this->get_' . $val . '())."\',
						 	';
						}
					 } else {
						if ($field_suffix == "date_created" || $field_suffix == "id" ){echo ')."\'
						 	';} 
						elseif ($field_suffix == "last_updated"){
							echo $selected_table . "_" . $val .'=NOW())
						 	';}
						 else {
						 	echo $selected_table . "_" .$val .'=\'".mysql_real_escape_string($this->get_' . $val . '())."\'
						 	';
						}				 
					}
				} 
 				$row_num = 0;				
				?>WHERE <?php echo $selected_table ?>_id=".mysql_real_escape_string($this->get_id());

				}		
				
				
			$result = $dm->updateRecords($strSQL);

			// if this is a new record get the record id from the database
			if(!$this->get_id() >= "0") {
				$this->set_id(mysql_insert_id());
			}
      
      
			// fetch data from the db to update date fields      
      $this->get_by_id($this->get_id());
      
			return $result;

		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}

	}

	// function to delete the record
	public function delete_by_id($id) {
		try{
			require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();

			$strSQL = "DELETE FROM <?php echo $selected_table ?> WHERE <?php echo $selected_table ?>_id=" . $id;
			$result = $dm->updateRecords($strSQL);
			return $result;
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}

	// function that fill the operator object with operator information
	public function get_by_id($id) {
		try{
			require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$status = false;
			$dm = new DataManager();
			$strSQL = "SELECT * FROM <?php echo $selected_table ?> WHERE <?php echo $selected_table ?>_id=" . $id;
      
			$result = $dm->queryRecords($strSQL);
			$num_rows = mysql_num_rows($result);

			if ($num_rows != 0){
				$row = mysql_fetch_assoc($result);
        $this->load($row);
				$status = true;
			}

			return $status;
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}
  
	// loads the object data from a mysql assoc array
  private function load($row){
  
  			<?php 
			foreach($field_names as $key => $val){

			echo '$this->set_' . $val .'($row["' . $selected_table . "_" .$val .'"]);
			';
		} 
	?>
  }
}