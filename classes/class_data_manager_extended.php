<?php
//**************************************************************************************
//  Class: DataManager
//	Description: The DataManager class will act as a proxy to the database, and will
//								contain basic APIs for the application to use.
//**************************************************************************************

class DataManager extends Project{

	//*******************************
	// class variables
	//*******************************
	private $connection = "";
	private $lastInsertedId = 0;

	
	//*******************************
	// constructor
	//*******************************
	function __construct() {
		
	}

	public function setConnection(){
	try {
			//Load all of the variable data from the config file
			
			$this->connection = mysql_pconnect($this->get_dbhost(), $this->get_dbuser(), $this->get_dbpass());
			if ($this->connection == false){
				//mail("jordan@orchardcity.ca","notice","failed connection");
				//throw new Exception("Class: DataManager - Method: __construct - mysql_connect failed.");
			}
			if (mysql_select_db($this->get_dbname()) == false){
				$msg = "failed database name " . $this->get_dbname();
				//mail("jordan@orchardcity.ca","notice",$msg);
				//throw new Exception("Class: DataManager - Method: __construct - mysql_select_db failed.");
			}
			if ($this->connection == true){
				return true;
			}
			
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once('class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;		
		}
	
	}
	//*******************************
	// Methods/Functions
	//*******************************
	public function queryRecords($sql) {
		try {
			$result = mysql_query($sql,$this->connection);
			if (!result){
				//mail("jordan@orchardcity.ca","Failed Query",$sql . mysql_error());
			}			
			return $result;
		}
		catch(Exception $e) {
			//throw new Exception('Class: DataManager - Method: queryRecords - File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Reason: '. $e->getMessage());
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;					
		}
	}
	
	public function updateRecords($sql) {
		try {
			$result = mysql_query($sql,$this->connection);
			// check for a successful update - if successful return true, otherwise return false
			if (!result){
				//mail("jordan@orchardcity.ca","Failed Query",$sql . mysql_error());
			}
			if($result != false) {			
				return true;
			}
			return false;
		}
		catch(Exception $e) {
				//mail("jordan@orchardcity.ca","Failed Query",$e->getMessage());
		
			//throw new Exception('Class: DataManager - Method: updateRecords - File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Reason: '. $e->getMessage());
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;			
		}
	}
	
	public function getConnection() {
		//Function is used by the record pager at least temporarily until rewritten
		return $this->connection;
	}
	
	
}
?>
