<?php
error_reporting(0);
ini_set('display_errors', '0');
extract($_GET);

require_once('../classes/class_data_manager.php');
$dm = new DataManager($db_host,$db_user,$db_pass,$db_name);

function right($str, $length) {
     return substr($str, -$length);
}
function trim_from_marker($str, $marker) {
	$marker_location = strpos($str,$marker,0);
	return substr($str,$marker_location+1, strlen($str));
}

	// Build field array:
	
	$sql = "Show columns from " . $selected_table;
	$result = $dm->queryRecords($sql);
	
	$num_rows = mysql_num_rows($result);

	while ($row = mysql_fetch_row($result)) {
		if (strpos($row[0],"_",0) > 0){
			$field_names[$row[0]]= trim_from_marker($row[0],"_");
		} else {
			$field_names[$row[0]]= $row[0];
		}
	}
	
	// Get Primary Index:
	
	$sql = 'SHOW INDEXES FROM ' . $selected_table . ' WHERE Key_name = "PRIMARY"';
	$indexResult = $dm->queryRecords($sql);
	$num_rows_index = mysql_num_rows($indexResult);
	
	if ($num_rows_index > 0){
	while ($row = mysql_fetch_array($indexResult, MYSQL_ASSOC)) {
		$index_name = $row['Column_name'];
	
	}
	} else {
		$index_name	= $selected_table . "_id";
	}

	
//foreach($field_names as $key => $val){
//echo $key . " => " . trim_from_marker($val,"_") . "<br>";
//}

  header('Content-disposition: attachment; filename=class_'.$selected_table.'.php');
  header ("Content-Type:text/php");print("<?php");
 ?>
 
 class <?php echo  
 
 ucfirst($selected_table) ?> {
 
		<?php	
foreach($field_names as $key => $val){
	if ($key == $index_name) {
 		echo 'private $id;
		';
	} else {
 		echo 'private $'. $val . ';
 		';
 	}
 }
?>

	function __construct() {
	
	}
		<?php 
foreach($field_names as $key => $val){
	if ($key == $index_name) {
		echo '		public function get_id() { return $this->id;}
		 ';
 		echo '		public function set_id($value) {$this->id=$value;}
 
		 ';
	} else {
		echo '		public function get_'. $val . '() { return $this->' . $val .';}
		 ';
 		echo '		public function set_'. $val . '($value) {$this->' . $val .'=$value;}
 
		 ';
 	}
}
?>

public function __toString(){
		// Debugging tool
		// Dumps out the attributes and method names of this object
		// To implement:
		// $a = new SomeClass();
		// echo $a;
		
		// Get Class name:
		$class = get_class($this);
		
		// Get attributes:
		$attributes = get_object_vars($this);
		
		// Get methods:
		$methods = get_class_methods($this);
		
		$str = "<h2>Information about the $class object</h2>";
		$str .= '<h3>Attributes</h3><ul>';
		foreach ($attributes as $key => $value){
			$str .= "<li>$key: $value</li>";
		}
		$str .= "</ul>";
		
		$str .= "<h3>Methods</h3><ul>";
		foreach ($methods as $value){
			$str .= "<li>$value</li>";
		}
		$str .= "</ul>";
		
		return $str;
	}

public function clear(){
	 foreach ($this as $key => $value) {
		 $this->$key=NULL;
	}
}	
		
public function save() {

		try{
			//require_once($class_folder . '/class_data_manager.php');
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
					// not last row
						$field_suffix = right($val,12);
						if ($field_suffix == "date_created" || $field_suffix == "last_updated"){
							echo "NOW(),
							";
						} 						
						else {
							if ($key == $index_name){
								echo '\'".mysqli_real_escape_string($dm->connection, $this->get_id())."\',
								';
							} else {
								echo '\'".mysqli_real_escape_string($dm->connection, $this->get_' . $val .'())."\',
								';
							}
						 }
					 } else {
					 // last row
						if ($field_suffix == "date_created" || $field_suffix == "last_updated"){
						?>'".mysqli_real_escape_string($dm->connection, $this->get_last_updated_user())."')";	
						<?php
						} else {
							if ($key == $index_name){
							 echo '\'".mysqli_real_escape_string($dm->connection, $this->get_id())."\')";
							 ';								
							} else {					 
							 echo '\'".mysqli_real_escape_string($dm->connection, $this->get_' . $val .'())."\')";
							 ';	
						 	}
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
					// Not last row
						if ($field_suffix == "date_created" || $key == $index_name){/* Do not include these fields */} 
						else {
							if ($field_suffix == "last_updated"){
								echo $key .'=NOW(),						
						 		';
							} else {
						 		echo  $key .'=\'".mysqli_real_escape_string($dm->connection, $this->get_' . $val .'())."\',						 
						 		';
							}
						}

					 } else {
					 // Last row (need to put the bracket on the end, and no semicolon)
						if ($field_suffix == "date_created" || $key == $index_name ){echo ')."\'
						 	';} 
						elseif ($field_suffix == "last_updated"){
							echo $key .'=NOW())
							
						 	';}
						 else {
						 	echo $key .'=\'".mysqli_real_escape_string($dm->connection, $this->get_' . $val . '())."\'
							
						 	';
						}				 
					}
				} 
 				$row_num = 0;				
				?>WHERE <?php echo $index_name ?>=".mysqli_real_escape_string($dm->connection, $this->get_id());

				}		
				
				
			$result = $dm->updateRecords($strSQL);

			// if this is a new record get the record id from the database
			if(!$this->get_id() >= "0") {
				$this->set_id(mysqli_insert_id($dm->connection));
			}
			
          	if (!$result):
      			throw new Exception("Failed Query: ". $strSQL);
   			endif;
      
			// fetch data from the db to update object properties      
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
		//	require_once($class_folder . '/class_data_manager.php');
			$dm = new DataManager();

			$strSQL = "DELETE FROM <?php echo $selected_table ?> WHERE <?php echo $index_name ?>=" . $id;
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

	// function to fetch the record and populate the object
	public function get_by_id($id) {
		try{
		//	require_once($class_folder . '/class_data_manager.php');
			$status = false;
			$dm = new DataManager();
			$strSQL = "SELECT * FROM <?php echo $selected_table ?> WHERE <?php echo $index_name ?>=" . $id;
      
			$result = $dm->queryRecords($strSQL);
			$num_rows = mysqli_num_rows($result);

			if ($num_rows != 0){
				$row = mysqli_fetch_assoc($result);
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
			if ($key == $index_name) {
				echo '$this->set_id($row["' .$key .'"]);
				';			
			} else {
				echo '$this->set_' . $val .'($row["' .$key .'"]);
				';
			}
  			} 
	?>
  }
}