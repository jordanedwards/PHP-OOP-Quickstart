<?php
//***********************************************************************************************
//  Class: ErrorHandler
//	Description: The ErrorHandler class handles all unexpected errors
//***********************************************************************************************
class ErrorHandler {

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
	// Sends an email to the MrRental Admins and forwards the user to a generic error page
	//****************************************************************************************	
	public function notifyAdminException(Exception $e){

			$_SESSION['alert_msg'] = "An unexpected system error has occurred. The administrators have been notified. We applogize for any inconvenience.";	
			$_SESSION['alert_color'] = "red";
			header("location: /index.php");		
			exit;
	}
}

?>