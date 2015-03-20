<?php

//***********************************************************************************************
//  Class: user
//	Description: The user class holds all of the user information along with get/set functions
//***********************************************************************************************
class User {

	//*******************************
	// class variables
	//*******************************
	private $id = 0;
	private $first_name;
	private $last_name;
	private $email;
	private $password;
	private $login;
	private $role;
	private $tel;
	private $date_created;
	private $last_updated;
	private $last_updated_user;

	//*******************************
	// constructor
	//*******************************
	function __construct() {
		/*******************************************************************************************************
		********************************************************************************************************/

	}

	//****************************************************************************************
	// Getter and Setter Methods
	//****************************************************************************************
	public function get_id() { return $this->id; }
	public function set_id($value) { $this->id = $value; }

	public function get_first_name() { return $this->first_name; }
	public function set_first_name($value) { $this->first_name = $value; }

//	public function tt_count() { return $this->first_name; }
//	public function set_tt_count($value) { $this->first_name = $value; }

	public function get_last_name() { return $this->last_name; }
	public function set_last_name($value) { $this->last_name = $value; }

	public function get_email() { return $this->email; }
	public function set_email($value) { $this->email = $value; }

	public function get_tel() { return $this->tel; }
	public function set_tel($value) { $this->tel = $value; }
		
	public function get_password() { return $this->password; }
	public function set_password($value, $hashed = false) { require($_SERVER['DOCUMENT_ROOT'] . '/includes/config_secure.php'); $this->password = ($hashed ? $value : hash("sha256", trim($value) . $appConfig["salt"])); }

	public function get_login() { return $this->login; }
	public function set_login($value) { $this->login = $value; }

	public function get_role() { return $this->role; }
	public function set_role($value) { $this->role = $value; }
	
	public function get_date_created() { return $this->date_created; }
	private function set_date_created($value) { $this->date_created = $value; }
	
	public function get_last_updated() { return $this->last_updated; }
	private function set_last_updated($value) { $this->last_updated = $value; }
	
	public function get_last_updated_user() { return $this->last_updated_user; }
	public function set_last_updated_user($value) { $this->last_updated_user = $value; }
	

	//****************************************************************************************
	// login function: checks the login information and returns true if it's valid
	//****************************************************************************************
	public function login() {

		try{
		//	require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();
			$strSQL = "SELECT user_id, user_role FROM user WHERE user_email='" . $this->get_email() . "' AND user_password='" . $this->get_password() . "'";
			//echo $strSQL; exit;
			$result = $dm->queryRecords($strSQL);
			$num_rows = mysqli_num_rows($result);

			if ($num_rows != 0){
				$row = mysqli_fetch_assoc($result);
				$this->set_role($row["user_role"]);
				return $row["user_id"];
			}else{
				return "";
				exit;
			}

		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}

	public function update_last_login($id) {
		
		try{
		//	require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();
			$strSQL = "UPDATE user SET user_login = NOW() WHERE user_id=".$id;
			$dm->updateRecords($strSQL);
			return "";

		}
		catch(Exception $e) {
			// CATCH EXCEPTION HERE -- DISPLAY ERROR MESSAGE & EMAIL ADMINISTRATOR
			include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_error_handler.php');
			$errorVar = new ErrorHandler();
			$errorVar->notifyAdminException($e);
			exit;
		}
	}



	// function for inserting/updating user info
	public function save() {

		try{
			//require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();

			if($this->get_id() == "0") {

				// verify that there is not an user with the same email

				$strSQL = "INSERT INTO user (user_first_name, user_last_name, user_tel, user_email, user_password, user_login, user_role, user_date_created, user_last_updated, user_last_updated_user) VALUES ('".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_first_name())."' ,'".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_last_name())."' ,'".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_tel())."','".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_email())."' ,'". mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_password()) ."', NOW(),".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_role()).",NOW(),NOW(),'".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_last_updated_user())."')";

			}
			else {
				$strSQL = "UPDATE user SET user_first_name= '".mysqli_real_escape_string($dm->connection, $dm->connection, $this->get_first_name())."',user_last_name= '".mysqli_real_escape_string($dm->connection, $this->get_last_name())."',user_tel= '".mysqli_real_escape_string($dm->connection, $this->get_tel())."', user_email= '".mysqli_real_escape_string($dm->connection, $this->get_email())."', user_password = '".mysqli_real_escape_string($dm->connection, $this->get_password())."', user_role = ".mysqli_real_escape_string($dm->connection, $this->get_role()).", user_last_updated=NOW(), user_last_updated_user='".mysqli_real_escape_string($dm->connection, $this->get_last_updated_user())."' WHERE user_id=".mysqli_real_escape_string($dm->connection, $this->get_id());
			}

			$result = $dm->updateRecords($strSQL);

			// if this is a new user get the user_id from the database
			if($this->get_id() == "0") {
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

	// function to delete the user info
	public function delete_by_id($id) {
		try{
			require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$dm = new DataManager();

			$strSQL = "DELETE FROM user WHERE user_id=" . $id;
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

	// function that fill the user object with user information
	public function get_by_id($id) {
		try{
		//	require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$status = false;
			$dm = new DataManager();
			$strSQL = "SELECT * FROM user WHERE user_id=" . $id;
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

	// function that fill the user object with user information
	public function get_by_email($email) {
		try{
		//	require_once($_SERVER['DOCUMENT_ROOT'] . '/classes/class_data_manager.php');
			$status = false;
			$dm = new DataManager();
			$strSQL = "SELECT * FROM user WHERE user_email='" . $email."'";
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
    $this->set_id($row["user_id"]);
    $this->set_first_name($row["user_first_name"]);
    $this->set_last_name($row["user_last_name"]);
    $this->set_tel($row["user_tel"]);	
    $this->set_email($row["user_email"]);
    $this->set_password($row['user_password'], true);
    $this->set_login($row['user_login']);
    $this->set_role($row['user_role']);
    $this->set_date_created($row['user_date_created']);
    $this->set_last_updated($row['user_last_updated']);
    $this->set_last_updated_user($row['user_last_updated_user']);
  }

    public function get_random_password($length) {
        $chars = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ23456789-=+#$@"; // 60 chars
        $pass = '' ;
        while ($length-- > 0) $pass .= substr($chars, rand(0, 59), 1);
        return $pass;
    }

}

