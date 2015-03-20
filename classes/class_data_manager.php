<?php
//**************************************************************************************
//  Class: DataManager
//	Description: The DataManager class will act as a proxy to the database, and will
//								contain basic APIs for the application to use.
//**************************************************************************************
class DataManager {

	//*******************************
	// class variables
	//*******************************
	private $dbhost        = '';
	private $dbuser        = '';
	private $dbpass        = '';
	private $dbname        = '';
	private $connection = "";
	private $lastInsertedId = 0;

	
	//*******************************
	// constructor
	//*******************************
	function __construct($dbhost,$dbuser,$dbpass,$dbname) {
		try {
			//Load all of the variable data from the config file
			//require($_SERVER['DOCUMENT_ROOT'] . '/includes/config_db.php');
			$this->dbhost = $dbhost;
			$this->dbuser = $dbuser;
			$this->dbpass = $dbpass;
			$this->dbname = $dbname;
			
			$this->connection = mysql_pconnect($this->dbhost, $this->dbuser, $this->dbpass);
			if ($this->connection == false){
				mail("jordan@orchardcity.ca","notice","failed connection");
				throw new Exception("Class: DataManager - Method: __construct - mysql_connect failed.");
			}
			if (mysql_select_db($this->dbname) == false){
				$msg = "failed database name " . $this->dbname;
				mail("jordan@orchardcity.ca","notice",$msg);

				throw new Exception("Class: DataManager - Method: __construct - mysql_select_db failed.");
			}
		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			require__once('class_error_handler.php');
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
				mail("jordan@orchardcity.ca","Failed Query",$sql . mysql_error());
			}			
			return $result;
		}
		catch(Exception $e) {
			//throw new Exception('Class: DataManager - Method: queryRecords - File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Reason: '. $e->getMessage());
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
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
				mail("jordan@orchardcity.ca","Failed Query",$sql . mysql_error());
			}
			if($result != false) {			
				return true;
			}
			return false;
		}
		catch(Exception $e) {
				mail("jordan@orchardcity.ca","Failed Query",$e->getMessage());
		
			//throw new Exception('Class: DataManager - Method: updateRecords - File: ' . $e->getFile() . 'Line: ' . $e->getLine() . 'Reason: '. $e->getMessage());
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			require__once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;			
		}
	}
	
	public function getConnection() {
		//Function is used by the record pager at least temporarily until rewritten
		return $this->connection;
	}
	
	public function setConVars(){

	}
	
	public function getLastInsertedId() {
		return mysql_insert_id($this->connection);
	}
	
}
?>
