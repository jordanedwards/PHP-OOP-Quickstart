<?php 
// import necessary classes here


//*****************************************************************************************************
//  Class: SessionUtils
//	Description: This class handles all session interaction and makes this application more manageable.
//*****************************************************************************************************
class SessionManager {

	//*******************************
	// class variables
	//*******************************
	
	
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
	public function getAlertMessage() { return isset($_SESSION["alert_msg"])?$_SESSION["alert_msg"]:""; }
	public function setAlertMessage($value) { $_SESSION["alert_msg"] = $value; }
	
	public function getAlertColor() { return isset($_SESSION["alert_color"])?$_SESSION["alert_color"]:""; }
	public function setAlertColor($value) { $_SESSION["alert_color"] = $value; }

	public function get_user_id() { return isset($_SESSION["user_id"])?$_SESSION["user_id"]:""; }
	public function set_user_id($value) { $_SESSION["user_id"] = $value; }

	public function get_user_role() { return isset($_SESSION["user_role"])?$_SESSION["user_role"]:""; }
	public function set_user_role($value) { $_SESSION["user_role"] = $value; }
	
	public function getQuery($page) { return isset($_SESSION[$page]['query']) ? $_SESSION[$page]['query'] : null; }
	public function setQuery($page,$value) { $_SESSION[$page]['query'] = $value; }

	public function getSort($page) { return isset($_SESSION[$page]['sort']) ? $_SESSION[$page]['sort'] : null; }
	public function setSort($page,$value) { $_SESSION[$page]['sort'] = $value; }

	public function getSortDir($page) { return isset($_SESSION[$page]['sortdir']) ? $_SESSION[$page]['sortdir'] : null; }
	public function setSortDir($page,$value) { $_SESSION[$page]['sortdir'] = $value; }
	
	public function getPage() { return isset($_SESSION['page']) ? $_SESSION['page'] : null; }
	public function setPage($value) { $_SESSION['page'] = $value; }


	public function logout() {
		session_unset();
		session_destroy();
	}
}
?>